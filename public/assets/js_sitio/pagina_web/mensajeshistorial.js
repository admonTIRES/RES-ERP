//VARIABLES
ID_FORMULARIO_CONTACTOSPAGINAWEB = 0




const ModalArea = document.getElementById('miModal_MENSAJES')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    
    ID_FORMULARIO_CONTACTOSPAGINAWEB = 0
    document.getElementById('formularioMENSAJES').reset();
   

    $('#DIV_SOLCITUD').hide();
    $('#NO_ATENDIDA').hide();


})


var Tablamensajepaginawebhistorial = $("#Tablamensajepaginawebhistorial").DataTable({
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
        url: '/Tablamensajepaginawebhistorial',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablamensajepaginawebhistorial.columns.adjust().draw();
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
        { data: 'NOMBRE' },
        { data: 'CORREO' },
        { data: 'MENSAJE' },
          {
            data: 'created_at',
            render: function (data) {
                if (!data) return '';
                return data.split('T')[0]; 
            }
        },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Nombre', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Correo electrónico', className: 'all text-center nombre-column' },
        { targets: 3, title: 'Mensaje', className: 'all text-center descripcion-column' },
        { targets: 4, title: 'Fecha de envío', className: 'all text-center nombre-column' },
        { targets: 5, title: 'Editar', className: 'all text-center' },
        { targets: 6, title: 'Visualizar', className: 'all text-center' },
        { targets: 7, title: 'Activo', className: 'all text-center' }
    ]
});




$("#guardarpaginaweb").click(function (e) {
    e.preventDefault();


    formularioValido = validarFormulario3($('#formularioMENSAJES'))

    if (formularioValido) {

    if (ID_FORMULARIO_CONTACTOSPAGINAWEB == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarpaginaweb')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_CONTACTOSPAGINAWEB: ID_FORMULARIO_CONTACTOSPAGINAWEB }, 'PaginawebSave', 'formularioMENSAJES', 'guardarpaginaweb', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                    ID_FORMULARIO_CONTACTOSPAGINAWEB = data.pagina.ID_FORMULARIO_CONTACTOSPAGINAWEB
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_MENSAJES').modal('hide')
                    document.getElementById('formularioMENSAJES').reset();
                    Tablamensajepaginawebhistorial.ajax.reload()
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarpaginaweb')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_CONTACTOSPAGINAWEB: ID_FORMULARIO_CONTACTOSPAGINAWEB }, 'PaginawebSave', 'formularioMENSAJES', 'guardarpaginaweb', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    ID_FORMULARIO_CONTACTOSPAGINAWEB = data.pagina.ID_FORMULARIO_CONTACTOSPAGINAWEB
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_MENSAJES').modal('hide')
                    document.getElementById('formularioMENSAJES').reset();
                    Tablamensajepaginawebhistorial.ajax.reload()

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});


$('#Tablamensajepaginawebhistorial tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablamensajepaginawebhistorial.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_FORMULARIO_CONTACTOSPAGINAWEB: row.data().ID_FORMULARIO_CONTACTOSPAGINAWEB
    };

    eliminarDatoTabla(data, [Tablamensajepaginawebhistorial], 'MensajespaginaDelete');
});



$('#Tablamensajepaginawebhistorial tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablamensajepaginawebhistorial.row(tr);


    ID_FORMULARIO_CONTACTOSPAGINAWEB = row.data().ID_FORMULARIO_CONTACTOSPAGINAWEB;

    editarDatoTabla(row.data(), 'formularioMENSAJES', 'miModal_MENSAJES');


});




$(document).ready(function() {
    $('#Tablamensajepaginawebhistorial tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablamensajepaginawebhistorial.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_MENSAJES');

        ID_FORMULARIO_CONTACTOSPAGINAWEB = row.data().ID_FORMULARIO_CONTACTOSPAGINAWEB;
        editarDatoTabla(row.data(), 'formularioMENSAJES', 'miModal_MENSAJES',1);

         if (row.data().SOLICITUD_ATENDIDA === "1") {
            $('#DIV_SOLCITUD').show();
            $('#NO_ATENDIDA').hide();
        } else if (row.data().SOLICITUD_ATENDIDA === "2") {
            $('#DIV_SOLCITUD').hide();
            $('#NO_ATENDIDA').show();
         } else {
             
            $('#DIV_SOLCITUD').hide();
            $('#NO_ATENDIDA').hide();
        }
        


    });

    $('#miModal_MENSAJES').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_MENSAJES');
    });
});



$('#SOLICITUD_ATENDIDA').on('change', function () {

    let valor = $(this).val();

    if (valor === "1") {
        $('#DIV_SOLCITUD').slideDown();
        $('#NO_ATENDIDA').slideUp();

    } else {
        $('#DIV_SOLCITUD').slideUp();
        $('#NO_ATENDIDA').slideDown();

    }
});



document.getElementById('SOLICITUD_ATENDIDA').addEventListener('change', function () {
    const input = document.getElementById('ATENDIO_SOLICITUD');
    const usuario = document.getElementById('USUARIO_AUTENTICADO').value;

    if (this.value === "1") {
        input.value = usuario;
    } else {
        input.value = "";
    }
});