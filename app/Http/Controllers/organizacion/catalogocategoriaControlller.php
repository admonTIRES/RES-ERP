<?php

namespace App\Http\Controllers\organizacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use App\Models\organizacion\catalogocategoriaModel;
use App\Models\selección\catalogopruebasconocimientosModel;
use App\Models\organizacion\requerimientoscategoriasModel;

use DB;







class catalogocategoriaControlller extends Controller
{


 public function index()
{
    $pruebas = catalogopruebasconocimientosModel::orderBy('NOMBRE_PRUEBA', 'ASC')->get();
    return view('RH.Catalogos.catalogo_categorias', compact('pruebas'));
}




    public function Tablacategoria()
    {
        try {
            $tabla = catalogocategoriaModel::get();


           foreach ($tabla as $value) {

            $value->REQUERIMIENTO = requerimientoscategoriasModel::where('CATALOGO_CATEGORIAS_ID', $value->ID_CATALOGO_CATEGORIA)->get();


            if ($value->ACTIVO == 0) {
                $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_CATALOGO_CATEGORIA . '"><span class="slider round"></span></label>';
                $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
            } else {
                $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_CATALOGO_CATEGORIA . '" checked><span class="slider round"></span></label>';
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
                DB::beginTransaction();

                if ($request->ID_CATALOGO_CATEGORIA == 0) {
                    DB::statement('ALTER TABLE catalogo_categorias AUTO_INCREMENT=1;');
                    $categorias = catalogocategoriaModel::create($request->all());
                } else {

                    if (isset($request->ELIMINAR)) {
                        if ($request->ELIMINAR == 1) {
                            $categorias = catalogocategoriaModel::where('ID_CATALOGO_CATEGORIA', $request['ID_CATALOGO_CATEGORIA'])->update(['ACTIVO' => 0]);
                            $response['code'] = 1;
                            $response['categoria'] = 'Desactivada';
                        } else {
                            $categorias = catalogocategoriaModel::where('ID_CATALOGO_CATEGORIA', $request['ID_CATALOGO_CATEGORIA'])->update(['ACTIVO' => 1]);
                            $response['code'] = 1;
                            $response['categoria'] = 'Activada';
                        }
                        DB::commit();
                        return response()->json($response);
                    } else {
                        $categorias = catalogocategoriaModel::find($request->ID_CATALOGO_CATEGORIA);
                        $categorias->update($request->all());

                        requerimientoscategoriasModel::where('CATALOGO_CATEGORIAS_ID', $request->ID_CATALOGO_CATEGORIA)->delete();
                    }
                }

                if ($request->has('TIPO_PRUEBA')) {
                    foreach ($request->TIPO_PRUEBA as $index => $requerimiento) {
                        requerimientoscategoriasModel::create([
                            'CATALOGO_CATEGORIAS_ID' => $categorias->ID_CATALOGO_CATEGORIA,
                            'TIPO_PRUEBA' => $requerimiento,
                            'PORCENTAJE' => $request->PORCENTAJE[$index]
                        ]);
                    }
                }

                $response['code'] = 1;
                $response['categoria'] = $categorias;
                DB::commit();
                return response()->json($response);
                break;

            default:
                $response['code'] = 1;
                $response['msj'] = 'Api no encontrada';
                return response()->json($response);
        }
    } catch (Exception $e) {
        DB::rollBack();
        return response()->json('Error al guardar la nueva categoría');
    }
}



}
