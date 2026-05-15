
ID_LISTA_POSTULANTES = 0



const ModalArea = document.getElementById('miModal_VACANTESACT')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    
    ID_LISTA_POSTULANTES = 0
    document.getElementById('formularioVACANTESACT').reset();
   
})



$("#guardarFormVACANTESACT").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioVACANTESACT'))

    if (formularioValido) {

    if (ID_LISTA_POSTULANTES == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormVACANTESACT')
            await ajaxAwaitFormData({ api: 1, ID_LISTA_POSTULANTES: ID_LISTA_POSTULANTES }, 'VacantesactSave', 'formularioVACANTESACT', 'guardarFormVACANTESACT', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_LISTA_POSTULANTES = data.asesor.ID_LISTA_POSTULANTES
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_VACANTESACT').modal('hide')
                    document.getElementById('formularioVACANTESACT').reset();
                    Tablapostulacioneshistorial.ajax.reload()

           
                
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormVACANTESACT')
            await ajaxAwaitFormData({ api: 1, ID_LISTA_POSTULANTES: ID_LISTA_POSTULANTES }, 'VacantesactSave', 'formularioVACANTESACT', 'guardarFormVACANTESACT', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_LISTA_POSTULANTES = data.asesor.ID_LISTA_POSTULANTES
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_VACANTESACT').modal('hide')
                    document.getElementById('formularioVACANTESACT').reset();
                    Tablapostulacioneshistorial.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});


var Tablapostulacioneshistorial = $("#Tablapostulacioneshistorial").DataTable({
    language: { url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json" },
    lengthChange: true,
    lengthMenu: [
        [10, 25, 50, -1],
        [10, 25, 50, 'All']
    ],
    info: false,
    paging: true,
    searching: true,
    filtering: true,
    scrollY: '65vh',
    scrollCollapse: true,
    responsive: true,
    ajax: {
        dataType: 'json',
        data: {},
        method: 'GET',
        cache: false,
        url: '/Tablapostulacioneshistorial',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablapostulacioneshistorial.columns.adjust().draw();
            ocultarCarga();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
    order: [[0, 'asc']],
    columns: [
        { 
            data: null,
            render: function(data, type, row, meta) {
                return meta.row + 1; 
            }
        },
        { data: 'NOMBRE_CATEGORIA' },
        { data: 'LUGAR_VACANTE' },
        { data: 'LA_VACANTES_ES' },
        { data: 'DESCRIPCION_VACANTE' },
        { data: 'FECHA_EXPIRACION' },
        { data: 'TOTAL_POSTULANTES' }, 
        { data: null,
            render: function (data, type, row) {
                return row.BTN_VISUALIZAR;
            }
        }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all text-center' },
        { targets: 1, title: 'Nombre de la categoría', className: 'all text-center' },
        { targets: 2, title: 'Lugar de trabajo', className: 'all text-center' },
        { targets: 3, title: 'Tipo de vacante', className: 'all text-center' },
        {
            targets: 4,
            title: 'Descripción de la vacantes',
            className: 'all text-center descripcion-column',
            render: function(data, type, row, meta) {
                if (type === 'display' && data.length > 100) {
                    return data.substr(0, 201) + '...'; 
                }
                return data;
            }
        },
        { targets: 5, title: 'Fecha de expiración', className: 'all text-center' },
        { targets: 6, title: 'Total de postulaciones', className: 'all text-center' },
        { targets: 7, title: 'Visualizar', className: 'all text-center' }
    ]
});






$(document).ready(function() {
    $('#Tablapostulacioneshistorial tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablapostulacioneshistorial.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_vacantes');

        ID_CATALOGO_VACANTE = row.data().ID_CATALOGO_VACANTE;
        editarDatoTabla(row.data(), 'formularioVACANTES', 'miModal_vacantes',1);
        cargarRequerimientos(row.data().REQUERIMIENTO);

        $('#botonAgregar').prop('disabled', true);

    });

    $('#miModal_vacantes').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_vacantes');
    });
});




function cargarRequerimientos(requerimientos) {
    const contenedor = document.getElementById('inputs-container');
    contenedor.innerHTML = ''; 

    requerimientos.forEach(function(requerimiento) {
        const divInput = document.createElement('div');
        divInput.classList.add('form-group', 'row', 'input-container', 'mb-3');
        divInput.innerHTML = `
            <div class="col-9 text-center">
                <label></label>
                <input type="text" name="NOMBRE_REQUERIMINETO[]" class="form-control" value="${requerimiento.NOMBRE_REQUERIMINETO}" placeholder="Escribe los Requerimientos de la vacante aquí">
            </div>
            <div class="col-3 text-center">
                <label>%</label>
                <input type="number" name="PORCENTAJE[]" class="form-control" value="${requerimiento.PORCENTAJE}">
            </div>
        `;
        contenedor.appendChild(divInput);

    });
}




// Función para mostrar la información de los postulantes




let idVacanteGlobal;
let categoriaVacanteGlobal;


function TotalPostulantes(idVacante, categoriaVacante) {
    // Asignar valores a las variables globales
    idVacanteGlobal = idVacante;
    categoriaVacanteGlobal = categoriaVacante;

    Swal.fire({
        title: 'Consultando información',
        text: 'Por favor, espere...',
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    $.ajax({
        url: '/informacionpostulantes/' + idVacante,
        method: 'GET',
        success: function(response) {
            Swal.close();

            let postulanteContent = '';
            let totalPostulantes = response.postulantes.length;

            if (totalPostulantes > 0) {
                response.postulantes.forEach((personalInfo, index) => {
                    let archivoCVContent = personalInfo.ARCHIVO_CV ? `
                        <iframe src="/obtener-cv/${personalInfo.CURP_CV}" width="100%" height="100%" style="border: none;"></iframe>
                    ` : `
                        <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                            <h5 class="text-danger">Archivo CV no encontrado.</h5>
                        </div>
                    `;

                    let postulanteCard = `
                    <div class="row mb-3 mt-1" data-curp="postulante-${personalInfo.CURP_CV}">
                        <div class="col-md-4 d-flex flex-column justify-content-start">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Información Personal</h5>
                                    <p class="card-text"><strong>Nombre:</strong> ${personalInfo.NOMBRE_CV || ''} ${personalInfo.PRIMER_APELLIDO_CV || ''} ${personalInfo.SEGUNDO_APELLIDO_CV || ''}</p>
                                    <p class="card-text" style="display: none;" ><strong>DATOSCOMPLETOS:</strong> ${personalInfo.DIA_FECHA_CV || ''} ${personalInfo.MES_FECHA_CV || ''} ${personalInfo.ANIO_FECHA_CV || ''}</p>

                                    <p class="card-text"><strong>Correo:</strong> ${personalInfo.CORREO_CV || ''}</p>
                                    <p class="card-text"><strong>Teléfonos:</strong> ${(personalInfo.TELEFONO1 || '') + (personalInfo.TELEFONO2 ? ', ' + personalInfo.TELEFONO2 : '')}</p>
                                </div>
                            </div>
                            <div class="card flex-grow-1">
                                <div class="card-body">
                                    <h5 class="card-title">Requerimientos de la Vacante</h5>
                                    <table class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th style="width: 70%;"></th>
                                                <th style="width: 30%; text-align: right;">Cumple</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${response.requerimientos.map((req, i) => `
                                            <tr>
                                                <td><strong>${i + 1}. ${req.NOMBRE_REQUERIMINETO}</strong></td>
                                                <td class="text-right">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="req-${req.NOMBRE_REQUERIMINETO}-${personalInfo.CURP_CV}" id="req-${req.NOMBRE_REQUERIMINETO}-si-${personalInfo.CURP_CV}" value="${req.PORCENTAJE}" onchange="actualizarTotal('${personalInfo.CURP_CV}')">
                                                            <label class="form-check-label me-3" for="req-${req.NOMBRE_REQUERIMINETO}-si-${personalInfo.CURP_CV}">Sí</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="req-${req.NOMBRE_REQUERIMINETO}-${personalInfo.CURP_CV}" id="req-${req.NOMBRE_REQUERIMINETO}-no-${personalInfo.CURP_CV}" value="0" onchange="actualizarTotal('${personalInfo.CURP_CV}')">
                                                            <label class="form-check-label me-3" for="req-${req.NOMBRE_REQUERIMINETO}-no-${personalInfo.CURP_CV}">No</label>
                                                        </div>
                                                        <span class="ms-3"><strong>${req.PORCENTAJE}%</strong></span>
                                                    </div>
                                                </td>
                                            </tr>
                                            `).join('')}
                                        </tbody>
                                    </table>
                                    <hr>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span><strong>Total cumplimiento:</strong></span>
                                        <span id="total-cumplimiento-${personalInfo.CURP_CV}" class="total-porcentaje-circle">0%</span>
                                    </div>
                                    <div class="text-center mt-4">
                                        <button class="btn btn-success guardar-postulante" data-curp="${personalInfo.CURP_CV}" data-id="${idVacante}" data-categoria="${categoriaVacante}" disabled>Guardar Información</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card h-100">
                                <div class="card-body p-0">
                                    ${archivoCVContent}
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                    postulanteContent += postulanteCard;
                });
            } else {
                postulanteContent = '<p class="text-center mt-3">No se encontraron postulantes para esta vacante.</p>';
            }

            var myModal = new bootstrap.Modal(document.getElementById('modalFullScreen'), {
                keyboard: true
            });
            myModal.show();

            $('#postulante-count').text(totalPostulantes);

            $('#postulante').html(postulanteContent);

            $('.guardar-postulante').click(function() {
                let curp = $(this).data('curp');
                let idVacante = $(this).data('id');
                let categoriaVacante = $(this).data('categoria');
                let postulante = response.postulantes.find(p => p.CURP_CV === curp);
                guardarInformacionPostulante(idVacante, categoriaVacante, postulante);
            });

            $.ajax({
                url: '/informacionpreseleccion/' + idVacante,
                method: 'GET',
                success: function(preseleccionResponse) {
                    let totalPreseleccionados = preseleccionResponse.length;

                    $('#preseleccionar-count').text(totalPreseleccionados);

                    if (!myModal._isShown) {
                        myModal.show();
                    }

                },
                error: function(error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un problema al consultar la información de preselección. Por favor, inténtelo de nuevo.',
                        confirmButtonText: 'Aceptar'
                    });
                }
            });

        },
        error: function(error) {
            Swal.close();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un problema al consultar la información. Por favor, inténtelo de nuevo.',
                confirmButtonText: 'Aceptar'
            });
        }
    });
}



function guardarInformacionPostulante(idVacante, categoriaVacante, postulante) {
    let totalCumplimiento = $(`#total-cumplimiento-${postulante.CURP_CV}`).text().replace('%', '');
    let datos = {
        VACANTES_ID: idVacante,
        CATEGORIA_VACANTE: categoriaVacante,
        CURP: postulante.CURP_CV,
        NOMBRE_AC: postulante.NOMBRE_CV,
        PRIMER_APELLIDO_AC: postulante.PRIMER_APELLIDO_CV,
        SEGUNDO_APELLIDO_AC: postulante.SEGUNDO_APELLIDO_CV,
        CORREO_AC: postulante.CORREO_CV,
        TELEFONO1_AC: postulante.TELEFONO1,
        TELEFONO2_AC: postulante.TELEFONO2,
        DIA_FECHA_AC:postulante.DIA_FECHA_CV,
        MES_FECHA_AC:postulante.MES_FECHA_CV,
        ANIO_FECHA_AC:postulante.ANIO_FECHA_CV,
        PORCENTAJE: totalCumplimiento
    };


    Swal.fire({
        title: '¿Está seguro?',
        text: '¿Desea enviar la información de este postulante?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, enviar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            let token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '/guardarPostulantes',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token 
                },
                data: datos,
                success: function (response) {
                    

                    if (typeof Tablapostulacioneshistorial !== 'undefined') {
                        Tablapostulacioneshistorial.ajax.reload(null, false);
                    }
                    

                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: 'La información se guardó correctamente.',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        $(`div[data-curp="postulante-${postulante.CURP_CV}"]`).remove();

                        let remainingPostulantes = $('#postulante .row[data-curp]').length;
                        $('#postulante-count').text(remainingPostulantes);

                        if (remainingPostulantes === 0) {
                            $('#postulante').append('<p class="text-center mt-3">No se encontraron más postulantes para guardar.</p>');
                        }

                        $.ajax({
                            url: '/informacionpreseleccion/' + idVacante,
                            method: 'GET',
                            success: function(preseleccionResponse) {
                                let totalPreseleccionados = preseleccionResponse.length;
                                $('#preseleccionar-count').text(totalPreseleccionados);

                                if ($('#preseleccionar-tab').hasClass('active')) {
                                    let preseleccionContent = '';

                                    if (totalPreseleccionados > 0) {
                                        preseleccionResponse.forEach((preseleccionInfo, index) => {
                                            let preseleccionCard = `
                                                <div class="row mb-3 mt-5" data-curp="${preseleccionInfo.CURP}">
                                                    <div class="col-md-12">
                                                        <div class="card mb-3">
                                                            <div class="card-body">
                                                                <h5 class="card-title">Información del postulante</h5>
                                                                <p class="card-text"><strong>Nombre:</strong> ${preseleccionInfo.NOMBRE_AC} ${preseleccionInfo.PRIMER_APELLIDO_AC} ${preseleccionInfo.SEGUNDO_APELLIDO_AC}</p>
                                                                <p class="card-text"><strong>Correo:</strong> ${preseleccionInfo.CORREO_AC}</p>
                                                                <p class="card-text"><strong>Teléfonos:</strong> ${preseleccionInfo.TELEFONO1_AC}, ${preseleccionInfo.TELEFONO2_AC}</p>
                                                                <p class="card-text" style="display: none;" ><strong>DATOSCOMPLETOS:</strong> ${preseleccionInfo.DIA_FECHA_AC || ''} ${preseleccionInfo.MES_FECHA_AC || ''} ${preseleccionInfo.ANIO_FECHA_AC || ''}</p>

                                                                <p class="card-text"><strong>Porcentaje de Cumplimiento:</strong> ${preseleccionInfo.PORCENTAJE}%</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            `;
                                            preseleccionContent += preseleccionCard;
                                        });
                                    } else {
                                        preseleccionContent = '<p class="text-center mt-3">No se encontraron registros de preseleccionados para esta vacante.</p>';
                                    }

                                    $('#preseleccionar').html(preseleccionContent);
                                }
                            },
                            error: function(error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Hubo un problema al consultar la información de preselección. Por favor, inténtelo de nuevo.',
                                    confirmButtonText: 'Aceptar'
                                });
                            }
                        });
                    });
                },
                error: function(error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un problema al guardar la información. Por favor, inténtelo de nuevo.',
                        confirmButtonText: 'Aceptar'
                    });
                }
            });
        }
    });
}




$(document).ready(function () {
    $('#preseleccionar-tab').on('click', function () {
        let idVacante = idVacanteGlobal;
        let categoriaVacante = categoriaVacanteGlobal;

        if (idVacante && categoriaVacante) {
            $.ajax({
                url: '/informacionpreseleccion/' + idVacante,
                method: 'GET',
                beforeSend: function () {
                    $('#preseleccionar').html('<div class="text-center mt-3"><div class="spinner-border" role="status"><span class="visualmente-oculto"></span></div></div>');
                },
                success: function (preseleccionResponse) {
                    let preseleccionContent = '';
                    let totalPreseleccionados = preseleccionResponse.length;

                    if (totalPreseleccionados > 0) {
                        preseleccionContent += `
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Correo</th>
                                            <th>Teléfonos</th>
                                            <th>% de Cumplimiento</th>
                                            <th>Disponibilidad</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                        `;

                        preseleccionResponse.forEach((preseleccionInfo, index) => {
                            let checkedSi = preseleccionInfo.DISPONIBLE === 'si' ? 'checked' : '';
                            let checkedNo = preseleccionInfo.DISPONIBLE === 'no' ? 'checked' : '';
                            let buttonDisabled = preseleccionInfo.DISPONIBLE === 'si' ? '' : 'disabled';
                            let buttonClass = preseleccionInfo.DISPONIBLE === 'si' ? 'btn-primary' : 'btn-secondary';

                            preseleccionContent += `
                            <tr data-curp="${preseleccionInfo.CURP}">
                                <td>${preseleccionInfo.NOMBRE_AC || ''} ${preseleccionInfo.PRIMER_APELLIDO_AC || ''} ${preseleccionInfo.SEGUNDO_APELLIDO_AC || ''}</td>
                                <td>${preseleccionInfo.CORREO_AC || ''}</td>
                                <td>${(preseleccionInfo.TELEFONO1_AC || '') + (preseleccionInfo.TELEFONO2_AC ? ', ' + preseleccionInfo.TELEFONO2_AC : '')}</td>
                                <p class="card-text" style="display: none;" ><strong>DATOSCOMPLETOS:</strong> ${preseleccionInfo.DIA_FECHA_AC || ''} ${preseleccionInfo.MES_FECHA_AC || ''} ${preseleccionInfo.ANIO_FECHA_AC || ''}</p>
                                <td>${preseleccionInfo.PORCENTAJE != null ? preseleccionInfo.PORCENTAJE + '%' : ''}</td>

                                <td class="radio-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="disponible-${index}" id="disponible-si-${index}" value="si" ${checkedSi} onchange="actualizarDisponibilidad(${index}, '${preseleccionInfo.CURP}', true)">
                                        <label class="form-check-label" for="disponible-si-${index}">Sí</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="disponible-${index}" id="disponible-no-${index}" value="no" ${checkedNo} onchange="actualizarDisponibilidad(${index}, '${preseleccionInfo.CURP}', false)">
                                        <label class="form-check-label" for="disponible-no-${index}">No</label>
                                    </div>
                                </td>
                                <td>
                                    <button class="btn btn-success btn-action ${buttonClass}" id="action-button-${index}" ${buttonDisabled} onclick="guardarPreseleccion(${index}, '${preseleccionInfo.CURP}', '${preseleccionInfo.NOMBRE_AC || ''}', '${preseleccionInfo.PRIMER_APELLIDO_AC || ''}', '${preseleccionInfo.SEGUNDO_APELLIDO_AC || ''}', '${preseleccionInfo.CORREO_AC || ''}', '${preseleccionInfo.TELEFONO1_AC || ''}', '${preseleccionInfo.TELEFONO2_AC || ''}', '${preseleccionInfo.DIA_FECHA_AC || ''}', '${preseleccionInfo.MES_FECHA_AC || ''}', '${preseleccionInfo.ANIO_FECHA_AC || ''}', ${preseleccionInfo.PORCENTAJE != null ? preseleccionInfo.PORCENTAJE : ''})">Preseleccionar</button>
                                </td>
                            </tr>
                        `;
                        
                        });

                        preseleccionContent += `
                                    </tbody>
                                </table>
                            </div>
                        `;
                    } else {
                        preseleccionContent = '<p class="text-center mt-3">No se encontraron registros de preseleccionados para esta vacante.</p>';
                    }

                    $('#preseleccionar-count').text(totalPreseleccionados);

                    $('#preseleccionar').html(preseleccionContent);
                },
                error: function (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un problema al consultar la información de preselección. Por favor, inténtelo de nuevo.',
                        confirmButtonText: 'Aceptar'
                    });
                }
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo obtener la información de la vacante. Por favor, inténtelo de nuevo.',
                confirmButtonText: 'Aceptar'
            });
        }
    });

    window.actualizarDisponibilidad = function(index, curp, isAvailable) {
        const button = $(`#action-button-${index}`);
        const vacanteID = idVacanteGlobal;

        $.ajax({
            url: '/actualizarDisponibilidad', 
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                VACANTES_ID: vacanteID,
                CURP: curp,
                DISPONIBLE: isAvailable ? 'si' : 'no'
            },
            success: function(response) {
                if (isAvailable) {
                    button.removeClass('btn-secondary').addClass('btn-primary');
                } else {
                    button.attr('disabled', 'disabled');
                    button.removeClass('btn-primary').addClass('btn-secondary');
                }
            },
            error: function(error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al actualizar la disponibilidad. Por favor, inténtelo de nuevo.',
                    confirmButtonText: 'Aceptar'
                });
            }
        });
    };

    window.guardarPreseleccion = function(index, curp, nombre, primerApellido, segundoApellido, correo, telefono1, telefono2,dia,mes,anio, porcentaje) {
        const vacanteID = idVacanteGlobal;
        const categoriaVacante = categoriaVacanteGlobal;

        Swal.fire({
            title: '¿Estás seguro?',
            text: `Estás a punto de preseleccionar a ${nombre} ${primerApellido} ${segundoApellido}.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, seleccionar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    willOpen: () => {
                        $('.swal2-popup').addClass('ld ld-breath');
                    }
                });

                const data = {
                    VACANTES_ID: vacanteID,
                    CATEGORIA_VACANTE: categoriaVacante,
                    CURP: curp,
                    NOMBRE_SELC: nombre,
                    PRIMER_APELLIDO_SELEC: primerApellido,
                    SEGUNDO_APELLIDO_SELEC: segundoApellido,
                    CORREO_SELEC: correo,
                    TELEFONO1_SELECT: telefono1,
                    TELEFONO2_SELECT: telefono2,
                    DIA_FECHA_SELECT: dia,
                    MES_FECHA_SELECT: mes,
                    ANIO_FECHA_SELECT: anio,
                    PORCENTAJE: porcentaje,
                };

                $.ajax({
                    url: '/guardarPreseleccion',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: data,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Preseleccionado ',
                            text: 'El postulante ha sido preseleccionado y guardado exitosamente.',
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            $(`tr[data-curp="${curp}"]`).remove();

                            let remainingPreseleccionados = $('#preseleccionar tbody tr').length;
                            $('#preseleccionar-count').text(remainingPreseleccionados);

                            if (remainingPreseleccionados === 0) {
                                $('#preseleccionar').html('<p class="text-center mt-3">No se encontraron más preseleccionados para guardar.</p>');
                            }
                        });
                    },
                    error: function(error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un problema al guardar la información. Por favor, inténtelo de nuevo.',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                });
            }
        });
    };
});


 $('#modalFullScreen').on('hidden.bs.modal', function () {
    $('#modalContent').empty(); 
    $('#postulante-count').text('0'); 

    $('#preseleccionar').empty(); 
    $('#preseleccionar-count').text('0');
    $('#postulante-tab').addClass('active');
    $('#preseleccionar-tab').removeClass('active');
    $('#postulante').addClass('show active');
    $('#preseleccionar').removeClass('show active');
});







function actualizarTotal(curp) {
    const radios = document.querySelectorAll(`input[name^="req-"][name$="${curp}"]:checked`);
    let total = 0;

    radios.forEach(radio => {
        total += parseInt(radio.value) || 0;
    });

    const totalSpan = document.getElementById(`total-cumplimiento-${curp}`);
    totalSpan.textContent = `${total}%`;

    if (total >= 90) {
        totalSpan.style.backgroundColor = 'green';
    } else if (total >= 80 && total < 90) {
        totalSpan.style.backgroundColor = 'orange';
    } else {
        totalSpan.style.backgroundColor = 'red';
    }
}





