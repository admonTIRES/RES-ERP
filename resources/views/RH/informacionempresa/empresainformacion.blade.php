@extends('principal.maestra')

@section('contenido')



<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-file-earmark-fill"></i>&nbsp;Información empresa</h3>

        <button type="button" class="btn btn-light waves-effect waves-light " id="NUEVO_CLIENTE" style="margin-left: auto;">
            Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
        </button>

    </ol>

    <div class="card-body">
        <table id="Tablainformacionempresa" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">

        </table>
    </div>


</div>













<div class="modal modal-fullscreen fade" id="miModal_EMPRESA" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioEMPRESA" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h5 class="modal-title" id="miModalLabel">Información empresa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    {!! csrf_field() !!}

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs mb-3" id="tabsCliente" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="tab1-info" data-bs-toggle="tab" data-bs-target="#contenido-info" type="button" role="tab">Información </button>
                        </li>
                    </ul>

                    <!-- Tab contents -->
                    <div class="tab-content">
                        <!-- TAB 1: Información del cliente -->
                        <div class="tab-pane fade show active" id="contenido-info" role="tabpanel">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-12 mb-3 text-center">
                                            <h5 class="form-label"><b>Datos de la empresa</b></h5>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">RFC </label>
                                            <input type="text" class="form-control" id="RFC_EMPRESA" name="RFC_EMPRESA" required>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Denominación/Razón Social *</label>
                                            <input type="text" class="form-control" id="RAZON_SOCIAL" name="RAZON_SOCIAL" required>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Régimen Capital *</label>
                                            <input type="text" class="form-control" id="REGIMEN_CAPITAL" name="REGIMEN_CAPITAL" required>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Nombre Comercial *</label>
                                            <input type="text" class="form-control" id="NOMBRE_COMERCIAL" name="NOMBRE_COMERCIAL" required>
                                        </div>




                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <label>Agregar dirección</label>
                                                <button id="botonAgregardomicilio" type="button" class="btn btn-danger ml-2 rounded-pill" title="Agregar">
                                                    <i class="bi bi-plus-circle-fill"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="direcciondiv mt-4"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <label>Agregar representante legal</label>
                                                <button id="botonAgregarcontacto" type="button" class="btn btn-danger ml-2 rounded-pill" title="Agregar">
                                                    <i class="bi bi-plus-circle-fill"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="contactodiv mt-4"></div>
                                    </div>
                                </div>


                                <div class="col-12 mb-3">
                                    <label class="form-label">¿Cuenta con sucursales? *</label>
                                    <select class="form-control" id="CUENTA_SUCURSALES" name="CUENTA_SUCURSALES" required>
                                        <option value="" selected disabled>Seleccione una opción</option>
                                        <option value="1">Sí</option>
                                        <option value="2">No</option>
                                    </select>
                                </div>



                                <div class="row" id="SUCURSALES_DIV" style="display: none;">
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <label>Agregar sucursal</label>
                                                <button id="botonAgregarSucursales" type="button" class="btn btn-danger ml-2 rounded-pill" title="Agregar">
                                                    <i class="bi bi-plus-circle-fill"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="sucursalesdiv mt-4"></div>
                                    </div>
                                </div>




                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer mx-5">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarEMPRESA">
                        <i class="bi bi-floppy-fill" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Guardar"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>








@endsection