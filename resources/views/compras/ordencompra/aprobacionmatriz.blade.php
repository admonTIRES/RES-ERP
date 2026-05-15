@extends('principal.maestracompras')

@section('contenido')



<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5" style="display: flex; justify-content: center; align-items: center;">
        <h3 style="color: #ffffff; margin: 0;">&nbsp;Matriz comparativa por aprobar</h3>

    </ol>
    <div class="card-body">
        <table id="Tablamatirzaprobada" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
        </table>
    </div>

</div>


<div class="modal modal-fullscreen fade" id="miModal_MATRIZ" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioMATRIZ" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="miModalLabel">Matriz comparativa de cotizaciones</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="row">

                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label">N° MR</label>
                                    <input type="text" class="form-control" id="NO_MR" name="NO_MR" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered text-center" id="tabla-proveedores-matriz">
                        <thead>
                            <tr class="table-dark">
                                <th colspan="2"></th>
                                <th colspan="2">Proveedor No. 1</th>
                                <th colspan="2">Proveedor No. 2</th>
                                <th colspan="2">Proveedor No. 3</th>
                            </tr>
                            <tr class="table-secondary">
                                <th colspan="2"></th>
                                <th colspan="2" id="head-prov1" class="d-none">
                                    <select class="form-select text-center" name="PROVEEDOR1" id="PROVEEDOR1"></select>
                                </th>
                                <th colspan="2" id="head-prov2" class="d-none">
                                    <select class="form-select text-center" name="PROVEEDOR2" id="PROVEEDOR2"></select>
                                </th>
                                <th colspan="2" id="head-prov3" class="d-none">
                                    <select class="form-select text-center" name="PROVEEDOR3" id="PROVEEDOR3"></select>
                                </th>


                            </tr>
                            <tr class="table-light">
                                <th>Descripción del bien y/o servicio</th>
                                <th>Cantidad</th>
                                <th class="d-none th-pu1">P. Unitario</th>
                                <th class="d-none th-total1">Total</th>
                                <th class="d-none th-pu2">P. Unitario</th>
                                <th class="d-none th-total2">Total</th>
                                <th class="d-none th-pu3">P. Unitario</th>
                                <th class="d-none th-total3">Total</th>
                            </tr>
                        </thead>
                        <tbody id="body-proveedores"></tbody>




                        <tr class="table fila-extra">
                            <th colspan="2">Fecha de cotización</th>
                            <th colspan="2" class="col-prov1">
                                <input type="text" class="form-control mydatepicker fecha-aprobacion" placeholder="aaaa-mm-dd" name="FECHA_COTIZACION_PROVEEDOR1" id="FECHA_COTIZACION_PROVEEDOR1">
                            </th>
                            <th colspan="2" class="col-prov2">
                                <input type="text" class="form-control mydatepicker fecha-aprobacion" placeholder="aaaa-mm-dd" name="FECHA_COTIZACION_PROVEEDOR2" id="FECHA_COTIZACION_PROVEEDOR2">
                            </th>
                            <th colspan="2" class="col-prov3">
                                <input type="text" class="form-control mydatepicker fecha-aprobacion" placeholder="aaaa-mm-dd" name="FECHA_COTIZACION_PROVEEDOR3" id="FECHA_COTIZACION_PROVEEDOR3">
                            </th>
                        </tr>
                        <tr class="table fila-extra">
                            <th colspan="2">Vigencia de cotización (días)</th>
                            <th colspan="2" class="col-prov1">
                                <input type="text" class="form-control" name="VIGENCIA_COTIZACION_PROVEEDOR1" id="VIGENCIA_COTIZACION_PROVEEDOR1">
                            </th>
                            <th colspan="2" class="col-prov2">
                                <input type="text" class="form-control" name="VIGENCIA_COTIZACION_PROVEEDOR2" id="VIGENCIA_COTIZACION_PROVEEDOR2">
                            </th>
                            <th colspan="2" class="col-prov3">
                                <input type="text" class="form-control" name="VIGENCIA_COTIZACION_PROVEEDOR3" id="VIGENCIA_COTIZACION_PROVEEDOR3">
                            </th>
                        </tr>
                        <tr class="table fila-extra">
                            <th colspan="2">Tiempo de entrega</th>
                            <th colspan="2" class="col-prov1">
                                <input type="text" class="form-control" name="TIEMPO_ENTREGA_PROVEEDOR1" id="TIEMPO_ENTREGA_PROVEEDOR1">
                            </th>
                            <th colspan="2" class="col-prov2">
                                <input type="text" class="form-control" name="TIEMPO_ENTREGA_PROVEEDOR2" id="TIEMPO_ENTREGA_PROVEEDOR2">
                            </th>
                            <th colspan="2" class="col-prov3">
                                <input type="text" class="form-control" name="TIEMPO_ENTREGA_PROVEEDOR3" id="TIEMPO_ENTREGA_PROVEEDOR3">
                            </th>
                        </tr>
                        <tr class="table fila-extra">
                            <th colspan="2">Condiciones de pago</th>
                            <th colspan="2" class="col-prov1">
                                <input type="text" class="form-control" name="CONDICIONES_PAGO_PROVEEDOR1" id="CONDICIONES_PAGO_PROVEEDOR1">
                            </th>
                            <th colspan="2" class="col-prov2">
                                <input type="text" class="form-control" name="CONDICIONES_PAGO_PROVEEDOR2" id="CONDICIONES_PAGO_PROVEEDOR2">
                            </th>
                            <th colspan="2" class="col-prov3">
                                <input type="text" class="form-control" name="CONDICIONES_PAGO_PROVEEDOR3" id="CONDICIONES_PAGO_PROVEEDOR3">
                            </th>
                        </tr>
                        <tr class="table fila-extra">
                            <th colspan="2">Condiciones de garantía</th>
                            <th colspan="2" class="col-prov1">
                                <input type="text" class="form-control" name="CONDICIONES_GARANTIA_PROVEEDOR1" id="CONDICIONES_GARANTIA_PROVEEDOR1">
                            </th>
                            <th colspan="2" class="col-prov2">
                                <input type="text" class="form-control" name="CONDICIONES_GARANTIA_PROVEEDOR2" id="CONDICIONES_GARANTIA_PROVEEDOR2">
                            </th>
                            <th colspan="2" class="col-prov3">
                                <input type="text" class="form-control" name="CONDICIONES_GARANTIA_PROVEEDOR3" id="CONDICIONES_GARANTIA_PROVEEDOR3">
                            </th>
                        </tr>
                        <tr class="table fila-extra">
                            <th colspan="2">Servicio postventa</th>
                            <th colspan="2" class="col-prov1">
                                <input type="text" class="form-control" name="SERVICIOPOST_PROVEEDOR1" id="SERVICIOPOST_PROVEEDOR1">
                            </th>
                            <th colspan="2" class="col-prov2">
                                <input type="text" class="form-control" name="SERVICIOPOST_PROVEEDOR2" id="SERVICIOPOST_PROVEEDOR2">
                            </th>
                            <th colspan="2" class="col-prov3">
                                <input type="text" class="form-control" name="SERVICIOPOST_PROVEEDOR3" id="SERVICIOPOST_PROVEEDOR3">
                            </th>
                        </tr>
                        <tr class="table fila-extra">
                            <th colspan="2">Beneficios ofertados por el proveedor</th>
                            <th colspan="2" class="col-prov1">
                                <input type="text" class="form-control" name="BENEFICIOS_PROVEEDOR1" id="BENEFICIOS_PROVEEDOR1">
                            </th>
                            <th colspan="2" class="col-prov2">
                                <input type="text" class="form-control" name="BENEFICIOS_PROVEEDOR2" id="BENEFICIOS_PROVEEDOR2">
                            </th>
                            <th colspan="2" class="col-prov3">
                                <input type="text" class="form-control" name="BENEFICIOS_PROVEEDOR3" id="BENEFICIOS_PROVEEDOR3">
                            </th>
                        </tr>
                        <tr class="table fila-extra">
                            <th colspan="2">Especificaciones adicionales<br>(no técnicas) <br> que fueron requeridas por el bien y/o servicio a adquirir:</th>
                            <th colspan="2" class="col-prov1">
                                <input type="text" class="form-control" name="ESPECIFICACIONES_PROVEEDOR1" id="ESPECIFICACIONES_PROVEEDOR1">
                            </th>
                            <th colspan="2" class="col-prov2">
                                <input type="text" class="form-control" name="ESPECIFICACIONES_PROVEEDOR2" id="ESPECIFICACIONES_PROVEEDOR2">
                            </th>
                            <th colspan="2" class="col-prov3">
                                <input type="text" class="form-control" name="ESPECIFICACIONES_PROVEEDOR3" id="ESPECIFICACIONES_PROVEEDOR3">
                            </th>
                        </tr>
                        <tr class="table fila-extra">
                            <th colspan="2">Certificaciones de calidad (opcional)</th>
                            <th colspan="2" class="col-prov1">
                                <input type="text" class="form-control" name="CERTIFIACION_CALIDAD_PROVEEDOR1" id="CERTIFIACION_CALIDAD_PROVEEDOR1">
                            </th>
                            <th colspan="2" class="col-prov2">
                                <input type="text" class="form-control" name="CERTIFIACION_CALIDAD_PROVEEDOR2" id="CERTIFIACION_CALIDAD_PROVEEDOR2">
                            </th>
                            <th colspan="2" class="col-prov3">
                                <input type="text" class="form-control" name="CERTIFIACION_CALIDAD_PROVEEDOR3" id="CERTIFIACION_CALIDAD_PROVEEDOR3">
                            </th>
                        </tr>



                    </table>






                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card border-info">
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Solicitar verificación -->
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label fw-bold">¿Solicitar aprobación?</label>
                                            <select class="form-select solicitar-verificacion" name="SOLICITAR_VERIFICACION" id="SOLICITAR_VERIFICACION">
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


                    <div class="col-md-12 mt-3" style="display: none;" id="COMENTARIO_SOLICITUD_MATRIZ">
                        <label class="form-label fw-bold">Comentario</label>
                        <textarea class="form-control comentario-aprobacion" name="COMENTARIO_SOLICITUD" id="COMENTARIO_SOLICITUD"></textarea>
                    </div>





                    <div class="aprobacion-direccion-hoja mt-5" id="APROBACION_HOJA" style="display: block;">


                        <div class="bloque-aprobacion">
                            <div class="row">
                                <!-- Estado de Aprobación -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Estado de Aprobación</label>
                                    <select class="form-control estado-aprobacion" name="ESTADO_APROBACION" id="ESTADO_APROBACION" required>
                                        <option value="" selected disabled>Seleccione una opción</option>
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



                        <!-- Sección inicial de PO -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card border-primary">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">¿Requiere PO?</label>
                                            <select class="form-select requiere-po" name="REQUIERE_PO" id="REQUIERE_PO" required>
                                                <option value="">Seleccione una opción</option>
                                                <option value="Sí">Sí</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Sección de selección final -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card border-success">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0 fw-bold">Proveedor seleccionado y detalles de pago</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Criterios de selección</label>
                                                    <select class="form-select forma-pago" name="CRITERIO_SELECCION" id="CRITERIO_SELECCION" required>
                                                        <option value="">Seleccionar forma de pago</option>
                                                        <option value="1">Precio</option>
                                                        <option value="2">Calidad</option>
                                                        <option value="3">Tiempo de entrega</option>
                                                        <option value="4">Servicio postventa</option>
                                                        <option value="5">Condiciones de pago</option>
                                                        <option value="6">Condiciones de garantía</option>
                                                        <option value="7">Proveedor confiable</option>
                                                        <option value="8">Valor agregado</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Proveedor seleccionado:</label>
                                                    <select class="form-select proveedor-seleccionado" name="PROVEEDOR_SELECCIONADO" id="PROVEEDOR_SELECCIONADO">
                                                        <option value="">Seleccionar proveedor sugerido</option>
                                                        <!-- Se llena dinámicamente -->
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Monto final:</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">$</span>
                                                        <input type="number" class="form-control monto-final" name="MONTO_FINAL" id="MONTO_FINAL">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Forma de pago:</label>
                                                    <select class="form-select forma-pago" name="FORMA_PAGO" id="FORMA_PAGO" required>
                                                        <option value="">Seleccionar forma de pago</option>
                                                        <option value="1">Transferencia bancaria (Pago anticipado)</option>
                                                        <option value="5">Efectivo (caja chica)</option>
                                                        <option value="3">Tarjeta de crédito</option>
                                                        <option value="4">Tarjeta de débito</option>
                                                        <option value="6">Crédito otorgado por el proveedor</option>


                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>








                    <div class="modal-footer mx-5">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success" id="guardarMATRIZ">Guardar</button>


                    </div>
                </div>
            </form>
        </div>
    </div>
</div>




<script>
    const proveedoresOficiales = @json($proveedoresOficiales);
    const proveedoresTemporales = @json($proveedoresTemporales);
</script>




@endsection