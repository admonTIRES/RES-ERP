<?php

namespace App\Http\Controllers\requisicionmaterial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

use DB;


use App\Models\requisicionmaterial\mrModel;
use App\Models\organizacion\catalogocategoriaModel;

use App\Models\proveedor\altaproveedorModel;
use App\Models\proveedor\proveedortempModel;



// BITACORA

use App\Models\HojaTrabajo;

class bitacora2025Controller extends Controller
{
    public function index()
    {
        $proveedoresOficiales = altaproveedorModel::select('RAZON_SOCIAL_ALTA', 'RFC_ALTA')->get();
        $proveedoresTemporales = proveedortempModel::select('RAZON_PROVEEDORTEMP', 'RFC_PROVEEDORTEMP', 'NOMBRE_PROVEEDORTEMP')->get();

        return view('compras.requisicionesmaterial.bitacorahistorial', compact('proveedoresOficiales', 'proveedoresTemporales'));
    }




    public function Tablabitacoramrhistorial(Request $request)
    {
        try {
           
            $query = mrModel::whereIn('ESTADO_APROBACION', ['Aprobada', 'Rechazada']);

           
            if ($request->filled('FECHA_INICIO') && $request->filled('FECHA_FIN')) {
                $query->whereBetween(
                    DB::raw('DATE(FECHA_SOLICITUD_MR)'),
                    [$request->FECHA_INICIO, $request->FECHA_FIN]
                );
            }

            $tabla = $query->get();                

            foreach ($tabla as $value) {
                $no_mr = $value->NO_MR;

                $bitacoras = DB::table('formulario_bitacoragr')
                    ->where('NO_MR', $no_mr)
                    ->select('NO_RECEPCION', 'FECHA_ENTREGA_GR')
                    ->get();

                if ($bitacoras->count() > 0) {
                    $value->NO_GR = $bitacoras
                        ->map(fn($item) => '• ' . $item->NO_RECEPCION)
                        ->implode('<br>');

                    $value->FECHA_GR = $bitacoras
                        ->map(fn($item) => '• ' . $item->FECHA_ENTREGA_GR)
                        ->implode('<br>');
                } else {
                    $value->NO_GR = '—';
                    $value->FECHA_GR = '—';
                }

                $hojas = DB::table('hoja_trabajo')->where('NO_MR', $no_mr)->get();
                $total = $hojas->count();

                if ($total === 0) {
                    $value->ESTADO_FINAL = 'Sin datos';
                    $value->COLOR = null;
                    $value->DISABLED_SELECT = true;
                } else {

                    $estados = $hojas->pluck('ESTADO_APROBACION');
                    $aprobados = $estados->filter(fn($e) => $e === 'Aprobada')->count();
                    $rechazados = $estados->filter(fn($e) => $e === 'Rechazada')->count();

                    $requiere_po = $hojas->where('REQUIERE_PO', 'Sí')->count();
                    $po_aprobada_o_rechazada = false;

                    foreach ($hojas as $hoja) {
                        $hoja_id = $hoja->id;
                        $po_relacionadas = DB::table('formulario_ordencompra')
                            ->whereJsonContains('HOJA_ID', (string)$hoja_id)
                            ->whereIn('ESTADO_APROBACION', ['Aprobada', 'Rechazada'])
                            ->count();

                        if ($po_relacionadas > 0) {
                            $po_aprobada_o_rechazada = true;
                            break;
                        }
                    }

                    if ($rechazados == $total) {

                        $value->ESTADO_FINAL = 'Finalizada';
                    } else {

                        if ($aprobados > 0 && $rechazados <= $total) {

                            if ($requiere_po > 0 && !$po_aprobada_o_rechazada) {
                                $value->ESTADO_FINAL = 'En proceso';
                            } else {
                                $value->ESTADO_FINAL = 'Finalizada';
                            }
                        } else {
                            $value->ESTADO_FINAL = 'En proceso';
                        }
                    }



                    if ($value->ESTADO_FINAL === 'En proceso') {
                        $value->COLOR = '#fff3cd';
                    } elseif ($rechazados == $total) {
                        $value->COLOR = '#f8d7da';
                    } elseif ($aprobados == $total) {
                        $value->COLOR = '#d4edda';
                    } elseif ($aprobados > 0 && $rechazados > 0) {
                        $value->COLOR = '#d4edda';
                    } else {
                        $value->COLOR = '#fff3cd';
                    }


                    $value->DISABLED_SELECT = false;
                }



                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_MR . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-eye"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_MR . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }

                if ($value->ESTADO_APROBACION === 'Rechazada') {
                    $value->BTN_NO_MR = '
                        <button type="button" class="btn btn-secondary btn-custom rounded-pill" disabled>
                            <i class="bi bi-ban"></i>
                        </button>
                    ';
                } else {

                    $value->BTN_NO_MR = '
                        <button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR">
                            <i class="bi bi-eye"></i>
                        </button>
                    ';
                }


                if ($value->ESTADO_APROBACION === 'Rechazada') {
                    $value->COLOR = '#f8d7da';
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



}
