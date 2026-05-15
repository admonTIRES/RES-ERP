<?php

namespace App\Http\Controllers\inventario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use App\Models\inventario\catalogotipoinventarioModel;

use DB;


class catalogotipoinventarioController extends Controller
{

    public function Tablatipoinventario()
    {
        try {
            $tabla = catalogotipoinventarioModel::get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_CATALOGO_TIPOINVENTARIO . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_CATALOGO_TIPOINVENTARIO . '" checked><span class="slider round"></span></label>';
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
                    if ($request->ID_CATALOGO_TIPOINVENTARIO == 0) {
                        DB::statement('ALTER TABLE catalogo_tipoinventario AUTO_INCREMENT=1;');
                        $tipos = catalogotipoinventarioModel::create($request->all());
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $tipos = catalogotipoinventarioModel::where('ID_CATALOGO_TIPOINVENTARIO', $request['ID_CATALOGO_TIPOINVENTARIO'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['tipo'] = 'Desactivada';
                            } else {
                                $tipos = catalogotipoinventarioModel::where('ID_CATALOGO_TIPOINVENTARIO', $request['ID_CATALOGO_TIPOINVENTARIO'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['tipo'] = 'Activada';
                            }
                        } else {
                            $tipos = catalogotipoinventarioModel::find($request->ID_CATALOGO_TIPOINVENTARIO);
                            $tipos->update($request->all());
                            $response['code'] = 1;
                            $response['tipo'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['tipo']  = $tipos;
                    return response()->json($response);
                    break;
                default:
                    $response['code']  = 1;
                    $response['msj']  = 'Api no encontrada';
                    return response()->json($response);
            }
        } catch (Exception $e) {
            return response()->json('Error al guardar ');
        }
    }
}
