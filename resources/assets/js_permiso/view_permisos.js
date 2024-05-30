/**
* @author Tarsicio Carrizales telecom.com.ve@gmail.com
*/
/////////////////////////////// MOSTRAR LOS PERMISOS SOLO LECTURA ///////////////////////////////////////
function mostrar_permisos(id){  
    var rol_id = $("#nombre_rol").attr('name');
    var modulo_id = id;
    var html = '';
    var contador = 1;    
    $.get('permisos/' + modulo_id + '/' + rol_id, 
        {_token:$('meta[name="csrf-token"]').attr('content')},function(data){                  
        jQuery.each(data, function(index, value) {            
            html = '<div style="text-align:center;"><h4>Permiso para el Rol:</h4><span style="color:blue;"><b>'+value.NAME_ROL+'</b></span><h4> Del módulo:</h4><span style="color:blue;"><b>'+value.NAME_MODULO+'</b></span></h4></div>';
            html += '<hr>';
            //////////////////////////////////// DELETE  //////////////////////////////////////
            html += '<div class="col-md-12">';
            html += '<div class="col-md-3">';
            html += '<div ></div>';
            html += '</div>';
            html += '<div class="col-md-3">';
            html += '<div style="text-align:left;"><b>DELETE</b></div>';
            html += '</div>';
            html += '<div class="col-md-3">';
            if(value.delete == 'ALLOW'){
                html += '<div style="text-align:center; color:green;"><b>'+value.delete+'</b></div>';
            }else{
                html += '<div style="text-align:center; color:red;"><b>'+value.delete+'</b></div>';
            }            
            html += '</div>';
            html += '<div class="col-md-3">';
            html += '<div></div>';
            html += '</div>';
            html += '</div>';
            //////////////////////////////////// UPDATE  //////////////////////////////////////
            html += '<div class="col-md-12">';
            html += '<div class="col-md-3">';
            html += '<div ></div>';
            html += '</div>';
            html += '<div class="col-md-3">';
            html += '<div style="text-align:left;"><b>UPDATE</b></div>';
            html += '</div>';
            html += '<div class="col-md-3">';
            if(value.update == 'ALLOW'){
                html += '<div style="text-align:center; color:green;"><b>'+value.update+'</b></div>';
            }else{
                html += '<div style="text-align:center; color:red;"><b>'+value.update+'</b></div>';
            }            
            html += '</div>';
            html += '<div class="col-md-3">';
            html += '<div></div>';
            html += '</div>';
            html += '</div>';
            //////////////////////////////////// EDIT  //////////////////////////////////////
            html += '<div class="col-md-12">';
            html += '<div class="col-md-3">';
            html += '<div ></div>';
            html += '</div>';
            html += '<div class="col-md-3">';
            html += '<div style="text-align:left;"><b>EDIT</b></div>';
            html += '</div>';
            html += '<div class="col-md-3">';
            if(value.edit == 'ALLOW'){
                html += '<div style="text-align:center; color:green;"><b>'+value.edit+'</b></div>';
            }else{
                html += '<div style="text-align:center; color:red;"><b>'+value.edit+'</b></div>';
            }            
            html += '</div>';
            html += '<div class="col-md-3">';
            html += '<div></div>';
            html += '</div>';
            html += '</div>';
            //////////////////////////////////// ADD  //////////////////////////////////////
            html += '<div class="col-md-12">';
            html += '<div class="col-md-3">';
            html += '<div ></div>';
            html += '</div>';
            html += '<div class="col-md-3">';
            html += '<div style="text-align:left;"><b>CREATE</b></div>';
            html += '</div>';
            html += '<div class="col-md-3">';
            if(value.add == 'ALLOW'){
                html += '<div style="text-align:center; color:green;"><b>'+value.add+'</b></div>';
            }else{
                html += '<div style="text-align:center; color:red;"><b>'+value.add+'</b></div>';
            }            
            html += '</div>';
            html += '<div class="col-md-3">';
            html += '<div></div>';
            html += '</div>';
            html += '</div>';
            //////////////////////////////////// VIEW  //////////////////////////////////////
            html += '<div class="col-md-12">';
            html += '<div class="col-md-3">';
            html += '<div ></div>';
            html += '</div>';
            html += '<div class="col-md-3">';
            html += '<div style="text-align:left;"><b>VIEW</b></div>';
            html += '</div>';
            html += '<div class="col-md-3">';
            if(value.view == 'ALLOW'){
                html += '<div style="text-align:center; color:green;"><b>'+value.view+'</b></div>';
            }else{
                html += '<div style="text-align:center; color:red;"><b>'+value.view+'</b></div>';
            }            
            html += '</div>';
            html += '<div class="col-md-3">';
            html += '<div></div>';
            html += '</div>';
            html += '</div>';
            //////////////////////////////////// PRINT  //////////////////////////////////////
            html += '<div class="col-md-12">';
            html += '<div class="col-md-3">';
            html += '<div ></div>';
            html += '</div>';
            html += '<div class="col-md-3">';
            html += '<div style="text-align:left;"><b>PRINT</b></div>';
            html += '</div>';
            html += '<div class="col-md-3">';
            if(value.print == 'ALLOW'){
                html += '<div style="text-align:center; color:green;"><b>'+value.print+'</b></div>';
            }else{
                html += '<div style="text-align:center; color:red;"><b>'+value.print+'</b></div>';
            }            
            html += '</div>';
            html += '<div class="col-md-3">';
            html += '<div></div>';
            html += '</div>';
            html += '</div>';
            //////////////////////////////////// DOWNLOAD  //////////////////////////////////////
            html += '<div class="col-md-12">';
            html += '<div class="col-md-3">';
            html += '<div ></div>';
            html += '</div>';
            html += '<div class="col-md-3">';
            html += '<div style="text-align:left;"><b>DOWNLOAD</b></div>';
            html += '</div>';
            html += '<div class="col-md-3">';
            if(value.download == 'ALLOW'){
                html += '<div style="text-align:center; color:green;"><b>'+value.download+'</b></div>';
            }else{
                html += '<div style="text-align:center; color:red;"><b>'+value.download+'</b></div>';
            }            
            html += '</div>';
            html += '<div class="col-md-3">';
            html += '<div></div>';
            html += '</div>';
            html += '</div>';
            //////////////////////////////////// UPLOAD  //////////////////////////////////////
            html += '<div class="col-md-12">';
            html += '<div class="col-md-3">';
            html += '<div ></div>';
            html += '</div>';
            html += '<div class="col-md-3">';
            html += '<div style="text-align:left;"><b>UPLOAD</b></div>';
            html += '</div>';
            html += '<div class="col-md-3">';
            if(value.upload == 'ALLOW'){
                html += '<div style="text-align:center; color:green;"><b>'+value.upload+'</b></div>';
            }else{
                html += '<div style="text-align:center; color:red;"><b>'+value.upload+'</b></div>';
            }            
            html += '</div>';
            html += '<div class="col-md-3">';
            html += '<div></div>';
            html += '</div>';
            html += '</div>';
            $("#mostrar_permisos_modulo_rol").empty();
            $("#mostrar_permisos_modulo_rol").html(html); 
            $("#mostrar_permisos_modulo_rol").show();
        });
    });
}

