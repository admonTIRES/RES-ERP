<?php

namespace App\Http\Controllers\confirmacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

use DB;

use App\Models\solicitudes\solicitudesModel;
use App\Models\ofertas\ofertasModel;
use App\Models\confirmacion\confirmacionModel;
use App\Models\confirmacion\catalogoverificacioninformacionModel;
use App\Models\confirmacion\evidenciaconfirmacionModel;


class confirmacionhistorialController extends Controller
{
    public function index()
    {
        $ofertasAsignadas = confirmacionModel::pluck('OFERTA_ID')->toArray();

        $ofertas = ofertasModel::select('ID_FORMULARIO_OFERTAS', 'NO_OFERTA')
            ->where('ESTATUS_OFERTA', 'like', '%Aceptada%')
            ->whereNotIn('ID_FORMULARIO_OFERTAS', $ofertasAsignadas)
            ->get();

        $solicitudes = collect();

        $grupos = $ofertas->groupBy(function ($item) {
            return preg_replace('/-Rev\d+$/', '', $item->NO_OFERTA);
        });

        $grupos->each(function ($grupo, $claveBase) use (&$solicitudes) {
            $ultimo = $grupo->sortByDesc(function ($item) {
                if (preg_match('/-Rev(\d+)$/', $item->NO_OFERTA, $m)) {
                    return (int) $m[1];
                }
                return 0;
            })->first();

            $solicitudes->push($ultimo);
        });

        $verificaciones = CatalogoVerificacionInformacionModel::where('ACTIVO', 1)->get();

        return view('ventas.confirmacion.confirmacionhistorial', compact('solicitudes', 'verificaciones'));
    }



    public function Tablaconfirmacionhistorial(Request $request)
    {
        try {

            $query = confirmacionModel::select(
                'formulario_confirmacion.*',
                'formulario_ofertas.NO_OFERTA'
            )
                ->leftJoin(
                    'formulario_ofertas',
                    'formulario_confirmacion.OFERTA_ID',
                    '=',
                    'formulario_ofertas.ID_FORMULARIO_OFERTAS'
                );

            if ($request->filled('FECHA_INICIO') && $request->filled('FECHA_FIN')) {
                $query->whereBetween(
                    DB::raw('DATE(formulario_confirmacion.FECHA_CONFIRMACION)'),
                    [$request->FECHA_INICIO, $request->FECHA_FIN]
                );
            }

            $tabla = $query->get();

            $rows = [];

            foreach ($tabla as $value) {

                $evidencias = evidenciaconfirmacionModel::where(
                    'CONFIRMACION_ID',
                    $value->ID_FORMULARIO_CONFRIMACION
                )->get();

                $evidenciasAgrupadas = [];

                foreach ($evidencias as $evidencia) {
                    $evidenciasAgrupadas[] = [
                        'NOMBRE_EVIDENCIA'    => $evidencia->NOMBRE_EVIDENCIA,
                        'DOCUMENTO_EVIDENCIA' => $evidencia->DOCUMENTO_EVIDENCIA,
                        'BTN_DOCUMENTO'       =>
                        '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-evidencia"
                            data-id="' . $evidencia->ID_EVIDENCIA_CONFIRMACION . '">
                            <i class="bi bi-filetype-pdf"></i>
                        </button>'
                    ];
                }

                $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                $value->BTN_DOCUMENTO  = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-aceptacion" data-id="' . $value->ID_FORMULARIO_CONFRIMACION . '"><i class="bi bi-filetype-pdf"></i></button>';
                $value->BTN_ELIMINAR   = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_CONFRIMACION . '" checked><span class="slider round"></span></label>';

                $rows[] = [
                    'ID_FORMULARIO_CONFRIMACION' => $value->ID_FORMULARIO_CONFRIMACION,
                    'OFERTA_ID'                  => $value->OFERTA_ID,
                    'ACEPTACION_CONFIRMACION'    => $value->ACEPTACION_CONFIRMACION,
                    'FECHA_CONFIRMACION'         => $value->FECHA_CONFIRMACION,
                    'QUIEN_ACEPTA'               => $value->QUIEN_ACEPTA,
                    'CARGO_ACEPTACION'           => $value->CARGO_ACEPTACION,
                    'DOCUMENTO_ACEPTACION'       => $value->DOCUMENTO_ACEPTACION,
                    'PROCEDE_ORDEN'              => $value->PROCEDE_ORDEN,
                    'NO_CONFIRMACION'            => $value->NO_CONFIRMACION,
                    'FECHA_EMISION'              => $value->FECHA_EMISION,
                    'FECHA_VALIDACION'           => $value->FECHA_VALIDACION,
                    'ACTIVO'                     => $value->ACTIVO,
                    'QUIEN_VALIDA'               => $value->QUIEN_VALIDA,
                    'COMENTARIO_VALIDACION'      => $value->COMENTARIO_VALIDACION,
                    'VERIFICACION_INFORMACION'   => $value->VERIFICACION_INFORMACION,
                    'ESTADO_VERIFICACION'        => $value->ESTADO_VERIFICACION,
                    'NO_OFERTA'                  => $value->NO_OFERTA,
                    'EVIDENCIAS'                 => $evidenciasAgrupadas,
                    'BTN_VISUALIZAR'             => $value->BTN_VISUALIZAR,
                    'BTN_DOCUMENTO'              => $value->BTN_DOCUMENTO,
                    'BTN_ELIMINAR'               => $value->BTN_ELIMINAR,
                    'BTN_EDITAR'                 => ($value->ACTIVO == 0)
                        ? '<button class="btn btn-secondary btn-custom rounded-pill" disabled><i class="bi bi-ban"></i></button>'
                        : '<button class="btn btn-secondary btn-custom rounded-pill disabled"><i class="bi bi-ban"></i></button>',
                    'BTN_CORREO'                 => ($value->ACTIVO == 0)
                        ? '<button class="btn btn-info btn-custom rounded-pill" disabled><i class="bi bi-ban"></i></button>'
                        : '<button class="btn btn-info btn-custom rounded-pill CORREO"><i class="bi bi-envelope-arrow-up-fill"></i></button>',
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

}
