<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="20x20" href="/assets/images/favicon.png">
    <title>Results In Performance</title>
    <!-- Importar la fuente Maven Pro de Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            /* Aplicar la fuente Maven Pro */
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }

        .container {
            text-align: center;
            width: 80%;
            max-width: 700px;
            position: relative;
        }

        .card {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px 0;
            padding: 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 250px;
            max-width: 700px;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .logo {
            width: 100px;
            height: auto;
            margin-bottom: 20px;
        }

        .logo img {
            width: 140%;
            height: auto;
            object-fit: contain;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .description {
            font-size: 18px;
            color: #555;
        }

        a {
            text-decoration: none;
            color: inherit;
        }
    </style>
</head>

<body>
    <div class="container">
        <a href="https://results-erp.results-in-performance.com/Formulario-vacantes" target="_blank">
            <div class="card">
                <div class="logo">
                    <img src="/assets/images/Colorlargo.png" alt="Logo de la empresa">
                </div>
                <div class="title">Registrarse en el banco de CV's</div>
                <div class="description">Ingresa tus datos y regístrate.</div>
            </div>
        </a>
        <a href="https://results-erp.results-in-performance.com/Vacantes" target="_blank">
            <div class="card">
                <div class="title">Vacantes disponibles</div>
                <div class="description">Consulta las vacantes abiertas y postúlate.</div>
            </div>
        </a>
    </div>
</body>

</html>