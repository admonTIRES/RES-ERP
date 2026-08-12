<?php

namespace App\Http\Controllers\inventariomantenimiento;


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

use App\Models\contratacion\contratacionModel;

use App\Models\inventariomantenimiento\inventariomantenimientoModel;
use App\Models\inventariomantenimiento\salidalmacenmttoModel;


class salidaalmacenmttoController extends Controller
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

        $inventariomantenimiento = inventariomantenimientoModel::where('ACTIVO', 1)->get();


        return view('mantenimiento.inventario.salidaalmacenmtto', compact('tipoinventario', 'proveedoresOficiales', 'proveedoresTemporales', 'inventario', 'colaboradores', 'proveedores', 'inventariomantenimiento'));
    }




    public function Tablasalidalmacenmtto()
    {
        try {

            $tabla = salidalmacenmttoModel::get();

            foreach ($tabla as $value) {

                if ($value->ACTIVO == 0) {

                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';

                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_SALIDA_MTTO . '"><span class="slider round"></span></label>';

                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {

                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_SALIDA_MTTO . '" checked><span class="slider round"></span></label>';

                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';

                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }

                $color = '';
                $faltan = 0;
                $totalRetornables = 0;

                if (!empty($value->MATERIALES_JSON)) {

                    $materiales = json_decode(
                        $value->MATERIALES_JSON,
                        true
                    );

                    if (is_array($materiales)) {

                        foreach ($materiales as $mat) {

                           
                            if (($mat['RETORNA_EQUIPO'] ?? '0') == '1') {

                               
                                if (($mat['VARIOS_ARTICULOS'] ?? '0') == '1') {

                                    if (!empty($mat['ARTICULOS']) && is_array($mat['ARTICULOS'])) 
                                    {

                                        foreach ($mat['ARTICULOS'] as $detalle) {

                                            
                                            $tieneDatos = (!empty($detalle['INVENTARIO']) || !empty($detalle['TIPO_INVENTARIO']) ||(!empty($detalle['CANTIDAD_DETALLE']) &&
                                                    $detalle['CANTIDAD_DETALLE'] != '0')
                                            );

                                            if ($tieneDatos) {

                                                $totalRetornables++;

                                                $retornoDetalle = isset($detalle['RETORNA_DETALLE']) ? (string) $detalle['RETORNA_DETALLE'] : '';

                                                if ($retornoDetalle != '1') {
                                                    $faltan++;
                                                }
                                            }
                                        }
                                    } else {

                                        $totalRetornables++;
                                        $faltan++;
                                    }
                                } else {

                                    $totalRetornables++;

                                    $articuloRetorno = isset($mat['ARTICULO_RETORNO']) ? (string) $mat['ARTICULO_RETORNO']: '';

                                  
                                    if ($articuloRetorno != '1') {
                                        $faltan++;
                                    }
                                }
                            }
                        }

                       
                        if ($totalRetornables > 0) {

                            if ($faltan == 0) {

                               
                                $color = 'bg-verde-suave';
                            } else {

            
                                $color = 'bg-amarillo-suave';

                    
                                if (!empty($value->FECHA_ESTIMADA_SALIDA)) {

                                    $fechaEstimada = strtotime($value->FECHA_ESTIMADA_SALIDA);

                                    $fechaHoy = strtotime(date('Y-m-d'));

                                    if ($fechaEstimada !== false && $fechaHoy >= $fechaEstimada) 
                                    {
                                        $color = 'bg-rojo-suave';
                                    }
                                }
                            }
                        } else {

                          
                            if ($value->FINALIZAR_SALIDA_ALMACEN == 1) {
                                $color = 'bg-verde-suave';
                            }
                        }
                    }
                }

                $value->COLOR_FILA = $color;
                $value->MATERIALES_PENDIENTES = $faltan;
                $value->MATERIALES_TOTAL = $totalRetornables;
                $value->MATERIALES_RETORNADOS = $totalRetornables - $faltan;

                
                if ($totalRetornables > 0) {

                    if ($faltan > 0) {

                        $value->ESTADO_RETORNO =
                            '<span class="badge bg-warning text-dark">' .'Pendiente retorno (' .($totalRetornables - $faltan) .'/' .$totalRetornables .')' .'</span>';
                    } else {

                        $value->ESTADO_RETORNO =
                            '<span class="badge bg-success">' .'Todo retornado (' .$totalRetornables .'/' .$totalRetornables .')' .'</span>';
                    }
                } else {

                    $value->ESTADO_RETORNO =
                        '<span class="badge bg-secondary">' .'No requiere retorno' .'</span>';
                }
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
        DB::beginTransaction();

        try {

            switch (intval($request->api)) {

                case 1:

                    if ($request->ID_FORMULARIO_SALIDA_MTTO == 0) {

                        DB::statement('ALTER TABLE salida_almacen_mantenimiento AUTO_INCREMENT=1;');

                        $materialesJson = is_string($request->MATERIALES_JSON)
                            ? $request->MATERIALES_JSON
                            : json_encode(
                                $request->MATERIALES_JSON,
                                JSON_UNESCAPED_UNICODE
                            );

                        $salida = salidalmacenmttoModel::create(
                            array_merge(
                                $request->all(),
                                [
                                    'USUARIO_ID'      => auth()->user()->ID_USUARIO,
                                    'MATERIALES_JSON' => $materialesJson,
                                ]
                            )
                        );
                    } else {


                        if (isset($request->ELIMINAR)) {

                            $estado = $request->ELIMINAR == 1 ? 0 : 1;

                            salidalmacenmttoModel::where('ID_FORMULARIO_SALIDA_MTTO',$request->ID_FORMULARIO_SALIDA_MTTO)->update(['ACTIVO' => $estado]);

                            DB::commit();

                            return response()->json([
                                'code'   => 1,
                                'salida' => $estado == 0 ? 'Desactivada' : 'Activada'
                            ]);
                        }

                        $salida = salidalmacenmttoModel::find($request->ID_FORMULARIO_SALIDA_MTTO);

                        if (!$salida) {

                            DB::rollBack();

                            return response()->json([
                                'code' => 0,
                                'msj'  => 'Salida no encontrada'
                            ], 404);
                        }

                        $datos = $request->all();

                        unset($datos['USUARIO_ID']);

                        if (isset($datos['MATERIALES_JSON'])) {

                            $datos['MATERIALES_JSON'] = is_string(
                                $datos['MATERIALES_JSON']
                            )
                                ? $datos['MATERIALES_JSON']
                                : json_encode(
                                    $datos['MATERIALES_JSON'],
                                    JSON_UNESCAPED_UNICODE
                                );
                        }

                        $salida->update($datos);
                    }

                
                    $salida = salidalmacenmttoModel::find($salida->ID_FORMULARIO_SALIDA_MTTO);

                    $salidaId = $salida->ID_FORMULARIO_SALIDA_MTTO;
                    $usuarioId = auth()->user()->ID_USUARIO;

                    $materiales = json_decode($salida->MATERIALES_JSON,true);

                    if (!is_array($materiales)) {

                        DB::rollBack();

                        return response()->json([
                            'code' => 0,
                            'msj'  => 'El JSON de materiales no es válido'
                        ], 422);
                    }

                   
                    $salidasAgrupadas = [];

                    foreach ($materiales as $material) {

                       
                        if (!empty($material['VARIOS_ARTICULOS']) && $material['VARIOS_ARTICULOS'] == '1' && isset($material['ARTICULOS']) && is_array($material['ARTICULOS'])) 
                        {

                            foreach ($material['ARTICULOS'] as $articulo) {

                                $inventarioId = isset($articulo['INVENTARIO'])
                                    ? intval($articulo['INVENTARIO'])
                                    : 0;

                                $cantidad = isset($articulo['CANTIDAD_DETALLE'])
                                    ? floatval($articulo['CANTIDAD_DETALLE'])
                                    : 0;

                                $unidad = isset($articulo['UNIDAD_DETALLE'])
                                    ? $articulo['UNIDAD_DETALLE']
                                    : null;

                                if ($inventarioId <= 0 || $cantidad <= 0) {
                                    continue;
                                }

                                if (!isset($salidasAgrupadas[$inventarioId])) {

                                    $salidasAgrupadas[$inventarioId] = [
                                        'INVENTARIO_ID'   => $inventarioId,
                                        'CANTIDAD_SALIDA' => 0,
                                        'UNIDAD_MEDIDA'   => $unidad
                                    ];
                                }

                                $salidasAgrupadas[$inventarioId]['CANTIDAD_SALIDA'] += $cantidad;

                                if (empty($salidasAgrupadas[$inventarioId]['UNIDAD_MEDIDA']) && !empty($unidad)) 
                                {
                                    $salidasAgrupadas[$inventarioId]['UNIDAD_MEDIDA'] = $unidad;
                                }
                            }
                        } else {

                            $inventarioId = isset($material['INVENTARIO'])
                                ? intval($material['INVENTARIO'])
                                : 0;

                            $cantidad = isset($material['CANTIDAD_SALIDA'])
                                ? floatval($material['CANTIDAD_SALIDA'])
                                : 0;

                            $unidad = isset($material['UNIDAD_SALIDA'])
                                ? $material['UNIDAD_SALIDA']
                                : null;

                            if ($inventarioId <= 0 || $cantidad <= 0) {
                                continue;
                            }

                            if (!isset($salidasAgrupadas[$inventarioId])) {

                                $salidasAgrupadas[$inventarioId] = [
                                    'INVENTARIO_ID'   => $inventarioId,
                                    'CANTIDAD_SALIDA' => 0,
                                    'UNIDAD_MEDIDA'   => $unidad
                                ];
                            }

                            $salidasAgrupadas[$inventarioId]['CANTIDAD_SALIDA'] += $cantidad;

                            if (empty($salidasAgrupadas[$inventarioId]['UNIDAD_MEDIDA']) && !empty($unidad)) 
                            {
                                $salidasAgrupadas[$inventarioId]['UNIDAD_MEDIDA'] = $unidad;
                            }
                        }
                    }

                    foreach ($salidasAgrupadas as $movimiento) {

                        $movimientoYaRegistrado = DB::table('salidas_inventario_mantenimiento')
                            ->where('SALIDA_ID', $salidaId)
                            ->where('INVENTARIO_ID',$movimiento['INVENTARIO_ID'])
                            ->exists();

                        if ($movimientoYaRegistrado) {
                            continue;
                        }

                        $inventario = inventariomantenimientoModel::where('ID_FORMULARIO_INVENTARIO_MANTENIMIENTO',$movimiento['INVENTARIO_ID'])
                            ->lockForUpdate()
                            ->first();

                        if (!$inventario) {

                            DB::rollBack();

                            return response()->json([
                                'code' => 0,
                                'msj'  => 'Uno de los artículos no existe en el inventario del taller'
                            ], 422);
                        }

                        $stockActual = floatval($inventario->CANTIDAD_EQUIPO);

                        $cantidadSalida = floatval($movimiento['CANTIDAD_SALIDA']);

                        if ($cantidadSalida > $stockActual) {

                            DB::rollBack();

                            return response()->json([
                                'code' => 0,
                                'msj'  => 'No hay suficiente existencia para el artículo ' .$inventario->DESCRIPCION_EQUIPO .'. Disponible: ' .$stockActual .'. Cantidad de salida: ' .$cantidadSalida
                            ], 422);
                        }
                    }

                    
                    foreach ($salidasAgrupadas as $movimiento) {

                        
                        $movimientoYaRegistrado = DB::table('salidas_inventario_mantenimiento')
                            ->where('SALIDA_ID', $salidaId)
                            ->where('INVENTARIO_ID',$movimiento['INVENTARIO_ID'])
                            ->exists();

                        if ($movimientoYaRegistrado) {
                            continue;
                        }

                        $inventario = inventariomantenimientoModel::where('ID_FORMULARIO_INVENTARIO_MANTENIMIENTO',$movimiento['INVENTARIO_ID'])
                            ->lockForUpdate()
                            ->first();

                        if (!$inventario) {
                            continue;
                        }

                        $cantidadSalida = floatval(
                            $movimiento['CANTIDAD_SALIDA']
                        );

                        DB::table(
                            'salidas_inventario_mantenimiento'
                        )->insert([
                            'USUARIO_ID'          => $usuarioId,
                            'INVENTARIO_ID'       => $movimiento['INVENTARIO_ID'],
                            'FECHA_SALIDA'        => $salida->FECHA_SALIDA,
                            'CANTIDAD_SALIDA'     => $cantidadSalida,
                            'UNIDAD_MEDIDA'       => $movimiento['UNIDAD_MEDIDA'],
                            'SALIDA_ASIGNACIONES' => null,
                            'USUARIO_ASIGNACION'  => null,
                            'SALIDA_ID'           => $salidaId,
                            'created_at'          => now(),
                            'updated_at'          => now()
                        ]);

                        $inventario->CANTIDAD_EQUIPO =
                            floatval($inventario->CANTIDAD_EQUIPO) -
                            $cantidadSalida;

                        $inventario->save();
                    }

                  
                    $retornosAgrupados = [];

                    foreach ($materiales as $material) {

                       
                        if (!empty($material['VARIOS_ARTICULOS']) && $material['VARIOS_ARTICULOS'] == '1' && isset($material['ARTICULOS']) && is_array($material['ARTICULOS'])) 
                        {

                            foreach ($material['ARTICULOS'] as $articulo) {

                                if (!isset($articulo['RETORNA_DETALLE']) || $articulo['RETORNA_DETALLE'] != '1') 
                                {
                                    continue;
                                }

                                $inventarioId = isset($articulo['INVENTARIO'])
                                    ? intval($articulo['INVENTARIO'])
                                    : 0;

                                $cantidadRetorno = isset(
                                    $articulo['CANTIDAD_RETORNO_DETALLE']
                                )
                                    ? floatval(
                                        $articulo['CANTIDAD_RETORNO_DETALLE']
                                    )
                                    : 0;

                                $fechaRetorno = isset($articulo['FECHA_DETALLE'])
                                    ? $articulo['FECHA_DETALLE']
                                    : null;

                                $unidad = isset($articulo['UNIDAD_DETALLE'])
                                    ? $articulo['UNIDAD_DETALLE']
                                    : null;

                                if (
                                    $inventarioId <= 0 ||
                                    $cantidadRetorno <= 0 ||
                                    empty($fechaRetorno)
                                ) {
                                    continue;
                                }

                                $clave =
                                    $inventarioId .
                                    '|' .
                                    $fechaRetorno .
                                    '|' .
                                    $unidad;

                                if (!isset($retornosAgrupados[$clave])) {

                                    $retornosAgrupados[$clave] = [
                                        'INVENTARIO_ID'     => $inventarioId,
                                        'FECHA_INGRESO'     => $fechaRetorno,
                                        'CANTIDAD_PRODUCTO' => 0,
                                        'UNIDAD_MEDIDA'     => $unidad
                                    ];
                                }

                                $retornosAgrupados[$clave]['CANTIDAD_PRODUCTO'] += $cantidadRetorno;
                            }
                        } else {

                           
                            if (
                                !isset($material['ARTICULO_RETORNO']) ||
                                $material['ARTICULO_RETORNO'] != '1'
                            ) {
                                continue;
                            }

                            $inventarioId = isset($material['INVENTARIO'])
                                ? intval($material['INVENTARIO'])
                                : 0;

                            $cantidadRetorno = isset(
                                $material['CANTIDAD_RETORNO']
                            )
                                ? floatval($material['CANTIDAD_RETORNO'])
                                : 0;

                            $fechaRetorno = isset($material['FECHA_RETORNO'])
                                ? $material['FECHA_RETORNO']
                                : null;

                            $unidad = isset($material['UNIDAD_SALIDA'])
                                ? $material['UNIDAD_SALIDA']
                                : null;

                            if (
                                $inventarioId <= 0 ||
                                $cantidadRetorno <= 0 ||
                                empty($fechaRetorno)
                            ) {
                                continue;
                            }

                            $clave =
                                $inventarioId .
                                '|' .
                                $fechaRetorno .
                                '|' .
                                $unidad;

                            if (!isset($retornosAgrupados[$clave])) {

                                $retornosAgrupados[$clave] = [
                                    'INVENTARIO_ID'     => $inventarioId,
                                    'FECHA_INGRESO'     => $fechaRetorno,
                                    'CANTIDAD_PRODUCTO' => 0,
                                    'UNIDAD_MEDIDA'     => $unidad
                                ];
                            }

                            $retornosAgrupados[$clave]['CANTIDAD_PRODUCTO'] += $cantidadRetorno;
                        }
                    }

                  
                    foreach ($retornosAgrupados as $retorno) {

                        $cantidadYaRegistrada = DB::table('entradas_inventario_mantenimiento')
                            ->where('SALIDA_ID', $salidaId)
                            ->where('INVENTARIO_ID', $retorno['INVENTARIO_ID'])
                            ->whereDate('FECHA_INGRESO', $retorno['FECHA_INGRESO'])
                            ->sum('CANTIDAD_PRODUCTO');

                        $cantidadYaRegistrada = floatval($cantidadYaRegistrada);

                        $cantidadRetorno = floatval($retorno['CANTIDAD_PRODUCTO']);

                        
                        if ($cantidadRetorno <= $cantidadYaRegistrada) {
                            continue;
                        }


                        $cantidadPendiente = $cantidadRetorno - $cantidadYaRegistrada;

                        $cantidadTotalSalida = DB::table('salidas_inventario_mantenimiento')
                            ->where('SALIDA_ID', $salidaId)
                            ->where('INVENTARIO_ID',$retorno['INVENTARIO_ID'])
                            ->sum('CANTIDAD_SALIDA');

                        $cantidadTotalRetornada = DB::table('entradas_inventario_mantenimiento')
                            ->where('SALIDA_ID', $salidaId)
                            ->where('INVENTARIO_ID',$retorno['INVENTARIO_ID'])
                            ->sum('CANTIDAD_PRODUCTO');

                        $cantidadTotalSalida = floatval($cantidadTotalSalida);

                        $cantidadTotalRetornada = floatval($cantidadTotalRetornada);

                    
                        if ($cantidadTotalRetornada + $cantidadPendiente > $cantidadTotalSalida) 
                        {

                            DB::rollBack();

                            return response()->json([
                                'code' => 0,
                                'msj'  => 'La cantidad que intenta retornar es mayor a la cantidad que salió del inventario'
                            ], 422);
                        }

                        $inventario = inventariomantenimientoModel::where('ID_FORMULARIO_INVENTARIO_MANTENIMIENTO',$retorno['INVENTARIO_ID'])
                            ->lockForUpdate()
                            ->first();

                        if (!$inventario) {

                            DB::rollBack();

                            return response()->json([
                                'code' => 0,
                                'msj'  => 'No se encontró el artículo que intenta retornar'
                            ], 422);
                        }

                        DB::table('entradas_inventario_mantenimiento')->insert([
                            'INVENTARIO_ID'     => $retorno['INVENTARIO_ID'],
                            'FECHA_INGRESO'     => $retorno['FECHA_INGRESO'],
                            'CANTIDAD_PRODUCTO' => $cantidadPendiente,
                            'VALOR_UNITARIO'    => null,
                            'COSTO_TOTAL'       => null,
                            'UNIDAD_MEDIDA'     => $retorno['UNIDAD_MEDIDA'],
                            'USUARIO_ID'        => $usuarioId,
                            'ENTRADA_SOLICITUD' => 1,
                            'ENTRA_ASIGNACION'  => null,
                            'SALIDA_ID'         => $salidaId,
                            'created_at'        => now(),
                            'updated_at'        => now()
                        ]);

                        $inventario->CANTIDAD_EQUIPO = floatval($inventario->CANTIDAD_EQUIPO) + $cantidadPendiente;
                        $inventario->save();
                    }

                    DB::commit();

                    $salida = salidalmacenmttoModel::find($salidaId);

                    return response()->json([
                        'code'   => 1,
                        'salida' => $salida
                    ]);

                    break;

                default:

                    DB::rollBack();

                    return response()->json([
                        'code' => 1,
                        'msj'  => 'Api no encontrada'
                    ]);
            }
        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Error al guardar salida del inventario del taller: ' .$e->getMessage());

            return response()->json([
                'code'  => 0,
                'error' => 'Error al guardar la salida',
                'msj'   => $e->getMessage()
            ], 500);
        }
    }


}
