@extends('principal.maestraproveedores')

@section('contenido')


<style>
    body {
        font-family: 'Poppins', sans-serif;

    }

    .card {
        max-width: 800px;
        margin: 20px auto;
        border: 2px solid #007DBA;
    }

    .card-img-top {
        display: block;
        margin: 0 auto;
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
</style>




<div class="card" id="formulario_servicio" style="display: block">

    <img src="/assets/images/Colorancho.png" class="card-img-top" alt="Imagen superior">
    <div class="card-body">
        <form method="post" enctype="multipart/form-data" id="formularioALTA">
            {!! csrf_field() !!}



            <input type="hidden" class="form-control" id="ID_FORMULARIO_ALTA" name="ID_FORMULARIO_ALTA" value="0">


            <div class="col-12">
                <div class="row">
                    <div class="col-4 mb-3">
                        <label>Tipo de Proveedor *</label>
                        <select class="form-control" name="TIPO_PERSONA_ALTA" id="TIPO_PERSONA_ALTA" required>
                            <option value="" selected disabled>Seleccione una opción</option>
                            <option value="1">Nacional</option>
                            <option value="2">Extranjero</option>
                        </select>
                    </div>


                    <div class="col-4 mb-3">
                        <label>Tipo de Persona *</label>
                        <select class="form-control" name="TIPO_PERSONA_OPCION" id="TIPO_PERSONA_OPCION" required>
                            <option value="" selected disabled>Seleccione una opción</option>
                            <option value="1">Moral</option>
                            <option value="2">Física</option>
                        </select>
                    </div>
                    <div class="col-4 mb-3">
                        <label>Razón social/Nombre *</label>
                        <input type="text" class="form-control" name="RAZON_SOCIAL_ALTA" id="RAZON_SOCIAL_ALTA" required>
                    </div>
                    <div class="col-4 mb-3">
                        <label>Representante Legal *</label>
                        <input type="text" class="form-control" name="REPRESENTANTE_LEGAL_ALTA" id="REPRESENTANTE_LEGAL_ALTA" required>
                    </div>
                    <div class="col-4 mb-3">
                        <label for="RFC_LABEL">R.F.C *</label>
                        <input type="text" class="form-control" name="RFC_ALTA" id="RFC_ALTA" required readonly>
                    </div>
                    <div class="col-4 mb-3">
                        <label>Régimen </label>
                        <select class="form-control" name="REGIMEN_ALTA" id="REGIMEN_ALTA">
                            <option value="" selected disabled>Seleccione una opción</option>
                            <option value="1">General de Ley Personas Morales </option>
                            <option value="2">Personas Morales con Fines no Lucrativos </option>
                            <option value="3">Sueldos y Salarios e Ingresos Asimilados a Salarios </option>
                            <option value="4">Arrendamiento </option>
                            <option value="5">Demás ingresos </option>
                            <option value="6">Consolidación </option>
                            <option value="7">Residentes en el Extranjero sin Establecimiento Permanente en México </option>
                            <option value="8">Ingresos por Dividendos (socios y accionistas) </option>
                            <option value="9">Personas Físicas con Actividades Empresariales y Profesionales </option>
                            <option value="10">Ingresos por intereses </option>
                            <option value="11">Sin obligaciones fiscales </option>
                            <option value="12">Sociedades Cooperativas de Producción que optan por diferir sus ingresos </option>
                            <option value="13">Incorporación Fiscal </option>
                            <option value="14">Actividades Agrícolas, Ganaderas, Silvícolas y Pesqueras </option>
                            <option value="15">Opcional para Grupos de Sociedades </option>
                            <option value="16">Coordinados </option>
                            <option value="17">Hidrocarburos </option>
                            <option value="18">Régimen de Enajenación o Adquisición de Bienes </option>
                            <option value="19">De los Regimenes Fiscales Preferentes y de las Empresas Multinacionales</option>
                            <option value="20">Enajenación de acciones en bolsa de valores </option>
                            <option value="21">Régimen de los ingresos por obtención de premios </option>
                            <option value="23">Régimen simplificado de confianza </option>
                            <option value="22">Otro </option>


                        </select>
                    </div>


                    <div class="mb-3 text-center">
                        <h4><b>Datos generales</b></label>
                    </div>


                    <div class="col-12" id="DOMICILIO_NACIONAL" style="display: block;">

                        <div class="row">

                            <div class="col-3 mb-3">
                                <label>Código Postal *</label>
                                <input type="number" class="form-control" name="CODIGO_POSTAL" id="CODIGO_POSTAL" required>
                            </div>
                            <div class="col-4 mb-3">
                                <label>Tipo de Vialidad *</label>
                                <input type="text" class="form-control" name="TIPO_VIALIDAD_EMPRESA" id="TIPO_VIALIDAD_EMPRESA" required>
                            </div>
                            <div class="col-5 mb-3">
                                <label>Nombre de la Vialidad *</label>
                                <input type="text" class="form-control" name="NOMBRE_VIALIDAD_EMPRESA" id="NOMBRE_VIALIDAD_EMPRESA" required>
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
                                <select class="form-control" name="NOMBRE_COLONIA_EMPRESA" id="NOMBRE_COLONIA_EMPRESA" required>
                                    <option value="">Seleccione una opción</option>
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label>Nombre de la Localidad *</label>
                                <input type="text" class="form-control" name="NOMBRE_LOCALIDAD_EMPRESA" id="NOMBRE_LOCALIDAD_EMPRESA">
                            </div>


                            <div class="col-6 mb-3">
                                <label>Nombre del municipio o demarcación territorial *</label>
                                <input type="text" class="form-control" name="NOMBRE_MUNICIPIO_EMPRESA" id="NOMBRE_MUNICIPIO_EMPRESA" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label>Nombre de la Entidad Federativa *</label>
                                <input type="text" class="form-control" name="NOMBRE_ENTIDAD_EMPRESA" id="NOMBRE_ENTIDAD_EMPRESA" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label>País *</label>
                                <input type="text" class="form-control" name="PAIS_EMPRESA" id="PAIS_EMPRESA" required>
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
                                <input type="text" class="form-control" name="DOMICILIO_EXTRANJERO" id="DOMICILIO_EXTRANJERO" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label>Código Postal </label>
                                <input type="text" class="form-control" name="CODIGO_EXTRANJERO" id="CODIGO_EXTRANJERO" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label>Ciudad *</label>
                                <input type="text" class="form-control" name="CIUDAD_EXTRANJERO" id="CIUDAD_EXTRANJERO" required>
                            </div>

                            <div class="col-6 mb-3">
                                <label>Estado/Departamento/Provincia</label>
                                <input type="text" class="form-control" name="ESTADO_EXTRANJERO" id="ESTADO_EXTRANJERO" required>
                            </div>

                            <div class="col-6 mb-3">
                                <label>País *</label>
                                <input type="text" class="form-control" name="PAIS_EXTRANJERO" id="PAIS_EXTRANJERO" required>
                            </div>

                        </div>
                    </div>





                    <div class="col-6 mb-3">
                        <label>Correo electrónico *</label>
                        <input type="text" class="form-control" name="CORREO_DIRECTORIO" id="CORREO_DIRECTORIO" required>
                    </div>

                    <div class="col-6 mb-3">
                        <label>Teléfono oficina *</label>
                        <input type="text" class="form-control" name="TELEFONO_OFICINA_ALTA" id="TELEFONO_OFICINA_ALTA" required>
                    </div>

                    <div class="col-12 mb-3">
                        <label>Página web </label>
                        <input type="text" class="form-control" name="PAGINA_WEB_ALTA" id="PAGINA_WEB_ALTA">
                    </div>


                    <div class="mb-3 text-center">
                        <h4><b>Actividad económica y términos comerciales</b></label>
                    </div>



                    <div class="col-12 mb-3 d-flex align-items-center">
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="ACTIVIDAD_ECONOMICA" id="VENTA_PRODUCTOS" value="1" required>
                            <label class="form-check-label" for="VENTA_PRODUCTOS">Ventas de productos/bienes</label>
                        </div>
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="ACTIVIDAD_ECONOMICA" id="VENTA_SERVICIOS" value="2">
                            <label class="form-check-label" for="VENTA_SERVICIOS">Venta de servicios</label>
                        </div>
                    </div>

                    <div id="CUAL_ACTIVIAD" class="col-12 mb-3" style="display: none;">
                        <label>Cuál</label>
                        <input type="text" class="form-control" name="CUAL_ACTVIDAD_ECONOMICA" id="CUAL_ACTVIDAD_ECONOMICA">
                    </div>

                    <div class="col-12 mb-3">
                        <label>Actividad comercial principal</label>
                        <input type="text" class="form-control" name="ACTVIDAD_COMERCIAL" id="ACTVIDAD_COMERCIAL" required>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="me-3">Descuentos que ofrece</label>
                    </div>

                    <div class="col-12 mb-3 d-flex align-items-center">
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="DESCUENTOS_ACTIVIDAD_ECONOMICA" id="POR_PAGO" value="1" required>
                            <label class="form-check-label" for="POR_PAGO">Por pronto pago</label>
                        </div>
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="DESCUENTOS_ACTIVIDAD_ECONOMICA" id="POR_VOLUMEN" value="2">
                            <label class="form-check-label" for="POR_VOLUMEN">Por volumen</label>
                        </div>
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="DESCUENTOS_ACTIVIDAD_ECONOMICA" id="POR_PROMOCION" value="3">
                            <label class="form-check-label" for="POR_PROMOCION">Promociones</label>
                        </div>
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="DESCUENTOS_ACTIVIDAD_ECONOMICA" id="OTROS_DESCUENTO" onclick="cualdescuentos()" value="4">
                            <label class="form-check-label" for="OTROS_DESCUENTO">Otros</label>
                        </div>
                    </div>

                    <div id="CUAL_DESCUENTOS" class="col-12 mb-3" style="display: none;">
                        <label>Cuál</label>
                        <input type="text" class="form-control" name="CUAL_DESCUENTOS_ECONOMICA" id="CUAL_DESCUENTOS_ECONOMICA" required>
                    </div>

                    <div class="col-12 mb-3">
                        <label>Días de crédito que otorga *</label>
                        <input type="number" class="form-control" name="DIAS_CREDITO_ALTA" id="DIAS_CREDITO_ALTA">
                    </div>

                    <div class="col-12 mb-3">
                        <label>Otros términos comerciales de importancia </label>
                        <textarea type="number" class="form-control" name="TERMINOS_IMPORTANCIAS_ALTA" id="TERMINOS_IMPORTANCIAS_ALTA" rows="5"></textarea>
                    </div>







                    <div class="mb-3 text-center">
                        <h4><b>Información adicional para la debida diligencia</b></label>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">¿Usted o la compañía tiene vínculos familiares hasta en tercer grado de consanguinidad con personal que laboran en Results In Performance, sus filiales o cualquier tipo de vínculo puede ser personal o laboral que pueda generar un conflicto de interés?</label>
                        <div class="form-check d-inline-block me-3">
                            <input class="form-check-input" type="radio" name="VINCULO_FAMILIAR" id="VINCULO_SI" value="SI" onclick="vinculosres()">
                            <label class="form-check-label" for="VINCULO_SI">Si</label>
                        </div>
                        <div class="form-check d-inline-block">
                            <input class="form-check-input" type="radio" name="VINCULO_FAMILIAR" id="VINCULO_NO" value="NO">
                            <label class="form-check-label" for="VINCULO_NO">No</label>
                        </div>
                    </div>
                    <div class="col-12 mb-3" id="DIV_VINCULOS" style="display: none">
                        <label class="form-label">Describa cuál:</label>
                        <input type="text" class="form-control" name="DESCRIPCION_VINCULO" id="DESCRIPCION_VINCULO" required>
                    </div>
                    <div class="col-12 mb-3 d-flex align-items-center">
                        <label class="me-3">¿La empresa que representa ofrece servicios directos como proveedor/contratista/subcontratista a PEMEX?</label>
                    </div>
                    <div class="col-12 mb-3 d-flex align-items-center">
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="SERVICIOS_PEMEX" id="SI_NUMEROPROVEEDOR" value="SI" onclick="numeroproveedor()">
                            <label class="form-check-label" for="SI_NUMEROPROVEEDOR">Si</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="SERVICIOS_PEMEX" id="NO_NUMEROPROVEEDOR" value="NO">
                            <label class="form-check-label" for="NO_NUMEROPROVEEDOR">No</label>
                        </div>
                    </div>

                    <div class="col-12 mb-3" id="DIV_NUMEROPROVEEDOR" style="display: none">
                        <label class="form-label">No. de proveedor:</label>
                        <input type="text" class="form-control" name="NUMERO_PROVEEDOR" id="NUMERO_PROVEEDOR" required>
                    </div>

                    <div class="col-12 mb-3 d-flex align-items-center">
                        <label class="me-3">¿Alguno de sus empleados clave o miembro de la alta dirección de su organización proporciona o proporcionará beneficios financieros o de cualquier otro tipo a algún empleado de Pemex o la Sociedad, a algún funcionario de gobierno o un miembro de la familia de un funcionario de gobierno (por ejemplo, asistencia educativa o médica, vivienda), es decir, Personas Políticamente Expuestas?</label>
                    </div>
                    <div class="col-12 mb-3 d-flex align-items-center">
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="BENEFICIOS_PERSONA" id="SI_BENEFICIOS_PERSONA" value="SI" onclick="politicamentexpuesto()">
                            <label class="form-check-label" for="SI_BENEFICIOS_PERSONA">Si</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="BENEFICIOS_PERSONA" id="NO_BENEFICIOS_PERSONA" value="NO">
                            <label class="form-check-label" for="NO_BENEFICIOS_PERSONA">No</label>
                        </div>
                    </div>

                    <div class="col-12 mb-3" id="PERSONA_EXPUESTA" style="display: none">
                        <label class="form-label">Nombre de la persona políticamente expuesta:</label>
                        <input type="text" class="form-control" name="NOMBRE_PERSONA" id="NOMBRE_PERSONA" required> 
                    </div>



                </div>
            </div>




            <div class="col-12 text-center">
                <div class="col-md-6 mx-auto">
                    <button type="submit" id="guardarALTA" class="btn btn-success w-100">
                        Guardar
                    </button>
                </div>
            </div>


        </form>
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