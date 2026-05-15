
ID_BANCO_CV = 0
ID_LISTA_POSTULANTES = 0

document.getElementById('notRegisteredBtn').addEventListener('click', function() {
    window.location.href = 'https://results-erp.results-in-performance.com/Formulario-vacantes';
});

document.getElementById('registeredBtn').addEventListener('click', function() {
    document.getElementById('curpInputContainer').style.display = 'block';
    document.querySelector('.modal-footer').style.display = 'none';
});

   








function showDetails(slug) {
    document.getElementById('panel-izquierdo').style.display = 'none';
    document.getElementById('vacantes-container').style.display = 'none';

    document.getElementById('details-container').style.display = 'block';

    var detailPanes = document.querySelectorAll('.details-pane');
    detailPanes.forEach(function(pane) {
        pane.style.display = 'none';
    });

    var detailsPane = document.getElementById('details-' + slug);
    if (detailsPane) {
        detailsPane.style.display = 'block';
    }
}

function volverATabla() {
    document.getElementById('panel-izquierdo').style.display = 'block';
    document.getElementById('vacantes-container').style.display = 'block';

    document.getElementById('details-container').style.display = 'none';

    var detailPanes = document.querySelectorAll('.details-pane');
    detailPanes.forEach(function(pane) {
        pane.style.display = 'none';
    });
}














document.getElementById('actualizarinfo').addEventListener('click', function() {
    var miModal = new bootstrap.Modal(document.getElementById('miModal_ACTUALIZARINFO'));
    miModal.show();
});


var $select = $('#INTERES_ADMINISTRATIVA').selectize({
    plugins: ['remove_button'],
    delimiter: ',',
    persist: false,
    placeholder: 'Seleccione una opción',
});
var selectizeInstance = $select[0].selectize;

var $select1 = $('#INTERES_OPERATIVAS').selectize({
    plugins: ['remove_button'],
    delimiter: ',',
    persist: false,
    placeholder: 'Seleccione una opción',
});


var selectizeInstance1 = $select1[0].selectize;




function validarCURP(curp) {
    const regex = /^[A-Z]{4}\d{6}[HM][A-Z]{5}[A-Z0-9]{2}$/;
    return regex.test(curp);
}

document.addEventListener('DOMContentLoaded', function() {
    var curpInput = document.getElementById('CURP_CV');

    if (curpInput) {
        curpInput.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
            var curp = this.value;
            var contador = document.getElementById('contador');
            if (contador) {
                contador.textContent = curp.length + '/18';
            }

            var mensaje = document.getElementById('mensaje');
            var error = document.getElementById('error');
            if (curp.length === 18) {
                if (validarCURP(curp)) {
                    if (mensaje) mensaje.textContent = 'CURP válida. Confirma tu CURP antes de continuar.';
                    if (error) error.textContent = '';
                } else {
                    if (mensaje) mensaje.textContent = '';
                    if (error) error.textContent = 'CURP inválida. Por favor, verifica el formato.';
                }
            } else {
                if (mensaje) mensaje.textContent = '';
                if (error) error.textContent = '';
            }
        });
    }
});


$(document).ready(function() {
    $('#formularioACTUALIZARINFO').on('submit', function(event) {
        const curp = $('#CURP_CV').val();
        if (!validarCURP(curp)) {
            $('#error').text('CURP inválida. Por favor, verifica el formato.');
            event.preventDefault();
        } else {
            $('#error').text('');
        }
    });
});




document.addEventListener('DOMContentLoaded', function() {
    var ultimoGradoCV = document.getElementById('ULTIMO_GRADO_CV');
    var licenciaturaNombre = document.getElementById('licenciatura-nombre-container');
    var licenciaturaTitulo = document.getElementById('licenciatura-titulo-container');
    var licenciaturaCedula = document.getElementById('licenciatura-cedula-container');
    var posgradoContainer = document.getElementById('posgrado-container');
    var posgradoNombre = document.getElementById('posgrado-nombre-container');
    var posgradoTitulo = document.getElementById('posgrado-titulo-container');
    var posgradoCedula = document.getElementById('posgrado-cedula-container');

    function toggleFields() {
        var selectedValue = ultimoGradoCV.value;
        
        if (licenciaturaNombre) licenciaturaNombre.style.display = selectedValue === '4' ? 'block' : 'none';
        if (licenciaturaTitulo) licenciaturaTitulo.style.display = selectedValue === '4' ? 'block' : 'none';
        if (licenciaturaCedula) licenciaturaCedula.style.display = selectedValue === '4' ? 'block' : 'none';
        if (posgradoContainer) posgradoContainer.style.display = selectedValue === '5' ? 'block' : 'none';

        if (selectedValue !== '5') {
            if (posgradoNombre) posgradoNombre.style.display = 'none';
            if (posgradoTitulo) posgradoTitulo.style.display = 'none';
            if (posgradoCedula) posgradoCedula.style.display = 'none';
        }
    }

    if (ultimoGradoCV) {
        toggleFields();
        

        ultimoGradoCV.addEventListener('change', toggleFields);
    }
});


document.addEventListener('DOMContentLoaded', function() {
    var tipoPosgradoCV = document.getElementById('TIPO_POSGRADO_CV');
    if (tipoPosgradoCV) {
        tipoPosgradoCV.addEventListener('change', function() {
            var display = this.value !== '0' ? 'block' : 'none';
            var posgradoNombre = document.getElementById('posgrado-nombre-container');
            var posgradoTitulo = document.getElementById('posgrado-titulo-container');
            var posgradoCedula = document.getElementById('posgrado-cedula-container');

            if (posgradoNombre) posgradoNombre.style.display = display;
            if (posgradoTitulo) posgradoTitulo.style.display = display;
            if (posgradoCedula) posgradoCedula.style.display = display;
        });
    }
});







document.addEventListener('DOMContentLoaded', function() {
    var archivoCurpCV = document.getElementById('ARCHIVO_CURP_CV');
    if (archivoCurpCV) {
        archivoCurpCV.addEventListener('change', function() {
            var archivo = this.files[0];
            var errorElement = document.getElementById('CURP_ERROR');
            var quitarCurp = document.getElementById('quitarCURP');
            if (archivo && archivo.type === 'application/pdf') {
                if (errorElement) errorElement.style.display = 'none';
                if (quitarCurp) quitarCurp.style.display = 'block';
            } else {
                if (errorElement) errorElement.style.display = 'block';
                this.value = '';
                if (quitarCurp) quitarCurp.style.display = 'none';
            }
        });
    }
});


document.addEventListener('DOMContentLoaded', function() {
    var quitarCurp = document.getElementById('quitarCURP');
    if (quitarCurp) {
        quitarCurp.addEventListener('click', function() {
            var archivoCurpCV = document.getElementById('ARCHIVO_CURP_CV');
            var errorElement = document.getElementById('CURP_ERROR');
            if (archivoCurpCV) archivoCurpCV.value = '';
            if (errorElement) errorElement.style.display = 'none';
            this.style.display = 'none';
        });
    }
});


document.addEventListener('DOMContentLoaded', function() {
    var archivoCV = document.getElementById('ARCHIVO_CV');
    if (archivoCV) {
        archivoCV.addEventListener('change', function() {
            var archivo = this.files[0];
            var errorElement = document.getElementById('CV_ERROR');
            var quitarCV = document.getElementById('quitarCV');
            if (archivo && archivo.type === 'application/pdf') {
                if (errorElement) errorElement.style.display = 'none';
                if (quitarCV) quitarCV.style.display = 'block';
            } else {
                if (errorElement) errorElement.style.display = 'block';
                this.value = '';
                if (quitarCV) quitarCV.style.display = 'none';
            }
        });
    }
});


document.addEventListener('DOMContentLoaded', function() {
    var quitarCV = document.getElementById('quitarCV');
    if (quitarCV) {
        quitarCV.addEventListener('click', function() {
            var archivoCV = document.getElementById('ARCHIVO_CV');
            var errorElement = document.getElementById('CV_ERROR');
            if (archivoCV) archivoCV.value = '';
            if (errorElement) errorElement.style.display = 'none';
            this.style.display = 'none';
        });
    }
});





document.addEventListener('DOMContentLoaded', function() {
    var selectNacionalidad = document.getElementById('NACIONALIDAD');
    var form = document.querySelector('form'); 

    if (selectNacionalidad) {
        selectNacionalidad.addEventListener('change', function() {
            var nacionalidad = this.value;

            var campoCurp = document.getElementById('campo-curp');
            var campoPasaporte = document.getElementById('campo-pasaporte');
            var labelArchivo = document.getElementById('label-archivo');
            var archivoCurpCv = document.getElementById('ARCHIVO_CURP_CV');

            if (campoCurp) campoCurp.style.display = 'none';
            if (campoPasaporte) campoPasaporte.style.display = 'none';

            if (nacionalidad == '1') {
                if (campoCurp) {
                    campoCurp.style.display = 'block';
                    document.getElementById('CURP_CV').setAttribute('name', 'CURP_CV');  
                }
                if (labelArchivo) labelArchivo.innerText = 'CURP. ';
                if (archivoCurpCv) {
                    archivoCurpCv.setAttribute('name', 'ARCHIVO_CURP_CV');
                    archivoCurpCv.setAttribute('required', true);
                }
                document.getElementById('ID_PASAPORTE').setAttribute('name', 'TEMP_PASAPORTE');
            } else if (nacionalidad == '2') {
                if (campoPasaporte) {
                    campoPasaporte.style.display = 'block';
                    document.getElementById('ID_PASAPORTE').setAttribute('name', 'CURP_CV');  
                }
                if (labelArchivo) labelArchivo.innerText = 'Pasaporte.  ';
                if (archivoCurpCv) {
                    archivoCurpCv.setAttribute('name', 'ARCHIVO_PASAPORTE_CV');
                    archivoCurpCv.removeAttribute('required');
                }
                document.getElementById('CURP_CV').setAttribute('name', 'TEMP_CURP');
            }
        });
    }

    form.addEventListener('submit', function(event) {
        var nacionalidad = selectNacionalidad.value;

        if (nacionalidad == '1') {
            document.getElementById('CURP_CV').setAttribute('name', 'CURP_CV');
            document.getElementById('ID_PASAPORTE').setAttribute('name', 'TEMP_PASAPORTE');
        } else if (nacionalidad == '2') {
            document.getElementById('ID_PASAPORTE').setAttribute('name', 'CURP_CV');
            document.getElementById('CURP_CV').setAttribute('name', 'TEMP_CURP');
        }
    });
});





document.getElementById('CURPS_INFO').addEventListener('blur', function() {
    var curp = this.value;

    if (curp) { 
        bloquearInputs(true);
        Swal.fire({
            title: 'Consultando información',
            text: 'Por favor, espere...',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        fetch('/actualizarinfo', { 
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: JSON.stringify({ curp: curp })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('HTTP error, status = ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            Swal.close();  
            bloquearInputs(false);  

            if (data.message) {
                alertToast(data.message);
            } else {
                document.getElementById('NOMBRE_CV').value = data.NOMBRE_CV || '';
                document.getElementById('PRIMER_APELLIDO_CV').value = data.PRIMER_APELLIDO_CV || '';
                document.getElementById('SEGUNDO_APELLIDO_CV').value = data.SEGUNDO_APELLIDO_CV || '';
                document.getElementById('CORREO_CV').value = data.CORREO_CV || '';
                document.getElementById('TELEFONO1').value = data.TELEFONO1 || '';
                document.getElementById('TELEFONO2').value = data.TELEFONO2 || '';
                document.getElementById('CURP_CV').value = data.CURP_CV || '';
                document.getElementById('GENERO').value = data.GENERO || '';
                document.getElementById('ULTIMO_GRADO_CV').value = data.ULTIMO_GRADO_CV || '';
                document.getElementById('NOMBRE_LICENCIATURA_CV').value = data.NOMBRE_LICENCIATURA_CV || '';
                document.getElementById('TIPO_POSGRADO_CV').value = data.TIPO_POSGRADO_CV || '';
                document.getElementById('NOMBRE_POSGRADO_CV').value = data.NOMBRE_POSGRADO_CV || '';
                document.getElementById('NACIONALIDAD').value = data.NACIONALIDAD || '';
                

                if (data.NACIONALIDAD === '1') {
                    $('#campo-curp').show();       
                    $('#campo-pasaporte').hide();  
                
                    document.getElementById('CURP_CV').setAttribute('name', 'CURP_CV');
                    document.getElementById('ID_PASAPORTE').setAttribute('name', 'TEMP_PASAPORTE');
                }
                
                
                else if (data.NACIONALIDAD === '2') {
                    $('#campo-pasaporte').show();  
                    $('#campo-curp').hide();      
                
                    document.getElementById('ID_PASAPORTE').setAttribute('name', 'CURP_CV');
                    document.getElementById('CURP_CV').setAttribute('name', 'TEMP_CURP');
                    document.getElementById('ID_PASAPORTE').value = data.CURP_CV || '';
                    document.getElementById('label-archivo').innerText = 'Pasaporte';



                }

                
                if (data.CUENTA_TITULO_LICENCIATURA_CV) {
                    document.querySelector(`input[name="CUENTA_TITULO_LICENCIATURA_CV"][value="${data.CUENTA_TITULO_LICENCIATURA_CV}"]`).checked = true;
                }
                if (data.CEDULA_TITULO_LICENCIATURA_CV) {
                    document.querySelector(`input[name="CEDULA_TITULO_LICENCIATURA_CV"][value="${data.CEDULA_TITULO_LICENCIATURA_CV}"]`).checked = true;
                }
                if (data.CUENTA_TITULO_POSGRADO_CV) {
                    document.querySelector(`input[name="CUENTA_TITULO_POSGRADO_CV"][value="${data.CUENTA_TITULO_POSGRADO_CV}"]`).checked = true;
                }
                if (data.CEDULA_TITULO_POSGRADO_CV) {
                    document.querySelector(`input[name="CEDULA_TITULO_POSGRADO_CV"][value="${data.CEDULA_TITULO_POSGRADO_CV}"]`).checked = true;
                }

                document.getElementById('ETIQUETA_TELEFONO1').value = data.ETIQUETA_TELEFONO1 || '';
                document.getElementById('ETIQUETA_TELEFONO2').value = data.ETIQUETA_TELEFONO2 || '';

                document.getElementById('dia').value = data.DIA_FECHA_CV || '';
                document.getElementById('mes').value = data.MES_FECHA_CV || '';
                document.getElementById('ano').value = data.ANIO_FECHA_CV || '';

                if (data.INTERES_ADMINISTRATIVA) {
                    selectizeInstance.setValue(data.INTERES_ADMINISTRATIVA);
                }

                if (data.INTERES_OPERATIVAS) {
                    selectizeInstance1.setValue(data.INTERES_OPERATIVAS);
                }
                var ultimoGradoCV = document.getElementById('ULTIMO_GRADO_CV');
                if (ultimoGradoCV) {
                    var event = new Event('change');
                    ultimoGradoCV.dispatchEvent(event); 
                }

                var tipoPosgradoCV = document.getElementById('TIPO_POSGRADO_CV');
                if (tipoPosgradoCV) {
                    var event = new Event('change');
                    tipoPosgradoCV.dispatchEvent(event); 
                }

                
            }
        })
        .catch(error => {
            Swal.close();  
            bloquearInputs(false);  
            alertToast('No se encontró ningún registro con esa CURP.');
        });
    } else {
        alertToast('Debe ingresar un valor para la CURP.');
    }
});



function bloquearInputs(bloquear) {
    const inputs = document.querySelectorAll('#miModal_ACTUALIZARINFO input, #miModal_ACTUALIZARINFO select, #miModal_ACTUALIZARINFO textarea, #miModal_ACTUALIZARINFO button');
    inputs.forEach(input => {
        input.disabled = bloquear;
    });
}






let vacanteId = null;

$(".postularse-btn").click(function (e) {
    vacanteId = $(this).data('vacante'); 
    // console.log("ID de la vacante seleccionada:", vacanteId);
});








document.getElementById('registeredBtn').addEventListener('click', function() {
    document.getElementById('postularseModalLabel').style.display = 'none';
    document.querySelector('#postularseModal .modal-body p').style.display = 'none';
    document.querySelector('.modal-footer.modal-footer-center').style.display = 'none';
    
    document.getElementById('curpInputContainer').style.display = 'block';
});

document.getElementById('curpInput').addEventListener('input', function() {
    let curp = this.value;
    
    if (curp.length === 18) {  
        fetch('/actualizarinfo', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ curp: curp })
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                alertToast(data.message, 'error', 2000);
            } else {
                alertToast(`CURP encontrada: ${data.NOMBRE_CV} ${data.PRIMER_APELLIDO_CV} ${data.SEGUNDO_APELLIDO_CV}`, 'success', 2000);
                
                document.getElementById('guardarFormpostularse').style.display = 'inline-block';
            }
        })
        .catch(error => console.error('Error:', error));
    }
});



























function resetValidation(form) {
    form.find('.is-invalid').removeClass('is-invalid');
    form.find('.error').removeClass('error');
    form.find('.invalid-feedback').hide();
    form.off('submit');
}

$('#actualizarinfo').click(function () {
    $('#postularseModal').modal('hide');
    $('#miModal_ACTUALIZARINFO').modal('show');
});

$('#postularseModal').on('hidden.bs.modal', function () {
    $('#formularioPostularse')[0].reset();
    resetValidation($('#formularioPostularse'));

    $('#postularseModalLabel').show();
    $('#postularseModal .modal-body p').show();
    $('.modal-footer.modal-footer-center').show();

    $('#curpInputContainer').hide();
    $('#guardarFormpostularse').hide();
});

$('#miModal_ACTUALIZARINFO').on('hidden.bs.modal', function () {
    $('#formularioACTUALIZARINFO').trigger('reset');
    resetValidation($('#formularioACTUALIZARINFO'));

    $('#INTERES_ADMINISTRATIVA')[0].selectize.clear();
    $('#INTERES_OPERATIVAS')[0].selectize.clear();
});

function validarCamposRequeridos(form) {
    let camposRequeridos = form.find('[required]');
    let valido = true;

    camposRequeridos.each(function() {
        if ($(this).val().trim() === '') {
            valido = false;
            $(this).addClass('is-invalid');
            $(this).next('.invalid-feedback').show();
        }
    });

    return valido;
}

$("#guardarFormpostularse").click(function (e) {
    e.preventDefault();
    resetValidation($('#formularioPostularse'));

    let camposValidos = validarCamposRequeridos($('#formularioPostularse'));

    if (camposValidos) {
        let formularioValido = validarFormulario($('#formularioPostularse'));

        if (formularioValido) {
            alertMensajeConfirm({
                title: "¿Desea postularte a esta vacante?",
                icon: "question",
            }, async function () {
                await loaderbtn('guardarFormpostularse');
                await ajaxAwaitFormData({ 
                    api: 1,  
                    ID_LISTA_POSTULANTES: ID_LISTA_POSTULANTES, 
                    VACANTES_ID: vacanteId  
                }, 'PostularseSave', 'formularioPostularse', 'guardarFormpostularse', { callbackAfter: true, callbackBefore: true }, () => {
                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');
                    
                }, function (data) {
                    if (mensajeAjax(data) === 1) {
                        ID_LISTA_POSTULANTES = data.lista.ID_LISTA_POSTULANTES; 
                        alertMensaje1('success', 'Te has postulado exitosamente', null, null, null, 2500);
                        $('#postularseModal').modal('hide');
                        document.getElementById('formularioPostularse').reset();
                        ID_LISTA_POSTULANTES = 0; 
                    }
                })
            }, 1);
        } else {
            alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000);
        }
    }
});





$("#guardarFormActualizar").click(function (e) {
    e.preventDefault();
    resetValidation($('#formularioACTUALIZARINFO'));

    let camposValidos = validarCamposRequeridos($('#formularioACTUALIZARINFO'));

    if (camposValidos) {
        let formularioValido = validarFormulario($('#formularioACTUALIZARINFO'));

        if (formularioValido) {
            alertMensajeConfirm({
                title: "¿Desea guardar la información?",
                icon: "question",
            }, async function () {
                await loaderbtn('guardarFormActualizar');
                await ajaxAwaitFormData({ 
                    api: 1, 
                    ID_BANCO_CV: ID_BANCO_CV, 
                    VACANTES_ID: vacanteId 
                }, 'ActualizarSave', 'formularioACTUALIZARINFO', 'guardarFormActualizar', { callbackAfter: true, callbackBefore: true }, () => {
                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');
                    
                }, function (data) {
                    ID_BANCO_CV = data.bancocv.ID_BANCO_CV;
                    alertMensaje1('success', 'Información Actualizada y Postulación Correcta', null, null, null, 2500);
                    $('#miModal_ACTUALIZARINFO').modal('hide');
                    $('#postularseModal').modal('hide');
                    document.getElementById('formularioACTUALIZARINFO').reset();
                    $('#INTERES_ADMINISTRATIVA')[0].selectize.clear();
                    $('#INTERES_OPERATIVAS')[0].selectize.clear();

                    ID_BANCO_CV = 0;
                });
            }, 1);
        } else {
            alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000);
        }
    } else {
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000);
    }
});



