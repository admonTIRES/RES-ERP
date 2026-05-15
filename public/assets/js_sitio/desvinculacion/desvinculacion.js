
ID_FORMULARIO_DESVINCULACION = 0



const ModalDesvinculacion = document.getElementById('miModal_DESVINCULACION');
ModalDesvinculacion.addEventListener('hidden.bs.modal', event => {
    
    ID_FORMULARIO_DESVINCULACION = 0

    document.getElementById('formularioDESVINCULACION').reset();
    $('#miModal_DESVINCULACION .modal-title').html('Desvinculación');

   
    document.getElementById('quitar_documento1').style.display = 'none';
    document.getElementById('DOCUMENTO_ERROR1').style.display = 'none';

    document.getElementById('quitar_documento2').style.display = 'none';
    document.getElementById('DOCUMENTO_ERROR2').style.display = 'none';

    document.getElementById('quitar_documento3').style.display = 'none';
    document.getElementById('DOCUMENTO_ERROR3').style.display = 'none';

});




$(document).ready(function () {
    var selectizeInstance = $('#CURP').selectize({
        placeholder: 'Seleccione un colaborador',
        allowEmptyOption: true,
        closeAfterSelect: true,
    });

    $("#nuevo_desvinculacion").click(function (e) {
        e.preventDefault();
        $("#miModal_DESVINCULACION").modal("show");

        var selectize = selectizeInstance[0].selectize;
        selectize.clear(); 
    });
});




document.addEventListener('DOMContentLoaded', function() {
    var archivo1 = document.getElementById('DOCUMENTO_ADEUDO');
    var quitar1 = document.getElementById('quitar_documento1');
    var error1 = document.getElementById('DOCUMENTO_ERROR1');

    if (archivo1) {
        archivo1.addEventListener('change', function() {
            var archivomedica = this.files[0];
            if (archivomedica && archivomedica.type === 'application/pdf') {
                if (error1) error1.style.display = 'none';
                if (quitar1) quitar1.style.display = 'block';
            } else {
                if (error1) error1.style.display = 'block';
                this.value = '';
                if (quitar1) quitar1.style.display = 'none';
            }
        });
        quitar1.addEventListener('click', function() {
            archivo1.value = ''; 
            quitar1.style.display = 'none'; 
            if (error1) error1.style.display = 'none'; 
        });
    }
});




document.addEventListener('DOMContentLoaded', function() {
    var archivo2 = document.getElementById('DOCUMENTO_BAJA');
    var quitar2 = document.getElementById('quitar_documento2');
    var error2 = document.getElementById('DOCUMENTO_ERROR2');

    if (archivo2) {
        archivo2.addEventListener('change', function() {
            var archivomedica = this.files[0];
            if (archivomedica && archivomedica.type === 'application/pdf') {
                if (error2) error2.style.display = 'none';
                if (quitar2) quitar2.style.display = 'block';
            } else {
                if (error2) error2.style.display = 'block';
                this.value = '';
                if (quitar2) quitar2.style.display = 'none';
            }
        });
        quitar2.addEventListener('click', function() {
            archivo2.value = ''; 
            quitar1.style.display = 'none'; 
            if (error2) error2.style.display = 'none'; 
        });
    }
});




document.addEventListener('DOMContentLoaded', function() {
    var archivo3 = document.getElementById('DOCUMENTO_CONVENIO');
    var quitar3 = document.getElementById('quitar_documento3');
    var error3 = document.getElementById('DOCUMENTO_ERROR3');

    if (archivo3) {
        archivo3.addEventListener('change', function() {
            var archivomedica = this.files[0];
            if (archivomedica && archivomedica.type === 'application/pdf') {
                if (error3) error3.style.display = 'none';
                if (quitar3) quitar3.style.display = 'block';
            } else {
                if (error3) error3.style.display = 'block';
                this.value = '';
                if (quitar3) quitar3.style.display = 'none';
            }
        });
        quitar3.addEventListener('click', function() {
            archivo3.value = ''; 
            quitar1.style.display = 'none'; 
            if (error3) error3.style.display = 'none'; 
        });
    }
});







$("#guardarDESVINCULACION").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario($('#formularioDESVINCULACION'))

    if (formularioValido) {

    if (ID_FORMULARIO_DESVINCULACION == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarDESVINCULACION')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_DESVINCULACION: ID_FORMULARIO_DESVINCULACION }, 'desvinculacionSave', 'formularioDESVINCULACION', 'guardarDESVINCULACION', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_FORMULARIO_DESVINCULACION = data.basico.ID_FORMULARIO_DESVINCULACION
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_DESVINCULACION').modal('hide')
                    document.getElementById('formularioDESVINCULACION').reset();
                    Tabladesvinculacion.ajax.reload()
                    $('#NOMBRE_COLABORADOR')[0].selectize.clear();

           
                
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarDESVINCULACION')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_DESVINCULACION: ID_FORMULARIO_DESVINCULACION }, 'desvinculacionSave', 'formularioDESVINCULACION', 'guardarDESVINCULACION', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_FORMULARIO_DESVINCULACION = data.basico.ID_FORMULARIO_DESVINCULACION
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_DESVINCULACION').modal('hide')
                    document.getElementById('formularioDESVINCULACION').reset();
                    Tabladesvinculacion.ajax.reload()
                    $('#NOMBRE_COLABORADOR')[0].selectize.clear();


                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});





var Tabladesvinculacion = $("#Tabladesvinculacion").DataTable({
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
        url: '/Tabladesvinculacion',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tabladesvinculacion.columns.adjust().draw();
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
        { data: 'NOMBRE_COLABORADOR' },
        { data: 'FECHA_BAJA' },
        { data: 'BTN_BAJA' },
        { data: 'BTN_CONVENIO' },
        { data: 'BTN_ADEUDO' },
        { data: 'BTN_EDITAR' },
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Nombre del colaborador', className: 'all text-center' },
        { targets: 2, title: 'Fecha desvinculación ', className: 'all text-center' },
        { targets: 3, title: 'Documento baja', className: 'all text-center ' },
        { targets: 4, title: 'Documento convenio', className: 'all text-center ' },
        { targets: 5, title: 'Documento no adeudo', className: 'all text-center ' },
        { targets: 6, title: 'Editar', className: 'all text-center' },
    ]
});






$('#Tabladesvinculacion tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tabladesvinculacion.row(tr);

    ID_FORMULARIO_DESVINCULACION = row.data().ID_FORMULARIO_DESVINCULACION;

    editarDatoTabla(row.data(), 'formularioDESVINCULACION', 'miModal_DESVINCULACION', 1);

    var selectize = $('#CURP')[0].selectize;

    selectize.clear();

    var curpSeleccionado = row.data().CURP; 
    selectize.setValue(curpSeleccionado);


    $('#miModal_DESVINCULACION .modal-title').html(row.data().NOMBRE_COLABORADOR);

});



$('#Tabladesvinculacion').on('click', '.ver-archivo-documentobaja', function () {
    var tr = $(this).closest('tr');
    var row = Tabladesvinculacion.row(tr);
    var id = $(this).data('id');

    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }

    var nombreDocumento = "Documento baja";
    var url = '/mostrardocumentobaja/' + id;
    
    abrirModal(url, nombreDocumento);
});



$('#Tabladesvinculacion').on('click', '.ver-archivo-documentoconvenio', function () {
    var tr = $(this).closest('tr');
    var row = Tabladesvinculacion.row(tr);
    var id = $(this).data('id');

    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }

    var nombreDocumento = "Documento convenio";
    var url = '/mostrardocumenconvenio/' + id;
    
    abrirModal(url, nombreDocumento);
});



$('#Tabladesvinculacion').on('click', '.ver-archivo-documentoadeudo', function () {
    var tr = $(this).closest('tr');
    var row = Tabladesvinculacion.row(tr);
    var id = $(this).data('id');

    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }

    var nombreDocumento = "Documento no adeudo";
    var url = '/mostrardocumenadeudo/' + id;
    
    abrirModal(url, nombreDocumento);
});