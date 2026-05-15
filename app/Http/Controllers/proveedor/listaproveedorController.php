<?php

namespace App\Http\Controllers\proveedor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;


use App\Models\proveedor\altacontactos;
use App\Models\proveedor\catalogofuncionesproveedorModel;
use App\Models\proveedor\catalogotituloproveedorModel;
use App\Models\proveedor\catalogodocumentoproveedorModel;
use App\Models\proveedor\catalogoverificacionproveedorModel;


use App\Models\proveedor\altacertificacionModel;
use App\Models\proveedor\altacuentaModel;
use App\Models\proveedor\altaproveedorModel;
use App\Models\proveedor\altareferenciasModel;
use App\Models\proveedor\altadocumentosModel;
use App\Models\proveedor\asignacionproveedorModel;
use App\Models\proveedor\contratoproveedorModel;
use App\Models\proveedor\facturacionModel;

use App\Models\proveedor\adendacontratoproveedorModel;



use DB;


class listaproveedorController extends Controller
{
    public function index()
    {
        $funcionesCuenta = catalogofuncionesproveedorModel::all();
        $titulosCuenta = catalogotituloproveedorModel::where('ACTIVO', 1)->get();
        $documetoscatalogo = catalogodocumentoproveedorModel::where('ACTIVO', 1)->get();
        $verificacioncatalogo = catalogoverificacionproveedorModel::where('ACTIVO', 1)
            ->orderBy('NOMBRE_VERIFICACION')
            ->get();


        return view('compras.listaproveedor.listaproveedores', compact('funcionesCuenta', 'titulosCuenta', 'documetoscatalogo', 'verificacioncatalogo'));
    }



    public function verificarestadobloqueoproveedor(Request $request)
    {
        $rfc = $request->input('rfcSeleccionada');

        if (!$rfc) {
            return response()->json(['error' => 'RFC no proporcionado'], 400);
        }

        $registro = DB::table('formulario_altaproveedor')
            ->where('RFC_ALTA', $rfc)
            ->first();

        $bloqueodesactivado = $registro && $registro->ACTIVO == 0 ? 0 : 1;

        return response()->json(['bloqueodesactivado' => $bloqueodesactivado]);
    }



    // public function Tablalistaproveedores()
    // {
    //     try {
    //         $tabla = altaproveedorModel::select('*')
    //             ->where('ACTIVO', 1)
    //             ->get();

    //         $periodo = DB::table('fecha_actualizaciondocsproveedor')
    //             ->where('ACTIVO', 1)
    //             ->whereDate('FECHA_INICIO', '<=', now())
    //             ->whereDate('FECHA_FIN', '>=', now())
    //             ->first();


    //         foreach ($tabla as $value) {


    //             $value->BTN_ACTUALIZACION_DOCS = '';


    //             if ($value->ACTIVO == 0) {

    //                 $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_ALTA . '"><span class="slider round"></span></label>';
    //             } else {
    //                 $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_ALTA . '" checked><span class="slider round"></span></label>';
    //             }


    //             $correoEnviadoPeriodo = false;

    //             if ($periodo) {
    //                 $correoEnviadoPeriodo = DB::table('enviocorreo_proveedor')
    //                     ->where('RFC_PROVEEDOR', $value->RFC_ALTA)
    //                     ->whereBetween('created_at', [
    //                         $periodo->FECHA_INICIO,
    //                         $periodo->FECHA_FIN
    //                     ])
    //                     ->exists();
    //             }



    //             if ((int) $value->VERIFICACION_SOLICITADA === 1) {

    //                 $value->ESTATUS_DATOS = '<span class="badge bg-success">Completo</span>';

    //                 $value->BTN_EDITAR = '<button class="btn btn-primary btn-custom rounded-pill EDITAR"><i class="bi bi-eye"></i></button>';

    //                 $value->BTN_CORREO = '';

    //                 if ($periodo) {

    //                     if ($correoEnviadoPeriodo) {

    //                         $value->BTN_ACTUALIZACION_DOCS =
    //                                     '<button class="btn btn-warning btn-custom rounded-pill ACTUALIZAR_DOCS"
    //                             data-id="' . $value->ID_FORMULARIO_ALTA . '"
    //                             disabled
    //                             data-bs-toggle="tooltip"
    //                             title="Correo ya enviado en este periodo">
    //                             <i class="bi bi-envelope-paper-fill"></i>
    //                             </button>';

    //                     } else {

    //                         $value->BTN_ACTUALIZACION_DOCS =
    //                             '<button class="btn btn-warning btn-custom rounded-pill ACTUALIZAR_DOCS"
    //                             data-id="' . $value->ID_FORMULARIO_ALTA . '"
    //                             data-bs-toggle="tooltip"
    //                             title="Enviar solicitud de actualización">
    //                             <i class="bi bi-envelope-paper-fill"></i>
    //                             </button>';
    //                     }
    //                 } else {

    //                     $value->BTN_ACTUALIZACION_DOCS = '';
    //                 }

    //                 continue;
    //             }


    //             $mensajes = [];
    //             $rfc = $value->RFC_ALTA;
    //             $tipoPersona = $value->TIPO_PERSONA_ALTA;
    //             $tipoPersonaOpcion = $value->TIPO_PERSONA_OPCION;

    //             if (!DB::table('formulario_altacontactoproveedor')->where('RFC_PROVEEDOR', $rfc)->exists()) {
    //                 $mensajes[] = 'Falta agregar contactos.';
    //             }

    //             if (!DB::table('formulario_altacuentaproveedor')->where('RFC_PROVEEDOR', $rfc)->exists()) {
    //                 $mensajes[] = 'Falta agregar cuentas bancarias.';
    //             }

    //             if (!DB::table('formulario_altareferenciasproveedor')->where('RFC_PROVEEDOR', $rfc)->exists()) {
    //                 $mensajes[] = 'Faltan agregar referencias comerciales.';
    //             }

    //             $documentosObligatorios = DB::table('catalogo_documentosproveedor')
    //                 ->where('ACTIVO', 1)
    //                 ->where('TIPO_DOCUMENTO', 1)
    //                 ->where(function ($q) use ($tipoPersona) {
    //                     $q->where('TIPO_PERSONA', $tipoPersona)
    //                         ->orWhere('TIPO_PERSONA', 3);
    //                 })
    //                 ->where(function ($q) use ($tipoPersonaOpcion) {
    //                     $q->where('TIPO_PERSONA_OPCION', $tipoPersonaOpcion)
    //                         ->orWhere('TIPO_PERSONA_OPCION', 3);
    //                 })
    //                 ->get();

    //             $documentosSubidos = DB::table('formulario_altadocumentoproveedores')
    //                 ->where('RFC_PROVEEDOR', $rfc)
    //                 ->pluck('TIPO_DOCUMENTO_PROVEEDOR')
    //                 ->toArray();

    //             foreach ($documentosObligatorios as $doc) {
    //                 if (!in_array($doc->ID_CATALOGO_DOCUMENTOSPROVEEDOR, $documentosSubidos)) {
    //                     $mensajes[] = 'Falta el documento: ' . $doc->NOMBRE_DOCUMENTO;
    //                 }
    //             }

    //             $value->ESTATUS_DATOS = empty($mensajes)
    //                 ? '<span class="badge bg-success">Completo</span>'
    //                 : implode('<br>', array_map(fn($msg) => "<span class='text-danger'>$msg</span>", $mensajes));

    //             $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR"><i class="bi bi-eye"></i></button>';

    //             $value->BTN_CORREO = empty($mensajes)
    //                 ? ''
    //                 : '<button type="button" class="btn btn-info btn-custom rounded-pill CORREO" data-id="' . $value->ID_FORMULARIO_ALTA . '"><i class="bi bi-envelope-arrow-up-fill"></i></button>';


    //         }

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



    public function Tablalistaproveedores()
    {
        try {
            $tabla = altaproveedorModel::select('*')
                ->where('ACTIVO', 1)
                ->get();

            $periodo = DB::table('fecha_actualizaciondocsproveedor')

                ->orderByDesc('ID_ACTUALIZACION_DOCUMENTOS_PROVEEDOR')

                ->first();

            foreach ($tabla as $value) {


                if ($value->ACTIVO == 0) {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_ALTA . '"><span class="slider round"></span></label>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_ALTA . '" checked><span class="slider round"></span></label>';
                }


                /////// ACTULIZAR DOCUMENTOS BOTONES /////// 




                $value->BTN_ACTUALIZACION_DOCS = '';

                if ((int) $value->VERIFICACION_SOLICITADA === 1) {

                    $value->ESTATUS_DATOS = '<span class="badge bg-success">Completo</span>';

                    $value->BTN_EDITAR = '
                        <button class="btn btn-primary btn-custom rounded-pill EDITAR">
                            <i class="bi bi-eye"></i>
                        </button>';

                    $value->BTN_CORREO = '';

                    if ($periodo) {

                    $hoy = now();

                  

                    $periodoActivo =
                        $hoy >= $periodo->FECHA_INICIO &&
                        $hoy <= $periodo->FECHA_FIN;

                    if (!$periodoActivo) {

                        $value->BTN_ACTUALIZACION_DOCS = '';

                        continue;
                    }

                    $registroEnPeriodo =
                        $value->created_at >= $periodo->FECHA_INICIO &&
                        $value->created_at <= $periodo->FECHA_FIN;

                  

                    if ($registroEnPeriodo) {

                        $value->BTN_ACTUALIZACION_DOCS = '';

                        continue;
                    }


                    $documentosActualizar = DB::table('catalogo_documentosproveedor')

                        ->where('ACTUALIZAR_DOCUMENTOS', 1)

                        ->where(function ($q) use ($value) {

                            $q->where('TIPO_PERSONA', $value->TIPO_PERSONA_ALTA)
                                ->orWhere('TIPO_PERSONA', 3);
                        })

                        ->where(function ($q) use ($value) {

                            $q->where('TIPO_PERSONA_OPCION', $value->TIPO_PERSONA_OPCION)
                                ->orWhere('TIPO_PERSONA_OPCION', 3);
                        })

                        ->pluck('ID_CATALOGO_DOCUMENTOSPROVEEDOR')

                        ->toArray();


                        $documentosSubidosPeriodo = DB::table('actualizacion_documentosproveedor')

                            ->where('RFC_PROVEEDOR', $value->RFC_ALTA)

                            ->whereBetween('created_at', [
                                $periodo->FECHA_INICIO,
                                $periodo->FECHA_FIN
                            ])

                            ->where(function ($q) {

                                $q->whereNull('VOBO_RH')
                                    ->orWhere('VOBO_RH', '!=', 2);
                            })

                            ->pluck('ID_CATALOGO_DOCUMENTO')

                            ->toArray();


                    $faltantes = array_diff(
                        $documentosActualizar,
                        $documentosSubidosPeriodo
                    );


                    if (empty($faltantes)) {

                        $value->BTN_ACTUALIZACION_DOCS = '
                        <span class="badge bg-success">
                            Actualización completa
                        </span>';
                    } else {

                        

                    $value->BTN_ACTUALIZACION_DOCS = '

                    <button class="btn btn-warning btn-custom rounded-pill ACTUALIZAR_DOCS"
                        data-id="' . $value->ID_FORMULARIO_ALTA . '"
                        data-bs-toggle="tooltip"
                        title="Enviar solicitud de actualización">
                        <i class="bi bi-envelope-paper-fill"></i>
                    </button>';
                            }
                        } else {

                            $value->BTN_ACTUALIZACION_DOCS = '';
                        }

                    continue;
                }

                ////////////////////////////////////////////////////////  


                $mensajes = [];
                $rfc = $value->RFC_ALTA;
                $tipoPersona = $value->TIPO_PERSONA_ALTA;
                $tipoPersonaOpcion = $value->TIPO_PERSONA_OPCION;

                if (!DB::table('formulario_altacontactoproveedor')->where('RFC_PROVEEDOR', $rfc)->exists()) {
                    $mensajes[] = 'Falta agregar contactos.';
                }

                if (!DB::table('formulario_altacuentaproveedor')->where('RFC_PROVEEDOR', $rfc)->exists()) {
                    $mensajes[] = 'Falta agregar cuentas bancarias.';
                }

                if (!DB::table('formulario_altareferenciasproveedor')->where('RFC_PROVEEDOR', $rfc)->exists()) {
                    $mensajes[] = 'Faltan agregar referencias comerciales.';
                }

                $documentosObligatorios = DB::table('catalogo_documentosproveedor')
                    ->where('ACTIVO', 1)
                    ->where('TIPO_DOCUMENTO', 1)
                    ->where(function ($q) use ($tipoPersona) {
                        $q->where('TIPO_PERSONA', $tipoPersona)
                            ->orWhere('TIPO_PERSONA', 3);
                    })
                    ->where(function ($q) use ($tipoPersonaOpcion) {
                        $q->where('TIPO_PERSONA_OPCION', $tipoPersonaOpcion)
                            ->orWhere('TIPO_PERSONA_OPCION', 3);
                    })
                    ->get();

                $documentosSubidos = DB::table('formulario_altadocumentoproveedores')
                    ->where('RFC_PROVEEDOR', $rfc)
                    ->pluck('TIPO_DOCUMENTO_PROVEEDOR')
                    ->toArray();

                foreach ($documentosObligatorios as $doc) {
                    if (!in_array($doc->ID_CATALOGO_DOCUMENTOSPROVEEDOR, $documentosSubidos)) {
                        $mensajes[] = 'Falta el documento: ' . $doc->NOMBRE_DOCUMENTO;
                    }
                }

                $value->ESTATUS_DATOS = empty($mensajes)
                    ? '<span class="badge bg-success">Completo</span>'
                    : implode('<br>', array_map(fn($msg) => "<span class='text-danger'>$msg</span>", $mensajes));

                $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR"><i class="bi bi-eye"></i></button>';

                $value->BTN_CORREO = empty($mensajes)
                    ? ''
                    : '<button type="button" class="btn btn-info btn-custom rounded-pill CORREO" data-id="' . $value->ID_FORMULARIO_ALTA . '"><i class="bi bi-envelope-arrow-up-fill"></i></button>';
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



    /////// INACTIVO


    public function Tablalistaproveedorinactivo()
    {
        try {
            $tabla = altaproveedorModel::select('*')
                ->where('ACTIVO', 0)
                ->get();

            $periodo = DB::table('fecha_actualizaciondocsproveedor')
                ->where('ACTIVO', 1)
                ->whereDate('FECHA_INICIO', '<=', now())
                ->whereDate('FECHA_FIN', '>=', now())
                ->first();


            foreach ($tabla as $value) {


                $value->BTN_ACTUALIZACION_DOCS = '';



                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ACTIVAR" data-id="' . $value->ID_FORMULARIO_ALTA . '"><span class="slider round"></span></label>';
                


                $correoEnviadoPeriodo = false;

                if ($periodo) {
                    $correoEnviadoPeriodo = DB::table('enviocorreo_proveedor')
                        ->where('RFC_PROVEEDOR', $value->RFC_ALTA)
                        ->whereBetween('created_at', [
                            $periodo->FECHA_INICIO,
                            $periodo->FECHA_FIN
                        ])
                        ->exists();
                }



                if ((int) $value->VERIFICACION_SOLICITADA === 1) {

                    $value->ESTATUS_DATOS = '<span class="badge bg-success">Completo</span>';

                    $value->BTN_EDITAR = '<button class="btn btn-primary btn-custom rounded-pill EDITAR"><i class="bi bi-eye"></i></button>';

                    $value->BTN_CORREO = '';

                    if ($periodo) {

                        if ($correoEnviadoPeriodo) {

                            $value->BTN_ACTUALIZACION_DOCS =
                                '<button class="btn btn-warning btn-custom rounded-pill ACTUALIZAR_DOCS"
                                data-id="' . $value->ID_FORMULARIO_ALTA . '"
                                disabled
                                data-bs-toggle="tooltip"
                                title="Correo ya enviado en este periodo">
                                <i class="bi bi-envelope-paper-fill"></i>
                                </button>';
                        } else {

                            $value->BTN_ACTUALIZACION_DOCS =
                                '<button class="btn btn-warning btn-custom rounded-pill ACTUALIZAR_DOCS"
                                data-id="' . $value->ID_FORMULARIO_ALTA . '"
                                data-bs-toggle="tooltip"
                                title="Enviar solicitud de actualización">
                                <i class="bi bi-envelope-paper-fill"></i>
                                </button>';
                        }
                    } else {

                        $value->BTN_ACTUALIZACION_DOCS = '';
                    }

                    continue;
                }


                $mensajes = [];
                $rfc = $value->RFC_ALTA;
                $tipoPersona = $value->TIPO_PERSONA_ALTA;
                $tipoPersonaOpcion = $value->TIPO_PERSONA_OPCION;

                if (!DB::table('formulario_altacontactoproveedor')->where('RFC_PROVEEDOR', $rfc)->exists()) {
                    $mensajes[] = 'Falta agregar contactos.';
                }

                if (!DB::table('formulario_altacuentaproveedor')->where('RFC_PROVEEDOR', $rfc)->exists()) {
                    $mensajes[] = 'Falta agregar cuentas bancarias.';
                }

                if (!DB::table('formulario_altareferenciasproveedor')->where('RFC_PROVEEDOR', $rfc)->exists()) {
                    $mensajes[] = 'Faltan agregar referencias comerciales.';
                }

                $documentosObligatorios = DB::table('catalogo_documentosproveedor')
                    ->where('ACTIVO', 1)
                    ->where('TIPO_DOCUMENTO', 1)
                    ->where(function ($q) use ($tipoPersona) {
                        $q->where('TIPO_PERSONA', $tipoPersona)
                            ->orWhere('TIPO_PERSONA', 3);
                    })
                    ->where(function ($q) use ($tipoPersonaOpcion) {
                        $q->where('TIPO_PERSONA_OPCION', $tipoPersonaOpcion)
                            ->orWhere('TIPO_PERSONA_OPCION', 3);
                    })
                    ->get();

                $documentosSubidos = DB::table('formulario_altadocumentoproveedores')
                    ->where('RFC_PROVEEDOR', $rfc)
                    ->pluck('TIPO_DOCUMENTO_PROVEEDOR')
                    ->toArray();

                foreach ($documentosObligatorios as $doc) {
                    if (!in_array($doc->ID_CATALOGO_DOCUMENTOSPROVEEDOR, $documentosSubidos)) {
                        $mensajes[] = 'Falta el documento: ' . $doc->NOMBRE_DOCUMENTO;
                    }
                }

                $value->ESTATUS_DATOS = empty($mensajes)
                    ? '<span class="badge bg-success">Completo</span>'
                    : implode('<br>', array_map(fn($msg) => "<span class='text-danger'>$msg</span>", $mensajes));

                $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR"><i class="bi bi-eye"></i></button>';

                $value->BTN_CORREO = empty($mensajes)
                    ? ''
                    : '<button type="button" class="btn btn-info btn-custom rounded-pill CORREO" data-id="' . $value->ID_FORMULARIO_ALTA . '"><i class="bi bi-envelope-arrow-up-fill"></i></button>';
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


    public function activarProveedor(Request $request)
    {
        try {

            DB::table('formulario_altaproveedor')
                ->where('ID_FORMULARIO_ALTA', $request->id)
                ->update([
                    'ACTIVO' => 1,
                    'updated_at' => now()
                ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Proveedor activado correctamente'
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
    

    public function enviarCorreoFaltantes($idFormularioAlta)
    {
                $proveedor = altaproveedorModel::findOrFail($idFormularioAlta);
                $rfc = $proveedor->RFC_ALTA;

            

                $correo = DB::table('formulario_altaproveedor')
                    ->where('RFC_ALTA', $rfc)
                    ->value('CORREO_DIRECTORIO');


                if (!$correo) {
                    return response()->json(['status' => 'error', 'message' => 'No se encontró un correo asociado al proveedor.']);
                }

                $faltantes = [];

                if (!DB::table('formulario_altacontactoproveedor')->where('RFC_PROVEEDOR', $rfc)->exists()) {
                    $faltantes[] = 'Falta agregar contactos.';
                }

                if (!DB::table('formulario_altacuentaproveedor')->where('RFC_PROVEEDOR', $rfc)->exists()) {
                    $faltantes[] = 'Falta agregar cuentas bancarias.';
                }

                if (!DB::table('formulario_altareferenciasproveedor')->where('RFC_PROVEEDOR', $rfc)->exists()) {
                    $faltantes[] = 'Faltan agregar referencias comerciales.';
                }

                $tipoPersona = $proveedor->TIPO_PERSONA_ALTA;
                $tipoPersonaOpcion = $proveedor->TIPO_PERSONA_OPCION;

                $documentosObligatorios = DB::table('catalogo_documentosproveedor')
                    ->where('ACTIVO', 1)
                    ->where('TIPO_DOCUMENTO', 1)
                    ->where(function ($q) use ($tipoPersona) {
                        $q->where('TIPO_PERSONA', $tipoPersona)->orWhere('TIPO_PERSONA', 3);
                    })
                    ->where(function ($q) use ($tipoPersonaOpcion) {
                        $q->where('TIPO_PERSONA_OPCION', $tipoPersonaOpcion)->orWhere('TIPO_PERSONA_OPCION', 3);
                    })
                    ->get();

                $documentosSubidos = DB::table('formulario_altadocumentoproveedores')
                    ->where('RFC_PROVEEDOR', $rfc)
                    ->pluck('TIPO_DOCUMENTO_PROVEEDOR')
                    ->toArray();

                foreach ($documentosObligatorios as $doc) {
                    if (!in_array($doc->ID_CATALOGO_DOCUMENTOSPROVEEDOR, $documentosSubidos)) {
                        $faltantes[] = 'Falta el documento: ' . $doc->NOMBRE_DOCUMENTO;
                    }
                }

                if (empty($faltantes)) {
                    return response()->json(['status' => 'ok', 'message' => 'Proveedor completo. No se envió correo.']);
                }

                $hora = now()->format('H');
                $saludo = $hora < 12 ? 'Buenos días' : 'Buenas tardes';

                Mail::send('emails.faltantes_proveedor', [
                    'saludo' => $saludo,
                    'razonSocial' => $proveedor->RAZON_SOCIAL_ALTA,
                    'faltantes' => $faltantes
                ], function ($message) use ($correo) {
                    $message->to($correo)
                        ->subject('ERP Results - Faltan datos en su registro');
                });

                return response()->json(['status' => 'success', 'message' => 'Correo enviado correctamente.']);
    }


    public function enviarCorreoActualizacionDocs(Request $request)
    {
        $proveedor = DB::table('formulario_altaproveedor')
            ->where('ID_FORMULARIO_ALTA', $request->id)
            ->first();

     
        $periodo = DB::table('fecha_actualizaciondocsproveedor')

            ->orderByDesc('ID_ACTUALIZACION_DOCUMENTOS_PROVEEDOR')

            ->first();

        if (!$periodo) {

            return response()->json([
                'status' => 'error',
                'message' => 'No existe periodo activo'
            ]);
        }

        
        $hoy = now();

        $periodoActivo =
            $hoy >= $periodo->FECHA_INICIO &&
            $hoy <= $periodo->FECHA_FIN;

        if (!$periodoActivo) {

            return response()->json([
                'status' => 'error',
                'message' => 'El periodo ya finalizó'
            ]);
        }

      

        $tipoPersona = $proveedor->TIPO_PERSONA_ALTA;

        $tipoPersonaOpcion = $proveedor->TIPO_PERSONA_OPCION;


        $documentosCatalogo = DB::table('catalogo_documentosproveedor')

            ->where('ACTUALIZAR_DOCUMENTOS', 1)

            ->where(function ($q) use ($tipoPersona) {

                $q->where('TIPO_PERSONA', $tipoPersona)
                    ->orWhere('TIPO_PERSONA', 3);
            })

            ->where(function ($q) use ($tipoPersonaOpcion) {

                $q->where('TIPO_PERSONA_OPCION', $tipoPersonaOpcion)
                    ->orWhere('TIPO_PERSONA_OPCION', 3);
            })

            ->get();



        $documentosSubidos = DB::table('actualizacion_documentosproveedor')

            ->where('RFC_PROVEEDOR', $proveedor->RFC_ALTA)

            ->whereBetween('created_at', [
                $periodo->FECHA_INICIO,
                $periodo->FECHA_FIN
            ])

            ->where(function ($q) {

                $q->whereNull('VOBO_RH')
                    ->orWhere('VOBO_RH', '!=', 2);
            })

            ->pluck('ID_CATALOGO_DOCUMENTO')

            ->toArray();

       

        $documentosFaltantes = $documentosCatalogo
            ->filter(function ($doc) use ($documentosSubidos) {

                return !in_array(
                    $doc->ID_CATALOGO_DOCUMENTOSPROVEEDOR,
                    $documentosSubidos
                );
            })

            ->pluck('NOMBRE_DOCUMENTO');


        if ($documentosFaltantes->isEmpty()) {

            return response()->json([
                'status' => 'success',
                'message' => 'El proveedor ya completó todos los documentos'
            ]);
        }

       

        Mail::send('emails.actualizacion_documentos', [

            'proveedor' => $proveedor,

            'documentos' => $documentosFaltantes,

            'periodo' => $periodo

        ], function ($mail) use ($proveedor) {

            $mail->to($proveedor->CORREO_DIRECTORIO)

                ->subject('Actualización de documentos');
        });

        

        DB::table('enviocorreo_proveedor')->insert([

            'RFC_PROVEEDOR' => $proveedor->RFC_ALTA,

            'created_at' => now(),

            'updated_at' => now()
        ]);

        return response()->json([

            'status' => 'success',

            'message' => 'Correo enviado al proveedor'
        ]);
    }



    public function actualizarVerificacionSolicitada(Request $request)
    {
        $rfc = $request->input('rfc');

        if (!$rfc) {
            return response()->json(['success' => false, 'message' => 'RFC no proporcionado.'], 400);
        }

        try {
            $actualizado = DB::table('formulario_altaproveedor')
                ->where('RFC_ALTA', $rfc)
                ->update(['VERIFICACION_SOLICITADA' => 1]);

            if ($actualizado) {
                return response()->json(['success' => true, 'message' => 'Verificación solicitada correctamente.']);
            } else {
                return response()->json(['success' => false, 'message' => 'No se encontró proveedor con ese RFC.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function verificarEstadoVerificacion(Request $request)
    {
        $rfc = $request->input('rfc');

        if (!$rfc) {
            return response()->json(['success' => false, 'message' => 'RFC no proporcionado.'], 400);
        }

        try {
            $registro = DB::table('formulario_altaproveedor')
                ->select('VERIFICACION_SOLICITADA')
                ->where('RFC_ALTA', $rfc)
                ->first();

            if (!$registro) {
                return response()->json(['success' => false, 'message' => 'Proveedor no encontrado.'], 404);
            }

            if ((int)$registro->VERIFICACION_SOLICITADA === 1) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message' => 'No se ha solicitado la verificación.']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function documentosProveedorAdmin($rfc)
    {
        $proveedor = altaproveedorModel::where('RFC_ALTA', $rfc)->first();

        if (!$proveedor) {
            return response()->json(['status' => 'error', 'message' => 'Proveedor no encontrado']);
        }

        $tipoProveedor = $proveedor->TIPO_PERSONA_ALTA;
        $tipoPersonaOpcion = $proveedor->TIPO_PERSONA_OPCION;

        $catalogo = catalogodocumentoproveedorModel::where('ACTIVO', 1)
            ->where(function ($q) use ($tipoProveedor) {
                $q->where('TIPO_PERSONA', $tipoProveedor)
                    ->orWhere('TIPO_PERSONA', 3);
            })
            ->where(function ($q) use ($tipoPersonaOpcion) {
                $q->where('TIPO_PERSONA_OPCION', $tipoPersonaOpcion)
                    ->orWhere('TIPO_PERSONA_OPCION', 3);
            })
            ->get();

        $registrados = DB::table('formulario_altadocumentoproveedores')
            ->where('RFC_PROVEEDOR', $rfc)
            ->where('ACTIVO', 1)
            ->pluck('TIPO_DOCUMENTO_PROVEEDOR');

        return response()->json([
            'catalogo' => $catalogo,
            'registrados' => $registrados,
        ]);
    }


    // TABLA DE CUENTAS
    public function Tablacuentas(Request $request)
    {
        try {
            $rfc = $request->get('rfc');

            $tabla = altacuentaModel::where('RFC_PROVEEDOR', $rfc)->get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_CUENTAPROVEEDOR . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-caratula" data-id="' . $value->ID_FORMULARIO_CUENTAPROVEEDOR . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_CUENTAPROVEEDOR . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-caratula" data-id="' . $value->ID_FORMULARIO_CUENTAPROVEEDOR . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
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

    // TABLA CONTACTOS
    public function Tablacontactos(Request $request)
    {
        try {
            $rfc = $request->get('rfc');

            $tabla = altacontactos::where('RFC_PROVEEDOR', $rfc)->get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_CONTACTOPROVEEDOR . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_CONTACTOPROVEEDOR . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
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


    // TABLA CERTIFICACION
    public function Tablacertificaciones(Request $request)
    {
        try {
            $rfc = $request->get('rfc');

            $tabla = altacertificacionModel::where('RFC_PROVEEDOR', $rfc)->get();

                foreach ($tabla as $value) {
                    $value->BTN_EDITAR = '';
                    $value->BTN_ELIMINAR = '';
                    $value->BTN_VISUALIZAR = '';
                    $value->BTN_DOCUMENTO = 'N/A';

                    $btnVisualizar = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $btnEditar = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $btnEditarDisabled = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                    $btnEliminarChecked = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_CERTIFICACIONPROVEEDOR . '" checked><span class="slider round"></span></label>';
                    $btnEliminarUnchecked = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_CERTIFICACIONPROVEEDOR . '"><span class="slider round"></span></label>';

                    $btnCertificacion = $value->DOCUMENTO_CERTIFICACION
                        ? '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-certificación" data-id="' . $value->ID_FORMULARIO_CERTIFICACIONPROVEEDOR . '" title="Ver certificación"><i class="bi bi-filetype-pdf"></i></button>'
                        : '';

                    $btnAcreditacion = $value->DOCUMENTO_ACREDITACION
                        ? '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-acreditacion" data-id="' . $value->ID_FORMULARIO_CERTIFICACIONPROVEEDOR . '" title="Ver acreditación"><i class="bi bi-filetype-pdf"></i></button>'
                        : '';

                    $btnAutorizacion = $value->DOCUMENTO_AUTORIZACION
                        ? '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-autorizacion" data-id="' . $value->ID_FORMULARIO_CERTIFICACIONPROVEEDOR . '" title="Ver autorización"><i class="bi bi-filetype-pdf"></i></button>'
                        : '';

                    $btnMembresia = $value->DOCUMENTO_MEMBRESIA
                        ? '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-membresia" data-id="' . $value->ID_FORMULARIO_CERTIFICACIONPROVEEDOR . '" title="Ver membresía"><i class="bi bi-filetype-pdf"></i></button>'
                        : '';

                    switch ($value->TIPO_DOCUMENTO) {
                        case 'Certificación':
                            $value->BTN_DOCUMENTO = $btnCertificacion ?: 'N/A';
                            break;
                        case 'Acreditación':
                            $botones = [];
                            if ($btnAcreditacion) {
                                $botones[] = '<div class="text-center"><small>Acreditación</small><br>' . $btnAcreditacion . '</div>';
                            }
                            if ($btnAutorizacion) {
                                $botones[] = '<div class="text-center"><small>Autorización</small><br>' . $btnAutorizacion . '</div>';
                            }
                            $value->BTN_DOCUMENTO = count($botones) ? implode('&nbsp;&nbsp;', $botones) : 'N/A';
                            break;

                        case 'Membresía':
                            $value->BTN_DOCUMENTO = $btnMembresia ?: 'N/A';
                            break;
                        default:
                            $value->BTN_DOCUMENTO = 'N/A';
                            break;
                    }

                    if ($value->ACTIVO == 0) {
                        $value->BTN_VISUALIZAR = $btnVisualizar;
                        $value->BTN_ELIMINAR = $btnEliminarUnchecked;
                        $value->BTN_EDITAR = $btnEditarDisabled;
                    } else {
                        $value->BTN_VISUALIZAR = $btnVisualizar;
                        $value->BTN_ELIMINAR = $btnEliminarChecked;
                        $value->BTN_EDITAR = $btnEditar;
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

    // TABLA REFERENCIAS 

    public function Tablareferencias(Request $request)
    {
        try {
            $rfc = $request->get('rfc');

            $tabla = altareferenciasModel::where('RFC_PROVEEDOR', $rfc)->get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_REFERENCIASPROVEEDOR . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_REFERENCIASPROVEEDOR . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
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

    // TABLA DOCUMENTOS DE SOPORTE

    public function Tabladocumentosoporteproveedores(Request $request)
    {
        try {
            $rfc = $request->get('rfc');

            $tabla = altadocumentosModel::where('RFC_PROVEEDOR', $rfc)->get();


            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_DOCUMENTOSPROVEEDOR . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-documentosoporte" data-id="' . $value->ID_FORMULARIO_DOCUMENTOSPROVEEDOR . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_DOCUMENTOSPROVEEDOR . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-documentosoporte" data-id="' . $value->ID_FORMULARIO_DOCUMENTOSPROVEEDOR . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
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

    // ASIGNACIONES PROVEEDOR

    public function Tablasignacionproveedor(Request $request)
    {
        try {

            $rfc = $request->get('rfc');

            $idsUsados = DB::table('asignaciones_proveedores')
                ->where('RFC', $rfc)
                ->whereNotNull('ASIGNACIONES_ID')
                ->pluck('ASIGNACIONES_ID');


            $idsExcluir = [];

            foreach ($idsUsados as $json) {
                $array = json_decode($json, true);
                if (is_array($array)) {
                    $idsExcluir = array_merge($idsExcluir, $array);
                }
            }


            $query = DB::table('asignaciones_inventario as ai')
                ->leftJoin(
                    'formulario_inventario as fi',
                    'fi.ID_FORMULARIO_INVENTARIO',
                    '=',
                    'ai.INVENTARIO_ID'
                )
                ->leftJoin(
                    'usuarios as u',
                    'u.ID_USUARIO',
                    '=',
                    'ai.ALMACENISTA_ID'
                )
                ->where('ai.ASIGNADO_ID', $rfc);

            if (!empty($idsExcluir)) {
                $query->whereNotIn('ai.ID_ASIGNACION_FORMULARIO', $idsExcluir);
            }

            $tabla = $query->select(
                'ai.ID_ASIGNACION_FORMULARIO',
                'ai.INVENTARIO_ID',
                'ai.CANTIDAD_SALIDA',
                'ai.ACTIVO',
                'ai.ALMACENISTA_ID',

                'fi.DESCRIPCION_EQUIPO',
                'fi.MARCA_EQUIPO',
                'fi.MODELO_EQUIPO',
                'fi.SERIE_EQUIPO',
                'fi.CODIGO_EQUIPO',

                DB::raw("
                CONCAT(
                    u.EMPLEADO_NOMBRE, ' ',
                    u.EMPLEADO_APELLIDOPATERNO, ' ',
                    u.EMPLEADO_APELLIDOMATERNO
                ) as ALMACENISTA_NOMBRE
            ")
            )->get();

            return response()->json([
                'data' => $tabla,
                'msj' => 'Información consultada correctamente'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'msj' => 'Error ' . $e->getMessage(),
                'data' => []
            ]);
        }
    }

    public function Tablasignacionproveedorgeneral(Request $request)
    {
        try {

            $rfc = $request->get('rfc');

            $asignaciones = asignacionproveedorModel::where('RFC', $rfc)->get();

            $resultado = [];

            foreach ($asignaciones as $asignacion) {

                $idsAsignaciones = json_decode($asignacion->ASIGNACIONES_ID, true);

                if (!is_array($idsAsignaciones) || empty($idsAsignaciones)) {
                    continue;
                }

                $inventarios = DB::table('asignaciones_inventario as ai')
                    ->leftJoin(
                        'formulario_inventario as fi',
                        'fi.ID_FORMULARIO_INVENTARIO',
                        '=',
                        'ai.INVENTARIO_ID'
                    )
                    ->whereIn('ai.ID_ASIGNACION_FORMULARIO', $idsAsignaciones)
                    ->select(
                        'ai.ID_ASIGNACION_FORMULARIO',
                        'ai.CANTIDAD_SALIDA',
                        'fi.DESCRIPCION_EQUIPO',
                        'fi.MARCA_EQUIPO',
                        'fi.MODELO_EQUIPO',
                        'fi.SERIE_EQUIPO',
                        'fi.CODIGO_EQUIPO'
                    )
                    ->get();

                $esPrimera = true;

                foreach ($inventarios as $inv) {

                    $fila = [
                        'GRUPO_ID'         => $asignacion->ID_ASINGACIONES_PROVEEDORES,
                        'PERSONAL_ASIGNA'  => $asignacion->PERSONAL_ASIGNA,
                        'FECHA_ASIGNACION' => $asignacion->FECHA_ASIGNACION,
                        'TIPO_ASIGNACION'  => $asignacion->TIPO_ASIGNACION,
                        'ALMACENISTA_ASIGNACION'  => $asignacion->ALMACENISTA_ASIGNACION,
                        'ASIGNACIONES_ID'  => $asignacion->ASIGNACIONES_ID,
                        'EPP_JSON'  => $asignacion->EPP_JSON,

                        'CANTIDAD_SALIDA' => $inv->CANTIDAD_SALIDA,
                        'DESCRIPCION_EQUIPO' => $inv->DESCRIPCION_EQUIPO,
                        'MARCA_EQUIPO'       => $inv->MARCA_EQUIPO,
                        'MODELO_EQUIPO'      => $inv->MODELO_EQUIPO,
                        'SERIE_EQUIPO'       => $inv->SERIE_EQUIPO,
                        'CODIGO_EQUIPO'      => $inv->CODIGO_EQUIPO,
                    ];

                    if ($esPrimera) {

                        if ($asignacion->ACTIVO == 0) {
                            $fila['BTN_EDITAR'] =
                                '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR">
                                <i class="bi bi-eye"></i>
                            </button>';
                        } else {
                            $fila['BTN_EDITAR'] =
                                '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR">
                                <i class="bi bi-pencil-square"></i>
                            </button>';
                        }

                        $fila['DESCARGAR_FORMATOS'] =
                            '<button class="btn btn-danger btn-custom rounded-pill pdf-button descargar-asignacion"
                                data-id="' . $asignacion->ID_ASINGACIONES_PROVEEDORES . '">
                                <i class="bi bi-filetype-pdf"></i>
                            </button>';


                        $fila['DESCARGAR_EPP'] =
                            '<button class="btn btn-danger btn-custom rounded-pill pdf-button descargar-epp"
                                data-id="' . $asignacion->ID_ASINGACIONES_PROVEEDORES . '">
                                <i class="bi bi-filetype-pdf"></i>
                            </button>';


                        $fila['BTN_DOCUMENTO'] =
                            '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-documentoasignacion"
                            data-id="' . $asignacion->ID_ASINGACIONES_PROVEEDORES . '">
                            <i class="bi bi-filetype-pdf"></i>
                        </button>';
                    } else {
                        $fila['BTN_EDITAR'] = '';
                        $fila['DESCARGAR_FORMATOS'] = '';
                        $fila['BTN_DOCUMENTO'] = '';
                    }

                    $resultado[] = $fila;
                    $esPrimera = false;
                }
            }

            return response()->json([
                'data' => $resultado,
                'msj'  => 'Información consultada correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'msj'  => 'Error ' . $e->getMessage(),
                'data' => []
            ]);
        }
    }

    public function TablasignacionproveedorEditar(Request $request)
    {
        try {

            $idAsignacion = $request->id_asignacion_contratacion;

            if (!$idAsignacion) {
                return response()->json(['data' => []]);
            }

            $asignacion = DB::table('asignaciones_proveedores')
                ->where('ID_ASINGACIONES_PROVEEDORES', $idAsignacion)
                ->first();

            if (!$asignacion || empty($asignacion->ASIGNACIONES_ID)) {
                return response()->json(['data' => []]);
            }

            $ids = json_decode($asignacion->ASIGNACIONES_ID, true);

            if (!is_array($ids) || empty($ids)) {
                return response()->json(['data' => []]);
            }

            $tabla = DB::table('asignaciones_inventario as ai')
                ->leftJoin(
                    'formulario_inventario as fi',
                    'fi.ID_FORMULARIO_INVENTARIO',
                    '=',
                    'ai.INVENTARIO_ID'
                )
                ->whereIn('ai.ID_ASIGNACION_FORMULARIO', $ids)
                ->select(
                    'ai.ID_ASIGNACION_FORMULARIO',
                    'ai.CANTIDAD_SALIDA',

                    'fi.DESCRIPCION_EQUIPO',
                    'fi.MARCA_EQUIPO',
                    'fi.MODELO_EQUIPO',
                    'fi.SERIE_EQUIPO',
                    'fi.CODIGO_EQUIPO'
                )
                ->get();

            return response()->json([
                'data' => $tabla
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'data' => [],
                'error' => $e->getMessage()
            ]);
        }
    }

    public function mostrarasignacionproveedor($id)
    {
        $archivo = asignacionproveedorModel::findOrFail($id)->DOCUMENTO_ASIGNACION;
        return Storage::response($archivo);
    }


    // TABLA CONTRATO PROVEEDOR

    public function Tablacontratosproveedores(Request $request)
    {
        try {
            $rfc = $request->get('rfc');

            $tabla = contratoproveedorModel::where('RFC_PROVEEDOR', $rfc)->get();


            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_CONTRATO_PROVEEDORES . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-contrato" data-id="' . $value->ID_CONTRATO_PROVEEDORES . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_CONTRATO_PROVEEDORES . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-contrato" data-id="' . $value->ID_CONTRATO_PROVEEDORES . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                }



                $adendas = DB::table('adenda_contratos_proveedor')
                    ->where('CONTRATO_ID', $value->ID_CONTRATO_PROVEEDORES)
                    ->get();

                $adendasAgrupadas = [];

                foreach ($adendas as $adenda) {
                    $adendasAgrupadas[] = [
                        'ID_ADENDA_CONTRATO_PROVEEDOR'        => $adenda->ID_ADENDA_CONTRATO_PROVEEDOR,
                        'FECHAI_ADENDA_CONTRATO'    => $adenda->FECHAI_ADENDA_CONTRATO,
                        'FECHAF_ADENDA_CONTRATO'    => $adenda->FECHAF_ADENDA_CONTRATO,
                        'COMENTARIO_ADENDA_CONTRATO' => $adenda->COMENTARIO_ADENDA_CONTRATO,
                        'DOCUMENTO_ADENDA_CONTRATO' => $adenda->DOCUMENTO_ADENDA_CONTRATO,
                        'BTN_DOCUMENTO'             => '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-adendacontrato" data-id="' . $adenda->ID_ADENDA_CONTRATO_PROVEEDOR . '" title="Ver Adenda"><i class="bi bi-filetype-pdf"></i></button>',
                    ];
                }

                $value->ADENDAS = $adendasAgrupadas;


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

    public function mostrarcontratoproveedor($id)
    {
        $archivo = contratoproveedorModel::findOrFail($id)->DOCUMENTO_CONTRATO_PROVEEDOR;
        return Storage::response($archivo);
    }


    public function mostraradendacontratoproveedores($id)
    {
        $archivo = adendacontratoproveedorModel::findOrFail($id)->DOCUMENTO_ADENDA_CONTRATO;
        return Storage::response($archivo);
    }
    

    public function folioContrato()
    {
        $anio = date('y'); 

        $prefijo = "RESCS-" . $anio . "-";

        $ultimo = DB::table('contratos_proveedores')
            ->where('NUMERO_CONTRATO_PROVEEDOR', 'like', $prefijo . '%')
            ->orderBy('NUMERO_CONTRATO_PROVEEDOR', 'desc')
            ->first();

        if ($ultimo) {
            $numero = intval(substr($ultimo->NUMERO_CONTRATO_PROVEEDOR, -3)) + 1;
        } else {
            $numero = 1;
        }

        $consecutivo = str_pad($numero, 3, '0', STR_PAD_LEFT);

        $folio = $prefijo . $consecutivo;

        return response()->json([
            'folio' => $folio
        ]);
    }


    // TABLA FACTURA PROVEEDOR





    public function Tablafacturaproveedoresinterno(Request $request)
    {
        try {

            
            $rfc = $request->get('rfc');

            $tabla = facturacionModel::where('RFC_PROVEEDOR', $rfc)->get();

            
            foreach ($tabla as $value) {

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


    public function obtenerDetalleFactura(Request $request)
    {
        $id = $request->id;

        $factura = facturacionModel::where('ID_FORMULARIO_FACTURACION', $id)->first();

        if (!$factura) {
            return response()->json(['error' => 'No encontrada']);
        }

        $proveedor = DB::table('formulario_altaproveedor')
            ->where('RFC_ALTA', $factura->RFC_PROVEEDOR)
            ->orderBy('ID_FORMULARIO_ALTA', 'desc')
            ->first();

        return response()->json([
            'factura' => $factura,
            'tipoProveedor' => $proveedor ? $proveedor->TIPO_PERSONA_ALTA : null
        ]);
    }


    public function mostrarecibodepago($id)
    {
        $archivo = facturacionModel::findOrFail($id)->ARCHIVO_RECIBO_PAGO;
        return Storage::response($archivo);
    }

    public function verXMLFactura($id)
    {
        $archivo = facturacionModel::findOrFail($id)->FACTURA_XML;

        if (request()->has('download')) {
            return Storage::download($archivo);
        }

        return Storage::response($archivo);
    }


    public function verXMLREP($id)
    {
        $archivo = facturacionModel::findOrFail($id)->XML_REP;

        if (request()->has('download')) {
            return Storage::download($archivo);
        }

        return Storage::response($archivo);
    }




    //////  STORE

    public function store(Request $request)
    {
        try {
            switch (intval($request->api)) {


                case 1:
                    if ($request->ID_FORMULARIO_ALTA == 0) {

                        DB::statement('ALTER TABLE formulario_altaproveedor AUTO_INCREMENT=1;');

                        $data = $request->except(['documentos']);
                        $contratos = altaproveedorModel::create($data);
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $contratos = altaproveedorModel::where('ID_FORMULARIO_ALTA', $request['ID_FORMULARIO_ALTA'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['contrato'] = 'Desactivada';
                            } else {
                                $contratos = altaproveedorModel::where('ID_FORMULARIO_ALTA', $request['ID_FORMULARIO_ALTA'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['contrato'] = 'Activada';
                            }
                        } else {
                        // Editar un contrato existente
                        $contratos = altaproveedorModel::find($request->ID_FORMULARIO_ALTA);
                        $contratos->update($request->all());

                            $response['code'] = 1;
                        $response['contrato'] = 'Actualizada';
                    }
                }

                $response['code'] = 1;
                $response['contrato'] = $contratos;
                return response()->json($response);
                
                break;




                // case 1:
                //     if ($request->ID_FORMULARIO_ALTA == 0) {
                //         DB::statement('ALTER TABLE formulario_altaproveedor AUTO_INCREMENT=1;');
                //         $funciones = altaproveedorModel::create($request->all());
                //     } else {

                //         if (isset($request->ELIMINAR)) {
                //             if ($request->ELIMINAR == 1) {

                //                 $funciones = altaproveedorModel::where('ID_FORMULARIO_ALTA', $request['ID_FORMULARIO_ALTA'])->update(['ACTIVO' => 0]);
                //                 $response['code'] = 1;
                //                 $response['funcion'] = 'Desactivada';
                //             } else {
                //                 $funciones = altaproveedorModel::where('ID_FORMULARIO_ALTA', $request['ID_FORMULARIO_ALTA'])->update(['ACTIVO' => 1]);
                //                 $response['code'] = 1;
                //                 $response['funcion'] = 'Activada';
                //             }
                //         } else {
                //             $funciones = altaproveedorModel::find($request->ID_FORMULARIO_ALTA);
                //             $funciones->update($request->all());
                //             $response['code'] = 1;
                //             $response['funcion'] = 'Actualizada';
                //         }
                //         return response()->json($response);
                //     }
                //     $response['code']  = 1;
                //     $response['funcion']  = $funciones;
                //     return response()->json($response);
                //     break;


                case 2:
                    $requestData = $request->all();
                    $rfc = $requestData['RFC_PROVEEDOR'] ?? null; 

                    if ($request->ID_FORMULARIO_CUENTAPROVEEDOR == 0) {
                        DB::statement('ALTER TABLE formulario_altacuentaproveedor AUTO_INCREMENT=1;');

                        $cuentas = altacuentaModel::create($requestData);

                        if ($request->hasFile('CARATULA_BANCARIA')) {
                            $file = $request->file('CARATULA_BANCARIA');
                            $folderPath = "proveedores/{$rfc}/Caratula de cuentas/{$cuentas->ID_FORMULARIO_CUENTAPROVEEDOR}";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);

                            $cuentas->CARATULA_BANCARIA = $filePath;
                            $cuentas->save();
                        }
                    } else {
                        $cuentas = altacuentaModel::find($request->ID_FORMULARIO_CUENTAPROVEEDOR);

                        if (isset($request->ELIMINAR)) {
                            $cuentas->ACTIVO = $request->ELIMINAR == 1 ? 0 : 1;
                            $cuentas->save();

                            $response['code'] = 1;
                            $response['cuenta'] = $request->ELIMINAR == 1 ? 'Desactivada' : 'Activada';
                            return response()->json($response);
                        }

                        if ($request->hasFile('CARATULA_BANCARIA')) {
                            if ($cuentas->CARATULA_BANCARIA && Storage::exists($cuentas->CARATULA_BANCARIA)) {
                                Storage::delete($cuentas->CARATULA_BANCARIA);
                            }

                            $file = $request->file('CARATULA_BANCARIA');
                            $folderPath = "proveedores/{$rfc}/Caratula de cuentas/{$cuentas->ID_FORMULARIO_CUENTAPROVEEDOR}";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);

                            $requestData['CARATULA_BANCARIA'] = $filePath;
                        }

                        $cuentas->update(collect($requestData)->except('RFC_PROVEEDOR')->toArray());

                        $response['code'] = 1;
                        $response['cuenta'] = 'Actualizada';
                        return response()->json($response);
                    }

                    $response['code']  = 1;
                    $response['cuenta']  = $cuentas;
                    return response()->json($response);
                    break;



                case 3:

                    $requestData = $request->all();

                    if ($request->has('FUNCIONES_CUENTA') && is_array($request->FUNCIONES_CUENTA)) {
                        $requestData['FUNCIONES_CUENTA'] = json_encode($request->FUNCIONES_CUENTA);
                    } else {
                        $requestData['FUNCIONES_CUENTA'] = null;
                    }

                    $rfc = $request->RFC_PROVEEDOR ?? null;
                    $requestData['RFC_PROVEEDOR'] = $rfc;

                    if ($request->ID_FORMULARIO_CONTACTOPROVEEDOR == 0) {

                        DB::statement('ALTER TABLE formulario_altacontactoproveedor AUTO_INCREMENT = 1;');

                        $cuentas = altacontactos::create($requestData);

                        return response()->json([
                            'code' => 1,
                            'cuenta' => $cuentas
                        ]);
                    } else {
                        if (isset($request->ELIMINAR)) {
                            $estado = $request->ELIMINAR == 1 ? 0 : 1;

                            altacontactos::where('ID_FORMULARIO_CONTACTOPROVEEDOR', $request->ID_FORMULARIO_CONTACTOPROVEEDOR)
                                ->update(['ACTIVO' => $estado]);

                            return response()->json([
                                'code' => 1,
                                'cuenta' => ['status' => $estado == 0 ? 'Desactivada' : 'Activada']
                            ]);
                        }

                        $cuentas = altacontactos::find($request->ID_FORMULARIO_CONTACTOPROVEEDOR);

                        if (!$cuentas) {
                            return response()->json([
                                'code' => 0,
                                'error' => 'Formulario no encontrado.'
                            ], 404);
                        }

                        $requestData = $request->except('RFC_PROVEEDOR');

                        if ($request->has('FUNCIONES_CUENTA') && is_array($request->FUNCIONES_CUENTA)) {
                            $requestData['FUNCIONES_CUENTA'] = json_encode($request->FUNCIONES_CUENTA);
                        } else {
                            $requestData['FUNCIONES_CUENTA'] = null;
                        }

                        $cuentas->update($requestData);

                        return response()->json([
                            'code' => 1,
                            'cuenta' => $cuentas
                        ]);
                    }

                    break;


                case 4:

                    $rfc = $request->RFC_PROVEEDOR ?? null;

                    if (!$rfc) {
                        return response()->json([
                            'code' => 0,
                            'error' => 'RFC_PROVEEDOR es requerido.'
                        ], 400);
                    }

                    $requestData = collect($request->except([
                        'DOCUMENTO_CERTIFICACION',
                        'DOCUMENTO_ACREDITACION',
                        'DOCUMENTO_AUTORIZACION',
                        'DOCUMENTO_MEMBRESIA'
                    ]))->toArray();

                    $requestData['RFC_PROVEEDOR'] = $rfc;

                    if ($request->ID_FORMULARIO_CERTIFICACIONPROVEEDOR == 0) {
                        DB::statement('ALTER TABLE formulario_altacertificacionproveedor AUTO_INCREMENT=1;');

                        $yaExiste = altacertificacionModel::where('RFC_PROVEEDOR', $rfc)
                            ->whereNotNull('DOCUMENTO_ACREDITACION')
                            ->first();

                        if ($yaExiste && $request->hasFile('DOCUMENTO_AUTORIZACION') && !$request->hasFile('DOCUMENTO_ACREDITACION')) {
                            $cuentas = $yaExiste;
                        } else {
                            $cuentas = altacertificacionModel::create($requestData);
                            $cuentas->refresh();
                        }

                        $cuentas = $this->guardarArchivos($request, $cuentas, $rfc);
                    } else {
                        $cuentas = altacertificacionModel::find($request->ID_FORMULARIO_CERTIFICACIONPROVEEDOR);

                        if (!$cuentas) {
                            return response()->json([
                                'code' => 0,
                                'error' => 'Registro no encontrado.'
                            ], 404);
                        }

                        if (isset($request->ELIMINAR)) {
                            $cuentas->ACTIVO = $request->ELIMINAR == 1 ? 0 : 1;
                            $cuentas->save();

                            return response()->json([
                                'code' => 1,
                                'cuenta' => $request->ELIMINAR == 1 ? 'Desactivada' : 'Activada'
                            ]);
                        }

                        $cuentas = $this->guardarArchivos($request, $cuentas, $rfc);

                        $cuentas->update($requestData);

                        return response()->json([
                            'code' => 1,
                            'cuenta' => 'Actualizada'
                        ]);
                    }

                    return response()->json([
                        'code' => 1,
                        'cuenta' => $cuentas
                    ]);


                    break;


                case 5:

                    if ($request->ID_FORMULARIO_REFERENCIASPROVEEDOR == 0) {
                        DB::statement('ALTER TABLE formulario_altareferenciasproveedor AUTO_INCREMENT=1;');

                        $requestData = $request->all();

                        $rfc = $requestData['RFC_PROVEEDOR'] ?? null;

                        if (!$rfc) {
                            return response()->json([
                                'code' => 0,
                                'error' => 'RFC_PROVEEDOR es requerido.'
                            ], 400);
                        }

                        $requestData['RFC_PROVEEDOR'] = $rfc;

                        $cuentas = altareferenciasModel::create($requestData);
                    } else {
                        if (isset($request->ELIMINAR)) {
                            $estado = $request->ELIMINAR == 1 ? 0 : 1;

                            $cuentas = altareferenciasModel::where('ID_FORMULARIO_REFERENCIASPROVEEDOR', $request['ID_FORMULARIO_REFERENCIASPROVEEDOR'])
                                ->update(['ACTIVO' => $estado]);

                            $response['code'] = 1;
                            $response['cuenta'] = $estado == 0 ? 'Desactivada' : 'Activada';
                        } else {
                            $cuentas = altareferenciasModel::find($request->ID_FORMULARIO_REFERENCIASPROVEEDOR);

                            if (!$cuentas) {
                                return response()->json([
                                    'code' => 0,
                                    'error' => 'Registro no encontrado.'
                                ], 404);
                            }

                            $cuentas->update($request->except('RFC_PROVEEDOR'));

                            $response['code'] = 1;
                            $response['cuenta'] = 'Actualizada';
                        }

                        return response()->json($response);
                    }

                    $response['code']  = 1;
                    $response['cuenta']  = $cuentas;
                    return response()->json($response);

                    break;

                case 6:

                    if ($request->ID_FORMULARIO_DOCUMENTOSPROVEEDOR == 0) {
                        DB::statement('ALTER TABLE formulario_altadocumentoproveedores AUTO_INCREMENT=1;');

                        $requestData = $request->all();

                        $rfc = $requestData['RFC_PROVEEDOR'] ?? null;

                        if (!$rfc) {
                            return response()->json([
                                'code' => 0,
                                'error' => 'RFC_PROVEEDOR es requerido.'
                            ], 400);
                        }

                        $requestData['RFC_PROVEEDOR'] = $rfc;

                        $cuentas = altadocumentosModel::create($requestData);

                        if ($request->hasFile('DOCUMENTO_SOPORTE')) {
                            $file = $request->file('DOCUMENTO_SOPORTE');
                            $folderPath = "proveedores/{$rfc}/Documento de soporte/{$cuentas->ID_FORMULARIO_DOCUMENTOSPROVEEDOR}";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);

                            $cuentas->DOCUMENTO_SOPORTE = $filePath;
                            $cuentas->save();
                        }
                    } else {
                        if (isset($request->ELIMINAR)) {
                            $estado = $request->ELIMINAR == 1 ? 0 : 1;

                            $cuentas = altadocumentosModel::where('ID_FORMULARIO_DOCUMENTOSPROVEEDOR', $request['ID_FORMULARIO_DOCUMENTOSPROVEEDOR'])
                                ->update(['ACTIVO' => $estado]);

                            $response['code'] = 1;
                            $response['cuenta'] = $estado == 0 ? 'Desactivada' : 'Activada';
                        } else {
                            $cuentas = altadocumentosModel::find($request->ID_FORMULARIO_DOCUMENTOSPROVEEDOR);

                            if (!$cuentas) {
                                return response()->json([
                                    'code' => 0,
                                    'error' => 'Registro no encontrado.'
                                ], 404);
                            }

                            $rfc = $request->RFC_PROVEEDOR ?? null;

                            if (!$rfc) {
                                return response()->json([
                                    'code' => 0,
                                    'error' => 'RFC_PROVEEDOR es requerido.'
                                ], 400);
                            }

                            $cuentas->update($request->except('RFC_PROVEEDOR'));

                            if ($request->hasFile('DOCUMENTO_SOPORTE')) {
                                if ($cuentas->DOCUMENTO_SOPORTE && Storage::exists($cuentas->DOCUMENTO_SOPORTE)) {
                                    Storage::delete($cuentas->DOCUMENTO_SOPORTE);
                                }

                                $file = $request->file('DOCUMENTO_SOPORTE');
                                $folderPath = "proveedores/{$rfc}/Documento de soporte/{$cuentas->ID_FORMULARIO_DOCUMENTOSPROVEEDOR}";
                                $fileName = $file->getClientOriginalName();
                                $filePath = $file->storeAs($folderPath, $fileName);

                                $cuentas->DOCUMENTO_SOPORTE = $filePath;
                                $cuentas->save();
                            }

                            $response['code'] = 1;
                            $response['cuenta'] = 'Actualizada';
                        }

                        return response()->json($response);
                    }

                    $response['code']  = 1;
                    $response['cuenta']  = $cuentas;
                    return response()->json($response);

                    break;


                case 7:

                    try {

                        function normalizarAsignaciones($value)
                        {
                            if (is_array($value)) {
                                return $value;
                            }

                            if (is_string($value)) {

                                $decoded = json_decode($value, true);

                                if (is_string($decoded)) {
                                    $decoded = json_decode($decoded, true);
                                }

                                if (is_array($decoded)) {
                                    return $decoded;
                                }
                            }

                            return [];
                        }


                   
                        $asignacionesArray = normalizarAsignaciones(
                            $request->ASIGNACIONES_ID ?? null
                        );

                        $asignacionesJson = json_encode($asignacionesArray);

                       
                        if ((int)$request->ID_ASINGACIONES_PROVEEDORES === 0) {

                            DB::statement('ALTER TABLE asignaciones_proveedores AUTO_INCREMENT = 1');

                            $soportes = asignacionproveedorModel::create(
                                array_merge(
                                    $request->except('DOCUMENTO_ASIGNACION', 'ASIGNACIONES_ID'),
                                    [
                                        'ASIGNACIONES_ID' => $asignacionesJson
                                    ]
                                )
                            );

                            if ($request->hasFile('DOCUMENTO_ASIGNACION')) {

                                $documento = $request->file('DOCUMENTO_ASIGNACION');
                                $ruta = "proveedores/{$request->RFC}/Asignaciones/{$soportes->ID_ASINGACIONES_PROVEEDORES}";
                                $nombre = 'Documento de asignacion.' . $documento->getClientOriginalExtension();

                                $soportes->update([
                                    'DOCUMENTO_ASIGNACION' => $documento->storeAs($ruta, $nombre)
                                ]);
                            }
                        }
                        
                        else {

                            $soportes = asignacionproveedorModel::findOrFail(
                                $request->ID_ASINGACIONES_PROVEEDORES
                            );

                            $soportes->update(
                                array_merge(
                                    $request->except('DOCUMENTO_ASIGNACION', 'ASIGNACIONES_ID'),
                                    [
                                        'ASIGNACIONES_ID' => $asignacionesJson
                                    ]
                                )
                            );

                            if ($request->hasFile('DOCUMENTO_ASIGNACION')) {

                                if ($soportes->DOCUMENTO_ASIGNACION && Storage::exists($soportes->DOCUMENTO_ASIGNACION)) {
                                    Storage::delete($soportes->DOCUMENTO_ASIGNACION);
                                }

                                $documento = $request->file('DOCUMENTO_ASIGNACION');
                                $ruta = "proveedores/{$request->RFC}/Asignaciones/{$soportes->ID_ASINGACIONES_PROVEEDORES}";
                                $nombre = 'Documento de asignacion.' . $documento->getClientOriginalExtension();

                                $soportes->update([
                                    'DOCUMENTO_ASIGNACION' => $documento->storeAs($ruta, $nombre)
                                ]);
                            }
                        }

                        return response()->json([
                            'code' => 1,
                            'soporte' => $soportes
                        ]);
                    } catch (\Throwable $e) {

                        return response()->json([
                            'code' => 0,
                            'error' => 'Error al guardar el contrato',
                            'detalle' => $e->getMessage()
                        ], 500);
                    }

                    break;


                case 8:
                    $requestData = $request->all();
                    $rfc = $requestData['RFC_PROVEEDOR'] ?? null;

                    if ($request->ID_CONTRATO_PROVEEDORES == 0) {
                        DB::statement('ALTER TABLE contratos_proveedores AUTO_INCREMENT=1;');

                        $cuentas = contratoproveedorModel::create($requestData);

                        if ($request->hasFile('DOCUMENTO_CONTRATO_PROVEEDOR')) {
                            $file = $request->file('DOCUMENTO_CONTRATO_PROVEEDOR');
                            $folderPath = "proveedores/{$rfc}/Contrato proveedor/{$cuentas->ID_CONTRATO_PROVEEDORES}";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);

                            $cuentas->DOCUMENTO_CONTRATO_PROVEEDOR = $filePath;
                            $cuentas->save();
                        }
                    } else {
                        $cuentas = contratoproveedorModel::find($request->ID_CONTRATO_PROVEEDORES);

                        if (isset($request->ELIMINAR)) {
                            $cuentas->ACTIVO = $request->ELIMINAR == 1 ? 0 : 1;
                            $cuentas->save();

                            $response['code'] = 1;
                            $response['cuenta'] = $request->ELIMINAR == 1 ? 'Desactivada' : 'Activada';
                            return response()->json($response);
                        }

                        if ($request->hasFile('DOCUMENTO_CONTRATO_PROVEEDOR')) {
                            if ($cuentas->DOCUMENTO_CONTRATO_PROVEEDOR && Storage::exists($cuentas->DOCUMENTO_CONTRATO_PROVEEDOR)) {
                                Storage::delete($cuentas->DOCUMENTO_CONTRATO_PROVEEDOR);
                            }

                            $file = $request->file('DOCUMENTO_CONTRATO_PROVEEDOR');
                            $folderPath = "proveedores/{$rfc}/Contrato proveedor/{$cuentas->ID_CONTRATO_PROVEEDORES}";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);

                            $requestData['DOCUMENTO_CONTRATO_PROVEEDOR'] = $filePath;
                        }

                        $cuentas->update(collect($requestData)->except('RFC_PROVEEDOR')->toArray());

                        $response['code'] = 1;
                        $response['cuenta'] = 'Actualizada';
                    }



                    // ADENDAS
                    if ($request->filled('FECHAI_ADENDA_CONTRATO')) {
                        $fechasInicio = $request->FECHAI_ADENDA_CONTRATO;
                        $fechasFin = $request->FECHAF_ADENDA_CONTRATO;
                        $comentarios = $request->COMENTARIO_ADENDA_CONTRATO;



                        $archivos = $request->file('DOCUMENTO_ADENDA_CONTRATO');
                        $rfc = $request->RFC_PROVEEDOR;
                        $renovacionId = $cuentas->ID_CONTRATO_PROVEEDORES;

                        $adendasAnteriores = adendacontratoproveedorModel::where('CONTRATO_ID', $renovacionId)->get()->toArray();

                        adendacontratoproveedorModel::where('CONTRATO_ID', $renovacionId)->delete();

                        foreach ($fechasInicio as $i => $inicio) {
                            $archivoRuta = null;

                            if (isset($archivos[$i]) && $archivos[$i]->isValid()) {
                                $archivo = $archivos[$i];
                                $nombre = 'adenda_' . ($i + 1) . '.' . $archivo->getClientOriginalExtension();

                                $rutaAdenda = "proveedores/{$rfc}/Contrato proveedor/{$renovacionId}/adenda de contrato/" . ($i + 1);
                                $archivoRuta = $archivo->storeAs($rutaAdenda, $nombre);
                            } elseif (isset($adendasAnteriores[$i]['DOCUMENTO_ADENDA_CONTRATO'])) {
                                $archivoRuta = $adendasAnteriores[$i]['DOCUMENTO_ADENDA_CONTRATO'];
                            }

                            adendacontratoproveedorModel::create([
                                'CONTRATO_ID' => $renovacionId,
                                'FECHAI_ADENDA_CONTRATO' => $inicio,
                                'FECHAF_ADENDA_CONTRATO' => $fechasFin[$i] ?? null,
                                'COMENTARIO_ADENDA_CONTRATO' => $comentarios[$i] ?? '',
                                'DOCUMENTO_ADENDA_CONTRATO' => $archivoRuta
                            ]);
                        }
                    }



                    $response['code']  = 1;
                    $response['cuenta']  = $cuentas;
                    return response()->json($response);
                    break;

                case 9:

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




    private function guardarArchivos(Request $request, $cuentas, $rfc)
    {
        $documentos = [
            'DOCUMENTO_CERTIFICACION' => 'certificacion',
            'DOCUMENTO_ACREDITACION' => 'acreditacion',
            'DOCUMENTO_AUTORIZACION' => 'autorizacion',
            'DOCUMENTO_MEMBRESIA' => 'membresia',
        ];

        foreach ($documentos as $input => $carpeta) {
            if ($request->hasFile($input)) {
                if ($cuentas->$input && Storage::exists($cuentas->$input)) {
                    Storage::delete($cuentas->$input);
                }

                $file = $request->file($input);
                $folderPath = "proveedores/{$rfc}/{$cuentas->ID_FORMULARIO_CERTIFICACIONPROVEEDOR}/{$carpeta}";
                $fileName = $file->getClientOriginalName();
                $filePath = $file->storeAs($folderPath, $fileName);

                $cuentas->$input = $filePath;
            }
        }

        $cuentas->save();
        return $cuentas;
    }



}
