@extends('principal.maestraventas')

@section('contenido')



<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5" style="display: flex; justify-content: center; align-items: center;">
        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-patch-check-fill"></i>&nbsp;Orden de trabajo - Historial </h3>
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
        <table id="Tablaordentrabajohistorial" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
        </table>
    </div>


</div>










<div class="modal modal-fullscreen fade" id="miModal_OT" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioOT" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h5 class="modal-title" id="miModalLabel">Orden de trabajo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="row">




                        <div class="mb-3">
                            <label>N° de Ofertas/Cotizaciones</label>
                            <select class="custom-select form-control" id="OFERTA_ID" name="OFERTA_ID[]" multiple>
                                <option selected disabled>Seleccione una cotización</option>
                                @foreach($solicitudes as $solicitud)
                                <option value="{{ $solicitud->ID_FORMULARIO_OFERTAS }}">
                                    {{ $solicitud->NO_OFERTA }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 mt-3">
                            <div class="row">
                                <div class="col-md-12 mb-3 text-center">
                                    <h5 class="form-label"><b>Volver a utilizar esta cotización para varias órdenes de trabajo </b></h5>
                                    <br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="UTILIZAR_COTIZACION" id="utilizarcotsi" value="1" required>
                                        <label class="form-check-label" for="utilizarcotsi">Sí</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="UTILIZAR_COTIZACION" id="utilizarcotno" value="2">
                                        <label class="form-check-label" for="utilizarcotno">No</label>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-12 mt-3">
                            <div class="row">


                                <div class="col-6">
                                    <label>Orden de Trabajo (OT) No. </label>
                                    <input type="text" class="form-control" id="NO_ORDEN_CONFIRMACION" name="NO_ORDEN_CONFIRMACION" readonly>
                                </div>

                                <div class="col-6">
                                    <label>Fecha de emisión de la OT*</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_EMISION" name="FECHA_EMISION" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="row">


                                <div class="col-6  mt-3">
                                    <label>Razón Social *</label>
                                    <input type="text" class="form-control" id="RAZON_CONFIRMACION" name="RAZON_CONFIRMACION">
                                </div>

                                <div class="col-6  mt-3">
                                    <label>Nombre comercial *</label>
                                    <input type="text" class="form-control" id="COMERCIAL_CONFIRMACION" name="COMERCIAL_CONFIRMACION">
                                </div>


                                <div class="col-6  mt-3">
                                    <label>RFC: *</label>
                                    <input type="text" class="form-control" id="RFC_CONFIRMACION" name="RFC_CONFIRMACION">
                                </div>

                                <div class="col-6  mt-3">
                                    <label>Giro de la empresa: *</label>
                                    <input type="text" class="form-control" id="GIRO_CONFIRMACION" name="GIRO_CONFIRMACION">
                                </div>

                                <div class="col-12  mt-3">
                                    <label>Seleccione dirección </label>
                                    <select class="form-control" id="SELECTOR_DIRECCION" name="SELECTOR_DIRECCION">
                                        <option value="" disabled selected>Seleccione una opción</option>
                                    </select>
                                </div>


                                <div class="col-12  mt-3">
                                    <label>Dirección del servicio *</label>
                                    <input type="text" class="form-control" id="DIRECCION_CONFIRMACION" name="DIRECCION_CONFIRMACION">
                                </div>

                                <div class="col-6  mt-3">
                                    <label>Seleccione quien solicita </label>
                                    <select class="form-control" id="SELECTOR_SOLICITA" name="SELECTOR_SOLICITA">
                                        <option value="" disabled selected>Seleccione una opción</option>
                                    </select>
                                </div>

                                <div class="col-6  mt-3">
                                    <label>Persona que solicita *</label>
                                    <input type="text" class="form-control" id="PERSONA_SOLICITA_CONFIRMACION" name="PERSONA_SOLICITA_CONFIRMACION">
                                </div>


                                <div class="col-4  mt-3">
                                    <label class="form-label">Seleccione contacto </label>
                                    <select class="form-control" id="SELECTOR_CONTACTO" name="SELECTOR_CONTACTO">
                                        <option value="" disabled selected>Seleccione una opción</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mt-3">
                                    <label class="form-label">Título</label>
                                    <select class="form-select" name="TITULO_CONFIRMACION" id="TITULO_CONFIRMACION">
                                        <option value="0" disabled selected>Seleccione una opción</option>
                                        @foreach ($titulosCuenta as $linea)
                                        <option value="{{ $linea->ABREVIATURA_TITULO }}">{{ $linea->NOMBRE_TITULO }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-4  mt-3">
                                    <label>Contacto *</label>
                                    <input type="text" class="form-control" id="CONTACTO_CONFIRMACION" name="CONTACTO_CONFIRMACION">
                                </div>

                                <div class="col-4  mt-3">
                                    <label>Teléfono *</label>
                                    <input type="text" class="form-control" id="CONTACTO_TELEFONO_CONFIRMACION" name="CONTACTO_TELEFONO_CONFIRMACION">
                                </div>
                                <div class="col-4  mt-3">
                                    <label>Celular *</label>
                                    <input type="text" class="form-control" id="CONTACTO_CELULAR_CONFIRMACION" name="CONTACTO_CELULAR_CONFIRMACION">
                                </div>

                                <div class="col-4  mt-3">
                                    <label>E-mail *</label>
                                    <input type="text" class="form-control" id="CONTACTO_EMAIL_CONFIRMACION" name="CONTACTO_EMAIL_CONFIRMACION">
                                </div>

                            </div>
                        </div>



                        <div class="col-12 mt-3">
                            <div class="row">

                                <div class="col-3">
                                    <label>Verificado por </label>
                                    <input type="text" class="form-control"
                                        id="VERIFICADO_POR"
                                        name="VERIFICADO_POR"
                                        readonly
                                        data-usuario="{{ Auth::user()->EMPLEADO_NOMBRE }} {{ Auth::user()->EMPLEADO_APELLIDOPATERNO }} {{ Auth::user()->EMPLEADO_APELLIDOMATERNO }}">
                                </div>

                                <div class="col-3">
                                    <label>Fecha de verificación *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_VERIFICACION" name="FECHA_VERIFICACION" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <label>Prioridad del servicio *</label>
                                    <select class="form-control" id="PRIORIDAD_SERVICIO" name="PRIORIDAD_SERVICIO" required>
                                        <option value="" disabled selected>Seleccione una opción</option>
                                        <option value="1">Normal</option>
                                        <option value="2">Urgente</option>
                                    </select>
                                </div>


                                <div class="col-3">
                                    <label>Fecha de inicio del servicio*</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_INICIO_SERVICIO" name="FECHA_INICIO_SERVICIO" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-12 mt-3">
                            <div class="row">

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Necesidad u objetivo del servicio: *</label>
                                    <textarea class="form-control" id="NECESIDAD_SERVICIO_CONFIRMACION" name="NECESIDAD_SERVICIO_CONFIRMACION" rows="5" required></textarea>
                                </div>

                                <div class="mt-3">
                                    <div class="row">
                                        <div class="col-6 mb-3">
                                            <label>Agregar servicio</label>
                                            <button id="botonmaterial" id="botonmaterial" type="button" class="btn btn-danger ml-2 rounded-pill" title="Agregar">
                                                <i class="bi bi-plus-circle-fill"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="materialesdiv mt-4"></div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Observaciones: </label>
                                    <textarea class="form-control" id="OBSERVACIONES_CONFIRMACION" name="OBSERVACIONES_CONFIRMACION" rows="5"></textarea>
                                </div>

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
                    <button type="submit" class="btn btn-success" id="guardarOT">
                        <i class="bi bi-floppy-fill" data-bs-toggle="tooltip" data-bs-placement="top"></i> Guardar
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


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/th





@endsection