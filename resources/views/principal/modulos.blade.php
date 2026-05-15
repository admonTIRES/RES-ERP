<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="20x20" href="/assets/images/favicon.png">
    <title>Results In Performance</title>
    <link href="assets/css/mobile.css" rel="stylesheet" media="all and (max-width: 600px)">
    <link href="assets/css/desktop.css" rel="stylesheet" media="all and (min-width: 600px)">


    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        .lineasDeNegocio__iconsm,
        .content__noticias img,
        .modules__circle img,
        .softwares__image,
        .learning__image img {
            transition: transform 0.3s ease, filter 0.3s ease;
        }

        .lineasDeNegocio__iconsm:hover,
        .content__noticias img:hover,
        .modules__circle img:hover,
        .softwares__image:hover,
        .learning__image img:hover {
            transform: scale(1.1);
            filter: brightness(1.2);
        }



        .softwares__card,
        .softwares__greyCard {
            height: 25vh;
            width: 48%;
            background-color: #ff585d;
            border-radius: 16px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 0.5em;
        }

        .softwares__card img,
        .softwares__greyCard img {
            height: 9em;
            width: 9em;
            padding-top: 0em;
        }

        .lineasDeNegocio__iconButton {
            transition: transform 0.3s ease, background-color 0.3s ease;
            border: none;
            background: none;
            cursor: pointer;
        }

        .lineasDeNegocio__iconButton:hover {
            transform: scale(1.2);
            background-color: rgba(0, 0, 0, 0.1);
        }


        .content__title,
        .content__paragraph,
        .modules__text,
        .learning__title,
        .learning__link {
            transition: color 0.3s ease;
        }

        .content__title:hover,
        .content__paragraph:hover,
        .modules__text:hover,
        .learning__title:hover,
        .learning__link:hover {
            color: #007bff;
        }


        .lineasDeNegocio__image img {
            transition: transform 0.3s ease, filter 0.3s ease;
        }

        .lineasDeNegocio__image:hover img {
            transform: scale(1.1);
            filter: brightness(1.2);
        }

        .tooltip {
            position: relative;
            display: inline-block;
        }

        .tooltipText {
            position: absolute;
            top: 50%;
            left: 110%;
            transform: translateY(-50%);
            background-color: #333;
            color: #fff;
            padding: 6px 10px;
            border-radius: 6px;
            white-space: nowrap;
            font-size: 13px;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease;
            z-index: 10;
        }

        .tooltip:hover .tooltipText {
            opacity: 1;
            visibility: visible;
        }

        .tooltipText::after {
            content: "";
            position: absolute;
            top: 50%;
            right: 100%;
            transform: translateY(-50%);
            border-width: 6px;
            border-style: solid;
            border-color: transparent #333 transparent transparent;
        }

        .learning {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.2);
            padding: 20px;
            color: #000;
        }

        .learning__title,
        .learning__link {
            color: #000 !important;
        }


        .content__noticias,
        .modules__card,
        .softwares__card,
        .softwares__greyCard,
        .learning {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .content__noticias:hover,
        .modules__card:hover,
        .softwares__card:hover,
        .softwares__greyCard:hover,
        .learning:hover {
            transform: translateY(-5px);
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }



        .content__noticias {
            display: flex;
            align-items: center;
            background-color: #ff5b5b;
            border-radius: 20px;
            margin-bottom: 20px;
            padding: 15px;
            gap: 20px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .content__noticias:hover {
            transform: scale(1.01);
        }

        .content__noticiasImage {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            flex-shrink: 0;
            background-color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .content__noticiasImage img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }


        .content__noticiasText {
            flex-grow: 1;
        }

        .content__title {
            font-size: 1.1rem;
            font-weight: bold;
            margin: 0 0 5px;
            color: white;
        }

        .content__paragraph {
            font-size: 0.9rem;
            color: white;
            margin: 0;
        }

        .modal-anuncio {
            position: fixed;
            z-index: 9999;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-contenido {
            background: white;
            padding: 20px;
            max-width: 600px;
            width: 90%;
            border-radius: 15px;
            text-align: center;
            position: relative;
        }

        .modal-contenido img {
            max-width: 300px;
            height: auto;
            border-radius: 10px;
            margin-bottom: 15px;
            object-fit: cover;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .cerrar {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 1.5rem;
            cursor: pointer;
        }

        .carrusel {
            position: relative;
            width: 100%;
            overflow: hidden;
            margin-bottom: 30px;
        }

        .carrusel-slide {
            display: none;
            width: 100%;
            animation: fade 0.5s ease-in-out;
        }

        .carrusel-slide.activo {
            display: block;
        }

        @keyframes fade {
            from {
                opacity: 0.5;
            }

            to {
                opacity: 1;
            }
        }
    </style>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>
    <section>





        <div class="erp">
            <div class="lineasDeNegocio">
                <div class="lineasDeNegocio__image">
                    <img src="{{ route('usuariofoto', auth()->user()->ID_USUARIO) }}" alt="">
                </div>

                <div class="tooltip">
                    <img class="lineasDeNegocio__iconsm" src="assets/Modulos/img/1-negocio.png" alt="">
                    <span class="tooltipText">SOLUCIONES EN CALIDAD</span>
                </div>

                <div class="tooltip">
                    <img class="lineasDeNegocio__iconsm" src="assets/Modulos/img/2-negocio.png" alt="">
                    <span class="tooltipText">SOLUCIONES LIDERAZGO Y HAB. HUMANAS</span>
                </div>

                <div class="tooltip">
                    <img class="lineasDeNegocio__iconsm" src="assets/Modulos/img/3-negocio.png" alt="">
                    <span class="tooltipText">SOLUCIONES TÉCNICAS</span>
                </div>

                <div class="tooltip">
                    <img class="lineasDeNegocio__iconsm" src="assets/Modulos/img/4-negocio.png" alt="">
                    <span class="tooltipText">SOLUCIONES MEDIO AMBIENTE</span>
                </div>

                <div class="tooltip">
                    <img class="lineasDeNegocio__iconsm" src="assets/Modulos/img/5-negocio.png" alt="">
                    <span class="tooltipText">SOLUCIONES EN SST</span>
                </div>

                <!-- <div class="tooltip">
                    <img class="lineasDeNegocio__iconsm" src="assets/Modulos/img/informacionempresa.png" alt="">
                    <span class="tooltipText">Información de la empresa</span>
                </div> -->

                <div class="tooltip" id="btnInfoEmpresa">
                    <img class="lineasDeNegocio__iconsm"
                        src="assets/Modulos/img/informacionempresa.png"
                        alt="">
                    <span class="tooltipText">Información de la empresa</span>
                </div>


                <div class="lineasDeNegocio__servicios"></div>

                <div class="tooltip lineasDeNegocio__button">
                    <form id="logoutForm" method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="button" id="logoutButton" class="lineasDeNegocio__iconButton">
                            <img src="assets/Modulos/img/salir.png" alt="">
                        </button>
                    </form>

                    <span class="tooltipText">Cerrar sesión</span>
                </div>
            </div>


            <div class="panel">

                <div class="nav">
                    <div class="nav__usuario">
                        <h2>Hola, {{ Auth::user()->EMPLEADO_NOMBRE }} {{ Auth::user()->EMPLEADO_APELLIDOPATERNO }} {{ Auth::user()->EMPLEADO_APELLIDOMATERNO }}</h2>
                    </div>

                    <div class="nav__buttons">
                        <div class="tooltip">
                            <a href="https://results-in-performance.com" target="_blank" class="nav__emailLink">
                                <button class="nav__circularButton">
                                    <img src="assets/Modulos/img/sitoweb.png" alt="">
                                </button>
                            </a>
                            <span class="tooltipText">Sitio web</span>
                        </div>

                        <div class="tooltip">
                            <a href="https://mail.google.com/mail/u/0/#inbox?compose=new" target="_blank" class="nav__emailLink">
                                <button class="nav__circularButton">
                                    <img src="assets/Modulos/img/email.png" alt="">
                                </button>
                            </a>
                            <span class="tooltipText">Correo electrónico</span>
                        </div>

                        <div class="notification-wrapper">
                            <div class="tooltip">
                                <button class="nav__circularButton" id="btnNotificaciones">
                                    <img src="assets/Modulos/img/notificacion.png" alt="">
                                    <span id="contadorNotificaciones" class="notification-count">0</span>
                                </button>

                            </div>

                            <div class="notification-panel" id="panelNotificaciones">
                                <div class="notification-header">
                                    <h4>Notificaciones</h4>
                                </div>

                                <div class="notification-body">
                                    <p class="notification-item">📌 No tienes notificaciones por el momento.</p>
                                </div>
                            </div>

                            <style>
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


                                .notification-wrapper {
                                    position: relative;
                                    display: inline-block;
                                }

                                .notification-panel {
                                    position: absolute;
                                    top: 85px;
                                    right: 0;
                                    width: 350px;
                                    background: #ffffff;
                                    border-radius: 10px;
                                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                                    display: none;
                                    z-index: 999;
                                    overflow: hidden;
                                }

                                .notification-header {
                                    background: #a2a2a2;
                                    padding: 10px;
                                    font-weight: bold;
                                    border-bottom: 1px solid #ddd;
                                }

                                .notification-body {
                                    max-height: 250px;
                                    overflow-y: auto;
                                }

                                .notification-item {
                                    padding: 12px;
                                    border-bottom: 1px solid #eee;
                                    font-size: 14px;
                                }

                                .notification-item:last-child {
                                    border-bottom: none;
                                }

                                .notification-item:hover {
                                    background: #f0f0f0;
                                    cursor: pointer;
                                }
                            </style>
                        </div>

                    </div>
                </div>

                <div class="content">

                    <div class="content__left">
                        {{-- CARRUSEL: Anuncios del Día o Año --}}
                        @if($anunciosDiaAnio->isNotEmpty())
                        <div class="carrusel" id="carruselDiaAnio">
                            @foreach ($anunciosDiaAnio as $index => $anuncio)
                            <div class="carrusel-slide {{ $index === 0 ? 'activo' : '' }}"
                                data-imagen="{{ route('anunciofoto', $anuncio->ID_CATALOGO_ANUNCIOS) }}"
                                data-titulo="{{{ $anuncio->TITULO_ANUNCIO }}}"
                                data-descripcion="{{{ $anuncio->DESCRIPCION_ANUNCIO }}}"
                                onclick="mostrarModalDesdeData(this)">
                                <div class="content__noticias">
                                    <div class="content__noticiasImage">
                                        <img src="{{ route('anunciofoto', $anuncio->ID_CATALOGO_ANUNCIOS) }}" alt="Imagen del anuncio">
                                    </div>
                                    <div class="content__noticiasText">
                                        <h3 class="content__title">{{ $anuncio->TITULO_ANUNCIO }}</h3>
                                        <p class="content__paragraph">{{ Str::limit($anuncio->DESCRIPCION_ANUNCIO, 80, '...') }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else

                        @endif

                        {{-- CARRUSEL: Anuncios del Mes --}}
                        @if($anunciosMes->isNotEmpty())
                        <div class="carrusel" id="carruselMes">
                            @foreach ($anunciosMes as $index => $anuncio)
                            <div class="carrusel-slide {{ $index === 0 ? 'activo' : '' }}"
                                data-imagen="{{ route('anunciofoto', $anuncio->ID_CATALOGO_ANUNCIOS) }}"
                                data-titulo="{{{ $anuncio->TITULO_ANUNCIO }}}"
                                data-descripcion="{{{ $anuncio->DESCRIPCION_ANUNCIO }}}"
                                onclick="mostrarModalDesdeData(this)">
                                <div class="content__noticias">
                                    <div class="content__noticiasImage">
                                        <img src="{{ route('anunciofoto', $anuncio->ID_CATALOGO_ANUNCIOS) }}" alt="Imagen del anuncio">
                                    </div>
                                    <div class="content__noticiasText">
                                        <h3 class="content__title">{{ $anuncio->TITULO_ANUNCIO }}</h3>
                                        <p class="content__paragraph">{{ Str::limit($anuncio->DESCRIPCION_ANUNCIO, 80, '...') }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else

                        @endif




                        <div class="widget">
                            <div class="widget__area" id="DIV_CLIMA"></div>

                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    const widgetArea = document.getElementById("DIV_CLIMA");

                                    function getWeatherByLocation() {
                                        if (navigator.geolocation) {
                                            navigator.geolocation.getCurrentPosition(success, error);
                                        } else {
                                            widgetArea.innerHTML = "Geolocalización no soportada.";
                                        }
                                    }

                                    function success(position) {
                                        const lat = position.coords.latitude;
                                        const lon = position.coords.longitude;
                                        fetchWeather(lat, lon);
                                    }

                                    function error() {
                                        widgetArea.innerHTML = "No se pudo obtener la ubicación.";
                                    }

                                    function fetchWeather(lat, lon) {
                                        const url = `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current_weather=true&timezone=auto`;

                                        fetch(url)
                                            .then(response => response.json())
                                            .then(data => {
                                                const temperature = data.current_weather.temperature;
                                                const windSpeed = data.current_weather.windspeed;
                                                const weatherCode = data.current_weather.weathercode;

                                                const weatherDescriptions = {
                                                    0: "Despejado ☀️",
                                                    1: "Mayormente despejado 🌤",
                                                    2: "Parcialmente nublado ⛅",
                                                    3: "Nublado ☁️",
                                                    45: "Niebla 🌫",
                                                    48: "Niebla helada ❄️🌫",
                                                    51: "Llovizna ligera 🌦",
                                                    53: "Llovizna moderada 🌧",
                                                    55: "Llovizna intensa 🌧",
                                                    61: "Lluvia ligera 🌧",
                                                    63: "Lluvia moderada 🌧",
                                                    65: "Lluvia intensa ⛈",
                                                    80: "Chubascos ligeros 🌦",
                                                    81: "Chubascos moderados 🌦",
                                                    82: "Chubascos intensos ⛈",
                                                    95: "Tormenta ⛈",
                                                    99: "Tormenta fuerte ⛈⚡"
                                                };

                                                const description = weatherDescriptions[weatherCode] || "Clima desconocido";

                                                widgetArea.innerHTML = `
                                                    <div class="weather-widget">
                                                        <h3>Clima Actual</h3>
                                                        <p class="temperature">${temperature}°C</p>
                                                        <p class="description">${description}</p>
                                                        <p>💨 Viento: ${windSpeed} km/h</p>
                                                        <p class="updated-time">⏰ Actualizado: <span id="current-time"></span></p>
                                                    </div>
                                                `;

                                                updateClock();
                                                setInterval(updateClock, 1000);
                                            })
                                            .catch(() => {
                                                widgetArea.innerHTML = "No se pudo obtener el clima.";
                                            });
                                    }

                                    function updateClock() {
                                        const now = new Date();
                                        const formattedTime = now.toLocaleTimeString("es-MX", {
                                            hour: "2-digit",
                                            minute: "2-digit",
                                            second: "2-digit"
                                        });
                                        const clockElement = document.getElementById("current-time");
                                        if (clockElement) {
                                            clockElement.innerText = formattedTime;
                                        }
                                    }

                                    getWeatherByLocation();
                                });
                            </script>

                            <style>
                                .widget__area {
                                    background: linear-gradient(to right, #236192, #007DBA);
                                    color: white;
                                    text-align: center;
                                    padding: 8px;
                                    border-radius: 15px;
                                    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
                                    font-family: 'Poppins', sans-serif;
                                    display: flex;
                                    flex-direction: column;
                                    justify-content: center;
                                    align-items: center;
                                    overflow: hidden;
                                }

                                .weather-widget {
                                    width: 100%;
                                    height: 100%;
                                }

                                .temperature {
                                    font-size: 1.5vw;
                                    font-weight: bold;
                                    margin: 2px 0;
                                }

                                .description {
                                    font-size: 0.9vw;
                                    font-weight: bold;
                                    text-align: center;
                                    margin: 2px 0;
                                    white-space: normal;
                                    line-height: 1.1;
                                }

                                .updated-time {
                                    font-size: 0.7vw;
                                    opacity: 0.8;
                                    margin-top: 3px;
                                }

                                p {
                                    margin: 2px 0;
                                    line-height: 1;
                                }
                            </style>


                            <div class="widget__area" id="DIV_MONEDA"></div>


                            <script>
                                async function cargarTipoCambio() {
                                    const div = document.getElementById("DIV_MONEDA");
                                    div.innerHTML = "⏳ Cargando tipo de cambio...";

                                    try {
                                        const response = await fetch("/tipo-cambio");
                                        const data = await response.json();

                                        if (data.error) {
                                            div.innerHTML = " Error: " + data.mensaje;
                                            return;
                                        }

                                        div.innerHTML = `
                                    <div class="currency-widget">
                                        <h3>💵 Tipo de Cambio</h3>
                                        <p class="rate">USD → MXN</p>
                                        <p class="value">$${data.dato} MXN</p>
                                        <p class="date">📅 Fecha: ${data.fecha}</p>
                                    </div>
                            `;

                                        updateClock();
                                        setInterval(updateClock, 1000);

                                    } catch (error) {
                                        div.innerHTML = "❌ No se pudo cargar el tipo de cambio.";
                                        console.error(error);
                                    }
                                }

                                function updateClock() {
                                    const now = new Date();
                                    const formattedTime = now.toLocaleTimeString("es-MX", {
                                        hour: "2-digit",
                                        minute: "2-digit",
                                        second: "2-digit"
                                    });
                                    const clockElement = document.getElementById("current-time");
                                    if (clockElement) {
                                        clockElement.innerText = formattedTime;
                                    }
                                }

                                document.addEventListener("DOMContentLoaded", cargarTipoCambio);
                            </script>

                            <style>
                                .widget__area {

                                    color: white;
                                    text-align: center;
                                    padding: 12px;
                                    border-radius: 15px;
                                    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
                                    font-family: 'Poppins', sans-serif;
                                    display: flex;
                                    flex-direction: column;
                                    justify-content: center;
                                    align-items: center;
                                    overflow: hidden;
                                }

                                .currency-widget {
                                    width: 100%;
                                    height: 100%;
                                }

                                .currency-widget h3 {
                                    margin: 5px 0;
                                    font-size: 1.2vw;
                                    font-weight: bold;
                                }

                                .rate {
                                    font-size: 0.9vw;
                                    margin: 3px 0;
                                }

                                .value {
                                    font-size: 1.6vw;
                                    font-weight: bold;
                                    margin: 4px 0;
                                }

                                .date {
                                    font-size: 0.8vw;
                                    margin: 2px 0;
                                }

                                .updated-time {
                                    font-size: 0.7vw;
                                    opacity: 0.8;
                                    margin-top: 3px;
                                }

                                p {
                                    margin: 2px 0;
                                    line-height: 1.1;
                                }
                            </style>

                        </div>


                        @php
                        $user = auth()->user();

                        /*
                        |--------------------------------------------------------------------------
                        | Rol con prioridad absoluta
                        |--------------------------------------------------------------------------
                        */
                        $esSuperusuario = $user->hasAnyRole(['Superusuario', 'Administrador','externo']);

                        /*
                        |--------------------------------------------------------------------------
                        | Roles operativos (solo aplican si NO es Superusuario/Admin)
                        |--------------------------------------------------------------------------
                        */
                        $tieneSoloRolIntendente = !$esSuperusuario && $user->hasRole('Intendente');
                        $tieneSoloRolAlmacenista = !$esSuperusuario && $user->hasRole('Almacenista');
                        $tieneSoloRolLideOperaciones = !$esSuperusuario && $user->hasRole('Líder de Operaciones');
                        $tieneSoloRolTecnicojunior = !$esSuperusuario && $user->hasRole('Técnico en mantenimiento junior');

                        /*
                        |--------------------------------------------------------------------------
                        | Roles restringidos administrativos
                        |--------------------------------------------------------------------------
                        */
                        $tieneSoloRolSSTJunior = !$esSuperusuario && $user->hasRole('Consultor-Instructor Junior');
                        $tieneSoloRolAsistentePlaneacion = !$esSuperusuario && $user->hasRole('Asistente de planeación y logística');
                        $tieneSoloRolHSEQ = !$esSuperusuario && $user->hasRole('Analista HSEQ');
                        $tieneSoloRolSoftware = !$esSuperusuario && $user->hasRole('Desarrollador de Software Junior');
                        $tieneSoloRolAmadellaves = !$esSuperusuario && $user->hasRole('Ama de llaves');

                        /*
                        |--------------------------------------------------------------------------
                        | Agrupador de roles restringidos
                        |--------------------------------------------------------------------------
                        */
                        $tieneRolRestringidoUnico =
                        $tieneSoloRolSSTJunior ||
                        $tieneSoloRolAsistentePlaneacion ||
                        $tieneSoloRolHSEQ ||
                        $tieneSoloRolSoftware ||
                        $tieneSoloRolAmadellaves;

                        @endphp



                        <div class="modules">
                            {{-- RRHH --}}
                            @if($tieneRolRestringidoUnico || $tieneSoloRolAlmacenista || $tieneSoloRolLideOperaciones || $tieneSoloRolIntendente || $tieneSoloRolTecnicojunior )
                            <a href="{{ url('/recempleado') }}" class="modules__link">
                                <div class="modules__card">
                                    <div class="modules__circle"><img src="assets/Modulos/img/RRHH.png" alt=""></div>
                                    <h2 class="modules__text">RRHH</h2>
                                </div>
                            </a>
                            @else
                            <a href="{{ url('/tablero') }}" class="modules__link">
                                <div class="modules__card">
                                    <div class="modules__circle"><img src="assets/Modulos/img/RRHH.png" alt=""></div>
                                    <h2 class="modules__text">RRHH</h2>
                                </div>
                            </a>
                            @endif
                            {{-- Compras (SIEMPRE LIBRE, excepto Almacenista que va a Bitácora-GR) --}}
                            @if($tieneSoloRolAlmacenista)
                            <a href="{{ url('/bitacoragr') }}" class="modules__link">
                                <div class="modules__card">
                                    <div class="modules__circle"><img src="assets/Modulos/img/Compras.png" alt=""></div>
                                    <h2 class="modules__text">Compras</h2>
                                </div>
                            </a>
                            @else
                            <a href="{{ url('/requisicionmateriales') }}" class="modules__link">
                                <div class="modules__card">
                                    <div class="modules__circle"><img src="assets/Modulos/img/Compras.png" alt=""></div>
                                    <h2 class="modules__text">Compras</h2>
                                </div>
                            </a>
                            @endif
                            {{-- Ventas --}}
                            @if($tieneRolRestringidoUnico || $tieneSoloRolAlmacenista || $tieneSoloRolLideOperaciones || $tieneSoloRolTecnicojunior )
                            <div class="modules__card" onclick="noPermiso('Ventas')">
                                <div class="modules__circle"><img src="assets/Modulos/img/Ventas.png" alt=""></div>
                                <h2 class="modules__text">Ventas</h2>
                            </div>
                            @else
                            <a href="{{ url('/clientes') }}" class="modules__link">
                                <div class="modules__card">
                                    <div class="modules__circle"><img src="assets/Modulos/img/Ventas.png" alt=""></div>
                                    <h2 class="modules__text">Ventas</h2>
                                </div>
                            </a>
                            @endif
                            {{-- Admón --}}
                            @if($tieneRolRestringidoUnico || $tieneSoloRolAlmacenista || $tieneSoloRolLideOperaciones || $tieneSoloRolTecnicojunior )
                            <div class="modules__card" onclick="noPermiso('Admón')">
                                <div class="modules__circle"><img src="assets/Modulos/img/Admon.png" alt=""></div>
                                <h2 class="modules__text">Admón</h2>
                            </div>
                            @else
                            <div class="modules__card">
                                <div class="modules__circle"><img src="assets/Modulos/img/Admon.png" alt=""></div>
                                <h2 class="modules__text">Admón</h2>
                            </div>
                            @endif
                            {{-- Almacén --}}
                            @if($tieneSoloRolAlmacenista )
                            <a href="{{ url('/inventario') }}" class="modules__link">
                                <div class="modules__card">
                                    <div class="modules__circle"><img src="assets/Modulos/img/Almacén.png" alt=""></div>
                                    <h2 class="modules__text">Almacén</h2>
                                </div>
                            </a>
                            @elseif($tieneRolRestringidoUnico || $tieneSoloRolLideOperaciones || $tieneSoloRolTecnicojunior  )
                            <div class="modules__card" onclick="noPermiso('Almacén')">
                                <div class="modules__circle"><img src="assets/Modulos/img/Almacén.png" alt=""></div>
                                <h2 class="modules__text">Almacén</h2>
                            </div>
                            @else
                            <a href="{{ url('/inventario') }}" class="modules__link">
                                <div class="modules__card">
                                    <div class="modules__circle"><img src="assets/Modulos/img/Almacén.png" alt=""></div>
                                    <h2 class="modules__text">Almacén</h2>
                                </div>
                            </a>
                            @endif
                            {{-- Mantenimiento --}}
                            @if($tieneSoloRolAlmacenista || $tieneSoloRolTecnicojunior )
                            <a href="{{ url('/mantenimientoequipos') }}" class="modules__link">
                                <div class="modules__card">
                                    <div class="modules__circle"><img src="assets/Modulos/img/Almacén.png" alt=""></div>
                                    <h2 class="modules__text">Mantenimiento</h2>
                                </div>
                            </a>
                            @elseif($tieneRolRestringidoUnico || $tieneSoloRolLideOperaciones )
                            <div class="modules__card" onclick="noPermiso('Mantenimiento')">
                                <div class="modules__circle"><img src="assets/Modulos/img/Almacén.png" alt=""></div>
                                <h2 class="modules__text">Mantenimiento</h2>
                            </div>
                            @else
                            <a href="{{ url('/mantenimientoequipos') }}" class="modules__link">
                                <div class="modules__card">
                                    <div class="modules__circle"><img src="assets/Modulos/img/Almacén.png" alt=""></div>
                                    <h2 class="modules__text">Mantenimiento</h2>
                                </div>
                            </a>
                            @endif
                            {{-- HSE --}}
                            @if($tieneRolRestringidoUnico || $tieneSoloRolAlmacenista || $tieneSoloRolLideOperaciones || $tieneSoloRolTecnicojunior)
                            <div class="modules__card" onclick="noPermiso('HSE')">
                                <div class="modules__circle"><img src="assets/Modulos/img/RRHH.png" alt=""></div>
                                <h2 class="modules__text">HSE</h2>
                            </div>
                            @else
                            <div class="modules__card">
                                <div class="modules__circle"><img src="assets/Modulos/img/RRHH.png" alt=""></div>
                                <h2 class="modules__text">HSE</h2>
                            </div>
                            @endif
                            {{-- Calidad --}}
                            @if($tieneRolRestringidoUnico || $tieneSoloRolAlmacenista || $tieneSoloRolLideOperaciones || $tieneSoloRolTecnicojunior)
                            <div class="modules__card" onclick="noPermiso('Calidad')">
                                <div class="modules__circle"><img src="assets/Modulos/img/Calidad.png" alt=""></div>
                                <h2 class="modules__text">Calidad</h2>
                            </div>
                            @else
                            <div class="modules__card">
                                <div class="modules__circle"><img src="assets/Modulos/img/Calidad.png" alt=""></div>
                                <h2 class="modules__text">Calidad</h2>
                            </div>
                            @endif
                            {{-- Página web --}}
                            @if($tieneRolRestringidoUnico || $tieneSoloRolAlmacenista || $tieneSoloRolLideOperaciones || $tieneSoloRolTecnicojunior)
                            <div class="modules__card" onclick="noPermiso('Página web')">
                                <div class="modules__circle"><img src="assets/Modulos/img/sitoweb.png" alt=""></div>
                                <h2 class="modules__text">Página web</h2>
                            </div>
                            @else
                            <a href="{{ url('/mensajespaginaweb') }}" class="modules__link">
                                <div class="modules__card">
                                    <div class="modules__circle"><img src="assets/Modulos/img/sitoweb2.png" alt=""></div>
                                    <h2 class="modules__text">Página web</h2>
                                </div>
                            </a>
                            @endif
                        </div>


                    </div>

                    <div class="content__right">
                        <div class="softwares">
                            <div class="softwares__top">
                                <div class="softwares__card">
                                    <a href="https://sehilab-prueba.results-in-performance.com/" target="_blank">
                                        <img class="softwares__image" src="assets/Modulos/img/sehilab.png" alt="">
                                        <h3 class="content__paragraph">SEHILAB</h3>
                                    </a>
                                </div>
                                <div class="softwares__greyCard" onclick="window.open('https://wcle.results-in-performance.com/', '_blank')" style="cursor: pointer;">
                                    <h3 class="content__paragraph">WELL CONTROL</h3>
                                </div>

                            </div>

                            <div class="softwares__bottom">
                                <div class="softwares__greyCard">
                                    <!-- <img class="softwares__image" src="assets/Modulos/img/sehilab.png" alt=""> -->
                                    <h3 class="content__paragraph">TRAIN+</h3>
                                </div>
                                <div class="softwares__card">
                                    <!-- <img class="softwares__image" src="assets/Modulos/img/sehilab.png" alt=""> -->
                                    <h3 class="content__paragraph">RigCAP</h3>
                                </div>
                            </div>
                            <div class="learning">
                                <div class="learning__text">
                                    <h2 class="learning__title">E-learning</h2>
                                    <h2 class="learning__link">Saber más</h2>
                                </div>
                                <div class="learning__image">
                                    <img src="assets/Modulos/img/laptop.png" alt="">
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
            <img class="content__logo" src="assets/Modulos/img/logo.png" alt="">

        </div>


    </section>



    <!-- Modal -->

    <div id="modalAnuncio" style="display: none;" class="modal-anuncio">
        <div class="modal-contenido" onclick="event.stopPropagation()">
            <span class="cerrar" onclick="cerrarModal()">×</span>
            <img id="modalImagen" src="" alt="Imagen del anuncio" />
            <h2 id="modalTitulo"></h2>
            <p id="modalDescripcion"></p>
        </div>
    </div>




    <div id="modalInfoEmpresa" class="modal-overlay">
        <div class="modal-xl">

            <div class="modal-header">
                <h2 class="titulomodal">Información de la Empresa</h2>
                <span class="modal-close" id="cerrarModal">&times;</span>
            </div>

            <div class="modal-body">

                <div id="mensajeGeneralEmpresa" class="mensaje-general" style="display:none;"></div>

                <!-- DATOS GENERALES -->
                <section class="info-section">
                    <h3>Datos Generales</h3>
                    <div class="info-grid info-grid-4">
                        <div><span>RFC:</span> <span id="rfcEmpresa"></span></div>
                        <div><span>Razón Social:</span> <span id="razonSocial"></span></div>
                        <div><span>Régimen Capital:</span> <span id="regimenCapital"></span></div>
                        <div><span>Nombre Comercial:</span> <span id="nombreComercial"></span></div>
                    </div>
                </section>

                <!-- REPRESENTANTES -->
                <section class="info-section">
                    <h3>Representantes Legales</h3>
                    <div id="contenedorContactos"></div>
                </section>

                <!-- DOMICILIO -->
                <section class="info-section">
                    <h3>Domicilio Fiscal</h3>
                    <div id="contenedorDomicilio"></div>
                </section>

                <!-- SUCURSALES -->
                <section class="info-section" id="seccionSucursales" style="display:none;">
                    <h3>Sucursales</h3>
                    <div id="contenedorSucursales"></div>
                </section>

                <!-- USUARIO -->
                <section class="info-section">
                    <h3>Usuario del Sistema</h3>

                    <!-- NOTA -->
                    <p class="nota-usuarios">
                        📝 Para crear o administrar usuarios iniciales del sistema,
                        <a href="/usuario" class="link-usuarios">presione aquí</a>.
                    </p>

                    <!-- ROLES -->
                    <div class="roles roles-detalle">

                        <div class="rol-item">
                            <span class="role super">Superusuario</span>
                            <p class="rol-descripcion">
                                Tiene todos los permisos del sistema sin restricciones.
                            </p>
                        </div>

                        <div class="rol-item">
                            <span class="role admin">Administrador</span>
                            <p class="rol-descripcion">
                                Tiene todos los permisos del sistema, excepto eliminar usuarios con rol Superusuario.
                            </p>
                        </div>

                    </div>
                </section>


            </div>
        </div>
    </div>





    <style>
        :root {
            --pantone-rojo: #FF585D;
            --pantone-verde: #A4D65E;
            --pantone-azul: #007DBA;
            --pantone-azul-oscuro: #236192;
            --pantone-negro: #2C2A29;
            --pantone-blanco: #FFFFFF;
            --borde-suave: #e1e4e8;
        }

        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .55);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .modal-xl {
            width: 90%;
            max-width: 1200px;
            max-height: 90vh;
            background: #fff;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
        }

        .modal-header {
            background: var(--pantone-azul-oscuro);
            color: #fff;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
        }

        .modal-close {
            font-size: 24px;
            cursor: pointer;
        }

        .modal-body {
            padding: 20px;
            overflow-y: auto;
            background: #f6f8fa;
        }

        .contacto-item {
            background: #f9fafb;
            border-radius: 10px;
            padding: 18px;
            margin-bottom: 16px;
        }

        .contacto-item .info-grid {
            align-items: flex-start;
        }

        .contacto-item .info-grid>div span {
            display: block;
            color: var(--pantone-azul);
            font-weight: 600;
            font-size: 13px;
            margin-bottom: 4px;
        }

        .contacto-item .info-grid>div {
            font-size: 15px;
            color: var(--pantone-negro);
            line-height: 1.4;
        }

        .contacto-item .info-grid>div {
            min-height: 58px;
        }

        #contenedorContactos .info-grid>div span {
            display: block;
            color: var(--pantone-azul);
            font-weight: 600;
            font-size: 13px;
            margin-bottom: 6px;
        }

        #contenedorContactos .info-grid>div {
            font-size: 15px;
            color: var(--pantone-negro);
            line-height: 1.4;
        }

        #contenedorContactos .info-grid>div {
            min-height: 60px;
        }

        .info-section h3 {
            color: var(--pantone-azul);
            font-size: 16px;
            font-weight: 600;
            margin: 0 0 12px;
            padding-left: 10px;
            border-left: 4px solid var(--pantone-azul);
        }

        .info-section h3 {
            color: var(--pantone-azul);
        }

        .contacto-item {
            background: #f9fafb;
            border-radius: 8px;
            padding: 12px 14px;
            margin-bottom: 12px;
            border-left: 4px solid var(--pantone-azul);
            display: flex;
            align-items: flex-start;
        }

        .contacto-bullet {
            width: 10px;
            height: 10px;
            background: var(--pantone-azul);
            border-radius: 50%;
            margin: 6px 14px 0 0;
            flex-shrink: 0;
        }

        .contacto-item .info-grid-4 {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 20px;
            width: 100%;
        }

        .contacto-item .info-grid-4>div {
            display: flex;
            flex-direction: column;
        }

        .contacto-item .info-grid-4 span:first-child {
            font-size: 13px;
            font-weight: 600;
            color: var(--pantone-azul-oscuro);
            margin-bottom: 4px;
        }

        .contacto-item .info-grid-4 span:last-child {
            font-size: 14px;
            font-weight: 400;
            color: var(--pantone-negro);
            line-height: 1.4;
            word-break: break-word;
        }


        @media (max-width: 992px) {
            .contacto-item .info-grid-4 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .contacto-item .info-grid-4 {
                grid-template-columns: 1fr;
            }
        }

        .info-section .info-grid.info-grid-4 {
            gap: 25px;
        }

        .info-section .info-grid.info-grid-4>div {
            background: #f9fafb;
            border-radius: 8px;
            padding: 12px 14px;
            border-left: 4px solid var(--pantone-azul);
        }

        .info-section .info-grid.info-grid-4>div>span:first-child {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--pantone-azul-oscuro);
            margin-bottom: 4px;
        }

        .info-section .info-grid.info-grid-4>div>span:last-child {
            display: block;
            font-size: 14px;
            font-weight: 400;
            color: var(--pantone-negro);
            line-height: 1.4;
        }

        @media (max-width: 992px) {
            .info-grid-4 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .info-grid-4 {
                grid-template-columns: 1fr;
            }
        }

        .info-section {
            background: #fff;
            border: 1px solid var(--borde-suave);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .info-section h3 {
            margin: 0 0 10px;
            color: var(--pantone-azul);
            border-bottom: 2px solid var(--pantone-azul);
            padding-bottom: 4px;
        }

        .info-grid {
            display: grid;
            gap: 20px;
            font-size: 14px;
        }

        .info-grid span {
            font-weight: 600;
        }

        .info-grid-4 {
            grid-template-columns: repeat(4, 1fr);
        }

        .info-grid-3 {
            grid-template-columns: repeat(3, 1fr);
        }

        .contacto-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .contacto-bullet {
            width: 10px;
            height: 10px;
            background: var(--pantone-azul);
            border-radius: 50%;
            margin: 6px 12px 0 0;
        }

        .direccion-box {
            background: #f9fafb;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 6px;
        }

        .direccion-box.nacional {
            border-left: 4px solid var(--pantone-azul);
        }

        .direccion-box.extranjero {
            border-left: 4px solid var(--pantone-verde);
        }

        .direccion-box h4 {
            margin: 0 0 10px;
        }

        .sucursal-box {
            border: 1px dashed var(--pantone-azul);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .sucursal-title {
            text-align: center;
            font-weight: 700;
            color: var(--pantone-azul-oscuro);
            margin-bottom: 10px;
        }

        .roles {
            display: flex;
            gap: 10px;
        }

        .role {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            color: #fff;
        }

        .role.super {
            background: var(--pantone-rojo);
        }

        .role.admin {
            background: var(--pantone-verde);
            color: #000;
        }

        .no-wrap {
            white-space: nowrap;
        }

        .bloque-direccion {
            background: #f9fafb;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .bloque-direccion.nacional {
            border-left: 4px solid var(--pantone-azul);
        }

        .bloque-direccion.extranjero {
            border-left: 4px solid var(--pantone-verde);
        }

        .bloque-direccion h4 {
            margin: 0 0 12px;
            font-size: 14px;
            font-weight: 600;
        }

        .bloque-sucursal {
            border: 1px dashed var(--pantone-azul);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .bloque-sucursal h4 {
            text-align: center;
            margin: 0 0 12px;
            font-weight: 700;
            color: var(--pantone-azul-oscuro);
        }

        .sin-info {
            color: #6c757d;
            padding: 10px;
        }

        .nota-usuarios {
            font-size: 14px;
            background: #f9fafb;
            border-left: 4px solid var(--pantone-azul);
            padding: 10px 12px;
            margin-bottom: 15px;
            border-radius: 6px;
            color: var(--pantone-negro);
        }

        .link-usuarios {
            color: var(--pantone-azul);
            font-weight: 600;
            text-decoration: none;
        }

        .link-usuarios:hover {
            text-decoration: underline;
        }

        .roles-detalle {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .rol-item {
            background: #f9fafb;
            border-radius: 8px;
            padding: 12px 15px;
            flex: 1;
            min-width: 260px;
        }

        .rol-descripcion {
            margin-top: 8px;
            font-size: 13px;
            color: #555;
        }

        .mensaje-general {
            background: #fff3cd;
            border: 1px solid #ffeeba;
            color: #856404;
            padding: 15px;
            border-radius: 8px;
            font-size: 15px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
        }

        .titulomodal {

            color: #ffffff;

        }
    </style>





    <script>
        function noPermiso(modulo) {
            Swal.fire({
                icon: 'error',
                title: 'Acceso denegado',
                text: 'No tienes permiso para acceder al módulo de ' + modulo,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Entendido'
            });
        }
    </script>



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


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/assets/js_sitio/modulos.js?v=1.7"></script>
    <script src="/assets/js_sitio/notificaciones.js?v=1.0"></script>


    <!-- Jquery 3.6.4-->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</body>

</html>