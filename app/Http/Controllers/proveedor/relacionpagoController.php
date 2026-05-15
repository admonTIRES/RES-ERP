<?php

namespace App\Http\Controllers\proveedor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
//LIBRERIAS
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

use App\Models\proveedor\relacionpagosModel;


use Barryvdh\DomPDF\Facade\Pdf;

use DB;


class relacionpagoController extends Controller
{




    public function pdfFichaErgonomica()
    {

        $pdf = Pdf::loadView(
            'pdf.ficha_ergonomia'
        );

        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('Ficha_Ergonomica.pdf');
    }



    // public function getFacturasRelacionPagos()
    // {
    //     $facturas = DB::table('formulario_facturasproveedores as f')
    //         ->where('f.ESTATUS_FACTURA', 1)
    //         ->orderBy('f.ID_FORMULARIO_FACTURACION', 'DESC')
    //         ->get();

    //     $datos = [];

    //     foreach ($facturas as $factura) {


    //         $proveedor = DB::table('formulario_altaproveedor')
    //             ->where('RFC_ALTA', $factura->RFC_PROVEEDOR)
    //             ->orderBy('ID_FORMULARIO_ALTA', 'DESC')
    //             ->first();

    //         $tipo = $proveedor ? $proveedor->TIPO_PERSONA_ALTA : null;

    //         if ($tipo == 1) {

    //             $fechaFactura = $factura->FECHA_FACTURA;
    //             $folioFiscal  = $factura->FOLIO_FISCAL;
    //             $subtotal = $factura->SUBTOTAL_FACTURA;
    //             $iva      = $factura->IVA_FACTURA;
    //             $total    = $factura->TOTAL_FACTURA;
    //             $moneda = $factura->MONEDA_FACTURA;
    //         } else {

    //             $fechaFactura = $factura->FECHA_FACTURA_EXTRANJERO;
    //             $folioFiscal  = $factura->NO_FACTURA_EXTRANJERO;
    //             $subtotal = $factura->SUBTOTAL_FACTURA_EXTRANJERO;
    //             $iva      = $factura->IVA_FACTURA_EXTRANJERO;
    //             $total    = $factura->TOTAL_FACTURA_EXTRANJERO;
    //             $moneda = $factura->MONEDA_FACTURA_EXTRANJERO;
    //         }

    //         $banco  = '';
    //         $cuenta = '';

    //         if ($tipo == 1) {

    //             $cuentaProveedor = DB::table('formulario_altacuentaproveedor')
    //                 ->where('RFC_PROVEEDOR', $factura->RFC_PROVEEDOR)
    //                 ->where('ACTIVO', 1)
    //                 ->orderBy('ID_FORMULARIO_CUENTAPROVEEDOR', 'DESC')
    //                 ->first();

    //             if ($cuentaProveedor) {

    //                 $tipoBanco = trim(
    //                     strtolower($cuentaProveedor->TIPO_BANCO)
    //                 );

    //                 if (
    //                     $tipoBanco == 'bbva' ||
    //                     $tipoBanco == 'bancomer bbva' ||
    //                     $tipoBanco == 'bancomer'
    //                 ) {
    //                     $banco = 'BBVA';
    //                 } else {
    //                     $banco = $cuentaProveedor->TIPO_BANCO;
    //                 }

    //                 $bancosNumeroCuenta = [
    //                     'bbva',
    //                     'bancomer bbva',
    //                     'bancomer'
    //                 ];
    //                 if (
    //                     in_array(
    //                         $tipoBanco,
    //                         $bancosNumeroCuenta
    //                     )
    //                 ) {
    //                     $cuenta = $cuentaProveedor->NUMERO_CUENTA;
    //                 } else {
    //                     $cuenta = $cuentaProveedor->CLABE_INTERBANCARIA;
    //                 }
    //             }
    //         }

    //         $datos[] = [
    //             'ID_FORMULARIO_FACTURACION'=> $factura->ID_FORMULARIO_FACTURACION,
    //             'FECHA_FACTURA' => $fechaFactura,
    //             'FOLIO_FISCAL' => $folioFiscal,
    //             'RAZON_SOCIAL_ALTA' => $proveedor ? $proveedor->RAZON_SOCIAL_ALTA: '',
    //             'RFC_PROVEEDOR' => $factura->RFC_PROVEEDOR,
    //             'SUBTOTAL' => $subtotal,
    //             'IVA' => $iva,
    //             'TOTAL' => $total,
    //             'MONEDA' => $moneda,
    //             'FECHA_RECEPCION' => date( 'Y-m-d', strtotime($factura->created_at)),
    //             'DIAS_CREDITO' => $proveedor ? $proveedor->DIAS_CREDITO_ALTA : '',
    //             'BANCO' => $banco,
    //             'NO_CUENTA' => $cuenta,
    //         ];
    //     }

    //     return response()->json($datos);
    // }


    public function getFacturasRelacionPagos()
    {


        $idsUsados = [];

        $relaciones = DB::table('relacionpagosproveedores')->get();

        foreach ($relaciones as $relacion) {

            $json = json_decode($relacion->JSON_RELACIONES, true);

            if (!$json) {
                continue;
            }

            foreach ($json as $item) {

                if (
                    isset($item['ID_FORMULARIO_FACTURACION']) &&
                    $item['ID_FORMULARIO_FACTURACION'] != 0
                ) {

                    $idsUsados[] =
                        $item['ID_FORMULARIO_FACTURACION'];
                }
            }
        }

        $facturas = DB::table('formulario_facturasproveedores as f')
            ->where('f.ESTATUS_FACTURA', 1)
            ->whereNotIn(
                'f.ID_FORMULARIO_FACTURACION',
                $idsUsados
            )
            ->orderBy('f.ID_FORMULARIO_FACTURACION', 'DESC')
            ->get();


        $datos = [];

        foreach ($facturas as $factura) {



            $proveedor = DB::table('formulario_altaproveedor')
                ->where('RFC_ALTA', $factura->RFC_PROVEEDOR)
                ->orderBy('ID_FORMULARIO_ALTA', 'DESC')
                ->first();


            $tipo = $proveedor
                ? $proveedor->TIPO_PERSONA_ALTA
                : null;


         

            if ($tipo == 1) {
                $fechaFactura = $factura->FECHA_FACTURA;
                $folioFiscal  = $factura->FOLIO_FISCAL;
                $subtotal = $factura->SUBTOTAL_FACTURA;
                $iva      = $factura->IVA_FACTURA;
                $total    = $factura->TOTAL_FACTURA;
                $moneda = $factura->MONEDA_FACTURA;
            } else {
                $fechaFactura = $factura->FECHA_FACTURA_EXTRANJERO;
                $folioFiscal = $factura->NO_FACTURA_EXTRANJERO;
                $subtotal = $factura->SUBTOTAL_FACTURA_EXTRANJERO;
                $iva = $factura->IVA_FACTURA_EXTRANJERO;
                $total = $factura->TOTAL_FACTURA_EXTRANJERO;
                $moneda =  $factura->MONEDA_FACTURA_EXTRANJERO;
            }


            $banco  = '';

            $cuenta = '';

            if ($tipo == 1) {

                $cuentaProveedor = DB::table(
                    'formulario_altacuentaproveedor'
                )

                    ->where(
                        'RFC_PROVEEDOR',
                        $factura->RFC_PROVEEDOR
                    )

                    ->where('ACTIVO', 1)

                    ->orderBy(
                        'ID_FORMULARIO_CUENTAPROVEEDOR',
                        'DESC'
                    )

                    ->first();


                if ($cuentaProveedor) {

                    $tipoBanco = trim(
                        strtolower(
                            $cuentaProveedor->TIPO_BANCO
                        )
                    );

                    if (
                        $tipoBanco == 'bbva' ||
                        $tipoBanco == 'bancomer bbva' |
                        $tipoBanco == 'bancomer'

                    ) {
                        $banco = 'BBVA';
                    } else {

                        $banco =
                            $cuentaProveedor->TIPO_BANCO;
                    }

                    $bancosNumeroCuenta = [
                        'bbva',
                        'bancomer bbva',
                        'bancomer'
                    ];
                    if (
                        in_array(
                            $tipoBanco,
                            $bancosNumeroCuenta
                        )
                    ) {
                        $cuenta = $cuentaProveedor->NUMERO_CUENTA;
                    } else {
                        $cuenta = $cuentaProveedor ->CLABE_INTERBANCARIA;
                    }
                }
            }


            $datos[] = [

                'ID_FORMULARIO_FACTURACION'
                => $factura->ID_FORMULARIO_FACTURACION,

                'FECHA_FACTURA'
                => $fechaFactura,

                'FOLIO_FISCAL'
                => $folioFiscal,

                'RAZON_SOCIAL_ALTA'
                => $proveedor
                    ? $proveedor->RAZON_SOCIAL_ALTA
                    : '',

                'RFC_PROVEEDOR'
                => $factura->RFC_PROVEEDOR,

                'SUBTOTAL'
                => $subtotal,

                'IVA'
                => $iva,

                'TOTAL'
                => $total,

                'MONEDA'
                => $moneda,

                'FECHA_RECEPCION'
                => date(
                    'Y-m-d',
                    strtotime($factura->created_at)
                ),

                'DIAS_CREDITO'
                => $proveedor
                    ? $proveedor->DIAS_CREDITO_ALTA
                    : '',

                'BANCO'
                => $banco,

                'NO_CUENTA'
                => $cuenta,
            ];
        }

        return response()->json($datos);
    }

    public function Tablarelacionespago()
    {
        try {
            $tabla = relacionpagosModel::get();

            foreach ($tabla as $value) {

                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_RELACION_PAGOS . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_RELACION_PAGOS . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }

                $value->BTN_EXCEL = '<button class="btn btn-success btn-custom rounded-pill EXCEL" onclick="descargarExcelRelacionPagos(
                ' . $value->ID_RELACION_PAGOS . ')"  title="Descargar Excel"><i class="bi bi-file-earmark-excel-fill"></i></button>';

                
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





    public function descargarExcelRelacionPagos($ID_RELACION_PAGOS)
     {

        $relacion = DB::table('relacionpagosproveedores')
            ->where('ID_RELACION_PAGOS',$ID_RELACION_PAGOS)
            ->first();

        if (!$relacion) {

            abort(404);
        }

        $datos = json_decode( $relacion->JSON_RELACIONES,true);


        if (!$datos) {
            $datos = [];
        }


        usort($datos, function ($a, $b) {

            $aEsBBVA = strtoupper( trim($a['BANCO']) ) == 'BBVA';
            $bEsBBVA = strtoupper( trim($b['BANCO']) ) == 'BBVA';

            if ($aEsBBVA == $bEsBBVA) {
                return 0;
            }
            return $aEsBBVA ? -1 : 1;
        });

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Relación de pagos');
        $sheet->mergeCells('A1:M2');
        $sheet->setCellValue('A1', 'Relación de pagos RES');
        $sheet->getStyle('A1')->applyFromArray([

        'font' => [ 'bold' => true, 'size' => 16,'name' => 'Arial'],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER,'vertical' => Alignment::VERTICAL_CENTER ]

        ]);

        $filaEncabezado = 4;

        $encabezados = [

            'A' => 'No',
            'B' => 'Fecha de factura',
            'C' => 'No. Factura o Folio Fiscal',
            'D' => 'Proveedor',
            'E' => 'RFC',
            'F' => 'Subtotal',
            'G' => 'IVA',
            'H' => 'Total',
            'I' => 'Moneda',
            'J' => 'Fecha de Recepción',
            'K' => 'Días de crédito',
            'L' => 'Banco',
            'M' => 'No. Cuenta Bancaria'

        ];


        foreach ($encabezados as $columna => $texto) {
            $sheet->setCellValue($columna . $filaEncabezado,$texto);
        }



        $sheet->getStyle('A4:M4' )->applyFromArray([

            'font' => ['bold' => true,'color' => ['rgb' => '000000'],'size' => 11,'name' => 'Arial'],
            'fill' => ['fillType' =>Fill::FILL_SOLID,'startColor' => ['rgb' => '92D050']],
            'alignment' => ['horizontal' =>Alignment::HORIZONTAL_CENTER,'vertical' => Alignment::VERTICAL_CENTER,'wrapText' => true ],
            'borders' => [ 'allBorders' => [ 'borderStyle' => Border::BORDER_THIN,'color' => [ 'rgb' => '000000' ]]]

        ]);



        $sheet->getRowDimension(4)->setRowHeight(40);
        $sheet->getColumnDimension('A')->setWidth(8);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(32);
        $sheet->getColumnDimension('D')->setWidth(35);
        $sheet->getColumnDimension('E')->setWidth(22);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(12);
        $sheet->getColumnDimension('J')->setWidth(18);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setWidth(18);
        $sheet->getColumnDimension('M')->setWidth(25);


        $fila = 5;

        $numero = 1;

        foreach ($datos as $dato) {

            $sheet->setCellValue('A' . $fila,$numero);
            $sheet->setCellValue('B' . $fila,$dato['FECHA_FACTURA']);
            $sheet->setCellValue('C' . $fila,$dato['FOLIO_FISCAL']);
            $sheet->setCellValue('D' . $fila,$dato['RAZON_SOCIAL']);
            $sheet->setCellValue('E' . $fila,$dato['RFC']);
            $sheet->setCellValue(  'F' . $fila,$dato['SUBTOTAL']);
            $sheet->setCellValue( 'G' . $fila,$dato['IVA']);
            $sheet->setCellValue( 'H' . $fila,$dato['TOTAL']);
            $sheet->setCellValue('I' . $fila,$dato['MONEDA']);
            $sheet->setCellValue('J' . $fila,$dato['FECHA_RECEPCION']);
            $sheet->setCellValue( 'K' . $fila,$dato['DIAS_CREDITO']);
            $sheet->setCellValue('L' . $fila,$dato['BANCO']);
            $sheet->setCellValue('M' . $fila,$dato['NO_CUENTA']);

            $sheet->getStyle('A' . $fila . ':M' . $fila )->applyFromArray([
                'font' => [ 'name' => 'Arial', 'size' => 10],
                'alignment' => [ 'horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
                'borders' => ['allBorders' => ['borderStyle' =>Border::BORDER_THIN,'color' => ['rgb' => 'BFBFBF']]]
            ]);

            $sheet->getRowDimension($fila) ->setRowHeight(35);
            $sheet->getStyle('F' . $fila . ':H' . $fila) ->getNumberFormat()->setFormatCode('$#,##0.00');
            $fila++;
            $numero++;
        }


        $filaTotales = $fila + 1;

        $sheet->mergeCells('E' . $filaTotales .':F' . $filaTotales);
        $sheet->setCellValue('E' . $filaTotales,'Total MXN');
        $sheet->setCellValue('G' . $filaTotales,$relacion->MONTO_MXN);
        $sheet->mergeCells('E' . ($filaTotales + 1) .':F' . ($filaTotales + 1));
        $sheet->setCellValue('E' . ($filaTotales + 1),'Total USD');
        $sheet->setCellValue('G' . ($filaTotales + 1), $relacion->MONTO_USD);

        $sheet->getStyle( 'E' . $filaTotales .':G' . ($filaTotales + 1) )->applyFromArray([
            'font' => [ 'bold' => true,'size' => 11],
            'fill' => [ 'fillType' => Fill::FILL_SOLID, 'startColor' => [ 'rgb' => 'D9EAD3']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => [ 'borderStyle' => Border::BORDER_THIN, 'color' => [ 'rgb' => '000000']]]
        ]);


        $sheet->getStyle('G' . $filaTotales .':G' . ($filaTotales + 1)) ->getNumberFormat() ->setFormatCode('$#,##0.00');
        $sheet->getStyle(  'A1:M' . ($filaTotales + 1))->getAlignment()->setVertical( Alignment::VERTICAL_CENTER);

        $nombreArchivo ='RelacionPagos_' . date('Ymd_His') .'.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header( 'Content-Disposition: attachment;filename="' .$nombreArchivo .'"');
        header( 'Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }


    public function store(Request $request)
    {
        try {
            switch (intval($request->api)) {
                case 1:
                    if ($request->ID_RELACION_PAGOS == 0) {
                        DB::statement('ALTER TABLE relacionpagosproveedores AUTO_INCREMENT=1;');
                        $relacion = relacionpagosModel::create($request->all());
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $relacion = relacionpagosModel::where('ID_RELACION_PAGOS', $request['ID_RELACION_PAGOS'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['relacion'] = 'Desactivada';
                            } else {
                                $relacion = relacionpagosModel::where('ID_RELACION_PAGOS', $request['ID_RELACION_PAGOS'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['relacion'] = 'Activada';
                            }
                        } else {
                            $relacion = relacionpagosModel::find($request->ID_RELACION_PAGOS);
                            $relacion->update($request->all());
                            $response['code'] = 1;
                            $response['relacion'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['relacion']  = $relacion;
                    return response()->json($response);
                    break;
                default:
                    $response['code']  = 1;
                    $response['msj']  = 'Api no encontrada';
                    return response()->json($response);
            }
        } catch (Exception $e) {
            return response()->json('Error al guardar');
        }
    }
}
