<?php

namespace App\Http\Controllers\listaitemcritico;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use App\Models\inventario\inventarioModel;

use Illuminate\Support\Facades\Storage;

//Recursos para abrir el Excel
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

use App\Models\inventario\catalogotipoinventarioModel;

use App\Models\inventario\entradasinventarioModel;


use App\Models\proveedor\altaproveedorModel;
use App\Models\proveedor\proveedortempModel;

class listaitemcriticoController extends Controller
{
    public function index()
    {
        $tipoinventario = catalogotipoinventarioModel::where('ACTIVO', 1)->get();
        $proveedoresOficiales = altaproveedorModel::select('RAZON_SOCIAL_ALTA', 'RFC_ALTA')->get();
        $proveedoresTemporales = proveedortempModel::select('RAZON_PROVEEDORTEMP', 'RFC_PROVEEDORTEMP', 'NOMBRE_PROVEEDORTEMP')->get();


        return view('almacen.listadeitemcriticos.listaitemcriticos', compact('tipoinventario', 'proveedoresOficiales', 'proveedoresTemporales'));
    }

    public function Tablalistaitemcriticos()
    {
        try {

            $tabla = inventarioModel::where('ITEM_CRITICO', 1)->get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_INVENTARIO . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_INVENTARIO . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }

                $value->FOTO_EQUIPO_HTML = '<img src="/equipofoto/' . $value->ID_FORMULARIO_INVENTARIO . '" alt="Foto" class="img-fluid" width="50" height="60">';

                $campos = [
                    'DESCRIPCION_EQUIPO',
                    'MARCA_EQUIPO',
                    'MODELO_EQUIPO',
                    'SERIE_EQUIPO',
                    'CODIGO_EQUIPO',
                    'CANTIDAD_EQUIPO',
                    'UBICACION_EQUIPO',
                    'ESTADO_EQUIPO',
                    'FECHA_ADQUISICION',
                    'PROVEEDOR_EQUIPO',
                    'UNITARIO_EQUIPO',
                    'TOTAL_EQUIPO',
                    'TIPO_EQUIPO',
                    'OBSERVACION_EQUIPO'
                ];


                $completo = true;
                foreach ($campos as $campo) {
                    if (empty($value->$campo)) {
                        $completo = false;
                        break;
                    }
                }

                if (!is_null($value->LIMITEMINIMO_EQUIPO) && $value->LIMITEMINIMO_EQUIPO !== '') {
                    $cantidad = (float)$value->CANTIDAD_EQUIPO;
                    $minimo = (float)$value->LIMITEMINIMO_EQUIPO;

                    if ($cantidad <= $minimo) {
                        $value->ROW_CLASS = 'bg-amarrillo-suave';
                    } else {
                        $value->ROW_CLASS = $completo ? 'bg-verde-suave' : 'bg-rojo-suave';
                    }
                } else {
                    $value->ROW_CLASS = $completo ? 'bg-verde-suave' : 'bg-rojo-suave';
                }

                if ($value->ASIGNADO == 1) {
                    $value->ROW_CLASS = 'bg-naranja-suave';
                }
            }

            // Respuesta
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
