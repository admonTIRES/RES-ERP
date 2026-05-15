//VARIABLES
ID_AREA_CONOCIMIENTO = 0




const ModalArea = document.getElementById('miModal_areaconomiento')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    ID_AREA_CONOCIMIENTO = 0
    document.getElementById('formularioareaconocimiento').reset();
   
    $('#miModal_areaconomiento .modal-title').html('Nueva área de conocimiento');


})






$("#guardarareaconocimiento").click(function (e) {
    e.preventDefault();


    formularioValido = validarFormulario3($('#formularioareaconocimiento'))

    if (formularioValido) {

    if (ID_AREA_CONOCIMIENTO == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarareaconocimiento')
            await ajaxAwaitFormData({ api: 2, ID_AREA_CONOCIMIENTO: ID_AREA_CONOCIMIENTO }, 'CatcapacitacionSave', 'formularioareaconocimiento', 'guardarareaconocimiento', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                    ID_AREA_CONOCIMIENTO = data.capacitaciones.ID_AREA_CONOCIMIENTO
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_areaconomiento').modal('hide')
                    document.getElementById('formularioareaconocimiento').reset();
                    Tablacapareaconocimiento.ajax.reload()
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarareaconocimiento')
            await ajaxAwaitFormData({ api: 2, ID_AREA_CONOCIMIENTO: ID_AREA_CONOCIMIENTO }, 'CatcapacitacionSave', 'formularioareaconocimiento', 'guardarareaconocimiento', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    ID_AREA_CONOCIMIENTO = data.capacitaciones.ID_AREA_CONOCIMIENTO
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_areaconomiento').modal('hide')
                    document.getElementById('formularioareaconocimiento').reset();
                    Tablacapareaconocimiento.ajax.reload()

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});



var Tablacapareaconocimiento = $("#Tablacapareaconocimiento").DataTable({
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
        url: '/Tablacapareaconocimiento',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablacapareaconocimiento.columns.adjust().draw();
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
        { data: 'NOMBRE_AREA_CONOCIMIENTO' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Nombre del área', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Editar', className: 'all text-center' },
        { targets: 3, title: 'Visualizar', className: 'all text-center' },
        { targets: 4, title: 'Activo', className: 'all text-center' }
    ]
});





$('#Tablacapareaconocimiento tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacapareaconocimiento.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 2,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_AREA_CONOCIMIENTO: row.data().ID_AREA_CONOCIMIENTO
    };

    eliminarDatoTabla(data, [Tablacapareaconocimiento], 'CatcapacitacionDelete');
});



$('#Tablacapareaconocimiento tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacapareaconocimiento.row(tr);


    ID_AREA_CONOCIMIENTO = row.data().ID_AREA_CONOCIMIENTO;

    editarDatoTabla(row.data(), 'formularioareaconocimiento', 'miModal_areaconomiento');

    $('#miModal_areaconomiento .modal-title').html(row.data().NOMBRE_AREA_CONOCIMIENTO);

});



$(document).ready(function() {
    $('#Tablacapareaconocimiento tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablacapareaconocimiento.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_areaconomiento');

        ID_AREA_CONOCIMIENTO = row.data().ID_AREA_CONOCIMIENTO;
        editarDatoTabla(row.data(), 'formularioareaconocimiento', 'miModal_areaconomiento');
         $('#miModal_areaconomiento .modal-title').html(row.data().NOMBRE_AREA_CONOCIMIENTO);

    });

    $('#miModal_areaconomiento').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_areaconomiento');
    });
});

