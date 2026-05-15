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


    /* ========== EXCEPCIÓN: COLUMNA JUSTIFICACIÓN ========== */

    #Tablabitacora td.col-justificacion {
        white-space: normal !important;
        overflow: visible !important;
        text-overflow: unset !important;
        word-wrap: break-word !important;
        text-align: center !important;
        vertical-align: middle !important;
        height: auto !important;
        line-height: 1.3em;
    }




    /* ========== TABLA COTIZACIONES (si aplica) ========== */
    #tablaCotizaciones {
        table-layout: fixed !important;
        width: 100% !important;
    }

    #tablaCotizaciones th,
    #tablaCotizaciones td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        text-align: center;
        vertical-align: middle;
    }




    .bg-verde-suave {
        background-color: #d1e7dd !important;
    }

    .bg-rojo-suave {
        background-color: #f8d7da !important;
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
        /* esto bloquea todo */
    }


    /* .input-bloqueado {
        pointer-events: none;
        background-color: #e9ecef;
        cursor: not-allowed;
    } */



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
        <h3 style="color: #ffffff; margin: 0;">&nbsp; Bitácora de consecutivos MR - Actual</h3>
    </ol>


    <div class="card-body">

        <div class="tabla-scroll-wrapper">
            <div class="tabla-scroll-top">
                <div class="scroll-inner"></div>
            </div>
            <div class="tabla-scroll-bottom">
                <div class="table-responsive">
                    <table id="Tablabitacora" class="table table-hover table-bordered  w-100" style="min-width: 1000px; table-layout: fixed;">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th class="text-center">Visualizar</th>
                                <th>Hoja</th>
                                <th>Requisición No.</th>
                                <th>Fecha de Solicitud</th>
                                <th>Solicitante</th>
                                <th class="col-justificacion">Justificación</th>
                                <th>Área Solicitante</th>
                                <th>Fecha de Vo. Bo.</th>
                                <th>Vo. Bo.</th>
                                <th>Fecha Aprobación</th>
                                <th>Aprobación</th>
                                <th>Prioridad</th>
                                <th>Estatus</th>
                                <th>Fecha de Adquisición</th>
                                <th>No.GR</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>






<div class="modal fade" id="modalMateriales" tabindex="-1" aria-labelledby="tituloMateriales" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioBITACORA" style="background-color: #ffffff;">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="tituloMateriales">Hoja de Trabajo - Materiales Aprobados</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="mb-2">
                        <strong>No. MR:</strong> <span id="noMRModal" class="text-primary fw-bold"></span>
                    </div>
                    <input type="hidden" id="inputNoMR" name="NO_MR">


                    <!-- Pregunta inicial -->
                    <div id="preguntaProveedorUnico" class="mb-4 text-center">
                        <h5 class="fw-bold">¿Todos los materiales se comprarán con el mismo proveedor?</h5>
                        <button type="button" class="btn btn-success me-2" id="respuestaProveedorUnicoSi">Sí</button>
                        <button type="button" class="btn btn-secondary" id="respuestaProveedorUnicoNo">No</button>

                    </div>

                    <div id="contenedorProductos"></div>

                    <input type="hidden" name="ES_UNICO" id="esProveedorUnico" value="NO">


                    <template id="templateProducto">
                        <div class="card mb-4 producto-card">
                            <div class="card-header bg-primary text-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="producto-titulo mb-0 fw-bold"></h5>
                                    <div class="d-flex align-items-center detalle-cantidad-unidad">
                                        <div class="border-start ps-3 ms-3">
                                            <div class="d-flex align-items-center">
                                                <span class="fw-medium me-2">Cantidad:</span>
                                                <span class="producto-cantidad fw-bold"></span>
                                            </div>
                                            <div class="d-flex align-items-center mt-1">
                                                <span class="fw-medium me-2">Unidad:</span>
                                                <span class="producto-unidad"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="DESCRIPCION[]" class="descripcion-input">
                            <input type="hidden" name="CANTIDAD[]" class="cantidad-input">
                            <input type="hidden" name="UNIDAD_MEDIDA[]" class="unidad-input">


                            <input type="hidden" class="form-control ID_HOJA" name="id[]">


                            <input type="hidden" class="form-control REQUIERE_MATRIZ" name="REQUIERE_MATRIZ[]">


                            <div class="card-body">
                                <div class="descripcion-materiales mb-3 text-muted small"></div>

                                <h6 class="fw-bold">Cotizaciones</h6>
                                <div class="grupo-producto">

                                    <div class="table-responsive" style="overflow-x: auto;">
                                        <table class="table table-bordered text-center" id="tablaCotizaciones">
                                            <thead class="table-secondary">
                                                <tr>
                                                    <th class="text-center" width="200">Cotización</th>
                                                    <th class="text-center" width="350">Proveedor</th>

                                                    <th class="text-center th-cantidadmr" width="100">Cantidad <br>MR</th>
                                                    <th class="text-center th-cantidadreal" width="100">Cantidad <br>real</th>
                                                    <th class="text-center th-preciounitario" width="150">Precio Unitario</th>

                                                    <th class="text-center" width="200">Subtotal</th>
                                                    <th class="text-center" width="200">IVA</th>
                                                    <th class="text-center" width="200">Importe</th>
                                                    <th class="text-center" width="200">Observaciones</th>
                                                    <th class="text-center" width="300">Fecha cotización</th>
                                                    <th class="text-center" width="500">Documento</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Q1 -->
                                                <tr class="fila-cotizacion" data-cotizacion="Q1">
                                                    <td class="text-center">Q1</td>
                                                    <td class="text-center">
                                                        <select class="form-select proveedor-cotizacionq1 text-center" name="PROVEEDOR_Q1[]">
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
                                                    </td>
                                                    <td class="text-center td-cotizacionq1-cantidadmr">
                                                        <div class="input-group">
                                                            <input type="number" class="form-control cantidadmr-cotizacionq1" name="CANTIDAD_MRQ1[]">
                                                        </div>
                                                    </td>

                                                    <td class="text-center td-cotizacionq1-cantidadreal">
                                                        <div class="input-group">
                                                            <input type="number" class="form-control cantidadreal-cotizacionq1" name="CANTIDAD_REALQ1[]">
                                                        </div>
                                                    </td>

                                                    <td class="text-center td-cotizacionq1-preciounitario">
                                                        <div class="input-group">
                                                            <input type="number" class="form-control preciounitario-cotizacionq1" name="PRECIO_UNITARIOQ1[]">
                                                        </div>
                                                    </td>


                                                    <td class="text-center">
                                                        <div class="input-group">
                                                            <span class="input-group-text">$</span>
                                                            <input type="number" class="form-control importe-cotizacionq1" name="SUBTOTAL_Q1[]">
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="input-group">
                                                            <span class="input-group-text">$</span>
                                                            <input type="number" class="form-control iva-cotizacionq1" name="IVA_Q1[]">
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="input-group">
                                                            <span class="input-group-text">$</span>
                                                            <input type="number" class="form-control total-cotizacionq1" name="IMPORTE_Q1[]" readonly>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <textarea rows="2" class="form-control textareaq1" placeholder="Observaciones..." name="OBSERVACIONES_Q1[]"></textarea>
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="text" class="form-control mydatepicker fecha-cotizacionq1" placeholder="aaaa-mm-dd" name="FECHA_COTIZACION_Q1[]">
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="input-group">
                                                            <input type="file" class="form-control doc-cotizacionq1" accept=".pdf" name="DOCUMENTO_Q1[]">
                                                            <span class="input-group-text"><i class="fas fa-upload"></i></span>
                                                        </div>
                                                    </td>


                                                </tr>

                                                <!-- Q2 -->
                                                <tr class="fila-cotizacion" data-cotizacion="Q2">
                                                    <td class="text-center">Q2</td>
                                                    <td class="text-center">
                                                        <select class="form-select proveedor-cotizacionq2 text-center" name="PROVEEDOR_Q2[]">
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
                                                    </td>
                                                    <td class="text-center  td-cotizacionq2-cantidadmr">
                                                        <div class="input-group">
                                                            <input type="number" class="form-control cantidadmr-cotizacionq2" name="CANTIDAD_MRQ2[]">
                                                        </div>
                                                    </td>

                                                    <td class="text-center td-cotizacionq2-cantidadreal">
                                                        <div class="input-group">
                                                            <input type="number" class="form-control cantidadreal-cotizacionq2" name="CANTIDAD_REALQ2[]">
                                                        </div>
                                                    </td>

                                                    <td class="text-center td-cotizacionq2-preciounitario">
                                                        <div class="input-group">
                                                            <input type="number" class="form-control preciounitario-cotizacionq2" name="PRECIO_UNITARIOQ2[]">
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="input-group">
                                                            <span class="input-group-text">$</span>
                                                            <input type="number" class="form-control importe-cotizacionq2" name="SUBTOTAL_Q2[]">
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="input-group">
                                                            <span class="input-group-text">$</span>
                                                            <input type="number" class="form-control iva-cotizacionq2" name="IVA_Q2[]">
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="input-group">
                                                            <span class="input-group-text">$</span>
                                                            <input type="number" class="form-control total-cotizacionq2" name="IMPORTE_Q2[]" readonly>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <textarea rows="2" class="form-control textareaq2" placeholder="Observaciones..." name="OBSERVACIONES_Q2[]"></textarea>
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="text" class="form-control mydatepicker fecha-cotizacionq2" placeholder="aaaa-mm-dd" name="FECHA_COTIZACION_Q2[]">
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="input-group">
                                                            <input type="file" class="form-control doc-cotizacionq2" name="DOCUMENTO_Q2[]" accept=".pdf">
                                                            <span class="input-group-text"><i class="fas fa-upload"></i></span>
                                                        </div>
                                                    </td>


                                                </tr>

                                                <!-- Q3 -->
                                                <tr class="fila-cotizacion" data-cotizacion="Q3">
                                                    <td class="text-center">Q3</td>
                                                    <td class="text-center">
                                                        <select class="form-select proveedor-cotizacionq3 text-center" name="PROVEEDOR_Q3[]">
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
                                                    </td>

                                                    <td class="text-center td-cotizacionq3-cantidadmr">
                                                        <div class="input-group">
                                                            <input type="number" class="form-control cantidadmr-cotizacionq3" name="CANTIDAD_MRQ3[]">
                                                        </div>
                                                    </td>

                                                    <td class="text-center td-cotizacionq3-cantidadreal">
                                                        <div class="input-group">
                                                            <input type="number" class="form-control cantidadreal-cotizacionq3" name="CANTIDAD_REALQ3[]">
                                                        </div>
                                                    </td>

                                                    <td class="text-center td-cotizacionq3-preciounitario">
                                                        <div class="input-group">
                                                            <input type="number" class="form-control preciounitario-cotizacionq3" name="PRECIO_UNITARIOQ3[]">
                                                        </div>
                                                    </td>


                                                    <td class="text-center">
                                                        <div class="input-group">
                                                            <span class="input-group-text">$</span>
                                                            <input type="number" class="form-control importe-cotizacionq3" name="SUBTOTAL_Q3[]">
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="input-group">
                                                            <span class="input-group-text">$</span>
                                                            <input type="number" class="form-control iva-cotizacionq3" name="IVA_Q3[]">
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="input-group">
                                                            <span class="input-group-text">$</span>
                                                            <input type="number" class="form-control total-cotizacionq3" name="IMPORTE_Q3[]" readonly>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <textarea rows="2" class="form-control textareaq3" placeholder="Observaciones..." name="OBSERVACIONES_Q3[]"></textarea>
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="text" class="form-control mydatepicker fecha-cotizacionq3" placeholder="aaaa-mm-dd" name="FECHA_COTIZACION_Q3[]">
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="input-group">
                                                            <input type="file" class="form-control doc-cotizacionq3" accept=".pdf" name="DOCUMENTO_Q3[]">
                                                            <span class="input-group-text"><i class="fas fa-upload"></i></span>
                                                        </div>
                                                    </td>


                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- NUEVO: Sección de proveedor sugerido -->
                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                            <div class="card border-info">
                                                <div class="card-header bg-light">
                                                    <h6 class="mb-0 fw-bold">Proveedor Sugerido</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <!-- Proveedor sugerido -->
                                                        <div class="col-md-4 mb-3">
                                                            <label class="form-label fw-bold">Seleccione el proveedor sugerido:</label>
                                                            <select class="form-select proveedor-sugerido" name="PROVEEDOR_SUGERIDO[]">
                                                                <option value="">Seleccionar proveedor sugerido</option>
                                                                <!-- Se llena dinámicamente -->
                                                            </select>
                                                        </div>

                                                        <!-- Solicitar verificación -->
                                                        <div class="col-md-4 mb-3">
                                                            <label class="form-label fw-bold">¿Solicitar aprobación?</label>
                                                            <select class="form-select solicitar-verificacion" name="SOLICITAR_VERIFICACION[]">
                                                                <option value="">Seleccione una opción</option>
                                                                <option value="Sí">Sí</option>
                                                                <option value="No">No</option>
                                                            </select>
                                                        </div>


                                                        <div class="col-md-4 mb-3">
                                                            <label class="form-label fw-bold">Fecha de solicitud *</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control mydatepicker fecha-verificacion" placeholder="aaaa-mm-dd" name="FECHA_VERIFICACION[]">
                                                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12  mt-3">
                                                        <label class="form-label fw-bold">Comentario</label>
                                                        <textarea class="form-control comentario-solicitud" name="COMENTARIO_SOLICITUD[]"></textarea>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>




                                    @if(auth()->check() && auth()->user()->hasRoles(['Superusuario','Administrador','externo']))


                                    <div class="aprobacion-direccion-hoja mt-5" style="display: none;">


                                        <div class="bloque-aprobacion">
                                            <div class="row">
                                                <!-- Estado de Aprobación -->
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label fw-bold">Estado de Aprobación</label>
                                                    <select class="form-control estado-aprobacion" name="ESTADO_APROBACION[]">
                                                        <option value="" selected disabled>Seleccione una opción</option>
                                                        <option value="Aprobada">Aprobada</option>
                                                        <option value="Rechazada">Rechazada</option>
                                                    </select>
                                                </div>

                                                <!-- Fecha de Aprobación -->
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label fw-bold">Fecha de aprobación *</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control mydatepicker fecha-aprobacion" placeholder="aaaa-mm-dd" name="FECHA_APROBACION[]">
                                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                                    </div>
                                                </div>

                                                <!-- Requiere comentario -->
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label fw-bold">Requiere algún comentario</label>
                                                    <select class="form-control requiere-comentario" name="REQUIERE_COMENTARIO[]">
                                                        <option value="" selected disabled>Seleccione una opción</option>
                                                        <option value="Sí">Sí</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </div>

                                                <!-- Comentario visible si selecciona "Sí" -->
                                                <div class="col-md-12 comentario-aprobacion-hoja mt-3" style="display: none;">
                                                    <label class="form-label fw-bold">Comentario</label>
                                                    <textarea class="form-control comentario-aprobacion" name="COMENTARIO_APROBACION[]"></textarea>
                                                </div>
                                            </div>

                                            <!-- Motivo de Rechazo -->
                                            <div class="mt-3 motivo-rechazo-hoja" style="display: none;">
                                                <label class="form-label fw-bold">Motivo del rechazo</label>
                                                <textarea class="form-control motivo-rechazo" name="MOTIVO_RECHAZO[]" rows="3" placeholder="Escriba el motivo de rechazo..."></textarea>
                                            </div>
                                        </div>



                                        <!-- Sección inicial de PO -->
                                        <div class="row mt-4">
                                            <div class="col-md-12">
                                                <div class="card border-primary">
                                                    <div class="card-body">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">¿Requiere PO?</label>
                                                            <select class="form-select requiere-po" name="REQUIERE_PO[]">
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
                                                            <div class="col-md-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold">Proveedor seleccionado:</label>
                                                                    <select class="form-select proveedor-seleccionado" name="PROVEEDOR_SELECCIONADO[]">
                                                                        <option value="">Seleccionar proveedor sugerido</option>
                                                                        <!-- Se llena dinámicamente -->
                                                                    </select>

                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold">Monto final:</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">$</span>
                                                                        <input type="number" class="form-control monto-final" name="MONTO_FINAL[]">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold">Forma de pago:</label>
                                                                    <select class="form-select forma-pago" name="FORMA_PAGO[]">
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

                                                        <div class="alert alert-warning matriz-comparativa d-none">
                                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                                            <strong>Aviso:</strong> Se requiere realizar una Matriz comparativa de cotizaciones
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    @endif

                                </div>
                            </div>
                        </div>
                    </template>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" id="btnGuardarTodo">Guardar Todo</button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Template para cada producto -->








<div class="modal fade" id="miModal_MR" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioMR" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Requisición de Materiales</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}


                    <div id="SOLICITUD_MR">


                        <div class="col-12 mt-3">
                            <div class="row">
                                <div class="col-9">
                                    <label>Solicitante </label>
                                    <input type="text" class="form-control" id="SOLICITANTE_MR" name="SOLICITANTE_MR" readonly>
                                </div>

                                <div class="col-3">
                                    <label>Fecha de solicitud *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_SOLICITUD_MR" name="FECHA_SOLICITUD_MR" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-12 mt-3">
                            <div class="row">
                                <div class="col-9">
                                    <label>Área Solicitante </label>
                                    <input type="text" class="form-control" id="AREA_SOLICITANTE_MR" name="AREA_SOLICITANTE_MR" readonly>
                                </div>
                                <div class="col-3">
                                    <label>No. de MR *</label>
                                    <input type="text" class="form-control" id="NO_MR" name="NO_MR" readonly>
                                </div>
                            </div>
                        </div>



                        <div class="mt-3">
                            <div class="row">
                                <!-- <div class="col-6 mb-3">
                                    <label>Agregar material</label>
                                    <button id="botonmaterial" id="botonmaterial" type="button" class="btn btn-danger ml-2 rounded-pill" title="Agregar">
                                        <i class="bi bi-plus-circle-fill"></i>
                                    </button>
                                </div> -->
                            </div>
                            <div class="materialesdiv mt-4"></div>
                        </div>

                        <div class="mt-3">
                            <label>Justificación *</label>
                            <textarea class="form-control" id="JUSTIFICACION_MR" name="JUSTIFICACION_MR" rows="3"></textarea>
                        </div>





                        <div id="VISTO_BUENO_JEFE" style="display: block;">



                            <div class="col-12 mt-3">
                                <div class="row">
                                    <div class="col-4">
                                        <label for="PRIORIDAD">Prioridad</label>
                                        <select class="form-control" id="PRIORIDAD_MR" name="PRIORIDAD_MR">
                                            <option value="" selected disabled>Seleccione una opción</option>
                                            <option value="Alta">Alta 1-15 días</option>
                                            <option value="Media">Media 16-30 días</option>
                                            <option value="Baja">Baja 31-60 días</option>
                                        </select>
                                    </div>

                                    <div class="col-8">
                                        <label for="OBSERVACIONES">Observaciones</label>
                                        <input type="text" class="form-control" id="OBSERVACIONES_MR" name="OBSERVACIONES_MR">
                                    </div>
                                </div>
                            </div>





                            <div class="col-12 mt-3">
                                <div class="row">
                                    <div class="col-8">
                                        <label for="VISTO_BUENO">Visto bueno</label>
                                        <input type="text" class="form-control" id="VISTO_BUENO" name="VISTO_BUENO">
                                    </div>

                                    <div class="col-4">
                                        <label>Fecha *</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_VISTO_MR" name="FECHA_VISTO_MR">
                                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-12 mt-3" id="MOTIVO_RECHAZO_JEFE_DIV" style="display: none;">
                                <label>Motivo del rechazo del jefe inmediato</label>
                                <textarea class="form-control" id="MOTIVO_RECHAZO_JEFE" name="MOTIVO_RECHAZO_JEFE" rows="3" placeholder="Escriba el motivo de rechazo..."></textarea>
                            </div>


                        </div>


                        <div id="BOTON_VISTO_BUENO" style="display: none;">
                            <div id="solicitarVerificacionDiv" class="col-12 text-center mt-3" style="display: block;">

                                <input type="hidden" id="DAR_BUENO" name="DAR_BUENO" value="0">
                            </div>



                        </div>




                        <div id="APROBACION_DIRECCION" style="display: none;">


                            <div class="col-12 mt-3">
                                <label for="ESTADO_APROBACION">Estado de Aprobación</label>
                                <div id="estado-container" class="p-2 rounded">
                                    <select class="form-control" id="ESTADO_APROBACION" name="ESTADO_APROBACION" onchange="cambiarColor()">
                                        <option value="" selected disabled>Seleccione una opción</option>
                                        <option value="Aprobada">Aprobada</option>
                                        <option value="Rechazada">Rechazada</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-12 mt-3" id="motivo-rechazo-container" style="display: none;">
                                <label>Motivo del rechazo del que aprobo</label>
                                <textarea class="form-control" id="MOTIVO_RECHAZO" name="MOTIVO_RECHAZO" rows="3" placeholder="Escriba el motivo de rechazo..."></textarea>
                            </div>


                            <div class="col-12 mt-3">
                                <div class="row">

                                    <div class="col-8">
                                        <label for="APROBACION">Quien aprueba</label>
                                        <input type="text" class="form-control" id="QUIEN_APROBACION" name="QUIEN_APROBACION">

                                        <meta name="usuario-autenticado" content="{{ Auth::user()->EMPLEADO_NOMBRE }} {{ Auth::user()->EMPLEADO_APELLIDOPATERNO }} {{ Auth::user()->EMPLEADO_APELLIDOMATERNO }}">
                                    </div>
                                    <div class="col-4">
                                        <label>Fecha *</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_APRUEBA_MR" name="FECHA_APRUEBA_MR">
                                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-12 mt-3">
                            <div class="row justify-content-center">
                                <div class="col-6 text-center">
                                    <button type="submit" class="btn btn-success w-100" id="GENERARPDF">Generar MR</button>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>






@endsection