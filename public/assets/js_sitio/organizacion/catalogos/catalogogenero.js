//VARIABLES
ID_CATALOGO_GENERO = 0




const ModalArea = document.getElementById('miModal_Genero')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    
    ID_CATALOGO_GENERO = 0
    document.getElementById('formularioGenero').reset();
   

    $('#miModal_Genero .modal-title').html('Agregar género');



})






$("#guardarFormGENERO").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioGenero'))

    if (formularioValido) {

    if (ID_CATALOGO_GENERO == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormGENERO')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_GENERO: ID_CATALOGO_GENERO }, 'GeneroSave', 'formularioGenero', 'guardarFormGENERO', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                    ID_CATALOGO_GENERO = data.genero.ID_CATALOGO_GENERO
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_Genero').modal('hide')
                    document.getElementById('formularioGenero').reset();
                    Tablageneros.ajax.reload()

           
                
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormGENERO')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_GENERO: ID_CATALOGO_GENERO }, 'GeneroSave', 'formularioGenero', 'guardarFormGENERO', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_CATALOGO_GENERO = data.genero.ID_CATALOGO_GENERO
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                    $('#miModal_Genero').modal('hide')
                    document.getElementById('formularioGenero').reset();
                    Tablageneros.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});


var Tablageneros = $("#Tablageneros").DataTable({
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
        url: '/Tablageneros',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablageneros.columns.adjust().draw();
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
        { data: 'NOMBRE_GENERO' },
        { data: 'DESCRIPCION_GENERO' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [ 
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Nombre', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Descripción', className: 'all text-center descripcion-column' },
        { targets: 3, title: 'Editar', className: 'all text-center' },
        { targets: 4, title: 'Visualizar', className: 'all text-center' },
        { targets: 5, title: 'Activo', className: 'all text-center' }
    ]
});


$('#Tablageneros tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablageneros.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_CATALOGO_GENERO: row.data().ID_CATALOGO_GENERO
    };

    eliminarDatoTabla(data, [Tablageneros], 'GeneroDelete');
});



$('#Tablageneros tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablageneros.row(tr);
    ID_CATALOGO_GENERO = row.data().ID_CATALOGO_GENERO;

    editarDatoTabla(row.data(), 'formularioGenero', 'miModal_Genero');

    $('#miModal_Genero .modal-title').html(row.data().NOMBRE_GENERO);

});





$(document).ready(function() {
    $('#Tablageneros tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablageneros.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_Genero');

        ID_CATALOGO_GENERO = row.data().ID_CATALOGO_GENERO;
        editarDatoTabla(row.data(), 'formularioGenero', 'miModal_Genero',1);

    $('#miModal_Genero .modal-title').html(row.data().NOMBRE_GENERO);

    });

    $('#miModal_Genero').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_Genero');
    });
});

