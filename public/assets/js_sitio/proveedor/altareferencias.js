
ID_FORMULARIO_REFERENCIASPROVEEDOR = 0





const Modalcontacto = document.getElementById('miModal_referencia')
Modalcontacto.addEventListener('hidden.bs.modal', event => {
    ID_FORMULARIO_REFERENCIASPROVEEDOR = 0
    document.getElementById('formularioReferencias').reset();
    
})


$("#guardarREFERENCIAS").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioReferencias'))

    if (formularioValido) {

    if (ID_FORMULARIO_REFERENCIASPROVEEDOR == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarREFERENCIAS')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_REFERENCIASPROVEEDOR: ID_FORMULARIO_REFERENCIASPROVEEDOR }, 'AltareferenciaSave', 'formularioReferencias', 'guardarREFERENCIAS', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_FORMULARIO_REFERENCIASPROVEEDOR = data.cuenta.ID_FORMULARIO_REFERENCIASPROVEEDOR
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_referencia').modal('hide')
                    document.getElementById('formularioReferencias').reset();
                    Tablareferenciasproveedor.ajax.reload()

        
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarREFERENCIAS')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_REFERENCIASPROVEEDOR: ID_FORMULARIO_REFERENCIASPROVEEDOR }, 'AltareferenciaSave', 'formularioReferencias', 'guardarREFERENCIAS', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_FORMULARIO_REFERENCIASPROVEEDOR = data.cuenta.ID_FORMULARIO_REFERENCIASPROVEEDOR
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_referencia').modal('hide')
                    document.getElementById('formularioReferencias').reset();
                    Tablareferenciasproveedor.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});



var Tablareferenciasproveedor = $("#Tablareferenciasproveedor").DataTable({
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
        url: '/Tablareferenciasproveedor',
        beforeSend: function () {
            $('#loadingIcon1').css('display', 'inline-block');
        },
        complete: function () {
            $('#loadingIcon1').css('display', 'none');
            Tablareferenciasproveedor.columns.adjust().draw(); 
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
        { data: 'NOMBRE_EMPRESA' },
        { data: 'NOMBRE_CONTACTO' },
        { data: 'CARGO_REFERENCIA' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Nombre de la empresa', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Nombre del contacto', className: 'all text-center nombre-column' },
        { targets: 3, title: 'Cargo', className: 'all text-center nombre-column' },
        { targets: 4, title: 'Editar', className: 'all text-center' },
        { targets: 5, title: 'Visualizar', className: 'all text-center' },
    ]
});




$('#Tablareferenciasproveedor tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablareferenciasproveedor.row(tr);
    ID_FORMULARIO_REFERENCIASPROVEEDOR = row.data().ID_FORMULARIO_REFERENCIASPROVEEDOR;

    editarDatoTabla(row.data(), 'formularioReferencias', 'miModal_referencia', 1);
    

   


});





$(document).ready(function() {
    $('#Tablareferenciasproveedor tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablareferenciasproveedor.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_referencia');

        ID_FORMULARIO_REFERENCIASPROVEEDOR = row.data().ID_FORMULARIO_REFERENCIASPROVEEDOR;
        editarDatoTabla(row.data(), 'formularioReferencias', 'miModal_referencia', 1);
        
    
    });


    $('#miModal_referencia').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_referencia');
    });
});






$('#Tablareferenciasproveedor tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablareferenciasproveedor.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_FORMULARIO_REFERENCIASPROVEEDOR: row.data().ID_FORMULARIO_REFERENCIASPROVEEDOR
    };

    eliminarDatoTabla(data, [Tablareferenciasproveedor], 'ReferenciasDelete');
});


document.addEventListener('DOMContentLoaded', function () {
    const check = document.getElementById('proveedorVigenteCheck');
    const hastaInput = document.getElementById('HASTA_REFERENCIA');
    const referenciaVigente = document.getElementById('referenciaVigenteInput');

    check.addEventListener('change', function () {
        if (check.checked) {
            const today = new Date().toISOString().split('T')[0];
            hastaInput.value = today;
            hastaInput.readOnly = true;
            referenciaVigente.value = today;
        } else {
            hastaInput.value = '';
            hastaInput.readOnly = false;
            referenciaVigente.value = '';
        }
    });
});


