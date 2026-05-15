@extends('principal.maestra')

@section('contenido')


<style>
    .justificacion-preview {
        max-width: 250px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: normal;
    }

    .ver-mas-link {
        color: #0d6efd;
        cursor: pointer;
        font-size: 12px;
        display: inline-block;
        margin-top: 4px;
    }
</style>

<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-person-check-fill"></i>&nbsp;Selección</h3>
    </ol>

    <div class="card-body">
        <table id="Tablaseleccion2Visualizar" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
        </table>
    </div>

</div>



<!-- ============================================================== -->
<!-- MODAL PRINCIPAL DISEÑO  -->
<!-- ============================================================== -->
<div class="modal fade" id="FullScreenModal" tabindex="-1" aria-labelledby="ModalFullLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">


                    <div class="row">

                        <div class="col-12 mb-3">
                            <div class="card h-100 cardseleccion">
                                <ol class="breadcrumb mb-5 d-flex align-items-center" style="background-color: #007DBA !important">
                                    <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-file-pdf-fill"></i>&nbsp;Formato de Autorización</h3>
                                    <button type="button" class="btn btn-light waves-effect waves-light" style="margin-left: 10px;" id="verPdfButton">
                                        <i class="bi bi-file-earmark-pdf-fill"></i> &nbsp; Ver
                                    </button>

                                </ol>
                                <div class="card-body position-relative">
                                    <i id="loadingIcon2" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                                    <table id="Tablaautorizacion" class="table table-hover bg-white table-bordered text-center w-100 TableSelecciones">
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- INTELIGENCIA LABORAL  -->
                        <div class="col-6 mb-3">
                            <div class="card h-100 cardseleccion">
                                <ol class="breadcrumb mb-5 d-flex align-items-center" style="background-color: #007DBA !important">
                                    <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-lightbulb-fill"></i>&nbsp;Inteligencia laboral</h3>

                                </ol>
                                <div class="card-body position-relative">
                                    <i id="loadingIcon3" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                                    <table id="Tablainteligencia" class="table table-hover bg-white table-bordered text-center w-100 TableSeleccion">
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- BURO LABORAL  -->
                        <div class="col-6 mb-3">
                            <div class="card h-100 cardseleccion">
                                <ol class="breadcrumb mb-5 d-flex align-items-center" style="background-color: #007DBA !important">
                                    <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-clipboard-data-fill"></i>&nbsp;Buró laboral</h3>

                                </ol>
                                <div class="card-body position-relative">
                                    <i id="loadingIcon4" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                                    <table id="Tablaburo" class="table table-hover bg-white table-bordered text-center w-100 TableSeleccion">
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- PPT -->
                        <div class="col-6 mb-3 ">
                            <div class="card h-100 cardseleccion">
                                <ol class="breadcrumb mb-5 d-flex align-items-center" style="background-color: #007DBA !important">
                                    <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-filetype-ppt"></i>&nbsp;Perfil de puesto de trabajo&nbsp;(PPT)</h3>

                                </ol>
                                <div class="card-body position-relative">
                                    <i id="loadingIcon1" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                                    <table id="Tablapptseleccion" class="table table-hover bg-white table-bordered text-center w-100 TableSeleccion">
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- EXPERIENCIA -->
                        <div class="col-6 mb-3">
                            <div class="card h-100 cardseleccion">
                                <ol class="breadcrumb mb-5 d-flex align-items-center" style="background-color: #007DBA !important">
                                    <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-file-person"></i>&nbsp;Referencias laboral</h3>

                                </ol>
                                <div class="card-body position-relative">
                                    <i id="loadingIcon5" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                                    <table id="Tablareferencia" class="table table-hover bg-white table-bordered text-center w-100 TableSeleccion">
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- PRUEBAS -->

                        <div class="col-6 mb-3">
                            <div class="card h-100 cardseleccion ">
                                <ol class="breadcrumb mb-5 d-flex align-items-center" style="background-color: #007DBA !important">
                                    <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-check2-square"></i>&nbsp;Pruebas de conocimientos</h3>

                                </ol>
                                <div class="card-body position-relative">
                                    <i id="loadingIcon7" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                                    <table id="Tablapruebaconocimientoseleccion" class="table table-hover bg-white table-bordered text-center w-100 TableSeleccion">
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- ENTREVISTAS  -->
                        <div class="col-6 mb-3">
                            <div class="card h-100 cardseleccion ">
                                <ol class="breadcrumb mb-5 d-flex align-items-center" style="background-color: #007DBA !important">
                                    <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-people-fill"></i>&nbsp;Entrevista</h3>

                                </ol>
                                <div class="card-body position-relative">
                                    <i id="loadingIcon" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                                    <table id="Tablaentrevistaseleccion" class="table table-hover bg-white table-bordered text-center w-100 TableSeleccion">
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>



<!-- ============================================================== -->
<!-- MODAL AUTORIZACION-->
<!-- ============================================================== -->

<div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pdfModalLabel">Formato de Autorización (PS-RH-FO-02)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="pdfIframe" src="" width="100%" height="500px"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="verPdfModal" tabindex="-1" aria-labelledby="verPdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verPdfModalLabel">Documento de Autorización</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="loadingMessage" style="text-align: center;">Cargando documento...</div>
                <iframe id="pdfIframe1" src="" width="100%" height="500px" style="display: none;"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="Modal_autorizacion" tabindex="-1" aria-labelledby="AutorizacionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioAUTORIZACION">

                <div class="modal-header">
                    <h5 class="modal-title" id="comentariosModalLabel">Subir documento de autorización</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}

                    <div class="mb-3">
                        <label class="form-label text-center">Documento de autorización *</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="ARCHIVO_AUTORIZACION" name="ARCHIVO_AUTORIZACION" accept=".pdf" required>
                            <button type="button" class="btn btn-light btn-sm ms-2" id="quitarformato" style="display:none;">Quitar archivo</button>
                        </div>
                        <small id="errorArchivo" class="text-danger" style="display:none;">El archivo debe ser un PDF.</small>
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
<!-- MODAL INTELIGENCIA LABORAL-->
<!-- ============================================================== -->
<div class="modal fade" id="Modal_inteligencia" tabindex="-1" aria-labelledby="InteligenciaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioINTELIGENCIA">

                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Inteligencia Laboral</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}



                    <div class="mb-3">
                        <label class="form-label text-center">Documento Competencias *</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="ARCHIVO_COMPETENCIAS" name="ARCHIVO_COMPETENCIAS" accept=".pdf" required>
                            <button type="button" class="btn btn-light btn-sm ms-2" id="quitarcompetencias" style="display:none;">Quitar archivo</button>
                        </div>
                        <small id="errorArchivoCompetencias" class="text-danger" style="display:none;">El archivo debe ser un PDF.</small>
                    </div>




                    <div class="mb-3">
                        <label class="form-label text-center">Documento Completo *</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="ARCHIVO_COMPLETO" name="ARCHIVO_COMPLETO" accept=".pdf" required>
                            <button type="button" class="btn btn-light btn-sm ms-2" id="quitarcompleto" style="display:none;">Quitar archivo</button>
                        </div>
                        <small id="errorArchivoCompleto" class="text-danger" style="display:none;">El archivo debe ser un PDF.</small>
                    </div>


                    <!-- Semáforo centrado con texto externo y título -->
                    <div class="traffic-light-wrapper">
                        <h3 class="traffic-light-title"><b>Riesgo</b></h3>

                        <div class="traffic-light">
                            <label class="light red">
                                <input type="radio" name="RIESGO_PORCENTAJE" value="40">
                                <span class="label">Alto</span>
                            </label>
                            <label class="light yellow">
                                <input type="radio" name="RIESGO_PORCENTAJE" value="70">
                                <span class="label">Medio</span>
                            </label>
                            <label class="light green">
                                <input type="radio" name="RIESGO_PORCENTAJE" value="100">
                                <span class="label">Bajo</span>
                            </label>
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
<!-- MODAL BURO LABORAL-->
<!-- ============================================================== -->
<div class="modal fade" id="Modal_buro" tabindex="-1" aria-labelledby="BuroLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioBURO">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Buró Laboral</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="mb-3">
                        <label class="form-label text-center">Cargar resultado *</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="ARCHIVO_RESULTADO" name="ARCHIVO_RESULTADO" accept=".pdf" required>
                            <button type="button" class="btn btn-light btn-sm ms-2" id="quitarResultado" style="display:none;">Quitar archivo</button>
                        </div>
                        <small id="errorArchivoResultado" class="text-danger" style="display:none;">El archivo debe ser un PDF.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">1 - Cédula profesional *</label>
                        <div class="d-flex align-items-center">


                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" name="CEDULA_PROFESIONAL" id="cedula_si" value="si">
                                <label for="cedula_si" class="form-check-label">Sí</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" name="CEDULA_PROFESIONAL" id="cedula_no" value="no">
                                <label for="cedula_no" class="form-check-label">No</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" name="CEDULA_PROFESIONAL" id="cedula_exterior" value="exterior">
                                <label for="cedula_exterior" class="form-check-label">Exterior</label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-center">2 - Experiencia laboral </label>
                        <div class="row justify-content-center">
                            <div class="col-3 text-center mx-auto">
                                <label>Reportadas en Buró *</label>
                                <input type="number" class="form-control" id="EXPERIENCIA_BURO" name="EXPERIENCIA_BURO" min="0" required>
                            </div>
                            <div class="col-3 text-center mx-auto">
                                <label>Reportadas en CV * </label>
                                <input type="number" class="form-control" id="EXPERIENCIA_CV" name="EXPERIENCIA_CV" min="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-center">3 - Boletines/Demandas </label>

                        <div class="row justify-content-center mb-3">
                            <div class="col-12 d-flex align-items-center">
                                <label class="me-3">Laborales *</label>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" name="LABORALES_DEMANDA" id="laborales_si" value="si">
                                    <label for="laborales_si" class="form-check-label">Sí</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" name="LABORALES_DEMANDA" id="laborales_no" value="no">
                                    <label for="laborales_no" class="form-check-label">No</label>
                                </div>
                                <input type="number" class="form-control ms-3 text-center" id="NUMERO_LABORALES" name="NUMERO_LABORALES" placeholder="N°" readonly style="max-width: 100px;">
                            </div>
                        </div>

                        <div class="row justify-content-center mb-3">
                            <div class="col-12 d-flex align-items-center">
                                <label class="me-3">Judiciales *</label>

                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" name="JUDICIALES_DEMANDA" id="judiciales_si" value="si">
                                    <label for="judiciales_si" class="form-check-label">Sí</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" name="JUDICIALES_DEMANDA" id="judiciales_no" value="no">
                                    <label for="judiciales_no" class="form-check-label">No</label>
                                </div>
                                <input type="number" class="form-control ms-3 text-center" id="NUMERO_JUDICIALES" name="NUMERO_JUDICIALES" placeholder="N°" readonly style="max-width: 100px;">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Observaciones </label>
                            <textarea class="form-control" id="OBSERVACIONES_BURO" name="OBSERVACIONES_BURO" rows="2"></textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-4 mx-auto  text-center">
                            <div class="form-group">
                                <label>Suma total del %</label>
                                <input type="number" class="form-control floating-input text-center" id="PORCENTAJE_TOTAL" name="PORCENTAJE_TOTAL" readonly>
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
<!-- MODAL  REFERENCIAS LABORAL-->
<!-- ============================================================== -->
<div class="modal fade" id="Modal_referencias" tabindex="-1" aria-labelledby="ReferneciasLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioReferencias">

                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Referencias Laboral</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}

                    <div class="mb-3 text-center">
                        <label class="form-label">¿El trabajador tiene experiencia laboral? *</label>
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" name="EXPERIENCIA_LABORAL" id="experiencia_si" value="si">
                                <label for="experiencia_si" class="form-check-label">Sí</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" name="EXPERIENCIA_LABORAL" id="experiencia_no" value="no">
                                <label for="experiencia_no" class="form-check-label">No</label>
                            </div>
                        </div>
                    </div>


                    <!-- Contenedor que estará oculto al inicio -->
                    <div id="contenedor-empresa" style="display: none;">
                        <div class="mb-3">
                            <label>Agregar empresa</label>
                            <button id="botonAgregar" type="button" class="btn btn-danger ml-2 rounded-pill" title="Agregar empresa"><i class="bi bi-plus-circle-fill"></i></button>
                            <div id="inputs-container" class="mt-3"></div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-4 mx-auto text-center">
                                <div class="form-group">
                                    <label>Suma total del %</label>
                                    <input type="number" class="form-control floating-input text-center" id="PORCENTAJE_TOTAL_REFERENCIAS" name="PORCENTAJE_TOTAL_REFERENCIAS" value="0" readonly>
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
<!-- MODAL  PRUEBAS -->
<!-- ============================================================== -->


<div class="modal fade" id="Modal_pruebas_concimiento" tabindex="-1" aria-labelledby="pruebasLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioPruebas">

                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Pruebas de conocimientos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="mb-3 text-center">
                        <label class="form-label">¿Requiere pruebas de conocimiento? *</label>
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" name="REQUIERE_PRUEBAS" id="prueba_si" value="si">
                                <label for="prueba_si" class="form-check-label">Sí</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" name="REQUIERE_PRUEBAS" id="prueba_no" value="no">
                                <label for="prueba_no" class="form-check-label">No</label>
                            </div>
                        </div>
                    </div>

                    <div id="prueba-categoria">
                        <div id="obtenerpruebas" class="mt-3">
                        </div>

                        <div class="row mb-3">
                            <div class="col-4 mx-auto text-center">
                                <div class="form-group">
                                    <label>Suma total del %</label>
                                    <input type="number" class="form-control floating-input text-center" id="porcentajeTotalPrueba" name="PORCENTAJE_TOTAL_PRUEBA" value="0" readonly>
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
<!-- MODAL ENTREVISTA -->
<!-- ============================================================== -->
<div class="modal fade" id="Modal_entrevistas" tabindex="-1" aria-labelledby="EntrevistaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioENTREVISTA">

                <div class="modal-header">
                    <h5 class="modal-title" id="comentariosModalLabel">Comentario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}

                    <div class="mb-3">
                        <label class="form-label">Nombre del entrevistador *</label>
                        <input type="text" class="form-control" id="NOMBRE_ENTREVISTA" name="NOMBRE_ENTREVISTA" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label>Fecha *</label>
                            <div class="input-group">
                                <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_ENTREVISTA" name="FECHA_ENTREVISTA" required>
                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <label>% de la entrevista</label>
                            <input type="number" class="form-control" id="PORCENTAJE_ENTREVISTA" name="PORCENTAJE_ENTREVISTA" min="0" max="100" required>
                        </div>
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Comentario de la entrevista *</label>
                        <textarea class="form-control" id="COMENTARIO_ENTREVISTA" name="COMENTARIO_ENTREVISTA" rows="4" required></textarea>
                    </div>

                    <div class="mb-3" style="display: none">>
                        <label class="form-label text-center">Evidencia</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="ARCHIVO_ENTREVISTA" name="ARCHIVO_ENTREVISTA" accept=".pdf">
                            <button type="button" class="btn btn-light btn-sm ms-2" id="quitarEvidencia" style="display:none;">Quitar archivo</button>
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
<!-- MODAL PPT -->
<!-- ============================================================== -->


<div class="modal modal-fullscreen fade" id="miModal_ppt" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioSeleccionPPT" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h5 class="modal-title" id="miModalLabel">Perfil de puesto de trabajo&nbsp;(PPT)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>


                <div class="modal-body">
                    {!! csrf_field() !!}

                    <div class="row">
                        <div class="row mb-3">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Nombre de la categoría *</label>
                                    <select class="form-control desabilitado2" id="DEPARTAMENTO_AREA_ID" name="DEPARTAMENTO_AREA_ID" required>
                                        <option value="0" selected disabled>Seleccione una opción</option>
                                        @foreach ($areas as $area)
                                        <option value="{{ $area->ID }}">{{ $area->NOMBRE }} </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Nombre del trabajador</label>
                                    <input type="text" class="form-control desabilitado1" id="NOMBRE_TRABAJADOR_PPT" name="NOMBRE_TRABAJADOR_PPT">
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
                                <h4>I. Características generales</h4>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Edad (mínima / máxima) *</label>
                                    <select class="form-control" id="EDAD_PPT" name="EDAD_PPT" required>
                                        <option value="0" selected disabled>Seleccione una opción</option>
                                        <option value="Indistinto">Indistinto</option>
                                        <option value="18-25">18-25</option>
                                        <option value="26-35">26-35</option>
                                        <option value="36-45">36-45</option>
                                        <option value="Mayor de 45">Mayor de 45</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-2">
                                <br>
                                <div class="radio-container">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input desabilitado" type="radio" name="EDAD_CUMPLE_PPT" id="EDAD_CUMPLE_SI" value="si">
                                        <label class="form-check-label" for="EDAD_CUMPLE_SI">Si</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input desabilitado" type="radio" name="EDAD_CUMPLE_PPT" id="EDAD_CUMPLE_NO" value="no">
                                        <label class="form-check-label" for="EDAD_CUMPLE_NO">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Género *</label>
                                    <select class="form-control" id="GENERO_PPT" name="GENERO_PPT" required>
                                        <option value="0" selected disabled>Seleccione una opción</option>
                                        <option value="Indistinto">Indistinto</option>
                                        <option value="Masculino">Masculino</option>
                                        <option value="Femenino">Femenino</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-2">
                                <br>
                                <div class="radio-container">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input desabilitado" type="radio" name="GENERO_CUMPLE_PPT" id="GENERO_CUMPLE_SI" value="si">
                                        <label class="form-check-label" for="GENERO_CUMPLE_SI">Si</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input desabilitado" type="radio" name="GENERO_CUMPLE_PPT" id="GENERO_CUMPLE_NO" value="no">
                                        <label class="form-check-label" for="GENERO_CUMPLE_NO">No</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Estado civil *</label>
                                    <select class="form-control" id="ESTADO_CIVIL_PPT" name="ESTADO_CIVIL_PPT" required>
                                        <option value="0" selected disabled>Seleccione una opción</option>
                                        <option value="Indistinto">Indistinto</option>
                                        <option value="Soltero(a)">Soltero (a)</option>
                                        <option value="Casado(a)">Casado (a)</option>
                                        <option value="Separado(a)">Separado (a)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-2">
                                <br>
                                <div class="radio-container">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input desabilitado" type="radio" name="ESTADO_CIVIL_CUMPLE_PPT" id="ESTADO_CUMPLE_SI" value="si">
                                        <label class="form-check-label" for="ESTADO_CUMPLE_SI">Si</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input desabilitado" type="radio" name="ESTADO_CIVIL_CUMPLE_PPT" id="ESTADO_CUMPLE_NO" value="no">
                                        <label class="form-check-label" for="ESTADO_CUMPLE_NO">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Nacionalidad *</label>
                                    <select class="form-control" id="NACIONALIDAD_PPT" name="NACIONALIDAD_PPT" required>
                                        <option value="0" selected disabled>Seleccione una opción</option>
                                        <option value="Indistinto">Indistinto</option>
                                        <option value="Mexicana">Mexicana</option>
                                        <option value="Extranjero">Extranjero</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-2">
                                <br>
                                <div class="radio-container">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input desabilitado" type="radio" name="NACIONALIDAD_CUMPLE_PPT" id="NACIONALIDAD_CUMPLE_SI" value="si">
                                        <label class="form-check-label" for="NACIONALIDAD_CUMPLE_SI">Si</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input desabilitado" type="radio" name="NACIONALIDAD_CUMPLE_PPT" id="NACIONALIDAD_CUMPLE_NO" value="no">
                                        <label class="form-check-label" for="NACIONALIDAD_CUMPLE_NO">No</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Persona con discapacidad *</label>
                                    <select class="form-control" id="DISCAPACIDAD_PPT" name="DISCAPACIDAD_PPT" required>
                                        <option value="0" selected disabled>Seleccione una opción</option>
                                        <option value="Indistinto">Indistinto</option>
                                        <option value="Ninguna">Ninguna</option>
                                        <option value="Motriz">Motriz</option>
                                        <option value="Visual">Visual </option>
                                        <option value="Auditiva">Auditiva</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-2">
                                <br>
                                <div class="radio-container">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input desabilitado" type="radio" name="DISCAPACIDAD_CUMPLE_PPT" id="DISCAPACIDAD_CUMPLE_SI" value="si">
                                        <label class="form-check-label" for="DISCAPACIDAD_CUMPLE_SI">Si</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input desabilitado" type="radio" name="DISCAPACIDAD_CUMPLE_PPT" id="DISCAPACIDAD_CUMPLE_NO" value="no">
                                        <label class="form-check-label" for="DISCAPACIDAD_CUMPLE_NO">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>¿Cuál?</label>
                                    <input type="text" class="form-control desabilitado1" id="CUAL_PPT" name="CUAL_PPT">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12 text-center">
                                <hr>
                            </div>



                            <!-- II. Formación académica -->
                            <div class="row mb-3">
                                <div class="col-12 text-center">
                                    <h4>II. Formación académica</h4>
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
                                                        <select class="form-control" id="SECUNDARIA_PPT" name="SECUNDARIA_PPT">
                                                            <option value="0" selected disabled>Seleccione una opción</option>
                                                            <option value="Incompleta">Incompleta</option>
                                                            <option value="Completa">Completa</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <br>
                                                    <div class="radio-container">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input desabilitado" type="radio" name="SECUNDARIA_CUMPLE_PPT" id="SECUNDARIA_CUMPLE_SI" value="si">
                                                            <label class="form-check-label" for="SECUNDARIA_CUMPLE_SI">Si</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input desabilitado" type="radio" name="SECUNDARIA_CUMPLE_PPT" id="SECUNDARIA_CUMPLE_NO" value="no">
                                                            <label class="form-check-label" for="SECUNDARIA_CUMPLE_NO">No</label>
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
                                                        <select class="form-control" id="TECNICA_PPT" name="TECNICA_PPT">
                                                            <option value="0" selected disabled>Seleccione una opción</option>
                                                            <option value="Incompleta">Incompleta</option>
                                                            <option value="Completa">Completa</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <br>
                                                    <div class="radio-container">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input desabilitado" type="radio" name="TECNICA_CUMPLE_PPT" id="TECNICA_CUMPLE_SI" value="si">
                                                            <label class="form-check-label" for="TECNICA_CUMPLE_SI">Si</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input desabilitado" type="radio" name="TECNICA_CUMPLE_PPT" id="TECNICA_CUMPLE_NO" value="no">
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
                                                        <select class="form-control" id="TECNICO_PPT" name="TECNICO_PPT">
                                                            <option value="0" selected disabled>Seleccione una opción</option>
                                                            <option value="Incompleta">Incompleta</option>
                                                            <option value="Completa">Completa</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <br>
                                                    <div class="radio-container">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input desabilitado" type="radio" name="TECNICO_CUMPLE_PPT" id="TECNICO_CUMPLE_SI" value="si">
                                                            <label class="form-check-label" for="TECNICO_CUMPLE_SI">Si</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input desabilitado" type="radio" name="TECNICO_CUMPLE_PPT" id="TECNICO_CUMPLE_NO" value="no">
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
                                                        <select class="form-control" id="UNIVERSITARIO_PPT" name="UNIVERSITARIO_PPT">
                                                            <option selected disabled>Seleccione una opción</option>
                                                            <option value="Incompleta">Incompleta</option>
                                                            <option value="Completa">Completa</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <br>
                                                    <div class="radio-container">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input desabilitado" type="radio" name="UNIVERSITARIO_CUMPLE_PPT" id="UNIVERSITARIO_CUMPLE_SI" value="si">
                                                            <label class="form-check-label" for="UNIVERSITARIO_CUMPLE_SI">Si</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input desabilitado" type="radio" name="UNIVERSITARIO_CUMPLE_PPT" id="UNIVERSITARIO_CUMPLE_NO" value="no">
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
                                                        <select class="form-control" id="SITUACION_PPT" name="SITUACION_PPT" required>
                                                            <option value="0" selected disabled>Seleccione una opción</option>
                                                            <option value="Egresado">Egresado</option>
                                                            <option value="Bachiller">Bachiller</option>
                                                            <option value="Titulado">Titulado</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <br>
                                                    <div class="radio-container">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input desabilitado" type="radio" name="SITUACION_CUMPLE_PPT" id="SITUACION_CUMPLE_SI" value="si">
                                                            <label class="form-check-label" for="SITUACION_CUMPLE_SI">Si</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input desabilitado" type="radio" name="SITUACION_CUMPLE_PPT" id="SITUACION_CUMPLE_NO" value="no">
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
                                                        <select class="form-control" id="CEDULA_PPT" name="CEDULA_PPT" required>
                                                            <option selected disabled>Seleccione una opción</option>
                                                            <option value="Aplica">Aplica</option>
                                                            <option value="No aplica">No aplica</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <br>
                                                    <div class="radio-container">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input  desabilitado" type="radio" name="CEDULA_CUMPLE_PPT" id="CEDULA_CUMPLE_SI" value="si">
                                                            <label class="form-check-label" for="CEDULA_CUMPLE_SI">Si</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input desabilitado desabilitado" type="radio" name="CEDULA_CUMPLE_PPT" id="CEDULA_CUMPLE_NO" value="no">
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
                                                        <label>Áreas de conocimientos</label>
                                                        <select class="form-control" id="AREA1_PPT" name="AREA1_PPT">
                                                            <option selected disabled>Seleccione una opción</option>
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
                                                    <br>
                                                    <div class="radio-container">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input desabilitado" type="radio" name="AREA1_CUMPLE_PPT" id="AREA1_CUMPLE_SI" value="si">
                                                            <label class="form-check-label" for="AREA1_CUMPLE_SI">Si</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input desabilitado" type="radio" name="AREA1_CUMPLE_PPT" id="AREA1_CUMPLE_NO" value="no">
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
                                                        <label></label>
                                                        <select class="form-control" id="AREA2_PPT" name="AREA2_PPT">
                                                            <option selected disabled>Seleccione una opción</option>
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
                                                    <br>
                                                    <div class="radio-container">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input desabilitado desabilitado" type="radio" name="AREA2_CUMPLE_PPT" id="AREA2_CUMPLE_SI" value="si">
                                                            <label class="form-check-label" for="AREA2_CUMPLE_SI">Si</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input desabilitado desabilitado" type="radio" name="AREA2_CUMPLE_PPT" id="AREA2_CUMPLE_NO" value="no">
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
                                                        <label></label>
                                                        <select class="form-control" id="AREA3_PPT" name="AREA3_PPT">
                                                            <option selected disabled>Seleccione una opción</option>
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
                                                    <br>
                                                    <div class="radio-container">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input desabilitado" type="radio" name="AREA3_CUMPLE_PPT" id="AREA3_CUMPLE_SI" value="si">
                                                            <label class="form-check-label" for="AREA3_CUMPLE_SI">Si</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input desabilitado" type="radio" name="AREA3_CUMPLE_PPT" id="AREA3_CUMPLE_NO" value="no">
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
                                                        <label></label>
                                                        <select class="form-control" id="AREA4_PPT" name="AREA4_PPT">
                                                            <option selected disabled>Seleccione una opción</option>
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
                                                    <br>
                                                    <div class="radio-container">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input desabilitado" type="radio" name="AREA4_CUMPLE_PPT" id="AREA4_CUMPLE_SI" value="si">
                                                            <label class="form-check-label" for="AREA4_CUMPLE_SI">Si</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input desabilitado" type="radio" name="AREA4_CUMPLE_PPT" id="AREA4_CUMPLE_NO" value="no">
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
                                        <textarea class="form-control" id="AREA_REQUERIDA_PPT" name="AREA_REQUERIDA_PPT" rows="3" required></textarea>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Área de conocimiento del trabajador</label>
                                        <input type="text" class="form-control desabilitado1" id="AREA_CONOCIMIENTO_PPT" name="AREA_CONOCIMIENTO_PPT">
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
                                </div>
                                <div class="col-1 mt-1">
                                    <div class="form-group text-center">
                                        <label for="ESPECIALIDAD_SI">Egresado</label>
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
                                            <input class="form-check-input desabilitado" type="radio" name="ESPECIALIDAD_CUMPLE_PPT" id="ESPECIALIDAD_CUMPLE_SI" value="si">
                                            <label class="form-check-label" for="ESPECIALIDAD_CUMPLE_SI">Si</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="ESPECIALIDAD_CUMPLE_PPT" id="ESPECIALIDAD_CUMPLE_NO" value="no">
                                            <label class="form-check-label" for="ESPECIALIDAD_CUMPLE_NO">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Área de conocimiento requerida *</label>
                                        <input type="text" class="form-control" id="AREAREQUERIDA_CONOCIMIENTO_PPT" name="AREAREQUERIDA_CONOCIMIENTO_PPT" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-1 mt-2">
                                    <label>Maestría</label>
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
                                            <input class="form-check-input desabilitado" type="radio" name="MAESTRIA_CUMPLE_PPT" id="MAESTRIA_CUMPLE_SI" value="si">
                                            <label class="form-check-label" for="MAESTRIA_CUMPLE_SI">Si</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="MAESTRIA_CUMPLE_PPT" id="MAESTRIA_CUMPLE_NO" value="no">
                                            <label class="form-check-label" for="MAESTRIA_CUMPLE_NO">No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-1 mt-4">
                                    <label>Doctorado</label>
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
                                            <input class="form-check-input desabilitado" type="radio" name="DOCTORADO_CUMPLE_PPT" id="DOCTORADO_CUMPLE_SI" value="si">
                                            <label class="form-check-label" for="DOCTORADO_CUMPLE_SI">Si</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input desabilitado" type="radio" name="DOCTORADO_CUMPLE_PPT" id="DOCTORADO_CUMPLE_NO" value="no">
                                            <label class="form-check-label" for="DOCTORADO_CUMPLE_NO">No</label>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Área de conocimiento del trabajador</label>
                                        <input type="text" class="form-control desabilitado1" id="AREA_CONOCIMIENTO_TRABAJADOR_PPT" name="AREA_CONOCIMIENTO_TRABAJADOR_PPT">
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
                                                    <td>Word</td>
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
                                                            <input class="form-check-input desabilitado" type="radio" name="WORD_CUMPLE_PPT" id="WORD_CUMPLE_SI" value="si">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="radio-container">
                                                            <label class="form-check-label" for="WORD_CUMPLE_NO">No</label>
                                                            <input class="form-check-input desabilitado" type="radio" name="WORD_CUMPLE_PPT" id="WORD_CUMPLE_NO" value="no">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr style="height: 5px;"></tr>

                                                <tr>
                                                    <td>Excel</td>
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
                                                            <input class="form-check-input desabilitado" type="radio" name="EXCEL_CUMPLE_PPT" id="EXCEL_CUMPLE_SI" value="si">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="radio-container">
                                                            <label class="form-check-label" for="EXCEL_CUMPLE_NO">No</label>
                                                            <input class="form-check-input desabilitado" type="radio" name="EXCEL_CUMPLE_PPT" id="EXCEL_CUMPLE_NO" value="no">
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr style="height: 5px;"></tr>

                                                <tr>
                                                    <td>Power Point</td>
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
                                                            <input class="form-check-input  desabilitado desabilitado" type="radio" name="POWER_CUMPLE_PPT" id="POWER_CUMPLE_SI" value="si">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="radio-container">
                                                            <label class="form-check-label" for="POWER _CUMPLE_NO">No</label>
                                                            <input class="form-check-input  desabilitado desabilitado" type="radio" name="POWER_CUMPLE_PPT" id="POWER _CUMPLE_NO" value="no">
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
                                                    <th class="text-center">Aplica</th>
                                                    <th class="text-center">Básico</th>
                                                    <th class="text-center">Intermedio</th>
                                                    <th class="text-center">Avanzado</th>
                                                    <th class="text-center">Si</th>
                                                    <th class="text-center">No</th>
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
                                                            <input class="form-check-input desabilitado" type="radio" name="IDIOMA1_CUMPLE_PPT" id="IDIOMA1_CUMPLE_SI" value="si">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="radio-container">
                                                            <label class="form-check-label" for="IDIOMA1_CUMPLE_NO">No</label>
                                                            <input class="form-check-input desabilitado" type="radio" name="IDIOMA1_CUMPLE_PPT" id="IDIOMA1_CUMPLE_NO" value="no">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr id="IDIOMA2" style="display: table-row;">
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
                                                            <input class="form-check-input desabilitado" type="radio" name="IDIOMA2_CUMPLE_PPT" id="IDIOMA2_CUMPLE_SI" value="si">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="radio-container">
                                                            <label class="form-check-label" for="IDIOMA2_CUMPLE_NO">No</label>
                                                            <input class="form-check-input desabilitado" type="radio" name="IDIOMA2_CUMPLE_PPT" id="IDIOMA2_CUMPLE_NO" value="no">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr id="IDIOMA3" style="display: table-row;">
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
                                                            <input class="form-check-input desabilitado" type="radio" name="IDIOMA3_CUMPLE_PPT" id="IDIOMA3_CUMPLE_SI" value="si">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="radio-container">
                                                            <label class="form-check-label" for="IDIOMA3_CUMPLE_NO">No</label>
                                                            <input class="form-check-input desabilitado" type="radio" name="IDIOMA3_CUMPLE_PPT" id="IDIOMA3_CUMPLE_NO" value="no">
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        {{-- <button id="addIdiomaBtn" class="btn btn-primary" title="Agregar idioma"><i class="bi bi-plus-circle"></i></button>
                                      <button id="addIdiomaBtn2" class="btn btn-primary" style="display:none;" title="Agregar idioma"><i class="bi bi-plus-circle"></i></button>
                                      <button id="removeIdiomaBtn2" class="btn btn-danger" style="display:none;" title="Eliminar idioma"><i class="bi bi-trash"></i></button>
                                         <button id="removeIdiomaBtn3" class="btn btn-danger" style="display:none;"  title="Eliminar idioma"><i class="bi bi-trash"></i></button> --}}
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[1]" id="CURSO1_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[1]" id="CURSO1_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[2]" id="CURSO2_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[2]" id="CURSO2_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[3]" id="CURSO3_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[3]" id="CURSO3_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[4]" id="CURSO4_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[4]" id="CURSO4_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[5]" id="CURSO5_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[5]" id="CURSO5_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[6]" id="CURSO6_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[6]" id="CURSO6_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[7]" id="CURSO7_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[7]" id="CURSO7_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[8]" id="CURSO8_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[8]" id="CURSO8_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[9]" id="CURSO9_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[9]" id="CURSO9_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[10]" id="CURSO10_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[10]" id="CURSO10_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[11]" id="CURSO11_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[11]" id="CURSO11_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[12]" id="CURSO12_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[12]" id="CURSO12_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[13]" id="CURSO13_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[13]" id="CURSO13_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[14]" id="CURSO14_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[14]" id="CURSO14_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[15]" id="CURSO15_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[15]" id="CURSO15_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[16]" id="CURSO16_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[16]" id="CURSO16_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[17]" id="CURSO17_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[17]" id="CURSO17_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[18]" id="CURSO18_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[18]" id="CURSO18_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[19]" id="CURSO19_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[19]" id="CURSO19_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[20]" id="CURSO20_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[20]" id="CURSO20_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[21]" id="CURSO21_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[21]" id="CURSO21_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[22]" id="CURSO22_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[22]" id="CURSO22_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[23]" id="CURSO23_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[23]" id="CURSO23_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[24]" id="CURSO24_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[24]" id="CURSO24_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[25]" id="CURSO25_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[25]" id="CURSO25_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[26]" id="CURSO26_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[26]" id="CURSO26_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[27]" id="CURSO27_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[27]" id="CURSO27_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[28]" id="CURSO28_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[28]" id="CURSO28_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[29]" id="CURSO29_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[29]" id="CURSO29_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[30]" id="CURSO30_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[30]" id="CURSO30_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[31]" id="CURSO31_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[31]" id="CURSO31_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[32]" id="CURSO32_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[32]" id="CURSO32_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[33]" id="CURSO33_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[33]" id="CURSO33_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[34]" id="CURSO34_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[34]" id="CURSO34_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[35]" id="CURSO35_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[35]" id="CURSO35_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[36]" id="CURSO36_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[36]" id="CURSO36_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[37]" id="CURSO37_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[37]" id="CURSO37_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[38]" id="CURSO38_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[38]" id="CURSO38_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[39]" id="CURSO39_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[39]" id="CURSO39_CUMPLE_NO" value="no">
                                                                            </div>
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
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[40]" id="CURSO40_CUMPLE_SI" value="si">
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="radio-container">
                                                                                <input class="form-check-input desabilitado" type="radio" name="CURSO_CUMPLE_PPT[40]" id="CURSO40_CUMPLE_NO" value="no">
                                                                            </div>
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
                                    <div class="col-12 text-center">
                                        <hr>
                                    </div>


                                    <!-- IV. Experiencia -->
                                    <div class="row mb-3">
                                        <div class="col-12 text-center">
                                            <h4>IV. Experiencia</h4>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-5">
                                            <label>Experiencia laboral general requerida</label>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <select class="form-control" id="EXPERIENCIA_LABORAL_GENERAL_PPT" name="EXPERIENCIA_LABORAL_GENERAL_PPT" required>
                                                    <option value="0" selected disabled>Seleccione una opción</option>
                                                    <option value="No necesaria">No necesaria</option>
                                                    <option value="Deseable">Deseable</option>
                                                    <option value="Necesaria">Necesaria</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="radio-container">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input desabilitado" type="radio" name="EXPERIENCIAGENERAL_CUMPLE_PPT" id="EXPERIENCIAGENERAL_CUMPLE_SI" value="si">
                                                    <label class="form-check-label" for="EXPERIENCIAGENERAL_CUMPLE_SI">Si</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input desabilitado" type="radio" name="EXPERIENCIAGENERAL_CUMPLE_PPT" id="EXPERIENCIAGENERAL_CUMPLE_NO" value="no">
                                                    <label class="form-check-label" for="EXPERIENCIAGENERAL_CUMPLE_NO">No</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-5">
                                            <label>Indique la cantidad total de años de experiencia laboral</label>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="CANTIDAD_EXPERIENCIA_PPT" name="CANTIDAD_EXPERIENCIA_PPT">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="radio-container">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input desabilitado" type="radio" name="CANTIDAD_EXPERIENCIA_CUMPLE_PPT" id="CANTIDAD_EXPERIENCIA_CUMPLE_SI" value="si">
                                                    <label class="form-check-label" for="CANTIDAD_EXPERIENCIA_CUMPLE_SI">Si</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input desabilitado" type="radio" name="CANTIDAD_EXPERIENCIA_CUMPLE_PPT" id="CANTIDAD_EXPERIENCIA_CUMPLE_NO" value="no">
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
                                                <select class="form-control" id="EXPERIENCIA_ESPECIFICA_PPT" name="EXPERIENCIA_ESPECIFICA_PPT" required>
                                                    <option value="0" selected disabled>Seleccione una opción</option>
                                                    <option value="No necesaria">No necesaria</option>
                                                    <option value="Deseable">Deseable</option>
                                                    <option value="Necesaria">Necesaria</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="radio-container">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input desabilitado" type="radio" name="EXPERIENCIA_ESPECIFICA_CUMPLE_PPT" id="EXPERIENCIA_ESPECIFICA_CUMPLE_SI" value="si">
                                                    <label class="form-check-label" for="EXPERIENCIA_ESPECIFICA_CUMPLE_SI">Si</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input desabilitado" type="radio" name="EXPERIENCIA_ESPECIFICA_CUMPLE_PPT" id="EXPERIENCIA_ESPECIFICA_CUMPLE_NO" value="no">
                                                    <label class="form-check-label" for="EXPERIENCIA_ESPECIFICA_CUMPLE_NO">No</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12 d-flex align-items-center">
                                            <h6 class="mb-0">Marque el nivel mínimo de puesto que se requiere como experiencia &nbsp;</h6>
                                            {{-- <button type="button" id="agregapuesto" title="Agregar otro puesto" class="btn btn-primary ml-3"><i class="bi bi-plus-circle"></i></button> --}}
                                        </div>
                                    </div>




                                    <div class="row mb-3" id="puesto1" style="display: flex;">
                                        <div class="col-1">
                                            <div class="form-group">
                                            </div>
                                        </div>
                                        <div class="col-2 mt-1">
                                            <div class="form-group">
                                                <select class="form-control puesto" id="PUESTO1_NOMBRE" name="PUESTO1_NOMBRE">
                                                    <option value="0" disabled selected>Seleccione una opción</option>
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
                                                    <input class="form-check-input desabilitado" type="radio" name="PUESTO1_CUMPLE_PPT" id="PUESTO1_CUMPLE_SI" value="si">
                                                    <label class="form-check-label" for="PUESTO1_CUMPLE_SI">Si</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input desabilitado" type="radio" name="PUESTO1_CUMPLE_PPT" id="PUESTO1_CUMPLE_NO" value="no">
                                                    <label class="form-check-label" for="PUESTO1_CUMPLE_NO">No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2 mt-1">
                                            <div class="form-group">
                                                <select class="form-control puesto" id="PUESTO2_NOMBRE" name="PUESTO2_NOMBRE">
                                                    <option value="0" disabled selected>Seleccione una opción</option>
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
                                                    <input class="form-check-input desabilitado" type="radio" name="PUESTO2_CUMPLE_PPT" id="PUESTO2_CUMPLE_SI" value="si">
                                                    <label class="form-check-label" for="PUESTO2_CUMPLE_SI">Si</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input desabilitado" type="radio" name="PUESTO2_CUMPLE_PPT" id="PUESTO2_CUMPLE_NO" value="no">
                                                    <label class="form-check-label" for="PUESTO2_CUMPLE_NO">No</label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>



                                    <div class="row mb-3" id="puesto2" style="display: flex;">
                                        <div class="col-1">
                                            <div class="form-group">
                                            </div>
                                        </div>
                                        <div class="col-2 mt-1">
                                            <div class="form-group">
                                                <select class="form-control puesto" id="PUESTO3_NOMBRE" name="PUESTO3_NOMBRE">
                                                    <option value="0" disabled selected>Seleccione una opción</option>
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
                                                    <input class="form-check-input desabilitado" type="radio" name="PUESTO3_CUMPLE_PPT" id="PUESTO3_CUMPLE_SI" value="si">
                                                    <label class="form-check-label" for="PUESTO3_CUMPLE_SI">Si</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input desabilitado" type="radio" name="PUESTO3_CUMPLE_PPT" id="PUESTO3_CUMPLE_NO" value="no">
                                                    <label class="form-check-label" for="PUESTO3_CUMPLE_NO">No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2 mt-1">
                                            <div class="form-group">
                                                <select class="form-control puesto" id="PUESTO4_NOMBRE" name="PUESTO4_NOMBRE">
                                                    <option value="0" disabled selected>Seleccione una opción</option>
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
                                                    <input class="form-check-input desabilitado" type="radio" name="PUESTO4_CUMPLE_PPT" id="PUESTO4_CUMPLE_SI" value="si">
                                                    <label class="form-check-label" for="PUESTO4_CUMPLE_SI">Si</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input desabilitado" type="radio" name="PUESTO4_CUMPLE_PPT" id="PUESTO4_CUMPLE_NO" value="no">
                                                    <label class="form-check-label" for="PUESTO4_CUMPLE_NO">No</label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>



                                    <div class="row mb-3" id="puesto3" style="display: flex;">
                                        <div class="col-1">
                                            <div class="form-group">
                                            </div>
                                        </div>
                                        <div class="col-2 mt-1">
                                            <div class="form-group">
                                                <select class="form-control puesto" id="PUESTO5_NOMBRE" name="PUESTO5_NOMBRE">
                                                    <option value="0" disabled selected>Seleccione una opción</option>
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
                                                    <input class="form-check-input desabilitado" type="radio" name="PUESTO5_CUMPLE_PPT" id="PUESTO5_CUMPLE_SI" value="si">
                                                    <label class="form-check-label" for="PUESTO5_CUMPLE_SI">Si</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input desabilitado" type="radio" name="PUESTO5_CUMPLE_PPT" id="PUESTO5_CUMPLE_NO" value="no">
                                                    <label class="form-check-label" for="PUESTO5_CUMPLE_NO">No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2 mt-1">
                                            <div class="form-group">
                                                <select class="form-control puesto" id="PUESTO6_NOMBRE" name="PUESTO6_NOMBRE">
                                                    <option value="0" disabled selected>Seleccione una opción</option>
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
                                                    <input class="form-check-input desabilitado" type="radio" name="PUESTO6_CUMPLE_PPT" id="PUESTO6_CUMPLE_SI" value="si">
                                                    <label class="form-check-label" for="PUESTO6_CUMPLE_SI">Si</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input desabilitado" type="radio" name="PUESTO6_CUMPLE_PPT" id="PUESTO6_CUMPLE_NO" value="no">
                                                    <label class="form-check-label" for="PUESTO6_CUMPLE_NO">No</label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>



                                    <div class="row mb-3" id="puesto4" style="display: flex;">
                                        <div class="col-1">
                                            <div class="form-group">
                                            </div>
                                        </div>

                                        <div class="col-2 mt-1">
                                            <div class="form-group">
                                                <select class="form-control puesto" id="PUESTO7_NOMBRE" name="PUESTO7_NOMBRE">
                                                    <option value="0" disabled selected>Seleccione una opción</option>
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
                                                    <input class="form-check-input desabilitado" type="radio" name="PUESTO7_CUMPLE_PPT" id="PUESTO7_CUMPLE_SI" value="si">
                                                    <label class="form-check-label" for="PUESTO7_CUMPLE_SI">Si</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input desabilitado" type="radio" name="PUESTO7_CUMPLE_PPT" id="PUESTO7_CUMPLE_NO" value="no">
                                                    <label class="form-check-label" for="PUESTO7_CUMPLE_NO">No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2 mt-1">
                                            <div class="form-group">
                                                <select class="form-control puesto" id="PUESTO8_NOMBRE" name="PUESTO8_NOMBRE">
                                                    <option value="0" disabled selected>Seleccione una opción</option>
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
                                                    <input class="form-check-input desabilitado" type="radio" name="PUESTO8_CUMPLE_PPT" id="PUESTO8_CUMPLE_SI" value="si">
                                                    <label class="form-check-label" for="PUESTO8_CUMPLE_SI">Si</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input desabilitado" type="radio" name="PUESTO8_CUMPLE_PPT" id="PUESTO8_CUMPLE_NO" value="no">
                                                    <label class="form-check-label" for="PUESTO8_CUMPLE_NO">No</label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>


                                    <div class="row mb-3" id="puesto5" style="display: flex;">
                                        <div class="col-1">
                                            <div class="form-group">
                                            </div>
                                        </div>

                                        <div class="col-2 mt-1">
                                            <div class="form-group">
                                                <select class="form-control puesto" id="PUESTO9_NOMBRE" name="PUESTO9_NOMBRE">
                                                    <option value="0" disabled selected>Seleccione una opción</option>
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
                                                    <input class="form-check-input desabilitado" type="radio" name="PUESTO9_CUMPLE_PPT" id="PUESTO9_CUMPLE_SI" value="si">
                                                    <label class="form-check-label" for="PUESTO9_CUMPLE_SI">Si</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input desabilitado" type="radio" name="PUESTO9_CUMPLE_PPT" id="PUESTO9_CUMPLE_NO" value="no">
                                                    <label class="form-check-label" for="PUESTO9_CUMPLE_NO">No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2 mt-1">
                                            <div class="form-group">
                                                <select class="form-control puesto" id="PUESTO10_NOMBRE" name="PUESTO10_NOMBRE">
                                                    <option value="0" disabled selected>Seleccione una opción</option>
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
                                                    <input class="form-check-input desabilitado" type="radio" name="PUESTO10_CUMPLE_PPT" id="PUESTO10_CUMPLE_SI" value="si">
                                                    <label class="form-check-label" for="PUESTO10_CUMPLE_SI">Si</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input desabilitado" type="radio" name="PUESTO10_CUMPLE_PPT" id="PUESTO10_CUMPLE_NO" value="no">
                                                    <label class="form-check-label" for="PUESTO10_CUMPLE_NO">No</label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>






                                    <div class="row mb-3">
                                        <div class="col-12 ">
                                            <h6>Indique el tiempo de experiencia específica requerida para el cargo</h6>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-8">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="TIEMPO_EXPERIENCIA_PPT" name="TIEMPO_EXPERIENCIA_PPT" required>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="radio-container">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input desabilitado" type="radio" name="TIEMPO_EXPERIENCIA_CUMPLE_PPT" id="TIEMPO_EXPERIENCIA_CUMPLE_SI" value="si">
                                                    <label class="form-check-label" for="TIEMPO_EXPERIENCIA_CUMPLE_SI">Si</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input desabilitado" type="radio" name="TIEMPO_EXPERIENCIA_CUMPLE_PPT" id="TIEMPO_EXPERIENCIA_CUMPLE_NO" value="no">
                                                    <label class="form-check-label" for="TIEMPO_EXPERIENCIA_CUMPLE_NO">No</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-12 text-center">
                                            <hr>
                                        </div>

                                        <!-- V. Habilidades y competencias funcionales -->
                                        <div class="row mb-3">
                                            <div class="col-12 text-center">
                                                <h4>V. Habilidades y competencias funcionales</h4>
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
                                                                    <input class="form-check-input desabilitado" type="radio" name="INNOVACION_CUMPLE_PPT" id="INNOVACION_CUMPLE_SI" value="si">
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="radio-container">
                                                                    <input class="form-check-input desabilitado" type="radio" name="INNOVACION_CUMPLE_PPT" id="INNOVACION_CUMPLE_NO" value="no">
                                                                </div>
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
                                                                    <input class="form-check-input desabilitado" type="radio" name="PASION_CUMPLE_PPT" id="PASION_CUMPLE_SI" value="si">
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="radio-container">
                                                                    <input class="form-check-input desabilitado" type="radio" name="PASION_CUMPLE_PPT" id="PASION_CUMPLE_NO" value="no">
                                                                </div>
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
                                                                    <input class="form-check-input desabilitado" type="radio" name="SERVICIO_CLIENTE_CUMPLE_PPT" id="SERVICIO_CLIENTE_CUMPLE_SI" value="si">
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="radio-container">
                                                                    <input class="form-check-input desabilitado" type="radio" name="SERVICIO_CLIENTE_CUMPLE_PPT" id="SERVICIO_CLIENTE_CUMPLE_NO" value="no">
                                                                </div>
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
                                                                    <input class="form-check-input desabilitado" type="radio" name="COMUNICACION_EFICAZ_CUMPLE_PPT" id="COMUNICACION_EFICAZ_CUMPLE_SI" value="si">
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="radio-container">
                                                                    <input class="form-check-input desabilitado" type="radio" name="COMUNICACION_EFICAZ_CUMPLE_PPT" id="COMUNICACION_EFICAZ_CUMPLE_NO" value="no">
                                                                </div>
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
                                                                    <input class="form-check-input desabilitado" type="radio" name="TRABAJO_EQUIPO_CUMPLE_PPT" id="TRABAJO_EQUIPO_CUMPLE_SI" value="si">
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="radio-container">
                                                                    <input class="form-check-input desabilitado" type="radio" name="TRABAJO_EQUIPO_CUMPLE_PPT" id="TRABAJO_EQUIPO_CUMPLE_NO" value="no">
                                                                </div>
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
                                                                    <input class="form-check-input desabilitado" type="radio" name="INTEGRIDAD_CUMPLE_PPT" id="INTEGRIDAD_CUMPLE_SI" value="si">
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="radio-container">
                                                                    <input class="form-check-input desabilitado" type="radio" name="INTEGRIDAD_CUMPLE_PPT" id="INTEGRIDAD_CUMPLE_NO" value="no">
                                                                </div>
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
                                                                    <input class="form-check-input desabilitado" type="radio" name="RESPONSABILIDAD_SOCIAL_CUMPLE_PPT" id="RESPONSABILIDAD_SOCIAL_CUMPLE_SI" value="si">
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="radio-container">
                                                                    <input class="form-check-input desabilitado" type="radio" name="RESPONSABILIDAD_SOCIAL_CUMPLE_PPT" id="RESPONSABILIDAD_SOCIAL_CUMPLE_NO" value="no">
                                                                </div>
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
                                                                    <input class="form-check-input desabilitado" type="radio" name="ADAPTABILIDAD_CUMPLE_PPT" id="ADAPTABILIDAD_CUMPLE_SI" value="si">
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="radio-container">
                                                                    <input class="form-check-input desabilitado" type="radio" name="ADAPTABILIDAD_CUMPLE_PPT" id="ADAPTABILIDAD_CUMPLE_NO" value="no">
                                                                </div>
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
                                                                    <input class="form-check-input desabilitado" type="radio" name="LIDERAZGO_CUMPLE_PPT" id="LIDERAZGO_CUMPLE_SI" value="si">
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="radio-container">
                                                                    <input class="form-check-input desabilitado" type="radio" name="LIDERAZGO_CUMPLE_PPT" id="LIDERAZGO_CUMPLE_NO" value="no">
                                                                </div>
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
                                                                    <input class="form-check-input desabilitado" type="radio" name="TOMA_DECISIONES_CUMPLE_PPT" id="TOMA_DECISIONES_CUMPLE_SI" value="si">
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="radio-container">
                                                                    <input class="form-check-input desabilitado" type="radio" name="TOMA_DECISIONES_CUMPLE_PPT" id="TOMA_DECISIONES_CUMPLE_NO" value="no">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-12 text-center">
                                                <hr>
                                            </div>

                                            <!-- VI. Otros -->
                                            <div class="row mb-3">
                                                <div class="col-12 text-center">
                                                    <h4>VI. Otros</h4>
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
                                                                        <option value="No">No</option>
                                                                        <option value="Nacional">Nacional</option>
                                                                        <option value="Internacional">Internacional</option>
                                                                        <option value="Nacional-Internac.">Nacional-Internac.</option>
                                                                    </select>
                                                                </td>
                                                                <td class="text-center">
                                                                    <div class="radio-container">
                                                                        <input class="form-check-input desabilitado" type="radio" name="DISPONIBILIDAD_VIAJAR_OPCION_CUMPLE" id="DISPONIBILADVIAJAR_OPCION_SI" value="si">
                                                                    </div>
                                                                </td>
                                                                <td class="text-center">
                                                                    <div class="radio-container">
                                                                        <input class="form-check-input desabilitado" type="radio" name="DISPONIBILIDAD_VIAJAR_OPCION_CUMPLE" id="DISPONIBILADVIAJAR_OPCION_NO" value="No">
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <select class="form-control" id="REQUIEREPASAPORTE_OPCION_PPT" name="REQUIEREPASAPORTE_OPCION_PPT">
                                                                        <option selected disabled>Seleccione una opción</option>
                                                                        <option value="No aplica">No aplica</option>
                                                                        <option value="Deseable">Deseable</option>
                                                                        <option value="Requerido">Requerido</option>
                                                                    </select>
                                                                </td>
                                                                <td class="text-center">
                                                                    <div class="radio-container">
                                                                        <input class="form-check-input desabilitado" type="radio" name="REQUIEREPASAPORTE_OPCION_CUMPLE" id="REQUIEREPASAPORTE_OPCION_SI" value="si">
                                                                    </div>
                                                                </td>
                                                                <td class="text-center">
                                                                    <div class="radio-container">
                                                                        <input class="form-check-input desabilitado" type="radio" name="REQUIEREPASAPORTE_OPCION_CUMPLE" id="REQUIEREPASAPORTE_OPCION_NO" value="no">
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <select class="form-control" id="REQUIERE_VISA_OPCION_PPT" name="REQUIERE_VISA_OPCION_PPT">
                                                                        <option selected disabled>Seleccione una opción</option>
                                                                        <option value="No aplica">No aplica</option>
                                                                        <option value="Deseable">Deseable</option>
                                                                        <option value="Requerido">Requerido</option>
                                                                    </select>
                                                                </td>
                                                                <td class="text-center">
                                                                    <div class="radio-container">
                                                                        <input class="form-check-input desabilitado" type="radio" name="REQUIEREVISA_OPCION_CUMPLE" id="REQUIEREVISA_OPCION_SI" value="si">
                                                                    </div>
                                                                </td>
                                                                <td class="text-center">
                                                                    <div class="radio-container">
                                                                        <input class="form-check-input desabilitado" type="radio" name="REQUIEREVISA_OPCION_CUMPLE" id="REQUIEREVISA_OPCION_NO" value="no">
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <select class="form-control" id="REQUIERELICENCIA_OPCION_PPT" name="REQUIERELICENCIA_OPCION_PPT">
                                                                        <option selected disabled>Seleccione una opción</option>
                                                                        <option value="No aplica">No aplica</option>
                                                                        <option value="Automovilista">Automovilista</option>
                                                                        <option value="Chofer">Chofer</option>
                                                                        <option value="Eq. Pesado">Eq. Pesado</option>
                                                                        <option value="Motociclista">Motociclista</option>
                                                                    </select>
                                                                </td>
                                                                <td class="text-center">
                                                                    <div class="radio-container">
                                                                        <input class="form-check-input desabilitado" type="radio" name="REQUIERELICENCIA_OPCION_CUMPLE" id="REQUIERELICENCIA_OPCION_SI" value="si">
                                                                    </div>
                                                                </td>
                                                                <td class="text-center">
                                                                    <div class="radio-container">
                                                                        <input class="form-check-input desabilitado" type="radio" name="REQUIERELICENCIA_OPCION_CUMPLE" id="REQUIERELICENCIA_OPCION_NO" value="no">
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <select class="form-control" id="CAMBIORESIDENCIA_OPCION_PPT" name="CAMBIORESIDENCIA_OPCION_PPT">
                                                                        <option selected disabled>Seleccione una opción</option>
                                                                        <option value="No aplica">No aplica</option>
                                                                        <option value="Nacional">Nacional</option>
                                                                        <option value="Internacional">Internacional</option>
                                                                    </select>
                                                                </td>
                                                                <td class="text-center">
                                                                    <div class="radio-container">
                                                                        <input class="form-check-input desabilitado" type="radio" name="CAMBIORESIDENCIA_OPCION_CUMPLE" id="CAMBIORESIDENCIA_OPCION_SI" value="si">
                                                                    </div>
                                                                </td>
                                                                <td class="text-center">
                                                                    <div class="radio-container">
                                                                        <input class="form-check-input desabilitado" type="radio" name="CAMBIORESIDENCIA_OPCION_CUMPLE" id="CAMBIORESIDENCIA_OPCION_NO" value="no">
                                                                    </div>

                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-4 mx-auto  text-center">
                                                    <div class="form-group ">
                                                        <label>Suma total del porcentaje del PPT</label>
                                                        <input type="number" class="form-control floating-input text-center" id="SUMA_TOTAL" name="SUMA_TOTAL" readonly>
                                                    </div>
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
                                                    <input type="text" class="form-control text-center" id="ELABORADO_NOMBRE_PPT" name="ELABORADO_NOMBRE_PPT" required>
                                                    <div>Nombre</div>
                                                    <br>
                                                    <input type="text" class="form-control text-center" id="ELABORADO_FIRMA_PPT" name="ELABORADO_FIRMA_PPT" required>
                                                    <div>Firma</div>
                                                    <br>
                                                    <input type="text" class="form-control text-center mydatepicker" placeholder="aaaa-mm-dd" id="ELABORADO_FECHA_PPT" name="ELABORADO_FECHA_PPT" required>
                                                    <i class="bi bi-calendar-event"></i>

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

                                                    <input type="text" class="form-control  text-center mydatepicker" placeholder="aaaa-mm-dd" id="REVISADO_FECHA_PPT" name="REVISADO_FECHA_PPT">
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

                                            <div class="row mb-3">

                                                <div class="col-6 text-center">
                                                    <label>Fecha de validación*</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_VALIDACION_PPT" name="FECHA_VALIDACION_PPT" required>
                                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="modal-footer mx-5">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                                    </div>
            </form>
        </div>
    </div>
</div>




<script>
    var pruebas = @json($pruebas);
</script>



@endsection