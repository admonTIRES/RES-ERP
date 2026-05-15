@extends('principal.maestracompras')

@section('contenido')

<style>
    .tabla-scroll-wrapper {
        width: 100%;
    }

    .tabla-scroll-top {
        overflow-x: auto;
        height: 20px;
        background: #f8f9fa;
    }

    .tabla-scroll-top .scroll-inner {
        height: 1px;
        background: transparent;
    }

    .tabla-scroll-bottom {
        overflow-x: auto;
        margin-top: 5px;
    }


    /* ========== TABLA BITÁCORA GENERAL ========== */
    #Tablabitacoragr {
        table-layout: fixed !important;
        width: 100% !important;
    }

    #Tablabitacoragr th,
    #Tablabitacoragr td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        /* text-align: center; */
        vertical-align: middle;
    }

    /* ========== EXCEPCIÓN: COLUMNA JUSTIFICACIÓN ========== */
    #Tablabitacoragr td.col-justificacion {
        white-space: normal !important;
        overflow: visible !important;
        text-overflow: unset !important;
        word-wrap: break-word !important;
        vertical-align: middle !important;
        height: auto !important;
        line-height: 1.3em;
    }


    table.dataTable td {
        white-space: normal !important;
        word-wrap: break-word;
    }


    .bg-amarillo-suave {
        background-color: #fff3cd !important;
    }

    .bg-verde-suave {
        background-color: #d4edda !important;
    }


    .color-vo {
        transition: background-color 0.3s ease;
    }


    .bloquear-interaccion {
        position: relative;
    }

    .bloquear-interaccion::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 10;
        background: transparent;
        pointer-events: all;
    }


    .col-bien-servicio {
        white-space: normal !important;
        word-wrap: break-word;
    }


    .select-finalizada {
        background-color: #d4edda !important;
        color: #155724 !important;
        font-weight: bold;
    }

    .select-en-proceso {
        background-color: #fff3cd !important;
        color: #856404 !important;
        font-weight: bold;
    }

    .select-sin-datos {
        background-color: #f8d7da !important;
        color: #721c24 !important;
        font-weight: bold;
    }
</style>

<div class="contenedor-contenido">

    <ol class="breadcrumb mb-5" style="display: flex; justify-content: center; align-items: center;">
        <h3 style="color: #ffffff; margin: 0;">&nbsp; Bitácora de Recepción de bienes y/o servicios - GR - Actual</h3>
    </ol>


    <div class="card-body">




        <div class="tabla-scroll-wrapper">
            <div class="tabla-scroll-top">
                <div class="scroll-inner"></div>
            </div>
            <div class="tabla-scroll-bottom">
                <div class="table-responsive">
                    <table id="Tablabitacoragr" class="table table-hover table-bordered  w-100" style="min-width: 1000px; table-layout: fixed;">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">No.MR</th>
                                <th class="text-center">Fecha de aprobación.MR</th>
                                <th class="text-center">No.PO</th>
                                <th class="text-center">Fecha de aprobación.PO</th>
                                <th class="text-center">Proveedor</th>
                                <th class="text-center">Fecha de entrega.PO</th>
                                <th class="text-center">Bien o servicio</th>
                                <th class="text-center">GR</th>
                                <th class="text-center">Fecha de emisión .GR</th>
                                <th class="text-center">No.GR</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>



    </div>

</div>




<div class="modal fade" id="modalGR" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formulariorecepciongr" style="background-color: #ffffff;">
                <div class="modal-header bg-white text-dark">
                    <h5 class="modal-title">Detalle de GR</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div id="modal-body-base">

                        <input type="hidden" id="ID_GR" name="ID_GR" value="0">
                        <input type="hidden" id="GENEROGR_ID" name="GENEROGR_ID" value="0">

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">No. MR</label>
                                <input type="text" class="form-control" id="modal_no_mr" name="modal_no_mr" readonly>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Fecha aprobación MR</label>
                                <input type="text" class="form-control" id="modal_fecha_mr" name="modal_fecha_mr" readonly>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">No. PO</label>
                                <input type="text" class="form-control" id="modal_no_po" name="modal_no_po" readonly>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Fecha aprobación PO</label>
                                <input type="text" class="form-control" id="modal_fecha_po" name="modal_fecha_po" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Proveedor</label>
                                <select class="form-select text-center" id="PROVEEDOR_EQUIPO" name="PROVEEDOR_EQUIPO">
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

                                    <optgroup label="Extra">
                                        <option value="Nota de remisión">Nota de remisión</option>
                                    </optgroup>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Fecha entrega PO</label>
                                <input type="text" class="form-control" id="modal_fecha_entrega" name="modal_fecha_entrega" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">No. recepción de orden - GR</label>
                                <input type="text" class="form-control" id="NO_RECEPCION" name="NO_RECEPCION">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Fecha de emisión</label>
                                <div class="input-group">
                                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="DESDE_ACREDITACION" name="DESDE_ACREDITACION" required>
                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Fecha de entrega GR</label>
                                <div class="input-group">
                                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_ENTREGA_GR" name="FECHA_ENTREGA_GR" required>
                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">La GR es parcial </label>
                                <select class="form-control" id="GR_PARCIAL" name="GR_PARCIAL" required>
                                    <option value="" selected>Seleccione una opción</option>
                                    <option value="Sí">Sí</option>
                                    <option value="No">No</option>
                                </select>

                            </div>
                        </div>
                        <hr>
                        <h5 class="mb-3 text-center">Bienes o Servicios (B o S)</h5>
                        <div id="modal_bien_servicio"></div>
                        <hr>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Usuario que solicito</label>
                                <input type="text" class="form-control" id="modal_usuario_nombre" name="modal_usuario_nombre" readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Mandar a Vo.Bo de usuario</label>
                                <select class="form-control" id="MANDAR_USUARIO_VOBO" name="MANDAR_USUARIO_VOBO">
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="Sí">Sí</option>
                                    <option value="No">No</option>
                                </select>
                            </div>

                        </div>

                        <div class="row mb-3" id="VISTOBOUSUARIO" style="display: none;">

                            <div class="col-md-6">
                                <label class="form-label">Fecha Vo.Bo usuario</label>
                                <div class="input-group">
                                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_VOUSUARIO" name="FECHA_VOUSUARIO">
                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Estado de Vo.Bo </label>
                                <div id="estado-container" class="p-2 rounded">
                                    <select class="form-control" id="VO_BO_USUARIO" name="VO_BO_USUARIO">
                                        <option value="" selected disabled>Seleccione una opción</option>
                                        <option value="Aprobada">Aprobada</option>
                                        <option value="Rechazada">Rechazada</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label class="form-label">Finalizar GR </label>
                                <select class="form-control" id="FINALIZAR_GR" name="FINALIZAR_GR">
                                    <option value="" selected>Seleccione una opción</option>
                                    <option value="Sí">Sí</option>
                                    <option value="No">No</option>
                                </select>

                            </div>
                        </div>
                    </div>


                    <div id="modal-body-parciales" style="display:none;"></div>




                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" id="EnviarGR">Enviar GR</button>
                    <button type="button" class="btn btn-info" id="DescargarGR">Descarga GR</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" id="btnGuardarGR">Guardar</button>
                </div>

            </form>
        </div>
    </div>
</div>





<script>
    window.tipoinventario = @json($tipoinventario);
    window.inventario = @json($inventario);
    window.proveedoresOficiales = @json($proveedoresOficiales);
    window.proveedoresTemporales = @json($proveedoresTemporales);
</script>














@endsection