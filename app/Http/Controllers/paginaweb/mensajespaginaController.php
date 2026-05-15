<?php

namespace App\Http\Controllers\paginaweb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\paginaweb\ContactoPaginaWeb;


class mensajespaginaController extends Controller
{

    public function Tablamensajepaginaweb()
    {
        try {
            $tabla = ContactoPaginaWeb::whereNull('SOLICITUD_ATENDIDA')
                ->orWhere('SOLICITUD_ATENDIDA', '')
                ->get();
            foreach ($tabla as $value) {


                foreach ($tabla as $value) {
                    if ($value->ACTIVO == 0) {
                        $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                        $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_CONTACTOSPAGINAWEB . '"><span class="slider round"></span></label>';
                        $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                    } else {
                        $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_CONTACTOSPAGINAWEB . '" checked><span class="slider round"></span></label>';
                        $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                        $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    }
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


    public function Tablamensajepaginawebhistorial()
    {
        try {
            $tabla = ContactoPaginaWeb::where('SOLICITUD_ATENDIDA', 1)
                ->orWhere('SOLICITUD_ATENDIDA', 2)
                ->get();
            foreach ($tabla as $value) {


                foreach ($tabla as $value) {

                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                    $value->BTN_ELIMINAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
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
                    if ($request->ID_FORMULARIO_CONTACTOSPAGINAWEB == 0) {
                        DB::statement('ALTER TABLE contactos_paginaweb AUTO_INCREMENT=1;');
                        $paginas = ContactoPaginaWeb::create($request->all());
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $paginas = ContactoPaginaWeb::where('ID_FORMULARIO_CONTACTOSPAGINAWEB', $request['ID_FORMULARIO_CONTACTOSPAGINAWEB'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['pagina'] = 'Desactivada';
                            } else {
                                $paginas = ContactoPaginaWeb::where('ID_FORMULARIO_CONTACTOSPAGINAWEB', $request['ID_FORMULARIO_CONTACTOSPAGINAWEB'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['pagina'] = 'Activada';
                            }
                        } else {
                            $paginas = ContactoPaginaWeb::find($request->ID_FORMULARIO_CONTACTOSPAGINAWEB);
                            $paginas->update($request->all());
                            $response['code'] = 1;
                            $response['pagina'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['pagina']  = $paginas;
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
