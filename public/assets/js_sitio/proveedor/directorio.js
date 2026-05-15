ID_FORMULARIO_DIRECTORIO = 0









$("#guardarDIRECTORIO").click(async function (e) {
    e.preventDefault();

    formularioValido = validarFormulario3($('#formularioDIRECTORIO'));

    if (formularioValido) {

        var servicios = [];
        $(".generarservicio").each(function() {
            var servicio = {
                'NOMBRE_SERVICIO': $(this).find("input[name='NOMBRE_SERVICIO']").val()
            };
            servicios.push(servicio);
        });

        const requestData = {
            api: 1,
            ID_FORMULARIO_DIRECTORIO: ID_FORMULARIO_DIRECTORIO,
            SERVICIOS_JSON: JSON.stringify(servicios)
        };

        if (ID_FORMULARIO_DIRECTORIO == 0) {
            alertMensajeConfirm({
                title: "¿Desea guardar la información?",
                text: "Al guardarla, se podrá usar",
                icon: "question",
            }, async function () {
                await loaderbtn('guardarDIRECTORIO');
                await ajaxAwaitFormData(requestData, 'ServiciosSave', 'formularioDIRECTORIO', 'guardarDIRECTORIO', { callbackAfter: true, callbackBefore: true }, () => {

                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');

                }, function (data) {
                    ID_FORMULARIO_DIRECTORIO = data.servicio.ID_FORMULARIO_DIRECTORIO;

                    Swal.fire({
                        icon: 'success',
                        title: 'Información guardada correctamente',
                        confirmButtonText: 'OK',
                    }).then(() => {
                        document.getElementById('formulario_servicio').style.display = 'none';
                        document.getElementById('nav_var').style.display = 'block';

                        const sectionFinalizado = document.getElementById('sectionFinalizado');
                        sectionFinalizado.classList.remove('d-none');
                        sectionFinalizado.classList.add('d-flex');

                        document.getElementById('formularioDIRECTORIO').reset();
                        ID_FORMULARIO_DIRECTORIO = 0;
                    });
                });
            }, 1);

        } else {
            alertMensajeConfirm({
                title: "¿Desea editar la información de este formulario?",
                text: "Al guardarla, se podrá usar",
                icon: "question",
            }, async function () {
                await loaderbtn('guardarDIRECTORIO');
                await ajaxAwaitFormData(requestData, 'ServiciosSave', 'formularioDIRECTORIO', 'guardarDIRECTORIO', { callbackAfter: true, callbackBefore: true }, () => {

                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');

                }, function (data) {
                    ID_FORMULARIO_DIRECTORIO = data.servicio.ID_FORMULARIO_DIRECTORIO;

                    Swal.fire({
                        icon: 'success',
                        title: 'Información editada correctamente',
                        confirmButtonText: 'OK',
                    }).then(() => {
                        document.getElementById('formulario_servicio').style.display = 'none';
                        document.getElementById('nav_var').style.display = 'none';

                        const sectionFinalizado = document.getElementById('sectionFinalizado');
                        sectionFinalizado.classList.remove('d-none');
                        sectionFinalizado.classList.add('d-flex');

                        document.getElementById('formularioDIRECTORIO').reset();
                        ID_FORMULARIO_DIRECTORIO = 0;
                    });
                });
            }, 1);
        }
    } else {
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000);
    }
});






document.addEventListener("DOMContentLoaded", function () {
    const botonAgregarContacto = document.getElementById('botonAgregarservicio');
    
    botonAgregarContacto.addEventListener('click', function () {
        agregarContacto();
    });

    function agregarContacto() {
        const divContacto = document.createElement('div');
        divContacto.classList.add('row', 'generarservicio', 'mb-3');
        divContacto.innerHTML = `
            <div class="col-12">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Servicio *</label>
                        <input type="text" class="form-control" name="NOMBRE_SERVICIO" required>
                    </div>
                </div>
            </div>
    
          
    
            <div class="col-12 mt-4 text-center">
                <button type="button" class="btn btn-danger botonEliminarContacto">Eliminar servicio<i class="bi bi-trash-fill"></i></button>
            </div>
        `;
    
        const contenedor = document.querySelector('.serviciodiv');
        contenedor.appendChild(divContacto);
    
        divContacto.querySelector('.botonEliminarContacto').addEventListener('click', function () {
            contenedor.removeChild(divContacto);
        });
    
    }
    
});


 document.getElementById("CONSTANCIA_DOCUMENTO").addEventListener("change", function(event) {
        let fileInput = event.target;
        let removeBtn = document.getElementById("removeFileBtn");
        let errorMsg = document.getElementById("errorMsg");
        
        if (fileInput.files.length > 0) {
            let file = fileInput.files[0];
            
            if (file.type !== "application/pdf") {
                errorMsg.style.display = "block";
                fileInput.value = "";
                removeBtn.style.display = "none";
            } else {
                errorMsg.style.display = "none";
                removeBtn.style.display = "inline-block";
            }
        } else {
            errorMsg.style.display = "block";
            removeBtn.style.display = "none";
        }
    });

    document.getElementById("removeFileBtn").addEventListener("click", function() {
        let fileInput = document.getElementById("CONSTANCIA_DOCUMENTO");
        let removeBtn = document.getElementById("removeFileBtn");
        let errorMsg = document.getElementById("errorMsg");
        
        fileInput.value = "";
        removeBtn.style.display = "none";
        errorMsg.style.display = "none";
    });








    let consultaRealizada = false;

document.querySelectorAll('#RFC_PROVEEDOR').forEach(element => {
    element.addEventListener('change', function () {
        var rfc = this.value.trim();

        if (rfc && !consultaRealizada) {
            consultaRealizada = true;

            fetch('/actualizarinfoproveedor', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({ rfc: rfc })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('HTTP error, status = ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                if (data && !data.message) {
                    Swal.fire({
                        title: 'El RFC ya está registrado',
                        text: '¿Desea actualizar la información?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, actualizar',
                        cancelButtonText: 'No'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            solicitarCodigo(data.CORREO_DIRECTORIO, data);
                        } else {
                            document.getElementById('formularioDIRECTORIO').reset();
                            consultaRealizada = false;
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                consultaRealizada = false;
            });
        }
    });
});

// Función para solicitar el código de verificación
function solicitarCodigo(correo, data) {
    fetch('/enviar-codigo', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: JSON.stringify({ correo: correo })
    })
    .then(response => response.json())
    .then(() => {
        Swal.fire({
            title: 'Código Enviado',
            text: 'Revisa tu correo con el que te diste de alta.',
            input: 'text',
            inputPlaceholder: 'Introduce el código de verificación',
            showCancelButton: true,
            confirmButtonText: 'Verificar Código',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                verificarCodigoAntesDeActualizar(correo, result.value, data);
            } else {
                Swal.fire('Cancelado', 'No se actualizaron los datos.', 'error');
            }
        });
    })
    .catch(error => console.error('Error:', error));
}

// Función para verificar el código antes de permitir la actualización
function verificarCodigoAntesDeActualizar(correo, codigo, data) {
    fetch('/verificar-codigo', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: JSON.stringify({ correo: correo, codigo: codigo })
    })
    .then(response => response.json())
    .then(responseData => {
        if (responseData.message) {
            Swal.fire({
                title: 'Código Correcto',
                text: 'Ahora puedes actualizar tu información.',
                icon: 'success'
            });

            document.getElementById('ID_FORMULARIO_DIRECTORIO').value = data.ID_FORMULARIO_DIRECTORIO || '';
            document.getElementById('TIPO_PERSONA').value = data.TIPO_PERSONA || '';
            document.getElementById('RAZON_SOCIAL').value = data.RAZON_SOCIAL || '';
            document.getElementById('RFC_PROVEEDOR').value = data.RFC_PROVEEDOR || '';
            document.getElementById('NOMBRE_COMERCIAL').value = data.NOMBRE_COMERCIAL || '';
            document.getElementById('GIRO_PROVEEDOR').value = data.GIRO_PROVEEDOR || '';
            document.getElementById('TIPO_PERSONA').value = data.TIPO_PERSONA || '';

            const tipoPersona = document.getElementById("TIPO_PERSONA");
            const domicilioNacional = document.getElementById("DOMICILIO_NACIONAL");


            const domicilioExtranjero = document.getElementById("DOMICILIO_ERXTRANJERO");

            if (tipoPersona.value === "1") {
                domicilioNacional.style.display = "block";
                domicilioExtranjero.style.display = "none";

                let codigoPostalInput = document.getElementById("CODIGO_POSTAL");
                codigoPostalInput.value = data.CODIGO_POSTAL || '';

                let coloniaGuardada = data.NOMBRE_COLONIA_EMPRESA || '';
                codigoPostalInput.dispatchEvent(new Event('change'));

                let coloniaSelect = document.getElementById('NOMBRE_COLONIA_EMPRESA');
                let observer = new MutationObserver(() => {
                    if (coloniaSelect.options.length > 1) { 
                        coloniaSelect.value = coloniaGuardada; 
                        observer.disconnect(); 
                    }
                });

                observer.observe(coloniaSelect, { childList: true });

            } else if (tipoPersona.value === "2") {
                domicilioNacional.style.display = "none";

                domicilioExtranjero.style.display = "block";
                document.querySelector('label[for="CONSTANCIA_LABEL"]').textContent = "Registro ante Hacienda / Tax ID *";
                document.querySelector('label[for="RFC_LABEL"]').textContent = "Tax ID";

            }

            document.getElementById('TIPO_VIALIDAD_EMPRESA').value = data.TIPO_VIALIDAD_EMPRESA || '';
            document.getElementById('NOMBRE_VIALIDAD_EMPRESA').value = data.NOMBRE_VIALIDAD_EMPRESA || '';
            document.getElementById('NUMERO_EXTERIOR_EMPRESA').value = data.NUMERO_EXTERIOR_EMPRESA || '';
            document.getElementById('NUMERO_INTERIOR_EMPRESA').value = data.NUMERO_INTERIOR_EMPRESA || '';
            document.getElementById('NOMBRE_LOCALIDAD_EMPRESA').value = data.NOMBRE_LOCALIDAD_EMPRESA || '';
            document.getElementById('NOMBRE_MUNICIPIO_EMPRESA').value = data.NOMBRE_MUNICIPIO_EMPRESA || '';
            document.getElementById('NOMBRE_ENTIDAD_EMPRESA').value = data.NOMBRE_ENTIDAD_EMPRESA || '';
            document.getElementById('PAIS_EMPRESA').value = data.PAIS_EMPRESA || '';
            document.getElementById('ENTRE_CALLE_EMPRESA').value = data.ENTRE_CALLE_EMPRESA || '';
            document.getElementById('ENTRE_CALLE2_EMPRESA').value = data.ENTRE_CALLE2_EMPRESA || '';
            document.getElementById('NOMBRE_DIRECTORIO').value = data.NOMBRE_DIRECTORIO || '';
            document.getElementById('CARGO_DIRECTORIO').value = data.CARGO_DIRECTORIO || '';
            document.getElementById('TELEFONO_DIRECOTORIO').value = data.TELEFONO_DIRECOTORIO || '';
            document.getElementById('EXSTENSION_DIRECTORIO').value = data.EXSTENSION_DIRECTORIO || '';
            document.getElementById('CELULAR_DIRECTORIO').value = data.CELULAR_DIRECTORIO || '';
            document.getElementById('CORREO_DIRECTORIO').value = data.CORREO_DIRECTORIO || '';





            document.getElementById('DOMICILIO_EXTRANJERO').value = data.DOMICILIO_EXTRANJERO || '';
            document.getElementById('CODIGO_EXTRANJERO').value = data.CODIGO_EXTRANJERO || '';
            document.getElementById('CIUDAD_EXTRANJERO').value = data.CIUDAD_EXTRANJERO || '';
            document.getElementById('ESTADO_EXTRANJERO').value = data.ESTADO_EXTRANJERO || '';
            document.getElementById('PAIS_EXTRANJERO').value = data.PAIS_EXTRANJERO || '';



            const contenedorServicios = document.querySelector('.serviciodiv');
            contenedorServicios.innerHTML = '';

            if (Array.isArray(data.SERVICIOS_JSON)) {
                data.SERVICIOS_JSON.forEach(servicio => {
                    agregarServicio(servicio.NOMBRE_SERVICIO);
                });
            }

        } else {
            Swal.fire('Error', 'Código incorrecto o expirado.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error', 'Hubo un problema verificando el código.', 'error');
    });
}


function agregarServicio(nombreServicio = '') {
    const divContacto = document.createElement('div');
    divContacto.classList.add('row', 'generarservicio', 'mb-3');
    divContacto.innerHTML = `
        <div class="col-12">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label">Servicio *</label>
                    <input type="text" class="form-control" name="NOMBRE_SERVICIO" value="${nombreServicio}" required>
                </div>
            </div>
        </div>
        <div class="col-12 mt-4 text-center">
            <button type="button" class="btn btn-danger botonEliminarContacto">Eliminar servicio<i class="bi bi-trash-fill"></i></button>
        </div>
    `;

    const contenedor = document.querySelector('.serviciodiv');
    contenedor.appendChild(divContacto);

    divContacto.querySelector('.botonEliminarContacto').addEventListener('click', function () {
        contenedor.removeChild(divContacto);
    });
}







document.addEventListener("DOMContentLoaded", function () {
    const tipoPersona = document.getElementById("TIPO_PERSONA");


    const domicilioNacional = document.getElementById("DOMICILIO_NACIONAL");
    const domicilioExtranjero = document.getElementById("DOMICILIO_ERXTRANJERO");

    const labelDomicilio = document.querySelector('label[for="CONSTANCIA_LABEL"]');
    const labelRFC = document.querySelector('label[for="RFC_LABEL"]');

    tipoPersona.addEventListener("change", function () {
        if (this.value === "1") {
           

            domicilioNacional.style.display = "block";
            domicilioExtranjero.style.display = "none";

            labelDomicilio.textContent = "Constancia de situación fiscal *";
            labelRFC.textContent = "RFC *";

        } else if (this.value === "2") {
           

            domicilioNacional.style.display = "none";
            domicilioExtranjero.style.display = "block";

            labelDomicilio.textContent = "Registro ante Hacienda / Tax ID *";
            labelRFC.textContent = "Tax ID *";
        }
    });

    if (tipoPersona.value === "1" || tipoPersona.value === "2") {
        tipoPersona.dispatchEvent(new Event("change"));
    }
});


   