


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
            Tablareciborep.columns.adjust();
            ocultarCarga();
        },

        error: function (jqXHR, textStatus, errorThrown) {
            ocultarCarga();
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },

        dataSrc: 'data'
    },

    order: [[0, 'asc']],

    columns: [

        {
            data: null,
            render: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        },

        {
            data: 'RFC_PROVEEDOR_TEXTO',
            render: function (data) {
                return $('<div>').text(data || '').html();
            }
        },

        {
            data: 'TIPO_FACTURA_FORMATO'
        },

        {
            data: null,

            render: function (data, type, row) {

                if (row.ES_GRUPO) {

                    return row.FACTURAS_AGRUPADAS.map(function (factura) {

                        return '<div class="mb-2">' +
                            $('<div>').text(factura.numero || 'Sin número').html() +
                            '</div>';

                    }).join('');
                }

                return $('<div>')
                    .text(row.FOLIO_FISCAL || row.NO_FACTURA_EXTRANJERO || '')
                    .html();
            }
        },

        {
            data: null,

            render: function (data, type, row) {

                if (row.ES_GRUPO) {

                    return row.FACTURAS_AGRUPADAS.map(function (factura) {

                        return '<div class="mb-2">' +
                            $('<div>').text(factura.fecha || '').html() +
                            '</div>';

                    }).join('');
                }

                return $('<div>')
                    .text(row.FECHA_FACTURA || row.FECHA_FACTURA_EXTRANJERO || '')
                    .html();
            }
        },

        {
            data: null,

            render: function (data, type, row) {

                if (row.ES_GRUPO) {

                    return row.FACTURAS_AGRUPADAS.map(function (factura) {

                        return '<div class="mb-2">' +
                            $('<div>').text(
                                factura.created_at
                                    ? String(factura.created_at).substring(0, 10)
                                    : ''
                            ).html() +
                            '</div>';

                    }).join('');
                }

                return row.created_at
                    ? String(row.created_at).substring(0, 10)
                    : '';
            }
        },

        {
            data: null,

            render: function (data, type, row) {

                return row.FACTURAS_AGRUPADAS.map(function (factura) {

                    if (!factura.factura_pdf) {
                        return '<div class="mb-2">N/A</div>';
                    }

                    return '<div class="mb-2">' +
                        '<button type="button" ' +
                        'class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-factura" ' +
                        'data-id="' + factura.id + '" ' +
                        'title="Ver factura">' +
                        '<i class="bi bi-filetype-pdf"></i>' +
                        '</button>' +
                        '</div>';

                }).join('');
            }
        },

        {
            data: null,

            render: function (data, type, row) {

                if (!row.ARCHIVO_REP || !String(row.ARCHIVO_REP).trim()) {
                    return 'N/A';
                }

                return row.BTN_REP;
            }
        },
        {
            data: null,

            render: function (data, type, row) {

                if (!row.ARCHIVO_RECIBO_PAGO || !String(row.ARCHIVO_RECIBO_PAGO).trim()) {
                    return 'N/A';
                }

                return row.BTN_COMPROBANTE;
            }
        },
        {
            data: 'BTN_VOBO'
        }

    ],

    columnDefs: [
        { targets: 0, title: '#', className: 'all text-center' },
        { targets: 1, title: 'Proveedor', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Factura por', className: 'all text-center nombre-column' },
        { targets: 3, title: 'No. Factura', className: 'all text-center nombre-column' },
        { targets: 4, title: 'Fecha factura', className: 'all text-center nombre-column' },
        { targets: 5, title: 'Fecha de recepción', className: 'all text-center nombre-column' },
        { targets: 6, title: 'Factura', className: 'all text-center' },
        { targets: 7, title: 'Archivo REP', className: 'all text-center' },
        { targets: 8, title: 'Archivo comprobante', className: 'all text-center' },
        { targets: 9, title: 'Estatus', className: 'all text-center' }
    ],

    infoCallback: function (settings, start, end, max, total, pre) {
        return `Total de ${total} registros`;
    }

});




$('#Tablareciborep').on('click', '.ver-archivo-rep', function () {

    var id = $(this).data('id');

    if (!id) {

        Swal.fire({
            icon: 'warning',
            title: 'Sin documento',
            text: 'Este registro no tiene documento.'
        });

        return;
    }

    window.open('/mostrareciboelectronico/' + id, '_blank');

});

$('#Tablareciborep').on('click', '.ver-archivo-factura', function () {

    var id = $(this).data('id');

    if (!id) {

        Swal.fire({
            icon: 'warning',
            title: 'Sin documento',
            text: 'Este registro no tiene documento.'
        });

        return;
    }

    window.open('/mostrarfactura/' + id, '_blank');

});



$('#Tablareciborep').on('click', '.ver-archivo-comprobante', function () {

    var id = $(this).data('id');

    if (!id) {

        Swal.fire({
            icon: 'warning',
            title: 'Sin documento',
            text: 'Este registro no tiene documento.'
        });

        return;
    }

    window.open('/mostrarecibodepago/' + id, '_blank');

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







$('#Tablareciborep').on('click', '.aprobar-rep', function () {

    var row = Tablareciborep.row($(this).closest('tr')).data();

    if (!row) {
        return;
    }

    var ids = row.IDS_FACTURAS_GRUPO;

    Swal.fire({

        title: '¿Aceptar Recibo Electrónico de Pago?',

        text: ids.length > 1
            ? 'Se aprobará el REP de las ' + ids.length + ' facturas agrupadas.'
            : 'El Recibo Electrónico de Pago será aprobado.',

        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar'

    }).then(function (result) {

        if (!result.isConfirmed) {
            return;
        }

        Swal.fire({
            title: 'Espere un momento',
            text: 'Estamos aprobando el REP y notificando al proveedor.',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: function () {
                Swal.showLoading();
            }
        });

        $.ajax({

            url: '/aprobarRechazarREP',
            type: 'POST',

            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                ids: ids,
                estatus: 1
            },

            success: function (resp) {

                Swal.close();

                if (resp.success) {

                    Swal.fire({
                        icon: resp.advertencia ? 'warning' : 'success',
                        title: 'Recibo Electrónico de Pago aprobado',
                        text: resp.advertencia
                            ? resp.message + '. ' + resp.advertencia
                            : resp.message
                    });

                    Tablareciborep.ajax.reload(null, false);

                } else {

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: resp.message
                    });
                }
            },

            error: function (xhr) {

                Swal.close();

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: xhr.responseJSON && xhr.responseJSON.message
                        ? xhr.responseJSON.message
                        : 'Ocurrió un error al aprobar el REP.'
                });
            }
        });
    });
});




$('#Tablareciborep').on('click', '.rechazar-rep', function () {

    var row = Tablareciborep.row($(this).closest('tr')).data();

    if (!row) {
        return;
    }

    var ids = row.IDS_FACTURAS_GRUPO;

    Swal.fire({

        title: 'Rechazar Recibo Electrónico de Pago',

        text: ids.length > 1
            ? 'Se rechazará el REP de las ' + ids.length + ' facturas agrupadas.'
            : 'Se rechazará el Recibo Electrónico de Pago.',

        input: 'textarea',

        inputPlaceholder: 'Escriba el motivo del rechazo...',

        inputAttributes: {
            'aria-label': 'Motivo del rechazo'
        },

        showCancelButton: true,
        confirmButtonText: 'Rechazar',
        cancelButtonText: 'Cancelar',

        inputValidator: function (value) {

            if (!value || !value.trim()) {
                return 'Debe escribir el motivo del rechazo';
            }
        }

    }).then(function (result) {

        if (!result.isConfirmed) {
            return;
        }

        Swal.fire({
            title: 'Espere un momento',
            text: 'Estamos rechazando el REP y notificando al proveedor.',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: function () {
                Swal.showLoading();
            }
        });

        $.ajax({

            url: '/aprobarRechazarREP',
            type: 'POST',

            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                ids: ids,
                estatus: 2,
                justificacion: result.value
            },

            success: function (resp) {

                Swal.close();

                if (resp.success) {

                    Swal.fire({
                        icon: resp.advertencia ? 'warning' : 'success',
                        title: 'Recibo Electrónico de Pago rechazado',
                        text: resp.advertencia
                            ? resp.message + '. ' + resp.advertencia
                            : resp.message
                    });

                    Tablareciborep.ajax.reload(null, false);

                } else {

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: resp.message
                    });
                }
            },

            error: function (xhr) {

                Swal.close();

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: xhr.responseJSON && xhr.responseJSON.message
                        ? xhr.responseJSON.message
                        : 'Ocurrió un error al rechazar el REP.'
                });
            }
        });
    });
});
