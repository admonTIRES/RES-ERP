<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="icon" type="image/png" sizes="20x20" href="/assets/images/favicon.png">
  <title>Results In Performance</title>


  <!-- Bootstrap  iconos v1.11.3 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- Bootstrap v.5.2 -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css" rel="stylesheet">
  <!-- Datatables 1.13.1  v.5.2 -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" />
  <!--Animación -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/loadingio/loading.css@v2.0.0/dist/loading.css​">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/loadingio/loading.css@v2.0.0/dist/loading.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/loadingio/transition.css@v2.0.0/dist/transition.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/loadingio/transition.css@v2.0.0/dist/transition.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/loadingio/ldcover/dist/index.min.css">
  <!-- Select opcion selectize -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.default.min.css" />
  <!--Archivo css -->
  <link rel="stylesheet" href="assets/css/estilos.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

</head>

<body>


  <style>
    body {
      font-family: 'Poppins', sans-serif;
      /* Aplicar la fuente Maven Pro */
      /* background-color: #007DBA; */
    }

    .card {
      /* max-width: 1899px; */
      max-width: 800px;
      margin: 20px auto;
      border: 2px solid #007DBA;
    }

    .card-img-top {
      display: block;
      margin: 0 auto;
      /* width: 26%; */
      width: 50%;

      height: auto;
    }


    #contador {
      font-size: 12px;
      color: gray;
    }

    /* #mensaje {
        margin-top: 5px;
        color: red;  
    } */


    #mensaje {
      font-size: 0.9em;
      color: green;
    }

    #error {
      font-size: 0.9em;
      color: red;
    }

    .modal-header img {
      position: absolute;
      right: 10px;
      top: 10px;
      max-height: 50px;
    }

    .modal-footer {
      justify-content: center;
    }

    .modal-content {
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(16, 16, 16, 0.958);
    }

    .modal-body {
      font-size: 1rem;
    }

    .modal-backdrop.show {
      opacity: 1;
    }

    .modal-backdrop {
      background-color: rgba(16, 16, 16, 0.963);
    }

    .btn-light.btn-sm {
      background-color: white;
      color: black;
      border: 1px solid #ced4da;
      padding: 0.25rem 0.5rem;
      font-size: 0.875rem;
    }

    .btn-light.btn-sm:hover {
      background-color: #e2e6ea;
    }

    .text-danger {
      font-size: 0.875rem;
      margin-top: 5px;
    }

    .add-button {
      padding: 5px 10px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .add-button i {
      margin-right: 5px;
    }

    .small-checkbox {
      width: 20px;
      height: 20px;
    }

    .texto-mayusculas {
      text-transform: uppercase;
    }
  </style>



  </head>

  <body>


    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: transparent; background-image: url(/assets/images/Logo3.png); background-size: cover; display: block" id="nav_var">
      <div class="container-fluid">
        <a class="navbar-brand" href="http://www.results-in-performance.com/">
          <img src="/assets/images/logoBlanco.png" class="ld ld-wander-h m-2" style="animation-duration:3.0s; width: 170px;" alt="Logo">

        </a>
      </div>
    </nav>



    <div class="card" id="formulario_servicio" style="display: block">

      <img src="/assets/images/Colorancho.png" class="card-img-top" alt="Imagen superior">
      <div class="card-body">
        <form method="post" enctype="multipart/form-data" id="formularioDIRECTORIO">
          {!! csrf_field() !!}



          <input type="hidden" class="form-control" id="ID_FORMULARIO_DIRECTORIO" name="ID_FORMULARIO_DIRECTORIO" value="0">


          <div class="col-12">
            <div class="row">
              <div class="col-4 mb-3">
                <label>Tipo de Persona *</label>
                <select class="form-control" name="TIPO_PERSONA" id="TIPO_PERSONA" required>
                  <option value="" selected disabled>Seleccione una opción</option>
                  <option value="1">Nacional</option>
                  <option value="2">Extranjero</option>
                </select>
              </div>

              <div class="col-4 mb-3">
                <label>Razón social/Nombre *</label>
                <input type="text" class="form-control" id="RAZON_SOCIAL" name="RAZON_SOCIAL" required>
              </div>
              <div class="col-4 mb-3">
                <label for="RFC_LABEL" translate="no">R.F.C *</label>
                <input type="text" class="form-control texto-mayusculas" id="RFC_PROVEEDOR" name="RFC_PROVEEDOR" required>
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
                  <label>Añada 1 o más de sus principales servicios</label>
                  <button id="botonAgregarservicio" type="button" class="btn btn-danger ml-2 rounded-pill" title="Agregar">
                    <i class="bi bi-plus-circle-fill"></i>
                  </button>
                </div>
              </div>
              <div class="serviciodiv mt-4"></div>
            </div>
          </div>

          <label for="CONSTANCIA_LABEL" translate="no">Constancia de situación fiscal *</label>

          <div class="mt-3 d-flex align-items-center">
            <input type="file" class="form-control" id="CONSTANCIA_DOCUMENTO" name="CONSTANCIA_DOCUMENTO" accept=".pdf" style="width: auto; flex: 1;" required>
            <button id="removeFileBtn" type="button" class="btn btn-danger ms-2" style="display: none;">Eliminar</button>
          </div>
          <div id="errorMsg" class="text-danger ms-2" style="display: none;">Solo se permiten archivos PDF.</div>


          <div class="col-12 text-center mt-4">
            <div class="col-md-6 mx-auto">
              <button type="submit" id="guardarDIRECTORIO" class="btn btn-success w-100">
                Guardar
              </button>
            </div>
          </div>


        </form>
      </div>
    </div>



    <section id="sectionFinalizado" class="container  mt-5 d-none justify-content-center " style="height: 100vh;">
      <div class="row justify-content-center">
        <div class="col-12">
          <div class="card text-center" style="border-radius: 12px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); margin: 10px;">
            <div class="card-header" style="background-color: #88bd23; color: #fff; font-weight: bold; border-radius: 12px 12px 0 0;">
              <h6 class="card-title m-0" style="font-size: 1.5rem; font-weight: bold; color: #ffffff;">
                <i class="fa fa-check-circle" style="color: #ffffff;"></i>
                Información guardada correctamente
              </h6>
            </div>
            <div class="card-body">
              <p class="lead mt-3 mb-3">
                <i class="fa fa-check-circle" style="color: #88bd23;"></i>
                Su información ha sido guardada exitosamente.
              </p>
              <a href="https://results-in-performance.com/" class="btn" style="background-color: #28a745; color: #fff; padding: 10px 20px; font-size: 1.2rem; font-weight: bold; border-radius: 5px; text-decoration: none;">
                Regresar
              </a>
            </div>
            <div class="card-footer text-muted" style="background-color: #009bcf; color: #fff; font-weight: bold; border-radius: 0 0 12px 12px;">
              <h6 class="card-title m-0" style="font-size: 1rem; font-weight: bold; color: #ffffff;">
                Results In Performance
              </h6>
            </div>
          </div>
        </div>
      </div>
    </section>










    <!-- Jquery 3.6.4-->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!--Bootstrap -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>
    <!-- Datatables 1.13.1  v.5.2 -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Animación -->
    <script src="https://cdn.jsdelivr.net/gh/loadingio/ldcover/dist/index.min.js"></script>
    <!-- Select opcion selectize -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>
    <!-- Funciones generales -->
    <script src="/assets/js_sitio/funciones.js?v=5.2"></script>
    <script src="/assets/js_sitio/proveedor/directorio.js?v=1.10"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>




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



      document.addEventListener('input', function(event) {
        const target = event.target;

        // Caso especial: RFC_PROVEEDOR siempre en mayúsculas
        if (target.id === 'RFC_PROVEEDOR') {
          target.value = target.value.toUpperCase();
          return; // salimos aquí para que no entre al capitalizador
        }

        // Para inputs text y textareas -> capitalización normal
        if ((target.tagName === 'INPUT' && target.type === 'text') || target.tagName === 'TEXTAREA') {
          const palabras = target.value.split(' ').map(palabra => {
            if (palabra.length === 0) return '';

            const primeraMayuscula = palabra[0].toUpperCase() + palabra.substring(1).toLowerCase();

            if (palabra !== palabra.toLowerCase() && palabra !== primeraMayuscula) {
              return primeraMayuscula;
            } else {
              return palabra;
            }
          });

          target.value = palabras.join(' ');
        }
      });
    </script>



  </body>

</html>