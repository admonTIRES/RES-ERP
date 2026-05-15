<?php

namespace App\Http\Controllers\organizacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use App\Models\organizacion\catalogojerarquiaModel;

use DB;


class catalogosController extends Controller
{
    
public function Tablajerarquia()
{
    try {
        $tabla = catalogojerarquiaModel::get();

        foreach ($tabla as $value) {
            if ($value->ACTIVO == 0) {
                $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_CATALOGO_JERARQUIA . '"><span class="slider round"></span></label>';
                $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
            } else {
                $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_CATALOGO_JERARQUIA . '" checked><span class="slider round"></span></label>';
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
                if ($request->ID_CATALOGO_JERARQUIA == 0) {
                    DB::statement('ALTER TABLE catalogo_jerarquias AUTO_INCREMENT=1;');
                    $jerarquias = catalogojerarquiaModel::create($request->all());
                } else {
                    
                    if (isset($request->ELIMINAR)) {
                        if ($request->ELIMINAR == 1) {
                            $jerarquias = catalogojerarquiaModel::where('ID_CATALOGO_JERARQUIA', $request['ID_CATALOGO_JERARQUIA'])->update(['ACTIVO' => 0]);
                            $response['code'] = 1;
                            $response['jerarquia'] = 'Desactivada';
                        } else {
                            $jerarquias = catalogojerarquiaModel::where('ID_CATALOGO_JERARQUIA', $request['ID_CATALOGO_JERARQUIA'])->update(['ACTIVO' => 1]);
                            $response['code'] = 1;
                            $response['jerarquia'] = 'Activada';
                        }
                    } else {
                        $jerarquias = catalogojerarquiaModel::find($request->ID_CATALOGO_JERARQUIA);
                        $jerarquias->update($request->all());
                        $response['code'] = 1;
                        $response['jerarquia'] = 'Actualizada';
                    }
                    return response()->json($response);
                }

                $response['code'] = 1;
                $response['jerarquia'] = $jerarquias;
                return response()->json($response);

            default:
                $response['code'] = 1;
                $response['msj'] = 'Api no encontrada';
                return response()->json($response);
        }
    } catch (Exception $e) {
        return response()->json('Error al guardar la jerarquía: ' . $e->getMessage());
    }
}





}
