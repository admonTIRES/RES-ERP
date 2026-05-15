<?php

namespace App\Http\Controllers\proveedor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Storage;
use App\Models\usuario\usuarioModel;

use Carbon\Carbon;

use DB;

use App\Models\proveedor\directorioModel;
use App\Models\proveedor\verificacionproveedor;


class listaproveedorescriticosController extends Controller
{
    public function Tablaproveedorescriticos()
    {
        try {
            $tabla = directorioModel::get();

            $tabla = directorioModel::where('PROVEEDOR_CRITICO', 1)->get();



            $rfcAlta = DB::table('formulario_altaproveedor')
                ->select(DB::raw('UPPER(TRIM(RFC_ALTA)) AS RFC_ALTA'))
                ->pluck('RFC_ALTA')
                ->toArray();

            foreach ($tabla as $value) {
                $tieneAlta = in_array(strtoupper(trim($value->RFC_PROVEEDOR)), $rfcAlta);

                $value->ROW_CLASS = $tieneAlta ? 'fila-verde' : '';

                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_DIRECTORIO . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-constancia" data-id="' . $value->ID_FORMULARIO_DIRECTORIO . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_DIRECTORIO . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-constancia" data-id="' . $value->ID_FORMULARIO_DIRECTORIO . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                }

                if ($value->PROVEEDOR_VERIFICADO == 1) {
                    $value->BTN_CORREO = '<button type="button" class="btn btn-info btn-custom rounded-pill CORREO" data-id="' . $value->ID_FORMULARIO_DIRECTORIO . '"><i class="bi bi-envelope-arrow-up-fill"></i></button>';
                } else {
                    $value->BTN_CORREO = '<button type="button" class="btn btn-secondary btn-custom rounded-pill CORREO" disabled><i class="bi bi-ban"></i></button>';
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
