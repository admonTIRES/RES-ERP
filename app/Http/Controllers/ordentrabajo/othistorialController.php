<?php

namespace App\Http\Controllers\ordentrabajo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;

use DB;

use App\Models\ofertas\ofertasModel;

use App\Models\ordentrabajo\otModel;
use App\Models\proveedor\catalogotituloproveedorModel;

class othistorialController extends Controller
{
    public function index()
    {
        $ofertasJSON = DB::table('formulario_ordentrabajo')->pluck('OFERTA_ID');
        $ofertasUsadas = [];

        foreach ($ofertasJSON as $json) {
            $ids = json_decode($json, true);
            if (is_array($ids)) {
                $ofertasUsadas = array_merge($ofertasUsadas, $ids);
            }
        }

        $ofertasUsadas = array_unique($ofertasUsadas);

        $ofertasPermitidas = DB::table('formulario_ordentrabajo')
            ->where('UTILIZAR_COTIZACION', 1)
            ->pluck('OFERTA_ID')
            ->toArray();

        $ofertasPermitidasIds = [];
        foreach ($ofertasPermitidas as $json) {
            $ids = json_decode($json, true);
            if (is_array($ids)) {
                $ofertasPermitidasIds = array_merge($ofertasPermitidasIds, $ids);
            }
        }


        $idsParaMostrar = array_diff($ofertasUsadas, $ofertasPermitidasIds);
        $ofertasFinales = array_diff($ofertasUsadas, $idsParaMostrar);

        $solicitudes = DB::table('formulario_confirmacion as fc')
            ->join('formulario_ofertas as fo', 'fc.OFERTA_ID', '=', 'fo.ID_FORMULARIO_OFERTAS')
            ->select('fo.ID_FORMULARIO_OFERTAS', 'fo.NO_OFERTA')
            ->where('fc.PROCEDE_ORDEN', 1)
            ->where(function ($query) use ($ofertasUsadas, $ofertasFinales) {
                $query->whereNotIn('fo.ID_FORMULARIO_OFERTAS', $ofertasUsadas)
                    ->orWhereIn('fo.ID_FORMULARIO_OFERTAS', $ofertasFinales);
            })
            ->get();


        $titulosCuenta = catalogotituloproveedorModel::where('ACTIVO', 1)->get();


        return view('ventas.orden_trabajo.ordentrabajohistorial', compact('solicitudes', 'titulosCuenta'));
    }


    public function Tablaordentrabajohistorial(Request $request)
    {
        try {

            $query = otModel::select('formulario_ordentrabajo.*')
                ->whereRaw('formulario_ordentrabajo.ID_FORMULARIO_ORDEN IN (
                SELECT MAX(ID_FORMULARIO_ORDEN)
                FROM formulario_ordentrabajo
                GROUP BY SUBSTRING_INDEX(NO_ORDEN_CONFIRMACION, "-Rev", 1)
            )');

            if ($request->filled('FECHA_INICIO') && $request->filled('FECHA_FIN')) {
                $query->whereBetween(
                    DB::raw('DATE(formulario_ordentrabajo.FECHA_EMISION)'),
                    [$request->FECHA_INICIO, $request->FECHA_FIN]
                );
            }

            $tabla = $query->get();

            foreach ($tabla as $value) {

                $baseOrden = preg_replace('/-Rev\d+$/', '', $value->NO_ORDEN_CONFIRMACION);

                $revisiones = otModel::select('formulario_ordentrabajo.*')
                    ->where(function ($query) use ($baseOrden) {
                        $query->where('NO_ORDEN_CONFIRMACION', $baseOrden)
                            ->orWhere('NO_ORDEN_CONFIRMACION', 'LIKE', $baseOrden . '-Rev%');
                    })
                    ->where('REVISION_ORDENCOMPRA', '<', $value->REVISION_ORDENCOMPRA)
                    ->orderBy('REVISION_ORDENCOMPRA', 'asc')
                    ->get();

                $ofertaIds = !empty($value->OFERTA_ID) ? json_decode($value->OFERTA_ID, true) : [];
                if (!empty($ofertaIds)) {
                    $ofertas = DB::table('formulario_ofertas')
                        ->whereIn('ID_FORMULARIO_OFERTAS', $ofertaIds)
                        ->pluck('NO_OFERTA')
                        ->toArray();

                    $value->NO_OFERTA = implode(', ', $ofertas);
                    $value->NO_OFERTA_HTML = implode('<br>', $ofertas);
                } else {
                    $value->NO_OFERTA = 'Sin oferta';
                    $value->NO_OFERTA_HTML = 'Sin oferta';
                }

                foreach ($revisiones as $rev) {

                    $ofertaIdsRev = !empty($rev->OFERTA_ID) ? json_decode($rev->OFERTA_ID, true) : [];
                    if (!empty($ofertaIdsRev)) {
                        $ofertasRev = DB::table('formulario_ofertas')
                            ->whereIn('ID_FORMULARIO_OFERTAS', $ofertaIdsRev)
                            ->pluck('NO_OFERTA')
                            ->toArray();

                        $rev->NO_OFERTA = implode(', ', $ofertasRev);
                        $rev->NO_OFERTA_HTML = implode('<br>', $ofertasRev);
                    } else {
                        $rev->NO_OFERTA = 'Sin oferta';
                        $rev->NO_OFERTA_HTML = 'Sin oferta';
                    }

                    $rev->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $rev->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $rev->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $rev->ID_FORMULARIO_ORDEN . '" checked><span class="slider round"></span></label>';
                }

                $value->REVISIONES = $revisiones->isEmpty() ? [] : $revisiones;

                if ($value->ACTIVO == 0) {
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill" disabled><i class="bi bi-ban"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_ORDEN . '"><span class="slider round"></span></label>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_CORREO = '<button type="button" class="btn btn-info btn-custom rounded-pill" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_ORDEN . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_CORREO = '<button type="button" class="btn btn-info btn-custom rounded-pill CORREO"><i class="bi bi-envelope-arrow-up-fill"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-ot" data-id="' . $value->ID_FORMULARIO_ORDEN . '"><i class="bi bi-filetype-pdf"></i></button>';
                }
            }

            return response()->json([
                'data' => $tabla,
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
