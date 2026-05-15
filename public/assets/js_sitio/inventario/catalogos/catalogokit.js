//VARIABLES
ID_CATALOGO_KITS = 0




const ModalArea = document.getElementById('miModal_KIT')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    ID_CATALOGO_KITS = 0
    document.getElementById('formularioKITS').reset();
   
    $('#miModal_KIT .modal-title').html('Nuevo kit');

    $(".contenidokit").empty(); 

})




document.addEventListener("DOMContentLoaded", function() {

    const botonAgregarServicio = document.getElementById('botonagregarcontenido');
    botonAgregarServicio.addEventListener('click', agregarServicio);

    function agregarServicio() {


        const divServicio = document.createElement('div');
        divServicio.classList.add('row', 'generarkits', 'mb-3');

        divServicio.innerHTML = `
        
            <div class="col-9">
                <div class="form-group">
                    <label>Nombre componente *</label>
                    <input type="text"
                           class="form-control"
                           name="NOMBRE_COMPONENTE"
                           required>
                    </select>
                </div>
            </div>

            <div class="col-3">
                <div class="form-group">
                    <label>Cantidad *</label>
                    <input type="number"
                           class="form-control"
                           name="CANTIDAD_COMPONENTE"
                           required>
                </div>
            </div>

            <div class="col-12 mt-2">
                <div class="form-group" style="text-align: center;">
                    <button type="button"
                            class="btn btn-danger botonEliminarKit">
                        <i class="bi bi-trash3-fill"></i>
                    </button>
                </div>
            </div>
        `;

        const contenedor = document.querySelector('.contenidokit');
        contenedor.appendChild(divServicio);

        const botonEliminar = divServicio.querySelector('.botonEliminarKit');
        botonEliminar.addEventListener('click', function() {
            contenedor.removeChild(divServicio);
        });
    }

});


$("#guardarkits").click(function (e) {
    e.preventDefault();


    formularioValido = validarFormulario3($('#formularioKITS'))

    if (formularioValido) {


        var componenteskits = [];
        $(".generarkits ").each(function() {
            var inputcomponentes = {
                'NOMBRE_COMPONENTE': $(this).find("input[name='NOMBRE_COMPONENTE']").val(),
                'CANTIDAD_COMPONENTE': $(this).find("input[name='CANTIDAD_COMPONENTE']").val(),
            };
            componenteskits.push(inputcomponentes);
        });

           
         const requestData = {
            api: 1,
            ID_CATALOGO_KITS: ID_CATALOGO_KITS,
            COMPONENTES_JSON: JSON.stringify(componenteskits),
        };



    if (ID_CATALOGO_KITS == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarkits')
            await ajaxAwaitFormData(requestData, 'KitsSave', 'formularioKITS', 'guardarkits', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                    ID_CATALOGO_KITS = data.kits.ID_CATALOGO_KITS
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_KIT').modal('hide')
                    document.getElementById('formularioKITS').reset();
                    Tablakits.ajax.reload()


            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarkits')
            await ajaxAwaitFormData(requestData, 'KitsSave', 'formularioKITS', 'guardarkits', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_CATALOGO_KITS = data.kits.ID_CATALOGO_KITS
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_KIT').modal('hide')
                    document.getElementById('formularioKITS').reset();
                    Tablakits.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});

var Tablakits = $("#Tablakits").DataTable({
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
        url: '/Tablakits',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablakits.columns.adjust().draw();
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
        { data: 'NOMBRE_KIT' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [ 
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Nombre del kit', className: 'all text-center' },
        { targets: 2, title: 'Editar', className: 'all text-center' },
        { targets: 3, title: 'Visualizar', className: 'all text-center' },
        { targets: 4, title: 'Activo', className: 'all text-center' }
    ]
});


$('#Tablakits tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablakits.row(tr);


    ID_CATALOGO_KITS = row.data().ID_CATALOGO_KITS;

    editarDatoTabla(row.data(), 'formularioKITS', 'miModal_KIT',1);


   $(".contenidokit").empty();
    mostrarcomponenteskits(row);
   

    $('#miModal_KIT .modal-title').html(row.data().NOMBRE_KIT);

});



$(document).ready(function() {
    $('#Tablakits tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablakits.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_KIT');

        ID_CATALOGO_KITS = row.data().ID_CATALOGO_KITS;
        editarDatoTabla(row.data(), 'formularioKITS', 'miModal_KIT',1);

        $('#miModal_KIT .modal-title').html(row.data().NOMBRE_KIT);
        
        $(".contenidokit").empty();
        mostrarcomponenteskits(row);

    });

    $('#miModal_KIT').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_KIT');
    });
});




function mostrarcomponenteskits(row) {

    const contenedor = document.querySelector('.contenidokit');
    contenedor.innerHTML = "";

    let data = row.data().COMPONENTES_JSON;

    if (!data) return;

    try {
        data = JSON.parse(data);
    } catch (e) {
        data = [];
    }

    data.forEach((item) => {

        const fila = document.createElement('div');
        fila.classList.add('row', 'generarkits', 'mb-3');

        const nombrecomponente = item.NOMBRE_COMPONENTE;
        const cantidadcomponente = item.CANTIDAD_COMPONENTE ?? "";

      

        fila.innerHTML = `
           <div class="col-9">
                <div class="form-group">
                      <label>Nombre componente *</label>
                    <input type="text"
                           class="form-control"
                           name="NOMBRE_COMPONENTE"
                           value="${escapeHtml(nombrecomponente)}"
                           required>
                </div>
            </div>

            <div class="col-3">
                <div class="form-group">
                        <label>Cantidad *</label>
                        <input type="number"
                           class="form-control"
                           name="CANTIDAD_COMPONENTE"
                           value="${cantidadcomponente}"
                           required>
                </div>
            </div>

           <div class="col-12 mt-2">
                <div class="form-group" style="text-align: center;">
                    <button type="button"
                            class="btn btn-danger botonEliminarKit">
                        <i class="bi bi-trash3-fill"></i>
                    </button>
                </div>
            </div>
        `;

        contenedor.appendChild(fila);

        // 🗑 Eliminar fila
        fila.querySelector('.botonEliminarKit')
            .addEventListener('click', function () {
                fila.remove();
            });
    });
}



$('#Tablakits tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablakits.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_CATALOGO_KITS: row.data().ID_CATALOGO_KITS
    };

    eliminarDatoTabla(data, [Tablakits], 'KitsDelete');
});

