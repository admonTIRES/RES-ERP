@extends('principal.maestramantenimiento')

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



    #Tablamantenimiento td.col-justificacion {
        white-space: normal !important;
        overflow: visible !important;
        text-overflow: unset !important;
        word-wrap: break-word !important;
        text-align: center !important;
        vertical-align: middle !important;
        height: auto !important;
        line-height: 1.3em;
    }


    #Tablamantenimiento td {
        word-wrap: break-word;
        white-space: normal !important;
    }
</style>


<div class="contenedor-contenido">

    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;">&nbsp;Lista de instalaciones que requieren mantenimiento</h3>
        <button type="button" class="btn btn-light waves-effect waves-light " id="NUEVO_INSTALACION" style="margin-left: auto;">
            Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
        </button>
    </ol>


    <div class="card-body">
        <div class="tabla-scroll-wrapper">
            <div class="tabla-scroll-top">
                <div class="scroll-inner"></div>
            </div>
            <div class="tabla-scroll-bottom">
                <div class="table-responsive">
                    <table id="Tablalistainstalacion" class="table table-hover table-bordered  w-100" style="min-width: 1000px; table-layout: fixed;">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Descripción</th>
                                <th class="text-center">Ubicación</th>
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


<div id="Modal_instalaciones" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" style="min-width: 86%;">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioINSTALACIONES" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nueva instalación</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs mb-3" id="tabsinventario" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="tab1-info" data-bs-toggle="tab" data-bs-target="#contenido-info" type="button" role="tab">Información de la instalación</button>
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
                                                        <label> Foto instalación </label>
                                                        <input type="file" accept="image/jpeg,image/x-png,image/gif" id="FOTO_INSTALACION" name="FOTO_INSTALACION" data-allowed-file-extensions="jpg png JPG PNG" data-height="240" data-default-file="" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-9">
                                            <div class="row">
                                                <div class="col-12">
                                                    {!! csrf_field() !!}
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <div class="form-group">
                                                        <label> Descripción de la instalación *</label>
                                                        <textarea class="form-control" id="DESCRIPCION_INSTALACION" name="DESCRIPCION_INSTALACION" rows="5" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <div class="form-group">
                                                        <label> Ubicación *</label>
                                                        <input type="text" step="any" class="form-control" id="UBICACION_INSTALACION" name="UBICACION_INSTALACION" required>
                                                    </div>
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <div class="form-group">
                                                        <label> Especificaciones *</label>
                                                        <textarea class="form-control" id="ESPECIFICACIONES_INSTALACION" name="ESPECIFICACIONES_INSTALACION" rows="5" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-6 mt-2">
                                                    <div class="form-group">
                                                        <label>Año de construcción *</label>
                                                        <select class="form-select" id="ANIO_CONSTRUCCION_INSTALACION" name="ANIO_CONSTRUCCION_INSTALACION" required>
                                                            <option value="" selected disabled>Seleccione una opción</option>
                                                            <script>
                                                                const currentYear = new Date().getFullYear();
                                                                for (let i = currentYear; i >= 2024; i--) {
                                                                    document.write('<option value="' + i + '">' + i + '</option>');
                                                                }
                                                            </script>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-6 mt-2">
                                                    <label>¿El proveedor está dado de alta? </label>
                                                    <select class="form-control" name="PROVEEDOR_ALTA" id="PROVEEDOR_ALTA" required>
                                                        <option value="" selected disabled>Seleccione una opción</option>
                                                        <option value="1">Sí</option>
                                                        <option value="2">No</option>
                                                    </select>
                                                </div>


                                                <div class="col-12 mt-2" id="PROVEEDORES_ACTIVOS" style="display: none;">
                                                    <label class="form-label">Proveedor</label>
                                                    <select class="form-select text-center" id="PROVEEDOR_INSTALACION" name="PROVEEDOR_INSTALACION">
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


                                                <div class="col-12 mt-2" id="ESCRIBIR_PROVEEDOR" style="display: none;">
                                                    <label class="form-label">Proveedor</label>
                                                    <input type="text" class="form-control" id="NOMBRE_PROVEEDOR_INSTALACION" name="NOMBRE_PROVEEDOR_INSTALACION" required>
                                                </div>

                                                <div class="col-12 mt-2">
                                                    <label class="form-label">Mantenimiento *</label>
                                                    <input type="text" class="form-control" id="MANTENIMIENTO_INSTALACION" name="MANTENIMIENTO_INSTALACION" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!--   Fin del tab información  -->
                    </div>
                </div>
                <div class="modal-footer mt-5">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarINSTALACIONES">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>




@endsection