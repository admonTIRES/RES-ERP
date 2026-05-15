

$(document).ready(function () {
    bloquearPorRolExterno();
});


function bloquearPorRolExterno() {

    $.ajax({
        url: '/validarRolExterno',
        type: 'GET',
        success: function (resp) {

            if (resp.externo) {

                $('#NUEVO_CLIENTE').prop('disabled', true);
                $('#guardarEMPRESA').prop('disabled', true);
                $('#abrirModalBtn').prop('disabled', true);
                $('#guardarArea').prop('disabled', true);
                $('#guardarEncargado').prop('disabled', true);
                $('#nuevo_ppt').prop('disabled', true);
                $('#guardarFormPPT').prop('disabled', true);
                $('#nuevo_dpt').prop('disabled', true);
                $('#guardarFormDPT').prop('disabled', true);
                $('#NUEVO_REQUISICION').prop('disabled', true);
                $('#guardarFormRP').prop('disabled', true);


                $('#guardarDatosGenerales').prop('disabled', true);

                
         
                $('#NUEVO_CLIENTE').prop('disabled', true);
                $('#guardarEMPRESA').prop('disabled', true);
                $('#abrirModalBtn').prop('disabled', true);
                $('#guardarArea').prop('disabled', true);
                $('#guardarEncargado').prop('disabled', true);
                $('#nuevo_ppt').prop('disabled', true);
                $('#guardarFormPPT').prop('disabled', true);
                $('#nuevo_dpt').prop('disabled', true);
                $('#guardarFormDPT').prop('disabled', true);
                $('#NUEVO_REQUISICION').prop('disabled', true);
                $('#guardarFormRP').prop('disabled', true);
                $('.ELIMINAR').prop('disabled', true);
                $('.ACTIVAR').prop('disabled', true);
                $('.pdf-button').prop('disabled', true);
                $('.DPT').prop('disabled', true);
                $('.btn-light').prop('disabled', true);
                $('.btn-success').prop('disabled', true);
                $('.btn-secondary ').prop('disabled', true);


                
 

            }

        },
        error: function () {
            console.error('Error al validar rol externo');
        }
    });

}