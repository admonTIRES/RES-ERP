<?php

namespace App\Http\Controllers\seleccion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Artisan;
use Exception;
use App\Models\selección\seleccionModel;
use App\Models\selección\seleccionpptModel;
use App\Models\selección\cursospptseleccionModel;
use App\Models\selección\entrevistaseleccionModel;
use App\Models\selección\autorizacionseleccionModel;
use App\Models\selección\inteligenciaseleccionModel;
use App\Models\selección\buroseleccionModel;
use App\Models\selección\referenciaseleccionModel;
use App\Models\selección\referenciasempresasModel;

use App\Models\selección\pruebaseleccionModel;
use App\Models\selección\referenciaspruebaseleccionModel;


use App\Models\pendientecontratar\pendientecontratarModel;

use App\Models\capacitacion\brechacompeModel;



use App\Models\organizacion\catalogoexperienciaModel;
use App\Models\selección\catalogopruebasconocimientosModel;

use DB;


class seleccionController extends Controller
{
    


    public function index()
    {
        $areas = DB::select("
            SELECT DISTINCT cat.ID_CATALOGO_CATEGORIA AS ID, cat.NOMBRE_CATEGORIA AS NOMBRE
            FROM catalogo_categorias cat
            INNER JOIN catalogo_vacantes vac ON vac.CATEGORIA_VACANTE = cat.ID_CATALOGO_CATEGORIA
            WHERE cat.ACTIVO = 1
        ");

        $puesto = catalogoexperienciaModel::orderBy('NOMBRE_PUESTO', 'ASC')->get();
        $pruebas = catalogopruebasconocimientosModel::orderBy('NOMBRE_PRUEBA', 'ASC')->get();

        return view('RH.Selección.seleccion', compact('areas','puesto','pruebas'));
    }

    public function index2()
    {
        $areas = DB::select("
            SELECT DISTINCT cat.ID_CATALOGO_CATEGORIA AS ID, cat.NOMBRE_CATEGORIA AS NOMBRE
            FROM catalogo_categorias cat
            INNER JOIN catalogo_vacantes vac ON vac.CATEGORIA_VACANTE = cat.ID_CATALOGO_CATEGORIA
            WHERE cat.ACTIVO = 1
        ");

        $puesto = catalogoexperienciaModel::orderBy('NOMBRE_PUESTO', 'ASC')->get();
        $pruebas = catalogopruebasconocimientosModel::orderBy('NOMBRE_PRUEBA', 'ASC')->get();

        return view('RH.Selección.visualizarseleccion', compact('areas', 'puesto', 'pruebas'));
    }


    // public function Tablaseleccion()
    // {
    //     try {

    //         $vacantes = DB::select("
    //         SELECT vac.*, 
    //                vac.ID_CATALOGO_VACANTE AS VACANTES_ID,
    //                cat.NOMBRE_CATEGORIA
    //         FROM catalogo_vacantes vac
    //         LEFT JOIN catalogo_categorias cat 
    //             ON cat.ID_CATALOGO_CATEGORIA = vac.CATEGORIA_VACANTE
    //         WHERE vac.ACTIVO = 1
    //         AND (
    //             vac.FECHA_EXPIRACION >= CURDATE()
    //             OR EXISTS (
    //                 SELECT 1
    //                 FROM formulario_seleccion fs
    //                 WHERE fs.VACANTES_ID = vac.ID_CATALOGO_VACANTE
    //                 AND fs.ACTIVO = 1
    //             )
    //         )
    //     ");

    //         foreach ($vacantes as $vacante) {

    //             $postulados = DB::table('formulario_seleccion')
    //                 ->where('VACANTES_ID', $vacante->VACANTES_ID)
    //                 ->where('ACTIVO', 1)
    //                 ->select(
    //                     'NOMBRE_SELC',
    //                     'PRIMER_APELLIDO_SELEC',
    //                     'SEGUNDO_APELLIDO_SELEC'
    //                 )
    //                 ->get();

    //             $listaPostulados = '<ul>';
    //             foreach ($postulados as $postulado) {
    //                 $nombreCompleto =
    //                     "{$postulado->NOMBRE_SELC} {$postulado->PRIMER_APELLIDO_SELEC} {$postulado->SEGUNDO_APELLIDO_SELEC}";
    //                 $listaPostulados .= "<li>{$nombreCompleto}</li>";
    //             }
    //             $listaPostulados .= '</ul>';

    //             $vacante->POSTULADOS = $listaPostulados;
    //         }

    //         return response()->json([
    //             'data' => $vacantes,
    //             'msj' => 'Información consultada correctamente'
    //         ]);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'msj' => 'Error ' . $e->getMessage(),
    //             'data' => []
    //         ]);
    //     }
    // }





    // public function Tablaseleccion2Visualizar()
    // {
    //     try {
    //         $vacantes = DB::select("
    //         SELECT vac.*, 
    //                vac.ID_CATALOGO_VACANTE AS VACANTES_ID,
    //                cat.NOMBRE_CATEGORIA
    //         FROM catalogo_vacantes vac
    //         LEFT JOIN catalogo_categorias cat ON cat.ID_CATALOGO_CATEGORIA = vac.CATEGORIA_VACANTE
    //         WHERE vac.ACTIVO = 1
    //     ");

    //         foreach ($vacantes as $vacante) {
    //             $postulados = DB::table('formulario_seleccion')
    //             ->where('VACANTES_ID', $vacante->VACANTES_ID)
    //                 ->where('ACTIVO', 0)
    //                 ->select('NOMBRE_SELC', 'PRIMER_APELLIDO_SELEC', 'SEGUNDO_APELLIDO_SELEC')
    //                 ->get();

    //             $listaPostulados = "<ul>";
    //             foreach ($postulados as $postulado) {
    //                 $nombreCompleto = "{$postulado->NOMBRE_SELC} {$postulado->PRIMER_APELLIDO_SELEC} {$postulado->SEGUNDO_APELLIDO_SELEC}";
    //                 $listaPostulados .= "<li>{$nombreCompleto}</li>";
    //             }
    //             $listaPostulados .= "</ul>";

    //             $vacante->POSTULADOS = $listaPostulados;
    //         }

    //         return response()->json([
    //                 'data' => $vacantes,
    //                 'msj' => 'Información consultada correctamente'
    //             ]);
    //     } catch (Exception $e) {
    //         return response()->json([
    //                 'msj' => 'Error ' . $e->getMessage(),
    //                 'data' => []
    //             ]);
    //     }
    // }




    public function Tablaseleccion()
    {
        try {

            $vacantes = DB::select("
            SELECT vac.*, 
                   vac.ID_CATALOGO_VACANTE AS VACANTES_ID,
                   cat.NOMBRE_CATEGORIA
            FROM catalogo_vacantes vac
            LEFT JOIN catalogo_categorias cat 
                ON cat.ID_CATALOGO_CATEGORIA = vac.CATEGORIA_VACANTE
            WHERE vac.ACTIVO = 1
            AND (
                vac.FECHA_EXPIRACION >= CURDATE()
                OR EXISTS (
                    SELECT 1
                    FROM formulario_seleccion fs
                    WHERE fs.VACANTES_ID = vac.ID_CATALOGO_VACANTE
                    AND fs.ACTIVO = 1
                )
            )
            ORDER BY vac.FECHA_EXPIRACION DESC
        ");

            foreach ($vacantes as $vacante) {

                $postulados = DB::table('formulario_seleccion')
                    ->where('VACANTES_ID', $vacante->VACANTES_ID)
                    ->where('ACTIVO', 1)
                    ->select(
                        'NOMBRE_SELC',
                        'PRIMER_APELLIDO_SELEC',
                        'SEGUNDO_APELLIDO_SELEC'
                    )
                    ->get();

                $listaPostulados = '<ul>';
                foreach ($postulados as $postulado) {
                    $nombreCompleto =
                        "{$postulado->NOMBRE_SELC} {$postulado->PRIMER_APELLIDO_SELEC} {$postulado->SEGUNDO_APELLIDO_SELEC}";
                    $listaPostulados .= "<li>{$nombreCompleto}</li>";
                }
                $listaPostulados .= '</ul>';

                $vacante->POSTULADOS = $listaPostulados;
            }

            return response()->json([
                'data' => $vacantes,
                'msj' => 'Información consultada correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'msj' => 'Error ' . $e->getMessage(),
                'data' => []
            ]);
        }
    }


    public function Tablaseleccion2Visualizar()
    {
        try {
            $vacantes = DB::select("
            SELECT vac.*, 
                   vac.ID_CATALOGO_VACANTE AS VACANTES_ID,
                   cat.NOMBRE_CATEGORIA
            FROM catalogo_vacantes vac
            LEFT JOIN catalogo_categorias cat 
                ON cat.ID_CATALOGO_CATEGORIA = vac.CATEGORIA_VACANTE
            WHERE vac.ACTIVO = 1
            ORDER BY vac.FECHA_EXPIRACION DESC
        ");

            foreach ($vacantes as $vacante) {

                $postulados = DB::table('formulario_seleccion')
                    ->where('VACANTES_ID', $vacante->VACANTES_ID)
                    ->where('ACTIVO', 0)
                    ->select(
                        'NOMBRE_SELC',
                        'PRIMER_APELLIDO_SELEC',
                        'SEGUNDO_APELLIDO_SELEC'
                    )
                    ->get();

                $listaPostulados = "<ul>";
                foreach ($postulados as $postulado) {
                    $nombreCompleto = "{$postulado->NOMBRE_SELC} {$postulado->PRIMER_APELLIDO_SELEC} {$postulado->SEGUNDO_APELLIDO_SELEC}";
                    $listaPostulados .= "<li>{$nombreCompleto}</li>";
                }
                $listaPostulados .= "</ul>";

                $vacante->POSTULADOS = $listaPostulados;
            }

            return response()->json([
                'data' => $vacantes,
                'msj' => 'Información consultada correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'msj' => 'Error ' . $e->getMessage(),
                'data' => []
            ]);
        }
    }

    
/// MANDAR A PENDINENTE POR CONTRATAR 


public function guardarPendiente(Request $request)
{
    try {
        $curp = $request->input('CURP');
        $nombre = $request->input('NOMBRE_PC');
        $primerApellido = $request->input('PRIMER_APELLIDO_PC');
        $segundoApellido = $request->input('SEGUNDO_APELLIDO_PC');
        $dia = $request->input('DIA_FECHA_PC');
        $mes = $request->input('MES_FECHA_PC');
        $anio = $request->input('ANIO_FECHA_PC');
        $vacanteId = $request->input('VACANTE_ID');
        pendientecontratarModel::create([
            'CURP' => $curp,
            'NOMBRE_PC' => $nombre,
            'PRIMER_APELLIDO_PC' => $primerApellido,
            'SEGUNDO_APELLIDO_PC' => $segundoApellido,
            'DIA_FECHA_PC' => $dia,
            'MES_FECHA_PC' => $mes,
            'ANIO_FECHA_PC' => $anio,
            'VACANTE_ID' => $vacanteId 
        ]);

        seleccionModel::where('CURP', $curp)->update(['ACTIVO' => 0]);

        return response()->json([
            'status' => 'success',
            'message' => 'Registro guardado y actualizado correctamente.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Hubo un error al guardar el registro.',
            'error' => $e->getMessage()
        ]);
    }
}





public function Tablapptseleccion(Request $request)
{
    try {

        $curp = $request->get('curp');

        $tabla = DB::select('SELECT ppt.*, cat.NOMBRE_CATEGORIA
                             FROM seleccion_ppt ppt
                             LEFT JOIN catalogo_categorias cat ON cat.ID_CATALOGO_CATEGORIA = ppt.DEPARTAMENTO_AREA_ID
                             WHERE ppt.CURP = ?', [$curp]);

        foreach ($tabla as $key => $value) {

            $cursos = cursospptseleccionModel::where('SELECCION_PPT_ID', $value->ID_PPT_SELECCION)->get();
               $value->CURSOS = $cursos;

            if ($value->ACTIVO == 0) {
                $value->BTN_EDITAR = '<button type="button" class="btn btn-secundary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
            } else {
                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
            }
        }

        $dato['data'] = $tabla;
        $dato["msj"] = 'Información consultada correctamente';
        return response()->json($dato);
    } catch (Exception $e) {
        $dato["msj"] = 'Error ' . $e->getMessage();
        $dato['data'] = 0;
        return response()->json($dato);
    }
}







public function Tablaentrevistaseleccion(Request $request)
{
    try {
        $curp = $request->get('curp');

        $tabla = entrevistaseleccionModel::where('CURP', $curp)->get();

        foreach ($tabla as $value) {
            if ($value->ACTIVO == 0) {
                $value->BTN_EDITAR = '<button type="button" class="btn btn-secundary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
            } else {
                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
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


public function Tablaautorizacion(Request $request)
{
    try {
        $curp = $request->get('curp');
        $tabla = autorizacionseleccionModel::where('CURP', $curp)->get();

        foreach ($tabla as $value) {
         
                if ($value->ARCHIVO_AUTORIZACION) {
                    $value->BTN_ARCHIVO = '<button type="button" class="btn btn-info btn-custom rounded-pill btn-ver-pdf" data-curp="' . $value->CURP . '"><i class="bi bi-eye"></i> Ver archivo</button>';
                } else {
                    $value->BTN_ARCHIVO = '<button type="button" class="btn btn-secondary btn-custom rounded-pill" disabled><i class="bi bi-file-earmark-excel"></i> Sin archivo</button>';
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




public function visualizarArchivo($curp)
{
    $autorizacion = autorizacionseleccionModel::where('CURP', $curp)->first();

    if ($autorizacion && Storage::exists($autorizacion->ARCHIVO_AUTORIZACION)) {
        $filePath = storage_path('app/' . $autorizacion->ARCHIVO_AUTORIZACION);
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.basename($filePath).'"'
        ]);
    } else {
        return response()->json(['error' => 'Archivo no encontrado'], 404);
    }
}




public function Tablainteligencia(Request $request)
{
    try {
        $curp = $request->get('curp');
        $tabla = inteligenciaseleccionModel::where('CURP', $curp)->get();

        foreach ($tabla as $value) {
            if ($value->ACTIVO == 0) {
                
                
                $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                $value->BTN_COMPLETO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-completo" data-id="' . $value->ID_INTELIGENCIA_SELECCION . '" title="Ver COMPLETO"> <i class="bi bi-filetype-pdf"></i></button>';
                $value->BTN_COMPETENCIAS = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-competencias" data-id="' . $value->ID_INTELIGENCIA_SELECCION . '" title="Ver COMPETENCIAS"> <i class="bi bi-filetype-pdf"></i></button>';
    
            } else {
                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                $value->BTN_COMPLETO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-completo" data-id="' . $value->ID_INTELIGENCIA_SELECCION . '" title="Ver COMPLETO"> <i class="bi bi-filetype-pdf"></i></button>';
                $value->BTN_COMPETENCIAS = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-competencias" data-id="' . $value->ID_INTELIGENCIA_SELECCION . '" title="Ver COMPETENCIAS"> <i class="bi bi-filetype-pdf"></i></button>';
    
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


public function mostrarcompetencias($id)
{
    $archivo = inteligenciaseleccionModel::findOrFail($id)->ARCHIVO_COMPETENCIAS;
    return Storage::response($archivo);
}

public function mostrarcompleto($id)
{
    $archivo = inteligenciaseleccionModel::findOrFail($id)->ARCHIVO_COMPLETO;
    return Storage::response($archivo);
}




public function Tablaburo(Request $request)
{
    try {
        $curp = $request->get('curp');

        $tabla = buroseleccionModel::where('CURP', $curp)->get();

        foreach ($tabla as $value) {
            if ($value->ACTIVO == 0) {
                $value->BTN_EDITAR = '<button type="button" class="btn btn-secundary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-buro" data-id="' . $value->ID_BURO_SELECCION . '" title="Ver buro"> <i class="bi bi-filetype-pdf"></i></button>';

            } else {
                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-buro" data-id="' . $value->ID_BURO_SELECCION . '" title="Ver buro"> <i class="bi bi-filetype-pdf"></i></button>';

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


public function mostrarburo($id)
{
    $archivo = buroseleccionModel::findOrFail($id)->ARCHIVO_RESULTADO;
    return Storage::response($archivo);
}




public function Tablareferencia(Request $request)
{
    try {
        $curp = $request->get('curp');

        $tabla = referenciaseleccionModel::where('CURP', $curp)->get();

        $rows = [];

        foreach ($tabla as $value) {
            $referencias = referenciasempresasModel::where('SELECCION_REFERENCIA_ID', $value->ID_REFERENCIAS_SELECCION)->get();

            $referenciasAgrupadas = [];
            foreach ($referencias as $referencia) {
                $referenciasAgrupadas[] = [
                    'NOMBRE_EMPRESA' => $referencia->NOMBRE_EMPRESA,
                    'COMENTARIO' => $referencia->COMENTARIO,
                    'CUMPLE' => $referencia->CUMPLE,
                    'ARCHIVO_RESULTADO' => $referencia->ARCHIVO_RESULTADO,
                    'BTN_DOCUMENTO' => '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-referencias" data-id="' . $referencia->ID_LABORAL_SELECCION . '" title="Ver referencias"> <i class="bi bi-filetype-pdf"></i></button>'
                ];
            }

            $rows[] = [
                'ID_REFERENCIAS_SELECCION' => $value->ID_REFERENCIAS_SELECCION,
                'EXPERIENCIA_LABORAL' => $value->EXPERIENCIA_LABORAL,
                'PORCENTAJE_TOTAL_REFERENCIAS' => $value->PORCENTAJE_TOTAL_REFERENCIAS,
                'REFERENCIAS' => $referenciasAgrupadas, 
                'BTN_EDITAR' => ($value->ACTIVO == 0) ? 
                    '<button type="button" class="btn btn-secundary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>' :
                    '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>',
            ];
        }

        return response()->json([
            'data' => $rows,
            'msj' => 'Información consultada correctamente'
        ]);
    } catch (Exception $e) {
        return response()->json([
            'msj' => 'Error ' . $e->getMessage(),
            'data' => 0
        ]);
    }
}


public function mostrareferencias($id)
{
    $archivo = referenciasempresasModel::findOrFail($id)->ARCHIVO_RESULTADO;
    return Storage::response($archivo);
}


public function Tablapruebaconocimientoseleccion(Request $request)
{
    try {
        $curp = $request->get('curp');

        $tabla = pruebaseleccionModel::where('CURP', $curp)->get();

        $rows = [];

        foreach ($tabla as $value) {
            $referencias = referenciaspruebaseleccionModel::where('SELECCION_PRUEBAS_ID', $value->ID_PRUEBAS_SELECCION)->get();

            $referenciasAgrupadas = [];
            foreach ($referencias as $referencia) {
                $referenciasAgrupadas[] = [
                    'TIPO_PRUEBA' => $referencia->TIPO_PRUEBA,
                    'PORCENTAJE_PRUEBA' => $referencia->PORCENTAJE_PRUEBA,
                    'TOTAL_PORCENTAJE' => $referencia->TOTAL_PORCENTAJE,
                    'ARCHIVO_RESULTADO' => $referencia->ARCHIVO_RESULTADO,
                    'BTN_DOCUMENTO' => '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-pruebas" data-id="' . $referencia->ID_REFERENCIASPRUEBAS_SELECCION . '" title="Ver prueba"> <i class="bi bi-filetype-pdf"></i></button>'
                ];
            }

            $rows[] = [
                'ID_PRUEBAS_SELECCION' => $value->ID_PRUEBAS_SELECCION,
                'REQUIERE_PRUEBAS' => $value->REQUIERE_PRUEBAS,
                'PORCENTAJE_TOTAL_PRUEBA' => $value->PORCENTAJE_TOTAL_PRUEBA,
                'REFERENCIAS' => $referenciasAgrupadas, 
                'BTN_EDITAR' => ($value->ACTIVO == 0) ? 
                    '<button type="button" class="btn btn-secundary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>' :
                    '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>',
            ];
        }

        return response()->json([
            'data' => $rows,
            'msj' => 'Información consultada correctamente'
        ]);
    } catch (Exception $e) {
        return response()->json([
            'msj' => 'Error ' . $e->getMessage(),
            'data' => 0
        ]);
    }
}


public function mostrarprueba($id)
{
    $archivo = referenciaspruebaseleccionModel::findOrFail($id)->ARCHIVO_RESULTADO;
    return Storage::response($archivo);
}





public function consultarSeleccion($vacantesId)
{
    $consultar = DB::table('formulario_seleccion')
        ->where('VACANTES_ID', $vacantesId)
        ->where('ACTIVO', 1)
        ->get();

    if ($consultar->isEmpty()) {
        return response()->json([
            'data' => [],
            'message' => 'No hay información relacionada para esta vacante.'
        ]);
    }

    foreach ($consultar as $persona) {
        $curp = $persona->CURP;

        $inteligencia = DB::table('seleccion_inteligencia')->where('CURP', $curp)->value('RIESGO_PORCENTAJE');
        $buroLaboral = DB::table('seleccion_buro_laboral')->where('CURP', $curp)->value('PORCENTAJE_TOTAL');
        $ppt = DB::table('seleccion_ppt')->where('CURP', $curp)->value('SUMA_TOTAL');
        $referenciasLaboral = DB::table('seleccion_referencias_laboral')->where('CURP', $curp)->value('PORCENTAJE_TOTAL_REFERENCIAS');
        $experienciaLaboral = DB::table('seleccion_referencias_laboral')->where('CURP', $curp)->value('EXPERIENCIA_LABORAL');
        $pruebaConocimiento = DB::table('seleccion_prueba_conocimiento')->where('CURP', $curp)->value('PORCENTAJE_TOTAL_PRUEBA');
        $entrevista = DB::table('seleccion_entrevista')->where('CURP', $curp)->value('PORCENTAJE_ENTREVISTA');

        if (is_null($inteligencia) || is_null($buroLaboral) || is_null($ppt) || is_null($referenciasLaboral) || is_null($pruebaConocimiento) || is_null($entrevista)) {
            $persona->PORCENTAJE_INTELIGENCIA = '**';
            $persona->PORCENTAJE_BURO = '**';
            $persona->PORCENTAJE_PPT = '**';
            $persona->PORCENTAJE_REFERENCIAS = '**';
            $persona->PORCENTAJE_PRUEBA = '**';
            $persona->PORCENTAJE_ENTREVISTA = '**';
            $persona->TOTAL = '**';
        } else {
            if ($experienciaLaboral == 'SI') {
                $porcentajes = [
                    'inteligencia' => 0.20,
                    'buroLaboral' => 0.15,
                    'ppt' => 0.15,
                    'referenciasLaboral' => 0.10,
                    'pruebaConocimiento' => 0.10,
                    'entrevista' => 0.30
                ];
            } else {
                $porcentajes = [
                    'inteligencia' => 0.20,
                    'buroLaboral' => 0.15,
                    'ppt' => 0.20,
                    'referenciasLaboral' => 0.00,
                    'pruebaConocimiento' => 0.10,
                    'entrevista' => 0.35
                ];
            }

            $total = round(
                ($inteligencia * $porcentajes['inteligencia']) +
                ($buroLaboral * $porcentajes['buroLaboral']) +
                ($ppt * $porcentajes['ppt']) +
                ($referenciasLaboral * $porcentajes['referenciasLaboral']) +
                ($pruebaConocimiento * $porcentajes['pruebaConocimiento']) +
                ($entrevista * $porcentajes['entrevista'])
            );

            $persona->PORCENTAJE_INTELIGENCIA = $inteligencia;
            $persona->PORCENTAJE_BURO = $buroLaboral;
            $persona->PORCENTAJE_PPT = $ppt;
            $persona->PORCENTAJE_REFERENCIAS = $referenciasLaboral;
            $persona->PORCENTAJE_PRUEBA = $pruebaConocimiento;
            $persona->PORCENTAJE_ENTREVISTA = $entrevista;
            $persona->TOTAL = $total;  
        }
    }

    return response()->json([
        'data' => $consultar
    ]);
}



    public function noSeleccionar(Request $request)
    {
        try {

            if (!$request->filled('ID_FORMULARIO_SELECCION')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'ID no recibido.'
                ]);
            }

            $registro = DB::table('formulario_seleccion')
                ->where('ID_FORMULARIO_SELECCION', $request->ID_FORMULARIO_SELECCION)
                ->first();

            if (!$registro) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Registro no encontrado.'
                ]);
            }

            DB::table('formulario_seleccion')
                ->where('ID_FORMULARIO_SELECCION', $request->ID_FORMULARIO_SELECCION)
                ->update([
                    'ACTIVO' => 0,
                    'NO_CONTRATAR' => 1,
                    'JUSTIFICACION' => $request->JUSTIFICACION,
                    'updated_at' => now()
                ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Registro actualizado correctamente.'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage() 
            ]);
        }
    }



    public function consultarSeleccion2Visualizar($vacantesId)
{
    $consultar = DB::table('formulario_seleccion')
        ->where('VACANTES_ID', $vacantesId)
        ->where('ACTIVO', 0)
        ->get();

    if ($consultar->isEmpty()) {
        return response()->json([
                'data' => [],
                'message' => 'No hay información relacionada para esta vacante.'
            ]);
    }

    foreach ($consultar as $persona) {
        $curp = $persona->CURP;

        $inteligencia = DB::table('seleccion_inteligencia')->where('CURP', $curp)->value('RIESGO_PORCENTAJE');
        $buroLaboral = DB::table('seleccion_buro_laboral')->where('CURP', $curp)->value('PORCENTAJE_TOTAL');
        $ppt = DB::table('seleccion_ppt')->where('CURP', $curp)->value('SUMA_TOTAL');
        $referenciasLaboral = DB::table('seleccion_referencias_laboral')->where('CURP', $curp)->value('PORCENTAJE_TOTAL_REFERENCIAS');
        $experienciaLaboral = DB::table('seleccion_referencias_laboral')->where('CURP', $curp)->value('EXPERIENCIA_LABORAL');
        $pruebaConocimiento = DB::table('seleccion_prueba_conocimiento')->where('CURP', $curp)->value('PORCENTAJE_TOTAL_PRUEBA');
        $entrevista = DB::table('seleccion_entrevista')->where('CURP', $curp)->value('PORCENTAJE_ENTREVISTA');

        if (is_null($inteligencia) || is_null($buroLaboral) || is_null($ppt) || is_null($referenciasLaboral) || is_null($pruebaConocimiento) || is_null($entrevista)) {
            $persona->PORCENTAJE_INTELIGENCIA = '**';
            $persona->PORCENTAJE_BURO = '**';
            $persona->PORCENTAJE_PPT = '**';
            $persona->PORCENTAJE_REFERENCIAS = '**';
            $persona->PORCENTAJE_PRUEBA = '**';
            $persona->PORCENTAJE_ENTREVISTA = '**';
            $persona->TOTAL = '**';
        } else {
            if ($experienciaLaboral == 'SI') {
                $porcentajes = [
                    'inteligencia' => 0.20,
                    'buroLaboral' => 0.15,
                    'ppt' => 0.15,
                    'referenciasLaboral' => 0.10,
                    'pruebaConocimiento' => 0.10,
                    'entrevista' => 0.30
                ];
            } else {
                $porcentajes = [
                    'inteligencia' => 0.20,
                    'buroLaboral' => 0.15,
                    'ppt' => 0.20,
                    'referenciasLaboral' => 0.00,
                    'pruebaConocimiento' => 0.10,
                    'entrevista' => 0.35
                ];
            }

            $total = round(
                ($inteligencia * $porcentajes['inteligencia']) +
                ($buroLaboral * $porcentajes['buroLaboral']) +
                ($ppt * $porcentajes['ppt']) +
                    ($referenciasLaboral * $porcentajes['referenciasLaboral']) +
                    ($pruebaConocimiento * $porcentajes['pruebaConocimiento']) +
                    ($entrevista * $porcentajes['entrevista'])
            );

            $persona->PORCENTAJE_INTELIGENCIA = $inteligencia;
            $persona->PORCENTAJE_BURO = $buroLaboral;
            $persona->PORCENTAJE_PPT = $ppt;
            $persona->PORCENTAJE_REFERENCIAS = $referenciasLaboral;
            $persona->PORCENTAJE_PRUEBA = $pruebaConocimiento;
            $persona->PORCENTAJE_ENTREVISTA = $entrevista;
            $persona->TOTAL = $total;
        }
    }

    return response()->json([
        'data' => $consultar
    ]);
}






public function obtenerRequerimientos($categoriaId)
{
    try {
        $requerimientos = DB::table('requerimientos_categorias')
            ->where('CATALOGO_CATEGORIAS_ID', $categoriaId)
            ->get();

        if ($requerimientos->isEmpty()) {
            return response()->json([
                'data' => [],
                'message' => 'No hay requerimientos asociados a esta categoría.'
            ]);
        }

        return response()->json([
            'data' => $requerimientos
        ]);
    } catch (Exception $e) {
        return response()->json([
            'error' => 'Error al obtener los requerimientos: ' . $e->getMessage()
        ], 500);
    }
}





public function consultarformppt($departamentoAreaId)
{
    $formulario = DB::table('formulario_ppt')
                    ->where('DEPARTAMENTO_AREA_ID', $departamentoAreaId)
                    ->first();

    if ($formulario) {
        $cursos = DB::table('cursos_ppt')
                    ->where('FORMULARIO_PPT_ID', $formulario->ID_FORMULARIO_PPT)
                    ->get();

        return response()->json([
            'formulario' => $formulario,
            'cursos' => $cursos
        ]);
    } else {
        return response()->json(['error' => 'No se encontró información.'], 404);
    }
}



public function mostrarPDF()
{
    $filePath = storage_path('app/Formatos/PS-RH-FO-02.pdf');
    
    if (file_exists($filePath)) {
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
        ]);
    } else {
        return response()->json(['error' => 'Archivo no encontrado'], 404);
    }
}



    




public function store(Request $request)
{

    try {
        switch (intval($request->api)) {

           
                case 1:

            if ($request->ID_PPT_SELECCION == 0) {

                DB::statement('ALTER TABLE seleccion_ppt AUTO_INCREMENT=1;');
                $PPT = seleccionpptModel::create($request->all());

                if ($request->CURSO_PPT) {
                    foreach ($request->CURSO_PPT as $key => $value) {
                        $num = $key + 1;
                        if ((!empty($request->CURSO_PPT[$key]))) {
                            $guardar_curso = cursospptseleccionModel::create([
                                'SELECCION_PPT_ID' => $PPT->ID_PPT_SELECCION,
                                'CURSO_PPT' => $value,
                                'CURSO_REQUERIDO' => isset($request->CURSO_REQUERIDO_PPT[$num]) ? $request->CURSO_REQUERIDO_PPT[$num] : null,
                                'CURSO_DESEABLE' => isset($request->CURSO_DESEABLE_PPT[$num]) ? $request->CURSO_DESEABLE_PPT[$num] : null,
                                'CURSO_CUMPLE_PPT' =>  isset($request->CURSO_CUMPLE_PPT[$num]) ? $request->CURSO_CUMPLE_PPT[$num] : null,
                                        'PORCENTAJE_CURSO' => isset($request->PORCENTAJE_CURSO[$num]) ? $request->PORCENTAJE_CURSO[$num] : null,

                                    ]);
                        }
                    }
                }

                if ($request->has('NOMBRE_BRECHA') && $request->has('BRECHA_JSON')) {
                    brechacompeModel::where('CURP', $request->CURP)->delete();
                    brechacompeModel::create([
                        'CURP' => $request->CURP,
                        'NOMBRE_BRECHA' => $request->NOMBRE_BRECHA,
                        'PORCENTAJE_FALTANTE' => $request->PORCENTAJE_FALTANTE ?? 0,
                        'BRECHA_JSON' => is_array($request->BRECHA_JSON) ? json_encode($request->BRECHA_JSON) : $request->BRECHA_JSON
                    ]);
                }

                $response['code']  = 1;
                $response['PPT']  = $PPT;
                return response()->json($response);

            } else {

                $eliminar_ppt = seleccionpptModel::where('ID_PPT_SELECCION', $request->ID_PPT_SELECCION)->delete();
                $PPT = seleccionpptModel::create($request->all());

                $eliminar_cursos = cursospptseleccionModel::where('SELECCION_PPT_ID', $request["ID_PPT_SELECCION"])->delete();

                if ($request->CURSO_PPT) {
                    foreach ($request->CURSO_PPT as $key => $value) {
                        $num = $key + 1;
                        if ((!empty($request->CURSO_PPT[$key]))) {
                            $guardar_curso = cursospptseleccionModel::create([
                                'SELECCION_PPT_ID' => $PPT->ID_PPT_SELECCION,
                                'CURSO_PPT' => $value,
                                'CURSO_REQUERIDO' => isset($request->CURSO_REQUERIDO_PPT[$num]) ? $request->CURSO_REQUERIDO_PPT[$num] : null,
                                'CURSO_DESEABLE' => isset($request->CURSO_DESEABLE_PPT[$num]) ? $request->CURSO_DESEABLE_PPT[$num] : null,
                                'CURSO_CUMPLE_PPT' =>  isset($request->CURSO_CUMPLE_PPT[$num]) ? $request->CURSO_CUMPLE_PPT[$num] : null,
                                'PORCENTAJE_CURSO' => isset($request->PORCENTAJE_CURSO[$num]) ? $request->PORCENTAJE_CURSO[$num] : null,

                                    ]);
                        }
                    }
                }

                if ($request->has('NOMBRE_BRECHA') && $request->has('BRECHA_JSON')) {
                    brechacompeModel::where('CURP', $request->CURP)->delete();
                    brechacompeModel::create([
                        'CURP' => $request->CURP,
                        'NOMBRE_BRECHA' => $request->NOMBRE_BRECHA,
                        'PORCENTAJE_FALTANTE' => $request->PORCENTAJE_FALTANTE ?? 0,
                        'BRECHA_JSON' => is_array($request->BRECHA_JSON) ? json_encode($request->BRECHA_JSON) : $request->BRECHA_JSON
                    ]);
                }

                $response['code']  = 1;
                $response['PPT']  = $PPT;
                return response()->json($response);
            }

            break;



                case 2:

    if ($request->ID_ENTREVISTA_SELECCION == 0) {
        DB::statement('ALTER TABLE seleccion_entrevista AUTO_INCREMENT=1;');
        $entrevistas = entrevistaseleccionModel::create($request->all());
    } else {
        if (!isset($request->ELIMINAR)) {
            $entrevistas = entrevistaseleccionModel::find($request->ID_ENTREVISTA_SELECCION);
            
            if ($request->hasFile('ARCHIVO_ENTREVISTA') && $entrevistas->ARCHIVO_ENTREVISTA) {
                Storage::delete($entrevistas->ARCHIVO_ENTREVISTA);
            }

            $entrevistas->update($request->all());
        } else {
            $entrevistas = entrevistaseleccionModel::where('ID_ENTREVISTA_SELECCION', $request['ID_ENTREVISTA_SELECCION'])->update(['ACTIVO' => 0]);
            $response['code'] = 1;
            $response['entrevista'] = 'Desactivada';
            return response()->json($response);
        }
    }

    if ($request->hasFile('ARCHIVO_ENTREVISTA')) {
        $curpFolder = 'reclutamiento/' . $request->CURP;
        $entrevistaFolder = $curpFolder . '/ENTREVISTA/';

        if (!Storage::exists($curpFolder)) {
            Storage::makeDirectory($curpFolder);
        }
        
        if (!Storage::exists($entrevistaFolder)) {
            Storage::makeDirectory($entrevistaFolder);
        }

        $entrevistaFile = $request->file('ARCHIVO_ENTREVISTA');
        $entrevistaFileName = 'ENTREVISTA_' . $request->CURP . '.' . $entrevistaFile->getClientOriginalExtension();
        $entrevistaFile->storeAs($entrevistaFolder, $entrevistaFileName);

        $entrevistas->ARCHIVO_ENTREVISTA = $entrevistaFolder . $entrevistaFileName;
        $entrevistas->save();
    }

    $response['code'] = 1;
    $response['entrevista'] = $entrevistas;
    return response()->json($response);

    break;


case 3:
    if ($request->ID_AUTORIZACION_SELECCION == 0) {
        DB::statement('ALTER TABLE seleccion_autorizacion AUTO_INCREMENT=1;');
        $autorizaciones = autorizacionseleccionModel::create($request->all());
    } else {
        if (!isset($request->ELIMINAR)) {
            $autorizaciones = autorizacionseleccionModel::find($request->ID_AUTORIZACION_SELECCION);
            
            if ($request->hasFile('ARCHIVO_AUTORIZACION') && $autorizaciones->ARCHIVO_AUTORIZACION) {
                Storage::delete($autorizaciones->ARCHIVO_AUTORIZACION);
            }

            $autorizaciones->update($request->all());
        } else {
            $autorizaciones = autorizacionseleccionModel::where('ID_AUTORIZACION_SELECCION', $request['ID_AUTORIZACION_SELECCION'])->update(['ACTIVO' => 0]);
            $response['code'] = 1;
            $response['autorizacion'] = 'Desactivada';
            return response()->json($response);
        }
    }

            if ($request->hasFile('ARCHIVO_AUTORIZACION')) {
            $curpFolder = 'reclutamiento/' . $request->CURP;
            $autorizacionFolder = $curpFolder . '/AUTORIZACION/';

            if (!Storage::exists($curpFolder)) {
                Storage::makeDirectory($curpFolder);
            }

            if (!Storage::exists($autorizacionFolder)) {
                Storage::makeDirectory($autorizacionFolder);
            }

            $autorizacionFile = $request->file('ARCHIVO_AUTORIZACION');
            $autorizacionFileName = 'AUTORIZACION_' . $request->CURP . '.' . $autorizacionFile->getClientOriginalExtension();
            $autorizacionFile->storeAs($autorizacionFolder, $autorizacionFileName);

            $autorizaciones->ARCHIVO_AUTORIZACION = $autorizacionFolder . $autorizacionFileName;
            $autorizaciones->save();
            }

            $response['code'] = 1;
            $response['autorizacion'] = $autorizaciones;
            return response()->json($response);

    break;
            

    case 4:
        if ($request->ID_INTELIGENCIA_SELECCION == 0) {
            DB::statement('ALTER TABLE seleccion_inteligencia AUTO_INCREMENT=1;');
            $inteligencias = inteligenciaseleccionModel::create($request->all());
        } else {
            if (!isset($request->ELIMINAR)) {
                $inteligencias = inteligenciaseleccionModel::find($request->ID_INTELIGENCIA_SELECCION);
                if ($request->hasFile('ARCHIVO_COMPLETO') && $inteligencias->ARCHIVO_COMPLETO) {
                    Storage::delete($inteligencias->ARCHIVO_COMPLETO);
                }
                if ($request->hasFile('ARCHIVO_COMPETENCIAS') && $inteligencias->ARCHIVO_COMPETENCIAS) {
                    Storage::delete($inteligencias->ARCHIVO_COMPETENCIAS);
                }
                $inteligencias->update($request->all());
            } else {
                $inteligencias = inteligenciaseleccionModel::where('ID_INTELIGENCIA_SELECCION', $request['ID_INTELIGENCIA_SELECCION'])->update(['ACTIVO' => 0]);
                $response['code'] = 1;
                $response['inteligencia'] = 'Desactivada';
                return response()->json($response);
            }
        }

        if ($request->hasFile('ARCHIVO_COMPLETO')) {
            $curpFolder = 'reclutamiento/' . $request->CURP . '/Inteligencia Laboral/';
            if (!Storage::exists($curpFolder)) {
                Storage::makeDirectory($curpFolder);
            }
            
            $completoFile = $request->file('ARCHIVO_COMPLETO');
            $completoFileName = 'COMPLETO_' . $request->CURP . '.' . $completoFile->getClientOriginalExtension();
            $completoFile->storeAs($curpFolder, $completoFileName);
            
            $inteligencias->ARCHIVO_COMPLETO = $curpFolder . $completoFileName;
        }

        if ($request->hasFile('ARCHIVO_COMPETENCIAS')) {
            $competenciasFile = $request->file('ARCHIVO_COMPETENCIAS');
            $competenciasFileName = 'COMPETENCIAS_' . $request->CURP . '.' . $competenciasFile->getClientOriginalExtension();
            $competenciasFile->storeAs($curpFolder, $competenciasFileName);
            
            $inteligencias->ARCHIVO_COMPETENCIAS = $curpFolder . $competenciasFileName;
        }

        $inteligencias->save();

        $response['code'] = 1;
        $response['inteligencia'] = $inteligencias;
        return response()->json($response);

        break;

               


                case 5:
                    if ($request->ID_BURO_SELECCION == 0) {
                        DB::statement('ALTER TABLE seleccion_buro_laboral AUTO_INCREMENT=1;');

                        $data = $request->except(['observacion']);
                        $autorizaciones = buroseleccionModel::create($data);

                        $buroId = $autorizaciones->ID_BURO_SELECCION;
                        $response['code'] = 1;
                        $response['autorizacion'] = $autorizaciones;
                    } else {
                        if (!isset($request->ELIMINAR)) {
                            $autorizaciones = buroseleccionModel::find($request->ID_BURO_SELECCION);

                            if (!$autorizaciones) {
                                throw new Exception("Registro no encontrado");
                            }

                            if ($request->hasFile('ARCHIVO_RESULTADO') && $autorizaciones->ID_BURO_SELECCION) {
                                Storage::delete($autorizaciones->ARCHIVO_RESULTADO);
                            }

                            $autorizaciones->update($request->except(['observacion']));
                            $buroId = $autorizaciones->ID_BURO_SELECCION;

                            $response['code'] = 1;
                            $response['autorizacion'] = 'Actualizada';
                        } else {
                            buroseleccionModel::where('ID_BURO_SELECCION', $request['ID_BURO_SELECCION'])
                                ->update(['ACTIVO' => 0]);

                            $response['code'] = 1;
                            $response['autorizacion'] = 'Desactivada';
                            return response()->json($response);
                        }
                    }

                    if ($request->hasFile('ARCHIVO_RESULTADO')) {
                        $curpFolder = 'reclutamiento/' . $request->CURP;
                        $autorizacionFolder = $curpFolder . '/Buro Laboral/';

                        if (!Storage::exists($curpFolder)) {
                            Storage::makeDirectory($curpFolder);
                        }

                        if (!Storage::exists($autorizacionFolder)) {
                            Storage::makeDirectory($autorizacionFolder);
                        }

                        $autorizacionFile = $request->file('ARCHIVO_RESULTADO');
                        $autorizacionFileName = 'BURO_LABORAL_' . $request->CURP . '.' . $autorizacionFile->getClientOriginalExtension();
                        $autorizacionFile->storeAs($autorizacionFolder, $autorizacionFileName);

                        $autorizaciones->ARCHIVO_RESULTADO = $autorizacionFolder . $autorizacionFileName;
                        $autorizaciones->save();
                    }

                    if ($request->filled('observacion')) {
                        buroseleccionModel::where('ID_BURO_SELECCION', $buroId)
                            ->update(['OBSERVACIONES_BURO' => $request->observacion]);
                    }

                    return response()->json($response);
                    break;




                case 6:
                DB::beginTransaction();
            
                if ($request->ID_REFERENCIAS_SELECCION == 0) {
                    DB::statement('ALTER TABLE seleccion_referencias_laboral AUTO_INCREMENT=1;');
                    $vacante = referenciaseleccionModel::create($request->all());
                } else {
                    $vacante = referenciaseleccionModel::find($request->ID_REFERENCIAS_SELECCION);
            
                    $vacante->update($request->all());
                }
            
                if ($request->has('NOMBRE_EMPRESA')) {
                    foreach ($request->NOMBRE_EMPRESA as $index => $nombreEmpresa) {
                        $comentario = isset($request->COMENTARIO[$index]) ? $request->COMENTARIO[$index] : null;
            
                        $cumpleKey = "CUMPLE_" . ($index + 1);
                        $cumple = $request->input($cumpleKey) ?? null;
            
                        $referencia = referenciasempresasModel::where('SELECCION_REFERENCIA_ID', $vacante->ID_REFERENCIAS_SELECCION)
                            ->where('NOMBRE_EMPRESA', $nombreEmpresa)
                            ->first();
            
                        if ($referencia) {
                            $archivoAnterior = $referencia->ARCHIVO_RESULTADO;
            
                            if ($request->hasFile("ARCHIVO_RESULTADO.$index")) {
                                if ($archivoAnterior) {
                                    Storage::delete($archivoAnterior);
                                }
            
                                $curpFolder = 'reclutamiento/' . $request->CURP;
                                $referenciaFolder = $curpFolder . '/Referencias Laborales/';
            
                                if (!Storage::exists($curpFolder)) {
                                    Storage::makeDirectory($curpFolder);
                                }
            
                                if (!Storage::exists($referenciaFolder)) {
                                    Storage::makeDirectory($referenciaFolder);
                                }
            
                                $archivoFile = $request->file("ARCHIVO_RESULTADO.$index");
                                $archivoFileName = $nombreEmpresa . '_' . $request->CURP . '.' . $archivoFile->getClientOriginalExtension();
                                $archivoFile->storeAs($referenciaFolder, $archivoFileName);
            
                                $referencia->ARCHIVO_RESULTADO = $referenciaFolder . $archivoFileName;
                            } else {
                                $referencia->ARCHIVO_RESULTADO = $archivoAnterior;
                            }
            
                            $referencia->NOMBRE_EMPRESA = $nombreEmpresa;
                            $referencia->COMENTARIO = $comentario;
                            $referencia->CUMPLE = $cumple;
                            $referencia->save();
                        } else {
                            $referencia = referenciasempresasModel::create([
                                'SELECCION_REFERENCIA_ID' => $vacante->ID_REFERENCIAS_SELECCION,
                                'NOMBRE_EMPRESA' => $nombreEmpresa,
                                'COMENTARIO' => $comentario,
                                'CUMPLE' => $cumple,
                            ]);
            
                            if ($request->hasFile("ARCHIVO_RESULTADO.$index")) {
                                $curpFolder = 'reclutamiento/' . $request->CURP;
                                $referenciaFolder = $curpFolder . '/Referencias Laborales/';
            
                                if (!Storage::exists($curpFolder)) {
                                    Storage::makeDirectory($curpFolder);
                                }
            
                                if (!Storage::exists($referenciaFolder)) {
                                    Storage::makeDirectory($referenciaFolder);
                                }
            
                                $archivoFile = $request->file("ARCHIVO_RESULTADO.$index");
                                $archivoFileName = $nombreEmpresa . '_' . $request->CURP . '.' . $archivoFile->getClientOriginalExtension();
                                $archivoFile->storeAs($referenciaFolder, $archivoFileName);
            
                                $referencia->ARCHIVO_RESULTADO = $referenciaFolder . $archivoFileName;
                                $referencia->save();
                            }
                        }
                    }
                }
            
                $response['code']  = 1;
                $response['vacantes']  = $vacante;
                DB::commit();
                return response()->json($response);
                break;
            







                case 7:
                    DB::beginTransaction();
                
                    if ($request->ID_PRUEBAS_SELECCION == 0) {
                        DB::statement('ALTER TABLE seleccion_prueba_conocimiento AUTO_INCREMENT=1;');
                        $vacante = pruebaseleccionModel::create($request->all());
                    } else {
                        $vacante = pruebaseleccionModel::find($request->ID_PRUEBAS_SELECCION);
                
                        $vacante->update($request->all());
                    }
                
                    if ($request->has('TIPO_PRUEBA')) {
                        foreach ($request->TIPO_PRUEBA as $index => $nombreEmpresa) {

                            $PORCENTAJE_PRUEBA = isset($request->PORCENTAJE_PRUEBA[$index]) ? $request->PORCENTAJE_PRUEBA[$index] : null;
                            $TOTAL_PORCENTAJE = isset($request->TOTAL_PORCENTAJE[$index]) ? $request->TOTAL_PORCENTAJE[$index] : null;
                                         
                     
                
                            $referencia = referenciaspruebaseleccionModel::where('SELECCION_PRUEBAS_ID', $vacante->ID_PRUEBAS_SELECCION)
                                ->where('TIPO_PRUEBA', $nombreEmpresa)
                                ->first();
                
                            if ($referencia) {
                                $archivoAnterior = $referencia->ARCHIVO_RESULTADO;
                
                                if ($request->hasFile("ARCHIVO_RESULTADO.$index")) {
                                    if ($archivoAnterior) {
                                        Storage::delete($archivoAnterior);
                                    }
                
                                    $curpFolder = 'reclutamiento/' . $request->CURP;
                                    $referenciaFolder = $curpFolder . '/Pruebas de conocimiento/';
                
                                    if (!Storage::exists($curpFolder)) {
                                        Storage::makeDirectory($curpFolder);
                                    }
                
                                    if (!Storage::exists($referenciaFolder)) {
                                        Storage::makeDirectory($referenciaFolder);
                                    }
                
                                    $archivoFile = $request->file("ARCHIVO_RESULTADO.$index");
                                    $archivoFileName = $nombreEmpresa . '_' . $request->CURP . '.' . $archivoFile->getClientOriginalExtension();
                                    $archivoFile->storeAs($referenciaFolder, $archivoFileName);
                
                                    $referencia->ARCHIVO_RESULTADO = $referenciaFolder . $archivoFileName;
                                } else {
                                    $referencia->ARCHIVO_RESULTADO = $archivoAnterior;
                                }
                
                                $referencia->TIPO_PRUEBA = $nombreEmpresa;
                                $referencia->PORCENTAJE_PRUEBA = $PORCENTAJE_PRUEBA;
                                $referencia->TOTAL_PORCENTAJE = $TOTAL_PORCENTAJE;
                                $referencia->save();
                            } else {
                                $referencia = referenciaspruebaseleccionModel::create([
                                    'SELECCION_PRUEBAS_ID' => $vacante->ID_PRUEBAS_SELECCION,
                                    'TIPO_PRUEBA' => $nombreEmpresa,
                                    'PORCENTAJE_PRUEBA' => $PORCENTAJE_PRUEBA,
                                    'TOTAL_PORCENTAJE' => $TOTAL_PORCENTAJE,
                                ]);
                
                                if ($request->hasFile("ARCHIVO_RESULTADO.$index")) {
                                    $curpFolder = 'reclutamiento/' . $request->CURP;
                                    $referenciaFolder = $curpFolder . '/Pruebas de conocimiento/';
                
                                    if (!Storage::exists($curpFolder)) {
                                        Storage::makeDirectory($curpFolder);
                                    }
                
                                    if (!Storage::exists($referenciaFolder)) {
                                        Storage::makeDirectory($referenciaFolder);
                                    }
                
                                    $archivoFile = $request->file("ARCHIVO_RESULTADO.$index");
                                    $archivoFileName = $nombreEmpresa . '_' . $request->CURP . '.' . $archivoFile->getClientOriginalExtension();
                                    $archivoFile->storeAs($referenciaFolder, $archivoFileName);
                
                                    $referencia->ARCHIVO_RESULTADO = $referenciaFolder . $archivoFileName;
                                    $referencia->save();
                                }
                            }
                        }
                    }
                
                    $response['code']  = 1;
                    $response['vacantes']  = $vacante;
                    DB::commit();
                    return response()->json($response);
                    break;


            default:

                $response['code']  = 2;
                return response()->json($response);
        }
    } catch (Exception $e) {

        return response()->json('Error al guardar');
    }
}

}





