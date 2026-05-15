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

        .alert {
            background: #fff8e6;
            border-left: 4px solid #f39c12;
            padding: 12px;
            margin: 15px 0;
            font-weight: bold;
        }

        .list {
            background: #f9fafb;
            border: 1px solid #e6e6e6;
            border-radius: 5px;
            padding: 15px;
            margin-top: 10px;
        }

        .list ul {
            margin: 0;
            padding-left: 20px;
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
            Información pendiente de registro
        </div>

        <div class="content">

            <p>{{ $saludo }} proveedor <b>{{ $razonSocial }}</b>,</p>

            <p>
                Gracias por su pre-registro en nuestro ERP.
            </p>

            <p>
                Detectamos que su registro en el sistema aún está incompleto.

            </p>

            <div class="alert">
                Los siguientes elementos requieren ser completados:
            </div>

            <div class="list">

                <ul>
                    @foreach ($faltantes as $item)
                    <li>{{ $item }}</li>
                    @endforeach
                </ul>

            </div>

            <p>
                Le solicitamos completar la información a la brevedad para continuar con el proceso de validación de su registro.
            </p>

            <div class="button">
                <a href="https://results-erp.results-in-performance.com/login">
                    Completar información en el sistema
                </a>
            </div>

            <p>
                Una vez completados los datos, su registro podrá continuar con el proceso de revisión.
            </p>

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