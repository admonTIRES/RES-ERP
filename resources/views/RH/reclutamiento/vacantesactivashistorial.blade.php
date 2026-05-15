@extends('principal.maestra')

@section('contenido')




<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5" style="display: flex; justify-content: center; align-items: center;">
        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-person-lines-fill"></i>&nbsp;Vacantes - Historial</h3>
    </ol>

    <div class="card-body">
        <table id="Tablapostulacioneshistorial" class="table table-hover bg-white table-bordered text-center w-100 TableCustom"></table>
    </div>
</div>





<div class="modal fade" id="modalFullScreen" tabindex="-1" aria-labelledby="modalFullScreenLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFullScreenLabel">Detalles de postulantes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <!-- Tabs -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="postulante-tab" data-bs-toggle="tab" data-bs-target="#postulante" type="button" role="tab" aria-controls="postulante" aria-selected="true">
                            Postulante <span class="badge bg-danger" id="postulante-count">0</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="preseleccionar-tab" data-bs-toggle="tab" data-bs-target="#preseleccionar" type="button" role="tab" aria-controls="preseleccionar" aria-selected="false">
                            Preseleccionar <span class="badge bg-warning" id="preseleccionar-count">0</span>
                        </button>
                    </li>
                </ul>

                <br>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="postulante" role="tabpanel" aria-labelledby="postulante-tab">
                        <div id="modalContent"></div>
                    </div>
                    <div class="tab-pane fade" id="preseleccionar" role="tabpanel" aria-labelledby="preseleccionar-tab">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>






<div class="modal fade" id="miModal_vacantes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioVACANTES" style="background-color: #ffffff;">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="mb-3">
                        <label>Tipo de vacante *</label>

                        <select class="form-select" id="LA_VACANTES_ES" name="LA_VACANTES_ES" required>
                            <option value="0" disabled selected>Seleccione una opción</option>
                            <option value="Pública">Pública</option>
                            <option value="Privada">Privada</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Categoría</label>
                        <select class="form-control" id="CATEGORIA_VACANTE" name="CATEGORIA_VACANTE" required>
                            <option selected disabled>Seleccione una opción</option>
                            @foreach ($areas as $area)
                            <option value="{{ $area->ID_CATALOGO_CATEGORIA }}">{{ $area->NOMBRE_CATEGORIA }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Descripción de la vacante</label>
                        <textarea name="DESCRIPCION_VACANTE" id="DESCRIPCION_VACANTE" class="form-control" rows="8" placeholder="Escribe la descripción de la vacante aquí" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Lugar de la vacante</label>
                        <input type="text" name="LUGAR_VACANTE" id="LUGAR_VACANTE" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Fecha de expiración de la vacante *</label>
                        <div class="input-group">
                            <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_EXPIRACION" name="FECHA_EXPIRACION" required>
                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Requerimiento de Vacantes:</label>
                        <div id="inputs-container" class="mt-3"></div>
                    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarFormvacantes">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade" id="miModal_VACANTESACT" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioVACANTESACT" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar a vacante</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <!-- <div class="mb-3">
                        <label>Vacante *</label>
                        <select class="form-control" id="VACANTES_ID" name="VACANTES_ID" required>
                            <option selected disabled>Seleccione una opción</option>
                            @foreach($vacantes as $vacante)
                                <option value="{{ $vacante->ID_CATALOGO_VACANTE }}">
                                    {{ $vacante->NOMBRE_CATEGORIA }}
                                </option>
                            @endforeach
                        </select>                
                    </div> -->

                    <div class="mb-3">
                        <label>Vacante *</label>
                        <select class="form-control" id="VACANTES_ID" name="VACANTES_ID" required>
                            <option selected disabled>Seleccione una opción</option>
                            @foreach($vacantes as $vacante)
                            <option value="{{ $vacante->ID_CATALOGO_VACANTE }}">
                                {{ $vacante->NOMBRE_CATEGORIA }} (expira: {{ $vacante->FECHA_EXPIRACION }})
                            </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="mb-3">
                        <label>CURP * </label>
                        <input type="text" class="form-control" id="CURP" name="CURP" required>
                    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarFormVACANTESACT">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>




@endsection