@extends('adminlte::layouts.app')

@section('css_database')
    @include('adminlte::layouts.partials.link')
@endsection

@section('htmlheader_title')
    {{ trans('message.home_1') }}
@endsection

@section('contentheader_title')
    <h2 class="mb-4">{{ trans('message.menu_notificaciones') }}</h2>
@endsection

@section('link_css_datatable')
    <link href="{{ url ('/css_datatable/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url ('/css_datatable/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url ('/css_datatable/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url ('/css_datatable/buttons.dataTables.min.css') }}" rel="stylesheet">
@endsection
    
@section('main-content')
<div class="container-fluid">
<div class="card">
    <div class="card-body">            
        <table class="table table-bordered notificaciones_all">
            <thead>
                <tr>                    
                    <th>{{ trans('message.permisos_rol.mensaje') }}</th>
                    <th style="width:90px;">{{ trans('message.datadatable_user.leido') }}</th>
                    <th style="width:70px;">{{ trans('message.datadatable_user.fecha') }}</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection

@section('script_datatable')
<script src="{{ url ('/js_datatable/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ url ('/js_datatable/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ url ('/js_datatable/dataTables.responsive.min.js') }}" type="text/javascript"></script>
<script src="{{ url ('/js_datatable/responsive.bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ url ('/js_datatable/dataTables.buttons.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
  $(function () {    
    var table = $('.notificaciones_all').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth : false,        
        ajax: "{{ route('notificaciones.list') }}",
        columns: [
            {
                data: 'data', name: 'data'
            },
            {
                data: 'read_at', name: 'read_at',
                "render": function ( data, type, row ) {                    
                    return '<div style="text-align:center;">'+data+'</div>';
                }
            },
            {data: 'created_at', name: 'created_at'},
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

