@extends('principal.maestracompras')

@section('contenido')

<div class="contenedor-contenido">
    <ol class="breadcrumb mt-2" style="display: flex; justify-content: center; align-items: center;">
        <h3 style="color: #ffffff; margin: 0;">
            <i class="bi bi-file-earmark-fill"></i>&nbsp;&nbsp;Lista de facturas
        </h3>

    </ol>

    <div class="card-body">
        <table id="Tablalistafacturasproveedores" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
        </table>
    </div>
</div>




<!-- ============================================================== -->
<!-- MODAL FACTURA PROVEEDOR  -->
<!-- ============================================================== -->

<div class="modal fade" id="modalDetalleFactura" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form method="post" enctype="multipart/form-data" id="formularioFACTURA" style="background-color: #ffffff;">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalle de factura</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    {!! csrf_field() !!}

                    <h5>Datos de factura</h5>


                    <input type="hidden" id="ID_FORMULARIO_FACTURACION" name="ID_FORMULARIO_FACTURACION" value="">

                    <div class="mb-4 d-none" id="contenedorCONTRATO">
                        <div class="row">
                            <div class="col-12">
                                <label class="form-label fw-bold">No. de contrato *</label>
                                <input type="text" class="form-control" id="NO_CONTRATO" name="NO_CONTRATO" required>
                            </div>
                        </div>
                    </div>

                    


                    <div class="mb-4 d-none" id="contenedorOC">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label fw-bold">No. Orden de Compra (PO) *</label>
                                <input type="text" class="form-control" id="NO_PO" name="NO_PO" placeholder="Ej. RES-POXX-000 o RES-POXX-000-RevX" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold">No. Recepción (GR) *</label>
                                <input type="text" class="form-control" id="NO_GR" name="NO_GR" placeholder="Ej. RES-GRXX-000" required>
                            </div>
                        </div>
                    </div>




                    <div class="row d-none" id="camposFactura">
                        <div class="col-md-4 mb-3">
                            <label>Folio fiscal</label>
                            <input type="text" id="FOLIO_FISCAL" name="FOLIO_FISCAL" class="form-control" required readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Fecha de la factura *</label>
                            <div class="input-group">
                                <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_FACTURA" name="FECHA_FACTURA" required>
                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Método Pago</label>
                            <input type="text" id="METODO_PAGO" name="METODO_PAGO" class="form-control" required readonly>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Moneda</label>
                            <input type="text" id="MONEDA_FACTURA" name="MONEDA_FACTURA" class="form-control" required readonly>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Subtotal</label>
                            <input type="text" id="SUBTOTAL_FACTURA" name="SUBTOTAL_FACTURA" class="form-control" required readonly>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>IVA</label>
                            <input type="text" id="IVA_FACTURA" name="IVA_FACTURA" class="form-control" required readonly>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Total</label>
                            <input type="text" id="TOTAL_FACTURA" name="TOTAL_FACTURA" class="form-control" required readonly>
                        </div>
                    </div>

                    <div class="row d-none" id="camposFacturaExtranjero">
                        <div class="col-md-4 mb-3">
                            <label>No. Factura</label>
                            <input type="text" id="NO_FACTURA_EXTRANJERO" name="NO_FACTURA_EXTRANJERO" class="form-control" required readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Fecha de la factura *</label>
                            <div class="input-group">
                                <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_FACTURA_EXTRANJERO" name="FECHA_FACTURA_EXTRANJERO" required>
                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Moneda</label>
                            <input type="text" id="MONEDA_FACTURA_EXTRANJERO" name="MONEDA_FACTURA_EXTRANJERO" class="form-control" required readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Subtotal</label>
                            <input type="text" id="SUBTOTAL_FACTURA_EXTRANJERO" name="SUBTOTAL_FACTURA_EXTRANJERO" class="form-control" required readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>IVA</label>
                            <input type="text" id="IVA_FACTURA_EXTRANJERO" name="IVA_FACTURA_EXTRANJERO" class="form-control" required readonly readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Total</label>
                            <input type="text" id="TOTAL_FACTURA_EXTRANJERO" name="TOTAL_FACTURA_EXTRANJERO" class="form-control" required readonly>
                        </div>
                    </div>

                    <hr>
                    <h6>Archivos</h6>

                    <a id="verFacturaPDF" target="_blank" class="btn btn-danger">Factura PDF</a>
                    <a id="verSoportePDF" target="_blank" class="btn btn-danger">Soporte</a>
                    <a id="verXML" target="_blank" class="btn btn-secondary d-none">XML</a>


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <!-- <button type="submit" class="btn btn-success" id="btnGuardarFactura">Guardar</button> -->
                </div>
            </div>
        </form>
    </div>
</div>

@endsection