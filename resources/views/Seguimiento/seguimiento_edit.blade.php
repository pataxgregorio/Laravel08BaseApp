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
    @component('components.boton_back',['ruta' => route('seguimiento.index'),'color' =>
    $array_color['back_button_color']])
    Botón de retorno
    @endcomponent
</div>

@endsection


@section('main-content')
<div class="container-fluid w-50" style="max-width:640px">
    <div class="card">
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

                <?php 
                    $usuario = Auth::user()->name;
                ?>

                <div class="form-group">
                    <div style="text-align:left;">
                        {!! Form::label('nombre',trans('message.users_action.nombre'), ['class' => 'control-label'])
                        !!}<span class="required" style="color:red;">*</span>
                        {!! Form::text('nombre',$solicitud_edit->nombre,['placeholder' =>
                        trans('message.solicitud_action.nombre'),'class' => 'form-control','id' =>
                        'nombre_user','disabled' => true]) !!}
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('cedula',trans('message.solicitud_action.cedula'), ['class' => 'control-label'])
                        !!}<span class="required" style="color:red;">*</span>
                        {!! Form::text('cedula',$solicitud_edit->cedula,['placeholder' =>
                        trans('message.solicitud_action.cedula'),'class' => 'form-control','id' =>
                        'cedula_user','disabled' => true]) !!}
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('telefono',trans('message.solicitud_action.telefono'), ['class' =>
                        'control-label']) !!}<span class="required" style="color:red;">*</span>
                        {!! Form::text('telefono',$solicitud_edit->telefono,['placeholder' =>
                        trans('message.solicitud_action.telefono'),'class' => 'form-control','id' =>
                        'telefono_user','disabled' => true]) !!}
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('telefono2',trans('message.solicitud_action.telefono2'), ['class' =>
                        'control-label']) !!}<span class="required" style="color:red;">*</span>
                        {!! Form::text('telefono2',$solicitud_edit->telefono2,['placeholder' =>
                        trans('message.solicitud_action.telefono2'),'class' => 'form-control','id' =>
                        'telefono2_user','disabled' => true]) !!}
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('email',trans('message.users_action.email_user'), ['class' => 'control-label'])
                        !!}<span class="required" style="color:red;">*</span>
                        {!! Form::email('email',$solicitud_edit->email,['placeholder' =>
                        trans('message.users_action.mail_ejemplo'),'class' => 'form-control','id' =>
                        'email_user','disabled' => true]) !!}
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('sexo_id',trans('message.solicitud_action.sexo'), ['class' => 'control-label'])
                        !!}<span class="required" style="color:red;">*</span>
                        {!! Form::select('sexo',$sexo, $solicitud_edit->sexo, ['placeholder' =>
                        trans('message.solicitud_action.sexo'),'class' => 'form-control','id' => 'sexo','disabled' =>
                        true]) !!}
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('edocivil',trans('message.solicitud_action.edocivil'), ['class' =>
                        'control-label']) !!}<span class="required" style="color:red;">*</span>
                        {!! Form::select('edocivil',$edocivil, $solicitud_edit->edocivil, ['placeholder' =>
                        trans('message.solicitud_action.edocivil'),'class' => 'form-control','id' =>
                        'edocivil_id','disabled' => true]) !!}

                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('fechaNacimiento','FECHA DE NACIMIENTO', ['class' => 'control-label']) !!}<span
                            class="required" style="color:red;">*</span>
                        {!! Form::date('fechaNacimiento',$solicitud_edit->fechaNacimiento,['placeholder' => 'FECHA DE
                        NACIMIENTO','class' => 'form-control','id' => 'fechaNacimiento_user','disabled' => true]) !!}
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('nivelestudio','NIVEL EDUCATIVO', ['class' => 'control-label']) !!}<span
                            class="required" style="color:red;">*</span>
                        {!! Form::select('nivelestudio',$nivelestudio, $solicitud_edit->nivelestudio, ['placeholder' =>
                        'NIVEL EDUCATIVO','class' => 'form-control','id' => 'nivelestudio_user','disabled' => true]) !!}
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('profesion','OCUPACION O/U OFICIO', ['class' => 'control-label']) !!}<span
                            class="required" style="color:red;">*</span>
                        {!! Form::select('profesion',$profesion, $solicitud_edit->profesion, ['placeholder' =>
                        'OCUPACION O/U OFICIO','class' => 'form-control','id' => 'profesion_user','disabled' => true])
                        !!}
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('estado_id',trans('message.solicitud_action.estado'), ['class' =>
                        'control-label']) !!}<span class="required" style="color:red;">*</span>
                        {!! Form::select('estado_id',$estado, $solicitud_edit->estado_id, ['placeholder' =>
                        trans('message.solicitud_action.estado'),'class' => 'form-control','id' =>
                        'estado_id','disabled' => true]) !!}
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('municipio_id',trans('message.solicitud_action.municipio'), ['class' =>
                        'control-label']) !!}<span class="required" style="color:red;">*</span>
                        {!! Form::select('municipio_id', $municipio, $solicitud_edit->municipio_id, ['placeholder' =>
                        trans('message.solicitud_action.municipio'),'class' => 'form-control','id' =>
                        'municipio_id','disabled' => true]) !!}
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('parroquia_id',trans('message.solicitud_action.parroquia'), ['class' =>
                        'control-label']) !!}<span class="required" style="color:red;">*</span>
                        {!! Form::select('parroquia_id', $parroquia, $solicitud_edit->parroquia_id, ['placeholder' =>
                        trans('message.solicitud_action.parroquia'),'class' => 'form-control','id' =>
                        'parroquia_id','disabled' => true]) !!}
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('comuna_id',trans('message.solicitud_action.comuna'), ['class' =>
                        'control-label']) !!}<span class="required" style="color:red;">*</span>
                        {!! Form::select('comuna_id', $comuna, $solicitud_edit->comuna_id, ['placeholder' =>
                        trans('message.solicitud_action.comuna'),'class' => 'form-control','id' =>
                        'comuna_id','disabled' => true]) !!}
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('comunidad_id',trans('message.solicitud_action.comunidad'), ['class' =>
                        'control-label']) !!}<span class="required" style="color:red;">*</span>
                        {!! Form::select('comunidad_id', $comunidad, $solicitud_edit->comunidad_id, ['placeholder' =>
                        trans('message.solicitud_action.comunidad'),'class' => 'form-control','id' =>
                        'comunidad_id','disabled' => true]) !!}
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('direccion',trans('message.solicitud_action.direccion'), ['class' =>
                        'control-label']) !!}<span class="required" style="color:red;">*</span>
                        {!! Form::text('direccion',$solicitud_edit->direccion,['placeholder' =>
                        trans('message.solicitud_action.direccion'),'class' => 'form-control','id' =>
                        'direccion_user','disabled' => true]) !!}
                    </div>

                    <div style="text-align:left;">
                        {!! Form::label('tipo_solicitud_id',trans('message.solicitud_action.tipo_solicitud'), ['class'
                        => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                        {!! Form::select('tipo_solicitud_id', $tipo_solicitud,$solicitud_edit->tipo_solicitud_id,
                        ['placeholder' => trans('message.solicitud_action.tipo_solicitud'),'class' =>
                        'form-control','id' => 'tipo_solicitud_id','disabled' => true]) !!}
                    </div>


                    <div class="container-fluid">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered users_all">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Fecha</th>
                                            <th style="text-align:center;">Asunto</th>
                                            <th style="text-align:center;">Evidencia</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach ($seguimiento_edit as $seguimiento_edit_2);
                                            $arrayData = isset($seguimiento_edit_2->seguimiento) ?$seguimiento_edit_2->seguimiento: NULL;
                                            
                                            if ($arrayData == NULL) {
                                                $seguimientoPrueba = [];
                                                $arrayData = [];
                                            }else{
                                                $seguimientoPrueba = json_decode($arrayData, true);
                                            }                                            
                                        ?>
                                        @foreach ($seguimientoPrueba as $data)                                                                         
                                        <tr>
                                            <td>{{$data['item']}}</td>
                                            <td>{{$data['fecha']}}</td>
                                            <td>{{$data['asunto']}}</td>
                                            @if($data['imagen'] == 'Undefined')
                                            <td>Sin evidencia</td>
                                            @endif
                                            @if($data['imagen'] != NULL)
                                                <td>
                                                    <a href="{{ asset($data['imagen']) }}" target="_blank"> 
                                                        <img src="{{ asset($data['imagen']) }}" style="width: 120px;">
                                                    </a>
                                                </td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                foreach ($seguimiento_edit as $seguimiento_edit_2){
                }
            ?>
            {!! Form::open(array('route' => array('seguimiento.update',isset($seguimiento_edit_2->id) ?$seguimiento_edit_2->id: ''), 'method'=>'POST','id' =>
            'form_users_id','enctype' =>'multipart/form-data')) !!}
            <div class="-dialog">
                <div class="-content">
                    <div class="-header">
                        <h3 style="justify-content: center; font-size:20px;">Agregar Seguimiento</h3>
                        <button type="button" class="close" data-dismiss="">&times;</button>
                    </div>
                    <div class="-body">
                        <div style="text-align:left;">
                            {!! Form::label('asunto','Asunto del Caso', ['class' => 'control-label'])
                            !!}<span class="required" style="color:red;">*</span>
                            {!! Form::textarea('asunto',old('asunto'),['placeholder' => 'Asunto del Caso','class' =>
                            'form-control','id' => 'asunto']) !!}
                        </div>
                        <div style="text-align:left; margin: 10px 10px 10px 0px;">
                            {!! Form::label('asunto','Evidencia', ['class' => 'control-label']) !!}
                            <input type="file" name="image" id="image">
                        </div>
                    </div>
                    <div class="-footer">
                        <button type="submit" class="btn btn-primary" id="Agregar" data-dismiss="">Agregar</button>
                        <input type="text" hidden value="{{$solicitud_edit->id}}" name="solicitud_id">
                        <input type="text" hidden value="{{$solicitud_edit->tipo_solicitud_id}}" name="tipo_solicitud_id">
                    </div>
                </div>
            </div>
            {!! Form::close() !!}

            <div style="text-align:left;">
                {!! Form::label('status_id', 'Estado de Solicitud', ['class' =>
                'control-label']) !!}<span class="required" style="color:red;">*</span>
                {!! Form::select('status_id', $status_solicitud, $status_solicitud, ['placeholder' => 'Seleccionar Estado','class'
                => 'form-control','id' =>
                'status_id']) !!}
            </div>

            <?php                
                foreach ($seguimiento_edit as $index => $seguimientoID) {
                    if ($seguimientoID->id !== null) {  // Verificar si el ID existe
                        echo '<script> var id = ' . $seguimientoID->id . ';</script>';
                        echo '<script> var idsolicitud = ' . $seguimientoID->solicitud_id . ';</script>';
                        break; // Salir del bucle después de encontrar el primer ID válido
                    } else {
                        // Manejo del error si el primer ID es nulo
                        if ($index === 0) { // Solo manejar el error en la primera iteración
                            echo '<script>
                                console.error("Error: El primer seguimientoID no tiene un valor válido.");
                                alert("Ha ocurrido un error al cargar los datos. Por favor, inténtelo de nuevo.");
                            </script>';
                        }
                    }
                }
            ?>
            @endsection
            @section('script_datatable')
            <script type="text/javascript">        
            $(document).ready(function() {
    var seguimientoID = null; // Declaramos seguimientoID como null por defecto
    var solicitudID = null; // Declaramos solicitudID como null por defecto

    <?php                
        foreach ($seguimiento_edit as $index => $seguimientoID) {
            if ($seguimientoID->id !== null) { 
                echo "seguimientoID = " . $seguimientoID->id . ";\n";
                echo "solicitudID = " . $seguimientoID->solicitud_id . ";\n";
                break; 
            } else {
                if ($index === 0) { 
                    echo 'console.error("Error: El primer seguimientoID no tiene un valor válido.");';
                    echo 'alert("Ha ocurrido un error al cargar los datos. Por favor, inténtelo de nuevo.");';
                }
            }
        }
    ?>

    $('#status_id').on('change', function() {
        if (seguimientoID !== null) { // Verificamos si seguimientoID ya tiene un valor
            var nuevoValor = $(this).val();
            
            if (confirm('¿Desea ejecutar el cambio?')) {
                $.ajax({
                    url: '{{ route('update2') }}',
                    method: 'GET',
                    data: { 
                        id: seguimientoID,
                        solicitudID: solicitudID, 
                        nuevo_valor: nuevoValor
                    },
                    success: function(response) {
                        alert('¡Actualización exitosa!');
                        window.location.href = "/seguimiento";
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en la actualización: ' + error);
                    }
                });
            } 
        }
    });
});

            </script>
            @endsection