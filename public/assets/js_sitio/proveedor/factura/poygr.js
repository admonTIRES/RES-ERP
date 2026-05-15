
var Tablapoproveedor = $("#Tablapoproveedor").DataTable({
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
        url: '/Tablapoproveedor',
        beforeSend: function () {
            $('#loadingIcon1').css('display', 'inline-block');
        },
        complete: function () {
            $('#loadingIcon1').css('display', 'none');
            Tablapoproveedor.columns.adjust().draw(); 
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
        { data: 'NO_PO' },
        { data: 'FECHA_EMISION' },
        { data: 'DESCARGA_PO' },
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'No. Orden de Compra', className: 'all text-center' },
        { targets: 2, title: 'Fecha de emisión', className: 'all text-center' },
        { targets: 3, title: 'Descargar orden', className: 'all text-center' },
    ]
});

$(document).on('click', '.pdf-po', function () {

    const id = $(this).data('id');

    if (!id) {
        Swal.fire('Error', 'ID no válido', 'error');
        return;
    }

    Swal.fire({
        title: 'Descargando PDF...',
        text: 'Por favor espere',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    window.location.href = `/generarPDFPO/${id}`;

    setTimeout(() => {
        Swal.close();
    }, 1500);
});

var Tablagrproveedor = $("#Tablagrproveedor").DataTable({
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
        url: '/Tablagrproveedor',
        beforeSend: function () {
            $('#loadingIcon2').css('display', 'inline-block');
        },
        complete: function () {
            $('#loadingIcon2').css('display', 'none');
            Tablagrproveedor.columns.adjust().draw(); 
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('#loadingIcon2').css('display', 'none');
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
        { data: 'NO_PO' },
        { data: 'NO_RECEPCION' },
        { data: 'FECHA_EMISION' },
        { data: 'DESCARGA_GR' },
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'No. Orden de Compra', className: 'all text-center' },
        { targets: 2, title: 'No. Recepción', className: 'all text-center' },
        { targets: 3, title: 'Fecha de emisión', className: 'all text-center' },
        { targets: 4, title: 'Descargar Recepción', className: 'all text-center' },
    ]
});

$(document).on('click', '.pdf-gr', function () {

    const id = $(this).data('id');

    if (!id) {
        Swal.fire('Error', 'ID no válido', 'error');
        return;
    }

    Swal.fire({
        title: 'Descargando PDF...',
        text: 'Por favor espere',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    window.location.href = `/generarGRpdf/${id}`;

    setTimeout(() => {
        Swal.close();
    }, 1500);
});






