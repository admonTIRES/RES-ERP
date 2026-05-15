//VARIABLES
ID_FORMULARO_REQUERIMIENTO = 0
Tablasolicitudrequerimientopersonal = null


$("#NUEVO_REQUISICION").click(function (e) {
    e.preventDefault();

    const hoy = new Date();
    const yyyy = hoy.getFullYear();
    const mm = String(hoy.getMonth() + 1).padStart(2, '0');
    const dd = String(hoy.getDate()).padStart(2, '0');
    const fechaHoy = `${yyyy}-${mm}-${dd}`;

    $("#FECHA_RP").val(fechaHoy);

    $("#miModal_REQUERIMIENTO").modal("show");
    $("#MOSTRAR_TODO").show();
});







const ModalArea = document.getElementById('miModal_REQUERIMIENTO');

ModalArea.addEventListener('hidden.bs.modal', event => {
    ID_FORMULARO_REQUERIMIENTO = 0;

    document.getElementById('formularioRP').reset();


    $("#MOSTRAR_TODO").show();
    $("#DIV_APROBACION").hide();
    $("#DIV_APROBACION_RECHAZO").hide();
  
});







$("#guardarFormRP").click(function (e) {
    e.preventDefault();


    formularioValido = validarFormularioV2('formularioRP');


    if (formularioValido) {

    if (ID_FORMULARO_REQUERIMIENTO == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormRP')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARO_REQUERIMIENTO: ID_FORMULARO_REQUERIMIENTO }, 'RequisiconPerSolicitudSave', 'formularioRP', 'guardarFormRP', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_FORMULARO_REQUERIMIENTO = data.requerimiento.ID_FORMULARO_REQUERIMIENTO
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_REQUERIMIENTO').modal('hide')
                    document.getElementById('formularioRP').reset();
                    Tablasolicitudrequerimientopersonal.ajax.reload()

           
                
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormRP')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARO_REQUERIMIENTO: ID_FORMULARO_REQUERIMIENTO }, 'RequisiconPerSolicitudSave', 'formularioRP', 'guardarFormRP', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_FORMULARO_REQUERIMIENTO = data.requerimiento.ID_FORMULARO_REQUERIMIENTO
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_REQUERIMIENTO').modal('hide')
                    document.getElementById('formularioRP').reset();
                    Tablasolicitudrequerimientopersonal.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});


var Tablasolicitudrequerimientopersonal = $("#Tablasolicitudrequerimientopersonal").DataTable({
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
        url: '/Tablasolicitudrequerimientopersonal',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablasolicitudrequerimientopersonal.columns.adjust().draw();
            ocultarCarga();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alertErrorAJAX(jqXHR, textStatus, errorThrown);
        },
        dataSrc: 'data'
    },
    order: [[0, 'desc']], 
    columns: [
        { 
            data: null,
            render: function(data, type, row, meta) {
                return meta.row + 1; 
            }

    
        },
        { data: 'NOMBRE_CATEGORIA' },
        { data: 'PRIORIDAD_RP',
            className: 'text-center',
            render: function(data) { return data ? data : 'N/A';}
         },
        { data: 'TIPO_VACANTE_RP',
            className: 'text-center',
            render: function(data) { return data ? data : 'N/A'; }
         },
        { data: 'MOTIVO_VACANTE_RP',
            className: 'text-center',
            render: function(data) { return data ? data : 'N/A'; }
        },
       {
            data: null,
            className: 'text-center',
            render: function (data, type, row) {

                if (row.ANTES_DE1 == 1) {
                    return row.FECHA_CREACION ? row.FECHA_CREACION : 'N/A';
                } else {
                    return row.FECHA_RP ? row.FECHA_RP : 'N/A';
                }

            }
        },
        { data: 'ESTATUS' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Categoría', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Prioridad', className: 'all text-center nombre-column' },
        { targets: 3, title: 'Tipo de vacante', className: 'all text-center' },
        { targets: 4, title: 'Motivo', className: 'all text-center' },
        { targets: 5, title: 'Fecha de creación', className: 'all text-center' },
        { targets: 6, title: 'Estatus', className: 'all text-center' },
        { targets: 7, title: 'Editar', className: 'all text-center' },
        { targets: 8, title: 'Visualizar', className: 'all text-center' },
    ]
});



$('#Tablasolicitudrequerimientopersonal tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablasolicitudrequerimientopersonal.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_FORMULARO_REQUERIMIENTO: row.data().ID_FORMULARO_REQUERIMIENTO
    };

    eliminarDatoTabla(data, [Tablasolicitudrequerimientopersonal], 'RequerimientoDelete');
});




$('#Tablasolicitudrequerimientopersonal tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablasolicitudrequerimientopersonal.row(tr);
    ID_FORMULARO_REQUERIMIENTO = row.data().ID_FORMULARO_REQUERIMIENTO;

    editarDatoTabla(row.data(), 'formularioRP', 'miModal_REQUERIMIENTO', 1);

    if (row.data().APROBO_ID) {
        $.get(`/obtenerNombreUsuario/${row.data().APROBO_ID}`, function (res) {
            $('#NOMBRE_APROBO_RP').val(res.nombre_completo);
        }).fail(() => $('#NOMBRE_APROBO_RP').val(''));
    } else {
        $('#NOMBRE_APROBO_RP').val('No se ha aprobado');
    }

    
    if (row.data().ESTADO_SOLICITUD === "Aprobada") {
     
        $("#DIV_APROBACION").show();
        $("#DIV_APROBACION_RECHAZO").hide();
       
    } else if (row.data().ESTADO_SOLICITUD === "Rechazada") {
       
        $("#DIV_APROBACION").show();
        $("#DIV_APROBACION_RECHAZO").show();
                 
    } else {
        $("#DIV_APROBACION").hide();
        $("#DIV_APROBACION_RECHAZO").hide();
          
    }




    $("#miModal_REQUERIMIENTO").modal("show");
});


$(document).ready(function() {
    $('#Tablasolicitudrequerimientopersonal tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablasolicitudrequerimientopersonal.row(tr);
        
        hacerSoloLectura2(row.data(), '#miModal_REQUERIMIENTO');

        ID_FORMULARO_REQUERIMIENTO = row.data().ID_FORMULARO_REQUERIMIENTO;
        editarDatoTabla(row.data(), 'formularioRP', 'miModal_REQUERIMIENTO',1);

    if (row.data().APROBO_ID) {
        $.get(`/obtenerNombreUsuario/${row.data().APROBO_ID}`, function (res) {
            $('#NOMBRE_APROBO_RP').val(res.nombre_completo);
        }).fail(() => $('#NOMBRE_APROBO_RP').val(''));
    } else {
        $('#NOMBRE_APROBO_RP').val('No se ha aprobado');
    }
        
        
           
    if (row.data().ESTADO_SOLICITUD === "Aprobada") {
     
        $("#DIV_APROBACION").show();
        $("#DIV_APROBACION_RECHAZO").hide();
       
    } else if (row.data().ESTADO_SOLICITUD === "Rechazada") {
       
        $("#DIV_APROBACION").show();
        $("#DIV_APROBACION_RECHAZO").show();
                 
    } else {
        $("#DIV_APROBACION").hide();
        $("#DIV_APROBACION_RECHAZO").hide();
          
    }

        
        
    });

    $('#miModal_REQUERIMIENTO').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_REQUERIMIENTO');
    });
});









$('#Tablasolicitudrequerimientopersonal tbody').on('click', 'td>button.RP', function () {


    var tr = $(this).closest('tr');
    var row = Tablasolicitudrequerimientopersonal.row(tr);
    ID_FORMULARO_REQUERIMIENTO = row.data().ID_FORMULARO_REQUERIMIENTO

   
       alertMensajeConfirm({
        title: "¿Desea visualizar el formato Requisición de personal ?",
        text: "Confirma para continuar ",
        icon: "question",
    }, function () { 

		window.open("/makeExcelRP/" + ID_FORMULARO_REQUERIMIENTO);
           
        
    }, 1)

})


$('#Tablasolicitudrequerimientopersonal').on('click', '.ver-archivo-requerimiento', function () {
    var tr = $(this).closest('tr');
    var row = Tablasolicitudrequerimientopersonal.row(tr);
    var id = $(this).data('id');

    if (!id) {
        alert('ARCHIVO NO ENCONTRADO.');
        return;
    }

    var nombreDocumentoSoporte = row.data().NOMBRE_CATEGORIA;
    var url = '/mostrardocumentorequisicion/' + id;
    
    abrirModal(url, nombreDocumentoSoporte);
});






const archivoAutorizacion = document.getElementById('DOCUMENTO_REQUISICION');
const quitarFormatoBtn = document.getElementById('quitarformato');
const errorArchivo = document.getElementById('errorArchivo');

archivoAutorizacion.addEventListener('change', function () {
    if (archivoAutorizacion.files.length > 0) {
        const file = archivoAutorizacion.files[0];
        const fileType = file.type;

        if (fileType !== 'application/pdf') {
            errorArchivo.style.display = 'inline-block';
            quitarFormatoBtn.style.display = 'none'; 
            archivoAutorizacion.value = ''; 
        } else {
            errorArchivo.style.display = 'none';
            quitarFormatoBtn.style.display = 'inline-block'; 
        }
    }
});

quitarFormatoBtn.addEventListener('click', function () {
    archivoAutorizacion.value = '';
    quitarFormatoBtn.style.display = 'none'; 
    errorArchivo.style.display = 'none'; 
});





