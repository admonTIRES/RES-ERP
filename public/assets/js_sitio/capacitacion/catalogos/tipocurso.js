//VARIABLES
ID_TIPO_CURSO = 0




const ModalArea = document.getElementById('miModal_tipocurso')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    
    ID_TIPO_CURSO = 0
    document.getElementById('formulariotipocurso').reset();
   
    $('#miModal_tipocurso .modal-title').html('Nuevo tipo de curso');


})






$("#guardartipocurso").click(function (e) {
    e.preventDefault();


    formularioValido = validarFormulario3($('#formulariotipocurso'))

    if (formularioValido) {

    if (ID_TIPO_CURSO == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardartipocurso')
            await ajaxAwaitFormData({ api: 1, ID_TIPO_CURSO: ID_TIPO_CURSO }, 'CatcapacitacionSave', 'formulariotipocurso', 'guardartipocurso', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                    ID_TIPO_CURSO = data.capacitaciones.ID_TIPO_CURSO
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_tipocurso').modal('hide')
                    document.getElementById('formulariotipocurso').reset();
                    Tablacaptipocurso.ajax.reload()

           
                
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardartipocurso')
            await ajaxAwaitFormData({ api: 1, ID_TIPO_CURSO: ID_TIPO_CURSO }, 'CatcapacitacionSave', 'formulariotipocurso', 'guardartipocurso', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_TIPO_CURSO = data.capacitaciones.ID_TIPO_CURSO
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_tipocurso').modal('hide')
                    document.getElementById('formulariotipocurso').reset();
                    Tablacaptipocurso.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});



var Tablacaptipocurso = $("#Tablacaptipocurso").DataTable({
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
        url: '/Tablacaptipocurso',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablacaptipocurso.columns.adjust().draw();
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
        { data: 'TIPO_CURSO' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Tipo de curso', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Editar', className: 'all text-center' },
        { targets: 3, title: 'Visualizar', className: 'all text-center' },
        { targets: 4, title: 'Activo', className: 'all text-center' }
    ]
});





$('#Tablacaptipocurso tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacaptipocurso.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_TIPO_CURSO: row.data().ID_TIPO_CURSO
    };

    eliminarDatoTabla(data, [Tablacaptipocurso], 'CatcapacitacionDelete');
});



$('#Tablacaptipocurso tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacaptipocurso.row(tr);


    ID_TIPO_CURSO = row.data().ID_TIPO_CURSO;

    editarDatoTabla(row.data(), 'formulariotipocurso', 'miModal_tipocurso');

    $('#miModal_tipocurso .modal-title').html(row.data().TIPO_CURSO);

});



$(document).ready(function() {
    $('#Tablacaptipocurso tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablacaptipocurso.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_tipocurso');

        ID_TIPO_CURSO = row.data().ID_TIPO_CURSO;
        editarDatoTabla(row.data(), 'formulariotipocurso', 'miModal_tipocurso');
         $('#miModal_tipocurso .modal-title').html(row.data().TIPO_CURSO);

    });

    $('#miModal_tipocurso').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_tipocurso');
    });
});

