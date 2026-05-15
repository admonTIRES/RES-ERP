@extends('principal.maestraproveedores')

@section('contenido')




<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-award-fill"></i>&nbsp;Certificaciones, acreditaciones y membresías</h3>


        <button type="button" class="btn btn-light waves-effect waves-light" id="NUEVA_CERTIFICACION" data-bs-toggle="modal" data-bs-target="#miModal_certificaciones" style="margin-left: auto;">
            Nueva &nbsp;<i class="bi bi-plus-circle"></i>
        </button>
    </ol>

    <div class="card-body">

        <table id="Tablacertificacionproveedores" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
            <i id="loadingIcon1" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
        </table>
    </div>
</div>

<div class="modal fade" id="miModal_certificaciones" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioCertificaciones" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Certificación, acreditación o membresía</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}

                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label">Seleccione el tipo *</label>
                            <select class="form-control" id="TIPO_DOCUMENTO" name="TIPO_DOCUMENTO" required>
                                <option value="" selected disabled>Seleccione una opción</option>
                                <option value="Certificación">Certificación</option>
                                <option value="Acreditación">Acreditación</option>
                                <option value="Membresía">Membresía</option>
                            </select>
                        </div>

                        <!-- Sección Certificación -->
                        <div id="DIV_CERTIFICACION" class="col-12" style="display: none;">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label">Norma estándar *</label>
                                    <input type="text" class="form-control" name="NORMA_CERTIFICACION" id="NORMA_CERTIFICACION">
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Versión *</label>
                                    <input type="text" class="form-control" name="VERSION_CERTIFICACION" id="VERSION_CERTIFICACION">
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Organismo certificador *</label>
                                    <input type="text" class="form-control" name="ENTIDAD_CERTIFICADORA" id="ENTIDAD_CERTIFICADORA">
                                </div>

                                <div class="col-6 mb-3">
                                    <label>Certificado desde *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="DESDE_CERTIFICACION" name="DESDE_CERTIFICACION">
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>

                                <div class="col-6 mb-3">
                                    <label>Hasta *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="HASTA_CERTIFICACION" name="HASTA_CERTIFICACION">
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">Subir archivo (PDF) *</label>
                                    <input type="file" class="form-control" name="DOCUMENTO_CERTIFICACION" id="DOCUMENTO_CERTIFICACION" accept=".pdf">
                                </div>
                            </div>
                        </div>

                        <!-- Sección Acreditación -->
                        <div id="DIV_ACREDITACION" class="col-12" style="display: none;">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label">Norma *</label>
                                    <input type="text" class="form-control" name="NORMA_ACREDITACION" id="NORMA_ACREDITACION">
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Versión *</label>
                                    <input type="text" class="form-control" name="VERSION_ACREDITACION" id="VERSION_ACREDITACION">
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Alcance de la certificación *</label>
                                    <input type="text" class="form-control" name="ALCANCE_ACREDITACION" id="ALCANCE_ACREDITACION">
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Organismo acreditador *</label>
                                    <input type="text" class="form-control" name="ENTIDAD_ACREDITADORA" id="ENTIDAD_ACREDITADORA">
                                </div>
                                <div class="col-12 mb-3">
                                    <label>Acreditado desde *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="DESDE_ACREDITACION" name="DESDE_ACREDITACION">
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Subir archivo (PDF) *</label>
                                    <input type="file" class="form-control" name="DOCUMENTO_ACREDITACION" id="DOCUMENTO_ACREDITACION" accept=".pdf">
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">¿El estándar requiere aprobación o autorización? *</label>
                                    <select class="form-control" id="REQUISITO_AUTORIZACION" name="REQUISITO_AUTORIZACION">
                                        <option value="" selected disabled>Seleccione una opción</option>
                                        <option value="Si">Sí</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div id="DIV_AUTORIZACION" class="col-12" style="display: none;">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Entidad *</label>
                                            <input type="text" class="form-control" name="ENTIDAD_AUTORIZADORA" id="ENTIDAD_AUTORIZADORA">
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label>Desde *</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="DESDE_AUTORIZACION" name="DESDE_AUTORIZACION">
                                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                            </div>
                                        </div>


                                        <div class="col-6 mb-3">
                                            <label>Hasta *</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="HASTA_ACREDITACION" name="HASTA_ACREDITACION">
                                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                            </div>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label class="form-label">Subir archivo (PDF) *</label>
                                            <input type="file" class="form-control" name="DOCUMENTO_AUTORIZACION" id="DOCUMENTO_AUTORIZACION" accept=".pdf">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sección Membresía -->
                        <div id="DIV_MEMBRESIA" class="col-12" style="display: none;">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label">Nombre de la entidad *</label>
                                    <input type="text" class="form-control" name="NOMBRE_ENTIDAD_MEMBRESIA" id="NOMBRE_ENTIDAD_MEMBRESIA">
                                </div>

                                <div class="col-6 mb-3">
                                    <label>Miembro desde *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="DESDE_MEMBRESIA" name="DESDE_MEMBRESIA">
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>

                                <div class="col-6 mb-3">
                                    <label>Vigencia hasta *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="HASTA_MEMBRESIA" name="HASTA_MEMBRESIA">
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Subir archivo (PDF) *</label>
                                    <input type="file" class="form-control" name="DOCUMENTO_MEMBRESIA" id="DOCUMENTO_MEMBRESIA" accept=".pdf">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarCertificaciones">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>





@endsection