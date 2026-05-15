@extends('principal.maestraproveedores')

@section('contenido')


<style>
    .datepicker {
        z-index: 9999 !important;
    }
</style>

<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5" style="display: flex; justify-content: center; align-items: center;">
        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-file-earmark-fill"></i>&nbsp;Cargar Recibo Electrónico de Pago (REP)</h3>
    </ol>

    <div class="card-body">
        <table id="Tablacargarrecp" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
            <i id="loadingIcon1" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
        </table>
    </div>
</div>


<div class="modal fade" id="miModal_factura" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioFACTURA" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Cargar REP</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="row" id="datosFactura">

                        <input type="hidden" id="SUBIR_REP" name="SUBIR_REP" value="1">

                        <input type="hidden" id="TOTAL_FACTURA" name="TOTAL_FACTURA" value="">

                        <div class="col-md-12 mb-3">
                            <label class="form-label"> Recibo Electrónico PDF *</label>
                            <input type="file" class="form-control" name="ARCHIVO_REP" id="ARCHIVO_REP" accept=".pdf" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Recibo Electrónico XML *</label>
                            <input type="file" class="form-control" name="XML_REP" id="XML_REP" accept=".xml" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btnGuardarFactura">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>





@endsection