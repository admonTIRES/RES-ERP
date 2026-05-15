//VARIABLES
ID_PENDIENTES_CONTRATAR = 0






const ModalArea = document.getElementById('miModal_PENDIENTE')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    
    ID_PENDIENTES_CONTRATAR = 0
    document.getElementById('formularioPENDIENTE').reset();


})




var Tablapendientecontratacion = $("#Tablapendientecontratacion").DataTable({
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
        url: '/Tablapendientecontratacion',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablapendientecontratacion.columns.adjust().draw();
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
        { 
            data: null,
            render: function (data, type, row) {
                return row.NOMBRE_PC + ' ' + row.PRIMER_APELLIDO_PC + ' ' + row.SEGUNDO_APELLIDO_PC;
            }
        },
        { data: 'categoria_nombre' },
        
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_CONTRATACION' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Nombre completo', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Nombre de la vacante', className: 'all text-center nombre-column' },
        { targets: 3, title: 'Visualizar', className: 'all text-center' },
        { targets: 4, title: 'Enviar a contratación', className: 'all text-center' }

    ]
});




$(document).ready(function() {
    $('#Tablapendientecontratacion tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablapendientecontratacion.row(tr);

        

    $('#miModal_PENDIENTE .modal-title').html(row.data().NOMBRE_PC+ ' ' + row.data().PRIMER_APELLIDO_PC + ' ' +  row.data().SEGUNDO_APELLIDO_PC);

        hacerSoloLectura(row.data(), '#miModal_PENDIENTE');

        ID_PENDIENTES_CONTRATAR = row.data().ID_PENDIENTES_CONTRATAR;
        editarDatoTabla(row.data(), 'formularioPENDIENTE', 'miModal_PENDIENTE',1);
    });

    $('#miModal_PENDIENTE').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_PENDIENTE');
    });
});




$(document).on('click', '.GUARDAR', function () {
    const curp = $(this).data('curp');
    const nombre = $(this).data('nombre');
    const primerApellido = $(this).data('primer-apellido');
    const segundoApellido = $(this).data('segundo-apellido');
    const dia = $(this).data('dia');
    const mes = $(this).data('mes');
    const anio = $(this).data('anio');

    Swal.fire({
        title: 'Fecha de ingreso requerida',
        html: `
            <div class="row mb-3">
                <div class="col-12">
                    <label>Fecha ingreso *</label>
                    <div class="input-group">
                        <input type="text" class="form-control mydatepicker" placeholder="aaaa-mm-dd" id="FECHA_INGRESO" name="FECHA_INGRESO" required>
                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                    </div>
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Enviar',
        cancelButtonText: 'Cancelar',
        didOpen: () => {
            $('.mydatepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
                language: 'es' 

            });
        },
        preConfirm: () => {
            const fechaIngreso = document.getElementById('FECHA_INGRESO').value;
            if (!fechaIngreso) {
                Swal.showValidationMessage('Por favor, ingrese una fecha válida.');
            }
            return fechaIngreso;
        },
    }).then((result) => {
        if (result.isConfirmed) {
            const fechaIngreso = result.value;

            $.ajax({
                url: '/mandarcontratacion',
                method: 'POST',
                data: {
                    CURP: curp,
                    NOMBRE_PC: nombre,
                    PRIMER_APELLIDO_PC: primerApellido,
                    SEGUNDO_APELLIDO_PC: segundoApellido,
                    DIA_FECHA_PC: dia,
                    MES_FECHA_PC: mes,
                    ANIO_FECHA_PC: anio,
                    FECHA_INGRESO: fechaIngreso, 
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'Aceptar',
                    }).then(() => {
                        Tablapendientecontratacion.ajax.reload()
                    });
                },
                error: function (xhr) {
                    Swal.fire({
                        title: 'Error',
                        text: xhr.responseJSON?.message || 'Ocurrió un error inesperado.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar',
                    });
                },
            });
        }
    });
});
