@extends('principal.maestra')

@section('contenido')


<style>
    .multisteps-form__progress {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        margin-bottom: 20px;
        width: 100%;
        height: 40px;
    }

    .multisteps-form__progress-btn {
        position: relative;
        z-index: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        font-size: 14px;
        color: #f3f3f3;
        flex: 1;
        text-align: center;
    }

    .step-circle {
        width: 49px;
        height: 49px;
        border-radius: 50%;
        background-color: #fffdfd;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 5px;
        position: relative;
        z-index: 1;
    }

    .step-circle i {
        font-size: 24px;
        color: #c9c4c4;
    }

    .texto-seleccionado {
        color: #0d6efd;
        font-weight: bold;
    }

    .texto-no-seleccionado {
        color: gray;
    }

    .texto-no-seleccionado:hover {
        text-decoration: underline;
    }

    .text-warning {
        color: orange !important;
    }

    .text-success {
        color: green !important;
    }

    .estado-verde {
        background-color: #d4edda !important;
        color: black;
        border-radius: 0.25rem;
    }

    .estado-amarillo {
        background-color: #fff3cd !important;
        color: black;
        border-radius: 0.25rem;
    }

    .estado-rojo {
        background-color: #f8d7da !important;
        color: black;
        border-radius: 0.25rem;
    }

    .bloque-renovacion,
    .bloque-adenda {
        min-height: 93px;
        flex-direction: column;
        justify-content: center;
    }

    .bloque-contrato,
    .bloque-adenda-contrato {
        min-height: 93px;
        flex-direction: column;
        justify-content: center;
    }
</style>







<div class="contenedor-contenido">





    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="contratos-tab" data-toggle="tab" href="#contratos" role="tab" aria-controls="contratos" aria-selected="true">Expediente</a>
                </li>
                <li class="nav-item" style="display: none;">
                    <a class="nav-link" id="datosgenerales-tab" data-toggle="tab" href="#datosgenerales" role="tab" aria-controls="datosgenerales" aria-selected="false">Datos generales</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="myTabContent">

                <!-- Lista de contratos Tab -->
                <div class="tab-pane fade show active" id="contratos" role="tabpanel" aria-labelledby="contratos-tab">
                    <ol class="breadcrumb mb-5" style="display: flex; justify-content: center; align-items: center;">
                        <h3 style="color: #ffffff; margin: 0;">
                            <i class="bi bi-folder2-open"></i>&nbsp;&nbsp;Expediente {{ Auth::user()->EMPLEADO_NOMBRE }} {{ Auth::user()->EMPLEADO_APELLIDOPATERNO }} {{ Auth::user()->EMPLEADO_APELLIDOMATERNO }}
                        </h3>
                    </ol>
                    <div class="card-body position-relative" style="display: block;">
                        <i id="loadingIcon8" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                        <table id="Tablaexpediente" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
                        </table>
                    </div>

                </div>


                <!-- Datos Generales Tab -->
                <div class="tab-pane fade" id="datosgenerales" role="tabpanel" aria-labelledby="datosgenerales-tab">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body" style="padding: 6px 10px;">
                                    <table class="table" style="border: px #000 solid; margin: 0px;">
                                        <tbody>
                                            <tr>
                                                <td width="auto" style="text-align: left; border: none; vertical-align: middle;">
                                                    <h7 style="margin: 0px;">
                                                        <i class="bi bi-person-circle"></i>&nbsp;&nbsp; <span class="text-primary div_trabajador_nombre">NOMBRE DEL COLABORADOR</span>
                                                    </h7>
                                                    <br>
                                                    <i class="bi bi-person-lines-fill" aria-hidden="true"></i>&nbsp; <span class="text-primary div_trabajador_cargo" style="color: #AAAAAA; font-size: 12px;">Cargo</span> &nbsp;
                                                    <br>
                                                    <i class="bi bi-list-ol" aria-hidden="true"></i> &nbsp; <span class="text-primary div_trabajador_numeoro" style="color: #AAAAAA; font-size: 12px;">Número</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-12 mt-5">
                            <div class="multisteps-form">
                                <div class="multisteps-form__progress">
                                    <div class="multisteps-form__progress-btn js-active" id="step1">
                                        <div class="step-circle">
                                            <i class="bi bi-briefcase-fill"></i>
                                        </div>
                                        <span>Datos generales</span>
                                    </div>
                                    <div class="multisteps-form__progress-btn" id="step2">
                                        <div class="step-circle">
                                            <i class="bi bi-file-earmark-text-fill"></i>
                                        </div>
                                        <span>Documentos del colaborador</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                    <!-- Step 1 de Datos Generales -->
                    <div id="step1-content" style="display: block;">
                        <ol class="breadcrumb mt-5 d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center;">
                            <h3 style="color: #ffffff; margin: 0;">
                                <i class="bi bi-person"></i>&nbsp;&nbsp;Información del colaborador
                            </h3>

                        </ol>

                        <!-- Formulario de Datos Generales -->
                        <form method="post" enctype="multipart/form-data" id="FormularioCONTRATACION">
                            {!! csrf_field() !!}
                            <div class="row">

                                <div class="col-9">
                                    <div class="row">

                                        <div class="col-4 mb-3">
                                            <label>Nombre(s) del colaborador *</label>
                                            <input type="text" class="form-control" id="NOMBRE_COLABORADOR" name="NOMBRE_COLABORADOR" required>
                                        </div>

                                        <div class="col-4 mb-3">
                                            <label>Primer apellido *</label>
                                            <input type="text" class="form-control" id="PRIMER_APELLIDO" name="PRIMER_APELLIDO" required>
                                        </div>

                                        <div class="col-4 mb-3">
                                            <label>Segundo apellido *</label>
                                            <input type="text" class="form-control" id="SEGUNDO_APELLIDO" name="SEGUNDO_APELLIDO" required>
                                        </div>

                                        <div class="col-5 mb-3">
                                            <label>CURP *</label>
                                            <input type="text" class="form-control" id="CURP" name="CURP" required>
                                        </div>

                                        <div class="col-5 mb-3">
                                            <label>No. Empleado *</label>
                                            <input type="number" class="form-control" id="NUMERO_EMPLEADO" name="NUMERO_EMPLEADO" required>
                                        </div>


                                        <div class="col-2 mb-3">
                                            <label>Iniciales</label>
                                            <input type="text" class="form-control" id="INICIALES_COLABORADOR" name="INICIALES_COLABORADOR">
                                        </div>
                                        {{-- <div class="col-12 mb-3 text-center">
                                        <label>Fecha de nacimiento</label>
                                    </div> --}}

                                        <div class="col-3 mb-3">
                                            <label></label>
                                            <select class="form-select me-2" id="DIA_COLABORADOR" name="DIA_COLABORADOR" required>
                                                <option value="" selected disabled>Día</option>
                                                <script>
                                                    for (let i = 1; i <= 31; i++) {
                                                        document.write('<option value="' + i + '">' + i + '</option>');
                                                    }
                                                </script>
                                            </select>
                                        </div>
                                        <div class="col-3 mb-3 text-center">
                                            <label>Fecha de nacimiento</label>
                                            <select class="form-select me-2" id="MES_COLABORADOR" name="MES_COLABORADOR" required>
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
                                        </div>

                                        <div class="col-3 mb-3">
                                            <label></label>
                                            <select class="form-select me-2" id="ANIO_COLABORADOR" name="ANIO_COLABORADOR" required>
                                                <option value="" selected disabled>Año</option>
                                                <script>
                                                    const currentYear = new Date().getFullYear();
                                                    for (let i = currentYear; i >= 1900; i--) {
                                                        document.write('<option value="' + i + '">' + i + '</option>');
                                                    }
                                                </script>
                                            </select>
                                        </div>
                                        <div class="col-3 mb-3">
                                            <label>Edad</label>
                                            <input type="number" class="form-control" id="EDAD_COLABORADOR" name="EDAD_COLABORADOR" readonly>
                                        </div>

                                        <div class="col-3 mb-3">
                                            <label>Teléfono *</label>
                                            <input type="number" class="form-control" id="TELEFONO_COLABORADOR" name="TELEFONO_COLABORADOR" required>
                                        </div>
                                        <div class="col-3 mb-3">
                                            <label for="correo">Correo *</label>
                                            <input type="email" class="form-control" id="CORREO_COLABORADOR" name="CORREO_COLABORADOR" required>
                                        </div>
                                        <div class="col-3 mb-3">
                                            <label for="estadoCivil">Estado Civil *</label>
                                            <select class="form-control" id="ESTADO_CIVIL" name="ESTADO_CIVIL" required>
                                                <option value="0" disabled selected>Seleccione una opción</option>
                                                <option value="1">Soltero (a)</option>
                                                <option value="2">Casado (a)</option>
                                                <option value="3">Divorciado (a)</option>
                                                <option value="4">Viudo (a)</option>
                                                <option value="5">Unión libre</option>

                                            </select>
                                        </div>
                                        <div class="col-3 mb-3">
                                            <label>RFC *</label>
                                            <input type="text" class="form-control" id="RFC_COLABORADOR" name="RFC_COLABORADOR" required>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-3">
                                    <div class="form-group">
                                        <label id="FOTO_TITULO">Foto colaborador (.png)*</label>
                                        <style>
                                            .dropify-wrapper {
                                                height: 270px !important;
                                                border-radius: 5px;
                                                box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
                                                text-align: center;
                                            }

                                            .dropify-message p {
                                                font-size: 14px;
                                                margin: 0;
                                            }
                                        </style>
                                        <input type="file"
                                            accept="image/png"
                                            id="FOTO_USUARIO"
                                            name="FOTO_USUARIO"
                                            class="dropify"
                                            data-allowed-file-extensions="png"
                                            data-height="300"
                                            data-default-file="">

                                    </div>
                                </div>





                                <div class="col-12 mb-3 text-center mt-4">
                                    <h5><b>Lugar de nacimiento </b></h5>
                                </div>

                                <div class="col-4 mb-3">
                                    <label>Ciudad</label>
                                    <input type="text" class="form-control" id="CIUDAD_LUGAR_NACIMIENTO" name="CIUDAD_LUGAR_NACIMIENTO">
                                </div>

                                <div class="col-4 mb-3">
                                    <label>Estado/Departamento/Provincia</label>
                                    <input type="text" class="form-control" id="ESTADO_LUGAR_NACIMIENTO" name="ESTADO_LUGAR_NACIMIENTO">
                                </div>

                                <div class="col-4 mb-3">
                                    <label>País </label>
                                    <input type="text" class="form-control" id="PAIS_LUGAR_NACIMIENTO" name="PAIS_LUGAR_NACIMIENTO">
                                </div>


                                <div class="col-12 mb-3 text-center mt-4">
                                    <h5><b>Documento de identificación oficial</b></h5>
                                </div>




                                <div class="listadedocumentoficial mt-4"></div>



                                <div class="col-12 mb-3 text-center mt-4">
                                    <h5><b>Domicilio</b></h5>
                                </div>

                                <div class="col-3 mb-3">
                                    <label>Código Postal *</label>
                                    <input type="number" class="form-control" id="CODIGO_POSTAL" name="CODIGO_POSTAL" required>
                                </div>

                                <div class="col-3 mb-3">
                                    <label>Tipo de Vialidad *</label>
                                    <input type="text" class="form-control" id="TIPO_VIALIDAD" name="TIPO_VIALIDAD" required>
                                </div>

                                <div class="col-3 mb-3">
                                    <label>Nombre de la Vialidad *</label>
                                    <input type="text" class="form-control" id="NOMBRE_VIALIDAD" name="NOMBRE_VIALIDAD" required>
                                </div>

                                <div class="col-3 mb-3">
                                    <label>Número Exterior </label>
                                    <input type="text" class="form-control" id="NUMERO_EXTERIOR" name="NUMERO_EXTERIOR">
                                </div>

                                <div class="col-3 mb-3">
                                    <label>Número Interior </label>
                                    <input type="text" class="form-control" id="NUMERO_INTERIOR" name="NUMERO_INTERIOR">
                                </div>

                                <div class="col-3 mb-3">
                                    <label>Nombre de la colonia *</label>
                                    <select class="form-control" id="NOMBRE_COLONIA" name="NOMBRE_COLONIA" required>
                                        <option value="">Seleccione una opción</option>
                                    </select>
                                </div>

                                <div class="col-3 mb-3">
                                    <label>Nombre de la Localidad *</label>
                                    <input type="text" class="form-control" id="NOMBRE_LOCALIDAD" name="NOMBRE_LOCALIDAD" required>
                                </div>

                                <div class="col-3 mb-3">
                                    <label>Nombre del municipio o demarcación territorial *</label>
                                    <input type="text" class="form-control" id="NOMBRE_MUNICIPIO" name="NOMBRE_MUNICIPIO" required>
                                </div>

                                <div class="col-3 mb-3">
                                    <label>Nombre de la Entidad Federativa *</label>
                                    <input type="text" class="form-control" id="NOMBRE_ENTIDAD" name="NOMBRE_ENTIDAD" required>
                                </div>
                                <div class="col-3 mb-3">
                                    <label>País *</label>
                                    <input type="text" class="form-control" id="PAIS_CONTRATACION" name="PAIS_CONTRATACION" required>
                                </div>


                                <div class="col-3 mb-3">
                                    <label>Entre Calle</label>
                                    <input type="text" class="form-control" id="ENTRE_CALLE" name="ENTRE_CALLE">
                                </div>

                                <div class="col-3 mb-3">
                                    <label>Y Calle</label>
                                    <input type="text" class="form-control" id="ENTRE_CALLE_2" name="ENTRE_CALLE_2">
                                </div>




                                <div class="col-12 mb-3 text-center mt-5">
                                    <h5><b>Información de emergencia</b></h5>
                                </div>

                                <div class="col-4 mb-3">
                                    <label>Número de Seguridad Social (NSS) *</label>
                                    <input type="number" class="form-control" id="NSS_COLABORADOR" name="NSS_COLABORADOR" required>
                                </div>

                                <div class="col-4 mb-3">
                                    <label>Tipo de Sangre *</label>
                                    <select class="form-control" id="TIPO_SANGRE" name="TIPO_SANGRE" required>
                                        <option value="0" disabled selected>Seleccione una opción</option>
                                        <option value="A+">A+</option>
                                        <option value="A-">A-</option>
                                        <option value="B+">B+</option>
                                        <option value="B-">B-</option>
                                        <option value="AB+">AB+</option>
                                        <option value="AB-">AB-</option>
                                        <option value="O+">O+</option>
                                        <option value="O-">O-</option>
                                    </select>
                                </div>
                                <div class="col-4 mb-3">
                                    <label>Alergias </label>
                                    <input type="text" class="form-control" id="ALERGIAS_COLABORADOR" name="ALERGIAS_COLABORADOR">
                                </div>

                                <div class="col-12 mb-3 text-center mt-5">
                                    <h5><b>Contacto de emergencia</b></h5>
                                </div>

                                <div class="col-3 mb-3">
                                    <label>Nombre completo *</label>
                                    <input type="text" class="form-control" id="NOMBRE_EMERGENCIA" name="NOMBRE_EMERGENCIA" required>
                                </div>
                                <div class="col-3 mb-3">
                                    <label>Parentesco *</label>
                                    <input type="text" class="form-control" id="PARENTESCO_EMERGENCIA" name="PARENTESCO_EMERGENCIA" required>
                                </div>
                                <div class="col-3 mb-3">
                                    <label>Teléfono 1 *</label>
                                    <input type="number" class="form-control" id="TELEFONO1_EMERGENCIA" name="TELEFONO1_EMERGENCIA" required>
                                </div>
                                <div class="col-3 mb-3">
                                    <label>Teléfono 2 </label>
                                    <input type="number" class="form-control" id="TELEFONO2_EMERGENCIA" name="TELEFONO2_EMERGENCIA">
                                </div>


                                <div class="col-12 mb-3 text-center mt-5">
                                    <h5><b>Beneficiario</b></h5>
                                </div>


                                <div class="listadeBeneficiario mt-4"></div>


                            </div>
                        </form>




                    </div> {{-- FINALIZA EL TAB DE EXPEDIENTE COLABORADOR --}}






                    <!-- Step 2 de Documentos del colaborador -->

                    <div id="step2-content" style="display: none;">
                        <ol class="breadcrumb mt-5">
                            <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-file-earmark-text-fill"></i> &nbsp;Documentos del colaborador</h3>
                        </ol>
                        <div class="card-body position-relative">
                            <i id="loadingIcon" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                            <table id="Tabladocumentosoportexpediente" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
                            </table>
                        </div>
                    </div>



                </div> {{-- FINALIZA EL TAB DE EXPEDIENTE COLABORADOR --}}


            </div>
        </div>
    </div>
</div>







<!-- ============================================================== -->
<!-- MODAL DOCUMENTO DE SOPORTE-->
<!-- ============================================================== -->

<div class="modal fade" id="miModal_DOCUMENTOS_SOPORTE" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioDOCUMENTOS" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Documento de soporte</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}


                    <div class="mb-3 text-center">
                        <label class="form-label">Requiere actualizar el documento*</label>
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" name="ACTUALIZAR_DOCUMENTO" id="actualizar_si" value="1" required>
                                <label for="experiencia_si" class="form-check-label">Sí</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" name="ACTUALIZAR_DOCUMENTO" id="actualizar_no" value="2">
                                <label for="experiencia_no" class="form-check-label">No</label>
                            </div>
                        </div>
                    </div>


                    <div id="DIV_ACTUALIZACOIN" style="display: none;">

                        <div class="mb-3">
                            <label>Nombre del archivo </label>
                            <input type="text" class="form-control" id="NOMBRE_DOCUMENTO" name="NOMBRE_DOCUMENTO" readonly required>
                        </div>

                        <div class="col-12 mt-4" id="REQUIERE_FECHA" style="display: block;">
                            <div class="row">
                                <div class="col-md-12 mb-3 text-center">
                                    <h5 class="form-label"><b>Requiere fecha </b></h5>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="PROCEDE_FECHA_DOC" id="procedesfechadocsi" value="1" required>
                                        <label class="form-check-label" for="procedesfechadocsi">Sí</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="PROCEDE_FECHA_DOC" id="procedesfechadocno" value="2">
                                        <label class="form-check-label" for="procedesfechadocno">No</label>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div id="FECHAS_SOPORTEDOCUMENTOS" style="display: none">
                            <div class="row  mb-3">
                                <div class="col-6">
                                    <label>Fecha Inicio *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHAI_DOCUMENTOSOPORTE" name="FECHAI_DOCUMENTOSOPORTE" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>

                                    </div>
                                </div>
                                <div class="col-6">
                                    <label>Fecha Fin *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHAF_DOCUMENTOSOPORTE" name="FECHAF_DOCUMENTOSOPORTE" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Subir documento</label>
                            <div class="input-group">
                                <input type="file" class="form-control" id="DOCUMENTO_SOPORTE" name="DOCUMENTO_SOPORTE" accept=".pdf" style="width: auto; flex: 1;">
                                <button type="button" class="btn btn-light btn-sm ms-2" id="quitar_documento" style="display:none;">Quitar archivo</button>
                            </div>
                        </div>
                        <div id="DOCUMENTO_ERROR" class="text-danger" style="display:none;">Por favor, sube un archivo PDF</div>


                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarDOCUMENTOSOPORTE">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    document.getElementById("CODIGO_POSTAL").addEventListener("change", function() {
        let codigoPostal = this.value.trim();

        if (codigoPostal.length === 5) {
            fetch(`/codigo-postal/${codigoPostal}`)
                .then(response => response.json())
                .then(data => {
                    if (!data.error) {
                        let response = data.response;

                        // Obtener el select de colonias
                        let coloniaSelect = document.getElementById("NOMBRE_COLONIA");
                        coloniaSelect.innerHTML = '<option value="">Seleccione una opción</option>';

                        // Verificar si `asentamiento` es un array o un solo valor
                        let colonias = Array.isArray(response.asentamiento) ? response.asentamiento : [response.asentamiento];

                        // Llenar el select con las colonias obtenidas
                        colonias.forEach(colonia => {
                            let option = document.createElement("option");
                            option.value = colonia;
                            option.textContent = colonia;
                            coloniaSelect.appendChild(option);
                        });

                        // Llenar municipio, estado, localidad (ciudad) y país
                        document.getElementById("NOMBRE_MUNICIPIO").value = response.municipio || "No disponible";
                        document.getElementById("NOMBRE_ENTIDAD").value = response.estado || "No disponible";
                        document.getElementById("NOMBRE_LOCALIDAD").value = response.ciudad || "No disponible"; // Localidad es "ciudad"
                        document.getElementById("PAIS_CONTRATACION").value = response.pais || "No disponible"; // Agregando País

                    } else {
                        alert("Código postal no encontrado");
                    }
                })
                .catch(error => {
                    console.error("Error al obtener datos:", error);
                    alert("Hubo un error al consultar la API.");
                });
        }
    });
</script>
@endsection