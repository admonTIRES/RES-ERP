<?php

namespace App\Http\Controllers\recursosempleado;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Models\contratacion\contratacionModel;
use App\Models\contratacion\documentosoporteModel;
use App\Models\organizacion\catalogotipovacanteModel;
use App\Models\organizacion\catalogomotivovacanteModel;
use App\Models\organizacion\areasModel;
use App\Models\contratacion\documentosactualizadosModel;
use App\Models\contratacion\fechasactualizaciondocs;


use DB;




class expedientecolabController extends Controller
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


        return view('RH.RecEmpleados.expedientecolaborador', compact('areas', 'tipos', 'motivos', 'areas1', 'todascategoria', 'categoria', 'areas2', 'requisicioncategoria'));
    }



    public function Tablaexpediente()
    {
        try {

        
            $curpUsuario = Auth::user()->CURP;

            $tabla = contratacionModel::where('ACTIVO', 1)
                ->where('CURP', $curpUsuario)
                ->get();

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

                    $fechaInicio = $renovacion ? $renovacion->FECHAI_RENOVACION : $contrato->FECHAI_CONTRATO;
                    $fechaFin = $renovacion ? $renovacion->FECHAF_RENOVACION : $contrato->VIGENCIA_CONTRATO;
                } else {
                    $fechaInicio = null;
                    $fechaFin = null;
                }

                if ($fechaInicio && $fechaFin) {
                    $inicio = new \DateTime($fechaInicio);
                    $fin = new \DateTime($fechaFin);
                    $hoy = new \DateTime();

                    $totalDias = $inicio->diff($fin)->days;
                    $diasRestantes = ($fin >= $hoy) ? $hoy->diff($fin)->days : -$hoy->diff($fin)->days;

                    $umbralVerde = $totalDias * 0.60;
                    $umbralAmarillo = $totalDias * 0.30;

                    if ($diasRestantes <= 0) {
                        $estado_dias = "<span style='color: red;'>(Terminado)</span>";
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

                // Botones
                $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR"><i class="bi bi-eye"></i></button>';
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








    /////////////////////////////////////////// STEP 2 DOCUMENTOS DE SOPORTE //////////////////////////////////


    public function validarPeriodoActualizacion()
    {
        try {

            $ultimo = fechasactualizaciondocs::orderBy('ID_ACTUALIZACION_DOCUMENTOS', 'desc')
                ->first();

            if (!$ultimo) {
                return response()->json([
                    'ok' => true,
                    'mostrar' => false
                ]);
            }

            $hoy = Carbon::now();

            $inicio = Carbon::parse($ultimo->FECHA_INICIO)->startOfDay();
            $fin = Carbon::parse($ultimo->FECHA_FIN)->endOfDay();



            return response()->json([
                'ok' => true,
                'mostrar' => $hoy->between($inicio, $fin)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'ok' => false,
                'mostrar' => false
            ]);
        }
    }



    public function Tabladocumentosoportexpediente(Request $request)
    {
        try {

            $curp = $request->get('curp');

            $ultimaFecha = fechasactualizaciondocs::latest('ID_ACTUALIZACION_DOCUMENTOS')->first();

            if (!$ultimaFecha) {
                return response()->json(['data' => []]);
            }

            $hoy = now()->format('Y-m-d');

            $fechaInicio = $ultimaFecha->FECHA_INICIO;
            $fechaFin    = $ultimaFecha->FECHA_FIN;

            $query = documentosoporteModel::where('CURP', $curp)
                ->whereNotExists(function ($sub) use ($ultimaFecha) {
                    $sub->select(DB::raw(1))
                        ->from('documento_actualizados as da')
                        ->whereColumn('da.DOCUMENTOS_ID', 'documentos_soporte_contratacion.ID_DOCUMENTO_SOPORTE')
                        ->where('da.ACTIVO', 1)
                        ->whereBetween('da.created_at', [
                            $ultimaFecha->FECHA_INICIO,
                            $ultimaFecha->FECHA_FIN
                        ]);
                });




            if ($hoy < $fechaInicio) {

                return response()->json(['data' => []]);
            }

            if ($hoy >= $fechaInicio && $hoy <= $fechaFin) {

                $tiposPermitidos = json_decode($ultimaFecha->TIPO_DOCUMENTO ?? '[]', true);

                if (empty($tiposPermitidos)) {
                    return response()->json(['data' => []]);
                }

                $query->whereIn('TIPO_DOCUMENTO', $tiposPermitidos);
            }

            if ($hoy > $fechaFin) {

                $query->where('RENOVACION_DOCUMENTO', 1);
            }

            $tabla = $query->get();

            foreach ($tabla as $value) {

                $value->BTN_EDITAR = ($value->ACTIVO == 0)
                    ? '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR">
                        <i class="bi bi-eye"></i>
                   </button>'
                    : '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR">
                        <i class="bi bi-pencil-square"></i>
                   </button>';

                $value->BTN_DOCUMENTO =
                    '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-documentosoporte"
                    data-id="' . $value->ID_DOCUMENTO_SOPORTE . '"
                    title="Ver documento">
                    <i class="bi bi-filetype-pdf"></i>
                </button>';

                $value->BTN_VISUALIZAR =
                    '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR">
                    <i class="bi bi-eye"></i>
                </button>';
            }

            return response()->json([
                'data' => $tabla
            ]);
        } catch (Exception $e) {

            return response()->json([
                'data' => [],
                'error' => $e->getMessage()
            ], 500);
        }
    }






    public function store(Request $request)
    {
        try {
            switch (intval($request->api)) {




                case 1:
                    if ($request->ID_DOCUMENTOS_ACTUALIZADOS == 0) {
                        DB::statement('ALTER TABLE documento_actualizados AUTO_INCREMENT=1;');
                        $soportes = documentosactualizadosModel::create($request->except('DOCUMENTO_SOPORTE'));

                        if ($request->hasFile('DOCUMENTO_SOPORTE')) {
                            $documento = $request->file('DOCUMENTO_SOPORTE');
                            $curp = $request->CURP;
                            $idDocumento = $soportes->ID_DOCUMENTOS_ACTUALIZADOS;

                            $nombreArchivo =  preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $request->NOMBRE_DOCUMENTO) . '.' . $documento->getClientOriginalExtension();

                            $rutaCarpeta = 'reclutamiento/' . $curp . '/Documentos actualizados/' . $idDocumento;
                            $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);

                            $soportes->DOCUMENTO_SOPORTE = $rutaCompleta;
                            $soportes->save();
                        }
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $soportes = documentosactualizadosModel::where('ID_DOCUMENTOS_ACTUALIZADOS', $request['ID_DOCUMENTOS_ACTUALIZADOS'])
                                    ->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['soporte'] = 'Desactivada';
                            } else {
                                $soportes = documentosactualizadosModel::where('ID_DOCUMENTOS_ACTUALIZADOS', $request['ID_DOCUMENTOS_ACTUALIZADOS'])
                                    ->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['soporte'] = 'Activada';
                            }
                        } else {
                            $soportes = documentosactualizadosModel::find($request->ID_DOCUMENTOS_ACTUALIZADOS);
                            $soportes->update($request->except('DOCUMENTO_SOPORTE'));

                            if ($request->hasFile('DOCUMENTO_SOPORTE')) {

                                if ($soportes->DOCUMENTO_SOPORTE && Storage::exists($soportes->DOCUMENTO_SOPORTE)) {
                                    Storage::delete($soportes->DOCUMENTO_SOPORTE);
                                }

                                $documento = $request->file('DOCUMENTO_SOPORTE');
                                $curp = $request->CURP;
                                $idDocumento = $soportes->ID_DOCUMENTOS_ACTUALIZADOS;

                                $nombreArchivo =  preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $request->NOMBRE_DOCUMENTO) . '.' . $documento->getClientOriginalExtension();

                                $rutaCarpeta = 'reclutamiento/' . $curp . '/Documentos actualizados/' . $idDocumento;
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
