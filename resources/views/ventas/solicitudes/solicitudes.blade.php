@extends('principal.maestraventas')

@section('contenido')



<div class="contenedor-contenido">
  <ol class="breadcrumb mb-5">
    <h3 style="color: #ffffff; margin: 0;"><i class="bi bi-pencil-fill"></i>&nbsp;Solicitudes</h3>

    <button type="button" class="btn btn-light waves-effect waves-light " id="NUEVA_SOLICITUD" style="margin-left: auto;">
      Nuevo &nbsp;<i class="bi bi-plus-circle"></i>
    </button>

  </ol>

  <div class="card-body">
    <table id="Tablasolicitudes" class="table table-hover bg-white table-bordered text-center w-100 TableCustom">

    </table>
  </div>


</div>












<div class="modal modal-fullscreen fade" id="miModal_SOLICITUDES" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form method="post" enctype="multipart/form-data" id="formularioSOLICITUDES" style="background-color: #ffffff;">
        <div class="modal-header">
          <h5 class="modal-title" id="miModalLabel">Solicitudes</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          {!! csrf_field() !!}
          <div class="row">

            <div class="col-12">
              <div class="row">
                <div class="col-md-12 mb-3 text-center">
                  <h5 class="form-label"><b>Datos de la solicitud </b></h5>
                </div>
              </div>
            </div>


            <div class="col-12">
              <div class="row">
                <div class="col-md-3 mb-3">
                  <label class="form-label">Tipo de Solicitud *</label>
                  <select class="form-select" id="TIPO_SOLICITUD" name="TIPO_SOLICITUD" required>
                    <option selected disabled>Seleccione una opción</option>
                    <option value="1">Pasiva</option>
                    <option value="2">Activa</option>
                  </select>
                </div>

                <div class="col-md-3 mb-3">
                  <label class="form-label">Solicitud No.</label>
                  <input type="text" class="form-control" id="NO_SOLICITUD" name="NO_SOLICITUD" readonly>
                </div>
                <div class="col-md-3 mb-3">
                  <label class="form-label">Fecha que solicita el cliente *</label>
                  <div class="input-group">
                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_SOLICITUD" name="FECHA_SOLICITUD" required>
                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                  </div>
                </div>

                <div class="col-md-3 mb-3">
                  <label class="form-label">Fecha que se crea la solicitud *</label>
                  <div class="input-group">
                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_CREACION_SOLICITUD" name="FECHA_CREACION_SOLICITUD" required>
                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                  </div>
                </div>



              </div>
            </div>

            <div class="col-12">
              <div class="row">

                <div class="col-md-3 mb-3">
                  <label class="form-label">Medio de Contacto *</label>
                  <select class="form-control puesto" id="MEDIO_CONTACTO_SOLICITUD" name="MEDIO_CONTACTO_SOLICITUD" required>
                    <option value="0" disabled selected>Seleccione una opción</option>
                    @foreach ($medios as $medio)
                    <option value="{{ $medio->ID_CATALOGO_MEDIO }}">{{ $medio->NOMBRE_MEDIO }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-3 mb-3">
                  <label class="form-label">Tipo de Cliente *</label>
                  <select class="form-select" id="TIPO_CLIENTE_SOLICITUD" name="TIPO_CLIENTE_SOLICITUD" required>
                    <option selected disabled>Seleccione una opción</option>
                    <option value="1">Prospecto</option>
                    <option value="2">Existente</option>
                  </select>
                </div>

                <div class="col-md-3 mb-3">
                  <label class="form-label">RFC *</label>

                  <select class="form-select text-center" id="RFC_SOLICITUD" name="RFC_SOLICITUD" required>
                    <option value="0" disabled selected>Seleccione una opción</option>
                    @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->RFC_CLIENTE }}"> {{ $cliente->RAZON_SOCIAL_CLIENTE }} ({{ $cliente->RFC_CLIENTE }})</option>
                    @endforeach


                  </select>


                </div>


                <div class="col-md-3 mb-3">
                  <label class="form-label">Razón Social *</label>
                  <input type="text" class="form-control" id="RAZON_SOCIAL_SOLICITUD" name="RAZON_SOCIAL_SOLICITUD" required>
                </div>


              </div>
            </div>

            <div class="col-12">
              <div class="row">

                <div class="col-md-4 mb-3">
                  <label class="form-label">Nombre Comercial *</label>
                  <input type="text" class="form-control" id="NOMBRE_COMERCIAL_SOLICITUD" name="NOMBRE_COMERCIAL_SOLICITUD" required>
                </div>
                <div class="col-md-4 mb-3">
                  <label class="form-label">Giro de la Empresa *</label>

                  <select class="form-control puesto" id="GIRO_EMPRESA_SOLICITUD" name="GIRO_EMPRESA_SOLICITUD" required>
                    <option value="0" disabled selected>Seleccione una opción</option>
                    @foreach ($giros as $giro)
                    <option value="{{ $giro->ID_CATALOGO_GIRO_EMPRESA }}">{{ $giro->NOMBRE_GIRO }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-4 mb-3">
                  <label class="form-label">Representante Legal *</label>
                  <input type="text" class="form-control" id="REPRESENTANTE_LEGAL_SOLICITUD" name="REPRESENTANTE_LEGAL_SOLICITUD" required>
                </div>
              </div>
            </div>




            <div class="col-6  mt-3">
              <label>Seleccione dirección </label>
              <select class="form-control" id="SELECTOR_DIRECCION" name="SELECTOR_DIRECCION">
                <option value="" disabled selected>Seleccione una opción</option>
              </select>
            </div>

            <div class="col-6  mt-3">
              <label>Usar la misma dirección para el servicio *</label>
              <select class="form-select " name="MISMA_DIRRECCION" id="MISMA_DIRRECCION">
                <option value="">Seleccione una opción</option>
                <option value="Sí">Sí</option>
                <option value="No">No</option>
              </select>
            </div>

            <div class="col-12  mt-3">
              <label>Dirección del servicio *</label>
              <input type="text" class="form-control" id="DIRECCION_SOLICITUDES" name="DIRECCION_SOLICITUDES">
            </div>







            <div class="col-12">
              <div class="row">
                <div class="col-md-12 mt-3">
                  <label class="form-label">Servicio Solicitado *</label>
                  <textarea class="form-control" id="SERVICIO_SOLICITADO_SOLICITUD" name="SERVICIO_SOLICITADO_SOLICITUD" rows="2"></textarea>
                </div>

                <div class="col-md-6 mt-3">
                  <label class="form-label">Necesidad del Servicio *</label>
                  <select class="form-control puesto" id="NECESIDAD_SERVICIO_SOLICITUD" name="NECESIDAD_SERVICIO_SOLICITUD" required>
                    <option value="0" disabled selected>Seleccione una opción</option>
                    @foreach ($necesidades as $necesidad)
                    <option value="{{ $necesidad->ID_CATALOGO_NECESIDAD_SERVICIO }}">{{ $necesidad->DESCRIPCION_NECESIDAD }}</option>
                    @endforeach
                  </select>
                </div>


                <div class="col-md-3 mt-3">
                  <label class="form-label">Línea de negocios *</label>
                  <select class="form-select" id="LINEA_NEGOCIO_SOLICITUD" name="LINEA_NEGOCIO_SOLICITUD" required>
                    <option value="0" disabled selected>Seleccione una opción</option>
                    @foreach ($lineas as $linea)
                    <option value="{{ $linea->ID_CATALOGO_LINEA_NEGOCIOS }}">{{ $linea->NOMBRE_LINEA }}</option>
                    @endforeach
                  </select>
                </div>


                <div class="col-md-3 mt-3">
                  <label class="form-label">Tipo de servicio *</label>
                  <select class="form-select" id="TIPO_SERVICIO_SOLICITUD" name="TIPO_SERVICIO_SOLICITUD" required>
                    <option value="0" disabled selected>Seleccione una opción</option>
                    @foreach ($tipos as $tipo)
                    <option value="{{ $tipo->ID_CATALOGO_TIPO_SERVICIO }}">{{ $tipo->NOMBRE_TIPO_SERVICIO }}</option>
                    @endforeach
                  </select>
                </div>


              </div>
            </div>


            <div class="col-12">
              <div class="row">
                <div class="col-md-12 mt-3 text-center">
                  <h5 class="form-label"><b>El servicio solicitado es para un tercero</b></h5>
                  <br>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="SERVICIO_TERCERO" id="servicioPropio" value="0" onchange="handleServicioChange()" required>
                    <label class="form-check-label" for="servicioPropio">No</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="SERVICIO_TERCERO" id="servicioParaTercero" value="1" onchange="handleServicioChange()">
                    <label class="form-check-label" for="servicioParaTercero">Sí</label>
                  </div>
                </div>
              </div>
            </div>



            <div id="empresaDatos" style="display: none;">
              <div class="col-12">
                <div class="row">
                  <div class="col-md-4 mb-3">
                    <label class="form-label">RFC *</label>
                    <input type="text" class="form-control" name="RFC_EMPRESA" id="RFC_EMPRESA">
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="form-label">Razón Social *</label>
                    <input type="text" class="form-control" name="RAZON_SOCIAL" id="RAZON_SOCIAL">
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="form-label">Nombre Comercial *</label>
                    <input type="text" class="form-control" name="NOMBRE_COMERCIAL_EMPRESA" id="NOMBRE_COMERCIAL_EMPRESA">
                  </div>
                </div>
              </div>

              <div class="col-12">
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Giro de la Empresa *</label>
                    <input type="text" class="form-control" name="GIRO_EMPRESA" id="GIRO_EMPRESA">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Representante Legal</label>
                    <input type="text" class="form-control" name="REPRESENTANTE_LEGAL_EMPRESA" id="REPRESENTANTE_LEGAL_EMPRESA">
                  </div>
                </div>
              </div>




              <div class="col-12">
                <div class="row">

                  <div class="col-3 mb-3">
                    <label>Tipo de Domicilio *</label>
                    <input type="text" class="form-control" name="TIPO_EMPRESA" id="TIPO_EMPRESA">
                  </div>

                  <div class="col-3 mb-3">
                    <label>Código Postal *</label>
                    <input type="number" class="form-control" name="CODIGO_POSTAL" id="CODIGO_POSTAL">
                  </div>
                  <div class="col-3 mb-3">
                    <label>Tipo de Vialidad *</label>
                    <input type="text" class="form-control" name="TIPO_VIALIDAD_EMPRESA" id="TIPO_VIALIDAD_EMPRESA">
                  </div>
                  <div class="col-3 mb-3">
                    <label>Nombre de la Vialidad *</label>
                    <input type="text" class="form-control" name="NOMBRE_VIALIDAD_EMPRESA" id="NOMBRE_VIALIDAD_EMPRESA">
                  </div>
                </div>
              </div>

              <div class="col-12">
                <div class="row">
                  <div class="col-3 mb-3">
                    <label>Número Exterior</label>
                    <input type="text" class="form-control" name="NUMERO_EXTERIOR_EMPRESA" id="NUMERO_EXTERIOR_EMPRESA">
                  </div>
                  <div class="col-3 mb-3">
                    <label>Número Interior</label>
                    <input type="text" class="form-control" name="NUMERO_INTERIOR_EMPRESA" id="NUMERO_INTERIOR_EMPRESA">
                  </div>
                  <div class="col-3 mb-3">
                    <label>Nombre de la colonia *</label>
                    <select class="form-control" name="NOMBRE_COLONIA_EMPRESA" id="NOMBRE_COLONIA_EMPRESA">
                      <option value="">Seleccione una opción</option>
                    </select>
                  </div>
                  <div class="col-3 mb-3">
                    <label>Nombre de la Localidad *</label>
                    <input type="text" class="form-control" name="NOMBRE_LOCALIDAD_EMPRESA" id="NOMBRE_LOCALIDAD_EMPRESA">
                  </div>
                </div>
              </div>

              <div class="col-12">
                <div class="row">
                  <div class="col-4 mb-3">
                    <label>Nombre del municipio o demarcación territorial *</label>
                    <input type="text" class="form-control" name="NOMBRE_MUNICIPIO_EMPRESA" id="NOMBRE_MUNICIPIO_EMPRESA">
                  </div>
                  <div class="col-4 mb-3">
                    <label>Nombre de la Entidad Federativa *</label>
                    <input type="text" class="form-control" name="NOMBRE_ENTIDAD_EMPRESA" id="NOMBRE_ENTIDAD_EMPRESA">
                  </div>
                  <div class="col-4 mb-3">
                    <label>País *</label>
                    <input type="text" class="form-control" name="PAIS_EMPRESA" id="PAIS_EMPRESA">
                  </div>
                </div>
              </div>

              <div class="col-12">
                <div class="row">
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



            </div>





            <div class="row">
              <div class="mb-3">
                <div class="row">
                  <div class="col-6 mb-3">
                    <label>Agregar observaciones</label>
                    <button id="botonAgregarobservaciones" id="botonAgregarobservaciones" type="button" class="btn btn-danger ml-2 rounded-pill" title="Agregar">
                      <i class="bi bi-plus-circle-fill"></i>
                    </button>
                  </div>
                </div>
                <div class="observacionesdiv mt-4"></div>
              </div>
            </div>










            <div class="col-12">
              <div class="row">
                <div class="col-md-12 mb-3 text-center">
                  <h5 class="form-label"><b>Datos del contacto</b> </h5>
                </div>
              </div>
            </div>



            <div class="col-12  mt-3">
              <label>Seleccione contacto </label>
              <select class="form-control" id="SELECTOR_CONTACTO" name="SELECTOR_CONTACTO">
                <option value="" disabled selected>Seleccione una opción</option>
              </select>
            </div>



            <div class="col-12">
              <div class="row">
                <div class="col-md-2 mt-3">
                  <label class="form-label">Título</label>
                  <select class="form-select" name="TITULO_CONTACTO_SOLICITUD" id="TITULO_CONTACTO_SOLICITUD">
                    <option value="0" disabled selected>Seleccione una opción</option>
                    @foreach ($titulosCuenta as $linea)
                    <option value="{{ $linea->ABREVIATURA_TITULO }}">{{ $linea->NOMBRE_TITULO }}</option>
                    @endforeach
                  </select>





                </div>
                <div class="col-md-4 mt-3">
                  <label class="form-label">Nombre *</label>
                  <input type="text" class="form-control" name="CONTACTO_SOLICITUD" id="CONTACTO_SOLICITUD">
                </div>
                <div class="col-md-6 mt-3">
                  <label class="form-label">Cargo *</label>
                  <input type="text" class="form-control" name="CARGO_SOLICITUD" id="CARGO_SOLICITUD">
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="row">
                <div class="col-md-3 mt-3">
                  <label class="form-label">Teléfono</label>
                  <input type="text" class="form-control" name="TELEFONO_SOLICITUD" id="TELEFONO_SOLICITUD">
                </div>
                <div class="col-md-3 mt-3">
                  <label class="form-label">Extensión</label>
                  <input type="text" class="form-control" name="EXTENSION_SOLICITUD" id="EXTENSION_SOLICITUD">
                </div>
                <div class="col-md-3 mt-3">
                  <label class="form-label">Celular *</label>
                  <input type="text" class="form-control" name="CELULAR_SOLICITUD" id="CELULAR_SOLICITUD">
                </div>
                <div class="col-md-3 mt-3">
                  <label class="form-label">Correo electrónico *</label>
                  <input type="email" class="form-control" name="CORREO_SOLICITUD" id="CORREO_SOLICITUD">
                </div>
              </div>
            </div>




            <div class="col-md-12 mt-4 text-center">
              <h5 class="form-label"><b>A quien se dirige la oferta</b></h5>
              <br>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="DIRIGE_OFERTA" id="mismoContacto" value="1" onchange="handleRadioChange()" required>
                <label class="form-check-label" for="mismoContacto">Mismo contacto</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="DIRIGE_OFERTA" id="aQuienCorresponda" value="0" onchange="handleRadioChange()">
                <label class="form-check-label" for="aQuienCorresponda">A quien corresponda</label>
              </div>

              <!-- Selector de contacto dinámico -->
            </div>




            <div class="col-12">
              <div class="row">


                <div class="col-md-2 mt-3">
                  <label class="form-label">Título</label>
                  <select class="form-select" name="TITULO_OFERTA" id="TITULO_OFERTA">
                    <option value="0" disabled selected>Seleccione una opción</option>
                    @foreach ($titulosCuenta as $linea)
                    <option value="{{ $linea->ABREVIATURA_TITULO }}">{{ $linea->NOMBRE_TITULO }}</option>
                    @endforeach
                  </select>
                </div>


                <div class="col-md-5 mt-3">
                  <label class="form-label">Nombre *</label>
                  <input type="text" class="form-control" id="CONTACTO_OFERTA" name="CONTACTO_OFERTA">
                </div>
                <div class="col-md-5 mt-3">
                  <label class="form-label">Cargo *</label>
                  <input type="text" class="form-control" id="CARGO_OFERTA" name="CARGO_OFERTA">
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="row">
                <div class="col-md-3 mt-3">
                  <label class="form-label">Teléfono </label>
                  <input type="text" class="form-control" id="TELEFONO_OFERTA" name="TELEFONO_OFERTA">
                </div>
                <div class="col-md-3 mt-3">
                  <label class="form-label">Extensión </label>
                  <input type="text" class="form-control" id="EXTENSION_OFERTA" name="EXTENSION_OFERTA">
                </div>
                <div class="col-md-3 mt-3">
                  <label class="form-label">Celular </label>
                  <input type="text" class="form-control" id="CELULAR_OFERTA" name="CELULAR_OFERTA">
                </div>
                <div class="col-md-3 mt-3">
                  <label class="form-label">Correo electronico </label>
                  <input type="email" class="form-control" id="CORREO_OFERTA" name="CORREO_OFERTA">
                </div>
              </div>
            </div>



            <div class="col-12">
              <div class="row">
                <div class="col-md-12 mt-5 text-center">
                  <h5 class="form-label"><b>Se procede a cotizar al cliente </b></h5>
                  <br>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="PROCEDE_COTIZAR" id="procedeno" value="0">
                    <label class="form-check-label" for="procedeno">No</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="PROCEDE_COTIZAR" id="procedesi" value="1">
                    <label class="form-check-label" for="procedesi">Sí</label>
                  </div>
                </div>
              </div>
            </div>




            <div class="col-12 mt-3" id="RECHAZO" style="display: none;">
              <div class="mb-3">
                <label class="form-label">Motivo del rechazo</label>
                <textarea class="form-control" id="MOTIVO_RECHAZO" name="MOTIVO_RECHAZO" rows="4" readonly></textarea>
              </div>
            </div>



          </div>
        </div>

        <div class="modal-footer mx-5">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-success" id="guardarSOLICITUD">
            <i class="bi bi-floppy-fill" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Guardar solicitud"></i> Guardar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>





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
</script>






@endsection