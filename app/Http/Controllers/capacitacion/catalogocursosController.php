<?php

namespace App\Http\Controllers\capacitacion;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;

use DB;


//Modelos

use App\Models\capacitacion\tipocursoModel;
use App\Models\capacitacion\areaconocimientoModel;
use App\Models\capacitacion\modalidadModel;
use App\Models\capacitacion\formatoModel;
use App\Models\capacitacion\paisregionModel;
use App\Models\capacitacion\idiomaModel;
use App\Models\capacitacion\normatividadModel;
use App\Models\capacitacion\reconocimientoModel;
use App\Models\capacitacion\competenciaModel;
use App\Models\capacitacion\tipoproveedorModel;
use App\Models\capacitacion\metodoevaluacionModel;
use App\Models\capacitacion\evidenciageneradaModel;
use App\Models\capacitacion\ubicacionModel;
use App\Models\capacitacion\materialdidacticoModel;
use App\Models\capacitacion\impactoesparadoModel;
use App\Models\organizacion\catalogocategoriaModel;
use App\Models\capacitacion\cursosModel;
use App\Models\capacitacion\documentosemitidosModel;
use App\Models\capacitacion\monedaModel;
use App\Models\capacitacion\lineanegocioModel;



class catalogocursosController extends Controller
{


    public function index()
    {

        $categorias = catalogocategoriaModel::where('ACTIVO', 1)->get();
        $tipocurso = tipocursoModel::where('ACTIVO', 1)->get();
        $areaconocimiento = areaconocimientoModel::where('ACTIVO', 1)->get();
        $modalidad = modalidadModel::where('ACTIVO', 1)->get();
        $formato = formatoModel::where('ACTIVO', 1)->get();
        $paisregion = paisregionModel::where('ACTIVO', 1)->get();
        $idioma = idiomaModel::where('ACTIVO', 1)->get();
        $normatividad = normatividadModel::where('ACTIVO', 1)->get();
        $reconocimiento = reconocimientoModel::where('ACTIVO', 1)->get();
        $competencia = competenciaModel::where('ACTIVO', 1)->get();
        $tipoproveedor = tipoproveedorModel::where('ACTIVO', 1)->get();
        $metodoevaluacion = metodoevaluacionModel::where('ACTIVO', 1)->get();
        $evidenciageneradas = evidenciageneradaModel::where('ACTIVO', 1)->get();
        $ubicacion = ubicacionModel::where('ACTIVO', 1)->get();
        $materialesdidactico = materialdidacticoModel::where('ACTIVO', 1)->get();
        $impactoesperado = impactoesparadoModel::where('ACTIVO', 1)->get();
        $docemitido = documentosemitidosModel::where('ACTIVO', 1)->get();
        $moneda = monedaModel::where('ACTIVO', 1)->get();
        $lineas = lineanegocioModel::where('ACTIVO', 1)->get();



        return view('RH.capacitacion.catalogos.catalogocursos', compact('tipocurso', 'areaconocimiento', 'modalidad', 'formato', 'paisregion', 'idioma', 'normatividad', 'reconocimiento', 'competencia', 'tipoproveedor', 'metodoevaluacion', 'evidenciageneradas', 'ubicacion', 'materialesdidactico', 'impactoesperado', 'categorias', 'docemitido','moneda', 'lineas'));
    }


    public function Tablacapcursos()
    {
        try {
            $tabla = cursosModel::get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_CURSOS_CAPACITACION . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_CURSOS_CAPACITACION . '" checked><span class="slider round"></span></label>';
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


    public function generarCodigoCurso(Request $request)
    {
        $tipo = $request->TIPO_ID;

        if (!$tipo) {
            return response()->json(['codigo' => null]);
        }

        $prefijos = [
            1 => 'H-TE-',
            2 => 'H-HU-',
            3 => 'H-SA-',
            4 => 'H-SE-',
            5 => 'H-MA-',
            6 => 'H-CA-',
        ];

        $prefijo = $prefijos[$tipo] ?? null;

        if (!$prefijo) {
            return response()->json(['codigo' => null]);
        }

        $ultimo = DB::table('capacitacion_cursos')
            ->where('TIPO_ID', $tipo)
            ->whereNotNull('NUMERO_ID')
            ->orderByDesc('ID_CURSOS_CAPACITACION')
            ->value('NUMERO_ID');

        if ($ultimo) {

            $numero = (int) substr($ultimo, -3);
            $nuevoNumero = $numero + 1;
        } else {

            $nuevoNumero = 1;
        }

        $consecutivo = str_pad($nuevoNumero, 3, '0', STR_PAD_LEFT);

        $codigoFinal = $prefijo . $consecutivo;

        return response()->json([
            'codigo' => $codigoFinal
        ]);
    }

    public function store(Request $request)
    {

        try {
            switch (intval($request->api)) {

                case 1:

                    try {

                        $camposArray = [
                            'CATEGORIAS_CURSO',
                            'TIPO_CURSO',
                            'AREA_CONOCIMIENTO',
                            'NIVELES_CURSO',
                            'MODALIDAD_CURSO',
                            'FORMATO_CURSO',
                            'PAISREGION_CURSO',
                            'IDIOMAS_CURSO',
                            'NORMATIVA_CURSO',
                            'RECONOCIMIENTO_CURSO',
                            'COMPETENCIAS_CURSO',
                            'TIPO_PROVEEDOR',
                            'METODO_EVALUACION',
                            'EVIDENCIAS_GENERADAS',
                            'DOCUMENTOS_EMITIDOS',
                            'UBICACION_CURSO',
                            'MATERIAL_DIDACTICO',
                            'IMPACTO_ESPERADO',
                        ];

                        foreach ($camposArray as $campo) {
                            if (!isset($request[$campo]) || empty($request[$campo])) {
                                $request[$campo] = null;
                            }
                        }

                      
                        if ($request->ID_CURSOS_CAPACITACION == 0) {

                            DB::statement('ALTER TABLE capacitacion_cursos AUTO_INCREMENT=1;');

                            $capacitacion = cursosModel::create($request->all());

                            $response['code'] = 1;
                            $response['capacitaciones'] = $capacitacion;
                        }

                     
                        else {

                            if (isset($request->ELIMINAR)) {

                                if ($request->ELIMINAR == 1) {

                                    cursosModel::where('ID_CURSOS_CAPACITACION', $request->ID_CURSOS_CAPACITACION)
                                        ->update(['ACTIVO' => 0]);

                                    $response['code'] = 1;
                                    $response['capacitaciones'] = 'Desactivada';
                                } else {

                                    cursosModel::where('ID_CURSOS_CAPACITACION', $request->ID_CURSOS_CAPACITACION)
                                        ->update(['ACTIVO' => 1]);

                                    $response['code'] = 1;
                                    $response['capacitaciones'] = 'Activada';
                                }
                            } else {

                                $capacitacion = cursosModel::findOrFail($request->ID_CURSOS_CAPACITACION);

                                $capacitacion->update($request->all());

                                $response['code'] = 1;
                                $response['capacitaciones'] = 'Actualizada';
                            }
                        }

                        return response()->json($response);
                    } catch (\Exception $e) {

                        return response()->json([
                            'code' => 0,
                            'error' => $e->getMessage()
                        ]);
                    }

                    break;

                default:

                    $response['code']  = 1;
                    $response['msj']  = 'Api no encontrada';
                    return response()->json($response);
            }
        } catch (Exception $e) {

            return response()->json('Error al guardar las funciones');
        }
    }




    }
