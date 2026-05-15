//VARIABLES
ID_FORMATO = 0




const ModalArea = document.getElementById('miModal_formato')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    ID_FORMATO = 0
    document.getElementById('formularioformato').reset();
   
    $('#miModal_formato .modal-title').html('Nuevo formato');


})






$("#guardarformato").click(function (e) {
    e.preventDefault();


    formularioValido = validarFormulario3($('#formularioformato'))

    if (formularioValido) {

    if (ID_FORMATO == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarformato')
            await ajaxAwaitFormData({ api: 4, ID_FORMATO: ID_FORMATO }, 'CatcapacitacionSave', 'formularioformato', 'guardarformato', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                    ID_FORMATO = data.capacitaciones.ID_FORMATO
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_formato').modal('hide')
                    document.getElementById('formularioformato').reset();
                    Tablacapformato.ajax.reload()
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarformato')
            await ajaxAwaitFormData({ api: 4, ID_FORMATO: ID_FORMATO }, 'CatcapacitacionSave', 'formularioformato', 'guardarformato', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    ID_FORMATO = data.capacitaciones.ID_FORMATO
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_formato').modal('hide')
                    document.getElementById('formularioformato').reset();
                    Tablacapformato.ajax.reload()

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});



var Tablacapformato = $("#Tablacapformato").DataTable({
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
        url: '/Tablacapformato',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablacapformato.columns.adjust().draw();
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
        { data: 'NOMBRE_FORMATO' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Nombre del formato', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Editar', className: 'all text-center' },
        { targets: 3, title: 'Visualizar', className: 'all text-center' },
        { targets: 4, title: 'Activo', className: 'all text-center' }
    ]
});





$('#Tablacapformato tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacapformato.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 4,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_FORMATO: row.data().ID_FORMATO
    };

    eliminarDatoTabla(data, [Tablacapformato], 'CatcapacitacionDelete');
});



$('#Tablacapformato tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacapformato.row(tr);


    ID_FORMATO = row.data().ID_FORMATO;

    editarDatoTabla(row.data(), 'formularioformato', 'miModal_formato');

    $('#miModal_formato .modal-title').html(row.data().NOMBRE_FORMATO);

});



$(document).ready(function() {
    $('#Tablacapformato tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablacapformato.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_formato');

        ID_FORMATO = row.data().ID_FORMATO;
        editarDatoTabla(row.data(), 'formularioformato', 'miModal_formato');
         $('#miModal_formato .modal-title').html(row.data().NOMBRE_FORMATO);

    });

    $('#miModal_formato').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_formato');
    });
});

