//VARIABLES
ID_MATERIAL_DIDACTICO = 0




const ModalArea = document.getElementById('miModal_materialdidactico')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    ID_MATERIAL_DIDACTICO = 0
    document.getElementById('formulariomaterialdidactico').reset();
   
    $('#miModal_materialdidactico .modal-title').html('Nuevo material didáctico');


})






$("#guardarmaterialdidactico").click(function (e) {
    e.preventDefault();


    formularioValido = validarFormulario3($('#formulariomaterialdidactico'))

    if (formularioValido) {

    if (ID_MATERIAL_DIDACTICO == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarmaterialdidactico')
            await ajaxAwaitFormData({ api: 14, ID_MATERIAL_DIDACTICO: ID_MATERIAL_DIDACTICO }, 'CatcapacitacionSave', 'formulariomaterialdidactico', 'guardarmaterialdidactico', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                    ID_MATERIAL_DIDACTICO = data.capacitaciones.ID_MATERIAL_DIDACTICO
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_materialdidactico').modal('hide')
                    document.getElementById('formulariomaterialdidactico').reset();
                    Tablacapmaterialdidactico.ajax.reload()
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarmaterialdidactico')
            await ajaxAwaitFormData({ api: 14, ID_MATERIAL_DIDACTICO: ID_MATERIAL_DIDACTICO }, 'CatcapacitacionSave', 'formulariomaterialdidactico', 'guardarmaterialdidactico', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    ID_MATERIAL_DIDACTICO = data.capacitaciones.ID_MATERIAL_DIDACTICO
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_materialdidactico').modal('hide')
                    document.getElementById('formulariomaterialdidactico').reset();
                    Tablacapmaterialdidactico.ajax.reload()

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});



var Tablacapmaterialdidactico = $("#Tablacapmaterialdidactico").DataTable({
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
        url: '/Tablacapmaterialdidactico',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablacapmaterialdidactico.columns.adjust().draw();
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
        { data: 'MATERIAL_DIDACTICO' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Material didáctico', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Editar', className: 'all text-center' },
        { targets: 3, title: 'Visualizar', className: 'all text-center' },
        { targets: 4, title: 'Activo', className: 'all text-center' }
    ]
});





$('#Tablacapmaterialdidactico tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacapmaterialdidactico.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 14,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_MATERIAL_DIDACTICO: row.data().ID_MATERIAL_DIDACTICO
    };

    eliminarDatoTabla(data, [Tablacapmaterialdidactico], 'CatcapacitacionDelete');
});



$('#Tablacapmaterialdidactico tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacapmaterialdidactico.row(tr);


    ID_MATERIAL_DIDACTICO = row.data().ID_MATERIAL_DIDACTICO;

    editarDatoTabla(row.data(), 'formulariomaterialdidactico', 'miModal_materialdidactico');

    $('#miModal_materialdidactico .modal-title').html(row.data().MATERIAL_DIDACTICO);

});



$(document).ready(function() {
    $('#Tablacapmaterialdidactico tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablacapmaterialdidactico.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_materialdidactico');

        ID_MATERIAL_DIDACTICO = row.data().ID_MATERIAL_DIDACTICO;
        editarDatoTabla(row.data(), 'formulariomaterialdidactico', 'miModal_materialdidactico');
         $('#miModal_materialdidactico .modal-title').html(row.data().MATERIAL_DIDACTICO);

    });

    $('#miModal_materialdidactico').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_materialdidactico');
    });
});

