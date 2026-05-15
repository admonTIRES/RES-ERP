//VARIABLES
ID_DOCUMENTOS_EMITIDOS = 0




const ModalArea = document.getElementById('miModal_emitidos')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    ID_DOCUMENTOS_EMITIDOS = 0
    document.getElementById('formularioemitido').reset();
   
    $('#miModal_emitidos .modal-title').html('Nuevo documento emitido');


})






$("#guardaremitido").click(function (e) {
    e.preventDefault();


    formularioValido = validarFormulario3($('#formularioemitido'))

    if (formularioValido) {

    if (ID_DOCUMENTOS_EMITIDOS == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardaremitido')
            await ajaxAwaitFormData({ api: 16, ID_DOCUMENTOS_EMITIDOS: ID_DOCUMENTOS_EMITIDOS }, 'CatcapacitacionSave', 'formularioemitido', 'guardaremitido', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                    ID_DOCUMENTOS_EMITIDOS = data.capacitaciones.ID_DOCUMENTOS_EMITIDOS
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_emitidos').modal('hide')
                    document.getElementById('formularioemitido').reset();
                    Tablacapemitidos.ajax.reload()
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardaremitido')
            await ajaxAwaitFormData({ api: 16, ID_DOCUMENTOS_EMITIDOS: ID_DOCUMENTOS_EMITIDOS }, 'CatcapacitacionSave', 'formularioemitido', 'guardaremitido', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    ID_DOCUMENTOS_EMITIDOS = data.capacitaciones.ID_DOCUMENTOS_EMITIDOS
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_emitidos').modal('hide')
                    document.getElementById('formularioemitido').reset();
                    Tablacapemitidos.ajax.reload()

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});



var Tablacapemitidos = $("#Tablacapemitidos").DataTable({
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
        url: '/Tablacapemitidos',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablacapemitidos.columns.adjust().draw();
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
        { data: 'NOMBRE_DOCUMENTO' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Documento emitido', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Editar', className: 'all text-center' },
        { targets: 3, title: 'Visualizar', className: 'all text-center' },
        { targets: 4, title: 'Activo', className: 'all text-center' }
    ]
});





$('#Tablacapemitidos tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacapemitidos.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 16,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_DOCUMENTOS_EMITIDOS: row.data().ID_DOCUMENTOS_EMITIDOS
    };

    eliminarDatoTabla(data, [Tablacapemitidos], 'CatcapacitacionDelete');
});



$('#Tablacapemitidos tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacapemitidos.row(tr);


    ID_DOCUMENTOS_EMITIDOS = row.data().ID_DOCUMENTOS_EMITIDOS;

    editarDatoTabla(row.data(), 'formularioemitido', 'miModal_emitidos');

    $('#miModal_emitidos .modal-title').html(row.data().NOMBRE_DOCUMENTO);

});



$(document).ready(function() {
    $('#Tablacapemitidos tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablacapemitidos.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_emitidos');

        ID_DOCUMENTOS_EMITIDOS = row.data().ID_DOCUMENTOS_EMITIDOS;
        editarDatoTabla(row.data(), 'formularioemitido', 'miModal_emitidos');
         $('#miModal_emitidos .modal-title').html(row.data().NOMBRE_DOCUMENTO);

    });

    $('#miModal_emitidos').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_emitidos');
    });
});

