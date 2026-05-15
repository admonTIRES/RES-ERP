ID_BITACORAS_ALMACEN = 0
let ID_FORM_GLOBAL = null;
let ID_INVENTARIO_GLOBAL = null;


const Modalbitacora = document.getElementById('miModal_BITACORA')
Modalbitacora.addEventListener('hidden.bs.modal', event => {
    
    ID_BITACORAS_ALMACEN = 0
    document.getElementById('formularioBITACORA').reset();
    $("#guardaBITACORA").show();
   
})

var Tablabitacoraconsumibles = $("#Tablabitacoraconsumibles").DataTable({
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
        url: '/Tablabitacoraconsumibles',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablabitacoraconsumibles.columns.adjust().draw();
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
        { data: 'DESCRIPCION' },
        { data: 'SOLICITANTE_SALIDA' },
        { data: 'CANTIDAD' },
        {
            data: null,
            render: function (data) {
                return `${data.CANTIDAD_SALIDA} (${data.UNIDAD_SALIDA ?? ''})`;
            }
        },
        { data: 'PRODUCTO_NOMBRE' },
        { data: 'MARCA_EQUIPO' },
        { data: 'MODELO_EQUIPO' },
        { data: 'SERIE_EQUIPO' },
        { data: 'FECHA_ALMACEN_SOLICITUD' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all text-center' },
        { targets: 1, title: 'Descripción del artículo', className: 'all text-center' },
        { targets: 2, title: 'Nombre del solicitante', className: 'all text-center' },
        { targets: 3, title: 'Cantidad solicitada', className: 'all text-center' },
        { targets: 4, title: 'Cantidad entregada', className: 'all text-center' },
        { targets: 5, title: 'Artículo entregado', className: 'all text-center' },
        { targets: 6, title: 'Marca', className: 'all text-center' },
        { targets: 7, title: 'Modelo', className: 'all text-center' },
        { targets: 8, title: 'No. Serie', className: 'all text-center' },
        { targets: 9, title: 'Fecha de entrega', className: 'all text-center' },
        { targets: 10, title: 'Editar', className: 'all text-center' },
        { targets: 11, title: 'Visualizar', className: 'all text-center' }
   ],
    createdRow: function (row, data) {
    if (data.ROW_CLASS) {
        $(row).addClass(data.ROW_CLASS);
    }
}
});

$(document).on('click', '.editarMaterial', function () {

    ID_FORM_GLOBAL = $(this).data('id');
    ID_INVENTARIO_GLOBAL = $(this).data('inventario');

    $.ajax({
        url: '/obtenerMaterialIndividual',
        method: 'GET',
        data: { id: ID_FORM_GLOBAL, inventario: ID_INVENTARIO_GLOBAL },

        success: function (res) {

            if (!res.success) {
                alert(res.message || "No se pudo obtener el material.");
                return;
            }

            let material = res.material;

            let canvas1 = document.getElementById("firmaCanvas");
            let canvas2 = document.getElementById("firmaCanvas2");

            let ctx1 = canvas1.getContext("2d");
            let ctx2 = canvas2.getContext("2d");

          
            canvas1.width = canvas1.width; 
            canvas2.width = canvas2.width;

            $("#FIRMA_RECIBIDO_POR").val("");
            $("#FIRMA_ENTREGADO_POR").val("");

           
            $("#SOLICITANTE_SALIDA").val(material.SOLICITANTE_SALIDA);
            $("#FECHA_ALMACEN_SOLICITUD").val(material.FECHA_ALMACEN_SOLICITUD);
            $("#DESCRIPCION").val(material.DESCRIPCION);
            $("#CANTIDAD").val(material.CANTIDAD);
            $("#CANTIDAD_SALIDA").val(material.CANTIDAD_SALIDA);
            $("#UNIDAD_SALIDA").val(material.UNIDAD_SALIDA);
            $("#INVENTARIO").val(material.INVENTARIO);
            $("#OBSERVACIONES_REC").val(material.OBSERVACIONES_REC);
            $("#ENTREGADO_POR").val(material.ENTREGADO_POR);

            if (material.YA_GUARDADO) {

                $("#ID_BITACORAS_ALMACEN").val(material.ID_BITACORAS_ALMACEN);
                $("#RECIBIDO_POR").val(material.RECIBIDO_POR);
                $("#OBSERVACIONES_BITACORA").val(material.OBSERVACIONES_BITACORA);
                $("#FUNCIONAMIENTO_BITACORA").val(material.FUNCIONAMIENTO_BITACORA);
                $("#FINALIZAR_BITACORA_CONSUMBIBLES").val(material.FINALIZAR_BITACORA_CONSUMBIBLES);

               
                if (material.FIRMA_RECIBIDO_POR) {
                    let img1 = new Image();
                    img1.onload = function () {
                        ctx1.drawImage(img1, 0, 0, canvas1.width, canvas1.height);
                    };
                    img1.src = material.FIRMA_RECIBIDO_POR;

                    $("#FIRMA_RECIBIDO_POR").val(material.FIRMA_RECIBIDO_POR);
                }

                if (material.FIRMA_ENTREGADO_POR) {
                    let img2 = new Image();
                    img2.onload = function () {
                        ctx2.drawImage(img2, 0, 0, canvas2.width, canvas2.height);
                    };
                    img2.src = material.FIRMA_ENTREGADO_POR;

                    $("#FIRMA_ENTREGADO_POR").val(material.FIRMA_ENTREGADO_POR);
                }

            } else {
                $("#ID_BITACORAS_ALMACEN").val(0);
                $("#RECIBIDO_POR").val("");
                $("#OBSERVACIONES_BITACORA").val("");
            }

            // $("#miModal_BITACORA").modal("show");

            const modalElement = document.getElementById('miModal_BITACORA');

            const modalBitacora = new bootstrap.Modal(modalElement, {
                backdrop: 'static', 
                keyboard: false     
            });

            modalBitacora.show();

            $('#miModal_BITACORA .modal-title').html(material.DESCRIPCION);
        },

        error: function () {
            alert("Error al obtener el material individual.");
        }
    });
});

$(document).on('click', '.visualizarMaterial', function () {

    ID_FORM_GLOBAL = $(this).data('id');
    ID_INVENTARIO_GLOBAL = $(this).data('inventario');

    $.ajax({
        url: '/obtenerMaterialIndividual',
        method: 'GET',
        data: { id: ID_FORM_GLOBAL, inventario: ID_INVENTARIO_GLOBAL },

        success: function (res) {

            if (!res.success) {
                alert(res.message || "No se pudo obtener el material.");
                return;
            }


            $("#guardaBITACORA").hide();

        
            let material = res.material;

            let canvas1 = document.getElementById("firmaCanvas");
            let canvas2 = document.getElementById("firmaCanvas2");

            let ctx1 = canvas1.getContext("2d");
            let ctx2 = canvas2.getContext("2d");

          
            canvas1.width = canvas1.width; 
            canvas2.width = canvas2.width;

            $("#FIRMA_RECIBIDO_POR").val("");
            $("#FIRMA_ENTREGADO_POR").val("");

           
            $("#SOLICITANTE_SALIDA").val(material.SOLICITANTE_SALIDA);
            $("#FECHA_ALMACEN_SOLICITUD").val(material.FECHA_ALMACEN_SOLICITUD);
            $("#DESCRIPCION").val(material.DESCRIPCION);
            $("#CANTIDAD").val(material.CANTIDAD);
            $("#CANTIDAD_SALIDA").val(material.CANTIDAD_SALIDA);
            $("#UNIDAD_SALIDA").val(material.UNIDAD_SALIDA);
            $("#INVENTARIO").val(material.INVENTARIO);
            $("#OBSERVACIONES_REC").val(material.OBSERVACIONES_REC);
            $("#ENTREGADO_POR").val(material.ENTREGADO_POR);

            if (material.YA_GUARDADO) {

                $("#ID_BITACORAS_ALMACEN").val(material.ID_BITACORAS_ALMACEN);
                $("#RECIBIDO_POR").val(material.RECIBIDO_POR);
                $("#OBSERVACIONES_BITACORA").val(material.OBSERVACIONES_BITACORA);
                $("#FUNCIONAMIENTO_BITACORA").val(material.FUNCIONAMIENTO_BITACORA);
                $("#FINALIZAR_BITACORA_CONSUMBIBLES").val(material.FINALIZAR_BITACORA_CONSUMBIBLES);

               
                if (material.FIRMA_RECIBIDO_POR) {
                    let img1 = new Image();
                    img1.onload = function () {
                        ctx1.drawImage(img1, 0, 0, canvas1.width, canvas1.height);
                    };
                    img1.src = material.FIRMA_RECIBIDO_POR;

                    $("#FIRMA_RECIBIDO_POR").val(material.FIRMA_RECIBIDO_POR);
                }

                if (material.FIRMA_ENTREGADO_POR) {
                    let img2 = new Image();
                    img2.onload = function () {
                        ctx2.drawImage(img2, 0, 0, canvas2.width, canvas2.height);
                    };
                    img2.src = material.FIRMA_ENTREGADO_POR;

                    $("#FIRMA_ENTREGADO_POR").val(material.FIRMA_ENTREGADO_POR);
                }

            } else {
                $("#ID_BITACORAS_ALMACEN").val(0);
                $("#RECIBIDO_POR").val("");
                $("#OBSERVACIONES_BITACORA").val("");
            }

            // $("#miModal_BITACORA").modal("show");
            const modalElement = document.getElementById('miModal_BITACORA');

            const modalBitacora = new bootstrap.Modal(modalElement, {
                backdrop: 'static', 
                keyboard: false     
            });

            modalBitacora.show();
            
            $('#miModal_BITACORA .modal-title').html(material.DESCRIPCION);
        },

        error: function () {
            alert("Error al obtener el material individual.");
        }
    });
});

function cargarFirmaEnCanvas(canvas, ctx, base64) {
    let img = new Image();
    img.onload = function () {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
    };
    img.src = base64;
}

$("#guardaBITACORA").click(function (e) {
    e.preventDefault();

        formularioValido = validarFormulario3($('#formularioBITACORA'))

    if (formularioValido) {

    if (ID_BITACORAS_ALMACEN == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardaBITACORA')
            await ajaxAwaitFormData({ api: 1, ID_BITACORAS_ALMACEN: ID_BITACORAS_ALMACEN,RECEMPLEADO_ID:ID_FORM_GLOBAL,INVENTARIO_ID: ID_INVENTARIO_GLOBAL}, 'BitacoraSave', 'formularioBITACORA', 'guardaBITACORA', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                    ID_BITACORAS_ALMACEN = data.bitacora.ID_BITACORAS_ALMACEN
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_BITACORA').modal('hide')
                    document.getElementById('formularioBITACORA').reset();
                    Tablabitacoraconsumibles.ajax.reload()
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardaBITACORA')
                 await ajaxAwaitFormData({ api: 1, ID_BITACORAS_ALMACEN: ID_BITACORAS_ALMACEN,RECEMPLEADO_ID:ID_FORM_GLOBAL,INVENTARIO_ID: ID_INVENTARIO_GLOBAL}, 'BitacoraSave', 'formularioBITACORA', 'guardaBITACORA', { callbackAfter: true, callbackBefore: true }, () => {        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_BITACORAS_ALMACEN = data.bitacora.ID_BITACORAS_ALMACEN
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                    $('#miModal_BITACORA').modal('hide')
                    document.getElementById('formularioBITACORA').reset();
                    Tablabitacoraconsumibles.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});


