//VARIABLES
ID_TIPO_PROVEEDOR = 0




const ModalArea = document.getElementById('miModal_tipoproveedor')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    ID_TIPO_PROVEEDOR = 0
    document.getElementById('formulariotipoproveedor').reset();
   
    $('#miModal_tipoproveedor .modal-title').html('Nuevo tipo de proveedor');


})






$("#guardartipoproveedor").click(function (e) {
    e.preventDefault();


    formularioValido = validarFormulario3($('#formulariotipoproveedor'))

    if (formularioValido) {

    if (ID_TIPO_PROVEEDOR == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardartipoproveedor')
            await ajaxAwaitFormData({ api: 10, ID_TIPO_PROVEEDOR: ID_TIPO_PROVEEDOR }, 'CatcapacitacionSave', 'formulariotipoproveedor', 'guardartipoproveedor', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                    ID_TIPO_PROVEEDOR = data.capacitaciones.ID_TIPO_PROVEEDOR
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_tipoproveedor').modal('hide')
                    document.getElementById('formulariotipoproveedor').reset();
                    Tablacaptipoproveedor.ajax.reload()
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardartipoproveedor')
            await ajaxAwaitFormData({ api: 10, ID_TIPO_PROVEEDOR: ID_TIPO_PROVEEDOR }, 'CatcapacitacionSave', 'formulariotipoproveedor', 'guardartipoproveedor', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    ID_TIPO_PROVEEDOR = data.capacitaciones.ID_TIPO_PROVEEDOR
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_tipoproveedor').modal('hide')
                    document.getElementById('formulariotipoproveedor').reset();
                    Tablacaptipoproveedor.ajax.reload()

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});



var Tablacaptipoproveedor = $("#Tablacaptipoproveedor").DataTable({
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
        url: '/Tablacaptipoproveedor',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablacaptipoproveedor.columns.adjust().draw();
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
        { data: 'TIPO_PROVEEDOR' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Tipo de proveedor', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Editar', className: 'all text-center' },
        { targets: 3, title: 'Visualizar', className: 'all text-center' },
        { targets: 4, title: 'Activo', className: 'all text-center' }
    ]
});





$('#Tablacaptipoproveedor tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacaptipoproveedor.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 10,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_TIPO_PROVEEDOR: row.data().ID_TIPO_PROVEEDOR
    };

    eliminarDatoTabla(data, [Tablacaptipoproveedor], 'CatcapacitacionDelete');
});



$('#Tablacaptipoproveedor tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacaptipoproveedor.row(tr);


    ID_TIPO_PROVEEDOR = row.data().ID_TIPO_PROVEEDOR;

    editarDatoTabla(row.data(), 'formulariotipoproveedor', 'miModal_tipoproveedor');

    $('#miModal_tipoproveedor .modal-title').html(row.data().TIPO_PROVEEDOR);

});



$(document).ready(function() {
    $('#Tablacaptipoproveedor tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablacaptipoproveedor.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_tipoproveedor');

        ID_TIPO_PROVEEDOR = row.data().ID_TIPO_PROVEEDOR;
        editarDatoTabla(row.data(), 'formulariotipoproveedor', 'miModal_tipoproveedor');
         $('#miModal_tipoproveedor .modal-title').html(row.data().TIPO_PROVEEDOR);

    });

    $('#miModal_tipoproveedor').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_tipoproveedor');
    });
});

