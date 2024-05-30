@extends('adminlte::layouts.app')

@section('css_database')
    @include('adminlte::layouts.partials.link')
@endsection

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.home') }}
@endsection

@section('contentheader_title')
<div>
    <h2 class="mb-4">{{ $titulo_modulo}}</h2>
    @component('components.boton_back',['ruta' => route('users.index'),'color' => $array_color['back_button_color']])
        Botón de retorno
    @endcomponent   
</div>
    
@endsection

    
@section('main-content')

<div class="container-fluid">
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
                {!! Form::open(array('route' => array('users.store'),
                'method'=>'POST','id' => 'form_users_id','enctype' =>'multipart/form-data')) !!}
                <div class="form-group">
                <table style="float: right;">
                    <tr>
                        <td>
                            <div id="preview"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>
                            {!! Form::label('avatar',trans('message.users_action.avatar_user'), ['class' => 'control-label']) !!}
                            {!! Form::file('avatar',['class' => 'form-control','id' => 'avatar_user','name' => 'avatar']) !!}
                            </div>
                        </td>
                    </tr>
                </table> 
                <div class="col-lg-6 col-xs-6">                    
                        <div style="text-align:left;">
                            {!! Form::label('name',trans('message.users_action.nombre'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                             {!! Form::text('name',old('name'),['placeholder' => trans('message.users_action.nombre'),'class' => 'form-control','id' => 'name_user']) !!}
                        </div>                        
                        <div style="text-align:left;">
                            {!! Form::label('email',trans('message.users_action.email_user'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                            {!! Form::email('email',old('email'),['placeholder' => trans('message.users_action.mail_ejemplo'),'class' => 'form-control','id' => 'email_user']) !!}
                        </div>
                        <div style="text-align:left;">
                            {!! Form::label('password',trans('message.users_action.password'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                            {!! Form::password('password',['class' => 'form-control','id' => 'password_user']) !!}
                            <span class="fa fa-fw fa-eye password-icon show-password" style="float: right; position: relative; margin: -25px 10px 0 0; cursor: pointer;"></span>
                        </div>
                        <div style="text-align:left;">
                            {!! Form::label('activo',trans('message.users_action.activo'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                            {!! Form::select('activo',['DENY' => 'DENY'],'DENY',['class' => 'form-control','id' => 'activo_user']) !!}
                        </div>
                        <div style="text-align:left;">
                            {!! Form::label('direccion_id',trans('message.solicitud_action.direcciones'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                            {!! Form::select('direccion_id', $direccion, old('direccion_id'), ['placeholder' => trans('message.solicitud_action.direcciones'),'class' => 'form-control','id' => 'direccion_id']) !!}
                        </div>
                        <div style="text-align:left;">
                            {!! Form::label('rols_id',trans('message.permisos_rol.roles'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                            {!! Form::select('rols_id', $roles, old('rols_id'), ['placeholder' => trans('message.permisos_rol.opcion'),'class' => 'form-control','id' => 'rols_id']) !!}
                        </div>
                        <div style="text-align:left;">
                            {!! Form::label('init_day',trans('message.users_action.fecha_inicio'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                            {!! Form::date('init_day',null,['class' => 'form-control','id' => 'init_day']) !!}
                        </div>
                        <div style="text-align:left;">
                            {!! Form::label('end_day',trans('message.users_action.fecha_fin'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                            {!! Form::date('end_day',null,['class' => 'form-control','id' => 'end_day']) !!}
                        </div>                        
                </div>        
                <hr>
                        {!! Form::submit(trans('message.users_action.new_user'),['class'=> 'form-control btn btn-primary','title' => trans('message.users_action.new_user'),'data-toggle' => 'tooltip','style' => 'background-color:'.$array_color['group_button_color'].';']) !!}                     
                </div>      
                {!!  Form::close() !!}
            </div>             
        </div>
    </div>
</div>
@endsection
@section('script_datatable')
    <script src="{{ url ('/js_users/js_users.min.js') }}" type="text/javascript"></script>
@endsection  