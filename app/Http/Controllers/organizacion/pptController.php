<?php

namespace App\Http\Controllers\organizacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use App\Models\organizacion\cursospptModel;
use App\Models\organizacion\formulariopptModel;
use App\Models\organizacion\departamentosAreasModel;
use App\Models\organizacion\catalogoexperienciaModel;


use DB;

class pptController extends Controller
{
    public function index()
    {
        $areas = DB::select("
        SELECT ID_CATALOGO_CATEGORIA  AS ID, NOMBRE_CATEGORIA AS NOMBRE, LUGAR_CATEGORIA AS LUGAR, PROPOSITO_CATEGORIA AS PROPOSITO, ES_LIDER_CATEGORIA AS LIDER
        FROM catalogo_categorias
        WHERE ACTIVO = 1
        ");


        $puesto = catalogoexperienciaModel::orderBy('NOMBRE_PUESTO', 'ASC')->get();


        return view('RH.organizacion.PPT', compact('areas','puesto'));
    }

    public function TablaPPT()
    {
        try {

            $tabla = DB::select('SELECT ppt.*, cat.NOMBRE_CATEGORIA
                                                FROM formulario_ppt ppt
                                                LEFT JOIN catalogo_categorias cat ON cat.ID_CATALOGO_CATEGORIA = ppt.DEPARTAMENTO_AREA_ID');


            foreach ($tabla as $key => $value) {

                $cursos = cursospptModel::where('FORMULARIO_PPT_ID', $value->ID_FORMULARIO_PPT)->get();
                $value->CURSOS = $cursos;


                $value->ELABORADO_POR =  $value->ELABORADO_NOMBRE_PPT . '<br>' . $value->ELABORADO_FECHA_PPT;
                $value->REVISADO_POR = is_null($value->REVISADO_NOMBRE_PPT) ? '<span class="badge text-bg-warning">Sin revisar</span>' : $value->REVISADO_NOMBRE_PPT . '<br>' . $value->REVISADO_FECHA_PPT;
                $value->AUTORIZADO_POR = is_null($value->AUTORIZADO_NOMBRE_PPT) ? '<span class="badge text-bg-danger">Sin autorizar</span>' : $value->AUTORIZADO_NOMBRE_PPT . '<br>' . $value->AUTORIZADO_FECHA_PPT;



                // ## CREADO Y AUN NO ESTA REVISADO NI AUTORIZADO
                // if (!is_null($value->ELABORADO_NOMBRE_PPT) && is_null($value->REVISADO_NOMBRE_PPT) && is_null($value->AUTORIZADO_NOMBRE_PPT)) {

                //     $value->BTN_ELIMINAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill ELIMINAR"><i class="bi bi-power"></i></button>';
                //     $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                //     $value->BTN_PPT = '<button type="button" class="btn btn-success btn-custom rounded-pill PPT"><i class="bi bi-file-earmark-excel-fill"></i></button>';
    
                //     ##CREADO Y REVISADO PERO NO AUTORIZADO
                // } else if (!is_null($value->ELABORADO_NOMBRE_PPT) && !is_null($value->REVISADO_NOMBRE_PPT) && is_null($value->AUTORIZADO_NOMBRE_PPT)) {

                //     $value->BTN_ELIMINAR = '<button type="button" class="btn btn-secondary btn-circle"><i class="bi bi-ban"></i></button>';
                //     $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-circle "><i class="bi bi-ban"></i></button>';
                //     $value->BTN_PPT = '<button type="button" class="btn btn-secondary btn-circle "><i class="bi bi-ban"></i></button>';

                //     ## CREADO, REVISADO Y AUTORIZADO
                // } else if (!is_null($value->ELABORADO_NOMBRE_PPT) && !is_null($value->REVISADO_NOMBRE_PPT) && !is_null($value->AUTORIZADO_NOMBRE_PPT)) {

                //     $value->BTN_ELIMINAR = '<button type="button" class="btn btn-secondary btn-circle "><i class="bi bi-ban"></i></button>';
                //     $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-circle"><i class="bi bi-ban"></i></button>';
                //     $value->BTN_PPT = '<button type="button" class="btn btn-success btn-circle PPT"><i class="bi bi-file-earmark-excel-fill"></i></button>';
                //     $value->BTN_ACCION = '<button type="button" class="btn btn-success btn-circle " data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Finalizado PPT" title="Finalizado"><i class="bi bi-check-circle-fill"></i></button>';
                // }




                if ($value->ACTIVO == 0) {
                    $value->BTN_PPT = '<button type="button" class="btn btn-success btn-custom rounded-pill DPT"disabled><i class="bi bi-ban"></i></button>';   
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_PPT . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
    
    
                } else {
    
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_PPT . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_PPT = '<button type="button" class="btn btn-success btn-custom rounded-pill DPT"><i class="bi bi-file-earmark-excel-fill"></i></button>';
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


    public function revisarPPT($id_formulario)
    {

        $fecha_actual = date('Y-m-d');

        $PPT = formulariopptModel::find($id_formulario);
        $PPT->REVISADO_NOMBRE_PPT = 'Usuario anónimo';
        $PPT->REVISADO_FIRMA_PPT = 'USER';
        $PPT->REVISADO_FECHA_PPT = $fecha_actual;

        $PPT->save();

        $response['code']  = 1;
        $response['PPT']  = 'Revisado';
        return response()->json($response);
    }


    public function autorizarPPT($id_formulario)
    {

        $fecha_actual = date('Y-m-d');

        $PPT = formulariopptModel::find($id_formulario);
        $PPT->AUTORIZADO_NOMBRE_PPT = 'Usuario anónimo';
        $PPT->AUTORIZADO_FIRMA_PPT = 'USER';
        $PPT->AUTORIZADO_FECHA_PPT = $fecha_actual;

        $PPT->save();

        $response['code']  = 1;
        $response['PPT']  = 'Autorizado';
        return response()->json($response);
    }



public function store(Request $request)
{

    try {
        switch (intval($request->api)) {
            case 1:

                if (isset($request->ELIMINAR)) {
                    if ($request->ELIMINAR == 1) {
                        $PPT = formulariopptModel::where('ID_FORMULARIO_PPT', $request['ID_FORMULARIO_PPT'])->update(['ACTIVO' => 0]);
                        $response['code'] = 1;
                        $response['PPT'] = 'Desactivado';
                    } else {
                        $PPT = formulariopptModel::where('ID_FORMULARIO_PPT', $request['ID_FORMULARIO_PPT'])->update(['ACTIVO' => 1]);
                        $response['code'] = 1;
                        $response['PPT'] = 'Activado';
                    }
                    return response()->json($response);
                } 



                if ($request->ID_FORMULARIO_PPT == 0) {

                    DB::statement('ALTER TABLE formulario_ppt AUTO_INCREMENT=1;');
                    $PPT = formulariopptModel::create($request->all());




                    if ($request->CURSO_PPT) {
                        foreach ($request->CURSO_PPT as $key => $value) {

                            $num = $key + 1;

                            if ((!empty($request->CURSO_PPT[$key]))) {

                                $guardar_curso = cursospptModel::create([
                                    'FORMULARIO_PPT_ID' => $PPT->ID_FORMULARIO_PPT,
                                    'CURSO_PPT' => $value,
                                    'CURSO_REQUERIDO' => isset($request->CURSO_REQUERIDO_PPT[$num]) ? $request->CURSO_REQUERIDO_PPT[$num] : null,
                                    'CURSO_DESEABLE' => isset($request->CURSO_DESEABLE_PPT[$num]) ? $request->CURSO_DESEABLE_PPT[$num] : null,
                                    'PORCENTAJE_CURSO' => isset($request->PORCENTAJE_CURSO[$num]) ? $request->PORCENTAJE_CURSO[$num] : null,
                                    ]);
                            }
                        }
                    }

                    $response['code']  = 1;
                    $response['PPT']  = $PPT;
                    return response()->json($response);
                } else { 



                    $eliminar_ppt = formulariopptModel::where('ID_FORMULARIO_PPT', $request->ID_FORMULARIO_PPT)->delete();

                    $PPT = formulariopptModel::create($request->all());

                    $eliminar_cursos = cursospptModel::where('FORMULARIO_PPT_ID', $request["ID_FORMULARIO_PPT"])->delete();


                    if ($request->CURSO_PPT) {
                        foreach ($request->CURSO_PPT as $key => $value) {

                            $num = $key + 1;

                            if ((!empty($request->CURSO_PPT[$key]))) {

                                $guardar_curso = cursospptModel::create([
                                    'FORMULARIO_PPT_ID' => $PPT->ID_FORMULARIO_PPT,
                                    'CURSO_PPT' => $value,
                                    'CURSO_REQUERIDO' => isset($request->CURSO_REQUERIDO_PPT[$num]) ? $request->CURSO_REQUERIDO_PPT[$num] : null,
                                    'CURSO_DESEABLE' => isset($request->CURSO_DESEABLE_PPT[$num]) ? $request->CURSO_DESEABLE_PPT[$num] : null,
                                    'PORCENTAJE_CURSO' => isset($request->PORCENTAJE_CURSO[$num]) ? $request->PORCENTAJE_CURSO[$num] : null,
                                    ]);
                            }
                        }
                    }

                    $response['code']  = 1;
                    $response['PPT']  = $PPT;
                    return response()->json($response);
                }

                break;

                

            default:

                $response['code']  = 2;
                return response()->json($response);
        }
    } catch (Exception $e) {

        return response()->json('Error al guardar el Area');
    }
}




// public function store(Request $request)
// {
//     try {
//         switch (intval($request->api)) {
//             case 1:
//                 // Lógica para activar o desactivar
//                 if (isset($request->ELIMINAR)) {
//                     if ($request->ELIMINAR == 1) {
//                         // Desactivar el registro
//                         $ppt = formulariopptModel::where('ID_FORMULARIO_PPT', $request['ID_FORMULARIO_PPT'])->update(['ACTIVO' => 0]);
//                         $response['code'] = 1;
//                         $response['PPT'] = 'Desactivado';
//                     } else {
//                         // Activar el registro
//                         $ppt = formulariopptModel::where('ID_FORMULARIO_PPT', $request['ID_FORMULARIO_PPT'])->update(['ACTIVO' => 1]);
//                         $response['code'] = 1;
//                         $response['PPT'] = 'Activado';
//                     }
//                     return response()->json($response);
//                 }

//                 // Guardar o actualizar el formulario PPT
//                 if ($request->ID_FORMULARIO_PPT == 0) {
//                     // Crear un nuevo registro en formulario_ppt
//                     DB::statement('ALTER TABLE formulario_ppt AUTO_INCREMENT=1;');
//                     $PPT = formulariopptModel::create($request->all());

//                     // Guardar los cursos
//                     if ($request->CURSO_PPT) {
//                         foreach ($request->CURSO_PPT as $key => $value) {
//                             $num = $key + 1;
//                             if (!empty($request->CURSO_PPT[$key])) {
//                                 cursospptModel::create([
//                                     'FORMULARIO_PPT_ID' => $PPT->ID_FORMULARIO_PPT,
//                                     'CURSO_PPT' => $value,
//                                     'CURSO_REQUERIDO' => $request->CURSO_REQUERIDO_PPT[$num] ?? null,
//                                     'CURSO_DESEABLE' => $request->CURSO_DESEABLE_PPT[$num] ?? null,
//                                 ]);
//                             }
//                         }
//                     }

//                     $response['code'] = 1;
//                     $response['PPT'] = $PPT;
//                     return response()->json($response);

//                 } else {
//                     // Editar el formulario PPT
//                     // Eliminar el registro anterior de PPT
//                     $eliminar_ppt = formulariopptModel::where('ID_FORMULARIO_PPT', $request->ID_FORMULARIO_PPT)->delete();

//                     // Crear un nuevo registro de PPT
//                     $PPT = formulariopptModel::create($request->all());

//                     // Eliminar los cursos anteriores
//                     $eliminar_cursos = cursospptModel::where('FORMULARIO_PPT_ID', $request["ID_FORMULARIO_PPT"])->delete();

//                     // Guardar los cursos nuevos
//                     if ($request->CURSO_PPT) {
//                         foreach ($request->CURSO_PPT as $key => $value) {
//                             $num = $key + 1;
//                             if (!empty($request->CURSO_PPT[$key])) {
//                                 cursospptModel::create([
//                                     'FORMULARIO_PPT_ID' => $PPT->ID_FORMULARIO_PPT,
//                                     'CURSO_PPT' => $value,
//                                     'CURSO_REQUERIDO' => $request->CURSO_REQUERIDO_PPT[$num] ?? null,
//                                     'CURSO_DESEABLE' => $request->CURSO_DESEABLE_PPT[$num] ?? null,
//                                 ]);
//                             }
//                         }
//                     }

//                     $response['code'] = 1;
//                     $response['PPT'] = $PPT;
//                     return response()->json($response);
//                 }

//                 break;

//             default:
//                 $response['code'] = 2;
//                 return response()->json($response);
//         }
//     } catch (Exception $e) {
//         return response()->json(['code' => 0, 'message' => 'Error al guardar el Área', 'error' => $e->getMessage()]);
//     }
// }

}
