@extends('principal.maestralmacen')

@section('contenido')

<style>
    .dropify-wrapper {
        height: 270px !important;
        border-radius: 5px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        text-align: center;

    }

    .dropify-message p {
        font-size: 14px;
        margin: 0;
    }


    .bg-verde-suave {
        background-color: #d4edda !important;
    }

    .bg-rojo-suave {
        background-color: #f8d7da !important;
    }

    .bg-amarrillo-suave {
        background-color: #fff3cd !important;
    }

    .bg-naranja-suave {
        background-color: #efd8b9 !important;
    }


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



    #Tablalistadeaf td.col-justificacion {
        white-space: normal !important;
        overflow: visible !important;
        text-overflow: unset !important;
        word-wrap: break-word !important;
        text-align: center !important;
        vertical-align: middle !important;
        height: auto !important;
        line-height: 1.3em;
    }


    #Tablalistadeaf td {
        word-wrap: break-word;
        white-space: normal !important;
    }
</style>


<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5" style="display: flex; justify-content: center; align-items: center;">

        <h3 class="mb-0 text-white">
            <i class="bi bi-list-task"></i> Lista de activo fijo
        </h3>
    </ol>


    <div class="card-body">
        <div class="tabla-scroll-wrapper">
            <div class="tabla-scroll-top">
                <div class="scroll-inner"></div>
            </div>
            <div class="tabla-scroll-bottom">
                <div class="table-responsive">
                    <table id="Tablalistadeaf" class="table table-hover table-bordered  w-100" style="min-width: 1000px; table-layout: fixed;">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Descripción</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-center">Marca</th>
                                <th class="text-center">Modelo</th>
                                <th class="text-center">Serie</th>
                                <th class="text-center">Ubicación</th>
                                <th class="text-center">Código de Identificación</th>
                                <th class="text-center">Editar</th>
                                <th class="text-center">Visualizar</th>
                                <th class="text-center">Activo</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</div>

<div id="Modal_inventario" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" style="min-width: 86%;">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioINVENTARIO" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Equipo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">


                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs mb-3" id="tabsinventario" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="tab1-info" data-bs-toggle="tab" data-bs-target="#contenido-info" type="button" role="tab">Información del ítem</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab3-documentos" data-bs-toggle="tab" data-bs-target="#contenido-documentos" type="button" role="tab" style="display: none;">Documentación</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab2-entrada" data-bs-toggle="tab" data-bs-target="#contenido-entrada" type="button" role="tab" style="display: none;">Bitácora</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab5-detalle" data-bs-toggle="tab" data-bs-target="#contenido-detalle" type="button" role="tab" style="display: none;">Detalle artículo</button>
                        </li>
                    </ul>


                    <!-- Tab contents -->
                    <div class="tab-content">

                        <div class="tab-pane fade show active" id="contenido-info" role="tabpanel">

                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label> Foto del ítem </label>
                                                        <input type="file" accept="image/jpeg,image/x-png,image/gif/" id="FOTO_EQUIPO" name="FOTO_EQUIPO" data-allowed-file-extensions="jpg png JPG PNG jpeg JPEG" data-height="240" data-default-file="" />
                                                    </div>


                                                    <div class="form-group mt-5 text-center" id="MOSTRAR_ALERTA_DOCUMENTOS" style="display: none;">
                                                        <div class="table-responsive mt-3">
                                                            <table class="table table-bordered table-striped" id="tablaDocumentos">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-center">Documento</th>
                                                                        <th class="text-center">Fecha documento</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody></tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-9">
                                            <div class="row">
                                                <div class="col-12">
                                                    {!! csrf_field() !!}
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label> Descripción del ítem*</label>
                                                        <textarea class="form-control" id="DESCRIPCION_EQUIPO" name="DESCRIPCION_EQUIPO" rows="5" required></textarea>
                                                    </div>
                                                </div>

                                                <div class="col-3 mt-2">
                                                    <div class="form-group">
                                                        <label> Marca *</label>
                                                        <input type="text" class="form-control" id="MARCA_EQUIPO" name="MARCA_EQUIPO" required>
                                                    </div>
                                                </div>
                                                <div class="col-3 mt-2">
                                                    <div class="form-group">
                                                        <label> Modelo *</label>
                                                        <input type="text" class="form-control" id="MODELO_EQUIPO" name="MODELO_EQUIPO" required>
                                                    </div>
                                                </div>
                                                <div class="col-3 mt-2">
                                                    <div class="form-group">
                                                        <label> Serie *</label>
                                                        <input type="text" class="form-control" id="SERIE_EQUIPO" name="SERIE_EQUIPO" required>
                                                    </div>
                                                </div>
                                                <div class="col-3 mt-2">
                                                    <div class="form-group">
                                                        <label>Código de Identificación *</label>
                                                        <input type="text" class="form-control" id="CODIGO_EQUIPO" name="CODIGO_EQUIPO" required>
                                                    </div>
                                                </div>
                                                <div class="col-12 mt-2" id="DATOS_VEHICULOS" style="display: none;">
                                                    <div class="row">

                                                        <div class="col-6 mt-2">
                                                            <div class="form-group">
                                                                <label>Placas *</label>
                                                                <input type="text" class="form-control" id="PLACAS_VEHICULOS" name="PLACAS_VEHICULOS" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 mt-2">
                                                            <div class="form-group">
                                                                <label>Color *</label>
                                                                <input type="text" class="form-control" id="COLOR_VEHICULO" name="COLOR_VEHICULO" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-3 mt-2">
                                                            <div class="form-group">
                                                                <label>Entidad póliza *</label>
                                                                <input type="text" class="form-control" id="ENTIDAD_POLIZA" name="ENTIDAD_POLIZA" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-3 mt-2">
                                                            <div class="form-group">
                                                                <label>Número de póliza *</label>
                                                                <input type="text" class="form-control" id="NUMERO_POLIZA" name="NUMERO_POLIZA" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-3 mt-2">
                                                            <div class="form-group">
                                                                <label>Inicio de Vigencia *</label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="INICIOVIGENCIA_POLIZA" name="INICIOVIGENCIA_POLIZA" required>
                                                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-3 mt-2">
                                                            <div class="form-group">
                                                                <label>Fin de Vigencia *</label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FINVIGENCIA_POLIZA" name="FINVIGENCIA_POLIZA" required>
                                                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 text-center mt-2">
                                                            <h5>Marca de llantas </h5>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <label>Frente derecha *</label>
                                                                <input type="text" class="form-control" id="FRENTE_DERECHA" name="FRENTE_DERECHA" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <label>Frente izquierda *</label>
                                                                <input type="text" class="form-control" id="FRENTE_IZQUIERDA" name="FRENTE_IZQUIERDA" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <label>Trasera derecha *</label>
                                                                <input type="text" class="form-control" id="TRASERA_DERECHA" name="TRASERA_DERECHA" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <label>Trasera izquierda *</label>
                                                                <input type="text" class="form-control" id="TRASERA_IZQUIERDA" name="TRASERA_IZQUIERDA" required>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-2 mt-2">
                                                    <div class="form-group">
                                                        <label> Cantidad *</label>
                                                        <input type="Number" step="any" class="form-control" id="CANTIDAD_EQUIPO" name="CANTIDAD_EQUIPO" required>
                                                    </div>
                                                </div>

                                                <div class="col-2 mt-2">
                                                    <div class="form-group">
                                                        <label>Límite mínimo *</label>
                                                        <input type="Number" step="any" class="form-control" id="LIMITEMINIMO_EQUIPO" name="LIMITEMINIMO_EQUIPO" required>
                                                    </div>
                                                </div>



                                                <div class="col-2 mt-2">
                                                    <div class="form-group">
                                                        <label> U.M. *</label>
                                                        <input type="text" step="any" class="form-control" id="UNIDAD_MEDIDA" name="UNIDAD_MEDIDA" required>
                                                    </div>
                                                </div>



                                                <div class="col-6 mt-2">
                                                    <div class="form-group">
                                                        <label> Ubicación *</label>
                                                        <input type="text" step="any" class="form-control" id="UBICACION_EQUIPO" name="UBICACION_EQUIPO" required>
                                                    </div>
                                                </div>


                                                <div class="col-4 mt-2">
                                                    <div class="form-group">
                                                        <label> Estado *</label>
                                                        <input type="text" step="any" class="form-control" id="ESTADO_EQUIPO" name="ESTADO_EQUIPO" required>
                                                    </div>
                                                </div>

                                                <div class="col-4 mt-2">
                                                    <label>¿El ítem es crítico? *</label>
                                                    <select class="form-control" name="ITEM_CRITICO" id="ITEM_CRITICO" required>
                                                        <option value="" selected disabled>Seleccione una opción</option>
                                                        <option value="1">Sí</option>
                                                        <option value="2">No</option>
                                                    </select>
                                                </div>


                                                <div class="col-4 mt-2">
                                                    <div class="form-group">
                                                        <label>Fecha de adquisición *</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_ADQUISICION" name="FECHA_ADQUISICION" required>
                                                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                                        </div>
                                                    </div>
                                                </div>



                                                <div class="col-4 mt-2">
                                                    <label>¿El proveedor está dado de alta? *</label>
                                                    <select class="form-control" name="PROVEEDOR_ALTA" id="PROVEEDOR_ALTA" required>
                                                        <option value="" selected disabled>Seleccione una opción</option>
                                                        <option value="1">Sí</option>
                                                        <option value="2">No</option>
                                                    </select>
                                                </div>

                                                <div class="col-8 mt-2">
                                                    <label>¿Requiere detallar los componentes del artículo? *</label>
                                                    <select class="form-control" name="DETALLAR_ARTICULOS" id="DETALLAR_ARTICULOS" onchange="guardarDetallearticulo()" required>
                                                        <option value="" selected disabled>Seleccione una opción</option>
                                                        <option value="1">Sí</option>
                                                        <option value="2">No</option>
                                                    </select>
                                                </div>


                                                <div class="col-12 mt-2" id="PROVEEDORES_ACTIVOS" style="display: block;">
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
                                                            <option value="N/A">N/A</option>

                                                        </optgroup>
                                                    </select>
                                                </div>


                                                <div class="col-12 mt-2" id="ESCRIBIR_PROVEEDOR" style="display: none;">
                                                    <label class="form-label">Proveedor</label>
                                                    <input type="text" class="form-control" id="NOMBRE_PROVEEDOR" name="NOMBRE_PROVEEDOR" required>
                                                </div>

                                                <div class="col-3 mt-2">
                                                    <div class="form-group">
                                                        <label> Precio Unitario (MXN)</label>
                                                        <input type="text" step="any" class="form-control" id="UNITARIO_EQUIPO" name="UNITARIO_EQUIPO">
                                                    </div>
                                                </div>
                                                <div class="col-3 mt-2">
                                                    <div class="form-group">
                                                        <label> Precio Total</label>
                                                        <input type="text" class="form-control" id="TOTAL_EQUIPO" name="TOTAL_EQUIPO">
                                                    </div>
                                                </div>
                                                <div class="col-3 mt-2">
                                                    <div class="form-group">
                                                        <label>Tipo *</label>
                                                        <select class="form-select" id="TIPO_EQUIPO" name="TIPO_EQUIPO" required>
                                                            <option value="0" disabled selected>Seleccione una opción</option>
                                                            @foreach ($tipoinventario as $tipos)
                                                            <option value="{{ $tipos->DESCRIPCION_TIPO }}">{{ $tipos->DESCRIPCION_TIPO }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-3 mt-2">
                                                    <label>Marcar si el ítem. requiere *</label>
                                                    <select class="form-control" id="REQUIERE_ARTICULO" name="REQUIERE_ARTICULO" onchange="guardarRequiereItem()" required>
                                                        <option value="" selected disabled>Seleccione una opción</option>
                                                        <option value="1">Documentación</option>
                                                        <option value="2">Mantenimiento</option>
                                                        <option value="3">N/A</option>
                                                    </select>
                                                </div>


                                                <div class="col-12 mt-3">
                                                    <div class="form-group">
                                                        <label> Observación</label>
                                                        <textarea class="form-control" id="OBSERVACION_EQUIPO" name="OBSERVACION_EQUIPO" rows="5" required></textarea>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!--   Fin del tab información del producto -->


                        <!-- TAB 2: Documentación del producto -->
                        <div class="tab-pane fade" id="contenido-documentos" role="tabpanel">
                            <ol class="breadcrumb mb-5">
                                <h3 style="color: #ffffff; margin: 0;">&nbsp;Documentos del ítem</h3>
                                <button type="button" class="btn btn-light waves-effect waves-light" id="NUEVA_DOCUMENTACION" style="margin-left: auto;">
                                    Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
                                </button>
                            </ol>

                            <div class="card-body">
                                <div class="card-body position-relative" id="tabla_activo" style="display: block;">
                                    <i id="loadingIcon1" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                                    <table id="Tabladocumentosinventario" class="table table-hover bg-white table-bordered text-center w-100 TableCustom"></table>
                                </div>
                            </div>
                        </div>
                        <!-- TAB 3: Entrada del producto -->
                        <div class="tab-pane fade" id="contenido-entrada" role="tabpanel">
                            <ol class="breadcrumb mb-5" style="display: flex; justify-content: center; align-items: center;">
                                <h3 style="color: #ffffff; margin: 0;">&nbsp;Bitácora</h3>
                            </ol>

                            <div class="card-body">
                                <div class="card-body position-relative" id="tabla_activo" style="display: block;">
                                    <i id="loadingIcon" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                                    <table id="Tablaentradainventario" class="table table-hover bg-white table-bordered text-center w-100 TableCustom"></table>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 5: Detalle artículo  -->

                        <div class="tab-pane fade" id="contenido-detalle" role="tabpanel">
                            <ol class="breadcrumb mb-5">
                                <h3 style="color: #ffffff; margin: 0;">&nbsp;Detalle</h3>
                                <button type="button" class="btn btn-light waves-effect waves-light" id="NUEVO_DETALLE" style="margin-left: auto;">
                                    Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
                                </button>
                            </ol>

                            <div class="card-body">
                                <div class="card-body position-relative" id="tabla_activo" style="display: block;">
                                    <i id="loadingIcon2" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                                    <table id="Tabladetallearticulos" class="table table-hover bg-white table-bordered text-center w-100 TableCustom"></table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer mt-5">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarINVENTARIO">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>




<!-- ============================================================== -->
<!-- MODAL DOCUMENTACION  -->
<!-- ============================================================== -->

<div class="modal fade" id="miModal_DOCUMENTOS" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioDOCUMENTOS" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nuevo documento</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Nombre del documento *</label>
                                <input type="text" class="form-control" name="NOMBRE_DOCUMENTO" id="NOMBRE_DOCUMENTO" required>
                            </div>

                            <div class="col-12 mt-4">
                                <div class="row">
                                    <div class="col-md-12 mb-3 text-center">
                                        <h5 class="form-label"><b>Requiere fecha </b></h5>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="REQUIERE_FECHA" id="fechasi" value="1" required>
                                            <label class="form-check-label" for="fechasi">Sí</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="REQUIERE_FECHA" id="fechano" value="2">
                                            <label class="form-check-label" for="fechano">No</label>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="mb-3" id="FECHA_DOCUMENTO" style="display: none;">
                                <div class="col-md-12 mb-3">
                                    <div class="row">
                                        <div class="col-4 mt-3">
                                            <label>Fecha Inicio *</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHAI_DOCUMENTO" name="FECHAI_DOCUMENTO" required>
                                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                            </div>
                                        </div>

                                        <div class="col-md-4 mt-3 text-center">
                                            <h5 class="form-label"><b>Indeterminado</b></h5>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="INDETERMINADO_DOCUMENTO" id="indeterminadosi" value="1" required>
                                                <label class="form-check-label" for="indeterminadosi">Sí</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="INDETERMINADO_DOCUMENTO" id="indeterminadono" value="2">
                                                <label class="form-check-label" for="indeterminadono">No</label>
                                            </div>

                                        </div>

                                        <div class="col-4 mt-3">
                                            <label>Fecha Fin *</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHAF_DOCUMENTO" name="FECHAF_DOCUMENTO" required>
                                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                            </div>
                                        </div>


                                    </div>

                                </div>
                            </div>



                            <div class="col-12 mb-3">
                                <label class="form-label">Subir Evidencia (PDF) *</label>
                                <div class="d-flex align-items-center">
                                    <input type="file" class="form-control me-2" name="DOCUMENTO_ARTICULO" id="DOCUMENTO_ARTICULO" accept=".pdf">
                                    <button type="button" class="btn btn-warning botonEliminarArchivo" title="Eliminar archivo">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarDOCUMENTACION">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- ============================================================== -->
<!-- MODAL DETALLE  -->
<!-- ============================================================== -->

<div class="modal fade" id="miModal_DETALLE" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioDETALLE" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nuevo detalle</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="col-12">
                        <div class="row">

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Nombre componente</label>
                                <input type="text" class="form-control" name="NOMBRE_COMPONENTE" id="NOMBRE_COMPONENTE">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Código / parte </label>
                                <input type="text" class="form-control" name="CODIGO_PARTE" id="CODIGO_PARTE">
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">Cantidad </label>
                                <input type="number" class="form-control" name="CANTIDAD_DETALLE" id="CANTIDAD_DETALLE">
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">Fecha de compra </label>
                                <div class="input-group">
                                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_COMPRA" name="FECHA_COMPRA">
                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                </div>
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">Requiere reemplazo </label>
                                <select class="form-control" id="REQUIERE_REEMPLAZO" name="REQUIERE_REEMPLAZO">
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="1">Sí</option>
                                    <option value="2">No</option>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarDETALLEARTICULO">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection