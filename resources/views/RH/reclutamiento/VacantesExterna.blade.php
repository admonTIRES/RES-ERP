<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" sizes="20x20" href="/assets/images/favicon.png">
    <title>Results In Performance</title>

    <!-- Bootstrap  iconos v1.11.3 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Bootstrap v.5.2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css" rel="stylesheet">

    <!-- Datatables 1.13.1  v.5.2 -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" />
    <!--Animación -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/loadingio/loading.css@v2.0.0/dist/loading.css​">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/loadingio/loading.css@v2.0.0/dist/loading.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/loadingio/transition.css@v2.0.0/dist/transition.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/loadingio/transition.css@v2.0.0/dist/transition.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/loadingio/ldcover/dist/index.min.css">
    <!-- Select opcion selectize -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.default.min.css" />

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.2.0/css/bootstrap.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">


    <style>
        body {
            font-family: 'Poppins', sans-serif;

        }

        #details-container {
            width: 100%;
            display: flex;
            justify-content: center;
            overflow-y: auto;
        }

        .details-pane {
            width: 80%;
            max-width: 1300px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }

        a:hover {
            text-decoration: underline;
        }

        .modal-footer-center {
            display: flex;
            justify-content: center;
            align-items: center;
        }



        .card {
            transition: 0.3s ease-in-out;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
        }

        .img-fluid {
            max-width: 90%;
            height: auto;
        }

        @media (max-width: 1200px) {
            .vertical-text {
                font-size: 6em !important;
            }
        }

        @media (max-width: 992px) {
            .vertical-text {
                font-size: 6vw;
            }
        }

        @media (max-width: 768px) {
            .img-fluid {
                max-width: 300px !important;
            }

            .vertical-text {
                font-size: 5vw;
            }
        }

        @media (max-width: 576px) {
            .img-fluid {
                max-width: 200px !important;
            }

            .vertical-text {
                font-size: 4vw;
            }
        }

        @media (max-width: 480px) {
            .img-fluid {
                max-width: 150px !important;
            }

            .vertical-text {
                font-size: 3vw;
            }
        }

        @media (max-width: 360px) {
            .img-fluid {
                max-width: 120px !important;
            }

            .vertical-text {
                font-size: 2.5em !important;
            }
        }

        .col-md-12 {
            width: 85%;
        }

        .col-md-4 {
            width: 41.333333%;
        }

        .col-md-8 {
            flex: 0 0 auto;
            width: 58.666667%;
        }

        .custom-card {
            max-width: 950px;
            background-color: #FFFFFF;
            border-radius: 0 30px 0 0;
            border: 1px solid #e0e0e0;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.1);
            margin: 0;
            padding: 20px;
            position: relative;
            left: 40px;
            display: flex;
            flex-direction: column;
        }

        #details-container {
            display: flex;
            justify-content: flex-start;
            align-items: flex-start;
            padding-left: 50px;
        }

        .text-pane {
            display: flex;
            justify-content: center;
            align-items: center;
            position: fixed;
            right: 70px;
            top: 44%;
            transform: translateY(-50%);
            width: 300px;
            height: auto;
            background-color: transparent;
            z-index: 1000;
        }

        .vertical-text {
            font-size: 5vw;
            font-weight: bold;
            color: rgba(255, 255, 255, 0.2);
            text-align: left;
            line-height: 1.2;
            writing-mode: vertical-rl;
            text-orientation: mixed;
            transform: rotate(180deg);
        }

        .custom-card .btn-primary {
            background-color: #A4D65E;
            border: none;
        }

        body,
        html {
            overflow-x: hidden;
            overflow-y: auto;
        }

        .swal2-container {
            z-index: 10050 !important;
        }
    </style>

</head>

<body>

    @php
    use Carbon\Carbon;
    @endphp








    {{-- <div class="container-fluid">
    <div class="row">
        <!-- Panel Izquierdo -->
        <div id="panel-izquierdo" class="col-md-4" style="background-color: rgb(50 95 131); padding: 60px; color: white; height: 100vh;">
            <h1 style="font-size: 2.5em;">Encuentra el <span style="color: #A4D65E;">trabajo</span> que <span style="font-family: 'Satisfy', cursive;">quieres</span><span style="font-size: 2em;">→</span></h1>

            <div class="text-center mt-5">
                <img src="/assets/images/image.png" alt="Logo Blanco" class="img-fluid">
            </div>

            <div class="d-flex justify-content-center mt-5">
                <div class="text-center mx-3">
                    <img src="/assets/images/medalla.png" alt="Postúlate" style="width: 100px; height: 100px;">
                    <p style="font-size: 1.2em;">Postúlate gratis</p>
                </div>
                <div class="text-center mx-3">
                    <img src="/assets/images/documentos.png" alt="Descubre Vacantes" style="width: 100px; height: 100px;">
                    <p style="font-size: 1.2em;">Descubre vacantes</p>
                </div>
            </div>
        </div>

        <div id="vacantes-container" class="col-md-8" style="background-color: #F7F9FB; padding: 60px;">
            <!-- Título más grande -->
            <h1 style="color: #A4D65E; font-size: 3em; font-weight: bold;">Vacantes disponibles</h1>
            <br>
            <div class="row">
                @foreach($vacantes as $vacante)
                    @php
                        $slug = $vacante->ID_CATALOGO_VACANTE;
                        $fechaFormateada = Carbon::parse($vacante->updated_at)->locale('es')->isoFormat('D [de] MMMM [del] YYYY');
                    @endphp

                    <div class="col-md-12 mb-4">
                        <div class="card p-4" style="background-color: #A4D65E; border-radius: 15px; cursor: pointer;" onclick="showDetails('{{ $slug }}')">
    <div class="card-body text-white">
        <h6 style="font-size: 1.2em;">{{ $fechaFormateada }}</h6>
        <h3 class="card-title" style="font-size: 1.5em;">{{ $vacante->NOMBRE_CATEGORIA }}</h3>
        <p style="font-size: 1.1em;"><i class="bi bi-geo-alt-fill"></i> {{ $vacante->LUGAR_VACANTE }}</p>
    </div>
    </div>
    </div>
    @endforeach
    </div>
    </div>
    </div>
    </div> --}}




    <div class="container-fluid">
        <div class="row">
            <!-- Panel Izquierdo -->
            <div id="panel-izquierdo" class="col-md-4" style="background-color: rgb(50 95 131); padding: 60px; color: white; height: 100vh;">
                <h1 style="font-size: 2.5em;">Encuentra el <span style="color: #A4D65E;">trabajo</span> que <span style="font-family: 'Satisfy', cursive;">quieres</span><span style="font-size: 2em;">→</span></h1>

                <div class="text-center mt-5">
                    <img src="/assets/images/logoBlanco.png" alt="Logo Blanco" class="img-fluid">
                </div>

                <div class="d-flex justify-content-center mt-5">
                    <div class="text-center mx-3">
                        <img src="/assets/images/medalla.png" alt="Postúlate" style="width: 100px; height: 100px;">
                        <p style="font-size: 1.2em;">Postúlate gratis</p>
                    </div>
                    <div class="text-center mx-3">
                        <img src="/assets/images/documentos.png" alt="Descubre Vacantes" style="width: 100px; height: 100px;">
                        <p style="font-size: 1.2em;">Descubre vacantes</p>
                    </div>
                </div>
            </div>

            <div id="vacantes-container" class="col-md-8" style="background-color: #F7F9FB; padding: 60px;">
                <!-- Título más grande -->
                @if(count($vacantes) > 0)
                <h1 style="color: #A4D65E; font-size: 3em; font-weight: bold;">Vacantes disponibles</h1>
                <br>
                <div class="row">
                    @foreach($vacantes as $vacante)
                    @php
                    $slug = $vacante->ID_CATALOGO_VACANTE;
                    $fechaFormateada = Carbon::parse($vacante->updated_at)->locale('es')->isoFormat('D [de] MMMM [del] YYYY');
                    @endphp

                    <div class="col-md-12 mb-4">
                        <div class="card p-4" style="background-color: #A4D65E; border-radius: 15px; cursor: pointer;" onclick="showDetails('{{ $slug }}')">
                            <div class="card-body text-white">
                                <h6 style="font-size: 1.2em;">{{ $fechaFormateada }}</h6>
                                <h3 class="card-title" style="font-size: 1.5em;">{{ $vacante->NOMBRE_CATEGORIA }}</h3>
                                <p style="font-size: 1.1em;"><i class="bi bi-geo-alt-fill"></i> {{ $vacante->LUGAR_VACANTE }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <!-- Mensaje de no hay vacantes disponibles -->
                <div class="d-flex flex-column justify-content-center align-items-center" style="height: 100%;">
                    <h3 style="color: #333; font-size: 2em; margin-top: 20px;">No hay vacantes disponibles por el momento</h3>
                    <p style="font-size: 1.5em; color: #777; margin-top: 20px;">Por favor, vuelve a revisar más tarde.</p>
                </div>
                @endif
            </div>
        </div>
    </div>









    <div id="details-container" class="position-relative" style="display: none; background-color: rgb(50 95 131); padding: 30px; min-height: 100vh; width: 100%; position: fixed; top: 0; left: 0; z-index: 9999; overflow-y: auto;">
        <div class="content-wrapper" style="display: flex; width: 100%; position: relative;">
            @foreach($vacantes as $vacante)
            @php
            $slug = $vacante->ID_CATALOGO_VACANTE;
            $fechaFormateada = Carbon::parse($vacante->updated_at)->locale('es')->isoFormat('D [de] MMMM [del] YYYY');
            @endphp
            <div class="details-pane custom-card" id="details-{{ $slug }}" style="display: none;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <a href="#" onclick="volverATabla()" style="color: #A4D65E; text-decoration: none;">
                        <span style="font-size: 1.2em; font-weight: bold;">&#x2190;</span> Volver
                    </a>
                </div>

                <h2 class="card-title my-4" style="color: #A4D65E; font-size: 2.5em;">{{ $vacante->NOMBRE_CATEGORIA }}</h2>
                <div class="d-flex align-items-center mb-3">
                    <i class="bi bi-geo-alt-fill" style="font-size: 1.5em; color: #A4D65E; margin-right: 10px;"></i>
                    <span style="color: #555; font-size: 1.2em;">{{ $vacante->LUGAR_VACANTE }}</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span style="color: #555; font-size: 1.2em;">{{ $fechaFormateada }}</span>
                </div>
                <br><br>
                <p style="color: #A4D65E; font-size: 1.2em;"><strong>Descripción, requisitos y beneficios de la vacante:</strong></p>
                <p style="color: #555; line-height: 1.6;">{{ $vacante->DESCRIPCION_VACANTE }}</p>
                <!-- <p style="color: #A4D65E; font-size: 1.2em;"><strong>Requisitos:</strong></p>
                <ul style="color: #555;">
                    @foreach($vacante->requerimientos as $requerimiento)
                    <li>{{ $requerimiento }}</li>
                    @endforeach
                </ul> -->
                <div class="text-end mt-4">
                    <button type="button" class="btn btn-primary postularse-btn" data-bs-toggle="modal" data-bs-target="#postularseModal" data-vacante="{{ $slug }}">Postularse</button>
                </div>
            </div>
            @endforeach
            <!-- Contenedor del texto "RESULTS IN PERFORMANCE" -->
            <div class="text-pane">
                <div class="vertical-text">
                    RESULTS IN PERFORMANCE
                </div>
            </div>
        </div>














        <!-- ============================================================== -->
        <!-- MODAL -->
        <!-- ============================================================== -->

        <div class="modal fade" id="postularseModal" tabindex="-1" aria-labelledby="postularseModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" enctype="multipart/form-data" id="formularioPostularse" style="background-color: #ffffff;">
                        {!! csrf_field() !!}
                        <div class="modal-header">
                            <h5 class="modal-title" id="postularseModalLabel">Nota Importante</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Para postularse asegúrese de estar registrado en el banco de CV. <br></p>
                        </div>
                        <div class="modal-footer modal-footer-center">
                            <button type="button" class="btn btn-danger" id="notRegisteredBtn">No estoy registrado</button>
                            <button type="button" class="btn btn-warning" id="actualizarinfo">Actualizar información y postularse a la vacante</button>
                            <button type="button" class="btn btn-success" id="registeredBtn">Sí estoy registrado</button>
                        </div>
                        <div class="modal-body" id="curpInputContainer" style="display:none;">
                            <h6 class="text-center mb-4">Proceso de Postulación</h6>
                            <div class="mb-3">
                                <label for="curpInput">Escribe tu CURP para continuar con tu postulación:</label>
                                <input type="text" id="curpInput" name="CURP" class="form-control" placeholder="Escribe tu CURP aquí">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success" id="guardarFormpostularse" style="display:none;">Postularse</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>







        <!-- ============================================================== -->
        <!-- MODAL ACTULIZAR INFORMACION -->
        <!-- ============================================================== -->


        <div class="modal modal-fullscreen fade" id="miModal_ACTUALIZARINFO" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="post" enctype="multipart/form-data" id="formularioACTUALIZARINFO" style="background-color: #ffffff;">
                        <div class="modal-header">
                            <h5 class="modal-title" id="miModalLabel">Actualizar Información</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            {!! csrf_field() !!}


                            <div class="mb-3">
                                <div class="form-group">
                                    <label>Confirme su curp o número de pasaporte :</label>
                                    <input type="text" class="form-control" id="CURPS_INFO" name="CURPS_INFO" required>

                                </div>
                            </div>
                            <div class="mb-3">
                                <label>Nombre(s)</label>
                                <input type="text" class="form-control" id="NOMBRE_CV" name="NOMBRE_CV" required>
                            </div>
                            <div class="mb-3">
                                <label>Primero Apellido </label>
                                <input type="text" class="form-control" id="PRIMER_APELLIDO_CV" name="PRIMER_APELLIDO_CV" required>
                            </div>
                            <div class="mb-3">
                                <label>Segundo Apellido </label>
                                <input type="text" class="form-control" id="SEGUNDO_APELLIDO_CV" name="SEGUNDO_APELLIDO_CV" required>
                            </div>

                            <div class="mb-3">
                                <label>Correo</label>
                                <input type="text" class="form-control" id="CORREO_CV" name="CORREO_CV" required>
                            </div>



                            <div class="mb-3 d-flex align-items-center">
                                <div class="col-2">
                                    <label>Etiqueta</label>
                                    <select class="form-select" id="ETIQUETA_TELEFONO1" name="ETIQUETA_TELEFONO1" required>
                                        <option value="0" selected disabled></option>
                                        <option value="Móvil">Móvil</option>
                                        <option value="Trabajo">Trabajo</option>
                                        <option value="Principal">Principal</option>
                                        <option value="Casa">Casa</option>
                                    </select>
                                </div>
                                <div class="col-10 mx-2">
                                    <label for="NUMERO1_CV" class="me-2">Teléfono 1</label>
                                    <input type="number" class="form-control col-auto" id="TELEFONO1" name="TELEFONO1" required>
                                </div>
                            </div>
                            <div class="mb-3 d-flex align-items-center">

                                <div class="col-2">
                                    <label>Etiqueta</label>
                                    <select class="form-select" id="ETIQUETA_TELEFONO2" name="ETIQUETA_TELEFONO2">
                                        <option value="0" selected disabled></option>
                                        <option value="Móvil">Móvil</option>
                                        <option value="Trabajo">Trabajo</option>
                                        <option value="Principal">Principal</option>
                                        <option value="Casa">Casa</option>
                                    </select>
                                </div>
                                <div class="col-10 mx-2">
                                    <label for="NUMERO1_CV" class="me-2">Teléfono 2 (opcional)</label>
                                    <input type="number" class="form-control col-auto" id="TELEFONO2" name="TELEFONO2">
                                </div>
                            </div>


                            <div class="mb-3">
                                <label>Nacionalidad</label>
                                <select class="form-control" id="NACIONALIDAD" name="NACIONALIDAD" required>
                                    <option value="0" selected disabled></option>
                                    <option value="1">Mexicana</option>
                                    <option value="2">Extranjera</option>
                                </select>
                            </div>


                            <div class="mb-3" id="campo-pasaporte" style="display: none;">
                                <label>Número de pasaporte</label>
                                <input type="text" class="form-control" id="ID_PASAPORTE" name="TEMP_PASAPORTE">
                            </div>

                            <div class="mb-3" id="campo-curp" style="display: none;">
                                <label>CURP</label>
                                <input type="text" class="form-control" id="CURP_CV" name="TEMP_CURP" maxlength="18">
                                <div id="contador" class="text-end">0/18</div>
                                <div id="mensaje"></div>
                                <div id="error"></div>
                            </div>


                            <div class="mb-3">
                                <label>Género</label>
                                <select class="form-control" id="GENERO" name="GENERO" required>
                                    <option selected disabled>Seleccione una opción</option>
                                    @foreach ($generos as $genero)
                                    <option value="{{ $genero->ID_CATALOGO_GENERO }}">{{ $genero->NOMBRE_GENERO }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Fecha de nacimiento</label>
                                <div class="d-flex justify-content-between">
                                    <select class="form-select me-2" id="dia" name="DIA_FECHA_CV" required>
                                        <option value="" selected disabled>Día</option>
                                        <!-- Genera los días del 1 al 31 -->
                                        <script>
                                            for (let i = 1; i <= 31; i++) {
                                                document.write('<option value="' + i + '">' + i + '</option>');
                                            }
                                        </script>
                                    </select>
                                    <select class="form-select me-2" id="mes" name="MES_FECHA_CV" required>
                                        <option value="" selected disabled>Mes</option>
                                        <option value="1">Enero</option>
                                        <option value="2">Febrero</option>
                                        <option value="3">Marzo</option>
                                        <option value="4">Abril</option>
                                        <option value="5">Mayo</option>
                                        <option value="6">Junio</option>
                                        <option value="7">Julio</option>
                                        <option value="8">Agosto</option>
                                        <option value="9">Septiembre</option>
                                        <option value="10">Octubre</option>
                                        <option value="11">Noviembre</option>
                                        <option value="12">Diciembre</option>
                                    </select>
                                    <select class="form-select" id="ano" name="ANIO_FECHA_CV" id="ANIO_FECHA_CV" required>
                                        <option value="" selected disabled>Año</option>
                                        <!-- Genera los años desde 1900 hasta el año actual -->
                                        <script>
                                            const currentYear = new Date().getFullYear();
                                            for (let i = currentYear; i >= 1900; i--) {
                                                document.write('<option value="' + i + '">' + i + '</option>');
                                            }
                                        </script>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="mb-3">
                                <labe class="text-center">Último grado académico cursado y terminado satisfactoriamente</labe>
                            </div>
                            <div class="mb-3">
                                <select class="form-select" id="ULTIMO_GRADO_CV" name="ULTIMO_GRADO_CV" required>
                                    <option value="0" selected disabled>Seleccione una opción</option>
                                    <option value="1">Primaria</option>
                                    <option value="2">Secundaria</option>
                                    <option value="3">Preparatoria</option>
                                    <option value="4">Licenciatura</option>
                                    <option value="5">Posgrado</option>
                                </select>
                            </div>
                            <div class="mb-3" id="licenciatura-nombre-container" style="display: none;">
                                <label>Nombre de la licenciatura</label>
                                <input type="text" class="form-control" id="NOMBRE_LICENCIATURA_CV" name="NOMBRE_LICENCIATURA_CV">
                            </div>
                            <div class="mb-3" id="licenciatura-titulo-container" style="display: none;">
                                <label class="col-form-label">¿Cuenta con Título?</label>
                                <div class="d-flex">
                                    <div class="form-check me-3">
                                        <label class="form-check-label" for="si">Si</label>
                                        <input class="form-check-input" type="radio" name="CUENTA_TITULO_LICENCIATURA_CV" id="si" value="Si">
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label" for="no">No</label>
                                        <input class="form-check-input" type="radio" name="CUENTA_TITULO_LICENCIATURA_CV" id="no" value="NO">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3" id="licenciatura-cedula-container" style="display: none;">
                                <label class="col-form-label">¿Cuenta con cédula profesional?</label>
                                <div class="d-flex">
                                    <div class="form-check me-3">
                                        <label class="form-check-label" for="si">Si</label>
                                        <input class="form-check-input" type="radio" name="CEDULA_TITULO_LICENCIATURA_CV" id="si" value="Si">
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label" for="no">No</label>
                                        <input class="form-check-input" type="radio" name="CEDULA_TITULO_LICENCIATURA_CV" id="no" value="NO">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3" id="posgrado-container" style="display: none;">
                                <label>Tipo de posgrado</label>
                                <select class="form-select" id="TIPO_POSGRADO_CV" name="TIPO_POSGRADO_CV">
                                    <option value="0" selected disabled>Seleccione una opción</option>
                                    <option value="1">Especialidad</option>
                                    <option value="2">Maestría</option>
                                    <option value="3">Doctorado</option>
                                    <option value="4">Post Doctorado</option>
                                </select>
                                <div class="mt-3" id="posgrado-nombre-container" style="display: none;">
                                    <label>Nombre del posgrado</label>
                                    <input type="text" class="form-control" id="NOMBRE_POSGRADO_CV" name="NOMBRE_POSGRADO_CV">
                                </div>
                                <div class="mb-3" id="posgrado-titulo-container" style="display: none;">
                                    <label class="col-form-label">¿Cuenta con Título?</label>
                                    <div class="d-flex">
                                        <div class="form-check me-3">
                                            <label class="form-check-label" for="titulo-posgrado-si">Si</label>
                                            <input class="form-check-input" type="radio" name="CUENTA_TITULO_POSGRADO_CV" id="titulo-posgrado-si" value="Si">
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label" for="titulo-posgrado-no">No</label>
                                            <input class="form-check-input" type="radio" name="CUENTA_TITULO_POSGRADO_CV" id="titulo-posgrado-no" value="No">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3" id="posgrado-cedula-container" style="display: none;">
                                    <label class="col-form-label">¿Cuenta con cédula profesional?</label>
                                    <div class="d-flex">
                                        <div class="form-check me-3">
                                            <label class="form-check-label" for="cedula-posgrado-si">Si</label>
                                            <input class="form-check-input" type="radio" name="CEDULA_TITULO_POSGRADO_CV" id="cedula-posgrado-si" value="Si">
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label" for="cedula-posgrado-no">No</label>
                                            <input class="form-check-input" type="radio" name="CEDULA_TITULO_POSGRADO_CV" id="cedula-posgrado-no" value="No">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 text-center">
                                <label class="mt-4"> Áreas de interés</label>
                            </div>

                            <div class="mb-3 d-flex">
                                <div class="col-6 me-1 text-center">
                                    <label>Administrativas</label>
                                    <select class="form-select" id="INTERES_ADMINISTRATIVA" name="INTERES_ADMINISTRATIVA[]" multiple>
                                        <option selected disabled></option>
                                        @foreach ($administrativas as $administrativa)
                                        <option value="{{ $administrativa->ID_CATALOGO_AREAINTERES }}">{{ $administrativa->NOMBRE_AREA }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6 text-center">
                                    <label>Operativas</label>
                                    <select class="form-select" id="INTERES_OPERATIVAS" name="INTERES_OPERATIVAS[]" multiple>
                                        <option selected disabled></option>

                                        @foreach ($operativas as $operativa)
                                        <option value="{{ $operativa->ID_CATALOGO_AREAINTERES }}">{{ $operativa->NOMBRE_AREA }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 text-center">
                                <label class="mt-4">Documentos</label>
                            </div>
                            <div class="mb-3">
                                <label class="mt-4"><b>Cargar archivos en PDF (Máximo 2&nbsp;MB)</b></label>
                            </div>
                            <div class="mb-3 d-flex align-items-center">
                                <label id="label-archivo">CURP. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                <input type="file" class="form-control" id="ARCHIVO_CURP_CV" name="ARCHIVO_CURP_CV" accept=".pdf" style="width: auto; flex: 1;">
                                <button type="button" class="btn btn-light btn-sm ms-2" id="quitarCURP" style="display:none;">Quitar archivo</button>
                            </div>
                            <div id="CURP_ERROR" class="text-danger" style="display:none;">Por favor, sube un archivo PDF</div>


                            <div class="mb-3 d-flex align-items-center">
                                <label>CV. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                <input type="file" class="form-control" id="ARCHIVO_CV" name="ARCHIVO_CV" accept=".pdf" style="width: auto; flex: 1;">
                                <button type="button" class="btn btn-light btn-sm ms-2" id="quitarCV" style="display:none;">Quitar archivo</button>
                            </div>
                            <div id="CV_ERROR" class="text-danger" style="display:none;">Por favor, sube un archivo PDF</div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-success" id="guardarFormActualizar">Guardar</button>
                            </div>

                    </form>


                </div>
            </div>

            </form>
        </div>
    </div>
    </div>



    <!-- ============================================================== -->
    <!-- SCRIPT -->
    <!-- ============================================================== -->


    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.2.0/js/bootstrap.bundle.min.js"></script>
    <!-- Jquery 3.6.4-->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!--Bootstrap -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>
    <!-- Datatables 1.13.1  v.5.2 -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Animación -->
    <script src="https://cdn.jsdelivr.net/gh/loadingio/ldcover/dist/index.min.js"></script>
    <!-- Select opcion selectize -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>

    <!-- Funciones generales -->
    <script src="/assets/js_sitio/funciones.js?v=5.0"></script>
    <script src="/assets/js_sitio/reclutamiento/vacantesexterna.js?v=2.0"></script>

    <!-- ============================================================== -->
    <!-- SCRIPT -->
    <!-- ============================================================== -->

</body>

</html>