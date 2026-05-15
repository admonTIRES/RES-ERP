//VARIABLES
ID_CATALOGO_TIPOINVENTARIO = 0




const ModalArea = document.getElementById('miModal_TIPO')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    
    ID_CATALOGO_TIPOINVENTARIO = 0
    document.getElementById('formularioTIPO').reset();
   

    $('#miModal_TIPO .modal-title').html('Nuevo tipo');



})






$("#guardarFormTIPO").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioTIPO'))

    if (formularioValido) {

    if (ID_CATALOGO_TIPOINVENTARIO == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormTIPO')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_TIPOINVENTARIO: ID_CATALOGO_TIPOINVENTARIO }, 'TipoinventarioSave', 'formularioTIPO', 'guardarFormTIPO', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                    ID_CATALOGO_TIPOINVENTARIO = data.tipo.ID_CATALOGO_TIPOINVENTARIO
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_TIPO').modal('hide')
                    document.getElementById('formularioTIPO').reset();
                    Tablatipoinventario.ajax.reload()

           
                
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormTIPO')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_TIPOINVENTARIO: ID_CATALOGO_TIPOINVENTARIO }, 'TipoinventarioSave', 'formularioTIPO', 'guardarFormTIPO', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_CATALOGO_TIPOINVENTARIO = data.tipo.ID_CATALOGO_TIPOINVENTARIO
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                    $('#miModal_TIPO').modal('hide')
                    document.getElementById('formularioTIPO').reset();
                    Tablatipoinventario.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});


var Tablatipoinventario = $("#Tablatipoinventario").DataTable({
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
        url: '/Tablatipoinventario',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablatipoinventario.columns.adjust().draw();
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
        { data: 'DESCRIPCION_TIPO' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [ 
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Descripción', className: 'all text-center' },
        { targets: 2, title: 'Editar', className: 'all text-center' },
        { targets: 3, title: 'Visualizar', className: 'all text-center' },
        { targets: 4, title: 'Activo', className: 'all text-center' }
    ]
});


$('#Tablatipoinventario tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablatipoinventario.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_CATALOGO_TIPOINVENTARIO: row.data().ID_CATALOGO_TIPOINVENTARIO
    };

    eliminarDatoTabla(data, [Tablatipoinventario], 'TipoinventarioDelete');
});



$('#Tablatipoinventario tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablatipoinventario.row(tr);
    ID_CATALOGO_TIPOINVENTARIO = row.data().ID_CATALOGO_TIPOINVENTARIO;

    editarDatoTabla(row.data(), 'formularioTIPO', 'miModal_TIPO');

    $('#miModal_TIPO .modal-title').html(row.data().DESCRIPCION_TIPO);

});





$(document).ready(function() {
    $('#Tablatipoinventario tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablatipoinventario.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_TIPO');

        ID_CATALOGO_TIPOINVENTARIO = row.data().ID_CATALOGO_TIPOINVENTARIO;
        editarDatoTabla(row.data(), 'formularioTIPO', 'miModal_TIPO',1);

    $('#miModal_TIPO .modal-title').html(row.data().DESCRIPCION_TIPO);

    });

    $('#miModal_TIPO').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_TIPO');
    });
});

