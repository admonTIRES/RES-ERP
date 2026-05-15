<?php

namespace App\Http\Controllers\organizacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use App\Models\organizacion\catalogoasesorModel;

use DB;


class catalogosasesoresController extends Controller
{
    

    public function Tablaasesores()
    {
        try {
            $tabla = catalogoasesorModel::get();
    
            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_CATALOGO_ASESOR . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_CATALOGO_ASESOR . '" checked><span class="slider round"></span></label>';
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
                    if ($request->ID_CATALOGO_ASESOR == 0) {
                        DB::statement('ALTER TABLE catalogo_asesores AUTO_INCREMENT=1;');
                        $asesores = catalogoasesorModel::create($request->all());
                    } else { 

                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                             
                                $asesores = catalogoasesorModel::where('ID_CATALOGO_ASESOR', $request['ID_CATALOGO_ASESOR'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['asesor'] = 'Desactivada';
                            } else {
                                $asesores = catalogoasesorModel::where('ID_CATALOGO_ASESOR', $request['ID_CATALOGO_ASESOR'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['asesor'] = 'Activada';
                            }
                        } else {
                            $asesores = catalogoasesorModel::find($request->ID_CATALOGO_ASESOR);
                            $asesores->update($request->all());
                            $response['code'] = 1;
                            $response['asesor'] = 'Actualizada';
                        }
                        return response()->json($response);

                    
                    }
                    $response['code']  = 1;
                    $response['asesor']  = $asesores;
                    return response()->json($response);
                    break;
                default:
                    $response['code']  = 1;
                    $response['msj']  = 'Api no encontrada';
                    return response()->json($response);
            }
        } catch (Exception $e) {
            return response()->json('Error al guardar el asesor');
        }
    }
    
}
