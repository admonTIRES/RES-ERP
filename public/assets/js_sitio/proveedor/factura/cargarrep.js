ID_FORMULARIO_FACTURACION = 0;





const ModalArea = document.getElementById('miModal_factura')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    
    ID_CATALOGO_TIPOINVENTARIO = 0
    document.getElementById('formularioFACTURA').reset();
   
    document.getElementById('SUBIR_REP').value = "0"; 




})



var ID_FORMULARIO_FACTURACION = null;

var xmlREPValidado = false;

var Tablacargarrecp = $("#Tablacargarrecp").DataTable({

    language: {
        url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
    },

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
        url: '/Tablacargarrecp',

        beforeSend: function () {
            $('#loadingIcon1').css('display', 'inline-block');
        },

        complete: function () {
            $('#loadingIcon1').css('display', 'none');
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
            render: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        },

        { data: 'TIPO_FACTURA_FORMATO' },
        {
            data: null,
            render: function (data, type, row) {
                if (row.ES_GRUPO && row.FACTURAS_AGRUPADAS) {
                    var contenido = '';
                    row.FACTURAS_AGRUPADAS.forEach(function (factura) {
                        contenido +=
                            '<div class="mb-2">' +
                            $('<div>').text(factura.numero || 'Sin número').html() +
                            '</div>';
                    });

                    return contenido;
                }

                return $('<div>')
                    .text(row.FOLIO_FISCAL || row.NO_FACTURA_EXTRANJERO || '')
                    .html();
            }
        },

        {
            data: null,
            render: function (data, type, row) {

                if (row.ES_GRUPO && row.FACTURAS_AGRUPADAS) {

                    var botones = '';

                    row.FACTURAS_AGRUPADAS.forEach(function (factura) {

                        botones +=
                            '<div class="mb-2">' +
                            '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-factura" ' +
                            'data-id="' + factura.id + '" ' +
                            'title="Ver documento">' +
                            '<i class="bi bi-filetype-pdf"></i>' +
                            '</button>' +
                            '</div>';
                    });

                    return botones;
                }

                return row.BTN_FACTURA;
            }
        },

        { data: 'BTN_EDITAR' }

    ],

    columnDefs: [

        {targets: 0,title: '#',className: 'all text-center'},
        {targets: 1,title: 'Factura por',className: 'all text-center nombre-column'},
        {targets: 2,title: 'Folio fiscal',className: 'all text-center'},
        {targets: 3,title: 'Visualizar factura',className: 'all text-center'},
        {targets: 4,title: 'Cargar REP',className: 'all text-center'}

    ]

});


$('#Tablacargarrecp').on('click', '.ver-archivo-factura', function () {
    var id = $(this).data('id');
    if (!id) {
        alert('ARCHIVO NO ENCONTRADO');
        return;
    }
    var url = '/mostrarfactura/' + id;
    abrirModal(url, 'Factura');
})


$('#Tablacargarrecp tbody').on('click', 'button.CARGARREP', function () {

    var tr = $(this).closest('tr');

    if (tr.hasClass('child')) {
        tr = tr.prev();
    }

    var row = Tablacargarrecp.row(tr);

    var datos = row.data();

    if (!datos) {
        return;
    }

    ID_FORMULARIO_FACTURACION = datos.ID_FORMULARIO_FACTURACION;

    var idsFacturas = datos.ES_GRUPO
        ? datos.IDS_FACTURAS_GRUPO
        : [datos.ID_FORMULARIO_FACTURACION];

    document.getElementById('formularioFACTURA').reset();

    xmlREPValidado = false;

    $('#IDS_FACTURAS_REP').val(JSON.stringify(idsFacturas));
    $('#SUBIR_REP').val('1');
    $('#ESTATUS_REP').val('');
    $('#TOTAL_FACTURA').val(datos.TOTAL_FACTURA);
    $('#LISTA_FACTURAS_REP').empty();

    if (datos.FACTURAS_AGRUPADAS) {

        datos.FACTURAS_AGRUPADAS.forEach(function (factura) {

            var elemento = $('<div>').addClass('d-flex justify-content-between border-bottom py-2');

            elemento.append($('<span>').text(factura.numero || 'Sin número'));
            elemento.append($('<strong>').text('$' + parseFloat(factura.total || 0).toFixed(2)));
            $('#LISTA_FACTURAS_REP').append(elemento);
        });
    }

    $('#TOTAL_FACTURAS_REP_TEXTO').text('$' + parseFloat(datos.TOTAL_FACTURA || 0).toFixed(2));

    $('#btnGuardarFactura').prop('disabled', false);
    $('#miModal_factura').modal('show');

});



$("#btnGuardarFactura").click(function (e) {

    e.preventDefault();

    var formularioValido = validarFormulario3($('#formularioFACTURA'));

    if (!formularioValido) {

        alertToast(
            'Por favor, complete todos los campos del formulario.',
            'error',
            2000
        );

        return;
    }

    if (!xmlREPValidado) {

        Swal.fire({
            icon: 'warning',
            title: 'XML pendiente',
            text: 'Debes seleccionar un archivo XML válido.'
        });

        return;
    }

    Swal.fire({

        title: '¿Desea guardar la información?',
        text: 'Se cargará el REP en las facturas seleccionadas.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, guardar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true

    }).then(function (result) {

        if (!result.isConfirmed) {
            return;
        }

        var formulario = document.getElementById('formularioFACTURA');

        var formData = new FormData(formulario);

        $('#btnGuardarFactura').prop('disabled', true);

        Swal.fire({

            icon: 'info',
            title: 'Espere un momento',
            text: 'Estamos cargando los archivos PDF y XML del REP.',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,

            didOpen: function () {
                Swal.showLoading();
            }

        });

        $.ajax({

            url: '/guardarREPFacturas',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            cache: false,

            success: function (response) {

                Swal.close();

                if (response.success) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Información guardada correctamente',
                        text: response.msj,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(function () {

                        $('#miModal_factura').modal('hide');

                        document.getElementById('formularioFACTURA').reset();

                        window.location.reload();

                    });

                } else {

                    $('#btnGuardarFactura').prop('disabled', false);

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.msj || 'No fue posible guardar el REP.'
                    });
                }
            },

            error: function (jqXHR) {

                Swal.close();

                $('#btnGuardarFactura').prop('disabled', false);

                var mensaje = 'Ocurrió un error al guardar los archivos.';

                if (jqXHR.responseJSON) {

                    if (jqXHR.responseJSON.msj) {
                        mensaje = jqXHR.responseJSON.msj;
                    }

                    if (jqXHR.responseJSON.message) {
                        mensaje = jqXHR.responseJSON.message;
                    }
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Error al guardar',
                    text: mensaje
                });
            }

        });

    });

});




$(document).on('change', '#XML_REP', function () {

    const file = this.files[0];

    xmlREPValidado = false;

    if (!file) {
        return;
    }

    $('#btnGuardarFactura').prop('disabled', true);

    const reader = new FileReader();

    reader.onload = function (e) {

        try {

            const xmlText = e.target.result;

            const parser = new DOMParser();

            const xmlDoc = parser.parseFromString(xmlText, "text/xml");

            if (xmlDoc.getElementsByTagName('parsererror').length > 0) {
                throw new Error('XML inválido');
            }

            let montoREP = null;

            const pagos20 = xmlDoc.getElementsByTagName("pago20:Pagos");

            if (pagos20.length > 0) {

                const totales = xmlDoc.getElementsByTagName("pago20:Totales");

                if (totales.length > 0) {

                    montoREP = parseFloat(
                        totales[0].getAttribute("MontoTotalPagos")
                    );
                }
            }

            const pagos10 = xmlDoc.getElementsByTagName("pago10:Pagos");

            if (pagos10.length > 0 && montoREP === null) {

                const pagos = xmlDoc.getElementsByTagName("pago10:Pago");

                if (pagos.length > 0) {

                    montoREP = Array.from(pagos).reduce(function (suma, pago) {
                        return suma + parseFloat(pago.getAttribute("Monto") || 0);
                    }, 0);
                }
            }

            if (montoREP === null || isNaN(montoREP)) {

                Swal.fire({
                    icon: 'error',
                    title: 'XML inválido',
                    text: 'El archivo XML no corresponde a un REP válido.'
                });

                $('#XML_REP').val('');

                $('#btnGuardarFactura').prop('disabled', true);

                return;
            }

            let totalFactura = parseFloat($('#TOTAL_FACTURA').val());

            if (isNaN(totalFactura)) {

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se encontró el total de las facturas.'
                });

                $('#XML_REP').val('');

                $('#btnGuardarFactura').prop('disabled', true);

                return;
            }

            montoREP = parseFloat(montoREP.toFixed(2));

            totalFactura = parseFloat(totalFactura.toFixed(2));

            xmlREPValidado = true;

            $('#btnGuardarFactura').prop('disabled', false);

            Swal.fire({
                icon: 'success',
                title: 'XML válido',
                html:
                    '<b>Total factura:</b> $' + totalFactura.toFixed(2) +
                    '<br><b>Monto REP:</b> $' + montoREP.toFixed(2)
            });

        } catch (error) {

            console.error(error);

            xmlREPValidado = false;

            $('#XML_REP').val('');

            $('#btnGuardarFactura').prop('disabled', true);

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No fue posible leer el XML.'
            });
        }
    };

    reader.onerror = function () {

        xmlREPValidado = false;

        $('#XML_REP').val('');

        $('#btnGuardarFactura').prop('disabled', true);

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No fue posible leer el archivo XML.'
        });
    };

    reader.readAsText(file);

});

