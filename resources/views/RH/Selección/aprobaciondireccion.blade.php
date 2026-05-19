@extends('principal.maestra')

@section('contenido')





<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5" style="display: flex; justify-content: center; align-items: center;">
        <h3 style="color: #ffffff; margin: 0;">&nbsp;Aprobar inteligencia laboral</h3>
    </ol>

    <div class="card-body">
        <table id="Tablaprobarinteligencialaboral" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">
        </table>
    </div>
</div>








<div class="modal fade" id="Modal_inteligencia" tabindex="-1" aria-labelledby="InteligenciaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioINTELIGENCIA">

                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Inteligencia Laboral</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}


                    <!-- Semáforo centrado con texto externo y título -->
                    <div class="traffic-light-wrapper">
                        <h3 class="traffic-light-title"><b>Riesgo</b></h3>

                        <div class="traffic-light">
                            <label class="light red">
                                <input type="radio" name="RIESGO_PORCENTAJE" value="40">
                                <span class="label">Alto</span>
                            </label>
                            <label class="light yellow">
                                <input type="radio" name="RIESGO_PORCENTAJE" value="70">
                                <span class="label">Medio</span>
                            </label>
                            <label class="light green">
                                <input type="radio" name="RIESGO_PORCENTAJE" value="100">
                                <span class="label">Bajo</span>
                            </label>
                        </div>
                    </div>



                    <div id="APROBACION_DIRECCION" style="display: block;">


                        <div class="col-12 mt-3">
                            <label class="form-label">Estado de Aprobación</label>
                            <select class="form-control" id="APROBACION_INTELIGENCIA" name="APROBACION_INTELIGENCIA" onchange="cambiarColor()" required>
                                <option value="" selected disabled>Seleccione una opción</option>
                                <option value="Aprobada">Aprobada</option>
                                <option value="Rechazada">Rechazada</option>
                            </select>
                        </div>

                        <div class="col-12 mt-3" id="motivo-aprobacion-container" style="display: block;">
                            <label class="form-label">Motivo de la aprobación *</label>
                            <textarea class="form-control" id="MOTIVO_APROBACION" name="MOTIVO_APROBACION" rows="3" placeholder="Escriba el motivo ..." required></textarea>
                        </div>


                        <div class="col-12 mt-3" id="motivo-rechazo-container" style="display: none;">
                            <label class="form-label">Motivo del rechazo *</label>
                            <textarea class="form-control" id="MOTIVO_RECHAZO" name="MOTIVO_RECHAZO" rows="3" placeholder="Escriba el motivo..." required></textarea>
                        </div>


                        <div class="col-12 mt-3">
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label">Quien aprueba *</label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->EMPLEADO_NOMBRE }} {{ Auth::user()->EMPLEADO_APELLIDOPATERNO }} {{ Auth::user()->EMPLEADO_APELLIDOMATERNO }}" id="QUIEN_APROBO" name="QUIEN_APROBO" readonly>
                                </div>
                            </div>
                        </div>

                    </div>




                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardarFormSeleccionInteligencia">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

















@endsection