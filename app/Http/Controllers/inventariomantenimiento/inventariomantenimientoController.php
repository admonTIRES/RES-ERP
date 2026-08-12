<?php

namespace App\Http\Controllers\inventariomantenimiento;

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


use App\Models\inventariomantenimiento\inventariomantenimientoModel;
use App\Models\inventario\catalogotipoinventarioModel;
use App\Models\inventario\documentosarticulosModel;
use App\Models\inventario\entradasinventariomantenimientoModel;
use App\Models\proveedor\altaproveedorModel;
use App\Models\proveedor\proveedortempModel;
use App\Models\inventario\detallearticuloModel;

use DB;


class inventariomantenimientoController extends Controller
{

    public function index()
    {
        $tipoinventario = catalogotipoinventarioModel::where('ACTIVO', 1)->get();


        $proveedoresOficiales = altaproveedorModel::select('RAZON_SOCIAL_ALTA', 'RFC_ALTA')->get();
        $proveedoresTemporales = proveedortempModel::select('RAZON_PROVEEDORTEMP', 'RFC_PROVEEDORTEMP', 'NOMBRE_PROVEEDORTEMP')->get();


        $ubicacioninventario = inventariomantenimientoModel::select('UBICACION_EQUIPO')
            ->distinct()
            ->orderBy('UBICACION_EQUIPO')
            ->get();


        return view('mantenimiento.inventario.inventariomtto', compact('tipoinventario', 'proveedoresOficiales', 'proveedoresTemporales', 'ubicacioninventario'));
    }




    public function Tablainventariomantenimiento(Request $request)
    {
        try {

            $query = inventariomantenimientoModel::query()
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
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_INVENTARIO_MANTENIMIENTO . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_INVENTARIO_MANTENIMIENTO . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }

                $value->FOTO_EQUIPO_HTML = '<img src="/equipofoto/' . $value->ID_FORMULARIO_INVENTARIO_MANTENIMIENTO . '" class="img-fluid" width="50" height="60">';

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


    public function mostrarFotoEquipoMantenimiento($usuario_id)
    {
        $foto = inventariomantenimientoModel::findOrFail($usuario_id);
        return Storage::response($foto->FOTO_EQUIPO);
    }





    public function metricasInventariomantenimiento(Request $request)
    {
        try {

            $query = inventariomantenimientoModel::query()
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






    public function Tablaentradainventariomantenimiento(Request $request)
    {
        try {

            $inventarioId = $request->get('inventario');

            $data = [];

            $primerEntradaId = null;

          
            $primerEntrada = DB::table('entradas_inventario_mantenimiento')
                ->where('INVENTARIO_ID',$inventarioId)
                ->orderBy('FECHA_INGRESO','asc')
                ->orderBy('created_at','asc')
                ->first();

            if ($primerEntrada) {

                $primerEntradaId = $primerEntrada ->ID_ENTRADA_FORMULARIO_MANTENIMIENTO;
                $data[] = ['ORDEN_PRIORIDAD' => 0,
                    'FECHA' => $primerEntrada->FECHA_INGRESO,
                    'FECHA_ORDEN' => $primerEntrada->FECHA_INGRESO . '00:00:00',
                    'CANTIDAD' => $primerEntrada->CANTIDAD_PRODUCTO .($primerEntrada->UNIDAD_MEDIDA ? " ({$primerEntrada->UNIDAD_MEDIDA})" : ""),
                    'VALOR_UNITARIO' => $primerEntrada->VALOR_UNITARIO,
                    'COSTO_TOTAL' => $primerEntrada->COSTO_TOTAL !== null && $primerEntrada->COSTO_TOTAL !== '' ? $primerEntrada->COSTO_TOTAL : ($primerEntrada->CANTIDAD_PRODUCTO *
                            $primerEntrada->VALOR_UNITARIO),
                    'TIPO' => '<span class="badge bg-warning text-dark">
                        Saldo inicial
                    </span>',
                    'USUARIO' => $primerEntrada->DETALLE_OPERACION ?? '',
                    'BTN_EDITAR' =>
                    '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR">
                        <i class="bi bi-pencil-square"></i>
                    </button>',
                    'BTN_VISUALIZAR' =>
                    '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR">
                        <i class="bi bi-eye"></i>
                    </button>'
                ];
            }

          
            $entradasQuery = DB::table(
                'entradas_inventario_mantenimiento as e'
            )
                ->leftJoin(
                    'usuarios as u',
                    'u.ID_USUARIO',
                    '=',
                    'e.USUARIO_ID'
                )
                ->where(
                    'e.INVENTARIO_ID',
                    $inventarioId
                );

            if ($primerEntradaId) {

                $entradasQuery->where(
                    'e.ID_ENTRADA_FORMULARIO_MANTENIMIENTO',
                    '!=',
                    $primerEntradaId
                );
            }

            $entradas = $entradasQuery
                ->get([
                    'e.ID_ENTRADA_FORMULARIO_MANTENIMIENTO',
                    'e.FECHA_INGRESO',
                    'e.CANTIDAD_PRODUCTO',
                    'e.UNIDAD_MEDIDA',
                    'e.VALOR_UNITARIO',
                    'e.COSTO_TOTAL',
                    'e.DETALLE_OPERACION',
                    'e.ENTRADA_SOLICITUD',
                    'e.ENTRA_ASIGNACION',
                    'e.created_at',

                    'u.EMPLEADO_NOMBRE',
                    'u.EMPLEADO_APELLIDOPATERNO',
                    'u.EMPLEADO_APELLIDOMATERNO'
                ])
                ->map(function ($entrada) {

                    $usuario = trim(
                        ($entrada->EMPLEADO_NOMBRE ?? '') .
                            ' ' .
                            ($entrada->EMPLEADO_APELLIDOPATERNO ?? '') .
                            ' ' .
                            ($entrada->EMPLEADO_APELLIDOMATERNO ?? '')
                    );

                    if ($entrada->ENTRA_ASIGNACION == 1) {

                        $tipo =
                            '<span class="badge bg-info">
                            Retornada por Administración
                        </span>';

                        $usuarioTxt = '';
                    } else {

                        $tipo =
                            $entrada->ENTRADA_SOLICITUD == 1
                            ? '<span class="badge bg-success">
                                Entrada
                               </span>'
                            : '<span class="badge bg-success">
                                Entrada por salida de almacén
                               </span>';

                        $usuarioTxt =
                            $entrada->ENTRADA_SOLICITUD == 1
                            ? 'Retornado por: ' . e($usuario)
                            : (
                                $entrada->DETALLE_OPERACION
                                ?? ''
                            );
                    }

                    $fechaMostrar =
                        $entrada->FECHA_INGRESO;

                    if (
                        !empty($entrada->created_at) &&
                        date('Y-m-d',strtotime($entrada->FECHA_INGRESO)) ===
                        date('Y-m-d',strtotime($entrada->created_at))) 
                    {

                        $horaCreated = date('H:i:s',strtotime($entrada->created_at));

                        $fechaOrden =
                            date('Y-m-d',strtotime($entrada->FECHA_INGRESO)).' '.$horaCreated;
                    } else {

                        $fechaOrden = date('Y-m-d',strtotime($entrada->FECHA_INGRESO)).' 23:59:59';
                    }

                    $costoTotal = $entrada->COSTO_TOTAL;
                    if ($costoTotal === null || $costoTotal === '') 
                    {

                        $costoTotal = $entrada->CANTIDAD_PRODUCTO * $entrada->VALOR_UNITARIO;
                    }

                    return [
                        'ID_ENTRADA_FORMULARIO_MANTENIMIENTO' => $entrada ->ID_ENTRADA_FORMULARIO_MANTENIMIENTO,
                        'ORDEN_PRIORIDAD' => 1,
                        'FECHA' => $fechaMostrar,
                        'FECHA_ORDEN' => $fechaOrden,
                        'CANTIDAD' => $entrada->CANTIDAD_PRODUCTO .($entrada->UNIDAD_MEDIDA ? " ({$entrada->UNIDAD_MEDIDA})" : ""),
                        'VALOR_UNITARIO' => $entrada->VALOR_UNITARIO,
                        'COSTO_TOTAL' => $costoTotal,
                        'TIPO' => $tipo,
                        'USUARIO' =>$usuarioTxt,

                        'BTN_EDITAR' =>
                        '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR">
                            <i class="bi bi-pencil-square"></i>
                        </button>',
                        'BTN_VISUALIZAR' =>
                        '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR">
                            <i class="bi bi-eye"></i>
                        </button>'
                    ];
                });

           
            $salidas = DB::table('salidas_inventario_mantenimiento as s')
                ->leftJoin(
                    'usuarios as u',
                    'u.ID_USUARIO',
                    '=',
                    's.USUARIO_ID'
                )
                ->where(
                    's.INVENTARIO_ID',
                    $inventarioId
                )
                ->get([
                    's.ID_SALIDA_FORMULARIO_MANTENIMIENTO',
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

                        $asignado =
                            $salida->USUARIO_ASIGNACION;

                        $colaborador = DB::table(
                            'formulario_contratacion'
                        )
                            ->where('CURP',$asignado)
                            ->first();

                        $proveedor = DB::table('formulario_directorio')
                            ->where('RFC_PROVEEDOR',$asignado)
                            ->first();

                        if ($colaborador) {
                            $usuario = trim($colaborador->NOMBRE_COLABORADOR .' ' .$colaborador->PRIMER_APELLIDO .' ' .$colaborador->SEGUNDO_APELLIDO);
                            $tipoBadge =
                                '<span class="badge text-bg-warning">
                            Asignado colaborador
                        </span>';
                        } elseif ($proveedor) {

                            $usuario = $proveedor->NOMBRE_DIRECTORIO .' (' .$proveedor->RFC_PROVEEDOR .')';

                            $tipoBadge =
                                '<span class="badge text-bg-warning">
                            Asignado proveedor
                        </span>';
                        } else {

                            $usuario =
                                $asignado;

                            $tipoBadge =
                                '<span class="badge text-bg-warning">
                            Asignado
                        </span>';
                        }
                    } else {

                        $usuario = trim(
                            ($salida->EMPLEADO_NOMBRE ?? '') .
                                ' ' .
                                ($salida->EMPLEADO_APELLIDOPATERNO ?? '') .
                                ' ' .
                                ($salida->EMPLEADO_APELLIDOMATERNO ?? '')
                        );

                        $tipoBadge =
                            '<span class="badge bg-danger">
                        Salida
                    </span>';
                    }

                    $fechaMostrar =
                        $salida->FECHA_SALIDA;

                    if (
                        !empty($salida->created_at) &&
                        date('Y-m-d',strtotime($salida->FECHA_SALIDA))===
                        date('Y-m-d',strtotime($salida->created_at))) 
                    {

                        $horaCreated = date('H:i:s',strtotime($salida->created_at));
                        $fechaOrden = date('Y-m-d',strtotime($salida->FECHA_SALIDA)).' '.$horaCreated;
                    } else {
                        $fechaOrden = date('Y-m-d',strtotime($salida->FECHA_SALIDA)).'23:59:59';
                    }

                    return [
                        'ID_SALIDA_FORMULARIO_MANTENIMIENTO' => $salida ->ID_SALIDA_FORMULARIO_MANTENIMIENTO,
                        'ORDEN_PRIORIDAD' => 1,
                        'FECHA' => $fechaMostrar,
                        'FECHA_ORDEN' => $fechaOrden,
                        'CANTIDAD' => $salida->CANTIDAD_SALIDA .($salida->UNIDAD_MEDIDA ? " ({$salida->UNIDAD_MEDIDA})": ""),
                        'VALOR_UNITARIO' => '',
                        'COSTO_TOTAL' => '',
                        'TIPO' => $tipoBadge,
                        'USUARIO' => $usuario,
                        'BTN_EDITAR' =>
                        '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR">
                        <i class="bi bi-pencil-square"></i>
                    </button>',

                        'BTN_VISUALIZAR' =>
                        '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR">
                        <i class="bi bi-eye"></i>
                    </button>'
                    ];
                });

          
            $todos = collect($data)
                ->merge($entradas)
                ->merge($salidas)
                ->sort(function ($a, $b) {

                    if (
                        $a['ORDEN_PRIORIDAD'] !=
                        $b['ORDEN_PRIORIDAD']
                    ) {

                        return
                            $a['ORDEN_PRIORIDAD']
                            <=>
                            $b['ORDEN_PRIORIDAD'];
                    }

                    return strcmp(
                        $a['FECHA_ORDEN'],
                        $b['FECHA_ORDEN']
                    );
                })
                ->values();

            return response()->json([
                'data' =>
                $todos,

                'msj' =>
                'Información consultada correctamente'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'msj' =>
                'Error ' . $e->getMessage(),

                'data' =>
                0
            ]);
        }
    }






    public function  store(Request $request)
    {
        try {
            switch (intval($request->api)) {

                case 1:


                    if ($request->ID_FORMULARIO_INVENTARIO_MANTENIMIENTO == 0) {
                        DB::statement('ALTER TABLE formulario_inventario_mantenimiento AUTO_INCREMENT=1;');

                        $datos = $request->except('FOTO_EQUIPO');
                        $inventarios = inventariomantenimientoModel::create($datos);

                        if ($request->hasFile('FOTO_EQUIPO')) {
                            $file = $request->file('FOTO_EQUIPO');
                            $folder = "Almacén/Inventario/{$inventarios->ID_FORMULARIO_INVENTARIO_MANTENIMIENTO}";
                            $filename = 'foto_equipo.' . $file->getClientOriginalExtension();
                            $path = $file->storeAs($folder, $filename);

                            $inventarios->FOTO_EQUIPO = $path;
                            $inventarios->save();
                        }

                        DB::table('entradas_inventario')->insert([
                            'INVENTARIO_ID'    => $inventarios->ID_FORMULARIO_INVENTARIO_MANTENIMIENTO,
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

                            inventariomantenimientoModel::where('ID_FORMULARIO_INVENTARIO_MANTENIMIENTO', $request->ID_FORMULARIO_INVENTARIO_MANTENIMIENTO)
                                ->update(['ACTIVO' => $estado]);

                            $response['code'] = 1;
                            $response['inventario'] = $accion;
                            return response()->json($response);
                        } else {
                            $inventarios = inventariomantenimientoModel::find($request->ID_FORMULARIO_INVENTARIO_MANTENIMIENTO);

                            if (!$inventarios) {
                                return response()->json(['code' => 0, 'msj' => 'Inventario no encontrado']);
                            }

                            if ($request->hasFile('FOTO_EQUIPO')) {
                                if ($inventarios->FOTO_EQUIPO && Storage::exists($inventarios->FOTO_EQUIPO)) {
                                    Storage::delete($inventarios->FOTO_EQUIPO);
                                }

                                $file = $request->file('FOTO_EQUIPO');
                                $folder = "Almacén/Inventario/{$inventarios->ID_FORMULARIO_INVENTARIO_MANTENIMIENTO}";
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
