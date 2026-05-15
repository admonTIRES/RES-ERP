<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>PS-RH-FO-23 Solicitud de Vacaciones</title>
    <style>
        @font-face {
            font-family: 'Poppins';
            font-weight: 400;
            src: url("{{ public_path('fonts/poppins/Poppins-Regular.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'Poppins';
            font-weight: 600;
            src: url("{{ public_path('fonts/poppins/Poppins-SemiBold.ttf') }}") format('truetype');
        }

        body {
            font-family: 'Poppins', sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 0;
        }

        @page {
            size: letter landscape;
            margin: 145px 40px 40px 40px;
        }

        header {
            position: fixed;
            top: -101px;
            left: 0;
            right: 0;
            height: 120px;
        }

        main {
            margin-top: -10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
        }

        .header-tabla {
            width: 100%;
            border: 1.5px solid black;
            border-collapse: collapse;
        }

        .header-tabla td {
            border: 1px solid black;
            text-align: center;
            vertical-align: middle;
            padding: 4px;
        }

        .logo {
            display: block;
            margin: 10px auto;
            width: 130px;
        }

        .titulo-col {
            text-align: center;
            font-size: 17px;
            font-weight: 600;
        }

        .info-col {
            width: 13%;
            font-size: 9.5px;
            text-align: center;
        }

        .datos-empleado td {
            height: 24px;
            padding: 0;
            margin: 0;
        }

        .celda-flex {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            height: 24px;
            padding: 0 6px;
            line-height: 1;
        }

        .celda-label,
        .bg-gray {
            background-color: #ccc !important;
            font-weight: 600;
            font-size: 10.5px;
            letter-spacing: 0.1px;
        }

        .celda-dato {
            font-weight: 400;
            font-size: 10.5px;
            color: #000;
            letter-spacing: 0.1px;
        }

        .periodo-label {
            background-color: #ccc !important;
            font-weight: 600;
            font-size: 10.3px;
        }

        .periodo-dato {
            font-weight: 400;
            font-size: 10.5px;
            color: #000;
        }

        .tabla-borde {
            border-left: 1.5px solid black;
            border-right: 1.5px solid black;
        }

        .tabla-inferior {
            border-bottom: 1.5px solid black;
        }

        .text-center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .tabla-observaciones {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid;
            margin-top: 0px;
        }

        .tabla-observaciones td {
            border: 1px solid;
            font-family: 'Poppins', sans-serif;
            font-size: 10.5px;
        }

        .tabla-observaciones .titulo-observaciones {
            background-color: #ccc;
            font-weight: 600;
            text-align: center;
            height: 20px;
            line-height: 1.1;
            vertical-align: middle;
        }

        .tabla-observaciones .contenido-observaciones {
            height: 45px;
            vertical-align: top;
            padding: 3px 6px;
        }


        .espacio {
            height: 10px;
        }

        .tabla-firmas {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .tabla-firmas td {
            border: 1px solid #000;
            text-align: center;
            padding: 8px 5px;
        }

        .tabla-firmas .bg-gray {
            background-color: #ccc;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <header>
        <table class="header-tabla">
            <tr>
                <td rowspan="3" style="width:13%;">
                    <img src="{{ public_path('assets/images/Color@4x.png') }}" class="logo">
                </td>
                <td rowspan="3" class="titulo-col"><strong>Solicitud de Vacaciones</strong></td>
                <td class="info-col bold">PS-RH-FO-23</td>
            </tr>
            <tr>
                <td class="info-col">Versión: 1</td>
            </tr>
            <tr>
                <td class="info-col">Página 1 de 1</td>
            </tr>
        </table>
    </header>

    <main>

        <table class="datos-empleado">
            <tr>
                <td class="celda-label">
                    <div class="celda-flex">Nombre del Empleado:</div>
                </td>
                <td colspan="4" class="celda-dato">
                    <div class="celda-flex">{{ $empleado->SOLICITANTE_SALIDA ?? '' }}</div>
                </td>
                <td class="celda-label">
                    <div class="celda-flex">No de Empleado:</div>
                </td>
                <td colspan="2" class="celda-dato">
                    <div class="celda-flex">{{ $empleado->NOEMPLEADO_PERMISO_VACACIONES ?? '' }}</div>
                </td>
            </tr>

            <tr>
                <td class="celda-label">
                    <div class="celda-flex">Área o Departamento:</div>
                </td>
                <td colspan="2" class="celda-dato">
                    <div class="celda-flex">{{ $empleado->AREA_VACACIONES ?? '' }}</div>
                </td>
                <td class="celda-label">
                    <div class="celda-flex">Fecha de Ingreso:</div>
                </td>
                <td class="celda-dato">
                    <div class="celda-flex">{{ $fecha_ingreso }}</div>
                </td>
                <td class="celda-label">
                    <div class="celda-flex">Años de Servicio:</div>
                </td>
                <td colspan="2" class="celda-dato">
                    <div class="celda-flex">{{ $empleado->ANIO_SERVICIO_VACACIONES ?? '01' }} años</div>
                </td>
            </tr>

            <tr>
                <td class="celda-label">
                    <div class="celda-flex">Días que Corresponden:</div>
                </td>
                <td class="celda-dato">
                    <div class="celda-flex">{{ $empleado->DIAS_CORRESPONDEN_VACACIONES ?? '' }}</div>
                </td>
                <td class="celda-label">
                    <div class="celda-flex">Días a Disfrutar:</div>
                </td>
                <td class="celda-dato">
                    <div class="celda-flex">{{ $empleado->DIAS_DISFRUTAR_VACACIONES ?? '' }}</div>
                </td>
                <td class="celda-label">
                    <div class="celda-flex">Días Pendientes:</div>
                </td>
                <td class="celda-dato" colspan="3">
                    <div class="celda-flex">{{ $empleado->DIAS_PENDIENTES_VACACIONES ?? '' }}</div>
                </td>
            </tr>

            <tr>
                <td class="periodo-label">
                    <div class="celda-flex">Período a Disfrutar:</div>
                </td>
                <td colspan="3" class="periodo-dato">
                    <div class="celda-flex">Desde {{ $empleado->DESDE_ANIO_VACACIONES ?? '' }}</div>
                </td>
                <td colspan="4" class="periodo-dato">
                    <div class="celda-flex">Hasta {{ $empleado->HASTA_ANIO_VACACIONES ?? '' }}</div>
                </td>
            </tr>
        </table>

        <div class="espacio"></div>



        <style>
            .tabla-vacaciones {
                width: 100%;
                border-collapse: collapse;
                border: 1px solid #000;
                table-layout: fixed;
            }

            .tabla-vacaciones td {
                border: 1px solid #000;
                text-align: center;
                vertical-align: middle;
                font-family: 'Poppins', sans-serif;
                font-size: 10.5px;
                height: 22px;
                padding: 2px 4px;
            }

            .vac-titulo {
                background-color: #ccc;
                font-weight: 600;
                font-size: 10.8px;
                text-align: center;
            }

            .vac-label {
                background-color: #ccc;
                font-weight: 600;
            }

            .vac-data {
                font-weight: 400;
                color: #000;
            }

            .vac-fila-presentarse td {
                height: 25px;
                line-height: 1.1;
            }
        </style>

        <table class="tabla-borde tabla-vacaciones">
            <tr>
                <td class="vac-titulo" colspan="8">Días que Inician sus Vacaciones</td>
            </tr>

            <tr>
                <td class="vac-label" style="width: 10%;">Del</td>
                <td class="vac-data" style="width: 10%;">{{ $fecha_inicio->format('Y') }}</td>
                <td class="vac-data" style="width: 10%;">{{ $fecha_inicio->format('m') }}</td>
                <td class="vac-data" style="width: 10%;">{{ $fecha_inicio->format('d') }}</td>
                <td class="vac-label" style="width: 10%;">Al</td>
                <td class="vac-data" style="width: 10%;">{{ $fecha_termino->format('Y') }}</td>
                <td class="vac-data" style="width: 10%;">{{ $fecha_termino->format('m') }}</td>
                <td class="vac-data" style="width: 10%;">{{ $fecha_termino->format('d') }}</td>
            </tr>

            <tr class="vac-fila-presentarse">
                <td class="vac-label" colspan="4">Fecha en que deberá presentarse a trabajar:</td>
                <td class="vac-data" colspan="4">{{ $fecha_presentacion }}</td>
            </tr>
        </table>

        <table class="tabla-borde tabla-observaciones" style="border-top: none;">
            <tr>
                <td class="titulo-observaciones">OBSERVACIONES</td>
            </tr>
            <tr>
                <td class="contenido-observaciones">{{ $empleado->OBSERVACIONES_REC ?? '' }}</td>
            </tr>
        </table>

        <p style="margin-top: 10px; text-align: justify;">
            Por el presente expreso mi conformidad de solicitar y gozar mis vacaciones de acuerdo con lo que establece el artículo 76 de la Ley Federal del Trabajo vigente, considerando los datos antes mencionados.
        </p>

        <table style="width: 100%; text-align: center;">
            <tr>
                <td>Villahermosa, Tabasco.</td>
                <td>{{ $dia_salida }}</td>
                <td>de</td>
                <td>{{ $mes_salida }}</td>
                <td>de</td>
                <td>{{ $anio_salida }}</td>
            </tr>
        </table>

        <div class="espacio"></div>


        <table class="tabla-borde tabla-inferior tabla-autorizaciones" style="width: 100%; border-collapse: collapse;">
            <tr>
                <td colspan="3" class="text-center bg-gray" style="
            font-weight: bold;
            height: 18px;
            border: 1px solid black;">
                    Autorizaciones
                </td>
            </tr>

            <tr>
                <td style="border: 1px solid black; height: 2cm; vertical-align: bottom; padding-bottom: 4px;">
                    <div>&nbsp;________________________</div>
                    <div style="font-size: 10px; margin-top: 2px;">
                        &nbsp; {{ $nombre_solicito }}
                    </div>
                </td>

                <td style="border: 1px solid black; height: 2cm; vertical-align: bottom; padding-bottom: 4px;">
                    <div>&nbsp;________________________</div>
                    <div style="font-size: 10px; margin-top: 2px;">
                        &nbsp; {{ $nombre_jefe }}
                    </div>
                </td>

                <td style="border: 1px solid black; height: 2cm; vertical-align: bottom; padding-bottom: 4px;">
                    <div>&nbsp;________________________</div>
                    <div style="font-size: 10px; margin-top: 2px;">
                        &nbsp; {{ $nombre_autorizo }}
                    </div>
                </td>
            </tr>


            <tr class="text-center bg-gray" style="font-weight: bold; height: auto;">
                <td style="padding: 1; vertical-align: top; line-height: 0.95;">
                    Solicita<br>
                    <span style="font-weight: normal;">Colaborador</span>
                </td>
                <td style="padding: 1; vertical-align: top; line-height: 0.95;">
                    Vo. Bo.<br>
                    <span style="font-weight: normal;">Jefe inmediato</span>
                </td>
                <td style="padding: 1; vertical-align: top; line-height: 0.95;">
                    Autoriza<br>
                    <span style="font-weight: normal;">Líder RRHH y Admón/ Dirección</span>
                </td>
            </tr>
        </table>

    </main>
</body>

</html>