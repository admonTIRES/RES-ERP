<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Recepción de bienes y/o servicios-GR</title>


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
                <td rowspan="3" class="text-center" style="font-size: 16px;"><strong>Recepción de bienes y/o servicios-GR</strong></td>
                <td class="text-center bold">PS-EM-FO-01</td>
            </tr>
            <tr>
                <td class="text-center"> Versión 1</td>
            </tr>
            <tr>
                <td class="text-center">Página {{ $currentPage }} de {{ $totalPages }}</td>
            </tr>
            <tr>
                <td colspan="3" class="text-right bold mt-4">
                    No. recepción de orden - GR:
                    <span style="color: blue;">{{ $orden->NO_RECEPCION }}</span>
                </td>
            </tr>
        </table>
    </header>
    <main>
        <table class="tabla-info">
            <tr>
                <td colspan="2" class="bg-gray text-center">Emisor de la Orden</td>
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
                <td class="bg-gray bold">No. de PO</td>
                <td colspan="3">{{ $orden->NO_PO ?? '' }}</td>
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
                @if ($proveedor->TIPO_PERSONA == '1')
                {{ $proveedor->TIPO_VIALIDAD_EMPRESA ?? '' }} {{ $proveedor->NOMBRE_VIALIDAD_EMPRESA ?? '' }}
                {{ $proveedor->NUMERO_EXTERIOR_EMPRESA ?? '' }}
                {{ $proveedor->NUMERO_INTERIOR_EMPRESA ? 'Int. ' . $proveedor->NUMERO_INTERIOR_EMPRESA : '' }},
                Col. {{ $proveedor->NOMBRE_COLONIA_EMPRESA ?? '' }}<br>
                C.P. {{ $proveedor->CODIGO_POSTAL ?? '' }},
                {{ $proveedor->NOMBRE_LOCALIDAD_EMPRESA ?? '' }},
                {{ $proveedor->NOMBRE_ENTIDAD_EMPRESA ?? '' }}
                @elseif ($proveedor->TIPO_PERSONA == '2')
                {{ $proveedor->DOMICILIO_EXTRANJERO ?? '' }},
                {{ $proveedor->DEPARTAMENTO_EXTRANJERO ?? '' }},
                {{ $proveedor->CODIGO_EXTRANJERO ?? '' }},
                {{ $proveedor->ESTADO_EXTRANJERO ?? '' }},
                {{ $proveedor->CIUDAD_EXTRANJERO ?? '' }},
                {{ $proveedor->PAIS_EXTRANJERO ?? '' }}
                @endif
            </td>
        </tr>
        <tr>
            <td class="bg-gray bold">Ciudad / País</td>
            <td>
                @if ($proveedor->TIPO_PERSONA == '1')
                @php
                $localidad = trim($proveedor->NOMBRE_LOCALIDAD_EMPRESA ?? '');
                $pais = trim($proveedor->PAIS_EMPRESA ?? '');
                @endphp
                @if ($localidad && $pais)
                {{ $localidad }}, {{ $pais }}
                @elseif ($localidad)
                {{ $localidad }}
                @elseif ($pais)
                {{ $pais }}
                @endif
                @else
                @php
                $ciudad = trim($proveedor->CIUDAD_EXTRANJERO ?? '');
                $paisExt = trim($proveedor->PAIS_EXTRANJERO ?? '');
                @endphp
                @if ($ciudad && $paisExt)
                {{ $ciudad }}, {{ $paisExt }}
                @elseif ($ciudad)
                {{ $ciudad }}
                @elseif ($paisExt)
                {{ $paisExt }}
                @endif
                @endif
            </td>
            <td class="bg-gray bold">Fecha de entrega<br>(aaaa/mm/dd)</td>
            <td>{{ $orden->FECHA_ENTREGA_GR ?? '' }}</td>
        </tr>
        <tr>
            <td class="bg-gray bold">Teléfono</td>
            <td>{{ $proveedor->TELEFONO_DIRECOTORIO && trim($proveedor->TELEFONO_DIRECOTORIO) !== '' ? $proveedor->TELEFONO_DIRECOTORIO : 'N/P' }}</td>
            <td class="bg-gray bold">Celular</td>
            <td>{{ $proveedor->CELULAR_DIRECTORIO && trim($proveedor->CELULAR_DIRECTORIO) !== '' ? $proveedor->CELULAR_DIRECTORIO : 'N/P' }}</td>

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
                <th style="width: 10%;">Verificación</th>
                <th style="width: 10%;">Cantidad solicitada</th>
                <th style="width: 10%;">Cantidad rechazada</th>
                <th style="width: 10%;">Cantidad aceptada</th>
            </tr>
        </thead>
        <tbody>
            @php $contador = 1; @endphp
            @foreach ($detalles as $detalle)
            <tr>
                <td class="text-center">{{ $contador++ }}</td>
                <td>{{ $detalle->DESCRIPCION ?? '' }}</td>

                <td class="text-center" style="font-family: DejaVu Sans; font-size: 18px;">
                    @if (trim($detalle->VOBO_USUARIO_PRODUCTO ?? '') === 'Sí')
                    ✔
                    @elseif (trim($detalle->VOBO_USUARIO_PRODUCTO ?? '') === 'No')
                    ✘
                    @else
                    –
                    @endif
                </td>
                <td class="text-center">{{ $detalle->CANTIDAD ?? 0 }}</td>
                <td class="text-center">{{ $detalle->CANTIDAD_RECHAZADA ?? 0 }}</td>
                <td class="text-center">{{ $detalle->CANTIDAD_ACEPTADA ?? 0 }}</td>
            </tr>
            @endforeach
        </tbody>
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
                Debe incluir el número de esta Orden de compra-PO y el número de Recepción del bien y/o servicio-GR en la factura<br>
                Anexar copia de la orden de compra y recepción en la factura y envíar la factura en archivo PDF y XML <br>
                <strong>Recepción de facturas: Martes y Jueves en horario de 9:00 - 13:00 horas</strong>
            </td>
        </tr>
    </table>
    <table style="width: 100%; border-collapse: collapse; margin-top: 1px; border: 2px solid black;">
        <tr>
            <td style="width: 50%; background-color: #ccc; text-align: center; font-weight: bold; border: 2px solid black;">Almacenista:</td>
            <td style="width: 50%; background-color: #ccc; text-align: center; font-weight: bold; border: 2px solid black;">Usuario de compras:</td>
        </tr>
        <tr>
            <td style="height: 50px; text-align: center; vertical-align: bottom; border: 2px solid black;">
                @if($usuarioRealizo)
                <div style="font-size: 14px; font-weight: bold;">
                    {{ $usuarioRealizo->EMPLEADO_NOMBRE }}
                    {{ $usuarioRealizo->EMPLEADO_APELLIDOPATERNO }}
                    {{ $usuarioRealizo->EMPLEADO_APELLIDOMATERNO }}
                </div>
                <div style="font-size: 10px;">
                    Firmado Digitalmente por {{ $usuarioRealizo->EMPLEADO_NOMBRE }}
                    {{ $usuarioRealizo->EMPLEADO_APELLIDOPATERNO }}
                    {{ $usuarioRealizo->EMPLEADO_APELLIDOMATERNO }} <br>
                    mediante el software Synaptix
                </div>
                <div style="font-size: 10px;">Fecha: {{ $orden->FECHA_EMISION ?? '' }}</div>
                @else
                <div>No disponible</div>
                @endif
            </td>



            <td style="height: 50px; text-align: center; vertical-align: bottom; border: 2px solid black;">
                @if($usuarioSolicito)
                <div style="font-size: 14px; font-weight: bold;">
                    {{ $usuarioSolicito->EMPLEADO_NOMBRE }}
                    {{ $usuarioSolicito->EMPLEADO_APELLIDOPATERNO }}
                    {{ $usuarioSolicito->EMPLEADO_APELLIDOMATERNO }}
                </div>
                <div style="font-size: 10px;">
                    Firmado Digitalmente por {{ $usuarioSolicito->EMPLEADO_NOMBRE }}
                    {{ $usuarioSolicito->EMPLEADO_APELLIDOPATERNO }}
                    {{ $usuarioSolicito->EMPLEADO_APELLIDOMATERNO }} <br>
                    mediante el software Synaptix
                </div>
                <div style="font-size: 10px;">Fecha: {{ $orden->FECHA_VOUSUARIO ?? '' }}</div>
                @else
                <div>No disponible</div>
                @endif
            </td>
        </tr>

    </table>



</body>

</html>