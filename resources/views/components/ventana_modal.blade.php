<div class="modal fade" id="{{$id_modal}}">
  <div class="modal-dialog modal-lg modal-dialog-centered" style="width: {{$size_windows}} !important;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          <span>[x]</span>
        </button>
        <h3 style="text-align:center;" id="title_permiso">{{$windows_title}}</h3>
        <div class="row">
          <div class="col-md-12">
            <!-- Aquí se puede poner un Button del lado derecho,  de requerir en el futuro, por ejemplo -->
          </div>
        </div>
      </div>
      <div>
        <!-- Vacio, cualquier cosa. -->
      </div>
      <div class="modal-body">
        <div id="{{$id_body_modal}}" class="row">          
            <!-- NO BORRAR, AQUÍ SE PRESENTAN LOS DATOS  -->          
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="close" data-dismiss="modal">
          <span>{{$modal_footer_close}}</span>
        </button>
      </div>
    </div>
  </div>
</div>