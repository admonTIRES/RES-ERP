@extends('principal.maestracompras')

@section('contenido')



<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;">&nbsp;Título </h3>
        <button type="button" class="btn btn-light waves-effect waves-light " data-bs-toggle="modal" data-bs-target="#miModal_titulos" style="margin-left: auto;">
            Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
        </button>
    </ol>

    <div class="card-body">
        <table id="Tablatitulocontacto" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
        </table>
    </div>
</div>



<div class="modal fade" id="miModal_titulos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioTITULO" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar título</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="mb-3">
                        <label>Nombre *</label>
                        <input type="text" class="form-control" id="NOMBRE_TITULO" name="NOMBRE_TITULO" required>
                    </div>
                    <div class="mb-3">
                        <label>Abreviatura *</label>
                        <input type="text" class="form-control" id="ABREVIATURA_TITULO" name="ABREVIATURA_TITULO" required>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarTITULOS">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection