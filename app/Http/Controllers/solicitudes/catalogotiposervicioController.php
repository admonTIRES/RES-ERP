<?php

namespace App\Http\Controllers\solicitudes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

use DB;
use App\Models\solicitudes\catalogotiposervicioModel;

class catalogotiposervicioController extends Controller
{
    public function Tablatiposervicio()
    {
        try {
            $tabla = catalogotiposervicioModel::get();

            foreach ($tabla as $value) {



                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_CATALOGO_TIPO_SERVICIO . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_CATALOGO_TIPO_SERVICIO . '" checked><span class="slider round"></span></label>';
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
                    if ($request->ID_CATALOGO_TIPO_SERVICIO == 0) {
                        DB::statement('ALTER TABLE catalogo_tiposervicio AUTO_INCREMENT=1;');
                        $tipos = catalogotiposervicioModel::create($request->all());
                    } else {

                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $tipos = catalogotiposervicioModel::where('ID_CATALOGO_TIPO_SERVICIO', $request['ID_CATALOGO_TIPO_SERVICIO'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['tipo'] = 'Desactivada';
                            } else {
                                $tipos = catalogotiposervicioModel::where('ID_CATALOGO_TIPO_SERVICIO', $request['ID_CATALOGO_TIPO_SERVICIO'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['tipo'] = 'Activada';
                            }
                        } else {
                            $tipos = catalogotiposervicioModel::find($request->ID_CATALOGO_TIPO_SERVICIO);
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
            return response()->json('Error al guardar');
        }
    }

}
