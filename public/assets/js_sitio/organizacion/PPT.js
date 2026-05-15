//VARIABLES
ID_FORMULARIO_PPT = 0


let puestoIndex = 0;  

const ModalArea = document.getElementById('miModal_PPT');
ModalArea.addEventListener('hidden.bs.modal', event => {
    ID_FORMULARIO_PPT = 0;
    
    document.getElementById('formularioPPT').reset();
    
    $('#formularioPPT input').prop('disabled', false);
    $('#formularioPPT textarea').prop('disabled', false);
    $('#formularioPPT select').prop('disabled', false);
    
    $('.collapse').collapse('hide');
    
    $('#guardarFormPPT').css('display', 'block').prop('disabled', false);
    $('#revisarFormPPT').css('display', 'none').prop('disabled', true);
    $('#AutorizarFormPPT').css('display', 'none').prop('disabled', true);
    $('.desabilitado').css('background','#E2EFDA').prop('disabled', true);
    
    for (let i = 2; i <= 3; i++) {
        document.getElementById(`IDIOMA${i}`).style.display = 'none';
    }

    document.getElementById('addIdiomaBtn').style.display = 'inline-block';
    document.getElementById('addIdiomaBtn2').style.display = 'none';
    document.getElementById('removeIdiomaBtn2').style.display = 'none';
    document.getElementById('removeIdiomaBtn3').style.display = 'none';

    for (let i = 1; i <= 5; i++) {
        document.getElementById(`puesto${i}`).style.display = 'none';
    }

    puestoIndex = 0;
});




TablaPPT = $("#TablaPPT").DataTable({
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
        url: '/TablaPPT',
        beforeSend: function () {
            mostrarCarga()
        },
        complete: function () {
            TablaPPT.columns.adjust().draw()
            ocultarCarga()
        },
        error: function (jqXHR, textStatus, errorThrown) {
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
        { data: 'ELABORADO_POR' },
        { data: 'REVISADO_POR' },
        { data: 'AUTORIZADO_POR' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_ELIMINAR' },
    ],
    columnDefs: [
        { target: 0,title: '#',className: 'all  text-center', },
        { target: 1, title: 'Nombre categoría', className: 'all  text-center' },
        { target: 2, title: 'Elaborado por', className: 'all text-center' },
        { target: 3, title: 'Revisado por', className: 'all text-center' },
        { target: 4, title: 'Aprobado por', className: 'all text-center' },
        { target: 5, title: 'Editar', className: 'all text-center' },
        { target: 6, title: 'Activo', className: 'all text-center' },
    ]
});



$("#nuevo_ppt").click(function (e) {
e.preventDefault();

$('.desabilitado').css('background','#E2EFDA');

$("#miModal_PPT").modal("show");


})


$("#guardarFormPPT").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioPPT'))

    if (formularioValido) {

        if (ID_FORMULARIO_PPT == 0) {
            
            alertMensajeConfirm({
                title: "¿Desea guardar la información?",
                text: "Al guardarla, se usara para la creación del PPT",
                icon: "question",
            },async function () { 

                await loaderbtn('guardarFormPPT')
                await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_PPT: ID_FORMULARIO_PPT }, 'pptSave', 'formularioPPT', 'guardarFormPPT', { callbackAfter: true, callbackBefore: true }, () => {
            
              

                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    })

                    $('.swal2-popup').addClass('ld ld-breath')
            
                    
                }, function (data) {
                        
                    setTimeout(() => {

                        ID_FORMULARIO_PPT = data.PPT.ID_FORMULARIO_PPT
                        alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para hacer uso del PPT',null,null, 1500)
                        $('#miModal_PPT').modal('hide')
                        document.getElementById('formularioPPT').reset();
                        TablaPPT.ajax.reload()

                    }, 300);
                    
                    
                })
                
                
                
            }, 1)
            
        } else {
                alertMensajeConfirm({
                title: "¿Desea editar la información de este formulario?",
                text: "Al guardarla, se editara la información del PPT",
                icon: "question",
            },async function () { 

                await loaderbtn('guardarFormPPT')
                await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_PPT: ID_FORMULARIO_PPT }, 'pptSave', 'formularioPPT', 'guardarFormPPT', { callbackAfter: true, callbackBefore: true }, () => {
            
                    Swal.fire({
                        icon: 'info',
                        title: 'Espere un momento',
                        text: 'Estamos guardando la información',
                        showConfirmButton: false
                    })

                    $('.swal2-popup').addClass('ld ld-breath')
            
                    
                }, function (data) {
                        
                    setTimeout(() => {

                        
                        ID_FORMULARIO_PPT = data.PPT.ID_FORMULARIO_PPT
                        alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                        $('#miModal_PPT').modal('hide')
                        document.getElementById('formularioPPT').reset();
                        TablaPPT.ajax.reload()


                    }, 300);  
                })
            }, 1)
        }
    
    } else {
        // Muestra un mensaje de error o realiza alguna otra acción
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

    }
    
});

$("#DEPARTAMENTO_AREA_ID").on("change", function () {

    var valorSeleccionado = $(this).find("option:selected");
    var infoLugar = valorSeleccionado.data("lugar");
    var infoProposito = valorSeleccionado.data("proposito");
   
    
    $('#AREA_TRABAJADOR_PPT').val(infoLugar).prop('readonly', true)
    $('#PROPOSITO_FINALIDAD_PPT').val(infoProposito).prop('readonly', true)


});



$('#TablaPPT tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = TablaPPT.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_FORMULARIO_PPT: row.data().ID_FORMULARIO_PPT
    };

    eliminarDatoTabla(data, [TablaPPT], 'pptDelete');
});




$('#TablaPPT tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = TablaPPT.row(tr);
    ID_FORMULARIO_PPT = row.data().ID_FORMULARIO_PPT;
    var data = row.data();
    var form = "formularioPPT";

    $('.desabilitado').css('background','#E2EFDA');


    editarDatoTabla(data, form, 'miModal_PPT', 1);
    mostrarCursos(data, form);

    puestoIndex = 0;

    for (let i = 1; i <= 5; i++) {
        const puestoField = document.getElementById(`puesto${i}`);
        const nombreField1 = document.getElementById(`PUESTO${(i * 2) - 1}_NOMBRE`);
        const checkboxField1 = document.getElementById(`PUESTO${(i * 2) - 1}`);
        const cumpleSiField1 = document.getElementById(`PUESTO${(i * 2) - 1}_CUMPLE_SI`);
        const cumpleNoField1 = document.getElementById(`PUESTO${(i * 2) - 1}_CUMPLE_NO`);

        const nombreField2 = document.getElementById(`PUESTO${i * 2}_NOMBRE`);
        const checkboxField2 = document.getElementById(`PUESTO${i * 2}`);
        const cumpleSiField2 = document.getElementById(`PUESTO${i * 2}_CUMPLE_SI`);
        const cumpleNoField2 = document.getElementById(`PUESTO${i * 2}_CUMPLE_NO`);

        if ((data[`PUESTO${(i * 2) - 1}_NOMBRE`] && data[`PUESTO${(i * 2) - 1}_NOMBRE`] !== "") ||
            (data[`PUESTO${i * 2}_NOMBRE`] && data[`PUESTO${i * 2}_NOMBRE`] !== "")) {
            
            puestoField.style.display = 'flex';
            puestoIndex = i;  
            
            if (data[`PUESTO${(i * 2) - 1}_NOMBRE`]) {
                nombreField1.value = data[`PUESTO${(i * 2) - 1}_NOMBRE`];
                checkboxField1.checked = data[`PUESTO${(i * 2) - 1}`] === 'X';
                if (data[`PUESTO${(i * 2) - 1}_CUMPLE_PPT`] === 'si') {
                    cumpleSiField1.checked = true;
                } else if (data[`PUESTO${(i * 2) - 1}_CUMPLE_PPT`] === 'no') {
                    cumpleNoField1.checked = true;
                }
            }

            if (data[`PUESTO${i * 2}_NOMBRE`]) {
                nombreField2.value = data[`PUESTO${i * 2}_NOMBRE`];
                checkboxField2.checked = data[`PUESTO${i * 2}`] === 'X';
                if (data[`PUESTO${i * 2}_CUMPLE_PPT`] === 'si') {
                    cumpleSiField2.checked = true;
                } else if (data[`PUESTO${i * 2}_CUMPLE_PPT`] === 'no') {
                    cumpleNoField2.checked = true;
                }
            }

        } else {
            puestoField.style.display = 'none';
        }
    }

    //  OBTENER LOS IDIOMAS
    if (data['NOMBRE_IDIOMA2_PPT'] && data['NOMBRE_IDIOMA2_PPT'] !== "") {
        document.getElementById('IDIOMA2').style.display = 'table-row';
        document.getElementById('NOMBRE_IDIOMA2_PPT').value = data['NOMBRE_IDIOMA2_PPT'];
        document.getElementById('addIdiomaBtn').style.display = 'none';
    }

    if (data['NOMBRE_IDIOMA3_PPT'] && data['NOMBRE_IDIOMA3_PPT'] !== "") {
        document.getElementById('IDIOMA3').style.display = 'table-row';
        document.getElementById('NOMBRE_IDIOMA3_PPT').value = data['NOMBRE_IDIOMA3_PPT'];
        document.getElementById('addIdiomaBtn2').style.display = 'none';
        document.getElementById('removeIdiomaBtn3').style.display = 'inline-block';
    }
});







$('#TablaPPT tbody').on('click', 'td>button.REVISAR', function () {


    var tr = $(this).closest('tr');
    var row = TablaPPT.row(tr);
    ID_FORMULARIO_PPT = row.data().ID_FORMULARIO_PPT
    data = row.data();
    form = "formularioPPT"

   
    //Rellenamos los datos del formulario
    editarDatoTabla(row.data(), 'formularioPPT', 'miModal_PPT', 1)
    mostrarCursos(data,form)


    $('#formularioPPT input').prop('disabled', true);
    $('#formularioPPT textarea').prop('disabled', true);
    $('#formularioPPT select').prop('disabled', true);

    $('#revisarFormPPT').css('display', 'block').prop('disabled', false);
    $('#guardarFormPPT').css('display', 'none').prop('disabled', true);

})


$('#TablaPPT tbody').on('click', 'td>button.AUTORIZAR', function () {


    var tr = $(this).closest('tr');
    var row = TablaPPT.row(tr);
    ID_FORMULARIO_PPT = row.data().ID_FORMULARIO_PPT
    data = row.data();
    form = "formularioPPT"

   
    //Rellenamos los datos del formulario
    editarDatoTabla(row.data(), 'formularioPPT', 'miModal_PPT', 1)
    mostrarCursos(data,form)


    $('#formularioPPT input').prop('disabled', true);
    $('#formularioPPT textarea').prop('disabled', true);
    $('#formularioPPT select').prop('disabled', true);

    $('#AutorizarFormPPT').css('display', 'block').prop('disabled', false);
    $('#guardarFormPPT').css('display', 'none').prop('disabled', true);

})

$('#revisarFormPPT').on('click', function () {
    
    alertMensajeConfirm({
        title: "¿Desea marcar como revisado este PPT?",
        text: "Al revisarlo, pasara hacer autorizado ",
        icon: "question",
    }, function () { 

        ajaxAwait({}, '/revisarPPT/' + ID_FORMULARIO_PPT, 'GET', { callbackAfter: true, callbackBefore: true }, () => {
    
            Swal.fire({
                icon: 'info',
                title: 'Espere un momento...',
                text: 'Estamos confirmando la revisión',
                showConfirmButton: false
            })

            $('.swal2-popup').addClass('ld ld-breath')
    
            
        }, function (data) {
                
            
            alertMensaje('success','Revisión confirmada', 'Esta información esta lista para ser autorizada',null,null, 2000)
            $('#miModal_PPT').modal('hide')
            document.getElementById('formularioPPT').reset();
            TablaPPT.ajax.reload()

        })
        
    }, 1)
})


$('#AutorizarFormPPT').on('click', function () {
    
    alertMensajeConfirm({
        title: "¿Desea autorizar el PPT?",
        text: "Al autorizarlo, podra hacer uso del PPT ",
        icon: "question",
    }, function () { 

        ajaxAwait({}, '/autorizarPPT/' + ID_FORMULARIO_PPT, 'GET', { callbackAfter: true, callbackBefore: true }, () => {
    
            Swal.fire({
                icon: 'info',
                title: 'Espere un momento...',
                text: 'Estamos confirmando la autorización',
                showConfirmButton: false
            })

            $('.swal2-popup').addClass('ld ld-breath')
    
            
        }, function (data) {
                
            
            alertMensaje('success','Autorización confirmada', 'Esta información esta lista para ser utilizada',null,null, 2000)
            $('#miModal_PPT').modal('hide')
            document.getElementById('formularioPPT').reset();
            TablaPPT.ajax.reload()

        })
        
    }, 1)
})


$('#TablaPPT tbody').on('click', 'td>button.PPT', function () {


    var tr = $(this).closest('tr');
    var row = TablaPPT.row(tr);
    ID_FORMULARIO_PPT = row.data().ID_FORMULARIO_PPT

   
       alertMensajeConfirm({
        title: "¿Desea visualizar el formato PPT?",
        text: "Confirma para continuar ",
        icon: "question",
    }, function () { 

		window.open("/makeExcelPPT/" + ID_FORMULARIO_PPT);
           
        
    }, 1)

})

function mostrarCursos(data,form){

 //RECORREMOS LOS CURSOS SI ES QUE EXISTE
 if ('CURSOS' in data) {
    if (data.CURSOS.length > 0) { 
      var cursos = data.CURSOS
      var count = 1    
    
        // Supongamos que 'data' es el array que contiene los objetos de datos
      cursos.forEach(function (obj) {
        
      

        // cumple = obj.CURSO_CUMPLE_PPT.toUpperCase(); 

        $('#' + form).find(`textarea[id='CURSO${count}_PPT']`).val(obj.CURSO_PPT)
    
          $('#' + form).find(`input[id='PORCENTAJE_CURSO${count}']`).val(obj.PORCENTAJE_CURSO);

        //   $('#' + form).find(`input[id='CURSO${count}_CUMPLE_${cumple}'][value='${obj.CURSO_CUMPLE_PPT}'][type='radio']`).prop('checked', true)


        if (obj.CURSO_DESEABLE == null) {
          
          $('#' + form).find(`input[id='CURSO${count}_REQUERIDO_PPT'][type='checkbox']`).prop('checked', true)

        } else {
          
          $('#' + form).find(`input[id='CURSO${count}_DESEABLE_PPT'][type='checkbox']`).prop('checked', true)

          }
          
        $('#' + form).find(`input[id='CURSO${count}_PPT']`).val(obj.CURSO_PPT)


        count++
      });


      cursosTotales = data.CURSOS.length 
      if (cursosTotales <= 10) {

        $('#cursoTemasCollapse').collapse('show')


      } else if (cursosTotales > 10 && cursosTotales <= 20) {
          $('#cursoTemasCollapse').collapse('show')
          $('#cursoTemas1Collapse').collapse('show')
          

      } else if (cursosTotales > 20 && cursosTotales <= 30) {
          $('#cursoTemasCollapse').collapse('show')
          $('#cursoTemas1Collapse').collapse('show')
          $('#cursoTemas2Collapse').collapse('show')


      } else if (cursosTotales > 30){
          
          $('.collapse').collapse('show')
      


      }

    }
  }
}



// Solo seleccionar una opcion de word,excel,power point
$('.word').on('change', function() {
    if ($(this).is(':checked')) {
        $('.word').not(this).prop('checked', false);
    }
});

$('.excel').on('change', function() {
    if ($(this).is(':checked')) {
        $('.excel').not(this).prop('checked', false);
    }
});

$('.power').on('change', function() {
    if ($(this).is(':checked')) {
        $('.power').not(this).prop('checked', false);
    }
});

//Solo seleccionar una opcion de los idomas 

$('.idioma1').on('change', function() {
    if ($(this).is(':checked')) {
        $('.idioma1').not(this).prop('checked', false);
    }
});


$('.idioma2').on('change', function() {
    if ($(this).is(':checked')) {
        $('.idioma2').not(this).prop('checked', false);
    }
});

$('.idioma3').on('change', function() {
    if ($(this).is(':checked')) {
        $('.idioma3').not(this).prop('checked', false);
    }
});


// AGREGAR IDOMAS

document.getElementById('addIdiomaBtn').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('IDIOMA2').style.display = 'table-row';
    this.style.display = 'none';
    document.getElementById('addIdiomaBtn2').style.display = 'inline-block';
    document.getElementById('removeIdiomaBtn2').style.display = 'inline-block';
    document.getElementById('removeIdiomaBtn3').style.display = 'none'; 
});

document.getElementById('addIdiomaBtn2').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('IDIOMA3').style.display = 'table-row';
    this.style.display = 'none';
    document.getElementById('removeIdiomaBtn3').style.display = 'inline-block';
    document.getElementById('removeIdiomaBtn2').style.display = 'none';
});

document.getElementById('removeIdiomaBtn2').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('IDIOMA2').style.display = 'none';
    document.getElementById('addIdiomaBtn').style.display = 'inline-block';
    document.getElementById('addIdiomaBtn2').style.display = 'none';
    this.style.display = 'none';
    document.getElementById('removeIdiomaBtn3').style.display = 'none'; 
});

document.getElementById('removeIdiomaBtn3').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('IDIOMA3').style.display = 'none';
    document.getElementById('addIdiomaBtn2').style.display = 'inline-block';
    this.style.display = 'none';
    document.getElementById('removeIdiomaBtn2').style.display = 'inline-block'; 
});


// check de los cursos

$('input[id^="CURSO"][id$="_REQUERIDO_PPT"], input[id^="CURSO"][id$="_DESEABLE_PPT"]').on('change', function() {

    var row = $(this).closest('tr');
    var requeridoCheckbox = row.find('input[id^="CURSO"][id$="_REQUERIDO_PPT"]');
    var deseableCheckbox = row.find('input[id^="CURSO"][id$="_DESEABLE_PPT"]');
    
    if ($(this).is(':checked')) {
        
        if ($(this).is(requeridoCheckbox)) {
            deseableCheckbox.prop('checked', false);
        } else if ($(this).is(deseableCheckbox)) {
            requeridoCheckbox.prop('checked', false);
        }

    }

});

// Habilidades y competencias funcionales
$('.innovacion').on('change', function() {
    if ($(this).is(':checked')) {
        $('.innovacion').not(this).prop('checked', false);
    }
});

$('.pasion').on('change', function() {
    if ($(this).is(':checked')) {
        $('.pasion').not(this).prop('checked', false);
    }
});

$('.servicio').on('change', function() {
    if ($(this).is(':checked')) {
        $('.servicio').not(this).prop('checked', false);
    }
});

$('.comunicacion').on('change', function() {
    if ($(this).is(':checked')) {
        $('.comunicacion').not(this).prop('checked', false);
    }
});

$('.trabajo').on('change', function() {
    if ($(this).is(':checked')) {
        $('.trabajo').not(this).prop('checked', false);
    }
});

$('.integridad').on('change', function() {
    if ($(this).is(':checked')) {
        $('.integridad').not(this).prop('checked', false);
    }    
});

$('.responsabilidad').on('change', function() {
    if ($(this).is(':checked')) {
        $('.responsabilidad').not(this).prop('checked', false);
    }
});

$('.adaptabilidad').on('change', function() {
    if ($(this).is(':checked')) {
        $('.adaptabilidad').not(this).prop('checked', false);
    }
});
$('.liderazgo').on('change', function() {
    if ($(this).is(':checked')) {
        $('.liderazgo').not(this).prop('checked', false);
    }
});

$('.decisiones').on('change', function() {
    if ($(this).is(':checked')) {
        $('.decisiones').not(this).prop('checked', false);
    }
});



document.addEventListener('DOMContentLoaded', function () {
    const puestos = ['puesto1', 'puesto2', 'puesto3', 'puesto4', 'puesto5'];

    document.getElementById('agregapuesto').addEventListener('click', function () {
        if (puestoIndex < puestos.length) {
            document.getElementById(puestos[puestoIndex]).style.display = 'flex';
            puestoIndex++;
        }
    });
});


document.addEventListener('DOMContentLoaded', function () {
    const selects = document.querySelectorAll('.puesto');

    selects.forEach(select => {
        select.addEventListener('change', function () {
            const selectedValues = Array.from(selects).map(s => s.value);
            
            selects.forEach(s => {
                const currentValue = s.value;
                const options = s.querySelectorAll('option');

                options.forEach(option => {
                    if (selectedValues.includes(option.value) && option.value !== currentValue) {
                        option.style.display = 'none';
                    } else {
                        option.style.display = 'block';
                    }
                });
            });
        });
    });
});


document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.eliminar-puesto').forEach(button => {
        button.addEventListener('click', function () {
            const puestoId = this.getAttribute('data-puesto');
            document.getElementById(puestoId).style.display = 'none';

            const inputs = document.getElementById(puestoId).querySelectorAll('input, select');
            inputs.forEach(input => input.value = '');
            const radios = document.getElementById(puestoId).querySelectorAll('input[type=radio]');
            radios.forEach(radio => radio.checked = false);
        });
    });
});



/// SUMA EN EL PPT




/// II. Formación académica

   function calcularSumaFormacion() {
    const ids = [
        'PORCENTAJE_SECUNDARIA',
        'PORCENTAJE_MEDIASUPERIOR',
        'PORCENTAJE_TECNICOSUPERIOR',
        'PORCENTAJE_UNIVERSITARIO',
        'PORCENTAJE_SITUACIONACADEMICA',
        'PORCENTAJE_CEDULA',
        'PORCENTAJE_AREA1',
        'PORCENTAJE_AREA2',
        'PORCENTAJE_AREA3',
        'PORCENTAJE_AREA4',
        'PORCENTAJE_ESPECIALIDAD',
        'PORCENTAJE_MAESTRIA',
        'PORCENTAJE_DOCTORADO'
    ];

    let suma = 0;

    ids.forEach(id => {
        const input = document.getElementById(id);
        if (input && input.value) {
            const valor = parseFloat(input.value) || 0;
            suma += valor;
        }
    });

    const sumaInput = document.getElementById('SUMA_FORMACION');
    if (sumaInput) {
        sumaInput.value = Number.isInteger(suma) ? suma : suma.toString();
    }

    if (suma > 20) {
        alertToast("La suma de los porcentajes de formación no puede exceder el 20%.", "error");
    } else if (suma === 20) {
        alertToast("La suma de los porcentajes de formación coincide correctamente.", "success");
    }
}

document.querySelectorAll('#PORCENTAJE_SECUNDARIA, #PORCENTAJE_MEDIASUPERIOR, #PORCENTAJE_TECNICOSUPERIOR, #PORCENTAJE_UNIVERSITARIO, #PORCENTAJE_SITUACIONACADEMICA, #PORCENTAJE_CEDULA, #PORCENTAJE_AREA1, #PORCENTAJE_AREA2, #PORCENTAJE_AREA3, #PORCENTAJE_AREA4, #PORCENTAJE_ESPECIALIDAD, #PORCENTAJE_MAESTRIA, #PORCENTAJE_DOCTORADO')
    .forEach(input => {
        input.addEventListener('input', calcularSumaFormacion);
    });


// III. Conocimientos adicionales
function calcularSumaConocimiento() {
    const ids = [
        'PORCENTAJE_WORD',
        'PORCENTAJE_EXCEL',
        'PORCENTAJE_POWERPOINT',
        'PORCENTAJE_IDIOMA1',
        'PORCENTAJE_IDIOMA2',
        'PORCENTAJE_IDIOMA3'
    ];

    let suma = 0;

    ids.forEach(id => {
        const input = document.getElementById(id);
        if (input && input.value) {
            const valor = parseFloat(input.value) || 0;
            suma += valor;
        }
    });

    const sumaInput = document.getElementById('SUMA_CONOCIMIENTO');
    if (sumaInput) {
        sumaInput.value = Number.isInteger(suma) ? suma : suma.toString();
    }

    if (suma > 10) {
        alertToast("La suma de los porcentajes de conocimientos no puede exceder el 10%.", "error");
    } else if (suma === 10) {
        alertToast("La suma de los porcentajes de conocimientos coincide correctamente.", "success");
    }
}

document.querySelectorAll('#PORCENTAJE_WORD, #PORCENTAJE_EXCEL, #PORCENTAJE_POWERPOINT, #PORCENTAJE_IDIOMA1, #PORCENTAJE_IDIOMA2, #PORCENTAJE_IDIOMA3')
    .forEach(input => {
        input.addEventListener('input', calcularSumaConocimiento);
    });


/// IV CURSOS

function calcularSumaCursos() {
    let suma = 0;

    for (let i = 1; i <= 40; i++) {
        const input = document.getElementById(`PORCENTAJE_CURSO${i}`);
        if (input && input.value) {
            const valor = parseFloat(input.value) || 0;
            suma += valor;
        }
    }

    const sumaInput = document.getElementById('SUMA_CURSOS');
    if (sumaInput) {
        sumaInput.value = Number.isInteger(suma) ? suma : suma.toString();
    }

    // Validaciones
    if (suma > 25) {
        alertToast("La suma de los porcentajes de cursos no puede exceder el 25%.", "error");
    } else if (suma === 25) {
        alertToast("La suma de los porcentajes de cursos coincide correctamente.", "success");
    }
}

for (let i = 1; i <= 40; i++) {
    const input = document.getElementById(`PORCENTAJE_CURSO${i}`);
    if (input) {
        input.addEventListener('input', calcularSumaCursos);
    }
}


/// V. Experiencia

function calcularSumaExperiencia() {
    const ids = [
        
        'PORCENTAJE_CANTIDADTOTAL',
        'PORCENTAJE_INDIQUEXPERIENCIA'
    ];

    let suma = 0;

    ids.forEach(id => {
        const input = document.getElementById(id);
        if (input && input.value) {
            const valor = parseFloat(input.value) || 0;
            suma += valor;
        }
    });

    const sumaInput = document.getElementById('SUMA_EXPERIENCIA');
    if (sumaInput) {
        sumaInput.value = Number.isInteger(suma) ? suma : suma.toString();
    }

    if (suma > 25) {
        alertToast("La suma de los porcentajes de experiencia no puede exceder el 25%.", "error");
    } else if (suma === 25) {
        alertToast("La suma de los porcentajes de experiencia coincide correctamente.", "success");
    }
}

document.querySelectorAll('#PORCENTAJE_CANTIDADTOTAL, #PORCENTAJE_INDIQUEXPERIENCIA')
    .forEach(input => {
        input.addEventListener('input', calcularSumaExperiencia);
    });


/// VI. Habilidades y competencias funcionales


function calcularSumaHabilidades() {
    const ids = [
        'PORCENTAJE_INNOVACION',
        'PORCENTAJE_PASION',
        'PORCENTAJE_SERVICIO_CLIENTE',
        'PORCENTAJE_COMUNICACION_EFICAZ',
        'PORCENTAJE_TRABAJO_EQUIPO',
        'PORCENTAJE_INTEGRIDAD',
        'PORCENTAJE_RESPONSABILIDAD_SOCIAL',
        'PORCENTAJE_ADAPTABILIDAD',
        'PORCENTAJE_LIDERAZGO',
        'PORCENTAJE_TOMA_DECISIONES'
    ];

    let suma = 0;

    ids.forEach(id => {
        const input = document.getElementById(id);
        if (input && input.value) {
            const valor = parseFloat(input.value) || 0;
            suma += valor;
        }
    });

    const sumaInput = document.getElementById('SUMA_HABILIDADES');
    if (sumaInput) {
        sumaInput.value = Number.isInteger(suma) ? suma : suma.toString();
    }

    if (suma > 20) {
        alertToast("La suma de los porcentajes de habilidades no puede exceder el 20%.", "error");
    } else if (suma === 20) {
        alertToast("La suma de los porcentajes de habilidades coincide correctamente.", "success");
    }
}

document.querySelectorAll('#PORCENTAJE_INNOVACION, #PORCENTAJE_PASION, #PORCENTAJE_SERVICIO_CLIENTE, #PORCENTAJE_COMUNICACION_EFICAZ, #PORCENTAJE_TRABAJO_EQUIPO, #PORCENTAJE_INTEGRIDAD, #PORCENTAJE_RESPONSABILIDAD_SOCIAL, #PORCENTAJE_ADAPTABILIDAD, #PORCENTAJE_LIDERAZGO, #PORCENTAJE_TOMA_DECISIONES')
    .forEach(input => {
        input.addEventListener('input', calcularSumaHabilidades);
    });
