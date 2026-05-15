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

use App\Models\proveedor\altacontactos;
use App\Models\proveedor\catalogofuncionesproveedorModel;
use App\Models\proveedor\catalogotituloproveedorModel;


class altacontactoController extends Controller
{

    public function index()
    {
        $funcionesCuenta = catalogofuncionesproveedorModel::all();
        $titulosCuenta = catalogotituloproveedorModel::where('ACTIVO', 1)->get();

        return view('compras.proveedores.altacontactos', compact('funcionesCuenta', 'titulosCuenta'));
    }



    public function Tablacontactosproveedor()
    {
        try {
            $userRFC = Auth::user()->RFC_PROVEEDOR;

            $tabla = altacontactos::where('RFC_PROVEEDOR', $userRFC)->get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_CONTACTOPROVEEDOR . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_CONTACTOPROVEEDOR . '" checked><span class="slider round"></span></label>';
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

                    $requestData = $request->all();

                    if ($request->has('FUNCIONES_CUENTA') && is_array($request->FUNCIONES_CUENTA)) {
                        $requestData['FUNCIONES_CUENTA'] = json_encode($request->FUNCIONES_CUENTA);
                    } else {
                        $requestData['FUNCIONES_CUENTA'] = null;
                    }

                    $requestData['RFC_PROVEEDOR'] = Auth::user()->RFC_PROVEEDOR;

                    if ($request->ID_FORMULARIO_CONTACTOPROVEEDOR == 0) {

                        DB::statement('ALTER TABLE formulario_altacuentaproveedor AUTO_INCREMENT = 1;');

                        $cuentas = altacontactos::create($requestData);

                        return response()->json([
                            'code' => 1,
                            'cuenta' => $cuentas
                        ]);
                    } else {
                        if (isset($request->ELIMINAR)) {
                            $estado = $request->ELIMINAR == 1 ? 0 : 1;

                            altacontactos::where('ID_FORMULARIO_CONTACTOPROVEEDOR', $request->ID_FORMULARIO_CONTACTOPROVEEDOR)
                                ->update(['ACTIVO' => $estado]);

                            return response()->json([
                                'code' => 1,
                                'cuenta' => ['status' => $estado == 0 ? 'Desactivada' : 'Activada']
                            ]);
                        }

                        $cuentas = altacontactos::find($request->ID_FORMULARIO_CONTACTOPROVEEDOR);

                        if (!$cuentas) {
                            return response()->json([
                                'code' => 0,
                                'error' => 'Formulario no encontrado.'
                            ], 404);
                        }

                        $requestData = $request->except('RFC_PROVEEDOR');

                        if ($request->has('FUNCIONES_CUENTA') && is_array($request->FUNCIONES_CUENTA)) {
                            $requestData['FUNCIONES_CUENTA'] = json_encode($request->FUNCIONES_CUENTA);
                        } else {
                            $requestData['FUNCIONES_CUENTA'] = null;
                        }

                        $cuentas->update($requestData);

                        return response()->json([
                            'code' => 1,
                            'cuenta' => $cuentas
                        ]);
                    }

                    break;

                default:
                    return response()->json([
                        'code' => 0,
                        'msj' => 'API no encontrada'
                    ], 400);
            }
        } catch (Exception $e) {
            return response()->json([
                'code' => 0,
                'error' => 'Error al guardar',
                'exception' => $e->getMessage()
            ], 500);
        }
    }
}
