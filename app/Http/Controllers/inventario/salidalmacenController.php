<?php

namespace App\Http\Controllers\inventario;




use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Auth;

use DB;



use App\Models\proveedor\altaproveedorModel;
use App\Models\proveedor\proveedortempModel;
use App\Models\inventario\inventarioModel;
use App\Models\inventario\catalogotipoinventarioModel;


use App\Models\recempleados\recemplaedosModel;
use App\Models\contratacion\contratacionModel;



class salidalmacenController extends Controller
{
    public function index()
    {

        $tipoinventario = catalogotipoinventarioModel::where('ACTIVO', 1)->get();
        $proveedoresOficiales = altaproveedorModel::select('RAZON_SOCIAL_ALTA', 'RFC_ALTA')->get();
        $proveedoresTemporales = proveedortempModel::select('RAZON_PROVEEDORTEMP', 'RFC_PROVEEDORTEMP', 'NOMBRE_PROVEEDORTEMP')->get();
        $inventario = inventarioModel::where('ACTIVO', 1)->get();


        $colaboradores = contratacionModel::where('ACTIVO', 1)->get();


        $proveedores = DB::table('formulario_altaproveedor as ap')
            ->leftJoin('formulario_directorio as d', 'd.RFC_PROVEEDOR', '=', 'ap.RFC_ALTA')
            ->where('ap.TIENE_ASIGNACION', 1)
            ->select(
                'ap.ID_FORMULARIO_ALTA',
                'ap.RFC_ALTA',
                'ap.TIENE_ASIGNACION',
                'd.NOMBRE_DIRECTORIO'
            )
            ->get();


        return view('almacen.salidalmacen.salidaalmacen', compact('tipoinventario', 'proveedoresOficiales', 'proveedoresTemporales', 'inventario', 'colaboradores', 'proveedores'));
    }


    public function Tablasalidalmacen()
    {
        try {


            $tabla = recemplaedosModel::where('TIPO_SOLICITUD', 2)
                ->where('ESTADO_APROBACION', 'Aprobada')
                ->orderBy('FECHA_SALIDA', 'asc')
                ->get();




            foreach ($tabla as $value) {
               

                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_RECURSOS_EMPLEADOS . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_RECURSOS_EMPLEADOS . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }

            
                if ($value->TIPO_SOLICITUD == 1) {
                    $value->TIPO_SOLICITUD_TEXTO = 'Aviso de ausencia y/o permiso';
                } elseif ($value->TIPO_SOLICITUD == 2) {
                    $value->TIPO_SOLICITUD_TEXTO = 'Salida de almacén de materiales y/o equipos';
                } else {
                    $value->TIPO_SOLICITUD_TEXTO = 'Solicitud de Vacaciones';
                }

             
                if ($value->DAR_BUENO == 0) {
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



                $color = '';
                $faltan = 0;
                $totalRetornables = 0;

                if (!empty($value->MATERIALES_JSON)) {
                    $materiales = json_decode($value->MATERIALES_JSON, true);

                    if (is_array($materiales)) {
                        foreach ($materiales as $mat) {

                            if (($mat['RETORNA_EQUIPO'] ?? '0') == '1') {

                                if (($mat['VARIOS_ARTICULOS'] ?? '0') == '1') {

                                    if (!empty($mat['ARTICULOS']) && is_array($mat['ARTICULOS'])) {
                                        foreach ($mat['ARTICULOS'] as $detalle) {

                                            $tieneDatos = (
                                                !empty($detalle['INVENTARIO']) ||
                                                !empty($detalle['TIPO_INVENTARIO']) ||
                                                (!empty($detalle['CANTIDAD_DETALLE']) && $detalle['CANTIDAD_DETALLE'] != '0')
                                            );

                                            if ($tieneDatos) {
                                                $totalRetornables++;

                                                if (!isset($detalle['RETORNA_DETALLE']) || in_array($detalle['RETORNA_DETALLE'], ['0', '2', ''])) {
                                                    $faltan++;
                                                }
                                            }
                                        }
                                    } else {
                                        $totalRetornables++;
                                        $faltan++;
                                    }
                                }

                                else {
                                    $existencia = intval($mat['EN_EXISTENCIA'] ?? 0);

                                    if ($existencia > 0) {
                                        $totalRetornables++;

                                        if (!isset($mat['ARTICULO_RETORNO']) || in_array($mat['ARTICULO_RETORNO'], ['0', '2', ''])) {
                                            $faltan++;
                                        }
                                    }
                                }
                            }
                        }

                        if ($totalRetornables > 0) {
                            if ($faltan == 0) {
                                $color = 'bg-verde-suave'; 
                            } else {
                                $color = 'bg-amarillo-suave'; 
                            }
                        } else {
                            if ($value->FINALIZAR_SOLICITUD_ALMACEN == 1) {
                                $color = 'bg-verde-suave';
                            }
                        }
                    }
                }

                // 🔹 Campos finales para DataTable o JSON
                $value->COLOR_FILA = $color;
                $value->MATERIALES_PENDIENTES = $faltan;
                $value->MATERIALES_TOTAL = $totalRetornables;
                $value->MATERIALES_RETORNADOS = $totalRetornables - $faltan;
                $value->ESTADO_RETORNO = ($faltan > 0)
                    ? '<span class="badge bg-warning text-dark">Pendiente retorno (' . ($totalRetornables - $faltan) . '/' . $totalRetornables . ')</span>'
                    : '<span class="badge bg-success">Todo retornado (' . $totalRetornables . '/' . $totalRetornables . ')</span>';
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
                    if ($request->ID_FORMULARIO_RECURSOS_EMPLEADOS == 0) {
                        DB::statement('ALTER TABLE formulario_recempleados AUTO_INCREMENT=1;');

                        $materialesJson = is_string($request->MATERIALES_JSON)
                            ? $request->MATERIALES_JSON
                            : json_encode($request->MATERIALES_JSON, JSON_UNESCAPED_UNICODE);

                        $mrs = recemplaedosModel::create(array_merge(
                            $request->except(['MATERIALES_JSON']),
                            [
                                'USUARIO_ID'      => auth()->user()->ID_USUARIO,
                                'CURP'            => auth()->user()->CURP,
                                'MATERIALES_JSON' => $materialesJson
                            ]
                        ));

                        return response()->json([
                            'code' => 1,
                            'mr'   => $mrs
                        ]);
                    } else {
                        if (isset($request->ELIMINAR)) {
                            $estado = $request->ELIMINAR == 1 ? 0 : 1;
                            recemplaedosModel::where('ID_FORMULARIO_RECURSOS_EMPLEADOS', $request->ID_FORMULARIO_RECURSOS_EMPLEADOS)
                                ->update(['ACTIVO' => $estado]);

                            return response()->json([
                                'code' => 1,
                                'mr'   => $estado == 0 ? 'Desactivada' : 'Activada'
                            ]);
                        } else {
                            $mrs = recemplaedosModel::find($request->ID_FORMULARIO_RECURSOS_EMPLEADOS);

                            if ($mrs) {
                                $datos = $request->except(['USUARIO_ID', 'CURP']);

                                if (isset($datos['MATERIALES_JSON'])) {
                                    $datos['MATERIALES_JSON'] = is_string($datos['MATERIALES_JSON'])
                                        ? $datos['MATERIALES_JSON']
                                        : json_encode($datos['MATERIALES_JSON'], JSON_UNESCAPED_UNICODE);
                                }

                                $mrs->update($datos);

                               
                                if (
                                    $request->FINALIZAR_SOLICITUD_ALMACEN == 1 &&
                                    $mrs->GUARDO_SALIDA_INVENTARIO != 1
                                ) {
                                    $materiales = json_decode($mrs->MATERIALES_JSON, true);

                                
                                    if (is_array($materiales) && $mrs->GUARDO_SALIDA_INVENTARIO != 1) {

                                        foreach ($materiales as $mat) {

                                            $esAsignacionUnico = isset($mat['ES_ASIGNACION']) && $mat['ES_ASIGNACION'] == "1";
                                            $nombreAsignacionUnico = $mat['NOMBRE_ASIGNACION'] ?? null;

                                            if (!empty($mat['VARIOS_ARTICULOS']) && $mat['VARIOS_ARTICULOS'] == "1" && isset($mat['ARTICULOS'])) {

                                                foreach ($mat['ARTICULOS'] as $art) {

                                                    $cantidad = intval($art['CANTIDAD_DETALLE'] ?? 0);
                                                    if ($cantidad <= 0) continue;

                                                    $esAsignacionDet = isset($art['ES_ASIGNACION_DETALLE']) && $art['ES_ASIGNACION_DETALLE'] == "1";
                                                    $nombreAsignacionDet = $art['NOMBRE_ASIGNACION_DETALLE'] ?? null;

                                                    if ($esAsignacionDet) {
                                                        $usuarioId = null;
                                                        $usuarioAsignacion = $nombreAsignacionDet;
                                                        $salidaAsignacion = 1;
                                                    } else {
                                                        $usuarioId = $mrs->USUARIO_ID;
                                                        $usuarioAsignacion = null;
                                                        $salidaAsignacion = null;
                                                    }

                                                    DB::table('salidas_inventario')->insert([
                                                        'USUARIO_ID'        => $usuarioId,
                                                        'USUARIO_ASIGNACION' => $usuarioAsignacion,
                                                        'SALIDA_ASIGNACIONES' => $salidaAsignacion,
                                                        'INVENTARIO_ID'     => $art['INVENTARIO'],
                                                        'CANTIDAD_SALIDA'   => $cantidad,
                                                        'FECHA_SALIDA'      => $mrs->FECHA_ALMACEN_SOLICITUD,
                                                        'UNIDAD_MEDIDA'     => $art['UNIDAD_DETALLE'],
                                                        'created_at'        => now(),
                                                        'updated_at'        => now()
                                                    ]);

                                                    $inventario = inventarioModel::find($art['INVENTARIO']);
                                                    if ($inventario) {
                                                        $inventario->CANTIDAD_EQUIPO = max(0, $inventario->CANTIDAD_EQUIPO - $cantidad);

                                                        if ($esAsignacionDet)
                                                            $inventario->ASIGNADO = 1;

                                                        $inventario->save();
                                                    }

                                                    if ($esAsignacionDet) {
                                                        DB::table('asignaciones_inventario')->insert([
                                                            'ASIGNADO_ID'      => $nombreAsignacionDet,
                                                            'INVENTARIO_ID'    => $art['INVENTARIO'],
                                                            'FECHA_ASIGNACION' => $mrs->FECHA_ALMACEN_SOLICITUD,
                                                            'CANTIDAD_SALIDA'   => $cantidad,
                                                            'ALMACENISTA_ID' => auth()->user()->ID_USUARIO,
                                                            'created_at'       => now(),
                                                            'updated_at'       => now()
                                                        ]);
                                                    }
                                                }
                                            } else {

                                                $cantidad = intval($mat['CANTIDAD_SALIDA'] ?? 0);
                                                if ($cantidad <= 0) continue;

                                                if ($esAsignacionUnico) {
                                                    $usuarioId = null;
                                                    $usuarioAsignacion = $nombreAsignacionUnico;
                                                    $salidaAsignacion = 1;
                                                } else {
                                                    $usuarioId = $mrs->USUARIO_ID;
                                                    $usuarioAsignacion = null;
                                                    $salidaAsignacion = null;
                                                }

                                                DB::table('salidas_inventario')->insert([
                                                    'USUARIO_ID'        => $usuarioId,
                                                    'USUARIO_ASIGNACION' => $usuarioAsignacion,
                                                    'SALIDA_ASIGNACIONES' => $salidaAsignacion,
                                                    'INVENTARIO_ID'     => $mat['INVENTARIO'],
                                                    'CANTIDAD_SALIDA'   => $cantidad,
                                                    'FECHA_SALIDA'      => $mrs->FECHA_ALMACEN_SOLICITUD,
                                                    'UNIDAD_MEDIDA'     => $mat['UNIDAD_SALIDA'],
                                                    'created_at'        => now(),
                                                    'updated_at'        => now()
                                                ]);

                                                $inventario = inventarioModel::find($mat['INVENTARIO']);
                                                if ($inventario) {
                                                    $inventario->CANTIDAD_EQUIPO = max(0, $inventario->CANTIDAD_EQUIPO - $cantidad);

                                                    if ($esAsignacionUnico)
                                                        $inventario->ASIGNADO = 1;

                                                    $inventario->save();
                                                }

                                                if ($esAsignacionUnico) {
                                                    DB::table('asignaciones_inventario')->insert([
                                                        'ASIGNADO_ID'      => $nombreAsignacionUnico,
                                                        'INVENTARIO_ID'    => $mat['INVENTARIO'],
                                                        'FECHA_ASIGNACION' => $mrs->FECHA_ALMACEN_SOLICITUD,
                                                        'CANTIDAD_SALIDA'   => $cantidad,
                                                        'ALMACENISTA_ID' => auth()->user()->ID_USUARIO,
                                                        'created_at'       => now(),
                                                        'updated_at'       => now()
                                                    ]);
                                                }
                                            }
                                        }

                                        $mrs->update([
                                            'GUARDO_SALIDA_INVENTARIO' => 1
                                        ]);
                                    }

                                }

                                $materiales = json_decode($mrs->MATERIALES_JSON, true);

                                if (is_array($materiales)) {
                                    foreach ($materiales as $mat) {
                                        if (!empty($mat['VARIOS_ARTICULOS']) && $mat['VARIOS_ARTICULOS'] == "1" && isset($mat['ARTICULOS'])) {
                                            foreach ($mat['ARTICULOS'] as $art) {
                                                if (!empty($art['RETORNA_DETALLE']) && $art['RETORNA_DETALLE'] == "1") {
                                                    $cantRetorno   = intval($art['CANTIDAD_RETORNO_DETALLE'] ?? 0);
                                                    $unidadRetorna = $art['UNIDAD_DETALLE'] ?? null;
                                                    $fechaIngreso  = $art['FECHA_DETALLE'] ?? $mrs->FECHA_ALMACEN_SOLICITUD;

                                                    if ($cantRetorno > 0) {
                                                        $existe = DB::table('entradas_inventario')
                                                            ->where('INVENTARIO_ID', $art['INVENTARIO'])
                                                            ->where('USUARIO_ID', $mrs->USUARIO_ID)
                                                            ->whereDate('FECHA_INGRESO', $fechaIngreso)
                                                            ->where('CANTIDAD_PRODUCTO', $cantRetorno)
                                                            ->exists();

                                                        if (!$existe) {
                                                            DB::table('entradas_inventario')->insert([
                                                                'INVENTARIO_ID'     => $art['INVENTARIO'],
                                                                'USUARIO_ID'        => $mrs->USUARIO_ID,
                                                                'FECHA_INGRESO'     => $fechaIngreso,
                                                                'CANTIDAD_PRODUCTO' => $cantRetorno,   
                                                                'UNIDAD_MEDIDA'     => $unidadRetorna, 
                                                                'ENTRADA_SOLICITUD' => 1,
                                                                'created_at'        => now(),
                                                                'updated_at'        => now()
                                                            ]);

                                                            $inventario = inventarioModel::find($art['INVENTARIO']);
                                                            if ($inventario) {
                                                                $inventario->CANTIDAD_EQUIPO += $cantRetorno;
                                                                $inventario->save();
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        } else {
                                            if (!empty($mat['ARTICULO_RETORNO']) && $mat['ARTICULO_RETORNO'] == "1") {
                                                $cantRetorno  = intval($mat['CANTIDAD_RETORNO'] ?? 0);
                                                $umretorna    = $mat['UNIDAD_SALIDA'] ?? null;
                                                $fechaIngreso = $mat['FECHA_RETORNO'] ?? $mrs->FECHA_ALMACEN_SOLICITUD;

                                                if ($cantRetorno > 0) {
                                                    $existe = DB::table('entradas_inventario')
                                                        ->where('INVENTARIO_ID', $mat['INVENTARIO'])
                                                        ->where('USUARIO_ID', $mrs->USUARIO_ID)
                                                        ->whereDate('FECHA_INGRESO', $fechaIngreso)
                                                        ->where('CANTIDAD_PRODUCTO', $cantRetorno)
                                                        ->exists();

                                                    if (!$existe) {
                                                        DB::table('entradas_inventario')->insert([
                                                            'INVENTARIO_ID'     => $mat['INVENTARIO'],
                                                            'USUARIO_ID'        => $mrs->USUARIO_ID,
                                                            'FECHA_INGRESO'     => $fechaIngreso,
                                                            'CANTIDAD_PRODUCTO' => $cantRetorno,
                                                            'UNIDAD_MEDIDA'     => $umretorna,
                                                            'ENTRADA_SOLICITUD' => 1,
                                                            'created_at'        => now(),
                                                            'updated_at'        => now()
                                                        ]);

                                                        $inventario = inventarioModel::find($mat['INVENTARIO']);
                                                        if ($inventario) {
                                                            $inventario->CANTIDAD_EQUIPO += $cantRetorno;
                                                            $inventario->save();
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }

                                return response()->json([
                                    'code' => 1,
                                    'mr'   => 'Actualizada'
                                ]);
                            }

                            return response()->json([
                                'code' => 0,
                                'msj'  => 'MR no encontrada'
                            ], 404);
                        }
                    }
                    break;

                default:
                    return response()->json([
                        'code' => 1,
                        'msj'  => 'Api no encontrada'
                    ]);
            }
        } catch (Exception $e) {
            Log::error("Error al guardar MR: " . $e->getMessage());
            return response()->json([
                'code'  => 0,
                'error' => 'Error al guardar la MR'
            ], 500);
        }
    }
}
