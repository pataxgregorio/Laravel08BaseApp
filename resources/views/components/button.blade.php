<div>
    <h2 class="mb-4">{{ $titulo_modulo}}</h2>
</div >    
<div style="container flex flex-wrap justify-content-center row-gap-3">
<a  style="background-color: {{$color}};" href="{{ $router_modulo_create }}" id="{{$id_new_modulo}}" class="btn btn-sm btn-primary glyphicon glyphicon-plus" style="color:black;" data-toggle="tooltip" title="{{$tooltip}}"><b>{{ $boton_crear }}</b></a>
    <a  style="background-color: {{$color}};" href="{{ $route_print }}" class="btn btn-primary btn-sm glyphicon glyphicon-print" role="button" aria-disabled="true" style="color:black;"><b> {{ trans('message.botones.print') }}</b></a>
    
</div>