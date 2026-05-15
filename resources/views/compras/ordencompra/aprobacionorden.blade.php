@extends('principal.maestracompras')

@section('contenido')

<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5" style="display: flex; justify-content: center; align-items: center;">
        <h3 style="color: #ffffff; margin: 0;">&nbsp;Orden de compra por aprobar</h3>

    </ol>

    <div class="card-body">
        <table id="Tablaordencompraprobacion" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
        </table>
    </div>
</div>





<div class="modal modal-fullscreen fade" id="miModal_PO" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioPO" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="miModalLabel">Orden de compra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="row">

                        <div class="col-12">
                            <div class="row">

                                <div class="col-4 mb-3">
                                    <label>N° PO </label>
                                    <input type="text" class="form-control" id="NO_PO" name="NO_PO">
                                </div>
                                <div class="col-4 mb-3">
                                    <label>N° MR</label>
                                    <input type="text" class="form-control" id="NO_MR" name="NO_MR" readonly>
                                </div>
                                <div class="col-4 mb-3">
                                    <label>Fecha de emisión *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_EMISION" name="FECHA_EMISION" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>

                                <div class="col-6 mb-3">
                                    <label>Proveedor seleccionado</label>
                                    <select class="form-select proveedor-cotizacionq3 text-center" name="PROVEEDOR_SELECCIONADO" id="PROVEEDOR_SELECCIONADO">
                                        <option value="">Seleccionar proveedor</option>
                                        <optgroup label="Proveedor oficial">
                                            @foreach ($proveedoresOficiales as $proveedor)
                                            <option value="{{ $proveedor->RFC_ALTA }}">
                                                {{ $proveedor->RAZON_SOCIAL_ALTA }} ({{ $proveedor->RFC_ALTA }})
                                            </option>
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="Proveedores temporales">
                                            @foreach ($proveedoresTemporales as $proveedor)
                                            <option value="{{ $proveedor->RAZON_PROVEEDORTEMP }}">
                                                {{ $proveedor->RAZON_PROVEEDORTEMP }} ({{ $proveedor->NOMBRE_PROVEEDORTEMP }})
                                            </option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                </div>

                                <div class="col-6 mb-3">
                                    <label>Fecha de entrega *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_ENTREGA" name="FECHA_ENTREGA" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>


                            </div>

                        </div>


                        <div class="mt-3">
                            <div class="row">
                                <div class="col-6 mb-3">

                                </div>
                            </div>
                            <div class="materialesdiv mt-4"></div>
                        </div>




                        <div class="row mt-3">
                            <div class="col-md-4 mt-2">
                                <label>Subtotal</label>
                                <input type="text" readonly class="form-control text-end" id="SUBTOTAL" name="SUBTOTAL" value="0">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label d-flex align-items-center">
                                    IVA:
                                    <div class="ms-2 d-inline-flex align-items-center gap-2">
                                        <div class="form-check form-check-inline mb-0">
                                            <input class="form-check-input" type="radio" name="PORCENTAJE_IVA" id="iva0" value="0">
                                            <label for="iva0">0%</label>
                                        </div>

                                        <div class="form-check form-check-inline mb-0">
                                            <input class="form-check-input" type="radio" name="PORCENTAJE_IVA" id="iva8" value="0.08">
                                            <label for="iva8">8%</label>
                                        </div>
                                        <div class="form-check form-check-inline mb-0">
                                            <input class="form-check-input" type="radio" name="PORCENTAJE_IVA" id="iva16" value="0.16">
                                            <label for="iva16">16%</label>
                                        </div>
                                    </div>
                                </label>

                                <input type="text" class="form-control text-end mt-1" id="IVA" name="IVA" readonly>
                            </div>


                            <div class="col-md-4 mt-2">
                                <label>Importe Total</label>
                                <input type="text" readonly class="form-control text-end" id="IMPORTE" name="IMPORTE">
                            </div>
                        </div>



                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card border-info">
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Solicitar verificación -->
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label fw-bold">¿Solicitar aprobación?</label>
                                                <select class="form-select solicitar-verificacion" name="SOLICITAR_AUTORIZACION" id="SOLICITAR_AUTORIZACION">
                                                    <option value="">Seleccione una opción</option>
                                                    <option value="Sí">Sí</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label fw-bold">Fecha de solicitud *</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control mydatepicker fecha-aprobacion" placeholder="aaaa-mm-dd" name="FECHA_SOLCITIUD" id="FECHA_SOLCITIUD">
                                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                                </div>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label fw-bold">Requiere algún comentario</label>
                                                <select class="form-select solicitar-verificacion" name="REQUIERE_COMENTARIO" id="REQUIERE_COMENTARIO">
                                                    <option value="">Seleccione una opción</option>
                                                    <option value="Sí">Sí</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-12 mt-3" style="display: none;" id="COMENTARIO_SOLICITUD_PO">
                            <label class="form-label fw-bold">Comentario</label>
                            <textarea class="form-control comentario-aprobacion" name="COMENTARIO_SOLICITUD" id="COMENTARIO_SOLICITUD"></textarea>
                        </div>



                        <div class="col-12  mt-4">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label>Solicitado por:</label>
                                    <input type="text" class="form-control" id="SOLICITADO_POR" name="SOLICITADO_POR" readonly>
                                </div>
                            </div>
                        </div>




                        <div class="aprobacion-direccion-hoja mt-5" id="APROBACION_HOJA" style="display: block;">


                            <div class="bloque-aprobacion">
                                <div class="row">
                                    <!-- Estado de Aprobación -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Estado de Aprobación</label>
                                        <select class="form-control estado-aprobacion" name="ESTADO_APROBACION" id="ESTADO_APROBACION" required>
                                            <option value="" disabled>Seleccione una opción</option>
                                            <option value="Aprobada">Aprobada</option>
                                            <option value="Rechazada">Rechazada</option>
                                        </select>

                                    </div>

                                    <!-- Fecha de Aprobación -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Fecha de aprobación *</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control mydatepicker fecha-aprobacion" placeholder="aaaa-mm-dd" name="FECHA_APROBACION" id="FECHA_APROBACION" required>
                                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Motivo de Rechazo -->
                                <div class="mt-3 " id="motivo-rechazoa" style="display: none;">
                                    <label class="form-label fw-bold">Motivo del rechazo</label>
                                    <textarea class="form-control motivo-rechazo" name="MOTIVO_RECHAZO" id="MOTIVO_RECHAZO" rows="3" placeholder="Escriba el motivo de rechazo..."></textarea>
                                </div>
                            </div>


                            <div class="col-12  mt-4">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label>Aprobado por:</label>
                                        <input type="text" value="{{ Auth::user()->EMPLEADO_NOMBRE }} {{ Auth::user()->EMPLEADO_APELLIDOPATERNO }} {{ Auth::user()->EMPLEADO_APELLIDOMATERNO }}" class="form-control" id="APROBADO_POR" name="APROBADO_POR" readonly>
                                    </div>
                                </div>
                            </div>


                        </div>




                    </div>

                </div>

                <div class="modal-footer mx-5">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarPO">Guardar</button>


                </div>
            </form>
        </div>
    </div>
</div>



@endsection