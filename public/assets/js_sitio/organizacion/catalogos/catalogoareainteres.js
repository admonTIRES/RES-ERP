//VARIABLES
ID_CATALOGO_AREAINTERES = 0




const ModalArea = document.getElementById('miModal_AREAINTERES')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    
    ID_CATALOGO_AREAINTERES = 0
    document.getElementById('formularioAREAINTERES').reset();
   

})






$("#guardarFormAREA").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioAREAINTERES'))

    if (formularioValido) {

    if (ID_CATALOGO_AREAINTERES == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormAREA')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_AREAINTERES: ID_CATALOGO_AREAINTERES }, 'interesSave', 'formularioAREAINTERES', 'guardarFormAREA', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_CATALOGO_AREAINTERES = data.area.ID_CATALOGO_AREAINTERES
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_AREAINTERES').modal('hide')
                    document.getElementById('formularioAREAINTERES').reset();
                    Tablaareainteres.ajax.reload()

        
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormAREA')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_AREAINTERES: ID_CATALOGO_AREAINTERES }, 'interesSave', 'formularioAREAINTERES', 'guardarFormAREA', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_CATALOGO_AREAINTERES = data.area.ID_CATALOGO_AREAINTERES
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_AREAINTERES').modal('hide')
                    document.getElementById('formularioAREAINTERES').reset();
                    Tablaareainteres.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});


var Tablaareainteres = $("#Tablaareainteres").DataTable({
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
        url: '/Tablaareainteres',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablaareainteres.columns.adjust().draw();
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
        { data: 'TIPO_AREA_TEXTO' },
        { data: 'NOMBRE_AREA' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Tipo', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Nombre', className: 'all text-center' },
        { targets: 3, title: 'Editar', className: 'all text-center' },
        { targets: 4, title: 'Visualizar', className: 'all text-center' },
        { targets: 5, title: 'Activo', className: 'all text-center' }
    ]
});



$('#Tablaareainteres tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablaareainteres.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_CATALOGO_AREAINTERES: row.data().ID_CATALOGO_AREAINTERES
    };

    eliminarDatoTabla(data, [Tablaareainteres], 'interesDelete');
});



$('#Tablaareainteres tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablaareainteres.row(tr);
    ID_CATALOGO_AREAINTERES = row.data().ID_CATALOGO_AREAINTERES;

    editarDatoTabla(row.data(), 'formularioAREAINTERES', 'miModal_AREAINTERES',1);
});



$(document).ready(function() {
    $('#Tablaareainteres tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablaareainteres.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_AREAINTERES');

        ID_CATALOGO_AREAINTERES = row.data().ID_CATALOGO_AREAINTERES;
        editarDatoTabla(row.data(), 'formularioAREAINTERES', 'miModal_AREAINTERES',1);
    });

    $('#miModal_AREAINTERES').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_AREAINTERES');
    });
});

