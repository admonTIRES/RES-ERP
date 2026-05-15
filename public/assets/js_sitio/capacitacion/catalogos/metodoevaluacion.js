//VARIABLES
ID_METODO_EVALUACION = 0




const ModalArea = document.getElementById('miModal_metodoevaluacion')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    ID_METODO_EVALUACION = 0
    document.getElementById('formulariometodoevaluacion').reset();
   
    $('#miModal_metodoevaluacion .modal-title').html('Nuevo método de evaluación');


})






$("#guardarmetodoevaluacion").click(function (e) {
    e.preventDefault();


    formularioValido = validarFormulario3($('#formulariometodoevaluacion'))

    if (formularioValido) {

    if (ID_METODO_EVALUACION == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarmetodoevaluacion')
            await ajaxAwaitFormData({ api: 11, ID_METODO_EVALUACION: ID_METODO_EVALUACION }, 'CatcapacitacionSave', 'formulariometodoevaluacion', 'guardarmetodoevaluacion', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                    ID_METODO_EVALUACION = data.capacitaciones.ID_METODO_EVALUACION
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_metodoevaluacion').modal('hide')
                    document.getElementById('formulariometodoevaluacion').reset();
                    Tablacapmetodoevaluacion.ajax.reload()
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarmetodoevaluacion')
            await ajaxAwaitFormData({ api: 11, ID_METODO_EVALUACION: ID_METODO_EVALUACION }, 'CatcapacitacionSave', 'formulariometodoevaluacion', 'guardarmetodoevaluacion', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    ID_METODO_EVALUACION = data.capacitaciones.ID_METODO_EVALUACION
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_metodoevaluacion').modal('hide')
                    document.getElementById('formulariometodoevaluacion').reset();
                    Tablacapmetodoevaluacion.ajax.reload()

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});



var Tablacapmetodoevaluacion = $("#Tablacapmetodoevaluacion").DataTable({
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
        url: '/Tablacapmetodoevaluacion',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablacapmetodoevaluacion.columns.adjust().draw();
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
        { data: 'METODO_EVALUACION' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Método de evaluación', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Editar', className: 'all text-center' },
        { targets: 3, title: 'Visualizar', className: 'all text-center' },
        { targets: 4, title: 'Activo', className: 'all text-center' }
    ]
});





$('#Tablacapmetodoevaluacion tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacapmetodoevaluacion.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 11,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_METODO_EVALUACION: row.data().ID_METODO_EVALUACION
    };

    eliminarDatoTabla(data, [Tablacapmetodoevaluacion], 'CatcapacitacionDelete');
});



$('#Tablacapmetodoevaluacion tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacapmetodoevaluacion.row(tr);


    ID_METODO_EVALUACION = row.data().ID_METODO_EVALUACION;

    editarDatoTabla(row.data(), 'formulariometodoevaluacion', 'miModal_metodoevaluacion');

    $('#miModal_metodoevaluacion .modal-title').html(row.data().METODO_EVALUACION);

});



$(document).ready(function() {
    $('#Tablacapmetodoevaluacion tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablacapmetodoevaluacion.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_metodoevaluacion');

        ID_METODO_EVALUACION = row.data().ID_METODO_EVALUACION;
        editarDatoTabla(row.data(), 'formulariometodoevaluacion', 'miModal_metodoevaluacion');
         $('#miModal_metodoevaluacion .modal-title').html(row.data().METODO_EVALUACION);

    });

    $('#miModal_metodoevaluacion').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_metodoevaluacion');
    });
});

