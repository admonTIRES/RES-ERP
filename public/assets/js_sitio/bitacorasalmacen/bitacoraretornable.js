ID_BITACORAS_ALMACEN = 0
let ID_FORM_GLOBAL = null;
let ID_INVENTARIO_GLOBAL = null;


const Modalbitacora = document.getElementById('miModal_BITACORA')
Modalbitacora.addEventListener('hidden.bs.modal', event => {
    
    ID_BITACORAS_ALMACEN = 0
    document.getElementById('formularioBITACORA').reset();

    $("#RETORNO_EQUIPO").hide();
    $("#guardaBITACORA").show();
   

      
    if (typeof imagenesSeleccionadas !== "undefined") {
        imagenesSeleccionadas = [];
    }

    $('#previewImagenesBitacora').empty();
    $('#contenedorImagenesHidden').empty();

    $('#inputCamara').val('');
    $('#inputGaleria').val('');

})

var Tablabitacoraretornable = $("#Tablabitacoraretornable").DataTable({
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
        url: '/Tablabitacoraretornable',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablabitacoraretornable.columns.adjust().draw();
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
        { data: 'CODIGO_EQUIPO' },
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
        { targets: 9, title: 'Código de Identificación', className: 'all text-center' },
        { targets: 10, title: 'Fecha de entrega', className: 'all text-center' },
        { targets: 11, title: 'Editar', className: 'all text-center' },
        { targets: 12, title: 'Visualizar', className: 'all text-center' }
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
        url: '/obtenerMaterialRetornable',
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
            let canvas3 = document.getElementById("firmaCanvas3");
            let canvas4 = document.getElementById("firmaCanvas4");

            let ctx1 = canvas1.getContext("2d");
            let ctx2 = canvas2.getContext("2d");
            let ctx3 = canvas3.getContext("2d");
            let ctx4 = canvas4.getContext("2d");

          
            canvas1.width = canvas1.width; 
            canvas2.width = canvas2.width;
            canvas3.width = canvas3.width;
            canvas4.width = canvas4.width;

            $("#FIRMA_RECIBIDO_POR").val("");
            $("#FIRMA_ENTREGADO_POR").val("");
            $("#FIRMA_RETORNADO_POR").val("");
            $("#FIRMA_ACEPTADO_POR").val("");
            
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

                cargarImagenesGuardadas(ID_FORM_GLOBAL,ID_INVENTARIO_GLOBAL);

                
                $("#ID_BITACORAS_ALMACEN").val(material.ID_BITACORAS_ALMACEN);
                $("#RECIBIDO_POR").val(material.RECIBIDO_POR);
                $("#OBSERVACIONES_BITACORA").val(material.OBSERVACIONES_BITACORA);
                $("#FUNCIONAMIENTO_BITACORA").val(material.FUNCIONAMIENTO_BITACORA);
                $("#RETORNO_BITACORA_RETORNABLE").val(material.RETORNO_BITACORA_RETORNABLE);
                $("#FECHA_RETORNO_BITACORA").val(material.FECHA_RETORNO_BITACORA);


                if (material.RETORNO_BITACORA_RETORNABLE === '1') {
                    $('#RETORNO_EQUIPO').show();
                } else {
                    $('#RETORNO_EQUIPO').hide();
                }

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

                if (material.FIRMA_RETORNADO_POR) {
                    let img3 = new Image();
                    img3.onload = function () {
                        ctx3.drawImage(img3, 0, 0, canvas3.width, canvas3.height);
                    };
                    img3.src = material.FIRMA_RETORNADO_POR;
                    $("#FIRMA_RETORNADO_POR").val(material.FIRMA_RETORNADO_POR);
                }

                if (material.FIRMA_ACEPTADO_POR) {
                    let img4 = new Image();
                    img4.onload = function () {
                        ctx4.drawImage(img4, 0, 0, canvas4.width, canvas4.height);
                    };
                    img4.src = material.FIRMA_ACEPTADO_POR;
                    $("#FIRMA_ACEPTADO_POR").val(material.FIRMA_ACEPTADO_POR);
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
        url: '/obtenerMaterialRetornable',
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
            let canvas3 = document.getElementById("firmaCanvas3");
            let canvas4 = document.getElementById("firmaCanvas4");

            let ctx1 = canvas1.getContext("2d");
            let ctx2 = canvas2.getContext("2d");
            let ctx3 = canvas3.getContext("2d");
            let ctx4 = canvas4.getContext("2d");

          
            canvas1.width = canvas1.width; 
            canvas2.width = canvas2.width;
            canvas3.width = canvas3.width;
            canvas4.width = canvas4.width;

            $("#FIRMA_RECIBIDO_POR").val("");
            $("#FIRMA_ENTREGADO_POR").val("");

            $("#FIRMA_RETORNADO_POR").val("");
            $("#FIRMA_ACEPTADO_POR").val("");
            
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


                cargarImagenesGuardadasVisualizar(ID_FORM_GLOBAL,ID_INVENTARIO_GLOBAL);

                
                $("#ID_BITACORAS_ALMACEN").val(material.ID_BITACORAS_ALMACEN);
                $("#RECIBIDO_POR").val(material.RECIBIDO_POR);
                $("#OBSERVACIONES_BITACORA").val(material.OBSERVACIONES_BITACORA);
                $("#FUNCIONAMIENTO_BITACORA").val(material.FUNCIONAMIENTO_BITACORA);
                $("#RETORNO_BITACORA_RETORNABLE").val(material.RETORNO_BITACORA_RETORNABLE);
                $("#FECHA_RETORNO_BITACORA").val(material.FECHA_RETORNO_BITACORA);


                if (material.RETORNO_BITACORA_RETORNABLE === '1') {
                    $('#RETORNO_EQUIPO').show();
                } else {
                    $('#RETORNO_EQUIPO').hide();
                }

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


                if (material.FIRMA_RETORNADO_POR) {
                    let img3 = new Image();
                    img3.onload = function () {
                        ctx3.drawImage(img3, 0, 0, canvas3.width, canvas3.height);
                    };
                    img3.src = material.FIRMA_RETORNADO_POR;
                    $("#FIRMA_RETORNADO_POR").val(material.FIRMA_RETORNADO_POR);
                }

                if (material.FIRMA_ACEPTADO_POR) {
                    let img4 = new Image();
                    img4.onload = function () {
                        ctx4.drawImage(img4, 0, 0, canvas4.width, canvas4.height);
                    };
                    img4.src = material.FIRMA_ACEPTADO_POR;
                    $("#FIRMA_ACEPTADO_POR").val(material.FIRMA_ACEPTADO_POR);
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
            }, async function () {

                await loaderbtn('guardaBITACORA')

            
                $('#contenedorImagenesHidden').empty();

                imagenesSeleccionadas.forEach(file => {

                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);

                    const input = document.createElement('input');
                    input.type = 'file';
                    input.name = 'IMAGENES_BITACORA[]';
                    input.files = dataTransfer.files;

                    document.getElementById('contenedorImagenesHidden').appendChild(input);
                });

              
                imagenesEliminadas.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'IMAGENES_ELIMINADAS[]';
                    input.value = id;
                    document.getElementById('contenedorImagenesHidden').appendChild(input);
                });

                await ajaxAwaitFormData(
                    {
                        api: 1,
                        ID_BITACORAS_ALMACEN: ID_BITACORAS_ALMACEN,
                        RECEMPLEADO_ID: ID_FORM_GLOBAL,
                        INVENTARIO_ID: ID_INVENTARIO_GLOBAL
                    },
                    'BitacoraRetornableSave',
                    'formularioBITACORA',
                    'guardaBITACORA',
                    { callbackAfter: true, callbackBefore: true },
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

                        ID_BITACORAS_ALMACEN = data.bitacora.ID_BITACORAS_ALMACEN

                        imagenesSeleccionadas = [];
                        imagenesEliminadas = [];
                        $('#previewImagenesBitacora').empty();
                        $('#contenedorImagenesHidden').empty();

                        alertMensaje(
                            'success',
                            'Información guardada correctamente',
                            'Esta información esta lista para usarse',
                            null,
                            null,
                            1500
                        )

                        $('#miModal_BITACORA').modal('hide')
                        document.getElementById('formularioBITACORA').reset();
                        Tablabitacoraretornable.ajax.reload()
                    }
                )

            }, 1)

        } else {

            alertMensajeConfirm({
                title: "¿Desea editar la información de este formulario?",
                text: "Al guardarla, se podra usar",
                icon: "question",
            }, async function () {

                await loaderbtn('guardaBITACORA')

              
                $('#contenedorImagenesHidden').empty();

                imagenesSeleccionadas.forEach(file => {

                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);

                    const input = document.createElement('input');
                    input.type = 'file';
                    input.name = 'IMAGENES_BITACORA[]';
                    input.files = dataTransfer.files;

                    document.getElementById('contenedorImagenesHidden').appendChild(input);
                });

               
                imagenesEliminadas.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'IMAGENES_ELIMINADAS[]';
                    input.value = id;
                    document.getElementById('contenedorImagenesHidden').appendChild(input);
                });

                await ajaxAwaitFormData(
                    {
                        api: 1,
                        ID_BITACORAS_ALMACEN: ID_BITACORAS_ALMACEN,
                        RECEMPLEADO_ID: ID_FORM_GLOBAL,
                        INVENTARIO_ID: ID_INVENTARIO_GLOBAL
                    },
                    'BitacoraRetornableSave',
                    'formularioBITACORA',
                    'guardaBITACORA',
                    { callbackAfter: true, callbackBefore: true },
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

                            ID_BITACORAS_ALMACEN = data.bitacora.ID_BITACORAS_ALMACEN

                            imagenesSeleccionadas = [];
                            imagenesEliminadas = [];
                            $('#previewImagenesBitacora').empty();
                            $('#contenedorImagenesHidden').empty();

                            alertMensaje(
                                'success',
                                'Información editada correctamente',
                                'Información guardada'
                            )

                            $('#miModal_BITACORA').modal('hide')
                            document.getElementById('formularioBITACORA').reset();
                            Tablabitacoraretornable.ajax.reload()

                        }, 300);

                    }
                )

            }, 1)
        }

    } else {
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)
    }
});

$('#RETORNO_BITACORA_RETORNABLE').on('change', function () {
    if ($(this).val() === '1') {   
        $('#RETORNO_EQUIPO').show();
    } else {                     
        $('#RETORNO_EQUIPO').hide();
    }
});


///////// CARGAR IMAGENES  

let imagenesGuardadas = []; 
let imagenesSeleccionadas = []; 
let imagenesEliminadas = [];

function mostrarPreview(files) {

    Array.from(files).forEach(file => {
        if (!file.type.startsWith('image/')) return;

        imagenesSeleccionadas.push(file);
        renderImagenNueva(file, imagenesSeleccionadas.length - 1);
    });
}

function renderImagenNueva(file, index) {

    const reader = new FileReader();

    reader.onload = function (e) {

        const preview = document.getElementById('previewImagenesBitacora');

        const col = document.createElement('div');
        col.className = 'col-6 col-md-3 mb-3';
        col.dataset.index = index; 

        col.innerHTML = `
            <div class="card shadow-sm position-relative">

                <button type="button"
                    class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                    style="z-index:10;border-radius:50%;"
                    onclick="eliminarImagenDOM(this)">
                   <i class="bi bi-trash-fill"></i>
                </button>

                <div style="height:180px;display:flex;align-items:center;justify-content:center;background:#f8f9fa;">
                    <img src="${e.target.result}"
                         style="height:100%;width:100%;object-fit:contain;background:#fff;">
                </div>

                <div class="text-center mt-2 mb-2">
                    <a class="btn btn-outline-primary btn-sm"
                       href="${e.target.result}"
                       download>
                     <i class="bi bi-download"></i> Descargar
                    </a>
                </div>
            </div>
        `;

        preview.appendChild(col);
    };

    reader.readAsDataURL(file);
}

document.getElementById('inputCamara').addEventListener('change', function () {
    mostrarPreview(this.files);
    this.value = ''; 
});

document.getElementById('inputGaleria').addEventListener('change', function () {
    mostrarPreview(this.files);
    this.value = ''; 
});

function cargarImagenesGuardadas(recId, inventarioId) {

    $.get('/obtenerImagenesBitacora', {
        RECEMPLEADO_ID: recId,
        INVENTARIO_ID: inventarioId
    }, function (imagenes) {

        const preview = document.getElementById('previewImagenesBitacora');

        imagenes.forEach(img => {

            const col = document.createElement('div');
            col.className = 'col-6 col-md-3 mb-3';
            col.dataset.guardada = "1"; 

            col.innerHTML = `
                <div class="card shadow-sm position-relative">

                    <button type="button"
                        class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                        style="z-index:10;border-radius:50%;"
                        onclick="eliminarImagenDOM(this)">
                      <i class="bi bi-trash-fill"></i>
                    </button>

                    <div style="height:180px;display:flex;align-items:center;justify-content:center;background:#f8f9fa;">
                        <img src="/bitacora/vehiculo/imagen/${img.ID_IMAGENES_BITACORASALMACEN}"
                             style="height:100%;width:100%;object-fit:contain;background:#fff;">
                    </div>

                    <div class="text-center mt-2 mb-2">
                        <a class="btn btn-outline-primary btn-sm"
                           href="/bitacora/vehiculo/imagen/${img.ID_IMAGENES_BITACORASALMACEN}"
                           download>
                          <i class="bi bi-download"></i> Descargar
                        </a>
                    </div>
                </div>
            `;

            preview.appendChild(col);
        });
    });
}

function eliminarImagenDOM(btn) {

    const col = btn.closest('.col-6');

    // Imagen NUEVA
    if (col.dataset.index !== undefined) {
        const index = parseInt(col.dataset.index);
        imagenesSeleccionadas.splice(index, 1);
    }

    // Imagen GUARDADA
    if (col.dataset.guardada === "1") {
        const img = col.querySelector('img');
        const id = img.getAttribute('src').split('/').pop();
        imagenesEliminadas.push(id);
    }

    col.remove();
}

function cargarImagenesGuardadasVisualizar(recId, inventarioId) {

    $.get('/obtenerImagenesBitacora', {
        RECEMPLEADO_ID: recId,
        INVENTARIO_ID: inventarioId
    }, function (imagenes) {

        const preview = document.getElementById('previewImagenesBitacora');

        imagenes.forEach(img => {

            const col = document.createElement('div');
            col.className = 'col-6 col-md-3 mb-3';
            col.dataset.guardada = "1"; 

            col.innerHTML = `
                <div class="card shadow-sm position-relative">

               
                    <div style="height:180px;display:flex;align-items:center;justify-content:center;background:#f8f9fa;">
                        <img src="/bitacora/vehiculo/imagen/${img.ID_IMAGENES_BITACORASALMACEN}"
                             style="height:100%;width:100%;object-fit:contain;background:#fff;">
                    </div>
                </div>
            `;

            preview.appendChild(col);
        });
    });
}