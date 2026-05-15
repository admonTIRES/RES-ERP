<?php

namespace App\Http\Controllers\bitacorasinventario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Log;

use DB;

use App\Models\proveedor\altaproveedorModel;
use App\Models\proveedor\proveedortempModel;
use App\Models\inventario\inventarioModel;
use App\Models\inventario\catalogotipoinventarioModel;
use App\Models\recempleados\recemplaedosModel;
use App\Models\usuario\usuarioModel;
use App\Models\bitacorasalmacen\bitacoraModel;



class bitacoraretornableController extends Controller
{
    public function index()
    {

        $tipoinventario = catalogotipoinventarioModel::where('ACTIVO', 1)->get();
        $proveedoresOficiales = altaproveedorModel::select('RAZON_SOCIAL_ALTA', 'RFC_ALTA')->get();
        $proveedoresTemporales = proveedortempModel::select('RAZON_PROVEEDORTEMP', 'RFC_PROVEEDORTEMP', 'NOMBRE_PROVEEDORTEMP')->get();
        $inventario = inventarioModel::where('ACTIVO', 1)->get();
        $usuarios = usuarioModel::where('ACTIVO', 1) ->where('USUARIO_TIPO', 1)->get();

        return view('almacen.bitacoras.bitacora_retornables', compact('tipoinventario', 'proveedoresOficiales', 'proveedoresTemporales', 'inventario', 'usuarios'));
    }



    // public function Tablabitacoraretornable()
    // {
    //     try {
    //         $tabla = recemplaedosModel::where('TIPO_SOLICITUD', 2)
    //             ->where('ESTADO_APROBACION', 'Aprobada')
    //             ->where('FINALIZAR_SOLICITUD_ALMACEN', 1)
    //             ->orderBy('FECHA_ALMACEN_SOLICITUD', 'asc')
    //             ->get();

    //         $data = [];
    //         $tiposPermitidos = ['AF', 'ANF']; 

    //         foreach ($tabla as $value) {

    //             $materiales = json_decode($value->MATERIALES_JSON, true);
    //             if (!is_array($materiales)) continue;

    //             foreach ($materiales as $articulo) {

    //                 if (!empty($articulo['VARIOS_ARTICULOS']) && $articulo['VARIOS_ARTICULOS'] == "1") {

    //                     if (empty($articulo['RETORNA_EQUIPO']) || $articulo['RETORNA_EQUIPO'] != 1) {
    //                         continue;
    //                     }

    //                     if (!empty($articulo['ARTICULOS']) && is_array($articulo['ARTICULOS'])) {

    //                         foreach ($articulo['ARTICULOS'] as $detalle) {

    //                             if (!empty($detalle['ES_ASIGNACION_DETALLE']) && $detalle['ES_ASIGNACION_DETALLE'] == 1) {
    //                                 continue;
    //                             }

    //                             if (empty($detalle['INVENTARIO']) || empty($detalle['TIPO_INVENTARIO'])) {
    //                                 continue;
    //                             }

    //                             if ($detalle['TIPO_INVENTARIO'] === 'Vehículos') {
    //                                 continue;
    //                             }

    //                             if (
    //                                 !in_array($detalle['TIPO_INVENTARIO'], $tiposPermitidos)
    //                                 && empty($articulo['RETORNA_EQUIPO'])
    //                             ) {
    //                                 continue;
    //                             }

    //                             $producto = DB::table('formulario_inventario')
    //                                 ->select('DESCRIPCION_EQUIPO', 'MARCA_EQUIPO', 'MODELO_EQUIPO', 'SERIE_EQUIPO', 'CODIGO_EQUIPO')
    //                                 ->where('ID_FORMULARIO_INVENTARIO', $detalle['INVENTARIO'])
    //                                 ->first();

    //                             $data[] = [
    //                                 'ID_FORMULARIO_RECURSOS_EMPLEADOS' => $value->ID_FORMULARIO_RECURSOS_EMPLEADOS,
    //                                 'DESCRIPCION' => trim($articulo['DESCRIPCION'] ?? ''),
    //                                 'SOLICITANTE_SALIDA' => $value->SOLICITANTE_SALIDA ?? 'N/A',
    //                                 'FECHA_ALMACEN_SOLICITUD' => $value->FECHA_ALMACEN_SOLICITUD ?? 'N/A',
    //                                 'OBSERVACIONES_REC' => $value->OBSERVACIONES_REC ?? 'N/A',
    //                                 'CANTIDAD' => $detalle['CANTIDAD_DETALLE'] ?? '',
    //                                 'CANTIDAD_SALIDA' => $detalle['CANTIDAD_DETALLE'] ?? '',
    //                                 'PRODUCTO_NOMBRE' => $producto->DESCRIPCION_EQUIPO ?? 'N/A',
    //                                 'MARCA_EQUIPO' => $producto->MARCA_EQUIPO ?? 'N/A',
    //                                 'MODELO_EQUIPO' => $producto->MODELO_EQUIPO ?? 'N/A',
    //                                 'SERIE_EQUIPO' => $producto->SERIE_EQUIPO ?? 'N/A',
    //                                 'CODIGO_EQUIPO' => $producto->CODIGO_EQUIPO ?? 'N/A',
    //                                 'UNIDAD_SALIDA' => $detalle['UNIDAD_DETALLE'] ?? '',
    //                                 'BTN_EDITAR' => '<button type="button" class="btn btn-warning btn-custom rounded-pill editarMaterial"
    //                                 data-id="' . $value->ID_FORMULARIO_RECURSOS_EMPLEADOS . '"
    //                                 data-inventario="' . ($detalle['INVENTARIO'] ?? '') . '">
    //                                 <i class="bi bi-pencil-square"></i>
    //                             </button>',
    //                                 'BTN_VISUALIZAR' => '<button type="button" class="btn btn-primary btn-custom rounded-pill visualizarMaterial"
    //                                 data-id="' . $value->ID_FORMULARIO_RECURSOS_EMPLEADOS . '"
    //                                 data-inventario="' . ($detalle['INVENTARIO'] ?? '') . '">
    //                                 <i class="bi bi-eye"></i>
    //                             </button>',
    //                             ];
    //                         }
    //                     }

    //                 } else {

    //                     if (empty($articulo['RETORNA_EQUIPO']) || $articulo['RETORNA_EQUIPO'] != 1) {
    //                         continue;
    //                     }

    //                     if (empty($articulo['TIPO_INVENTARIO']) || empty($articulo['INVENTARIO'])) {
    //                         continue;
    //                     }

    //                     if ($articulo['TIPO_INVENTARIO'] === 'Vehículos') {
    //                         continue;
    //                     }

    //                     if (
    //                         !in_array($articulo['TIPO_INVENTARIO'], $tiposPermitidos)
    //                         && empty($articulo['RETORNA_EQUIPO'])
    //                     ) {
    //                         continue;
    //                     }

    //                     $producto = DB::table('formulario_inventario')
    //                         ->select('DESCRIPCION_EQUIPO', 'MARCA_EQUIPO', 'MODELO_EQUIPO', 'SERIE_EQUIPO', 'CODIGO_EQUIPO')
    //                         ->where('ID_FORMULARIO_INVENTARIO', $articulo['INVENTARIO'])
    //                         ->first();

    //                     $data[] = [
    //                         'ID_FORMULARIO_RECURSOS_EMPLEADOS' => $value->ID_FORMULARIO_RECURSOS_EMPLEADOS,
    //                         'DESCRIPCION' => trim($articulo['DESCRIPCION'] ?? ''),
    //                         'SOLICITANTE_SALIDA' => $value->SOLICITANTE_SALIDA ?? 'N/A',
    //                         'FECHA_ALMACEN_SOLICITUD' => $value->FECHA_ALMACEN_SOLICITUD ?? 'N/A',
    //                         'OBSERVACIONES_REC' => $value->OBSERVACIONES_REC ?? 'N/A',
    //                         'CANTIDAD' => $articulo['CANTIDAD'] ?? '',
    //                         'CANTIDAD_SALIDA' => $articulo['CANTIDAD_SALIDA'] ?? '',
    //                         'PRODUCTO_NOMBRE' => $producto->DESCRIPCION_EQUIPO ?? 'N/A',
    //                         'MARCA_EQUIPO' => $producto->MARCA_EQUIPO ?? 'N/A',
    //                         'MODELO_EQUIPO' => $producto->MODELO_EQUIPO ?? 'N/A',
    //                         'SERIE_EQUIPO' => $producto->SERIE_EQUIPO ?? 'N/A',
    //                         'CODIGO_EQUIPO' => $producto->CODIGO_EQUIPO ?? 'N/A',
    //                         'UNIDAD_SALIDA' => $articulo['UNIDAD_SALIDA'] ?? '',
    //                         'BTN_EDITAR' => '<button type="button" class="btn btn-warning btn-custom rounded-pill editarMaterial"
    //                         data-id="' . $value->ID_FORMULARIO_RECURSOS_EMPLEADOS . '"
    //                         data-inventario="' . ($articulo['INVENTARIO'] ?? '') . '">
    //                         <i class="bi bi-pencil-square"></i>
    //                     </button>',
    //                         'BTN_VISUALIZAR' => '<button type="button" class="btn btn-primary btn-custom rounded-pill visualizarMaterial"
    //                         data-id="' . $value->ID_FORMULARIO_RECURSOS_EMPLEADOS . '"
    //                         data-inventario="' . ($articulo['INVENTARIO'] ?? '') . '">
    //                         <i class="bi bi-eye"></i>
    //                     </button>',
    //                     ];
    //                 }
    //             }
    //         }

    //         return response()->json(['data' => $data], 200);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
    //     }
    // }


    public function Tablabitacoraretornable()
    {
        try {

            $tabla = recemplaedosModel::where('TIPO_SOLICITUD', 2)
                ->where('ESTADO_APROBACION', 'Aprobada')
                ->where('FINALIZAR_SOLICITUD_ALMACEN', 1)
                ->orderBy('FECHA_ALMACEN_SOLICITUD', 'asc')
                ->get();

            $data = [];
            $tiposPermitidos = ['AF', 'ANF'];

            $fechaInicio = '2025-01-01';
            $fechaFin    = '2025-12-07';

            foreach ($tabla as $value) {

                $materiales = json_decode($value->MATERIALES_JSON, true);
                if (!is_array($materiales)) continue;

                foreach ($materiales as $articulo) {

                    /* ================= VARIOS ================= */
                    if (!empty($articulo['VARIOS_ARTICULOS']) && $articulo['VARIOS_ARTICULOS'] == "1") {

                        if (empty($articulo['RETORNA_EQUIPO']) || $articulo['RETORNA_EQUIPO'] != 1) {
                            continue;
                        }

                        if (!empty($articulo['ARTICULOS']) && is_array($articulo['ARTICULOS'])) {

                            foreach ($articulo['ARTICULOS'] as $detalle) {

                                if (!empty($detalle['ES_ASIGNACION_DETALLE']) && $detalle['ES_ASIGNACION_DETALLE'] == 1) {
                                    continue;
                                }

                                if (empty($detalle['INVENTARIO']) || empty($detalle['TIPO_INVENTARIO'])) {
                                    continue;
                                }

                                if ($detalle['TIPO_INVENTARIO'] === 'Vehículos') {
                                    continue;
                                }

                                if (
                                    !in_array($detalle['TIPO_INVENTARIO'], $tiposPermitidos)
                                    && empty($articulo['RETORNA_EQUIPO'])
                                ) {
                                    continue;
                                }

                                /* ================= COLOR ================= */
                                $rowClass = '';
                                $fechaSolicitud = $value->FECHA_ALMACEN_SOLICITUD;

                                if ($fechaSolicitud >= $fechaInicio && $fechaSolicitud <= $fechaFin) {

                                    $rowClass = 'bg-verde-suave';
                                } elseif ($fechaSolicitud > $fechaFin) {

                                    $bitacora = DB::table('bitacorasalmacen')
                                        ->where('RECEMPLEADO_ID', $value->ID_FORMULARIO_RECURSOS_EMPLEADOS)
                                        ->where('INVENTARIO_ID', $detalle['INVENTARIO'])
                                        ->where('ACTIVO', 1)
                                        ->first();

                                    if ($bitacora) {
                                        if ($bitacora->RETORNO_BITACORA_RETORNABLE == 1) {
                                            $rowClass = 'bg-verde-suave';
                                        } elseif ($bitacora->RETORNO_BITACORA_RETORNABLE == 2) {
                                            $rowClass = 'bg-amarillo-suave';
                                        }
                                    }
                                }
                                /* ========================================= */

                                $producto = DB::table('formulario_inventario')
                                    ->select(
                                        'DESCRIPCION_EQUIPO',
                                        'MARCA_EQUIPO',
                                        'MODELO_EQUIPO',
                                        'SERIE_EQUIPO',
                                        'CODIGO_EQUIPO'
                                    )
                                    ->where('ID_FORMULARIO_INVENTARIO', $detalle['INVENTARIO'])
                                    ->first();

                                $data[] = [
                                    'ROW_CLASS' => $rowClass,

                                    'ID_FORMULARIO_RECURSOS_EMPLEADOS' => $value->ID_FORMULARIO_RECURSOS_EMPLEADOS,
                                    'DESCRIPCION' => trim($articulo['DESCRIPCION'] ?? ''),
                                    'SOLICITANTE_SALIDA' => $value->SOLICITANTE_SALIDA ?? 'N/A',
                                    'FECHA_ALMACEN_SOLICITUD' => $value->FECHA_ALMACEN_SOLICITUD ?? 'N/A',
                                    'OBSERVACIONES_REC' => $value->OBSERVACIONES_REC ?? 'N/A',
                                    'CANTIDAD' => $detalle['CANTIDAD_DETALLE'] ?? '',
                                    'CANTIDAD_SALIDA' => $detalle['CANTIDAD_DETALLE'] ?? '',
                                    'PRODUCTO_NOMBRE' => $producto->DESCRIPCION_EQUIPO ?? 'N/A',
                                    'MARCA_EQUIPO' => $producto->MARCA_EQUIPO ?? 'N/A',
                                    'MODELO_EQUIPO' => $producto->MODELO_EQUIPO ?? 'N/A',
                                    'SERIE_EQUIPO' => $producto->SERIE_EQUIPO ?? 'N/A',
                                    'CODIGO_EQUIPO' => $producto->CODIGO_EQUIPO ?? 'N/A',
                                    'UNIDAD_SALIDA' => $detalle['UNIDAD_DETALLE'] ?? '',

                                    'BTN_EDITAR' => '<button type="button" class="btn btn-warning btn-custom rounded-pill editarMaterial"
                                    data-id="' . $value->ID_FORMULARIO_RECURSOS_EMPLEADOS . '"
                                    data-inventario="' . ($detalle['INVENTARIO'] ?? '') . '">
                                    <i class="bi bi-pencil-square"></i>
                                </button>',

                                    'BTN_VISUALIZAR' => '<button type="button" class="btn btn-primary btn-custom rounded-pill visualizarMaterial"
                                    data-id="' . $value->ID_FORMULARIO_RECURSOS_EMPLEADOS . '"
                                    data-inventario="' . ($detalle['INVENTARIO'] ?? '') . '">
                                    <i class="bi bi-eye"></i>
                                </button>',
                                ];
                            }
                        }

                        /* ================= NORMAL ================= */
                    } else {

                        if (empty($articulo['RETORNA_EQUIPO']) || $articulo['RETORNA_EQUIPO'] != 1) {
                            continue;
                        }

                        if (empty($articulo['TIPO_INVENTARIO']) || empty($articulo['INVENTARIO'])) {
                            continue;
                        }

                        if ($articulo['TIPO_INVENTARIO'] === 'Vehículos') {
                            continue;
                        }

                        if (
                            !in_array($articulo['TIPO_INVENTARIO'], $tiposPermitidos)
                            && empty($articulo['RETORNA_EQUIPO'])
                        ) {
                            continue;
                        }

                        /* ================= COLOR ================= */
                        $rowClass = '';
                        $fechaSolicitud = $value->FECHA_ALMACEN_SOLICITUD;

                        if ($fechaSolicitud >= $fechaInicio && $fechaSolicitud <= $fechaFin) {

                            $rowClass = 'bg-verde-suave';
                        } elseif ($fechaSolicitud > $fechaFin) {

                            $bitacora = DB::table('bitacorasalmacen')
                                ->where('RECEMPLEADO_ID', $value->ID_FORMULARIO_RECURSOS_EMPLEADOS)
                                ->where('INVENTARIO_ID', $articulo['INVENTARIO'])
                                ->where('ACTIVO', 1)
                                ->first();

                            if ($bitacora) {
                                if ($bitacora->RETORNO_BITACORA_RETORNABLE == 1) {
                                    $rowClass = 'bg-verde-suave';
                                } elseif ($bitacora->RETORNO_BITACORA_RETORNABLE == 2) {
                                    $rowClass = 'bg-amarillo-suave';
                                }
                            }
                        }
                        /* ========================================= */

                        $producto = DB::table('formulario_inventario')
                            ->select(
                                'DESCRIPCION_EQUIPO',
                                'MARCA_EQUIPO',
                                'MODELO_EQUIPO',
                                'SERIE_EQUIPO',
                                'CODIGO_EQUIPO'
                            )
                            ->where('ID_FORMULARIO_INVENTARIO', $articulo['INVENTARIO'])
                            ->first();

                        $data[] = [
                            'ROW_CLASS' => $rowClass,

                            'ID_FORMULARIO_RECURSOS_EMPLEADOS' => $value->ID_FORMULARIO_RECURSOS_EMPLEADOS,
                            'DESCRIPCION' => trim($articulo['DESCRIPCION'] ?? ''),
                            'SOLICITANTE_SALIDA' => $value->SOLICITANTE_SALIDA ?? 'N/A',
                            'FECHA_ALMACEN_SOLICITUD' => $value->FECHA_ALMACEN_SOLICITUD ?? 'N/A',
                            'OBSERVACIONES_REC' => $value->OBSERVACIONES_REC ?? 'N/A',
                            'CANTIDAD' => $articulo['CANTIDAD'] ?? '',
                            'CANTIDAD_SALIDA' => $articulo['CANTIDAD_SALIDA'] ?? '',
                            'PRODUCTO_NOMBRE' => $producto->DESCRIPCION_EQUIPO ?? 'N/A',
                            'MARCA_EQUIPO' => $producto->MARCA_EQUIPO ?? 'N/A',
                            'MODELO_EQUIPO' => $producto->MODELO_EQUIPO ?? 'N/A',
                            'SERIE_EQUIPO' => $producto->SERIE_EQUIPO ?? 'N/A',
                            'CODIGO_EQUIPO' => $producto->CODIGO_EQUIPO ?? 'N/A',
                            'UNIDAD_SALIDA' => $articulo['UNIDAD_SALIDA'] ?? '',

                            'BTN_EDITAR' => '<button type="button" class="btn btn-warning btn-custom rounded-pill editarMaterial"
                            data-id="' . $value->ID_FORMULARIO_RECURSOS_EMPLEADOS . '"
                            data-inventario="' . ($articulo['INVENTARIO'] ?? '') . '">
                            <i class="bi bi-pencil-square"></i>
                        </button>',

                            'BTN_VISUALIZAR' => '<button type="button" class="btn btn-primary btn-custom rounded-pill visualizarMaterial"
                            data-id="' . $value->ID_FORMULARIO_RECURSOS_EMPLEADOS . '"
                            data-inventario="' . ($articulo['INVENTARIO'] ?? '') . '">
                            <i class="bi bi-eye"></i>
                        </button>',
                        ];
                    }
                }
            }

            return response()->json(['data' => $data], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }






    public function obtenerMaterialRetornable(Request $request)
    {
        try {
            $idFormulario = $request->get('id');
            $idInventario = $request->get('inventario');

            $bitacora = bitacoraModel::where('RECEMPLEADO_ID', $idFormulario)
                ->where('INVENTARIO_ID', $idInventario)
                ->where('ACTIVO', 1)
                ->first();

            if ($bitacora) {

                return response()->json([
                    'success' => true,
                    'material' => [
                        'ID_BITACORAS_ALMACEN'      => $bitacora->ID_BITACORAS_ALMACEN,
                        'SOLICITANTE_SALIDA'        => $bitacora->SOLICITANTE_SALIDA,
                        'FECHA_ALMACEN_SOLICITUD'              => $bitacora->FECHA_ALMACEN_SOLICITUD,
                        'DESCRIPCION'               => $bitacora->DESCRIPCION,
                        'CANTIDAD'                  => $bitacora->CANTIDAD,
                        'CANTIDAD_SALIDA'           => $bitacora->CANTIDAD_SALIDA,
                        'UNIDAD_SALIDA'             => $bitacora->UNIDAD_SALIDA,
                        'INVENTARIO'                => $bitacora->INVENTARIO,
                        'OBSERVACIONES_REC'         => $bitacora->OBSERVACIONES_REC,
                        'RECIBIDO_POR'              => $bitacora->RECIBIDO_POR,
                        'ENTREGADO_POR'             => $bitacora->ENTREGADO_POR,
                        'FIRMA_RECIBIDO_POR'        => $bitacora->FIRMA_RECIBIDO_POR,
                        'FIRMA_ENTREGADO_POR'       => $bitacora->FIRMA_ENTREGADO_POR,
                        'OBSERVACIONES_BITACORA'    => $bitacora->OBSERVACIONES_BITACORA,
                        'FUNCIONAMIENTO_BITACORA'   => $bitacora->FUNCIONAMIENTO_BITACORA,
                        'RETORNO_BITACORA_RETORNABLE'   => $bitacora->RETORNO_BITACORA_RETORNABLE,
                        'FIRMA_RETORNADO_POR'   => $bitacora->FIRMA_RETORNADO_POR,
                        'FIRMA_ACEPTADO_POR'   => $bitacora->FIRMA_ACEPTADO_POR,
                        'FECHA_RETORNO_BITACORA'  => $bitacora->FECHA_RETORNO_BITACORA,
                        'YA_GUARDADO'               => true        
                    ]
                ]);
            }


            $registro = recemplaedosModel::where('ID_FORMULARIO_RECURSOS_EMPLEADOS', $idFormulario)->first();

            if (!$registro) {
                return response()->json(['success' => false, 'message' => 'Registro no encontrado']);
            }

            $materiales = json_decode($registro->MATERIALES_JSON, true);
            $materialEncontrado = null;


            if (is_array($materiales)) {

                foreach ($materiales as $item) {

                    if (isset($item['INVENTARIO']) && $item['INVENTARIO'] == $idInventario) {
                        $materialEncontrado = $item;
                        break;
                    }

                    if (isset($item['VARIOS_ARTICULOS']) && $item['VARIOS_ARTICULOS'] == "1" && !empty($item['ARTICULOS'])) {

                        foreach ($item['ARTICULOS'] as $detalle) {

                            if (isset($detalle['INVENTARIO']) && $detalle['INVENTARIO'] == $idInventario) {

                                $materialEncontrado = array_merge($item, $detalle);

                                $materialEncontrado['CANTIDAD']         = $detalle['CANTIDAD_DETALLE'] ?? '';
                                $materialEncontrado['CANTIDAD_SALIDA']  = $detalle['CANTIDAD_DETALLE'] ?? '';
                                $materialEncontrado['UNIDAD_SALIDA']    = $detalle['UNIDAD_DETALLE'] ?? '';
                                $materialEncontrado['FECHA_RETORNO']    = $detalle['FECHA_DETALLE'] ?? '';

                                break 2;
                            }
                        }
                    }
                }
            }

            if (!$materialEncontrado) {
                return response()->json(['success' => false, 'message' => 'Artículo no encontrado']);
            }

            $materialEncontrado['SOLICITANTE_SALIDA'] = $registro->SOLICITANTE_SALIDA;
            $materialEncontrado['FECHA_ALMACEN_SOLICITUD']       = $registro->FECHA_ALMACEN_SOLICITUD;
            $materialEncontrado['OBSERVACIONES_REC']  = $registro->OBSERVACIONES_REC;

            $materialEncontrado['ID_BITACORAS_ALMACEN'] = 0;
            $materialEncontrado['YA_GUARDADO']          = false;


            $usuario = auth()->user();

            $materialEncontrado['ENTREGADO_POR'] =
                ($usuario->EMPLEADO_NOMBRE ?? '') . ' ' .
                ($usuario->EMPLEADO_APELLIDOPATERNO ?? '') . ' ' .
                ($usuario->EMPLEADO_APELLIDOMATERNO ?? '');

            return response()->json(['success' => true, 'material' => $materialEncontrado]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }



    public function store(Request $request)
    {
        try {

            switch (intval($request->api)) {

                case 1:

                    if ($request->ID_BITACORAS_ALMACEN == 0) {

                        DB::statement('ALTER TABLE bitacorasalmacen AUTO_INCREMENT=1;');
                        $bitacoras = bitacoraModel::create($request->all());
                    } else {

                        if (isset($request->ELIMINAR)) {

                            if ($request->ELIMINAR == 1) {

                                bitacoraModel::where('ID_BITACORAS_ALMACEN', $request->ID_BITACORAS_ALMACEN)
                                    ->update(['ACTIVO' => 0]);

                                return response()->json([
                                    'code' => 1,
                                    'bitacora' => 'Desactivada'
                                ]);
                            } else {

                                bitacoraModel::where('ID_BITACORAS_ALMACEN', $request->ID_BITACORAS_ALMACEN)
                                    ->update(['ACTIVO' => 1]);

                                return response()->json([
                                    'code' => 1,
                                    'bitacora' => 'Activada'
                                ]);
                            }
                        } else {

                            $bitacoras = bitacoraModel::find($request->ID_BITACORAS_ALMACEN);
                            $bitacoras->update($request->all());
                        }
                    }

                    if ($request->hasFile('IMAGENES_BITACORA')) {

                        foreach ($request->file('IMAGENES_BITACORA') as $index => $imagen) {

                            if (!$imagen->isValid()) continue;

                            $folder = "Bitácora_retornable/{$request->RECEMPLEADO_ID}/{$request->INVENTARIO_ID}";
                            $filename = 'img_' . time() . '_' . $index . '.' . $imagen->getClientOriginalExtension();
                            $path = $imagen->storeAs($folder, $filename);

                            DB::table('imagenes_bitacorasalmacen')->insert([
                                'RECEMPLEADO_ID' => $request->RECEMPLEADO_ID,
                                'INVENTARIO_ID'  => $request->INVENTARIO_ID,
                                'RUTA_FOTOS'     => $path,
                                'ACTIVO'         => 1,
                                'created_at'     => now(),
                                'updated_at'     => now(),
                            ]);
                        }
                    }


                    if ($request->has('IMAGENES_ELIMINADAS')) {

                        DB::table('imagenes_bitacorasalmacen')
                            ->whereIn(
                                'ID_IMAGENES_BITACORASALMACEN',
                                $request->IMAGENES_ELIMINADAS
                            )
                            ->update([
                                'ACTIVO' => 0,
                                'updated_at' => now()
                            ]);
                    }

                    return response()->json([
                        'code' => 1,
                        'bitacora' => 'Guardada correctamente'
                    ]);

                default:

                    return response()->json([
                        'code' => 0,
                        'msj' => 'Api no encontrada'
                    ]);
            }
        } catch (\Exception $e) {

            return response()->json([
                'code' => 0,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
