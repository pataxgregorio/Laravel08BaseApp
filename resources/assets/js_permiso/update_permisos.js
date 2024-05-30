/**
* @author Tarsicio Carrizales telecom.com.ve@gmail.com
*/
  /////////////////////////      UPDATE PERMISOS ///////////////////////////////////////////////////////
  function update_permisos(id){ 
    var rol_id = $("#nombre_rol").attr('name');
    var modulo_id = id;
    var html = '';
    $.get('permisos/' + modulo_id + '/' + rol_id, 
        {_token:$('meta[name="csrf-token"]').attr('content')},function(data){ 
        jQuery.each(data, function(index, value) {
            html = '<div style="text-align:center;">';
            html += 'Permiso para el Rol: <b style="color:blue;"> '+value.NAME_ROL+'</b> Del módulo: <b style="color:blue;">'+value.NAME_MODULO+'</b>';            
            html += '</div>';
            html += '<hr>';
            /**
             * Inicio proceso para marca todos en ALLOW o marcar todos en DENY
             */
            html += '<div class="col-md-12">';
            html += '<div class="col-md-3">';            
            html += '</div>';
            html += '<div class="col-md-3" style="text-align:center; color:green; border-top-style: solid; border-right-style: solid; border-bottom-style: solid; border-left-style: solid;">';
            html += 'ALL ALLOW&nbsp;';
            html += '<input type="radio" onclick="update_all('+value.id+',\'ALLOW\','+modulo_id+')" name="ALL_01" class="form-group" id="mark_all_allow"/>';
            html += '</div>';
            html += '<div class="col-md-3" style="text-align:center; color:red;  border-top-style: solid; border-right-style: solid; border-bottom-style: solid; border-left-style: solid;">';
            html += 'ALL DENY&nbsp;';
            html += '<input type="radio" onclick="update_all('+value.id+',\'DENY\','+modulo_id+')" name="ALL_01" class="form-group" id="mark_all_deny"/>';
            html += '</div>';
            html += '<div class="col-md-3">';            
            html += '</div>';
            html += '</div>';
            /**
             * Fin proceso para marca todos en ALLOW o marcar todos en DENY
             */
           //////////////////////////////////// INICIO DELETE UPDATE  //////////////////////////////////////
            html += '<div class="col-md-12">';
            html += '<div class="col-md-3">';            
            html += '</div>';
            html += '<div class="col-md-6 form-group form-inline" style="text-align:left; border-top-style: solid; border-right-style: solid; border-bottom-style: solid; border-left-style: solid;">';
            html += '<dl>';
            html += '<li style="color:black;"><b>DELETE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>';            
            if(value.delete == 'ALLOW'){
              html += '<label style="color:green;">ALLOW&nbsp;';
              html += '<input type="radio" onclick="update_permiso_individual('+value.id+',\'delete\',\'ALLOW\','+modulo_id+')" name="ALLOW_DENY_01" checked="checked" class="form-group delete_allow_'+value.NAME_MODULO+'" id="delete_allow_'+value.id+'"/>';
              html += '&nbsp;&nbsp;<label style="color:red;">DENY&nbsp;</label>&nbsp;';
              html += '<input type="radio" onclick="update_permiso_individual('+value.id+',\'delete\',\'DENY\','+modulo_id+')" name="ALLOW_DENY_01" class="form-group delete_deny_'+value.NAME_MODULO+'" id="delete_deny_'+value.id+'"/>';
            }else{
              html += '<label style="color:green;">ALLOW&nbsp;';
              html += '<input type="radio" onclick="update_permiso_individual('+value.id+',\'delete\',\'ALLOW\','+modulo_id+')" name="ALLOW_DENY_01" class="form-group delete_allow_'+value.NAME_MODULO+'" id="delete_allow_'+value.id+'"/>';
              html += '&nbsp;&nbsp;<label style="color:red;">DENY&nbsp;</label>&nbsp;';
              html += '<input type="radio" onclick="update_permiso_individual('+value.id+',\'delete\',\'DENY\','+modulo_id+')" name="ALLOW_DENY_01" checked="checked" class=" form-group delete_deny_'+value.NAME_MODULO+'" id="delete_deny_'+value.id+'"/>';
            }            
            html += '</li>';
            html += '</dl>';            
            html += '</div>';
            html += '<div class="col-md-3">';            
            html += '</div>';
            html += '</div>';
            //////////////////////////////////// FIN DELETE UPDATE  //////////////////////////////////////
            //////////////////////////////////// INICIO UPDATE UPDATE  //////////////////////////////////////
            html += '<div class="col-md-12">';
            html += '<div class="col-md-3">';            
            html += '</div>';
            html += '<div class="col-md-6 form-group form-inline" style="text-align:left; border-top-style: solid; border-right-style: solid; border-bottom-style: solid; border-left-style: solid;">';            
            html += '<dl>';
            html += '<li style="color:black;"><b>UPDATE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>';            
            if(value.update == 'ALLOW'){
              html += '<label style="color:green;">ALLOW&nbsp;';
              html += '<input type="radio" onclick="update_permiso_individual('+value.id+',\'update\',\'ALLOW\','+modulo_id+')" name="ALLOW_DENY_02" checked="checked" class="form-group update_allow_'+value.NAME_MODULO+'" id="update_allow_'+value.id+'"/>';
              html += '&nbsp;&nbsp;<label style="color:red;">DENY&nbsp;</label>&nbsp;';
              html += '<input type="radio" onclick="update_permiso_individual('+value.id+',\'update\',\'DENY\','+modulo_id+')" name="ALLOW_DENY_02" class="form-group update_deny_'+value.NAME_MODULO+'" id="update_deny_'+value.id+'"/>';
            }else{
              html += '<label style="color:green;">ALLOW&nbsp;';
              html += '<input type="radio" onclick="update_permiso_individual('+value.id+',\'update\',\'ALLOW\','+modulo_id+')" name="ALLOW_DENY_02" class="form-group update_allow_'+value.NAME_MODULO+'" id="update_allow_'+value.id+'"/>';
              html += '&nbsp;&nbsp;<label style="color:red;">DENY&nbsp;</label>&nbsp;';
              html += '<input type="radio" onclick="update_permiso_individual('+value.id+',\'update\',\'DENY\','+modulo_id+')" name="ALLOW_DENY_02" checked="checked" class=" form-group update_deny_'+value.NAME_MODULO+'" id="update_deny_'+value.id+'"/>';
            }            
            html += '</li>';
            html += '</dl>';            
            html += '</div>';
            html += '<div class="col-md-3">';            
            html += '</div>';
            html += '</div>';
            //////////////////////////////////// FIN UPDATE UPDATE  //////////////////////////////////////
            //////////////////////////////////// INICIO EDIT UPDATE  //////////////////////////////////////
            html += '<div class="col-md-12">';
            html += '<div class="col-md-3">';            
            html += '</div>';
            html += '<div class="col-md-6 form-group form-inline" style="text-align:left; border-top-style: solid; border-right-style: solid; border-bottom-style: solid; border-left-style: solid;">';            
            html += '<dl>';
            html += '<li style="color:black;"><b>EDIT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>';            
            if(value.edit == 'ALLOW'){
              html += '<label style="color:green;">ALLOW&nbsp;';
              html += '<input type="radio" onclick="update_permiso_individual('+value.id+',\'edit\',\'ALLOW\','+modulo_id+')" name="ALLOW_DENY_03" checked="checked" class="form-group edit_allow_'+value.NAME_MODULO+'" id="edit_allow_'+value.id+'"/>';
              html += '&nbsp;&nbsp;<label style="color:red;">DENY&nbsp;</label>&nbsp;';
              html += '<input type="radio" onclick="update_permiso_individual('+value.id+',\'edit\',\'DENY\','+modulo_id+')" name="ALLOW_DENY_03" class="form-group edit_deny_'+value.NAME_MODULO+'" id="edit_deny_'+value.id+'"/>';
            }else{
              html += '<label style="color:green;">ALLOW&nbsp;';
              html += '<input type="radio" onclick="update_permiso_individual('+value.id+',\'edit\',\'ALLOW\','+modulo_id+')" name="ALLOW_DENY_03" class="form-group edit_allow_'+value.NAME_MODULO+'" id="edit_allow_'+value.id+'"/>';
              html += '&nbsp;&nbsp;<label style="color:red;">DENY&nbsp;</label>&nbsp;';
              html += '<input type="radio" onclick="update_permiso_individual('+value.id+',\'edit\',\'DENY\','+modulo_id+')" name="ALLOW_DENY_03" checked="checked" class=" form-group edit_deny_'+value.NAME_MODULO+'" id="edit_deny_'+value.id+'"/>';
            }            
            html += '</li>';
            html += '</dl>';
            html += '</div>';            
            html += '<div class="col-md-3">';            
            html += '</div>';
            html += '</div>';
            //////////////////////////////////// FIN EDIT UPDATE  //////////////////////////////////////
            //////////////////////////////////// INICIO ADD UPDATE  //////////////////////////////////////
            html += '<div class="col-md-12">';
            html += '<div class="col-md-3">';            
            html += '</div>';
            html += '<div class="col-md-6 form-group form-inline" style="text-align:left; border-top-style: solid; border-right-style: solid; border-bottom-style: solid; border-left-style: solid;">';            
            html += '<dl>';
            html += '<li style="color:black;"><b>CRAETE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>';            
            if(value.add == 'ALLOW'){
              html += '<label style="color:green;">ALLOW&nbsp;';
              html += '<input type="radio" onclick="update_permiso_individual('+value.id+',\'add\',\'ALLOW\','+modulo_id+')" name="ALLOW_DENY_04" checked="checked" class="form-group add_allow_'+value.NAME_MODULO+'" id="add_allow_'+value.id+'"/>';
              html += '&nbsp;&nbsp;<label style="color:red;">DENY&nbsp;</label>&nbsp;';
              html += '<input type="radio" onclick="update_permiso_individual('+value.id+',\'add\',\'DENY\','+modulo_id+')" name="ALLOW_DENY_04" class="form-group add_deny_'+value.NAME_MODULO+'" id="add_deny_'+value.id+'"/>';
            }else{
              html += '<label style="color:green;">ALLOW&nbsp;';
              html += '<input type="radio" onclick="update_permiso_individual('+value.id+',\'add\',\'ALLOW\','+modulo_id+')" name="ALLOW_DENY_04" class="form-group add_allow_'+value.NAME_MODULO+'" id="add_allow_'+value.id+'"/>';
              html += '&nbsp;&nbsp;<label style="color:red;">DENY&nbsp;</label>&nbsp;';
              html += '<input type="radio" onclick="update_permiso_individual('+value.id+',\'add\',\'DENY\','+modulo_id+')" name="ALLOW_DENY_04" checked="checked" class=" form-group add_deny_'+value.NAME_MODULO+'" id="add_deny_'+value.id+'"/>';
            }            
            html += '</li>';
            html += '</dl>';
            html += '</div>';            
            html += '<div class="col-md-3">';            
            html += '</div>';
            html += '</div>';
            //////////////////////////////////// FIN ADD UPDATE  //////////////////////////////////////
            //////////////////////////////////// INICIO VIEW UPDATE  //////////////////////////////////////
            html += '<div class="col-md-12">';
            html += '<div class="col-md-3">';            
            html += '</div>';
            html += '<div class="col-md-6 form-group form-inline" style="text-align:left; border-top-style: solid; border-right-style: solid; border-bottom-style: solid; border-left-style: solid;">';            
            html += '<dl>';
            html += '<li style="color:black;"><b>VIEW&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>';
            if(value.view == 'ALLOW'){
              html += '<label style="color:green;">ALLOW&nbsp;';
              html += '<input type="radio" onclick="update_permiso_individual('+value.id+',\'view\',\'ALLOW\','+modulo_id+')" name="ALLOW_DENY_05" checked="checked" class="form-group view_allow_'+value.NAME_MODULO+'" id="view_allow_'+value.id+'"/>';
              html += '&nbsp;&nbsp;<label style="color:red;">DENY&nbsp;</label>&nbsp;';
              html += '<input type="radio" onclick="update_permiso_individual('+value.id+',\'view\',\'DENY\','+modulo_id+')" name="ALLOW_DENY_05" class="form-group view_deny_'+value.NAME_MODULO+'" id="view_deny_'+value.id+'"/>';
            }else{
              html += '<label style="color:green;">ALLOW&nbsp;';
              html += '<input type="radio" onclick="update_permiso_individual('+value.id+',\'view\',\'ALLOW\','+modulo_id+')" name="ALLOW_DENY_05" class="form-group view_allow_'+value.NAME_MODULO+'" id="view_allow_'+value.id+'"/>';
              html += '&nbsp;&nbsp;<label style="color:red;">DENY&nbsp;</label>&nbsp;';
              html += '<input type="radio" onclick="update_permiso_individual('+value.id+',\'view\',\'DENY\','+modulo_id+')" name="ALLOW_DENY_05" checked="checked" class=" form-group view_deny_'+value.NAME_MODULO+'" id="view_deny_'+value.id+'"/>';
            }            
            html += '</li>';
            html += '</dl>';
            html += '</div>';            
            html += '<div class="col-md-3">';            
            html += '</div>';
            html += '</div>';
            //////////////////////////////////// FIN VIEW UPDATE  //////////////////////////////////////
            //////////////////////////////////// INICIO PRINT UPDATE  //////////////////////////////////////
            html += '<div class="col-md-12">';
            html += '<div class="col-md-3">';            
            html += '</div>';
            html += '<div class="col-md-6 form-group form-inline" style="text-align:left; border-top-style: solid; border-right-style: solid; border-bottom-style: solid; border-left-style: solid;">';            
            html += '<dl>';
            html += '<li style="color:black;"><b>PRINT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>';            
            if(value.print == 'ALLOW'){
              html += '<label style="color:green;">ALLOW&nbsp;';
              html += '<input type="radio" onclick="update_permiso_individual('+value.id+',\'print\',\'ALLOW\','+modulo_id+')" name="ALLOW_DENY_06" checked="checked" class="form-group print_allow_'+value.NAME_MODULO+'" id="print_allow_'+value.id+'"/>';
              html += '&nbsp;&nbsp;<label style="color:red;">DENY&nbsp;</label>&nbsp;';
              html += '<input type="radio" onclick="update_permiso_individual('+value.id+',\'print\',\'DENY\','+modulo_id+')" name="ALLOW_DENY_06" class="form-group print_deny_'+value.NAME_MODULO+'" id="print_deny_'+value.id+'"/>';
            }else{
              html += '<label style="color:green;">ALLOW&nbsp;';
              html += '<input type="radio" onclick="update_permiso_individual('+value.id+',\'print\',\'ALLOW\','+modulo_id+')" name="ALLOW_DENY_06" class="form-group print_allow_'+value.NAME_MODULO+'" id="print_allow_'+value.id+'"/>';
              html += '&nbsp;&nbsp;<label style="color:red;">DENY&nbsp;</label>&nbsp;';
              html += '<input type="radio" onclick="update_permiso_individual('+value.id+',\'print\',\'DENY\','+modulo_id+')" name="ALLOW_DENY_06" checked="checked" class=" form-group print_deny_'+value.NAME_MODULO+'" id="print_deny_'+value.id+'"/>';
            }            
            html += '</li>';
            html += '</dl>';
            html += '</div>';            
            html += '<div class="col-md-3">';            
            html += '</div>';
            html += '</div>';
            //////////////////////////////////// FIN PRINT UPDATE  //////////////////////////////////////
            //////////////////////////////////// INICIO DOWNLOAD UPDATE  //////////////////////////////////////
            html += '<div class="col-md-12">';
            html += '<div class="col-md-3">';            
            html += '</div>';
            html += '<div class="col-md-6 form-group form-inline" style="text-align:left; border-top-style: solid; border-right-style: solid; border-bottom-style: solid; border-left-style: solid;">';            
            html += '<dl>';
            html += '<li style="color:black;"><b>DOWNLOAD&nbsp;</b>';            
            if(value.download == 'ALLOW'){
              html += '<label style="color:green;">ALLOW&nbsp;';
              html += '<input type="radio" onclick="update_permiso_individual('+value.id+',\'download\',\'ALLOW\','+modulo_id+')" name="ALLOW_DENY_07" checked="checked" class="form-group download_allow_'+value.NAME_MODULO+'" id="download_allow_'+value.id+'"/>';
              html += '&nbsp;&nbsp;<label style="color:red;">DENY&nbsp;</label>&nbsp;';
              html += '<input type="radio" onclick="update_permiso_individual('+value.id+',\'download\',\'DENY\','+modulo_id+')" name="ALLOW_DENY_07" class="form-group download_deny_'+value.NAME_MODULO+'" id="download_deny_'+value.id+'"/>';
            }else{
              html += '<label style="color:green;">ALLOW&nbsp;&nbsp;';
              html += '<input type="radio" onclick="update_permiso_individual('+value.id+',\'download\',\'ALLOW\','+modulo_id+')" name="ALLOW_DENY_07" class="form-group download_allow_'+value.NAME_MODULO+'" id="download_allow_'+value.id+'"/>';
              html += '&nbsp;&nbsp;<label style="color:red;">DENY&nbsp;</label>&nbsp;';
              html += '<input type="radio" onclick="update_permiso_individual('+value.id+',\'download\',\'DENY\','+modulo_id+')" name="ALLOW_DENY_07" checked="checked" class=" form-group download_deny_'+value.NAME_MODULO+'" id="download_deny_'+value.id+'"/>';
            }            
            html += '</li>';
            html += '</dl>';
            html += '</div>';            
            html += '<div class="col-md-3">';            
            html += '</div>';
            html += '</div>';
            //////////////////////////////////// FIN DOWNLOAD UPDATE  //////////////////////////////////////
            //////////////////////////////////// INICIO UPLOAD UPDATE  //////////////////////////////////////
            html += '<div class="col-md-12">';
            html += '<div class="col-md-3">';            
            html += '</div>';
            html += '<div class="col-md-6 form-group form-inline" style="text-align:left; border-top-style: solid; border-right-style: solid; border-bottom-style: solid; border-left-style: solid;">';            
            html += '<dl>';
            html += '<li style="color:black;"><b>UPLOAD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>';            
            if(value.upload == 'ALLOW'){
              html += '<label style="color:green;">ALLOW&nbsp;';
              html += '<input type="radio" onclick="update_permiso_individual('+value.id+',\'upload\',\'ALLOW\','+modulo_id+')" name="ALLOW_DENY_08" checked="checked" class="form-group upload_allow_'+value.NAME_MODULO+'" id="upload_allow_'+value.id+'"/>';
              html += '&nbsp;&nbsp;<label style="color:red;">DENY&nbsp;</label>&nbsp;';
              html += '<input type="radio" onclick="update_permiso_individual('+value.id+',\'upload\',\'DENY\','+modulo_id+')" name="ALLOW_DENY_08" class="form-group upload_deny_'+value.NAME_MODULO+'" id="upload_deny_'+value.id+'"/>';
            }else{
              html += '<label style="color:green;">ALLOW&nbsp;';
              html += '<input type="radio" onclick="update_permiso_individual('+value.id+',\'upload\',\'ALLOW\','+modulo_id+')" name="ALLOW_DENY_08" class="form-group upload_allow_'+value.NAME_MODULO+'" id="upload_allow_'+value.id+'"/>';
              html += '&nbsp;&nbsp;<label style="color:red;">DENY&nbsp;</label>&nbsp;';
              html += '<input type="radio" onclick="update_permiso_individual('+value.id+',\'upload\',\'DENY\','+modulo_id+')" name="ALLOW_DENY_08" checked="checked" class=" form-group upload_deny_'+value.NAME_MODULO+'" id="upload_deny_'+value.id+'"/>';
            }            
            html += '</li>';
            html += '</dl>';
            html += '</div>';            
            html += '<div class="col-md-3">';            
            html += '</div>';
            html += '</div>';
            //////////////////////////////////// FIN UPLOAD UPDATE  //////////////////////////////////////
            $("#mostrar_permisos_modulo_rol_update").empty();
            $("#mostrar_permisos_modulo_rol_update").html(html); 
            $("#mostrar_permisos_modulo_rol_update").show();
        });
    });
}

function update_permiso_individual(id,accion,allow_deny,modulo_id){   
  $.post('permisos/' + id + '/' + accion + '/' + allow_deny, 
        {_token:$('meta[name="csrf-token"]').attr('content')},function(data){ 
          update_permisos(modulo_id);         
      });
}

function update_all(id,allow_deny,modulo_id){  
  $.post('permisos/' + id + '/' + allow_deny, 
        {_token:$('meta[name="csrf-token"]').attr('content')},function(data){        
          update_permisos(modulo_id);
      });
}

