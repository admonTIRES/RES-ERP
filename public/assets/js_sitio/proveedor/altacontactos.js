
ID_FORMULARIO_CONTACTOPROVEEDOR = 0





const Modalcontacto = document.getElementById('miModal_contactos')
Modalcontacto.addEventListener('hidden.bs.modal', event => {
    
    
    ID_FORMULARIO_CONTACTOPROVEEDOR = 0
    document.getElementById('formularioCONTACTOS').reset();
      var selectize = $('#FUNCIONES_CUENTA')[0].selectize;
    selectize.clear(); 
    selectize.setValue("");

})



$(document).ready(function () {
    var selectizeInstance = $('#FUNCIONES_CUENTA').selectize({
        placeholder: 'Seleccione una opción',
        allowEmptyOption: true,
        closeAfterSelect: true,
    });

    $("#NUEVO_CONTACTO").click(function (e) {
        e.preventDefault();

        $("#miModal_contactos").modal("show");

        document.getElementById('formularioCONTACTOS').reset();

        var selectize = selectizeInstance[0].selectize;
        selectize.clear();
        selectize.setValue(""); 


      
    });
});



$("#guardarCONTACTOS").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioCONTACTOS'))

    if (formularioValido) {

    if (ID_FORMULARIO_CONTACTOPROVEEDOR == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarCONTACTOS')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_CONTACTOPROVEEDOR: ID_FORMULARIO_CONTACTOPROVEEDOR }, 'AltacontactoSave', 'formularioCONTACTOS', 'guardarCONTACTOS', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_FORMULARIO_CONTACTOPROVEEDOR = data.cuenta.ID_FORMULARIO_CONTACTOPROVEEDOR
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_contactos').modal('hide')
                    document.getElementById('formularioCONTACTOS').reset();
                    Tablacontactosproveedor.ajax.reload()

        
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarCONTACTOS')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_CONTACTOPROVEEDOR: ID_FORMULARIO_CONTACTOPROVEEDOR }, 'AltacontactoSave', 'formularioCONTACTOS', 'guardarCONTACTOS', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_FORMULARIO_CONTACTOPROVEEDOR = data.cuenta.ID_FORMULARIO_CONTACTOPROVEEDOR
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_contactos').modal('hide')
                    document.getElementById('formularioCONTACTOS').reset();
                    Tablacontactosproveedor.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});






var Tablacontactosproveedor = $("#Tablacontactosproveedor").DataTable({
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
    destroy: true,
    ajax: {
        dataType: 'json',
        data: {},
        method: 'GET',
        cache: false,
        url: '/Tablacontactosproveedor',
        beforeSend: function () {
            $('#loadingIcon1').css('display', 'inline-block');
        },
        complete: function () {
            $('#loadingIcon1').css('display', 'none');
            Tablacontactosproveedor.columns.adjust().draw(); 
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('#loadingIcon1').css('display', 'none');
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
                return row.TITULO_CUENTA ? `${row.TITULO_CUENTA}. ${row.NOMBRE_CONTACTO_CUENTA}` : row.NOMBRE_CONTACTO_CUENTA;
            }
        },
        { data: 'CARGO_CONTACTO_CUENTA' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Nombre del contacto', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Cargo', className: 'all text-center nombre-column' },
        { targets: 3, title: 'Editar', className: 'all text-center' },
        { targets: 4, title: 'Visualizar', className: 'all text-center' },
    ]
});




$('#Tablacontactosproveedor tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacontactosproveedor.row(tr);
    ID_FORMULARIO_CONTACTOPROVEEDOR = row.data().ID_FORMULARIO_CONTACTOPROVEEDOR;

    editarDatoTabla(row.data(), 'formularioCONTACTOS', 'miModal_contactos', 1);
    

     var selectize = $('#FUNCIONES_CUENTA')[0].selectize;

    if (row.data().FUNCIONES_CUENTA) {
        try {
            let ofertaArray = JSON.parse(row.data().FUNCIONES_CUENTA); 
            if (Array.isArray(ofertaArray)) {
                selectize.setValue(ofertaArray); 
            } else {
                selectize.clear();
            }
        } catch (error) {
            console.error("Error al parsear:", error);
            selectize.clear();
        }
    } else {
        selectize.clear();
    }


});





$(document).ready(function() {
    $('#Tablacontactosproveedor tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablacontactosproveedor.row(tr);
        
        hacerSoloLectura2(row.data(), '#miModal_contactos');

        ID_FORMULARIO_CONTACTOPROVEEDOR = row.data().ID_FORMULARIO_CONTACTOPROVEEDOR;
        editarDatoTabla(row.data(), 'formularioCONTACTOS', 'miModal_contactos', 1);
        
       
  var selectize = $('#FUNCIONES_CUENTA')[0].selectize;

    if (row.data().FUNCIONES_CUENTA) {
        try {
            let ofertaArray = JSON.parse(row.data().FUNCIONES_CUENTA); 
            if (Array.isArray(ofertaArray)) {
                selectize.setValue(ofertaArray); 
            } else {
                selectize.clear();
            }
        } catch (error) {
            console.error("Error al parsear:", error);
            selectize.clear();
        }
    } else {
        selectize.clear();
    }
        

    });


    $('#miModal_contactos').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_contactos');
    });
});






$('#Tablacontactosproveedor tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacontactosproveedor.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_FORMULARIO_CONTACTOPROVEEDOR: row.data().ID_FORMULARIO_CONTACTOPROVEEDOR
    };

    eliminarDatoTabla(data, [Tablacontactosproveedor], 'ContactoDelete');
});
