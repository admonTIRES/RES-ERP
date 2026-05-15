//VARIABLES
ID_IDIOMAS = 0




const ModalArea = document.getElementById('miModal_idioma')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    ID_IDIOMAS = 0
    document.getElementById('formularioidioma').reset();
   
    $('#miModal_idioma .modal-title').html('Nuevo idioma');


})






$("#guardaridioma").click(function (e) {
    e.preventDefault();


    formularioValido = validarFormulario3($('#formularioidioma'))

    if (formularioValido) {

    if (ID_IDIOMAS == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardaridioma')
            await ajaxAwaitFormData({ api: 6, ID_IDIOMAS: ID_IDIOMAS }, 'CatcapacitacionSave', 'formularioidioma', 'guardaridioma', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                    ID_IDIOMAS = data.capacitaciones.ID_IDIOMAS
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_idioma').modal('hide')
                    document.getElementById('formularioidioma').reset();
                    Tablacapidioma.ajax.reload()
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardaridioma')
            await ajaxAwaitFormData({ api: 6, ID_IDIOMAS: ID_IDIOMAS }, 'CatcapacitacionSave', 'formularioidioma', 'guardaridioma', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    ID_IDIOMAS = data.capacitaciones.ID_IDIOMAS
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_idioma').modal('hide')
                    document.getElementById('formularioidioma').reset();
                    Tablacapidioma.ajax.reload()

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});



var Tablacapidioma = $("#Tablacapidioma").DataTable({
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
        url: '/Tablacapidioma',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablacapidioma.columns.adjust().draw();
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
        { data: 'NOMBRE_IDIOMA' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Nombre del idioma', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Editar', className: 'all text-center' },
        { targets: 3, title: 'Visualizar', className: 'all text-center' },
        { targets: 4, title: 'Activo', className: 'all text-center' }
    ]
});





$('#Tablacapidioma tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacapidioma.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 6,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_IDIOMAS: row.data().ID_IDIOMAS
    };

    eliminarDatoTabla(data, [Tablacapidioma], 'CatcapacitacionDelete');
});



$('#Tablacapidioma tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacapidioma.row(tr);


    ID_IDIOMAS = row.data().ID_IDIOMAS;

    editarDatoTabla(row.data(), 'formularioidioma', 'miModal_idioma');

    $('#miModal_idioma .modal-title').html(row.data().NOMBRE_IDIOMA);

});



$(document).ready(function() {
    $('#Tablacapidioma tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablacapidioma.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_idioma');

        ID_IDIOMAS = row.data().ID_IDIOMAS;
        editarDatoTabla(row.data(), 'formularioidioma', 'miModal_idioma');
         $('#miModal_idioma .modal-title').html(row.data().NOMBRE_IDIOMA);

    });

    $('#miModal_idioma').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_idioma');
    });
});

