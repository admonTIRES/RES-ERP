ID_ACTUALIZACION_DOCUMENTOS_PROVEEDOR = 0









var Tabladocumentosaprobacionproveedor = $("#Tabladocumentosaprobacionproveedor").DataTable({
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
        url: '/Tabladocumentosaprobacionproveedor',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tabladocumentosaprobacionproveedor.columns.adjust().draw();
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
            { data: 'NOMBRE_USUARIO', className: 'text-center' },
            { data: 'NOMBRE_DOCUMENTO', className: 'text-center' },
            { data: 'BTN_DOCUMENTO' }, 
            { data: 'BTN_APROBACION' },
        ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all text-center' },
            { targets: 1, title: 'Proveedor', className: 'all text-center' },  
            { targets: 2, title: 'Usuario Vo.Bo', className: 'all text-center' },  
            { targets: 3, title: 'Nombre del documento actualizado',  className: 'all text-center nombre-column' },  
            { targets: 4, title: 'Documento actualizado',  className: 'all text-center' },  
            { targets: 5, title: 'Aprobación', className: 'all text-center ' }
    ],
        
});



$('#Tabladocumentosaprobacionproveedor').on('click', '.ver-archivo-documentoactualizado', function () {
    var tr = $(this).closest('tr');
    var row = Tabladocumentosaprobacionproveedor.row(tr).data();
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





$(document).on('click','.aprobar-final',function(){

    let id=$(this).data('id');

    Swal.fire({
        title:'¿Autorizar documento?',
        icon:'question',
        showCancelButton:true,
        confirmButtonText: 'Si autorizar',
        cancelButtonText: 'Cancelar'

    }).then((result)=>{

        if(result.isConfirmed){

            $.ajax({

                url:'/aprobarDocumentoProveedorFinal',
                type:'POST',
                data:{
                    id:id,
                    _token:$('meta[name="csrf-token"]').attr('content')
                },

                success:function(){

                    Tabladocumentosaprobacionproveedor.ajax.reload();

                    Swal.fire(
                        'Autorizado',
                        'Documento autorizado correctamente',
                        'success'
                    );

                }

            });

        }

    });

});


$(document).on('click','.rechazar-final',function(){

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

                url:'/rechazarDocumentoProveedorFinal',
                type:'POST',
                data:{
                    id:id,
                    motivo:result.value,
                    _token:$('meta[name="csrf-token"]').attr('content')
                },

                success:function(){

                    Tabladocumentosaprobacionproveedor.ajax.reload();

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
