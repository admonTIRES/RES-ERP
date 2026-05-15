<?php

namespace App\Http\Controllers\inventario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

//Recursos para abrir el Excel
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;


use App\Models\inventario\inventarioModel;
use App\Models\inventario\catalogotipoinventarioModel;
use App\Models\inventario\documentosarticulosModel;
use App\Models\inventario\entradasinventarioModel;
use App\Models\proveedor\altaproveedorModel;
use App\Models\proveedor\proveedortempModel;
use App\Models\inventario\detallearticuloModel;

use DB;

class inventarioController extends Controller
{


    public function index()
    {
        $tipoinventario = catalogotipoinventarioModel::where('ACTIVO', 1)->get();


        $proveedoresOficiales = altaproveedorModel::select('RAZON_SOCIAL_ALTA', 'RFC_ALTA')->get();
        $proveedoresTemporales = proveedortempModel::select('RAZON_PROVEEDORTEMP', 'RFC_PROVEEDORTEMP', 'NOMBRE_PROVEEDORTEMP')->get();


        $ubicacioninventario = inventarioModel::select('UBICACION_EQUIPO')
            ->distinct()
            ->orderBy('UBICACION_EQUIPO')
            ->get();


        return view('almacen.inventario.inventario', compact('tipoinventario', 'proveedoresOficiales', 'proveedoresTemporales', 'ubicacioninventario'));
    }

    public function indexinactivo()
    {
        $tipoinventario = catalogotipoinventarioModel::where('ACTIVO', 1)->get();


        $proveedoresOficiales = altaproveedorModel::select('RAZON_SOCIAL_ALTA', 'RFC_ALTA')->get();
        $proveedoresTemporales = proveedortempModel::select('RAZON_PROVEEDORTEMP', 'RFC_PROVEEDORTEMP', 'NOMBRE_PROVEEDORTEMP')->get();


        $ubicacioninventario = inventarioModel::select('UBICACION_EQUIPO')
            ->distinct()
            ->orderBy('UBICACION_EQUIPO')
            ->get();


        return view('almacen.inventario.inventarioinactivo', compact('tipoinventario', 'proveedoresOficiales', 'proveedoresTemporales', 'ubicacioninventario'));
    }


    // public function Tablainventario(Request $request)
    // {
    //     try {

    //         $query = inventarioModel::query()
    //             ->where(function ($q) {
    //                 $q->where('ES_INFRAESTRUCTURA', '!=', 1)
    //                     ->orWhereNull('ES_INFRAESTRUCTURA');
    //             });

    //         if ($request->filled('UBICACION_EQUIPO')) {
    //             $query->where('UBICACION_EQUIPO', $request->UBICACION_EQUIPO);
    //         }

    //         $tabla = $query->get();

    //         foreach ($tabla as $value) {

    //             if ($value->ACTIVO == 0) {
    //                 $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
    //                 $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_INVENTARIO . '"><span class="slider round"></span></label>';
    //                 $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
    //             } else {
    //                 $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_INVENTARIO . '" checked><span class="slider round"></span></label>';
    //                 $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
    //                 $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
    //             }

    //             $value->FOTO_EQUIPO_HTML = '<img src="/equipofoto/' . $value->ID_FORMULARIO_INVENTARIO . '" alt="Foto" class="img-fluid" width="50" height="60">';

    //             $campos = [
    //                 'DESCRIPCION_EQUIPO',
    //                 'MARCA_EQUIPO',
    //                 'MODELO_EQUIPO',
    //                 'SERIE_EQUIPO',
    //                 'CODIGO_EQUIPO',
    //                 'CANTIDAD_EQUIPO',
    //                 'UBICACION_EQUIPO',
    //                 'ESTADO_EQUIPO',
    //                 'FECHA_ADQUISICION',
    //                 'UNITARIO_EQUIPO',
    //                 'TOTAL_EQUIPO',
    //                 'TIPO_EQUIPO',
    //                 'OBSERVACION_EQUIPO',
    //                 'FOTO_EQUIPO',
    //                 'UNIDAD_MEDIDA',
    //                 'ITEM_CRITICO',
    //                 'PROVEEDOR_ALTA',
    //                 'REQUIERE_ARTICULO'
    //             ];

    //             $completo = true;
    //             foreach ($campos as $campo) {
    //                 if (empty($value->$campo)) {
    //                     $completo = false;
    //                     break;
    //                 }
    //             }

    //             if (!is_null($value->LIMITEMINIMO_EQUIPO) && $value->LIMITEMINIMO_EQUIPO !== '') {
    //                 $cantidad = (float)$value->CANTIDAD_EQUIPO;
    //                 $minimo = (float)$value->LIMITEMINIMO_EQUIPO;

    //                 if ($cantidad <= $minimo) {
    //                     $value->ROW_CLASS = 'bg-amarrillo-suave';
    //                 } else {
    //                     $value->ROW_CLASS = $completo ? 'bg-verde-suave' : 'bg-rojo-suave';
    //                 }
    //             } else {
    //                 $value->ROW_CLASS = $completo ? 'bg-verde-suave' : 'bg-rojo-suave';
    //             }


    //             if ($value->ASIGNADO == 1) {
    //                 $value->ROW_CLASS = 'bg-naranja-suave';
    //             }


    //         }

    //         // Respuesta
    //         return response()->json([
    //             'data' => $tabla,
    //             'msj' => 'Información consultada correctamente'
    //         ]);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'msj' => 'Error ' . $e->getMessage(),
    //             'data' => 0
    //         ]);
    //     }
    // }


    public function metricasInventario(Request $request)
    {
        try {

            $query = inventarioModel::query()
                ->where(function ($q) {
                    $q->where('ES_INFRAESTRUCTURA', '!=', 1)
                        ->orWhereNull('ES_INFRAESTRUCTURA');
                });

            if ($request->filled('UBICACION_EQUIPO')) {
                $query->where('UBICACION_EQUIPO', $request->UBICACION_EQUIPO);
            }

            $data = $query->get();

            $conteo = [
                'verde' => 0,
                'rojo' => 0,
                'amarillo' => 0,
                'naranja' => 0,
                'azul' => 0,
                'total' => 0
            ];

            foreach ($data as $value) {

                $campos = [
                    'DESCRIPCION_EQUIPO',
                    'MARCA_EQUIPO',
                    'MODELO_EQUIPO',
                    'SERIE_EQUIPO',
                    'CODIGO_EQUIPO',
                    'CANTIDAD_EQUIPO',
                    'UBICACION_EQUIPO',
                    'ESTADO_EQUIPO',
                    'FECHA_ADQUISICION',
                    'UNITARIO_EQUIPO',
                    'TOTAL_EQUIPO',
                    'TIPO_EQUIPO',
                    'OBSERVACION_EQUIPO',
                    'FOTO_EQUIPO',
                    'UNIDAD_MEDIDA',
                    'ITEM_CRITICO',
                    'PROVEEDOR_ALTA',
                    'REQUIERE_ARTICULO',
                    'LIMITEMINIMO_EQUIPO',
                    'DETALLAR_ARTICULOS'
                ];

                $completo = true;
                foreach ($campos as $campo) {
                    if (!isset($value->$campo) || $value->$campo === '') {
                        $completo = false;
                        break;
                    }
                }

                $cantidad = (float)$value->CANTIDAD_EQUIPO;
                $minimo = (float)$value->LIMITEMINIMO_EQUIPO;
                $tieneMinimo = (!is_null($value->LIMITEMINIMO_EQUIPO) && $value->LIMITEMINIMO_EQUIPO !== '' && $minimo > 0);

                if ($value->ASIGNADO == 1) {
                    $conteo['naranja']++;
                } elseif ($tieneMinimo && $cantidad <= $minimo) {
                    $conteo['amarillo']++;
                } elseif ($cantidad == 0) {
                    $conteo[$completo ? 'rojo' : 'azul']++;
                } else {
                    $conteo[$completo ? 'verde' : 'azul']++;
                }

                $conteo['total']++;
            }

            foreach ($conteo as $key => $val) {
                if ($key !== 'total') {
                    $conteo[$key . '_porcentaje'] = $conteo['total'] > 0
                        ? round(($val / $conteo['total']) * 100, 2)
                        : 0;
                }
            }

            return response()->json($conteo);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function Tablainventario(Request $request)
    {
        try {

            $query = inventarioModel::query()
                ->where(function ($q) {
                    $q->where('ES_INFRAESTRUCTURA', '!=', 1)
                        ->orWhereNull('ES_INFRAESTRUCTURA');
                });

            if ($request->filled('UBICACION_EQUIPO')) {
                $query->where('UBICACION_EQUIPO', $request->UBICACION_EQUIPO);
            }

            $tabla = $query->get();

            foreach ($tabla as $value) {

                // BOTONES
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_INVENTARIO . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_INVENTARIO . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }

                $value->FOTO_EQUIPO_HTML = '<img src="/equipofoto/' . $value->ID_FORMULARIO_INVENTARIO . '" class="img-fluid" width="50" height="60">';

                // CAMPOS
                $campos = [
                    'DESCRIPCION_EQUIPO',
                    'MARCA_EQUIPO',
                    'MODELO_EQUIPO',
                    'SERIE_EQUIPO',
                    'CODIGO_EQUIPO',
                    'CANTIDAD_EQUIPO',
                    'UBICACION_EQUIPO',
                    'ESTADO_EQUIPO',
                    'FECHA_ADQUISICION',
                    'UNITARIO_EQUIPO',
                    'TOTAL_EQUIPO',
                    'TIPO_EQUIPO',
                    'OBSERVACION_EQUIPO',
                    'FOTO_EQUIPO',
                    'UNIDAD_MEDIDA',
                    'ITEM_CRITICO',
                    'PROVEEDOR_ALTA',
                    'REQUIERE_ARTICULO',
                    'LIMITEMINIMO_EQUIPO',
                    'DETALLAR_ARTICULOS'
                ];

                $completo = true;
                foreach ($campos as $campo) {
                    if (!isset($value->$campo) || $value->$campo === '') {
                        $completo = false;
                        break;
                    }
                }

                $cantidad = (float)$value->CANTIDAD_EQUIPO;
                $minimo = (float)$value->LIMITEMINIMO_EQUIPO;
                $tieneMinimo = (!is_null($value->LIMITEMINIMO_EQUIPO) && $value->LIMITEMINIMO_EQUIPO !== '' && $minimo > 0);


                if ($value->ASIGNADO == 1) {
                    $value->ROW_CLASS = 'bg-naranja-suave';
                }

                elseif ($tieneMinimo && $cantidad <= $minimo) {
                    $value->ROW_CLASS = 'bg-amarrillo-suave';
                }

                elseif ($cantidad == 0) {
                    $value->ROW_CLASS = $completo ? 'bg-rojo-suave' : 'bg-azul-suave';
                }

                else {
                    $value->ROW_CLASS = $completo ? 'bg-verde-suave' : 'bg-azul-suave';
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

    public function Tablainventarioinactivo(Request $request)
    {
        try {

            // $query = inventarioModel::query()
            //     ->where(function ($q) {
            //         $q->where('ES_INFRAESTRUCTURA', '!=', 1)
            //             ->orWhereNull('ES_INFRAESTRUCTURA');
            //     });

            $query = inventarioModel::query()
                ->where('ACTIVO', 0)
                ->where(function ($q) {
                    $q->where('ES_INFRAESTRUCTURA', '!=', 1)
                        ->orWhereNull('ES_INFRAESTRUCTURA');
                });


            if ($request->filled('UBICACION_EQUIPO')) {
                $query->where('UBICACION_EQUIPO', $request->UBICACION_EQUIPO);
            }

            $tabla = $query->get();

            foreach ($tabla as $value) {

                // BOTONES
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_INVENTARIO . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_INVENTARIO . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }

                $value->FOTO_EQUIPO_HTML = '<img src="/equipofoto/' . $value->ID_FORMULARIO_INVENTARIO . '" class="img-fluid" width="50" height="60">';

                // CAMPOS
                $campos = [
                    'DESCRIPCION_EQUIPO',
                    'MARCA_EQUIPO',
                    'MODELO_EQUIPO',
                    'SERIE_EQUIPO',
                    'CODIGO_EQUIPO',
                    'CANTIDAD_EQUIPO',
                    'UBICACION_EQUIPO',
                    'ESTADO_EQUIPO',
                    'FECHA_ADQUISICION',
                    'UNITARIO_EQUIPO',
                    'TOTAL_EQUIPO',
                    'TIPO_EQUIPO',
                    'OBSERVACION_EQUIPO',
                    'FOTO_EQUIPO',
                    'UNIDAD_MEDIDA',
                    'ITEM_CRITICO',
                    'PROVEEDOR_ALTA',
                    'REQUIERE_ARTICULO',
                    'LIMITEMINIMO_EQUIPO',
                    'DETALLAR_ARTICULOS'
                ];

                $completo = true;
                foreach ($campos as $campo) {
                    if (!isset($value->$campo) || $value->$campo === '') {
                        $completo = false;
                        break;
                    }
                }

                $cantidad = (float)$value->CANTIDAD_EQUIPO;
                $minimo = (float)$value->LIMITEMINIMO_EQUIPO;
                $tieneMinimo = (!is_null($value->LIMITEMINIMO_EQUIPO) && $value->LIMITEMINIMO_EQUIPO !== '' && $minimo > 0);


                if ($value->ASIGNADO == 1) {
                    $value->ROW_CLASS = 'bg-naranja-suave';
                } elseif ($tieneMinimo && $cantidad <= $minimo) {
                    $value->ROW_CLASS = 'bg-amarrillo-suave';
                } elseif ($cantidad == 0) {
                    $value->ROW_CLASS = $completo ? 'bg-rojo-suave' : 'bg-azul-suave';
                } else {
                    $value->ROW_CLASS = $completo ? 'bg-verde-suave' : 'bg-azul-suave';
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


    public function generarCodigoAF()
    {
        try {
            $anio_actual = date('y'); 

         
            $ultimo = DB::table('formulario_inventario')
                ->where('CODIGO_EQUIPO', 'REGEXP', '^AFR[0-9]{5}[0-9]{2}$')
                ->orderByRaw('CAST(SUBSTRING(CODIGO_EQUIPO, 4, 5) AS UNSIGNED) DESC')
                ->first();

            if ($ultimo) {
                $consecutivo = (int) substr($ultimo->CODIGO_EQUIPO, 3, 5) + 1;
            } else {
                $consecutivo = 1;
            }

            $codigo_nuevo = 'AFR'
                . str_pad($consecutivo, 5, '0', STR_PAD_LEFT)
                . $anio_actual;

            return response()->json([
                'codigo' => $codigo_nuevo,
                'msj' => 'Código generado correctamente'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'codigo' => null,
                'msj' => 'Error: ' . $e->getMessage()
            ]);
        }
    }


    public function generarCodigoANF()
    {
        try {
            $ultimo = DB::table('formulario_inventario')
                ->where('CODIGO_EQUIPO', 'like', 'AFN/A%')
                ->orderByRaw("CAST(SUBSTRING(CODIGO_EQUIPO, 7) AS UNSIGNED) DESC")
                ->first();

            if ($ultimo) {
                preg_match('/AFN\/A(\d+)/', $ultimo->CODIGO_EQUIPO, $matches);
                $consecutivo = isset($matches[1]) ? intval($matches[1]) + 1 : 1;
            } else {
                $consecutivo = 1;
            }

          
            $codigoNuevo = 'AFN/A' . str_pad($consecutivo, 4, '0', STR_PAD_LEFT);

            return response()->json([
                'codigo' => $codigoNuevo,
                'msj' => 'Código ANF generado correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'codigo' => null,
                'msj' => 'Error: ' . $e->getMessage()
            ]);
        }
    }



    public function cantidadEquipoReadonly()
    {
        return response()->json([
            'readonly' => Auth::user()->ID_USUARIO == 10
        ]);
    }





    public function mostrarFotoEquipo($usuario_id)
    {
        $foto = inventarioModel::findOrFail($usuario_id);
        return Storage::response($foto->FOTO_EQUIPO);
    }



    public function respaldarInventario()
    {
        try {
            $inventarios = DB::table('formulario_inventario')->get();

            foreach ($inventarios as $inv) {
                DB::table('inventario_respaldo')->insert([
                    'INVENTARIO_ID'       => $inv->ID_FORMULARIO_INVENTARIO, 
                    'FOTO_EQUIPO'         => $inv->FOTO_EQUIPO,
                    'DESCRIPCION_EQUIPO'  => $inv->DESCRIPCION_EQUIPO,
                    'MARCA_EQUIPO'        => $inv->MARCA_EQUIPO,
                    'MODELO_EQUIPO'       => $inv->MODELO_EQUIPO,
                    'SERIE_EQUIPO'        => $inv->SERIE_EQUIPO,
                    'CODIGO_EQUIPO'       => $inv->CODIGO_EQUIPO,
                    'CANTIDAD_EQUIPO'     => $inv->CANTIDAD_EQUIPO,
                    'UBICACION_EQUIPO'    => $inv->UBICACION_EQUIPO,
                    'ESTADO_EQUIPO'       => $inv->ESTADO_EQUIPO,
                    'FECHA_ADQUISICION'   => $inv->FECHA_ADQUISICION,
                    'PROVEEDOR_EQUIPO'    => $inv->PROVEEDOR_EQUIPO,
                    'UNITARIO_EQUIPO'     => $inv->UNITARIO_EQUIPO,
                    'TOTAL_EQUIPO'        => $inv->TOTAL_EQUIPO,
                    'TIPO_EQUIPO'         => $inv->TIPO_EQUIPO,
                    'ACTIVO'              => $inv->ACTIVO,
                    'OBSERVACION_EQUIPO'  => $inv->OBSERVACION_EQUIPO,
                    'created_at'          => now(),
                    'updated_at'          => now(),
                ]);
            }

            return response()->json(['message' => 'Respaldo realizado con éxito.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al respaldar: ' . $e->getMessage()], 500);
        }
    }



    /////////////////////////////////// ENTRADA INVENTARIO /////////////////////////////////// 


    public function Tablaentradainventario(Request $request)
    {
        try {
            $inventarioId = $request->get('inventario');
            $data = [];
            $primerEntradaId = null;

            // =========================
            // 1. Saldo inicial
            // =========================
            $saldoInicial = DB::table('inventario_respaldo')
                ->where('INVENTARIO_ID', $inventarioId)
                ->first(['CANTIDAD_EQUIPO', 'FECHA_ADQUISICION', 'UNITARIO_EQUIPO']);

            if ($saldoInicial) {
                $data[] = [
                    'ORDEN_PRIORIDAD' => 0,
                    'FECHA'          => $saldoInicial->FECHA_ADQUISICION,
                    'FECHA_ORDEN'    => $saldoInicial->FECHA_ADQUISICION,
                    'CANTIDAD'       => $saldoInicial->CANTIDAD_EQUIPO,
                    'VALOR_UNITARIO' => $saldoInicial->UNITARIO_EQUIPO,
                    'COSTO_TOTAL'    => $saldoInicial->CANTIDAD_EQUIPO * $saldoInicial->UNITARIO_EQUIPO,
                    'TIPO'           => '<span class="badge bg-warning text-dark">Saldo inicial</span>',
                    'USUARIO'        => '',
                    'BTN_EDITAR'     => '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>',
                    'BTN_VISUALIZAR' => '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>'
                ];
            } else {
                $primerEntrada = DB::table('entradas_inventario')
                    ->where('INVENTARIO_ID', $inventarioId)
                    ->orderBy('FECHA_INGRESO', 'asc')
                    ->first();

                if ($primerEntrada) {
                    $primerEntradaId = $primerEntrada->ID_ENTRADA_FORMULARIO;

                    $data[] = [
                        'ORDEN_PRIORIDAD' => 0,
                        'FECHA'          => $primerEntrada->FECHA_INGRESO,
                        'FECHA_ORDEN'    => $primerEntrada->FECHA_INGRESO,
                        'CANTIDAD'       => $primerEntrada->CANTIDAD_PRODUCTO . ($primerEntrada->UNIDAD_MEDIDA ? " ({$primerEntrada->UNIDAD_MEDIDA})" : ""),
                        'VALOR_UNITARIO' => $primerEntrada->VALOR_UNITARIO,
                        'COSTO_TOTAL'    => $primerEntrada->CANTIDAD_PRODUCTO * $primerEntrada->VALOR_UNITARIO,
                        'TIPO'           => '<span class="badge bg-warning text-dark">Saldo inicial</span>',
                        'USUARIO'        => '',
                        'BTN_EDITAR'     => '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>',
                        'BTN_VISUALIZAR' => '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>'
                    ];
                }
            }

            // =========================
            // 2. Entradas
            // =========================
            $entradasQuery = DB::table('entradas_inventario as e')
                ->leftJoin('usuarios as u', 'u.ID_USUARIO', '=', 'e.USUARIO_ID')
                ->where('e.INVENTARIO_ID', $inventarioId);

            if ($primerEntradaId) {
                $entradasQuery->where('e.ID_ENTRADA_FORMULARIO', '!=', $primerEntradaId);
            }

            $entradas = $entradasQuery->get([
                'e.FECHA_INGRESO',
                'e.CANTIDAD_PRODUCTO',
                'e.UNIDAD_MEDIDA',
                'e.VALOR_UNITARIO',
                'e.ENTRADA_SOLICITUD',
                'e.created_at',
                'u.EMPLEADO_NOMBRE',
                'u.EMPLEADO_APELLIDOPATERNO',
                'u.EMPLEADO_APELLIDOMATERNO'
            ])->map(function ($entrada) {
                $usuario = trim($entrada->EMPLEADO_NOMBRE . ' ' . $entrada->EMPLEADO_APELLIDOPATERNO . ' ' . $entrada->EMPLEADO_APELLIDOMATERNO);

                $tipo       = $entrada->ENTRADA_SOLICITUD == 1
                    ? '<span class="badge bg-success">Entrada</span>'
                    : '<span class="badge bg-success">Entrada por compra</span>';
                $usuarioTxt = $entrada->ENTRADA_SOLICITUD == 1
                    ? 'Retornado por: ' . e($usuario)
                    : '';

                $fechaMostrar = $entrada->FECHA_INGRESO;

                // ================================
                // ORDENAR: solo validar created_at si ENTRADA_SOLICITUD = 1
                // ================================
                if ($entrada->ENTRADA_SOLICITUD == 1) {
                    if (date('Y-m-d', strtotime($entrada->FECHA_INGRESO)) === date('Y-m-d', strtotime($entrada->created_at))) {
                        $horaCreated = date('H:i:s', strtotime($entrada->created_at));
                        $fechaOrden  = $entrada->FECHA_INGRESO . ' ' . $horaCreated;
                    } else {
                        $fechaOrden = $entrada->FECHA_INGRESO . ' 23:59:59';
                    }
                } else {
                    $fechaOrden = $entrada->FECHA_INGRESO;
                }


                return [
                    'ORDEN_PRIORIDAD' => 1,
                    'FECHA'          => $fechaMostrar,
                    'FECHA_ORDEN'    => $fechaOrden,
                    'CANTIDAD'       => $entrada->CANTIDAD_PRODUCTO . ($entrada->UNIDAD_MEDIDA ? " ({$entrada->UNIDAD_MEDIDA})" : ""),
                    'VALOR_UNITARIO' => $entrada->VALOR_UNITARIO,
                    'COSTO_TOTAL'    => $entrada->CANTIDAD_PRODUCTO * $entrada->VALOR_UNITARIO,
                    'TIPO'           => $tipo,
                    'USUARIO'        => $usuarioTxt,
                    'BTN_EDITAR'     => '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>',
                    'BTN_VISUALIZAR' => '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>'
                ];
            });

            // =========================
            // 3. Salidas
            // =========================
          
            $salidas = DB::table('salidas_inventario as s')
                ->leftJoin('usuarios as u', 'u.ID_USUARIO', '=', 's.USUARIO_ID')
                ->where('s.INVENTARIO_ID', $inventarioId)
                ->get([
                    's.FECHA_SALIDA',
                    's.CANTIDAD_SALIDA',
                    's.UNIDAD_MEDIDA',
                    's.created_at',
                    's.SALIDA_ASIGNACIONES',
                    's.USUARIO_ASIGNACION',
                    'u.EMPLEADO_NOMBRE',
                    'u.EMPLEADO_APELLIDOPATERNO',
                    'u.EMPLEADO_APELLIDOMATERNO'
                ])
                ->map(function ($salida) {

                    if ($salida->SALIDA_ASIGNACIONES == 1) {

                        $asignado = $salida->USUARIO_ASIGNACION;

                        $colaborador = DB::table('formulario_contratacion')
                            ->where('CURP', $asignado)
                            ->first();

                        $proveedor = DB::table('formulario_directorio')
                            ->where('RFC_PROVEEDOR', $asignado)
                            ->first();

                        if ($colaborador) {
                            $usuario = trim($colaborador->NOMBRE_COLABORADOR . ' ' .
                                $colaborador->PRIMER_APELLIDO . ' ' .
                                $colaborador->SEGUNDO_APELLIDO);

                            $tipoBadge = '<span class="badge text-bg-warning">Asignado colaborador</span>';
                        } 
                        elseif ($proveedor) {
                        $usuario = $proveedor->NOMBRE_DIRECTORIO . ' (' . $proveedor->RFC_PROVEEDOR . ')';

                        $tipoBadge = '<span class="badge text-bg-warning">Asignado proveedor</span>';
                            
                        } else {
                            $usuario = $asignado;
                            $tipoBadge = '<span class="badge text-bg-warning">Asignado</span>';
                        }
                    } else {

                      
                        $usuario = trim(
                            ($salida->EMPLEADO_NOMBRE ?? '') . ' ' .
                                ($salida->EMPLEADO_APELLIDOPATERNO ?? '') . ' ' .
                                ($salida->EMPLEADO_APELLIDOMATERNO ?? '')
                        );

                        $tipoBadge = '<span class="badge bg-danger">Salida</span>';
                    }

                    return [
                        'ORDEN_PRIORIDAD' => 1,
                        'FECHA'          => $salida->FECHA_SALIDA,
                        'FECHA_ORDEN'    => $salida->FECHA_SALIDA,
                        'CANTIDAD'       => $salida->CANTIDAD_SALIDA . ($salida->UNIDAD_MEDIDA ? " ({$salida->UNIDAD_MEDIDA})" : ""),
                        'VALOR_UNITARIO' => '',
                        'COSTO_TOTAL'    => '',
                        'TIPO'           => $tipoBadge,
                        'USUARIO'        => $usuario,
                        'BTN_EDITAR'     => '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>',
                        'BTN_VISUALIZAR' => '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>'
                    ];
                });


            // =========================
            // 4. Unir todo y ordenar
            // =========================
            $todos = collect($data)
                ->merge($entradas)
                ->merge($salidas)
                ->sortBy([
                    ['ORDEN_PRIORIDAD', 'asc'],
                    ['FECHA_ORDEN', 'asc']
                ])
                ->values();

            return response()->json([
                'data' => $todos,
                'msj'  => 'Información consultada correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'msj'  => 'Error ' . $e->getMessage(),
                'data' => 0
            ]);
        }
    }

    ///// DOCUMENTOS DEL EQUIPO 

    public function guardarRequiereItem(Request $request)
    {
        DB::table('formulario_inventario')
            ->where('ID_FORMULARIO_INVENTARIO', $request->ID_FORMULARIO_INVENTARIO)
            ->update([
            'REQUIERE_ARTICULO' => $request->REQUIERE_ARTICULO
            ]);

        return response()->json([
            'code' => 1,
            'message' => 'Guardado correctamente'
        ]);
    }


    public function Tabladocumentosinventario(Request $request)
    {
        try {

            
            $equipo = $request->get('equipo');

            $tabla = documentosarticulosModel::where('INVENTARIO_ID', $equipo)->get();
            $fecha_actual = date('Y-m-d');




            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {

                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-verificacionproveedor" data-id="' . $value->ID_DOCUMENTO_ARTICULO . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                } else {

                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-documentosequipo" data-id="' . $value->ID_DOCUMENTO_ARTICULO . '" title="Ver documento"> <i class="bi bi-filetype-pdf"></i></button>';
                }



                if ($value->REQUIERE_FECHA == 1) {

                    if ($value->INDETERMINADO_DOCUMENTO == 1) {
                        $value->FECHAS_DOCUMENTOS = '
                        <div>
                            <strong>' . $value->FECHAI_DOCUMENTO . '</strong><br>
                            <span class="badge bg-success text-light">Indeterminado</span>
                        </div>';
                    } elseif (!empty($value->FECHAI_DOCUMENTO) && !empty($value->FECHAF_DOCUMENTO)) {

                        $fechaInicio = strtotime($value->FECHAI_DOCUMENTO);
                        $fechaFin = strtotime($value->FECHAF_DOCUMENTO);
                        $hoy = strtotime($fecha_actual);

                        $total_dias = ($fechaFin - $fechaInicio) / 86400;
                        $restantes = ($fechaFin - $hoy) / 86400;

                        if ($hoy > $fechaFin) {
                            $restantes = 0;
                        }

                        $transcurrido = $total_dias > 0 ? (($total_dias - $restantes) / $total_dias) * 100 : 100;

                        if ($hoy > $fechaFin) {
                            $color = 'danger';
                            $texto = 'Vencido';
                        } elseif ($transcurrido < 60) {
                            $color = 'success';
                            $texto = 'Vigente';
                        } elseif ($transcurrido < 80) {
                            $color = 'warning';
                            $texto = 'Revisar';
                        } else {
                            $color = 'danger';
                            $texto = 'Próximo a vencer';
                        }

                        $dias_restantes = max(0, floor($restantes));

                        $value->FECHAS_DOCUMENTOS = '
                        <div>
                            <strong>' . $value->FECHAI_DOCUMENTO . ' - ' . $value->FECHAF_DOCUMENTO . '</strong><br>
                            <span class="badge bg-' . $color . ' text-light">' . $texto . ' (' . $dias_restantes . ' días restantes)</span>
                        </div>';
                    } else {
                        $value->FECHAS_DOCUMENTOS = 'Sin fecha';
                    }
                } else {
                    $value->FECHAS_DOCUMENTOS = 'N/A';
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

    public function mostrardocumentoquipo($id)
    {
        $archivo = documentosarticulosModel::findOrFail($id)->DOCUMENTO_ARTICULO;
        return Storage::response($archivo);
    }


    public function obtenerDocumentosPorInventario($inventario_id)
    {
        $documentos = documentosarticulosModel::where('INVENTARIO_ID', $inventario_id)
            ->where('REQUIERE_FECHA', 1)
            ->where('INDETERMINADO_DOCUMENTO', 2)
            ->select('NOMBRE_DOCUMENTO', 'FECHAI_DOCUMENTO', 'FECHAF_DOCUMENTO')
            ->get();

        return response()->json($documentos);
    }

    ///// DETALLE DOCUMENTO 

    public function guardarDetallearticulo(Request $request)
    {
        DB::table('formulario_inventario')
            ->where('ID_FORMULARIO_INVENTARIO', $request->ID_FORMULARIO_INVENTARIO)
            ->update([
            'DETALLAR_ARTICULOS' => $request->DETALLAR_ARTICULOS
            ]);

        return response()->json([
            'code' => 1,
            'message' => 'Guardado correctamente'
        ]);
    }


    public function Tabladetallearticulos(Request $request)
    {
        try {


            $equipo = $request->get('equipo');

            $tabla = detallearticuloModel::where('INVENTARIO_ID', $equipo)->get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_DETALLE_ARTICULO . '"><span class="slider round"></span></label>';
                } else {

                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_DETALLE_ARTICULO . '" checked><span class="slider round"></span></label>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
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



    public function  store(Request $request)
    {
        try {
            switch (intval($request->api)) {
             
                case 1:
                    

                    if ($request->ID_FORMULARIO_INVENTARIO == 0) {
                        DB::statement('ALTER TABLE formulario_inventario AUTO_INCREMENT=1;');

                        $datos = $request->except('FOTO_EQUIPO');
                        $inventarios = inventarioModel::create($datos);

                        if ($request->hasFile('FOTO_EQUIPO')) {
                            $file = $request->file('FOTO_EQUIPO');
                            $folder = "Almacén/Inventario/{$inventarios->ID_FORMULARIO_INVENTARIO}";
                            $filename = 'foto_equipo.' . $file->getClientOriginalExtension();
                            $path = $file->storeAs($folder, $filename);

                            $inventarios->FOTO_EQUIPO = $path;
                            $inventarios->save();
                        }

                        DB::table('entradas_inventario')->insert([
                            'INVENTARIO_ID'    => $inventarios->ID_FORMULARIO_INVENTARIO,
                            'FECHA_INGRESO'    => $inventarios->FECHA_ADQUISICION,
                            'CANTIDAD_PRODUCTO' => $inventarios->CANTIDAD_EQUIPO,
                            'VALOR_UNITARIO'   => $inventarios->UNITARIO_EQUIPO,
                            'UNIDAD_MEDIDA'    => $inventarios->UNIDAD_MEDIDA,
                            'created_at'       => now(),  
                            'updated_at'       => now()
                        ]);

                        $response['code']  = 1;
                        $response['inventario']  = $inventarios;
                        return response()->json($response);
                    


                } else {
                        if (isset($request->ELIMINAR)) {
                            $estado = $request->ELIMINAR == 1 ? 0 : 1;
                            $accion = $estado == 1 ? 'Activada' : 'Desactivada';

                            inventarioModel::where('ID_FORMULARIO_INVENTARIO', $request->ID_FORMULARIO_INVENTARIO)
                                ->update(['ACTIVO' => $estado]);

                            $response['code'] = 1;
                            $response['inventario'] = $accion;
                            return response()->json($response);
                        } else {
                            $inventarios = inventarioModel::find($request->ID_FORMULARIO_INVENTARIO);

                            if (!$inventarios) {
                                return response()->json(['code' => 0, 'msj' => 'Inventario no encontrado']);
                            }

                            if ($request->hasFile('FOTO_EQUIPO')) {
                                if ($inventarios->FOTO_EQUIPO && Storage::exists($inventarios->FOTO_EQUIPO)) {
                                    Storage::delete($inventarios->FOTO_EQUIPO);
                                }

                                $file = $request->file('FOTO_EQUIPO');
                                $folder = "Almacén/Inventario/{$inventarios->ID_FORMULARIO_INVENTARIO}";
                                $filename = 'foto_equipo.' . $file->getClientOriginalExtension();
                                $path = $file->storeAs($folder, $filename);

                                $inventarios->FOTO_EQUIPO = $path;
                            }

                            $inventarios->fill($request->except('FOTO_EQUIPO'))->save();

                            $response['code'] = 1;
                            $response['inventario'] = 'Actualizada';
                            return response()->json($response);
                        }
                    }
                    break;
                case 3:
                    if ($request->ID_DOCUMENTO_ARTICULO == 0) {
                        DB::statement('ALTER TABLE documentos_articulosalmacen AUTO_INCREMENT=1;');
                        $cliente = documentosarticulosModel::create($request->all());

                        if ($request->hasFile('DOCUMENTO_ARTICULO')) {
                            $documento = $request->file('DOCUMENTO_ARTICULO');
                            $articuloId = $cliente->INVENTARIO_ID;
                            $registroId = $cliente->ID_DOCUMENTO_ARTICULO;

                            $extension = $documento->getClientOriginalExtension();
                            $nombreBase = pathinfo($documento->getClientOriginalName(), PATHINFO_FILENAME);
                            $nombreLimpio = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $nombreBase);
                            $nombreArchivo = $nombreLimpio . '.' . $extension;

                            $ruta = "Almacén/Inventario/{$articuloId}/Documento del equipo/{$registroId}";
                            $rutaCompleta = $documento->storeAs($ruta, $nombreArchivo);

                            $cliente->DOCUMENTO_ARTICULO = $rutaCompleta;
                            $cliente->save();
                        }
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $cliente = documentosarticulosModel::where('ID_DOCUMENTO_ARTICULO', $request['ID_DOCUMENTO_ARTICULO'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['cliente'] = 'Desactivada';
                            } else {
                                $cliente = documentosarticulosModel::where('ID_DOCUMENTO_ARTICULO', $request['ID_DOCUMENTO_ARTICULO'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['cliente'] = 'Activada';
                            }
                        } else {
                            $cliente = documentosarticulosModel::find($request->ID_DOCUMENTO_ARTICULO);
                            $cliente->update($request->all());

                            if ($request->hasFile('DOCUMENTO_ARTICULO')) {
                                $documento = $request->file('DOCUMENTO_ARTICULO');
                                $articuloId = $cliente->INVENTARIO_ID;
                                $registroId = $cliente->ID_DOCUMENTO_ARTICULO;

                                $extension = $documento->getClientOriginalExtension();
                                $nombreBase = pathinfo($documento->getClientOriginalName(), PATHINFO_FILENAME);
                                $nombreLimpio = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $nombreBase);
                                $nombreArchivo = $nombreLimpio . '.' . $extension;

                                $ruta = "Almacén/Inventario/{$articuloId}/Documento del equipo/{$registroId}";
                                $rutaCompleta = $documento->storeAs($ruta, $nombreArchivo);

                                $cliente->DOCUMENTO_ARTICULO = $rutaCompleta;
                                $cliente->save();
                            }


                            $response['code'] = 1;
                            $response['cliente'] = 'Actualizada';
                        }

                        return response()->json($response);
                    }

                    $response['code'] = 1;
                    $response['cliente'] = $cliente;
                    return response()->json($response);
                    break;


                case 4:
                    if ($request->ID_DETALLE_ARTICULO == 0) {
                        DB::statement('ALTER TABLE detalle_articulo AUTO_INCREMENT=1;');
                        $cliente = detallearticuloModel::create($request->all());
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $cliente = detallearticuloModel::where('ID_DETALLE_ARTICULO', $request['ID_DETALLE_ARTICULO'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['cliente'] = 'Desactivada';
                            } else {
                                $cliente = detallearticuloModel::where('ID_DETALLE_ARTICULO', $request['ID_DETALLE_ARTICULO'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['cliente'] = 'Activada';
                            }
                        } else {
                            $cliente = detallearticuloModel::find($request->ID_DETALLE_ARTICULO);
                            $cliente->update($request->all());
                            $response['code'] = 1;
                            $response['cliente'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['cliente']  = $cliente;
                    return response()->json($response);
                    break;



                case 2:
                    try {
                        if ($request->hasFile('excelEquipos')) {
                            $excel = $request->file('excelEquipos');

                            $spreadsheet = IOFactory::load($excel->getPathname());
                            $sheet = $spreadsheet->getActiveSheet();
                            $data = $sheet->toArray(null, true, true, true);

                            array_shift($data);
                            array_shift($data);

                            $datosGenerales = [];
                            foreach ($data as $row) {
                                if (!empty(array_filter($row))) {
                                    $datosGenerales[] = $row;
                                }
                            }

                            $drawings = $sheet->getDrawingCollection();
                            $imagenesMap = []; 

                            foreach ($drawings as $drawing) {
                                $coordinates = $drawing->getCoordinates();
                                $col = strtoupper(preg_replace('/[0-9]/', '', $coordinates));
                                $rowNum = preg_replace('/[^0-9]/', '', $coordinates);

                                if ($col !== 'K') continue;

                                if ($drawing instanceof MemoryDrawing) {
                                    ob_start();
                                    call_user_func($drawing->getRenderingFunction(), $drawing->getImageResource());
                                    $imageContents = ob_get_contents();
                                    ob_end_clean();

                                    $extension = 'png';
                                    switch ($drawing->getMimeType()) {
                                        case MemoryDrawing::MIMETYPE_GIF:
                                            $extension = 'gif';
                                            break;
                                        case MemoryDrawing::MIMETYPE_JPEG:
                                            $extension = 'jpg';
                                            break;
                                    }
                                } elseif ($drawing instanceof Drawing) {
                                    $zipReader = fopen($drawing->getPath(), 'r');
                                    $imageContents = '';
                                    while (!feof($zipReader)) {
                                        $imageContents .= fread($zipReader, 1024);
                                    }
                                    fclose($zipReader);
                                    $extension = $drawing->getExtension();
                                }

                                $imagenesMap[$rowNum] = [
                                    'contents' => $imageContents,
                                    'extension' => $extension
                                ];
                            }

                            $totalEquipos = count($datosGenerales);
                            $equipoInsertados = 0;
                            $filaExcel = 3; 

                            foreach ($datosGenerales as $rowData) {
                                $nuevoEquipo = inventarioModel::create([
                                    'DESCRIPCION_EQUIPO' => !empty($rowData['B']) ? $rowData['B'] : null,
                                    'MARCA_EQUIPO'       => !empty($rowData['C']) ? $rowData['C'] : null,
                                    'MODELO_EQUIPO'      => !empty($rowData['D']) ? $rowData['D'] : null,
                                    'SERIE_EQUIPO'       => !empty($rowData['E']) ? $rowData['E'] : null,
                                    'CODIGO_EQUIPO'      => !empty($rowData['F']) ? $rowData['F'] : null,
                                    'CANTIDAD_EQUIPO'    => !empty($rowData['G']) ? $rowData['G'] : null,
                                    'UBICACION_EQUIPO'   => !empty($rowData['I']) ? $rowData['I'] : null,
                                    'ESTADO_EQUIPO'      => !empty($rowData['J']) ? $rowData['J'] : null,
                                    'FECHA_ADQUISICION'  => !empty($rowData['L']) ? $rowData['L'] : null,
                                    'PROVEEDOR_EQUIPO'   => !empty($rowData['M']) ? $rowData['M'] : null,
                                    'UNITARIO_EQUIPO'    => !empty($rowData['N']) ? $rowData['N'] : null,
                                    'TOTAL_EQUIPO'       => !empty($rowData['O']) ? $rowData['O'] : null,
                                    'TIPO_EQUIPO'        => !empty($rowData['P']) ? $rowData['P'] : null,
                                    'OBSERVACION_EQUIPO' => !empty($rowData['Q']) ? $rowData['Q'] : null,
                                    'FOTO_EQUIPO'        => null
                                ]);

                                if (isset($imagenesMap[$filaExcel])) {
                                    $imagen = $imagenesMap[$filaExcel];
                                    $filename = 'foto_equipo.' . $imagen['extension'];
                                    $pathFinal = 'Almacén/Inventario/' . $nuevoEquipo->ID_FORMULARIO_INVENTARIO . '/' . $filename;

                                    Storage::put($pathFinal, $imagen['contents']);

                                    $nuevoEquipo->update([
                                        'FOTO_EQUIPO' => $pathFinal
                                    ]);
                                } else {
                                    $nuevoEquipo->update([
                                        'FOTO_EQUIPO' => null 
                                    ]);
                                }

                                $equipoInsertados++;
                                $filaExcel++;
                            }

                            return response()->json([
                                'msj'  => 'Total de equipos agregados: ' . $equipoInsertados . ' de ' . $totalEquipos,
                                'code' => 200
                            ]);
                        } else {
                            return response()->json(["msj" => 'No se ha subido ningún archivo', "code" => 500]);
                        }
                    } catch (Exception $e) {
                        return response()->json([
                            'msj'  => 'Se produjo un error al intentar cargar los equipos: ' . $e->getMessage(),
                            'code' => 500
                        ]);
                    }



                    
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
