```html
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>
        Relación de pago - {{ $relacion->FECHA_RELACION ?? '' }}
    </title>

    <style>
        @font-face {
            font-family: 'Poppins';
            font-weight: 400;
            src: url("{{ public_path('fonts/poppins/Poppins-Regular.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'Poppins';
            font-weight: 500;
            src: url("{{ public_path('fonts/poppins/Poppins-Medium.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'Poppins';
            font-weight: 600;
            src: url("{{ public_path('fonts/poppins/Poppins-SemiBold.ttf') }}") format('truetype');
        }


        @page {
            margin: 25px 25px 30px 25px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            font-size: 8px;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .encabezado {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        .encabezado td {
            border: none !important;
            vertical-align: middle;
            padding: 0;
        }

        .logo {
            width: 145px;
            height: auto;
        }

        .titulo {
            text-align: center;
            font-size: 15px;
            font-weight: 600;
        }


        .fecha-pago {
            width: 100%;
            text-align: right;
            font-size: 9px;
            margin-bottom: 10px;
        }

        .fecha-pago strong {
            font-weight: 600;
        }

        .tabla {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .tabla th {
            background-color: #92D050;
            border: 1px solid #000;
            padding: 5px 3px;
            text-align: center;
            font-size: 7px;
            font-weight: 600;
            vertical-align: middle;
            line-height: 1.25;
        }

        .tabla td {
            border: 1px solid #BFBFBF;
            padding: 5px 3px;
            text-align: center;
            vertical-align: middle;
            word-wrap: break-word;
            overflow-wrap: break-word;
            font-size: 7px;
            font-weight: 400;
            line-height: 1.25;
        }

        .col-no {
            width: 3%;
        }

        .col-fecha {
            width: 7%;
        }

        .col-folio {
            width: 12%;
        }

        .col-proveedor {
            width: 13%;
        }

        .col-rfc {
            width: 8%;
        }

        .col-subtotal {
            width: 7%;
        }

        .col-iva {
            width: 6%;
        }

        .col-total {
            width: 7%;
        }

        .col-moneda {
            width: 5%;
        }

        .col-recepcion {
            width: 8%;
        }

        .col-dias {
            width: 5%;
        }

        .col-banco {
            width: 7%;
        }

        .col-cuenta {
            width: 10%;
        }

        .col-observaciones {
            width: 10%;
        }

        .contenedor-totales {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .contenedor-totales td {
            border: none !important;
            padding: 0;
            text-align: center;
        }

        .tabla-totales {
            width: 230px;
            margin: 0 auto;
            border-collapse: collapse;
        }

        .tabla-totales td {
            border: 1px solid #000 !important;
            padding: 6px 10px;
            font-size: 9px;
            font-weight: 600;
            text-align: center;
            vertical-align: middle;
        }

        .tabla-totales .total-label {
            width: 40%;
            background-color: #D9EAD3;
        }

        .tabla-totales .total-valor {
            width: 40%;
            background-color: #D9EAD3;
        }

        .firmas {
            width: 70%;
            margin: 65px auto 0 auto;
            border-collapse: collapse;
        }

        .firmas td {
            width: 50%;
            text-align: center;
            border: none !important;
            vertical-align: top;
            padding: 0 25px;
        }

        .titulo-firma {
            font-size: 8px;
            font-weight: 600;
            text-align: center;
            margin-bottom: 8px;
        }

        .texto-firma {
            font-size: 7px;
            font-weight: 400;
            line-height: 1.5;
            text-align: center;
        }

        .pie {
            position: fixed;
            bottom: -18px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 7px;
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>


<body>

    <table class="encabezado">
        <tr>
            <td style="width: 25%;">

                @php

                $logoPath = public_path('assets/images/Color@4x.png');

                $logoBase64 = '';

                if (file_exists($logoPath)) {

                $logoBase64 = 'data:image/png;base64,' .base64_encode(file_get_contents($logoPath));

                }
                @endphp
                @if($logoBase64)
                <img src="{{ $logoBase64 }}" class="logo">
                @endif
            </td>
            <td class="titulo" style="width: 50%;">
                RELACIÓN DE PAGOS RES
            </td>
            <td style="width: 25%;">
            </td>
        </tr>
    </table>

    <div class="fecha-pago">
        <strong>Fecha de pago:</strong>
        {{ $relacion->FECHA_RELACION ?? '' }}
    </div>

    <table class="tabla">
        <thead>
            <tr>
                <th class="col-no">
                    No
                </th>
                <th class="col-fecha">
                    Fecha de factura
                </th>
                <th class="col-folio">
                    No. Factura o Folio Fiscal
                </th>
                <th class="col-proveedor">
                    Proveedor
                </th>
                <th class="col-rfc">
                    RFC
                </th>
                <th class="col-subtotal">
                    Subtotal
                </th>
                <th class="col-iva">
                    IVA
                </th>
                <th class="col-total">
                    Total
                </th>
                <th class="col-moneda">
                    Moneda
                </th>
                <th class="col-recepcion">
                    Fecha de Recepción
                </th>
                <th class="col-dias">
                    Días de crédito
                </th>
                <th class="col-banco">
                    Banco
                </th>
                <th class="col-cuenta">
                    No. Cuenta Bancaria
                </th>
                <th class="col-observaciones">
                    Observaciones
                </th>
            </tr>
        </thead>

        <tbody>

            @php

            $numero = 1;

            @endphp

            @forelse($datos as $dato)

            @php

            $observaciones = $dato['OBSERVACIONES'] ?? '';

            if ($observaciones === null || strtolower(trim((string) $observaciones)) === 'null')
            {

            $observaciones = '';

            }

            $subtotal = $dato['SUBTOTAL'] ?? '';

            $iva = $dato['IVA'] ?? '';

            $total = $dato['TOTAL'] ?? '';


            if ($subtotal !== '' && $subtotal !== null) {

            $subtotalTexto = (string) $subtotal;

            $subtotalPartes = explode('.', $subtotalTexto, 2);

            $subtotalEntero = $subtotalPartes[0];

            $subtotalDecimal = $subtotalPartes[1] ?? null;

            $subtotalEntero = number_format((int) $subtotalEntero,0,'',',');

            $subtotalFormateado = $subtotalDecimal !== null ? $subtotalEntero . '.' . $subtotalDecimal : $subtotalEntero;

            } else {

            $subtotalFormateado = '';

            }


            if ($iva !== '' && $iva !== null) {

            $ivaTexto = (string) $iva;

            $ivaPartes = explode('.', $ivaTexto, 2);

            $ivaEntero = $ivaPartes[0];

            $ivaDecimal = $ivaPartes[1] ?? null;

            $ivaEntero = number_format((int) $ivaEntero,0,'',',');

            $ivaFormateado = $ivaDecimal !== null ? $ivaEntero . '.' . $ivaDecimal : $ivaEntero;

            } else {

            $ivaFormateado = '';

            }


            if ($total !== '' && $total !== null) {

            $totalTexto = (string) $total;

            $totalPartes = explode('.', $totalTexto, 2);

            $totalEntero = $totalPartes[0];

            $totalDecimal = $totalPartes[1] ?? null;

            $totalEntero = number_format((int) $totalEntero,0,'',',');

            $totalFormateado = $totalDecimal !== null ? $totalEntero . '.' . $totalDecimal : $totalEntero;

            } else {

            $totalFormateado = '';

            }
            @endphp

            <tr>
                <td>
                    {{ $numero }}
                </td>
                <td>
                    {{ $dato['FECHA_FACTURA'] ?? '' }}
                </td>
                <td>
                    {{ $dato['FOLIO_FISCAL'] ?? '' }}
                </td>
                <td>
                    {{ $dato['RAZON_SOCIAL'] ?? '' }}
                </td>
                <td>
                    {{ $dato['RFC'] ?? '' }}
                </td>
                <td>
                    ${{ $subtotalFormateado }}
                </td>
                <td>
                    ${{ $ivaFormateado }}
                </td>
                <td>
                    ${{ $totalFormateado }}
                </td>
                <td>
                    {{ $dato['MONEDA'] ?? '' }}
                </td>
                <td>
                    {{ $dato['FECHA_RECEPCION'] ?? '' }}
                </td>
                <td>
                    {{ $dato['DIAS_CREDITO'] ?? '' }}
                </td>
                <td>
                    {{ $dato['BANCO'] ?? '' }}
                </td>
                <td>
                    {{ $dato['NO_CUENTA'] ?? '' }}
                </td>
                <td>
                    {{ $observaciones }}
                </td>
            </tr>

            @php

            $numero++;

            @endphp

            @empty

            <tr>
                <td colspan="14">
                    No existen registros en esta relación de pagos.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <table class="contenedor-totales">
        <tr>
            <td>
                <table class="tabla-totales">

                    @php

                    $montoMXN = $relacion->MONTO_MXN ?? '';

                    $montoUSD = $relacion->MONTO_USD ?? '';

                    if ($montoMXN !== '' && $montoMXN !== null) {

                    $montoMXNTexto = (string) $montoMXN;

                    $partesMXN = explode('.', $montoMXNTexto, 2);

                    $enteroMXN = number_format((int) $partesMXN[0],0,'',',');

                    $decimalesMXN = $partesMXN[1] ?? '';

                    if ($decimalesMXN === '') {

                    $decimalesMXN = '00';

                    } elseif (strlen($decimalesMXN) === 1) {

                    $decimalesMXN .= '0';

                    }

                    $montoMXNFormateado = $enteroMXN . '.' . $decimalesMXN;

                    } else {

                    $montoMXNFormateado = '';

                    }


                    if ($montoUSD !== '' && $montoUSD !== null) {

                    $montoUSDTexto = (string) $montoUSD;

                    $partesUSD = explode('.', $montoUSDTexto, 2);

                    $enteroUSD = number_format((int) $partesUSD[0],0,'',',');

                    $decimalesUSD = $partesUSD[1] ?? '';

                    if ($decimalesUSD === '') {

                    $decimalesUSD = '00';

                    } elseif (strlen($decimalesUSD) === 1) {

                    $decimalesUSD .= '0';

                    }

                    $montoUSDFormateado = $enteroUSD . '.' . $decimalesUSD;

                    } else {

                    $montoUSDFormateado = '';

                    }

                    @endphp

                    <tr>
                        <td class="total-label">
                            Total MXN
                        </td>
                        <td class="total-valor">
                            ${{ $montoMXNFormateado }}
                        </td>
                    </tr>
                    <tr>
                        <td class="total-label">
                            Total USD
                        </td>
                        <td class="total-valor">
                            ${{ $montoUSDFormateado }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="firmas">
        <tr>
            <td>
                <div class="titulo-firma">
                    ELABORADOR POR
                </div>
                <div class="texto-firma">
                    {{ $relacion->FIRMADO_POR ?? 'N/A' }}
                </div>
            </td>
            <td>
                <div class="titulo-firma">
                    APROBADO POR
                </div>
                <div class="texto-firma">
                    {{ $relacion->APROBADO_POR ?? 'N/A' }}
                </div>
            </td>
        </tr>
    </table>

    <div class="pie">
        Relación de pagos RES
    </div>

</body>

</html>