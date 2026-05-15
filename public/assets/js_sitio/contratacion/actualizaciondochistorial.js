ID_ACTUALIZACION_DOCUMENTOS = 0



var actualizacion_id = null;














var Tabladocumentosactualizadohistorial = $("#Tabladocumentosactualizadohistorial").DataTable({
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
        url: '/Tabladocumentosactualizadohistorial',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tabladocumentosactualizadohistorial.columns.adjust().draw();
            ocultarCarga();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
    order: [[0, 'asc']],
      columns: [
        { data: null, render: function (data, type, row, meta) { return meta.row + 1; }, className: 'text-center' },
        { data: 'NOMBRE_COMPLETO', className: 'text-center' },
        { data: 'NOMBRE_DOCUMENTO', className: 'text-center' },  
        { data: 'BTN_DOCUMENTO' }, 
        { data: 'BTN_EDITAR' },

        ],
        columnDefs: [
            { targets: 0, title: '#', className: 'all text-center' },
            { targets: 1, title: 'Nombre del colaborador', className: 'all text-center' },  
            { targets: 2, title: 'Nombre del documento', className: 'all text-center' },  
            { targets: 3, title: 'Documento actualizado', className: 'all text-center' },  
            { targets: 4, title: 'Visualizar', className: 'all text-center' }
        ]
});



const Modaldocumentosoporte = document.getElementById('miModal_DOCUMENTOS_SOPORTE')
Modaldocumentosoporte.addEventListener('hidden.bs.modal', event => {
    
    ID_DOCUMENTOS_ACTUALIZADOS = 0
    
    document.getElementById('formularioDOCUMENTOS').reset();
   
    $('#miModal_DOCUMENTOS_SOPORTE .modal-title').html('Documento de soporte');

    $('#NOMBRE_DOCUMENTO').prop('readonly', false); 




    document.getElementById('FECHAS_SOPORTEDOCUMENTOS').style.display = 'none';


    actualizacion_id = 0; 

})


document.addEventListener('DOMContentLoaded', function () {

    const contenedorFechas = document.getElementById('FECHAS_SOPORTEDOCUMENTOS');

    document.querySelectorAll('input[name="PROCEDE_FECHA_DOC"]').forEach(function (radio) {
        radio.addEventListener('change', function () {

            if (this.value === "1") {
                contenedorFechas.style.display = 'block';
            } else {
                contenedorFechas.style.display = 'none';
            }

        });
    });

});


document.addEventListener('DOMContentLoaded', function() {
    var archivoSoporte = document.getElementById('DOCUMENTO_SOPORTE');
    var quitarSoporte = document.getElementById('quitar_documento');
    var errorElement = document.getElementById('DOCUMENTO_ERROR');

    if (archivoSoporte) {
        archivoSoporte.addEventListener('change', function() {
            var archivo = this.files[0];
            if (archivo && archivo.type === 'application/pdf') {
                if (errorElement) errorElement.style.display = 'none';
                if (quitarSoporte) quitarSoporte.style.display = 'block';
            } else {
                if (errorElement) errorElement.style.display = 'block';
                this.value = '';
                if (quitarSoporte) quitarSoporte.style.display = 'none';
            }
        });
        quitarSoporte.addEventListener('click', function() {
            archivoSoporte.value = ''; 
            quitarSoporte.style.display = 'none'; 
            if (errorElement) errorElement.style.display = 'none'; 
        });
    }
});


$('#Tabladocumentosactualizadohistorial').on('click', '.ver-archivo-documentosactualizados', function () {
    var tr = $(this).closest('tr');
    var row = Tabladocumentosactualizadohistorial.row(tr);
    var id = $(this).data('id');

    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }

    var nombreDocumentoSoporte = row.data().NOMBRE_DOCUMENTO;
    var url = '/mostrardocumentoactualizado/' + id;
    
    abrirModal(url, nombreDocumentoSoporte);
});




$('#Tabladocumentosactualizadohistorial').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tabladocumentosactualizadohistorial.row(tr);

    ID_DOCUMENTOS_ACTUALIZADOS = row.data().ID_DOCUMENTOS_ACTUALIZADOS;

    actualizacion_id = row.data().ID_DOCUMENTOS_ACTUALIZADOS;

    editarDatoTabla(row.data(), 'formularioDOCUMENTOS', 'miModal_DOCUMENTOS_SOPORTE', 1);

    $('#miModal_DOCUMENTOS_SOPORTE .modal-title').html(row.data().NOMBRE_DOCUMENTO);

    $('#NOMBRE_DOCUMENTO').prop('readonly', true); 

    if (row.data().PROCEDE_FECHA_DOC === "1") {
        $('#FECHAS_SOPORTEDOCUMENTOS').show();
    } else {
        $('#FECHAS_SOPORTEDOCUMENTOS').hide();
    }


});




