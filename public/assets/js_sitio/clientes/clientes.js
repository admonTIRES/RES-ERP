//VARIABLES GLOBALES

var cliente_id = null; 


// ID DE LOS FORMULARIOS 

ID_FORMULARIO_CLIENTES = 0
ID_VERIFICACION_CLIENTE = 0
ID_ACTA_CLIENTE = 0



$("#NUEVO_CLIENTE").click(function (e) {
    e.preventDefault();

    $('#formularioCLIENTES')[0].reset();
    $(".contactodiv").empty();
    $(".direcciondiv").empty();

    $("#miModal_CLIENTES").modal("show");

    $("#tab1-info").click();

    $("#tab2-verif").prop("disabled", true);
    $("#tab3-acta").prop("disabled", true);
});



$("#NUEVA_VERIFICACION").click(function (e) {
    e.preventDefault();

    
    $('#formularioVERIFICACIONES').each(function(){
        this.reset();
    });

    $("#miModal_VERIFICACIONES").modal("show");
   
});



$("#NUEVA_ACTA").click(function (e) {
    e.preventDefault();

    
    $('#formularioACTA').each(function(){
        this.reset();
    });

    $("#miModal_ACTA").modal("show");
   
});


const ModalArea = document.getElementById('miModal_CLIENTES');

ModalArea.addEventListener('hidden.bs.modal', event => {
    ID_FORMULARIO_CLIENTES = 0;
    document.getElementById('formularioCLIENTES').reset();

    $('#miModal_CLIENTES .modal-title').html('Cliente');

});



$("#guardarCLIENTE").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormularioV1('formularioCLIENTES');

    if (formularioValido) {
    
                    var contactos = [];
                    $(".generarcontacto").each(function() {
                        var contacto = {
                            'TITULO_CONTACTO_SOLICITUD': $(this).find("select[name='TITULO_CONTACTO_SOLICITUD']").val()?.trim() || '',
                            'CONTACTO_SOLICITUD': $(this).find("input[name='CONTACTO_SOLICITUD']").val()?.trim() || '',
                            'CARGO_SOLICITUD': $(this).find("input[name='CARGO_SOLICITUD']").val()?.trim() || '',
                            'TELEFONO_SOLICITUD': $(this).find("input[name='TELEFONO_SOLICITUD']").val()?.trim() || '',
                            'CELULAR_SOLICITUD': $(this).find("input[name='CELULAR_SOLICITUD']").val()?.trim() || '',
                            'CORREO_SOLICITUD': $(this).find("input[name='CORREO_SOLICITUD']").val()?.trim() || '',
                            'EXTENSION_SOLICITUD': $(this).find("input[name='EXTENSION_SOLICITUD']").val()?.trim() || ''
                        };
                        contactos.push(contacto);
                    });

                    var direcciones = [];

            $(".generardireccion").each(function () {
                const tipoSeleccionado = $(this).find("select.tipoDomicilioSelect").val()?.trim();

                if (tipoSeleccionado === "nacional") {
                    var direccion = {
                        'TIPODEDOMICILIOFISCAL': 'nacional',

                        'TIPO_DOMICILIO': $(this).find("input[name='TIPO_DOMICILIO']").val()?.trim() || '', 
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
                api: 1,
                ID_FORMULARIO_CLIENTES: ID_FORMULARIO_CLIENTES,
                CONTACTOS_JSON: contactos.length ? JSON.stringify(contactos) : "[]",
                DIRECCIONES_JSON: direcciones.length ? JSON.stringify(direcciones) : "[]"
            };
            

        if (ID_FORMULARIO_CLIENTES == 0) {
            alertMensajeConfirm({
                title: "¿Desea guardar la información?",
                text: "Al guardarla, se podrá usar",
                icon: "question",
            }, async function () {

                await loaderbtn('guardarCLIENTE');
                await ajaxAwaitFormData(requestData, 'ClienteSave', 'formularioCLIENTES', 'guardarCLIENTE', { callbackAfter: true, callbackBefore: true }, () => {
                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');
                    
                }, function (data) {
                    
                    ID_FORMULARIO_CLIENTES = data.cliente.ID_FORMULARIO_CLIENTES
                    alertMensaje('success', 'Información guardada correctamente', 'Esta información esta lista para usarse', null, null, 1500)
                     $('#miModal_CLIENTES').modal('hide')
                        document.getElementById('formularioCLIENTES').reset();
                        Tablaclientesventas.ajax.reload()
    
    
                })
                
            }, 1);
            
        } else {
            alertMensajeConfirm({
                title: "¿Desea editar la información de este formulario?",
                text: "Al guardarla, se podrá usar",
                icon: "question",
            }, async function () {

                await loaderbtn('guardarCLIENTE');
                await ajaxAwaitFormData(requestData, 'ClienteSave', 'formularioCLIENTES', 'guardarCLIENTE', { callbackAfter: true, callbackBefore: true }, () => {
                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');

                }, function (data) {
                    
                    setTimeout(() => {
    
                        ID_FORMULARIO_CLIENTES = data.cliente.ID_FORMULARIO_CLIENTES
                        alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                        $('#miModal_CLIENTES').modal('hide')
                        document.getElementById('formularioCLIENTES').reset();
                        Tablaclientesventas.ajax.reload()
    
    
                    }, 300);  
                })
            }, 1);
        }
    } else {
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000);
    }
});


document.addEventListener('DOMContentLoaded', function () {
  const guardarBtn = document.getElementById('guardarCLIENTE');
  const tabs = document.querySelectorAll('#tabsCliente button[data-bs-toggle="tab"]');

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

  const activeTab = document.querySelector('#tabsCliente button.active');
  if (activeTab && activeTab.getAttribute('data-bs-target') !== '#contenido-info') {
    guardarBtn.style.display = 'none';
  }
});



var Tablaclientesventas = $("#Tablaclientesventas").DataTable({
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
        url: '/Tablaclientesventas',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablaclientesventas.columns.adjust().draw();
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
        { data: 'RFC_CLIENTE' },
        { data: 'RAZON_SOCIAL_CLIENTE' },
        { data: 'BTN_DOCUMENTO' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'R.F.C', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Razón Social', className: 'all text-center nombre-column' },
        { targets: 3, title: 'C.S.F', className: 'all text-center nombre-column' },
        { targets: 4, title: 'Editar', className: 'all text-center' },
        { targets: 5, title: 'Visualizar', className: 'all text-center' },
        { targets: 6, title: 'Activo', className: 'all text-center' }
    ],
     infoCallback: function (settings, start, end, max, total, pre) {
        return `Total de ${total} registros`;
    },
});



$('#Tablaclientesventas').on('click', '.ver-archivo-constancia', function () {
    var tr = $(this).closest('tr');
    var row = Tablaclientesventas.row(tr);
    var id = $(this).data('id');

    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }

    var nombreDocumento = row.data().RAZON_SOCIAL_CLIENTE;
    var url = '/mostrarconstanciacliente/' + id;
    
    abrirModal(url, nombreDocumento);
});





$('#Tablaclientesventas tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablaclientesventas.row(tr);


        ID_FORMULARIO_CLIENTES = row.data().ID_FORMULARIO_CLIENTES;

        cliente_id = row.data().ID_FORMULARIO_CLIENTES;
    

    $(".contactodiv").empty();
    obtenerContactos(row);  

    $(".direcciondiv").empty();
    obtenerDirecciones(row);

    
    
    editarDatoTabla(row.data(), 'formularioCLIENTES', 'miModal_CLIENTES', 1);
    $('#miModal_CLIENTES .modal-title').html(row.data().RAZON_SOCIAL_CLIENTE);


    $("#tab1-info").click();

    $("#tab2-verif").prop("disabled", false);
    $("#tab3-acta").prop("disabled", false);

    
    $("#tab2-verif").off("click").on("click", function () {
        cargarTablaverificacion();
    });


    $("#tab3-acta").off("click").on("click", function () {
        cargarTablaacta();
    });
    
});


$(document).ready(function() {
    $('#Tablaclientesventas tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablaclientesventas.row(tr);
        
        hacerSoloLectura2(row.data(), '#miModal_CLIENTES');

        ID_FORMULARIO_CLIENTES = row.data().ID_FORMULARIO_CLIENTES;


        $(".contactodiv").empty();
        obtenerContactos(row);  
    
        $(".direcciondiv").empty();
        obtenerDirecciones(row);


        editarDatoTabla(row.data(), 'formularioCLIENTES', 'miModal_CLIENTES',1);
        $('#miModal_CLIENTES .modal-title').html(row.data().RAZON_SOCIAL_CLIENTE);


        $("#tab1-info").click();

        $("#tab2-verif").prop("disabled", false);
        $("#tab3-acta").prop("disabled", false);
    
        

    });

    $('#miModal_CLIENTES').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_CLIENTES');
    });
});


$('#Tablaclientesventas tbody').on('change', 'td>label>input.ELIMINAR', function () {
var tr = $(this).closest('tr');
var row = Tablaclientesventas.row(tr);

var estado = $(this).is(':checked') ? 1 : 0;

data = {
    api: 1,
    ELIMINAR: estado == 0 ? 1 : 0, 
    ID_FORMULARIO_CLIENTES: row.data().ID_FORMULARIO_CLIENTES
};

eliminarDatoTabla(data, [Tablaclientesventas], 'ClienteDelete');
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

        let options = '<option value="" disabled selected>Seleccione un título</option>';
        titulosCuenta.forEach(item => {
            options += `<option value="${item.ABREVIATURA_TITULO}">${item.ABREVIATURA_TITULO}</option>`;
        });

        divContacto.innerHTML = `
            <div class="col-12">
                <div class="row">
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Título</label>
                        <select class="form-select" name="TITULO_CONTACTO_SOLICITUD">
                            ${options}
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
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
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" class="form-control" name="TELEFONO_SOLICITUD">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Extensión</label>
                        <input type="text" class="form-control" name="EXTENSION_SOLICITUD">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Celular </label>
                        <input type="text" class="form-control" name="CELULAR_SOLICITUD" >
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Correo electrónico </label>
                        <input type="email" class="form-control" name="CORREO_SOLICITUD" >
                    </div>
                </div>
            </div>

            <div class="col-12 mt-4 text-center">
                <button type="button" class="btn btn-danger botonEliminarContacto">Eliminar contacto <i class="bi bi-trash-fill"></i></button>
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
            EXTENSION_SOLICITUD,
            CELULAR_SOLICITUD,
            CORREO_SOLICITUD,
            TITULO_CONTACTO_SOLICITUD
        } = contacto;

        let options = '<option value="" disabled>Seleccione un título</option>';
        titulosCuenta.forEach(item => {
            const selected = item.ABREVIATURA_TITULO === TITULO_CONTACTO_SOLICITUD ? 'selected' : '';
            options += `<option value="${item.ABREVIATURA_TITULO}" ${selected}>${item.ABREVIATURA_TITULO}</option>`;
        });

        const divContacto = document.createElement('div');
        divContacto.classList.add('row', 'generarcontacto', 'mb-3');

        divContacto.innerHTML = `
            <div class="col-12">
                <div class="row">
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Título</label>
                        <select class="form-select" name="TITULO_CONTACTO_SOLICITUD">
                            ${options}
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
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
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" class="form-control" name="TELEFONO_SOLICITUD" value="${TELEFONO_SOLICITUD || ''}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Extensión</label>
                        <input type="text" class="form-control" name="EXTENSION_SOLICITUD" value="${EXTENSION_SOLICITUD || ''}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Celular *</label>
                        <input type="text" class="form-control" name="CELULAR_SOLICITUD" value="${CELULAR_SOLICITUD}" >
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Correo electrónico *</label>
                        <input type="email" class="form-control" name="CORREO_SOLICITUD" value="${CORREO_SOLICITUD}" >
                    </div>
                </div>
            </div>

            <div class="col-12 mt-4 text-center">
                <button type="button" class="btn btn-danger botonEliminarContacto">Eliminar contacto <i class="bi bi-trash-fill"></i></button>
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
                    <div class="col-3 mb-3">
                        <label>Tipo de Domicilio *</label>
                        <input type="text" class="form-control" name="TIPO_DOMICILIO">
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
                    <div class="col-3 mb-3">
                        <label>Tipo de Domicilio </label>
                        <input type="text" class="form-control" name="TIPO_DOMICILIO" value="${direccion.TIPO_DOMICILIO || ''}">
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


//////////////////////////  VERIFICACION DEL CLIENTE ////////////////////////// 


const Modalverificacion = document.getElementById('miModal_VERIFICACIONES');

Modalverificacion.addEventListener('hidden.bs.modal', event => {
    ID_VERIFICACION_CLIENTE = 0;
    document.getElementById('formularioVERIFICACIONES').reset();

    $('#miModal_VERIFICACIONES .modal-title').html('Nueva verificación');

});




$("#guardarVERIFICACION").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormularioV1('formularioVERIFICACIONES');

    if (formularioValido) {

    if (ID_VERIFICACION_CLIENTE == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarVERIFICACION')
            await ajaxAwaitFormData({ api: 2,CLIENTE_ID:cliente_id, ID_VERIFICACION_CLIENTE: ID_VERIFICACION_CLIENTE }, 'ClienteSave', 'formularioVERIFICACIONES', 'guardarVERIFICACION', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
                
            }, function (data) {
                    
                ID_VERIFICACION_CLIENTE = data.cliente.ID_VERIFICACION_CLIENTE
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_VERIFICACIONES').modal('hide')
                    document.getElementById('formularioVERIFICACIONES').reset();


                    
                    if ($.fn.DataTable.isDataTable('#Tablaverificacionusuario')) {
                        Tablaverificacionusuario.ajax.reload(null, false); 
                    }

            })
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarVERIFICACION')
            await ajaxAwaitFormData({ api: 2,CLIENTE_ID:cliente_id ,ID_VERIFICACION_CLIENTE: ID_VERIFICACION_CLIENTE }, 'ClienteSave', 'formularioVERIFICACIONES', 'guardarVERIFICACION', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
            }, function (data) {
                    
                setTimeout(() => {

                    ID_VERIFICACION_CLIENTE = data.cliente.ID_VERIFICACION_CLIENTE
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_VERIFICACIONES').modal('hide')
                    document.getElementById('formularioVERIFICACIONES').reset();


                    
                    if ($.fn.DataTable.isDataTable('#Tablaverificacionusuario')) {
                        Tablaverificacionusuario.ajax.reload(null, false); 
                    }

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});



function cargarTablaverificacion() {
    if ($.fn.DataTable.isDataTable('#Tablaverificacionusuario')) {
        Tablaverificacionusuario.clear().destroy();
    }

    Tablaverificacionusuario = $("#Tablaverificacionusuario").DataTable({
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
            data: { cliente: cliente_id }, 
            method: 'GET',
            cache: false,
            url: '/Tablaverificacionusuario',  
            beforeSend: function () {
                $('#loadingIcon').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon').css('display', 'none');
                Tablaverificacionusuario.columns.adjust().draw(); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon').css('display', 'none');
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            },
            dataSrc: 'data'
        },
        columns: [
            { data: null, render: function(data, type, row, meta) { return meta.row + 1; }, className: 'text-center' },
            { data: 'VERIFICADO_EN', className: 'text-center' },
            { data: 'BTN_DOCUMENTO', className: 'text-center' },
            { data: 'BTN_EDITAR', className: 'text-center' },
        ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all text-center' },
            { targets: 1, title: 'Verificado en:', className: 'all text-center' },  
            { targets: 2, title: 'Documento', className: 'all text-center' },  
            { targets: 3, title: 'Editar', className: 'all text-center' }, 

        ],
       
    });
}



$('#Tablaverificacionusuario').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablaverificacionusuario.row(tr);

    ID_VERIFICACION_CLIENTE = row.data().ID_VERIFICACION_CLIENTE;

    editarDatoTabla(row.data(), 'formularioVERIFICACIONES', 'miModal_VERIFICACIONES', 1);

    $('#miModal_VERIFICACIONES .modal-title').html(row.data().VERIFICADO_EN);
});




$('#Tablaverificacionusuario').on('click', '.ver-archivo-verificacion', function () {
    var tr = $(this).closest('tr');
    var row = Tablaverificacionusuario.row(tr);
    var id = $(this).data('id');

    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }

    var nombreDocumento = row.data().VERIFICADO_EN;
    var url = '/mostrarverificacionclienteventas/' + id;
    
    abrirModal(url, nombreDocumento);
});

////////////////////////// ACTA CONSTITUTIVA //////////////////////////



const Modalacta = document.getElementById('miModal_ACTA');

Modalacta.addEventListener('hidden.bs.modal', event => {
    ID_ACTA_CLIENTE = 0;
    document.getElementById('formularioACTA').reset();

    $('#miModal_ACTA .modal-title').html('Nueva acta constitutiva');

});

$("#guardarACTA").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormularioV1('formularioACTA');

    if (formularioValido) {

    if (ID_ACTA_CLIENTE == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarACTA')
            await ajaxAwaitFormData({ api: 3,CLIENTE_ID:cliente_id, ID_ACTA_CLIENTE: ID_ACTA_CLIENTE }, 'ClienteSave', 'formularioACTA', 'guardarACTA', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
                
            }, function (data) {
                    
                ID_ACTA_CLIENTE = data.cliente.ID_ACTA_CLIENTE
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_ACTA').modal('hide')
                    document.getElementById('formularioACTA').reset();


                    
                    if ($.fn.DataTable.isDataTable('#Tablactaconstitutivausuario')) {
                        Tablactaconstitutivausuario.ajax.reload(null, false); 
                    }

            })
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarACTA')
            await ajaxAwaitFormData({ api: 3,CLIENTE_ID:cliente_id ,ID_ACTA_CLIENTE: ID_ACTA_CLIENTE }, 'ClienteSave', 'formularioACTA', 'guardarACTA', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
            }, function (data) {
                    
                setTimeout(() => {

                    ID_ACTA_CLIENTE = data.cliente.ID_ACTA_CLIENTE
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_ACTA').modal('hide')
                    document.getElementById('formularioACTA').reset();


                    
                    if ($.fn.DataTable.isDataTable('#Tablactaconstitutivausuario')) {
                        Tablactaconstitutivausuario.ajax.reload(null, false); 
                    }

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});





function cargarTablaacta() {
    if ($.fn.DataTable.isDataTable('#Tablactaconstitutivausuario')) {
        Tablactaconstitutivausuario.clear().destroy();
    }

    Tablactaconstitutivausuario = $("#Tablactaconstitutivausuario").DataTable({
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
            data: { cliente: cliente_id }, 
            method: 'GET',
            cache: false,
            url: '/Tablactaconstitutivausuario',  
            beforeSend: function () {
                $('#loadingIcon2').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon2').css('display', 'none');
                Tablactaconstitutivausuario.columns.adjust().draw(); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon2').css('display', 'none');
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            },
            dataSrc: 'data'
        },
        columns: [
            { data: null, render: function(data, type, row, meta) { return meta.row + 1; }, className: 'text-center' },
            { data: 'ACTA_CONSTITUVA', className: 'text-center' },
            { data: 'BTN_DOCUMENTO', className: 'text-center' },
            { data: 'BTN_EDITAR', className: 'text-center' },
        ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all text-center' },
            { targets: 1, title: ' Acta constitutiva ', className: 'all text-center' },  
            { targets: 2, title: 'Documento', className: 'all text-center' },  
            { targets: 3, title: 'Editar', className: 'all text-center' }, 

        ],
       
    });
}




$('#Tablactaconstitutivausuario').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablactaconstitutivausuario.row(tr);

    ID_ACTA_CLIENTE = row.data().ID_ACTA_CLIENTE;

    editarDatoTabla(row.data(), 'formularioACTA', 'miModal_ACTA', 1);

    $('#miModal_ACTA .modal-title').html(row.data().ACTA_CONSTITUVA);
});




$('#Tablactaconstitutivausuario').on('click', '.ver-archivo-veracta', function () {
    var tr = $(this).closest('tr');
    var row = Tablactaconstitutivausuario.row(tr);
    var id = $(this).data('id');

    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }

    var nombreDocumento = row.data().ACTA_CONSTITUVA;
    var url = '/mostraractaclienteventas/' + id;
    
    abrirModal(url, nombreDocumento);
});