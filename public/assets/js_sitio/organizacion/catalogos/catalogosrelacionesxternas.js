//VARIABLES
ID_CATALOGO_RELACIONESEXTERNAS = 0
Tablarelacionesexterna = null




const ModalArea = document.getElementById('miModal_RELACIONESEXTERNAS')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    
    ID_CATALOGO_RELACIONESEXTERNAS = 0
    document.getElementById('formularioRELACIONESEXTERNAS').reset();
   
    $('#miModal_RELACIONESEXTERNAS .modal-title').html('Nueva relación externa');

    

})






$("#guardarFormRELACIONESEXTERNAS").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioRELACIONESEXTERNAS'))

    if (formularioValido) {

    if (ID_CATALOGO_RELACIONESEXTERNAS == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormRELACIONESEXTERNAS')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_RELACIONESEXTERNAS: ID_CATALOGO_RELACIONESEXTERNAS }, 'ExternaSave', 'formularioRELACIONESEXTERNAS', 'guardarFormRELACIONESEXTERNAS', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_CATALOGO_RELACIONESEXTERNAS = data.externa.ID_CATALOGO_RELACIONESEXTERNAS
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_RELACIONESEXTERNAS').modal('hide')
                    document.getElementById('formularioRELACIONESEXTERNAS').reset();
                    Tablarelacionesexterna.ajax.reload()

           
                
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormRELACIONESEXTERNAS')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_RELACIONESEXTERNAS: ID_CATALOGO_RELACIONESEXTERNAS }, 'ExternaSave', 'formularioRELACIONESEXTERNAS', 'guardarFormRELACIONESEXTERNAS', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_CATALOGO_RELACIONESEXTERNAS = data.externa.ID_CATALOGO_RELACIONESEXTERNAS
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_RELACIONESEXTERNAS').modal('hide')
                    document.getElementById('formularioRELACIONESEXTERNAS').reset();
                    Tablarelacionesexterna.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});


var Tablarelacionesexterna = $("#Tablarelacionesexterna").DataTable({
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
        url: '/Tablarelacionesexterna',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablarelacionesexterna.columns.adjust().draw();
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
        { data: 'NOMBRE_RELACIONEXTERNA' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Nombre', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Editar', className: 'all text-center' },
        { targets: 3, title: 'Visualizar', className: 'all text-center' },
        { targets: 4, title: 'Activo', className: 'all text-center' }
    ]
});





$('#Tablarelacionesexterna tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablarelacionesexterna.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_CATALOGO_RELACIONESEXTERNAS: row.data().ID_CATALOGO_RELACIONESEXTERNAS
    };

    eliminarDatoTabla(data, [Tablarelacionesexterna], 'ExternaDelete');
});



$('#Tablarelacionesexterna tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablarelacionesexterna.row(tr);
    ID_CATALOGO_RELACIONESEXTERNAS = row.data().ID_CATALOGO_RELACIONESEXTERNAS;


    editarDatoTabla(row.data(), 'formularioRELACIONESEXTERNAS', 'miModal_RELACIONESEXTERNAS');
    $('#miModal_RELACIONESEXTERNAS .modal-title').html(row.data().NOMBRE_RELACIONEXTERNA);


});

$(document).ready(function() {
    $('#Tablarelacionesexterna tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablarelacionesexterna.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_RELACIONESEXTERNAS');

        ID_CATALOGO_RELACIONESEXTERNAS = row.data().ID_CATALOGO_RELACIONESEXTERNAS;
        editarDatoTabla(row.data(), 'formularioRELACIONESEXTERNAS', 'miModal_RELACIONESEXTERNAS',1);
    $('#miModal_RELACIONESEXTERNAS .modal-title').html(row.data().NOMBRE_RELACIONEXTERNA);


    });

    $('#miModal_RELACIONESEXTERNAS').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_RELACIONESEXTERNAS');
    });
});




