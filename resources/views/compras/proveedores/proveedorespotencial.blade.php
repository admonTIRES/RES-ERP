@extends('principal.maestracompras')

@section('contenido')



<style>
  .fila-verde {
    background-color: #d4edda !important;
  }
</style>

<div class="contenedor-contenido">
  <ol class="breadcrumb mb-5" style="display: flex; justify-content: center; align-items: center;">
    <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-person-lines-fill"></i> &nbsp; Banco de proveedores
    </h3>

  </ol>

  <div class="card-body">
    <table id="Tabladirectorio" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">

    </table>
  </div>
</div>




<div class="modal modal-fullscreen fade" id="miModal_POTENCIALES" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form method="post" enctype="multipart/form-data" id="formularioDIRECTORIO" style="background-color: #ffffff;">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Proveedores</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          {!! csrf_field() !!}

          <!-- Nav tabs -->
          <ul class="nav nav-tabs mb-3" id="tabsCliente" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="tab1-info" data-bs-toggle="tab" data-bs-target="#contenido-info" type="button" role="tab">Información del proveedor</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="tab2-verif" data-bs-toggle="tab" data-bs-target="#contenido-verif" type="button" role="tab">Verificación/validación del proveedor</button>
            </li>

          </ul>

          <!-- Tab contents -->
          <div class="tab-content">
            <!-- TAB 1: Información del cliente -->
            <div class="tab-pane fade show active" id="contenido-info" role="tabpanel">


              <input type="hidden" class="form-control" id="ID_FORMULARIO_DIRECTORIO" name="ID_FORMULARIO_DIRECTORIO" value="0">


              <div class="col-12">
                <div class="row">
                  <div class="col-4 mb-3">
                    <label>Tipo de Persona *</label>
                    <select class="form-control" name="TIPO_PERSONA" id="TIPO_PERSONA" required>
                      <option value="" selected disabled>Seleccione una opción</option>
                      <option value="1">Nacional</option>
                      <option value="2">Extranjera</option>
                    </select>
                  </div>

                  <div class="col-4 mb-3">
                    <label>Razón social/Nombre *</label>
                    <input type="text" class="form-control" id="RAZON_SOCIAL" name="RAZON_SOCIAL" required>
                  </div>
                  <div class="col-4 mb-3">
                    <label for="RFC_LABEL">RFC *</label>
                    <input type="text" class="form-control" id="RFC_PROVEEDOR" name="RFC_PROVEEDOR" required>
                  </div>
                  <div class="col-6 mb-3">
                    <label>Nombre comercial </label>
                    <input type="text" class="form-control" id="NOMBRE_COMERCIAL" name="NOMBRE_COMERCIAL">
                  </div>

                  <div class="col-6 mb-3">
                    <label>Giro * </label>
                    <input type="text" class="form-control" id="GIRO_PROVEEDOR" name="GIRO_PROVEEDOR" required>
                  </div>
                </div>
              </div>


              <div class="mb-3">
                <h4><b>Domicilio</b></label>
              </div>

              <div class="col-12" id="DOMICILIO_NACIONAL" style="display: block;">
                <div class="row">

                  <div class="col-3 mb-3">
                    <label>Código Postal *</label>
                    <input type="number" class="form-control" name="CODIGO_POSTAL" id="CODIGO_POSTAL">
                  </div>
                  <div class="col-4 mb-3">
                    <label>Tipo de Vialidad *</label>
                    <input type="text" class="form-control" name="TIPO_VIALIDAD_EMPRESA" id="TIPO_VIALIDAD_EMPRESA">
                  </div>
                  <div class="col-5 mb-3">
                    <label>Nombre de la Vialidad *</label>
                    <input type="text" class="form-control" name="NOMBRE_VIALIDAD_EMPRESA" id="NOMBRE_VIALIDAD_EMPRESA">
                  </div>

                  <div class="col-3 mb-3">
                    <label>Número Exterior</label>
                    <input type="text" class="form-control" name="NUMERO_EXTERIOR_EMPRESA" id="NUMERO_EXTERIOR_EMPRESA">
                  </div>
                  <div class="col-3 mb-3">
                    <label>Número Interior</label>
                    <input type="text" class="form-control" name="NUMERO_INTERIOR_EMPRESA" id="NUMERO_INTERIOR_EMPRESA">
                  </div>
                  <div class="col-6 mb-3">
                    <label>Nombre de la colonia *</label>
                    <select class="form-control" name="NOMBRE_COLONIA_EMPRESA" id="NOMBRE_COLONIA_EMPRESA">
                      <option value="">Seleccione una opción</option>
                    </select>
                  </div>
                  <div class="col-6 mb-3">
                    <label>Nombre de la Localidad *</label>
                    <input type="text" class="form-control" name="NOMBRE_LOCALIDAD_EMPRESA" id="NOMBRE_LOCALIDAD_EMPRESA">
                  </div>


                  <div class="col-6 mb-3">
                    <label>Nombre del municipio o demarcación territorial *</label>
                    <input type="text" class="form-control" name="NOMBRE_MUNICIPIO_EMPRESA" id="NOMBRE_MUNICIPIO_EMPRESA">
                  </div>
                  <div class="col-6 mb-3">
                    <label>Nombre de la Entidad Federativa *</label>
                    <input type="text" class="form-control" name="NOMBRE_ENTIDAD_EMPRESA" id="NOMBRE_ENTIDAD_EMPRESA">
                  </div>
                  <div class="col-6 mb-3">
                    <label>País *</label>
                    <input type="text" class="form-control" name="PAIS_EMPRESA" id="PAIS_EMPRESA">
                  </div>



                  <div class="col-6 mb-3">
                    <label>Entre Calle</label>
                    <input type="text" class="form-control" name="ENTRE_CALLE_EMPRESA" id="ENTRE_CALLE_EMPRESA">
                  </div>
                  <div class="col-6 mb-3">
                    <label>Y Calle</label>
                    <input type="text" class="form-control" name="ENTRE_CALLE2_EMPRESA" id="ENTRE_CALLE2_EMPRESA">
                  </div>
                </div>
              </div>


              <div class="col-12" id="DOMICILIO_ERXTRANJERO" style="display: none;">

                <div class="row">

                  <div class="col-12 mb-3">
                    <label>Domicilio *</label>
                    <input type="text" class="form-control" name="DOMICILIO_EXTRANJERO" id="DOMICILIO_EXTRANJERO">
                  </div>
                  <div class="col-6 mb-3">
                    <label>Código Postal</label>
                    <input type="text" class="form-control" name="CODIGO_EXTRANJERO" id="CODIGO_EXTRANJERO">
                  </div>
                  <div class="col-6 mb-3">
                    <label>Ciudad *</label>
                    <input type="text" class="form-control" name="CIUDAD_EXTRANJERO" id="CIUDAD_EXTRANJERO">
                  </div>

                  <div class="col-6 mb-3">
                    <label>Estado/Departamento/Provincia</label>
                    <input type="text" class="form-control" name="ESTADO_EXTRANJERO" id="ESTADO_EXTRANJERO">
                  </div>

                  <div class="col-6 mb-3">
                    <label>País *</label>
                    <input type="text" class="form-control" name="PAIS_EXTRANJERO" id="PAIS_EXTRANJERO">
                  </div>

                </div>
              </div>

              <div class="mb-3">
                <h4><b>Contacto</b></label>
              </div>


              <div class="col-12">
                <div class="row">

                  <div class="col-7 mb-3">
                    <label>Nombre *</label>
                    <input type="text" class="form-control" name="NOMBRE_DIRECTORIO" id="NOMBRE_DIRECTORIO" required>
                  </div>
                  <div class="col-5 mb-3">
                    <label>Cargo *</label>
                    <input type="text" class="form-control" name="CARGO_DIRECTORIO" id="CARGO_DIRECTORIO" required>
                  </div>
                  <div class="col-4 mb-3">
                    <label>Teléfono *</label>
                    <input type="text" class="form-control" name="TELEFONO_DIRECOTORIO" id="TELEFONO_DIRECOTORIO" required>
                  </div>
                  <div class="col-4 mb-3">
                    <label>Extensión </label>
                    <input type="text" class="form-control" name="EXSTENSION_DIRECTORIO" id="EXSTENSION_DIRECTORIO">
                  </div>
                  <div class="col-4 mb-3">
                    <label>Celular </label>
                    <input type="text" class="form-control" name="CELULAR_DIRECTORIO" id="CELULAR_DIRECTORIO">
                  </div>

                  <div class="col-12 mb-3">
                    <label>Correo electrónico *</label>
                    <input type="text" class="form-control" name="CORREO_DIRECTORIO" id="CORREO_DIRECTORIO" required>
                  </div>
                </div>
              </div>

             
              <div class="row">
                <div class="mb-3">
                  <div class="row">
                    <div class="col-6 mb-3">
                      <label>Añada servicios</label>
                      <button id="botonAgregarservicio" type="button" class="btn btn-danger ml-2 rounded-pill" title="Agregar">
                        <i class="bi bi-plus-circle-fill"></i>
                      </button>
                    </div>
                  </div>
                  <div class="serviciodiv mt-4"></div>
                </div>
              </div>


              <div class="mt-3 d-flex align-items-center">
                <input type="file" class="form-control" id="CONSTANCIA_DOCUMENTO" name="CONSTANCIA_DOCUMENTO" accept=".pdf" style="width: auto; flex: 1;">
                <button id="removeFileBtn" type="button" class="btn btn-danger ms-2" style="display: none;">Eliminar</button>
              </div>
              <div id="errorMsg" class="text-danger ms-2" style="display: none;">Solo se permiten archivos PDF.</div>

              <br><br>

              <div style="text-align: center;" id="PROVEEDORES_VALIDACION">
                <button class="btn btn-success btn-verificar-proveedor" style="width: 70%;">
                  Verificar proveedor <i class="fa fa-check-circle"></i>
                </button>
              </div>




            </div>

            <!-- TAB 2: Verificación del cliente -->
            <div class="tab-pane fade" id="contenido-verif" role="tabpanel">
              <ol class="breadcrumb mb-5">
                <h3 style="color: #ffffff; margin: 0;">&nbsp;Verificación/validación del proveedor</h3>
                <button type="button" class="btn btn-light waves-effect waves-light" id="NUEVA_VERIFICACION" style="margin-left: auto;">
                  Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
                </button>
              </ol>

              <div class="card-body">
                <div class="card-body position-relative" id="tabla_activo" style="display: block;">
                  <i id="loadingIcon" class="bi bi-arrow-repeat position-absolute spin" style="top: 10px; left: 10px; font-size: 24px; display: none;"></i>
                  <table id="Tablaverificacionproveedor" class="table table-hover bg-white table-bordered text-center w-100 TableCustom"></table>
                </div>
              </div>
            </div>


          </div>
        </div>

        <div class="modal-footer mx-5">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-success" id="guardarDIRECTORIO">
            <i class="bi bi-floppy-fill" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Guardar "></i> Guardar
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
          <h1 class="modal-title fs-5" id="exampleModalLabel">Nueva verificación/validación</h1>
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


<script>
  document.getElementById("CODIGO_POSTAL").addEventListener("change", function() {
    let codigoPostal = this.value.trim();

    if (codigoPostal.length === 5) {
      fetch(`/codigo-postal/${codigoPostal}`, {
          method: 'GET',
          headers: {
            'Accept': 'application/json'
          }
        })
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
</script>

@endsection