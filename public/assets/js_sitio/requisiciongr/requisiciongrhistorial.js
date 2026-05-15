



const modalgr = document.getElementById('modalGR');


modalgr.addEventListener('hidden.bs.modal', event => {
    document.getElementById('formulariorecepciongr').reset();
    $('#ID_GR').val('');
    $('#modal_bien_servicio').empty();
    $("#modal-body-parciales").empty().hide();
    $("#modal-body-base").show();
});





var Tablabitacoragrhistorial = $("#Tablabitacoragrhistorial").DataTable({
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
        method: 'GET',
        url: '/Tablabitacoragrhistorial',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablabitacoragrhistorial.columns.adjust().draw();
            ocultarCarga();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
         data: function (d) {
            d.FECHA_INICIO = $('#FECHA_INICIO').val();
            d.FECHA_FIN = $('#FECHA_FIN').val();
        },
        dataSrc: 'data'
    },
    columnDefs: [
        { targets: '_all', defaultContent: 'N/A' },
        { targets: 0,  width: '1px'  },                                                                       
        { targets: 1, width: '10px', className: 'text-center'  },
        { targets: 2, width: '17px',className: 'text-center'  },
        { targets: 3, width: '10px',className: 'text-center'  },
        { targets: 4, width: '17px', className: 'text-center' },
        { targets: 5, width: '50px',className: 'text-center' },
        { targets: 6, width: '10px',className: 'text-center'  },
        { targets: 7, width: '70px', className: 'col-bien-servicio' },
        { targets: 8, width: '10px', className: 'text-center' },
        { targets: 9, width: '10px',className: 'text-center'  },
        { targets: 10, width: '10px',className: 'text-center'  },
    ],
  columns: [
        { 
            data: null,
            render: function(data, type, row, meta) {
                return meta.row + 1; 
            }
        },
        { data: 'NO_MR' },
        { data: 'FECHA_APRUEBA_MR' },
        { data: 'NO_PO' },
        { data: 'FECHA_APROBACION_PO' },
        { data: 'PROVEEDOR' },
        { data: 'FECHA_ENTREGA_PO' },
        { data: 'BIEN_SERVICIO' },
         {
        data: null,
        className: "text-center",
        defaultContent: '<button class="btn btn-sm btn-primary btn-gr">Ver GR</button>'
      },
      { data: 'FECHA_EMISION' }, 
      { data: 'NO_GR' }, 
  ],
    rowCallback: function(row, data) {
        if (data.ROW_CLASS) {
            $(row).addClass(data.ROW_CLASS);
        }
    },
    createdRow: function (row, data, dataIndex) {
        $(row).css('background-color', data.COLOR);
    },
     infoCallback: function (settings, start, end, max, total, pre) {
        return `Total de ${total} registros`;
    },
    drawCallback: function () {
        const topScroll = document.querySelector('.tabla-scroll-top');
        const scrollInner = document.querySelector('.tabla-scroll-top .scroll-inner');
        const table = document.querySelector('#Tablabitacoragrhistorial');
        const scrollBody = document.querySelector('.dataTables_scrollBody');

        if (!topScroll || !scrollInner || !table || !scrollBody) return;

        const tableWidth = table.scrollWidth;
        scrollInner.style.width = tableWidth + 'px';

        let syncingTop = false;
        let syncingBottom = false;

        topScroll.addEventListener('scroll', function () {
            if (syncingTop) return;
            syncingBottom = true;
            scrollBody.scrollLeft = topScroll.scrollLeft;
            syncingBottom = false;
        });

        scrollBody.addEventListener('scroll', function () {
            if (syncingBottom) return;
            syncingTop = true;
            topScroll.scrollLeft = scrollBody.scrollLeft;
            syncingTop = false;
        });
    }
});

$('#btnFiltrarMR').on('click', function () {

    const inicio = $('#FECHA_INICIO').val();
    const fin = $('#FECHA_FIN').val();

    if ((inicio && !fin) || (!inicio && fin)) {
        alertToast('Seleccione ambas fechas o deje ambas vacías', 'warning', 2000);
        return;
    }

    if (inicio && fin && inicio > fin) {
        alertToast('La fecha inicio no puede ser mayor a la fecha fin', 'error', 2000);
        return;
    }

    Tablabitacoragrhistorial.ajax.reload();
});


$(document).on('click', '.btn-ver-mas-materiales', function() {
    let $btn = $(this);
    let $extra = $btn.siblings('.extra-materiales');
    if ($extra.is(':visible')) {
        $extra.hide();
        $btn.text('Ver más');
    } else {
        $extra.show();
        $btn.text('Ver menos');
    }
});


$('#Tablabitacoragrhistorial tbody').on('click', 'button.btn-gr', function () {
  var data = Tablabitacoragrhistorial.row($(this).parents('tr')).data();

  let requestData = {
    NO_MR: data.NO_MR ?? '',
    NO_PO: data.NO_PO ?? '',
    PROVEEDOR: data.PROVEEDOR_KEY ?? '',
    _token: $('input[name="_token"]').val()
  };

  $.post('/consultar-gr', requestData, function (resp) {

  
    let contenedor = $("#modal_bien_servicio");
    contenedor.empty();


if (resp.existe) {

    // ==========================
    // VARIAS GR (Parciales)
    // ==========================
   
    if (resp.grs && Object.keys(resp.grs).length > 1) {
        $("#modal-body-base").hide();
        let contenedor = $("#modal-body-parciales");
        contenedor.show().empty();

        let tabs = `<ul class="nav nav-tabs" id="tabsGR" role="tablist">`;
        let panes = `<div class="tab-content" id="tabsGRContent">`;

          
        let idx = 0;
        for (let id in resp.grs) {
            let grupo   = resp.grs[id] || {};
            let cab     = grupo.cabecera || {};
            let detalle = grupo.detalle || [];

            let active = idx === 0 ? 'active' : '';
            let show   = idx === 0 ? 'show active' : '';

            tabs += `
              <li class="nav-item" role="presentation">
                <button class="nav-link ${active}" id="tab-${id}" data-bs-toggle="tab" 
                        data-bs-target="#pane-${id}" type="button" role="tab">
                  GR #${cab.ID_GR} ${cab.GR_PARCIAL === "Sí" ? "(Parcial)" : ""}
                </button>
              </li>
            `;

          panes += `
             
          
              <div class="tab-pane fade ${show}" id="pane-${id}" role="tabpanel">
                <form class="form-gr" data-id="${cab.ID_GR}">
                
                    
                 <input type="hidden" name="ID_GR[]" value="${cab.ID_GR}">



              <input type="hidden" class="form-control" value="${cab.GENEROGR_ID ?? ''}"  name="GENEROGR_ID">

                  <div class="row mb-3">
                      <div class="col-md-3 mt-2">
                          <label>No. MR</label>
                          <input type="text" class="form-control" value="${cab.NO_MR ?? ''}"  name="modal_no_mr" readonly>
                      </div>
                      <div class="col-md-3 mt-2">
                          <label>Fecha Aprobación MR</label>
                          <input type="text" class="form-control" value="${data.FECHA_APRUEBA_MR ?? ''}"  name="modal_fecha_mr"  readonly>
                      </div>
                      <div class="col-md-3 mt-2">
                          <label>No. PO</label>
                          <input type="text" class="form-control" value="${cab.NO_PO ?? ''}"  name="modal_no_po" readonly>
                      </div>
                      <div class="col-md-3 mt-2">
                          <label>Fecha Aprobación PO</label>
                          <input type="text" class="form-control" value="${data.FECHA_APROBACION_PO ?? ''}"  name="modal_fecha_po" readonly>
                      </div>
                  </div>

                  <div class="row mb-3">
                      <div class="col-md-6">
                          <label>Proveedor</label>

                          <select class="form-select text-center" name="PROVEEDOR_EQUIPO">
                              <option value="">Seleccionar proveedor</option>
                              <optgroup label="Proveedor oficial">
                                  ${window.proveedoresOficiales.map(p => `
                                      <option value="${p.RFC_ALTA}" ${cab.PROVEEDOR_KEY === p.RFC_ALTA ? "selected" : ""}>
                                          ${p.RAZON_SOCIAL_ALTA} (${p.RFC_ALTA})
                                      </option>
                                  `).join("")}
                              </optgroup>
                              <optgroup label="Proveedores temporales">
                                  ${window.proveedoresTemporales.map(p => `
                                      <option value="${p.RAZON_PROVEEDORTEMP}" ${cab.PROVEEDOR_KEY === p.RAZON_PROVEEDORTEMP ? "selected" : ""}>
                                          ${p.RAZON_PROVEEDORTEMP} (${p.NOMBRE_PROVEEDORTEMP})
                                      </option>
                                  `).join("")}
                              </optgroup>
                          </select>



                      </div>
                      <div class="col-md-6">
                          <label>Fecha Entrega PO</label>
                          <input type="text" class="form-control" value="${data.FECHA_ENTREGA_PO ?? ''}" name="modal_fecha_entrega" >
                      </div>
                  </div>

                  <div class="row mb-3">
                      <div class="col-md-6">
                          <label>No. Recepción GR</label>
                          <input type="text" class="form-control" value="${cab.NO_RECEPCION ?? ''}"  name="NO_RECEPCION">
                      </div>
                      <div class="col-md-6">
                          <label>Fecha de emisión</label>
                           <div class="input-group">
                                <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" value="${cab.FECHA_EMISION ?? ''}"  name="DESDE_ACREDITACION" >
                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                            </div>
                      </div>
                  </div>
                  <div class="row mb-3">
                       <div class="col-md-6">
                            <label class="form-label"> Fecha de entrega GR</label>
                           <div class="input-group">
                                <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" value="${cab.FECHA_ENTREGA_GR ?? ''}"  name="FECHA_ENTREGA_GR" >
                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                            </div>
                      </div>
                       <div class="col-md-6">
                          <label class="form-label"> GR Parcial</label>
                          <select class="form-control gr_parcialjs" name="GR_PARCIAL">
                              <option value="">Seleccione</option>
                              <option value="Sí" ${cab.GR_PARCIAL === "Sí" ? "selected" : ""}>Sí</option>
                              <option value="No" ${cab.GR_PARCIAL === "No" ? "selected" : ""}>No</option>
                          </select>
                      </div>
                  </div>


                  <hr>
                  <h5 class="mb-3 text-center">Bienes o Servicios (B o S)</h5>
                  <div class="detalles-gr"></div>
                  <hr>

                  <div class="row mb-3">
                      <div class="col-md-6">
                          <label>Usuario que solicitó</label>
                          <input type="text" class="form-control" value="${cab.USUARIO_SOLICITO ?? ''}"  name="modal_usuario_nombre" readonly>
                      </div>
                      <div class="col-md-6">
                          <label class="form-label"> Mandar a Vo.Bo usuario</label>
                              <select class="form-control" name="MANDAR_USUARIO_VOBO" >
                                  <option value="">Seleccione</option>
                                    <option value="Sí" ${cab.MANDAR_USUARIO_VOBO === "Sí" ? "selected" : ""}>Sí</option>
                                  <option value="No" ${cab.MANDAR_USUARIO_VOBO === "No" ? "selected" : ""}>No</option>
                          </select>
                      </div>
                  </div>


                  
                  <div class="row mb-3">
                      <div class="col-md-6">
                          <label class="form-label"> Estado Vo.Bo usuario</label>
                          <select class="form-control" name="VO_BO_USUARIO">
                              <option value="">Seleccione</option>
                              <option value="Aprobada" ${cab.VO_BO_USUARIO === "Aprobada" ? "selected" : ""}>Aprobada</option>
                              <option value="Rechazada" ${cab.VO_BO_USUARIO === "Rechazada" ? "selected" : ""}>Rechazada</option>
                          </select>
                      </div>


                      <div class="col-md-6">
                            <label class="form-label">Fecha Vo.Bo usuario</label>
                            <div class="input-group">
                                <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" value="${cab.FECHA_VOUSUARIO ?? ''}" name="FECHA_VOUSUARIO">
                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                            </div>
                        </div>


                        <div class="col-md-12 mt-2">
                          <label class="form-label"> Finalizar GR</label>
                          <select class="form-control" name="FINALIZAR_GR">
                              <option value="">Seleccione</option>
                              <option value="Sí" ${cab.FINALIZAR_GR === "Sí" ? "selected" : ""}>Sí</option>
                              <option value="No" ${cab.FINALIZAR_GR === "No" ? "selected" : ""}>No</option>
                          </select>
                      </div>


                     
                  </div>


                </form>
              </div>
            `;

            idx++;

  
          

         setTimeout(() => {
            let detalleCont = $(`#pane-${id} .detalles-gr`);
           detalle.forEach(det => {
                let bloque = crearBloqueDetalle(det, resp);
                detalleCont.append(bloque);

                activarSelect2EnBloque(bloque);
            });

    
             
            let $form = $(`#pane-${id} form.form-gr`);
            if ($form.find('input[name="_token"]').length === 0) {
                $form.prepend(
                    `<input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">`
                );
            }

            $(`#pane-${id} .mydatepicker`).datepicker({
                format: 'yyyy-mm-dd',
                weekStart: 1,
                autoclose: true,
                todayHighlight: true,
                language: 'es'
            });
        }, 200);

          
          
        }

        tabs += `</ul>`;
        panes += `</div>`;
        contenedor.append(tabs + panes);
    } 
        // ==========================
        // SOLO UNA GR
        // ==========================
        else {

            $("#modal-body-parciales").hide().empty();
        $("#modal-body-base").show();
        
            let cab = resp.cabecera;

                $('#ID_GR').val(cab.ID_GR ?? '');
                $('#modal_no_mr').val(cab.NO_MR);
                $('#modal_fecha_mr').val(data.FECHA_APRUEBA_MR ?? '');
                $('#modal_no_po').val(cab.NO_PO ?? '');
                $('#modal_fecha_po').val(data.FECHA_APROBACION_PO ?? '');
                $('#PROVEEDOR_EQUIPO').val(cab.PROVEEDOR_KEY ?? '');
                $('#modal_fecha_entrega').val(data.FECHA_ENTREGA_PO ?? '');
                $('#modal_usuario_nombre').val(cab.USUARIO_SOLICITO ?? '');
                $('#DESDE_ACREDITACION').val(cab.FECHA_EMISION ?? '');
                $('#NO_RECEPCION').val(cab.NO_RECEPCION ?? '');
                $('#GENEROGR_ID').val(cab.GENEROGR_ID ?? '');
                $('#MANDAR_USUARIO_VOBO').val(cab.MANDAR_USUARIO_VOBO ?? '');
                $('#FECHA_VOUSUARIO').val(cab.FECHA_VOUSUARIO ?? '');
                $('#VO_BO_USUARIO').val(cab.VO_BO_USUARIO ?? '');
                $('#GR_PARCIAL').val(cab.GR_PARCIAL ?? '');
                $('#FECHA_ENTREGA_GR').val(cab.FECHA_ENTREGA_GR ?? '');
                $('#FINALIZAR_GR').val(cab.FINALIZAR_GR ?? '');



        

            let detalleCont = $("#modal_bien_servicio");
            detalleCont.empty();
            resp.detalle.forEach(det => {
                let bloque = crearBloqueDetalle(det, resp);
                detalleCont.append(bloque);

                activarSelect2EnBloque(bloque);

            });

            $('#VISTOBOUSUARIO').show();
        }

    

      
          
        // ==========================
        // Caso: NO EXISTE GR
        // ==========================
        }
         else {
            $('#ID_GR').val(""); 
            $('#modal_no_mr').val(data.NO_MR ?? '');
            $('#modal_fecha_mr').val(data.FECHA_APRUEBA_MR ?? '');
            $('#modal_no_po').val(data.NO_PO ?? '');
            $('#modal_fecha_po').val(data.FECHA_APROBACION_PO ?? '');
            $('#PROVEEDOR_EQUIPO').val(data.PROVEEDOR_KEY ?? '');
            $('#modal_fecha_entrega').val(data.FECHA_ENTREGA_PO ?? '');
            $('#modal_usuario_nombre').val(data.USUARIO_NOMBRE ?? '');

            if (data.BIEN_SERVICIO_COMPLETO) {
              $(data.BIEN_SERVICIO_COMPLETO).each(function (index) {
                  
            const texto = $(this).text().trim();
            let limpio = texto.replace(/^•\s*/, "");
            let partes = limpio.split(" - $ ");
            let descYcantidad = partes[0];
            let precio = partes[1] ?? "";

            let match = descYcantidad.match(/^(.*)\((\d+)\s*([^)]+)\)$/);
            let descripcion = match ? match[1].trim() : descYcantidad.trim();
            let cantidad = match ? match[2].trim() : 0;
            let unidad = match ? match[3].trim() : "";  
                  
                    let bloque = $(`
                        <div class="border rounded p-3 mb-3 bg-light">
                        
                          <div class="row mb-2">
                          
                          <div class="col-12 text-center">
                            <h5>Cantidad solicitada</h5>
                          </div>
                       
                            <div class="col-3 mt-2">
                              <label class="form-label">Descripción</label>
                              <textarea class="form-control" name="DESCRIPCION[]" rows="2" >${escapeHtml(descripcion)}</textarea>
                            </div>
                            <div class="col-2 mt-2">
                                  <label class="form-label">U.M.</label>
                                  <input type="text" class="form-control" name="UNIDAD[]" value="${unidad}" >
                                </div>
                           
                            <div class="col-2 mt-2">
                              <label class="form-label">Cantidad</label>
                              <input type="number" class="form-control cantidad" name="CANTIDAD[]" value="${cantidad}" readonly>
                            </div>
                            <div class="col-2 mt-2">
                              <label class="form-label">Precio unitario</label>
                              <input type="text" class="form-control precio_unitario" name="PRECIO_UNITARIO[]" value="${precio}" readonly>
                            </div>
                            <div class="col-2 mt-2">
                              <label class="form-label">Precio total</label>
                              <input type="text" class="form-control precio_total_mr" name="PRECIO_TOTAL_MR[]" value="0" readonly>
                            </div>
                          </div>
                              <div class="col-12 text-center">
                                <h5>Cantidad recibida </h5>
                              </div>
                          <div class="row mb-2">
                            <div class="col-3 mt-2">
                              <label class="form-label">Cantidad rechazada</label>
                              <input type="number" class="form-control" name="CANTIDAD_RECHAZADA[]" value="0" min="0">
                            </div>
                            <div class="col-3 mt-2">
                              <label class="form-label">Cantidad aceptada</label>
                              <input type="number" class="form-control cantidad_aceptada" name="CANTIDAD_ACEPTADA[]" value="0" min="0" max="${cantidad}">
                            </div>
                            <div class="col-3 mt-2">
                              <label class="form-label">Precio unitario GR</label>
                              <input type="text" class="form-control precio_unitario_gr" name="PRECIO_UNITARIO_GR[]" value="0" readonly>
                            </div>
                            <div class="col-3 mt-2">
                              <label class="form-label">Precio total GR</label>
                              <input type="text" class="form-control precio_total_gr" name="PRECIO_TOTAL_GR[]" value="0" readonly>
                            </div>
                          </div>

                          <div class="row mb-2 comentario-diferencia" style="display:none;">
                            <div class="col-12 mt-2">
                              <label class="form-label">Comentario por diferencia en cantidad</label>
                              <textarea class="form-control" name="COMENTARIO_DIFERENCIA[]" rows="2"></textarea>
                            </div>
                          </div>
                          <div class="row mb-2">

                           <div class="col-4 mt-2">
                              <label class="form-label">Tipo de cálculo</label>
                              <select class="form-control tipo_calculo" name="TIPO_CALCULO[]" required> 
                                <option value="">Seleccione</option>
                                <option value="1">Por pieza</option>
                                <option value="2">Por paquete</option>
                                <option value="3">N/A</option>
                              </select>
                            </div>


                            <div class="col-4 mt-2">
                              <label class="form-label">Cantidad que entra a almacén</label>
                              <input type="number" class="form-control cantidad_entraalmacen" name="CANTIDAD_ENTRA_ALMACEN[]" value="0" min="0">
                            </div>
                           <div class="col-4 mt-2">
                              <label class="form-label">U.M</label>
                              <input type="text" class="form-control " name="UNIDAD_MEDIDA_ALMACEN[]" required>
                            </div>

                             <div class="col-4 mt-2">
                              <label class="form-label">El ítem se guarda</label>
                              <select class="form-control guarda_item" name="ARTICULOS_SEPERADOS[]" required>
                                <option value="">Seleccione</option>
                                <option value="1">Por separado</option>
                                <option value="2">Todo junto</option>
                                <option value="3">N/A</option>
                              </select>
                            </div>


                            <div class="col-4 mt-2">
                              <label class="form-label">Tipo</label>
                              <select class="form-control" name="TIPO_BS[]" required>
                                <option value="">Seleccione</option>
                                <option value="Bien">Bien</option>
                                <option value="Servicio">Servicio</option>
                                <option value="Infraestructura">Infraestructura</option>
                                <option value="N/A">N/A</option>

                              </select>
                            </div>

                            <div class="col-4 mt-2">
                              <label class="form-label">El B o S es parcial</label>
                              <select class="form-control bs-esparcial" name="BIENS_PARCIAL[]" style="pointer-events:none; background-color:#e9ecef;">

                                <option value="">Seleccione</option>
                                <option value="Sí">Sí</option>
                                <option value="No">No</option>
                              </select>
                            </div>

                          </div>

                             <div class="row mb-2 comentario-diferencia-almacen" style="display:none;">
                                <div class="col-12 mt-2">
                                  <label class="form-label">Comentario por diferencia en cantidad que entra a almacén</label>
                                  <textarea class="form-control" name="COMENTARIO_DIFERENCIA_ALMACEN[]" rows="2"></textarea>
                                </div>
                              </div>



                          <div class="row mb-2">
                           <div class="col-4 mt-2">
                              <label class="form-label">¿Está en inventario?</label>  
                              <select class="form-control en_inventario" name="EN_INVENTARIO[]">
                                <option value="" >Seleccione</option>
                                <option value="Sí">Sí</option>
                                <option value="No">No</option>
                              </select>
                            </div>
                              <div class="col-8 bloque-inventario" style="display:none;">
                                <div class="row">
                                  <div class="col-6 mt-2">
                                    <label class="form-label">Tipo Inventario</label>
                                    <select class="form-control tipo_inventario" name="TIPO_INVENTARIO[]">
                                      <option value="">Seleccione</option>
                                      ${resp.tipoinventario.map(t => 
                                        `<option value="${t.ID_CATALOGO_TIPOINVENTARIO}">${t.DESCRIPCION_TIPO}</option>`
                                      ).join("")}
                                    </select>
                                  </div>
                                  <div class="col-6 mt-2">
                                    <label class="form-label">Inventario</label>
                                    <select class="form-control inventario" name="INVENTARIO[]">
                                      <option value="">Seleccione</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                          </div>


                        </div>
                    `);

                    contenedor.append(bloque);

                  
                let selectTipoInventario = bloque.find(".inventario");

                selectTipoInventario.select2({
                    width: '100%',
                    dropdownParent: obtenerModalPadre(selectTipoInventario),
                    placeholder: "Seleccione",
                    allowClear: true
                });
                                
                  
                  calcularTotales(bloque);

                
                    bloque.find(".cantidad_aceptada").on("input", function () {
                        calcularTotales(bloque);
                        let cant = parseFloat(bloque.find(".cantidad").val()) || 0;
                        let aceptada = parseFloat($(this).val()) || 0;
                        bloque.find(".comentario-diferencia").toggle(cant !== aceptada);
                    });

                  bloque.find(".tipo_calculo").on("change", function () {
                        calcularTotales(bloque);
                    });
                
               bloque.find(".cantidad_entraalmacen").on("input", function () {
                    calcularTotales(bloque);
                });
                
                
                    bloque.find(".en_inventario").on("change", function () {
                        if ($(this).val() === "Sí") {
                            bloque.find(".bloque-inventario").show();
                        } else {
                            bloque.find(".bloque-inventario").hide();
                            bloque.find(".tipo_inventario").val("");
                            bloque.find(".inventario").empty().append('<option value="">Seleccione</option>');
                        }
                    });
 
                      bloque.find(".cantidad_entraalmacen").on("input", function () {
                        calcularTotales(bloque);
                    });
                    bloque.find(".tipo_inventario").on("change", function () {
                        let tipoDesc = $(this).find("option:selected").text();
                        let inventarioSelect = bloque.find(".inventario");
                        inventarioSelect.empty().append('<option value="">Seleccione</option>');

                        if (tipoDesc) {
                            resp.inventario
                                .filter(inv => inv.TIPO_EQUIPO == tipoDesc)
                                .forEach(inv => {
                                    inventarioSelect.append(
                                        `<option value="${inv.ID_FORMULARIO_INVENTARIO}">${inv.DESCRIPCION_EQUIPO} | ${inv.MARCA_EQUIPO} | ${inv.MODELO_EQUIPO} | ${inv.SERIE_EQUIPO} | ${inv.CODIGO_EQUIPO}</option>`
                                    );
                                });
                        }
                    });
                });
            } else {
                contenedor.html('<div class="text-muted">No hay bienes o servicios</div>');
          }
          

              $('#VISTOBOUSUARIO').hide();

        }

        $('#modalGR').modal('show');
    });
});

function obtenerModalPadre(elemento) {
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

function activarSelect2EnBloque(bloque) {

    let selects = bloque.find(".inventario");

    selects.each(function () {

        let $this = $(this);

        // Si ya está inicializado lo destruimos primero
        if ($this.hasClass("select2-hidden-accessible")) {
            $this.select2("destroy");
        }

        $this.select2({
            width: '100%',
            dropdownParent: obtenerModalPadre($this),
            placeholder: "Seleccione",
            allowClear: true
        });
    });
}

function calcularTotales(bloque) {

    let cantidad      = parseFloat(bloque.find(".cantidad").val()) || 0;
    let precioUnitMR  = parseFloat(bloque.find(".precio_unitario").val()) || 0;
    let almacen       = parseFloat(bloque.find(".cantidad_entraalmacen").val()) || 0;
    let aceptada      = parseFloat(bloque.find(".cantidad_aceptada").val()) || 0;
    let tipoCalculo   = bloque.find(".tipo_calculo").val();

 
    let totalMr = cantidad * precioUnitMR;
    bloque.find(".precio_total_mr").val(totalMr.toFixed(2));

    let precioUnitGR = 0;
    let totalGR = 0;

  
    if (tipoCalculo === "1") {

        precioUnitGR = precioUnitMR; 
        totalGR = precioUnitGR * almacen;

    }

   
    else if (tipoCalculo === "2") {

        if (almacen > 0) {
            precioUnitGR = totalMr / almacen;
            totalGR = precioUnitGR * almacen;
        } else {
            precioUnitGR = 0;
            totalGR = 0;
        }

    }

  
    else {
        precioUnitGR = 0;
        totalGR = 0;
    }

    bloque.find(".precio_unitario_gr").val(precioUnitGR.toFixed(2));
    bloque.find(".precio_total_gr").val(totalGR.toFixed(2));

 
    bloque.find(".comentario-diferencia")
          .toggle(cantidad !== aceptada);

    bloque.find(".comentario-diferencia-almacen")
          .toggle(cantidad !== almacen);
}

$('#btnGuardarGR').on('click', function () {

    let formActivo;

    if ($(".form-gr").length > 0) {
        formActivo = $(".tab-pane.active .form-gr");
    } else {
        formActivo = $("#formulariorecepciongr");
    }

    if (!validarFormulariogr(formActivo)) {

        Swal.fire({
            icon: 'warning',
            title: 'Formulario incompleto',
            text: 'Debe completar los campos obligatorios.'
        });

        return; 
    }

    let formData = formActivo.serializeArray();

    formData.push({
        name: "_token",
        value: $('meta[name="csrf-token"]').attr('content')
    });

    Swal.fire({
        title: '¿Desea guardar la GR?',
        text: "Confirme para continuar",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, guardar',
        cancelButtonText: 'No, cancelar'
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url: '/guardarGR',
                method: 'POST',
                data: $.param(formData),
                beforeSend: function () {
                    Swal.fire({
                        title: 'Guardando...',
                        text: 'Por favor espere',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => Swal.showLoading()
                    });
                },
                success: function (resp) {

                    Swal.close();

                    if (resp.ok) {
                        Swal.fire('Éxito', 'GR guardada', 'success');
                        $('#modalGR').modal('hide');
                        Tablabitacoragrhistorial.ajax.reload();
                    } else {
                        Swal.fire('Error', resp.msg, 'error');
                    }
                },
                error: function () {
                    Swal.close();
                    Swal.fire('Error', 'Ocurrió un problema al guardar la GR', 'error');
                }
            });

        }
    });

});

function validarFormulariogr(formulario) {

    let formularioValido = true;

    formulario.find('.error').removeClass('error');

    const campos = formulario.find(
        'input[required]:not([disabled]):visible, textarea[required]:not([disabled]):visible, select[required]:not([disabled]):visible'
    );

    campos.each(function () {

        const tipoCampo = $(this).attr('type');
        const valorCampo = $(this).val();

        if (tipoCampo === 'radio' || tipoCampo === 'checkbox') {

            const nombreGrupo = $(this).attr('name');

            if ($('input[name="' + nombreGrupo + '"]:checked').length === 0) {
                $('input[name="' + nombreGrupo + '"]').addClass('error');
                formularioValido = false;
            }

        } else {
            if (!valorCampo || valorCampo.trim() === '') {
                $(this).addClass('error');
                formularioValido = false;
            }
        }

    });

    return formularioValido;
}

function crearBloqueDetalle(det, resp) {
    let bloque = $(`
          <div class="border rounded p-3 mb-3 bg-light">
                        <div class="row mb-2">

                         <div class="col-12 text-center">
                            <h5>Cantidad solicitada</h5>
                          </div>
                          <div class="col-3 mt-2">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control" name="DESCRIPCION[]" rows="2" >${det.DESCRIPCION}</textarea>
                          </div>
                           <div class="col-2 mt-2">
                                <label class="form-label">U.M.</label>
                                <input type="text" class="form-control" name="UNIDAD[]" value="${det.UNIDAD ?? ''}">
                          </div>
                          <div class="col-2 mt-2">
                            <label class="form-label">Cantidad</label>
                            <input type="number" class="form-control cantidad" name="CANTIDAD[]" value="${det.CANTIDAD}" readonly>
                          </div>
                          <div class="col-2 mt-2">
                            <label class="form-label">Precio Unitario</label>
                            <input type="text" class="form-control precio_unitario" name="PRECIO_UNITARIO[]" value="${det.PRECIO_UNITARIO}" readonly>
                          </div>
                          <div class="col-2 mt-2">
                            <label class="form-label">Precio Total</label>
                            <input type="text" class="form-control precio_total_mr" name="PRECIO_TOTAL_MR[]" value="${det.PRECIO_TOTAL_MR ?? 0}" readonly>
                          </div>
                        </div>

                        <div class="col-12 text-center">
                          <h5>Cantidad recibida </h5>
                        </div>
                        
                        <div class="row mb-2">
                          <div class="col-3 mt-2">
                            <label class="form-label">Cantidad Rechazada</label>
                            <input type="number" class="form-control" name="CANTIDAD_RECHAZADA[]" value="${det.CANTIDAD_RECHAZADA}">
                          </div>
                          <div class="col-3 mt-2">
                            <label class="form-label">Cantidad Aceptada</label>
                            <input type="number" class="form-control cantidad_aceptada" name="CANTIDAD_ACEPTADA[]" value="${det.CANTIDAD_ACEPTADA}">
                          </div>
                          <div class="col-3 mt-2">
                            <label class="form-label">Precio Unitario GR</label>
                            <input type="text" class="form-control precio_unitario_gr" name="PRECIO_UNITARIO_GR[]" value="${det.PRECIO_UNITARIO_GR ?? 0}" readonly>
                          </div>
                          <div class="col-3 mt-2">
                            <label class="form-label">Precio Total GR</label>
                            <input type="text" class="form-control precio_total_gr" name="PRECIO_TOTAL_GR[]" value="${det.PRECIO_TOTAL_GR ?? 0}" readonly>
                          </div>
                        </div>

                        <div class="row mb-2 comentario-diferencia" style="display:${det.CANTIDAD != det.CANTIDAD_ACEPTADA ? 'block' : 'none'};">
                          <div class="col-12 mt-2">
                            <label class="form-label">Comentario por diferencia en cantidad</label>
                            <textarea class="form-control" name="COMENTARIO_DIFERENCIA[]" rows="2">${det.COMENTARIO_DIFERENCIA ?? ""}</textarea>
                          </div>
                        </div>
                  

                         <div class="row mb-2">


                          <div class="col-4 mt-2">
                              <label class="form-label">Tipo de cálculo</label>
                                <select class="form-control tipo_calculo" name="TIPO_CALCULO[]" required>
                                <option value="">Seleccione</option>
                                <option value="1" ${det.TIPO_CALCULO=="1"?"selected":""}>Por pieza</option>
                                <option value="2" ${det.TIPO_CALCULO == "2" ? "selected" : ""}>Por paquete</option>
                                <option value="3" ${det.TIPO_CALCULO=="3"?"selected":""}>N/A</option>
                                </select>
                          </div>



                            <div class="col-4 mt-2">
                              <label class="form-label">Cantidad que entra a almacén</label>
                              <input type="number" class="form-control cantidad_entraalmacen" name="CANTIDAD_ENTRA_ALMACEN[]"   value="${det.CANTIDAD_ENTRA_ALMACEN ?? ''}">
                            </div>
                       

                          <div class="col-4 mt-2">
                              <label class="form-label">U.M</label>
                              <input type="text" class="form-control" name="UNIDAD_MEDIDA_ALMACEN[]"  value="${det.UNIDAD_MEDIDA_ALMACEN ?? ''}" required>
                            </div>


                            <div class="col-4 mt-2">
                              <label class="form-label">El ítem se guarda</label>
                                <select class="form-control guarda_item" name="ARTICULOS_SEPERADOS[]" required>
                                <option value="">Seleccione</option>
                                <option value="1" ${det.ARTICULOS_SEPERADOS=="1"?"selected":""}>Por separado</option>
                                <option value="2" ${det.ARTICULOS_SEPERADOS == "2" ? "selected" : ""}>Todo junto</option>
                                <option value="3" ${det.ARTICULOS_SEPERADOS=="3"?"selected":""}>N/A</option>
                                </select>
                            </div>



                            <div class="col-4 mt-2">
                                <label class="form-label">Tipo</label>
                                <select class="form-control" name="TIPO_BS[]" required>
                                <option value="">Seleccione</option>
                                <option value="Bien" ${det.TIPO_BS=="Bien"?"selected":""}>Bien</option>
                                <option value="Servicio" ${det.TIPO_BS == "Servicio" ? "selected" : ""}>Servicio</option>
                                <option value="Infraestructura" ${det.TIPO_BS == "Infraestructura" ? "selected" : ""}>Infraestructura</option>
                                <option value="N/A" ${det.TIPO_BS=="N/A"?"selected":""}>N/A</option>
                                </select>
                          </div>

                               <div class="col-4 mt-2">
                              <label class="form-label">El B o S es parcial</label>
                              <select class="form-control bs-esparcial" name="BIENS_PARCIAL[]" style="pointer-events:none; background-color:#e9ecef;">
                              <option value="">Seleccione</option>
                              <option value="Sí" ${det.BIENS_PARCIAL=="Sí"?"selected":""}>Sí</option>
                              <option value="No" ${det.BIENS_PARCIAL=="No"?"selected":""}>No</option>
                            </select>

                            </div>

                          </div>


                        <div class="row mb-2 comentario-diferencia-almacen" style="display:${det.CANTIDAD != det.CANTIDAD_ENTRA_ALMACEN ? 'block' : 'none'};">
                          <div class="col-12 mt-2">
                                <label class="form-label">Comentario por diferencia en cantidad que entra a almacén</label>
                            <textarea class="form-control" name="COMENTARIO_DIFERENCIA_ALMACEN[]" rows="2">${det.COMENTARIO_DIFERENCIA_ALMACEN ?? ""}</textarea>
                          </div>
                        </div>


                

                           <div class="row mb-2">
                             <div class="col-4 mt-2">
                            <label class="form-label">¿Está en inventario?</label>
                            <select class="form-control en_inventario" name="EN_INVENTARIO[]">
                              <option value="">Seleccione</option>
                              <option value="Sí" ${det.EN_INVENTARIO=="Sí"?"selected":""}>Sí</option>
                              <option value="No" ${det.EN_INVENTARIO == "No" ? "selected" : ""}>No</option>
                            </select>
                          </div>
                          <div class="col-8 bloque-inventario" style="display:${det.INVENTARIO_ID ? 'block' : 'none'};">
                            <div class="row">
                              <div class="col-6 mt-2">
                                <label class="form-label">Tipo Inventario</label>
                                <select class="form-control tipo_inventario" name="TIPO_INVENTARIO[]">
                                  <option value="">Seleccione</option>
                                  ${resp.tipoinventario ? resp.tipoinventario.map(t => 
                                    `<option value="${t.ID_CATALOGO_TIPOINVENTARIO}" ${det.TIPO_EQUIPO == t.DESCRIPCION_TIPO ? "selected" : ""}>${t.DESCRIPCION_TIPO}</option>`
                                  ).join("") : ""}
                                </select>
                              </div>
                              <div class="col-6 mt-2">
                                <label class="form-label">Inventario</label>
                                <select class="form-control inventario" name="INVENTARIO[]">
                                  <option value="">Seleccione</option>
                                  ${resp.inventario ? resp.inventario
                                    .filter(inv => inv.TIPO_EQUIPO == det.TIPO_EQUIPO)
                                    .map(inv =>
                                    `<option value="${inv.ID_FORMULARIO_INVENTARIO}" ${det.INVENTARIO_ID == inv.ID_FORMULARIO_INVENTARIO ? "selected" : ""}>${inv.DESCRIPCION_EQUIPO} | ${inv.MARCA_EQUIPO} | ${inv.MODELO_EQUIPO} | ${inv.SERIE_EQUIPO} | ${inv.CODIGO_EQUIPO}</option>`
                                    ).join("") : ""}
                                </select>
                              </div>
                            </div>
                          </div>
                          </div>

                          <div class="row mb-3">
                          <div class="col-12 text-center">
                            <h4>Vo.Bo usuario</h4>
                          </div>
                        </div>
                          <div class="row mb-2">
                          <div class="col-2 mt-2">
                            <label class="form-label">Cumple lo especificado usuario</label>
                            <select class="form-control" name="CUMPLE_ESPECIFICADO_USUARIO[]">
                              <option value="">Seleccione</option>
                              <option value="Sí" ${det.CUMPLE_ESPECIFICADO_USUARIO=="Sí"?"selected":""}>Sí</option>
                              <option value="No" ${det.CUMPLE_ESPECIFICADO_USUARIO=="No"?"selected":""}>No</option>
                            </select>
                          </div>
                          <div class="col-3 mt-2">
                            <label class="form-label">Comentario especificación usuario</label>
                            <textarea class="form-control" name="COMENTARIO_CUMPLE_USUARIO[]" rows="2">${det.COMENTARIO_CUMPLE_USUARIO??""}</textarea>
                          </div>
                         <div class="col-2 mt-2">
                            <label class="form-label">Estado del B o S usuario</label>
                            <select class="form-control" name="ESTADO_BS_USUARIO[]">
                              <option value="">Seleccione</option>
                                 <option value="BUEN_ESTADO" ${det.ESTADO_BS_USUARIO=="BUEN_ESTADO"?"selected":""}>En buen estado</option>
                              <option value="MAL_ESTADO" ${det.ESTADO_BS_USUARIO=="MAL_ESTADO"?"selected":""}>Mal estado</option>
                            </select>
                          </div>

                              
                     
                          <div class="col-3 mt-2">
                            <label class="form-label">Comentario estado usuario</label>
                            <textarea class="form-control" name="COMENTARIO_ESTADO_USUARIO[]" rows="2">${det.COMENTARIO_ESTADO_USUARIO??""}</textarea>
                          </div>

                          
                           <div class="col-2">
                            <label class="form-label">Vo. Bo</label>
                              <select class="form-control" name="VOBO_USUARIO_PRODUCTO[]">
                                <option value="">Seleccione</option>
                                <option value="Sí" ${det.VOBO_USUARIO_PRODUCTO=="Sí"?"selected":""}>Sí</option>
                                <option value="No" ${det.VOBO_USUARIO_PRODUCTO=="No"?"selected":""}>No</option>
                            </select>
                          </div>

                          <div class="col-12 mt-2 comentario-rechazada" 
                              style="display:${det.VOBO_USUARIO_PRODUCTO=="No" ? "block" : "none"};">
                              <label class="form-label">Comentario de rechazo</label>
                              <textarea class="form-control" name="COMENTARIO_VO_RECHAZO[]" rows="2">${det.COMENTARIO_VO_RECHAZO ?? ""}</textarea>
                          </div>


                        </div>


                    </div>
    `);

    calcularTotales(bloque);

    bloque.find(".cantidad_aceptada").on("input", function () {
        calcularTotales(bloque);
        let cant = parseFloat(bloque.find(".cantidad").val()) || 0;
        let aceptada = parseFloat($(this).val()) || 0;
        bloque.find(".comentario-diferencia").toggle(cant !== aceptada);
    });

  
  
  
   bloque.find(".cantidad_entraalmacen").on("input", function () {
    calcularTotales(bloque);
});
  

    bloque.find(".tipo_calculo").on("change", function () {
    calcularTotales(bloque);
    });
    
  
  
    bloque.find(".en_inventario").on("change", function () {
        if ($(this).val() === "Sí") {
            bloque.find(".bloque-inventario").show();
        } else {
            bloque.find(".bloque-inventario").hide();
            bloque.find(".tipo_inventario").val("");
            bloque.find(".inventario").empty().append('<option value="">Seleccione</option>');
        }
    });

    bloque.find(".tipo_inventario").on("change", function () {
        let tipoDesc = $(this).find("option:selected").text();
        let inventarioSelect = bloque.find(".inventario");
        inventarioSelect.empty().append('<option value="">Seleccione</option>');

        if (tipoDesc) {
            resp.inventario
                .filter(inv => inv.TIPO_EQUIPO == tipoDesc)
                .forEach(inv => {
                    inventarioSelect.append(
                        `<option value="${inv.ID_FORMULARIO_INVENTARIO}">${inv.DESCRIPCION_EQUIPO} | ${inv.MARCA_EQUIPO} | ${inv.MODELO_EQUIPO} | ${inv.SERIE_EQUIPO} | ${inv.CODIGO_EQUIPO}</option>`
                    );
                });
        }
    });
  
  
   bloque.find(".vobo-usuario").on("change", function () {
        let selectVal = $(this).val();
        let comentarioDiv = bloque.find(".comentario-rechazada");

        if (selectVal === "No") {
            comentarioDiv.show();
            comentarioDiv.find("textarea").attr("required", true);
        } else {
            comentarioDiv.hide();
            comentarioDiv.find("textarea").removeAttr("required").val("");
        }
   });
  
  
  bloque.find(".cantidad_entraalmacen").on("input", function () {
    calcularTotales(bloque);
});
  
  


    return bloque;
}

$('#GR_PARCIAL').on('change', function () {
    if ($(this).val() === "Sí") {
        $('.bs-esparcial').css({
            'pointer-events': 'auto',
            'background-color': ''
        });
    } else {
        $('.bs-esparcial').val("").css({
            'pointer-events': 'none',
            'background-color': '#e9ecef'
        });
    }
});

$(document).on('change', '.gr_parcialjs', function () {
    if ($(this).val() === "Sí") {
        $('.bs-esparcial').css({
            'pointer-events': 'auto',
            'background-color': ''
        });
    } else {
        $('.bs-esparcial').val("").css({
            'pointer-events': 'none',
            'background-color': '#e9ecef'
        });
    }
});

$('#DescargarGR').on('click', function () {
    let idsGR = [];

    if ($(".form-gr").length > 0) {
        let activeTab = $(".tab-pane.show.active");
        if (activeTab.length > 0) {
            const id = activeTab.find('input[name="ID_GR[]"]').val();
            if (id && id !== "0") idsGR.push(id);
        } else {
            $(".form-gr").each(function () {
                const id = $(this).find('input[name="ID_GR[]"]').val();
                if (id && id !== "0") idsGR.push(id);
            });
        }
    } else {
        const id = $('#ID_GR').val();
        if (id && id !== "0") idsGR.push(id);
    }

    if (idsGR.length === 0) {
        Swal.fire('Atención', 'No hay GR generadas para descargar.', 'warning');
        return;
    }

    Swal.fire({
        title: 'Descargar PDF de Recepción (GR)',
        text: idsGR.length > 1
            ? 'Se descargarán varios archivos (uno por cada GR parcial).'
            : 'Se descargará el PDF de la GR actual.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, descargar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Verificando GR...',
                text: 'Por favor espere unos segundos',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => Swal.showLoading()
            });

            let delay = 700;

            idsGR.forEach((id, i) => {
                setTimeout(() => {
                    fetch(`/generarGRpdf/${id}`)
                        .then(async response => {
                            const contentType = response.headers.get('Content-Type') || '';

                            if (contentType.includes('application/json')) {
                                const data = await response.json();
                                Swal.fire('Atención', data.error || 'No se pudo generar el PDF.', 'warning');
                                return;
                            }
                            if (response.ok) {
                                const url = `/generarGRpdf/${id}`;
                                window.open(url, '_blank');
                            } else {
                                Swal.fire('Error', 'No se pudo generar el PDF (estado inválido).', 'error');
                            }
                        })
                        .catch(() => {
                            Swal.fire('Error', 'No se pudo conectar con el servidor.', 'error');
                        });
                }, i * delay);
            });

            setTimeout(() => Swal.close(), idsGR.length * delay + 1000);
        }
    });
});

$('#EnviarGR').on('click', function () {

    let idsGR = [];

    if ($(".form-gr").length > 0) {

        let activeTab = $(".tab-pane.show.active");

        if (activeTab.length > 0) {
            const id = activeTab.find('input[name="ID_GR[]"]').val();
            if (id && id !== "0") idsGR.push(id);
        } else {
            $(".form-gr").each(function () {
                const id = $(this).find('input[name="ID_GR[]"]').val();
                if (id && id !== "0") idsGR.push(id);
            });
        }

    } else {
        const id = $('#ID_GR').val();
        if (id && id !== "0") idsGR.push(id);
    }

    if (idsGR.length === 0) {
        Swal.fire('Atención', 'No hay GR para enviar.', 'warning');
        return;
    }

    Swal.fire({
        title: 'Enviar correo GR',
        text: 'Se notificará al proveedor',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, enviar'
    }).then((result) => {

        if (result.isConfirmed) {

            Swal.fire({
                title: 'Enviando...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            $.ajax({
                url: '/enviarCorreoGR',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    ids: idsGR
                },
                success: function (resp) {

                    if (resp.success) {
                        Swal.fire('Correcto', resp.message, 'success');
                    } else {
                        Swal.fire('Error', resp.message, 'error');
                    }

                },
                error: function () {
                    Swal.fire('Error', 'Fallo al enviar correos', 'error');
                }
            });

        }

    });

});

