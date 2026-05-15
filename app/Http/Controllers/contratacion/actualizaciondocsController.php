<?php

namespace App\Http\Controllers\contratacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


use App\Models\contratacion\fechasactualizaciondocs;
use App\Models\contratacion\documentosactualizadosModel;
use App\Models\contratacion\documentosoporteModel;

use DB;

class actualizaciondocsController extends Controller
{

    public function index()
    {
        $ultimaFecha = fechasactualizaciondocs::where('ACTIVO', 1)
            ->orderBy('ID_ACTUALIZACION_DOCUMENTOS', 'desc')
            ->first();

        $documentos = [
            1  => 'Copia del INE',
            2  => 'Copia del Pasaporte',
            3  => 'Copia de la licencia de conducción tipo chofer',
            5  => 'Copia del acta de nacimiento',
            6  => 'Copia de la CURP',
            9  => 'Copia del comprobante de domicilio',
            12 => 'Constancia de situación fiscal',
            14 => 'Visa',
            15 => 'Credencial de residente',
            16 => 'Aviso o carta de retención de INFONAVIT',

        ];

        $documentosSeleccionados = [];

        if ($ultimaFecha && $ultimaFecha->TIPO_DOCUMENTO) {
            $documentosSeleccionados = json_decode($ultimaFecha->TIPO_DOCUMENTO, true);
        }

        return view(
            'RH.contratacion.actualizaciondoc',
            compact('ultimaFecha', 'documentos', 'documentosSeleccionados')
        );
    }



    public function Tabladocumentosactualizados()
    {
        try {

            $tabla = DB::table('documento_actualizados as da')
                ->leftJoin('formulario_contratacion as fc', 'da.CURP', '=', 'fc.CURP')
                ->where('da.ACTUALIZAR_DOCUMENTO', 1)
                ->where(function ($query) {
                    $query->whereNull('da.ESTADO_DOCUMENTO')
                        ->orWhere('da.ESTADO_DOCUMENTO', '');
                })
                ->select(
                    'da.*',
                        DB::raw("CONCAT(
                        COALESCE(fc.NOMBRE_COLABORADOR,''), ' ',
                        COALESCE(fc.PRIMER_APELLIDO,''), ' ',
                        COALESCE(fc.SEGUNDO_APELLIDO,'')
                    ) as NOMBRE_COMPLETO")
                )
                ->get();

            foreach ($tabla as $value) {

                $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR">
                                    <i class="bi bi-eye"></i>
                                  </button>';

                $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-documentosactualizados"
                                        data-id="' . $value->ID_DOCUMENTOS_ACTUALIZADOS . '"
                                        title="Ver documento">
                                        <i class="bi bi-filetype-pdf"></i>
                                    </button>';

                $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR">
                                        <i class="bi bi-eye"></i>
                                      </button>';
            }

            return response()->json([
                'data' => $tabla,
                'msj'  => 'Información consultada correctamente'
            ]);
        } catch (Exception $e) {

            return response()->json([
                'msj'  => 'Error ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }




    public function aceptarDocumentoActualizado(Request $request)
    {
        try {

            DB::beginTransaction();

            $idActualizacion = $request->ID_DOCUMENTOS_ACTUALIZADOS;

            $actualizacion = documentosactualizadosModel::where(
                'ID_DOCUMENTOS_ACTUALIZADOS',
                $idActualizacion
            )->first();

            if (!$actualizacion) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Documento no encontrado'
                ]);
            }

            $actualizacion->ESTADO_DOCUMENTO = 1;
            $actualizacion->save();


            documentosoporteModel::where(
                'ID_DOCUMENTO_SOPORTE',
                $actualizacion->DOCUMENTOS_ID
            )->update([
                'PROCEDE_FECHA_DOC'       => $actualizacion->PROCEDE_FECHA_DOC,
                'FECHAI_DOCUMENTOSOPORTE' => $actualizacion->FECHAI_DOCUMENTOSOPORTE,
                'FECHAF_DOCUMENTOSOPORTE' => $actualizacion->FECHAF_DOCUMENTOSOPORTE,
                'DOCUMENTO_SOPORTE'       => $actualizacion->DOCUMENTO_SOPORTE,
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Documento aceptado correctamente'
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Error al aceptar documento',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function rechazarDocumentoActualizado(Request $request)
    {
        try {

            $idActualizacion = $request->ID_DOCUMENTOS_ACTUALIZADOS;

            $actualizacion = documentosactualizadosModel::where(
                'ID_DOCUMENTOS_ACTUALIZADOS',
                $idActualizacion
            )->first();

            if (!$actualizacion) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Documento no encontrado'
                ]);
            }

            $actualizacion->ACTIVO = 0;
            $actualizacion->ESTADO_DOCUMENTO = 2; 
            $actualizacion->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Documento rechazado correctamente'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => 'Error al rechazar documento',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function mostrardocumentoactualizado($id)
    {
        $archivo = documentosactualizadosModel::findOrFail($id)->DOCUMENTO_SOPORTE;
        return Storage::response($archivo);
    }


  
    public function store(Request $request)
    {
        try {

            switch (intval($request->api)) {

                case 1:

                    $registroExistente = fechasactualizaciondocs::where('FECHA_INICIO', $request->FECHA_INICIO)
                        ->where('FECHA_FIN', $request->FECHA_FIN)
                        ->first();

                    if ($registroExistente) {

                        $registroExistente->update([
                            'TIPO_DOCUMENTO' => json_encode($request->TIPO_DOCUMENTO ?? []),
                            'ACTIVO'         => 1
                        ]);

                        return response()->json([
                            'code' => 1,
                            'fecha' => $registroExistente,
                            'accion' => 'actualizado'
                        ]);
                    }

                    $nuevoRegistro = fechasactualizaciondocs::create([
                        'FECHA_INICIO'   => $request->FECHA_INICIO,
                        'FECHA_FIN'      => $request->FECHA_FIN,
                        'TIPO_DOCUMENTO' => json_encode($request->TIPO_DOCUMENTO ?? []),
                        'ACTIVO'         => 1
                    ]);

                    return response()->json([
                        'code' => 1,
                        'fecha' => $nuevoRegistro,
                        'accion' => 'creado'
                    ]);

                    break;

                default:
                    return response()->json([
                        'code' => 0,
                        'msj' => 'Api no encontrada'
                    ]);
            }
        } catch (Exception $e) {

            return response()->json([
                'code' => 0,
                'msj' => 'Error al guardar las fechas',
                'error' => $e->getMessage()
            ]);
        }
    }


    }
