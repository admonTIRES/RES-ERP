@extends('principal.maestracompras')

@section('contenido')



<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-person-rolodex"></i>&nbsp;Proveedores temporales </h3>
        <button type="button" class="btn btn-light waves-effect waves-light " data-bs-toggle="modal" data-bs-target="#miModal_proveedortemporal" style="margin-left: auto;">
            Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
        </button>
    </ol>

    <div class="card-body">
        <table id="Tablaproveedortemporal" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
        </table>
    </div>
</div>







<div class="modal modal-fullscreen fade" id="miModal_proveedortemporal" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioPROVEEDORTEMP" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar proveedor</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    {!! csrf_field() !!}

                    <div class="col-12">
                        <div class="row">


                            <div class="col-6 mt-3">
                                <label>R.F.C </label>
                                <input type="text" class="form-control" id="RFC_PROVEEDORTEMP" name="RFC_PROVEEDORTEMP">
                            </div>
                            <div class="col-6 mt-3">
                                <label>Nombre comercial </label>
                                <input type="text" class="form-control" id="NOMBRE_PROVEEDORTEMP" name="NOMBRE_PROVEEDORTEMP">
                            </div>
                            <div class="col-6 mt-3">
                                <label>Razón social</label>
                                <input type="text" class="form-control" id="RAZON_PROVEEDORTEMP" name="RAZON_PROVEEDORTEMP">
                            </div>
                            <div class="col-6 mt-3">
                                <label>Giro </label>
                                <input type="text" class="form-control" id="GIRO_PROVEEDORTEMP" name="GIRO_PROVEEDORTEMP">
                            </div>

                        </div>
                    </div>


                    <div class="row mt-5">
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


                    <div class="col-12 mt-4">
                        <div class="row">
                            <div class="col-md-12 mb-3 text-center">
                                <h5 class="form-label"><b>Requiere contrato </b></h5>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="REQUIERE_CONTRATO" id="contratosi" value="1" required>
                                    <label class="form-check-label" for="contratosi">Sí</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="REQUIERE_CONTRATO" id="contratono" value="2">
                                    <label class="form-check-label" for="contratono">No</label>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="mb-3" id="DOCUMENTO_CONTRATO" style="display: none;">
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <label class="form-label">Cargar contrato (PDF) *</label>
                                <div class="d-flex align-items-center">
                                    <input type="file" class="form-control me-2" name="DOCUMENTO_SOPORTE" accept=".pdf">
                                    <button type="button" class="btn btn-warning botonEliminarArchivo" title="Eliminar archivo">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>



                                <div class="col-4 mt-3">
                                    <label>Fecha Inicio *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHAI_CONTRATO" name="FECHAI_CONTRATO" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>

                                <div class="col-md-4 mt-3 text-center">
                                    <h5 class="form-label"><b>Contrato indeterminado</b></h5>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="INDETERMINADO_CONTRATO" id="indeterminadosi" value="1" required>
                                        <label class="form-check-label" for="indeterminadosi">Sí</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="INDETERMINADO_CONTRATO" id="indeterminadono" value="2">
                                        <label class="form-check-label" for="indeterminadono">No</label>
                                    </div>

                                </div>


                                <div class="col-4 mt-3">
                                    <label>Fecha Fin *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHAF_CONTRATO" name="FECHAF_CONTRATO" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>


                            </div>

                        </div>
                    </div>






                </div>

                <div class="modal-footer mx-5">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarPROVEEDORTEMP">
                        <i class="bi bi-floppy-fill" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Guardar proveedor"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>






@endsection