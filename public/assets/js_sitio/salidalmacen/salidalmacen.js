//VARIABLES
ID_FORMULARIO_RECURSOS_EMPLEADOS = 0




const Modalmr = document.getElementById('miModal_RECURSOSEMPLEADOS');
Modalmr.addEventListener('hidden.bs.modal', event => {


    ID_FORMULARIO_RECURSOS_EMPLEADOS = 0;
    document.getElementById('formularioRECURSOSEMPLEADO').reset();


    $('#FECHA_ESTIMADA').hide();
    $('#SOLIDA_ALMACEN').hide();
    $('#PERMISO_AUSENCIA').hide();
    $('#SOLICITUD_VACACIONES').hide();
    $('#EXPLIQUE_PERMISO').hide();
    $('#DIV_FIRMAR').show();
    $('#VISTO_BUENO_JEFE').hide();
    $('#APROBACION_DIRECCION').hide();
    $('#DIV_FIRMA_ALMACENISTA').hide();

    document.querySelector('.materialesdiv').innerHTML = '';
    contadorMateriales = 1;

    const inputFecha = document.getElementById("FECHA_ALMACEN_SOLICITUD");
    if (inputFecha) {
        inputFecha.classList.remove("is-invalid"); 
    }

    if (typeof Swal !== "undefined") {
        Swal.close();
    }
});







$("#NUEVO_RECUROSEMPLEADO").click(function (e) {
    e.preventDefault();

    $('#formularioRECURSOSEMPLEADO').each(function(){
        this.reset();
    });

    $(".materialesdiv").empty();


    $("#miModal_RECURSOSEMPLEADOS").modal("show");


    $.get('/obtenerAreaSolicitante', function(response) {
    if (response.area) {
        $("#AREA_SOLICITANTE_MR").val(response.area);
    } else {
        $("#AREA_SOLICITANTE_MR").val("Área no encontrada");
        }
        
        });

    
     $.get('/obtenerDatosPermiso', function (response) {
        if (response.cargo) {
            $("#CARGO_PERMISO").val(response.cargo);
        }
        if (response.numero_empleado) {
            $("#NOEMPLEADO_PERMISO").val(response.numero_empleado);
        }
     });
    
    

    

   
});



let contadorMateriales = 1; 




 function actualizarNumerosOrden() {
        const materiales = document.querySelectorAll('.material-item');
        let nuevoContador = 1;
        materiales.forEach(material => {
            material.querySelector('input[name="NUMERO_ORDEN"]').value = nuevoContador;
            nuevoContador++;
        });
        contadorMateriales = nuevoContador;
}
    
    

$("#guardaRECEMPLEADOS").click(function (e) {
    e.preventDefault();

        formularioValido = validarFormulario3($('#formularioRECURSOSEMPLEADO'))

    
    if (formularioValido) {

        
        var documentos = [];
       
        $(".material-item").each(function() {
            var documento = {
                'DESCRIPCION': $(this).find("input[name='DESCRIPCION']").val(),
                'CANTIDAD': $(this).find("input[name='CANTIDAD']").val(),
                'RETORNA_EQUIPO': $(this).find("select[name='RETORNA_EQUIPO']").val(),
                'EN_EXISTENCIA': $(this).find("select[name='EN_EXISTENCIA']").val(),
                'TIPO_INVENTARIO': $(this).find("select[name='TIPO_INVENTARIO']").val(),
                'INVENTARIO': $(this).find("select[name='INVENTARIO']").val(),
                'CANTIDAD_SALIDA': $(this).find("input[name='CANTIDAD_SALIDA']").val(),
                'NOTA_CANTIDAD': $(this).find("textarea[name='NOTA_CANTIDAD']").val(),
                'ARTICULO_RETORNO': $(this).find("select[name='ARTICULO_RETORNO']").val(),
                'FECHA_RETORNO': $(this).find("input[name='FECHA_RETORNO']").val(),
                'CANTIDAD_RETORNO': $(this).find("input[name='CANTIDAD_RETORNO']").val(),
                'VARIOS_ARTICULOS': $(this).find("select[name='VARIOS_ARTICULOS']").val(),
                'UNIDAD_SALIDA': $(this).find("input[name='UNIDAD_SALIDA']").val(),
                'ES_ASIGNACION': $(this).find("select[name='ES_ASIGNACION']").val(),
                'NOMBRE_ASIGNACION': $(this).find("select[name='NOMBRE_ASIGNACION']").val(),

                'ARTICULOS': [] 
            };

            if (documento.VARIOS_ARTICULOS === "1") {
                $(this).find(".articulo-item").each(function() {
                    var articulo = {
                        'TIPO_INVENTARIO': $(this).find("select[name='TIPO_INVENTARIO_DETALLE[]']").val(),
                        'INVENTARIO': $(this).find("select[name='INVENTARIO_DETALLE[]']").val(),
                        'CANTIDAD_DETALLE': $(this).find("input[name='CANTIDAD_DETALLE[]']").val(),
                        'RETORNA_DETALLE': $(this).find("select[name='RETORNA_DETALLE[]']").val(),
                        'FECHA_DETALLE': $(this).find("input[name='FECHA_DETALLE[]']").val(),
                        'CANTIDAD_RETORNO_DETALLE': $(this).find("input[name='CANTIDAD_RETORNO_DETALLE[]']").val(),
                        'UNIDAD_DETALLE': $(this).find("input[name='UNIDAD_DETALLE[]']").val(),
                        'ES_ASIGNACION_DETALLE': $(this).find("select[name='ES_ASIGNACION_DETALLE[]']").val(),
                        'NOMBRE_ASIGNACION_DETALLE': $(this).find("select[name='NOMBRE_ASIGNACION_DETALLE[]']").val(),


                        

                    };
                    documento.ARTICULOS.push(articulo);
                });
            }

            documentos.push(documento);
        });
        
        const requestData = {
            api: 1,
            ID_FORMULARIO_RECURSOS_EMPLEADOS: ID_FORMULARIO_RECURSOS_EMPLEADOS,
            MATERIALES_JSON: JSON.stringify(documentos)

        };

        if (ID_FORMULARIO_RECURSOS_EMPLEADOS == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardaRECEMPLEADOS')
            await ajaxAwaitFormData(requestData,'SalidalmacenSave', 'formularioRECURSOSEMPLEADO', 'guardaRECEMPLEADOS', { callbackAfter: true, callbackBefore: true }, () => {

        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                    ID_FORMULARIO_RECURSOS_EMPLEADOS = data.mr.ID_FORMULARIO_RECURSOS_EMPLEADOS
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_RECURSOSEMPLEADOS').modal('hide')
                    document.getElementById('formularioRECURSOSEMPLEADO').reset();
                    location.reload();

        
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardaRECEMPLEADOS')
            await ajaxAwaitFormData(requestData,'SalidalmacenSave', 'formularioRECURSOSEMPLEADO', 'guardaRECEMPLEADOS', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_FORMULARIO_RECURSOS_EMPLEADOS = data.mr.ID_FORMULARIO_RECURSOS_EMPLEADOS
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_RECURSOSEMPLEADOS').modal('hide')
                    document.getElementById('formularioRECURSOSEMPLEADO').reset();
                    location.reload();


                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});


var Tablasalidalmacen = $("#Tablasalidalmacen").DataTable({
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
        url: '/Tablasalidalmacen',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablasalidalmacen.columns.adjust().draw();
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
    { data: 'TIPO_SOLICITUD_TEXTO' },
    { data: 'SOLICITANTE_SALIDA' },    
    { data: 'FECHA_SALIDA' },  
    { data: 'FECHA_ALMACEN_SOLICITUD' },    
    { data: 'ESTATUS' },    
    { data: 'MATERIALES_PENDIENTES', defaultContent: '0' }, 
    { data: 'BTN_EDITAR' },
    { data: 'BTN_VISUALIZAR' },

],

columnDefs: [
    { targets: 0, title: '#', className: 'all text-center' },
    { targets: 1, title: 'Tipo de solicitud', className: 'all text-center' },
    { targets: 2, title: 'Nombre del solicitante', className: 'all text-center' }, 
    { targets: 3, title: 'Fecha de solicitud', className: 'all text-center' },
    { targets: 4, title: 'Fecha de entrega', className: 'all text-center' },
    { targets: 5, title: 'Estatus', className: 'all text-center' }, 
    { targets: 6, title: 'Pendientes', className: 'all text-center' },
    { targets: 7, title: 'Editar', className: 'all text-center' },
    { targets: 8, title: 'Visualizar', className: 'all text-center' },

],createdRow: function (row, data, dataIndex) {
    if (data.COLOR_FILA) {
        $(row).addClass(data.COLOR_FILA);
    }
},



});




$(document).ready(function() {
    $('#Tablasalidalmacen tbody').on('click', 'td>button.VISUALIZAR', function () {


    var tr = $(this).closest('tr');
    var row = Tablasalidalmacen.row(tr);
    
    hacerSoloLectura(row.data(), '#miModal_RECURSOSEMPLEADOS');

    ID_FORMULARIO_RECURSOS_EMPLEADOS = row.data().ID_FORMULARIO_RECURSOS_EMPLEADOS;
        
    cargarMaterialesDesdeJSON(row.data().MATERIALES_JSON);


    editarDatoTabla(row.data(), 'formularioRECURSOSEMPLEADO', 'miModal_RECURSOSEMPLEADOS', 1);
    

     
    if (row.data().TIPO_SOLICITUD === "1") {
        $('#PERMISO_AUSENCIA').show();
        $('#SOLIDA_ALMACEN').hide();
        $('#SOLICITUD_VACACIONES').hide();
    } else if (row.data().TIPO_SOLICITUD === "2") {
        $('#SOLIDA_ALMACEN').show();
        $('#PERMISO_AUSENCIA').hide();
        $('#SOLICITUD_VACACIONES').hide();
    } else if (row.data().TIPO_SOLICITUD === "3") {
        $('#SOLICITUD_VACACIONES').show();
        $('#PERMISO_AUSENCIA').hide();
        $('#SOLIDA_ALMACEN').hide();
    }

    if (row.data().CONCEPTO_PERMISO === "9") {
        $('#EXPLIQUE_PERMISO').show();
    } else {
        $('#EXPLIQUE_PERMISO').hide();
    }

    if (row.data().FIRMO_USUARIO === "1") {
        $('#DIV_FIRMAR').hide();
    } else  {
        $('#DIV_FIRMAR').show();
    } 
        
   if (row.data().DAR_BUENO == 1) { 
        $('#VISTO_BUENO_JEFE').show();
        $('#MOTIVO_RECHAZO_JEFE_DIV').hide();

    } else if (row.data().DAR_BUENO == 2) {
        $('#VISTO_BUENO_JEFE').show();
        $('#MOTIVO_RECHAZO_JEFE_DIV').show();

    } else {
        $('#VISTO_BUENO_JEFE').hide();
        $('#MOTIVO_RECHAZO_JEFE_DIV').hide();
    }

    if (row.data().ESTADO_APROBACION === "Aprobada") {
        $('#motivo-rechazo-container').hide();   
        $('#APROBACION_DIRECCION').show();
    
    } else if (row.data().ESTADO_APROBACION === "Rechazada") {
        $('#APROBACION_DIRECCION').show();
        $('#motivo-rechazo-container').show();
                    
    } else {
    
        $('#motivo-rechazo-container').hide();   
        $('#APROBACION_DIRECCION').hide();
    }


   if (row.data().FIRMO_ALMACENISTA === "1") {
        $('#DIV_FIRMAR_ALMACEN').hide();
    } else  {
        $('#DIV_FIRMAR_ALMACEN').show();
    } 

        
        
    });

    $('#miModal_RECURSOSEMPLEADOS').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_RECURSOSEMPLEADOS');
    });
});




$('#Tablasalidalmacen tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablasalidalmacen.row(tr);
    ID_FORMULARIO_RECURSOS_EMPLEADOS = row.data().ID_FORMULARIO_RECURSOS_EMPLEADOS;

    cargarMaterialesDesdeJSON(row.data().MATERIALES_JSON);

    editarDatoTabla(row.data(), 'formularioRECURSOSEMPLEADO', 'miModal_RECURSOSEMPLEADOS', 1);

    if (row.data().TIPO_SOLICITUD === "1") {
        $('#PERMISO_AUSENCIA').show();
        $('#SOLIDA_ALMACEN').hide();
        $('#SOLICITUD_VACACIONES').hide();
    } else if (row.data().TIPO_SOLICITUD === "2") {
        $('#SOLIDA_ALMACEN').show();
        $('#PERMISO_AUSENCIA').hide();
        $('#SOLICITUD_VACACIONES').hide();
    } else if (row.data().TIPO_SOLICITUD === "3") {
        $('#SOLICITUD_VACACIONES').show();
        $('#PERMISO_AUSENCIA').hide();
        $('#SOLIDA_ALMACEN').hide();
    }

    if (row.data().CONCEPTO_PERMISO === "9") {
        $('#EXPLIQUE_PERMISO').show();
    } else {
        $('#EXPLIQUE_PERMISO').hide();
    }

    if (row.data().FIRMO_USUARIO === "1") {
        $('#DIV_FIRMAR').hide();
    } else  {
        $('#DIV_FIRMAR').show();
    } 
        
   if (row.data().DAR_BUENO == 1) { 
       $('#VISTO_BUENO_JEFE').show();
       $('#MOTIVO_RECHAZO_JEFE_DIV').hide();

    } else if (row.data().DAR_BUENO == 2) {
        $('#VISTO_BUENO_JEFE').show();
        $('#MOTIVO_RECHAZO_JEFE_DIV').show();

    } else {
        $('#VISTO_BUENO_JEFE').hide();
        $('#MOTIVO_RECHAZO_JEFE_DIV').hide();
    }

    if (row.data().ESTADO_APROBACION === "Aprobada") {
        $('#motivo-rechazo-container').hide();   
        $('#APROBACION_DIRECCION').show();
    
    } else if (row.data().ESTADO_APROBACION === "Rechazada") {
        $('#APROBACION_DIRECCION').show();
        $('#motivo-rechazo-container').show();
                    
    } else {
       
        $('#motivo-rechazo-container').hide();   
        $('#APROBACION_DIRECCION').hide();
    }

   if (row.data().FIRMO_ALMACENISTA === "1") {
        $('#DIV_FIRMAR_ALMACEN').hide();
    } else  {
       $('#DIV_FIRMAR_ALMACEN').show();
       
        // const hoy = new Date();
        // const yyyy = hoy.getFullYear();
        // const mm = String(hoy.getMonth() + 1).padStart(2, '0');
        // const dd = String(hoy.getDate()).padStart(2, '0');
        // const fechaHoy = `${yyyy}-${mm}-${dd}`;

        // $("#FECHA_ALMACEN_SOLICITUD").val(fechaHoy);
    } 


});




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

function cargarMaterialesDesdeJSON(materialesJson) {
    const contenedorMateriales = document.querySelector('.materialesdiv');
    contenedorMateriales.innerHTML = '';
    contadorMateriales = 1;

    try {
        const materiales = JSON.parse(materialesJson);

        materiales.forEach(material => {
            const divMaterial = document.createElement('div');
            divMaterial.classList.add('material-item', 'mt-2');

            divMaterial.innerHTML = `
                <div class="row p-3 rounded">
                    <div class="col-1 mt-2">
                        <label class="form-label">N°</label>
                        <input type="text" class="form-control" name="NUMERO_ORDEN" value="${contadorMateriales}" readonly>
                    </div>
                    <div class="col-4 mt-2">
                        <label class="form-label">Descripción</label>
                        <input type="text" class="form-control" name="DESCRIPCION" value="${escapeHtml(material.DESCRIPCION)}" required>
                    </div>
                    <div class="col-1 mt-2">
                        <label class="form-label">Cantidad</label>
                        <input type="number" class="form-control cantidad_original" name="CANTIDAD" value="${material.CANTIDAD}" required>
                    </div>

                    <div class="col-2 mt-2">
                        <label class="form-label">Varios ítem</label>
                        <select class="form-control varios_articulos" name="VARIOS_ARTICULOS" required>
                            <option value="" ${!material.VARIOS_ARTICULOS ? "selected" : ""} disabled>Seleccione</option>
                            <option value="0" ${material.VARIOS_ARTICULOS === "0" ? "selected" : ""}>No</option>
                            <option value="1" ${material.VARIOS_ARTICULOS === "1" ? "selected" : ""}>Sí</option>
                        </select>
                    </div>

                    <div class="col-2 mt-2  retorna_wrap">
                        <label class="form-label">¿El ítem retorna?*</label>
                        <select class="form-control retorna_material" name="RETORNA_EQUIPO" required>
                            <option value="0" disabled>Seleccione una opción</option>
                            <option value="1" ${material.RETORNA_EQUIPO === "1" ? "selected" : ""}>Sí</option>
                            <option value="2" ${material.RETORNA_EQUIPO === "2" ? "selected" : ""}>No</option>
                        </select>
                    </div>
                    <div class="col-2 mt-2 campo_unico">
                        <label class="form-label">En existencia</label>
                        <select class="form-control en_existencia" name="EN_EXISTENCIA" required>
                            <option value="" ${!material.EN_EXISTENCIA ? "selected" : ""} disabled>Seleccione</option>
                            <option value="1" ${material.EN_EXISTENCIA === "1" ? "selected" : ""}>Sí</option>
                            <option value="0" ${material.EN_EXISTENCIA === "0" ? "selected" : ""}>No</option>
                        </select>
                    </div>
                    <div class="col-2 mt-2 campo_unico">
                        <label class="form-label">Tipo inventario</label>
                        <select class="form-control tipo_inventario" name="TIPO_INVENTARIO" >
                            <option value="" ${!material.TIPO_INVENTARIO ? "selected" : ""} disabled>Seleccione</option>
                            ${window.tipoinventario.map(t => `
                                <option value="${t.DESCRIPCION_TIPO}" ${material.TIPO_INVENTARIO === t.DESCRIPCION_TIPO ? "selected" : ""}>
                                    ${t.DESCRIPCION_TIPO}
                                </option>
                            `).join('')}
                        </select>
                    </div>

                    <div class="col-5 mt-2 campo_unico">
                        <label class="form-label">Inventario</label>
                        <select class="form-control inventario select2-inventario" name="INVENTARIO">
                             <option value="" ${!material.INVENTARIO ? "selected" : ""} disabled>Seleccione</option>
                         </select>
                     </div>

                    <div class="col-3 mt-2 campo_unico">
                        <label class="form-label">Cantidad sale de almacén</label>
                        <input type="number" class="form-control cantidad_salida" name="CANTIDAD_SALIDA" value="${material.CANTIDAD_SALIDA || ''}">
                    </div>
                    <div class="col-2 mt-2 campo_unico">
                        <label class="form-label">U.M.</label>
                        <input type="text" class="form-control unidad_salida" name="UNIDAD_SALIDA" value="${material.UNIDAD_SALIDA || ''}">
                    </div>

                    <div class="col-6 mt-2 campo_unico">
                        <label class="form-label">Es asignación</label>
                        <select class="form-control asignacion_articulos" name="ES_ASIGNACION" required>
                            <option value="" ${!material.ES_ASIGNACION ? "selected" : ""} disabled>Seleccione</option>
                            <option value="1" ${material.ES_ASIGNACION === "1" ? "selected" : ""}>Sí</option>
                            <option value="0" ${material.ES_ASIGNACION === "0" ? "selected" : ""}>No</option>
                        </select>
                    </div>

                  <div class="col-6 mt-2 div_nombreasignacion text-center"  style="display: none;">
                        <label class="form-label">Nombre colaborador/proveedor</label>
                        <select class="form-control nombre_asignacion text-center" name="NOMBRE_ASIGNACION" required>

                            <option value="">Seleccione</option>

                            <optgroup label="Colaboradores">
                                ${window.colaboradores.map(c => `
                                    <option value="${c.CURP}"
                                        ${material.NOMBRE_ASIGNACION === c.CURP ? "selected" : ""}>
                                        ${c.NOMBRE_COLABORADOR} ${c.PRIMER_APELLIDO} ${c.SEGUNDO_APELLIDO}
                                    </option>
                                `).join('')}
                            </optgroup>

                            <optgroup label="Proveedores">
                                ${window.proveedores.map(p => `
                                    <option value="${p.RFC_ALTA}"
                                        ${material.NOMBRE_ASIGNACION === p.RFC_ALTA ? "selected" : ""}>
                                        ${p.NOMBRE_DIRECTORIO ?? "SIN NOMBRE"} (${p.RFC_ALTA})
                                    </option>
                                `).join('')}
                            </optgroup>

                        </select>
                    </div>


                    <div class="col-4 mt-2 div_articulo_retorno campo_unico" style="display: none;">
                        <label class="form-label">Artículo ya retorno</label>
                        <select class="form-control articulo_retorno" name="ARTICULO_RETORNO" required>
                            <option value="" ${!material.ARTICULO_RETORNO ? "selected" : ""} disabled>Seleccione</option>
                            <option value="1" ${material.ARTICULO_RETORNO === "1" ? "selected" : ""}>Sí</option>
                            <option value="0" ${material.ARTICULO_RETORNO === "0" ? "selected" : ""}>No</option>
                        </select>
                    </div>
                    <div class="col-4 mt-2 div_fecha_retorno" style="display: none;">
                        <label class="form-label">Fecha que retorno</label>
                        <div class="input-group">
                            <input type="text" class="form-control mydatepicker fecha_retorno"  placeholder="aaaa-mm-dd"  name="FECHA_RETORNO" value="${material.FECHA_RETORNO || ''}" required>
                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                        </div>
                    </div>
                    <div class="col-4 mt-2 div_cantidad_retorno" style="display: none;">
                        <label class="form-label">Cantidad que retorna a almacén</label>
                        <input type="number" class="form-control cantidad_retorno" name="CANTIDAD_RETORNO"  value="${material.CANTIDAD_RETORNO || ''}" required>
                    </div>

                    <div class="col-12 mt-2 contenedor_articulos" style="display: none;">
                    </div>

                    <div class="col-12 mt-2 nota_div" style="display: none;">
                        <label class="form-label">Nota (explique por qué no es la misma cantidad)</label>
                        <textarea class="form-control nota_cantidad" name="NOTA_CANTIDAD">${material.NOTA_CANTIDAD || ''}</textarea>
                    </div>
                </div>
            `;

            contenedorMateriales.appendChild(divMaterial);

           
            
            contadorMateriales++;

         

            const selectVarios = divMaterial.querySelector('.varios_articulos');
            const contenedorArticulos = divMaterial.querySelector('.contenedor_articulos');
            const inputCantidadTotal = divMaterial.querySelector('.cantidad_original');
            const divNota = divMaterial.querySelector('.nota_div');
            const textareaNota = divMaterial.querySelector('.nota_cantidad');

         function agregarArticulo(valor = {}) {
            const divArticulo = document.createElement('div');
            divArticulo.classList.add('row', 'g-2', 'mb-2', 'articulo-item');
            divArticulo.innerHTML = `
                <div class="col-2">
                    <label class="form-label">Tipo inventario</label>
                    <select class="form-control tipo_inventario_detalle" name="TIPO_INVENTARIO_DETALLE[]" >
                        <option value="" ${!valor.TIPO_INVENTARIO ? "selected" : ""} disabled>Seleccione</option>
                        ${window.tipoinventario.map(t => `
                            <option value="${t.DESCRIPCION_TIPO}" ${valor.TIPO_INVENTARIO === t.DESCRIPCION_TIPO ? "selected" : ""}>
                                ${t.DESCRIPCION_TIPO}
                            </option>
                        `).join('')}
                    </select>
                </div>
                <div class="col-5">
                    <label class="form-label">Inventario</label>
                    <select class="form-control inventario_detalle select2-inventario-detalee" name="INVENTARIO_DETALLE[]">
                        <option value="" ${!valor.INVENTARIO ? "selected" : ""} disabled>Seleccione</option>
                    </select>
                </div>
                <div class="col-3">
                    <label class="form-label">Cantidad salida</label>
                    <input type="number" class="form-control cantidad_detalle" name="CANTIDAD_DETALLE[]" value="${valor.CANTIDAD_DETALLE || ''}" >
                </div>
                <div class="col-2">
                    <label class="form-label">U.M.</label>
                    <input type="text" class="form-control " name="UNIDAD_DETALLE[]" value="${valor.UNIDAD_DETALLE || ''}" >
                </div>
                  <div class="col-6 mt-2">
                        <label class="form-label">Es asignación</label>
                        <select class="form-control asignacion_detalle" name="ES_ASIGNACION_DETALLE[]" required>
                            <option value="" ${!valor.ES_ASIGNACION_DETALLE ? "selected" : ""} disabled>Seleccione</option>
                            <option value="1" ${valor.ES_ASIGNACION_DETALLE === "1" ? "selected" : ""}>Sí</option>
                            <option value="0" ${valor.ES_ASIGNACION_DETALLE === "0" ? "selected" : ""}>No</option>
                        </select>
                    </div>

                  <div class="col-6 mt-2 detalle_asignacion_div text-center" style="display:none;">
                        <label class="form-label">Nombre colaborador/proveedor</label>
                        <select class="form-control nombreasignacion_detalle text-center" name="NOMBRE_ASIGNACION_DETALLE[]" required>

                            <option value="">Seleccione</option>

                            <optgroup label="Colaboradores">
                                ${window.colaboradores.map(c => `
                                    <option value="${c.CURP}"
                                        ${valor.NOMBRE_ASIGNACION_DETALLE === c.CURP ? "selected" : ""}>
                                        ${c.NOMBRE_COLABORADOR} ${c.PRIMER_APELLIDO} ${c.SEGUNDO_APELLIDO}
                                    </option>
                                `).join('')}
                            </optgroup>

                            <optgroup label="Proveedores">
                                ${window.proveedores.map(p => `
                                    <option value="${p.RFC_ALTA}"
                                        ${valor.NOMBRE_ASIGNACION_DETALLE === p.RFC_ALTA ? "selected" : ""}>
                                        ${p.NOMBRE_DIRECTORIO ?? "SIN NOMBRE"} (${p.RFC_ALTA})
                                    </option>
                                `).join('')}
                            </optgroup>

                        </select>
                    </div>

                <div class="col-4 mt-2 retorna_detalle_wrap">
                    <label class="form-label">Artículo ya retorno</label>
                    <select class="form-control retorna_detalle" name="RETORNA_DETALLE[]" required>
                        <option value="" ${!valor.RETORNA_DETALLE ? "selected" : ""}>Seleccione</option>
                        <option value="1" ${valor.RETORNA_DETALLE === "1" ? "selected" : ""}>Sí</option>
                        <option value="2" ${valor.RETORNA_DETALLE === "2" ? "selected" : ""}>No</option>
                    </select>
                </div>
                <div class="col-4 mt-2 fecha_detalle_div" style="display:none;">
                    <label class="form-label">Fecha retorno</label>
                    <input type="text" class="form-control mydatepicker fecha_detalle" placeholder="aaaa-mm-dd" name="FECHA_DETALLE[]" value="${valor.FECHA_DETALLE || ''}" required>
                </div>
                <div class="col-4 mt-2 cantidad_retorno_div" style="display:none;">
                    <label class="form-label">Cantidad retorno</label>
                    <input type="number" class="form-control cantidad_retorno_detalle" name="CANTIDAD_RETORNO_DETALLE[]" value="${valor.CANTIDAD_RETORNO_DETALLE || ''}" required>
                </div>
            `;
            contenedorArticulos.appendChild(divArticulo);

            const selectTipoDetalle = divArticulo.querySelector('.tipo_inventario_detalle');
            const selectInvDetalle = divArticulo.querySelector('.inventario_detalle');

         
          function cargarInventarioDetalle(tipoSeleccionado, valorGuardado = null) {

                    if (!tipoSeleccionado) return;

                    const opciones = window.inventario
                        .filter(inv => inv.TIPO_EQUIPO === tipoSeleccionado)
                        .sort((a, b) => a.DESCRIPCION_EQUIPO.localeCompare(b.DESCRIPCION_EQUIPO))
                        .map(inv => {

                            const mostrarTexto = (tipoSeleccionado === "AF" || tipoSeleccionado === "ANF")
                                ? `${inv.DESCRIPCION_EQUIPO} (${inv.CODIGO_EQUIPO || ""})`
                                : [
                                    inv.DESCRIPCION_EQUIPO,
                                    inv.MARCA_EQUIPO,
                                    inv.MODELO_EQUIPO,
                                    inv.SERIE_EQUIPO
                                ].filter(Boolean).join(" | ");


                            const estaAsignado = inv.ASIGNADO == 2;
                            const esElGuardado = valorGuardado == inv.ID_FORMULARIO_INVENTARIO;

                            const textoFinal = estaAsignado
                                ? `${mostrarTexto} - Asignado`
                                : mostrarTexto;

                            const disabledAttr = (estaAsignado && !esElGuardado)
                                ? "disabled class='opcion-asignada'"
                                : "";

                            return `
                                <option value="${inv.ID_FORMULARIO_INVENTARIO}"
                                    data-stock="${inv.CANTIDAD_EQUIPO || 0}"
                                    ${esElGuardado ? "selected" : ""}
                                    ${disabledAttr}>
                                    ${textoFinal}
                                </option>
                            `;
                        })
                        .join('');

                    selectInvDetalle.innerHTML = `
                        <option value="" disabled ${!valorGuardado ? "selected" : ""}>Seleccione inventario</option>
                        ${opciones}
                    `;

                    if ($(selectInvDetalle).hasClass("select2-hidden-accessible")) {
                        $(selectInvDetalle).select2('destroy');
                    }

                    $(selectInvDetalle).select2({
                        width: "100%",
                        placeholder: "Seleccione inventario",
                        allowClear: true,
                        dropdownParent: obtenerModalPadre(selectInvDetalle),
                        dropdownPosition: 'below'
                    });

                    const inputCantDetalle = divArticulo.querySelector('.cantidad_detalle');

                    selectInvDetalle.addEventListener('change', function () {
                        const stock = parseInt(this.options[this.selectedIndex]?.dataset.stock || 0);
                        inputCantDetalle.setAttribute('max', stock);
                    });

                    inputCantDetalle.addEventListener('input', function () {
                        const stock = parseInt(selectInvDetalle.options[selectInvDetalle.selectedIndex]?.dataset.stock || 0);
                        if (parseInt(this.value || 0) > stock) {
                            alert(`Solo hay ${stock} unidades disponibles en inventario.`);
                            this.value = stock;
                        }
                    });
                }


             
            if (valor.TIPO_INVENTARIO) {
                cargarInventarioDetalle(valor.TIPO_INVENTARIO, valor.INVENTARIO);
            }
            selectTipoDetalle.addEventListener('change', function () {
                cargarInventarioDetalle(this.value);
            });

                $(divArticulo).find('.mydatepicker').datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true,
                    todayHighlight: true,
                    language: 'es'
                });

             
           
                const wrapRetornaDetalle     = divArticulo.querySelector('.retorna_detalle_wrap'); 
                const selectRetornaDetalle   = divArticulo.querySelector('select.retorna_detalle'); 
                const divFechaDetalle        = divArticulo.querySelector('.fecha_detalle_div');
                const divCantRetDetalle      = divArticulo.querySelector('.cantidad_retorno_div');

                const selectPrincipalRetorna = divMaterial.querySelector('.retorna_material');

                selectRetornaDetalle.value = (valor.RETORNA_DETALLE ?? "").toString();

                function actualizarRetornoDetalle() {
                if (String(selectPrincipalRetorna.value) !== "1") {
                    wrapRetornaDetalle.style.display = "none";
                    divFechaDetalle.style.display = "none";
                    divCantRetDetalle.style.display = "none";
                    return;
                }

                wrapRetornaDetalle.style.display = "block";

                if (String(selectRetornaDetalle.value) === "1") {
                    divFechaDetalle.style.display = "block";
                    divCantRetDetalle.style.display = "block";
                } else {
                    divFechaDetalle.style.display = "none";
                    divCantRetDetalle.style.display = "none";
                }
                }

                selectPrincipalRetorna.addEventListener('change', actualizarRetornoDetalle);
                selectRetornaDetalle.addEventListener('change', actualizarRetornoDetalle);

                setTimeout(actualizarRetornoDetalle, 0);

              
            
                const divnombreasignaciondetalle = divArticulo.querySelector('.detalle_asignacion_div');
                const selectAsignacionarticulosdetalle = divArticulo.querySelector('.asignacion_detalle');
                const selectNombredetalle = divArticulo.querySelector('.nombreasignacion_detalle');

        
                function actualizarNombreAsignacionDetalle() {
                    if (selectAsignacionarticulosdetalle.value === "1") {
                        divnombreasignaciondetalle.style.display = "block";
                    } else {
                        divnombreasignaciondetalle.style.display = "none";
                    }
                    }

                selectAsignacionarticulosdetalle.value = (valor.ES_ASIGNACION_DETALLE ?? "").toString();
                selectNombredetalle.value = (valor.NOMBRE_ASIGNACION_DETALLE ?? "").toString();

            actualizarNombreAsignacionDetalle();

            selectAsignacionarticulosdetalle.addEventListener("change", actualizarNombreAsignacionDetalle);
               

             
            }

        
            function validarCantidades() {
                const cantidades = contenedorArticulos.querySelectorAll('.cantidad_detalle');
                let suma = 0;
                cantidades.forEach(c => suma += parseInt(c.value || 0));
                if (suma !== parseInt(inputCantidadTotal.value || 0)) {
                    divNota.style.display = "block";
                    textareaNota.required = true;
                } else {
                    divNota.style.display = "none";
                    textareaNota.required = false;
                }
            }

            if (material.VARIOS_ARTICULOS === "1") {

                divMaterial.querySelectorAll('.campo_unico').forEach(el => el.style.display = "none");
                contenedorArticulos.style.display = "block";

                if (material.ARTICULOS && Array.isArray(material.ARTICULOS)) {
                    material.ARTICULOS.forEach(a => agregarArticulo(a));
                } else {
                    for (let i = 0; i < parseInt(material.CANTIDAD || 1); i++) {
                        agregarArticulo();
                    }
                }
                validarCantidades();
                contenedorArticulos.addEventListener('input', validarCantidades);
            }

            selectVarios.addEventListener('change', function () {
                if (this.value === "1") {
                    divMaterial.querySelectorAll('.campo_unico').forEach(el => el.style.display = "none");
                    contenedorArticulos.style.display = "block";
                    contenedorArticulos.innerHTML = '';
                    for (let i = 0; i < parseInt(inputCantidadTotal.value || 1); i++) {
                        agregarArticulo();
                    }
                    validarCantidades();
                    contenedorArticulos.addEventListener('input', validarCantidades);
                } else {
                    divMaterial.querySelectorAll('.campo_unico').forEach(el => el.style.display = "block");
                    contenedorArticulos.style.display = "none";
                    contenedorArticulos.innerHTML = '';
                    divNota.style.display = "none";
                    textareaNota.required = false;
                }
            });


        

        const selectEnExistencia = divMaterial.querySelector('.en_existencia');
        const selectTipo = divMaterial.querySelector('.tipo_inventario');
        const selectInv = divMaterial.querySelector('.inventario');
        const inputCantidad = divMaterial.querySelector('.cantidad_original');
        const inputSalida = divMaterial.querySelector('.cantidad_salida');
        const inputunidad = divMaterial.querySelector('.unidad_salida');
        
        const selectRetorna = divMaterial.querySelector('.retorna_material');
        const divArticuloRetorno = divMaterial.querySelector('.div_articulo_retorno');
        const selectArticuloRetorno = divMaterial.querySelector('.articulo_retorno');
        const divFechaRetorno = divMaterial.querySelector('.div_fecha_retorno');
        const divCantidadRetorno = divMaterial.querySelector('.div_cantidad_retorno');

            
        const divnombreasignacion = divMaterial.querySelector('.div_nombreasignacion');
        const selectAsignacionarticulos = divMaterial.querySelector('.asignacion_articulos');

        function actualizarNombreAsignacion() {
            if (selectAsignacionarticulos.value === "1") {
                divnombreasignacion.style.display = "block";
            } else {
                divnombreasignacion.style.display = "none";
            }
        }

        actualizarNombreAsignacion();
        selectAsignacionarticulos.addEventListener("change", actualizarNombreAsignacion);


        if (material.VARIOS_ARTICULOS !== "1") {
        
            $(divMaterial).find('.mydatepicker').datepicker({
                format: 'yyyy-mm-dd',
                weekStart: 1,
                autoclose: true,
                todayHighlight: true,
                language: 'es'
            }).on('click', function () {
                $(this).datepicker('setDate', $(this).val());
            });

            
            function cargarInventario(tipoSeleccionado, valorGuardado = null) {

                if (!tipoSeleccionado) return;

                const opciones = window.inventario
                    .filter(inv => inv.TIPO_EQUIPO === tipoSeleccionado)
                    .sort((a, b) => a.DESCRIPCION_EQUIPO.localeCompare(b.DESCRIPCION_EQUIPO))
                        .map(inv => {

                      const mostrarTexto = (tipoSeleccionado === "AF" || tipoSeleccionado === "ANF")
                    ? `${inv.DESCRIPCION_EQUIPO} (${inv.CODIGO_EQUIPO || ""})`
                    : [
                        inv.DESCRIPCION_EQUIPO,
                        inv.MARCA_EQUIPO,
                        inv.MODELO_EQUIPO,
                        inv.SERIE_EQUIPO
                    ].filter(Boolean).join(" | ");

                        const estaAsignado = inv.ASIGNADO == 2;

                        const esElGuardado = valorGuardado == inv.ID_FORMULARIO_INVENTARIO;

                        const textoFinal = estaAsignado
                            ? `${mostrarTexto} - Asignado`
                            : mostrarTexto;

                        const disabledAttr = (estaAsignado && !esElGuardado)
                            ? "disabled class='opcion-asignada'"
                            : "";

                        return `
                            <option value="${inv.ID_FORMULARIO_INVENTARIO}"
                                data-stock="${inv.CANTIDAD_EQUIPO || 0}"
                                ${esElGuardado ? "selected" : ""}
                                ${disabledAttr}>
                                ${textoFinal}
                            </option>
                        `;
                            }).join('');

                selectInv.innerHTML = `
                    <option value="" disabled ${!valorGuardado ? "selected" : ""}>Seleccione inventario</option>
                    ${opciones}
                `;

                if ($(selectInv).hasClass("select2-hidden-accessible")) {
                    $(selectInv).select2('destroy');
                }

                $(selectInv).select2({
                    width: "100%",
                    placeholder: "Seleccione inventario",
                    allowClear: true,
                    dropdownParent: obtenerModalPadre(selectInv),
                    dropdownPosition: 'below'
                });

                inputSalida.addEventListener("input", function () {
                    const stock = parseInt(selectInv.options[selectInv.selectedIndex]?.dataset.stock || 0);
                    if (parseInt(this.value || 0) > stock) {
                        alert(`Solo hay ${stock} unidades disponibles.`);
                        this.value = stock;
                    }
                });
            }


            if (material.TIPO_INVENTARIO) {
                cargarInventario(material.TIPO_INVENTARIO, material.INVENTARIO);
            }

            selectTipo.addEventListener('change', function () {
                cargarInventario(this.value);
            });

            // Activar/desactivar inventario y cantidad salida según existencia
           
            function actualizarEstadoInventario() {
                if (selectEnExistencia.value === "0") { 
                    selectTipo.value = "";
                    selectInv.value = "";
                    inputSalida.value = "";
                    inputunidad.value = "";

                    selectTipo.style.pointerEvents = "none";
                    selectTipo.style.backgroundColor = "#e9ecef";
                    selectInv.style.pointerEvents = "none";
                    selectInv.style.backgroundColor = "#e9ecef";
                    inputSalida.disabled = true;
                    inputunidad.disabled = true;
                    inputSalida.removeAttribute("required");

                    divNota.style.display = "none";
                    textareaNota.required = false;

                } else { 

                    selectTipo.style.pointerEvents = "auto";
                    selectTipo.style.backgroundColor = "";
                    selectInv.style.pointerEvents = "auto";
                    selectInv.style.backgroundColor = "";
                    inputSalida.disabled = false;
                    inputunidad.disabled = false;

                    revisarCantidadSalida();
                }
            }

            
            actualizarEstadoInventario();
            selectEnExistencia.addEventListener('change', actualizarEstadoInventario);

            function revisarCantidadSalida() {
                if (
                    selectEnExistencia.value === "1" &&
                    parseInt(inputSalida.value || 0) !== parseInt(inputCantidad.value || 0)
                ) {
                    divNota.style.display = "block";
                    textareaNota.required = true;
                } else {
                    divNota.style.display = "none";
                    textareaNota.required = false;
                }
            }

            revisarCantidadSalida();
            inputSalida.addEventListener('input', revisarCantidadSalida);
        }

            function actualizarRetorno() {

                if (selectVarios.value === "1") {
                        divArticuloRetorno.style.display = "none";
                        divFechaRetorno.style.display = "none";
                        divCantidadRetorno.style.display = "none";
                        return;
                    }

                    if (selectRetorna.value === "1") {
                        divArticuloRetorno.style.display = "block";

                        if (selectArticuloRetorno.value === "1") {
                            divFechaRetorno.style.display = "block";
                            divCantidadRetorno.style.display = "block";
                        } else {
                            divFechaRetorno.style.display = "none";
                            divCantidadRetorno.style.display = "none";
                        }
                    } else {
                        divArticuloRetorno.style.display = "none";
                        divFechaRetorno.style.display = "none";
                        divCantidadRetorno.style.display = "none";
                }
                


                 if (selectRetorna.value === "1") {
                        divArticuloRetorno.style.display = "block";

                        if (selectArticuloRetorno.value === "1") {
                            divFechaRetorno.style.display = "block";
                            divCantidadRetorno.style.display = "block";
                        } else {
                            divFechaRetorno.style.display = "none";
                            divCantidadRetorno.style.display = "none";
                        }
                    } else {
                        divArticuloRetorno.style.display = "none";
                        divFechaRetorno.style.display = "none";
                        divCantidadRetorno.style.display = "none";
                }
                
                
                }

                actualizarRetorno();

            
            

            // Eventos
                selectRetorna.addEventListener("change", actualizarRetorno);
                selectArticuloRetorno.addEventListener("change", actualizarRetorno);
                selectVarios.addEventListener("change", actualizarRetorno);

            
   
    
        });

        


        revisarSelects();

    } catch (e) {
        console.error('Error al parsear MATERIALES_JSON:', e);
    }
}









function revisarSelects() {
    const selects = document.querySelectorAll('.retorna_material');
    let mostrar = false;
    selects.forEach(sel => {
        if (sel.value === "1") { 
            mostrar = true;
        }
    });
    document.getElementById("FECHA_ESTIMADA").style.display = mostrar ? "block" : "none";
}






document.addEventListener("DOMContentLoaded", function () {
    const select = document.getElementById("TIPO_SOLICITUD");

    const divs = {
        "1": document.getElementById("PERMISO_AUSENCIA"),
        "2": document.getElementById("SOLIDA_ALMACEN"),
        "3": document.getElementById("SOLICITUD_VACACIONES")
    };

    select.addEventListener("change", function () {
        Object.values(divs).forEach(div => {
            div.style.display = "none";

            div.querySelectorAll("input, select, textarea").forEach(el => {
                if (el.id === "SOLICITANTE_SALIDA" || el.id === "SOLICITANTE_PERMISO") {
                    return; 
                }

                if (el.type === "radio" || el.type === "checkbox") {
                    el.checked = false;
                } else {
                    el.value = "";
                }
            });
        });


        if (divs[this.value]) {
            divs[this.value].style.display = "block";
        }

        

        if (this.value === "1") {
            $.get('/obtenerDatosPermiso', function (response) {
                if (response.cargo) {
                    $("#CARGO_PERMISO").val(response.cargo);
                }
                if (response.numero_empleado) {
                    $("#NOEMPLEADO_PERMISO").val(response.numero_empleado);
                }
            });
        }
    });
});





document.addEventListener("DOMContentLoaded", function () {
    const btnFirmar = document.getElementById("FIRMAR_SOLICITUD_ALMACEN");
    const inputFirmo = document.getElementById("FIRMO_ALMACENISTA");
    const inputFirmadoPor = document.getElementById("FIRMA_ALMACEN");
    const inputFechaSalida = document.getElementById("FECHA_ALMACEN_SOLICITUD");

    btnFirmar.addEventListener("click", function () {
        let usuarioNombre = btnFirmar.getAttribute("data-usuario");
        let fechaSalida = inputFechaSalida.value; // yyyy-mm-dd

        // Validar que exista fecha
        if (!fechaSalida) {
            alert("Debe ingresar la fecha antes de firmar la solicitud.");

            // Marcar el input en rojo
            inputFechaSalida.classList.add("is-invalid");

            // Quitar el rojo automáticamente cuando empiece a escribir
            inputFechaSalida.addEventListener("input", function () {
                if (this.value) {
                    this.classList.remove("is-invalid");
                }
            });

            return; // detener ejecución
        }

        // Obtener hora actual
        let ahora = new Date();
        let horas = ahora.getHours();
        let minutos = String(ahora.getMinutes()).padStart(2, "0");
        let segundos = String(ahora.getSeconds()).padStart(2, "0");

        // Determinar AM o PM
        let ampm = horas >= 12 ? "p.m." : "a.m.";

        // Convertir a formato de 12 horas
        horas = horas % 12;
        horas = horas ? horas : 12; // El 0 se convierte en 12

        let horaCompleta = horas + ":" + minutos + ":" + segundos + " " + ampm;

        // Asignar valores
        inputFirmo.value = "1";
        inputFirmadoPor.value = usuarioNombre + " el " + fechaSalida ;
    });
});



