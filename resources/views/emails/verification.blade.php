<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Código de Verificación</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .header {
            background-color: #2C3E50;
            padding: 20px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .header img {
            width: 170px;
            display: block;
            margin: 0 auto;
        }

        .content {
            padding: 20px;
        }

        h2 {
            color: #2C3E50;
        }

        p {
            color: #555555;
            font-size: 16px;
        }

        .code {
            font-size: 24px;
            font-weight: bold;
            color: #ffffff;
            background-color: #2C3E50;
            padding: 15px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 10px;
        }

        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #777777;
        }

        .button {
            display: inline-block;
            background-color: #2C3E50;
            color: #ffffff;
            padding: 12px 25px;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
            margin-top: 20px;
        }

        .button:hover {
            background-color: #1a252f;
        }

        .footer a {
            color: #2C3E50;
            text-decoration: none;
            font-weight: bold;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="https://results-erp.results-in-performance.com/assets/images/logoBlanco.png"
                alt="Results In Performance" width="170">
        </div>
        <div class="content">
            <h2>Tu Código de Verificación</h2>
            <p>Usa este código para actualizar tu información:</p>
            <div class="code">{{ $codigo }}</div>
            <p>Este código expira en 10 minutos.</p>

        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} <a href="https://results-in-performance.com">Results In Performance</a>. Todos los derechos reservados.</p>
        </div>
    </div>
</body>

</html>