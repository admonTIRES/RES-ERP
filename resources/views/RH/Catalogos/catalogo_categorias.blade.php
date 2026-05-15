@extends('principal.maestra')

@section('contenido')




<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;">&nbsp;Nueva Categoría</h3>


        <button type="button" class="btn btn-light waves-effect waves-light " data-bs-toggle="modal" data-bs-target="#miModal_categoria" style="margin-left: auto;">
            Nueva &nbsp;<i class="bi bi-plus-circle"></i>
        </button>
    </ol>

    <div class="card-body">
        <table id="Tablacategoria" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">

        </table>
    </div>
</div>


<div class="modal fade" id="miModal_categoria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioCATEGORIAS" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nueva Categoría</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="mb-3">
                        <label>Nombre de la categoría *</label>
                        <input type="text" class="form-control" id="NOMBRE_CATEGORIA" name="NOMBRE_CATEGORIA" required />
                    </div>
                    <div class="mb-3">
                        <label>Lugar de trabajo *</label>
                        <input type="text" class="form-control" id="LUGAR_CATEGORIA" name="LUGAR_CATEGORIA" required />
                    </div>
                    <div class="mb-3 mt-3">
                        <label>Propósito o finalidad de la categoría *</label>
                        <textarea name="PROPOSITO_CATEGORIA" id="PROPOSITO_CATEGORIA" class="form-control" rows="8" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="mt-2">Es líder</label>

                    </div>
                    <div class="mb-3">
                        <label for="LIDER_SI">Si</label>
                        <input class="mx-2" type="radio" id="LIDER_SI" name="ES_LIDER_CATEGORIA" value="1" required>
                        <label for="LIDER_NO">No</label>
                        <input class="mx-2" type="radio" id="LIDER_NO" name="ES_LIDER_CATEGORIA" value="0">
                    </div>
                    <div id="pruebas-contenedor">
                        <div class="mb-3">
                            <label>Agregar pruebas</label>
                            <button id="botonAgregarprueba" type="button" class="btn btn-danger ml-2 rounded-pill" title="Agregar prueba"><i class="bi bi-plus-circle-fill"></i></button>
                            <div id="inputs-prueba" class="mt-3"></div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarFormcategorias">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>




<script>
    var pruebas = @json($pruebas);
</script>



@endsection