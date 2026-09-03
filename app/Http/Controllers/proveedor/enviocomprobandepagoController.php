<?php

namespace App\Http\Controllers\proveedor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use App\Models\proveedor\facturacionModel;


use DB;


class enviocomprobandepagoController extends Controller
{




    public function Tablacomprobantedepago()
    {
        try {

            $tabla = DB::table('formulario_facturasproveedores as cp')
                ->leftJoin(
                    'formulario_altaproveedor as fa',
                    'cp.RFC_PROVEEDOR',
                    '=',
                    'fa.RFC_ALTA'
                )
                ->select(
                    'cp.*',
                    'fa.RAZON_SOCIAL_ALTA',
                    'fa.RFC_ALTA'
                )
                ->where(function ($query) {
                    $query->whereNull('cp.SUBIR_RECIBO_PAGO')
                        ->orWhere('cp.SUBIR_RECIBO_PAGO', '');
                })
                ->whereExists(function ($subquery) {
                    $subquery->select(DB::raw(1))
                        ->from('relacionpagosproveedores as rp')
                        ->whereRaw("
                        JSON_SEARCH(
                            rp.JSON_RELACIONES,
                            'one',
                            CAST(cp.ID_FORMULARIO_FACTURACION AS CHAR),
                            NULL,
                            '$[*].ID_FORMULARIO_FACTURACION'
                        ) IS NOT NULL
                    ");
                })
                ->get();

            foreach ($tabla as $value) {

                $value->RFC_PROVEEDOR_TEXTO = ($value->RAZON_SOCIAL_ALTA ?? 'SIN NOMBRE') .' (' .($value->RFC_ALTA ?? $value->RFC_PROVEEDOR) .')';

             
                $value->BTN_SUBIR_RECIBO_PAGO = '<button type="button" class="btn btn-success btn-custom rounded-pill SUBIR_RECIBO_PAGO" data-id="' . $value->ID_FORMULARIO_FACTURACION . '"
                    data-proveedor="' . htmlspecialchars($value->RAZON_SOCIAL_ALTA ?? 'SIN NOMBRE',ENT_QUOTES,'UTF-8') . '" title="Subir comprobante de pago" >
                    <i class="bi bi-cloud-arrow-up-fill"></i>
                </button>';

                if ($value->ACTIVO == 0) {

                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"> <i class="bi bi-eye"></i></button>';

                    $value->BTN_ELIMINAR = '<label class="switch"> <input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_FACTURACION . '"><span class="slider round"></span>
                    </label>';

                    $value->BTN_EDITAR =
                        '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';

                    $value->BTN_SOPORTES = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-soportes" data-id="' . $value->ID_FORMULARIO_FACTURACION . '"
                        title="Ver documento"><i class="bi bi-filetype-pdf"></i></button>';

                    $value->BTN_FACTURA = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-factura" data-id="' . $value->ID_FORMULARIO_FACTURACION . '"
                        title="Ver documento"><i class="bi bi-filetype-pdf"></i></button>';
                } else {

                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_FACTURACION . '" checked>
                        <span class="slider round"></span></label>';

                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';

                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';

                    $value->BTN_SOPORTES = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-soportes" data-id="' . $value->ID_FORMULARIO_FACTURACION . '"
                        title="Ver documento"><i class="bi bi-filetype-pdf"></i></button>';

                    $value->BTN_FACTURA = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-factura" data-id="' . $value->ID_FORMULARIO_FACTURACION . '"
                        title="Ver documento"><i class="bi bi-filetype-pdf"></i></button>';
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
                    $value->ESTADO_FACTURA_TEXTO ='<span class="badge bg-secondary">En revisión</span>';
                }
            }

            return response()->json([
                'data' => $tabla,
                'msj'  => 'Información consultada correctamente'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'msj'  => 'Error ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }



    public function cargarcomprobantepago(Request $request)
    {
        try {

            $factura = facturacionModel::where('ID_FORMULARIO_FACTURACION', $request->ID_FORMULARIO_FACTURACION)->first();

            if (!$factura) {
                return response()->json([
                    'success' => false,
                    'message' => 'Factura no encontrada.'
                ], 404);
            }

            if (!is_null($factura->SUBIR_RECIBO_PAGO) && $factura->SUBIR_RECIBO_PAGO != '' && $factura->SUBIR_RECIBO_PAGO != 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Esta factura ya tiene un comprobante de pago.'
                ]);
            }

            if (!$request->hasFile('ARCHIVO_RECIBO_PAGO')) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se seleccionó ningún comprobante de pago.'
                ]);
            }

            $proveedor = DB::table('formulario_altaproveedor')->where('RFC_ALTA', $factura->RFC_PROVEEDOR)->orderBy('ID_FORMULARIO_ALTA', 'desc')->first();

            $rfc = $factura->RFC_PROVEEDOR;
            $file = $request->file('ARCHIVO_RECIBO_PAGO');
            $folderPath = "proveedores/{$rfc}/Facturas/{$factura->ID_FORMULARIO_FACTURACION}/Recibo de pago/{$factura->ID_FORMULARIO_FACTURACION}";
            $fileName = $file->getClientOriginalName();
            $filePath = $file->storeAs($folderPath, $fileName);

            if (!$filePath) {
                return response()->json([
                    'success' => false,
                    'message' => 'No fue posible guardar el comprobante de pago.'
                ]);
            }

            $factura->ARCHIVO_RECIBO_PAGO = $filePath;
            $factura->SUBIR_RECIBO_PAGO = 1;
            $factura->save();

            if (!$proveedor) {
                return response()->json([
                    'success' => true,
                    'correo_enviado' => false,
                    'message' => 'El comprobante se guardó correctamente, pero no se encontró la información del proveedor.'
                ]);
            }

            if (!$proveedor->CORREO_DIRECTORIO) {
                return response()->json([
                    'success' => true,
                    'correo_enviado' => false,
                    'message' => 'El comprobante se guardó correctamente, pero el proveedor no tiene correo registrado.'
                ]);
            }

            try {

                $rutaArchivoCompleta = storage_path('app/' . $filePath);

                Mail::send('emails.enviarcomprobantepago', [
                    'proveedor' => $proveedor,
                    'factura' => $factura
                ], function ($mail) use ($proveedor, $rutaArchivoCompleta, $fileName) {

                    $mail->to($proveedor->CORREO_DIRECTORIO)->subject('Comprobante de pago disponible');

                    $mail->attach($rutaArchivoCompleta, [
                        'as' => $fileName,
                        'mime' => 'application/pdf'
                    ]);
                });
            } catch (\Exception $correoError) {

                return response()->json([
                    'success' => true,
                    'correo_enviado' => false,
                    'message' => 'El comprobante se guardó correctamente, pero ocurrió un error al enviar el correo.',
                    'error_correo' => $correoError->getMessage()
                ]);
            }

            return response()->json([
                'success' => true,
                'correo_enviado' => true,
                'message' => 'El comprobante de pago se guardó y el correo se envió correctamente.'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Error al subir el comprobante de pago: ' . $e->getMessage()
            ], 500);
        }
    }


    public function store(Request $request)
    {
        try {
            switch (intval($request->api)) {

                case 1:

                    $requestData = $request->all();
                    $rfc = $requestData['RFC_PROVEEDOR'] ?? null;

                    if ($request->ID_FORMULARIO_FACTURACION == 0) {
                        DB::statement('ALTER TABLE formulario_facturasproveedores AUTO_INCREMENT=1;');

                        $cuentas = facturacionModel::create($requestData);

                        if ($request->hasFile('DOCUMENTOS_SOPORTE_FACTURA')) {
                            $file = $request->file('DOCUMENTOS_SOPORTE_FACTURA');
                            $folderPath = "proveedores/{$rfc}/Facturas/{$cuentas->ID_FORMULARIO_FACTURACION}/Documentos de soporte";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);
                            $cuentas->DOCUMENTOS_SOPORTE_FACTURA = $filePath;
                            $cuentas->save();
                        }

                        if ($request->hasFile('FACTURA_PDF')) {
                            $file = $request->file('FACTURA_PDF');
                            $folderPath = "proveedores/{$rfc}/Facturas/{$cuentas->ID_FORMULARIO_FACTURACION}/Documento factura";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);
                            $cuentas->FACTURA_PDF = $filePath;
                            $cuentas->save();
                        }

                        if ($request->hasFile('FACTURA_XML')) {
                            $file = $request->file('FACTURA_XML');
                            $folderPath = "proveedores/{$rfc}/Facturas/{$cuentas->ID_FORMULARIO_FACTURACION}/XML factura";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);
                            $cuentas->FACTURA_XML = $filePath;
                            $cuentas->save();
                        }

                        if ($request->hasFile('ARCHIVO_REP')) {
                            $file = $request->file('ARCHIVO_REP');
                            $folderPath = "proveedores/{$rfc}/Facturas/{$cuentas->ID_FORMULARIO_FACTURACION}/Recibo Electrónico de Pago/PDF/{$cuentas->ID_FORMULARIO_FACTURACION}";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);
                            $cuentas->ARCHIVO_REP = $filePath;
                            $cuentas->save();
                        }

                        if ($request->hasFile('XML_REP')) {
                            $file = $request->file('XML_REP');
                            $folderPath = "proveedores/{$rfc}/Facturas/{$cuentas->ID_FORMULARIO_FACTURACION}/Recibo Electrónico de Pago/XML/{$cuentas->ID_FORMULARIO_FACTURACION}";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);
                            $cuentas->XML_REP = $filePath;
                            $cuentas->save();
                        }


                        if ($request->hasFile('ARCHIVO_RECIBO_PAGO')) {
                            $file = $request->file('ARCHIVO_RECIBO_PAGO');
                            $folderPath = "proveedores/{$rfc}/Facturas/{$cuentas->ID_FORMULARIO_FACTURACION}/Recibo de pago/{$cuentas->ID_FORMULARIO_FACTURACION}";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);
                            $cuentas->ARCHIVO_RECIBO_PAGO = $filePath;
                            $cuentas->save();
                        }
                    } else {
                        $cuentas = facturacionModel::find($request->ID_FORMULARIO_FACTURACION);

                        if (isset($request->ELIMINAR)) {
                            $cuentas->ACTIVO = $request->ELIMINAR == 1 ? 0 : 1;
                            $cuentas->save();

                            $response['code'] = 1;
                            $response['cuenta'] = $request->ELIMINAR == 1 ? 'Desactivada' : 'Activada';
                            return response()->json($response);
                        }

                        if ($request->hasFile('DOCUMENTOS_SOPORTE_FACTURA')) {
                            if ($cuentas->DOCUMENTOS_SOPORTE_FACTURA && Storage::exists($cuentas->DOCUMENTOS_SOPORTE_FACTURA)) {
                                Storage::delete($cuentas->DOCUMENTOS_SOPORTE_FACTURA);
                            }
                            $file = $request->file('DOCUMENTOS_SOPORTE_FACTURA');
                            $folderPath = "proveedores/{$rfc}/Facturas/{$cuentas->ID_FORMULARIO_FACTURACION}/Documentos de soporte";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);
                            $requestData['DOCUMENTOS_SOPORTE_FACTURA'] = $filePath;
                        }

                        if ($request->hasFile('FACTURA_PDF')) {
                            if ($cuentas->FACTURA_PDF && Storage::exists($cuentas->FACTURA_PDF)) {
                                Storage::delete($cuentas->FACTURA_PDF);
                            }
                            $file = $request->file('FACTURA_PDF');
                            $folderPath = "proveedores/{$rfc}/Facturas/{$cuentas->ID_FORMULARIO_FACTURACION}/Documento factura";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);
                            $requestData['FACTURA_PDF'] = $filePath;
                        }

                        if ($request->hasFile('FACTURA_XML')) {
                            if ($cuentas->FACTURA_XML && Storage::exists($cuentas->FACTURA_XML)) {
                                Storage::delete($cuentas->FACTURA_XML);
                            }
                            $file = $request->file('FACTURA_XML');
                            $folderPath = "proveedores/{$rfc}/Facturas/{$cuentas->ID_FORMULARIO_FACTURACION}/XML factura";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);
                            $requestData['FACTURA_XML'] = $filePath;
                        }

                        if ($request->hasFile('ARCHIVO_REP')) {
                            if ($cuentas->ARCHIVO_REP && Storage::exists($cuentas->ARCHIVO_REP)) {
                                Storage::delete($cuentas->ARCHIVO_REP);
                            }
                            $file = $request->file('ARCHIVO_REP');
                            $folderPath = "proveedores/{$rfc}/Facturas/{$cuentas->ID_FORMULARIO_FACTURACION}/Recibo Electrónico de Pago/PDF/{$cuentas->ID_FORMULARIO_FACTURACION}";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);
                            $requestData['ARCHIVO_REP'] = $filePath;
                        }

                        if ($request->hasFile('XML_REP')) {
                            if ($cuentas->XML_REP && Storage::exists($cuentas->XML_REP)) {
                                Storage::delete($cuentas->XML_REP);
                            }
                            $file = $request->file('XML_REP');
                            $folderPath = "proveedores/{$rfc}/Facturas/{$cuentas->ID_FORMULARIO_FACTURACION}/Recibo Electrónico de Pago/XML/{$cuentas->ID_FORMULARIO_FACTURACION}";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);
                            $requestData['XML_REP'] = $filePath;
                        }

                        if ($request->hasFile('ARCHIVO_RECIBO_PAGO')) {
                            if ($cuentas->ARCHIVO_RECIBO_PAGO && Storage::exists($cuentas->ARCHIVO_RECIBO_PAGO)) {
                                Storage::delete($cuentas->ARCHIVO_RECIBO_PAGO);
                            }
                            $file = $request->file('ARCHIVO_RECIBO_PAGO');
                            $folderPath = "proveedores/{$rfc}/Facturas/{$cuentas->ID_FORMULARIO_FACTURACION}/Recibo de pago/{$cuentas->ID_FORMULARIO_FACTURACION}";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);
                            $requestData['ARCHIVO_RECIBO_PAGO'] = $filePath;
                        }



                        $cuentas->update(collect($requestData)->except('RFC_PROVEEDOR')->toArray());

                        $response['code'] = 1;
                        $response['cuenta'] = 'Actualizada';
                        return response()->json($response);
                    }
                    break;

                default:
                    $response['code']  = 1;
                    $response['msj']  = 'Api no encontrada';
                    return response()->json($response);
            }
        } catch (Exception $e) {
            return response()->json('Error al guardar ');
        }
    }

}
