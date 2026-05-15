@extends('principal.maestraventas')

@section('contenido')



<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5" style="display: flex; justify-content: center; align-items: center;">
        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-patch-check-fill"></i>&nbsp;Confirmación del servicio - Historial</h3>
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
        <table id="Tablaconfirmacionhistorial" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
        </table>
    </div>
</div>










<div class="modal modal-fullscreen fade" id="miModal_CONFIRMACION" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioCONFIRMACION" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h5 class="modal-title" id="miModalLabel">Confirmación del servicio </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="row">


                        <div class="mb-3">
                            <label>N° de Ofertas/Cotizaciones</label>
                            <select class="custom-select form-control" id="OFERTA_ID" name="OFERTA_ID">
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

                                <div class="col-6">
                                    <label>Forma de aceptación *</label>
                                    <select class="form-control" id="ACEPTACION_CONFIRMACION" name="ACEPTACION_CONFIRMACION" required>
                                        <option value="" disabled selected>Seleccione una opción</option>
                                        <option value="1">Firma</option>
                                        <option value="2">OC/OS</option>
                                        <option value="3">Contrato</option>
                                    </select>
                                </div>


                                <div class="col-6">
                                    <label>Fecha de aceptación *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_CONFIRMACION" name="FECHA_CONFIRMACION" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>

                                <div class="col-6 mt-3">
                                    <label class="form-label">Quién acepta *</label>
                                    <input type="text" class="form-control" name="QUIEN_ACEPTA" id="QUIEN_ACEPTA" required>
                                </div>
                                <div class="col-6 mt-3">
                                    <label class="form-label">Cargo *</label>
                                    <input type="text" class="form-control" name="CARGO_ACEPTACION" id="CARGO_ACEPTACION" required>
                                </div>

                            </div>
                        </div>


                        <div class="col-12 mt-3">
                            <div class="row">
                                <div class="col-4">
                                    <label>No. OC/OS/Contrato </label>
                                    <input type="text" class="form-control" id="NO_CONFIRMACION" name="NO_CONFIRMACION">
                                </div>

                                <div class="col-4">
                                    <label>Fecha de emisión *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_EMISION" name="FECHA_EMISION" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>

                            </div>
                        </div>



                        <div class="row">
                            <div class="mb-3 mt-3">
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label>Agregar evidencia</label>
                                        <button id="botonagregarevidencia" type="button" class="btn btn-danger ml-2 rounded-pill" title="Agregar">
                                            <i class="bi bi-plus-circle-fill"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="verifiacionesdiv mt-4"></div>
                            </div>

                        </div>




                        <div class="d-flex align-items-center mt-3">
                            <h5 class="me-2">Validar información</h5>
                            <button id="btnVerificacion" type="button" class="btn btn-info btn-custom rounded-pill" disabled style="display: block;" disabled>
                                <i class="bi bi-check"></i>
                            </button>
                        </div>
                        <input type="hidden" id="ESTADO_VERIFICACION" name="ESTADO_VERIFICACION" value="0">



                        <div id="VERIFICACION_CLIENTE" style="display: none;">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Quién valida *</label>
                                        <input type="text" class="form-control"
                                            id="QUIEN_VALIDA"
                                            name="QUIEN_VALIDA"
                                            readonly
                                            data-usuario="{{ Auth::user()->EMPLEADO_NOMBRE }} {{ Auth::user()->EMPLEADO_APELLIDOPATERNO }} {{ Auth::user()->EMPLEADO_APELLIDOMATERNO }}">
                                    </div>


                                    <div class="col-md-6 mt-2">
                                        <label>Fecha de Validación *</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_VALIDACION" name="FECHA_VALIDACION">
                                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Comentario *</label>
                                        <textarea class="form-control" name="COMENTARIO_VALIDACION" id="COMENTARIO_VALIDACION" rows="1"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="d-flex align-items-center justify-content-center-mb-2">
                                    <h5 class="mb-0"><b>Verificación de Información</b></h5> &nbsp;
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-success" onclick="seleccionarTodos('Sí')">Marcar todos Sí</button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="seleccionarTodos('No')">Marcar todos No</button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 mt-3">
                                        <div class="row">
                                            @foreach($verificaciones as $verificacion)
                                            @php
                                            $inputId = 'motivo_' . $verificacion->ID_CATALOGO_VERIFICACION_CLIENTE;
                                            $radioName = 'verificacion_' . $verificacion->ID_CATALOGO_VERIFICACION_CLIENTE;
                                            @endphp
                                            <div class="col-12 d-flex align-items-center mb-1 flex-wrap">
                                                <div style="min-width: 250px;">
                                                    <label class="form-label mb-0">{{ $verificacion->NOMBRE_VERIFICACION }}</label>
                                                </div>
                                                <div class="d-flex align-items-center gap-3 flex-wrap" style="flex: 1;">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="{{ $radioName }}" value="Na" onclick="toggleInput('{{ $inputId }}', false)">
                                                        <label class="form-check-label">N/A</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="{{ $radioName }}" value="Sí" onclick="toggleInput('{{ $inputId }}', false)">
                                                        <label class="form-check-label">Sí</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="{{ $radioName }}" value="No" onclick="toggleInput('{{ $inputId }}', true)">
                                                        <label class="form-check-label">No</label>
                                                    </div>
                                                    <input type="text" id="{{ $inputId }}" class="form-control d-none" style="max-width: 970px;" placeholder="Motivo">
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>



                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-12 mb-3 text-center">
                                    <h5 class="form-label"><b>Se procede a generar la orden de trabajo </b></h5>
                                    <br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="PROCEDE_ORDEN" id="procedeno" value="0">
                                        <label class="form-check-label" for="procedeno">No</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="PROCEDE_ORDEN" id="procedesi" value="1">
                                        <label class="form-check-label" for="procedesi">Sí</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer mx-5">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarCONFIRMACION">
                        <i class="bi bi-floppy-fill" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Confirmación del servicio "></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>










@endsection