@extends('principal.maestramantenimiento')


@section('contenido')

<style>
    .bg-amarillo-suave {
        background-color: #fff3cd !important;
    }

    .bg-verde-suave {
        background-color: #d4edda !important;
    }

    .bg-rojo-suave {
        background-color: #f8d7da !important;
    }


    .select2-dropdown-fixed {
        position: absolute !important;
        top: unset !important;
        bottom: unset !important;
    }


    .select2-results__option.opcion-asignada {
        color: #fcba6fff !important;
        font-style: italic;
    }


    .progress {
        background-color: #eee;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress div {
        height: 100%;
        transition: width 0.5s ease;
    }


    .filtro-color {
        cursor: pointer;
        transition: 0.3s;
    }

    .filtro-color:hover {
        opacity: 0.7;
    }

    .filtro-color.active {
        border: 2px solid #000;
    }

    .progress {
        background-color: #eee;
        border-radius: 10px;
        overflow: hidden;
    }
</style>

<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-box-arrow-right"></i>&nbsp;Salida de almacén de materiales y/o equipos</h3>
        <button type="button" class="btn btn-light waves-effect waves-light " id="NUEVA_SALIDAMTTO" style="margin-left: auto;">
            Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
        </button>
    </ol>

    <div class="mb-3">

        <div class="mb-2 filtro-color" data-color="bg-verde-suave">
            <div class="d-flex justify-content-between">
                <span>Finalizada</span>
            </div>
            <div class="progress" style="height: 10px;">
                <div class="progress-bar bg-verde-suave" style="width: 100%;"></div>
            </div>
        </div>

        <div class="mb-2 filtro-color" data-color="bg-amarillo-suave">
            <div class="d-flex justify-content-between">
                <span>Pendiente por retornar</span>
            </div>

            <div class="progress" style="height: 10px;">
                <div class="progress-bar bg-amarillo-suave" style="width: 100%;"></div>
            </div>
        </div>

        <div class="mb-2 filtro-color" data-color="bg-rojo-suave">
            <div class="d-flex justify-content-between">
                <span>Retorno vencido</span>
            </div>

            <div class="progress" style="height: 10px;">
                <div class="progress-bar bg-rojo-suave" style="width: 100%;"></div>
            </div>
        </div>
        <div class="text-end mt-2">
            <button id="limpiarFiltro" class="btn btn-secondary btn-sm">
                Mostrar todo
            </button>
        </div>

    </div>


    <div class="card-body">
        <table id="Tablasalidalmacenmtto" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
        </table>
    </div>

</div>




<div class="modal fade" id="miModal_salidamtto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formulariosalidamtto" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Salida de almacén de materiales y/o equipos</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}

                    <input type="hidden" id="FIRMO_USUARIO" name="FIRMO_USUARIO" value="">

                    <input type="hidden" id="FINALIZAR_SALIDA_ALMACEN" name="FINALIZAR_SALIDA_ALMACEN" value="1">


                    <div class="col-12 mt-3">
                        <div class="row">
                            <div class="col-9">
                                <label class="form-label">Solicitante </label>
                                <input type="text" class="form-control" value="{{ Auth::user()->EMPLEADO_NOMBRE }} {{ Auth::user()->EMPLEADO_APELLIDOPATERNO }} {{ Auth::user()->EMPLEADO_APELLIDOMATERNO }}" id="SOLICITANTE_SALIDA" name="SOLICITANTE_SALIDA" readonly>
                            </div>

                            <div class="col-3">
                                <label class="form-label">Fecha de salida *</label>
                                <div class="input-group">
                                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_SALIDA" name="FECHA_SALIDA"
                                        style="pointer-events:none; background-color:#e9ecef;" required tabindex="-1">
                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <div class="row">
                            <div class="col-6 mb-3" id="AGREGAR_MATERIAL" style="display: none;">
                                <label>Agregar material</label>
                                <button id="botonmaterial" id="botonmaterial" type="button" class="btn btn-danger ml-2 rounded-pill" title="Agregar">
                                    <i class="bi bi-plus-circle-fill"></i>
                                </button>
                            </div>
                        </div>
                        <div class="materialesdiv mt-4"></div>
                    </div>

                    <div class="col-12 mt-3 d-flex align-items-center">
                        <div class="col-6" id="FECHA_ESTIMADA" style="display: none;">
                            <label class="col-form-label me-2">Fecha estimada de retorno *</label>
                            <div class="input-group">
                                <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd"
                                    id="FECHA_ESTIMADA_SALIDA" name="FECHA_ESTIMADA_SALIDA" required>
                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                            </div>
                        </div>
                    </div>


                    <div class="col-12 mt-3">
                        <div class="row">
                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label>¿Cuenta con una orden de servicio? *</label>
                                    <select class="form-select" id="TIENE_ORDEN" name="TIENE_ORDEN" required>
                                        <option value="" disabled selected>Seleccione una opción</option>
                                        <option value="1">Sí</option>
                                        <option value="2">No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-6 mt-3" id="NO_ORDEN" style="display: none;">
                                <div class="form-group">
                                    <label>No. orden de servicio *</label>
                                    <input type="text" class="form-control" id="NO_ORDEN_SERVICIO" name="NO_ORDEN_SERVICIO" required>
                                </div>
                            </div>

                            <div class="col-6 mt-3" id="NO_TIENE_ORDEN" style="display: none;">
                                <div class="form-group">
                                    <label>¿Por qué no cuenta con una orden de servicio? *</label>
                                    <input type="text" class="form-control" id="NO_CUENTA_ORDEN" name="NO_CUENTA_ORDEN" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label>Motivo *</label>
                        <textarea class="form-control" id="OBSERVACIONES_SALIDA" name="OBSERVACIONES_SALIDA" rows="3" required></textarea>
                    </div>
                    <div class="col-12 mt-3" id="DIV_FIRMAR" style="display:block; margin-top:10px;">
                        <div class="row justify-content-center">
                            <div class="col-6 text-center">
                                <button type="button"
                                    id="FIRMAR_SOLICITUD"
                                    class="btn btn-info"
                                    data-usuario="{{ Auth::user()->EMPLEADO_NOMBRE }} {{ Auth::user()->EMPLEADO_APELLIDOPATERNO }} {{ Auth::user()->EMPLEADO_APELLIDOMATERNO }}">
                                    <i class="bi bi-pen-fill"></i> Firmar salida
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="form-label">Firmado por</label>
                        <input type="text" id="FIRMADO_POR" name="FIRMADO_POR" class="form-control" readonly required>
                    </div>

                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarsalidamtto" style="display: block;">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>






<div class="modal fade" id="modalDiasTomados" tabindex="-1" aria-labelledby="modalDiasTomadosLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDiasTomadosLabel">Días ya tomados</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <label for="inputDiasTomados" class="form-label">Ingrese cuántos días ha tomado anteriormente:</label>
                <input type="number" id="inputDiasTomados" class="form-control" placeholder="Ejemplo: 6" min="0" step="1">
                <div id="mensajeErrorDias" class="text-danger mt-2" style="display:none;">
                    No puede superar los días que corresponden.
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnGuardarDiasTomados" disabled>Aceptar</button>
            </div>
        </div>
    </div>
</div>



<script>
    window.tipoinventario = @json($tipoinventario);
    window.inventariomantenimiento = @json($inventariomantenimiento);
</script>


@endsection