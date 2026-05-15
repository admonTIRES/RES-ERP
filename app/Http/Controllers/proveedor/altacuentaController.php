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

use App\Models\proveedor\altacuentaModel;

class altacuentaController extends Controller
{



    public function Tablacuentasproveedores()
    {
        try {
            $userRFC = Auth::user()->RFC_PROVEEDOR; 

            $tabla = altacuentaModel::where('RFC_PROVEEDOR', $userRFC)->get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_CUENTAPROVEEDOR . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-caratula" data-id="' . $value->ID_FORMULARIO_CUENTAPROVEEDOR . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_CUENTAPROVEEDOR . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-caratula" data-id="' . $value->ID_FORMULARIO_CUENTAPROVEEDOR . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
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

    public function mostrarcaratula($id)
    {
        $archivo = altacuentaModel::findOrFail($id)->CARATULA_BANCARIA;
        return Storage::response($archivo);
    }

  

    public function store(Request $request)
{
    try {
        switch (intval($request->api)) {
            case 1:
                $rfc = Auth::user()->RFC_PROVEEDOR;
                $requestData = $request->all();
                $requestData['RFC_PROVEEDOR'] = $rfc;

                if ($request->ID_FORMULARIO_CUENTAPROVEEDOR == 0) {
                    DB::statement('ALTER TABLE formulario_altacuentaproveedor AUTO_INCREMENT=1;');

                    $cuentas = altacuentaModel::create($requestData);

                    if ($request->hasFile('CARATULA_BANCARIA')) {
                        $file = $request->file('CARATULA_BANCARIA');
                        $folderPath = "proveedores/{$rfc}/Caratula de cuentas/{$cuentas->ID_FORMULARIO_CUENTAPROVEEDOR}";
                        $fileName = $file->getClientOriginalName();
                        $filePath = $file->storeAs($folderPath, $fileName);

                        $cuentas->CARATULA_BANCARIA = $filePath;
                        $cuentas->save();
                    }

                } else {
                    $cuentas = altacuentaModel::find($request->ID_FORMULARIO_CUENTAPROVEEDOR);

                    if (isset($request->ELIMINAR)) {
                        $cuentas->ACTIVO = $request->ELIMINAR == 1 ? 0 : 1;
                        $cuentas->save();

                        $response['code'] = 1;
                        $response['cuenta'] = $request->ELIMINAR == 1 ? 'Desactivada' : 'Activada';
                        return response()->json($response);
                    }

                    if ($request->hasFile('CARATULA_BANCARIA')) {
                        if ($cuentas->CARATULA_BANCARIA && Storage::exists($cuentas->CARATULA_BANCARIA)) {
                            Storage::delete($cuentas->CARATULA_BANCARIA);
                        }

                        $file = $request->file('CARATULA_BANCARIA');
                        $folderPath = "proveedores/{$rfc}/Caratula de cuentas/{$cuentas->ID_FORMULARIO_CUENTAPROVEEDOR}";
                        $fileName = $file->getClientOriginalName();
                        $filePath = $file->storeAs($folderPath, $fileName);

                        $requestData['CARATULA_BANCARIA'] = $filePath;
                    }

                    $cuentas->update(collect($requestData)->except('RFC_PROVEEDOR')->toArray());

                    $response['code'] = 1;
                    $response['cuenta'] = 'Actualizada';
                    return response()->json($response);
                }

                $response['code']  = 1;
                $response['cuenta']  = $cuentas;
                return response()->json($response);

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
