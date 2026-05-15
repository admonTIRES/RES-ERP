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

    <link rel="stylesheet" href="assets/css/estilos.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">



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
            <!-- Contenedor para centrar el título -->
            <div class="d-flex justify-content-center align-items-center w-100" style="position: absolute; top: 0; left: 0; height: 100px;">
                <h1 class="text-white m-0" style="color:#ffff;font-weight: bold;">{{ Auth::user()->NOMBRE_COMERCIAL_PROVEEDOR }}</h1>
            </div>
            <!-- Menú lateral derecho -->
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav1">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown" style="margin-right: 45px;">
                        @auth
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-fill text-white" style="font-size: 24px;"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" style="min-width: 250px;">
                            <li class="dropdown-item text-center">
                                <strong>{{ Auth::user()->NOMBRE_COMERCIAL_PROVEEDOR }}</strong>
                                <br>
                                <small>{{ Auth::user()->RFC_PROVEEDOR }}</small>
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
                        @else
                        <script>
                            window.location.href = "{{ route('login') }}"; // Redirige al login si no está autenticado
                        </script>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
    </nav>



    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: rgba(0, 124, 186, 0.850); -webkit-box-shadow: 3px 29px 29px -15px rgba(0,0,0,0.75); -moz-box-shadow: 3px 29px 29px -15px rgba(0,0,0,0.75); box-shadow: 3px 29px 29px -15px rgba(0,0,0,0.75);">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown" style="margin-left: 8px;">
                        {{-- <a class="nav-link BOTON" href="{{ url('/Alta') }}" style="color: #fff; font-weight: bold; text-decoration: none; ">
                        <i class="bi bi-speedometer" style="margin-right: 5px;"></i> <span class="d-lg-none">Alta y actualización </span><span class="d-none d-lg-inline">Alta y actualización </span>
                        </a> --}}
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    @if(session('error'))

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



    <!-- Botón de menú hamburguesa -->



    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Menú lateral en col-2 -->
            <div class="col-2 d-none d-md-block bg-light vh-100">
                <div class="p-3">
                    <h5 class="text-center">Menú</h5>
                    <nav>
                        <ul class="menu-list">
                            <li class="nav-item dropdown">
                                <a href="{{ url('/alta') }}" class="d-flex flex-column align-items-center text-center ">
                                    <i class="bi bi-speedometer"></i>
                                    <span>Alta y actualización</span>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a href="{{ url('/proveedorescuentas') }}" class="d-flex flex-column align-items-center text-center">
                                    <i class="bi bi-currency-dollar"></i>
                                    <span>Cuentas bancarias</span>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a href="{{ url('/proveedorescontactos') }}" class="d-flex flex-column align-items-center text-center">
                                    <i class="bi bi-person-lines-fill"></i>
                                    <span>Contactos</span>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a href="{{ url('/proveedorescertificaciones') }}" class="d-flex flex-column align-items-center text-center">
                                    <i class="bi bi-award-fill"></i>
                                    <span>Certificaciones, acreditaciones y membresías</span>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a href="{{ url('/proveedoresreferencias') }}" class="d-flex flex-column align-items-center text-center">
                                    <i class="bi bi-journal-text"></i>
                                    <span>Referencias comerciales</span>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a href="{{ url('/proveedoresdocumentos') }}" class="d-flex flex-column align-items-center text-center">
                                    <i class="bi bi-file-earmark-pdf-fill"></i>
                                    <span>Documentos de soporte</span>
                                </a>
                            </li>
                            <li class="nav-item dropdown" id="CONTRATOS" style="display: none;">
                                <a href="{{ url('/contratoproveedores') }}" class="d-flex flex-column align-items-center text-center">
                                    <i class="bi bi-file-earmark-fill"></i>
                                    <span> Contratos </span>
                                </a>
                            </li>
                            <li class="nav-item dropdown" id="POYGR" style="display: none;">
                                <a href="{{ url('/po-gr') }}" class="d-flex flex-column align-items-center text-center">
                                    <i class="bi bi-file-earmark-fill"></i>
                                    <span>Orden de compras (PO) <br> y <br> Recepción de bienes y/o servicios (GR)
                                    </span>
                                </a>
                            </li>

                            <li id="FACTURA" style="display: none;">
                                <a href="{{ url('/factura') }}" class="d-flex flex-column align-items-center text-center">
                                    <i class="bi bi-file-earmark-fill"></i>
                                    <span>Facturación</span>
                                </a>
                            </li>
                            <li id="REP" style="display: none;">
                                <a href="{{ url('/reciboelectronico') }}" class="d-flex flex-column align-items-center text-center">
                                    <i class="bi bi-file-earmark-fill"></i>
                                    <span>Recibo Electrónico de Pago (REP)</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <button type="submit" id="SOLICITAR_VERIFICACION"
                        class="btn w-100 text-white fw-bold"
                        style="background-color: #ff4c4c; border-color: #ff4c4c;">
                        Solicitar validación de la información
                    </button>
                </div>
            </div>

            <!-- Contenedor del contenido principal en col-10 -->
            <div class="col-10 position-relative">
                <!-- Contenido dinámico -->
                <div class="contenido p-4">
                    @yield('contenido')
                </div>
            </div>
        </div>
    </div>


    <!-- Estilos para mejorar la apariencia del menú -->
    <style>
        .menu-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .menu-list li {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            /* Línea divisoria sutil */
        }

        .menu-list li a {
            display: block;
            text-decoration: none;
            color: #333;
            font-size: 18px;
            font-weight: bold;
            transition: background 0.3s, color 0.3s;
            padding: 10px 15px;
            border-radius: 5px;
        }

        .menu-list li a:hover {
            background-color: #007bff;
            color: white;
        }
    </style>


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


    <script src="/assets/js_sitio/proveedor/funciongeneralesproveedores.js?v=4"></script>



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




    <script>
        // document.addEventListener('input', function(event) {
        //     if ((event.target.tagName === 'INPUT' && event.target.type === 'text') || event.target.tagName === 'TEXTAREA') {
        //         const palabras = event.target.value.split(' ').map(palabra => {
        //             if (palabra.length === 0) return '';

        //             const primeraMayuscula = palabra[0].toUpperCase() + palabra.substring(1).toLowerCase();

        //             // Si la palabra no es igual a toda minúscula, ni igual a primera mayúscula → corregimos
        //             if (palabra !== palabra.toLowerCase() && palabra !== primeraMayuscula) {
        //                 return primeraMayuscula;
        //             } else {
        //                 return palabra;
        //             }
        //         });

        //         event.target.value = palabras.join(' ');
        //     }
        // });


        document.addEventListener('input', function(event) {
            if ((event.target.tagName === 'INPUT' && event.target.type === 'text') || event.target.tagName === 'TEXTAREA') {

                const idsExcluidos = ['TIPO_BANCO', 'TIPO_MONEDA', 'CODIGO_SWIFT_BIC', 'CODIGO_ABA', 'CIUDAD', 'PAIS', 'NOMBRE_BENEFICIARIO', 'NOMBRE_CONTACTO_CUENTA', 'CARGO_CONTACTO_CUENTA', 'NORMA_CERTIFICACION', 'VERSION_CERTIFICACION', 'ENTIDAD_CERTIFICADORA', 'NORMA_ACREDITACION', 'VERSION_ACREDITACION', 'ALCANCE_ACREDITACION', 'ENTIDAD_ACREDITADORA', 'ENTIDAD_AUTORIZADORA', 'NOMBRE_ENTIDAD_MEMBRESIA', 'NOMBRE_EMPRESA', 'NOMBRE_CONTACTO', 'CARGO_REFERENCIA', 'PRODUCTO_SERVICIO', 'OTRO_ID', 'NO_PO', 'NO_GR', 'MONEDA_FACTURA', 'NO_FACTURA', 'METODO_PAGO', 'FOLIO_FISCAL', 'NO_FACTURA_EXTRANJERO', 'MONEDA_FACTURA_EXTRANJERO', 'NO_CONTRATO', 'IVA_FACTURA', 'TOTAL_FACTURA'];

                if (idsExcluidos.includes(event.target.id)) {
                    return;
                }

                const palabras = event.target.value.split(' ').map(palabra => {
                    if (palabra.length === 0) return '';

                    const primeraMayuscula = palabra[0].toUpperCase() + palabra.substring(1).toLowerCase();

                    if (palabra !== palabra.toLowerCase() && palabra !== primeraMayuscula) {
                        return primeraMayuscula;
                    } else {
                        return palabra;
                    }
                });

                event.target.value = palabras.join(' ');
            }
        });
    </script>


    @if(request()->is('alta'))
    <script src="/assets/js_sitio/proveedor/altaproveedores.js?v=2"></script>
    @endif

    @if(request()->is('proveedorescuentas'))
    <script src="/assets/js_sitio/proveedor/altacuentas.js?v=1.3"></script>
    @endif

    @if(request()->is('proveedorescontactos'))
    <script src="/assets/js_sitio/proveedor/altacontactos.js?v=1.3"></script>
    @endif

    @if(request()->is('proveedorescertificaciones'))
    <script src="/assets/js_sitio/proveedor/altacertifiacion.js?v=1.0"></script>
    @endif

    @if(request()->is('proveedoresreferencias'))
    <script src="/assets/js_sitio/proveedor/altareferencias.js?v=1.0"></script>
    @endif

    @if(request()->is('proveedoresdocumentos'))
    <script src="/assets/js_sitio/proveedor/altadocumentos.js?v=2"></script>
    @endif

    @if(request()->is('po-gr'))
    <script src="/assets/js_sitio/proveedor/factura/poygr.js?v=1"></script>
    @endif

    @if(request()->is('factura'))
    <script src="/assets/js_sitio/proveedor/factura/cargarfactura.js?v=6"></script>
    @endif

    @if(request()->is('reciboelectronico'))
    <script src="/assets/js_sitio/proveedor/factura/cargarrep.js?v=1"></script>
    @endif


    @if(request()->is('contratoproveedores'))
    <script src="/assets/js_sitio/proveedor/contratosproveedors.js"></script>
    @endif



</body>

</body>

</html>