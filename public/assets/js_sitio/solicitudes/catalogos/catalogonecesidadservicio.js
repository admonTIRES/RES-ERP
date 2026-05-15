//VARIABLES
ID_CATALOGO_NECESIDAD_SERVICIO = 0




const Modalnecesidad = document.getElementById('miModal_NECESIDADSERVICIO')
Modalnecesidad.addEventListener('hidden.bs.modal', event => {
    
    
    ID_CATALOGO_NECESIDAD_SERVICIO = 0
    document.getElementById('formularioNECESIDADSERVICIO').reset();
   

})






$("#guardarNECESIDADSERVICIO").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioNECESIDADSERVICIO'))

    if (formularioValido) {

    if (ID_CATALOGO_NECESIDAD_SERVICIO == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarNECESIDADSERVICIO')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_NECESIDAD_SERVICIO: ID_CATALOGO_NECESIDAD_SERVICIO }, 'NecesidadSave', 'formularioNECESIDADSERVICIO', 'guardarNECESIDADSERVICIO', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_CATALOGO_NECESIDAD_SERVICIO = data.necesidad.ID_CATALOGO_NECESIDAD_SERVICIO
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_NECESIDADSERVICIO').modal('hide')
                    document.getElementById('formularioNECESIDADSERVICIO').reset();
                    Tablanecesidadservicio.ajax.reload()

        
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarNECESIDADSERVICIO')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_NECESIDAD_SERVICIO: ID_CATALOGO_NECESIDAD_SERVICIO }, 'NecesidadSave', 'formularioNECESIDADSERVICIO', 'guardarNECESIDADSERVICIO', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_CATALOGO_NECESIDAD_SERVICIO = data.necesidad.ID_CATALOGO_NECESIDAD_SERVICIO
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_NECESIDADSERVICIO').modal('hide')
                    document.getElementById('formularioNECESIDADSERVICIO').reset();
                    Tablanecesidadservicio.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});


var Tablanecesidadservicio = $("#Tablanecesidadservicio").DataTable({
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
        url: '/Tablanecesidadservicio',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablanecesidadservicio.columns.adjust().draw();
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
        { data: 'DESCRIPCION_NECESIDAD' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Nombre', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Editar', className: 'all text-center' },
        { targets: 3, title: 'Visualizar', className: 'all text-center' },
        { targets: 4, title: 'Activo', className: 'all text-center' }
    ]
});



$('#Tablanecesidadservicio tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablanecesidadservicio.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_CATALOGO_NECESIDAD_SERVICIO: row.data().ID_CATALOGO_NECESIDAD_SERVICIO
    };

    eliminarDatoTabla(data, [Tablanecesidadservicio], 'NecesidadDelete');
});



$('#Tablanecesidadservicio tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablanecesidadservicio.row(tr);
    ID_CATALOGO_NECESIDAD_SERVICIO = row.data().ID_CATALOGO_NECESIDAD_SERVICIO;

    editarDatoTabla(row.data(), 'formularioNECESIDADSERVICIO', 'miModal_NECESIDADSERVICIO',1);
});



$(document).ready(function() {
    $('#Tablanecesidadservicio tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablanecesidadservicio.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_NECESIDADSERVICIO');

        ID_CATALOGO_NECESIDAD_SERVICIO = row.data().ID_CATALOGO_NECESIDAD_SERVICIO;
        editarDatoTabla(row.data(), 'formularioNECESIDADSERVICIO', 'miModal_NECESIDADSERVICIO',1);
    });

    $('#miModal_NECESIDADSERVICIO').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_NECESIDADSERVICIO');
    });
});

