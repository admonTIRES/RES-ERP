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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropify@0.2.2/dist/css/dropify.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker.min.css"> <!--Archivo css -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">


    <!-- Select 2 -->

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="assets/css/estilos.css">

    <style>
        .dropdown-menu {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .dropdown-item {
            text-align: center;
        }

        .dropdown-item button {
            border: none;
            background: none;
            width: 100%;
            text-align: center;
            padding: 8px;
        }

        .dropdown-item button:hover {
            background-color: #f8f9fa;
        }

        .dropdown-item span.badge {
            font-size: 0.85rem;
        }
    </style>


</head>

<body class="body">



    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #A4D65E; height: 100px;">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <img src="/assets/images/logoBlanco.png" class="ld ld-wander-h m-2" style="animation-duration:3.0s; width: 170px;" alt="Logo">
            </a>
            <div class="d-flex justify-content-center align-items-center w-100" style="position: absolute; top: 0; left: 0; height: 100px;">
                <h1 class="text-white m-0" style="color:#ffff;font-weight: bold;">Solicitudes ofertas y contratos</h1>
            </div>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav1">
                <ul class="navbar-nav d-flex align-items-center" style="gap: 10px;">
                    <li class="nav-item d-flex align-items-center">
                        <div class="notification-wrapper">
                            <button class="nav__iconButton" id="btnNotificaciones">
                                <img src="assets/Modulos/img/notificacion.png" alt="Notificación">
                                <span id="contadorNotificaciones" class="notification-count">0</span>
                            </button>

                            <div class="notification-panel" id="panelNotificaciones">
                                <div class="notification-header">
                                    <h4>Notificaciones</h4>
                                </div>
                                <div class="notification-body">
                                    <p class="notification-item">📌 No tienes notificaciones por el momento.</p>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown d-flex align-items-center">
                        @auth
                        <a class="nav__iconButton dropdown-toggle" href="#" id="navbarDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-fill" style="font-size: 22px; color:#555;"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" style="min-width: 250px;">
                            <li class="dropdown-item text-center">
                                <strong>{{ Auth::user()->EMPLEADO_NOMBRE }}
                                    {{ Auth::user()->EMPLEADO_APELLIDOPATERNO }}
                                    {{ Auth::user()->EMPLEADO_APELLIDOMATERNO }}</strong>
                                <br>
                                <small>{{ Auth::user()->EMPLEADO_CORREO }}</small>
                            </li>
                            <li class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-center" style="color: red;">
                                        <i class="bi bi-power"></i> Cerrar sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                        @endauth
                    </li>
                </ul>
            </div>


            <style>
                .nav__iconButton {
                    width: 40px;
                    height: 40px;
                    background: white;
                    border-radius: 50%;
                    border: none;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    padding: 0;
                    cursor: pointer;
                    position: relative;
                    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
                }

                .nav__iconButton img {
                    width: 22px;
                    height: 22px;
                    object-fit: contain;
                    opacity: .7;
                }

                .dropdown-toggle::after {
                    display: none !important;
                }

                .navbar-nav {
                    gap: 10px !important;
                }


                .notification-wrapper {
                    position: relative;
                    display: inline-block;
                }

                .notification-panel {
                    position: absolute;
                    top: 49px;
                    right: 0;
                    width: 350px;
                    background: #ffffff;
                    border-radius: 10px;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                    display: none;
                    z-index: 999;
                    overflow: hidden;
                }

                .notification-count {
                    position: absolute;
                    top: -5px;
                    right: -5px;
                    background: red;
                    color: white;
                    font-size: 12px;
                    font-weight: bold;
                    padding: 3px 6px;
                    border-radius: 50%;
                    display: none;
                    z-index: 9999;
                }



                .notification-header {
                    background: #a2a2a2 !important;
                    padding: 8px 12px !important;
                    border-bottom: 1px solid #ddd !important;
                    height: 42px;
                    display: flex;
                    align-items: center;
                }

                .notification-header h4 {
                    font-size: 16px !important;
                    font-weight: 800 !important;
                    /* más grueso */
                    color: #333 !important;
                    margin: 0 !important;
                    padding: 0 !important;
                    line-height: 1 !important;
                }



                .notification-body {
                    max-height: 250px;
                    overflow-y: auto;
                }

                .notification-item {
                    padding: 12px;
                    border-bottom: 1px solid #eee;
                    font-size: 13px;
                    color: #444;
                    line-height: 1.2;
                }

                .notification-item:last-child {
                    border-bottom: none;
                }

                .notification-item:hover {
                    background: #f0f0f0;
                    cursor: pointer;
                }


                .notification-item strong,
                .notification-item b {
                    font-size: 14px !important;
                    font-weight: 800 !important;
                    color: #111 !important;
                    line-height: 1.1 !important;
                    display: block;
                    margin-bottom: 3px;
                }
            </style>



        </div>
    </nav>



    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: rgba(0, 124, 186, 0.850); -webkit-box-shadow: 3px 29px 29px -15px rgba(0,0,0,0.75); -moz-box-shadow: 3px 29px 29px -15px rgba(0,0,0,0.75); box-shadow: 3px 29px 29px -15px rgba(0,0,0,0.75);">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown" style="margin-left: -2px;">
                        <a class="nav-link BOTON" href="{{ url('/modulos') }}" style="color: #fff; font-weight: bold; text-decoration: none; ">
                            <i class="bi bi-grid-3x3-gap-fill" style="margin-right: 5px;"></i> <span class="d-lg-none">Inicio</span><span class="d-none d-lg-inline">Inicio</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown" style="margin-left: -2px;">
                        <a class="nav-link BOTON" href="{{ url('/clientes') }}" style="color: #fff; font-weight: bold; text-decoration: none; ">
                            <i class="bi bi-person-lines-fill" style="margin-right: 5px;"></i> <span class="d-lg-none">Clientes</span><span class="d-none d-lg-inline">Clientes</span>
                        </a>
                    </li>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown" style="margin-left: -2px;">
                            <a class="nav-link dropdown-toggle BOTON" href="#"
                                style="color: #fff; font-weight: bold; text-decoration: none;"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-pencil-fill" style="margin-right: 5px;"></i>
                                <span class="d-lg-none">Solicitudes</span>
                                <span class="d-none d-lg-inline">Solicitudes</span>
                            </a>
                            <ul class="dropdown-menu">

                                <li>
                                    <a class="dropdown-item" href="{{ url('/solicitudes') }}">
                                        Actual
                                    </a>
                                </li>
                                <hr class="dropdown-divider">
                                <li>
                                    <a class="dropdown-item" href="{{ url('/solicitudeshistorial') }}">
                                        Historial
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>

                    <ul class="navbar-nav">
                        <li class="nav-item dropdown" style="margin-left: -2px;">
                            <a class="nav-link dropdown-toggle BOTON" href="#"
                                style="color: #fff; font-weight: bold; text-decoration: none;"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-currency-dollar" style="margin-right: 5px;"></i>
                                <span class="d-lg-none">Ofertas/Cotizaciones</span>
                                <span class="d-none d-lg-inline">Ofertas/Cotizaciones</span>
                            </a>
                            <ul class="dropdown-menu">

                                <li>
                                    <a class="dropdown-item" href="{{ url('/ofertas') }}">
                                        Actual
                                    </a>
                                </li>
                                <hr class="dropdown-divider">
                                <li>
                                    <a class="dropdown-item" href="{{ url('/ofertashistorial') }}">
                                        Historial
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>

                    <ul class="navbar-nav">
                        <li class="nav-item dropdown" style="margin-left: -2px;">
                            <a class="nav-link dropdown-toggle BOTON" href="#"
                                style="color: #fff; font-weight: bold; text-decoration: none;"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-patch-check-fill" style="margin-right: 5px;"></i>
                                <span class="d-lg-none">Confirmación del servicio </span>
                                <span class="d-none d-lg-inline">Confirmación del servicio </span>
                            </a>
                            <ul class="dropdown-menu">

                                <li>
                                    <a class="dropdown-item" href="{{ url('/confirmacion') }}">
                                        Actual
                                    </a>
                                </li>
                                <hr class="dropdown-divider">
                                <li>
                                    <a class="dropdown-item" href="{{ url('/confirmacionhistorial') }}">
                                        Historial
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>

                    <ul class="navbar-nav">
                        <li class="nav-item dropdown" style="margin-left: -2px;">
                            <a class="nav-link dropdown-toggle BOTON" href="#"
                                style="color: #fff; font-weight: bold; text-decoration: none;"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-patch-check-fill" style="margin-right: 5px;"></i>
                                <span class="d-lg-none">Orden de trabajo - OT</span>
                                <span class="d-none d-lg-inline">Orden de trabajo - OT</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ url('/ordentrabajo') }}">
                                        Actual
                                    </a>
                                </li>
                                <hr class="dropdown-divider">
                                <li>
                                    <a class="dropdown-item" href="{{ url('/ordentrabajohistorial') }}">
                                        Historial
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>

                    <li class="nav-item dropdown" style="margin-left: -2px;">
                        <a class="nav-link BOTON" href="#" style="color: #fff; font-weight: bold; text-decoration: none; ">
                            <i class="bi bi-aspect-ratio-fill" style="margin-right: 5px;"></i> <span class="d-lg-none">General </span><span class="d-none d-lg-inline">General </span>
                        </a>
                    </li>
                    <li class="nav-item dropdown" style="margin-left: -2px;">
                        <a class="nav-link BOTON" href="#" style="color: #fff; font-weight: bold; text-decoration: none; ">
                            <i class="" style="margin-right: 5px;"></i> <span class="d-lg-none">Indicadores </span><span class="d-none d-lg-inline">Indicadores </span>
                        </a>
                    </li>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown" style="margin-left: -2px;">
                            <a class="nav-link dropdown-toggle BOTON" href="#" style="color: #fff; font-weight: bold; text-decoration: none;" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-file-earmark-fill" style="margin-right: 5px;"></i>
                                <span class="d-lg-none">Catálogos</span>
                                <span class="d-none d-lg-inline">Catálogos</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{url('/catalogosolicitudes')}}">Catálogos de solicitudes</a>
                                </li>
                                <hr class="dropdown-divider">
                                <li><a class="dropdown-item" href="{{url('/catalogoconfirmacion')}}">Catálogos de confirmación</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </ul>
            </div>
        </div>
    </nav>


    @if(session('error'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: 'error',
                title: 'Acceso Denegado',
                text: 'No tienes acceso a este módulo.',
                confirmButtonText: 'Entendido',
                background: '#f8d7da', // Fondo rojo claro
                customClass: {
                    popup: 'swal-wide' // Clase personalizada para ampliar la alerta
                }
            });

        });
    </script>
    @endif


    <!-- Modal de carga -->
    <style>
        #modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Ajusta la opacidad aquí */
            z-index: 999;
            display: none;
            /* Empieza oculto */
        }

        #loading-image {
            position: absolute;
            top: 40%;
            left: 28%;
        }
    </style>
    <div id="modal-overlay">
        <img src="/assets/images/Colorancho.png" class="ld ld-bounce" alt="Cargando" style="max-width: 100%; max-height: 214px;" id="loading-image">
    </div>


    <div style="margin-top: 25px;">
        @yield('contenido')
    </div>



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
    <!-- datepicker -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/locales/bootstrap-datepicker.es.min.js"></script>
    <!-- Dropify -->
    <script src="https://cdn.jsdelivr.net/npm/dropify@0.2.2/dist/js/dropify.min.js"></script>
    <!-- Funciones generales -->
    <script src="/assets/js_sitio/funciones.js?v=8"></script>
    <script src="/assets/js_sitio/notificaciones.js?v=1.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

    <!-- Select 2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script>
        $(document).ready(function() {
            // Inicializar campos datepicker con opciones en español
            $('.mydatepicker').datepicker({
                format: 'yyyy-mm-dd', // Formato de fecha
                weekStart: 1, // Día que inicia la semana, 1 = Lunes
                autoclose: true, // Cierra automáticamente el calendario
                todayHighlight: true, // Marca el día de hoy en el calendario
                language: 'es' // Configura el idioma en español
            });

            // Mostrar la fecha seleccionada en el input
            $('.mydatepicker').on('click', function() {
                $(this).datepicker('setDate', $(this).val()); // Mostrar fecha del input y marcar en el calendario
            });
        });
    </script>




    @if(request()->is('clientes'))
    <script src="/assets/js_sitio/clientes/clientes.js?v=10"></script>
    @endif

    @if(request()->is('solicitudes'))
    <script src="/assets/js_sitio/solicitudes/solicitudes.js?v=6"></script>
    @endif

    @if(request()->is('ofertas'))
    <script src="/assets/js_sitio/ofertas/ofertas.js?v=6"></script>
    @endif

    @if(request()->is('confirmacion'))
    <script src="/assets/js_sitio/confirmacion/confirmacion.js?v=4"></script>
    @endif

    @if(request()->is('catalogomediocontacto'))
    <script src="/assets/js_sitio/solicitudes/catalogos/catalogomotivo.js?v=1.0"></script>
    @endif

    @if(request()->is('catalogogiroempresa'))
    <script src="/assets/js_sitio/solicitudes/catalogos/catalogogiroempresa.js?v=1.0"></script>
    @endif

    @if(request()->is('catalogonecesidadservicio'))
    <script src="/assets/js_sitio/solicitudes/catalogos/catalogonecesidadservicio.js?v=1.0"></script>
    @endif

    @if(request()->is('ordentrabajo'))
    <script src="/assets/js_sitio/orden_trabajo/orden_trabajo.js?v=2"></script>
    @endif

    @if(request()->is('catalogolineanegocio'))
    <script src="/assets/js_sitio/solicitudes/catalogos/catalogolinea.js?v=1.0"></script>
    @endif

    @if(request()->is('catalogotiposervicio'))
    <script src="/assets/js_sitio/solicitudes/catalogos/catalogotiposervicio.js?v=1.0"></script>
    @endif

    @if(request()->is('catalogoverificacion'))
    <script src="/assets/js_sitio/solicitudes/catalogos/catalogoverificacioninformacion.js?v=1.0"></script>
    @endif

    @if(request()->is('catalogoclientestitulos'))
    <script src="/assets/js_sitio/solicitudes/catalogos/catalogotitulosclientes.js"></script>
    @endif

    @if(request()->is('solicitudeshistorial'))
    <script src="/assets/js_sitio/solicitudes/solictudeshistorial.js?v=3.0"></script>
    @endif

    @if(request()->is('ofertashistorial'))
    <script src="/assets/js_sitio/ofertas/ofertashistorial.js"></script>
    @endif

    @if(request()->is('confirmacionhistorial'))
    <script src="/assets/js_sitio/confirmacion/confirmacionhistorial.js"></script>
    @endif

    @if(request()->is('ordentrabajohistorial'))
    <script src="/assets/js_sitio/orden_trabajo/orden_trabajohistorial.js?v=2.0"></script>
    @endif


    <script src="/assets/js_sitio/externo.js?v=1.0"></script>

</body>

</body>

</html>