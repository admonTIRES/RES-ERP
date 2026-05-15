//VARIABLESID_FORMULARIO_MR = 0




const Modalmr = document.getElementById('miModal_MR');
Modalmr.addEventListener('hidden.bs.modal', event => {
    ID_FORMULARIO_MR = 0;
    document.getElementById('formularioMR').reset();

   
        document.getElementById('DAR_BUENO').value = "0"; 

    
    document.querySelector('.materialesdiv').innerHTML = '';
    contadorMateriales = 1;

    
});







$("#NUEVO_MR").click(function (e) {
    e.preventDefault();


       
    $('#formularioMR').each(function(){
        this.reset();
    });

    $(".materialesdiv").empty();


    $("#miModal_MR").modal("show");


    $.get('/obtenerAreaSolicitante', function(response) {
    if (response.area) {
        $("#AREA_SOLICITANTE_MR").val(response.area);
    } else {
        $("#AREA_SOLICITANTE_MR").val("Área no encontrada");
    }
});


    

cambiarColor();
   
});



let contadorMateriales = 1; 

// document.addEventListener("DOMContentLoaded", function () {
//     const botonMaterial = document.getElementById('botonmaterial');
//     const contenedorMateriales = document.querySelector('.materialesdiv');
//     let contadorMateriales = 1;

//     botonMaterial.addEventListener('click', function () {
//         agregarMaterial();
//     });

//     function agregarMaterial() {
//         const divMaterial = document.createElement('div');
//         divMaterial.classList.add('row', 'material-item', 'mt-1');
//         divMaterial.innerHTML = `
//           <div class="col-1">
//                 <div class="form-check">
//                     <input class="form-check-input" type="checkbox" name="CHECK_MATERIAL" disabled>
//                     <label class="form-check-label">Verificado</label>
//                 </div>
//             </div>
//             <div class="col-1">
//                 <label class="form-label">N°</label>
//                 <input type="text" class="form-control" name="NUMERO_ORDEN" value="${contadorMateriales}" readonly>
//             </div>
//             <div class="col-5">
//                 <label class="form-label">Descripción</label>
//                 <input type="text" class="form-control" name="DESCRIPCION" required>
//             </div>
//             <div class="col-1">
//                 <label class="form-label">Cantidad</label>
//                 <input type="number" class="form-control" name="CANTIDAD" required>
//             </div>
//             <div class="col-2">
//                 <label class="form-label">Unidad de Medida</label>
//                 <input type="text" class="form-control" name="UNIDAD_MEDIDA" required>
//             </div>
          
//             <div class="col-2">
//                 <label class="form-label">Línea de Negocios</label>
//                 <select class="form-select" name="CATEGORIA_MATERIAL" disabled>
//                     <option value="">Seleccionar</option>
//                     <option value="STE">STE</option>
//                     <option value="SST">SST</option>
//                     <option value="SCA">SCA</option>
//                     <option value="SMA">SMA</option>
//                     <option value="SLH">SLH</option>
//                     <option value="ADM">ADM</option>
//                 </select>
//             </div>
//             <div class="col-12 mt-2 text-end">
//                 <button type="button" class="btn btn-danger botonEliminarMaterial" title="Eliminar">
//                     <i class="bi bi-trash"></i>
//                 </button>
//             </div>
//         `;

//         contenedorMateriales.appendChild(divMaterial);
//         contadorMateriales++;

//         const botonEliminar = divMaterial.querySelector('.botonEliminarMaterial');
//         botonEliminar.addEventListener('click', function () {
//             contenedorMateriales.removeChild(divMaterial);
//             actualizarNumerosOrden(); // asegúrate de tener esta función si quieres reenumerar
//         });
//     }
// });


  function actualizarNumerosOrden() {
        const materiales = document.querySelectorAll('.material-item');
        let nuevoContador = 1;
        materiales.forEach(material => {
            material.querySelector('input[name="NUMERO_ORDEN"]').value = nuevoContador;
            nuevoContador++;
        });
        contadorMateriales = nuevoContador;
}
    


function cambiarColor() {
        var select = document.getElementById("ESTADO_APROBACION");
        var container = document.getElementById("estado-container");
        var motivoContainer = document.getElementById("motivo-rechazo-container");

        if (select.value === "Aprobada") {
            container.style.backgroundColor = "green";
            container.style.color = "white";
            motivoContainer.style.display = "none"; 
        } else if (select.value === "Rechazada") {
            container.style.backgroundColor = "red";
            container.style.color = "white";
            motivoContainer.style.display = "block"; 
        } else {
            container.style.backgroundColor = "transparent";
            container.style.color = "black";
            motivoContainer.style.display = "none"; 
        }
}
    











$("#guardarMR").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormularioV1('formularioMR');

    if (formularioValido) {

        
         var documentos = [];
        $(".material-item").each(function() {
            var documento = {
                'DESCRIPCION': $(this).find("input[name='DESCRIPCION']").val(),
                'CANTIDAD': $(this).find("input[name='CANTIDAD']").val(),
                'UNIDAD_MEDIDA': $(this).find("input[name='UNIDAD_MEDIDA']").val(),
            'CHECK_MATERIAL': $(this).find("input[name='CHECK_MATERIAL']").is(":checked"),
        'CATEGORIA_MATERIAL': $(this).find("select[name='CATEGORIA_MATERIAL']").val()

            };
            documentos.push(documento);
        });


        const requestData = {
            api: 1,
            ID_FORMULARIO_MR: ID_FORMULARIO_MR,
            MATERIALES_JSON: JSON.stringify(documentos)

        };

        if (ID_FORMULARIO_MR == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarMR')
            await ajaxAwaitFormData(requestData,'MrSave', 'formularioMR', 'guardarMR', { callbackAfter: true, callbackBefore: true }, () => {

        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_FORMULARIO_MR = data.mr.ID_FORMULARIO_MR
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_MR').modal('hide')
                    document.getElementById('formularioMR').reset();
                    Tablarequisicion.ajax.reload()

        
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarMR')
            await ajaxAwaitFormData(requestData,'MrSave', 'formularioMR', 'guardarMR', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_FORMULARIO_MR = data.mr.ID_FORMULARIO_MR
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_MR').modal('hide')
                    document.getElementById('formularioMR').reset();
                    Tablarequisicion.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});


var Tablarequisicion = $("#Tablarequisicion").DataTable({
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
        url: '/Tablarequisicion',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablarequisicion.columns.adjust().draw();
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
    { data: 'SOLICITANTE_MR' },
    { data: 'NO_MR' },
    { data: 'FECHA_SOLICITUD_MR' },
    { data: 'ESTADO_REVISION' }, 
    { data: 'ESTATUS' },          
    { data: 'BTN_EDITAR' },
],

columnDefs: [
    { targets: 0, title: '#', className: 'all text-center' },
    { targets: 1, title: 'Nombre del solicitante', className: 'all text-center' },
    { targets: 2, title: 'N° MR', className: 'all text-center' },
    { targets: 3, title: 'Fecha solicitud', className: 'all text-center' },
    { targets: 4, title: 'Vo. Bo ', className: 'all text-center' },
    { targets: 5, title: 'Estatus', className: 'all text-center' }, 
    { targets: 6, title: 'Editar', className: 'all text-center' },
    ],
    infoCallback: function (settings, start, end, max, total, pre) {
        return `Total de ${total} registros`;
    },

});




$('#Tablarequisicion tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablarequisicion.row(tr);
    ID_FORMULARIO_MR = row.data().ID_FORMULARIO_MR;

    cargarMaterialesDesdeJSON(row.data().MATERIALES_JSON);

    editarDatoTabla(row.data(), 'formularioMR', 'miModal_MR', 1);

    var nombreAutenticado = $('meta[name="usuario-autenticado"]').attr('content');
    if (!row.data().VISTO_BUENO) {
        $('#VISTO_BUENO').val(nombreAutenticado);
    } else {
        $('#VISTO_BUENO').val(row.data().VISTO_BUENO);
    }

    if (row.data().ESTADO_APROBACION === "Aprobada") {
        $('#motivo-rechazo-container').hide();
        $('#APROBACION_DIRECCION').show();
    } else {
          
        $('#motivo-rechazo-container').show();
        $('#APROBACION_DIRECCION').show();      
    }

    if (row.data().DAR_BUENO === "1") {
        $('#BOTON_VISTO_BUENO').hide();
    } else if (row.data().DAR_BUENO === "2") {
         $('#BOTON_VISTO_BUENO').hide();
     } else {
         $('#BOTON_VISTO_BUENO').show();          
    }

    const hoy = new Date();
    const yyyy = hoy.getFullYear();
    const mm = String(hoy.getMonth() + 1).padStart(2, '0');
    const dd = String(hoy.getDate()).padStart(2, '0');
    const fechaHoy = `${yyyy}-${mm}-${dd}`;

    $("#FECHA_VISTO_MR").val(fechaHoy);

    
});



// function cargarMaterialesDesdeJSON(materialesJson) {
//     const contenedorMateriales = document.querySelector('.materialesdiv');
//     contenedorMateriales.innerHTML = '';
//     contadorMateriales = 1;

//     try {
//         const materiales = JSON.parse(materialesJson);

//         materiales.forEach(material => {
//             const divMaterial = document.createElement('div');
//             divMaterial.classList.add('material-item', 'mt-2');

//             let colorClass = '';
//            if (material.CHECK_VO === 'SI' && material.CHECK_MATERIAL !== 'NO') {
//                 colorClass = 'bg-verde-suave';
//             } else if (
//                 material.CHECK_VO === 'NO' ||
//                 (material.CHECK_VO === 'SI' && material.CHECK_MATERIAL === 'NO')
//             ) {
//                 colorClass = 'bg-rojo-suave';
//             }

//             divMaterial.innerHTML = `
//                 <div class="row p-3 rounded color-vo ${colorClass}">
//                     <div class="col-1">
//                         <label class="form-label">Aprobado</label>
//                         <select class="form-select" name="CHECK_MATERIAL" disabled >
//                             <option value=""></option>
//                             <option value="SI" ${material.CHECK_MATERIAL === 'SI' ? 'selected' : ''}>Sí</option>
//                             <option value="NO" ${material.CHECK_MATERIAL === 'NO' ? 'selected' : ''}>No</option>
//                         </select>
//                     </div>
//                     <div class="col-1">
//                         <label class="form-label">N°</label>
//                         <input type="text" class="form-control" name="NUMERO_ORDEN" value="${contadorMateriales}" readonly>
//                     </div>
//                     <div class="col-4">
//                         <label class="form-label">Descripción</label>
//                         <input type="text" class="form-control" name="DESCRIPCION" value="${material.DESCRIPCION}" >
//                     </div>
//                     <div class="col-1">
//                         <label class="form-label">Cantidad</label>
//                         <input type="number" class="form-control" name="CANTIDAD" value="${material.CANTIDAD}" >
//                     </div>
//                     <div class="col-2">
//                         <label class="form-label">Unidad de Medida</label>
//                         <input type="text" class="form-control" name="UNIDAD_MEDIDA" value="${material.UNIDAD_MEDIDA}" required>
//                     </div>
//                     <div class="col-2">
//                         <label class="form-label">Línea de Negocios</label>
//                         <select class="form-select" name="CATEGORIA_MATERIAL"  required>
//                             <option value="">Seleccionar</option>
//                             <option value="STE" ${material.CATEGORIA_MATERIAL === 'STE' ? 'selected' : ''}>STE</option>
//                             <option value="SST" ${material.CATEGORIA_MATERIAL === 'SST' ? 'selected' : ''}>SST</option>
//                             <option value="SCA" ${material.CATEGORIA_MATERIAL === 'SCA' ? 'selected' : ''}>SCA</option>
//                             <option value="SMA" ${material.CATEGORIA_MATERIAL === 'SMA' ? 'selected' : ''}>SMA</option>
//                             <option value="SLH" ${material.CATEGORIA_MATERIAL === 'SLH' ? 'selected' : ''}>SLH</option>
//                             <option value="ADM" ${material.CATEGORIA_MATERIAL === 'ADM' ? 'selected' : ''}>ADM</option>
//                         </select>
//                     </div>
//                     <div class="col-1">
//                         <label class="form-label">Vo. Bo</label>
//                         <select class="form-select check-vo-select" name="CHECK_VO" required>
//                             <option value=""></option>
//                             <option value="SI" ${material.CHECK_VO === 'SI' ? 'selected' : ''}>Sí</option>
//                             <option value="NO" ${material.CHECK_VO === 'NO' ? 'selected' : ''}>No</option>
//                         </select>
//                     </div>
//                     <div class="col-12 mt-2 text-end">
//                         <button type="button" class="btn btn-danger botonEliminarMaterial" title="Eliminar">
//                             <i class="bi bi-trash"></i>
//                         </button>
//                     </div>
//                 </div>
//             `;

//             contenedorMateriales.appendChild(divMaterial);
//             contadorMateriales++;

//             const botonEliminar = divMaterial.querySelector('.botonEliminarMaterial');
//             botonEliminar.addEventListener('click', function () {
//                 contenedorMateriales.removeChild(divMaterial);
//                 actualizarNumerosOrden();
//             });

//             const selectVoBo = divMaterial.querySelector('.check-vo-select');
//             const contenedorColor = divMaterial.querySelector('.color-vo');

//             selectVoBo.addEventListener('change', function () {
//                 contenedorColor.classList.remove('bg-verde-suave', 'bg-rojo-suave');

//                 if (selectVoBo.value === 'SI') {
//                     contenedorColor.classList.add('bg-verde-suave');
//                 } else if (selectVoBo.value === 'NO') {
//                     contenedorColor.classList.add('bg-rojo-suave');
//                 }
//             });
//         });

//     } catch (e) {
//         console.error('Error al parsear MATERIALES_JSON:', e);
//     }
// }


function cargarMaterialesDesdeJSON(materialesJson) {
    const contenedorMateriales = document.querySelector('.materialesdiv');
    contenedorMateriales.innerHTML = '';
    contadorMateriales = 1;

    try {
        const materiales = JSON.parse(materialesJson);

        const filtrosDiv = document.createElement('div');
        filtrosDiv.classList.add('row', 'mb-3', 'justify-content-center');

        filtrosDiv.innerHTML = `
            <div class="col-3  text-center">
                <label class="form-label fw-bold">Seleccionar línea de negocio</label>
                <select class="form-select" id="filtroLineaNegocios">
                    <option value=""></option>
                    <option value="STE">STE</option>
                    <option value="SST">SST</option>
                    <option value="SCA">SCA</option>
                    <option value="SMA">SMA</option>
                    <option value="SLH">SLH</option>
                    <option value="ADM">ADM</option>
                </select>
            </div>
            <div class="col-3  text-center">
                <label class="form-label fw-bold">Vo. Bo</label>
                <select class="form-select" id="filtroVoBo">
                    <option value=""></option>
                    <option value="SI">Sí</option>
                    <option value="NO">No</option>
                </select>
            </div>
        `;
        contenedorMateriales.appendChild(filtrosDiv);

        const filtroLinea = filtrosDiv.querySelector('#filtroLineaNegocios');
        const filtroVoBo = filtrosDiv.querySelector('#filtroVoBo');

        filtroLinea.addEventListener('change', function () {
            const valorSeleccionado = this.value;
            const selectsCategoria = contenedorMateriales.querySelectorAll('select[name="CATEGORIA_MATERIAL"]');
            selectsCategoria.forEach(select => {
                select.value = valorSeleccionado;
            });
        });

        filtroVoBo.addEventListener('change', function () {
            const valorSeleccionado = this.value;
            const selectsVoBo = contenedorMateriales.querySelectorAll('select[name="CHECK_VO"]');
            selectsVoBo.forEach(select => {
                select.value = valorSeleccionado;

                const contenedorColor = select.closest('.color-vo');
                if (contenedorColor) {
                    contenedorColor.classList.remove('bg-verde-suave', 'bg-rojo-suave');
                    if (valorSeleccionado === 'SI') {
                        contenedorColor.classList.add('bg-verde-suave');
                    } else if (valorSeleccionado === 'NO') {
                        contenedorColor.classList.add('bg-rojo-suave');
                    }
                }
            });
        });

        materiales.forEach(material => {
            const divMaterial = document.createElement('div');
            divMaterial.classList.add('material-item', 'mt-2');

            let colorClass = '';
            if (material.CHECK_VO === 'SI' && material.CHECK_MATERIAL !== 'NO') {
                colorClass = 'bg-verde-suave';
            } else if (
                material.CHECK_VO === 'NO' ||
                (material.CHECK_VO === 'SI' && material.CHECK_MATERIAL === 'NO')
            ) {
                colorClass = 'bg-rojo-suave';
            }

            divMaterial.innerHTML = `
                <div class="row p-3 rounded color-vo ${colorClass}">
                    <div class="col-1">
                        <label class="form-label">Aprobado</label>
                        <select class="form-select" name="CHECK_MATERIAL" disabled>
                            <option value=""></option>
                            <option value="SI" ${material.CHECK_MATERIAL === 'SI' ? 'selected' : ''}>Sí</option>
                            <option value="NO" ${material.CHECK_MATERIAL === 'NO' ? 'selected' : ''}>No</option>
                        </select>
                    </div>
                    <div class="col-1">
                        <label class="form-label">N°</label>
                        <input type="text" class="form-control" name="NUMERO_ORDEN" value="${contadorMateriales}" readonly>
                    </div>
                    <div class="col-4">
                        <label class="form-label">Descripción</label>
<input type="text" class="form-control" name="DESCRIPCION" value="${escapeHtml(material.DESCRIPCION)}" required>
                    </div>
                    <div class="col-1">
                        <label class="form-label">Cantidad</label>
                        <input type="number" class="form-control" name="CANTIDAD" value="${material.CANTIDAD}">
                    </div>
                    <div class="col-2">
                        <label class="form-label">Unidad de Medida</label>
                        <input type="text" class="form-control" name="UNIDAD_MEDIDA" value="${material.UNIDAD_MEDIDA}" required>
                    </div>
                    <div class="col-2">
                        <label class="form-label">Línea de Negocios</label>
                        <select class="form-select" name="CATEGORIA_MATERIAL" required>
                            <option value="">Seleccionar</option>
                            <option value="STE" ${material.CATEGORIA_MATERIAL === 'STE' ? 'selected' : ''}>STE</option>
                            <option value="SST" ${material.CATEGORIA_MATERIAL === 'SST' ? 'selected' : ''}>SST</option>
                            <option value="SCA" ${material.CATEGORIA_MATERIAL === 'SCA' ? 'selected' : ''}>SCA</option>
                            <option value="SMA" ${material.CATEGORIA_MATERIAL === 'SMA' ? 'selected' : ''}>SMA</option>
                            <option value="SLH" ${material.CATEGORIA_MATERIAL === 'SLH' ? 'selected' : ''}>SLH</option>
                            <option value="ADM" ${material.CATEGORIA_MATERIAL === 'ADM' ? 'selected' : ''}>ADM</option>
                        </select>
                    </div>
                    <div class="col-1">
                        <label class="form-label">Vo. Bo</label>
                        <select class="form-select check-vo-select" name="CHECK_VO" required>
                            <option value=""></option>
                            <option value="SI" ${material.CHECK_VO === 'SI' ? 'selected' : ''}>Sí</option>
                            <option value="NO" ${material.CHECK_VO === 'NO' ? 'selected' : ''}>No</option>
                        </select>
                    </div>
                    <div class="col-12 mt-2 text-end">
                        <button type="button" class="btn btn-danger botonEliminarMaterial" title="Eliminar">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            `;

            contenedorMateriales.appendChild(divMaterial);
            contadorMateriales++;

            const botonEliminar = divMaterial.querySelector('.botonEliminarMaterial');
            botonEliminar.addEventListener('click', function () {
                contenedorMateriales.removeChild(divMaterial);
                actualizarNumerosOrden();
            });

            const selectVoBo = divMaterial.querySelector('.check-vo-select');
            const contenedorColor = divMaterial.querySelector('.color-vo');

            selectVoBo.addEventListener('change', function () {
                contenedorColor.classList.remove('bg-verde-suave', 'bg-rojo-suave');

                if (selectVoBo.value === 'SI') {
                    contenedorColor.classList.add('bg-verde-suave');
                } else if (selectVoBo.value === 'NO') {
                    contenedorColor.classList.add('bg-rojo-suave');
                }
            });
        });

    } catch (e) {
        console.error('Error al parsear MATERIALES_JSON:', e);
    }
}


function darVistoBueno() {
    Swal.fire({
        title: '¿Deseas dar el visto bueno a la M.R?',
        text: "Esta acción enviará la solicitud y guardará los datos.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, enviar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Validación general del formulario
            const formularioValido = validarFormularioV1('formularioMR');
            if (!formularioValido) {
                alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000);
                return;
            }

            var documentos = [];
            var camposCompletos = true;

            $(".material-item").each(function () {
                var documento = {
                    'DESCRIPCION': $(this).find("input[name='DESCRIPCION']").val(),
                    'CANTIDAD': $(this).find("input[name='CANTIDAD']").val(),
                    'UNIDAD_MEDIDA': $(this).find("input[name='UNIDAD_MEDIDA']").val(),
                    'CHECK_VO': $(this).find("select[name='CHECK_VO']").val(),
                    'CATEGORIA_MATERIAL': $(this).find("select[name='CATEGORIA_MATERIAL']").val(),
                    'CHECK_MATERIAL': $(this).find("select[name='CHECK_MATERIAL']").val()
                };

                // Verifica si algún campo está vacío
                if (
                 
                    !documento.CHECK_VO ||
                    !documento.CATEGORIA_MATERIAL 
                ) {
                    camposCompletos = false;
                }

                documentos.push(documento);
            });

            if (!camposCompletos) {
                alertToast('Por favor, complete todos los campos de materiales.', 'error', 2000);
                return;
            }

            var materialesJson = JSON.stringify(documentos);

            if (typeof ID_FORMULARIO_MR !== 'undefined' && ID_FORMULARIO_MR > 0) {
                $.ajax({
                    url: '/guardarYDarVistoBueno',
                    method: 'POST',
                    data: {
                        id: ID_FORMULARIO_MR,
                        prioridad: $('#PRIORIDAD_MR').val(),
                        observaciones: $('#OBSERVACIONES_MR').val(),
                        fecha_visto: $('#FECHA_VISTO_MR').val(),
                        visto_bueno: $('#VISTO_BUENO').val(),
                        materiales_json: materialesJson,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Visto bueno registrado',
                                text: response.message
                            });

                            $('#miModal_MR').modal('hide');
                            $('#Tablarequisicion').DataTable().ajax.reload(null, false);
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error al guardar el formulario.'
                        });
                    }
                });
            }
        }
    });
}







function validarCamposObligatoriosMR() {
    var camposValidos = true;

    var campos = [
        '#PRIORIDAD_MR',
        '#FECHA_VISTO_MR',
    ];

    campos.forEach(function(selector) {
        var valor = $(selector).val();
        if (!valor || valor.trim() === '') {
            camposValidos = false;
        }
    });

    return camposValidos;
}



function rechazarVistoBueno() {
    if (!validarCamposObligatoriosMR()) {
        Swal.fire({
            icon: 'warning',
            title: 'Campos incompletos',
            text: 'Debe llenar todos los campos antes de poder rechazar.'
        });
        return;
    }

    document.getElementById('motivoRechazoTextarea').value = '';
    const modal = new bootstrap.Modal(document.getElementById('modalRechazo'));
    modal.show();
}

document.getElementById('formRechazo').addEventListener('submit', function (event) {
    event.preventDefault();

    const motivo = document.getElementById('motivoRechazoTextarea').value.trim();

    if (motivo === '') {
        Swal.fire({
            icon: 'warning',
            title: 'Campo vacío',
            text: 'Por favor, escriba el motivo del rechazo.'
        });
        return;
    }

    Swal.fire({
        title: '¿Deseas rechazar la M.R?',
        text: "Esta acción registrará el rechazo de manera permanente.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, rechazar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
           
                var documentos = [];
                        $(".material-item").each(function() {
                            var documento = {
                               'DESCRIPCION': $(this).find("input[name='DESCRIPCION']").val(),
                                'CANTIDAD': $(this).find("input[name='CANTIDAD']").val(),
                                'UNIDAD_MEDIDA': $(this).find("input[name='UNIDAD_MEDIDA']").val(),
                                'CHECK_VO': $(this).find("select[name='CHECK_VO']").val(),
                                'CATEGORIA_MATERIAL': $(this).find("select[name='CATEGORIA_MATERIAL']").val(),
                                'CHECK_MATERIAL': $(this).find("select[name='CHECK_MATERIAL']").val()

                            };
                            documentos.push(documento);
                });
            
            var materialesJson = JSON.stringify(documentos);



            if (typeof ID_FORMULARIO_MR !== 'undefined' && ID_FORMULARIO_MR > 0) {
                $.ajax({
                    url: '/rechazar',
                    method: 'POST',
                    data: {
                        id: ID_FORMULARIO_MR,
                        motivo: motivo,
                        prioridad: $('#PRIORIDAD_MR').val(),
                        observaciones: $('#OBSERVACIONES_MR').val(),
                        fecha_visto: $('#FECHA_VISTO_MR').val(),
                        visto_bueno: $('#VISTO_BUENO').val(),
                        materiales_json: materialesJson,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Rechazo registrado',
                                text: response.message
                            });

                            bootstrap.Modal.getInstance(document.getElementById('modalRechazo')).hide();
                            $('#miModal_MR').modal('hide');
                            $('#Tablarequisicion').DataTable().ajax.reload(null, false);
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudo registrar el rechazo.'
                        });
                    }
                });
            }
        }
    });
});


// Limpiar el formulario del modal de rechazo al cerrarse
document.getElementById('modalRechazo').addEventListener('hidden.bs.modal', function () {
    document.getElementById('formRechazo').reset();
});

