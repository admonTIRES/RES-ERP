//VARIABLES
ID_FORMULARIO_CUENTAPROVEEDOR = 0




const Modalcuenta = document.getElementById('miModal_cuentas');

Modalcuenta.addEventListener('hidden.bs.modal', event => {
    ID_FORMULARIO_CUENTAPROVEEDOR = 0;
    document.getElementById('formularioCuentas').reset();

    $('#DIV_EXTRAJERO').hide();
    $('#CLABE_INTERBANCARIA').show();

    document.getElementById('CARATULA_BANCARIA').value = '';
    document.getElementById('iconEliminarArchivo').classList.add('d-none');
});



$("#guardarCuentas").click(function (e) {
    e.preventDefault();

    formularioValido = validarFormulario3($('#formularioCuentas'))

    if (formularioValido) {

    if (ID_FORMULARIO_CUENTAPROVEEDOR == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarCuentas')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_CUENTAPROVEEDOR: ID_FORMULARIO_CUENTAPROVEEDOR }, 'AltacuentaSave', 'formularioCuentas', 'guardarCuentas', { callbackAfter: true, callbackBefore: true }, () => {
        
               

                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    

                ID_FORMULARIO_CUENTAPROVEEDOR = data.cuenta.ID_FORMULARIO_CUENTAPROVEEDOR
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#miModal_cuentas').modal('hide')
                    document.getElementById('formularioCuentas').reset();
                    Tablacuentasproveedores.ajax.reload()

        
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('guardarCuentas')
            await ajaxAwaitFormData({ api: 1, ID_FORMULARIO_CUENTAPROVEEDOR: ID_FORMULARIO_CUENTAPROVEEDOR }, 'AltacuentaSave', 'formularioCuentas', 'guardarCuentas', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    
                    ID_FORMULARIO_CUENTAPROVEEDOR = data.cuenta.ID_FORMULARIO_CUENTAPROVEEDOR
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#miModal_cuentas').modal('hide')
                    document.getElementById('formularioCuentas').reset();
                    Tablacuentasproveedores.ajax.reload()


                }, 300);  
            })
        }, 1)
    }

} else {
    // Muestra un mensaje de error o realiza alguna otra acción
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});




var Tablacuentasproveedores = $("#Tablacuentasproveedores").DataTable({
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
        url: '/Tablacuentasproveedores',
        beforeSend: function () {
            $('#loadingIcon1').css('display', 'inline-block');
        },
        complete: function () {
            $('#loadingIcon1').css('display', 'none');
            Tablacuentasproveedores.columns.adjust().draw(); 
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
        { data: 'TIPO_CUENTA' },
        { data: 'NOMBRE_BENEFICIARIO' },
        { data: 'BTN_EDITAR' },
        { data: 'BTN_VISUALIZAR' },
        { data: 'BTN_DOCUMENTO' },
    ],
    columnDefs: [
        { targets: 0, title: '#', className: 'all  text-center' },
        { targets: 1, title: 'Tipo de cuenta', className: 'all text-center nombre-column' },
        { targets: 2, title: 'Nombre del beneficiario', className: 'all text-center nombre-column' },
        { targets: 3, title: 'Editar', className: 'all text-center' },
        { targets: 4, title: 'Visualizar', className: 'all text-center' },
        { targets: 5, title: 'Carátula bancaria', className: 'all text-center' },
    ]
});






$('#Tablacuentasproveedores').on('click', '.ver-archivo-caratula', function () {
    var id = $(this).data('id');
    if (!id) {
        alert('ARCHIVO NO ENCONTRADO');
        return;
    }
    var url = '/mostrarcaratula/' + id;
    abrirModal(url, 'Carátula bancaria');
});




$('#Tablacuentasproveedores tbody').on('change', 'td>label>input.ELIMINAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacuentasproveedores.row(tr);

    var estado = $(this).is(':checked') ? 1 : 0;

    data = {
        api: 1,
        ELIMINAR: estado == 0 ? 1 : 0, 
        ID_FORMULARIO_CUENTAPROVEEDOR: row.data().ID_FORMULARIO_CUENTAPROVEEDOR
    };

    eliminarDatoTabla(data, [Tablacuentasproveedores], 'CuentasDelete');
});



$('#Tablacuentasproveedores tbody').on('click', 'td>button.EDITAR', function () {
    var tr = $(this).closest('tr');
    var row = Tablacuentasproveedores.row(tr);
    ID_FORMULARIO_CUENTAPROVEEDOR = row.data().ID_FORMULARIO_CUENTAPROVEEDOR;

    editarDatoTabla(row.data(), 'formularioCuentas', 'miModal_cuentas', 1);
    

     if (row.data().TIPO_CUENTA === "Extranjera") {
        $('#DIV_EXTRAJERO').show();
        $('#CLABE_INTERBANCARIA').hide();
    } else {
        $('#DIV_EXTRAJERO').hide();
        $('#CLABE_INTERBANCARIA').show();
    }
});



$(document).ready(function() {
    $('#Tablacuentasproveedores tbody').on('click', 'td>button.VISUALIZAR', function () {
        var tr = $(this).closest('tr');
        var row = Tablacuentasproveedores.row(tr);
        
        hacerSoloLectura2(row.data(), '#miModal_cuentas');

        ID_FORMULARIO_CUENTAPROVEEDOR = row.data().ID_FORMULARIO_CUENTAPROVEEDOR;
        editarDatoTabla(row.data(), 'formularioCuentas', 'miModal_cuentas', 1);
        
          if (row.data().TIPO_CUENTA === "Extranjera") {
        $('#DIV_EXTRAJERO').show();
        $('#CLABE_INTERBANCARIA').hide();
        } else {
            $('#DIV_EXTRAJERO').hide();
            $('#CLABE_INTERBANCARIA').show();
        }
    });


    $('#miModal_cuentas').on('hidden.bs.modal', function () {
        resetFormulario('#miModal_cuentas');
    });
});



document.addEventListener("DOMContentLoaded", function () {
    const tipoCuentaSelect = document.querySelector('select[name="TIPO_CUENTA"]');
    const divExtranjero = document.getElementById("DIV_EXTRAJERO");
    const clabeInterbancaria = document.getElementById("CLABE_INTERBANCARIA");

    tipoCuentaSelect.addEventListener("change", function () {
        if (this.value === "Extranjera") {
            divExtranjero.style.display = "block";
            clabeInterbancaria.style.display = "none";
        } else {
            divExtranjero.style.display = "none";
            clabeInterbancaria.style.display = "block";
        }
    });
});





const inputArchivo = document.getElementById('CARATULA_BANCARIA');
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
