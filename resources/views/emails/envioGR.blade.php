<!DOCTYPE html>
<html lang="en">

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
            color: #333;
            font-size: 15px;
            line-height: 1.6;
        }

        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #2C3E50;
            padding: 12px;
            margin: 15px 0;
            font-weight: bold;
        }

        .table-info {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table-info td {
            border: 1px solid #e6e6e6;
            padding: 10px;
        }

        .table-info td:first-child {
            background: #f9fafb;
            font-weight: bold;
            width: 40%;
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
            font-weight: bold;
            font-size: 15px;
            display: inline-block;
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
        <div class="header"> Recepción de bienes y/o servicios </div>
        <div class="content">
            <p> Estimado proveedor, </p>
            <p> Se le informa que tiene una <b>Recepción de bienes y/o servicios pendiente</b> en el sistema. </p>
            <div class="info-box"> Detalle de la recepción </div>
            <table class="table-info">
                <tr>
                    <td>No. Recepción</td>
                    <td>{{ $no_recepcion }}</td>
                </tr>
                <tr>
                    <td>Fecha de emisión</td>
                    <td>{{ $fecha }}</td>
                </tr>
            </table>
            <div class="button"> <a href="https://results-erp.results-in-performance.com/login"> Ingresar al sistema </a> </div>
            <p> Por favor ingrese al sistema para revisar la orden de compra correspondiente. </p>

            <div class="no-reply"> NO responda a este correo electrónico.<br> Para cualquier duda o aclaración contacte a:<br> <a href="mailto:vlicona@results-in-performance.com"> vlicona@results-in-performance.com </a> </div>
        </div>

        <div class="footer"> © {{ date('Y') }} <a href="https://results-in-performance.com"> Results In Performance </a> <br> Todos los derechos reservados. </div>
    </div>





</body>

</html>