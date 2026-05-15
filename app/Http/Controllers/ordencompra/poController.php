<?php

namespace App\Http\Controllers\ordencompra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;

use DB;

use App\Models\ordencompra\poModel;
use App\Models\ordencompra\PoCorreoEnviado;

use App\Models\HojaTrabajo;

use App\Models\proveedor\altaproveedorModel;
use App\Models\proveedor\proveedortempModel;



class poController extends Controller
{



    public function index()
    {
        $proveedoresOficiales = altaproveedorModel::select('RAZON_SOCIAL_ALTA', 'RFC_ALTA')->get();
        $proveedoresTemporales = proveedortempModel::select('RAZON_PROVEEDORTEMP', 'RFC_PROVEEDORTEMP', 'NOMBRE_PROVEEDORTEMP')->get();

        return view('compras.ordencompra.ordencompra', compact('proveedoresOficiales', 'proveedoresTemporales'));
    }

    public function index1()
    {
        $proveedoresOficiales = altaproveedorModel::select('RAZON_SOCIAL_ALTA', 'RFC_ALTA')->get();
        $proveedoresTemporales = proveedortempModel::select('RAZON_PROVEEDORTEMP', 'RFC_PROVEEDORTEMP', 'NOMBRE_PROVEEDORTEMP')->get();

        return view('compras.ordencompra.aprobacionorden', compact('proveedoresOficiales', 'proveedoresTemporales'));
    }





    public function Tablaordencompra()
    {
        try {

            $fechaInicio = Carbon::now('America/Mexico_City')->startOfYear()->toDateString();
            $fechaFin    = Carbon::now('America/Mexico_City')->endOfYear()->toDateString();


            $tabla = DB::table('formulario_ordencompra as po')
                ->leftJoin('formulario_altaproveedor as p', 'po.PROVEEDOR_SELECCIONADO', '=', 'p.RFC_ALTA')

                ->where(function ($q) use ($fechaInicio, $fechaFin) {

                    $q->whereBetween('po.FECHA_EMISION', [$fechaInicio, $fechaFin])

                        ->orWhere(function ($x) use ($fechaInicio, $fechaFin) {
                            $x->whereNotBetween('po.FECHA_EMISION', [$fechaInicio, $fechaFin])
                                ->where(function ($y) {
                                    $y->whereNull('po.ESTADO_APROBACION')
                                        ->orWhereNotIn('po.ESTADO_APROBACION', ['Aprobada', 'Rechazada']);
                                });
                        })

                        ->orWhereNull('po.FECHA_EMISION')
                        ->orWhere('po.FECHA_EMISION', '');
                })


                ->whereIn('po.ID_FORMULARIO_PO', function ($query) {
                    $query->select(DB::raw('MAX(ID_FORMULARIO_PO)'))
                        ->from('formulario_ordencompra')
                        ->groupBy(DB::raw("SUBSTRING_INDEX(NO_PO, '-Rev', 1)"));
                })

                ->select(
                    'po.*',
                    DB::raw("CONCAT(p.RAZON_SOCIAL_ALTA, ' (', p.RFC_ALTA, ')') as PROVEEDORES")
                )

                ->orderByRaw("
                CAST(
                    SUBSTRING_INDEX(
                        SUBSTRING_INDEX(po.NO_PO, '-', -1),
                        '-Rev', 1
                    ) AS UNSIGNED
                )
            ")

                ->get();


            foreach ($tabla as $value) {


                if ($value->CANCELACION_PO == 1) {

                    $value->ESTADO_BADGE = '<span class="badge bg-danger">Cancelada</span>';
                } elseif ($value->ESTADO_APROBACION == 'Aprobada') {

                    $value->ESTADO_BADGE = '<span class="badge bg-success">Aprobado</span>';
                } elseif ($value->ESTADO_APROBACION == 'Rechazada') {

                    $value->ESTADO_BADGE = '<span class="badge bg-danger">Rechazado</span>';
                } elseif ($value->SOLICITAR_AUTORIZACION == 'Sí') {

                    $value->ESTADO_BADGE = '<span class="badge bg-warning text-dark">En revisión</span>';
                } else {

                    $value->ESTADO_BADGE = '<span class="badge bg-secondary">Sin estatus</span>';
                }


                if ($value->ESTADO_APROBACION == 'Aprobada') {

                    $value->DESCARGA_PO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button " data-id="' . $value->ID_FORMULARIO_PO . '" title="Descargar"><i class="bi bi-filetype-pdf"></i></button>';

                    $value->CORREO_AVISO = '<button type="button" class="btn btn-info btn-custom rounded-pill ENVIAR_CORREO" data-id="' . $value->ID_FORMULARIO_PO . '"><i class="bi bi-envelope-paper-fill"></i></button>';
                } elseif ($value->ESTADO_APROBACION == 'Rechazada') {

                    $value->DESCARGA_PO = '<button class="btn btn-danger rounded-pill" disabled><i class="bi bi-filetype-pdf"></i></button>';
                    $value->CORREO_AVISO = '<button class="btn btn-info rounded-pill" disabled><i class="bi bi-envelope-paper-fill"></i></button>';
                } else {

                    $value->DESCARGA_PO = '<button class="btn btn-danger rounded-pill" disabled><i class="bi bi-filetype-pdf"></button>';
                    $value->CORREO_AVISO = '<button class="btn btn-info rounded-pill" disabled><i class="bi bi-envelope-paper-fill"></i></button>';
                }


                
                
                if ($value->CANCELACION_PO == 1) {
                    $value->BTN_EDITAR = '<button class="btn btn-secondary rounded-pill" disabled><i class="bi bi-ban"></i></button>';
                    $value->DESCARGA_PO = '<button class="btn btn-danger rounded-pill" disabled><i class="bi bi-filetype-pdf"></i></button>';
                    $value->CORREO_AVISO = '<button class="btn btn-info rounded-pill" disabled><i class="bi bi-envelope-paper-fill"></i></button>';
                } else {
                    $value->BTN_EDITAR = '<button class="btn btn-warning rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                }

                $value->BTN_VISUALIZAR = '<button class="btn btn-primary rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';


              


                $basePO = preg_replace('/-Rev\d+$/', '', $value->NO_PO);

                $revisiones = poModel::where(function ($q) use ($basePO) {
                    $q->where('NO_PO', $basePO)
                        ->orWhere('NO_PO', 'like', "$basePO-Rev%");
                })
                    ->where('ID_FORMULARIO_PO', '<', $value->ID_FORMULARIO_PO)
                    ->orderBy('ID_FORMULARIO_PO')
                    ->get();

                foreach ($revisiones as $rev) {
                    $rev->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR" data-id="' . $rev->ID_FORMULARIO_PO . '"><i class="bi bi-pencil-square"></i></button>';
                }

                $value->REVISIONES = $revisiones;
            }

            return response()->json([
                'data' => $tabla,
                'msj' => 'Últimas órdenes cargadas'
            ]);
        } catch (\Exception $e) {
            return response()->json(['data' => [], 'msj' => 'Error: ' . $e->getMessage()]);
        }
    }




 

    public function Tablaordencompraprobacion()
    {
        try {
            

            $ultimasPO = DB::table('formulario_ordencompra')
                ->select(DB::raw('MAX(ID_FORMULARIO_PO) as ID_FORMULARIO_PO'))
                ->groupBy(DB::raw("SUBSTRING_INDEX(NO_PO, '-Rev', 1)"));

            $tabla = DB::table('formulario_ordencompra as po')
                ->leftJoin('formulario_altaproveedor as p', 'po.PROVEEDOR_SELECCIONADO', '=', 'p.RFC_ALTA')
                ->whereIn('po.ID_FORMULARIO_PO', $ultimasPO)
                ->where('po.SOLICITAR_AUTORIZACION', 'Sí')
                ->where(function ($query) {
                    $query->whereNull('po.ESTADO_APROBACION')
                        ->orWhereNotIn('po.ESTADO_APROBACION', ['Aprobada', 'Rechazada']);
                })
                ->select(
                    'po.*',
                    DB::raw("CONCAT(p.RAZON_SOCIAL_ALTA, ' (', p.RFC_ALTA, ')') as PROVEEDORES")
                )
                ->orderByRaw("CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(po.NO_PO, '-', -1), '-Rev', 1) AS UNSIGNED)")
                ->get();

                
            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }

                if ($value->SOLICITAR_AUTORIZACION == 'Sí') {
                    $value->ESTADO_REVISION = '<span class="badge bg-warning text-dark">En revisión</span>';
                } elseif ($value->DAR_BUENO == 1) {
                    $value->ESTADO_REVISION = '<span class="badge bg-success">✔</span>';
                } elseif ($value->DAR_BUENO == 2) {
                    $value->ESTADO_REVISION = '<span class="badge bg-danger">✖</span>';
                } else {
                    $value->ESTADO_REVISION = '<span class="badge bg-secondary">Sin estado</span>';
                }

                if ($value->ESTADO_APROBACION == 'Aprobada') {
                    $value->ESTATUS = '<span class="badge bg-success">Aprobado</span>';
                } elseif ($value->ESTADO_APROBACION == 'Rechazada') {
                    $value->ESTATUS = '<span class="badge bg-danger">Rechazado</span>';
                } else {
                    $value->ESTATUS = '<span class="badge bg-secondary">Aprobar</span>';
                }

                $basePO = preg_replace('/-Rev\d+$/', '', $value->NO_PO);

                $revisiones = poModel::where(function ($q) use ($basePO) {
                    $q->where('NO_PO', $basePO)
                        ->orWhere('NO_PO', 'like', "$basePO-Rev%");
                })
                    ->where('ID_FORMULARIO_PO', '<', $value->ID_FORMULARIO_PO)
                    ->orderBy('ID_FORMULARIO_PO')
                    ->get();

                foreach ($revisiones as $rev) {
                    $rev->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR" data-id="' . $rev->ID_FORMULARIO_PO . '"><i class="bi bi-pencil-square"></i></button>';
                }

                $value->REVISIONES = $revisiones;
            }

            return response()->json([
                'data' => $tabla,
                'msj' => 'Órdenes en revisión cargadas correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'msj' => 'Error: ' . $e->getMessage(),
                'data' => []
            ]);
        }
    }





    public function obtenerNombreUsuario($id)
    {
        $usuario = DB::table('usuarios')
            ->select('EMPLEADO_NOMBRE', 'EMPLEADO_APELLIDOPATERNO', 'EMPLEADO_APELLIDOMATERNO')
            ->where('ID_USUARIO', $id)
            ->first();

        if ($usuario) {
            $nombreCompleto = trim("{$usuario->EMPLEADO_NOMBRE} {$usuario->EMPLEADO_APELLIDOPATERNO} {$usuario->EMPLEADO_APELLIDOMATERNO}");
            return response()->json(['nombre_completo' => $nombreCompleto]);
        } else {
            return response()->json(['nombre_completo' => ''], 404);
        }
    }





    public function store(Request $request)
    {
        try {
            switch (intval($request->api)) {

                case 1:
                    if ($request->ID_FORMULARIO_PO == 0) {
                        DB::statement('ALTER TABLE formulario_ordencompra AUTO_INCREMENT=1;');

                        if ($request->SOLICITAR_AUTORIZACION === 'Sí') {
                            $request->merge(['USUARIO_ID' => auth()->user()->ID_USUARIO]);
                        }

                        $data = $request->except(['servicios']);

                        $compras = poModel::create($data);
                        $response['code']  = 1;
                        $response['compra'] = $compras;
                        return response()->json($response);
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $compras = poModel::where('ID_FORMULARIO_PO', $request['ID_FORMULARIO_PO'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['compra'] = 'Desactivada';
                            } else {
                                $compras = poModel::where('ID_FORMULARIO_PO', $request['ID_FORMULARIO_PO'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['compra'] = 'Activada';
                            }
                        } else {
                            $compras = poModel::find($request->ID_FORMULARIO_PO);

                            if ($request->SOLICITAR_AUTORIZACION === 'Sí' && !$compras->USUARIO_ID) {
                                $request->merge(['USUARIO_ID' => auth()->user()->ID_USUARIO]);
                            }

                            $compras->update($request->all());
                            $response['code'] = 1;
                            $response['compra'] = 'Actualizada';
                        }

                        return response()->json($response);
                    }

                    break;

                case 2:
                    if ($request->ID_FORMULARIO_PO == 0) {
                        DB::statement('ALTER TABLE formulario_ordencompra AUTO_INCREMENT=1;');

                        $data = $request->except(['servicios']);

                        $compras = poModel::create($data);

                        $response['code']  = 1;
                        $response['compra']  = $compras;
                        return response()->json($response);
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $compras = poModel::where('ID_FORMULARIO_PO', $request['ID_FORMULARIO_PO'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['compra'] = 'Desactivada';
                            } else {
                                $compras = poModel::where('ID_FORMULARIO_PO', $request['ID_FORMULARIO_PO'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['compra'] = 'Activada';
                            }
                        } else {
                            $compras = poModel::find($request->ID_FORMULARIO_PO);

                            if (
                                in_array($request->ESTADO_APROBACION, ['Aprobada', 'Rechazada']) &&
                                empty($compras->APROBO_ID)
                            ) {
                                $compras->APROBO_ID = auth()->user()->ID_USUARIO;
                            }

                            $compras->update($request->all());

                            $response['code'] = 1;
                            $response['compra'] = 'Actualizada';
                        }

                        return response()->json($response);
                    }

                    break;


                case 3:
                    $ofertaOriginal = poModel::find($request->ID_FORMULARIO_PO);

                    if ($ofertaOriginal) {
                        $noOfertaBase = explode('-Rev', $ofertaOriginal->NO_PO)[0];

                        $ultimaRevision = poModel::where('NO_PO', 'LIKE', "$noOfertaBase%")
                            ->orderBy('REVISION_PO', 'desc')
                            ->first();

                        $revisionNumero = $ultimaRevision ? $ultimaRevision->REVISION_PO + 1 : 1;
                        $noOfertaConRevision = $noOfertaBase . '-Rev' . $revisionNumero;

                        $nuevaOferta = $ofertaOriginal->replicate();

                        $nuevaOferta->NO_PO = $noOfertaConRevision;
                        $nuevaOferta->REVISION_PO = $revisionNumero;
                        $nuevaOferta->MOTIVO_REVISION_PO = $request->MOTIVO_REVISION_PO;

                        $nuevaOferta->SOLICITAR_AUTORIZACION = null;
                        $nuevaOferta->USUARIO_ID = null;
                        $nuevaOferta->REQUIERE_COMENTARIO = null;
                        $nuevaOferta->COMENTARIO_SOLICITUD = null;
                        $nuevaOferta->ESTADO_APROBACION = null;
                        $nuevaOferta->FECHA_APROBACION = null;
                        $nuevaOferta->MOTIVO_RECHAZO = null;
                        $nuevaOferta->APROBO_ID = null;
                        $nuevaOferta->FECHA_SOLCITIUD = null;

                        $nuevaOferta->save();

                        $response['code'] = 1;
                        $response['compra'] = $nuevaOferta;
                    } else {
                        $response['code'] = 0;
                        $response['message'] = 'PO no encontrada';
                    }

                    return response()->json($response);
                    break;

                case 4:
                    $po = poModel::find($request->ID_FORMULARIO_PO);

                    if ($po) {

                        $po->CANCELACION_PO = 1;
                        $po->MOTIVO_CANCELACION = $request->MOTIVO_CANCELACION_PO; 
                        $po->CANCELO_ID = auth()->user()->ID_USUARIO;
                        $po->FECHA_CANCELACION_PO = now();

                        $po->save();

                        $response['code'] = 1;
                        $response['compra'] = $po;
                    } else {
                        $response['code'] = 0;
                        $response['message'] = 'PO no encontrada';
                    }

                    return response()->json($response);
                    break;



                default:
                    $response['code']  = 1;
                    $response['msj']  = 'Api no encontrada';
                    return response()->json($response);
            }
        } catch (Exception $e) {
            return response()->json('Error al guardar');
        }
    }

    
}