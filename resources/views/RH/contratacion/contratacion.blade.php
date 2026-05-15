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
                    <a class="nav-link active" id="contratos-tab" data-toggle="tab" href="#contratos" role="tab" aria-controls="contratos" aria-selected="true">Lista de colaboradores</a>
                </li>
                <li class="nav-item" style="display: none;">
                    <a class="nav-link" id="datosgenerales-tab" data-toggle="tab" href="#datosgenerales" role="tab" aria-controls="datosgenerales" aria-selected="false">Expediente del colaborador</a>
                </li>
                <li class="nav-item" style="display: none;">
                    <a class="nav-link" id="contratosdoc-tab" data-toggle="tab" href="#contratosdoc" role="tab" aria-controls="contratosdoc" aria-selected="false">Contratos y anexos</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="myTabContent">

                <!-- Lista de contratos Tab -->
                <div class="tab-pane fade show active" id="contratos" role="tabpanel" aria-labelledby="contratos-tab">
                    <ol class="breadcrumb mb-5" style="display: flex; justify-content: center; align-items: center;">
                        <h3 style="color: #ffffff; margin: 0;">
                            <i class="bi bi-folder2-open"></i>&nbsp;&nbsp;Contratos
                        </h3>
                        <!-- <button type="button" class="btn btn-light waves-effect waves-light" id="boton_nuevo_contrato" style="margin-left: auto;">
                            Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
                        </button> -->
                    </ol>

                    <div class="d-flex justify-content-center align-items-center mb-4">
                        <span id="texto_activo" class="texto-seleccionado me-4" style="cursor: pointer;">Activo</span>
                        <span id="texto_inactivo" class="texto-no-seleccionado" style="cursor: pointer;">Inactivo</span>
                    </div>

                    <div class="card-body position-relative" id="tabla_activo" style="display: block;">
                        <i id="loadingIcon8" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                        <table id="Tablacontratacion" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
                        </table>
                    </div>

                    <div class="card-body position-relative" id="tabla_inactivo" style="display: none;">
                        <i id="loadingIcon7" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                        <table id="Tablacontratacion1" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
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
                                    <div class="multisteps-form__progress-btn" id="step6">
                                        <div class="step-circle">
                                            <i class="bi bi-file-earmark-text-fill"></i>
                                        </div>
                                        <span> Requisición de personal</span>
                                    </div>
                                    <div class="multisteps-form__progress-btn" id="step3">
                                        <div class="step-circle">
                                            <i class="bi bi-file-earmark-text-fill"></i>
                                        </div>
                                        <span>Contratos y anexos</span>
                                    </div>
                                    <div class="multisteps-form__progress-btn" id="step4">
                                        <div class="step-circle">
                                            <i class="bi bi-file-earmark-text-fill"></i>
                                        </div>
                                        <span>Documentos de soporte contrato</span>
                                    </div>

                                    <div class="multisteps-form__progress-btn" id="step5">
                                        <div class="step-circle">
                                            <i class="bi bi-file-person-fill"></i>
                                        </div>
                                        <span>CV</span>
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


                                <div class="row">
                                    <div class="col-2">
                                        <div class="form-group" style="text-align: center;">
                                            <button type="button" class="btn btn-danger botonagregardocumentoficial" id="botonagregardocumentoficial">
                                                Agregar documento <i class="bi bi-plus-circle"></i>
                                            </button>
                                        </div>
                                    </div>
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

                                <div class="row">
                                    <div class="col-2">
                                        <div class="form-group" style="text-align: center;">
                                            <button type="button" class="btn btn-danger botonagregarbeneficiario" id="botonagregarbeneficiario">
                                                Agregar beneficiario <i class="bi bi-plus-circle"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="listadeBeneficiario mt-4"></div>



                                <div class="col-11 mt-4">
                                    <div class="form-group" style="text-align: right;">
                                        <button type="submit" class="btn btn-success " id="guardarDatosGenerales">Guardar</button>
                                    </div>
                                </div>

                            </div>
                        </form>




                        <div class="card-body" id="BAJAS_COLABORADOR" style="display: block">

                            <h5>Historial del colaborador</h5>


                        </div>



                    </div> {{-- FINALIZA EL TAB DE EXPEDIENTE COLABORADOR --}}






                    <!-- Step 2 de Documentos del colaborador -->

                    <div id="step2-content" style="display: none;">
                        <ol class="breadcrumb mt-5">
                            <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-file-earmark-text-fill"></i> &nbsp;Documentos del colaborador</h3>
                            <button type="button" class="btn btn-light waves-effect waves-light " data-bs-toggle="modal" data-bs-target="#miModal_DOCUMENTOS_SOPORTE" style="margin-left: auto;">
                                Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
                            </button>
                        </ol>
                        <div class="card-body position-relative">
                            <i id="loadingIcon" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                            <table id="Tabladocumentosoporte" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
                            </table>
                        </div>
                    </div>


                    <!-- Step 3 Contratos y anexos -->


                    <div id="step3-content" style="display: none;">
                        <ol class="breadcrumb mt-5">
                            <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-file-earmark-text-fill"></i> &nbsp;Contratos y anexos</h3>
                            <button type="button" class="btn btn-light waves-effect waves-light " data-bs-toggle="modal" data-bs-target="#miModal_CONTRATO" style="margin-left: auto;">
                                Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
                            </button>
                        </ol>
                        <div class="card-body position-relative">
                            <i id="loadingIcon1" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                            <table id="Tablacontratosyanexos" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
                            </table>
                        </div>
                    </div>




                    <!-- Step 4 DOCUMENTOS DE SOPORTE DE LOS CONTRATOS EN GENERAL -->

                    <div id="step4-content" style="display: none;">
                        <ol class="breadcrumb mt-5">
                            <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-file-earmark-person-fill"></i> &nbsp;Documentos de soportes del contrato</h3>
                            <button type="button" class="btn btn-light waves-effect waves-light " id="NUEVO_DOCUMENTOSOPORTESCONTRATO" style="margin-left: auto;">
                                Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
                            </button>
                        </ol>
                        <div class="card-body position-relative">
                            <i id="loadingIcon9" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                            <table id="Tablasoportecontrato" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
                            </table>
                        </div>
                    </div>


                    <!-- Step 5 CV´S -->

                    <div id="step5-content" style="display: none;">
                        <ol class="breadcrumb mt-5">
                            <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-file-earmark-person-fill"></i> &nbsp;CV</h3>
                            <button type="button" class="btn btn-light waves-effect waves-light" id="btnNuevoCV" style="margin-left: auto;">
                                Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
                            </button>
                        </ol>
                        <div class="card-body position-relative">
                            <i id="loadingIcon10" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                            <table id="Tablacvs" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
                            </table>
                        </div>
                    </div>


                    <!-- Step 6 Requisición de personal  -->

                    <div id="step6-content" style="display: none;">
                        <ol class="breadcrumb mt-5">
                            <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-file-earmark-person-fill"></i> &nbsp; Requisición de personal
                            </h3>
                            <button type="button" class="btn btn-light waves-effect waves-light " id="NUEVO_REQUISICION" style="margin-left: auto;">
                                Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
                            </button>
                        </ol>
                        <div class="card-body position-relative">
                            <i id="loadingIcon13" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                            <table id="Tablarequisicioncontratacion" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
                            </table>
                        </div>
                    </div>


































                </div> {{-- FINALIZA EL TAB DE EXPEDIENTE COLABORADOR --}}


                <div class="tab-pane fade" id="contratosdoc" role="tabpanel" aria-labelledby="contratosdoc-tab">

                    <div class="col-12 mt-4">
                        <ol class="breadcrumb m-b-10" style="background-color: #ffffff !important; color: #0c3f64; border: #0c3f64 2px solid; padding: 10px; display: flex; justify-content: space-between; align-items: center;">
                            <div style="flex: 1; text-align: center;">
                                <p style="margin: 0;">
                                    <i class="bi bi-person-lines-fill" aria-hidden="true"></i>
                                    Cargo: <span id="contrato_cargo" style="color: #009efb;"></span>
                                </p>
                            </div>
                            <div style="flex: 1; text-align: center;">
                                <p style="margin: 0;">
                                    <i class="bi bi-calendar-event" aria-hidden="true"></i>
                                    Fecha inicio: <span id="contrato_fechai" style="color: #009efb;"></span>
                                </p>
                            </div>
                            <div style="flex: 1; text-align: center;">
                                <p style="margin: 0;">
                                    <i class="bi bi-calendar-x" aria-hidden="true"></i>
                                    Fecha fin: <span id="contrato_fecha_final" style="color: #009efb;"></span>
                                </p>
                            </div>
                            <div style="flex: 1; text-align: center;">
                                <p style="margin: 0;">
                                    <i class="bi bi-currency-dollar" aria-hidden="true"></i>
                                    Salario: <span id="contrato_salario" style="color: #009efb;"></span>
                                </p>
                            </div>



                        </ol>
                    </div>

                    <div id="documentos_soportes_contrato">
                        <ol class="breadcrumb mt-5">
                            <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-file-earmark-text-fill"></i> &nbsp;Documentos de soporte</h3>
                            <button type="button" class="btn btn-light waves-effect waves-light " data-bs-toggle="modal" data-bs-target="#miModal_DOCUMENTOSOPORTECONTRATO" style="margin-left: auto;">
                                Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
                            </button>
                        </ol>
                        <div class="card-body position-relative">
                            <i id="loadingIcon11" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                            <table id="Tabladocumentosoportecontrato" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
                            </table>
                        </div>
                    </div>


                    <div id="renovacion">
                        <ol class="breadcrumb mt-5 d-flex justify-content-center" style="gap: 10px; list-style: none; padding: 0; margin: 0; background-color: rgba(0, 124, 186, 0.850) !important;">
                            <li>
                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#miModal_CONTRATO">Promoción</button>
                            </li>
                            <li>
                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#miModal_RENOVACION" id="BOTON_RENOVACION">Renovación</button>
                            </li>
                        </ol>
                    </div>

                    <div id="renovacion_contrato">
                        <ol class="breadcrumb mt-5 d-flex justify-content-center">
                            <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-file-earmark-text-fill"></i> &nbsp;Renovación</h3>
                        </ol>
                        <div class="card-body position-relative">
                            <i id="loadingIcon12" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                            <table id="Tablarenovacioncontrato" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
                            </table>
                        </div>
                    </div>


                    @if(auth()->check() && auth()->user()->hasRoles(['Superusuario','Administrador','externo']))
                    <div id="informacion_medica_contratos">
                        <ol class="breadcrumb mt-5">
                            <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-hospital-fill"></i> &nbsp;Información Médica</h3>
                            <button type="button" class="btn btn-light waves-effect waves-light " id="NUEVA_INFORMACIONMEDICA" style="margin-left: auto;">
                                Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
                            </button>
                        </ol>
                        <div class="card-body position-relative">
                            <i id="loadingIcon3" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                            <table id="Tablainformacionmedica" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
                            </table>
                        </div>
                    </div>
                    @endif


                    <div id="incidencias_contratos">
                        <ol class="breadcrumb mt-5">
                            <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-person-check-fill"></i> &nbsp;Incidencias</h3>
                            <!-- <button type="button" class="btn btn-light waves-effect waves-light " data-bs-toggle="modal" data-bs-target="#miModal_INCIDENCIAS" style="margin-left: auto;">
                                Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
                            </button> -->
                        </ol>
                        <div class="card-body position-relative">
                            <i id="loadingIcon4" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                            <table id="Tablaincidencias" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
                            </table>
                        </div>
                        <div class="card-body position-relative">
                            <i id="loadingIcon15" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                            <table id="Tablaspermisosrecempleados" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
                            </table>
                        </div>
                    </div>


                    <div id="solicitudvacaciones_contratos">
                        <ol class="breadcrumb mt-5">
                            <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-person-check-fill"></i> &nbsp;Solicitud de Vacaciones</h3>
                        </ol>
                        <div class="card-body position-relative">
                            <i id="loadingIcon14" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                            <table id="Tablasolicitudvacaciones" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
                            </table>
                        </div>
                    </div>




                    <div id="acciones_disciplinarias_contratos">
                        <ol class="breadcrumb mt-5">
                            <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-person-circle"></i> &nbsp;Acciones disciplinarias</h3>
                            <button type="button" class="btn btn-light waves-effect waves-light " data-bs-toggle="modal" data-bs-target="#miModal_ACCIONES_DISCIPLINARIAS" style="margin-left: auto;">
                                Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
                            </button>
                        </ol>
                        <div class="card-body position-relative">
                            <i id="loadingIcon5" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                            <table id="Tablaccionesdisciplinarias" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
                            </table>
                        </div>
                    </div>



                    <div id="recibos_nomina">
                        <ol class="breadcrumb mt-5">
                            <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-pen-fill"></i> &nbsp;Recibos de nómina</h3>
                            <button type="button" class="btn btn-light waves-effect waves-light " data-bs-toggle="modal" data-bs-target="#miModal_RECIBOS_NOMINA" style="margin-left: auto;">
                                Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
                            </button>
                        </ol>
                        <div class="card-body position-relative">
                            <i id="loadingIcon6" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                            <table id="Tablarecibonomina" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
                            </table>
                        </div>
                    </div>


                    <div id="asignacion_colaborador" style="display: none;">
                        <ol class="breadcrumb mt-5">
                            <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-card-list"></i>&nbsp;Asignaciones colaborador</h3>
                            <button type="button" class="btn btn-light waves-effect waves-light" id="NUEVA_ASIGNACION" style="margin-left: auto;">
                                Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
                            </button>
                        </ol>
                        <div class="card-body position-relative">
                            <i id="loadingIcon16" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                            <table id="Tablasignacioncolaboradorgeneral" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
                            </table>
                        </div>
                    </div>

                </div> {{-- FINALIZA EL TAB DE CONTRATO --}}


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

                    <div class="mb-3">
                        <label>Este documento se debe actualizar o renovar anualmente</label>
                        <select class="form-select" id="RENOVACION_DOCUMENTO" name="RENOVACION_DOCUMENTO">
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="1">Sí</option>
                            <option value="2">No</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Tipo de documento *</label>
                        <select class="form-select" id="TIPO_DOCUMENTO" name="TIPO_DOCUMENTO">
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="1">Copia del INE</option>
                            <option value="2">Copia del Pasaporte</option>
                            <option value="3">Copia de la licencia de conducción tipo chofer</option>
                            <option value="4">Copia del número de seguridad social (NSS)</option>
                            <option value="5">Copia del acta de nacimiento</option>
                            <option value="6">Copia de la CURP</option>
                            <option value="8">Copia de la cartilla de servicio militar (hombres)</option>
                            <option value="9">Copia del comprobante de domicilio </option>
                            <option value="10">Dos (2) cartas de recomendación</option>
                            <option value="11">Contrato o caratula del estado de cuenta </option>
                            <option value="12">Constancia de situación fiscal</option>
                            <option value="14">Visa</option>
                            <option value="15">Credencial de residente</option>
                            <option value="16">Aviso o carta de retención de INFONAVIT</option>
                            <option value="13">Otros</option>
                        </select>
                    </div>

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
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarDOCUMENTOSOPORTE">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL CONTRATOS Y ANEXOS-->
<!-- ============================================================== -->

<div class="modal fade" id="miModal_CONTRATO" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioCONTRATO" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Contratos y anexos</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}


                    <div class="mb-3">
                        <label>Documento *</label>
                        <select class="form-select" id="TIPO_DOCUMENTO_CONTRATO" name="TIPO_DOCUMENTO_CONTRATO" required>
                            <option value="3" selected>Contrato</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Tipo de contrato *</label>
                        <input type="text" class="form-control" id="NOMBRE_DOCUMENTO_CONTRATO" name="NOMBRE_DOCUMENTO_CONTRATO" required>
                    </div>

                    <div class="row  mb-3" id="CONTRATO" style="display: block">
                        <div class="col-12 mb-3">
                            <label>Cargo</label>
                            <select class="form-control" id="NOMBRE_CARGO" name="NOMBRE_CARGO" required>
                                <option value="0" selected disabled>Seleccione una opción</option>
                                @foreach ($areas as $area)
                                <option value="{{ $area->ID }}">{{ $area->NOMBRE }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row  mb-3">
                            <div class="col-6">
                                <label>Fecha Inicio *</label>
                                <div class="input-group">
                                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHAI_CONTRATO" name="FECHAI_CONTRATO" required>
                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>

                                </div>
                            </div>
                            <div class="col-6">
                                <label>Fecha Fin *</label>
                                <div class="input-group">
                                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="VIGENCIA_CONTRATO" name="VIGENCIA_CONTRATO" required>
                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>

                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                <label>Salario *</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="SALARIO_CONTRATO" name="SALARIO_CONTRATO" required>
                                </div>
                            </div>

                            <div class="col-6  mt-4">
                                <label>Requiere crendencial *</label>
                                <div class="input-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="REQUIERE_CREDENCIAL" id="procedecredencialsi" value="1" required>
                                        <label class="form-check-label" for="procedecredencialsi">Sí</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="REQUIERE_CREDENCIAL" id="procedecredencialno" value="2">
                                        <label class="form-check-label" for="procedecredencialno">No</label>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="mb-3">
                        <label>Subir documento</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="DOCUMENTO_CONTRATO" name="DOCUMENTO_CONTRATO" accept=".pdf" style="width: auto; flex: 1;">
                            <button type="button" class="btn btn-light btn-sm ms-2" id="quitar_contrato" style="display:none;">Quitar archivo</button>
                        </div>
                    </div>
                    <div id="DOCUEMNTO_ERROR_CONTRATO" class="text-danger" style="display:none;">Por favor, sube un archivo PDF</div>




                    <div class="col-12 mt-4" id="REQUIERE_ADENDA_CONTRATO" style="display: none;">
                        <div class="row">
                            <div class="col-md-12 mb-3 text-center">
                                <h5 class="form-label"><b>Requiere adenda </b></h5>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="PROCEDE_ADENDA_CONTRATO" id="procedecontratosi" value="1">
                                    <label class="form-check-label" for="procedecontratosi">Sí</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="PROCEDE_ADENDA_CONTRATO" id="procedecontratono" value="2">
                                    <label class="form-check-label" for="procedecontratono">No</label>
                                </div>

                            </div>
                        </div>
                    </div>



                    <div class="row" id="AGREGAR_ADENDA_CONTRATO" style="display: none;">
                        <div class="mb-3 mt-3">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label>Agregar adenda</label>
                                    <button id="botonagregarevidenciacontrato" type="button" class="btn btn-danger ml-2 rounded-pill" title="Agregar">
                                        <i class="bi bi-plus-circle-fill"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="adendacontratodiv mt-4"></div>
                        </div>
                    </div>






                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarCONTRATO">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL DOCUMENTOS DE SOPORTE CONTRATRO GENERALES-->
<!-- ============================================================== -->

<div class="modal fade" id="miModal_SOPORTECONTRATO" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioSOPORTECONTRATO" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Documentos de soporte contrato</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}

                    <div class="mb-3">
                        <label>Tipo de documento *</label>
                        <select class="form-select" id="TIPO_DOCUMENTO_SOPORTECONTRATO" name="TIPO_DOCUMENTO_SOPORTECONTRATO">
                            <option value="0" disabled selected>Seleccione una opción</option>
                            <option value="1">Descripción del puesto de trabajo (DPT) firmado por el colaborador</option>
                            <option value="2">Antecedentes, Imparcialidad y Beneficiarios</option>
                            <option value="3">Aviso de privacidad, Encuesta socioeconómica y Protección de datos del colaborador</option>
                            <option value="3">Aviso de privacidad</option>
                            <option value="14">Encuesta socioeconómica y Protección de datos del colaborador</option>
                            <option value="6">Autorización de emisión de recibos de nómina</option>
                            <option value="7">Autorización de firma y rúbrica</option>
                            <option value="8">Acuse de recibo del Catálogo de Políticas</option>
                            <option value="9">Solicitud de derechos ARCO</option>
                            <option value="10">Carta de vínculo con Personal Políticamente Expuesto</option>
                            <option value="11">Carta presentación declaración anual</option>
                            <option value="12">Carta de no crédito INFONAVIT</option>
                            <option value="14">Retención de descuentos</option>
                            <option value="13">Otros</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Nombre del documento *</label>
                        <input type="text" class="form-control" id="NOMBRE_DOCUMENTO_SOPORTECONTRATO" name="NOMBRE_DOCUMENTO_SOPORTECONTRATO" required>
                    </div>




                    <div id="FECHAS_SOPORTEDOCUMENTOSCONTRATO" style="display: none">


                        <div class="row  mb-3">
                            <div class="col-6">
                                <label>Fecha Inicio *</label>
                                <div class="input-group">
                                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHAI_DOCUMENTOSOPORTECONTRATO" name="FECHAI_DOCUMENTOSOPORTECONTRATO">
                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>

                                </div>
                            </div>
                            <div class="col-6">
                                <label>Fecha Fin *</label>
                                <div class="input-group">
                                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHAF_DOCUMENTOSOPORTECONTRATO" name="FECHAF_DOCUMENTOSOPORTECONTRATO">
                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>

                                </div>
                            </div>


                        </div>

                    </div>


                    <div class="mb-3">
                        <label>Subir documento</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="DOCUMENTO_SOPORTECONTRATO" name="DOCUMENTO_SOPORTECONTRATO" accept=".pdf" style="width: auto; flex: 1;">
                            <button type="button" class="btn btn-light btn-sm ms-2" id="quitar_soportecontrato" style="display:none;">Quitar archivo</button>
                        </div>
                    </div>
                    <div id="DOCUEMNTO_ERROR_SOPORTECONTRATO" class="text-danger" style="display:none;">Por favor, sube un archivo PDF</div>

                    <!-- 
                    <div class="mb-3" id="DIV_FOTO_FIRMA" style="display: none">
                            <div class="form-group">
                                <label  >Firma colaborador (.png)*</label>
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
                                    id="FOTO_FIRMA"
                                    name="FOTO_FIRMA"
                                    class="dropify"
                                    data-allowed-file-extensions="png"
                                    data-height="300"
                                    data-default-file="">

                            </div>
                    </div> -->



                    <div class="mb-3" id="DIV_FOTO_FIRMA" style="display: none">
                        <div class="row">
                            <!-- Col 6: Firma colaborador -->

                            <input type="hidden" name="ELIMINAR_FOTO_FIRMA" id="ELIMINAR_FOTO_FIRMA" value="0">
                            <input type="hidden" name="ELIMINAR_FOTO_FIRMA_RH" id="ELIMINAR_FOTO_FIRMA_RH" value="0">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Firma colaborador (.png)</label>
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
                                        id="FOTO_FIRMA"
                                        name="FOTO_FIRMA"
                                        class="dropify"
                                        data-allowed-file-extensions="png"
                                        data-height="300"
                                        data-default-file="">
                                </div>
                            </div>

                            <!-- Col 6: Firma RH -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Firma RH (.png)</label>
                                    <input type="file"
                                        accept="image/png"
                                        id="FOTO_FIRMA_RH"
                                        name="FOTO_FIRMA_RH"
                                        class="dropify"
                                        data-allowed-file-extensions="png"
                                        data-height="300"
                                        data-default-file="">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarSOPORTECONTRATO">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL DOCUMENTOS DE SOPORTE CONTRATRO-->
<!-- ============================================================== -->

<div class="modal fade" id="miModal_DOCUMENTOSOPORTECONTRATO" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioDOCUMENTOSOPORTECONTRATO" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Documentos de soporte contrato</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}

                    <div class="mb-3">
                        <label>Tipo de documento *</label>
                        <select class="form-select" id="TIPO_DOCUMENTOSOPORTECONTRATO" name="TIPO_DOCUMENTOSOPORTECONTRATO" required>
                            <option value="0" disabled selected>Seleccione una opción</option>
                            <option value="1">Anexo 1. Acuerdo de confidencialidad</option>
                            <option value="2">Compromiso de independencia, integridad e imparcialidad</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Nombre del documento *</label>
                        <input type="text" class="form-control" id="NOMBRE_DOCUMENTOSOPORTECONTRATO" name="NOMBRE_DOCUMENTOSOPORTECONTRATO" readonly required>
                    </div>

                    <div class="row  mb-3">
                        <div class="col-6">
                            <label>Fecha Inicio *</label>
                            <div class="input-group">
                                <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHAI_DOCUMENTOSOPORTECONTRATO" name="FECHAI_DOCUMENTOSOPORTECONTRATO" required>
                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>

                            </div>
                        </div>
                        <div class="col-6">
                            <label>Fecha Fin *</label>
                            <div class="input-group">
                                <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHAF_DOCUMENTOSOPORTECONTRATO" name="FECHAF_DOCUMENTOSOPORTECONTRATO">
                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>

                            </div>
                        </div>


                    </div>


                    <div class="mb-3">
                        <label>Subir documento</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="DOCUMENTOS_SOPORTECONTRATOS" name="DOCUMENTOS_SOPORTECONTRATOS" accept=".pdf" style="width: auto; flex: 1;">
                            <button type="button" class="btn btn-light btn-sm ms-2" id="quitar_documentossoportecontrato" style="display:none;">Quitar archivo</button>
                        </div>
                    </div>
                    <div id="ERROR_DOCUMENTOSOPORTECONTRATO" class="text-danger" style="display:none;">Por favor, sube un archivo PDF</div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarDOCUMENTOSOPORTECONTRATO">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL RENOVACION CONTRATO-->
<!-- ============================================================== -->

<div class="modal fade" id="miModal_RENOVACION" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioRENOVACION" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Renovación contrato</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}



                    <div class="mb-3">
                        <label>Nombre del documento *</label>
                        <input type="text" class="form-control" id="NOMBRE_DOCUMENTO_RENOVACION" name="NOMBRE_DOCUMENTO_RENOVACION" value="Renovación contrato" readonly required>
                    </div>

                    <div class="row  mb-3">
                        <div class="col-4">
                            <label>Fecha Inicio *</label>
                            <div class="input-group">
                                <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHAI_RENOVACION" name="FECHAI_RENOVACION" required>
                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>

                            </div>
                        </div>
                        <div class="col-4">
                            <label>Fecha Fin *</label>
                            <div class="input-group">
                                <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHAF_RENOVACION" name="FECHAF_RENOVACION" required>
                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>

                            </div>
                        </div>

                        <div class="col-4">
                            <label>Salario *</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="SALARIO_RENOVACION" name="SALARIO_RENOVACION" required>
                            </div>
                        </div>
                    </div>


                    <div class="mb-3">
                        <label>Subir documento</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="DOCUMENTOS_RENOVACION" name="DOCUMENTOS_RENOVACION" accept=".pdf" style="width: auto; flex: 1;">
                            <button type="button" class="btn btn-light btn-sm ms-2" id="quitar_documentorenovacion" style="display:none;">Quitar archivo</button>
                        </div>
                    </div>
                    <div id="ERROR_DOCUMENTORENOVACION" class="text-danger" style="display:none;">Por favor, sube un archivo PDF</div>



                    <div class="col-12 mt-4" id="REQUIERE_ADENDA" style="display: none;">
                        <div class="row">
                            <div class="col-md-12 mb-3 text-center">
                                <h5 class="form-label"><b>Requiere adenda </b></h5>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="PROCEDE_ADENDA" id="procedesi" value="1">
                                    <label class="form-check-label" for="procedesi">Sí</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="PROCEDE_ADENDA" id="procedeno" value="2">
                                    <label class="form-check-label" for="procedeno">No</label>
                                </div>

                            </div>
                        </div>
                    </div>



                    <div class="row" id="AGREGAR_ADENDA" style="display: none;">
                        <div class="mb-3 mt-3">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label>Agregar adenda</label>
                                    <button id="botonagregarevidencia" type="button" class="btn btn-danger ml-2 rounded-pill" title="Agregar">
                                        <i class="bi bi-plus-circle-fill"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="adendadiv mt-4"></div>
                        </div>
                    </div>









                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarRENOVACION">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL RECIBO -->
<!-- ============================================================== -->

<div class="modal fade" id="miModal_RECIBOS_NOMINA" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioRECIBO" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Recibos de nómina</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}

                    <div class="mb-3">
                        <label>Nombre del archivo </label>
                        <input type="text" class="form-control" id="NOMBRE_RECIBO" name="NOMBRE_RECIBO" required>
                    </div>


                    <div class="row  mb-3">

                        <div class="col-4">
                            <label>Días laborados </label>
                            <input type="text" class="form-control" id="DIAS_LABORADOS_RECIBO" name="DIAS_LABORADOS_RECIBO">
                        </div>

                        <div class="col-4">
                            <label>Fecha inicio *</label>
                            <div class="input-group">
                                <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_RECIBO" name="FECHA_RECIBO" required>
                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                            </div>
                        </div>
                        <div class="col-4">
                            <label>Fecha fin *</label>
                            <div class="input-group">
                                <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHAF_RECIBO" name="FECHAF_RECIBO" required>
                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                            </div>
                        </div>

                        <div class="col-4 mt-3">
                            <label>Días festivos</label>
                            <input type="text" class="form-control" id="DIAS_FESTIVOS_RECIBO" name="DIAS_FESTIVOS_RECIBO">
                        </div>

                        <div class="col-4 mt-3">
                            <label>Total de días</label>
                            <input type="text" class="form-control" id="TOTAL_DIAS_RECIBO" name="TOTAL_DIAS_RECIBO" required>
                        </div>

                        <div class="col-4 mt-3">
                            <label>HHT</label>
                            <input type="text" class="form-control" id="HHT_RECIBO" name="HHT_RECIBO" required>
                        </div>
                    </div>


                    <div class="mb-3">
                        <label>Subir documento</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="DOCUMENTO_RECIBO" name="DOCUMENTO_RECIBO" accept=".pdf" style="width: auto; flex: 1;">
                            <button type="button" class="btn btn-light btn-sm ms-2" id="quitar_recibo" style="display:none;">Quitar archivo</button>
                        </div>
                    </div>
                    <div id="RECIBO_ERROR" class="text-danger" style="display:none;">Por favor, sube un archivo PDF</div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarRECIBONOMINA">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL INFORMACION MEDICA -->
<!-- ============================================================== -->

<div class="modal fade" id="miModal_INFORMACION_MEDICA" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioINFORMACION" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Información Medica</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}

                    <div class="mb-3">
                        <label>Tipo de examen *</label>
                        <input type="text" class="form-control" id="NOMBRE_DOCUMENTO_INFORMACION" name="NOMBRE_DOCUMENTO_INFORMACION" required>
                    </div>
                    <div class="mb-3">
                        <label>Fecha del examen *</label>
                        <div class="input-group">
                            <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_EXAMEN_MEDICA" name="FECHA_EXAMEN_MEDICA" required>
                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Proveedor *</label>
                        <input type="text" class="form-control" id="PROVEEDOR_INFORMACION" name="PROVEEDOR_INFORMACION" required>
                    </div>


                    <div class="mb-3">
                        <label>Dictamen </label>
                        <input type="text" class="form-control" id="DICTAMEN_INFORMACION" name="DICTAMEN_INFORMACION">
                    </div>

                    <div class="row">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label>Agregar observaciones</label>
                                    <button id="botonAgregarobservaciones" id="botonAgregarobservaciones" type="button" class="btn btn-danger ml-2 rounded-pill" title="Agregar">
                                        <i class="bi bi-plus-circle-fill"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="observacionesdiv mt-4"></div>
                        </div>
                    </div>




                    <div class="mb-3">
                        <label>Subir documento</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="DOCUMENTO_INFORMACION_MEDICA" name="DOCUMENTO_INFORMACION_MEDICA" accept=".pdf" style="width: auto; flex: 1;">
                            <button type="button" class="btn btn-light btn-sm ms-2" id="quitar_informacion_medica" style="display:none;">Quitar archivo</button>
                        </div>
                    </div>
                    <div id="INFORMACIONMEDICA_ERROR" class="text-danger" style="display:none;">Por favor, sube un archivo PDF</div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarINFORMACIONMEDICA">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL INCIDENCIAS -->
<!-- ============================================================== -->

<div class="modal fade" id="miModal_INCIDENCIAS" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioINCIDENCIAS" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Incidencias</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}

                    <div class="mb-3">
                        <label>Nombre del archivo </label>
                        <input type="text" class="form-control" id="NOMBRE_DOCUMENTO_INCIDENCIAS" name="NOMBRE_DOCUMENTO_INCIDENCIAS" required>
                    </div>

                    <div class="row  mb-3">
                        <div class="col-4">
                            <label>Fecha Inicio *</label>
                            <div class="input-group">
                                <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHAI_INCIDENCIA" name="FECHAI_INCIDENCIA" required>
                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>

                            </div>
                        </div>
                        <div class="col-4">
                            <label>Fecha Fin *</label>
                            <div class="input-group">
                                <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHAF_INCIDENCIA" name="FECHAF_INCIDENCIA" required>
                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>

                            </div>
                        </div>


                        <div class="col-4">
                            <label>Número de horas </label>
                            <input type="number" class="form-control" id="NUMERO_HORAS_INCIDENCIA" name="NUMERO_HORAS_INCIDENCIA" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="col-form-label">Aplica para ausentismo *</label>
                        <div class="d-flex">
                            <div class="form-check me-3">
                                <input class="form-check-input" type="radio" name="APLICA_AUSENTISMO" id="SI_AUSENTISMO" value="SI" required>
                                <label class="form-check-label" for="SI_AUSENTISMO">Si</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="APLICA_AUSENTISMO" id="NO_AUSENTISMO" value="NO" required>
                                <label class="form-check-label" for="NO_AUSENTISMO">No</label>
                            </div>
                        </div>
                    </div>


                    <div class="mb-3">
                        <label>Subir documento</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="DOCUMENTO_INCIDENCIAS" name="DOCUMENTO_INCIDENCIAS" accept=".pdf" style="width: auto; flex: 1;">
                            <button type="button" class="btn btn-light btn-sm ms-2" id="quitar_incidencias" style="display:none;">Quitar archivo</button>
                        </div>
                    </div>
                    <div id="INCIDENCIAS_ERROR" class="text-danger" style="display:none;">Por favor, sube un archivo PDF</div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarINCIDENCIAS">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- ACCIONES DISCIPLINARIAS  -->
<!-- ============================================================== -->

<div class="modal fade" id="miModal_ACCIONES_DISCIPLINARIAS" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioACCIONES_DISCIPLINARIAS" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Acciones disciplinarias</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}

                    <div class="mb-3">
                        <label>Nombre del archivo </label>
                        <input type="text" class="form-control" id="NOMBRE_DOCUMENTO_ACCIONES" name="NOMBRE_DOCUMENTO_ACCIONES" required>
                    </div>

                    <div class="row  mb-3">
                        <div class="col-12">
                            <label>Fecha en que se firma *</label>
                            <div class="input-group">
                                <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHAI_ACCION" name="FECHAI_ACCION" required>
                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>

                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Acción disciplinaria *</label>
                        <textarea type="text" class="form-control" id="ACCION_DISCIPLINARIA" name="ACCION_DISCIPLINARIA" rows="4" required></textarea>
                    </div>


                    <div class="mb-3">
                        <label>Sanción disciplinaria *</label>
                        <select class="form-select" id="SANCION_DISCIPLINARIA" name="SANCION_DISCIPLINARIA" required>
                            <option value="0" disabled selected>Seleccione una opción</option>
                            <option value="1">Amonestación verbal</option>
                            <option value="2">Amonestación por escrito a través de acta administrativa</option>
                            <option value="3">Suspensión misma que no puede exceder de ocho días y además el colaborador
                                tiene el derecho a ser oído antes de que se aplique cualquier sanción.</option>
                            <option value="4">Rescisión (de conformidad al artículo 47 de la Ley Federal del Trabajo vigente).</option>

                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Subir documento</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="DOCUMENTO_ACCIONES_DISCIPLINARIAS" name="DOCUMENTO_ACCIONES_DISCIPLINARIAS" accept=".pdf" style="width: auto; flex: 1;">
                            <button type="button" class="btn btn-light btn-sm ms-2" id="quitar_acciones_disciplinarias" style="display:none;">Quitar archivo</button>
                        </div>
                    </div>
                    <div id="ACCIONES_DISCIPLINARIAS_ERROR" class="text-danger" style="display:none;">Por favor, sube un archivo PDF</div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarACCIONES">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL CV  -->
<!-- ============================================================== -->


<div class="modal fade" id="ModalCV" tabindex="-1" aria-labelledby="ModalFullLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <!-- Formulario de Datos Generales -->
            <form method="post" enctype="multipart/form-data" id="FormularioCV" style="background-color: #ffffff;">
                <div class="modal-header ">
                    <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Ficha datos CV</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {!! csrf_field() !!}

                <div class="modal-body">
                    <div class="row">
                        <!-- Columna Izquierda -->
                        <div class="col-9">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label>Nombre completo *</label>
                                    <input type="text" class="form-control" id="NOMBRE_CV" name="NOMBRE_CV" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label>Cargo *</label>
                                    <input type="text" class="form-control" id="CARGO_CV" name="CARGO_CV" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label>Profesión *</label>
                                    <input type="text" class="form-control" id="PROFESION_CV" name="PROFESION_CV" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label>Nacionalidad *</label>
                                    <input type="text" class="form-control" id="NACIONALIDAD_CV" name="NACIONALIDAD_CV" required>
                                </div>


                                <h4><b>Perfil profesional</b></h4>

                                <div class="col-12 mb-3">
                                    <label>Descripción *</label>
                                    <textarea type="text" class="form-control" id="DESCRIPCION_PERFIL_CV" name="DESCRIPCION_PERFIL_CV" rows="3" required></textarea>
                                </div>

                            </div>
                        </div>

                        <!-- Columna Derecha -->
                        <div class="col-3">
                            <div class="form-group">
                                <label id="FOTO_TITULO">Foto colaborador *</label>
                                <style>
                                    .dropify-wrapper {
                                        height: 270px !important;
                                        text-align: center;
                                    }

                                    .dropify-message p {
                                        font-size: 14px;
                                        margin: 0;
                                    }
                                </style>
                                <input type="file" accept="image/jpeg,image/x-png" id="FOTO_CV" name="FOTO_CV" class="dropify" data-allowed-file-extensions="jpg png" data-height="300" data-default-file="" />
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <h4><b>Formación académica</b></h4>

                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label>Agregar formación académica</label>
                                    <button id="botonAgregarFormacion" type="button" class="btn btn-danger ml-2 rounded-pill" title="Agregar">
                                        <i class="bi bi-plus-circle-fill"></i>
                                    </button>
                                </div>
                            </div>
                            <div id="Informacion-academica" class="mt-3"></div>
                        </div>


                        <!-- Grado de Estudio -->


                        <h4><b>Documentos académicos</b></h4>


                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label>Agregar documento</label>
                                    <button id="botonAgregarDocumento" type="button" class="btn btn-danger ml-2 rounded-pill" title="Agregar ">
                                        <i class="bi bi-plus-circle-fill"></i>
                                    </button>
                                </div>
                            </div>
                            <div id="documentos-academica" class="mt-3"></div>
                        </div>



                        <div class="mb-3 text-center">
                            <label class="form-label">¿Requiere cédula profesional? *</label>
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input requiere-cedula" name="REQUIERE_CEDULA_CV" id="experiencia_si" value="si">
                                    <label for="experiencia_si" class="form-check-label">Sí</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input requiere-cedula" name="REQUIERE_CEDULA_CV" id="experiencia_no" value="no">
                                    <label for="experiencia_no" class="form-check-label">No</label>
                                </div>

                                <div class="form-check form-check-inline ms-3">
                                    <label class="form-label me-2">Estatus:</label>
                                    <select class="form-select estatus-select" id="ESTATUS_CEDULA_CV" name="ESTATUS_CEDULA_CV">
                                        <option value="0" selected disabled>Seleccione un estatus</option>
                                        <option value="1" class="text-warning">En trámite</option>
                                        <option value="2" class="text-success">Finalizado</option>
                                    </select>
                                </div>
                            </div>
                        </div>



                        <div id="MOSTRAR_CEDULA" style="display: none;">
                            <div class="row">
                                <div class="col-4 mb-3">
                                    <label>Nombre del programa *</label>
                                    <input type="text" class="form-control" id="NOMBRE_CEDULA_CV" name="NOMBRE_CEDULA_CV">
                                </div>
                                <div class="col-4 mb-3">
                                    <label>N° de cédula *</label>
                                    <input type="number" class="form-control" id="NUMERO_CEDULA_CV" name="NUMERO_CEDULA_CV">
                                </div>
                                <div class="col-4 mb-3">
                                    <label>Fecha emisión *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="EMISION_CEDULA_CV" name="EMISION_CEDULA_CV">
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>

                                <h6> <b>Documentos </b></h6>

                                <div class="col-6 mb-3">
                                    <label>Cédula *</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" id="DOCUMENTO_CEDULA_CV" name="DOCUMENTO_CEDULA_CV" accept="application/pdf">
                                        <button type="button" class="btn btn-danger eliminar-archivo" title="Eliminar archivo">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-6 mb-3">
                                    <label>Validación *</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" id="DOCUMENTO_VALCEDULA_CV" name="DOCUMENTO_VALCEDULA_CV" accept="application/pdf">
                                        <button type="button" class="btn btn-danger eliminar-archivo" title="Eliminar archivo">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>




                    </div><!-- FIN DE DIV ROW DE FOR.ACADEM  -->




                    <div class="row">

                        <h4><b>Experiencia laboral</b></h4>

                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label>Agregar experiencia laboral</label>
                                    <button id="botonAgregarExperiencia" type="button" class="btn btn-danger ml-2 rounded-pill" title="Agregar">
                                        <i class="bi bi-plus-circle-fill"></i>
                                    </button>
                                </div>
                            </div>
                            <div id="Experiencia-laboral" class="mt-3"></div>
                        </div>


                    </div> <!-- FIN DE DIV ROW DE  EXP.LAB  -->



                    <div class="row">

                        <h4><b>Educación continua</b></h4>

                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label>Agregar educación continua</label>
                                    <button id="botonAgregarEducacionContinua" type="button" class="btn btn-danger ml-2 rounded-pill" title="Agregar">
                                        <i class="bi bi-plus-circle-fill"></i>
                                    </button>
                                </div>
                            </div>
                            <div id="Educacion-continua" class="mt-3"></div>
                        </div>


                    </div> <!-- FIN DE DIV ROW DE  EDUCACION CONTINUA -->























                </div> <!-- FIN DE DIV DE MODAL BODY  -->
                <div class="modal-footer">
                    <div class="col-11 text-end">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success" id="guardarCV">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL REQUISICION DE PERSONAL  -->
<!-- ============================================================== -->

<div class="modal modal-fullscreen fade" id="miModal_REQUERIMIENTO" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioRP" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h5 class="modal-title" id="miModalLabel">Requisición de personal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="row">

                        <div class="row mb-3">

                            <input type="hidden" class="form-control" id="ANTES_DE1" name="ANTES_DE1" value="0">
                        </div>


                        <div class="row mb-3">

                            <div class="col-12">
                                <label>Seleccionar Categoría</label>
                                <select class="form-control" id="SELECCIONAR_CATEGORIA_RP" name="SELECCIONAR_CATEGORIA_RP" required>
                                    <option selected disabled>Seleccione una opción</option>

                                    <optgroup label="Requisición se realizó antes del 2024-11-01">
                                        @foreach ($requisicioncategoria as $cat)
                                        @if ($cat->ANTES_DE1 == 1)
                                        <option value="{{ $cat->ID_FORMULARO_REQUERIMIENTO }}">
                                            {{ $cat->NOMBRE_CATEGORIA }} - {{ \Carbon\Carbon::parse($cat->FECHA_MOSTRAR)->format('Y-m-d') }}
                                        </option>

                                        @endif
                                        @endforeach
                                    </optgroup>

                                    <optgroup label="Requisición después del 2024-11-01">
                                        @foreach ($requisicioncategoria as $cat)
                                        @if ($cat->ANTES_DE1 == 0)
                                        <option value="{{ $cat->ID_FORMULARO_REQUERIMIENTO }}">
                                            {{ $cat->NOMBRE_CATEGORIA }} - {{ \Carbon\Carbon::parse($cat->FECHA_MOSTRAR)->format('Y-m-d') }}
                                        </option>

                                        @endif
                                        @endforeach
                                    </optgroup>
                                </select>



                            </div>
                        </div>
                        <div id="MOSTRAR_TODO" style="display: block">


                            <div class="row mb-3 mt-4">
                                <div class="col-4">
                                    <label>Fecha *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_RP" name="FECHA_RP" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Prioridad:</label>
                                        <select class="form-control" id="PRIORIDAD_RP" name="PRIORIDAD_RP" required>
                                            <option selected disabled>Seleccione una opción</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Urgente">Urgente</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Tipo de vacante:</label>
                                        <select class="form-control" id="TIPO_VACANTE_RP" name="TIPO_VACANTE_RP" required>
                                            <option selected disabled>Seleccione una opción</option>
                                            @foreach ($tipos as $tipo)
                                            <option value="{{ $tipo->NOMBRE_TIPOVACANTE }}">{{ $tipo->NOMBRE_TIPOVACANTE }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Motivo de la vacante:</label>
                                        <select class="form-control" id="MOTIVO_VACANTE_RP" name="MOTIVO_VACANTE_RP" required>
                                            <option selected disabled>Seleccione una opción</option>
                                            @foreach ($motivos as $motivo)
                                            <option value="{{ $motivo->NOMBRE_MOTIVO_VACANTE }}">{{ $motivo->NOMBRE_MOTIVO_VACANTE }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="form-group">
                                        <label>Área: </label>
                                        <select class="form-control" id="AREA_RP" name="AREA_RP" required>
                                            <option selected disabled>Seleccione una opción</option>
                                            @foreach ($areas2 as $area)
                                            <option value="{{ $area->ID_AREA }}">{{ $area->NOMBRE }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <label>Sustituye a: </label>
                                    <input type="text" class="form-control " id="SUSTITUYE_RP" name="SUSTITUYE_RP">
                                </div>
                                <div class="col-6">
                                    <label>Categoría a sustituir</label>
                                    <select class="form-control" id="SUSTITUYE_CATEGORIA_RP" name="SUSTITUYE_CATEGORIA_RP">
                                        <option selected disabled>Seleccione una opción</option>
                                        <option value="N/A">N/A</option>
                                        @foreach ($todascategoria as $cat)
                                        <option value="{{ $cat->ID_CATALOGO_CATEGORIA }}">{{ $cat->NOMBRE }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            <div class="row mb-3">

                                <div class="col-2 text-center">
                                    <div class="form-group">
                                        <label>No. de vacantes</label>
                                        <input type="number" class="form-control " id="NO_VACANTES_RP" name="NO_VACANTES_RP" required>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <label></label>
                                </div>
                                <div class="col-4 text-center">
                                    <div class="form-group">
                                        <label>Categoría</label>
                                        <select class="form-control" id="PUESTO_RP" name="PUESTO_RP" required>
                                            <option selected disabled>Seleccione una opción</option>
                                            @foreach ($categoria as $cat)
                                            <option value="{{ $cat->ID_DEPARTAMENTO_AREA }}">{{ $cat->NOMBRE }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <label></label>
                                </div>
                                <div class="col-4 text-center">
                                    <label>Fecha de inicio *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_INICIO_RP" name="FECHA_INICIO_RP" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="form-group">
                                        <h4><b>Observaciones</b></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">1.-</span>
                                    <input type="text" class="form-control" id="OBSERVACION1_RP" name="OBSERVACION1_RP">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">2.-</span>
                                    <input type="text" class="form-control" id="OBSERVACION2_RP" name="OBSERVACION2_RP">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">3.-</span>
                                    <input type="text" class="form-control" id="OBSERVACION3_RP" name="OBSERVACION3_RP">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">4.-</span>
                                    <input type="text" class="form-control" id="OBSERVACION4_RP" name="OBSERVACION4_RP">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">5.-</span>
                                    <input type="text" class="form-control" id="OBSERVACION5_RP" name="OBSERVACION5_RP">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-5">
                                    <label>¿El colaborador utilizará correo electrónico corporativo? </label>
                                </div>
                                <div class="col-4">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="CORREO_SI">Si</label>
                                        <input class="form-check-input" type="radio" name="CORREO_CORPORATIVO_RP" id="CORREO_SI" value="si">
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="CORREO_NO">No</label>
                                        <input class="form-check-input" type="radio" name="CORREO_CORPORATIVO_RP" id="CORREO_NO" value="no">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-5">
                                    <label>¿El colaborador utilizará teléfono celular corporativo? </label>
                                </div>
                                <div class="col-2">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="TELEFONO_SI">Si</label>
                                        <input class="form-check-input" type="radio" name="TELEFONO_CORPORATIVO_RP" id="TELEFONO_SI" value="si">
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="TELEFONO_NO">No</label>
                                        <input class="form-check-input" type="radio" name="TELEFONO_CORPORATIVO_RP" id="TELEFONO_NO" value="no">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-5">
                                    <label>¿El colaborador necesita acceso a software de la empresa? </label>
                                </div>
                                <div class="col-2">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="SOFTWARE_SI">Si</label>
                                        <input class="form-check-input" type="radio" name="SOFTWARE_RP" id="SOFTWARE_SI" value="si">
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="SOFTWARE_NO">No</label>
                                        <input class="form-check-input" type="radio" name="SOFTWARE_RP" id="SOFTWARE_NO" value="no">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-5">
                                    <label>¿El colaborador conducirá vehículo de la empresa? </label>
                                </div>
                                <div class="col-2">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="VEHICULO_SI">Si</label>
                                        <input class="form-check-input" type="radio" name="VEHICULO_EMPRESA_RP" id="VEHICULO_SI" value="si">
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="VEHICULO_NO">No</label>
                                        <input class="form-check-input" type="radio" name="VEHICULO_EMPRESA_RP" id="VEHICULO_NO" value="no">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12">
                                    <label>Nombre del solicitante *</label>
                                    <input type="text" class="form-control " id="NOMBRE_SOLICITA_RP" name="NOMBRE_SOLICITA_RP" readonly>
                                </div>
                            </div>

                            <div class="mb-3 mt-2">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label> Estado de aprobación:</label>
                                            <select class="form-control" id="ESTADO_SOLICITUD" name="ESTADO_SOLICITUD" required>
                                                <option selected disabled>Seleccione una opción</option>
                                                <option value="Aprobada">Aprobada</option>
                                                <option value="Rechazada">Rechazada</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6 mt-2">
                                        <label>Quien aprobó/rechazo *</label>
                                        <input type="text" class="form-control " id="NOMBRE_APROBO_RP" readonly>

                                        <input type="hidden" class="form-control " id="APROBO_ID" name="APROBO_ID">

                                    </div>
                                    <div class="col-6 mt-2">
                                        <label>Fecha de aprobación*</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_APROBO_RP" name="FECHA_APROBO_RP" required>
                                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>


                        <div id="MOSTRAR_ANTES" style="display: none">
                            <div class="row mb-3 mt-4">

                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="form-label text-center">Categoría</label>
                                        <select class="form-control" id="PUESTO_RP_ANTES" name="PUESTO_RP">
                                            <option value="0" selected disabled>Seleccione una opción</option>
                                            @foreach ($areas1 as $area2)
                                            <option value="{{ $area2->ID }}">{{ $area2->NOMBRE }}</option>
                                            @endforeach
                                        </select>



                                    </div>
                                </div>
                                <div class="col-4">
                                    <label class="form-label text-center">Documento*</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" id="DOCUMENTO_REQUISICION" name="DOCUMENTO_REQUISICION" accept=".pdf">
                                        <button type="button" class="btn btn-light btn-sm ms-2" id="quitarformato" style="display:none;">Quitar archivo</button>
                                    </div>
                                    <small id="errorArchivo" class="text-danger" style="display:none;">El archivo debe ser un PDF.</small>
                                </div>

                                <div class="col-4 text-center">
                                    <label class="form-label text-center">Fecha de creación *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="aaaa-mm-dd" id="FECHA_CREACION" name="FECHA_CREACION" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
                <div class="modal-footer mx-5">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarFormRP"><i class="bi bi-floppy-fill" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Guardar Requisición"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- ============================================================== -->
<!-- MODAL PERMISOS REC EMPLEADOS  -->
<!-- ============================================================== -->


<div class="modal fade" id="miModal_PERMISORECEMPLEADO" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioPERMISORECEMPLEADO" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Aviso de ausencia y/o permiso </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}


                    <div class="col-12 mb-3">
                        <label class="form-label">Seleccione el tipo *</label>
                        <select class="form-control" id="TIPO_SOLICITUD" name="TIPO_SOLICITUD" style="pointer-events:none; background-color:#e9ecef;">
                            <option value="" selected disabled>Seleccione una opción</option>
                            <option value="1">Aviso de ausencia y/o permiso</option>
                            <option value="2">Salida de almacén de materiales y/o equipos</option>
                            <option value="3">Solicitud de Vacaciones</option>
                        </select>
                    </div>

                    <div class="col-12 mt-3">
                        <div class="row">
                            <div class="col-9">
                                <label class="form-label">Solicitante </label>
                                <input type="text" class="form-control" id="SOLICITANTE_SALIDA" name="SOLICITANTE_SALIDA" readonly>
                            </div>

                            <div class="col-3">
                                <label class="form-label">Fecha de solicitud *</label>
                                <div class="input-group">
                                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_SALIDA" name="FECHA_SALIDA" required>
                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="PERMISO_AUSENCIA" style="display: block;">

                        <div class="col-12 mt-3">
                            <div class="row">
                                <div class="col-9">
                                    <label class="form-label">Cargo </label>
                                    <input type="text" class="form-control" id="CARGO_PERMISO" name="CARGO_PERMISO" readonly>
                                </div>

                                <div class="col-3">
                                    <label class="form-label">No. de empleado: </label>
                                    <input type="text" class="form-control" id="NOEMPLEADO_PERMISO" name="NOEMPLEADO_PERMISO" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <div class="row">
                                <div class="col-4">
                                    <label class="form-label">Concepto de ausencia *</label>
                                    <select class="form-control" id="CONCEPTO_PERMISO" name="CONCEPTO_PERMISO" required>
                                        <option value="" selected disabled>Seleccione una opción</option>
                                        <option value="1">Permiso</option>
                                        <option value="2">Incapacidad</option>
                                        <option value="3">Omitir registro en el checador</option>
                                        <option value="4">Fallecimiento</option>
                                        <option value="5">Matrimonio</option>
                                        <option value="6">Permiso de maternidad</option>
                                        <option value="7">Permiso de paternidad</option>
                                        <option value="8">Compensatorio </option>
                                        <option value="9">Otros (explique)</option>
                                    </select>
                                </div>

                                <div class="col-1">
                                    <label class="form-label">No. días </label>
                                    <input type="number" class="form-control" id="NODIAS_PERMISO" name="NODIAS_PERMISO">
                                </div>

                                <div class="col-1">
                                    <label class="form-label">No. horas </label>
                                    <input type="number" class="form-control" id="NOHORAS_PERMISO" name="NOHORAS_PERMISO">
                                </div>

                                <div class="col-3">
                                    <label class="form-label">Fecha inicial *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_INICIAL_PERMISO" name="FECHA_INICIAL_PERMISO" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>

                                <div class="col-3">
                                    <label class="form-label">Fecha Final *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_FINAL_PERMISO" name="FECHA_FINAL_PERMISO" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>

                                <div class="col-12 mt-3" id="EXPLIQUE_PERMISO" style="display: none;">
                                    <label class="form-label">Exlique </label>
                                    <textarea class="form-control" id="EXPLIQUE_PERMISO" name="EXPLIQUE_PERMISO" rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="form-label">Observaciones *</label>
                        <textarea class="form-control" id="OBSERVACIONES_REC" name="OBSERVACIONES_REC" rows="3" required></textarea>
                    </div>



                    <div class="mt-3">
                        <label class="form-label">Firmado por</label>
                        <input type="text" id="FIRMADO_POR" name="FIRMADO_POR" class="form-control" readonly required>
                    </div>

                    <div id="VISTO_BUENO_JEFE" style="display: block;">
                        <div class="col-12 mt-3 text-center">
                            <label class="form-label">Vo.Bo Jefe Inmediato</label>
                            <select class="form-control" id="DAR_BUENO" name="DAR_BUENO" required>
                                <option value="0" selected disabled>Seleccione una opción</option>
                                <option value="1">Aprobada</option>
                                <option value="2">Rechazada</option>
                            </select>
                        </div>

                        <div class="col-12 mt-3">
                            <div class="row">
                                <div class="col-8">
                                    <label class="form-label">Visto bueno</label>

                                    <input type="text" class="form-control" id="VISTO_BUENO" name="VISTO_BUENO" readonly>
                                </div>
                                <div class="col-4">
                                    <label class="form-label">Fecha Vo.Bo*</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_VISTO_SOLICITUD" name="FECHA_VISTO_SOLICITUD" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-3" id="MOTIVO_RECHAZO_JEFE_DIV" style="display: none;">
                            <label class="form-label">Motivo del rechazo del jefe inmediato</label>
                            <textarea class="form-control" id="MOTIVO_RECHAZO_JEFE" name="MOTIVO_RECHAZO_JEFE" rows="3" placeholder="Escriba el motivo de rechazo..."></textarea>
                        </div>

                    </div>

                    <div id="APROBACION_DIRECCION" style="display: block;">
                        <div class="col-12 mt-3">
                            <label for="ESTADO_APROBACION">Estado de Aprobación</label>
                            <div id="estado-container" class="p-2 rounded">
                                <select class="form-control" id="ESTADO_APROBACION" name="ESTADO_APROBACION" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="Aprobada">Aprobada</option>
                                    <option value="Rechazada">Rechazada</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 mt-3" id="motivo-rechazo-container" style="display: none;">
                            <label>Motivo del rechazo del que aprobo</label>
                            <textarea class="form-control" id="MOTIVO_RECHAZO" name="MOTIVO_RECHAZO" rows="3" placeholder="Escriba el motivo de rechazo..."></textarea>
                        </div>

                        <div class="col-12 mt-3">
                            <div class="row">
                                <div class="col-8">
                                    <label for="APROBACION">Quien aprueba</label>
                                    <input type="text" class="form-control" id="QUIEN_APROBACION" name="QUIEN_APROBACION" readonly required>
                                </div>
                                <div class="col-4">
                                    <label>Fecha *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_APRUEBA_SOLICITUD" name="FECHA_APRUEBA_SOLICITUD" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- ============================================================== -->
<!-- MODAL SOLICITUD DE VACACIONES  -->
<!-- ============================================================== -->

<div class="modal fade" id="miModal_RECURSOSEMPLEADOS" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioRECURSOSEMPLEADO" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Solicitud de Vacaciones</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}


                    <div class="col-12 mb-3">
                        <label class="form-label">Seleccione el tipo *</label>
                        <select class="form-control" id="TIPO_SOLICITUD" name="TIPO_SOLICITUD" style="pointer-events:none; background-color:#e9ecef;">
                            <option value="" selected disabled>Seleccione una opción</option>
                            <option value="1">Aviso de ausencia y/o permiso</option>
                            <option value="2">Salida de almacén de materiales y/o equipos</option>
                            <option value="3">Solicitud de Vacaciones</option>
                        </select>
                    </div>

                    <div class="col-12 mt-3">
                        <div class="row">
                            <div class="col-9">
                                <label class="form-label">Solicitante </label>
                                <input type="text" class="form-control" id="SOLICITANTE_SALIDA" name="SOLICITANTE_SALIDA" readonly>
                            </div>

                            <div class="col-3">
                                <label class="form-label">Fecha de solicitud *</label>
                                <div class="input-group">
                                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_SALIDA" name="FECHA_SALIDA" required>
                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="SOLICITUD_VACACIONES" style="display: block;">
                        <div class="col-12 mt-3">
                            <div class="row">
                                <div class="col-4">
                                    <label class="form-label">Área o Departamento: </label>
                                    <input type="text" class="form-control" id="AREA_VACACIONES" name="AREA_VACACIONES" readonly>
                                </div>
                                <div class="col-4">
                                    <label class="form-label">No. de empleado: </label>
                                    <input type="text" class="form-control" id="NOEMPLEADO_PERMISO_VACACIONES" name="NOEMPLEADO_PERMISO_VACACIONES" readonly>
                                </div>

                                <div class="col-4">
                                    <label class="form-label">Fecha Ingreso: </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_INGRESO_VACACIONES" name="FECHA_INGRESO_VACACIONES" required readonly>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>

                                <div class="col-3 mt-3">
                                    <label class="form-label">Año de servicio </label>
                                    <input type="number" class="form-control" id="ANIO_SERVICIO_VACACIONES" name="ANIO_SERVICIO_VACACIONES" required readonly>
                                </div>

                                <div class="col-3 mt-3">
                                    <label class="form-label">Días que corresponden</label>
                                    <input type="number" class="form-control" id="DIAS_CORRESPONDEN_VACACIONES" name="DIAS_CORRESPONDEN_VACACIONES" required readonly>
                                </div>

                                <div class="col-3 mt-3">
                                    <label class="form-label">Días a disfrutar</label>
                                    <input type="number" class="form-control" id="DIAS_DISFRUTAR_VACACIONES" name="DIAS_DISFRUTAR_VACACIONES" required>
                                </div>

                                <div class="col-3 mt-3">
                                    <label class="form-label">Días Pendientes</label>
                                    <input type="number" class="form-control" id="DIAS_PENDIENTES_VACACIONES" name="DIAS_PENDIENTES_VACACIONES" required readonly>
                                </div>

                                <input type="hidden" id="DIAS_TOMADOS_ANTERIORES" name="DIAS_TOMADOS_ANTERIORES">

                                <div class="col-12 mt-3">
                                    <h5 class="text-center">Período a Disfrutar:</h5>
                                </div>

                                <div class="col-6 mt-3">
                                    <label class="form-label">Desde Año: </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="DESDE_ANIO_VACACIONES" name="DESDE_ANIO_VACACIONES" required readonly>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>

                                <div class="col-6 mt-3">
                                    <label class="form-label">Hasta el Año: </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="HASTA_ANIO_VACACIONES" name="HASTA_ANIO_VACACIONES" required readonly>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>

                                <div class="col-4 mt-3">
                                    <label class="form-label">Fecha de inicio vacaciones: </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_INICIO_VACACIONES" name="FECHA_INICIO_VACACIONES" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>

                                <div class="col-4 mt-3">
                                    <label class="form-label">Fecha de terminación vacaciones: </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_TERMINACION_VACACIONES" name="FECHA_TERMINACION_VACACIONES" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>

                                <div class="col-4 mt-3">
                                    <label class="form-label">Día que inicia labores: </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_INICIALABORES_VACACIONES" name="FECHA_INICIALABORES_VACACIONES" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="form-label">Observaciones *</label>
                        <textarea class="form-control" id="OBSERVACIONES_REC" name="OBSERVACIONES_REC" rows="3" required></textarea>
                    </div>



                    <div class="mt-3">
                        <label class="form-label">Firmado por</label>
                        <input type="text" id="FIRMADO_POR" name="FIRMADO_POR" class="form-control" readonly required>
                    </div>

                    <div id="VISTO_BUENO_JEFE" style="display: block;">
                        <div class="col-12 mt-3 text-center">
                            <label class="form-label">Vo.Bo Jefe Inmediato</label>
                            <select class="form-control" id="DAR_BUENO" name="DAR_BUENO" required>
                                <option value="0" selected disabled>Seleccione una opción</option>
                                <option value="1">Aprobada</option>
                                <option value="2">Rechazada</option>
                            </select>
                        </div>

                        <div class="col-12 mt-3">
                            <div class="row">
                                <div class="col-8">
                                    <label class="form-label">Visto bueno</label>

                                    <input type="text" class="form-control" id="VISTO_BUENO" name="VISTO_BUENO" readonly>
                                </div>
                                <div class="col-4">
                                    <label class="form-label">Fecha Vo.Bo*</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_VISTO_SOLICITUD" name="FECHA_VISTO_SOLICITUD" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-3" id="MOTIVO_RECHAZO_JEFE_DIV" style="display: none;">
                            <label class="form-label">Motivo del rechazo del jefe inmediato</label>
                            <textarea class="form-control" id="MOTIVO_RECHAZO_JEFE" name="MOTIVO_RECHAZO_JEFE" rows="3" placeholder="Escriba el motivo de rechazo..."></textarea>
                        </div>

                    </div>

                    <div id="APROBACION_DIRECCION" style="display: block;">
                        <div class="col-12 mt-3">
                            <label for="ESTADO_APROBACION">Estado de Aprobación</label>
                            <div id="estado-container" class="p-2 rounded">
                                <select class="form-control" id="ESTADO_APROBACION" name="ESTADO_APROBACION" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="Aprobada">Aprobada</option>
                                    <option value="Rechazada">Rechazada</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 mt-3" id="motivo-rechazo-container" style="display: none;">
                            <label>Motivo del rechazo del que aprobo</label>
                            <textarea class="form-control" id="MOTIVO_RECHAZO" name="MOTIVO_RECHAZO" rows="3" placeholder="Escriba el motivo de rechazo..."></textarea>
                        </div>

                        <div class="col-12 mt-3">
                            <div class="row">
                                <div class="col-8">
                                    <label for="APROBACION">Quien aprueba</label>
                                    <input type="text" class="form-control" id="QUIEN_APROBACION" name="QUIEN_APROBACION" readonly required>
                                </div>
                                <div class="col-4">
                                    <label>Fecha *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_APRUEBA_SOLICITUD" name="FECHA_APRUEBA_SOLICITUD" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- ============================================================== -->
<!-- MODAL ASIGNACIONES EMPLEADOS  -->
<!-- ============================================================== -->


<div class="modal fade" id="modalAsignacionColaborador" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioASIGNACIONES" style="background-color: #ffffff;">

                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-box-seam"></i> Asignaciones del colaborador
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    {!! csrf_field() !!}

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <small class="text-muted">
                                Selecciona los equipos que deseas guardar
                            </small>
                        </div>
                    </div>

                    <table id="Tablasignacioncolaborador"
                        class="table table-hover table-bordered w-100 text-center">
                    </table>

                    <input type="hidden" id="ASIGNACIONES_ID" name="ASIGNACIONES_ID">

                    <div class="col-12 mb-3">
                        <label class="form-label"> Tipo de asignación *</label>
                        <select class="form-control" id="TIPO_ASIGNACION" name="TIPO_ASIGNACION" required>
                            <option value="" selected disabled>Seleccione una opción</option>
                            <option value="1">Equipos - otros</option>
                            <option value="2">EPP</option>
                        </select>
                    </div>


                    <div id="ASIGANCION_EPP" style="display:none;">

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Categoría</label>
                                <select class="form-control" id="categoriaEPP">
                                    <option value="">Seleccione categoría</option>
                                    <option value="Cabeza">Cabeza</option>
                                    <option value="Ojos y cara">Ojos y cara</option>
                                    <option value="Oídos">Oídos</option>
                                    <option value="Aparato respiratorio">Aparato respiratorio</option>
                                    <option value="Extremidades superiores">Extremidades superiores</option>
                                    <option value="Tronco">Tronco</option>
                                    <option value="Extremidades inferiores">Extremidades inferiores</option>
                                    <option value="Dotación">Dotación</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label>Equipo</label>
                                <select class="form-control" id="equipoEPP">
                                    <option value="">Seleccione equipo</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label>Talla</label>
                                <input type="text" class="form-control" id="tallaEPP">
                            </div>

                            <div class="col-md-1">
                                <label>Solic.</label>
                                <input type="number" class="form-control" id="cantidadSolicitada">
                            </div>

                            <div class="col-md-1">
                                <label>Entreg.</label>
                                <input type="number" class="form-control" id="cantidadEntregada">
                            </div>
                        </div>

                        <div class="mb-3">
                            <button type="button" class="btn btn-primary" id="agregarEPP">
                                Agregar equipo
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>Categoría</th>
                                        <th>Equipo</th>
                                        <th>Talla</th>
                                        <th>Solicitada</th>
                                        <th>Entregada</th>
                                        <th>Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaEPPBody"></tbody>
                            </table>
                        </div>

                        <input type="hidden" name="EPP_JSON" id="EPP_JSON">

                    </div>


                    <div class="col-12 mt-3">
                        <div class="row">
                            <div class="col-8">
                                <label class="form-label">Personal que asigna</label>
                                <input type="text" class="form-control" id="PERSONAL_ASIGNA" name="PERSONAL_ASIGNA" readonly required>
                            </div>
                            <div class="col-4">
                                <label class="form-label">Fecha *</label>
                                <div class="input-group">
                                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_ASIGNACION" name="FECHA_ASIGNACION" required>
                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                </div>
                            </div>

                            <div class="col-12 mt-3" id="FIRMA_ASIGNACION" style="display:block; margin-top:10px;">
                                <div class="row justify-content-center">
                                    <div class="col-6 text-center">
                                        <button type="button"
                                            id="FIRMAR_SOLICITUD"
                                            class="btn btn-info"
                                            data-usuario="{{ Auth::user()->EMPLEADO_NOMBRE }} {{ Auth::user()->EMPLEADO_APELLIDOPATERNO }} {{ Auth::user()->EMPLEADO_APELLIDOMATERNO }}">
                                            <i class="bi bi-pen-fill"></i> Firmar asignación
                                        </button>

                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <label class="form-label">Almacenista</label>
                                <input type="text" class="form-control" id="ALMACENISTA_ASIGNACION" name="ALMACENISTA_ASIGNACION">
                            </div>
                        </div>
                    </div>



                    <div class="mt-3" id="SUBIR_DOCUMENTO_ASIGNACION" style="display: none;">
                        <label>Subir documento</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="DOCUMENTO_ASIGNACION" name="DOCUMENTO_ASIGNACION" accept=".pdf" style="width: auto; flex: 1;">
                            <button type="button" class="btn btn-light btn-sm ms-2" id="quitar_asignacion" style="display:none;">Quitar archivo</button>
                        </div>
                    </div>
                    <div id="ASIGNACION_ERROR" class="text-danger" style="display:none;">Por favor, sube un archivo PDF</div>






                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarASIGNACIONES">Guardar</button>
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