<?php

namespace App\Http\Controllers\ordentrabajo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;

use DB;

use App\Models\ofertas\ofertasModel;

use App\Models\ordentrabajo\otModel;
use App\Models\proveedor\catalogotituloproveedorModel;

class otController extends Controller
{
    public function index()
    {
        $ofertasJSON = DB::table('formulario_ordentrabajo')->pluck('OFERTA_ID');
        $ofertasUsadas = [];

        foreach ($ofertasJSON as $json) {
            $ids = json_decode($json, true);
            if (is_array($ids)) {
                $ofertasUsadas = array_merge($ofertasUsadas, $ids);
            }
        }

        $ofertasUsadas = array_unique($ofertasUsadas);

        $ofertasPermitidas = DB::table('formulario_ordentrabajo')
            ->where('UTILIZAR_COTIZACION', 1)
            ->pluck('OFERTA_ID')
            ->toArray();

        $ofertasPermitidasIds = [];
        foreach ($ofertasPermitidas as $json) {
            $ids = json_decode($json, true);
            if (is_array($ids)) {
                $ofertasPermitidasIds = array_merge($ofertasPermitidasIds, $ids);
            }
        }

       
        $idsParaMostrar = array_diff($ofertasUsadas, $ofertasPermitidasIds);
        $ofertasFinales = array_diff($ofertasUsadas, $idsParaMostrar); 

        $solicitudes = DB::table('formulario_confirmacion as fc')
            ->join('formulario_ofertas as fo', 'fc.OFERTA_ID', '=', 'fo.ID_FORMULARIO_OFERTAS')
            ->select('fo.ID_FORMULARIO_OFERTAS', 'fo.NO_OFERTA')
            ->where('fc.PROCEDE_ORDEN', 1)
            ->where(function ($query) use ($ofertasUsadas, $ofertasFinales) {
                $query->whereNotIn('fo.ID_FORMULARIO_OFERTAS', $ofertasUsadas)
                    ->orWhereIn('fo.ID_FORMULARIO_OFERTAS', $ofertasFinales);
            })
            ->get();


        $titulosCuenta = catalogotituloproveedorModel::where('ACTIVO', 1)->get();


        return view('ventas.orden_trabajo.orden_trabajo', compact('solicitudes', 'titulosCuenta'));
    }


    public function obtenerDatosOferta(Request $request)
    {
        $ofertaIds = $request->input('oferta_ids', []);

        $datos = DB::table('formulario_ofertas as fo')
            ->join('formulario_solicitudes as fs', 'fo.SOLICITUD_ID', '=', 'fs.ID_FORMULARIO_SOLICITUDES')
            ->join('catalogo_giroempresa as cg', 'fs.GIRO_EMPRESA_SOLICITUD', '=', 'cg.ID_CATALOGO_GIRO_EMPRESA')
            ->leftJoin('formulario_clientes as fc', 'fs.RFC_SOLICITUD', '=', 'fc.RFC_CLIENTE')
            ->select(
                'fs.RAZON_SOCIAL_SOLICITUD',
                'fs.NOMBRE_COMERCIAL_SOLICITUD',
                'fs.RFC_SOLICITUD',
                'cg.NOMBRE_GIRO as GIRO_EMPRESA',
                'fs.DIRECCION_SOLICITUDES', 
                'fc.CONTACTOS_JSON'
            )
            ->whereIn('fo.ID_FORMULARIO_OFERTAS', $ofertaIds)
            ->get();

       
        $razonesSociales = $datos->pluck('RAZON_SOCIAL_SOLICITUD')->unique()->values();
        $comerciales     = $datos->pluck('NOMBRE_COMERCIAL_SOLICITUD')->unique()->values();
        $rfcs            = $datos->pluck('RFC_SOLICITUD')->unique()->values();
        $giros           = $datos->pluck('GIRO_EMPRESA')->unique()->values();

      
        $direcciones = $datos
            ->pluck('DIRECCION_SOLICITUDES')
            ->filter(fn($dir) => !empty(trim($dir)))
            ->unique()
            ->values();

   
        $contactosNombres   = [];
        $contactosCompletos = [];

        foreach ($datos as $registro) {
            if ($registro->CONTACTOS_JSON) {
                $json = json_decode($registro->CONTACTOS_JSON, true);

                if (is_array($json)) {
                    foreach ($json as $contacto) {
                        $nombre = trim($contacto['CONTACTO_SOLICITUD'] ?? '');

                        if ($nombre === '') {
                            continue;
                        }

                        if (!in_array($nombre, $contactosNombres)) {
                            $contactosNombres[] = $nombre;
                        }

                        if (!isset($contactosCompletos[$nombre])) {
                            $contactosCompletos[$nombre] = [
                                'nombre'   => $nombre,
                                'titulo'   => $contacto['TITULO_CONTACTO_SOLICITUD'] ?? '',
                                'telefono' => $contacto['TELEFONO_SOLICITUD'] ?? '',
                                'celular'  => $contacto['CELULAR_SOLICITUD'] ?? '',
                                'correo'   => $contacto['CORREO_SOLICITUD'] ?? '',
                                'cargo'    => $contacto['CARGO_SOLICITUD'] ?? ''
                            ];
                        }
                    }
                }
            }
        }

        return response()->json([
            'razones'              => $razonesSociales,
            'comerciales'          => $comerciales,
            'rfcs'                 => $rfcs,
            'giros'                => $giros,
            'direcciones'          => $direcciones,
            'contactos'            => $contactosNombres,
            'contactos_completos'  => array_values($contactosCompletos)
        ]);
    }



    public function Tablaordentrabajo()
    {
        try {

            $fechaInicio = Carbon::now('America/Mexico_City')->startOfYear()->toDateString();
            $fechaFin    = Carbon::now('America/Mexico_City')->endOfYear()->toDateString();

            $tabla = otModel::select('formulario_ordentrabajo.*')
                ->where(function ($query) use ($fechaInicio, $fechaFin) {
                    $query->whereBetween(
                        DB::raw('DATE(formulario_ordentrabajo.FECHA_EMISION)'),
                        [$fechaInicio, $fechaFin]
                    )
                        ->orWhereNull('formulario_ordentrabajo.FECHA_EMISION')
                        ->orWhere('formulario_ordentrabajo.FECHA_EMISION', '');
                })
                ->whereRaw('formulario_ordentrabajo.ID_FORMULARIO_ORDEN IN (
                SELECT MAX(ID_FORMULARIO_ORDEN)
                FROM formulario_ordentrabajo
                GROUP BY SUBSTRING_INDEX(NO_ORDEN_CONFIRMACION, "-Rev", 1)
            )')
                ->get();

            foreach ($tabla as $value) {

                $baseOrden = preg_replace('/-Rev\d+$/', '', $value->NO_ORDEN_CONFIRMACION);

                $revisiones = otModel::select('formulario_ordentrabajo.*')
                    ->where(function ($query) use ($baseOrden) {
                        $query->where('NO_ORDEN_CONFIRMACION', $baseOrden)
                            ->orWhere('NO_ORDEN_CONFIRMACION', 'LIKE', $baseOrden . '-Rev%');
                    })
                    ->where('REVISION_ORDENCOMPRA', '<', $value->REVISION_ORDENCOMPRA)
                    ->orderBy('REVISION_ORDENCOMPRA', 'asc')
                    ->get();

                $ofertaIds = !empty($value->OFERTA_ID) ? json_decode($value->OFERTA_ID, true) : [];

                if (!empty($ofertaIds)) {
                    $ofertas = DB::table('formulario_ofertas')
                        ->whereIn('ID_FORMULARIO_OFERTAS', $ofertaIds)
                        ->pluck('NO_OFERTA')
                        ->toArray();

                    $value->NO_OFERTA = implode(', ', $ofertas);
                    $value->NO_OFERTA_HTML = implode('<br>', $ofertas);
                } else {
                    $value->NO_OFERTA = 'Sin oferta';
                    $value->NO_OFERTA_HTML = 'Sin oferta';
                }

                foreach ($revisiones as $rev) {

                    $ofertaIdsRev = !empty($rev->OFERTA_ID) ? json_decode($rev->OFERTA_ID, true) : [];

                    if (!empty($ofertaIdsRev)) {
                        $ofertasRev = DB::table('formulario_ofertas')
                            ->whereIn('ID_FORMULARIO_OFERTAS', $ofertaIdsRev)
                            ->pluck('NO_OFERTA')
                            ->toArray();

                        $rev->NO_OFERTA = implode(', ', $ofertasRev);
                        $rev->NO_OFERTA_HTML = implode('<br>', $ofertasRev);
                    } else {
                        $rev->NO_OFERTA = 'Sin oferta';
                        $rev->NO_OFERTA_HTML = 'Sin oferta';
                    }

                    $rev->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $rev->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $rev->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $rev->ID_FORMULARIO_ORDEN . '" checked><span class="slider round"></span></label>';
                }

                $value->REVISIONES = $revisiones->isEmpty() ? [] : $revisiones;

                if ($value->ACTIVO == 0) {
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill" disabled><i class="bi bi-ban"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_ORDEN . '"><span class="slider round"></span></label>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_CORREO = '<button type="button" class="btn btn-info btn-custom rounded-pill" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_ORDEN . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_CORREO = '<button type="button" class="btn btn-info btn-custom rounded-pill CORREO"><i class="bi bi-envelope-arrow-up-fill"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-ot" data-id="' . $value->ID_FORMULARIO_ORDEN . '"><i class="bi bi-filetype-pdf"></i></button>';
                }

                $value->DESCARGA_OT = '<button class="btn btn-danger btn-custom rounded-pill pdf-button " data-id="' . $value->ID_FORMULARIO_ORDEN . '" title="Descargar"><i class="bi bi-filetype-pdf"></i></button>';

            }

            return response()->json([
                'data' => $tabla,
                'msj'  => 'Información consultada correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'msj'  => 'Error ' . $e->getMessage(),
                'data' => 0
            ]);
        }
    }

    public function store(Request $request)
    {
        try {
            switch (intval($request->api)) {
               
                case 1:
                    if ($request->ID_FORMULARIO_ORDEN == 0) {
                        DB::statement('ALTER TABLE formulario_ordentrabajo AUTO_INCREMENT=1;');

                        $anioActual = date('Y');
                        $ultimoDigitoAnio = substr($anioActual, -2);

                        $ultimoRegistro = otModel::whereRaw("
                            NO_ORDEN_CONFIRMACION REGEXP ?
                        ", ["^RESOT-$ultimoDigitoAnio-[0-9]{3}(-Rev[0-9]+)?$"])
                                            ->orderByRaw("
                            CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(NO_ORDEN_CONFIRMACION, '-Rev', 1), '-', -1) AS UNSIGNED) DESC
                        ")
                            ->first();

                        if ($ultimoRegistro) {
                            preg_match('/RESOT-\d{2}-(\d{3})/', $ultimoRegistro->NO_ORDEN_CONFIRMACION, $matches);
                            $numeroIncremental = isset($matches[1]) ? intval($matches[1]) + 1 : 1;
                        } else {
                            $numeroIncremental = 1;
                        }

                        $noOrdenConfirmacion = 'RESOT-' . $ultimoDigitoAnio . '-' . str_pad($numeroIncremental, 3, '0', STR_PAD_LEFT);

                        $ofertaArray = $request->filled('OFERTA_ID')
                            ? json_encode($request->input('OFERTA_ID'))
                            : json_encode([]);
                        $serviciosJson = $request->filled('SERVICIOS_JSON')
                            ? $request->input('SERVICIOS_JSON')
                            : json_encode([]);

                        $ordenes = otModel::create(array_merge($request->all(), [
                            'NO_ORDEN_CONFIRMACION' => $noOrdenConfirmacion,
                            'OFERTA_ID' => $ofertaArray,
                            'SERVICIOS_JSON' => $serviciosJson,
                            'REVISION_ORDENCOMPRA' => 0,
                            'MOTIVO_REVISION_ORDENCOMPRA' => 'Revisión inicial'
                        ]));

                        return response()->json([
                            'code' => 1,
                            'orden' => $ordenes
                        ]);
                    } else {
                        if (isset($request->ELIMINAR)) {
                            $estado = $request->ELIMINAR == 1 ? 0 : 1;
                            otModel::where('ID_FORMULARIO_ORDEN', $request->ID_FORMULARIO_ORDEN)
                                ->update(['ACTIVO' => $estado]);

                            return response()->json([
                                'code' => 1,
                                'orden' => $estado == 0 ? 'Desactivada' : 'Activada'
                            ]);
                        } else {
                            $ordenes = otModel::find($request->ID_FORMULARIO_ORDEN);
                            if ($ordenes) {
                                $ofertaArray = $request->filled('OFERTA_ID') ? json_encode($request->input('OFERTA_ID')) : json_encode([]);
                                $serviciosJson = $request->filled('SERVICIOS_JSON') ? $request->input('SERVICIOS_JSON') : json_encode([]);

                                $ordenes->update(array_merge($request->all(), [
                                    'OFERTA_ID' => $ofertaArray,
                                    'SERVICIOS_JSON' => $serviciosJson
                                ]));

                                return response()->json([
                                    'code' => 1,
                                    'orden' => 'Actualizada'
                                ]);
                            }
                            return response()->json([
                                'code' => 0,
                                'msj' => 'Orden no encontrada'
                            ], 404);
                        }
                    }
                    break;



                case 2:
                    $ordenOriginal = otModel::find($request->ID_FORMULARIO_ORDEN);

                    if ($ordenOriginal) {
                        $noOfertaBase = explode('-Rev', $ordenOriginal->NO_ORDEN_CONFIRMACION)[0];

                        $ultimaRevision = otModel::where('NO_ORDEN_CONFIRMACION', 'LIKE', "$noOfertaBase%")
                            ->orderBy('REVISION_ORDENCOMPRA', 'desc')
                            ->first();

                        $revisionNumero = $ultimaRevision ? $ultimaRevision->REVISION_ORDENCOMPRA + 1 : 1;
                        $noOfertaConRevision = $noOfertaBase . '-Rev' . $revisionNumero;

                        $nuevaOrden = $ordenOriginal->replicate();
                        $nuevaOrden->NO_ORDEN_CONFIRMACION  = $noOfertaConRevision;
                        $nuevaOrden->REVISION_ORDENCOMPRA = $revisionNumero;
                        $nuevaOrden->MOTIVO_REVISION_ORDENCOMPRA = $request->MOTIVO_REVISION_ORDENCOMPRA;
                        $nuevaOrden->FECHA_EMISION = null;
                        $nuevaOrden->TITULO_CONFIRMACION = null;
                        $nuevaOrden->CONTACTO_CONFIRMACION = null;
                        $nuevaOrden->CONTACTO_TELEFONO_CONFIRMACION = null;
                        $nuevaOrden->CONTACTO_CELULAR_CONFIRMACION = null;
                        $nuevaOrden->CONTACTO_EMAIL_CONFIRMACION = null;

                        $nuevaOrden->FECHA_VERIFICACION = null;
                        $nuevaOrden->PRIORIDAD_SERVICIO = null;
                        $nuevaOrden->FECHA_INICIO_SERVICIO = null;
                        $nuevaOrden->PERSONA_SOLICITA_CONFIRMACION = null;
                        $nuevaOrden->DIRECCION_CONFIRMACION = null;

                        $nuevaOrden->RAZON_CONFIRMACION = $request->RAZON_CONFIRMACION;
                        $nuevaOrden->COMERCIAL_CONFIRMACION = $request->COMERCIAL_CONFIRMACION  ;
                        $nuevaOrden->RFC_CONFIRMACION = $request->RFC_CONFIRMACION;
                        $nuevaOrden->GIRO_CONFIRMACION = $request->GIRO_CONFIRMACION;

                    
                        $nuevaOrden->save();

                        $response['code'] = 1;
                        $response['oferta'] = $nuevaOrden;
                    } else {
                        $response['code'] = 0;
                        $response['message'] = 'Oferta no encontrada';
                    }
                    return response()->json($response);

                    break;

                default:
                    return response()->json(['code' => 1, 'msj' => 'API no encontrada']);

                }
        } catch (Exception $e) {
            Log::error("Error al guardar orden: " . $e->getMessage());
            return response()->json([
                'code' => 0,
                'error' => 'Error al guardar la orden'
            ], 500);
        }
    }
}
