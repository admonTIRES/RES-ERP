//VARIABLES
ID_LINEA_NEGOCIO = 0




const ModalArea = document.getElementById('miModal_linea')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    ID_LINEA_NEGOCIO = 0
    document.getElementById('formulariolinea').reset();
   
    $('#miModal_linea .modal-title').html('Nueva línea de negocio');


})






$("#guardarlinea").click(function (e) {
    e.preventDefault();


    formularioValido = validarFormulario3($('#formulariolinea'))

    if (formularioValido) {

    if (ID_LINEA_NEGOCIO == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarlinea')
            await ajaxAwaitFormData({ api: 18, ID_LINEA_NEGOCIO: ID_LINEA_NEGOCIO }, 'CatcapacitacionSave', 'formulariolinea', 'guardarlinea', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                    ID_LINEA_NEGOCIO = data.capacitaciones.ID_LINEA_NEGOCIO
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_linea').modal('hide')
                    document.getElementById('formulariolinea').reset();
                    Tablacaplineanegocios.ajax.reload()
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarlinea')
            await ajaxAwaitFormData({ api: 18, ID_LINEA_NEGOCIO: ID_LINEA_NEGOCIO }, 'CatcapacitacionSave', 'formulariolinea', 'guardarlinea', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    ID_LINEA_NEGOCIO = data.capacitaciones.ID_LINEA_NEGOCIO
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_linea').modal('hide')
                    document.getElementById('formulariolinea').reset();
                    Tablacaplineanegocios.ajax.reload()

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});



var Tablacaplineanegocios = $("#Tablacaplineanegocios").DataTable({
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
        url: '/Tablacaplineanegocios',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablacaplineanegocios.columns.adjust().draw();
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
        {
            data: null,
            render: function (data, type, row) {
                if (row.ABREVIATURA_NEGOCIO) {
                    return row.NOMBRE_LINEA + ' (' + row.ABREVIATURA_NEGOCIO + ')';
                }
                return row.NOMBRE_LINEA;
            }
        },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Líneas de negocios', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Editar', className: 'all text-center' },
        { targets: 3, title: 'Visualizar', className: 'all text-center' },
        { targets: 4, title: 'Activo', className: 'all text-center' }
    ]
});





$('#Tablacaplineanegocios tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacaplineanegocios.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 18,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_LINEA_NEGOCIO: row.data().ID_LINEA_NEGOCIO
    };

    eliminarDatoTabla(data, [Tablacaplineanegocios], 'CatcapacitacionDelete');
});



$('#Tablacaplineanegocios tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacaplineanegocios.row(tr);


    ID_LINEA_NEGOCIO = row.data().ID_LINEA_NEGOCIO;

    editarDatoTabla(row.data(), 'formulariolinea', 'miModal_linea');

    $('#miModal_linea .modal-title').html(row.data().NOMBRE_LINEA);

});



$(document).ready(function() {
    $('#Tablacaplineanegocios tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablacaplineanegocios.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_linea');

        ID_LINEA_NEGOCIO = row.data().ID_LINEA_NEGOCIO;
        editarDatoTabla(row.data(), 'formulariolinea', 'miModal_linea');
         $('#miModal_linea .modal-title').html(row.data().NOMBRE_LINEA);

    });

    $('#miModal_linea').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_linea');
    });
});

