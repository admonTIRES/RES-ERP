ID_FORMULARIO_FACTURACION = 0;

let tipoProveedor = null;




$("#NUEVA_FACTURA").click(function (e) {
    e.preventDefault();

    $.get('/validarPuedeSubirFactura', function (res) {

        if (!res.puede) {
            Swal.fire({
                icon: 'warning',
                title: 'No puedes subir factura',
                text: res.mensaje
            });
            return;
        }

       
        $('#formularioFACTURA')[0].reset();
        $('#TIPO_FACTURA').val('');
        $('#contenedorOC').addClass('d-none');
        $('#datosFactura').addClass('d-none');
        $('#camposFactura').addClass('d-none');
        $('#soporteFacturaTexto').addClass('d-none');
        $('#camposFacturaExtranjero').addClass('d-none');
        $('#FACTURA_PDF').val('');
        $('#FACTURA_XML').val('');
        $('#btnGuardarFactura').hide(); 
        $('#contenedorCONTRATO').addClass('d-none');
        $('#soporteFacturaTextoContrato').addClass('d-none');


        $("#miModal_factura").modal("show");
    });
});



const Modalfactura = document.getElementById('miModal_factura');
Modalfactura.addEventListener('hidden.bs.modal', event => {

    ID_FORMULARIO_FACTURACION = 0;

    document.getElementById('formularioFACTURA').reset();

    $('#TIPO_FACTURA').val('');
    $('#contenedorOC').addClass('d-none');
    $('#datosFactura').addClass('d-none');
    $('#camposFactura').addClass('d-none');
    $('#soporteFacturaTexto').addClass('d-none');
    $('#camposFacturaExtranjero').addClass('d-none');
    $('#FACTURA_PDF').val('');
    $('#FACTURA_XML').val('');
    $('#btnGuardarFactura').hide(); 
    $('#contenedorCONTRATO').addClass('d-none');
    $('#soporteFacturaTextoContrato').addClass('d-none');
 
});




$(document).on('change', '#TIPO_FACTURA', function () {

    let tipo = $(this).val();

    $('#contenedorOC, #datosFactura, #camposFactura','#camposFacturaExtranjero,#soporteFacturaTexto,#contenedorCONTRATO,#soporteFacturaTextoContrato').addClass('d-none');
    $('#btnGuardarFactura').hide();

   
    $.get('/obtenerTipoProveedor', function (res) {

        tipoProveedor = res.tipo;

        if (tipo === 'OC') {
            $('#contenedorOC').removeClass('d-none');
            $('#soporteFacturaTexto,#datosFactura,#camposFactura,#camposFacturaExtranjero,#contenedorCONTRATO,#soporteFacturaTextoContrato').addClass('d-none');
            $('#NO_PO').val('');
            $('#NO_GR').val('');
        }

       if (tipo === 'CONTRATO') {

            $('#contenedorCONTRATO').removeClass('d-none');

            $('#contenedorOC,#soporteFacturaTexto,#datosFactura,#camposFactura,#camposFacturaExtranjero,#soporteFacturaTextoContrato').addClass('d-none');

            $('#NO_CONTRATO').val('');
            $('#NO_PO').val('');
            $('#NO_GR').val('');

            $('#SELECCIONAR_CONTRATO').html('');

            $.get('/obtenerContratosProveedor', function (contratos) {
                $('#SELECCIONAR_CONTRATO').append(`
                    <option value="">Seleccione un contrato</option>
                `);
                if (contratos.length > 0) {
                    contratos.forEach(function (contrato) {
                        $('#SELECCIONAR_CONTRATO').append(`
                           <option value="${contrato.NUMERO_CONTRATO_PROVEEDOR}">
                                ${contrato.NUMERO_CONTRATO_PROVEEDOR}
                            </option>
                        `);

                    });
                } else {

                    $('#SELECCIONAR_CONTRATO').append(`
                        <option value="">No hay contratos vigentes</option>
                    `);
                }
            });
        }
    });
});


document.addEventListener('DOMContentLoaded', function () {

    const selectorContrato = document.getElementById('SELECCIONAR_CONTRATO');
    const inputContrato = document.getElementById('NO_CONTRATO');

    selectorContrato.addEventListener('change', function () {

        let selectedOption = this.options[this.selectedIndex].text;

        if (this.value == '') {

            inputContrato.value = '';

        } else {

            inputContrato.removeAttribute('readonly');

            inputContrato.value = selectedOption;

            inputContrato.setAttribute('readonly', true);

        }

    });

});


function activarCampos() {

    $('#datosFactura').removeClass('d-none');
    $('#btnGuardarFactura').show();


    if (tipoProveedor == 2) {


        $('#soporteFacturaTexto').addClass('d-none');
        $('#soporteFacturaTextoContrato').addClass('d-none');


        $('#camposFacturaExtranjero').removeClass('d-none');
        $('#FACTURA_DIV').removeClass('col-md-4');
        $('#FACTURA_DIV').addClass('col-md-12');
        $('#FACTURA_DIV').closest('.col-md-12').show();

        $('#XML_DIV').closest('.col-md-4').hide();
        $('#SOPORTE_DIV').closest('.col-md-4').hide();


        $('#MONEDA_FACTURA_EXTRANJERO').val('USD');
        $('#IVA_FACTURA_EXTRANJERO').val('0');
        $('#FOLIO_FISCAL').val('');
        $('#METODO_PAGO').val('');



    } else {

        $('#camposFactura').removeClass('d-none');
        $('#SOPORTE_DIV').closest('.col-md-4').show();
        $('#FACTURA_DIV').closest('.col-md-4').show();
        $('#XML_DIV').closest('.col-md-4').show();

        $('#NO_FACTURA').val('');
        $('#FECHA_FACTURA').val('');
    }

   
}


$(document).on('click', '#btnValidarCONTRATO', function () {

    let numeroContrato = $('#NO_CONTRATO').val().trim();

    if (!numeroContrato) {
        Swal.fire('Error', 'Debe ingresar el número de contrato', 'error');
        return;
    }

    $.ajax({
        url: '/validarContratoNumero',
        method: 'POST',
        data: {
            numero_contrato: numeroContrato,
            _token: $('input[name="_token"]').val()
        },
        success: function (res) {

            if (!res.valido) {

              
                Swal.fire('Error', res.mensaje, 'error');

                $('#datosFactura').addClass('d-none');
                $('#btnGuardarFactura').hide();

              

                return;
            }

            Swal.fire('Correcto', 'Contrato válido y vigente', 'success');

           validarTextoFactura();
            activarCampos();
            
            $('#DOCUMENTOS_SOPORTE_FACTURA').val('');
            $('#FACTURA_PDF').val('');
            $('#FACTURA_XML').val('');
            $('#FECHA_FACTURA').val('');
            $('#MONEDA_FACTURA').val('');
            $('#SUBTOTAL_FACTURA').val('');
            $('#IVA_FACTURA').val('');
            $('#TOTAL_FACTURA').val('');
            $('#FOLIO_FISCAL').val('');
            $('#METODO_PAGO').val('');
            $('#NO_FACTURA_EXTRANJERO').val('');
            $('#FECHA_FACTURA_EXTRANJERO').val('');
            $('#SUBTOTAL_FACTURA_EXTRANJERO').val('');
            $('#TOTAL_FACTURA_EXTRANJERO').val('');
            
        },
        error: function () {
            Swal.fire('Error', 'Error al validar el contrato', 'error');
        }
    });
});




$(document).on('click', '#btnValidarPOGR', function () {

    let po = $('#NO_PO').val().trim();
    let gr = $('#NO_GR').val().trim();

    if (!po || !gr) {
        Swal.fire('Error', 'Debes ingresar PO y GR', 'error');
        return;
    }

    $.ajax({
        url: '/validarPOGR',
        method: 'POST',
        data: {
            po: po,
            gr: gr,
            _token: $('input[name="_token"]').val()
        },
        success: function (res) {

            if (!res.valido) {

                Swal.fire('Error', res.mensaje, 'error');

                $('#datosFactura').addClass('d-none');
                $('#btnGuardarFactura').hide();

                return;
            }

            Swal.fire('Correcto', 'Orden de Compra (PO) y Recepción (GR) son válidos', 'success');
            
            validarTextoFactura();
            activarCampos();


        $('#DOCUMENTOS_SOPORTE_FACTURA').val('');
        $('#FACTURA_PDF').val('');
        $('#FACTURA_XML').val('');
        $('#FECHA_FACTURA').val('');
        $('#MONEDA_FACTURA').val('');
        $('#SUBTOTAL_FACTURA').val('');
        $('#IVA_FACTURA').val('');
        $('#TOTAL_FACTURA').val('');
        $('#FOLIO_FISCAL').val('');
        $('#METODO_PAGO').val('');
        $('#NO_FACTURA_EXTRANJERO').val('');
        $('#FECHA_FACTURA_EXTRANJERO').val('');
        $('#SUBTOTAL_FACTURA_EXTRANJERO').val('');
        $('#TOTAL_FACTURA_EXTRANJERO').val('');


        },
        error: function () {
            Swal.fire('Error', 'Error al validar PO/GR', 'error');
        }
    });
});




// function validarSoporteFactura() {

//     if (tipoProveedor == 1) {
//         $('#soporteFacturaTexto').removeClass('d-none');
//         $('#soporteFacturaTextoContrato').removeClass('d-none');

//     } else {

//         $('#soporteFacturaTexto').addClass('d-none');
//         $('#soporteFacturaTextoContrato').addClass('d-none');

//     }
// }


function validarTextoFactura() {
    
    let tipo = $('#TIPO_FACTURA').val();
    
    if (tipo === 'OC')
    {
        $('#soporteFacturaTexto').removeClass('d-none'); 
        $('#soporteFacturaTextoContrato').addClass('d-none');
        
    } else {
        
        $('#soporteFacturaTexto').addClass('d-none');
          $('#soporteFacturaTextoContrato').removeClass('d-none');
    }

}



$(document).on('change', '#FACTURA_XML', function () {

    if (tipoProveedor != 1) return; 

    let file = this.files[0];
    if (!file) return;

    let reader = new FileReader();

    reader.onload = function (e) {

        let xml = new DOMParser().parseFromString(e.target.result, "text/xml");

        const getNode = name =>
            Array.from(xml.getElementsByTagName('*'))
                .find(el => el.localName === name);

        const getNodes = name =>
            Array.from(xml.getElementsByTagName('*'))
                .filter(el => el.localName === name);

        let comp = getNode('Comprobante');

        let subtotal = comp?.getAttribute('SubTotal') || '';
        let total    = comp?.getAttribute('Total') || '';
        let moneda   = comp?.getAttribute('Moneda') || '';
        let metodo   = comp?.getAttribute('MetodoPago') || '';

        let iva = 0;
        let impuestos = getNode('Impuestos');

        if (impuestos && impuestos.getAttribute('TotalImpuestosTrasladados')) {
            iva = impuestos.getAttribute('TotalImpuestosTrasladados');
        } else {
            let trasladoGlobal = getNodes('Traslado').find(t =>
                parseFloat(t.getAttribute('Base')) === parseFloat(subtotal)
            );
            if (trasladoGlobal) {
                iva = trasladoGlobal.getAttribute('Importe');
            }
        }

        let timbre = getNode('TimbreFiscalDigital');

        let uuid = timbre?.getAttribute('UUID') || '';
        let fecha = timbre?.getAttribute('FechaTimbrado') || '';

        if (fecha.includes('T')) {
            fecha = fecha.split('T')[0];
        }

        $('#SUBTOTAL_FACTURA').val(subtotal);
        $('#TOTAL_FACTURA').val(total);
        $('#MONEDA_FACTURA').val(moneda);
        $('#METODO_PAGO').val(metodo);
        $('#FOLIO_FISCAL').val(uuid);
        // $('#IVA_FACTURA').val(iva);
        $('#IVA_FACTURA').val(parseFloat(iva).toFixed(2));
        $('#FECHA_FACTURA').val(fecha);


    };

    reader.readAsText(file);
});

$(document).on('input', '#SUBTOTAL_FACTURA_EXTRANJERO', function () {

    if (tipoProveedor != 2) return;

    let sub = $(this).val(); 

    $('#IVA_FACTURA_EXTRANJERO').val('0');
    $('#TOTAL_FACTURA_EXTRANJERO').val(sub);
});



$("#btnGuardarFactura").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario3($('#formularioFACTURA'))

    if (formularioValido) {

    if (ID_FORMULARIO_FACTURACION == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('btnGuardarFactura')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_FACTURACION: ID_FORMULARIO_FACTURACION }, 'FacturacionSave', 'formularioFACTURA', 'btnGuardarFactura', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_FORMULARIO_FACTURACION = data.cuenta.ID_FORMULARIO_FACTURACION
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_factura').modal('hide')
                    document.getElementById('formularioFACTURA').reset();
                    Tablafacturaproveedores.ajax.reload()

            })
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('btnGuardarFactura')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_FACTURACION: ID_FORMULARIO_FACTURACION }, 'FacturacionSave', 'formularioFACTURA', 'btnGuardarFactura', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_FORMULARIO_FACTURACION = data.cuenta.ID_FORMULARIO_FACTURACION
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_factura').modal('hide')
                    document.getElementById('formularioFACTURA').reset();
                    Tablafacturaproveedores.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});


var Tablafacturaproveedores = $("#Tablafacturaproveedores").DataTable({
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
        url: '/Tablafacturaproveedores',
        beforeSend: function () {
            $('#loadingIcon1').css('display', 'inline-block');
        },
        complete: function () {
            $('#loadingIcon1').css('display', 'none');
            Tablafacturaproveedores.columns.adjust().draw(); 
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
        { data: 'BTN_SOPORTES' },
        { data: 'BTN_FACTURA' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'ESTADO_FACTURA_TEXTO' },
        {
            data: null,
            render: function (data, type, row) {
                if (!row.ARCHIVO_RECIBO_PAGO || row.ARCHIVO_RECIBO_PAGO.trim() === '') {
                    return '-';
                }
                return row.BTN_COMPROBANTE;
            }
        },
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Factura por', className: 'all text-center nombre-column' },
        { targets: 2, title: 'No. Factura', className: 'all text-center nombre-column' },
        { targets: 3, title: 'Soporte de la factura', className: 'all text-center' },
        { targets: 4, title: 'Factura', className: 'all text-center' },
        { targets: 5, title: 'Visualizar', className: 'all text-center' },
        { targets: 6, title: 'Estatus factura', className: 'all text-center' },
        { targets: 7, title: 'Comprobante de pago', className: 'all text-center' },

    ]
});


$('#Tablafacturaproveedores').on('click', '.ver-archivo-soportes', function () {
    var id = $(this).data('id');
    if (!id) {
        alert('ARCHIVO NO ENCONTRADO');
        return;
    }
    var url = '/mostrarsoportefactura/' + id;
    abrirModal(url, 'Soporte factura');
})



$('#Tablafacturaproveedores').on('click', '.ver-archivo-factura', function () {
    var id = $(this).data('id');
    if (!id) {
        alert('ARCHIVO NO ENCONTRADO');
        return;
    }
    var url = '/mostrarfactura/' + id;
    abrirModal(url, 'Factura');
})


$('#Tablafacturaproveedores').on('click', '.ver-archivo-comprobante', function () {
    var id = $(this).data('id');
    if (!id) {
        alert('ARCHIVO NO ENCONTRADO');
        return;
    }
    var url = '/mostrarecibodepago/' + id;
    abrirModal(url, 'Comprobante de pago');
})




$(document).ready(function() {
    $('#Tablafacturaproveedores tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablafacturaproveedores.row(tr);
        
        hacerSoloLectura2(row.data(), '#miModal_factura');

        ID_FORMULARIO_FACTURACION = row.data().ID_FORMULARIO_FACTURACION;
        editarDatoTabla(row.data(), 'formularioFACTURA', 'miModal_factura', 1);
        
        if (row.data().TIPO_FACTURA === "CONTRATO") {

            $('#contenedorCONTRATO').removeClass('d-none');
            $('#contenedorOC').addClass('d-none');
            
        } else {
        
            $('#contenedorOC').removeClass('d-none');
            $('#contenedorCONTRATO').addClass('d-none');

        }
    
        $.get('/obtenerTipoProveedor', function (res) {

            if (res.tipo == 1) {
                $('#camposFactura').removeClass('d-none');
                $('#camposFacturaExtranjero').addClass('d-none');

            } else if (res.tipo == 2) {
                $('#camposFacturaExtranjero').removeClass('d-none');
                $('#camposFactura').addClass('d-none');
            }
        });


    });


    $('#miModal_factura').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_factura');
    });
});
