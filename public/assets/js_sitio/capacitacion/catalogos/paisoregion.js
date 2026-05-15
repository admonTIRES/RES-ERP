//VARIABLES
ID_PAIS_REGION = 0




const ModalArea = document.getElementById('miModal_paisregion')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    ID_PAIS_REGION = 0
    document.getElementById('formulariopaisoregion').reset();
   
    $('#miModal_paisregion .modal-title').html('Nuevo país o región');


})






$("#guardarpaisoregion").click(function (e) {
    e.preventDefault();


    formularioValido = validarFormulario3($('#formulariopaisoregion'))

    if (formularioValido) {

    if (ID_PAIS_REGION == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarpaisoregion')
            await ajaxAwaitFormData({ api: 5, ID_PAIS_REGION: ID_PAIS_REGION }, 'CatcapacitacionSave', 'formulariopaisoregion', 'guardarpaisoregion', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                    ID_PAIS_REGION = data.capacitaciones.ID_PAIS_REGION
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_paisregion').modal('hide')
                    document.getElementById('formulariopaisoregion').reset();
                    Tablacappaisoregion.ajax.reload()
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarpaisoregion')
            await ajaxAwaitFormData({ api: 5, ID_PAIS_REGION: ID_PAIS_REGION }, 'CatcapacitacionSave', 'formulariopaisoregion', 'guardarpaisoregion', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    ID_PAIS_REGION = data.capacitaciones.ID_PAIS_REGION
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_paisregion').modal('hide')
                    document.getElementById('formulariopaisoregion').reset();
                    Tablacappaisoregion.ajax.reload()

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});



var Tablacappaisoregion = $("#Tablacappaisoregion").DataTable({
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
        url: '/Tablacappaisoregion',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablacappaisoregion.columns.adjust().draw();
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
        { data: 'NOMBRE_PAIS_REGION' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'País o región', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Editar', className: 'all text-center' },
        { targets: 3, title: 'Visualizar', className: 'all text-center' },
        { targets: 4, title: 'Activo', className: 'all text-center' }
    ]
});





$('#Tablacappaisoregion tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacappaisoregion.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 5,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_PAIS_REGION: row.data().ID_PAIS_REGION
    };

    eliminarDatoTabla(data, [Tablacappaisoregion], 'CatcapacitacionDelete');
});



$('#Tablacappaisoregion tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacappaisoregion.row(tr);


    ID_PAIS_REGION = row.data().ID_PAIS_REGION;

    editarDatoTabla(row.data(), 'formulariopaisoregion', 'miModal_paisregion');

    $('#miModal_paisregion .modal-title').html(row.data().NOMBRE_PAIS_REGION);

});



$(document).ready(function() {
    $('#Tablacappaisoregion tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablacappaisoregion.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_paisregion');

        ID_PAIS_REGION = row.data().ID_PAIS_REGION;
        editarDatoTabla(row.data(), 'formulariopaisoregion', 'miModal_paisregion');
         $('#miModal_paisregion .modal-title').html(row.data().NOMBRE_PAIS_REGION);

    });

    $('#miModal_paisregion').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_paisregion');
    });
});

