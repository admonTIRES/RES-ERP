ID_BANCO_CV = 0





document.addEventListener('DOMContentLoaded', function() {
    var avisoModalElement = document.getElementById('avisoPrivacidadModal');
    if (avisoModalElement) {
        var avisoModal = new bootstrap.Modal(avisoModalElement, {
            backdrop: 'static',
            keyboard: false
        });
        avisoModal.show();

        document.getElementById('aceptoTerminos').addEventListener('click', function() {
            avisoModal.hide();
        });

        document.getElementById('noAceptoTerminos').addEventListener('click', function() {
            window.location.href = 'http://results-in-performance.com/';
        });
    }
});



$("#guardarFormBancoCV").click(async function (e) {
    e.preventDefault();


    formularioValido = validarFormulario3($('#formularioBANCO'))

    if (formularioValido) {
        if (ID_BANCO_CV == 0) {
            alertMensajeConfirm({
                title: "¿Desea guardar la información?",
                text: "Al guardarla, se podrá usar",
                icon: "question",
            }, async function () {
                await loaderbtn('guardarFormBancoCV');
                await ajaxAwaitFormData({ api: 1, ID_BANCO_CV: ID_BANCO_CV }, 'FormCVSave', 'formularioBANCO', 'guardarFormBancoCV', { callbackAfter: true, callbackBefore: true }, () => {

                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');

                }, function (data) {
                    ID_BANCO_CV = data.bancocv.ID_BANCO_CV;

                    Swal.fire({
                        icon: 'success',
                        title: 'Información guardada correctamente',
                        confirmButtonText: 'OK',
                    }).then(() => {
                        document.getElementById('formulario_cv').style.display = 'none';
                        document.getElementById('nav_var').style.display = 'block';

                        const sectionFinalizado = document.getElementById('sectionFinalizado');
                        sectionFinalizado.classList.remove('d-none');
                        sectionFinalizado.classList.add('d-flex');

                        document.getElementById('formularioBANCO').reset();
                        $('#INTERES_ADMINISTRATIVA')[0].selectize.clear();
                        $('#INTERES_OPERATIVAS')[0].selectize.clear();

                        ID_BANCO_CV = 0;

                        document.getElementById('guardarFormBancoCV').disabled = true;
                        document.getElementById('aceptaTerminos').checked = false;
                    });
                });
            }, 1);

        } else {
            alertMensajeConfirm({
                title: "¿Desea editar la información de este formulario?",
                text: "Al guardarla, se podrá usar",
                icon: "question",
            }, async function () {
                await loaderbtn('guardarFormBancoCV');
                await ajaxAwaitFormData({ api: 1, ID_BANCO_CV: ID_BANCO_CV }, 'FormCVSave', 'formularioBANCO', 'guardarFormBancoCV', { callbackAfter: true, callbackBefore: true }, () => {

                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');

                }, function (data) {
                    ID_BANCO_CV = data.bancocv.ID_BANCO_CV;

                    Swal.fire({
                        icon: 'success',
                        title: 'Información editada correctamente',
                        confirmButtonText: 'OK',
                    }).then(() => {
                        document.getElementById('formulario_cv').style.display = 'none';
                        document.getElementById('nav_var').style.display = 'none';

                        const sectionFinalizado = document.getElementById('sectionFinalizado');
                        sectionFinalizado.classList.remove('d-none');
                        sectionFinalizado.classList.add('d-flex');

                        document.getElementById('formularioBANCO').reset();
                        $('#INTERES_ADMINISTRATIVA')[0].selectize.clear();
                        $('#INTERES_OPERATIVAS')[0].selectize.clear();

                        ID_BANCO_CV = 0;

                        document.getElementById('guardarFormBancoCV').disabled = true;
                        document.getElementById('aceptaTerminos').checked = false;
                    });
                });
            }, 1);
        }
    } else {
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000);
    }
});






  document.addEventListener('DOMContentLoaded', function() {
        var selectNacionalidad = document.getElementById('NACIONALIDAD');

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
                    }
                    document.getElementById('CURP_CV').setAttribute('name', 'TEMP_CURP');
                }
            });
        }
    });









function validarCURP(curp) {
    const regex = /^[A-Z]{4}\d{6}[HM][A-Z]{5}[A-Z0-9]{2}$/;
    return regex.test(curp);
}

document.addEventListener('DOMContentLoaded', function() {
    var curpInput = document.getElementById('CURP_CV');

    // Solo añade el listener si el elemento existe
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
    $('#formularioBANCO').on('submit', function(event) {
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
    if (ultimoGradoCV) {
        ultimoGradoCV.addEventListener('change', function() {
            var selectedValue = this.value;
            var licenciaturaNombre = document.getElementById('licenciatura-nombre-container');
            var licenciaturaTitulo = document.getElementById('licenciatura-titulo-container');
            var licenciaturaCedula = document.getElementById('licenciatura-cedula-container');
            var posgradoContainer = document.getElementById('posgrado-container');

            if (licenciaturaNombre) licenciaturaNombre.style.display = selectedValue === '4' ? 'block' : 'none';
            if (licenciaturaTitulo) licenciaturaTitulo.style.display = selectedValue === '4' ? 'block' : 'none';
            if (licenciaturaCedula) licenciaturaCedula.style.display = selectedValue === '4' ? 'block' : 'none';
            if (posgradoContainer) posgradoContainer.style.display = selectedValue === '5' ? 'block' : 'none';
            var posgradoNombre = document.getElementById('posgrado-nombre-container');
            var posgradoTitulo = document.getElementById('posgrado-titulo-container');
            var posgradoCedula = document.getElementById('posgrado-cedula-container');

            if (posgradoNombre) posgradoNombre.style.display = 'none';
            if (posgradoTitulo) posgradoTitulo.style.display = 'none';
            if (posgradoCedula) posgradoCedula.style.display = 'none';
        });
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
    var aceptaTerminosCheckbox = document.getElementById('aceptaTerminos');
    var guardarBtn = document.getElementById('guardarFormBancoCV');

    if (aceptaTerminosCheckbox && guardarBtn) {
        aceptaTerminosCheckbox.addEventListener('change', function() {
            guardarBtn.disabled = !this.checked;
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    var botonGuardar = document.getElementById('guardarFormBancoCV');
    if (botonGuardar) {
        botonGuardar.addEventListener('click', function(event) {
            var aceptaTerminosCheckbox = document.getElementById('aceptaTerminos');
            if (aceptaTerminosCheckbox && !aceptaTerminosCheckbox.checked) {
                event.preventDefault(); 
                alert('Debe aceptar los términos y condiciones para continuar.');
            }
        });
    }
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











// document.querySelectorAll('#CURP_CV, #ID_PASAPORTE').forEach(element => {
//     element.addEventListener('blur', function () {
//         var curp = this.value;

//         if (curp) {
//             bloquearInputs(true);
//             Swal.fire({
//                 title: 'Consultando información',
//                 text: 'Por favor, espere...',
//                 allowOutsideClick: false,
//                 showConfirmButton: false,
//                 didOpen: () => {
//                     Swal.showLoading();
//                 }
//             });

//             fetch('/actualizarinfo', {
//                 method: 'POST',
//                 headers: {
//                     'Content-Type': 'application/json',
//                     'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
//                 },
//                 body: JSON.stringify({ curp: curp })
//             })
//             .then(response => {
//                 if (!response.ok) {
//                     throw new Error('HTTP error, status = ' + response.status);
//                 }
//                 return response.json();
//             })
//             .then(data => {
//                 Swal.close();
//                 bloquearInputs(false);

//                 if (data.message) {
//                     alertToast(data.message);
//                 } else {
//                     document.getElementById('NOMBRE_CV').value = data.NOMBRE_CV || '';
//                     document.getElementById('PRIMER_APELLIDO_CV').value = data.PRIMER_APELLIDO_CV || '';
//                     document.getElementById('SEGUNDO_APELLIDO_CV').value = data.SEGUNDO_APELLIDO_CV || '';
//                     document.getElementById('CORREO_CV').value = data.CORREO_CV || '';
//                     document.getElementById('TELEFONO1').value = data.TELEFONO1 || '';
//                     document.getElementById('TELEFONO2').value = data.TELEFONO2 || '';
//                     document.getElementById('CURP_CV').value = data.CURP_CV || '';
//                     document.getElementById('GENERO').value = data.GENERO || '';
//                     document.getElementById('ULTIMO_GRADO_CV').value = data.ULTIMO_GRADO_CV || '';
//                     document.getElementById('NOMBRE_LICENCIATURA_CV').value = data.NOMBRE_LICENCIATURA_CV || '';
//                     document.getElementById('TIPO_POSGRADO_CV').value = data.TIPO_POSGRADO_CV || '';
//                     document.getElementById('NOMBRE_POSGRADO_CV').value = data.NOMBRE_POSGRADO_CV || '';
//                     document.getElementById('NACIONALIDAD').value = data.NACIONALIDAD || '';

//                     if (data.NACIONALIDAD === '1') {
//                         $('#campo-curp').show();
//                         $('#campo-pasaporte').hide();

//                         document.getElementById('CURP_CV').setAttribute('name', 'CURP_CV');
//                         document.getElementById('ID_PASAPORTE').setAttribute('name', 'TEMP_PASAPORTE');
//                     } else if (data.NACIONALIDAD === '2') {
//                         $('#campo-pasaporte').show();
//                         $('#campo-curp').hide();

//                         document.getElementById('ID_PASAPORTE').setAttribute('name', 'CURP_CV');
//                         document.getElementById('CURP_CV').setAttribute('name', 'TEMP_CURP');
//                         document.getElementById('ID_PASAPORTE').value = data.CURP_CV || '';
//                         document.getElementById('label-archivo').innerText = 'Pasaporte';
//                     }

//                     if (data.CUENTA_TITULO_LICENCIATURA_CV) {
//                         document.querySelector(`input[name="CUENTA_TITULO_LICENCIATURA_CV"][value="${data.CUENTA_TITULO_LICENCIATURA_CV}"]`).checked = true;
//                     }
//                     if (data.CEDULA_TITULO_LICENCIATURA_CV) {
//                         document.querySelector(`input[name="CEDULA_TITULO_LICENCIATURA_CV"][value="${data.CEDULA_TITULO_LICENCIATURA_CV}"]`).checked = true;
//                     }
//                     if (data.CUENTA_TITULO_POSGRADO_CV) {
//                         document.querySelector(`input[name="CUENTA_TITULO_POSGRADO_CV"][value="${data.CUENTA_TITULO_POSGRADO_CV}"]`).checked = true;
//                     }
//                     if (data.CEDULA_TITULO_POSGRADO_CV) {
//                         document.querySelector(`input[name="CEDULA_TITULO_POSGRADO_CV"][value="${data.CEDULA_TITULO_POSGRADO_CV}"]`).checked = true;
//                     }

//                     document.getElementById('ETIQUETA_TELEFONO1').value = data.ETIQUETA_TELEFONO1 || '';
//                     document.getElementById('ETIQUETA_TELEFONO2').value = data.ETIQUETA_TELEFONO2 || '';

//                     document.getElementById('dia').value = data.DIA_FECHA_CV || '';
//                     document.getElementById('mes').value = data.MES_FECHA_CV || '';
//                     document.getElementById('ano').value = data.ANIO_FECHA_CV || '';

//                     if (data.INTERES_ADMINISTRATIVA) {
//                         selectizeInstance.setValue(data.INTERES_ADMINISTRATIVA);
//                     }

//                     if (data.INTERES_OPERATIVAS) {
//                         selectizeInstance1.setValue(data.INTERES_OPERATIVAS);
//                     }

//                     var ultimoGradoCV = document.getElementById('ULTIMO_GRADO_CV');
//                     if (ultimoGradoCV) {
//                         var event = new Event('change');
//                         ultimoGradoCV.dispatchEvent(event);
//                     }

//                     var tipoPosgradoCV = document.getElementById('TIPO_POSGRADO_CV');
//                     if (tipoPosgradoCV) {
//                         var event = new Event('change');
//                         tipoPosgradoCV.dispatchEvent(event);
//                     }
//                 }
//             })
//             .catch(error => {
//                 Swal.close();
//                 bloquearInputs(false);
//                 alertToast('No se encontró ningún registro con esa CURP.');
//             });
//         } else {
//             alertToast('Debe ingresar un valor para la CURP.');
//         }
//     });
// });



function bloquearInputs(bloquear) {
    const inputs = document.querySelectorAll('#formularioBANCO input, #formularioBANCO select, #formularioBANCO textarea, #formularioBANCO button');
    inputs.forEach(input => {
        input.disabled = bloquear;
    });
}








let consultaRealizada = false;

document.querySelectorAll('#CURP_CV, #ID_PASAPORTE').forEach(element => {
    element.addEventListener('change', function () {
        var curp = this.value.trim();

        if (curp && !consultaRealizada) {
            consultaRealizada = true; 

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
                if (data && !data.message) {
                    Swal.fire({
                        title: 'Usted ya está registrado',
                        text: '¿Desea actualizar su información?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, actualizar',
                        cancelButtonText: 'No'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            document.getElementById('ID_BANCO_CV').value = data.ID_BANCO_CV || '';

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
                                document.getElementById('campo-curp').style.display = 'block';
                                document.getElementById('campo-pasaporte').style.display = 'none';
                            } else if (data.NACIONALIDAD === '2') {
                                document.getElementById('campo-pasaporte').style.display = 'block';
                                document.getElementById('campo-curp').style.display = 'none';
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





                        } else {
                            document.getElementById('formularioBANCO').reset();
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




