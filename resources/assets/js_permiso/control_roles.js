/**
* @author Tarsicio Carrizales telecom.com.ve@gmail.com
*/
$(document).ready(function () {
///////////////////////////  AL CAMBIAR LA SELECCION PARA ESCOGER EL ROL ////////////////////////////////////////
    $(document).on('change','#rols_id', function (e) {
        var rols_id = $('#rols_id').val();
        var url_vieja = $('#form_permiso_id').attr('action');
        var largo = url_vieja.length;
        var posicion = url_vieja.lastIndexOf('=');
        var diferencia = largo - posicion;
        var url_nueva = url_vieja.substring(0,(largo+1)-diferencia);        
        $('#form_permiso_id').attr('action',url_nueva + rols_id);
        $('#mostar_ocultar_permisos').empty();
    });
  ////////////////////////// FIN  AL CAMBIAR LA SELECCION PARA ESCOGER EL ROL ////////////////////////////////////
});