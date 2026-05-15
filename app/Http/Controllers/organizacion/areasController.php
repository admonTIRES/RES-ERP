<?php

namespace App\Http\Controllers\organizacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Illuminate\Support\Facades\Storage;
use Exception;
use App\Models\organizacion\areasModel;
use App\Models\organizacion\departamentosAreasModel;
use App\Models\organizacion\encargadosAreasModel;
use App\Models\organizacion\catalogocategoriaModel;
use App\Models\organizacion\areasLideresModel;
use App\Models\organizacion\lideresCategoriasModel;



use DB;



class areasController extends Controller
{

    public function index()
    {

        $categorias = catalogocategoriaModel::where('ACTIVO', 1)->get();
        $lideres = catalogocategoriaModel::where('ACTIVO', 1)->where('ES_LIDER_CATEGORIA', 1)->get();

        return view('RH.organizacion.organigrama', compact('categorias', 'lideres'));
    }


    public function TablaAreas()
    {
        try {

            $tabla = DB::select("CALL sp_obtener_organigrama_areas_b()");



            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_AREA . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                    $value->BTN_ORGANIGRAMA = '<button type="button" class="btn btn-success btn-custom ORGANIGRAMA rounded-pill"><i class="bi bi-diagram-3-fill"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-pdf" data-id="' . $value->ID_AREA . '" title="Ver documento"> <i class="bi bi-filetype-pdf"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_AREA . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ORGANIGRAMA = '<button type="button" class="btn btn-success btn-custom ORGANIGRAMA rounded-pill"><i class="bi bi-diagram-3-fill"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-pdf" data-id="' . $value->ID_AREA . '" title="Ver documento"> <i class="bi bi-filetype-pdf"></i></button>';
                }
            }




            $dato['data'] = $tabla;
            $dato["msj"] = 'Información consultada correctamente';
            return response()->json($dato);
        } catch (Exception $e) {

            $dato["msj"] = 'Error ' . $e->getMessage();
            $dato['data'] = 0;
            return response()->json($dato);
        }
    }

    public function mostrararchivo($id)
    {
        $archivo = areasModel::findOrFail($id)->DOCUMENTO_ORGANIGRAMA;
        return Storage::response($archivo);
    }


    public function TablaEncargados($area_id)
    {
        try {

            $tabla = DB::select('

                        SELECT 
                            cat.NOMBRE_CATEGORIA AS NOMBRE,
                            1 AS LIDER,
                            lideres.ID_AREA_LIDER AS ID_REGISTRO,
                            "areas_lideres" AS TIPO,
                            lideres.ACTIVO
                        FROM areas_lideres lideres
                        LEFT JOIN catalogo_categorias cat 
                            ON cat.ID_CATALOGO_CATEGORIA = lideres.LIDER_ID
                        WHERE lideres.AREA_ID = ?

                        UNION ALL

                        SELECT 
                            cat.NOMBRE_CATEGORIA AS NOMBRE,
                            0 AS LIDER,
                            lideres_cat.ID_LIDER_CATEGORIAS AS ID_REGISTRO,
                            "lideres_categorias" AS TIPO,
                            lideres_cat.ACTIVO
                        FROM lideres_categorias lideres_cat
                        LEFT JOIN catalogo_categorias cat 
                            ON cat.ID_CATALOGO_CATEGORIA = lideres_cat.CATEGORIA_ID
                        WHERE lideres_cat.AREA_ID = ?
                    ', [$area_id, $area_id]);

                        $COUNT = 1;

            foreach ($tabla as $value) {

                $value->COUNT = $COUNT++;

                if ($value->LIDER == 1) {
                    $value->ES_LIDER = '<span class="badge rounded-pill text-bg-success"><i class="bi bi-check-lg"></i></span>';
                } else {
                    $value->ES_LIDER = '<span class="badge rounded-pill text-bg-danger"><i class="bi bi-x-lg"></i></span>';
                }

                if ($value->ACTIVO == 1) {
                    $value->BTN_ACTIVO =
                        '<label class="switch">
                        <input type="checkbox"
                               class="ACTIVAR"
                               data-id="' . $value->ID_REGISTRO . '"
                               data-tipo="' . $value->TIPO . '"
                               checked>
                        <span class="slider round"></span>
                    </label>';
                } else {
                    $value->BTN_ACTIVO =
                        '<label class="switch">
                        <input type="checkbox"
                               class="ACTIVAR"
                               data-id="' . $value->ID_REGISTRO . '"
                               data-tipo="' . $value->TIPO . '">
                        <span class="slider round"></span>
                    </label>';
                }
            }

            return response()->json([
                'data' => $tabla,
                'msj'  => 'Información consultada correctamente'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'data' => [],
                'msj'  => 'Error: ' . $e->getMessage()
            ]);
        }
    }



    public function activarEncargado(Request $request)
    {
        try {

            $id     = (int) $request->id;
            $tipo   = $request->tipo;
            $activo = $request->activo == 1 ? "b'1'" : "b'0'";

            if (!$id || !$tipo) {
                return response()->json([
                    'ok' => false,
                    'msj' => 'Datos incompletos'
                ], 400);
            }

            if ($tipo === 'areas_lideres') {

                DB::table('areas_lideres')
                    ->where('ID_AREA_LIDER', $id)
                    ->update([
                        'ACTIVO' => DB::raw($activo),
                        'updated_at' => now()
                    ]);
            } elseif ($tipo === 'lideres_categorias') {

                DB::table('lideres_categorias')
                    ->where('ID_LIDER_CATEGORIAS', $id)
                    ->update([
                        'ACTIVO' => DB::raw($activo),
                        'updated_at' => now()
                    ]);
            } else {
                return response()->json([
                    'ok' => false,
                    'msj' => 'Tipo inválido'
                ], 400);
            }

            return response()->json([
                'ok' => true,
                'msj' => 'Estado actualizado correctamente'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'ok' => false,
                'msj' => $e->getMessage()
            ], 500);
        }
    }




    public function getDataOrganigrama($area_id, $esGeneral)
    {
        try {

            $resultados = DB::select('CALL sp_obtener_json_organigrama_b(?, ?)', [$area_id, $esGeneral]);

            $arreglo_json = [];
            foreach ($resultados as $resultado) {

                $json = json_decode($resultado->JSON_DIRECCION, true);

                $arreglo_json[] = $json;
            }



            $response['code']  = 1;
            $response['data']  = json_encode($arreglo_json);
            return response()->json($response);
        } catch (Exception  $e) {

            return response()->json('Error al ejecutar el Procedure');
        }
    }


   




    public function store(Request $request)
    {

        try {
            switch (intval($request->api)) {



                case 1:
                    // Guardamos Área y documento
                    if ($request->ID_AREA == 0
                    ) {
                        DB::statement('ALTER TABLE areas AUTO_INCREMENT=1;');

                        $areas = areasModel::create($request->except(['DOCUMENTO_ORGANIGRAMA', 'FOTO_ORGANIGRAMA']));

                        if ($request->hasFile('DOCUMENTO_ORGANIGRAMA')) {
                            $documento = $request->file('DOCUMENTO_ORGANIGRAMA');
                            $nombreArchivo = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $request->NOMBRE) . '.' . $documento->getClientOriginalExtension();
                            $rutaCarpeta = 'Documentos organigrama/' . $areas->ID_AREA . '/Documento de soporte';
                            $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);

                            $areas->DOCUMENTO_ORGANIGRAMA = $rutaCompleta;
                            $areas->save();
                        }

                        if ($request->hasFile('FOTO_ORGANIGRAMA')) {
                            $foto = $request->file('FOTO_ORGANIGRAMA');
                            $nombreFoto = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $request->NOMBRE) . '.' . $foto->getClientOriginalExtension();
                            $rutaCarpeta = 'Documentos organigrama/' . $areas->ID_AREA . '/Foto organigrama';
                            $rutaCompleta = $foto->storeAs($rutaCarpeta, $nombreFoto);

                            $areas->FOTO_ORGANIGRAMA = $rutaCompleta;
                            $areas->save();
                        }
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $areas = areasModel::where('ID_AREA', $request['ID_AREA'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['area'] = 'Desactivada';
                            } else {
                                $areas = areasModel::where('ID_AREA', $request['ID_AREA'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['area'] = 'Activada';
                            }
                        } else {
                            $areas = areasModel::find($request->ID_AREA);
                            $areas->update($request->except(['DOCUMENTO_ORGANIGRAMA', 'FOTO_ORGANIGRAMA']));

                            if ($request->hasFile('DOCUMENTO_ORGANIGRAMA')) {
                                if ($areas->DOCUMENTO_ORGANIGRAMA && Storage::exists($areas->DOCUMENTO_ORGANIGRAMA)) {
                                    Storage::delete($areas->DOCUMENTO_ORGANIGRAMA);
                                }

                                $documento = $request->file('DOCUMENTO_ORGANIGRAMA');
                                $nombreArchivo = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $request->NOMBRE) . '.' . $documento->getClientOriginalExtension();
                                $rutaCarpeta = 'Documentos organigrama/' . $areas->ID_AREA . '/Documento de soporte';
                                $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);

                                $areas->DOCUMENTO_ORGANIGRAMA = $rutaCompleta;
                                $areas->save();
                            }

                            if ($request->hasFile('FOTO_ORGANIGRAMA')) {
                                if ($areas->FOTO_ORGANIGRAMA && Storage::exists($areas->FOTO_ORGANIGRAMA)) {
                                    Storage::delete($areas->FOTO_ORGANIGRAMA);
                                }

                                $foto = $request->file('FOTO_ORGANIGRAMA');
                                $nombreFoto = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $request->NOMBRE) . '.' . $foto->getClientOriginalExtension();
                                $rutaCarpeta = 'Documentos organigrama/' . $areas->ID_AREA . '/Foto organigrama';
                                $rutaCompleta = $foto->storeAs($rutaCarpeta, $nombreFoto);

                                $areas->FOTO_ORGANIGRAMA = $rutaCompleta;
                                $areas->save();
                            }

                            $response['code'] = 1;
                            $response['area'] = 'Actualizada';
                        }
                    }

                    $response['code'] = 1;
                    $response['area'] = $areas;
                    return response()->json($response);
                    break;

                
                    


                    //GUARDAR CATEGORIAS
                case 2:
                    if ($request->NUEVO == 1) {

                        if ($request->ES_LIDER == 1) {

                            DB::statement('ALTER TABLE areas_lideres AUTO_INCREMENT=1;');
                            $request['AREA_ID'] = $request->AREA_ID;
                            $request['LIDER_ID'] = $request->CATEGORIA;

                            $categoria = areasLideresModel::create($request->all());

                            $response['code']  = 1;
                            $response['categoria']  = $categoria;
                            return response()->json($response);
                        } else {

                            DB::statement('ALTER TABLE lideres_categorias AUTO_INCREMENT=1;');
                            $request['AREA_ID'] = $request->AREA_ID;
                            $request['CATEGORIA_ID'] = $request->CATEGORIA;
                            $request['LIDER_ID'] = $request->LIDER;


                            $categoria = lideresCategoriasModel::create($request->all());

                            $response['code']  = 1;
                            $response['categoria']  = $categoria;
                            return response()->json($response);
                        }
                    } else { 

                        $encargados = encargadosAreasModel::where('ID_ENCARGADO_AREA', $request['ID_ENCARGADO_AREA'])->delete();

                        $response['code']  = 1;
                        $response['encargado']  = 'Eliminado';
                        return response()->json($response);
                    }



                    break;
                default:

                    $response['code']  = 2;
                    $response['msj']  = 'Api no encontrada';
                    return response()->json($response);
            }
        } catch (Exception $e) {

            return response()->json('Error al guardar el Area');
        }
    }




    public function mostrarFoto($area_id)
    {
        $foto = areasModel::findOrFail($area_id);
        return Storage::response($foto->FOTO_ORGANIGRAMA);
    }


    
}
