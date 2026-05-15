


//VARIABLES
ID_FORMULARIO_CONFRIMACION = 0



const Modalconfirmacion = document.getElementById('miModal_CONFIRMACION');
Modalconfirmacion.addEventListener('hidden.bs.modal', event => {
    ID_FORMULARIO_CONFRIMACION = 0;

    document.getElementById('formularioCONFIRMACION').reset();

    document.getElementById('VERIFICACION_CLIENTE').style.display = 'none';

    document.getElementById('btnVerificacion').disabled = true; 


    document.querySelectorAll('input[type=radio]').forEach(radio => {
        radio.checked = false; 
    });

 
    
    var selectize = $('#OFERTA_ID')[0].selectize;
    selectize.clear(); 
    selectize.setValue("");
});





$("#guardarCONFIRMACION").click(function (e) {
    e.preventDefault();


            formularioValido = validarFormulario3($('#formularioCONFIRMACION'))

    if (formularioValido) {
        let verificacionInfo = {};

        $("input[type=radio]:checked").each(function () {
            let nombre = $(this).attr("name"); 
            let valor = $(this).val(); 

            let motivo = "";
            let inputId = "motivo_" + nombre.split("_")[1]; 
            let inputElement = document.getElementById(inputId);

            if (valor === "No" && inputElement) { 
                motivo = inputElement.value.trim(); 
            }

            verificacionInfo[nombre] = {
                valor: valor,
                motivo: motivo
            };
        });

        let jsonVerificacion = JSON.stringify(verificacionInfo);

        if (ID_FORMULARIO_CONFRIMACION == 0) {
            alertMensajeConfirm({
                title: "¿Desea guardar la información?",
                text: "Al guardarla, se podrá usar",
                icon: "question",
            }, async function () { 

                await loaderbtn('guardarCONFIRMACION');

                await ajaxAwaitFormData(
                    { 
                        api: 1, 
                        ID_FORMULARIO_CONFRIMACION: ID_FORMULARIO_CONFRIMACION,
                        VERIFICACION_INFORMACION: jsonVerificacion
                    }, 
                    'ContratacionSave', 
                    'formularioCONFIRMACION', 
                    'guardarCONFIRMACION', 
                    { callbackAfter: true, callbackBefore: true }, 
                    () => {
                        Swal.fire({
                            icon: 'info',
                            title: 'Espere un momento',
                            text: 'Estamos guardando la información',
                            showConfirmButton: false
                        });
                        $('.swal2-popup').addClass('ld ld-breath');
                    }, 
                    function (data) {
                        ID_FORMULARIO_CONFRIMACION = data.confirmacion.ID_FORMULARIO_CONFRIMACION;

                        var ofertaUsada = $("#OFERTA_ID").val();
                        if (ofertaUsada) {
                            var selectize = $('#OFERTA_ID')[0].selectize;
                            selectize.removeOption(ofertaUsada);
                        }
                        
                        alertMensaje('success', 'Información guardada correctamente', 'Esta información está lista para usarse', null, null, 1500);
                        $('#miModal_CONFIRMACION').modal('hide');
                        document.getElementById('formularioCONFIRMACION').reset();
                        Tablaconfirmacion.ajax.reload();
                    }
                );
            }, 1);
        } else {
            alertMensajeConfirm({
                title: "¿Desea editar la información de este formulario?",
                text: "Al guardarla, se podrá usar",
                icon: "question",
            }, async function () { 
                await loaderbtn('guardarCONFIRMACION');

                await ajaxAwaitFormData(
                    { 
                        api: 1, 
                        ID_FORMULARIO_CONFRIMACION: ID_FORMULARIO_CONFRIMACION,
                        VERIFICACION_INFORMACION: jsonVerificacion
                    }, 
                    'ContratacionSave', 
                    'formularioCONFIRMACION', 
                    'guardarCONFIRMACION', 
                    { callbackAfter: true, callbackBefore: true }, 
                    () => {
                        Swal.fire({
                            icon: 'info',
                            title: 'Espere un momento',
                            text: 'Estamos guardando la información',
                            showConfirmButton: false
                        });
                        $('.swal2-popup').addClass('ld ld-breath');
                    }, 
                    function (data) {
                        setTimeout(() => {
                            ID_FORMULARIO_CONFRIMACION = data.confirmacion.ID_FORMULARIO_CONFRIMACION;
                            alertMensaje('success', 'Información editada correctamente', 'Información guardada');
                            $('#miModal_CONFIRMACION').modal('hide');
                            document.getElementById('formularioCONFIRMACION').reset();
                            Tablaconfirmacion.ajax.reload();
                        }, 300);  
                    }
                );
            }, 1);
        }
    } else {
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000);
    }
});




$(document).ready(function () {
    var selectizeInstance = $('#OFERTA_ID').selectize({
        placeholder: 'Seleccione una oferta',
        allowEmptyOption: true,
        closeAfterSelect: true,
    });

    var selectize = selectizeInstance[0].selectize;

    var idsOriginales = Object.keys(selectize.options);

    $("#NUEVA_CONFIRMACION").click(function (e) {
        e.preventDefault();

        $("#miModal_CONFIRMACION").modal("show");
        document.getElementById('formularioCONFIRMACION').reset();
        $(".verifiacionesdiv").empty();


        Object.keys(selectize.options).forEach(function (id) {
            if (!idsOriginales.includes(id)) {
                selectize.removeOption(id);
            }
        });

        selectize.clear();
        selectize.setValue(""); 


    });
});





var Tablaconfirmacion = $("#Tablaconfirmacion").DataTable({
        language: {
        url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
    },
    scrollX: true,
    autoWidth: false,
    responsive: false,
    paging: true,
    searching: true,
    filtering: true,
    lengthChange: true,
    info: true,   
    scrollY: false,
    scrollCollapse: false,
    fixedHeader: false,    
    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'Todos']],
    ajax: {
        dataType: 'json',
        data: {},
        method: 'GET',
        cache: false,
        url: '/Tablaconfirmacion',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablaconfirmacion.columns.adjust().draw();
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
        { data: 'NO_OFERTA' },
        { data: 'FECHA_CONFIRMACION' },
        { 
            data: 'EVIDENCIAS',
            render: function (data) {
                if (!data || data.length === 0) return 'NA';
                let referenciasHTML = '';
                data.forEach(function (evidencias) {
                    referenciasHTML += `<strong>${evidencias.NOMBRE_EVIDENCIA || 'NA'}</strong><br>
                                        ${evidencias.BTN_DOCUMENTO || 'NA'}<br>`;
                });
                return referenciasHTML;
            }
        },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all text-center' },
        { targets: 1, title: 'N° de cotización', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Fecha de aceptación', className: 'all text-center' },
        { targets: 3, title: 'Evidencias ', className: 'all text-center' },
        { targets: 4, title: 'Editar', className: 'all text-center' },
        { targets: 5, title: 'Visualizar', className: 'all text-center' },
    ],
      infoCallback: function (settings, start, end, max, total, pre) {
        return `Total de ${total} registros`;
    },
});

$('#Tablaconfirmacion').on('click', '.ver-archivo-aceptacion', function () {
    var tr = $(this).closest('tr');
    var row = Tablaconfirmacion.row(tr);
    var id = $(this).data('id');

    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }

    var nombreDocumento = 'Documento de aceptación';
    var url = '/mostraraceptacion/' + id;
    
    abrirModal(url, nombreDocumento);
});



$('#Tablaconfirmacion').on('click', '.ver-archivo-evidencia', function () {
    var tr = $(this).closest('tr');
    var row = Tablaconfirmacion.row(tr);
    var id = $(this).data('id');

    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }


    var url = '/mostrarevidencias/' + id;
    abrirModal(url, 'Evidencia');
});

document.addEventListener("DOMContentLoaded", function () {
    const botonagregarevidencia = document.getElementById('botonagregarevidencia');
    const btnVerificacion = document.getElementById('btnVerificacion');

    btnVerificacion.disabled = true; 

    botonagregarevidencia.addEventListener('click', function () {
        agregarevidencia();
    });

    function actualizarEstadoBotonVerificacion() {
        const evidencias = document.querySelectorAll('.generarverificacion');
        btnVerificacion.disabled = evidencias.length === 0;
    }

    function agregarevidencia() {
        const divVerificacion = document.createElement('div');
        divVerificacion.classList.add('row', 'generarverificacion', 'mb-3');
        divVerificacion.innerHTML = `
            <div class="col-12">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombre de la evidencia *</label>
                        <input type="text" class="form-control" name="NOMBRE_EVIDENCIA[]" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Subir Evidencia (PDF) *</label>
                        <div class="d-flex align-items-center">
                            <input type="file" class="form-control me-2" name="DOCUMENTO_EVIDENCIA[]" accept=".pdf">
                            <button type="button" class="btn btn-warning botonEliminarArchivo" title="Eliminar archivo">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-4">
                <div class="form-group text-center">
                    <button type="button" class="btn btn-danger botonEliminarVerificacion">Eliminar verificación <i class="bi bi-trash-fill"></i></button>
                </div>
            </div>
        `;

        const contenedor = document.querySelector('.verifiacionesdiv');
        contenedor.appendChild(divVerificacion);

        const botonEliminar = divVerificacion.querySelector('.botonEliminarVerificacion');
        botonEliminar.addEventListener('click', function () {
            contenedor.removeChild(divVerificacion);
            actualizarEstadoBotonVerificacion();
        });

        const botonEliminarArchivo = divVerificacion.querySelector('.botonEliminarArchivo');
        const inputArchivo = divVerificacion.querySelector('input[type="file"]');

        botonEliminarArchivo.addEventListener('click', function () {
            inputArchivo.value = '';
        });

        actualizarEstadoBotonVerificacion(); 
    }
});





function obtenerevidencias(evidencias) {
    const contenedorVerificaciones = document.querySelector('.verifiacionesdiv');
    contenedorVerificaciones.innerHTML = '';

    evidencias.forEach(function (evidencias, index) {
        const divVerificacion = document.createElement('div');
        divVerificacion.classList.add('row', 'generarverificacion', 'mb-3');
        divVerificacion.innerHTML = `
            <div class="col-12">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombre de la evidencia *</label>
                        <input type="text" class="form-control" name="NOMBRE_EVIDENCIA[]"  value="${evidencias.NOMBRE_EVIDENCIA || ''}"  required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Subir Evidencia (PDF) *</label>
                        <div class="d-flex align-items-center">
                            <input type="file" class="form-control me-2" name="DOCUMENTO_EVIDENCIA[]" accept=".pdf" >
                            <button type="button" class="btn btn-warning botonEliminarArchivo" title="Eliminar archivo">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-4">
                <div class="form-group text-center">
                    <button type="button" class="btn btn-danger botonEliminarVerificacion">Eliminar verificación <i class="bi bi-trash-fill"></i></button>
                </div>
            </div>
        `;

        contenedorVerificaciones.appendChild(divVerificacion);

        const botonEliminar = divVerificacion.querySelector('.botonEliminarVerificacion');
       botonEliminar.addEventListener('click', function () {
    contenedorVerificaciones.removeChild(divVerificacion);
});



        const botonEliminarArchivo = divVerificacion.querySelector('.botonEliminarArchivo');
        const inputArchivo = divVerificacion.querySelector('input[name="DOCUMENTO_EVIDENCIA"]');

        botonEliminarArchivo.addEventListener('click', function () {
            inputArchivo.value = '';
        });
    });
}




document.addEventListener("DOMContentLoaded", function () {
    const btnVerificacion = document.getElementById("btnVerificacion");
    const verificacionClienteDiv = document.getElementById("VERIFICACION_CLIENTE");
    const inputVerificacionEstado = document.getElementById("ESTADO_VERIFICACION");
    const quienValidaInput = document.getElementById("QUIEN_VALIDA");

    const usuarioAutenticado = quienValidaInput.getAttribute("data-usuario");

    btnVerificacion.addEventListener("click", function () {
        let estadoActual = parseInt(inputVerificacionEstado.value, 10);
        let nuevoEstado = estadoActual === 0 ? 1 : 0;

        inputVerificacionEstado.value = nuevoEstado;

        verificacionClienteDiv.style.display = nuevoEstado === 1 ? "block" : "none";

        if (nuevoEstado === 1) {
            quienValidaInput.value = usuarioAutenticado; 
        } else {
            quienValidaInput.value = "";
        }
    });
});




function toggleInput(inputId, activar) {
    const input = document.getElementById(inputId);
    if (input) {
        if (activar) {
            input.classList.remove("d-none"); 
        } else {
            input.classList.add("d-none"); 
            input.value = ""; 
        }
    }
}

 function seleccionarTodos(valor) {
    const radios = document.querySelectorAll(`input[type="radio"][value="${valor}"]`);
    radios.forEach(radio => {
        radio.checked = true;
        const inputName = radio.name;
        const id = 'motivo_' + inputName.split('_')[1];
        toggleInput(id, valor === 'No');
    });
}

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".botonEliminarArchivo").forEach(boton => {
        boton.addEventListener("click", function () {
            const inputArchivo = this.previousElementSibling;
            if (inputArchivo && inputArchivo.type === "file") {
                inputArchivo.value = ""; 
            }
        });
    });
});




$('#Tablaconfirmacion tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablaconfirmacion.row(tr);
    ID_FORMULARIO_CONFRIMACION = row.data().ID_FORMULARIO_CONFRIMACION;

    editarDatoTabla(row.data(), 'formularioCONFIRMACION', 'miModal_CONFIRMACION', 1);

    if (row.data().ESTADO_VERIFICACION == "1") {
        document.getElementById('VERIFICACION_CLIENTE').style.display = 'block';
    } else {
        document.getElementById('VERIFICACION_CLIENTE').style.display = 'none';
    }

    $(".verifiacionesdiv").empty();

    if (row.data().EVIDENCIAS && row.data().EVIDENCIAS.length > 0) {
        obtenerevidencias(row.data().EVIDENCIAS); 
    }

    if (row.data().QUIEN_VALIDA) {
        $("#QUIEN_VALIDA").val(row.data().QUIEN_VALIDA);
    }

    $("#ESTADO_VERIFICACION").val(row.data().ESTADO_VERIFICACION);


    document.getElementById('btnVerificacion').style.display = 'none';

    
   var selectize = $('#OFERTA_ID')[0].selectize;
    var ofertaId = row.data().OFERTA_ID;
    var noOferta = row.data().NO_OFERTA;

    if (ofertaId) {
        if (!selectize.options[ofertaId]) {
            selectize.addOption({ value: ofertaId, text: noOferta });
        }
        selectize.setValue(ofertaId);
    } else {
        selectize.clear();
    }

    let verificacionInfo = row.data().VERIFICACION_INFORMACION;
    if (verificacionInfo) {
        try {
            verificacionInfo = JSON.parse(verificacionInfo); 

            Object.keys(verificacionInfo).forEach(nombre => {
                let valor = verificacionInfo[nombre].valor;
                let motivo = verificacionInfo[nombre].motivo;

                let radioSelector = `input[name="${nombre}"][value="${valor}"]`;
                $(radioSelector).prop("checked", true);

                let inputId = "motivo_" + nombre.split("_")[1]; 

                let inputElement = document.getElementById(inputId);
                if (inputElement) {
                    if (valor === "No") {
                        $("#" + inputId).val(motivo).removeClass("d-none");
                    } else {
                        $("#" + inputId).addClass("d-none").val("");
                    }
                }
            });

        } catch (error) {
            console.error("Error al parsear JSON de VERIFICACION_INFORMACION:", error);
        }
    }
});





$(document).ready(function() {
    $('#Tablaconfirmacion tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablaconfirmacion.row(tr);
        
        hacerSoloLectura2(row.data(), '#miModal_CONFIRMACION');

        ID_FORMULARIO_CONFRIMACION = row.data().ID_FORMULARIO_CONFRIMACION;
        editarDatoTabla(row.data(), 'formularioCONFIRMACION', 'miModal_CONFIRMACION', 1);
        
        if (row.data().ESTADO_VERIFICACION == "1") {
        document.getElementById('VERIFICACION_CLIENTE').style.display = 'block';
        } else {
            document.getElementById('VERIFICACION_CLIENTE').style.display = 'none';
        }

        if (row.data().QUIEN_VALIDA) {
            $("#QUIEN_VALIDA").val(row.data().QUIEN_VALIDA);
        }

    document.getElementById('btnVerificacion').style.display = 'none';


        var selectize = $('#OFERTA_ID')[0].selectize;
        var ofertaId = row.data().OFERTA_ID;
        var noOferta = row.data().NO_OFERTA;

        if (ofertaId) {
            if (!selectize.options[ofertaId]) {
                selectize.addOption({ value: ofertaId, text: noOferta });
            }
            selectize.setValue(ofertaId);
        } else {
            selectize.clear();
        }

    let verificacionInfo = row.data().VERIFICACION_INFORMACION;
    if (verificacionInfo) {
        try {
            verificacionInfo = JSON.parse(verificacionInfo); 

            Object.keys(verificacionInfo).forEach(nombre => {
                let valor = verificacionInfo[nombre].valor;
                let motivo = verificacionInfo[nombre].motivo;

                let radioSelector = `input[name="${nombre}"][value="${valor}"]`;
                $(radioSelector).prop("checked", true);

                let inputId = "motivo_" + nombre.split("_")[1]; 

                let inputElement = document.getElementById(inputId);
                if (inputElement) {
                    if (valor === "No") {
                        $("#" + inputId).val(motivo).removeClass("d-none");
                    } else {
                        $("#" + inputId).addClass("d-none").val("");
                    }
                }
            });

        } catch (error) {
            console.error("Error al parsear JSON de VERIFICACION_INFORMACION:", error);
        }
    }


    });

    $('#miModal_CONFIRMACION').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_CONFIRMACION');
    });
});


$('#Tablaconfirmacion tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablaconfirmacion.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_FORMULARIO_CONFRIMACION: row.data().ID_FORMULARIO_CONFRIMACION
    };

    eliminarDatoTabla(data, [Tablaconfirmacion], 'confirmacionDelete');
});


