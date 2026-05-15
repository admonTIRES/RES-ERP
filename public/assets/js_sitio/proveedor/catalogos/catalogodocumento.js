//VARIABLES
ID_CATALOGO_DOCUMENTOSPROVEEDOR = 0




const ModalArea = document.getElementById('miModal_documentos')
ModalArea.addEventListener('hidden.bs.modal', event => {
    
    
    ID_CATALOGO_DOCUMENTOSPROVEEDOR = 0
    document.getElementById('formularioDOCUMENTOS').reset();
   

    $('#miModal_documentos .modal-title').html('Agregar documentos de soporte');


})






$("#guardarDOCUMENTO").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioDOCUMENTOS'))

    if (formularioValido) {

    if (ID_CATALOGO_DOCUMENTOSPROVEEDOR == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarDOCUMENTO')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_DOCUMENTOSPROVEEDOR: ID_CATALOGO_DOCUMENTOSPROVEEDOR }, 'DocumentosSave', 'formularioDOCUMENTOS', 'guardarDOCUMENTO', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                    ID_CATALOGO_DOCUMENTOSPROVEEDOR = data.documento.ID_CATALOGO_DOCUMENTOSPROVEEDOR
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_documentos').modal('hide')
                    document.getElementById('formularioDOCUMENTOS').reset();
                    Tabladocumentosoportes.ajax.reload()

           
                
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarDOCUMENTO')
            await ajaxAwaitFormData({ api: 1, ID_CATALOGO_DOCUMENTOSPROVEEDOR: ID_CATALOGO_DOCUMENTOSPROVEEDOR }, 'DocumentosSave', 'formularioDOCUMENTOS', 'guardarDOCUMENTO', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_CATALOGO_DOCUMENTOSPROVEEDOR = data.documento.ID_CATALOGO_DOCUMENTOSPROVEEDOR
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_documentos').modal('hide')
                    document.getElementById('formularioDOCUMENTOS').reset();
                    Tabladocumentosoportes.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});



var Tabladocumentosoportes = $("#Tabladocumentosoportes").DataTable({
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
        url: '/Tabladocumentosoportes',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tabladocumentosoportes.columns.adjust().draw();
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
        { data: 'NOMBRE_DOCUMENTO' },
        { data: 'TIPO_PERSONA_TEXTO' },
        { data: 'TIPO_PERSONA_OPCION_TEXTO' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Nombre del documento', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Tipo de Proveedor', className: 'all text-center nombre-column' },
        { targets: 3, title: 'Tipo de Persona', className: 'all text-center nombre-column' },
        { targets: 4, title: 'Editar', className: 'all text-center' },
        { targets: 5, title: 'Visualizar', className: 'all text-center' },
        { targets: 6, title: 'Activo', className: 'all text-center' }
    ]
});





$('#Tabladocumentosoportes tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tabladocumentosoportes.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_CATALOGO_DOCUMENTOSPROVEEDOR: row.data().ID_CATALOGO_DOCUMENTOSPROVEEDOR
    };

    eliminarDatoTabla(data, [Tabladocumentosoportes], 'DocumentosDeleteProveedor');
});



$('#Tabladocumentosoportes tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tabladocumentosoportes.row(tr);
    ID_CATALOGO_DOCUMENTOSPROVEEDOR = row.data().ID_CATALOGO_DOCUMENTOSPROVEEDOR;

    editarDatoTabla(row.data(), 'formularioDOCUMENTOS', 'miModal_documentos',1);
    $('#miModal_documentos .modal-title').html(row.data().NOMBRE_DOCUMENTO);



});



$(document).ready(function() {
    $('#Tabladocumentosoportes tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tabladocumentosoportes.row(tr);
        
        hacerSoloLectura(row.data(), '#miModal_documentos');

        ID_CATALOGO_DOCUMENTOSPROVEEDOR = row.data().ID_CATALOGO_DOCUMENTOSPROVEEDOR;
        editarDatoTabla(row.data(), 'formularioDOCUMENTOS', 'miModal_documentos', 1);
    $('#miModal_documentos .modal-title').html(row.data().NOMBRE_DOCUMENTO);
        

    });

    $('#miModal_documentos').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_documentos');
    });
});

