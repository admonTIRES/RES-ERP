<?php

namespace App\Http\Controllers\organizacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use App\Models\organizacion\catalogofuncionescargoModel;

use DB;

class catalogosfuncionescargoController extends Controller
{
    public function index()
    {
        $areas = DB::select("SELECT ID_CATALOGO_CATEGORIA  AS ID, NOMBRE_CATEGORIA AS NOMBRE
        FROM catalogo_categorias
        WHERE ACTIVO = 1");

        return view('RH.Catalogos.catalogo_funcionescargo', compact('areas'));
    }

    public function Tablaafuncionescargo()
    {
        try {
            $tabla = DB::select('SELECT fun.*, IFNULL(cat.NOMBRE_CATEGORIA, "No aplica") as NOMBRE_CATEGORIA
                                FROM catalogo_funcionescargos fun
                                LEFT JOIN catalogo_categorias cat ON cat.ID_CATALOGO_CATEGORIA = fun.CATEGORIAS_CARGO');
    
            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {

                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_CATALOGO_FUNCIONESCARGO . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_CATALOGO_FUNCIONESCARGO . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }
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


    public function store(Request $request)
    {

        try {
            switch (intval($request->api)) {
                case 1:

                    
                    if ($request->ID_CATALOGO_FUNCIONESCARGO == 0) {

                        DB::statement('ALTER TABLE catalogo_funcionescargos AUTO_INCREMENT=1;');
                        $cargos = catalogofuncionescargoModel::create($request->all());
                    } else { 

                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $cargos = catalogofuncionescargoModel::where('ID_CATALOGO_FUNCIONESCARGO', $request['ID_CATALOGO_FUNCIONESCARGO'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['cargo'] = 'Desactivada';
                            } else {
                                $cargos = catalogofuncionescargoModel::where('ID_CATALOGO_FUNCIONESCARGO', $request['ID_CATALOGO_FUNCIONESCARGO'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['cargo'] = 'Activada';
                            }
                        } else {
                            $cargos = catalogofuncionescargoModel::find($request->ID_CATALOGO_FUNCIONESCARGO);
                            $cargos->update($request->all());
                            $response['code'] = 1;
                            $response['cargo'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }

                    $response['code']  = 1;
                    $response['cargo']  = $cargos;
                    return response()->json($response);

                    break;

                default:

                    $response['code']  = 1;
                    $response['msj']  = 'Api no encontrada';
                    return response()->json($response);
            }
        } catch (Exception $e) {

            return response()->json('Error al guardar las funciones');
        }
    }

}
