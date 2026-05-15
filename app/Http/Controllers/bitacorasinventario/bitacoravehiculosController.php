<?php

namespace App\Http\Controllers\bitacorasinventario;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

use DB;

use App\Models\proveedor\altaproveedorModel;
use App\Models\proveedor\proveedortempModel;
use App\Models\inventario\inventarioModel;
use App\Models\inventario\catalogotipoinventarioModel;
use App\Models\recempleados\recemplaedosModel;
use App\Models\usuario\usuarioModel;
use App\Models\bitacorasalmacen\bitacoraModel;
use App\Models\contratacion\contratacionModel;
use App\Models\bitacorasalmacen\imagenebitacoraalmacen;

class bitacoravehiculosController extends Controller
{
    public function index()
    {

        $tipoinventario = catalogotipoinventarioModel::where('ACTIVO', 1)->get();
        $proveedoresOficiales = altaproveedorModel::select('RAZON_SOCIAL_ALTA', 'RFC_ALTA')->get();
        $proveedoresTemporales = proveedortempModel::select('RAZON_PROVEEDORTEMP', 'RFC_PROVEEDORTEMP', 'NOMBRE_PROVEEDORTEMP')->get();
        $inventario = inventarioModel::where('ACTIVO', 1)->get();
        $usuarios = usuarioModel::where('ACTIVO', 1) ->where('USUARIO_TIPO', 1)->get();
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

        return view('almacen.bitacoras.bitacora_vehiculos', compact('tipoinventario', 'proveedoresOficiales', 'proveedoresTemporales', 'inventario', 'usuarios','colaboradores','proveedores'));
    }




    public function Tablabitacoravehiculos()
    {
        try {

            $tabla = recemplaedosModel::where('TIPO_SOLICITUD', 2)
                ->where('ESTADO_APROBACION', 'Aprobada')
                ->where('FINALIZAR_SOLICITUD_ALMACEN', 1)
                ->orderBy('FECHA_ALMACEN_SOLICITUD', 'asc')
                ->get();

            $data = [];
            $tiposPermitidos = ['Vehículos'];

            $fechaInicio = '2025-01-01';
            $fechaFin    = '2025-12-15';

            foreach ($tabla as $value) {

                $materiales = json_decode($value->MATERIALES_JSON, true);
                if (!is_array($materiales)) continue;

                foreach ($materiales as $articulo) {

                  
                    if (!empty($articulo['VARIOS_ARTICULOS']) && $articulo['VARIOS_ARTICULOS'] == "1") {

                        if (!empty($articulo['ARTICULOS']) && is_array($articulo['ARTICULOS'])) {

                            foreach ($articulo['ARTICULOS'] as $detalle) {

                                if (!empty($detalle['ES_ASIGNACION_DETALLE']) && $detalle['ES_ASIGNACION_DETALLE'] == 1) {
                                    continue;
                                }

                                if (
                                    empty($detalle['INVENTARIO']) ||
                                    empty($detalle['TIPO_INVENTARIO']) ||
                                    !in_array($detalle['TIPO_INVENTARIO'], $tiposPermitidos)
                                ) continue;

                              
                                $rowClass = '';
                                $fechaSolicitud = $value->FECHA_ALMACEN_SOLICITUD;

                                if ($fechaSolicitud >= $fechaInicio && $fechaSolicitud <= $fechaFin) {

                                    $rowClass = 'bg-verde-suave';
                                } elseif ($fechaSolicitud >= '2025-12-16') {

                                    $bitacora = DB::table('bitacorasalmacen')
                                        ->where('RECEMPLEADO_ID', $value->ID_FORMULARIO_RECURSOS_EMPLEADOS)
                                        ->where('INVENTARIO_ID', $detalle['INVENTARIO'])
                                        ->where('ACTIVO', 1)
                                        ->first();

                                    if ($bitacora) {
                                        if ($bitacora->RETORNO_VEHICULOS == 1) {
                                            $rowClass = 'bg-verde-suave';
                                        } elseif ($bitacora->RETORNO_VEHICULOS == 2) {
                                            $rowClass = 'bg-amarillo-suave';
                                        }
                                    }
                                }

                         
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

                                    'BTN_EDITAR' => '<button type="button"
                                    class="btn btn-warning btn-custom rounded-pill editarMaterial"
                                    data-id="' . $value->ID_FORMULARIO_RECURSOS_EMPLEADOS . '"
                                    data-inventario="' . ($detalle['INVENTARIO'] ?? '') . '">
                                    <i class="bi bi-pencil-square"></i>
                                    </button>',

                                    'BTN_VISUALIZAR' => '<button type="button"
                                    class="btn btn-primary btn-custom rounded-pill visualizarMaterial"
                                    data-id="' . $value->ID_FORMULARIO_RECURSOS_EMPLEADOS . '"
                                    data-inventario="' . ($detalle['INVENTARIO'] ?? '') . '">
                                    <i class="bi bi-eye"></i>
                                    </button>',
                                ];
                            }
                        }

                    } else {

                        if (!empty($articulo['ES_ASIGNACION']) && $articulo['ES_ASIGNACION'] == 1) {
                            continue;
                        }

                        if (
                            empty($articulo['TIPO_INVENTARIO']) ||
                            !in_array($articulo['TIPO_INVENTARIO'], $tiposPermitidos)
                        ) continue;

                    
                        $rowClass = '';
                        $fechaSolicitud = $value->FECHA_ALMACEN_SOLICITUD;

                        if ($fechaSolicitud >= $fechaInicio && $fechaSolicitud <= $fechaFin) {

                            $rowClass = 'bg-verde-suave';
                        } elseif ($fechaSolicitud >= '2025-12-16') {

                            $bitacora = DB::table('bitacorasalmacen')
                                ->where('RECEMPLEADO_ID', $value->ID_FORMULARIO_RECURSOS_EMPLEADOS)
                                ->where('INVENTARIO_ID', $articulo['INVENTARIO'])
                                ->where('ACTIVO', 1)
                                ->first();

                            if ($bitacora) {
                                if ($bitacora->RETORNO_VEHICULOS == 1) {
                                    $rowClass = 'bg-verde-suave';
                                } elseif ($bitacora->RETORNO_VEHICULOS == 2) {
                                    $rowClass = 'bg-amarillo-suave';
                                }
                            }
                        }

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

                            'BTN_EDITAR' => '<button type="button"
                            class="btn btn-warning btn-custom rounded-pill editarMaterial"
                            data-id="' . $value->ID_FORMULARIO_RECURSOS_EMPLEADOS . '"
                            data-inventario="' . ($articulo['INVENTARIO'] ?? '') . '">
                            <i class="bi bi-pencil-square"></i>
                            </button>',

                            'BTN_VISUALIZAR' => '<button type="button"
                            class="btn btn-primary btn-custom rounded-pill visualizarMaterial"
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

    public function mostrarImagenBitacora($id)
    {
        $imagen = imagenebitacoraalmacen::where('ID_IMAGENES_BITACORASALMACEN', $id)
            ->where('ACTIVO', 1)
            ->firstOrFail();

        if (!Storage::exists($imagen->RUTA_FOTOS)) {
            abort(404);
        }

        return Storage::response($imagen->RUTA_FOTOS);
    }

    public function obtenerImagenesBitacora(Request $request)
    {
        $imagenes = imagenebitacoraalmacen::where('RECEMPLEADO_ID', $request->RECEMPLEADO_ID)
            ->where('INVENTARIO_ID', $request->INVENTARIO_ID)
            ->where('ACTIVO', 1)
            ->get([
                'ID_IMAGENES_BITACORASALMACEN'
            ]);

        return response()->json($imagenes);
    }

    public function obtenerLicenciaPersona(Request $request)
    {
        $valor = $request->valor; 
        $documentosJson = null;

        $colaborador = contratacionModel::where('CURP', $valor)->first();

        if ($colaborador && $colaborador->DOCUMENTOS_JSON) {
            $documentosJson = $colaborador->DOCUMENTOS_JSON;
        }

        if (!$documentosJson) {

            $proveedor = altaproveedorModel::where('RFC_ALTA', $valor)->first();

            if ($proveedor && $proveedor->DOCUMENTOS_JSON) {
                $documentosJson = $proveedor->DOCUMENTOS_JSON;
            }
        }

        if (!$documentosJson) {
            return response()->json([
                'success' => false,
                'type'    => 'NO_DOCUMENTOS',
                'message' => 'No tiene documentos registrados'
            ]);
        }

        $documentos = json_decode($documentosJson, true);

        if (!is_array($documentos)) {
            return response()->json([
                'success' => false,
                'type'    => 'INVALIDO',
                'message' => 'Documentos inválidos'
            ]);
        }

      
        foreach ($documentos as $doc) {

            if (($doc['TIPO_DOCUMENTO_IDENTIFICACION'] ?? null) == '5') {

                $vigencia = $doc['VIGENCIA_DOCUMENTO'] ?? null;

                if (!$vigencia) {
                    break;
                }

                $fechaVigencia = Carbon::parse($vigencia)->endOfDay();
                $hoy = Carbon::now();

                if ($fechaVigencia->lt($hoy)) {
                    return response()->json([
                        'success' => false,
                        'type'    => 'VENCIDA',
                        'message' => 'La licencia está vencida'
                    ]);
                }

                return response()->json([
                    'success'  => true,
                    'numero'   => $doc['NUMERO_DOCUMENTO'] ?? '',
                    'vigencia' => $vigencia
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'type'    => 'NO_LICENCIA',
            'message' => 'No tiene licencia registrada'
        ]);
    }




    public function obtenerDatosInventarioVehiculo(Request $request)
    {
        try {

            $inventarioId = $request->get('inventario');

            $inventario = DB::table('formulario_inventario')
                ->where('ID_FORMULARIO_INVENTARIO', $inventarioId)
                ->first();

            if (!$inventario) {
                return response()->json([
                    'success' => false,
                    'message' => 'Inventario no encontrado'
                ]);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'MARCA_EQUIPO'   => $inventario->MARCA_EQUIPO ?? '',
                    'COLOR_VEHICULO'   => $inventario->COLOR_VEHICULO ?? '',
                    'PLACAS_VEHICULOS'  => $inventario->PLACAS_VEHICULOS ?? '',
                    'MODELO_EQUIPO'  => $inventario->MODELO_EQUIPO ?? '',
                    'CODIGO_EQUIPO'  => $inventario->CODIGO_EQUIPO ?? '',
                    'NUMERO_POLIZA'  => $inventario->NUMERO_POLIZA ?? '',
                    'ENTIDAD_POLIZA'  => $inventario->ENTIDAD_POLIZA ?? '',
                    'INICIOVIGENCIA_POLIZA'  => $inventario->INICIOVIGENCIA_POLIZA ?? '',
                    'FINVIGENCIA_POLIZA'  => $inventario->FINVIGENCIA_POLIZA ?? '',
                    'FRENTE_DERECHA'  => $inventario->FRENTE_DERECHA ?? '',
                    'FRENTE_IZQUIERDA'  => $inventario->FRENTE_IZQUIERDA ?? '',
                    'TRASERA_DERECHA'  => $inventario->TRASERA_DERECHA ?? '',
                    'TRASERA_IZQUIERDA'  => $inventario->TRASERA_IZQUIERDA ?? '',
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function obtenerMaterialVehiculos(Request $request)
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

                        'ID_BITACORAS_ALMACEN' => $bitacora->ID_BITACORAS_ALMACEN,
                        'YA_GUARDADO'          => true,
                        'SOLICITANTE_SALIDA'        => $bitacora->SOLICITANTE_SALIDA,
                        'FECHA_ALMACEN_SOLICITUD'  => $bitacora->FECHA_ALMACEN_SOLICITUD,
                        'DESCRIPCION'         => $bitacora->DESCRIPCION,
                        'CANTIDAD'            => $bitacora->CANTIDAD,
                        'CANTIDAD_SALIDA'     => $bitacora->CANTIDAD_SALIDA,
                        'UNIDAD_SALIDA'       => $bitacora->UNIDAD_SALIDA,
                        'INVENTARIO'          => $bitacora->INVENTARIO,
                        'OBSERVACIONES_REC'   => $bitacora->OBSERVACIONES_REC,
                        'RECIBIDO_POR'        => $bitacora->RECIBIDO_POR,
                        'ENTREGADO_POR'       => $bitacora->ENTREGADO_POR,
                        'VALIDADO_POR'        => $bitacora->VALIDADO_POR,
                        'FIRMA_RECIBIDO_POR'  => $bitacora->FIRMA_RECIBIDO_POR,
                        'FIRMA_ENTREGADO_POR' => $bitacora->FIRMA_ENTREGADO_POR,
                        'FIRMA_VALIDADO_POR'  => $bitacora->FIRMA_VALIDADO_POR,
                        'FIRMA_VERIFICADO_POR'  => $bitacora->FIRMA_VERIFICADO_POR,
                        'MARCA_VEHICULO'        => $bitacora->MARCA_VEHICULO,
                        'MANTENIMIENTO_VEHICULO'  => $bitacora->MANTENIMIENTO_VEHICULO,
                        'MODELO_VEHICULO' => $bitacora->MODELO_VEHICULO,
                        'COLOR_VEHICULO' => $bitacora->COLOR_VEHICULO,
                        'PLACAS_VEHICULO' => $bitacora->PLACAS_VEHICULO,
                        'NOINVENTARIO_VEHICULO'  => $bitacora->NOINVENTARIO_VEHICULO,
                        'NUMERO_POLIZA'  => $bitacora->NUMERO_POLIZA,
                        'ENTIDAD_POLIZA'  => $bitacora->ENTIDAD_POLIZA,
                        'INICIOVIGENCIA_POLIZA'  => $bitacora->INICIOVIGENCIA_POLIZA,
                        'FINVIGENCIA_POLIZA'  => $bitacora->FINVIGENCIA_POLIZA,
                        'NOLICENCIA_VEHICULO'  => $bitacora->NOLICENCIA_VEHICULO,
                        'FECHAVENCIMIENTO_VEHICULO' => $bitacora->FECHAVENCIMIENTO_VEHICULO,
                        'KILOMETRAJE_SALIDA_VEHICULOS' => $bitacora->KILOMETRAJE_SALIDA_VEHICULOS,
                        'COMBUSTIBLE_SALIDA_VEHICULOS'  =>$bitacora->COMBUSTIBLE_SALIDA_VEHICULOS,
                        'NOPERSONAS_VEHICULOS' => $bitacora->NOPERSONAS_VEHICULOS,
                        'HORASALIDA_VEHICULOS' => $bitacora->HORASALIDA_VEHICULOS,
                        'BOTIQUIN_PRIMEROS_AUXILIOS_VEHICULOS' => $bitacora->BOTIQUIN_PRIMEROS_AUXILIOS_VEHICULOS,
                        'KIT_SEGURIDAD_VEHICULOS' => $bitacora->KIT_SEGURIDAD_VEHICULOS,
                        'KILOMETRAJE_LLEGADA_VEHICULOS' => $bitacora->KILOMETRAJE_LLEGADA_VEHICULOS,
                        'COMBUSTIBLE_LLEGADA_VEHICULOS' => $bitacora->COMBUSTIBLE_LLEGADA_VEHICULOS,
                        'RETORNO_VEHICULOS' =>  $bitacora->RETORNO_VEHICULOS,
                        'OBS_MALETIN_VEHICULOS'  =>  $bitacora->OBS_MALETIN_VEHICULOS,
                        'OBS_FERULA_VEHICULOS' =>  $bitacora->OBS_FERULA_VEHICULOS,
                        'OBS_FACE_SHIELD_VEHICULOS' =>  $bitacora->OBS_FACE_SHIELD_VEHICULOS,
                        'OBS_TIJERAS_VEHICULOS' =>  $bitacora->OBS_TIJERAS_VEHICULOS,
                        'OBS_GASAS_10_VEHICULOS' =>  $bitacora->OBS_GASAS_10_VEHICULOS,
                        'OBS_GASAS_5_VEHICULOS' =>  $bitacora->OBS_GASAS_5_VEHICULOS,
                        'OBS_GUANTES_VEHICULOS' =>  $bitacora->OBS_GUANTES_VEHICULOS,
                        'OBS_MICROPORE_1_VEHICULOS' =>  $bitacora->OBS_MICROPORE_1_VEHICULOS,
                        'OBS_MICROPORE_2_VEHICULOS' =>  $bitacora->OBS_MICROPORE_2_VEHICULOS,
                        'OBS_VENDA_5_VEHICULOS' =>  $bitacora->OBS_VENDA_5_VEHICULOS,
                        'OBS_VENDA_10_VEHICULOS' =>  $bitacora->OBS_VENDA_10_VEHICULOS,
                        'OBS_SOLUCION_SALINA_VEHICULOS' =>  $bitacora->OBS_SOLUCION_SALINA_VEHICULOS,
                        'OBS_VENDA_TRIANGULAR_VEHICULOS' =>  $bitacora->OBS_VENDA_TRIANGULAR_VEHICULOS,
                        'OBS_MALETIN_HERRAMIENTAS_VEHICULOS' =>  $bitacora->OBS_MALETIN_HERRAMIENTAS_VEHICULOS,
                        'OBS_DESARMADOR_CRUZ_VEHICULOS' =>  $bitacora->OBS_DESARMADOR_CRUZ_VEHICULOS,
                        'OBS_DESARMADOR_PLANO_VEHICULOS' =>  $bitacora->OBS_DESARMADOR_PLANO_VEHICULOS,
                        'OBS_PINZAS_MULTIUSOS_VEHICULOS' =>  $bitacora->OBS_PINZAS_MULTIUSOS_VEHICULOS,
                        'OBS_CUERDAS_BUNGEE_VEHICULOS' =>  $bitacora->OBS_CUERDAS_BUNGEE_VEHICULOS,
                        'OBS_LONA_POLIETILENO_VEHICULOS' =>  $bitacora->OBS_LONA_POLIETILENO_VEHICULOS,
                        'OBS_GUANTES_NEOPRENO_VEHICULOS' =>  $bitacora->OBS_GUANTES_NEOPRENO_VEHICULOS,
                        'OBS_CALIBRADOR_LLANTAS_VEHICULOS' =>  $bitacora->OBS_CALIBRADOR_LLANTAS_VEHICULOS,
                        'OBS_EXTINTOR_PQS_VEHICULOS' =>  $bitacora->OBS_EXTINTOR_PQS_VEHICULOS,
                        'OBS_LINTERNA_RECARGABLE_VEHICULOS' =>  $bitacora->OBS_LINTERNA_RECARGABLE_VEHICULOS,
                        'VERIFICA_POR' => $bitacora->VERIFICA_POR,
                        'VALIDADO_POR' =>$bitacora->VALIDADO_POR,
                        'SEGUIMIENTO_VEHICULOS'          => $bitacora->SEGUIMIENTO_VEHICULOS,
                        'INSPECCION_USUARIO_VEHICULOS'   => $bitacora->INSPECCION_USUARIO_VEHICULOS,
                        'TARJETA_CIRCULACION_VEHICULOS'        => $bitacora->TARJETA_CIRCULACION_VEHICULOS,
                        'OBS_TARJETA_CIRCULACION_VEHICULOS'    => $bitacora->OBS_TARJETA_CIRCULACION_VEHICULOS,
                        'TENENCIA_VIGENTE_VEHICULOS'            => $bitacora->TENENCIA_VIGENTE_VEHICULOS,
                        'OBS_TENENCIA_VIGENTE_VEHICULOS'        => $bitacora->OBS_TENENCIA_VIGENTE_VEHICULOS,
                        'POLIZA_SEGURO_VIGENTE_VEHICULOS'       => $bitacora->POLIZA_SEGURO_VIGENTE_VEHICULOS,
                        'OBS_POLIZA_SEGURO_VIGENTE_VEHICULOS'   => $bitacora->OBS_POLIZA_SEGURO_VIGENTE_VEHICULOS,
                        'INSTRUCTIVO_MANUAL_VEHICULOS'          => $bitacora->INSTRUCTIVO_MANUAL_VEHICULOS,
                        'OBS_INSTRUCTIVO_MANUAL_VEHICULOS'      => $bitacora->OBS_INSTRUCTIVO_MANUAL_VEHICULOS,
                        'ENCENDIDO_MOTOR_VEHICULOS'              => $bitacora->ENCENDIDO_MOTOR_VEHICULOS,
                        'ACCESORIOS_CAMBIO_LLANTA_VEHICULOS'     => $bitacora->ACCESORIOS_CAMBIO_LLANTA_VEHICULOS,
                        'NIVEL_ACEITE_VEHICULOS'                 => $bitacora->NIVEL_ACEITE_VEHICULOS,
                        'REFLEJANTES_SEGURIDAD_VEHICULOS'        => $bitacora->REFLEJANTES_SEGURIDAD_VEHICULOS,
                        'FRENOS_VEHICULOS'                       => $bitacora->FRENOS_VEHICULOS,
                        'CABLE_PASA_CORRIENTE_VEHICULOS'         => $bitacora->CABLE_PASA_CORRIENTE_VEHICULOS,
                        'SISTEMA_ELECTRICO_VEHICULOS'             => $bitacora->SISTEMA_ELECTRICO_VEHICULOS,
                        'GEL_ANTIBACTERIAL_VEHICULOS'             => $bitacora->GEL_ANTIBACTERIAL_VEHICULOS,
                        'FAROS_VEHICULOS'                        => $bitacora->FAROS_VEHICULOS,
                        'ESPEJOS_VEHICULOS'                      => $bitacora->ESPEJOS_VEHICULOS,
                        'INTERMITENTES_VEHICULOS'                => $bitacora->INTERMITENTES_VEHICULOS,
                        'CRISTALES_VENTANAS_VEHICULOS'            => $bitacora->CRISTALES_VENTANAS_VEHICULOS,
                        'FUNCIONAMIENTO_LIMPIADORES_VEHICULOS'   => $bitacora->FUNCIONAMIENTO_LIMPIADORES_VEHICULOS,
                        'MANCHAS_VESTIDURAS_VEHICULOS'            => $bitacora->MANCHAS_VESTIDURAS_VEHICULOS,
                        'AGUA_LIMPIADORES_VEHICULOS'              => $bitacora->AGUA_LIMPIADORES_VEHICULOS,
                        'ASIENTOS_VEHICULOS'                     => $bitacora->ASIENTOS_VEHICULOS,
                        'MOLDURAS_DELANTERAS_VEHICULOS'           => $bitacora->MOLDURAS_DELANTERAS_VEHICULOS,
                        'CINTURONES_SEGURIDAD_VEHICULOS'          => $bitacora->CINTURONES_SEGURIDAD_VEHICULOS,
                        'MOLDURAS_TRASERAS_VEHICULOS'             => $bitacora->MOLDURAS_TRASERAS_VEHICULOS,
                        'CALCOMANIAS_LOGO_VEHICULOS'              => $bitacora->CALCOMANIAS_LOGO_VEHICULOS,
                        'LLANTAS_VEHICULOS'                       => $bitacora->LLANTAS_VEHICULOS,
                        'PASE_VEHICULAR_VEHICULOS'                => $bitacora->PASE_VEHICULAR_VEHICULOS,
                        'LLANTA_REFACCION_VEHICULOS'              => $bitacora->LLANTA_REFACCION_VEHICULOS,
                        'BRILLO_SEGURIDAD_VEHICULOS'              => $bitacora->BRILLO_SEGURIDAD_VEHICULOS,
                        'HORAREGRESO_VEHICULOS'          => $bitacora->HORAREGRESO_VEHICULOS,
                        'OBSERVACIONES_BITACORA' => $bitacora->OBSERVACIONES_BITACORA,
                        'DANIOS_UNIDAD_JSON' => $bitacora->DANIOS_UNIDAD_JSON,
                        'FRENTE_DERECHA' => $bitacora->FRENTE_DERECHA,
                        'FRENTE_IZQUIERDA' => $bitacora->FRENTE_IZQUIERDA,
                        'TRASERA_DERECHA' => $bitacora->TRASERA_DERECHA,
                        'TRASERA_IZQUIERDA' => $bitacora->TRASERA_IZQUIERDA,
                        'FRENTE_DERECHA_RADIO' => $bitacora->FRENTE_DERECHA_RADIO,
                        'FRENTE_IZQUIERDA_RADIO' => $bitacora->FRENTE_IZQUIERDA_RADIO,
                        'TRASERA_DERECHA_RADIO' => $bitacora->TRASERA_DERECHA_RADIO,
                        'TRASERA_IZQUIERDA_RADIO' => $bitacora->TRASERA_IZQUIERDA_RADIO,
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

            $materialEncontrado['VALIDADO_POR'] =
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

                            $folder = "Bitácora_vehículos/{$request->RECEMPLEADO_ID}/{$request->INVENTARIO_ID}";
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
