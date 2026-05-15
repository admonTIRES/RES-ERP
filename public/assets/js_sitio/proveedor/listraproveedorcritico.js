//VARIABLES GLOBALES
var rfcSeleccionada; 


window.ID_FORMULARIO_ALTA = 0;


// ID DE LOS FORMULARIOS
ID_FORMULARIO_CUENTAPROVEEDOR = 0
ID_FORMULARIO_CONTACTOPROVEEDOR = 0
ID_FORMULARIO_CERTIFICACIONPROVEEDOR = 0
ID_FORMULARIO_REFERENCIASPROVEEDOR = 0
ID_FORMULARIO_DOCUMENTOSPROVEEDOR = 0
ID_ASINGACIONES_PROVEEDOR = 0;
ID_CONTRATO_PROVEEDORES = 0
ID_FORMULARIO_FACTURACION = 0;


// TABLAS
Tablalistaproveedorescriticos = null



var Tablacuentas;
var tablacuentasCargada = false; 


var Tablacontactos;
var tablacontactosCargada = false; 


var Tablacertificaciones;
var tablacertificacionesCargada = false; 


var Tablareferencias;
var tablareferenciasCargada = false; 


var Tabladocumentosoporteproveedores;
var tablasoportesCargada = false; 


var Tablasignacionproveedorgeneral;
var tablasasignacionesCargada = false; 



var Tablacontratosproveedores;
var tablascontratoCargada = false; 



var Tablafacturaproveedoresinterno;
var tablasfacturaCargada = false; 



$('#myTab a').on('click', function (e) {
    e.preventDefault();
    $(this).tab('show');
});

$(document).ready(function() {
    
    $("#contratos-tab").click(function () {
        $('#datosgenerales-tab').closest('li').css("display", 'none');
        $('#contratosdoc-tab').closest('li').css("display", 'none');
    });
    
    $("#datosgenerales-tab").click(function () {
        
        if (tablacontratosCargada) {
            Tablacontratosyanexos.columns.adjust().draw();
        } else {
            cargarTablaContratosyanexos();
            tablacontratosCargada = true;
        }

        $('#contratosdoc-tab').closest('li').css("display", 'none');
    });

});






var Tablalistaproveedorescriticos = $("#Tablalistaproveedorescriticos").DataTable({
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
    destroy: true,
    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'Todos']],
    ajax: {
        dataType: 'json',
        data: {},
        method: 'GET',
        cache: false,
        url: '/Tablalistaproveedorescriticos',
        beforeSend: function () {
            $('#loadingIcon1').css('display', 'inline-block');
        },
        complete: function () {
            $('#loadingIcon1').css('display', 'none');
            Tablalistaproveedorescriticos.columns.adjust().draw(); 
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('#loadingIcon1').css('display', 'none');
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
        { data: 'RFC_ALTA' },
        { data: 'RAZON_SOCIAL_ALTA' },
        {
            data: 'created_at',
            render: function (data) {
                if (!data) return '';
                return data.split('T')[0]; 
            }
        },
        { data: 'ESTATUS_DATOS' }, 
        { data: 'BTN_CORREO' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    createdRow: function(row, data) {
        if (data.VERIFICACION_SOLICITADA == 1) {

            $(row).css("background-color", "#fff3cd"); 
            $(row).attr("title", "Verificación de información solicitada");
            $(row).tooltip();
        } else {
            $(row).css("background-color", ""); 
            $(row).attr("title", "");
            $(row).tooltip();
        }
    },
    
    columnDefs: [
        { targets: 0, title: '#', className: 'all text-center' },
        { targets: 1, title: 'RFC/Tax ID ', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Razón social/Nombre', className: 'all text-center nombre-column' },
        { targets: 3, title: 'Fecha de registro', className: 'all text-center' },
        { targets: 4, title: 'Información faltante', className: 'all text-center' },
        { targets: 5, title: 'Correo', className: 'all text-center' },
        { targets: 6, title: 'Mostrar', className: 'all text-center' },
        { targets: 7, title: 'Activo', className: 'all text-center' },


    ],
     infoCallback: function (settings, start, end, max, total, pre) {
        return `Total de ${total} registros`;
    },
});



$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    var target = $(e.target).attr("href"); 
    if (target === '#contratos') {
        Tablalistaproveedorescriticos.columns.adjust().draw(); 
    }
    
});

function reloadTablalistaproveedorescriticos() {
    Tablalistaproveedorescriticos.ajax.reload(null, false); 
}




$(document).on("click", ".CORREO", function (e) {
    e.preventDefault();

    const $btn = $(this);
    const id = $btn.data("id");

    $btn.prop("disabled", true); 

    Swal.fire({
        title: 'Enviando correo...',
        text: 'Por favor, espere un momento.',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    $.ajax({
        url: `/enviarCorreoFaltantes/${id}`,
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
        },
        success: function (response) {
            Swal.close();

            if (response.status === "success") {
                Swal.fire({
                    title: "Correo enviado",
                    text: response.message,
                    icon: "success"
                });
            } else {
                Swal.fire({
                    title: "Atención",
                    text: response.message,
                    icon: "warning"
                });
            }
        },
        error: function (xhr) {
            Swal.close();

            let mensaje = "Ocurrió un error inesperado al enviar el correo.";
            if (xhr.responseJSON && xhr.responseJSON.message) {
                mensaje = xhr.responseJSON.message;
            }

            Swal.fire({
                title: "Error",
                text: mensaje,
                icon: "error"
            });
        },
        complete: function () {
            $btn.prop("disabled", false); // Reactivar botón al terminar
        }
    });
});









// <!-- ============================================================================================================================ -->
// <!--                                                          STEP 1                                                              -->
// <!-- ============================================================================================================================ -->


document.getElementById('step1').addEventListener('click', function() {
    document.querySelectorAll('[id$="-content"]').forEach(function(content) {
        content.style.display = 'none';
    });

    document.getElementById('step1-content').style.display = 'block';
});



$("#guardarALTA").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormularioV1('formularioALTA');

    if (formularioValido) {
      
        var documentos = [];
        $(".generardocumento").each(function() {
            var documento = {
                'TIPO_DOCUMENTO_IDENTIFICACION': $(this).find("select[name='TIPO_DOCUMENTO_IDENTIFICACION']").val(),
                'EMISION_DOCUMENTO': $(this).find("input[name='EMISION_DOCUMENTO']").val(),
                'VIGENCIA_DOCUMENTO': $(this).find("input[name='VIGENCIA_DOCUMENTO']").val(),
                'NUMERO_DOCUMENTO': $(this).find("input[name='NUMERO_DOCUMENTO']").val(),
                'EXPEDIDO_DOCUMENTO': $(this).find("input[name='EXPEDIDO_DOCUMENTO']").val(),
                'EMITIDO_POR_DOCUMENTO': $(this).find("input[name='EMITIDO_POR_DOCUMENTO']").val()

            };
            documentos.push(documento);
        });

        const requestData = {
            api: 1,
            ID_FORMULARIO_ALTA: ID_FORMULARIO_ALTA,
            DOCUMENTOS_JSON: JSON.stringify(documentos)

        };

        if (ID_FORMULARIO_ALTA == 0) {
            alertMensajeConfirm({
                title: "¿Desea guardar la información?",
                text: "Al guardarla, se podrá usar",
                icon: "question",
            }, async function () {

                await loaderbtn('guardarALTA');
                await ajaxAwaitFormData(requestData, 'AltaSave1', 'formularioALTA', 'guardarALTA', { callbackAfter: true, callbackBefore: true }, () => {
                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');
                    
                },function (data) {
                    rfcSeleccionada = data.funcion.RFC_ALTA;
                    ID_FORMULARIO_ALTA = data.funcion.ID_FORMULARIO_ALTA;
        
                    alertMensaje('success', 'Información guardada correctamente', 'Esta información está lista para usarse', null, null, 1500);
                    Tablalistaproveedorescriticos.ajax.reload();
                });
            }, 1);
            
        } else {
            alertMensajeConfirm({
                title: "¿Desea editar la información de este formulario?",
                text: "Al guardarla, se podrá usar",
                icon: "question",
            }, async function () {

                await loaderbtn('guardarALTA');
                await ajaxAwaitFormData(requestData, 'AltaSave1', 'formularioALTA', 'guardarALTA', { callbackAfter: true, callbackBefore: true }, () => {
                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');

                }, function (data) {
                    setTimeout(() => {
                        ID_FORMULARIO_ALTA = data.contrato.ID_FORMULARIO_ALTA;
                        alertMensaje('success', 'Información editada correctamente', 'Información guardada');
                        Tablalistaproveedorescriticos.ajax.reload();
                    }, 300);
                });
            }, 1);
        }
    } else {
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000);
    }
});




document.addEventListener("DOMContentLoaded", function () {
    const tipoPersona = document.getElementById("TIPO_PERSONA_ALTA");
    const domicilioNacional = document.getElementById("DOMICILIO_NACIONAL");
    const domicilioExtranjero = document.getElementById("DOMICILIO_ERXTRANJERO");
    const labelRFC = document.querySelector('label[for="RFC_LABEL"]'); 


    tipoPersona.addEventListener("change", function () {
        if (this.value === "1") {
            domicilioNacional.style.display = "block";
            domicilioExtranjero.style.display = "none";
            labelRFC.textContent = "R.F.C *";

        } else if (this.value === "2") {
            domicilioNacional.style.display = "none";
            domicilioExtranjero.style.display = "block";
            labelRFC.textContent = "Tax ID *";

        }
    });
});


$('#Tablalistaproveedorescriticos tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablalistaproveedorescriticos.row(tr);


    
    ID_FORMULARIO_ALTA = row.data().ID_FORMULARIO_ALTA;

    $('#formularioALTA').each(function() {
        this.reset();
    });

    $('#datosgenerales-tab').closest('li').css("display", 'block');
    $('#step2, #step3,#step4,#step5,#step6,#step7').css("display", "flex");

    $('#step1-content').css("display", 'block');
    $('#step2-content, #step3-content, #step4-content,#step5-content,#step6-content,#step7-content').css("display", 'none');



    var rfc = row.data().RFC_ALTA;
    $("#RFC_ALTA").val(rfc);
    rfcSeleccionada = rfc;

    $("#ID_FORMULARIO_ALTA").val(row.data().ID_FORMULARIO_ALTA);


    
    $("#TIPO_PERSONA_OPCION").val(row.data().TIPO_PERSONA_OPCION);

    $("#TIPO_PERSONA_ALTA").val(row.data().TIPO_PERSONA_ALTA);
    $("#RAZON_SOCIAL_ALTA").val(row.data().RAZON_SOCIAL_ALTA);
    $("#RFC_ALTA").val(row.data().RFC_ALTA);
    $("#REPRESENTANTE_LEGAL_ALTA").val(row.data().REPRESENTANTE_LEGAL_ALTA || '');
    $("#REGIMEN_ALTA").val(row.data().REGIMEN_ALTA || '');
    $("#CORREO_DIRECTORIO").val(row.data().CORREO_DIRECTORIO || '');
    $("#TELEFONO_OFICINA_ALTA").val(row.data().TELEFONO_OFICINA_ALTA || '');
    $("#PAGINA_WEB_ALTA").val(row.data().PAGINA_WEB_ALTA || '');
    $("#CUAL_ACTVIDAD_ECONOMICA").val(row.data().CUAL_ACTVIDAD_ECONOMICA || '');
    $("#CUAL_DESCUENTOS_ECONOMICA").val(row.data().CUAL_DESCUENTOS_ECONOMICA || '');
    $("#DIAS_CREDITO_ALTA").val(row.data().DIAS_CREDITO_ALTA || '');
    $("#TERMINOS_IMPORTANCIAS_ALTA").val(row.data().TERMINOS_IMPORTANCIAS_ALTA || '');
    $("#DESCRIPCION_VINCULO").val(row.data().DESCRIPCION_VINCULO || '');
    $("#NUMERO_PROVEEDOR").val(row.data().NUMERO_PROVEEDOR || '');
    $("#ACTVIDAD_COMERCIAL").val(row.data().ACTVIDAD_COMERCIAL || '');
    
    $("#CODIGO_POSTAL").val(row.data().CODIGO_POSTAL);
    $("#TIPO_VIALIDAD_EMPRESA").val(row.data().TIPO_VIALIDAD_EMPRESA);
    $("#NOMBRE_VIALIDAD_EMPRESA").val(row.data().NOMBRE_VIALIDAD_EMPRESA);
    $("#NUMERO_EXTERIOR_EMPRESA").val(row.data().NUMERO_EXTERIOR_EMPRESA);
    $("#NUMERO_INTERIOR_EMPRESA").val(row.data().NUMERO_INTERIOR_EMPRESA);
    $("#NOMBRE_COLONIA_EMPRESA").val(row.data().NOMBRE_COLONIA_EMPRESA);
    $("#NOMBRE_LOCALIDAD_EMPRESA").val(row.data().NOMBRE_LOCALIDAD_EMPRESA);
    $("#NOMBRE_MUNICIPIO_EMPRESA").val(row.data().NOMBRE_MUNICIPIO_EMPRESA);
    $("#NOMBRE_ENTIDAD_EMPRESA").val(row.data().NOMBRE_ENTIDAD_EMPRESA);
    $("#PAIS_EMPRESA").val(row.data().PAIS_EMPRESA);
    $("#ENTRE_CALLE_EMPRESA").val(row.data().ENTRE_CALLE_EMPRESA);
    $("#ENTRE_CALLE2_EMPRESA").val(row.data().ENTRE_CALLE2_EMPRESA);
    
    $("#DOMICILIO_EXTRANJERO").val(row.data().DOMICILIO_EXTRANJERO);
    $("#CODIGO_EXTRANJERO").val(row.data().CODIGO_EXTRANJERO);
    $("#CIUDAD_EXTRANJERO").val(row.data().CIUDAD_EXTRANJERO);
    $("#ESTADO_EXTRANJERO").val(row.data().ESTADO_EXTRANJERO);
    $("#PAIS_EXTRANJERO").val(row.data().PAIS_EXTRANJERO);
    $("#DEPARTAMENTO_EXTRANJERO").val(row.data().DEPARTAMENTO_EXTRANJERO);
    $("#TIENE_ASIGNACION").val(row.data().TIENE_ASIGNACION);
    $("#PROVEEDOR_CRITICO").val(row.data().PROVEEDOR_CRITICO);
        $("#PROVEEDOR_CONTRATO").val(row.data().PROVEEDOR_CONTRATO);

    
    $(".listadedocumentoficial").empty();
    obtenerDocumentosOficiales(row);


    var verificacionSolicitada = row.data().VERIFICACION_SOLICITADA || 0;
    $("#VERIFICACION_SOLICITADA").val(verificacionSolicitada);

    if (parseInt(verificacionSolicitada) === 1) {
        $("#VALIDAR_INFORMACION_PROVEEDOR").hide();
    } else {
        $("#VALIDAR_INFORMACION_PROVEEDOR").show();
        }



    
    let actividad = $(`input[name="ACTIVIDAD_ECONOMICA"][value="${row.data().ACTIVIDAD_ECONOMICA}"]`);
    if (actividad.length) actividad.prop('checked', true);

    let descuento = $(`input[name="DESCUENTOS_ACTIVIDAD_ECONOMICA"][value="${row.data().DESCUENTOS_ACTIVIDAD_ECONOMICA}"]`);
        if (descuento.length) {
            descuento.prop('checked', true);
            if (row.data().DESCUENTOS_ACTIVIDAD_ECONOMICA == "4") {
                $("#CUAL_DESCUENTOS").show();
            } else {
                $("#CUAL_DESCUENTOS").hide();
                
            }
        }
        

    let vinculo = $(`input[name="VINCULO_FAMILIAR"][value="${row.data().VINCULO_FAMILIAR}"]`);
    if (vinculo.length) {
        vinculo.prop('checked', true);
        if (row.data().VINCULO_FAMILIAR?.toUpperCase() === "SI") {
            $("#DIV_VINCULOS").show();
        } else {
            $("#DIV_VINCULOS").hide();
        }
    }

    let servicios = $(`input[name="SERVICIOS_PEMEX"][value="${row.data().SERVICIOS_PEMEX}"]`);
    if (servicios.length) {
        servicios.prop('checked', true);
        if (row.data().SERVICIOS_PEMEX?.toUpperCase() === "SI") {
            $("#DIV_NUMEROPROVEEDOR").show();
        } else {
            $("#DIV_NUMEROPROVEEDOR").hide();   
        }
        
        }
        
        
    let beneficios = $(`input[name="BENEFICIOS_PERSONA"][value="${row.data().BENEFICIOS_PERSONA}"]`);
    if (beneficios.length) {
        beneficios.prop('checked', true);
        if (row.data().BENEFICIOS_PERSONA?.toUpperCase() === "SI") {
            $("#PERSONA_EXPUESTA").show();
        } else {
            $("#PERSONA_EXPUESTA").hide();

         }
    }
        

        $("#NOMBRE_PERSONA").val(row.data().NOMBRE_PERSONA);




    let coloniaGuardada = row.data().NOMBRE_COLONIA_EMPRESA || '';
    let codigoPostalInput = document.getElementById("CODIGO_POSTAL");

    codigoPostalInput.value = row.data().CODIGO_POSTAL || '';
    codigoPostalInput.dispatchEvent(new Event('change'));

    let coloniaSelect = document.getElementById("NOMBRE_COLONIA_EMPRESA");
    let observer = new MutationObserver(() => {
        if (coloniaSelect.options.length > 1) {
            coloniaSelect.value = coloniaGuardada;
            observer.disconnect();
        }
    });
    observer.observe(coloniaSelect, { childList: true });



    if (row.data().TIPO_PERSONA_ALTA == "1") {
        $('label[for="RFC_LABEL"]').text("R.F.C");
        $("#DOMICILIO_NACIONAL").show();
        $("#DOMICILIO_ERXTRANJERO").hide();
    } else if (row.data().TIPO_PERSONA_ALTA == "2") {
        $('label[for="RFC_LABEL"]').text("Tax ID");
        $("#DOMICILIO_NACIONAL").hide();
        $("#DOMICILIO_ERXTRANJERO").show();
    }

    actualizarStepsConRFC(rfc);

    tablacuentasCargada = false;
    tablacontactosCargada = false;
    tablacertificacionesCargada = false;
    tablareferenciasCargada = false;
    tablasoportesCargada = false;
    tablasasignacionesCargada = false;
    tablascontratoCargada = false;
    tablasfacturaCargada = false;

    $('#datosgenerales-tab').tab('show');



    $(".div_trabajador_nombre").html(row.data().RFC_ALTA);
    $(".div_trabajador_cargo").html(row.data().RAZON_SOCIAL_ALTA);




    $("#step1").click();
});


$('#Tablalistaproveedorescriticos tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablalistaproveedorescriticos.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_FORMULARIO_ALTA: row.data().ID_FORMULARIO_ALTA
    };

    eliminarDatoTabla(data, [Tablalistaproveedorescriticos], 'listaproveedorDelete');
});



function cualdescuentos() {
    var otrosCheckbox = document.getElementById('OTROS_DESCUENTO');
    var actividadDiv = document.getElementById('CUAL_DESCUENTOS');
    actividadDiv.style.display = otrosCheckbox.checked ? 'block' : 'none';
}

document.addEventListener("DOMContentLoaded", function () {
    var radios = document.getElementsByName('DESCUENTOS_ACTIVIDAD_ECONOMICA');
    radios.forEach(function (radio) {
        radio.addEventListener("change", cualdescuentos);
    });
});


function actualizarStepsConRFC(rfc) {
    $("#RFC_ALTA").val(rfc);
    rfcSeleccionada = rfc;
}


// AGREGAR DOCUEMENTO DE IDENTIFICACION OFICICAL 


document.addEventListener("DOMContentLoaded", function () {
    const botonAgregarDoc = document.getElementById('botonagregardocumentoficial');
    botonAgregarDoc.addEventListener('click', function () {
        agregarDocumento();
    });

    function agregarDocumento() {
        const divDocumentoOfi = document.createElement('div');
        divDocumentoOfi.classList.add('row', 'generardocumento', 'm-3');
        divDocumentoOfi.innerHTML = `
            <div class="col-lg-12 col-sm-1">
                <div class="form-group">
                    <h5><i class="bi bi-person"></i> Agregar documento</h5>                    
                </div>
            </div>
            <div class="col-2 mb-3">
                <label>Tipo *</label>
                <select class="form-control"  name="TIPO_DOCUMENTO_IDENTIFICACION"  required>
                    <option value="0" disabled selected>Seleccione una opción</option>
                    <option value="1">Residencia temporal</option>
                    <option value="2">Residencia Permanente</option>
                    <option value="3">Credencial para votar</option>
                    <option value="4">Pasaporte</option>
                    <option value="5">Licencia de conducir</option>
                </select>
            </div>
            <div class="col-2 mb-3">
                <label>Emitido por *</label>
                <input type="text" class="form-control" name="EMITIDO_POR_DOCUMENTO" required>
            </div> 
             <div class="col-2 mb-3">
                <label>Emisión *</label>
                <div class="input-group">
                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd"  name="EMISION_DOCUMENTO" required>
                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                </div>
            </div>
             <div class="col-2 mb-3">
                <label>Vigencia *</label>
                <div class="input-group">
                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="VIGENCIA_DOCUMENTO" name="VIGENCIA_DOCUMENTO" required>
                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                </div>
            </div>
            <div class="col-2 mb-3">
                <label>Número *</label>
                <input type="text" class="form-control" name="NUMERO_DOCUMENTO" required>
            </div>
            <div class="col-2 mb-3">
                <label>Expedido en *</label>
                <input type="text" class="form-control" name="EXPEDIDO_DOCUMENTO" required>
            </div> 
            <br>
            <div class="col-12 mt-4">
                <div class="form-group" style="text-align: center;">
                    <button type="button" class="btn btn-danger botonEliminarDocumento">Eliminar documento <i class="bi bi-trash-fill"></i></button>
                </div>
            </div>
        `;
        const contenedor = document.querySelector('.listadedocumentoficial');
        contenedor.appendChild(divDocumentoOfi);

        const botonEliminar = divDocumentoOfi.querySelector('.botonEliminarDocumento');
        botonEliminar.addEventListener('click', function () {
            contenedor.removeChild(divDocumentoOfi);
        });
    }

    $(document).on('focus', '.mydatepicker', function () {
        if (!$(this).data('datepicker')) {
            $(this).datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
                language: 'es',
            });
        }
    });
});

function obtenerDocumentosOficiales(data) {
    let row = data.data().DOCUMENTOS_JSON;
    let documentos = JSON.parse(row);
    let contadorDocumentos = 1;

    $.each(documentos, function (index, contacto) {
        let tipo = contacto.TIPO_DOCUMENTO_IDENTIFICACION;
        let emision = contacto.EMISION_DOCUMENTO;
        let vigencia = contacto.VIGENCIA_DOCUMENTO;
        let numero = contacto.NUMERO_DOCUMENTO;
        let expedido = contacto.EXPEDIDO_DOCUMENTO;
        let emitidopor = contacto.EMITIDO_POR_DOCUMENTO;


        const hoy = new Date();
        const fechaEmision = new Date(emision);
        const fechaVigencia = new Date(vigencia);

        const diasTotal = Math.ceil((fechaVigencia - fechaEmision) / (1000 * 60 * 60 * 24));
        const diasRestantes = Math.ceil((fechaVigencia - hoy) / (1000 * 60 * 60 * 24));

        let porcentajeRestante = (diasRestantes / diasTotal) * 100;
        let colorClase = "estado-verde";
        let mensajeTooltip = "";

        if (diasRestantes <= 0) {
            colorClase = "estado-rojo";
            mensajeTooltip = `Venció hace ${Math.abs(diasRestantes)} días`;
        } else {
            if (porcentajeRestante <= 20) {
                colorClase = "estado-rojo";
            } else if (porcentajeRestante <= 30) {
                colorClase = "estado-amarillo";
            }
            mensajeTooltip = `Faltan ${diasRestantes} días para que venza`;
        }

        const divDocumentoOfi = document.createElement('div');
        divDocumentoOfi.classList.add('row', 'generardocumento', 'm-3', 'p-3', 'rounded', colorClase);
        divDocumentoOfi.setAttribute('title', mensajeTooltip);

        divDocumentoOfi.innerHTML = `
            <div class="col-lg-12 col-sm-1">
                <div class="form-group d-flex align-items-center">
                    <h5><i class="bi bi-person"></i> Documento N° ${contadorDocumentos} &nbsp;</h5>
                </div>
            </div>
            <div class="col-2 mb-3">
                <label>Tipo *</label>
                <select class="form-control" name="TIPO_DOCUMENTO_IDENTIFICACION" required>
                    <option value="0" disabled>Seleccione una opción</option>
                    <option value="1" ${tipo == 1 ? 'selected' : ''}>Residencia temporal</option>
                    <option value="2" ${tipo == 2 ? 'selected' : ''}>Residencia Permanente</option>
                    <option value="3" ${tipo == 3 ? 'selected' : ''}>Credencial para votar</option>
                    <option value="4" ${tipo == 4 ? 'selected' : ''}>Pasaporte</option>
                    <option value="5" ${tipo == 5 ? 'selected' : ''}>Licencia de conducir</option>
                </select>
            </div>
            <div class="col-2 mb-3">
                <label>Emitido por *</label>
                <input type="text" class="form-control" name="EMITIDO_POR_DOCUMENTO" value="${emitidopor}" required>
            </div> 
            <div class="col-2 mb-3">
                <label>Emisión *</label>
                <div class="input-group">
                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" name="EMISION_DOCUMENTO" value="${emision}" required>
                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                </div>
            </div>
            <div class="col-2 mb-3">
                <label>Vigencia *</label>
                <div class="input-group">
                    <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" name="VIGENCIA_DOCUMENTO" value="${vigencia}" required>
                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                </div>
            </div>
            <div class="col-2 mb-3">
                <label>Número *</label>
                <input type="text" class="form-control" name="NUMERO_DOCUMENTO" value="${numero}" required>
            </div>
            <div class="col-2 mb-3">
                <label>Expedido en *</label>
                <input type="text" class="form-control" name="EXPEDIDO_DOCUMENTO" value="${expedido}" required>
            </div>
            <div class="col-12 mt-4">
                <div class="form-group text-center">
                    <button type="button" class="btn btn-danger botonEliminarDocumento">Eliminar documento <i class="bi bi-trash-fill"></i></button>
                </div>
            </div>
        `;

        const contenedor = document.querySelector('.listadedocumentoficial');
        contenedor.appendChild(divDocumentoOfi);

        // Inicializar tooltip con Bootstrap
        new bootstrap.Tooltip(divDocumentoOfi);

        contadorDocumentos++;

        const botonEliminar = divDocumentoOfi.querySelector('.botonEliminarDocumento');
        botonEliminar.addEventListener('click', function () {
            contenedor.removeChild(divDocumentoOfi);
        });
    });
}

$('#VALIDAR_INFORMACION_PROVEEDOR').on('click', function() {
    if (!rfcSeleccionada) {
        Swal.fire({
            icon: 'warning',
            title: '¡Atención!',
            text: 'No se ha seleccionado ningún RFC.'
        });
        return;
    }

    Swal.fire({
        title: '¿Quieres mandar a verificar la información?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, solicitar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/actualizarVerificacionSolicitada',
                method: 'POST',
                data: { rfc: rfcSeleccionada },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if(response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Hecho!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                        $('#VALIDAR_INFORMACION_PROVEEDOR').hide();

                        Tablalistaproveedorescriticos.ajax.reload();

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error al solicitar la verificación.'
                    });
                    console.error(xhr.responseText);
                }
            });
        }
    });
});


// <!-- ============================================================================================================================ -->
// <!--                                                          STEP 2                                                              -->
// <!-- ============================================================================================================================ -->



document.getElementById('step2').addEventListener('click', function() {
    document.querySelectorAll('[id$="-content"]').forEach(function(content) {
        content.style.display = 'none';
    });

    const step2Content = document.getElementById('step2-content');
    step2Content.style.display = 'block';

    if (tablacuentasCargada) {
        Tablacuentas.columns.adjust().draw();
    } else {
        cargarTablacuentas();
        tablacuentasCargada = true;
    }


});

const Modalcuenta = document.getElementById('miModal_cuentas');

Modalcuenta.addEventListener('hidden.bs.modal', event => {
    ID_FORMULARIO_CUENTAPROVEEDOR = 0;
    document.getElementById('formularioCuentas').reset();

    $('#DIV_EXTRAJERO').hide();
    $('#CLABE_INTERBANCARIA').show();

    document.getElementById('CARATULA_BANCARIA').value = '';
    document.getElementById('iconEliminarArchivo').classList.add('d-none');
});

$("#guardarCuentas").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario3($('#formularioCuentas'))

    if (formularioValido) {

    if (ID_FORMULARIO_CUENTAPROVEEDOR == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarCuentas')
            await ajaxAwaitFormData({ api: 2, RFC_PROVEEDOR:rfcSeleccionada, ID_FORMULARIO_CUENTAPROVEEDOR: ID_FORMULARIO_CUENTAPROVEEDOR }, 'AltaSave1', 'formularioCuentas', 'guardarCuentas', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_FORMULARIO_CUENTAPROVEEDOR = data.cuenta.ID_FORMULARIO_CUENTAPROVEEDOR
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_cuentas').modal('hide')
                    document.getElementById('formularioCuentas').reset();
                    
                    if ($.fn.DataTable.isDataTable('#Tablacuentas')) {
                        Tablacuentas.ajax.reload(null, false); 
                    }
        
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarCuentas')
            await ajaxAwaitFormData({ api: 2, RFC_PROVEEDOR: rfcSeleccionada, ID_FORMULARIO_CUENTAPROVEEDOR: ID_FORMULARIO_CUENTAPROVEEDOR }, 'AltaSave1', 'formularioCuentas', 'guardarCuentas', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_FORMULARIO_CUENTAPROVEEDOR = data.cuenta.ID_FORMULARIO_CUENTAPROVEEDOR
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_cuentas').modal('hide')
                    document.getElementById('formularioCuentas').reset();
                    if ($.fn.DataTable.isDataTable('#Tablacuentas')) {
                        Tablacuentas.ajax.reload(null, false); 
                    }


                }, 300);  
            })
        }, 1)
    }

} else {
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});

function cargarTablacuentas() {
    if ($.fn.DataTable.isDataTable('#Tablacuentas')) {
        Tablacuentas.clear().destroy();
    }

    Tablacuentas = $("#Tablacuentas").DataTable({
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
            data: { rfc: rfcSeleccionada }, 
            method: 'GET',
            cache: false,
            url: '/Tablacuentas',  
            beforeSend: function () {
                $('#loadingIcon2').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon2').css('display', 'none');
                Tablacuentas.columns.adjust().draw(); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon2').css('display', 'none');
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            },
            dataSrc: 'data'
        },
        columns: [
            { 
                data: null,
                render: function(data, type, row, meta) {
                    return meta.row + 1; 
                }
            },
            { data: 'TIPO_CUENTA' },
            { data: 'NOMBRE_BENEFICIARIO' },
            { data: 'BTN_EDITAR' },
            { data: 'BTN_VISUALIZAR' },
            { data: 'BTN_DOCUMENTO' },
            { data: 'BTN_ELIMINAR' }
        ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all  text-center' },
            { targets: 1, title: 'Tipo de cuenta', className: 'all text-center nombre-column' },
            { targets: 2, title: 'Nombre del beneficiario', className: 'all text-center nombre-column' },
            { targets: 3, title: 'Editar', className: 'all text-center' },
            { targets: 4, title: 'Visualizar', className: 'all text-center' },
            { targets: 5, title: 'Carátula bancaria', className: 'all text-center' },
            { targets: 6, title: 'Activo', className: 'all text-center' }
        ]
    });
}

$('#Tablacuentas').on('click', '.ver-archivo-caratula', function () {
    var tr = $(this).closest('tr');
    var row = Tablacuentas.row(tr).data();
    var id = $(this).data('id');

    if (!id || !row.CARATULA_BANCARIA || row.CARATULA_BANCARIA.trim() === "") {
        Swal.fire({
            icon: 'warning',
            title: 'Sin documento',
            text: 'Este registro no tiene documento.',
        });
        return;
    }

    var url = '/mostrarcaratula/' + id;
    window.open(url, '_blank');
});

$('#Tablacuentas    ').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacuentas.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_FORMULARIO_CUENTAPROVEEDOR: row.data().ID_FORMULARIO_CUENTAPROVEEDOR
    };

    eliminarDatoTabla(data, [Tablacuentas], 'CuentasDelete');
});

$('#Tablacuentas').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacuentas.row(tr);
    ID_FORMULARIO_CUENTAPROVEEDOR = row.data().ID_FORMULARIO_CUENTAPROVEEDOR;

    editarDatoTabla(row.data(), 'formularioCuentas', 'miModal_cuentas', 1);
    

     if (row.data().TIPO_CUENTA === "Extranjera") {
        $('#DIV_EXTRAJERO').show();
        $('#CLABE_INTERBANCARIA').hide();
    } else {
        $('#DIV_EXTRAJERO').hide();
        $('#CLABE_INTERBANCARIA').show();
    }
});

$(document).ready(function() {
    $('#Tablacuentas').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablacuentas.row(tr);
        
        hacerSoloLectura2(row.data(), '#miModal_cuentas');

        ID_FORMULARIO_CUENTAPROVEEDOR = row.data().ID_FORMULARIO_CUENTAPROVEEDOR;
        editarDatoTabla(row.data(), 'formularioCuentas', 'miModal_cuentas', 1);
        
          if (row.data().TIPO_CUENTA === "Extranjera") {
        $('#DIV_EXTRAJERO').show();
        $('#CLABE_INTERBANCARIA').hide();
        } else {
            $('#DIV_EXTRAJERO').hide();
            $('#CLABE_INTERBANCARIA').show();
        }
    });


    $('#miModal_cuentas').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_cuentas');
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const tipoCuentaSelect = document.querySelector('select[name="TIPO_CUENTA"]');
    const divExtranjero = document.getElementById("DIV_EXTRAJERO");
    const clabeInterbancaria = document.getElementById("CLABE_INTERBANCARIA");

    tipoCuentaSelect.addEventListener("change", function () {
        if (this.value === "Extranjera") {
            divExtranjero.style.display = "block";
            clabeInterbancaria.style.display = "none";
        } else {
            divExtranjero.style.display = "none";
            clabeInterbancaria.style.display = "block";
        }
    });
});


// // <!-- ============================================================================================================================ -->
// // <!--                                                          STEP 3                                                              -->
// // <!-- ============================================================================================================================ -->



document.getElementById('step3').addEventListener('click', function() {
    document.querySelectorAll('[id$="-content"]').forEach(function(content) {
        content.style.display = 'none';
    });

    document.getElementById('step3-content').style.display = 'block';

    if (tablacontactosCargada) {
        Tablacontactos.columns.adjust().draw();
    } else {
        cargarTablacontactos();
        tablacontactosCargada = true;
    }
  
});

$(document).ready(function () {
    var selectizeInstance = $('#FUNCIONES_CUENTA').selectize({
        placeholder: 'Seleccione una opción',
        allowEmptyOption: true,
        closeAfterSelect: true,
    });

    $("#NUEVO_CONTACTO").click(function (e) {
        e.preventDefault();

        $("#miModal_contactos").modal("show");

        document.getElementById('formularioCONTACTOS').reset();

        var selectize = selectizeInstance[0].selectize;
        selectize.clear();
        selectize.setValue(""); 


      
    });
});

const Modalcontacto = document.getElementById('miModal_contactos')
Modalcontacto.addEventListener('hidden.bs.modal', event => {
    
    
    ID_FORMULARIO_CONTACTOPROVEEDOR = 0
    document.getElementById('formularioCONTACTOS').reset();
      var selectize = $('#FUNCIONES_CUENTA')[0].selectize;
    selectize.clear(); 
    selectize.setValue("");

})

$("#guardarCONTACTOS").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioCONTACTOS'))

    if (formularioValido) {

    if (ID_FORMULARIO_CONTACTOPROVEEDOR == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarCONTACTOS')
            await ajaxAwaitFormData({ api: 3, RFC_PROVEEDOR:rfcSeleccionada,ID_FORMULARIO_CONTACTOPROVEEDOR: ID_FORMULARIO_CONTACTOPROVEEDOR }, 'AltaSave1', 'formularioCONTACTOS', 'guardarCONTACTOS', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_FORMULARIO_CONTACTOPROVEEDOR = data.cuenta.ID_FORMULARIO_CONTACTOPROVEEDOR
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_contactos').modal('hide')
                    document.getElementById('formularioCONTACTOS').reset();

                    if ($.fn.DataTable.isDataTable('#Tablacontactos')) {
                        Tablacontactos.ajax.reload(null, false); 
                    }
        
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarCONTACTOS')
            await ajaxAwaitFormData({ api: 3,RFC_PROVEEDOR:rfcSeleccionada, ID_FORMULARIO_CONTACTOPROVEEDOR: ID_FORMULARIO_CONTACTOPROVEEDOR }, 'AltaSave1', 'formularioCONTACTOS', 'guardarCONTACTOS', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_FORMULARIO_CONTACTOPROVEEDOR = data.cuenta.ID_FORMULARIO_CONTACTOPROVEEDOR
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_contactos').modal('hide')
                    document.getElementById('formularioCONTACTOS').reset();

                    if ($.fn.DataTable.isDataTable('#Tablacontactos')) {
                        Tablacontactos.ajax.reload(null, false); 
                    }

                }, 300);  
            })
        }, 1)
    }

} else {
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});

function cargarTablacontactos() {
    if ($.fn.DataTable.isDataTable('#Tablacontactos')) {
        Tablacontactos.clear().destroy();
    }

    Tablacontactos = $("#Tablacontactos").DataTable({
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
            data: { rfc: rfcSeleccionada }, 
            method: 'GET',
            cache: false,
            url: '/Tablacontactos',  
            beforeSend: function () {
                $('#loadingIcon3').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon3').css('display', 'none');
                Tablacontactos.columns.adjust().draw(); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon3').css('display', 'none');
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            },
            dataSrc: 'data'
        },
        columns: [
            { 
                data: null,
                render: function(data, type, row, meta) {
                    return meta.row + 1; 
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    return row.TITULO_CUENTA ? `${row.TITULO_CUENTA}.${row.NOMBRE_CONTACTO_CUENTA}` : row.NOMBRE_CONTACTO_CUENTA;
                }
            },
            { data: 'CARGO_CONTACTO_CUENTA' },
            { data: 'BTN_EDITAR' },
            { data: 'BTN_VISUALIZAR' },
            { data: 'BTN_ELIMINAR' }
        ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all  text-center' },
            { targets: 1, title: 'Nombre del contacto', className: 'all text-center nombre-column' },
            { targets: 2, title: 'Cargo', className: 'all text-center nombre-column' },
            { targets: 3, title: 'Editar', className: 'all text-center' },
            { targets: 4, title: 'Visualizar', className: 'all text-center' },
            { targets: 5, title: 'Activo', className: 'all text-center' }
        ]
    });
}

$('#Tablacontactos').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacontactos.row(tr);
    ID_FORMULARIO_CONTACTOPROVEEDOR = row.data().ID_FORMULARIO_CONTACTOPROVEEDOR;

    editarDatoTabla(row.data(), 'formularioCONTACTOS', 'miModal_contactos', 1);
    

     var selectize = $('#FUNCIONES_CUENTA')[0].selectize;

    if (row.data().FUNCIONES_CUENTA) {
        try {
            let ofertaArray = JSON.parse(row.data().FUNCIONES_CUENTA); 
            if (Array.isArray(ofertaArray)) {
                selectize.setValue(ofertaArray); 
            } else {
                selectize.clear();
            }
        } catch (error) {
            console.error("Error al parsear:", error);
            selectize.clear();
        }
    } else {
        selectize.clear();
    }


});

$(document).ready(function() {
    $('#Tablacontactos').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablacontactos.row(tr);
        
        hacerSoloLectura2(row.data(), '#miModal_contactos');

        ID_FORMULARIO_CONTACTOPROVEEDOR = row.data().ID_FORMULARIO_CONTACTOPROVEEDOR;
        editarDatoTabla(row.data(), 'formularioCONTACTOS', 'miModal_contactos', 1);
        
       
  var selectize = $('#FUNCIONES_CUENTA')[0].selectize;

    if (row.data().FUNCIONES_CUENTA) {
        try {
            let ofertaArray = JSON.parse(row.data().FUNCIONES_CUENTA); 
            if (Array.isArray(ofertaArray)) {
                selectize.setValue(ofertaArray); 
            } else {
                selectize.clear();
            }
        } catch (error) {
            console.error("Error al parsear:", error);
            selectize.clear();
        }
    } else {
        selectize.clear();
    }
        

    });


    $('#miModal_contactos').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_contactos');
    });
});

$('#Tablacontactos').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacontactos.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_FORMULARIO_CONTACTOPROVEEDOR: row.data().ID_FORMULARIO_CONTACTOPROVEEDOR
    };

    eliminarDatoTabla(data, [Tablacontactos], 'ContactoDelete');
});





// // <!-- ============================================================================================================================ -->
// // <!--                                                          STEP 4                                                              -->
// // <!-- ============================================================================================================================ -->

document.getElementById('step4').addEventListener('click', function() {
    document.querySelectorAll('[id$="-content"]').forEach(function(content) {
        content.style.display = 'none';
    });

    document.getElementById('step4-content').style.display = 'block';

    if (tablacertificacionesCargada) {
        Tablacertificaciones.columns.adjust().draw();
    } else {
        cargarTablacertificaciones();
        tablacertificacionesCargada = true;
    }


});

const Modalcertificacion = document.getElementById('miModal_certificaciones');

Modalcertificacion.addEventListener('hidden.bs.modal', event => {

    ID_FORMULARIO_CERTIFICACIONPROVEEDOR = 0;

    document.getElementById('formularioCertificaciones').reset();

    $('#DIV_CERTIFICACION').hide();
    $('#DIV_ACREDITACION').hide();
    $('#DIV_AUTORIZACION').hide();
    $('#DIV_MEMBRESIA').hide();

});

document.getElementById('TIPO_DOCUMENTO').addEventListener('change', function () {
    let tipo = this.value;

    resetSection('DIV_CERTIFICACION');
    resetSection('DIV_ACREDITACION');
    resetSection('DIV_MEMBRESIA');

    if (tipo === 'Certificación') {
        document.getElementById('DIV_CERTIFICACION').style.display = 'block';
    } else if (tipo === 'Acreditación') {
        document.getElementById('DIV_ACREDITACION').style.display = 'block';
    } else if (tipo === 'Membresía') {
        document.getElementById('DIV_MEMBRESIA').style.display = 'block';
    }
});

document.getElementById('REQUISITO_AUTORIZACION').addEventListener('change', function () {
    if (this.value === 'Si') {
        document.getElementById('DIV_AUTORIZACION').style.display = 'block';
    } else {
        resetSection('DIV_AUTORIZACION');
    }
});

function resetSection(divId) {
    let section = document.getElementById(divId);
    section.style.display = 'none';
    let inputs = section.querySelectorAll('input, select, textarea');
    inputs.forEach(function (input) {
        if (input.type === 'checkbox' || input.type === 'radio') {
            input.checked = false;
        } else {
            input.value = '';
        }
    });
}

$("#guardarCertificaciones").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario3($('#formularioCertificaciones'))

    if (formularioValido) {

    if (ID_FORMULARIO_CERTIFICACIONPROVEEDOR == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarCertificaciones')
            await ajaxAwaitFormData({ api: 4, RFC_PROVEEDOR:rfcSeleccionada,ID_FORMULARIO_CERTIFICACIONPROVEEDOR: ID_FORMULARIO_CERTIFICACIONPROVEEDOR }, 'AltaSave1', 'formularioCertificaciones', 'guardarCertificaciones', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_FORMULARIO_CERTIFICACIONPROVEEDOR = data.cuenta.ID_FORMULARIO_CERTIFICACIONPROVEEDOR
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_certificaciones').modal('hide')
                    document.getElementById('formularioCertificaciones').reset();
                    
                    if ($.fn.DataTable.isDataTable('#Tablacertificaciones')) {
                        Tablacertificaciones.ajax.reload(null, false); 
                    }

        
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarCertificaciones')
            await ajaxAwaitFormData({ api: 4,RFC_PROVEEDOR:rfcSeleccionada, ID_FORMULARIO_CERTIFICACIONPROVEEDOR: ID_FORMULARIO_CERTIFICACIONPROVEEDOR }, 'AltaSave1', 'formularioCertificaciones', 'guardarCertificaciones', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_FORMULARIO_CERTIFICACIONPROVEEDOR = data.cuenta.ID_FORMULARIO_CERTIFICACIONPROVEEDOR
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_certificaciones').modal('hide')
                    document.getElementById('formularioCertificaciones').reset();
                    if ($.fn.DataTable.isDataTable('#Tablacertificaciones')) {
                        Tablacertificaciones.ajax.reload(null, false); 
                    }

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});

function cargarTablacertificaciones() {
    if ($.fn.DataTable.isDataTable('#Tablacertificaciones')) {
        Tablacertificaciones.clear().destroy();
    }

    Tablacertificaciones = $("#Tablacertificaciones").DataTable({
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
            data: { rfc: rfcSeleccionada }, 
            method: 'GET',
            cache: false,
            url: '/Tablacertificaciones',  
            beforeSend: function () {
                $('#loadingIcon4').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon4').css('display', 'none');
                Tablacertificaciones.columns.adjust().draw(); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon4').css('display', 'none');
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            },
            dataSrc: 'data'
        },
        columns: [
            { 
                data: null,
                render: function(data, type, row, meta) {
                    return meta.row + 1; 
                }
            },
            { data: 'TIPO_DOCUMENTO' },
            { data: 'BTN_EDITAR' },
            { data: 'BTN_VISUALIZAR' },
            { data: 'BTN_DOCUMENTO' },
            { data: 'BTN_ELIMINAR' }
        ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all  text-center' },
            { targets: 1, title: 'Tipo ', className: 'all text-center nombre-column' },
            { targets: 2, title: 'Editar', className: 'all text-center' },
            { targets: 3, title: 'Visualizar', className: 'all text-center' },
            { targets: 4, title: 'Documentos', className: 'all text-center' },
            { targets: 5, title: 'Activo', className: 'all text-center' }
        ]
    });
}

$('#Tablacertificaciones').on('click', '.ver-archivo-certificación', function () {
    var tr = $(this).closest('tr');
    var row = Tablacertificaciones.row(tr).data();
    var id = $(this).data('id');

    if (!id || !row.DOCUMENTO_CERTIFICACION || row.DOCUMENTO_CERTIFICACION.trim() === "") {
        Swal.fire({
            icon: 'warning',
            title: 'Sin documento',
            text: 'Este registro no tiene documento.',
        });
        return;
    }

    var url = '/mostrarcertificacion/' + id;
    window.open(url, '_blank');
});

$('#Tablacertificaciones').on('click', '.ver-archivo-acreditacion', function () {
    var tr = $(this).closest('tr');
    var row = Tablacertificaciones.row(tr).data();
    var id = $(this).data('id');

    if (!id || !row.DOCUMENTO_ACREDITACION || row.DOCUMENTO_ACREDITACION.trim() === "") {
        Swal.fire({
            icon: 'warning',
            title: 'Sin documento',
            text: 'Este registro no tiene documento.',
        });
        return;
    }

    var url = '/mostraracreditacion/' + id;
    window.open(url, '_blank');
});

$('#Tablacertificaciones').on('click', '.ver-archivo-autorizacion', function () {
    var tr = $(this).closest('tr');
    var row = Tablacertificaciones.row(tr).data();
    var id = $(this).data('id');

    if (!id || !row.DOCUMENTO_AUTORIZACION || row.DOCUMENTO_AUTORIZACION.trim() === "") {
        Swal.fire({
            icon: 'warning',
            title: 'Sin documento',
            text: 'Este registro no tiene documento.',
        });
        return;
    }

    var url = '/mostrarautorizacion/' + id;
    window.open(url, '_blank');
});

$('#Tablacertificaciones').on('click', '.ver-archivo-membresia', function () {
    var tr = $(this).closest('tr');
    var row = Tablacertificaciones.row(tr).data();
    var id = $(this).data('id');

    if (!id || !row.DOCUMENTO_MEMBRESIA || row.DOCUMENTO_MEMBRESIA.trim() === "") {
        Swal.fire({
            icon: 'warning',
            title: 'Sin documento',
            text: 'Este registro no tiene documento.',
        });
        return;
    }

    var url = '/mostrarmembresia/' + id;
    window.open(url, '_blank');
});

$('#Tablacertificaciones').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacertificaciones.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_FORMULARIO_CERTIFICACIONPROVEEDOR: row.data().ID_FORMULARIO_CERTIFICACIONPROVEEDOR
    };

    eliminarDatoTabla(data, [Tablacertificaciones], 'CertificacionDelete');
});

$('#Tablacertificaciones').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacertificaciones.row(tr);

    ID_FORMULARIO_CERTIFICACIONPROVEEDOR = row.data().ID_FORMULARIO_CERTIFICACIONPROVEEDOR;

    editarDatoTabla(row.data(), 'formularioCertificaciones', 'miModal_certificaciones', 1);
    

     if (row.data().TIPO_DOCUMENTO === "Certificación") {
        $('#DIV_CERTIFICACION').show();
         $('#DIV_ACREDITACION').hide();
        $('#DIV_AUTORIZACION').hide();
        $('#DIV_MEMBRESIA').hide();
         
    } else if (row.data().TIPO_DOCUMENTO === "Acreditación") {
         $('#DIV_ACREDITACION').show();
         $('#DIV_CERTIFICACION').hide();
        $('#DIV_MEMBRESIA').hide();
         
        
     } else {
         $('#DIV_MEMBRESIA').show();
        $('#DIV_CERTIFICACION').hide();
        $('#DIV_ACREDITACION').hide();
        $('#DIV_AUTORIZACION').hide();
          
    }


    if (row.data().REQUISITO_AUTORIZACION === "Si") {
        $('#DIV_AUTORIZACION').show();
    } else {
        $('#DIV_AUTORIZACION').hide();
    }

  
});

$(document).ready(function() {
    $('#Tablacertificaciones').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablacertificaciones.row(tr);
        
        hacerSoloLectura2(row.data(), '#miModal_certificaciones');

        ID_FORMULARIO_CERTIFICACIONPROVEEDOR = row.data().ID_FORMULARIO_CERTIFICACIONPROVEEDOR;
        editarDatoTabla(row.data(), 'formularioCertificaciones', 'miModal_certificaciones', 1);
        
        if (row.data().TIPO_DOCUMENTO === "Certificación") {
            $('#DIV_CERTIFICACION').show();
             $('#DIV_ACREDITACION').hide();
            $('#DIV_AUTORIZACION').hide();
            $('#DIV_MEMBRESIA').hide();
             
        } else if (row.data().TIPO_DOCUMENTO === "Acreditación") {
             $('#DIV_ACREDITACION').show();
             $('#DIV_CERTIFICACION').hide();
            $('#DIV_MEMBRESIA').hide();
             
            
         } else {
             $('#DIV_MEMBRESIA').show();
            $('#DIV_CERTIFICACION').hide();
            $('#DIV_ACREDITACION').hide();
            $('#DIV_AUTORIZACION').hide();
              
        }
    
    
        if (row.data().REQUISITO_AUTORIZACION === "Si") {
            $('#DIV_AUTORIZACION').show();
        } else {
            $('#DIV_AUTORIZACION').hide();
        }
    
    });


    $('#miModal_certificaciones').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_certificaciones');
    });
});





// // <!-- ============================================================================================================================ -->
// // <!--                                                          STEP 5                                                              -->
// // <!-- ============================================================================================================================ -->

document.getElementById('step5').addEventListener('click', function() {
    document.querySelectorAll('[id$="-content"]').forEach(function(content) {
        content.style.display = 'none';
    });

    document.getElementById('step5-content').style.display = 'block';

    
 if (tablareferenciasCargada) {
        Tablareferencias.columns.adjust().draw();
    } else {
        cargarTablareferencias();
        tablareferenciasCargada = true;
    }
});

const Modalreferencia = document.getElementById('miModal_referencia')
Modalreferencia.addEventListener('hidden.bs.modal', event => {
    ID_FORMULARIO_REFERENCIASPROVEEDOR = 0
    document.getElementById('formularioReferencias').reset();
    
})

$("#guardarREFERENCIAS").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioReferencias'))

    if (formularioValido) {

    if (ID_FORMULARIO_REFERENCIASPROVEEDOR == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarREFERENCIAS')
            await ajaxAwaitFormData({ api: 5, RFC_PROVEEDOR:rfcSeleccionada, ID_FORMULARIO_REFERENCIASPROVEEDOR: ID_FORMULARIO_REFERENCIASPROVEEDOR }, 'AltaSave1', 'formularioReferencias', 'guardarREFERENCIAS', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_FORMULARIO_REFERENCIASPROVEEDOR = data.cuenta.ID_FORMULARIO_REFERENCIASPROVEEDOR
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_referencia').modal('hide')
                    document.getElementById('formularioReferencias').reset();

                    if ($.fn.DataTable.isDataTable('#Tablareferencias')) {
                        Tablareferencias.ajax.reload(null, false); 
                    }
        
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarREFERENCIAS')
            await ajaxAwaitFormData({ api: 5, RFC_PROVEEDOR:rfcSeleccionada,ID_FORMULARIO_REFERENCIASPROVEEDOR: ID_FORMULARIO_REFERENCIASPROVEEDOR }, 'AltaSave1', 'formularioReferencias', 'guardarREFERENCIAS', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_FORMULARIO_REFERENCIASPROVEEDOR = data.cuenta.ID_FORMULARIO_REFERENCIASPROVEEDOR
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_referencia').modal('hide')
                    document.getElementById('formularioReferencias').reset();


                    if ($.fn.DataTable.isDataTable('#Tablareferencias')) {
                        Tablareferencias.ajax.reload(null, false); 
                    }



                }, 300);  
            })
        }, 1)
    }

} else {
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});

function cargarTablareferencias() {
    if ($.fn.DataTable.isDataTable('#Tablareferencias')) {
        Tablareferencias.clear().destroy();
    }

    Tablareferencias = $("#Tablareferencias").DataTable({
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
            data: { rfc: rfcSeleccionada }, 
            method: 'GET',
            cache: false,
            url: '/Tablareferencias',  
            beforeSend: function () {
                $('#loadingIcon5').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon5').css('display', 'none');
                Tablareferencias.columns.adjust().draw(); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon5').css('display', 'none');
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            },
            dataSrc: 'data'
        },
            columns: [
                { 
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + 1; 
                    }
                },
                { data: 'NOMBRE_EMPRESA' },
                { data: 'NOMBRE_CONTACTO' },
                { data: 'CARGO_REFERENCIA' },
                { data: 'BTN_EDITAR' },
                { data: 'BTN_VISUALIZAR' },
                { data: 'BTN_ELIMINAR' }
            ],
            columnDefs: [
                { targets: 0, title: '#', className: 'all  text-center' },
                { targets: 1, title: 'Nombre de la empresa', className: 'all text-center nombre-column' },
                { targets: 2, title: 'Nombre del contacto', className: 'all text-center nombre-column' },
                { targets: 3, title: 'Cargo', className: 'all text-center nombre-column' },
                { targets: 4, title: 'Editar', className: 'all text-center' },
                { targets: 5, title: 'Visualizar', className: 'all text-center' },
                { targets: 6, title: 'Activo', className: 'all text-center' }
            ]
    });
}

$('#Tablareferencias').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablareferencias.row(tr);
    ID_FORMULARIO_REFERENCIASPROVEEDOR = row.data().ID_FORMULARIO_REFERENCIASPROVEEDOR;

    editarDatoTabla(row.data(), 'formularioReferencias', 'miModal_referencia', 1);
    

   


});

$(document).ready(function() {
    $('#Tablareferencias').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablareferencias.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_referencia');

        ID_FORMULARIO_REFERENCIASPROVEEDOR = row.data().ID_FORMULARIO_REFERENCIASPROVEEDOR;
        editarDatoTabla(row.data(), 'formularioReferencias', 'miModal_referencia', 1);
        
    });

    $('#miModal_referencia').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_referencia');
    });
});

$('#Tablareferencias').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablareferencias.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_FORMULARIO_REFERENCIASPROVEEDOR: row.data().ID_FORMULARIO_REFERENCIASPROVEEDOR
    };

    eliminarDatoTabla(data, [Tablareferencias], 'ReferenciasDelete');
});




// // <!-- ============================================================================================================================ -->
// // <!--                                                          STEP 6                                                              -->
// // <!-- ============================================================================================================================ -->


document.getElementById('step6').addEventListener('click', function() {
    document.querySelectorAll('[id$="-content"]').forEach(function(content) {
        content.style.display = 'none';
    });

    document.getElementById('step6-content').style.display = 'block';

    if (tablasoportesCargada) {
        Tabladocumentosoporteproveedores.columns.adjust().draw();
    } else {
        cargarTablasoportes();
        tablasoportesCargada = true;
    }

    
  
});

$("#NUEVO_DOCUMENTO").click(function (e) {
    e.preventDefault();

    
    $('#formularioDOCUMENTOS').each(function(){
        this.reset();
    });

    $("#miModal_documentos").modal("show");
   
    ID_FORMULARIO_DOCUMENTOSPROVEEDOR = 0;


    if (rfcSeleccionada) {
        cargarSelectDocumentosPorProveedor(rfcSeleccionada);
    }

});

const Modaldocumentos = document.getElementById('miModal_documentos');

Modaldocumentos.addEventListener('hidden.bs.modal', event => {

    ID_FORMULARIO_DOCUMENTOSPROVEEDOR = 0;

    document.getElementById('formularioDOCUMENTOS').reset();
    $('#TIPO_DOCUMENTO_PROVEEDOR').prop('disabled', false); 

    
    document.getElementById('DOCUMENTO_SOPORTE').value = '';
    document.getElementById('iconEliminarArchivo').classList.add('d-none');
    $('#miModal_documentos .modal-title').html('Nuevo documento');
 
});

$("#guardarDOCUMENTOS").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioDOCUMENTOS'))

    if (formularioValido) {

    if (ID_FORMULARIO_DOCUMENTOSPROVEEDOR == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarDOCUMENTOS')
            await ajaxAwaitFormData({ api: 6,RFC_PROVEEDOR:rfcSeleccionada, ID_FORMULARIO_DOCUMENTOSPROVEEDOR: ID_FORMULARIO_DOCUMENTOSPROVEEDOR }, 'AltaSave1', 'formularioDOCUMENTOS', 'guardarDOCUMENTOS', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_FORMULARIO_DOCUMENTOSPROVEEDOR = data.cuenta.ID_FORMULARIO_DOCUMENTOSPROVEEDOR
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_documentos').modal('hide')
                    document.getElementById('formularioDOCUMENTOS').reset();
                    if ($.fn.DataTable.isDataTable('#Tabladocumentosoporteproveedores')) {
                        Tabladocumentosoporteproveedores.ajax.reload(null, false); 
                    }
        
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarDOCUMENTOS')
            await ajaxAwaitFormData({ api: 6,RFC_PROVEEDOR:rfcSeleccionada, ID_FORMULARIO_DOCUMENTOSPROVEEDOR: ID_FORMULARIO_DOCUMENTOSPROVEEDOR }, 'AltaSave1', 'formularioDOCUMENTOS', 'guardarDOCUMENTOS', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_FORMULARIO_DOCUMENTOSPROVEEDOR = data.cuenta.ID_FORMULARIO_DOCUMENTOSPROVEEDOR
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_documentos').modal('hide')
                    document.getElementById('formularioDOCUMENTOS').reset();
                    if ($.fn.DataTable.isDataTable('#Tabladocumentosoporteproveedores')) {
                        Tabladocumentosoporteproveedores.ajax.reload(null, false); 
                    }
        

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});
  
function cargarTablasoportes() {
    if ($.fn.DataTable.isDataTable('#Tabladocumentosoporteproveedores')) {
        Tabladocumentosoporteproveedores.clear().destroy();
    }

    Tabladocumentosoporteproveedores = $("#Tabladocumentosoporteproveedores").DataTable({
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
            data: { rfc: rfcSeleccionada }, 
            method: 'GET',
            cache: false,
            url: '/Tabladocumentosoporteproveedores',  
            beforeSend: function () {
                $('#loadingIcon6').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon6').css('display', 'none');
                Tabladocumentosoporteproveedores.columns.adjust().draw(); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon6').css('display', 'none');
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            },
            dataSrc: 'data'
        },
           columns: [
        { 
            data: null,
            render: function(data, type, row, meta) {
                return meta.row + 1; 
            }
        },
        { data: 'NOMBRE_DOCUMENTO_PROVEEEDOR' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_DOCUMENTO' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Nombre del documento ', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Editar', className: 'all text-center' },
        { targets: 3, title: 'Visualizar', className: 'all text-center' },
        { targets: 4, title: 'Documentos', className: 'all text-center' },
        { targets: 5, title: 'Activo', className: 'all text-center' }
    ]
    });
}

$('#Tabladocumentosoporteproveedores').on('click', '.ver-archivo-documentosoporte', function () {
    var tr = $(this).closest('tr');
    var row = Tabladocumentosoporteproveedores.row(tr).data();
    var id = $(this).data('id');

    if (!id || !row.DOCUMENTO_SOPORTE || row.DOCUMENTO_SOPORTE.trim() === "") {
        Swal.fire({
            icon: 'warning',
            title: 'Sin documento',
            text: 'Este registro no tiene documento.',
        });
        return;
    }

    var url = '/mostrardocumentosoporteproveedor/' + id;
    window.open(url, '_blank');
});

$('#Tabladocumentosoporteproveedores').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tabladocumentosoporteproveedores.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_FORMULARIO_DOCUMENTOSPROVEEDOR: row.data().ID_FORMULARIO_DOCUMENTOSPROVEEDOR
    };

    eliminarDatoTabla(data, [Tabladocumentosoporteproveedores], 'DocumentosDelete');
});

$('#Tabladocumentosoporteproveedores').on('click', 'td>button.EDITAR', function () {
    const tr = $(this).closest('tr');
    const row = Tabladocumentosoporteproveedores.row(tr);
    const data = row.data();
    
    ID_FORMULARIO_DOCUMENTOSPROVEEDOR = data.ID_FORMULARIO_DOCUMENTOSPROVEEDOR;

    editarDatoTabla(data, 'formularioDOCUMENTOS', 'miModal_documentos', 1);

    $('#miModal_documentos .modal-title').html(data.NOMBRE_DOCUMENTO_PROVEEEDOR);

    const select = $('#TIPO_DOCUMENTO_PROVEEDOR');
    select.prop('disabled', true);

    select.empty().append(`
        <option value="${data.TIPO_DOCUMENTO_PROVEEDOR}" selected>
            ${data.NOMBRE_DOCUMENTO_PROVEEEDOR}
        </option>
    `);
});

$(document).ready(function() {
    $('#Tabladocumentosoporteproveedores').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tabladocumentosoporteproveedores.row(tr);
        const data = row.data();
        hacerSoloLectura2(row.data(), '#miModal_documentos');

        ID_FORMULARIO_DOCUMENTOSPROVEEDOR = data.ID_FORMULARIO_DOCUMENTOSPROVEEDOR;

        editarDatoTabla(data, 'formularioDOCUMENTOS', 'miModal_documentos', 1);
    
        $('#miModal_documentos .modal-title').html(data.NOMBRE_DOCUMENTO_PROVEEEDOR);
    
        const select = $('#TIPO_DOCUMENTO_PROVEEDOR');
        select.prop('disabled', true);
    
        select.empty().append(`
            <option value="${data.TIPO_DOCUMENTO_PROVEEDOR}" selected>
                ${data.NOMBRE_DOCUMENTO_PROVEEEDOR}
            </option>
        `);
    
    });


    $('#miModal_documentos').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_documentos');
    });
});

const inputArchivo = document.getElementById('DOCUMENTO_SOPORTE');
const iconEliminar = document.getElementById('iconEliminarArchivo');

inputArchivo.addEventListener('change', function () {
    if (this.files.length > 0) {
        iconEliminar.classList.remove('d-none');
    } else {
        iconEliminar.classList.add('d-none');
    }
});

iconEliminar.addEventListener('click', function () {
    inputArchivo.value = '';
    iconEliminar.classList.add('d-none');
});

document.addEventListener("DOMContentLoaded", function () {
    const selectTipoDocumento = document.getElementById("TIPO_DOCUMENTO_PROVEEDOR");
    const inputNombreDocumento = document.getElementById("NOMBRE_DOCUMENTO_PROVEEEDOR");

    if (!selectTipoDocumento || !inputNombreDocumento) return;

    selectTipoDocumento.addEventListener("change", function () {
        const selectedOption = this.options[this.selectedIndex];

        if (!selectedOption || !selectedOption.value) {
            inputNombreDocumento.value = "";
            inputNombreDocumento.readOnly = true;
            return;
        }

        if (selectedOption.value === "0") {
            // 🔹 Si selecciona "Otro": dejar vacío y editable
            inputNombreDocumento.value = "";
            inputNombreDocumento.readOnly = false;
            inputNombreDocumento.focus();
        } else {
            // 🔹 Si selecciona un documento existente: autocompletar y bloquear
            inputNombreDocumento.value = selectedOption.text.trim();
            inputNombreDocumento.readOnly = true;
        }
    });
});

function cargarSelectDocumentosPorProveedor(rfcSeleccionada) {
    if (!rfcSeleccionada) return;

    const select = document.getElementById('TIPO_DOCUMENTO_PROVEEDOR');
    const inputNombre = document.getElementById('NOMBRE_DOCUMENTO');

    if (!select) return;

    select.innerHTML = '<option value="" disabled selected>Seleccione una opción</option>';

    fetch(`/documentosProveedorAdmin/${rfcSeleccionada}`)
        .then(response => response.json())
        .then(data => {
            const obligatorios = data.catalogo.filter(doc => doc.TIPO_DOCUMENTO === "1");
            const opcionales = data.catalogo.filter(doc => doc.TIPO_DOCUMENTO === "2");

            const crearGrupo = (label, documentos) => {
                const group = document.createElement('optgroup');
                group.label = label;

                documentos.forEach(doc => {
                    const option = document.createElement('option');
                    option.value = doc.ID_CATALOGO_DOCUMENTOSPROVEEDOR;
                    option.textContent = doc.NOMBRE_DOCUMENTO;

                    if (data.registrados.includes(String(doc.ID_CATALOGO_DOCUMENTOSPROVEEDOR))) {
                        option.disabled = true;
                        option.style.color = 'green';
                        option.style.fontWeight = 'bold';
                    }

                    option.dataset.nombre = doc.NOMBRE_DOCUMENTO;

                    group.appendChild(option);
                });

                return group;
            };

            select.appendChild(crearGrupo('Documentos obligatorios', obligatorios));
            select.appendChild(crearGrupo('Documentos opcionales', opcionales));

            const optionOtro = document.createElement('option');
            optionOtro.value = "0";
            optionOtro.textContent = "Otro";
            optionOtro.style.color = 'blue';
            optionOtro.style.fontWeight = 'bold';
            select.appendChild(optionOtro);

            if (inputNombre) {
                select.addEventListener('change', function () {
                    const selectedOption = this.options[this.selectedIndex];

                    if (selectedOption.value === "0") {
                        inputNombre.readOnly = false;
                        inputNombre.value = "";
                        inputNombre.focus();
                    } else {
                        inputNombre.readOnly = true;
                        inputNombre.value = selectedOption.dataset.nombre || "";
                    }
                });
            }
        })
        .catch(err => {
            console.error('Error al cargar documentos:', err);
        });
}
    


// <!-- ============================================================================================================================ -->
// <!--                                                          STEP 7                                                              -->
// <!-- ============================================================================================================================ -->

// function activarStepsHasta(stepId) {
//     const pasos = ['step1','step2','step3','step4','step5','step6','step7'];

//     const indexActual = pasos.indexOf(stepId);
//     if (indexActual === -1) return;

//     for (let i = 0; i <= indexActual; i++) {
//         const step = document.getElementById(pasos[i]);
//         if (step && !step.classList.contains('js-active')) {
//             step.classList.add('js-active');
//         }
//     }
// }

// activarStepsHasta('step7');


// document.getElementById('step7').addEventListener('click', function(event) {
//     event.preventDefault();
//     event.stopImmediatePropagation();

//     if (!rfcSeleccionada) {
//         Swal.fire({
//             icon: 'warning',
//             title: '¡Atención!',
//             text: 'No se ha seleccionado ningún RFC.'
//         });
//         return;
//     }

//     const stepClicked = this;

//     $.ajax({
//         url: '/verificarEstadoVerificacion',
//         method: 'POST',
//         data: { rfc: rfcSeleccionada },
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         success: function(response) {
//             if (response.success) {
//                 activarStepsHasta('step7');

//                 document.querySelectorAll('[id$="-content"]').forEach(c => c.style.display = 'none');
//                 const contenido = document.getElementById(stepClicked.id + '-content');
//                 if (contenido) contenido.style.display = 'block';
//             } else {
//                 Swal.fire({
//                     icon: 'error',
//                     title: 'Acceso denegado',
//                     text: response.message || 'No puedes acceder a este paso porque no está solicitada la verificación.'
//                 });
//             }
//         },
//         error: function(xhr) {
//             Swal.fire({
//                 icon: 'error',
//                 title: 'Error',
//                 text: 'Ocurrió un error al verificar el estado de la verificación.'
//             });
//             console.error(xhr.responseText);
//         }
//     });
// });




//  (function(){
//     function setBadge(elStatus, value){
//       // Limpia clases previas
//       elStatus.innerHTML = "";
//       const span = document.createElement('span');
//       if(value === "1"){
//         span.className = "badge badge-success";
//         span.textContent = "Cumple";
//       }else if(value === "0"){
//         span.className = "badge badge-danger";
//         span.textContent = "No cumple";
//       }else{
//         span.className = "badge badge-neutral";
//         span.textContent = "Sin seleccionar";
//       }
//       elStatus.appendChild(span);
//     }

//     function initBadges(){
//       document.querySelectorAll(".verif-status").forEach(s => {
//         const v = s.getAttribute("data-value") || "";
//         setBadge(s, v);
//       });
//     }

//     function bindChanges(){
//       // Delegación en el contenedor del step 7
//       const container = document.getElementById("step7-content");
//       if(!container) return;

//       container.addEventListener("change", function(e){
//         const input = e.target;
//         if(input && input.type === "radio" && input.name.startsWith("VERIFICACIONES[")){
//           const li = input.closest(".verif-item");
//           if(!li) return;
//           const id = li.getAttribute("data-id");
//           const status = document.getElementById("status_" + id);
//           const value = input.value; // "1" ó "0"
//           setBadge(status, value);
//           status.setAttribute("data-value", value);
//         }
//       });
//     }

//     document.addEventListener("DOMContentLoaded", function(){
//       initBadges();
//       bindChanges();
//     });

   
//   })();







// <!-- ============================================================================================================================ -->
// <!--                                                          STEP 8                                                          -->
// <!-- ============================================================================================================================ -->

document.getElementById('step8').addEventListener('click', function() {
    document.querySelectorAll('[id$="-content"]').forEach(function(content) {
        content.style.display = 'none';
    });

    document.getElementById('step8-content').style.display = 'block';

    if (tablasasignacionesCargada) {
        Tablasignacionproveedorgeneral.columns.adjust().draw();
    } else {
        cargarTablasingnaciongeneralproveedor();
        tablasasignacionesCargada = true;
    }

    
  
});

const Modalasignacion = document.getElementById('modalAsignacionProveedor')
Modalasignacion.addEventListener('hidden.bs.modal', event => {

    ID_ASINGACIONES_PROVEEDORES = 0

    $('#ASIGNACIONES_ID').val('');
    $('#FIRMA_ASIGNACION').show();
    $('#SUBIR_DOCUMENTO_ASIGNACION').hide();
    $('#ASIGANCION_EPP').hide();

    window.listaEPP = [];
    $('#tablaEPPBody').empty();
    $('#EPP_JSON').val('');
})

$('#NUEVA_ASIGNACION').on('click', function () {

    document.getElementById('formularioASIGNACIONES').reset();
    ID_ASINGACIONES_PROVEEDORES = 0;


   window.listaEPP = [];
    actualizarTabla();
    $('#EPP_JSON').val('');


    $('#FIRMA_ASIGNACION').show();
    $('#SUBIR_DOCUMENTO_ASIGNACION').hide();

    $('#modalAsignacionProveedor').modal('show');

    $('#modalAsignacionProveedor').one('shown.bs.modal', function () {
        cargarTablaAsignacionesModal(); 
    });

    $('#ASIGANCION_EPP').hide();

});

function cargarTablaAsignacionesModal() {

    $('#Tablasignacionproveedor').DataTable({
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
        destroy: true,
        autoWidth: false,
        ajax: {
            url: '/Tablasignacionproveedor',
            data: function (d) {
                d.rfc = rfcSeleccionada;
            },
            complete: function (xhr) {

                const response = xhr.responseJSON;

                if (response.data && response.data.length > 0) {
                    $('#ALMACENISTA_ASIGNACION').val(
                        response.data[0].ALMACENISTA_NOMBRE
                    );
                } else {
                    $('#ALMACENISTA_ASIGNACION').val('');
                }
            }
        },
        columns: [
            {
                data: null,
                render: function (data) {
                    return `
                        <input type="checkbox"
                               class="form-check-input seleccionar-equipo"
                               value="${data.ID_ASIGNACION_FORMULARIO}">
                    `;
                },
                orderable: false
            },
            { data: 'DESCRIPCION_EQUIPO' },
            { data: 'CANTIDAD_SALIDA' },
            { data: 'MARCA_EQUIPO' },
            { data: 'MODELO_EQUIPO' },
            { data: 'SERIE_EQUIPO' },
            { data: 'CODIGO_EQUIPO' },
        ],
        columnDefs: [
            { targets: 0, title: '✔', className: 'all text-center' },
            { targets: 1, title: 'Descripción', className: 'all text-center' },
            { targets: 2, title: 'Cantidad', className: 'all text-center' },
            { targets: 3, title: 'Marca', className: 'all text-center' },
            { targets: 4, title: 'Modelo', className: 'all text-center' },
            { targets: 5, title: 'No. Serie', className: 'all text-center' },
            { targets: 6, title: 'No. Inventario', className: 'all text-center' },
        ]
    });
}

document.addEventListener("DOMContentLoaded", function () {
     const btnFirmar = document.getElementById("FIRMAR_SOLICITUD");
    const inputFirmadoPor = document.getElementById("PERSONAL_ASIGNA");

    btnFirmar.addEventListener("click", function () {
        let usuarioNombre = btnFirmar.getAttribute("data-usuario");

    
        inputFirmadoPor.value =  usuarioNombre ;
    });
});

function setAsignacionesSeleccionadas() {

    let asignaciones = [];

    $('#Tablasignacionproveedor tbody input.seleccionar-equipo:checked')
        .each(function () {
            asignaciones.push($(this).val());
        });

    $('#ASIGNACIONES_ID').val(JSON.stringify(asignaciones));
}

$("#guardarASIGNACIONES").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario3($('#formularioASIGNACIONES'))

    if (formularioValido) {


        if (ID_ASINGACIONES_PROVEEDORES == 0) {
            setAsignacionesSeleccionadas();
        }

        
    if (ID_ASINGACIONES_PROVEEDORES == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarASIGNACIONES')
            await ajaxAwaitFormData({ api: 7, RFC: rfcSeleccionada , ID_ASINGACIONES_PROVEEDORES: ID_ASINGACIONES_PROVEEDORES }, 'AltaSave1', 'formularioASIGNACIONES', 'guardarASIGNACIONES', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
                
            }, function (data) {
                    
                ID_ASINGACIONES_PROVEEDORES = data.soporte.ID_ASINGACIONES_PROVEEDORES
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#modalAsignacionProveedor').modal('hide')
                    document.getElementById('formularioASIGNACIONES').reset();

                    
                    if ($.fn.DataTable.isDataTable('#Tablasignacionproveedorgeneral')) {
                        Tablasignacionproveedorgeneral.ajax.reload(null, false); 
                    }

            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarASIGNACIONES')
            await ajaxAwaitFormData({ api: 7, RFC: rfcSeleccionada ,ID_ASINGACIONES_PROVEEDORES: ID_ASINGACIONES_PROVEEDORES }, 'AltaSave1', 'formularioASIGNACIONES', 'guardarASIGNACIONES', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
            }, function (data) {
                    
                setTimeout(() => {

                    ID_ASINGACIONES_PROVEEDORES = data.soporte.ID_ASINGACIONES_PROVEEDORES
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#modalAsignacionProveedor').modal('hide')
                    document.getElementById('formularioASIGNACIONES').reset();

                    if ($.fn.DataTable.isDataTable('#Tablasignacionproveedorgeneral')) {
                        Tablasignacionproveedorgeneral.ajax.reload(null, false); 
                    }

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});

function cargarTablasingnaciongeneralproveedor() {
    if ($.fn.DataTable.isDataTable('#Tablasignacionproveedorgeneral')) {
        Tablasignacionproveedorgeneral.clear().destroy();
    }

    Tablasignacionproveedorgeneral = $("#Tablasignacionproveedorgeneral").DataTable({
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
            data: { rfc: rfcSeleccionada },
            method: 'GET',
            cache: false,
            url: '/Tablasignacionproveedorgeneral',  
            beforeSend: function () {
                $('#loadingIcon8').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon8').css('display', 'none');
                Tablasignacionproveedorgeneral.columns.adjust().draw(); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon8').css('display', 'none');
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            },
            dataSrc: 'data'
        },
       columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                },
                className: 'text-center'
            },
           { data: 'DESCRIPCION_EQUIPO', className: 'text-center' },
            { data: 'CANTIDAD_SALIDA', className: 'text-center' },
            { data: 'MARCA_EQUIPO', className: 'text-center' },
            { data: 'MODELO_EQUIPO', className: 'text-center' },
            { data: 'SERIE_EQUIPO', className: 'text-center' },
            { data: 'CODIGO_EQUIPO', className: 'text-center' },
            {
                data: null,
                className: 'text-center',
                render: function (data, type, row) {

                    if (row.TIPO_ASIGNACION == 1) {
                        return row.DESCARGAR_FORMATOS || '';
                    }

                    if (row.TIPO_ASIGNACION == 2) {
                        return row.DESCARGAR_EPP || '';
                    }

                    return '';
                }
            },
            { data: 'BTN_DOCUMENTO', className: 'text-center' },
            { data: 'BTN_EDITAR', className: 'text-center' },
        ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all text-center' },
            { targets: 1, title: 'Descripción', className: 'all text-center' },
            { targets: 2, title: 'Cantidad', className: 'all text-center' },
            { targets: 3, title: 'Marca', className: 'all text-center' },
            { targets: 4, title: 'Modelo', className: 'all text-center' },
            { targets: 5, title: 'No. Serie', className: 'all text-center' },
            { targets: 6, title: 'No. Inventario', className: 'all text-center' },
            { targets: 7, title: 'Descargar formato', className: 'all text-center' },
            { targets: 8, title: 'Documento', className: 'all text-center' },
            { targets: 9, title: 'Editar', className: 'all text-center' },
        ],
        drawCallback: function () {

            const api = this.api();
            const rows = api.rows({ page: 'current' }).nodes();

            let lastGroup = null;
            let rowspan = 1;
            let firstRow = null;

            api.rows({ page: 'current' }).every(function (rowIdx) {

                const data = this.data();
                const grupoActual = data.GRUPO_ID;

                if (lastGroup === grupoActual) {

                    rowspan++;

                    $(rows).eq(rowIdx).find('td:eq(7)').hide();
                    $(rows).eq(rowIdx).find('td:eq(8)').hide(); 
                    $(rows).eq(rowIdx).find('td:eq(9)').hide(); 

                    $(firstRow).find('td:eq(7)').attr('rowspan', rowspan);
                    $(firstRow).find('td:eq(8)').attr('rowspan', rowspan);
                    $(firstRow).find('td:eq(9)').attr('rowspan', rowspan);

                } else {

                    lastGroup = grupoActual;
                    rowspan = 1;
                    firstRow = rows[rowIdx];

                    $(firstRow).addClass('table-light');

                    
                }
            });
        },

       
    });
}

$(document).on('click', '.descargar-asignacion', function () {
    const id = $(this).data('id');

    window.open(
        `/pdfAsignacionproveedor/${id}`,
        '_blank'
    );
});

$(document).on('click', '.descargar-epp', function () {
    const id = $(this).data('id');

    window.open(
        `/pdfAsignacionEppproveedor/${id}`,
        '_blank'
    );
});

document.addEventListener('DOMContentLoaded', function () {

    const selectTipo = document.getElementById('TIPO_ASIGNACION');
    const divEpp = document.getElementById('ASIGANCION_EPP');

    selectTipo.addEventListener('change', function () {

        if (this.value === "2") {
            divEpp.style.display = "block";
        } else {
            divEpp.style.display = "none";
        }

    });

});

const equiposPorCategoria = {
    "Cabeza": [
        "Casco contra impacto",
        "Casco dieléctrico",
        "Tafilete",
        "Barbiquejo"
    ],
    "Ojos y cara": [
        "Anteojo de protección",
        "Monogafa",
        "Marco",
        "Lente claro",
        "Lente oscuro",
        "Lente con filtro UV"
    ],
    "Oídos": [
        "Tapones auditivos desechables",
        "Tapones auditivos de nitrilo"
    ],
    "Aparato respiratorio": [
        "Respirador contra partículas",
        "Respirador de media cara",
        "Filtro contra vapor"
    ],
    "Extremidades superiores": [
        "Guante de nitrilo",
        "Guante punto PVC"
    ],
    "Tronco": [
        "Chaleco salvavidas tipo V",
        "Mandil de neopreno y/o nitrilo"
    ],
    "Extremidades inferiores": [
        "Calzado contra impactos",
        "Calzado dieléctrico Clase E",
        "Botas impermeables"
    ],
    "Dotación": [
        "Camisa manga larga",
        "Camisa manga corta",
        "Playera tipo polo",
        "Overol"
    ]
};

window.listaEPP = [];

$(document).ready(function() {

    $('#categoriaEPP').on('change', function() {
        const categoria = $(this).val();
        const equipoSelect = $('#equipoEPP');

        equipoSelect.empty();
        equipoSelect.append('<option value="">Seleccione equipo</option>');

        if (equiposPorCategoria[categoria]) {
            equiposPorCategoria[categoria].forEach(function(equipo) {
                equipoSelect.append(`<option value="${equipo}">${equipo}</option>`);
            });
        }
    });

    $('#agregarEPP').on('click', function() {

        const categoria = $('#categoriaEPP').val();
        const equipo = $('#equipoEPP').val();
        const talla = $('#tallaEPP').val();
        const solicitada = $('#cantidadSolicitada').val();
        const entregada = $('#cantidadEntregada').val();

        if (!categoria || !equipo || !solicitada) {
            alert('Complete los campos obligatorios');
            return;
        }

        const item = {
            categoria: categoria,
            equipo: equipo,
            talla: talla,
            cantidad_solicitada: solicitada,
            cantidad_entregada: entregada
        };

        listaEPP.push(item);
        actualizarTabla();
        limpiarCampos();
    });

});

function actualizarTabla() {

    const tbody = $('#tablaEPPBody');
    tbody.empty();

    listaEPP.forEach((item, index) => {

        tbody.append(`
            <tr>
                <td>${item.categoria}</td>
                <td>${item.equipo}</td>
                <td>${item.talla || 'N/A'}</td>
                <td>${item.cantidad_solicitada}</td>
                <td>${item.cantidad_entregada || 0}</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm eliminarEPP" data-index="${index}">
                         <i class="bi bi-trash3-fill"></i>
                    </button>
                </td>
            </tr>
        `);

    });

    $('#EPP_JSON').val(JSON.stringify(listaEPP));
}

$(document).on('click', '.eliminarEPP', function() {

    const index = $(this).data('index');
    listaEPP.splice(index, 1);
    actualizarTabla();

});

function limpiarCampos() {
    $('#categoriaEPP').val('');
    $('#equipoEPP').empty().append('<option value="">Seleccione equipo</option>');
    $('#tallaEPP').val('');
    $('#cantidadSolicitada').val('');
    $('#cantidadEntregada').val('');
}

$('#Tablasignacionproveedorgeneral').on('click', 'td>button.EDITAR', function () {

    var tr = $(this).closest('tr');
    var row = Tablasignacionproveedorgeneral.row(tr);

    ID_ASINGACIONES_PROVEEDORES =
        row.data().GRUPO_ID || row.data().ID_ASINGACIONES_PROVEEDORES;


    $('#FIRMA_ASIGNACION').hide();
    $('#SUBIR_DOCUMENTO_ASIGNACION').show();

    editarDatoTabla(row.data(), 'formularioASIGNACIONES', 'modalAsignacionProveedor', 1);


    $('#ASIGNACIONES_ID').val(
        JSON.stringify(row.data().ASIGNACIONES_ID || [])
    );

    $('#EPP_JSON').val(
        JSON.stringify(row.data().EPP_JSON || [])
    );

    
    if (row.data().TIPO_ASIGNACION == 2) {

        $('#ASIGANCION_EPP').show();

        let jsonEPP = row.data().EPP_JSON || [];

        try {
            window.listaEPP = Array.isArray(jsonEPP)
                ? jsonEPP
                : JSON.parse(jsonEPP);
        } catch (e) {
            console.error("Error parseando JSON EPP:", e);
            window.listaEPP = [];
        }

        actualizarTabla(); 

    } else {

        $('#ASIGANCION_EPP').hide();
        window.listaEPP = [];
        actualizarTabla();

    }
    $('#modalAsignacionProveedor').modal('show');

    $('#modalAsignacionProveedor').one('shown.bs.modal', function () {
        cargarTablaAsignacionesModalEditar(); 
    });
});

function cargarTablaAsignacionesModalEditar() {

    $('#Tablasignacionproveedor').DataTable({
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
        destroy: true,
        autoWidth: false,
        ajax: {
            url: '/TablasignacionproveedorEditar',
            data: {
                id_asignacion_contratacion: ID_ASINGACIONES_PROVEEDORES
            },
            dataSrc: 'data'
        },
        columns: [
            { 
                data: null,
                render: function(data, type, row, meta) {
                    return meta.row + 1; 
                }
            },
            { data: 'DESCRIPCION_EQUIPO' },
            { data: 'CANTIDAD_SALIDA' },
            { data: 'MARCA_EQUIPO' },
            { data: 'MODELO_EQUIPO' },
            { data: 'SERIE_EQUIPO' },
            { data: 'CODIGO_EQUIPO' }
        ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all text-center' },
            { targets: 1, title: 'Descripción', className: 'text-center' },
            { targets: 2, title: 'Cantidad', className: 'text-center' },
            { targets: 3, title: 'Marca', className: 'text-center' },
            { targets: 4, title: 'Modelo', className: 'text-center' },
            { targets: 5, title: 'No. Serie', className: 'text-center' },
            { targets: 6, title: 'No. Inventario', className: 'text-center' }
        ]
    });
}

document.addEventListener('DOMContentLoaded', function() {
    var archivoasignacion = document.getElementById('DOCUMENTO_ASIGNACION');
    var quitarasignacion = document.getElementById('quitar_asignacion');
    var errorasignacion = document.getElementById('ASIGNACION_ERROR');

    if (archivoasignacion) {
        archivoasignacion.addEventListener('change', function() {
            var archivoasignacion = this.files[0];
            if (archivoasignacion && archivoasignacion.type === 'application/pdf') {
                if (errorasignacion) errorasignacion.style.display = 'none';
                if (quitarasignacion) quitarasignacion.style.display = 'block';
            } else {
                if (errorasignacion) errorasignacion.style.display = 'block';
                this.value = '';
                if (quitarasignacion) quitarasignacion.style.display = 'none';
            }
        });
        quitarasignacion.addEventListener('click', function() {
            archivoasignacion.value = ''; 
            quitarasignacion.style.display = 'none'; 
            if (errorasignacion) errorasignacion.style.display = 'none'; 
        });
    }
});

$('#Tablasignacionproveedorgeneral').on('click', '.ver-archivo-documentoasignacion', function () {
    var tr = $(this).closest('tr');
    var row = Tablasignacionproveedorgeneral.row(tr);
    var id = $(this).data('id');

    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }

    var nombreDocumento = 'Documento de asignación';
    var url = '/mostrarasignacionproveedor/' + id;
    
    abrirModal(url, nombreDocumento);
});




// <!-- ============================================================================================================================ -->
// <!--                                                          STEP 9                                                              -->
// <!-- ============================================================================================================================ -->


document.getElementById('step9').addEventListener('click', function() {
    document.querySelectorAll('[id$="-content"]').forEach(function(content) {
        content.style.display = 'none';
    });

    document.getElementById('step9-content').style.display = 'block';

    cargarTablacontratosproveedores();

});

$("#NUEVO_CONTRATO").click(function (e) {
    e.preventDefault();

    
    $('#formularioCONTRATO').each(function(){
        this.reset();
    });

    $("#miModal_contrato").modal("show");
   
    ID_CONTRATO_PROVEEDORES = 0;

    document.getElementById('REQUIERE_ADENDA_CONTRATO').style.display = 'none';
    document.getElementById('AGREGAR_ADENDA_CONTRATO').style.display = 'none';
    $(".adendadivcontrato").empty();

});

$("#CONSECUTIVO_CONTRATO").on("change", function () {

    let valor = $(this).val();

    if (valor == "1") {
        $.get('/folioContrato', function (resp) {
            $("#NUMERO_CONTRATO_PROVEEDOR")
                .val(resp.folio)
                .prop("readonly", true);
        });

    } else if (valor == "2") {
        $("#NUMERO_CONTRATO_PROVEEDOR")
            .val("")
            .prop("readonly", false)
            .focus();
    }

});

$("#guardarCONTRATOPROVEEDOR").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario3($('#formularioCONTRATO'))

    if (formularioValido) {

    if (ID_CONTRATO_PROVEEDORES == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarCONTRATOPROVEEDOR')
            await ajaxAwaitFormData({ api: 8, RFC_PROVEEDOR:rfcSeleccionada, ID_CONTRATO_PROVEEDORES: ID_CONTRATO_PROVEEDORES }, 'AltaSave1', 'formularioCONTRATO', 'guardarCONTRATOPROVEEDOR', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                ID_CONTRATO_PROVEEDORES = data.cuenta.ID_CONTRATO_PROVEEDORES
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_contrato').modal('hide')
                    document.getElementById('formularioCONTRATO').reset();
                    
                    if ($.fn.DataTable.isDataTable('#Tablacontratosproveedores')) {
                        Tablacontratosproveedores.ajax.reload(null, false); 
                    }
            })
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarCONTRATOPROVEEDOR')
            await ajaxAwaitFormData({ api: 8, RFC_PROVEEDOR: rfcSeleccionada, ID_CONTRATO_PROVEEDORES: ID_CONTRATO_PROVEEDORES }, 'AltaSave1', 'formularioCONTRATO', 'guardarCONTRATOPROVEEDOR', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_CONTRATO_PROVEEDORES = data.cuenta.ID_CONTRATO_PROVEEDORES
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_contrato').modal('hide')
                    document.getElementById('formularioCONTRATO').reset();
                    if ($.fn.DataTable.isDataTable('#Tablacontratosproveedores')) {
                        Tablacontratosproveedores.ajax.reload(null, false); 
                    }


                }, 300);  
            })
        }, 1)
    }

} else {
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});

const Modalcontrato = document.getElementById('miModal_contrato');

Modalcontrato.addEventListener('hidden.bs.modal', event => {

    ID_CONTRATO_PROVEEDORES = 0;
    document.getElementById('formularioCONTRATO').reset();

    document.getElementById('DOCUMENTO_CONTRATO_PROVEEDOR').value = '';
    document.getElementById('DOCUEMNTO_ERROR_CONTRATO').classList.add('d-none');
    document.getElementById('quitar_contrato').classList.add('d-none');
    document.getElementById('REQUIERE_ADENDA_CONTRATO').style.display = 'none';
    document.getElementById('AGREGAR_ADENDA_CONTRATO').style.display = 'none';

    $(".adendadivcontrato").empty();

});

document.addEventListener('DOMContentLoaded', function() {
    var archivoasignacion = document.getElementById('DOCUMENTO_CONTRATO_PROVEEDOR');
    var quitarasignacion = document.getElementById('quitar_contrato');
    var errorasignacion = document.getElementById('DOCUEMNTO_ERROR_CONTRATO');

    if (archivoasignacion) {
        archivoasignacion.addEventListener('change', function() {
            var archivoasignacion = this.files[0];
            if (archivoasignacion && archivoasignacion.type === 'application/pdf') {
                if (errorasignacion) errorasignacion.style.display = 'none';
                if (quitarasignacion) quitarasignacion.style.display = 'block';
            } else {
                if (errorasignacion) errorasignacion.style.display = 'block';
                this.value = '';
                if (quitarasignacion) quitarasignacion.style.display = 'none';
            }
        });
        quitarasignacion.addEventListener('click', function() {
            archivoasignacion.value = ''; 
            quitarasignacion.style.display = 'none'; 
            if (errorasignacion) errorasignacion.style.display = 'none'; 
        });
    }
});

function cargarTablacontratosproveedores() {
    if ($.fn.DataTable.isDataTable('#Tablacontratosproveedores')) {
        Tablacontratosproveedores.clear().destroy();
    }

    Tablacontratosproveedores = $("#Tablacontratosproveedores").DataTable({
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
            data: { rfc: rfcSeleccionada }, 
            method: 'GET',
            cache: false,
            url: '/Tablacontratosproveedores',  
            beforeSend: function () {
                $('#loadingIcon10').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon10').css('display', 'none');
                Tablacontratosproveedores.columns.adjust().draw(); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon10').css('display', 'none');
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            },
            dataSrc: 'data'
        },
        columns: [
            { 
                data: null,
                render: function(data, type, row, meta) {
                    return meta.row + 1; 
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    let html = `
                        <div class="bloque-contrato p-2 mb-2 border-bottom border-secondary">
                            <strong>${row.NUMERO_CONTRATO_PROVEEDOR || 'Contrato'}</strong>
                        </div>
                    `;

                    if (row.ADENDAS && row.ADENDAS.length > 0) {
                        row.ADENDAS.forEach((adenda, index) => {
                            html += `
                                <div class="bloque-adenda-contrato p-2 mb-2 border-bottom border-secondary bg-light">
                                    <span class="text-muted">Adenda ${index + 1}</span>
                                    <div class="text-sm text-dark mt-1">${adenda.COMENTARIO_ADENDA_CONTRATO || ''}</div>
                                </div>
                            `;
                        });
                    }

                    return html;
                },
                className: 'text-center'
            },

            // { data: 'NUMERO_CONTRATO_PROVEEDOR' },
            { 
                data: null,
               render: function(data, type, row) {

                    function parseFechaLocal(fechaStr) {
                        let partes = fechaStr.split('-');
                        return new Date(partes[0], partes[1] - 1, partes[2]);
                    }

                    let fechaInicio = parseFechaLocal(row.FECHAI_CONTRATO_PROVEEDOR);
                    let fechaFin = parseFechaLocal(row.FECHAF_CONTRATO_PROVEEDOR);
                    let hoy = new Date();

                    fechaInicio.setHours(0,0,0,0);
                    fechaFin.setHours(0,0,0,0);
                    hoy.setHours(0,0,0,0);

                    let totalDias = (fechaFin - fechaInicio) / (1000 * 60 * 60 * 24);
                    let diasRestantes = Math.floor((fechaFin - hoy) / (1000 * 60 * 60 * 24));

                    if (diasRestantes < 0) diasRestantes = 0;

                    let porcentaje = 100;

                    if (totalDias > 0) {
                        let diasConsumidos = totalDias - diasRestantes;
                        porcentaje = (diasConsumidos / totalDias) * 100;
                    }

                    let estadoHTML = "";
                    let color = "";

                    if (hoy > fechaFin) {
                        estadoHTML = "<span style='color:red;'>(Terminado)</span>";
                    } 
                    else if (diasRestantes === 0) {
                        estadoHTML = "<span style='color:red;'>(Hoy vence)</span>";
                    }
                    else {

                        if (porcentaje <= 40) {
                            color = "green";
                        } else if (porcentaje <= 70) {
                            color = "orange";
                        } else {
                            color = "red";
                        }

                        estadoHTML = `<span style='color:${color};'>(${diasRestantes} días restantes)</span>`;
                    }

                    return `
                        <div>
                            ${row.FECHAI_CONTRATO_PROVEEDOR} <br> ${row.FECHAF_CONTRATO_PROVEEDOR}
                            <br>
                            ${estadoHTML}
                        </div>
                    `;
                }
            },
            { data: 'BTN_EDITAR' },
            { data: 'BTN_VISUALIZAR' },
            // { data: 'BTN_DOCUMENTO' },
            {
                data: null,
                render: function (data, type, row) {
                    let html = `
                        <div class="bloque-contrato p-2 mb-2 border-bottom border-secondary">
                            ${row.BTN_DOCUMENTO || ''}
                        </div>
                    `;

                    if (row.ADENDAS && row.ADENDAS.length > 0) {
                        row.ADENDAS.forEach(adenda => {
                            html += `
                                <div class="bloque-adenda-contrato p-2 mb-2 border-bottom border-secondary bg-light">
                                    ${adenda.BTN_DOCUMENTO || ''}
                                </div>
                            `;
                        });
                    }

                    return html;
                },
                className: 'text-center'
            },
            { data: 'BTN_ELIMINAR' }
        ],
            columnDefs: [
            { targets: 0, title: '#', className: 'all text-center' },
            { targets: 1, title: 'No de contrato / Adendas', className: 'all text-center' },
            { targets: 2, title: 'Vigencia del contrato', className: 'all text-center' },
            { targets: 3, title: 'Editar', className: 'all text-center' },
            { targets: 4, title: 'Visualizar', className: 'all text-center' },
            { targets: 5, title: 'Contrato', className: 'all text-center' },
            { targets: 6, title: 'Activo', className: 'all text-center' }
        ]
    });
}

$('#Tablacontratosproveedores').on('click', '.ver-archivo-contrato', function () {
    var tr = $(this).closest('tr');
    var row = Tablacontratosproveedores.row(tr).data();
    var id = $(this).data('id');

    if (!id || !row.DOCUMENTO_CONTRATO_PROVEEDOR || row.DOCUMENTO_CONTRATO_PROVEEDOR.trim() === "") {
        Swal.fire({
            icon: 'warning',
            title: 'Sin documento',
            text: 'Este registro no tiene documento.',
        });
        return;
    }

    var url = '/mostrarcontratoproveedor/' + id;
    window.open(url, '_blank');
});

$('#Tablacontratosproveedores').on('click', '.ver-archivo-adendacontrato', function () {
    var id = $(this).data('id');
    if (!id) {
        alert('ARCHIVO NO ENCONTRADO');
        return;
    }
    var url = '/mostraradendacontratoproveedores/' + id;
    abrirModal(url, 'Archivo adenda');
})

$('#Tablacontratosproveedores').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacontratosproveedores.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 8,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_CONTRATO_PROVEEDORES: row.data().ID_CONTRATO_PROVEEDORES
    };

    eliminarDatoTabla(data, [Tablacontratosproveedores], 'AltaDelete');
});

$('#Tablacontratosproveedores').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacontratosproveedores.row(tr);

    ID_CONTRATO_PROVEEDORES = row.data().ID_CONTRATO_PROVEEDORES;

    editarDatoTabla(row.data(), 'formularioCONTRATO', 'miModal_contrato', 1);
    
    document.getElementById('REQUIERE_ADENDA_CONTRATO').style.display = 'block';

    if (row.data().PROCEDE_ADENDA_CONTRATO == "1") {
        document.getElementById('AGREGAR_ADENDA_CONTRATO').style.display = 'block';
        document.getElementById('procedecontratosi').checked = true;
    } else if (row.data().PROCEDE_ADENDA_CONTRATO == "2") {
        document.getElementById('AGREGAR_ADENDA').style.display = 'none';
        document.getElementById('procedecontratono').checked = true;
    } else {
        document.getElementById('AGREGAR_ADENDA_CONTRATO').style.display = 'none';
        document.getElementById('procedecontratosi').checked = false;
        document.getElementById('procedecontratono').checked = false;
    }

    $(".adendacontratodiv").empty();

    if (row.data().ADENDAS && row.data().ADENDAS.length > 0) {
        obtenerAdendascontrato(row.data().ADENDAS);
    }

    if (row.data().CONSECUTIVO_CONTRATO == "1") {
        $("#NUMERO_CONTRATO_PROVEEDOR").prop("readonly", true);
        
    } else {
        $("#NUMERO_CONTRATO_PROVEEDOR").prop("readonly", false);
       
    }
});

$(document).ready(function() {
    $('#Tablacontratosproveedores').on('click', 'td>button.VISUALIZAR', function () {

        var tr = $(this).closest('tr');
        var row = Tablacontratosproveedores.row(tr);
        
        hacerSoloLectura2(row.data(), '#miModal_contrato');

        ID_CONTRATO_PROVEEDORES = row.data().ID_CONTRATO_PROVEEDORES;
        editarDatoTabla(row.data(), 'formularioCONTRATO', 'miModal_contrato', 1);


         document.getElementById('REQUIERE_ADENDA_CONTRATO').style.display = 'block';

        
        if (row.data().PROCEDE_ADENDA_CONTRATO == "1") {
            document.getElementById('AGREGAR_ADENDA_CONTRATO').style.display = 'block';
            document.getElementById('procedecontratosi').checked = true;
        } else if (row.data().PROCEDE_ADENDA_CONTRATO == "2") {
            document.getElementById('AGREGAR_ADENDA').style.display = 'none';
            document.getElementById('procedecontratono').checked = true;
        } else {
            document.getElementById('AGREGAR_ADENDA_CONTRATO').style.display = 'none';
            document.getElementById('procedecontratosi').checked = false;
            document.getElementById('procedecontratono').checked = false;
        }

        $(".adendacontratodiv").empty();

        if (row.data().ADENDAS && row.data().ADENDAS.length > 0) {
            obtenerAdendascontrato(row.data().ADENDAS);
        }

        
        
        
    });


    $('#miModal_contrato').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_contrato');
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const radioSi = document.getElementById('procedecontratosi');
    const radioNo = document.getElementById('procedecontratono');
    const agregarAdendaDiv = document.getElementById('AGREGAR_ADENDA_CONTRATO');

    function toggleAdendaDiv() {
        if (radioSi.checked) {
            agregarAdendaDiv.style.display = 'block';
        } else {
            agregarAdendaDiv.style.display = 'none';
        }
    }

    radioSi.addEventListener('change', toggleAdendaDiv);
    radioNo.addEventListener('change', toggleAdendaDiv);
});
 
document.addEventListener("DOMContentLoaded", function () {
    const botonagregarevidencia = document.getElementById('botonagregarevidenciacontrato');
    const btnVerificacion = document.getElementById('btnVerificacion');


    botonagregarevidencia.addEventListener('click', function () {
        agregarevidencia();
    });

   
function agregarevidencia() {
    const divVerificacion = document.createElement('div');
    divVerificacion.classList.add('row', 'generarverificacioncontrato', 'mb-3');
    divVerificacion.innerHTML = `
        <div class="col-12">
            <div class="row">
                <div class="col-4 mt-2">
                    <label>Fecha Inicio *</label>
                    <div class="input-group">
                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" name="FECHAI_ADENDA_CONTRATO[]">
                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                    </div>
                </div>
                <div class="col-4 mt-2">
                    <label>Fecha Fin *</label>
                    <div class="input-group">
                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" name="FECHAF_ADENDA_CONTRATO[]">
                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                    </div>
                </div>
                <div class="col-4 mt-2">
                    <label>Comentario *</label>
                    <textarea class="form-control" name="COMENTARIO_ADENDA_CONTRATO[]" rows="3"></textarea>
                </div>
                <div class="col-12 mt-2">
                    <label class="form-label">Subir documento (PDF) *</label>
                    <div class="d-flex align-items-center">
                        <input type="file" class="form-control me-2" name="DOCUMENTO_ADENDA_CONTRATO[]" accept=".pdf">
                        <button type="button" class="btn btn-warning botonEliminarArchivo" title="Eliminar archivo">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mt-4">
            <div class="form-group text-center">
                <button type="button" class="btn btn-danger botonEliminarVerificacion">Eliminar adenda <i class="bi bi-trash-fill"></i></button>
            </div>
        </div>
    `;

    const contenedor = document.querySelector('.adendacontratodiv');
    contenedor.appendChild(divVerificacion);

   
    const botonEliminar = divVerificacion.querySelector('.botonEliminarVerificacion');
    botonEliminar.addEventListener('click', function () {
        contenedor.removeChild(divVerificacion);
    });

    const botonEliminarArchivo = divVerificacion.querySelector('.botonEliminarArchivo');
    const inputArchivo = divVerificacion.querySelector('input[type="file"]');
    botonEliminarArchivo.addEventListener('click', function () {
        inputArchivo.value = '';
    });
}


});

function obtenerAdendascontrato(adendas) {
    const contenedor = document.querySelector('.adendacontratodiv');
    contenedor.innerHTML = '';

    adendas.forEach(function (item, index) {
        const divVerificacion = document.createElement('div');
        divVerificacion.classList.add('row', 'generarverificacioncontrato', 'mb-3');

        divVerificacion.innerHTML = `
            <div class="col-12 mb-2">
                <label>Adenda ${index + 1}</label>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-4 mt-2">
                        <label>Fecha Inicio *</label>
                        <div class="input-group">
                            <input type="text" class="form-control mydatepicker" name="FECHAI_ADENDA_CONTRATO[]" value="${item.FECHAI_ADENDA_CONTRATO || ''}" placeholder="aaaa-mm-dd">
                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                        </div>
                    </div>
                    <div class="col-4 mt-2">
                        <label>Fecha Fin *</label>
                        <div class="input-group">
                            <input type="text" class="form-control mydatepicker" name="FECHAF_ADENDA_CONTRATO[]" value="${item.FECHAF_ADENDA_CONTRATO || ''}" placeholder="aaaa-mm-dd" >
                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                        </div>
                    </div>
                    <div class="col-4 mt-2">
                        <label>Comentario *</label>
                        <textarea class="form-control" name="COMENTARIO_ADENDA_CONTRATO[]" rows="3">${item.COMENTARIO_ADENDA_CONTRATO || ''}</textarea>
                    </div>
                    <div class="col-12 mt-2">
                        <label class="form-label">Subir documento (PDF) *</label>
                        <div class="d-flex align-items-center">
                            <input type="file" class="form-control me-2" name="DOCUMENTO_ADENDA_CONTRATO[]" accept=".pdf">
                            <button type="button" class="btn btn-warning botonEliminarArchivo" title="Eliminar archivo">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-4">
                <div class="form-group text-center">
                    <button type="button" class="btn btn-danger botonEliminarVerificacion">Eliminar adenda <i class="bi bi-trash-fill"></i></button>
                </div>
            </div>
        `;

        contenedor.appendChild(divVerificacion);

        const botonEliminar = divVerificacion.querySelector('.botonEliminarVerificacion');
        botonEliminar.addEventListener('click', function () {
            contenedor.removeChild(divVerificacion);
        });

        const botonEliminarArchivo = divVerificacion.querySelector('.botonEliminarArchivo');
        const inputArchivo = divVerificacion.querySelector('input[type="file"]');
        botonEliminarArchivo.addEventListener('click', function () {
            inputArchivo.value = '';
        });
    });
}


// <!-- ============================================================================================================================ -->
// <!--                                                          STEP 10                                                              -->
// <!-- ============================================================================================================================ -->



document.getElementById('step10').addEventListener('click', function() {
    document.querySelectorAll('[id$="-content"]').forEach(function(content) {
        content.style.display = 'none';
    });

    document.getElementById('step10-content').style.display = 'block';

    cargarTablafacturaproveedores();

});

function cargarTablafacturaproveedores() {
    if ($.fn.DataTable.isDataTable('#Tablafacturaproveedoresinterno')) {
        Tablafacturaproveedoresinterno.clear().destroy();
    }

    Tablafacturaproveedoresinterno = $("#Tablafacturaproveedoresinterno").DataTable({
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
            data: { rfc: rfcSeleccionada }, 
            method: 'GET',
            cache: false,
            url: '/Tablafacturaproveedoresinterno',  
            beforeSend: function () {
                $('#loadingIcon11').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon11').css('display', 'none');
                Tablafacturaproveedoresinterno.columns.adjust().draw(); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon11').css('display', 'none');
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            },
            dataSrc: 'data'
        },
        columns: [
        { 
            data: null,
            render: function(data, type, row, meta) {
                return meta.row + 1; 
            }
        },
        { data: 'TIPO_FACTURA_FORMATO' },
        {
            data: null,
            render: function (data, type, row) {
                if (row.FOLIO_FISCAL === null || row.FOLIO_FISCAL === '') {
                    return row.NO_FACTURA_EXTRANJERO;
                }
                return row.FOLIO_FISCAL;
            }
            },
          {
            data: null,
            render: function (data, type, row) {
                if (row.FECHA_FACTURA === null || row.FECHA_FACTURA === '') {
                    return row.FECHA_FACTURA_EXTRANJERO;
                }
                return row.FECHA_FACTURA;
            }
        },
        {
            data: 'created_at',
            render: function (data) {
                if (!data) return '';
                return data.substring(0, 10);
            }
        },
        {
            data: null,
            render: function (data, type, row) {
                if (!row.DOCUMENTOS_SOPORTE_FACTURA || row.DOCUMENTOS_SOPORTE_FACTURA.trim() === '') {
                    return 'N/A';
                }
                return row.BTN_SOPORTES;
            }
        },
        { data: 'BTN_FACTURA' },
        { data: 'ESTADO_FACTURA_TEXTO' },
        { data: 'BTN_VISUALIZAR' },
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Factura por', className: 'all text-center nombre-column' },
        { targets: 2, title: 'No. Factura', className: 'all text-center nombre-column' },
        { targets: 3, title: 'Fecha factura', className: 'all text-center nombre-column' },
        { targets: 4, title: 'Fecha de recepción', className: 'all text-center nombre-column' },
        { targets: 5, title: 'Soporte', className: 'all text-center nombre-column' },
        { targets: 6, title: 'Factura', className: 'all text-center nombre-column' },
        { targets: 7, title: 'Estatus', className: 'all text-center nombre-column' },
        { targets: 8, title: 'Visualizar', className: 'all text-center nombre-column' },
    ]
    });
}


$('#Tablafacturaproveedoresinterno').on('click', '.ver-archivo-soportes', function () {
    var tr = $(this).closest('tr');
    var row = Tablafacturaproveedoresinterno.row(tr).data();
    var id = $(this).data('id');

    if (!id || !row.DOCUMENTOS_SOPORTE_FACTURA || row.DOCUMENTOS_SOPORTE_FACTURA.trim() === "") {
        Swal.fire({
            icon: 'warning',
            title: 'Sin documento',
            text: 'Este registro no tiene documento.',
        });
        return;
    }

    var url = '/mostrarsoportefactura/' + id;
    window.open(url, '_blank');
});

$('#Tablafacturaproveedoresinterno').on('click', '.ver-archivo-factura', function () {
    var tr = $(this).closest('tr');
    var row = Tablafacturaproveedoresinterno.row(tr).data();
    var id = $(this).data('id');

    if (!id || !row.FACTURA_PDF || row.FACTURA_PDF.trim() === "") {
        Swal.fire({
            icon: 'warning',
            title: 'Sin documento',
            text: 'Este registro no tiene documento.',
        });
        return;
    }

    var url = '/mostrarfactura/' + id;
    window.open(url, '_blank');
});

const Modalfactura = document.getElementById('modalDetalleFactura')
Modalfactura.addEventListener('hidden.bs.modal', event => {
    
    document.getElementById('formularioFACTURA').reset();
    document.getElementById('ID_FORMULARIO_FACTURACION').value = "0"; 


     $('#verXML').addClass('d-none');
            $('#verSoportePDF').addClass('d-none');    
            $('#verSoportePDF').addClass('d-none');    
            $('#verSoportePDF').addClass('d-none');    

    
    
})

$(document).on('click', '.VISUALIZAR', function () {

    let tr = $(this).closest('tr');
    let row = Tablafacturaproveedoresinterno.row(tr).data();

    let id = row.ID_FORMULARIO_FACTURACION;


    
    $.get('/obtenerDetalleFactura', { id: id }, function (res) {

        let f = res.factura;
        let tipo = res.tipoProveedor;

        $('#camposFactura, #camposFacturaExtranjero, #seccionREP, #seccionReciboPago')
            .addClass('d-none');

        
        $('#verReciboPago')
        .addClass('d-none')
        .attr('href', '');

        $('#RECIBO_PAGO').val('');
        

        $('#ID_FORMULARIO_FACTURACION').val(f.ID_FORMULARIO_FACTURACION);
        

        $('#contenedorOC, #contenedorCONTRATO').addClass('d-none');

        $('#contenedorOC input, #contenedorCONTRATO input').prop('required', false);


        if (f.TIPO_FACTURA === 'OC') {

            $('#contenedorOC').removeClass('d-none');

            $('#NO_PO').val(f.NO_PO);
            $('#NO_GR').val(f.NO_GR);

            $('#NO_PO, #NO_GR').prop('required', true);

        } else if (f.TIPO_FACTURA === 'CONTRATO') {

            $('#contenedorCONTRATO').removeClass('d-none');

            $('#NO_CONTRATO').val(f.NO_CONTRATO);
            $('#NO_CONTRATO').prop('required', true);
        }

        
        if (tipo == 1) {
            toggleCamposFactura(1);

            $('#camposFactura').removeClass('d-none');
            $('#FOLIO_FISCAL').val(f.FOLIO_FISCAL);
            $('#FECHA_FACTURA').val(f.FECHA_FACTURA);
            $('#METODO_PAGO').val(f.METODO_PAGO);
            $('#MONEDA_FACTURA').val(f.MONEDA_FACTURA);
            $('#SUBTOTAL_FACTURA').val(f.SUBTOTAL_FACTURA);
            $('#IVA_FACTURA').val(f.IVA_FACTURA);
            $('#TOTAL_FACTURA').val(f.TOTAL_FACTURA);
            $('#verXML').removeClass('d-none');
            $('#verSoportePDF').removeClass('d-none');


         } else if (tipo == 2) {
             toggleCamposFactura(2);

            $('#camposFacturaExtranjero').removeClass('d-none');
            $('#NO_FACTURA_EXTRANJERO').val(f.NO_FACTURA_EXTRANJERO);
            $('#FECHA_FACTURA_EXTRANJERO').val(f.FECHA_FACTURA_EXTRANJERO);
            $('#MONEDA_FACTURA_EXTRANJERO').val(f.MONEDA_FACTURA_EXTRANJERO);
            $('#SUBTOTAL_FACTURA_EXTRANJERO').val(f.SUBTOTAL_FACTURA_EXTRANJERO);
            $('#IVA_FACTURA_EXTRANJERO').val(f.IVA_FACTURA_EXTRANJERO);
            $('#TOTAL_FACTURA_EXTRANJERO').val(f.TOTAL_FACTURA_EXTRANJERO);
            $('#verXML').addClass('d-none');
            $('#verSoportePDF').addClass('d-none');


            
        }


        if (f.ESTATUS_FACTURA == 1) { 
            $('#MOTIVO_RECHAZO_JEFE_DIV').hide();
        } else if (f.ESTATUS_FACTURA == 2) {
            $('#MOTIVO_RECHAZO_JEFE_DIV').show();
        } else {
            $('#MOTIVO_RECHAZO_JEFE_DIV').hide();
        }


        $('#MOTIVO_RECHAZO_FACTURA').val(f.MOTIVO_RECHAZO_FACTURA);
        



        $('#verFacturaPDF').attr('href', '/mostrarfactura/' + f.ID_FORMULARIO_FACTURACION);
        $('#verSoportePDF').attr('href', '/mostrarsoportefactura/' + f.ID_FORMULARIO_FACTURACION);

        $('#verXML').attr('href', '/verXMLFactura/' + f.ID_FORMULARIO_FACTURACION + '?download=1');

        $('#ESTATUS_FACTURA').val(f.ESTATUS_FACTURA ?? '');

        if (
            tipo == 1 &&
            f.METODO_PAGO == 'PPD' &&
            f.ESTATUS_FACTURA == 1 &&
            f.SUBIR_REP == 1
        ) {
            $('#seccionREP').removeClass('d-none');

            $('#verREP').attr('href', '/mostrareciboelectronico/' + f.ID_FORMULARIO_FACTURACION);

            $('#verXMLREP').attr('href', '/verXMLREP/' + f.ID_FORMULARIO_FACTURACION + '?download=1');

            $('#ESTATUS_REP').val(f.ESTATUS_REP ?? '');
        }

            $('#SUBIR_RECIBO_PAGO').val(f.SUBIR_RECIBO_PAGO ?? '');

            if (f.SUBIR_RECIBO_PAGO == 1) {

                $('#seccionReciboPago').removeClass('d-none');

                if (f.ARCHIVO_RECIBO_PAGO) {

                    $('#verReciboPago')
                        .removeClass('d-none')
                        .attr('href', '/mostrarecibodepago/' + f.ID_FORMULARIO_FACTURACION);

                    $('#RECIBO_PAGO').hide();

                } else {

                    $('#RECIBO_PAGO').show();
                    $('#verReciboPago').addClass('d-none');
                }

            } else {

                $('#seccionReciboPago').addClass('d-none');
            }
        $('#modalDetalleFactura').modal('show');
    });
});

$(document).on('change', '#SUBIR_RECIBO_PAGO', function () {

    let valor = $(this).val();

    if (valor == '1') {
        $('#seccionReciboPago').removeClass('d-none');
    } else {
        $('#seccionReciboPago').addClass('d-none');
        $('#RECIBO_PAGO').val('');
        $('#verReciboPago').addClass('d-none');
    }
});

$("#btnGuardarFactura").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario3($('#formularioFACTURA'))

    if (formularioValido) {

    if (ID_FORMULARIO_FACTURACION == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('btnGuardarFactura')
            await ajaxAwaitFormData({ api: 9,RFC_PROVEEDOR: rfcSeleccionada, ID_FORMULARIO_FACTURACION: ID_FORMULARIO_FACTURACION }, 'AltaSave1', 'formularioFACTURA', 'btnGuardarFactura', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_FORMULARIO_FACTURACION = data.cuenta.ID_FORMULARIO_FACTURACION
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#modalDetalleFactura').modal('hide')
                    document.getElementById('formularioFACTURA').reset();
                    Tablafacturaproveedoresinterno.ajax.reload()

            })
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('btnGuardarFactura')
            await ajaxAwaitFormData({ api: 9,RFC_PROVEEDOR: rfcSeleccionada, ID_FORMULARIO_FACTURACION: ID_FORMULARIO_FACTURACION }, 'AltaSave1', 'formularioFACTURA', 'btnGuardarFactura', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_FORMULARIO_FACTURACION = data.cuenta.ID_FORMULARIO_FACTURACION
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#modalDetalleFactura').modal('hide')
                    document.getElementById('formularioFACTURA').reset();
                    Tablafacturaproveedoresinterno.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});

function toggleCamposFactura(tipo) {

    if (tipo == 1) {
        $('#camposFactura').removeClass('d-none');
        $('#camposFacturaExtranjero').addClass('d-none');

        $('#camposFactura input').prop('required', true);

        $('#camposFacturaExtranjero input').prop('required', false);

    } else if (tipo == 2) {
        $('#camposFacturaExtranjero').removeClass('d-none');
        $('#camposFactura').addClass('d-none');

        $('#camposFacturaExtranjero input').prop('required', true);

        $('#camposFactura input').prop('required', false);
    }
}

