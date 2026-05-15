<?php

namespace App\Http\Controllers\reclutamiento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use App\Models\reclutamiento\catalogovacantesModel;
use App\Models\organizacion\catalogocategoriaModel;
use App\Models\reclutamiento\requerimientoModel;

use DB;


class catalogovacantesController extends Controller
{

   

    
        public function index()
    {
       


    $areas = catalogocategoriaModel::whereIn('ID_CATALOGO_CATEGORIA', function($query) {
        $query->select('PUESTO_RP')
              ->from('formulario_requerimientos');
    })
    ->orderBy('NOMBRE_CATEGORIA', 'ASC')
    ->get();


        $requerimientos = DB::table('formulario_requerimientos as fr')
            ->join('catalogo_categorias as cat', 'cat.ID_CATALOGO_CATEGORIA', '=', 'fr.PUESTO_RP')
            ->select(
                'fr.ID_FORMULARO_REQUERIMIENTO',
                'fr.PUESTO_RP',
                'cat.NOMBRE_CATEGORIA',
                DB::raw("
            CASE 
                WHEN fr.ANTES_DE1 = 1 THEN fr.FECHA_CREACION
                ELSE fr.FECHA_RP
            END AS FECHA_EFECTIVA
        ")
            )
            ->where('fr.ESTADO_SOLICITUD', 'Aprobada')
            ->orderBy('FECHA_EFECTIVA', 'DESC')
            ->get();



        return view('RH.Catalogos.catalogo_vacantes', compact('areas', 'requerimientos'));
   
    }

    

    public function Tablavacantes()
{
    try {
        $tabla = DB::select("
            SELECT vac.*, cat.NOMBRE_CATEGORIA,
                   DATEDIFF(vac.FECHA_EXPIRACION, CURDATE()) as DIAS_RESTANTES,
                   (CASE WHEN vac.FECHA_EXPIRACION < CURDATE() THEN 1 ELSE 0 END) as EXPIRADO
            FROM catalogo_vacantes vac
            LEFT JOIN catalogo_categorias cat ON cat.ID_CATALOGO_CATEGORIA = vac.CATEGORIA_VACANTE
        ");

        foreach ($tabla as $value) {
            $value->REQUERIMIENTO = requerimientoModel::where('CATALOGO_VACANTES_ID', $value->ID_CATALOGO_VACANTE)->get();

            if ($value->ACTIVO == 0) {
                $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_CATALOGO_VACANTE . '"><span class="slider round"></span></label>';
                $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
            } else {
                $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_CATALOGO_VACANTE . '" checked><span class="slider round"></span></label>';
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
                DB::beginTransaction();

                if ($request->ID_CATALOGO_VACANTE == 0) {
                    DB::statement('ALTER TABLE catalogo_vacantes AUTO_INCREMENT=1;');
                    $vacante = catalogovacantesModel::create($request->all());
                } else {
                    if (isset($request->ELIMINAR)) {
                        if ($request->ELIMINAR == 1) {
                            $vacante = catalogovacantesModel::where('ID_CATALOGO_VACANTE', $request['ID_CATALOGO_VACANTE'])->update(['ACTIVO' => 0]);
                            $response['code'] = 1;
                            $response['vacante'] = 'Desactivada';
                        } else {
                            $vacante = catalogovacantesModel::where('ID_CATALOGO_VACANTE', $request['ID_CATALOGO_VACANTE'])->update(['ACTIVO' => 1]);
                            $response['code'] = 1;
                            $response['vacante'] = 'Activada';
                        }
                        DB::commit();
                        return response()->json($response);
                    } else {
                        $vacante = catalogovacantesModel::find($request->ID_CATALOGO_VACANTE);
                        $vacante->update($request->all());

                        requerimientoModel::where('CATALOGO_VACANTES_ID', $request->ID_CATALOGO_VACANTE)->delete();
                    }
                }

                if ($request->has('NOMBRE_REQUERIMINETO')) {
                    foreach ($request->NOMBRE_REQUERIMINETO as $index => $requerimiento) {
                        requerimientoModel::create([
                            'CATALOGO_VACANTES_ID' => $vacante->ID_CATALOGO_VACANTE,
                            'NOMBRE_REQUERIMINETO' => $requerimiento,
                            'PORCENTAJE' => $request->PORCENTAJE[$index]
                        ]);
                    }
                }

                $response['code'] = 1;
                $response['vacante'] = $vacante;
                DB::commit();
                return response()->json($response);
                break;

            default:
                $response['code'] = 1;
                $response['msj'] = 'Api no encontrada';
                return response()->json($response);
        }
    } catch (Exception $e) {
        DB::rollBack();
        return response()->json('Error al guardar la nueva vacante');
    }
}




}

