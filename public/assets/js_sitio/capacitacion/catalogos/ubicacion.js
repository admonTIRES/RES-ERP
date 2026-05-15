//VARIABLES
ID_UBICACION = 0




const ModalArea = document.getElementById('miModal_ubicacion')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    ID_UBICACION = 0
    document.getElementById('formularioubicacion').reset();
   
    $('#miModal_ubicacion .modal-title').html('Nueva ubicación');


})






$("#guardarubicacion").click(function (e) {
    e.preventDefault();


    formularioValido = validarFormulario3($('#formularioubicacion'))

    if (formularioValido) {

    if (ID_UBICACION == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarubicacion')
            await ajaxAwaitFormData({ api: 13, ID_UBICACION: ID_UBICACION }, 'CatcapacitacionSave', 'formularioubicacion', 'guardarubicacion', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                    ID_UBICACION = data.capacitaciones.ID_UBICACION
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_ubicacion').modal('hide')
                    document.getElementById('formularioubicacion').reset();
                    Tablacapubicacion.ajax.reload()
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarubicacion')
            await ajaxAwaitFormData({ api: 13, ID_UBICACION: ID_UBICACION }, 'CatcapacitacionSave', 'formularioubicacion', 'guardarubicacion', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    ID_UBICACION = data.capacitaciones.ID_UBICACION
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_ubicacion').modal('hide')
                    document.getElementById('formularioubicacion').reset();
                    Tablacapubicacion.ajax.reload()

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});



var Tablacapubicacion = $("#Tablacapubicacion").DataTable({
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
        url: '/Tablacapubicacion',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablacapubicacion.columns.adjust().draw();
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
        { data: 'NOMBRE_UBICACION' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Nombre de la ubicación', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Editar', className: 'all text-center' },
        { targets: 3, title: 'Visualizar', className: 'all text-center' },
        { targets: 4, title: 'Activo', className: 'all text-center' }
    ]
});





$('#Tablacapubicacion tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacapubicacion.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 13,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_UBICACION: row.data().ID_UBICACION
    };

    eliminarDatoTabla(data, [Tablacapubicacion], 'CatcapacitacionDelete');
});



$('#Tablacapubicacion tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacapubicacion.row(tr);


    ID_UBICACION = row.data().ID_UBICACION;

    editarDatoTabla(row.data(), 'formularioubicacion', 'miModal_ubicacion');

    $('#miModal_ubicacion .modal-title').html(row.data().NOMBRE_UBICACION);

});



$(document).ready(function() {
    $('#Tablacapubicacion tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablacapubicacion.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_ubicacion');

        ID_UBICACION = row.data().ID_UBICACION;
        editarDatoTabla(row.data(), 'formularioubicacion', 'miModal_ubicacion');
         $('#miModal_ubicacion .modal-title').html(row.data().NOMBRE_UBICACION);

    });

    $('#miModal_ubicacion').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_ubicacion');
    });
});

