<?php

namespace App\Http\Controllers\solicitudes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

use DB; 

use App\Models\solicitudes\catalogiroempresaModel;


class catalogogiroempresaController extends Controller
{
    public function Tablagiroempresa()
{
    try {
        $tabla = catalogiroempresaModel::get();

        foreach ($tabla as $value) {
            
        

            if ($value->ACTIVO == 0) {
                $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_CATALOGO_GIRO_EMPRESA . '"><span class="slider round"></span></label>';
                $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
            } else {
                $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_CATALOGO_GIRO_EMPRESA . '" checked><span class="slider round"></span></label>';
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
                    if ($request->ID_CATALOGO_GIRO_EMPRESA == 0) {
                        DB::statement('ALTER TABLE catalogo_giroempresa AUTO_INCREMENT=1;');
                        $giros = catalogiroempresaModel::create($request->all());
                    } else { 

                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $giros = catalogiroempresaModel::where('ID_CATALOGO_GIRO_EMPRESA', $request['ID_CATALOGO_GIRO_EMPRESA'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['giro'] = 'Desactivada';
                            } else {
                                $giros = catalogiroempresaModel::where('ID_CATALOGO_GIRO_EMPRESA', $request['ID_CATALOGO_GIRO_EMPRESA'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['giro'] = 'Activada';
                            }
                        } else {
                            $giros = catalogiroempresaModel::find($request->ID_CATALOGO_GIRO_EMPRESA);
                            $giros->update($request->all());
                            $response['code'] = 1;
                            $response['giro'] = 'Actualizada';
                        }
                        return response()->json($response);

                    }
                    $response['code']  = 1;
                    $response['giro']  = $giros;
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
