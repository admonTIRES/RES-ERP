<?php

namespace App\Http\Controllers\listaafn;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use App\Models\inventario\inventarioModel;
use Illuminate\Support\Facades\Storage;


use App\Models\inventario\catalogotipoinventarioModel;
use App\Models\inventario\entradasinventarioModel;
use App\Models\proveedor\altaproveedorModel;
use App\Models\proveedor\proveedortempModel;



use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\DataType;


class listaafnController extends Controller
{
    public function index()
    {
        $tipoinventario = catalogotipoinventarioModel::where('ACTIVO', 1)->get();
        $proveedoresOficiales = altaproveedorModel::select('RAZON_SOCIAL_ALTA', 'RFC_ALTA')->get();
        $proveedoresTemporales = proveedortempModel::select('RAZON_PROVEEDORTEMP', 'RFC_PROVEEDORTEMP', 'NOMBRE_PROVEEDORTEMP')->get();


        return view('almacen.listadeafn.listaafn', compact('tipoinventario', 'proveedoresOficiales', 'proveedoresTemporales'));
    }

    public function Tablalistadeafn()
    {
        try {

            $tabla = inventarioModel::where('TIPO_EQUIPO', 'ANF')->get();

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


                // CAMPOS
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
                    'UNITARIO_EQUIPO',
                    'TOTAL_EQUIPO',
                    'TIPO_EQUIPO',
                    'OBSERVACION_EQUIPO',
                    'FOTO_EQUIPO',
                    'UNIDAD_MEDIDA',
                    'ITEM_CRITICO',
                    'PROVEEDOR_ALTA',
                    'REQUIERE_ARTICULO',
                    'LIMITEMINIMO_EQUIPO',
                    'DETALLAR_ARTICULOS'
                ];

                $completo = true;
                foreach ($campos as $campo) {
                    if (!isset($value->$campo) || $value->$campo === '') {
                        $completo = false;
                        break;
                    }
                }

                $cantidad = (float)$value->CANTIDAD_EQUIPO;
                $minimo = (float)$value->LIMITEMINIMO_EQUIPO;
                $tieneMinimo = (!is_null($value->LIMITEMINIMO_EQUIPO) && $value->LIMITEMINIMO_EQUIPO !== '' && $minimo > 0);


                if ($value->ASIGNADO == 1) {
                    $value->ROW_CLASS = 'bg-naranja-suave';
                } elseif ($tieneMinimo && $cantidad <= $minimo) {
                    $value->ROW_CLASS = 'bg-amarrillo-suave';
                } elseif ($cantidad == 0) {
                    $value->ROW_CLASS = $completo ? 'bg-rojo-suave' : 'bg-azul-suave';
                } else {
                    $value->ROW_CLASS = $completo ? 'bg-verde-suave' : 'bg-azul-suave';
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




    public function descargarListaActivoNoFijo()
    {
        // $inventario = inventarioModel::all();


        $inventario = inventarioModel::where('TIPO_EQUIPO', 'ANF')->get();


        $spreadsheet = new Spreadsheet();
        $hoja = $spreadsheet->getActiveSheet();
        $hoja->setTitle('Activo fijo');

        // Fila 1: título.
        $hoja->mergeCells('A1:H1');
        $hoja->setCellValue('A1', 'Lista de activo no fijo');
        $hoja->getStyle('A1:H1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 16,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1F4E78'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
        $hoja->getRowDimension(1)->setRowHeight(30);

        // Fila 2: encabezados.
        $encabezados = [
            'A2' => '#',
            'B2' => 'Descripción',
            'C2' => 'Cantidad',
            'D2' => 'Marca',
            'E2' => 'Modelo',
            'F2' => 'Serie',
            'G2' => 'Ubicación',
            'H2' => 'Código de identificación',
        ];

        foreach ($encabezados as $celda => $titulo) {
            $hoja->setCellValue($celda, $titulo);
        }

        $hoja->getStyle('A2:H2')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4472C4'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ]);
        $hoja->getRowDimension(2)->setRowHeight(32);

        // Fila 3 en adelante: artículos.
        $fila = 3;
        $numero = 1;

        foreach ($inventario as $articulo) {
            $cantidad = (string) ($articulo->CANTIDAD_EQUIPO ?? '');
            $unidad = trim((string) ($articulo->UNIDAD_MEDIDA ?? ''));

            $cantidadConUnidad = $cantidad;
            if ($unidad !== '') {
                $cantidadConUnidad .= ' (' . $unidad . ')';
            }

            $hoja->setCellValue("A{$fila}", $numero);
            $hoja->setCellValueExplicit("B{$fila}", (string) ($articulo->DESCRIPCION_EQUIPO ?? ''), DataType::TYPE_STRING);
            $hoja->setCellValueExplicit("C{$fila}", $cantidadConUnidad, DataType::TYPE_STRING);
            $hoja->setCellValueExplicit("D{$fila}", (string) ($articulo->MARCA_EQUIPO ?? ''), DataType::TYPE_STRING);
            $hoja->setCellValueExplicit("E{$fila}", (string) ($articulo->MODELO_EQUIPO ?? ''), DataType::TYPE_STRING);
            $hoja->setCellValueExplicit("F{$fila}", (string) ($articulo->SERIE_EQUIPO ?? ''), DataType::TYPE_STRING);
            $hoja->setCellValueExplicit("G{$fila}", (string) ($articulo->UBICACION_EQUIPO ?? ''), DataType::TYPE_STRING);
            $hoja->setCellValueExplicit("H{$fila}", (string) ($articulo->CODIGO_EQUIPO ?? ''), DataType::TYPE_STRING);

            $fila++;
            $numero++;
        }

        $ultimaFila = max(2, $fila - 1);

        $hoja->getStyle("A2:H{$ultimaFila}")->getBorders()->getAllBorders()->setBorderStyle(
            Border::BORDER_THIN
        );

        $hoja->getStyle("A3:A{$ultimaFila}")->getAlignment()->setHorizontal(
            Alignment::HORIZONTAL_CENTER
        );

        $anchos = [
            'A' => 8,
            'B' => 45,
            'C' => 22,
            'D' => 22,
            'E' => 22,
            'F' => 25,
            'G' => 32,
            'H' => 30,
        ];

        foreach ($anchos as $columna => $ancho) {
            $hoja->getColumnDimension($columna)->setWidth($ancho);
        }

        $hoja->freezePane('A3');
        $hoja->setAutoFilter("A2:H{$ultimaFila}");

        $nombreArchivo = 'Lista activo fijo.xlsx';
        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer, $spreadsheet) {
            $writer->save('php://output');
            $spreadsheet->disconnectWorksheets();
        }, $nombreArchivo, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }


}
