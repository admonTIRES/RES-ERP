//VARIABLES
ID_CATALOGO_COMPETENCIA_GERENCIAL = 0




const ModalArea = document.getElementById('miModal_COMPETENCIAGERENCIALES')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    
    ID_CATALOGO_COMPETENCIA_GERENCIAL = 0
    document.getElementById('forCompetenciasGerenciales').reset();
   
    $('#miModal_COMPETENCIAGERENCIALES .modal-title').html('Nueva competencia gerencial');

})


$("#guardarFormCompetenciaGerencial").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#forCompetenciasGerenciales'))

    if (formularioValido) {

        if (ID_CATALOGO_COMPETENCIA_GERENCIAL == 0) {
            
            alertMensajeConfirm({
                title: "¿Desea guardar la información?",
                text: "Confime para continuar el proceso",
                icon: "question",
            },async function () { 

                await loaderbtn('guardarFormCompetenciaGerencial')
                await ajaxAwaitFormData({ api: 1, ID_CATALOGO_COMPETENCIA_GERENCIAL: ID_CATALOGO_COMPETENCIA_GERENCIAL }, 'GerencialesSave', 'forCompetenciasGerenciales', 'guardarFormCompetenciaGerencial', { callbackAfter: true, callbackBefore: true }, () => {
            
                    

                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    })

                    $('.swal2-popup').addClass('ld ld-breath')
            
                    
                }, function (data) {
                        

                        ID_CATALOGO_COMPETENCIA_GERENCIAL = data.basico.ID_CATALOGO_COMPETENCIA_GERENCIAL
                        alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                        $('#miModal_COMPETENCIAGERENCIALES').modal('hide')
                        document.getElementById('forCompetenciasGerenciales').reset();
                        TablaCompetenciasGerenciales.ajax.reload()

                
                    
                    
                })
                
                
                
            }, 1)
            
        } else {
                alertMensajeConfirm({
                title: "¿Desea editar la información de este formulario?",
                text: "Confime para continuar el proceso",
                icon: "question",
            },async function () { 

                await loaderbtn('guardarFormCompetenciaGerencial')
                await ajaxAwaitFormData({ api: 1, ID_CATALOGO_COMPETENCIA_GERENCIAL: ID_CATALOGO_COMPETENCIA_GERENCIAL }, 'GerencialesSave', 'forCompetenciasGerenciales', 'guardarFormCompetenciaGerencial', { callbackAfter: true, callbackBefore: true }, () => {
            
                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    })

                    $('.swal2-popup').addClass('ld ld-breath')
            
                    
                }, function (data) {
                        
                    setTimeout(() => {

                        
                        ID_CATALOGO_COMPETENCIA_GERENCIAL = data.basico.ID_CATALOGO_COMPETENCIA_GERENCIAL
                        alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                            $('#miModal_COMPETENCIAGERENCIALES').modal('hide')
                        document.getElementById('forCompetenciasGerenciales').reset();
                        TablaCompetenciasGerenciales.ajax.reload()


                    }, 300);  
                })
            }, 1)
        }

    } else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

    }
    
});


var TablaCompetenciasGerenciales = $("#TablaCompetenciasGerenciales").DataTable({
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
        url: '/TablaCompetenciasGerenciales',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            TablaCompetenciasGerenciales.columns.adjust().draw();
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
        { data: 'NOMBRE_COMPETENCIA_GERENCIAL' },
        { data: 'DESCRIPCION_COMPETENCIA_GERENCIAL' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Nombre', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Descripción', className: 'all text-center descripcion-column' },
        { targets: 3, title: 'Editar', className: 'all text-center' },
        { targets: 4, title: 'Visualizar', className: 'all text-center' },
        { targets: 5, title: 'Activo', className: 'all text-center' }
    ]
});





$('#TablaCompetenciasGerenciales tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = TablaCompetenciasGerenciales.row(tr);
    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_CATALOGO_COMPETENCIA_GERENCIAL: row.data().ID_CATALOGO_COMPETENCIA_GERENCIAL
    };

    eliminarDatoTabla(data, [TablaCompetenciasGerenciales], 'GerencialesDelete');
});




$('#TablaCompetenciasGerenciales tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = TablaCompetenciasGerenciales.row(tr);
    ID_CATALOGO_COMPETENCIA_GERENCIAL = row.data().ID_CATALOGO_COMPETENCIA_GERENCIAL;

    editarDatoTabla(row.data(), 'forCompetenciasGerenciales', 'miModal_COMPETENCIAGERENCIALES');
     $('#miModal_COMPETENCIAGERENCIALES .modal-title').html(row.data().NOMBRE_COMPETENCIA_GERENCIAL);

});



$(document).ready(function() {
    $('#TablaCompetenciasGerenciales tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = TablaCompetenciasGerenciales.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_COMPETENCIAGERENCIALES');

        ID_CATALOGO_COMPETENCIA_GERENCIAL = row.data().ID_CATALOGO_COMPETENCIA_GERENCIAL;
        editarDatoTabla(row.data(), 'forCompetenciasGerenciales', 'miModal_COMPETENCIAGERENCIALES',1);
     $('#miModal_COMPETENCIAGERENCIALES .modal-title').html(row.data().NOMBRE_COMPETENCIA_GERENCIAL);

    });

    $('#miModal_COMPETENCIAGERENCIALES').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_COMPETENCIAGERENCIALES');
    });
});

