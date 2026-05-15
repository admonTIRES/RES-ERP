<?php

namespace App\Http\Controllers\listamantenimiento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use App\Models\inventario\inventarioModel;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

use App\Models\inventario\catalogotipoinventarioModel;
use App\Models\proveedor\altaproveedorModel;
use App\Models\proveedor\proveedortempModel;

use App\Models\listamtto\listamttoinstalacionesModel;


use DB;


class listainstalacionController extends Controller
{
    public function index()
    {
        $tipoinventario = catalogotipoinventarioModel::where('ACTIVO', 1)->get();


        $proveedoresOficiales = altaproveedorModel::select('RAZON_SOCIAL_ALTA', 'RFC_ALTA')->get();
        $proveedoresTemporales = proveedortempModel::select('RAZON_PROVEEDORTEMP', 'RFC_PROVEEDORTEMP', 'NOMBRE_PROVEEDORTEMP')->get();



        return view('mantenimiento.listainstalacion.listamttoinstalacion', compact('tipoinventario', 'proveedoresOficiales', 'proveedoresTemporales'));
    }


    public function Tablalistainstalacion()
    {
        try {
            $tabla = listamttoinstalacionesModel::get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_INSTALACIONES . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_INSTALACIONES . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }

                $value->FOTO_INSTALACION_HTML = '<img src="/mostrarFotoInstalacion/' . $value->ID_FORMULARIO_INSTALACIONES . '" alt="Foto" class="img-fluid" width="50" height="60">';


                }

            // Respuesta
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



    public function mostrarFotoInstalacion($id)
    {
        $foto = listamttoinstalacionesModel::findOrFail($id);
        return Storage::response($foto->FOTO_INSTALACION);
    }


    public function  store(Request $request)
    {
        try {
            switch (intval($request->api)) {


                case 1:

                    if ($request->ID_FORMULARIO_INSTALACIONES == 0) {

                        DB::statement('ALTER TABLE formulario_mttoinstalaciones AUTO_INCREMENT=1;');
                        $cliente = listamttoinstalacionesModel::create($request->all());

                      
                        $registroId = $cliente->ID_FORMULARIO_INSTALACIONES;

                      
                        if ($request->hasFile('FOTO_INSTALACION')) {

                            $foto = $request->file('FOTO_INSTALACION');
                            $extension = $foto->getClientOriginalExtension();
                            $nombreBase = 'foto';
                            $nombreLimpio = iconv('UTF-8', 'ASCII//TRANSLIT', $nombreBase);
                            $nombreLimpio = preg_replace('/[^A-Za-z0-9\-]/', '_', $nombreLimpio);
                            $nombreLimpio = trim($nombreLimpio, '_');
                            $nombreArchivo = $nombreLimpio . '.' . $extension;
                            $rutaFoto = "Mantenimiento/Instalaciones/{$registroId}/Foto instalación";
                            $rutaFotoCompleta = $foto->storeAs($rutaFoto, $nombreArchivo);
                            $cliente->FOTO_INSTALACION = $rutaFotoCompleta;
                        }

                        $cliente->save();
                    } else {

                        if (isset($request->ELIMINAR)) {

                            if ($request->ELIMINAR == 1) {
                                listamttoinstalacionesModel::where('ID_FORMULARIO_INSTALACIONES', $request['ID_FORMULARIO_INSTALACIONES'])
                                    ->update(['ACTIVO' => 0]);

                                $response['code'] = 1;
                                $response['cliente'] = 'Desactivada';
                            } else {

                                listamttoinstalacionesModel::where('ID_FORMULARIO_INSTALACIONES', $request['ID_FORMULARIO_INSTALACIONES'])
                                    ->update(['ACTIVO' => 1]);

                                $response['code'] = 1;
                                $response['cliente'] = 'Activada';
                            }
                        } else {

                            $cliente = listamttoinstalacionesModel::find($request->ID_FORMULARIO_INSTALACIONES);
                            $cliente->update($request->all());

                            $registroId = $cliente->ID_FORMULARIO_INSTALACIONES;

                          
                            if ($request->hasFile('FOTO_INSTALACION')) {

                                $foto = $request->file('FOTO_INSTALACION');
                                $extension = $foto->getClientOriginalExtension();
                                $nombreBase = 'foto';
                                $nombreLimpio = iconv('UTF-8', 'ASCII//TRANSLIT', $nombreBase);
                                $nombreLimpio = preg_replace('/[^A-Za-z0-9\-]/', '_', $nombreLimpio);
                                $nombreLimpio = trim($nombreLimpio, '_');
                                $nombreArchivo = $nombreLimpio . '.' . $extension;
                                $rutaFoto = "Mantenimiento/Instalaciones/{$registroId}/Fotos instalación";
                                $rutaFotoCompleta = $foto->storeAs($rutaFoto, $nombreArchivo);
                                $cliente->FOTO_INSTALACION = $rutaFotoCompleta;
                            }


                            $cliente->save();

                            $response['code'] = 1;
                            $response['cliente'] = 'Actualizada';
                        }

                        return response()->json($response);
                    }

                    $response['code'] = 1;
                    $response['cliente'] = $cliente;
                    return response()->json($response);

                    break;



                case 4:

                    if ($request->ID_DOCUMENTO_CALIBRACION == 0) {

                        DB::statement('ALTER TABLE documentos_calibracion_mantenimiento AUTO_INCREMENT=1;');
                        $cliente = documentoscalibracionModel::create($request->all());

                        $articuloId = $cliente->MANTENIMIENTO_ID;
                        $registroId = $cliente->ID_DOCUMENTO_CALIBRACION;


                        if ($request->hasFile('DOCUMENTO_CALIBRACION')) {
                            $documento = $request->file('DOCUMENTO_CALIBRACION');
                            $extension = $documento->getClientOriginalExtension();
                            $nombreBase = $request->NOMBRE_DOCUMENTO_CALIBRACION ?? 'documento';
                            $nombreLimpio = iconv('UTF-8', 'ASCII//TRANSLIT', $nombreBase);
                            $nombreLimpio = preg_replace('/[^A-Za-z0-9\-]/', '_', $nombreLimpio);
                            $nombreLimpio = trim($nombreLimpio, '_');
                            $nombreArchivo = $nombreLimpio . '.' . $extension;
                            $ruta = "Mantenimiento/Equipo/{$articuloId}/Documento de calibración/{$registroId}";
                            $rutaCompleta = $documento->storeAs($ruta, $nombreArchivo);
                            $cliente->DOCUMENTO_CALIBRACION = $rutaCompleta;
                        }

                        $cliente->save();
                    } else {

                        if (isset($request->ELIMINAR)) {

                            if ($request->ELIMINAR == 1) {
                                documentoscalibracionModel::where('ID_DOCUMENTO_CALIBRACION', $request['ID_DOCUMENTO_CALIBRACION'])
                                    ->update(['ACTIVO' => 0]);

                                $response['code'] = 1;
                                $response['cliente'] = 'Desactivada';
                            } else {

                                documentoscalibracionModel::where('ID_DOCUMENTO_CALIBRACION', $request['ID_DOCUMENTO_CALIBRACION'])
                                    ->update(['ACTIVO' => 1]);

                                $response['code'] = 1;
                                $response['cliente'] = 'Activada';
                            }
                        } else {

                            $cliente = documentoscalibracionModel::find($request->ID_DOCUMENTO_CALIBRACION);
                            $cliente->update($request->all());

                            $articuloId = $cliente->MANTENIMIENTO_ID;
                            $registroId = $cliente->ID_DOCUMENTO_CALIBRACION;

                            if ($request->hasFile('DOCUMENTO_CALIBRACION')) {

                                $documento = $request->file('DOCUMENTO_CALIBRACION');
                                $extension = $documento->getClientOriginalExtension();
                                $nombreBase = $request->NOMBRE_DOCUMENTO_CALIBRACION ?? 'documento';
                                $nombreLimpio = iconv('UTF-8', 'ASCII//TRANSLIT', $nombreBase);
                                $nombreLimpio = preg_replace('/[^A-Za-z0-9\-]/', '_', $nombreLimpio);
                                $nombreLimpio = trim($nombreLimpio, '_');
                                $nombreArchivo = $nombreLimpio . '.' . $extension;
                                $ruta = "Mantenimiento/Equipo/{$articuloId}/Documento de calibración/{$registroId}";
                                $rutaCompleta = $documento->storeAs($ruta, $nombreArchivo);
                                $cliente->DOCUMENTO_CALIBRACION = $rutaCompleta;
                            }


                            $cliente->save();

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
                    $response['code']  = 1;
                    $response['msj']  = 'Api no encontrada';
                    return response()->json($response);
            }
        } catch (Exception $e) {
            return response()->json('Error al guardar');
        }
    }




}
