@extends('principal.maestracompras')

@section('contenido')


<style>
    .bg-verde-suave {
        background-color: #d1e7dd !important;
    }

    .bg-rojo-suave {
        background-color: #f8d7da !important;
    }

    .color-vo {
        transition: background-color 0.3s ease;
    }
</style>



<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5" style="display: flex; justify-content: center; align-items: center;">
        <h3 style="color: #ffffff; margin: 0;">&nbsp; Vo.Bo - MR
        </h3>

    </ol>

    <div class="card-body">
        <table id="Tablarequisicion" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">

        </table>
    </div>
</div>


<div class="modal fade" id="miModal_MR" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioMR" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Requisición de Materiales</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}


                    <div id="SOLICITUD_MR">


                        <div class="col-12 mt-3">
                            <div class="row">
                                <div class="col-9">
                                    <label>Solicitante </label>
                                    <input type="text" class="form-control" id="SOLICITANTE_MR" name="SOLICITANTE_MR" readonly>
                                </div>

                                <div class="col-3">
                                    <label>Fecha de solicitud *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_SOLICITUD_MR" name="FECHA_SOLICITUD_MR" style="pointer-events:none; background-color:#e9ecef;" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-12 mt-3">
                            <div class="row">
                                <div class="col-9">
                                    <label>Área Solicitante </label>
                                    <input type="text" class="form-control" id="AREA_SOLICITANTE_MR" name="AREA_SOLICITANTE_MR" readonly>
                                </div>
                                <div class="col-3">
                                    <label>No. de MR *</label>
                                    <input type="text" class="form-control" id="NO_MR" name="NO_MR" readonly>
                                </div>
                            </div>
                        </div>




                        <div class="mt-3">

                            <div class="materialesdiv mt-4"></div>
                        </div>

                        <div class="mt-3">
                            <label>Justificación *</label>
                            <textarea class="form-control" id="JUSTIFICACION_MR" name="JUSTIFICACION_MR" rows="3"></textarea>
                        </div>





                        <div id="VISTO_BUENO_JEFE" style="display: block;">



                            <div class="col-12 mt-3">
                                <div class="row">
                                    <div class="col-4">
                                        <label for="PRIORIDAD">Prioridad *</label>
                                        <select class="form-control" id="PRIORIDAD_MR" name="PRIORIDAD_MR" required>
                                            <option value="" selected disabled>Seleccione una opción</option>
                                            <option value="Alta">Alta 1-15 días</option>
                                            <option value="Media">Media 16-30 días</option>
                                            <option value="Baja">Baja 31-60 días</option>
                                        </select>
                                    </div>

                                    <div class="col-8">
                                        <label for="OBSERVACIONES">Observaciones</label>
                                        <input type="text" class="form-control" id="OBSERVACIONES_MR" name="OBSERVACIONES_MR">
                                    </div>

                                </div>
                            </div>





                            <div class="col-12 mt-3">
                                <div class="row">
                                    <div class="col-8">
                                        <label for="VISTO_BUENO">Visto bueno</label>
                                        <input type="text" class="form-control" id="VISTO_BUENO" name="VISTO_BUENO" readonly>
                                        <meta name="usuario-autenticado" content="{{ Auth::user()->EMPLEADO_NOMBRE }} {{ Auth::user()->EMPLEADO_APELLIDOPATERNO }} {{ Auth::user()->EMPLEADO_APELLIDOMATERNO }}">
                                    </div>

                                    <div class="col-4">
                                        <label>Fecha *</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_VISTO_MR" name="FECHA_VISTO_MR"  style="pointer-events:none; background-color:#e9ecef;" required>
                                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-12 mt-3" id="MOTIVO_RECHAZO_JEFE_DIV" style="display: none;">
                                <label>Motivo del rechazo del jefe inmediato</label>
                                <textarea class="form-control" id="MOTIVO_RECHAZO_JEFE" name="MOTIVO_RECHAZO_JEFE" rows="3" placeholder="Escriba el motivo de rechazo..."></textarea>
                            </div>


                        </div>


                        <div id="BOTON_VISTO_BUENO" style="display: block;">
                            <div id=" solicitarVerificacionDiv" class="col-12 text-center mt-3" style="display: block;">
                                <div class="col-md-6 mx-auto d-flex gap-2">
                                    <button type="button" id="SOLICITAR_VERIFICACION" class="btn btn-info w-100" onclick="darVistoBueno()">
                                        Dar visto bueno
                                    </button>
                                    <button type="button" id="RECHAZAR_VERIFICACION" class="btn btn-danger w-100" onclick="rechazarVistoBueno()">
                                        Rechazar
                                    </button>
                                </div>
                            </div>

                            <input type="hidden" id="DAR_BUENO" name="DAR_BUENO" value="0">


                        </div>




                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="modalRechazo" tabindex="-1" aria-labelledby="modalRechazoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalRechazoLabel">Motivo de Rechazo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="formRechazo">
                    <div class="mb-3">
                        <label for="motivoRechazoTextarea" class="form-label">Explique el motivo del rechazo:</label>
                        <textarea class="form-control" id="motivoRechazoTextarea" name="motivo" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger w-100">Enviar Rechazo</button>
                </form>
            </div>
        </div>
    </div>
</div>




@endsection