<?php

namespace App\Http\Controllers\contratacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;

use App\Models\pendientecontratar\pendientecontratarModel;

use DB;

class pendientecontratarController extends Controller
{
    

    public function Tablapendientecontratacion()
    {
        try {
            $tabla = DB::table('pendientes_contratar')
            ->join('catalogo_categorias', 'pendientes_contratar.VACANTE_ID', '=', 'catalogo_categorias.ID_CATALOGO_CATEGORIA')
            ->select('pendientes_contratar.*', 'catalogo_categorias.NOMBRE_CATEGORIA as categoria_nombre')
            ->get();    
            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_CONTRATACION = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_CONTRATACION = '<button type="button" class="btn btn-success rounded-pill GUARDAR" 
                                data-curp="' . $value->CURP . '" 
                                data-nombre="' . $value->NOMBRE_PC . '" 
                                data-primer-apellido="' . $value->PRIMER_APELLIDO_PC . '" 
                                data-segundo-apellido="' . $value->SEGUNDO_APELLIDO_PC . '" 
                                data-dia="' . $value->DIA_FECHA_PC . '" 
                                data-mes="' . $value->MES_FECHA_PC . '" 
                                data-anio="' . $value->ANIO_FECHA_PC . '">
                                <i class="bi bi-save"></i>
                            </button>';

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











    public function mandarContratacion(Request $request)
    {
        try {
            $request->validate([
                'CURP' => 'required|string'
            ]);
    
            $registro = pendientecontratarModel::where('CURP', $request->CURP)->first();
    
            if (!$registro) {
                return response()->json(['message' => 'No se encontró el registro con la CURP proporcionada.'], 404);
            }
    
            pendientecontratarModel::where('CURP', $request->CURP)->delete();
    
            DB::table('formulario_contratacion')->insert([
                'CURP' => $registro->CURP,
                'NOMBRE_COLABORADOR' => $registro->NOMBRE_PC,
                'PRIMER_APELLIDO' => $registro->PRIMER_APELLIDO_PC,
                'SEGUNDO_APELLIDO' => $registro->SEGUNDO_APELLIDO_PC,
                'DIA_COLABORADOR' => $registro->DIA_FECHA_PC,
                'MES_COLABORADOR' => $registro->MES_FECHA_PC,
                'ANIO_COLABORADOR' => $registro->ANIO_FECHA_PC,
                'FECHA_INGRESO' => $request->FECHA_INGRESO, 

            ]);
    
            return response()->json(['message' => 'Registro enviado a contratación correctamente.'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
    
}
