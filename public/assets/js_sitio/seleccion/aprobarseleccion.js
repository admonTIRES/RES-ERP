var ID_INTELIGENCIA_SELECCION = 0




const ModalPrueba = document.getElementById('Modal_inteligencia');

ModalPrueba.addEventListener('hidden.bs.modal', event => {
    ID_INTELIGENCIA_SELECCION = 0;
    document.getElementById('formularioINTELIGENCIA').reset();   



    $('#motivo-aprobacion-container').show();
    $('#motivo-rechazo-container').hide();
});

  





$("#guardarFormSeleccionInteligencia").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario3($('#formularioINTELIGENCIA'))

    if (formularioValido) {

    if (ID_INTELIGENCIA_SELECCION == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormSeleccionInteligencia')
            await ajaxAwaitFormData({ api: 1, ID_INTELIGENCIA_SELECCION: ID_INTELIGENCIA_SELECCION }, 'AprobarInteligenciaSave', 'formularioINTELIGENCIA', 'guardarFormSeleccionInteligencia', { callbackAfter: true, callbackBefore: true }, () => {

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    ID_INTELIGENCIA_SELECCION = data.inteligencia.ID_INTELIGENCIA_SELECCION
                    alertMensaje('success','Información guardada correctamente',null)
                     $('#Modal_inteligencia').modal('hide')
                    document.getElementById('formularioINTELIGENCIA').reset();
                    Tablaprobarinteligencialaboral.ajax.reload()

                }, 300);
                
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se editara la información",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarFormSeleccionInteligencia')
            await ajaxAwaitFormData({ api: 1, ID_INTELIGENCIA_SELECCION: ID_INTELIGENCIA_SELECCION }, 'AprobarInteligenciaSave', 'formularioINTELIGENCIA', 'guardarFormSeleccionInteligencia', { callbackAfter: true, callbackBefore: true }, () => {

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_INTELIGENCIA_SELECCION = data.inteligencia.ID_INTELIGENCIA_SELECCION
                    alertMensaje('success','Información guardada correctamente',null )
                     $('#Modal_inteligencia').modal('hide')
                    document.getElementById('formularioINTELIGENCIA').reset();
                    Tablaprobarinteligencialaboral.ajax.reload()


                }, 300);  
            })
        }, 1)
    }
} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});



var Tablaprobarinteligencialaboral = $("#Tablaprobarinteligencialaboral").DataTable({
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
        url: '/Tablaprobarinteligencialaboral',
        beforeSend: function () {
            mostrarCarga();
        },
        complete: function () {
            Tablaprobarinteligencialaboral.columns.adjust().draw();
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
        { data: 'TEXTO_CURP' },
        { data: 'RIESGO', className: 'text-center' },  
        { data: 'BTN_EDITAR' },
        { data: 'BTN_ELIMINAR' }
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Nombre del postulante', className: 'all text-center nombre-column' },
        { target:  2, title: 'Riesgo', className: 'all text-center' },  
        { targets: 3, title: 'Editar', className: 'all text-center' },
        { targets: 4, title: 'Activo', className: 'all text-center' }
    ]
});




$('#Tablaprobarinteligencialaboral tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablaprobarinteligencialaboral.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_INTELIGENCIA_SELECCION: row.data().ID_INTELIGENCIA_SELECCION
    };

    eliminarDatoTabla(data, [Tablaprobarinteligencialaboral], 'AprobarInteligenciaDelete');
});




function cambiarColor() {
        var select = document.getElementById("APROBACION_INTELIGENCIA");
        var container = document.getElementById("estado-container");
        var motivoContainer = document.getElementById("motivo-rechazo-container");
        var motivoContainerAprobacion = document.getElementById("motivo-aprobacion-container");
    

        if (select.value === "Aprobada") {
            motivoContainerAprobacion.style.display = "block"; 
            motivoContainer.style.display = "none"; 
        } else if (select.value === "Rechazada") {
            motivoContainerAprobacion.style.display = "none"; 
            motivoContainer.style.display = "block"; 
        } else {
            motivoContainerAprobacion.style.display = "block"; 
            motivoContainer.style.display = "none"; 
        }
}
    



$('#Tablaprobarinteligencialaboral tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablaprobarinteligencialaboral.row(tr);
    ID_INTELIGENCIA_SELECCION = row.data().ID_INTELIGENCIA_SELECCION;
    var data = row.data();
    var form = "formularioINTELIGENCIA";
    

    delete data.QUIEN_APROBO;


    editarDatoTabla(data, form, 'Modal_inteligencia', 1);
    
    var riesgoPorcentaje = data.RIESGO_PORCENTAJE;  

    document.querySelectorAll('input[name="RIESGO_PORCENTAJE"]').forEach(radio => {
        radio.checked = false;
    });
    document.querySelectorAll('.light').forEach(light => {
        light.classList.remove('active');
    });

    if (riesgoPorcentaje == 40) {
        document.querySelector('input[name="RIESGO_PORCENTAJE"][value="40"]').checked = true;
        document.querySelector('.light.red').classList.add('active');
    } else if (riesgoPorcentaje == 70) {
        document.querySelector('input[name="RIESGO_PORCENTAJE"][value="70"]').checked = true;
        document.querySelector('.light.yellow').classList.add('active');
    } else if (riesgoPorcentaje == 100) {
        document.querySelector('input[name="RIESGO_PORCENTAJE"][value="100"]').checked = true;
        document.querySelector('.light.green').classList.add('active');
    }
});







