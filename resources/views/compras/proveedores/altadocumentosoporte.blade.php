@extends('principal.maestraproveedores')

@section('contenido')




<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-file-earmark-pdf-fill"></i>&nbsp;Documentos de soporte</h3>


        <button type="button" class="btn btn-light waves-effect waves-light" id="NUEVO_DOCUMENTO" data-bs-toggle="modal" data-bs-target="#miModal_documentos" style="margin-left: auto;">
            Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
        </button>
    </ol>

    <div class="card-body">
        <table id="Tabladocumentosproveedores" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
            <i id="loadingIcon1" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>

        </table>
    </div>
</div>


<div class="modal fade" id="miModal_documentos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioDOCUMENTOS" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nuevo documento</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Documento *</label>
                            <select class="form-control" name="TIPO_DOCUMENTO_PROVEEDOR" id="TIPO_DOCUMENTO_PROVEEDOR">
                                <option value="" selected disabled>Seleccione una opción</option>

                                <optgroup label="Documentos obligatorios">
                                    @foreach ($documetoscatalogo->where('TIPO_DOCUMENTO', 1) as $documento)
                                    <option value="{{ $documento->ID_CATALOGO_DOCUMENTOSPROVEEDOR }}">
                                        {{ $documento->NOMBRE_DOCUMENTO }}
                                    </option>
                                    @endforeach
                                </optgroup>

                                <optgroup label="Documentos opcionales">
                                    @foreach ($documetoscatalogo->where('TIPO_DOCUMENTO', 2) as $documento)
                                    <option value="{{ $documento->ID_CATALOGO_DOCUMENTOSPROVEEDOR }}">
                                        {{ $documento->NOMBRE_DOCUMENTO }}
                                    </option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>


                        <div class="mb-3">
                            <label>Nombre del archivo </label>
                            <input type="text" class="form-control" id="NOMBRE_DOCUMENTO_PROVEEEDOR" name="NOMBRE_DOCUMENTO_PROVEEEDOR" readonly required>
                        </div>



                        <div class="col-12 mb-3">
                            <label class="form-label">
                                Anexar documento &nbsp;
                            </label>
                            <div class="input-group align-items-center">
                                <input type="file" class="form-control" name="DOCUMENTO_SOPORTE" id="DOCUMENTO_SOPORTE" accept="application/pdf" required>
                                <i id="iconEliminarArchivo" class="bi bi-trash-fill ms-2 text-danger fs-5 d-none" style="cursor: pointer;" title="Eliminar archivo"></i>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarDOCUMENTOS">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade" id="modalActualizarDocumento">

    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Actualizar documento</h5>
            </div>

            <div class="modal-body">

                <form id="formActualizarDocumento" enctype="multipart/form-data">

                    <input type="hidden" name="ID_FORMULARIO_DOCUMENTOSPROVEEDOR" id="ID_FORMULARIO_DOCUMENTOSPROVEEDOR">
                    <input type="hidden" name="TIPO_DOCUMENTO_PROVEEDOR" id="TIPO_DOCUMENTO_PROVEEDOR_ACT">

                    <div class="mb-3">
                        <label>Seleccione documento (PDF)</label>
                        <input type="file"
                            class="form-control"
                            name="DOCUMENTO_SOPORTE"
                            accept="application/pdf"
                            required>
                    </div>

                </form>

            </div>

            <div class="modal-footer">

                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>

                <button class="btn btn-primary" id="guardarActualizacionDoc">
                    Actualizar</button>

            </div>

        </div>
    </div>
</div>

@endsection