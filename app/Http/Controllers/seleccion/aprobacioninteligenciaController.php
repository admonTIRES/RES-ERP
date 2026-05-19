<?php

namespace App\Http\Controllers\seleccion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Artisan;
use Exception;


use App\Models\selección\inteligenciaseleccionModel;


use DB;

class aprobacioninteligenciaController extends Controller
{
    public function Tablaprobarinteligencialaboral()
    {
        try {

            $tabla = inteligenciaseleccionModel::select(
                'seleccion_inteligencia.*',
                DB::raw("
                    CONCAT(
                        formulario_bancocv.NOMBRE_CV, ' ',
                        formulario_bancocv.PRIMER_APELLIDO_CV, ' ',
                        formulario_bancocv.SEGUNDO_APELLIDO_CV,
                        ' (',
                        seleccion_inteligencia.CURP,
                        ')'
                    ) as TEXTO_CURP
                ")
            )
                ->leftJoin(
                    'formulario_bancocv',
                    'formulario_bancocv.CURP_CV',
                    '=',
                    'seleccion_inteligencia.CURP'
                )

                ->whereIn('RIESGO_PORCENTAJE', [40, 70])

                ->where(function ($query) {
                    $query->whereNull('APROBACION_INTELIGENCIA')
                        ->orWhere('APROBACION_INTELIGENCIA', '');
                })

                ->get();

            foreach ($tabla as $value) {

                if ($value->ACTIVO == 0) {

                    $value->BTN_VISUALIZAR = '
                    <button type="button"
                        class="btn btn-primary btn-custom rounded-pill VISUALIZAR">
                        <i class="bi bi-eye"></i>
                    </button>';

                    $value->BTN_ELIMINAR = '
                    <label class="switch">
                        <input type="checkbox"
                            class="ELIMINAR"
                            data-id="' . $value->ID_INTELIGENCIA_SELECCION . '">
                        <span class="slider round"></span>
                    </label>';

                    $value->BTN_EDITAR = '
                    <button type="button"
                        class="btn btn-secondary btn-custom rounded-pill EDITAR"
                        disabled>
                        <i class="bi bi-ban"></i>
                    </button>';
                } else {

                    $value->BTN_ELIMINAR = '
                    <label class="switch">
                        <input type="checkbox"
                            class="ELIMINAR"
                            data-id="' . $value->ID_INTELIGENCIA_SELECCION . '"
                            checked>
                        <span class="slider round"></span>
                    </label>';

                    $value->BTN_EDITAR = '
                    <button type="button"
                        class="btn btn-warning btn-custom rounded-pill EDITAR">
                        <i class="bi bi-pencil-square"></i>
                    </button>';

                    $value->BTN_VISUALIZAR = '
                    <button type="button"
                        class="btn btn-primary btn-custom rounded-pill VISUALIZAR">
                        <i class="bi bi-eye"></i>
                    </button>';
                }


                switch ($value->RIESGO_PORCENTAJE) {
                    case 100:
                        $value->RIESGO = 'Bajo';
                        break;
                    case 70:
                        $value->RIESGO = 'Medio';
                        break;
                    case 40:
                        $value->RIESGO = 'Alto';
                        break;
                    default:
                        $value->RIESGO = 'Desconocido';
                        break;
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
                    if ($request->ID_INTELIGENCIA_SELECCION == 0) {
                        DB::statement('ALTER TABLE seleccion_inteligencia AUTO_INCREMENT=1;');
                        $inteligencia = inteligenciaseleccionModel::create($request->all());
                    } else {

                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {

                                $inteligencia = inteligenciaseleccionModel::where('ID_INTELIGENCIA_SELECCION', $request['ID_INTELIGENCIA_SELECCION'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['inteligencia'] = 'Desactivada';
                            } else {
                                $inteligencia = inteligenciaseleccionModel::where('ID_INTELIGENCIA_SELECCION', $request['ID_INTELIGENCIA_SELECCION'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['inteligencia'] = 'Activada';
                            }
                        } else {
                            $inteligencia = inteligenciaseleccionModel::find($request->ID_INTELIGENCIA_SELECCION);
                            $inteligencia->update($request->all());
                            $response['code'] = 1;
                            $response['inteligencia'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['inteligencia']  = $inteligencia;
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
