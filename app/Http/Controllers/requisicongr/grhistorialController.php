<?php

namespace App\Http\Controllers\requisicongr;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use DB;

use App\Models\proveedor\altaproveedorModel;
use App\Models\proveedor\proveedortempModel;
use App\Models\inventario\inventarioModel;
use App\Models\inventario\catalogotipoinventarioModel;



class grhistorialController extends Controller
{

    public function index()
    {
        $proveedoresOficiales = altaproveedorModel::select('RAZON_SOCIAL_ALTA', 'RFC_ALTA')->get();
        $proveedoresTemporales = proveedortempModel::select('RAZON_PROVEEDORTEMP', 'RFC_PROVEEDORTEMP', 'NOMBRE_PROVEEDORTEMP')->get();


        $tipoinventario = catalogotipoinventarioModel::where('ACTIVO', 1)->get();
        $inventario = inventarioModel::where('ACTIVO', 1)->get();



        return view('compras.recepciongr.recepcionbienesgrhistorial', compact('proveedoresOficiales', 'proveedoresTemporales', 'tipoinventario', 'inventario'));
    }


    public function Tablabitacoragrhistorial(Request $request)
    {
        try {


            $aplicarFiltroFecha = function ($query) use ($request) {
                if ($request->filled('FECHA_INICIO') && $request->filled('FECHA_FIN')) {
                    $query->whereBetween(
                        DB::raw('DATE(mr.FECHA_APRUEBA_MR)'),
                        [$request->FECHA_INICIO, $request->FECHA_FIN]
                    );
                }
            };


            $poUltimo = DB::table('formulario_ordencompra as po')
                ->select(
                    'po.ID_FORMULARIO_PO',
                    'po.NO_PO',
                    'po.HOJA_ID',
                    'po.FECHA_APROBACION',
                    'po.FECHA_ENTREGA',
                    'po.PROVEEDOR_SELECCIONADO',
                    'po.MATERIALES_JSON',
                    'po.ESTADO_APROBACION',
                    'po.CANCELACION_PO'
                )
                ->join(
                    DB::raw('(
            SELECT 
                REPLACE(SUBSTRING_INDEX(NO_PO, "-Rev", 1), " ", "") AS PO_BASE,
                MAX(FECHA_APROBACION) AS max_fecha
            FROM formulario_ordencompra
            GROUP BY PO_BASE
        ) AS ult'),
                    function ($join) {
                        $join->on(
                            DB::raw('REPLACE(SUBSTRING_INDEX(po.NO_PO, "-Rev", 1), " ", "")'),
                            '=',
                            'ult.PO_BASE'
                        )
                            ->on('po.FECHA_APROBACION', '=', 'ult.max_fecha');
                    }
                );

            // === CONSULTA ORIGINAL PARA CASOS CON PO ===
            $rowsConPO = DB::table('hoja_trabajo as ht')
                ->join('formulario_requisiconmaterial as mr', 'mr.NO_MR', '=', 'ht.NO_MR')
                ->leftJoin('usuarios as u', 'u.ID_USUARIO', '=', 'mr.USUARIO_ID')
                ->leftJoinSub($poUltimo, 'po', function ($join) {
                    $join->whereRaw("
            FIND_IN_SET(
                CAST(ht.id AS CHAR), 
                REPLACE(REPLACE(REPLACE(REPLACE(po.HOJA_ID, '[', ''), ']', ''), '\"', ''), ' ', '')
            )
        ");
                })
                ->leftJoin('formulario_altaproveedor as prov', function ($join) {
                    $join->on('prov.RFC_ALTA', '=', 'po.PROVEEDOR_SELECCIONADO');
                })
                ->leftJoin('formulario_proveedortemp as provtemp', function ($join) {
                    $join->on('provtemp.RAZON_PROVEEDORTEMP', '=', 'po.PROVEEDOR_SELECCIONADO');
                })
                ->whereNotNull('po.NO_PO')
                ->where('po.ESTADO_APROBACION', 'Aprobada')
                ->where(function ($q) {
                    $q->whereNull('po.CANCELACION_PO')
                        ->orWhere('po.CANCELACION_PO', '!=', 1);
                })
                ->tap($aplicarFiltroFecha) 
                ->select([
                    DB::raw('COALESCE(po.NO_PO, CONCAT("HT-", ht.id)) as AGRUPADOR'),
                    'mr.NO_MR',
                    'mr.FECHA_APRUEBA_MR',
                    DB::raw("CONCAT(u.EMPLEADO_NOMBRE, ' ', u.EMPLEADO_APELLIDOPATERNO, ' ', u.EMPLEADO_APELLIDOMATERNO) as USUARIO_NOMBRE"), // Nombre usuario
                    'po.NO_PO',
                    'po.FECHA_APROBACION as FECHA_APROBACION_PO',
                    'po.FECHA_ENTREGA as FECHA_ENTREGA_PO',
                    DB::raw("
            CASE 
                WHEN prov.RAZON_SOCIAL_ALTA IS NOT NULL 
                    THEN CONCAT(prov.RAZON_SOCIAL_ALTA, ' (', prov.RFC_ALTA, ')')
                WHEN provtemp.RAZON_PROVEEDORTEMP IS NOT NULL 
                    THEN CONCAT(provtemp.RAZON_PROVEEDORTEMP, 
                        IF(provtemp.RFC_PROVEEDORTEMP IS NOT NULL AND provtemp.RFC_PROVEEDORTEMP != '', 
                            CONCAT(' (', provtemp.RFC_PROVEEDORTEMP, ')'), ''))
                ELSE NULL 
            END as PROVEEDOR
        "),
                    'po.MATERIALES_JSON',
                    DB::raw('NULL as HT_DESCRIPCION'),
                    DB::raw('NULL as MATERIALES_HOJA_JSON'),
                    DB::raw('po.PROVEEDOR_SELECCIONADO as PROVEEDOR_KEY'),
                    DB::raw('NULL as PROVEEDOR_Q1'),
                    DB::raw('NULL as PROVEEDOR_Q2'),
                    DB::raw('NULL as PROVEEDOR_Q3'),
                    DB::raw('NULL as CANTIDAD_REALQ1'),
                    DB::raw('NULL as CANTIDAD_REALQ2'),
                    DB::raw('NULL as CANTIDAD_REALQ3'),
                    DB::raw('NULL as PRECIO_UNITARIOQ1'),
                    DB::raw('NULL as PRECIO_UNITARIOQ2'),
                    DB::raw('NULL as PRECIO_UNITARIOQ3'),
                    DB::raw('NULL as UNIDAD_MEDIDA')


                ])
                ->groupBy(
                    'AGRUPADOR',
                    'mr.NO_MR',
                    'mr.FECHA_APRUEBA_MR',
                    'u.EMPLEADO_NOMBRE',
                    'u.EMPLEADO_APELLIDOPATERNO',
                    'u.EMPLEADO_APELLIDOMATERNO',
                    'po.NO_PO',
                    'po.FECHA_APROBACION',
                    'po.FECHA_ENTREGA',
                    'prov.RAZON_SOCIAL_ALTA',
                    'prov.RFC_ALTA',
                    'po.MATERIALES_JSON',
                    'provtemp.RAZON_PROVEEDORTEMP',
                    'provtemp.RFC_PROVEEDORTEMP',
                    'po.PROVEEDOR_SELECCIONADO'
                );

            // === CONSULTA PARA CASOS SIN PO ===
            $rowsSinPO = DB::table('hoja_trabajo as ht')
                ->join('formulario_requisiconmaterial as mr', 'mr.NO_MR', '=', 'ht.NO_MR')
                ->leftJoin('usuarios as u', 'u.ID_USUARIO', '=', 'mr.USUARIO_ID')
                ->leftJoinSub($poUltimo, 'po', function ($join) {
                    $join->whereRaw("
            FIND_IN_SET(
                CAST(ht.id AS CHAR), 
                REPLACE(REPLACE(REPLACE(REPLACE(po.HOJA_ID, '[', ''), ']', ''), '\"', ''), ' ', '')
            )
        ");
                })
                ->leftJoin('formulario_altaproveedor as prov', function ($join) {
                    $join->on('prov.RFC_ALTA', '=', 'ht.PROVEEDOR_SELECCIONADO');
                })
                ->leftJoin('formulario_proveedortemp as provtemp', function ($join) {
                    $join->on('provtemp.RAZON_PROVEEDORTEMP', '=', 'ht.PROVEEDOR_SELECCIONADO');
                })
                ->whereNull('po.NO_PO')
                ->where('ht.ESTADO_APROBACION', 'Aprobada')
                ->tap($aplicarFiltroFecha) 
                ->select([
                    DB::raw('CONCAT("HT-", ht.NO_MR, "-", ht.PROVEEDOR_SELECCIONADO) as AGRUPADOR'),
                    'mr.NO_MR',
                    'mr.FECHA_APRUEBA_MR',
                    DB::raw("CONCAT(u.EMPLEADO_NOMBRE, ' ', u.EMPLEADO_APELLIDOPATERNO, ' ', u.EMPLEADO_APELLIDOMATERNO) as USUARIO_NOMBRE"),
                    DB::raw('NULL as NO_PO'),
                    DB::raw('NULL as FECHA_APROBACION_PO'),
                    DB::raw('NULL as FECHA_ENTREGA_PO'),
                    DB::raw("
                        CASE 
                            WHEN prov.RAZON_SOCIAL_ALTA IS NOT NULL 
                                THEN CONCAT(prov.RAZON_SOCIAL_ALTA, ' (', prov.RFC_ALTA, ')')
                            WHEN provtemp.RAZON_PROVEEDORTEMP IS NOT NULL 
                                THEN CONCAT(provtemp.RAZON_PROVEEDORTEMP, 
                                    IF(provtemp.RFC_PROVEEDORTEMP IS NOT NULL AND provtemp.RFC_PROVEEDORTEMP != '', 
                                        CONCAT(' (', provtemp.RFC_PROVEEDORTEMP, ')'), ''))
                            WHEN ht.PROVEEDOR_SELECCIONADO IS NOT NULL 
                                THEN ht.PROVEEDOR_SELECCIONADO
                            ELSE NULL 
                        END as PROVEEDOR
                    "),
                    DB::raw('NULL as MATERIALES_JSON'),
                    'ht.DESCRIPCION as HT_DESCRIPCION',
                    'ht.MATERIALES_HOJA_JSON',
                    'ht.PROVEEDOR_SELECCIONADO as PROVEEDOR_KEY',
                    'ht.PROVEEDOR_Q1',
                    'ht.PROVEEDOR_Q2',
                    'ht.PROVEEDOR_Q3',
                    'ht.CANTIDAD_REALQ1',
                    'ht.CANTIDAD_REALQ2',
                    'ht.CANTIDAD_REALQ3',
                    'ht.PRECIO_UNITARIOQ1',
                    'ht.PRECIO_UNITARIOQ2',
                    'ht.PRECIO_UNITARIOQ3',
                    'ht.UNIDAD_MEDIDA'
                ]);

            // === UNIR CONSULTAS ===
            $union = $rowsConPO->unionAll($rowsSinPO);

            // === AGRUPACIÓN FINAL ===
            $rows = DB::query()
                ->fromSub($union, 't')
                ->orderBy('t.NO_MR', 'asc')
                ->get()
                ->groupBy('AGRUPADOR')
                ->map(function ($group) {
                    $first = $group->first();

                    $materialesArray = [];
                    $vistos = [];



                    foreach ($group as $row) {
                        if (!empty($row->MATERIALES_JSON)) {
                            $materiales = json_decode($row->MATERIALES_JSON, true);

                            if (is_array($materiales)) {
                                foreach ($materiales as $mat) {
                                    $cantidad     = $mat['CANTIDAD_'] ?? 0;
                                    $precio       = $mat['PRECIO_UNITARIO'] ?? null;
                                    $unidad       = $mat['UNIDAD_MEDIDA'] ?? '';
                                    $descripcion  = $mat['DESCRIPCION'] ?? '';

                                    $key = $descripcion . '-' . $cantidad . '-' . $precio . '-' . $unidad;

                                    if ($cantidad > 0 && !isset($vistos[$key])) {
                                        $vistos[$key] = true;
                                        $texto = "• {$descripcion} ({$cantidad} {$unidad})";
                                        if ($precio !== null && $precio !== '') {
                                            $texto .= " - $ {$precio}";
                                        }
                                        $materialesArray[] = $texto;
                                    }
                                }
                            }
                        } elseif (!empty($row->MATERIALES_HOJA_JSON)) {
                            $materiales = json_decode($row->MATERIALES_HOJA_JSON, true);
                            if (is_array($materiales)) {
                                foreach ($materiales as $mat) {
                                    $cantidad     = $mat['CANTIDAD_REAL'] ?? ($mat['CANTIDAD'] ?? 0);
                                    if ($cantidad <= 0) continue;

                                    $unidad      = $mat['UNIDAD_MEDIDA'] ?? '';
                                    $descripcion = $mat['DESCRIPCION'] ?? '';

                                    $precio = null;
                                    if ($row->PROVEEDOR_KEY == $row->PROVEEDOR_Q1) {
                                        $precio = $mat['PRECIO_UNITARIO'] ?? null;
                                    } elseif ($row->PROVEEDOR_KEY == $row->PROVEEDOR_Q2) {
                                        $precio = $mat['PRECIO_UNITARIO_Q2'] ?? null;
                                    } elseif ($row->PROVEEDOR_KEY == $row->PROVEEDOR_Q3) {
                                        $precio = $mat['PRECIO_UNITARIO_Q3'] ?? null;
                                    }

                                    $key = $descripcion . '-' . $cantidad . '-' . $precio . '-' . $unidad;
                                    if (!isset($vistos[$key])) {
                                        $vistos[$key] = true;
                                        $texto = "• {$descripcion} ({$cantidad} {$unidad})";
                                        if ($precio !== null && $precio !== '') {
                                            $texto .= " - $ {$precio}";
                                        }
                                        $materialesArray[] = $texto;
                                    }
                                }
                            }
                        } elseif (!empty($row->HT_DESCRIPCION)) {
                            $cantidad     = 0;
                            $precio       = null;
                            $unidad       = $row->UNIDAD_MEDIDA ?? '';
                            $descripcion  = $row->HT_DESCRIPCION;

                            if ($row->PROVEEDOR_KEY == $row->PROVEEDOR_Q1) {
                                $cantidad = $row->CANTIDAD_REALQ1;
                                $precio   = $row->PRECIO_UNITARIOQ1;
                            } elseif ($row->PROVEEDOR_KEY == $row->PROVEEDOR_Q2) {
                                $cantidad = $row->CANTIDAD_REALQ2;
                                $precio   = $row->PRECIO_UNITARIOQ2;
                            } elseif ($row->PROVEEDOR_KEY == $row->PROVEEDOR_Q3) {
                                $cantidad = $row->CANTIDAD_REALQ3;
                                $precio   = $row->PRECIO_UNITARIOQ3;
                            }

                            if ($cantidad > 0) {
                                $key = $descripcion . '-' . $cantidad . '-' . $precio . '-' . $unidad;
                                if (!isset($vistos[$key])) {
                                    $vistos[$key] = true;
                                    $texto = "• {$descripcion} ({$cantidad} {$unidad})";
                                    if ($precio !== null && $precio !== '') {
                                        $texto .= " - $ {$precio}";
                                    }
                                    $materialesArray[] = $texto;
                                }
                            }
                        }
                    }

                    $bienes = '';
                    $bienesCompleto = '';

                    if (!empty($materialesArray)) {
                        $mostrar = array_slice($materialesArray, 0, 3);
                        $ocultos = array_slice($materialesArray, 3);

                        foreach ($mostrar as $m) {
                            $bienes .= "<div>{$m}</div>";
                        }

                        if (!empty($ocultos)) {
                            $bienes .= '<div class="extra-materiales" style="display:none">';
                            foreach ($ocultos as $m) {
                                $bienes .= "<div>{$m}</div>";
                            }
                            $bienes .= '</div>';
                            $bienes .= '<button type="button" class="btn-ver-mas-materiales btn btn-link p-0">Ver más</button>';
                        }

                        foreach ($materialesArray as $m) {
                            $bienesCompleto .= "<div>{$m}</div>";
                        }
                    } else {
                        $bienes = '-';
                        $bienesCompleto = '-';
                    }

                    $first->BIEN_SERVICIO = $bienes;
                    $first->BIEN_SERVICIO_COMPLETO = $bienesCompleto;

                    unset($first->MATERIALES_JSON, $first->HT_DESCRIPCION, $first->MATERIALES_HOJA_JSON);



                $registrosGR = DB::table('formulario_bitacoragr')
                    ->where('NO_MR', $first->NO_MR)
                    ->when($first->NO_PO, function ($q) use ($first) {
                        $q->where('NO_PO', $first->NO_PO);
                    }, function ($q) use ($first) {
                        $q->where('PROVEEDOR_KEY', $first->PROVEEDOR_KEY);
                    })
                    ->get(['FINALIZAR_GR', 'NO_RECEPCION', 'FECHA_EMISION']);

                if ($registrosGR->isEmpty()) {

                    $first->ROW_CLASS = '';
                    $first->NO_GR = null;
                    $first->FECHA_EMISION = null;
                } else {

                    $first->ROW_CLASS = $registrosGR->every(fn($v) => $v->FINALIZAR_GR === 'Sí')
                        ? 'bg-verde-suave'
                        : 'bg-amarillo-suave';

                    // 🔹 NO_GR
                    $first->NO_GR = $registrosGR
                        ->pluck('NO_RECEPCION')
                        ->filter() // elimina null
                        ->map(fn($v) => "• {$v}")
                        ->implode('<br>');

                    // 🔹 FECHAS
                    $first->FECHA_EMISION = $registrosGR
                        ->pluck('FECHA_EMISION')
                        ->filter()
                        ->map(fn($v) => "• {$v}")
                        ->implode('<br>');
                }



                    return $first;
                })

                ->values();

            return response()->json(['data' => $rows]);
        } catch (\Throwable $e) {
            return response()->json([
                'data' => [],
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    }
