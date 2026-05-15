


document.addEventListener("DOMContentLoaded", function () {
    deshabilitarOpcionesTipoDocumento();
});



ID_FORMULARIO_DOCUMENTOSPROVEEDOR = 0



const Modaldocumentos = document.getElementById('miModal_documentos');

Modaldocumentos.addEventListener('hidden.bs.modal', event => {

    ID_FORMULARIO_DOCUMENTOSPROVEEDOR = 0;

    document.getElementById('formularioDOCUMENTOS').reset();

    $('#TIPO_DOCUMENTO_PROVEEDOR').prop('disabled', false); 
    $('#DOCUMENTO_SOPORTE').prop('required', true); 
  

    document.getElementById('DOCUMENTO_SOPORTE').value = '';
    document.getElementById('iconEliminarArchivo').classList.add('d-none');
    $('#miModal_documentos .modal-title').html('Nuevo documento');
 
});





function deshabilitarOpcionesTipoDocumento() {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('/documentosRegistrados', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(idsRegistrados => {
        const select = document.getElementById('TIPO_DOCUMENTO_PROVEEDOR');
        if (!select) return;

        for (let i = 0; i < select.options.length; i++) {
            const option = select.options[i];
            const valor = option.value;

            if (idsRegistrados.includes(valor)) {
                option.disabled = true;
                option.style.color = 'green';
                option.style.fontWeight = 'bold';
            }
        }
    })
    .catch(error => {
        console.error('Error al obtener documentos registrados:', error);
    });
}


$("#guardarDOCUMENTOS").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioDOCUMENTOS'))

    if (formularioValido) {

    if (ID_FORMULARIO_DOCUMENTOSPROVEEDOR == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarDOCUMENTOS')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_DOCUMENTOSPROVEEDOR: ID_FORMULARIO_DOCUMENTOSPROVEEDOR }, 'AltaDocumentosSave', 'formularioDOCUMENTOS', 'guardarDOCUMENTOS', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_FORMULARIO_DOCUMENTOSPROVEEDOR = data.cuenta.ID_FORMULARIO_DOCUMENTOSPROVEEDOR
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_documentos').modal('hide')
                    document.getElementById('formularioDOCUMENTOS').reset();
                    Tabladocumentosproveedores.ajax.reload()

                    deshabilitarOpcionesTipoDocumento();
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarDOCUMENTOS')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_DOCUMENTOSPROVEEDOR: ID_FORMULARIO_DOCUMENTOSPROVEEDOR }, 'AltaDocumentosSave', 'formularioDOCUMENTOS', 'guardarDOCUMENTOS', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_FORMULARIO_DOCUMENTOSPROVEEDOR = data.cuenta.ID_FORMULARIO_DOCUMENTOSPROVEEDOR
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_documentos').modal('hide')
                    document.getElementById('formularioDOCUMENTOS').reset();
                    Tabladocumentosproveedores.ajax.reload()

                    deshabilitarOpcionesTipoDocumento();

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});



var Tabladocumentosproveedores = $("#Tabladocumentosproveedores").DataTable({
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
    destroy: true,
    ajax: {
        dataType: 'json',
        data: {},
        method: 'GET',
        cache: false,
        url: '/Tabladocumentosproveedores',
        beforeSend: function () {
            $('#loadingIcon1').css('display', 'inline-block');
        },
        complete: function () {
            $('#loadingIcon1').css('display', 'none');
            Tabladocumentosproveedores.columns.adjust().draw(); 
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('#loadingIcon1').css('display', 'none');
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
        { data: 'NOMBRE_DOCUMENTO_PROVEEEDOR' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_DOCUMENTO' },
         { data: 'BTN_ACTUALIZAR' }, 

    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Nombre del documento ', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Editar', className: 'all text-center' },
        { targets: 3, title: 'Visualizar', className: 'all text-center' },
        { targets: 4, title: 'Documento', className: 'all text-center' },
        { targets: 5, title: 'Actualizar', className: 'all text-center' },

    ]
});




$(document).on('click','.ACTUALIZAR_DOC',function(){

let id=$(this).data('id')
let tipo=$(this).data('tipo')

$('#ID_FORMULARIO_DOCUMENTOSPROVEEDOR').val(id)
$('#TIPO_DOCUMENTO_PROVEEDOR_ACT').val(tipo)

$('#modalActualizarDocumento').modal('show')

})


$('#guardarActualizacionDoc').click(function(){

let formData = new FormData($('#formActualizarDocumento')[0]);

let token = $('meta[name="csrf-token"]').attr('content');

$.ajax({

    url:'/actualizarDocumentoProveedor',
    type:'POST',

    headers:{
        'X-CSRF-TOKEN': token
    },

    data:formData,
    processData:false,
    contentType:false,

    success:function(response){

        if(response.status=="success"){

            Swal.fire({
                icon:'success',
                title:'Correcto',
                text:response.message
            })

            $('#modalActualizarDocumento').modal('hide')

            tablaDocumentos.ajax.reload()

        }else{

            Swal.fire({
                icon:'warning',
                title:'Aviso',
                text:response.message
            })

        }

    }

})

})

$('#Tabladocumentosproveedores').on('click', '.ver-archivo-documentosoporte', function () {
    var tr = $(this).closest('tr');
    var row = Tabladocumentosproveedores.row(tr);
    var id = $(this).data('id');

    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }

    var nombreDocumentoSoporte = row.data().NOMBRE_DOCUMENTO;
    var url = '/mostrardocumentosoporteproveedor/' + id;
    
    abrirModal(url, nombreDocumentoSoporte);
});





$('#Tabladocumentosproveedores tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tabladocumentosproveedores.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_FORMULARIO_DOCUMENTOSPROVEEDOR: row.data().ID_FORMULARIO_DOCUMENTOSPROVEEDOR
    };

    eliminarDatoTabla(data, [Tabladocumentosproveedores], 'DocumentosDelete');
});


$('#Tabladocumentosproveedores tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tabladocumentosproveedores.row(tr);

    ID_FORMULARIO_DOCUMENTOSPROVEEDOR = row.data().ID_FORMULARIO_DOCUMENTOSPROVEEDOR;

    editarDatoTabla(row.data(), 'formularioDOCUMENTOS', 'miModal_documentos', 1);


    $('#TIPO_DOCUMENTO_PROVEEDOR').prop('disabled',true ); 


$('#DOCUMENTO_SOPORTE').removeAttr('required');



    $('#miModal_documentos .modal-title').html(row.data().NOMBRE_DOCUMENTO_PROVEEEDOR);
    


  
});





$(document).ready(function() {
    $('#Tabladocumentosproveedores tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tabladocumentosproveedores.row(tr);
        
        hacerSoloLectura2(row.data(), '#miModal_documentos');

        ID_FORMULARIO_DOCUMENTOSPROVEEDOR = row.data().ID_FORMULARIO_DOCUMENTOSPROVEEDOR;
        editarDatoTabla(row.data(), 'formularioDOCUMENTOS', 'miModal_documentos', 1);
    $('#miModal_documentos .modal-title').html(row.data().NOMBRE_DOCUMENTO_PROVEEEDOR);
        
       
    
    });


    $('#miModal_documentos').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_documentos');
    });
});








const inputArchivo = document.getElementById('DOCUMENTO_SOPORTE');
const iconEliminar = document.getElementById('iconEliminarArchivo');

inputArchivo.addEventListener('change', function () {
    if (this.files.length > 0) {
        iconEliminar.classList.remove('d-none');
    } else {
        iconEliminar.classList.add('d-none');
    }
});

iconEliminar.addEventListener('click', function () {
    inputArchivo.value = '';
    iconEliminar.classList.add('d-none');
});



document.addEventListener("DOMContentLoaded", function () {
    const selectTipoDocumento = document.getElementById("TIPO_DOCUMENTO_PROVEEDOR");
    const inputNombreDocumento = document.getElementById("NOMBRE_DOCUMENTO_PROVEEEDOR");

    selectTipoDocumento.addEventListener("change", function () {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption && selectedOption.value) {
            inputNombreDocumento.value = selectedOption.text.trim();
        } else {
            inputNombreDocumento.value = "";
        }
    });
});