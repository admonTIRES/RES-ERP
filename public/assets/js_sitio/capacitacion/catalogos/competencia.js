//VARIABLES
ID_COMPETENCIA_DESARROLLA = 0




const ModalArea = document.getElementById('miModal_competencias')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    ID_COMPETENCIA_DESARROLLA = 0
    document.getElementById('formulariocompetencia').reset();
   
    $('#miModal_competencias .modal-title').html('Nueva competencias que desarrolla');


})






$("#guardarcompetencia").click(function (e) {
    e.preventDefault();


    formularioValido = validarFormulario3($('#formulariocompetencia'))

    if (formularioValido) {

    if (ID_COMPETENCIA_DESARROLLA == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarcompetencia')
            await ajaxAwaitFormData({ api: 9, ID_COMPETENCIA_DESARROLLA: ID_COMPETENCIA_DESARROLLA }, 'CatcapacitacionSave', 'formulariocompetencia', 'guardarcompetencia', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                    ID_COMPETENCIA_DESARROLLA = data.capacitaciones.ID_COMPETENCIA_DESARROLLA
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_competencias').modal('hide')
                    document.getElementById('formulariocompetencia').reset();
                    Tablacapcompetencias.ajax.reload()
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarcompetencia')
            await ajaxAwaitFormData({ api: 9, ID_COMPETENCIA_DESARROLLA: ID_COMPETENCIA_DESARROLLA }, 'CatcapacitacionSave', 'formulariocompetencia', 'guardarcompetencia', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    ID_COMPETENCIA_DESARROLLA = data.capacitaciones.ID_COMPETENCIA_DESARROLLA
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_competencias').modal('hide')
                    document.getElementById('formulariocompetencia').reset();
                    Tablacapcompetencias.ajax.reload()

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});



var Tablacapcompetencias = $("#Tablacapcompetencias").DataTable({
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
        url: '/Tablacapcompetencias',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablacapcompetencias.columns.adjust().draw();
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
        { data: 'NOMBRE_COMPETENCIAS' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Nombre de la competencia', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Editar', className: 'all text-center' },
        { targets: 3, title: 'Visualizar', className: 'all text-center' },
        { targets: 4, title: 'Activo', className: 'all text-center' }
    ]
});





$('#Tablacapcompetencias tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacapcompetencias.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 9,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_COMPETENCIA_DESARROLLA: row.data().ID_COMPETENCIA_DESARROLLA
    };

    eliminarDatoTabla(data, [Tablacapcompetencias], 'CatcapacitacionDelete');
});



$('#Tablacapcompetencias tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacapcompetencias.row(tr);


    ID_COMPETENCIA_DESARROLLA = row.data().ID_COMPETENCIA_DESARROLLA;

    editarDatoTabla(row.data(), 'formulariocompetencia', 'miModal_competencias');

    $('#miModal_competencias .modal-title').html(row.data().NOMBRE_COMPETENCIAS);

});



$(document).ready(function() {
    $('#Tablacapcompetencias tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablacapcompetencias.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_competencias');

        ID_COMPETENCIA_DESARROLLA = row.data().ID_COMPETENCIA_DESARROLLA;
        editarDatoTabla(row.data(), 'formulariocompetencia', 'miModal_competencias');
         $('#miModal_competencias .modal-title').html(row.data().NOMBRE_COMPETENCIAS);

    });

    $('#miModal_competencias').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_competencias');
    });
});

