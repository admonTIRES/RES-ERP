
//VARIABLES GLOBALES
var ID_CATALOGO_PRUEBA_CONOCIMIENTO = 0


Tablapruebaconocimiento = null




const ModalPrueba = document.getElementById('miModal_PRUEBA');

ModalPrueba.addEventListener('hidden.bs.modal', event => {
    ID_CATALOGO_PRUEBA_CONOCIMIENTO = 0;
    document.getElementById('formularioPRUEBA').reset();   

    $('#miModal_PRUEBA .modal-title').html('Nueva prueba de conocimiento');

});

  





$("#guardarFormPRUEBA").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioPRUEBA'))

    if (formularioValido) {

    if (ID_CATALOGO_PRUEBA_CONOCIMIENTO == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormPRUEBA')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_PRUEBA_CONOCIMIENTO: ID_CATALOGO_PRUEBA_CONOCIMIENTO }, 'pruebaSave', 'formularioPRUEBA', 'guardarFormPRUEBA', { callbackAfter: true, callbackBefore: true }, () => {

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    ID_CATALOGO_PRUEBA_CONOCIMIENTO = data.prueba.ID_CATALOGO_PRUEBA_CONOCIMIENTO
                    alertMensaje('success','Información guardada correctamente',null)
                     $('#miModal_PRUEBA').modal('hide')
                    document.getElementById('formularioPRUEBA').reset();
                    Tablapruebaconocimiento.ajax.reload()

                }, 300);
                
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se editara la información",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormPRUEBA')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_PRUEBA_CONOCIMIENTO: ID_CATALOGO_PRUEBA_CONOCIMIENTO }, 'pruebaSave', 'formularioPRUEBA', 'guardarFormPRUEBA', { callbackAfter: true, callbackBefore: true }, () => {

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_CATALOGO_PRUEBA_CONOCIMIENTO = data.prueba.ID_CATALOGO_PRUEBA_CONOCIMIENTO
                    alertMensaje('success','Información guardada correctamente',null )
                     $('#miModal_PRUEBA').modal('hide')
                    document.getElementById('formularioPRUEBA').reset();
                    Tablapruebaconocimiento.ajax.reload()


                }, 300);  
            })
        }, 1)
    }
} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});



var Tablapruebaconocimiento = $("#Tablapruebaconocimiento").DataTable({
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
        url: '/Tablapruebaconocimiento',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablapruebaconocimiento.columns.adjust().draw();
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
        { data: 'NOMBRE_PRUEBA' },
        { 
            data: 'DESCRIPCION_PRUEBA',
            render: function(data, type, row) {
                return data && data.trim() !== '' ? data : 'NA';
            }
        },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Nombre', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Descripción', className: 'all text-center descripcion-column' },
        { targets: 3, title: 'Editar', className: 'all text-center' },
        { targets: 4, title: 'Visualizar', className: 'all text-center' },
        { targets: 5, title: 'Activo', className: 'all text-center' }
    ]
});




$('#Tablapruebaconocimiento tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablapruebaconocimiento.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_CATALOGO_PRUEBA_CONOCIMIENTO: row.data().ID_CATALOGO_PRUEBA_CONOCIMIENTO
    };

    eliminarDatoTabla(data, [Tablapruebaconocimiento], 'pruebaDelete');
});





$('#Tablapruebaconocimiento tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablapruebaconocimiento.row(tr);
    ID_CATALOGO_PRUEBA_CONOCIMIENTO = row.data().ID_CATALOGO_PRUEBA_CONOCIMIENTO;


    editarDatoTabla(row.data(), 'formularioPRUEBA', 'miModal_PRUEBA');

    $('#miModal_PRUEBA .modal-title').html(row.data().NOMBRE_PRUEBA);

});




$(document).ready(function() {

    $('#Tablapruebaconocimiento tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablapruebaconocimiento.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_PRUEBA');

        ID_CATALOGO_PRUEBA_CONOCIMIENTO = row.data().ID_CATALOGO_PRUEBA_CONOCIMIENTO;
        editarDatoTabla(row.data(), 'formularioPRUEBA', 'miModal_PRUEBA');


    $('#miModal_PRUEBA .modal-title').html(row.data().NOMBRE_PRUEBA);

    });

    $('#miModal_PRUEBA').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_PRUEBA');
    });
});

