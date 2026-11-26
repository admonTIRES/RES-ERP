<?php

namespace App\Http\Controllers\proveedor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Models\proveedor\facturacionModel;
use Illuminate\Support\Facades\Crypt;
use DB;

/// PDF ORDEN DE COMPRA

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\ordencompra\poModel;
use App\Models\proveedor\directorioModel;
use App\Models\proveedor\altaproveedorModel;


/// PDF GR 

use Illuminate\Support\Facades\App;
use App\Models\proveedor\proveedortempModel;



class listafacturasController extends Controller
{


    public function Tablalistafacturasproveedores()
    {
        try {
            $tabla = DB::table('formulario_facturasproveedores as cp')
                ->leftJoin('formulario_altaproveedor as fa', 'cp.RFC_PROVEEDOR', '=', 'fa.RFC_ALTA')
                ->select(
                    'cp.*',
                    'fa.RAZON_SOCIAL_ALTA',
                    'fa.RFC_ALTA'
                )
                ->whereNull('cp.ESTATUS_FACTURA')

                ->get();

            foreach ($tabla as $value) {

                $value->RFC_PROVEEDOR_TEXTO = ($value->RAZON_SOCIAL_ALTA ?? 'SIN NOMBRE') .' (' . ($value->RFC_ALTA ?? $value->RFC_PROVEEDOR) . ')';

                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_FACTURACION . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                    $value->BTN_SOPORTES = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-soportes" data-id="' . $value->ID_FORMULARIO_FACTURACION . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                    $value->BTN_FACTURA = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-factura" data-id="' . $value->ID_FORMULARIO_FACTURACION . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_FACTURACION . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_SOPORTES = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-soportes" data-id="' . $value->ID_FORMULARIO_FACTURACION . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                    $value->BTN_FACTURA = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-factura" data-id="' . $value->ID_FORMULARIO_FACTURACION . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                }

                if ($value->TIPO_FACTURA == 'CONTRATO') {
                    $value->TIPO_FACTURA_FORMATO = 'Contrato (No. ' . $value->NO_CONTRATO . ')';

                } elseif ($value->TIPO_FACTURA == 'OC') {

                    $poCifrado = rtrim(strtr(base64_encode(
                        Crypt::encryptString((string) $value->NO_PO)
                    ), '+/', '-_'), '=');

                    $grCifrado = rtrim(strtr(base64_encode(
                        Crypt::encryptString((string) $value->NO_GR)
                    ), '+/', '-_'), '=');

                    $po = htmlspecialchars($value->NO_PO ?? '', ENT_QUOTES, 'UTF-8');
                    $gr = htmlspecialchars($value->NO_GR ?? '', ENT_QUOTES, 'UTF-8');

                    $value->TIPO_FACTURA_FORMATO = '
                            Orden de Compra y Recepción <br>
                            (
                                PO: <a href="/generarpofactura/' . $poCifrado . '" target="_blank" rel="noopener noreferrer">' . $po . '</a>
                                |
                                GR: <a href="/generargrfactura/' . $grCifrado . '" target="_blank" rel="noopener noreferrer">' . $gr . '</a>
                            )
                        ';
                }
                
                else {
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
                        <button type="button" class="btn btn-success btn-custom rounded-pill aprobar-doc" data-id="' . $value->ID_FORMULARIO_FACTURACION . '"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Aprobar factura"><i class="bi bi-check-circle"></i>
                        </button>

                        <button type="button" class="btn btn-danger btn-custom rounded-pill rechazar-doc" data-id="' . $value->ID_FORMULARIO_FACTURACION . '"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Rechazar factura"> <i class="bi bi-x-circle"></i>
                        </button>
                    </div>';


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




    public function aprobarRechazarFactura(Request $request)
    {
        try {

            $request->validate([
                'id' => 'required',
                'estatus' => 'required|in:1,2'
            ]);

          

            $factura = facturacionModel::where(
                'ID_FORMULARIO_FACTURACION',
                $request->id
            )->first();

            if (!$factura) {

                return response()->json([
                    'success' => false,
                    'message' => 'Factura no encontrada'
                ]);
            }

           

            $factura->ESTATUS_FACTURA = $request->estatus;

         

            if ($request->estatus == 2) {

                $factura->MOTIVO_RECHAZO_FACTURA = $request->justificacion;
            } else {

                $factura->MOTIVO_RECHAZO_FACTURA = null;
            }

          

            $factura->save();

           

            $proveedor = DB::table('formulario_altaproveedor')
                ->where('RFC_ALTA', $factura->RFC_PROVEEDOR)
                ->orderBy('ID_FORMULARIO_ALTA', 'desc')
                ->first();

         

            if ($proveedor && $proveedor->CORREO_DIRECTORIO) {

                Mail::send(

                    'emails.factura_estatus',

                    [
                        'proveedor' => $proveedor,
                        'factura' => $factura,
                        'estatus' => $request->estatus,
                        'justificacion' => $request->justificacion
                    ],

                    function ($mail) use ($proveedor, $request) {

                        $asunto = $request->estatus == 1
                            ? 'Factura aprobada'
                            : 'Factura rechazada';

                        $mail->to($proveedor->CORREO_DIRECTORIO)
                            ->subject($asunto);
                    }
                );
            }

           

            return response()->json([
                'success' => true,
                'message' => $request->estatus == 1
                    ? 'Factura aprobada correctamente'
                    : 'Factura rechazada correctamente'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }




    public function generarpofactura($numero)
    {
        try {
            $numeroBase64 = strtr($numero, '-_', '+/');
            $numeroBase64 .= str_repeat('=', (4 - strlen($numeroBase64) % 4) % 4);

            $numeroCifrado = base64_decode($numeroBase64, true);

            if ($numeroCifrado === false) {
                return response()->json(['error' => 'Enlace inválido'], 404);
            }

            try {
                $numero = Crypt::decryptString($numeroCifrado);
            } catch (\Throwable $e) {
                return response()->json(['error' => 'Enlace inválido o expirado'], 404);
            }

            $orden = poModel::where('NO_PO', $numero)->first();

            if (!$orden) {
                return response()->json(['error' => 'Orden no encontrada'], 404);
            }

            $proveedor = directorioModel::where(
                'RFC_PROVEEDOR',
                $orden->PROVEEDOR_SELECCIONADO
            )->first();

            $proveedor1 = altaproveedorModel::where(
                'RFC_ALTA',
                $orden->PROVEEDOR_SELECCIONADO
            )->first();

            $usuarioSolicito = DB::table('usuarios')
                ->select(
                    'EMPLEADO_NOMBRE',
                    'EMPLEADO_APELLIDOPATERNO',
                    'EMPLEADO_APELLIDOMATERNO'
                )
                ->where('ID_USUARIO', $orden->USUARIO_ID)
                ->first();

            $usuarioAprobo = DB::table('usuarios')
                ->select(
                    'EMPLEADO_NOMBRE',
                    'EMPLEADO_APELLIDOPATERNO',
                    'EMPLEADO_APELLIDOMATERNO'
                )
                ->where('ID_USUARIO', $orden->APROBO_ID)
                ->first();

            $pdf = Pdf::loadView(
                'pdf.po_pdf',
                compact(
                    'orden',
                    'proveedor',
                    'proveedor1',
                    'usuarioSolicito',
                    'usuarioAprobo'
                )
            );

            return $pdf->stream("PO_{$orden->NO_PO}.pdf");
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Error al generar el PDF: ' . $e->getMessage()
            ], 500);
        }
    }


    public function generargrfactura($numero)
    {
        try {
            $numeroBase64 = strtr($numero, '-_', '+/');
            $numeroBase64 .= str_repeat('=', (4 - strlen($numeroBase64) % 4) % 4);

            $numeroCifrado = base64_decode($numeroBase64, true);

            if ($numeroCifrado === false) {
                return response()->json(['error' => 'Enlace inválido'], 404);
            }

            try {
                $numero = Crypt::decryptString($numeroCifrado);
            } catch (\Throwable $e) {
                return response()->json(['error' => 'Enlace inválido o expirado'], 404);
            }

            $orden = DB::table('formulario_bitacoragr')
                ->where('NO_RECEPCION', $numero)
                ->first();

            if (!$orden) {
                return response()->json([
                    'error' => 'No se encontró la GR con ese número de recepción.'
                ], 404);
            }

            if (trim($orden->FINALIZAR_GR ?? '') !== 'Sí') {
                return response()->json([
                    'error' => 'La GR no está finalizada aún. Solo se puede visualizar cuando está finalizada.'
                ], 400);
            }

            $proveedor = null;

            if (!empty($orden->PROVEEDOR_KEY)) {
                $proveedor = directorioModel::where(
                    'RFC_PROVEEDOR',
                    $orden->PROVEEDOR_KEY
                )->first();
            }

            if (!$proveedor && !empty($orden->PROVEEDOR_KEY)) {
                $temp = proveedortempModel::where(
                    'RAZON_PROVEEDORTEMP',
                    $orden->PROVEEDOR_KEY
                )->first();

                if ($temp) {
                    $proveedor = (object)[
                        'TIPO_PERSONA' => 'TEMP',
                        'RAZON_SOCIAL' => $temp->RAZON_PROVEEDORTEMP ?: 'N/P',
                        'RFC_PROVEEDOR' => $temp->RFC_PROVEEDORTEMP ?: 'N/P',
                        'NOMBRE_DIRECTORIO' => '',
                        'TIPO_VIALIDAD_EMPRESA' => '',
                        'NOMBRE_VIALIDAD_EMPRESA' => '',
                        'NUMERO_EXTERIOR_EMPRESA' => '',
                        'NUMERO_INTERIOR_EMPRESA' => '',
                        'NOMBRE_COLONIA_EMPRESA' => '',
                        'CODIGO_POSTAL' => '',
                        'NOMBRE_LOCALIDAD_EMPRESA' => '',
                        'NOMBRE_ENTIDAD_EMPRESA' => '',
                        'PAIS_EMPRESA' => '',
                        'TELEFONO_DIRECOTORIO' => '',
                        'CELULAR_DIRECTORIO' => '',
                        'CORREO_DIRECTORIO' => '',
                        'DOMICILIO_EXTRANJERO' => '',
                        'DEPARTAMENTO_EXTRANJERO' => '',
                        'CODIGO_EXTRANJERO' => '',
                        'ESTADO_EXTRANJERO' => '',
                        'CIUDAD_EXTRANJERO' => '',
                        'PAIS_EXTRANJERO' => ''
                    ];
                }
            }

            if (!$proveedor) {
                $proveedor = (object)[
                    'TIPO_PERSONA' => '1',
                    'RAZON_SOCIAL' => 'N/P',
                    'RFC_PROVEEDOR' => 'N/P',
                    'NOMBRE_DIRECTORIO' => '',
                    'TIPO_VIALIDAD_EMPRESA' => '',
                    'NOMBRE_VIALIDAD_EMPRESA' => '',
                    'NUMERO_EXTERIOR_EMPRESA' => '',
                    'NUMERO_INTERIOR_EMPRESA' => '',
                    'NOMBRE_COLONIA_EMPRESA' => '',
                    'CODIGO_POSTAL' => '',
                    'NOMBRE_LOCALIDAD_EMPRESA' => '',
                    'NOMBRE_ENTIDAD_EMPRESA' => '',
                    'PAIS_EMPRESA' => '',
                    'TELEFONO_DIRECOTORIO' => '',
                    'CELULAR_DIRECTORIO' => '',
                    'CORREO_DIRECTORIO' => '',
                    'DOMICILIO_EXTRANJERO' => '',
                    'DEPARTAMENTO_EXTRANJERO' => '',
                    'CODIGO_EXTRANJERO' => '',
                    'ESTADO_EXTRANJERO' => '',
                    'CIUDAD_EXTRANJERO' => '',
                    'PAIS_EXTRANJERO' => ''
                ];
            }

            $usuarioSolicito = DB::table('usuarios')
                ->select(
                    'EMPLEADO_NOMBRE',
                    'EMPLEADO_APELLIDOPATERNO',
                    'EMPLEADO_APELLIDOMATERNO'
                )
                ->where('ID_USUARIO', $orden->USUARIO_ID)
                ->first();

            $usuarioRealizo = DB::table('usuarios')
                ->select(
                    'EMPLEADO_NOMBRE',
                    'EMPLEADO_APELLIDOPATERNO',
                    'EMPLEADO_APELLIDOMATERNO'
                )
                ->where('ID_USUARIO', $orden->GENEROGR_ID)
                ->first();

            $detalles = DB::table('formulario_bitacoragr_detalle')
                ->where('ID_GR', $orden->ID_GR)
                ->where(function ($query) {
                    $query->where(function ($q1) {
                        $q1->whereNull('BIENS_PARCIAL')
                            ->orWhere('BIENS_PARCIAL', '')
                            ->orWhere('BIENS_PARCIAL', 'No');
                    })
                        ->orWhere(function ($q2) {
                            $q2->where('BIENS_PARCIAL', 'Sí')
                                ->where(function ($q3) {
                                    $q3->whereNotNull('CANTIDAD_ACEPTADA')
                                        ->where('CANTIDAD_ACEPTADA', '>', 0);
                                });
                        });
                })
                ->select(
                    'DESCRIPCION',
                    'CANTIDAD',
                    'CANTIDAD_RECHAZADA',
                    'CANTIDAD_ACEPTADA',
                    'VOBO_USUARIO_PRODUCTO',
                    'BIENS_PARCIAL'
                )
                ->get();

            $pdf = Pdf::loadView('pdf.gr_pdf', [
                'orden' => $orden,
                'proveedor' => $proveedor,
                'usuarioSolicito' => $usuarioSolicito,
                'usuarioRealizo' => $usuarioRealizo,
                'detalles' => $detalles,
            ])->setPaper('letter', 'portrait');

            $noRecepcion = $orden->NO_RECEPCION ?? 'SIN_NUMERO';

            return $pdf->stream($noRecepcion . '.pdf');
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Error al generar el PDF: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ], 500);
        }
    }
    



}
