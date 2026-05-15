//VARIABLES
ID_CATALOGO_VACANTE = 0



const ModalArea = document.getElementById('miModal_vacantes');
ModalArea.addEventListener('hidden.bs.modal', event => {
    ID_CATALOGO_VACANTE = 0;
    document.getElementById('formularioVACANTES').reset();
    document.getElementById('inputs-container').innerHTML = '';
    
    // Resetear el porcentaje a 0
    const totalElement = document.getElementById('totalPorcentajes');
    if (totalElement) {
        totalElement.textContent = 'Total: 0%';
    }

    $('#miModal_vacantes .modal-title').html('Nueva vacante');


});





$("#guardarFormvacantes").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioVACANTES'))

    if (formularioValido) {

    if (ID_CATALOGO_VACANTE == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormvacantes')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_VACANTE: ID_CATALOGO_VACANTE }, 'VacantesSave', 'formularioVACANTES', 'guardarFormvacantes', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_CATALOGO_VACANTE = data.vacante.ID_CATALOGO_VACANTE
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_vacantes').modal('hide')
                    document.getElementById('formularioVACANTES').reset();
                    Tablavacantes.ajax.reload()

                
            })
                    
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormvacantes')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_VACANTE: ID_CATALOGO_VACANTE }, 'VacantesSave', 'formularioVACANTES', 'guardarFormvacantes', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_CATALOGO_VACANTE = data.vacante.ID_CATALOGO_VACANTE
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_vacantes').modal('hide')
                    document.getElementById('formularioVACANTES').reset();
                    Tablavacantes.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
    
});





var Tablavacantes = $("#Tablavacantes").DataTable({
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
        method: 'GET',
        cache: false,
        url: '/Tablavacantes',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablavacantes.columns.adjust().draw();
            ocultarCarga();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
    order: [[0, 'desc']],
    columns: [
        { 
            data: null,
            render: function(data, type, row, meta) {
                return meta.row + 1;
            }
        },
        { data: 'NOMBRE_CATEGORIA' },
        { data: 'LUGAR_VACANTE' },
        { data: 'LA_VACANTES_ES' },
        { data: 'DESCRIPCION_VACANTE', render: function(data, type, row) {
                if (type === 'display' && data.length > 100) {
                    return data.substr(0, 100) + '...'; 
                }
                return data;
            } 
        },
        { data: 'created_at', render: function(data, type, row) {
                return data.split(' ')[0]; 
            } 
        },
        { data: 'FECHA_EXPIRACION', render: function (data, type, row) {
                var diasRestantes = row.DIAS_RESTANTES;
                var expirado = row.EXPIRADO;
                var textColor = expirado ? '#D8000C' : (diasRestantes <= 3 ? '#b8b814' : 'black');
                
                return '<span style="color: ' + textColor + ';">' + data + ' (' + diasRestantes + ' días restantes)</span>';
            }
        },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR'},
        { data: 'BTN_ELIMINAR'},
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Nombre de la categoría', className: 'all text-center' },
        { targets: 2, title: 'Lugar de trabajo', className: 'all text-center' },
        { targets: 3, title: 'Tipo de vacante', className: 'all  text-center' },
        { targets: 4, title: 'Descripción de la vacante', className: 'all text-center ' },
        { targets: 5, title: 'Fecha de publicación', className: 'all  text-center' },
        { targets: 6, title: 'Fecha de expiración', className: 'all  text-center' },
        { targets: 7, title: 'Editar', className: 'all  text-center' },
        { targets: 8, title: 'Visualizar', className: 'all  text-center' },
        { targets: 9, title: 'Activo', className: 'all  text-center' },
    ]
});









$('#Tablavacantes tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablavacantes.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_CATALOGO_VACANTE: row.data().ID_CATALOGO_VACANTE
    };

    eliminarDatoTabla(data, [Tablavacantes], 'VacanteDelete');
});





$('#Tablavacantes tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablavacantes.row(tr);

    ID_CATALOGO_VACANTE = row.data().ID_CATALOGO_VACANTE;
    editarDatoTabla(row.data(), 'formularioVACANTES', 'miModal_vacantes', 1);
    cargarRequerimientos(row.data().REQUERIMIENTO);



	$('#miModal_vacantes .modal-title').html(row.data().NOMBRE_CATEGORIA);

});



$(document).ready(function() {
    $('#Tablavacantes tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablavacantes.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_vacantes');

        ID_CATALOGO_VACANTE = row.data().ID_CATALOGO_VACANTE;
        editarDatoTabla(row.data(), 'formularioVACANTES', 'miModal_vacantes',1);
        cargarRequerimientos(row.data().REQUERIMIENTO);

        $('#miModal_vacantes .modal-title').html(row.data().NOMBRE_CATEGORIA);
        
        $('#botonAgregar').prop('disabled', true);
    });


    
    $('#miModal_vacantes').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_vacantes');
    });
});




function cargarRequerimientos(requerimientos) {
    const contenedor = document.getElementById('inputs-container');
    const botonGuardar = document.getElementById('guardarFormvacantes'); 
    contenedor.innerHTML = ''; 

    requerimientos.forEach(function(requerimiento) {
        const divInput = document.createElement('div');
        divInput.classList.add('form-group', 'row', 'input-container', 'mb-3');
        divInput.innerHTML = `
            <div class="col-8 text-center">
                <label></label>
                <input type="text" name="NOMBRE_REQUERIMINETO[]" class="form-control" value="${requerimiento.NOMBRE_REQUERIMINETO}" placeholder="Escribe los Requerimientos de la vacante aquí">
            </div>
            <div class="col-2 text-center">
                <label>%</label>
                <input type="number" name="PORCENTAJE[]" class="form-control porcentaje-input" value="${requerimiento.PORCENTAJE}" max="100" min="0" step="1" maxlength="3">
            </div>
            <div class="col-2">
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
    const botonAgregar = document.getElementById('botonAgregar');
    const botonGuardar = document.getElementById('guardarFormvacantes'); 

    botonAgregar.addEventListener('click', function(e) {
        e.preventDefault();
        agregarInput();
    });

    function agregarInput() {
        const divInput = document.createElement('div');
        divInput.classList.add('form-group', 'row', 'input-container', 'mb-3');
        divInput.innerHTML = `
            <div class="col-8 text-center">
                <label></label>
                <input type="text" name="NOMBRE_REQUERIMINETO[]" class="form-control" placeholder="Escribe los Requerimientos de la vacante aquí">
            </div>
            <div class="col-2 text-center">
                <label>%</label>
                <input type="number" name="PORCENTAJE[]" class="form-control porcentaje-input" max="100" min="0" step="1" maxlength="3">
            </div>
            <div class="col-2">
                <br>
                <button type="button" class="btn btn-danger botonEliminar"><i class="bi bi-trash3-fill"></i></button>
            </div>
        `;
        const contenedor = document.getElementById('inputs-container');
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

        // Mostrar el total sumado al final
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
    const contenedor = document.getElementById('inputs-container');
    contenedor.parentNode.appendChild(totalContainer);
});




document.addEventListener('DOMContentLoaded', function () {

    const selectRequisicion = document.getElementById('REQUISICION_ID');
    const selectCategoria   = document.getElementById('CATEGORIA_VACANTE');

    selectRequisicion.addEventListener('change', function () {

        const optionSeleccionada = this.options[this.selectedIndex];
        const puestoRP = optionSeleccionada.getAttribute('data-puesto');

        if (puestoRP) {
            selectCategoria.value = puestoRP;
        }

    });

});











