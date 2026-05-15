<?php

namespace App\Http\Controllers\matrizcomparativa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

use DB;


use App\Models\matrizcomparativa\matrizModel;


use App\Models\proveedor\altaproveedorModel;
use App\Models\proveedor\proveedortempModel;

class matrizController extends Controller
{



    public function index()
    {
        $proveedoresOficiales = altaproveedorModel::select('RAZON_SOCIAL_ALTA', 'RFC_ALTA')->get();
        $proveedoresTemporales = proveedortempModel::select('RAZON_PROVEEDORTEMP', 'RFC_PROVEEDORTEMP', 'NOMBRE_PROVEEDORTEMP')->get();

        return view('compras.matrizcomparativa.matrizcomparativa', compact('proveedoresOficiales', 'proveedoresTemporales'));

    }



    public function index1()
    {
        $proveedoresOficiales = altaproveedorModel::select('RAZON_SOCIAL_ALTA', 'RFC_ALTA')->get();
        $proveedoresTemporales = proveedortempModel::select('RAZON_PROVEEDORTEMP', 'RFC_PROVEEDORTEMP', 'NOMBRE_PROVEEDORTEMP')->get();

        return view('compras.ordencompra.aprobacionmatriz', compact('proveedoresOficiales', 'proveedoresTemporales'));
    }


    public function Tablamatrizcomparativa()
    {
        try {
            $tabla = matrizModel::get();

            foreach ($tabla as $value) {
                if ($value->ESTADO_APROBACION == 'Aprobada') {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }

                if ($value->ESTADO_APROBACION == 'Aprobada') {
                    $value->ESTADO_BADGE = '<span class="badge bg-success">Aprobado</span>';
                } elseif ($value->ESTADO_APROBACION == 'Rechazada') {
                    $value->ESTADO_BADGE = '<span class="badge bg-danger">Rechazado</span>';
                } elseif ($value->SOLICITAR_VERIFICACION == 'Sí') {
                    $value->ESTADO_BADGE = '<span class="badge bg-warning text-dark">En revisión</span>';
                } else {
                    $value->ESTADO_BADGE = '<span class="badge bg-secondary">Sin estatus</span>'; 
                }
            }

            return response()->json([
                'data' => $tabla,
                'msj' => 'Información consultada correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'msj' => 'Error ' . $e->getMessage(),
                'data' => 0
            ]);
        }
    }


    //// APROBACION DE MATRIz

    public function Tablamatirzaprobada()
    {
        try {
            $tabla = matrizModel::where('SOLICITAR_VERIFICACION', 'Sí')
                ->where(function ($query) {
                    $query->whereNull('ESTADO_APROBACION')
                        ->orWhereNotIn('ESTADO_APROBACION', ['Aprobada', 'Rechazada']);
                })
              
                ->get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }

                if ($value->SOLICITAR_VERIFICACION == 'Sí') {
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
            }

            return response()->json([
                'data' => $tabla,
                'msj' => 'Información consultada correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'msj' => 'Error ' . $e->getMessage(),
                'data' => 0
            ]);
        }
    }



    public function store(Request $request)
    {
        try {
            switch (intval($request->api)) {
                case 1:
                    if ($request->ID_FORMULARIO_MATRIZ == 0) {
                        DB::statement('ALTER TABLE formulario_matrizcomparativa AUTO_INCREMENT=1;');
                        $matrizes = matrizModel::create($request->all());
                    } else {

                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $matrizes = matrizModel::where('ID_FORMULARIO_MATRIZ', $request['ID_FORMULARIO_MATRIZ'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['matriz'] = 'Desactivada';
                            } else {
                                $matrizes = matrizModel::where('ID_FORMULARIO_MATRIZ', $request['ID_FORMULARIO_MATRIZ'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['matriz'] = 'Activada';
                            }
                        } else {
                            $matrizes = matrizModel::find($request->ID_FORMULARIO_MATRIZ);
                            $matrizes->update($request->all());
                            $response['code'] = 1;
                            $response['matriz'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['matriz']  = $matrizes;
                    return response()->json($response);
                    break;

                case 2:
                    if ($request->ID_FORMULARIO_MATRIZ == 0) {
                        DB::statement('ALTER TABLE formulario_matrizcomparativa AUTO_INCREMENT=1;');
                        $matrizes = matrizModel::create($request->all());
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                matrizModel::where('ID_FORMULARIO_MATRIZ', $request['ID_FORMULARIO_MATRIZ'])->update(['ACTIVO' => 0]);
                                return response()->json(['code' => 1, 'matriz' => 'Desactivada']);
                            } else {
                                matrizModel::where('ID_FORMULARIO_MATRIZ', $request['ID_FORMULARIO_MATRIZ'])->update(['ACTIVO' => 1]);
                                return response()->json(['code' => 1, 'matriz' => 'Activada']);
                            }
                        } else {
                            $matrizes = matrizModel::find($request->ID_FORMULARIO_MATRIZ);
                            $matrizes->update($request->all());
                        }
                    }

                    $hojas = json_decode($matrizes->HOJA_ID, true);

                    if (is_array($hojas)) {
                        foreach ($hojas as $hojaId) {
                            DB::table('hoja_trabajo')
                                ->where('id', $hojaId)
                                ->update([
                                    'ESTADO_APROBACION'      => $request->ESTADO_APROBACION,
                                    'FECHA_APROBACION'       => $request->FECHA_APROBACION,
                                    'MOTIVO_RECHAZO'         => $request->MOTIVO_RECHAZO,
                                    'REQUIERE_PO'            => $request->REQUIERE_PO,
                                    'PROVEEDOR_SELECCIONADO' => $request->PROVEEDOR_SELECCIONADO,
                                    'MONTO_FINAL'            => $request->MONTO_FINAL,
                                    'FORMA_PAGO'             => $request->FORMA_PAGO,
                                    'REQUIERE_MATRIZ'        => 'No',
                                    'APROBADO_ID'            => auth()->user()->ID_USUARIO,
                                ]);
                        }
                    }

                    if ($request->REQUIERE_PO === 'Sí' && is_array($hojas)) {
                        $existe = DB::table('formulario_ordencompra')->where('HOJA_ID', json_encode($hojas))->first();

                        if (!$existe) {
                            $año = now()->format('y');
                            $ultimo = DB::table('formulario_ordencompra')
                                ->where('NO_PO', 'like', "RES-PO$año-%")
                                ->orderByDesc('ID_FORMULARIO_PO')
                                ->value('NO_PO');

                            $consecutivo = $ultimo ? (int)substr($ultimo, -3) + 1 : 1;
                            $numeroOrden = sprintf("RES-PO%s-%03d", $año, $consecutivo);

                            $proveedor = $request->PROVEEDOR_SELECCIONADO;
                            $materialesJson = null;
                            $subtotal = null;
                            $iva = null;
                            $importe = null;

                            if ($proveedor === $matrizes->PROVEEDOR1) {
                                $materialesJson = $matrizes->MATERIALES_JSON_PROVEEDOR1;
                                $subtotal = $matrizes->SUBTOTAL_PROVEEDOR1;
                                $iva = $matrizes->IVA_PROVEEDOR1;
                                $importe = $matrizes->IMPORTE_PROVEEDOR1;
                            } elseif ($proveedor === $matrizes->PROVEEDOR2) {
                                $materialesJson = $matrizes->MATERIALES_JSON_PROVEEDOR2;
                                $subtotal = $matrizes->SUBTOTAL_PROVEEDOR2;
                                $iva = $matrizes->IVA_PROVEEDOR2;
                                $importe = $matrizes->IMPORTE_PROVEEDOR2;
                            } elseif ($proveedor === $matrizes->PROVEEDOR3) {
                                $materialesJson = $matrizes->MATERIALES_JSON_PROVEEDOR3;
                                $subtotal = $matrizes->SUBTOTAL_PROVEEDOR3;
                                $iva = $matrizes->IVA_PROVEEDOR3;
                                $importe = $matrizes->IMPORTE_PROVEEDOR3;
                            }

                            DB::table('formulario_ordencompra')->insert([
                                'NO_PO'                  => $numeroOrden,
                                'NO_MR'                  => $matrizes->NO_MR,
                                'HOJA_ID'                => json_encode($hojas), 
                                'MATERIALES_JSON'        => $materialesJson,
                                'PROVEEDOR_SELECCIONADO' => $proveedor,
                                'SUBTOTAL'               => $subtotal,
                                'IVA'                    => $iva,
                                'IMPORTE'                => $importe,
                                'created_at'             => now(),
                                'updated_at'             => now(),
                                'ACTIVO'                 => 1
                            ]);
                        }
                    }


                    return response()->json([
                        'code'   => 1,
                        'matriz' => $matrizes
                    ]);
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
