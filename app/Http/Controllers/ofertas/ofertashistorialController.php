<?php

namespace App\Http\Controllers\ofertas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

use DB;


use App\Models\solicitudes\solicitudesModel;

use App\Models\ofertas\ofertasModel;

class ofertashistorialController extends Controller
{
    public function index()
    {
        $solicitudesAceptadas = solicitudesModel::select(
            'ID_FORMULARIO_SOLICITUDES',
            'NO_SOLICITUD',
            'NOMBRE_COMERCIAL_SOLICITUD',
            'FECHA_SOLICITUD'
        )
            ->where('ESTATUS_SOLICITUD', 'like', '%Aceptada%')
            ->get();

        $idsAsociados = ofertasModel::pluck('SOLICITUD_ID')->toArray();

        $solicitudes = $solicitudesAceptadas->filter(function ($solicitud) use ($idsAsociados) {
            return !in_array($solicitud->ID_FORMULARIO_SOLICITUDES, $idsAsociados);
        });

        return view('ventas.ofertas.ofertashistorial', compact('solicitudes'));
    }



    public function Tablaofertashistorial(Request $request)
    {
        try {

            $query = ofertasModel::select(
                'formulario_ofertas.*',
                'formulario_solicitudes.NO_SOLICITUD',
                'formulario_solicitudes.NOMBRE_COMERCIAL_SOLICITUD',
                'formulario_ofertas.SOLICITUD_ID'
            )
                ->leftJoin(
                    'formulario_solicitudes',
                    'formulario_ofertas.SOLICITUD_ID',
                    '=',
                    'formulario_solicitudes.ID_FORMULARIO_SOLICITUDES'
                )
                ->whereRaw('formulario_ofertas.ID_FORMULARIO_OFERTAS IN (
                SELECT MAX(ID_FORMULARIO_OFERTAS)
                FROM formulario_ofertas
                GROUP BY SUBSTRING_INDEX(NO_OFERTA, "-Rev", 1)
            )');

            if ($request->filled('FECHA_INICIO') && $request->filled('FECHA_FIN')) {
                $query->whereBetween(
                    DB::raw('DATE(formulario_ofertas.FECHA_OFERTA)'),
                    [$request->FECHA_INICIO, $request->FECHA_FIN]
                );
            }

            $tabla = $query->get();

            $solicitudesAceptadas = solicitudesModel::select(
                'ID_FORMULARIO_SOLICITUDES',
                'NO_SOLICITUD',
                'NOMBRE_COMERCIAL_SOLICITUD'
            )
                ->where('ESTATUS_SOLICITUD', 'like', '%Aceptada%')
                ->get();

            $idsAsociados = ofertasModel::pluck('SOLICITUD_ID')->toArray();

            foreach ($tabla as $value) {
                $solicitudesDisponibles = $solicitudesAceptadas->filter(function ($solicitud) use ($idsAsociados, $value) {
                    return !in_array($solicitud->ID_FORMULARIO_SOLICITUDES, $idsAsociados) ||
                        $solicitud->ID_FORMULARIO_SOLICITUDES == $value->SOLICITUD_ID;
                });

                $value->SOLICITUDES = $solicitudesDisponibles->values();

                $baseOferta = preg_replace('/-Rev\d+$/', '', $value->NO_OFERTA);

                $revisiones = ofertasModel::select(
                    'formulario_ofertas.*',
                    'formulario_solicitudes.NO_SOLICITUD',
                    'formulario_solicitudes.NOMBRE_COMERCIAL_SOLICITUD'
                )
                    ->leftJoin(
                        'formulario_solicitudes',
                        'formulario_ofertas.SOLICITUD_ID',
                        '=',
                        'formulario_solicitudes.ID_FORMULARIO_SOLICITUDES'
                    )
                    ->where(function ($query) use ($baseOferta) {
                        $query->where('NO_OFERTA', $baseOferta)
                            ->orWhere('NO_OFERTA', 'LIKE', $baseOferta . '-Rev%');
                    })
                    ->where('REVISION_OFERTA', '<', $value->REVISION_OFERTA)
                    ->orderBy('REVISION_OFERTA', 'asc')
                    ->get();

                foreach ($revisiones as $rev) {
                    $rev->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-cotizacion" data-id="' . $rev->ID_FORMULARIO_OFERTAS . '" title="Ver documento"><i class="bi bi-filetype-pdf"></i></button>';

                    $value->BTN_TERMINOS = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-terminos" data-id="' . $value->ID_FORMULARIO_OFERTAS . '" title="Ver documento"><i class="bi bi-filetype-pdf"></i></button>';

                    $rev->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR" data-id="' . $rev->ID_FORMULARIO_OFERTAS . '"><i class="bi bi-pencil-square"></i></button>';

                    $rev->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';

                    $rev->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $rev->ID_FORMULARIO_OFERTAS . '" checked><span class="slider round"></span></label>';
                }

                $value->REVISIONES = $revisiones->isEmpty() ? [] : $revisiones;

                if ($value->ACTIVO == 0) {
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_OFERTAS . '"><span class="slider round"></span></label>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-cotizacion" data-id="' . $value->ID_FORMULARIO_OFERTAS . '" title="Ver documento"><i class="bi bi-filetype-pdf"></i></button>';
                    $value->BTN_TERMINOS = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-terminos" data-id="' . $value->ID_FORMULARIO_OFERTAS . '" title="Ver documento"><i class="bi bi-filetype-pdf"></i></button>';
                } else {
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled data-id="' . $value->ID_FORMULARIO_OFERTAS . '"><i class="bi bi-ban"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_OFERTAS . '" checked><span class="slider round"></span></label>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_CORREO = '<button type="button" class="btn btn-info btn-custom rounded-pill CORREO"><i class="bi bi-envelope-arrow-up-fill"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-cotizacion" data-id="' . $value->ID_FORMULARIO_OFERTAS . '" title="Ver documento"><i class="bi bi-filetype-pdf"></i></button>';
                    $value->BTN_TERMINOS = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-terminos" data-id="' . $value->ID_FORMULARIO_OFERTAS . '" title="Ver documento"><i class="bi bi-filetype-pdf"></i></button>';
                }
            }

            return response()->json([
                'data' => $tabla,
                'msj' => 'Última revisión consultada correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'msj' => 'Error ' . $e->getMessage(),
                'data' => []
            ]);
        }
    }

}
