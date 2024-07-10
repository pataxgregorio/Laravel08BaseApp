@extends('adminlte::layouts.app')

@section('css_database')
    @include('adminlte::layouts.partials.link')
@endsection

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.home') }}
@endsection

@section('contentheader_title')
<!-- Componente Button Para todas las Ventanas de los Módulos, no Borrar.--> 

  
    
@endsection

@section('link_css_datatable')
    <link href="{{ url ('/css_datatable/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url ('/css_datatable/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url ('/css_datatable/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url ('/css_datatable/buttons.dataTables.min.css') }}" rel="stylesheet">
@endsection

    
@section('main-content')
@component('components.alert_msg',['tipo_alert'=>$tipo_alert])
 Componentes para los mensajes de Alert, No Eliminar
@endcomponent

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <label for="fecha_desde">Fecha Desde:</label>
                    <input type="date" class="form-control" id="fecha_desde">
                </div>
                <div class="col-md-3">
                    <label for="fecha_hasta">Fecha Hasta:</label>
                    <input type="date" class="form-control" id="fecha_hasta">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary" id="btn_filtrar" style="margin-top: 25px;">Filtrar</button>
                </div>
            </div>
            <br>
            <table class="table table-bordered solicitud_all">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Cedula</th>
                        <th style="text-align:center;">Tipo Solicitud</th>
                        <th style="text-align:center;">Direccion</th>
                        <th style="text-align:center;">Status</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <button class="btn btn-primary" style="padding:5px;" id="btn_listado">Imprimir Listado</button>
    <button class="btn btn-primary" style="padding:5px;" id="btn_totales">Imprimir Totales</button>
</div>


@endsection
@section('script_datatable')
<script src="{{ url ('/js_datatable/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ url ('/js_datatable/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ url ('/js_datatable/dataTables.responsive.min.js') }}" type="text/javascript"></script>
<script src="{{ url ('/js_datatable/responsive.bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ url ('/js_datatable/dataTables.buttons.min.js') }}" type="text/javascript"></script>
<script src="{{ url ('/js_delete/sweetalert.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {
        
        $('#btn_totales').click(function() {
        $.ajax({
            url: "{{ route('solicitud.solicitudTotalFinalizadas') }}",
            method: 'GET',
            dataType: 'json', // Indicamos que esperamos una respuesta JSON
            success: function(response) {
                console.log(response); 
                // Aquí puedes mostrar los resultados en tu interfaz de usuario
                // Por ejemplo: 
                // alert("Total de solicitudes: " + response.TOTAL_SOLICITUD);
            },
            error: function() {
                console.error("Error al obtener los totales.");
            }
            });
        });

        var table = $('.solicitud_all').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth : false,
            ajax: {
                url: "{{ route('seguimiento.finalizadas') }}",
                data: function (d) {
                    d.fecha_desde = $('#fecha_desde').val();
                    d.fecha_hasta = $('#fecha_hasta').val();
                }
            },
            columns: [
                {
                    data: 'id', name: 'id',
                    "render": function ( data, type, row ) { 
                        return '<div style="text-align:center;"><b>'+data+'</b></div>';
                    }
                },
                {data: 'solicitante', name: 'solicitante'}, 
                {data: 'cedula', name: 'cedula'}, 
                {data: 'nombretipo', name: 'nombretipo'}, 
                {data: 'direccionnombre', name: 'direccionnombre'}, 
                {data: 'nombrestatus', name: 'nombrestatus'},            
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

        $('#btn_filtrar').click(function() {
            table.ajax.reload(); 
        });
    }); 
</script>

<script src="{{ url ('/js_delete/delete_confirm.min.js') }}"></script>
@endsection  
