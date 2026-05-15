@extends('principal.maestra')

@section('contenido')



<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;">&nbsp;Anuncios</h3>
        <button type="button" class="btn btn-light waves-effect waves-light " id="NUEVO_ANUNCIO" style="margin-left: auto;">
            Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
        </button>
    </ol>

    <div class="card-body">
        <table id="Tablanuncios" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
        </table>
    </div>
</div>


<div class="modal fade" id="miModal_anuncio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioAnuncio" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nuevo anuncio</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}

                    <div class="mb-3">
                        <label>Título del anuncio</label>
                        <input type="text"  class="form-control" id="TITULO_ANUNCIO" name="TITULO_ANUNCIO">
                    </div>

                    <div class="mb-3">
                        <label>Descripción</label>
                        <textarea class="form-control" id="DESCRIPCION_ANUNCIO" name="DESCRIPCION_ANUNCIO" rows="4"></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Tipo de repetición del anuncio</label>
                        <select class="form-select" id="TIPO_REPETICION" name="TIPO_REPETICION">
                            <option value="normal">No repetir (fecha específica)</option>
                            <option value="anual">Repetir cada año (día fijo)</option>
                            <option value="mensual">Mostrar todo el mes</option>
                        </select>
                    </div>

                    <div id="campos_normales">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Fecha de inicio *</label>
                                <div class="input-group">
                                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_INICIO" name="FECHA_INICIO">
                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Fecha de fin *</label>
                                <div class="input-group">
                                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_FIN" name="FECHA_FIN">
                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Hora de inicio *</label>
                                <input type="time" class="form-control" id="HORA_INICIO" name="HORA_INICIO">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Hora de fin *</label>
                                <input type="time" class="form-control" id="HORA_FIN" name="HORA_FIN">
                            </div>
                        </div>
                    </div>

                    <div id="campos_anual" style="display:none;">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>Fecha del evento (día y mes)</label>
                                <input type="text" class="form-control" id="FECHA_ANUAL" name="FECHA_ANUAL" placeholder="Ej. 10-05">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Hora de inicio</label>
                                <input type="time" class="form-control" id="HORA_ANUAL_INICIO" name="HORA_ANUAL_INICIO">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Hora de fin</label>
                                <input type="time" class="form-control" id="HORA_ANUAL_FIN" name="HORA_ANUAL_FIN">
                            </div>
                        </div>
                    </div>

                    <div id="campos_mensual" style="display:none;">
                        <div class="mb-3">
                            <label>Mes del evento</label>
                            <select class="form-select" id="MES_MENSUAL" name="MES_MENSUAL">
                                <option value="">Selecciona un mes</option>
                                <option value="01">Enero</option>
                                <option value="02">Febrero</option>
                                <option value="03">Marzo</option>
                                <option value="04">Abril</option>
                                <option value="05">Mayo</option>
                                <option value="06">Junio</option>
                                <option value="07">Julio</option>
                                <option value="08">Agosto</option>
                                <option value="09">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Foto *</label>
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
                                <input type="file" accept="image/jpeg,image/x-png" id="FOTO_ANUNCIO" name="FOTO_ANUNCIO" class="dropify" data-allowed-file-extensions="jpg png" data-height="300" data-default-file="" />
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarANUNCIO">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>




@endsection