ID_RELACION_PAGOS = 0


const ModalRelacion = document.getElementById('modalRelacionPagos')
ModalRelacion.addEventListener('hidden.bs.modal', event => {

    ID_RELACION_PAGOS = 0

    document.getElementById('formularioRELACION').reset();   

    $('#tablaRelacionPagos tbody').empty();


    $('#JSON_RELACIONES').val('');


})

$("#NUEVA_RELACION").click(function (e) {
    e.preventDefault();

    $("#modalRelacionPagos").modal("show");

    document.getElementById('formularioRELACION').reset();

    $('#tablaRelacionPagos tbody').empty();

    cargarTablaRelacionPagos();

    $('#JSON_RELACIONES').val('');

});


function cargarTablaRelacionPagos() {

    $.get('/getFacturasRelacionPagos', function (data) {

        let html = '';

        data.forEach(function (item) {

            html += `

                <tr 
                    data-idfactura="${item.ID_FORMULARIO_FACTURACION}"
                    data-manual="0">

                    <td class="text-center">
                        <button type="button"class="btn btn-secondary btn-sm"disabled>
                            <i class="bi bi-lock-fill"></i>
                        </button>
                    </td>
                    <td class="text-center">
                        <input type="checkbox" class="form-check-input seleccionar-factura" value="${item.ID_FORMULARIO_FACTURACION}">
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm mydatepicker fecha-factura" value="${item.FECHA_FACTURA ?? ''}">
                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                        </div>
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm input-pago folio-fiscal" value="${item.FOLIO_FISCAL ?? ''}">
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm input-pago razon-social" value="${item.RAZON_SOCIAL_ALTA ?? ''}">
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm input-pago rfc-proveedor" value="${item.RFC_PROVEEDOR ?? ''}">
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm input-pago subtotal-factura"value="${item.SUBTOTAL ?? ''}">
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm input-pago iva-factura" value="${item.IVA ?? ''}">
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm input-pago total-factura" value="${item.TOTAL ?? ''}">
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm input-pago moneda-factura" value="${item.MONEDA ?? ''}">
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm mydatepicker fecha-recepcion" value="${item.FECHA_RECEPCION ?? ''}">
                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                        </div>
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm input-pago dias-credito" value="${item.DIAS_CREDITO ?? ''}">
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm input-pago banco-factura" value="${item.BANCO ?? ''}">
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm input-pago cuenta-factura" value="${item.NO_CUENTA ?? ''}">
                    </td>
                </tr>
            `;
        });

        $('#tablaRelacionPagos tbody').html(html);
        activarDatePickerRelacion();
        calcularTotalesRelacion();

    });
}


$(document).on('click', '#agregarPagoManual', function () {

    let fila = `

        <tr 
            class="fila-pago-manual"
            data-idfactura="0"
            data-manual="1">
            <td class="text-center">
                <button type="button"class="btn btn-danger btn-sm eliminarPagoManual">
                    <i class="bi bi-trash3-fill"></i>
                </button>
            </td>
            <td class="text-center">
                <input type="checkbox" class="form-check-input seleccionar-factura" checked>
            </td>
            <td>
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm mydatepicker fecha-factura" placeholder="aaaa-mm-dd">
                    <span class="input-group-text"> <i class="bi bi-calendar-event"></i></span>
                </div>
            </td>
            <td>
                <input type="text" class="form-control form-control-sm input-pago folio-fiscal" placeholder="Factura / Folio">
            </td>
            <td>
                <input type="text" class="form-control form-control-sm input-pago razon-social" placeholder="Razón social">
            </td>
            <td>
                <input type="text" class="form-control form-control-sm input-pago rfc-proveedor" placeholder="RFC">
            </td>
            <td>
                <input type="text" class="form-control form-control-sm input-pago subtotal-factura" placeholder="Subtotal">
            </td>
            <td>
                <input type="text" class="form-control form-control-sm input-pago iva-factura" placeholder="IVA">
            </td>
            <td>
                <input type="text" class="form-control form-control-sm input-pago total-factura" placeholder="Total">
            </td>
            <td>
                <input type="text" class="form-control form-control-sm input-pago moneda-factura" placeholder="Moneda">
            </td>
            <td>
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm mydatepicker fecha-recepcion" placeholder="aaaa-mm-dd">
                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                </div>
            </td>
            <td>
                <input type="text" class="form-control form-control-sm input-pago dias-credito" placeholder="Días">
            </td>
            <td>
                <input type="text" class="form-control form-control-sm input-pago banco-factura" placeholder="Banco">
            </td>
            <td>
                <input type="text" class="form-control form-control-sm input-pago cuenta-factura" placeholder="Cuenta bancaria">

            </td>

        </tr>
    `;

    $('#tablaRelacionPagos tbody').append(fila);

    activarDatePickerRelacion();

    calcularTotalesRelacion();

});




$(document).on('click', '.eliminarPagoManual', function () {

    $(this).closest('tr').remove();

    calcularTotalesRelacion();

});




function activarDatePickerRelacion() {

    $('.mydatepicker').datepicker({
        format: 'yyyy-mm-dd',
        weekStart: 1,
        autoclose: true,
        todayHighlight: true,
        language: 'es'

    });

    $('.mydatepicker').off('click').on('click', function () {

        $(this).datepicker(
            'setDate',
            $(this).val()
        );

    });

}


function calcularTotalesRelacion() {

    let totalMXN = 0;

    let totalUSD = 0;


    $('#tablaRelacionPagos tbody tr').each(function () {

        let checked = $(this)
            .find('.seleccionar-factura')
            .is(':checked');

        if (!checked) return;


        let total = $(this)
            .find('.total-factura')
            .val();

        total = parseFloat(
            String(total).replace(/,/g, '')
        );

        if (isNaN(total)) {

            total = 0;
        }


        let moneda = $(this)
            .find('.moneda-factura')
            .val();

        moneda = String(moneda)
            .trim()
            .toUpperCase();

        if (moneda == 'MXN') {

            totalMXN += total;

        } else if (moneda == 'USD') {

            totalUSD += total;
        }

    });

    $('#MONTO_MXN').val(totalMXN);

    $('#MONTO_USD').val(totalUSD);

}


$(document).on(
    'keyup change',
    '.seleccionar-factura, .total-factura, .moneda-factura',
    function () {

        calcularTotalesRelacion();

    }
);




function obtenerFacturasRelacion() {

    let facturas = [];


    $('#tablaRelacionPagos tbody tr').each(function () {

        let checked = $(this)
            .find('.seleccionar-factura')
            .is(':checked');

        if (!checked) return;


        facturas.push({

            ID_FORMULARIO_FACTURACION :

                $(this).attr('data-idfactura'),

            MANUAL :

                $(this).attr('data-manual'),

            FECHA_FACTURA :

                $(this)
                    .find('.fecha-factura')
                    .val(),

            FOLIO_FISCAL :

                $(this)
                    .find('.folio-fiscal')
                    .val(),

            RAZON_SOCIAL :

                $(this)
                    .find('.razon-social')
                    .val(),

            RFC :

                $(this)
                    .find('.rfc-proveedor')
                    .val(),

            SUBTOTAL :

                $(this)
                    .find('.subtotal-factura')
                    .val(),

            IVA :

                $(this)
                    .find('.iva-factura')
                    .val(),

            TOTAL :

                $(this)
                    .find('.total-factura')
                    .val(),

            MONEDA :

                $(this)
                    .find('.moneda-factura')
                    .val(),

            FECHA_RECEPCION :

                $(this)
                    .find('.fecha-recepcion')
                    .val(),

            DIAS_CREDITO :

                $(this)
                    .find('.dias-credito')
                    .val(),

            BANCO :

                $(this)
                    .find('.banco-factura')
                    .val(),

            NO_CUENTA :

                $(this)
                    .find('.cuenta-factura')
                    .val()

        });

    });

    return facturas;
}






$("#guardarRELACION").click(function (e) {

    e.preventDefault();

    formularioValido = validarFormulario3($('#formularioRELACION'))

    if (formularioValido) {


        let facturas = obtenerFacturasRelacion();

        $('#JSON_RELACIONES').remove();

        $('<input>')
            .attr({
                type: 'hidden',
                id: 'JSON_RELACIONES',
                name: 'JSON_RELACIONES',
                value: JSON.stringify(facturas)
            })
            .appendTo('#formularioRELACION');



    if (ID_RELACION_PAGOS == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 
            await loaderbtn('guardarRELACION')
            await ajaxAwaitFormData({ api: 1, ID_RELACION_PAGOS: ID_RELACION_PAGOS },  'RelacionSave', 'formularioRELACION', 'guardarRELACION', { callbackAfter: true, callbackBefore: true }, 
                () => {
                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    })
                    $('.swal2-popup').addClass('ld ld-breath')
                }, 
                function (data) {
                    ID_RELACION_PAGOS = data.relacion.ID_RELACION_PAGOS
                    alertMensaje(
                        'success',
                        'Información guardada correctamente',
                        'Esta información esta lista para usarse',
                        null,
                        null,
                        1500
                    )
                    $('#modalRelacionPagos').modal('hide')
                    document.getElementById('formularioRELACION').reset();
                    Tablarelacionespago.ajax.reload()
                }
            )            
        }, 1)
        
    } else {

        alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        }, async function () { 
            await loaderbtn('guardarRELACION')
            await ajaxAwaitFormData({ api: 1, ID_RELACION_PAGOS: ID_RELACION_PAGOS }, 'RelacionSave', 'formularioRELACION','guardarRELACION', { callbackAfter: true, callbackBefore: true }, 
                () => {
                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    })
                    $('.swal2-popup').addClass('ld ld-breath')            
                }, 
                function (data) { 
                    setTimeout(() => {
                        ID_RELACION_PAGOS = data.relacion.ID_RELACION_PAGOS
                        alertMensaje(
                            'success',
                            'Información editada correctamente',
                            'Información guardada'
                        )
                        $('#modalRelacionPagos').modal('hide')
                        document.getElementById('formularioRELACION').reset();
                        Tablarelacionespago.ajax.reload()
                    }, 300);  
                }
            )
        }, 1)
    }

} else {

    alertToast(
        'Por favor, complete todos los campos del formulario.',
        'error',
        2000
    )

}
    
});



var Tablarelacionespago = $("#Tablarelacionespago").DataTable({
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
        url: '/Tablarelacionespago',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablarelacionespago.columns.adjust().draw();
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
        { data: 'FECHA_RELACION' },
        { data: 'BTN_EXCEL' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Fecha relación', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Descargar Excel', className: 'all text-center' },
        { targets: 3, title: 'Editar', className: 'all text-center' },
        { targets: 4, title: 'Visualizar', className: 'all text-center' },
        { targets: 5, title: 'Activo', className: 'all text-center' }
    ]
});



$('#Tablarelacionespago tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablarelacionespago.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_RELACION_PAGOS: row.data().ID_RELACION_PAGOS
    };

    eliminarDatoTabla(data, [Tablarelacionespago], 'RelacionDelete');
});



$('#Tablarelacionespago tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablarelacionespago.row(tr);
    ID_RELACION_PAGOS = row.data().ID_RELACION_PAGOS;

    editarDatoTabla(row.data(), 'formularioRELACION', 'modalRelacionPagos',1);
    
    $('#tablaRelacionPagos tbody').empty();
    cargarTablaRelacionDesdeJSON(
        row.data().JSON_RELACIONES
    );

});



$(document).ready(function() {
    $('#Tablarelacionespago tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablarelacionespago.row(tr);
        
        hacerSoloLectura(row.data(), '#modalRelacionPagos');

        ID_RELACION_PAGOS = row.data().ID_RELACION_PAGOS;
        editarDatoTabla(row.data(), 'formularioRELACION', 'modalRelacionPagos', 1);
        
        $('#tablaRelacionPagos tbody').empty();
        cargarTablaRelacionDesdeJSON(
            row.data().JSON_RELACIONES
        );
    });

    $('#modalRelacionPagos').on('hidden.bs.modal', function () {
        resetFormulario('#modalRelacionPagos');
    });
});






function cargarTablaRelacionDesdeJSON(jsonRelaciones) {

    $('#tablaRelacionPagos tbody').empty();
    let facturas = [];

    try {

        facturas = JSON.parse(jsonRelaciones);

    } catch (e) {

        facturas = [];
    }


    facturas.forEach(function(item){

        let boton = '';

        if(item.MANUAL == 1){

            boton = `
                <button type="button" class="btn btn-danger btn-sm eliminarPagoManual">
                    <i class="bi bi-trash3-fill"></i>
                </button>
            `;

        } else {

            boton = `
                <button type="button" class="btn btn-secondary btn-sm" disabled>
                    <i class="bi bi-lock-fill"></i>
                </button>
            `;
        }

        let fila = `

            <tr
                data-idfactura="${item.ID_FORMULARIO_FACTURACION}"
                data-manual="${item.MANUAL}">
                <td class="text-center">
                    ${boton}
                </td>
                <td class="text-center">
                    <input type="checkbox" class="form-check-input seleccionar-factura" checked>
                </td>
                <td>
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm mydatepicker fecha-factura" value="${item.FECHA_FACTURA ?? ''}">
                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                    </div>
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm input-pago folio-fiscal" value="${item.FOLIO_FISCAL ?? ''}">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm input-pago razon-social" value="${item.RAZON_SOCIAL ?? ''}">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm input-pago rfc-proveedor" value="${item.RFC ?? ''}">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm input-pago subtotal-factura" value="${item.SUBTOTAL ?? ''}">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm input-pago iva-factura" value="${item.IVA ?? ''}">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm input-pago total-factura" value="${item.TOTAL ?? ''}">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm input-pago moneda-factura" value="${item.MONEDA ?? ''}">
                </td>
                <td>
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm mydatepicker fecha-recepcion" value="${item.FECHA_RECEPCION ?? ''}">
                        <span class="input-group-text"> <i class="bi bi-calendar-event"></i></span>
                    </div>
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm input-pago dias-credito" value="${item.DIAS_CREDITO ?? ''}">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm input-pago banco-factura" value="${item.BANCO ?? ''}">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm input-pago cuenta-factura" value="${item.NO_CUENTA ?? ''}">
                </td>
            </tr>
        `;

        $('#tablaRelacionPagos tbody').append(fila);

    });


    activarDatePickerRelacion();
    calcularTotalesRelacion();

}




function descargarExcelRelacionPagos(id)
{

    window.open(

        '/descargarExcelRelacionPagos/' + id,

        '_blank'

    );

}



$("#PDFS_FICHAS").click(function (e) {

    e.preventDefault();

    window.open('/pdfFichaErgonomica', '_blank');

});

