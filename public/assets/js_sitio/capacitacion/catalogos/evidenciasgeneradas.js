//VARIABLES
ID_EVIDENCIA_GENERADAS = 0




const ModalArea = document.getElementById('miModal_evidenciasgeneradas')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    ID_EVIDENCIA_GENERADAS = 0
    document.getElementById('formularioevidenciasgeneradas').reset();
   
    $('#miModal_evidenciasgeneradas .modal-title').html('Nueva evidencias generada');


})






$("#guardarevidenciasgeneradas").click(function (e) {
    e.preventDefault();


    formularioValido = validarFormulario3($('#formularioevidenciasgeneradas'))

    if (formularioValido) {

    if (ID_EVIDENCIA_GENERADAS == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarevidenciasgeneradas')
            await ajaxAwaitFormData({ api: 12, ID_EVIDENCIA_GENERADAS: ID_EVIDENCIA_GENERADAS }, 'CatcapacitacionSave', 'formularioevidenciasgeneradas', 'guardarevidenciasgeneradas', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                    ID_EVIDENCIA_GENERADAS = data.capacitaciones.ID_EVIDENCIA_GENERADAS
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_evidenciasgeneradas').modal('hide')
                    document.getElementById('formularioevidenciasgeneradas').reset();
                    Tablacapevidenciasgeneradas.ajax.reload()
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarevidenciasgeneradas')
            await ajaxAwaitFormData({ api: 12, ID_EVIDENCIA_GENERADAS: ID_EVIDENCIA_GENERADAS }, 'CatcapacitacionSave', 'formularioevidenciasgeneradas', 'guardarevidenciasgeneradas', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    ID_EVIDENCIA_GENERADAS = data.capacitaciones.ID_EVIDENCIA_GENERADAS
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_evidenciasgeneradas').modal('hide')
                    document.getElementById('formularioevidenciasgeneradas').reset();
                    Tablacapevidenciasgeneradas.ajax.reload()

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});



var Tablacapevidenciasgeneradas = $("#Tablacapevidenciasgeneradas").DataTable({
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
        url: '/Tablacapevidenciasgeneradas',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablacapevidenciasgeneradas.columns.adjust().draw();
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
        { data: 'NOMBRE_EVIDENCIA' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Nombre de la evidencia', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Editar', className: 'all text-center' },
        { targets: 3, title: 'Visualizar', className: 'all text-center' },
        { targets: 4, title: 'Activo', className: 'all text-center' }
    ]
});





$('#Tablacapevidenciasgeneradas tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacapevidenciasgeneradas.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 12,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_EVIDENCIA_GENERADAS: row.data().ID_EVIDENCIA_GENERADAS
    };

    eliminarDatoTabla(data, [Tablacapevidenciasgeneradas], 'CatcapacitacionDelete');
});



$('#Tablacapevidenciasgeneradas tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacapevidenciasgeneradas.row(tr);


    ID_EVIDENCIA_GENERADAS = row.data().ID_EVIDENCIA_GENERADAS;

    editarDatoTabla(row.data(), 'formularioevidenciasgeneradas', 'miModal_evidenciasgeneradas');

    $('#miModal_evidenciasgeneradas .modal-title').html(row.data().NOMBRE_EVIDENCIA);

});



$(document).ready(function() {
    $('#Tablacapevidenciasgeneradas tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablacapevidenciasgeneradas.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_evidenciasgeneradas');

        ID_EVIDENCIA_GENERADAS = row.data().ID_EVIDENCIA_GENERADAS;
        editarDatoTabla(row.data(), 'formularioevidenciasgeneradas', 'miModal_evidenciasgeneradas');
         $('#miModal_evidenciasgeneradas .modal-title').html(row.data().NOMBRE_EVIDENCIA);

    });

    $('#miModal_evidenciasgeneradas').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_evidenciasgeneradas');
    });
});

