<?php

namespace App\Http\Controllers\solicitudes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

use DB;


use App\Models\solicitudes\solicitudesModel;
use App\Models\solicitudes\verificacionsolicitudModel;
use App\Models\solicitudes\catalogomediocontactoModel;
use App\Models\solicitudes\catalonecesidadModel;
use App\Models\solicitudes\catalogiroempresaModel;
use App\Models\solicitudes\catalogolineanegociosModel;
use App\Models\solicitudes\catalogotiposervicioModel;
use App\Models\proveedor\catalogotituloproveedorModel;
use App\Models\cliente\clienteModel;


class solicitudesController extends Controller
{



    public function index()
    {


        $medios = catalogomediocontactoModel::where('ACTIVO', 1)->get();
        $necesidades = catalonecesidadModel::where('ACTIVO', 1)->get();
        $giros = catalogiroempresaModel::where('ACTIVO', 1)->get();

        $lineas = catalogolineanegociosModel::where('ACTIVO', 1)->get();
        $tipos = catalogotiposervicioModel::where('ACTIVO', 1)->get();

        $titulosCuenta = catalogotituloproveedorModel::where('ACTIVO', 1)->get();


        $clientes = clienteModel::where('ACTIVO', 1)->get();


        return view('ventas.solicitudes.solicitudes', compact('medios', 'necesidades','giros', 'lineas', 'tipos', 'titulosCuenta', 'clientes'));


    }

    public function buscarCliente(Request $request)
    {
        $rfc = $request->query('rfc');

        $cliente = clienteModel::where('RFC_CLIENTE', $rfc)->first();

        if ($cliente) {
            $direcciones = [];
            if (!empty($cliente->DIRECCIONES_JSON)) {
                $direccionesArray = json_decode($cliente->DIRECCIONES_JSON, true);
                foreach ($direccionesArray as $dir) {
                    if (($dir['TIPODEDOMICILIOFISCAL'] ?? '') === 'nacional') {
                        $direccionFormateada =
                            ($dir['NOMBRE_VIALIDAD_DOMICILIO'] ?? '') . ' ' .
                            (empty($dir['NUMERO_EXTERIOR_DOMICILIO']) ? '' : 'No. ' . $dir['NUMERO_EXTERIOR_DOMICILIO']) .
                            (empty($dir['NUMERO_INTERIOR_DOMICILIO']) ? '' : ' Int. ' . $dir['NUMERO_INTERIOR_DOMICILIO']) .
                            (empty($dir['NOMBRE_COLONIA_DOMICILIO']) ? '' : ', Colonia ' . $dir['NOMBRE_COLONIA_DOMICILIO']) .
                            (empty($dir['NOMBRE_LOCALIDAD_DOMICILIO']) ? '' : ', ' . $dir['NOMBRE_LOCALIDAD_DOMICILIO']) .
                            (empty($dir['CODIGO_POSTAL_DOMICILIO']) ? '' : ', C.P. ' . $dir['CODIGO_POSTAL_DOMICILIO']) .
                            (empty($dir['NOMBRE_MUNICIPIO_DOMICILIO']) ? '' : ', ' . $dir['NOMBRE_MUNICIPIO_DOMICILIO']) .
                            (empty($dir['NOMBRE_ENTIDAD_DOMICILIO']) ? '' : ', ' . $dir['NOMBRE_ENTIDAD_DOMICILIO']) .
                            (empty($dir['PAIS_CONTRATACION_DOMICILIO']) ? '' : ', ' . $dir['PAIS_CONTRATACION_DOMICILIO']);

                        $direcciones[] = [
                            'tipo' => 'Nacional',
                            'direccion' => $direccionFormateada,
                        ];
                    } elseif (($dir['TIPODEDOMICILIOFISCAL'] ?? '') === 'extranjero') {
                        $direccionFormateada =
                            ($dir['DOMICILIO_EXTRANJERO'] ?? '') .
                            (empty($dir['CIUDAD_EXTRANJERO']) ? '' : ', ' . $dir['CIUDAD_EXTRANJERO']) .
                            (empty($dir['ESTADO_EXTRANJERO']) ? '' : ', ' . $dir['ESTADO_EXTRANJERO']) .
                            (empty($dir['PAIS_EXTRANJERO']) ? '' : ', ' . $dir['PAIS_EXTRANJERO']) .
                            (empty($dir['CP_EXTRANJERO']) ? '' : ', C.P. ' . $dir['CP_EXTRANJERO']);

                        $direcciones[] = [
                            'tipo' => 'Extranjero',
                            'direccion' => $direccionFormateada,
                        ];
                    }
                }
            }

            $contactos = [];
            if (!empty($cliente->CONTACTOS_JSON)) {
                $contactosArray = json_decode($cliente->CONTACTOS_JSON, true);
                foreach ($contactosArray as $contacto) {
                    $contactos[] = $contacto;
                }
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'RAZON_SOCIAL_CLIENTE' => $cliente->RAZON_SOCIAL_CLIENTE,
                    'NOMBRE_COMERCIAL_CLIENTE' => $cliente->NOMBRE_COMERCIAL_CLIENTE,
                    'GIRO_EMPRESA_CLIENTE' => $cliente->GIRO_EMPRESA_CLIENTE,
                    'REPRESENTANTE_LEGAL_CLIENTE' => $cliente->REPRESENTANTE_LEGAL_CLIENTE,
                    'DIRECCIONES' => $direcciones,
                    'CONTACTOS' => $contactos,
                ],
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Cliente no encontrado',
            ]);
        }
    }


    // public function Tablasolicitudes()
    // {
    //     try {
    //         $tabla = solicitudesModel::get();

    //         $rows = [];
    //         foreach ($tabla as $value) {
    //             $verificaciones = verificacionsolicitudModel::where('SOLICITUD_ID', $value->ID_FORMULARIO_SOLICITUDES)->get();

    //             $verificacionesAgrupadas = $verificaciones->map(function ($verificacion) {
    //                 return [
    //                     'VERIFICADO_EN' => $verificacion->VERIFICADO_EN,
    //                     'EVIDENCIA_VERIFICACION' => $verificacion->EVIDENCIA_VERIFICACION,
    //                     'BTN_DOCUMENTO' => '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-verificacion" data-id="' . $verificacion->ID_VERIFICACION_SOLICITUD . '" title="Ver evidencia"> <i class="bi bi-filetype-pdf"></i></button>'
    //                 ];
    //             });
    //             $rows[] = array_merge($value->toArray(), [
    //                 'SOLICITAR_VERIFICACION' => $value->SOLICITAR_VERIFICACION,
    //                 'PROCEDE_COTIZAR' => $value->PROCEDE_COTIZAR,
    //                 'MOTIVO_COTIZACION' => $value->MOTIVO_COTIZACION, 
    //                 'VERIFICACIONES' => $verificacionesAgrupadas,
    //                 'BTN_EDITAR' => ($value->ACTIVO == 0) ?
    //                     '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>' :
    //                     '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>',
    //                 'BTN_VISUALIZAR' => '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>',
    //                 'BTN_ELIMINAR' => '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_SOLICITUDES . '"' . ($value->ACTIVO ? ' checked' : '') . '><span class="slider round"></span></label>',
    //                 'BTN_CORREO' => ($value->ACTIVO == 0) ?
    //                     '<button type="button" class="btn btn-info btn-custom rounded-pill CORREO" disabled><i class="bi bi-ban"></i></button>' :
    //                     '<button type="button" class="btn btn-info btn-custom rounded-pill CORREO"><i class="bi bi-envelope-arrow-up-fill"></i></button>',
    //             ]);

    //         }

    //         return response()->json([
    //             'data' => $rows,
    //             'msj' => 'Información consultada correctamente'
    //         ]);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'msj' => 'Error ' . $e->getMessage(),
    //             'data' => 0
    //         ]);
    //     }
    // }

    public function Tablasolicitudes()
    {
        try {

            $fechaInicio = Carbon::now('America/Mexico_City')->startOfYear()->toDateString();
            $fechaFin    = Carbon::now('America/Mexico_City')->endOfYear()->toDateString();

            $tabla = solicitudesModel::whereBetween(
                DB::raw('DATE(FECHA_CREACION_SOLICITUD)'),
                [$fechaInicio, $fechaFin]
            )->get();

            $rows = [];
            foreach ($tabla as $value) {

                $verificaciones = verificacionsolicitudModel::where(
                    'SOLICITUD_ID',
                    $value->ID_FORMULARIO_SOLICITUDES
                )->get();

                $verificacionesAgrupadas = $verificaciones->map(function ($verificacion) {
                    return [
                        'VERIFICADO_EN' => $verificacion->VERIFICADO_EN,
                        'EVIDENCIA_VERIFICACION' => $verificacion->EVIDENCIA_VERIFICACION,
                        'BTN_DOCUMENTO' =>
                        '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-verificacion"
                            data-id="' . $verificacion->ID_VERIFICACION_SOLICITUD . '"
                            title="Ver evidencia">
                            <i class="bi bi-filetype-pdf"></i>
                        </button>'
                    ];
                });

                $rows[] = array_merge($value->toArray(), [
                    'SOLICITAR_VERIFICACION' => $value->SOLICITAR_VERIFICACION,
                    'PROCEDE_COTIZAR' => $value->PROCEDE_COTIZAR,
                    'MOTIVO_COTIZACION' => $value->MOTIVO_COTIZACION,
                    'VERIFICACIONES' => $verificacionesAgrupadas,
                    'BTN_EDITAR' => ($value->ACTIVO == 0)
                        ? '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled>
                            <i class="bi bi-ban"></i>
                       </button>'
                        : '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR">
                            <i class="bi bi-pencil-square"></i>
                       </button>',
                    'BTN_VISUALIZAR' => '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR">
                                        <i class="bi bi-eye"></i>
                                     </button>',
                    'BTN_ELIMINAR' => '<label class="switch">
                                    <input type="checkbox" class="ELIMINAR"
                                        data-id="' . $value->ID_FORMULARIO_SOLICITUDES . '"' .
                        ($value->ACTIVO ? ' checked' : '') . '>
                                    <span class="slider round"></span>
                                  </label>',
                    'BTN_CORREO' => ($value->ACTIVO == 0)
                        ? '<button type="button" class="btn btn-info btn-custom rounded-pill CORREO" disabled>
                            <i class="bi bi-ban"></i>
                       </button>'
                        : '<button type="button" class="btn btn-info btn-custom rounded-pill CORREO">
                            <i class="bi bi-envelope-arrow-up-fill"></i>
                       </button>',
                ]);
            }

            return response()->json([
                'data' => $rows,
                'msj' => 'Información consultada correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'msj' => 'Error ' . $e->getMessage(),
                'data' => 0
            ]);
        }
    }



    public function mostrarverificacioncliente($id)
    {
        $archivo = verificacionsolicitudModel::findOrFail($id)->EVIDENCIA_VERIFICACION;
        return Storage::response($archivo);
    }


    public function actualizarSolicitud(Request $request)
    {
        $solicitud = solicitudesModel::find($request->ID_FORMULARIO_SOLICITUDES);

        if ($solicitud) {
            $solicitud->SOLICITAR_VERIFICACION = 1;
            $solicitud->save();

            return response()->json(['success' => true, 'message' => 'Estado actualizado correctamente']);
        }

        return response()->json(['success' => false, 'message' => 'No se encontró la solicitud']);
    }




    public function actualizarEstatusSolicitud(Request $request)
    {
        try {
            $request->validate([
                'ID_FORMULARIO_SOLICITUDES' => 'required|exists:formulario_solicitudes,ID_FORMULARIO_SOLICITUDES',
                'ESTATUS_SOLICITUD' => 'required|string|in:Aceptada,Revisión,Rechazada',
                'MOTIVO_RECHAZO' => 'nullable|string|max:255'
            ]);

            $solicitud = solicitudesModel::find($request->ID_FORMULARIO_SOLICITUDES);

            $solicitud->ESTATUS_SOLICITUD = $request->ESTATUS_SOLICITUD;
            $solicitud->MOTIVO_RECHAZO = $request->ESTATUS_SOLICITUD === 'Rechazada' ? $request->MOTIVO_RECHAZO : null;
            $solicitud->save();

            return response()->json([
                'success' => true,
                'message' => 'Estatus actualizado correctamente.'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el estatus: ' . $e->getMessage()
            ], 500);
        }
    }



    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            switch (intval($request->api)) {

                // case 1:
                //     if ($request->ID_FORMULARIO_SOLICITUDES == 0) {
                //         $ultimoRegistro = solicitudesModel::orderBy('ID_FORMULARIO_SOLICITUDES', 'desc')->first();
                //         $numeroIncremental = $ultimoRegistro ? intval(substr($ultimoRegistro->NO_SOLICITUD, 0, 3)) + 1 : 1;
                //         $anioActual = date('Y');
                //         $ultimoDigitoAnio = substr($anioActual, -2);
                //         $noSolicitud = str_pad($numeroIncremental, 3, '0', STR_PAD_LEFT) . '-' . $ultimoDigitoAnio;

                //         $request->merge(['NO_SOLICITUD' => $noSolicitud]);

                //         DB::statement('ALTER TABLE formulario_solicitudes AUTO_INCREMENT=1;');

                //         $data = $request->except(['observacion', 'contactos', 'direcciones']);
                //         $solicitudes = solicitudesModel::create($data);

                //         $solicitudId = $solicitudes->ID_FORMULARIO_SOLICITUDES;

                //         $response['code'] = 1;
                //         $response['solicitud'] = $solicitudes;
                //     } else {
                //         $solicitudes = solicitudesModel::find($request->ID_FORMULARIO_SOLICITUDES);
                //         if (!$solicitudes) {
                //             throw new Exception("Solicitud no encontrada");
                //         }
                //         $solicitudes->update($request->except('FOTO_USUARIO'));
                //         $solicitudId = $solicitudes->ID_FORMULARIO_SOLICITUDES;
                //         $response['code'] = 1;
                //         $response['solicitud'] = 'Actualizada';
                //     }

                //     if ($request->has('VERIFICADO_EN')) {
                //         foreach ($request->VERIFICADO_EN as $index => $verificadoEn) {
                //             $archivoPath = verificacionsolicitudModel::where('SOLICITUD_ID', $solicitudId)
                //                 ->where('VERIFICADO_EN', $verificadoEn)
                //                 ->value('EVIDENCIA_VERIFICACION');

                //             if ($request->hasFile("EVIDENCIA_VERIFICACION.$index")) {
                //                 $baseFolder = "ventas/solicitudes/$solicitudId/";

                //                 if (!Storage::exists($baseFolder)) {
                //                     Storage::makeDirectory($baseFolder);
                //                 }

                //                 $archivoFile = $request->file("EVIDENCIA_VERIFICACION.$index");

                //                 if ($archivoPath && Storage::exists($archivoPath)) {
                //                     Storage::delete($archivoPath);
                //                 }

                //                 $archivoFileName = $archivoFile->getClientOriginalName();
                //                 $archivoFile->storeAs($baseFolder, $archivoFileName);

                //                 $archivoPath = $baseFolder . $archivoFileName;
                //             }

                //             verificacionsolicitudModel::updateOrCreate(
                //                 [
                //                     'SOLICITUD_ID' => $solicitudId,
                //                     'VERIFICADO_EN' => $verificadoEn,
                //                 ],
                //                 [
                //                     'EVIDENCIA_VERIFICACION' => $archivoPath,
                //                 ]
                //             );
                //         }
                //     }

                //     DB::commit();
                //     return response()->json($response);
                //     break;


                case 1:
                    if ($request->ID_FORMULARIO_SOLICITUDES == 0) {

                     
                        $anioActual = date('Y');
                        $ultimoDigitoAnio = substr($anioActual, -2);

                        $ultimoRegistro = solicitudesModel::where('NO_SOLICITUD', 'like', '%-' . $ultimoDigitoAnio)
                            ->orderBy('ID_FORMULARIO_SOLICITUDES', 'desc')
                            ->first();

                        $numeroIncremental = $ultimoRegistro
                            ? intval(substr($ultimoRegistro->NO_SOLICITUD, 0, 3)) + 1
                            : 1;

                        $noSolicitud = str_pad($numeroIncremental, 3, '0', STR_PAD_LEFT) . '-' . $ultimoDigitoAnio;

                        $request->merge(['NO_SOLICITUD' => $noSolicitud]);

                        DB::statement('ALTER TABLE formulario_solicitudes AUTO_INCREMENT=1;');

                        $data = $request->except(['observacion', 'contactos', 'direcciones']);
                        $solicitudes = solicitudesModel::create($data);

                        $solicitudId = $solicitudes->ID_FORMULARIO_SOLICITUDES;

                        $response['code'] = 1;
                        $response['solicitud'] = $solicitudes;
                    } else {

                        $solicitudes = solicitudesModel::find($request->ID_FORMULARIO_SOLICITUDES);
                        if (!$solicitudes) {
                            throw new Exception("Solicitud no encontrada");
                        }

                        $solicitudes->update($request->except('FOTO_USUARIO'));
                        $solicitudId = $solicitudes->ID_FORMULARIO_SOLICITUDES;

                        $response['code'] = 1;
                        $response['solicitud'] = 'Actualizada';
                    }

                    if ($request->has('VERIFICADO_EN')) {
                        foreach ($request->VERIFICADO_EN as $index => $verificadoEn) {

                            $archivoPath = verificacionsolicitudModel::where('SOLICITUD_ID', $solicitudId)
                                ->where('VERIFICADO_EN', $verificadoEn)
                                ->value('EVIDENCIA_VERIFICACION');

                            if ($request->hasFile("EVIDENCIA_VERIFICACION.$index")) {

                                $baseFolder = "ventas/solicitudes/$solicitudId/";

                                if (!Storage::exists($baseFolder)) {
                                    Storage::makeDirectory($baseFolder);
                                }

                                $archivoFile = $request->file("EVIDENCIA_VERIFICACION.$index");

                                if ($archivoPath && Storage::exists($archivoPath)) {
                                    Storage::delete($archivoPath);
                                }

                                $archivoFileName = $archivoFile->getClientOriginalName();
                                $archivoFile->storeAs($baseFolder, $archivoFileName);

                                $archivoPath = $baseFolder . $archivoFileName;
                            }

                            verificacionsolicitudModel::updateOrCreate(
                                [
                                    'SOLICITUD_ID' => $solicitudId,
                                    'VERIFICADO_EN' => $verificadoEn,
                                ],
                                [
                                    'EVIDENCIA_VERIFICACION' => $archivoPath,
                                ]
                            );
                        }
                    }

                    DB::commit();
                    return response()->json($response);
                    break;



                default:
                    DB::rollback();
                    $response['code'] = 1;
                    $response['msj'] = 'Api no encontrada';
                    return response()->json($response);
            }
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Error al guardar la solicitud', 'message' => $e->getMessage()]);
        }
    }



}
