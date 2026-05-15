@extends('principal.maestraventas')

@section('contenido')



<div class="contenedor-contenido">
  <ol class="breadcrumb mb-5">
    <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-person-lines-fill"></i>&nbsp;Clientes</h3>

    <button type="button" class="btn btn-light waves-effect waves-light " id="NUEVO_CLIENTE" style="margin-left: auto;">
      Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
    </button>

  </ol>

  <div class="card-body">
    <table id="Tablaclientesventas" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">

    </table>
  </div>


</div>













<div class="modal modal-fullscreen fade" id="miModal_CLIENTES" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form method="post" enctype="multipart/form-data" id="formularioCLIENTES" style="background-color: #ffffff;">
        <div class="modal-header">
          <h5 class="modal-title" id="miModalLabel">Cliente</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          {!! csrf_field() !!}

          <!-- Nav tabs -->
          <ul class="nav nav-tabs mb-3" id="tabsCliente" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="tab1-info" data-bs-toggle="tab" data-bs-target="#contenido-info" type="button" role="tab">Información del cliente</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="tab2-verif" data-bs-toggle="tab" data-bs-target="#contenido-verif" type="button" role="tab" disabled>Verificación del cliente</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="tab3-acta" data-bs-toggle="tab" data-bs-target="#contenido-acta" type="button" role="tab" disabled>Acta constitutiva</button>
            </li>
          </ul>

          <!-- Tab contents -->
          <div class="tab-content">
            <!-- TAB 1: Información del cliente -->
            <div class="tab-pane fade show active" id="contenido-info" role="tabpanel">
              <div class="row">
                <div class="col-12">
                  <div class="row">
                    <div class="col-md-12 mb-3 text-center">
                      <h5 class="form-label"><b>Datos del cliente</b></h5>
                    </div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="row">
                    <div class="col-md-3 mb-3">
                      <label class="form-label">RFC</label>
                      <input type="text" class="form-control" id="RFC_CLIENTE" name="RFC_CLIENTE">
                    </div>

                    <div class="col-md-4 mb-3">
                      <label class="form-label">Razón Social</label>
                      <input type="text" class="form-control" id="RAZON_SOCIAL_CLIENTE" name="RAZON_SOCIAL_CLIENTE">
                    </div>

                    <div class="col-md-5 mb-3">
                      <label class="form-label">Nombre Comercial</label>
                      <input type="text" class="form-control" id="NOMBRE_COMERCIAL_CLIENTE" name="NOMBRE_COMERCIAL_CLIENTE">
                    </div>

                    <div class="col-md-4 mb-3">
                      <label class="form-label">Giro de la Empresa</label>
                      <select class="form-control puesto" id="GIRO_EMPRESA_CLIENTE" name="GIRO_EMPRESA_CLIENTE">
                        <option value="0" disabled selected>Seleccione una opción</option>
                        @foreach ($giros as $giro)
                        <option value="{{ $giro->ID_CATALOGO_GIRO_EMPRESA }}">{{ $giro->NOMBRE_GIRO }}</option>
                        @endforeach
                      </select>
                    </div>

                    <div class="col-md-4 mb-3">
                      <label class="form-label">Representante Legal</label>
                      <input type="text" class="form-control" id="REPRESENTANTE_LEGAL_CLIENTE" name="REPRESENTANTE_LEGAL_CLIENTE">
                    </div>

                    <div class="col-md-4 mb-3">
                      <label class="form-label">Página web</label>
                      <input type="text" class="form-control" id="PAGINA_CLIENTE" name="PAGINA_CLIENTE">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="mb-3">
                    <div class="row">
                      <div class="col-6 mb-3">
                        <label>Agregar dirección</label>
                        <button id="botonAgregardomicilio" type="button" class="btn btn-danger ml-2 rounded-pill" title="Agregar">
                          <i class="bi bi-plus-circle-fill"></i>
                        </button>
                      </div>
                    </div>
                    <div class="direcciondiv mt-4"></div>
                  </div>
                </div>

                <div class="row">
                  <div class="mb-3">
                    <div class="row">
                      <div class="col-6 mb-3">
                        <label>Agregar contacto</label>
                        <button id="botonAgregarcontacto" type="button" class="btn btn-danger ml-2 rounded-pill" title="Agregar">
                          <i class="bi bi-plus-circle-fill"></i>
                        </button>
                      </div>
                    </div>
                    <div class="contactodiv mt-4"></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="row">
                    <div class="col-md-12 mb-3 text-center">
                      <h5 class="form-label"><b>El cliente emite orden de compra</b></h5><br>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="EMITE_ORDEN" id="procedeno" value="0">
                        <label class="form-check-label" for="procedeno">No</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="EMITE_ORDEN" id="procedesi" value="1">
                        <label class="form-check-label" for="procedesi">Sí</label>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-6 mb-3">
                  <label class="form-label">Constancia de situación fiscal (PDF) </label>
                  <div class="d-flex align-items-center">
                    <input type="file" class="form-control me-2" name="CONSTANCIA_DOCUMENTO" accept=".pdf">
                    <button type="button" class="btn btn-warning botonEliminarArchivo" title="Eliminar archivo">
                      <i class="bi bi-trash"></i>
                    </button>
                  </div>
                </div>

                <div class="col-6 mb-3">
                  <label class="form-label">Fecha constancia</label>
                  <div class="input-group">
                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_CONSTANCIA" name="FECHA_CONSTANCIA">
                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                  </div>
                </div>
              </div>
            </div>

            <!-- TAB 2: Verificación del cliente -->
            <div class="tab-pane fade" id="contenido-verif" role="tabpanel">
              <ol class="breadcrumb mb-5">
                <h3 style="color: #ffffff; margin: 0;">&nbsp;Verificación del cliente</h3>
                <button type="button" class="btn btn-light waves-effect waves-light" id="NUEVA_VERIFICACION" style="margin-left: auto;">
                  Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
                </button>
              </ol>

              <div class="card-body">
                <div class="card-body position-relative" id="tabla_activo" style="display: block;">
                  <i id="loadingIcon" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                  <table id="Tablaverificacionusuario" class="table table-hover bg-white table-bordered text-center w-100 TableCustom"></table>
                </div>
              </div>
            </div>

            <!-- TAB 3: Acta constitutiva -->
            <div class="tab-pane fade" id="contenido-acta" role="tabpanel">
              <ol class="breadcrumb mb-5">
                <h3 style="color: #ffffff; margin: 0;">&nbsp;Acta constitutiva</h3>
                <button type="button" class="btn btn-light waves-effect waves-light" id="NUEVA_ACTA" style="margin-left: auto;">
                  Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
                </button>
              </ol>

              <div class="card-body">
                <div class="card-body position-relative" id="tabla_activo" style="display: block;">
                  <i id="loadingIcon2" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                  <table id="Tablactaconstitutivausuario" class="table table-hover bg-white table-bordered text-center w-100 TableCustom"></table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer mx-5">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-success" id="guardarCLIENTE">
            <i class="bi bi-floppy-fill" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Guardar CLIENTE"></i> Guardar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>




<div class="modal fade" id="miModal_VERIFICACIONES" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <form method="post" enctype="multipart/form-data" id="formularioVERIFICACIONES" style="background-color: #ffffff;">
              <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Nueva verificación</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  {!! csrf_field() !!}
                  <div class="col-12">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Verificado en *</label>
                            <input type="text" class="form-control" name="VERIFICADO_EN" id="VERIFICADO_EN" required>
                        </div>
                        <div class="col-12 mb-3">
                          <label class="form-label">Subir Evidencia (PDF) *</label>
                          <div class="d-flex align-items-center">
                              <input type="file" class="form-control me-2" name="EVIDENCIA_VERIFICACION" id="EVIDENCIA_VERIFICACION" accept=".pdf">
                              <button type="button" class="btn btn-warning botonEliminarArchivo" title="Eliminar archivo">
                                  <i class="bi bi-trash"></i>
                              </button>
                          </div>
                       </div>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-success" id="guardarVERIFICACION">Guardar</button>
              </div>
          </form>
      </div>
  </div>
</div>




<div class="modal fade" id="miModal_ACTA" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <form method="post" enctype="multipart/form-data" id="formularioACTA" style="background-color: #ffffff;">
              <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Nueva acta constitutiva</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  {!! csrf_field() !!}
                  <div class="col-12">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nombre del archivo *</label>
                            <input type="text" class="form-control" name="ACTA_CONSTITUVA" id="ACTA_CONSTITUVA" value="Acta constitutiva">
                        </div>
                        <div class="col-md-6 mb-3">
                          <label class="form-label">Número </label>
                          <input type="text" class="form-control" name="NUMERO_CONSTITUVA" id="NUMERO_CONSTITUVA" >
                      </div>
                        <div class="col-12 mb-3">
                          <label class="form-label">Subir Evidencia (PDF) *</label>
                          <div class="d-flex align-items-center">
                              <input type="file" class="form-control me-2" name="EVIDENCIA_CONSTITUVA" id="EVIDENCIA_CONSTITUVA" accept=".pdf">
                              <button type="button" class="btn btn-warning botonEliminarArchivo" title="Eliminar archivo">
                                  <i class="bi bi-trash"></i>
                              </button>
                          </div>
                       </div>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-success" id="guardarACTA">Guardar</button>
              </div>
          </form>
      </div>
  </div>
</div>

{{-- 
<script>
  document.getElementById("CODIGO_POSTAL").addEventListener("change", function() {
    let codigoPostal = this.value.trim();

    if (codigoPostal.length === 5) {
      fetch(`/codigo-postal/${codigoPostal}`)
        .then(response => response.json())
        .then(data => {
          if (!data.error) {
            let response = data.response;

            let coloniaSelect = document.getElementById("NOMBRE_COLONIA_EMPRESA");
            coloniaSelect.innerHTML = '<option value="">Seleccione una opción</option>';

            let colonias = Array.isArray(response.asentamiento) ? response.asentamiento : [response.asentamiento];

            colonias.forEach(colonia => {
              let option = document.createElement("option");
              option.value = colonia;
              option.textContent = colonia;
              coloniaSelect.appendChild(option);
            });

            document.getElementById("NOMBRE_MUNICIPIO_EMPRESA").value = response.municipio || "No disponible";
            document.getElementById("NOMBRE_ENTIDAD_EMPRESA").value = response.estado || "No disponible";
            document.getElementById("NOMBRE_LOCALIDAD_EMPRESA").value = response.ciudad || "No disponible";
            document.getElementById("PAIS_EMPRESA").value = response.pais || "No disponible";

          } else {
            alert("Código postal no encontrado");
          }
        })
        .catch(error => {
          console.error("Error al obtener datos:", error);
          alert("Hubo un error al consultar la API.");
        });
    }
  });
</script> --}}



<script>
  const titulosCuenta = @json($titulosCuenta);
</script>




@endsection