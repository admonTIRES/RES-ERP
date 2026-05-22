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

    @if(request()->is('listaproveedores'))
    <!-- form_wizard_steps -->
    <link href="/assets/plugins/form_wizard_steps_bootstrap/form_wizard_style.css" rel="stylesheet">
    </link>
    @endif

    @if(request()->is('listaproveedorescriticos'))
    <!-- form_wizard_steps -->
    <link href="/assets/plugins/form_wizard_steps_bootstrap/form_wizard_style.css" rel="stylesheet">
    </link>
    @endif



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

        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu>.dropdown-menu {
            top: 0;
            left: 100%;
            margin-left: .1rem;
            display: none;
        }

        .dropdown-submenu:hover>.dropdown-menu {
            display: block;
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
                <h1 class="text-white m-0" style="color:#ffff;font-weight: bold;">Compras</h1>
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
                    <li class="nav-item dropdown" style="margin-left: -10px;">
                        <a class="nav-link BOTON" href="{{ url('/modulos') }}" style="color: #fff; font-weight: bold; text-decoration: none; ">
                            <i class="bi bi-grid-3x3-gap-fill" style="margin-right: 1px;"></i> <span class="d-lg-none">Inicio</span><span class="d-none d-lg-inline">Inicio</span>
                        </a>
                    </li>
                    <ul class="navbar-nav">
                        @if(auth()->check() && !auth()->user()->hasRoles(['Almacenista','Asistente de compras']))
                        <li class="nav-item dropdown" style="margin-left: -10px;">
                            <a class="nav-link dropdown-toggle BOTON" href="#"
                                style="color: #fff; font-weight: bold; text-decoration: none;"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-file-earmark-fill" style="margin-right: 1px;"></i>
                                <span class="d-lg-none">Requisición de Materiales - M.R</span>
                                <span class="d-none d-lg-inline">Requisición de Materiales - M.R</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ url('/requisicionmateriales') }}">
                                        Requisición de Materiales - M.R </a>
                                </li>
                                @endif
                                @if(auth()->user()->hasRoles(['Superusuario','Líder RRHH y Administración','Líder contable y financiero','Líder de Operaciones','externo']))
                                <hr class="dropdown-divider">
                                <li>
                                    <a class="dropdown-item" href="{{ url('/requisicionmaterialeslideres') }}">
                                        M.R por dar Vo.Bo
                                    </a>
                                </li>
                                @endif
                                @if(auth()->user()->hasRoles(['Superusuario','Administrador','externo']))
                                <hr class="dropdown-divider">
                                <li>
                                    <a class="dropdown-item" href="{{ url('/requisicionmaterialesaprobacion') }}">
                                        M.R por aprobar
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @if(auth()->check() && auth()->user()->hasRoles(['Superusuario', 'Administrador','Asistente de compras','externo']))
                        <!-- <li class="nav-item dropdown" style="margin-left: -2px;">
                            <a class="nav-link BOTON" href="{{ url('/bitacora') }}" style="color: #fff; font-weight: bold; text-decoration: none; ">
                                <i class="bi bi-file-earmark-fill" style="margin-right: 5px;"></i> <span class="d-lg-none">Bitácora de consecutivos - MR</span><span class="d-none d-lg-inline">Bitácora de consecutivos - MR</span>
                            </a>
                        </li> -->


                        <ul class="navbar-nav">
                            <li class="nav-item dropdown" style="margin-left: -10px;">
                                <a class="nav-link dropdown-toggle BOTON" href="#" style="color: #fff; font-weight: bold; text-decoration: none;" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-file-earmark-fill" style="margin-right: 1px;"></i>
                                    <span class="d-lg-none">Bitácora de consecutivos - MR</span>
                                    <span class="d-none d-lg-inline">Bitácora de consecutivos - MR</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{url('/bitacora')}}">Actual</a>
                                    </li>
                                    <hr class="dropdown-divider">
                                    <li><a class="dropdown-item" href="{{url('/bitacoramrhistorial')}}">Historial </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>


                        @endif

                        @if(auth()->check() && auth()->user()->hasRoles(['Superusuario', 'Administrador','Asistente de planeación y logística','Asistente de compras','externo']))
                        <li class="nav-item dropdown" style="margin-left: -10px;">
                            <a class="nav-link dropdown-toggle BOTON" href="#"
                                style="color: #fff; font-weight: bold; text-decoration: none;"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-lines-fill" style="margin-right: 1px;"></i>
                                <span class="d-lg-none">Proveedores</span>
                                <span class="d-none d-lg-inline">Proveedores</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ url('/bancoproveedores') }}">
                                        Banco de proveedores
                                    </a>
                                </li>
                                <hr class="dropdown-divider">
                                <li>
                                    <a class="dropdown-item" href="{{ url('/listaproveedores') }}">
                                        Proveedores
                                    </a>
                                </li>
                                <hr class="dropdown-divider">
                                <li>
                                    <a class="dropdown-item" href="{{ url('/proveedorestemporales') }}">
                                        Proveedores temporales
                                    </a>
                                </li>
                                <hr class="dropdown-divider">
                                <li>
                                    <a class="dropdown-item" href="{{ url('/listaproveedorescriticos') }}">
                                        Proveedores críticos
                                    </a>
                                </li>
                                @if(auth()->user()->hasRoles(['Superusuario','Administrador','externo','Asistente de planeación y logística']))
                                <hr class="dropdown-divider">
                                <li>
                                    <a class="dropdown-item" href="{{ url('/listacontratosproveedores') }}">
                                        Contratos
                                    </a>
                                </li>
                                @endif
                                <hr class="dropdown-divider">
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" href="#">
                                        Actualización de documentos
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ url('/actualizaciondocumentosproveedor') }}">
                                                Vo.Bo
                                            </a>
                                        </li>

                                        <hr class="dropdown-divider">
                                        <li>
                                            <a class="dropdown-item" href="{{ url('/aprobardocumentosproveedor') }}">
                                                Aprobación
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        @endif

                        @if(auth()->check() && auth()->user()->hasRoles(['Superusuario', 'Administrador','Asistente de planeación y logística','Asistente de compras','externo']))
                        <li class="nav-item dropdown" style="margin-left: -10px;">
                            <a class="nav-link dropdown-toggle BOTON" href="#"
                                style="color: #fff; font-weight: bold; text-decoration: none;"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-file-earmark-fill" style="margin-right: 1px;"></i>
                                <span class="d-lg-none">Facturación</span>
                                <span class="d-none d-lg-inline">Facturación</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ url('/listafacturas') }}">
                                        Recepción facturas
                                    </a>
                                </li>
                                <hr class="dropdown-divider">
                                <li>
                                    <a class="dropdown-item" href="{{ url('/relacionpagos') }}">
                                        Relación de pagos
                                    </a>
                                </li>
                                <hr class="dropdown-divider">
                                <li>
                                    <a class="dropdown-item" href="{{ url('/#') }}">
                                        Envió comprobante de pago
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif



                        @if(auth()->check() && auth()->user()->hasRoles(['Superusuario', 'Administrador','Asistente de compras','externo']))
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown" style="margin-left: -10px;">
                                <a class="nav-link dropdown-toggle BOTON" href="#"
                                    style="color: #fff; font-weight: bold; text-decoration: none;"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-file-earmark-fill" style="margin-right: 1px;"></i>
                                    <span class="d-lg-none">Matriz comparativa</span>
                                    <span class="d-none d-lg-inline">Matriz comparativa</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ url('/matrizcomparativa') }}">
                                            Matriz comparativa
                                        </a>
                                    </li>
                                    @if(auth()->user()->hasRoles(['Superusuario','Administrador','externo']))
                                    <hr class="dropdown-divider">
                                    <li>
                                        <a class="dropdown-item" href="{{ url('/matrizaprobacion') }}">
                                            Matriz comparativa por aprobar
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            </li>
                        </ul>
                        @endif
                        @if(auth()->check() && auth()->user()->hasRoles(['Superusuario', 'Administrador','Asistente de compras','externo']))
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown" style="margin-left: -10px;">
                                <a class="nav-link dropdown-toggle BOTON" href="#"
                                    style="color: #fff; font-weight: bold; text-decoration: none;"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-file-earmark-fill" style="margin-right: 1px;"></i>
                                    <span class="d-lg-none">Orden de compra - PO</span>
                                    <span class="d-none d-lg-inline">Orden de compra - PO</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ url('/ordencompra') }}">
                                            Actual
                                        </a>
                                    </li>
                                    <hr class="dropdown-divider">
                                    <li>
                                        <a class="dropdown-item" href="{{ url('/ordencomprahistorial') }}">
                                            Historial
                                        </a>
                                    </li>
                                    @if(auth()->user()->hasRoles(['Superusuario','Administrador','externo']))
                                    <hr class="dropdown-divider">
                                    <li>
                                        <a class="dropdown-item" href="{{ url('/ordencompraaprobacion') }}">
                                            Orden de compra por aprobar
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            </li>
                        </ul>
                        @endif
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown" style="margin-left: -10px;">
                                <a class="nav-link dropdown-toggle BOTON" href="#"
                                    style="color: #fff; font-weight: bold; text-decoration: none;"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-file-earmark-fill" style="margin-right: 1px;"></i>
                                    <span class="d-lg-none">Recepción de bienes y/o servicios - GR</span>
                                    <span class="d-none d-lg-inline">Recepción de bienes y/o servicios - GR</span>
                                </a>
                                <ul class="dropdown-menu">
                                    @if(auth()->check() && auth()->user()->hasRoles(['Superusuario','Administrador','Almacenista','externo']))
                                    <li>
                                        <a class="dropdown-item" href="{{ url('/bitacoragr') }}">
                                            Actual
                                        </a>
                                    </li>
                                    <hr class="dropdown-divider">
                                    <li>
                                        <a class="dropdown-item" href="{{ url('/bitacoragrhistorial') }}">
                                            Historial
                                        </a>
                                    </li>
                                    <hr class="dropdown-divider">

                                    @endif
                                    <li>
                                        <a class="dropdown-item" href="{{ url('/vobogrusuario') }}">
                                            Vo.Bo. de usuario de B.y.S
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        @if(auth()->check() && auth()->user()->hasRoles(['Superusuario', 'Administrador','Asistente de compras','externo']))
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown" style="margin-left: -10px;">
                                <a class="nav-link dropdown-toggle BOTON" href="#" style="color: #fff; font-weight: bold; text-decoration: none;" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-file-earmark-fill" style="margin-right: 1px;"></i>
                                    <span class="d-lg-none">Catálogos</span>
                                    <span class="d-none d-lg-inline">Catálogos</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{url('/catalogosproveedores')}}">Catálogos de proveedores</a>
                                    </li>

                                </ul>
                            </li>
                        </ul>
                        @endif
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
                background: '#f8d7da',
                customClass: {
                    popup: 'swal-wide'
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



    @if(request()->is('requisicionmateriales'))
    <script src="/assets/js_sitio/requisiconmaterial/requisicionmr.js?v=5"></script>
    @endif

    @if(request()->is('requisicionmaterialeslideres'))
    <script src="/assets/js_sitio/requisiconmaterial/requisiconlider.js?v=2.13"></script>
    @endif

    @if(request()->is('requisicionmaterialesaprobacion'))
    <script src="/assets/js_sitio/requisiconmaterial/requisiconaprobada.js?v=2.5"></script>
    @endif

    @if(request()->is('bitacora'))
    <script src="/assets/js_sitio/requisiconmaterial/bitacora.js?v=3"></script>
    @endif

    @if(request()->is('bitacoramrhistorial'))
    <script src="/assets/js_sitio/requisiconmaterial/bitacorahistorial.js?v=2"></script>
    @endif

    @if(request()->is('bancoproveedores'))
    <script src="/assets/js_sitio/proveedor/proveedorespotenciales.js?v=1.13"></script>
    @endif

    @if(request()->is('catalogofunciones'))
    <script src="/assets/js_sitio/proveedor/catalogos/catalogofunciones.js?v=1.0"></script>
    @endif

    @if(request()->is('catalogotitulos'))
    <script src="/assets/js_sitio/proveedor/catalogos/catalogotitulos.js?v=1.0"></script>
    @endif

    @if(request()->is('catalogodocumentosoporte'))
    <script src="/assets/js_sitio/proveedor/catalogos/catalogodocumento.js?v=1.3"></script>
    @endif

    @if(request()->is('listaproveedores'))
    <script src="/assets/js_sitio/proveedor/listaproveedor.js?v=31"></script>
    <script src="/assets/plugins/form_wizard_steps_bootstrap/form_wizard_script.js"></script>
    @endif

    @if(request()->is('proveedorestemporales'))
    <script src="/assets/js_sitio/proveedor/proveedorestemp.js?v=1.9"></script>
    @endif

    @if(request()->is('ordencompra'))
    <script src="/assets/js_sitio/orden_compra/orden_compra.js?v=3"></script>
    @endif

    @if(request()->is('ordencomprahistorial'))
    <script src="/assets/js_sitio/orden_compra/orden_comprahistorial.js?v=1.0"></script>
    @endif

    @if(request()->is('ordencompraaprobacion'))
    <script src="/assets/js_sitio/orden_compra/aprobacioncompra.js?v=1.7"></script>
    @endif

    @if(request()->is('matrizcomparativa'))
    <script src="/assets/js_sitio/matrizcomparativa/matrizcomparativa.js?v=1.5"></script>
    @endif

    @if(request()->is('matrizaprobacion'))
    <script src="/assets/js_sitio/matrizcomparativa/aprobacionmatriz.js?v=1.5"></script>
    @endif

    @if(request()->is('catalogoverificacionproveedor'))
    <script src="/assets/js_sitio/proveedor/catalogos/catalogoverproveedor.js"></script>
    @endif

    @if(request()->is('bitacoragr'))
    <script src="/assets/js_sitio/requisiciongr/requisiciongr.js?v=12"></script>
    @endif

    @if(request()->is('vobogrusuario'))
    <script src="/assets/js_sitio/requisiciongr/vobogrusuario.js?v=1.4"></script>
    @endif

    @if(request()->is('bitacoragrhistorial'))
    <script src="/assets/js_sitio/requisiciongr/requisiciongrhistorial.js?v=11"></script>
    @endif

    @if(request()->is('listaproveedorescriticos'))
    <script src="/assets/js_sitio/proveedor/listraproveedorcritico.js?v=15"></script>
    <script src="/assets/plugins/form_wizard_steps_bootstrap/form_wizard_script.js"></script>
    @endif

    @if(request()->is('actualizaciondocumentosproveedor'))
    <script src="/assets/js_sitio/proveedor/fechaactualizaciondoc.js?v=6"></script>
    @endif

    @if(request()->is('aprobardocumentosproveedor'))
    <script src="/assets/js_sitio/proveedor/aprobardocumentosproveedor.js?v=6"></script>
    @endif

    @if(request()->is('listacontratosproveedores'))
    <script src="/assets/js_sitio/proveedor/listacontratosproveedores.js"></script>
    @endif

    @if(request()->is('listafacturas'))
    <script src="/assets/js_sitio/proveedor/listafacturas.js?v=3"></script>
    @endif

    @if(request()->is('relacionpagos'))
    <script src="/assets/js_sitio/proveedor/relacionpago.js"></script>
    @endif




    <script src="/assets/js_sitio/externo.js?v=1.0"></script>

</body>

</body>

</html>