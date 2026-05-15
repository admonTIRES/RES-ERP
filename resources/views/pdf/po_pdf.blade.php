<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Orden de Compra</title>


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

        body {
            font-family: 'Poppins', sans-serif;
            font-size: 11px;

        }

        @page {
            margin: 140px 40px 40px 40px;
        }

        header {
            position: fixed;
            top: -115px;
            left: 0;
            right: 0;
            height: 130px;
        }

        table,
        table td,
        table th {
            border: 2px solid black;
        }

        .logo {
            display: block;
            margin-left: auto;
            margin-right: auto;
            max-width: 70px;
        }

        .tabla-encabezado {
            width: 100%;
            border-collapse: collapse;
        }

        .tabla-encabezado td {
            border: 1px solid black;
            /* padding: 1px; */
        }

        .tabla-info {
            width: 100%;
            border-collapse: collapse;
        }

        .tabla-info td,
        .tabla-info th {
            border: 1px solid black;
        }

        .tabla-info_2 {
            width: 100%;
            border-collapse: collapse;
            margin-top: -1px;
        }

        .tabla-info_2 td,
        .tabla-info_2 th {
            border: 1px solid black;

        }

        .bg-gray {
            background-color: #ccc;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        footer {
            position: fixed;
            bottom: -20px;
            left: 0;
            right: 0;
            height: 20px;
            font-size: 9.5px;
            text-align: right;
            padding-right: 20px;
        }

        .tabla-observaciones {
            width: 100%;
            border: 2px solid black;
            border-collapse: collapse;
            font-size: 11.5px;
        }

        .tabla-observaciones th,
        .tabla-observaciones td {
            border: 2px solid black;
            text-align: left;
            vertical-align: top;
        }

        .encabezado-observaciones {
            background-color: #ccc;
            text-align: center;
            font-size: 14px;
        }

        .contenido-observaciones strong {
            font-weight: bold;
        }

        .contenido-observaciones u {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    @php
    $currentPage = 1;
    $totalPages = 1;
    @endphp

    <header>
        <table class="tabla-encabezado">
            <tr>
                <td rowspan="3" style="width: 33%; text-align: center;">
                    <img src="{{ public_path('assets/images/MARCAREGISTRADA.png') }}" class="logo" style="margin-top: 10px;">
                </td>
                <td rowspan="3" class="text-center" style="font-size: 16px;"><strong>Orden de compra</strong></td>
                <td class="text-center bold">PS-CP-FO-07</td>
            </tr>
            <tr>
                <td class="text-center"> Versión 1</td>
            </tr>
            <tr>
                <td class="text-center">Página {{ $currentPage }} de {{ $totalPages }}</td>
            </tr>
            <tr>
                <td colspan="3" class="text-right bold mt-4">
                    No. de orden de compra - PO:
                    <span style="color: blue;">{{ $orden->NO_PO }}</span>
                </td>
            </tr>
        </table>
    </header>
    <main>
        <table class="tabla-info">
            <tr>
                <td colspan="2" class="bg-gray text-center">Emisor de la orden de compra</td>
                <td class="bg-gray text-center">Ciudad / País</td>
                <td class="bg-gray text-center">Fecha de emisión<br>(aaaa/mm/dd)</td>
            </tr>
            <tr>
                <td colspan="2" class="text-center">Results In Performance S.A. de C.V.
                    <hr> RIP1706223K9
                </td>
                <td class="text-center">Villahermosa, México</td>
                <td class="text-center">{{ $orden->FECHA_EMISION }}</td>
            </tr>
            <tr>
                <td class="bg-gray bold">Contacto</td>
                <td colspan="3">{{ $orden->CONTACTO ?? 'Virginia Licona Andrade' }}</td>
            </tr>
            <tr>
                <td class="bg-gray bold">Dirección</td>
                <td colspan="3">Prol. De Avenida Los Ríos, 203. C.P. 86100, Col. Atasta de Serra, Villahermosa, Centro.</td>
            </tr>
            <tr>
                <td class="bg-gray bold">Teléfono</td>
                <td>{{ $orden->TELEFONO ?? '993 147 2682' }}</td>
                <td class="bg-gray bold">Celular</td>
                <td>{{ $orden->CELULAR ?? '938 1804173' }}</td>
            </tr>
            <tr>
                <td class="bg-gray bold">E-mail</td>
                <td colspan="3">
                    <a href="mailto:vlicona@results-in-performance.com">vlicona@results-in-performance.com</a>
                </td>
            </tr>
            <tr>
                <td class="bg-gray bold">No. de MR</td>
                <td colspan="3">{{ $orden->NO_MR ?? '' }}</td>
            </tr>
        </table>
    </main>
    <table class="tabla-info_2">
        <tr>
            <td colspan="4" class="bg-gray text-center bold">Proveedor</td>
        </tr>
        <tr>
            <td colspan="4" class="text-center">
                {{ $proveedor->RAZON_SOCIAL ?? '' }}
                <hr>
                <span>{{ $proveedor->RFC_PROVEEDOR ?? '' }}</span>
            </td>
        </tr>
        <tr>
            <td class="bg-gray bold">Contacto:</td>
            <td colspan="3">{{ $proveedor->NOMBRE_DIRECTORIO ?? '' }}</td>
        </tr>
        <tr>
            <td class="bg-gray bold">Dirección:</td>
            <td colspan="3">
                @if ($proveedor1->TIPO_PERSONA_ALTA == '1')
                {{ $proveedor1->TIPO_VIALIDAD_EMPRESA ?? '' }} {{ $proveedor1->NOMBRE_VIALIDAD_EMPRESA ?? '' }}
                {{ $proveedor1->NUMERO_EXTERIOR_EMPRESA ?? '' }}
                {{ $proveedor1->NUMERO_INTERIOR_EMPRESA ? 'Int. ' . $proveedor1->NUMERO_INTERIOR_EMPRESA : '' }},
                Col. {{ $proveedor1->NOMBRE_COLONIA_EMPRESA ?? '' }}<br>
                C.P. {{ $proveedor1->CODIGO_POSTAL ?? '' }},
                {{ $proveedor1->NOMBRE_LOCALIDAD_EMPRESA ?? '' }},
                {{ $proveedor1->NOMBRE_ENTIDAD_EMPRESA ?? '' }}
                @elseif ($proveedor1->TIPO_PERSONA_ALTA == '2')
                {{ $proveedor1->DOMICILIO_EXTRANJERO ?? '' }},
                {{ $proveedor1->DEPARTAMENTO_EXTRANJERO ?? '' }},
                {{ $proveedor1->CODIGO_EXTRANJERO ?? '' }},
                {{ $proveedor1->ESTADO_EXTRANJERO ?? '' }},
                {{ $proveedor1->CIUDAD_EXTRANJERO ?? '' }},
                {{ $proveedor1->PAIS_EXTRANJERO ?? '' }}
                @endif
            </td>
        </tr>
        <tr>
            <td class="bg-gray bold">Ciudad / País</td>
            <td>
                @if ($proveedor1->TIPO_PERSONA_ALTA == '1')
                {{ $proveedor1->NOMBRE_LOCALIDAD_EMPRESA ?? '' }}, {{ $proveedor1->PAIS_EMPRESA ?? '' }}
                @else
                {{ $proveedor1->CIUDAD_EXTRANJERO ?? '' }}, {{ $proveedor1->PAIS_EXTRANJERO ?? '' }}
                @endif
            </td>
            <td class="bg-gray bold">Fecha de entrega<br>(aaaa/mm/dd)</td>
            <td>{{ $orden->FECHA_ENTREGA ?? '' }}</td>
        </tr>
        <tr>
            <td class="bg-gray bold">Teléfono</td>
            <td>{{ $proveedor1->TELEFONO_DIRECOTORIO && trim($proveedor1->TELEFONO_DIRECOTORIO) !== '' ? $proveedor1->TELEFONO_DIRECOTORIO : 'N/P' }}</td>
            <td class="bg-gray bold">Celular</td>
            <td>{{ $proveedor1->CELULAR_DIRECTORIO && trim($proveedor1->CELULAR_DIRECTORIO) !== '' ? $proveedor1->CELULAR_DIRECTORIO : 'N/P' }}</td>

        </tr>
        <tr>
            <td class="bg-gray bold">E-mail</td>
            <td colspan="3">
                @if (!empty($proveedor->CORREO_DIRECTORIO))
                <a href="mailto:{{ $proveedor->CORREO_DIRECTORIO }}">{{ $proveedor->CORREO_DIRECTORIO }}</a>
                @else
                N/P
                @endif
            </td>

        </tr>
    </table>
    <table class="tabla-info_2">
        <thead>
            <tr class="bg-gray text-center">
                <th style="width: 5%;">No.</th>
                <th style="width: 55%;">Descripción</th>
                <th style="width: 10%;">Cantidad</th>
                <th style="width: 15%;">Precio Unitario</th>
                <th style="width: 15%;">Importe Total</th>
            </tr>
        </thead>
        <tbody>
            @php
            $contador = 1;
            $materiales = json_decode($orden->MATERIALES_JSON ?? '[]', true);
            @endphp

            @foreach ($materiales as $material)
            @php
            $cantidad = is_numeric($material['CANTIDAD_']) ? (float)$material['CANTIDAD_'] : 0;
            $unitario = is_numeric($material['PRECIO_UNITARIO']) ? (float)$material['PRECIO_UNITARIO'] : 0;
            $total = $cantidad * $unitario;

            $precioUnitarioTexto = number_format($unitario, 2, '.', ',');
            $importeTexto = number_format($total, 2, '.', ',');
            @endphp
            <tr>
                <td class="text-center">{{ $contador++ }}</td>
                <td>{{ $material['DESCRIPCION'] ?? '' }}</td>
                <td class="text-center">{{ $cantidad }}</td>
                <td class="text-right">$ {{ $precioUnitarioTexto }}</td>
                <td class="text-right">$ {{ $importeTexto }}</td>
            </tr>
            @endforeach
        </tbody>

        <tfoot>
            <tr>
                <td colspan="3" rowspan="3"></td>
                <td class="text-right bold bg-gray">Subtotal</td>
                <td class="text-right">
                    ${{ number_format($orden->SUBTOTAL ?? 0, 2, '.', ',') }}
                </td>
            </tr>
            <tr>
                <td class="text-right bold bg-gray">IVA</td>
                <td class="text-right">
                    ${{ number_format($orden->IVA ?? 0, 2, '.', ',') }}
                </td>
            </tr>
            <tr>
                <td class="text-right bold bg-gray">Total</td>
                <td class="text-right">
                    ${{ number_format($orden->IMPORTE ?? 0, 2, '.', ',') }}
                </td>
            </tr>
        </tfoot>
    </table>

    <table class="tabla-observaciones">
        <tr>
            <th colspan="2" class="encabezado-observaciones" style="text-align: center; ">Observaciones o indicaciones especiales</th>
        </tr>
        <tr>
            <td colspan="2" class="contenido-observaciones">
                <strong>De acuerdo con la nueva disposición fiscal del SAT para la facturación versión 4.0 considerar lo siguientes:</strong><br>
                <u>Forma de pago</u>: <strong>"99" por definir</strong> posteriormente debe emitirse el Recibo Electrónico de Pago - (REP): <strong>"03" transferencia electrónica de fondos</strong><br>
                <u>Método de pago</u>: <strong>"PPD" pago en parcialidades o diferido</strong><br>
                <strong>Uso de CFDI: G03 gastos en general</strong><br>
                Debe incluir el número de la Orden de compra-PO y el número de Recepción del bien y/o servicio-GR en la factura<br>
                <strong>Recepción de facturas: Martes y Jueves en horario de 9:00 - 13:00 horas</strong>
            </td>
        </tr>
    </table>
    <table style="width: 100%; border-collapse: collapse; margin-top: 1px; border: 2px solid black;">
        <tr>
            <td style="width: 50%; background-color: #ccc; text-align: center; font-weight: bold; border: 2px solid black;">Solicitado por:</td>
            <td style="width: 50%; background-color: #ccc; text-align: center; font-weight: bold; border: 2px solid black;">Aprobado por:</td>
        </tr>
        <tr>
            <td style="height: 50px; text-align: center; vertical-align: bottom; border: 2px solid black;">
                @if($usuarioSolicito)
                <div style="font-size: 14px; font-weight: bold;">
                    {{ $usuarioSolicito->EMPLEADO_NOMBRE }} {{ $usuarioSolicito->EMPLEADO_APELLIDOPATERNO }} {{ $usuarioSolicito->EMPLEADO_APELLIDOMATERNO }}
                </div>
                <div style="font-size: 10px;">Firmado Digitalmente por {{ $usuarioSolicito->EMPLEADO_NOMBRE }} {{ $usuarioSolicito->EMPLEADO_APELLIDOPATERNO }} {{ $usuarioSolicito->EMPLEADO_APELLIDOMATERNO }} <br> mediante el software Synaptix</div>
                <div style="font-size: 10px;">Fecha: {{ $orden->FECHA_SOLCITIUD }}</div>
                @else
                <div>No disponible</div>
                @endif
            </td>
            <td style="height: 50px; text-align: center; vertical-align: bottom; border: 2px solid black;">
                @if($usuarioAprobo)
                <div style="font-size: 14px; font-weight: bold;">
                    {{ $usuarioAprobo->EMPLEADO_NOMBRE }} {{ $usuarioAprobo->EMPLEADO_APELLIDOPATERNO }} {{ $usuarioAprobo->EMPLEADO_APELLIDOMATERNO }}
                </div>
                <div style="font-size: 10px;">Firmado Digitalmente por {{ $usuarioAprobo->EMPLEADO_NOMBRE }} {{ $usuarioAprobo->EMPLEADO_APELLIDOPATERNO }} {{ $usuarioAprobo->EMPLEADO_APELLIDOMATERNO }} <br> mediante el software Synaptix</div>
                <div style="font-size: 10px;">Fecha: {{ $orden->FECHA_APROBACION }}</div>
                @else
                <div>No disponible</div>
                @endif
            </td>
        </tr>
    </table>



</body>

</html>