<?php

namespace App\Http\Controllers\proveedor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Storage;
use App\Models\usuario\usuarioModel;

use Carbon\Carbon;

use DB; 

use App\Models\proveedor\directorioModel;
use App\Models\proveedor\verificacionproveedor;


class directorioController extends Controller
{
    


    public function Tabladirectorio()
    {
        try {
            $tabla = directorioModel::get();

            $rfcAlta = DB::table('formulario_altaproveedor')
                ->select(DB::raw('UPPER(TRIM(RFC_ALTA)) AS RFC_ALTA'))
                ->pluck('RFC_ALTA')
                ->toArray();

            foreach ($tabla as $value) {
                $tieneAlta = in_array(strtoupper(trim($value->RFC_PROVEEDOR)), $rfcAlta);

                $value->ROW_CLASS = $tieneAlta ? 'fila-verde' : '';

                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_DIRECTORIO . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-constancia" data-id="' . $value->ID_FORMULARIO_DIRECTORIO . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_DIRECTORIO . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-constancia" data-id="' . $value->ID_FORMULARIO_DIRECTORIO . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                }

                if ($value->PROVEEDOR_VERIFICADO == 1) {
                    $value->BTN_CORREO = '<button type="button" class="btn btn-info btn-custom rounded-pill CORREO" data-id="' . $value->ID_FORMULARIO_DIRECTORIO . '"><i class="bi bi-envelope-arrow-up-fill"></i></button>';
                } else {
                    $value->BTN_CORREO = '<button type="button" class="btn btn-secondary btn-custom rounded-pill CORREO" disabled><i class="bi bi-ban"></i></button>';
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



    public function mostrarconstanciaproveedor($id)
    {
        $archivo = directorioModel::findOrFail($id)->CONSTANCIA_DOCUMENTO;
        return Storage::response($archivo);
    }


    public function actualizarinfoproveedor(Request $request)
    {
        $rfc = $request->input('rfc');
        $rfcInfo = directorioModel::where('RFC_PROVEEDOR', $rfc)->first();

        if ($rfcInfo) {
            $rfcInfo->SERVICIOS_JSON = json_decode($rfcInfo->SERVICIOS_JSON, true);
            return response()->json($rfcInfo);
        } else {
            return response()->json(['message' => 'No se encontró el RFC.'], 404);
        }
    }




    public function enviarCorreoProveedor(Request $request)
    {
        $id = $request->input('id');

        $directorio = directorioModel::find($id);

        if (!$directorio) {
            return response()->json(['status' => 'error', 'message' => 'No se encontró el proveedor.']);
        }

        $usuario = usuarioModel::where('RFC_PROVEEDOR', $directorio->RFC_PROVEEDOR)->first();

        if (!$usuario) {
            return response()->json(['status' => 'error', 'message' => 'No se encontró un usuario con ese RFC.']);
        }
        $carbon = Carbon::now('America/Mexico_City');
        $saludo = $carbon->hour < 12 ? 'Buenos días' : 'Buenas tardes';


        Mail::send('emails.enviaracceso', [
            'saludo' => $saludo,
            'usuario' => $usuario->RFC_PROVEEDOR,
            'contrasena' => $usuario->PASSWORD_2
        ], function ($message) use ($directorio) {
            $message->to($directorio->CORREO_DIRECTORIO)
                ->subject('ERP Results - Alta Proveedor');
        });

        return response()->json(['status' => 'success', 'message' => 'Correo enviado correctamente.']);
    }


    public function verificarProveedor(Request $request)
    {
        try {
            $tieneVerificacion = DB::table('verificacion_proveedor')
                ->where('PROVEEDOR_ID', $request->ID_FORMULARIO_DIRECTORIO)
                ->exists();

            if (!$tieneVerificacion) {
                return response()->json([
                    'success' => false,
                    'message' => 'Este proveedor no tiene evidencia de verificación registrada.'
                ]);
            }

            $proveedor = directorioModel::findOrFail($request->ID_FORMULARIO_DIRECTORIO);
            $proveedor->PROVEEDOR_VERIFICADO = 1;
            $proveedor->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al verificar: ' . $e->getMessage()
            ]);
        }
    }




    public function Tablaverificacionproveedor(Request $request)
    {
        try {
            $proveedor = $request->get('proveedor');

            $tabla = verificacionproveedor::where('PROVEEDOR_ID', $proveedor)->get();




            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {

                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-verificacionproveedor" data-id="' . $value->ID_VERIFICACION_PROVEEDOR . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                } else {

                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-verificacionproveedor" data-id="' . $value->ID_VERIFICACION_PROVEEDOR . '" title="Ver documento"> <i class="bi bi-filetype-pdf"></i></button>';
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

    public function mostrarverificacionproveedor($id)
    {
        $archivo = verificacionproveedor::findOrFail($id)->EVIDENCIA_VERIFICACION;
        return Storage::response($archivo);
    }



    public function store(Request $request)
    {
        try {
            switch (intval($request->api)) {
                case 1:
                    if ($request->ID_FORMULARIO_DIRECTORIO == 0) {
                        DB::statement('ALTER TABLE formulario_directorio AUTO_INCREMENT=1;');

                        $data = $request->except(['servicios', 'CONSTANCIA_DOCUMENTO']);
                        $servicios = directorioModel::create($data);

                        if ($request->hasFile('CONSTANCIA_DOCUMENTO')) {
                            $documento = $request->file('CONSTANCIA_DOCUMENTO');
                            $idFormulario = $servicios->ID_FORMULARIO_DIRECTORIO;

                            $nombreArchivo = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', pathinfo($documento->getClientOriginalName(), PATHINFO_FILENAME));
                            $nombreArchivo .= '.' . $documento->getClientOriginalExtension();

                            $rutaCarpeta = 'compras/' . $idFormulario;
                            $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);

                            $servicios->CONSTANCIA_DOCUMENTO = $rutaCompleta;
                            $servicios->save();
                        }
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $servicios = directorioModel::where('ID_FORMULARIO_DIRECTORIO', $request['ID_FORMULARIO_DIRECTORIO'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['servicio'] = 'Desactivada';
                            } else {
                                $servicios = directorioModel::where('ID_FORMULARIO_DIRECTORIO', $request['ID_FORMULARIO_DIRECTORIO'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['servicio'] = 'Activada';
                            }
                        } else {
                            $servicios = directorioModel::find($request->ID_FORMULARIO_DIRECTORIO);
                            $servicios->update($request->except('CONSTANCIA_DOCUMENTO'));

                            if ($request->hasFile('CONSTANCIA_DOCUMENTO')) {
                                if ($servicios->CONSTANCIA_DOCUMENTO && Storage::exists($servicios->CONSTANCIA_DOCUMENTO)) {
                                    Storage::delete($servicios->CONSTANCIA_DOCUMENTO);
                                }

                                $documento = $request->file('CONSTANCIA_DOCUMENTO');
                                $idFormulario = $servicios->ID_FORMULARIO_DIRECTORIO;

                                $nombreArchivo = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', pathinfo($documento->getClientOriginalName(), PATHINFO_FILENAME));
                                $nombreArchivo .= '.' . $documento->getClientOriginalExtension();

                                $rutaCarpeta = 'compras/' . $idFormulario;
                                $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);

                                $servicios->CONSTANCIA_DOCUMENTO = $rutaCompleta;
                                $servicios->save();
                            }

                            $response['code'] = 1;
                            $response['servicio'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }

                    $response['code'] = 1;
                    $response['servicio'] = $servicios;
                    return response()->json($response);
                    break;




                case 2:
                    if ($request->ID_VERIFICACION_PROVEEDOR == 0) {
                        DB::statement('ALTER TABLE verificacion_proveedor AUTO_INCREMENT=1;');
                        $cliente = verificacionproveedor::create($request->all());

                        if ($request->hasFile('EVIDENCIA_VERIFICACION')) {
                            $documento = $request->file('EVIDENCIA_VERIFICACION');
                            $clienteId = $cliente->PROVEEDOR_ID;
                            $registroId = $cliente->ID_VERIFICACION_PROVEEDOR;

                            $extension = $documento->getClientOriginalExtension();
                            $nombreBase = pathinfo($documento->getClientOriginalName(), PATHINFO_FILENAME);
                            $nombreLimpio = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $nombreBase);
                            $nombreArchivo = $nombreLimpio . '.' . $extension;

                            $ruta = "compras/{$clienteId}/verificacion del proveedor/{$registroId}";
                            $rutaCompleta = $documento->storeAs($ruta, $nombreArchivo);

                            $cliente->EVIDENCIA_VERIFICACION = $rutaCompleta;
                            $cliente->save();
                        }
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $cliente = verificacionproveedor::where('ID_VERIFICACION_PROVEEDOR', $request['ID_VERIFICACION_PROVEEDOR'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['cliente'] = 'Desactivada';
                            } else {
                                $cliente = verificacionproveedor::where('ID_VERIFICACION_PROVEEDOR', $request['ID_VERIFICACION_PROVEEDOR'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['cliente'] = 'Activada';
                            }
                        } else {
                            $cliente = verificacionproveedor::find($request->ID_VERIFICACION_PROVEEDOR);
                            $cliente->update($request->all());

                            // Guardar nueva evidencia si viene
                            if ($request->hasFile('EVIDENCIA_VERIFICACION')) {
                                $documento = $request->file('EVIDENCIA_VERIFICACION');
                                $clienteId = $cliente->PROVEEDOR_ID;
                                $registroId = $cliente->ID_VERIFICACION_PROVEEDOR;

                                $extension = $documento->getClientOriginalExtension();
                                $nombreBase = pathinfo($documento->getClientOriginalName(), PATHINFO_FILENAME);
                                $nombreLimpio = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $nombreBase);
                                $nombreArchivo = $nombreLimpio . '.' . $extension;

                                $ruta = "compras/{$clienteId}/verificacion del proveedor/{$registroId}";
                                $rutaCompleta = $documento->storeAs($ruta, $nombreArchivo);

                                $cliente->EVIDENCIA_VERIFICACION = $rutaCompleta;
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


                default:
                    $response['code'] = 1;
                    $response['msj'] = 'Api no encontrada';
                    return response()->json($response);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al guardar', 'message' => $e->getMessage()]);
        }
    }
}