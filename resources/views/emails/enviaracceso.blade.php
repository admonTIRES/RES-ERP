<!-- <!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">


    <style>
        .footer {
            text-align: center;
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
    <p>{{ $saludo }} proveedor,</p>

    <p>Gracias por su pre-registro en nuestro ERP.</p>

    <p>Para concluir su registro, agradezco su apoyo para ingresar al siguiente link:</p>

    <p><a href="https://results-erp.results-in-performance.com/login">https://results-erp.results-in-performance.com/login</a></p>

    <p>Su clave para el acceso es la siguiente:</p>

    <ul>
        <li><strong>Usuario:</strong> {{ $usuario }}</li>
        <li><strong>Contraseña:</strong> {{ $contrasena }}</li>
    </ul>

    <p><strong>Notas:</strong></p>
    <p>
        <li>1.Tener en cuenta que al acceder les va solicitar un Código de Verificación, el cual llegará al correo que dieron de alta como contacto.</li>
        <li>2.Por favor completar el formulario en Datos generales, Actividad económica y términos comerciales e Información adicional para la debida diligencia.</li>
        <li>3.Ingresar a cada Menú que se encuentra del lado izquierdo de su pantalla, completar y adjuntar los datos y documentos que solicita.</li>
        <li>4.Por último, una vez que haya completado toda su información, presione el botón de validación para verificar todos sus datos.</li>

    </p>

    <br>

    <p>Saludos cordiales.</p>

    <div class="footer">
        <p>&copy; {{ date('Y') }} <a href="https://results-in-performance.com">Results In Performance</a>. Todos los derechos reservados.</p>
    </div>
</body>

</html> -->


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <style>
        .footer {
            text-align: center;
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

        .no-reply {
            margin-top: 30px;
            padding: 15px;
            border: 2px solid #cc0000;
            background-color: #fff3f3;
            color: #cc0000;
            font-size: 15px;
            font-weight: bold;
            text-align: center;
            border-radius: 5px;
        }

        .no-reply a {
            color: #cc0000;
            text-decoration: underline;
            font-weight: normal;
        }
    </style>
</head>

<body>
    <p>{{ $saludo }} proveedor,</p>

    <p>Gracias por su pre-registro en nuestro ERP.</p>

    <p>Para concluir su registro, agradezco su apoyo para ingresar al siguiente link:</p>

    <p><a href="https://results-erp.results-in-performance.com/login">https://results-erp.results-in-performance.com/login</a></p>

    <p>Su clave para el acceso es la siguiente:</p>

    <ul>
        <li><strong>Usuario:</strong> {{ $usuario }}</li>
        <li><strong>Contraseña:</strong> {{ $contrasena }}</li>
    </ul>

    <p><strong>Notas:</strong></p>
    <p>
        <li>1. Tener en cuenta que al acceder les va solicitar un Código de Verificación, el cual llegará al correo que dieron de alta como contacto.</li>
        <li>2. Por favor completar el formulario en Datos generales, Actividad económica y términos comerciales e Información adicional para la debida diligencia.</li>
        <li>3. Ingresar a cada Menú que se encuentra del lado izquierdo de su pantalla, completar y adjuntar los datos y documentos que solicita.</li>
        <li>4. Por último, una vez que haya completado toda su información, presione el botón de validación para verificar todos sus datos.</li>
    </p>

    <br>

    <p>Saludos cordiales.</p>

    <div class="no-reply">
        Por favor, <u>NO responda a este correo electrónico.</u><br>
        Si tiene alguna duda o aclaración, contacte a:
        <a href="mailto:vlicona@results-in-performance.com?subject=Consulta%20sobre%20registro%20ERP">vlicona@results-in-performance.com</a>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} <a href="https://results-in-performance.com">Results In Performance</a>. Todos los derechos reservados.</p>
    </div>
</body>

</html>