var Tablalistacontratosproveedores = $("#Tablalistacontratosproveedores").DataTable({
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
        url: '/Tablalistacontratosproveedores',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablalistacontratosproveedores.columns.adjust().draw();
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
            { data: 'NUMERO_CONTRATO_PROVEEDOR' },
            { data: 'RFC_PROVEEDOR_TEXTO' },
            { 
                data: null,
               render: function(data, type, row) {

                    function parseFechaLocal(fechaStr) {
                        let partes = fechaStr.split('-');
                        return new Date(partes[0], partes[1] - 1, partes[2]);
                    }

                    let fechaInicio = parseFechaLocal(row.FECHAI_CONTRATO_PROVEEDOR);
                    let fechaFin = parseFechaLocal(row.FECHAF_CONTRATO_PROVEEDOR);
                    let hoy = new Date();

                    fechaInicio.setHours(0,0,0,0);
                    fechaFin.setHours(0,0,0,0);
                    hoy.setHours(0,0,0,0);

                    let totalDias = (fechaFin - fechaInicio) / (1000 * 60 * 60 * 24);
                    let diasRestantes = Math.floor((fechaFin - hoy) / (1000 * 60 * 60 * 24));

                    if (diasRestantes < 0) diasRestantes = 0;

                    let porcentaje = 100;

                    if (totalDias > 0) {
                        let diasConsumidos = totalDias - diasRestantes;
                        porcentaje = (diasConsumidos / totalDias) * 100;
                    }

                    let estadoHTML = "";
                    let color = "";

                    if (hoy > fechaFin) {
                        estadoHTML = "<span style='color:red;'>(Terminado)</span>";
                    } 
                    else if (diasRestantes === 0) {
                        estadoHTML = "<span style='color:red;'>(Hoy vence)</span>";
                    }
                    else {

                        if (porcentaje <= 40) {
                            color = "green";
                        } else if (porcentaje <= 70) {
                            color = "orange";
                        } else {
                            color = "red";
                        }

                        estadoHTML = `<span style='color:${color};'>(${diasRestantes} días restantes)</span>`;
                    }

                    return `
                        <div>
                            ${row.FECHAI_CONTRATO_PROVEEDOR} <br> ${row.FECHAF_CONTRATO_PROVEEDOR}
                            <br>
                            ${estadoHTML}
                        </div>
                    `;
                }
            },
            { data: 'BTN_DOCUMENTO' },
        ],
            columnDefs: [
            { targets: 0, title: '#', className: 'all text-center' },
            { targets: 1, title: 'No de contrato', className: 'all text-center' },
            { targets: 2, title: 'Proveedor', className: 'all text-center' },
            { targets: 3, title: 'Vigencia del contrato', className: 'all text-center' },
            { targets: 4, title: 'Contrato', className: 'all text-center' },
        ]
});




$('#Tablalistacontratosproveedores').on('click', '.ver-archivo-contrato', function () {
    var tr = $(this).closest('tr');
    var row = Tablalistacontratosproveedores.row(tr).data();
    var id = $(this).data('id');

    if (!id || !row.DOCUMENTO_CONTRATO_PROVEEDOR || row.DOCUMENTO_CONTRATO_PROVEEDOR.trim() === "") {
        Swal.fire({
            icon: 'warning',
            title: 'Sin documento',
            text: 'Este registro no tiene documento.',
        });
        return;
    }

    var url = '/mostrarcontratoproveedor/' + id;
    window.open(url, '_blank');
});