ID_FORMULARIO_INVENTARIO = 0
ID_ENTRADA_FORMULARIO = 0
ID_DOCUMENTO_ARTICULO = 0
ID_DOCUMENTO_CALIBRACION = 0
ID_INFORMACION_MTTO = 0


var inventario_id = null; 


const Modalinventario = document.getElementById('Modal_inventario')
Modalinventario.addEventListener('hidden.bs.modal', event => {
    
    ID_FORMULARIO_INVENTARIO = 0
    document.getElementById('formularioINVENTARIO').reset();
   
    $('#CANTIDAD_EQUIPO').prop('readonly', false);
    $('#LIMITEMINIMO_EQUIPO').prop('readonly', false);

    $('#Modal_inventario .modal-title').html('Equipo');

})

function obtenerModalPadre(elemento) {
    const modalBody = $(elemento).closest(".modal-body");

    if (modalBody.length > 0) {
        return modalBody; 
    }

    const modal = $(elemento).closest(".modal");

    if (modal.length > 0) {
        return modal;
    }

    return $("body");
}



function initSelectProveedor() {

    const select = $('#PROVEEDOR_EQUIPO');

    if (select.hasClass("select2-hidden-accessible")) {
        select.select2('destroy');
    }

    select.select2({
        dropdownParent: obtenerModalPadre(select),
        width: '100%',
        placeholder: 'Seleccionar proveedor',
        allowClear: true
    });
}



$("#guardarINVENTARIO").click(function (e) {
    e.preventDefault();


            formularioValido = validarFormulario3($('#formularioINVENTARIO'))

    if (formularioValido) {

    if (ID_FORMULARIO_INVENTARIO == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarINVENTARIO')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_INVENTARIO: ID_FORMULARIO_INVENTARIO }, 'MantenimientoSave', 'formularioINVENTARIO', 'guardarINVENTARIO', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_FORMULARIO_INVENTARIO = data.inventario.ID_FORMULARIO_INVENTARIO
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#Modal_inventario').modal('hide')
                    document.getElementById('formularioINVENTARIO').reset();
                    Tablamantenimiento.ajax.reload()

        
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarINVENTARIO')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_INVENTARIO: ID_FORMULARIO_INVENTARIO }, 'MantenimientoSave', 'formularioINVENTARIO', 'guardarINVENTARIO', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_FORMULARIO_INVENTARIO = data.inventario.ID_FORMULARIO_INVENTARIO
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#Modal_inventario').modal('hide')
                    document.getElementById('formularioINVENTARIO').reset();
                    Tablamantenimiento.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});



var Tablamantenimiento = $("#Tablamantenimiento").DataTable({
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
        method: 'GET',
        url: '/Tablamantenimiento',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablamantenimiento.columns.adjust().draw();
            ocultarCarga();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
    columnDefs: [
        { targets: '_all', className: 'text-center' }, 
        { targets: 0,  width:  '50px' },
        { targets: 1,  width:  '250px' },
        { targets: 2,  width:  '120px'},
        { targets: 3,  width:  '120px'},
        { targets: 4,  width:  '120px'},
        { targets: 5,  width:  '120px'},
        { targets: 6,  width:  '250px'},
        { targets: 7,  width:  '120px'},
        { targets: 8,  width:  '70px' },
        { targets: 9, width:  '70px' },
        { targets: 10, width:  '70px' }                                 
    ],
    columns: [
        { 
            data: null,
            render: function(data, type, row, meta) {
                return meta.row + 1; 
            }
        },
        { data: 'DESCRIPCION_EQUIPO' },
        //  { data: 'CANTIDAD_EQUIPO' },
        {
            data: null,
            render: function (data) {
                let cantidad = data.CANTIDAD_EQUIPO || '';
                let unidad = data.UNIDAD_MEDIDA || '';
                return `${cantidad} (${unidad})`;
            }
        },
        { data: 'MARCA_EQUIPO' },
        { data: 'MODELO_EQUIPO' },
        { data: 'SERIE_EQUIPO' },
        { data: 'UBICACION_EQUIPO' },
        { data: 'CODIGO_EQUIPO' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
        
       
  ],
    createdRow: function (row, data) {
        $(row).addClass(data.ROW_CLASS);
    },
      infoCallback: function (settings, start, end, max, total, pre) {
            return `Total de ${total} registros`;
    },
    drawCallback: function () {
        const topScroll = document.querySelector('.tabla-scroll-top');
        const scrollInner = document.querySelector('.tabla-scroll-top .scroll-inner');
        const table = document.querySelector('#Tablamantenimiento');
        const scrollBody = document.querySelector('.dataTables_scrollBody');

        if (!topScroll || !scrollInner || !table || !scrollBody) return;

        const tableWidth = table.scrollWidth;

        scrollInner.style.width = tableWidth + 'px';

        let syncingTop = false;
        let syncingBottom = false;

        topScroll.addEventListener('scroll', function () {
            if (syncingTop) return;
            syncingBottom = true;
            scrollBody.scrollLeft = topScroll.scrollLeft;
            syncingBottom = false;
        });

        scrollBody.addEventListener('scroll', function () {
            if (syncingBottom) return;
            syncingTop = true;
            topScroll.scrollLeft = scrollBody.scrollLeft;
            syncingTop = false;
        });
    }


});

document.getElementById('TIPO_EQUIPO').addEventListener('change', function () {
    const tipo = this.value;
    const divVehiculos = document.getElementById('DATOS_VEHICULOS');

    if (tipo === 'Vehículos') {
        divVehiculos.style.display = 'block';
    } else {
        divVehiculos.style.display = 'none';
    }
});

$('#Tablamantenimiento tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablamantenimiento.row(tr);
    ID_FORMULARIO_INVENTARIO = row.data().ID_FORMULARIO_INVENTARIO;



    inventario_id = row.data().ID_FORMULARIO_INVENTARIO;

    $("#tab1-info").click();

   $("#tab2-documentos").off("click").on("click", function () {
       cargarTablaDocumentosEquipo();
       
    });
    
     $("#tab6-entrada").off("click").on("click", function () {
        cargartablaentradainventario();
    });

    $("#tab6-entrada").show();


    cargarDocumentos(inventario_id);
    

    editarDatoTablainventario(row.data(), 'formularioINVENTARIO', 'Modal_inventario', 1);


    if (row.data().FOTO_EQUIPO) {
        var archivo = row.data().FOTO_EQUIPO;
        var extension = archivo.substring(archivo.lastIndexOf("."));
        var imagenUrl = '/mostrarFotoEquipoMan/' + row.data().ID_FORMULARIO_INVENTARIO + extension;

        if ($('#FOTO_EQUIPO').data('dropify')) {
            $('#FOTO_EQUIPO').dropify().data('dropify').destroy();
            $('#FOTO_EQUIPO').dropify().data('dropify').settings.defaultFile = imagenUrl;
            $('#FOTO_EQUIPO').dropify().data('dropify').init();
        } else {
            $('#FOTO_EQUIPO').attr('data-default-file', imagenUrl);
            $('#FOTO_EQUIPO').dropify({
                messages: {
                    'default': 'Arrastre la imagen aquí o haga click',
                    'replace': 'Arrastre la imagen o haga clic para reemplazar',
                    'remove': 'Quitar',
                    'error': 'Ooops, ha ocurrido un error.'
                }
            });
        }
    } else {
        $('#FOTO_EQUIPO').dropify().data('dropify').resetPreview();
        $('#FOTO_EQUIPO').dropify().data('dropify').clearElement();
    }

    $('#Modal_inventario .modal-title').html(row.data().DESCRIPCION_EQUIPO);

   
    const cantidad = document.getElementById("CANTIDAD_EQUIPO");
    const unitario = document.getElementById("UNITARIO_EQUIPO");
    const total = document.getElementById("TOTAL_EQUIPO");

    function calcularTotal() {
        let cant = parseFloat(cantidad.value) || 0;
        let precio = parseFloat(unitario.value) || 0;

        if (cant === 0 || precio === 0) {
            total.value = "0.00";
        } else {
            total.value = (cant * precio).toFixed(2);
        }
    }

    cantidad.removeEventListener("input", calcularTotal); 
    unitario.removeEventListener("input", calcularTotal);
    cantidad.addEventListener("input", calcularTotal);
    unitario.addEventListener("input", calcularTotal);

    calcularTotal();



     if (row.data().PROVEEDOR_ALTA === '1') {

    $('#PROVEEDORES_ACTIVOS').show();
    $('#ESCRIBIR_PROVEEDOR').hide();

    } else if (row.data().PROVEEDOR_ALTA === '2') {

        $('#PROVEEDORES_ACTIVOS').hide();
        $('#ESCRIBIR_PROVEEDOR').show();

    } else {
        $('#PROVEEDORES_ACTIVOS').show();
        $('#ESCRIBIR_PROVEEDOR').hide();
    }
       
    if (row.data().TIPO_EQUIPO === 'Vehículos') {
        $('#DATOS_VEHICULOS').show();
    } else {
        $('#DATOS_VEHICULOS').hide();
    }

    
    $.get('/cantidadEquipoReadonlyMan', function (resp) {

    if (resp.readonly === true) {
        $('#CANTIDAD_EQUIPO').attr('readonly', true);
        $('#LIMITEMINIMO_EQUIPO').attr('readonly', true);

    } else {
        $('#CANTIDAD_EQUIPO').removeAttr('readonly');
        $('#LIMITEMINIMO_EQUIPO').removeAttr('readonly');

    }
        
    });


    if (row.data().REQUIERE_CALIBRACION === "1") {
       $("#tab3-calibracion").show();
    } else if (row.data().REQUIERE_CALIBRACION === "2") {
       $("#tab3-calibracion").hide();
       
    }  else {
       $("#tab3-calibracion").hide();
    }



     if (row.data().DETALLAR_ARTICULOS === "1") {
       $("#tab5-detalle").show();
      
    } else {
       $("#tab5-detalle").hide();

    }


    $("#tab5-detalle").off("click").on("click", function () {
        cargarTablaDetallaArticulo();
    });



    initSelectProveedor();

    if (row.data().PROVEEDOR_EQUIPO) {
    $('#PROVEEDOR_EQUIPO')
        .val(row.data().PROVEEDOR_EQUIPO)
        .trigger('change');
    }

    $("#tab3-calibracion").off("click").on("click", function () {
       cargarTablaDocumentosCalibracion();
       
    });
    

    $("#tab4-mtto").off("click").on("click", function () {
        SelectProveedormtto();
        cargarInformacionMtto();

    });

});


function SelectProveedormtto() {

    const select = $('#PROVEEDOR_INTERNO_MTTO');

    if (select.hasClass("select2-hidden-accessible")) {
        select.select2('destroy');
    }

    select.select2({
        dropdownParent: obtenerModalPadre(select),
        width: '100%',
        placeholder: 'Seleccionar proveedor',
        allowClear: true
    });
}


$(document).ready(function() {
    $('#Tablamantenimiento tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablamantenimiento.row(tr);
        
        hacerSoloLecturainventario(row.data(), '#Modal_inventario');

        ID_FORMULARIO_INVENTARIO = row.data().ID_FORMULARIO_INVENTARIO;

        inventario_id = row.data().ID_FORMULARIO_INVENTARIO;
    
        $("#tab1-info").click();
    
         $("#tab2-documentos").off("click").on("click", function () {
            cargarTablaDocumentosEquipo();
         });
        
         $("#tab6-entrada").off("click").on("click", function () {
            cargartablaentradainventario();
        });

        $("#tab6-entrada").show();

        
        cargarDocumentos(inventario_id);

        editarDatoTablainventario(row.data(), 'formularioINVENTARIO', 'Modal_inventario', 1);
        

        if (row.data().FOTO_EQUIPO) {
        var archivo = row.data().FOTO_EQUIPO;
        var extension = archivo.substring(archivo.lastIndexOf("."));
        var imagenUrl = '/mostrarFotoEquipoMan/' + row.data().ID_FORMULARIO_INVENTARIO + extension;

        if ($('#FOTO_EQUIPO').data('dropify')) {
            $('#FOTO_EQUIPO').dropify().data('dropify').destroy();
            $('#FOTO_EQUIPO').dropify().data('dropify').settings.defaultFile = imagenUrl;
            $('#FOTO_EQUIPO').dropify().data('dropify').init();
        } else {
            $('#FOTO_EQUIPO').attr('data-default-file', imagenUrl);
            $('#FOTO_EQUIPO').dropify({
                messages: {
                    'default': 'Arrastre la imagen aquí o haga click',
                    'replace': 'Arrastre la imagen o haga clic para reemplazar',
                    'remove': 'Quitar',
                    'error': 'Ooops, ha ocurrido un error.'
                },
                error: {
                    'fileSize': 'Demasiado grande ({{ value }} max).',
                    'minWidth': 'Ancho demasiado pequeño (min {{ value }}}px).',
                    'maxWidth': 'Ancho demasiado grande (max {{ value }}}px).',
                    'minHeight': 'Alto demasiado pequeño (min {{ value }}}px).',
                    'maxHeight': 'Alto demasiado grande (max {{ value }}px).',
                    'imageFormat': 'Formato no permitido, sólo ({{ value }}).'
                }
            });
        }
    } else {
        $('#FOTO_EQUIPO').dropify().data('dropify').resetPreview();
        $('#FOTO_EQUIPO').dropify().data('dropify').clearElement();
        }
        
        $('#Modal_inventario .modal-title').html(row.data().DESCRIPCION_EQUIPO);
        
        
                
        const cantidad = document.getElementById("CANTIDAD_EQUIPO");
        const unitario = document.getElementById("UNITARIO_EQUIPO");
        const total = document.getElementById("TOTAL_EQUIPO");

        function calcularTotal() {
            let cant = parseFloat(cantidad.value) || 0;
            let precio = parseFloat(unitario.value) || 0;

            if (cant === 0 || precio === 0) {
                total.value = "0.00";
            } else {
                total.value = (cant * precio).toFixed(2);
            }
        }

        cantidad.removeEventListener("input", calcularTotal); 
        unitario.removeEventListener("input", calcularTotal);
        cantidad.addEventListener("input", calcularTotal);
        unitario.addEventListener("input", calcularTotal);

        calcularTotal();
                   
        
       if (row.data().PROVEEDOR_ALTA === '1') {

    $('#PROVEEDORES_ACTIVOS').show();
    $('#ESCRIBIR_PROVEEDOR').hide();

    } else if (row.data().PROVEEDOR_ALTA === '2') {

        $('#PROVEEDORES_ACTIVOS').hide();
        $('#ESCRIBIR_PROVEEDOR').show();

    } else {
        $('#PROVEEDORES_ACTIVOS').show();
        $('#ESCRIBIR_PROVEEDOR').hide();
    }
        
    
    if (row.data().TIPO_EQUIPO === 'Vehículos') {
        $('#DATOS_VEHICULOS').show();
    } else {
        $('#DATOS_VEHICULOS').hide();
    }
     
        
    if (row.data().REQUIERE_CALIBRACION === "1") {
       $("#tab3-calibracion").show();
    } else if (row.data().REQUIERE_CALIBRACION === "2") {
       $("#tab3-calibracion").hide();
       
    }  else {
       $("#tab3-calibracion").hide();
    }

        
    if (row.data().DETALLAR_ARTICULOS === "1") {
       $("#tab5-detalle").show();
      
    } else {
       $("#tab5-detalle").hide();

    }
        
    $("#tab5-detalle").off("click").on("click", function () {
        cargarTablaDetallaArticulo();
    });

    initSelectProveedor();

    if (row.data().PROVEEDOR_EQUIPO) {
        $('#PROVEEDOR_EQUIPO')
        .val(row.data().PROVEEDOR_EQUIPO)
        .trigger('change');
    }
        
        
    $("#tab4-mtto").off("click").on("click", function () {
        SelectProveedormtto();
        cargarInformacionMtto();

    });
        
        
    });

    $('#Modal_inventario').on('hidden.bs.modal', function () {
        resetFormulario('#Modal_inventario');
    });
});

$('#Tablamantenimiento tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablamantenimiento.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_FORMULARIO_INVENTARIO: row.data().ID_FORMULARIO_INVENTARIO
    };

    eliminarDatoTabla(data, [Tablamantenimiento], 'MantenimientoDelete');
});

document.addEventListener("DOMContentLoaded", function () {
    const cantidad = document.getElementById("CANTIDAD_EQUIPO");
    const unitario = document.getElementById("UNITARIO_EQUIPO");
    const total = document.getElementById("TOTAL_EQUIPO");

    function calcularTotal() {
        let cant = parseFloat(cantidad.value) || 0;
        let precio = parseFloat(unitario.value) || 0;
        let resultado = cant * precio;

        total.value = resultado.toFixed(2); 
    }

    cantidad.addEventListener("input", calcularTotal);
    unitario.addEventListener("input", calcularTotal);
});

document.addEventListener("DOMContentLoaded", function () {

    const proveedorAlta = document.getElementById("PROVEEDOR_ALTA");
    const proveedoresActivos = document.getElementById("PROVEEDORES_ACTIVOS");
    const escribirProveedor = document.getElementById("ESCRIBIR_PROVEEDOR");

    proveedoresActivos.style.display = "none";
    escribirProveedor.style.display = "none";

    proveedorAlta.addEventListener("change", function () {

        if (this.value === "1") {
            proveedoresActivos.style.display = "block";
            escribirProveedor.style.display = "none";
        }

        if (this.value === "2") {
            proveedoresActivos.style.display = "none";
            escribirProveedor.style.display = "block";
        }

    });
});


////////////////////////////////// DOCUMENTOS ARTICULO //////////////////////////////////

const Modaldocumento = document.getElementById('miModal_DOCUMENTOS')
Modaldocumento.addEventListener('hidden.bs.modal', event => {
     
    ID_DOCUMENTO_ARTICULO = 0
    document.getElementById('formularioDOCUMENTOS').reset();
    $('#miModal_DOCUMENTOS .modal-title').html('Nuevo documento ');
   
    document.getElementById('FECHA_DOCUMENTO').style.display = 'none';

    const fechaFin = document.getElementById('FECHAF_DOCUMENTO');
    fechaFin.disabled = false;

})

$("#NUEVA_DOCUMENTACION").click(function (e) {
    e.preventDefault();

    $('#formularioDOCUMENTOS').each(function(){
        this.reset();
    });


    var drEvent = $('#FOTO_DOCUMENTO').dropify({
        messages: {
            'default': 'Arrastre la imagen aquí o haga clic',
            'replace': 'Arrastre la imagen aquí o haga clic para reemplazar',
            'remove': 'Quitar',
            'error': 'Ooops, ha ocurrido un error.'
        },
        error: {
            'fileSize': 'El archivo es demasiado grande (máx. {{ value }}).',
            'minWidth': 'El ancho de la imagen es demasiado pequeño (mín. {{ value }}px).',
            'maxWidth': 'El ancho de la imagen es demasiado grande (máx. {{ value }}px).',
            'minHeight': 'La altura de la imagen es demasiado pequeña (mín. {{ value }}px).',
            'maxHeight': 'La altura de la imagen es demasiado grande (máx. {{ value }}px).',
            'imageFormat': 'Formato no permitido, sólo se aceptan: ({{ value }}).'
        }
    });

        

    drEvent = drEvent.data('dropify');
    drEvent.resetPreview();  
    drEvent.clearElement();  
    

    $("#miModal_DOCUMENTOS").modal("show");
   
    $('#FECHAF_DOCUMENTO').prop('required', false).removeClass('validar');

    $('#DIV_REQUIERE_FECHA').hide();
    $('#FECHA_DOCUMENTO').hide();
    $('#SUBIR_DOCUMENTO').hide();
    $('#IMAGEN_DOCUMENTOS').hide();


});

document.addEventListener('DOMContentLoaded', function () {
    const contratoSi = document.getElementById('fechasi');
    const contratoNo = document.getElementById('fechano');
    const documentoContrato = document.getElementById('FECHA_DOCUMENTO');

    function toggleDocumentoContrato() {
        if (contratoSi.checked) {
            documentoContrato.style.display = 'block';
        } else {
            documentoContrato.style.display = 'none';
        }
    }

    contratoSi.addEventListener('change', toggleDocumentoContrato);
    contratoNo.addEventListener('change', toggleDocumentoContrato);
});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".botonEliminarArchivo").forEach(boton => {
        boton.addEventListener("click", function () {
            const inputArchivo = this.previousElementSibling;
            if (inputArchivo && inputArchivo.type === "file") {
                inputArchivo.value = ""; 
            }
        });
    });
});

$(document).ready(function() {
    $('input[name="INDETERMINADO_DOCUMENTO"]').on('change', function() {
        if ($(this).val() === '1') { 
            $('#FECHAF_DOCUMENTO').prop('disabled', true).val('');
            $('#FECHAF_DOCUMENTO').prop('required', false).removeClass('validar error');

        } else {
            $('#FECHAF_DOCUMENTO').prop('disabled', false);
            $('#FECHAF_DOCUMENTO').prop('required', true).addClass('validar error');
        }
    });
});

$("#guardarDOCUMENTACION").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario3($('#formularioDOCUMENTOS'))

    if (formularioValido) {

    if (ID_DOCUMENTO_ARTICULO == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarDOCUMENTACION')
            await ajaxAwaitFormData({ api: 3,INVENTARIO_ID:inventario_id, ID_DOCUMENTO_ARTICULO: ID_DOCUMENTO_ARTICULO }, 'MantenimientoSave', 'formularioDOCUMENTOS', 'guardarDOCUMENTACION', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
                
            }, function (data) {
                    
                ID_DOCUMENTO_ARTICULO = data.cliente.ID_DOCUMENTO_ARTICULO
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_DOCUMENTOS').modal('hide')
                    document.getElementById('formularioDOCUMENTOS').reset();


                    
                    if ($.fn.DataTable.isDataTable('#Tabladocumentomantenimiento')) {
                        Tabladocumentomantenimiento.ajax.reload(null, false); 
                    }

            })
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarDOCUMENTACION')
            await ajaxAwaitFormData({ api: 3,INVENTARIO_ID:inventario_id ,ID_DOCUMENTO_ARTICULO: ID_DOCUMENTO_ARTICULO }, 'MantenimientoSave', 'formularioDOCUMENTOS', 'guardarDOCUMENTACION', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
            }, function (data) {
                    
                setTimeout(() => {

                    ID_DOCUMENTO_ARTICULO = data.cliente.ID_DOCUMENTO_ARTICULO
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_DOCUMENTOS').modal('hide')
                    document.getElementById('formularioDOCUMENTOS').reset();


                    
                    if ($.fn.DataTable.isDataTable('#Tabladocumentomantenimiento')) {
                        Tabladocumentomantenimiento.ajax.reload(null, false); 
                    }

                }, 300);  
            })
        }, 1)
    }

    } else {
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

    }
    
});

function cargarTablaDocumentosEquipo() {
    if ($.fn.DataTable.isDataTable('#Tabladocumentomantenimiento')) {
        Tabladocumentomantenimiento.clear().destroy();
    }

    Tabladocumentomantenimiento = $("#Tabladocumentomantenimiento").DataTable({
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
            data: { equipo: inventario_id }, 
            method: 'GET',
            cache: false,
            url: '/Tabladocumentomantenimiento',  
            beforeSend: function () {
                $('#loadingIcon1').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon1').css('display', 'none');
                Tabladocumentomantenimiento.columns.adjust().draw(); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon1').css('display', 'none');
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            },
            dataSrc: 'data'
        },
        columns: [
            { data: null, render: function (data, type, row, meta) { return meta.row + 1; }, className: 'text-center' },
            { data: 'TIPO_DOCUMENTO_TEXTO', className: 'text-center' },
            { data: 'NOMBRE_DOCUMENTO', className: 'text-center' },
            { data: 'FECHAS_DOCUMENTOS' },
            {
                data: null,
                className: 'text-center',
                render: function (data, type, row) {

                    if (row.TIPO_DOCUMENTO == 1) {
                        return row.BTN_DOCUMENTO;
                    }

                    if (row.TIPO_DOCUMENTO == 2) {
                        return row.FOTO_DOCUMENTOS_HTML;
                    }

                    return '';
                }
            },
            { data: 'BTN_EDITAR', className: 'text-center' },
            { data: 'BTN_VISUALIZAR', className: 'text-center' },
            { data: 'BTN_ELIMINAR', className: 'text-center' },

        ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all text-center' },
            { targets: 1, title: 'Tipo de documento:', className: 'all text-center' },  
            { targets: 2, title: 'Nombre del documento:', className: 'all text-center' },  
            { targets: 3, title: 'Fecha documentos:', className: 'all text-center' },  
            { targets: 4, title: 'Documento/imagen', className: 'all text-center' },  
            { targets: 5, title: 'Editar', className: 'all text-center' }, 
            { targets: 6, title: 'Visualizar', className: 'all text-center' }, 
            { targets: 7, title: 'Activo', className: 'all text-center' }, 


        ],
       
    });
}

document.addEventListener('DOMContentLoaded', function () {

    const selectTipo = document.getElementById('TIPO_DOCUMENTO');

    const divRequiereFecha = document.getElementById('DIV_REQUIERE_FECHA');
    const divSubirDocumento = document.getElementById('SUBIR_DOCUMENTO');
    const divImagen = document.getElementById('IMAGEN_DOCUMENTOS');
    const divfechadocumento = document.getElementById('FECHA_DOCUMENTO');

    selectTipo.addEventListener('change', function () {

        if (this.value === "1") {
            // Documento
            divRequiereFecha.style.display = 'block';
            divSubirDocumento.style.display = 'block';
            divImagen.style.display = 'none';
        }

        if (this.value === "2") {
            // Imagen
            divRequiereFecha.style.display = 'none';
            divSubirDocumento.style.display = 'none';
            divfechadocumento.style.display = 'none';
            divImagen.style.display = 'block';
        }

    });

});

$('#Tabladocumentomantenimiento').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tabladocumentomantenimiento.row(tr);

    ID_DOCUMENTO_ARTICULO = row.data().ID_DOCUMENTO_ARTICULO;

    editarDatoTabla(row.data(), 'formularioDOCUMENTOS', 'miModal_DOCUMENTOS', 1);

    $('#miModal_DOCUMENTOS .modal-title').html(row.data().NOMBRE_DOCUMENTO);


     if (row.data().REQUIERE_FECHA == 1) {
        $('#FECHA_DOCUMENTO').show();
        $('#fechasi').prop('checked', true);
    } else {
        $('#FECHA_DOCUMENTO').hide();
        $('#fechano').prop('checked', true);
    }


    if (row.data().INDETERMINADO_DOCUMENTO == 1) {
        $('#indeterminadosi').prop('checked', true);
        $('#FECHAF_DOCUMENTO').prop('disabled', true).val('');
        $('#FECHAF_DOCUMENTO').prop('required', false);

    } else if (row.data().INDETERMINADO_DOCUMENTO == 2) {
        $('#indeterminadono').prop('checked', true);
        $('#FECHAF_DOCUMENTO').prop('disabled', false);
        $('#FECHAF_DOCUMENTO').prop('required', true);
    } else {
        $('#FECHAF_DOCUMENTO').prop('disabled', false);
    }

    if (row.data().TIPO_DOCUMENTO == 1) {
        $('#DIV_REQUIERE_FECHA').show();
        $('#SUBIR_DOCUMENTO').show();
        $('#IMAGEN_DOCUMENTOS').hide();
        
    } else {
        $('#DIV_REQUIERE_FECHA').hide();
        $('#FECHA_DOCUMENTO').hide();
        $('#SUBIR_DOCUMENTO').hide();
        $('#IMAGEN_DOCUMENTOS').show();
    
    if (row.data().FOTO_DOCUMENTO) {
        var archivo = row.data().FOTO_DOCUMENTO;
        var extension = archivo.substring(archivo.lastIndexOf("."));
        var imagenUrl = '/FotosDocMtto/' + row.data().ID_DOCUMENTO_ARTICULO + extension;

        if ($('#FOTO_DOCUMENTO').data('dropify')) {
            $('#FOTO_DOCUMENTO').dropify().data('dropify').destroy();
            $('#FOTO_DOCUMENTO').dropify().data('dropify').settings.defaultFile = imagenUrl;
            $('#FOTO_DOCUMENTO').dropify().data('dropify').init();
        } else {
            $('#FOTO_DOCUMENTO').attr('data-default-file', imagenUrl);
            $('#FOTO_DOCUMENTO').dropify({
                messages: {
                    'default': 'Arrastre la imagen aquí o haga click',
                    'replace': 'Arrastre la imagen o haga clic para reemplazar',
                    'remove': 'Quitar',
                    'error': 'Ooops, ha ocurrido un error.'
                }
            });
        }
    } else {
        $('#FOTO_DOCUMENTO').dropify().data('dropify').resetPreview();
        $('#FOTO_DOCUMENTO').dropify().data('dropify').clearElement();
        }
        
    }
    

});

$(document).ready(function() {
    $('#Tabladocumentomantenimiento').on('click', 'td>button.VISUALIZAR', function () {
    var tr = $(this).closest('tr');
    var row = Tabladocumentomantenimiento.row(tr);
        
    hacerSoloLecturainventario(row.data(), '#miModal_DOCUMENTOS');

    ID_DOCUMENTO_ARTICULO = row.data().ID_DOCUMENTO_ARTICULO;

    editarDatoTabla(row.data(), 'formularioDOCUMENTOS', 'miModal_DOCUMENTOS', 1);
        
    $('#miModal_DOCUMENTOS .modal-title').html(row.data().NOMBRE_DOCUMENTO);

        
    if (row.data().REQUIERE_FECHA == 1) {
        $('#FECHA_DOCUMENTO').show();
        $('#fechasi').prop('checked', true);
    } else {
        $('#FECHA_DOCUMENTO').hide();
        $('#fechano').prop('checked', true);
    }


    if (row.data().INDETERMINADO_DOCUMENTO == 1) {
        $('#indeterminadosi').prop('checked', true);
        $('#FECHAF_DOCUMENTO').prop('disabled', true).val('');
        $('#FECHAF_DOCUMENTO').prop('required', false);

    } else if (row.data().INDETERMINADO_DOCUMENTO == 2) {
        $('#indeterminadono').prop('checked', true);
        $('#FECHAF_DOCUMENTO').prop('disabled', false);
        $('#FECHAF_DOCUMENTO').prop('required', true);
    } else {
        $('#FECHAF_DOCUMENTO').prop('disabled', false);
    }

    if (row.data().TIPO_DOCUMENTO == 1) {
        $('#DIV_REQUIERE_FECHA').show();
        $('#SUBIR_DOCUMENTO').show();
        $('#IMAGEN_DOCUMENTOS').hide();
    } else {
        $('#DIV_REQUIERE_FECHA').hide();
        $('#FECHA_DOCUMENTO').hide();
        $('#SUBIR_DOCUMENTO').hide();
        $('#IMAGEN_DOCUMENTOS').show();
    

    if (row.data().FOTO_DOCUMENTO) {
        var archivo = row.data().FOTO_DOCUMENTO;
        var extension = archivo.substring(archivo.lastIndexOf("."));
        var imagenUrl = '/FotosDocMtto/' + row.data().ID_DOCUMENTO_ARTICULO + extension;

        if ($('#FOTO_DOCUMENTO').data('dropify')) {
            $('#FOTO_DOCUMENTO').dropify().data('dropify').destroy();
            $('#FOTO_DOCUMENTO').dropify().data('dropify').settings.defaultFile = imagenUrl;
            $('#FOTO_DOCUMENTO').dropify().data('dropify').init();
        } else {
            $('#FOTO_DOCUMENTO').attr('data-default-file', imagenUrl);
            $('#FOTO_DOCUMENTO').dropify({
                messages: {
                    'default': 'Arrastre la imagen aquí o haga click',
                    'replace': 'Arrastre la imagen o haga clic para reemplazar',
                    'remove': 'Quitar',
                    'error': 'Ooops, ha ocurrido un error.'
                }
            });
        }
    } else {
        $('#FOTO_DOCUMENTO').dropify().data('dropify').resetPreview();
        $('#FOTO_DOCUMENTO').dropify().data('dropify').clearElement();
        }
        
    }

    });

    $('#miModal_DOCUMENTOS').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_DOCUMENTOS');
    });
});

$('#Tabladocumentomantenimiento').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tabladocumentomantenimiento.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 3,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_DOCUMENTO_ARTICULO: row.data().ID_DOCUMENTO_ARTICULO
    };

    eliminarDatoTabla(data, [Tabladocumentomantenimiento], 'MantenimientoDelete');
});

$('#Tabladocumentomantenimiento').on('click', '.ver-archivo-documentosequipo', function (e) {
    e.preventDefault(); 
    e.stopPropagation(); 

    var tr = $(this).closest('tr');
    var row = Tabladocumentomantenimiento.row(tr).data();
    var id = $(this).data('id');

    if (!id || !row.DOCUMENTO_ARTICULO || row.DOCUMENTO_ARTICULO.trim() === "") {
        Swal.fire({
            icon: 'warning',
            title: 'Sin documento',
            text: 'Este registro no tiene documento.',
        });
        return;
    }

    var url = '/mostrardocumentomantenimiento/' + id;

    window.open(url, '_blank');
});


////////////////////////////////// FECHAS DOCUMENTOS //////////////////////////////////

function cargarDocumentos(inventario_id) {
    $.ajax({
        url: `/obtenerDocumentosPorMantenimiento/${inventario_id}`,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            const tbody = $('#tablaDocumentos tbody');
            tbody.empty();

            if (data.length > 0) {
                $('#MOSTRAR_ALERTA_DOCUMENTOS').show();

                data.forEach(doc => {
                    const fechaInicio = new Date(doc.FECHAI_DOCUMENTO);
                    const fechaFin = new Date(doc.FECHAF_DOCUMENTO);
                    const hoy = new Date();

                    let diasTotales = Math.ceil((fechaFin - fechaInicio) / (1000 * 60 * 60 * 24));
                    let diasRestantes = Math.ceil((fechaFin - hoy) / (1000 * 60 * 60 * 24));

                    if (diasTotales < 0) diasTotales = 0;
                    if (diasRestantes < 0) diasRestantes = 0;

                    const porcentaje = diasTotales > 0 
                        ? ((diasTotales - diasRestantes) / diasTotales) * 100 
                        : 100;

                    let color = 'success'; 
                    if (porcentaje >= 80) color = 'danger'; 
                    else if (porcentaje >= 60) color = 'warning'; 

                    const textoBadge = diasRestantes > 0
                        ? `${diasRestantes} días restantes`
                        : 'Vencido';

                    tbody.append(`
                        <tr>
                            <td class="text-center">${doc.NOMBRE_DOCUMENTO}</td>
                            <td class="text-center">
                                ${doc.FECHAI_DOCUMENTO} - ${doc.FECHAF_DOCUMENTO}<br>
                                <span class="badge bg-${color}">${textoBadge}</span>
                            </td>
                        </tr>
                    `);
                });
            } else {
                $('#MOSTRAR_ALERTA_DOCUMENTOS').hide();
            }
        },
        error: function () {
            console.error('Error al cargar los documentos.');
        }
    });
}

////////////////////////////////// CALIBRACION EQUIPO  //////////////////////////////////


const Modalcalibracion = document.getElementById('miModal_CALIBRACION')
Modalcalibracion.addEventListener('hidden.bs.modal', event => {
     
    ID_DOCUMENTO_CALIBRACION = 0
    document.getElementById('formularioCALIBRACION').reset();
    $('#miModal_CALIBRACION .modal-title').html('Nueva calibración');

    $('#PROVEEDORES_ALTA').hide();
    $('#ESCRIBIR_PROVEEDOR_CALIBRACION').hide();

})

function seleccionarproveedorcalibracion() {

    const select = $('#PROVEEDOR_CALIBRACION');

    if (select.hasClass("select2-hidden-accessible")) {
        select.select2('destroy');
    }

    select.select2({
        dropdownParent: obtenerModalPadre(select),
        width: '100%',
        placeholder: 'Seleccionar proveedor',
        allowClear: true
    });
}

$("#NUEVA_CALIBRACION").click(function (e) {
    e.preventDefault();

    seleccionarproveedorcalibracion();

    $('#formularioCALIBRACION').each(function(){
        this.reset();
    });

    $('#PROVEEDORES_ALTA').hide();
    $('#ESCRIBIR_PROVEEDOR_CALIBRACION').hide();

    $("#miModal_CALIBRACION").modal("show");
   
});

document.addEventListener('DOMContentLoaded', function () {

    const selectCalibracion = document.getElementById('REQUIERE_CALIBRACION');
    const tabCalibracion = document.getElementById('tab3-calibracion');

    selectCalibracion.addEventListener('change', function () {

        if (this.value === "1") {
            tabCalibracion.style.display = 'block';
        } else {
            tabCalibracion.style.display = 'none';
        }

    });

});

function guardarRequiereCalibracion() {

    const valor = document.getElementById('REQUIERE_CALIBRACION').value;

    if (!inventario_id || !valor) {
        return;
    }

    fetch('/guardarRequiereCalibracion', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            ID_FORMULARIO_INVENTARIO: inventario_id,
            REQUIERE_CALIBRACION: valor
        })
    })
    .then(response => response.json())
    .then(data => {

        if (data.code === 1) {
            Tablamantenimiento.ajax.reload(null, false);
        } else {
            alert('Error al guardar calibración');
        }

    })
    .catch(error => {
        console.error(error);
    });
}

document.addEventListener('DOMContentLoaded', function () {

    const selectAlta = document.getElementById('DADO_ALTA_CALIBRACION');
    const divProveedorAlta = document.getElementById('PROVEEDORES_ALTA');
    const divEscribirProveedor = document.getElementById('ESCRIBIR_PROVEEDOR_CALIBRACION');

    selectAlta.addEventListener('change', function () {

        if (this.value === "1") {
            divProveedorAlta.style.display = 'block';
            divEscribirProveedor.style.display = 'none';
        }

        if (this.value === "2") {
            divProveedorAlta.style.display = 'none';
            divEscribirProveedor.style.display = 'block';
        }

    });

});

$("#guardarDOCUMENTACIONCALIBRACION").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario3($('#formularioCALIBRACION'))

    if (formularioValido) {

    if (ID_DOCUMENTO_CALIBRACION == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarDOCUMENTACIONCALIBRACION')
            await ajaxAwaitFormData({ api: 4,MANTENIMIENTO_ID:inventario_id, ID_DOCUMENTO_CALIBRACION: ID_DOCUMENTO_CALIBRACION }, 'MantenimientoSave', 'formularioCALIBRACION', 'guardarDOCUMENTACIONCALIBRACION', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
                
            }, function (data) {
                    
                ID_DOCUMENTO_CALIBRACION = data.cliente.ID_DOCUMENTO_CALIBRACION
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_CALIBRACION').modal('hide')
                    document.getElementById('formularioCALIBRACION').reset();
  
                    if ($.fn.DataTable.isDataTable('#Tablacalibracionmantenimiento')) {
                        Tablacalibracionmantenimiento.ajax.reload(null, false); 
                    }

            })
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarDOCUMENTACIONCALIBRACION')
            await ajaxAwaitFormData({ api: 4,MANTENIMIENTO_ID:inventario_id ,ID_DOCUMENTO_CALIBRACION: ID_DOCUMENTO_CALIBRACION }, 'MantenimientoSave', 'formularioCALIBRACION', 'guardarDOCUMENTACIONCALIBRACION', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
            }, function (data) {
                    
                setTimeout(() => {

                    ID_DOCUMENTO_CALIBRACION = data.cliente.ID_DOCUMENTO_CALIBRACION
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_CALIBRACION').modal('hide')
                    document.getElementById('formularioCALIBRACION').reset();


                    
                    if ($.fn.DataTable.isDataTable('#Tablacalibracionmantenimiento')) {
                        Tablacalibracionmantenimiento.ajax.reload(null, false); 
                    }

                }, 300);  
            })
        }, 1)
    }

    } else {
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

    }
    
});

function cargarTablaDocumentosCalibracion() {
    if ($.fn.DataTable.isDataTable('#Tablacalibracionmantenimiento')) {
        Tablacalibracionmantenimiento.clear().destroy();
    }

    Tablacalibracionmantenimiento = $("#Tablacalibracionmantenimiento").DataTable({
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
            data: { equipo: inventario_id }, 
            method: 'GET',
            cache: false,
            url: '/Tablacalibracionmantenimiento',  
            beforeSend: function () {
                $('#loadingIcon2').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon2').css('display', 'none');
                Tablacalibracionmantenimiento.columns.adjust().draw(); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon2').css('display', 'none');
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            },
            dataSrc: 'data'
        },
        order: [[0, 'desc']], 
        columns: [
            { data: null, render: function (data, type, row, meta) { return meta.row + 1; }, className: 'text-center' },
            { data: 'NOMBRE_DOCUMENTO_CALIBRACION', className: 'text-center' },
            { data: 'FECHAS_CALIBRACION', className: 'text-center' },
            { data: 'BTN_DOCUMENTO' },
            { data: 'BTN_EDITAR', className: 'text-center' },
            { data: 'BTN_VISUALIZAR', className: 'text-center' },
            { data: 'BTN_ELIMINAR', className: 'text-center' },

        ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all text-center' },
            { targets: 1, title: 'Nombre del documento:', className: 'all text-center' },  
            { targets: 2, title: 'Fecha calibración:', className: 'all text-center' },  
            { targets: 3, title: 'Documento', className: 'all text-center' },  
            { targets: 4, title: 'Editar', className: 'all text-center' }, 
            { targets: 5, title: 'Visualizar', className: 'all text-center' }, 
            { targets: 6, title: 'Activo', className: 'all text-center' }, 


        ],
       
    });
}

$('#Tablacalibracionmantenimiento').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacalibracionmantenimiento.row(tr);

    ID_DOCUMENTO_CALIBRACION = row.data().ID_DOCUMENTO_CALIBRACION;

    editarDatoTabla(row.data(), 'formularioCALIBRACION', 'miModal_CALIBRACION', 1);

    $('#miModal_CALIBRACION .modal-title').html(row.data().NOMBRE_DOCUMENTO_CALIBRACION);


    if (row.data().DADO_ALTA_CALIBRACION == 1) {
        $('#PROVEEDORES_ALTA').show();
        $('#ESCRIBIR_PROVEEDOR_CALIBRACION').hide();
         
        seleccionarproveedorcalibracion();

        if (row.data().PROVEEDOR_CALIBRACION) {
        $('#PROVEEDOR_CALIBRACION')
            .val(row.data().PROVEEDOR_CALIBRACION)
            .trigger('change');
         }
         
    } else {
        $('#PROVEEDORES_ALTA').hide();
        $('#ESCRIBIR_PROVEEDOR_CALIBRACION').show();
    }


});

$(document).ready(function() {
    $('#Tablacalibracionmantenimiento').on('click', 'td>button.VISUALIZAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacalibracionmantenimiento.row(tr);
        
    hacerSoloLecturainventario(row.data(), '#miModal_CALIBRACION');
    
    ID_DOCUMENTO_CALIBRACION = row.data().ID_DOCUMENTO_CALIBRACION;

    editarDatoTabla(row.data(), 'formularioCALIBRACION', 'miModal_CALIBRACION', 1);

    $('#miModal_CALIBRACION .modal-title').html(row.data().NOMBRE_DOCUMENTO_CALIBRACION);


    if (row.data().DADO_ALTA_CALIBRACION == 1) {
        $('#PROVEEDORES_ALTA').show();
        $('#ESCRIBIR_PROVEEDOR_CALIBRACION').hide();
         
        seleccionarproveedorcalibracion();

        if (row.data().PROVEEDOR_CALIBRACION) {
            $('#PROVEEDOR_CALIBRACION')
            .val(row.data().PROVEEDOR_CALIBRACION)
            .trigger('change');
        }
         
    } else {
        $('#PROVEEDORES_ALTA').hide();
        $('#ESCRIBIR_PROVEEDOR_CALIBRACION').show();
    }


   
        
        
    });

    $('#miModal_CALIBRACION').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_CALIBRACION');
    });
});

$('#Tablacalibracionmantenimiento').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacalibracionmantenimiento.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 4,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_DOCUMENTO_CALIBRACION: row.data().ID_DOCUMENTO_CALIBRACION
    };

    eliminarDatoTabla(data, [Tablacalibracionmantenimiento], 'MantenimientoDelete');
});

$('#Tablacalibracionmantenimiento').on('click', '.ver-archivo-documentoscalibracion', function (e) {
    e.preventDefault(); 
    e.stopPropagation(); 

    var tr = $(this).closest('tr');
    var row = Tablacalibracionmantenimiento.row(tr).data();
    var id = $(this).data('id');

    if (!id || !row.DOCUMENTO_CALIBRACION || row.DOCUMENTO_CALIBRACION.trim() === "") {
        Swal.fire({
            icon: 'warning',
            title: 'Sin documento',
            text: 'Este registro no tiene documento.',
        });
        return;
    }

    var url = '/mostrardocumentocalibracion/' + id;

    window.open(url, '_blank');
});


//////////////////////////////////  MTTO  //////////////////////////////////

/// CRITERIO


document.addEventListener('DOMContentLoaded', function () {

    const selectproveedores = document.getElementById('PROVEEDOR_INTEXT_MTTO');
    const divProveedorinterno = document.getElementById('PROVEEDORES_INTERNO');
    const divEscribirExterno = document.getElementById('PROVEEDORES_EXTERNO');

    selectproveedores.addEventListener('change', function () {

        if (this.value === "1") {
            divProveedorinterno.style.display = 'block';
            divEscribirExterno.style.display = 'none';
        }

        if (this.value === "2") {
            divProveedorinterno.style.display = 'none';
            divEscribirExterno.style.display = 'block';
        }

    });

});



$("#guardarMTTO").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario3($('#formularioINVENTARIO'))

    if (formularioValido) {

    if (ID_INFORMACION_MTTO == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarMTTO')
            await ajaxAwaitFormData({ api: 5,MANTENIMIENTO_ID:inventario_id, ID_INFORMACION_MTTO: ID_INFORMACION_MTTO }, 'MantenimientoSave', 'formularioINVENTARIO', 'guardarMTTO', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
                
            }, function (data) {
                    
                ID_INFORMACION_MTTO = data.cliente.ID_INFORMACION_MTTO
                alertMensaje('success', 'Información guardada correctamente', 'Esta información esta lista para usarse', null, null, 1500)
                

            })
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarMTTO')
            await ajaxAwaitFormData({ api: 5,MANTENIMIENTO_ID:inventario_id ,ID_INFORMACION_MTTO: ID_INFORMACION_MTTO }, 'MantenimientoSave', 'formularioINVENTARIO', 'guardarMTTO', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
            }, function (data) {
                    
                setTimeout(() => {

                    ID_INFORMACION_MTTO = data.cliente.ID_INFORMACION_MTTO
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')

                }, 300);  
            })
        }, 1)
    }

    } else {
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

    }
    
});


function cargarInformacionMtto() {

    document.getElementById('ID_INFORMACION_MTTO').value = 0;

    document.getElementById('PROVEEDORES_INTERNO').style.display = 'none';
    document.getElementById('PROVEEDORES_EXTERNO').style.display = 'none';

    if (!inventario_id) {
        return;
    }

    fetch(`/obtenerInformacionMtto?MANTENIMIENTO_ID=${inventario_id}`)
        .then(response => response.json())
        .then(resp => {

            if (!resp.success || !resp.data) {
                return;
            }

            const data = resp.data;

            document.getElementById('ID_INFORMACION_MTTO').value =
                data.ID_INFORMACION_MTTO ?? 0;

            document.getElementById('CRITERIO_MTTO').value = data.CRITERIO_MTTO ?? '';
            document.getElementById('TIPO_MTTO').value = data.TIPO_MTTO ?? '';
            document.getElementById('PROVEEDOR_INTEXT_MTTO').value = data.PROVEEDOR_INTEXT_MTTO ?? '';
            document.getElementById('FECHA_ULTIMO_MTTO').value = data.FECHA_ULTIMO_MTTO ?? '';

            if (data.PROVEEDOR_INTEXT_MTTO == 1) {

                document.getElementById('PROVEEDORES_INTERNO').style.display = 'block';
                document.getElementById('PROVEEDORES_EXTERNO').style.display = 'none';

                SelectProveedormtto();

                $('#PROVEEDOR_INTERNO_MTTO')
                    .val(data.PROVEEDOR_INTERNO_MTTO ?? '')
                    .trigger('change');

            } else if (data.PROVEEDOR_INTEXT_MTTO == 2) {

                document.getElementById('PROVEEDORES_INTERNO').style.display = 'none';
                document.getElementById('PROVEEDORES_EXTERNO').style.display = 'block';

                document.getElementById('PROVEEDOR_EXTERNO_MTTO').value =
                    data.PROVEEDOR_EXTERNO_MTTO ?? '';
            }

        })
        .catch(error => {
            console.error('Error al cargar información MTTO:', error);
        });
}


//////////////////////////////////  DETALLE ARTICULO //////////////////////////////////

const Modaldetalle= document.getElementById('miModal_DETALLE')
Modaldetalle.addEventListener('hidden.bs.modal', event => {
     
    ID_DETALLE_ARTICULO = 0

    document.getElementById('formularioDETALLE').reset();

    $('#miModal_DETALLE .modal-title').html('Nuevo detalle');
   

})

$("#NUEVO_DETALLE").click(function (e) {
    e.preventDefault();

    $('#formularioDETALLE').each(function(){
        this.reset();
    });

    $("#miModal_DETALLE").modal("show");
   
});

$("#guardarDETALLEARTICULO").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario3($('#formularioDETALLE'))

    if (formularioValido) {

    if (ID_DETALLE_ARTICULO == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarDETALLEARTICULO')
            await ajaxAwaitFormData({ api: 4,INVENTARIO_ID:inventario_id, ID_DETALLE_ARTICULO: ID_DETALLE_ARTICULO }, 'InventarioSave', 'formularioDETALLE', 'guardarDETALLEARTICULO', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
                
            }, function (data) {
                    
                ID_DETALLE_ARTICULO = data.cliente.ID_DETALLE_ARTICULO
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_DETALLE').modal('hide')
                    document.getElementById('formularioDETALLE').reset();


                    
                    if ($.fn.DataTable.isDataTable('#Tabladetallearticulos')) {
                        Tabladetallearticulos.ajax.reload(null, false); 
                    }

            })
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarDETALLEARTICULO')
            await ajaxAwaitFormData({ api: 4,INVENTARIO_ID:inventario_id ,ID_DETALLE_ARTICULO: ID_DETALLE_ARTICULO }, 'InventarioSave', 'formularioDETALLE', 'guardarDETALLEARTICULO', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
            }, function (data) {
                    
                setTimeout(() => {

                    ID_DETALLE_ARTICULO = data.cliente.ID_DETALLE_ARTICULO
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_DETALLE').modal('hide')
                    document.getElementById('formularioDETALLE').reset();


                    
                    if ($.fn.DataTable.isDataTable('#Tabladetallearticulos')) {
                        Tabladetallearticulos.ajax.reload(null, false); 
                    }

                }, 300);  
            })
        }, 1)
    }

    } else {
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

    }
    
});

function cargarTablaDetallaArticulo() {
    if ($.fn.DataTable.isDataTable('#Tabladetallearticulos')) {
        Tabladetallearticulos.clear().destroy();
    }

    Tabladetallearticulos = $("#Tabladetallearticulos").DataTable({
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
            data: { equipo: inventario_id }, 
            method: 'GET',
            cache: false,
            url: '/Tabladetallearticulos',  
            beforeSend: function () {
                $('#loadingIcon2').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon2').css('display', 'none');
                Tabladetallearticulos.columns.adjust().draw(); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon2').css('display', 'none');
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            },
            dataSrc: 'data'
        },
        columns: [
            { data: null, render: function(data, type, row, meta) { return meta.row + 1; }, className: 'text-center' },
            { data: 'NOMBRE_COMPONENTE', className: 'text-center' },
            { data: 'CODIGO_PARTE' },
            { data: 'CANTIDAD_DETALLE' },
            { data: 'FECHA_COMPRA' },
            { data: 'BTN_EDITAR', className: 'text-center' },
            { data: 'BTN_VISUALIZAR', className: 'text-center' },
            { data: 'BTN_ELIMINAR', className: 'text-center' },

        ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all text-center' },
            { targets: 1, title: 'Nombre componente', className: 'all text-center' },  
            { targets: 2, title: 'Código / parte', className: 'all text-center' },  
            { targets: 3, title: 'Cantidad', className: 'all text-center' },  
            { targets: 4, title: 'Fecha de compra ', className: 'all text-center' },  
            { targets: 5, title: 'Editar', className: 'all text-center' }, 
            { targets: 6, title: 'Visualizar', className: 'all text-center' }, 
            { targets: 7, title: 'Activo', className: 'all text-center' }, 

        ],
       
    });
}

$('#Tabladetallearticulos').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tabladetallearticulos.row(tr);

    ID_DETALLE_ARTICULO = row.data().ID_DETALLE_ARTICULO;

    editarDatoTabla(row.data(), 'formularioDETALLE', 'miModal_DETALLE', 1);

    $('#miModal_DETALLE .modal-title').html(row.data().NOMBRE_COMPONENTE);
});

$(document).ready(function() {
    $('#Tabladetallearticulos').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tabladetallearticulos.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_DETALLE');

        ID_DETALLE_ARTICULO = row.data().ID_DETALLE_ARTICULO;
        editarDatoTabla(row.data(), 'formularioDETALLE', 'miModal_DETALLE',1);

    $('#miModal_DETALLE .modal-title').html(row.data().NOMBRE_COMPONENTE);

    });

    $('#miModal_DETALLE').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_DETALLE');
    });
});


$('#Tabladetallearticulos').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tabladetallearticulos.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 4,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_DETALLE_ARTICULO: row.data().ID_DETALLE_ARTICULO
    };

    eliminarDatoTabla(data, [Tabladetallearticulos], 'inventarioDelete');
});

////////////////////////  ENTRADA INVENTARIO TAB 6 ////////////////////////

function cargartablaentradainventario() {
    if ($.fn.DataTable.isDataTable('#Tablaentradainventario')) {
        Tablaentradainventario.clear().destroy();
    }

    Tablaentradainventario = $("#Tablaentradainventario").DataTable({
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
            data: { inventario: inventario_id }, 
            method: 'GET',
            cache: false,
            url: '/Tablaentradainventario',
            beforeSend: function () {
                $('#loadingIcon').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon').css('display', 'none');
                Tablaentradainventario.columns.adjust().draw();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon').css('display', 'none');
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            },
            dataSrc: 'data'
        },
        columns: [
            { data: null, render: function (data, type, row, meta) { return meta.row + 1; }, className: 'text-center' },
            { data: 'FECHA', className: 'text-center' },
            { data: 'CANTIDAD', className: 'text-center' },
            { 
                data: 'VALOR_UNITARIO', 
                className: 'text-center',
                render: function (data) {
                    if (!data) return '';
                    let numero = parseFloat(data);
                    return isNaN(numero) ? data : '$ ' + numero.toFixed(2);
                }
            },
            { 
                data: 'COSTO_TOTAL',
                className: 'text-center',
                render: function (data) {
                    if (!data) return '';
                    let numero = parseFloat(data);
                    return isNaN(numero) ? data : '$ ' + numero.toFixed(2);
                }
            },
            { data: 'TIPO', className: 'text-center' },
            { data: 'USUARIO', className: 'text-center' },
           
        ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all text-center' },
            { targets: 1, title: 'Fecha', className: 'all text-center' },  
            { targets: 2, title: 'Cantidad', className: 'all text-center' },  
            { targets: 3, title: 'Valor unitario de compras', className: 'all text-center' },  
            { targets: 4, title: 'Total', className: 'all text-center' },
            { targets: 5, title: 'Tipo', className: 'all text-center' },
            { targets: 6, title: 'Usuario', className: 'all text-center' },
           
        ]
    });
}
