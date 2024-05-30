@if($tipo_alert == 'Delete') 
<div class="alert alert-success alert-dismissable" style="text-align: center;" id="success-alert">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong >{{ trans('message.mensajes_alert.record_delete') }}</strong>
</div>
@elseif($tipo_alert == 'Create')
<div class="alert alert-success alert-dismissable" style="text-align: center;" id="success-alert">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong >{{ trans('message.mensajes_alert.msg_03') }}</strong>
</div>
@elseif($tipo_alert == 'Update')
<div class="alert alert-success alert-dismissable" style="text-align: center;" id="success-alert">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong >{{ trans('message.mensajes_alert.msg_02') }}</strong>
</div>
@elseif($tipo_alert == 'Delete_02')
 <div class="alert alert-error alert-dismissable" style="text-align: center;" id="success-alert">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong >{{ trans('message.mensajes_alert.msg_no_delete') }}</strong>
</div>
@elseif($tipo_alert == 'SIN_INTERNET')
<div class="alert alert-error alert-dismissable" style="text-align: center;" id="success-alert">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong >{{ trans('message.mensajes_alert.no_guardo') }}</strong>
</div>
@else
 <!-- NO HACE NADA -->
@endif