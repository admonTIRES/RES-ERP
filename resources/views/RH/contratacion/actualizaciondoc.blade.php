@extends('principal.maestra')

@section('contenido')



<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5" style="display: flex; justify-content: center; align-items: center;">
        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-briefcase-fill"></i>&nbsp;Actualización de documentos del colaborador - Actual</h3>
    </ol>


    <form method="post" enctype="multipart/form-data" id="formularioFECHAS">
        {!! csrf_field() !!}

        <div class="row justify-content-center align-items-end mb-4">
            <div class="col-md-3 text-center">
                <label>Fecha inicio</label>
                <div class="input-group">
                    <input type="text"
                        class="form-control mydatepicker"
                        placeholder="aaaa-mm-dd"
                        id="FECHA_INICIO"
                        name="FECHA_INICIO"
                        value="{{ $ultimaFecha->FECHA_INICIO ?? '' }}">
                    <span class="input-group-text">
                        <i class="bi bi-calendar-event"></i>
                    </span>
                </div>
            </div>
            <div class="col-md-3 text-center">
                <label>Fecha fin</label>
                <div class="input-group">
                    <input type="text"
                        class="form-control mydatepicker"
                        placeholder="aaaa-mm-dd"
                        id="FECHA_FIN"
                        name="FECHA_FIN"
                        value="{{ $ultimaFecha->FECHA_FIN ?? '' }}">
                    <span class="input-group-text">

                        <i class="bi bi-calendar-event"></i>
                    </span>
                </div>
            </div>
            <div class="col-md-3 text-center">
                <label>Seleccionar documentos</label>
                <select class="form-select"
                    id="TIPO_DOCUMENTO"
                    name="TIPO_DOCUMENTO[]"
                    multiple>

                    @foreach($documentos as $id => $nombre)
                    <option value="{{ $id }}"
                        {{ in_array((string)$id, $documentosSeleccionados ?? []) ? 'selected' : '' }}>
                        {{ $nombre }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex">
                <button type="submit" class="btn btn-success" id="guardaractulizacion">
                    Guardar
                </button>
            </div>
        </div>
    </form>

    <div class="card-body">
        <table id="Tabladocumentosactualizados" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
        </table>
    </div>

</div>






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

                    <div id="BOTON_VISTO_BUENO" style="display: block;">
                        <div id=" solicitarVerificacionDiv" class="col-12 text-center mt-3" style="display: block;">
                            <div class="col-md-6 mx-auto d-flex gap-2">
                                <button type="button" id="SOLICITAR_VERIFICACION" class="btn btn-info w-100" onclick="darVistoBueno()">
                                    Aceptar 
                                </button>
                                <button type="button" id="RECHAZAR_VERIFICACION" class="btn btn-danger w-100" onclick="rechazarVistoBueno()">
                                    Rechazar
                                </button>
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










@endsection