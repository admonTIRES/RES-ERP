<?php

namespace App\Http\Controllers\contratacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;

use App\Models\contratacion\contratacionModel;
use App\Models\contratacion\documentosoporteModel;
use App\Models\contratacion\contratosanexosModel;
use App\Models\contratacion\documentoscolaboradorcontratoModel;
use App\Models\contratacion\reingresocontratoModel;

use App\Models\contratacion\reciboscontratoModel;
use App\Models\contratacion\informacionmedicaModel;
use App\Models\contratacion\incidenciasModel;
use App\Models\contratacion\accionesdisciplinariasModel;
use App\Models\contratacion\documentosoportecontratoModel;
use App\Models\contratacion\renovacioncontratoModel;
use App\Models\contratacion\adendarenovacionModel;
use App\Models\contratacion\requisicioncontratacion;

use App\Models\contratacion\adendacontratoModel;
use App\Models\recempleados\recemplaedosModel;

use App\Models\contratacion\asignacioncontratacionModel;

use App\Models\organizacion\catalogotipovacanteModel;
use App\Models\organizacion\catalogomotivovacanteModel;
use App\Models\organizacion\areasModel;

use App\Models\inventario\asignacionesinventarioModel;


use DB;



class contratacionController extends Controller
{
    

    public function index()
    {
        $areas = DB::select("
        SELECT ID_CATALOGO_CATEGORIA  AS ID, NOMBRE_CATEGORIA AS NOMBRE, LUGAR_CATEGORIA AS LUGAR, PROPOSITO_CATEGORIA AS PROPOSITO, ES_LIDER_CATEGORIA AS LIDER
        FROM catalogo_categorias
        WHERE ACTIVO = 1
        ");


        $areas2 = areasModel::orderBy('NOMBRE', 'ASC')->get();

        $requisicioncategoria = DB::select("
                SELECT 
                    rec.*, 
                    cat.NOMBRE_CATEGORIA,
                    CASE 
                        WHEN rec.ANTES_DE1 = 1 THEN rec.FECHA_CREACION
                        ELSE rec.FECHA_RP
                    END AS FECHA_MOSTRAR
                FROM formulario_requerimientos rec
                LEFT JOIN catalogo_categorias cat 
                    ON cat.ID_CATALOGO_CATEGORIA = rec.PUESTO_RP
                WHERE rec.ESTADO_SOLICITUD = 'Aprobada'
            ");


        $tipos = catalogotipovacanteModel::orderBy('NOMBRE_TIPOVACANTE', 'ASC')->get();
        $motivos = catalogomotivovacanteModel::orderBy('NOMBRE_MOTIVO_VACANTE', 'ASC')->get();


        $areas1 = DB::select("
        SELECT ID_CATALOGO_CATEGORIA  AS ID, NOMBRE_CATEGORIA AS NOMBRE, LUGAR_CATEGORIA AS LUGAR, PROPOSITO_CATEGORIA AS PROPOSITO, ES_LIDER_CATEGORIA AS LIDER
        FROM catalogo_categorias
        WHERE ACTIVO = 1
        ");

        $todascategoria = DB::select("SELECT ID_CATALOGO_CATEGORIA  AS ID_CATALOGO_CATEGORIA, NOMBRE_CATEGORIA AS NOMBRE
                FROM catalogo_categorias
                WHERE ACTIVO = 1");


        $categoria = DB::select("
                SELECT c.ID_CATALOGO_CATEGORIA AS ID_DEPARTAMENTO_AREA, 
                    c.NOMBRE_CATEGORIA AS NOMBRE
                FROM catalogo_categorias c
                INNER JOIN formulario_dpt f ON c.ID_CATALOGO_CATEGORIA = f.DEPARTAMENTOS_AREAS_ID
                WHERE c.ACTIVO = 1
            ");


        return view('RH.contratacion.contratacion', compact('areas','tipos','motivos', 'areas1','todascategoria','categoria', 'areas2', 'requisicioncategoria'));
    }



    public function obtenerUltimoCargo(Request $request)
    {
        try {
            $curp = $request->input('curp');

            $cargo = DB::table('contratos_anexos_contratacion as cac')
            ->join('catalogo_categorias as cc', 'cc.ID_CATALOGO_CATEGORIA', '=', 'cac.NOMBRE_CARGO') 
            ->where('cac.CURP', $curp)
            ->orderBy('cac.ID_CONTRATOS_ANEXOS', 'desc') 
            ->select('cc.NOMBRE_CATEGORIA') 
            ->first();

            $nombreCargo = $cargo ? $cargo->NOMBRE_CATEGORIA : "No disponible";

            return response()->json([
                'cargo' => $nombreCargo
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error al obtener el cargo: ' . $e->getMessage()
            ]);
        }
    }





    public function Tablacontratacion()
    {
        try {
            $tabla = contratacionModel::where('ACTIVO', 1)->get();

            foreach ($tabla as $value) {

                $contrato = DB::table('contratos_anexos_contratacion')
                    ->where('CURP', $value->CURP)
                    ->orderByDesc('ID_CONTRATOS_ANEXOS')
                    ->first();

                if ($contrato) {

                    $renovacion = DB::table('renovacion_contrato')
                        ->where('CONTRATO_ID', $contrato->ID_CONTRATOS_ANEXOS)
                        ->orderByDesc('FECHAF_RENOVACION')
                        ->first();

                    $fechaInicio = $renovacion
                        ? $renovacion->FECHAI_RENOVACION
                        : $contrato->FECHAI_CONTRATO;

                    $fechaFin = $renovacion
                        ? $renovacion->FECHAF_RENOVACION
                        : $contrato->VIGENCIA_CONTRATO;
                } else {
                    $fechaInicio = null;
                    $fechaFin = null;
                }

                if ($fechaInicio && $fechaFin) {

                    // 🔥 Manejo correcto de fechas
                    $inicio = new \DateTime($fechaInicio);
                    $fin = new \DateTime($fechaFin);
                    $hoy = new \DateTime();

                    // 🔴 Quitar horas (clave)
                    $inicio->setTime(0, 0, 0);
                    $fin->setTime(0, 0, 0);
                    $hoy->setTime(0, 0, 0);

                    $totalDias = $inicio->diff($fin)->days;

                    // 🔴 SIN +1 (conteo real correcto)
                    if ($fin >= $hoy) {
                        $diasRestantes = $hoy->diff($fin)->days;
                    } else {
                        $diasRestantes = -$hoy->diff($fin)->days;
                    }

                    $umbralVerde = $totalDias * 0.60;
                    $umbralAmarillo = $totalDias * 0.30;

                    // 🔥 Estados corregidos
                    if ($fin < $hoy) {

                        $estado_dias = "<span style='color: red;'>(Terminado)</span>";
                    } elseif ($fin == $hoy) {

                        $estado_dias = "<span style='color: orange;'>(Vence hoy)</span>";
                    } elseif ($diasRestantes <= $umbralAmarillo) {

                        $estado_dias = "<span style='color: red;'>($diasRestantes días restantes)</span>";
                    } elseif ($diasRestantes <= $umbralVerde) {

                        $estado_dias = "<span style='color: orange;'>($diasRestantes días restantes)</span>";
                    } else {

                        $estado_dias = "<span style='color: green;'>($diasRestantes días restantes)</span>";
                    }

                    $value->ESTATUS_CONTRATO = "$fechaInicio<br>$fechaFin<br>$estado_dias";
                } else {

                    $value->ESTATUS_CONTRATO = "<span style='color: gray;'>(Sin contrato)</span>";
                }

                // Botón
                $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR">
                                    <i class="bi bi-eye"></i>
                                 </button>';
            }

            return response()->json([
                'data' => $tabla,
                'msj' => 'Información consultada correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'msj' => 'Error: ' . $e->getMessage(),
                'data' => []
            ]);
        }
    }


public function Tablacontratacion1()
{
    try {
        $tabla = contratacionModel::where('ACTIVO', 0)->get();

        foreach ($tabla as $value) {
            
         
        $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR"><i class="bi bi-eye"></i></button>';
        $value->BTN_ACTIVAR = '<label class="switch"><input type="checkbox" class="ACTIVAR"  data-id="' . $value->ID_FORMULARIO_CONTRATACION . '" ><span class="slider round"></span></label>';

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
    
public function verificarestadobloqueo(Request $request)
{
    $curp = $request->input('curpSeleccionada');

    if (!$curp) {
        return response()->json(['error' => 'CURP no proporcionada'], 400);
    }

    $registro = DB::table('formulario_contratacion')
        ->where('CURP', $curp)
        ->first();

    $bloqueodesactivado = $registro && $registro->ACTIVO == 0 ? 0 : 1;

    return response()->json(['bloqueodesactivado' => $bloqueodesactivado]);
}


    public function obtenerSiguienteNumeroEmpleado(Request $request)
    {
        try {

            $curp = $request->curp;

            if (!$curp) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'CURP no proporcionada'
                ]);
            }

            $empleado = DB::table('formulario_contratacion')
                ->where('CURP', $curp)
                ->select('NUMERO_EMPLEADO')
                ->first();

            if ($empleado && !empty($empleado->NUMERO_EMPLEADO)) {
                return response()->json([
                    'status' => 'existe',
                    'numero' => $empleado->NUMERO_EMPLEADO
                ]);
            }

            $ultimoNumero = DB::table('formulario_contratacion')
                ->whereNotNull('NUMERO_EMPLEADO')
                ->max('NUMERO_EMPLEADO');

            $siguienteNumero = $ultimoNumero ? $ultimoNumero + 1 : 1;

            return response()->json([
                'status' => 'nuevo',
                'numero' => $siguienteNumero
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }





    public function activarColaborador(Request $request, $id)
{
    try {
        $colaborador = contratacionModel::findOrFail($id);

        if ($colaborador->ACTIVO == 1) {
            return response()->json([
                'msj' => 'El colaborador ya está activo',
                'status' => 'info'
            ]);
        }

        reingresocontratoModel::create([
            'CURP' => $colaborador->CURP,
            'FECHA_REINGRESO' => $request->input('fechaReingreso'),
            'ACTIVO' => 1
        ]);

        $colaborador->ACTIVO = 1;
        $colaborador->save();

        return response()->json([
            'msj' => 'El colaborador ha sido activado exitosamente',
            'status' => 'success'
        ]);
    } catch (Exception $e) {
        return response()->json([
            'msj' => 'Error: ' . $e->getMessage(),
            'status' => 'error'
        ]);
    }
}


/////////////////////////////////////////// STEP 1  DATOS GENERALES //////////////////////////////////

    public function mostrarfotocolaborador($colaborador_id)
    {
        $foto = contratacionModel::findOrFail($colaborador_id);
        return Storage::response($foto->FOTO_USUARIO);
    }
        



    public function obtenerbajasalta(Request $request) {
        $curp = $request->input('curp');

        if (!$curp) {
            return response()->json(['error' => 'CURP no proporcionada.'], 400);
        }

        $altas = DB::table('formulario_contratacion')
            ->select('FECHA_INGRESO as fecha')
            ->where('CURP', $curp)
            ->get();

        $bajas = DB::table('formulario_desvinculacion')
            ->select('FECHA_BAJA as fecha')
            ->where('CURP', $curp)
            ->get();

        $reingresos = DB::table('reingreso_contratacion')
            ->select('FECHA_REINGRESO as fecha')
            ->where('CURP', $curp)
            ->get();

        $eventos = [];

        foreach ($altas as $a) {
            $eventos[] = ['tipo' => 'ALTA', 'fecha' => $a->fecha];
        }

        foreach ($bajas as $b) {
            $eventos[] = ['tipo' => 'BAJA', 'fecha' => $b->fecha];
        }

        foreach ($reingresos as $r) {
            $eventos[] = ['tipo' => 'REINGRESO', 'fecha' => $r->fecha];
        }

        usort($eventos, function ($a, $b) {
            return strtotime($a['fecha']) - strtotime($b['fecha']);
        });

        $hoy = date('Y-m-d');
        $historial = [];
        $fechaInicio = null;
        $indiceInicio = null;

        foreach ($eventos as $i => $evento) {
            if ($evento['tipo'] === 'ALTA' || $evento['tipo'] === 'REINGRESO') {
                $fechaInicio = $evento['fecha'];
                $indiceInicio = count($historial);
                $historial[] = [
                    'tipo' => $evento['tipo'],
                    'fecha' => $evento['fecha'],
                    'fecha_fin' => '-',
                    'dias_transcurridos' => '-'
                ];
            } elseif ($evento['tipo'] === 'BAJA' && $fechaInicio !== null) {
                $fechaFin = $evento['fecha'];
                $dias = (strtotime($fechaFin) - strtotime($fechaInicio)) / 86400;
                $historial[] = [
                    'tipo' => 'BAJA',
                    'fecha' => $fechaFin,
                    'fecha_fin' => $fechaFin,
                    'dias_transcurridos' => floor($dias)
                ];
                $historial[$indiceInicio]['fecha_fin'] = $fechaFin;
                $historial[$indiceInicio]['dias_transcurridos'] = floor($dias);
                $fechaInicio = null;
                $indiceInicio = null;
            }
        }

        // Si aún está activo
        if ($fechaInicio !== null && $indiceInicio !== null) {
            $dias = (strtotime($hoy) - strtotime($fechaInicio)) / 86400;
            $historial[$indiceInicio]['fecha_fin'] = $hoy;
            $historial[$indiceInicio]['dias_transcurridos'] = floor($dias);
        }

        return response()->json($historial);
    }


/////////////////////////////////////////// STEP 2 DOCUMENTOS DE SOPORTE //////////////////////////////////

public function Tabladocumentosoporte(Request $request)
{
    try {
        $curp = $request->get('curp');

        $tabla = documentosoporteModel::where('CURP', $curp)->get();


        // $tabla = documentosoporteModel::get();


        foreach ($tabla as $value) {
            if ($value->ACTIVO == 0) {

                $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR" ><i class="bi bi-eye"></i></button>';
                $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-documentosoporte" data-id="' . $value->ID_DOCUMENTO_SOPORTE . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';

            } else {

                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-documentosoporte" data-id="' . $value->ID_DOCUMENTO_SOPORTE . '" title="Ver documento"> <i class="bi bi-filetype-pdf"></i></button>';
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

public function mostrardocumentosoporte($id)
{
    $archivo = documentosoporteModel::findOrFail($id)->DOCUMENTO_SOPORTE;
    return Storage::response($archivo);
}

public function obtenerguardados(Request $request)
{
    $curp = $request->input('CURP');
    $documentos = documentosoporteModel::where('CURP', $curp)
                  ->pluck('TIPO_DOCUMENTO')
                  ->toArray();

    return response()->json($documentos);
}


    /////////////////////////////////////////// STEP 3  CONTRATOS Y ANEXOS //////////////////////////////////



    public function Tablacontratosyanexos(Request $request)
    {
        try {
            $curp = $request->get('curp');

            if (!$curp) {
                return response()->json([
                    'msj' => 'CURP no proporcionada',
                    'data' => []
                ], 400);
            }

            $tabla = DB::select("
            SELECT 
                rec.*, 
                cat.NOMBRE_CATEGORIA,
                (SELECT MAX(FECHAI_RENOVACION) FROM renovacion_contrato WHERE CONTRATO_ID = rec.ID_CONTRATOS_ANEXOS) AS ULTIMA_FECHA_INICIO,
                (SELECT MAX(FECHAF_RENOVACION) FROM renovacion_contrato WHERE CONTRATO_ID = rec.ID_CONTRATOS_ANEXOS) AS ULTIMA_FECHA_FIN
            FROM contratos_anexos_contratacion rec
            LEFT JOIN catalogo_categorias cat 
                ON cat.ID_CATALOGO_CATEGORIA = rec.NOMBRE_CARGO
            WHERE rec.CURP = ?
        ", [$curp]);

            foreach ($tabla as $value) {

                $fecha_inicio_mostrar = !empty($value->ULTIMA_FECHA_INICIO)
                    ? $value->ULTIMA_FECHA_INICIO
                    : $value->FECHAI_CONTRATO;

                $fecha_fin_mostrar = !empty($value->ULTIMA_FECHA_FIN)
                    ? $value->ULTIMA_FECHA_FIN
                    : $value->VIGENCIA_CONTRATO;

                if (!empty($fecha_inicio_mostrar) && !empty($fecha_fin_mostrar)) {

                    $inicio = new \DateTime($fecha_inicio_mostrar);
                    $fin = new \DateTime($fecha_fin_mostrar);
                    $hoy = new \DateTime();

                    $inicio->setTime(0, 0, 0);
                    $fin->setTime(0, 0, 0);
                    $hoy->setTime(0, 0, 0);

                    $totalDias = $inicio->diff($fin)->days;

                    if ($fin >= $hoy) {
                        $diasRestantes = $hoy->diff($fin)->days;
                    } else {
                        $diasRestantes = -$hoy->diff($fin)->days;
                    }

                    $umbralVerde = $totalDias * 0.60;
                    $umbralAmarillo = $totalDias * 0.30;

                    if ($fin < $hoy) {

                        $estado_dias = "<span style='color: red;'>(Terminado)</span>";
                    } elseif ($fin == $hoy) {

                        $estado_dias = "<span style='color: orange;'>(Vence hoy)</span>";
                    } elseif ($diasRestantes <= $umbralAmarillo) {

                        $estado_dias = "<span style='color: red;'>($diasRestantes días restantes)</span>";
                    } elseif ($diasRestantes <= $umbralVerde) {

                        $estado_dias = "<span style='color: orange;'>($diasRestantes días restantes)</span>";
                    } else {

                        $estado_dias = "<span style='color: green;'>($diasRestantes días restantes)</span>";
                    }
                } else {
                    $estado_dias = "<span style='color: gray;'>(Fecha desconocida)</span>";
                }

                $value->FECHA_ESTADO = $fecha_inicio_mostrar . "<br>" . $fecha_fin_mostrar . "<br>" . $estado_dias;

                if ($value->ACTIVO == 0) {
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR"><i class="bi bi-eye"></i></button>';
                } else {
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                }

                $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-contratosyanexos" data-id="' . $value->ID_CONTRATOS_ANEXOS . '" title="Ver documento"><i class="bi bi-filetype-pdf"></i></button>';
                $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                $value->BTN_CONTRATO = '<button type="button" class="btn btn-success btn-custom rounded-pill informacion" id="contrato-' . $value->ID_CONTRATOS_ANEXOS . '"><i class="bi bi-eye"></i></button>';

                if ($value->REQUIERE_CREDENCIAL == 1) {
                    $value->BTN_CREDENCIAL = '<button class="btn btn-danger btn-custom rounded-pill generar-credencial" data-id="' . $value->ID_CONTRATOS_ANEXOS . '" data-curp="' . $value->CURP . '" title="Generar credencial"><i class="bi bi-person-badge-fill"></i></button>';
                } else {
                    $value->BTN_CREDENCIAL = '<button type="button" class="btn btn-secondary btn-custom rounded-pill" disabled><i class="bi bi-ban"></i></button>';
                }

                $adendas = DB::table('adenda_contratos')
                    ->where('CONTRATO_ID', $value->ID_CONTRATOS_ANEXOS)
                    ->get();

                $adendasAgrupadas = [];

                foreach ($adendas as $adenda) {
                    $adendasAgrupadas[] = [
                        'ID_ADENDA_CONTRATO'        => $adenda->ID_ADENDA_CONTRATO,
                        'FECHAI_ADENDA_CONTRATO'    => $adenda->FECHAI_ADENDA_CONTRATO,
                        'FECHAF_ADENDA_CONTRATO'    => $adenda->FECHAF_ADENDA_CONTRATO,
                        'COMENTARIO_ADENDA_CONTRATO' => $adenda->COMENTARIO_ADENDA_CONTRATO,
                        'DOCUMENTO_ADENDA_CONTRATO' => $adenda->DOCUMENTO_ADENDA_CONTRATO,
                        'BTN_DOCUMENTO'             => '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-adendacontrato" data-id="' . $adenda->ID_ADENDA_CONTRATO . '" title="Ver Adenda"><i class="bi bi-filetype-pdf"></i></button>',
                    ];
                }

                $value->ADENDAS = $adendasAgrupadas;
            }

            return response()->json([
                'data' => $tabla,
                'msj' => 'Información consultada correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'msj' => 'Error: ' . $e->getMessage(),
                'data' => []
            ]);
        }
    }



public function mostrarcontratosyanexos($id)
{
    $archivo = contratosanexosModel::findOrFail($id)->DOCUMENTO_CONTRATO;
    return Storage::response($archivo);
}


 public function mostraradendacontrato($id)
    {
        $archivo = adendacontratoModel::findOrFail($id)->DOCUMENTO_ADENDA_CONTRATO;
        return Storage::response($archivo);
    }


    

    public function obtenerInformacionContrato($contrato_id)
    {
        try {
            $contrato = DB::selectOne("
            SELECT 
                rec.ID_CONTRATOS_ANEXOS,
                cat.NOMBRE_CATEGORIA,
                rec.FECHAI_CONTRATO,
                rec.VIGENCIA_CONTRATO,
                rec.SALARIO_CONTRATO
            FROM contratos_anexos_contratacion rec
            LEFT JOIN catalogo_categorias cat 
                ON cat.ID_CATALOGO_CATEGORIA = rec.NOMBRE_CARGO
            WHERE rec.ID_CONTRATOS_ANEXOS = ?
        ", [$contrato_id]);

            if (!$contrato) {
                return response()->json(['msj' => 'Contrato no encontrado', 'data' => null], 404);
            }

            $renovacion = DB::selectOne("
            SELECT 
                FECHAI_RENOVACION AS FECHAI_CONTRATO,
                FECHAF_RENOVACION AS VIGENCIA_CONTRATO,
                SALARIO_RENOVACION AS SALARIO_CONTRATO
            FROM renovacion_contrato
            WHERE CONTRATO_ID = ?
            ORDER BY FECHAI_RENOVACION DESC
            LIMIT 1
        ", [$contrato_id]);

            if ($renovacion) {
                $contrato->FECHAI_CONTRATO = $renovacion->FECHAI_CONTRATO;
                $contrato->VIGENCIA_CONTRATO = $renovacion->VIGENCIA_CONTRATO;
                $contrato->SALARIO_CONTRATO = $renovacion->SALARIO_CONTRATO;
            }

            return response()->json(['msj' => 'Información obtenida correctamente', 'data' => $contrato]);
        } catch (\Exception $e) {
            return response()->json(['msj' => 'Error: ' . $e->getMessage(), 'data' => null], 500);
        }
    }

/////////////////////////////////////////// DOCUMENTOS DE CONTRATO //////////////////////////////////

// DOCUMENTOS DE SOPORTE DEL COTRATO 

public function Tabladocumentosoportecontrato(Request $request)
{
    try {
        $contrato = $request->get('contrato');

        $tabla = documentosoportecontratoModel::where('CONTRATO_ID', $contrato)->get();


        // $tabla = documentosoporteModel::get();


        foreach ($tabla as $value) {
            if ($value->ACTIVO == 0) {

                $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR" ><i class="bi bi-eye"></i></button>';
                $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-soportescontratos" data-id="' . $value->ID_SOPORTE_CONTRATO . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';

            } else {

                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-soportescontratos" data-id="' . $value->ID_SOPORTE_CONTRATO . '" title="Ver documento"> <i class="bi bi-filetype-pdf"></i></button>';
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

public function mostrardocumentosoportecontrato($id)
{
    $archivo = documentosoportecontratoModel::findOrFail($id)->DOCUMENTOS_SOPORTECONTRATOS;
    return Storage::response($archivo);
}


    public function Tablarenovacioncontrato(Request $request)
    {
        try {
            $contrato = $request->get('contrato');

            $tabla = renovacioncontratoModel::where('CONTRATO_ID', $contrato)->get();
            $rows = [];

            foreach ($tabla as $value) {
                $adendas = adendarenovacionModel::where('RENOVACION_ID', $value->ID_RENOVACION_CONTATO)->get();
                $adendasAgrupadas = [];

                foreach ($adendas as $adenda) {
                    $adendasAgrupadas[] = [
                        'ID_ADENDA_RENOVACION'     => $adenda->ID_ADENDA_RENOVACION,

                        'FECHAI_ADENDA'     => $adenda->FECHAI_ADENDA,
                        'FECHAF_ADENDA'     => $adenda->FECHAF_ADENDA,
                        'COMENTARIO_ADENDA' => $adenda->COMENTARIO_ADENDA,
                        'DOCUMENTO_ADENDA'  => $adenda->DOCUMENTO_ADENDA,
                        'BTN_DOCUMENTO'     => '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-informacionadenda" data-id="' . $adenda->ID_ADENDA_RENOVACION . '" title="Ver Adenda"><i class="bi bi-filetype-pdf"></i></button>'
                    ];
                }


                $value->BTN_EDITAR = ($value->ACTIVO == 0)
                    ? '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>'
                    : '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';

                $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-informacionrenovacion" data-id="' . $value->ID_RENOVACION_CONTATO . '" title="Ver documento"><i class="bi bi-filetype-pdf"></i></button>';

             

                $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';

                $rows[] = [
                    'ID_RENOVACION_CONTATO'       => $value->ID_RENOVACION_CONTATO,
                    'CONTRATO_ID'                 => $value->CONTRATO_ID,
                    'NOMBRE_DOCUMENTO_RENOVACION' => $value->NOMBRE_DOCUMENTO_RENOVACION,
                    'FECHAI_RENOVACION'           => $value->FECHAI_RENOVACION,
                    'FECHAF_RENOVACION'           => $value->FECHAF_RENOVACION,
                    'PROCEDE_ADENDA'              => $value->PROCEDE_ADENDA,
                    'SALARIO_RENOVACION'            => $value->SALARIO_RENOVACION,
                    'ACTIVO'                      => $value->ACTIVO,
                    'ADENDAS'                     => $adendasAgrupadas,
                    'BTN_EDITAR'                  => $value->BTN_EDITAR,
                    'BTN_DOCUMENTO'               => $value->BTN_DOCUMENTO,
                    'BTN_ADENDA'                  => $value->BTN_ADENDA,
                    'BTN_VISUALIZAR'              => $value->BTN_VISUALIZAR,
                ];
            }

            return response()->json([
                'data' => $rows,
                'msj'  => 'Información consultada correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'msj'  => 'Error ' . $e->getMessage(),
                'data' => 0
            ]);
        }
    }



    public function mostrardocumentorenovacion($id)
{
    $archivo = renovacioncontratoModel::findOrFail($id)->DOCUMENTOS_RENOVACION;
    return Storage::response($archivo);
}


    public function mostraradenda($id)
    {
        $archivo = adendarenovacionModel::findOrFail($id)->DOCUMENTO_ADENDA;
        return Storage::response($archivo);
    }


    // INFORMACION MEDICA

    public function Tablainformacionmedica(Request $request)
{
    try {
        $contrato = $request->get('contrato');

        $tabla = informacionmedicaModel::where('CONTRATO_ID', $contrato)->get();


        // $tabla = documentosoporteModel::get();


        foreach ($tabla as $value) {
            if ($value->ACTIVO == 0) {

                $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR" ><i class="bi bi-eye"></i></button>';
                $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-informacionmedica" data-id="' . $value->ID_INFORMACION_MEDICA . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';

            } else {

                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-informacionmedica" data-id="' . $value->ID_INFORMACION_MEDICA . '" title="Ver documento"> <i class="bi bi-filetype-pdf"></i></button>';
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

public function mostrarinformacionmedica($id)
{
    $archivo = informacionmedicaModel::findOrFail($id)->DOCUMENTO_INFORMACION_MEDICA;
    return Storage::response($archivo);
}

// INCIDENCIAS 

public function Tablaincidencias(Request $request)
{
    try {
        $contrato = $request->get('contrato');

        $tabla = incidenciasModel::where('CONTRATO_ID', $contrato)->get();

        foreach ($tabla as $value) {
            if ($value->ACTIVO == 0) {

                $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR" ><i class="bi bi-eye"></i></button>';
                $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-incidencias" data-id="' . $value->ID_INCIDENCIAS . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';

            } else {

                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-incidencias" data-id="' . $value->ID_INCIDENCIAS . '" title="Ver documento"> <i class="bi bi-filetype-pdf"></i></button>';
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



    public function Tablaspermisosrecempleados(Request $request)
    {
        try {
            $contrato = $request->get('contrato');

            $tabla = recemplaedosModel::where('CONTRATO_ID', $contrato)
                ->where('TIPO_SOLICITUD', 1)
                ->where('ESTADO_APROBACION', 'Aprobada')
                ->orderBy('FECHA_SALIDA', 'asc')
                ->get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                } else {
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-recempleado" data-id="' . $value->ID_FORMULARIO_RECURSOS_EMPLEADOS . '" title="Ver documento"><i class="bi bi-filetype-pdf"></i></button>';
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



public function mostrarincidencias($id)
{
    $archivo = incidenciasModel::findOrFail($id)->DOCUMENTO_INCIDENCIAS;
    return Storage::response($archivo);
}

    // SOLICITUD VACACIONES 

    public function Tablasolicitudvacaciones(Request $request)
    {
        try {
            $contrato = $request->get('contrato');

            $tabla = recemplaedosModel::where('CONTRATO_ID', $contrato)
                ->where('TIPO_SOLICITUD', 3)
                ->where('ESTADO_APROBACION', 'Aprobada')
                ->get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                } else {
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-recempleado" data-id="' . $value->ID_FORMULARIO_RECURSOS_EMPLEADOS . '" title="Ver documento"><i class="bi bi-filetype-pdf"></i></button>';
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


    // ACCIONES DISCIPLINARIAS 

    public function Tablaccionesdisciplinarias(Request $request)
{
    try {
        $contrato = $request->get('contrato');

        $tabla = accionesdisciplinariasModel::where('CONTRATO_ID', $contrato)->get();

        foreach ($tabla as $value) {
            if ($value->ACTIVO == 0) {

                $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR" ><i class="bi bi-eye"></i></button>';
                $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-acciones" data-id="' . $value->ID_ACCIONES_DISCIPLINARIAS . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';

            } else {

                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-acciones" data-id="' . $value->ID_ACCIONES_DISCIPLINARIAS . '" title="Ver documento"> <i class="bi bi-filetype-pdf"></i></button>';
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

public function mostraracciones($id)
{
    $archivo = accionesdisciplinariasModel::findOrFail($id)->DOCUMENTO_ACCIONES_DISCIPLINARIAS;
    return Storage::response($archivo);
}

// RECIBOS DE NOMINA 

public function Tablarecibonomina(Request $request)
{
    try {
        $contrato = $request->get('contrato');

        $tabla = reciboscontratoModel::where('CONTRATO_ID', $contrato)->get();


        // $tabla = documentosoporteModel::get();


        foreach ($tabla as $value) {
            if ($value->ACTIVO == 0) {

                $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR" ><i class="bi bi-eye"></i></button>';
                $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-recibonomina" data-id="' . $value->ID_RECIBOS_NOMINA . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';

            } else {

                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-recibonomina" data-id="' . $value->ID_RECIBOS_NOMINA . '" title="Ver documento"> <i class="bi bi-filetype-pdf"></i></button>';
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

public function mostrarecibosnomina($id)
{
    $archivo = reciboscontratoModel::findOrFail($id)->DOCUMENTO_RECIBO;
    return Storage::response($archivo);
}



    ///// ASIGNACIONES 


    public function Tablasignacioncolaborador(Request $request)
    {
        try {

            $curp = $request->get('curp');

            $idsUsados = DB::table('asignaciones_contratacion')
                ->where('CURP', $curp)
                ->whereNotNull('ASIGNACIONES_ID')
                ->pluck('ASIGNACIONES_ID');

           
            $idsExcluir = [];

            foreach ($idsUsados as $json) {
                $array = json_decode($json, true);
                if (is_array($array)) {
                    $idsExcluir = array_merge($idsExcluir, $array);
                }
            }

            
            $query = DB::table('asignaciones_inventario as ai')
                ->leftJoin(
                    'formulario_inventario as fi',
                    'fi.ID_FORMULARIO_INVENTARIO',
                    '=',
                    'ai.INVENTARIO_ID'
                )
                ->leftJoin(
                    'usuarios as u',
                    'u.ID_USUARIO',
                    '=',
                    'ai.ALMACENISTA_ID'
                )
                ->where('ai.ASIGNADO_ID', $curp);

            if (!empty($idsExcluir)) {
                $query->whereNotIn('ai.ID_ASIGNACION_FORMULARIO', $idsExcluir);
            }

            $tabla = $query->select(
                'ai.ID_ASIGNACION_FORMULARIO',
                'ai.INVENTARIO_ID',
                'ai.CANTIDAD_SALIDA',
                'ai.ACTIVO',
                'ai.ALMACENISTA_ID',

                'fi.DESCRIPCION_EQUIPO',
                'fi.MARCA_EQUIPO',
                'fi.MODELO_EQUIPO',
                'fi.SERIE_EQUIPO',
                'fi.CODIGO_EQUIPO',

                DB::raw("
                CONCAT(
                    u.EMPLEADO_NOMBRE, ' ',
                    u.EMPLEADO_APELLIDOPATERNO, ' ',
                    u.EMPLEADO_APELLIDOMATERNO
                ) as ALMACENISTA_NOMBRE
            ")
            )->get();

            return response()->json([
                'data' => $tabla,
                'msj' => 'Información consultada correctamente'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'msj' => 'Error ' . $e->getMessage(),
                'data' => []
            ]);
        }
    }


    public function validarPrimerContrato(Request $request)
    {
        try {

            $contratoId = $request->get('contrato_id');
            $curp = $request->get('curp');

            if (!$contratoId || !$curp) {
                return response()->json([
                    'es_primer_contrato' => false
                ]);
            }

            $primerContratoId = DB::table('contratos_anexos_contratacion')
                ->where('CURP', $curp)
                ->orderBy('ID_CONTRATOS_ANEXOS', 'asc')
                ->value('ID_CONTRATOS_ANEXOS');

            return response()->json([
                'es_primer_contrato' => ((int)$contratoId === (int)$primerContratoId)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'es_primer_contrato' => false
            ]);
        }
    }



    public function Tablasignacioncolaboradorgeneral(Request $request)
    {
        try {


            $contrato = $request->get('contrato');

            $asignaciones = asignacioncontratacionModel::where('CONTRATO_ID', $contrato)->get();


            $resultado = [];

            foreach ($asignaciones as $asignacion) {

                $idsAsignaciones = json_decode($asignacion->ASIGNACIONES_ID, true);

                if (!is_array($idsAsignaciones) || empty($idsAsignaciones)) {
                    continue;
                }

                $inventarios = DB::table('asignaciones_inventario as ai')
                    ->leftJoin(
                        'formulario_inventario as fi',
                        'fi.ID_FORMULARIO_INVENTARIO',
                        '=',
                        'ai.INVENTARIO_ID'
                    )
                    ->whereIn('ai.ID_ASIGNACION_FORMULARIO', $idsAsignaciones)
                    ->select(
                        'ai.ID_ASIGNACION_FORMULARIO',
                        'ai.CANTIDAD_SALIDA',
                        'fi.DESCRIPCION_EQUIPO',
                        'fi.MARCA_EQUIPO',
                        'fi.MODELO_EQUIPO',
                        'fi.SERIE_EQUIPO',
                        'fi.CODIGO_EQUIPO'
                    )
                    ->get();

                $esPrimera = true;

                foreach ($inventarios as $inv) {

                    $fila = [
                        'GRUPO_ID'         => $asignacion->ID_ASINGACIONES_CONTRATACION,
                        'PERSONAL_ASIGNA'  => $asignacion->PERSONAL_ASIGNA,
                        'FECHA_ASIGNACION' => $asignacion->FECHA_ASIGNACION,
                        'TIPO_ASIGNACION'  => $asignacion->TIPO_ASIGNACION,
                        'ALMACENISTA_ASIGNACION'  => $asignacion->ALMACENISTA_ASIGNACION,
                        'ASIGNACIONES_ID'  => $asignacion->ASIGNACIONES_ID,
                        'EPP_JSON'  => $asignacion->EPP_JSON,

                        'CANTIDAD_SALIDA' => $inv->CANTIDAD_SALIDA,
                        'DESCRIPCION_EQUIPO' => $inv->DESCRIPCION_EQUIPO,
                        'MARCA_EQUIPO'       => $inv->MARCA_EQUIPO,
                        'MODELO_EQUIPO'      => $inv->MODELO_EQUIPO,
                        'SERIE_EQUIPO'       => $inv->SERIE_EQUIPO,
                        'CODIGO_EQUIPO'      => $inv->CODIGO_EQUIPO,
                    ];

                    if ($esPrimera) {

                        if ($asignacion->ACTIVO == 0) {
                            $fila['BTN_EDITAR'] =
                                '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR">
                                <i class="bi bi-eye"></i>
                            </button>';
                        } else {
                            $fila['BTN_EDITAR'] =
                                '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR">
                                <i class="bi bi-pencil-square"></i>
                            </button>';
                        }

                        $fila['DESCARGAR_FORMATOS'] =
                            '<button class="btn btn-danger btn-custom rounded-pill pdf-button descargar-asignacion"
                                data-id="' . $asignacion->ID_ASINGACIONES_CONTRATACION . '">
                                <i class="bi bi-filetype-pdf"></i>
                            </button>';


                        $fila['DESCARGAR_EPP'] =
                            '<button class="btn btn-danger btn-custom rounded-pill pdf-button descargar-epp"
                                data-id="' . $asignacion->ID_ASINGACIONES_CONTRATACION . '">
                                <i class="bi bi-filetype-pdf"></i>
                            </button>';


                        $fila['BTN_DOCUMENTO'] =
                            '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-documentoasignacion"
                            data-id="' . $asignacion->ID_ASINGACIONES_CONTRATACION . '">
                            <i class="bi bi-filetype-pdf"></i>
                        </button>';
                    } else {
                        $fila['BTN_EDITAR'] = '';
                        $fila['DESCARGAR_FORMATOS'] = '';
                        $fila['BTN_DOCUMENTO'] = '';
                    }

                    $resultado[] = $fila;
                    $esPrimera = false;
                }
            }

            return response()->json([
                'data' => $resultado,
                'msj'  => 'Información consultada correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'msj'  => 'Error ' . $e->getMessage(),
                'data' => []
            ]);
        }
    }

    public function TablasignacioncolaboradorEditar(Request $request)
    {
        try {

            $idAsignacion = $request->id_asignacion_contratacion;

            if (!$idAsignacion) {
                return response()->json(['data' => []]);
            }

            $asignacion = DB::table('asignaciones_contratacion')
                ->where('ID_ASINGACIONES_CONTRATACION', $idAsignacion)
                ->first();

            if (!$asignacion || empty($asignacion->ASIGNACIONES_ID)) {
                return response()->json(['data' => []]);
            }

            $ids = json_decode($asignacion->ASIGNACIONES_ID, true);

            if (!is_array($ids) || empty($ids)) {
                return response()->json(['data' => []]);
            }

            $tabla = DB::table('asignaciones_inventario as ai')
                ->leftJoin(
                    'formulario_inventario as fi',
                    'fi.ID_FORMULARIO_INVENTARIO',
                    '=',
                    'ai.INVENTARIO_ID'
                )
                ->whereIn('ai.ID_ASIGNACION_FORMULARIO', $ids)
                ->select(
                    'ai.ID_ASIGNACION_FORMULARIO',
                    'ai.CANTIDAD_SALIDA',

                    'fi.DESCRIPCION_EQUIPO',
                    'fi.MARCA_EQUIPO',
                    'fi.MODELO_EQUIPO',
                    'fi.SERIE_EQUIPO',
                    'fi.CODIGO_EQUIPO'
                )
                ->get();

            return response()->json([
                'data' => $tabla
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'data' => [],
                'error' => $e->getMessage()
            ]);
        }
    }


    public function mostrarasignacion($id)
    {
        $archivo = asignacioncontratacionModel::findOrFail($id)->DOCUMENTO_ASIGNACION;
        return Storage::response($archivo);
    }


    /////////////////////////////////////////// STEP 4  DOCUMENTOS DE SOPORTE DE LOS CONTRATOS EN GENERAL //////////////////////////////////

    public function Tablasoportecontrato(Request $request)
{
    try {
        $curp = $request->get('curp');

        $tabla = documentoscolaboradorcontratoModel::where('CURP', $curp)->get();


        // $tabla = documentosoporteModel::get();


        foreach ($tabla as $value) {
            if ($value->ACTIVO == 0) {

                $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR" ><i class="bi bi-eye"></i></button>';
                $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-documentocolaboradorsoportecontrato" data-id="' . $value->ID_DOCUMENTO_COLABORADOR_CONTRATO . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';

            } else {

                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-documentocolaboradorsoportecontrato" data-id="' . $value->ID_DOCUMENTO_COLABORADOR_CONTRATO . '" title="Ver documento"> <i class="bi bi-filetype-pdf"></i></button>';
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

public function mostrardocumentocolaboradorcontratosoporte($id)
{
    $archivo = documentoscolaboradorcontratoModel::findOrFail($id)->DOCUMENTO_SOPORTECONTRATO;
    return Storage::response($archivo);
}

public function obtenerdocumentosoportescontratos(Request $request)
{
    $curp = $request->input('CURP');
    $documentos = documentoscolaboradorcontratoModel::where('CURP', $curp)
                  ->pluck('TIPO_DOCUMENTO_SOPORTECONTRATO')
                  ->toArray();

    return response()->json($documentos);
}



 public function mostrarFotofirma($id)
    {
        $foto = documentoscolaboradorcontratoModel::findOrFail($id);
        return Storage::response($foto->FOTO_FIRMA);
    }



    public function mostrarFotofirmaRH($id)
    {
        $foto = documentoscolaboradorcontratoModel::findOrFail($id);
        return Storage::response($foto->FOTO_FIRMA_RH);
    }


    /////////////////////////////////////////// STEP 5  CREACION DE CV´S  //////////////////////////////////


    /////////////////////////////////////////// STEP 6  REQUSICION DE PERSONAL   //////////////////////////////////


    public function Tablarequisicioncontratacion(Request $request)
    {
        try {
            $curp = $request->get('curp');

            $tabla = DB::select("
            SELECT rec.*, cat.NOMBRE_CATEGORIA
            FROM contratacion_requisicion rec
            LEFT JOIN catalogo_categorias cat ON cat.ID_CATALOGO_CATEGORIA = rec.PUESTO_RP
            WHERE rec.CURP = ?
        ", [$curp]);

            $tabla = collect($tabla);

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-requerisicioncontratacion" data-id="' . $value->ID_CONTRATACION_REQUERIMIENTO . '" title="Ver documento"> <i class="bi bi-filetype-pdf"></i></button>';
                } else {
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-requerisicioncontratacion" data-id="' . $value->ID_CONTRATACION_REQUERIMIENTO . '" title="Ver documento"> <i class="bi bi-filetype-pdf"></i></button>';
                }
            }

            return response()->json([
                'data' => $tabla,
                'msj' => 'Información consultada correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'msj' => 'Error ' . $e->getMessage(),
                'data' => 0
            ]);
        }
    }




    public function obtenerDatosCategoria(Request $request)
    {
        $id = $request->get('categoria');

        $registro = DB::table('formulario_requerimientos as rec')
            ->leftJoin('catalogo_categorias as cat', 'cat.ID_CATALOGO_CATEGORIA', '=', 'rec.PUESTO_RP')
            ->leftJoin('usuarios as u', 'u.ID_USUARIO', '=', 'rec.APROBO_ID')
            ->where('rec.ID_FORMULARO_REQUERIMIENTO', $id)
            ->select(
                'rec.*',
                'cat.NOMBRE_CATEGORIA',
                'u.ID_USUARIO as APROBO_ID_USUARIO',
                DB::raw("
                CONCAT(
                    u.EMPLEADO_NOMBRE, ' ',
                    u.EMPLEADO_APELLIDOPATERNO, ' ',
                    u.EMPLEADO_APELLIDOMATERNO
                ) as NOMBRE_APROBO
            ")
            )
            ->first();

        if (!$registro) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontraron datos.'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $registro
        ]);
    }




    public function mostrarrequisicon($id)
    {
        $archivo = requisicioncontratacion::findOrFail($id)->DOCUMENTO_REQUISICION;
        return Storage::response($archivo);
    }



 

    /////////////////////////////////////////// STORE //////////////////////////////////
    public function store(Request $request)
{
    try {
        switch (intval($request->api)) {

             // STEP 1 DATOS GENERALES 

            case 1:
                if ($request->ID_FORMULARIO_CONTRATACION == 0) {

                    DB::statement('ALTER TABLE formulario_contratacion AUTO_INCREMENT=1;');
                
                    $data = $request->except(['FOTO_USUARIO', 'beneficiarios','documentos']);
                    $contratos = contratacionModel::create($data);
                
                    if ($request->hasFile('FOTO_USUARIO')) {
                        $imagen = $request->file('FOTO_USUARIO');
                        $curp = $request->CURP;
                        $rutaCarpeta = 'reclutamiento/' . $curp . '/IMAGEN COLABORADOR';
                        $nombreArchivo = 'foto_usuario.' . $imagen->getClientOriginalExtension();
                        $rutaCompleta = $imagen->storeAs($rutaCarpeta, $nombreArchivo);
                
                        $contratos->FOTO_USUARIO = $rutaCompleta;
                        $contratos->save();
                    }
                } else {
                    if (isset($request->ELIMINAR)) {
                        if ($request->ELIMINAR == 1) {
                            $contratos = contratacionModel::where('ID_FORMULARIO_CONTRATACION', $request['ID_FORMULARIO_CONTRATACION'])->update(['ACTIVO' => 0]);
                            $response['code'] = 1;
                            $response['contrato'] = 'Desactivada';
                        } else {
                            $contratos = contratacionModel::where('ID_FORMULARIO_CONTRATACION', $request['ID_FORMULARIO_CONTRATACION'])->update(['ACTIVO' => 1]);
                            $response['code'] = 1;
                            $response['contrato'] = 'Activada';
                        }
                    } else {
                        // Editar un contrato existente
                        $contratos = contratacionModel::find($request->ID_FORMULARIO_CONTRATACION);
                        $contratos->update($request->except('FOTO_USUARIO'));
                
                        if ($request->hasFile('FOTO_USUARIO')) {
                            if ($contratos->FOTO_USUARIO && Storage::exists($contratos->FOTO_USUARIO)) {
                                Storage::delete($contratos->FOTO_USUARIO);
                            }
                
                            $imagen = $request->file('FOTO_USUARIO');
                            $curp = $request->CURP;
                            $rutaCarpeta = 'reclutamiento/' . $curp . '/IMAGEN COLABORADOR';
                            $nombreArchivo = 'foto_usuario.' . $imagen->getClientOriginalExtension();
                            $rutaCompleta = $imagen->storeAs($rutaCarpeta, $nombreArchivo);
                
                            $contratos->FOTO_USUARIO = $rutaCompleta;
                            $contratos->save();
                        }
                
                        $response['code'] = 1;
                        $response['contrato'] = 'Actualizada';
                    }
                }

                $response['code'] = 1;
                $response['contrato'] = $contratos;
                return response()->json($response);
                
                break;


                // STEP 2 DOCUMENTOS SOPORTE

                case 2:
                    if ($request->ID_DOCUMENTO_SOPORTE == 0) {
                        DB::statement('ALTER TABLE documentos_soporte_contratacion AUTO_INCREMENT=1;');
                        $soportes = documentosoporteModel::create($request->except('DOCUMENTO_SOPORTE')); 

                        if ($request->hasFile('DOCUMENTO_SOPORTE')) {
                            $documento = $request->file('DOCUMENTO_SOPORTE');
                            $curp = $request->CURP;
                            $idDocumento = $soportes->ID_DOCUMENTO_SOPORTE;

                            $nombreArchivo =  preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $request->NOMBRE_DOCUMENTO) . '.' . $documento->getClientOriginalExtension();

                            $rutaCarpeta = 'reclutamiento/' . $curp . '/Documentos de soporte/' . $idDocumento;
                            $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);

                            $soportes->DOCUMENTO_SOPORTE = $rutaCompleta;
                            $soportes->save();
                        }
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $soportes = documentosoporteModel::where('ID_DOCUMENTO_SOPORTE', $request['ID_DOCUMENTO_SOPORTE'])
                                    ->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['soporte'] = 'Desactivada';
                            } else {
                                $soportes = documentosoporteModel::where('ID_DOCUMENTO_SOPORTE', $request['ID_DOCUMENTO_SOPORTE'])
                                    ->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['soporte'] = 'Activada';
                            }
                        } else {
                            $soportes = documentosoporteModel::find($request->ID_DOCUMENTO_SOPORTE);
                            $soportes->update($request->except('DOCUMENTO_SOPORTE'));

                            if ($request->hasFile('DOCUMENTO_SOPORTE')) {
                                
                                if ($soportes->DOCUMENTO_SOPORTE && Storage::exists($soportes->DOCUMENTO_SOPORTE)) {
                                    Storage::delete($soportes->DOCUMENTO_SOPORTE); 
                                }

                                $documento = $request->file('DOCUMENTO_SOPORTE');
                                $curp = $request->CURP;
                                $idDocumento = $soportes->ID_DOCUMENTO_SOPORTE;

                                $nombreArchivo =  preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $request->NOMBRE_DOCUMENTO) . '.' . $documento->getClientOriginalExtension();

                                $rutaCarpeta = 'reclutamiento/' . $curp . '/Documentos de soporte/' . $idDocumento;
                                $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);

                                $soportes->DOCUMENTO_SOPORTE = $rutaCompleta;
                                $soportes->save();
                            }

                            $response['code'] = 1;
                            $response['soporte'] = 'Actualizada';
                        }
                    }

                    $response['code'] = 1;
                    $response['soporte'] = $soportes;
                    return response()->json($response);
                    break;



                      // STEP 3 CONTRATOS Y ANEXOS 

                case 3:
                    if ($request->ID_CONTRATOS_ANEXOS == 0) {
                        DB::statement('ALTER TABLE contratos_anexos_contratacion AUTO_INCREMENT=1;');
                        $soportes = contratosanexosModel::create($request->except('DOCUMENTO_CONTRATO')); 

                        if ($request->hasFile('DOCUMENTO_CONTRATO')) {
                            $documento = $request->file('DOCUMENTO_CONTRATO');
                            $curp = $request->CURP;
                            $idDocumento = $soportes->ID_CONTRATOS_ANEXOS;

                            $nombreArchivo = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $request->NOMBRE_DOCUMENTO_CONTRATO) . '.' . $documento->getClientOriginalExtension();

                            $rutaCarpeta = 'reclutamiento/' . $curp . '/Documentos de contratos y anexos/' . $idDocumento;
                            $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);

                            $soportes->DOCUMENTO_CONTRATO = $rutaCompleta;
                            $soportes->save();
                        }
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $soportes = contratosanexosModel::where('ID_CONTRATOS_ANEXOS', $request['ID_CONTRATOS_ANEXOS'])
                                    ->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['soporte'] = 'Desactivada';
                            } else {
                                $soportes = contratosanexosModel::where('ID_CONTRATOS_ANEXOS', $request['ID_CONTRATOS_ANEXOS'])
                                    ->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['soporte'] = 'Activada';
                            }
                        } else {
                            $soportes = contratosanexosModel::find($request->ID_CONTRATOS_ANEXOS);
                            $soportes->update($request->except('DOCUMENTO_CONTRATO'));

                            if ($request->hasFile('DOCUMENTO_CONTRATO')) {
                                if ($soportes->DOCUMENTO_CONTRATO && Storage::exists($soportes->DOCUMENTO_CONTRATO)) {
                                    Storage::delete($soportes->DOCUMENTO_CONTRATO); 
                                }

                                $documento = $request->file('DOCUMENTO_CONTRATO');
                                $curp = $request->CURP;
                                $idDocumento = $soportes->ID_CONTRATOS_ANEXOS;

                                $nombreArchivo = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $request->NOMBRE_DOCUMENTO_CONTRATO) . '.' . $documento->getClientOriginalExtension();

                                $rutaCarpeta = 'reclutamiento/' . $curp . '/Documentos de contratos y anexos/' . $idDocumento;
                                $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);

                                $soportes->DOCUMENTO_CONTRATO = $rutaCompleta;
                                $soportes->save();
                            }

                            $response['code'] = 1;
                            $response['soporte'] = 'Actualizada';
                        }
                    }




                      // ADENDAS
                    if ($request->filled('FECHAI_ADENDA_CONTRATO')) {
                        $fechasInicio = $request->FECHAI_ADENDA_CONTRATO;
                        $fechasFin = $request->FECHAF_ADENDA_CONTRATO;
                        $comentarios = $request->COMENTARIO_ADENDA_CONTRATO;



                        $archivos = $request->file('DOCUMENTO_ADENDA_CONTRATO');
                        $curp = $request->CURP;
                        $renovacionId = $soportes->ID_CONTRATOS_ANEXOS;

                        $adendasAnteriores = adendacontratoModel::where('CONTRATO_ID', $renovacionId)->get()->toArray();

                        adendacontratoModel::where('CONTRATO_ID', $renovacionId)->delete();

                        foreach ($fechasInicio as $i => $inicio) {
                            $archivoRuta = null;

                            if (isset($archivos[$i]) && $archivos[$i]->isValid()) {
                                $archivo = $archivos[$i];
                                $nombre = 'adenda_' . ($i + 1) . '.' . $archivo->getClientOriginalExtension();

                                $rutaAdenda = "reclutamiento/{$curp}/Documentos de contratos y anexos/{$renovacionId}/adenda de contrato/" . ($i + 1);
                                $archivoRuta = $archivo->storeAs($rutaAdenda, $nombre);
                            } elseif (isset($adendasAnteriores[$i]['DOCUMENTO_ADENDA_CONTRATO'])) {
                                $archivoRuta = $adendasAnteriores[$i]['DOCUMENTO_ADENDA_CONTRATO'];
                            }

                            adendacontratoModel::create([
                                'CONTRATO_ID' => $renovacionId,
                                'FECHAI_ADENDA_CONTRATO' => $inicio,
                                'FECHAF_ADENDA_CONTRATO' => $fechasFin[$i] ?? null,
                                'COMENTARIO_ADENDA_CONTRATO' => $comentarios[$i] ?? '',
                                'DOCUMENTO_ADENDA_CONTRATO' => $archivoRuta
                            ]);
                        }
                    }





                    $response['code'] = 1;
                    $response['soporte'] = $soportes;
                    return response()->json($response);
                    break;


                // STEP 4 DOCUMENTOS DE SOPORTE DE LOS CONTRATOS EN GENERAL


                // case 4:
                //     if ($request->ID_DOCUMENTO_COLABORADOR_CONTRATO == 0) {
                //         DB::statement('ALTER TABLE documentos_colaborador_contrato AUTO_INCREMENT=1;');
                //         $soportes = documentoscolaboradorcontratoModel::create($request->except(['DOCUMENTO_SOPORTECONTRATO', 'FOTO_FIRMA','FOTO_FIRMA_RH'])); 

                //         if ($request->hasFile('DOCUMENTO_SOPORTECONTRATO')) {
                //             $documento = $request->file('DOCUMENTO_SOPORTECONTRATO');
                //             $curp = $request->CURP;
                //             $idDocumento = $soportes->ID_DOCUMENTO_COLABORADOR_CONTRATO;

                //             $nombreArchivo = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $request->NOMBRE_DOCUMENTO_SOPORTECONTRATO) . '.' . $documento->getClientOriginalExtension();

                //             $rutaCarpeta = 'reclutamiento/' . $curp . '/Documentos de soporte de los contratos en general/' . $idDocumento;
                //             $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);

                //             $soportes->DOCUMENTO_SOPORTECONTRATO = $rutaCompleta;
                //             $soportes->save();
                //         }

                //         if ($request->hasFile('FOTO_FIRMA')) {
                //             $firma = $request->file('FOTO_FIRMA');
                //             $curp = $request->CURP;
                //             $idDocumento = $soportes->ID_DOCUMENTO_COLABORADOR_CONTRATO;

                //             $nombreFirma = 'firma_colaborador.' . $firma->getClientOriginalExtension();
                //             $rutaFirma = 'reclutamiento/' . $curp . '/Documentos de soporte de los contratos en general/' . $idDocumento . '/firma del colaborador';
                //             $rutaFirmaCompleta = $firma->storeAs($rutaFirma, $nombreFirma);

                //             $soportes->FOTO_FIRMA = $rutaFirmaCompleta;
                //             $soportes->save();
                //         }


                //         if ($request->hasFile('FOTO_FIRMA_RH')) {
                //             $firma = $request->file('FOTO_FIRMA_RH');
                //             $curp = $request->CURP;
                //             $idDocumento = $soportes->ID_DOCUMENTO_COLABORADOR_CONTRATO;

                //             $nombreFirma = 'firma_rh.' . $firma->getClientOriginalExtension();
                //             $rutaFirma = 'reclutamiento/' . $curp . '/Documentos de soporte de los contratos en general/' . $idDocumento . '/firma RH';
                //             $rutaFirmaCompleta = $firma->storeAs($rutaFirma, $nombreFirma);

                //             $soportes->FOTO_FIRMA_RH = $rutaFirmaCompleta;
                //             $soportes->save();
                //         }

                //                     } else {
                //         if (isset($request->ELIMINAR)) {
                //             if ($request->ELIMINAR == 1) {
                //                 $soportes = documentoscolaboradorcontratoModel::where('ID_DOCUMENTO_COLABORADOR_CONTRATO', $request['ID_DOCUMENTO_COLABORADOR_CONTRATO'])
                //                     ->update(['ACTIVO' => 0]);
                //                 $response['code'] = 1;
                //                 $response['soporte'] = 'Desactivada';
                //             } else {
                //                 $soportes = documentoscolaboradorcontratoModel::where('ID_DOCUMENTO_COLABORADOR_CONTRATO', $request['ID_DOCUMENTO_COLABORADOR_CONTRATO'])
                //                     ->update(['ACTIVO' => 1]);
                //                 $response['code'] = 1;
                //                 $response['soporte'] = 'Activada';
                //             }
                //         } else {
                //             $soportes = documentoscolaboradorcontratoModel::find($request->ID_DOCUMENTO_COLABORADOR_CONTRATO);
                //             $soportes->update($request->except(['DOCUMENTO_SOPORTECONTRATO', 'FOTO_FIRMA', 'FOTO_FIRMA_RH']));

                //             if ($request->hasFile('DOCUMENTO_SOPORTECONTRATO')) {
                //                 if ($soportes->DOCUMENTO_SOPORTECONTRATO && Storage::exists($soportes->DOCUMENTO_SOPORTECONTRATO)) {
                //                     Storage::delete($soportes->DOCUMENTO_SOPORTECONTRATO); 
                //                 }

                //                 $documento = $request->file('DOCUMENTO_SOPORTECONTRATO');
                //                 $curp = $request->CURP;
                //                 $idDocumento = $soportes->ID_DOCUMENTO_COLABORADOR_CONTRATO;

                //                 $nombreArchivo = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $request->NOMBRE_DOCUMENTO_SOPORTECONTRATO) . '.' . $documento->getClientOriginalExtension();

                //                 $rutaCarpeta = 'reclutamiento/' . $curp . '/Documentos de soporte de los contratos en general/' . $idDocumento;
                //                 $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);

                //                 $soportes->DOCUMENTO_SOPORTECONTRATO = $rutaCompleta;
                //                 $soportes->save();
                //             }

                //             if ($request->hasFile('FOTO_FIRMA')) {
                //                 if ($soportes->FOTO_FIRMA && Storage::exists($soportes->FOTO_FIRMA)) {
                //                     Storage::delete($soportes->FOTO_FIRMA);
                //                 }

                //                 $firma = $request->file('FOTO_FIRMA');
                //                 $curp = $request->CURP;
                //                 $idDocumento = $soportes->ID_DOCUMENTO_COLABORADOR_CONTRATO;

                //                 $nombreFirma = 'firma_colaborador.' . $firma->getClientOriginalExtension();
                //                 $rutaFirma = 'reclutamiento/' . $curp . '/Documentos de soporte de los contratos en general/' . $idDocumento . '/firma del colaborador';
                //                 $rutaFirmaCompleta = $firma->storeAs($rutaFirma, $nombreFirma);

                //                 $soportes->FOTO_FIRMA = $rutaFirmaCompleta;
                //                 $soportes->save();
                //             }


                //             if ($request->hasFile('FOTO_FIRMA_RH')) {
                //                 $firma = $request->file('FOTO_FIRMA_RH');
                //                 $curp = $request->CURP;
                //                 $idDocumento = $soportes->ID_DOCUMENTO_COLABORADOR_CONTRATO;

                //                 $nombreFirma = 'firma_rh.' . $firma->getClientOriginalExtension();
                //                 $rutaFirma = 'reclutamiento/' . $curp . '/Documentos de soporte de los contratos en general/' . $idDocumento . '/firma RH';
                //                 $rutaFirmaCompleta = $firma->storeAs($rutaFirma, $nombreFirma);

                //                 $soportes->FOTO_FIRMA_RH = $rutaFirmaCompleta;
                //                 $soportes->save();
                //             }



                //             $response['code'] = 1;
                //             $response['soporte'] = 'Actualizada';
                //         }
                //     }

                //     $response['code'] = 1;
                //     $response['soporte'] = $soportes;
                //     return response()->json($response);
                //     break;




                case 4:
                    if ($request->ID_DOCUMENTO_COLABORADOR_CONTRATO == 0) {
                       
                        DB::statement('ALTER TABLE documentos_colaborador_contrato AUTO_INCREMENT=1;');

                        $soportes = documentoscolaboradorcontratoModel::create(
                            $request->except(['DOCUMENTO_SOPORTECONTRATO', 'FOTO_FIRMA', 'FOTO_FIRMA_RH'])
                        );

                        if ($request->hasFile('DOCUMENTO_SOPORTECONTRATO')) {
                            $documento   = $request->file('DOCUMENTO_SOPORTECONTRATO');
                            $curp        = $request->CURP;
                            $idDocumento = $soportes->ID_DOCUMENTO_COLABORADOR_CONTRATO;

                            $nombreArchivo = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $request->NOMBRE_DOCUMENTO_SOPORTECONTRATO)
                                . '.' . $documento->getClientOriginalExtension();

                            $rutaCarpeta  = 'reclutamiento/' . $curp . '/Documentos de soporte de los contratos en general/' . $idDocumento;
                            $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);

                            $soportes->DOCUMENTO_SOPORTECONTRATO = $rutaCompleta;
                            $soportes->save();
                        }

                        if ($request->hasFile('FOTO_FIRMA')) {
                            $firma       = $request->file('FOTO_FIRMA');
                            $curp        = $request->CURP;
                            $idDocumento = $soportes->ID_DOCUMENTO_COLABORADOR_CONTRATO;

                            $nombreFirma       = 'firma_colaborador.' . $firma->getClientOriginalExtension();
                            $rutaFirma         = 'reclutamiento/' . $curp . '/Documentos de soporte de los contratos en general/' . $idDocumento . '/firma del colaborador';
                            $rutaFirmaCompleta = $firma->storeAs($rutaFirma, $nombreFirma);

                            $soportes->FOTO_FIRMA = $rutaFirmaCompleta;
                            $soportes->save();
                        }

                        
                        if ($request->hasFile('FOTO_FIRMA_RH')) {
                            $firma       = $request->file('FOTO_FIRMA_RH');
                            $curp        = $request->CURP;
                            $idDocumento = $soportes->ID_DOCUMENTO_COLABORADOR_CONTRATO;

                            $nombreFirma       = 'firma_rh.' . $firma->getClientOriginalExtension();
                            $rutaFirma         = 'reclutamiento/' . $curp . '/Documentos de soporte de los contratos en general/' . $idDocumento . '/firma RH';
                            $rutaFirmaCompleta = $firma->storeAs($rutaFirma, $nombreFirma);

                            $soportes->FOTO_FIRMA_RH = $rutaFirmaCompleta;
                            $soportes->save();
                        }
                    } else {
                        
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $soportes = documentoscolaboradorcontratoModel::where(
                                    'ID_DOCUMENTO_COLABORADOR_CONTRATO',
                                    $request['ID_DOCUMENTO_COLABORADOR_CONTRATO']
                                )->update(['ACTIVO' => 0]);

                                $response['code']    = 1;
                                $response['soporte'] = 'Desactivada';
                            } else {
                                $soportes = documentoscolaboradorcontratoModel::where(
                                    'ID_DOCUMENTO_COLABORADOR_CONTRATO',
                                    $request['ID_DOCUMENTO_COLABORADOR_CONTRATO']
                                )->update(['ACTIVO' => 1]);

                                $response['code']    = 1;
                                $response['soporte'] = 'Activada';
                            }
                        } else {
                            
                            $soportes = documentoscolaboradorcontratoModel::find($request->ID_DOCUMENTO_COLABORADOR_CONTRATO);

                            
                            $soportes->update($request->except([
                                'DOCUMENTO_SOPORTECONTRATO',
                                'FOTO_FIRMA',
                                'FOTO_FIRMA_RH',
                                'ELIMINAR_DOCUMENTO_SOPORTECONTRATO',
                                'ELIMINAR_FOTO_FIRMA',
                                'ELIMINAR_FOTO_FIRMA_RH'
                            ]));


                            if ($request->boolean('ELIMINAR_DOCUMENTO_SOPORTECONTRATO')) {
                                if ($soportes->DOCUMENTO_SOPORTECONTRATO && Storage::exists($soportes->DOCUMENTO_SOPORTECONTRATO)) {
                                    Storage::delete($soportes->DOCUMENTO_SOPORTECONTRATO);
                                }
                                $soportes->DOCUMENTO_SOPORTECONTRATO = null;
                                $soportes->save();
                            }

                            if ($request->boolean('ELIMINAR_FOTO_FIRMA')) {
                                if ($soportes->FOTO_FIRMA && Storage::exists($soportes->FOTO_FIRMA)) {
                                    Storage::delete($soportes->FOTO_FIRMA);
                                }
                                $soportes->FOTO_FIRMA = null;
                                $soportes->save();
                            }

                            if ($request->boolean('ELIMINAR_FOTO_FIRMA_RH')) {
                                if ($soportes->FOTO_FIRMA_RH && Storage::exists($soportes->FOTO_FIRMA_RH)) {
                                    Storage::delete($soportes->FOTO_FIRMA_RH);
                                }
                                $soportes->FOTO_FIRMA_RH = null;
                                $soportes->save();
                            }


                            if ($request->hasFile('DOCUMENTO_SOPORTECONTRATO')) {
                                if ($soportes->DOCUMENTO_SOPORTECONTRATO && Storage::exists($soportes->DOCUMENTO_SOPORTECONTRATO)) {
                                    Storage::delete($soportes->DOCUMENTO_SOPORTECONTRATO);
                                }

                                $documento   = $request->file('DOCUMENTO_SOPORTECONTRATO');
                                $curp        = $request->CURP;
                                $idDocumento = $soportes->ID_DOCUMENTO_COLABORADOR_CONTRATO;

                                $nombreArchivo = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $request->NOMBRE_DOCUMENTO_SOPORTECONTRATO)
                                    . '.' . $documento->getClientOriginalExtension();

                                $rutaCarpeta  = 'reclutamiento/' . $curp . '/Documentos de soporte de los contratos en general/' . $idDocumento;
                                $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);

                                $soportes->DOCUMENTO_SOPORTECONTRATO = $rutaCompleta;
                                $soportes->save();
                            }

                            if ($request->hasFile('FOTO_FIRMA')) {
                                if ($soportes->FOTO_FIRMA && Storage::exists($soportes->FOTO_FIRMA)) {
                                    Storage::delete($soportes->FOTO_FIRMA);
                                }

                                $firma       = $request->file('FOTO_FIRMA');
                                $curp        = $request->CURP;
                                $idDocumento = $soportes->ID_DOCUMENTO_COLABORADOR_CONTRATO;

                                $nombreFirma       = 'firma_colaborador.' . $firma->getClientOriginalExtension();
                                $rutaFirma         = 'reclutamiento/' . $curp . '/Documentos de soporte de los contratos en general/' . $idDocumento . '/firma del colaborador';
                                $rutaFirmaCompleta = $firma->storeAs($rutaFirma, $nombreFirma);

                                $soportes->FOTO_FIRMA = $rutaFirmaCompleta;
                                $soportes->save();
                            }

                            if ($request->hasFile('FOTO_FIRMA_RH')) {
                                if ($soportes->FOTO_FIRMA_RH && Storage::exists($soportes->FOTO_FIRMA_RH)) {
                                    Storage::delete($soportes->FOTO_FIRMA_RH);
                                }

                                $firma       = $request->file('FOTO_FIRMA_RH');
                                $curp        = $request->CURP;
                                $idDocumento = $soportes->ID_DOCUMENTO_COLABORADOR_CONTRATO;

                                $nombreFirma       = 'firma_rh.' . $firma->getClientOriginalExtension();
                                $rutaFirma         = 'reclutamiento/' . $curp . '/Documentos de soporte de los contratos en general/' . $idDocumento . '/firma RH';
                                $rutaFirmaCompleta = $firma->storeAs($rutaFirma, $nombreFirma);

                                $soportes->FOTO_FIRMA_RH = $rutaFirmaCompleta;
                                $soportes->save();
                            }

                            $response['code']    = 1;
                            $response['soporte'] = 'Actualizada';
                        }
                    }

                    $response['code']    = 1;
                    $response['soporte'] = $soportes;
                    return response()->json($response);
                    break;





                /////////////////////////////////////////// DOCUMENTOS DE CONTRATO //////////////////////////////////

                // INFORMACION MEDICA

                case 5:
                    if ($request->ID_INFORMACION_MEDICA == 0) {
                        DB::statement('ALTER TABLE informacion_medica_contrato AUTO_INCREMENT=1;');
                        $soportes = informacionmedicaModel::create($request->except('DOCUMENTO_INFORMACION_MEDICA', 'observacion')); 
                
                        if ($request->hasFile('DOCUMENTO_INFORMACION_MEDICA')) {
                            $documento = $request->file('DOCUMENTO_INFORMACION_MEDICA');
                            $curp = $request->CURP;
                            $idDocumento = $soportes->ID_INFORMACION_MEDICA;
                            $contratoId = $soportes->CONTRATO_ID; 
                
                            $nombreArchivo = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $request->NOMBRE_DOCUMENTO_INFORMACION) . '.' . $documento->getClientOriginalExtension();
                
                            $rutaCarpeta = 'reclutamiento/' . $curp . '/Documentos del contrato/' . $contratoId . '/Información Medica/' . $idDocumento;
                            $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);
                
                            $soportes->DOCUMENTO_INFORMACION_MEDICA = $rutaCompleta;
                            $soportes->save();
                        }
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $soportes = informacionmedicaModel::where('ID_INFORMACION_MEDICA', $request['ID_INFORMACION_MEDICA'])
                                    ->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['soporte'] = 'Desactivada';
                            } else {
                                $soportes = informacionmedicaModel::where('ID_INFORMACION_MEDICA', $request['ID_INFORMACION_MEDICA'])
                                    ->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['soporte'] = 'Activada';
                            }
                        } else {
                            $soportes = informacionmedicaModel::find($request->ID_INFORMACION_MEDICA);
                            $soportes->update($request->except('DOCUMENTO_INFORMACION_MEDICA'));
                
                            if ($request->hasFile('DOCUMENTO_INFORMACION_MEDICA')) {
                                if ($soportes->DOCUMENTO_INFORMACION_MEDICA && Storage::exists($soportes->DOCUMENTO_INFORMACION_MEDICA)) {
                                    Storage::delete($soportes->DOCUMENTO_INFORMACION_MEDICA); 
                                }
                
                                $documento = $request->file('DOCUMENTO_INFORMACION_MEDICA');
                                $curp = $request->CURP;
                                $idDocumento = $soportes->ID_INFORMACION_MEDICA;
                                $contratoId = $soportes->CONTRATO_ID; 
                
                                $nombreArchivo = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $request->NOMBRE_DOCUMENTO_INFORMACION) . '.' . $documento->getClientOriginalExtension();
                
                                $rutaCarpeta = 'reclutamiento/' . $curp . '/Documentos del contrato/' . $contratoId . '/Información Medica/' . $idDocumento;
                                $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);
                
                                $soportes->DOCUMENTO_INFORMACION_MEDICA = $rutaCompleta;
                                $soportes->save();
                            }
                
                            $response['code'] = 1;
                            $response['soporte'] = 'Actualizada';
                        }
                    }
                
                    $response['code'] = 1;
                    $response['soporte'] = $soportes;
                    return response()->json($response);
                    break;



                    // INCIDENCIAS

                    case 6:
                        if ($request->ID_INCIDENCIAS == 0) {
                            DB::statement('ALTER TABLE incidencias_contrato AUTO_INCREMENT=1;');
                            $soportes = incidenciasModel::create($request->except('DOCUMENTO_INCIDENCIAS')); 
                    
                            if ($request->hasFile('DOCUMENTO_INCIDENCIAS')) {
                                $documento = $request->file('DOCUMENTO_INCIDENCIAS');
                                $curp = $request->CURP;
                                $idDocumento = $soportes->ID_INCIDENCIAS;
                                $contratoId = $soportes->CONTRATO_ID; 
                    
                                $nombreArchivo = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $request->NOMBRE_DOCUMENTO_INCIDENCIAS) . '.' . $documento->getClientOriginalExtension();
                    
                                $rutaCarpeta = 'reclutamiento/' . $curp . '/Documentos del contrato/' . $contratoId . '/Incidencias/' . $idDocumento;
                                $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);
                    
                                $soportes->DOCUMENTO_INCIDENCIAS = $rutaCompleta;
                                $soportes->save();
                            }
                        } else {
                            if (isset($request->ELIMINAR)) {
                                if ($request->ELIMINAR == 1) {
                                    $soportes = incidenciasModel::where('ID_INCIDENCIAS', $request['ID_INCIDENCIAS'])
                                        ->update(['ACTIVO' => 0]);
                                    $response['code'] = 1;
                                    $response['soporte'] = 'Desactivada';
                                } else {
                                    $soportes = incidenciasModel::where('ID_INCIDENCIAS', $request['ID_INCIDENCIAS'])
                                        ->update(['ACTIVO' => 1]);
                                    $response['code'] = 1;
                                    $response['soporte'] = 'Activada';
                                }
                            } else {
                                $soportes = incidenciasModel::find($request->ID_INCIDENCIAS);
                                $soportes->update($request->except('DOCUMENTO_INCIDENCIAS'));
                    
                                if ($request->hasFile('DOCUMENTO_INCIDENCIAS')) {
                                    if ($soportes->DOCUMENTO_INCIDENCIAS && Storage::exists($soportes->DOCUMENTO_INCIDENCIAS)) {
                                        Storage::delete($soportes->DOCUMENTO_INCIDENCIAS); 
                                    }
                    
                                    $documento = $request->file('DOCUMENTO_INCIDENCIAS');
                                    $curp = $request->CURP;
                                    $idDocumento = $soportes->ID_INCIDENCIAS;
                                    $contratoId = $soportes->CONTRATO_ID; 
                    
                                    $nombreArchivo = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $request->NOMBRE_DOCUMENTO_INCIDENCIAS) . '.' . $documento->getClientOriginalExtension();
                    
                                    $rutaCarpeta = 'reclutamiento/' . $curp . '/Documentos del contrato/' . $contratoId . '/Incidencias/' . $idDocumento;
                                    $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);
                    
                                    $soportes->DOCUMENTO_INCIDENCIAS = $rutaCompleta;
                                    $soportes->save();
                                }
                    
                                $response['code'] = 1;
                                $response['soporte'] = 'Actualizada';
                            }
                        }
                    
                        $response['code'] = 1;
                        $response['soporte'] = $soportes;
                        return response()->json($response);
                        break;

                        


                        // ACCIONES DISCIPLINARIAS

                    case 7:
                        if ($request->ID_ACCIONES_DISCIPLINARIAS == 0) {
                            DB::statement('ALTER TABLE acciones_disciplinarias_contrato AUTO_INCREMENT=1;');
                            $soportes = accionesdisciplinariasModel::create($request->except('DOCUMENTO_ACCIONES_DISCIPLINARIAS')); 
                    
                            if ($request->hasFile('DOCUMENTO_ACCIONES_DISCIPLINARIAS')) {
                                $documento = $request->file('DOCUMENTO_ACCIONES_DISCIPLINARIAS');
                                $curp = $request->CURP;
                                $idDocumento = $soportes->ID_ACCIONES_DISCIPLINARIAS;
                                $contratoId = $soportes->CONTRATO_ID; 
                    
                                $nombreArchivo = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $request->NOMBRE_DOCUMENTO_ACCIONES) . '.' . $documento->getClientOriginalExtension();
                    
                                $rutaCarpeta = 'reclutamiento/' . $curp . '/Documentos del contrato/' . $contratoId . '/Acciones disciplinarias/' . $idDocumento;
                                $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);
                    
                                $soportes->DOCUMENTO_ACCIONES_DISCIPLINARIAS = $rutaCompleta;
                                $soportes->save();
                            }
                        } else {
                            if (isset($request->ELIMINAR)) {
                                if ($request->ELIMINAR == 1) {
                                    $soportes = accionesdisciplinariasModel::where('ID_ACCIONES_DISCIPLINARIAS', $request['ID_ACCIONES_DISCIPLINARIAS'])
                                        ->update(['ACTIVO' => 0]);
                                    $response['code'] = 1;
                                    $response['soporte'] = 'Desactivada';
                                } else {
                                    $soportes = accionesdisciplinariasModel::where('ID_ACCIONES_DISCIPLINARIAS', $request['ID_ACCIONES_DISCIPLINARIAS'])
                                        ->update(['ACTIVO' => 1]);
                                    $response['code'] = 1;
                                    $response['soporte'] = 'Activada';
                                }
                            } else {
                                $soportes = accionesdisciplinariasModel::find($request->ID_ACCIONES_DISCIPLINARIAS);
                                $soportes->update($request->except('DOCUMENTO_ACCIONES_DISCIPLINARIAS'));
                    
                                if ($request->hasFile('DOCUMENTO_ACCIONES_DISCIPLINARIAS')) {
                                    if ($soportes->DOCUMENTO_ACCIONES_DISCIPLINARIAS && Storage::exists($soportes->DOCUMENTO_ACCIONES_DISCIPLINARIAS)) {
                                        Storage::delete($soportes->DOCUMENTO_ACCIONES_DISCIPLINARIAS); 
                                    }
                    
                                    $documento = $request->file('DOCUMENTO_ACCIONES_DISCIPLINARIAS');
                                    $curp = $request->CURP;
                                    $idDocumento = $soportes->ID_ACCIONES_DISCIPLINARIAS;
                                    $contratoId = $soportes->CONTRATO_ID; 
                    
                                    $nombreArchivo = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $request->NOMBRE_DOCUMENTO_ACCIONES) . '.' . $documento->getClientOriginalExtension();
                    
                                    $rutaCarpeta = 'reclutamiento/' . $curp . '/Documentos del contrato/' . $contratoId . '/Acciones disciplinarias/' . $idDocumento;
                                    $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);
                    
                                    $soportes->DOCUMENTO_ACCIONES_DISCIPLINARIAS = $rutaCompleta;
                                    $soportes->save();
                                }
                    
                                $response['code'] = 1;
                                $response['soporte'] = 'Actualizada';
                            }
                        }
                    
                        $response['code'] = 1;
                        $response['soporte'] = $soportes;
                        return response()->json($response);
                        break;



                         // RECIBOS DE NOMINA  
                         case 8:
                            if ($request->ID_RECIBOS_NOMINA == 0) {
                                DB::statement('ALTER TABLE recibos_contrato AUTO_INCREMENT=1;');
                                $soportes = reciboscontratoModel::create($request->except('DOCUMENTO_RECIBO')); 
                        
                                if ($request->hasFile('DOCUMENTO_RECIBO')) {
                                    $documento = $request->file('DOCUMENTO_RECIBO');
                                    $curp = $request->CURP;
                                    $idDocumento = $soportes->ID_RECIBOS_NOMINA;
                                    $contratoId = $soportes->CONTRATO_ID; 
                        
                                    $nombreArchivo = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $request->NOMBRE_RECIBO) . '.' . $documento->getClientOriginalExtension();
                        
                                    $rutaCarpeta = 'reclutamiento/' . $curp . '/Documentos del contrato/' . $contratoId . '/Recibos de nómina/' . $idDocumento;
                                    $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);
                        
                                    $soportes->DOCUMENTO_RECIBO = $rutaCompleta;
                                    $soportes->save();
                                }
                            } else {
                                if (isset($request->ELIMINAR)) {
                                    if ($request->ELIMINAR == 1) {
                                        $soportes = reciboscontratoModel::where('ID_RECIBOS_NOMINA', $request['ID_RECIBOS_NOMINA'])
                                            ->update(['ACTIVO' => 0]);
                                        $response['code'] = 1;
                                        $response['soporte'] = 'Desactivada';
                                    } else {
                                        $soportes = reciboscontratoModel::where('ID_RECIBOS_NOMINA', $request['ID_RECIBOS_NOMINA'])
                                            ->update(['ACTIVO' => 1]);
                                        $response['code'] = 1;
                                        $response['soporte'] = 'Activada';
                                    }
                                } else {
                                    $soportes = reciboscontratoModel::find($request->ID_RECIBOS_NOMINA);
                                    $soportes->update($request->except('DOCUMENTO_RECIBO'));
                        
                                    if ($request->hasFile('DOCUMENTO_RECIBO')) {
                                        if ($soportes->DOCUMENTO_RECIBO && Storage::exists($soportes->DOCUMENTO_RECIBO)) {
                                            Storage::delete($soportes->DOCUMENTO_RECIBO); 
                                        }
                        
                                        $documento = $request->file('DOCUMENTO_RECIBO');
                                        $curp = $request->CURP;
                                        $idDocumento = $soportes->ID_RECIBOS_NOMINA;
                                        $contratoId = $soportes->CONTRATO_ID; 
                        
                                        $nombreArchivo = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $request->NOMBRE_RECIBO) . '.' . $documento->getClientOriginalExtension();
                        
                                        $rutaCarpeta = 'reclutamiento/' . $curp . '/Documentos del contrato/' . $contratoId . '/Recibos de nómina/' . $idDocumento;
                                        $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);
                        
                                        $soportes->DOCUMENTO_RECIBO = $rutaCompleta;
                                        $soportes->save();
                                    }
                        
                                    $response['code'] = 1;
                                    $response['soporte'] = 'Actualizada';
                                }
                            }
                        
                            $response['code'] = 1;
                            $response['soporte'] = $soportes;
                            return response()->json($response);
                            break;
                        


                              // DOCUMENTOS DE SOPORTE DEL CONTRATO
                         case 9:
                            if ($request->ID_SOPORTE_CONTRATO == 0) {
                                DB::statement('ALTER TABLE documentos_soporte_contrato AUTO_INCREMENT=1;');
                                $soportes = documentosoportecontratoModel::create($request->except('DOCUMENTOS_SOPORTECONTRATOS')); 
                        
                                if ($request->hasFile('DOCUMENTOS_SOPORTECONTRATOS')) {
                                    $documento = $request->file('DOCUMENTOS_SOPORTECONTRATOS');
                                    $curp = $request->CURP;
                                    $idDocumento = $soportes->ID_SOPORTE_CONTRATO;
                                    $contratoId = $soportes->CONTRATO_ID; 
                        
                                    $nombreArchivo = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $request->NOMBRE_DOCUMENTOSOPORTECONTRATO) . '.' . $documento->getClientOriginalExtension();
                        
                                    $rutaCarpeta = 'reclutamiento/' . $curp . '/Documentos del contrato/' . $contratoId . '/Documentos de soporte del contrato/' . $idDocumento;
                                    $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);
                        
                                    $soportes->DOCUMENTOS_SOPORTECONTRATOS = $rutaCompleta;
                                    $soportes->save();
                                }
                            } else {
                                if (isset($request->ELIMINAR)) {
                                    if ($request->ELIMINAR == 1) {
                                        $soportes = documentosoportecontratoModel::where('ID_SOPORTE_CONTRATO', $request['ID_SOPORTE_CONTRATO'])
                                            ->update(['ACTIVO' => 0]);
                                        $response['code'] = 1;
                                        $response['soporte'] = 'Desactivada';
                                    } else {
                                        $soportes = documentosoportecontratoModel::where('ID_SOPORTE_CONTRATO', $request['ID_SOPORTE_CONTRATO'])
                                            ->update(['ACTIVO' => 1]);
                                        $response['code'] = 1;
                                        $response['soporte'] = 'Activada';
                                    }
                                } else {
                                    $soportes = documentosoportecontratoModel::find($request->ID_SOPORTE_CONTRATO);
                                    $soportes->update($request->except('DOCUMENTOS_SOPORTECONTRATOS'));
                        
                                    if ($request->hasFile('DOCUMENTOS_SOPORTECONTRATOS')) {
                                        if ($soportes->DOCUMENTOS_SOPORTECONTRATOS && Storage::exists($soportes->DOCUMENTOS_SOPORTECONTRATOS)) {
                                            Storage::delete($soportes->DOCUMENTOS_SOPORTECONTRATOS); 
                                        }
                        
                                        $documento = $request->file('DOCUMENTOS_SOPORTECONTRATOS');
                                        $curp = $request->CURP;
                                        $idDocumento = $soportes->ID_SOPORTE_CONTRATO;
                                        $contratoId = $soportes->CONTRATO_ID; 
                        
                                        $nombreArchivo = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $request->NOMBRE_DOCUMENTOSOPORTECONTRATO) . '.' . $documento->getClientOriginalExtension();
                        
                                        $rutaCarpeta = 'reclutamiento/' . $curp . '/Documentos del contrato/' . $contratoId . '/Documentos de soporte del contrato/' . $idDocumento;
                                        $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);
                        
                                        $soportes->DOCUMENTOS_SOPORTECONTRATOS = $rutaCompleta;
                                        $soportes->save();
                                    }
                        
                                    $response['code'] = 1;
                                    $response['soporte'] = 'Actualizada';
                                }
                            }
                        
                            $response['code'] = 1;
                            $response['soporte'] = $soportes;
                            return response()->json($response);
                            break;




                case 10:

                    if ($request->ID_RENOVACION_CONTATO == 0) {
                        DB::statement('ALTER TABLE renovacion_contrato AUTO_INCREMENT=1;');
                        $soportes = renovacioncontratoModel::create($request->except('DOCUMENTOS_RENOVACION'));

                        if ($request->hasFile('DOCUMENTOS_RENOVACION')) {
                            $documento = $request->file('DOCUMENTOS_RENOVACION');
                            $curp = $request->CURP;
                            $idDocumento = $soportes->ID_RENOVACION_CONTATO;
                            $contratoId = $soportes->CONTRATO_ID;

                            $nombreArchivo = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $request->NOMBRE_DOCUMENTO_RENOVACION) . '.' . $documento->getClientOriginalExtension();

                            $rutaCarpeta = "reclutamiento/{$curp}/Documentos del contrato/{$contratoId}/Renovación de contrato/{$idDocumento}";
                            $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);

                            $soportes->DOCUMENTOS_RENOVACION = $rutaCompleta;
                            $soportes->save();
                        }
                    } else {
                        if (isset($request->ELIMINAR)) {
                            $soportes = renovacioncontratoModel::where('ID_RENOVACION_CONTATO', $request['ID_RENOVACION_CONTATO'])
                                ->update(['ACTIVO' => $request->ELIMINAR == 1 ? 0 : 1]);

                            $response['code'] = 1;
                            $response['soporte'] = $request->ELIMINAR == 1 ? 'Desactivada' : 'Activada';
                        } else {
                            $soportes = renovacioncontratoModel::find($request->ID_RENOVACION_CONTATO);

                            if (!$soportes) {
                                return response()->json(['error' => 'Renovación no encontrada'], 404);
                            }

                            $documentoAnterior = $soportes->DOCUMENTOS_RENOVACION;

                            $soportes->update($request->except('DOCUMENTOS_RENOVACION'));

                            if ($request->hasFile('DOCUMENTOS_RENOVACION')) {
                                if ($documentoAnterior && Storage::exists($documentoAnterior)) {
                                    Storage::delete($documentoAnterior);
                                }

                                $documento = $request->file('DOCUMENTOS_RENOVACION');
                                $curp = $request->CURP;
                                $idDocumento = $soportes->ID_RENOVACION_CONTATO;
                                $contratoId = $soportes->CONTRATO_ID;

                                $nombreArchivo = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $request->NOMBRE_DOCUMENTO_RENOVACION) . '.' . $documento->getClientOriginalExtension();

                                $rutaCarpeta = "reclutamiento/{$curp}/Documentos del contrato/{$contratoId}/Renovación de contrato/{$idDocumento}";
                                $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);

                                $soportes->DOCUMENTOS_RENOVACION = $rutaCompleta;
                            } else {
                                $soportes->DOCUMENTOS_RENOVACION = $documentoAnterior;
                            }

                            $soportes->save();
                            $response['code'] = 1;
                            $response['soporte'] = 'Actualizada';
                        }
                    }

                    if ($request->filled('FECHAI_ADENDA')) {
                        $fechasInicio = $request->FECHAI_ADENDA;
                        $fechasFin = $request->FECHAF_ADENDA;
                        $comentarios = $request->COMENTARIO_ADENDA;
                        $archivos = $request->file('DOCUMENTO_ADENDA');
                        $curp = $request->CURP;
                        $contratoId = $soportes->CONTRATO_ID;
                        $renovacionId = $soportes->ID_RENOVACION_CONTATO;

                        $adendasAnteriores = adendarenovacionModel::where('RENOVACION_ID', $renovacionId)->get()->toArray();

                        adendarenovacionModel::where('RENOVACION_ID', $renovacionId)->delete();

                        foreach ($fechasInicio as $i => $inicio) {
                            $archivoRuta = null;

                            if (isset($archivos[$i]) && $archivos[$i]->isValid()) {
                                $archivo = $archivos[$i];
                                $nombre = 'adenda_' . ($i + 1) . '.' . $archivo->getClientOriginalExtension();

                                $rutaAdenda = "reclutamiento/{$curp}/Documentos del contrato/{$contratoId}/Renovación de contrato/{$renovacionId}/adenda/" . ($i + 1);
                                $archivoRuta = $archivo->storeAs($rutaAdenda, $nombre);
                            } elseif (isset($adendasAnteriores[$i]['DOCUMENTO_ADENDA'])) {
                                $archivoRuta = $adendasAnteriores[$i]['DOCUMENTO_ADENDA'];
                            }

                            adendarenovacionModel::create([
                                'RENOVACION_ID' => $renovacionId,
                                'FECHAI_ADENDA' => $inicio,
                                'FECHAF_ADENDA' => $fechasFin[$i] ?? null,
                                'COMENTARIO_ADENDA' => $comentarios[$i] ?? '',
                                'DOCUMENTO_ADENDA' => $archivoRuta
                            ]);
                        }
                    }

                    $response['code'] = 1;
                    $response['soporte'] = $soportes;
                    return response()->json($response);





                    // REQUSICION CONTRATACION


                case 11:
                                if ($request->ID_CONTRATACION_REQUERIMIENTO == 0) {
                                    DB::statement('ALTER TABLE contratacion_requisicion AUTO_INCREMENT=1;');

                                    $requerimientos = requisicioncontratacion::create($request->all());

                                    if ($request->hasFile('DOCUMENTO_REQUISICION')) {
                                        $file = $request->file('DOCUMENTO_REQUISICION');

                                        $folderPath = "Requisición de personal/{$requerimientos->ID_CONTRATACION_REQUERIMIENTO}";
                                        $fileName = $file->getClientOriginalName();

                                        $filePath = $file->storeAs($folderPath, $fileName);

                                        $requerimientos->DOCUMENTO_REQUISICION = $filePath;
                                        $requerimientos->save();
                                    }
                                } else {
                                    if (isset($request->ELIMINAR)) {
                                        if ($request->ELIMINAR == 1) {
                                            $requerimientos = requisicioncontratacion::where('ID_CONTRATACION_REQUERIMIENTO', $request['ID_CONTRATACION_REQUERIMIENTO'])->update(['ACTIVO' => 0]);
                                            $response['code'] = 1;
                                            $response['requerimiento'] = 'Desactivada';
                                        } else {
                                            $requerimientos = requisicioncontratacion::where('ID_CONTRATACION_REQUERIMIENTO', $request['ID_CONTRATACION_REQUERIMIENTO'])->update(['ACTIVO' => 1]);
                                            $response['code'] = 1;
                                            $response['requerimiento'] = 'Activada';
                                        }
                                    } else {
                                        $requerimientos = requisicioncontratacion::find($request->ID_CONTRATACION_REQUERIMIENTO);

                                        $requerimientos->update($request->all());

                                        if ($request->hasFile('DOCUMENTO_REQUISICION')) {
                                            $file = $request->file('DOCUMENTO_REQUISICION');

                                            if ($requerimientos->DOCUMENTO_REQUISICION && Storage::exists($requerimientos->DOCUMENTO_REQUISICION)) {
                                                Storage::delete($requerimientos->DOCUMENTO_REQUISICION);
                                            }

                                            $folderPath = "Requisición de personal/{$requerimientos->ID_CONTRATACION_REQUERIMIENTO}";
                                            $fileName = $file->getClientOriginalName();

                                            $filePath = $file->storeAs($folderPath, $fileName);

                                            $requerimientos->DOCUMENTO_REQUISICION = $filePath;
                                            $requerimientos->save();
                                        }
                                        $response['code'] = 1;
                                        $response['requerimiento'] = 'Actualizada';
                                    }
                                    return response()->json($response);
                                }

                                $response['code']  = 1;
                                $response['requerimiento']  = $requerimientos;
                                return response()->json($response);

                                break;







                    // ASIGNACIONES COLABORADOR 

               

                case 12:

                    try {

                        function normalizarAsignaciones($value)
                        {
                            if (is_array($value)) {
                                return $value;
                            }

                            if (is_string($value)) {

                                $decoded = json_decode($value, true);

                                // Si sigue siendo string, estaba doble encodeado
                                if (is_string($decoded)) {
                                    $decoded = json_decode($decoded, true);
                                }

                                if (is_array($decoded)) {
                                    return $decoded;
                                }
                            }

                            return [];
                        }

                        
                        // =========================
                        // NORMALIZAR ASIGNACIONES_ID
                        // =========================
                        $asignacionesArray = normalizarAsignaciones(
                            $request->ASIGNACIONES_ID ?? null
                        );

                        // SIEMPRE guardar como JSON STRING
                        $asignacionesJson = json_encode($asignacionesArray);

                        // =========================
                        // NUEVO
                        // =========================
                        if ((int)$request->ID_ASINGACIONES_CONTRATACION === 0) {

                            DB::statement('ALTER TABLE asignaciones_contratacion AUTO_INCREMENT = 1');

                            $soportes = asignacioncontratacionModel::create(
                                array_merge(
                                    $request->except('DOCUMENTO_ASIGNACION', 'ASIGNACIONES_ID'),
                                    [
                                        'ASIGNACIONES_ID' => $asignacionesJson
                                    ]
                                )
                            );

                            if ($request->hasFile('DOCUMENTO_ASIGNACION')) {

                                $documento = $request->file('DOCUMENTO_ASIGNACION');
                                $ruta = "reclutamiento/{$request->CURP}/Asignaciones/{$soportes->ID_ASINGACIONES_CONTRATACION}";
                                $nombre = 'Documento de asignacion.' . $documento->getClientOriginalExtension();

                                $soportes->update([
                                    'DOCUMENTO_ASIGNACION' => $documento->storeAs($ruta, $nombre)
                                ]);
                            }
                        }
                        // =========================
                        // EDITAR
                        // =========================
                        else {

                            $soportes = asignacioncontratacionModel::findOrFail(
                                $request->ID_ASINGACIONES_CONTRATACION
                            );

                            $soportes->update(
                                array_merge(
                                    $request->except('DOCUMENTO_ASIGNACION', 'ASIGNACIONES_ID'),
                                    [
                                        'ASIGNACIONES_ID' => $asignacionesJson
                                    ]
                                )
                            );

                            if ($request->hasFile('DOCUMENTO_ASIGNACION')) {

                                if ($soportes->DOCUMENTO_ASIGNACION && Storage::exists($soportes->DOCUMENTO_ASIGNACION)) {
                                    Storage::delete($soportes->DOCUMENTO_ASIGNACION);
                                }

                                $documento = $request->file('DOCUMENTO_ASIGNACION');
                                $ruta = "reclutamiento/{$request->CURP}/Asignaciones/{$soportes->ID_ASINGACIONES_CONTRATACION}";
                                $nombre = 'Documento de asignacion.' . $documento->getClientOriginalExtension();

                                $soportes->update([
                                    'DOCUMENTO_ASIGNACION' => $documento->storeAs($ruta, $nombre)
                                ]);
                            }
                        }

                        return response()->json([
                            'code' => 1,
                            'soporte' => $soportes
                        ]);
                    } catch (\Throwable $e) {

                        return response()->json([
                            'code' => 0,
                            'error' => 'Error al guardar el contrato',
                            'detalle' => $e->getMessage()
                        ], 500);
                    }

                    break;






                default:
                $response['code'] = 1;
                $response['msj'] = 'Api no encontrada';
                return response()->json($response);
        }
    } catch (Exception $e) {
        return response()->json('Error al guardar el contrato');
    }
}



}
