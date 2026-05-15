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
use App\Models\inventario\documentosarticulosModel;
use App\Models\proveedor\altaproveedorModel;
use App\Models\proveedor\proveedortempModel;
use App\Models\inventario\documentoscalibracionModel;
use App\Models\inventario\informacionmttoModel;


use DB;




class listamantenimientoController extends Controller
{
    public function index()
    {
        $tipoinventario = catalogotipoinventarioModel::where('ACTIVO', 1)->get();


        $proveedoresOficiales = altaproveedorModel::select('RAZON_SOCIAL_ALTA', 'RFC_ALTA')->get();
        $proveedoresTemporales = proveedortempModel::select('RAZON_PROVEEDORTEMP', 'RFC_PROVEEDORTEMP', 'NOMBRE_PROVEEDORTEMP')->get();



        return view('mantenimiento.listamantenimiento.listamantenimiento', compact('tipoinventario', 'proveedoresOficiales', 'proveedoresTemporales'));
    }


    public function Tablamantenimiento()
    {
        try {
            $tabla = inventarioModel::where('REQUIERE_ARTICULO', 2)->get();

            foreach ($tabla as $value) {



                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_INVENTARIO . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_INVENTARIO . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }

                $value->FOTO_EQUIPO_HTML = '<img src="/mostrarFotoEquipoMan/' . $value->ID_FORMULARIO_INVENTARIO . '" alt="Foto" class="img-fluid" width="50" height="60">';


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

    public function cantidadEquipoReadonlyMan()
    {
        return response()->json([
            'readonly' => Auth::user()->ID_USUARIO == 10
        ]);
    }

    public function mostrarFotoEquipoMan($usuario_id)
    {
        $foto = inventarioModel::findOrFail($usuario_id);
        return Storage::response($foto->FOTO_EQUIPO);
    }


    ///////////////// DOCUMENTOS DEL EQUIPO  ///////////////// 

    public function Tabladocumentomantenimiento(Request $request)
    {
        try {


            $equipo = $request->get('equipo');

            $tabla = documentosarticulosModel::where('INVENTARIO_ID', $equipo)->get();
            $fecha_actual = date('Y-m-d');

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {

                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_DOCUMENTO_ARTICULO . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-documentosequipo" data-id="' . $value->ID_DOCUMENTO_ARTICULO . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';

                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                } else {

                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-documentosequipo" data-id="' . $value->ID_DOCUMENTO_ARTICULO . '" title="Ver documento"> <i class="bi bi-filetype-pdf"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_DOCUMENTO_ARTICULO . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';

                }

                $value->FOTO_DOCUMENTOS_HTML = '<img src="/FotosDocMtto/' . $value->ID_DOCUMENTO_ARTICULO . '" alt="Foto" class="img-fluid" width="130">';


                if ($value->TIPO_DOCUMENTO == 1) {
                    $value->TIPO_DOCUMENTO_TEXTO = "Documento";
                } elseif ($value->TIPO_DOCUMENTO == 2) {
                    $value->TIPO_DOCUMENTO_TEXTO = "Imagen";
                } else {
                    $value->TIPO_DOCUMENTO_TEXTO = "N/A";
                }


                if ($value->REQUIERE_FECHA == 1) {

                    if ($value->INDETERMINADO_DOCUMENTO == 1) {

                        $value->FECHAS_DOCUMENTOS = '
                                <div>
                                    <strong>' . $value->FECHAI_DOCUMENTO . '</strong><br>
                                    <span class="badge bg-success text-light">Indeterminado</span>
                                </div>';
                    } elseif (!empty($value->FECHAI_DOCUMENTO) && !empty($value->FECHAF_DOCUMENTO)) {

                        $fechaInicio = strtotime($value->FECHAI_DOCUMENTO);
                        $fechaFin    = strtotime($value->FECHAF_DOCUMENTO);
                        $hoy         = strtotime($fecha_actual);

                        $total_dias = ($fechaFin - $fechaInicio) / 86400;
                        $restantes  = ($fechaFin - $hoy) / 86400;

                        if ($hoy > $fechaFin) {
                            $restantes = 0;
                        }

                        $transcurrido = $total_dias > 0
                            ? (($total_dias - $restantes) / $total_dias) * 100
                            : 100;

                        if ($hoy > $fechaFin) {
                            $color = 'danger';
                            $texto = 'Vencido';
                        } else {

                            if ($transcurrido <= 40) {
                                $color = 'success';
                                $texto = 'Vigente';
                            } elseif ($transcurrido <= 70) {
                                $color = 'warning';
                                $texto = 'Revisar';
                            } else {
                                $color = 'danger';
                                $texto = 'Próximo a vencer';
                            }
                        }

                        $dias_restantes = max(0, floor($restantes));
                        $porcentaje = round($transcurrido);

                        $value->FECHAS_DOCUMENTOS = '
                            <div>
                                <strong>' . $value->FECHAI_DOCUMENTO . ' - ' . $value->FECHAF_DOCUMENTO . '</strong><br>
                                <span class="badge bg-' . $color . ' text-light">
                                    ' . $texto . ' (' . $dias_restantes . ' días restantes)
                                </span>
                            </div>';
                    } else {

                        $value->FECHAS_DOCUMENTOS = 'Sin fecha';
                    }
                } else {

                    $value->FECHAS_DOCUMENTOS = 'N/A';
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

    public function mostrardocumentomantenimiento($id)
    {
        $archivo = documentosarticulosModel::findOrFail($id)->DOCUMENTO_ARTICULO;
        return Storage::response($archivo);
    }


    public function obtenerDocumentosPorMantenimiento($inventario_id)
    {
        $documentos = documentosarticulosModel::where('INVENTARIO_ID', $inventario_id)
            ->where('REQUIERE_FECHA', 1)
            ->where('INDETERMINADO_DOCUMENTO', 2)
            ->select('NOMBRE_DOCUMENTO', 'FECHAI_DOCUMENTO', 'FECHAF_DOCUMENTO')
            ->get();

        return response()->json($documentos);
    }

    public function FotosDocMtto($imagen_id)
    {
        $foto = documentosarticulosModel::findOrFail($imagen_id);
        return Storage::response($foto->FOTO_DOCUMENTO);
    }

    ///////////////// CALIBRACION DEL EQUIPO  ///////////////// 

    public function guardarRequiereCalibracion(Request $request)
    {
        DB::table('formulario_inventario')
            ->where('ID_FORMULARIO_INVENTARIO', $request->ID_FORMULARIO_INVENTARIO)
            ->update([
                'REQUIERE_CALIBRACION' => $request->REQUIERE_CALIBRACION
            ]);

        return response()->json([
            'code' => 1,
            'message' => 'Guardado correctamente'
        ]);
    }


    public function Tablacalibracionmantenimiento(Request $request)
    {
        try {


            $equipo = $request->get('equipo');

            $tabla = documentoscalibracionModel::where('MANTENIMIENTO_ID', $equipo)->get();
            $fecha_actual = date('Y-m-d');

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {

                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_DOCUMENTO_CALIBRACION . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-documentoscalibracion" data-id="' . $value->ID_DOCUMENTO_CALIBRACION . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';

                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                } else {

                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-documentoscalibracion" data-id="' . $value->ID_DOCUMENTO_CALIBRACION . '" title="Ver documento"> <i class="bi bi-filetype-pdf"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_DOCUMENTO_CALIBRACION . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }



                if (!empty($value->FECHAI_DOCUMENTO_CALIBRACION) && !empty($value->FECHAF_DOCUMENTO_CALIBRACION)) {

                    $fechaInicio = strtotime($value->FECHAI_DOCUMENTO_CALIBRACION);
                    $fechaFin    = strtotime($value->FECHAF_DOCUMENTO_CALIBRACION);
                    $hoy         = strtotime($fecha_actual);

                    $total_dias = ($fechaFin - $fechaInicio) / 86400;
                    $restantes  = ($fechaFin - $hoy) / 86400;

                    if ($hoy > $fechaFin) {
                        $restantes = 0;
                    }

                    $transcurrido = $total_dias > 0
                        ? (($total_dias - $restantes) / $total_dias) * 100
                        : 100;

                    if ($hoy > $fechaFin) {
                        $color = 'danger';
                        $texto = 'Vencido';
                    } else {
                        if ($transcurrido <= 40) {
                            $color = 'success';
                            $texto = 'Vigente';
                        } elseif ($transcurrido <= 70) {
                            $color = 'warning';
                            $texto = 'Revisar';
                        } else {
                            $color = 'danger';
                            $texto = 'Próximo a vencer';
                        }
                    }

                    $dias_restantes = max(0, floor($restantes));
                    $porcentaje = round($transcurrido);

                    $value->FECHAS_CALIBRACION = '
                    <div>
                        <strong>' . $value->FECHAI_DOCUMENTO_CALIBRACION . ' - ' . $value->FECHAF_DOCUMENTO_CALIBRACION . '</strong><br>
                        <span class="badge bg-' . $color . ' text-light">
                            ' . $texto . ' (' . $dias_restantes . ' días restantes)
                        </span>
                    </div>';
                } else {

                    $value->FECHAS_CALIBRACION = 'Sin fecha';
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


    public function mostrardocumentocalibracion($id)
    {
        $archivo = documentoscalibracionModel::findOrFail($id)->DOCUMENTO_CALIBRACION;
        return Storage::response($archivo);
    }


    ///////////////// MTTO CRITERIO, PROGRAMACION Y BITACORA   ///////////////// 



    public function obtenerInformacionMtto(Request $request)
    {
        $mantenimientoId = $request->get('MANTENIMIENTO_ID');

        $info = informacionmttoModel::where('MANTENIMIENTO_ID', $mantenimientoId)->first();

        if (!$info) {
            return response()->json([
                'success' => false,
                'data' => null
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $info
        ]);
    }





    public function  store(Request $request)
    {
        try {
            switch (intval($request->api)) {

                case 1:

                    if ($request->ID_FORMULARIO_INVENTARIO == 0) {
                        DB::statement('ALTER TABLE formulario_inventario AUTO_INCREMENT=1;');

                        $datos = $request->except('FOTO_EQUIPO');
                        $inventarios = inventarioModel::create($datos);

                        if ($request->hasFile('FOTO_EQUIPO')) {
                            $file = $request->file('FOTO_EQUIPO');
                            $folder = "Almacén/Inventario/{$inventarios->ID_FORMULARIO_INVENTARIO}";
                            $filename = 'foto_equipo.' . $file->getClientOriginalExtension();
                            $path = $file->storeAs($folder, $filename);

                            $inventarios->FOTO_EQUIPO = $path;
                            $inventarios->save();
                        }

                        DB::table('entradas_inventario')->insert([
                            'INVENTARIO_ID'    => $inventarios->ID_FORMULARIO_INVENTARIO,
                            'FECHA_INGRESO'    => $inventarios->FECHA_ADQUISICION,
                            'CANTIDAD_PRODUCTO' => $inventarios->CANTIDAD_EQUIPO,
                            'VALOR_UNITARIO'   => $inventarios->UNITARIO_EQUIPO,
                            'UNIDAD_MEDIDA'    => $inventarios->UNIDAD_MEDIDA,
                            'created_at'       => now(),
                            'updated_at'       => now()
                        ]);

                        $response['code']  = 1;
                        $response['inventario']  = $inventarios;
                        return response()->json($response);
                    } else {
                        if (isset($request->ELIMINAR)) {
                            $estado = $request->ELIMINAR == 1 ? 0 : 1;
                            $accion = $estado == 1 ? 'Activada' : 'Desactivada';

                            inventarioModel::where('ID_FORMULARIO_INVENTARIO', $request->ID_FORMULARIO_INVENTARIO)
                                ->update(['ACTIVO' => $estado]);

                            $response['code'] = 1;
                            $response['inventario'] = $accion;
                            return response()->json($response);
                        } else {
                            $inventarios = inventarioModel::find($request->ID_FORMULARIO_INVENTARIO);

                            if (!$inventarios) {
                                return response()->json(['code' => 0, 'msj' => 'Inventario no encontrado']);
                            }

                            if ($request->hasFile('FOTO_EQUIPO')) {
                                if ($inventarios->FOTO_EQUIPO && Storage::exists($inventarios->FOTO_EQUIPO)) {
                                    Storage::delete($inventarios->FOTO_EQUIPO);
                                }

                                $file = $request->file('FOTO_EQUIPO');
                                $folder = "Almacén/Inventario/{$inventarios->ID_FORMULARIO_INVENTARIO}";
                                $filename = 'foto_equipo.' . $file->getClientOriginalExtension();
                                $path = $file->storeAs($folder, $filename);

                                $inventarios->FOTO_EQUIPO = $path;
                            }

                            $inventarios->fill($request->except('FOTO_EQUIPO'))->save();

                            $response['code'] = 1;
                            $response['inventario'] = 'Actualizada';
                            return response()->json($response);
                        }
                    }
                    break;

                // case 3:
                //     if ($request->ID_DOCUMENTO_ARTICULO == 0) {
                //         DB::statement('ALTER TABLE documentos_articulosalmacen AUTO_INCREMENT=1;');
                //         $cliente = documentosarticulosModel::create($request->all());

                //         if ($request->hasFile('DOCUMENTO_ARTICULO')) {
                //             $documento = $request->file('DOCUMENTO_ARTICULO');
                //             $articuloId = $cliente->INVENTARIO_ID;
                //             $registroId = $cliente->ID_DOCUMENTO_ARTICULO;

                //             $extension = $documento->getClientOriginalExtension();
                //             $nombreBase = pathinfo($documento->getClientOriginalName(), PATHINFO_FILENAME);
                //             $nombreLimpio = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $nombreBase);
                //             $nombreArchivo = $nombreLimpio . '.' . $extension;

                //             $ruta = "Mantenimiento/Equipo/{$articuloId}/Documento del equipo/{$registroId}";
                //             $rutaCompleta = $documento->storeAs($ruta, $nombreArchivo);

                //             $cliente->DOCUMENTO_ARTICULO = $rutaCompleta;
                //             $cliente->save();
                //         }
                //     } else {
                //         if (isset($request->ELIMINAR)) {
                //             if ($request->ELIMINAR == 1) {
                //                 $cliente = documentosarticulosModel::where('ID_DOCUMENTO_ARTICULO', $request['ID_DOCUMENTO_ARTICULO'])->update(['ACTIVO' => 0]);
                //                 $response['code'] = 1;
                //                 $response['cliente'] = 'Desactivada';
                //             } else {
                //                 $cliente = documentosarticulosModel::where('ID_DOCUMENTO_ARTICULO', $request['ID_DOCUMENTO_ARTICULO'])->update(['ACTIVO' => 1]);
                //                 $response['code'] = 1;
                //                 $response['cliente'] = 'Activada';
                //             }
                //         } else {
                //             $cliente = documentosarticulosModel::find($request->ID_DOCUMENTO_ARTICULO);
                //             $cliente->update($request->all());

                //             if ($request->hasFile('DOCUMENTO_ARTICULO')) {
                //                 $documento = $request->file('DOCUMENTO_ARTICULO');
                //                 $articuloId = $cliente->INVENTARIO_ID;
                //                 $registroId = $cliente->ID_DOCUMENTO_ARTICULO;

                //                 $extension = $documento->getClientOriginalExtension();
                //                 $nombreBase = pathinfo($documento->getClientOriginalName(), PATHINFO_FILENAME);
                //                 $nombreLimpio = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $nombreBase);
                //                 $nombreArchivo = $nombreLimpio . '.' . $extension;

                //                 $ruta = "Mantenimiento/Equipo/{$articuloId}/Documento del equipo/{$registroId}";
                //                 $rutaCompleta = $documento->storeAs($ruta, $nombreArchivo);

                //                 $cliente->DOCUMENTO_ARTICULO = $rutaCompleta;
                //                 $cliente->save();
                //             }


                //             $response['code'] = 1;
                //             $response['cliente'] = 'Actualizada';
                //         }

                //         return response()->json($response);
                //     }

                //     $response['code'] = 1;
                //     $response['cliente'] = $cliente;
                //     return response()->json($response);
                //     break;

                case 3:

                    if ($request->ID_DOCUMENTO_ARTICULO == 0) {

                        DB::statement('ALTER TABLE documentos_articulosalmacen AUTO_INCREMENT=1;');
                        $cliente = documentosarticulosModel::create($request->all());

                        $articuloId = $cliente->INVENTARIO_ID;
                        $registroId = $cliente->ID_DOCUMENTO_ARTICULO;

                        // ================= DOCUMENTO =================

                        if ($request->hasFile('DOCUMENTO_ARTICULO')) {

                            $documento = $request->file('DOCUMENTO_ARTICULO');
                            $extension = $documento->getClientOriginalExtension();
                            $nombreBase = $request->NOMBRE_DOCUMENTO ?? 'documento';
                            $nombreLimpio = iconv('UTF-8', 'ASCII//TRANSLIT', $nombreBase);
                            $nombreLimpio = preg_replace('/[^A-Za-z0-9\-]/', '_', $nombreLimpio);
                            $nombreLimpio = trim($nombreLimpio, '_');
                            $nombreArchivo = $nombreLimpio . '.' . $extension;
                            $ruta = "Mantenimiento/Equipo/{$articuloId}/Documento del equipo/{$registroId}";
                            $rutaCompleta = $documento->storeAs($ruta, $nombreArchivo);
                            $cliente->DOCUMENTO_ARTICULO = $rutaCompleta;
                        }

                        // ================= FOTO =================

                        if ($request->hasFile('FOTO_DOCUMENTO')) {

                            $foto = $request->file('FOTO_DOCUMENTO');
                            $extension = $foto->getClientOriginalExtension();
                            $nombreBase = $request->NOMBRE_DOCUMENTO ?? 'foto';
                            $nombreLimpio = iconv('UTF-8', 'ASCII//TRANSLIT', $nombreBase);
                            $nombreLimpio = preg_replace('/[^A-Za-z0-9\-]/', '_', $nombreLimpio);
                            $nombreLimpio = trim($nombreLimpio, '_');
                            $nombreArchivo = $nombreLimpio . '.' . $extension;
                            $rutaFoto = "Mantenimiento/Equipo/{$articuloId}/Fotos adicionales/{$registroId}";
                            $rutaFotoCompleta = $foto->storeAs($rutaFoto, $nombreArchivo);
                            $cliente->FOTO_DOCUMENTO = $rutaFotoCompleta;
                        }

                        $cliente->save();

                    } else {

                        if (isset($request->ELIMINAR)) {

                            if ($request->ELIMINAR == 1) {
                                documentosarticulosModel::where('ID_DOCUMENTO_ARTICULO', $request['ID_DOCUMENTO_ARTICULO'])
                                    ->update(['ACTIVO' => 0]);

                                $response['code'] = 1;
                                $response['cliente'] = 'Desactivada';
                            } else {

                                documentosarticulosModel::where('ID_DOCUMENTO_ARTICULO', $request['ID_DOCUMENTO_ARTICULO'])
                                    ->update(['ACTIVO' => 1]);

                                $response['code'] = 1;
                                $response['cliente'] = 'Activada';
                            }
                        } else {

                            $cliente = documentosarticulosModel::find($request->ID_DOCUMENTO_ARTICULO);
                            $cliente->update($request->all());

                            $articuloId = $cliente->INVENTARIO_ID;
                            $registroId = $cliente->ID_DOCUMENTO_ARTICULO;

                            // ================= DOCUMENTO =================
                            if ($request->hasFile('DOCUMENTO_ARTICULO')) {

                                $documento = $request->file('DOCUMENTO_ARTICULO');
                                $extension = $documento->getClientOriginalExtension();
                                $nombreBase = $request->NOMBRE_DOCUMENTO ?? 'documento';
                                $nombreLimpio = iconv('UTF-8', 'ASCII//TRANSLIT', $nombreBase);
                                $nombreLimpio = preg_replace('/[^A-Za-z0-9\-]/', '_', $nombreLimpio);
                                $nombreLimpio = trim($nombreLimpio, '_');
                                $nombreArchivo = $nombreLimpio . '.' . $extension;
                                $ruta = "Mantenimiento/Equipo/{$articuloId}/Documento del equipo/{$registroId}";
                                $rutaCompleta = $documento->storeAs($ruta, $nombreArchivo);
                                $cliente->DOCUMENTO_ARTICULO = $rutaCompleta;
                            }

                            // ================= FOTO =================
                            if ($request->hasFile('FOTO_DOCUMENTO')) {

                                $foto = $request->file('FOTO_DOCUMENTO');
                                $extension = $foto->getClientOriginalExtension();
                                $nombreBase = $request->NOMBRE_DOCUMENTO ?? 'foto';
                                $nombreLimpio = iconv('UTF-8', 'ASCII//TRANSLIT', $nombreBase);
                                $nombreLimpio = preg_replace('/[^A-Za-z0-9\-]/', '_', $nombreLimpio);
                                $nombreLimpio = trim($nombreLimpio, '_');
                                $nombreArchivo = $nombreLimpio . '.' . $extension;
                                $rutaFoto = "Mantenimiento/Equipo/{$articuloId}/Fotos adicionales/{$registroId}";
                                $rutaFotoCompleta = $foto->storeAs($rutaFoto, $nombreArchivo);
                                $cliente->FOTO_DOCUMENTO = $rutaFotoCompleta;
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




                case 5:

                    if ($request->ID_INFORMACION_MTTO == 0) {

                        DB::statement('ALTER TABLE informacion_mtto AUTO_INCREMENT=1;');
                        $cliente = informacionmttoModel::create($request->all());

                        $cliente->save();
                    } else {

                        if (isset($request->ELIMINAR)) {

                            if ($request->ELIMINAR == 1) {
                                informacionmttoModel::where('ID_INFORMACION_MTTO', $request['ID_INFORMACION_MTTO'])
                                    ->update(['ACTIVO' => 0]);

                                $response['code'] = 1;
                                $response['cliente'] = 'Desactivada';
                            } else {

                                informacionmttoModel::where('ID_INFORMACION_MTTO', $request['ID_INFORMACION_MTTO'])
                                    ->update(['ACTIVO' => 1]);

                                $response['code'] = 1;
                                $response['cliente'] = 'Activada';
                            }
                        } else {

                            $cliente = informacionmttoModel::find($request->ID_INFORMACION_MTTO);
                            $cliente->update($request->all());
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





                case 2:
                    try {
                        if ($request->hasFile('excelEquipos')) {
                            $excel = $request->file('excelEquipos');

                            $spreadsheet = IOFactory::load($excel->getPathname());
                            $sheet = $spreadsheet->getActiveSheet();
                            $data = $sheet->toArray(null, true, true, true);

                            array_shift($data);
                            array_shift($data);

                            $datosGenerales = [];
                            foreach ($data as $row) {
                                if (!empty(array_filter($row))) {
                                    $datosGenerales[] = $row;
                                }
                            }

                            $drawings = $sheet->getDrawingCollection();
                            $imagenesMap = [];

                            foreach ($drawings as $drawing) {
                                $coordinates = $drawing->getCoordinates();
                                $col = strtoupper(preg_replace('/[0-9]/', '', $coordinates));
                                $rowNum = preg_replace('/[^0-9]/', '', $coordinates);

                                if ($col !== 'K') continue;

                                if ($drawing instanceof MemoryDrawing) {
                                    ob_start();
                                    call_user_func($drawing->getRenderingFunction(), $drawing->getImageResource());
                                    $imageContents = ob_get_contents();
                                    ob_end_clean();

                                    $extension = 'png';
                                    switch ($drawing->getMimeType()) {
                                        case MemoryDrawing::MIMETYPE_GIF:
                                            $extension = 'gif';
                                            break;
                                        case MemoryDrawing::MIMETYPE_JPEG:
                                            $extension = 'jpg';
                                            break;
                                    }
                                } elseif ($drawing instanceof Drawing) {
                                    $zipReader = fopen($drawing->getPath(), 'r');
                                    $imageContents = '';
                                    while (!feof($zipReader)) {
                                        $imageContents .= fread($zipReader, 1024);
                                    }
                                    fclose($zipReader);
                                    $extension = $drawing->getExtension();
                                }

                                $imagenesMap[$rowNum] = [
                                    'contents' => $imageContents,
                                    'extension' => $extension
                                ];
                            }

                            $totalEquipos = count($datosGenerales);
                            $equipoInsertados = 0;
                            $filaExcel = 3;

                            foreach ($datosGenerales as $rowData) {
                                $nuevoEquipo = inventarioModel::create([
                                    'DESCRIPCION_EQUIPO' => !empty($rowData['B']) ? $rowData['B'] : null,
                                    'MARCA_EQUIPO'       => !empty($rowData['C']) ? $rowData['C'] : null,
                                    'MODELO_EQUIPO'      => !empty($rowData['D']) ? $rowData['D'] : null,
                                    'SERIE_EQUIPO'       => !empty($rowData['E']) ? $rowData['E'] : null,
                                    'CODIGO_EQUIPO'      => !empty($rowData['F']) ? $rowData['F'] : null,
                                    'CANTIDAD_EQUIPO'    => !empty($rowData['G']) ? $rowData['G'] : null,
                                    'UBICACION_EQUIPO'   => !empty($rowData['I']) ? $rowData['I'] : null,
                                    'ESTADO_EQUIPO'      => !empty($rowData['J']) ? $rowData['J'] : null,
                                    'FECHA_ADQUISICION'  => !empty($rowData['L']) ? $rowData['L'] : null,
                                    'PROVEEDOR_EQUIPO'   => !empty($rowData['M']) ? $rowData['M'] : null,
                                    'UNITARIO_EQUIPO'    => !empty($rowData['N']) ? $rowData['N'] : null,
                                    'TOTAL_EQUIPO'       => !empty($rowData['O']) ? $rowData['O'] : null,
                                    'TIPO_EQUIPO'        => !empty($rowData['P']) ? $rowData['P'] : null,
                                    'OBSERVACION_EQUIPO' => !empty($rowData['Q']) ? $rowData['Q'] : null,
                                    'FOTO_EQUIPO'        => null
                                ]);

                                if (isset($imagenesMap[$filaExcel])) {
                                    $imagen = $imagenesMap[$filaExcel];
                                    $filename = 'foto_equipo.' . $imagen['extension'];
                                    $pathFinal = 'Almacén/Inventario/' . $nuevoEquipo->ID_FORMULARIO_INVENTARIO . '/' . $filename;

                                    Storage::put($pathFinal, $imagen['contents']);

                                    $nuevoEquipo->update([
                                        'FOTO_EQUIPO' => $pathFinal
                                    ]);
                                } else {
                                    $nuevoEquipo->update([
                                        'FOTO_EQUIPO' => null
                                    ]);
                                }

                                $equipoInsertados++;
                                $filaExcel++;
                            }

                            return response()->json([
                                'msj'  => 'Total de equipos agregados: ' . $equipoInsertados . ' de ' . $totalEquipos,
                                'code' => 200
                            ]);
                        } else {
                            return response()->json(["msj" => 'No se ha subido ningún archivo', "code" => 500]);
                        }
                    } catch (Exception $e) {
                        return response()->json([
                            'msj'  => 'Se produjo un error al intentar cargar los equipos: ' . $e->getMessage(),
                            'code' => 500
                        ]);
                    }




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
