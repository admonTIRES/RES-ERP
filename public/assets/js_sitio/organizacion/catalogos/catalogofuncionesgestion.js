//VARIABLES
ID_CATALOGO_FUNCIONESGESTION = 0
Tablafuncionesgestion = null



const ModalArea = document.getElementById('miModal_FUNCIONESGESTION');
ModalArea.addEventListener('hidden.bs.modal', event => {
    ID_CATALOGO_FUNCIONESGESTION = 0;
    document.getElementById('formularioFUNCIONESGESTION').reset();
   
    $('#formularioFUNCIONESGESTION input[type="checkbox"]').prop('checked', false).prop('disabled', false);
});






// $("#guardarFormFuncionesgestion").click(function (e) {
//     e.preventDefault();

    
//     formularioValido = validarFormulario($('#formularioFUNCIONESGESTION'))

//     if (formularioValido) {

//     if (ID_CATALOGO_FUNCIONESGESTION == 0) {
        
//         alertMensajeConfirm({
//             title: "¿Desea guardar la información?",
//             text: "Al guardarla, se podra usar",
//             icon: "question",
//         },async function () { 

//             await loaderbtn('guardarFormFuncionesgestion')
//             await ajaxAwaitFormData({ api: 1, ID_CATALOGO_FUNCIONESGESTION: ID_CATALOGO_FUNCIONESGESTION }, 'GestionSave', 'formularioFUNCIONESGESTION', 'guardarFormFuncionesgestion', { callbackAfter: true, callbackBefore: true }, () => {
        
               

//                 Swal.fire({
//                     icon: 'info',
//                     title: 'Espere un momento',
//                     text: 'Estamos guardando la información',
//                     showConfirmButton: false
//                 })

//                 $('.swal2-popup').addClass('ld ld-breath')
        
                
//             }, function (data) {
                    

//                 ID_CATALOGO_FUNCIONESGESTION = data.gestion.ID_CATALOGO_FUNCIONESGESTION
//                     alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
//                      $('#miModal_FUNCIONESGESTION').modal('hide')
//                     document.getElementById('formularioFUNCIONESGESTION').reset();
//                     Tablafuncionesgestion.ajax.reload()

                         
                
//             })
                        
            
//         }, 1)
        
//     } else {
//             alertMensajeConfirm({
//             title: "¿Desea editar la información de este formulario?",
//             text: "Al guardarla, se podra usar",
//             icon: "question",
//         },async function () { 

//             await loaderbtn('guardarFormFuncionesgestion')
//             await ajaxAwaitFormData({ api: 1, ID_CATALOGO_FUNCIONESGESTION: ID_CATALOGO_FUNCIONESGESTION }, 'GestionSave', 'formularioFUNCIONESGESTION', 'guardarFormFuncionesgestion', { callbackAfter: true, callbackBefore: true }, () => {
        
//                 Swal.fire({
//                     icon: 'info',
//                     title: 'Espere un momento',
//                     text: 'Estamos guardando la información',
//                     showConfirmButton: false
//                 })

//                 $('.swal2-popup').addClass('ld ld-breath')
        
                
//             }, function (data) {
                    
//                 setTimeout(() => {

                    
//                     ID_CATALOGO_FUNCIONESGESTION = data.gestion.ID_CATALOGO_FUNCIONESGESTION
//                     alertMensaje('success', 'Información editada correctamente', 'Información guardada')
//                      $('#miModal_FUNCIONESGESTION').modal('hide')
//                     document.getElementById('formularioFUNCIONESGESTION').reset();
//                     Tablafuncionesgestion.ajax.reload()


//                 }, 300);  
//             })
//         }, 1)
//     }
// } else {
//     alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

// }
    
// });




$("#guardarFormFuncionesgestion").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioFUNCIONESGESTION'));

    if (formularioValido) {
        if (ID_CATALOGO_FUNCIONESGESTION == 0) {
            alertMensajeConfirm({
                title: "¿Desea guardar la información?",
                text: "Al guardarla, se podrá usar",
                icon: "question",
            }, async function () {
                await loaderbtn('guardarFormFuncionesgestion');
                await ajaxAwaitFormData(
                    { api: 1, ID_CATALOGO_FUNCIONESGESTION: ID_CATALOGO_FUNCIONESGESTION },
                    'GestionSave',
                    'formularioFUNCIONESGESTION',
                    'guardarFormFuncionesgestion',
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
                        ID_CATALOGO_FUNCIONESGESTION = data.gestion.ID_CATALOGO_FUNCIONESGESTION;
                        alertMensaje('success', 'Información guardada correctamente', 'Esta información está lista para usarse', null, null, 1500);
                        $('#miModal_FUNCIONESGESTION').modal('hide');
                        document.getElementById('formularioFUNCIONESGESTION').reset();
                        Tablafuncionesgestion.ajax.reload();
                    }
                );
            }, 1);
        } else {
            alertMensajeConfirm({
                title: "¿Desea editar la información de este formulario?",
                text: "Al guardarla, se podrá usar",
                icon: "question",
            }, async function () {
                await loaderbtn('guardarFormFuncionesgestion');
                await ajaxAwaitFormData(
                    { api: 1, ID_CATALOGO_FUNCIONESGESTION: ID_CATALOGO_FUNCIONESGESTION },
                    'GestionSave',
                    'formularioFUNCIONESGESTION',
                    'guardarFormFuncionesgestion',
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
                            ID_CATALOGO_FUNCIONESGESTION = data.gestion.ID_CATALOGO_FUNCIONESGESTION;
                            alertMensaje('success', 'Información editada correctamente', 'Información guardada');
                            $('#miModal_FUNCIONESGESTION').modal('hide');
                            document.getElementById('formularioFUNCIONESGESTION').reset();
                            Tablafuncionesgestion.ajax.reload();
                        }, 300);
                    }
                );
            }, 1);
        }
    } else {
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000);
    }
});




var Tablafuncionesgestion = $("#Tablafuncionesgestion").DataTable({
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
        url: '/Tablafuncionesgestion',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablafuncionesgestion.columns.adjust().draw();
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
        { 
            data: null,
            render: function (data, type, row) {
                let selectedGestion = [];
                if (row.DIRECTOR_GESTION && row.DIRECTOR_GESTION !== 'null') {
                    selectedGestion.push('Director');
                }
                if (row.LIDER_GESTION && row.LIDER_GESTION !== 'null') {
                    selectedGestion.push('Líder categoría');
                }
                if (row.COLABORADOR_GESTION && row.COLABORADOR_GESTION !== 'null') {
                    selectedGestion.push('Colaborador');
                }
                if (row.TODO_GESTION && row.TODO_GESTION !== 'null') {
                    selectedGestion.push('Todos');
                }
                return selectedGestion.join(', ');
            }
        },
        { data: 'DESCRIPCION_FUNCION_GESTION'},
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Función destinada a:', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Descripción', className: 'all text-center descripcion-column' },
        { targets: 3, title: 'Editar', className: 'all text-center' },
        { targets: 4, title: 'Visualizar', className: 'all text-center' },
        { targets: 5, title: 'Activo', className: 'all text-center' }
    ]
});




$('#Tablafuncionesgestion tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablafuncionesgestion.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_CATALOGO_FUNCIONESGESTION: row.data().ID_CATALOGO_FUNCIONESGESTION
    };

    eliminarDatoTabla(data, [Tablafuncionesgestion], 'GestionDelete');
});



$(document).ready(function() {
    $('#Tablafuncionesgestion tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablafuncionesgestion.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_FUNCIONESGESTION');

        ID_CATALOGO_FUNCIONESGESTION = row.data().ID_CATALOGO_FUNCIONESGESTION;
        editarDatoTabla(row.data(), 'formularioFUNCIONESGESTION', 'miModal_FUNCIONESGESTION',1);
    });

    $('#miModal_FUNCIONESGESTION').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_FUNCIONESGESTION');
    });
});


$('#Tablafuncionesgestion tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablafuncionesgestion.row(tr);
    ID_CATALOGO_FUNCIONESGESTION = row.data().ID_CATALOGO_FUNCIONESGESTION;

    editarDatoTabla(row.data(), 'formularioFUNCIONESGESTION', 'miModal_FUNCIONESGESTION', 1);

    var data = row.data();
    $('#formularioFUNCIONESGESTION').find('input[type="checkbox"]').each(function () {
        var inputName = $(this).attr('name');
        if (data[inputName] !== undefined) {
            $(this).prop('checked', data[inputName] === $(this).val());
        }
    });

});


document.addEventListener('DOMContentLoaded', function () {
    const directorCheckbox = document.getElementById('director');
    const liderCheckbox = document.getElementById('lider');
    const colaboradorCheckbox = document.getElementById('colaborador');
    const todoCheckbox = document.getElementById('todo');

    function updateCheckboxState() {
        if (todoCheckbox.checked) {
            directorCheckbox.checked = false;
            liderCheckbox.checked = false;
            colaboradorCheckbox.checked = false;
            directorCheckbox.disabled = true;
            liderCheckbox.disabled = true;
            colaboradorCheckbox.disabled = true;
        } else {
            directorCheckbox.disabled = false;
            liderCheckbox.disabled = false;
            colaboradorCheckbox.disabled = false;

            const selectedCheckboxes = [directorCheckbox, liderCheckbox, colaboradorCheckbox].filter(checkbox => checkbox.checked);
            if (selectedCheckboxes.length >= 2) {
                [directorCheckbox, liderCheckbox, colaboradorCheckbox].forEach(checkbox => {
                    if (!checkbox.checked) {
                        checkbox.disabled = true;
                    }
                });
            } else {
                [directorCheckbox, liderCheckbox, colaboradorCheckbox].forEach(checkbox => {
                    checkbox.disabled = false;
                });
            }
        }
    }

    directorCheckbox.addEventListener('change', updateCheckboxState);
    liderCheckbox.addEventListener('change', updateCheckboxState);
    colaboradorCheckbox.addEventListener('change', updateCheckboxState);
    todoCheckbox.addEventListener('change', updateCheckboxState);
});


