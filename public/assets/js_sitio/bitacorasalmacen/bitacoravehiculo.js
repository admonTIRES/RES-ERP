ID_BITACORAS_ALMACEN = 0
let ID_FORM_GLOBAL = null;
let ID_INVENTARIO_GLOBAL = null;

const Modalbitacoravehiculo = document.getElementById('miModal_BITACORA');

Modalbitacoravehiculo.addEventListener('hidden.bs.modal', event => {

    ID_BITACORAS_ALMACEN = 0;

    document.getElementById('formularioBITACORA').reset();

    const inputDanios = document.getElementById("DANIOS_UNIDAD_JSON");
    if (inputDanios) {
        inputDanios.value = "";
    }

    if (typeof marcas !== "undefined") {
        marcas = [];
    }

    if (typeof ctx !== "undefined" && typeof img !== "undefined") {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
    }

    if (typeof modo !== "undefined") {
        modo = "x";
        if (typeof setModoActivo === "function") {
            setModoActivo();
        }
    }

    limpiarCombustibleSalida();
    limpiarCombustibleLlegada();


    $("#TABLA_BOTIQUIN_VEHICULOS").hide();
    $("#TABLA_KIT_SEGURIDAD_VEHICULOS").hide();
    $("#DIV_KILOMETRAJE_LLEGADA").hide();
    $("#FIRMA_REGRESO_VEHICULO").hide();
    $("#guardaBITACORA").show();

     
    if (typeof imagenesSeleccionadas !== "undefined") {
        imagenesSeleccionadas = [];
    }

    $('#previewImagenesBitacora').empty();
    $('#contenedorImagenesHidden').empty();

    $('#inputCamara').val('');
    $('#inputGaleria').val('');

    trazosComb = [];
    document.getElementById("COMBUSTIBLE_SALIDA_VEHICULOS").value = "";
    redibujarComb();

});

var Tablabitacoravehiculos = $("#Tablabitacoravehiculos").DataTable({
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
        url: '/Tablabitacoravehiculos',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablabitacoravehiculos.columns.adjust().draw();
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
        { data: 'DESCRIPCION' },
        { data: 'SOLICITANTE_SALIDA' },
        { data: 'CANTIDAD' },
        {
            data: null,
            render: function (data) {
                return `${data.CANTIDAD_SALIDA} (${data.UNIDAD_SALIDA ?? ''})`;
            }
        },
        { data: 'PRODUCTO_NOMBRE' },
        { data: 'MARCA_EQUIPO' },
        { data: 'MODELO_EQUIPO' },
        { data: 'SERIE_EQUIPO' },
        { data: 'CODIGO_EQUIPO' },
        { data: 'FECHA_ALMACEN_SOLICITUD' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all text-center' },
        { targets: 1, title: 'Descripción del vehículo', className: 'all text-center' },
        { targets: 2, title: 'Nombre del solicitante', className: 'all text-center' },
        { targets: 3, title: 'Cantidad solicitada', className: 'all text-center' },
        { targets: 4, title: 'Cantidad entregada', className: 'all text-center' },
        { targets: 5, title: 'Vehículo entregado', className: 'all text-center' },
        { targets: 6, title: 'Marca', className: 'all text-center' },
        { targets: 7, title: 'Modelo', className: 'all text-center' },
        { targets: 8, title: 'No. Serie', className: 'all text-center' },
        { targets: 9, title: 'Código de Identificación', className: 'all text-center' },
        { targets: 10, title: 'Fecha de entrega', className: 'all text-center' },
        { targets: 11, title: 'Editar', className: 'all text-center' },
        { targets: 12, title: 'Visualizar', className: 'all text-center' }
    ],

    createdRow: function (row, data) {
        if (data.ROW_CLASS) {
            $(row).addClass(data.ROW_CLASS);
        }
    }

});

$(document).on('click', '.editarMaterial', function () {

    ID_FORM_GLOBAL = $(this).data('id');
    ID_INVENTARIO_GLOBAL = $(this).data('inventario');


    $.ajax({
        url: '/obtenerMaterialVehiculos',
        method: 'GET',
        data: { id: ID_FORM_GLOBAL, inventario: ID_INVENTARIO_GLOBAL },

        success: function (res) {

            if (!res.success) {
                alert(res.message || "No se pudo obtener el material.");
                return;
            }

                let material = res.material;
            
                let canvas1 = document.getElementById("firmaCanvas");
                let canvas2 = document.getElementById("firmaCanvas2");
                let canvas3 = document.getElementById("firmaCanvas3");
                let canvas4 = document.getElementById("firmaCanvas4");

                let ctx1 = canvas1.getContext("2d");
                let ctx2 = canvas2.getContext("2d");
                let ctx3 = canvas3.getContext("2d");
                let ctx4 = canvas4.getContext("2d");


                canvas1.width = canvas1.width;
                canvas2.width = canvas2.width;
                canvas3.width = canvas3.width;
                canvas4.width = canvas4.width;


                $("#FIRMA_RECIBIDO_POR").val("");
                $("#FIRMA_ENTREGADO_POR").val("");
                $("#FIRMA_VERIFICADO_POR").val("");
                $("#FIRMA_VALIDADO_POR").val("");

          
                $("#SOLICITANTE_SALIDA").val(material.SOLICITANTE_SALIDA);
                $("#FECHA_ALMACEN_SOLICITUD").val(material.FECHA_ALMACEN_SOLICITUD);
                $("#DESCRIPCION").val(material.DESCRIPCION);
                $("#CANTIDAD").val(material.CANTIDAD);
                $("#CANTIDAD_SALIDA").val(material.CANTIDAD_SALIDA);
                $("#UNIDAD_SALIDA").val(material.UNIDAD_SALIDA);
                $("#INVENTARIO").val(material.INVENTARIO);
                $("#OBSERVACIONES_REC").val(material.OBSERVACIONES_REC);
                $("#ENTREGADO_POR").val(material.ENTREGADO_POR);
                $("#VALIDADO_POR").val(material.VALIDADO_POR);


                $.ajax({
                    url: '/obtenerDatosInventarioVehiculo',
                    method: 'GET',
                    data: { inventario: ID_INVENTARIO_GLOBAL },
                    success: function (resp) {

                        if (!resp.success) return;

                        if (!$("#MARCA_VEHICULO").val()) {
                            $("#MARCA_VEHICULO").val(resp.data.MARCA_EQUIPO);
                        }

                        if (!$("#COLOR_VEHICULO").val()) {
                            $("#COLOR_VEHICULO").val(resp.data.COLOR_VEHICULO);
                        }

                        if (!$("#PLACAS_VEHICULO").val()) {
                            $("#PLACAS_VEHICULO").val(resp.data.PLACAS_VEHICULOS);
                        }

                        if (!$("#MODELO_VEHICULO").val()) {
                            $("#MODELO_VEHICULO").val(resp.data.MODELO_EQUIPO);
                        }

                        if (!$("#NOINVENTARIO_VEHICULO").val()) {
                            $("#NOINVENTARIO_VEHICULO").val(resp.data.CODIGO_EQUIPO);
                        }

                        if (!$("#NUMERO_POLIZA").val()) {
                            $("#NUMERO_POLIZA").val(resp.data.NUMERO_POLIZA);
                        }


                         if (!$("#ENTIDAD_POLIZA").val()) {
                            $("#ENTIDAD_POLIZA").val(resp.data.ENTIDAD_POLIZA);
                        }


                        if (!$("#INICIOVIGENCIA_POLIZA").val()) {
                            $("#INICIOVIGENCIA_POLIZA").val(resp.data.INICIOVIGENCIA_POLIZA);
                        }


                        if (!$("#FINVIGENCIA_POLIZA").val()) {
                            $("#FINVIGENCIA_POLIZA").val(resp.data.FINVIGENCIA_POLIZA);
                        }

                        if (!$("#FRENTE_DERECHA").val()) {
                            $("#FRENTE_DERECHA").val(resp.data.FRENTE_DERECHA);
                        }

                        if (!$("#FRENTE_IZQUIERDA").val()) {
                            $("#FRENTE_IZQUIERDA").val(resp.data.FRENTE_IZQUIERDA);
                        }

                        if (!$("#TRASERA_DERECHA").val()) {
                            $("#TRASERA_DERECHA").val(resp.data.TRASERA_DERECHA);
                        }

                        if (!$("#TRASERA_IZQUIERDA").val()) {
                            $("#TRASERA_IZQUIERDA").val(resp.data.TRASERA_IZQUIERDA);
                        }

                    }
                });
                    
            
           
                marcarRadio('TARJETA_CIRCULACION_VEHICULOS', material.TARJETA_CIRCULACION_VEHICULOS);
                $('input[name="OBS_TARJETA_CIRCULACION_VEHICULOS"]').val(material.OBS_TARJETA_CIRCULACION_VEHICULOS || '');
                marcarRadio('TENENCIA_VIGENTE_VEHICULOS', material.TENENCIA_VIGENTE_VEHICULOS);
                $('input[name="OBS_TENENCIA_VIGENTE_VEHICULOS"]').val(material.OBS_TENENCIA_VIGENTE_VEHICULOS || '');
                marcarRadio('POLIZA_SEGURO_VIGENTE_VEHICULOS', material.POLIZA_SEGURO_VIGENTE_VEHICULOS);
                $('input[name="OBS_POLIZA_SEGURO_VIGENTE_VEHICULOS"]').val(material.OBS_POLIZA_SEGURO_VIGENTE_VEHICULOS || '');
                marcarRadio('INSTRUCTIVO_MANUAL_VEHICULOS', material.INSTRUCTIVO_MANUAL_VEHICULOS);
                $('input[name="OBS_INSTRUCTIVO_MANUAL_VEHICULOS"]').val(material.OBS_INSTRUCTIVO_MANUAL_VEHICULOS || '');
                marcarRadio('ENCENDIDO_MOTOR_VEHICULOS', material.ENCENDIDO_MOTOR_VEHICULOS);
                marcarRadio('ACCESORIOS_CAMBIO_LLANTA_VEHICULOS', material.ACCESORIOS_CAMBIO_LLANTA_VEHICULOS);
                marcarRadio('NIVEL_ACEITE_VEHICULOS', material.NIVEL_ACEITE_VEHICULOS);
                marcarRadio('REFLEJANTES_SEGURIDAD_VEHICULOS', material.REFLEJANTES_SEGURIDAD_VEHICULOS);
                marcarRadio('FRENOS_VEHICULOS', material.FRENOS_VEHICULOS);
                marcarRadio('CABLE_PASA_CORRIENTE_VEHICULOS', material.CABLE_PASA_CORRIENTE_VEHICULOS);
                marcarRadio('SISTEMA_ELECTRICO_VEHICULOS', material.SISTEMA_ELECTRICO_VEHICULOS);
                marcarRadio('GEL_ANTIBACTERIAL_VEHICULOS', material.GEL_ANTIBACTERIAL_VEHICULOS);
                marcarRadio('FAROS_VEHICULOS', material.FAROS_VEHICULOS);
                marcarRadio('ESPEJOS_VEHICULOS', material.ESPEJOS_VEHICULOS);
                marcarRadio('INTERMITENTES_VEHICULOS', material.INTERMITENTES_VEHICULOS);
                marcarRadio('CRISTALES_VENTANAS_VEHICULOS', material.CRISTALES_VENTANAS_VEHICULOS);
                marcarRadio('FUNCIONAMIENTO_LIMPIADORES_VEHICULOS', material.FUNCIONAMIENTO_LIMPIADORES_VEHICULOS);
                marcarRadio('MANCHAS_VESTIDURAS_VEHICULOS', material.MANCHAS_VESTIDURAS_VEHICULOS);
                marcarRadio('AGUA_LIMPIADORES_VEHICULOS', material.AGUA_LIMPIADORES_VEHICULOS);
                marcarRadio('ASIENTOS_VEHICULOS', material.ASIENTOS_VEHICULOS);
                marcarRadio('MOLDURAS_DELANTERAS_VEHICULOS', material.MOLDURAS_DELANTERAS_VEHICULOS);
                marcarRadio('CINTURONES_SEGURIDAD_VEHICULOS', material.CINTURONES_SEGURIDAD_VEHICULOS);
                marcarRadio('MOLDURAS_TRASERAS_VEHICULOS', material.MOLDURAS_TRASERAS_VEHICULOS);
                marcarRadio('CALCOMANIAS_LOGO_VEHICULOS', material.CALCOMANIAS_LOGO_VEHICULOS);
                marcarRadio('LLANTAS_VEHICULOS', material.LLANTAS_VEHICULOS);
                marcarRadio('PASE_VEHICULAR_VEHICULOS', material.PASE_VEHICULAR_VEHICULOS);
                marcarRadio('LLANTA_REFACCION_VEHICULOS', material.LLANTA_REFACCION_VEHICULOS);
                marcarRadio('BRILLO_SEGURIDAD_VEHICULOS', material.BRILLO_SEGURIDAD_VEHICULOS);
                marcarRadio('FRENTE_DERECHA_RADIO', material.FRENTE_DERECHA_RADIO);
                marcarRadio('FRENTE_IZQUIERDA_RADIO', material.FRENTE_IZQUIERDA_RADIO);
                marcarRadio('TRASERA_DERECHA_RADIO', material.TRASERA_DERECHA_RADIO);
                marcarRadio('TRASERA_IZQUIERDA_RADIO', material.TRASERA_IZQUIERDA_RADIO);
            
            
            /* ===============================
               YA GUARDADO
            =============================== */
            if (material.YA_GUARDADO) {

                cargarImagenesGuardadas(ID_FORM_GLOBAL,ID_INVENTARIO_GLOBAL);
                
                $("#ID_BITACORAS_ALMACEN").val(material.ID_BITACORAS_ALMACEN);
                $("#RECIBIDO_POR").val(material.RECIBIDO_POR);
                $("#OBSERVACIONES_BITACORA").val(material.OBSERVACIONES_BITACORA);
                $("#SEGUIMIENTO_VEHICULOS").val(material.SEGUIMIENTO_VEHICULOS);
                $("#INSPECCION_USUARIO_VEHICULOS").val(material.INSPECCION_USUARIO_VEHICULOS);
                $("#MARCA_VEHICULO").val(material.MARCA_VEHICULO);
                $("#MANTENIMIENTO_VEHICULO").val(material.MANTENIMIENTO_VEHICULO);
                $("#MODELO_VEHICULO").val(material.MODELO_VEHICULO);
                $("#COLOR_VEHICULO").val(material.COLOR_VEHICULO);
                $("#PLACAS_VEHICULO").val(material.PLACAS_VEHICULO);
                $("#NOINVENTARIO_VEHICULO").val(material.NOINVENTARIO_VEHICULO);
                $("#NUMERO_POLIZA").val(material.NUMERO_POLIZA);
                $("#ENTIDAD_POLIZA").val(material.ENTIDAD_POLIZA);
                $("#INICIOVIGENCIA_POLIZA").val(material.INICIOVIGENCIA_POLIZA);
                $("#FINVIGENCIA_POLIZA").val(material.FINVIGENCIA_POLIZA);
                $("#NOLICENCIA_VEHICULO").val(material.NOLICENCIA_VEHICULO);
                $("#FECHAVENCIMIENTO_VEHICULO").val(material.FECHAVENCIMIENTO_VEHICULO);
                $("#KILOMETRAJE_SALIDA_VEHICULOS").val(material.KILOMETRAJE_SALIDA_VEHICULOS);
                $("#NOPERSONAS_VEHICULOS").val(material.NOPERSONAS_VEHICULOS);
                $("#HORASALIDA_VEHICULOS").val(material.HORASALIDA_VEHICULOS);
                $("#BOTIQUIN_PRIMEROS_AUXILIOS_VEHICULOS").val(material.BOTIQUIN_PRIMEROS_AUXILIOS_VEHICULOS);
                $("#KIT_SEGURIDAD_VEHICULOS").val(material.KIT_SEGURIDAD_VEHICULOS);
                $("#KILOMETRAJE_LLEGADA_VEHICULOS").val(material.KILOMETRAJE_LLEGADA_VEHICULOS);
                $("#HORAREGRESO_VEHICULOS").val(material.HORAREGRESO_VEHICULOS);
                $("#VERIFICA_POR").val(material.VERIFICA_POR);
                $("#VALIDADO_POR").val(material.VALIDADO_POR);
                $("#RETORNO_VEHICULOS").val(material.RETORNO_VEHICULOS);
                $("#OBS_MALETIN_VEHICULOS").val(material.OBS_MALETIN_VEHICULOS);
                $("#OBS_FERULA_VEHICULOS").val(material.OBS_FERULA_VEHICULOS);
                $("#OBS_FACE_SHIELD_VEHICULOS").val(material.OBS_FACE_SHIELD_VEHICULOS);
                $("#OBS_TIJERAS_VEHICULOS").val(material.OBS_TIJERAS_VEHICULOS);
                $("#OBS_GASAS_10_VEHICULOS").val(material.OBS_GASAS_10_VEHICULOS);
                $("#OBS_GASAS_5_VEHICULOS").val(material.OBS_GASAS_5_VEHICULOS);
                $("#OBS_GUANTES_VEHICULOS").val(material.OBS_GUANTES_VEHICULOS);
                $("#OBS_MICROPORE_1_VEHICULOS").val(material.OBS_MICROPORE_1_VEHICULOS);
                $("#OBS_MICROPORE_2_VEHICULOS").val(material.OBS_MICROPORE_2_VEHICULOS);
                $("#OBS_VENDA_5_VEHICULOS").val(material.OBS_VENDA_5_VEHICULOS);
                $("#OBS_VENDA_10_VEHICULOS").val(material.OBS_VENDA_10_VEHICULOS);
                $("#OBS_SOLUCION_SALINA_VEHICULOS").val(material.OBS_SOLUCION_SALINA_VEHICULOS);
                $("#OBS_VENDA_TRIANGULAR_VEHICULOS").val(material.OBS_VENDA_TRIANGULAR_VEHICULOS);
                $("#OBS_MALETIN_HERRAMIENTAS_VEHICULOS").val(material.OBS_MALETIN_HERRAMIENTAS_VEHICULOS);
                $("#OBS_DESARMADOR_CRUZ_VEHICULOS").val(material.OBS_DESARMADOR_CRUZ_VEHICULOS);
                $("#OBS_DESARMADOR_PLANO_VEHICULOS").val(material.OBS_DESARMADOR_PLANO_VEHICULOS);
                $("#OBS_PINZAS_MULTIUSOS_VEHICULOS").val(material.OBS_PINZAS_MULTIUSOS_VEHICULOS);
                $("#OBS_CUERDAS_BUNGEE_VEHICULOS").val(material.OBS_CUERDAS_BUNGEE_VEHICULOS);
                $("#OBS_LONA_POLIETILENO_VEHICULOS").val(material.OBS_LONA_POLIETILENO_VEHICULOS);
                $("#OBS_GUANTES_NEOPRENO_VEHICULOS").val(material.OBS_GUANTES_NEOPRENO_VEHICULOS);
                $("#OBS_CALIBRADOR_LLANTAS_VEHICULOS").val(material.OBS_CALIBRADOR_LLANTAS_VEHICULOS);
                $("#OBS_EXTINTOR_PQS_VEHICULOS").val(material.OBS_EXTINTOR_PQS_VEHICULOS);
                $("#OBS_LINTERNA_RECARGABLE_VEHICULOS").val(material.OBS_LINTERNA_RECARGABLE_VEHICULOS);


                $("#FRENTE_DERECHA").val(material.FRENTE_DERECHA);
                $("#FRENTE_IZQUIERDA").val(material.FRENTE_IZQUIERDA);
                $("#TRASERA_DERECHA").val(material.TRASERA_DERECHA);
                $("#TRASERA_IZQUIERDA").val(material.TRASERA_IZQUIERDA);


                if (material.BOTIQUIN_PRIMEROS_AUXILIOS_VEHICULOS === '1') {
                    $('#TABLA_BOTIQUIN_VEHICULOS').show();
                } else {
                    $('#TABLA_BOTIQUIN_VEHICULOS').hide();
                }

                if (material.KIT_SEGURIDAD_VEHICULOS === '1') {
                    $('#TABLA_KIT_SEGURIDAD_VEHICULOS').show();
                } else {
                    $('#TABLA_KIT_SEGURIDAD_VEHICULOS').hide();
                }

                if (material.RETORNO_VEHICULOS === '1') {
                    $('#DIV_KILOMETRAJE_LLEGADA').show();
                    $('#FIRMA_REGRESO_VEHICULO').show();
                } else {
                    $('#DIV_KILOMETRAJE_LLEGADA').hide();
                    $('#FIRMA_REGRESO_VEHICULO').hide();
                }

                if (material.FIRMA_RECIBIDO_POR) {
                    let img1 = new Image();
                    img1.onload = function () {
                        ctx1.drawImage(img1, 0, 0, canvas1.width, canvas1.height);
                    };
                    img1.src = material.FIRMA_RECIBIDO_POR;
                    $("#FIRMA_RECIBIDO_POR").val(material.FIRMA_RECIBIDO_POR);
                }

                if (material.FIRMA_ENTREGADO_POR) {
                    let img2 = new Image();
                    img2.onload = function () {
                        ctx2.drawImage(img2, 0, 0, canvas2.width, canvas2.height);
                    };
                    img2.src = material.FIRMA_ENTREGADO_POR;
                    $("#FIRMA_ENTREGADO_POR").val(material.FIRMA_ENTREGADO_POR);
                }

                if (material.FIRMA_VERIFICADO_POR) {
                    let img3 = new Image();
                    img3.onload = function () {
                        ctx3.drawImage(img3, 0, 0, canvas3.width, canvas3.height);
                    };
                    img3.src = material.FIRMA_VERIFICADO_POR;
                    $("#FIRMA_VERIFICADO_POR").val(material.FIRMA_VERIFICADO_POR);
                }

                if (material.FIRMA_VALIDADO_POR) {
                    let img4 = new Image();
                    img4.onload = function () {
                        ctx4.drawImage(img4, 0, 0, canvas4.width, canvas4.height);
                    };
                    img4.src = material.FIRMA_VALIDADO_POR;
                    $("#FIRMA_VALIDADO_POR").val(material.FIRMA_VALIDADO_POR);
                }

                $("#DANIOS_UNIDAD_JSON").val(material.DANIOS_UNIDAD_JSON || "");
                cargarDaniosEnCanvas(material.DANIOS_UNIDAD_JSON);

                $("#COMBUSTIBLE_SALIDA_VEHICULOS").val(material.COMBUSTIBLE_SALIDA_VEHICULOS || "");
                if (material.COMBUSTIBLE_SALIDA_VEHICULOS) {
                    cargarCombustibleSalida(material.COMBUSTIBLE_SALIDA_VEHICULOS);
                }

                $("#COMBUSTIBLE_LLEGADA_VEHICULOS").val(material.COMBUSTIBLE_LLEGADA_VEHICULOS || "");
                if (material.COMBUSTIBLE_LLEGADA_VEHICULOS) {
                    cargarCombustibleLlegada(material.COMBUSTIBLE_LLEGADA_VEHICULOS);
                }

            
            } else {
                $("#ID_BITACORAS_ALMACEN").val(0);
                $("#RECIBIDO_POR").val("");
                $("#OBSERVACIONES_BITACORA").val("");
            }

            // $("#miModal_BITACORA").modal("show");

            const modalElement = document.getElementById('miModal_BITACORA');

            const modalBitacora = new bootstrap.Modal(modalElement, {
                backdrop: 'static', 
                keyboard: false    
            });

            modalBitacora.show();
            
            $('#miModal_BITACORA .modal-title').html(material.DESCRIPCION);
        },

        error: function () {
            alert("Error al obtener el material individual.");
        }
    });
});

$(document).on('click', '.visualizarMaterial', function () {

    ID_FORM_GLOBAL = $(this).data('id');
    ID_INVENTARIO_GLOBAL = $(this).data('inventario');

    $.ajax({
        url: '/obtenerMaterialVehiculos',
        method: 'GET',
        data: { id: ID_FORM_GLOBAL, inventario: ID_INVENTARIO_GLOBAL },

        success: function (res) {

            if (!res.success) {
                alert(res.message || "No se pudo obtener el material.");
                return;
            }

                $("#guardaBITACORA").hide();

                let material = res.material;
            
                let canvas1 = document.getElementById("firmaCanvas");
                let canvas2 = document.getElementById("firmaCanvas2");
                let canvas3 = document.getElementById("firmaCanvas3");
                let canvas4 = document.getElementById("firmaCanvas4");

                let ctx1 = canvas1.getContext("2d");
                let ctx2 = canvas2.getContext("2d");
                let ctx3 = canvas3.getContext("2d");
                let ctx4 = canvas4.getContext("2d");


                canvas1.width = canvas1.width;
                canvas2.width = canvas2.width;
                canvas3.width = canvas3.width;
                canvas4.width = canvas4.width;


                $("#FIRMA_RECIBIDO_POR").val("");
                $("#FIRMA_ENTREGADO_POR").val("");
                $("#FIRMA_VERIFICADO_POR").val("");
                $("#FIRMA_VALIDADO_POR").val("");

          
                $("#SOLICITANTE_SALIDA").val(material.SOLICITANTE_SALIDA);
                $("#FECHA_ALMACEN_SOLICITUD").val(material.FECHA_ALMACEN_SOLICITUD);
                $("#DESCRIPCION").val(material.DESCRIPCION);
                $("#CANTIDAD").val(material.CANTIDAD);
                $("#CANTIDAD_SALIDA").val(material.CANTIDAD_SALIDA);
                $("#UNIDAD_SALIDA").val(material.UNIDAD_SALIDA);
                $("#INVENTARIO").val(material.INVENTARIO);
                $("#OBSERVACIONES_REC").val(material.OBSERVACIONES_REC);
                $("#ENTREGADO_POR").val(material.ENTREGADO_POR);
                $("#VALIDADO_POR").val(material.VALIDADO_POR);


                $.ajax({
                    url: '/obtenerDatosInventarioVehiculo',
                    method: 'GET',
                    data: { inventario: ID_INVENTARIO_GLOBAL },
                    success: function (resp) {

                        if (!resp.success) return;

                        if (!$("#MARCA_VEHICULO").val()) {
                            $("#MARCA_VEHICULO").val(resp.data.MARCA_EQUIPO);
                        }

                        if (!$("#COLOR_VEHICULO").val()) {
                            $("#COLOR_VEHICULO").val(resp.data.COLOR_VEHICULO);
                        }

                        if (!$("#PLACAS_VEHICULO").val()) {
                            $("#PLACAS_VEHICULO").val(resp.data.PLACAS_VEHICULOS);
                        }

                        if (!$("#MODELO_VEHICULO").val()) {
                            $("#MODELO_VEHICULO").val(resp.data.MODELO_EQUIPO);
                        }

                        if (!$("#NOINVENTARIO_VEHICULO").val()) {
                            $("#NOINVENTARIO_VEHICULO").val(resp.data.CODIGO_EQUIPO);
                        }

                        if (!$("#NUMERO_POLIZA").val()) {
                            $("#NUMERO_POLIZA").val(resp.data.NUMERO_POLIZA);
                        }

                        if (!$("#ENTIDAD_POLIZA").val()) {
                            $("#ENTIDAD_POLIZA").val(resp.data.ENTIDAD_POLIZA);
                        }

                        if (!$("#INICIOVIGENCIA_POLIZA").val()) {
                            $("#INICIOVIGENCIA_POLIZA").val(resp.data.INICIOVIGENCIA_POLIZA);
                        }

                        if (!$("#FINVIGENCIA_POLIZA").val()) {
                            $("#FINVIGENCIA_POLIZA").val(resp.data.FINVIGENCIA_POLIZA);
                        }

                        if (!$("#FRENTE_DERECHA").val()) {
                            $("#FRENTE_DERECHA").val(resp.data.FRENTE_DERECHA);
                        }

                        if (!$("#FRENTE_IZQUIERDA").val()) {
                            $("#FRENTE_IZQUIERDA").val(resp.data.FRENTE_IZQUIERDA);
                        }

                        if (!$("#TRASERA_DERECHA").val()) {
                            $("#TRASERA_DERECHA").val(resp.data.TRASERA_DERECHA);
                        }

                        if (!$("#TRASERA_IZQUIERDA").val()) {
                            $("#TRASERA_IZQUIERDA").val(resp.data.TRASERA_IZQUIERDA);
                        }
                    }
                });
                    
                marcarRadio('TARJETA_CIRCULACION_VEHICULOS', material.TARJETA_CIRCULACION_VEHICULOS);
                $('input[name="OBS_TARJETA_CIRCULACION_VEHICULOS"]').val(material.OBS_TARJETA_CIRCULACION_VEHICULOS || '');
                marcarRadio('TENENCIA_VIGENTE_VEHICULOS', material.TENENCIA_VIGENTE_VEHICULOS);
                $('input[name="OBS_TENENCIA_VIGENTE_VEHICULOS"]').val(material.OBS_TENENCIA_VIGENTE_VEHICULOS || '');
                marcarRadio('POLIZA_SEGURO_VIGENTE_VEHICULOS', material.POLIZA_SEGURO_VIGENTE_VEHICULOS);
                $('input[name="OBS_POLIZA_SEGURO_VIGENTE_VEHICULOS"]').val(material.OBS_POLIZA_SEGURO_VIGENTE_VEHICULOS || '');
                marcarRadio('INSTRUCTIVO_MANUAL_VEHICULOS', material.INSTRUCTIVO_MANUAL_VEHICULOS);
                $('input[name="OBS_INSTRUCTIVO_MANUAL_VEHICULOS"]').val(material.OBS_INSTRUCTIVO_MANUAL_VEHICULOS || '');
                marcarRadio('ENCENDIDO_MOTOR_VEHICULOS', material.ENCENDIDO_MOTOR_VEHICULOS);
                marcarRadio('ACCESORIOS_CAMBIO_LLANTA_VEHICULOS', material.ACCESORIOS_CAMBIO_LLANTA_VEHICULOS);
                marcarRadio('NIVEL_ACEITE_VEHICULOS', material.NIVEL_ACEITE_VEHICULOS);
                marcarRadio('REFLEJANTES_SEGURIDAD_VEHICULOS', material.REFLEJANTES_SEGURIDAD_VEHICULOS);
                marcarRadio('FRENOS_VEHICULOS', material.FRENOS_VEHICULOS);
                marcarRadio('CABLE_PASA_CORRIENTE_VEHICULOS', material.CABLE_PASA_CORRIENTE_VEHICULOS);
                marcarRadio('SISTEMA_ELECTRICO_VEHICULOS', material.SISTEMA_ELECTRICO_VEHICULOS);
                marcarRadio('GEL_ANTIBACTERIAL_VEHICULOS', material.GEL_ANTIBACTERIAL_VEHICULOS);
                marcarRadio('FAROS_VEHICULOS', material.FAROS_VEHICULOS);
                marcarRadio('ESPEJOS_VEHICULOS', material.ESPEJOS_VEHICULOS);
                marcarRadio('INTERMITENTES_VEHICULOS', material.INTERMITENTES_VEHICULOS);
                marcarRadio('CRISTALES_VENTANAS_VEHICULOS', material.CRISTALES_VENTANAS_VEHICULOS);
                marcarRadio('FUNCIONAMIENTO_LIMPIADORES_VEHICULOS', material.FUNCIONAMIENTO_LIMPIADORES_VEHICULOS);
                marcarRadio('MANCHAS_VESTIDURAS_VEHICULOS', material.MANCHAS_VESTIDURAS_VEHICULOS);
                marcarRadio('AGUA_LIMPIADORES_VEHICULOS', material.AGUA_LIMPIADORES_VEHICULOS);
                marcarRadio('ASIENTOS_VEHICULOS', material.ASIENTOS_VEHICULOS);
                marcarRadio('MOLDURAS_DELANTERAS_VEHICULOS', material.MOLDURAS_DELANTERAS_VEHICULOS);
                marcarRadio('CINTURONES_SEGURIDAD_VEHICULOS', material.CINTURONES_SEGURIDAD_VEHICULOS);
                marcarRadio('MOLDURAS_TRASERAS_VEHICULOS', material.MOLDURAS_TRASERAS_VEHICULOS);
                marcarRadio('CALCOMANIAS_LOGO_VEHICULOS', material.CALCOMANIAS_LOGO_VEHICULOS);
                marcarRadio('LLANTAS_VEHICULOS', material.LLANTAS_VEHICULOS);
                marcarRadio('PASE_VEHICULAR_VEHICULOS', material.PASE_VEHICULAR_VEHICULOS);
                marcarRadio('LLANTA_REFACCION_VEHICULOS', material.LLANTA_REFACCION_VEHICULOS);
                marcarRadio('BRILLO_SEGURIDAD_VEHICULOS', material.BRILLO_SEGURIDAD_VEHICULOS);

                marcarRadio('FRENTE_DERECHA_RADIO', material.FRENTE_DERECHA_RADIO);
                marcarRadio('FRENTE_IZQUIERDA_RADIO', material.FRENTE_IZQUIERDA_RADIO);
                marcarRadio('TRASERA_DERECHA_RADIO', material.TRASERA_DERECHA_RADIO);
                marcarRadio('TRASERA_IZQUIERDA_RADIO', material.TRASERA_IZQUIERDA_RADIO);
            
            
            /* ===============================
               YA GUARDADO
            =============================== */
            if (material.YA_GUARDADO) {


                cargarImagenesGuardadasVisualizar(ID_FORM_GLOBAL,ID_INVENTARIO_GLOBAL);

                
                $("#ID_BITACORAS_ALMACEN").val(material.ID_BITACORAS_ALMACEN);
                $("#RECIBIDO_POR").val(material.RECIBIDO_POR);
                $("#OBSERVACIONES_BITACORA").val(material.OBSERVACIONES_BITACORA);
                $("#SEGUIMIENTO_VEHICULOS").val(material.SEGUIMIENTO_VEHICULOS);
                $("#INSPECCION_USUARIO_VEHICULOS").val(material.INSPECCION_USUARIO_VEHICULOS);
                $("#MARCA_VEHICULO").val(material.MARCA_VEHICULO);
                $("#MANTENIMIENTO_VEHICULO").val(material.MANTENIMIENTO_VEHICULO);
                $("#MODELO_VEHICULO").val(material.MODELO_VEHICULO);
                $("#COLOR_VEHICULO").val(material.COLOR_VEHICULO);
                $("#PLACAS_VEHICULO").val(material.PLACAS_VEHICULO);
                $("#NOINVENTARIO_VEHICULO").val(material.NOINVENTARIO_VEHICULO);
                $("#NUMERO_POLIZA").val(material.NUMERO_POLIZA);
                $("#ENTIDAD_POLIZA").val(material.ENTIDAD_POLIZA);
                $("#INICIOVIGENCIA_POLIZA").val(material.INICIOVIGENCIA_POLIZA);
                $("#FINVIGENCIA_POLIZA").val(material.FINVIGENCIA_POLIZA);
                $("#NOLICENCIA_VEHICULO").val(material.NOLICENCIA_VEHICULO);
                $("#FECHAVENCIMIENTO_VEHICULO").val(material.FECHAVENCIMIENTO_VEHICULO);
                $("#KILOMETRAJE_SALIDA_VEHICULOS").val(material.KILOMETRAJE_SALIDA_VEHICULOS);
                $("#NOPERSONAS_VEHICULOS").val(material.NOPERSONAS_VEHICULOS);
                $("#HORASALIDA_VEHICULOS").val(material.HORASALIDA_VEHICULOS);
                $("#BOTIQUIN_PRIMEROS_AUXILIOS_VEHICULOS").val(material.BOTIQUIN_PRIMEROS_AUXILIOS_VEHICULOS);
                $("#KIT_SEGURIDAD_VEHICULOS").val(material.KIT_SEGURIDAD_VEHICULOS);
                $("#KILOMETRAJE_LLEGADA_VEHICULOS").val(material.KILOMETRAJE_LLEGADA_VEHICULOS);
                $("#HORAREGRESO_VEHICULOS").val(material.HORAREGRESO_VEHICULOS);
                $("#VERIFICA_POR").val(material.VERIFICA_POR);
                $("#VALIDADO_POR").val(material.VALIDADO_POR);
                $("#RETORNO_VEHICULOS").val(material.RETORNO_VEHICULOS);
                $("#OBS_MALETIN_VEHICULOS").val(material.OBS_MALETIN_VEHICULOS);
                $("#OBS_FERULA_VEHICULOS").val(material.OBS_FERULA_VEHICULOS);
                $("#OBS_FACE_SHIELD_VEHICULOS").val(material.OBS_FACE_SHIELD_VEHICULOS);
                $("#OBS_TIJERAS_VEHICULOS").val(material.OBS_TIJERAS_VEHICULOS);
                $("#OBS_GASAS_10_VEHICULOS").val(material.OBS_GASAS_10_VEHICULOS);
                $("#OBS_GASAS_5_VEHICULOS").val(material.OBS_GASAS_5_VEHICULOS);
                $("#OBS_GUANTES_VEHICULOS").val(material.OBS_GUANTES_VEHICULOS);
                $("#OBS_MICROPORE_1_VEHICULOS").val(material.OBS_MICROPORE_1_VEHICULOS);
                $("#OBS_MICROPORE_2_VEHICULOS").val(material.OBS_MICROPORE_2_VEHICULOS);
                $("#OBS_VENDA_5_VEHICULOS").val(material.OBS_VENDA_5_VEHICULOS);
                $("#OBS_VENDA_10_VEHICULOS").val(material.OBS_VENDA_10_VEHICULOS);
                $("#OBS_SOLUCION_SALINA_VEHICULOS").val(material.OBS_SOLUCION_SALINA_VEHICULOS);
                $("#OBS_VENDA_TRIANGULAR_VEHICULOS").val(material.OBS_VENDA_TRIANGULAR_VEHICULOS);
                $("#OBS_MALETIN_HERRAMIENTAS_VEHICULOS").val(material.OBS_MALETIN_HERRAMIENTAS_VEHICULOS);
                $("#OBS_DESARMADOR_CRUZ_VEHICULOS").val(material.OBS_DESARMADOR_CRUZ_VEHICULOS);
                $("#OBS_DESARMADOR_PLANO_VEHICULOS").val(material.OBS_DESARMADOR_PLANO_VEHICULOS);
                $("#OBS_PINZAS_MULTIUSOS_VEHICULOS").val(material.OBS_PINZAS_MULTIUSOS_VEHICULOS);
                $("#OBS_CUERDAS_BUNGEE_VEHICULOS").val(material.OBS_CUERDAS_BUNGEE_VEHICULOS);
                $("#OBS_LONA_POLIETILENO_VEHICULOS").val(material.OBS_LONA_POLIETILENO_VEHICULOS);
                $("#OBS_GUANTES_NEOPRENO_VEHICULOS").val(material.OBS_GUANTES_NEOPRENO_VEHICULOS);
                $("#OBS_CALIBRADOR_LLANTAS_VEHICULOS").val(material.OBS_CALIBRADOR_LLANTAS_VEHICULOS);
                $("#OBS_EXTINTOR_PQS_VEHICULOS").val(material.OBS_EXTINTOR_PQS_VEHICULOS);
                $("#OBS_LINTERNA_RECARGABLE_VEHICULOS").val(material.OBS_LINTERNA_RECARGABLE_VEHICULOS);
                $("#FRENTE_DERECHA").val(material.FRENTE_DERECHA);
                $("#FRENTE_IZQUIERDA").val(material.FRENTE_IZQUIERDA);
                $("#TRASERA_DERECHA").val(material.TRASERA_DERECHA);
                $("#TRASERA_IZQUIERDA").val(material.TRASERA_IZQUIERDA);


                if (material.BOTIQUIN_PRIMEROS_AUXILIOS_VEHICULOS === '1') {
                    $('#TABLA_BOTIQUIN_VEHICULOS').show();
                } else {
                    $('#TABLA_BOTIQUIN_VEHICULOS').hide();
                }

                if (material.KIT_SEGURIDAD_VEHICULOS === '1') {
                    $('#TABLA_KIT_SEGURIDAD_VEHICULOS').show();
                } else {
                    $('#TABLA_KIT_SEGURIDAD_VEHICULOS').hide();
                }

                if (material.RETORNO_VEHICULOS === '1') {
                    $('#DIV_KILOMETRAJE_LLEGADA').show();
                    $('#FIRMA_REGRESO_VEHICULO').show();
                } else {
                    $('#DIV_KILOMETRAJE_LLEGADA').hide();
                    $('#FIRMA_REGRESO_VEHICULO').hide();
                }

                if (material.FIRMA_RECIBIDO_POR) {
                    let img1 = new Image();
                    img1.onload = function () {
                        ctx1.drawImage(img1, 0, 0, canvas1.width, canvas1.height);
                    };
                    img1.src = material.FIRMA_RECIBIDO_POR;
                    $("#FIRMA_RECIBIDO_POR").val(material.FIRMA_RECIBIDO_POR);
                }

                if (material.FIRMA_ENTREGADO_POR) {
                    let img2 = new Image();
                    img2.onload = function () {
                        ctx2.drawImage(img2, 0, 0, canvas2.width, canvas2.height);
                    };
                    img2.src = material.FIRMA_ENTREGADO_POR;
                    $("#FIRMA_ENTREGADO_POR").val(material.FIRMA_ENTREGADO_POR);
                }

                if (material.FIRMA_VERIFICADO_POR) {
                    let img3 = new Image();
                    img3.onload = function () {
                        ctx3.drawImage(img3, 0, 0, canvas3.width, canvas3.height);
                    };
                    img3.src = material.FIRMA_VERIFICADO_POR;
                    $("#FIRMA_VERIFICADO_POR").val(material.FIRMA_VERIFICADO_POR);
                }

                if (material.FIRMA_VALIDADO_POR) {
                    let img4 = new Image();
                    img4.onload = function () {
                        ctx4.drawImage(img4, 0, 0, canvas4.width, canvas4.height);
                    };
                    img4.src = material.FIRMA_VALIDADO_POR;
                    $("#FIRMA_VALIDADO_POR").val(material.FIRMA_VALIDADO_POR);
                }

                $("#DANIOS_UNIDAD_JSON").val(material.DANIOS_UNIDAD_JSON || "");
                cargarDaniosEnCanvas(material.DANIOS_UNIDAD_JSON);


                 $("#COMBUSTIBLE_SALIDA_VEHICULOS").val(material.COMBUSTIBLE_SALIDA_VEHICULOS || "");
                if (material.COMBUSTIBLE_SALIDA_VEHICULOS) {
                    cargarCombustibleSalida(material.COMBUSTIBLE_SALIDA_VEHICULOS);
                }

                $("#COMBUSTIBLE_LLEGADA_VEHICULOS").val(material.COMBUSTIBLE_LLEGADA_VEHICULOS || "");
                if (material.COMBUSTIBLE_LLEGADA_VEHICULOS) {
                    cargarCombustibleLlegada(material.COMBUSTIBLE_LLEGADA_VEHICULOS);
                }
            
            } else {
                $("#ID_BITACORAS_ALMACEN").val(0);
                $("#RECIBIDO_POR").val("");
                $("#OBSERVACIONES_BITACORA").val("");
            }

            // $("#miModal_BITACORA").modal("show");
            const modalElement = document.getElementById('miModal_BITACORA');

            const modalBitacora = new bootstrap.Modal(modalElement, {
                backdrop: 'static', 
                keyboard: false     
            });

            modalBitacora.show();
            
            $('#miModal_BITACORA .modal-title').html(material.DESCRIPCION);
        },

        error: function () {
            alert("Error al obtener el material individual.");
        }
    });
});

function cargarFirmaEnCanvas(canvas, ctx, base64) {
    let img = new Image();
    img.onload = function () {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
    };
    img.src = base64;
}

function marcarRadio(nombre, valor) {
    if (valor === null || valor === undefined) return;

    valor = valor.toString().toUpperCase().trim();

    let posiblesValores = [];

    if (valor === '1' || valor === 'SI' || valor === 'TRUE') {
        posiblesValores = ['1', 'SI'];
    } else if (valor === '0' || valor === 'NO' || valor === 'FALSE') {
        posiblesValores = ['0', 'NO'];
    } else {
        posiblesValores = [valor];
    }

    $('input[name="' + nombre + '"]').prop('checked', false);

        posiblesValores.forEach(function(val) {
        const radio = $('input[name="' + nombre + '"][value="' + val + '"]');
        if (radio.length) {
            radio.prop('checked', true);
        }
    });
}

$("#guardaBITACORA").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario3($('#formularioBITACORA'))

    if (formularioValido) {

        if (ID_BITACORAS_ALMACEN == 0) {

            alertMensajeConfirm({
                title: "¿Desea guardar la información?",
                text: "Al guardarla, se podra usar",
                icon: "question",
            }, async function () {

                await loaderbtn('guardaBITACORA')

            
                $('#contenedorImagenesHidden').empty();

                imagenesSeleccionadas.forEach(file => {

                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);

                    const input = document.createElement('input');
                    input.type = 'file';
                    input.name = 'IMAGENES_BITACORA[]';
                    input.files = dataTransfer.files;

                    document.getElementById('contenedorImagenesHidden').appendChild(input);
                });

              
                imagenesEliminadas.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'IMAGENES_ELIMINADAS[]';
                    input.value = id;
                    document.getElementById('contenedorImagenesHidden').appendChild(input);
                });

                await ajaxAwaitFormData(
                    {
                        api: 1,
                        ID_BITACORAS_ALMACEN: ID_BITACORAS_ALMACEN,
                        RECEMPLEADO_ID: ID_FORM_GLOBAL,
                        INVENTARIO_ID: ID_INVENTARIO_GLOBAL
                    },
                    'BitacoraVehiculoSave',
                    'formularioBITACORA',
                    'guardaBITACORA',
                    { callbackAfter: true, callbackBefore: true },
                    () => {

                        Swal.fire({
                            icon: 'info',
                            title: 'Espere un momento',
                            text: 'Estamos guardando la información',
                            showConfirmButton: false
                        })

                        $('.swal2-popup').addClass('ld ld-breath')

                    },
                    function (data) {

                        ID_BITACORAS_ALMACEN = data.bitacora.ID_BITACORAS_ALMACEN

                        imagenesSeleccionadas = [];
                        imagenesEliminadas = [];
                        $('#previewImagenesBitacora').empty();
                        $('#contenedorImagenesHidden').empty();

                        alertMensaje(
                            'success',
                            'Información guardada correctamente',
                            'Esta información esta lista para usarse',
                            null,
                            null,
                            1500
                        )

                        $('#miModal_BITACORA').modal('hide')
                        document.getElementById('formularioBITACORA').reset();
                        Tablabitacoravehiculos.ajax.reload()
                    }
                )

            }, 1)

        } else {

            alertMensajeConfirm({
                title: "¿Desea editar la información de este formulario?",
                text: "Al guardarla, se podra usar",
                icon: "question",
            }, async function () {

                await loaderbtn('guardaBITACORA')

              
                $('#contenedorImagenesHidden').empty();

                imagenesSeleccionadas.forEach(file => {

                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);

                    const input = document.createElement('input');
                    input.type = 'file';
                    input.name = 'IMAGENES_BITACORA[]';
                    input.files = dataTransfer.files;

                    document.getElementById('contenedorImagenesHidden').appendChild(input);
                });

               
                imagenesEliminadas.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'IMAGENES_ELIMINADAS[]';
                    input.value = id;
                    document.getElementById('contenedorImagenesHidden').appendChild(input);
                });

                await ajaxAwaitFormData(
                    {
                        api: 1,
                        ID_BITACORAS_ALMACEN: ID_BITACORAS_ALMACEN,
                        RECEMPLEADO_ID: ID_FORM_GLOBAL,
                        INVENTARIO_ID: ID_INVENTARIO_GLOBAL
                    },
                    'BitacoraVehiculoSave',
                    'formularioBITACORA',
                    'guardaBITACORA',
                    { callbackAfter: true, callbackBefore: true },
                    () => {

                        Swal.fire({
                            icon: 'info',
                            title: 'Espere un momento',
                            text: 'Estamos guardando la información',
                            showConfirmButton: false
                        })

                        $('.swal2-popup').addClass('ld ld-breath')

                    },
                    function (data) {

                        setTimeout(() => {

                            ID_BITACORAS_ALMACEN = data.bitacora.ID_BITACORAS_ALMACEN

                            imagenesSeleccionadas = [];
                            imagenesEliminadas = [];
                            $('#previewImagenesBitacora').empty();
                            $('#contenedorImagenesHidden').empty();

                            alertMensaje(
                                'success',
                                'Información editada correctamente',
                                'Información guardada'
                            )

                            $('#miModal_BITACORA').modal('hide')
                            document.getElementById('formularioBITACORA').reset();
                            Tablabitacoravehiculos.ajax.reload()

                        }, 300);

                    }
                )

            }, 1)
        }

    } else {
        alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)
    }
});

$('#RECIBIDO_POR').on('change', function () {

    const valor = $(this).val();

    $('#NOLICENCIA_VEHICULO').val('');
    $('#FECHAVENCIMIENTO_VEHICULO').val('');
    $('#guardaBITACORA').show();

    if (!valor) return;

    $.ajax({
        url: '/obtenerLicenciaPersona',
        method: 'GET',
        data: { valor },

        success: function (res) {

            if (!res.success) {

                let mensaje = 'No se podrá guardar la información.';

                if (res.type === 'NO_LICENCIA') {
                    mensaje = 'Esta persona no tiene licencia registrada y no se podrá guardar la información.';
                }

                if (res.type === 'VENCIDA') {
                    mensaje = 'La licencia está vencida y no se podrá guardar la información.';
                }

                Swal.fire({
                    icon: 'warning',
                    title: 'Licencia inválida',
                    text: mensaje,
                    confirmButtonText: 'Aceptar'
                });

                $('#guardaBITACORA').hide();
                return;
            }

            $('#NOLICENCIA_VEHICULO').val(res.numero);
            $('#FECHAVENCIMIENTO_VEHICULO').val(res.vigencia);
            $('#guardaBITACORA').show();
        },

        error: function () {

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo verificar la licencia. No se podrá guardar la información.'
            });

            $('#guardaBITACORA').hide();
        }
    });
});

$('#BOTIQUIN_PRIMEROS_AUXILIOS_VEHICULOS').on('change', function () {
    if ($(this).val() === '1') {
        $('#TABLA_BOTIQUIN_VEHICULOS').slideDown();
    } else {
        $('#TABLA_BOTIQUIN_VEHICULOS').slideUp();
    }
});

$('#KIT_SEGURIDAD_VEHICULOS').on('change', function () {
    if ($(this).val() === '1') {
        $('#TABLA_KIT_SEGURIDAD_VEHICULOS').slideDown();
    } else {
        $('#TABLA_KIT_SEGURIDAD_VEHICULOS').slideUp();
    }
});

$('#RETORNO_VEHICULOS').on('change', function () {
    if ($(this).val() === '1') {   
        $('#DIV_KILOMETRAJE_LLEGADA').slideDown();
        $('#FIRMA_REGRESO_VEHICULO').slideDown();
    } else {                     
        $('#DIV_KILOMETRAJE_LLEGADA').slideUp();
        $('#FIRMA_REGRESO_VEHICULO').slideUp();
    }
});


// ===============================
// DAÑOS DEL CARRO 
// ===============================

const canvas = document.getElementById("canvasCarro");
const ctx = canvas.getContext("2d");

const img = new Image();
img.src = "/assets/images/IMAGENCARRO.png";

let modo = "x";
let marcas = []; 

img.onload = () => {
    redibujar();
};

document.getElementById("btnX").onclick = () => modo = "x";
document.getElementById("btnCirculo").onclick = () => modo = "circulo";

canvas.addEventListener("click", function (e) {
    const rect = canvas.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;

    if (modo === "x") {
        marcas.push({ tipo: "X", x, y });
    }

    if (modo === "circulo") {
        marcas.push({ tipo: "CIRCULO", x, y });
    }

    actualizar();
});

function redibujar() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

    marcas.forEach(m => {
        if (m.tipo === "X") dibujarX(m.x, m.y);
        if (m.tipo === "CIRCULO") dibujarCirculo(m.x, m.y);
    });
}

function dibujarX(x, y) {
    ctx.strokeStyle = "red";
    ctx.lineWidth = 3;

    ctx.beginPath();
    ctx.moveTo(x - 10, y - 10);
    ctx.lineTo(x + 10, y + 10);
    ctx.moveTo(x + 10, y - 10);
    ctx.lineTo(x - 10, y + 10);
    ctx.stroke();
}

function dibujarCirculo(x, y) {
    ctx.strokeStyle = "red";
    ctx.lineWidth = 2;

    ctx.beginPath();
    ctx.arc(x, y, 18, 0, Math.PI * 2);
    ctx.stroke();
}

document.getElementById("btnBorrarUltimo").onclick = () => {
    marcas.pop();
    actualizar();
};

document.getElementById("btnLimpiar").onclick = () => {
    marcas = [];
    actualizar();
};

function actualizar() {
    redibujar();
    document.getElementById("DANIOS_UNIDAD_JSON").value = JSON.stringify(marcas);
}

const modoTexto = document.getElementById("modoActual");
const btnX = document.getElementById("btnX");
const btnCirculo = document.getElementById("btnCirculo");

btnX.onclick = () => {
    modo = "x";
    setModoActivo();
};

btnCirculo.onclick = () => {
    modo = "circulo";
    setModoActivo();
};

function setModoActivo() {
    btnX.classList.remove("activo");
    btnCirculo.classList.remove("activo");

    if (modo === "x") {
        btnX.classList.add("activo");
        modoTexto.innerText = "Modo actual: Marcar X";
        modoTexto.style.color = "#0d6efd";
    }

    if (modo === "circulo") {
        btnCirculo.classList.add("activo");
        modoTexto.innerText = "Modo actual: Encerrar la X";
        modoTexto.style.color = "#dc3545";
    }
}

function cargarDaniosEnCanvas(json) {

    marcas = [];

    if (!json) {
        actualizar(); 
        return;
    }

    try {
        const datos = typeof json === "string" ? JSON.parse(json) : json;

        if (Array.isArray(datos)) {
            marcas = datos;
        }

    } catch (e) {
        console.error("Error al parsear DANIOS_UNIDAD_JSON", e);
        marcas = [];
    }

    actualizar();
}


// ===============================
// CARGAR IMAGENES  
// ===============================


let imagenesGuardadas = []; 
let imagenesSeleccionadas = []; 
let imagenesEliminadas = [];

function mostrarPreview(files) {

    Array.from(files).forEach(file => {
        if (!file.type.startsWith('image/')) return;

        imagenesSeleccionadas.push(file);
        renderImagenNueva(file, imagenesSeleccionadas.length - 1);
    });
}

function renderImagenNueva(file, index) {

    const reader = new FileReader();

    reader.onload = function (e) {

        const preview = document.getElementById('previewImagenesBitacora');

        const col = document.createElement('div');
        col.className = 'col-6 col-md-3 mb-3';
        col.dataset.index = index; 

        col.innerHTML = `
            <div class="card shadow-sm position-relative">

                <button type="button"
                    class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                    style="z-index:10;border-radius:50%;"
                    onclick="eliminarImagenDOM(this)">
                  <i class="bi bi-trash-fill"></i>
                </button>

                <div style="height:180px;display:flex;align-items:center;justify-content:center;background:#f8f9fa;">
                    <img src="${e.target.result}"
                         style="height:100%;width:100%;object-fit:contain;background:#fff;">
                </div>

                <div class="text-center mt-2 mb-2">
                    <a class="btn btn-outline-primary btn-sm"
                       href="${e.target.result}"
                       download>
                      <i class="bi bi-download"></i> Descargar
                    </a>
                </div>
            </div>
        `;

        preview.appendChild(col);
    };

    reader.readAsDataURL(file);
}

document.getElementById('inputCamara').addEventListener('change', function () {
    mostrarPreview(this.files);
    this.value = ''; 
});

document.getElementById('inputGaleria').addEventListener('change', function () {
    mostrarPreview(this.files);
    this.value = ''; 
});

function cargarImagenesGuardadas(recId, inventarioId) {

    $.get('/obtenerImagenesBitacora', {
        RECEMPLEADO_ID: recId,
        INVENTARIO_ID: inventarioId
    }, function (imagenes) {

        const preview = document.getElementById('previewImagenesBitacora');

        imagenes.forEach(img => {

            const col = document.createElement('div');
            col.className = 'col-6 col-md-3 mb-3';
            col.dataset.guardada = "1"; 

            col.innerHTML = `
                <div class="card shadow-sm position-relative">

                    <button type="button"
                        class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                        style="z-index:10;border-radius:50%;"
                        onclick="eliminarImagenDOM(this)">
                       <i class="bi bi-trash-fill"></i>
                    </button>

                    <div style="height:180px;display:flex;align-items:center;justify-content:center;background:#f8f9fa;">
                        <img src="/bitacora/vehiculo/imagen/${img.ID_IMAGENES_BITACORASALMACEN}"
                             style="height:100%;width:100%;object-fit:contain;background:#fff;">
                    </div>

                    <div class="text-center mt-2 mb-2">
                        <a class="btn btn-outline-primary btn-sm"
                           href="/bitacora/vehiculo/imagen/${img.ID_IMAGENES_BITACORASALMACEN}"
                           download>
                           <i class="bi bi-download"></i> Descargar
                        </a>
                    </div>
                </div>
            `;

            preview.appendChild(col);
        });
    });
}

function eliminarImagenDOM(btn) {

    const col = btn.closest('.col-6');

    // Imagen NUEVA
    if (col.dataset.index !== undefined) {
        const index = parseInt(col.dataset.index);
        imagenesSeleccionadas.splice(index, 1);
    }

    // Imagen GUARDADA
    if (col.dataset.guardada === "1") {
        const img = col.querySelector('img');
        const id = img.getAttribute('src').split('/').pop();
        imagenesEliminadas.push(id);
    }

    col.remove();
}

function cargarImagenesGuardadasVisualizar(recId, inventarioId) {

    $.get('/obtenerImagenesBitacora', {
        RECEMPLEADO_ID: recId,
        INVENTARIO_ID: inventarioId
    }, function (imagenes) {

        const preview = document.getElementById('previewImagenesBitacora');

        imagenes.forEach(img => {

            const col = document.createElement('div');
            col.className = 'col-6 col-md-3 mb-3';
            col.dataset.guardada = "1"; 

            col.innerHTML = `
                <div class="card shadow-sm position-relative">

               
                    <div style="height:180px;display:flex;align-items:center;justify-content:center;background:#f8f9fa;">
                        <img src="/bitacora/vehiculo/imagen/${img.ID_IMAGENES_BITACORASALMACEN}"
                             style="height:100%;width:100%;object-fit:contain;background:#fff;">
                    </div>
                </div>
            `;

            preview.appendChild(col);
        });
    });
}


// ===============================
// COMBUSTIBLE SALIDA
// ===============================


const canvasComb = document.getElementById("canvasCombustibleSalida");
const ctxComb = canvasComb.getContext("2d");

const imgComb = new Image();
imgComb.src = "/assets/images/nivelcombustible.png";

let dibujandoComb = false;
let trazosComb = [];
let trazoActual = [];

imgComb.onload = () => redibujarComb();

canvasComb.addEventListener("pointerdown", e => {
    e.preventDefault();

    dibujandoComb = true;
    trazoActual = [];

    canvasComb.setPointerCapture(e.pointerId);

    const pos = getPosComb(e);
    trazoActual.push(pos);
});

canvasComb.addEventListener("pointermove", e => {
    if (!dibujandoComb) return;
    e.preventDefault();

    const pos = getPosComb(e);
    trazoActual.push(pos);

    redibujarComb();
});

canvasComb.addEventListener("pointerup", e => {
    if (!dibujandoComb) return;
    e.preventDefault();

    dibujandoComb = false;
    trazosComb.push(trazoActual);
    actualizarHiddenComb();

    canvasComb.releasePointerCapture(e.pointerId);
});

canvasComb.addEventListener("pointercancel", e => {
    if (!dibujandoComb) return;

    dibujandoComb = false;
    trazosComb.push(trazoActual);
    actualizarHiddenComb();
});

function getPosComb(e) {
    const rect = canvasComb.getBoundingClientRect();
    return {
        x: e.clientX - rect.left,
        y: e.clientY - rect.top
    };
}

function redibujarComb() {
    ctxComb.clearRect(0, 0, canvasComb.width, canvasComb.height);

    if (!imgComb.complete) return;

    ctxComb.drawImage(imgComb, 0, 0, canvasComb.width, canvasComb.height);

    ctxComb.strokeStyle = "red";
    ctxComb.lineWidth = 3;
    ctxComb.lineCap = "round";

    trazosComb.forEach(trazo => {
        ctxComb.beginPath();
        trazo.forEach((p, i) => {
            if (i === 0) ctxComb.moveTo(p.x, p.y);
            else ctxComb.lineTo(p.x, p.y);
        });
        ctxComb.stroke();
    });

    if (trazoActual.length > 0) {
        ctxComb.beginPath();
        trazoActual.forEach((p, i) => {
            if (i === 0) ctxComb.moveTo(p.x, p.y);
            else ctxComb.lineTo(p.x, p.y);
        });
        ctxComb.stroke();
    }
}

function redibujarCombWrapper() {
    redibujarComb();
}
const redibujarCombAlias = redibujarComb;

function actualizarHiddenComb() {
    document.getElementById("COMBUSTIBLE_SALIDA_VEHICULOS").value =
        JSON.stringify(trazosComb);
}

document.getElementById("btnLimpiarCombustibleSalida").onclick = () => {
    limpiarCombustibleSalida();
};

function limpiarCombustibleSalida() {
    trazosComb = [];
    trazoActual = [];
    document.getElementById("COMBUSTIBLE_SALIDA_VEHICULOS").value = "";

    redibujarComb();
}

function cargarCombustibleSalida(json) {

    trazosComb = [];
    trazoActual = [];

    if (!json) {
        redibujarComb();
        return;
    }

    try {
        let datos = json;

        if (typeof datos === "string") {
            datos = JSON.parse(datos);
        }

        if (Array.isArray(datos)) {
            trazosComb = datos;
        }

        document.getElementById("COMBUSTIBLE_SALIDA_VEHICULOS").value =
            JSON.stringify(trazosComb);

    } catch (e) {
        trazosComb = [];
        document.getElementById("COMBUSTIBLE_SALIDA_VEHICULOS").value = "";
    }

    redibujarComb();
}





// ===============================
// COMBUSTIBLE LLEGADA
// ===============================


const canvasCombLlegada = document.getElementById("canvasCombustibleLlegada");
const ctxCombLlegada = canvasCombLlegada.getContext("2d");

const imgCombLlegada = new Image();
imgCombLlegada.src = "/assets/images/nivelcombustible.png";

let dibujandoCombLlegada = false;
let trazosCombLlegada = [];
let trazoActualLlegada = [];


imgCombLlegada.onload = () => redibujarCombLlegada();

canvasCombLlegada.addEventListener("pointerdown", e => {
    e.preventDefault();

    dibujandoCombLlegada = true;
    trazoActualLlegada = [];

    canvasCombLlegada.setPointerCapture(e.pointerId);

    const pos = getPosCombLlegada(e);
    trazoActualLlegada.push(pos);
});

canvasCombLlegada.addEventListener("pointermove", e => {
    if (!dibujandoCombLlegada) return;
    e.preventDefault();

    const pos = getPosCombLlegada(e);
    trazoActualLlegada.push(pos);

    redibujarCombLlegada();
});

canvasCombLlegada.addEventListener("pointerup", e => {
    if (!dibujandoCombLlegada) return;
    e.preventDefault();

    dibujandoCombLlegada = false;
    trazosCombLlegada.push(trazoActualLlegada);
    actualizarHiddenCombLlegada();

    canvasCombLlegada.releasePointerCapture(e.pointerId);
});

canvasCombLlegada.addEventListener("pointercancel", e => {
    if (!dibujandoCombLlegada) return;

    dibujandoCombLlegada = false;
    trazosCombLlegada.push(trazoActualLlegada);
    actualizarHiddenCombLlegada();
});

function getPosCombLlegada(e) {
    const rect = canvasCombLlegada.getBoundingClientRect();
    return {
        x: e.clientX - rect.left,
        y: e.clientY - rect.top
    };
}

function redibujarCombLlegada() {
    ctxCombLlegada.clearRect(0, 0, canvasCombLlegada.width, canvasCombLlegada.height);

    if (!imgCombLlegada.complete) return;

    ctxCombLlegada.drawImage(
        imgCombLlegada,
        0, 0,
        canvasCombLlegada.width,
        canvasCombLlegada.height
    );

    ctxCombLlegada.strokeStyle = "red";
    ctxCombLlegada.lineWidth = 3;
    ctxCombLlegada.lineCap = "round";

    trazosCombLlegada.forEach(trazo => {
        ctxCombLlegada.beginPath();
        trazo.forEach((p, i) => {
            if (i === 0) ctxCombLlegada.moveTo(p.x, p.y);
            else ctxCombLlegada.lineTo(p.x, p.y);
        });
        ctxCombLlegada.stroke();
    });

    if (trazoActualLlegada.length > 0) {
        ctxCombLlegada.beginPath();
        trazoActualLlegada.forEach((p, i) => {
            if (i === 0) ctxCombLlegada.moveTo(p.x, p.y);
            else ctxCombLlegada.lineTo(p.x, p.y);
        });
        ctxCombLlegada.stroke();
    }
}

function actualizarHiddenCombLlegada() {
    document.getElementById("COMBUSTIBLE_LLEGADA_VEHICULOS").value =
        JSON.stringify(trazosCombLlegada);
}

document.getElementById("btnLimpiarCombustibleLlegada").onclick = () => {
    limpiarCombustibleLlegada();
};

function limpiarCombustibleLlegada() {
    trazosCombLlegada = [];
    trazoActualLlegada = [];
    document.getElementById("COMBUSTIBLE_LLEGADA_VEHICULOS").value = "";

    redibujarCombLlegada();
}

function cargarCombustibleLlegada(json) {

    trazosCombLlegada = [];
    trazoActualLlegada = [];

    if (!json) {
        redibujarCombLlegada();
        return;
    }

    try {
        let datos = json;

        if (typeof datos === "string") {
            datos = JSON.parse(datos);
        }

        if (Array.isArray(datos)) {
            trazosCombLlegada = datos;
        }

        document.getElementById("COMBUSTIBLE_LLEGADA_VEHICULOS").value =
            JSON.stringify(trazosCombLlegada);

    } catch (e) {
        trazosCombLlegada = [];
        document.getElementById("COMBUSTIBLE_LLEGADA_VEHICULOS").value = "";
    }

    redibujarCombLlegada();
}


