<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Asignaciones </title>

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
            margin: 130px 40px 110px 40px;
        }



        body {
            margin-top: 40px;
            padding-left: 50px;
            padding-right: 10px;
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

        .page-background {
            position: fixed;
            top: -130px;
            left: -40px;
            right: -40px;
            bottom: -110px;
            z-index: -1000;
        }

        .page-background img {
            width: 100%;
            height: 100%;
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
    </style>
</head>

<body>


    <div class="page-background">
        <img src="{{ public_path('assets/images/membretado.png') }}">
    </div>

    <!-- HEADER -->
    <header>
        <table>
            <tr>
                <td rowspan="3" class="text-center" style="width:33%">
                    <img src="{{ public_path('assets/images/MARCAREGISTRADA.png') }}" class="logo">
                </td>
                <td rowspan="3" class="text-center" style="font-size:10px;">
                    <strong>Asignación de equipo de cómputo - otros</strong>
                </td>
                <td class="text-center bold">PS-RH-FO-11</td>
            </tr>
            <tr>
                <td class="text-center">Versión 1</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
        </table>
    </header>




    <div class="contenido">


        <table style="margin-top: 10px; width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 30%; border: none;">
                    Nombre del empleado
                </td>
                <td style="width: 70%; border: none; border-bottom: 1px solid #000;">
                    {{
                trim(
                    ($empleado->NOMBRE_COLABORADOR ?? '') . ' ' .
                    ($empleado->PRIMER_APELLIDO ?? '') . ' ' .
                    ($empleado->SEGUNDO_APELLIDO ?? '')
                )
            }}
                </td>
            </tr>
            <tr>
                <td style="border: none; padding-top: 2px;">
                    Número de empleado
                </td>
                <td style="border: none; border-bottom: 1px solid #000; padding-top: 2px;">
                    {{ $empleado->NUMERO_EMPLEADO ?? '' }}
                </td>
            </tr>
        </table>

        <div class="texto-legal" style="margin-top: 10px;">
            <strong>Results In Performance S.A. de C.V. (RES)</strong> provee equipo, consumibles y
            materiales necesarios para desempeñar su trabajo. Estos artículos deberán ser usados
            única y exclusivamente para los propósitos de <strong>RES</strong>. Se espera que los
            empleados de <strong>RES</strong> cuiden el equipo que se le ha asignado y lo utilicen
            exclusivamente para los fines autorizados.
            <br><br>
            La negligencia en el uso del equipo podrá ser motivo de sanción, que podrá llegar hasta la
            terminación de la relación laboral. Adicionalmente <strong>RES</strong> podrá exigir el
            pago de la reparación o reposición de estos activos. La pérdida, robo o daño de cualquier
            equipo propiedad de <strong>RES</strong> debe de ser reportada al jefe inmediato.
        </div>

        <table style="margin-top: 10px;">
            <thead>
                <tr class="bg-gray text-center">
                    <td>Descripción</td>
                    <td>Cantidad</td>
                    <td>Marca</td>
                    <td>Modelo</td>
                    <td>No. Serie</td>
                    <td>No. Inventario</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($inventarios as $item)
                <tr>
                    <td class="text-center">{{ $item->DESCRIPCION_EQUIPO }}</td>
                    <td class="text-center">{{ $item->CANTIDAD_SALIDA }}</td>
                    <td class="text-center">{{ $item->MARCA_EQUIPO }}</td>
                    <td class="text-center">{{ $item->MODELO_EQUIPO }}</td>
                    <td class="text-center">{{ $item->SERIE_EQUIPO }}</td>
                    <td class="text-center">{{ $item->CODIGO_EQUIPO }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>


        <div class="texto-acuse" style="margin-top: 10px;">
            Por este medio, acuso de recibo del equipo descrito anteriormente. Me doy por enterado de la
            responsabilidad que tengo sobre el equipo de protección de <strong>RES</strong>, que tengo
            en mi posesión. Soy responsable de reembolsar el valor total del equipo en caso de que no esté
            en buen estado, no funcione o no sea devuelto al momento en que sea requerido y autorizo a
            <strong>RES</strong> a que se me descuente de mi finiquito o de cualquier otra forma, este valor.
        </div>



        <div class="bloque-firmas">

            <table style="width:100%; border:none;">
                <tr>
                    <td style="width:35%; border:none;">
                        Nombre y firma del colaborador:
                    </td>
                    <td style="width:65%; border:none; border-bottom:1px solid #000;">
                        {{ trim(
                    ($empleado->NOMBRE_COLABORADOR ?? '') . ' ' .
                    ($empleado->PRIMER_APELLIDO ?? '') . ' ' .
                    ($empleado->SEGUNDO_APELLIDO ?? '')
                ) }}
                    </td>
                </tr>
            </table>

            <div style="margin-top:10px; text-align:center; font-weight:bold;">
                Personal que asigna
            </div>

            <table style="margin-top:10px; width:100%; border:none;">
                <tr>
                    <td style="width:15%; border:none;">Nombre y firma:</td>
                    <td style="width:55%; border:none; border-bottom:1px solid #000;">
                        {{ $asignacion->PERSONAL_ASIGNA ?? '' }}
                    </td>
                    <td style="width:10%; border:none; text-align:right;">Fecha:</td>
                    <td style="width:20%; border:none; border-bottom:1px solid #000;">
                        {{ $asignacion->FECHA_ASIGNACION ?? '' }}
                    </td>
                </tr>
            </table>

            <div style="margin-top:10px; text-align:center; font-weight:bold;">
                Almacenista
            </div>

            <table style="margin-top:10px; width:100%; border:none;">
                <tr>
                    <td style="width:15%; border:none;">Nombre y firma:</td>
                    <td style="width:85%; border:none; border-bottom:1px solid #000;">
                        {{ $asignacion->ALMACENISTA_ASIGNACION ?? '' }}
                    </td>
                </tr>
            </table>

        </div>




    </div>

    <script type="text/php">
        if (isset($pdf)) {
            $pdf->page_script(function ($pageNumber, $pageCount, $pdf, $fontMetrics) {

                $font = $fontMetrics->getFont("Poppins", "normal");

            
                $x = 465; 
                $y = 95; 

        $pdf->text($x, $y, "Página $pageNumber de $pageCount", $font, 9);
    });
}
</script>


</body>

</html>