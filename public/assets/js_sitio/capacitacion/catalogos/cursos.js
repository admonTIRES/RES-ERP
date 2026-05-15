
ID_CURSOS_CAPACITACION = 0


const Modalcurso = document.getElementById('miModal_curso');
Modalcurso.addEventListener('hidden.bs.modal', event => {

    ID_CURSOS_CAPACITACION = 0;
    document.getElementById('formulariocurso').reset();

    $('#CADA_ANIO').hide();
    $('#NOMBRE_CURSOS').hide();
    $('#PRESTACION_SERVICIOS').hide();

    $(".perfilrecomendado").empty();
    $(".cursosprevios").empty();
    $(".prestacionservicios").empty();
    $(".certificacionesinstructor").empty();
    $(".leccionesaprendidas").empty();
    $(".observacionescurso").empty();
    
});




$("#NUEVO_CURSO").click(function (e) {
    e.preventDefault();

       
    if ($('#CATEGORIAS_CURSO')[0].selectize) {
        $('#CATEGORIAS_CURSO')[0].selectize.destroy();
    }

    if ($('#TIPO_CURSO')[0].selectize) {
        $('#TIPO_CURSO')[0].selectize.destroy();
    }

    if ($('#AREA_CONOCIMIENTO')[0].selectize) {
        $('#AREA_CONOCIMIENTO')[0].selectize.destroy();
    }

    if ($('#NIVELES_CURSO')[0].selectize) {
        $('#NIVELES_CURSO')[0].selectize.destroy();
    }

    if ($('#MODALIDAD_CURSO')[0].selectize) {
        $('#MODALIDAD_CURSO')[0].selectize.destroy();
    }

    if ($('#FORMATO_CURSO')[0].selectize) {
        $('#FORMATO_CURSO')[0].selectize.destroy();
    }

    if ($('#PAISREGION_CURSO')[0].selectize) {
        $('#PAISREGION_CURSO')[0].selectize.destroy();
    }

    if ($('#IDIOMAS_CURSO')[0].selectize) {
        $('#IDIOMAS_CURSO')[0].selectize.destroy();
    }
    
    if ($('#NORMATIVA_CURSO')[0].selectize) {
        $('#NORMATIVA_CURSO')[0].selectize.destroy();
    }

    if ($('#RECONOCIMIENTO_CURSO')[0].selectize) {
        $('#RECONOCIMIENTO_CURSO')[0].selectize.destroy();
    }
    
    if ($('#COMPETENCIAS_CURSO')[0].selectize) {
        $('#COMPETENCIAS_CURSO')[0].selectize.destroy();
    }
    
    if ($('#TIPO_PROVEEDOR')[0].selectize) {
        $('#TIPO_PROVEEDOR')[0].selectize.destroy();
    }

    if ($('#METODO_EVALUACION')[0].selectize) {
        $('#METODO_EVALUACION')[0].selectize.destroy();
    }

    if ($('#EVIDENCIAS_GENERADAS')[0].selectize) {
        $('#EVIDENCIAS_GENERADAS')[0].selectize.destroy();
    }

    if ($('#DOCUMENTOS_EMITIDOS')[0].selectize) {
        $('#DOCUMENTOS_EMITIDOS')[0].selectize.destroy();
    }

    if ($('#UBICACION_CURSO')[0].selectize) {
        $('#UBICACION_CURSO')[0].selectize.destroy();
    }

    if ($('#MATERIAL_DIDACTICO')[0].selectize) {
        $('#MATERIAL_DIDACTICO')[0].selectize.destroy();
    }

    if ($('#IMPACTO_ESPERADO')[0].selectize) {
        $('#IMPACTO_ESPERADO')[0].selectize.destroy();
    }

    
    $('#formularioRECURSOSEMPLEADO').each(function () {
        this.reset();
    });


    $(".perfilrecomendado").empty();
    $(".cursosprevios").empty();
    $(".prestacionservicios").empty();
    $(".certificacionesinstructor").empty();
    $(".leccionesaprendidas").empty();
    $(".observacionescurso").empty();


    $("#miModal_curso").modal("show");
   
  
   $('#CATEGORIAS_CURSO').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
   });
    
    $('#TIPO_CURSO').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });
  
    $('#AREA_CONOCIMIENTO').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });
 
    $('#NIVELES_CURSO').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });

    $('#MODALIDAD_CURSO').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });
    
    $('#FORMATO_CURSO').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });

    $('#PAISREGION_CURSO').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });

    $('#IDIOMAS_CURSO').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });

    $('#NORMATIVA_CURSO').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });

    $('#RECONOCIMIENTO_CURSO').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });

    $('#COMPETENCIAS_CURSO').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });

    $('#TIPO_PROVEEDOR').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });

    $('#METODO_EVALUACION').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });

    $('#EVIDENCIAS_GENERADAS').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });

    $('#DOCUMENTOS_EMITIDOS').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });

    $('#UBICACION_CURSO').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });

    $('#MATERIAL_DIDACTICO').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });

     $('#IMPACTO_ESPERADO').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Seleccione una opción',
    });
});

$('#VIGENCIA_CURSO').on('change', function () {

    let valor = $(this).val();

    if (valor === "2" || valor === "3") {
        $('#CADA_ANIO').slideDown();
    } else {
        $('#CADA_ANIO').slideUp();
    }

});

document.addEventListener("DOMContentLoaded", function() {
    const botonAgregarperfil = document.getElementById('botonagregarperfilrecomendado');
    botonAgregarperfil.addEventListener('click', agregarperfil);

    function agregarperfil() {

        const contenedor = document.querySelector('.perfilrecomendado');

        let ultimaFila = contenedor.querySelector('.fila-perfil:last-child');

        if (!ultimaFila || ultimaFila.querySelectorAll('.col-6').length === 2) {
            ultimaFila = document.createElement('div');
            ultimaFila.classList.add('row', 'fila-perfil', 'mb-3');
            contenedor.appendChild(ultimaFila);
        }

        const bloque = document.createElement('div');
        bloque.classList.add('col-6');
        bloque.innerHTML = `
            <div class="form-group">
                <label>Recomendado *</label>
                <input type="text" class="form-control" name="PERFIL_RECOMENDADO" required>

                <div class="mt-2" style="text-align:center;">
                    <button type="button" class="btn btn-danger botonEliminarperfil">
                        <i class="bi bi-trash3-fill"></i>
                    </button>
                </div>
            </div>
        `;

        ultimaFila.appendChild(bloque);

        bloque.querySelector('.botonEliminarperfil')
            .addEventListener('click', function() {
                bloque.remove();

                if (ultimaFila.querySelectorAll('.col-6').length === 0) {
                    ultimaFila.remove();
                }
            });
    }
});

$('#CURSOS_PREVIOS').on('change', function () {

    let valor = $(this).val();

    if (valor === "1") {
        $('#NOMBRE_CURSOS').slideDown();
    } else {
        $('#NOMBRE_CURSOS').slideUp();
    }
});

document.addEventListener("DOMContentLoaded", function() {
    const botonCursos = document.getElementById('botonagregarcursos');
    botonCursos.addEventListener('click', agregarcursos);

    function agregarcursos() {

        const contenedor = document.querySelector('.cursosprevios');

        let ultimaFila = contenedor.querySelector('.fila-cursos:last-child');

        if (!ultimaFila || ultimaFila.querySelectorAll('.col-6').length === 2) {
            ultimaFila = document.createElement('div');
            ultimaFila.classList.add('row', 'fila-cursos', 'mb-3');
            contenedor.appendChild(ultimaFila);
        }

        const bloque = document.createElement('div');
        bloque.classList.add('col-6');
        bloque.innerHTML = `
            <div class="form-group">
                <label>Nombre del curso *</label>
                <input type="text" class="form-control" name="NOMBRE_CURSO" required>

                <div class="mt-2" style="text-align:center;">
                    <button type="button" class="btn btn-danger botonEliminarcurso">
                        <i class="bi bi-trash3-fill"></i>
                    </button>
                </div>
            </div>
        `;

        ultimaFila.appendChild(bloque);

        bloque.querySelector('.botonEliminarcurso')
            .addEventListener('click', function() {
                bloque.remove();

                if (ultimaFila.querySelectorAll('.col-6').length === 0) {
                    ultimaFila.remove();
                }
            });
    }
});

$('#PRESTACIONSERVICIOS_CURSO').on('change', function () {

    let valor = $(this).val();

    if (valor === "1") {
        $('#PRESTACION_SERVICIOS').slideDown();
    } else {
        $('#PRESTACION_SERVICIOS').slideUp();
    }
});

document.addEventListener("DOMContentLoaded", function() {

    const botonAgregarServicio = document.getElementById('botonagregarservicios');
    botonAgregarServicio.addEventListener('click', agregarServicio);

    function agregarServicio() {

        let opciones = `<option value="">Seleccione una opción</option>`;

        if (window.lineas && Array.isArray(window.lineas)) {
            window.lineas.forEach(lineas => {
                opciones += `
                    <option value="${lineas.ID_LINEA_NEGOCIO}">
                        ${lineas.ABREVIATURA_NEGOCIO}
                    </option>
                `;
            });
        }

        const divServicio = document.createElement('div');
        divServicio.classList.add('row', 'generarservicio', 'mb-3');

        divServicio.innerHTML = `
        
            <div class="col-6">
                <div class="form-group">
                    <label>Línea de negocio *</label>
                    <select class="form-control"
                            name="LINEA_NEGOCIO"
                            required>
                        ${opciones}
                    </select>
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label>¿Cuál? *</label>
                    <input type="text"
                           class="form-control"
                           name="CUAL_SERVICIO"
                           required>
                </div>
            </div>

            <div class="col-12 mt-2">
                <div class="form-group" style="text-align: center;">
                    <button type="button"
                            class="btn btn-danger botonEliminarServicio">
                        <i class="bi bi-trash3-fill"></i>
                    </button>
                </div>
            </div>
        `;

        const contenedor = document.querySelector('.prestacionservicios');
        contenedor.appendChild(divServicio);

        const botonEliminar = divServicio.querySelector('.botonEliminarServicio');
        botonEliminar.addEventListener('click', function() {
            contenedor.removeChild(divServicio);
        });
    }

});

$('#CERTIFICACIONES_INSTRUCTOR').on('change', function () {

    let valor = $(this).val();

    if (valor === "1") {
        $('#CERTIFICACIONESINSTRUCTOR').slideDown();
    } else {
        $('#CERTIFICACIONESINSTRUCTOR').slideUp();
    }
});

document.addEventListener("DOMContentLoaded", function() {
    const botonCertificaciones = document.getElementById('botonagregarcertificacioninstructor');
    botonCertificaciones.addEventListener('click', agregarcertificacion);

    function agregarcertificacion() {

        const contenedor = document.querySelector('.certificacionesinstructor');

        let ultimaFila = contenedor.querySelector('.fila-certificaciones:last-child');

        if (!ultimaFila || ultimaFila.querySelectorAll('.col-6').length === 2) {
            ultimaFila = document.createElement('div');
            ultimaFila.classList.add('row', 'fila-certificaciones', 'mb-3');
            contenedor.appendChild(ultimaFila);
        }

        const bloque = document.createElement('div');
        bloque.classList.add('col-6');
        bloque.innerHTML = `
            <div class="form-group">
                <label>Nombre certificación *</label>
                <input type="text" class="form-control" name="NOMBRE_CERTIFICACION" required>

                <div class="mt-2" style="text-align:center;">
                    <button type="button" class="btn btn-danger botonEliminarcertificacion">
                        <i class="bi bi-trash3-fill"></i>
                    </button>
                </div>
            </div>
        `;

        ultimaFila.appendChild(bloque);

        bloque.querySelector('.botonEliminarcertificacion')
            .addEventListener('click', function() {
                bloque.remove();

                if (ultimaFila.querySelectorAll('.col-6').length === 0) {
                    ultimaFila.remove();
                }
            });
    }
});



document.addEventListener("DOMContentLoaded", function() {
    const botonAgregarLecciones = document.getElementById('botonagregarlecciones');
    botonAgregarLecciones.addEventListener('click', agregarlecciones);

    function agregarlecciones() {

        const contenedor = document.querySelector('.leccionesaprendidas');

        let ultimaFila = contenedor.querySelector('.fila-lecciones:last-child');

        if (!ultimaFila || ultimaFila.querySelectorAll('.col-6').length === 2) {
            ultimaFila = document.createElement('div');
            ultimaFila.classList.add('row', 'fila-lecciones', 'mb-3');
            contenedor.appendChild(ultimaFila);
        }

        const bloque = document.createElement('div');
        bloque.classList.add('col-6');
        bloque.innerHTML = `
            <div class="form-group">
                <label>Lección *</label>
                <input type="text" class="form-control" name="NOMBRE_LECCION" required>

                <div class="mt-2" style="text-align:center;">
                    <button type="button" class="btn btn-danger botonEliminarleccion">
                        <i class="bi bi-trash3-fill"></i>
                    </button>
                </div>
            </div>
        `;

        ultimaFila.appendChild(bloque);

        bloque.querySelector('.botonEliminarleccion')
            .addEventListener('click', function() {
                bloque.remove();

                if (ultimaFila.querySelectorAll('.col-6').length === 0) {
                    ultimaFila.remove();
                }
            });
    }
});

document.addEventListener("DOMContentLoaded", function() {
    const botonAgregarObservaciones = document.getElementById('botonagregarobservaciones');
    botonAgregarObservaciones.addEventListener('click', agregarobservaciones);

    function agregarobservaciones() {

        const contenedor = document.querySelector('.observacionescurso');

        let ultimaFila = contenedor.querySelector('.fila-observaciones:last-child');

        if (!ultimaFila || ultimaFila.querySelectorAll('.col-6').length === 2) {
            ultimaFila = document.createElement('div');
            ultimaFila.classList.add('row', 'fila-observaciones', 'mb-3');
            contenedor.appendChild(ultimaFila);
        }

        const bloque = document.createElement('div');
        bloque.classList.add('col-6');
        bloque.innerHTML = `
            <div class="form-group">
                <label>Observación *</label>
                <input type="text" class="form-control" name="INPUT_OBSERVACION" required>
                <div class="mt-2" style="text-align:center;">
                    <button type="button" class="btn btn-danger botonEliminarobservacion">
                        <i class="bi bi-trash3-fill"></i>
                    </button>
                </div>
            </div>
        `;

        ultimaFila.appendChild(bloque);

        bloque.querySelector('.botonEliminarobservacion')
            .addEventListener('click', function() {
                bloque.remove();

                if (ultimaFila.querySelectorAll('.col-6').length === 0) {
                    ultimaFila.remove();
                }
            });
    }
});



$("#guardarcursos").click(function (e) {
    e.preventDefault();


    formularioValido = validarFormulario3($('#formulariocurso'))

    if (formularioValido) {


        var perfilrestricciones = [];
            $("[name='PERFIL_RECOMENDADO']").each(function () {
                perfilrestricciones.push({ 'PERFIL_RECOMENDADO': $(this).val() });
        });
        
          var cursosprevios = [];
            $("[name='NOMBRE_CURSO']").each(function () {
                cursosprevios.push({ 'NOMBRE_CURSO': $(this).val() });
        });
        
        
        var prestacionservicios = [];
        $(".generarservicio ").each(function() {
            var inputservicios = {
                'LINEA_NEGOCIO': $(this).find("select[name='LINEA_NEGOCIO']").val(),
                'CUAL_SERVICIO': $(this).find("input[name='CUAL_SERVICIO']").val(),
            };
            prestacionservicios.push(inputservicios);
        });

        var certificacioninstructor = [];
            $("[name='NOMBRE_CERTIFICACION']").each(function () {
                certificacioninstructor.push({ 'NOMBRE_CERTIFICACION': $(this).val() });
        });
        
        var leccionesaprendidas= [];
            $("[name='NOMBRE_LECCION']").each(function () {
                leccionesaprendidas.push({ 'NOMBRE_LECCION': $(this).val() });
        });
        
         var observacionescurso= [];
            $("[name='INPUT_OBSERVACION']").each(function () {
                observacionescurso.push({ 'NOMBREINPUT_OBSERVACION_LECCION': $(this).val() });
        });
        
         const requestData = {
            api: 1,
            ID_CURSOS_CAPACITACION: ID_CURSOS_CAPACITACION,
            PERFILRECOMENDADO_CURSO: JSON.stringify(perfilrestricciones),
            CURSOS_JSON: JSON.stringify(cursosprevios),
            PRESTACION_SERVICIO_JSON: JSON.stringify(prestacionservicios),
            CERTIFICACIONES_INSTRUCTOR_JSON: JSON.stringify(certificacioninstructor),
            LECCIONES_APRENDIDAS: JSON.stringify(leccionesaprendidas),
            OBSERVACIONES_CURSO: JSON.stringify(observacionescurso),
            

        };



    if (ID_CURSOS_CAPACITACION == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarcursos')
            await ajaxAwaitFormData(requestData, 'CapCursoSave', 'formulariocurso', 'guardarcursos', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                    ID_CURSOS_CAPACITACION = data.capacitaciones.ID_CURSOS_CAPACITACION
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_curso').modal('hide')
                    document.getElementById('formulariocurso').reset();
                    Tablacapcursos.ajax.reload()

           
                
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarcursos')
            await ajaxAwaitFormData(requestData, 'CapCursoSave', 'formulariocurso', 'guardarcursos', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_CURSOS_CAPACITACION = data.capacitaciones.ID_CURSOS_CAPACITACION
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_curso').modal('hide')
                    document.getElementById('formulariocurso').reset();
                    Tablacapcursos.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});


var Tablacapcursos = $("#Tablacapcursos").DataTable({
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
        url: '/Tablacapcursos',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablacapcursos.columns.adjust().draw();
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
        { data: 'NUMERO_ID' },
        { data: 'NOMBE_OFICIAL_CURSO' },
        { data: 'NOMBE_COMERCIAL_CURSO' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Código del curso', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Nombre oficial del curso', className: 'all text-center nombre-column' },
        { targets: 3, title: 'Nombre corto / comercial', className: 'all text-center nombre-column' },
        { targets: 4, title: 'Editar', className: 'all text-center' },
        { targets: 5, title: 'Visualizar', className: 'all text-center' },
        { targets: 6, title: 'Activo', className: 'all text-center' }
    ]
});


$('#Tablacapcursos tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacapcursos.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_CURSOS_CAPACITACION: row.data().ID_CURSOS_CAPACITACION
    };

    eliminarDatoTabla(data, [Tablacapcursos], 'CapCursoDelete');
});



$('#Tablacapcursos tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacapcursos.row(tr);


    ID_CURSOS_CAPACITACION = row.data().ID_CURSOS_CAPACITACION;

    editarDatoTabla(row.data(), 'formulariocurso', 'miModal_curso',1);



    if (row.data().VIGENCIA_CURSO === "1") {
        $('#CADA_ANIO').hide();
    } else if (row.data().VIGENCIA_CURSO === "2") {
        $('#CADA_ANIO').show();
    } else if (row.data().VIGENCIA_CURSO === "3") {
        $('#CADA_ANIO').show();
    }else {
        $('#CADA_ANIO').hide();
    }

    if (row.data().CURSOS_PREVIOS === "1") {
        $('#NOMBRE_CURSOS').show();
    } else if (row.data().CURSOS_PREVIOS === "2") {
        $('#NOMBRE_CURSOS').hide();
    }else {
        $('#NOMBRE_CURSOS').hide();
    }

    if (row.data().PRESTACIONSERVICIOS_CURSO === "1") {
        $('#PRESTACION_SERVICIOS').show();
    } else if (row.data().PRESTACIONSERVICIOS_CURSO === "2") {
        $('#PRESTACION_SERVICIOS').hide();
    }else {
        $('#PRESTACION_SERVICIOS').hide();
    }

    if (row.data().CERTIFICACIONES_INSTRUCTOR === "1") {
        $('#CERTIFICACIONESINSTRUCTOR').show();
    } else if (row.data().CERTIFICACIONES_INSTRUCTOR === "2") {
        $('#CERTIFICACIONESINSTRUCTOR').hide();
    }else {
        $('#CERTIFICACIONESINSTRUCTOR').hide();
    }



    /// CATEGORIAS 
    if (!$('#CATEGORIAS_CURSO')[0].selectize) {
            $('#CATEGORIAS_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selcat = $('#CATEGORIAS_CURSO')[0].selectize;
        selcat.clear();

        let valorescat = row.data().CATEGORIAS_CURSO;

        if (typeof valorescat === "string") {
            try { valorescat = JSON.parse(valorescat); } catch (e) { valorescat = []; }
        }

        if (Array.isArray(valorescat)) {
            selcat.setValue(valorescat);
    }
    

    /// TIPO CURSO
    if (!$('#TIPO_CURSO')[0].selectize) {
            $('#TIPO_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let seltipocurso = $('#TIPO_CURSO')[0].selectize;
        seltipocurso.clear();

        let valorestipocurso= row.data().TIPO_CURSO;

        if (typeof valorestipocurso === "string") {
            try { valorestipocurso = JSON.parse(valorestipocurso); } catch (e) { valorestipocurso = []; }
        }

        if (Array.isArray(valorestipocurso)) {
            seltipocurso.setValue(valorestipocurso);
    }

    /// AREA CONOCIMIENTO
    if (!$('#AREA_CONOCIMIENTO')[0].selectize) {
            $('#AREA_CONOCIMIENTO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selarea = $('#AREA_CONOCIMIENTO')[0].selectize;
        selarea.clear();

        let valoresarea= row.data().AREA_CONOCIMIENTO;

        if (typeof valoresarea === "string") {
            try { valoresarea = JSON.parse(valoresarea); } catch (e) { valoresarea = []; }
        }

        if (Array.isArray(valoresarea)) {
            selarea.setValue(valoresarea);
    }

     /// NIVELES
    if (!$('#NIVELES_CURSO')[0].selectize) {
            $('#NIVELES_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selniveles = $('#NIVELES_CURSO')[0].selectize;
        selniveles.clear();

        let valorniveles= row.data().NIVELES_CURSO;

        if (typeof valorniveles === "string") {
            try { valorniveles = JSON.parse(valorniveles); } catch (e) { valorniveles = []; }
        }

        if (Array.isArray(valorniveles)) {
            selniveles.setValue(valorniveles);
    }

     /// MODALIDAD
    if (!$('#MODALIDAD_CURSO')[0].selectize) {
            $('#MODALIDAD_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selmodalidad = $('#MODALIDAD_CURSO')[0].selectize;
        selmodalidad.clear();

        let valormodalidad= row.data().MODALIDAD_CURSO;

        if (typeof valormodalidad === "string") {
            try { valormodalidad = JSON.parse(valormodalidad); } catch (e) { valormodalidad = []; }
        }

        if (Array.isArray(valormodalidad)) {
            selmodalidad.setValue(valormodalidad);
    }

    /// FORMATO
    if (!$('#FORMATO_CURSO')[0].selectize) {
            $('#FORMATO_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selformato = $('#FORMATO_CURSO')[0].selectize;
        selformato.clear();

        let valorformato= row.data().FORMATO_CURSO;

        if (typeof valorformato === "string") {
            try { valorformato = JSON.parse(valorformato); } catch (e) { valorformato = []; }
        }

        if (Array.isArray(valorformato)) {
            selformato.setValue(valorformato);
    }

     /// PAIS
    if (!$('#PAISREGION_CURSO')[0].selectize) {
            $('#PAISREGION_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selpais = $('#PAISREGION_CURSO')[0].selectize;
        selpais.clear();

        let valorpais= row.data().PAISREGION_CURSO;

        if (typeof valorpais === "string") {
            try { valorpais = JSON.parse(valorpais); } catch (e) { valorpais = []; }
        }

        if (Array.isArray(valorpais)) {
            selpais.setValue(valorpais);
    }

      /// IDIOMA
    if (!$('#IDIOMAS_CURSO')[0].selectize) {
            $('#IDIOMAS_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selidioma = $('#IDIOMAS_CURSO')[0].selectize;
        selidioma.clear();

        let valoridioma= row.data().IDIOMAS_CURSO;

        if (typeof valoridioma === "string") {
            try { valoridioma = JSON.parse(valoridioma); } catch (e) { valoridioma = []; }
        }

        if (Array.isArray(valoridioma)) {
            selidioma.setValue(valoridioma);
    }

       /// NORMATIVA
    if (!$('#NORMATIVA_CURSO')[0].selectize) {
            $('#NORMATIVA_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selnormativa = $('#NORMATIVA_CURSO')[0].selectize;
        selnormativa.clear();

        let valornormativa= row.data().NORMATIVA_CURSO;

        if (typeof valornormativa === "string") {
            try { valornormativa = JSON.parse(valornormativa); } catch (e) { valornormativa = []; }
        }

        if (Array.isArray(valornormativa)) {
            selnormativa.setValue(valornormativa);
    }

      /// RECONOCIMIENTO
    if (!$('#RECONOCIMIENTO_CURSO')[0].selectize) {
            $('#RECONOCIMIENTO_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selreconocimiento = $('#RECONOCIMIENTO_CURSO')[0].selectize;
        selreconocimiento.clear();

        let valoreconocimineto= row.data().RECONOCIMIENTO_CURSO;

        if (typeof valoreconocimineto === "string") {
            try { valoreconocimineto = JSON.parse(valoreconocimineto); } catch (e) { valoreconocimineto = []; }
        }

        if (Array.isArray(valoreconocimineto)) {
            selreconocimiento.setValue(valoreconocimineto);
    }

      /// COMPETENCIAS
    if (!$('#COMPETENCIAS_CURSO')[0].selectize) {
            $('#COMPETENCIAS_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selcompetencias = $('#COMPETENCIAS_CURSO')[0].selectize;
        selcompetencias.clear();

        let valorcompetencias= row.data().COMPETENCIAS_CURSO;

        if (typeof valorcompetencias === "string") {
            try { valorcompetencias = JSON.parse(valorcompetencias); } catch (e) { valorcompetencias = []; }
        }

        if (Array.isArray(valorcompetencias)) {
            selcompetencias.setValue(valorcompetencias);
    }

     /// TIPO PROVEEDOR
    if (!$('#TIPO_PROVEEDOR')[0].selectize) {
            $('#TIPO_PROVEEDOR').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let seltipoproveedor = $('#TIPO_PROVEEDOR')[0].selectize;
        seltipoproveedor.clear();

        let valortipoproveedor= row.data().TIPO_PROVEEDOR;

        if (typeof valortipoproveedor === "string") {
            try { valortipoproveedor = JSON.parse(valortipoproveedor); } catch (e) { valortipoproveedor = []; }
        }

        if (Array.isArray(valortipoproveedor)) {
            seltipoproveedor.setValue(valortipoproveedor);
    }

     ///  METODO EVALUACION
    if (!$('#METODO_EVALUACION')[0].selectize) {
            $('#METODO_EVALUACION').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selmetodoevaluacion = $('#METODO_EVALUACION')[0].selectize;
        selmetodoevaluacion.clear();

        let valormetodoevaluacion= row.data().METODO_EVALUACION;

        if (typeof valormetodoevaluacion === "string") {
            try { valormetodoevaluacion = JSON.parse(valormetodoevaluacion); } catch (e) { valormetodoevaluacion = []; }
        }

        if (Array.isArray(valormetodoevaluacion)) {
            selmetodoevaluacion.setValue(valormetodoevaluacion);
    }

      ///  EVIDENCIAS GENERADAS
    if (!$('#EVIDENCIAS_GENERADAS')[0].selectize) {
            $('#EVIDENCIAS_GENERADAS').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selevidencias = $('#EVIDENCIAS_GENERADAS')[0].selectize;
        selevidencias.clear();

        let valorevidencias= row.data().EVIDENCIAS_GENERADAS;

        if (typeof valorevidencias === "string") {
            try { valorevidencias = JSON.parse(valorevidencias); } catch (e) { valorevidencias = []; }
        }

        if (Array.isArray(valorevidencias)) {
            selevidencias.setValue(valorevidencias);
    }

        ///  DOCUMENTOS EMITIDOS
    if (!$('#DOCUMENTOS_EMITIDOS')[0].selectize) {
            $('#DOCUMENTOS_EMITIDOS').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let seldocumentos= $('#DOCUMENTOS_EMITIDOS')[0].selectize;
        seldocumentos.clear();

        let valordocumentos= row.data().DOCUMENTOS_EMITIDOS;

        if (typeof valordocumentos === "string") {
            try { valordocumentos = JSON.parse(valordocumentos); } catch (e) { valordocumentos = []; }
        }

        if (Array.isArray(valordocumentos)) {
            seldocumentos.setValue(valordocumentos);
    }

       ///  UBICACION   
    if (!$('#UBICACION_CURSO')[0].selectize) {
            $('#UBICACION_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selubicacion= $('#UBICACION_CURSO')[0].selectize;
        selubicacion.clear();

        let valorubicacion= row.data().UBICACION_CURSO;

        if (typeof valorubicacion === "string") {
            try { valorubicacion = JSON.parse(valorubicacion); } catch (e) { valorubicacion = []; }
        }

        if (Array.isArray(valorubicacion)) {
            selubicacion.setValue(valorubicacion);
    }

     ///  MATERIAL DIDACTICO   
    if (!$('#MATERIAL_DIDACTICO')[0].selectize) {
            $('#MATERIAL_DIDACTICO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selmaterial= $('#MATERIAL_DIDACTICO')[0].selectize;
        selmaterial.clear();

        let valormaterial= row.data().MATERIAL_DIDACTICO;

        if (typeof valormaterial === "string") {
            try { valormaterial = JSON.parse(valormaterial); } catch (e) { valormaterial = []; }
        }

        if (Array.isArray(valormaterial)) {
            selmaterial.setValue(valormaterial);
    }

     /// IMPACTO ESPERADO   
    if (!$('#IMPACTO_ESPERADO')[0].selectize) {
            $('#IMPACTO_ESPERADO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selimpacto= $('#IMPACTO_ESPERADO')[0].selectize;
        selimpacto.clear();

        let valorimpacto= row.data().IMPACTO_ESPERADO;

        if (typeof valorimpacto === "string") {
            try { valorimpacto = JSON.parse(valorimpacto); } catch (e) { valorimpacto = []; }
        }

        if (Array.isArray(valorimpacto)) {
            selimpacto.setValue(valorimpacto);
    }



   $(".perfilrecomendado").empty();
    mostrarperfilrecomendado(row);

    $(".cursosprevios").empty();
    mostrarcursosprevios(row);

    $(".prestacionservicios").empty();
    mostrarPrestacionServicios(row);

    $(".certificacionesinstructor").empty();
    mostrarcertificaciones(row);

    $(".leccionesaprendidas").empty();
    mostrarleccionesaprendidas(row);

    $(".observacionescurso").empty();
    mostrarobservaciones(row);




    

    $('#miModal_curso .modal-title').html(row.data().NOMBE_OFICIAL_CURSO);

});

function mostrarperfilrecomendado(row) {

    let contenedor = document.querySelector('.perfilrecomendado');

    contenedor.innerHTML = "";

    let data = row.data().PERFILRECOMENDADO_CURSO;

    if (!data) return;

    try {
        data = JSON.parse(data);
    } catch (e) {
        data = [];
    }

    let ultimaFila = null;

    data.forEach((item, index) => {

        if (!ultimaFila || ultimaFila.querySelectorAll('.col-6').length === 2) {
            ultimaFila = document.createElement('div');
            ultimaFila.classList.add('row', 'fila-perfil', 'mb-3');
            contenedor.appendChild(ultimaFila);
        }

        const bloque = document.createElement('div');
        bloque.classList.add('col-6');
        bloque.innerHTML = `
            <div class="form-group">
                <label>Recomendado *</label>
                <input type="text" class="form-control" 
                       name="PERFIL_RECOMENDADO" 
                       value="${item.PERFIL_RECOMENDADO}" required>

                <div class="mt-2" style="text-align:center;">
                    <button type="button" class="btn btn-danger botonEliminarperfil">
                        <i class="bi bi-trash3-fill"></i>
                    </button>
                </div>
            </div>
        `;

        ultimaFila.appendChild(bloque);

        bloque.querySelector('.botonEliminarperfil')
            .addEventListener('click', function () {
                bloque.remove();

                if (ultimaFila.querySelectorAll('.col-6').length === 0) {
                    ultimaFila.remove();
                }
            });
    });
}

function mostrarcursosprevios(row) {

    let contenedor = document.querySelector('.cursosprevios');

    contenedor.innerHTML = "";

    let data = row.data().CURSOS_JSON;

    if (!data) return;

    try {
        data = JSON.parse(data);
    } catch (e) {
        data = [];
    }

    let ultimaFila = null;

    data.forEach((item, index) => {

        if (!ultimaFila || ultimaFila.querySelectorAll('.col-6').length === 2) {
            ultimaFila = document.createElement('div');
            ultimaFila.classList.add('row', 'fila-cursos', 'mb-3');
            contenedor.appendChild(ultimaFila);
        }

        const bloque = document.createElement('div');
        bloque.classList.add('col-6');
        bloque.innerHTML = `
            <div class="form-group">
                <label>Nombre del curso *</label>
                <input type="text" class="form-control" 
                       name="NOMBRE_CURSO" 
                       value="${item.NOMBRE_CURSO}" required>

                <div class="mt-2" style="text-align:center;">
                    <button type="button" class="btn btn-danger botonEliminarcurso">
                        <i class="bi bi-trash3-fill"></i>
                    </button>
                </div>
            </div>
        `;

        ultimaFila.appendChild(bloque);

        bloque.querySelector('.botonEliminarcurso')
            .addEventListener('click', function () {
                bloque.remove();

                if (ultimaFila.querySelectorAll('.col-6').length === 0) {
                    ultimaFila.remove();
                }
            });
    });
}

function mostrarPrestacionServicios(row) {

    const contenedor = document.querySelector('.prestacionservicios');
    contenedor.innerHTML = "";

    let data = row.data().PRESTACION_SERVICIO_JSON;

    if (!data) return;

    try {
        data = JSON.parse(data);
    } catch (e) {
        data = [];
    }

    data.forEach((item) => {

        const fila = document.createElement('div');
        fila.classList.add('row', 'generarservicio', 'mb-3');

        const servicioSeleccionada = item.LINEA_NEGOCIO;
        const cualServicio = item.CUAL_SERVICIO ?? "";

        let opcionesClasificacion = `<option value="">Seleccione una clasificación</option>`;

        if (window.lineas && Array.isArray(window.lineas)) {
            window.lineas.forEach(servicios => {
                opcionesClasificacion += `
                    <option value="${servicios.ID_LINEA_NEGOCIO}"
                        ${servicios.ID_LINEA_NEGOCIO == servicioSeleccionada ? "selected" : ""}>
                        ${servicios.ABREVIATURA_NEGOCIO}
                    </option>
                `;
            });
        }

        fila.innerHTML = `
            <div class="col-6">
                <div class="form-group">
                    <label>Línea de negocio *</label>
                    <select class="form-control"
                            name="LINEA_NEGOCIO"
                            required>
                        ${opcionesClasificacion}
                    </select>
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                      <label>¿Cuál? *</label>
                    <input type="text"
                           class="form-control"
                           name="CUAL_SERVICIO"
                           value="${cualServicio}"
                           required>
                </div>
            </div>

           <div class="col-12 mt-2">
                <div class="form-group" style="text-align: center;">
                    <button type="button"
                            class="btn btn-danger botonEliminarServicio">
                        <i class="bi bi-trash3-fill"></i>
                    </button>
                </div>
            </div>
        `;

        contenedor.appendChild(fila);

        // 🗑 Eliminar fila
        fila.querySelector('.botonEliminarServicio')
            .addEventListener('click', function () {
                fila.remove();
            });
    });
}

function mostrarcertificaciones(row) {

    let contenedor = document.querySelector('.certificacionesinstructor');

    contenedor.innerHTML = "";

    let data = row.data().CERTIFICACIONES_INSTRUCTOR_JSON;

    if (!data) return;

    try {
        data = JSON.parse(data);
    } catch (e) {
        data = [];
    }

    let ultimaFila = null;

    data.forEach((item, index) => {

        if (!ultimaFila || ultimaFila.querySelectorAll('.col-6').length === 2) {
            ultimaFila = document.createElement('div');
            ultimaFila.classList.add('row', 'fila-certificaciones', 'mb-3');
            contenedor.appendChild(ultimaFila);
        }

        const bloque = document.createElement('div');
        bloque.classList.add('col-6');
        bloque.innerHTML = `
            <div class="form-group">
            <label>Nombre certificación *</label>
                 <input type="text" class="form-control"
                       name="NOMBRE_CERTIFICACION" 
                       value="${item.NOMBRE_CERTIFICACION}" required>

                <div class="mt-2" style="text-align:center;">
                    <button type="button" class="btn btn-danger botonEliminarcertificacion">
                        <i class="bi bi-trash3-fill"></i>
                    </button>
                </div>
            </div>
        `;

        ultimaFila.appendChild(bloque);

        bloque.querySelector('.botonEliminarcertificacion')
            .addEventListener('click', function () {
                bloque.remove();

                if (ultimaFila.querySelectorAll('.col-6').length === 0) {
                    ultimaFila.remove();
                }
            });
    });
}

function mostrarleccionesaprendidas(row) {

    let contenedor = document.querySelector('.leccionesaprendidas');

    contenedor.innerHTML = "";

    let data = row.data().LECCIONES_APRENDIDAS;

    if (!data) return;

    try {
        data = JSON.parse(data);
    } catch (e) {
        data = [];
    }

    let ultimaFila = null;

    data.forEach((item, index) => {

        if (!ultimaFila || ultimaFila.querySelectorAll('.col-6').length === 2) {
            ultimaFila = document.createElement('div');
            ultimaFila.classList.add('row', 'fila-lecciones', 'mb-3');
            contenedor.appendChild(ultimaFila);
        }

        const bloque = document.createElement('div');
        bloque.classList.add('col-6');
        bloque.innerHTML = `
            <div class="form-group">
                <label>Lección *</label>
                <input type="text" class="form-control" 
                       name="NOMBRE_LECCION" 
                       value="${item.NOMBRE_LECCION}" required>

                <div class="mt-2" style="text-align:center;">
                    <button type="button" class="btn btn-danger botonEliminarleccion">
                        <i class="bi bi-trash3-fill"></i>
                    </button>
                </div>
            </div>
        `;

        ultimaFila.appendChild(bloque);

        bloque.querySelector('.botonEliminarleccion')
            .addEventListener('click', function () {
                bloque.remove();

                if (ultimaFila.querySelectorAll('.col-6').length === 0) {
                    ultimaFila.remove();
                }
            });
    });
}

function mostrarobservaciones(row) {

    let contenedor = document.querySelector('.observacionescurso');

    contenedor.innerHTML = "";

    let data = row.data().OBSERVACIONES_CURSO;

    if (!data) return;

    try {
        data = JSON.parse(data);
    } catch (e) {
        data = [];
    }

    let ultimaFila = null;

    data.forEach((item, index) => {

        if (!ultimaFila || ultimaFila.querySelectorAll('.col-6').length === 2) {
            ultimaFila = document.createElement('div');
            ultimaFila.classList.add('row', 'fila-observaciones', 'mb-3');
            contenedor.appendChild(ultimaFila);
        }

        const bloque = document.createElement('div');
        bloque.classList.add('col-6');
        bloque.innerHTML = `
            <div class="form-group">
                 <label>Observación *</label>
                <input type="text" class="form-control" 
                       name="INPUT_OBSERVACION" 
                       value="${item.INPUT_OBSERVACION}" required>

                <div class="mt-2" style="text-align:center;">
                    <button type="button" class="btn btn-danger botonEliminarobservacion">
                        <i class="bi bi-trash3-fill"></i>
                    </button>
                </div>
            </div>
        `;

        ultimaFila.appendChild(bloque);

        bloque.querySelector('.botonEliminarobservacion')
            .addEventListener('click', function () {
                bloque.remove();

                if (ultimaFila.querySelectorAll('.col-6').length === 0) {
                    ultimaFila.remove();
                }
            });
    });
}

$(document).ready(function() {
    $('#Tablacapcursos tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablacapcursos.row(tr);
        
        hacerSoloLecturainventario(row.data(), '#miModal_curso');

        ID_CURSOS_CAPACITACION = row.data().ID_CURSOS_CAPACITACION;
        editarDatoTabla(row.data(), 'formulariocurso', 'miModal_curso',1);


    if (row.data().VIGENCIA_CURSO === "1") {
        $('#CADA_ANIO').hide();
    } else if (row.data().VIGENCIA_CURSO === "2") {
        $('#CADA_ANIO').show();
    } else if (row.data().VIGENCIA_CURSO === "3") {
        $('#CADA_ANIO').show();
    }else {
        $('#CADA_ANIO').hide();
    }

    if (row.data().CURSOS_PREVIOS === "1") {
        $('#NOMBRE_CURSOS').show();
    } else if (row.data().CURSOS_PREVIOS === "2") {
        $('#NOMBRE_CURSOS').hide();
    }else {
        $('#NOMBRE_CURSOS').hide();
    }

    if (row.data().PRESTACIONSERVICIOS_CURSO === "1") {
        $('#PRESTACION_SERVICIOS').show();
    } else if (row.data().PRESTACIONSERVICIOS_CURSO === "2") {
        $('#PRESTACION_SERVICIOS').hide();
    }else {
        $('#PRESTACION_SERVICIOS').hide();
    }

    if (row.data().CERTIFICACIONES_INSTRUCTOR === "1") {
        $('#CERTIFICACIONESINSTRUCTOR').show();
    } else if (row.data().CERTIFICACIONES_INSTRUCTOR === "2") {
        $('#CERTIFICACIONESINSTRUCTOR').hide();
    }else {
        $('#CERTIFICACIONESINSTRUCTOR').hide();
    }



    /// CATEGORIAS 
    if (!$('#CATEGORIAS_CURSO')[0].selectize) {
            $('#CATEGORIAS_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selcat = $('#CATEGORIAS_CURSO')[0].selectize;
        selcat.clear();

        let valorescat = row.data().CATEGORIAS_CURSO;

        if (typeof valorescat === "string") {
            try { valorescat = JSON.parse(valorescat); } catch (e) { valorescat = []; }
        }

        if (Array.isArray(valorescat)) {
            selcat.setValue(valorescat);
    }
    

    /// TIPO CURSO
    if (!$('#TIPO_CURSO')[0].selectize) {
            $('#TIPO_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let seltipocurso = $('#TIPO_CURSO')[0].selectize;
        seltipocurso.clear();

        let valorestipocurso= row.data().TIPO_CURSO;

        if (typeof valorestipocurso === "string") {
            try { valorestipocurso = JSON.parse(valorestipocurso); } catch (e) { valorestipocurso = []; }
        }

        if (Array.isArray(valorestipocurso)) {
            seltipocurso.setValue(valorestipocurso);
    }

    /// AREA CONOCIMIENTO
    if (!$('#AREA_CONOCIMIENTO')[0].selectize) {
            $('#AREA_CONOCIMIENTO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selarea = $('#AREA_CONOCIMIENTO')[0].selectize;
        selarea.clear();

        let valoresarea= row.data().AREA_CONOCIMIENTO;

        if (typeof valoresarea === "string") {
            try { valoresarea = JSON.parse(valoresarea); } catch (e) { valoresarea = []; }
        }

        if (Array.isArray(valoresarea)) {
            selarea.setValue(valoresarea);
    }

     /// NIVELES
    if (!$('#NIVELES_CURSO')[0].selectize) {
            $('#NIVELES_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selniveles = $('#NIVELES_CURSO')[0].selectize;
        selniveles.clear();

        let valorniveles= row.data().NIVELES_CURSO;

        if (typeof valorniveles === "string") {
            try { valorniveles = JSON.parse(valorniveles); } catch (e) { valorniveles = []; }
        }

        if (Array.isArray(valorniveles)) {
            selniveles.setValue(valorniveles);
    }

     /// MODALIDAD
    if (!$('#MODALIDAD_CURSO')[0].selectize) {
            $('#MODALIDAD_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selmodalidad = $('#MODALIDAD_CURSO')[0].selectize;
        selmodalidad.clear();

        let valormodalidad= row.data().MODALIDAD_CURSO;

        if (typeof valormodalidad === "string") {
            try { valormodalidad = JSON.parse(valormodalidad); } catch (e) { valormodalidad = []; }
        }

        if (Array.isArray(valormodalidad)) {
            selmodalidad.setValue(valormodalidad);
    }

    /// FORMATO
    if (!$('#FORMATO_CURSO')[0].selectize) {
            $('#FORMATO_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selformato = $('#FORMATO_CURSO')[0].selectize;
        selformato.clear();

        let valorformato= row.data().FORMATO_CURSO;

        if (typeof valorformato === "string") {
            try { valorformato = JSON.parse(valorformato); } catch (e) { valorformato = []; }
        }

        if (Array.isArray(valorformato)) {
            selformato.setValue(valorformato);
    }

     /// PAIS
    if (!$('#PAISREGION_CURSO')[0].selectize) {
            $('#PAISREGION_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selpais = $('#PAISREGION_CURSO')[0].selectize;
        selpais.clear();

        let valorpais= row.data().PAISREGION_CURSO;

        if (typeof valorpais === "string") {
            try { valorpais = JSON.parse(valorpais); } catch (e) { valorpais = []; }
        }

        if (Array.isArray(valorpais)) {
            selpais.setValue(valorpais);
    }

      /// IDIOMA
    if (!$('#IDIOMAS_CURSO')[0].selectize) {
            $('#IDIOMAS_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selidioma = $('#IDIOMAS_CURSO')[0].selectize;
        selidioma.clear();

        let valoridioma= row.data().IDIOMAS_CURSO;

        if (typeof valoridioma === "string") {
            try { valoridioma = JSON.parse(valoridioma); } catch (e) { valoridioma = []; }
        }

        if (Array.isArray(valoridioma)) {
            selidioma.setValue(valoridioma);
    }

       /// NORMATIVA
    if (!$('#NORMATIVA_CURSO')[0].selectize) {
            $('#NORMATIVA_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selnormativa = $('#NORMATIVA_CURSO')[0].selectize;
        selnormativa.clear();

        let valornormativa= row.data().NORMATIVA_CURSO;

        if (typeof valornormativa === "string") {
            try { valornormativa = JSON.parse(valornormativa); } catch (e) { valornormativa = []; }
        }

        if (Array.isArray(valornormativa)) {
            selnormativa.setValue(valornormativa);
    }

      /// RECONOCIMIENTO
    if (!$('#RECONOCIMIENTO_CURSO')[0].selectize) {
            $('#RECONOCIMIENTO_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selreconocimiento = $('#RECONOCIMIENTO_CURSO')[0].selectize;
        selreconocimiento.clear();

        let valoreconocimineto= row.data().RECONOCIMIENTO_CURSO;

        if (typeof valoreconocimineto === "string") {
            try { valoreconocimineto = JSON.parse(valoreconocimineto); } catch (e) { valoreconocimineto = []; }
        }

        if (Array.isArray(valoreconocimineto)) {
            selreconocimiento.setValue(valoreconocimineto);
    }

      /// COMPETENCIAS
    if (!$('#COMPETENCIAS_CURSO')[0].selectize) {
            $('#COMPETENCIAS_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selcompetencias = $('#COMPETENCIAS_CURSO')[0].selectize;
        selcompetencias.clear();

        let valorcompetencias= row.data().COMPETENCIAS_CURSO;

        if (typeof valorcompetencias === "string") {
            try { valorcompetencias = JSON.parse(valorcompetencias); } catch (e) { valorcompetencias = []; }
        }

        if (Array.isArray(valorcompetencias)) {
            selcompetencias.setValue(valorcompetencias);
    }

     /// TIPO PROVEEDOR
    if (!$('#TIPO_PROVEEDOR')[0].selectize) {
            $('#TIPO_PROVEEDOR').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let seltipoproveedor = $('#TIPO_PROVEEDOR')[0].selectize;
        seltipoproveedor.clear();

        let valortipoproveedor= row.data().TIPO_PROVEEDOR;

        if (typeof valortipoproveedor === "string") {
            try { valortipoproveedor = JSON.parse(valortipoproveedor); } catch (e) { valortipoproveedor = []; }
        }

        if (Array.isArray(valortipoproveedor)) {
            seltipoproveedor.setValue(valortipoproveedor);
    }

     ///  METODO EVALUACION
    if (!$('#METODO_EVALUACION')[0].selectize) {
            $('#METODO_EVALUACION').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selmetodoevaluacion = $('#METODO_EVALUACION')[0].selectize;
        selmetodoevaluacion.clear();

        let valormetodoevaluacion= row.data().METODO_EVALUACION;

        if (typeof valormetodoevaluacion === "string") {
            try { valormetodoevaluacion = JSON.parse(valormetodoevaluacion); } catch (e) { valormetodoevaluacion = []; }
        }

        if (Array.isArray(valormetodoevaluacion)) {
            selmetodoevaluacion.setValue(valormetodoevaluacion);
    }

      ///  EVIDENCIAS GENERADAS
    if (!$('#EVIDENCIAS_GENERADAS')[0].selectize) {
            $('#EVIDENCIAS_GENERADAS').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selevidencias = $('#EVIDENCIAS_GENERADAS')[0].selectize;
        selevidencias.clear();

        let valorevidencias= row.data().EVIDENCIAS_GENERADAS;

        if (typeof valorevidencias === "string") {
            try { valorevidencias = JSON.parse(valorevidencias); } catch (e) { valorevidencias = []; }
        }

        if (Array.isArray(valorevidencias)) {
            selevidencias.setValue(valorevidencias);
    }

        ///  DOCUMENTOS EMITIDOS
    if (!$('#DOCUMENTOS_EMITIDOS')[0].selectize) {
            $('#DOCUMENTOS_EMITIDOS').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let seldocumentos= $('#DOCUMENTOS_EMITIDOS')[0].selectize;
        seldocumentos.clear();

        let valordocumentos= row.data().DOCUMENTOS_EMITIDOS;

        if (typeof valordocumentos === "string") {
            try { valordocumentos = JSON.parse(valordocumentos); } catch (e) { valordocumentos = []; }
        }

        if (Array.isArray(valordocumentos)) {
            seldocumentos.setValue(valordocumentos);
    }

       ///  UBICACION   
    if (!$('#UBICACION_CURSO')[0].selectize) {
            $('#UBICACION_CURSO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selubicacion= $('#UBICACION_CURSO')[0].selectize;
        selubicacion.clear();

        let valorubicacion= row.data().UBICACION_CURSO;

        if (typeof valorubicacion === "string") {
            try { valorubicacion = JSON.parse(valorubicacion); } catch (e) { valorubicacion = []; }
        }

        if (Array.isArray(valorubicacion)) {
            selubicacion.setValue(valorubicacion);
    }

     ///  MATERIAL DIDACTICO   
    if (!$('#MATERIAL_DIDACTICO')[0].selectize) {
            $('#MATERIAL_DIDACTICO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selmaterial= $('#MATERIAL_DIDACTICO')[0].selectize;
        selmaterial.clear();

        let valormaterial= row.data().MATERIAL_DIDACTICO;

        if (typeof valormaterial === "string") {
            try { valormaterial = JSON.parse(valormaterial); } catch (e) { valormaterial = []; }
        }

        if (Array.isArray(valormaterial)) {
            selmaterial.setValue(valormaterial);
    }

     /// IMPACTO ESPERADO   
    if (!$('#IMPACTO_ESPERADO')[0].selectize) {
            $('#IMPACTO_ESPERADO').selectize({
                placeholder: 'Seleccione una o varias opciones',
                maxItems: null
            });
        }

        let selimpacto= $('#IMPACTO_ESPERADO')[0].selectize;
        selimpacto.clear();

        let valorimpacto= row.data().IMPACTO_ESPERADO;

        if (typeof valorimpacto === "string") {
            try { valorimpacto = JSON.parse(valorimpacto); } catch (e) { valorimpacto = []; }
        }

        if (Array.isArray(valorimpacto)) {
            selimpacto.setValue(valorimpacto);
    }



   $(".perfilrecomendado").empty();
    mostrarperfilrecomendado(row);

    $(".cursosprevios").empty();
    mostrarcursosprevios(row);

    $(".prestacionservicios").empty();
    mostrarPrestacionServicios(row);

    $(".certificacionesinstructor").empty();
    mostrarcertificaciones(row);

    $(".leccionesaprendidas").empty();
    mostrarleccionesaprendidas(row);

    $(".observacionescurso").empty();
    mostrarobservaciones(row);





    $('#miModal_curso .modal-title').html(row.data().NOMBE_OFICIAL_CURSO);

    });

    $('#miModal_curso').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_curso');
    });
});



$('#TIPO_ID').on('change', function () {

    let tipo = $(this).val();

    if (!tipo) {
        $('#NUMERO_ID').val('');
        return;
    }

    $.ajax({
        url: '/generarCodigoCurso',
        method: 'POST',
        data: {
            TIPO_ID: tipo,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {

            if (response.codigo) {
                $('#NUMERO_ID').val(response.codigo);
            } else {
                $('#NUMERO_ID').val('');
            }

        }
    });
});



$('#COSTO_CURSO, #TASA_CAMBIO').on('input', function () {

    let costo = $('#COSTO_CURSO').val().replace(/,/g, '');
    let tasa  = $('#TASA_CAMBIO').val().replace(/,/g, '');

    let numCosto = parseFloat(costo);
    let numTasa  = parseFloat(tasa);

    if (!isNaN(numCosto) && !isNaN(numTasa)) {
        $('#VALOR_MXN').val(numCosto * numTasa);
    } else {
        $('#VALOR_MXN').val('');
    }

});
