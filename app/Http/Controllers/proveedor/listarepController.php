<?php

namespace App\Http\Controllers\proveedor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\proveedor\facturacionModel;


use DB;


class listarepController extends Controller
{

    // public function Tablareciborep()
    // {
    //     try {

    //         $tabla = DB::table('formulario_facturasproveedores as cp')
    //             ->leftJoin('formulario_altaproveedor as fa', 'cp.RFC_PROVEEDOR', '=', 'fa.RFC_ALTA')
    //             ->select(
    //                 'cp.*',
    //                 'fa.RAZON_SOCIAL_ALTA',
    //                 'fa.RFC_ALTA'
    //             )
    //             ->where('cp.ESTATUS_FACTURA', 1)
    //             ->whereRaw("UPPER(TRIM(cp.METODO_PAGO)) = 'PPD'")
    //             ->where('cp.SUBIR_REP', 1)
    //             ->whereNull('cp.ESTATUS_REP')
    //             ->get();

    //         foreach ($tabla as $value) {

    //             $value->RFC_PROVEEDOR_TEXTO = ($value->RAZON_SOCIAL_ALTA ?? 'SIN NOMBRE') . ' (' . ($value->RFC_ALTA ?? $value->RFC_PROVEEDOR) . ')';

    //             if ($value->ACTIVO == 0) {

    //                 $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';

    //                 $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_FACTURACION . '"><span class="slider round"></span></label>';

    //                 $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';

    //                 $value->BTN_REP = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-rep" data-id="' . $value->ID_FORMULARIO_FACTURACION . '" title="Ver documento"><i class="bi bi-filetype-pdf"></i></button>';

    //                 $value->BTN_FACTURA = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-factura" data-id="' . $value->ID_FORMULARIO_FACTURACION . '" title="Ver documento"><i class="bi bi-filetype-pdf"></i></button>';
    //             } else {

    //                 $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_FACTURACION . '" checked><span class="slider round"></span></label>';

    //                 $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';

    //                 $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';

    //                 $value->BTN_REP = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-rep" data-id="' . $value->ID_FORMULARIO_FACTURACION . '" title="Ver documento"><i class="bi bi-filetype-pdf"></i></button>';

    //                 $value->BTN_FACTURA = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-factura" data-id="' . $value->ID_FORMULARIO_FACTURACION . '" title="Ver documento"><i class="bi bi-filetype-pdf"></i></button>';
    //             }

    //             if ($value->TIPO_FACTURA == 'CONTRATO') {

    //                 $value->TIPO_FACTURA_FORMATO = 'Contrato (No. ' . $value->NO_CONTRATO . ')';
    //             } elseif ($value->TIPO_FACTURA == 'OC') {

    //                 $value->TIPO_FACTURA_FORMATO = 'Orden de Compra y Recepción <br> (PO: ' . $value->NO_PO . ' | GR: ' . $value->NO_GR . ')';
    //             } else {

    //                 $value->TIPO_FACTURA_FORMATO = $value->TIPO_FACTURA;
    //             }

    //             if ($value->ESTATUS_FACTURA == 1) {

    //                 $value->ESTADO_FACTURA_TEXTO = '<span class="badge bg-success">Aprobada</span>';
    //             } elseif ($value->ESTATUS_FACTURA == 2) {

    //                 $value->ESTADO_FACTURA_TEXTO = '<span class="badge bg-danger">Rechazada</span>';
    //             } else {

    //                 $value->ESTADO_FACTURA_TEXTO = '<span class="badge bg-secondary">En revisión</span>';
    //             }


    //             $value->BTN_VOBO = '
    //                 <div class="d-flex flex-column align-items-center gap-2">
    //                     <button type="button" class="btn btn-success btn-custom rounded-pill aprobar-rep" data-id="' . $value->ID_FORMULARIO_FACTURACION . '"
    //                         data-bs-toggle="tooltip" data-bs-placement="top" title="Aprobar REP"><i class="bi bi-check-circle"></i>
    //                     </button>

    //                     <button type="button" class="btn btn-danger btn-custom rounded-pill rechazar-rep" data-id="' . $value->ID_FORMULARIO_FACTURACION . '"
    //                         data-bs-toggle="tooltip" data-bs-placement="top" title="Rechazar REP"> <i class="bi bi-x-circle"></i>
    //                     </button>
    //                 </div>';

    //         }

    //         return response()->json([
    //             'data' => $tabla,
    //             'msj' => 'Información consultada correctamente'
    //         ]);
    //     } catch (\Exception $e) {

    //         return response()->json([
    //             'msj' => 'Error ' . $e->getMessage(),
    //             'data' => 0
    //         ]);
    //     }
    // }




    public function Tablareciborep()
    {
        try {

            $tabla = DB::table('formulario_facturasproveedores as cp')
                ->leftJoin('formulario_altaproveedor as fa', 'cp.RFC_PROVEEDOR', '=', 'fa.RFC_ALTA')
                ->select(
                    'cp.*',
                    'fa.RAZON_SOCIAL_ALTA',
                    'fa.RFC_ALTA'
                )
                ->where('cp.ESTATUS_FACTURA', 1)
                ->whereRaw("UPPER(TRIM(cp.METODO_PAGO)) = 'PPD'")
                ->where('cp.SUBIR_REP', 1)
                ->whereNull('cp.ESTATUS_REP')
                ->get();

            $grupos = DB::table('comprobantes_pago_agrupados')
                ->orderBy('ID_COMPROBANTE_AGRUPADO', 'asc')
                ->get();

            $facturasPorId = $tabla->keyBy('ID_FORMULARIO_FACTURACION');

            $procesadas = [];
            $resultado = collect();

            foreach ($grupos as $grupo) {

                $idsGrupo = json_decode($grupo->IDS_FACTURAS, true);

                if (!is_array($idsGrupo)) {
                    continue;
                }

                $facturasGrupo = collect();

                foreach (array_unique($idsGrupo) as $id) {

                    $id = (int) $id;

                    if (
                        $facturasPorId->has($id) &&
                        !in_array($id, $procesadas)
                    ) {

                        $factura = $facturasPorId->get($id);

                        if ($factura->RFC_PROVEEDOR == $grupo->RFC_PROVEEDOR) {
                            $facturasGrupo->push($factura);
                        }
                    }
                }

                if ($facturasGrupo->count() < 2) {
                    continue;
                }

                $principal = clone $facturasGrupo->first();

                $principal->ES_GRUPO = true;

                $principal->ID_GRUPO_REP = $grupo->ID_COMPROBANTE_AGRUPADO;

                $principal->IDS_FACTURAS_GRUPO = $facturasGrupo
                    ->pluck('ID_FORMULARIO_FACTURACION')
                    ->map(function ($id) {
                        return (int) $id;
                    })
                    ->values()
                    ->all();

                $principal->FACTURAS_AGRUPADAS = $facturasGrupo
                    ->map(function ($factura) {

                        return [
                            'id' => $factura->ID_FORMULARIO_FACTURACION,
                            'numero' => $factura->FOLIO_FISCAL
                                ?: $factura->NO_FACTURA_EXTRANJERO,
                            'fecha' => $factura->FECHA_FACTURA
                                ?: $factura->FECHA_FACTURA_EXTRANJERO,
                            'created_at' => $factura->created_at,
                            'factura_pdf' => $factura->FACTURA_PDF,
                            'archivo_rep' => $factura->ARCHIVO_REP
                        ];
                    })
                    ->values()
                    ->all();

                $resultado->push($principal);

                foreach ($facturasGrupo as $factura) {
                    $procesadas[] = (int) $factura->ID_FORMULARIO_FACTURACION;
                }
            }

            foreach ($tabla as $factura) {

                $id = (int) $factura->ID_FORMULARIO_FACTURACION;

                if (in_array($id, $procesadas)) {
                    continue;
                }

                $factura->ES_GRUPO = false;

                $factura->ID_GRUPO_REP = null;

                $factura->IDS_FACTURAS_GRUPO = [$id];

                $factura->FACTURAS_AGRUPADAS = [
                    [
                        'id' => $id,
                        'numero' => $factura->FOLIO_FISCAL
                            ?: $factura->NO_FACTURA_EXTRANJERO,
                        'fecha' => $factura->FECHA_FACTURA
                            ?: $factura->FECHA_FACTURA_EXTRANJERO,
                        'created_at' => $factura->created_at,
                        'factura_pdf' => $factura->FACTURA_PDF,
                        'archivo_rep' => $factura->ARCHIVO_REP
                    ]
                ];

                $resultado->push($factura);
            }

            foreach ($resultado as $value) {

                $id = $value->ID_FORMULARIO_FACTURACION;

                $value->RFC_PROVEEDOR_TEXTO =
                    ($value->RAZON_SOCIAL_ALTA ?? 'SIN NOMBRE')
                    . ' ('
                    . ($value->RFC_ALTA ?? $value->RFC_PROVEEDOR)
                    . ')';

                if ($value->ACTIVO == 0) {

                    $value->BTN_VISUALIZAR =
                        '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';

                    $value->BTN_ELIMINAR =
                        '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $id . '"><span class="slider round"></span></label>';

                    $value->BTN_EDITAR =
                        '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {

                    $value->BTN_ELIMINAR =
                        '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $id . '" checked><span class="slider round"></span></label>';

                    $value->BTN_EDITAR =
                        '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';

                    $value->BTN_VISUALIZAR =
                        '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';



                        
                }

                $value->BTN_REP =
                    '<button type="button" class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-rep" data-id="' . $id . '" title="Ver REP"><i class="bi bi-filetype-pdf"></i></button>';

                $value->BTN_FACTURA =
                    '<button type="button" class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-factura" data-id="' . $id . '" title="Ver factura"><i class="bi bi-filetype-pdf"></i></button>';



                $value->BTN_COMPROBANTE =
                    '<button type="button" class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-comprobante" data-id="' . $id . '" title="Ver comprobante de pago "><i class="bi bi-filetype-pdf"></i></button>';





                if ($value->TIPO_FACTURA == 'CONTRATO') {

                    $value->TIPO_FACTURA_FORMATO =
                        'Contrato (No. ' . e($value->NO_CONTRATO) . ')';
                } elseif ($value->TIPO_FACTURA == 'OC') {

                    $value->TIPO_FACTURA_FORMATO =
                        'Orden de Compra y Recepción <br> (PO: '
                        . e($value->NO_PO)
                        . ' | GR: '
                        . e($value->NO_GR)
                        . ')';
                } else {

                    $value->TIPO_FACTURA_FORMATO = e($value->TIPO_FACTURA);
                }

                if ($value->ESTATUS_FACTURA == 1) {

                    $value->ESTADO_FACTURA_TEXTO =
                        '<span class="badge bg-success">Aprobada</span>';
                } elseif ($value->ESTATUS_FACTURA == 2) {

                    $value->ESTADO_FACTURA_TEXTO =
                        '<span class="badge bg-danger">Rechazada</span>';
                } else {

                    $value->ESTADO_FACTURA_TEXTO =
                        '<span class="badge bg-secondary">En revisión</span>';
                }

                $value->BTN_VOBO = '
                <div class="d-flex flex-column align-items-center gap-2">

                    <button type="button"
                        class="btn btn-success btn-custom rounded-pill aprobar-rep"
                        data-id="' . $id . '"
                        title="Aprobar REP">
                        <i class="bi bi-check-circle"></i>
                    </button>

                    <button type="button"
                        class="btn btn-danger btn-custom rounded-pill rechazar-rep"
                        data-id="' . $id . '"
                        title="Rechazar REP">
                        <i class="bi bi-x-circle"></i>
                    </button>

                </div>';
            }

            return response()->json([
                'data' => $resultado->values(),
                'msj' => 'Información consultada correctamente'
            ]);
        } catch (\Throwable $e) {

            return response()->json([
                'msj' => 'Error ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }




    // public function aprobarRechazarREP(Request $request)
    // {
    //     try {

    //         $request->validate([
    //             'id' => 'required',
    //             'estatus' => 'required|in:1,2'
    //         ]);

    //         $factura = facturacionModel::where('ID_FORMULARIO_FACTURACION', $request->id)->first();

    //         if (!$factura) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Factura no encontrada'
    //             ]);
    //         }

    //         $factura->ESTATUS_REP = $request->estatus;

    //         if ($request->estatus == 2) {
    //             $factura->MOTIVO_RECHAZO_REP = $request->justificacion;
    //         } else {
    //             $factura->MOTIVO_RECHAZO_REP = null;
    //         }

    //         $factura->save();

    //         $proveedor = DB::table('formulario_altaproveedor')->where('RFC_ALTA', $factura->RFC_PROVEEDOR)->orderBy('ID_FORMULARIO_ALTA', 'desc')->first();

    //         if ($proveedor && $proveedor->CORREO_DIRECTORIO) {

    //             Mail::send('emails.rep_estatus', [
    //                 'proveedor' => $proveedor,
    //                 'factura' => $factura,
    //                 'estatus' => $request->estatus,
    //                 'justificacion' => $request->justificacion
    //             ], function ($mail) use ($proveedor, $request) {

    //                 $asunto = $request->estatus == 1 ? 'Recibo Electrónico de Pago aprobado' : 'Recibo Electrónico de Pago rechazado';

    //                 $mail->to($proveedor->CORREO_DIRECTORIO)->subject($asunto);
    //             });
    //         }

    //         return response()->json([
    //             'success' => true,
    //             'message' => $request->estatus == 1 ? 'Recibo Electrónico de Pago aprobado correctamente' : 'Recibo Electrónico de Pago rechazado correctamente'
    //         ]);
    //     } catch (\Exception $e) {

    //         return response()->json([
    //             'success' => false,
    //             'message' => $e->getMessage()
    //         ]);
    //     }
    // }




    public function aprobarRechazarREP(Request $request)
    {
        try {

            $request->validate([
                'ids' => 'required|array|min:1',
                'ids.*' => 'required|integer|distinct',
                'estatus' => 'required|in:1,2',
                'justificacion' => 'required_if:estatus,2'
            ]);

            $facturas = facturacionModel::whereIn(
                'ID_FORMULARIO_FACTURACION',
                $request->ids
            )
                ->where('ESTATUS_FACTURA', 1)
                ->whereRaw("UPPER(TRIM(METODO_PAGO)) = 'PPD'")
                ->where('SUBIR_REP', 1)
                ->whereNull('ESTATUS_REP')
                ->get();

            if ($facturas->count() != count($request->ids)) {

                return response()->json([
                    'success' => false,
                    'message' => 'Una o varias facturas no están disponibles para revisión'
                ]);
            }

            if ($facturas->pluck('RFC_PROVEEDOR')->unique()->count() != 1) {

                return response()->json([
                    'success' => false,
                    'message' => 'Las facturas deben pertenecer al mismo proveedor'
                ]);
            }

            $estatus = $request->estatus;

            $justificacion = $estatus == 2
                ? $request->justificacion
                : null;

            DB::transaction(function () use ($facturas, $estatus, $justificacion) {

                foreach ($facturas as $factura) {

                    $factura->ESTATUS_REP = $estatus;

                    $factura->MOTIVO_RECHAZO_REP = $justificacion;

                    $factura->save();
                }
            });

            $proveedor = DB::table('formulario_altaproveedor')
                ->where('RFC_ALTA', $facturas->first()->RFC_PROVEEDOR)
                ->orderBy('ID_FORMULARIO_ALTA', 'desc')
                ->first();

            $advertencia = null;

            if ($proveedor && $proveedor->CORREO_DIRECTORIO) {

                try {

                    Mail::send('emails.rep_estatus', [
                        'proveedor' => $proveedor,
                        'facturas' => $facturas,
                        'estatus' => $estatus,
                        'justificacion' => $justificacion
                    ], function ($mail) use ($proveedor, $estatus) {

                        $asunto = $estatus == 1
                            ? 'Recibo Electrónico de Pago aprobado'
                            : 'Recibo Electrónico de Pago rechazado';

                        $mail->to($proveedor->CORREO_DIRECTORIO)
                            ->subject($asunto);
                    });
                } catch (\Exception $e) {

                    report($e);

                    $advertencia = 'Las facturas se actualizaron correctamente, pero no se pudo enviar el correo.';
                }
            } else {

                $advertencia = 'Las facturas se actualizaron correctamente, pero el proveedor no tiene correo registrado.';
            }

            return response()->json([
                'success' => true,
                'message' => $estatus == 1
                    ? 'Recibo Electrónico de Pago aprobado correctamente'
                    : 'Recibo Electrónico de Pago rechazado correctamente',
                'facturas_actualizadas' => $facturas->count(),
                'advertencia' => $advertencia
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
