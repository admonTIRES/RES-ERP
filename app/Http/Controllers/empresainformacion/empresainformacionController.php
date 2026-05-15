<?php

namespace App\Http\Controllers\empresainformacion;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

use DB;


use App\Models\empresainformacion\empresainformacionModel;




class empresainformacionController extends Controller
{


    public function Tablainformacionempresa()
    {
        try {

            $tabla = empresainformacionModel::get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {

                    $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR" ><i class="bi bi-eye"></i></button>';
                
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_EMPRESA . '"><span class="slider round"></span></label>';
                } else {

                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                  
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_EMPRESA . '" checked><span class="slider round"></span></label>';
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

                    if ($request->ID_FORMULARIO_EMPRESA == 0) {
                        DB::statement('ALTER TABLE formularioempresa AUTO_INCREMENT=1;');

                        $data = $request->except(['contactos', 'direcciones','sucursales']);
                        $data['CONTACTOS_JSON'] = is_string($request->CONTACTOS_JSON) ? $request->CONTACTOS_JSON : json_encode($request->CONTACTOS_JSON ?? []);
                        $data['DIRECCIONES_JSON'] = is_string($request->DIRECCIONES_JSON) ? $request->DIRECCIONES_JSON : json_encode($request->DIRECCIONES_JSON ?? []);
                        $data['SUCURSALES_JSON'] = is_string($request->SUCURSALES_JSON) ? $request->SUCURSALES_JSON : json_encode($request->SUCURSALES_JSON ?? []);




                        $cliente = empresainformacionModel::create($data);

                        
                        $response['code'] = 1;
                        $response['cliente'] = $cliente;
                        return response()->json($response);
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                empresainformacionModel::where('ID_FORMULARIO_EMPRESA', $request->ID_FORMULARIO_EMPRESA)
                                    ->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['cliente'] = 'Desactivada';
                            } else {
                                empresainformacionModel::where('ID_FORMULARIO_EMPRESA', $request->ID_FORMULARIO_EMPRESA)
                                    ->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['cliente'] = 'Activada';
                            }
                        } else {
                            $cliente = empresainformacionModel::find($request->ID_FORMULARIO_EMPRESA);

                            $data = $request->except(['contactos', 'direcciones', 'sucursales']);
                            $data['CONTACTOS_JSON'] = is_string($request->CONTACTOS_JSON) ? $request->CONTACTOS_JSON : json_encode($request->CONTACTOS_JSON ?? []);
                            $data['DIRECCIONES_JSON'] = is_string($request->DIRECCIONES_JSON) ? $request->DIRECCIONES_JSON : json_encode($request->DIRECCIONES_JSON ?? []);
                            $data['SUCURSALES_JSON'] = is_string($request->SUCURSALES_JSON) ? $request->SUCURSALES_JSON : json_encode($request->SUCURSALES_JSON ?? []);


                            $cliente->update($data);

                       

                            $response['code'] = 1;
                            $response['cliente'] = 'Actualizada';
                        }

                        return response()->json($response);
                    }

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
