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

class vacantesactivasController extends Controller
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

            
        return view('RH.reclutamiento.Vacantes_activas', compact('areas', 'vacantes'));
    }



    // TABLA PARA VER TODAS LAS POSTULACIONES     
    // public function Tablapostulaciones()
    // {
    //         try {

    //             $tabla = DB::select("
    //             SELECT vac.*, 
    //                 cat.NOMBRE_CATEGORIA, 
    //                 (
    //                     SELECT COUNT(lp.VACANTES_ID) 
    //                     FROM lista_postulantes lp 
    //                     WHERE lp.VACANTES_ID = vac.ID_CATALOGO_VACANTE 
    //                     AND lp.ACTIVO = 1
    //                 ) AS TOTAL_POSTULANTES
    //             FROM catalogo_vacantes vac
    //             LEFT JOIN catalogo_categorias cat 
    //                 ON cat.ID_CATALOGO_CATEGORIA = vac.CATEGORIA_VACANTE
    //             WHERE vac.ACTIVO = 1
    //             AND (
    //                 vac.FECHA_EXPIRACION >= CURDATE()
    //                 OR EXISTS (
    //                     SELECT 1
    //                     FROM lista_postulantes lp
    //                     WHERE lp.VACANTES_ID = vac.ID_CATALOGO_VACANTE
    //                     AND lp.ACTIVO = 1
    //                 )
    //                 OR EXISTS (
    //                     SELECT 1
    //                     FROM vacantes_activas va
    //                     WHERE va.VACANTES_ID = vac.ID_CATALOGO_VACANTE
    //                 )
    //             )
    //         ");

    //             foreach ($tabla as $value) {

    //                 $value->REQUERIMIENTO = requerimientoModel::where(
    //                     'CATALOGO_VACANTES_ID',
    //                     $value->ID_CATALOGO_VACANTE
    //                 )->get();

    //                 $value->BTN_VISUALIZAR = '
    //                 <button type="button"
    //                     class="btn btn-primary btn-custom rounded-pill VISUALIZAR"
    //                     data-bs-toggle="tooltip"
    //                     data-bs-placement="top"
    //                     title="Visualizar registro">
    //                     <i class="bi bi-eye"></i>
    //                 </button>
    //             ';

    //                 $value->TOTAL_POSTULANTES = '
    //                 <button type="button"
    //                     class="btn btn-success btn-custom rounded-pill TOTAL_POSTULANTES"
    //                     onclick="TotalPostulantes(' . $value->ID_CATALOGO_VACANTE . ', ' . $value->CATEGORIA_VACANTE . ')">
    //                     ' . $value->TOTAL_POSTULANTES . '
    //                 </button>
    //             ';
    //             }

    //             return response()->json([
    //                 'data' => $tabla,
    //                 'msj' => 'Información consultada correctamente'
    //             ]);
    //         } catch (Exception $e) {

    //             return response()->json([
    //                 'msj' => 'Error ' . $e->getMessage(),
    //                 'data' => []
    //             ]);
    //         }
    // }

    public function Tablapostulaciones()
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
            AND vac.FECHA_EXPIRACION >= CURDATE()
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
                'data' => []
            ]);
        }
    }



    // FUNCION  PARA CONSULTAR LAS PERSONAS QUE SE CREARON  PARA PODER PRESELECCIONAR 
    public function informacionpreseleccion($idVacante)
{
    try {
        $preseleccionados = DB::table('vacantes_activas')
            ->where('VACANTES_ID', $idVacante)
            ->where('ACTIVO', 1)
            ->select(
                'CURP',
                'NOMBRE_AC',
                'PRIMER_APELLIDO_AC',
                'SEGUNDO_APELLIDO_AC',
                'CORREO_AC',
                'TELEFONO1_AC',
                'TELEFONO2_AC',
                'DIA_FECHA_AC',
                'MES_FECHA_AC',
                'ANIO_FECHA_AC',
                'PORCENTAJE',
                'DISPONIBLE'
            )
            ->get();

        return response()->json($preseleccionados);
    } catch (Exception $e) {
        return response()->json([
            'msj' => 'Error ' . $e->getMessage(),
            'data' => 0
        ]);
    }
}



//  FUNCION PARA CONSULTAR LAS PERSONAS QUE SE POSTULARON 
public function informacionpostulantes($idVacante)
{
    try {
        $postulantes = DB::select("
            SELECT 
                fb.NOMBRE_CV,
                fb.PRIMER_APELLIDO_CV,
                fb.SEGUNDO_APELLIDO_CV,
                fb.CURP_CV,
                fb.CORREO_CV,
                fb.TELEFONO1,
                fb.TELEFONO2,
                fb.DIA_FECHA_CV,
                fb.MES_FECHA_CV,
                fb.ANIO_FECHA_CV,
                fb.ARCHIVO_CV, 
                lp.VACANTES_ID
            FROM lista_postulantes lp
            LEFT JOIN formulario_bancocv fb ON lp.CURP = fb.CURP_CV
            WHERE lp.VACANTES_ID = ? AND lp.ACTIVO = 1
            GROUP BY fb.CURP_CV, lp.VACANTES_ID, fb.NOMBRE_CV, fb.PRIMER_APELLIDO_CV, fb.SEGUNDO_APELLIDO_CV, fb.CORREO_CV, fb.TELEFONO1, fb.TELEFONO2, fb.DIA_FECHA_CV,
                fb.MES_FECHA_CV,fb.ANIO_FECHA_CV, fb.ARCHIVO_CV
        ", [$idVacante]);

        $requerimientos = DB::select("
            SELECT 
                rv.NOMBRE_REQUERIMINETO,
                rv.PORCENTAJE
            FROM requerimientos_vacantes rv
            WHERE rv.CATALOGO_VACANTES_ID = ?
        ", [$idVacante]);

        return response()->json([
            'postulantes' => $postulantes,
            'requerimientos' => $requerimientos,
            'msj' => 'Información consultada correctamente'
        ]);
    } catch (Exception $e) {
        return response()->json([
            'msj' => 'Error ' . $e->getMessage(),
            'data' => 0
        ]);
    }
}


//  FUNCION PARA MOSTRAR EL CV DE LA PERSONA QUE SE POSTULO A LA VACANTE 

public function mostrarCvPorCurp($curp)
{
    try {
        $postulante = bancocvModel::where('CURP_CV', $curp)->firstOrFail();

        $rutaArchivo = $postulante->ARCHIVO_CV;

        if (Storage::exists($rutaArchivo)) {
            return Storage::response($rutaArchivo);
        } else {
            return response()->json(['msj' => 'Archivo no encontrado'], 404);
        }
    } catch (Exception $e) {
        return response()->json(['msj' => 'Error al obtener el archivo: ' . $e->getMessage()], 500);
    }
}


//  FUNCION PARA GUARDAR LOS POSTULANTES 

public function guardarPostulantes (Request $request)
{
    $postulante = $request->all(); 

    listapostulacionesModel::where('CURP', $postulante['CURP'])
    ->where('VACANTES_ID', $postulante['VACANTES_ID'])
    ->delete();


    vacantesactivasModel::create([
        'VACANTES_ID' => $postulante['VACANTES_ID'],
        'CATEGORIA_VACANTE' => $postulante['CATEGORIA_VACANTE'],
        'CURP' => $postulante['CURP'],
        'NOMBRE_AC' => $postulante['NOMBRE_AC'],
        'PRIMER_APELLIDO_AC' => $postulante['PRIMER_APELLIDO_AC'],
        'SEGUNDO_APELLIDO_AC' => $postulante['SEGUNDO_APELLIDO_AC'],
        'CORREO_AC' => $postulante['CORREO_AC'],
        'TELEFONO1_AC' => $postulante['TELEFONO1_AC'],
        'TELEFONO2_AC' => $postulante['TELEFONO2_AC'],
        'DIA_FECHA_AC' => $postulante['DIA_FECHA_AC'],
        'MES_FECHA_AC' => $postulante['MES_FECHA_AC'],
        'ANIO_FECHA_AC' => $postulante['ANIO_FECHA_AC'],
        'PORCENTAJE' => $postulante['PORCENTAJE'],
        'ACTIVO' => 1
    ]);

    return response()->json(['message' => 'Información guardada con éxito.'], 200);
}


//  FUNCION PARA GUARDAR LAS PERSONAS QUE SE PRESELECCIONARON  Y MANDARLO A SELECCION

public function guardarPreseleccion(Request $request)
    {
        try {

        vacantesactivasModel::where('CURP', $request->CURP)
        ->where('VACANTES_ID', $request->VACANTES_ID)
        ->delete();
            
        SeleccionModel::create([
            'VACANTES_ID' => $request->VACANTES_ID,
            'CATEGORIA_VACANTE' => $request->CATEGORIA_VACANTE,
            'CURP' => $request->CURP,
            'NOMBRE_SELC' => $request->NOMBRE_SELC,
            'PRIMER_APELLIDO_SELEC' => $request->PRIMER_APELLIDO_SELEC,
            'SEGUNDO_APELLIDO_SELEC' => $request->SEGUNDO_APELLIDO_SELEC,
            'CORREO_SELEC' => $request->CORREO_SELEC,
            'TELEFONO1_SELECT' => $request->TELEFONO1_SELECT,
            'TELEFONO2_SELECT' => $request->TELEFONO2_SELECT,
            'DIA_FECHA_SELECT' => $request->DIA_FECHA_SELECT,
            'MES_FECHA_SELECT' => $request->MES_FECHA_SELECT,
            'ANIO_FECHA_SELECT' => $request->ANIO_FECHA_SELECT,
            'PORCENTAJE' => $request->PORCENTAJE,
        ]);

        return response()->json(['message' => 'Postulante seleccionado exitosamente.'], 200);
    } catch (Exception $e) {
        return response()->json(['message' => 'Error al seleccionar postulante: ' . $e->getMessage()], 500);
    }
}

 
// FUNCION PARA ACTULIZAR LA DISPONIBLIDAD DE LAS PERSONAS ANTES DE PRESELECCIONAR 

public function actualizarDisponibilidad(Request $request)
{
    try {
        $request->validate([
            'VACANTES_ID' => 'required|integer',
            'CURP' => 'required|string',
            'DISPONIBLE' => 'required|string|in:si,no'
        ]);

        $vacante = vacantesactivasModel::where('VACANTES_ID', $request->VACANTES_ID)
            ->where('CURP', $request->CURP)
            ->first();

        if ($vacante) {
            $vacante->DISPONIBLE = $request->DISPONIBLE;
            $vacante->save();

            return response()->json(['message' => 'Disponibilidad actualizada con éxito.'], 200);
        } else {
            return response()->json(['message' => 'Registro no encontrado.'], 404);
        }
    } catch (Exception $e) {
        return response()->json(['message' => 'Error al actualizar la disponibilidad: ' . $e->getMessage()], 500);
    }
}



public function store(Request $request)
    {
        try {
            switch (intval($request->api)) {
                case 1:
                    if ($request->ID_LISTA_POSTULANTES == 0) {
                        DB::statement('ALTER TABLE lista_postulantes AUTO_INCREMENT=1;');
                        $asesores = listapostulacionesModel::create($request->all());
                    } else { 

                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                             
                                $asesores = listapostulacionesModel::where('ID_LISTA_POSTULANTES', $request['ID_LISTA_POSTULANTES'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['asesor'] = 'Desactivada';
                            } else {
                                $asesores = listapostulacionesModel::where('ID_LISTA_POSTULANTES', $request['ID_LISTA_POSTULANTES'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['asesor'] = 'Activada';
                            }
                        } else {
                            $asesores = listapostulacionesModel::find($request->ID_LISTA_POSTULANTES);
                            $asesores->update($request->all());
                            $response['code'] = 1;
                            $response['asesor'] = 'Actualizada';
                        }
                        return response()->json($response);

                    
                    }
                    $response['code']  = 1;
                    $response['asesor']  = $asesores;
                    return response()->json($response);
                    break;
                default:
                    $response['code']  = 1;
                    $response['msj']  = 'Api no encontrada';
                    return response()->json($response);
            }
        } catch (Exception $e) {
            return response()->json('Error al guardar el asesor');
        }
    }



}
