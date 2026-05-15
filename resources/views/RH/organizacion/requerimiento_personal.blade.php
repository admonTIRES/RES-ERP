@extends('principal.maestra')

@section('contenido')



<div class="contenedor-contenido">
  <ol class="breadcrumb mb-5" style="display: flex; justify-content: center; align-items: center;">
    <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-file-earmark-fill"></i>&nbsp;Requisición de personal</h3>

  </ol>

  <div class="card-body">
    <table id="Tablarequerimiento" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">

    </table>
  </div>


</div>

<div class="modal modal-fullscreen fade" id="miModal_REQUERIMIENTO" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form method="post" enctype="multipart/form-data" id="formularioRP" style="background-color: #ffffff;">
        <div class="modal-header">
          <h5 class="modal-title" id="miModalLabel">Requisición de personal</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          {!! csrf_field() !!}
          <div class="row">

            <div class="row mb-3">

              <div class="mb-3" id="BOTON_2024" style="display: none;">

                <span class="mb-3 text-danger col-7"><i class="bi bi-info-circle"></i>&nbsp; Si la requisición de personal se realizó antes del 2024-11-01</span>
                <button type="button" class="btn btn-info col-2" id="PRESIONAR_AQUI">Presione aquí</button>
              </div>

              <input type="hidden" class="form-control" id="ANTES_DE1" name="ANTES_DE1" value="0">
            </div>
            <div id="MOSTRAR_TODO" style="display: block">


              <div class="row mb-3 mt-4">
                <div class="col-4">
                  <label>Fecha *</label>
                  <div class="input-group">
                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_RP" name="FECHA_RP" required style="pointer-events:none; background-color:#e9ecef;">
                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-group">
                    <label>Prioridad:</label>
                    <select class="form-control" id="PRIORIDAD_RP" name="PRIORIDAD_RP" required>
                      <option selected disabled>Seleccione una opción</option>
                      <option value="Normal">Normal</option>
                      <option value="Urgente">Urgente</option>
                    </select>
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-group">
                    <label>Tipo de vacante:</label>
                    <select class="form-control" id="TIPO_VACANTE_RP" name="TIPO_VACANTE_RP" required>
                      <option selected disabled>Seleccione una opción</option>
                      @foreach ($tipos as $tipo)
                      <option value="{{ $tipo->NOMBRE_TIPOVACANTE }}">{{ $tipo->NOMBRE_TIPOVACANTE }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-4">
                  <div class="form-group">
                    <label>Motivo de la vacante:</label>
                    <select class="form-control" id="MOTIVO_VACANTE_RP" name="MOTIVO_VACANTE_RP" required>
                      <option selected disabled>Seleccione una opción</option>
                      @foreach ($motivos as $motivo)
                      <option value="{{ $motivo->NOMBRE_MOTIVO_VACANTE }}">{{ $motivo->NOMBRE_MOTIVO_VACANTE }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-8">
                  <div class="form-group">
                    <label>Área: </label>
                    <select class="form-control" id="AREA_RP" name="AREA_RP" required>
                      <option selected disabled>Seleccione una opción</option>
                      @foreach ($areas as $area)
                      <option value="{{ $area->ID_AREA }}">{{ $area->NOMBRE }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-6">
                  <label>Sustituye a: </label>
                  <input type="text" class="form-control " id="SUSTITUYE_RP" name="SUSTITUYE_RP">
                </div>
                <div class="col-6">
                  <label>Categoría a sustituir</label>
                  <select class="form-control" id="SUSTITUYE_CATEGORIA_RP" name="SUSTITUYE_CATEGORIA_RP">
                    <option selected disabled>Seleccione una opción</option>
                    <option value="N/A">N/A</option>
                    @foreach ($todascategoria as $cat)
                    <option value="{{ $cat->ID_CATALOGO_CATEGORIA }}">{{ $cat->NOMBRE }}</option>
                    @endforeach
                  </select>

                </div>
              </div>

              <div class="row mb-3">

                <div class="col-2 text-center">
                  <div class="form-group">
                    <label>No. de vacantes</label>
                    <input type="number" class="form-control " id="NO_VACANTES_RP" name="NO_VACANTES_RP" required>
                  </div>
                </div>
                <div class="col-1">
                  <label></label>
                </div>
                <div class="col-4 text-center">
                  <div class="form-group">
                    <label>Categoría</label>
                    <select class="form-control" id="PUESTO_RP" name="PUESTO_RP" required>
                      <option selected disabled>Seleccione una opción</option>
                      @foreach ($categoria as $cat)
                      <option value="{{ $cat->ID_DEPARTAMENTO_AREA }}">{{ $cat->NOMBRE }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-1">
                  <label></label>
                </div>
                <div class="col-4 text-center">
                  <label>Fecha de inicio *</label>
                  <div class="input-group">
                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_INICIO_RP" name="FECHA_INICIO_RP" required>
                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-12">
                  <div class="form-group">
                    <h4><b>Observaciones</b></h4>
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <div class="input-group mb-3">
                  <span class="input-group-text" id="basic-addon1">1.-</span>
                  <input type="text" class="form-control" id="OBSERVACION1_RP" name="OBSERVACION1_RP">
                </div>
              </div>
              <div class="row mb-3">
                <div class="input-group mb-3">
                  <span class="input-group-text" id="basic-addon1">2.-</span>
                  <input type="text" class="form-control" id="OBSERVACION2_RP" name="OBSERVACION2_RP">
                </div>
              </div>
              <div class="row mb-3">
                <div class="input-group mb-3">
                  <span class="input-group-text" id="basic-addon1">3.-</span>
                  <input type="text" class="form-control" id="OBSERVACION3_RP" name="OBSERVACION3_RP">
                </div>
              </div>
              <div class="row mb-3">
                <div class="input-group mb-3">
                  <span class="input-group-text" id="basic-addon1">4.-</span>
                  <input type="text" class="form-control" id="OBSERVACION4_RP" name="OBSERVACION4_RP">
                </div>
              </div>
              <div class="row mb-3">
                <div class="input-group mb-3">
                  <span class="input-group-text" id="basic-addon1">5.-</span>
                  <input type="text" class="form-control" id="OBSERVACION5_RP" name="OBSERVACION5_RP">
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-5">
                  <label>¿El colaborador utilizará correo electrónico corporativo? </label>
                </div>
                <div class="col-4">
                  <div class="form-check form-check-inline">
                    <label class="form-check-label" for="CORREO_SI">Si</label>
                    <input class="form-check-input" type="radio" name="CORREO_CORPORATIVO_RP" id="CORREO_SI" value="si">
                  </div>
                  <div class="form-check form-check-inline">
                    <label class="form-check-label" for="CORREO_NO">No</label>
                    <input class="form-check-input" type="radio" name="CORREO_CORPORATIVO_RP" id="CORREO_NO" value="no">
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-5">
                  <label>¿El colaborador utilizará teléfono celular corporativo? </label>
                </div>
                <div class="col-2">
                  <div class="form-check form-check-inline">
                    <label class="form-check-label" for="TELEFONO_SI">Si</label>
                    <input class="form-check-input" type="radio" name="TELEFONO_CORPORATIVO_RP" id="TELEFONO_SI" value="si">
                  </div>
                  <div class="form-check form-check-inline">
                    <label class="form-check-label" for="TELEFONO_NO">No</label>
                    <input class="form-check-input" type="radio" name="TELEFONO_CORPORATIVO_RP" id="TELEFONO_NO" value="no">
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-5">
                  <label>¿El colaborador necesita acceso a software de la empresa? </label>
                </div>
                <div class="col-2">
                  <div class="form-check form-check-inline">
                    <label class="form-check-label" for="SOFTWARE_SI">Si</label>
                    <input class="form-check-input" type="radio" name="SOFTWARE_RP" id="SOFTWARE_SI" value="si">
                  </div>
                  <div class="form-check form-check-inline">
                    <label class="form-check-label" for="SOFTWARE_NO">No</label>
                    <input class="form-check-input" type="radio" name="SOFTWARE_RP" id="SOFTWARE_NO" value="no">
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-5">
                  <label>¿El colaborador conducirá vehículo de la empresa? </label>
                </div>
                <div class="col-2">
                  <div class="form-check form-check-inline">
                    <label class="form-check-label" for="VEHICULO_SI">Si</label>
                    <input class="form-check-input" type="radio" name="VEHICULO_EMPRESA_RP" id="VEHICULO_SI" value="si">
                  </div>
                  <div class="form-check form-check-inline">
                    <label class="form-check-label" for="VEHICULO_NO">No</label>
                    <input class="form-check-input" type="radio" name="VEHICULO_EMPRESA_RP" id="VEHICULO_NO" value="no">
                  </div>
                </div>
              </div>




              <div class="row mb-3">
                <div class="col-12">
                  <label>Nombre del solicitante *</label>
                  <input type="text" class="form-control " id="NOMBRE_SOLICITA_RP" name="NOMBRE_SOLICITA_RP" readonly>
                </div>
              </div>


              <div class="mb-3 mt-2">
                <div class="row">
                  <div class="col-12">
                    <div class="form-group">
                      <label> Estado de aprobación:</label>
                      <select class="form-control" id="ESTADO_SOLICITUD" name="ESTADO_SOLICITUD" required>
                        <option selected disabled>Seleccione una opción</option>
                        <option value="Aprobada">Aprobada</option>
                        <option value="Rechazada">Rechazada</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-6 mt-2">
                    <label>Quien aprobó/rechazo *</label>
                    <input type="text" class="form-control " id="NOMBRE_APROBO_RP" readonly>
                  </div>
                  <div class="col-6 mt-2">
                    <label>Fecha de aprobación*</label>
                    <div class="input-group">
                      <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_APROBO_RP" name="FECHA_APROBO_RP"
                        style="pointer-events:none; background-color:#e9ecef;" required>
                      <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                    </div>
                  </div>
                </div>
              </div>



              <div class="mb-3 mt-2" id="DIV_APROBACION_RECHAZO" style="display: none;">
                <div class="row">
                  <div class="col-12">
                    <div class="form-group">
                      <label>Motivo del rechazo</label>
                      <textarea class="form-control" id="MOTIVO_RECHAZO_RP" name="MOTIVO_RECHAZO_RP" rows="3" placeholder="Escriba el motivo de rechazo..."></textarea>
                    </div>
                  </div>
                </div>
              </div>


            </div>


            <div id="MOSTRAR_ANTES" style="display: none">
              <div class="row mb-3 mt-4">

                <div class="col-4">
                  <div class="form-group">
                    <label class="form-label text-center">Categoría</label>
                    <select class="form-control" id="PUESTO_RP" name="PUESTO_RP">
                      <option value="0" selected disabled>Seleccione una opción</option>
                      @foreach ($areas1 as $area2)
                      <option value="{{ $area2->ID }}">{{ $area2->NOMBRE }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-4">
                  <label class="form-label text-center">Documento*</label>
                  <div class="input-group">
                    <input type="file" class="form-control" id="DOCUMENTO_REQUISICION" name="DOCUMENTO_REQUISICION" accept=".pdf">
                    <button type="button" class="btn btn-light btn-sm ms-2" id="quitarformato" style="display:none;">Quitar archivo</button>
                  </div>
                  <small id="errorArchivo" class="text-danger" style="display:none;">El archivo debe ser un PDF.</small>
                </div>

                <div class="col-4 text-center">
                  <label class="form-label text-center">Fecha de creación *</label>
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="aaaa-mm-dd" id="FECHA_CREACION" name="FECHA_CREACION" required>
                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                  </div>
                </div>
              </div>
            </div>











          </div>
          <div class="modal-footer mx-5">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-success" id="guardarFormRP"><i class="bi bi-floppy-fill" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Guardar Requisición de personal"></i> Guardar</button>
          </div>
      </form>
    </div>
  </div>
</div>











<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/th">
</script>





@endsection