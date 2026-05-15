ID_FORMULARIO_INVENTARIO = 0
ID_ENTRADA_FORMULARIO = 0
ID_DOCUMENTO_ARTICULO = 0


var inventario_id = null; 


const Modalinventario = document.getElementById('Modal_inventario')
Modalinventario.addEventListener('hidden.bs.modal', event => {
    
    ID_FORMULARIO_INVENTARIO = 0
    document.getElementById('formularioINVENTARIO').reset();
   
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






$(document).ready(function() {
    $('#NUEVO_EQUIPO').on('click', function() {
        limpiarFormularioUsuario(); 

        $('#FOTO_EQUIPO').dropify({
            messages: {
                'default': 'Arrastre la imagen aquí o haga clic',
                'replace': 'Arrastre la imagen aquí o haga clic para reemplazar',
                'remove':  'Quitar',
                'error':   'Ooops, ha ocurrido un error.'
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

        $('#Modal_inventario').modal('show');
        $("#tab1-info").click();
        $("#tab2-entrada").prop("disabled", true);
        $("#tab2-entrada").hide();
        $("#tab3-documentos").hide();
        $("#ANTES_2024").hide();
        $("#DESPUES_2024").show();
        $("#MOSTRAR_ALERTA_DOCUMENTOS").hide();


    });

});

function limpiarFormularioUsuario() {
    $('#formularioINVENTARIO')[0].reset(); 

    var drEvent = $('#FOTO_EQUIPO').data('dropify');
    if (drEvent) {
        drEvent.resetPreview();
        drEvent.clearElement();
    }
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
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_INVENTARIO: ID_FORMULARIO_INVENTARIO }, 'InventarioSave', 'formularioINVENTARIO', 'guardarINVENTARIO', { callbackAfter: true, callbackBefore: true }, () => {
        
               

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
                    Tablalistacomercializacion.ajax.reload()

        
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarINVENTARIO')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_INVENTARIO: ID_FORMULARIO_INVENTARIO }, 'InventarioSave', 'formularioINVENTARIO', 'guardarINVENTARIO', { callbackAfter: true, callbackBefore: true }, () => {
        
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
                    Tablalistacomercializacion.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});


var Tablalistacomercializacion = $("#Tablalistacomercializacion").DataTable({
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
        url: '/Tablalistacomercializacion',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablalistacomercializacion.columns.adjust().draw();
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
    const table = document.querySelector('#Tablalistacomercializacion');
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

$('#Tablalistacomercializacion tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablalistacomercializacion.row(tr);
    ID_FORMULARIO_INVENTARIO = row.data().ID_FORMULARIO_INVENTARIO;



    inventario_id = row.data().ID_FORMULARIO_INVENTARIO;

    $("#tab1-info").click();

    $("#tab2-entrada").off("click").on("click", function () {
        cargartablaentradainventario();
    });


    editarDatoTablainventario(row.data(), 'formularioINVENTARIO', 'Modal_inventario', 1);


    if (row.data().FOTO_EQUIPO) {
        var archivo = row.data().FOTO_EQUIPO;
        var extension = archivo.substring(archivo.lastIndexOf("."));
        var imagenUrl = '/equipofoto/' + row.data().ID_FORMULARIO_INVENTARIO + extension;

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
   
    $("#tab2-entrada").show();
            
   if (row.data().REQUIERE_ARTICULO === "1") {
       $("#tab3-documentos").show();
       $("#MOSTRAR_ALERTA_DOCUMENTOS").show();
       cargarDocumentos(inventario_id);


    } else if (row.data().REQUIERE_ARTICULO === "2") {
       $("#tab3-documentos").hide();
        $("#MOSTRAR_ALERTA_DOCUMENTOS").hide();
       
    } else if (row.data().REQUIERE_ARTICULO === "3") {
       $("#tab3-documentos").hide();
        $("#MOSTRAR_ALERTA_DOCUMENTOS").hide();

    } else {
       $("#tab3-documentos").hide();
       $("#MOSTRAR_ALERTA_DOCUMENTOS").hide();

    }
    
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
    
    $("#tab3-documentos").off("click").on("click", function () {
        cargarTablaDocumentosEquipo();
    });


    $.get('/cantidadEquipoReadonly', function (resp) {

    if (resp.readonly === true) {
        $('#CANTIDAD_EQUIPO').attr('readonly', true);
        $('#LIMITEMINIMO_EQUIPO').attr('readonly', true);

    } else {
        $('#CANTIDAD_EQUIPO').removeAttr('readonly');
        $('#LIMITEMINIMO_EQUIPO').removeAttr('readonly');

    }

    });

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


});

$(document).ready(function() {
    $('#Tablalistacomercializacion tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablalistacomercializacion.row(tr);
        
        hacerSoloLecturainventario(row.data(), '#Modal_inventario');

        ID_FORMULARIO_INVENTARIO = row.data().ID_FORMULARIO_INVENTARIO;

        inventario_id = row.data().ID_FORMULARIO_INVENTARIO;
    
        $("#tab1-info").click();
    
        $("#tab2-entrada").off("click").on("click", function () {
            cargartablaentradainventario();
        });


        editarDatoTablainventario(row.data(), 'formularioINVENTARIO', 'Modal_inventario', 1);
        

        if (row.data().FOTO_EQUIPO) {
        var archivo = row.data().FOTO_EQUIPO;
        var extension = archivo.substring(archivo.lastIndexOf("."));
        var imagenUrl = '/equipofoto/' + row.data().ID_FORMULARIO_INVENTARIO + extension;

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
                   
        

    
        $("#tab2-entrada").show();
        
            
         
    if (row.data().REQUIERE_ARTICULO === "1") {
       $("#tab3-documentos").show();
        $("#MOSTRAR_ALERTA_DOCUMENTOS").show();
        cargarDocumentos(inventario_id);


    } else if (row.data().REQUIERE_ARTICULO === "2") {
    $("#tab3-documentos").hide();
        $("#MOSTRAR_ALERTA_DOCUMENTOS").hide();
    
    } else if (row.data().REQUIERE_ARTICULO === "3") {
    $("#tab3-documentos").hide();
        $("#MOSTRAR_ALERTA_DOCUMENTOS").hide();

    } else {
    $("#tab3-documentos").hide();
    $("#MOSTRAR_ALERTA_DOCUMENTOS").hide();

    }
        
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


    $("#tab3-documentos").off("click").on("click", function () {
        cargarTablaDocumentosEquipo();
    });

        
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
        



    });

    $('#Modal_inventario').on('hidden.bs.modal', function () {
        resetFormulario('#Modal_inventario');
    });
});

$('#Tablalistacomercializacion tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablalistacomercializacion.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_FORMULARIO_INVENTARIO: row.data().ID_FORMULARIO_INVENTARIO
    };

    eliminarDatoTabla(data, [Tablalistacomercializacion], 'inventarioDelete');
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

$('#TIPO_EQUIPO').on('change', function () {
    const tipo = $(this).val();

    if (tipo === 'AF') {
        $.ajax({
            url: '/generarCodigoAF',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.codigo) {
                    $('#CODIGO_EQUIPO').val(response.codigo);
                } else {
                    $('#CODIGO_EQUIPO').val('');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.msj || 'No se pudo generar el código AF.'
                    });
                }
            }
        });
    } else if (tipo === 'ANF') {
        $.ajax({
            url: '/generarCodigoANF',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.codigo) {
                    $('#CODIGO_EQUIPO').val(response.codigo);
                } else {
                    $('#CODIGO_EQUIPO').val('');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.msj || 'No se pudo generar el código ANF.'
                    });
                }
            }
        });
    } else {
        $('#CODIGO_EQUIPO').val('');
    }
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

////////////////////////  ENTRADA INVENTARIO TAB 2 ////////////////////////

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

document.addEventListener('DOMContentLoaded', function () {
  const guardarBtn = document.getElementById('guardarINVENTARIO');
  const tabs = document.querySelectorAll('#tabsinventario button[data-bs-toggle="tab"]');

  tabs.forEach(tab => {
    tab.addEventListener('shown.bs.tab', function (event) {
      const target = event.target.getAttribute('data-bs-target');
      if (target === '#contenido-info') {
        guardarBtn.style.display = 'inline-block';
      } else {
        guardarBtn.style.display = 'none';
      }
    });
  });

  const activeTab = document.querySelector('#tabsinventario button.active');
  if (activeTab && activeTab.getAttribute('data-bs-target') !== '#contenido-info') {
    guardarBtn.style.display = 'none';
  }
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

    $("#miModal_DOCUMENTOS").modal("show");
   

            $('#FECHAF_DOCUMENTO').prop('required', false).removeClass('validar');

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
            await ajaxAwaitFormData({ api: 3,INVENTARIO_ID:inventario_id, ID_DOCUMENTO_ARTICULO: ID_DOCUMENTO_ARTICULO }, 'InventarioSave', 'formularioDOCUMENTOS', 'guardarDOCUMENTACION', { callbackAfter: true, callbackBefore: true }, () => {
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


                    
                    if ($.fn.DataTable.isDataTable('#Tabladocumentosinventario')) {
                        Tabladocumentosinventario.ajax.reload(null, false); 
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
            await ajaxAwaitFormData({ api: 3,INVENTARIO_ID:inventario_id ,ID_DOCUMENTO_ARTICULO: ID_DOCUMENTO_ARTICULO }, 'InventarioSave', 'formularioDOCUMENTOS', 'guardarDOCUMENTACION', { callbackAfter: true, callbackBefore: true }, () => {
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


                    
                    if ($.fn.DataTable.isDataTable('#Tabladocumentosinventario')) {
                        Tabladocumentosinventario.ajax.reload(null, false); 
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
    if ($.fn.DataTable.isDataTable('#Tabladocumentosinventario')) {
        Tabladocumentosinventario.clear().destroy();
    }

    Tabladocumentosinventario = $("#Tabladocumentosinventario").DataTable({
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
            url: '/Tabladocumentosinventario',  
            beforeSend: function () {
                $('#loadingIcon1').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon1').css('display', 'none');
                Tabladocumentosinventario.columns.adjust().draw(); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon1').css('display', 'none');
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            },
            dataSrc: 'data'
        },
        columns: [
            { data: null, render: function(data, type, row, meta) { return meta.row + 1; }, className: 'text-center' },
            { data: 'NOMBRE_DOCUMENTO', className: 'text-center' },
            { data: 'FECHAS_DOCUMENTOS' },
            { data: 'BTN_DOCUMENTO', className: 'text-center' },
            { data: 'BTN_EDITAR', className: 'text-center' },
        ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all text-center' },
            { targets: 1, title: 'Nombre del documento:', className: 'all text-center' },  
            { targets: 2, title: 'Fecha documentos:', className: 'all text-center' },  
            { targets: 3, title: 'Documento', className: 'all text-center' },  
            { targets: 4, title: 'Editar', className: 'all text-center' }, 

        ],
       
    });
}

$('#Tabladocumentosinventario').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tabladocumentosinventario.row(tr);

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



});

$('#Tabladocumentosinventario').on('click', '.ver-archivo-documentosequipo', function (e) {
    e.preventDefault(); 
    e.stopPropagation(); 

    var tr = $(this).closest('tr');
    var row = Tabladocumentosinventario.row(tr).data();
    var id = $(this).data('id');

    if (!id || !row.DOCUMENTO_ARTICULO || row.DOCUMENTO_ARTICULO.trim() === "") {
        Swal.fire({
            icon: 'warning',
            title: 'Sin documento',
            text: 'Este registro no tiene documento.',
        });
        return;
    }

    var url = '/mostrardocumentoquipo/' + id;

    window.open(url, '_blank');
});

////////////////////////////////// FECHAS DOCUMENTOS //////////////////////////////////

function cargarDocumentos(inventario_id) {
    $.ajax({
        url: `/obtenerDocumentosPorInventario/${inventario_id}`,
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

