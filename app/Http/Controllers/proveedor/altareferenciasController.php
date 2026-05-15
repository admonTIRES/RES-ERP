<?php

namespace App\Http\Controllers\proveedor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

use DB;

use App\Models\proveedor\altareferenciasModel;



class altareferenciasController extends Controller
{
    
    public function Tablareferenciasproveedor()
    {
        try {
            $userRFC = Auth::user()->RFC_PROVEEDOR;

            $tabla = altareferenciasModel::where('RFC_PROVEEDOR', $userRFC)->get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_REFERENCIASPROVEEDOR . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_REFERENCIASPROVEEDOR . '" checked><span class="slider round"></span></label>';
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
                    if ($request->ID_FORMULARIO_REFERENCIASPROVEEDOR == 0) {
                        DB::statement('ALTER TABLE formulario_altareferenciasproveedor AUTO_INCREMENT=1;');

                        $requestData = $request->all();
                        $requestData['RFC_PROVEEDOR'] = Auth::user()->RFC_PROVEEDOR;

                        $cuentas = altareferenciasModel::create($requestData);
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $cuentas = altareferenciasModel::where('ID_FORMULARIO_REFERENCIASPROVEEDOR', $request['ID_FORMULARIO_REFERENCIASPROVEEDOR'])
                                    ->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['cuenta'] = 'Desactivada';
                            } else {
                                $cuentas = altareferenciasModel::where('ID_FORMULARIO_REFERENCIASPROVEEDOR', $request['ID_FORMULARIO_REFERENCIASPROVEEDOR'])
                                    ->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['cuenta'] = 'Activada';
                            }
                        } else {
                            $cuentas = altareferenciasModel::find($request->ID_FORMULARIO_REFERENCIASPROVEEDOR);
                            $cuentas->update($request->except('RFC_PROVEEDOR')); 
                            $response['code'] = 1;
                            $response['cuenta'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['cuenta']  = $cuentas;
                    return response()->json($response);
                    break;
                default:
                    $response['code']  = 1;
                    $response['msj']  = 'API no encontrada';
                    return response()->json($response);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al guardar'], 500);
        }
    }

}
