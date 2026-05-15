//VARIABLES
ID_RECONOCIMIENTO = 0




const ModalArea = document.getElementById('miModal_reconocimiento')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    ID_RECONOCIMIENTO = 0
    document.getElementById('formularioreconocimiento').reset();
   
    $('#miModal_reconocimiento .modal-title').html('Nuevo reconocimiento');


})






$("#guardarreconocimiento").click(function (e) {
    e.preventDefault();


    formularioValido = validarFormulario3($('#formularioreconocimiento'))

    if (formularioValido) {

    if (ID_RECONOCIMIENTO == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarreconocimiento')
            await ajaxAwaitFormData({ api: 8, ID_RECONOCIMIENTO: ID_RECONOCIMIENTO }, 'CatcapacitacionSave', 'formularioreconocimiento', 'guardarreconocimiento', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                    ID_RECONOCIMIENTO = data.capacitaciones.ID_RECONOCIMIENTO
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_reconocimiento').modal('hide')
                    document.getElementById('formularioreconocimiento').reset();
                    Tablacapreconocimiento.ajax.reload()
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarreconocimiento')
            await ajaxAwaitFormData({ api: 8, ID_RECONOCIMIENTO: ID_RECONOCIMIENTO }, 'CatcapacitacionSave', 'formularioreconocimiento', 'guardarreconocimiento', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    ID_RECONOCIMIENTO = data.capacitaciones.ID_RECONOCIMIENTO
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_reconocimiento').modal('hide')
                    document.getElementById('formularioreconocimiento').reset();
                    Tablacapreconocimiento.ajax.reload()

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});



var Tablacapreconocimiento = $("#Tablacapreconocimiento").DataTable({
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
        url: '/Tablacapreconocimiento',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablacapreconocimiento.columns.adjust().draw();
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
        { data: 'NOMBRE_RECONOCIMIENTO' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Nombre del reconocimiento', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Editar', className: 'all text-center' },
        { targets: 3, title: 'Visualizar', className: 'all text-center' },
        { targets: 4, title: 'Activo', className: 'all text-center' }
    ]
});





$('#Tablacapreconocimiento tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacapreconocimiento.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 8,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_RECONOCIMIENTO: row.data().ID_RECONOCIMIENTO
    };

    eliminarDatoTabla(data, [Tablacapreconocimiento], 'CatcapacitacionDelete');
});



$('#Tablacapreconocimiento tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacapreconocimiento.row(tr);


    ID_RECONOCIMIENTO = row.data().ID_RECONOCIMIENTO;

    editarDatoTabla(row.data(), 'formularioreconocimiento', 'miModal_reconocimiento');

    $('#miModal_reconocimiento .modal-title').html(row.data().NOMBRE_RECONOCIMIENTO);

});



$(document).ready(function() {
    $('#Tablacapreconocimiento tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablacapreconocimiento.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_reconocimiento');

        ID_RECONOCIMIENTO = row.data().ID_RECONOCIMIENTO;
        editarDatoTabla(row.data(), 'formularioreconocimiento', 'miModal_reconocimiento');
         $('#miModal_reconocimiento .modal-title').html(row.data().NOMBRE_RECONOCIMIENTO);

    });

    $('#miModal_reconocimiento').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_reconocimiento');
    });
});

