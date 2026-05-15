<?php

namespace App\Http\Controllers\reclutamiento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use App\Models\organizacion\catalogogeneroModel;
use App\Models\organizacion\cataloareainteresModel;
use App\Models\reclutamiento\bancocvModel;
use App\Models\reclutamiento\listapostulacionesModel;


use DB;

class PuestoController extends Controller
{


    public function index()
    {
        $today = now()->toDateString(); 
    

        $vacantes = DB::select("SELECT vac.*, cat.NOMBRE_CATEGORIA
                                FROM catalogo_vacantes vac
                                LEFT JOIN catalogo_categorias cat ON cat.ID_CATALOGO_CATEGORIA = vac.CATEGORIA_VACANTE
                                WHERE vac.LA_VACANTES_ES = 'Pública' 
                                AND vac.FECHA_EXPIRACION > ? 
                                AND vac.ACTIVO = 1", [$today]);
    
        foreach ($vacantes as $vacante) {

            $requerimientos = DB::table('requerimientos_vacantes')
                                ->where('CATALOGO_VACANTES_ID', $vacante->ID_CATALOGO_VACANTE)
                                ->pluck('NOMBRE_REQUERIMINETO');
    
            $vacante->requerimientos = $requerimientos;
        }
    
        $generos = catalogogeneroModel::where('ACTIVO', 1)->get();
    
        $administrativas = cataloareainteresModel::where('TIPO_AREA', 1)->get();
        $operativas = cataloareainteresModel::where('TIPO_AREA', 2)->get();
    
        return view('RH.reclutamiento.VacantesExterna', compact('vacantes', 'generos', 'administrativas', 'operativas'));
    }
    
    
public function getCvInfo(Request $request)
{
    $curp = $request->input('curp');
    $cvInfo = bancocvModel::where('CURP_CV', $curp)->first();

    if ($cvInfo) {
        return response()->json($cvInfo);
    } else {
        return response()->json(['message' => 'No se encontró la CURP.'], 404);
    }
}







public function store(Request $request)
{
    try {
        switch (intval($request->api)) {
            case 1:
                $identificador = $request->CURP_CV ? $request->CURP_CV : 'extranjero_' . time();
                
                $bancocvs = bancocvModel::where('CURP_CV', $request->CURP_CV)->first();

                if ($bancocvs) {
                    $interes_admon = $request->INTERES_ADMINISTRATIVA ?? $bancocvs->INTERES_ADMINISTRATIVA;
                    $interes_ope = $request->INTERES_OPERATIVAS ?? $bancocvs->INTERES_OPERATIVAS;

                    $bancocvs->update(array_merge($bancocvs->toArray(), $request->except(['ARCHIVO_CURP_CV', 'ARCHIVO_PASAPORTE_CV', 'ARCHIVO_CV']), [
                        'INTERES_ADMINISTRATIVA' => $interes_admon,
                        'INTERES_OPERATIVAS' => $interes_ope,
                    ]));

                    $curpFolder = 'reclutamiento/' . $identificador; 

                    if ($request->hasFile('ARCHIVO_CURP_CV') || $request->hasFile('ARCHIVO_PASAPORTE_CV')) {
                        if ($request->hasFile('ARCHIVO_CURP_CV')) {
                            $curpFile = $request->file('ARCHIVO_CURP_CV');
                            $curpFileFolder = $curpFolder . '/CURP/';
                            $curpFileName = 'CURP_' . $identificador . '.' . $curpFile->getClientOriginalExtension();
                            $curpFile->storeAs($curpFileFolder, $curpFileName);
                            $bancocvs->ARCHIVO_CURP_CV = $curpFileFolder . $curpFileName;
                        } elseif ($request->hasFile('ARCHIVO_PASAPORTE_CV')) {
                            $pasaporteFile = $request->file('ARCHIVO_PASAPORTE_CV');
                            $pasaporteFileFolder = $curpFolder . '/PASAPORTE/';
                            $pasaporteFileName = 'PASAPORTE_' . $identificador . '.' . $pasaporteFile->getClientOriginalExtension();
                            $pasaporteFile->storeAs($pasaporteFileFolder, $pasaporteFileName);
                            $bancocvs->ARCHIVO_CURP_CV = $pasaporteFileFolder . $pasaporteFileName; 
                        }
                    }

                    if ($request->hasFile('ARCHIVO_CV')) {
                        $cvFile = $request->file('ARCHIVO_CV');
                        $cvFileFolder = $curpFolder . '/CV/';
                        $cvFileName = 'CV_' . $identificador . '.' . $cvFile->getClientOriginalExtension();
                        $cvFile->storeAs($cvFileFolder, $cvFileName);
                        $bancocvs->ARCHIVO_CV = $cvFileFolder . $cvFileName;
                    }

                    listapostulacionesModel::create([
                        'VACANTES_ID' => $request->VACANTES_ID,
                        'CURP' => $request->CURP_CV, 
                    ]);

                    $response['code'] = 1;
                    $response['bancocv'] = $bancocvs;
                    return response()->json($response);
                } else {
                    $response['code'] = 0;
                    $response['msj'] = 'No se encontró un registro con esa CURP o Pasaporte';
                    return response()->json($response);
                }

            default:
                $response['code'] = 0;
                $response['msj'] = 'Api no encontrada';
                return response()->json($response);
        }
    } catch (Exception $e) {
        return response()->json(['code' => 0, 'msj' => 'Error al actualizar la información', 'error' => $e->getMessage()]);
    }
}









public function store1(Request $request)
{
    try {
        switch (intval($request->api)) {
            case 1:
                $existePostulacion = listapostulacionesModel::where('VACANTES_ID', $request->VACANTES_ID)
                                                          ->where('CURP', $request->CURP)
                                                          ->exists();

                if ($existePostulacion) {
                    $response['code']  = 0;
                    $response['msj']  = 'Ya te has postulado a esta vacante';
                    return response()->json($response);
                }

                if ($request->ID_LISTA_POSTULANTES == 0) {
                    DB::statement('ALTER TABLE lista_postulantes AUTO_INCREMENT=1;');

                    $listas = listapostulacionesModel::create([
                        'VACANTES_ID' => $request->VACANTES_ID,
                        'CURP' => $request->CURP,
                    ]);

                    $response['code']  = 1;
                    $response['lista']  = $listas;
                    return response()->json($response);
                } 

                break;
            default:
                $response['code']  = 0;
                $response['msj']  = 'Api no encontrada';
                return response()->json($response);
        }
    } catch (Exception $e) {
        return response()->json(['code' => 0, 'msj' => 'Error al guardar la postulación', 'error' => $e->getMessage()]);
    }
}

}
