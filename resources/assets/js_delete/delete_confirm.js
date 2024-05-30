/**
* @author Tarsicio Carrizales telecom.com.ve@gmail.com
*/
function deleteData(link) {
    swal({
        icon: 'warning',
        title: '¿Eliminar Registro?',
        text: 'Realmente desea eliminar este registro',
        buttons: ["No", "Yes"],
        dangerMode: true,
    })
        .then(isClose => {
            if (isClose) {
                window.location = $(link).attr('action');
            } else {
                swal("Se cancelo eliminar el registro");
            }
        });
    }
    $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
        $("#success-alert").slideUp(500);
    });