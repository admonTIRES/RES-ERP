//VARIABLES
ID_NORMATIVIDAD_MARCO = 0




const ModalArea = document.getElementById('miModal_normatividad')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    ID_NORMATIVIDAD_MARCO = 0
    document.getElementById('formularionormatividad').reset();
   
    $('#miModal_normatividad .modal-title').html('Nueva normativa o marco de referencia');


})






$("#guardarnormatividad").click(function (e) {
    e.preventDefault();


    formularioValido = validarFormulario3($('#formularionormatividad'))

    if (formularioValido) {

    if (ID_NORMATIVIDAD_MARCO == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarnormatividad')
            await ajaxAwaitFormData({ api: 7, ID_NORMATIVIDAD_MARCO: ID_NORMATIVIDAD_MARCO }, 'CatcapacitacionSave', 'formularionormatividad', 'guardarnormatividad', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                    ID_NORMATIVIDAD_MARCO = data.capacitaciones.ID_NORMATIVIDAD_MARCO
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_normatividad').modal('hide')
                    document.getElementById('formularionormatividad').reset();
                    Tablacapnormatividad.ajax.reload()
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarnormatividad')
            await ajaxAwaitFormData({ api: 7, ID_NORMATIVIDAD_MARCO: ID_NORMATIVIDAD_MARCO }, 'CatcapacitacionSave', 'formularionormatividad', 'guardarnormatividad', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    ID_NORMATIVIDAD_MARCO = data.capacitaciones.ID_NORMATIVIDAD_MARCO
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_normatividad').modal('hide')
                    document.getElementById('formularionormatividad').reset();
                    Tablacapnormatividad.ajax.reload()

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});



var Tablacapnormatividad = $("#Tablacapnormatividad").DataTable({
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
        url: '/Tablacapnormatividad',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablacapnormatividad.columns.adjust().draw();
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
        { data: 'NOMBRE_NORMATIVIDAD' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Nombre de la normativa o marco de referencia', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Editar', className: 'all text-center' },
        { targets: 3, title: 'Visualizar', className: 'all text-center' },
        { targets: 4, title: 'Activo', className: 'all text-center' }
    ]
});





$('#Tablacapnormatividad tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacapnormatividad.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 7,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_NORMATIVIDAD_MARCO: row.data().ID_NORMATIVIDAD_MARCO
    };

    eliminarDatoTabla(data, [Tablacapnormatividad], 'CatcapacitacionDelete');
});



$('#Tablacapnormatividad tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacapnormatividad.row(tr);


    ID_NORMATIVIDAD_MARCO = row.data().ID_NORMATIVIDAD_MARCO;

    editarDatoTabla(row.data(), 'formularionormatividad', 'miModal_normatividad');

    $('#miModal_normatividad .modal-title').html(row.data().NOMBRE_NORMATIVIDAD);

});



$(document).ready(function() {
    $('#Tablacapnormatividad tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablacapnormatividad.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_normatividad');

        ID_NORMATIVIDAD_MARCO = row.data().ID_NORMATIVIDAD_MARCO;
        editarDatoTabla(row.data(), 'formularionormatividad', 'miModal_normatividad');
         $('#miModal_normatividad .modal-title').html(row.data().NOMBRE_NORMATIVIDAD);

    });

    $('#miModal_normatividad').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_normatividad');
    });
});

