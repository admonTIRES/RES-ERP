




var Tablacomprobantedepago = $("#Tablacomprobantedepago").DataTable({
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
        url: '/Tablacomprobantedepago',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablacomprobantedepago.columns.adjust().draw(); 
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
        {
            data: null,
            render: function (data, type, row) {
                if (!row.DOCUMENTOS_SOPORTE_FACTURA || row.DOCUMENTOS_SOPORTE_FACTURA.trim() === '') {
                    return 'N/A';
                }
                return row.BTN_SOPORTES;
            }
        },
        { data: 'BTN_FACTURA' },
        { data: 'ESTADO_FACTURA_TEXTO' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_SUBIR_RECIBO_PAGO' },

    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Proveedor', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Factura por', className: 'all text-center nombre-column' },
        { targets: 3, title: 'No. Factura', className: 'all text-center nombre-column' },
        { targets: 4, title: 'Fecha factura', className: 'all text-center nombre-column' },
        { targets: 5, title: 'Fecha de recepción', className: 'all text-center nombre-column' },
        { targets: 6, title: 'Soporte', className: 'all text-center' },
        { targets: 7, title: 'Factura', className: 'all text-center' },
        { targets: 8, title: 'Estatus', className: 'all text-center' },
        { targets: 9, title: 'Visualizar', className: 'all text-center' },
        { targets: 10, title: 'Enviar comprobante', className: 'all text-center' },

    ],
     infoCallback: function (settings, start, end, max, total, pre) {
        return `Total de ${total} registros`;
    },
});




$('#Tablacomprobantedepago').on('click', '.ver-archivo-soportes', function () {
    var tr = $(this).closest('tr');
    var row = Tablacomprobantedepago.row(tr).data();
    var id = $(this).data('id');

    if (!id || !row.DOCUMENTOS_SOPORTE_FACTURA || row.DOCUMENTOS_SOPORTE_FACTURA.trim() === "") {
        Swal.fire({
            icon: 'warning',
            title: 'Sin documento',
            text: 'Este registro no tiene documento.',
        });
        return;
    }

    var url = '/mostrarsoportefactura/' + id;
    window.open(url, '_blank');
});

$('#Tablacomprobantedepago').on('click', '.ver-archivo-factura', function () {
    var tr = $(this).closest('tr');
    var row = Tablacomprobantedepago.row(tr).data();
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
    let row = Tablacomprobantedepago.row(tr).data();

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





$(document).on('click', '.SUBIR_RECIBO_PAGO', function () {

    var idFactura = $(this).data('id');
    var proveedor = $(this).data('proveedor');

    $('#formSubirReciboPago')[0].reset();

    $('#ID_FACTURA_RECIBO_PAGO').val(idFactura);
    $('#NOMBRE_PROVEEDOR_RECIBO').text(proveedor);

    $('#ModalSubirReciboPago').modal('show');
});


$('#formSubirReciboPago').on('submit', function (e) {

    e.preventDefault();

    var idFactura = $('#ID_FACTURA_RECIBO_PAGO').val();
    var archivo = $('#ARCHIVO_RECIBO_PAGO')[0].files[0];

    if (!idFactura) {

        Swal.fire({
            icon: 'warning',
            title: 'Factura no seleccionada',
            text: 'No fue posible identificar la factura.'
        });

        return;
    }

    if (!archivo) {

        Swal.fire({
            icon: 'warning',
            title: 'Archivo requerido',
            text: 'Seleccione el comprobante de pago en formato PDF.'
        });

        return;
    }

    var extension = archivo.name
        .split('.')
        .pop()
        .toLowerCase();

    if (extension !== 'pdf') {

        Swal.fire({
            icon: 'warning',
            title: 'Archivo no permitido',
            text: 'El comprobante de pago debe estar en formato PDF.'
        });

        $('#ARCHIVO_RECIBO_PAGO').val('');

        return;
    }

    var formData = new FormData(this);

    Swal.fire({
        title: 'Subiendo comprobante',
        text: 'Espere un momento...',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: function () {
            Swal.showLoading();
        }
    });

    $('#botonGuardarReciboPago')
        .prop('disabled', true);

    $.ajax({
        url: '/cargarcomprobantepago',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        cache: false,

        success: function (response) {

            $('#botonGuardarReciboPago')
                .prop('disabled', false);

            if (response.success) {

                $('#ModalSubirReciboPago').modal('hide');

                $('#formSubirReciboPago')[0].reset();

                Swal.fire({
                    icon: response.correo_enviado ? 'success' : 'warning',
                    title: response.correo_enviado
                        ? 'Comprobante cargado'
                        : 'Comprobante cargado sin correo',
                    text: response.message
                });

                if (
                    typeof Tablacomprobantedepago !== 'undefined' &&
                    Tablacomprobantedepago !== null
                ) {
                    Tablacomprobantedepago.ajax.reload(null, false);
                }

            } else {

                Swal.fire({
                    icon: 'error',
                    title: 'No fue posible guardar',
                    text: response.message
                });
            }
        },

        error: function (xhr) {

            $('#botonGuardarReciboPago')
                .prop('disabled', false);

            var mensaje = 'Ocurrió un error al subir el comprobante.';

            if (
                xhr.responseJSON &&
                xhr.responseJSON.message
            ) {
                mensaje = xhr.responseJSON.message;
            }

            if (
                xhr.status === 422 &&
                xhr.responseJSON &&
                xhr.responseJSON.errors &&
                xhr.responseJSON.errors.ARCHIVO_RECIBO_PAGO
            ) {
                mensaje =
                    xhr.responseJSON.errors.ARCHIVO_RECIBO_PAGO[0];
            }

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: mensaje
            });
        }
    });
});