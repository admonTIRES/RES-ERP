//VARIABLES
ID_CATALOGO_CATEGORIA = 0




const ModalArea = document.getElementById('miModal_categoria')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    
    ID_CATALOGO_CATEGORIA = 0
    document.getElementById('formularioCATEGORIAS').reset();
   
    $('#miModal_categoria .modal-title').html('Nueva Categoría');
    document.getElementById('inputs-prueba').innerHTML = '';
    
    const totalElement = document.getElementById('totalPorcentajes');
    if (totalElement) {
        totalElement.textContent = 'Total: 0%';
    }

})






$("#guardarFormcategorias").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioCATEGORIAS'))

    if (formularioValido) {

    if (ID_CATALOGO_CATEGORIA == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormcategorias')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_CATEGORIA: ID_CATALOGO_CATEGORIA }, 'CategoriaSave', 'formularioCATEGORIAS', 'guardarFormcategorias', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_CATALOGO_CATEGORIA = data.categoria.ID_CATALOGO_CATEGORIA
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_categoria').modal('hide')
                    document.getElementById('formularioCATEGORIAS').reset();
                    Tablacategoria.ajax.reload()

           
                
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormcategorias')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_CATEGORIA: ID_CATALOGO_CATEGORIA }, 'CategoriaSave', 'formularioCATEGORIAS', 'guardarFormcategorias', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_CATALOGO_CATEGORIA = data.categoria.ID_CATALOGO_CATEGORIA
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_categoria').modal('hide')
                    document.getElementById('formularioCATEGORIAS').reset();
                    Tablacategoria.ajax.reload()


                }, 300);  
            })
        }, 1)
    }
    } else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});


var Tablacategoria = $("#Tablacategoria").DataTable({
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
        url: '/Tablacategoria',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablacategoria.columns.adjust().draw();
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
        { data: 'NOMBRE_CATEGORIA' },
        { data: 'LUGAR_CATEGORIA' },
        { data: 'PROPOSITO_CATEGORIA' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Nombre', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Lugar de trabajo', className: 'all text-center nombre-column' },
        { targets: 3, title: 'Propósito o finalidad de la categoría', className: 'all text-center' },
        { targets: 4, title: 'Editar', className: 'all text-center' },
        { targets: 5, title: 'Visualizar', className: 'all text-center' },
        { targets: 6, title: 'Activo', className: 'all text-center' }
    ]
});




$('#Tablacategoria tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacategoria.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_CATALOGO_CATEGORIA: row.data().ID_CATALOGO_CATEGORIA
    };

    eliminarDatoTabla(data, [Tablacategoria], 'CategoriaDelete');
});







$('#Tablacategoria tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacategoria.row(tr);
    ID_CATALOGO_CATEGORIA = row.data().ID_CATALOGO_CATEGORIA;

    editarDatoTabla(row.data(), 'formularioCATEGORIAS', 'miModal_categoria', 1);

    $('#miModal_categoria .modal-title').html(row.data().NOMBRE_CATEGORIA);

    cargarRequerimientos(row.data().REQUERIMIENTO);


    $('#miModal_categoria').modal('show');
});



$(document).ready(function() {
    $('#Tablacategoria tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablacategoria.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_categoria');

        ID_CATALOGO_CATEGORIA = row.data().ID_CATALOGO_CATEGORIA;
        editarDatoTabla(row.data(), 'formularioCATEGORIAS', 'miModal_categoria',1);

        $('#miModal_categoria .modal-title').html(row.data().NOMBRE_CATEGORIA);

        $('#botonAgregarprueba').prop('disabled', true);


    cargarRequerimientos(row.data().REQUERIMIENTO);




    });

    $('#miModal_categoria').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_categoria');
    });


});





function cargarRequerimientos(requerimientos) {
    const contenedor = document.getElementById('inputs-prueba');
    const botonGuardar = document.getElementById('guardarFormcategorias'); 
    contenedor.innerHTML = ''; 

    requerimientos.forEach(function(requerimiento) {
        const divInput = document.createElement('div');
        divInput.classList.add('form-group', 'row', 'input-prueba', 'mb-3');

        let opcionesPruebas = '<option value="" disabled selected></option>';
        pruebas.forEach(function(prueba) {
            const selected = prueba.NOMBRE_PRUEBA === requerimiento.TIPO_PRUEBA ? 'selected' : '';
            opcionesPruebas += `<option value="${prueba.NOMBRE_PRUEBA}" ${selected}>${prueba.NOMBRE_PRUEBA}</option>`;
        });



        divInput.innerHTML = `
        <div class="col-5 text-center">
            <label for="tipoPrueba">Nombre de la prueba</label>
            <select name="TIPO_PRUEBA[]" class="form-control">
                ${opcionesPruebas}
            </select>
        </div>
        <div class="col-5 text-center">
            <label for="cantidad">% de la prueba</label>
            <input type="number" name="PORCENTAJE[]" class="form-control porcentaje-input" value="${requerimiento.PORCENTAJE}" max="100" min="0" step="1" maxlength="3">
        </div>
        <div class="col-1">
            <br>
            <button type="button" class="btn btn-danger botonEliminar"><i class="bi bi-trash3-fill"></i></button>
        </div>
    `;
        contenedor.appendChild(divInput);

        const botonEliminar = divInput.querySelector('.botonEliminar');
        botonEliminar.addEventListener('click', function() {
            contenedor.removeChild(divInput);
            validarPorcentajeTotal(); 
        });

        const inputPorcentaje = divInput.querySelector('.porcentaje-input');
        inputPorcentaje.addEventListener('input', function() {
            validarPorcentajeTotal(); 
        });
    });

   
    validarPorcentajeTotal();

    function calcularSumaPorcentajes() {
        const porcentajes = document.querySelectorAll('.porcentaje-input');
        let total = 0;

        porcentajes.forEach(function(input) {
            total += parseInt(input.value) || 0;
        });

        return total;
    }

    function validarPorcentajeTotal() {
        const total = calcularSumaPorcentajes();
        const totalElement = document.getElementById('totalPorcentajes');
        totalElement.textContent = `Total: ${total}%`;

        if (total > 100) {
            alertToast("La suma de los porcentajes no puede exceder el 100%.");
            botonGuardar.disabled = true; 
        } else {
            botonGuardar.disabled = false; 
        }
    }
}















document.addEventListener("DOMContentLoaded", function() {
    const botonAgregar = document.getElementById('botonAgregarprueba');
    const botonGuardar = document.getElementById('guardarFormcategorias'); 

    botonAgregar.addEventListener('click', function(e) {
        e.preventDefault();
        agregarInput();
    });

    function agregarInput() {
        const divInput = document.createElement('div');
        divInput.classList.add('form-group', 'row', 'input-prueba', 'mb-3');

        let opcionesPruebas = '<option value="" disabled selected></option>';
        pruebas.forEach(function(prueba) {
            opcionesPruebas += `<option value="${prueba.NOMBRE_PRUEBA}">${prueba.NOMBRE_PRUEBA}</option>`;
        });

        

        divInput.innerHTML = `
        <div class="col-5 text-center">
            <label for="tipoPrueba">Nombre de la prueba</label>
            <select name="TIPO_PRUEBA[]" class="form-control">
                ${opcionesPruebas}
            </select>
        </div>
        <div class="col-5 text-center">
            <label for="cantidad">% de la prueba</label>
            <input type="number" name="PORCENTAJE[]" class="form-control porcentaje-input" max="100" min="0" step="1" maxlength="3">
        </div>
        <div class="col-1">
            <br>
            <button type="button" class="btn btn-danger botonEliminar"><i class="bi bi-trash3-fill"></i></button>
        </div>
    `;
        const contenedor = document.getElementById('inputs-prueba');
        contenedor.appendChild(divInput);

        const botonEliminar = divInput.querySelector('.botonEliminar');
        botonEliminar.addEventListener('click', function() {
            contenedor.removeChild(divInput);
            validarPorcentajeTotal(); 
        });

        const inputPorcentaje = divInput.querySelector('.porcentaje-input');
        inputPorcentaje.addEventListener('input', function() {
            if (this.value.length > 3) {
                this.value = this.value.slice(0, 3); 
            }
            if (this.value > 100) {
                this.value = 100; 
            }
            validarPorcentajeTotal();
        });

        validarPorcentajeTotal();
    }

    function validarPorcentajeTotal() {
        const porcentajes = document.querySelectorAll('.porcentaje-input');
        let total = 0;

        porcentajes.forEach(function(input) {
            total += parseInt(input.value) || 0;
        });

        const totalElement = document.getElementById('totalPorcentajes');
        totalElement.textContent = `Total: ${total}%`;

        if (total > 100) {
            alertToast("La suma de los porcentajes no puede exceder el 100%.");
            botonGuardar.disabled = true; 
            return false;
        } else if (total === 100) {
            alertToast("La suma de los porcentajes es exactamente 100%.");
            botonGuardar.disabled = false; 
        } else {
            botonGuardar.disabled = true; 
        }
    }

    // Crear el elemento para mostrar el total
    const totalContainer = document.createElement('div');
    totalContainer.classList.add('mt-3');
    totalContainer.style.textAlign = 'center'; 
    totalContainer.innerHTML = `
        <h5 id="totalPorcentajes">Total: 0%</h5>
    `;
    const contenedor = document.getElementById('inputs-prueba');
    contenedor.parentNode.appendChild(totalContainer);
});
