//VARIABLES
ID_MODALIDAD = 0




const ModalArea = document.getElementById('miModal_modalidad')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    ID_MODALIDAD = 0
    document.getElementById('formulariomodalidad').reset();
   
    $('#miModal_modalidad .modal-title').html('Nueva modalidad');


})






$("#guardarmodalidad").click(function (e) {
    e.preventDefault();


    formularioValido = validarFormulario3($('#formulariomodalidad'))

    if (formularioValido) {

    if (ID_MODALIDAD == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarmodalidad')
            await ajaxAwaitFormData({ api: 3, ID_MODALIDAD: ID_MODALIDAD }, 'CatcapacitacionSave', 'formulariomodalidad', 'guardarmodalidad', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                    ID_MODALIDAD = data.capacitaciones.ID_MODALIDAD
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_modalidad').modal('hide')
                    document.getElementById('formulariomodalidad').reset();
                    Tablacapmodalidad.ajax.reload()
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarmodalidad')
            await ajaxAwaitFormData({ api: 3, ID_MODALIDAD: ID_MODALIDAD }, 'CatcapacitacionSave', 'formulariomodalidad', 'guardarmodalidad', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    ID_MODALIDAD = data.capacitaciones.ID_MODALIDAD
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_modalidad').modal('hide')
                    document.getElementById('formulariomodalidad').reset();
                    Tablacapmodalidad.ajax.reload()

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});



var Tablacapmodalidad = $("#Tablacapmodalidad").DataTable({
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
        url: '/Tablacapmodalidad',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablacapmodalidad.columns.adjust().draw();
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
        { data: 'NOMBRE_MODALIDAD' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Nombre de la modalidad', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Editar', className: 'all text-center' },
        { targets: 3, title: 'Visualizar', className: 'all text-center' },
        { targets: 4, title: 'Activo', className: 'all text-center' }
    ]
});





$('#Tablacapmodalidad tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacapmodalidad.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 3,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_MODALIDAD: row.data().ID_MODALIDAD
    };

    eliminarDatoTabla(data, [Tablacapmodalidad], 'CatcapacitacionDelete');
});



$('#Tablacapmodalidad tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacapmodalidad.row(tr);


    ID_MODALIDAD = row.data().ID_MODALIDAD;

    editarDatoTabla(row.data(), 'formulariomodalidad', 'miModal_modalidad');

    $('#miModal_modalidad .modal-title').html(row.data().NOMBRE_MODALIDAD);

});



$(document).ready(function() {
    $('#Tablacapmodalidad tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablacapmodalidad.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_modalidad');

        ID_MODALIDAD = row.data().ID_MODALIDAD;
        editarDatoTabla(row.data(), 'formulariomodalidad', 'miModal_modalidad');
         $('#miModal_modalidad .modal-title').html(row.data().NOMBRE_MODALIDAD);

    });

    $('#miModal_modalidad').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_modalidad');
    });
});

