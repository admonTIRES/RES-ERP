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
    
    document.querySelector('.materialesdiv').innerHTML = '';
    contadorMateriales = 1;

     const inputFecha = document.getElementById("FECHA_APRUEBA_SOLICITUD");
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


            };
            documentos.push(documento);
        });

        const requestData = {
            api: 4,
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
            await ajaxAwaitFormData(requestData,'RecempleadoSave', 'formularioRECURSOSEMPLEADO', 'guardaRECEMPLEADOS', { callbackAfter: true, callbackBefore: true }, () => {

        
               

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
                    Tablaaprobacionalmacen.ajax.reload()

        
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardaRECEMPLEADOS')
            await ajaxAwaitFormData(requestData,'RecempleadoSave', 'formularioRECURSOSEMPLEADO', 'guardaRECEMPLEADOS', { callbackAfter: true, callbackBefore: true }, () => {
        
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
                    Tablaaprobacionalmacen.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});


var Tablaaprobacionalmacen = $("#Tablaaprobacionalmacen").DataTable({
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
        url: '/Tablaaprobacionalmacen',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablaaprobacionalmacen.columns.adjust().draw();
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
    { data: 'TIPO_SOLICITUD_TEXTO' },
    { data: 'SOLICITANTE_SALIDA' },    
    { data: 'FECHA_SALIDA' },    
    { data: 'ESTADO_REVISION' }, 
    { data: 'ESTATUS' },          
    { data: 'BTN_EDITAR' },
    { data: 'BTN_VISUALIZAR' },

],

columnDefs: [
    { targets: 0, title: '#', className: 'all text-center' },
    { targets: 1, title: 'Tipo de solicitud', className: 'all text-center' },
    { targets: 2, title: 'Nombre del solicitante', className: 'all text-center' }, 
    { targets: 3, title: 'Fecha de solicitud', className: 'all text-center' },
    { targets: 4, title: 'Vo. Bo ', className: 'all text-center' },
    { targets: 5, title: 'Estatus', className: 'all text-center' }, 
    { targets: 6, title: 'Editar', className: 'all text-center' },
    { targets: 7, title: 'Visualizar', className: 'all text-center' },

]

});




$(document).ready(function() {
    $('#Tablaaprobacionalmacen tbody').on('click', 'td>button.VISUALIZAR', function () {


        var tr = $(this).closest('tr');
        var row = Tablaaprobacionalmacen.row(tr);
    
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

    


    });

    $('#miModal_RECURSOSEMPLEADOS').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_RECURSOSEMPLEADOS');
    });
});




$('#Tablaaprobacionalmacen tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablaaprobacionalmacen.row(tr);
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

    
     const hoy = new Date();
    const yyyy = hoy.getFullYear();
    const mm = String(hoy.getMonth() + 1).padStart(2, '0');
    const dd = String(hoy.getDate()).padStart(2, '0');
    const fechaHoy = `${yyyy}-${mm}-${dd}`;

    $("#FECHA_APRUEBA_SOLICITUD").val(fechaHoy);

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

//             divMaterial.innerHTML = `
//                 <div class="row p-3 rounded">

                 
//                     <div class="col-1 mt-2">
//                         <label class="form-label">N°</label>
//                         <input type="text" class="form-control" name="NUMERO_ORDEN" value="${contadorMateriales}" readonly>
//                     </div>
//                     <div class="col-5 mt-2">
//                         <label class="form-label">Descripción</label>
//                         <input type="text" class="form-control" name="DESCRIPCION" value="${escapeHtml(material.DESCRIPCION)}" required>
//                     </div>
//                     <div class="col-1 mt-2">
//                         <label class="form-label">Cantidad</label>
//                         <input type="number" class="form-control" name="CANTIDAD" value="${material.CANTIDAD}" required>
//                     </div>
//                      <div class="col-3 mt-2">
//                         <label class="form-label">¿El material y/o equipo retorna? *</label>
//                         <select class="form-control" name="RETORNA_EQUIPO" required>
//                             <option value="0" disabled>Seleccione una opción</option>
//                             <option value="1" ${material.RETORNA_EQUIPO === "1" ? "selected" : ""}>Sí</option>
//                             <option value="2" ${material.RETORNA_EQUIPO === "2" ? "selected" : ""}>No</option>
//                         </select>
//                     </div>

//                         <div class="col-2 mt-3">
//                             <br>
//                             <button type="button" class="btn btn-danger botonEliminarMaterial" title="Eliminar">
//                                 <i class="bi bi-trash"></i>
//                             </button>
//                         </div>
                    
//                 </div>
//             `;

//             contenedorMateriales.appendChild(divMaterial);
//             contadorMateriales++;

//             const botonEliminar = divMaterial.querySelector('.botonEliminarMaterial');
//             botonEliminar.addEventListener('click', function () {
//                 contenedorMateriales.removeChild(divMaterial);
//                 actualizarNumerosOrden();
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

        materiales.forEach(material => {
            const divMaterial = document.createElement('div');
            divMaterial.classList.add('material-item', 'mt-2');

            divMaterial.innerHTML = `
                <div class="row p-3 rounded">
                    <div class="col-1 mt-2">
                        <label class="form-label">N°</label>
                        <input type="text" class="form-control" name="NUMERO_ORDEN" value="${contadorMateriales}" readonly>
                    </div>
                    <div class="col-5 mt-2">
                        <label class="form-label">Descripción</label>
                        <input type="text" class="form-control" name="DESCRIPCION" value="${escapeHtml(material.DESCRIPCION)}" required>
                    </div>
                    <div class="col-1 mt-2">
                        <label class="form-label">Cantidad</label>
                        <input type="number" class="form-control" name="CANTIDAD" value="${material.CANTIDAD}" required>
                    </div>
                    <div class="col-3 mt-2">
                        <label class="form-label">¿El material o equipo retorna?*</label>
                        <select class="form-control retorna_material" name="RETORNA_EQUIPO" required>
                            <option value="0" disabled>Seleccione una opción</option>
                            <option value="1" ${material.RETORNA_EQUIPO === "1" ? "selected" : ""}>Sí</option>
                            <option value="2" ${material.RETORNA_EQUIPO === "2" ? "selected" : ""}>No</option>
                        </select>
                    </div>
                    <div class="col-2 mt-3">
                        <br>
                        <button type="button" class="btn btn-danger botonEliminarMaterial" title="Eliminar">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            `;

            contenedorMateriales.appendChild(divMaterial);
            contadorMateriales++;

            // Evento eliminar
            const botonEliminar = divMaterial.querySelector('.botonEliminarMaterial');
            botonEliminar.addEventListener('click', function () {
                contenedorMateriales.removeChild(divMaterial);
                actualizarNumerosOrden();
                revisarSelects(); 
            });

            const selectRetorna = divMaterial.querySelector('.retorna_material');
            selectRetorna.addEventListener('change', function () {
                revisarSelects();
            });
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
    const radios = document.querySelectorAll('input[name="MATERIAL_RETORNA_SALIDA"]');
    const fechaDiv = document.getElementById("FECHA_ESTIMADA");
    const fechaInput = document.getElementById("FECHA_ESTIMADA_SALIDA");

    radios.forEach(radio => {
        radio.addEventListener("change", function () {
            if (this.value === "Sí") {
                fechaDiv.style.display = "inline-flex"; 
                fechaInput.setAttribute("required", "required");
            } else {
                fechaDiv.style.display = "none"; 
                fechaInput.removeAttribute("required");
                fechaInput.value = "";
            }
        });
    });
});




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
    const selectConcepto = document.getElementById("CONCEPTO_PERMISO");
    const divExplique = document.getElementById("EXPLIQUE_PERMISO");

    selectConcepto.addEventListener("change", function () {
        if (this.value === "9") {
            divExplique.style.display = "block";
            divExplique.querySelector("textarea").setAttribute("required", "required");
        } else {
            divExplique.style.display = "none";
            const textarea = divExplique.querySelector("textarea");
            textarea.value = "";
            textarea.removeAttribute("required");
        }
    });
});




// document.addEventListener("DOMContentLoaded", function () {
//     const btnFirmar = document.getElementById("FIRMAR_SOLICITUD_APROBACION");
//     const inputFirmo = document.getElementById("FIRMO_APROBACION");
//     const inputFirmadoPor = document.getElementById("QUIEN_APROBACION");
//     const inputFechaSalida = document.getElementById("FECHA_APRUEBA_SOLICITUD");

//     btnFirmar.addEventListener("click", function () {
//         let usuarioNombre = btnFirmar.getAttribute("data-usuario");
//         let fechaSalida = inputFechaSalida.value; // yyyy-mm-dd

//         // Obtener hora actual
//         let ahora = new Date();
//         let horas = ahora.getHours();
//         let minutos = String(ahora.getMinutes()).padStart(2, "0");
//         let segundos = String(ahora.getSeconds()).padStart(2, "0");

//         // Determinar AM o PM
//         let ampm = horas >= 12 ? "p.m." : "a.m.";

//         // Convertir a formato de 12 horas
//         horas = horas % 12;
//         horas = horas ? horas : 12; // El 0 se convierte en 12

//         let horaCompleta = horas + ":" + minutos + ":" + segundos + " " + ampm;

//         // Asignar valores
//         inputFirmo.value = "1";
//         inputFirmadoPor.value =  usuarioNombre + " el " + fechaSalida ;
//     });
// });


document.addEventListener("DOMContentLoaded", function () {
    const btnFirmar = document.getElementById("FIRMAR_SOLICITUD_APROBACION");
    const inputFirmo = document.getElementById("FIRMO_APROBACION");
    const inputFirmadoPor = document.getElementById("QUIEN_APROBACION");
    const inputFechaSalida = document.getElementById("FECHA_APRUEBA_SOLICITUD");

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


document.addEventListener("DOMContentLoaded", function () {
    const concepto = document.getElementById("CONCEPTO_PERMISO");
    const inputDias = document.getElementById("NODIAS_PERMISO");
    const inputHoras = document.getElementById("NOHORAS_PERMISO");

    concepto.addEventListener("change", function () {
        if (this.value === "6") { 
            inputDias.value = 84;
            inputHoras.value = "";
            inputHoras.disabled = true;
        } else if (this.value === "7") { 
            inputDias.value = 5;
            inputHoras.value = "";
            inputHoras.disabled = true;
        } else {
            inputDias.value = "";
            inputHoras.value = "";
            inputHoras.disabled = false;
        }
    });

    inputDias.addEventListener("input", function () {
        if (this.value && parseInt(this.value) > 0) {
            inputHoras.value = "";
            inputHoras.disabled = true;
        } else {
            inputHoras.disabled = false;
        }
    });

    // Bloquear días si se escribe horas
    inputHoras.addEventListener("input", function () {
        if (this.value && parseInt(this.value) > 0) {
            inputDias.value = "";
            inputDias.disabled = true;
        } else {
            inputDias.disabled = false;
        }
    });
});




document.addEventListener("DOMContentLoaded", function () {
    const selectEstado = document.getElementById("ESTADO_APROBACION");
    const motivoDiv = document.getElementById("motivo-rechazo-container");

    if (selectEstado) {
        selectEstado.addEventListener("change", function () {
            if (this.value === "Rechazada") {
                motivoDiv.style.display = "block";
            } else {
                motivoDiv.style.display = "none";
            }
        });
    }
});
