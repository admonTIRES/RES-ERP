//VARIABLES
ID_FORMULARIO_MR = 0




const Modalmr = document.getElementById('miModal_MR');
Modalmr.addEventListener('hidden.bs.modal', event => {
    ID_FORMULARIO_MR = 0;
    document.getElementById('formularioMR').reset();

    
        document.getElementById('DAR_BUENO').value = "0"; 


        $('#MOTIVO_RECHAZO_JEFE_DIV').hide();
   
    $('#motivo-rechazo-container').hide();


    document.querySelector('.materialesdiv').innerHTML = '';
    contadorMateriales = 1;

    cambiarColor();     
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
                'CHECK_VO': $(this).find("select[name='CHECK_VO']").val(),
                'CATEGORIA_MATERIAL': $(this).find("select[name='CATEGORIA_MATERIAL']").val(),
                'CHECK_MATERIAL': $(this).find("select[name='CHECK_MATERIAL']").val()

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
                    Tablarequsicionaprobada.ajax.reload()

        
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea guardar la información de este formulario?",
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
                    Tablarequsicionaprobada.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});



var Tablarequsicionaprobada = $("#Tablarequsicionaprobada").DataTable({
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
        url: '/Tablarequsicionaprobada',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablarequsicionaprobada.columns.adjust().draw();
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




$('#Tablarequsicionaprobada tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablarequsicionaprobada.row(tr);
    ID_FORMULARIO_MR = row.data().ID_FORMULARIO_MR;


    cargarMaterialesDesdeJSON(row.data().MATERIALES_JSON);

    editarDatoTabla(row.data(), 'formularioMR', 'miModal_MR', 1);
    

    if (row.data().DAR_BUENO === "2") {
        $('#MOTIVO_RECHAZO_JEFE_DIV').show();  
    } else {
    }

    if (row.data().ESTADO_APROBACION === "Rechazada") {
        $('#motivo-rechazo-container').show();
    } else {
    }


    var nombreAutenticado = $('meta[name="usuario-autenticado"]').attr('content');
    if (!row.data().QUIEN_APROBACION) {
        $('#QUIEN_APROBACION').val(nombreAutenticado);
    } else {
        $('#QUIEN_APROBACION').val(row.data().QUIEN_APROBACION);
    }



    if (row.data().DAR_BUENO === "1") {
        $('#VISTO_BUENO_JEFE').show();
        $('#APROBACION_DIRECCION').show();
        $('#MOTIVO_RECHAZO_JEFE_DIV').hide();
        $('#BOTON_VISTO_BUENO').hide();
    
    } else if (row.data().DAR_BUENO === "2") {
        $('#VISTO_BUENO_JEFE').show();
        $('#MOTIVO_RECHAZO_JEFE_DIV').show();
        $('#APROBACION_DIRECCION').show();
          
     } else {
        $('#VISTO_BUENO_JEFE').hide();
        $('#MOTIVO_RECHAZO_JEFE_DIV').hide();
        $('#APROBACION_DIRECCION').hide();
    }

    const hoy = new Date();
    const yyyy = hoy.getFullYear();
    const mm = String(hoy.getMonth() + 1).padStart(2, '0');
    const dd = String(hoy.getDate()).padStart(2, '0');
    const fechaHoy = `${yyyy}-${mm}-${dd}`;

    $("#FECHA_APRUEBA_MR").val(fechaHoy);




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
//                         <select class="form-select" name="CHECK_MATERIAL" required >
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
//                         <input type="text" class="form-control" name="UNIDAD_MEDIDA" value="${material.UNIDAD_MEDIDA}" >
//                     </div>
//                     <div class="col-2">
//                         <label class="form-label">Línea de Negocios</label>
//                         <select class="form-select" name="CATEGORIA_MATERIAL" >
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
//                         <select class="form-select check-vo-select" name="CHECK_VO" disabled>
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

        const filtroCheckMaterialDiv = document.createElement('div');
        filtroCheckMaterialDiv.classList.add('row', 'mb-3', 'justify-content-center');

        filtroCheckMaterialDiv.innerHTML = `
            <div class="col-2">
                <label class="form-label fw-bold">Aplicar Aprobado a todos</label>
                <select class="form-select" id="filtroCheckMaterial">
                    <option value=""></option>
                    <option value="SI">Sí</option>
                    <option value="NO">No</option>
                </select>
            </div>
        `;

        contenedorMateriales.appendChild(filtroCheckMaterialDiv);

        const filtroCheckMaterial = filtroCheckMaterialDiv.querySelector('#filtroCheckMaterial');
        filtroCheckMaterial.addEventListener('change', function () {
            const valorSeleccionado = this.value;
            const selectsAprobado = contenedorMateriales.querySelectorAll('select[name="CHECK_MATERIAL"]');
            selectsAprobado.forEach(select => {
                select.value = valorSeleccionado;
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
                        <select class="form-select" name="CHECK_MATERIAL" required>
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
                        <input type="text" class="form-control" name="UNIDAD_MEDIDA" value="${material.UNIDAD_MEDIDA}">
                    </div>
                    <div class="col-2">
                        <label class="form-label">Línea de Negocios</label>
                        <select class="form-select" name="CATEGORIA_MATERIAL">
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
                        <select class="form-select check-vo-select" name="CHECK_VO" disabled>
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
        text: "Esta acción enviará la solicitud.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, enviar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            if (typeof ID_FORMULARIO_MR !== 'undefined' && ID_FORMULARIO_MR > 0) {
                $.ajax({
                    url: '/darVistoBueno',
                    method: 'POST',
                    data: {
                        id: ID_FORMULARIO_MR,
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
                            $('#Tablarequsicionaprobada').DataTable().ajax.reload(null, false);
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error al guardar el visto bueno.'
                        });
                    }
                });
            }
        }
    });
}






function rechazarVistoBueno() {
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
            if (typeof ID_FORMULARIO_MR !== 'undefined' && ID_FORMULARIO_MR > 0) {
                $.ajax({
                    url: '/rechazar',
                    method: 'POST',
                    data: {
                        id: ID_FORMULARIO_MR,
                        motivo: motivo,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Rechazar M.R',
                                text: response.message
                            });

                            bootstrap.Modal.getInstance(document.getElementById('modalRechazo')).hide();
                            $('#miModal_MR').modal('hide');
                            $('#Tablarequsicionaprobada').DataTable().ajax.reload(null, false);
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
