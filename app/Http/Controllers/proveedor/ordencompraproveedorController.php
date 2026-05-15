<?php

namespace App\Http\Controllers\proveedor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

use DB;

use App\Models\ordencompra\poModel;
use App\Models\ordencompra\PoCorreoEnviado;

use App\Models\HojaTrabajo;

use App\Models\proveedor\altaproveedorModel;
use App\Models\proveedor\proveedortempModel;

class ordencompraproveedorController extends Controller
{


    public function Tablapoproveedor()
    {
        try {

            $userRFC = Auth::user()->RFC_PROVEEDOR;

            $tabla = poModel::where('PROVEEDOR_SELECCIONADO', $userRFC)

                ->whereIn('ID_FORMULARIO_PO', function ($query) {
                    $query->select('po_id')
                        ->from('po_correos_enviados');
                })

                ->where(function ($q) {
                    $q->whereNull('CANCELACION_PO')
                        ->orWhere('CANCELACION_PO', '!=', 1);
                })

                ->get();

            foreach ($tabla as $value) {

                $value->DESCARGA_PO = '<button class="btn btn-danger btn-custom rounded-pill pdf-po " data-id="' . $value->ID_FORMULARIO_PO . '" title="Descargar"><i class="bi bi-filetype-pdf"></i></button>';
            }

            return response()->json([
                'data' => $tabla,
                'msj' => 'Información consultada correctamente'
            ]);
        } catch (Exception $e) {

            return response()->json([
                'msj' => 'Error ' . $e->getMessage(),
                'data' => []
            ]);
        }
    }



    public function Tablagrproveedor()
    {
        try {

            $userRFC = Auth::user()->RFC_PROVEEDOR;

            $tabla = DB::table('formulario_bitacoragr')

                ->where('PROVEEDOR_KEY', $userRFC)

                ->whereIn('ID_GR', function ($query) {
                    $query->select('gr_id')
                        ->from('gr_correos_enviados');
                })

                ->whereIn('FINALIZAR_GR', ['Sí', 'Si']) 

                ->get();

            foreach ($tabla as $value) {

                $value->DESCARGA_GR = '<button class="btn btn-danger btn-custom rounded-pill pdf-gr" data-id="' . $value->ID_GR . '" title="Descargar"><i class="bi bi-filetype-pdf"></i></button>';
            }

            return response()->json([
                'data' => $tabla,
                'msj' => 'Información consultada correctamente'
            ]);
        } catch (Exception $e) {

            return response()->json([
                'msj' => 'Error ' . $e->getMessage(),
                'data' => []
            ]);
        }
    }



    }
