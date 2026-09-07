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
                ->where('cp.SUBIR_RECIBO_PAGO', 1)
                ->whereNull('cp.ESTATUS_REP')
                ->get();

            foreach ($tabla as $value) {

                $value->RFC_PROVEEDOR_TEXTO = ($value->RAZON_SOCIAL_ALTA ?? 'SIN NOMBRE') . ' (' . ($value->RFC_ALTA ?? $value->RFC_PROVEEDOR) . ')';

                if ($value->ACTIVO == 0) {

                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';

                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_FACTURACION . '"><span class="slider round"></span></label>';

                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';

                    $value->BTN_REP = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-rep" data-id="' . $value->ID_FORMULARIO_FACTURACION . '" title="Ver documento"><i class="bi bi-filetype-pdf"></i></button>';

                    $value->BTN_FACTURA = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-factura" data-id="' . $value->ID_FORMULARIO_FACTURACION . '" title="Ver documento"><i class="bi bi-filetype-pdf"></i></button>';
                } else {

                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_FACTURACION . '" checked><span class="slider round"></span></label>';

                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';

                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';

                    $value->BTN_REP = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-rep" data-id="' . $value->ID_FORMULARIO_FACTURACION . '" title="Ver documento"><i class="bi bi-filetype-pdf"></i></button>';

                    $value->BTN_FACTURA = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-factura" data-id="' . $value->ID_FORMULARIO_FACTURACION . '" title="Ver documento"><i class="bi bi-filetype-pdf"></i></button>';
                }

                if ($value->TIPO_FACTURA == 'CONTRATO') {

                    $value->TIPO_FACTURA_FORMATO = 'Contrato (No. ' . $value->NO_CONTRATO . ')';
                } elseif ($value->TIPO_FACTURA == 'OC') {

                    $value->TIPO_FACTURA_FORMATO = 'Orden de Compra y Recepción <br> (PO: ' . $value->NO_PO . ' | GR: ' . $value->NO_GR . ')';
                } else {

                    $value->TIPO_FACTURA_FORMATO = $value->TIPO_FACTURA;
                }

                if ($value->ESTATUS_FACTURA == 1) {

                    $value->ESTADO_FACTURA_TEXTO = '<span class="badge bg-success">Aprobada</span>';
                } elseif ($value->ESTATUS_FACTURA == 2) {

                    $value->ESTADO_FACTURA_TEXTO = '<span class="badge bg-danger">Rechazada</span>';
                } else {

                    $value->ESTADO_FACTURA_TEXTO = '<span class="badge bg-secondary">En revisión</span>';
                }


                $value->BTN_VOBO = '
                    <div class="d-flex flex-column align-items-center gap-2">
                        <button type="button" class="btn btn-success btn-custom rounded-pill aprobar-rep" data-id="' . $value->ID_FORMULARIO_FACTURACION . '"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Aprobar REP"><i class="bi bi-check-circle"></i>
                        </button>

                        <button type="button" class="btn btn-danger btn-custom rounded-pill rechazar-rep" data-id="' . $value->ID_FORMULARIO_FACTURACION . '"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Rechazar REP"> <i class="bi bi-x-circle"></i>
                        </button>
                    </div>';

            }

            return response()->json([
                'data' => $tabla,
                'msj' => 'Información consultada correctamente'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'msj' => 'Error ' . $e->getMessage(),
                'data' => 0
            ]);
        }
    }




    public function aprobarRechazarREP(Request $request)
    {
        try {

            $request->validate([
                'id' => 'required',
                'estatus' => 'required|in:1,2'
            ]);

            $factura = facturacionModel::where('ID_FORMULARIO_FACTURACION', $request->id)->first();

            if (!$factura) {
                return response()->json([
                    'success' => false,
                    'message' => 'Factura no encontrada'
                ]);
            }

            $factura->ESTATUS_REP = $request->estatus;

            if ($request->estatus == 2) {
                $factura->MOTIVO_RECHAZO_REP = $request->justificacion;
            } else {
                $factura->MOTIVO_RECHAZO_REP = null;
            }

            $factura->save();

            $proveedor = DB::table('formulario_altaproveedor')->where('RFC_ALTA', $factura->RFC_PROVEEDOR)->orderBy('ID_FORMULARIO_ALTA', 'desc')->first();

            if ($proveedor && $proveedor->CORREO_DIRECTORIO) {

                Mail::send('emails.rep_estatus', [
                    'proveedor' => $proveedor,
                    'factura' => $factura,
                    'estatus' => $request->estatus,
                    'justificacion' => $request->justificacion
                ], function ($mail) use ($proveedor, $request) {

                    $asunto = $request->estatus == 1 ? 'Recibo Electrónico de Pago aprobado' : 'Recibo Electrónico de Pago rechazado';

                    $mail->to($proveedor->CORREO_DIRECTORIO)->subject($asunto);
                });
            }

            return response()->json([
                'success' => true,
                'message' => $request->estatus == 1 ? 'Recibo Electrónico de Pago aprobado correctamente' : 'Recibo Electrónico de Pago rechazado correctamente'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }




}
