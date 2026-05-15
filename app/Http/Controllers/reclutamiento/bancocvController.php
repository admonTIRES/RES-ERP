<?php

namespace App\Http\Controllers\reclutamiento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;
use App\Models\reclutamiento\bancocvModel;
use App\Models\reclutamiento\catalogovacantesModel;
use App\Models\organizacion\catalogogeneroModel;
use App\Models\organizacion\cataloareainteresModel;

use DB;

class bancocvController extends Controller
{


public function index()
{
    $vacantes = catalogovacantesModel::where('LA_VACANTES_ES', 'Privada')->get();
    $generos = catalogogeneroModel::where('ACTIVO', 1)->get();
    $administrativas = cataloareainteresModel::where('TIPO_AREA', 1)->get();
    $operativas = cataloareainteresModel::where('TIPO_AREA', 2)->get();

    return view('RH.reclutamiento.reclutamiento', compact('vacantes','generos','administrativas','operativas'));
}



public function index1()
{
    $generos = catalogogeneroModel::where('ACTIVO', 1)->get();
    $administrativas = cataloareainteresModel::where('TIPO_AREA', 1)->get();
    $operativas = cataloareainteresModel::where('TIPO_AREA', 2)->get();


    return view('RH.reclutamiento.formulario_bancocv', compact('generos','administrativas','operativas'));
}





    public function Tablabancocv()
    {
        try {

            $tabla = bancocvModel::whereNotIn(
                'CURP_CV',
                function ($query) {
                    $query->select('CURP')
                        ->from('formulario_contratacion')
                        ->whereNotNull('CURP');
                }
            )->get();

            foreach ($tabla as $value) {

                $value->BTN_CURP = '
                <button class="btn btn-outline-danger btn-custom rounded-pill pdf-button ver-archivo-curp"
                    data-id="' . $value->ID_BANCO_CV . '" title="Ver CURP">
                    <i class="bi bi-filetype-pdf"></i>
                </button>';

                $value->BTN_CV = '
                <button class="btn btn-outline-danger btn-custom rounded-pill pdf-button ver-archivo-cv"
                    data-id="' . $value->ID_BANCO_CV . '" title="Ver CV">
                    <i class="bi bi-filetype-pdf"></i>
                </button>';

                $value->BTN_ELIMINAR = '
                <button type="button" class="btn btn-danger btn-custom rounded-pill ELIMINAR">
                    <i class="bi bi-trash3-fill"></i>
                </button>';

                $value->BTN_EDITAR = '
                <button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR">
                    <i class="bi bi-eye-fill"></i>
                </button>';
            }

            return response()->json([
                'data' => $tabla,
                'msj'  => 'Información consultada correctamente'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'msj'  => 'Error: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }


    public function Tablacontratadobancocv()
    {
        try {

            $tabla = bancocvModel::query()
                ->join(
                    'formulario_contratacion',
                    'formulario_contratacion.CURP',
                    '=',
                    'formulario_bancocv.CURP_CV'
                )
                ->select('formulario_bancocv.*')
                ->get();

            foreach ($tabla as $value) {

                $value->BTN_CURP = '<button class="btn btn-outline-danger btn-custom rounded-pill pdf-button ver-archivo-curp"
                data-id="' . $value->ID_BANCO_CV . '" title="Ver CURP">
                <i class="bi bi-filetype-pdf"></i>
            </button>';

                $value->BTN_CV = '<button class="btn btn-outline-danger btn-custom rounded-pill pdf-button ver-archivo-cv"
                data-id="' . $value->ID_BANCO_CV . '" title="Ver CV">
                <i class="bi bi-filetype-pdf"></i>
            </button>';

                $value->BTN_ELIMINAR = '<button type="button"
                class="btn btn-danger btn-custom rounded-pill ELIMINAR">
                <i class="bi bi-trash3-fill"></i>
            </button>';

                $value->BTN_EDITAR = '<button type="button"
                class="btn btn-primary btn-custom rounded-pill EDITAR">
                <i class="bi bi-eye-fill"></i>
            </button>';
            }

            return response()->json([
                'data' => $tabla,
                'msj'  => 'Información consultada correctamente'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'msj'  => 'Error ' . $e->getMessage(),
                'data' => []
            ]);
        }
    }




    public function mostrarCurpCv($id)
{
    $archivo = bancocvModel::findOrFail($id)->ARCHIVO_CURP_CV;
    return Storage::response($archivo);
}

public function mostrarCv($id)
{
    $archivo = bancocvModel::findOrFail($id)->ARCHIVO_CV;
    return Storage::response($archivo);
}




public function store(Request $request)
{
    try {
        switch (intval($request->api)) {
            case 1:
                if ($request->ID_BANCO_CV == 0) {

                    $interes_admon = $request->INTERES_ADMINISTRATIVA ? $request->INTERES_ADMINISTRATIVA : [];
                    $interes_ope = $request->INTERES_OPERATIVAS ? $request->INTERES_OPERATIVAS : [];

                    DB::statement('ALTER TABLE formulario_bancocv AUTO_INCREMENT=1;');
                    $bancocvs = bancocvModel::create(array_merge($request->all(), [
                        'INTERES_ADMINISTRATIVA' => $interes_admon,
                        'INTERES_OPERATIVAS' => $interes_ope,
                    ]));

                } else {
                    if (!isset($request->ELIMINAR)) {
                        $bancocvs = bancocvModel::find($request->ID_BANCO_CV);

                        $interes_admon = $request->INTERES_ADMINISTRATIVA ? $request->INTERES_ADMINISTRATIVA : [];
                        $interes_ope = $request->INTERES_OPERATIVAS ? $request->INTERES_OPERATIVAS : [];

                        $bancocvs->update(array_merge($request->all(), [
                            'INTERES_ADMINISTRATIVA' => $interes_admon,
                            'INTERES_OPERATIVAS' => $interes_ope,
                        ]));

                    } else {
                        bancocvModel::where('ID_BANCO_CV', $request->ID_BANCO_CV)->delete();
                        $response['code'] = 1;
                        $response['bancocv'] = 'Eliminada';
                        return response()->json($response);
                    }
                }

                $identificador = $request->CURP_CV ? $request->CURP_CV : 'extranjero_' . time(); 
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

                $bancocvs->save();

                $response['code'] = 1;
                $response['bancocv'] = $bancocvs;
                return response()->json($response);
                break;

            default:
                $response['code'] = 0;
                $response['msj'] = 'Api no encontrada';
                return response()->json($response);
        }
    } catch (Exception $e) {
        return response()->json(['code' => 0, 'msj' => 'Error al guardar la información', 'error' => $e->getMessage()]);
    }
}




}
