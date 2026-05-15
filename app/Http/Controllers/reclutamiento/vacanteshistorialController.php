<?php

namespace App\Http\Controllers\reclutamiento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use App\Models\reclutamiento\requerimientoModel;
use App\Models\organizacion\catalogocategoriaModel;
use App\Models\selección\seleccionModel;
use App\Models\reclutamiento\listapostulacionesModel;
use App\Models\reclutamiento\bancocvModel;
use App\Models\reclutamiento\vacantesactivasModel;


use Illuminate\Support\Facades\Storage;


use DB;
use Carbon\Carbon;

class vacanteshistorialController extends Controller
{
    public function index()
    {
        $areas = catalogocategoriaModel::where('ES_LIDER_CATEGORIA', 0)
            ->orderBy('NOMBRE_CATEGORIA', 'ASC')
            ->get();

        $vacantes = DB::table('catalogo_vacantes')
            ->join('catalogo_categorias', 'catalogo_vacantes.CATEGORIA_VACANTE', '=', 'catalogo_categorias.ID_CATALOGO_CATEGORIA')
            ->select(
                'catalogo_vacantes.ID_CATALOGO_VACANTE',
                'catalogo_categorias.NOMBRE_CATEGORIA',
                'catalogo_vacantes.FECHA_EXPIRACION'
            )
            ->where('catalogo_vacantes.LA_VACANTES_ES', 'Privada')
            ->whereDate('catalogo_vacantes.FECHA_EXPIRACION', '>=', Carbon::now()->toDateString())
            ->orderBy('catalogo_categorias.NOMBRE_CATEGORIA', 'ASC')
            ->get();

        return view('RH.reclutamiento.vacantesactivashistorial', compact('areas', 'vacantes'));
    }


    // TABLA PARA VER TODAS LAS POSTULACIONES     
    // public function Tablapostulacioneshistorial()
    // {
    //     try {
    //         $tabla = DB::select("
    //         SELECT vac.*, 
    //                 cat.NOMBRE_CATEGORIA, 
    //                 (SELECT COUNT(lp.VACANTES_ID) 
    //                 FROM lista_postulantes lp 
    //                 WHERE lp.VACANTES_ID = vac.ID_CATALOGO_VACANTE AND lp.ACTIVO = 1) AS TOTAL_POSTULANTES
    //         FROM catalogo_vacantes vac
    //         LEFT JOIN catalogo_categorias cat ON cat.ID_CATALOGO_CATEGORIA = vac.CATEGORIA_VACANTE
    //         WHERE vac.ACTIVO = 1
    //     ");

    //         foreach ($tabla as $value) {
    //             $value->REQUERIMIENTO = requerimientoModel::where('CATALOGO_VACANTES_ID', $value->ID_CATALOGO_VACANTE)->get();

    //             $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR" data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar registro"><i class="bi bi-eye"></i></button>';

    //             $value->TOTAL_POSTULANTES = '<button type="button" class="btn btn-success btn-custom rounded-pill TOTAL_POSTULANTES" onclick="TotalPostulantes(' . $value->ID_CATALOGO_VACANTE . ', ' . $value->CATEGORIA_VACANTE . ')">' . $value->TOTAL_POSTULANTES . '</button>';
    //         }

    //         return response()->json([
    //             'data' => $tabla,
    //             'msj' => 'Información consultada correctamente'
    //         ]);
    //     } catch (Exception $e) {

    //         return response()->json([
    //             'msj' => 'Error ' . $e->getMessage(),
    //             'data' => 0
    //         ]);
    //     }
    // }



    public function Tablapostulacioneshistorial()
    {
        try {

            $tabla = DB::select("
            SELECT vac.*, 
                    cat.NOMBRE_CATEGORIA, 
                    (
                        SELECT COUNT(lp.VACANTES_ID) 
                        FROM lista_postulantes lp 
                        WHERE lp.VACANTES_ID = vac.ID_CATALOGO_VACANTE 
                        AND lp.ACTIVO = 1
                    ) AS TOTAL_POSTULANTES
            FROM catalogo_vacantes vac
            LEFT JOIN catalogo_categorias cat 
                ON cat.ID_CATALOGO_CATEGORIA = vac.CATEGORIA_VACANTE
            WHERE vac.ACTIVO = 1
            ORDER BY vac.FECHA_EXPIRACION DESC
        ");

            foreach ($tabla as $value) {

                $value->REQUERIMIENTO = requerimientoModel::where(
                    'CATALOGO_VACANTES_ID',
                    $value->ID_CATALOGO_VACANTE
                )->get();

                $value->BTN_VISUALIZAR = '
                <button type="button"
                    class="btn btn-primary btn-custom rounded-pill VISUALIZAR"
                    data-bs-toggle="tooltip"
                    data-bs-placement="top"
                    title="Visualizar registro">
                    <i class="bi bi-eye"></i>
                </button>
            ';

                $value->TOTAL_POSTULANTES = '
                <button type="button"
                    class="btn btn-success btn-custom rounded-pill TOTAL_POSTULANTES"
                    onclick="TotalPostulantes(' . $value->ID_CATALOGO_VACANTE . ', ' . $value->CATEGORIA_VACANTE . ')">
                    ' . $value->TOTAL_POSTULANTES . '
                </button>
            ';
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
    
}
