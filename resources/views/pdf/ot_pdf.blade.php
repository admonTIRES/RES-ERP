<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Orden de Trabajo</title>

    <style>
        @font-face {
            font-family: 'Poppins';
            src: url("{{ public_path('fonts/poppins/Poppins-Regular.ttf') }}") format('truetype');
        }

        body {
            font-family: 'Poppins', sans-serif;
            font-size: 11px;
        }

        @page {
            margin: 140px 40px 60px 40px;
        }

        header {
            position: fixed;
            top: -121px;
            left: 0;
            right: 0;
            height: 130px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table td {
            border: 1px solid black;
            padding: 5px;
        }

        .bg-gray {
            background-color: #ccc;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .logo {
            max-width: 70px;
            margin-top: 10px;
        }

        .observaciones {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>

    <header>
        <table>
            <tr>
                <td rowspan="3" class="text-center" style="width:33%">
                    <img src="{{ public_path('assets/images/MARCAREGISTRADA.png') }}" class="logo" style="margin-top: 10px;">
                </td>
                <td rowspan="3" class="text-center" style="font-size:16px;">
                    <strong>Orden de trabajo (OT)</strong>
                </td>
                <td class="text-center bold">PM-OC-FO-05</td>
            </tr>
            <tr>
                <td class="text-center">Versión 1</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
        </table>
    </header>

    <table>
        <tr>
            <td colspan="6" class="bg-gray text-center">Datos del cliente a quien se dirige el informe</td>
        </tr>

        <tr>
            <td class="bg-gray">No. de cotización:</td>
            <td colspan="2">{{ $cotizaciones }}</td>
            <td class="bg-gray">No. de OT:</td>
            <td colspan="2">{{ $ot->NO_ORDEN_CONFIRMACION }}</td>
        </tr>

        <tr>
            <td class="bg-gray">Fecha:</td>
            <td colspan="5">{{ $ot->FECHA_EMISION }}</td>
        </tr>

        <tr>
            <td class="bg-gray">Razón Social:</td>
            <td colspan="5">{{ $ot->RAZON_CONFIRMACION }}</td>
        </tr>

        <tr>
            <td class="bg-gray">Nombre comercial:</td>
            <td colspan="5">{{ $ot->COMERCIAL_CONFIRMACION }}</td>
        </tr>

        <tr>
            <td class="bg-gray">RFC:</td>
            <td colspan="2">{{ $ot->RFC_CONFIRMACION }}</td>
            <td class="bg-gray">Giro de la empresa:</td>
            <td colspan="2">{{ $ot->GIRO_CONFIRMACION }}</td>
        </tr>

        <tr>
            <td class="bg-gray">Dirección del servicio:</td>
            <td colspan="5">{{ $ot->DIRECCION_CONFIRMACION }}</td>
        </tr>

        <tr>
            <td class="bg-gray">Persona que solicita:</td>
            <td colspan="5">{{ $ot->PERSONA_SOLICITA_CONFIRMACION }}</td>
        </tr>
    </table>
    <table>
        <tr>
            <td colspan="6" class="bg-gray text-center">
                Datos de contacto
            </td>
        </tr>

        <tr>
            <td class="bg-gray">Contacto:</td>
            <td colspan="2">
                {{ $ot->TITULO_CONFIRMACION ?? '' }}
                {{ $ot->CONTACTO_CONFIRMACION ?? '' }}
            </td>

            <td class="bg-gray">Teléfono:</td>
            <td colspan="2">
                {{ !empty($ot->CONTACTO_TELEFONO_CONFIRMACION) ? $ot->CONTACTO_TELEFONO_CONFIRMACION : 'NP' }}
            </td>
        </tr>

        <tr>
            <td class="bg-gray">Celular:</td>
            <td colspan="2">
                {{ !empty($ot->CONTACTO_CELULAR_CONFIRMACION) ? $ot->CONTACTO_CELULAR_CONFIRMACION : 'NP' }}
            </td>

            <td class="bg-gray">E-mail:</td>
            <td colspan="2">
                {{ !empty($ot->CONTACTO_EMAIL_CONFIRMACION) ? $ot->CONTACTO_EMAIL_CONFIRMACION : 'NP' }}
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <td colspan="6" class="bg-gray text-center bold">Descripción del servicio</td>
        </tr>
        <tr>
            <td class="bg-gray" style="width:25%">Necesidad u objetivo del servicio:</td>
            <td colspan="5">{!! nl2br(e($ot->NECESIDAD_SERVICIO_CONFIRMACION)) !!}</td>
        </tr>
    </table>

    <table>
        <tr>
            <td class="bg-gray text-center bold" style="width:5%">No.</td>
            <td class="bg-gray text-center bold" style="width:10%">Cantidad</td>
            <td class="bg-gray text-center bold" style="width:35%">Servicio</td>
            <td class="bg-gray text-center bold" style="width:50%">Descripción</td>
        </tr>

        @foreach($servicios as $index => $item)
        <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td class="text-center">{{ $item['CANTIDAD'] ?? '' }}</td>
            <td>{!! nl2br(e($item['SERVICIO'] ?? '')) !!}</td>
            <td>{!! nl2br(e($item['DESCRIPCION'] ?? '')) !!}</td>
        </tr>
        @endforeach
    </table>

    <table class="observaciones">
        <tr>
            <td class="bg-gray text-center bold">Observaciones</td>
        </tr>
        <tr>
            <td style="text-align: left;">
                {!! nl2br(e($ot->OBSERVACIONES_CONFIRMACION ?? '')) !!}
            </td>
        </tr>
    </table>

    <table style="width:100%; border-collapse:collapse; margin-top:0px;">
        <tr>
            <td class="bg-gray text-center bold" style="border:1px solid black;">
                Verificado por:
            </td>
        </tr>

        <tr>
            <td style="height:70px; text-align:center; vertical-align:bottom; border:1px solid black;">

                <div style="font-size:14px; font-weight:bold;">
                    {{ $ot->VERIFICADO_POR ?? 'N/D' }}
                </div>

                <div style="font-size:10px; margin-top:4px;">
                    Firmado Digitalmente por {{ $ot->VERIFICADO_POR ?? 'N/D' }} <br>
                    mediante el software <strong>Synaptix</strong>
                </div>

                <div style="font-size:10px; margin-top:4px;">
                    Fecha: {{ $ot->FECHA_VERIFICACION ?? '' }}
                </div>

            </td>
        </tr>
    </table>





    <script type="text/php">
        if (isset($pdf)) {
    $pdf->page_script(function ($pageNumber, $pageCount, $pdf, $fontMetrics) {

        $font = $fontMetrics->getFont("Poppins", "normal");

      
        $x = 455; 
        $y = 80; 

        $pdf->text($x, $y, "Página $pageNumber de $pageCount", $font, 9);
    });
}
</script>


</body>

</html>