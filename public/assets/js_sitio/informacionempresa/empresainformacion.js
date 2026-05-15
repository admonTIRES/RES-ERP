//VARIABLES GLOBALES



ID_FORMULARIO_EMPRESA = 0




$("#NUEVO_CLIENTE").click(function (e) {
    e.preventDefault();

    $('#formularioEMPRESA')[0].reset();
    $(".contactodiv").empty();
    $(".direcciondiv").empty();
    $(".sucursalesdiv").empty();

    $("#miModal_EMPRESA").modal("show");
    
    $('#SUCURSALES_DIV').hide();

    $("#tab1-info").click();

});







const ModalArea = document.getElementById('miModal_EMPRESA');

ModalArea.addEventListener('hidden.bs.modal', event => {
    ID_FORMULARIO_EMPRESA = 0;
    document.getElementById('formularioEMPRESA').reset();

    $('#miModal_EMPRESA .modal-title').html('Información empresa');

});



$("#guardarEMPRESA").click(function (e) {
    e.preventDefault();


    formularioValido = validarFormulario3($('#formularioEMPRESA'))

    
    if (formularioValido) {
    
                    var contactos = [];
                    $(".generarcontacto").each(function() {
                        var contacto = {
                            'CONTACTO_SOLICITUD': $(this).find("input[name='CONTACTO_SOLICITUD']").val()?.trim() || '',
                            'CARGO_SOLICITUD': $(this).find("input[name='CARGO_SOLICITUD']").val()?.trim() || '',
                            'TELEFONO_SOLICITUD': $(this).find("input[name='TELEFONO_SOLICITUD']").val()?.trim() || '',
                            'CELULAR_SOLICITUD': $(this).find("input[name='CELULAR_SOLICITUD']").val()?.trim() || '',
                            'CORREO_SOLICITUD': $(this).find("input[name='CORREO_SOLICITUD']").val()?.trim() || '',
                        };
                        contactos.push(contacto);
                    });

                    var direcciones = [];

            $(".generardireccion").each(function () {
                const tipoSeleccionado = $(this).find("select.tipoDomicilioSelect").val()?.trim();

                if (tipoSeleccionado === "nacional") {
                    var direccion = {
                        'TIPODEDOMICILIOFISCAL': 'nacional',

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

        
           var sucursales = [];

            $(".generarsucursal ").each(function () {
                const tipoSeleccionado = $(this).find("select.tipoDomicilioSelect").val()?.trim();

                if (tipoSeleccionado === "nacional") {
                    var sucursal = {
                        'TIPODEDOMICILIOFISCAL': 'nacional',

                        'NOMBRE_SUCURSAL': $(this).find("input[name='NOMBRE_SUCURSAL']").val()?.trim() || '',
                        'CODIGO_POSTAL_SUCURSAL': $(this).find("input[name='CODIGO_POSTAL_SUCURSAL']").val()?.trim() || '',
                        'TIPO_VIALIDAD_SUCURSAL': $(this).find("input[name='TIPO_VIALIDAD_SUCURSAL']").val()?.trim() || '',
                        'NOMBRE_VIALIDAD_SUCURSAL': $(this).find("input[name='NOMBRE_VIALIDAD_SUCURSAL']").val()?.trim() || '',
                        'NUMERO_EXTERIOR_SUCURSAL': $(this).find("input[name='NUMERO_EXTERIOR_SUCURSAL']").val()?.trim() || '',
                        'NUMERO_INTERIOR_SUCURSAL': $(this).find("input[name='NUMERO_INTERIOR_SUCURSAL']").val()?.trim() || '',
                        'NOMBRE_COLONIA_SUCURSAL': $(this).find("select[name='NOMBRE_COLONIA_SUCURSAL']").val()?.trim() || '',
                        'NOMBRE_LOCALIDAD_SUCURSAL': $(this).find("input[name='NOMBRE_LOCALIDAD_SUCURSAL']").val()?.trim() || '',
                        'NOMBRE_MUNICIPIO_SUCURSAL': $(this).find("input[name='NOMBRE_MUNICIPIO_SUCURSAL']").val()?.trim() || '',
                        'NOMBRE_ENTIDAD_SUCURSAL': $(this).find("input[name='NOMBRE_ENTIDAD_SUCURSAL']").val()?.trim() || '',
                        'PAIS_CONTRATACION_SUCURSAL': $(this).find("input[name='PAIS_CONTRATACION_SUCURSAL']").val()?.trim() || '',
                        'ENTRE_CALLE_SUCURSAL': $(this).find("input[name='ENTRE_CALLE_SUCURSAL']").val()?.trim() || '',
                        'ENTRE_CALLE_2_SUCURSAL': $(this).find("input[name='ENTRE_CALLE_2_SUCURSAL']").val()?.trim() || '',


                        'SUCURSAL_EXTRANJERO':'',
                        'DOMICILIO_EXTRANJERO': '',
                        'CP_EXTRANJERO': '',
                        'CIUDAD_EXTRANJERO': '',
                        'ESTADO_EXTRANJERO': '',
                        'PAIS_EXTRANJERO': ''
                    };
                    sucursales.push(sucursal);

                } else if (tipoSeleccionado === "extranjero") {
                    var sucursal = {
                        'TIPODEDOMICILIOFISCAL': 'extranjero',

                        'NOMBRE_SUCURSAL': '',
                        'CODIGO_POSTAL_SUCURSAL': '',
                        'TIPO_VIALIDAD_SUCURSAL': '',
                        'NOMBRE_VIALIDAD_SUCURSAL': '',
                        'NUMERO_EXTERIOR_SUCURSAL': '',
                        'NUMERO_INTERIOR_SUCURSAL': '',
                        'NOMBRE_COLONIA_SUCURSAL': '',
                        'NOMBRE_LOCALIDAD_SUCURSAL': '',
                        'NOMBRE_MUNICIPIO_SUCURSAL': '',
                        'NOMBRE_ENTIDAD_SUCURSAL': '',
                        'PAIS_CONTRATACION_SUCURSAL': '',
                        'ENTRE_CALLE_SUCURSAL': '',
                        'ENTRE_CALLE_2_SUCURSAL': '',

                        'SUCURSAL_EXTRANJERO': $(this).find("input[name='SUCURSAL_EXTRANJERO']").val()?.trim() || '',
                        'DOMICILIO_EXTRANJERO': $(this).find("input[name='DOMICILIO_EXTRANJERO']").val()?.trim() || '',
                        'CP_EXTRANJERO': $(this).find("input[name='CP_EXTRANJERO']").val()?.trim() || '',
                        'CIUDAD_EXTRANJERO': $(this).find("input[name='CIUDAD_EXTRANJERO']").val()?.trim() || '',
                        'ESTADO_EXTRANJERO': $(this).find("input[name='ESTADO_EXTRANJERO']").val()?.trim() || '',
                        'PAIS_EXTRANJERO': $(this).find("input[name='PAIS_EXTRANJERO']").val()?.trim() || ''
                    };
                    sucursales.push(sucursal);
                }
            });

        
        
        
        
            const requestData = {
                api: 1,
                ID_FORMULARIO_EMPRESA: ID_FORMULARIO_EMPRESA,
                CONTACTOS_JSON: contactos.length ? JSON.stringify(contactos) : "[]",
                DIRECCIONES_JSON: direcciones.length ? JSON.stringify(direcciones) : "[]",
                SUCURSALES_JSON: sucursales.length ? JSON.stringify(sucursales) : "[]"

            };
            

        if (ID_FORMULARIO_EMPRESA == 0) {
            alertMensajeConfirm({
                title: "¿Desea guardar la información?",
                text: "Al guardarla, se podrá usar",
                icon: "question",
            }, async function () {

                await loaderbtn('guardarEMPRESA');
                await ajaxAwaitFormData(requestData, 'InfoEmpresaSave', 'formularioEMPRESA', 'guardarEMPRESA', { callbackAfter: true, callbackBefore: true }, () => {
                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');
                    
                }, function (data) {
                    
                    ID_FORMULARIO_EMPRESA = data.cliente.ID_FORMULARIO_EMPRESA
                    alertMensaje('success', 'Información guardada correctamente', 'Esta información esta lista para usarse', null, null, 1500)
                     $('#miModal_EMPRESA').modal('hide')
                        document.getElementById('formularioEMPRESA').reset();
                        Tablainformacionempresa.ajax.reload()
    
    
                })
                
            }, 1);
            
        } else {
            alertMensajeConfirm({
                title: "¿Desea editar la información de este formulario?",
                text: "Al guardarla, se podrá usar",
                icon: "question",
            }, async function () {

                await loaderbtn('guardarEMPRESA');
                await ajaxAwaitFormData(requestData, 'InfoEmpresaSave', 'formularioEMPRESA', 'guardarEMPRESA', { callbackAfter: true, callbackBefore: true }, () => {
                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');

                }, function (data) {
                    
                    setTimeout(() => {
    
                        ID_FORMULARIO_EMPRESA = data.cliente.ID_FORMULARIO_EMPRESA
                        alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                        $('#miModal_EMPRESA').modal('hide')
                        document.getElementById('formularioEMPRESA').reset();
                        Tablainformacionempresa.ajax.reload()
    
    
                    }, 300);  
                })
            }, 1);
        }
    } else {
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000);
    }
});



var Tablainformacionempresa = $("#Tablainformacionempresa").DataTable({
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
        url: '/Tablainformacionempresa',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablainformacionempresa.columns.adjust().draw();
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
        { data: 'RFC_EMPRESA' },
        { data: 'RAZON_SOCIAL' },
        { data: 'REGIMEN_CAPITAL' },
        { data: 'NOMBRE_COMERCIAL' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'R.F.C', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Razón Social', className: 'all text-center nombre-column' },
        { targets: 3, title: 'Régimen Capital', className: 'all text-center nombre-column' },
        { targets: 4, title: 'Nombre Comercial', className: 'all text-center nombre-column' },
        { targets: 5, title: 'Editar', className: 'all text-center' },
        { targets: 6, title: 'Visualizar', className: 'all text-center' },
        { targets: 7, title: 'Activo', className: 'all text-center' }
    ]
});



$('#Tablainformacionempresa').on('click', '.ver-archivo-constancia', function () {
    var tr = $(this).closest('tr');
    var row = Tablainformacionempresa.row(tr);
    var id = $(this).data('id');

    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }

    var nombreDocumento = row.data().RAZON_SOCIAL_CLIENTE;
    var url = '/mostrarconstanciacliente/' + id;
    
    abrirModal(url, nombreDocumento);
});





$('#Tablainformacionempresa tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablainformacionempresa.row(tr);


        ID_FORMULARIO_EMPRESA = row.data().ID_FORMULARIO_EMPRESA;

    

    $(".contactodiv").empty();
    obtenerContactos(row);  

    $(".direcciondiv").empty();
    obtenerDirecciones(row);

    $(".sucursalesdiv").empty();
    obtenerSucursales(row);
    

     if (row.data().CUENTA_SUCURSALES === "1") {
        $('#SUCURSALES_DIV').show();
    } else {
        $('#SUCURSALES_DIV').hide();
    }


    editarDatoTabla(row.data(), 'formularioEMPRESA', 'miModal_EMPRESA', 1);
    $('#miModal_EMPRESA .modal-title').html(row.data().RAZON_SOCIAL_CLIENTE);


    $("#tab1-info").click();

    
});


$(document).ready(function() {
    $('#Tablainformacionempresa tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablainformacionempresa.row(tr);
        
        hacerSoloLectura2(row.data(), '#miModal_EMPRESA');

        ID_FORMULARIO_EMPRESA = row.data().ID_FORMULARIO_EMPRESA;


        $(".contactodiv").empty();
        obtenerContactos(row);  
    
        $(".direcciondiv").empty();
        obtenerDirecciones(row);

        $(".sucursalesdiv").empty();
        obtenerSucursales(row);
        


        editarDatoTabla(row.data(), 'formularioEMPRESA', 'miModal_EMPRESA',1);
        $('#miModal_EMPRESA .modal-title').html(row.data().RAZON_SOCIAL_CLIENTE);


        $("#tab1-info").click();



    });

    $('#miModal_EMPRESA').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_EMPRESA');
    });
});


$('#Tablainformacionempresa tbody').on('change', 'td>label>input.ELIMINAR', function () {
var tr = $(this).closest('tr');
var row = Tablainformacionempresa.row(tr);

var estado = $(this).is(':checked') ? 1 : 0;

data = {
    api: 1,
    ELIMINAR: estado == 0 ? 1 : 0, 
    ID_FORMULARIO_EMPRESA: row.data().ID_FORMULARIO_EMPRESA
};

eliminarDatoTabla(data, [Tablainformacionempresa], 'InfoEmpresaDelete');
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
    const botonAgregarContacto = document.getElementById('botonAgregarcontacto');

    botonAgregarContacto.addEventListener('click', function () {
        agregarContacto();
    });

    function agregarContacto() {
        const divContacto = document.createElement('div');
        divContacto.classList.add('row', 'generarcontacto', 'mb-3');

      

        divContacto.innerHTML = `
            <div class="col-12">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombre </label>
                        <input type="text" class="form-control" name="CONTACTO_SOLICITUD" >
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Cargo </label>
                        <input type="text" class="form-control" name="CARGO_SOLICITUD" >
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" class="form-control" name="TELEFONO_SOLICITUD">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Celular </label>
                        <input type="text" class="form-control" name="CELULAR_SOLICITUD" >
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Correo electrónico </label>
                        <input type="email" class="form-control" name="CORREO_SOLICITUD" >
                    </div>
                </div>
            </div>

            <div class="col-12 mt-4 text-center">
                <button type="button" class="btn btn-danger botonEliminarContacto">Eliminar representante <i class="bi bi-trash-fill"></i></button>
            </div>
        `;

        const contenedor = document.querySelector('.contactodiv');
        contenedor.appendChild(divContacto);

        divContacto.querySelector('.botonEliminarContacto').addEventListener('click', function () {
            contenedor.removeChild(divContacto);
        });
    }
});

function obtenerContactos(data) {
    let row = data.data().CONTACTOS_JSON;

    if (!row || row === "null" || row === null) {
        console.warn("No hay contactos para mostrar.");
        $(".contactodiv").empty();
        return;
    }

    let contactos = [];

    try {
        contactos = JSON.parse(row);
        if (!Array.isArray(contactos)) {
            console.warn("CONTACTOS_JSON no es un arreglo.");
            contactos = [];
        }
    } catch (e) {
        console.error("Error al parsear CONTACTOS_JSON:", e);
        contactos = [];
    }

    $(".contactodiv").empty(); 
    const contenedor = document.querySelector('.contactodiv');

    contactos.forEach(contacto => {
        const {
            CONTACTO_SOLICITUD,
            CARGO_SOLICITUD,
            TELEFONO_SOLICITUD,
            CELULAR_SOLICITUD,
            CORREO_SOLICITUD,
            
        } = contacto;

     

        const divContacto = document.createElement('div');
        divContacto.classList.add('row', 'generarcontacto', 'mb-3');

        divContacto.innerHTML = `
            <div class="col-12">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombre *</label>
                        <input type="text" class="form-control" name="CONTACTO_SOLICITUD" value="${CONTACTO_SOLICITUD}" >
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Cargo *</label>
                        <input type="text" class="form-control" name="CARGO_SOLICITUD" value="${CARGO_SOLICITUD}" >
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" class="form-control" name="TELEFONO_SOLICITUD" value="${TELEFONO_SOLICITUD || ''}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Celular *</label>
                        <input type="text" class="form-control" name="CELULAR_SOLICITUD" value="${CELULAR_SOLICITUD}" >
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Correo electrónico *</label>
                        <input type="email" class="form-control" name="CORREO_SOLICITUD" value="${CORREO_SOLICITUD}" >
                    </div>
                </div>
            </div>

            <div class="col-12 mt-4 text-center">
                <button type="button" class="btn btn-danger botonEliminarContacto">Eliminar representante  <i class="bi bi-trash-fill"></i></button>
            </div>
        `;

        contenedor.appendChild(divContacto);

        divContacto.querySelector('.botonEliminarContacto').addEventListener('click', function () {
            contenedor.removeChild(divContacto);
        });
    });
}


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
                <label>Tipo de Domicilio Fiscal *</label>
                <select class="form-select tipoDomicilioSelect" required>
                    <option value="">Seleccione una opción</option>
                    <option value="nacional">Nacional</option>
                    <option value="extranjero">Extranjero</option>
                </select>
            </div>

            <div class="col-12 contenedorNacional" style="display:none;">
                <div class="row">
                    
                    <div class="col-6 mb-3">
                        <label>Código Postal </label>
                        <input type="number" class="form-control" name="CODIGO_POSTAL_DOMICILIO">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Tipo de Vialidad </label>
                        <input type="text" class="form-control" name="TIPO_VIALIDAD_DOMICILIO">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Nombre de la Vialidad </label>
                        <input type="text" class="form-control" name="NOMBRE_VIALIDAD_DOMICILIO">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Número Exterior</label>
                        <input type="text" class="form-control" name="NUMERO_EXTERIOR_DOMICILIO">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Número Interior</label>
                        <input type="text" class="form-control" name="NUMERO_INTERIOR_DOMICILIO">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Nombre de la colonia</label>
                        <select class="form-control" name="NOMBRE_COLONIA_DOMICILIO">
                            <option value="">Seleccione una opción</option>
                        </select>
                    </div>
                    <div class="col-6 mb-3">
                        <label>Nombre de la Localidad </label>
                        <input type="text" class="form-control" name="NOMBRE_LOCALIDAD_DOMICILIO">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Nombre del municipio o demarcación territorial </label>
                        <input type="text" class="form-control" name="NOMBRE_MUNICIPIO_DOMICILIO">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Nombre de la Entidad Federativa </label>
                        <input type="text" class="form-control" name="NOMBRE_ENTIDAD_DOMICILIO">
                    </div>
                    <div class="col-6 mb-3">
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

        const botonEliminar = divDomicilio.querySelector('.botonEliminarDomicilio');
        botonEliminar.addEventListener('click', function () {
            contenedor.removeChild(divDomicilio);
        });

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
        const tipoFiscal = direccion.TIPODEDOMICILIOFISCAL || ''; 
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
                <label>Tipo de Domicilio Fiscal *</label>
                <select class="form-select tipoDomicilioSelect" required>
                    ${tipoOptions}
                </select>
            </div>

            <!-- Contenedor Nacional -->
            <div class="col-12 contenedorNacional" style="display: ${tipoFiscal === 'nacional' ? 'block' : 'none'};">
                <div class="row"> 
                    <div class="col-6 mb-3">
                        <label>Código Postal </label>
                        <input type="number" class="form-control codigo-postal" name="CODIGO_POSTAL_DOMICILIO" value="${direccion.CODIGO_POSTAL_DOMICILIO || ''}">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Tipo de Vialidad </label>
                        <input type="text" class="form-control" name="TIPO_VIALIDAD_DOMICILIO" value="${direccion.TIPO_VIALIDAD_DOMICILIO || ''}">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Nombre de la Vialidad </label>
                        <input type="text" class="form-control" name="NOMBRE_VIALIDAD_DOMICILIO" value="${direccion.NOMBRE_VIALIDAD_DOMICILIO || ''}">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Número Exterior</label>
                        <input type="text" class="form-control" name="NUMERO_EXTERIOR_DOMICILIO" value="${direccion.NUMERO_EXTERIOR_DOMICILIO || ''}">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Número Interior</label>
                        <input type="text" class="form-control" name="NUMERO_INTERIOR_DOMICILIO" value="${direccion.NUMERO_INTERIOR_DOMICILIO || ''}">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Nombre de la colonia</label>
                        <select class="form-control nombre-colonia" name="NOMBRE_COLONIA_DOMICILIO">
                            <option value="">Seleccione una opción</option>
                        </select>
                    </div>
                    <div class="col-6 mb-3">
                        <label>Nombre de la Localidad *</label>
                        <input type="text" class="form-control" name="NOMBRE_LOCALIDAD_DOMICILIO" value="${direccion.NOMBRE_LOCALIDAD_DOMICILIO || ''}">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Nombre del municipio o demarcación territorial *</label>
                        <input type="text" class="form-control" name="NOMBRE_MUNICIPIO_DOMICILIO" value="${direccion.NOMBRE_MUNICIPIO_DOMICILIO || ''}">
                    </div>
                    <div class="col-6 mb-3">
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


/// SUCURSALES


$('#CUENTA_SUCURSALES').on('change', function () {

    if ($(this).val() === '1') {
        $('#SUCURSALES_DIV').show();
    } else {
        $('#SUCURSALES_DIV').hide();
    }

});




document.addEventListener("input", function (event) {
    if (event.target.matches("input[name='CODIGO_POSTAL_SUCURSAL']")) {
        let codigoPostalInput = event.target;
        let codigoPostal = codigoPostalInput.value.trim();

        if (codigoPostal.length === 5) {
            fetch(`/codigo-postal/${codigoPostal}`)
                .then(response => response.json())
                .then(data => {
                    if (!data.error) {
                        let response = data.response;
                        
                        let contenedor = codigoPostalInput.closest(".generarsucursal");

                        let coloniaSelect = contenedor.querySelector("select[name='NOMBRE_COLONIA_SUCURSAL']");
                        let municipioInput = contenedor.querySelector("input[name='NOMBRE_MUNICIPIO_SUCURSAL']");
                        let entidadInput = contenedor.querySelector("input[name='NOMBRE_ENTIDAD_SUCURSAL']");

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
    const botonAgregarSucursal = document.getElementById('botonAgregarSucursales');

    botonAgregarSucursal.addEventListener('click', function () {
        agregarSucursal();
    });

    function agregarSucursal() {
        const divSucursales = document.createElement('div');
        divSucursales.classList.add('row', 'generarsucursal', 'mb-3');

        divSucursales.innerHTML = `
            <div class="col-12 mb-3">
                <label>Tipo de Domicilio Fiscal *</label>
                <select class="form-select tipoDomicilioSelect" required>
                    <option value="">Seleccione una opción</option>
                    <option value="nacional">Nacional</option>
                    <option value="extranjero">Extranjero</option>
                </select>
            </div>

            <div class="col-12 contenedorNacional" style="display:none;">
                <div class="row">
                      <div class="col-4 mb-3">
                        <label>Nombre de la sucursal </label>
                        <input type="text" class="form-control" name="NOMBRE_SUCURSAL">
                    </div>

                    <div class="col-4 mb-3">
                        <label>Código Postal </label>
                        <input type="number" class="form-control" name="CODIGO_POSTAL_SUCURSAL">
                    </div>
                    <div class="col-4 mb-3">
                        <label>Tipo de Vialidad </label>
                        <input type="text" class="form-control" name="TIPO_VIALIDAD_SUCURSAL">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Nombre de la Vialidad </label>
                        <input type="text" class="form-control" name="NOMBRE_VIALIDAD_SUCURSAL">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Número Exterior</label>
                        <input type="text" class="form-control" name="NUMERO_EXTERIOR_SUCURSAL">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Número Interior</label>
                        <input type="text" class="form-control" name="NUMERO_INTERIOR_SUCURSAL">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Nombre de la colonia</label>
                        <select class="form-control" name="NOMBRE_COLONIA_SUCURSAL">
                            <option value="">Seleccione una opción</option>
                        </select>
                    </div>
                    <div class="col-6 mb-3">
                        <label>Nombre de la Localidad </label>
                        <input type="text" class="form-control" name="NOMBRE_LOCALIDAD_SUCURSAL">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Nombre del municipio o demarcación territorial </label>
                        <input type="text" class="form-control" name="NOMBRE_MUNICIPIO_SUCURSAL">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Nombre de la Entidad Federativa </label>
                        <input type="text" class="form-control" name="NOMBRE_ENTIDAD_SUCURSAL">
                    </div>
                    <div class="col-6 mb-3">
                        <label>País </label>
                        <input type="text" class="form-control" name="PAIS_CONTRATACION_SUCURSAL">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Entre Calle</label>
                        <input type="text" class="form-control" name="ENTRE_CALLE_SUCURSAL">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Y Calle</label>
                        <input type="text" class="form-control" name="ENTRE_CALLE_2_SUCURSAL">
                    </div>
                </div>
            </div>

            <div class="col-12 contenedorExtranjero" style="display:none;">
                <div class="row">
                  <div class="col-4 mb-3">
                        <label>Nombre de la sucursal </label>
                        <input type="text" class="form-control" name="SUCURSAL_EXTRANJERO">
                    </div>
                    <div class="col-8 mb-3">
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
                    <button type="button" class="btn btn-danger botonEliminarDomicilio">Eliminar sucursal <i class="bi bi-trash-fill"></i></button>
                </div>
            </div>
        `;

        const contenedor = document.querySelector('.sucursalesdiv');
        contenedor.appendChild(divSucursales);

        const botonEliminar = divSucursales.querySelector('.botonEliminarDomicilio');
        botonEliminar.addEventListener('click', function () {
            contenedor.removeChild(divSucursales);
        });

        const tipoSelect = divSucursales.querySelector('.tipoDomicilioSelect');
        const nacionalDiv = divSucursales.querySelector('.contenedorNacional');
        const extranjeroDiv = divSucursales.querySelector('.contenedorExtranjero');

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



function obtenerSucursales(data) {
    let row = data.data().SUCURSALES_JSON;
    let sucursales = JSON.parse(row);

    sucursales.forEach(sucursal => {
        const tipoFiscal = sucursal.TIPODEDOMICILIOFISCAL || ''; 
        const contenedor = document.querySelector('.sucursalesdiv');

        const divDomicilio = document.createElement('div');
        divDomicilio.classList.add('row', 'generarsucursal', 'mb-3');

        // Opciones del select
        let tipoOptions = `
            <option value="">Seleccione una opción</option>
            <option value="nacional" ${tipoFiscal === 'nacional' ? 'selected' : ''}>Nacional</option>
            <option value="extranjero" ${tipoFiscal === 'extranjero' ? 'selected' : ''}>Extranjero</option>
        `;

        divDomicilio.innerHTML = `
            <div class="col-12 mb-3">
                <label>Tipo de Domicilio Fiscal *</label>
                <select class="form-select tipoDomicilioSelect" required>
                    ${tipoOptions}
                </select>
            </div>

            <!-- Contenedor Nacional -->
            <div class="col-12 contenedorNacional" style="display: ${tipoFiscal === 'nacional' ? 'block' : 'none'};">
                <div class="row"> 
                
                    <div class="col-4 mb-3">
                        <label>Nombre de la sucursal </label>
                        <input type="text" class="form-control" name="NOMBRE_SUCURSAL" value="${sucursal.NOMBRE_SUCURSAL || ''}">
                    </div>

                    <div class="col-4 mb-3">
                        <label>Código Postal </label>
                        <input type="number" class="form-control codigo-postal" name="CODIGO_POSTAL_SUCURSAL" value="${sucursal.CODIGO_POSTAL_SUCURSAL || ''}">
                    </div>
                    <div class="col-4 mb-3">
                        <label>Tipo de Vialidad </label>
                        <input type="text" class="form-control" name="TIPO_VIALIDAD_SUCURSAL" value="${sucursal.TIPO_VIALIDAD_SUCURSAL || ''}">
                    </div>
                    <div class="col-4 mb-3">
                        <label>Nombre de la Vialidad </label>
                        <input type="text" class="form-control" name="NOMBRE_VIALIDAD_SUCURSAL" value="${sucursal.NOMBRE_VIALIDAD_SUCURSAL || ''}">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Número Exterior</label>
                        <input type="text" class="form-control" name="NUMERO_EXTERIOR_SUCURSAL" value="${sucursal.NUMERO_EXTERIOR_SUCURSAL || ''}">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Número Interior</label>
                        <input type="text" class="form-control" name="NUMERO_INTERIOR_SUCURSAL" value="${sucursal.NUMERO_INTERIOR_SUCURSAL || ''}">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Nombre de la colonia</label>
                        <select class="form-control nombre-colonia" name="NOMBRE_COLONIA_SUCURSAL">
                            <option value="">Seleccione una opción</option>
                        </select>
                    </div>
                    <div class="col-6 mb-3">
                        <label>Nombre de la Localidad *</label>
                        <input type="text" class="form-control" name="NOMBRE_LOCALIDAD_SUCURSAL" value="${sucursal.NOMBRE_LOCALIDAD_SUCURSAL || ''}">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Nombre del municipio o demarcación territorial *</label>
                        <input type="text" class="form-control" name="NOMBRE_MUNICIPIO_SUCURSAL" value="${sucursal.NOMBRE_MUNICIPIO_SUCURSAL || ''}">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Nombre de la Entidad Federativa *</label>
                        <input type="text" class="form-control" name="NOMBRE_ENTIDAD_SUCURSAL" value="${sucursal.NOMBRE_ENTIDAD_SUCURSAL || ''}">
                    </div>
                    <div class="col-6 mb-3">
                        <label>País </label>
                        <input type="text" class="form-control" name="PAIS_CONTRATACION_SUCURSAL" value="${sucursal.PAIS_CONTRATACION_SUCURSAL || ''}">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Entre Calle</label>
                        <input type="text" class="form-control" name="ENTRE_CALLE_SUCURSAL" value="${sucursal.ENTRE_CALLE_SUCURSAL || ''}">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Y Calle</label>
                        <input type="text" class="form-control" name="ENTRE_CALLE_2_SUCURSAL" value="${sucursal.ENTRE_CALLE_2_SUCURSAL || ''}">
                    </div>
                </div>
            </div>

            <!-- Contenedor Extranjero -->
            <div class="col-12 contenedorExtranjero" style="display: ${tipoFiscal === 'extranjero' ? 'block' : 'none'};">
                <div class="row">
                 <div class="col-4 mb-3">
                        <label>Nombre de la sucursal </label>
                        <input type="text" class="form-control" name="SUCURSAL_EXTRANJERO" value="${sucursal.SUCURSAL_EXTRANJERO || ''}">
                    </div>
                    <div class="col-8 mb-3">
                        <label>Domicilio </label>
                        <input type="text" class="form-control" name="DOMICILIO_EXTRANJERO" value="${sucursal.DOMICILIO_EXTRANJERO || ''}">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Código Postal </label>
                        <input type="text" class="form-control" name="CP_EXTRANJERO" value="${sucursal.CP_EXTRANJERO || ''}">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Ciudad </label>
                        <input type="text" class="form-control" name="CIUDAD_EXTRANJERO" value="${sucursal.CIUDAD_EXTRANJERO || ''}">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Estado/Departamento/Provincia *</label>
                        <input type="text" class="form-control" name="ESTADO_EXTRANJERO" value="${sucursal.ESTADO_EXTRANJERO || ''}">
                    </div>
                    <div class="col-6 mb-3">
                        <label>País </label>
                        <input type="text" class="form-control" name="PAIS_EXTRANJERO" value="${sucursal.PAIS_EXTRANJERO || ''}">
                    </div>
                </div>
            </div>

            <div class="col-12 mt-4">
                <div class="form-group text-center">
                    <button type="button" class="btn btn-danger botonEliminarDomicilio">Eliminar sucursal <i class="bi bi-trash-fill"></i></button>
                </div>
            </div>
        `;

        contenedor.appendChild(divDomicilio);

        if (tipoFiscal === 'nacional' && sucursal.CODIGO_POSTAL_SUCURSAL) {
            fetch(`/codigo-postal/${sucursal.CODIGO_POSTAL_SUCURSAL}`)
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

                        coloniaSelect.value = sucursal.NOMBRE_COLONIA_SUCURSAL || '';
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




