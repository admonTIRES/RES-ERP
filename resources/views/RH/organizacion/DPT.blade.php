@extends('principal.maestra')

@section('contenido')




<div class="contenedor-contenido">
  <ol class="breadcrumb mb-5">
    <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-file-earmark-fill"></i>&nbsp;Descripción del puesto de trabajo&nbsp;(DPT)</h3>


    <button type="button" class="btn btn-light waves-effect waves-light botonnuevo_ppt" id="nuevo_dpt" style="margin-left: auto;">
      Nuevo DPT &nbsp;<i class="bi bi-plus-circle"></i>
    </button>
  </ol>

  <div class="card-body">
    <table id="TablaDPT" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">

    </table>
  </div>

</div>





<!-- MODAL  -->
<div class="modal modal-fullscreen fade" id="miModal_DPT" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <form method="post" enctype="multipart/form-data" id="formularioDPT" style="background-color: #ffffff;">
        <div class="modal-header">
          <h5 class="modal-title" id="miModalLabel">Descripción del puesto de trabajo &nbsp;(DPT)</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          {!! csrf_field() !!}
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label>Nombre de la categoría *</label>
                <select class="form-control" id="DEPARTAMENTOS_AREAS_ID" name="DEPARTAMENTOS_AREAS_ID" required>
                  <option value="0" disabled selected>Seleccione una opción</option>
                  @foreach ($areas1 as $area)
                  <option value="{{ $area->ID }}" data-lugar="{{ $area->LUGAR}}" data-proposito="{{ $area->PROPOSITO }}" data-lider="{{ $area->LIDER }}">{{ $area->NOMBRE }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-6">
              <div class="form-group">
                <label>Lugar de trabajo </label>
                <input type="text" class="form-control" id="AREA_TRABAJO_DPT" name="AREA_TRABAJO_DPT" readonly>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-12 mt-3">
                <div class="form-group">
                  <label>Propósito o finalidad del puesto</label>
                  <textarea class="form-control" id="PROPOSITO_FINALIDAD_DPT" name="PROPOSITO_FINALIDAD_DPT" rows="3" readonly></textarea>
                </div>
              </div>
            </div>
            <!-- I. Estructura organizacional -->
            <div class="row mb-3">
              <div class="col-12 text-center">
                <h4>I. Estructura organizacional</h4>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-2">
                <label>Nivel jerárquico del puesto</label>
              </div>
              <div class="col-4">
                <div class="form-group">
                  <select class="form-control" id="NIVEL_JERARQUICO_DPT" name="NIVEL_JERARQUICO_DPT" required>
                    <option value="0" disabled selected>Seleccione una opción</option>
                    @foreach ($nivel as $niveles)
                    <option value="{{ $niveles->ID_CATALOGO_JERARQUIA }}" data-descripcion="{{ $niveles->DESCRIPCION_JERARQUIA }}">{{ $niveles->NOMBRE_JERARQUIA }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-2">
                <label>Puesto al que reporta</label>
              </div>
              <div class="col-4">
                <div class="form-group">
                  <input type="text" class="form-control" id="PUESTO_REPORTA_DPT" name="PUESTO_REPORTA_DPT" readonly>
                </div>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-2">
                <label>Descripción del nivel jerárquico</label>
              </div>
              <div class="col-10">
                <p id="DESCRIPCION_NIVEL_JERARQUICO"></p>
              </div>
            </div>


            <div class="row mb-3">
              <div class="col-2">
                <label>Puestos que le reportan </label>
              </div>
              <div class="col-10">
                <div class="form-group">
                  <input type="text" class="form-control" id="PUESTO_LE_REPORTAN_DPT" name="PUESTO_LE_REPORTAN_DPT" readonly>
                </div>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-2">
                <label for="puestos-interactuan" class="form-label">Puestos que interactúan</label>
              </div>

              <div class="col-10">
                <select class="custom-select form-control" id="PUESTOS_INTERACTUAN_DPT" name="PUESTOS_INTERACTUAN_DPT[]"  multiple>
                  <option selected disabled></option>
                  @foreach ($categorias as $cat)
                  <option value="{{ $cat->ID }}-{{$cat->LIDER}}">{{ $cat->NOMBRE }}</option>
                  @endforeach
                </select>
              </div>



            </div>
            <div class="row mb-3">
              <div class="col-4">
                <label for="directos" class="form-label">Directos</label>
                <input type="text" id="PUESTOS_DIRECTOS_DPT" name="PUESTOS_DIRECTOS_DPT" class="form-control" readonly >
              </div>
              <div class="col-4">
                <label for="indirectos" class="form-label">Indirectos</label>
                <input type="text" id="PUESTOS_INDIRECTOS_DPT" name="PUESTOS_INDIRECTOS_DPT" class="form-control"  readonly>
              </div>
              <div class="col-4 mt-4">
                <label for="disponibilidad-viajar" class="form-label ml-5">Disponibilidad para viajar</label>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="DISPONIBILIDAD_VIAJAR" id="DISPONIBILIDAD_CUMPLE_SI" value="si">
                  <label class="form-check-label" for="DISPONIBILIDAD_CUMPLE_SI">Si</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="DISPONIBILIDAD_VIAJAR" id="DISPONIBILIDAD_CUMPLE_NO" value="no">
                  <label class="form-check-label" for="DISPONIBILIDAD_CUMPLE_NO">No</label>
                </div>
              </div>
            </div>


            <div class="row mb-3">
              <div class="col-2">
                <label>&nbsp;&nbsp;Horario de entrada</label>
              </div>
              <div class="col-2 ">
                <input type="time" id="HORARIO_ENTRADA_DPT" name="HORARIO_ENTRADA_DPT" class="form-control text-center" required>
              </div>
              <div class="col-2">
                <label>&nbsp;&nbsp;Horario de salida</label>
              </div>
              <div class="col-2">
                <input type="time" id="HORARIO_SALIDA_DPT" name="HORARIO_SALIDA_DPT" class="form-control text-center" required>
              </div>
              <div class="col-1">
                <label>Horas de comida</label>
              </div>
              <div class="col-2">
                <input type="number" id="HORARIO_SALIDA_DPT" name="HORAS_COMIDA_PPT" class="form-control text-center" required>
              </div>
            </div>

            <!-- II. Funciones y responsabilidades clave del cargo -->
            <div class="row mb-3">
              <div class="col-12 text-center">
                <h4>II. Funciones y responsabilidades clave del cargo</h4>
              </div>
            </div>

           <div class="row mb-3">
              <table class="table-sm" style="width: 96%; table-layout: fixed;">
                  <thead>
                      <tr>
                          <th class="header" style="width: 70%;">Descripción</th>
                          <th class="header" style="width: 30%;">Activar/Desactivar</th>
                      </tr>
                  </thead>
                  <tbody id="tbodyFucnionesCargo"></tbody>
              </table>
          </div>



            <!-- III. Funciones y responsabilidades del sistema integrado de gestión (SIG) -->
            <div class="row mb-3">
              <div class="col-12 text-center">
                <h4>III. Funciones y responsabilidades del sistema integrado de gestión (SIG)</h4>
              </div>
            </div>

            <div class="row mb-3">
              <table class="table-sm" style="width: 96%; table-layout: fixed;">
                  <thead>
                      <tr>
                          <th class="header" style="width: 70%;">Descripción</th>
                          <th class="header" style="width: 30%;">Activar/Desactivar</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($gestion as $gestiones)
                      <tr>
                          <td id="desc-gestion-{{ $gestiones->ID_CATALOGO_FUNCIONESGESTION }}" class="description blocked">
                              {{ $gestiones->DESCRIPCION_FUNCION_GESTION }}
                          </td>
                          <td>
                              <div class="switch-container">
                                  <label class="switch">
                                      <input type="checkbox" class="toggle-switch-cargo" name="FUNCIONES_GESTION_DPT[]" value="{{ $gestiones->ID_CATALOGO_FUNCIONESGESTION }}">
                                      <span class="slider"></span>
                                  </label>
                              </div>
                          </td>
                      </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>



            <!-- IV. Relaciones internas estratégicas -->
            <div class="row mb-3">
              <div class="col-12 text-center">
                <h4>IV. Relaciones internas estratégicas</h4>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-12">
                <table class="table">
                  <thead>
                    <tr>
                      <th style="width: 30%;" class="text-center">Con quién (área y/o puesto en la empresa)</th>
                      <th style="width: 30%;" class="text-center">Para qué (acción concreta)</th>
                      <th colspan="5" class="text-center" style="width: 10%;">Frecuencia</th>
                    </tr>
                    <tr>
                      <th></th>
                      <th></th>
                      <th style="width: 50%;"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <select class="form-control area-select" id="INTERNAS_CONQUIEN1_DPT" name="INTERNAS_CONQUIEN_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          @foreach ($areas as $area)
                          <option value="{{ $area->ID }}">{{ $area->NOMBRE }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <textarea class="form-control" style="width: 100%;" id="INTERNAS_PARAQUE1_DPT" name="INTERNAS_PARAQUE_DPT[]" rows="2"></textarea>
                      </td>
                      <td>
                        <select class="form-control" id="INTERNAS_FRECUENCIA1_DPT" name="INTERNAS_FRECUENCIA_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          <option value="Diaria">Diaria</option>
                          <option value="Semanal">Semanal</option>
                          <option value="Mensual">Mensual</option>
                          <option value="Semestral">Semestral</option>
                          <option value="Anual">Anual</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <select class="form-control area-select" id="INTERNAS_CONQUIEN2_DPT" name="INTERNAS_CONQUIEN_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          @foreach ($areas as $area)
                          <option value="{{ $area->ID }}">{{ $area->NOMBRE }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <textarea class="form-control" style="width: 100%;" id="INTERNAS_PARAQUE2_DPT" name="INTERNAS_PARAQUE_DPT[]" rows="2"></textarea>
                      </td>
                      <td>
                        <select class="form-control" id="INTERNAS_FRECUENCIA2_DPT" name="INTERNAS_FRECUENCIA_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          <option value="Diaria">Diaria</option>
                          <option value="Semanal">Semanal</option>
                          <option value="Mensual">Mensual</option>
                          <option value="Semestral">Semestral</option>
                          <option value="Anual">Anual</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <select class="form-control area-select" id="INTERNAS_CONQUIEN3_DPT" name="INTERNAS_CONQUIEN_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          @foreach ($areas as $area)
                          <option value="{{ $area->ID }}">{{ $area->NOMBRE }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <textarea class="form-control" style="width: 100%;" id="INTERNAS_PARAQUE3_DPT" name="INTERNAS_PARAQUE_DPT[]" rows="2"></textarea>
                      </td>
                      <td>
                        <select class="form-control" id="INTERNAS_FRECUENCIA3_DPT" name="INTERNAS_FRECUENCIA_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          <option value="Diaria">Diaria</option>
                          <option value="Semanal">Semanal</option>
                          <option value="Mensual">Mensual</option>
                          <option value="Semestral">Semestral</option>
                          <option value="Anual">Anual</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <select class="form-control area-select" id="INTERNAS_CONQUIEN4_DPT" name="INTERNAS_CONQUIEN_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          @foreach ($areas as $area)
                          <option value="{{ $area->ID }}">{{ $area->NOMBRE }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <textarea class="form-control" style="width: 100%;" id="INTERNAS_PARAQUE4_DPT" name="INTERNAS_PARAQUE_DPT[]" rows="2"></textarea>
                      </td>
                      <td>
                        <select class="form-control" id="INTERNAS_FRECUENCIA4_DPT" name="INTERNAS_FRECUENCIA_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          <option value="Diaria">Diaria</option>
                          <option value="Semanal">Semanal</option>
                          <option value="Mensual">Mensual</option>
                          <option value="Semestral">Semestral</option>
                          <option value="Anual">Anual</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <select class="form-control area-select" id="INTERNAS_CONQUIEN5_DPT" name="INTERNAS_CONQUIEN_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          @foreach ($areas as $area)
                          <option value="{{ $area->ID }}">{{ $area->NOMBRE }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <textarea class="form-control" style="width: 100%;" id="INTERNAS_PARAQUE5_DPT" name="INTERNAS_PARAQUE_DPT[]" rows="2"></textarea>
                      </td>
                      <td>
                        <select class="form-control" id="INTERNAS_FRECUENCIA5_DPT" name="INTERNAS_FRECUENCIA_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          <option value="Diaria">Diaria</option>
                          <option value="Semanal">Semanal</option>
                          <option value="Mensual">Mensual</option>
                          <option value="Semestral">Semestral</option>
                          <option value="Anual">Anual</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <select class="form-control area-select" id="INTERNAS_CONQUIEN6_DPT" name="INTERNAS_CONQUIEN_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          @foreach ($areas as $area)
                          <option value="{{ $area->ID }}">{{ $area->NOMBRE }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <textarea class="form-control" style="width: 100%;" id="INTERNAS_PARAQUE6_DPT" name="INTERNAS_PARAQUE_DPT[]" rows="2"></textarea>
                      </td>
                      <td>
                        <select class="form-control" id="INTERNAS_FRECUENCIA6_DPT" name="INTERNAS_FRECUENCIA_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          <option value="Diaria">Diaria</option>
                          <option value="Semanal">Semanal</option>
                          <option value="Mensual">Mensual</option>
                          <option value="Semestral">Semestral</option>
                          <option value="Anual">Anual</option>
                        </select>
                      </td>
                    </tr>

                    <tr>
                      <td>
                        <select class="form-control area-select" id="INTERNAS_CONQUIEN7_DPT" name="INTERNAS_CONQUIEN_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          @foreach ($areas as $area)
                          <option value="{{ $area->ID }}">{{ $area->NOMBRE }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <textarea class="form-control" style="width: 100%;" id="INTERNAS_PARAQUE7_DPT" name="INTERNAS_PARAQUE_DPT[]" rows="2"></textarea>
                      </td>
                      <td>
                        <select class="form-control" id="INTERNAS_FRECUENCIA7_DPT" name="INTERNAS_FRECUENCIA_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          <option value="Diaria">Diaria</option>
                          <option value="Semanal">Semanal</option>
                          <option value="Mensual">Mensual</option>
                          <option value="Semestral">Semestral</option>
                          <option value="Anual">Anual</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <select class="form-control area-select" id="INTERNAS_CONQUIEN8_DPT" name="INTERNAS_CONQUIEN_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          @foreach ($areas as $area)
                          <option value="{{ $area->ID }}">{{ $area->NOMBRE }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <textarea class="form-control" style="width: 100%;" id="INTERNAS_PARAQUE8_DPT" name="INTERNAS_PARAQUE_DPT[]" rows="2"></textarea>
                      </td>
                      <td>
                        <select class="form-control" id="INTERNAS_FRECUENCIA8_DPT" name="INTERNAS_FRECUENCIA_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          <option value="Diaria">Diaria</option>
                          <option value="Semanal">Semanal</option>
                          <option value="Mensual">Mensual</option>
                          <option value="Semestral">Semestral</option>
                          <option value="Anual">Anual</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <select class="form-control area-select" id="INTERNAS_CONQUIEN9_DPT" name="INTERNAS_CONQUIEN_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          @foreach ($areas as $area)
                          <option value="{{ $area->ID }}">{{ $area->NOMBRE }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <textarea class="form-control" style="width: 100%;" id="INTERNAS_PARAQUE9_DPT" name="INTERNAS_PARAQUE_DPT[]" rows="2"></textarea>
                      </td>
                      <td>
                        <select class="form-control" id="INTERNAS_FRECUENCIA9_DPT" name="INTERNAS_FRECUENCIA_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          <option value="Diaria">Diaria</option>
                          <option value="Semanal">Semanal</option>
                          <option value="Mensual">Mensual</option>
                          <option value="Semestral">Semestral</option>
                          <option value="Anual">Anual</option>

                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <select class="form-control area-select" id="INTERNAS_CONQUIEN10_DPT" name="INTERNAS_CONQUIEN_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          @foreach ($areas as $area)
                          <option value="{{ $area->ID }}">{{ $area->NOMBRE }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <textarea class="form-control" style="width: 100%;" id="INTERNAS_PARAQUE10_DPT" name="INTERNAS_PARAQUE_DPT[]" rows="2"></textarea>
                      </td>
                      <td>
                        <select class="form-control" id="INTERNAS_FRECUENCIA10_DPT" name="INTERNAS_FRECUENCIA_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          <option value="Diaria">Diaria</option>
                          <option value="Semanal">Semanal</option>
                          <option value="Mensual">Mensual</option>
                          <option value="Semestral">Semestral</option>
                          <option value="Anual">Anual</option>

                        </select>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- V. Relaciones externas estratégicas -->
            <div class="row mb-3">
              <div class="col-12 text-center">
                <h4>V. Relaciones externas estratégicas</h4>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-12">
                <table class="table">
                  <thead>
                    <tr>
                      <th style="width: 30%;" class="text-center">Con quién (cliente, proveedores)</th>
                      <th style="width: 30%;" class="text-center">Para qué (acción concreta)</th>
                      <th colspan="5" class="text-center" style="width: 10%;">Frecuencia</th>
                    </tr>
                    <tr>
                      <th></th>
                      <th></th>
                      <th style="width: 50%;"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <select class="form-control externa-select" id="EXTERNAS_CONQUIEN1_DPT" name="EXTERNAS_CONQUIEN_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          @foreach ($externo as $externos)
                          <option value="{{ $externos->ID_CATALOGO_RELACIONESEXTERNAS }}">{{ $externos->NOMBRE_RELACIONEXTERNA }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <textarea class="form-control" style="width: 100%;" id="EXTERNAS_PARAQUE1_DPT" name="EXTERNAS_PARAQUE_DPT[]" rows="2"></textarea>
                      </td>
                      <td>
                        <select class="form-control" id="EXTERNAS_FRECUENCIA1_DPT" name="EXTERNAS_FRECUENCIA_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          <option value="Diaria">Diaria</option>
                          <option value="Semanal">Semanal</option>
                          <option value="Mensual">Mensual</option>
                          <option value="Semestral">Semestral</option>
                          <option value="Anual">Anual</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <select class="form-control externa-select" id="EXTERNAS_CONQUIEN2_DPT" name="EXTERNAS_CONQUIEN_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          @foreach ($externo as $externos)
                          <option value="{{ $externos->ID_CATALOGO_RELACIONESEXTERNAS }}">{{ $externos->NOMBRE_RELACIONEXTERNA }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <textarea class="form-control" style="width: 100%;" id="EXTERNAS_PARAQUE2_DPT" name="EXTERNAS_PARAQUE_DPT[]" rows="2"></textarea>
                      </td>
                      <td>
                        <select class="form-control" id="EXTERNAS_FRECUENCIA2_DPT" name="EXTERNAS_FRECUENCIA_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          <option value="Diaria">Diaria</option>
                          <option value="Semanal">Semanal</option>
                          <option value="Mensual">Mensual</option>
                          <option value="Semestral">Semestral</option>
                          <option value="Anual">Anual</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <select class="form-control externa-select" id="EXTERNAS_CONQUIEN3_DPT" name="EXTERNAS_CONQUIEN_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          @foreach ($externo as $externos)
                          <option value="{{ $externos->ID_CATALOGO_RELACIONESEXTERNAS }}">{{ $externos->NOMBRE_RELACIONEXTERNA }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <textarea class="form-control" style="width: 100%;" id="EXTERNAS_PARAQUE3_DPT" name="EXTERNAS_PARAQUE_DPT[]" rows="2"></textarea>
                      </td>
                      <td>
                        <select class="form-control" id="EXTERNAS_FRECUENCIA3_DPT" name="EXTERNAS_FRECUENCIA_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          <option value="Diaria">Diaria</option>
                          <option value="Semanal">Semanal</option>
                          <option value="Mensual">Mensual</option>
                          <option value="Semestral">Semestral</option>
                          <option value="Anual">Anual</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <select class="form-control externa-select" id="EXTERNAS_CONQUIEN4_DPT" name="EXTERNAS_CONQUIEN_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          @foreach ($externo as $externos)
                          <option value="{{ $externos->ID_CATALOGO_RELACIONESEXTERNAS }}">{{ $externos->NOMBRE_RELACIONEXTERNA }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <textarea class="form-control" style="width: 100%;" id="EXTERNAS_PARAQUE4_DPT" name="EXTERNAS_PARAQUE_DPT[]" rows="2"></textarea>
                      </td>
                      <td>
                        <select class="form-control" id="EXTERNAS_FRECUENCIA4_DPT" name="EXTERNAS_FRECUENCIA_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          <option value="Diaria">Diaria</option>
                          <option value="Semanal">Semanal</option>
                          <option value="Mensual">Mensual</option>
                          <option value="Semestral">Semestral</option>
                          <option value="Anual">Anual</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <select class="form-control externa-select" id="EXTERNAS_CONQUIEN5_DPT" name="EXTERNAS_CONQUIEN_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          @foreach ($externo as $externos)
                          <option value="{{ $externos->ID_CATALOGO_RELACIONESEXTERNAS }}">{{ $externos->NOMBRE_RELACIONEXTERNA }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <textarea class="form-control" style="width: 100%;" id="EXTERNAS_PARAQUE5_DPT" name="EXTERNAS_PARAQUE_DPT[]" rows="2"></textarea>
                      </td>
                      <td>
                        <select class="form-control" id="EXTERNAS_FRECUENCIA5_DPT" name="EXTERNAS_FRECUENCIA_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          <option value="Diaria">Diaria</option>
                          <option value="Semanal">Semanal</option>
                          <option value="Mensual">Mensual</option>
                          <option value="Semestral">Semestral</option>
                          <option value="Anual">Anual</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <select class="form-control externa-select" id="EXTERNAS_CONQUIEN6_DPT" name="EXTERNAS_CONQUIEN_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          @foreach ($externo as $externos)
                          <option value="{{ $externos->ID_CATALOGO_RELACIONESEXTERNAS }}">{{ $externos->NOMBRE_RELACIONEXTERNA }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <textarea class="form-control" style="width: 100%;" id="EXTERNAS_PARAQUE6_DPT" name="EXTERNAS_PARAQUE_DPT[]" rows="2"></textarea>
                      </td>
                      <td>
                        <select class="form-control" id="EXTERNAS_FRECUENCIA6_DPT" name="EXTERNAS_FRECUENCIA_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          <option value="Diaria">Diaria</option>
                          <option value="Semanal">Semanal</option>
                          <option value="Mensual">Mensual</option>
                          <option value="Semestral">Semestral</option>
                          <option value="Anual">Anual</option>
                        </select>
                      </td>
                    </tr>

                    <tr>
                      <td>
                        <select class="form-control externa-select" id="EXTERNAS_CONQUIEN7_DPT" name="EXTERNAS_CONQUIEN_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          @foreach ($externo as $externos)
                          <option value="{{ $externos->ID_CATALOGO_RELACIONESEXTERNAS }}">{{ $externos->NOMBRE_RELACIONEXTERNA }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <textarea class="form-control" style="width: 100%;" id="EXTERNAS_PARAQUE7_DPT" name="EXTERNAS_PARAQUE_DPT[]" rows="2"></textarea>
                      </td>
                      <td>
                        <select class="form-control" id="EXTERNAS_FRECUENCIA7_DPT" name="EXTERNAS_FRECUENCIA_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          <option value="Diaria">Diaria</option>
                          <option value="Semanal">Semanal</option>
                          <option value="Mensual">Mensual</option>
                          <option value="Semestral">Semestral</option>
                          <option value="Anual">Anual</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <select class="form-control externa-select" id="EXTERNAS_CONQUIEN8_DPT" name="EXTERNAS_CONQUIEN_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          @foreach ($externo as $externos)
                          <option value="{{ $externos->ID_CATALOGO_RELACIONESEXTERNAS }}">{{ $externos->NOMBRE_RELACIONEXTERNA }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <textarea class="form-control" style="width: 100%;" id="EXTERNAS_PARAQUE8_DPT" name="EXTERNAS_PARAQUE_DPT[]" rows="2"></textarea>
                      </td>
                      <td>
                        <select class="form-control" id="EXTERNAS_FRECUENCIA8_DPT" name="EXTERNAS_FRECUENCIA_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          <option value="Diaria">Diaria</option>
                          <option value="Semanal">Semanal</option>
                          <option value="Mensual">Mensual</option>
                          <option value="Semestral">Semestral</option>
                          <option value="Anual">Anual</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <select class="form-control externa-select" id="EXTERNAS_CONQUIEN9_DPT" name="EXTERNAS_CONQUIEN_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          @foreach ($externo as $externos)
                          <option value="{{ $externos->ID_CATALOGO_RELACIONESEXTERNAS }}">{{ $externos->NOMBRE_RELACIONEXTERNA }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <textarea class="form-control" style="width: 100%;" id="EXTERNAS_PARAQUE9_DPT" name="EXTERNAS_PARAQUE_DPT[]" rows="2"></textarea>
                      </td>
                      <td>
                        <select class="form-control" id="EXTERNAS_FRECUENCIA9_DPT" name="EXTERNAS_FRECUENCIA_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          <option value="Diaria">Diaria</option>
                          <option value="Semanal">Semanal</option>
                          <option value="Mensual">Mensual</option>
                          <option value="Semestral">Semestral</option>
                          <option value="Anual">Anual</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <select class="form-control externa-select" id="EXTERNAS_CONQUIEN10_DPT" name="EXTERNAS_CONQUIEN_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          @foreach ($externo as $externos)
                          <option value="{{ $externos->ID_CATALOGO_RELACIONESEXTERNAS }}">{{ $externos->NOMBRE_RELACIONEXTERNA }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <textarea class="form-control" style="width: 100%;" id="EXTERNAS_PARAQUE10_DPT" name="EXTERNAS_PARAQUE_DPT[]" rows="2"></textarea>
                      </td>
                      <td>
                        <select class="form-control" id="EXTERNAS_FRECUENCIA10_DPT" name="EXTERNAS_FRECUENCIA_DPT[]">
                          <option selected disabled>Seleccione una opción</option>
                          <option value="Diaria">Diaria</option>
                          <option value="Semanal">Semanal</option>
                          <option value="Mensual">Mensual</option>
                          <option value="Semestral">Semestral</option>
                          <option value="Anual">Anual</option>
                        </select>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>


            <!-- VI. Competencias básicas o cardinales -->
            <div class="row mb-3">
              <div class="col-12 text-center">
                <h4>VI. Competencias básicas o cardinales</h4>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-12">
                <table class="table">
                  <thead>
                    <tr>
                      <th style="width: 15%;">Competencia &nbsp;<button id="agregarCompetencia" class="btn btn-primary"><i class="bi bi-plus-circle"></i></button></th>
                      <th class="text-center" style="width: 50%;">Descripción</th>
                      <th style="width: 3%;">Bajo</th>
                      <th style="width: 3%;">Medio</th>
                      <th style="width: 3%;">Alto</th>
                    </tr>
                  </thead>
                  <tbody>

                    <tr id="COMPETENCIA1" style="display: none;">
                      <td>
                        <select class="form-control cardinales-select" id="NOMBRE_COMPETENCIA1" name="NOMBRE_COMPETENCIA1">
                          <option selected disabled>Seleccione una opción</option>
                          @foreach ($basicos as $basico)
                          <option value="{{ $basico->ID_CATALOGO_COMPETENCIA_BASICA }}" data-descripcion="{{ $basico->DESCRIPCION_COMPETENCIA_BASICA }}">{{ $basico->NOMBRE_COMPETENCIA_BASICA }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <textarea class="form-control" style="width: 100%;" id="DESCRIPCION_COMPETENCIA1" name="DESCRIPCION_COMPETENCIA1" rows="2" readonly></textarea>
                      </td>
                      <td>
                        <input class="form-check-input" type="radio" name="COMPETENCIA1_ESCALA" id="ESCALA_INNOVACION_BAJO" value="BAJO">
                      </td>
                      <td>
                        <input class="form-check-input" type="radio" name="COMPETENCIA1_ESCALA" id="ESCALA_INNOVACION_MEDIO" value="MEDIO">
                      </td>
                      <td>
                        <input class="form-check-input" type="radio" name="COMPETENCIA1_ESCALA" id="ESCALA_INNOVACION_ALTO" value="ALTO">
                      </td>
                    </tr>

                    <tr id="COMPETENCIA2" style="display: none;">
                      <td>
                        <select class="form-control cardinales-select" id="NOMBRE_COMPETENCIA2" name="NOMBRE_COMPETENCIA2">
                          <option selected disabled>Seleccione una opción</option>
                          @foreach ($basicos as $basico)
                          <option value="{{ $basico->ID_CATALOGO_COMPETENCIA_BASICA }}" data-descripcion="{{ $basico->DESCRIPCION_COMPETENCIA_BASICA }}">{{ $basico->NOMBRE_COMPETENCIA_BASICA }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <textarea class="form-control" style="width: 100%;" id="DESCRIPCION_COMPETENCIA2" name="DESCRIPCION_COMPETENCIA2" rows="2" readonly></textarea>
                      </td>
                      <td>
                        <input class="form-check-input" type="radio" name="COMPETENCIA2_ESCALA" id="ESCALA_INNOVACION_BAJO" value="BAJO">
                      </td>
                      <td>
                        <input class="form-check-input" type="radio" name="COMPETENCIA2_ESCALA" id="ESCALA_INNOVACION_MEDIO" value="MEDIO">
                      </td>
                      <td>
                        <input class="form-check-input" type="radio" name="COMPETENCIA2_ESCALA" id="ESCALA_INNOVACION_ALTO" value="ALTO">
                      </td>
                    </tr>

                    <tr id="COMPETENCIA3" style="display: none;">
                      <td>
                        <select class="form-control cardinales-select" id="NOMBRE_COMPETENCIA3" name="NOMBRE_COMPETENCIA3">
                          <option selected disabled>Seleccione una opción</option>
                          @foreach ($basicos as $basico)
                          <option value="{{ $basico->ID_CATALOGO_COMPETENCIA_BASICA }}" data-descripcion="{{ $basico->DESCRIPCION_COMPETENCIA_BASICA }}">{{ $basico->NOMBRE_COMPETENCIA_BASICA }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <textarea class="form-control" style="width: 100%;" id="DESCRIPCION_COMPETENCIA3" name="DESCRIPCION_COMPETENCIA3" rows="2" readonly></textarea>
                      </td>
                      <td>
                        <input class="form-check-input" type="radio" name="COMPETENCIA3_ESCALA" id="ESCALA_INNOVACION_BAJO" value="BAJO">
                      </td>
                      <td>
                        <input class="form-check-input" type="radio" name="COMPETENCIA3_ESCALA" id="ESCALA_INNOVACION_MEDIO" value="MEDIO">
                      </td>
                      <td>
                        <input class="form-check-input" type="radio" name="COMPETENCIA3_ESCALA" id="ESCALA_INNOVACION_ALTO" value="ALTO">
                      </td>
                    </tr>


                    <tr id="COMPETENCIA4" style="display: none;">
                      <td>
                        <select class="form-control cardinales-select" id="NOMBRE_COMPETENCIA4" name="NOMBRE_COMPETENCIA4">
                          <option selected disabled>Seleccione una opción</option>
                          @foreach ($basicos as $basico)
                          <option value="{{ $basico->ID_CATALOGO_COMPETENCIA_BASICA }}" data-descripcion="{{ $basico->DESCRIPCION_COMPETENCIA_BASICA }}">{{ $basico->NOMBRE_COMPETENCIA_BASICA }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <textarea class="form-control" style="width: 100%;" id="DESCRIPCION_COMPETENCIA4" name="DESCRIPCION_COMPETENCIA4" rows="2" readonly></textarea>
                      </td>
                      <td>
                        <input class="form-check-input" type="radio" name="COMPETENCIA4_ESCALA" id="ESCALA_INNOVACION_BAJO" value="BAJO">
                      </td>
                      <td>
                        <input class="form-check-input" type="radio" name="COMPETENCIA4_ESCALA" id="ESCALA_INNOVACION_MEDIO" value="MEDIO">
                      </td>
                      <td>
                        <input class="form-check-input" type="radio" name="COMPETENCIA4_ESCALA" id="ESCALA_INNOVACION_ALTO" value="ALTO">
                      </td>
                    </tr>



                    <tr id="COMPETENCIA5" style="display: none;">
                      <td>
                        <select class="form-control cardinales-select" id="NOMBRE_COMPETENCIA5" name="NOMBRE_COMPETENCIA5">
                          <option selected disabled>Seleccione una opción</option>
                          @foreach ($basicos as $basico)
                          <option value="{{ $basico->ID_CATALOGO_COMPETENCIA_BASICA }}" data-descripcion="{{ $basico->DESCRIPCION_COMPETENCIA_BASICA }}">{{ $basico->NOMBRE_COMPETENCIA_BASICA }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <textarea class="form-control" style="width: 100%;" id="DESCRIPCION_COMPETENCIA5" name="DESCRIPCION_COMPETENCIA5" rows="2" readonly></textarea>
                      </td>
                      <td>
                        <input class="form-check-input" type="radio" name="COMPETENCIA5_ESCALA" id="ESCALA_INNOVACION_BAJO" value="BAJO">
                      </td>
                      <td>
                        <input class="form-check-input" type="radio" name="COMPETENCIA5_ESCALA" id="ESCALA_INNOVACION_MEDIO" value="MEDIO">
                      </td>
                      <td>
                        <input class="form-check-input" type="radio" name="COMPETENCIA5_ESCALA" id="ESCALA_INNOVACION_ALTO" value="ALTO">
                      </td>
                    </tr>

                    <tr id="COMPETENCIA6" style="display: none;">
                      <td>
                        <select class="form-control cardinales-select" id="NOMBRE_COMPETENCIA6" name="NOMBRE_COMPETENCIA6">
                          <option selected disabled>Seleccione una opción</option>
                          @foreach ($basicos as $basico)
                          <option value="{{ $basico->ID_CATALOGO_COMPETENCIA_BASICA }}" data-descripcion="{{ $basico->DESCRIPCION_COMPETENCIA_BASICA }}">{{ $basico->NOMBRE_COMPETENCIA_BASICA }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <textarea class="form-control" style="width: 100%;" id="DESCRIPCION_COMPETENCIA6" name="DESCRIPCION_COMPETENCIA6" rows="2" readonly></textarea>
                      </td>
                      <td>
                        <input class="form-check-input" type="radio" name="COMPETENCIA6_ESCALA" id="ESCALA_INNOVACION_BAJO" value="BAJO">
                      </td>
                      <td>
                        <input class="form-check-input" type="radio" name="COMPETENCIA6_ESCALA" id="ESCALA_INNOVACION_MEDIO" value="MEDIO">
                      </td>
                      <td>
                        <input class="form-check-input" type="radio" name="COMPETENCIA6_ESCALA" id="ESCALA_INNOVACION_ALTO" value="ALTO">
                      </td>
                    </tr>


                    <tr id="COMPETENCIA7" style="display: none;">
                      <td>
                        <select class="form-control cardinales-select" id="NOMBRE_COMPETENCIA7" name="NOMBRE_COMPETENCIA7">
                          <option selected disabled>Seleccione una opción</option>
                          @foreach ($basicos as $basico)
                          <option value="{{ $basico->ID_CATALOGO_COMPETENCIA_BASICA }}" data-descripcion="{{ $basico->DESCRIPCION_COMPETENCIA_BASICA }}">{{ $basico->NOMBRE_COMPETENCIA_BASICA }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <textarea class="form-control" style="width: 100%;" id="DESCRIPCION_COMPETENCIA7" name="DESCRIPCION_COMPETENCIA7" rows="2" readonly></textarea>
                      </td>
                      <td>
                        <input class="form-check-input" type="radio" name="COMPETENCIA7_ESCALA" id="ESCALA_INNOVACION_BAJO" value="BAJO">
                      </td>
                      <td>
                        <input class="form-check-input" type="radio" name="COMPETENCIA7_ESCALA" id="ESCALA_INNOVACION_MEDIO" value="MEDIO">
                      </td>
                      <td>
                        <input class="form-check-input" type="radio" name="COMPETENCIA7_ESCALA" id="ESCALA_INNOVACION_ALTO" value="ALTO">
                      </td>
                    </tr>


                    <tr id="COMPETENCIA8" style="display: none;">
                      <td>
                        <select class="form-control cardinales-select" id="NOMBRE_COMPETENCIA8" name="NOMBRE_COMPETENCIA8">
                          <option selected disabled>Seleccione una opción</option>
                          @foreach ($basicos as $basico)
                          <option value="{{ $basico->ID_CATALOGO_COMPETENCIA_BASICA }}" data-descripcion="{{ $basico->DESCRIPCION_COMPETENCIA_BASICA }}">{{ $basico->NOMBRE_COMPETENCIA_BASICA }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <textarea class="form-control" style="width: 100%;" id="DESCRIPCION_COMPETENCIA8" name="DESCRIPCION_COMPETENCIA8" rows="2" readonly></textarea>
                      </td>
                      <td>
                        <input class="form-check-input" type="radio" name="COMPETENCIA8_ESCALA" id="ESCALA_INNOVACION_BAJO" value="BAJO">
                      </td>
                      <td>
                        <input class="form-check-input" type="radio" name="COMPETENCIA8_ESCALA" id="ESCALA_INNOVACION_MEDIO" value="MEDIO">
                      </td>
                      <td>
                        <input class="form-check-input" type="radio" name="COMPETENCIA8_ESCALA" id="ESCALA_INNOVACION_ALTO" value="ALTO">
                      </td>
                    </tr>

                  </tbody>
                </table>
              </div>
            </div>


            <!-- VII. Competencias gerenciales o de mandos medios -->
            <div class="row mb-3">
              <div class="col-12 text-center">
                <h4>VII. Competencias gerenciales o de mandos medios</h4>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-12">
                <table class="table">
                  <thead>
                    <tr>
                      <th style="width: 15%;">Competencia &nbsp;<button id="agregarCompetencia1" class="btn btn-primary"><i class="bi bi-plus-circle"></i></button></th>
                      <th class="text-center" style="width: 50%;">Descripción</th>
                      <th style="width: 3%;">Bajo</th>
                      <th style="width: 3%;">Medio</th>
                      <th style="width: 3%;">Alto</th>
                    </tr>
                  </thead>
                  <tbody>

                    <tr id="GERENCIALES1" style="display: none;">
                      <td>
                        <select class="form-control gerenciales-select" id="NOMBRE_COMPETENCIA11" name="NOMBRE_COMPETENCIA11">
                          <option selected disabled>Seleccione una opción</option>
                          @foreach ($gerenciales as $basico)
                          <option value="{{ $basico->ID_CATALOGO_COMPETENCIA_GERENCIAL }}" data-descripcion="{{ $basico->DESCRIPCION_COMPETENCIA_GERENCIAL }}">{{ $basico->NOMBRE_COMPETENCIA_GERENCIAL }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <textarea class="form-control" style="width: 100%;" id="DESCRIPCION_COMPETENCIA11" name="DESCRIPCION_COMPETENCIA11" rows="2" readonly></textarea>
                      </td>
                      <td>
                        <input class="form-check-input" type="radio" name="COMPETENCIA11_ESCALA" id="ESCALA_INNOVACION_BAJO" value="BAJO">
                      </td>
                      <td>
                        <input class="form-check-input" type="radio" name="COMPETENCIA11_ESCALA" id="ESCALA_INNOVACION_MEDIO" value="MEDIO">
                      </td>
                      <td>
                        <input class="form-check-input" type="radio" name="COMPETENCIA11_ESCALA" id="ESCALA_INNOVACION_ALTO" value="ALTO">
                      </td>
                    </tr>


                    <tr id="GERENCIALES2" style="display: none;">
                      <td>
                        <select class="form-control gerenciales-select" id="NOMBRE_COMPETENCIA12" name="NOMBRE_COMPETENCIA12">
                          <option selected disabled>Seleccione una opción</option>
                          @foreach ($gerenciales as $basico)
                          <option value="{{ $basico->ID_CATALOGO_COMPETENCIA_GERENCIAL }}" data-descripcion="{{ $basico->DESCRIPCION_COMPETENCIA_GERENCIAL }}">{{ $basico->NOMBRE_COMPETENCIA_GERENCIAL }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <textarea class="form-control" style="width: 100%;" id="DESCRIPCION_COMPETENCIA12" name="DESCRIPCION_COMPETENCIA12" rows="2" readonly></textarea>
                      </td>
                      <td>
                        <input class="form-check-input" type="radio" name="COMPETENCIA12_ESCALA" id="ESCALA_INNOVACION_BAJO" value="BAJO">
                      </td>
                      <td>
                        <input class="form-check-input" type="radio" name="COMPETENCIA12_ESCALA" id="ESCALA_INNOVACION_MEDIO" value="MEDIO">
                      </td>
                      <td>
                        <input class="form-check-input" type="radio" name="COMPETENCIA12_ESCALA" id="ESCALA_INNOVACION_ALTO" value="ALTO">
                      </td>
                    </tr>


                    <tr id="GERENCIALES3" style="display: none;">
                      <td>
                        <select class="form-control gerenciales-select" id="NOMBRE_COMPETENCIA13" name="NOMBRE_COMPETENCIA13">
                          <option selected disabled>Seleccione una opción</option>
                          @foreach ($gerenciales as $basico)
                          <option value="{{ $basico->ID_CATALOGO_COMPETENCIA_GERENCIAL }}" data-descripcion="{{ $basico->DESCRIPCION_COMPETENCIA_GERENCIAL }}">{{ $basico->NOMBRE_COMPETENCIA_GERENCIAL }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <textarea class="form-control" style="width: 100%;" id="DESCRIPCION_COMPETENCIA13" name="DESCRIPCION_COMPETENCIA13" rows="2" readonly></textarea>
                      </td>
                      <td>
                        <input class="form-check-input" type="radio" name="COMPETENCIA13_ESCALA" id="ESCALA_INNOVACION_BAJO" value="BAJO">
                      </td>
                      <td>
                        <input class="form-check-input" type="radio" name="COMPETENCIA13_ESCALA" id="ESCALA_INNOVACION_MEDIO" value="MEDIO">
                      </td>
                      <td>
                        <input class="form-check-input" type="radio" name="COMPETENCIA13_ESCALA" id="ESCALA_INNOVACION_ALTO" value="ALTO">
                      </td>
                    </tr>


                    <tr id="GERENCIALES4" style="display: none;">
                      <td>
                        <select class="form-control gerenciales-select" id="NOMBRE_COMPETENCIA14" name="NOMBRE_COMPETENCIA14">
                          <option selected disabled>Seleccione una opción</option>
                          @foreach ($gerenciales as $basico)
                          <option value="{{ $basico->ID_CATALOGO_COMPETENCIA_GERENCIAL }}" data-descripcion="{{ $basico->DESCRIPCION_COMPETENCIA_GERENCIAL }}">{{ $basico->NOMBRE_COMPETENCIA_GERENCIAL }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <textarea class="form-control" style="width: 100%;" id="DESCRIPCION_COMPETENCIA14" name="DESCRIPCION_COMPETENCIA14" rows="2" readonly></textarea>
                      </td>
                      <td>
                        <input class="form-check-input" type="radio" name="COMPETENCIA14_ESCALA" id="ESCALA_INNOVACION_BAJO" value="BAJO">
                      </td>
                      <td>
                        <input class="form-check-input" type="radio" name="COMPETENCIA14_ESCALA" id="ESCALA_INNOVACION_MEDIO" value="MEDIO">
                      </td>
                      <td>
                        <input class="form-check-input" type="radio" name="COMPETENCIA14_ESCALA" id="ESCALA_INNOVACION_ALTO" value="ALTO">
                      </td>
                    </tr>







                  </tbody>
                </table>
              </div>
            </div>
            <!-- VIII. Autoridad -->
            <div class="row mb-3">
              <div class="col-12 text-center">
                <h4>VIII. Autoridad</h4>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-6 text-center">
                <h6>De información</h6>
              </div>
              <div class="col-6 text-center">
                <h6>De recursos financieros</h6>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-6 text-center">
                <h6></h6>
              </div>
              <div class="col-6 text-center">
                <label>¿Maneja recursos financieros?</label>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-1 text-center">
                <h6></h6>
              </div>
              <div class="col-2">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="DE_INFORMACION_DPT" id="DEINFORMACION_SI" value="si">
                  <label class="form-check-label" for="DEINFORMACION_SI">Si</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="DE_INFORMACION_DPT" id="DEINFORMACION_NO" value="no">
                  <label class="form-check-label" for="DEINFORMACION_NO">No</label>
                </div>
              </div>
              <div class="col-3">
                <label>Especifique</label>
              </div>
              <div class="col-1 text-center">
                <h6></h6>
              </div>
              <div class="col-2">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="DE_RECURSOS_DPT" id="DERECURSOS_SI" value="si">
                  <label class="form-check-label" for="DERECURSOS_SI">Si</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="DE_RECURSOS_DPT" id="DERECURSOS_NO" value="no">
                  <label class="form-check-label" for="DERECURSOS_NO">No</label>
                </div>
              </div>
              <div class="col-3">
                <label>Especifique</label>
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-6 text-center">
              <textarea class="form-control" id="DE_INFORMACION_ESPECIFIQUE_DPT" name="DE_INFORMACION_ESPECIFIQUE_DPT" rows="2"></textarea>
            </div>
            <div class="col-6 text-center">
              <textarea class="form-control" id="DE_RECURSOS_ESPECIFIQUE_DPT" name="DE_RECURSOS_ESPECIFIQUE_DPT" rows="2"></textarea>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-6 text-center">
              <h6>De materiales y equipos</h6>
            </div>
            <div class="col-6 text-center">
              <h6>De vehículos</h6>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-6 text-center">
              <label>¿Usa materiales y equipos para realizar su trabajo?</label>
            </div>
            <div class="col-6 text-center">
              <label>¿Esta autorizado para conducir vehículos de la empresa?</label>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-1 text-center">
              <h6></h6>
            </div>
            <div class="col-2">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="DE_EQUIPOS_DPT" id="DEEQUIPOS_SI" value="si">
                <label class="form-check-label" for="DEEQUIPOS_SI">Si</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="DE_EQUIPOS_DPT" id="DEEQUIPOS_NO" value="no">
                <label class="form-check-label" for="DEEQUIPOS_NO">No</label>
              </div>
            </div>
            <div class="col-3">
              <label>Especifique</label>
            </div>
            <div class="col-1 text-center">
              <h6></h6>
            </div>
            <div class="col-2">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="DE_VEHICULOS_DPT" id="DEVEHICULOS_SI" value="si">
                <label class="form-check-label" for="DEVEHICULOS_SI">Si</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="DE_VEHICULOS_DPT" id="DEVEHICULOS_NO" value="no">
                <label class="form-check-label" for="DEVEHICULOS_NO">No</label>
              </div>
            </div>
            <div class="col-3">
              <label>Especifique</label>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-6 text-center">
              <textarea class="form-control" id="DE_EQUIPOS_ESPECIFIQUE_DPT" name="DE_EQUIPOS_ESPECIFIQUE_DPT" rows="2"></textarea>
            </div>
            <div class="col-6 text-center">
              <textarea class="form-control" id="DE_VEHICULOS_ESPECIFIQUE_DPT" name="DE_VEHICULOS_ESPECIFIQUE_DPT" rows="2"></textarea>
            </div>
          </div>

          <!--IX. Observaciones-->
          <div class="row mb-3">
            <div class="col-12 text-center">
              <h4>IX. Observaciones</h4>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-12">
              <div class="form-group">
                <textarea class="form-control" id="OBSERVACIONES_DPT" name="OBSERVACIONES_DPT" rows="2"></textarea>
              </div>
            </div>
          </div>

          <!--X. Organigrama-->
          <div class="row mb-3">
            <div class="col-12 text-center">
              <h4>X. Organigrama</h4>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-12">
              <div class="form-group">
                <textarea class="form-control" id="ORGANIGRAMA_DPT" name="ORGANIGRAMA_DPT" rows="5"></textarea>
              </div>
            </div>
          </div>
          <div class="row mb-3 mt-5">
            <div class="col-4 text-center">
              <h6>Elaborado por</h6>
              <input type="text" class="form-control text-center" id="ELABORADO_NOMBRE_DPT" name="ELABORADO_NOMBRE_DPT" required>
              <div>Nombre</div>
              <br>
              <input type="text" class="form-control text-center" id="ELABORADO_FIRMA_DPT" name="ELABORADO_FIRMA_DPT" required>
              <div>Firma</div>
              <br>

              <input type="text" class="form-control text-center mydatepicker" placeholder="aaaa-mm-dd" id="ELABORADO_FECHA_DPT" name="ELABORADO_FECHA_DPT" required>
              <i class="bi bi-calendar-event"></i>             
              {{-- <input type="date" class="form-control text-center" id="ELABORADO_FECHA_DPT" name="ELABORADO_FECHA_DPT"> --}}
              <div>Fecha</div>
              <br>
            </div>
            <div class="col-4 text-center">
              <h6>Revisado por</h6>
              <input type="text" class="form-control text-center" id="REVISADO_NOMBRE_DPT" name="REVISADO_NOMBRE_DPT">
              <div>Nombre</div>
              <br>
              <input type="text" class="form-control text-center" id="REVISADO_FIRMA_DPT" name="REVISADO_FIRMA_DPT">
              <div>Firma</div>
              <br>

              <input type="text" class="form-control text-center mydatepicker" placeholder="aaaa-mm-dd" id="REVISADO_FECHA_DPT" name="REVISADO_FECHA_DPT" >
              <i class="bi bi-calendar-event"></i>


              {{-- <input type="date" class="form-control text-center" id="REVISADO_FECHA_DPT" name="REVISADO_FECHA_DPT"> --}}
              <div>Fecha</div>
              <br>
            </div>
            <div class="col-4 text-center">
              <h6>Autorizado por</h6>
              <input type="text" class="form-control text-center" id="AUTORIZADO_NOMBRE_DPT" name="AUTORIZADO_NOMBRE_DPT">
              <div>Nombre</div>
              <br>
              <input type="text" class="form-control text-center" id="AUTORIZADO_FIRMA_DPT" name="AUTORIZADO_FIRMA_DPT">
              <div>Firma</div>
              <br>
              <input type="text" class="form-control text-center mydatepicker" placeholder="aaaa-mm-dd" id="AUTORIZADO_FECHA_DPT" name="AUTORIZADO_FECHA_DPT" >
              <i class="bi bi-calendar-event"></i>
              {{-- <input type="date" class="form-control text-center" id="AUTORIZADO_FECHA_DPT" name="AUTORIZADO_FECHA_DPT"> --}}
              <div>Fecha</div>
              <br>
            </div>
          </div>

        </div>
        <div class="modal-footer mx-5">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-success" id="guardarFormDPT"><i class="bi bi-floppy-fill" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Guardar DPT"></i> Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
</div>




@endsection