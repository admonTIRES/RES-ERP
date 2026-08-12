//VARIABLES
ID_FORMULARIO_SALIDA_MTTO = 0




const Modalsalidamtto = document.getElementById('miModal_salidamtto');
Modalsalidamtto.addEventListener('hidden.bs.modal', event => {

    ID_FORMULARIO_SALIDA_MTTO = 0;
    document.getElementById('formulariosalidamtto').reset();

    $('#FECHA_ESTIMADA').hide();
    $('#NO_ORDEN').hide();
    $('#NO_TIENE_ORDEN').hide();
    $('#AGREGAR_MATERIAL').hide();
    $('#DIV_FIRMAR').show();

    document.querySelector('.materialesdiv').innerHTML = '';
    contadorMateriales = 1;

    document.getElementById("guardarsalidamtto").disabled = false;

    const inputFecha = document.getElementById("FECHA_SALIDA");
    
    if (inputFecha) {
        inputFecha.classList.remove("is-invalid"); 
    }

    if (typeof Swal !== "undefined") {
        Swal.close();
    }
    
    document.getElementById('FIRMO_USUARIO').value = "0"; 
    document.getElementById('FINALIZAR_SALIDA_ALMACEN').value = "0"; 


});

$("#NUEVA_SALIDAMTTO").click(function (e) {
    e.preventDefault();

       
    $('#formulariosalidamtto').each(function(){
        this.reset();
    });

    $(".materialesdiv").empty();

    
    $('#FECHA_ESTIMADA').hide();
    $('#NO_ORDEN').hide();
    $('#NO_TIENE_ORDEN').hide();
    $('#AGREGAR_MATERIAL').show();
    $('#DIV_FIRMAR').show();


    $("#miModal_salidamtto").modal("show");
   
    const hoy = new Date();
    const yyyy = hoy.getFullYear();
    const mm = String(hoy.getMonth() + 1).padStart(2, '0');
    const dd = String(hoy.getDate()).padStart(2, '0');
    const fechaHoy = `${yyyy}-${mm}-${dd}`;

    $("#FECHA_SALIDA").val(fechaHoy);
   
    document.getElementById("guardarsalidamtto").disabled = true;
    document.getElementById('FINALIZAR_SALIDA_ALMACEN').value = "1"; 

});


document.addEventListener("DOMContentLoaded", function () {
     const btnFirmar = document.getElementById("FIRMAR_SOLICITUD");
    const inputFirmo = document.getElementById("FIRMO_USUARIO");
    const inputFirmadoPor = document.getElementById("FIRMADO_POR");
    const inputFechaSalida = document.getElementById("FECHA_SALIDA");

    btnFirmar.addEventListener("click", function () {
        let usuarioNombre = btnFirmar.getAttribute("data-usuario");
        let fechaSalida = inputFechaSalida.value; 

        if (!fechaSalida) {
            alert("Debe ingresar la fecha antes de firmar la solicitud.");

            inputFechaSalida.classList.add("is-invalid");

            inputFechaSalida.addEventListener("input", function () {
                if (this.value) {
                    this.classList.remove("is-invalid");
                }
            });

            return; 
        }

        let ahora = new Date();
        let horas = ahora.getHours();
        let minutos = String(ahora.getMinutes()).padStart(2, "0");
        let segundos = String(ahora.getSeconds()).padStart(2, "0");

        let ampm = horas >= 12 ? "p.m." : "a.m.";

        horas = horas % 12;
        horas = horas ? horas : 12; 

        let horaCompleta = horas + ":" + minutos + ":" + segundos + " " + ampm;

        inputFirmo.value = "1";
        inputFirmadoPor.value =  usuarioNombre + " el " + fechaSalida + " a las " + horaCompleta;
    });
});


let contadorMateriales = 1; 

document.addEventListener("DOMContentLoaded", function () {

    const botonMaterial = document.getElementById('botonmaterial');
    const contenedorMateriales = document.querySelector('.materialesdiv');
    const fechaEstimadoDiv = document.getElementById("FECHA_ESTIMADA");
    const botonGuardar = document.getElementById("guardarsalidamtto");

    botonMaterial.addEventListener('click', function () {
        agregarMaterial();
    });

    function actualizarFechaEstimada() {
        const selectRetornos = contenedorMateriales.querySelectorAll('.retorna_material');
        let existeMaterialQueRetorna = false;

        selectRetornos.forEach(function (select) {
            if (select.value === "1") {
                existeMaterialQueRetorna = true;
            }
        });

        if (fechaEstimadoDiv) {
            fechaEstimadoDiv.style.display = existeMaterialQueRetorna ? "block" : "none";

            fechaEstimadoDiv.querySelectorAll('input, select, textarea').forEach(function (campo) {
                campo.required = existeMaterialQueRetorna;

                if (!existeMaterialQueRetorna) {
                    campo.value = "";
                }
            });
        }
    }

    function obtenerSelectInventarioDesdeCantidad(inputCantidad) {
        if (inputCantidad.classList.contains('cantidad_salida')) {
            const materialItem = inputCantidad.closest('.material-item');

            if (!materialItem) {
                return null;
            }

            return materialItem.querySelector('.inventario_taller');
        }

        if (inputCantidad.classList.contains('cantidad_detalle')) {
            const articuloItem = inputCantidad.closest('.articulo-item');

            if (!articuloItem) {
                return null;
            }

            return articuloItem.querySelector('.inventario_taller_detalle');
        }

        return null;
    }

    function campoCantidadEstaActivo(inputCantidad) {
        const materialItem = inputCantidad.closest('.material-item');

        if (!materialItem) {
            return false;
        }

        const selectVarios = materialItem.querySelector('.varios_articulos');

        if (!selectVarios) {
            return false;
        }

        if (inputCantidad.classList.contains('cantidad_salida')) {
            return selectVarios.value !== "1";
        }

        if (inputCantidad.classList.contains('cantidad_detalle')) {
            return selectVarios.value === "1";
        }

        return false;
    }

    function obtenerStockInventario(selectInventario) {
        if (!selectInventario || !selectInventario.value) {
            return 0;
        }

        const opcionSeleccionada = selectInventario.options[selectInventario.selectedIndex];

        if (!opcionSeleccionada) {
            return 0;
        }

        return parseFloat(opcionSeleccionada.dataset.stock || 0);
    }

    function obtenerCantidadUtilizada(inventarioId, inputExcluir) {
        let cantidadUtilizada = 0;

        contenedorMateriales.querySelectorAll('.cantidad_salida, .cantidad_detalle').forEach(function (inputCantidad) {
            if (inputCantidad === inputExcluir) {
                return;
            }

            if (!campoCantidadEstaActivo(inputCantidad)) {
                return;
            }

            const selectInventario = obtenerSelectInventarioDesdeCantidad(inputCantidad);

            if (!selectInventario || !selectInventario.value) {
                return;
            }

            if (String(selectInventario.value) === String(inventarioId)) {
                cantidadUtilizada += parseFloat(inputCantidad.value || 0);
            }
        });

        return cantidadUtilizada;
    }

    function validarCantidadAcumulada(inputCantidad, mostrarAlerta) {
        if (!inputCantidad || !campoCantidadEstaActivo(inputCantidad)) {
            return true;
        }

        const selectInventario = obtenerSelectInventarioDesdeCantidad(inputCantidad);

        if (!selectInventario || !selectInventario.value) {
            inputCantidad.removeAttribute('max');
            return true;
        }

        const stock = obtenerStockInventario(selectInventario);
        const cantidadUtilizada = obtenerCantidadUtilizada(selectInventario.value, inputCantidad);
        const cantidadDisponible = Math.max(stock - cantidadUtilizada, 0);
        const cantidadActual = parseFloat(inputCantidad.value || 0);

        inputCantidad.setAttribute('max', cantidadDisponible);

        if (cantidadActual > cantidadDisponible) {
            if (mostrarAlerta !== false) {
                if (cantidadDisponible > 0) {
                    alert(`Solo quedan ${cantidadDisponible} unidades disponibles de este artículo. El stock total es de ${stock} unidades.`);
                } else {
                    alert(`Ya se utilizaron las ${stock} unidades disponibles de este artículo.`);
                }
            }

            inputCantidad.value = cantidadDisponible > 0 ? cantidadDisponible : "";

            return false;
        }

        return true;
    }

    function actualizarLimitesStock() {
        contenedorMateriales.querySelectorAll('.cantidad_salida, .cantidad_detalle').forEach(function (inputCantidad) {
            if (!campoCantidadEstaActivo(inputCantidad)) {
                inputCantidad.removeAttribute('max');
                return;
            }

            const selectInventario = obtenerSelectInventarioDesdeCantidad(inputCantidad);

            if (!selectInventario || !selectInventario.value) {
                inputCantidad.removeAttribute('max');
                return;
            }

            const stock = obtenerStockInventario(selectInventario);
            const cantidadUtilizada = obtenerCantidadUtilizada(selectInventario.value, inputCantidad);
            const cantidadDisponible = Math.max(stock - cantidadUtilizada, 0);

            inputCantidad.setAttribute('max', cantidadDisponible);
        });
    }

    function validarTodosLosInventarios(mostrarAlerta) {
        const cantidadesPorInventario = {};
        const stocksPorInventario = {};
        let formularioCorrecto = true;

        contenedorMateriales.querySelectorAll('.cantidad_salida, .cantidad_detalle').forEach(function (inputCantidad) {
            if (!campoCantidadEstaActivo(inputCantidad)) {
                return;
            }

            const selectInventario = obtenerSelectInventarioDesdeCantidad(inputCantidad);

            if (!selectInventario || !selectInventario.value) {
                return;
            }

            const inventarioId = String(selectInventario.value);
            const cantidad = parseFloat(inputCantidad.value || 0);
            const stock = obtenerStockInventario(selectInventario);

            if (!cantidadesPorInventario[inventarioId]) {
                cantidadesPorInventario[inventarioId] = 0;
            }

            cantidadesPorInventario[inventarioId] += cantidad;
            stocksPorInventario[inventarioId] = stock;
        });

        Object.keys(cantidadesPorInventario).forEach(function (inventarioId) {
            const cantidadTotal = cantidadesPorInventario[inventarioId];
            const stock = stocksPorInventario[inventarioId];

            if (cantidadTotal > stock) {
                formularioCorrecto = false;

                if (mostrarAlerta !== false) {
                    alert(`La cantidad total seleccionada para un artículo es ${cantidadTotal}, pero solamente hay ${stock} unidades disponibles en el inventario del taller.`);
                }
            }
        });

        return formularioCorrecto;
    }

    function agregarMaterial() {
        const divMaterial = document.createElement('div');
        divMaterial.classList.add('row', 'material-item', 'mt-1');

        divMaterial.innerHTML = `
            <div class="col-1 mt-4">
                <label class="form-label">N°</label>
                <input type="text" class="form-control" name="NUMERO_ORDEN" value="${contadorMateriales}" readonly>
            </div>

            <div class="col-4 mt-4">
                <label class="form-label">Descripción</label>
                <input type="text" class="form-control" name="DESCRIPCION" required>
            </div>

            <div class="col-1 mt-4">
                <label class="form-label">Cantidad</label>
                <input type="number" class="form-control cantidad_original" name="CANTIDAD" min="1" required>
            </div>

            <div class="col-3 mt-4">
                <label class="form-label">¿El material o equipo retorna?*</label>
                <select class="form-control retorna_material" name="RETORNA_EQUIPO" required>
                    <option value="" disabled selected>Seleccione una opción</option>
                    <option value="1">Sí</option>
                    <option value="2">No</option>
                </select>
            </div>

            <div class="col-2 mt-4">
                <label class="form-label">Varios artículos</label>
                <select class="form-control varios_articulos" name="VARIOS_ARTICULOS" required>
                    <option value="" disabled selected>Seleccione</option>
                    <option value="0">No</option>
                    <option value="1">Sí</option>
                </select>
            </div>

            <div class="col-1 mt-4">
                <br>
                <button type="button" class="btn btn-danger botonEliminarMaterial" title="Eliminar">
                    <i class="bi bi-trash"></i>
                </button>
            </div>

            <div class="col-2 mt-3 campo_unico">
                <label class="form-label">Tipo inventario</label>
                <select class="form-control tipo_inventario" name="TIPO_INVENTARIO" required>
                    <option value="" disabled selected>Seleccione</option>

                    ${(window.tipoinventario || []).map(tipo => `
                        <option value="${tipo.DESCRIPCION_TIPO}">${tipo.DESCRIPCION_TIPO}</option>
                    `).join('')}
                </select>
            </div>

            <div class="col-5 mt-3 campo_unico">
                <label class="form-label">Inventario del taller</label>
                <select class="form-control inventario_taller select2-inventario-taller" name="INVENTARIO" required>
                    <option value="" disabled selected>Seleccione inventario</option>
                </select>
            </div>

            <div class="col-3 mt-3 campo_unico">
                <label class="form-label">Cantidad salida</label>
                <input type="number" class="form-control cantidad_salida" name="CANTIDAD_SALIDA" min="1" required>
            </div>

            <div class="col-2 mt-3 campo_unico">
                <label class="form-label">U.M.</label>
                <input type="text" class="form-control unidad_salida" name="UNIDAD_SALIDA" readonly required>
            </div>

            <div class="col-12 mt-3 contenedor_articulos" style="display:none;"></div>
        `;

        contenedorMateriales.appendChild(divMaterial);

        contadorMateriales++;

        botonGuardar.disabled = false;

        const botonEliminar = divMaterial.querySelector('.botonEliminarMaterial');
        const selectRetorna = divMaterial.querySelector('.retorna_material');
        const selectVarios = divMaterial.querySelector('.varios_articulos');
        const inputCantidadOriginal = divMaterial.querySelector('.cantidad_original');
        const selectTipo = divMaterial.querySelector('.tipo_inventario');
        const selectInventario = divMaterial.querySelector('.inventario_taller');
        const inputCantidadSalida = divMaterial.querySelector('.cantidad_salida');
        const inputUnidadSalida = divMaterial.querySelector('.unidad_salida');
        const contenedorArticulos = divMaterial.querySelector('.contenedor_articulos');

        function obtenerModalPadreElemento(elemento) {
            const modalBody = $(elemento).closest(".modal-body");

            if (modalBody.length > 0) {
                return modalBody; 
            }

            const modal = $(elemento).closest(".modal");

            if (modal.length > 0) {
                return modal;
            }

            return $("body");
        }

        function obtenerTextoInventario(inventario, tipoSeleccionado) {
            if (tipoSeleccionado === "AF" || tipoSeleccionado === "ANF") {
                return `${inventario.DESCRIPCION_EQUIPO || ''} (${inventario.CODIGO_EQUIPO || ''})`;
            }

            return [
                inventario.DESCRIPCION_EQUIPO,
                inventario.MARCA_EQUIPO,
                inventario.MODELO_EQUIPO,
                inventario.SERIE_EQUIPO
            ].filter(Boolean).join(' | ');
        }

        function cargarInventarioTaller(tipoSeleccionado) {
            const inventarios = Array.isArray(window.inventariomantenimiento)
                ? window.inventariomantenimiento
                : [];

            const opciones = inventarios
                .filter(inventario => inventario.TIPO_EQUIPO === tipoSeleccionado)
                .sort((a, b) => (a.DESCRIPCION_EQUIPO || '').localeCompare(b.DESCRIPCION_EQUIPO || ''))
                .map(inventario => `
                    <option value="${inventario.ID_FORMULARIO_INVENTARIO_MANTENIMIENTO}" data-stock="${inventario.CANTIDAD_EQUIPO || 0}" data-unidad="${inventario.UNIDAD_MEDIDA || ''}">
                        ${obtenerTextoInventario(inventario, tipoSeleccionado)}
                    </option>
                `)
                .join('');

            if ($(selectInventario).hasClass('select2-hidden-accessible')) {
                $(selectInventario).select2('destroy');
            }

            selectInventario.innerHTML = `
                <option value="" disabled selected>Seleccione inventario</option>
                ${opciones}
            `;

            $(selectInventario).select2({
                width: '100%',
                placeholder: 'Seleccione inventario',
                allowClear: true,
                dropdownParent: obtenerModalPadreElemento(selectInventario),
                dropdownPosition: 'below'
            });

            inputCantidadSalida.value = "";
            inputCantidadSalida.removeAttribute('max');
            inputUnidadSalida.value = "";

            actualizarLimitesStock();
        }

        function validarCantidadUnica() {
            const opcionSeleccionada = selectInventario.options[selectInventario.selectedIndex];

            if (!opcionSeleccionada || !opcionSeleccionada.value) {
                inputCantidadSalida.removeAttribute('max');
                inputUnidadSalida.value = "";
                actualizarLimitesStock();
                return;
            }

            inputUnidadSalida.value = opcionSeleccionada.dataset.unidad || "";

            validarCantidadAcumulada(inputCantidadSalida, true);
            actualizarLimitesStock();
        }

        function agregarArticuloDetalle() {
            const divArticulo = document.createElement('div');
            divArticulo.classList.add('row', 'g-2', 'mb-2', 'articulo-item');

            divArticulo.innerHTML = `
                <div class="col-2 mt-3">
                    <label class="form-label">Tipo inventario</label>
                    <select class="form-control tipo_inventario_detalle" name="TIPO_INVENTARIO_DETALLE[]" required>
                        <option value="" disabled selected>Seleccione</option>

                        ${(window.tipoinventario || []).map(tipo => `
                            <option value="${tipo.DESCRIPCION_TIPO}">${tipo.DESCRIPCION_TIPO}</option>
                        `).join('')}
                    </select>
                </div>

                <div class="col-5 mt-3">
                    <label class="form-label">Inventario del taller</label>
                    <select class="form-control inventario_taller_detalle select2-inventario-taller-detalle" name="INVENTARIO_DETALLE[]" required>
                        <option value="" disabled selected>Seleccione inventario</option>
                    </select>
                </div>

                <div class="col-3 mt-3">
                    <label class="form-label">Cantidad salida</label>
                    <input type="number" class="form-control cantidad_detalle" name="CANTIDAD_DETALLE[]" min="1" required>
                </div>

                <div class="col-2 mt-3">
                    <label class="form-label">U.M.</label>
                    <input type="text" class="form-control unidad_detalle" name="UNIDAD_DETALLE[]" readonly required>
                </div>
            `;

            contenedorArticulos.appendChild(divArticulo);

            const selectTipoDetalle = divArticulo.querySelector('.tipo_inventario_detalle');
            const selectInventarioDetalle = divArticulo.querySelector('.inventario_taller_detalle');
            const inputCantidadDetalle = divArticulo.querySelector('.cantidad_detalle');
            const inputUnidadDetalle = divArticulo.querySelector('.unidad_detalle');

            function cargarInventarioTallerDetalle(tipoSeleccionado) {
                const inventarios = Array.isArray(window.inventariomantenimiento)
                    ? window.inventariomantenimiento
                    : [];

                const opciones = inventarios
                    .filter(inventario => inventario.TIPO_EQUIPO === tipoSeleccionado)
                    .sort((a, b) => (a.DESCRIPCION_EQUIPO || '').localeCompare(b.DESCRIPCION_EQUIPO || ''))
                    .map(inventario => `
                        <option value="${inventario.ID_FORMULARIO_INVENTARIO_MANTENIMIENTO}" data-stock="${inventario.CANTIDAD_EQUIPO || 0}" data-unidad="${inventario.UNIDAD_MEDIDA || ''}">
                            ${obtenerTextoInventario(inventario, tipoSeleccionado)}
                        </option>
                    `)
                    .join('');

                if ($(selectInventarioDetalle).hasClass('select2-hidden-accessible')) {
                    $(selectInventarioDetalle).select2('destroy');
                }

                selectInventarioDetalle.innerHTML = `
                    <option value="" disabled selected>Seleccione inventario</option>
                    ${opciones}
                `;

                $(selectInventarioDetalle).select2({
                    width: '100%',
                    placeholder: 'Seleccione inventario',
                    allowClear: true,
                    dropdownParent: obtenerModalPadreElemento(selectInventarioDetalle),
                    dropdownPosition: 'below'
                });

                inputCantidadDetalle.value = "";
                inputCantidadDetalle.removeAttribute('max');
                inputUnidadDetalle.value = "";

                actualizarLimitesStock();
            }

            function validarCantidadDetalle() {
                const opcionSeleccionada = selectInventarioDetalle.options[selectInventarioDetalle.selectedIndex];

                if (!opcionSeleccionada || !opcionSeleccionada.value) {
                    inputCantidadDetalle.removeAttribute('max');
                    inputUnidadDetalle.value = "";
                    actualizarLimitesStock();
                    return;
                }

                inputUnidadDetalle.value = opcionSeleccionada.dataset.unidad || "";

                validarCantidadAcumulada(inputCantidadDetalle, true);
                actualizarLimitesStock();
            }

            selectTipoDetalle.addEventListener('change', function () {
                cargarInventarioTallerDetalle(this.value);
            });

            selectInventarioDetalle.addEventListener('change', validarCantidadDetalle);
            inputCantidadDetalle.addEventListener('input', validarCantidadDetalle);
        }

        function actualizarTipoSalida() {
            if (selectVarios.value === "1") {
                divMaterial.querySelectorAll('.campo_unico').forEach(function (elemento) {
                    elemento.style.display = "none";

                    elemento.querySelectorAll('select, input, textarea').forEach(function (campo) {
                        campo.required = false;
                    });
                });

                contenedorArticulos.style.display = "block";

                if (contenedorArticulos.querySelectorAll('.articulo-item').length === 0) {
                    const numeroArticulos = parseInt(inputCantidadOriginal.value || 1);

                    for (let i = 0; i < numeroArticulos; i++) {
                        agregarArticuloDetalle();
                    }
                }
            } else {
                divMaterial.querySelectorAll('.campo_unico').forEach(function (elemento) {
                    elemento.style.display = "block";

                    elemento.querySelectorAll('select, input, textarea').forEach(function (campo) {
                        campo.required = true;
                    });
                });

                contenedorArticulos.style.display = "none";
                contenedorArticulos.innerHTML = "";
            }

            actualizarLimitesStock();
        }

        botonEliminar.addEventListener('click', function () {
            contenedorMateriales.removeChild(divMaterial);

            actualizarNumerosOrden();
            actualizarFechaEstimada();
            actualizarLimitesStock();

            if (contenedorMateriales.querySelectorAll('.material-item').length === 0) {
                botonGuardar.disabled = true;
            }
        });

        selectTipo.addEventListener('change', function () {
            cargarInventarioTaller(this.value);
        });

        selectInventario.addEventListener('change', validarCantidadUnica);
        inputCantidadSalida.addEventListener('input', validarCantidadUnica);

        selectVarios.addEventListener('change', function () {
            actualizarTipoSalida();
        });

        selectRetorna.addEventListener('change', function () {
            actualizarFechaEstimada();

            if (typeof revisarSelects === "function") {
                revisarSelects();
            }
        });

        actualizarFechaEstimada();
    }

    if (botonGuardar) {
        botonGuardar.addEventListener('click', function (event) {
            if (!validarTodosLosInventarios(true)) {
                event.preventDefault();
                event.stopImmediatePropagation();
                return false;
            }
        }, true);
    }

    actualizarFechaEstimada();
});

 function actualizarNumerosOrden() {
        const materiales = document.querySelectorAll('.material-item');
        let nuevoContador = 1;
        materiales.forEach(material => {
            material.querySelector('input[name="NUMERO_ORDEN"]').value = nuevoContador;
            nuevoContador++;
        });
        contadorMateriales = nuevoContador;
}


function revisarSelects() {
    const selects = document.querySelectorAll('.retorna_material');
    let mostrar = false;
    selects.forEach(sel => {
        if (sel.value === "1") { 
            mostrar = true;
        }
    });
    document.getElementById("FECHA_ESTIMADA").style.display = mostrar ? "block" : "none";
}



$('#TIENE_ORDEN').on('change', function () {

    if ($(this).val() === '1') {
        $('#NO_ORDEN').show();
        $('#NO_TIENE_ORDEN').hide();
        $('#NO_CUENTA_ORDEN').val('');

    } else if ($(this).val() === '2') {
        $('#NO_ORDEN').hide();
        $('#NO_TIENE_ORDEN').show();
        $('#NO_ORDEN_SERVICIO').val('');

    } else {
        $('#NO_ORDEN').hide();
        $('#NO_TIENE_ORDEN').hide();

        $('#NO_ORDEN_SERVICIO').val('');
        $('#NO_CUENTA_ORDEN').val('');
    }
});




$("#guardarsalidamtto").click(function (e) {
    e.preventDefault();

        formularioValido = validarFormulario3($('#formulariosalidamtto'))
    
    if (formularioValido) {

        
        var documentos = [];
       
        $(".material-item").each(function() {
            var documento = {
                'DESCRIPCION': $(this).find("input[name='DESCRIPCION']").val(),
                'CANTIDAD': $(this).find("input[name='CANTIDAD']").val(),
                'RETORNA_EQUIPO': $(this).find("select[name='RETORNA_EQUIPO']").val(),
                'VARIOS_ARTICULOS': $(this).find("select[name='VARIOS_ARTICULOS']").val(),
                'TIPO_INVENTARIO': $(this).find("select[name='TIPO_INVENTARIO']").val(),
                'INVENTARIO': $(this).find("select[name='INVENTARIO']").val(),
                'CANTIDAD_SALIDA': $(this).find("input[name='CANTIDAD_SALIDA']").val(),
                'UNIDAD_SALIDA': $(this).find("input[name='UNIDAD_SALIDA']").val(),

                'ARTICULO_RETORNO': $(this).find("select[name='ARTICULO_RETORNO']").val(),
                'FECHA_RETORNO': $(this).find("input[name='FECHA_RETORNO']").val(),
                'CANTIDAD_RETORNO': $(this).find("input[name='CANTIDAD_RETORNO']").val(),

                'ARTICULOS': [] 
            };

            if (documento.VARIOS_ARTICULOS === "1") {
                $(this).find(".articulo-item").each(function() {
                    var articulo = {
                        'TIPO_INVENTARIO': $(this).find("select[name='TIPO_INVENTARIO_DETALLE[]']").val(),
                        'INVENTARIO': $(this).find("select[name='INVENTARIO_DETALLE[]']").val(),
                        'CANTIDAD_DETALLE': $(this).find("input[name='CANTIDAD_DETALLE[]']").val(),
                        'UNIDAD_DETALLE': $(this).find("input[name='UNIDAD_DETALLE[]']").val(),

                        'RETORNA_DETALLE': $(this).find("select[name='RETORNA_DETALLE[]']").val(),
                        'FECHA_DETALLE': $(this).find("input[name='FECHA_DETALLE[]']").val(),
                        'CANTIDAD_RETORNO_DETALLE': $(this).find("input[name='CANTIDAD_RETORNO_DETALLE[]']").val(),

                    };
                    documento.ARTICULOS.push(articulo);
                });
            }

            documentos.push(documento);
        });
        
        const requestData = {
            api: 1,
            ID_FORMULARIO_SALIDA_MTTO: ID_FORMULARIO_SALIDA_MTTO,
            MATERIALES_JSON: JSON.stringify(documentos)

        };

        if (ID_FORMULARIO_SALIDA_MTTO == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarsalidamtto')
            await ajaxAwaitFormData(requestData,'salidalmacenmttoSave', 'formulariosalidamtto', 'guardarsalidamtto', { callbackAfter: true, callbackBefore: true }, () => {
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {

                    ID_FORMULARIO_SALIDA_MTTO = data.salida.ID_FORMULARIO_SALIDA_MTTO
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_salidamtto').modal('hide')
                    document.getElementById('formulariosalidamtto').reset();
                    location.reload();

            })
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarsalidamtto')
            await ajaxAwaitFormData(requestData,'salidalmacenmttoSave', 'formulariosalidamtto', 'guardarsalidamtto', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    ID_FORMULARIO_SALIDA_MTTO = data.salida.ID_FORMULARIO_SALIDA_MTTO
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_salidamtto').modal('hide')
                    document.getElementById('formulariosalidamtto').reset();
                    location.reload();

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});




var Tablasalidalmacenmtto = $("#Tablasalidalmacenmtto").DataTable({
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
        url: '/Tablasalidalmacenmtto',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablasalidalmacenmtto.columns.adjust().draw();
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
    { data: 'SOLICITANTE_SALIDA' },    
    { data: 'FECHA_SALIDA' },  
    { data: 'OBSERVACIONES_SALIDA' },  
    { data: 'MATERIALES_PENDIENTES', defaultContent: '0' }, 
    { data: 'BTN_EDITAR' },
    { data: 'BTN_VISUALIZAR' },

],

columnDefs: [
    { targets: 0, title: '#', className: 'all text-center' },
    { targets: 1, title: 'Nombre del solicitante', className: 'all text-center' }, 
    { targets: 2, title: 'Fecha de solicitud', className: 'all text-center' },
    { targets: 3, title: 'Motivo', className: 'all text-center descripcion-column' },
    { targets: 4, title: 'Pendientes', className: 'all text-center' },
    { targets: 5, title: 'Editar', className: 'all text-center' },
    { targets: 6, title: 'Visualizar', className: 'all text-center' },

],createdRow: function (row, data, dataIndex) {
    if (data.COLOR_FILA) {
        $(row).addClass(data.COLOR_FILA);
    }
},
 infoCallback: function (settings, start, end, max, total, pre) {
            return `Total de ${total} registros`;
    },

});



let colorSeleccionado = null;

$.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {

    if (settings.nTable.id !== 'Tablasalidalmacenmtto') {
        return true;
    }
    if (!colorSeleccionado) return true;
    let row = Tablasalidalmacenmtto.row(dataIndex).node();
    return $(row).hasClass(colorSeleccionado);
});


$(document).on('click', '.filtro-color', function () {

    let color = $(this).data('color');

    if (colorSeleccionado === color) {
        colorSeleccionado = null;
        $('.filtro-color').removeClass('active');
    } else {
        colorSeleccionado = color;
        $('.filtro-color').removeClass('active');
        $(this).addClass('active');
    }

    Tablasalidalmacenmtto.draw();
});


$('#limpiarFiltro').on('click', function () {
    colorSeleccionado = null;
    $('.filtro-color').removeClass('active');
    Tablasalidalmacenmtto.draw();
});





$('#Tablasalidalmacenmtto tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablasalidalmacenmtto.row(tr);

    ID_FORMULARIO_SALIDA_MTTO = row.data().ID_FORMULARIO_SALIDA_MTTO;

    cargarMaterialesDesdeJSON(row.data().MATERIALES_JSON);

    editarDatoTabla(row.data(), 'formulariosalidamtto', 'miModal_salidamtto', 1);

    $('#AGREGAR_MATERIAL').hide();


     if (row.data().TIENE_ORDEN == 1) { 
        $('#NO_ORDEN').show();
        $('#NO_TIENE_ORDEN').hide();

    } else if (row.data().TIENE_ORDEN == 2) {
        $('#NO_TIENE_ORDEN').show();
        $('#NO_ORDEN').hide();

    } else {
        $('#NO_TIENE_ORDEN').hide();
        $('#NO_ORDEN').hide();
    }

    if (row.data().FIRMO_USUARIO === "1") {
        $('#DIV_FIRMAR').hide();
    } else  {
        $('#DIV_FIRMAR').show();
    } 
        
});




$(document).ready(function() {
    $('#Tablasalidalmacenmtto tbody').on('click', 'td>button.VISUALIZAR', function () {


    var tr = $(this).closest('tr');
    var row = Tablasalidalmacenmtto.row(tr);
    
    hacerSoloLectura(row.data(), '#miModal_salidamtto');

    ID_FORMULARIO_SALIDA_MTTO = row.data().ID_FORMULARIO_SALIDA_MTTO;

    cargarMaterialesDesdeJSON(row.data().MATERIALES_JSON);

    editarDatoTabla(row.data(), 'formulariosalidamtto', 'miModal_salidamtto', 1);

    $('#AGREGAR_MATERIAL').hide();

    if (row.data().TIENE_ORDEN === "1") {
        $('#NO_ORDEN').show();
    } else {
        $('#NO_TIENE_ORDEN').hide();
    }

    if (row.data().FIRMO_USUARIO === "1") {
        $('#DIV_FIRMAR').hide();
    } else  {
        $('#DIV_FIRMAR').show();
    } 
        
        

            
    });

    $('#miModal_salidamtto').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_salidamtto');
    });
});




function cargarMaterialesDesdeJSON(materialesJson) {
    const contenedorMateriales = document.querySelector('.materialesdiv');
    const fechaEstimadaDiv = document.getElementById('FECHA_ESTIMADA');

    contenedorMateriales.innerHTML = '';
    contadorMateriales = 1;

    function revisarSelects() {
        const selects = contenedorMateriales.querySelectorAll('.retorna_material');
        let mostrar = false;

        selects.forEach(function (select) {
            if (String(select.value) === '1') {
                mostrar = true;
            }
        });

        if (fechaEstimadaDiv) {
            fechaEstimadaDiv.style.display = mostrar ? 'block' : 'none';

            fechaEstimadaDiv.querySelectorAll('input, select, textarea').forEach(function (campo) {
                campo.required = mostrar;
            });
        }
    }

    try {
        const materiales = typeof materialesJson === 'string'
            ? JSON.parse(materialesJson)
            : materialesJson;

        if (!Array.isArray(materiales)) {
            console.error('MATERIALES_JSON no contiene un arreglo válido.');
            revisarSelects();
            return;
        }

        materiales.forEach(function (material) {
            const divMaterial = document.createElement('div');

            divMaterial.classList.add('material-item', 'mt-2');

            divMaterial.innerHTML = `
                <div class="row p-3 rounded">
                    <div class="col-1 mt-3">
                        <label class="form-label">N°</label>
                        <input type="text" class="form-control" name="NUMERO_ORDEN" value="${contadorMateriales}" readonly>
                    </div>

                    <div class="col-4 mt-3">
                        <label class="form-label">Descripción</label>
                        <input type="text" class="form-control" name="DESCRIPCION" value="${escapeHtml(material.DESCRIPCION || '')}" readonly required>
                    </div>

                    <div class="col-1 mt-3">
                        <label class="form-label">Cantidad</label>
                        <input type="number" class="form-control cantidad_original" name="CANTIDAD" value="${material.CANTIDAD || ''}" readonly required>
                    </div>

                    <div class="col-3 mt-3">
                        <label class="form-label">¿El material o equipo retorna?*</label>
                        <select class="form-control retorna_material" name="RETORNA_EQUIPO" required style="pointer-events:none; background-color:#e9ecef;" tabindex="-1">
                            <option value="" disabled>Seleccione una opción</option>
                            <option value="1" ${String(material.RETORNA_EQUIPO) === "1" ? "selected" : ""}>Sí</option>
                            <option value="2" ${String(material.RETORNA_EQUIPO) === "2" ? "selected" : ""}>No</option>
                        </select>
                    </div>

                    <div class="col-2 mt-3">
                        <label class="form-label">Varios artículos</label>
                        <select class="form-control varios_articulos" name="VARIOS_ARTICULOS" required style="pointer-events:none; background-color:#e9ecef;" tabindex="-1">
                            <option value="" disabled>Seleccione</option>
                            <option value="0" ${String(material.VARIOS_ARTICULOS) === "0" ? "selected" : ""}>No</option>
                            <option value="1" ${String(material.VARIOS_ARTICULOS) === "1" ? "selected" : ""}>Sí</option>
                        </select>
                    </div>

                    <div class="col-2 mt-3 campo_unico">
                        <label class="form-label">Tipo inventario</label>
                        <select class="form-control tipo_inventario" name="TIPO_INVENTARIO" required style="pointer-events:none; background-color:#e9ecef;" tabindex="-1">
                            <option value="" ${!material.TIPO_INVENTARIO ? "selected" : ""} disabled>Seleccione</option>
                            ${(window.tipoinventario || []).map(function (tipo) {
                                return `<option value="${tipo.DESCRIPCION_TIPO}" ${String(material.TIPO_INVENTARIO || '') === String(tipo.DESCRIPCION_TIPO) ? 'selected' : ''}>${tipo.DESCRIPCION_TIPO}</option>`;
                            }).join('')}
                        </select>
                    </div>

                    <div class="col-5 mt-3 campo_unico">
                        <label class="form-label">Inventario del taller</label>
                        <select class="form-control inventario_taller select2-inventario-taller" name="INVENTARIO" required>
                            <option value="" disabled>Seleccione inventario</option>
                        </select>
                    </div>

                    <div class="col-3 mt-3 campo_unico">
                        <label class="form-label">Cantidad salida</label>
                        <input type="number" class="form-control cantidad_salida" name="CANTIDAD_SALIDA" value="${material.CANTIDAD_SALIDA || ''}" readonly required>
                    </div>

                    <div class="col-2 mt-3 campo_unico">
                        <label class="form-label">U.M.</label>
                        <input type="text" class="form-control unidad_salida" name="UNIDAD_SALIDA" value="${material.UNIDAD_SALIDA || ''}" readonly required>
                    </div>

                    <div class="col-4 mt-3 div_articulo_retorno campo_unico" style="display:none;">
                        <label class="form-label">¿El artículo ya retornó?*</label>
                        <select class="form-control articulo_retorno" name="ARTICULO_RETORNO">
                            <option value="" ${material.ARTICULO_RETORNO === null || material.ARTICULO_RETORNO === undefined || material.ARTICULO_RETORNO === '' ? 'selected' : ''} disabled>Seleccione</option>
                            <option value="1" ${String(material.ARTICULO_RETORNO) === "1" ? "selected" : ""}>Sí</option>
                            <option value="0" ${String(material.ARTICULO_RETORNO) === "0" ? "selected" : ""}>No</option>
                        </select>
                    </div>

                    <div class="col-4 mt-3 div_fecha_retorno" style="display:none;">
                        <label class="form-label">Fecha de retorno*</label>
                        <div class="input-group">
                            <input type="text" class="form-control mydatepicker fecha_retorno" name="FECHA_RETORNO" value="${material.FECHA_RETORNO || ''}" placeholder="aaaa-mm-dd">
                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                        </div>
                    </div>

                    <div class="col-4 mt-3 div_cantidad_retorno" style="display:none;">
                        <label class="form-label">Cantidad que retorna*</label>
                        <input type="number" class="form-control cantidad_retorno" name="CANTIDAD_RETORNO" value="${material.CANTIDAD_RETORNO || ''}" min="1">
                    </div>

                    <div class="col-12 mt-3 contenedor_articulos" style="display:none;"></div>
                </div>
            `;

            contenedorMateriales.appendChild(divMaterial);

            contadorMateriales++;

            const selectVarios = divMaterial.querySelector('.varios_articulos');
            const selectInventario = divMaterial.querySelector('.inventario_taller');
            const inputUnidad = divMaterial.querySelector('.unidad_salida');
            const inputCantidadSalida = divMaterial.querySelector('.cantidad_salida');
            const selectRetorna = divMaterial.querySelector('.retorna_material');
            const divArticuloRetorno = divMaterial.querySelector('.div_articulo_retorno');
            const selectArticuloRetorno = divMaterial.querySelector('.articulo_retorno');
            const divFechaRetorno = divMaterial.querySelector('.div_fecha_retorno');
            const inputFechaRetorno = divMaterial.querySelector('.fecha_retorno');
            const divCantidadRetorno = divMaterial.querySelector('.div_cantidad_retorno');
            const inputCantidadRetorno = divMaterial.querySelector('.cantidad_retorno');
            const contenedorArticulos = divMaterial.querySelector('.contenedor_articulos');

            function obtenerModalPadre(elemento) {
                const modalBody = $(elemento).closest('.modal-body');

                if (modalBody.length > 0) {
                    return modalBody;
                }

                const modal = $(elemento).closest('.modal');

                if (modal.length > 0) {
                    return modal;
                }

                return $('body');
            }

            function obtenerTextoInventario(inventario, tipoSeleccionado) {
                if (tipoSeleccionado === 'AF' || tipoSeleccionado === 'ANF') {
                    return `${inventario.DESCRIPCION_EQUIPO || ''} (${inventario.CODIGO_EQUIPO || ''})`;
                }

                return [
                    inventario.DESCRIPCION_EQUIPO,
                    inventario.MARCA_EQUIPO,
                    inventario.MODELO_EQUIPO,
                    inventario.SERIE_EQUIPO
                ].filter(Boolean).join(' | ');
            }

            function cargarInventarioTaller(tipoSeleccionado, valorGuardado) {
                const inventarios = Array.isArray(window.inventariomantenimiento)
                    ? window.inventariomantenimiento
                    : [];

                const opciones = inventarios
                    .filter(function (inventario) {
                        return String(inventario.TIPO_EQUIPO || '') === String(tipoSeleccionado || '');
                    })
                    .sort(function (a, b) {
                        return (a.DESCRIPCION_EQUIPO || '').localeCompare(b.DESCRIPCION_EQUIPO || '');
                    })
                    .map(function (inventario) {
                        const seleccionado = String(inventario.ID_FORMULARIO_INVENTARIO_MANTENIMIENTO) === String(valorGuardado || '')
                            ? 'selected'
                            : '';

                        return `<option value="${inventario.ID_FORMULARIO_INVENTARIO_MANTENIMIENTO}" data-stock="${inventario.CANTIDAD_EQUIPO || 0}" data-unidad="${inventario.UNIDAD_MEDIDA || ''}" ${seleccionado}>${obtenerTextoInventario(inventario, tipoSeleccionado)}</option>`;
                    })
                    .join('');

                if ($(selectInventario).hasClass('select2-hidden-accessible')) {
                    $(selectInventario).select2('destroy');
                }

                selectInventario.innerHTML = `<option value="" disabled ${!valorGuardado ? 'selected' : ''}>Seleccione inventario</option>${opciones}`;

                $(selectInventario).select2({
                    width: '100%',
                    placeholder: 'Seleccione inventario',
                    allowClear: false,
                    dropdownParent: obtenerModalPadre(selectInventario),
                    dropdownPosition: 'below'
                });

                if (valorGuardado !== null && valorGuardado !== undefined && valorGuardado !== '') {
                    $(selectInventario).val(String(valorGuardado)).trigger('change.select2');
                }

                $(selectInventario).prop('disabled', true);

                const inventarioSeleccionado = inventarios.find(function (inventario) {
                    return String(inventario.ID_FORMULARIO_INVENTARIO_MANTENIMIENTO) === String(valorGuardado || '');
                });

                inputUnidad.value = inventarioSeleccionado
                    ? inventarioSeleccionado.UNIDAD_MEDIDA || material.UNIDAD_SALIDA || ''
                    : material.UNIDAD_SALIDA || '';

                inputCantidadSalida.setAttribute(
                    'max',
                    inventarioSeleccionado
                        ? inventarioSeleccionado.CANTIDAD_EQUIPO || 0
                        : 0
                );
            }

            function actualizarRetornoUnico() {
                const esArticuloUnico = String(selectVarios.value) !== '1';
                const debeRetornar = String(selectRetorna.value) === '1';
                const yaRetorno = String(selectArticuloRetorno.value) === '1';

                divArticuloRetorno.style.display = esArticuloUnico && debeRetornar
                    ? 'block'
                    : 'none';

                selectArticuloRetorno.required = esArticuloUnico && debeRetornar;

                divFechaRetorno.style.display = esArticuloUnico && debeRetornar && yaRetorno
                    ? 'block'
                    : 'none';

                divCantidadRetorno.style.display = esArticuloUnico && debeRetornar && yaRetorno
                    ? 'block'
                    : 'none';

                inputFechaRetorno.required = esArticuloUnico && debeRetornar && yaRetorno;
                inputCantidadRetorno.required = esArticuloUnico && debeRetornar && yaRetorno;

                if (!esArticuloUnico || !debeRetornar) {
                    selectArticuloRetorno.required = false;
                    inputFechaRetorno.required = false;
                    inputCantidadRetorno.required = false;
                }

                if (!yaRetorno) {
                    inputFechaRetorno.required = false;
                    inputCantidadRetorno.required = false;
                }
            }

            function agregarArticuloDetalle(valor) {
                valor = valor || {};

                const divArticulo = document.createElement('div');

                divArticulo.classList.add('row', 'g-2', 'mb-2', 'articulo-item');

                divArticulo.innerHTML = `
                    <div class="col-2 mt-3">
                        <label class="form-label">Tipo inventario</label>
                        <select class="form-control tipo_inventario_detalle" name="TIPO_INVENTARIO_DETALLE[]" required style="pointer-events:none; background-color:#e9ecef;" tabindex="-1">
                            <option value="" ${!valor.TIPO_INVENTARIO ? 'selected' : ''} disabled>Seleccione</option>
                            ${(window.tipoinventario || []).map(function (tipo) {
                                return `<option value="${tipo.DESCRIPCION_TIPO}" ${String(valor.TIPO_INVENTARIO || '') === String(tipo.DESCRIPCION_TIPO) ? 'selected' : ''}>${tipo.DESCRIPCION_TIPO}</option>`;
                            }).join('')}
                        </select>
                    </div>

                    <div class="col-5 mt-3">
                        <label class="form-label">Inventario del taller</label>
                        <select class="form-control inventario_taller_detalle select2-inventario-taller-detalle" name="INVENTARIO_DETALLE[]" required tabindex="-1">
                            <option value="" disabled>Seleccione inventario</option>
                        </select>
                    </div>

                    <div class="col-3 mt-3">
                        <label class="form-label">Cantidad salida</label>
                        <input type="number" class="form-control cantidad_detalle" name="CANTIDAD_DETALLE[]" value="${valor.CANTIDAD_DETALLE || ''}" readonly required>
                    </div>

                    <div class="col-2 mt-3">
                        <label class="form-label">U.M.</label>
                        <input type="text" class="form-control unidad_detalle" name="UNIDAD_DETALLE[]" value="${valor.UNIDAD_DETALLE || ''}" readonly required>
                    </div>

                    <div class="col-4 mt-3 retorna_detalle_wrap" style="display:none;">
                        <label class="form-label">¿El artículo ya retornó?*</label>
                        <select class="form-control retorna_detalle" name="RETORNA_DETALLE[]">
                            <option value="" ${valor.RETORNA_DETALLE === null || valor.RETORNA_DETALLE === undefined || valor.RETORNA_DETALLE === '' ? 'selected' : ''} disabled>Seleccione</option>
                            <option value="1" ${String(valor.RETORNA_DETALLE) === '1' ? 'selected' : ''}>Sí</option>
                            <option value="2" ${String(valor.RETORNA_DETALLE) === '2' || String(valor.RETORNA_DETALLE) === '0' ? 'selected' : ''}>No</option>
                        </select>
                    </div>

                    <div class="col-4 mt-3 fecha_detalle_div" style="display:none;">
                        <label class="form-label">Fecha de retorno*</label>
                        <div class="input-group">
                            <input type="text" class="form-control mydatepicker fecha_detalle" name="FECHA_DETALLE[]" value="${valor.FECHA_DETALLE || ''}" placeholder="aaaa-mm-dd">
                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                        </div>
                    </div>

                    <div class="col-4 mt-3 cantidad_retorno_div" style="display:none;">
                        <label class="form-label">Cantidad que retorna*</label>
                        <input type="number" class="form-control cantidad_retorno_detalle" name="CANTIDAD_RETORNO_DETALLE[]" value="${valor.CANTIDAD_RETORNO_DETALLE || ''}" min="1">
                    </div>
                `;

                contenedorArticulos.appendChild(divArticulo);

                const selectInventarioDetalle = divArticulo.querySelector('.inventario_taller_detalle');
                const inputUnidadDetalle = divArticulo.querySelector('.unidad_detalle');
                const inputCantidadDetalle = divArticulo.querySelector('.cantidad_detalle');
                const divRetornaDetalle = divArticulo.querySelector('.retorna_detalle_wrap');
                const selectRetornaDetalle = divArticulo.querySelector('.retorna_detalle');
                const divFechaDetalle = divArticulo.querySelector('.fecha_detalle_div');
                const inputFechaDetalle = divArticulo.querySelector('.fecha_detalle');
                const divCantidadRetornoDetalle = divArticulo.querySelector('.cantidad_retorno_div');
                const inputCantidadRetornoDetalle = divArticulo.querySelector('.cantidad_retorno_detalle');

                function cargarInventarioDetalle(tipoSeleccionado, valorGuardado) {
                    const inventarios = Array.isArray(window.inventariomantenimiento)
                        ? window.inventariomantenimiento
                        : [];

                    const opciones = inventarios
                        .filter(function (inventario) {
                            return String(inventario.TIPO_EQUIPO || '') === String(tipoSeleccionado || '');
                        })
                        .sort(function (a, b) {
                            return (a.DESCRIPCION_EQUIPO || '').localeCompare(b.DESCRIPCION_EQUIPO || '');
                        })
                        .map(function (inventario) {
                            const seleccionado = String(inventario.ID_FORMULARIO_INVENTARIO_MANTENIMIENTO) === String(valorGuardado || '')
                                ? 'selected'
                                : '';

                            return `<option value="${inventario.ID_FORMULARIO_INVENTARIO_MANTENIMIENTO}" data-stock="${inventario.CANTIDAD_EQUIPO || 0}" data-unidad="${inventario.UNIDAD_MEDIDA || ''}" ${seleccionado}>${obtenerTextoInventario(inventario, tipoSeleccionado)}</option>`;
                        })
                        .join('');

                    if ($(selectInventarioDetalle).hasClass('select2-hidden-accessible')) {
                        $(selectInventarioDetalle).select2('destroy');
                    }

                    selectInventarioDetalle.innerHTML = `<option value="" disabled ${!valorGuardado ? 'selected' : ''}>Seleccione inventario</option>${opciones}`;

                    $(selectInventarioDetalle).select2({
                        width: '100%',
                        placeholder: 'Seleccione inventario',
                        allowClear: false,
                        dropdownParent: obtenerModalPadre(selectInventarioDetalle),
                        dropdownPosition: 'below'
                    });

                    if (valorGuardado !== null && valorGuardado !== undefined && valorGuardado !== '') {
                        $(selectInventarioDetalle).val(String(valorGuardado)).trigger('change.select2');
                    }

                    $(selectInventarioDetalle).prop('disabled', true);

                    const inventarioSeleccionado = inventarios.find(function (inventario) {
                        return String(inventario.ID_FORMULARIO_INVENTARIO_MANTENIMIENTO) === String(valorGuardado || '');
                    });

                    inputUnidadDetalle.value = inventarioSeleccionado
                        ? inventarioSeleccionado.UNIDAD_MEDIDA || valor.UNIDAD_DETALLE || ''
                        : valor.UNIDAD_DETALLE || '';

                    inputCantidadDetalle.setAttribute(
                        'max',
                        inventarioSeleccionado
                            ? inventarioSeleccionado.CANTIDAD_EQUIPO || 0
                            : 0
                    );
                }

                function actualizarRetornoDetalle() {
                    const debeRetornar = String(selectRetorna.value) === '1';
                    const yaRetorno = String(selectRetornaDetalle.value) === '1';

                    divRetornaDetalle.style.display = debeRetornar
                        ? 'block'
                        : 'none';

                    selectRetornaDetalle.required = debeRetornar;

                    divFechaDetalle.style.display = debeRetornar && yaRetorno
                        ? 'block'
                        : 'none';

                    divCantidadRetornoDetalle.style.display = debeRetornar && yaRetorno
                        ? 'block'
                        : 'none';

                    inputFechaDetalle.required = debeRetornar && yaRetorno;
                    inputCantidadRetornoDetalle.required = debeRetornar && yaRetorno;

                    if (!debeRetornar) {
                        selectRetornaDetalle.required = false;
                        inputFechaDetalle.required = false;
                        inputCantidadRetornoDetalle.required = false;
                    }

                    if (!yaRetorno) {
                        inputFechaDetalle.required = false;
                        inputCantidadRetornoDetalle.required = false;
                    }
                }

                selectRetornaDetalle.addEventListener('change', actualizarRetornoDetalle);

                cargarInventarioDetalle(
                    valor.TIPO_INVENTARIO,
                    valor.INVENTARIO
                );

                actualizarRetornoDetalle();

                $(divArticulo).find('.mydatepicker').datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true,
                    todayHighlight: true,
                    language: 'es'
                });
            }

            if (String(material.VARIOS_ARTICULOS) === '1') {
                divMaterial.querySelectorAll('.campo_unico').forEach(function (elemento) {
                    elemento.style.display = 'none';

                    elemento.querySelectorAll('input, select, textarea').forEach(function (campo) {
                        campo.required = false;
                    });
                });

                contenedorArticulos.style.display = 'block';

                if (Array.isArray(material.ARTICULOS)) {
                    material.ARTICULOS.forEach(function (articulo) {
                        agregarArticuloDetalle(articulo);
                    });
                }

            } else {
                divMaterial.querySelectorAll('.campo_unico').forEach(function (elemento) {
                    elemento.style.display = 'block';
                });

                contenedorArticulos.style.display = 'none';

                cargarInventarioTaller(
                    material.TIPO_INVENTARIO,
                    material.INVENTARIO
                );
            }

            selectArticuloRetorno.addEventListener('change', actualizarRetornoUnico);

            selectRetorna.addEventListener('change', function () {
                actualizarRetornoUnico();
                revisarSelects();

                divMaterial.querySelectorAll('.articulo-item').forEach(function (articuloItem) {
                    const selectRetornoDetalle = articuloItem.querySelector('.retorna_detalle');

                    if (selectRetornoDetalle) {
                        selectRetornoDetalle.dispatchEvent(new Event('change'));
                    }
                });
            });

            actualizarRetornoUnico();

            $(divMaterial).find('.mydatepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
                language: 'es'
            });

            revisarSelects();
        });

        revisarSelects();

    } catch (error) {
        console.error('Error al cargar MATERIALES_JSON:', error);
        revisarSelects();
    }
}