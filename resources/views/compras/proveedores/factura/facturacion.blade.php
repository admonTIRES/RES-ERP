@extends('principal.maestraproveedores')

@section('contenido')


<style>
    .datepicker {
        z-index: 9999 !important;
    }
</style>

<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5" style="display: flex; justify-content: center; align-items: center;">
        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-file-earmark-fill"></i>&nbsp;Facturación</h3>
        <button type="button" class="btn btn-light waves-effect waves-light" id="NUEVA_FACTURA" style="margin-left: auto;">
            Nueva &nbsp;<i class="bi bi-plus-circle"></i>
        </button>
    </ol>

    <div class="card-body">
        <table id="Tablafacturaproveedores" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
            <i id="loadingIcon1" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
        </table>
    </div>
</div>


<div class="modal fade" id="miModal_factura" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioFACTURA" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="mb-4">
                        <label class="form-label fw-bold">La factura es por *</label>
                        <select class="form-control" id="TIPO_FACTURA" name="TIPO_FACTURA">
                            <option value="">Seleccione una opción</option>
                            <option value="OC">Orden de Compra</option>
                            <option value="CONTRATO">Contrato</option>
                        </select>
                    </div>
                    <div class="mb-4 d-none" id="contenedorCONTRATO">
                        <div class="row">

                            <div class="col-12">
                                <label class="form-label">Seleccionar contrato *</label>
                                <select class="form-control" id="SELECCIONAR_CONTRATO" name="SELECCIONAR_CONTRATO">
                                </select>
                            </div>
                            <div class="col-12 mt-2 text-start">
                                <label class="form-label fw-bold">
                                    No. de contrato *
                                </label>
                                <input type="text" class="form-control" id="NO_CONTRATO" name="NO_CONTRATO" readonly>
                            </div>

                            <div class="text-center mt-2">
                                <button type="button" class="btn btn-primary" id="btnValidarCONTRATO">
                                    Validar contrato
                                </button>
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
                            <div class="text-center mt-2">
                                <button type="button" class="btn btn-primary" id="btnValidarPOGR">
                                    Validar PO / GR
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 d-none" id="soporteFacturaTextoContrato">
                        <p>
                            El soporte de la factura debe incluir en un solo archivo los siguientes documentos:
                        </p>
                        <ul>
                            <li>Verificación de la factura</li>
                            <li>Opinión de cumplimiento en positivo</li>
                            <li>Carta de contenido nacional (Si aplica)</li>
                            <li>Comprobante del pago al IMSS e INFONAVIT (Si aplica)</li>
                            <li>Comprobante del pago SAT (Si aplica)</li>
                        </ul>
                    </div>
                    <div class="mb-3 d-none" id="soporteFacturaTexto">
                        <p>
                            El soporte de la factura debe incluir en un solo archivo los siguientes documentos:
                        </p>
                        <ul>
                            <li>Factura en PDF</li>
                            <li>Verificación de comprobantes fiscales digitales por internet emitida por el SAT</li>
                            <li>Opinión de cumplimiento en positivo</li>
                            <li>Carta de contenido nacional (Si aplica)</li>
                            <li>Comprobante del pago al IMSS e INFONAVIT (Si aplica)</li>
                            <li>Comprobante del pago SAT (Si aplica)</li>
                        </ul>
                    </div>

                    <div class="row d-none" id="datosFactura">
                        <div class="col-md-4 mb-3" id="FACTURA_DIV">
                            <label class="form-label">Factura PDF *</label>
                            <input type="file" class="form-control" name="FACTURA_PDF" id="FACTURA_PDF" accept=".pdf" required>
                        </div>
                        <div class="col-md-4 mb-3" id="XML_DIV">
                            <label class="form-label">Factura XML *</label>
                            <input type="file" class="form-control" name="FACTURA_XML" id="FACTURA_XML" accept=".xml" required>
                        </div>
                        <div class="col-md-4 mb-3" id="SOPORTE_DIV">
                            <label class="form-label">Soporte de la factura PDF *</label>
                            <input type="file" class="form-control" name="DOCUMENTOS_SOPORTE_FACTURA" id="DOCUMENTOS_SOPORTE_FACTURA" accept=".pdf" required>
                        </div>

                    </div>

                    <div class="row d-none" id="camposFactura">
                        <div class="col-md-4 mb-3">
                            <label>Folio fiscal</label>
                            <input type="text" id="FOLIO_FISCAL" name="FOLIO_FISCAL" class="form-control" required readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Fecha de la factura *</label>
                            <input type="date" class="form-control" placeholder="aaaa-mm-dd" id="FECHA_FACTURA" name="FECHA_FACTURA" required readonly>
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
                            <input type="text" id="NO_FACTURA_EXTRANJERO" name="NO_FACTURA_EXTRANJERO" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Fecha de la factura *</label>
                            <input type="date" class="form-control" placeholder="aaaa-mm-dd" id="FECHA_FACTURA_EXTRANJERO" name="FECHA_FACTURA_EXTRANJERO" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Moneda</label>
                            <input type="text" id="MONEDA_FACTURA_EXTRANJERO" name="MONEDA_FACTURA_EXTRANJERO" class="form-control" required readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Subtotal</label>
                            <input type="text" id="SUBTOTAL_FACTURA_EXTRANJERO" name="SUBTOTAL_FACTURA_EXTRANJERO" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>IVA</label>
                            <input type="text" id="IVA_FACTURA_EXTRANJERO" name="IVA_FACTURA_EXTRANJERO" class="form-control" required readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Total</label>
                            <input type="text" id="TOTAL_FACTURA_EXTRANJERO" name="TOTAL_FACTURA_EXTRANJERO" class="form-control" required readonly>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btnGuardarFactura">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>





@endsection