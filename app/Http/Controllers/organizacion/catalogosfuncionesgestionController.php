<?php

namespace App\Http\Controllers\organizacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use App\Models\organizacion\catalogofuncionesgestionModel;

use DB;

class catalogosfuncionesgestionController extends Controller
{
   

    public function Tablafuncionesgestion()
    {
        try {
            $tabla = catalogofuncionesgestionModel::get();
    
            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_CATALOGO_FUNCIONESGESTION . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_CATALOGO_FUNCIONESGESTION . '" checked><span class="slider round"></span></label>';
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



public function store(Request $request)
{
    try {
        switch (intval($request->api)) {
            case 1:
                $data = $this->prepareCheckboxData($request->all());

                if ($request->ID_CATALOGO_FUNCIONESGESTION == 0) {
                    DB::statement('ALTER TABLE catalogo_funcionesgestiones AUTO_INCREMENT=1;');
                    $gestiones = catalogofuncionesgestionModel::create($data);
                } else {
                    $gestiones = catalogofuncionesgestionModel::find($request->ID_CATALOGO_FUNCIONESGESTION);
                    if ($gestiones) {
                        $gestiones->update($data);
                    }
                    $response['code'] = 1;
                    $response['gestion'] = 'Actualizada';
                    return response()->json($response);
                }
                

                $response['code'] = 1;
                $response['gestion'] = $gestiones;
                return response()->json($response);

            default:
                $response['code'] = 0;
                $response['msj'] = 'Api no encontrada';
                return response()->json($response);
        }
    } catch (Exception $e) {
        return response()->json(['code' => 0, 'error' => 'Error al guardar las funciones']);
    }
}

private function prepareCheckboxData(array $data)
{
    $checkboxes = ['DIRECTOR_GESTION', 'LIDER_GESTION', 'COLABORADOR_GESTION', 'TODO_GESTION'];

    foreach ($checkboxes as $checkbox) {
        $data[$checkbox] = $data[$checkbox] ?? null;
    }

    return $data;
}


}


