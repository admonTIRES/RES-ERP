<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 650px;
            margin: auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .header {
            background: #2C3E50;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }

        .content {
            padding: 25px;
            font-size: 15px;
            color: #333;
            line-height: 1.6;
        }

        .estatus-aprobado {
            background: #edf9f0;
            border-left: 4px solid #28a745;
            padding: 15px;
            margin: 15px 0;
            font-weight: bold;
            color: #28a745;
        }

        .estatus-rechazado {
            background: #fff3f3;
            border-left: 4px solid #dc3545;
            padding: 15px;
            margin: 15px 0;
            font-weight: bold;
            color: #dc3545;
        }

        .factura-box {
            background: #f9fafb;
            border: 1px solid #e6e6e6;
            border-radius: 5px;
            padding: 15px;
            margin-top: 15px;
        }

        .motivo {
            margin-top: 15px;
            padding: 12px;
            background: #ffeaea;
            border: 1px solid #ffcccc;
            border-radius: 5px;
            color: #cc0000;
        }

        .button {
            text-align: center;
            margin: 25px 0;
        }

        .button a {
            background: #007bff;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 15px;
            font-weight: bold;
            display: inline-block;
        }

        .button a:hover {
            background: #0056b3;
        }

        .no-reply {
            margin-top: 25px;
            padding: 15px;
            border: 2px solid #cc0000;
            background: #fff3f3;
            color: #cc0000;
            font-size: 14px;
            text-align: center;
            border-radius: 5px;
        }

        .no-reply a {
            color: #cc0000;
        }

        .footer {
            background: #f4f4f4;
            text-align: center;
            font-size: 13px;
            color: #777;
            padding: 15px;
        }

        .footer a {
            color: #2C3E50;
            text-decoration: none;
            font-weight: bold;
        }
    </style>

</head>

<body>

    <div class="container">

        <div class="header">
            Estatus de factura
        </div>

        <div class="content">

            <p>
                Estimado proveedor
                <b>{{ $proveedor->RAZON_SOCIAL_ALTA }}</b>,
            </p>

            @if($estatus == 1)

            <div class="estatus-aprobado">
                La factura ha sido aprobada correctamente.
            </div>

            @else

            <div class="estatus-rechazado">
                La factura ha sido rechazada.
            </div>

            @endif


            <div class="factura-box">

                @if($proveedor->TIPO_PERSONA_ALTA == 1)

                <b>Folio fiscal:</b><br>
                {{ $factura->FOLIO_FISCAL }}

                @else

                <b>No. Factura:</b><br>
                {{ $factura->NO_FACTURA_EXTRANJERO }}

                @endif

            </div>

            @if($estatus == 2)

            <p>
                <b>Motivo del rechazo:</b>
            </p>

            <div class="motivo">

                {{ $justificacion }}

            </div>

            <p>
                Le solicitamos realizar las correcciones correspondientes y volver a cargar la factura en el sistema.
            </p>



            <div class="button">

                <a href="https://results-erp.results-in-performance.com/login">

                    Ingresar al sistema

                </a>

            </div>



            @else


            @endif



            <div class="no-reply">

                NO responda a este correo electrónico.<br>

                Si tiene alguna duda o aclaración contacte a:<br>

                <a href="mailto:vlicona@results-in-performance.com">
                    vlicona@results-in-performance.com
                </a>

            </div>

        </div>

        <div class="footer">

            © {{ date('Y') }}

            <a href="https://results-in-performance.com">
                Results In Performance
            </a>

            <br>

            Todos los derechos reservados.

        </div>

    </div>

</body>

</html>