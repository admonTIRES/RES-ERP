@extends('principal.maestralmacen')

@section('contenido')



<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;">&nbsp;Tipos</h3>


        <button type="button" class="btn btn-light waves-effect waves-light " data-bs-toggle="modal" data-bs-target="#miModal_TIPO" style="margin-left: auto;">
            Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
        </button>
    </ol>

    <div class="card-body">
        <table id="Tablatipoinventario" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">

        </table>
    </div>

</div>



<div class="modal fade" id="miModal_TIPO" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioTIPO" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nuevo tipo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="mb-3">
                        <label>Descripción *</label>
                        <input type="text" class="form-control" id="DESCRIPCION_TIPO" name="DESCRIPCION_TIPO" required>
                    </div>

                    <!-- <div class="mb-3">
                        <label>Abreviatura *</label>
                        <input type="text" class="form-control" id="ABREVIATURA_TIPO" name="ABREVIATURA_TIPO" required>
                    </div> -->

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarFormTIPO">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection