<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>PS-RH-FO-22 Aviso de ausencia y/o permiso</title>

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
            margin: 0;
            padding: 0;
        }

        @page {

            margin: 145px 40px 40px 40px;

        }

        header {
            position: fixed;
            top: -110px;
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
            border-spacing: 0;
        }

        th,
        td {
            border: 1px solid black;
            padding: 4px;
        }

        .tabla-borde {
            border-left: 1.5px solid black;
            border-right: 1.5px solid black;
        }

        .tabla-superior {
            border-top: 1.5px solid black;
        }

        .tabla-inferior {
            border-bottom: 1.5px solid black;
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

        .text-left {
            text-align: left;
        }

        .bold {
            font-weight: bold;
        }

        .small-text {
            font-size: 9px;
        }

        .logo {
            display: block;
            margin-left: auto;
            margin-right: auto;
            max-width: 160px;
        }

        .tabla-encabezado td {
            border: 1px solid black;
        }

        .tabla-observaciones td {
            height: 60px;
            vertical-align: top;
        }

        .tabla-notas td {
            border: none;
            font-size: 9px;
            line-height: 1.2;
            padding-left: 2px;
        }

        .tabla-autorizaciones td {
            height: 30px;
            vertical-align: bottom;
        }
    </style>
</head>

<body>

    <header>
        <table class="tabla-superior tabla-borde tabla-encabezado">
            <tr>
                <td rowspan="3" style="width: 10; text-align: center;">
                    <img src="{{ public_path('assets/images/Color@4x.png') }}" class="logo" style="margin-top: 20px;">
                </td>
                <td rowspan="3" class="text-center" style="font-size: 15px;">
                    <strong>Aviso de ausencia y/o permiso</strong>
                </td>
                <td class="text-center bold">PS-RH-FO-22</td>
            </tr>
            <tr>
                <td class="text-center">Versión: 1</td>
            </tr>
            <tr>
                <td class="text-center">Página 1 de 1</td>
            </tr>
        </table>
    </header>

    <main>

        <table class="tabla-borde tabla-datos" style="border-top: none; width: 100%; border-collapse: collapse;">
            <tr>
                <td colspan="3" style="border: none; padding: 0; height: 18px;">
                    <div style="text-align: right; font-size: 11px;">
                        <div style="display: inline-block; text-align: left;">
                            <strong>Fecha:</strong>
                            <span style="display: inline-block; border-bottom: 1.5px solid black; width: 140px; margin-left: 5px; vertical-align: middle;">
                                {{ $fecha ?? '' }}
                            </span>
                        </div>
                    </div>
                </td>


            </tr>

            <tr>
                <td colspan="3" style="border: none; padding: 2px 0 0 0; height: 20px; font-size: 11px;">
                    <strong>&nbsp;Nombre del empleado:</strong>
                    <span style="display: inline-block; border-bottom: 1.5px solid black; width: 580px; margin-left: 5px; line-height: 13px; vertical-align: middle;">
                        {{ $nombre_empleado ?? '' }}
                    </span>
                </td>
            </tr>

            <tr>
                <td colspan="2" style="border: none; padding: 2px 0 10px 0; height: 20px; font-size: 11px;">
                    <strong>&nbsp;Cargo:</strong>
                    <span style="display: inline-block; border-bottom: 1.5px solid black; width: 280px; margin-left: 5px; line-height: 13px; vertical-align: middle;">
                        {{ $cargo ?? '' }}
                    </span>
                </td>
                <td style="border: none; padding: 2px 0 10px 0; height: 20px; font-size: 11px;">
                    <strong>No. de empleado:</strong>
                    <span style="display: inline-block; border-bottom: 1.5px solid black; width: 130px; margin-left: 5px; line-height: 13px; vertical-align: middle;">
                        {{ $no_empleado ?? '' }}
                    </span>
                </td>

            </tr>

        </table>


        <style>
            .tabla-conceptos {
                border-collapse: collapse;
                width: 100%;
                border: 1.5px solid black;
                font-size: 10.5px;
            }

            .tabla-conceptos th,
            .tabla-conceptos td {
                border: 1px solid black;
                text-align: center;
                padding: 2px 3px;
                height: 17px;
            }

            .tabla-conceptos thead th {
                background-color: #ccc;
                font-weight: bold;
            }

            .tabla-conceptos tbody td:first-child {
                background-color: #e6e6e6;
                text-align: left;
                padding-left: 6px;
            }

            .tabla-conceptos tbody td:not(:first-child) {
                background-color: #fff;
            }

            .celda-diagonal {
                position: relative;
                padding: 0;
                height: 22px;
                text-align: center;
                vertical-align: middle;
                overflow: hidden;
            }

            .celda-diagonal::after {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                width: 150%;
                height: 150%;
                border-top: 1px solid black;
                transform: rotate(-45deg);
                transform-origin: top left;
            }
        </style>


        <table class="tabla-borde tabla-conceptos">
            <thead>
                <tr>
                    <th>Concepto de ausencia</th>
                    <th>No. de días</th>
                    <th>No. horas</th>
                    <th>Fecha inicial</th>
                    <th>Fecha Final</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($conceptos as $key => $concepto)
                @php
                $esSeleccionado = $conceptoSeleccionado == $key;
                $mostrarDias = $esSeleccionado && !empty($no_dias);
                $mostrarHoras = $esSeleccionado && !empty($no_horas);
                @endphp

                @if ($key != 9)
                <tr>
                    <td>{{ $concepto }}</td>

                    @if ($mostrarDias)
                    <td class="text-center">{{ $no_dias }}</td>
                    @else
                    <td class="celda-diagonal"></td>
                    @endif

                    @if ($mostrarHoras)
                    <td class="text-center">{{ $no_horas }}</td>
                    @else
                    <td class="celda-diagonal"></td>
                    @endif

                    @if ($esSeleccionado)
                    <td class="text-center">{{ $fecha_inicial ?? '' }}</td>
                    <td class="text-center">{{ $fecha_final ?? '' }}</td>
                    @else
                    <td class="celda-diagonal"></td>
                    <td class="celda-diagonal"></td>
                    @endif
                </tr>

                @else
                <tr>
                    <td style="text-align: left; padding: 0; width: 28%;">
                        <table style="width: 100%; border-collapse: collapse; border: none;">
                            <tr>
                                <td style="
                                    background-color: #e6e6e6;
                                    width: 50%;
                                    padding-left: 5px;
                                    border: none;
                                    border-right: 1px solid black;">
                                    Otros (explique)
                                </td>
                                <td style="
                                    background-color: #ffffff;
                                    width: 50%;
                                    border: none;">
                                    @if ($esSeleccionado)
                                    {{ $explique ?? '' }}
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </td>

                    {{-- No. días --}}
                    @if ($mostrarDias)
                    <td class="text-center">{{ $no_dias }}</td>
                    @else
                    <td class="celda-diagonal"></td>
                    @endif

                    {{-- No. horas --}}
                    @if ($mostrarHoras)
                    <td class="text-center">{{ $no_horas }}</td>
                    @else
                    <td class="celda-diagonal"></td>
                    @endif

                    {{-- Fechas --}}
                    @if ($esSeleccionado)
                    <td class="text-center">{{ $fecha_inicial ?? '' }}</td>
                    <td class="text-center">{{ $fecha_final ?? '' }}</td>
                    @else
                    <td class="celda-diagonal"></td>
                    <td class="celda-diagonal"></td>
                    @endif
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>

        <table class="tabla-borde tabla-observaciones" style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="
            background-color: #e6e6e6;
            text-align: center;
            font-weight: bold;
            border: 1px solid black;
            height: 20px;">
                    Observaciones
                </td>
            </tr>

            <tr>
                <td style="
            background-color: #ffffff;
            height: 60px;
            vertical-align: top;
            border: 1px solid black;
            padding: 5px;">
                    {{ $observaciones ?? '' }}
                </td>
            </tr>
        </table>

        <table class="tabla-borde tabla-notas">
            <tr>
                <td>1. Anexar acta de defunción (cónyuge, hijos, padres o hermanos) <br> 2. Anexar acta de matrimonio <br> 3. Anexar acta de nacimiento o adopción</td>
            </tr>

        </table>

        <table class="tabla-borde tabla-uso" style="width: 100%; border-collapse: collapse;  border: none; ">
            <tr>
                <td colspan="2" class="bg-gray" style="
            text-align: center;
            font-weight: bold;
            border: 1px solid black;
            height: 20px;">
                    Uso exclusivo del área encargada
                    <span style="font-weight: normal;">(Marca con una “X”)</span>
                </td>
            </tr>

            <tr>
                <td style="padding: 0;">
                    <table style="width: 100%; border-collapse: collapse; border: none;">
                        <tr>
                            <td style="
                        background-color: #e6e6e6;
                        width: 85%;
                        padding-left: 5px;
                         border: none;
                                    border-right: 1px solid black;
                        height: 22px;">
                                Permiso con goce de sueldo
                            </td>
                            <td style="
                        background-color: #ffffff;
                        width: 15%;
                        text-align: center;
                        font-weight: bold;
                        height: 22px;
                        border: none;">
                                @if($goce_permiso == 1 || $goce_permiso === '1')
                                X
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>

                <td style="padding: 0; ">
                    <table style="width: 100%; border-collapse: collapse; border: none;">
                        <tr>
                            <td style="
                        background-color: #e6e6e6;
                        width: 85%;
                        padding-left: 5px;
                        border: none;
                        border-right: 1px solid black;
                        height: 22px;">
                                Permiso sin goce de sueldo
                            </td>
                            <td style="
                        background-color: #ffffff;
                        width: 15%;
                        text-align: center;
                        font-weight: bold;
                        height: 22px;
                        border: none;">
                                @if($goce_permiso == 2 || $goce_permiso === '2')
                                X
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <table class="tabla-borde tabla-inferior tabla-autorizaciones" style="width: 100%; border-collapse: collapse;">
            <tr>
                <td colspan="3" class="text-center bg-gray" style="
            font-weight: bold;
            height: 18px;
            border: 1px solid black;">
                    Autorizaciones
                </td>
            </tr>

            <tr class="text-center" style="height: 55px;">
                <td style="border: 1px solid black; vertical-align: bottom; padding-bottom: 2px;">
                    <div>________________________</div>
                    <div style="font-size: 10px; margin-top: 0px;">
                        {{ $nombre_solicito }}
                    </div>
                </td>
                <td style="border: 1px solid black; vertical-align: bottom; padding-bottom: 2px;">
                    <div style=" margin-top: 30px;">________________________</div>
                    <div style="font-size: 10px; margin-top: 0px;">
                        {{ $nombre_jefe }}
                    </div>
                </td>
                <td style="border: 1px solid black; vertical-align: bottom; padding-bottom: 2px;">
                    <div style=" margin-top: 30px;">________________________</div>
                    <div style="font-size: 10px; margin-top: 0px;">
                        {{ $nombre_autorizo }}
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
                    <span style="font-weight: normal;">RRHH - Administración/Dirección</span>
                </td>
            </tr>
        </table>


    </main>

</body>

</html>