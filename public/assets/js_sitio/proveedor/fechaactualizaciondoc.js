ID_ACTUALIZACION_DOCUMENTOS_PROVEEDOR = 0



var actualizacion_id = null;











$("#guardaractulizacion").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioFECHAS'))

    if (formularioValido) {

    if (ID_ACTUALIZACION_DOCUMENTOS_PROVEEDOR == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardaractulizacion')
            await ajaxAwaitFormData({ api: 1, ID_ACTUALIZACION_DOCUMENTOS_PROVEEDOR: ID_ACTUALIZACION_DOCUMENTOS_PROVEEDOR }, 'ActualizarfechasProveedorSave', 'formularioFECHAS', 'guardaractulizacion', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                    ID_ACTUALIZACION_DOCUMENTOS_PROVEEDOR = data.fecha.ID_ACTUALIZACION_DOCUMENTOS_PROVEEDOR
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
            await ajaxAwaitFormData({ api: 1, ID_ACTUALIZACION_DOCUMENTOS_PROVEEDOR: ID_ACTUALIZACION_DOCUMENTOS_PROVEEDOR }, 'ActualizarfechasProveedorSave', 'formularioFECHAS', 'guardaractulizacion', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_ACTUALIZACION_DOCUMENTOS_PROVEEDOR = data.fecha.ID_ACTUALIZACION_DOCUMENTOS_PROVEEDOR
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')


                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});




var Tabladocumentosactualizadosproveedor = $("#Tabladocumentosactualizadosproveedor").DataTable({
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
        url: '/Tabladocumentosactualizadosproveedor',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tabladocumentosactualizadosproveedor.columns.adjust().draw();
            ocultarCarga();
            activarTooltips();

        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
    order: [[0, 'asc']],
      columns: [
            { data: null, render: function (data, type, row, meta) { return meta.row + 1; }, className: 'text-center' },
            { data: 'PROVEEDOR_MOSTRAR', className: 'text-center' },
            { data: 'NOMBRE_DOCUMENTO', className: 'text-center' },
            { data: 'BTN_DOCUMENTO' }, 
            { data: 'BTN_VOBO' },
        ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all text-center' },
            { targets: 1, title: 'Proveedor', className: 'all text-center' },  
            { targets: 2, title: 'Nombre del documento actualizado', className: 'all text-center nombre-column'  },  
            { targets: 3, title: 'Documento actualizado', className: 'all text-center' },  
            { targets: 4, title: 'Vo.Bo', className: 'all text-center' }
    ],
        
});



$('#Tabladocumentosactualizadosproveedor').on('click', '.ver-archivo-documentoactualizado', function () {
    var tr = $(this).closest('tr');
    var row = Tabladocumentosactualizadosproveedor.row(tr).data();
    var id = $(this).data('id');

    if (!id || !row.DOCUMENTO_NUEVO || row.DOCUMENTO_NUEVO.trim() === "") {
        Swal.fire({
            icon: 'warning',
            title: 'Sin documento',
            text: 'Este registro no tiene documento.',
        });
        return;
    }

    var url = '/mostrardocumentoactualizadoproveedor/' + id;
    window.open(url, '_blank');
});





function activarTooltips(){

var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
tooltipTriggerList.map(function (tooltipTriggerEl) {
return new bootstrap.Tooltip(tooltipTriggerEl)
})

}


$(document).on('click','.aprobar-doc',function(){

    let id=$(this).data('id');

        Swal.fire({
            title:'¿Aprobar documento?',
            icon:'question',
            showCancelButton:true,
            confirmButtonText: 'Si aprobar',
            cancelButtonText: 'Cancelar'
        }).then((result)=>{

        if(result.isConfirmed){

        $.ajax({

                url:'/aprobarDocumentoProveedor',
                type:'POST',
                data:{
                id:id,
                _token:$('meta[name="csrf-token"]').attr('content')
            },

            success:function(){

            Tabladocumentosactualizadosproveedor.ajax.reload();

                Swal.fire(
                    'Aprobado',
                    'Documento aprobado correctamente',
                    'success'
                );

            }

        });

        }

    });

});



$(document).on('click','.rechazar-doc',function(){

    let id=$(this).data('id');

        Swal.fire({

        title:'Motivo del rechazo',
        input:'textarea',
        inputPlaceholder:'Escriba el motivo...',
        showCancelButton:true,
        confirmButtonText:'Rechazar',
        confirmButtonColor: '#d33',
        cancelButtonText: 'Cancelar'

        }).then((result)=>{

     if(result.value){

    $.ajax({

        url:'/rechazarDocumentoProveedor',
        type:'POST',
        data:{
        id:id,
        motivo:result.value,
        _token:$('meta[name="csrf-token"]').attr('content')
    },

    success:function(){

    Tabladocumentosactualizadosproveedor.ajax.reload();

            Swal.fire(
            'Rechazado',
            'Se notificó al proveedor',
            'success'
            );

            }

            });

        }

    });

});

