<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="20x20" href="/assets/images/favicon.png">
    <title>Results In Performance</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;

        }

        body,
        html {
            height: 100%;
            margin: 0;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            background-color: #ffffff;
            border-radius: 15px;
            padding: 50px;
            width: 450px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: 700;
            color: #333333;
        }

        .login-container img {
            width: 200px;
            margin-top: 30px;
        }

        .login-container .form-control {
            border-radius: 10px;
            margin-bottom: 25px;
            font-size: 18px;
            padding: 15px;
        }

        .login-container .btn {
            background-color: #ff4c4c;
            color: #ffffff;
            border-radius: 10px;
            padding: 15px;
            width: 100%;
            font-weight: 700;
            font-size: 18px;
        }

        .login-container .btn:hover {
            background-color: #ff4c4c;
        }

        .error-message {
            color: #ff4c4c;
            margin-bottom: 20px;
            font-size: 16px;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Acceso</h2>

        <!-- Mensaje de error si hay un error de login -->
        @if($errors->has('login_error'))
        <div class="error-message">
            {{ $errors->first('login_error') }}
        </div>
        @endif

        <form id="loginForm" action="/login" method="POST">
            @csrf
            <div class="form-group">
                <input type="text" class="form-control" name="email" placeholder="Correo electrónico o RFC" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Contraseña" required>
            </div>
            <button type="submit" class="btn">ENTRAR</button>
            <img src="assets/images/Colorancho.png" alt="Logo">
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("loginForm").addEventListener("submit", function(event) {
                event.preventDefault();

                let form = this;
                let formData = new FormData(form);

                fetch('/login', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'verification_required') {
                            Swal.fire({
                                title: 'Código de Verificación',
                                input: 'text',
                                inputLabel: 'Se ha enviado un código a tu correo con el que te diste de alta.',
                                inputPlaceholder: 'Ingresa el código aquí',
                                showCancelButton: true,
                                confirmButtonText: 'Verificar',
                                cancelButtonText: 'Cancelar',
                                inputValidator: (value) => {
                                    if (!value) {
                                        return 'Debes ingresar un código';
                                    }
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    let verifyData = new FormData();
                                    verifyData.append('correo', data.correo);
                                    verifyData.append('codigo', result.value);
                                    verifyData.append('_token', document.querySelector('input[name="_token"]').value);

                                    fetch('/verify-code', {
                                            method: 'POST',
                                            body: verifyData
                                        })
                                        .then(response => response.json())
                                        .then(verifyData => {
                                            if (verifyData.status === 'success') {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Verificado',
                                                    text: 'Código correcto, accediendo...',
                                                }).then(() => window.location.href = data.redirect);
                                            } else {
                                                fetch('/logout', {
                                                    method: 'POST',
                                                    headers: {
                                                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                                                    }
                                                }).then(() => {
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Código incorrecto o expirado',
                                                        text: 'Vuelve a intentarlo',
                                                    }).then(() => window.location.href = "/login");
                                                });
                                            }
                                        });
                                }
                            });
                        } else if (data.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Inicio de sesión exitoso',
                                confirmButtonText: 'Aceptar'
                            }).then(() => {
                                window.location.href = data.redirect;
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message,
                                confirmButtonText: 'Intentar de nuevo'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    </script>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</body>

</html>