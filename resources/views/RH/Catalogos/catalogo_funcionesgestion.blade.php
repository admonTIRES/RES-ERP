@extends('principal.maestra')

@section('contenido')




<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
    <h3 style="color: #ffffff; margin: 0;">&nbsp;Funciones y responsabilidades del sistema integrado de gestión (SIG)</h3>


        <button type="button" class="btn btn-light waves-effect waves-light botonnuevo_jerarquia" data-bs-toggle="modal" data-bs-target="#miModal_FUNCIONESGESTION" style="margin-left: auto;">
            Nuevo  &nbsp;<i class="bi bi-plus-circle"></i>
        </button>
    </ol>

    <div class="card-body">
        <table id="Tablafuncionesgestion" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">

        </table>
    </div>
</div>


    <div class="modal fade" id="miModal_FUNCIONESGESTION" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" enctype="multipart/form-data" id="formularioFUNCIONESGESTION" style="background-color: #ffffff;">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Funciones y responsabilidades del sistema integrado de gestión (SIG)</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {!! csrf_field() !!}
                        <div class="mb-3">
                            <label class="col-form-label">Función destinada a *</label>
                            <div class="d-flex">
                                <div class="form-check me-3">
                                    <label class="form-check-label" for="director">Director</label>
                                    <input class="form-check-input" type="checkbox" name="DIRECTOR_GESTION" id="director" value="Director">
                                </div>
                                <div class="form-check me-3 mx-4">
                                    <label class="form-check-label" for="lider">Líder categoría</label>
                                    <input class="form-check-input" type="checkbox" name="LIDER_GESTION" id="lider" value="Líder">
                                </div>
                                <div class="form-check me-3 mx-4">
                                    <label class="form-check-label" for="colaborador">Colaborador</label>
                                    <input class="form-check-input" type="checkbox" name="COLABORADOR_GESTION" id="colaborador" value="Colaborador">
                                </div>
                                <div class="form-check me-3 mx-4">
                                    <label class="form-check-label" for="todo">Todos </label>
                                    <input class="form-check-input" type="checkbox" name="TODO_GESTION" id="todo" value="Todo">
                                </div>
                                
                            </div>
                        
                        <div class="row mb-3">
                            <div class="col-12 mt-3 ">
                                <label><b>Nota:</b> brevemente describa las responsabilidades del puesto, enlistando las actividades en orden de importancia. Utilizar verbos en infinitivo como: elaborar, validar, actualizar, enviar, atender, mantener, administrar, entre otros.</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Descripción de la función *</label>
                            <textarea class="form-control" id="descripcion-funcion" name="DESCRIPCION_FUNCION_GESTION" rows="8" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success" id="guardarFormFuncionesgestion">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    

@endsection