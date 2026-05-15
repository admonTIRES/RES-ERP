ID_FORMULARIO_FACTURACION = 0;





const ModalArea = document.getElementById('miModal_factura')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    
    ID_CATALOGO_TIPOINVENTARIO = 0
    document.getElementById('formularioFACTURA').reset();
   
    document.getElementById('SUBIR_REP').value = "0"; 




})


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
            await ajaxAwaitFormData({ api: 2, ID_FORMULARIO_FACTURACION: ID_FORMULARIO_FACTURACION }, 'FacturacionSave', 'formularioFACTURA', 'btnGuardarFactura', { callbackAfter: true, callbackBefore: true }, () => {
        
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
                    Tablacargarrecp.ajax.reload()

            })
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
             title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('btnGuardarFactura')
            await ajaxAwaitFormData({ api: 2, ID_FORMULARIO_FACTURACION: ID_FORMULARIO_FACTURACION }, 'FacturacionSave', 'formularioFACTURA', 'btnGuardarFactura', { callbackAfter: true, callbackBefore: true }, () => {
        
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
                    alertMensaje('success', 'Información guardada correctamente', 'Información guardada')
                     $('#miModal_factura').modal('hide')
                    document.getElementById('formularioFACTURA').reset();
                    Tablacargarrecp.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});




var Tablacargarrecp = $("#Tablacargarrecp").DataTable({
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
        url: '/Tablacargarrecp',
        beforeSend: function () {
            $('#loadingIcon1').css('display', 'inline-block');
        },
        complete: function () {
            $('#loadingIcon1').css('display', 'none');
            Tablacargarrecp.columns.adjust().draw(); 
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
        { data: 'FOLIO_FISCAL' },
        { data: 'BTN_FACTURA' },
        { data: 'BTN_EDITAR' }
        
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Factura por', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Folio fiscal', className: 'all text-center' },
        { targets: 3, title: 'Visualizar factura', className: 'all text-center' },
        { targets: 4, title: 'Cargar REP', className: 'all text-center' },
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



$('#Tablacargarrecp tbody').on('click', 'td>button.CARGARREP', function () {
    var tr = $(this).closest('tr');
    var row = Tablacargarrecp.row(tr);
    ID_FORMULARIO_FACTURACION = row.data().ID_FORMULARIO_FACTURACION;


    document.getElementById('SUBIR_REP').value = "1"; 
    

    $("#TOTAL_FACTURA").val(row.data().TOTAL_FACTURA);

$('#btnGuardarFactura').prop('disabled', false);

    $('#miModal_factura').modal('show');

});


$(document).on('change', '#XML_REP', function () {

    const file = this.files[0];

    if (!file) return;


    $('#btnGuardarFactura').prop('disabled', false);

    const reader = new FileReader();

    reader.onload = function (e) {

        try {

            const xmlText = e.target.result;

            const parser = new DOMParser();

            const xmlDoc = parser.parseFromString(xmlText, "text/xml");

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

                const pago = xmlDoc.getElementsByTagName("pago10:Pago");

                if (pago.length > 0) {

                    montoREP = parseFloat(
                        pago[0].getAttribute("Monto")
                    );
                }
            }

           

            if (montoREP === null || isNaN(montoREP)) {

                Swal.fire({
                    icon: 'error',
                    title: 'XML inválido',
                    text: 'El archivo XML no corresponde a un REP válido'
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
                    text: 'No se encontró el total de la factura'
                });

                $('#XML_REP').val('');

                $('#btnGuardarFactura').prop('disabled', true);

                return;
            }

            // =========================================
            // REDONDEAR
            // =========================================

            montoREP = parseFloat(montoREP.toFixed(2));

            totalFactura = parseFloat(totalFactura.toFixed(2));

            // =========================================
            // VALIDAR QUE NO EXCEDA
            // =========================================

            if (montoREP > totalFactura) {

                Swal.fire({
                    icon: 'error',
                    title: 'Monto inválido',
                    html:
                        '<b>Total factura:</b> $' + totalFactura.toFixed(2) +
                        '<br><b>Monto REP:</b> $' + montoREP.toFixed(2) +
                        '<br><br>El monto del REP no puede ser mayor al total de la factura.'
                });

                $('#XML_REP').val('');

                $('#btnGuardarFactura').prop('disabled', true);

                return;
            }

            // =========================================
            // XML CORRECTO
            // =========================================

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

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No fue posible leer el XML'
            });

            $('#XML_REP').val('');

            $('#btnGuardarFactura').prop('disabled', true);
        }
    };

    reader.readAsText(file);
});