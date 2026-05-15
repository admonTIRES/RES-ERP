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


class actualizaciondochistorialController extends Controller
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
        ];

        $documentosSeleccionados = [];

        if ($ultimaFecha && $ultimaFecha->TIPO_DOCUMENTO) {
            $documentosSeleccionados = json_decode($ultimaFecha->TIPO_DOCUMENTO, true);
        }

        return view(
            'RH.contratacion.actualizaciondochistorial',
            compact('ultimaFecha', 'documentos', 'documentosSeleccionados')
        );
    }


    public function Tabladocumentosactualizadohistorial()
    {
        try {

            $tabla = DB::table('documento_actualizados as da')
                ->leftJoin('formulario_contratacion as fc', 'da.CURP', '=', 'fc.CURP')
                ->where('da.ACTUALIZAR_DOCUMENTO', 1)
                ->where('da.ESTADO_DOCUMENTO', 1) 
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

    }
