@extends('principal.maestraventas')

@section('contenido')



<style>
    .revision-row {
        background-color: #f0f0f0 !important;
        /* Fondo gris claro */
        font-size: 14px;
        /* Texto más pequeño */
    }

    .revision-row td {
        border-left: 3px solid #999 !important;
        /* Línea lateral para identificar */
    }
</style>

<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5" style="display: flex; justify-content: center; align-items: center;">
        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-currency-dollar"></i>&nbsp;Ofertas/Cotizaciones - Historial </h3>
    </ol>

    <div class="row justify-content-center align-items-end mb-4">
        <div class="col-md-3 text-center">
            <label>Fecha inicio</label>
            <div class="input-group">
                <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_INICIO">
                <span class="input-group-text">
                    <i class="bi bi-calendar-event"></i>
                </span>
            </div>
        </div>
        <div class="col-md-3 text-center">
            <label>Fecha fin</label>
            <div class="input-group">
                <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_FIN">
                <span class="input-group-text">
                    <i class="bi bi-calendar-event"></i>
                </span>
            </div>
        </div>
        <div class="col-md-2 d-flex">
            <button
                type="button"
                class="btn btn-primary btn-circle"
                id="btnFiltrarMR"
                title="Filtrar"
                data-bs-toggle="tooltip"
                data-bs-placement="top">
                <i class="bi bi-filter"></i>
            </button>
        </div>
    </div>

    <div class="card-body">
        <table id="Tablaofertashistorial" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
        </table>
    </div>


</div>










<div class="modal modal-fullscreen fade" id="miModal_OFERTAS" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioOFERTAS" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h5 class="modal-title" id="miModalLabel">Ofertas/Cotizaciones</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="row">

                        <div class="mb-3">
                            <label>N° de solicitud</label>
                            <select class="custom-select form-control" id="SOLICITUD_ID" name="SOLICITUD_ID">
                                <option selected disabled>Seleccione una solicitud</option>
                                @foreach($solicitudes as $solicitud)
                                <option value="{{ $solicitud->ID_FORMULARIO_SOLICITUDES }}">
                                    {{ $solicitud->NO_SOLICITUD }} ({{ $solicitud->NOMBRE_COMERCIAL_SOLICITUD }})
                                </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-12">
                            <div class="row">
                                <div class="col-4">
                                    <label>O/C No.</label>
                                    <input type="text" class="form-control" id="NO_OFERTA" name="NO_OFERTA" readonly>
                                </div>
                                <div class="col-1">
                                    <label>Rev</label>
                                    <input type="text" class="form-control" id="REVISION_OFERTA" name="REVISION_OFERTA" readonly>
                                </div>
                                <div class="col-4">
                                    <label>Fecha de la cotización/Revisiones *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_OFERTA" name="FECHA_OFERTA" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <label>Tiempo en días desde la solicitud</label>
                                    <input type="number" class="form-control" id="TIEMPO_OFERTA" name="TIEMPO_OFERTA" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <label>Servicio cotizado *</label>
                            <textarea type="text" class="form-control" id="SERVICIO_COTIZADO_OFERTA" name="SERVICIO_COTIZADO_OFERTA" rows="4" required></textarea>
                        </div>

                        <div class="col-12 mt-3">
                            <div class="row">
                                <div class="col-lg-2 col-sm-6 mt-3">
                                    <label class="form-check-label" for="MONEDA_MONTOMNX">
                                        Monto MXN
                                    </label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="MONEDA_MONTO" id="MONEDA_MONTOMNX" value="MXN" checked>

                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 mt-3">
                                    <label class="form-check-label" for="MONEDA_MONTOUSD">
                                        Monto USD
                                    </label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="MONEDA_MONTO" id="MONEDA_MONTOUSD" value="USD">
                                    </div>
                                </div>
                                <div class="col-4 mt-3">
                                    <label>Importe sin IVA *</label>
                                    <input type="text" step="0.01" class="form-control" id="IMPORTE_OFERTA" name="IMPORTE_OFERTA" required>
                                </div>
                                <div class="col-4 mt-3">
                                    <label>Días de validez de la OC *</label>
                                    <input type="number" class="form-control" id="DIAS_VALIDACION_OFERTA" name="DIAS_VALIDACION_OFERTA" required>
                                </div>
                            </div>
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

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Cargar Cotización (PDF) *</label>
                            <div class="d-flex align-items-center">
                                <input type="file" class="form-control me-2" name="COTIZACION_DOCUMENTO" accept=".pdf">
                                <button type="button" class="btn btn-warning botonEliminarArchivo" title="Eliminar archivo">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>



                        <div class="col-md-6 mb-3">
                            <label class="form-label">Términos y condiciones (PDF) *</label>
                            <div class="d-flex align-items-center">
                                <input type="file" class="form-control me-2" name="TERMINOS_DOCUMENTO" accept=".pdf">
                                <button type="button" class="btn btn-warning botonEliminarArchivo" title="Eliminar archivo">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>





                        <div class="col-12 mt-3" id="RECHAZO" style="display: none;">
                            <div class="mb-3">
                                <label class="form-label">Motivo del rechazo</label>
                                <textarea class="form-control" id="MOTIVO_RECHAZO" name="MOTIVO_RECHAZO" rows="4" readonly></textarea>
                            </div>
                        </div>







                    </div>
                </div>

                <div class="col-12 text-center">
                    <div class="col-md-6 mx-auto">
                        <button type="button" id="crearREVISION" class="btn btn-warning w-100">
                            Crear Revisión
                        </button>
                    </div>
                </div>

                <br>

                <div class="modal-footer mx-5">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarOFERTA">
                        <i class="bi bi-floppy-fill" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Guardar Ofertas/Cotizaciones"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="modalMotivoRevision" tabindex="-1" aria-labelledby="modalMotivoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalMotivoLabel">Motivo de la Revisión</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <textarea id="motivoRevisionInput" class="form-control" rows="4" placeholder="Escriba el motivo de la revisión..."></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" id="confirmarMotivoRevision" class="btn btn-primary">Confirmar</button>
            </div>
        </div>
    </div>
</div>



<script>
    var solicitudesFechas = @json($solicitudes -> pluck('FECHA_SOLICITUD', 'ID_FORMULARIO_SOLICITUDES'));
</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/th





@endsection