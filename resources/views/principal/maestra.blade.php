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
    <link rel="stylesheet" href="assets/css/organigrama.css">



    @if(request()->is('dpt'))
    <link rel="stylesheet" href="assets/css/dpt.css">
    @endif

    @if(request()->is('contratacion'))
    <!-- form_wizard_steps -->
    <link href="/assets/plugins/form_wizard_steps_bootstrap/form_wizard_style.css" rel="stylesheet">
    </link>
    @endif

    @if(request()->is('expediente'))
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
                <h1 class="text-white m-0" style="color:#ffff;font-weight: bold;">Recursos Humanos</h1>
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
                    @if(auth()->check() && auth()->user()->hasRoles(['Superusuario', 'Administrador','externo']))
                    <li class="nav-item dropdown" style="margin-left: -2px;">
                        <a class="nav-link BOTON" href="{{ url('/tablero') }}" style="color: #fff; font-weight: bold; text-decoration: none; ">
                            <i class="bi bi-speedometer" style="margin-right: 5px;"></i> <span class="d-lg-none">Tablero</span><span class="d-none d-lg-inline">Tablero</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown" style="margin-left: -2px;">
                        <a class="nav-link BOTON" href="{{ url('/informacionempresa') }}" style="color: #fff; font-weight: bold; text-decoration: none; ">
                            <i class="bi bi-file-earmark-fill" style="margin-right: 5px;"></i> <span class="d-lg-none">Información empresa</span><span class="d-none d-lg-inline">Información empresa</span>
                        </a>
                    </li>
                    @endif


                    @if(auth()->check() && auth()->user()->hasRoles([
                    'Superusuario',
                    'Administrador',
                    'Líder RRHH y Administración',
                    'Líder de Operaciones',
                    'Líder RRHH y Administración',
                    'Director',
                    'externo'
                    ]))
                    <li class="nav-item dropdown" style="margin-left: -2px;">
                        <a class="nav-link dropdown-toggle BOTON" href="#"
                            style="color: #fff; font-weight: bold; text-decoration: none;"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-diagram-3-fill" style="margin-right: 5px;"></i>
                            <span class="d-lg-none">Organización</span>
                            <span class="d-none d-lg-inline">Organización</span>
                        </a>

                        <ul class="dropdown-menu">

                            @if(auth()->user()->hasRoles(['Superusuario', 'Administrador','externo']))
                            <li><a class="dropdown-item" href="{{ url('/organigrama') }}">Organigrama</a></li>
                            <hr class="dropdown-divider">
                            @endif

                            @if(auth()->user()->hasRoles(['Superusuario', 'Administrador','externo']))
                            <li><a class="dropdown-item" href="{{ url('/ppt') }}">PPT</a></li>
                            <hr class="dropdown-divider">
                            @endif

                            @if(auth()->user()->hasRoles(['Superusuario', 'Administrador','externo']))
                            <li><a class="dropdown-item" href="{{ url('/dpt') }}">DPT</a></li>
                            <hr class="dropdown-divider">
                            @endif

                            <li class="dropdown-submenu">
                                <a class="dropdown-item dropdown-toggle" href="#">
                                    Requisición de personal
                                </a>

                                <ul class="dropdown-menu">

                                    @if(auth()->user()->hasRoles([
                                    'Superusuario',
                                    'Administrador',
                                    'Líder RRHH y Administración',
                                    'Líder de Operaciones',
                                    'Líder RRHH y Administración',
                                    'Director',
                                    'externo'
                                    ]))
                                    <li>
                                        <a class="dropdown-item" href="{{ url('/requisiciondepersonalsolicitud') }}">
                                            Solicitud
                                        </a>
                                    </li>
                                    @endif

                                    @if(auth()->user()->hasRoles(['Superusuario', 'Administrador','externo']))
                                    <hr class="dropdown-divider">
                                    <li>
                                        <a class="dropdown-item" href="{{ url('/requisiciondepersonal') }}">
                                            Autorización
                                        </a>
                                    </li>
                                    @endif

                                </ul>
                            </li>

                        </ul>
                    </li>
                    @endif
                    @if(auth()->check() && auth()->user()->hasRoles(['Superusuario','Administrador','externo']))
                    <li class="nav-item dropdown" style="margin-left: -2px;">
                        <a class="nav-link dropdown-toggle BOTON" href="#" style="color: #fff; font-weight: bold; text-decoration: none; " role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-lines-fill" style="margin-right: 5px;"></i> <span class="d-lg-none">Reclutamiento</span><span class="d-none d-lg-inline">Reclutamiento</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ url('/listavacantes') }}">Banco de CV</a></li>

                            <hr class="dropdown-divider">
                            <li><a class="dropdown-item" href="{{url('/postulaciones')}}">Vacantes Actual</a></li>
                            <hr class="dropdown-divider">
                            <li><a class="dropdown-item" href="{{url('/postulacioneshistorial')}}">Vacantes Historial</a></li>
                        </ul>
                    </li>
                    @endif
                    @if(auth()->check() && auth()->user()->hasRoles(['Superusuario','Administrador','externo']))
                    <li class="nav-item dropdown" style="margin-left: -2px;">
                        <a class="nav-link dropdown-toggle BOTON" href="#" style="color: #fff; font-weight: bold; text-decoration: none; " role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-badge-fill" style="margin-right: 5px;"></i> <span class="d-lg-none">Selección</span><span class="d-none d-lg-inline">Selección</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ url('/seleccion') }}">Actual</a></li>
                            <hr class="dropdown-divider">
                            <li><a class="dropdown-item" href="{{url('/visualizarseleccion')}}">Historial</a></li>
                            <hr class="dropdown-divider">
                            <li><a class="dropdown-item" href="{{url('/aprobarinteligencialaboral')}}">Aprobar inteligencia</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown" style="margin-left: -2px;">
                        <a class="nav-link dropdown-toggle BOTON" href="#" style="color: #fff; font-weight: bold; text-decoration: none; " role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-badge-fill" style="margin-right: 5px;"></i> <span class="d-lg-none">Contratación</span><span class="d-none d-lg-inline">Contratación</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ url('/pendientecontratar') }}">Pendientes por contratar</a></li>
                            <hr class="dropdown-divider">

                            <li><a class="dropdown-item" href="{{url('/contratacion')}}">Lista de colaboradores</a></li>

                            <hr class="dropdown-divider">
                            <li class="dropdown-submenu">
                                <a class="dropdown-item dropdown-toggle" href="#">
                                    Actualización de documentos
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ url('/actualizaciondocumentos') }}">
                                            Actual
                                        </a>
                                    </li>
                                    <hr class="dropdown-divider">
                                    <li>
                                        <a class="dropdown-item" href="{{ url('/actualizaciondocumentoshistorial') }}">
                                            Historial
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    @endif
                    <li class="nav-item dropdown" style="margin-left: -2px;">
                        <a class="nav-link dropdown-toggle BOTON" href="#"
                            style="color: #fff; font-weight: bold; text-decoration: none;"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-file-earmark-fill" style="margin-right: 5px;"></i>
                            <span class="d-lg-none">Rec.Empleados</span>
                            <span class="d-none d-lg-inline">Rec.Empleados</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ url('/recempleado') }}">
                                    Rec.Empleados </a>
                            </li>
                            <hr class="dropdown-divider">
                            <li>
                                <a class="dropdown-item" href="{{ url('/expediente') }}">
                                    Expediente </a>
                            </li>
                            {{-- Para líderes --}}
                            @if(auth()->user()->hasRoles(['Superusuario','Líder RRHH y Administración','Líder contable y financiero','Líder de Operaciones', 'Administrador','externo']))
                            <hr class="dropdown-divider">
                            <li>
                                <a class="dropdown-item" href="{{ url('/solicitudesvobo') }}">
                                    Solicitudes por dar Vo.Bo
                                </a>
                            </li>
                            @endif
                            {{-- Para administradores --}}
                            @if(auth()->user()->hasRoles(['Superusuario','Administrador','externo']))
                            <hr class="dropdown-divider">
                            <li>
                                <a class="dropdown-item" href="{{ url('/solicitudesaprobaciones') }}">
                                    Solicitudes por aprobar
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    @if(auth()->check() && auth()->user()->hasRoles(['Superusuario','Administrador','externo']))
                    <li class="nav-item dropdown" style="margin-left: -2px;">
                        <a class="nav-link dropdown-toggle BOTON" href="#" style="color: #fff; font-weight: bold; text-decoration: none; " role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-bounding-box" style="margin-right: 5px;"></i> <span class="d-lg-none">Capacitación</span><span class="d-none d-lg-inline">Capacitación</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ url('/brechacompetencia') }}">Brecha de competencia</a></li>
                            <hr class="dropdown-divider">
                            <li><a class="dropdown-item" href="{{url('/#')}}">Capacitación</a></li>
                        </ul>
                    </li>
                    @endif
                    {{-- <li class="nav-item dropdown" style="margin-left: 8px;">
                    <a class="nav-link BOTON" href="#" style="color: #fff; font-weight: bold; text-decoration: none; ">
                        <i class="bi bi-clipboard-data-fill" style="margin-right: 5px;"></i> <span class="d-lg-none">Eval.desempeño</span><span class="d-none d-lg-inline">Eval.desempeño</span>
                    </a>
                </li> --}}
                    @if(auth()->check() && auth()->user()->hasRoles(['Superusuario','Administrador','externo']))
                    <li class="nav-item dropdown" style="margin-left: -2px;">
                        <a class="nav-link BOTON" href="{{ url('/desvinculacion') }}" style="color: #fff; font-weight: bold; text-decoration: none; ">
                            <i class="bi bi-person-dash-fill" style="margin-right: 5px;"></i> <span class="d-lg-none">Desvinculación</span><span class="d-none d-lg-inline">Desvinculación</span>
                        </a>
                    </li>
                    @endif
                    @if(auth()->check() && auth()->user()->hasRoles(['Superusuario','Administrador','externo','Líder de Operaciones']))
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown" style="margin-left: 8px;">
                            <a class="nav-link dropdown-toggle BOTON" href="#" style="color: #fff; font-weight: bold; text-decoration: none;" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-file-earmark-fill" style="margin-right: 5px;"></i>
                                <span class="d-lg-none">Catálogos</span>
                                <span class="d-none d-lg-inline">Catálogos</span>
                            </a>
                            <ul class="dropdown-menu">
                                @if(auth()->user()->hasRoles(['Superusuario','Administrador','externo']))

                                <li><a class="dropdown-item" href="{{url('/catalogoppt')}}">Catálogos de PPT</a>
                                </li>
                                <hr class="dropdown-divider">
                                <li><a class="dropdown-item" href="{{url('/catalogodpt')}}">Catálogos de DPT</a>
                                </li>
                                <hr class="dropdown-divider">
                                <li><a class="dropdown-item" href="{{url('/catalogorequisicion')}}">Catálogos de Requisición</a>
                                </li>
                                <hr class="dropdown-divider">
                                <li><a class="dropdown-item" href="{{url('/catalogogenerales')}}">Catálogos generales</a>
                                </li>
                                @endif
                                @if(auth()->user()->hasRoles(['Superusuario','Administrador','externo','Líder de Operaciones']))
                                <hr class="dropdown-divider">
                                <li><a class="dropdown-item" href="{{url('/catalogoscapacitacion')}}">Catálogos capacitación</a>
                                </li>
                                @endif
                            </ul>
                        </li>
                    </ul>
                    @endif

                    @if(auth()->check() && auth()->user()->hasRoles(['Superusuario','Administrador']))
                    <li class="nav-item dropdown" style="margin-left: -2px;">
                        <a class="nav-link BOTON" href="{{ url('/usuario') }}" style="color: #fff; font-weight: bold; text-decoration: none; ">
                            <i class="bi bi-people-fill" style="margin-right: 5px;"></i> <span class="d-lg-none">Usuarios</span><span class="d-none d-lg-inline">Usuarios</span>
                        </a>
                    </li>
                    @endif
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


    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>


    @if(request()->is('informacionempresa'))
    <script src="/assets/js_sitio/informacionempresa/empresainformacion.js?v=1.0"></script>
    @endif

    @if(request()->is('organigrama'))
    <script src="/assets/js_sitio/organizacion/organigrama.js?v=6.0"> </script>
    <script src="/assets/js/GOJs/go.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    @endif

    @if(request()->is('ppt'))
    <script src="/assets/js_sitio/organizacion/PPT.js?v=3.2"></script>
    @endif

    @if(request()->is('dpt'))
    <script src="/assets/js_sitio/organizacion/DPT.js?v=6.0"></script>
    @endif

    @if(request()->is('jerarquico'))
    <script src="/assets/js_sitio/organizacion/catalogos/catalogos.js?v=1.0"></script>
    @endif

    @if(request()->is('asesores'))
    <script src="/assets/js_sitio/organizacion/catalogos/catalogoasesores.js?v=1.0"></script>
    @endif

    @if(request()->is('funcionescargo'))
    <script src="/assets/js_sitio/organizacion/catalogos/catalogofuncionescargo.js?v=1.0"></script>
    @endif

    @if(request()->is('funcionesgestion'))
    <script src="/assets/js_sitio/organizacion/catalogos/catalogofuncionesgestion.js?v=3.0"></script>
    @endif

    @if(request()->is('relacionesexternas'))
    <script src="/assets/js_sitio/organizacion/catalogos/catalogosrelacionesxternas.js?v=1.0"></script>
    @endif

    @if(request()->is('requisiciondepersonal'))
    <script src="/assets/js_sitio/organizacion/requerimiento.js?v=6"></script>
    @endif

    @if(request()->is('catalogodevacantes'))
    <script src="/assets/js_sitio/organizacion/catalogos/catalogovacantes.js?v=1.2"></script>
    @endif

    @if(request()->is('categorias'))
    <script src="/assets/js_sitio/organizacion/catalogos/catalogocategoria.js?v=4.0"></script>
    @endif

    @if(request()->is('genero'))
    <script src="/assets/js_sitio/organizacion/catalogos/catalogogenero.js?v=1.0"></script>
    @endif

    @if(request()->is('puestoexperiencia'))
    <script src="/assets/js_sitio/organizacion/catalogos/catalogoexperiencia.js?v=1.0"></script>
    @endif

    @if(request()->is('competenciasbasicas'))
    <script src="/assets/js_sitio/organizacion/catalogos/catálogocompetenciabasica.js?v=1.0"></script>
    @endif

    @if(request()->is('tipovacante'))
    <script src="/assets/js_sitio/organizacion/catalogos/catalogotipovacante.js?v=1.0"></script>
    @endif

    @if(request()->is('competenciasgerenciales'))
    <script src="/assets/js_sitio/organizacion/catalogos/catalogoCompetenciasGerenciales.js?v=1.0"></script>
    @endif

    @if(request()->is('anuncios'))
    <script src="/assets/js_sitio/organizacion/catalogos/catalogoanuncion.js"></script>
    @endif

    @if(request()->is('listavacantes'))
    <script src="/assets/js_sitio/reclutamiento/Listavacante.js?v=2.0"></script>
    @endif

    @if(request()->is('postulaciones'))
    <script src="/assets/js_sitio/reclutamiento/vacantesactivas.js?v=6.2"></script>
    @endif

    @if(request()->is('motivovacante'))
    <script src="/assets/js_sitio/organizacion/catalogos/catalogomotivovacante.js?v=1.0"></script>
    @endif

    @if(request()->is('areainteres'))
    <script src="/assets/js_sitio/organizacion/catalogos/catalogoareainteres.js?v=1.0"></script>
    @endif

    @if(request()->is('seleccion'))
    <script src="/assets/js_sitio/seleccion/seleccion.js?v=24"></script>
    @endif

    @if(request()->is('visualizarseleccion'))
    <script src="/assets/js_sitio/seleccion/visualizarseleccion.js?v=4"></script>
    @endif

    @if(request()->is('pruebasconocimientos'))
    <script src="/assets/js_sitio/organizacion/catalogos/catalogopruebas.js?v=1.0"></script>
    @endif

    @if(request()->is('usuario'))
    <script src="/assets/js_sitio/usuario/usuario.js?v=5"></script>
    @endif

    @if(request()->is('contratacion'))
    <script src="/assets/js_sitio/contratacion/contratacion.js?v=17"></script>
    <!-- Form wizard -->
    <script src="/assets/plugins/form_wizard_steps_bootstrap/form_wizard_script.js"></script>
    @endif

    @if(request()->is('pendientecontratar'))
    <script src="/assets/js_sitio/contratacion/pendientecontratar.js?v=2.0"></script>
    @endif

    @if(request()->is('desvinculacion'))
    <script src="/assets/js_sitio/desvinculacion/desvinculacion.js?v=4.0"></script>
    @endif

    @if(request()->is('brechacompetencia'))
    <script src="/assets/js_sitio/capacitacion/brechacompetencia.js?v=1.5"></script>
    @endif

    @if(request()->is('recempleado'))
    <script src="/assets/js_sitio/RecEmpleados/recursosempleado.js?v=1.21"></script>
    @endif

    @if(request()->is('solicitudesvobo'))
    <script src="/assets/js_sitio/RecEmpleados/recempleadovobo.js?v=1.11"></script>
    @endif

    @if(request()->is('solicitudesaprobaciones'))
    <script src="/assets/js_sitio/RecEmpleados/recempleadoaprobacion.js?v=2"></script>
    @endif

    @if(request()->is('requisiciondepersonalsolicitud'))
    <script src="/assets/js_sitio/organizacion/requerimientosolicitud.js?v=2.0"></script>
    @endif

    @if(request()->is('postulacioneshistorial'))
    <script src="/assets/js_sitio/reclutamiento/vacantesactivashistorial.js"></script>
    @endif

    @if(request()->is('expediente'))
    <script src="/assets/js_sitio/RecEmpleados/expediente.js?v=2"></script>
    <!-- Form wizard -->
    <script src="/assets/plugins/form_wizard_steps_bootstrap/form_wizard_script.js"></script>
    @endif

    @if(request()->is('actualizaciondocumentos'))
    <script src="/assets/js_sitio/contratacion/actualizaciondocs.js?v=2"></script>
    @endif

    @if(request()->is('actualizaciondocumentoshistorial'))
    <script src="/assets/js_sitio/contratacion/actualizaciondochistorial.js"></script>
    @endif

    @if(request()->is('capacitaciontipocurso'))
    <script src="/assets/js_sitio/capacitacion/catalogos/tipocurso.js"></script>
    @endif

    @if(request()->is('capacitacionareaconocimiento'))
    <script src="/assets/js_sitio/capacitacion/catalogos/areaconocimiento.js"></script>
    @endif

    @if(request()->is('capacitacionmodalidad'))
    <script src="/assets/js_sitio/capacitacion/catalogos/modalidad.js"></script>
    @endif

    @if(request()->is('capacitacionformato'))
    <script src="/assets/js_sitio/capacitacion/catalogos/formato.js"></script>
    @endif

    @if(request()->is('capacitacionpaisoregion'))
    <script src="/assets/js_sitio/capacitacion/catalogos/paisoregion.js"></script>
    @endif

    @if(request()->is('capacitacionidioma'))
    <script src="/assets/js_sitio/capacitacion/catalogos/idioma.js"></script>
    @endif

    @if(request()->is('capacitacionnormatividad'))
    <script src="/assets/js_sitio/capacitacion/catalogos/normatividad.js"></script>
    @endif

    @if(request()->is('capacitacionreconocimiento'))
    <script src="/assets/js_sitio/capacitacion/catalogos/reconocimiento.js"></script>
    @endif

    @if(request()->is('capacitacioncompetencia'))
    <script src="/assets/js_sitio/capacitacion/catalogos/competencia.js"></script>
    @endif

    @if(request()->is('capacitaciontipoproveedor'))
    <script src="/assets/js_sitio/capacitacion/catalogos/tipoproveedor.js"></script>
    @endif

    @if(request()->is('capacitacionmetodoevaluacion'))
    <script src="/assets/js_sitio/capacitacion/catalogos/metodoevaluacion.js"></script>
    @endif

    @if(request()->is('capacitacionevidenciasgeneradas'))
    <script src="/assets/js_sitio/capacitacion/catalogos/evidenciasgeneradas.js"></script>
    @endif

    @if(request()->is('capacitacionubicacion'))
    <script src="/assets/js_sitio/capacitacion/catalogos/ubicacion.js"></script>
    @endif

    @if(request()->is('capacitacionmaterialdidactico'))
    <script src="/assets/js_sitio/capacitacion/catalogos/materialdidactico.js"></script>
    @endif

    @if(request()->is('capacitacionimpactoesperado'))
    <script src="/assets/js_sitio/capacitacion/catalogos/impactoesperado.js"></script>
    @endif

    @if(request()->is('capacitacioncursos'))
    <script src="/assets/js_sitio/capacitacion/catalogos/cursos.js?v=1"></script>
    @endif

    @if(request()->is('capacitaciondocumentosemitidos'))
    <script src="/assets/js_sitio/capacitacion/catalogos/documentosemitidos.js"></script>
    @endif

    @if(request()->is('capacitacionmoneda'))
    <script src="/assets/js_sitio/capacitacion/catalogos/moneda.js"></script>
    @endif

    @if(request()->is('capacitaciolineasnegocios'))
    <script src="/assets/js_sitio/capacitacion/catalogos/lineanegocios.js"></script>
    @endif

    @if(request()->is('aprobarinteligencialaboral'))
    <script src="/assets/js_sitio/seleccion/aprobarseleccion.js?v=1"></script>
    @endif




    <script src="/assets/js_sitio/externo.js?v=1.0"></script>



</body>

</html>