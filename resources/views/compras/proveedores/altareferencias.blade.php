@extends('principal.maestraproveedores')

@section('contenido')




<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-journal-text"></i>&nbsp;Referencia comerciales</h3>


        <button type="button" class="btn btn-light waves-effect waves-light" id="NUEVA_REFERENCIA" data-bs-toggle="modal" data-bs-target="#miModal_referencia" style="margin-left: auto;">
            Nueva &nbsp;<i class="bi bi-plus-circle"></i>
        </button>
    </ol>

    <div class="card-body">
        <table id="Tablareferenciasproveedor" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
            <i id="loadingIcon1" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>

        </table>
    </div>
</div>


<div class="modal fade" id="miModal_referencia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioReferencias" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nueva referencia comercial</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}

                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label">Nombre de la empresa *</label>
                                    <input type="text" class="form-control" name="NOMBRE_EMPRESA" id="NOMBRE_EMPRESA" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Nombre del contacto *</label>
                                    <input type="text" class="form-control" name="NOMBRE_CONTACTO" id="NOMBRE_CONTACTO" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Cargo *</label>
                                    <input type="text" class="form-control" name="CARGO_REFERENCIA" id="CARGO_REFERENCIA" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Teléfono *</label>
                                    <input type="text" class="form-control" name="TELEFONO_REFERENCIA" id="TELEFONO_REFERENCIA" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Correo electrónico *</label>
                                    <input type="text" class="form-control" name="CORREO_REFERENCIA" id="CORREO_REFERENCIA" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Producto y/o servicio suministrado *</label>
                                    <input type="text" class="form-control" name="PRODUCTO_SERVICIO" id="PRODUCTO_SERVICIO" required>
                                </div>
                                <div class="col-4 mb-3">
                                    <label class="form-label">Desde *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" name="DESDE_REFERENCIA" id="DESDE_REFERENCIA" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>

                                <div class="col-4 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="proveedorVigenteCheck">
                                        <label class="form-check-label" for="proveedorVigenteCheck">
                                            Proveedor vigente (actual)
                                        </label>
                                    </div>
                                </div>

                                <input type="hidden" name="REFERENCIA_VIGENTE" id="referenciaVigenteInput">


                                <div class="col-4 mb-3">
                                    <label class="form-label">Hasta *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" name="HASTA_REFERENCIA" id="HASTA_REFERENCIA" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarREFERENCIAS">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>





@endsection