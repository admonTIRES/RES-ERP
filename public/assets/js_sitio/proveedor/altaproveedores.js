//VARIABLES
ID_FORMULARIO_ALTA = 0





 function cualactividad() {
        var otrosCheckbox = document.getElementById('OTROS_ACTIVIDAD');
        var actividadDiv = document.getElementById('CUAL_ACTIVIAD');
        actividadDiv.style.display = otrosCheckbox.checked ? 'block' : 'none';
}
    


function cualdescuentos() {
    var otrosCheckbox = document.getElementById('OTROS_DESCUENTO');
    var actividadDiv = document.getElementById('CUAL_DESCUENTOS');
    
    actividadDiv.style.display = otrosCheckbox.checked ? 'block' : 'none';
}

document.addEventListener("DOMContentLoaded", function () {
    var radios = document.getElementsByName('DESCUENTOS_ACTIVIDAD_ECONOMICA');
    radios.forEach(function (radio) {
        radio.addEventListener("change", cualdescuentos);
    });
});

    
function vinculosres() {
    var otrosCheckbox = document.getElementById('VINCULO_SI');
    var actividadDiv = document.getElementById('DIV_VINCULOS');
    
    // Verifica si "Otros" está seleccionado
    actividadDiv.style.display = otrosCheckbox.checked ? 'block' : 'none';
}

document.addEventListener("DOMContentLoaded", function () {
    var radios = document.getElementsByName('VINCULO_FAMILIAR');
    radios.forEach(function (radio) {
        radio.addEventListener("change", vinculosres);
    });
});

   
function numeroproveedor() {
    var otrosCheckbox = document.getElementById('SI_NUMEROPROVEEDOR');
    var actividadDiv = document.getElementById('DIV_NUMEROPROVEEDOR');
    
    // Verifica si "Otros" está seleccionado
    actividadDiv.style.display = otrosCheckbox.checked ? 'block' : 'none';
}

document.addEventListener("DOMContentLoaded", function () {
    var radios = document.getElementsByName('SERVICIOS_PEMEX');
    radios.forEach(function (radio) {
        radio.addEventListener("change", numeroproveedor);
    });
});


function politicamentexpuesto() {
    var otrosCheckbox1 = document.getElementById('SI_BENEFICIOS_PERSONA');
    var actividadDiv1 = document.getElementById('PERSONA_EXPUESTA');
    
    actividadDiv1.style.display = otrosCheckbox1.checked ? 'block' : 'none';
}



document.addEventListener("DOMContentLoaded", function () {
    var textarea = document.getElementById("TERMINOS_IMPORTANCIAS_ALTA");
    var counter = document.createElement("span");
    counter.id = "charCounter";
    counter.style.display = "block";
    counter.style.marginTop = "5px";
    counter.style.color = "red";
    
    textarea.parentNode.appendChild(counter);

    textarea.addEventListener("input", function () {
        if (this.value.length > 300) {
            this.value = this.value.substring(0, 300); // Limita a 300 caracteres
        }
        counter.textContent = `${this.value.length}/300`; // Muestra caracteres escritos / total
    });

    counter.textContent = "0/300";
});





$("#guardarALTA").click(function (e) {
    e.preventDefault();


    formularioValido = validarFormulario3($('#formularioALTA'))


    if (formularioValido) {

    if (ID_FORMULARIO_ALTA == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarALTA')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_ALTA: ID_FORMULARIO_ALTA }, 'AltaSave', 'formularioALTA', 'guardarALTA', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_FORMULARIO_ALTA = data.alta.ID_FORMULARIO_ALTA
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                    
                    setTimeout(() => {
                        window.scrollTo(0, 0); // Lleva al tope
                        location.reload();     // Luego recarga
                    }, 1600);
                    
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarALTA')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_ALTA: ID_FORMULARIO_ALTA }, 'AltaSave', 'formularioALTA', 'guardarALTA', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_FORMULARIO_ALTA = data.alta.ID_FORMULARIO_ALTA
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                    

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});











document.addEventListener("DOMContentLoaded", function () {
    const tipoPersona = document.getElementById("TIPO_PERSONA_ALTA");
    const domicilioNacional = document.getElementById("DOMICILIO_NACIONAL");
    const domicilioExtranjero = document.getElementById("DOMICILIO_ERXTRANJERO");
    const labelRFC = document.querySelector('label[for="RFC_LABEL"]'); // Selecciona el label específico


    tipoPersona.addEventListener("change", function () {
        if (this.value === "1") {
            domicilioNacional.style.display = "block";
            domicilioExtranjero.style.display = "none";
            labelRFC.textContent = "R.F.C *";

        } else if (this.value === "2") {
            domicilioNacional.style.display = "none";
            domicilioExtranjero.style.display = "block";
            labelRFC.textContent = "Tax ID *";

        }
    });
});



document.addEventListener("DOMContentLoaded", function() {
    fetch('/obtenerDatosProveedor')
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            console.error(data.error);
            return;
        }



                document.getElementById("ID_FORMULARIO_ALTA").value = data.ID_FORMULARIO_ALTA;
        document.getElementById("TIPO_PERSONA_ALTA").value = data.TIPO_PERSONA_ALTA;
        document.getElementById("TIPO_PERSONA_OPCION").value = data.TIPO_PERSONA_OPCION;
        document.getElementById("RAZON_SOCIAL_ALTA").value = data.RAZON_SOCIAL_ALTA;
        document.getElementById("RFC_ALTA").value = data.RFC_ALTA;

        if (data.TIPO_PERSONA_ALTA == "1") {
            document.querySelector('label[for="RFC_LABEL"]').textContent = "R.F.C";

            document.getElementById("DOMICILIO_NACIONAL").style.display = "block";
            document.getElementById("DOMICILIO_ERXTRANJERO").style.display = "none";



            document.getElementById("CODIGO_POSTAL").value = data.CODIGO_POSTAL;
            document.getElementById("TIPO_VIALIDAD_EMPRESA").value = data.TIPO_VIALIDAD_EMPRESA;
            document.getElementById("NOMBRE_VIALIDAD_EMPRESA").value = data.NOMBRE_VIALIDAD_EMPRESA;
            document.getElementById("NUMERO_EXTERIOR_EMPRESA").value = data.NUMERO_EXTERIOR_EMPRESA;
            document.getElementById("NUMERO_INTERIOR_EMPRESA").value = data.NUMERO_INTERIOR_EMPRESA;
            document.getElementById("NOMBRE_COLONIA_EMPRESA").value = data.NOMBRE_COLONIA_EMPRESA;
            document.getElementById("NOMBRE_LOCALIDAD_EMPRESA").value = data.NOMBRE_LOCALIDAD_EMPRESA;
            document.getElementById("NOMBRE_MUNICIPIO_EMPRESA").value = data.NOMBRE_MUNICIPIO_EMPRESA;
            document.getElementById("NOMBRE_ENTIDAD_EMPRESA").value = data.NOMBRE_ENTIDAD_EMPRESA;
            document.getElementById("PAIS_EMPRESA").value = data.PAIS_EMPRESA;
            document.getElementById("ENTRE_CALLE_EMPRESA").value = data.ENTRE_CALLE_EMPRESA;
            document.getElementById("ENTRE_CALLE2_EMPRESA").value = data.ENTRE_CALLE2_EMPRESA;

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

        } else if (data.TIPO_PERSONA_ALTA == "2") {
            document.querySelector('label[for="RFC_LABEL"]').textContent = "Tax ID";

            document.getElementById("DOMICILIO_NACIONAL").style.display = "none";
            document.getElementById("DOMICILIO_ERXTRANJERO").style.display = "block";

            document.getElementById("DOMICILIO_EXTRANJERO").value = data.DOMICILIO_EXTRANJERO;
            document.getElementById("CODIGO_EXTRANJERO").value = data.CODIGO_EXTRANJERO;
            document.getElementById("CIUDAD_EXTRANJERO").value = data.CIUDAD_EXTRANJERO;
            document.getElementById("ESTADO_EXTRANJERO").value = data.ESTADO_EXTRANJERO;
            document.getElementById("PAIS_EXTRANJERO").value = data.PAIS_EXTRANJERO;
            // document.getElementById("DEPARTAMENTO_EXTRANJERO").value = data.DEPARTAMENTO_EXTRANJERO;
        }

        document.getElementById("REPRESENTANTE_LEGAL_ALTA").value = data.REPRESENTANTE_LEGAL_ALTA || '';
        document.getElementById("REGIMEN_ALTA").value = data.REGIMEN_ALTA || '';
        document.getElementById("CORREO_DIRECTORIO").value = data.CORREO_DIRECTORIO || '';
        document.getElementById("TELEFONO_OFICINA_ALTA").value = data.TELEFONO_OFICINA_ALTA || '';
        document.getElementById("PAGINA_WEB_ALTA").value = data.PAGINA_WEB_ALTA || '';
        document.getElementById("CUAL_ACTVIDAD_ECONOMICA").value = data.CUAL_ACTVIDAD_ECONOMICA || '';
        document.getElementById("CUAL_DESCUENTOS_ECONOMICA").value = data.CUAL_DESCUENTOS_ECONOMICA || '';
        document.getElementById("DIAS_CREDITO_ALTA").value = data.DIAS_CREDITO_ALTA || '';
        document.getElementById("TERMINOS_IMPORTANCIAS_ALTA").value = data.TERMINOS_IMPORTANCIAS_ALTA || '';
        document.getElementById("DESCRIPCION_VINCULO").value = data.DESCRIPCION_VINCULO || '';
        document.getElementById("NUMERO_PROVEEDOR").value = data.NUMERO_PROVEEDOR || '';

                document.getElementById("ACTVIDAD_COMERCIAL").value = data.ACTVIDAD_COMERCIAL || '';

   


           if (data.ACTIVIDAD_ECONOMICA) {
            let actividad = document.querySelector(`input[name="ACTIVIDAD_ECONOMICA"][value="${data.ACTIVIDAD_ECONOMICA}"]`);
            if (actividad) actividad.checked = true;
        }

        
                    // DESCUENTOS_ACTIVIDAD_ECONOMICA
            if (data.DESCUENTOS_ACTIVIDAD_ECONOMICA) {
                let descuento = document.querySelector(`input[name="DESCUENTOS_ACTIVIDAD_ECONOMICA"][value="${data.DESCUENTOS_ACTIVIDAD_ECONOMICA}"]`);
                if (descuento) {
                    descuento.checked = true;

                    // Mostrar el campo adicional si es "4"
                    if (data.DESCUENTOS_ACTIVIDAD_ECONOMICA == "4") {
                        document.getElementById("CUAL_DESCUENTOS").style.display = "block";
                    }
                }
            }

            // VINCULO_FAMILIAR
            if (data.VINCULO_FAMILIAR) {
                let vinculo = document.querySelector(`input[name="VINCULO_FAMILIAR"][value="${data.VINCULO_FAMILIAR}"]`);
                if (vinculo) {
                    vinculo.checked = true;

                    // Mostrar el div si es "SI"
                    if (data.VINCULO_FAMILIAR.toUpperCase() === "SI") {
                        document.getElementById("DIV_VINCULOS").style.display = "block";
                    }
                }
            }

            // SERVICIOS_PEMEX
            if (data.SERVICIOS_PEMEX) {
                let servicios = document.querySelector(`input[name="SERVICIOS_PEMEX"][value="${data.SERVICIOS_PEMEX}"]`);
                if (servicios) {
                    servicios.checked = true;

                    // Mostrar el campo si es "SI"
                    if (data.SERVICIOS_PEMEX.toUpperCase() === "SI") {
                        document.getElementById("DIV_NUMEROPROVEEDOR").style.display = "block";
                    }
                }
        }
        


         // POLITICAMENTE EXPUESTO
            if (data.BENEFICIOS_PERSONA) {
                let beneficios = document.querySelector(`input[name="BENEFICIOS_PERSONA"][value="${data.BENEFICIOS_PERSONA}"]`);
                if (beneficios) {
                    beneficios.checked = true;

                    // Mostrar el div si es "SI"
                    if (data.BENEFICIOS_PERSONA.toUpperCase() === "SI") {
                        document.getElementById("PERSONA_EXPUESTA").style.display = "block";
                    }
                }
            }

        document.getElementById("NOMBRE_PERSONA").value = data.NOMBRE_PERSONA || '';
        
        




    })
    
    .catch(error => console.error('Error al obtener los datos:', error));
});
