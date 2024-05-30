@extends('adminlte::layouts.app')

@section('css_database')
    @include('adminlte::layouts.partials.link')
@endsection

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.home') }}
@endsection

@section('contentheader_title')
<div>
    <h2 class="mb-4">Seguimiento</h2>
    @component('components.boton_back',['ruta' => route('seguimiento.index'),'color' => $array_color['back_button_color']])
        Botón de retorno
    @endcomponent   
</div>
    
@endsection

    
@section('main-content')

<div class="container-fluid ">
    <div class="card">

                <div class="modal" id="myModal">
                <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">Agregar Seguimiento</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                <div style="text-align:left;">
                    {!! Form::label('asunto','Asunto del Caso', ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                    {!! Form::textarea('asunto',old('asunto'),['placeholder' => 'Asunto del Caso','class' => 'form-control','id' => 'asunto']) !!}
                </div>
                <div style="text-align:left;">
                {!! Form::label('asunto','Evidencia', ['class' => 'control-label']) !!}
                    <input type="file" name="image" id="image">
                </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="Agregar" data-dismiss="modal">Agregar</button>
                    <input type="text" hidden value="{{$solicitud_edit->id}}" name="solicitud_id">
                </div>
                </div>
                </div>
                </div>
        <div class="card-body">
            <div class="col-lg-12 col-xs-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                    <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                    </ul>
                    </div>
                @endif

                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="margin-bottom: 10px;">+Seguimiento</button>
                
            </div>
        </div>
    </div>
</div><!-- container-fluid -->
@endsection
@section('script_datatable')
    <script type="text/javascript">
        $(document).ready(function() {
            // Assuming you have a table with ID 'my-data-table'
            $('#my-data-table').DataTable();

            $('#myModal').on('shown.bs.modal', function () {
                // Code to execute when the modal is shown (optional)
            });

            $("#boton").hide();  // Assuming you want to hide a button with ID 'boton'

            $('#Agregar').click(function() {
                // Code to execute when the 'Agregar' button is clicked
                // Replace 'alert("test");' with your actual logic
                alert("Seguimiento agregado (placeholder for your logic)");
            });
        });
    </script>
@endsection