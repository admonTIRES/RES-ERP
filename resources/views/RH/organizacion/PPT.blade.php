@extends('principal.maestra')

@section('contenido')



<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-filetype-ppt"></i>&nbsp;Perfil de puesto de trabajo&nbsp;(PPT)</h3>


        <button type="button" class="btn btn-light waves-effect waves-light botonnuevo_ppt" id="nuevo_ppt" style="margin-left: auto;">
            Nuevo PPT &nbsp;<i class="bi bi-plus-circle"></i>
        </button>
    </ol>

    <div class="card-body">
        <table id="TablaPPT" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">

        </table>
    </div>

</div>




<!-- MODAL  -->
<div class="modal modal-fullscreen fade" id="miModal_PPT" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioPPT" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h5 class="modal-title" id="miModalLabel">Perfil de puesto de trabajo&nbsp;(PPT)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>


                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="row">
                        <input type="hidden" class="form-control" id="USUARIO_ID" name="USUARIO_ID" value="0">

                    </div>
                    <div class="row">
                        <div class="row mb-3">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Nombre de la categoría *</label>
                                    <select class="form-control" id="DEPARTAMENTO_AREA_ID" name="DEPARTAMENTO_AREA_ID" required>
                                        <option value="0" selected disabled>Seleccione una opción</option>
                                        @foreach ($areas as $area)
                                        <option value="{{ $area->ID }}" data-lugar="{{ $area->LUGAR}}" data-proposito="{{ $area->PROPOSITO }}" data-lider="{{ $area->LIDER }}">{{ $area->NOMBRE }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Nombre del trabajador</label>
                                    <input type="text" class="form-control desabilitado" id="NOMBRE_TRABAJADOR_PPT" name="NOMBRE_TRABAJADOR_PPT" disabled>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Área de trabajo</label>
                                    <input type="text" class="form-control" id="AREA_TRABAJADOR_PPT" name="AREA_TRABAJADOR_PPT" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Propósito o finalidad de la categoría</label>
                                    <textarea class="form-control " id="PROPOSITO_FINALIDAD_PPT" name="PROPOSITO_FINALIDAD_PPT" rows="3" readonly></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- I. Características generales -->
                        <div class="row mb-3">
                            <div class="col-12 text-center">
                                <div style="display: inline-flex; align-items: center; gap: 10px;">
                                    <h4 style="margin: 0;">I. Características generales</h4>
                                </div>
                            </div>
                        </div>


                        <div class="row mb-3">
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Edad (mínima / máxima) *</label>
                                    <select class="form-control" id="EDAD_PPT" name="EDAD_PPT">
                                        <option value="0" selected disabled>Seleccione una opción</option>
                                        <option value=""></option>
                                        <option value="Indistinto">Indistinto</option>
                                        <option value="18-25">18-25</option>
                                        <option value="26-35">26-35</option>
                                        <option value="36-45">36-45</option>
                                        <option value="Mayor de 45">Mayor de 45</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-3">
                                <br>
                                <div class="d-flex align-items-center">
                                    <div class="radio-container" style="background-color: #e6f2d9; padding: 5px 10px; border-radius: 5px; display: flex; align-items: center; gap: 10px;">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="EDAD_CUMPLE_PPT" id="EDAD_CUMPLE_SI" value="si" disabled>
                                            <label class="form-check-label" for="EDAD_CUMPLE_SI">Si</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="EDAD_CUMPLE_PPT" id="EDAD_CUMPLE_NO" value="no" disabled>
                                            <label class="form-check-label" for="EDAD_CUMPLE_NO">No</label>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <div class="col-3">
                                <div class="form-group">
                                    <label>Género *</label>
                                    <select class="form-control" id="GENERO_PPT" name="GENERO_PPT">
                                        <option value="0" selected disabled>Seleccione una opción</option>
                                        <option value=""></option>
                                        <option value="Indistinto">Indistinto</option>
                                        <option value="Masculino">Masculino</option>
                                        <option value="Femenino">Femenino</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-3">
                                <br>
                                <div class="d-flex align-items-center">
                                    <br>
                                    <div class="radio-container" style="background-color: #e6f2d9; padding: 5px 10px; border-radius: 5px; display: flex; align-items: center; gap: 10px;">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="GENERO_CUMPLE_PPT" id="GENERO_CUMPLE_SI" value="si" disabled>
                                            <label class="form-check-label" for="GENERO_CUMPLE_SI">Si</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="GENERO_CUMPLE_PPT" id="GENERO_CUMPLE_NO" value="no" disabled>
                                            <label class="form-check-label" for="GENERO_CUMPLE_NO">No</label>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="row mb-3">
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Estado civil *</label>
                                    <select class="form-control" id="ESTADO_CIVIL_PPT" name="ESTADO_CIVIL_PPT">
                                        <option value="0" selected disabled>Seleccione una opción</option>
                                        <option value=""></option>
                                        <option value="Indistinto">Indistinto</option>
                                        <option value="Soltero(a)">Soltero (a)</option>
                                        <option value="Casado(a)">Casado (a)</option>
                                        <option value="Separado(a)">Separado (a)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-3">
                                <br>
                                <div class="d-flex align-items-center">
                                    <div class="radio-container" style="background-color: #e6f2d9; padding: 5px 10px; border-radius: 5px; display: flex; align-items: center; gap: 10px;">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="ESTADO_CIVIL_CUMPLE_PPT" id="ESTADO_CUMPLE_SI" value="si" disabled>
                                            <label class="form-check-label" for="ESTADO_CUMPLE_SI">Si</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="ESTADO_CIVIL_CUMPLE_PPT" id="ESTADO_CUMPLE_NO" value="no" disabled>
                                            <label class="form-check-label" for="ESTADO_CUMPLE_NO">No</label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Nacionalidad *</label>
                                    <select class="form-control" id="NACIONALIDAD_PPT" name="NACIONALIDAD_PPT">
                                        <option value="0" selected disabled>Seleccione una opción</option>
                                        <option value=""></option>
                                        <option value="Indistinto">Indistinto</option>
                                        <option value="Mexicana">Mexicana</option>
                                        <option value="Extranjero">Extranjero</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-3">
                                <br>
                                <div class="d-flex align-items-center">
                                    <div class="radio-container" style="background-color: #e6f2d9; padding: 5px 10px; border-radius: 5px; display: flex; align-items: center; gap: 10px;">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="NACIONALIDAD_CUMPLE_PPT" id="NACIONALIDAD_CUMPLE_SI" value="si" disabled>
                                            <label class="form-check-label" for="NACIONALIDAD_CUMPLE_SI">Si</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="NACIONALIDAD_CUMPLE_PPT" id="NACIONALIDAD_CUMPLE_NO" value="no" disabled>
                                            <label class="form-check-label" for="NACIONALIDAD_CUMPLE_NO">No</label>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="row mb-3">
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Persona con discapacidad *</label>
                                    <select class="form-control" id="DISCAPACIDAD_PPT" name="DISCAPACIDAD_PPT">
                                        <option value="0" selected disabled>Seleccione una opción</option>
                                        <option value=""></option>
                                        <option value="Indistinto">Indistinto</option>
                                        <option value="Ninguna">Ninguna</option>
                                        <option value="Motriz">Motriz</option>
                                        <option value="Visual">Visual</option>
                                        <option value="Auditiva">Auditiva</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-3">
                                <br>
                                <div class="d-flex align-items-center">
                                    <div class="radio-container" style="background-color: #e6f2d9; padding: 5px 10px; border-radius: 5px; display: flex; align-items: center; gap: 10px;">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="DISCAPACIDAD_CUMPLE_PPT" id="DISCAPACIDAD_CUMPLE_SI" value="si" disabled>
                                            <label class="form-check-label" for="DISCAPACIDAD_CUMPLE_SI">Si</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="DISCAPACIDAD_CUMPLE_PPT" id="DISCAPACIDAD_CUMPLE_NO" value="no" disabled>
                                            <label class="form-check-label" for="DISCAPACIDAD_CUMPLE_NO">No</label>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label>¿Cuál?</label>
                                    <input type="text" class="form-control desabilitado" id="CUAL_PPT" name="CUAL_PPT" disabled>
                                </div>
                            </div>
                        </div>

                        <!-- II. Formación académica -->
                        <hr>

                        <div class="row mb-3">
                            <div class="col-12 text-center">
                                <div style="display: inline-flex; align-items: center; gap: 10px;">
                                    <h4>II. Formación académica</h4>
                                    <input type="text" value="20" style="width: 40px; height: 40px; text-align: center;" readonly>
                                    <span style="font-size: 18px;">%</span>
                                    <input type="text" style="width: 40px; height: 40px; text-align: center;" id="SUMA_FORMACION" name="SUMA_FORMACION" readonly>
                                    <span style="font-size: 18px;">%</span>
                                </div>
                            </div>
                        </div>


                        <div class="row mb-3">
                            {{-- Area de escuela --}}
                            <div class="col-4">
                                <div class="row">
                                    <!-- SECUNDARIA -->
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="form-group">
                                                    <label>Secundaria</label>
                                                    <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_SECUNDARIA" name="PORCENTAJE_SECUNDARIA">
                                                    <span style="font-size: 18px;">%</span>
                                                    <select class="form-control mt-1" id="SECUNDARIA_PPT" name="SECUNDARIA_PPT">
                                                        <option value="0" selected disabled>Seleccione una opción</option>
                                                        <option value=""></option>
                                                        <option value="Incompleta">Incompleta</option>
                                                        <option value="Completa">Completa</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <br><br>
                                                <div class="d-flex align-items-center">
                                                    <div class="radio-container">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input desabilitado" type="radio" name="SECUNDARIA_CUMPLE_PPT" id="SECUNDARIA_CUMPLE_SI" value="si" disabled>
                                                            <label class="form-check-label" for="SECUNDARIA_CUMPLE_SI">Si</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input desabilitado" type="radio" name="SECUNDARIA_CUMPLE_PPT" id="SECUNDARIA_CUMPLE_NO" value="no" disabled>
                                                            <label class="form-check-label" for="SECUNDARIA_CUMPLE_NO">No</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- TECNICA BASICA -->
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="form-group">
                                                    <label>Medio superior</label>
                                                    <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_MEDIASUPERIOR" name="PORCENTAJE_MEDIASUPERIOR">
                                                    <span style="font-size: 18px;">%</span>
                                                    <select class="form-control mt-1" id="TECNICA_PPT" name="TECNICA_PPT">
                                                        <option value="0" selected disabled>Seleccione una opción</option>
                                                        <option value=""></option>
                                                        <option value="Incompleta">Incompleta</option>
                                                        <option value="Completa">Completa</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <br><br>
                                                <div class="radio-container">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input desabilitado" type="radio" name="TECNICA_CUMPLE_PPT" id="TECNICA_CUMPLE_SI" value="si" disabled>
                                                        <label class="form-check-label" for="TECNICA_CUMPLE_SI">Si</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input desabilitado" type="radio" name="TECNICA_CUMPLE_PPT" id="TECNICA_CUMPLE_NO" value="no" disabled>
                                                        <label class="form-check-label" for="TECNICA_CUMPLE_NO">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- TECNICO SUPERIOR -->
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="form-group">
                                                    <label>Técnico superior</label>
                                                    <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_TECNICOSUPERIOR" name="PORCENTAJE_TECNICOSUPERIOR">
                                                    <span style="font-size: 18px;">%</span>
                                                    <select class="form-control mt-1" id="TECNICO_PPT" name="TECNICO_PPT">
                                                        <option value="0" selected disabled>Seleccione una opción</option>
                                                        <option value=""></option>
                                                        <option value="Incompleta">Incompleta</option>
                                                        <option value="Completa">Completa</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <br><br>
                                                <div class="radio-container">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input desabilitado" type="radio" name="TECNICO_CUMPLE_PPT" id="TECNICO_CUMPLE_SI" value="si" disabled>
                                                        <label class="form-check-label" for="TECNICO_CUMPLE_SI">Si</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input desabilitado" type="radio" name="TECNICO_CUMPLE_PPT" id="TECNICO_CUMPLE_NO" value="no" disabled>
                                                        <label class="form-check-label" for="TECNICO_CUMPLE_NO">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- UNIVERSITARIO -->
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="form-group">
                                                    <label>Universitario (Lic.)</label>
                                                    <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_UNIVERSITARIO" name="PORCENTAJE_UNIVERSITARIO">
                                                    <span style="font-size: 18px;">%</span>
                                                    <select class="form-control mt-1" id="UNIVERSITARIO_PPT" name="UNIVERSITARIO_PPT">
                                                        <option selected disabled>Seleccione una opción</option>
                                                        <option value=""></option>
                                                        <option value="Incompleta">Incompleta</option>
                                                        <option value="Completa">Completa</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <br><br>
                                                <div class="radio-container">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input desabilitado" type="radio" name="UNIVERSITARIO_CUMPLE_PPT" id="UNIVERSITARIO_CUMPLE_SI" value="si" disabled>
                                                        <label class="form-check-label" for="UNIVERSITARIO_CUMPLE_SI">Si</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input desabilitado" type="radio" name="UNIVERSITARIO_CUMPLE_PPT" id="UNIVERSITARIO_CUMPLE_NO" value="no" disabled>
                                                        <label class="form-check-label" for="UNIVERSITARIO_CUMPLE_NO">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Situación académica   --}}
                            <div class="col-4">
                                <div class="row">
                                    <!-- SECUNDARIA -->
                                    <div class="col-12 mb-5">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="form-group">
                                                    <label>Situación académica *</label>
                                                    <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_SITUACIONACADEMICA" name="PORCENTAJE_SITUACIONACADEMICA">
                                                    <span style="font-size: 18px;">%</span>
                                                    <select class="form-control mt-1" id="SITUACION_PPT" name="SITUACION_PPT">
                                                        <option value="0" selected disabled>Seleccione una opción</option>
                                                        <option value=""></option>
                                                        <option value="Egresado">Egresado</option>
                                                        <option value="Bachiller">Bachiller</option>
                                                        <option value="Titulado">Titulado</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <br><br>
                                                <div class="radio-container">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input desabilitado" type="radio" name="SITUACION_CUMPLE_PPT" id="SITUACION_CUMPLE_SI" value="si" disabled>
                                                        <label class="form-check-label" for="SITUACION_CUMPLE_SI">Si</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input desabilitado" type="radio" name="SITUACION_CUMPLE_PPT" id="SITUACION_CUMPLE_NO" value="no" disabled>
                                                        <label class="form-check-label" for="SITUACION_CUMPLE_NO">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Cédula profesional  -->
                                    <div class="col-12 mt-5">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="form-group">
                                                    <label>Cédula profesional *</label>
                                                    <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CEDULA" name="PORCENTAJE_CEDULA">
                                                    <span style="font-size: 18px;">%</span>
                                                    <select class="form-control mt-1" id="CEDULA_PPT" name="CEDULA_PPT">
                                                        <option selected disabled>Seleccione una opción</option>
                                                        <option value=""></option>
                                                        <option value="Aplica">Aplica</option>
                                                        <option value="No aplica">No aplica</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <br><br>
                                                <div class="radio-container">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input desabilitado desabilitado" type="radio" name="CEDULA_CUMPLE_PPT" id="CEDULA_CUMPLE_SI" value="si" disabled>
                                                        <label class="form-check-label" for="CEDULA_CUMPLE_SI">Si</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input desabilitado desabilitado" type="radio" name="CEDULA_CUMPLE_PPT" id="CEDULA_CUMPLE_NO" value="no" disabled>
                                                        <label class="form-check-label" for="CEDULA_CUMPLE_NO">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Áreas de conocimientos --}}
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-8 ">
                                                <div class="form-group">
                                                    <label>Área de conocimiento 1</label>
                                                    <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_AREA1" name="PORCENTAJE_AREA1">
                                                    <span style="font-size: 18px;">%</span>
                                                    <select class="form-control mt-1" id="AREA1_PPT" name="AREA1_PPT">
                                                        <option selected disabled>Seleccione una opción</option>
                                                        <option value=""></option>
                                                        <option value="N/A">N/A</option>
                                                        <option value="Agronomía">Agronomía</option>
                                                        <option value="C. Educación">C. Educación</option>
                                                        <option value="C. Naturales">C. Naturales</option>
                                                        <option value="C. Salud">C. Salud</option>
                                                        <option value="C. Sociales">C. Sociales</option>
                                                        <option value="Administración">Administración</option>
                                                        <option value="Ingeniería">Ingeniería</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <br><br>
                                                <div class="radio-container">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input desabilitado" type="radio" name="AREA1_CUMPLE_PPT" id="AREA1_CUMPLE_SI" value="si" disabled>
                                                        <label class="form-check-label" for="AREA1_CUMPLE_SI">Si</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input desabilitado" type="radio" name="AREA1_CUMPLE_PPT" id="AREA1_CUMPLE_NO" value="no" disabled>
                                                        <label class="form-check-label" for="AREA1_CUMPLE_NO">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- AREA 2 -->
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="form-group">
                                                    <label>Área de conocimiento 2</label>
                                                    <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_AREA2" name="PORCENTAJE_AREA2">
                                                    <span style="font-size: 18px;">%</span>
                                                    <select class="form-control mt-1" id="AREA2_PPT" name="AREA2_PPT">
                                                        <option selected disabled>Seleccione una opción</option>
                                                        <option value=""></option>
                                                        <option value="N/A">N/A</option>
                                                        <option value="Agronomía">Agronomía</option>
                                                        <option value="C. Educación">C. Educación</option>
                                                        <option value="C. Naturales">C. Naturales</option>
                                                        <option value="C. Salud">C. Salud</option>
                                                        <option value="C. Sociales">C. Sociales</option>
                                                        <option value="Administración">Administración</option>
                                                        <option value="Ingeniería">Ingeniería</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <br><br>
                                                <div class="radio-container">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input desabilitado desabilitado" type="radio" name="AREA2_CUMPLE_PPT" id="AREA2_CUMPLE_SI" value="si" disabled>
                                                        <label class="form-check-label" for="AREA2_CUMPLE_SI">Si</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input desabilitado desabilitado" type="radio" name="AREA2_CUMPLE_PPT" id="AREA2_CUMPLE_NO" value="no" disabled>
                                                        <label class="form-check-label" for="AREA2_CUMPLE_NO">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- AREA 3 -->
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="form-group">
                                                    <label>Área de conocimiento 3</label>
                                                    <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_AREA3" name="PORCENTAJE_AREA3">
                                                    <span style="font-size: 18px;">%</span>
                                                    <select class="form-control mt-1" id="AREA3_PPT" name="AREA3_PPT">
                                                        <option selected disabled>Seleccione una opción</option>
                                                        <option value=""></option>
                                                        <option value="N/A">N/A</option>
                                                        <option value="Agronomía">Agronomía</option>
                                                        <option value="C. Educación">C. Educación</option>
                                                        <option value="C. Naturales">C. Naturales</option>
                                                        <option value="C. Salud">C. Salud</option>
                                                        <option value="C. Sociales">C. Sociales</option>
                                                        <option value="Administración">Administración</option>
                                                        <option value="Ingeniería">Ingeniería</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <br><br>
                                                <div class="radio-container">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input desabilitado" type="radio" name="AREA3_CUMPLE_PPT" id="AREA3_CUMPLE_SI" value="si" disabled>
                                                        <label class="form-check-label" for="AREA3_CUMPLE_SI">Si</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input desabilitado" type="radio" name="AREA3_CUMPLE_PPT" id="AREA3_CUMPLE_NO" value="no" disabled>
                                                        <label class="form-check-label" for="AREA3_CUMPLE_NO">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- AREA 4 -->
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="form-group">
                                                    <label>Área de conocimiento 4</label>
                                                    <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_AREA4" name="PORCENTAJE_AREA4">
                                                    <span style="font-size: 18px;">%</span>
                                                    <select class="form-control mt-1" id="AREA4_PPT" name="AREA4_PPT">
                                                        <option selected disabled>Seleccione una opción</option>
                                                        <option value=""></option>
                                                        <option value="N/A">N/A</option>
                                                        <option value="Agronomía">Agronomía</option>
                                                        <option value="C. Educación">C. Educación</option>
                                                        <option value="C. Naturales">C. Naturales</option>
                                                        <option value="C. Salud">C. Salud</option>
                                                        <option value="C. Sociales">C. Sociales</option>
                                                        <option value="Administración">Administración</option>
                                                        <option value="Ingeniería">Ingeniería</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <br><br>
                                                <div class="radio-container">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input desabilitado" type="radio" name="AREA4_CUMPLE_PPT" id="AREA4_CUMPLE_SI" value="si" disabled>
                                                        <label class="form-check-label" for="AREA4_CUMPLE_SI">Si</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input desabilitado" type="radio" name="AREA4_CUMPLE_PPT" id="AREA4_CUMPLE_NO" value="no" disabled>
                                                        <label class="form-check-label" for="AREA4_CUMPLE_NO">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Área de conocimiento específica requerida *</label>
                                    <textarea class="form-control" id="AREA_REQUERIDA_PPT" name="AREA_REQUERIDA_PPT" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Área de conocimiento del trabajador</label>
                                    <input type="text" class="form-control desabilitado" id="AREA_CONOCIMIENTO_PPT" name="AREA_CONOCIMIENTO_PPT" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12 ">
                                <h6>Estudios de posgrado requeridos</h6>
                            </div>
                        </div>

                        <div class="row mb-1">
                            <div class="col-1 mt-1">
                                <label>Especialidad</label>
                                <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_ESPECIALIDAD" name="PORCENTAJE_ESPECIALIDAD">
                                <span style="font-size: 18px;">%</span>
                            </div>
                            <div class="col-1 mt-1">
                                <div class="form-group text-center">
                                    <label for="ESPECIALIDAD_SI">Egresado&nbsp;&nbsp;&nbsp;</label>
                                    <input class="form-check-input" type="radio" name="EGRESADO_ESPECIALIDAD_PPT" id="ESPECIALIDAD_SI" value="*E">

                                </div>
                            </div>
                            <div class="col-1 mt-1">
                                <div class="form-group text-center">
                                    <label for="ESPECIALIDAD_NO">Grado/título</label>
                                    <input class="form-check-input " type="radio" name="EGRESADO_ESPECIALIDAD_PPT" id="ESPECIALIDAD_NO" value="*D">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="radio-container">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input desabilitado" type="radio" name="ESPECIALIDAD_CUMPLE_PPT" id="ESPECIALIDAD_CUMPLE_SI" value="si" disabled>
                                        <label class="form-check-label" for="ESPECIALIDAD_CUMPLE_SI">Si</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input desabilitado" type="radio" name="ESPECIALIDAD_CUMPLE_PPT" id="ESPECIALIDAD_CUMPLE_NO" value="no" disabled>
                                        <label class="form-check-label" for="ESPECIALIDAD_CUMPLE_NO">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Área de conocimiento requerida *</label>
                                    <input type="text" class="form-control" id="AREAREQUERIDA_CONOCIMIENTO_PPT" name="AREAREQUERIDA_CONOCIMIENTO_PPT">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-1 mt-2">
                                <label>Maestría</label>
                                <br>
                                <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_MAESTRIA" name="PORCENTAJE_MAESTRIA">
                                <span style="font-size: 18px;">%</span>
                            </div>

                            <div class="col-1 mt-2">
                                <div class="form-group text-center">
                                    <label for="MAESTRIA_SI">Egresado &nbsp;&nbsp;&nbsp;</label>
                                    <input class="form-check-input " type="radio" name="EGRESADO_MAESTRIA_PPT" id="MAESTRIA_SI" value="*E">
                                </div>
                            </div>
                            <div class="col-1 mt-2">
                                <div class="form-group text-center">
                                    <label for="MAESTRIA_NO">Grado/título</label>
                                    <input class="form-check-input " type="radio" name="EGRESADO_MAESTRIA_PPT" id="MAESTRIA_NO" value="*D">
                                </div>
                            </div>
                            <div class="col-2 mt-2">
                                <div class="radio-container">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input desabilitado" type="radio" name="MAESTRIA_CUMPLE_PPT" id="MAESTRIA_CUMPLE_SI" value="si" disabled>
                                        <label class="form-check-label" for="MAESTRIA_CUMPLE_SI">Si</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input desabilitado" type="radio" name="MAESTRIA_CUMPLE_PPT" id="MAESTRIA_CUMPLE_NO" value="no" disabled>
                                        <label class="form-check-label" for="MAESTRIA_CUMPLE_NO">No</label>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row mb-1">
                            <div class="col-1 mt-4">
                                <label>Doctorado</label>
                                <br>
                                <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_DOCTORADO" name="PORCENTAJE_DOCTORADO">
                                <span style="font-size: 18px;">%</span>
                            </div>
                            <div class="col-1 mt-4">
                                <div class="form-group text-center">
                                    <label for="DOCTORADO_SI">Egresado &nbsp;&nbsp;&nbsp;</label>
                                    <input class="form-check-input " type="radio" name="EGRESADO_DOCTORADO_PPT" id="DOCTORADO_SI" value="*E">
                                </div>
                            </div>
                            <div class="col-1 mt-4 ">
                                <div class="form-group text-center">
                                    <label for="DOCTORADO_NO">Grado/título</label>
                                    <input class="form-check-input " type="radio" name="EGRESADO_DOCTORADO_PPT" id="DOCTORADO_NO" value="*D">
                                </div>
                            </div>
                            <div class="col-2 mt-4">
                                <div class="radio-container">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input desabilitado" type="radio" name="DOCTORADO_CUMPLE_PPT" id="DOCTORADO_CUMPLE_SI" value="si" disabled>
                                        <label class="form-check-label" for="DOCTORADO_CUMPLE_SI">Si</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input desabilitado" type="radio" name="DOCTORADO_CUMPLE_PPT" id="DOCTORADO_CUMPLE_NO" value="no" disabled>
                                        <label class="form-check-label" for="DOCTORADO_CUMPLE_NO">No</label>
                                    </div>
                                </div>

                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Área de conocimiento del trabajador</label>
                                    <input type="text" class="form-control desabilitado" id="AREA_CONOCIMIENTO_TRABAJADOR_PPT" name="AREA_CONOCIMIENTO_TRABAJADOR_PPT" disabled>
                                </div>
                            </div>
                        </div>

                        <!-- III. Conocimientos adicionales -->
                        <br>
                        <br<br>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-12 text-center">
                                    <h4>III. Conocimientos adicionales</h4>
                                    <input type="text" value="10" style="width: 40px; height: 40px; text-align: center;" readonly>
                                    <span style="font-size: 18px;">%</span>
                                    <input type="text" style="width: 40px; height: 40px; text-align: center;" id="SUMA_CONOCIMIENTO" name="SUMA_CONOCIMIENTO" readonly>
                                    <span style="font-size: 18px;">%</span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th rowspan="2">Ofimática</th>
                                                <th colspan="5" class="text-center">Nivel de dominio </th>
                                            </tr>
                                            <tr>
                                                <th class="text-center">Aplica</th>
                                                <th class="text-center">Bajo</th>
                                                <th class="text-center">Medio</th>
                                                <th class="text-center">Alto</th>
                                                <th>Si</th>
                                                <th>No</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr style="height: 5px;"></tr>

                                            <tr>
                                                <td>Word <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_WORD" name="PORCENTAJE_WORD">
                                                    <span style="font-size: 18px;">%</span>
                                                </td>
                                                <td class="text-center">
                                                    <label for="WORD_APLICA_PPT_si">Si</label>
                                                    <input class="form-check-input" type="radio" name="WORD_APLICA_PPT" id="WORD_APLICA_PPT_si" value="si">
                                                    <label for="WORD_APLICA_PPT_no">No</label>
                                                    <input class="form-check-input" type="radio" name="WORD_APLICA_PPT" id="WORD_APLICA_PPT_no" value="no">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="word" id="WORD_BAJO_PPT" name="WORD_BAJO_PPT" value="X">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="word" id="WORD_MEDIO_PPT" name="WORD_MEDIO_PPT" value="X">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="word" id="WORD_ALTO_PPT" name="WORD_ALTO_PPT" value="X">
                                                </td>

                                                <td>
                                                    <div class="radio-container">
                                                        <label class="form-check-label" for="WORD_CUMPLE_SI">Si</label>
                                                        <input class="form-check-input desabilitado" type="radio" name="WORD_CUMPLE_PPT" id="WORD_CUMPLE_SI" value="si" disabled>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="radio-container">
                                                        <label class="form-check-label" for="WORD_CUMPLE_NO">No</label>
                                                        <input class="form-check-input desabilitado" type="radio" name="WORD_CUMPLE_PPT" id="WORD_CUMPLE_NO" value="no" disabled>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr style="height: 5px;"></tr>

                                            <tr>
                                                <td>Excel <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_EXCEL" name="PORCENTAJE_EXCEL">
                                                    <span style="font-size: 18px;">%</span>
                                                </td>
                                                <td class="text-center">
                                                    <label for="EXCEL_APLICA_PPT_si">Si</label>
                                                    <input class="form-check-input" type="radio" name="EXCEL_APLICA_PPT" id="EXCEL_APLICA_PPT_si" value="si">
                                                    <label for="EXCEL_APLICA_PPT_no">No</label>
                                                    <input class="form-check-input" type="radio" name="EXCEL_APLICA_PPT" id="EXCEL_APLICA_PPT_no" value="no">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="excel" id="EXCEL_BAJO_PPT" name="EXCEL_BAJO_PPT" value="X">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="excel" id="EXCEL_MEDIO_PPT" name="EXCEL_MEDIO_PPT" value="X">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="excel" id="EXCEL_ALTO_PPT" name="EXCEL_ALTO_PPT" value="X">
                                                </td>
                                                <td>
                                                    <div class="radio-container">
                                                        <label class="form-check-label" for="EXCEL_CUMPLE_SI">Si</label>
                                                        <input class="form-check-input desabilitado" type="radio" name="EXCEL_CUMPLE_PPT" id="EXCEL_CUMPLE_SI" value="si" disabled>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="radio-container">
                                                        <label class="form-check-label" for="EXCEL_CUMPLE_NO">No</label>
                                                        <input class="form-check-input desabilitado" type="radio" name="EXCEL_CUMPLE_PPT" id="EXCEL_CUMPLE_NO" value="no" disabled>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr style="height: 5px;"></tr>

                                            <tr>
                                                <td>Power Point <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_POWERPOINT" name="PORCENTAJE_POWERPOINT">
                                                    <span style="font-size: 18px;">%</span>
                                                </td>
                                                <td class="text-center">
                                                    <label for="POWER_APLICA_PPT_si">Si</label>
                                                    <input class="form-check-input" type="radio" name="POWER_APLICA_PPT" id="POWER_APLICA_PPT_si" value="si">
                                                    <label for="POWER_APLICA_PPT_no">No</label>
                                                    <input class="form-check-input" type="radio" name="POWER_APLICA_PPT" id="POWER_APLICA_PPT_no" value="no">

                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="power" id="POWER_BAJO_PPT" name="POWER_BAJO_PPT" value="X">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="power" id="POWER_MEDIO_PPT" name="POWER_MEDIO_PPT" value="X">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="power" id="POWER_ALTO_PPT" name="POWER_ALTO_PPT" value="X">
                                                </td>
                                                <td>
                                                    <div class="radio-container">
                                                        <label class="form-check-label" for="POWER_CUMPLE_SI">Si</label>
                                                        <input class="form-check-input  desabilitado desabilitado" type="radio" name="POWER_CUMPLE_PPT" id="POWER_CUMPLE_SI" value="si" disabled>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="radio-container">
                                                        <label class="form-check-label" for="POWER _CUMPLE_NO">No</label>
                                                        <input class="form-check-input  desabilitado desabilitado" type="radio" name="POWER_CUMPLE_PPT" id="POWER _CUMPLE_NO" value="no" disabled>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-6">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th colspan="10" class="text-center">Nivel de dominio</th>
                                            </tr>
                                            <tr>
                                                <th class="text-center">Idioma</th>
                                                <th class="text-center">Aplica </th>
                                                <th class="text-center">Básico<br> A1-A2</th>
                                                <th class="text-center">Intermedio <br> B1-B2</th>
                                                <th class="text-center">Avanzado <br> C1-C2</th>
                                                <th class="text-center">Si</th>
                                                <th class="text-center">No</th>
                                                <th class="text-center">%</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>

                                                <td>
                                                    <input type="text" class="form-control" id="NOMBRE_IDIOMA1_PPT" name="NOMBRE_IDIOMA1_PPT">
                                                </td>
                                                <td class="text-center">
                                                    <label for="IDIOMA1_APLICA_PPT_si">Si</label>
                                                    <input class="form-check-input" type="radio" name="APLICA_IDIOMA1_PPT" id="IDIOMA1_APLICA_PPT_si" value="si">
                                                    <br>
                                                    <label for="IDIOMA1_APLICA_PPT_no">No</label>
                                                    <input class="form-check-input" type="radio" name="APLICA_IDIOMA1_PPT" id="IDIOMA1_APLICA_PPT_no" value="no">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="idioma1" id="BASICO_IDIOMA1_PPT" name="BASICO_IDIOMA1_PPT" value="X">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="idioma1" id="INTERMEDIO_IDIOMA1_PPT" name="INTERMEDIO_IDIOMA1_PPT" value="X">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="idioma1" id="AVANZADO_IDIOMA1_PPT" name="AVANZADO_IDIOMA1_PPT" value="X">
                                                </td>

                                                <td>
                                                    <div class="radio-container">
                                                        <label class="form-check-label" for="IDIOMA1_CUMPLE_SI">Sí</label>
                                                        <input class="form-check-input desabilitado" type="radio" name="IDIOMA1_CUMPLE_PPT" id="IDIOMA1_CUMPLE_SI" value="si" disabled>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="radio-container">
                                                        <label class="form-check-label" for="IDIOMA1_CUMPLE_NO">No</label>
                                                        <input class="form-check-input desabilitado" type="radio" name="IDIOMA1_CUMPLE_PPT" id="IDIOMA1_CUMPLE_NO" value="no" disabled>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_IDIOMA1" name="PORCENTAJE_IDIOMA1">
                                                </td>
                                            </tr>
                                            <tr id="IDIOMA2" style="display:none;">
                                                <td>
                                                    <input type="text" class="form-control" id="NOMBRE_IDIOMA2_PPT" name="NOMBRE_IDIOMA2_PPT">
                                                </td>
                                                <td class="text-center">
                                                    <label for="IDIOMA2_APLICA_PPT_si">Si</label>
                                                    <input class="form-check-input" type="radio" name="APLICA_IDIOMA2_PPT" id="IDIOMA2_APLICA_PPT_si" value="si">
                                                    <br>
                                                    <label for="IDIOMA2_APLICA_PPT_no">No</label>
                                                    <input class="form-check-input" type="radio" name="APLICA_IDIOMA2_PPT" id="IDIOMA2_APLICA_PPT_no" value="no">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="idioma2" id="BASICO_IDIOMA2_PPT" name="BASICO_IDIOMA2_PPT" value="X">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="idioma2" id="INTERMEDIO_IDIOMA2_PPT" name="INTERMEDIO_IDIOMA2_PPT" value="X">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="idioma2" id="AVANZADO_IDIOMA2_PPT" name="AVANZADO_IDIOMA2_PPT" value="X">
                                                </td>

                                                <td>
                                                    <div class="radio-container">
                                                        <label class="form-check-label" for="IDIOMA2_CUMPLE_SI">Sí</label>
                                                        <input class="form-check-input desabilitado" type="radio" name="IDIOMA2_CUMPLE_PPT" id="IDIOMA2_CUMPLE_SI" value="si" disabled>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="radio-container">
                                                        <label class="form-check-label" for="IDIOMA2_CUMPLE_NO">No</label>
                                                        <input class="form-check-input desabilitado" type="radio" name="IDIOMA2_CUMPLE_PPT" id="IDIOMA2_CUMPLE_NO" value="no" disabled>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_IDIOMA2" name="PORCENTAJE_IDIOMA2">
                                                </td>
                                            </tr>
                                            <tr id="IDIOMA3" style="display:none;">
                                                <td>
                                                    <input type="text" class="form-control" id="NOMBRE_IDIOMA3_PPT" name="NOMBRE_IDIOMA3_PPT">
                                                </td>
                                                <td class="text-center">
                                                    <label for="IDIOMA3_APLICA_PPT_si">Si</label>
                                                    <input class="form-check-input" type="radio" name="APLICA_IDIOMA3_PPT" id="IDIOMA3_APLICA_PPT_si" value="si">
                                                    <br>
                                                    <label for="IDIOMA3_APLICA_PPT_no">No</label>
                                                    <input class="form-check-input" type="radio" name="APLICA_IDIOMA3_PPT" id="IDIOMA3_APLICA_PPT_no" value="no">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="idioma3" id="BASICO_IDIOMA3_PPT" name="BASICO_IDIOMA3_PPT" value="X">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="idioma3" id="INTERMEDIO_IDIOMA3_PPT" name="INTERMEDIO_IDIOMA3_PPT" value="X">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="idioma3" id="AVANZADO_IDIOMA3_PPT" name="AVANZADO_IDIOMA3_PPT" value="X">
                                                </td>
                                                <td>
                                                    <div class="radio-container">
                                                        <label class="form-check-label" for="IDIOMA3_CUMPLE_SI">Sí</label>
                                                        <input class="form-check-input desabilitado" type="radio" name="IDIOMA3_CUMPLE_PPT" id="IDIOMA3_CUMPLE_SI" value="si" disabled>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="radio-container">
                                                        <label class="form-check-label" for="IDIOMA3_CUMPLE_NO">No</label>
                                                        <input class="form-check-input desabilitado" type="radio" name="IDIOMA3_CUMPLE_PPT" id="IDIOMA3_CUMPLE_NO" value="no" disabled>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_IDIOMA3" name="PORCENTAJE_IDIOMA3">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button id="addIdiomaBtn" class="btn btn-primary" title="Agregar idioma"><i class="bi bi-plus-circle"></i></button>
                                    <button id="addIdiomaBtn2" class="btn btn-primary" style="display:none;" title="Agregar idioma"><i class="bi bi-plus-circle"></i></button>
                                    <button id="removeIdiomaBtn2" class="btn btn-danger" style="display:none;" title="Eliminar idioma"><i class="bi bi-trash"></i></button>
                                    <button id="removeIdiomaBtn3" class="btn btn-danger" style="display:none;" title="Eliminar idioma"><i class="bi bi-trash"></i></button>
                                </div>
                            </div>

                            <!-- IIII. Cursos -->
                            <hr>
                            <div class="row mb-3">
                                <div class="col-12 text-center">
                                    <div style="display: inline-flex; align-items: center; gap: 10px;">
                                        <h4>IV. Cursos</h4>
                                        <input type="text" value="25" style="width: 40px; height: 40px; text-align: center;" readonly>
                                        <span style="font-size: 18px;">%</span>
                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="SUMA_CURSOS" name="SUMA_CURSOS" readonly>
                                        <span style="font-size: 18px;">%</span>
                                    </div>


                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="accordion" id="otrosConocimientosAccordion">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="cursoTemasHeading">
                                                <button class="accordion-button collapsed text-center" type="button" data-bs-toggle="collapse" data-bs-target="#cursoTemasCollapse" aria-expanded="false" aria-controls="cursoTemasCollapse">
                                                    Otros conocimientos adicionales
                                                </button>
                                            </h2>
                                            <div id="cursoTemasCollapse" class="accordion-collapse collapse" aria-labelledby="cursoTemasHeading" data-bs-parent="#otrosConocimientosAccordion">
                                                <div class="accordion-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">Cursos/Temas</th>
                                                                    <th class="text-center">*R</th>
                                                                    <th class="text-center">*D</th>
                                                                    <th class="text-center">Si</th>
                                                                    <th class="text-center">No</th>
                                                                    <th class="text-center">%</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO1_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO1_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[1]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO1_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[1]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[1]" id="CURSO1_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[1]" id="CURSO1_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO1" name="PORCENTAJE_CURSO[1]">
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO2_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO2_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[2]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO2_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[2]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[2]" id="CURSO2_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[2]" id="CURSO2_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO2" name="PORCENTAJE_CURSO[2]">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO3_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO3_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[3]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO3_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[3]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[3]" id="CURSO3_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[3]" id="CURSO3_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO3" name="PORCENTAJE_CURSO[3]">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO4_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO4_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[4]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO4_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[4]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[4]" id="CURSO4_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[4]" id="CURSO4_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO4" name="PORCENTAJE_CURSO[4]">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO5_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO5_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[5]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO5_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[5]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[5]" id="CURSO5_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[5]" id="CURSO5_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO5" name="PORCENTAJE_CURSO[5]">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO6_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO6_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[6]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO6_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[6]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[6]" id="CURSO6_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[6]" id="CURSO6_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO6" name="PORCENTAJE_CURSO[6]">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO7_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO7_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[7]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO7_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[7]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[7]" id="CURSO7_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[7]" id="CURSO7_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO7" name="PORCENTAJE_CURSO[7]">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO8_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO8_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[8]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO8_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[8]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[8]" id="CURSO8_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[8]" id="CURSO8_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO8" name="PORCENTAJE_CURSO[8]">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO9_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO9_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[9]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO9_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[9]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[9]" id="CURSO9_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[9]" id="CURSO9_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO9" name="PORCENTAJE_CURSO[9]">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO10_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO10_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[10]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO10_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[10]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[10]" id="CURSO10_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[10]" id="CURSO10_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO10" name="PORCENTAJE_CURSO[10]">
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <p class="mt-3 text-center">
                                                        <strong>*R: Requerido *D: Deseable</strong>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="accordion" id="otrosConocimientos1Accordion">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="cursoTemas1Heading">
                                                <button class="accordion-button collapsed text-center" type="button" data-bs-toggle="collapse" data-bs-target="#cursoTemas1Collapse" aria-expanded="false" aria-controls="cursoTemas1Collapse">
                                                    Otros conocimientos adicionales
                                                </button>
                                            </h2>
                                            <div id="cursoTemas1Collapse" class="accordion-collapse collapse" aria-labelledby="cursoTemas1Heading" data-bs-parent="#otrosConocimientos1Accordion">
                                                <div class="accordion-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">Cursos/Temas</th>
                                                                    <th class="text-center">*R</th>
                                                                    <th class="text-center">*D</th>
                                                                    <th class="text-center">Si</th>
                                                                    <th class="text-center">No</th>
                                                                    <th class="text-center">%</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO11_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO11_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[11]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO11_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[11]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[11]" id="CURSO11_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[11]" id="CURSO11_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO11" name="PORCENTAJE_CURSO[11]">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO12_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO12_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[12]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO12_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[12]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[12]" id="CURSO12_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[12]" id="CURSO12_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO12" name="PORCENTAJE_CURSO[12]">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO13_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO13_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[13]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO13_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[13]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[13]" id="CURSO13_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[13]" id="CURSO13_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO13" name="PORCENTAJE_CURSO[13]">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO14_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO14_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[14]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO14_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[14]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[14]" id="CURSO14_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[14]" id="CURSO14_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO14" name="PORCENTAJE_CURSO[14]">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO15_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO15_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[15]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO15_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[15]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[15]" id="CURSO15_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[15]" id="CURSO15_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO15" name="PORCENTAJE_CURSO[15]">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO16_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO16_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[16]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO16_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[16]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[16]" id="CURSO16_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[16]" id="CURSO16_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO16" name="PORCENTAJE_CURSO[16]">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO17_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO17_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[17]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO17_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[17]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[17]" id="CURSO17_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[17]" id="CURSO17_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO17" name="PORCENTAJE_CURSO[17]">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO18_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO18_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[18]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO18_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[18]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[18]" id="CURSO18_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[18]" id="CURSO18_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO18" name="PORCENTAJE_CURSO[18]">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO19_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO19_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[19]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO19_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[19]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[19]" id="CURSO19_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[19]" id="CURSO19_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO19" name="PORCENTAJE_CURSO[19]">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO20_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO20_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[20]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO20_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[20]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[20]" id="CURSO20_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[20]" id="CURSO20_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO20" name="PORCENTAJE_CURSO[20]">
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <p class="mt-3 text-center">
                                                        <strong>*R: Requerido *D: Deseable</strong>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="accordion" id="otrosConocimientos2Accordion">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="cursoTemas2Heading">
                                                <button class="accordion-button collapsed text-center" type="button" data-bs-toggle="collapse" data-bs-target="#cursoTemas2Collapse" aria-expanded="false" aria-controls="cursoTemas2Collapse">
                                                    Otros conocimientos adicionales
                                                </button>
                                            </h2>
                                            <div id="cursoTemas2Collapse" class="accordion-collapse collapse" aria-labelledby="cursoTemas2Heading" data-bs-parent="#otrosConocimientos2Accordion">
                                                <div class="accordion-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">Cursos/Temas</th>
                                                                    <th class="text-center">*R</th>
                                                                    <th class="text-center">*D</th>
                                                                    <th class="text-center">Si</th>
                                                                    <th class="text-center">No</th>
                                                                    <th class="text-center">%</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO21_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO21_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[21]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO21_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[21]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[21]" id="CURSO21_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[21]" id="CURSO21_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO21" name="PORCENTAJE_CURSO[21]">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO22_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO22_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[22]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO22_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[22]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[22]" id="CURSO22_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[22]" id="CURSO22_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO22" name="PORCENTAJE_CURSO[22]">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO23_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO23_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[23]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO23_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[23]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[23]" id="CURSO23_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[23]" id="CURSO23_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO23" name="PORCENTAJE_CURSO[23]">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO24_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO24_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[24]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO24_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[24]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[24]" id="CURSO24_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[24]" id="CURSO24_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO24" name="PORCENTAJE_CURSO[24]">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO25_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO25_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[25]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO25_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[25]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[25]" id="CURSO25_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[25]" id="CURSO25_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO25" name="PORCENTAJE_CURSO[25]">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO26_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO26_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[26]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO26_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[26]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[26]" id="CURSO26_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[26]" id="CURSO26_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO26" name="PORCENTAJE_CURSO[26]">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO27_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO27_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[27]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO27_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[27]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[27]" id="CURSO27_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[27]" id="CURSO27_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO27" name="PORCENTAJE_CURSO[27]">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO28_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO28_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[28]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO28_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[28]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[28]" id="CURSO28_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[28]" id="CURSO28_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO28" name="PORCENTAJE_CURSO[28]">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO29_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO29_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[29]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO29_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[29]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[29]" id="CURSO29_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[29]" id="CURSO29_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO29" name="PORCENTAJE_CURSO[29]">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO30_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO30_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[30]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO30_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[30]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[30]" id="CURSO30_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[30]" id="CURSO30_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO30" name="PORCENTAJE_CURSO[30]">
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <p class="mt-3 text-center">
                                                        <strong>*R: Requerido *D: Deseable</strong>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="accordion" id="otrosConocimientos3Accordion">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="cursoTemas3Heading">
                                                <button class="accordion-button collapsed text-center" type="button" data-bs-toggle="collapse" data-bs-target="#cursoTemas3Collapse" aria-expanded="false" aria-controls="cursoTemas3Collapse">
                                                    Otros conocimientos adicionales
                                                </button>
                                            </h2>
                                            <div id="cursoTemas3Collapse" class="accordion-collapse collapse" aria-labelledby="cursoTemas3Heading" data-bs-parent="#otrosConocimientos3Accordion">
                                                <div class="accordion-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">Cursos/Temas</th>
                                                                    <th class="text-center">*R</th>
                                                                    <th class="text-center">*D</th>
                                                                    <th class="text-center">Si</th>
                                                                    <th class="text-center">No</th>
                                                                    <th class="text-center">%</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO31_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO31_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[31]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO31_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[31]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[31]" id="CURSO31_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[31]" id="CURSO31_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO31" name="PORCENTAJE_CURSO[31]">
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO32_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO32_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[32]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO32_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[32]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[32]" id="CURSO32_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[32]" id="CURSO32_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO32" name="PORCENTAJE_CURSO[32]">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO33_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO33_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[33]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO33_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[33]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[33]" id="CURSO33_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[33]" id="CURSO33_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO33" name="PORCENTAJE_CURSO[33]">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO34_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO34_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[34]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO34_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[34]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[34]" id="CURSO34_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[34]" id="CURSO34_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO34" name="PORCENTAJE_CURSO[34]">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO35_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO35_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[35]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO35_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[35]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[35]" id="CURSO35_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[35]" id="CURSO35_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO35" name="PORCENTAJE_CURSO[35]">
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO36_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO36_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[36]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO36_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[36]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[36]" id="CURSO36_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[36]" id="CURSO36_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO36" name="PORCENTAJE_CURSO[36]">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO37_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO37_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[37]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO37_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[37]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[37]" id="CURSO37_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[37]" id="CURSO37_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO37" name="PORCENTAJE_CURSO[37]">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO38_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO38_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[38]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO38_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[38]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[38]" id="CURSO38_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[38]" id="CURSO38_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO38" name="PORCENTAJE_CURSO[38]">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO39_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO39_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[39]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO39_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[39]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[39]" id="CURSO39_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[39]" id="CURSO39_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO39" name="PORCENTAJE_CURSO[39]">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <textarea type="text" class="form-control" id="CURSO40_PPT" name="CURSO_PPT[]" rows="1"></textarea>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO40_REQUERIDO_PPT" name="CURSO_REQUERIDO_PPT[40]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" id="CURSO40_DESEABLE_PPT" name="CURSO_DESEABLE_PPT[40]" value="X">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[40]" id="CURSO40_CUMPLE_SI" value="si" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="radio-container">
                                                                            <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[40]" id="CURSO40_CUMPLE_NO" value="no" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CURSO40" name="PORCENTAJE_CURSO[40]">
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <p class="mt-3 text-center">
                                                        <strong>*R: Requerido *D: Deseable</strong>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- V. Experiencia -->


                            <hr>
                            <div class="row mb-3">
                                <div class="col-12 text-center">
                                    <div style="display: inline-flex; align-items: center; gap: 10px;">
                                        <h4>V. Experiencia</h4>
                                        <input type="text" value="25" style="width: 40px; height: 40px; text-align: center;" readonly>
                                        <span style="font-size: 18px;">%</span>
                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="SUMA_EXPERIENCIA" name="SUMA_EXPERIENCIA" readonly>
                                        <span style="font-size: 18px;">%</span>
                                    </div>


                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-5">
                                    <label>Experiencia laboral general requerida</label>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <select class="form-control" id="EXPERIENCIA_LABORAL_GENERAL_PPT" name="EXPERIENCIA_LABORAL_GENERAL_PPT">
                                            <option value="0" selected disabled>Seleccione una opción</option>
                                            <option value=""></option>
                                            <option value="No necesaria">No necesaria</option>
                                            <option value="Deseable">Deseable</option>
                                            <option value="Necesaria">Necesaria</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="radio-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="EXPERIENCIAGENERAL_CUMPLE_PPT" id="EXPERIENCIAGENERAL_CUMPLE_SI" value="si" disabled>
                                            <label class="form-check-label" for="EXPERIENCIAGENERAL_CUMPLE_SI">Si</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="EXPERIENCIAGENERAL_CUMPLE_PPT" id="EXPERIENCIAGENERAL_CUMPLE_NO" value="no" disabled>
                                            <label class="form-check-label" for="EXPERIENCIAGENERAL_CUMPLE_NO">No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-5">
                                    <label>Indique la cantidad total de años de experiencia laboral</label>
                                    <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_CANTIDADTOTAL" name="PORCENTAJE_CANTIDADTOTAL">
                                    <span style="font-size: 18px;">%</span>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="CANTIDAD_EXPERIENCIA_PPT" name="CANTIDAD_EXPERIENCIA_PPT">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="radio-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="CANTIDAD_EXPERIENCIA_CUMPLE_PPT" id="CANTIDAD_EXPERIENCIA_CUMPLE_SI" value="si" disabled>
                                            <label class="form-check-label" for="CANTIDAD_EXPERIENCIA_CUMPLE_SI">Si</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="CANTIDAD_EXPERIENCIA_CUMPLE_PPT" id="CANTIDAD_EXPERIENCIA_CUMPLE_NO" value="no" disabled>
                                            <label class="form-check-label" for="CANTIDAD_EXPERIENCIA_CUMPLE_NO">No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-5">
                                    <label>Experiencia laboral específica requerida</label>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <select class="form-control" id="EXPERIENCIA_ESPECIFICA_PPT" name="EXPERIENCIA_ESPECIFICA_PPT">
                                            <option value="0" selected disabled>Seleccione una opción</option>
                                            <option value=""></option>

                                            <option value="No necesaria">No necesaria</option>
                                            <option value="Deseable">Deseable</option>
                                            <option value="Necesaria">Necesaria</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="radio-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="EXPERIENCIA_ESPECIFICA_CUMPLE_PPT" id="EXPERIENCIA_ESPECIFICA_CUMPLE_SI" value="si" disabled>
                                            <label class="form-check-label" for="EXPERIENCIA_ESPECIFICA_CUMPLE_SI">Si</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="EXPERIENCIA_ESPECIFICA_CUMPLE_PPT" id="EXPERIENCIA_ESPECIFICA_CUMPLE_NO" value="no" disabled>
                                            <label class="form-check-label" for="EXPERIENCIA_ESPECIFICA_CUMPLE_NO">No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 d-flex align-items-center">
                                    <h6 class="mb-0">Marque el nivel mínimo de puesto que se requiere como experiencia &nbsp;</h6>
                                    <button type="button" id="agregapuesto" title="Agregar otro puesto" class="btn btn-primary ml-3"><i class="bi bi-plus-circle"></i></button>
                                </div>
                            </div>




                            <div class="row mb-3" id="puesto1" style="display: none;">
                                <div class="col-2 mt-1">
                                    <div class="form-group">
                                        <select class="form-control puesto" id="PUESTO1_NOMBRE" name="PUESTO1_NOMBRE">
                                            <option value="0" disabled selected>Seleccione una opción</option>
                                            <option value=""></option>

                                            @foreach ($puesto as $puestos)
                                            <option value="{{ $puestos->ID_CATALOGO_EXPERIENCIA }}">{{ $puestos->NOMBRE_PUESTO }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <div class="form-group">
                                        <input type="checkbox" id="PUESTO1" name="PUESTO1" value="X">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="radio-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="PUESTO1_CUMPLE_PPT" id="PUESTO1_CUMPLE_SI" value="si" disabled>
                                            <label class="form-check-label" for="PUESTO1_CUMPLE_SI">Si</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="PUESTO1_CUMPLE_PPT" id="PUESTO1_CUMPLE_NO" value="no" disabled>
                                            <label class="form-check-label" for="PUESTO1_CUMPLE_NO">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 mt-1">
                                    <div class="form-group">
                                        <select class="form-control puesto" id="PUESTO2_NOMBRE" name="PUESTO2_NOMBRE">
                                            <option value="0" disabled selected>Seleccione una opción</option>
                                            <option value=""></option>
                                            @foreach ($puesto as $puestos)
                                            <option value="{{ $puestos->ID_CATALOGO_EXPERIENCIA }}">{{ $puestos->NOMBRE_PUESTO }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <div class="form-group">
                                        <input type="checkbox" id="PUESTO2" name="PUESTO2" value="X">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="radio-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="PUESTO2_CUMPLE_PPT" id="PUESTO2_CUMPLE_SI" value="si" disabled>
                                            <label class="form-check-label" for="PUESTO2_CUMPLE_SI">Si</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="PUESTO2_CUMPLE_PPT" id="PUESTO2_CUMPLE_NO" value="no" disabled>
                                            <label class="form-check-label" for="PUESTO2_CUMPLE_NO">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <button type="button" class="btn btn-danger eliminar-puesto" data-puesto="puesto1"><i class="bi bi-trash"></i></button>
                                </div>
                            </div>



                            <div class="row mb-3" id="puesto2" style="display: none;">
                                <div class="col-2 mt-1">
                                    <div class="form-group">
                                        <select class="form-control puesto" id="PUESTO3_NOMBRE" name="PUESTO3_NOMBRE">
                                            <option value="0" disabled selected>Seleccione una opción</option>
                                            <option value=""></option>
                                            @foreach ($puesto as $puestos)
                                            <option value="{{ $puestos->ID_CATALOGO_EXPERIENCIA }}">{{ $puestos->NOMBRE_PUESTO }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <div class="form-group">
                                        <input type="checkbox" id="PUESTO3" name="PUESTO3" value="X">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="radio-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="PUESTO3_CUMPLE_PPT" id="PUESTO3_CUMPLE_SI" value="si" disabled>
                                            <label class="form-check-label" for="PUESTO3_CUMPLE_SI">Si</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="PUESTO3_CUMPLE_PPT" id="PUESTO3_CUMPLE_NO" value="no" disabled>
                                            <label class="form-check-label" for="PUESTO3_CUMPLE_NO">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 mt-1">
                                    <div class="form-group">
                                        <select class="form-control puesto" id="PUESTO4_NOMBRE" name="PUESTO4_NOMBRE">
                                            <option value="0" disabled selected>Seleccione una opción</option>
                                            <option value=""></option>
                                            @foreach ($puesto as $puestos)
                                            <option value="{{ $puestos->ID_CATALOGO_EXPERIENCIA }}">{{ $puestos->NOMBRE_PUESTO }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <div class="form-group">
                                        <input type="checkbox" id="PUESTO4" name="PUESTO4" value="X">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="radio-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="PUESTO4_CUMPLE_PPT" id="PUESTO4_CUMPLE_SI" value="si" disabled>
                                            <label class="form-check-label" for="PUESTO4_CUMPLE_SI">Si</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="PUESTO4_CUMPLE_PPT" id="PUESTO4_CUMPLE_NO" value="no" disabled>
                                            <label class="form-check-label" for="PUESTO4_CUMPLE_NO">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <button type="button" class="btn btn-danger eliminar-puesto" data-puesto="puesto2"><i class="bi bi-trash"></i></button>
                                </div>
                            </div>



                            <div class="row mb-3" id="puesto3" style="display: none;">
                                <div class="col-2 mt-1">
                                    <div class="form-group">
                                        <select class="form-control puesto" id="PUESTO5_NOMBRE" name="PUESTO5_NOMBRE">
                                            <option value="0" disabled selected>Seleccione una opción</option>
                                            <option value=""></option>
                                            @foreach ($puesto as $puestos)
                                            <option value="{{ $puestos->ID_CATALOGO_EXPERIENCIA }}">{{ $puestos->NOMBRE_PUESTO }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <div class="form-group">
                                        <input type="checkbox" id="PUESTO5" name="PUESTO5" value="X">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="radio-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="PUESTO5_CUMPLE_PPT" id="PUESTO5_CUMPLE_SI" value="si" disabled>
                                            <label class="form-check-label" for="PUESTO5_CUMPLE_SI">Si</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="PUESTO5_CUMPLE_PPT" id="PUESTO5_CUMPLE_NO" value="no" disabled>
                                            <label class="form-check-label" for="PUESTO5_CUMPLE_NO">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 mt-1">
                                    <div class="form-group">
                                        <select class="form-control puesto" id="PUESTO6_NOMBRE" name="PUESTO6_NOMBRE">
                                            <option value="0" disabled selected>Seleccione una opción</option>
                                            <option value=""></option>
                                            @foreach ($puesto as $puestos)
                                            <option value="{{ $puestos->ID_CATALOGO_EXPERIENCIA }}">{{ $puestos->NOMBRE_PUESTO }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <div class="form-group">
                                        <input type="checkbox" id="PUESTO6" name="PUESTO6" value="X">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="radio-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="PUESTO6_CUMPLE_PPT" id="PUESTO6_CUMPLE_SI" value="si" disabled>
                                            <label class="form-check-label" for="PUESTO6_CUMPLE_SI">Si</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="PUESTO6_CUMPLE_PPT" id="PUESTO6_CUMPLE_NO" value="no" disabled>
                                            <label class="form-check-label" for="PUESTO6_CUMPLE_NO">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <button type="button" class="btn btn-danger eliminar-puesto" data-puesto="puesto3"><i class="bi bi-trash"></i></button>
                                </div>
                            </div>



                            <div class="row mb-3" id="puesto4" style="display: none;">
                                <div class="col-2 mt-1">
                                    <div class="form-group">
                                        <select class="form-control puesto" id="PUESTO7_NOMBRE" name="PUESTO7_NOMBRE">
                                            <option value="0" disabled selected>Seleccione una opción</option>
                                            <option value=""></option>
                                            @foreach ($puesto as $puestos)
                                            <option value="{{ $puestos->ID_CATALOGO_EXPERIENCIA }}">{{ $puestos->NOMBRE_PUESTO }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <div class="form-group">
                                        <input type="checkbox" id="PUESTO7" name="PUESTO7" value="X">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="radio-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="PUESTO7_CUMPLE_PPT" id="PUESTO7_CUMPLE_SI" value="si" disabled>
                                            <label class="form-check-label" for="PUESTO7_CUMPLE_SI">Si</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="PUESTO7_CUMPLE_PPT" id="PUESTO7_CUMPLE_NO" value="no" disabled>
                                            <label class="form-check-label" for="PUESTO7_CUMPLE_NO">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 mt-1">
                                    <div class="form-group">
                                        <select class="form-control puesto" id="PUESTO8_NOMBRE" name="PUESTO8_NOMBRE">
                                            <option value="0" disabled selected>Seleccione una opción</option>
                                            <option value=""></option>
                                            @foreach ($puesto as $puestos)
                                            <option value="{{ $puestos->ID_CATALOGO_EXPERIENCIA }}">{{ $puestos->NOMBRE_PUESTO }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <div class="form-group">
                                        <input type="checkbox" id="PUESTO8" name="PUESTO8" value="X">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="radio-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="PUESTO8_CUMPLE_PPT" id="PUESTO8_CUMPLE_SI" value="si" disabled>
                                            <label class="form-check-label" for="PUESTO8_CUMPLE_SI">Si</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="PUESTO8_CUMPLE_PPT" id="PUESTO8_CUMPLE_NO" value="no" disabled>
                                            <label class="form-check-label" for="PUESTO8_CUMPLE_NO">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <button type="button" class="btn btn-danger eliminar-puesto" data-puesto="puesto4"><i class="bi bi-trash"></i></button>
                                </div>
                            </div>




                            <div class="row mb-3" id="puesto5" style="display: none;">
                                <div class="col-2 mt-1">
                                    <div class="form-group">
                                        <select class="form-control puesto" id="PUESTO9_NOMBRE" name="PUESTO9_NOMBRE">
                                            <option value="0" disabled selected>Seleccione una opción</option>
                                            <option value=""></option>
                                            @foreach ($puesto as $puestos)
                                            <option value="{{ $puestos->ID_CATALOGO_EXPERIENCIA }}">{{ $puestos->NOMBRE_PUESTO }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <div class="form-group">
                                        <input type="checkbox" id="PUESTO9" name="PUESTO9" value="X">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="radio-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="PUESTO9_CUMPLE_PPT" id="PUESTO9_CUMPLE_SI" value="si" disabled>
                                            <label class="form-check-label" for="PUESTO9_CUMPLE_SI">Si</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="PUESTO9_CUMPLE_PPT" id="PUESTO9_CUMPLE_NO" value="no" disabled>
                                            <label class="form-check-label" for="PUESTO9_CUMPLE_NO">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 mt-1">
                                    <div class="form-group">
                                        <select class="form-control puesto" id="PUESTO10_NOMBRE" name="PUESTO10_NOMBRE">
                                            <option value="0" disabled selected>Seleccione una opción</option>
                                            <option value=""></option>
                                            @foreach ($puesto as $puestos)
                                            <option value="{{ $puestos->ID_CATALOGO_EXPERIENCIA }}">{{ $puestos->NOMBRE_PUESTO }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <div class="form-group">
                                        <input type="checkbox" id="PUESTO10" name="PUESTO10" value="X">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="radio-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="PUESTO10_CUMPLE_PPT" id="PUESTO10_CUMPLE_SI" value="si" disabled>
                                            <label class="form-check-label" for="PUESTO10_CUMPLE_SI">Si</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="PUESTO10_CUMPLE_PPT" id="PUESTO10_CUMPLE_NO" value="no" disabled>
                                            <label class="form-check-label" for="PUESTO10_CUMPLE_NO">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <button type="button" class="btn btn-danger eliminar-puesto" data-puesto="puesto5"><i class="bi bi-trash"></i></button>
                                </div>
                            </div>






                            <div class="row mb-3">
                                <div class="col-12" style="display: flex; align-items: center; gap: 10px;">
                                    <h6 style="margin: 0;">Indique el tiempo de experiencia específica requerida para el cargo</h6>
                                    <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_INDIQUEXPERIENCIA" name="PORCENTAJE_INDIQUEXPERIENCIA">
                                    <span style="font-size: 18px;">%</span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-8">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="TIEMPO_EXPERIENCIA_PPT" name="TIEMPO_EXPERIENCIA_PPT">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="radio-container">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="TIEMPO_EXPERIENCIA_CUMPLE_PPT" id="TIEMPO_EXPERIENCIA_CUMPLE_SI" value="si" disabled>
                                            <label class="form-check-label" for="TIEMPO_EXPERIENCIA_CUMPLE_SI">Si</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="TIEMPO_EXPERIENCIA_CUMPLE_PPT" id="TIEMPO_EXPERIENCIA_CUMPLE_NO" value="no" disabled>
                                            <label class="form-check-label" for="TIEMPO_EXPERIENCIA_CUMPLE_NO">No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- VI. Habilidades y competencias funcionales -->

                            <hr>
                            <div class="row mb-3">
                                <div class="col-12 text-center">
                                    <div style="display: inline-flex; align-items: center; gap: 10px;">
                                        <h4>VI. Habilidades y competencias funcionales</h4>
                                        <input type="text" value="20" style="width: 40px; height: 40px; text-align: center;" readonly>
                                        <span style="font-size: 18px;">%</span>
                                        <input type="text" style="width: 40px; height: 40px; text-align: center;" id="SUMA_HABILIDADES" name="SUMA_HABILIDADES" readonly>
                                        <span style="font-size: 18px;">%</span>
                                    </div>


                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Habilidad / Competencia</th>
                                                <th class="text-center">Requerido</th>
                                                <th class="text-center">Deseable</th>
                                                <th class="text-center">No requerido</th>
                                                <th class="text-center">Si</th>
                                                <th class="text-center">No</th>
                                                <th class="text-center">%</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Innovación</td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="innovacion" id="INNOVACION_REQUERIDA_PPT" name="INNOVACION_REQUERIDA_PPT" value="X">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="innovacion" id="INNOVACION_DESEABLE_PPT" name="INNOVACION_DESEABLE_PPT" value="X">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="innovacion" id="INNOVACION_NO_REQUERIDA_PPT" name="INNOVACION_NO_REQUERIDA_PPT" value="X">
                                                </td>
                                                <td class="text-center">
                                                    <div class="radio-container">
                                                        <input class="form-check-input desabilitado" type="radio" name="INNOVACION_CUMPLE_PPT" id="INNOVACION_CUMPLE_SI" value="si" disabled>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="radio-container">
                                                        <input class="form-check-input desabilitado" type="radio" name="INNOVACION_CUMPLE_PPT" id="INNOVACION_CUMPLE_NO" value="no" disabled>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_INNOVACION" name="PORCENTAJE_INNOVACION">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Pasión</td>
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="pasion" id="PASION_REQUERIDA_PPT" name="PASION_REQUERIDA_PPT" value="X">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="pasion" id="PASION_DESEABLE_PPT" name="PASION_DESEABLE_PPT" value="X">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="pasion" id="PASION_NO_REQUERIDA_PPT" name="PASION_NO_REQUERIDA_PPT" value="X">
                                                </td>
                                                <td class="text-center">
                                                    <div class="radio-container">
                                                        <input class="form-check-input desabilitado" type="radio" name="PASION_CUMPLE_PPT" id="PASION_CUMPLE_SI" value="si" disabled>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="radio-container">
                                                        <input class="form-check-input desabilitado" type="radio" name="PASION_CUMPLE_PPT" id="PASION_CUMPLE_NO" value="no" disabled>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_PASION" name="PORCENTAJE_PASION">
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Servicio (Orientación al cliente)</td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="servicio" id="SERVICIO_CLIENTE_REQUERIDA_PPT" name="SERVICIO_CLIENTE_REQUERIDA_PPT" value="X">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="servicio" id="SERVICIO_CLIENTE_DESEABLE_PPT" name="SERVICIO_CLIENTE_DESEABLE_PPT" value="X">

                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="servicio" id="SERVICIO_CLIENTE_NO_REQUERIDA_PPT" name="SERVICIO_CLIENTE_NO_REQUERIDA_PPT" value="X">
                                                </td>
                                                <td class="text-center">
                                                    <div class="radio-container">
                                                        <input class="form-check-input desabilitado" type="radio" name="SERVICIO_CLIENTE_CUMPLE_PPT" id="SERVICIO_CLIENTE_CUMPLE_SI" value="si" disabled>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="radio-container">
                                                        <input class="form-check-input desabilitado" type="radio" name="SERVICIO_CLIENTE_CUMPLE_PPT" id="SERVICIO_CLIENTE_CUMPLE_NO" value="no" disabled>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_SERVICIO_CLIENTE" name="PORCENTAJE_SERVICIO_CLIENTE">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Comunicación eficaz</td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="comunicacion" id="COMUNICACION_EFICAZ_REQUERIDA_PPT" name="COMUNICACION_EFICAZ_REQUERIDA_PPT" value="X">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="comunicacion" id="COMUNICACION_EFICAZ_DESEABLE_PPT" name="COMUNICACION_EFICAZ_DESEABLE_PPT" value="X">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="comunicacion" id="COMUNICACION_EFICAZ_NO_REQUERIDA_PPT" name="COMUNICACION_EFICAZ_NO_REQUERIDA_PPT" value="X">
                                                </td>
                                                <td class="text-center">
                                                    <div class="radio-container">
                                                        <input class="form-check-input desabilitado" type="radio" name="COMUNICACION_EFICAZ_CUMPLE_PPT" id="COMUNICACION_EFICAZ_CUMPLE_SI" value="si" disabled>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="radio-container">
                                                        <input class="form-check-input desabilitado" type="radio" name="COMUNICACION_EFICAZ_CUMPLE_PPT" id="COMUNICACION_EFICAZ_CUMPLE_NO" value="no" disabled>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_COMUNICACION_EFICAZ" name="PORCENTAJE_COMUNICACION_EFICAZ">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Trabajo en equipo</td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="trabajo" id="TRABAJO_EQUIPO_REQUERIDA_PPT" name="TRABAJO_EQUIPO_REQUERIDA_PPT" value="X">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="trabajo" id="TRABAJO_EQUIPO_DESEABLE_PPT" name="TRABAJO_EQUIPO_DESEABLE_PPT" value="X">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="trabajo" id="TRABAJO_EQUIPO_NO_REQUERIDA_PPT" name="TRABAJO_EQUIPO_NO_REQUERIDA_PPT" value="X">
                                                </td>
                                                <td class="text-center">
                                                    <div class="radio-container">
                                                        <input class="form-check-input desabilitado" type="radio" name="TRABAJO_EQUIPO_CUMPLE_PPT" id="TRABAJO_EQUIPO_CUMPLE_SI" value="si" disabled>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="radio-container">
                                                        <input class="form-check-input desabilitado" type="radio" name="TRABAJO_EQUIPO_CUMPLE_PPT" id="TRABAJO_EQUIPO_CUMPLE_NO" value="no" disabled>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_TRABAJO_EQUIPO" name="PORCENTAJE_TRABAJO_EQUIPO">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Integridad</td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="integridad" id="INTEGRIDAD_REQUERIDA_PPT" name="INTEGRIDAD_REQUERIDA_PPT" value="X">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="integridad" id="INTEGRIDAD_DESEABLE_PPT" name="INTEGRIDAD_DESEABLE_PPT" value="X">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="integridad" id="INTEGRIDAD_NO_REQUERIDA_PPT" name="INTEGRIDAD_NO_REQUERIDA_PPT" value="X">
                                                </td>
                                                <td class="text-center">
                                                    <div class="radio-container">
                                                        <input class="form-check-input desabilitado" type="radio" name="INTEGRIDAD_CUMPLE_PPT" id="INTEGRIDAD_CUMPLE_SI" value="si" disabled>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="radio-container">
                                                        <input class="form-check-input desabilitado" type="radio" name="INTEGRIDAD_CUMPLE_PPT" id="INTEGRIDAD_CUMPLE_NO" value="no" disabled>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_INTEGRIDAD" name="PORCENTAJE_INTEGRIDAD">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Responsabilidad social</td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="responsabilidad" id="RESPONSABILIDAD_SOCIAL_REQUERIDA_PPT" name="RESPONSABILIDAD_SOCIAL_REQUERIDA_PPT" value="X">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="responsabilidad" id="RESPONSABILIDAD_SOCIAL_DESEABLE_PPT" name="RESPONSABILIDAD_SOCIAL_DESEABLE_PPT" value="X">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="responsabilidad" id="RESPONSABILIDAD_SOCIAL_NO_REQUERIDA_PPT" name="RESPONSABILIDAD_SOCIAL_NO_REQUERIDA_PPT" value="X">
                                                </td>
                                                <td class="text-center">
                                                    <div class="radio-container">
                                                        <input class="form-check-input desabilitado" type="radio" name="RESPONSABILIDAD_SOCIAL_CUMPLE_PPT" id="RESPONSABILIDAD_SOCIAL_CUMPLE_SI" value="si" disabled>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="radio-container">
                                                        <input class="form-check-input desabilitado" type="radio" name="RESPONSABILIDAD_SOCIAL_CUMPLE_PPT" id="RESPONSABILIDAD_SOCIAL_CUMPLE_NO" value="no" disabled>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_RESPONSABILIDAD_SOCIAL" name="PORCENTAJE_RESPONSABILIDAD_SOCIAL">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Adaptabilidad a los cambios del entorno</td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="adaptabilidad" id="ADAPTABILIDAD_REQUERIDA_PPT" name="ADAPTABILIDAD_REQUERIDA_PPT" value="X">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="adaptabilidad" id="ADAPTABILIDAD_DESEABLE_PPT" name="ADAPTABILIDAD_DESEABLE_PPT" value="X">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="adaptabilidad" id="ADAPTABILIDAD_NO_REQUERIDA_PPT" name="ADAPTABILIDAD_NO_REQUERIDA_PPT" value="X">
                                                </td>
                                                <td class="text-center">
                                                    <div class="radio-container">
                                                        <input class="form-check-input desabilitado" type="radio" name="ADAPTABILIDAD_CUMPLE_PPT" id="ADAPTABILIDAD_CUMPLE_SI" value="si" disabled>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="radio-container">
                                                        <input class="form-check-input desabilitado" type="radio" name="ADAPTABILIDAD_CUMPLE_PPT" id="ADAPTABILIDAD_CUMPLE_NO" value="no" disabled>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_ADAPTABILIDAD" name="PORCENTAJE_ADAPTABILIDAD">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Liderazgo</td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="liderazgo" id="LIDERAZGO_REQUERIDA_PPT" name="LIDERAZGO_REQUERIDA_PPT" value="X">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="liderazgo" id="LIDERAZGO_DESEABLE_PPT" name="LIDERAZGO_DESEABLE_PPT" Value="X">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="liderazgo" id="LIDERAZGO_NO_REQUERIDA_PPT" name="LIDERAZGO_NO_REQUERIDA_PPT" Value="X">
                                                </td>
                                                <td class="text-center">
                                                    <div class="radio-container">
                                                        <input class="form-check-input desabilitado" type="radio" name="LIDERAZGO_CUMPLE_PPT" id="LIDERAZGO_CUMPLE_SI" value="si" disabled>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="radio-container">
                                                        <input class="form-check-input desabilitado" type="radio" name="LIDERAZGO_CUMPLE_PPT" id="LIDERAZGO_CUMPLE_NO" value="no" disabled>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_LIDERAZGO" name="PORCENTAJE_LIDERAZGO">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Toma de decisiones</td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="decisiones" id="TOMA_DECISIONES_REQUERIDA_PPT" name="TOMA_DECISIONES_REQUERIDA_PPT" Value="X">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="decisiones" id="TOMA_DECISIONES_DESEABLE_PPT" name="TOMA_DECISIONES_DESEABLE_PPT" Value="X">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" class="decisiones" id="TOMA_DECISIONES_NO_REQUERIDA_PPT" name="TOMA_DECISIONES_NO_REQUERIDA_PPT" Value="X">
                                                </td>
                                                <td class="text-center">
                                                    <div class="radio-container">
                                                        <input class="form-check-input desabilitado" type="radio" name="TOMA_DECISIONES_CUMPLE_PPT" id="TOMA_DECISIONES_CUMPLE_SI" value="si" disabled>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="radio-container">
                                                        <input class="form-check-input desabilitado" type="radio" name="TOMA_DECISIONES_CUMPLE_PPT" id="TOMA_DECISIONES_CUMPLE_NO" value="no" disabled>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <input type="text" style="width: 40px; height: 40px; text-align: center;" id="PORCENTAJE_TOMA_DECISIONES" name="PORCENTAJE_TOMA_DECISIONES">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- VI. Otros -->
                            <div class="row mb-3">
                                <div class="col-12 text-center">
                                    <h4>VII. Otros</h4>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th class="text-center">Si</th>
                                                <th class="text-center">No</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Disponibilidad para viajar</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="radio" name="DISPONIBILIDAD_VIAJAR_PPT" id="VIAJAR_SI" value="si">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="radio" name="DISPONIBILIDAD_VIAJAR_PPT" id="VIAJAR_NO" value="no">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Requiere pasaporte</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="radio" name="REQUIERE_PASAPORTE_PPT" id="PASAPORTE_SI" value="si">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="radio" name="REQUIERE_PASAPORTE_PPT" id="PASAPORTE_NO" value="no">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Requiere visa americana</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="radio" name="REQUIERE_VISA_PPT" id="VISA_SI" value="si">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="radio" name="REQUIERE_VISA_PPT" id="VISA_NO" value="no">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Requiere licencia de conducción</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="radio" name="REQUIERE_LICENCIA_PPT" id="LICENCIA_SI" value="si">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="radio" name="REQUIERE_LICENCIA_PPT" id="LICENCIA_NO" value="no">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Disponibilidad para cambio de residencia</td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="radio" name="CAMBIO_RESIDENCIA_PPT" id="CAMBIORESIDENCIA_SI" value="si">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="radio" name="CAMBIO_RESIDENCIA_PPT" id="CAMBIORESIDENCIA_NO" value="no">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-6">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th class="text-center">Si</th>
                                                <th class="text-center">No</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <select class="form-control" id="DISPONIBILIDAD_VIAJAR_OPCION_PPT" name="DISPONIBILIDAD_VIAJAR_OPCION_PPT">
                                                        <option selected disabled>Seleccione una opción</option>
                                                        <option value=""></option>
                                                        <option value="No">No</option>
                                                        <option value="Nacional">Nacional</option>
                                                        <option value="Internacional">Internacional</option>
                                                        <option value="Nacional-Internac.">Nacional-Internac.</option>
                                                    </select>
                                                </td>
                                                <td class="text-center">
                                                    <div class="radio-container">
                                                        <input class="form-check-input desabilitado" type="radio" name="DISPONIBILIDAD_VIAJAR_OPCION_CUMPLE" id="DISPONIBILADVIAJAR_OPCION_SI" value="si" disabled>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="radio-container">
                                                        <input class="form-check-input desabilitado" type="radio" name="DISPONIBILIDAD_VIAJAR_OPCION_CUMPLE" id="DISPONIBILADVIAJAR_OPCION_NO" value="No" disabled>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <select class="form-control" id="REQUIEREPASAPORTE_OPCION_PPT" name="REQUIEREPASAPORTE_OPCION_PPT">
                                                        <option selected disabled>Seleccione una opción</option>
                                                        <option value=""></option>
                                                        <option value="No aplica">No aplica</option>
                                                        <option value="Deseable">Deseable</option>
                                                        <option value="Requerido">Requerido</option>
                                                    </select>
                                                </td>
                                                <td class="text-center">
                                                    <div class="radio-container">
                                                        <input class="form-check-input desabilitado" type="radio" name="REQUIEREPASAPORTE_OPCION_CUMPLE" id="REQUIEREPASAPORTE_OPCION_SI" value="si" disabled>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="radio-container">
                                                        <input class="form-check-input desabilitado" type="radio" name="REQUIEREPASAPORTE_OPCION_CUMPLE" id="REQUIEREPASAPORTE_OPCION_NO" value="no" disabled>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <select class="form-control" id="REQUIERE_VISA_OPCION_PPT" name="REQUIERE_VISA_OPCION_PPT">
                                                        <option selected disabled>Seleccione una opción</option>
                                                        <option value=""></option>
                                                        <option value="No aplica">No aplica</option>
                                                        <option value="Deseable">Deseable</option>
                                                        <option value="Requerido">Requerido</option>
                                                    </select>
                                                </td>
                                                <td class="text-center">
                                                    <div class="radio-container">
                                                        <input class="form-check-input desabilitado" type="radio" name="REQUIEREVISA_OPCION_CUMPLE" id="REQUIEREVISA_OPCION_SI" value="si" disabled>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="radio-container">
                                                        <input class="form-check-input desabilitado" type="radio" name="REQUIEREVISA_OPCION_CUMPLE" id="REQUIEREVISA_OPCION_NO" value="no" disabled>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <select class="form-control" id="REQUIERELICENCIA_OPCION_PPT" name="REQUIERELICENCIA_OPCION_PPT">
                                                        <option selected disabled>Seleccione una opción</option>
                                                        <option value=""></option>
                                                        <option value="No aplica">No aplica</option>
                                                        <option value="Automovilista">Automovilista</option>
                                                        <option value="Chofer">Chofer</option>
                                                        <option value="Eq. Pesado">Eq. Pesado</option>
                                                        <option value="Motociclista">Motociclista</option>
                                                    </select>
                                                </td>
                                                <td class="text-center">
                                                    <div class="radio-container">
                                                        <input class="form-check-input desabilitado" type="radio" name="REQUIERELICENCIA_OPCION_CUMPLE" id="REQUIERELICENCIA_OPCION_SI" value="si" disabled>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="radio-container">
                                                        <input class="form-check-input desabilitado" type="radio" name="REQUIERELICENCIA_OPCION_CUMPLE" id="REQUIERELICENCIA_OPCION_NO" value="no" disabled>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <select class="form-control" id="CAMBIORESIDENCIA_OPCION_PPT" name="CAMBIORESIDENCIA_OPCION_PPT">
                                                        <option selected disabled>Seleccione una opción</option>
                                                        <option value=""></option>
                                                        <option value="No aplica">No aplica</option>
                                                        <option value="Nacional">Nacional</option>
                                                        <option value="Internacional">Internacional</option>
                                                    </select>
                                                </td>
                                                <td class="text-center">
                                                    <div class="radio-container">
                                                        <input class="form-check-input desabilitado" type="radio" name="CAMBIORESIDENCIA_OPCION_CUMPLE" id="CAMBIORESIDENCIA_OPCION_SI" value="si" disabled>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="radio-container">
                                                        <input class="form-check-input desabilitado" type="radio" name="CAMBIORESIDENCIA_OPCION_CUMPLE" id="CAMBIORESIDENCIA_OPCION_NO" value="no" disabled>
                                                    </div>

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- X. Observaciones -->
                            <div class="row mb-3">
                                <div class="col-12 text-center">
                                    <h4>X. Observaciones</h4>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="form-group">
                                        <textarea class="form-control" id="OBSERVACIONES_PPT" name="OBSERVACIONES_PPT" rows="2"></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row mb-3">
                                <div class="col-12 text-center">
                                    <h4></h4>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-4 text-center">
                                    <h6>Elaborado por</h6>
                                    <input type="text" class="form-control text-center" id="ELABORADO_NOMBRE_PPT" name="ELABORADO_NOMBRE_PPT">
                                    <div>Nombre</div>
                                    <br>
                                    <input type="text" class="form-control text-center" id="ELABORADO_FIRMA_PPT" name="ELABORADO_FIRMA_PPT">
                                    <div>Firma</div>
                                    <br>
                                    <input type="text" class="form-control text-center mydatepicker" placeholder="aaaa-mm-dd" id="ELABORADO_FECHA_PPT" name="ELABORADO_FECHA_PPT">
                                    <i class="bi bi-calendar-event"></i>

                                    {{-- <input type="date" class="form-control text-center" id="ELABORADO_FECHA_PPT" name="ELABORADO_FECHA_PPT" > --}}
                                    <div>Fecha</div>
                                    <br>
                                </div>
                                <div class="col-4 text-center">
                                    <h6>Revisado por</h6>
                                    <input type="text" class="form-control text-center" id="REVISADO_NOMBRE_PPT" name="REVISADO_NOMBRE_PPT">
                                    <div>Nombre</div>
                                    <br>
                                    <input type="text" class="form-control text-center" id="REVISADO_FIRMA_PPT" name="REVISADO_FIRMA_PPT">
                                    <div>Firma</div>
                                    <br>

                                    <input type="text" class="form-control text-center mydatepicker" placeholder="aaaa-mm-dd" id="REVISADO_FECHA_PPT" name="REVISADO_FECHA_PPT">
                                    <i class="bi bi-calendar-event"></i>

                                    {{-- <input type="date" class="form-control text-center" id="REVISADO_FECHA_PPT" name="REVISADO_FECHA_PPT"> --}}
                                    <div>Fecha</div>
                                    <br>
                                </div>
                                <div class="col-4 text-center">
                                    <h6>Autorizado por</h6>
                                    <input type="text" class="form-control text-center" id="AUTORIZADO_NOMBRE_PPT" name="AUTORIZADO_NOMBRE_PPT">
                                    <div>Nombre</div>
                                    <br>
                                    <input type="text" class="form-control text-center" id="AUTORIZADO_FIRMA_PPT" name="AUTORIZADO_FIRMA_PPT">
                                    <div>Firma</div>
                                    <br>

                                    <input type="text" class="form-control text-center mydatepicker" placeholder="aaaa-mm-dd" id="AUTORIZADO_FECHA_PPT" name="AUTORIZADO_FECHA_PPT">
                                    <i class="bi bi-calendar-event"></i>


                                    {{-- <input type="date" class="form-control text-center" id="AUTORIZADO_FECHA_PPT" name="AUTORIZADO_FECHA_PPT"> --}}
                                    <div>Fecha</div>
                                    <br>
                                </div>
                            </div>

                    </div>
                </div>

                <div class="modal-footer mx-5">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarFormPPT"><i class="bi bi-floppy-fill" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Guardar PPT"></i> Guardar</button>

                    <button type="button" class="btn btn-success" id="revisarFormPPT" style="display: none;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Marcar como revisado formato de PPT" disabled><i class="bi bi-card-checklist"></i> Revisado</button>

                    <button type="button" class="btn btn-success" id="AutorizarFormPPT" style="display: none;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Autorizar formato PPT" disabled><i class="bi bi-clipboard-check-fill"></i> Autorizar</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection