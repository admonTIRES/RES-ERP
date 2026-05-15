//VARIABLES GLOBALES
var ID_AREA = 0

//TABLAS
TablaCategorias = null

function resetDiagram() {
  
    document.getElementById("myDiagramDiv").innerHTML = "";

    if (myDiagram) {
        myDiagram.div = null;
        myDiagram = null;
    }
    
    if (myOverview) {
        myOverview.div = null;
        myOverview = null;
    }
}

//FUNCION PARA EL ORGANIGRAMA
function init(dataJsonOrganigrama) {
    
      
          const $ = go.GraphObject.make; 

          // some constants that will be reused within templates
          var mt8 = new go.Margin(8, 0, 0, 0);
          var mt4 = new go.Margin(4, 0, 0, 0);
          var mr8 = new go.Margin(0, 8, 0, 0);
          var ml8 = new go.Margin(0, 0, 0, 8);
          var roundedRectangleParams = {
            parameter1: 15,  // set the rounded corner
            spot1: go.Spot.TopLeft, spot2: go.Spot.BottomRight  
          };

            // Function to determine color based on boss
          function determineColor(boss) {
            switch (boss) { 
              case 1: return "#09ABDD";  //Direccion
              case 2: return "#94B732";  //Intermediarios de areas
              case 3: return "#0A3E62";  //Areas
              case 4: return "#94B732";  //Intermediarios de cargos
              case 5: return "#B4C7E7";  //Cargos
              default: return "#ffffff"; 
            }
          }

          myDiagram =
            $(go.Diagram, "myDiagramDiv",  // the DIV HTML element
              {
                // Put the diagram contents at the top center of the viewport
                initialDocumentSpot: go.Spot.Top,
                initialViewportSpot: go.Spot.Top,
                layout:
                  $(go.TreeLayout,  // use a TreeLayout to position all of the nodes
                    {
                      isOngoing: false,  // don't relayout when expanding/collapsing panels
                      treeStyle: go.TreeLayout.StyleLastParents,
                      // properties for most of the tree:
                      angle: 90,
                      layerSpacing: 45,
                      // properties for the "last parents":
                      alternateAngle: 0,
                      alternateAlignment: go.TreeLayout.AlignmentStart,
                      alternateNodeIndent: 12,
                      alternateNodeIndentPastParent: 1,
                      alternateNodeSpacing: 20,
                      alternateLayerSpacing: 40,
                      alternateLayerSpacingParentOverlap: 1,
                      alternatePortSpot: new go.Spot(0.001, 1, 20, 0),
                      alternateChildPortSpot: go.Spot.Left
                    })
              });

          // This function provides a common style for most of the TextBlocks.
          // Some of these values may be overridden in a particular TextBlock.
          function textStyle(field) {
            return [
              {
                font: "12px Roboto, sans-serif", stroke: "#ffffff",
                visible: false  // only show textblocks when there is corresponding data for them
              },
              new go.Binding("visible", field, val => val !== undefined)
            ];
          }

        
          // define the Node template
          myDiagram.nodeTemplate =
            $(go.Node, "Auto",
              {
                locationSpot: go.Spot.Top,
                isShadowed: true, shadowBlur: 1,
                shadowOffset: new go.Point(0, 1),
                shadowColor: "rgba(0, 0, 0, .14)",
                selectionAdornmentTemplate:  // selection adornment to match shape of nodes
                  $(go.Adornment, "Auto",
                    $(go.Shape, "RoundedRectangle", roundedRectangleParams,
                      { fill: null, stroke: "#7986cb", strokeWidth: 3 }
                    ),
                    $(go.Placeholder)
                  )  // end Adornment
              },
              $(go.Shape, "RoundedRectangle", roundedRectangleParams,
                { name: "SHAPE", fill: "#ffffff", strokeWidth: 0 },
                // gold if highlighted, white otherwise
              new go.Binding("fill", "type", determineColor)

              ),
              $(go.Panel, "Vertical",
                $(go.Panel, "Horizontal",
                  { margin: 30 },
                  $(go.Panel, "Table",
                    $(go.TextBlock,
                      {
                        row: 0, alignment: go.Spot.Right,
                        font: "30px Roboto, sans-serif",
                        stroke: "#ffffff",
                        maxSize: new go.Size(500, NaN)
                      },
                      new go.Binding("text", "name")
                    ),
                  )
                ),
              )
            );

          // define the Link template, a simple orthogonal line
          myDiagram.linkTemplate =
            $(go.Link, go.Link.Orthogonal,
              { corner: 2, selectable: false },
              $(go.Shape, { strokeWidth: 3, stroke: "#000000" }));  // dark gray, rounded corner links



          // create the Model with data for the tree, and assign to the Diagram
          myDiagram.model =
            new go.TreeModel(
              {
                nodeParentKeyProperty: "boss",  // this property refers to the parent node data
                nodeDataArray: dataJsonOrganigrama
              });

          // Overview
          myOverview =
            $(go.Overview, "myOverviewDiv",  // the HTML DIV element for the Overview
              { observed: myDiagram, contentAlignment: go.Spot.Center });   // tell it which Diagram to show and pan
    
}






//LIMPIAMOS EL FORMULARIO DE AREAS CADA VEZ QUE ESTE SE CIERRE
const ModalArea = document.getElementById('ModalArea')
ModalArea.addEventListener('hidden.bs.modal', event => {
    document.getElementById('formArea').reset();
    // $('#guardarArea').text('Guardar')
    $('#guardarArea').html('Guardar').prop('disabled', false).removeClass('btn-light').addClass('btn-success');
    $('#nav-encargados-tab').prop('disabled', true)
    $('#nav-cargos-tab').prop('disabled', true)
    $('#nav-area-tab').click()
    ID_AREA = 0

    $('#ModalArea .modal-title').html('Nueva Área');

    
    document.getElementById('quitar_documento').style.display = 'none';

    document.getElementById('ERROR_DOCUMENTO').style.display = 'none';
})


document.addEventListener('DOMContentLoaded', function() {
    var archivo = document.getElementById('DOCUMENTO_ORGANIGRAMA');
    var quitar = document.getElementById('quitar_documento');
    var error = document.getElementById('ERROR_DOCUMENTO');

    if (archivo) {
        archivo.addEventListener('change', function() {
            var archivoscontrato = this.files[0]; // Accede al archivo
            if (archivoscontrato && archivoscontrato.type === 'application/pdf') {
                if (error) error.style.display = 'none';
                if (quitar) quitar.style.display = 'block';
            } else {
                if (error) error.style.display = 'block';
                this.value = ''; // Limpia el input si no es un PDF válido
                if (quitar) quitar.style.display = 'none';
            }
        });
        quitar.addEventListener('click', function() {
            archivo.value = ''; 
            quitar.style.display = 'none'; 
            if (error) error.style.display = 'none'; 
        });
    }
});



const ModalOrganigrama = document.getElementById('modalOrganigrama')
ModalOrganigrama.addEventListener('hidden.bs.modal', event => {
    resetDiagram()
    $('.body').css('padding-right', '0px')
})

$('#nav-encargados-tab').on('click', function () { TablaCategorias.columns.adjust().draw() })

// ======================== AREAS =================================
$("#guardarArea").click(function (e) {
    e.preventDefault();
    
    formularioValido = validarFormulario($('#formArea'))

    if (formularioValido) {

        if (ID_AREA == 0) {
            
            alertMensajeConfirm({
                title: "¿Desea guardar esta nueva área?",
                text: "Al guardarla, se agregara al organigrama",
                icon: "question",
            }, async function () {

                await loaderbtn('guardarArea')
                await ajaxAwaitFormData({ api: 1, ID_AREA: ID_AREA }, 'areasSave', 'formArea', 'guardarArea', { callbackAfter: true }, false, function (data) {
                        
                    setTimeout(() => {

                        ID_AREA = data.area.ID_AREA
                        $('#nav-encargados-tab').prop('disabled', false)
                        $('#nav-cargos-tab').prop('disabled', false)
                        alertToast('Área guardada exitosamente', 'success', 3000)

                        //Cargamos las tablas
                        TablaAreas.ajax.reload()
                        TablaEncargados(ID_AREA)

                        
                        
                    }, 300);
                    
                    
                })
                
                
                
            }, 1)
            
        } else {
            alertMensajeConfirm({
                title: "¿Desea editar el área actual?",
                text: "Al guardarla, se editara en el organigrama",
                icon: "question",
            }, async function () {

                await loaderbtn('guardarArea')
                await ajaxAwaitFormData({ api: 1, ID_AREA: ID_AREA }, 'areasSave', 'formArea', 'guardarArea', { callbackAfter: true }, false, function (data) {
                        
                    setTimeout(() => {

                        ID_AREA = data.area.ID_AREA
                        $('#nav-encargados-tab').prop('disabled', false)
                        alertToast('Área editada exitosamente', 'success', 3000)
                        TablaAreas.ajax.reload()

                    }, 300);
                })
            }, 1)
        }
    } else {
        // Muestra un mensaje de error o realiza alguna otra acción
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

    }
});

//INICIAMOS LA TABLA DE LAS AREAS
TablaAreas = $("#TablaAreas").DataTable({
    language: { url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json", },
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
        url: '/TablaAreas',
        beforeSend: function () {
            mostrarCarga()
        },
        complete: function () {
            TablaAreas.columns.adjust().draw()
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
        { data: 'NOMBRE' },
        { data: 'LIDERES' },
        { data: 'CATEGORIAS' },
        { data: 'BTN_ORGANIGRAMA' },
        { data: 'BTN_DOCUMENTO' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' },



    ],
    columnDefs: [
        { target: 0, title: '#', className: 'all' },
        { target: 1, title: 'Área', className: 'all' },
        { target: 2, title: 'Líderes de categorías', className: 'all' },
        { target: 3, title: 'Categorías', className: 'all' },
        { target: 4, title: 'Organigrama', className: 'all text-center' },
        { target: 5, title: 'Documento', className: 'all text-center' },
        { target: 6, title: 'Editar', className: 'all text-center' },
        { target: 7, title: 'Visualizar', className: 'all text-center' },
        { target: 8, title: 'Activo', className: 'all text-center' },


    ]
})


$('#TablaAreas').on('click', '.ver-archivo-pdf', function () {
    var tr = $(this).closest('tr');
    var row = TablaAreas.row(tr);
    var id = $(this).data('id');

    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }

    var nombreDocumentoSoporte = row.data().NOMBRE;
    var url = '/mostrararchivo/' + id;
    
    abrirModal(url, nombreDocumentoSoporte);
});




$('#TablaAreas tbody').on('click', 'td>button.EDITAR', function () {

    var tr = $(this).closest('tr');
    var row = TablaAreas.row(tr);
    ID_AREA = row.data().ID_AREA


    editarDatoTabla(row.data(), 'formArea', 'ModalArea',1)


           
  if (row.data().FOTO_ORGANIGRAMA) {
        var archivo = row.data().FOTO_ORGANIGRAMA;
        var extension = archivo.substring(archivo.lastIndexOf("."));
        var imagenUrl = '/mostrarFoto/' + row.data().ID_AREA + extension;
        console.log(imagenUrl); 

        if ($('#FOTO_ORGANIGRAMA').data('dropify')) {
            $('#FOTO_ORGANIGRAMA').dropify().data('dropify').destroy();
            $('#FOTO_ORGANIGRAMA').dropify().data('dropify').settings.defaultFile = imagenUrl;
            $('#FOTO_ORGANIGRAMA').dropify().data('dropify').init();
        } else {
            $('#FOTO_ORGANIGRAMA').attr('data-default-file', imagenUrl);
            $('#FOTO_ORGANIGRAMA').dropify({
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
        $('#FOTO_ORGANIGRAMA').dropify().data('dropify').resetPreview();
        $('#FOTO_ORGANIGRAMA').dropify().data('dropify').clearElement();
    }



    $('#nav-encargados-tab').prop('disabled', false)
    $('#nav-cargos-tab').prop('disabled', false)

    //CARGAMOS LA TABLA DE LOS DEPARTAMENTOS
    TablaEncargados(ID_AREA)

    $('#ModalArea .modal-title').html(row.data().NOMBRE);
 

})


$(document).ready(function() {
    $('#TablaAreas tbody').on('click', 'td>button.VISUALIZAR', function () {
        
        var tr = $(this).closest('tr');
        var row = TablaAreas.row(tr);
        ID_AREA = row.data().ID_AREA
        
        hacerSoloLectura2(row.data(), '#ModalArea');

         editarDatoTabla(row.data(), 'formArea', 'ModalArea',1)


           
  if (row.data().FOTO_ORGANIGRAMA) {
        var archivo = row.data().FOTO_ORGANIGRAMA;
        var extension = archivo.substring(archivo.lastIndexOf("."));
        var imagenUrl = '/mostrarFoto/' + row.data().ID_AREA + extension;
        console.log(imagenUrl); 

        if ($('#FOTO_ORGANIGRAMA').data('dropify')) {
            $('#FOTO_ORGANIGRAMA').dropify().data('dropify').destroy();
            $('#FOTO_ORGANIGRAMA').dropify().data('dropify').settings.defaultFile = imagenUrl;
            $('#FOTO_ORGANIGRAMA').dropify().data('dropify').init();
        } else {
            $('#FOTO_ORGANIGRAMA').attr('data-default-file', imagenUrl);
            $('#FOTO_ORGANIGRAMA').dropify({
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
        $('#FOTO_ORGANIGRAMA').dropify().data('dropify').resetPreview();
        $('#FOTO_ORGANIGRAMA').dropify().data('dropify').clearElement();
    }



    $('#nav-encargados-tab').prop('disabled', false)
    $('#nav-cargos-tab').prop('disabled', false)

    //CARGAMOS LA TABLA DE LOS DEPARTAMENTOS
    TablaEncargados(ID_AREA)

        $('#ModalArea .modal-title').html(row.data().NOMBRE);
        



    });

    $('#ModalArea').on('hidden.bs.modal', function () {
        resetFormulario('#ModalArea');
    });
});



$('#TablaAreas tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = TablaAreas.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_AREA: row.data().ID_AREA
    };

    eliminarDatoTabla(data, [TablaAreas], 'areasDelete');
});






$('#TablaAreas tbody').on('click', 'td>button.ORGANIGRAMA', function () {

    var tr = $(this).closest('tr');
    var row = TablaAreas.row(tr);

    $('#TituloModalOrganigrma').text('Organigrama del área de: '+ row.data().NOMBRE)

    url = '/getDataOrganigrama/' + row.data().ID_AREA + '/' + 0

    ajaxAwait({}, url , 'GET', { callbackAfter: true, callbackBefore: true }, () => {
		
        Swal.fire({
            icon: 'info',
            title: 'Espere un momento',
            text: 'Estamos cargando la información para el organigrama',
            showConfirmButton: false
        })

        $('.swal2-popup').addClass('ld ld-breath')
        
    }, function (data) {

        swal.close()
        $('.swal2-popup').removeClass('ld ld-breath')
        dataJsonOrganigrama = JSON.parse(data.data)
        //Ejcutamos la funcion que crear el organigrama
        init(dataJsonOrganigrama)
            
        $('#modalOrganigrama').modal('show')

        
    })

  
})



$('#verOrganigramaGeneral').on('click', function () {


    $('#TituloModalOrganigrma').text('Organigrama General ')

    url = '/getDataOrganigrama/' + 0 + '/' + 1

    ajaxAwait({}, url , 'GET', { callbackAfter: true, callbackBefore: true }, () => {
		
        Swal.fire({
            icon: 'info',
            title: 'Espere un momento',
            text: 'Estamos cargando la información para el organigrama',
            showConfirmButton: false
        })
        
    }, function (data) {

        swal.close()
        dataJsonOrganigrama = JSON.parse(data.data)
        //Ejcutamos la funcion que crear el organigrama
        init(dataJsonOrganigrama)
            
        $('#modalOrganigrama').modal('show')

        
    })

  
})

// ======================== FUNCIONALIDADES DE LAS CATEGORIAS DE  AREAS =================================

$('#CATEGORIA').on('change', function (e) {

    var valorSeleccionado = $(this).find("option:selected");
    var esLider = valorSeleccionado.data("lider");
    
    if (esLider == 1) {
        $('#esLiderText').text('Es líder: Si')
        $('#LIDER').prop('disabled', true).prop('required', false)
        $('#LIDER').val('')
        $('#ES_LIDER').val(1)

    } else {
        $('#esLiderText').text('Es líder: No')
        $('#LIDER').prop('disabled', false).prop('required', false)
        $('#LIDER').val('')
        $('#ES_LIDER').val(0)
    }
})


$("#guardarEncargado").click(function (e) {
    e.preventDefault();
    
  
    formularioValido = validarFormulario($('#formCategoria'))

    if (formularioValido) {
        
    alertMensajeConfirm({
        title: "¿Desea agregar esta categoría al area actual?",
        text: "Al guardarlo, se agregara al organigrama",
        icon: "question",
    },async function () { 

        await loaderbtn('guardarEncargado')

        await ajaxAwaitFormData({ api: 2, AREA_ID : ID_AREA, NUEVO: 1 }, 'areasSave', 'formCategoria', 'guardarEncargado', { callbackAfter: true}, false, function (data) {
                
            setTimeout(() => {
                
                document.getElementById('formCategoria').reset();
                $('#esLiderText').text('Categoría')

                alertToast('Categoría agregada exitosamente', 'success', 3000)

                TablaAreas.ajax.reload()
                TablaCategorias.ajax.reload()
                
                
            }, 300);  
        })
    }, 1)
} else {
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}

});


function TablaEncargados(id_area) {

    if (TablaCategorias != null) {
        TablaCategorias.destroy()
        
    }   

    TablaCategorias = $("#TablaEncargados").DataTable({
        language: { url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json", },
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
            url: '/TablaEncargados/'+ id_area,
            beforeSend: function () {
        
            },
            complete: function () {
                TablaCategorias.columns.adjust().draw()
            
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alertErrorAJAX(jqXHR, textStatus, errorThrown);
            },
            dataSrc: 'data'
        },
        columns: [
            { data: 'COUNT' },
            { data: 'NOMBRE' },
            { data: 'ES_LIDER' },
            { data: 'BTN_ACTIVO' },


        ],
        columnDefs: [
            { target: 0, title: '#', className: 'all' },
            { target: 1, title: 'Nombre de la categoría', className: 'all' },
            { target: 2, title: 'Es líder', className: 'all text-center' },
            { target: 3, title: 'Activo', className: 'all text-center' },

        ]
    })

}


$(document).on('change', '.ACTIVAR', function () {

    const checkbox = $(this);
    const id       = checkbox.data('id');
    const tipo     = checkbox.data('tipo');
    const activo   = checkbox.is(':checked') ? 1 : 0;

    checkbox.prop('disabled', true);

    $.ajax({
        url: '/activarEncargado',
        type: 'POST',
        data: {
            id: id,
            tipo: tipo,
            activo: activo,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (resp) {

            if (resp.ok) {
                TablaAreas.ajax.reload(null, false);
            } else {
                checkbox.prop('checked', !activo);
                alert(resp.msj);
            }
        },
        error: function () {
            checkbox.prop('checked', !activo);
            alert('Error al actualizar el estado');
        },
        complete: function () {
            checkbox.prop('disabled', false);
        }
    });
});



$('#TablaEncargados').on('click', 'button.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = TablaCategorias.row(tr);
    
    console.log('sds')
    var data = {
        api: 3,
        ID_ENCARGADO_AREA: row.data().ID_ENCARGADO_AREA
    };

    eliminarDatoTabla(data, [TablaCategorias], 'areasDelete');
    

});



  


$('#Capturarorganigrama').on('click', function () {
    var organigramaDiv = document.getElementById('myDiagramDiv');

    // Congelar el renderizado del organigrama antes de capturar
    myDiagram.startTransaction("captura");

    // Deshabilitar animaciones para evitar parpadeos
    myDiagram.animationManager.isEnabled = false;

    setTimeout(() => {
        // Obtener los límites del contenido del diagrama (coordenadas relativas al diagrama)
        var bounds = myDiagram.documentBounds;

        // Usar `html2canvas` para capturar el `div` del organigrama
        html2canvas(organigramaDiv, {
            useCORS: true, // Permitir CORS si es necesario
            scale: 2, // Aumenta la escala para mejor calidad
            backgroundColor: null, // Hace que el fondo sea transparente
            scrollX: 0, // Asegura que no haya desplazamiento horizontal
            scrollY: -window.scrollY // Compensa el desplazamiento vertical de la ventana
        }).then(function (canvas) {
            // Crear un nuevo canvas para recortar la imagen
            var croppedCanvas = document.createElement('canvas');
            var croppedContext = croppedCanvas.getContext('2d');

            // Definir dimensiones del canvas recortado según los límites del organigrama
            var width = Math.ceil(bounds.width); // Ancho del organigrama
            var height = Math.ceil(bounds.height); // Altura del organigrama

            // Ajustar las dimensiones del nuevo canvas
            croppedCanvas.width = width * 2; // Escala x2 para mejor calidad
            croppedCanvas.height = height * 2;

            // Copiar la parte visible del canvas al nuevo canvas recortado
            croppedContext.drawImage(canvas,
                (bounds.x - organigramaDiv.getBoundingClientRect().left) * 2, // Ajuste horizontal
                (bounds.y - organigramaDiv.getBoundingClientRect().top) * 2, // Ajuste vertical
                width * 2, height * 2, // Dimensiones del recorte
                0, 0, width * 2, height * 2 // Posición en el nuevo canvas
            );

            // Convertir el nuevo canvas a una imagen en formato PNG
            var imgData = croppedCanvas.toDataURL("image/png");

            // Crear un enlace para descargar la imagen
            var downloadLink = document.createElement('a');
            downloadLink.href = imgData;
            downloadLink.download = 'organigrama.png'; // Nombre del archivo
            document.body.appendChild(downloadLink); // Agregar el enlace al cuerpo
            downloadLink.click(); // Simular el clic para descargar la imagen
            document.body.removeChild(downloadLink); // Eliminar el enlace después de la descarga

            // Restaurar la configuración original después de la captura
            myDiagram.commitTransaction("captura");
        }).catch(function (error) {
            console.error('Error capturando el organigrama:', error);

            // Restaurar la configuración original en caso de error
            myDiagram.commitTransaction("captura");
        });
    }, 100); // Tiempo de espera para asegurar renderizado
});





$(document).ready(function() {
    $('#abrirModalBtn').on('click', function() {
        limpiarFormularioUsuario(); 

        $('#FOTO_ORGANIGRAMA').dropify({
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

        $('#ModalArea').modal('show');
    });

});




function limpiarFormularioUsuario() {
    $('#formArea')[0].reset(); 
    $('#formCategoria')[0].reset(); 

    var drEvent = $('#FOTO_ORGANIGRAMA').dropify().data('dropify');
    drEvent.resetPreview();
    drEvent.clearElement();
}