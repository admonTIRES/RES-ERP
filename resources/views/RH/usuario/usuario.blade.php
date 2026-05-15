@extends('principal.maestra')

@section('contenido')



<style type="text/css" media="screen">
    
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


    .modal-header .close {
        font-size: 1.5rem;
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
    }

    .btn-default.waves-effect {
        background-color: #f1f1f1;
        border: 1px solid #ddd;
    }

    .btn-danger {
        background-color: #d9534f;
        border-color: #d43f3a;
    }

    .form-control {
        margin-bottom: 15px;
    }


    #Tablausuarios thead th:nth-child(6) {
        text-align: center;
    }

    #Tablausuarios tbody td:nth-child(6) {
        text-align: left !important;
    }

    #Tablausuarios ul {
        padding-left: 20px;
        margin: 0;
    }

    #Tablausuarios ul li {
        margin: 0;
        padding: 0;
    }

    .texto-seleccionado {
        color: #0d6efd;
        font-weight: bold;
    }

    .texto-no-seleccionado {
        color: gray;
    }

    .texto-no-seleccionado:hover {
        text-decoration: underline;
    }
</style>

<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-person-fill"></i>&nbsp;Usuarios </h3>
        <button type="button" class="btn btn-light waves-effect waves-light" id="btnNuevoUsuario" style="margin-left: auto;">
            Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
        </button>
    </ol>
    <div class="card-body">
        <div class="d-flex justify-content-center align-items-center mb-4">
            <span id="texto_activo" class="texto-seleccionado me-4" style="cursor: pointer;">Colaborador</span>
            <span id="texto_inactivo" class="texto-no-seleccionado" style="cursor: pointer;">Proveedor</span>
        </div>

        <div class="card-body position-relative" id="tabla_activo" style="display: block;">
            <i id="loadingIcon8" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
            <table id="Tablausuarios" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
            </table>
        </div>

        <div class="card-body position-relative" id="tabla_inactivo" style="display: none;">
            <i id="loadingIcon7" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
            <table id="Tablaproveedores" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
            </table>
        </div>
    </div>
</div>








<div class="modal fade" id="modal_usuario" tabindex="-1" aria-labelledby="EXAMPLEMODALLABEL" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="min-width: 1100px!important;">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioUSUARIO" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="EXAMPLEMODALLABEL">Usuario</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-8">
                            <div class="row">
                                <div class="col-6">
                                    <div class="row">
                                        {!! csrf_field() !!}
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>Tipo *</label>
                                                <select class="form-select" id="USUARIO_TIPO" name="USUARIO_TIPO" required>
                                                    <option disabled selected>Seleccione una opción</option>
                                                    <option value="1">Usuario empleado</option>
                                                    <option value="2">Proveedor</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2" id="DIV_INFORMACION" style="display: block;">
                                        <div class="col-12 campo_dato_empleado">
                                            <div class="form-group">
                                                <label>Nombre (s) *</label>
                                                <input type="text" class="form-control" id="EMPLEADO_NOMBRE" name="EMPLEADO_NOMBRE" required>
                                            </div>
                                        </div>
                                        <div class="col-12 campo_dato_empleado">
                                            <div class="form-group">
                                                <label>Apellido paterno *</label>
                                                <input type="text" class="form-control" id="EMPLEADO_APELLIDOPATERNO" name="EMPLEADO_APELLIDOPATERNO" required>
                                            </div>
                                        </div>
                                        <div class="col-12 campo_dato_empleado">
                                            <div class="form-group">
                                                <label>Apellido materno *</label>
                                                <input type="text" class="form-control" id="EMPLEADO_APELLIDOMATERNO" name="EMPLEADO_APELLIDOMATERNO" required>
                                            </div>
                                        </div>
                                        <div class="col-12 campo_dato_empleado">
                                            <div class="form-group">
                                                <label>Curp *</label>
                                                <input type="text" class="form-control" id="CURP" name="CURP" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6" id="DIV_FOTO" style="display: block;">
                                    <div class="form-group">
                                        <label id="FOTO_TITULO">Foto usuario </label>
                                        <style>
                                            .dropify-wrapper {
                                                height: 333 !important;
                                                border-radius: 5px;
                                                box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
                                                text-align: center;
                                            }

                                            .dropify-message p {
                                                font-size: 14px;
                                                margin: 0;
                                            }
                                        </style>
                                        <input type="file" accept="image/jpeg,image/x-png" id="FOTO_USUARIO" name="FOTO_USUARIO" class="dropify" data-allowed-file-extensions="jpg png" data-height="300" data-default-file="" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-12 campo_dato_empleado" id="DIV_DIRRECCION" style="display: block;">
                                    <div class="form-group">
                                        <label>Dirección *</label>
                                        <input type="text" class="form-control" id="EMPLEADO_DIRECCION" name="EMPLEADO_DIRECCION" required>
                                    </div>
                                </div>
                                <div class="col-6 campo_dato_empleado" id="DIV_CARGO" style="display: block;">
                                    <div class="form-group">
                                        <label>Cargo *</label>
                                        <input type="text" class="form-control" id="EMPLEADO_CARGO" name="EMPLEADO_CARGO" required>
                                    </div>
                                </div>
                                <div class="col-6 campo_dato_empleado" id="DIV_TELEFONO" style="display: block;">
                                    <div class="form-group">
                                        <label>Teléfono *</label>
                                        <input type="text" class="form-control" id="EMPLEADO_TELEFONO" name="EMPLEADO_TELEFONO" >
                                    </div>
                                </div>
                                <div class="col-6 campo_dato_empleado" id="DIV_NACIMIENTO" style="display: block;">
                                    <label>Fecha de nacimiento *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="EMPLEADO_FECHANACIMIENTO" name="EMPLEADO_FECHANACIMIENTO" required>
                                    </div>
                                </div>
                                <div class="col-6 campo_dato_empleado mt-2" id="DIV_CORREO" style="display: block;">
                                    <div class="form-group">
                                        <label for="EMPLEADO_CORREO">Correo de acceso *</label>
                                        <input type="text" class="form-control" id="EMPLEADO_CORREO" name="EMPLEADO_CORREO">
                                    </div>
                                </div>


                                <div class="col-6  mt-2" id="DIV_RFC" style="display: none;">
                                    <div class="form-group">
                                        <label>RFC *</label>
                                        <input type="text" class="form-control" id="RFC_PROVEEDOR" name="RFC_PROVEEDOR">
                                    </div>
                                </div>

                                
                                <div class="col-6  mt-2" id="DIV_PROVEDOR" style="display: none;">

                                    <div class="form-group">
                                        <label>Nombre comercial/razón social *</label>
                                        <input type="text" class="form-control" id="NOMBRE_COMERCIAL_PROVEEDOR" name="NOMBRE_COMERCIAL_PROVEEDOR" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-6 mb-3">
                                            <label>Generar contraseña</label>
                                            <button id="btnGENERARCONTRASEÑA" type="button" class="btn btn-primary ml-2 rounded-pill" title="Agregar">
                                                <i class="bi bi-arrow-clockwise"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            
                            <div class="row" id="DIV_CONTRASEÑA">
                                <div class="col-5">
                                    <div class="form-group">
                                        <label>Contraseña *</label>
                                        <input type="password" class="form-control" id="PASSWORD" name="PASSWORD" onkeyup="verificapassword();" required>
                                    </div>
                                </div>
                                <div class="col-1 d-flex align-items-center">
                                    <button type="button" class="btn btn-link p-0 toggle-password" data-toggle="#PASSWORD" style="font-size: 1.5em;">
                                        <i class="bi bi-eye-slash-fill"></i>
                                    </button>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <label>Confirmar Contraseña *</label>
                                        <input type="password" class="form-control" id="PASSWORD_2" name="PASSWORD_2" onkeyup="verificapassword();" required>
                                    </div>
                                </div>
                                <div class="col-1 d-flex align-items-center">
                                    <button type="button" class="btn btn-link p-0 toggle-password" data-toggle="#PASSWORD_2" style="font-size: 1.5em;">
                                        <i class="bi bi-eye-slash-fill"></i>
                                    </button>
                                </div>
                                <div class="col-12 text-center mt-2">
                                    <span id="PASSWORD_MENSAJE" style="display: none; color: red; font-weight: bold;"></span>
                                </div>
                            </div>


                        </div> {{-- fin del col 8 --}}

                        <div class="col-4" id=ROLES_COLABORADOR style="display: block;">
                            <div class="row">
                                <div class="col-12">
                                    <label>[roles] *</label>
                                    <div class="card">
                                        <div class="card-body" style="height: 572px; overflow-x: hidden; overflow-y: auto;">
                                            <style type="text/css">
                                                .tooltip-inner {
                                                    max-width: 320px;
                                                    padding: 6px 8px;
                                                    color: #fff;
                                                    text-align: justify;
                                                    background-color: #000;
                                                    border-radius: 0.25rem;
                                                    line-height: 16px;
                                                }

                                                .switch-container {
                                                    display: flex;
                                                    align-items: center;
                                                    justify-content: flex-start;
                                                    margin-bottom: -5px;
                                                }

                                                .switch-container .form-check {
                                                    margin-right: 10px;
                                                }

                                                .demo-switch-title {
                                                    font-size: 14px;
                                                    color: #444;
                                                }
                                            </style>
                                            <div class="row" id="rol_lista">
                                                @foreach ($roles as $rol)
                                                <div class="col-12 switch-container">
                                                    <div class="form-check form-switch" style="margin-bottom: 10px;">
                                                        <input class="form-check-input checkbox_rol" type="checkbox" id="role_{{ $loop->index }}" name="NOMBRE_ROL[]" value="{{ $rol }}">
                                                        <label class="form-check-label demo-switch-title" for="role_{{ $loop->index }}" style="margin-left: 10px;">{{ $rol }}</label>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> {{-- fin del col 4 --}}





                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarFormUSUARIO">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>














<!-- ============================================================== -->
<!-- MODAL-USUARIO -->
<!-- ============================================================== -->





@endsection