<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <style>
        @page {
            margin: 20px;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }

        .text-center {
            text-align: center;
        }

        .fw-bold {
            font-weight: bold;
        }

        .card {
            margin-top: 10px;
        }

        .card-header {
            border: 1px solid #000;
            padding: 10px;
            font-weight: bold;
        }

        .card-body {
            border-left: 1px solid #000;
            border-right: 1px solid #000;
            border-bottom: 1px solid #000;
        }

        .header-res {
            background: #007DBA;
        }

        .header-verde {
            background: #A4D65E;
        }

        .header-azul {
            background: #b7c7d6;
        }

        .header-rojo {
            background: #f28b82;
        }

        .linea {

            border-bottom: 1px solid #000;
            height: 20px;
            width: 100%;
            margin-top: 5px;

        }

        .col-check {
            width: 70px;
            text-align: center;
        }

        .texto-pregunta {
            line-height: 1.5;
        }

        .check {
            font-size: 18px;
            font-weight: bold;
        }


        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        td {
            border: 1px solid #000;
            padding: 4px;
            vertical-align: top;
        }

        .texto-pregunta {
            font-size: 10px;
            line-height: 1.2;
        }

        .card-header {
            padding: 6px;
            font-size: 10px;
        }

        .card-body {
            padding: 0;
        }

        p {
            margin: 0;
        }

        .col-check {
            width: 55px;
            text-align: center;
        }

        .logo {
            display: block;
            margin-left: auto;
            margin-right: auto;
            max-width: 70px;
        }

        .check-box {

            display: inline-block;
            width: 12px;
            height: 12px;
            border: 1px solid #000;
            margin-right: 5px;
            vertical-align: middle;

        }
    </style>

</head>

<body>





    <table>

        <tr>

            <td width="20%" class="text-center">
                <img src="{{ public_path('assets/images/MARCAREGISTRADA.png') }}" class="logo" style="margin-top: 10px;">

            </td>

            <td width="60%" class="text-center">

                <div style="font-size:18px;font-weight:bold;">
                    <br>
                    <br>

                    FORMATO DE EVALUACIÓN ERGONÓMICA
                </div>



            </td>

            <td width="20%">

                <table>

                    <tr>

                    </tr>

                    <tr>

                    </tr>

                    <tr>
                        <td><b>Fecha</b></td>
                        <td>_____/_____/______</td>
                    </tr>

                </table>

            </td>

        </tr>

    </table>









    <div class="card">

        <div class="card-header header-verde">

            DATOS GENERALES DEL EMPLEADO

        </div>

        <div class="card-body">

            <table>

                <tr>

                    <td width="70%">

                        <b>Nombre del empleado</b>

                        <div class="linea"></div>

                    </td>

                    <td width="30%">

                        <b>Ficha / No empleado</b>

                        <div class="linea"></div>

                    </td>

                </tr>





                <tr>

                    <td>

                        <b>Sexo</b>

                        <div class="linea"></div>

                    </td>

                    <td>

                        <b>Fecha de nacimiento</b>

                        <div class="linea"></div>

                    </td>

                </tr>





                <tr>

                    <td>
                        <b>Categoría</b>


                        <div class="linea"></div>

                    </td>

                    <td>
                        <b>Edad</b>


                        <div class="linea"></div>

                    </td>

                </tr>





                <tr>

                    <td>

                        <b>Peso (kg)</b>

                        <div class="linea"></div>

                    </td>

                    <td>

                        <b>Talla (cm)</b>

                        <div class="linea"></div>

                    </td>

                </tr>





                <tr>

                    <td>

                        <b>Régimen Contractual</b>

                        <div class="linea"></div>

                    </td>

                    <td>

                        <b>Jornada</b>

                        <div class="linea"></div>

                    </td>

                </tr>





                <tr>

                    <td>

                        <b>Turno</b>

                        <div class="linea"></div>

                    </td>

                    <td>

                        <b>Tiempo en la empresa</b>

                        <div class="linea"></div>

                    </td>

                </tr>





                <tr>

                    <td colspan="2">

                        <b>Antigüedad en la categoría</b>

                        <div class="linea"></div>

                    </td>

                </tr>

            </table>

        </div>

    </div>









    <div class="card">

        <div class="card-header header-res text-center">

            1. NOM-036-1-STPS-2018

        </div>

        <div class="card-body">

            <table>

                <tr>

                    <td class="texto-pregunta" width="70%">

                        1. Durante su jornada laboral,
                        ¿levanta, baja, manipula objetos o materiales
                        con un peso mayor a 3 Kg?

                    </td>

                    <td class="col-check">
                        <span class="check-box"></span> SI
                    </td>

                    <td class="col-check">
                        <span class="check-box"></span> NO
                    </td>

                </tr>





                <tr>

                    <td class="texto-pregunta">

                        2. ¿Con qué frecuencia realiza actividades
                        que involucren el manejo manual de cargas
                        (más de una vez al día)?

                    </td>

                    <td class="col-check">
                        <span class="check-box"></span> SI
                    </td>

                    <td class="col-check">
                        <span class="check-box"></span> NO
                    </td>

                </tr>





                <tr>

                    <td class="texto-pregunta">

                        3. ¿Tiene que levantar, bajar, transportar,
                        empujar, jalar y/o estibar objetos o materiales
                        como parte de su trabajo?

                    </td>

                    <td class="col-check">
                        <span class="check-box"></span> SI
                    </td>

                    <td class="col-check">
                        <span class="check-box"></span> NO
                    </td>

                </tr>

            </table>

        </div>

    </div>




    {{-- ===================================================== --}}
    {{-- TEXTO MANIPULACIÓN --}}
    {{-- ===================================================== --}}

    <div class="card mt-2">

        <div class="card-header header-verde">

            <div class="text-center">
                <b>Manipulación manual de cargas</b>
            </div>

        </div>

        <div class="card-body p-2" style="line-height:1.6;">

            Cualquier operación de transporte o sujeción de una carga mayor a 3 kg
            por parte de uno o varios trabajadores,
            como el levantamiento,
            la colocación,
            el empuje,
            la tracción o el desplazamiento,
            que por sus características ergonómicas inadecuadas entrañe riesgo,
            en particular dorsolumbares,
            para los trabajadores.

        </div>

    </div>







    {{-- ===================================================== --}}
    {{-- LEVANTAMIENTO DE CARGAS --}}
    {{-- ===================================================== --}}

    <div class="card mt-2">

        <div class="card-header header-res">

            <div class="text-center">
                <b>2. Levantamiento de cargas</b>
            </div>

        </div>

    </div>








    {{-- ===================================================== --}}
    {{-- FICHA 1.1 --}}
    {{-- ===================================================== --}}

    <div class="card mt-3">

        <div class="card-header header-verde">

            <b>
                FICHA 1.1.- Evaluación Rápida para Identificar la presencia
                de condiciones aceptables (Zona verde)
                por LEVANTAMIENTO DE CARGAS.
            </b>

            <br><br>

            NOTA:
            Señale con una "X",
            cuando la condición verificada está presente
            (columna "SI")
            y cuando no está presente
            (columna "NO")

        </div>

        <div class="card-body">

            <table>

                <tr>

                    <td width="40" class="text-center fw-bold">
                        a.
                    </td>

                    <td class="texto-pregunta">

                        ¿Todas las cargas levantadas pesan 10 kg o menos?

                    </td>

                    <td width="55" class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td width="55" class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>





                <tr>

                    <td class="text-center fw-bold">
                        b.
                    </td>

                    <td class="texto-pregunta">

                        ¿El peso máximo de la carga está entre 3 kg y 5 kg
                        y la frecuencia de levantamientos
                        no excede de 5 levantamientos/minuto?

                        <br><br>

                        O bien,

                        <br><br>

                        ¿El peso máximo de la carga es de más de 5 kg
                        e inferior a los 10 kg
                        y la frecuencia no excede de 1 levantamiento/minuto?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>





                <tr>

                    <td class="text-center fw-bold">
                        c.
                    </td>

                    <td class="texto-pregunta">

                        ¿El desplazamiento vertical se realiza
                        entre la cadera y los hombros?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>





                <tr>

                    <td class="text-center fw-bold">
                        d.
                    </td>

                    <td class="texto-pregunta">

                        ¿El tronco está erguido,
                        sin flexión ni rotación?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>





                <tr>

                    <td class="text-center fw-bold">
                        e.
                    </td>

                    <td class="texto-pregunta">

                        ¿La carga se mantiene muy cerca del cuerpo
                        (no más de 10 cm de la parte frontal del torso)?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>

            </table>

            <div class="p-2" style="line-height:1.6;">

                Si a todas las preguntas ha contestado “SI”
                entonces la tarea tiene un riesgo aceptable
                y está en la Zona Verde.

                <br><br>

                Si alguna de las respuestas es “NO”,
                compruebe si se trata de una tarea
                con un nivel de riesgo inaceptable
                según la ficha 1.4.

            </div>

        </div>

    </div>





    <br><br>
    <br>




    {{-- ===================================================== --}}
    {{-- FICHA 1.4 --}}
    {{-- ===================================================== --}}

    <div class="card mt-3">

        <div class="card-header header-rojo text-center">

            <b>
                FICHA 1.4.
                Evaluación Rápida para identificar
                la presencia de condiciones inaceptables
                (Zona roja)
                por LEVANTAMIENTO DE CARGAS
            </b>

            <br><br>

            NOTA:
            Señale con una "X",
            cuando la condición verificada está presente
            (columna "SI")
            y cuando no está presente
            (columna "NO")

        </div>

        <div class="card-body">

            <table>

                <tr>

                    <td width="40" class="text-center fw-bold">
                        a.
                    </td>

                    <td class="texto-pregunta">

                        ¿La distancia vertical es superior a 175 cm
                        o está por debajo del nivel del suelo?

                    </td>

                    <td width="55" class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td width="55" class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>





                <tr>

                    <td class="text-center fw-bold">
                        b.
                    </td>

                    <td class="texto-pregunta">

                        ¿El desplazamiento vertical es superior a 175 cm?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>





                <tr>

                    <td class="text-center fw-bold">
                        c.
                    </td>

                    <td class="texto-pregunta">

                        ¿La distancia horizontal es superior a 63 cm
                        fuera del alcance máximo
                        (brazo completamente estirado hacia delante)?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>





                <tr>

                    <td class="text-center fw-bold">
                        d.
                    </td>

                    <td class="texto-pregunta">

                        ¿El ángulo de asimetría es superior a 135°?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>

            </table>

        </div>

    </div>









    {{-- ===================================================== --}}
    {{-- FICHA 1.3 --}}
    {{-- ===================================================== --}}

    <div class="card mt-3">

        <div class="card-header header-azul text-center">

            <b>
                FICHA 1.3.- Aspectos adicionales a considerar
            </b>

            <br><br>

            A cada una de las preguntas de cada apartado
            marque una "X"
            en la columna SI o NO

        </div>

        <div class="card-body">

            <table>

                <tr class="header-gris">

                    <td colspan="2" class="texto-pregunta fw-bold">

                        Condiciones ambientales de trabajo
                        para el levantamiento o transporte manual

                    </td>

                    <td width="80"></td>

                    <td width="80"></td>

                </tr>





                <tr>

                    <td width="40" class="text-center fw-bold">
                        a.
                    </td>

                    <td class="texto-pregunta">

                        ¿Hay presencia de baja o altas temperaturas?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>





                <tr>

                    <td class="text-center fw-bold">
                        b.
                    </td>

                    <td class="texto-pregunta">

                        ¿Hay presencia de suelo resbaladizo,
                        desigual o inestable?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>





                <tr>

                    <td class="text-center fw-bold">
                        c.
                    </td>

                    <td class="texto-pregunta">

                        ¿Está restringida la libre circulación
                        en el puesto de trabajo?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>

            </table>

        </div>

    </div>



    {{-- ===================================================== --}}
    {{-- TRANSPORTE DE CARGAS --}}
    {{-- ===================================================== --}}

    <div class="card mt-2">

        <div class="card-header header-res">

            <div class="text-center">
                <b>3. Transporte de cargas</b>
            </div>

        </div>

    </div>









    {{-- ===================================================== --}}
    {{-- FICHA 1.2 --}}
    {{-- ===================================================== --}}

    <div class="card mt-3">

        <div class="card-header header-verde">

            <b>
                FICHA 1.2.- Evaluación Rápida para Identificar
                la presencia de condiciones aceptables
                (Zona verde)
                por TRANSPORTE DE CARGAS.
            </b>

            <br><br>

            NOTA:
            Señale con una "X",
            cuando la condición verificada está presente
            (columna "SI")
            y cuando no está presente
            (columna "NO")

        </div>

        <div class="card-body">

            <table>

                <tr>

                    <td width="40" class="text-center fw-bold">
                        a.
                    </td>

                    <td class="texto-pregunta">

                        Si se requiere que una carga sea transportada manualmente
                        a una distancia inferior o igual a 10 m, responda:

                        <br><br>

                        ¿La masa acumulada transportada manualmente
                        (peso total de todas las cargas)
                        es menor de 10.000 kg en 8 horas?

                        <br><br>

                        Y

                        <br><br>

                        ¿La masa acumulada transportada manualmente
                        (peso total de todas las cargas)
                        es menor de 1.500 kg en 1 hora?

                        <br><br>

                        Y

                        <br><br>

                        ¿La masa acumulada transportada manualmente
                        (peso total de todas las cargas)
                        es menor de 30 kg en 1 minuto?

                    </td>

                    <td width="55" class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td width="55" class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>







                <tr>

                    <td class="text-center fw-bold">
                        b.
                    </td>

                    <td class="texto-pregunta">

                        Si se requiere que una carga sea transportada manualmente
                        a una distancia superior a 10 m, responda:

                        <br><br>

                        ¿La masa acumulada transportada manualmente
                        (peso total de todas las cargas)
                        es menor de 6.000 kg en 8 horas?

                        <br><br>

                        Y

                        <br><br>

                        ¿La masa acumulada transportada manualmente
                        (peso total de todas las cargas)
                        es menor de 750 kg en 1 hora?

                        <br><br>

                        Y

                        <br><br>

                        ¿La masa acumulada transportada manualmente
                        (peso total de todas las cargas)
                        es menor de 15 kg en 1 minuto?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>







                <tr>

                    <td class="text-center fw-bold">
                        c.
                    </td>

                    <td class="texto-pregunta">

                        ¿El transporte de la carga
                        se realiza sin posturas forzadas?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>

            </table>

            <div class="p-2" style="line-height:1.6;">

                Si a las preguntas “a” o “b”,
                y a la pregunta “c”
                ha contestado “SI”
                entonces la tarea tiene un riesgo aceptable
                y está en la Zona Verde.

                <br><br>

                Si alguna de las respuestas es “NO”,
                compruebe si se trata de una tarea
                con un nivel de riesgo inaceptable
                según la ficha 1.5.

            </div>

        </div>

    </div>









    {{-- ===================================================== --}}
    {{-- FICHA 1.5 --}}
    {{-- ===================================================== --}}

    <div class="card mt-3">

        <div class="card-header header-rojo text-center">

            <b>
                FICHA 1.5.
                Evaluación Rápida para identificar
                la presencia de condiciones inaceptables
                (Zona roja)
                por TRANSPORTE DE CARGAS
            </b>

            <br><br>

            NOTA:
            Señale con una "X",
            cuando la condición verificada está presente
            (columna "SI")
            y cuando no está presente
            (columna "NO")

        </div>

        <div class="card-body">

            <table>

                <tr>

                    <td width="40" class="text-center fw-bold">
                        a.
                    </td>

                    <td class="texto-pregunta">

                        ¿Se manipula una masa acumulada
                        (peso total de todas las cargas)
                        de más de 10.000 kg en 8 horas,
                        en una distancia menor a 20 metros?

                    </td>

                    <td width="55" class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td width="55" class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>







                <tr>

                    <td class="text-center fw-bold">
                        b.
                    </td>

                    <td class="texto-pregunta">

                        ¿Se manipula una masa acumulada
                        (peso total de todas las cargas)
                        de más de 6.000 kg en 8 horas,
                        en una distancia igual o superior a 20 metros?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>

            </table>

        </div>

    </div>


    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    {{-- ===================================================== --}}
    {{-- EMPUJE Y TRACCIÓN DE CARGAS --}}
    {{-- ===================================================== --}}

    <div class="card mt-2">

        <div class="card-header header-res">

            <div class="text-center">
                <b>4. Empuje y tracción de cargas</b>
            </div>

        </div>

    </div>


    {{-- ===================================================== --}}
    {{-- FICHA 2.1 --}}
    {{-- ===================================================== --}}

    <div class="card mt-3">

        <div class="card-header header-verde">

            <b>
                FICHA 2.1.- Evaluación Rápida para Identificar
                la presencia de condiciones aceptables
                (Zona verde)
                por EMPUJE Y TRACCIÓN DE CARGAS.
            </b>

            <br><br>

            NOTA:
            Señale con una "X",
            cuando la condición verificada está presente
            (columna "SI")
            y cuando no está presente
            (columna "NO")

        </div>

        <div class="card-body">

            <table>

                <tr>

                    <td width="40" class="text-center fw-bold">
                        a.
                    </td>

                    <td class="texto-pregunta">

                        ¿La fuerza requerida en el empuje o tracción
                        es inferior a “Moderada”
                        (en la Escala de Borg menor a 3)?

                        <br><br>

                        O

                        <br><br>

                        ¿La fuerza requerida en el empuje o tracción
                        no supera los 30 N en fuerza continua (sostenida)
                        y no supera los 100 N en los picos de fuerza?

                        <br><br>

                        O

                        <br><br>

                        ¿La fuerza requerida en el empuje o tracción
                        no supera los 50 N
                        cuando la frecuencia es menor
                        1 acción cada 5 minutos
                        en una distancia de recorrido inferior a 50 m?

                    </td>

                    <td width="55" class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td width="55" class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>







                <tr>

                    <td class="text-center fw-bold">
                        b.
                    </td>

                    <td class="texto-pregunta">

                        ¿La fuerza de empuje o tracción
                        se aplica a una altura de agarre
                        entre la cadera y la mitad del pecho?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>







                <tr>

                    <td class="text-center fw-bold">
                        c.
                    </td>

                    <td class="texto-pregunta">

                        ¿La acción de empuje o tracción
                        se realiza con el tronco erguido
                        (sin torsión ni flexión)?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>







                <tr>

                    <td class="text-center fw-bold">
                        d.
                    </td>

                    <td class="texto-pregunta">

                        ¿La tarea de empuje o tracción
                        se realiza durante menos de 8 horas al día?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>

            </table>

            <div class="p-2" style="line-height:1.6;">

                Si a todas las preguntas ha contestado “SI”
                entonces la tarea tiene un riesgo aceptable
                y está en la Zona Verde.

                <br><br>

                Si alguna de las respuestas es “NO”,
                compruebe si se trata de una tarea
                con un nivel de riesgo inaceptable
                según la ficha 2.3.

            </div>

        </div>

    </div>









    {{-- ===================================================== --}}
    {{-- FICHA 2.3 --}}
    {{-- ===================================================== --}}

    <div class="card mt-3">

        <div class="card-header header-rojo text-center">

            <b>
                FICHA 2.3.
                Evaluación Rápida para identificar
                la presencia de condiciones inaceptables
                (Zona roja)
                por EMPUJE Y TRACCIÓN DE CARGAS
            </b>

            <br><br>

            NOTA:
            Señale con una "X",
            cuando la condición verificada está presente
            (columna "SI")
            y cuando no está presente
            (columna "NO")

        </div>

        <div class="card-body">

            <table>

                <tr>

                    <td width="40" class="text-center fw-bold">
                        a.
                    </td>

                    <td class="texto-pregunta">

                        ¿La fuerza requerida en el empuje o tracción
                        es “Muy intensa” o superior
                        (Escala de Borg mayor o igual a 8)?

                        <br><br>

                        O

                        <br><br>

                        ¿La fuerza requerida en el empuje o tracción
                        para iniciar el movimiento
                        es 360 N o más para hombres,
                        o de 240 N o más para mujeres?

                        <br><br>

                        O

                        <br><br>

                        ¿La fuerza requerida
                        para el empuje o tracción
                        para mantener el movimiento
                        es de 250 N o más para hombres
                        o de 150 N o más mujeres?

                    </td>

                    <td width="55" class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td width="55" class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>







                <tr>

                    <td class="text-center fw-bold">
                        b.
                    </td>

                    <td class="texto-pregunta">

                        ¿La fuerza de empuje o tracción
                        se aplica a una altura de agarre
                        superior a 150 cm
                        o menor a 60 cm?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>







                <tr>

                    <td class="text-center fw-bold">
                        c.
                    </td>

                    <td class="texto-pregunta">

                        ¿La acción de empuje o tracción
                        se realiza con el tronco flexionado
                        o en torsión?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>







                <tr>

                    <td class="text-center fw-bold">
                        d.
                    </td>

                    <td class="texto-pregunta">

                        ¿Se realiza la tarea
                        de empuje o tracción
                        durante más de 8 horas al día?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>

            </table>

        </div>

    </div>









    {{-- ===================================================== --}}
    {{-- FICHA 2.2 --}}
    {{-- ===================================================== --}}

    <div class="card mt-3">

        <div class="card-header header-azul text-center">

            <b>
                FICHA 2.2.- Aspectos adicionales a considerar
            </b>

            <br><br>

            A cada una de las preguntas
            de cada apartado
            marque una "X"
            en la columna SI o NO

        </div>

        <div class="card-body">

            <table>

                <tr class="header-gris">

                    <td colspan="2" class="texto-pregunta fw-bold">

                        Condiciones ambientales de trabajo

                    </td>

                    <td width="80"></td>

                    <td width="80"></td>

                </tr>







                <tr>

                    <td width="40" class="text-center fw-bold">
                        a.
                    </td>

                    <td class="texto-pregunta">

                        ¿Las superficies de los suelos
                        son resbaladizas,
                        inestables,
                        irregulares,
                        con pendientes,
                        o presentan fisuras,
                        grietas
                        o están rotas?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>







                <tr>

                    <td class="text-center fw-bold">
                        b.
                    </td>

                    <td class="texto-pregunta">

                        ¿Hay restricciones
                        o limitaciones para desplazarse?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>







                <tr>

                    <td class="text-center fw-bold">
                        c.
                    </td>

                    <td class="texto-pregunta">

                        ¿Hay rampas
                        o cuestas con mucha pendiente?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>







                <tr>

                    <td class="text-center fw-bold">
                        d.
                    </td>

                    <td class="texto-pregunta">

                        ¿La temperatura ambiental
                        no es adecuada
                        (por frío o calor)?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>







                <tr>

                    <td class="text-center fw-bold">
                        e.
                    </td>

                    <td class="texto-pregunta">

                        ¿Los espacios son confinados,
                        insuficientes para girar,
                        puertas estrechas, etc.?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>

            </table>

        </div>

    </div>


    {{-- ===================================================== --}}
    {{-- MOVIMIENTO REPETITIVO --}}
    {{-- ===================================================== --}}

    <div class="card mt-5">

        <div class="card-header header-verde">

            <div class="text-center">
                <b>Movimiento repetitivo</b>
            </div>

        </div>

        <div class="card-body p-2" style="line-height:1.6;">

            Tarea caracterizada por tener un ciclo de trabajo que se repite.
            Está caracterizada por la presencia de ciclos
            con acciones técnicas
            que deben ser realizadas
            por las extremidades superiores.

        </div>

    </div>









    {{-- ===================================================== --}}
    {{-- MOVIMIENTOS REPETITIVOS --}}
    {{-- ===================================================== --}}

    <div class="card mt-2">

        <div class="card-header header-res">

            <div class="text-center">
                <b>5. Movimientos repetitivos de la extremidad superior</b>
            </div>

        </div>

    </div>









    {{-- ===================================================== --}}
    {{-- FICHA 3.1 --}}
    {{-- ===================================================== --}}

    <div class="card mt-3">

        <div class="card-header header-verde text-center">

            <b>
                FICHA 3.1.- Evaluación Rápida para Identificar
                la presencia de condiciones aceptables
                (Zona verde)
                por MOVIMIENTOS REPETITIVOS
                DE LA EXTREMIDAD SUPERIOR.
            </b>

            <br><br>

            NOTA:
            Señale con una "X",
            cuando la condición verificada está presente
            (columna "SI")
            y cuando no está presente
            (columna "NO")

        </div>

        <div class="card-body">

            <table>

                <tr>

                    <td width="40" class="text-center fw-bold">
                        a.
                    </td>

                    <td class="texto-pregunta">

                        ¿Las extremidades superiores están inactivas
                        por más del 50% del tiempo total
                        del trabajo repetitivo
                        (se considera como tiempo de inactividad
                        de la extremidad superior
                        cuando el trabajador camina con las manos vacías,
                        o lee,
                        o hace control visual,
                        o espera que la máquina concluya el trabajo, etc.)?

                    </td>

                    <td width="55" class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td width="55" class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>







                <tr>

                    <td class="text-center fw-bold">
                        b.
                    </td>

                    <td class="texto-pregunta">

                        ¿Ninguno de los brazos trabaja
                        con el codo casi a la altura del hombro
                        por más del 10%
                        del tiempo de trabajo repetitivo?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>







                <tr>

                    <td class="text-center fw-bold">
                        c.
                    </td>

                    <td class="texto-pregunta">

                        ¿La fuerza necesaria para realizar el trabajo
                        es menor a moderada (es ligera)?

                        <br><br>

                        O bien,

                        <br><br>

                        ¿Si la fuerza es moderada,
                        no supera el 25%
                        del tiempo de trabajo repetitivo?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>







                <tr>

                    <td class="text-center fw-bold">
                        d.
                    </td>

                    <td class="texto-pregunta">

                        ¿Están ausentes los picos de fuerza
                        (más que Moderada en la Escala Borg)?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>







                <tr>

                    <td class="text-center fw-bold">
                        e.
                    </td>

                    <td class="texto-pregunta">

                        ¿Hay pausas de duración
                        al menos 8 min cada 2 horas?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>







                <tr>

                    <td class="text-center fw-bold">
                        f.
                    </td>

                    <td class="texto-pregunta">

                        ¿La(s) tarea(s)
                        de trabajo repetitivo
                        se realiza durante menos de 8 horas al día?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>

            </table>

            <div class="p-2" style="line-height:1.6;">

                Si a todas las preguntas ha contestado “SI”
                entonces la tarea tiene un riesgo aceptable
                y está en la Zona Verde.

                <br><br>

                Si alguna de las respuestas es “NO”,
                compruebe si se trata de una tarea
                con un nivel de riesgo inaceptable
                según la ficha 3.2.

            </div>

        </div>

    </div>









    {{-- ===================================================== --}}
    {{-- FICHA 3.2 --}}
    {{-- ===================================================== --}}

    <div class="card mt-3">

        <div class="card-header header-rojo text-center">

            <b>
                FICHA 3.2.
                Evaluación Rápida para identificar
                la presencia de condiciones inaceptables
                (Zona roja)
                por MOVIMIENTOS REPETITIVOS
                DE LA EXTREMIDAD SUPERIOR
            </b>

            <br><br>

            NOTA:
            Señale con una "X",
            cuando la condición verificada está presente
            (columna "SI")
            y cuando no está presente
            (columna "NO")

        </div>

        <div class="card-body">

            <table>

                <tr>

                    <td width="40" class="text-center fw-bold">
                        a.
                    </td>

                    <td class="texto-pregunta">

                        ¿Las acciones técnicas
                        de una extremidad
                        son tan rápidas
                        que no es posible contarlas?

                    </td>

                    <td width="55" class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td width="55" class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>







                <tr>

                    <td class="text-center fw-bold">
                        b.
                    </td>

                    <td class="texto-pregunta">

                        ¿Un brazo o ambos trabajan
                        con el codo casi a la altura del hombro
                        por la mitad o más
                        del tiempo de trabajo repetitivo?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>







                <tr>

                    <td class="text-center fw-bold">
                        c.
                    </td>

                    <td class="texto-pregunta">

                        ¿Se realizan picos de fuerza
                        (Fuerza intensa o más en la escala Borg)
                        durante el 5% o más
                        del tiempo de trabajo repetitivo?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>







                <tr>

                    <td class="text-center fw-bold">
                        d.
                    </td>

                    <td class="texto-pregunta">

                        ¿Se requiere el agarre de objetos
                        con los dedos
                        (agarre de precisión)
                        durante más del 80%
                        del tiempo de trabajo repetitivo?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>







                <tr>

                    <td class="text-center fw-bold">
                        e.
                    </td>

                    <td class="texto-pregunta">

                        En turnos de 6 horas o más,
                        ¿sólo tiene una pausa o ninguna?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>







                <tr>

                    <td class="text-center fw-bold">
                        f.
                    </td>

                    <td class="texto-pregunta">

                        ¿El tiempo de trabajo repetitivo
                        es superior a 8 horas en el turno?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>

            </table>

        </div>

    </div>


    {{-- ===================================================== --}}
    {{-- POSTURA ESTÁTICA --}}
    {{-- ===================================================== --}}

    <div class="card mt-5">

        <div class="card-header header-verde">

            <div class="text-center">
                <b>Postura estática</b>
            </div>

        </div>

        <div class="card-body p-2" style="line-height:1.6;">

            Posición que se realiza
            con una contracción muscular prolongada
            sin producir movimiento
            durante por lo menos 4 segundos
            de manera consecutiva.

        </div>

    </div>









    {{-- ===================================================== --}}
    {{-- POSTURAS ESTÁTICAS FORZADAS --}}
    {{-- ===================================================== --}}

    <div class="card mt-2">

        <div class="card-header header-res">

            <div class="text-center">
                <b>6. Posturas estáticas forzadas</b>
            </div>

        </div>

    </div>









    {{-- ===================================================== --}}
    {{-- FICHA 4.1 --}}
    {{-- ===================================================== --}}

    <div class="card mt-3">

        <div class="card-header header-verde text-center">

            <b>
                FICHA 4.1.- Evaluación Rápida para Identificar
                la presencia de condiciones aceptables
                (Zona verde)
                por POSTURAS ESTÁTICAS FORZADAS
            </b>

            <br><br>

            NOTA:
            Señale con una "X",
            cuando la condición verificada está presente
            (columna "SI")
            y cuando no está presente
            (columna "NO")

        </div>

        <div class="card-body">

            <table>

                <tr class="header-gris">

                    <td colspan="2" class="texto-pregunta fw-bold">

                        Cabeza y tronco

                    </td>

                    <td width="80"></td>

                    <td width="80"></td>

                </tr>







                <tr>

                    <td width="40" class="text-center fw-bold">
                        a.
                    </td>

                    <td class="texto-pregunta">

                        ¿El tronco está erguido,
                        o si está flexionado o en extensión
                        el ángulo no supera los 20°?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>







                <tr>

                    <td class="text-center fw-bold">
                        b.
                    </td>

                    <td class="texto-pregunta">

                        ¿El cuello está recto,
                        o si está flexionado o en extensión
                        el ángulo no supera los 25°?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>







                <tr>

                    <td class="text-center fw-bold">
                        c.
                    </td>

                    <td class="texto-pregunta">

                        ¿La cabeza está recta,
                        o si está inclinada lateralmente
                        el ángulo no supera los 25°?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>









                <tr class="header-gris">

                    <td colspan="2" class="texto-pregunta fw-bold">

                        Extremidad Superior

                    </td>

                    <td></td>

                    <td></td>

                </tr>







                <tr>

                    <td class="text-center fw-bold">
                        d.
                    </td>

                    <td class="texto-pregunta">

                        ¿El brazo está sin apoyo
                        y la flexión no supera el ángulo de 20°?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>







                <tr>

                    <td class="text-center fw-bold">
                        e.
                    </td>

                    <td class="texto-pregunta">

                        ¿El brazo está con apoyo
                        y la flexión no supera el ángulo de 60°?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>







                <tr>

                    <td class="text-center fw-bold">
                        f.
                    </td>

                    <td class="texto-pregunta">

                        ¿El codo realiza flexo-extensiones
                        o prono-supinaciones
                        no extremas (pequeñas)?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>







                <tr>

                    <td class="text-center fw-bold">
                        g.
                    </td>

                    <td class="texto-pregunta">

                        ¿La muñeca está en posición neutra
                        o no realiza desviaciones extremas
                        (flexión,
                        extensión,
                        desviación radial
                        o ulnar)?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>









                <tr class="header-gris">

                    <td colspan="2" class="texto-pregunta fw-bold">

                        Extremidad Inferior

                    </td>

                    <td></td>

                    <td></td>

                </tr>







                <tr>

                    <td class="text-center fw-bold">
                        h.
                    </td>

                    <td class="texto-pregunta">

                        ¿Las flexiones extremas
                        de rodilla
                        están ausentes?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>







                <tr>

                    <td class="text-center fw-bold">
                        i.
                    </td>

                    <td class="texto-pregunta">

                        ¿Las dorsiflexiones
                        y flexiones plantares de tobillo extremas
                        están ausentes?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>







                <tr>

                    <td class="text-center fw-bold">
                        j.
                    </td>

                    <td class="texto-pregunta">

                        ¿Las posturas de rodillas
                        y cuclillas
                        están ausentes?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>







                <tr>

                    <td class="text-center fw-bold">
                        k.
                    </td>

                    <td class="texto-pregunta">

                        Si la postura es sentado,
                        ¿el ángulo de rodilla
                        está entre 55° y 135°?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>

            </table>

        </div>

    </div>




    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    {{-- ===================================================== --}}
    {{-- POSTURA DINÁMICA --}}
    {{-- ===================================================== --}}

    <div class="card mt-5">

        <div class="card-header header-verde">

            <div class="text-center">
                <b>Postura dinámica</b>
            </div>

        </div>

        <div class="card-body p-2" style="line-height:1.6;">

            Posición corporal
            que se realiza
            con una contracción
            de diferentes grupos musculares
            y con cambios
            en los movimientos
            de las articulaciones.

        </div>

    </div>









    {{-- ===================================================== --}}
    {{-- POSTURAS DINÁMICAS FORZADAS --}}
    {{-- ===================================================== --}}

    <div class="card mt-2">

        <div class="card-header header-res">

            <div class="text-center">
                <b>7. Posturas dinámicas forzadas</b>
            </div>

        </div>

    </div>








    {{-- ===================================================== --}}
    {{-- FICHA 4.2 --}}
    {{-- ===================================================== --}}

    <div class="card mt-3">

        <div class="card-header header-verde text-center">

            <b>
                FICHA 4.2.- Evaluación Rápida para Identificar
                la presencia de condiciones aceptables
                (Zona verde)
                por POSTURAS DINÁMICAS FORZADAS
            </b>

            <br><br>

            NOTA:
            Señale con una "X",
            cuando la condición verificada está presente
            (columna "SI")
            y cuando no está presente
            (columna "NO")

        </div>

        <div class="card-body">

            <table>

                <tr>

                    <td width="40" class="text-center fw-bold">
                        a.
                    </td>

                    <td class="texto-pregunta">

                        ¿El tronco está erguido,
                        o realiza flexiones o extensiones
                        sin superar el ángulo de 20°?

                    </td>

                    <td width="55" class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td width="55" class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>







                <tr>

                    <td class="text-center fw-bold">
                        b.
                    </td>

                    <td class="texto-pregunta">

                        ¿El tronco está erguido,
                        o realiza inclinaciones laterales
                        o torsión
                        sin superar el ángulo de 10°?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>







                <tr>

                    <td class="text-center fw-bold">
                        c.
                    </td>

                    <td class="texto-pregunta">

                        ¿La cabeza está recta,
                        o realiza inclinaciones laterales
                        sin superar el ángulo de 10°?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>







                <tr>

                    <td class="text-center fw-bold">
                        d.
                    </td>

                    <td class="texto-pregunta">

                        ¿La cabeza está recta,
                        o realiza torsión del cuello
                        sin superar el ángulo de 45°?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>







                <tr>

                    <td class="text-center fw-bold">
                        e.
                    </td>

                    <td class="texto-pregunta">

                        ¿El cuello está recto
                        o realiza flexiones
                        entre 0° y 40°?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>







                <tr>

                    <td class="text-center fw-bold">
                        f.
                    </td>

                    <td class="texto-pregunta">

                        ¿Los brazos están neutros,
                        o realizan flexión o abducción
                        sin superar el ángulo de 20°?

                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> NO
                    </td>

                    <td class="text-center">
                        <span class="check-box"></span> SI
                    </td>

                </tr>

            </table>

        </div>

    </div>
</body>

</html>