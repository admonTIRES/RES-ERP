<?php

namespace App\Http\Controllers\ordencompra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use DB;


use App\Models\ordencompra\poModel;
use App\Models\HojaTrabajo;
use App\Models\proveedor\altaproveedorModel;
use App\Models\proveedor\proveedortempModel;


class pohistorialController extends Controller
{
    public function index()
    {
        $proveedoresOficiales = altaproveedorModel::select('RAZON_SOCIAL_ALTA', 'RFC_ALTA')->get();
        $proveedoresTemporales = proveedortempModel::select('RAZON_PROVEEDORTEMP', 'RFC_PROVEEDORTEMP', 'NOMBRE_PROVEEDORTEMP')->get();

        return view('compras.ordencompra.ordencomprahistorial', compact('proveedoresOficiales', 'proveedoresTemporales'));
    }


    public function Tablaordencomprahistorial(Request $request)
    {
        try {

            $query = DB::table('formulario_ordencompra as po')
                ->leftJoin('formulario_altaproveedor as p', 'po.PROVEEDOR_SELECCIONADO', '=', 'p.RFC_ALTA')
                ->whereIn('po.ID_FORMULARIO_PO', function ($query) {
                    $query->select(DB::raw('MAX(ID_FORMULARIO_PO)'))
                        ->from('formulario_ordencompra')
                        ->groupBy(DB::raw("SUBSTRING_INDEX(NO_PO, '-Rev', 1)"));
                })
                ->select(
                    'po.*',
                    DB::raw("CONCAT(p.RAZON_SOCIAL_ALTA, ' (', p.RFC_ALTA, ')') as PROVEEDORES")
                );

            if ($request->filled('FECHA_INICIO') && $request->filled('FECHA_FIN')) {
                $query->whereBetween(
                    DB::raw('DATE(po.FECHA_EMISION)'),
                    [$request->FECHA_INICIO, $request->FECHA_FIN]
                );
            }

            $tabla = $query
                ->orderByRaw(
                    "CAST(
                    SUBSTRING_INDEX(
                        SUBSTRING_INDEX(po.NO_PO, '-', -1),
                        '-Rev', 1
                    ) AS UNSIGNED
                )"
                )
                ->get();


            foreach ($tabla as $value) {


                if ($value->CANCELACION_PO == 1) {

                    $value->ESTADO_BADGE = '<span class="badge bg-danger">Cancelada</span>';
                } elseif ($value->ESTADO_APROBACION == 'Aprobada') {

                    $value->ESTADO_BADGE = '<span class="badge bg-success">Aprobado</span>';
                } elseif ($value->ESTADO_APROBACION == 'Rechazada') {

                    $value->ESTADO_BADGE = '<span class="badge bg-danger">Rechazado</span>';
                } elseif ($value->SOLICITAR_AUTORIZACION == 'Sí') {

                    $value->ESTADO_BADGE = '<span class="badge bg-warning text-dark">En revisión</span>';
                } else {

                    $value->ESTADO_BADGE = '<span class="badge bg-secondary">Sin estatus</span>';
                }


                // if ($value->CANCELACION_PO == 1) {
                //     $value->BTN_EDITAR = '<button class="btn btn-secondary rounded-pill" disabled><i class="bi bi-ban"></i></button>';
                // } else {
                //     $value->BTN_EDITAR = '<button class="btn btn-warning rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                // }
                
                
                $value->BTN_EDITAR = '<button class="btn btn-secondary rounded-pill" disabled><i class="bi bi-ban"></i></button>';
                $value->BTN_VISUALIZAR = '<button class="btn btn-primary rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                $value->DESCARGA_PO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button " data-id="' . $value->ID_FORMULARIO_PO . '" title="Descargar"><i class="bi bi-filetype-pdf"></i></button>';


                $basePO = preg_replace('/-Rev\d+$/', '', $value->NO_PO);

                $revisiones = poModel::where(function ($q) use ($basePO) {
                    $q->where('NO_PO', $basePO)
                        ->orWhere('NO_PO', 'like', "$basePO-Rev%");
                })
                    ->where('ID_FORMULARIO_PO', '<', $value->ID_FORMULARIO_PO)
                    ->orderBy('ID_FORMULARIO_PO')
                    ->get();

                foreach ($revisiones as $rev) {
                    $rev->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR" data-id="' . $rev->ID_FORMULARIO_PO . '"><i class="bi bi-pencil-square"></i></button>';
                }

                $value->REVISIONES = $revisiones;
            }

            return response()->json([
                'data' => $tabla,
                'msj' => 'Últimas órdenes cargadas'
            ]);
        } catch (\Exception $e) {
            return response()->json(['data' => [], 'msj' => 'Error: ' . $e->getMessage()]);
        }
    }
}
