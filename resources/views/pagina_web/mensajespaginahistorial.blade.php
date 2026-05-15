@extends('pagina_web.maestrapagina')

@section('contenido')



<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5" style="display: flex; justify-content: center; align-items: center;">
        <h3 style="color: #ffffff; margin: 0; text-align: center;">&nbsp;Mensajes - Historial</h3>
    </ol>

    <div class="card-body">
        <table id="Tablamensajepaginawebhistorial" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">

        </table>
    </div>

</div>



<div class="modal fade" id="miModal_MENSAJES" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioMENSAJES" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}

                    <div class="mb-3">
                        <label>Nombre</label>
                        <input type="text" class="form-control" id="NOMBRE" name="NOMBRE">
                    </div>

                    <div class="mb-3">
                        <label>Correo electrónico </label>
                        <input type="text" class="form-control" id="CORREO" name="CORREO">
                    </div>

                    <div class="mb-3">
                        <label>Número de teléfono </label>
                        <input type="text" class="form-control" id="TELEFONO" name="TELEFONO">
                    </div>

                    <div class="mb-3">
                        <label>Mensaje: *</label>
                        <textarea class="form-control" id="MENSAJE" name="MENSAJE" rows="5"></textarea>
                    </div>

                    <div class="mb-3">
                        <div class="form-group">
                            <label>Fue atendida la solicitud *</label>
                            <select class="form-select" id="SOLICITUD_ATENDIDA" name="SOLICITUD_ATENDIDA" required>
                                <option value="" disabled selected>Seleccione una opción</option>
                                <option value="1">Sí</option>
                                <option value="2">No</option>
                            </select>
                        </div>
                    </div>

                    <div id="DIV_SOLCITUD" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label">Quien atendió la solicitud *</label>
                            <input type="text" class="form-control"  id="ATENDIO_SOLICITUD" name="ATENDIO_SOLICITUD" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Fecha *</label>
                            <div class="input-group">
                                <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_ATENCION" name="FECHA_ATENCION" required>
                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                            </div>
                        </div>
                    </div>

                    <div id="NO_ATENDIDA" style="display: none;">

                        <div class="mb-3">
                            <label>Motivo por el que no fue atendida *</label>
                            <textarea class="form-control" id="MOTIVO_NOATENDIDO" name="MOTIVO_NOATENDIDO" rows="5" required></textarea>
                        </div>
                    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarpaginaweb">Guardar</button>

                </div>
            </form>
        </div>
    </div>
</div>



@endsection