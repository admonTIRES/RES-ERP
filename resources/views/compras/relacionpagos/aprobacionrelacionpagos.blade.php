@extends('principal.maestracompras')

@section('contenido')


<style>
    .tabla-relacion-pagos thead th {
        background: #e8f1ed;
        color: #1d1d1d;
        font-weight: 700;
        vertical-align: middle;
        white-space: nowrap;
        font-size: 14px;
        border: 1px solid #d7d7d7;
    }

    .tabla-relacion-pagos tbody td {
        vertical-align: middle;
        font-size: 14px;
        border: 1px solid #e1e1e1;
        white-space: nowrap;
    }

    .tabla-relacion-pagos tbody tr:hover {
        background: #f7fbf9;
    }

    .card-pagos {
        border: 1px solid #dfe7e3;
        border-radius: 12px;
        /* overflow: hidden; */
        margin-bottom: 20px;
        background: #fff;
    }

    .card-pagos-header {
        background: #f6faf8;
        padding: 12px 15px;
        border-bottom: 1px solid #e2ebe7;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .titulo-pagos {
        font-size: 15px;
        font-weight: 700;
        color: #1f1f1f;
    }

    .contenedor-tabla-pagos {
        overflow: auto;
    }

    .btn-agregar-pago {
        border-radius: 10px;
        font-weight: 600;
        padding: 7px 14px;
    }

    .fila-pago-manual {
        background: #fffdf5;
    }

    .input-pago {
        width: 100%;
        min-width: unset;
    }

    .tabla-relacion-pagos {
        width: 100%;
    }

    .tabla-relacion-pagos td,
    .tabla-relacion-pagos th {
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .tabla-relacion-pagos thead th {
        background: #e8f1ed;
        color: #1d1d1d;
        font-weight: 700;
        font-size: 16px;
        padding: 18px 12px;
        vertical-align: middle;
        white-space: nowrap;
        border: 1px solid #d7d7d7;
    }

    .tabla-relacion-pagos tbody td {
        font-size: 15px;
        padding: 14px 10px;
        vertical-align: middle;
        border: 1px solid #e1e1e1;
        white-space: nowrap;
    }

    .tabla-relacion-pagos tbody tr {
        height: 65px;
    }

    .tabla-relacion-pagos thead tr {
        height: 70px;
    }

    .tabla-relacion-pagos {
        border-radius: 12px;
        overflow: hidden;
    }
</style>
<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5" style="display: flex; justify-content: center; align-items: center;">
        <h3 style="color: #ffffff; margin: 0;">
            <i class="bi bi-cash-stack"></i>&nbsp;&nbsp;Aprobar relación de pagos
        </h3>

    </ol>

    <div class="card-body">
        <table id="Tablarelacionespagoaprobar" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
        </table>
    </div>
</div>




<div class="modal fade" id="modalRelacionPagos" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioRELACION" style="background-color: #ffffff;">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-box-seam"></i> Relación de pagos
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    {!! csrf_field() !!}

                    <input type="hidden" id="JSON_RELACIONES" name="JSON_RELACIONES">


                    <div class="card-pagos">
                        <div class="card-pagos-header">
                            <div class="titulo-pagos">
                                <label>Fecha de la relación *</label>
                                <div class="input-group">
                                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_RELACION" name="FECHA_RELACION" required style="pointer-events:none; background-color:#e9ecef;" required tabindex="-1">
                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="contenedor-tabla-pagos">
                            <table class="table table-bordered align-middle mb-0 tabla-relacion-pagos"
                                id="tablaRelacionPagos">
                                <thead>
                                    <tr>
                                        <th style="min-width:120px;" class="text-center">Acciones</th>
                                        <th style="min-width:70px;" class="text-center"></th>
                                        <th style="min-width:180px;" class="text-center">Fecha de factura</th>
                                        <th style="min-width:350px;" class="text-center">No. Factura o Folio Fiscal</th>
                                        <th style="min-width:300px;" class="text-center">Razón Social</th>
                                        <th style="min-width:180px;" class="text-center">RFC</th>
                                        <th style="min-width:140px;" class="text-center">Subtotal</th>
                                        <th style="min-width:140px;" class="text-center">IVA</th>
                                        <th style="min-width:140px;" class="text-center">Total</th>
                                        <th style="min-width:50px;" class="text-center">Moneda</th>
                                        <th style="min-width:180px;" class="text-center">Fecha de Recepción </th>
                                        <th style="min-width:50px;" class="text-center">Días Crédito</th>
                                        <th style="min-width:180px;" class="text-center">Banco</th>
                                        <th style="min-width:250px;" class="text-center">No. Cuenta Bancaria</th>
                                        <th style="min-width:250px;" class="text-center">Observaciones</th>

                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-4 mx-auto  text-center">
                            <div class="form-group ">
                                <label>Total MXN</label>
                                <input type="text" class="form-control floating-input text-center" id="MONTO_MXN" name="MONTO_MXN" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4 mx-auto  text-center">
                            <div class="form-group ">
                                <label>Total USD</label>
                                <input type="text" class="form-control floating-input text-center" id="MONTO_USD" name="MONTO_USD" readonly>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="FIRMO_USUARIO" name="FIRMO_USUARIO" value="">

                    <div class="mt-3">
                        <label class="form-label">Firmado por</label>
                        <input type="text" id="FIRMADO_POR" name="FIRMADO_POR" class="form-control" readonly required>
                    </div>

                    <div class="aprobacion-direccion-hoja mt-5" id="APROBACION_HOJA" style="display: block;">
                        <div class="bloque-aprobacion">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Estado de Aprobación</label>
                                    <select class="form-control" id="ESTADO_APROBACION" name="ESTADO_APROBACION" required>
                                        <option value="" disabled>Seleccione una opción</option>
                                        <option value="Aprobada">Aprobada</option>
                                        <option value="Rechazada">Rechazada</option>
                                    </select>

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Fecha de aprobación *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker fecha-aprobacion" placeholder="aaaa-mm-dd" name="FECHA_APROBACION" id="FECHA_APROBACION" style="pointer-events:none; background-color:#e9ecef;" required tabindex="-1">
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 " id="motivo-rechazo" style="display: none;">
                                <label class="form-label fw-bold">Motivo del rechazo</label>
                                <textarea class="form-control motivo-rechazo" name="MOTIVO_RECHAZO" id="MOTIVO_RECHAZO" rows="3" placeholder="Escriba el motivo de rechazo..." required></textarea>
                            </div>
                        </div>


                        <div class="col-12 mt-5" id="DIV_FIRMAR" style="display:block; margin-top:10px;">
                            <div class="row justify-content-center">
                                <div class="col-6 text-center">
                                    <button type="button" id="FIRMAR_RELACION" class="btn btn-info"
                                        data-usuario="{{ Auth::user()->EMPLEADO_NOMBRE }} {{ Auth::user()->EMPLEADO_APELLIDOPATERNO }} {{ Auth::user()->EMPLEADO_APELLIDOMATERNO }}">
                                        <i class="bi bi-pen-fill"></i> Firmar
                                    </button>
                                </div>
                            </div>
                        </div>


                        <input type="hidden" id="FIRMO_APROBACION" name="FIRMO_APROBACION" value="">



                        <div class="col-12  mt-4">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label>Aprobado por:</label>
                                    <input type="text" class="form-control" id="APROBADO_POR" name="APROBADO_POR" required readonly>
                                </div>
                            </div>
                        </div>
                    </div>




                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarRELACION">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>




@endsection