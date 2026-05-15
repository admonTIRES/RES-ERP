//VARIABLES
ID_CATALOGO_LINEA_NEGOCIOS = 0




const Modallinea = document.getElementById('miModal_LINEANEGOCIO') 
Modallinea.addEventListener('hidden.bs.modal', event => {
    
    
    ID_CATALOGO_LINEA_NEGOCIOS = 0
    document.getElementById('formularioLINEANEGOCIO').reset();
   

})






$("#guardarLINEANEGOCIO").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioLINEANEGOCIO'))

    if (formularioValido) {

    if (ID_CATALOGO_LINEA_NEGOCIOS == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarLINEANEGOCIO')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_LINEA_NEGOCIOS: ID_CATALOGO_LINEA_NEGOCIOS }, 'LineaSave', 'formularioLINEANEGOCIO', 'guardarLINEANEGOCIO', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_CATALOGO_LINEA_NEGOCIOS = data.linea.ID_CATALOGO_LINEA_NEGOCIOS
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_LINEANEGOCIO').modal('hide')
                    document.getElementById('formularioLINEANEGOCIO').reset();
                    Tablalineanegocio.ajax.reload()

        
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarLINEANEGOCIO')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_LINEA_NEGOCIOS: ID_CATALOGO_LINEA_NEGOCIOS }, 'LineaSave', 'formularioLINEANEGOCIO', 'guardarLINEANEGOCIO', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_CATALOGO_LINEA_NEGOCIOS = data.linea.ID_CATALOGO_LINEA_NEGOCIOS
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_LINEANEGOCIO').modal('hide')
                    document.getElementById('formularioLINEANEGOCIO').reset();
                    Tablalineanegocio.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});


var Tablalineanegocio = $("#Tablalineanegocio").DataTable({
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
        url: '/Tablalineanegocio',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablalineanegocio.columns.adjust().draw();
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
        { data: 'NOMBRE_LINEA' },
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



$('#Tablalineanegocio tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablalineanegocio.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_CATALOGO_LINEA_NEGOCIOS: row.data().ID_CATALOGO_LINEA_NEGOCIOS
    };

    eliminarDatoTabla(data, [Tablalineanegocio], 'LineaDelete');
});



$('#Tablalineanegocio tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablalineanegocio.row(tr);
    ID_CATALOGO_LINEA_NEGOCIOS = row.data().ID_CATALOGO_LINEA_NEGOCIOS;

    editarDatoTabla(row.data(), 'formularioLINEANEGOCIO', 'miModal_LINEANEGOCIO',1);
});



$(document).ready(function() {
    $('#Tablalineanegocio tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablalineanegocio.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_LINEANEGOCIO');

        ID_CATALOGO_LINEA_NEGOCIOS = row.data().ID_CATALOGO_LINEA_NEGOCIOS;
        editarDatoTabla(row.data(), 'formularioLINEANEGOCIO', 'miModal_LINEANEGOCIO',1);
    });

    $('#miModal_LINEANEGOCIO').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_LINEANEGOCIO');
    });
});

