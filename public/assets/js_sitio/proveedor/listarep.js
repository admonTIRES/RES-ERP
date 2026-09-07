


var Tablareciborep = $("#Tablareciborep").DataTable({
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
    destroy: true,
    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'Todos']],
    ajax: {
        dataType: 'json',
        data: {},
        method: 'GET',
        cache: false,
        url: '/Tablareciborep',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablareciborep.columns.adjust().draw(); 
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
        { data: 'RFC_PROVEEDOR_TEXTO' },
        { data: 'TIPO_FACTURA_FORMATO' },
        {
            data: null,
            render: function (data, type, row) {
                if (row.FOLIO_FISCAL === null || row.FOLIO_FISCAL === '') {
                    return row.NO_FACTURA_EXTRANJERO;
                }
                return row.FOLIO_FISCAL;
            }
        },
        {
            data: null,
            render: function (data, type, row) {
                if (row.FECHA_FACTURA === null || row.FECHA_FACTURA === '') {
                    return row.FECHA_FACTURA_EXTRANJERO;
                }
                return row.FECHA_FACTURA;
            }
        },
         {
            data: 'created_at',
            render: function (data) {
                if (!data) return '';
                return data.substring(0, 10);
            }
        },
        { data: 'BTN_FACTURA' },
        {
            data: null,
            render: function (data, type, row) {
                if (!row.ARCHIVO_REP || row.ARCHIVO_REP.trim() === '') {
                    return 'N/A';
                }
                return row.BTN_REP;
            }
        },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_VOBO' },
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Proveedor', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Factura por', className: 'all text-center nombre-column' },
        { targets: 3, title: 'No. Factura', className: 'all text-center nombre-column' },
        { targets: 4, title: 'Fecha factura', className: 'all text-center nombre-column' },
        { targets: 5, title: 'Fecha de recepción', className: 'all text-center nombre-column' },
        { targets: 6, title: 'Factura', className: 'all text-center' },
        { targets: 7, title: 'Archivo REP', className: 'all text-center' },
        { targets: 8, title: 'Visualizar', className: 'all text-center' },
        { targets: 9, title: 'Estatus', className: 'all text-center' },
    ],
     infoCallback: function (settings, start, end, max, total, pre) {
        return `Total de ${total} registros`;
    },
});



$('#Tablareciborep').on('click', '.ver-archivo-rep', function () {
    var tr = $(this).closest('tr');
    var row = Tablareciborep.row(tr).data();
    var id = $(this).data('id');

    if (!id || !row.ARCHIVO_REP || row.ARCHIVO_REP.trim() === "") {
        Swal.fire({
            icon: 'warning',
            title: 'Sin documento',
            text: 'Este registro no tiene documento.',
        });
        return;
    }

    var url = '/mostrareciboelectronico/' + id;
    window.open(url, '_blank');
});

$('#Tablareciborep').on('click', '.ver-archivo-factura', function () {
    var tr = $(this).closest('tr');
    var row = Tablareciborep.row(tr).data();
    var id = $(this).data('id');

    if (!id || !row.FACTURA_PDF || row.FACTURA_PDF.trim() === "") {
        Swal.fire({
            icon: 'warning',
            title: 'Sin documento',
            text: 'Este registro no tiene documento.',
        });
        return;
    }

    var url = '/mostrarfactura/' + id;
    window.open(url, '_blank');
});





$(document).on('click', '.VISUALIZAR', function () {

    let tr = $(this).closest('tr');
    let row = Tablareciborep.row(tr).data();

    let id = row.ID_FORMULARIO_FACTURACION;

    $.get('/obtenerDetalleFactura', { id: id }, function (res) {

        let f = res.factura;
        let tipo = res.tipoProveedor;

        $('#camposFactura, #camposFacturaExtranjero')
            .addClass('d-none');

        $('#ID_FORMULARIO_FACTURACION').val(f.ID_FORMULARIO_FACTURACION);
        

        $('#contenedorOC, #contenedorCONTRATO').addClass('d-none');

        $('#contenedorOC input, #contenedorCONTRATO input').prop('required', false);


        if (f.TIPO_FACTURA === 'OC') {

            $('#contenedorOC').removeClass('d-none');

            $('#NO_PO').val(f.NO_PO);
            $('#NO_GR').val(f.NO_GR);

            $('#NO_PO, #NO_GR').prop('required', true);

        } else if (f.TIPO_FACTURA === 'CONTRATO') {

            $('#contenedorCONTRATO').removeClass('d-none');

            $('#NO_CONTRATO').val(f.NO_CONTRATO);
            $('#NO_CONTRATO').prop('required', true);
        }

        
       
        if (tipo == 1) {
            toggleCamposFactura(1);

            $('#camposFactura').removeClass('d-none');
            $('#FOLIO_FISCAL').val(f.FOLIO_FISCAL);
            $('#FECHA_FACTURA').val(f.FECHA_FACTURA);
            $('#METODO_PAGO').val(f.METODO_PAGO);
            $('#MONEDA_FACTURA').val(f.MONEDA_FACTURA);
            $('#SUBTOTAL_FACTURA').val(f.SUBTOTAL_FACTURA);
            $('#IVA_FACTURA').val(f.IVA_FACTURA);
            $('#TOTAL_FACTURA').val(f.TOTAL_FACTURA);
            $('#verXML').removeClass('d-none');
            $('#verSoportePDF').removeClass('d-none');


         } else if (tipo == 2) {
             toggleCamposFactura(2);

            $('#camposFacturaExtranjero').removeClass('d-none');
            $('#NO_FACTURA_EXTRANJERO').val(f.NO_FACTURA_EXTRANJERO);
            $('#FECHA_FACTURA_EXTRANJERO').val(f.FECHA_FACTURA_EXTRANJERO);
            $('#MONEDA_FACTURA_EXTRANJERO').val(f.MONEDA_FACTURA_EXTRANJERO);
            $('#SUBTOTAL_FACTURA_EXTRANJERO').val(f.SUBTOTAL_FACTURA_EXTRANJERO);
            $('#IVA_FACTURA_EXTRANJERO').val(f.IVA_FACTURA_EXTRANJERO);
            $('#TOTAL_FACTURA_EXTRANJERO').val(f.TOTAL_FACTURA_EXTRANJERO);
            $('#verXML').addClass('d-none');
            $('#verSoportePDF').addClass('d-none');    
        }


        $('#verFacturaPDF').attr('href', '/mostrarfactura/' + f.ID_FORMULARIO_FACTURACION);
        $('#verSoportePDF').attr('href', '/mostrarsoportefactura/' + f.ID_FORMULARIO_FACTURACION);

        $('#verXML').attr('href', '/verXMLFactura/' + f.ID_FORMULARIO_FACTURACION + '?download=1');

        $('#ESTATUS_FACTURA').val(f.ESTATUS_FACTURA ?? '');

    
        $('#modalDetalleFactura').modal('show');
    });
});




function toggleCamposFactura(tipo) {

    if (tipo == 1) {
        $('#camposFactura').removeClass('d-none');
        $('#camposFacturaExtranjero').addClass('d-none');

        $('#camposFactura input').prop('required', true);

        $('#camposFacturaExtranjero input').prop('required', false);

    } else if (tipo == 2) {
        $('#camposFacturaExtranjero').removeClass('d-none');
        $('#camposFactura').addClass('d-none');

        $('#camposFacturaExtranjero input').prop('required', true);

        $('#camposFactura input').prop('required', false);
    }
}



$(document).on('click', '.aprobar-rep', function () {

    let id = $(this).data('id');

    Swal.fire({
        title: '¿Aceptar Recibo Electrónico de Pago?',
        text: 'El Recibo Electrónico de Pago será aprobado.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url: '/aprobarRechazarREP',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: id,
                    estatus: 1
                },
                success: function (resp) {

                    if (resp.success) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Recibo Electrónico de Pago aprobado',
                            text: resp.message
                        });

                        Tablareciborep.ajax.reload();

                    } else {

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: resp.message
                        });
                    }
                },
                error: function (xhr) {

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Ocurrió un error al aprobar el Recibo Electrónico de Pago.'
                    });
                }
            });
        }
    });
});


$(document).on('click', '.rechazar-rep', function () {

    let id = $(this).data('id');

    Swal.fire({
        title: 'Rechazar Recibo Electrónico de Pago',
        input: 'textarea',
        inputPlaceholder: 'Escriba el motivo del rechazo...',
        inputAttributes: {
            'aria-label': 'Motivo del rechazo'
        },
        showCancelButton: true,
        confirmButtonText: 'Rechazar',
        cancelButtonText: 'Cancelar',
        inputValidator: (value) => {

            if (!value || !value.trim()) {
                return 'Debe escribir el motivo del rechazo';
            }
        }
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url: '/aprobarRechazarREP',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: id,
                    estatus: 2,
                    justificacion: result.value
                },
                success: function (resp) {

                    if (resp.success) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Recibo Electrónico de Pago rechazado',
                            text: resp.message
                        });

                        Tablareciborep.ajax.reload();

                    } else {

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: resp.message
                        });
                    }
                },
                error: function (xhr) {

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Ocurrió un error al rechazar el Recibo Electrónico de Pago.'
                    });
                }
            });
        }
    });
});