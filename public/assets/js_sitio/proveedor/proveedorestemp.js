//VARIABLES
ID_FORMULARIO_PROVEEDORTEMP = 0




const ModalArea = document.getElementById('miModal_proveedortemporal')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    
    ID_FORMULARIO_PROVEEDORTEMP = 0
    document.getElementById('formularioPROVEEDORTEMP').reset();
    $('#miModal_proveedortemporal .modal-title').html('Agregar proveedor');
   

    $(".direcciondiv").empty();




    document.getElementById('DOCUMENTO_CONTRATO').style.display = 'none';

 const fechaFin = document.getElementById('FECHAF_CONTRATO');
    fechaFin.disabled = false;

})




document.addEventListener('DOMContentLoaded', function () {
    const contratoSi = document.getElementById('contratosi');
    const contratoNo = document.getElementById('contratono');
    const documentoContrato = document.getElementById('DOCUMENTO_CONTRATO');

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



$("#guardarPROVEEDORTEMP").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario3($('#formularioPROVEEDORTEMP'))

    if (formularioValido) {


           var direcciones = [];

            $(".generardireccion").each(function () {
                const tipoSeleccionado = $(this).find("select.tipoDomicilioSelect").val()?.trim();

                if (tipoSeleccionado === "nacional") {
                    var direccion = {
                        'TIPODEDOMICILIOFISCAL': 'nacional',

                        'TIPO_DOMICILIO': $(this).find("select[name='TIPO_DOMICILIO']").val()?.trim() || '', 
                        'CODIGO_POSTAL_DOMICILIO': $(this).find("input[name='CODIGO_POSTAL_DOMICILIO']").val()?.trim() || '',
                        'TIPO_VIALIDAD_DOMICILIO': $(this).find("input[name='TIPO_VIALIDAD_DOMICILIO']").val()?.trim() || '',
                        'NOMBRE_VIALIDAD_DOMICILIO': $(this).find("input[name='NOMBRE_VIALIDAD_DOMICILIO']").val()?.trim() || '',
                        'NUMERO_EXTERIOR_DOMICILIO': $(this).find("input[name='NUMERO_EXTERIOR_DOMICILIO']").val()?.trim() || '',
                        'NUMERO_INTERIOR_DOMICILIO': $(this).find("input[name='NUMERO_INTERIOR_DOMICILIO']").val()?.trim() || '',
                        'NOMBRE_COLONIA_DOMICILIO': $(this).find("select[name='NOMBRE_COLONIA_DOMICILIO']").val()?.trim() || '',
                        'NOMBRE_LOCALIDAD_DOMICILIO': $(this).find("input[name='NOMBRE_LOCALIDAD_DOMICILIO']").val()?.trim() || '',
                        'NOMBRE_MUNICIPIO_DOMICILIO': $(this).find("input[name='NOMBRE_MUNICIPIO_DOMICILIO']").val()?.trim() || '',
                        'NOMBRE_ENTIDAD_DOMICILIO': $(this).find("input[name='NOMBRE_ENTIDAD_DOMICILIO']").val()?.trim() || '',
                        'PAIS_CONTRATACION_DOMICILIO': $(this).find("input[name='PAIS_CONTRATACION_DOMICILIO']").val()?.trim() || '',
                        'ENTRE_CALLE_DOMICILIO': $(this).find("input[name='ENTRE_CALLE_DOMICILIO']").val()?.trim() || '',
                        'ENTRE_CALLE_2_DOMICILIO': $(this).find("input[name='ENTRE_CALLE_2_DOMICILIO']").val()?.trim() || '',

                        'DOMICILIO_EXTRANJERO': '',
                        'CP_EXTRANJERO': '',
                        'CIUDAD_EXTRANJERO': '',
                        'ESTADO_EXTRANJERO': '',
                        'PAIS_EXTRANJERO': ''
                    };
                    direcciones.push(direccion);

                } else if (tipoSeleccionado === "extranjero") {
                    var direccion = {
                        'TIPODEDOMICILIOFISCAL': 'extranjero',

                        'TIPO_DOMICILIO': '',
                        'CODIGO_POSTAL_DOMICILIO': '',
                        'TIPO_VIALIDAD_DOMICILIO': '',
                        'NOMBRE_VIALIDAD_DOMICILIO': '',
                        'NUMERO_EXTERIOR_DOMICILIO': '',
                        'NUMERO_INTERIOR_DOMICILIO': '',
                        'NOMBRE_COLONIA_DOMICILIO': '',
                        'NOMBRE_LOCALIDAD_DOMICILIO': '',
                        'NOMBRE_MUNICIPIO_DOMICILIO': '',
                        'NOMBRE_ENTIDAD_DOMICILIO': '',
                        'PAIS_CONTRATACION_DOMICILIO': '',
                        'ENTRE_CALLE_DOMICILIO': '',
                        'ENTRE_CALLE_2_DOMICILIO': '',

                        'DOMICILIO_EXTRANJERO': $(this).find("input[name='DOMICILIO_EXTRANJERO']").val()?.trim() || '',
                        'CP_EXTRANJERO': $(this).find("input[name='CP_EXTRANJERO']").val()?.trim() || '',
                        'CIUDAD_EXTRANJERO': $(this).find("input[name='CIUDAD_EXTRANJERO']").val()?.trim() || '',
                        'ESTADO_EXTRANJERO': $(this).find("input[name='ESTADO_EXTRANJERO']").val()?.trim() || '',
                        'PAIS_EXTRANJERO': $(this).find("input[name='PAIS_EXTRANJERO']").val()?.trim() || ''
                    };
                    direcciones.push(direccion);
                }
            });
        
         const requestData = {
                api: 2,
                ID_FORMULARIO_PROVEEDORTEMP: ID_FORMULARIO_PROVEEDORTEMP,
                DIRECCIONES_JSON: direcciones.length ? JSON.stringify(direcciones) : "[]"
            };
        

    if (ID_FORMULARIO_PROVEEDORTEMP == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarPROVEEDORTEMP')
            await ajaxAwaitFormData(requestData, 'TempSave', 'formularioPROVEEDORTEMP', 'guardarPROVEEDORTEMP', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                    ID_FORMULARIO_PROVEEDORTEMP = data.temporal.ID_FORMULARIO_PROVEEDORTEMP
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_proveedortemporal').modal('hide')
                    document.getElementById('formularioPROVEEDORTEMP').reset();
                    Tablaproveedortemporal.ajax.reload()

           
                
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarPROVEEDORTEMP')
            await ajaxAwaitFormData(requestData, 'TempSave', 'formularioPROVEEDORTEMP', 'guardarPROVEEDORTEMP', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_FORMULARIO_PROVEEDORTEMP = data.temporal.ID_FORMULARIO_PROVEEDORTEMP
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_proveedortemporal').modal('hide')
                    document.getElementById('formularioPROVEEDORTEMP').reset();
                    Tablaproveedortemporal.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});



var Tablaproveedortemporal = $("#Tablaproveedortemporal").DataTable({
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
        url: '/Tablaproveedortemporal',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablaproveedortemporal.columns.adjust().draw();
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
        { data: 'RFC_PROVEEDORTEMP' },
        { data: 'RAZON_PROVEEDORTEMP' },
        { data: 'NOMBRE_PROVEEDORTEMP' },        
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        {
            data: 'BTN_DOCUMENTO',
            className: 'text-center',
            render: function (data, type, row) {
                return row.DOCUMENTO_SOPORTE ? data : 'N/A';
            }
        },
        { data: 'FECHA_CONTRATO' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'R.F.C', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Razón social', className: 'all text-center nombre-column' },
        { targets: 3, title: 'Nombre comercial', className: 'all text-center nombre-column' },
        { targets: 4, title: 'Editar', className: 'all text-center' },
        { targets: 5, title: 'Visualizar', className: 'all text-center' },
        { targets: 6, title: 'Contrato', className: 'all text-center' },
        { targets: 7, title: 'Fecha contrato', className: 'all text-center' },
        { targets: 8, title: 'Activo', className: 'all text-center' }
    ],
     infoCallback: function (settings, start, end, max, total, pre) {
        return `Total de ${total} registros`;
    },
});


$('#Tablaproveedortemporal').on('click', '.ver-archivo-requierecontrato', function () {
    var tr = $(this).closest('tr');
    var row = Tablaproveedortemporal.row(tr).data();
    var id = $(this).data('id');

    // Verifica que el campo del archivo exista
    if (!id || !row.DOCUMENTO_SOPORTE || row.DOCUMENTO_SOPORTE.trim() === "") {
        Swal.fire({
            icon: 'warning',
            title: 'Sin documento',
            text: 'Este registro no tiene documento.',
        });
        return;
    }

    var url = '/mostrarequierecontrato/' + id;
    window.open(url, '_blank');
});




$('#Tablaproveedortemporal tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablaproveedortemporal.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_FORMULARIO_PROVEEDORTEMP: row.data().ID_FORMULARIO_PROVEEDORTEMP
    };

    eliminarDatoTabla(data, [Tablaproveedortemporal], 'TempDelete');
});



$('#Tablaproveedortemporal tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablaproveedortemporal.row(tr);
    ID_FORMULARIO_PROVEEDORTEMP = row.data().ID_FORMULARIO_PROVEEDORTEMP;


     $(".direcciondiv").empty();
    obtenerDirecciones(row);


    editarDatoTabla(row.data(), 'formularioPROVEEDORTEMP', 'miModal_proveedortemporal',1);
    $('#miModal_proveedortemporal .modal-title').html(row.data().RAZON_PROVEEDORTEMP);

    if (row.data().REQUIERE_CONTRATO == 1) {
        $('#DOCUMENTO_CONTRATO').show();
        $('#contratosi').prop('checked', true);
    } else {
        $('#DOCUMENTO_CONTRATO').hide();
        $('#contratono').prop('checked', true);
    }


    if (row.data().INDETERMINADO_CONTRATO == 1) {
        $('#indeterminadosi').prop('checked', true);
        $('#FECHAF_CONTRATO').prop('disabled', true).val('');
    } else if (row.data().INDETERMINADO_CONTRATO == 2) {
        $('#indeterminadono').prop('checked', true);
        $('#FECHAF_CONTRATO').prop('disabled', false);
    } else {
        $('#FECHAF_CONTRATO').prop('disabled', false);
    }


});



$(document).ready(function() {
    $('#Tablaproveedortemporal tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablaproveedortemporal.row(tr);
        
        hacerSoloLectura2(row.data(), '#miModal_proveedortemporal');

        ID_FORMULARIO_PROVEEDORTEMP = row.data().ID_FORMULARIO_PROVEEDORTEMP;

        $(".direcciondiv").empty();
        obtenerDirecciones(row);
            
        editarDatoTabla(row.data(), 'formularioPROVEEDORTEMP', 'miModal_proveedortemporal', 1);
        $('#miModal_proveedortemporal .modal-title').html(row.data().RAZON_PROVEEDORTEMP);
            

        if (row.data().REQUIERE_CONTRATO == 1) {
            $('#DOCUMENTO_CONTRATO').show();
            $('#contratosi').prop('checked', true);
        } else {
            $('#DOCUMENTO_CONTRATO').hide();
            $('#contratono').prop('checked', true);
        }

        if (row.data().INDETERMINADO_CONTRATO == 1) {
            $('#indeterminadosi').prop('checked', true);
            $('#FECHAF_CONTRATO').prop('disabled', true).val('');
        } else if (row.data().INDETERMINADO_CONTRATO == 2) {
            $('#indeterminadono').prop('checked', true);
            $('#FECHAF_CONTRATO').prop('disabled', false);
        } else {
            $('#FECHAF_CONTRATO').prop('disabled', false);
        }
        
    });

    $('#miModal_proveedortemporal').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_proveedortemporal');
    });
});



document.addEventListener("input", function (event) {
    if (event.target.matches("input[name='CODIGO_POSTAL_DOMICILIO']")) {
        let codigoPostalInput = event.target;
        let codigoPostal = codigoPostalInput.value.trim();

        if (codigoPostal.length === 5) {
            fetch(`/codigo-postal/${codigoPostal}`)
                .then(response => response.json())
                .then(data => {
                    if (!data.error) {
                        let response = data.response;
                        
                        let contenedor = codigoPostalInput.closest(".generardireccion");

                        let coloniaSelect = contenedor.querySelector("select[name='NOMBRE_COLONIA_DOMICILIO']");
                        let municipioInput = contenedor.querySelector("input[name='NOMBRE_MUNICIPIO_DOMICILIO']");
                        let entidadInput = contenedor.querySelector("input[name='NOMBRE_ENTIDAD_DOMICILIO']");

                        coloniaSelect.innerHTML = '<option value="">Seleccione una opción</option>';
                        let colonias = Array.isArray(response.asentamiento) ? response.asentamiento : [response.asentamiento];

                        colonias.forEach(colonia => {
                            let option = document.createElement("option");
                            option.value = colonia;
                            option.textContent = colonia;
                            coloniaSelect.appendChild(option);
                        });

                        municipioInput.value = response.municipio || "No disponible";
                        entidadInput.value = response.estado || "No disponible";

                    } else {
                        alert("Código postal no encontrado");
                    }
                })
                .catch(error => {
                    console.error("Error al obtener datos:", error);
                    alert("Hubo un error al consultar la API.");
                });
        }
    }
});


document.addEventListener("DOMContentLoaded", function () {
    const botonAgregarDomicilio = document.getElementById('botonAgregardomicilio');

    botonAgregarDomicilio.addEventListener('click', function () {
        agregarDomicilio();
    });

    function agregarDomicilio() {
        const divDomicilio = document.createElement('div');
        divDomicilio.classList.add('row', 'generardireccion', 'mb-3');

        divDomicilio.innerHTML = `
            <div class="col-12 mb-3">
                <label>Tipo de dirección *</label>
                <select class="form-select tipoDomicilioSelect" required>
                    <option value="">Seleccione una opción</option>
                    <option value="nacional">Nacional</option>
                    <option value="extranjero">Extranjero</option>
                </select>
            </div>

            <div class="col-12 contenedorNacional" style="display:none;">
                <div class="row">
                    <div class="col-3 mb-3">
                        <label>Tipo de Domicilio *</label>
                         <select class="form-select"  name="TIPO_DOMICILIO" >
                                <option value="">Seleccione una opción</option>
                                <option value="1">Fiscal</option>
                                <option value="2">Sucursal</option>
                            </select>

                    </div>
                    <div class="col-3 mb-3">
                        <label>Código Postal </label>
                        <input type="number" class="form-control" name="CODIGO_POSTAL_DOMICILIO">
                    </div>
                    <div class="col-3 mb-3">
                        <label>Tipo de Vialidad </label>
                        <input type="text" class="form-control" name="TIPO_VIALIDAD_DOMICILIO">
                    </div>
                    <div class="col-3 mb-3">
                        <label>Nombre de la Vialidad </label>
                        <input type="text" class="form-control" name="NOMBRE_VIALIDAD_DOMICILIO">
                    </div>
                    <div class="col-3 mb-3">
                        <label>Número Exterior</label>
                        <input type="text" class="form-control" name="NUMERO_EXTERIOR_DOMICILIO">
                    </div>
                    <div class="col-3 mb-3">
                        <label>Número Interior</label>
                        <input type="text" class="form-control" name="NUMERO_INTERIOR_DOMICILIO">
                    </div>
                    <div class="col-3 mb-3">
                        <label>Nombre de la colonia</label>
                        <select class="form-control" name="NOMBRE_COLONIA_DOMICILIO">
                            <option value="">Seleccione una opción</option>
                        </select>
                    </div>
                    <div class="col-3 mb-3">
                        <label>Nombre de la Localidad </label>
                        <input type="text" class="form-control" name="NOMBRE_LOCALIDAD_DOMICILIO">
                    </div>
                    <div class="col-4 mb-3">
                        <label>Nombre del municipio o demarcación territorial </label>
                        <input type="text" class="form-control" name="NOMBRE_MUNICIPIO_DOMICILIO">
                    </div>
                    <div class="col-4 mb-3">
                        <label>Nombre de la Entidad Federativa </label>
                        <input type="text" class="form-control" name="NOMBRE_ENTIDAD_DOMICILIO">
                    </div>
                    <div class="col-4 mb-3">
                        <label>País </label>
                        <input type="text" class="form-control" name="PAIS_CONTRATACION_DOMICILIO">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Entre Calle</label>
                        <input type="text" class="form-control" name="ENTRE_CALLE_DOMICILIO">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Y Calle</label>
                        <input type="text" class="form-control" name="ENTRE_CALLE_2_DOMICILIO">
                    </div>
                </div>
            </div>

            <div class="col-12 contenedorExtranjero" style="display:none;">
                <div class="row">
                    <div class="col-12 mb-3">
                        <label>Domicilio </label>
                        <input type="text" class="form-control" name="DOMICILIO_EXTRANJERO">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Código Postal </label>
                        <input type="text" class="form-control" name="CP_EXTRANJERO">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Ciudad </label>
                        <input type="text" class="form-control" name="CIUDAD_EXTRANJERO">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Estado/Departamento/Provincia *</label>
                        <input type="text" class="form-control" name="ESTADO_EXTRANJERO">
                    </div>
                    <div class="col-6 mb-3">
                        <label>País </label>
                        <input type="text" class="form-control" name="PAIS_EXTRANJERO">
                    </div>
                </div>
            </div>

            <div class="col-12 mt-4">
                <div class="form-group text-center">
                    <button type="button" class="btn btn-danger botonEliminarDomicilio">Eliminar dirección <i class="bi bi-trash-fill"></i></button>
                </div>
            </div>
        `;

        const contenedor = document.querySelector('.direcciondiv');
        contenedor.appendChild(divDomicilio);

        // Botón eliminar domicilio
        const botonEliminar = divDomicilio.querySelector('.botonEliminarDomicilio');
        botonEliminar.addEventListener('click', function () {
            contenedor.removeChild(divDomicilio);
        });

        // Cambiar tipo nacional/extranjero
        const tipoSelect = divDomicilio.querySelector('.tipoDomicilioSelect');
        const nacionalDiv = divDomicilio.querySelector('.contenedorNacional');
        const extranjeroDiv = divDomicilio.querySelector('.contenedorExtranjero');

        tipoSelect.addEventListener('change', function () {
            if (this.value === "nacional") {
                nacionalDiv.style.display = 'block';
                extranjeroDiv.style.display = 'none';
            } else if (this.value === "extranjero") {
                nacionalDiv.style.display = 'none';
                extranjeroDiv.style.display = 'block';
            } else {
                nacionalDiv.style.display = 'none';
                extranjeroDiv.style.display = 'none';
            }
        });
    }
});



function obtenerDirecciones(data) {
    let row = data.data().DIRECCIONES_JSON;
    let direcciones = JSON.parse(row);

    direcciones.forEach(direccion => {
        const tipoFiscal = direccion.TIPODEDOMICILIOFISCAL || ''; // 'nacional' o 'extranjero'
        const contenedor = document.querySelector('.direcciondiv');

        const divDomicilio = document.createElement('div');
        divDomicilio.classList.add('row', 'generardireccion', 'mb-3');

        // Opciones del select
        let tipoOptions = `
            <option value="">Seleccione una opción</option>
            <option value="nacional" ${tipoFiscal === 'nacional' ? 'selected' : ''}>Nacional</option>
            <option value="extranjero" ${tipoFiscal === 'extranjero' ? 'selected' : ''}>Extranjero</option>
        `;

        divDomicilio.innerHTML = `
            <div class="col-12 mb-3">
                <label>Tipo de dirección *</label>

                <select class="form-select tipoDomicilioSelect" required>
                    ${tipoOptions}
                </select>
            </div>

            <!-- Contenedor Nacional -->
            <div class="col-12 contenedorNacional" style="display: ${tipoFiscal === 'nacional' ? 'block' : 'none'};">
                <div class="row">
                    <div class="col-3 mb-3">
                        <label>Tipo de Domicilio </label>
                        <select class="form-select" name="TIPO_DOMICILIO">
                                <option value="">Seleccione una opción</option>
                                <option value="1" ${direccion.TIPO_DOMICILIO == "1" ? 'selected' : ''}>Fiscal</option>
                                <option value="2" ${direccion.TIPO_DOMICILIO == "2" ? 'selected' : ''}>Sucursal</option>
                            </select>                    
                 </div>
                    <div class="col-3 mb-3">
                        <label>Código Postal </label>
                        <input type="number" class="form-control codigo-postal" name="CODIGO_POSTAL_DOMICILIO" value="${direccion.CODIGO_POSTAL_DOMICILIO || ''}">
                    </div>
                    <div class="col-3 mb-3">
                        <label>Tipo de Vialidad </label>
                        <input type="text" class="form-control" name="TIPO_VIALIDAD_DOMICILIO" value="${direccion.TIPO_VIALIDAD_DOMICILIO || ''}">
                    </div>
                    <div class="col-3 mb-3">
                        <label>Nombre de la Vialidad </label>
                        <input type="text" class="form-control" name="NOMBRE_VIALIDAD_DOMICILIO" value="${direccion.NOMBRE_VIALIDAD_DOMICILIO || ''}">
                    </div>
                    <div class="col-3 mb-3">
                        <label>Número Exterior</label>
                        <input type="text" class="form-control" name="NUMERO_EXTERIOR_DOMICILIO" value="${direccion.NUMERO_EXTERIOR_DOMICILIO || ''}">
                    </div>
                    <div class="col-3 mb-3">
                        <label>Número Interior</label>
                        <input type="text" class="form-control" name="NUMERO_INTERIOR_DOMICILIO" value="${direccion.NUMERO_INTERIOR_DOMICILIO || ''}">
                    </div>
                    <div class="col-3 mb-3">
                        <label>Nombre de la colonia</label>
                        <select class="form-control nombre-colonia" name="NOMBRE_COLONIA_DOMICILIO">
                            <option value="">Seleccione una opción</option>
                        </select>
                    </div>
                    <div class="col-3 mb-3">
                        <label>Nombre de la Localidad *</label>
                        <input type="text" class="form-control" name="NOMBRE_LOCALIDAD_DOMICILIO" value="${direccion.NOMBRE_LOCALIDAD_DOMICILIO || ''}">
                    </div>
                    <div class="col-4 mb-3">
                        <label>Nombre del municipio o demarcación territorial *</label>
                        <input type="text" class="form-control" name="NOMBRE_MUNICIPIO_DOMICILIO" value="${direccion.NOMBRE_MUNICIPIO_DOMICILIO || ''}">
                    </div>
                    <div class="col-4 mb-3">
                        <label>Nombre de la Entidad Federativa *</label>
                        <input type="text" class="form-control" name="NOMBRE_ENTIDAD_DOMICILIO" value="${direccion.NOMBRE_ENTIDAD_DOMICILIO || ''}">
                    </div>
                    <div class="col-4 mb-3">
                        <label>País </label>
                        <input type="text" class="form-control" name="PAIS_CONTRATACION_DOMICILIO" value="${direccion.PAIS_CONTRATACION_DOMICILIO || ''}">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Entre Calle</label>
                        <input type="text" class="form-control" name="ENTRE_CALLE_DOMICILIO" value="${direccion.ENTRE_CALLE_DOMICILIO || ''}">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Y Calle</label>
                        <input type="text" class="form-control" name="ENTRE_CALLE_2_DOMICILIO" value="${direccion.ENTRE_CALLE_2_DOMICILIO || ''}">
                    </div>
                </div>
            </div>

            <!-- Contenedor Extranjero -->
            <div class="col-12 contenedorExtranjero" style="display: ${tipoFiscal === 'extranjero' ? 'block' : 'none'};">
                <div class="row">
                    <div class="col-12 mb-3">
                        <label>Domicilio </label>
                        <input type="text" class="form-control" name="DOMICILIO_EXTRANJERO" value="${direccion.DOMICILIO_EXTRANJERO || ''}">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Código Postal </label>
                        <input type="text" class="form-control" name="CP_EXTRANJERO" value="${direccion.CP_EXTRANJERO || ''}">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Ciudad </label>
                        <input type="text" class="form-control" name="CIUDAD_EXTRANJERO" value="${direccion.CIUDAD_EXTRANJERO || ''}">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Estado/Departamento/Provincia *</label>
                        <input type="text" class="form-control" name="ESTADO_EXTRANJERO" value="${direccion.ESTADO_EXTRANJERO || ''}">
                    </div>
                    <div class="col-6 mb-3">
                        <label>País </label>
                        <input type="text" class="form-control" name="PAIS_EXTRANJERO" value="${direccion.PAIS_EXTRANJERO || ''}">
                    </div>
                </div>
            </div>

            <div class="col-12 mt-4">
                <div class="form-group text-center">
                    <button type="button" class="btn btn-danger botonEliminarDomicilio">Eliminar dirección <i class="bi bi-trash-fill"></i></button>
                </div>
            </div>
        `;

        contenedor.appendChild(divDomicilio);

        if (tipoFiscal === 'nacional' && direccion.CODIGO_POSTAL_DOMICILIO) {
            fetch(`/codigo-postal/${direccion.CODIGO_POSTAL_DOMICILIO}`)
                .then(response => response.json())
                .then(data => {
                    if (!data.error) {
                        let response = data.response;
                        let coloniaSelect = divDomicilio.querySelector(".nombre-colonia");
                        coloniaSelect.innerHTML = '<option value="">Seleccione una opción</option>';

                        let colonias = Array.isArray(response.asentamiento) ? response.asentamiento : [response.asentamiento];
                        colonias.forEach(colonia => {
                            let option = document.createElement("option");
                            option.value = colonia;
                            option.textContent = colonia;
                            coloniaSelect.appendChild(option);
                        });

                        coloniaSelect.value = direccion.NOMBRE_COLONIA_DOMICILIO || '';
                    }
                })
                .catch(error => {
                    console.error("Error al obtener datos del código postal:", error);
                });
        }

        divDomicilio.querySelector('.botonEliminarDomicilio').addEventListener('click', function () {
            contenedor.removeChild(divDomicilio);
        });

        const selectTipo = divDomicilio.querySelector('.tipoDomicilioSelect');
        const nacionalDiv = divDomicilio.querySelector('.contenedorNacional');
        const extranjeroDiv = divDomicilio.querySelector('.contenedorExtranjero');

        selectTipo.addEventListener('change', function () {
            if (this.value === "nacional") {
                nacionalDiv.style.display = 'block';
                extranjeroDiv.style.display = 'none';
            } else if (this.value === "extranjero") {
                nacionalDiv.style.display = 'none';
                extranjeroDiv.style.display = 'block';
            } else {
                nacionalDiv.style.display = 'none';
                extranjeroDiv.style.display = 'none';
            }
        });
    });
}



$(document).ready(function() {
    $('input[name="INDETERMINADO_CONTRATO"]').on('change', function() {
        if ($(this).val() === '1') { 
            $('#FECHAF_CONTRATO').prop('disabled', true).val('');
        } else {
            $('#FECHAF_CONTRATO').prop('disabled', false);
        }
    });
});