//VARIABLES
ID_FORMULARIO_DPT = 0


var contadorCompetencias = 1;
var contadorCompetencias1 = 1;


const ModalArea = document.getElementById('miModal_DPT');
ModalArea.addEventListener('hidden.bs.modal', function(event) {
    ID_FORMULARIO_DPT = 0;

    document.getElementById('formularioDPT').reset();

    $('#formularioDPT input').prop('disabled', false);
    $('#formularioDPT textarea').prop('disabled', false);
    $('#formularioDPT select').prop('disabled', false);

    $('.collapse').collapse('hide');

    $('#tbodyFucnionesCargo').empty();
    $('#tbodyFuncionesGestion').empty();

    for (let i = 1; i <= 8; i++) {
        $('#COMPETENCIA' + i).hide();
    }

    for (let i = 1; i <= 4; i++) {
        $('#GERENCIALES' + i).hide();
    }

    contadorCompetencias = 1;
    contadorCompetencias1 = 1;

    $('#agregarCompetencia').show();
    $('#agregarCompetencia1').show();
});






TablaDPT = $("#TablaDPT").DataTable({
    language: { url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json", },
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
        url: '/TablaDPT',
        beforeSend: function () {
            mostrarCarga()
        },
        complete: function () {
            TablaDPT.columns.adjust().draw()
            ocultarCarga()

        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
    columns: [
        { 
            data: null,
            render: function(data, type, row, meta) {
                return meta.row + 1; 
            }
        },
        { data: 'NOMBRE_CATEGORIA' }, 
        { data: 'ELABORADO_POR' },
        { data: 'REVISADO_POR' },
        { data: 'AUTORIZADO_POR' },
        { data: 'BTN_DPT' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_ELIMINAR' },
        
        
    ],
    columnDefs: [
        { target: 0, title: '#', className: 'all  text-center' },
        { target: 1, title: 'Nombre categoría', className: 'all  text-center' },
        { target: 2, title: 'Elaborado por', className: 'all text-center' },
        { target: 3, title: 'Revisado por', className: 'all text-center' },
        { target: 4, title: 'Aprobado por', className: 'all text-center' },
        { target: 5, title: 'Descargar', className: 'all text-center' },
        { target: 6, title: 'Editar', className: 'all text-center' },
        { target: 7, title: 'Activo', className: 'all text-center' },



    ]
})


$("#guardarFormDPT").click(function (e) {
        e.preventDefault();

        formularioValido = validarFormulario($('#formularioDPT'))

     if (formularioValido) {

        if (ID_FORMULARIO_DPT == 0) {
            alertMensajeConfirm({
                title: "¿Desea guardar la información?",
                text: "Al guardarla, se usara para la creación del DPT",
                icon: "question",
            }, async function () { 
                await loaderbtn('guardarFormDPT');
                await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_DPT: ID_FORMULARIO_DPT}, 'dptSave', 'formularioDPT', 'guardarFormDPT', { callbackAfter: true, callbackBefore: true }, () => {
                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });
                    $('.swal2-popup').addClass('ld ld-breath');
                }, function (data) {
                    setTimeout(() => {
                        ID_FORMULARIO_DPT = data.DPT.ID_FORMULARIO_DPT;
                        alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para hacer uso del DPT',null,null, 1500);
                        $('#miModal_DPT').modal('hide');
                        document.getElementById('formularioDPT').reset();
                        TablaDPT.ajax.reload();
                        $('#PUESTOS_INTERACTUAN_DPT')[0].selectize.clear();
                    }, 300);
                });
            }, 1);
        } else {
            alertMensajeConfirm({
                title: "¿Desea editar la información de este formulario?",
                text: "Al guardarla, se editara la información del DPT",
                icon: "question",
            }, async function () { 
                await loaderbtn('guardarFormDPT');
                await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_DPT: ID_FORMULARIO_DPT }, 'dptSave', 'formularioDPT', 'guardarFormDPT', { callbackAfter: true, callbackBefore: true }, () => {
                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });
                    $('.swal2-popup').addClass('ld ld-breath');
                }, function (data) {
                    setTimeout(() => {
                        ID_FORMULARIO_DPT = data.DPT.ID_FORMULARIO_DPT;
                        alertMensaje('success', 'Información editada correctamente', 'Información guardada');
                        $('#miModal_DPT').modal('hide');
                        document.getElementById('formularioDPT').reset();
                        TablaDPT.ajax.reload();
                        $('#PUESTOS_INTERACTUAN_DPT')[0].selectize.clear();
                    }, 300);  
                });
            }, 1);
        }
         } else {
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

    }
});



var info = ''
// $("#DEPARTAMENTOS_AREAS_ID").on("change", function () {

//     var valorSeleccionado = $(this).find("option:selected");

//     //Obtenemos valores
//     var infoLugar = valorSeleccionado.data("lugar");
//     var infoProposito = valorSeleccionado.data("proposito");
//     var infoLider = valorSeleccionado.data("lider");
//     var textoSeleccionado = valorSeleccionado.text();

//     //Asignamos valores 
//     $('#AREA_TRABAJO_DPT').val(infoLugar).prop('readonly', true)
//     $('#PROPOSITO_FINALIDAD_DPT').val(infoProposito).prop('readonly', true)


//     //Creamos la ruta de consulta 
//     lider = textoSeleccionado.toUpperCase() == 'DIRECTOR' ? 2 : parseInt(infoLider)
//     ruta = '/infoReportan/' + parseInt($(this).val()) + '/' + lider

//     //Realizamos la peticion para consultar la informacion
//     ajaxAwait({}, ruta , 'GET', { callbackAfter: true, callbackBefore: true }, () => {

//         $('#PUESTO_REPORTA_DPT').val('Consultando información...').prop('readonly', true)
//         $('#PUESTO_LE_REPORTAN_DPT').val('Consultando información...').prop('readonly', true)
//         $('#PUESTOS_DIRECTOS_DPT').val('Consultando información...').prop('readonly', true)


//     }, function (data) {
//             info = data


//             $('#tbodyFucnionesCargo').empty();
            
//             //FUNCIONES DE CARG0
//             $.each(data.FUNCIONES, function(index, funcion) {
//                 let rowHtml = '';
            
//                 if (funcion.TIPO == 'generica') {
//                     rowHtml = `<tr>
//                         <td id="desc-cargo-${funcion.ID}" class="description blocked">
//                             ${funcion.DESCRIPCION}
//                         </td>
//                         <td>
//                             <div class="switch-container">
//                                 <label class="switch">
//                                     <input type="checkbox" class="toggle-switch-cargo" name="FUNCIONES_CARGO_DPT[]" value="${funcion.ID}">
//                                     <span class="slider"></span>
//                                 </label>
//                             </div>
//                         </td>
//                     </tr>`;
//                 } else {
//                     rowHtml = `<tr>
//                         <td id="desc-cargo-${funcion.ID}" class="description active">
//                             ${funcion.DESCRIPCION}
//                         </td>
//                         <td>
//                             <div class="switch-container">
//                                 <label class="switch">
//                                     <input type="checkbox" class="toggle-switch-cargo" name="FUNCIONES_CARGO_DPT[]" value="${funcion.ID}" >
//                                     <span class="slider"></span>
//                                 </label>
//                             </div>
//                         </td>
//                     </tr>`;
//                 }
            
//                 $('#tbodyFucnionesCargo').append(rowHtml);
//             });

                    

//         //CONSUILTAMOS LOS REPONSABLES DE CADA CATEGORIA
//         if (lider == 1 || lider == 2) {
//             $('#PUESTO_REPORTA_DPT').val(data.REPORTA).prop('readonly', true)
//             $('#PUESTO_LE_REPORTAN_DPT').val(data.REPORTAN[0].REPORTAN).prop('readonly', true)
//             $('#PUESTOS_DIRECTOS_DPT').val(data.REPORTAN[0].TOTAL).prop('readonly', true)


//         } else {

//             $('#PUESTO_REPORTA_DPT').val(data.REPORTA[0].REPORTA).prop('readonly', true)
//             $('#PUESTO_LE_REPORTAN_DPT').val(data.REPORTAN).prop('readonly', true)
//             $('#PUESTOS_DIRECTOS_DPT').val(0).prop('readonly', true)

//         }  


//           // Consultar responsables
//           if (lider == 1 || lider == 2) {
//             $('#PUESTO_REPORTA_DPT').val(data.REPORTA).prop('readonly', true);
//             $('#PUESTO_LE_REPORTAN_DPT').val(data.REPORTAN[0].REPORTAN).prop('readonly', true);
//             $('#PUESTOS_DIRECTOS_DPT').val(data.REPORTAN[0].TOTAL).prop('readonly', true);
//         } else {
//             $('#PUESTO_REPORTA_DPT').val(data.REPORTA[0].REPORTA).prop('readonly', true);
//             $('#PUESTO_LE_REPORTAN_DPT').val(data.REPORTAN).prop('readonly', true);
//             $('#PUESTOS_DIRECTOS_DPT').val(0).prop('readonly', true);
//         }

//         // Ajustar valores específicos de los campos
//         if (valor === 10) {
//             $('#PUESTO_REPORTA_DPT').val('Director');
//             $('#PUESTO_LE_REPORTAN_DPT').val('Ninguno');
//         } else if (valor === 13) {
//             $('#PUESTO_REPORTA_DPT').val('Ninguno');
//             $('#PUESTO_LE_REPORTAN_DPT').val('Ninguno');
//         }




        
//     })
// });



$("#DEPARTAMENTOS_AREAS_ID").on("change", function () {
    var valorSeleccionado = $(this).find("option:selected");
    var valor = parseInt($(this).val());

    var infoLugar = valorSeleccionado.data("lugar");
    var infoProposito = valorSeleccionado.data("proposito");
    var infoLider = valorSeleccionado.data("lider");
    var textoSeleccionado = valorSeleccionado.text();

    $('#AREA_TRABAJO_DPT').val(infoLugar).prop('readonly', true);
    $('#PROPOSITO_FINALIDAD_DPT').val(infoProposito).prop('readonly', true);

    var lider = textoSeleccionado.toUpperCase() == 'DIRECTOR' ? 2 : parseInt(infoLider);
    var ruta = '/infoReportan/' + valor + '/' + lider;

    ajaxAwait({}, ruta, 'GET', { callbackAfter: true, callbackBefore: true }, () => {
        $('#PUESTO_REPORTA_DPT').val('Consultando información...').prop('readonly', true);
        $('#PUESTO_LE_REPORTAN_DPT').val('Consultando información...').prop('readonly', true);
        $('#PUESTOS_DIRECTOS_DPT').val('Consultando información...').prop('readonly', true);
    }, function (data) {
        info = data;

        $('#tbodyFucnionesCargo').empty();

        $.each(data.FUNCIONES, function (index, funcion) {
            let rowHtml = '';

            if (funcion.TIPO == 'Genérica') {
                rowHtml = `<tr>
                    <td id="desc-cargo-${funcion.ID}" class="description blocked">
                        ${funcion.DESCRIPCION}
                    </td>
                    <td>
                        <div class="switch-container">
                            <label class="switch">
                                <input type="checkbox" class="toggle-switch-cargo" name="FUNCIONES_CARGO_DPT[]" value="${funcion.ID}">
                                <span class="slider"></span>
                            </label>
                        </div>
                    </td>
                </tr>`;
            } else {
                rowHtml = `<tr>
                    <td id="desc-cargo-${funcion.ID}" class="description blocked">
                        ${funcion.DESCRIPCION}
                    </td>
                    <td>
                        <div class="switch-container">
                            <label class="switch">
                                <input type="checkbox" class="toggle-switch-cargo" name="FUNCIONES_CARGO_DPT[]" value="${funcion.ID}" >
                                <span class="slider"></span>
                            </label>
                        </div>
                    </td>
                </tr>`;
            }

            $('#tbodyFucnionesCargo').append(rowHtml);
        });

        if (valor === 10) {
            $('#PUESTO_REPORTA_DPT').val('Director');
            $('#PUESTO_LE_REPORTAN_DPT').val('Ninguno');
            $('#PUESTOS_DIRECTOS_DPT').val('0');

        } else if (valor === 13) {
            $('#PUESTO_REPORTA_DPT').val('Junta Directiva');
            $('#PUESTO_LE_REPORTAN_DPT').val('Todos los colaboradores y líderes de procesos');
            $('#PUESTOS_DIRECTOS_DPT').val('5');

        } else {
            if (lider == 1 || lider == 2) {
                $('#PUESTO_REPORTA_DPT').val(data.REPORTA).prop('readonly', true);
                $('#PUESTO_LE_REPORTAN_DPT').val(data.REPORTAN[0].REPORTAN).prop('readonly', true);
                $('#PUESTOS_DIRECTOS_DPT').val(data.REPORTAN[0].TOTAL).prop('readonly', true);
            } else if (data.REPORTA && data.REPORTA.length > 0) {
                $('#PUESTO_REPORTA_DPT').val(data.REPORTA[0].REPORTA).prop('readonly', true);
                $('#PUESTO_LE_REPORTAN_DPT').val(data.REPORTAN).prop('readonly', true);
                $('#PUESTOS_DIRECTOS_DPT').val(0).prop('readonly', true);
            }
        }
    });
});



//FUNCION EDITAR   Y QUE SE MUESTREN LOS SELECT

$(document).ready(function () {

    var $select = $('#PUESTOS_INTERACTUAN_DPT').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
        onItemAdd: function(value, $item) {
            contarPuestosInderectos();
        },
        onItemRemove: function(value) {
            contarPuestosInderectos();
        }
    });

    var selectizeInstance = $select[0].selectize;

    $('#TablaDPT tbody').on('click', 'td>button.EDITAR', function () {
        var tr = $(this).closest('tr');
        var row = TablaDPT.row(tr);
        ID_FORMULARIO_DPT = row.data().ID_FORMULARIO_DPT;
        var form = "formularioDPT";
        var data = row.data();
        
        var savedOptions = [];
        var puestosInteractuan = data.PUESTOS_INTERACTUAN_DPT;
    
        if (Array.isArray(puestosInteractuan)) { 
            savedOptions = puestosInteractuan;
        } else if (puestosInteractuan && puestosInteractuan.length > 2) { 
            try {
                savedOptions = JSON.parse(puestosInteractuan);
            } catch (e) {
                console.error("Error al parsear JSON: ", e);
            }
        } else {
            console.warn("PUESTOS_INTERACTUAN_DPT está vacío o no tiene un formato JSON válido.");
        }
        
        selectizeInstance.clear();
    
        if (Array.isArray(savedOptions)) {
            selectizeInstance.setValue(savedOptions);
        }
    
        editarDatoTabla(data, form, 'miModal_DPT', 1);
        mostrarFunciones(data, form);
    


        const areaId = data["DEPARTAMENTOS_AREAS_ID"];
        if (areaId) {
            consultarFuncionesConSeleccion(areaId, data["FUNCIONES_CARGO_DPT"] || [])
                .then(() => {
                    console.log("Funciones cargadas correctamente.");
                })
                .catch((error) => {
                    console.error("Error al cargar funciones:", error);
                });
        }
    



        const funcionesGestionGuardadas = data["FUNCIONES_GESTION_DPT"] || [];
        let funcionesGestionGuardadasArray = [];
        
        if (typeof funcionesGestionGuardadas === 'string') {
            try {
                funcionesGestionGuardadasArray = JSON.parse(funcionesGestionGuardadas);
            } catch (e) {
                console.error("Error al parsear FUNCIONES_GESTION_DPT:", e);
            }
        } else if (Array.isArray(funcionesGestionGuardadas)) {
            funcionesGestionGuardadasArray = funcionesGestionGuardadas;
        }
        
        $('input[name="FUNCIONES_GESTION_DPT[]"]').each(function () {
            const funcionId = $(this).val();
            const isChecked = funcionesGestionGuardadasArray.includes(funcionId);
        
            $(this).prop('checked', isChecked);
        
            const descripcionElement = $(`#desc-gestion-${funcionId}`);
        
            if (isChecked) {
                descripcionElement.removeClass('blocked');
            } else {
                descripcionElement.addClass('blocked');
            }
        });


        for (let i = 1; i <= 8; i++) {
            const competenciaField = document.getElementById(`COMPETENCIA${i}`);
            const nombreField = document.getElementById(`NOMBRE_COMPETENCIA${i}`);
            const descripcionField = document.getElementById(`DESCRIPCION_COMPETENCIA${i}`);
            const escalaBajo = document.getElementById(`ESCALA_INNOVACION_BAJO`);
            const escalaMedio = document.getElementById(`ESCALA_INNOVACION_MEDIO`);
            const escalaAlto = document.getElementById(`ESCALA_INNOVACION_ALTO`);
    
            if (data[`NOMBRE_COMPETENCIA${i}`] && data[`NOMBRE_COMPETENCIA${i}`] !== "") {
                competenciaField.style.display = 'table-row';
                nombreField.value = data[`NOMBRE_COMPETENCIA${i}`];
                descripcionField.value = data[`DESCRIPCION_COMPETENCIA${i}`];
    
                if (data[`COMPETENCIA${i}_ESCALA`] === 'BAJO') {
                    escalaBajo.checked = true;
                } else if (data[`COMPETENCIA${i}_ESCALA`] === 'MEDIO') {
                    escalaMedio.checked = true;
                } else if (data[`COMPETENCIA${i}_ESCALA`] === 'ALTO') {
                    escalaAlto.checked = true;
                }
            } else {
                competenciaField.style.display = 'none';
            }
        }
    
        for (let i = 1; i <= 4; i++) {
            const gerencialField = document.getElementById(`GERENCIALES${i}`);
            const nombreGerencialField = document.getElementById(`NOMBRE_COMPETENCIA${10 + i}`);
            const descripcionGerencialField = document.getElementById(`DESCRIPCION_COMPETENCIA${10 + i}`);
            const escalaBajoGerencial = document.getElementById(`ESCALA_INNOVACION_BAJO`);
            const escalaMedioGerencial = document.getElementById(`ESCALA_INNOVACION_MEDIO`);
            const escalaAltoGerencial = document.getElementById(`ESCALA_INNOVACION_ALTO`);
    
            if (data[`NOMBRE_COMPETENCIA${10 + i}`] && data[`NOMBRE_COMPETENCIA${10 + i}`] !== "") {
                gerencialField.style.display = 'table-row';
                nombreGerencialField.value = data[`NOMBRE_COMPETENCIA${10 + i}`];
                descripcionGerencialField.value = data[`DESCRIPCION_COMPETENCIA${10 + i}`];
    
                if (data[`COMPETENCIA${10 + i}_ESCALA`] === 'BAJO') {
                    escalaBajoGerencial.checked = true;
                } else if (data[`COMPETENCIA${10 + i}_ESCALA`] === 'MEDIO') {
                    escalaMedioGerencial.checked = true;
                } else if (data[`COMPETENCIA${10 + i}_ESCALA`] === 'ALTO') {
                    escalaAltoGerencial.checked = true;
                }
            } else {
                gerencialField.style.display = 'none';
            }
        }
    });
    


    function contarPuestosInderectos() {
        var count = $select[0].selectize.items.length;
        $('#PUESTOS_INDIRECTOS_DPT').val(count);
    }
});



function toggleDescription(tablePrefix, id, checked) {
    const description = document.getElementById(`desc-${tablePrefix}-${id}`);
    if (description) {
        if (checked) {
            description.classList.remove('blocked');
            description.classList.add('active');
        } else {
            description.classList.remove('active');
            description.classList.add('blocked');
        }
    }
}




function consultarFuncionesConSeleccion(areaId, funcionesSeleccionadas = []) {
    return new Promise((resolve, reject) => {
        const ruta = `/consultarfuncionescargo/${areaId}`;
        $.ajax({
            url: ruta,
            type: "GET",
            success: function (response) {
                if (response.code === 1) {
                    $('#tbodyFucnionesCargo').empty();

                    $.each(response.FUNCIONES, function (index, funcion) {
                        const isChecked = funcionesSeleccionadas.includes(String(funcion.ID)) ? "checked" : "";
                        const blockedClass = isChecked ? '' : 'blocked';

                        const rowHtml = `<tr>
                            <td id="desc-cargo-${funcion.ID}" class="description ${blockedClass}">
                                ${funcion.DESCRIPCION}
                            </td>
                            <td>
                                <div class="switch-container">
                                    <label class="switch">
                                        <input type="checkbox" class="toggle-switch-cargo" name="FUNCIONES_CARGO_DPT[]" value="${funcion.ID}" ${isChecked}>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </td>
                        </tr>`;
                        $('#tbodyFucnionesCargo').append(rowHtml);
                    });

                    resolve();
                } else {
                    console.error("Error al cargar funciones:", response.msj);
                    reject(response.msj); 
                }
            },
            error: function (xhr, status, error) {
                console.error("Error en la consulta:", error);
                reject(error); 
            }
        });
    });
}




// MARCAR LOS CHECK Y QUE SE PONGAN LAS LETRAS EN NEGRO 
$(document).on('change', '.toggle-switch-cargo', function() {
    let isChecked = $(this).is(':checked');
    let descripcionTd = $(this).closest('tr').find('.description');

    if (isChecked) {
        descripcionTd.removeClass('blocked').addClass('active');
    } else {
        descripcionTd.removeClass('active').addClass('blocked');
    }
});





$('#TablaDPT tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = TablaDPT.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_FORMULARIO_DPT: row.data().ID_FORMULARIO_DPT
    };

    eliminarDatoTabla(data, [TablaDPT], 'dptDelete');
});

// $('#TablaDPT tbody').on('click', 'td>button.REVISAR', function () {


//     var tr = $(this).closest('tr');
//     var row = TablaDPT.row(tr);
//     ID_FORMULARIO_DPT = row.data().ID_FORMULARIO_DPT

//     //Rellenamos los datos del formulario
//     editarDatoTabla(row.data(), 'formularioDPT', 'miModal_DPT', 1)


//     $('#formularioDPT input').prop('disabled', true);
//     $('#formularioDPT textarea').prop('disabled', true);
//     $('#formularioDPT select').prop('disabled', true);

//     $('#revisarFormDPT').css('display', 'block').prop('disabled', false);
//     $('#guardarFormDPT').css('display', 'none').prop('disabled', true);

// })


// $('#TablaDPT tbody').on('click', 'td>button.AUTORIZAR', function () {


//     var tr = $(this).closest('tr');
//     var row = TablaDPT.row(tr);
//     ID_FORMULARIO_DPT = row.data().ID_FORMULARIO_DPT

//     //Rellenamos los datos del formulario
//     editarDatoTabla(row.data(), 'formularioDPT', 'miModal_DPT', 1)


//     $('#formularioDPT input').prop('disabled', true);
//     $('#formularioDPT textarea').prop('disabled', true);
//     $('#formularioDPT select').prop('disabled', true);

//     $('#AutorizarFormDPT').css('display', 'block').prop('disabled', false);
//     $('#guardarFormDPT').css('display', 'none').prop('disabled', true);

// })

// $('#revisarFormDPT').on('click', function () {
    
//     alertMensajeConfirm({
//         title: "¿Desea marcar como revisado este DPT?",
//         text: "Al revisarlo, pasara hacer autorizado ",
//         icon: "question",
//     }, function () { 

//         ajaxAwait({}, '/revisarDPT/' + ID_FORMULARIO_DPT, 'GET', { callbackAfter: true, callbackBefore: true }, () => {
    
//             Swal.fire({
//                 icon: 'info',
//                 title: 'Espere un momento...',
//                 text: 'Estamos confirmando la revisión',
//                 showConfirmButton: false
//             })

//             $('.swal2-popup').addClass('ld ld-breath')
    
            
//         }, function (data) {
                
            
//             alertMensaje('success','Revisión confirmada', 'Esta información esta lista para ser autorizada',null,null, 2000)
//             $('#miModal_DPT').modal('hide')
//             document.getElementById('formularioDPT').reset();
//             TablaDPT.ajax.reload()

//         })
        
//     }, 1)
// })


// $('#AutorizarFormDPT').on('click', function () {
    
//     alertMensajeConfirm({
//         title: "¿Desea autorizar el DPT?",
//         text: "Al autorizarlo, podra hacer uso del DPT ",
//         icon: "question",
//     }, function () { 

//         ajaxAwait({}, '/autorizarDPT/' + ID_FORMULARIO_DPT, 'GET', { callbackAfter: true, callbackBefore: true }, () => {
    
//             Swal.fire({
//                 icon: 'info',
//                 title: 'Espere un momento...',
//                 text: 'Estamos confirmando la autorización',
//                 showConfirmButton: false
//             })

//             $('.swal2-popup').addClass('ld ld-breath')
    
            
//         }, function (data) {
                
            
//             alertMensaje('success','Autorización confirmada', 'Esta información esta lista para ser utilizada',null,null, 2000)
//             $('#miModal_DPT').modal('hide')
//             document.getElementById('formularioDPT').reset();
//             TablaDPT.ajax.reload()

//         })
        
//     }, 1)
// })


$('#TablaDPT tbody').on('click', 'td>button.DPT', function () {


    var tr = $(this).closest('tr');
    var row = TablaDPT.row(tr);
    ID_FORMULARIO_DPT = row.data().ID_FORMULARIO_DPT

   
       alertMensajeConfirm({
        title: "¿Desea visualizar el formato DPT?",
        text: "Confirma para continuar ",
        icon: "question",
    }, function () { 

		window.open("/makeExcelDPT/" + ID_FORMULARIO_DPT);
           
        
    }, 1)

})





// NO SELECCIONAR LA MISMA CATEGORIA EN LAS RELACIONES INTERNAS
document.addEventListener('DOMContentLoaded', function () {
    const selects = document.querySelectorAll('.area-select');

    selects.forEach(select => {
        select.addEventListener('change', function () {
            const selectedValues = Array.from(selects).map(s => s.value);
            
            selects.forEach(s => {
                const currentValue = s.value;
                const options = s.querySelectorAll('option');

                options.forEach(option => {
                    if (selectedValues.includes(option.value) && option.value !== currentValue) {
                        option.style.display = 'none';
                    } else {
                        option.style.display = 'block';
                    }
                });
            });
        });
    });
});

// NO SELECCIONAR LOS MISMOS DE RELACIONES EXTERNAS 

document.addEventListener('DOMContentLoaded', function () {
    const selects = document.querySelectorAll('.externa-select');

    selects.forEach(select => {
        select.addEventListener('change', function () {
            const selectedValues = Array.from(selects).map(s => s.value);
            
            selects.forEach(s => {
                const currentValue = s.value;
                const options = s.querySelectorAll('option');

                options.forEach(option => {
                    if (selectedValues.includes(option.value) && option.value !== currentValue) {
                        option.style.display = 'none';
                    } else {
                        option.style.display = 'block';
                    }
                });
            });
        });
    });
});


// NO SELECCIONAR LAS MISMAS Competencias básicas o cardinales 
document.addEventListener('DOMContentLoaded', function () {
    const selects = document.querySelectorAll('.cardinales-select');

    selects.forEach(select => {
        select.addEventListener('change', function () {
            const selectedValues = Array.from(selects).map(s => s.value);
            
            selects.forEach(s => {
                const currentValue = s.value;
                const options = s.querySelectorAll('option');

                options.forEach(option => {
                    if (selectedValues.includes(option.value) && option.value !== currentValue) {
                        option.style.display = 'none';
                    } else {
                        option.style.display = 'block';
                    }
                });
            });
        });
    });
});

// NO SELECCIONAR LAS MISMAS Competencias gerenciales o de mandos medios

document.addEventListener('DOMContentLoaded', function () {
    const selects = document.querySelectorAll('.gerenciales-select');

    selects.forEach(select => {
        select.addEventListener('change', function () {
            const selectedValues = Array.from(selects).map(s => s.value);
            
            selects.forEach(s => {
                const currentValue = s.value;
                const options = s.querySelectorAll('option');

                options.forEach(option => {
                    if (selectedValues.includes(option.value) && option.value !== currentValue) {
                        option.style.display = 'none';
                    } else {
                        option.style.display = 'block';
                    }
                });
            });
        });
    });
});




// CREAR UN NUEVO DPT
$(document).ready(function () {
    $("#nuevo_dpt").click(function (e) {
        e.preventDefault();
        $("#miModal_DPT").modal("show");

        $('.toggle-switch-cargo').each(function () {
            this.checked = false; 
            toggleDescription(this.name === 'FUNCIONES_CARGO_DPT[]' ? 'cargo' : 'gestion', this.value, false);
        });

        var selectize = $('#PUESTOS_INTERACTUAN_DPT')[0].selectize;
        selectize.clear();

        
    });

    document.querySelectorAll('.toggle-switch-cargo').forEach(switchInput => {
        switchInput.addEventListener('change', function () {
            const id = this.value; 
            const tablePrefix = this.name === 'FUNCIONES_CARGO_DPT[]' ? 'cargo' : 'gestion';
            toggleDescription(tablePrefix, id, this.checked);
        });
    });

    function toggleDescription(tablePrefix, id, checked) {
        const description = document.getElementById(`desc-${tablePrefix}-${id}`);
        if (description) {
            if (checked) {
                description.classList.remove('blocked');
                description.classList.add('active');
            } else {
                description.classList.remove('active');
                description.classList.add('blocked');
            }
        }
    }
});


function mostrarFunciones(data,form){

    if ('INTERNAS' in data) {

        if (data.INTERNAS.length > 0) { 
          var cursos = data.INTERNAS
          var count = 1    
  
          cursos.forEach(function (obj) {
  
  
            
            $('#' + form).find(`select[id='INTERNAS_CONQUIEN${count}_DPT']`).val(obj.INTERNAS_CONQUIEN_DPT)
            $('#' + form).find(`textarea[id='INTERNAS_PARAQUE${count}_DPT']`).val(obj.INTERNAS_PARAQUE_DPT)
            $('#' + form).find(`select[id='INTERNAS_FRECUENCIA${count}_DPT']`).val(obj.INTERNAS_FRECUENCIA_DPT)
  
            count++
          });
        }
      }
  
      
      if ('EXTERNAS' in data) {
  
        if (data.EXTERNAS.length > 0) { 
          var cursos1 = data.EXTERNAS
          var count = 1    
  
          cursos1.forEach(function (obj) {
  
            $('#' + form).find(`select[id='EXTERNAS_CONQUIEN${count}_DPT']`).val(obj.EXTERNAS_CONQUIEN_DPT)
            $('#' + form).find(`textarea[id='EXTERNAS_PARAQUE${count}_DPT']`).val(obj.EXTERNAS_PARAQUE_DPT)
            $('#' + form).find(`select[id='EXTERNAS_FRECUENCIA${count}_DPT']`).val(obj.EXTERNAS_FRECUENCIA_DPT)
  
            count++
          });
        }
      }

}


$(document).ready(function() {
    $('#NIVEL_JERARQUICO_DPT').on('change', function() {
        var descripcion = $(this).find('option:selected').data('descripcion');
        $('#DESCRIPCION_NIVEL_JERARQUICO').text(descripcion);
    });
});










$(document).ready(function() {
 

    $('#agregarCompetencia').on('click', function(e) {
        e.preventDefault();
    
        if (contadorCompetencias <= 8) {
            $('#COMPETENCIA' + contadorCompetencias).fadeIn();
            contadorCompetencias++;
    
            if (contadorCompetencias > 8) {
                $(this).hide();
            }
        }
    });
    
    $('#agregarCompetencia1').on('click', function(e) {
        e.preventDefault();
    
        if (contadorCompetencias1 <= 4) {
            $('#GERENCIALES' + contadorCompetencias1).fadeIn();
            contadorCompetencias1++;
    
            if (contadorCompetencias1 > 4) {
                $(this).hide();
            }
        }
    });


    $('select[id^="NOMBRE_COMPETENCIA"]').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var descripcion = selectedOption.data('descripcion');
        var competenciaId = $(this).attr('id').replace('NOMBRE_COMPETENCIA', 'DESCRIPCION_COMPETENCIA');
        $('#' + competenciaId).val(descripcion);
    });
});



