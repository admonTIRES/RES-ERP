ID_ACTUALIZACION_DOCUMENTOS = 0



var actualizacion_id = null;


$(document).ready(function () {

    $('#TIPO_DOCUMENTO').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });
  
});









$("#guardaractulizacion").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioFECHAS'))

    if (formularioValido) {

    if (ID_ACTUALIZACION_DOCUMENTOS == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardaractulizacion')
            await ajaxAwaitFormData({ api: 1, ID_ACTUALIZACION_DOCUMENTOS: ID_ACTUALIZACION_DOCUMENTOS }, 'ActualizarfechasSave', 'formularioFECHAS', 'guardaractulizacion', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                    ID_ACTUALIZACION_DOCUMENTOS = data.fecha.ID_ACTUALIZACION_DOCUMENTOS
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)

                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardaractulizacion')
            await ajaxAwaitFormData({ api: 1, ID_ACTUALIZACION_DOCUMENTOS: ID_ACTUALIZACION_DOCUMENTOS }, 'ActualizarfechasSave', 'formularioFECHAS', 'guardaractulizacion', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_ACTUALIZACION_DOCUMENTOS = data.fecha.ID_ACTUALIZACION_DOCUMENTOS
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')


                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});




var Tabladocumentosactualizados = $("#Tabladocumentosactualizados").DataTable({
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
        url: '/Tabladocumentosactualizados',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tabladocumentosactualizados.columns.adjust().draw();
            ocultarCarga();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
    order: [[0, 'asc']],
      columns: [
        { data: null, render: function (data, type, row, meta) { return meta.row + 1; }, className: 'text-center' },
        { data: 'NOMBRE_COMPLETO', className: 'text-center' },
        { data: 'NOMBRE_DOCUMENTO', className: 'text-center' },  
        { data: 'BTN_DOCUMENTO' }, 
        { data: 'BTN_EDITAR' },

        ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all text-center' },
            { targets: 1, title: 'Nombre del colaborador', className: 'all text-center' },  
            { targets: 2, title: 'Nombre del documento', className: 'all text-center' },  
            { targets: 3, title: 'Documento actualizado', className: 'all text-center' },  
            { targets: 4, title: 'Visualizar', className: 'all text-center' }
        ]
});



const Modaldocumentosoporte = document.getElementById('miModal_DOCUMENTOS_SOPORTE')
Modaldocumentosoporte.addEventListener('hidden.bs.modal', event => {
    
    ID_DOCUMENTOS_ACTUALIZADOS = 0
    
    document.getElementById('formularioDOCUMENTOS').reset();
   
    $('#miModal_DOCUMENTOS_SOPORTE .modal-title').html('Documento de soporte');

    $('#NOMBRE_DOCUMENTO').prop('readonly', false); 




    document.getElementById('FECHAS_SOPORTEDOCUMENTOS').style.display = 'none';


    actualizacion_id = 0; 

})


document.addEventListener('DOMContentLoaded', function () {

    const contenedorFechas = document.getElementById('FECHAS_SOPORTEDOCUMENTOS');

    document.querySelectorAll('input[name="PROCEDE_FECHA_DOC"]').forEach(function (radio) {
        radio.addEventListener('change', function () {

            if (this.value === "1") {
                contenedorFechas.style.display = 'block';
            } else {
                contenedorFechas.style.display = 'none';
            }

        });
    });

});


document.addEventListener('DOMContentLoaded', function() {
    var archivoSoporte = document.getElementById('DOCUMENTO_SOPORTE');
    var quitarSoporte = document.getElementById('quitar_documento');
    var errorElement = document.getElementById('DOCUMENTO_ERROR');

    if (archivoSoporte) {
        archivoSoporte.addEventListener('change', function() {
            var archivo = this.files[0];
            if (archivo && archivo.type === 'application/pdf') {
                if (errorElement) errorElement.style.display = 'none';
                if (quitarSoporte) quitarSoporte.style.display = 'block';
            } else {
                if (errorElement) errorElement.style.display = 'block';
                this.value = '';
                if (quitarSoporte) quitarSoporte.style.display = 'none';
            }
        });
        quitarSoporte.addEventListener('click', function() {
            archivoSoporte.value = ''; 
            quitarSoporte.style.display = 'none'; 
            if (errorElement) errorElement.style.display = 'none'; 
        });
    }
});


$('#Tabladocumentosactualizados').on('click', '.ver-archivo-documentosactualizados', function () {
    var tr = $(this).closest('tr');
    var row = Tabladocumentosactualizados.row(tr);
    var id = $(this).data('id');

    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }

    var nombreDocumentoSoporte = row.data().NOMBRE_DOCUMENTO;
    var url = '/mostrardocumentoactualizado/' + id;
    
    abrirModal(url, nombreDocumentoSoporte);
});




$('#Tabladocumentosactualizados').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tabladocumentosactualizados.row(tr);

    ID_DOCUMENTOS_ACTUALIZADOS = row.data().ID_DOCUMENTOS_ACTUALIZADOS;

    actualizacion_id = row.data().ID_DOCUMENTOS_ACTUALIZADOS;

    editarDatoTabla(row.data(), 'formularioDOCUMENTOS', 'miModal_DOCUMENTOS_SOPORTE', 1);

    $('#miModal_DOCUMENTOS_SOPORTE .modal-title').html(row.data().NOMBRE_DOCUMENTO);

    $('#NOMBRE_DOCUMENTO').prop('readonly', true); 

    if (row.data().PROCEDE_FECHA_DOC === "1") {
        $('#FECHAS_SOPORTEDOCUMENTOS').show();
    } else {
        $('#FECHAS_SOPORTEDOCUMENTOS').hide();
    }


});




function darVistoBueno() {

    if (!actualizacion_id) {
        Swal.fire('Error', 'No se encontró el documento.', 'error');
        return;
    }

    Swal.fire({
        title: '¿Aceptar documento?',
        text: 'Esta acción aprobará el documento y actualizará la información oficial.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, aceptar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url: '/aceptarDocumentoActualizado',
                type: 'POST',
                data: {
                    ID_DOCUMENTOS_ACTUALIZADOS: actualizacion_id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {

                    if (response.status === 'success') {

                        Swal.fire({
                            icon: 'success',
                            title: 'Documento aceptado',
                            text: response.message
                        });

                        $('#miModal_DOCUMENTOS_SOPORTE').modal('hide');

                        Tabladocumentosactualizados.ajax.reload(null, false);

                    } else {

                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function (xhr) {

                    console.error(xhr.responseText);

                    Swal.fire(
                        'Error',
                        'Ocurrió un error al aceptar el documento.',
                        'error'
                    );
                }
            });

        }

    });
}


function rechazarVistoBueno() {

    if (!actualizacion_id) {
        Swal.fire('Error', 'No se encontró el documento.', 'error');
        return;
    }

    Swal.fire({
        title: '¿Rechazar documento?',
        text: 'Esta acción desactivará el documento.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, rechazar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url: '/rechazarDocumentoActualizado',
                type: 'POST',
                data: {
                    ID_DOCUMENTOS_ACTUALIZADOS: actualizacion_id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {

                    if (response.status === 'success') {

                        Swal.fire({
                            icon: 'success',
                            title: 'Documento rechazado',
                            text: response.message
                        });

                        $('#miModal_DOCUMENTOS_SOPORTE').modal('hide');

                        Tabladocumentosactualizados.ajax.reload(null, false);

                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    Swal.fire(
                        'Error',
                        'Ocurrió un error al rechazar el documento.',
                        'error'
                    );
                }
            });

        }

    });
}
