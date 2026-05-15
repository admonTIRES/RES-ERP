
ID_FORMULARIO_MATRIZ = 0









$("#guardarMATRIZ").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioMATRIZ'))

    if (formularioValido) {

    if (ID_FORMULARIO_MATRIZ == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarMATRIZ')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_MATRIZ: ID_FORMULARIO_MATRIZ }, 'MatrizSave', 'formularioMATRIZ', 'guardarMATRIZ', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_FORMULARIO_MATRIZ = data.matriz.ID_FORMULARIO_MATRIZ
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_MATRIZ').modal('hide')
                    document.getElementById('formularioMATRIZ').reset();
                    Tablamatrizcomparativa.ajax.reload()

        
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarMATRIZ')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_MATRIZ: ID_FORMULARIO_MATRIZ }, 'MatrizSave', 'formularioMATRIZ', 'guardarMATRIZ', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_FORMULARIO_MATRIZ = data.matriz.ID_FORMULARIO_MATRIZ
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_MATRIZ').modal('hide')
                    document.getElementById('formularioMATRIZ').reset();
                    Tablamatrizcomparativa.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});





var Tablamatrizcomparativa = $("#Tablamatrizcomparativa").DataTable({
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
    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'Todos']],
    ajax: {
        dataType: 'json',
        data: {},
        method: 'GET',
        cache: false,
        url: '/Tablamatrizcomparativa',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablamatrizcomparativa.columns.adjust().draw();
            ocultarCarga();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
    order: [[0, 'desc']], 
    columns: [
        { 
            data: null,
            render: function(data, type, row, meta) {
                return meta.row + 1; 
            }
        },
        { data: 'NO_MR' },
        { data: 'ESTADO_BADGE' }, 
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },

    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'N° MR', className: 'all text-center' },
        { targets: 2, title: 'Estado', className: 'all text-center' }, 
        { targets: 3, title: 'Editar', className: 'all text-center' },
        { targets: 4, title: 'Visualizar', className: 'all text-center' }
    ],
     infoCallback: function (settings, start, end, max, total, pre) {
        return `Total de ${total} registros`;
    },
});





$('#Tablamatrizcomparativa tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablamatrizcomparativa.row(tr);
    var data = row.data();
    ID_FORMULARIO_MATRIZ = data.ID_FORMULARIO_MATRIZ;



        $('#NO_MR').val(data.NO_MR);

    
    
        $('#FECHA_COTIZACION_PROVEEDOR1').val(data.FECHA_COTIZACION_PROVEEDOR1);
        $('#FECHA_COTIZACION_PROVEEDOR2').val(data.FECHA_COTIZACION_PROVEEDOR2);
        $('#FECHA_COTIZACION_PROVEEDOR3').val(data.FECHA_COTIZACION_PROVEEDOR3);
        
        $('#VIGENCIA_COTIZACION_PROVEEDOR1').val(data.VIGENCIA_COTIZACION_PROVEEDOR1);
        $('#VIGENCIA_COTIZACION_PROVEEDOR2').val(data.VIGENCIA_COTIZACION_PROVEEDOR2);
        $('#VIGENCIA_COTIZACION_PROVEEDOR3').val(data.VIGENCIA_COTIZACION_PROVEEDOR3);
        
        $('#TIEMPO_ENTREGA_PROVEEDOR1').val(data.TIEMPO_ENTREGA_PROVEEDOR1);
        $('#TIEMPO_ENTREGA_PROVEEDOR2').val(data.TIEMPO_ENTREGA_PROVEEDOR2);
        $('#TIEMPO_ENTREGA_PROVEEDOR3').val(data.TIEMPO_ENTREGA_PROVEEDOR3);
        
        $('#CONDICIONES_PAGO_PROVEEDOR1').val(data.CONDICIONES_PAGO_PROVEEDOR1);
        $('#CONDICIONES_PAGO_PROVEEDOR2').val(data.CONDICIONES_PAGO_PROVEEDOR2);
        $('#CONDICIONES_PAGO_PROVEEDOR3').val(data.CONDICIONES_PAGO_PROVEEDOR3);
        
        $('#CONDICIONES_GARANTIA_PROVEEDOR1').val(data.CONDICIONES_GARANTIA_PROVEEDOR1);
        $('#CONDICIONES_GARANTIA_PROVEEDOR2').val(data.CONDICIONES_GARANTIA_PROVEEDOR2);
        $('#CONDICIONES_GARANTIA_PROVEEDOR3').val(data.CONDICIONES_GARANTIA_PROVEEDOR3);
        
        $('#SERVICIOPOST_PROVEEDOR1').val(data.SERVICIOPOST_PROVEEDOR1);
        $('#SERVICIOPOST_PROVEEDOR2').val(data.SERVICIOPOST_PROVEEDOR2);
        $('#SERVICIOPOST_PROVEEDOR3').val(data.SERVICIOPOST_PROVEEDOR3);
        
        $('#BENEFICIOS_PROVEEDOR1').val(data.BENEFICIOS_PROVEEDOR1);
        $('#BENEFICIOS_PROVEEDOR2').val(data.BENEFICIOS_PROVEEDOR2);
        $('#BENEFICIOS_PROVEEDOR3').val(data.BENEFICIOS_PROVEEDOR3);
        
        $('#ESPECIFICACIONES_PROVEEDOR1').val(data.ESPECIFICACIONES_PROVEEDOR1);
        $('#ESPECIFICACIONES_PROVEEDOR2').val(data.ESPECIFICACIONES_PROVEEDOR2);
        $('#ESPECIFICACIONES_PROVEEDOR3').val(data.ESPECIFICACIONES_PROVEEDOR3);
        
        $('#CERTIFIACION_CALIDAD_PROVEEDOR1').val(data.CERTIFIACION_CALIDAD_PROVEEDOR1);
        $('#CERTIFIACION_CALIDAD_PROVEEDOR2').val(data.CERTIFIACION_CALIDAD_PROVEEDOR2);
        $('#CERTIFIACION_CALIDAD_PROVEEDOR3').val(data.CERTIFIACION_CALIDAD_PROVEEDOR3);
    
       
        
        $('#SOLICITAR_VERIFICACION').val(data.SOLICITAR_VERIFICACION);


        $('#FECHA_APROBACION').val(data.FECHA_APROBACION);
        $('#REQUIERE_PO').val(data.REQUIERE_PO);
        $('#PROVEEDOR_SELECCIONADO').val(data.PROVEEDOR_SELECCIONADO);
        $('#MONTO_FINAL').val(data.MONTO_FINAL);
        $('#FORMA_PAGO').val(data.FORMA_PAGO);

        $('#CRITERIO_SELECCION').val(data.CRITERIO_SELECCION);
        
        $('#FECHA_SOLCITIUD').val(data.FECHA_SOLCITIUD || '');
        
        
        $('#REQUIERE_COMENTARIO').val(data.REQUIERE_COMENTARIO || '');
    $('#COMENTARIO_SOLICITUD').val(data.COMENTARIO_SOLICITUD || '');
    
            toggleComentario();
    

    
        $('#ESTADO_APROBACION').val(data.ESTADO_APROBACION || '');
        $('#MOTIVO_RECHAZO').val(data.MOTIVO_RECHAZO || '');
        togglerechazo();
    
    
        verificarEstadoAprobacion();

    
     
    
        $('#body-proveedores').empty();
        $('.th-pu1, .th-pu2, .th-pu3, .th-total1, .th-total2, .th-total3, #head-prov1, #head-prov2, #head-prov3').addClass('d-none');
        $('.col-prov1, .col-prov2, .col-prov3, .fila-extra').hide();
        
        const proveedores = [
            { nombre: data.PROVEEDOR1, materiales: data.MATERIALES_JSON_PROVEEDOR1 },
            { nombre: data.PROVEEDOR2, materiales: data.MATERIALES_JSON_PROVEEDOR2 },
            { nombre: data.PROVEEDOR3, materiales: data.MATERIALES_JSON_PROVEEDOR3 }
        ];
        
        const columnasActivas = proveedores.map(p => p.materiales ? true : false);
        
        let filas = [];
        let totales = [{ subtotal: 0 }, { subtotal: 0 }, { subtotal: 0 }];
        
        for (let i = 0; i < 100; i++) {
            let fila = { descripcion: '', cantidad: '', precios: [] };
            let hayDatos = false;
        
            proveedores.forEach((prov, idx) => {
                if (prov.materiales) {
                    let materiales = [];
                    try { materiales = JSON.parse(prov.materiales); } catch (e) {}
        
                    const mat = materiales[i];
                    if (mat) {
                        const cantidad = parseFloat(mat.CANTIDAD_ || 0);
                        const unitario = parseFloat(mat.PRECIO_UNITARIO || 0);
                        const total = unitario * cantidad;
        
                        if (!fila.descripcion) fila.descripcion = mat.DESCRIPCION || '';
                        if (!fila.cantidad) fila.cantidad = mat.CANTIDAD_ || '';
        
                        fila.precios[idx] = {
                            unitario: unitario.toFixed(2),
                            total: total.toFixed(2)
                        };
        
                        totales[idx].subtotal += total;
                        hayDatos = true;
                    }
                }
            });
        
            if (hayDatos) filas.push(fila);
            else break;
        }
        
        function llenarSelectProveedores(selectId, valorSeleccionado = '') {
            let html = '<option value="">Seleccionar proveedor</option>';
        
            html += '<optgroup label="Proveedor oficial">';
            proveedoresOficiales.forEach(p => {
                const selected = (valorSeleccionado === p.RFC_ALTA) ? 'selected' : '';
                html += `<option value="${p.RFC_ALTA}" ${selected}>${p.RAZON_SOCIAL_ALTA} (${p.RFC_ALTA})</option>`;
            });
            html += '</optgroup>';
        
            html += '<optgroup label="Proveedores temporales">';
            proveedoresTemporales.forEach(p => {
                const selected = (valorSeleccionado === p.RAZON_PROVEEDORTEMP) ? 'selected' : '';
                html += `<option value="${p.RAZON_PROVEEDORTEMP}" ${selected}>${p.RAZON_PROVEEDORTEMP} (${p.NOMBRE_PROVEEDORTEMP})</option>`;
            });
            html += '</optgroup>';
        
            $(`#PROVEEDOR${selectId}`).html(html);
        }
        
        proveedores.forEach((prov, idx) => {
            const num = idx + 1;
            if (prov.materiales) {
                $(`#head-prov${num}`).removeClass('d-none');
                $(`.th-pu${num}`).removeClass('d-none');
                $(`.th-total${num}`).removeClass('d-none');
                $(`.col-prov${num}`).show();
                $('.fila-extra').show();
                llenarSelectProveedores(num, prov.nombre);
            }
        });
        
        filas.forEach(fila => {
            let tr = `<tr><td>${fila.descripcion}</td><td>${fila.cantidad}</td>`;
            for (let i = 0; i < 3; i++) {
                if (columnasActivas[i]) {
                    if (fila.precios[i]) {
                        tr += `<td>$ ${fila.precios[i].unitario}</td><td>$ ${fila.precios[i].total}</td>`;
                    } else {
                        tr += `<td></td><td></td>`;
                    }
                }
            }
            tr += '</tr>';
            $('#body-proveedores').append(tr);
        });
        
        const etiquetas = ['Subtotal', 'IVA', 'Importe'];
        for (let filaTipo = 0; filaTipo < 3; filaTipo++) {
            let tr = `<tr class="fila-extra"><td></td><td></td>`;
            for (let i = 0; i < 3; i++) {
                if (columnasActivas[i]) {
                    const idSubtotal = `SUBTOTAL_PROVEEDOR${i + 1}`;
                    const idIva = `IVA_PROVEEDOR${i + 1}`;
                    const idImporte = `IMPORTE_PROVEEDOR${i + 1}`;
                    const subtotal = parseFloat(totales[i].subtotal || 0).toFixed(2);
        
                    if (filaTipo === 0) {
                        tr += `
                            <td class="col-prov${i + 1}"><strong>${etiquetas[filaTipo]}</strong></td>
                            <td class="col-prov${i + 1}">
                                <input type="text" class="form-control text-center" readonly name="${idSubtotal}" id="${idSubtotal}" value="${subtotal}">
                            </td>`;
                    } else if (filaTipo === 1) {
                        tr += `
                            <td class="col-prov${i + 1}"><strong>${etiquetas[filaTipo]}</strong></td>
                            <td class="col-prov${i + 1}">
                                <input type="number" step="any" class="form-control text-center iva-input" data-subtotal-id="${idSubtotal}" data-importe-id="${idImporte}" name="${idIva}" id="${idIva}">
                            </td>`;
                    } else if (filaTipo === 2) {
                        tr += `
                            <td class="col-prov${i + 1}"><strong>${etiquetas[filaTipo]}</strong></td>
                            <td class="col-prov${i + 1}">
                                <input type="text" class="form-control text-center" readonly name="${idImporte}" id="${idImporte}">
                            </td>`;
                    }
                }
            }
            tr += '</tr>';
            $('#body-proveedores').append(tr);
    }
    

    $('#IVA_PROVEEDOR1').val(data.IVA_PROVEEDOR1);
    $('#IMPORTE_PROVEEDOR1').val(data.IMPORTE_PROVEEDOR1);
    
    $('#IVA_PROVEEDOR2').val(data.IVA_PROVEEDOR2);
    $('#IMPORTE_PROVEEDOR2').val(data.IMPORTE_PROVEEDOR2);
    
    $('#IVA_PROVEEDOR3').val(data.IVA_PROVEEDOR3);
    $('#IMPORTE_PROVEEDOR3').val(data.IMPORTE_PROVEEDOR3);
    

        
        $(document).off('input', '.iva-input').on('input', '.iva-input', function () {
            const iva = parseFloat($(this).val()) || 0;
            const subtotalId = $(this).data('subtotal-id');
            const importeId = $(this).data('importe-id');
            const subtotal = parseFloat($(`#${subtotalId}`).val()) || 0;
            const total = subtotal + iva;
            $(`#${importeId}`).val(total.toFixed(2));
        });
    
    

    
    
        $('#PROVEEDOR_SELECCIONADO').empty(); 

        $('#PROVEEDOR_SELECCIONADO').append(`<option value="">Seleccionar proveedor sugerido</option>`);
        
        const proveedoresDisponibles = [
            { id: 1, nombre: data.PROVEEDOR1 },
            { id: 2, nombre: data.PROVEEDOR2 },
            { id: 3, nombre: data.PROVEEDOR3 },
        ];
        
        proveedoresDisponibles.forEach(p => {
            if (p.nombre) {
                $('#PROVEEDOR_SELECCIONADO').append(`
                    <option value="${p.nombre}">${p.nombre}</option>
                `);
            }
        });
        
        $('#PROVEEDOR_SELECCIONADO').val(data.PROVEEDOR_SELECCIONADO || '');
        
    
    
    // Mostrar modal manualmente
    $('#miModal_MATRIZ').modal('show');
});



$(document).ready(function() {

    $('#Tablamatrizcomparativa tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablamatrizcomparativa.row(tr);
        var data = row.data();
        ID_FORMULARIO_MATRIZ = data.ID_FORMULARIO_MATRIZ;

        
        hacerSoloLectura(row.data(), '#miModal_MATRIZ');

      
        
        $('#NO_MR').val(data.NO_MR);

    
    
        $('#FECHA_COTIZACION_PROVEEDOR1').val(data.FECHA_COTIZACION_PROVEEDOR1);
        $('#FECHA_COTIZACION_PROVEEDOR2').val(data.FECHA_COTIZACION_PROVEEDOR2);
        $('#FECHA_COTIZACION_PROVEEDOR3').val(data.FECHA_COTIZACION_PROVEEDOR3);
        
        $('#VIGENCIA_COTIZACION_PROVEEDOR1').val(data.VIGENCIA_COTIZACION_PROVEEDOR1);
        $('#VIGENCIA_COTIZACION_PROVEEDOR2').val(data.VIGENCIA_COTIZACION_PROVEEDOR2);
        $('#VIGENCIA_COTIZACION_PROVEEDOR3').val(data.VIGENCIA_COTIZACION_PROVEEDOR3);
        
        $('#TIEMPO_ENTREGA_PROVEEDOR1').val(data.TIEMPO_ENTREGA_PROVEEDOR1);
        $('#TIEMPO_ENTREGA_PROVEEDOR2').val(data.TIEMPO_ENTREGA_PROVEEDOR2);
        $('#TIEMPO_ENTREGA_PROVEEDOR3').val(data.TIEMPO_ENTREGA_PROVEEDOR3);
        
        $('#CONDICIONES_PAGO_PROVEEDOR1').val(data.CONDICIONES_PAGO_PROVEEDOR1);
        $('#CONDICIONES_PAGO_PROVEEDOR2').val(data.CONDICIONES_PAGO_PROVEEDOR2);
        $('#CONDICIONES_PAGO_PROVEEDOR3').val(data.CONDICIONES_PAGO_PROVEEDOR3);
        
        $('#CONDICIONES_GARANTIA_PROVEEDOR1').val(data.CONDICIONES_GARANTIA_PROVEEDOR1);
        $('#CONDICIONES_GARANTIA_PROVEEDOR2').val(data.CONDICIONES_GARANTIA_PROVEEDOR2);
        $('#CONDICIONES_GARANTIA_PROVEEDOR3').val(data.CONDICIONES_GARANTIA_PROVEEDOR3);
        
        $('#SERVICIOPOST_PROVEEDOR1').val(data.SERVICIOPOST_PROVEEDOR1);
        $('#SERVICIOPOST_PROVEEDOR2').val(data.SERVICIOPOST_PROVEEDOR2);
        $('#SERVICIOPOST_PROVEEDOR3').val(data.SERVICIOPOST_PROVEEDOR3);
        
        $('#BENEFICIOS_PROVEEDOR1').val(data.BENEFICIOS_PROVEEDOR1);
        $('#BENEFICIOS_PROVEEDOR2').val(data.BENEFICIOS_PROVEEDOR2);
        $('#BENEFICIOS_PROVEEDOR3').val(data.BENEFICIOS_PROVEEDOR3);
        
        $('#ESPECIFICACIONES_PROVEEDOR1').val(data.ESPECIFICACIONES_PROVEEDOR1);
        $('#ESPECIFICACIONES_PROVEEDOR2').val(data.ESPECIFICACIONES_PROVEEDOR2);
        $('#ESPECIFICACIONES_PROVEEDOR3').val(data.ESPECIFICACIONES_PROVEEDOR3);
        
        $('#CERTIFIACION_CALIDAD_PROVEEDOR1').val(data.CERTIFIACION_CALIDAD_PROVEEDOR1);
        $('#CERTIFIACION_CALIDAD_PROVEEDOR2').val(data.CERTIFIACION_CALIDAD_PROVEEDOR2);
        $('#CERTIFIACION_CALIDAD_PROVEEDOR3').val(data.CERTIFIACION_CALIDAD_PROVEEDOR3);
    
        $('#SOLICITAR_VERIFICACION').val(data.SOLICITAR_VERIFICACION);
        $('#FECHA_APROBACION').val(data.FECHA_APROBACION);
        $('#REQUIERE_PO').val(data.REQUIERE_PO);
        $('#PROVEEDOR_SELECCIONADO').val(data.PROVEEDOR_SELECCIONADO);
        $('#MONTO_FINAL').val(data.MONTO_FINAL);
        $('#FORMA_PAGO').val(data.FORMA_PAGO);


        $('#CRITERIO_SELECCION').val(data.CRITERIO_SELECCION);
        $('#REQUIERE_COMENTARIO').val(data.REQUIERE_COMENTARIO || '');
        $('#COMENTARIO_SOLICITUD').val(data.COMENTARIO_SOLICITUD || '');
            toggleComentario();
        

    
        $('#ESTADO_APROBACION').val(data.ESTADO_APROBACION || '');
        $('#MOTIVO_RECHAZO').val(data.MOTIVO_RECHAZO || '');

        $('#FECHA_SOLCITIUD').val(data.FECHA_SOLCITIUD || '');

        togglerechazo();
        
        

        verificarEstadoAprobacion();


    

        $('#body-proveedores').empty();
        $('.th-pu1, .th-pu2, .th-pu3, .th-total1, .th-total2, .th-total3, #head-prov1, #head-prov2, #head-prov3').addClass('d-none');
        $('.col-prov1, .col-prov2, .col-prov3, .fila-extra').hide();
        
        const proveedores = [
            { nombre: data.PROVEEDOR1, materiales: data.MATERIALES_JSON_PROVEEDOR1 },
            { nombre: data.PROVEEDOR2, materiales: data.MATERIALES_JSON_PROVEEDOR2 },
            { nombre: data.PROVEEDOR3, materiales: data.MATERIALES_JSON_PROVEEDOR3 }
        ];
        
        const columnasActivas = proveedores.map(p => p.materiales ? true : false);
        
        let filas = [];
        let totales = [{ subtotal: 0 }, { subtotal: 0 }, { subtotal: 0 }];
        
        for (let i = 0; i < 100; i++) {
            let fila = { descripcion: '', cantidad: '', precios: [] };
            let hayDatos = false;
        
            proveedores.forEach((prov, idx) => {
                if (prov.materiales) {
                    let materiales = [];
                    try { materiales = JSON.parse(prov.materiales); } catch (e) {}
        
                    const mat = materiales[i];
                    if (mat) {
                        const cantidad = parseFloat(mat.CANTIDAD_ || 0);
                        const unitario = parseFloat(mat.PRECIO_UNITARIO || 0);
                        const total = unitario * cantidad;
        
                        if (!fila.descripcion) fila.descripcion = mat.DESCRIPCION || '';
                        if (!fila.cantidad) fila.cantidad = mat.CANTIDAD_ || '';
        
                        fila.precios[idx] = {
                            unitario: unitario.toFixed(2),
                            total: total.toFixed(2)
                        };
        
                        totales[idx].subtotal += total;
                        hayDatos = true;
                    }
                }
            });
        
            if (hayDatos) filas.push(fila);
            else break;
        }
        
        function llenarSelectProveedores(selectId, valorSeleccionado = '') {
            let html = '<option value="">Seleccionar proveedor</option>';
        
            html += '<optgroup label="Proveedor oficial">';
            proveedoresOficiales.forEach(p => {
                const selected = (valorSeleccionado === p.RFC_ALTA) ? 'selected' : '';
                html += `<option value="${p.RFC_ALTA}" ${selected}>${p.RAZON_SOCIAL_ALTA} (${p.RFC_ALTA})</option>`;
            });
            html += '</optgroup>';
        
            html += '<optgroup label="Proveedores temporales">';
            proveedoresTemporales.forEach(p => {
                const selected = (valorSeleccionado === p.RAZON_PROVEEDORTEMP) ? 'selected' : '';
                html += `<option value="${p.RAZON_PROVEEDORTEMP}" ${selected}>${p.RAZON_PROVEEDORTEMP} (${p.NOMBRE_PROVEEDORTEMP})</option>`;
            });
            html += '</optgroup>';
        
            $(`#PROVEEDOR${selectId}`).html(html);
        }
        
        proveedores.forEach((prov, idx) => {
            const num = idx + 1;
            if (prov.materiales) {
                $(`#head-prov${num}`).removeClass('d-none');
                $(`.th-pu${num}`).removeClass('d-none');
                $(`.th-total${num}`).removeClass('d-none');
                $(`.col-prov${num}`).show();
                $('.fila-extra').show();
                llenarSelectProveedores(num, prov.nombre);
            }
        });
        
        filas.forEach(fila => {
            let tr = `<tr><td>${fila.descripcion}</td><td>${fila.cantidad}</td>`;
            for (let i = 0; i < 3; i++) {
                if (columnasActivas[i]) {
                    if (fila.precios[i]) {
                        tr += `<td>$ ${fila.precios[i].unitario}</td><td>$ ${fila.precios[i].total}</td>`;
                    } else {
                        tr += `<td></td><td></td>`;
                    }
                }
            }
            tr += '</tr>';
            $('#body-proveedores').append(tr);
        });
        
        const etiquetas = ['Subtotal', 'IVA', 'Importe'];
        for (let filaTipo = 0; filaTipo < 3; filaTipo++) {
            let tr = `<tr class="fila-extra"><td></td><td></td>`;
            for (let i = 0; i < 3; i++) {
                if (columnasActivas[i]) {
                    const idSubtotal = `SUBTOTAL_PROVEEDOR${i + 1}`;
                    const idIva = `IVA_PROVEEDOR${i + 1}`;
                    const idImporte = `IMPORTE_PROVEEDOR${i + 1}`;
                    const subtotal = parseFloat(totales[i].subtotal || 0).toFixed(2);
        
                    if (filaTipo === 0) {
                        tr += `
                            <td class="col-prov${i + 1}"><strong>${etiquetas[filaTipo]}</strong></td>
                            <td class="col-prov${i + 1}">
                                <input type="text" class="form-control text-center" readonly name="${idSubtotal}" id="${idSubtotal}" value="${subtotal}">
                            </td>`;
                    } else if (filaTipo === 1) {
                        tr += `
                            <td class="col-prov${i + 1}"><strong>${etiquetas[filaTipo]}</strong></td>
                            <td class="col-prov${i + 1}">
                                <input type="number" step="any" class="form-control text-center iva-input" data-subtotal-id="${idSubtotal}" data-importe-id="${idImporte}" name="${idIva}" id="${idIva}">
                            </td>`;
                    } else if (filaTipo === 2) {
                        tr += `
                            <td class="col-prov${i + 1}"><strong>${etiquetas[filaTipo]}</strong></td>
                            <td class="col-prov${i + 1}">
                                <input type="text" class="form-control text-center" readonly name="${idImporte}" id="${idImporte}">
                            </td>`;
                    }
                }
            }
            tr += '</tr>';
            $('#body-proveedores').append(tr);
        }
        

        
        $('#IVA_PROVEEDOR1').val(data.IVA_PROVEEDOR1);
        $('#IMPORTE_PROVEEDOR1').val(data.IMPORTE_PROVEEDOR1);

        $('#IVA_PROVEEDOR2').val(data.IVA_PROVEEDOR2);
        $('#IMPORTE_PROVEEDOR2').val(data.IMPORTE_PROVEEDOR2);

        $('#IVA_PROVEEDOR3').val(data.IVA_PROVEEDOR3);
        $('#IMPORTE_PROVEEDOR3').val(data.IMPORTE_PROVEEDOR3);

        
        $(document).off('input', '.iva-input').on('input', '.iva-input', function () {
            const iva = parseFloat($(this).val()) || 0;
            const subtotalId = $(this).data('subtotal-id');
            const importeId = $(this).data('importe-id');
            const subtotal = parseFloat($(`#${subtotalId}`).val()) || 0;
            const total = subtotal + iva;
            $(`#${importeId}`).val(total.toFixed(2));
        });
    
    


    
        $('#PROVEEDOR_SELECCIONADO').empty(); 

        $('#PROVEEDOR_SELECCIONADO').append(`<option value="">Seleccionar proveedor sugerido</option>`);
        
        const proveedoresDisponibles = [
            { id: 1, nombre: data.PROVEEDOR1 },
            { id: 2, nombre: data.PROVEEDOR2 },
            { id: 3, nombre: data.PROVEEDOR3 },
        ];
        
        proveedoresDisponibles.forEach(p => {
            if (p.nombre) {
                $('#PROVEEDOR_SELECCIONADO').append(`
                    <option value="${p.nombre}">${p.nombre}</option>
                `);
            }
        });
        
        $('#PROVEEDOR_SELECCIONADO').val(data.PROVEEDOR_SELECCIONADO || '');
        
    
    
        $('#miModal_MATRIZ').modal('show');
        




    });

    $('#miModal_MATRIZ').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_MATRIZ');
    });
});




function toggleComentario() {
    const valor = $('#REQUIERE_COMENTARIO').val();
    if (valor === 'Sí') {
        $('#COMENTARIO_SOLICITUD_MATRIZ').show();
    } else {
        $('#COMENTARIO_SOLICITUD_MATRIZ').hide();
        $('#COMENTARIO_SOLICITUD').val('');
    }
}

$('#REQUIERE_COMENTARIO').on('change', toggleComentario);


function togglerechazo() {
    const valor = $('#ESTADO_APROBACION').val();
    if (valor === 'Rechazada') {
        $('#motivo-rechazoa').show();
    } else {
        $('#motivo-rechazoa').hide();
        $('#MOTIVO_RECHAZO').val('');
    }
}

$('#ESTADO_APROBACION').on('change', togglerechazo);



function verificarEstadoAprobacion() {
    const estado = $('#ESTADO_APROBACION').val();
    if (estado === 'Aprobada' || estado === 'Rechazada') {
        $('#APROBACION_HOJA').show();
    } else {
        $('#APROBACION_HOJA').hide();
    }
}

$('#ESTADO_APROBACION').on('change', verificarEstadoAprobacion);




