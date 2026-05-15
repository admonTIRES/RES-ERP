ID_FORMULARIO_INSTALACIONES = 0


const Modalinstalaciones = document.getElementById('Modal_instalaciones')
Modalinstalaciones.addEventListener('hidden.bs.modal', event => {
    
    ID_FORMULARIO_INSTALACIONES = 0
    document.getElementById('formularioINSTALACIONES').reset();
   
    $('#PROVEEDORES_ACTIVOS').hide();
    $('#ESCRIBIR_PROVEEDOR').hide();

    $('#Modal_instalaciones .modal-title').html('Nueva instalación');

})



function obtenerModalPadre(elemento) {
    const modalBody = $(elemento).closest(".modal-body");

    if (modalBody.length > 0) {
        return modalBody; 
    }

    const modal = $(elemento).closest(".modal");

    if (modal.length > 0) {
        return modal;
    }

    return $("body");
}



function initSelectProveedor() {

    const select = $('#PROVEEDOR_INSTALACION');

    if (select.hasClass("select2-hidden-accessible")) {
        select.select2('destroy');
    }

    select.select2({
        dropdownParent: obtenerModalPadre(select),
        width: '100%',
        placeholder: 'Seleccionar proveedor',
        allowClear: true
    });
}




$(document).ready(function() {
    $('#NUEVO_INSTALACION').on('click', function() {
        limpiarformularioINSTALACIONES(); 

        initSelectProveedor();

        
        $('#FOTO_INSTALACION').dropify({
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

        $('#PROVEEDORES_ACTIVOS').hide();
        $('#ESCRIBIR_PROVEEDOR').hide();

        $('#Modal_instalaciones').modal('show');
       

    });

});

function limpiarformularioINSTALACIONES() {
    $('#formularioINSTALACIONES')[0].reset(); 

    var drEvent = $('#FOTO_INSTALACION').data('dropify');
    if (drEvent) {
        drEvent.resetPreview();
        drEvent.clearElement();
    }
}


document.addEventListener('DOMContentLoaded', function () {

    const selectproveedores = document.getElementById('PROVEEDOR_ALTA');
    const divProveedorinterno = document.getElementById('PROVEEDORES_ACTIVOS');
    const divEscribirExterno = document.getElementById('ESCRIBIR_PROVEEDOR');

    selectproveedores.addEventListener('change', function () {

        if (this.value === "1") {
            divProveedorinterno.style.display = 'block';
            divEscribirExterno.style.display = 'none';
        }

        if (this.value === "2") {
            divProveedorinterno.style.display = 'none';
            divEscribirExterno.style.display = 'block';
        }

    });

});


$("#guardarINSTALACIONES").click(function (e) {
    e.preventDefault();


            formularioValido = validarFormulario3($('#formularioINSTALACIONES'))

    if (formularioValido) {

    if (ID_FORMULARIO_INSTALACIONES == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarINSTALACIONES')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_INSTALACIONES: ID_FORMULARIO_INSTALACIONES }, 'MttoInstalacionSave', 'formularioINSTALACIONES', 'guardarINSTALACIONES', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_FORMULARIO_INSTALACIONES = data.cliente.ID_FORMULARIO_INSTALACIONES
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#Modal_instalaciones').modal('hide')    
                    document.getElementById('formularioINSTALACIONES').reset();
                    Tablalistainstalacion.ajax.reload()
            })
            
                        
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarINSTALACIONES')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_INSTALACIONES: ID_FORMULARIO_INSTALACIONES }, 'MttoInstalacionSave', 'formularioINSTALACIONES', 'guardarINSTALACIONES', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_FORMULARIO_INSTALACIONES = data.cliente.ID_FORMULARIO_INSTALACIONES
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#Modal_instalaciones').modal('hide')
                    document.getElementById('formularioINSTALACIONES').reset();
                     Tablalistainstalacion.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});



var Tablalistainstalacion = $("#Tablalistainstalacion").DataTable({
      language: {
        url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
    },
    scrollX: true,
    autoWidth: false,
    responsive: false,
    paging: true,
    searching: true,
    filtering: true,
    lengthChange: true,
    info: true,   
    scrollY: false,
    scrollCollapse: false,
    fixedHeader: false,    
    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'Todos']],
    ajax: {
        dataType: 'json',
        method: 'GET',
        url: '/Tablalistainstalacion',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablalistainstalacion.columns.adjust().draw();
            ocultarCarga();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
    columnDefs: [
        { targets: '_all', className: 'text-center' }, 
        { targets: 0,  width:  '50px' },
        { targets: 1,  width:  '250px' },
        { targets: 2,  width:  '120px'},
        { targets: 3,  width:  '120px'},
        { targets: 4,  width:  '120px'},
        { targets: 5,  width:  '120px'}                               
    ],
    columns: [
        { 
            data: null,
            render: function(data, type, row, meta) {
                return meta.row + 1; 
            }
        },
        { data: 'DESCRIPCION_INSTALACION' },
        { data: 'UBICACION_INSTALACION' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
        
       
  ],
    createdRow: function (row, data) {
        $(row).addClass(data.ROW_CLASS);
    },
      infoCallback: function (settings, start, end, max, total, pre) {
            return `Total de ${total} registros`;
    },
    drawCallback: function () {
        const topScroll = document.querySelector('.tabla-scroll-top');
        const scrollInner = document.querySelector('.tabla-scroll-top .scroll-inner');
        const table = document.querySelector('#Tablalistainstalacion');
        const scrollBody = document.querySelector('.dataTables_scrollBody');

        if (!topScroll || !scrollInner || !table || !scrollBody) return;

        const tableWidth = table.scrollWidth;

        scrollInner.style.width = tableWidth + 'px';

        let syncingTop = false;
        let syncingBottom = false;

        topScroll.addEventListener('scroll', function () {
            if (syncingTop) return;
            syncingBottom = true;
            scrollBody.scrollLeft = topScroll.scrollLeft;
            syncingBottom = false;
        });

        scrollBody.addEventListener('scroll', function () {
            if (syncingBottom) return;
            syncingTop = true;
            topScroll.scrollLeft = scrollBody.scrollLeft;
            syncingTop = false;
        });
    }


});




$('#Tablalistainstalacion tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablalistainstalacion.row(tr);

    ID_FORMULARIO_INSTALACIONES = row.data().ID_FORMULARIO_INSTALACIONES;

    editarDatoTabla(row.data(), 'formularioINSTALACIONES', 'Modal_instalaciones', 1);


     if (row.data().FOTO_INSTALACION) {
        var archivo = row.data().FOTO_INSTALACION;
        var extension = archivo.substring(archivo.lastIndexOf("."));
        var imagenUrl = '/mostrarFotoInstalacion/' + row.data().ID_FORMULARIO_INSTALACIONES + extension;

        if ($('#FOTO_INSTALACION').data('dropify')) {
            $('#FOTO_INSTALACION').dropify().data('dropify').destroy();
            $('#FOTO_INSTALACION').dropify().data('dropify').settings.defaultFile = imagenUrl;
            $('#FOTO_INSTALACION').dropify().data('dropify').init();
        } else {
            $('#FOTO_INSTALACION').attr('data-default-file', imagenUrl);
            $('#FOTO_INSTALACION').dropify({
                messages: {
                    'default': 'Arrastre la imagen aquí o haga click',
                    'replace': 'Arrastre la imagen o haga clic para reemplazar',
                    'remove': 'Quitar',
                    'error': 'Ooops, ha ocurrido un error.'
                }
            });
        }
    } else {
        $('#FOTO_INSTALACION').dropify().data('dropify').resetPreview();
        $('#FOTO_INSTALACION').dropify().data('dropify').clearElement();
    }


    $('#Modal_instalaciones .modal-title').html(row.data().DESCRIPCION_INSTALACION);


    if (row.data().PROVEEDOR_ALTA == 1) {
        $('#PROVEEDORES_ACTIVOS').show();
        $('#ESCRIBIR_PROVEEDOR').hide();
         
        initSelectProveedor();

        if (row.data().PROVEEDOR_INSTALACION) {
        $('#PROVEEDOR_INSTALACION')
            .val(row.data().PROVEEDOR_INSTALACION)
            .trigger('change');
         }
         
    } else {
        $('#PROVEEDORES_ACTIVOS').hide();
        $('#ESCRIBIR_PROVEEDOR').show();
    }


});



$(document).ready(function() {
    $('#Tablalistainstalacion tbody').on('click', 'td>button.VISUALIZAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablalistainstalacion.row(tr);
        
    hacerSoloLecturainventario(row.data(), '#Modal_instalaciones');
    
    ID_FORMULARIO_INSTALACIONES = row.data().ID_FORMULARIO_INSTALACIONES;

    editarDatoTabla(row.data(), 'formularioINSTALACIONES', 'Modal_instalaciones', 1);


     if (row.data().FOTO_INSTALACION) {
        var archivo = row.data().FOTO_INSTALACION;
        var extension = archivo.substring(archivo.lastIndexOf("."));
        var imagenUrl = '/mostrarFotoInstalacion/' + row.data().ID_FORMULARIO_INSTALACIONES + extension;

        if ($('#FOTO_INSTALACION').data('dropify')) {
            $('#FOTO_INSTALACION').dropify().data('dropify').destroy();
            $('#FOTO_INSTALACION').dropify().data('dropify').settings.defaultFile = imagenUrl;
            $('#FOTO_INSTALACION').dropify().data('dropify').init();
        } else {
            $('#FOTO_INSTALACION').attr('data-default-file', imagenUrl);
            $('#FOTO_INSTALACION').dropify({
                messages: {
                    'default': 'Arrastre la imagen aquí o haga click',
                    'replace': 'Arrastre la imagen o haga clic para reemplazar',
                    'remove': 'Quitar',
                    'error': 'Ooops, ha ocurrido un error.'
                }
            });
        }
    } else {
        $('#FOTO_INSTALACION').dropify().data('dropify').resetPreview();
        $('#FOTO_INSTALACION').dropify().data('dropify').clearElement();
    }


    $('#Modal_instalaciones .modal-title').html(row.data().DESCRIPCION_INSTALACION);


    if (row.data().PROVEEDOR_ALTA == 1) {
        $('#PROVEEDORES_ACTIVOS').show();
        $('#ESCRIBIR_PROVEEDOR').hide();
         
        initSelectProveedor();

        if (row.data().PROVEEDOR_INSTALACION) {
        $('#PROVEEDOR_INSTALACION')
            .val(row.data().PROVEEDOR_INSTALACION)
            .trigger('change');
         }
         
    } else {
        $('#PROVEEDORES_ACTIVOS').hide();
        $('#ESCRIBIR_PROVEEDOR').show();
    }

        
    });

    $('#Modal_instalaciones').on('hidden.bs.modal', function () {
        resetFormulario('#Modal_instalaciones');
    });
});


$('#Tablalistainstalacion tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablalistainstalacion.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_FORMULARIO_INSTALACIONES: row.data().ID_FORMULARIO_INSTALACIONES
    };

    eliminarDatoTabla(data, [Tablalistainstalacion], 'MttoInstalacionDelete');
});

