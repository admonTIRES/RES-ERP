@extends('principal.maestra')

@section('contenido')

<div class="contenedor-contenido">
  <ol class="breadcrumb mb-5">
    <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-diagram-3-fill"></i>&nbsp;Organigrama </h3>

    <button type="button" class="btn btn-light waves-effect waves-light" id="verOrganigramaGeneral" style="margin-left: 35px;">
      Organigrama General <i class="bi bi-eye"></i>
    </button>

    <button type="button" class="btn btn-light waves-effect waves-light botonnuevo_departamento" id="abrirModalBtn" style="margin-left: auto;">
      Área <i class="bi bi-plus-circle"></i>
    </button>
  </ol>


  <div class="card-body">
    <table id="TablaAreas" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">

    </table>
  </div>

</div>



<!-- =========================================================================================================================
                                                   MODALES
  ========================================================================================================================= -->
<!--  MODAL AREA -->
<div class="modal fade" id="ModalArea" tabindex="-1" aria-labelledby="ModalAreaTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="ModalAreaTitle">Nueva Área</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <nav>
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-area-tab" data-bs-toggle="tab" data-bs-target="#nav-area" type="button" role="tab" aria-controls="nav-area" aria-selected="true">Área</button>
            <button class="nav-link" id="nav-encargados-tab" data-bs-toggle="tab" data-bs-target="#nav-encargados" type="button" role="tab" aria-controls="nav-encargados" aria-selected="false" disabled>Categorías</button>

          </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade show active" id="nav-area" role="tabpanel" aria-labelledby="nav-area-tab" tabindex="0">
            <!-- Formulario de Area -->
            <form id="formArea" class="mt-4">
              {!! csrf_field() !!}
              <input type="hidden" name="TIPO_AREA_ID" value="3">

              <div class="mb-3">
                <label class="form-label">Nombre del área *</label>
                <input type="text" class="form-control" id="NOMBRE_AREA" name="NOMBRE" placeholder="ejem: Administración" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Descripción </label>
                <textarea class="form-control" id="DESCRIPCION_AREA" name="DESCRIPCION" rows="2"></textarea>
              </div>

              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label>Foto organigrama *</label>
                    <style>
                      .dropify-wrapper {
                        height: 270px !important;
                        border-radius: 5px;
                        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
                        text-align: center;
                      }

                      .dropify-message p {
                        font-size: 14px;
                        margin: 0;
                      }
                    </style>
                    <input type="file" accept="image/jpeg,image/x-png" id="FOTO_ORGANIGRAMA" name="FOTO_ORGANIGRAMA" class="dropify" data-allowed-file-extensions="jpg png" data-height="300" data-default-file="" />
                  </div>
                </div>

                <div class="col-6">
                  <label>Subir documento</label>
                  <div class="input-group">
                    <input type="file" class="form-control" id="DOCUMENTO_ORGANIGRAMA" name="DOCUMENTO_ORGANIGRAMA" accept=".pdf" />
                    <button type="button" class="btn btn-light btn-sm ms-2" id="quitar_documento" style="display:none;">Quitar archivo</button>
                  </div>
                  <div id="ERROR_DOCUMENTO" class="text-danger" style="display:none;">Por favor, sube un archivo PDF</div>
                </div>
              </div>



              <button type="submit" id="guardarArea" class="btn btn-success mt-2 ">Guardar </button>
            </form>
          </div>
          <div class="tab-pane fade" id="nav-encargados" role="tabpanel" aria-labelledby="nav-encargados-tab" tabindex="0">
            <!-- Formulario de encargado -->
            <form id="formCategoria" class="mt-4 mb-5">
              {!! csrf_field() !!}
              <input type="hidden" name="TIPO_AREA_ID" value="4">

              <div class="row">
                <span class="mb-3 text-center text-danger"><i class="bi bi-info-circle"></i> Asegurece de agregar primero los lideres del área si tiene alguno.</span>
                <div class="col-9">
                  <label class="mb-2">Seleccione la categoría a agregar</label>
                  <select class="form-control" id="CATEGORIA" name="CATEGORIA" required>
                    <option selected disabled>Seleccione una opción</option>
                    @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->ID_CATALOGO_CATEGORIA }}" data-lider="{{ $categoria->ES_LIDER_CATEGORIA }}">{{ $categoria->NOMBRE_CATEGORIA }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-3" style="margin-top: 35px;">
                  <h4><span class="badge text-bg-warning" id="esLiderText">Categoría</span></h4>
                  <input type="hidden" class="form-control" id="ES_LIDER" name="ES_LIDER">
                </div>
              </div>

              <div class="row mt-2">
                <div class="col-9">
                  <label class="mb-2">Líder a cargo</label>
                  <select class="form-control" id="LIDER" name="LIDER">
                    <option selected disabled>Seleccione una opción</option>
                    @foreach ($lideres as $lider)
                    <option value="{{ $lider->ID_CATALOGO_CATEGORIA }}" ">{{ $lider->NOMBRE_CATEGORIA }}</option>
                    @endforeach
                  </select>
                </div>
                <div class=" col-3" style="margin-top: 23px;">
                      <button type="submit" id="guardarEncargado" class="btn btn-success mt-2 "><i class="bi bi-save"></i> Agregar categoría</button>
                </div>
              </div>
            </form>

            <!-- Tabla de los encargados -->
            <table id="TablaEncargados" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">

            </table>

          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal del organigrama -->
<div class="modal fade" id="modalOrganigrama" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="TituloModalOrganigrma"></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="d-flex flex-column w-100 h-100">
          <div id="allSampleContent" class="w-100 h-100 p-4 position-relative">
            <style type="text/css">
              #myOverviewDiv {
                position: absolute;
                width: 200px;
                height: 100px;
                top: 10px;
                left: 10px;
                background-color: #f2f2f2;
                z-index: 300;
                /* Asegura que esté en frente */
                border: solid 1px #7986cb;
              }
            </style>

            <div id="sample" class="d-flex justify-content-center align-items-center position-relative h-100">
              <div id="myDiagramDiv" style="background-color: #ffffff; width: 100%; height: 100%;"></div>
              <div id="myOverviewDiv"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        {{-- <button type="button" id="Capturarorganigrama" class="btn btn-success">Capturar</button> --}}
      </div>
    </div>
  </div>
</div>



<!-- Modal Ccategoría !-->

<div class="modal fade" id="miModal_CATEGORIAS" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" enctype="multipart/form-data" id="formDepartamentos" style="background-color: #ffffff;">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Categoría</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          {!! csrf_field() !!}
          <div class="row mt-4">
            <div class="col-10">
              <div class="mb-3">
                <input type="text" class="form-control" id="CARGO_DESCRIPCION" name="NOMBRE" placeholder="Nombre de la categoría" required>
              </div>

            </div>

            <div class="col-12">
              <div class="mb-3">
                <input type="text" class="form-control" id="LUGAR_TRABAJO_CATEGORIA" name="LUGAR_TRABAJO_CATEGORIA" placeholder="Lugar de Trabajo" required>
              </div>

            </div>
            <div class="col-12">
              <div class="mb-3">
                <textarea class="form-control" id="PROPOSITO_FINALIDAD_CATEGORIA" name="PROPOSITO_FINALIDAD_CATEGORIA" rows="2" placeholder="Propósito o finalidad el puesto"></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-success" id="guardarDepartamento">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection