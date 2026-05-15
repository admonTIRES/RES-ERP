
var ID_USUARIO = 0

Tablausuarios = null

var password_error = 0;


var Tablaproveedores;
var TablaproveedoresCargada = false; 


const textoActivo = document.getElementById('texto_activo');
const textoInactivo = document.getElementById('texto_inactivo');
const tablaActivo = document.getElementById('tabla_activo');
const tablaInactivo = document.getElementById('tabla_inactivo');


textoActivo.addEventListener('click', () => {
    tablaActivo.style.display = 'block';
    tablaInactivo.style.display = 'none';
    textoActivo.classList.add('texto-seleccionado');
    textoActivo.classList.remove('texto-no-seleccionado');
    textoInactivo.classList.add('texto-no-seleccionado');
    textoInactivo.classList.remove('texto-seleccionado');

    Tablausuarios.columns.adjust().draw(); 

});



textoInactivo.addEventListener('click', () => {
    tablaActivo.style.display = 'none';
    tablaInactivo.style.display = 'block';
    textoInactivo.classList.add('texto-seleccionado');
    textoInactivo.classList.remove('texto-no-seleccionado');
    textoActivo.classList.add('texto-no-seleccionado');
    textoActivo.classList.remove('texto-seleccionado');

   
    cargarTablaProveedores();
     


});


$(document).ready(function() {
    $('#btnNuevoUsuario').on('click', function() {
        limpiarFormularioUsuario(); 

        $('#FOTO_USUARIO').dropify({
            messages: {
                'default': 'Arrastre la imagen aquí o haga clic',
                'replace': 'Arrastre la imagen aquí o haga clic para reemplazar',
                'remove':  'Quitar',
                'error':   'Ooops, ha ocurrido un error.'
            },
            error: {
                'fileSize': 'El archivo es demasiado grande (máx. {{ value }}).',
                'minWidth': 'El ancho de la imagen es demasiado pequeño (mín. {{ value }}px).',
                'maxWidth': 'El ancho de la imagen es demasiado grande (máx. {{ value }}px).',
                'minHeight': 'La altura de la imagen es demasiado pequeña (mín. {{ value }}px).',
                'maxHeight': 'La altura de la imagen es demasiado grande (máx. {{ value }}px).',
                'imageFormat': 'Formato no permitido, sólo se aceptan: ({{ value }}).'
            }
        });

        $('#modal_usuario').modal('show');
    });


    $('.toggle-password').on('click', function() {
        togglePasswordVisibility($(this));
    });
});


const Modalusuario = document.getElementById('modal_usuario');

Modalusuario.addEventListener('hidden.bs.modal', event => {
    ID_USUARIO = 0;
    document.getElementById('formularioUSUARIO').reset();

    const checkboxes = document.querySelectorAll('.checkbox_rol');
    checkboxes.forEach(checkbox => {
        checkbox.disabled = false;
    });

    $("#USUARIO_TIPO").val("1").trigger("change");
    $("#DIV_INFORMACION input, #DIV_FOTO input, #DIV_DIRRECCION input, #DIV_CARGO input, #DIV_TELEFONO input, #DIV_NACIMIENTO input, #DIV_PROVEDOR input").removeAttr("required");


        $('#guardarFormUSUARIO').prop('disabled', false);

    
    
});



$("#guardarFormUSUARIO").click(function (e) {
    e.preventDefault();


        formularioValido = validarFormulario3($('#formularioUSUARIO'))

    
    if (formularioValido) {

    if (ID_USUARIO == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () {

            await loaderbtn('guardarFormUSUARIO')
            await ajaxAwaitFormData({ api: 1, ID_USUARIO: ID_USUARIO }, 'usuarioSave', 'formularioUSUARIO', 'guardarFormUSUARIO', { callbackAfter: true, callbackBefore: true }, () => {

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    ID_USUARIO = data.usuario.ID_USUARIO
                    alertMensaje('success','Información guardada correctamente',null)
                     $('#modal_usuario').modal('hide')
                    document.getElementById('formularioUSUARIO').reset();
                    Tablausuarios.ajax.reload()

                    
                  

                }, 300);
                
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se editara la información",
            icon: "question",
        },async function () {

            await loaderbtn('guardarFormUSUARIO')
            await ajaxAwaitFormData({ api: 1, ID_USUARIO: ID_USUARIO }, 'usuarioSave', 'formularioUSUARIO', 'guardarFormUSUARIO', { callbackAfter: true, callbackBefore: true }, () => {

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_USUARIO = data.usuario.ID_USUARIO
                    alertMensaje('success','Información guardada correctamente',null )
                     $('#modal_usuario').modal('hide')
                    document.getElementById('formularioUSUARIO').reset();
                    Tablausuarios.ajax.reload()

                
                            


                }, 300);
            })
        }, 1)
    }
} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});






var Tablausuarios = $("#Tablausuarios").DataTable({
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
        url: '/Tablausuarios',
        beforeSend: function () {
            $('#loadingIcon8').css('display', 'inline-block');
        },
        complete: function () {
            $('#loadingIcon8').css('display', 'none');
            Tablausuarios.columns.adjust().draw(); 
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('#loadingIcon8').css('display', 'none');
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
            data: null,  render: function (data, type, row)
             {
                return row.NOMBRE_COLABORADOR + ' ' + row.PRIMER_APELLIDO + ' ' + row.SEGUNDO_APELLIDO;
            }
        }
        ,
        { data: 'CURP' },
        { data: 'BTN_EDITAR' }
    ],
     columns: [
        { 
            data: null,
            render: function(data, type, row, meta) {
                return meta.row + 1; 
            }
        },
        { 
            data: 'FOTO_USUARIO_HTML',
            orderable: false,
            searchable: false,
            className: 'text-center'
        },
        { data: 'EMPLEADO_NOMBRES' },
        { data: 'EMPLEADO_CORREOS' },
        { data: 'USUARIO_TIPOS' },
        {
            data: 'ROLES_ASIGNADOS',
            render: function(data, type, row) {
                if (data && data.length > 0) {
                    return `<ul>${data.map(role => `<li>${role}</li>`).join('')}</ul>`;
                }
                return 'Sin roles asignados';
            }
        },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_ELIMINAR' }
    ],
   columnDefs: [
    { targets: 0, title: '#', className: 'all text-center' },
    { targets: 1, title: 'Foto', className: 'all text-center' },
    { targets: 2, title: 'Nombre / Cargo', className: 'all text-center' },
    { targets: 3, title: 'Correo / Teléfono', className: 'all text-center' },
    { targets: 4, title: 'Tipo usuario', className: 'all text-center' },
    {
        targets: 5, 
        title: 'Perfil de accesos',
        className: 'all text-center', 
        createdCell: function (td, cellData, rowData, row, col) {
            $(td).css('text-align', 'left'); 
        }
    },
    { targets: 6, title: 'Editar', className: 'all text-center' },
    { targets: 7, title: 'Activo', className: 'all text-center' }
]
});




function cargarTablaProveedores() {
    if ($.fn.DataTable.isDataTable('#Tablaproveedores')) {
        Tablaproveedores.clear().destroy();
    }

    Tablaproveedores = $("#Tablaproveedores").DataTable({
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
        url: '/Tablaproveedores',
        beforeSend: function () {
            $('#loadingIcon7').css('display', 'inline-block');
        },
        complete: function () {
            $('#loadingIcon7').css('display', 'none');
            Tablaproveedores.columns.adjust().draw(); 
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('#loadingIcon7').css('display', 'none');
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },      
            columns: [
                { 
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + 1; 
                    }
                },
                { data: 'RFC_PROVEEDOR' },
                { data: 'NOMBRE_COMERCIAL_PROVEEDOR' },
                { data: 'USUARIO_TIPOS' },
                {
                    data: 'ROLES_ASIGNADOS',
                    render: function(data, type, row) {
                        if (data && data.length > 0) {
                            return `<ul>${data.map(role => `<li>${role}</li>`).join('')}</ul>`;
                        }
                        return 'Sin roles asignados';
                    }
                },
                { data: 'BTN_EDITAR' },
                { data: 'BTN_ELIMINAR' },
            ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all text-center' },
            { targets: 1, title: 'RFC', className: 'all text-center' },
            { targets: 2, title: 'Nombre comercial', className: 'all text-center' },
            { targets: 3, title: 'Tipo usuario', className: 'all text-center' },
            {
                targets: 4, 
                title: 'Perfil de accesos',
                className: 'all text-center', 
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).css('text-align', 'left'); 
                }
            },
            { targets: 5, title: 'Editar', className: 'all text-center' },
            { targets: 6, title: 'Activo', className: 'all text-center' }
        ]
    });
}


$(document).on('change', '#Tablaproveedores .ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablaproveedores.row(tr);

    if (!row.data()) return; 

    const estado = $(this).is(':checked') ? 1 : 0;
    const data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0,
        ID_USUARIO: row.data().ID_USUARIO
    };

    eliminarDatoTabla(data, [Tablaproveedores], 'usuarioDelete');
});





// var Tablausuarios = $("#Tablausuarios").DataTable({
//     language: { url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json" },
//     lengthChange: true,
//     lengthMenu: [
//         [10, 25, 50, -1],
//         [10, 25, 50, 'All']
//     ],
//     info: false,
//     paging: true,
//     searching: true,
//     filtering: true,
//     scrollY: '65vh',
//     scrollCollapse: true,
//     responsive: true,
//     ajax: {
//         dataType: 'json',
//         data: {},
//         method: 'GET',
//         cache: false,
//         url: '/Tablausuarios',
//         beforeSend: function () {
//             mostrarCarga();
//         },
//         complete: function () {
//             ocultarCarga();

//             // Esperar a que todas las imágenes carguen y luego ajustar las columnas
//             $('#Tablausuarios tbody img').on('load', function () {
//                 Tablausuarios.columns.adjust().draw();
//             });
//         },
//         error: function (jqXHR, textStatus, errorThrown) {
//             alertErrorAJAX(jqXHR, textStatus, errorThrown);
//         },
//         dataSrc: 'data'
//     },
//     order: [[0, 'asc']],
//     columns: [
//         { 
//             data: null,
//             render: function(data, type, row, meta) {
//                 return meta.row + 1; 
//             }
//         },
//         { 
//             data: 'FOTO_USUARIO_HTML',
//             orderable: false,
//             searchable: false,
//             className: 'text-center'
//         },
//         { data: 'EMPLEADO_NOMBRES' },
//         { data: 'EMPLEADO_CORREOS' },
//         { data: 'USUARIO_TIPOS' },
//         {
//             data: 'ROLES_ASIGNADOS',
//             render: function(data, type, row) {
//                 if (data && data.length > 0) {
//                     return `<ul>${data.map(role => `<li>${role}</li>`).join('')}</ul>`;
//                 }
//                 return 'Sin roles asignados';
//             }
//         },
//         { data: 'BTN_EDITAR' },
//         { data: 'BTN_ELIMINAR' }
//     ],
//    columnDefs: [
//     { targets: 0, title: '#', className: 'all text-center' },
//     { targets: 1, title: 'Foto', className: 'all text-center' },
//     { targets: 2, title: 'Nombre / Cargo', className: 'all text-center' },
//     { targets: 3, title: 'Correo / Teléfono', className: 'all text-center' },
//     { targets: 4, title: 'Tipo usuario', className: 'all text-center' },
//     {
//         targets: 5, // Índice de la columna "Perfil de accesos"
//         title: 'Perfil de accesos',
//         className: 'all text-center', // Centrar el título
//         createdCell: function (td, cellData, rowData, row, col) {
//             $(td).css('text-align', 'left'); // Alinear el contenido a la izquierda
//         }
//     },
//     { targets: 6, title: 'Editar', className: 'all text-center' },
//     { targets: 7, title: 'Activo', className: 'all text-center' }
// ]

// });









$('#Tablausuarios tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablausuarios.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_USUARIO: row.data().ID_USUARIO
    };

    eliminarDatoTabla(data, [Tablausuarios], 'usuarioDelete');
});





$('#Tablausuarios tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablausuarios.row(tr);
    ID_USUARIO = row.data().ID_USUARIO;


    
    const datosUsuario = { ...row.data() };

    delete datosUsuario.PASSWORD;
    



    editarDatoTabla(row.data(), 'formularioUSUARIO', 'modal_usuario', 1);



    
     $("#PASSWORD").val(datosUsuario.PASSWORD_2);
    $("#PASSWORD_2").val(datosUsuario.PASSWORD_2);


    const rolesAsignados = row.data().ROLES_ASIGNADOS;
    const checkboxes = document.querySelectorAll('.checkbox_rol');
    const superusuarioCheckbox = Array.from(checkboxes).find(cb => cb.value === 'Superusuario');
    const administradorCheckbox = Array.from(checkboxes).find(cb => cb.value === 'Administrador');
    const proveedorCheckbox = Array.from(checkboxes).find(cb => cb.value === 'Proveedor');

    $("#USUARIO_TIPO").val(row.data().USUARIO_TIPO).trigger("change");

    checkboxes.forEach(checkbox => {
        checkbox.checked = rolesAsignados.includes(checkbox.value);
    });

    const tipoUsuario = row.data().USUARIO_TIPO;

    if (tipoUsuario === "2") { 
        checkboxes.forEach(cb => {
            cb.checked = false;
            cb.disabled = true;
        });
        if (proveedorCheckbox) {
            proveedorCheckbox.disabled = false;
            proveedorCheckbox.checked = true;
        }
    } else if (tipoUsuario === "1") { 
        checkboxes.forEach(cb => {
            cb.disabled = false;
        });
        if (proveedorCheckbox) {
            proveedorCheckbox.checked = false;
            proveedorCheckbox.disabled = true;
        }
    } else {
        checkboxes.forEach(cb => {
            cb.disabled = false;
        });
    }

    if (superusuarioCheckbox.checked) {
        administradorCheckbox.checked = false;
        administradorCheckbox.disabled = true;
    } else {
        administradorCheckbox.disabled = false;
    }

    if (administradorCheckbox.checked) {
        superusuarioCheckbox.checked = false;
        superusuarioCheckbox.disabled = true;
    } else {
        superusuarioCheckbox.disabled = false;
    }

    if (row.data().FOTO_USUARIO) {
        var archivo = row.data().FOTO_USUARIO;
        var extension = archivo.substring(archivo.lastIndexOf("."));
        var imagenUrl = '/usuariofoto/' + row.data().ID_USUARIO + extension;

        if ($('#FOTO_USUARIO').data('dropify')) {
            $('#FOTO_USUARIO').dropify().data('dropify').destroy();
            $('#FOTO_USUARIO').dropify().data('dropify').settings.defaultFile = imagenUrl;
            $('#FOTO_USUARIO').dropify().data('dropify').init();
        } else {
            $('#FOTO_USUARIO').attr('data-default-file', imagenUrl);
            $('#FOTO_USUARIO').dropify({
                messages: {
                    'default': 'Arrastre la imagen aquí o haga click',
                    'replace': 'Arrastre la imagen o haga clic para reemplazar',
                    'remove': 'Quitar',
                    'error': 'Ooops, ha ocurrido un error.'
                },
                error: {
                    'fileSize': 'Demasiado grande ({{ value }} max).',
                    'minWidth': 'Ancho demasiado pequeño (min {{ value }}}px).',
                    'maxWidth': 'Ancho demasiado grande (max {{ value }}}px).',
                    'minHeight': 'Alto demasiado pequeño (min {{ value }}}px).',
                    'maxHeight': 'Alto demasiado grande (max {{ value }}px).',
                    'imageFormat': 'Formato no permitido, sólo ({{ value }}).'
                }
            });
        }
    } else {
        $('#FOTO_USUARIO').dropify().data('dropify').resetPreview();
        $('#FOTO_USUARIO').dropify().data('dropify').clearElement();
    }


    

      setTimeout(() => {
    $("#PASSWORD").val(row.data().PASSWORD_2);
    $("#PASSWORD_2").val(row.data().PASSWORD_2);
    }, 100); // pequeño retraso para asegurar que el form ya fue llenado
    
});





$('#Tablaproveedores').on('click', 'button.EDITAR', function () {

    var tr = $(this).closest('tr');
    var row = Tablaproveedores.row(tr);
    ID_USUARIO = row.data().ID_USUARIO;


    const datosUsuario = { ...row.data() };

    delete datosUsuario.PASSWORD;
    

    editarDatoTabla(datosUsuario, 'formularioUSUARIO', 'modal_usuario', 1);

  
     $("#PASSWORD").val(datosUsuario.PASSWORD_2);
    $("#PASSWORD_2").val(datosUsuario.PASSWORD_2);


     const rolesAsignados = row.data().ROLES_ASIGNADOS;
    const checkboxes = document.querySelectorAll('.checkbox_rol');
    const superusuarioCheckbox = Array.from(checkboxes).find(cb => cb.value === 'Superusuario');
    const administradorCheckbox = Array.from(checkboxes).find(cb => cb.value === 'Administrador');
    const proveedorCheckbox = Array.from(checkboxes).find(cb => cb.value === 'Proveedor');

    $("#USUARIO_TIPO").val(row.data().USUARIO_TIPO).trigger("change");

    checkboxes.forEach(checkbox => {
        checkbox.checked = rolesAsignados.includes(checkbox.value);
    });

    const tipoUsuario = row.data().USUARIO_TIPO;

    if (tipoUsuario === "2") { 
        checkboxes.forEach(cb => {
            cb.checked = false;
            cb.disabled = true;
        });
        if (proveedorCheckbox) {
            proveedorCheckbox.disabled = false;
            proveedorCheckbox.checked = true;
        }
    } else if (tipoUsuario === "1") { 
        checkboxes.forEach(cb => {
            cb.disabled = false;
        });
        if (proveedorCheckbox) {
            proveedorCheckbox.checked = false;
            proveedorCheckbox.disabled = true;
        }
    } else {
        checkboxes.forEach(cb => {
            cb.disabled = false;
        });
    }

    if (superusuarioCheckbox.checked) {
        administradorCheckbox.checked = false;
        administradorCheckbox.disabled = true;
    } else {
        administradorCheckbox.disabled = false;
    }

    if (administradorCheckbox.checked) {
        superusuarioCheckbox.checked = false;
        superusuarioCheckbox.disabled = true;
    } else {
        superusuarioCheckbox.disabled = false;
    }



    if (row.data().FOTO_USUARIO) {
        var archivo = row.data().FOTO_USUARIO;
        var extension = archivo.substring(archivo.lastIndexOf("."));
        var imagenUrl = '/usuariofoto/' + row.data().ID_USUARIO + extension;

        if ($('#FOTO_USUARIO').data('dropify')) {
            $('#FOTO_USUARIO').dropify().data('dropify').destroy();
            $('#FOTO_USUARIO').dropify().data('dropify').settings.defaultFile = imagenUrl;
            $('#FOTO_USUARIO').dropify().data('dropify').init();
        } else {
            $('#FOTO_USUARIO').attr('data-default-file', imagenUrl);
            $('#FOTO_USUARIO').dropify({
                messages: {
                    'default': 'Arrastre la imagen aquí o haga click',
                    'replace': 'Arrastre la imagen o haga clic para reemplazar',
                    'remove': 'Quitar',
                    'error': 'Ooops, ha ocurrido un error.'
                },
                error: {
                    'fileSize': 'Demasiado grande ({{ value }} max).',
                    'minWidth': 'Ancho demasiado pequeño (min {{ value }}}px).',
                    'maxWidth': 'Ancho demasiado grande (max {{ value }}}px).',
                    'minHeight': 'Alto demasiado pequeño (min {{ value }}}px).',
                    'maxHeight': 'Alto demasiado grande (max {{ value }}px max).',
                    'imageFormat': 'Formato no permitido, sólo ({{ value }}).'
                }
            });
        }
    } else {
        $('#FOTO_USUARIO').dropify().data('dropify').resetPreview();
        $('#FOTO_USUARIO').dropify().data('dropify').clearElement();
    }


      setTimeout(() => {
    $("#PASSWORD").val(row.data().PASSWORD_2);
    $("#PASSWORD_2").val(row.data().PASSWORD_2);
    }, 100); // pequeño retraso para asegurar que el form ya fue llenado
    

});




function verificapassword() {
    const pass1 = $('#PASSWORD').val();
    const pass2 = $('#PASSWORD_2').val();

    if (pass1.length > 5) {
        if (pass1 === pass2) {
            password_error = 0;
            $('#PASSWORD_MENSAJE')
                .html('<h5 class="text-success">* Contraseñas iguales *</h5>')
                .show();
        } else {
            password_error = 1;
            $('#PASSWORD_MENSAJE')
                .html('<h5 class="text-danger">* Las contraseñas no son iguales *</h5>')
                .show();
        }
    } else {
        password_error = 1;
        $('#PASSWORD_MENSAJE')
            .html('<h5 class="text-danger">* La contraseña debe tener mínimo 6 caracteres *</h5>')
            .show();
    }
}

function togglePasswordVisibility(button) {
    var input = $(button.data('toggle'));
    var icon = button.find('i');

    if (input.attr('type') === 'password') {
        input.attr('type', 'text');
        icon.removeClass('bi-eye-slash-fill').addClass('bi-eye-fill');
    } else {
        input.attr('type', 'password');
        icon.removeClass('bi-eye-fill').addClass('bi-eye-slash-fill');
    }
}

function limpiarFormularioUsuario() {
    $('#formularioUSUARIO')[0].reset(); 

    $('#PASSWORD').val('');
    $('#PASSWORD_2').val('');
    $('#PASSWORD_MENSAJE').text('').hide();

    var drEvent = $('#FOTO_USUARIO').dropify().data('dropify');
    drEvent.resetPreview();
    drEvent.clearElement();
}


document.addEventListener('DOMContentLoaded', () => {
    const checkboxes = document.querySelectorAll('.checkbox_rol');
    const superusuarioCheckbox = Array.from(checkboxes).find(cb => cb.value === 'Superusuario');
    const administradorCheckbox = Array.from(checkboxes).find(cb => cb.value === 'Administrador');
    const proveedorCheckbox = Array.from(checkboxes).find(cb => cb.value === 'Proveedor'); 

    document.getElementById("USUARIO_TIPO").addEventListener("change", function() {
        let seleccion = this.value;

        if (seleccion === "2") { // Proveedor
            checkboxes.forEach(cb => {
                cb.checked = false;
                cb.disabled = true;
            });
            if (proveedorCheckbox) {
                proveedorCheckbox.disabled = false;
                proveedorCheckbox.checked = true; 
            }
        } else if (seleccion === "1") { 
            checkboxes.forEach(cb => {
                cb.disabled = false;
                cb.checked = false;
            });
            if (proveedorCheckbox) {
                proveedorCheckbox.disabled = true;
                proveedorCheckbox.checked = false;
            }
        } else { // Otros tipos
            checkboxes.forEach(cb => {
                cb.disabled = false;
                cb.checked = false;
            });
        }
    });

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            if (checkbox === superusuarioCheckbox && checkbox.checked) {
                if (administradorCheckbox) {
                    administradorCheckbox.checked = false;
                    administradorCheckbox.disabled = true;
                }
            }

            if (checkbox === superusuarioCheckbox && !checkbox.checked) {
                if (administradorCheckbox) {
                    administradorCheckbox.disabled = false;
                }
            }

            if (checkbox === administradorCheckbox && checkbox.checked) {
                if (superusuarioCheckbox) {
                    superusuarioCheckbox.checked = false;
                    superusuarioCheckbox.disabled = true;
                }
            }

            if (checkbox === administradorCheckbox && !checkbox.checked) {
                if (superusuarioCheckbox) {
                    superusuarioCheckbox.disabled = false;
                }
            }
        });
    });
});




$(document).ready(function() {
    $("#USUARIO_TIPO").change(function () {
        let seleccion = $(this).val();

        if (seleccion === "1") { 
            $("#DIV_INFORMACION, #DIV_FOTO, #DIV_DIRRECCION, #DIV_CARGO, #DIV_TELEFONO, #DIV_NACIMIENTO ,#ROLES_COLABORADOR, #DIV_CORREO").show();
            $("#DIV_PROVEDOR,  #DIV_RFC").hide();

            $("#DIV_FOTO").removeClass("col-12").addClass("col-6");
            $("label[for='EMPLEADO_CORREO']").text("Correo de acceso *");

            $("#DIV_INFORMACION input,#DIV_DIRRECCION input, #DIV_CARGO input, #DIV_TELEFONO input, #DIV_NACIMIENTO input").attr("required", true);
            
            $("#DIV_PROVEDOR input").removeAttr("required");

        } else if (seleccion === "2") { 
            $("#DIV_INFORMACION, #DIV_DIRRECCION, #DIV_CARGO, #DIV_TELEFONO, #DIV_NACIMIENTO, #DIV_CORREO").hide();
            $("#DIV_PROVEDOR, #DIV_RFC").show();

            

            $("#DIV_FOTO").removeClass("col-6").addClass("col-12");

            $("#DIV_PROVEDOR input").attr("required", true);
            $("#DIV_RFC input").attr("required", true);


            $("#DIV_INFORMACION input, #DIV_DIRRECCION input, #DIV_CARGO input, #DIV_TELEFONO input, #DIV_NACIMIENTO input").removeAttr("required");
        }
    });

    $("#USUARIO_TIPO").trigger("change");
});


// document.addEventListener("DOMContentLoaded", function () {
//     const btnGenerar = document.getElementById("btnGENERARCONTRASEÑA");

//     btnGenerar.addEventListener("click", function () {
//         const password = Math.floor(100000 + Math.random() * 900000).toString();

//         document.getElementById("PASSWORD").value = password;
//         document.getElementById("PASSWORD_2").value = password;

        
//     });

// });
    



document.addEventListener("DOMContentLoaded", function () {
    const btnGenerar = document.getElementById("btnGENERARCONTRASEÑA");

    btnGenerar.addEventListener("click", function () {
        const numero = Math.floor(100000 + Math.random() * 900000);
        const password = "RES" + numero;

        document.getElementById("PASSWORD").value = password;
        document.getElementById("PASSWORD_2").value = password;
    });
});



$(document).on('input', '#RFC_PROVEEDOR', function () {
    let rfc = $(this).val().trim();

    if (rfc.length > 0) {
        $.ajax({
            url: '/validarRFC',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                RFC_PROVEEDOR: rfc
            },
            success: function (response) {
                if (response.existe) {
                    Swal.fire({
                        icon: 'error',
                        title: 'RFC ya registrado',
                        text: '',
                        confirmButtonText: 'Entendido'
                    });

                    $('#guardarFormUSUARIO').prop('disabled', true); 
                } else {
                    $('#guardarFormUSUARIO').prop('disabled', false); 
                }
            }
        });
    } else {
        $('#guardarFormUSUARIO').prop('disabled', false); 
    }
});
