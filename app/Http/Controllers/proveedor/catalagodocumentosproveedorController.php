<?php

namespace App\Http\Controllers\proveedor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use App\Models\proveedor\catalogodocumentoproveedorModel;

use DB;



class catalagodocumentosproveedorController extends Controller
{




    public function Tabladocumentosoportes()
    {
        try {
            $tabla = catalogodocumentoproveedorModel::get();

            foreach ($tabla as $value) {

            
                if ($value->TIPO_PERSONA == 1) {
                    $value->TIPO_PERSONA_TEXTO = 'Nacional';
                } elseif ($value->TIPO_PERSONA == 2) {
                    $value->TIPO_PERSONA_TEXTO = 'Extranjero';
                } else {
                    $value->TIPO_PERSONA_TEXTO = 'Nacional y extranjero';
                }

                if ($value->TIPO_PERSONA_OPCION == 1) {
                    $value->TIPO_PERSONA_OPCION_TEXTO = 'Moral';
                } elseif ($value->TIPO_PERSONA_OPCION == 2) {
                    $value->TIPO_PERSONA_OPCION_TEXTO = 'Física';
                } else {
                    $value->TIPO_PERSONA_OPCION_TEXTO = 'Moral y física';
                }


                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_CATALOGO_DOCUMENTOSPROVEEDOR . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_CATALOGO_DOCUMENTOSPROVEEDOR . '" checked><span class="slider round"></span></label>';
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
                    if ($request->ID_CATALOGO_DOCUMENTOSPROVEEDOR == 0) {
                        DB::statement('ALTER TABLE catalogo_documentosproveedor AUTO_INCREMENT=1;');
                        $documentos = catalogodocumentoproveedorModel::create($request->all());
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $documentos = catalogodocumentoproveedorModel::where('ID_CATALOGO_DOCUMENTOSPROVEEDOR', $request['ID_CATALOGO_DOCUMENTOSPROVEEDOR'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['documento'] = 'Desactivada';
                            } else {
                                $documentos = catalogodocumentoproveedorModel::where('ID_CATALOGO_DOCUMENTOSPROVEEDOR', $request['ID_CATALOGO_DOCUMENTOSPROVEEDOR'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['documento'] = 'Activada';
                            }
                        } else {
                            $documentos = catalogodocumentoproveedorModel::find($request->ID_CATALOGO_DOCUMENTOSPROVEEDOR);
                            $documentos->update($request->all());
                            $response['code'] = 1;
                            $response['documento'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['documento']  = $documentos;
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
