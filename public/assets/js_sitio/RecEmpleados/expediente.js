//VARIABLES GLOBALES
var curpSeleccionada; 
var contrato_id = null; 

var documento_id = null; 

// ID DE LOS FORMULARIOS 
ID_FORMULARIO_CONTRATACION = 0;
ID_DOCUMENTO_SOPORTE = 0;
ID_CONTRATOS_ANEXOS = 0;
ID_DOCUMENTO_COLABORADOR_CONTRATO = 0;
ID_CV_CONTRATACION = 0;
ID_INFORMACION_MEDICA = 0;
ID_INCIDENCIAS = 0 ;
ID_ACCIONES_DISCIPLINARIAS = 0;
ID_RECIBOS_NOMINA = 0;
ID_SOPORTE_CONTRATO = 0;
ID_RENOVACION_CONTATO = 0;
ID_CONTRATACION_REQUERIMIENTO = 0;


ID_DOCUMENTOS_ACTUALIZADOS = 0;


// TABLAS
Tablaexpediente = null


var Tablacontratacion1;
var tablacontracion1Cargada = false; 


var Tabladocumentosoportexpediente;
var tablaDocumentosCargada = false; 


var Tablasoportecontrato;
var tablasoportecontratoCargada = false; 


var Tablacontratosyanexos;
var tablacontratosCargada = false; 

var Tablarequisicioncontratacion;
var tablarequisiconCargada = false; 

var Tablacvs;
var tablaCVCargada = false; 











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

        $('#contratosdoc-tab').closest('li').css("display", 'none');
    });

});












var Tablaexpediente = $("#Tablaexpediente").DataTable({
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
    ajax: {
        dataType: 'json',
        data: {},
        method: 'GET',
        cache: false,
        url: '/Tablaexpediente',
        beforeSend: function () {
            $('#loadingIcon8').css('display', 'inline-block');
        },
        complete: function () {
            $('#loadingIcon8').css('display', 'none');
            Tablaexpediente.columns.adjust().draw(); 
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('#loadingIcon8').css('display', 'none');
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
    order: [[0, 'asc']],
    columns: [
        {
            data: null,
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        {
            data: null,
            render: function (data, type, row) {
                return row.NOMBRE_COLABORADOR + ' ' + row.PRIMER_APELLIDO + ' ' + row.SEGUNDO_APELLIDO;
            }
        },
        { data: 'CURP' },
        { data: 'NUMERO_EMPLEADO' },
        { data: 'BTN_EDITAR' }
    ],
    
    columnDefs: [
        { targets: 0, title: '#', className: 'all text-center' },
        { targets: 1, title: 'Nombre del colaborador', className: 'all text-center nombre-column' },
        { targets: 2, title: 'CURP', className: 'all text-center' },
        { targets: 3, title: 'No. empleado', className: 'all text-center' },
        { targets: 4, title: 'Mostrar', className: 'all text-center' }
    ]
});

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    var target = $(e.target).attr("href"); 
    if (target === '#contratos') {
        Tablaexpediente.columns.adjust().draw(); 
    }
    
});

function reloadTablaContratacion() {
    Tablaexpediente.ajax.reload(null, false); 
}







// <!-- ============================================================================================================================ -->
// <!--                                                          STEP 1                                                              -->
// <!-- ============================================================================================================================ -->


document.getElementById('step1').addEventListener('click', function() {
    document.querySelectorAll('[id$="-content"]').forEach(function(content) {
        content.style.display = 'none';
    });

    document.getElementById('step1-content').style.display = 'block';
});




function obtenerCargo() {
    $.ajax({
        url: '/obtenerUltimoCargo', 
        method: 'POST',
        data: {
            curp: curpSeleccionada,
            _token: $('meta[name="csrf-token"]').attr('content') 
        },
        success: function(response) {
            if (response.cargo) {
                $(".div_trabajador_cargo").html(`<span class="text-primary" style="color: #AAAAAA; font-size: 12px;">${response.cargo}</span>`);
            } else {
                $(".div_trabajador_cargo").html(`<span class="text-primary" style="color: #AAAAAA; font-size: 12px;">No disponible</span>`);
            }
        },
        error: function() {
            console.error("Error al obtener el cargo.");
            $(".div_trabajador_cargo").html(`<span class="text-primary" style="color: #AAAAAA; font-size: 12px;">Error al cargar</span>`);
        }
    });
}

$("#guardarDatosGenerales").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormularioV1('FormularioCONTRATACION');

    if (formularioValido) {
        var beneficiarios = [];
        $(".generarlistadebeneficiario").each(function() {
            var beneficiario = {
                'NOMBRE_BENEFICIARIO': $(this).find("input[name='NOMBRE_BENEFICIARIO']").val(),
                'PARENTESCO_BENEFICIARIO': $(this).find("input[name='PARENTESCO_BENEFICIARIO']").val(),
                'PORCENTAJE_BENEFICIARIO': $(this).find("input[name='PORCENTAJE_BENEFICIARIO']").val(),
                'TELEFONO1_BENEFICIARIO': $(this).find("input[name='TELEFONO1_BENEFICIARIO']").val(),
                'TELEFONO2_BENEFICIARIO': $(this).find("input[name='TELEFONO2_BENEFICIARIO']").val()
            };
            beneficiarios.push(beneficiario);
        });


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
            ID_FORMULARIO_CONTRATACION: ID_FORMULARIO_CONTRATACION,
            BENEFICIARIOS_JSON: JSON.stringify(beneficiarios),
            DOCUMENTOS_JSON: JSON.stringify(documentos)

        };

        if (ID_FORMULARIO_CONTRATACION == 0) {
            alertMensajeConfirm({
                title: "¿Desea guardar la información?",
                text: "Al guardarla, se podrá usar",
                icon: "question",
            }, async function () {

                await loaderbtn('guardarDatosGenerales');
                await ajaxAwaitFormData(requestData, 'ExpedienteSave', 'FormularioCONTRATACION', 'guardarDatosGenerales', { callbackAfter: true, callbackBefore: true }, () => {
                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');
                    
                }, function (data) {
                    curpSeleccionada = data.contrato.CURP;
                    ID_FORMULARIO_CONTRATACION = data.contrato.ID_FORMULARIO_CONTRATACION;
                    $('#step2').css("display", "flex");
                   

                    alertMensaje('success', 'Información guardada correctamente', 'Esta información está lista para usarse', null, null, 1500);
                    Tablaexpediente.ajax.reload();
                });
            }, 1);
            
        } else {
            alertMensajeConfirm({
                title: "¿Desea editar la información de este formulario?",
                text: "Al guardarla, se podrá usar",
                icon: "question",
            }, async function () {

                await loaderbtn('guardarDatosGenerales');
                await ajaxAwaitFormData(requestData, 'ExpedienteSave', 'FormularioCONTRATACION', 'guardarDatosGenerales', { callbackAfter: true, callbackBefore: true }, () => {
                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });

                    $('.swal2-popup').addClass('ld ld-breath');

                }, function (data) {
                    setTimeout(() => {
                        ID_FORMULARIO_CONTRATACION = data.contrato.ID_FORMULARIO_CONTRATACION;
                        alertMensaje('success', 'Información editada correctamente', 'Información guardada');
                        Tablaexpediente.ajax.reload();
                    }, 300);
                });
            }, 1);
        }
    } else {
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000);
    }
});

$('#Tablaexpediente tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablaexpediente.row(tr);
    ID_FORMULARIO_CONTRATACION = row.data().ID_FORMULARIO_CONTRATACION;



    
    $('#FormularioCONTRATACION').each(function() {
        this.reset();
    });

    $('#datosgenerales-tab').closest('li').css("display", 'block');
    $('#step2').css("display", "flex");

    $('#step1-content').css("display", 'block');
    $('#step2-content').css("display", 'none');


    $('#DESCARGAR_CREDENCIAL').css("display", 'none');


    
    if (row.data().FOTO_USUARIO) {
        var archivo = row.data().FOTO_USUARIO;
        var extension = archivo.substring(archivo.lastIndexOf("."));
        var imagenUrl = '/usuariocolaborador/' + row.data().ID_FORMULARIO_CONTRATACION + extension;

        if ($('#FOTO_USUARIO').data('dropify')) {
            $('#FOTO_USUARIO').dropify().data('dropify').destroy();
            $('#FOTO_USUARIO').dropify().data('dropify').settings.defaultFile = imagenUrl;
            $('#FOTO_USUARIO').dropify().data('dropify').init();
        } else {
            $('#FOTO_USUARIO').attr('data-default-file', imagenUrl);
            $('#FOTO_USUARIO').dropify({
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
                    'maxHeight': 'Alto demasiado grande (max {{ value }}px max).',
                    'imageFormat': 'Formato no permitido, sólo ({{ value }}).'
                }
            });
        }
    } else {
        $('#FOTO_USUARIO').dropify().data('dropify').resetPreview();
        $('#FOTO_USUARIO').dropify().data('dropify').clearElement();
    }

    var curp = row.data().CURP;
    $("#CURP").val(curp);
    curpSeleccionada = curp;

    $("#NOMBRE_COLABORADOR").val(row.data().NOMBRE_COLABORADOR);
    $("#PRIMER_APELLIDO").val(row.data().PRIMER_APELLIDO);
    $("#SEGUNDO_APELLIDO").val(row.data().SEGUNDO_APELLIDO);
    $("#INICIALES_COLABORADOR").val(row.data().INICIALES_COLABORADOR);
    $("#NUMERO_EMPLEADO").val(row.data().NUMERO_EMPLEADO);

    $("#DIA_COLABORADOR").val(row.data().DIA_COLABORADOR);
    $("#MES_COLABORADOR").val(row.data().MES_COLABORADOR);
    $("#ANIO_COLABORADOR").val(row.data().ANIO_COLABORADOR);
    $("#LUGAR_NACIMIENTO").val(row.data().LUGAR_NACIMIENTO);
    $("#TELEFONO_COLABORADOR").val(row.data().TELEFONO_COLABORADOR);
    $("#CORREO_COLABORADOR").val(row.data().CORREO_COLABORADOR);
    $("#ESTADO_CIVIL").val(row.data().ESTADO_CIVIL);
    $("#RFC_COLABORADOR").val(row.data().RFC_COLABORADOR);
    $("#VIGENCIA_INE").val(row.data().VIGENCIA_INE);
    $("#NSS_COLABORADOR").val(row.data().NSS_COLABORADOR);
    $("#TIPO_SANGRE").val(row.data().TIPO_SANGRE);
    $("#ALERGIAS_COLABORADOR").val(row.data().ALERGIAS_COLABORADOR);
    $("#CALLE_COLABORADOR").val(row.data().CALLE_COLABORADOR);
    $("#COLONIA_COLABORADOR").val(row.data().COLONIA_COLABORADOR);
    $("#CODIGO_POSTAL").val(row.data().CODIGO_POSTAL);

    $("#CIUDAD_COLABORADOR").val(row.data().CIUDAD_COLABORADOR);
    $("#ESTADO_COLABORADOR").val(row.data().ESTADO_COLABORADOR);
    $("#NOMBRE_EMERGENCIA").val(row.data().NOMBRE_EMERGENCIA);
    $("#PARENTESCO_EMERGENCIA").val(row.data().PARENTESCO_EMERGENCIA);
    $("#TELEFONO1_EMERGENCIA").val(row.data().TELEFONO1_EMERGENCIA);
    $("#TELEFONO2_EMERGENCIA").val(row.data().TELEFONO2_EMERGENCIA);
    $("#NOMBRE_BENEFICIARIO").val(row.data().NOMBRE_BENEFICIARIO);
    $("#PARENTESCO_BENEFICIARIO").val(row.data().PARENTESCO_BENEFICIARIO);
    $("#PORCENTAJE_BENEFICIARIO").val(row.data().PORCENTAJE_BENEFICIARIO);
    $("#TELEFONO1_BENEFICIARIO").val(row.data().TELEFONO1_BENEFICIARIO);
    $("#TELEFONO2_BENEFICIARIO").val(row.data().TELEFONO2_BENEFICIARIO);


    $("#PAIS_CONTRATACION").val(row.data().PAIS_CONTRATACION);


    $("#CIUDAD_LUGAR_NACIMIENTO").val(row.data().CIUDAD_LUGAR_NACIMIENTO);
    $("#ESTADO_LUGAR_NACIMIENTO").val(row.data().ESTADO_LUGAR_NACIMIENTO);
    $("#PAIS_LUGAR_NACIMIENTO").val(row.data().PAIS_LUGAR_NACIMIENTO);
    $("#TIPO_DOCUMENTO_IDENTIFICACION").val(row.data().TIPO_DOCUMENTO_IDENTIFICACION);
    $("#EMISION_DOCUMENTO").val(row.data().EMISION_DOCUMENTO);
    $("#VIGENCIA_DOCUMENTO").val(row.data().VIGENCIA_DOCUMENTO);
    $("#NUMERO_DOCUMENTO").val(row.data().NUMERO_DOCUMENTO);
    $("#EXPEDIDO_DOCUMENTO").val(row.data().EXPEDIDO_DOCUMENTO);
    $("#CALLE1_COLABORADOR").val(row.data().CALLE1_COLABORADOR);
    $("#CALLE2_COLABORADOR").val(row.data().CALLE2_COLABORADOR);

    $("#TIPO_VIALIDAD").val(row.data().TIPO_VIALIDAD);
    $("#NOMBRE_VIALIDAD").val(row.data().NOMBRE_VIALIDAD);
    $("#NUMERO_EXTERIOR").val(row.data().NUMERO_EXTERIOR);
    $("#NUMERO_INTERIOR").val(row.data().NUMERO_INTERIOR);
    $("#NOMBRE_COLONIA").val(row.data().NOMBRE_COLONIA);
    $("#NOMBRE_LOCALIDAD").val(row.data().NOMBRE_LOCALIDAD);
    $("#NOMBRE_MUNICIPIO").val(row.data().NOMBRE_MUNICIPIO);
    $("#NOMBRE_ENTIDAD").val(row.data().NOMBRE_ENTIDAD);
    $("#ENTRE_CALLE").val(row.data().ENTRE_CALLE);
    $("#ENTRE_CALLE_2").val(row.data().ENTRE_CALLE_2);



   

    if (row.data().CODIGO_POSTAL) {
        fetch(`/codigo-postal/${row.data().CODIGO_POSTAL}`)
            .then(response => response.json())
            .then(data => {
                if (!data.error) {
                    let response = data.response;

                    let coloniaSelect = document.getElementById("NOMBRE_COLONIA");
                    coloniaSelect.innerHTML = '<option value="">Seleccione una opción</option>';

                    let colonias = Array.isArray(response.asentamiento) ? response.asentamiento : [response.asentamiento];

                    colonias.forEach(colonia => {
                        let option = document.createElement("option");
                        option.value = colonia;
                        option.textContent = colonia;
                        coloniaSelect.appendChild(option);
                    });

                    if (row.data().NOMBRE_COLONIA) {
                        coloniaSelect.value = row.data().NOMBRE_COLONIA;
                    }

                    document.getElementById("NOMBRE_MUNICIPIO").value = response.municipio || "No disponible";
                    document.getElementById("NOMBRE_ENTIDAD").value = response.estado || "No disponible";
                } else {
                    alert("Código postal no encontrado");
                }
            })
            .catch(error => {
                console.error("Error al obtener datos:", error);
                alert("Hubo un error al consultar la API.");
            });
    }


    actualizarStepsConCurp(curp);

    tablaDocumentosCargada = false;
    tablacontratosCargada = false;
    tablasoportecontratoCargada = false;
    tablaCVCargada = false;
    tablarequisiconCargada = false;


    $('#datosgenerales-tab').tab('show');

    $(".listadeBeneficiario").empty();
    obtenerDatosBeneficiarios(row);

    $(".listadedocumentoficial").empty();
    obtenerDocumentosOficiales(row);



    $("#step1").click();

    $(".div_trabajador_nombre").html(row.data().NOMBRE_COLABORADOR + ' ' + row.data().PRIMER_APELLIDO + ' ' + row.data().SEGUNDO_APELLIDO);

$(".div_trabajador_numeoro").html(`Número de empleado: ${row.data().NUMERO_EMPLEADO ? row.data().NUMERO_EMPLEADO : "No disponible"}`);

     obtenerCargo();

    if (row.data().DIA_COLABORADOR && row.data().MES_COLABORADOR && row.data().ANIO_COLABORADOR) {
        const fechaNacimiento = `${row.data().ANIO_COLABORADOR}-${row.data().MES_COLABORADOR}-${row.data().DIA_COLABORADOR}`;
        const edad = calcularEdad(fechaNacimiento);
        $('#EDAD_COLABORADOR').val(edad).prop('readonly', true).show();
    }

    setTimeout(() => {
        $('#ANIO_COLABORADOR').val(row.data().ANIO_COLABORADOR);
    }, 100);



    $("#step1").click();
});




function calcularEdad(fechaNacimiento) {
    const hoy = new Date();
    const nacimiento = new Date(fechaNacimiento);
    let edad = hoy.getFullYear() - nacimiento.getFullYear();
    const mesDiferencia = hoy.getMonth() - nacimiento.getMonth();
    
    if (mesDiferencia < 0 || (mesDiferencia === 0 && hoy.getDate() < nacimiento.getDate())) {
        edad--;
    }

    return edad;
}

function actualizarStepsConCurp(curp) {
    $("#CURP").val(curp);
    curpSeleccionada = curp;
}




function obtenerDatosBeneficiarios(data) {
    let row = data.data().BENEFICIARIOS_JSON;
    var beneficiarios = JSON.parse(row);
    let contadorBeneficiario = 1;

    $.each(beneficiarios, function (index, contacto) {
        var nombre = contacto.NOMBRE_BENEFICIARIO;
        var parentesco = contacto.PARENTESCO_BENEFICIARIO;
        var porcentaje = contacto.PORCENTAJE_BENEFICIARIO;
        var telefono1 = contacto.TELEFONO1_BENEFICIARIO;
        var telefono2 = contacto.TELEFONO2_BENEFICIARIO;

        const divContacto = document.createElement('div');
        divContacto.classList.add('row', 'generarlistadebeneficiario', 'm-2');
        divContacto.innerHTML = `
            <div class="col-lg-12 col-sm-1">
                <div class="form-group d-flex align-items-center">
                    <h5><i class="bi bi-person"></i> Beneficiario N° ${contadorBeneficiario} &nbsp;</h5>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="form-group">
                    <label>Nombre completo *</label>
                    <input type="text" class="form-control" name="NOMBRE_BENEFICIARIO" value="${nombre}" required>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="form-group">
                    <label>Parentesco *</label>
                    <input type="text" class="form-control" name="PARENTESCO_BENEFICIARIO" value="${parentesco}" required>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6">
                <div class="form-group">
                    <label>Porcentaje *</label>
                    <input type="number" class="form-control" name="PORCENTAJE_BENEFICIARIO" value="${porcentaje}" required>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6">
                <div class="form-group">
                    <label>Teléfono 1 *</label>
                    <input type="number" class="form-control" name="TELEFONO1_BENEFICIARIO" value="${telefono1}" required>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6">
                <div class="form-group">
                    <label>Teléfono  2 </label>
                    <input type="number" class="form-control" name="TELEFONO2_BENEFICIARIO" value="${telefono2}">
                </div>
            </div>
            <div class="col-12 mt-4">
                <div class="form-group"  style="display: none;">
                    <button type="button" class="btn btn-danger botonEliminarBeneficiario"  id="botoneliminarbene">Eliminar beneficiario <i class="bi bi-trash-fill"></i></button>
                </div>
            </div>
        `;
        const contenedor = document.querySelector('.listadeBeneficiario');
        contenedor.appendChild(divContacto);

        contadorBeneficiario++;

        const botonEliminar = divContacto.querySelector('.botonEliminarBeneficiario');
        botonEliminar.addEventListener('click', function () {
            contenedor.removeChild(divContacto);
        });
    });

}



// AGREGAR DOCUEMENTO DE IDENTIFICACION OFICICAL 




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
            <div class="col-12 mt-4"  style="display: none;">
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







// <!-- ============================================================================================================================ -->
// <!--                                                          STEP 2                                                              -->
// <!-- ============================================================================================================================ -->




document.getElementById('step2').addEventListener('click', function() {
    document.querySelectorAll('[id$="-content"]').forEach(function(content) {
        content.style.display = 'none';
    });

    const step2Content = document.getElementById('step2-content');
    step2Content.style.display = 'block';

    if (tablaDocumentosCargada) {
        Tabladocumentosoportexpediente.columns.adjust().draw();
    } else {
        cargarTablaDocumentosSoporte();
        tablaDocumentosCargada = true;
    }


});

document.addEventListener('DOMContentLoaded', function() {
    var archivoSoporte = document.getElementById('DOCUMENTO_SOPORTE');
    var quitarSoporte = document.getElementById('quitar_documento');
    var errorElement = document.getElementById('DOCUMENTO_ERROR');

    if (archivoSoporte) {
        archivoSoporte.addEventListener('change', function() {
            var archivo = this.files[0];
            if (archivo && archivo.type === 'application/pdf') {
                if (errorElement) errorElement.style.display = 'none';
                if (quitarSoporte) quitarSoporte.style.display = 'block';
            } else {
                if (errorElement) errorElement.style.display = 'block';
                this.value = '';
                if (quitarSoporte) quitarSoporte.style.display = 'none';
            }
        });
        quitarSoporte.addEventListener('click', function() {
            archivoSoporte.value = ''; 
            quitarSoporte.style.display = 'none'; 
            if (errorElement) errorElement.style.display = 'none'; 
        });
    }
});

$("#guardarDOCUMENTOSOPORTE").click(function (e) {
    e.preventDefault();


    formularioValido = validarFormulario3($('#formularioDOCUMENTOS'))

    
    if (formularioValido) {

    if (ID_DOCUMENTOS_ACTUALIZADOS == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarDOCUMENTOSOPORTE')
            await ajaxAwaitFormData({ api: 1, DOCUMENTOS_ID: documento_id, CURP: curpSeleccionada, ID_DOCUMENTOS_ACTUALIZADOS: ID_DOCUMENTOS_ACTUALIZADOS }, 'ExpedienteSave', 'formularioDOCUMENTOS', 'guardarDOCUMENTOSOPORTE', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
                
            }, function (data) {
                    
                ID_DOCUMENTOS_ACTUALIZADOS = data.soporte.ID_DOCUMENTOS_ACTUALIZADOS
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_DOCUMENTOS_SOPORTE').modal('hide')
                    document.getElementById('formularioDOCUMENTOS').reset();

                    
                    if ($.fn.DataTable.isDataTable('#Tabladocumentosoportexpediente')) {
                        Tabladocumentosoportexpediente.ajax.reload(null, false); 
                    }

            })
             
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarDOCUMENTOSOPORTE')
            await ajaxAwaitFormData({ api: 1, DOCUMENTOS_ID: documento_id, CURP: curpSeleccionada, ID_DOCUMENTOS_ACTUALIZADOS: ID_DOCUMENTOS_ACTUALIZADOS }, 'ExpedienteSave', 'formularioDOCUMENTOS', 'guardarDOCUMENTOSOPORTE', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
            }, function (data) {
                    
                setTimeout(() => {

                    ID_DOCUMENTOS_ACTUALIZADOS = data.soporte.ID_DOCUMENTOS_ACTUALIZADOS
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_DOCUMENTOS_SOPORTE').modal('hide')
                    document.getElementById('formularioDOCUMENTOS').reset();


                    
                    if ($.fn.DataTable.isDataTable('#Tabladocumentosoportexpediente')) {
                        Tabladocumentosoportexpediente.ajax.reload(null, false); 
                    }



                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});


function cargarTablaDocumentosSoporte() {
    if ($.fn.DataTable.isDataTable('#Tabladocumentosoportexpediente')) {
        Tabladocumentosoportexpediente.clear().destroy();
    }

    Tabladocumentosoportexpediente = $("#Tabladocumentosoportexpediente").DataTable({
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
            data: { curp: curpSeleccionada }, 
            method: 'GET',
            cache: false,
            url: '/Tabladocumentosoportexpediente',  
            beforeSend: function () {
                $('#loadingIcon').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon').css('display', 'none');
                Tabladocumentosoportexpediente.columns.adjust().draw(); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon').css('display', 'none');
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            },
            dataSrc: 'data'
        },
        columns: [
            { data: null, render: function(data, type, row, meta) { return meta.row + 1; }, className: 'text-center' },
            { data: 'NOMBRE_DOCUMENTO', className: 'text-center' },  
            { data: 'BTN_EDITAR' }
        ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all text-center' },
            { targets: 1, title: 'Nombre del documento', className: 'all text-center' },  
            { targets: 2, title: 'Editar', className: 'all text-center' }
        ]
    });
}


$('#Tabladocumentosoportexpediente').on('click', '.ver-archivo-documentosoporte', function () {
    var tr = $(this).closest('tr');
    var row = Tabladocumentosoportexpediente.row(tr);
    var id = $(this).data('id');

    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }

    var nombreDocumentoSoporte = row.data().NOMBRE_DOCUMENTO;
    var url = '/mostrardocumentosoporte/' + id;
    
    abrirModal(url, nombreDocumentoSoporte);
});



const Modaldocumentosoporte = document.getElementById('miModal_DOCUMENTOS_SOPORTE')
Modaldocumentosoporte.addEventListener('hidden.bs.modal', event => {
    
    ID_DOCUMENTO_SOPORTE = 0


    ID_DOCUMENTOS_ACTUALIZADOS = 0


    
    document.getElementById('formularioDOCUMENTOS').reset();
   
    $('#miModal_DOCUMENTOS_SOPORTE .modal-title').html('Documento de soporte');

    $('#TIPO_DOCUMENTO').prop('disabled', false); 
    $('#NOMBRE_DOCUMENTO').prop('readonly', false); 


    document.getElementById('quitar_documento').style.display = 'none';

    document.getElementById('DOCUMENTO_ERROR').style.display = 'none';

    document.getElementById('FECHAS_SOPORTEDOCUMENTOS').style.display = 'none';

    document.getElementById('DIV_ACTUALIZACOIN').style.display = 'none';


    documento_id = 0; 

})


document.addEventListener('DOMContentLoaded', function () {

    const contenedorFechas = document.getElementById('FECHAS_SOPORTEDOCUMENTOS');

    document.querySelectorAll('input[name="PROCEDE_FECHA_DOC"]').forEach(function (radio) {
        radio.addEventListener('change', function () {

            if (this.value === "1") {
                contenedorFechas.style.display = 'block';
            } else {
                contenedorFechas.style.display = 'none';
            }

        });
    });

});


$(document).ready(function () {

    $('input[name="ACTUALIZAR_DOCUMENTO"]').on('change', function () {

        if ($(this).val() == "1") {
            $('#DIV_ACTUALIZACOIN').slideDown();
        } else {
            $('#DIV_ACTUALIZACOIN').slideUp();
        }

    });

});


$('#Tabladocumentosoportexpediente').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tabladocumentosoportexpediente.row(tr);

    ID_DOCUMENTO_SOPORTE = row.data().ID_DOCUMENTO_SOPORTE;


    documento_id = row.data().ID_DOCUMENTO_SOPORTE;

    
    editarDatoTabla(row.data(), 'formularioDOCUMENTOS', 'miModal_DOCUMENTOS_SOPORTE', 1);

    $('#miModal_DOCUMENTOS_SOPORTE .modal-title').html(row.data().NOMBRE_DOCUMENTO);

    $('#TIPO_DOCUMENTO').prop('disabled', true); 
    $('#NOMBRE_DOCUMENTO').prop('readonly', true); 

    if (row.data().PROCEDE_FECHA_DOC === "1") {
        $('#FECHAS_SOPORTEDOCUMENTOS').show();
    } else {
        $('#FECHAS_SOPORTEDOCUMENTOS').hide();
    }


});






