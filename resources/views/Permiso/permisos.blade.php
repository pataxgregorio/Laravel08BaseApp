@extends('adminlte::layouts.app')

@section('css_database')
    @include('adminlte::layouts.partials.link')
@endsection

@section('htmlheader_title')
    {{ trans('message.home_1') }}
@endsection

@section('contentheader_title')
    <h2 class="mb-4">{{ trans('message.menu_permiso') }}</h2>
@endsection

@section('link_css_datatable')
    <link href="{{ url ('/css_datatable/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url ('/css_datatable/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url ('/css_datatable/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url ('/css_datatable/buttons.dataTables.min.css') }}" rel="stylesheet">
@endsection
    
@section('main-content')
@if(Auth::user()->rols_id == 1)
<div class="container-fluid">
<div class="row">
    <div class="col-lg-12 col-xs-12">             
        <div class="card">
            <div class="card-body">                
                {!! Form::open(array('route' => array('permisos.index','name='.$rols_id),
                'method'=>'GET','id' => 'form_permiso_id')) !!}                
                    <div class="form-group">
                        <div style="text-align:left;">
                            {!! Form::label('name',trans('message.permisos_rol.roles'), ['class' => 'control-label']) !!}
                        </div>                        
                        <div style="text-align:left;">
                        {!! Form::select('name', $roles, $rols_id, ['placeholder' => trans('message.permisos_rol.opcion'),'class' => 'form-control','id' => 'rols_id']) !!}                                            
                        </div>
                        <hr>
                        {!! Form::submit(trans('message.mensajes_alert.submit_01'),['class'=> 'form-control btn btn-primary','title' => trans('message.tooltip.procesa_rol'),'data-toggle' => 'tooltip','style' => 'background-color:'.$array_color['group_button_color'].';']) !!}
                    </div>                
                {!!  Form::close() !!}                
            </div>
        </div>
    </div>
</div>
<div style="text-align:center">    
    <label style="color:black;">{{ trans('message.permisos_rol.msg_rol') }}&nbsp;</label>
    <label id="nombre_rol" name="{{$rols_id}}" style="color:blue;">{{ $nombre_rol}}</label>  
</div>
<div class="card" id="mostar_ocultar_permisos">
    <div class="card-body">            
        <table class="table table-bordered permiso_all">
            <thead>
                <tr>
                    <th style="text-align:center;">ID</th>
                    <th>{{ trans('message.datadatable_user.nombre') }}</th>                    
                    <th style="text-align:center;">{{ trans('message.description') }}</th>
                    <th style="text-align:center;">{{ trans('message.botones.edit') }}</th>
                    <th style="text-align:center;">{{ trans('message.botones.view') }}</th>                    
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
</div>
@else
  @php alert()->warning(trans('message.mensajes_alert.denegado'),trans('message.mensajes_alert.mensaje')); @endphp
  <h1 style="text-align:center;">Área dedicada al rol ROOT</h1>
@endif

<!-- Componente, Ventana Modal para Ver los Permisos.--> 
@component('components.ventana_modal',['id_modal' => 'view_permisos',
                                'windows_title' => trans('message.windows_modal.view_title_permiso'),
                                'id_body_modal' => 'mostrar_permisos_modulo_rol',
                                'modal_footer_close' => trans('message.windows_modal.close'),
                                'size_windows' => '50%'])
Componente, Ventana Modal para Ver los Permisos
@endcomponent

<!-- Componente, Ventana Modal para Editar los Permisos.--> 
@component('components.ventana_modal',['id_modal' => 'edit_permisos',
                                'windows_title' => trans('message.windows_modal.edit_title_permiso'),
                                'id_body_modal' => 'mostrar_permisos_modulo_rol_update',
                                'modal_footer_close' => trans('message.windows_modal.close'),
                                'size_windows' => '50%'])
Componente, Ventana Modal para Editar los Permisos
@endcomponent
@endsection

@section('script_datatable')
<script src="{{ url ('/js_permiso/control_roles.min.js') }}" type="text/javascript"></script>
<script src="{{ url ('/js_datatable/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ url ('/js_datatable/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ url ('/js_datatable/dataTables.responsive.min.js') }}" type="text/javascript"></script>
<script src="{{ url ('/js_datatable/responsive.bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ url ('/js_datatable/dataTables.buttons.min.js') }}" type="text/javascript"></script>
<script src="{{ url ('/js_permiso/view_permisos.min.js') }}" type="text/javascript"></script>   
<script src="{{ url ('/js_permiso/update_permisos.min.js') }}" type="text/javascript"></script>   
<script type="text/javascript">
  $(function () {    
    var table = $('.permiso_all').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth : false,        
        ajax: "{{ route('permisos.list') }}",        
        columns: [             
            {
                data: 'id', name: 'id',
                "render": function ( data, type, row ) {                    
                    return '<div style="text-align:center;"><b>'+data+'</b></div>';
                }
            },
            {data: 'name', name: 'name'},            
            {data: 'description', name: 'description'},
            {
                data: 'edit', name: 'edit', orderable: false, searchable: false,
                "render": function ( data, type, row ) {                    
                    return '<div style="text-align:center;">'+data+'</div>';
                }
            },
            {
                data: 'view', name: 'view', orderable: false, searchable: false,                
                "render": function ( data, type, row ) {                    
                    return '<div style="text-align:center;">'+data+'</div>';
                }
            },
        ],
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "Nada encontrado !!! - disculpe",
            "info": "Mostrando la página _PAGE_ de _PAGES_",
            "infoEmpty": "Registros no disponible",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "search": "Buscar:",
            "paginate": {
                "next": "Siguiente",
                "previous": "Anterior",
            }
        }       
    });    
  });
</script>
@endsection