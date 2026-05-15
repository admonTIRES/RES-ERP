@extends('principal.maestraproveedores')

@section('contenido')




<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-person-lines-fill"></i>&nbsp;Contactos</h3>


        <button type="button" class="btn btn-light waves-effect waves-light " id="NUEVO_CONTACTO" style="margin-left: auto;">
            Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
        </button>
    </ol>

    <div class="card-body">
        <table id="Tablacontactosproveedor" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
            <i id="loadingIcon1" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>

        </table>
    </div>
</div>


<div class="modal fade" id="miModal_contactos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioCONTACTOS" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nuevo contacto</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}

                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Funciones/áreas *</label>
                                    <select class="form-control" name="FUNCIONES_CUENTA[]" id="FUNCIONES_CUENTA" multiple>
                                        @foreach ($funcionesCuenta as $funcion)
                                        <option value="{{ $funcion->ID_CATALOGO_FUNCIONESPROVEEDOR }}">
                                            {{ $funcion->NOMBRE_FUNCIONES }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Título *</label>
                                    <select class="form-control" name="TITULO_CUENTA" id="TITULO_CUENTA" required>
                                        <option value="" selected disabled>Seleccione una opción</option>
                                        @foreach ($titulosCuenta as $titulo)
                                        <option value="{{ $titulo->ABREVIATURA_TITULO }}">
                                            {{ $titulo->NOMBRE_TITULO }}
                                        </option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="col-md-9 mb-3">
                                    <label class="form-label">Nombre *</label>
                                    <input type="text" class="form-control" name="NOMBRE_CONTACTO_CUENTA" id="NOMBRE_CONTACTO_CUENTA" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Cargo *</label>
                                    <input type="text" class="form-control" name="CARGO_CONTACTO_CUENTA" id="CARGO_CONTACTO_CUENTA" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Teléfono</label>
                                    <input type="text" class="form-control" name="TELEFONO_CONTACTO_CUENTA" id="TELEFONO_CONTACTO_CUENTA">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Extensión</label>
                                    <input type="text" class="form-control" name="EXTENSION_CONTACTO_CUENTA" id="EXTENSION_CONTACTO_CUENTA">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Celular *</label>
                                    <input type="text" class="form-control" name="CELULAR_CONTACTO_CUENTA" id="CELULAR_CONTACTO_CUENTA" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Correo electrónico *</label>
                                    <input type="email" class="form-control" name="CORREO_CONTACTO_CUENTA" id="CORREO_CONTACTO_CUENTA" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarCONTACTOS">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>





@endsection