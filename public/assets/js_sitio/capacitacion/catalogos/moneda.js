//VARIABLES
ID_MONEDA = 0




const ModalArea = document.getElementById('miModal_moneda')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    ID_MONEDA = 0
    document.getElementById('formulariomoneda').reset();
   
    $('#miModal_moneda .modal-title').html('Nueva moneda');


})






$("#guardarmoneda").click(function (e) {
    e.preventDefault();


    formularioValido = validarFormulario3($('#formulariomoneda'))

    if (formularioValido) {

    if (ID_MONEDA == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarmoneda')
            await ajaxAwaitFormData({ api: 17, ID_MONEDA: ID_MONEDA }, 'CatcapacitacionSave', 'formulariomoneda', 'guardarmoneda', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                    ID_MONEDA = data.capacitaciones.ID_MONEDA
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_moneda').modal('hide')
                    document.getElementById('formulariomoneda').reset();
                    Tablacapmoneda.ajax.reload()
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarmoneda')
            await ajaxAwaitFormData({ api: 17, ID_MONEDA: ID_MONEDA }, 'CatcapacitacionSave', 'formulariomoneda', 'guardarmoneda', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    ID_MONEDA = data.capacitaciones.ID_MONEDA
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_moneda').modal('hide')
                    document.getElementById('formulariomoneda').reset();
                    Tablacapmoneda.ajax.reload()

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});



var Tablacapmoneda = $("#Tablacapmoneda").DataTable({
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
        url: '/Tablacapmoneda',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablacapmoneda.columns.adjust().draw();
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
        { data: 'TIPO_MONEDA' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Moneda', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Editar', className: 'all text-center' },
        { targets: 3, title: 'Visualizar', className: 'all text-center' },
        { targets: 4, title: 'Activo', className: 'all text-center' }
    ]
});





$('#Tablacapmoneda tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacapmoneda.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 17,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_MONEDA: row.data().ID_MONEDA
    };

    eliminarDatoTabla(data, [Tablacapmoneda], 'CatcapacitacionDelete');
});



$('#Tablacapmoneda tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacapmoneda.row(tr);


    ID_MONEDA = row.data().ID_MONEDA;

    editarDatoTabla(row.data(), 'formulariomoneda', 'miModal_moneda');

    $('#miModal_moneda .modal-title').html(row.data().TIPO_MONEDA);

});



$(document).ready(function() {
    $('#Tablacapmoneda tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablacapmoneda.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_moneda');

        ID_MONEDA = row.data().ID_MONEDA;
        editarDatoTabla(row.data(), 'formulariomoneda', 'miModal_moneda');
         $('#miModal_moneda .modal-title').html(row.data().TIPO_MONEDA);

    });

    $('#miModal_moneda').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_moneda');
    });
});

