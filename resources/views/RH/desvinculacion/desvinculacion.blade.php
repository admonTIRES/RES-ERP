@extends('principal.maestra')

@section('contenido')



<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-person-dash-fill"></i>&nbsp;Desvinculación</h3>


        <button type="button" class="btn btn-light waves-effect waves-light " id="nuevo_desvinculacion" style="margin-left: auto;">
            Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
        </button>
    </ol>

    <div class="card-body">
        <table id="Tabladesvinculacion" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">

        </table>
    </div>

</div>



<div class="modal fade" id="miModal_DESVINCULACION" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioDESVINCULACION" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Desvinculación</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}




                    <div class="mb-3">
                        <label>Nombre del colaborador</label>
                        <select class="custom-select form-control" id="CURP" name="CURP">
                            <option selected disabled>Seleccione un colaborador</option>
                            @foreach ($contratacion as $cat)
                            <option value="{{ $cat->CURP }}">{{ $cat->NOMBRE_COLABORADOR }} {{ $cat->PRIMER_APELLIDO }} {{ $cat->SEGUNDO_APELLIDO }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row  mb-3">
                        <div class="col-12">
                            <label>Fecha desvinculación *</label>
                            <div class="input-group">
                                <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_BAJA" name="FECHA_BAJA" required>
                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>

                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>No adeudo</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="DOCUMENTO_ADEUDO" name="DOCUMENTO_ADEUDO" accept=".pdf" style="width: auto; flex: 1;" required>
                            <button type="button" class="btn btn-light btn-sm ms-2" id="quitar_documento1" style="display:none;">Quitar archivo</button>
                        </div>
                    </div>
                    <div id="DOCUMENTO_ERROR1" class="text-danger" style="display:none;">Por favor, sube un archivo PDF</div>

                    <div class="mb-3">
                        <label>Baja</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="DOCUMENTO_BAJA" name="DOCUMENTO_BAJA" accept=".pdf" style="width: auto; flex: 1;" required>
                            <button type="button" class="btn btn-light btn-sm ms-2" id="quitar_documento2" style="display:none;">Quitar archivo</button>
                        </div>
                    </div>
                    <div id="DOCUMENTO_ERROR2" class="text-danger" style="display:none;">Por favor, sube un archivo PDF</div>


                    <div class="mb-3">
                        <label>Convenio </label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="DOCUMENTO_CONVENIO" name="DOCUMENTO_CONVENIO" accept=".pdf" style="width: auto; flex: 1;" required>
                            <button type="button" class="btn btn-light btn-sm ms-2" id="quitar_documento3" style="display:none;">Quitar archivo</button>
                        </div>
                    </div>
                    <div id="DOCUMENTO_ERROR3" class="text-danger" style="display:none;">Por favor, sube un archivo PDF</div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarDESVINCULACION">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection