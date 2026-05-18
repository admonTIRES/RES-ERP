//VARIABLES GLOBALES
var curpSeleccionada; 
var contrato_id = null; 



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
ID_ASINGACIONES_CONTRATACION = 0;


// TABLAS
Tablacontratacion = null


var Tablacontratacion1;
var tablacontracion1Cargada = false; 


var Tabladocumentosoporte;
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
        
        if (tablacontratosCargada) {
            Tablacontratosyanexos.columns.adjust().draw();
        } else {
            cargarTablaContratosyanexos();
            tablacontratosCargada = true;
        }

        $('#contratosdoc-tab').closest('li').css("display", 'none');
    });

});

const textoActivo = document.getElementById('texto_activo');
const textoInactivo = document.getElementById('texto_inactivo');
const tablaActivo = document.getElementById('tabla_activo');
const tablaInactivo = document.getElementById('tabla_inactivo');

textoActivo.addEventListener('click', () => {
    tablaActivo.style.display = 'block';
    tablaInactivo.style.display = 'none';
    textoActivo.classList.add('texto-seleccionado');
    textoActivo.classList.remove('texto-no-seleccionado');
    textoInactivo.classList.add('texto-no-seleccionado');
    textoInactivo.classList.remove('texto-seleccionado');

    Tablacontratacion.columns.adjust().draw(); 

});

textoInactivo.addEventListener('click', () => {
    tablaActivo.style.display = 'none';
    tablaInactivo.style.display = 'block';
    textoInactivo.classList.add('texto-seleccionado');
    textoInactivo.classList.remove('texto-no-seleccionado');
    textoActivo.classList.add('texto-no-seleccionado');
    textoActivo.classList.remove('texto-seleccionado');

    if (tablacontracion1Cargada) {
        Tablacontratacion1.columns.adjust().draw();
    } else {
        cargarTablaContratacionInactivo();
        tablacontracion1Cargada = true;
    }


});

$(document).ready(function() {
    $("#boton_nuevo_contrato").click(function () {

        ID_FORMULARIO_CONTRATACION = 0;


        $(".div_trabajador_nombre").html('NOMBRE DEL COLABORADOR');
        $(".div_trabajador_numeoro").html('Número de empleado');
        $(".div_trabajador_cargo").html('Cargo'); 

        $('#datosgenerales-tab').closest('li').css("display", 'block');
        
    
        $("#step1").css('display', 'flex');
        $("#step1-content").css('display', 'block');

        $( "#step2" ).css('display', 'none');
        $( "#step2-content" ).css('display', 'none');

      
        $( "#step3" ).css('display', 'none');
        $( "#step3-content" ).css('display', 'none');

    
        $( "#step4" ).css('display', 'none');
        $( "#step4-content" ).css('display', 'none');

    
        $( "#step5" ).css('display', 'none');
        $( "#step5-content" ).css('display', 'none');

 
        $( "#step6" ).css('display', 'none');
        $( "#step6-content" ).css('display', 'none');

 

    
        $('#datosgenerales-tab').tab('show'); 

        var drEvent = $('#FOTO_USUARIO').dropify({
            messages: {
                'default': 'Arrastre la imagen aquí o haga clic',
                'replace': 'Arrastre la imagen aquí o haga clic para reemplazar',
                'remove': 'Quitar',
                'error': 'Ooops, ha ocurrido un error.'
            },
            error: {
                'fileSize': 'El archivo es demasiado grande (máx. {{ value }}).',
                'minWidth': 'El ancho de la imagen es demasiado pequeño (mín. {{ value }}px).',
                'maxWidth': 'El ancho de la imagen es demasiado grande (máx. {{ value }}px).',
                'minHeight': 'La altura de la imagen es demasiado pequeña (mín. {{ value }}px).',
                'maxHeight': 'La altura de la imagen es demasiado grande (máx. {{ value }}px).',
                'imageFormat': 'Formato no permitido, sólo se aceptan: ({{ value }}).'
            }
        });

        

        drEvent = drEvent.data('dropify');
        drEvent.resetPreview();  
        drEvent.clearElement();  


        desbloquearBotones();
        
        $('#FormularioCONTRATACION').each(function(){
            this.reset();
        });

        $(".listadeBeneficiario").empty();
        $(".listadedocumentoficial").empty();
        $("#steps_menu_tab1").click();


        $("#BAJAS_COLABORADOR").css("display", "none");
        $("#BAJAS_COLABORADOR").html(`
            <h5>Historial del colaborador</h5>
        `);





    });
});


function bloquearBotones() {
    const botones = [
        'botonagregarbeneficiario',
        'guardarDatosGenerales',
        'botoneliminarbene',
        'guardarDOCUMENTOSOPORTE',
        'guardarCONTRATO',
        'guardarRECIBONOMINA',
        'guardarINFORMACIONMEDICA',
        'guardarINCIDENCIAS',
        'guardarACCIONES',
        'guardarFormRP',
        'guardarDOCUMENTOSOPORTECONTRATO',
        'guardarRENOVACION',
        'guardarSOPORTECONTRATO',
    ];

    botones.forEach(botonId => {
        const boton = document.getElementById(botonId);
        if (boton) {
            boton.setAttribute('disabled', 'true');
        }
    });
}


function desbloquearBotones() {
    const botones = [
        'botonagregarbeneficiario',
        'guardarDatosGenerales',
        'botoneliminarbene',
        'guardarDOCUMENTOSOPORTE',
        'guardarCONTRATO',
        'guardarRECIBONOMINA',
        'guardarINFORMACIONMEDICA',
        'guardarINCIDENCIAS',
        'guardarACCIONES',
        'guardarFormRP',
        'guardarDOCUMENTOSOPORTECONTRATO',
        'guardarRENOVACION',
        'guardarSOPORTECONTRATO'
    ];

    botones.forEach(botonId => {
        const boton = document.getElementById(botonId);
        if (boton) {
            boton.removeAttribute('disabled');
        }
    });
}




function verificarEstadoYActualizarBotones() {
    if (typeof curpSeleccionada === 'undefined' || !curpSeleccionada) {
        console.error('CURP no definida.');
        return;
    }

    fetch('/verificarestadobloqueo', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({ curpSeleccionada }) 
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor.');
            }
            return response.json();
        })
        .then(data => {
            const bloqueodesactivado = data.bloqueodesactivado;

            if (bloqueodesactivado === 0) {
                bloquearBotones();
            } else {
                desbloquearBotones();
            }
        })
        .catch(error => {
            console.error('Error al verificar el estado:', error);
        });
}

var Tablacontratacion = $("#Tablacontratacion").DataTable({
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
        url: '/Tablacontratacion',
        beforeSend: function () {
            $('#loadingIcon8').css('display', 'inline-block');
        },
        complete: function () {
            $('#loadingIcon8').css('display', 'none');
            Tablacontratacion.columns.adjust().draw(); 
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
        { data: 'ESTATUS_CONTRATO' }, 
        { data: 'BTN_EDITAR' }
    ],
    
    columnDefs: [
        { targets: 0, title: '#', className: 'all text-center' },
        { targets: 1, title: 'Nombre del colaborador', className: 'all text-center nombre-column' },
        { targets: 2, title: 'CURP', className: 'all text-center' },
        { targets: 3, title: 'No. empleado', className: 'all text-center' },
        { targets: 4, title: 'Estatus del contrato', className: 'all text-center' }, 
        { targets: 5, title: 'Mostrar', className: 'all text-center' }
    ]
});

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    var target = $(e.target).attr("href"); 
    if (target === '#contratos') {
        Tablacontratacion.columns.adjust().draw(); 
    }
    
});

function reloadTablaContratacion() {
    Tablacontratacion.ajax.reload(null, false); 
}




// <!-- ============================================================================================================================ -->
// <!--                                                          COLABORADORES INACTIVOS                                             -->
// <!-- ============================================================================================================================ -->



function cargarTablaContratacionInactivo() {
    if ($.fn.DataTable.isDataTable('#Tablacontratacion1')) {
        Tablacontratacion1.clear().destroy();
    }

    Tablacontratacion1 = $("#Tablacontratacion1").DataTable({
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
        url: '/Tablacontratacion1',
        beforeSend: function () {
            $('#loadingIcon7').css('display', 'inline-block');
        },
        complete: function () {
            $('#loadingIcon7').css('display', 'none');
            Tablacontratacion1.columns.adjust().draw(); 
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('#loadingIcon7').css('display', 'none');
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
                data: null,  render: function (data, type, row)
                 {
                    return row.NOMBRE_COLABORADOR + ' ' + row.PRIMER_APELLIDO + ' ' + row.SEGUNDO_APELLIDO;
                }
            }
            ,
            { data: 'CURP' },
            { data: 'NUMERO_EMPLEADO' },

            { data: 'BTN_EDITAR' },
            { data: 'BTN_ACTIVAR' }

        ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all text-center' },
            { targets: 1, title: 'Nombre del colaborador', className: 'all text-center nombre-column' },
            { targets: 2, title: 'CURP', className: 'all text-center' },
            { targets: 3, title: 'No. empleado', className: 'all text-center' },
            { targets: 4, title: 'Mostrar', className: 'all text-center' },
            { targets: 5, title: 'Activar', className: 'all text-center' }

        ]
    });
}


$(document).on('change', '.ACTIVAR', function () {
    var checkbox = $(this); 
    var row = checkbox.closest('tr'); 
    var data = Tablacontratacion1.row(row).data(); 
    var id = checkbox.data('id'); 
    var estadoAnterior = checkbox.prop('checked');

    if (!id || !data) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo obtener la información del colaborador',
            timer: 2000,
            timerProgressBar: true
        });
        return;
    }

    var nombreColaborador = `${data.NOMBRE_COLABORADOR} ${data.PRIMER_APELLIDO} ${data.SEGUNDO_APELLIDO}`;
    var curp = data.CURP;

    Swal.fire({
        title: `Confirme para activar al colaborador`,
        html: `
            <p>Está a punto de activar a ${nombreColaborador}. Por favor, ingrese la fecha de reingreso:</p>
            <div class="input-group">
                <input type="text" id="FECHA_REINGRESO" class="form-control mydatepicker" placeholder="aaaa-mm-dd">
                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
            </div>
        `,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: 'Sí, confirmar',
        cancelButtonText: 'Cancelar',
        didOpen: () => {
            $('.mydatepicker').datepicker({
                format: 'yyyy-mm-dd', 
                autoclose: true,     
                todayHighlight: true,
                language: 'es' 

            });
        },
        preConfirm: () => {
            const fechaReingreso = document.getElementById('FECHA_REINGRESO').value;
            if (!fechaReingreso) {
                Swal.showValidationMessage('Debe ingresar una fecha de reingreso válida');
                return false;
            }
            return fechaReingreso;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const fechaReingreso = result.value;
            $.ajax({
                type: "POST",
                url: '/activarColaborador/' + id,
                data: {
                    fechaReingreso: fechaReingreso,
                    curp: curp
                },
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.status === "success") {


                        if ($.fn.DataTable.isDataTable('#Tablacontratacion1')) {
                            Tablacontratacion1.ajax.reload(null, false);
                            }
                            
                        if ($.fn.DataTable.isDataTable('#Tablacontratacion')) {
                            Tablacontratacion.ajax.reload(null, false);
                        }
                            
                        Swal.fire({
                            icon: 'success',
                            title: 'Colaborador activado',
                            text: `${nombreColaborador} ha sido activado exitosamente`,
                            timer: 2000,
                            timerProgressBar: true
                        });
                    } else {
                        Swal.fire({
                            icon: response.status,
                            title: 'Atención',
                            text: response.msj,
                            timer: 2000,
                            timerProgressBar: true
                        });
                        checkbox.prop('checked', !estadoAnterior);
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo completar la acción',
                        timer: 2000,
                        timerProgressBar: true
                    });
                    checkbox.prop('checked', !estadoAnterior);
                }
            });
        } else {
            checkbox.prop('checked', !estadoAnterior);
        }
    });
});




$('#Tablacontratacion1').on('click', 'button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacontratacion1.row(tr);

    
    ID_FORMULARIO_CONTRATACION = row.data().ID_FORMULARIO_CONTRATACION;

    $('#FormularioCONTRATACION').each(function() {
        this.reset();
    });

    $('#datosgenerales-tab').closest('li').css("display", 'block');
    $('#step2, #step3,#step4,#step5,#step6').css("display", "flex");

    $('#step1-content').css("display", 'block');
    $('#step2-content, #step3-content, #step4-content,#step5-content,#step6-content').css("display", 'none');





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

    verificarEstadoYActualizarBotones();



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


    cargarBajasColaborador();


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
                await ajaxAwaitFormData(requestData, 'contratoSave', 'FormularioCONTRATACION', 'guardarDatosGenerales', { callbackAfter: true, callbackBefore: true }, () => {
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
                    $('#step2, #step3, #step4,#step5,#step6').css("display", "flex");
                   
                     cargarBajasColaborador();

                    alertMensaje('success', 'Información guardada correctamente', 'Esta información está lista para usarse', null, null, 1500);
                    Tablacontratacion.ajax.reload();
                });
            }, 1);
            
        } else {
            alertMensajeConfirm({
                title: "¿Desea editar la información de este formulario?",
                text: "Al guardarla, se podrá usar",
                icon: "question",
            }, async function () {

                await loaderbtn('guardarDatosGenerales');
                await ajaxAwaitFormData(requestData, 'contratoSave', 'FormularioCONTRATACION', 'guardarDatosGenerales', { callbackAfter: true, callbackBefore: true }, () => {
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
                        Tablacontratacion.ajax.reload();
                    }, 300);
                });
            }, 1);
        }
    } else {
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000);
    }
});

$('#Tablacontratacion tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacontratacion.row(tr);
    ID_FORMULARIO_CONTRATACION = row.data().ID_FORMULARIO_CONTRATACION;

    $('#FormularioCONTRATACION').each(function() {
        this.reset();
    });

    $('#datosgenerales-tab').closest('li').css("display", 'block');
    $('#step2, #step3,#step4,#step5,#step6').css("display", "flex");

    $('#step1-content').css("display", 'block');
    $('#step2-content, #step3-content, #step4-content,#step5-content,#step6-content').css("display", 'none');

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

    verificarEstadoYActualizarBotones();
    bloquearPorRolExterno();

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

    cargarBajasColaborador();


    $("#step1").click();

    $(".div_trabajador_nombre").html(row.data().NOMBRE_COLABORADOR + ' ' + row.data().PRIMER_APELLIDO + ' ' + row.data().SEGUNDO_APELLIDO);

    $(".div_trabajador_numeoro").html(`Número de empleado: ${row.data().NUMERO_EMPLEADO ? row.data().NUMERO_EMPLEADO : "No disponible"}`);

    obtenerCargo();
    generarNumeroEmpleado();

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


function generarNumeroEmpleado() {

    if (!curpSeleccionada) {
        console.warn("No hay CURP seleccionada");
        return;
    }

    $.ajax({
        url: '/obtenerSiguienteNumeroEmpleado',
        type: 'POST',
        data: {
            curp: curpSeleccionada,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {

            if (response.status === 'nuevo') {
                $('#NUMERO_EMPLEADO').val(response.numero);
            }

            if (response.status === 'existe') {
                $('#NUMERO_EMPLEADO').val(response.numero);
            }

        },
        error: function() {
            console.error("Error al obtener número empleado");
        }
    });
}





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

function validarPorcentajeBeneficiarios() {
    let suma = 0;

    document.querySelectorAll("input[name='PORCENTAJE_BENEFICIARIO']").forEach(function (input) {
        let valor = parseFloat(input.value) || 0; 
        suma += valor;
    });

    const botonGuardar = document.getElementById('guardarDatosGenerales');

    if (suma > 100) {
        alertToast("La suma de los porcentajes no puede exceder el 100%.");
        botonGuardar.disabled = true; 
    } else if (suma === 100) {
        botonGuardar.disabled = false; 
    } else {
        botonGuardar.disabled = true; 
    }
}


// AGREGAR BENEFICIARIO
document.addEventListener("DOMContentLoaded", function () {
    const botonAgregar = document.getElementById('botonagregarbeneficiario');
    botonAgregar.addEventListener('click', function () {
        agregarBeneficiario();
        validarPorcentajeBeneficiarios(); 
    });

    document.addEventListener('input', function (e) {
        if (e.target.name === 'PORCENTAJE_BENEFICIARIO') {
            validarPorcentajeBeneficiarios(); 
        }
    });

    function agregarBeneficiario() {
        const divContacto = document.createElement('div');
        divContacto.classList.add('row', 'generarlistadebeneficiario', 'm-3');
        divContacto.innerHTML = `
            <div class="col-lg-12 col-sm-1">
                <div class="form-group">
                    <h5><i class="bi bi-person"></i> Agregar beneficiario</h5>                    
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="form-group">
                    <label>Nombre completo *</label>
                    <input type="text" class="form-control" name="NOMBRE_BENEFICIARIO" required>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="form-group">
                    <label>Parentesco *</label>
                    <input type="text" class="form-control" name="PARENTESCO_BENEFICIARIO" required>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6">
                <div class="form-group">
                    <label>Porcentaje *</label>
                    <input type="number" class="form-control" name="PORCENTAJE_BENEFICIARIO" required>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6">
                <div class="form-group">
                    <label>Teléfono 1 *</label>
                    <input type="number" class="form-control" name="TELEFONO1_BENEFICIARIO" required>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6">
                <div class="form-group">
                    <label>Teléfono  2 </label>
                    <input type="number" class="form-control" name="TELEFONO2_BENEFICIARIO">
                </div>
            </div>
            <br>
            <div class="col-12 mt-4">
                <div class="form-group" style="text-align: center;">
                    <button type="button" class="btn btn-danger botonEliminarBeneficiario">Eliminar beneficiario <i class="bi bi-trash-fill"></i></button>
                </div>
            </div>
        `;
        const contenedor = document.querySelector('.listadeBeneficiario');
        contenedor.appendChild(divContacto);

        const botonEliminar = divContacto.querySelector('.botonEliminarBeneficiario');
        botonEliminar.addEventListener('click', function () {
            contenedor.removeChild(divContacto);
            validarPorcentajeBeneficiarios(); 
        });
    }
});

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
                <div class="form-group" style="text-align: center;">
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
            validarPorcentajeBeneficiarios(); 
        });
    });

    validarPorcentajeBeneficiarios();
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



function cargarBajasColaborador() {
    const container = document.getElementById('BAJAS_COLABORADOR');
    
    container.innerHTML = `<h5>Historial del colaborador</h5>`;

    fetch(`/obtenerbajasalta`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ curp: curpSeleccionada }) 
    })
    .then(response => response.json())
    .then(data => {
        let tabla = '<table class="table table-bordered">';
        tabla += `
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Fecha inicio</th>
                    <th>Fecha fin / Hoy</th>
                    <th>Días transcurridos</th>
                </tr>
            </thead>
            <tbody>
        `;

        data.forEach(registro => {
            tabla += `
                <tr>
                    <td>${registro.tipo}</td>
                    <td>${registro.fecha}</td>
                    <td>${registro.fecha_fin}</td>
                    <td>${registro.dias_transcurridos}</td>
                </tr>
            `;
        });

        tabla += '</tbody></table>';

        container.innerHTML += tabla;
    })
    .catch(error => {
        console.error('Error al obtener las bajas del colaborador:', error);
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
        Tabladocumentosoporte.columns.adjust().draw();
    } else {
        cargarTablaDocumentosSoporte();
        tablaDocumentosCargada = true;
    }

    cargarDocumentosGuardados();
    bloquearPorRolExterno();

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

document.addEventListener('DOMContentLoaded', function() {
    var tipoArea = document.getElementById('TIPO_DOCUMENTO');
    var nombreDocumento = document.getElementById('NOMBRE_DOCUMENTO');

    tipoArea.addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex].text; 

        if (this.value == '13') {
            nombreDocumento.removeAttribute('readonly');
            nombreDocumento.value = ''; 
        } else {
            nombreDocumento.setAttribute('readonly', true);
            nombreDocumento.value = selectedOption; 
        }
    });
});

$("#guardarDOCUMENTOSOPORTE").click(function (e) {
    e.preventDefault();


    formularioValido = validarFormulario3($('#formularioDOCUMENTOS'))

    
    if (formularioValido) {

    if (ID_DOCUMENTO_SOPORTE == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarDOCUMENTOSOPORTE')
            await ajaxAwaitFormData({ api: 2, CURP: curpSeleccionada , ID_DOCUMENTO_SOPORTE: ID_DOCUMENTO_SOPORTE }, 'contratoSave', 'formularioDOCUMENTOS', 'guardarDOCUMENTOSOPORTE', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
                
            }, function (data) {
                    
                ID_DOCUMENTO_SOPORTE = data.soporte.ID_DOCUMENTO_SOPORTE
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_DOCUMENTOS_SOPORTE').modal('hide')
                    document.getElementById('formularioDOCUMENTOS').reset();

                    
                    if ($.fn.DataTable.isDataTable('#Tabladocumentosoporte')) {
                        Tabladocumentosoporte.ajax.reload(null, false); 
                    }
                    cargarDocumentosGuardados();

            })
             
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarDOCUMENTOSOPORTE')
            await ajaxAwaitFormData({ api: 2, CURP: curpSeleccionada ,ID_DOCUMENTO_SOPORTE: ID_DOCUMENTO_SOPORTE }, 'contratoSave', 'formularioDOCUMENTOS', 'guardarDOCUMENTOSOPORTE', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
            }, function (data) {
                    
                setTimeout(() => {

                    ID_DOCUMENTO_SOPORTE = data.soporte.ID_DOCUMENTO_SOPORTE
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_DOCUMENTOS_SOPORTE').modal('hide')
                    document.getElementById('formularioDOCUMENTOS').reset();


                    
                    if ($.fn.DataTable.isDataTable('#Tabladocumentosoporte')) {
                        Tabladocumentosoporte.ajax.reload(null, false); 
                    }

                    cargarDocumentosGuardados();


                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});


function cargarTablaDocumentosSoporte() {
    if ($.fn.DataTable.isDataTable('#Tabladocumentosoporte')) {
        Tabladocumentosoporte.clear().destroy();
    }

    Tabladocumentosoporte = $("#Tabladocumentosoporte").DataTable({
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
            url: '/Tabladocumentosoporte',  
            beforeSend: function () {
                $('#loadingIcon').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon').css('display', 'none');
                Tabladocumentosoporte.columns.adjust().draw(); 
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
            { data: 'BTN_DOCUMENTO' }, 
            {
                data: null,
                render: function (data, type, row) {
                    const inicioRaw = row.FECHAI_DOCUMENTOSOPORTE;
                    const finRaw = row.FECHAF_DOCUMENTOSOPORTE;
            
                    if (!inicioRaw || !finRaw) {
                        return `
                            <div class="text-center">
                                <div><strong></strong> N/A</div>
                            </div>
                        `;
                    }
            
                    const inicio = new Date(inicioRaw);
                    const fin = new Date(finRaw);
                    const hoy = new Date();
            
                    const totalDias = Math.ceil((fin - inicio) / (1000 * 60 * 60 * 24));
                    const diasRestantes = Math.ceil((fin - hoy) / (1000 * 60 * 60 * 24));
            
                    const umbralVerde = totalDias * 0.60;     // VERDE si quedan más del 60%
                    const umbralAmarillo = totalDias * 0.30;  // AMARILLO si quedan entre 30 y 60%
            
                    let colorTexto = 'green';
                    let mensaje = `(${diasRestantes} días restantes)`;
            
                    if (diasRestantes <= 0) {
                        colorTexto = 'red';
                        mensaje = '(Terminado)';
                    } else if (diasRestantes <= umbralAmarillo) {
                        colorTexto = 'red';
                    } else if (diasRestantes <= umbralVerde) {
                        colorTexto = 'orange';
                    } else {
                        colorTexto = 'green';
                    }
            
                    return `
                        <div class="text-center">
                            <div><strong></strong> ${inicioRaw}</div>
                            <div><strong></strong> ${finRaw}</div>
                            <span style="color: ${colorTexto};">${mensaje}</span>
                        </div>
                    `;
                },
                className: 'text-center'
            },
            
            
            
            { data: 'BTN_EDITAR' }
        ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all text-center' },
            { targets: 1, title: 'Nombre del documento', className: 'all text-center' },  
            { targets: 2, title: 'Documento de soporte', className: 'all text-center' },  
            { targets: 3, title: 'Fecha inicio/fin - Estatus', className: 'all text-center' },  
            { targets: 4, title: 'Editar', className: 'all text-center' }
        ]
    });
}


$('#Tabladocumentosoporte').on('click', '.ver-archivo-documentosoporte', function () {
    var tr = $(this).closest('tr');
    var row = Tabladocumentosoporte.row(tr);
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
    document.getElementById('formularioDOCUMENTOS').reset();
   
    $('#miModal_DOCUMENTOS_SOPORTE .modal-title').html('Documento de soporte');

    $('#TIPO_DOCUMENTO').prop('disabled', false); 
    $('#NOMBRE_DOCUMENTO').prop('readonly', false); 


    document.getElementById('quitar_documento').style.display = 'none';

    document.getElementById('DOCUMENTO_ERROR').style.display = 'none';

    document.getElementById('FECHAS_SOPORTEDOCUMENTOS').style.display = 'none';




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

$('#Tabladocumentosoporte').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tabladocumentosoporte.row(tr);

    ID_DOCUMENTO_SOPORTE = row.data().ID_DOCUMENTO_SOPORTE;

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





function cargarDocumentosGuardados() {
    if (!curpSeleccionada || curpSeleccionada.trim() === '') {
        console.error('CURP no definida');
        return;
    }

    $.ajax({
        url: '/obtenerguardados',
        method: 'POST',
        data: {
            CURP: curpSeleccionada, 
            _token: $('input[name="_token"]').val() 
        },
        success: function (data) {
            let select = $('#TIPO_DOCUMENTO');

            select.find('option').prop('disabled', false);

            data.forEach(function (tipoDocumento) {
                if (tipoDocumento !== "13") {  // No bloquear la opción 3
                    select.find(`option[value="${tipoDocumento}"]`).prop('disabled', true);
                }
            });

        },
        error: function (xhr, status, error) {
            console.error('Error al cargar documentos guardados:', error);
        }
    });
}


// function cargarDocumentosGuardados() {
//     if (!curpSeleccionada || curpSeleccionada.trim() === '') {
//         console.error('CURP no definida');
//         return;
//     }

//     $.ajax({
//         url: '/obtenerguardados',
//         method: 'POST',
//         data: {
//             CURP: curpSeleccionada,
//             _token: $('input[name="_token"]').val()
//         },
//         success: function (data) {
//             let select = $('#TIPO_DOCUMENTO');

//             select.find('option').each(function () {
//                 $(this).prop('disabled', true).css('color', ''); 
//             });

//             data.forEach(function (tipoDocumento) {
//                 select.find(`option[value="${tipoDocumento}"]`)
//                     .prop('disabled', false)
//                     .css('color', 'green');
//             });
//         },
//         error: function (xhr, status, error) {
//             console.error('Error al cargar documentos guardados:', error);
//         }
//     });
// }




// <!-- ============================================================================================================================ -->
// <!--                                                          STEP 3                                                              -->
// <!-- ============================================================================================================================ -->

let fechaRenovacionGlobalcontrato = '';

let fechaInicioRenovacionGlobalcontrato = '';

document.getElementById('step3').addEventListener('click', function() {
    document.querySelectorAll('[id$="-content"]').forEach(function(content) {
        content.style.display = 'none';
    });

    document.getElementById('step3-content').style.display = 'block';

    if (tablacontratosCargada) {
        Tablacontratosyanexos.columns.adjust().draw();
    } else {
        cargarTablaContratosyanexos();
        tablacontratosCargada = true;
    }
  
    bloquearPorRolExterno();

});

document.addEventListener('DOMContentLoaded', function() {
    var archivocontrato = document.getElementById('DOCUMENTO_CONTRATO');
    var quitarcontrato = document.getElementById('quitar_contrato');
    var errorElement = document.getElementById('DOCUEMNTO_ERROR_CONTRATO');

    if (archivocontrato) {
        archivocontrato.addEventListener('change', function() {
            var archivoscontrato = this.files[0];
            if (archivoscontrato && archivo.type === 'application/pdf') {
                if (errorElement) errorElement.style.display = 'none';
                if (quitarcontrato) quitarcontrato.style.display = 'block';
            } else {
                if (errorElement) errorElement.style.display = 'block';
                this.value = '';
                if (quitarcontrato) quitarcontrato.style.display = 'none';
            }
        });
        quitarcontrato.addEventListener('click', function() {
            archivocontrato.value = ''; 
            quitarcontrato.style.display = 'none'; 
            if (errorElement) errorElement.style.display = 'none'; 
        });
    }
});



const ModalContrato = document.getElementById('miModal_CONTRATO');
ModalContrato.addEventListener('hidden.bs.modal', event => {
    
    ID_CONTRATOS_ANEXOS = 0

    document.getElementById('formularioCONTRATO').reset();
    $('#miModal_CONTRATO .modal-title').html('Contratos y anexos');

   
    document.getElementById('quitar_contrato').style.display = 'none';

    document.getElementById('DOCUEMNTO_ERROR_CONTRATO').style.display = 'none';


    document.getElementById('REQUIERE_ADENDA_CONTRATO').style.display = 'none';

    document.getElementById('AGREGAR_ADENDA_CONTRATO').style.display = 'none';

    $(".adendadivcontrato").empty();

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

    const fechaInicioInput = divVerificacion.querySelector('input[name="FECHAI_ADENDA_CONTRATO[]"]');

    if (fechaInicioRenovacionGlobalcontrato) {
        const [year, month, day] = fechaInicioRenovacionGlobalcontrato.split("-");
        const fechaMinima = new Date(year, month - 1, parseInt(day) + 1); 

        $(fechaInicioInput).datepicker({
            format: 'yyyy-mm-dd',
            weekStart: 1,
            autoclose: true,
            todayHighlight: true,
            language: 'es',
            startDate: fechaMinima
        }).on('click', function () {
            $(this).datepicker('setDate', $(this).val());
        });
    }


    const fechaFinInput = divVerificacion.querySelector('input[name="FECHAF_ADENDA_CONTRATO[]"]');
    if (fechaRenovacionGlobalcontrato) {
        fechaFinInput.value = fechaRenovacionGlobalcontrato;
    }


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




$("#guardarCONTRATO").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormularioV1('formularioCONTRATO');

    if (formularioValido) {

    if (ID_CONTRATOS_ANEXOS == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarCONTRATO')
            await ajaxAwaitFormData({ api: 3, CURP: curpSeleccionada , ID_CONTRATOS_ANEXOS: ID_CONTRATOS_ANEXOS }, 'contratoSave', 'formularioCONTRATO', 'guardarCONTRATO', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
                
            }, function (data) {
                    
                ID_CONTRATOS_ANEXOS = data.soporte.ID_CONTRATOS_ANEXOS
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_CONTRATO').modal('hide')
                    document.getElementById('formularioCONTRATO').reset();



                    
                    if ($.fn.DataTable.isDataTable('#Tablacontratosyanexos')) {
                        Tablacontratosyanexos.ajax.reload(null, false); 
                    }



            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarCONTRATO')
            await ajaxAwaitFormData({ api: 3, CURP: curpSeleccionada ,ID_CONTRATOS_ANEXOS: ID_CONTRATOS_ANEXOS }, 'contratoSave', 'formularioCONTRATO', 'guardarCONTRATO', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
            }, function (data) {
                    
                setTimeout(() => {

                    ID_CONTRATOS_ANEXOS = data.soporte.ID_CONTRATOS_ANEXOS
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_CONTRATO').modal('hide')
                    document.getElementById('formularioCONTRATO').reset();


                    
                    if ($.fn.DataTable.isDataTable('#Tablacontratosyanexos')) {
                        Tablacontratosyanexos.ajax.reload(null, false); 
                    }

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});


// function cargarTablaContratosyanexos() {
//     if ($.fn.DataTable.isDataTable('#Tablacontratosyanexos')) {
//         Tablacontratosyanexos.clear().destroy();
//     }

//     Tablacontratosyanexos = $("#Tablacontratosyanexos").DataTable({
//         language: { url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json" },
//         lengthChange: true,
//         lengthMenu: [
//             [10, 25, 50, -1],
//             [10, 25, 50, 'All']
//         ],
//         info: false,
//         paging: true,
//         searching: true,
//         filtering: true,
//         scrollY: '65vh',
//         scrollCollapse: true,
//         responsive: true,
//         ajax: {
//             dataType: 'json',
//             data: { curp: curpSeleccionada }, 
//             method: 'GET',
//             cache: false,
//             url: '/Tablacontratosyanexos',  
//             beforeSend: function () {
//                 $('#loadingIcon1').css('display', 'inline-block');
//             },
//             complete: function () {
//                 $('#loadingIcon1').css('display', 'none');
//                 Tablacontratosyanexos.columns.adjust().draw(); 
//             },
//             error: function (jqXHR, textStatus, errorThrown) {
//                 $('#loadingIcon1').css('display', 'none');
//                 alertErrorAJAX(jqXHR, textStatus, errorThrown);
//             },
//             dataSrc: 'data'
//         },
//         columns: [
//             { data: null, render: function(data, type, row, meta) { return meta.row + 1; }, className: 'text-center' },
//             { data: 'NOMBRE_DOCUMENTO_CONTRATO', className: 'text-center' },
//             { 
//                 data: 'NOMBRE_CATEGORIA', 
//                 className: 'text-center',
//                 render: function(data) { return data ? data : 'N/A'; }
//             }, 
//             {
//                 data: 'FECHA_ESTADO', // Ahora solo mostramos un texto limpio desde PHP
//                 className: 'text-center'
//             },
//             { data: 'BTN_DOCUMENTO', className: 'text-center' },
//             { data: 'BTN_EDITAR', className: 'text-center' },
//             { data: 'BTN_CONTRATO', className: 'text-center' }
//         ],
//         columnDefs: [
//             { targets: 0, title: '#', className: 'all text-center' },
//             { targets: 1, title: 'Tipo de contrato', className: 'all text-center' },  
//             { targets: 2, title: 'Nombre del Cargo', className: 'all text-center' },  
//             { targets: 3, title: 'Fechas y Estado', className: 'all text-center' },  
//             { targets: 4, title: 'Documento', className: 'all text-center' },  
//             { targets: 5, title: 'Editar', className: 'all text-center' }, 
//             { targets: 6, title: 'Contrato', className: 'all text-center' }
//         ],
//     });
// }



function cargarTablaContratosyanexos() {
    if ($.fn.DataTable.isDataTable('#Tablacontratosyanexos')) {
        Tablacontratosyanexos.clear().destroy();
    }

    Tablacontratosyanexos = $("#Tablacontratosyanexos").DataTable({
        language: { url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json" },
        lengthChange: true,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All']],
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
            url: '/Tablacontratosyanexos',
            beforeSend: function () {
                $('#loadingIcon1').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon1').css('display', 'none');
                Tablacontratosyanexos.columns.adjust().draw();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon1').css('display', 'none');
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
            {
                data: null,
                render: function (data, type, row) {
                    let html = `
                        <div class="bloque-contrato p-2 mb-2 border-bottom border-secondary">
                            <strong>${row.NOMBRE_DOCUMENTO_CONTRATO || 'Contrato'}</strong>
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
            {
                data: 'NOMBRE_CATEGORIA',
                className: 'text-center',
                render: function (data) {
                    return data ? data : 'N/A';
                }
            },
            { data: 'FECHAI_CONTRATO', className: 'text-center' },
            {
                data: null,
                render: function (data, type, row) {
                    let html = `
                        <div class="bloque-contrato p-2 mb-2 border-bottom border-secondary">
                            ${row.FECHA_ESTADO || ''}
                        </div>
                    `;

                    if (row.ADENDAS && row.ADENDAS.length > 0) {
                        row.ADENDAS.forEach(adenda => {
                            html += `
                                <div class="bloque-adenda-contrato p-2 mb-2 border-bottom border-secondary bg-light">
                                    <div>${adenda.FECHAI_ADENDA_CONTRATO || ''}</div>
                                    <div>${adenda.FECHAF_ADENDA_CONTRATO || ''}</div>
                                </div>
                            `;
                        });
                    }

                    return html;
                },
                className: 'text-center'
            },
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
            { data: 'BTN_EDITAR', className: 'text-center' },
            { data: 'BTN_CREDENCIAL', className: 'text-center' },
            { data: 'BTN_CONTRATO', className: 'text-center' }
        ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all text-center' },
            { targets: 1, title: 'Tipo de contrato / Adendas', className: 'all text-center' },
            { targets: 2, title: 'Nombre del Cargo', className: 'all text-center' },
            { targets: 3, title: 'Fecha de Ingreso', className: 'all text-center' },
            { targets: 4, title: 'Fechas y Estado', className: 'all text-center' },
            { targets: 5, title: 'Documentos', className: 'all text-center' },
            { targets: 6, title: 'Editar', className: 'all text-center' },
            { targets: 7, title: 'Credencial', className: 'all text-center' },
            { targets: 8, title: 'Contrato', className: 'all text-center' }
        ],
    });
}



$('#Tablacontratosyanexos').on('click', '.generar-credencial', function () {
    const idContrato = $(this).data('id');
    const curp = $(this).data('curp');

    if (!curp || !idContrato) {
        alert('No se puede generar la credencial. Falta la CURP o el ID del contrato.');
        return;
    }

    Swal.fire({
        title: 'Generando credencial...',
        text: 'Espere un momento mientras se descarga.',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading(),
    });

    window.location.href = `/descargar-credencial?curp=${encodeURIComponent(curp)}&id_contrato=${idContrato}`;

    setTimeout(() => {
        Swal.close(); 
    }, 6000);
});



$('#Tablacontratosyanexos').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacontratosyanexos.row(tr);

    ID_CONTRATOS_ANEXOS = row.data().ID_CONTRATOS_ANEXOS;
     var fechaLimpia = row.data().FECHA_ESTADO.replace(/<[^>]*>/g, '');

    var rowDataLimpio = { ...row.data(), FECHA_ESTADO: fechaLimpia };

    editarDatoTabla(rowDataLimpio, 'formularioCONTRATO', 'miModal_CONTRATO', 1);
    $('#miModal_CONTRATO .modal-title').html(row.data().NOMBRE_DOCUMENTO_CONTRATO);


    document.getElementById('REQUIERE_ADENDA_CONTRATO').style.display = 'block';


    fechaRenovacionGlobalcontrato = row.data().VIGENCIA_CONTRATO || ''; 
    fechaInicioRenovacionGlobalcontrato = row.data().FECHAI_CONTRATO || '';



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

$('#Tablacontratosyanexos').on('click', '.ver-archivo-contratosyanexos', function () {
    var tr = $(this).closest('tr');
    var row = Tablacontratosyanexos.row(tr);
    var id = $(this).data('id');

    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }

    var nombreDocumento = row.data().NOMBRE_DOCUMENTO_CONTRATO;
    var url = '/mostrarcontratosyanexos/' + id;
    
    abrirModal(url, nombreDocumento);
});




$('#Tablacontratosyanexos').on('click', '.ver-archivo-adendacontrato', function () {
    var id = $(this).data('id');
    if (!id) {
        alert('ARCHIVO NO ENCONTRADO');
        return;
    }
    var url = '/mostraradendacontrato/' + id;
    abrirModal(url, 'Archivo adenda');
})

$('#Tablacontratosyanexos').on('click', 'button.informacion', function () {

    var tr = $(this).closest('tr');
    var row = Tablacontratosyanexos.row(tr);


    contrato_id = row.data().ID_CONTRATOS_ANEXOS;

     
    NOMBRE_CATEGORIA = row.data().NOMBRE_CATEGORIA;
    VIGENCIA_CONTRATO = row.data().VIGENCIA_CONTRATO;

    FECHAI_CONTRATO = row.data().FECHAI_CONTRATO;
    SALARIO_CONTRATO = row.data().SALARIO_CONTRATO;
    


    $('#contratosdoc-tab').closest('li').css("display", "block");
    $("#contratosdoc-tab").click();



    cargarInformacionContrato();
    cargarTablaDocumentosSoporteContrato();
    cargarTablaRenovacionContrato ();
    cargarTablaInformacionMedica ();
    cargarTablaIncidencias();  
    cargarTablaAusenciaEmpleado();
    cargarTablaSolicitudvacaciones();
    cargarTablaAccionesDisciplinarias ();
    cargarTablaRecibosNomina();

    cargarTablasingnaciongeneral();
    bloquearPorRolExterno();

    
});

 function cargarInformacionContrato() {
    $.ajax({
        url: `/obtenerInformacionContrato/${contrato_id}`,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.data) {
                $('#contrato_cargo').text(response.data.NOMBRE_CATEGORIA);
                $('#contrato_fechai').text(response.data.FECHAI_CONTRATO);
                $('#contrato_fecha_final').text(response.data.VIGENCIA_CONTRATO);
                $('#contrato_salario').text(response.data.SALARIO_CONTRATO);
            } else {
                console.warn("No se encontraron datos del contrato.");
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error al obtener datos del contrato:", textStatus, errorThrown);
        }
    });
}


// <!-- ============================================================================================================================ -->
// <!--                                                          DOCUMENTOS DE CONTRATOS                                             -->
// <!-- ============================================================================================================================ -->


// <!-- ============================================================== -->
// <!-- DOCUMENTOS DE SOPORTE DEL CONTRATO-->
// <!-- ============================================================== -->
document.addEventListener('DOMContentLoaded', function() {
    var archivodocumentosdesoporte = document.getElementById('DOCUMENTOS_SOPORTECONTRATOS');
    var quitardocumentosdesoporte = document.getElementById('quitar_documentossoportecontrato');
    var errorenquitardocumentosdesoporte = document.getElementById('ERROR_DOCUMENTOSOPORTECONTRATO');

    if (archivodocumentosdesoporte) {
        archivodocumentosdesoporte.addEventListener('change', function() {
            var archivomedica = this.files[0];
            if (archivomedica && archivomedica.type === 'application/pdf') {
                if (errorenquitardocumentosdesoporte) errorenquitardocumentosdesoporte.style.display = 'none';
                if (quitardocumentosdesoporte) quitardocumentosdesoporte.style.display = 'block';
            } else {
                if (errorenquitardocumentosdesoporte) errorenquitardocumentosdesoporte.style.display = 'block';
                this.value = '';
                if (quitardocumentosdesoporte) quitardocumentosdesoporte.style.display = 'none';
            }
        });
        quitardocumentosdesoporte.addEventListener('click', function() {
            archivodocumentosdesoporte.value = ''; 
            quitardocumentosdesoporte.style.display = 'none'; 
            if (errorenquitardocumentosdesoporte) errorenquitardocumentosdesoporte.style.display = 'none'; 
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    var tipoArea = document.getElementById('TIPO_DOCUMENTOSOPORTECONTRATO');
    var nombreDocumento = document.getElementById('NOMBRE_DOCUMENTOSOPORTECONTRATO');

    tipoArea.addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex].text; 

        if (this.value == '14') {
            nombreDocumento.removeAttribute('readonly');
            nombreDocumento.value = ''; 
        } else {
            nombreDocumento.setAttribute('readonly', true);
            nombreDocumento.value = selectedOption; 
        }
    });
});






document.addEventListener("DOMContentLoaded", function () {
    const selectTipoDocumento = document.getElementById("TIPO_DOCUMENTOSOPORTECONTRATO");
    const fechaFinInput = document.getElementById("FECHAF_DOCUMENTOSOPORTECONTRATO");

    selectTipoDocumento.addEventListener("change", function () {
        if (selectTipoDocumento.value === "2") {
            fechaFinInput.disabled = true;
            fechaFinInput.removeAttribute("required");
            fechaFinInput.value = ""; 
        } else {
            fechaFinInput.disabled = false;
            fechaFinInput.setAttribute("required", "required");
        }
    });
});



$("#guardarDOCUMENTOSOPORTECONTRATO").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormularioV1('formularioDOCUMENTOSOPORTECONTRATO');

    if (formularioValido) {

    if (ID_SOPORTE_CONTRATO == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarDOCUMENTOSOPORTECONTRATO')
            await ajaxAwaitFormData({ api: 9,CONTRATO_ID:contrato_id, CURP: curpSeleccionada , ID_SOPORTE_CONTRATO: ID_SOPORTE_CONTRATO }, 'contratoSave', 'formularioDOCUMENTOSOPORTECONTRATO', 'guardarDOCUMENTOSOPORTECONTRATO', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
                
            }, function (data) {
                    
                ID_SOPORTE_CONTRATO = data.soporte.ID_SOPORTE_CONTRATO
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_DOCUMENTOSOPORTECONTRATO').modal('hide')
                    document.getElementById('formularioDOCUMENTOSOPORTECONTRATO').reset();


                    
                    if ($.fn.DataTable.isDataTable('#Tabladocumentosoportecontrato')) {
                        Tabladocumentosoportecontrato.ajax.reload(null, false); 
                    }
            })
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarDOCUMENTOSOPORTECONTRATO')
            await ajaxAwaitFormData({ api: 9,CONTRATO_ID:contrato_id, CURP: curpSeleccionada ,ID_SOPORTE_CONTRATO: ID_SOPORTE_CONTRATO }, 'contratoSave', 'formularioDOCUMENTOSOPORTECONTRATO', 'guardarDOCUMENTOSOPORTECONTRATO', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
            }, function (data) {
                    
                setTimeout(() => {

                    ID_SOPORTE_CONTRATO = data.soporte.ID_SOPORTE_CONTRATO
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_DOCUMENTOSOPORTECONTRATO').modal('hide')
                    document.getElementById('formularioDOCUMENTOSOPORTECONTRATO').reset();


                    
                    if ($.fn.DataTable.isDataTable('#Tabladocumentosoportecontrato')) {
                        Tabladocumentosoportecontrato.ajax.reload(null, false); 
                    }

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});

const Modaldocumetosoportecontrato = document.getElementById('miModal_DOCUMENTOSOPORTECONTRATO')
Modaldocumetosoportecontrato.addEventListener('hidden.bs.modal', event => {
    
    ID_SOPORTE_CONTRATO = 0
    document.getElementById('formularioDOCUMENTOSOPORTECONTRATO').reset();
   
    $('#miModal_RECIBOS_NOMINA .modal-title').html('Documentos de soporte contrato');

    document.getElementById('quitar_documentossoportecontrato').style.display = 'none';

    document.getElementById('ERROR_DOCUMENTOSOPORTECONTRATO').style.display = 'none';


        document.getElementById('FECHAF_DOCUMENTOSOPORTECONTRATO').disabled = false;

})




function cargarTablaDocumentosSoporteContrato() {
    if ($.fn.DataTable.isDataTable('#Tabladocumentosoportecontrato')) {
        Tabladocumentosoportecontrato.clear().destroy();
    }

    Tabladocumentosoportecontrato = $("#Tabladocumentosoportecontrato").DataTable({
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
            data: { contrato: contrato_id }, 
            method: 'GET',
            cache: false,
            url: '/Tabladocumentosoportecontrato',  
            beforeSend: function () {
                $('#loadingIcon11').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon11').css('display', 'none');
                Tabladocumentosoportecontrato.columns.adjust().draw(); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon11').css('display', 'none');
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            },
            dataSrc: 'data'
        },
        columns: [
            { data: null, render: function(data, type, row, meta) { return meta.row + 1; }, className: 'text-center' },
            { data: 'NOMBRE_DOCUMENTOSOPORTECONTRATO', className: 'text-center' },
            {
                data: null,
                render: function (data, type, row) {
                    let fechaInicio = row.FECHAI_DOCUMENTOSOPORTECONTRATO;
                    let tipoDocumento = row.TIPO_DOCUMENTOSOPORTECONTRATO; 

                    if (tipoDocumento === "2") {  
                        return ` <span style="color: green;">(Vigente)</span>`;
                    } else {
                        let fechaFin = row.FECHAF_DOCUMENTOSOPORTECONTRATO;
                        let hoy = new Date();
                        let fechaFinDate = new Date(fechaFin);
                        let diferenciaDias = Math.ceil((fechaFinDate - hoy) / (1000 * 60 * 60 * 24));

                        let estadoTexto = diferenciaDias < 0 
                            ? `<span style="color: red;"> <br>(Terminado)</span>`
                            : `<span style="color: green;"> <br> (${diferenciaDias} días restantes)</span>`;

                        return `${fechaInicio} <br> ${fechaFin} ${estadoTexto}`;
                    }
                },
                className: 'text-center'
            },
            { data: 'BTN_DOCUMENTO', className: 'text-center' },
            { data: 'BTN_EDITAR', className: 'text-center' },
        ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all text-center' },
            { targets: 1, title: 'Nombre del documento', className: 'all text-center' },  
            { targets: 2, title: 'Fecha inicio <br> Fecha fin (Estado)', className: 'all text-center' },
            { targets: 3, title: 'Documento', className: 'all text-center' },  
            { targets: 4, title: 'Editar', className: 'all text-center' }, 
        ],
    });
}


$('#Tabladocumentosoportecontrato').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tabladocumentosoportecontrato.row(tr);

    ID_SOPORTE_CONTRATO = row.data().ID_SOPORTE_CONTRATO;

    editarDatoTabla(row.data(), 'formularioDOCUMENTOSOPORTECONTRATO', 'miModal_DOCUMENTOSOPORTECONTRATO', 1);

    $('#miModal_DOCUMENTOSOPORTECONTRATO .modal-title').html(row.data().NOMBRE_DOCUMENTOSOPORTECONTRATO);

    if (row.data().TIPO_DOCUMENTOSOPORTECONTRATO === "2") {
        $('#FECHAF_DOCUMENTOSOPORTECONTRATO').prop('disabled', true);
    } else {
        $('#FECHAF_DOCUMENTOSOPORTECONTRATO').prop('disabled', false);
    }
});


$('#Tabladocumentosoportecontrato').on('click', '.ver-archivo-soportescontratos', function () {
    var tr = $(this).closest('tr');
    var row = Tabladocumentosoportecontrato.row(tr);
    var id = $(this).data('id');

    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }

    var nombreDocumento = row.data().NOMBRE_DOCUMENTOSOPORTECONTRATO;
    var url = '/mostrardocumentosoportecontrato/' + id;
    
    abrirModal(url, nombreDocumento);
});



// <!-- ============================================================== -->
// <!--  RENOVACION CONTRATO-->
// <!-- ============================================================== -->

let fechaRenovacionGlobal = '';

let fechaInicioRenovacionGlobal = '';

document.addEventListener('DOMContentLoaded', function() {
    var archivorenovacion = document.getElementById('DOCUMENTOS_RENOVACION');
    var quitardocumentorenovacion = document.getElementById('quitar_documentorenovacion');
    var errorenovacion = document.getElementById('ERROR_DOCUMENTORENOVACION');

    if (archivorenovacion) {
        archivorenovacion.addEventListener('change', function() {
            var archivomedica = this.files[0];
            if (archivomedica && archivomedica.type === 'application/pdf') {
                if (errorenovacion) errorenovacion.style.display = 'none';
                if (quitardocumentorenovacion) quitardocumentorenovacion.style.display = 'block';
            } else {
                if (errorenovacion) errorenovacion.style.display = 'block';
                this.value = '';
                if (quitardocumentorenovacion) quitardocumentorenovacion.style.display = 'none';
            }
        });
        quitardocumentorenovacion.addEventListener('click', function() {
            archivorenovacion.value = ''; 
            quitardocumentorenovacion.style.display = 'none'; 
            if (errorenovacion) errorenovacion.style.display = 'none'; 
        });
    }
});



$("#guardarRENOVACION").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormularioV1('formularioRENOVACION');

    if (formularioValido) {

    if (ID_RENOVACION_CONTATO == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarRENOVACION')
            await ajaxAwaitFormData({ api: 10,CONTRATO_ID:contrato_id, CURP: curpSeleccionada , ID_RENOVACION_CONTATO: ID_RENOVACION_CONTATO }, 'contratoSave', 'formularioRENOVACION', 'guardarRENOVACION', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
                
            }, function (data) {
                    
                ID_RENOVACION_CONTATO = data.soporte.ID_RENOVACION_CONTATO
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_RENOVACION').modal('hide')
                    document.getElementById('formularioRENOVACION').reset();


                    
                    if ($.fn.DataTable.isDataTable('#Tablarenovacioncontrato')) {
                        Tablarenovacioncontrato.ajax.reload(null, false); 
                    }
            })
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarRENOVACION')
            await ajaxAwaitFormData({ api: 10,CONTRATO_ID:contrato_id, CURP: curpSeleccionada ,ID_RENOVACION_CONTATO: ID_RENOVACION_CONTATO }, 'contratoSave', 'formularioRENOVACION', 'guardarRENOVACION', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
            }, function (data) {
                    
                setTimeout(() => {

                    ID_RENOVACION_CONTATO = data.soporte.ID_RENOVACION_CONTATO
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_RENOVACION').modal('hide')
                    document.getElementById('formularioRENOVACION').reset();


                    
                    if ($.fn.DataTable.isDataTable('#Tablarenovacioncontrato')) {
                        Tablarenovacioncontrato.ajax.reload(null, false); 
                    }

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});



const Modalrenovacioncontrato = document.getElementById('miModal_RENOVACION')
Modalrenovacioncontrato.addEventListener('hidden.bs.modal', event => {
    
    ID_RENOVACION_CONTATO = 0
    document.getElementById('formularioRENOVACION').reset();
   
    $('#miModal_RENOVACION .modal-title').html('Renovación contrato');

    document.getElementById('quitar_documentorenovacion').style.display = 'none';

    document.getElementById('ERROR_DOCUMENTORENOVACION').style.display = 'none';

    document.getElementById('REQUIERE_ADENDA').style.display = 'none';

    document.getElementById('AGREGAR_ADENDA').style.display = 'none';


    $(".adendadiv").empty();


})


document.addEventListener('DOMContentLoaded', function () {
    const radioSi = document.getElementById('procedesi');
    const radioNo = document.getElementById('procedeno');
    const agregarAdendaDiv = document.getElementById('AGREGAR_ADENDA');

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
    const botonagregarevidencia = document.getElementById('botonagregarevidencia');
    const btnVerificacion = document.getElementById('btnVerificacion');


    botonagregarevidencia.addEventListener('click', function () {
        agregarevidencia();
    });

   
function agregarevidencia() {
    const divVerificacion = document.createElement('div');
    divVerificacion.classList.add('row', 'generarverificacion', 'mb-3');
    divVerificacion.innerHTML = `
        <div class="col-12">
            <div class="row">
                <div class="col-4 mt-2">
                    <label>Fecha Inicio *</label>
                    <div class="input-group">
                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" name="FECHAI_ADENDA[]">
                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                    </div>
                </div>
                <div class="col-4 mt-2">
                    <label>Fecha Fin *</label>
                    <div class="input-group">
                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" name="FECHAF_ADENDA[]">
                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                    </div>
                </div>
                <div class="col-4 mt-2">
                    <label>Comentario *</label>
                    <textarea class="form-control" name="COMENTARIO_ADENDA[]" rows="3"></textarea>
                </div>
                <div class="col-12 mt-2">
                    <label class="form-label">Subir documento (PDF) *</label>
                    <div class="d-flex align-items-center">
                        <input type="file" class="form-control me-2" name="DOCUMENTO_ADENDA[]" accept=".pdf">
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

    const contenedor = document.querySelector('.adendadiv');
    contenedor.appendChild(divVerificacion);

    const fechaInicioInput = divVerificacion.querySelector('input[name="FECHAI_ADENDA[]"]');

    if (fechaInicioRenovacionGlobal) {
        const [year, month, day] = fechaInicioRenovacionGlobal.split("-");
        const fechaMinima = new Date(year, month - 1, parseInt(day) + 1); 

        $(fechaInicioInput).datepicker({
            format: 'yyyy-mm-dd',
            weekStart: 1,
            autoclose: true,
            todayHighlight: true,
            language: 'es',
            startDate: fechaMinima
        }).on('click', function () {
            $(this).datepicker('setDate', $(this).val());
        });
    }


    const fechaFinInput = divVerificacion.querySelector('input[name="FECHAF_ADENDA[]"]');
    if (fechaRenovacionGlobal) {
        fechaFinInput.value = fechaRenovacionGlobal;
    }


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


function cargarTablaRenovacionContrato() {
    if ($.fn.DataTable.isDataTable('#Tablarenovacioncontrato')) {
        Tablarenovacioncontrato.clear().destroy();
    }

    Tablarenovacioncontrato = $("#Tablarenovacioncontrato").DataTable({
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
            data: { contrato: contrato_id }, 
            method: 'GET',
            cache: false,
            url: '/Tablarenovacioncontrato',  
            beforeSend: function () {
                $('#loadingIcon12').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon12').css('display', 'none');
                Tablarenovacioncontrato.columns.adjust().draw(); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon12').css('display', 'none');
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
    {
        data: null,
        render: function (data, type, row) {
            let html = `
                <div class="bloque-renovacion p-2 mb-2 border-bottom border-secondary">
                    <strong>Renovación contrato</strong>
                </div>
            `;
    
            if (row.ADENDAS && row.ADENDAS.length > 0) {
                row.ADENDAS.forEach((adenda, index) => {
                    html += `
                        <div class="bloque-adenda p-2 mb-2 border-bottom border-secondary bg-light">
                            <span class="text-muted">Adenda ${index + 1}</span>
                            <div class="text-sm text-dark mt-1">${adenda.COMENTARIO_ADENDA || ''}</div>
                        </div>
                    `;
                });
            }
    
            return html;
        },
        className: 'text-center'
    },
    
    {
        data: null,
        render: function (data, type, row) {
            const hoy = new Date();
            const fechaInicio = row.FECHAI_RENOVACION;
            const fechaFin = row.FECHAF_RENOVACION;
            const fechaFinDate = new Date(fechaFin);
            const diferenciaDias = Math.ceil((fechaFinDate - hoy) / (1000 * 60 * 60 * 24));

            const estado = diferenciaDias < 0
                ? `<span style="color: red;">(Terminado)</span>`
                : `<span style="color: green;">(${diferenciaDias} días restantes)</span>`;

            let html = `
                <div class="bloque-renovacion p-2 mb-2 border-bottom border-secondary">
                    <div><strong>${fechaInicio}</strong></div>
                    <div><strong>${fechaFin}</strong></div>
                    <div>${estado}</div>
                </div>
            `;

            if (row.ADENDAS && row.ADENDAS.length > 0) {
                row.ADENDAS.forEach(adenda => {
                    html += `
                        <div class="bloque-adenda p-2 mb-2 border-bottom border-secondary bg-light">
                            <div>${adenda.FECHAI_ADENDA}</div>
                            <div>${adenda.FECHAF_ADENDA}</div>
                        </div>
                    `;
                });
            }

            return html;
        },
        className: 'text-center'
    },
   {
        data: null,
        render: function (data, type, row) {
            let html = `
                <div class="bloque-renovacion p-2 mb-2 border-bottom border-secondary">
                    ${row.BTN_DOCUMENTO || ''}
                </div>
            `;

            if (row.ADENDAS && row.ADENDAS.length > 0) {
                row.ADENDAS.forEach(adenda => {
                    html += `
                        <div class="bloque-adenda p-2 mb-2 border-bottom border-secondary bg-light">
                            ${adenda.BTN_DOCUMENTO || ''}
                        </div>
                    `;
                });
            }

            return html;
        },
        className: 'text-center'
    },
    {
        data: 'BTN_EDITAR',
        className: 'text-center'
    }
    ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all text-center' },
            { targets: 1, title: 'Nombre del documento', className: 'all text-center' },  
            { targets: 2, title: 'Fecha inicio <br> Fecha fin (Estado)', className: 'all text-center' },  
            { targets: 3, title: 'Documento', className: 'all text-center' },  
            { targets: 4, title: 'Editar', className: 'all text-center' }, 
        ],
    });
}


$('#Tablarenovacioncontrato').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablarenovacioncontrato.row(tr);

    ID_RENOVACION_CONTATO = row.data().ID_RENOVACION_CONTATO;

    editarDatoTabla(row.data(), 'formularioRENOVACION', 'miModal_RENOVACION', 1);

    $('#miModal_RENOVACION .modal-title').html(row.data().NOMBRE_DOCUMENTO_RENOVACION);


    document.getElementById('REQUIERE_ADENDA').style.display = 'block';

  fechaRenovacionGlobal = row.data().FECHAF_RENOVACION || ''; 
    fechaInicioRenovacionGlobal = row.data().FECHAI_RENOVACION || '';

    if (row.data().PROCEDE_ADENDA == "1") {
        document.getElementById('AGREGAR_ADENDA').style.display = 'block';
        document.getElementById('procedesi').checked = true;
    } else if (row.data().PROCEDE_ADENDA == "2") {
        document.getElementById('AGREGAR_ADENDA').style.display = 'none';
        document.getElementById('procedeno').checked = true;
    } else {
        document.getElementById('AGREGAR_ADENDA').style.display = 'none';
        document.getElementById('procedesi').checked = false;
        document.getElementById('procedeno').checked = false;
    }

    $(".adendadiv").empty();

if (row.data().ADENDAS && row.data().ADENDAS.length > 0) {
        obtenerAdendas(row.data().ADENDAS);
    }
});


function obtenerAdendas(adendas) {
    const contenedor = document.querySelector('.adendadiv');
    contenedor.innerHTML = '';

    adendas.forEach(function (item, index) {
        const divVerificacion = document.createElement('div');
        divVerificacion.classList.add('row', 'generarverificacion', 'mb-3');

        divVerificacion.innerHTML = `
            <div class="col-12 mb-2">
                <label>Adenda ${index + 1}</label>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-4 mt-2">
                        <label>Fecha Inicio *</label>
                        <div class="input-group">
                            <input type="text" class="form-control mydatepicker" name="FECHAI_ADENDA[]" value="${item.FECHAI_ADENDA || ''}" placeholder="aaaa-mm-dd">
                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                        </div>
                    </div>
                    <div class="col-4 mt-2">
                        <label>Fecha Fin *</label>
                        <div class="input-group">
                            <input type="text" class="form-control mydatepicker" name="FECHAF_ADENDA[]" value="${item.FECHAF_ADENDA || ''}" placeholder="aaaa-mm-dd" max="${fechaRenovacionGlobal}">
                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                        </div>
                    </div>
                    <div class="col-4 mt-2">
                        <label>Comentario *</label>
                        <textarea class="form-control" name="COMENTARIO_ADENDA[]" rows="3">${item.COMENTARIO_ADENDA || ''}</textarea>
                    </div>
                    <div class="col-12 mt-2">
                        <label class="form-label">Subir documento (PDF) *</label>
                        <div class="d-flex align-items-center">
                            <input type="file" class="form-control me-2" name="DOCUMENTO_ADENDA[]" accept=".pdf">
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



$('#Tablarenovacioncontrato').on('click', '.ver-archivo-informacionrenovacion', function () {
    var tr = $(this).closest('tr');
    var row = Tablarenovacioncontrato.row(tr);
    var id = $(this).data('id');

    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }

    var nombreDocumento = row.data().NOMBRE_DOCUMENTO_RENOVACION;
    var url = '/mostrardocumentorenovacion/' + id;
    
    abrirModal(url, nombreDocumento);
});




$('#Tablarenovacioncontrato').on('click', '.ver-archivo-informacionadenda', function () {
    var id = $(this).data('id');
    if (!id) {
        alert('ARCHIVO NO ENCONTRADO');
        return;
    }
    var url = '/mostraradenda/' + id;
    abrirModal(url, 'Archivo adenda');
});


// <!-- ============================================================== -->
// <!--INFORMACION MEDICA-->
// <!-- ============================================================== -->



$("#NUEVA_INFORMACIONMEDICA").click(function (e) {
    e.preventDefault();


       
    $('#formularioINFORMACION').each(function(){
        this.reset();
    });

    $(".observacionesdiv").empty();

    $("#miModal_INFORMACION_MEDICA").modal("show");


});




document.addEventListener('DOMContentLoaded', function() {
    var archivoinformacion = document.getElementById('DOCUMENTO_INFORMACION_MEDICA');
    var quitarinformacion = document.getElementById('quitar_informacion_medica');
    var errorinformacion = document.getElementById('INFORMACIONMEDICA_ERROR');

    if (archivoinformacion) {
        archivoinformacion.addEventListener('change', function() {
            var archivomedica = this.files[0];
            if (archivomedica && archivomedica.type === 'application/pdf') {
                if (errorinformacion) errorinformacion.style.display = 'none';
                if (quitarinformacion) quitarinformacion.style.display = 'block';
            } else {
                if (errorinformacion) errorinformacion.style.display = 'block';
                this.value = '';
                if (quitarinformacion) quitarinformacion.style.display = 'none';
            }
        });
        quitarinformacion.addEventListener('click', function() {
            archivoinformacion.value = ''; 
            quitarinformacion.style.display = 'none'; 
            if (errorinformacion) errorinformacion.style.display = 'none'; 
        });
    }
});

$("#guardarINFORMACIONMEDICA").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormularioV1('formularioINFORMACION');

    if (formularioValido) {



        var observacion = [];
        $(".generarobervaciones").each(function() {
            var observaciones = {
                'OBSERVACIONES': $(this).find("textarea[name='OBSERVACIONES']").val()
            };
            observacion.push(observaciones);
        });



        const requestData = {
            api: 5,
            ID_INFORMACION_MEDICA: ID_INFORMACION_MEDICA,
            CONTRATO_ID: contrato_id,
            CURP: curpSeleccionada ,
            OBSERVACIONES_SOLICITUD: JSON.stringify(observacion)


        };



        if (ID_INFORMACION_MEDICA == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarINFORMACIONMEDICA')
            await ajaxAwaitFormData(requestData , 'contratoSave', 'formularioINFORMACION', 'guardarINFORMACIONMEDICA', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
                
            }, function (data) {
                    
                ID_INFORMACION_MEDICA = data.soporte.ID_INFORMACION_MEDICA
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_INFORMACION_MEDICA').modal('hide')
                    document.getElementById('formularioINFORMACION').reset();

                    
                    if ($.fn.DataTable.isDataTable('#Tablainformacionmedica')) {
                        Tablainformacionmedica.ajax.reload(null, false); 
                    }

            })
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarINFORMACIONMEDICA')
            await ajaxAwaitFormData( requestData, 'contratoSave', 'formularioINFORMACION', 'guardarINFORMACIONMEDICA', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
            }, function (data) {
                    
                setTimeout(() => {

                    ID_INFORMACION_MEDICA = data.soporte.ID_INFORMACION_MEDICA
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_INFORMACION_MEDICA').modal('hide')
                    document.getElementById('formularioINFORMACION').reset();


                    
                    if ($.fn.DataTable.isDataTable('#Tablainformacionmedica')) {
                        Tablainformacionmedica.ajax.reload(null, false); 
                    }

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});

const Modalinformacionmedica = document.getElementById('miModal_INFORMACION_MEDICA')
Modalinformacionmedica.addEventListener('hidden.bs.modal', event => {

    ID_INFORMACION_MEDICA = 0
    document.getElementById('formularioINFORMACION').reset();
   
    $('#miModal_INFORMACION_MEDICA .modal-title').html('Información medica');

    document.getElementById('quitar_informacion_medica').style.display = 'none';

    document.getElementById('INFORMACIONMEDICA_ERROR').style.display = 'none';

})

function cargarTablaInformacionMedica() {
    if ($.fn.DataTable.isDataTable('#Tablainformacionmedica')) {
        Tablainformacionmedica.clear().destroy();
    }

    Tablainformacionmedica = $("#Tablainformacionmedica").DataTable({
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
            data: { contrato: contrato_id }, 
            method: 'GET',
            cache: false,
            url: '/Tablainformacionmedica',  
            beforeSend: function () {
                $('#loadingIcon3').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon3').css('display', 'none');
                Tablainformacionmedica.columns.adjust().draw(); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon3').css('display', 'none');
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            },
            dataSrc: 'data'
        },
        columns: [
            { data: null, render: function(data, type, row, meta) { return meta.row + 1; }, className: 'text-center' },
            { data: 'NOMBRE_DOCUMENTO_INFORMACION', className: 'text-center' },
            { data: 'BTN_DOCUMENTO', className: 'text-center' },
            { data: 'BTN_EDITAR', className: 'text-center' },
        ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all text-center' },
            { targets: 1, title: 'Nombre del documento', className: 'all text-center' },  
            { targets: 2, title: 'Documento', className: 'all text-center' },  
            { targets: 3, title: 'Editar', className: 'all text-center' }, 

        ],
       
    });
}

$('#Tablainformacionmedica').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablainformacionmedica.row(tr);
    var data = row.data(); 


    ID_INFORMACION_MEDICA = row.data().ID_INFORMACION_MEDICA;

      $(".observacionesdiv").empty();
    obtenerObservaciones(row);

    editarDatoTabla(row.data(), 'formularioINFORMACION', 'miModal_INFORMACION_MEDICA', 1);

    $('#miModal_INFORMACION_MEDICA .modal-title').html(row.data().NOMBRE_DOCUMENTO_INFORMACION);


});

$('#Tablainformacionmedica').on('click', '.ver-archivo-informacionmedica', function () {
    var tr = $(this).closest('tr');
    var row = Tablainformacionmedica.row(tr);
    var id = $(this).data('id');

    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }

    var nombreDocumento = row.data().NOMBRE_DOCUMENTO_INFORMACION;
    var url = '/mostrarinformacionmedica/' + id;
    
    abrirModal(url, nombreDocumento);
});



document.addEventListener("DOMContentLoaded", function () {
    const botonAgregarDoc = document.getElementById('botonAgregarobservaciones');
    botonAgregarDoc.addEventListener('click', function () {
        agregarobservaciones();
    });

    function agregarobservaciones() {
        const divDocumentoOfi = document.createElement('div');
        divDocumentoOfi.classList.add('row', 'generarobervaciones', 'mb-3');
        divDocumentoOfi.innerHTML = `
        
            <div class="col-12">
              <div class="mb-3">
                <label class="form-label">Observación</label>
                <textarea class="form-control"  name="OBSERVACIONES" rows="2"></textarea>
              </div>
            </div>

            <br>
            <div class="col-12 mt-4">
                <div class="form-group" style="text-align: center;">
                    <button type="button" class="btn btn-danger botonEliminarObservacion">Eliminar observación <i class="bi bi-trash-fill"></i></button>
                </div>
            </div>
        `;
        const contenedor = document.querySelector('.observacionesdiv');
        contenedor.appendChild(divDocumentoOfi);

        const botonEliminar = divDocumentoOfi.querySelector('.botonEliminarObservacion');
        botonEliminar.addEventListener('click', function () {
            contenedor.removeChild(divDocumentoOfi);
        });
    }


});




function obtenerObservaciones(data) {
    let row = data.data().OBSERVACIONES_SOLICITUD;
    var observaciones = JSON.parse(row);

    $.each(observaciones, function (index, contacto) {
        var observa = contacto.OBSERVACIONES;
     

        const divDocumentoOfi = document.createElement('div');
        divDocumentoOfi.classList.add('row', 'generarobervaciones', 'mb-3');
        divDocumentoOfi.innerHTML = `
         
            <div class="col-12">
              <div class="mb-3">
                <label class="form-label">Observación</label>
                    <textarea class="form-control" name="OBSERVACIONES" rows="2">${observa}</textarea>
              </div>
            </div>
            
            <br>
            <div class="col-12 mt-4">
                <div class="form-group" style="text-align: center;">
                    <button type="button" class="btn btn-danger botonEliminarObservacion">Eliminar observación <i class="bi bi-trash-fill"></i></button>
                </div>
            </div>
        `;
        const contenedor = document.querySelector('.observacionesdiv');
        contenedor.appendChild(divDocumentoOfi);

      
        const botonEliminar = divDocumentoOfi.querySelector('.botonEliminarObservacion');
        botonEliminar.addEventListener('click', function () {
            contenedor.removeChild(divDocumentoOfi);
        });
    });

}


// <!-- ============================================================== -->
// <!--INCIDENCIAS-->
// <!-- ============================================================== -->

document.addEventListener('DOMContentLoaded', function() {
    var archivoincidencias = document.getElementById('DOCUMENTO_INCIDENCIAS');
    var quitarincidencias = document.getElementById('quitar_incidencias');
    var errorincidencias = document.getElementById('INCIDENCIAS_ERROR');

    if (archivoincidencias) {
        archivoincidencias.addEventListener('change', function() {
            var archivomedica = this.files[0];
            if (archivomedica && archivomedica.type === 'application/pdf') {
                if (errorincidencias) errorincidencias.style.display = 'none';
                if (quitarincidencias) quitarincidencias.style.display = 'block';
            } else {
                if (errorincidencias) errorincidencias.style.display = 'block';
                this.value = '';
                if (quitarincidencias) quitarincidencias.style.display = 'none';
            }
        });
        quitarincidencias.addEventListener('click', function() {
            archivoincidencias.value = ''; 
            quitarincidencias.style.display = 'none'; 
            if (errorincidencias) errorincidencias.style.display = 'none'; 
        });
    }
});

$("#guardarINCIDENCIAS").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormularioV1('formularioINCIDENCIAS');

    if (formularioValido) {

    if (ID_INCIDENCIAS == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarINCIDENCIAS')
            await ajaxAwaitFormData({ api: 6,CONTRATO_ID:contrato_id, CURP: curpSeleccionada , ID_INCIDENCIAS: ID_INCIDENCIAS }, 'contratoSave', 'formularioINCIDENCIAS', 'guardarINCIDENCIAS', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
                
            }, function (data) {
                    
                ID_INCIDENCIAS = data.soporte.ID_INCIDENCIAS
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_INCIDENCIAS').modal('hide')
                    document.getElementById('formularioINCIDENCIAS').reset();

                    
                    if ($.fn.DataTable.isDataTable('#Tablaincidencias')) {
                        Tablaincidencias.ajax.reload(null, false); 
                    }

            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarINCIDENCIAS')
            await ajaxAwaitFormData({ api: 6,CONTRATO_ID:contrato_id, CURP: curpSeleccionada ,ID_INCIDENCIAS: ID_INCIDENCIAS }, 'contratoSave', 'formularioINCIDENCIAS', 'guardarINCIDENCIAS', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
            }, function (data) {
                    
                setTimeout(() => {

                    ID_INCIDENCIAS = data.soporte.ID_INCIDENCIAS
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_INCIDENCIAS').modal('hide')
                    document.getElementById('formularioINCIDENCIAS').reset();


                    
                    if ($.fn.DataTable.isDataTable('#Tablaincidencias')) {
                        Tablaincidencias.ajax.reload(null, false); 
                    }

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});

const Modalincidendia = document.getElementById('miModal_INCIDENCIAS')
Modalincidendia.addEventListener('hidden.bs.modal', event => {

    ID_INCIDENCIAS = 0

    document.getElementById('formularioINCIDENCIAS').reset();
   
    $('#miModal_INCIDENCIAS .modal-title').html('Incidencias');

    document.getElementById('quitar_incidencias').style.display = 'none';

    document.getElementById('INCIDENCIAS_ERROR').style.display = 'none';

})

function cargarTablaIncidencias() {
    if ($.fn.DataTable.isDataTable('#Tablaincidencias')) {
        Tablaincidencias.clear().destroy();
    }

    Tablaincidencias = $("#Tablaincidencias").DataTable({
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
            data: { contrato: contrato_id }, 
            method: 'GET',
            cache: false,
            url: '/Tablaincidencias',  
            beforeSend: function () {
                $('#loadingIcon4').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon4').css('display', 'none');
                Tablaincidencias.columns.adjust().draw(); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon4').css('display', 'none');
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            },
            dataSrc: 'data'
        },
        columns: [
            { data: null, render: function(data, type, row, meta) { return meta.row + 1; }, className: 'text-center' },
            { data: 'NOMBRE_DOCUMENTO_INCIDENCIAS', className: 'text-center' },
            { data: 'BTN_DOCUMENTO', className: 'text-center' },
            { data: 'BTN_EDITAR', className: 'text-center' },
        ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all text-center' },
            { targets: 1, title: 'Nombre del documento', className: 'all text-center' },  
            { targets: 2, title: 'Documento', className: 'all text-center' },  
            { targets: 3, title: 'Editar', className: 'all text-center' }, 

        ],
       
    });
}

$('#Tablaincidencias').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablaincidencias.row(tr);

    ID_INCIDENCIAS = row.data().ID_INCIDENCIAS;

    editarDatoTabla(row.data(), 'formularioINCIDENCIAS', 'miModal_INCIDENCIAS', 1);

    $('#miModal_INCIDENCIAS .modal-title').html(row.data().NOMBRE_DOCUMENTO_INCIDENCIAS);


});

$('#Tablaincidencias').on('click', '.ver-archivo-incidencias', function () {
    var tr = $(this).closest('tr');
    var row = Tablaincidencias.row(tr);
    var id = $(this).data('id');

    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }

    var nombreDocumento = row.data().NOMBRE_DOCUMENTO_INCIDENCIAS;
    var url = '/mostrarincidencias/' + id;
    
    abrirModal(url, nombreDocumento);
});



////// PERMISO DE AUSENCIA


function cargarTablaAusenciaEmpleado() {
    if ($.fn.DataTable.isDataTable('#Tablaspermisosrecempleados')) {
        Tablaspermisosrecempleados.clear().destroy();
    }

    Tablaspermisosrecempleados = $("#Tablaspermisosrecempleados").DataTable({
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
        order: [[1, 'asc']],

        ajax: {
            dataType: 'json',
            data: { contrato: contrato_id },
            method: 'GET',
            cache: false,
            url: '/Tablaspermisosrecempleados',
            beforeSend: function () {
                $('#loadingIcon15').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon15').css('display', 'none');
                Tablaspermisosrecempleados.columns.adjust().draw();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon15').css('display', 'none');
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            },
            dataSrc: 'data'
        },

        columns: [
            {
                data: 'CONCEPTO_PERMISO',
                render: function (data, type, row) {
                    const tipos = {
                        1: 'Permiso',
                        2: 'Incapacidad',
                        3: 'Omitir registro en el checador',
                        4: 'Fallecimiento',
                        5: 'Matrimonio',
                        6: 'Permiso de maternidad',
                        7: 'Permiso de paternidad',
                        8: 'Compensatorio',
                        9: 'Otros'
                    };
                    return tipos[data] || '-';
                }
            },
            {
                data: 'FECHA_SALIDA',
            },

            {
                data: null,
                render: function (data, type, row) {
                    return `
                        <div>
                            <span><strong>Inicial:</strong> ${row.FECHA_INICIAL_PERMISO || '-'}</span><br>
                            <span><strong>Final:</strong> ${row.FECHA_FINAL_PERMISO || '-'}</span>
                        </div>`;
                }
            },
            {
                data: 'BTN_DOCUMENTO',
                className: 'text-center',
                render: function (data, type, row) {
                    return row.DOCUMENTO_SOLICITUD ? data : '-';
                }
            },
            { data: 'BTN_EDITAR' },

        ],

        columnDefs: [
            { targets: 0, title: 'Tipo de ausencia', className: 'all text-center' },
            { targets: 1, title: 'Fecha de solicitud', className: 'all text-center' },
            { targets: 2, title: 'Fecha inicial / final', className: 'all text-center' },
            { targets: 3, title: 'Visualizar documento', className: 'all text-center' },
            { targets: 4, title: 'Visualizar', className: 'all text-center' },
        ],
    });
}


const Modalmr = document.getElementById('miModal_PERMISORECEMPLEADO');
Modalmr.addEventListener('hidden.bs.modal', event => {

    ID_FORMULARIO_RECURSOS_EMPLEADOS = 0;
    document.getElementById('formularioPERMISORECEMPLEADO').reset();

    $('#EXPLIQUE_PERMISO').hide();
    
});


$('#Tablaspermisosrecempleados').on('click', 'button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablaspermisosrecempleados.row(tr);

    ID_FORMULARIO_RECURSOS_EMPLEADOS = row.data().ID_FORMULARIO_RECURSOS_EMPLEADOS;

    editarDatoTabla(row.data(), 'formularioPERMISORECEMPLEADO', 'miModal_PERMISORECEMPLEADO', 1);
    
    if (row.data().TIPO_SOLICITUD === "1") {
        $('#PERMISO_AUSENCIA').show();
    } else if (row.data().TIPO_SOLICITUD === "2") {
    } else if (row.data().TIPO_SOLICITUD === "3") {
    }

    if (row.data().CONCEPTO_PERMISO === "9") {
        $('#EXPLIQUE_PERMISO').show();
    } else {
        $('#EXPLIQUE_PERMISO').hide();
    }

  
});





$('#Tablaspermisosrecempleados').on('click', '.ver-archivo-recempleado', function () {
    var tr = $(this).closest('tr');
    var id = $(this).data('id');

    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }

    var url = '/mostrardocumentosrecempleados/' + id;
    
    abrirModal(url, 'Documento');
});





// <!-- ============================================================== -->
// <!-- SOLICITUD VACACIONES-->
// <!-- ============================================================== -->


function cargarTablaSolicitudvacaciones() {
    if ($.fn.DataTable.isDataTable('#Tablasolicitudvacaciones')) {
        Tablasolicitudvacaciones.clear().destroy();
    }

    Tablasolicitudvacaciones = $("#Tablasolicitudvacaciones").DataTable({
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
            data: { contrato: contrato_id },
            method: 'GET',
            cache: false,
            url: '/Tablasolicitudvacaciones',
            beforeSend: function () {
                $('#loadingIcon14').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon14').css('display', 'none');
                Tablasolicitudvacaciones.columns.adjust().draw();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon14').css('display', 'none');
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            },
            dataSrc: 'data'
        },
        columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { data: 'FECHA_SALIDA' },
            { data: 'ANIO_SERVICIO_VACACIONES' },
            {
                data: null,
                render: function (data, type, row) {
                    return `
                        <div>
                            <span><strong>Desde:</strong> ${row.DESDE_ANIO_VACACIONES || '-'}</span><br>
                            <span><strong>Hasta:</strong> ${row.HASTA_ANIO_VACACIONES || '-'}</span>
                        </div>`;
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    return `
                        <div>
                            <span><strong>Inicio:</strong> ${row.FECHA_INICIO_VACACIONES || '-'}</span><br>
                            <span><strong>Fin:</strong> ${row.FECHA_TERMINACION_VACACIONES || '-'}</span>
                        </div>`;
                }
            },
            { data: 'DIAS_DISFRUTAR_VACACIONES' },
            {
                data: 'BTN_DOCUMENTO',
                className: 'text-center',
                render: function (data, type, row) {
                    return row.DOCUMENTO_SOLICITUD ? data : '-';
                }
            },
            { data: 'BTN_EDITAR' },
        ],

        columnDefs: [
            { targets: 0, title: '#', className: 'all text-center' },
            { targets: 1, title: 'Fecha de solicitud', className: 'all text-center' },
            { targets: 2, title: 'Año de servicio', className: 'all text-center' },
            { targets: 3, title: 'Período a disfrutar', className: 'all text-center' },
            { targets: 4, title: 'Fecha inicio/terminación', className: 'all text-center' },
            { targets: 5, title: 'Días a disfrutar', className: 'all text-center' },
            { targets: 6, title: 'Visualizar documento', className: 'all text-center' },
            { targets: 7, title: 'Visualizar', className: 'all text-center' },
        ],
    });
}


$('#Tablasolicitudvacaciones').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablasolicitudvacaciones.row(tr);

    ID_FORMULARIO_RECURSOS_EMPLEADOS = row.data().ID_FORMULARIO_RECURSOS_EMPLEADOS;

    editarDatoTabla(row.data(), 'formularioRECURSOSEMPLEADO', 'miModal_RECURSOSEMPLEADOS', 1);



});

$('#Tablasolicitudvacaciones').on('click', '.ver-archivo-recempleado', function () {
    var tr = $(this).closest('tr');
    var id = $(this).data('id');

    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }

    var url = '/mostrardocumentosrecempleados/' + id;
    
    abrirModal(url, 'Documento');
});



// <!-- ============================================================== -->
// <!--ACCIONES DISCIPLINARIAS -->
// <!-- ============================================================== -->

document.addEventListener('DOMContentLoaded', function() {
    var archvioaccciones = document.getElementById('DOCUMENTO_ACCIONES_DISCIPLINARIAS');
    var quitacciones = document.getElementById('quitar_acciones_disciplinarias');
    var erroracciones = document.getElementById('ACCIONES_DISCIPLINARIAS_ERROR');

    if (archvioaccciones) {
        archvioaccciones.addEventListener('change', function() {
            var archivomedica = this.files[0];
            if (archivomedica && archivomedica.type === 'application/pdf') {
                if (erroracciones) erroracciones.style.display = 'none';
                if (quitacciones) quitacciones.style.display = 'block';
            } else {
                if (erroracciones) erroracciones.style.display = 'block';
                this.value = '';
                if (quitacciones) quitacciones.style.display = 'none';
            }
        });
        quitacciones.addEventListener('click', function() {
            archvioaccciones.value = ''; 
            quitacciones.style.display = 'none'; 
            if (erroracciones) erroracciones.style.display = 'none'; 
        });
    }
});

$("#guardarACCIONES").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormularioV1('formularioACCIONES_DISCIPLINARIAS');

    if (formularioValido) {

    if (ID_ACCIONES_DISCIPLINARIAS == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarACCIONES')
            await ajaxAwaitFormData({ api: 7,CONTRATO_ID:contrato_id, CURP: curpSeleccionada , ID_ACCIONES_DISCIPLINARIAS: ID_ACCIONES_DISCIPLINARIAS }, 'contratoSave', 'formularioACCIONES_DISCIPLINARIAS', 'guardarACCIONES', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
                
            }, function (data) {
                    
                ID_ACCIONES_DISCIPLINARIAS = data.soporte.ID_ACCIONES_DISCIPLINARIAS
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_ACCIONES_DISCIPLINARIAS').modal('hide')
                    document.getElementById('formularioACCIONES_DISCIPLINARIAS').reset();

                    
                    if ($.fn.DataTable.isDataTable('#Tablaccionesdisciplinarias')) {
                        Tablaccionesdisciplinarias.ajax.reload(null, false); 
                    }

            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarACCIONES')
            await ajaxAwaitFormData({ api: 7,CONTRATO_ID:contrato_id, CURP: curpSeleccionada ,ID_ACCIONES_DISCIPLINARIAS: ID_ACCIONES_DISCIPLINARIAS }, 'contratoSave', 'formularioACCIONES_DISCIPLINARIAS', 'guardarACCIONES', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
            }, function (data) {
                    
                setTimeout(() => {

                    ID_ACCIONES_DISCIPLINARIAS = data.soporte.ID_ACCIONES_DISCIPLINARIAS
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_ACCIONES_DISCIPLINARIAS').modal('hide')
                    document.getElementById('formularioACCIONES_DISCIPLINARIAS').reset();


                    
                    if ($.fn.DataTable.isDataTable('#Tablaccionesdisciplinarias')) {
                        Tablaccionesdisciplinarias.ajax.reload(null, false); 
                    }

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});

const Modalacciones = document.getElementById('miModal_ACCIONES_DISCIPLINARIAS')
Modalacciones.addEventListener('hidden.bs.modal', event => {

    ID_ACCIONES_DISCIPLINARIAS = 0

    document.getElementById('formularioACCIONES_DISCIPLINARIAS').reset();
   
    $('#miModal_ACCIONES_DISCIPLINARIAS .modal-title').html('Acciones disciplinarias');

    document.getElementById('quitar_acciones_disciplinarias').style.display = 'none';

    document.getElementById('ACCIONES_DISCIPLINARIAS_ERROR').style.display = 'none';

})

function cargarTablaAccionesDisciplinarias() {
    if ($.fn.DataTable.isDataTable('#Tablaccionesdisciplinarias')) {
        Tablaccionesdisciplinarias.clear().destroy();
    }

    Tablaccionesdisciplinarias = $("#Tablaccionesdisciplinarias").DataTable({
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
            data: { contrato: contrato_id }, 
            method: 'GET',
            cache: false,
            url: '/Tablaccionesdisciplinarias',  
            beforeSend: function () {
                $('#loadingIcon5').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon5').css('display', 'none');
                Tablaccionesdisciplinarias.columns.adjust().draw(); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon5').css('display', 'none');
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            },
            dataSrc: 'data'
        },
        columns: [
            { data: null, render: function(data, type, row, meta) { return meta.row + 1; }, className: 'text-center' },
            { data: 'NOMBRE_DOCUMENTO_ACCIONES', className: 'text-center' },
            { data: 'BTN_DOCUMENTO', className: 'text-center' },
            { data: 'BTN_EDITAR', className: 'text-center' },
        ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all text-center' },
            { targets: 1, title: 'Nombre del documento', className: 'all text-center' },  
            { targets: 2, title: 'Documento', className: 'all text-center' },  
            { targets: 3, title: 'Editar', className: 'all text-center' }, 

        ],
       
    });
}

$('#Tablaccionesdisciplinarias').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablaccionesdisciplinarias.row(tr);

    ID_ACCIONES_DISCIPLINARIAS = row.data().ID_ACCIONES_DISCIPLINARIAS;

    editarDatoTabla(row.data(), 'formularioACCIONES_DISCIPLINARIAS', 'miModal_ACCIONES_DISCIPLINARIAS', 1);

    $('#miModal_ACCIONES_DISCIPLINARIAS .modal-title').html(row.data().NOMBRE_DOCUMENTO_ACCIONES);


});

$('#Tablaccionesdisciplinarias').on('click', '.ver-archivo-acciones', function () {
    var tr = $(this).closest('tr');
    var row = Tablaccionesdisciplinarias.row(tr);
    var id = $(this).data('id');

    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }

    var nombreDocumento = row.data().NOMBRE_DOCUMENTO_ACCIONES;
    var url = '/mostraracciones/' + id;
    
    abrirModal(url, nombreDocumento);
});


// <!-- ============================================================== -->
// <!--RECIBOS DE NOMINA-->
// <!-- ============================================================== -->

document.addEventListener('DOMContentLoaded', function() {
    var archivorecibo = document.getElementById('DOCUMENTO_RECIBO');
    var quitarecibo = document.getElementById('quitar_recibo');
    var errorecibo = document.getElementById('RECIBO_ERROR');

    if (archivorecibo) {
        archivorecibo.addEventListener('change', function() {
            var archivo = this.files[0];
            if (archivo && archivo.type === 'application/pdf') {
                if (errorecibo) errorecibo.style.display = 'none';
                if (quitarecibo) quitarecibo.style.display = 'block';
            } else {
                if (errorecibo) errorecibo.style.display = 'block';
                this.value = '';
                if (quitarecibo) quitarecibo.style.display = 'none';
            }
        });
        quitarecibo.addEventListener('click', function() {
            archivorecibo.value = ''; 
            quitarecibo.style.display = 'none'; 
            if (errorecibo) errorecibo.style.display = 'none'; 
        });
    }
});

$("#guardarRECIBONOMINA").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormularioV1('formularioRECIBO');

    if (formularioValido) {

    if (ID_RECIBOS_NOMINA == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarRECIBONOMINA')
            await ajaxAwaitFormData({ api: 8,CONTRATO_ID:contrato_id, CURP: curpSeleccionada , ID_RECIBOS_NOMINA: ID_RECIBOS_NOMINA }, 'contratoSave', 'formularioRECIBO', 'guardarRECIBONOMINA', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
                
            }, function (data) {
                    
                ID_RECIBOS_NOMINA = data.soporte.ID_RECIBOS_NOMINA
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_RECIBOS_NOMINA').modal('hide')
                    document.getElementById('formularioRECIBO').reset();

                    
                    if ($.fn.DataTable.isDataTable('#Tablarecibonomina')) {
                        Tablarecibonomina.ajax.reload(null, false); 
                    }

            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarRECIBONOMINA')
            await ajaxAwaitFormData({ api: 8,CONTRATO_ID:contrato_id, CURP: curpSeleccionada ,ID_RECIBOS_NOMINA: ID_RECIBOS_NOMINA }, 'contratoSave', 'formularioRECIBO', 'guardarRECIBONOMINA', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
            }, function (data) {
                    
                setTimeout(() => {

                    ID_RECIBOS_NOMINA = data.soporte.ID_RECIBOS_NOMINA
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_RECIBOS_NOMINA').modal('hide')
                    document.getElementById('formularioRECIBO').reset();


                    
                    if ($.fn.DataTable.isDataTable('#Tablarecibonomina')) {
                        Tablarecibonomina.ajax.reload(null, false); 
                    }

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});


const Modalrecibonomina = document.getElementById('miModal_RECIBOS_NOMINA')
Modalrecibonomina.addEventListener('hidden.bs.modal', event => {
    
    ID_RECIBOS_NOMINA = 0
    document.getElementById('formularioRECIBO').reset();
   
    $('#miModal_RECIBOS_NOMINA .modal-title').html('Recibo de nómina');

    document.getElementById('quitar_recibo').style.display = 'none';

    document.getElementById('RECIBO_ERROR').style.display = 'none';

})




    function contarDomingos(fechaInicio, fechaFin) {
        let inicio = new Date(fechaInicio);
        let fin = new Date(fechaFin);
        let domingos = 0;

        while (inicio <= fin) {
            if (inicio.getDay() === 0) { 
                domingos++;
            }
            inicio.setDate(inicio.getDate() + 1);
        }

        return domingos;
    }

    function calcularTotalDiasYHoras() {
        const diasLaborados = parseInt(document.getElementById("DIAS_LABORADOS_RECIBO").value) || 0;
        const fechaInicio = document.getElementById("FECHA_RECIBO").value;
        const fechaFin = document.getElementById("FECHAF_RECIBO").value;
        const diasFestivos = parseInt(document.getElementById("DIAS_FESTIVOS_RECIBO").value) || 0;

        if (!fechaInicio || !fechaFin) {
            return; 
        }

        const domingos = contarDomingos(fechaInicio, fechaFin);
        const totalDias = diasLaborados - domingos - diasFestivos;
        const totalDiasFinal = totalDias >= 0 ? totalDias : 0;

        document.getElementById("TOTAL_DIAS_RECIBO").value = totalDiasFinal;

        const horasHombre = totalDiasFinal * 8;
        document.getElementById("HHT_RECIBO").value = horasHombre;
    }

    document.getElementById("DIAS_LABORADOS_RECIBO").addEventListener("input", calcularTotalDiasYHoras);
    document.getElementById("FECHA_RECIBO").addEventListener("change", calcularTotalDiasYHoras);
    document.getElementById("FECHAF_RECIBO").addEventListener("change", calcularTotalDiasYHoras);
    document.getElementById("DIAS_FESTIVOS_RECIBO").addEventListener("input", calcularTotalDiasYHoras);


    
    
    
function cargarTablaRecibosNomina() {
    if ($.fn.DataTable.isDataTable('#Tablarecibonomina')) {
        Tablarecibonomina.clear().destroy();
    }

    Tablarecibonomina = $("#Tablarecibonomina").DataTable({
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
            data: { contrato: contrato_id }, 
            method: 'GET',
            cache: false,
            url: '/Tablarecibonomina',  
            beforeSend: function () {
                $('#loadingIcon6').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon6').css('display', 'none');
                Tablarecibonomina.columns.adjust().draw(); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon6').css('display', 'none');
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            },
            dataSrc: 'data'
        },
        columns: [
            { data: null, render: function(data, type, row, meta) { return meta.row + 1; }, className: 'text-center' },
            { data: 'NOMBRE_RECIBO', className: 'text-center' },
            { 
                data: 'FECHA_RECIBO', 
                className: 'text-center',
                render: function(data) { return data ? data : 'N/A'; }
            }, 
            { data: 'BTN_DOCUMENTO', className: 'text-center' },
            { data: 'BTN_EDITAR', className: 'text-center' },
        ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all text-center' },
            { targets: 1, title: 'Nombre del documento', className: 'all text-center' },  
            { targets: 2, title: 'Fecha del recibo', className: 'all text-center' },  
            { targets: 3, title: 'Documento', className: 'all text-center' },  
            { targets: 4, title: 'Editar', className: 'all text-center' }, 

        ],
       
    });
}

$('#Tablarecibonomina').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablarecibonomina.row(tr);

    ID_RECIBOS_NOMINA = row.data().ID_RECIBOS_NOMINA;

    editarDatoTabla(row.data(), 'formularioRECIBO', 'miModal_RECIBOS_NOMINA', 1);

    $('#miModal_RECIBOS_NOMINA .modal-title').html(row.data().NOMBRE_RECIBO);


});

$('#Tablarecibonomina').on('click', '.ver-archivo-recibonomina', function () {
    var tr = $(this).closest('tr');
    var row = Tablarecibonomina.row(tr);
    var id = $(this).data('id');

    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }

    var nombreDocumento = row.data().NOMBRE_RECIBO;
    var url = '/mostrarecibosnomina/' + id;
    
    abrirModal(url, nombreDocumento);
});


// <!-- ============================================================== -->
// <!-- ASIGNACION EMPLEADO-->
// <!-- ============================================================== -->



const Modalasignacion = document.getElementById('modalAsignacionColaborador')
Modalasignacion.addEventListener('hidden.bs.modal', event => {

    ID_ASINGACIONES_CONTRATACION = 0

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
    ID_ASINGACIONES_CONTRATACION = 0;


   window.listaEPP = [];
    actualizarTabla();
    $('#EPP_JSON').val('');


    $('#FIRMA_ASIGNACION').show();
    $('#SUBIR_DOCUMENTO_ASIGNACION').hide();

    $('#modalAsignacionColaborador').modal('show');

    $('#modalAsignacionColaborador').one('shown.bs.modal', function () {
        cargarTablaAsignacionesModal(); 
    });

    $('#ASIGANCION_EPP').hide();

});



function cargarTablaAsignacionesModal() {

    $('#Tablasignacioncolaborador').DataTable({
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
            url: '/Tablasignacioncolaborador',
            data: function (d) {
                d.curp = curpSeleccionada;
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

    $('#Tablasignacioncolaborador tbody input.seleccionar-equipo:checked')
        .each(function () {
            asignaciones.push($(this).val());
        });

    $('#ASIGNACIONES_ID').val(JSON.stringify(asignaciones));
}


$("#guardarASIGNACIONES").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario3($('#formularioASIGNACIONES'))

    if (formularioValido) {


        if (ID_ASINGACIONES_CONTRATACION == 0) {
            setAsignacionesSeleccionadas();
        }

        
    if (ID_ASINGACIONES_CONTRATACION == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarASIGNACIONES')
            await ajaxAwaitFormData({ api: 12,CONTRATO_ID:contrato_id, CURP: curpSeleccionada , ID_ASINGACIONES_CONTRATACION: ID_ASINGACIONES_CONTRATACION }, 'contratoSave', 'formularioASIGNACIONES', 'guardarASIGNACIONES', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
                
            }, function (data) {
                    
                ID_ASINGACIONES_CONTRATACION = data.soporte.ID_ASINGACIONES_CONTRATACION
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#modalAsignacionColaborador').modal('hide')
                    document.getElementById('formularioASIGNACIONES').reset();

                    
                    if ($.fn.DataTable.isDataTable('#Tablasignacioncolaboradorgeneral')) {
                        Tablasignacioncolaboradorgeneral.ajax.reload(null, false); 
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
            await ajaxAwaitFormData({ api: 12,CONTRATO_ID:contrato_id, CURP: curpSeleccionada ,ID_ASINGACIONES_CONTRATACION: ID_ASINGACIONES_CONTRATACION }, 'contratoSave', 'formularioASIGNACIONES', 'guardarASIGNACIONES', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
            }, function (data) {
                    
                setTimeout(() => {

                    ID_ASINGACIONES_CONTRATACION = data.soporte.ID_ASINGACIONES_CONTRATACION
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#modalAsignacionColaborador').modal('hide')
                    document.getElementById('formularioASIGNACIONES').reset();

                    if ($.fn.DataTable.isDataTable('#Tablasignacioncolaboradorgeneral')) {
                        Tablasignacioncolaboradorgeneral.ajax.reload(null, false); 
                    }

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});


function cargarTablasingnaciongeneral() {
    if ($.fn.DataTable.isDataTable('#Tablasignacioncolaboradorgeneral')) {
        Tablasignacioncolaboradorgeneral.clear().destroy();
    }

    Tablasignacioncolaboradorgeneral = $("#Tablasignacioncolaboradorgeneral").DataTable({
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
             data: { contrato: contrato_id }, 
            method: 'GET',
            cache: false,
            url: '/Tablasignacioncolaboradorgeneral',  
            beforeSend: function () {
                $('#loadingIcon16').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon16').css('display', 'none');
                Tablasignacioncolaboradorgeneral.columns.adjust().draw(); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon16').css('display', 'none');
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
        `/pdfAsignacion/${id}`,
        '_blank'
    );
});

$(document).on('click', '.descargar-epp', function () {
    const id = $(this).data('id');

    window.open(
        `/pdfAsignacionEpp/${id}`,
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



$('#Tablasignacioncolaboradorgeneral').on('click', 'td>button.EDITAR', function () {

    var tr = $(this).closest('tr');
    var row = Tablasignacioncolaboradorgeneral.row(tr);

    ID_ASINGACIONES_CONTRATACION =
        row.data().GRUPO_ID || row.data().ID_ASINGACIONES_CONTRATACION;


    $('#FIRMA_ASIGNACION').hide();
    $('#SUBIR_DOCUMENTO_ASIGNACION').show();

    editarDatoTabla(row.data(), 'formularioASIGNACIONES', 'modalAsignacionColaborador', 1);


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
    $('#modalAsignacionColaborador').modal('show');

    $('#modalAsignacionColaborador').one('shown.bs.modal', function () {
        cargarTablaAsignacionesModalEditar(); 
    });
});



function cargarTablaAsignacionesModalEditar() {

    $('#Tablasignacioncolaborador').DataTable({
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
            url: '/TablasignacioncolaboradorEditar',
            data: {
                id_asignacion_contratacion: ID_ASINGACIONES_CONTRATACION
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


$('#Tablasignacioncolaboradorgeneral').on('click', '.ver-archivo-documentoasignacion', function () {
    var tr = $(this).closest('tr');
    var row = Tablasignacioncolaboradorgeneral.row(tr);
    var id = $(this).data('id');

    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }

    var nombreDocumento = 'Documento de asignación';
    var url = '/mostrarasignacion/' + id;
    
    abrirModal(url, nombreDocumento);
});


// <!-- ============================================================================================================================ -->
// <!--                                                          STEP 4                                                              -->
// <!-- ============================================================================================================================ -->




$(document).ready(function() {
    $('#NUEVO_DOCUMENTOSOPORTESCONTRATO').on('click', function() {
        limpiarFormulariocontrato(); 

        $('#FOTO_FIRMA').dropify({
            messages: {
                'default': 'Arrastre la imagen aquí o haga clic',
                'replace': 'Arrastre la imagen aquí o haga clic para reemplazar',
                'remove':  'Quitar',
                'error':   'Ooops, ha ocurrido un error.'
            },
            error: {
                'fileSize': 'El archivo es demasiado grande (máx. {{ value }}).',
                'minWidth': 'El ancho de la imagen es demasiado pequeño (mín. {{ value }}px).',
                'maxWidth': 'El ancho de la imagen es demasiado grande (máx. {{ value }}px).',
                'minHeight': 'La altura de la imagen es demasiado pequeña (mín. {{ value }}px).',
                'maxHeight': 'La altura de la imagen es demasiado grande (máx. {{ value }}px).',
                'imageFormat': 'Formato no permitido, sólo se aceptan: ({{ value }}).'
            }
        });




          $('#FOTO_FIRMA_RH').dropify({
            messages: {
                'default': 'Arrastre la imagen aquí o haga clic',
                'replace': 'Arrastre la imagen aquí o haga clic para reemplazar',
                'remove':  'Quitar',
                'error':   'Ooops, ha ocurrido un error.'
            },
            error: {
                'fileSize': 'El archivo es demasiado grande (máx. {{ value }}).',
                'minWidth': 'El ancho de la imagen es demasiado pequeño (mín. {{ value }}px).',
                'maxWidth': 'El ancho de la imagen es demasiado grande (máx. {{ value }}px).',
                'minHeight': 'La altura de la imagen es demasiado pequeña (mín. {{ value }}px).',
                'maxHeight': 'La altura de la imagen es demasiado grande (máx. {{ value }}px).',
                'imageFormat': 'Formato no permitido, sólo se aceptan: ({{ value }}).'
            }
          });
        
        
        
        
        
        $('#miModal_SOPORTECONTRATO').modal('show');
    });

});



function limpiarFormulariocontrato() {
    $('#formularioSOPORTECONTRATO')[0].reset(); 

    var drEvent = $('#FOTO_FIRMA').dropify().data('dropify');
    drEvent.resetPreview();
    drEvent.clearElement();
}


document.getElementById('step4').addEventListener('click', function() {
    document.querySelectorAll('[id$="-content"]').forEach(function(content) {
        content.style.display = 'none';
    });

    document.getElementById('step4-content').style.display = 'block';

    if (tablasoportecontratoCargada) {
        Tablasoportecontrato.columns.adjust().draw();
    } else {
        cargarTablaDocumentoscolaboradorcontrato();
        tablasoportecontratoCargada = true;
    }

    cargarDocumentossoportecontratosgenerales();
    bloquearPorRolExterno();

});

document.addEventListener('DOMContentLoaded', function() {
    var archivosoportecontrato = document.getElementById('DOCUMENTO_SOPORTECONTRATO');
    var quitarsoportecontrato = document.getElementById('quitar_soportecontrato');
    var errorsoportecontrato = document.getElementById('DOCUEMNTO_ERROR_SOPORTECONTRATO');

    if (archivosoportecontrato) {
        archivosoportecontrato.addEventListener('change', function() {
            var archivo = this.files[0];
            if (archivo && archivo.type === 'application/pdf') {
                if (errorsoportecontrato) errorsoportecontrato.style.display = 'none';
                if (quitarsoportecontrato) quitarsoportecontrato.style.display = 'block';
            } else {
                if (errorsoportecontrato) errorsoportecontrato.style.display = 'block';
                this.value = '';
                if (quitarsoportecontrato) quitarsoportecontrato.style.display = 'none';
            }
        });
        quitarsoportecontrato.addEventListener('click', function() {
            archivosoportecontrato.value = ''; 
            quitarsoportecontrato.style.display = 'none'; 
            if (errorsoportecontrato) errorsoportecontrato.style.display = 'none'; 
        });
    }
});




document.addEventListener('DOMContentLoaded', function() {
    var tipoArea = document.getElementById('TIPO_DOCUMENTO_SOPORTECONTRATO');
    var nombreDocumento = document.getElementById('NOMBRE_DOCUMENTO_SOPORTECONTRATO');

    tipoArea.addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex].text; 

        if (this.value == '13') {
            nombreDocumento.removeAttribute('readonly');
            nombreDocumento.value = ''; 
        } else {
            nombreDocumento.value = selectedOption; 
        }
    });
});



$("#guardarSOPORTECONTRATO").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormularioV1('formularioSOPORTECONTRATO');

    if (formularioValido) {

    if (ID_DOCUMENTO_COLABORADOR_CONTRATO == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarSOPORTECONTRATO')
            await ajaxAwaitFormData({ api: 4, CURP: curpSeleccionada , ID_DOCUMENTO_COLABORADOR_CONTRATO: ID_DOCUMENTO_COLABORADOR_CONTRATO }, 'contratoSave', 'formularioSOPORTECONTRATO', 'guardarSOPORTECONTRATO', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
                
            }, function (data) {
                    
                ID_DOCUMENTO_COLABORADOR_CONTRATO = data.soporte.ID_DOCUMENTO_COLABORADOR_CONTRATO
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_SOPORTECONTRATO').modal('hide')
                    document.getElementById('formularioSOPORTECONTRATO').reset();

                    
                    if ($.fn.DataTable.isDataTable('#Tablasoportecontrato')) {
                        Tablasoportecontrato.ajax.reload(null, false); 
                    }
                    cargarDocumentossoportecontratosgenerales();

            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarSOPORTECONTRATO')
            await ajaxAwaitFormData({ api: 4, CURP: curpSeleccionada ,ID_DOCUMENTO_COLABORADOR_CONTRATO: ID_DOCUMENTO_COLABORADOR_CONTRATO }, 'contratoSave', 'formularioSOPORTECONTRATO', 'guardarSOPORTECONTRATO', { callbackAfter: true, callbackBefore: true }, () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
            }, function (data) {
                    
                setTimeout(() => {

                    ID_DOCUMENTO_COLABORADOR_CONTRATO = data.soporte.ID_DOCUMENTO_COLABORADOR_CONTRATO
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_SOPORTECONTRATO').modal('hide')
                    document.getElementById('formularioSOPORTECONTRATO').reset();


                    
                    if ($.fn.DataTable.isDataTable('#Tablasoportecontrato')) {
                        Tablasoportecontrato.ajax.reload(null, false); 
                    }
                    cargarDocumentossoportecontratosgenerales();

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});



const MiModal_SOPORTECONTRATO = document.getElementById('miModal_SOPORTECONTRATO')
MiModal_SOPORTECONTRATO.addEventListener('hidden.bs.modal', event => {
    
    ID_DOCUMENTO_COLABORADOR_CONTRATO = 0
    document.getElementById('formularioSOPORTECONTRATO').reset();
   
    $('#miModal_SOPORTECONTRATO .modal-title').html('Documentos de soporte contrato');

    document.getElementById('quitar_soportecontrato').style.display = 'none';

    document.getElementById('DOCUEMNTO_ERROR_SOPORTECONTRATO').style.display = 'none';


    document.getElementById('FECHAS_SOPORTEDOCUMENTOSCONTRATO').style.display = 'none';


    document.getElementById('DIV_FOTO_FIRMA').style.display = 'none';



})


document.addEventListener('DOMContentLoaded', function () {
    const selectTipoDocumento1 = document.getElementById('TIPO_DOCUMENTO_SOPORTECONTRATO');
    const divFechasSoporte1 = document.getElementById('FECHAS_SOPORTEDOCUMENTOSCONTRATO');

    const valoresPermitidos1 = ['11','14'];

    selectTipoDocumento1.addEventListener('change', function () {
        const valorSeleccionado1 = this.value;

        if (valoresPermitidos1.includes(valorSeleccionado1)) {
            divFechasSoporte1.style.display = 'block';
        } else {
            divFechasSoporte1.style.display = 'none';
        }
    });
});



document.addEventListener('DOMContentLoaded', function () {
    const selectTipoDocumento7 = document.getElementById('TIPO_DOCUMENTO_SOPORTECONTRATO');
    const divFoto = document.getElementById('DIV_FOTO_FIRMA');

    const valoresPermitidos7 = ['7'];

    selectTipoDocumento7.addEventListener('change', function () {
        const valorSeleccionado7 = this.value;

        if (valoresPermitidos7.includes(valorSeleccionado7)) {
            divFoto.style.display = 'block';
        } else {
            divFoto.style.display = 'none';
        }
    });
});






function cargarTablaDocumentoscolaboradorcontrato() {
    if ($.fn.DataTable.isDataTable('#Tablasoportecontrato')) {
        Tablasoportecontrato.clear().destroy();
    }

    Tablasoportecontrato = $("#Tablasoportecontrato").DataTable({
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
            url: '/Tablasoportecontrato',  
            beforeSend: function () {
                $('#loadingIcon9').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon9').css('display', 'none');
                Tablasoportecontrato.columns.adjust().draw(); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon9').css('display', 'none');
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            },
            dataSrc: 'data'
        },
        columns: [
            { data: null, render: function(data, type, row, meta) { return meta.row + 1; }, className: 'text-center' },
            { data: 'NOMBRE_DOCUMENTO_SOPORTECONTRATO', className: 'text-center' },  
            { data: 'BTN_DOCUMENTO' }, 
            { data: 'BTN_EDITAR' },
        ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all text-center' },
            { targets: 1, title: 'Nombre del documento', className: 'all text-center' },  
            { targets: 2, title: 'Documento de soporte', className: 'all text-center' },  
            { targets: 3, title: 'Editar', className: 'all text-center' },  
        ]
    });
}


$('#Tablasoportecontrato').on('click', '.ver-archivo-documentocolaboradorsoportecontrato', function () {
    var tr = $(this).closest('tr');
    var row = Tablasoportecontrato.row(tr);
    var id = $(this).data('id');

    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }

    var nombreDocumentoSoporte = row.data().NOMBRE_DOCUMENTO_SOPORTECONTRATO;
    var url = '/mostrardocumentocolaboradorcontratosoporte/' + id;
    
    abrirModal(url, nombreDocumentoSoporte);
});



$('#Tablasoportecontrato').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablasoportecontrato.row(tr);

    ID_DOCUMENTO_COLABORADOR_CONTRATO = row.data().ID_DOCUMENTO_COLABORADOR_CONTRATO;

    editarDatoTabla(row.data(), 'formularioSOPORTECONTRATO', 'miModal_SOPORTECONTRATO', 1);

    $('#miModal_SOPORTECONTRATO .modal-title').html(row.data().NOMBRE_DOCUMENTO_SOPORTECONTRATO);

    const mostrarDivdocumentos = ['11','14'];
    const mostrarfoto = ['7'];

    const tipoSeleccionado1 = String(row.data().TIPO_DOCUMENTO_SOPORTECONTRATO); 

    if (mostrarDivdocumentos.includes(tipoSeleccionado1)) {
        document.getElementById('FECHAS_SOPORTEDOCUMENTOSCONTRATO').style.display = 'block';
    } else {
        document.getElementById('FECHAS_SOPORTEDOCUMENTOSCONTRATO').style.display = 'none';
    }

    const tipoSeleccionado7 = String(row.data().TIPO_DOCUMENTO_SOPORTECONTRATO); 

    if (mostrarfoto.includes(tipoSeleccionado7)) {
        document.getElementById('DIV_FOTO_FIRMA').style.display = 'block';
    } else {
        document.getElementById('DIV_FOTO_FIRMA').style.display = 'none';
    }

    // ======= Firma COLABORADOR (igual que tenías) =======
    if (row.data().FOTO_FIRMA) {
        var archivo = row.data().FOTO_FIRMA;
        var extension = archivo.substring(archivo.lastIndexOf("."));
        var imagenUrl = '/firmacolaborador/' + row.data().ID_DOCUMENTO_COLABORADOR_CONTRATO + extension;

        if ($('#FOTO_FIRMA').data('dropify')) {
            $('#FOTO_FIRMA').dropify().data('dropify').destroy();
            $('#FOTO_FIRMA').dropify().data('dropify').settings.defaultFile = imagenUrl;
            $('#FOTO_FIRMA').dropify().data('dropify').init();
        } else {
            $('#FOTO_FIRMA').attr('data-default-file', imagenUrl);
            $('#FOTO_FIRMA').dropify({
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
        $('#FOTO_FIRMA').dropify().data('dropify').resetPreview();
        $('#FOTO_FIRMA').dropify().data('dropify').clearElement();
    }

    $('#ELIMINAR_FOTO_FIRMA').val('0');
    $('#FOTO_FIRMA')
        .off('dropify.afterClear._flag change._flag') 
        .on('dropify.afterClear._flag', function () {
            $('#ELIMINAR_FOTO_FIRMA').val('1'); 
            $(this).val('');                   
        })
        .on('change._flag', function () {
            if (this.files && this.files.length > 0) {
                $('#ELIMINAR_FOTO_FIRMA').val('0'); 
            }
        });

    if (row.data().FOTO_FIRMA_RH) {
        var archivo = row.data().FOTO_FIRMA_RH;
        var extension = archivo.substring(archivo.lastIndexOf("."));
        var imagenUrl = '/firmarh/' + row.data().ID_DOCUMENTO_COLABORADOR_CONTRATO + extension;

        if ($('#FOTO_FIRMA_RH').data('dropify')) {
            $('#FOTO_FIRMA_RH').dropify().data('dropify').destroy();
            $('#FOTO_FIRMA_RH').dropify().data('dropify').settings.defaultFile = imagenUrl;
            $('#FOTO_FIRMA_RH').dropify().data('dropify').init();
        } else {
            $('#FOTO_FIRMA_RH').attr('data-default-file', imagenUrl);
            $('#FOTO_FIRMA_RH').dropify({
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
        $('#FOTO_FIRMA_RH').dropify().data('dropify').resetPreview();
        $('#FOTO_FIRMA_RH').dropify().data('dropify').clearElement();
    }

    $('#ELIMINAR_FOTO_FIRMA_RH').val('0'); 
    $('#FOTO_FIRMA_RH')
        .off('dropify.afterClear._flag change._flag')
        .on('dropify.afterClear._flag', function () {
            $('#ELIMINAR_FOTO_FIRMA_RH').val('1');
            $(this).val('');
        })
        .on('change._flag', function () {
            if (this.files && this.files.length > 0) {
                $('#ELIMINAR_FOTO_FIRMA_RH').val('0');
            }
        });

    $('#miModal_SOPORTECONTRATO').modal('show');
});



function cargarDocumentossoportecontratosgenerales() {
    if (!curpSeleccionada || curpSeleccionada.trim() === '') {
        console.error('CURP no definida');
        return;
    }

    $.ajax({
        url: '/obtenerdocumentosoportescontratos',
        method: 'POST',
        data: {
            CURP: curpSeleccionada, 
            _token: $('input[name="_token"]').val() 
        },
        success: function (data) {
            let select = $('#TIPO_DOCUMENTO_SOPORTECONTRATO');
            select.find('option').prop('disabled', false);

         data.forEach(function (tipoDocumento) {
                if (tipoDocumento !== "13") {  
                    select.find(`option[value="${tipoDocumento}"]`).prop('disabled', true);
                }
            });

        },
        error: function (xhr, status, error) {
            console.error('Error al cargar documentos guardados:', error);
        }
    });
}

// <!-- ============================================================================================================================ -->
// <!--                                                          STEP 5                                                              -->
// <!-- ============================================================================================================================ -->

document.getElementById('step5').addEventListener('click', function() {
    document.querySelectorAll('[id$="-content"]').forEach(function(content) {
        content.style.display = 'none';
    });

    document.getElementById('step5-content').style.display = 'block';

    
 if (tablaCVCargada) {
        Tablacvs.columns.adjust().draw();
    } else {
        cargarTablaCV();
        tablaCVCargada = true;
    }
    bloquearPorRolExterno();

});




$(document).ready(function() {
    $('#btnNuevoCV').on('click', function() {
        limpiarFormularioUsuario(); 

        $('#FOTO_CV').dropify({
            messages: {
                'default': 'Arrastre la imagen aquí o haga clic',
                'replace': 'Arrastre la imagen aquí o haga clic para reemplazar',
                'remove':  'Quitar',
                'error':   'Ooops, ha ocurrido un error.'
            },
            error: {
                'fileSize': 'El archivo es demasiado grande (máx. {{ value }}).',
                'minWidth': 'El ancho de la imagen es demasiado pequeño (mín. {{ value }}px).',
                'maxWidth': 'El ancho de la imagen es demasiado grande (máx. {{ value }}px).',
                'minHeight': 'La altura de la imagen es demasiado pequeña (mín. {{ value }}px).',
                'maxHeight': 'La altura de la imagen es demasiado grande (máx. {{ value }}px).',
                'imageFormat': 'Formato no permitido, sólo se aceptan: ({{ value }}).'
            }
        });

        $('#ModalCV').modal('show');
    });

    
});



function limpiarFormularioUsuario() {
    $('#FormularioCV')[0].reset(); 


    var drEvent = $('#FOTO_CV').dropify().data('dropify');
    drEvent.resetPreview();
    drEvent.clearElement();


    document.getElementById('Informacion-academica').innerHTML = '';
    document.getElementById('documentos-academica').innerHTML = '';
    document.getElementById('Experiencia-laboral').innerHTML = '';
    document.getElementById('Educacion-continua').innerHTML = '';

    document.getElementById('MOSTRAR_CEDULA').style.display = 'none';

    document.querySelectorAll('input[name="REQUIERE_CEDULA_CV"]').forEach(radio => radio.checked = false);
    document.getElementById('ESTATUS_CEDULA_CV').value = '0';
}

// AGREGAR FORMACION ACADEMICA

const botonAgregarFormacion = document.getElementById('botonAgregarFormacion');
const documentosAcademicaContainer = document.getElementById('Informacion-academica');

botonAgregarFormacion.addEventListener('click', function () {
    const formacionDiv = document.createElement('div');
    formacionDiv.classList.add('row', 'mb-3', 'formacion-contenedor');

    const formacionId = `formacion-${Date.now()}`;

    formacionDiv.innerHTML = `
        <div class="col-12 mb-3">
            <label>Activo</label>
            <label class="switch">
                <input type="checkbox" class="activo-switch" name="ACTIVO_FORMACION[]" data-id="${formacionId}">
                <span class="slider round"></span>
            </label>
        </div>


        <div class="col-6 mb-3">
            <label>Grado de estudio *</label>
            <select class="form-select grado-estudio" name="GRADO_ESTUDIO_CV[]" data-id="${formacionId}" required>
                <option value="0" selected disabled>Seleccione una opción</option>
                <option value="1">Secundaria</option>
                <option value="2">Preparatoria</option>
                <option value="3">Licenciatura</option>
                <option value="4">Posgrado</option>
            </select>
        </div>

        <div class="col-6 mb-3 licenciatura-container" style="display: none;">
            <label>Nombre de la licenciatura</label>
            <input type="text" class="form-control licenciatura-nombre" name="NOMBRE_LICENCIATURA_CV[]" data-id="${formacionId}">
        </div>

        <div class="col-12 mb-3 posgrado-container" style="display: none;">
            <div class="row">
                <div class="col-6">
                    <label>Tipo de posgrado</label>
                    <select class="form-select tipo-posgrado" name="TIPO_POSGRADO_CV[]" data-id="${formacionId}">
                        <option value="0" selected disabled>Seleccione una opción</option>
                        <option value="1">Especialidad</option>
                        <option value="2">Maestría</option>
                        <option value="3">Doctorado</option>
                        <option value="4">Post Doctorado</option>
                    </select>
                </div>
                <div class="col-6 posgrado-nombre-container" style="display: none;">
                    <label>Nombre del posgrado</label>
                    <input type="text" class="form-control posgrado-nombre" name="NOMBRE_POSGRADO_CV[]" data-id="${formacionId}">
                </div>
            </div>
        </div>

        <div class="col-12 mb-3">
            <div class="row">
                <div class="col-4 mb-3">
                    <label>Nombre de la institución</label>
                    <input type="text" class="form-control nombre-institucion" name="NOMBRE_INSTITUCION_CV[]" data-id="${formacionId}">
                </div>
                <div class="col-4 mb-3">
                    <label>Fecha finalización *</label>
                    <div class="input-group">
                        <input type="text" class="form-control mydatepicker fecha-finalizacion" placeholder="aaaa-mm-dd" name="FECHA_FINALIZACION_CV[]" data-id="${formacionId}">
                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                    </div>
                </div>
                <div class="col-4 mb-3">
                    <label>Fecha emisión título *</label>
                    <div class="input-group">
                        <input type="text" class="form-control mydatepicker fecha-emision" placeholder="aaaa-mm-dd" name="FECHA_EMISION_CV[]" data-id="${formacionId}">
                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 mb-3 text-center">
            <button type="button" class="btn btn-danger eliminar-formacion" title="Eliminar formación">Eliminar</button>
        </div>
    `;

    documentosAcademicaContainer.appendChild(formacionDiv);

    $('.mydatepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        language: 'es',
    });

    ordenarFormacionesPorFecha();

    const gradoEstudioSelect = formacionDiv.querySelector('.grado-estudio');
    const licenciaturaContainer = formacionDiv.querySelector('.licenciatura-container');
    const posgradoContainer = formacionDiv.querySelector('.posgrado-container');
    const posgradoNombreContainer = formacionDiv.querySelector('.posgrado-nombre-container');
    const tipoPosgradoSelect = formacionDiv.querySelector('.tipo-posgrado');
    const fechaFinalizacionInput = formacionDiv.querySelector('.fecha-finalizacion');

    gradoEstudioSelect.addEventListener('change', function () {
        licenciaturaContainer.style.display = 'none';
        posgradoContainer.style.display = 'none';
        posgradoNombreContainer.style.display = 'none';

        if (this.value === '3') {
            licenciaturaContainer.style.display = 'block';
        } else if (this.value === '4') {
            posgradoContainer.style.display = 'block';
        }
    });

    tipoPosgradoSelect.addEventListener('change', function () {
        if (this.value !== '0') {
            posgradoNombreContainer.style.display = 'block';
        } else {
            posgradoNombreContainer.style.display = 'none';
        }
    });

    fechaFinalizacionInput.addEventListener('input', ordenarFormacionesPorFecha);

    formacionDiv.querySelector('.eliminar-formacion').addEventListener('click', function () {
        documentosAcademicaContainer.removeChild(formacionDiv);
        ordenarFormacionesPorFecha();
    });
});

function ordenarFormacionesPorFecha() {
    const formaciones = Array.from(documentosAcademicaContainer.querySelectorAll('.formacion-contenedor'));

    formaciones.sort((a, b) => {
        const fechaA = a.querySelector('.fecha-finalizacion').value || '0000-00-00';
        const fechaB = b.querySelector('.fecha-finalizacion').value || '0000-00-00';

        return new Date(fechaB) - new Date(fechaA); 
    });

    formaciones.forEach(formacion => documentosAcademicaContainer.appendChild(formacion));
}


// AGREGAR DOCUMENTOS ACADEMICOS

const botonAgregarDocumento = document.getElementById('botonAgregarDocumento');
const inputsContainer = document.getElementById('documentos-academica');

botonAgregarDocumento.addEventListener('click', function () {
    const nuevoDiv = document.createElement('div');
    nuevoDiv.classList.add('row', 'mb-3', 'documento-contenedor');

    const selectDiv = document.createElement('div');
    selectDiv.classList.add('col-5', 'mb-3');
    selectDiv.innerHTML = `
        <label for="DOCUMENTO_CV">Tipo de Documento</label>
        <select class="form-select" name="DOCUMENTO_CV[]" required>
            <option value="0" selected disabled>Seleccione una opción</option>
            <option value="1">Certificado</option>
            <option value="2">Título</option>
            <option value="3">Otro</option>
        </select>
    `;

    const fileDiv = document.createElement('div');
    fileDiv.classList.add('col-5', 'mb-3');
    fileDiv.innerHTML = `
        <label for="DOCUMENTO_FILE">Subir documento (PDF)</label>
        <div class="input-group">
            <input type="file" class="form-control" name="DOCUMENTO_FILE[]" accept="application/pdf" required>
            <button type="button" class="btn btn-warning eliminarArchivo" title="Eliminar archivo">
                <i class="bi bi-x-circle-fill"></i>
            </button>
        </div>
    `;

    const deleteDiv = document.createElement('div');
    deleteDiv.classList.add('col-1', 'mb-3');
    deleteDiv.innerHTML = `
        <br>
        <button type="button" class="btn btn-danger botonEliminar" title="Eliminar documento">
            <i class="bi bi-trash3-fill"></i>
        </button>
    `;

    nuevoDiv.appendChild(selectDiv);
    nuevoDiv.appendChild(fileDiv);
    nuevoDiv.appendChild(deleteDiv);

    inputsContainer.appendChild(nuevoDiv);

    fileDiv.querySelector('.eliminarArchivo').addEventListener('click', function () {
        const fileInput = fileDiv.querySelector('input[type="file"]');
        fileInput.value = ''; 
    });

    deleteDiv.querySelector('.botonEliminar').addEventListener('click', function () {
        inputsContainer.removeChild(nuevoDiv);
    });
});

/// SI REQUIERE CEDULA

const requiereCedulaName = 'REQUIERE_CEDULA_CV'; 
const estatusSelectId = 'ESTATUS_CEDULA_CV'; 
const mostrarCedulaId = 'MOSTRAR_CEDULA'; 

document.addEventListener('DOMContentLoaded', function () {
    const radiosCedula = document.querySelectorAll(`input[name="${requiereCedulaName}"]`);
    const estatusSelect = document.getElementById(estatusSelectId);
    const mostrarCedula = document.getElementById(mostrarCedulaId);

    function resetInputsInDiv(div) {
        const inputs = div.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            if (input.type === 'checkbox' || input.type === 'radio') {
                input.checked = false; 
            } else {
                input.value = ''; 
            }
        });
    }

    radiosCedula.forEach(radio => {
        radio.addEventListener('change', function () {
            const requiereCedula = document.querySelector(`input[name="${requiereCedulaName}"]:checked`)?.value;
            const estatus = estatusSelect.value;

            if (requiereCedula === 'si' && estatus === '2') {
                mostrarCedula.style.display = 'block';
            } else {
                mostrarCedula.style.display = 'none';
                resetInputsInDiv(mostrarCedula); 
            }
        });
    });

    if (estatusSelect) {
        estatusSelect.addEventListener('change', function () {
            const requiereCedula = document.querySelector(`input[name="${requiereCedulaName}"]:checked`)?.value;
            const estatus = estatusSelect.value;

            if (requiereCedula === 'si' && estatus === '2') {
                mostrarCedula.style.display = 'block';
            } else {
                mostrarCedula.style.display = 'none';
                resetInputsInDiv(mostrarCedula); 
            }
        });
    }
});



document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.eliminar-archivo').forEach(button => {
        button.addEventListener('click', function () {
            const fileInput = this.previousElementSibling;
            if (fileInput && fileInput.type === 'file') {
                fileInput.value = ''; 
            }
        });
    });
});


// AGREGAR EXPERIENCIA LABORAL 




const botonAgregarExperiencia = document.getElementById('botonAgregarExperiencia');
const experienciaLaboralContainer = document.getElementById('Experiencia-laboral');

experienciaLaboralContainer.addEventListener('input', function (event) {
    const target = event.target;

    if (target && (target.name === "FECHA_INICIO[]" || target.name === "FECHA_FIN[]")) {
        ordenarCronologicamente();
        actualizarContadorGlobal();
    }
});

function inicializarDatepickers() {
    $('.mydatepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        language: 'es'
    }).on('changeDate', function () {
        ordenarCronologicamente();
        actualizarContadorGlobal();
    });
}

// Agregar una nueva experiencia laboral
botonAgregarExperiencia.addEventListener('click', function () {
    const experienciaDiv = document.createElement('div');
    experienciaDiv.classList.add('row', 'mb-3', 'experiencia-contenedor');

    const experienciaId = `experiencia-${Date.now()}`;

    experienciaDiv.innerHTML = `

    <div class="col-12 mb-3">
        <label>Activo</label>
        <label class="switch">
            <input type="checkbox" class="activo-switch" name="ACTIVO_EXPERIENCIA[]" data-id="${experienciaId}">
            <span class="slider round"></span>
        </label>
    </div>


        <!-- Primera fila -->
        <div class="col-12 mb-3">
            <div class="row">
                <div class="col-4">
                    <label>Nombre de la empresa *</label>
                    <input type="text" class="form-control" name="NOMBRE_EMPRESA[]" data-id="${experienciaId}">
                </div>
                <div class="col-4">
                    <label>Cargo *</label>
                    <input type="text" class="form-control" name="CARGO[]" data-id="${experienciaId}">
                </div>
                <div class="col-2">
                    <label>Editar Cargo</label>
                    <div class="form-check mt-2">
                        <input type="checkbox" class="form-check-input" name="EDITAR_CARGO[]" data-id="${experienciaId}">
                        <label class="form-check-label">Editar</label>
                    </div>
                </div>
                <div class="col-2">
                    <label>N° Contrato *</label>
                    <input type="text" class="form-control" name="NUMERO_CONTRATO[]" data-id="${experienciaId}">
                </div>
            </div>
        </div>

        <!-- Segunda fila -->
        <div class="col-12 mb-3">
            <div class="row">
                <div class="col-3">
                    <label>Fecha inicio *</label>
                    <div class="input-group">
                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" name="FECHA_INICIO[]" data-id="${experienciaId}">
                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                    </div>
                </div>
                <div class="col-3">
                    <label>Fecha fin *</label>
                    <div class="input-group">
                        <input type="text" class="form-control mydatepicker fecha-finalizacion" placeholder="aaaa-mm-dd" name="FECHA_FIN[]" data-id="${experienciaId}">
                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                    </div>
                </div>
                <div class="col-2">
                    <label>¿Incluir actual?</label>
                    <div class="d-flex align-items-center">
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input incluir-actualmente" name="ACTUALMENTE-${experienciaId}" value="1" data-id="${experienciaId}">
                            <label class="form-check-label">Sí</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input incluir-actualmente" name="ACTUALMENTE-${experienciaId}" value="0" data-id="${experienciaId}">
                            <label class="form-check-label">No</label>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <label>Jornada *</label>
                    <select class="form-select" name="JORNADA[]" data-id="${experienciaId}">
                        <option value="0" selected disabled>Seleccione una opción</option>
                        <option value="1">Tiempo completo</option>
                        <option value="2">Medio tiempo</option>
                        <option value="3">Tiempo parcial</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Tercera fila -->
        <div class="col-12 mb-3">
            <div class="row">
                <div class="col-6">
                    <label>Descripción *</label>
                    <textarea class="form-control" name="DESCRIPCION[]" rows="4" data-id="${experienciaId}"></textarea>
                </div>
                <div class="col-6">
                    <label>Documento *</label>
                    <div class="input-group">
                        <input type="file" class="form-control" name="DOCUMENTO[]" accept="application/pdf" data-id="${experienciaId}">
                        <button type="button" class="btn btn-danger eliminar-documento" data-id="${experienciaId}">
                            <i class="bi bi-trash3-fill"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón para eliminar el contenedor completo -->
        <div class="col-12 mb-3 text-center">
            <button type="button" class="btn btn-danger eliminar-experiencia" title="Eliminar experiencia">
                Eliminar
            </button>
        </div>
    `;

    experienciaLaboralContainer.appendChild(experienciaDiv);

    inicializarDatepickers();

    ordenarCronologicamente();
    actualizarContadorGlobal();

    experienciaDiv.querySelector('.eliminar-documento').addEventListener('click', function () {
        const fileInput = this.previousElementSibling;
        if (fileInput && fileInput.type === 'file') {
            fileInput.value = ''; 
        }
    });

    experienciaDiv.querySelector('.eliminar-experiencia').addEventListener('click', function () {
        experienciaLaboralContainer.removeChild(experienciaDiv);
        ordenarCronologicamente();
        actualizarContadorGlobal();
    });
});

function ordenarCronologicamente() {
    const experienciaContenedores = Array.from(document.querySelectorAll('.experiencia-contenedor'));
    experienciaContenedores.sort((a, b) => {
        const fechaFinA = a.querySelector('.fecha-finalizacion').value || '0000-00-00';
        const fechaFinB = b.querySelector('.fecha-finalizacion').value || '0000-00-00';
        return new Date(fechaFinB) - new Date(fechaFinA);
    });

    experienciaContenedores.forEach(contenedor => experienciaLaboralContainer.appendChild(contenedor));
}

function calcularTiempoExperiencia() {
    const experiencias = [];
    const experienciaContenedores = document.querySelectorAll('.experiencia-contenedor');

    experienciaContenedores.forEach(contenedor => {
        const fechaInicio = contenedor.querySelector('input[name="FECHA_INICIO[]"]').value;
        const fechaFin = contenedor.querySelector('input[name="FECHA_FIN[]"]').value;

        if (fechaInicio && fechaFin) {
            experiencias.push({
                inicio: new Date(fechaInicio),
                fin: new Date(fechaFin)
            });
        }
    });

    experiencias.sort((a, b) => a.inicio - b.inicio);

    let totalDias = 0;
    let periodoActual = null;

    experiencias.forEach(periodo => {
        if (!periodoActual) {
            periodoActual = { ...periodo };
        } else {
            if (periodo.inicio <= periodoActual.fin) {
                periodoActual.fin = new Date(Math.max(periodoActual.fin, periodo.fin));
            } else {
                totalDias += Math.floor((periodoActual.fin - periodoActual.inicio) / (1000 * 60 * 60 * 24));
                periodoActual = { ...periodo };
            }
        }
    });

    if (periodoActual) {
        totalDias += Math.floor((periodoActual.fin - periodoActual.inicio) / (1000 * 60 * 60 * 24));
    }

    const anios = Math.floor(totalDias / 365);
    const meses = Math.floor((totalDias % 365) / 30);
    const dias = totalDias % 30;

    return { anios, meses, dias };
}


function actualizarContadorGlobal() {
    const contadorDiv = document.getElementById('contador-global');
    const tiempo = calcularTiempoExperiencia();

    if (!contadorDiv) {
        const nuevoDiv = document.createElement('div');
        nuevoDiv.id = 'contador-global';
        nuevoDiv.classList.add('text-center', 'mt-3');
        nuevoDiv.innerHTML = `
            <h5><b>Tiempo total de experiencia:</b></h5>
            <p><span id="tiempo-total-anios">${tiempo.anios}</span> años, 
            <span id="tiempo-total-meses">${tiempo.meses}</span> meses, 
            <span id="tiempo-total-dias">${tiempo.dias}</span> días</p>
        `;
        experienciaLaboralContainer.appendChild(nuevoDiv);
    } else {
        contadorDiv.querySelector('#tiempo-total-anios').textContent = tiempo.anios;
        contadorDiv.querySelector('#tiempo-total-meses').textContent = tiempo.meses;
        contadorDiv.querySelector('#tiempo-total-dias').textContent = tiempo.dias;
    }
}

// Agregar educación continua 



const botonAgregarEducacionContinua = document.getElementById('botonAgregarEducacionContinua');
const educacionContinuaContainer = document.getElementById('Educacion-continua');

botonAgregarEducacionContinua.addEventListener('click', function () {
    const educacionDiv = document.createElement('div');
    educacionDiv.classList.add('row', 'mb-3', 'educacion-contenedor');

    const educacionId = `educacion-${Date.now()}`;

    educacionDiv.innerHTML = `

   <div class="col-12 mb-3">
        <label>Activo</label>
        <label class="switch">
            <input type="checkbox" class="activo-switch" name="ACTIVO_CONTINUA[]" data-id="${educacionId}">
            <span class="slider round"></span>
        </label>
    </div>



        <!-- Primera fila -->
        <div class="col-12 mb-3">
            <div class="row">
                <div class="col-4">
                    <label>Tipo *</label>
                    <select class="form-select" name="TIPO_EDUCACION[]" data-id="${educacionId}" required>
                        <option value="" selected disabled>Seleccione una opción</option>
                        <option value="Curso">Curso</option>
                        <option value="Certificación">Certificación</option>
                    </select>
                </div>
                  <div class="col-4">
                    <label>Nombre *</label>
                    <input type="text" class="form-control" name="NOMBRE_EDUCACION[]" data-id="${educacionId}" required>
                </div>
                <div class="col-4">
                    <label>Entidad acreditadora *</label>
                    <input type="text" class="form-control" name="ENTIDAD_EDUCACION[]" data-id="${educacionId}" required>
                </div>
            </div>
        </div>

        <!-- Segunda fila -->
        <div class="col-12 mb-3">
            <div class="row">
                <div class="col-4">
                    <label>Fecha Inicio *</label>
                    <div class="input-group">
                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" name="FECHA_INICIO_EDUCACION[]" data-id="${educacionId}" required>
                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                    </div>
                </div>
                <div class="col-4">
                    <label>Fecha Fin *</label>
                    <div class="input-group">
                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" name="FECHA_FIN_EDUCACION[]" data-id="${educacionId}" required>
                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                    </div>
                </div>
                <div class="col-4">
                    <label>Ciudad / País *</label>
                    <input type="text" class="form-control" name="CIUDAD_PAIS_EDUCACION[]" data-id="${educacionId}" required>
                </div>
            </div>
        </div>

        <!-- Tercera fila -->
        <div class="col-12 mb-3">
            <div class="row">
                <div class="col-6">
                    <label>Estatus *</label>
                    <select class="form-select" name="ESTATUS_EDUCACION[]" data-id="${educacionId}" required>
                        <option value="" selected disabled>Seleccione una opción</option>
                        <option value="Vigente">Vigente</option>
                        <option value="Vencido">Vencido</option>
                    </select>
                </div>
                <div class="col-6">
                    <label>Documento *</label>
                    <div class="input-group">
                        <input type="file" class="form-control" name="DOCUMENTO_EDUCACION[]" accept="application/pdf" data-id="${educacionId}" required>
                        <button type="button" class="btn btn-danger eliminar-documento" data-id="${educacionId}">
                            <i class="bi bi-trash3-fill"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón para eliminar el contenedor completo -->
        <div class="col-12 mb-3 text-center">
            <button type="button" class="btn btn-danger eliminar-educacion" title="Eliminar educación">
                Eliminar
            </button>
        </div>
    `;

    educacionContinuaContainer.appendChild(educacionDiv);

    $('.mydatepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        language: 'es',
    });

    educacionDiv.querySelector('.eliminar-documento').addEventListener('click', function () {
        const fileInput = this.previousElementSibling;
        if (fileInput && fileInput.type === 'file') {
            fileInput.value = ''; 
        }
    });

    educacionDiv.querySelector('.eliminar-educacion').addEventListener('click', function () {
        educacionContinuaContainer.removeChild(educacionDiv);
    });
});






const ModalCV = document.getElementById('ModalCV');
ModalCV.addEventListener('hidden.bs.modal', event => {
    ID_CV_CONTRATACION = 0;
    document.getElementById('FormularioCV').reset();
    document.getElementById('Informacion-academica').innerHTML = '';
    document.getElementById('documentos-academica').innerHTML = '';
    document.getElementById('Experiencia-laboral').innerHTML = '';
    document.getElementById('Educacion-continua').innerHTML = '';
    document.getElementById('tiempo-total-anios').textContent = '0';
    document.getElementById('tiempo-total-meses').textContent = '0';
    document.getElementById('tiempo-total-dias').textContent = '0';
    document.getElementById('MOSTRAR_CEDULA').style.display = 'none';
    document.querySelectorAll('input[name="REQUIERE_CEDULA_CV"]').forEach(radio => radio.checked = false);
    document.getElementById('ESTATUS_CEDULA_CV').value = '0';

    $('#ModalCV .modal-title').html('Ficha datos CV');
});






$("#guardarCV").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormularioV1('FormularioCV');

    if (formularioValido) {
        var formaciones = [];
        $(".formacion-contenedor").each(function() {
            var formacion = {
                GRADO_ESTUDIO: $(this).find("select[name='GRADO_ESTUDIO_CV[]']").val(),
                NOMBRE_LICENCIATURA: $(this).find("input[name='NOMBRE_LICENCIATURA_CV[]']").val(),
                TIPO_POSGRADO: $(this).find("select[name='TIPO_POSGRADO_CV[]']").val(),
                NOMBRE_POSGRADO: $(this).find("input[name='NOMBRE_POSGRADO_CV[]']").val(),
                NOMBRE_INSTITUCION: $(this).find("input[name='NOMBRE_INSTITUCION_CV[]']").val(),
                FECHA_FINALIZACION: $(this).find("input[name='FECHA_FINALIZACION_CV[]']").val(),
                FECHA_EMISION: $(this).find("input[name='FECHA_EMISION_CV[]']").val(),
                ACTIVO: $(this).find("input[name='ACTIVO_FORMACION[]']").is(":checked") ? 1 : 0
            };
            formaciones.push(formacion);
        });

        var documentos = [];
        $(".documento-contenedor").each(function() {
            var documento = {
                DOCUMENTO_TIPO: $(this).find("select[name='DOCUMENTO_CV[]']").val()
            };
            documentos.push(documento);
        });

        var experiencias = [];
        $(".experiencia-contenedor").each(function() {
            var experiencia = {
                NOMBRE_EMPRESA: $(this).find("input[name='NOMBRE_EMPRESA[]']").val(),
                CARGO: $(this).find("input[name='CARGO[]']").val(),
                NUMERO_CONTRATO: $(this).find("input[name='NUMERO_CONTRATO[]']").val(),
                FECHA_INICIO: $(this).find("input[name='FECHA_INICIO[]']").val(),
                FECHA_FIN: $(this).find("input[name='FECHA_FIN[]']").val(),
                ACTIVO: $(this).find("input[name='ACTIVO_EXPERIENCIA[]']").is(":checked") ? 1 : 0
            };
            experiencias.push(experiencia);
        });

        var continuas = [];
        $(".educacion-contenedor").each(function() {
            var continua = {
                TIPO_EDUCACION: $(this).find("select[name='TIPO_EDUCACION[]']").val(),
                NOMBRE: $(this).find("input[name='NOMBRE_EDUCACION[]']").val(),
                ENTIDAD_ACREDITADORA: $(this).find("input[name='ENTIDAD_EDUCACION[]']").val(),
                FECHA_INICIO: $(this).find("input[name='FECHA_INICIO_EDUCACION[]']").val(),
                FECHA_FIN: $(this).find("input[name='FECHA_FIN_EDUCACION[]']").val(),
                ACTIVO: $(this).find("input[name='ACTIVO_CONTINUA[]']").is(":checked") ? 1 : 0
            };
            continuas.push(continua);
        });

        const requestData = {
            api: 1,
             CURP: curpSeleccionada ,
            ID_CV_CONTRATACION: ID_CV_CONTRATACION,
            FORMACION_ACADEMICA_CV: JSON.stringify(formaciones),
            DOCUMENTO_ACADEMICOS_CV: JSON.stringify(documentos),
            EXPERIENCIA_LABORAL_CV: JSON.stringify(experiencias),
            EDUCACION_CONTINUA_CV: JSON.stringify(continuas)
        };

        if (ID_CV_CONTRATACION == 0) {
            alertMensajeConfirm({
                title: "¿Desea guardar la información?",
                text: "Al guardarla, se podrá usar",
                icon: "question",
            }, async function () {
                await loaderbtn('guardarCV');
                await ajaxAwaitFormData(requestData, 'cvSave', 'FormularioCV', 'guardarCV', { callbackAfter: true, callbackBefore: true }, () => {
                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });
                    $('.swal2-popup').addClass('ld ld-breath');
                }, function (data) {
                    ID_CV_CONTRATACION = data.cv.ID_CV_CONTRATACION;
                    alertMensaje('success', 'Información guardada correctamente', 'Esta información está lista para usarse', null, null, 1500);
                    $('#ModalCV').modal('hide'); 
                    document.getElementById('FormularioCV').reset();

                    if ($.fn.DataTable.isDataTable('#Tablacvs')) {
                        Tablacvs.ajax.reload(null, false); 
                    }
                    
                });
            }, 1);
        } else {
            alertMensajeConfirm({
                title: "¿Desea editar la información de este formulario?",
                text: "Al guardarla, se podrá usar",
                icon: "question",
            }, async function () {
                await loaderbtn('guardarCV');
                await ajaxAwaitFormData(requestData, 'cvSave', 'FormularioCV', 'guardarCV', { callbackAfter: true, callbackBefore: true }, () => {
                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    });
                    $('.swal2-popup').addClass('ld ld-breath');
                }, function (data) {
                    setTimeout(() => {
                        ID_CV_CONTRATACION = data.cv.ID_CV_CONTRATACION;
                        alertMensaje('success', 'Información editada correctamente', 'Información guardada');
                        $('#ModalCV').modal('hide'); 
                        document.getElementById('FormularioCV').reset(); 


                        if ($.fn.DataTable.isDataTable('#Tablacvs')) {
                        Tablacvs.ajax.reload(null, false); 
                        }
                        

                    }, 300);
                });
            }, 1);
        }
    } else {
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000);
    }
});






function cargarTablaCV() {
    if ($.fn.DataTable.isDataTable('#Tablacvs')) {
        Tablacvs.clear().destroy();
    }

    Tablacvs = $("#Tablacvs").DataTable({
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
            url: '/Tablacvs',  
            beforeSend: function () {
                $('#loadingIcon10').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon10').css('display', 'none');
                Tablacvs.columns.adjust().draw(); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon10').css('display', 'none');
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            },
            dataSrc: 'data'
        },
        columns: [
            { data: null, render: function(data, type, row, meta) { return meta.row + 1; }, className: 'text-center' },
            { data: 'NOMBRE_CV', className: 'text-center' },  
            { data: 'BTN_BIO' },
            { data: 'BTN_CV' },
            { data: 'BTN_PERSONAL' },
            { data: 'BTN_EDITAR' },

        ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all text-center' },
            { targets: 1, title: 'Nombre del documento', className: 'all text-center' },  
            { targets: 2, title: 'Generar CV bio', className: 'all text-center' },  
            { targets: 3, title: 'Generar CV general', className: 'all text-center' },  
            { targets: 4, title: 'Generar CV del personal propuesto', className: 'all text-center' },
            { targets: 5, title: 'Editar', className: 'all text-center' },  
        ]
    });
}





$('#Tablacvs').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacvs.row(tr);
    ID_CV_CONTRATACION = row.data().ID_CV_CONTRATACION;

    editarDatoTabla(row.data(), 'FormularioCV', 'ModalCV', 1);

 
    if (row.data().FOTO_CV) {
        var archivo = row.data().FOTO_CV;
        var extension = archivo.substring(archivo.lastIndexOf("."));
        var imagenUrl = '/mostrarFotoCV/' + row.data().ID_CV_CONTRATACION + extension;

        if ($('#FOTO_CV').data('dropify')) {
            $('#FOTO_CV').dropify().data('dropify').destroy();
            $('#FOTO_CV').dropify().data('dropify').settings.defaultFile = imagenUrl;
            $('#FOTO_CV').dropify().data('dropify').init();
        } else {
            $('#FOTO_CV').attr('data-default-file', imagenUrl);
            $('#FOTO_CV').dropify({
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
        $('#FOTO_CV').dropify().data('dropify').resetPreview();
        $('#FOTO_CV').dropify().data('dropify').clearElement();
    }
});




// <!-- ============================================================================================================================ -->
// <!--                                                          STEP 6                                                              -->
// <!-- ============================================================================================================================ -->


document.getElementById('step6').addEventListener('click', function() {
    document.querySelectorAll('[id$="-content"]').forEach(function(content) {
        content.style.display = 'none';
    });

    document.getElementById('step6-content').style.display = 'block';

    if (tablarequisiconCargada) {
        Tablarequisicioncontratacion.columns.adjust().draw();
    } else {
        cargarTablarequisicion();
        tablarequisiconCargada = true;
    }
    bloquearPorRolExterno();
  
});




$("#NUEVO_REQUISICION").click(function (e) {
    e.preventDefault();

    $("#miModal_REQUERIMIENTO").modal("show");

    $("#MOSTRAR_TODO").show();
    $("#MOSTRAR_ANTES").hide();

    $('#guardarFormRP').show();

   
});


const ModalArea = document.getElementById('miModal_REQUERIMIENTO');

ModalArea.addEventListener('hidden.bs.modal', event => {
    ID_CONTRATACION_REQUERIMIENTO = 0;

    document.getElementById('formularioRP').reset();

    document.getElementById('MOSTRAR_TODO').style.display = "block";
    document.getElementById('MOSTRAR_ANTES').style.display = "none";
    document.getElementById("APROBO_ID").value = "";

    $('#guardarFormRP').show();
  
});




    
    
    
$("#guardarFormRP").click(function (e) {
    e.preventDefault();


    formularioValido = validarFormularioV2('formularioRP');


    if (formularioValido) {

    if (ID_CONTRATACION_REQUERIMIENTO == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormRP')
            await ajaxAwaitFormData({ api: 11,CURP: curpSeleccionada, ID_CONTRATACION_REQUERIMIENTO: ID_CONTRATACION_REQUERIMIENTO }, 'contratoSave', 'formularioRP', 'guardarFormRP', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_CONTRATACION_REQUERIMIENTO = data.requerimiento.ID_CONTRATACION_REQUERIMIENTO
                alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                $('#miModal_REQUERIMIENTO').modal('hide')
                document.getElementById('formularioRP').reset();
                
                if ($.fn.DataTable.isDataTable('#Tablarequisicioncontratacion')) {
                    Tablarequisicioncontratacion.ajax.reload(null, false); 
                }

                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormRP')
            await ajaxAwaitFormData({ api: 11, CURP: curpSeleccionada, ID_CONTRATACION_REQUERIMIENTO: ID_CONTRATACION_REQUERIMIENTO }, 'contratoSave', 'formularioRP', 'guardarFormRP', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_CONTRATACION_REQUERIMIENTO = data.requerimiento.ID_CONTRATACION_REQUERIMIENTO
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_REQUERIMIENTO').modal('hide')
                    document.getElementById('formularioRP').reset();

                    
                if ($.fn.DataTable.isDataTable('#Tablarequisicioncontratacion')) {
                    Tablarequisicioncontratacion.ajax.reload(null, false); 
                }

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});
    




function cargarTablarequisicion() {
    if ($.fn.DataTable.isDataTable('#Tablarequisicioncontratacion')) {
        Tablarequisicioncontratacion.clear().destroy();
    }

    Tablarequisicioncontratacion = $("#Tablarequisicioncontratacion").DataTable({
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
            url: '/Tablarequisicioncontratacion',  
            beforeSend: function () {
                $('#loadingIcon13').css('display', 'inline-block');
            },
            complete: function () {
                $('#loadingIcon13').css('display', 'none');
                Tablarequisicioncontratacion.columns.adjust().draw(); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#loadingIcon13').css('display', 'none');
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
        { data: 'NOMBRE_CATEGORIA' },
        { data: 'PRIORIDAD_RP',
            className: 'text-center',
            render: function(data) { return data ? data : 'N/A';}
         },
        { data: 'TIPO_VACANTE_RP',
            className: 'text-center',
            render: function(data) { return data ? data : 'N/A'; }
         },
        { data: 'MOTIVO_VACANTE_RP',
            className: 'text-center',
            render: function(data) { return data ? data : 'N/A'; }
        },
        { data: 'FECHA_CREACION' ,
            className: 'text-center',
            render: function(data) { return data ? data : 'N/A'; }
        },

        { data: 'BTN_EDITAR' },
        {
            data: 'BTN_DOCUMENTO',
            render: function(data, type, row) {
                if (row.ANTES_DE1 === 1) {
                    return data; 
                } else {
                    return 'NA'; 
                }
            }
        }        
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Categoría', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Prioridad', className: 'all text-center nombre-column' },
        { targets: 3, title: 'Tipo de vacante', className: 'all text-center' },
        { targets: 4, title: 'Motivo', className: 'all text-center' },
        { targets: 5, title: 'Fecha de creación', className: 'all text-center' },
        { targets: 6, title: 'Editar', className: 'all text-center' },
        { targets: 7, title: 'Documento', className: 'all text-center' },


    ]
    });
}



$('#Tablarequisicioncontratacion').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablarequisicioncontratacion.row(tr);

    ID_CONTRATACION_REQUERIMIENTO = row.data().ID_CONTRATACION_REQUERIMIENTO;

    editarDatoTabla(row.data(), 'formularioRP', 'miModal_REQUERIMIENTO', 1);

    $('#guardarFormRP').hide();


     if (row.data().ANTES_DE1 == 1) {
        $('#MOSTRAR_ANTES').show();
        $('#MOSTRAR_TODO').hide();

        $('#MOSTRAR_TODO').find('[required]').removeAttr('required');
    } else {
        $('#MOSTRAR_TODO').show();
        $('#MOSTRAR_ANTES').hide();

        $('#MOSTRAR_ANTES').find('[required]').removeAttr('required');

    }


    if (row.data().APROBO_ID) {
        $.get(`/obtenerNombreUsuario/${row.data().APROBO_ID}`, function (res) {
            $('#NOMBRE_APROBO_RP').val(res.nombre_completo);
        }).fail(() => $('#NOMBRE_APROBO_RP').val(''));
    } else {
        $('#NOMBRE_APROBO_RP').val('No se ha aprobado');
    }

    $("#miModal_REQUERIMIENTO").modal("show");
 
});




$('#SELECCIONAR_CATEGORIA_RP').on('change', function () {
    const categoria = $(this).val();

    $.ajax({
        url: '/obtenerDatosCategoria',
        method: 'GET',
        data: { categoria },
        success: function (response) {
            if (response.success) {
                const data = response.data;

                if (data.ANTES_DE1 == 1) {
                    $('#MOSTRAR_ANTES').show();
                    $('#MOSTRAR_TODO').hide();

                    $('#PUESTO_RP_ANTES').val(data.PUESTO_RP);
                    $('#FECHA_CREACION').val(data.FECHA_CREACION);
                    $('#ANTES_DE1').val(data.ANTES_DE1);

                    $('#DOCUMENTO_REQUISICION').val(data.DOCUMENTO_REQUISICION);

                } else {
                    $('#MOSTRAR_ANTES').hide();
                    $('#MOSTRAR_TODO').show();

                    $('#FECHA_RP').val(data.FECHA_RP);
                    $('#PRIORIDAD_RP').val(data.PRIORIDAD_RP);
                    $('#TIPO_VACANTE_RP').val(data.TIPO_VACANTE_RP);
                    $('#MOTIVO_VACANTE_RP').val(data.MOTIVO_VACANTE_RP);
                    $('#SUSTITUYE_RP').val(data.SUSTITUYE_RP);
                    $('#SUSTITUYE_CATEGORIA_RP').val(data.SUSTITUYE_CATEGORIA_RP);
                    $('#CENTRO_COSTO_RP').val(data.CENTRO_COSTO_RP);
                    $('#AREA_RP').val(data.AREA_RP);
                    $('#NO_VACANTES_RP').val(data.NO_VACANTES_RP);
                    $('#PUESTO_RP').val(data.PUESTO_RP);
                    $('#FECHA_INICIO_RP').val(data.FECHA_INICIO_RP);
                    $('#OBSERVACION1_RP').val(data.OBSERVACION1_RP);
                    $('#OBSERVACION2_RP').val(data.OBSERVACION2_RP);
                    $('#OBSERVACION3_RP').val(data.OBSERVACION3_RP);
                    $('#OBSERVACION4_RP').val(data.OBSERVACION4_RP);
                    $('#OBSERVACION5_RP').val(data.OBSERVACION5_RP);


                    // $('#CORREO_CORPORATIVO_RP').val(data.CORREO_CORPORATIVO_RP);
                    // $('#TELEFONO_CORPORATIVO_RP').val(data.TELEFONO_CORPORATIVO_RP);
                    // $('#SOFTWARE_RP').val(data.SOFTWARE_RP);
                    // $('#VEHICULO_EMPRESA_RP').val(data.VEHICULO_EMPRESA_RP);


                    // CORREO
                    $('input[name="CORREO_CORPORATIVO_RP"][value="' + data.CORREO_CORPORATIVO_RP + '"]').prop('checked', true);

                    // TELEFONO
                    $('input[name="TELEFONO_CORPORATIVO_RP"][value="' + data.TELEFONO_CORPORATIVO_RP + '"]').prop('checked', true);

                    // SOFTWARE
                    $('input[name="SOFTWARE_RP"][value="' + data.SOFTWARE_RP + '"]').prop('checked', true);

                    // VEHÍCULO
                    $('input[name="VEHICULO_EMPRESA_RP"][value="' + data.VEHICULO_EMPRESA_RP + '"]').prop('checked', true);

                    $('#NOMBRE_SOLICITA_RP').val(data.NOMBRE_SOLICITA_RP);
                   
                    $('#FECHA_CREACION').val(data.FECHA_CREACION);
                    $('#DOCUMENTO_REQUISICION').val(data.DOCUMENTO_REQUISICION);

                    $('#ESTADO_SOLICITUD').val(data.ESTADO_SOLICITUD);
                    $('#FECHA_APROBO_RP').val(data.FECHA_APROBO_RP);
                    $('#APROBO_ID').val(data.APROBO_ID);


                    $('#NOMBRE_APROBO_RP').val(data.NOMBRE_APROBO ?? '');


                }
            } else {
                alert(response.message);
            }
        },
        error: function () {
            alert('Error al consultar la información.');
        }
    });
});



$('#Tablarequisicioncontratacion').on('click', '.ver-archivo-requerisicioncontratacion', function () {
    var tr = $(this).closest('tr');
    var row = Tablarequisicioncontratacion.row(tr);
    var id = $(this).data('id');

    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }

    var nombreDocumentoSoporte = row.data().NOMBRE_CATEGORIA;
    var url = '/mostrarrequisicon/' + id;
    
    abrirModal(url, nombreDocumentoSoporte);
});
