<?php

namespace App\Http\Controllers\proveedor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



use App\Models\proveedor\contratoproveedorModel;

use DB;




class listacontratosController extends Controller
{


    public function Tablalistacontratosproveedores()
    {
        try {
            $tabla = DB::table('contratos_proveedores as cp')
                ->leftJoin('formulario_altaproveedor as fa', 'cp.RFC_PROVEEDOR', '=', 'fa.RFC_ALTA')
                ->select(
                    'cp.*',
                    'fa.RAZON_SOCIAL_ALTA',
                    'fa.RFC_ALTA'
                )
                ->orderBy('cp.ID_CONTRATO_PROVEEDORES', 'asc')
                ->get();

            foreach ($tabla as $value) {

                $value->RFC_PROVEEDOR_TEXTO =
                    ($value->RAZON_SOCIAL_ALTA ?? 'SIN NOMBRE') .
                    ' (' . ($value->RFC_ALTA ?? $value->RFC_PROVEEDOR) . ')';

                $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-contrato" data-id="' . $value->ID_CONTRATO_PROVEEDORES . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
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
