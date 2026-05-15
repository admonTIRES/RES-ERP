@extends('principal.maestraproveedores')

@section('contenido')




<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-person-lines-fill"></i>&nbsp;Información para pago/depósito/transferencia interbancaria</h3>
        <button type="button" class="btn btn-light waves-effect waves-light" id="NUEVA_CUENTA" data-bs-toggle="modal" data-bs-target="#miModal_cuentas" style="margin-left: auto;">
            Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
        </button>
    </ol>



    <div class="card-body">
        <table id="Tablacuentasproveedores" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
            <i id="loadingIcon1" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
        </table>
    </div>
</div>


<div class="modal fade" id="miModal_cuentas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioCuentas" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nueva cuenta</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}

                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tipo de cuenta *</label>
                                    <select class="form-control" name="TIPO_CUENTA" id="TIPO_CUENTA" required>
                                        <option value="" selected disabled>Seleccione una opción</option>
                                        <option value="Ahorros">Ahorros</option>
                                        <option value="Cheques">Cheques</option>
                                        <option value="Extranjera">Extranjera</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nombre del banco *</label>
                                    <input type="text" class="form-control" name="TIPO_BANCO" id="TIPO_BANCO" required>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Nombre del beneficiario *</label>
                                    <input type="text" class="form-control" name="NOMBRE_BENEFICIARIO" id="NOMBRE_BENEFICIARIO" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">No. de cuenta *</label>
                                    <input type="text" class="form-control" name="NUMERO_CUENTA" id="NUMERO_CUENTA" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tipo de moneda *</label>
                                    <input type="text" class="form-control" name="TIPO_MONEDA" id="TIPO_MONEDA" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mb-3" id="CLABE_INTERBANCARIA" style="display: block;">
                            <label class="form-label">CLABE interbancaria *</label>
                            <input type="text" class="form-control" name="CLABE_INTERBANCARIA" id="CLABE_INTERBANCARIA" pattern="\d{18}" maxlength="18" placeholder="Ingrese 18 dígitos" required>
                        </div>

                        <div id="DIV_EXTRAJERO" style="display: none;">


                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Código SWIFT o BIC</label>
                                        <input type="text" class="form-control" name="CODIGO_SWIFT_BIC" id="CODIGO_SWIFT_BIC">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Código ABA</label>
                                        <input type="text" class="form-control" name="CODIGO_ABA" id="CODIGO_ABA">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Dirección del banco *</label>
                                <input type="text" class="form-control" name="DIRECCION_BANCO" id="DIRECCION_BANCO">
                            </div>

                        </div>


                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Ciudad *</label>
                                    <input type="text" class="form-control" name="CIUDAD" id="CIUDAD" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">País *</label>
                                    <input type="text" class="form-control" name="PAIS" id="PAIS" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">
                                Carátula bancaria &nbsp;
                                <i class="bi bi-info-circle-fill" title="Anexar carátula bancaria sin saldo y que aparezcan los datos del beneficiario"></i>
                            </label>
                            <div class="input-group align-items-center">
                                <input type="file" class="form-control" name="CARATULA_BANCARIA" id="CARATULA_BANCARIA" accept="application/pdf" required>
                                <i id="iconEliminarArchivo" class="bi bi-trash-fill ms-2 text-danger fs-5 d-none" style="cursor: pointer;" title="Eliminar archivo"></i>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarCuentas">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>





@endsection