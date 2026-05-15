<?php

namespace App\Http\Controllers\proveedor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

use DB;

use App\Models\proveedor\fechaactualizacionModel;

use App\Models\proveedor\actualizaciondocumnetosproveedor;



class actualizaciondocumentosController extends Controller
{
    public function index()
    {
        $ultimaFecha = fechaactualizacionModel::where('ACTIVO', 1)
            ->orderBy('ID_ACTUALIZACION_DOCUMENTOS_PROVEEDOR', 'desc')
            ->first();

        $documentos = [
            1  => 'Copia del INE',
            2  => 'Copia del Pasaporte',
            3  => 'Copia de la licencia de conducción tipo chofer',
            5  => 'Copia del acta de nacimiento',
            6  => 'Copia de la CURP',
            9  => 'Copia del comprobante de domicilio',
            12 => 'Constancia de situación fiscal',
            14 => 'Visa',
            15 => 'Credencial de residente',
            16 => 'Aviso o carta de retención de INFONAVIT',

        ];

        $documentosSeleccionados = [];

        if ($ultimaFecha && $ultimaFecha->TIPO_DOCUMENTO) {
            $documentosSeleccionados = json_decode($ultimaFecha->TIPO_DOCUMENTO, true);
        }

        return view('compras.proveedores.actualizaciondocsproveedor.fechaactualizaciondoc',compact('ultimaFecha', 'documentos', 'documentosSeleccionados'));
    }


    public function store(Request $request)
    {
        try {

            switch (intval($request->api)) {

                case 1:

                    $registroExistente = fechaactualizacionModel::where('FECHA_INICIO', $request->FECHA_INICIO)
                        ->where('FECHA_FIN', $request->FECHA_FIN)
                        ->first();

                    if ($registroExistente) {

                        $registroExistente->update([
                            'ACTIVO'         => 1
                        ]);

                        return response()->json([
                            'code' => 1,
                            'fecha' => $registroExistente,
                            'accion' => 'actualizado'
                        ]);
                    }

                    $nuevoRegistro = fechaactualizacionModel::create([
                        'FECHA_INICIO'   => $request->FECHA_INICIO,
                        'FECHA_FIN'      => $request->FECHA_FIN,
                        'ACTIVO'         => 1
                    ]);

                    return response()->json([
                        'code' => 1,
                        'fecha' => $nuevoRegistro,
                        'accion' => 'creado'
                    ]);

                    break;

                default:
                    return response()->json([
                        'code' => 0,
                        'msj' => 'Api no encontrada'
                    ]);
            }
        } catch (Exception $e) {

            return response()->json([
                'code' => 0,
                'msj' => 'Error al guardar las fechas',
                'error' => $e->getMessage()
            ]);
        }
    }



    public function Tabladocumentosactualizadosproveedor()
    {
        try {



            $tabla = DB::table('actualizacion_documentosproveedor as adp')
                ->leftJoin('formulario_altaproveedor as fa', 'fa.RFC_ALTA', '=', 'adp.RFC_PROVEEDOR')
                ->leftJoin('catalogo_documentosproveedor as cd', 'cd.ID_CATALOGO_DOCUMENTOSPROVEEDOR', '=', 'adp.ID_CATALOGO_DOCUMENTO')
                ->select(
                    'adp.*',
                    'fa.RAZON_SOCIAL_ALTA',
                    'cd.NOMBRE_DOCUMENTO',
                    DB::raw("CONCAT(fa.RAZON_SOCIAL_ALTA,' (',adp.RFC_PROVEEDOR,')') as PROVEEDOR_MOSTRAR")
                )
                ->whereNull('adp.VOBO_RH') 
                ->get();

            foreach ($tabla as $value) {


                if ($value->ACTIVO == 0) {

                    $value->BTN_VOBO = '<button type="button" class="btn btn-success btn-custom rounded-pill VOBO"><i class="bi bi-check-circle-fill"></i></button>';

                    $value->BTN_ELIMINAR = '<label class="switch">
                    <input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_ACTUALIZACION_DOC . '">
                    <span class="slider round"></span>
                    </label>';

                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled>
                    <i class="bi bi-ban"></i>
                    </button>';

                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-documentosoporte"
                    data-id="' . $value->ID_ACTUALIZACION_DOC . '">
                    <i class="bi bi-filetype-pdf"></i>
                    </button>';
                } else {

                    $value->BTN_ELIMINAR = '<label class="switch">
                    <input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_ACTUALIZACION_DOC . '" checked>
                    <span class="slider round"></span>
                    </label>';

                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR">
                    <i class="bi bi-pencil-square"></i>
                    </button>';

                    $value->BTN_VOBO = '
                        <button class="btn btn-success btn-custom rounded-pill aprobar-doc"
                        data-id="' . $value->ID_ACTUALIZACION_DOC . '"
                        data-bs-toggle="tooltip"
                        data-bs-placement="top"
                        title="Aprobar documento">
                        <i class="bi bi-check-circle"></i>
                        </button>

                        <button class="btn btn-danger btn-custom rounded-pill rechazar-doc"
                        data-id="' . $value->ID_ACTUALIZACION_DOC . '"
                        data-bs-toggle="tooltip"
                        data-bs-placement="top"
                        title="Rechazar documento">
                        <i class="bi bi-x-circle"></i>
                        </button>
                        ';


                

                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-documentoactualizado"
                    data-id="' . $value->ID_ACTUALIZACION_DOC . '">
                    <i class="bi bi-filetype-pdf"></i>
                </button>';
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


    public function mostrardocumentoactualizadoproveedor($id)
    {
        $archivo = actualizaciondocumnetosproveedor::findOrFail($id)->DOCUMENTO_NUEVO;
        return Storage::response($archivo);
    }


    public function aprobarDocumentoProveedor(Request $request)
    {

        DB::table('actualizacion_documentosproveedor')
            ->where('ID_ACTUALIZACION_DOC', $request->id)
            ->update([

                'VOBO_RH' => 1,
                'FECHA_VOBO' => now(),
                'USUARIO_VOBO' => auth()->user()->ID_USUARIO


        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Documento aprobado'
        ]);
    }


    public function rechazarDocumentoProveedor(Request $request)
    {

        $doc = DB::table('actualizacion_documentosproveedor as adp')
            ->leftJoin(
                'catalogo_documentosproveedor as cd',
                'cd.ID_CATALOGO_DOCUMENTOSPROVEEDOR',
                '=',
                'adp.ID_CATALOGO_DOCUMENTO'
            )
            ->leftJoin(
                'formulario_altaproveedor as fa',
                'fa.RFC_ALTA',
                '=',
                'adp.RFC_PROVEEDOR'
            )
            ->select(
                'adp.*',
                'cd.NOMBRE_DOCUMENTO',
                'fa.CORREO_DIRECTORIO',
                'fa.RAZON_SOCIAL_ALTA'
            )
            ->where('adp.ID_ACTUALIZACION_DOC', $request->id)
            ->first();


        DB::table('actualizacion_documentosproveedor')
            ->where('ID_ACTUALIZACION_DOC', $request->id)
            ->update([

                'VOBO_RH' => 2,
                'MOTIVO_RECHAZO' => $request->motivo,
                'FECHA_VOBO' => now(),
                'USUARIO_VOBO' => auth()->user()->ID_USUARIO


        ]);


        Mail::send('emails.documento_rechazado', [
            'empresa' => $doc->RAZON_SOCIAL_ALTA,
            'documento' => $doc->NOMBRE_DOCUMENTO,
            'motivo' => $request->motivo
        ], function ($mail) use ($doc) {

            $mail->to($doc->CORREO_DIRECTORIO)
                ->subject('Documento rechazado - ERP Results');
        });


        return response()->json([
            'status' => 'success',
            'message' => 'Documento rechazado'
        ]);
    }


    //////// AUTORIZACION DE DOCUMENTOS PROVEEDORES 



    public function Tabladocumentosaprobacionproveedor()
    {
        try {


            $tabla = DB::table('actualizacion_documentosproveedor as adp')
                ->leftJoin('formulario_altaproveedor as fa', 'fa.RFC_ALTA', '=', 'adp.RFC_PROVEEDOR')
                ->leftJoin('catalogo_documentosproveedor as cd', 'cd.ID_CATALOGO_DOCUMENTOSPROVEEDOR', '=', 'adp.ID_CATALOGO_DOCUMENTO')

                ->leftJoin('usuarios as u', 'u.ID_USUARIO', '=', 'adp.USUARIO_VOBO')

                ->select(
                    'adp.*',
                    'fa.RAZON_SOCIAL_ALTA',
                    'cd.NOMBRE_DOCUMENTO',

                    DB::raw("CONCAT(fa.RAZON_SOCIAL_ALTA,' (',adp.RFC_PROVEEDOR,')') as PROVEEDOR_MOSTRAR"),

                    DB::raw("CONCAT(u.EMPLEADO_NOMBRE,' ',u.EMPLEADO_APELLIDOPATERNO,' ',u.EMPLEADO_APELLIDOMATERNO) as NOMBRE_USUARIO")
                )

                ->where('adp.VOBO_RH', 1)
                    ->whereNull('adp.AUTORIZACION_FINAL') 

                ->get();


            foreach ($tabla as $value) {


                if ($value->ACTIVO == 0) {

                    $value->BTN_VOBO = '<button type="button" class="btn btn-success btn-custom rounded-pill VOBO"><i class="bi bi-check-circle-fill"></i></button>';

                    $value->BTN_ELIMINAR = '<label class="switch">
                    <input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_ACTUALIZACION_DOC . '">
                    <span class="slider round"></span>
                </label>';

                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled>
                    <i class="bi bi-ban"></i>
                </button>';

                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-documentosoporte"
                    data-id="' . $value->ID_ACTUALIZACION_DOC . '">
                    <i class="bi bi-filetype-pdf"></i>
                </button>';
                } else {

                    $value->BTN_ELIMINAR = '<label class="switch">
                    <input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_ACTUALIZACION_DOC . '" checked>
                    <span class="slider round"></span>
                </label>';

                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR">
                    <i class="bi bi-pencil-square"></i>
                </button>';

                $value->BTN_APROBACION = '
                    <button class="btn btn-success btn-custom rounded-pill  aprobar-final"
                    data-id="' . $value->ID_ACTUALIZACION_DOC . '"
                    data-bs-toggle="tooltip"
                    data-bs-placement="top"
                    title="Aprobar documento">

                    <i class="bi bi-check-circle"></i>

                    </button>

                    <button class="btn btn-danger btn-custom rounded-pill rechazar-final"
                    data-id="' . $value->ID_ACTUALIZACION_DOC . '"
                    data-bs-toggle="tooltip"
                    data-bs-placement="top"
                    title="Rechazar documento">

                    <i class="bi bi-x-circle"></i>

                    </button>
                    ';

                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-documentoactualizado"
                    data-id="' . $value->ID_ACTUALIZACION_DOC . '">
                    <i class="bi bi-filetype-pdf"></i>
                </button>';
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





    public function aprobarDocumentoProveedorFinal(Request $request)
    {

        $doc = DB::table('actualizacion_documentosproveedor')
            ->where('ID_ACTUALIZACION_DOC', $request->id)
            ->first();


        DB::table('actualizacion_documentosproveedor')
            ->where('ID_ACTUALIZACION_DOC', $request->id)
            ->update([

                'AUTORIZACION_FINAL' => 1,
                'FECHA_AUTORIZACION' => now(),
                'AUTORIZA_ID' => auth()->user()->ID_USUARIO

            ]);


        // REEMPLAZAR DOCUMENTO
        DB::table('formulario_altadocumentoproveedores')
            ->where('ID_FORMULARIO_DOCUMENTOSPROVEEDOR', $doc->ID_DOCUMENTO_PROVEEDOR)
            ->update([

                'DOCUMENTO_SOPORTE' => $doc->DOCUMENTO_NUEVO

            ]);


        return response()->json([
            'status' => 'success',
            'message' => 'Documento aprobado correctamente'
        ]);
    }


    public function rechazarDocumentoProveedorFinal(Request $request)
    {

        $doc = DB::table('actualizacion_documentosproveedor as adp')
            ->leftJoin(
                'catalogo_documentosproveedor as cd',
                'cd.ID_CATALOGO_DOCUMENTOSPROVEEDOR',
                '=',
                'adp.ID_CATALOGO_DOCUMENTO'
            )
            ->leftJoin(
                'formulario_altaproveedor as fa',
                'fa.RFC_ALTA',
                '=',
                'adp.RFC_PROVEEDOR'
            )
            ->select(
                'adp.*',
                'cd.NOMBRE_DOCUMENTO',
                'fa.CORREO_DIRECTORIO',
                'fa.RAZON_SOCIAL_ALTA'
            )
            ->where('adp.ID_ACTUALIZACION_DOC', $request->id)
            ->first();


        DB::table('actualizacion_documentosproveedor')
            ->where('ID_ACTUALIZACION_DOC', $request->id)
            ->update([

                'AUTORIZACION_FINAL' => 2,
                'MOTIVO_RECHAZO' => $request->motivo,
                'FECHA_AUTORIZACION' => now(),
                'AUTORIZA_ID' => auth()->user()->ID_USUARIO

            ]);


        Mail::send('emails.documento_rechazado', [
            'empresa' => $doc->RAZON_SOCIAL_ALTA,
            'documento' => $doc->NOMBRE_DOCUMENTO,
            'motivo' => $request->motivo
        ], function ($mail) use ($doc) {

            $mail->to($doc->CORREO_DIRECTORIO)
                ->subject('Documento rechazado - ERP Results');
        });


        return response()->json([
            'status' => 'success',
            'message' => 'Documento rechazado'
        ]);
    }




    }
