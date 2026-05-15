
//VARIABLES
ID_CATALOGO_ANUNCIOS = 0




const Modalanuncio = document.getElementById('miModal_anuncio');
    Modalanuncio.addEventListener('hidden.bs.modal', event => {
        ID_CATALOGO_ANUNCIOS = 0;

        document.getElementById('formularioAnuncio').reset();

       

        document.getElementById('TIPO_REPETICION').value = 'normal';
        document.getElementById('campos_normales').style.display = 'block';
        document.getElementById('campos_anual').style.display = 'none';
        document.getElementById('campos_mensual').style.display = 'none';

        $('#miModal_anuncio .modal-title').html('Nuevo anuncio');
    });



$(document).ready(function() {
    $('#NUEVO_ANUNCIO').on('click', function() {
        limpiarFormularioUsuario(); 

        $('#FOTO_ORGANIGRAMA').dropify({
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

        $('#miModal_anuncio').modal('show');
    });

});




function limpiarFormularioUsuario() {
    $('#formularioAnuncio')[0].reset(); 
   
    var drEvent = $('#FOTO_ANUNCIO').dropify().data('dropify');
    drEvent.resetPreview();
    drEvent.clearElement();
}

  document.addEventListener('DOMContentLoaded', function () {
        const tipoRepeticion = document.getElementById('TIPO_REPETICION');

        function limpiarCamposOtros(tipo) {
            if (tipo !== 'normal') {
                document.getElementById('FECHA_INICIO').value = '';
                document.getElementById('FECHA_FIN').value = '';
                document.getElementById('HORA_INICIO').value = '';
                document.getElementById('HORA_FIN').value = '';
            }

            if (tipo !== 'anual') {
                document.getElementById('FECHA_ANUAL').value = '';
                document.getElementById('HORA_ANUAL_INICIO').value = '';
                document.getElementById('HORA_ANUAL_FIN').value = '';
            }

            if (tipo !== 'mensual') {
                document.getElementById('MES_MENSUAL').value = '';
            }
        }

        function mostrarCampos(tipo) {
            document.getElementById('campos_normales').style.display = tipo === 'normal' ? 'block' : 'none';
            document.getElementById('campos_anual').style.display = tipo === 'anual' ? 'block' : 'none';
            document.getElementById('campos_mensual').style.display = tipo === 'mensual' ? 'block' : 'none';

            limpiarCamposOtros(tipo);
        }

        tipoRepeticion.addEventListener('change', function () {
            mostrarCampos(this.value);
        });

        mostrarCampos(tipoRepeticion.value);
    });




  
$("#guardarANUNCIO").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioAnuncio'))

    if (formularioValido) {

    if (ID_CATALOGO_ANUNCIOS == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarANUNCIO')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_ANUNCIOS: ID_CATALOGO_ANUNCIOS }, 'AnuncioSave', 'formularioAnuncio', 'guardarANUNCIO', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                    ID_CATALOGO_ANUNCIOS = data.anuncio.ID_CATALOGO_ANUNCIOS
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_anuncio').modal('hide')
                    document.getElementById('formularioAnuncio').reset();
                     Tablanuncios.ajax.reload()

            })
            
        
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarANUNCIO')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_ANUNCIOS: ID_CATALOGO_ANUNCIOS }, 'AnuncioSave', 'formularioAnuncio', 'guardarANUNCIO', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_CATALOGO_ANUNCIOS = data.anuncio.ID_CATALOGO_ANUNCIOS
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_anuncio').modal('hide')
                    document.getElementById('formularioAnuncio').reset();
                     Tablanuncios.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});


var Tablanuncios = $("#Tablanuncios").DataTable({
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
        url: '/Tablanuncios',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablanuncios.columns.adjust().draw();
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
        { data: 'TITULO_ANUNCIO' },
        { data: 'DESCRIPCION_ANUNCIO' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Título del anuncio', className: 'all text-center ' },
        { targets: 2, title: 'Descripción', className: 'all text-center descripcion-column' },
        { targets: 3, title: 'Editar', className: 'all text-center descripcion-colum' },
        { targets: 4, title: 'Activo', className: 'all text-center' }
    ]
});



$('#Tablanuncios tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablanuncios.row(tr);

    ID_CATALOGO_ANUNCIOS = row.data().ID_CATALOGO_ANUNCIOS;

    editarDatoTabla(row.data(), 'formularioAnuncio', 'miModal_anuncio',1);




    $('#miModal_anuncio .modal-title').html(row.data().TITULO_ANUNCIO);


       var tipo = row.data().TIPO_REPETICION;

        $('#TIPO_REPETICION').val(tipo);

        if (tipo === 'anual') {
            $('#campos_anual').show();
            $('#campos_normales, #campos_mensual').hide();

            $('#campos_normales, #campos_mensual').find('[required]').removeAttr('required');

        } else if (tipo === 'mensual') {
            $('#campos_mensual').show();
            $('#campos_normales, #campos_anual').hide();

            $('#campos_normales, #campos_anual').find('[required]').removeAttr('required');

        } else {
            // normal o vacío
            $('#campos_normales').show();
            $('#campos_anual, #campos_mensual').hide();

            $('#campos_anual, #campos_mensual').find('[required]').removeAttr('required');
        }
    
      if (row.data().FOTO_ANUNCIO) {
        var archivo = row.data().FOTO_ANUNCIO;
        var extension = archivo.substring(archivo.lastIndexOf("."));
        var imagenUrl = '/anunciofoto/' + row.data().ID_CATALOGO_ANUNCIOS + extension;

        if ($('#FOTO_ANUNCIO').data('dropify')) {
            $('#FOTO_ANUNCIO').dropify().data('dropify').destroy();
            $('#FOTO_ANUNCIO').dropify().data('dropify').settings.defaultFile = imagenUrl;
            $('#FOTO_ANUNCIO').dropify().data('dropify').init();
        } else {
            $('#FOTO_ANUNCIO').attr('data-default-file', imagenUrl);
            $('#FOTO_ANUNCIO').dropify({
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
        $('#FOTO_ANUNCIO').dropify().data('dropify').resetPreview();
        $('#FOTO_ANUNCIO').dropify().data('dropify').clearElement();
    }




});




$('#Tablanuncios tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablanuncios.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_CATALOGO_ANUNCIOS: row.data().ID_CATALOGO_ANUNCIOS
    };

    eliminarDatoTabla(data, [Tablanuncios], 'AnuncioDelete');
});
