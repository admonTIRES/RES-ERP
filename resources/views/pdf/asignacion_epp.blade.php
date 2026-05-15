<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Asignación EPP</title>

    <style>
        @font-face {
            font-family: 'Poppins';
            src: url("{{ public_path('fonts/poppins/Poppins-Regular.ttf') }}");
            font-weight: normal;
        }

        @font-face {
            font-family: 'Poppins';
            src: url("{{ public_path('fonts/poppins/Poppins-Bold.ttf') }}");
            font-weight: bold;
        }

        * {
            font-family: 'Poppins', sans-serif !important;
        }


        @page {

            margin: 145px 40px 40px 40px;

        }

        body {
            margin: 0;
            margin-top: 40px;
            font-family: 'Poppins', sans-serif;
            font-size: 11px;
        }



        header {
            position: fixed;
            top: -90px;
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
            font-size: 11px;
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

        .bloque-firmas {
            margin-top: 35px;
            page-break-inside: avoid;
        }

        .logo {
            max-width: 70px;
            margin-top: 10px;
        }

        table td {
            border: 1px solid black;
            padding: 4px;
            font-size: 10px;
        }
    </style>
</head>

<body>



    <!-- HEADER -->
    <header>
        <table>
            <tr>
                <td rowspan="3" class="text-center" style="width:33%">
                    <img src="{{ public_path('assets/images/MARCAREGISTRADA.png') }}" class="logo">
                </td>
                <td rowspan="3" class="text-center" style="font-size:10px;">
                    <strong>Solicitud y entrega de equipos de protección personal y/o dotación de seguridad industrial</strong>
                </td>
                <td class="text-center bold">PS-RH-FO-24</td>
            </tr>
            <tr>
                <td class="text-center">Versión 1</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
        </table>
    </header>


    <br>

    <table>
        <tr>
            <td class="bg-gray" style="width:20%">Nombre:</td>
            <td>
                {{ $empleado->NOMBRE_COLABORADOR ?? '' }}
                {{ $empleado->PRIMER_APELLIDO ?? '' }}
                {{ $empleado->SEGUNDO_APELLIDO ?? '' }}
            </td>
        </tr>

        <tr>
            <td class="bg-gray">Cargo:</td>
            <td>
                {{ $cargo->NOMBRE_CATEGORIA ?? '' }}
            </td>
        </tr>
    </table>

    @php
    $epp = json_decode($asignacion->EPP_JSON ?? '[]', true);
    @endphp

    <br>

    <table>
        <tr>
            <td class="bg-gray text-center" colspan="2">Equipo entregado</td>
            <td class="bg-gray text-center">Talla</td>
            <td class="bg-gray text-center">Cant. Solicitada</td>
            <td class="bg-gray text-center">Cant. Entregada</td>
        </tr>

        @foreach($epp as $item)
        <tr>
            <td class="text-center">
                {{ $item['categoria'] ?? '' }}
            </td>
            <td>
                {{ $item['equipo'] ?? '' }}
            </td>
            <td class="text-center">
                {{ $item['talla'] ?? 'N/A' }}
            </td>
            <td class="text-center">
                {{ $item['cantidad_solicitada'] ?? 0 }}
            </td>
            <td class="text-center">
                {{ $item['cantidad_entregada'] ?? 0 }}
            </td>
        </tr>
        @endforeach
    </table>


    <br>

    <table>
        <tr>
            <td class="bg-gray" style="width:30%">Fecha de entrega:</td>
            <td class="text-center">
                {{ $asignacion->FECHA_ASIGNACION ?? '' }}
            </td>
        </tr>
    </table>

    <br>

    <table>
        <tr>
            <td style="border: 1px solid black; padding:8px; font-size:10px; line-height:14px; text-align: justify;">
                DECLARO HABER RECIBIDO LOS ELEMENTOS DE PROTECCIÓN PERSONAL AQUÍ SEÑALADOS,
                ASÍ COMO LAS INSTRUCCIONES PARA SU CORRECTO USO Y ACEPTO EL COMPROMISO QUE SE SOLICITA DE:
                <br>
                a. Utilizar el elemento durante la jornada de trabajo en las áreas cuya obligatoriedad de uso se encuentra señalizado.
                <br>
                b. Consultar cualquier duda sobre su correcta utilización, cuidando de su perfecto estado y conservación.
                <br>
                c. Solicitar un nuevo equipo en caso de deterioro del mismo.
            </td>
        </tr>
    </table>

    <br>

    <table style="width:100%; border-collapse: collapse;">
        <tr>
            <td style="height:50px; border:1px solid black;"></td>
            <td style="height:50px; border:1px solid black;"></td>
            <td style="height:50px; border:1px solid black;"></td>
        </tr>

        <tr>
            <td class="text-center" style="padding-top:5px;">
                {{ $empleado->NOMBRE_COLABORADOR ?? '' }}
                {{ $empleado->PRIMER_APELLIDO ?? '' }}
                {{ $empleado->SEGUNDO_APELLIDO ?? '' }}
            </td>
            <td class="text-center" style="padding-top:5px;">
                {{ $asignacion->ALMACENISTA_ASIGNACION ?? '' }}
            </td>
            <td class="text-center" style="padding-top:5px;">
                {{ $asignacion->PERSONAL_ASIGNA ?? '' }}
            </td>

        </tr>
        <tr>
            <td class="bg-gray text-center bold">
                Recibe <br> Colaborador
            </td>
            <td class="bg-gray text-center bold">
                Entrega <br> Almacenista
            </td>
            <td class="bg-gray text-center bold">
                Autoriza <br> RRHH
            </td>
        </tr>
    </table>



    <script type="text/php">

        if (isset($pdf)) {
        $pdf->page_script(function ($pageNumber, $pageCount, $pdf, $fontMetrics) {

            $font = $fontMetrics->getFont("Poppins", "normal");

            $x = 465; 
            $y = 105; 

            $pdf->text($x, $y, "Página $pageNumber de $pageCount", $font, 9);
        });
    }
</script>


</body>

</html>