@extends('principal.maestra')

@section('contenido')



<div class="contenedor-contenido">
    <ol class="breadcrumb mb-5">
        <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-briefcase-fill"></i>&nbsp;Rec.Empleados</h3>


        <button type="button" class="btn btn-light waves-effect waves-light " id="NUEVO_RECUROSEMPLEADO" style="margin-left: auto;">
            Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
        </button>
    </ol>

    <div class="card-body">
        <table id="Tablarecempleados" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">

        </table>
    </div>

</div>




<div class="modal fade" id="miModal_RECURSOSEMPLEADOS" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formularioRECURSOSEMPLEADO" style="background-color: #ffffff;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Recursos empleados</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}



                    <div class="col-12 mb-3">
                        <label class="form-label">Seleccione el tipo *</label>
                        <select class="form-control" id="TIPO_SOLICITUD" name="TIPO_SOLICITUD" required>
                            <option value="" selected disabled>Seleccione una opción</option>
                            <option value="1">Aviso de ausencia y/o permiso</option>
                            <option value="2">Salida de almacén de materiales y/o equipos</option>
                            <option value="3">Solicitud de Vacaciones</option>
                        </select>
                    </div>

                    <div class="col-12 mt-3">
                        <div class="row">
                            <div class="col-9">
                                <label class="form-label">Solicitante </label>
                                <input type="text" class="form-control" value="{{ Auth::user()->EMPLEADO_NOMBRE }} {{ Auth::user()->EMPLEADO_APELLIDOPATERNO }} {{ Auth::user()->EMPLEADO_APELLIDOMATERNO }}" id="SOLICITANTE_SALIDA" name="SOLICITANTE_SALIDA" readonly>
                            </div>

                            <div class="col-3">
                                <label class="form-label">Fecha de solicitud *</label>
                                <div class="input-group">
                                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_SALIDA" name="FECHA_SALIDA"
                                        style="pointer-events:none; background-color:#e9ecef;" required >
                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div id="SOLIDA_ALMACEN" style="display: none;">

                        <div id="SOLICITUD_MR">

                            <div class="mt-3">
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label>Agregar material</label>
                                        <button id="botonmaterial" id="botonmaterial" type="button" class="btn btn-danger ml-2 rounded-pill" title="Agregar">
                                            <i class="bi bi-plus-circle-fill"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="materialesdiv mt-4"></div>
                            </div>
                        </div>

                        <div class="col-12 mt-3 d-flex align-items-center">
                            <!-- <label class="col-form-label me-3">¿El material y/o equipo retorna? *</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="MATERIAL_RETORNA_SALIDA" id="radio_si" value="Sí" required>
                                <label class="form-check-label" for="radio_si">Sí</label>
                            </div>
                            <div class="form-check form-check-inline me-3">
                                <input class="form-check-input" type="radio" name="MATERIAL_RETORNA_SALIDA" id="radio_no" value="No" required>
                                <label class="form-check-label" for="radio_no">No</label>
                            </div> -->

                            <div class="col-6" id="FECHA_ESTIMADA" style="display: none;">
                                <label class="col-form-label me-2">Fecha estimada de retorno *</label>
                                <div class="input-group">
                                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd"
                                        id="FECHA_ESTIMADA_SALIDA" name="FECHA_ESTIMADA_SALIDA" required>
                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                </div>
                            </div>
                        </div>


                    </div>


                    <div id="PERMISO_AUSENCIA" style="display: none;">


                        <div class="col-12 mt-3">
                            <div class="row">
                                <div class="col-9">
                                    <label class="form-label">Cargo </label>
                                    <input type="text" class="form-control" id="CARGO_PERMISO" name="CARGO_PERMISO" readonly>
                                </div>

                                <div class="col-3">
                                    <label class="form-label">No. de empleado: </label>
                                    <input type="text" class="form-control" id="NOEMPLEADO_PERMISO" name="NOEMPLEADO_PERMISO" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <div class="row">
                                <div class="col-4">
                                    <label class="form-label">Concepto de ausencia *</label>
                                    <select class="form-control" id="CONCEPTO_PERMISO" name="CONCEPTO_PERMISO" required>
                                        <option value="" selected disabled>Seleccione una opción</option>
                                        <option value="1">Permiso</option>
                                        <option value="2">Incapacidad</option>
                                        <option value="3">Omitir registro en el checador</option>
                                        <option value="4">Fallecimiento</option>
                                        <option value="5">Matrimonio</option>
                                        <option value="6">Permiso de maternidad</option>
                                        <option value="7">Permiso de paternidad</option>
                                        <option value="8">Compensatorio </option>
                                        <option value="9">Otros (explique)</option>
                                    </select>
                                </div>

                                <div class="col-1">
                                    <label class="form-label">No. días </label>
                                    <input type="number" class="form-control" id="NODIAS_PERMISO" name="NODIAS_PERMISO">
                                </div>

                                <div class="col-1">
                                    <label class="form-label">No. horas </label>
                                    <input type="number" class="form-control" id="NOHORAS_PERMISO" name="NOHORAS_PERMISO">
                                </div>





                                <div class="col-3">
                                    <label class="form-label">Fecha inicial *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_INICIAL_PERMISO" name="FECHA_INICIAL_PERMISO" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>



                                <div class="col-3">
                                    <label class="form-label">Fecha Final *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_FINAL_PERMISO" name="FECHA_FINAL_PERMISO" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>


                                <div class="col-12 mt-3" id="EXPLIQUE_PERMISO" style="display: none;">
                                    <label class="form-label">Exlique </label>
                                    <textarea class="form-control" id="EXPLIQUE_PERMISO" name="EXPLIQUE_PERMISO" rows="2"></textarea>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div id="SOLICITUD_VACACIONES" style="display: none;">

                        <div class="col-12 mt-3">
                            <div class="row">
                                <div class="col-4">
                                    <label class="form-label">Área o Departamento: </label>
                                    <input type="text" class="form-control" id="AREA_VACACIONES" name="AREA_VACACIONES" readonly>
                                </div>
                                <div class="col-4">
                                    <label class="form-label">No. de empleado: </label>
                                    <input type="text" class="form-control" id="NOEMPLEADO_PERMISO_VACACIONES" name="NOEMPLEADO_PERMISO_VACACIONES" readonly>
                                </div>


                                <div class="col-4">
                                    <label class="form-label">Fecha Ingreso: </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_INGRESO_VACACIONES" name="FECHA_INGRESO_VACACIONES" required readonly>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>

                                <div class="col-3 mt-3">
                                    <label class="form-label">Año de servicio </label>
                                    <input type="number" class="form-control" id="ANIO_SERVICIO_VACACIONES" name="ANIO_SERVICIO_VACACIONES" required>
                                </div>


                                <div class="col-3 mt-3">
                                    <label class="form-label">Días que corresponden</label>
                                    <input type="number" class="form-control" id="DIAS_CORRESPONDEN_VACACIONES" name="DIAS_CORRESPONDEN_VACACIONES" required>
                                </div>


                                <div class="col-3 mt-3">
                                    <label class="form-label">Días a disfrutar</label>
                                    <input type="number" class="form-control" id="DIAS_DISFRUTAR_VACACIONES" name="DIAS_DISFRUTAR_VACACIONES" required>
                                </div>

                                <div class="col-3 mt-3">
                                    <label class="form-label">Días Pendientes</label>
                                    <input type="number" class="form-control" id="DIAS_PENDIENTES_VACACIONES" name="DIAS_PENDIENTES_VACACIONES" required readonly>
                                </div>

                                <input type="hidden" id="DIAS_TOMADOS_ANTERIORES" name="DIAS_TOMADOS_ANTERIORES">

                                <div class="col-12 mt-3">
                                    <h5 class="text-center">Período a Disfrutar:</h5>
                                </div>


                                <div class="col-4 mt-3">
                                    <label class="form-label">Desde Año: </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="DESDE_ANIO_VACACIONES" name="DESDE_ANIO_VACACIONES" required readonly>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>

                                <div class="col-4 mt-3">
                                    <label class="form-label">Hasta el Año: </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="HASTA_ANIO_VACACIONES" name="HASTA_ANIO_VACACIONES" required readonly>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>



                                <div class="col-4 mt-3">
                                    <label class="form-label">Fecha de inicio vacaciones: </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_INICIO_VACACIONES" name="FECHA_INICIO_VACACIONES" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>





                            </div>
                        </div>

                    </div>

                    <div class="mt-3">
                        <label>Observaciones *</label>
                        <textarea class="form-control" id="OBSERVACIONES_REC" name="OBSERVACIONES_REC" rows="3" required></textarea>
                    </div>


                    <!-- Botón de firma -->
                    <div class="col-12 mt-3" id="DIV_FIRMAR" style="display:block; margin-top:10px;">
                        <div class="row justify-content-center">
                            <div class="col-6 text-center">
                                <button type="button"
                                    id="FIRMAR_SOLICITUD"
                                    class="btn btn-info"
                                    data-usuario="{{ Auth::user()->EMPLEADO_NOMBRE }} {{ Auth::user()->EMPLEADO_APELLIDOPATERNO }} {{ Auth::user()->EMPLEADO_APELLIDOMATERNO }}">
                                    <i class="bi bi-pen-fill"></i> Firmar solicitud
                                </button>
                            </div>
                        </div>
                    </div>



                    <input type="hidden" id="FIRMO_USUARIO" name="FIRMO_USUARIO" value="">

                    <div class="mt-3">
                        <label class="form-label">Firmado por</label>
                        <input type="text" id="FIRMADO_POR" name="FIRMADO_POR" class="form-control" readonly required>
                    </div>

                    <div id="VISTO_BUENO_JEFE" style="display: none;">

                        <div class="col-12 mt-3 text-center">
                            <label class="form-label">Vo.Bo Jefe Inmediato</label>
                            <div id="estado-container" class="p-2 rounded">
                                <select class="form-control" id="DAR_BUENO" name="DAR_BUENO" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="1">Aprobada</option>
                                    <option value="2">Rechazada</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-12 mt-3">
                            <div class="row">
                                <div class="col-8">
                                    <label class="form-label">Visto bueno</label>

                                    <input type="text" class="form-control" id="VISTO_BUENO" name="VISTO_BUENO" readonly>
                                </div>

                                <div class="col-4">
                                    <label class="form-label">Fecha *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_VISTO_SOLICITUD" name="FECHA_VISTO_SOLICITUD" required>
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-12 mt-3" id="MOTIVO_RECHAZO_JEFE_DIV" style="display: none;">
                            <label class="form-label">Motivo del rechazo del jefe inmediato</label>
                            <textarea class="form-control" id="MOTIVO_RECHAZO_JEFE" name="MOTIVO_RECHAZO_JEFE" rows="3" placeholder="Escriba el motivo de rechazo..."></textarea>
                        </div>

                    </div>





                    <div id="APROBACION_DIRECCION" style="display: none;">
                        <div class="col-12 mt-3">
                            <label for="ESTADO_APROBACION">Estado de Aprobación</label>
                            <div id="estado-container" class="p-2 rounded">
                                <select class="form-control" id="ESTADO_APROBACION" name="ESTADO_APROBACION">
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="Aprobada">Aprobada</option>
                                    <option value="Rechazada">Rechazada</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-12 mt-3" id="motivo-rechazo-container" style="display: none;">
                            <label>Motivo del rechazo del que aprobo</label>
                            <textarea class="form-control" id="MOTIVO_RECHAZO" name="MOTIVO_RECHAZO" rows="3" placeholder="Escriba el motivo de rechazo..."></textarea>
                        </div>


                        <div class="col-12 mt-3">
                            <div class="row">

                                <div class="col-8">
                                    <label for="APROBACION">Quien aprueba</label>
                                    <input type="text" class="form-control" id="QUIEN_APROBACION" name="QUIEN_APROBACION">
                                </div>
                                <div class="col-4">
                                    <label>Fecha *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_APRUEBA_SOLICITUD" name="FECHA_APRUEBA_SOLICITUD">
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="col-12 mt-3" id="DIV_FIRMA_ALMACENISTA" style="display: none;">
                        <div class="row">

                            <div class="col-8">
                                <label for="APROBACION">Firma almacenista</label>
                                <input type="text" class="form-control" id="FIRMA_ALMACEN" name="FIRMA_ALMACEN" readonly>
                            </div>
                            <div class="col-4">
                                <label>Fecha *</label>
                                <div class="input-group">
                                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_ALMACEN_SOLICITUD" name="FECHA_ALMACEN_SOLICITUD">
                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                </div>
                            </div>
                        </div>


                        <input type="hidden" id="FIRMO_ALMACENISTA" name="FIRMO_ALMACENISTA" value="">



                    </div>

                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="guardaRECEMPLEADOS" style="display: block;">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>






<div class="modal fade" id="modalDiasTomados" tabindex="-1" aria-labelledby="modalDiasTomadosLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDiasTomadosLabel">Días ya tomados</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <label for="inputDiasTomados" class="form-label">Ingrese cuántos días ha tomado anteriormente:</label>
                <input type="number" id="inputDiasTomados" class="form-control" placeholder="Ejemplo: 6" min="0" step="1">
                <div id="mensajeErrorDias" class="text-danger mt-2" style="display:none;">
                    No puede superar los días que corresponden.
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnGuardarDiasTomados">Aceptar</button>
            </div>
        </div>
    </div>
</div>


@endsection