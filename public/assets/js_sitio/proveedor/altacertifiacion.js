
ID_FORMULARIO_CERTIFICACIONPROVEEDOR = 0



const Modalcertificacion = document.getElementById('miModal_certificaciones');

Modalcertificacion.addEventListener('hidden.bs.modal', event => {

    ID_FORMULARIO_CERTIFICACIONPROVEEDOR = 0;

    document.getElementById('formularioCertificaciones').reset();

    $('#DIV_CERTIFICACION').hide();
    $('#DIV_ACREDITACION').hide();
    $('#DIV_AUTORIZACION').hide();
    $('#DIV_MEMBRESIA').hide();

 
});



document.getElementById('TIPO_DOCUMENTO').addEventListener('change', function () {
    let tipo = this.value;

    resetSection('DIV_CERTIFICACION');
    resetSection('DIV_ACREDITACION');
    resetSection('DIV_MEMBRESIA');

    if (tipo === 'Certificación') {
        document.getElementById('DIV_CERTIFICACION').style.display = 'block';
    } else if (tipo === 'Acreditación') {
        document.getElementById('DIV_ACREDITACION').style.display = 'block';
    } else if (tipo === 'Membresía') {
        document.getElementById('DIV_MEMBRESIA').style.display = 'block';
    }
});

document.getElementById('REQUISITO_AUTORIZACION').addEventListener('change', function () {
    if (this.value === 'Si') {
        document.getElementById('DIV_AUTORIZACION').style.display = 'block';
    } else {
        resetSection('DIV_AUTORIZACION');
    }
});

function resetSection(divId) {
    let section = document.getElementById(divId);
    section.style.display = 'none';
    // Limpia todos los campos dentro del div
    let inputs = section.querySelectorAll('input, select, textarea');
    inputs.forEach(function (input) {
        if (input.type === 'checkbox' || input.type === 'radio') {
            input.checked = false;
        } else {
            input.value = '';
        }
    });
}



$("#guardarCertificaciones").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario3($('#formularioCertificaciones'))

    if (formularioValido) {

    if (ID_FORMULARIO_CERTIFICACIONPROVEEDOR == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarCertificaciones')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_CERTIFICACIONPROVEEDOR: ID_FORMULARIO_CERTIFICACIONPROVEEDOR }, 'AltacertificacionSave', 'formularioCertificaciones', 'guardarCertificaciones', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_FORMULARIO_CERTIFICACIONPROVEEDOR = data.cuenta.ID_FORMULARIO_CERTIFICACIONPROVEEDOR
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_certificaciones').modal('hide')
                    document.getElementById('formularioCertificaciones').reset();
                    Tablacertificacionproveedores.ajax.reload()

        
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarCertificaciones')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_CERTIFICACIONPROVEEDOR: ID_FORMULARIO_CERTIFICACIONPROVEEDOR }, 'AltacertificacionSave', 'formularioCertificaciones', 'guardarCertificaciones', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_FORMULARIO_CERTIFICACIONPROVEEDOR = data.cuenta.ID_FORMULARIO_CERTIFICACIONPROVEEDOR
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_certificaciones').modal('hide')
                    document.getElementById('formularioCertificaciones').reset();
                    Tablacertificacionproveedores.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});



var Tablacertificacionproveedores = $("#Tablacertificacionproveedores").DataTable({
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
        url: '/Tablacertificacionproveedores',
        beforeSend: function () {
            $('#loadingIcon1').css('display', 'inline-block');
        },
        complete: function () {
            $('#loadingIcon1').css('display', 'none');
            Tablacertificacionproveedores.columns.adjust().draw(); 
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
        { data: 'TIPO_DOCUMENTO' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_DOCUMENTO' },
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Tipo ', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Editar', className: 'all text-center' },
        { targets: 3, title: 'Visualizar', className: 'all text-center' },
        { targets: 4, title: 'Documentos', className: 'all text-center' },
    ]
});






$('#Tablacertificacionproveedores').on('click', '.ver-archivo-certificación', function () {
    var id = $(this).data('id');
    if (!id) {
        alert('ARCHIVO NO ENCONTRADO');
        return;
    }
    var url = '/mostrarcertificacion/' + id;
    abrirModal(url, 'Certificación');
});





$('#Tablacertificacionproveedores').on('click', '.ver-archivo-acreditacion', function () {
    var id = $(this).data('id');
    if (!id) {
        alert('ARCHIVO NO ENCONTRADO');
        return;
    }
    var url = '/mostraracreditacion/' + id;
    abrirModal(url, 'Acreditación');
});





$('#Tablacertificacionproveedores').on('click', '.ver-archivo-autorizacion', function () {
    var id = $(this).data('id');
    if (!id) {
        alert('ARCHIVO NO ENCONTRADO');
        return;
    }
    var url = '/mostrarautorizacion/' + id;
    abrirModal(url, 'Autorización');
});




$('#Tablacertificacionproveedores').on('click', '.ver-archivo-membresia', function () {
    var id = $(this).data('id');
    if (!id) {
        alert('ARCHIVO NO ENCONTRADO');
        return;
    }
    var url = '/mostrarmembresia/' + id;
    abrirModal(url, 'Membresía');
});




$('#Tablacertificacionproveedores tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacertificacionproveedores.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_FORMULARIO_CERTIFICACIONPROVEEDOR: row.data().ID_FORMULARIO_CERTIFICACIONPROVEEDOR
    };

    eliminarDatoTabla(data, [Tablacertificacionproveedores], 'CertificacionDelete');
});


$('#Tablacertificacionproveedores tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacertificacionproveedores.row(tr);

    ID_FORMULARIO_CERTIFICACIONPROVEEDOR = row.data().ID_FORMULARIO_CERTIFICACIONPROVEEDOR;

    editarDatoTabla(row.data(), 'formularioCertificaciones', 'miModal_certificaciones', 1);
    

     if (row.data().TIPO_DOCUMENTO === "Certificación") {
        $('#DIV_CERTIFICACION').show();
         $('#DIV_ACREDITACION').hide();
        $('#DIV_AUTORIZACION').hide();
        $('#DIV_MEMBRESIA').hide();
         
    } else if (row.data().TIPO_DOCUMENTO === "Acreditación") {
         $('#DIV_ACREDITACION').show();
         $('#DIV_CERTIFICACION').hide();
        $('#DIV_MEMBRESIA').hide();
         
        
     } else {
         $('#DIV_MEMBRESIA').show();
        $('#DIV_CERTIFICACION').hide();
        $('#DIV_ACREDITACION').hide();
        $('#DIV_AUTORIZACION').hide();
          
    }


    if (row.data().REQUISITO_AUTORIZACION === "Si") {
        $('#DIV_AUTORIZACION').show();
    } else {
        $('#DIV_AUTORIZACION').hide();
    }

  
});





$(document).ready(function() {
    $('#Tablacertificacionproveedores tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablacertificacionproveedores.row(tr);
        
        hacerSoloLectura2(row.data(), '#miModal_certificaciones');

        ID_FORMULARIO_CERTIFICACIONPROVEEDOR = row.data().ID_FORMULARIO_CERTIFICACIONPROVEEDOR;
        editarDatoTabla(row.data(), 'formularioCertificaciones', 'miModal_certificaciones', 1);
        
        if (row.data().TIPO_DOCUMENTO === "Certificación") {
            $('#DIV_CERTIFICACION').show();
             $('#DIV_ACREDITACION').hide();
            $('#DIV_AUTORIZACION').hide();
            $('#DIV_MEMBRESIA').hide();
             
        } else if (row.data().TIPO_DOCUMENTO === "Acreditación") {
             $('#DIV_ACREDITACION').show();
             $('#DIV_CERTIFICACION').hide();
            $('#DIV_MEMBRESIA').hide();
             
            
         } else {
             $('#DIV_MEMBRESIA').show();
            $('#DIV_CERTIFICACION').hide();
            $('#DIV_ACREDITACION').hide();
            $('#DIV_AUTORIZACION').hide();
              
        }
    
    
        if (row.data().REQUISITO_AUTORIZACION === "Si") {
            $('#DIV_AUTORIZACION').show();
        } else {
            $('#DIV_AUTORIZACION').hide();
        }
    
    });


    $('#miModal_certificaciones').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_certificaciones');
    });
});

