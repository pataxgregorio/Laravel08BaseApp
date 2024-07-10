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
                {!! Form::open(array('route' => array('users.update',$user_edit->id),
                'method'=>'POST','id' => 'form_users_id','enctype' =>'multipart/form-data')) !!}
                <div class="form-group">
                <table style="float: right;">
                    <tr>
                        <td>
                            <div id="preview"><img src="{{ url('/storage/avatars/'.$user_edit->avatar) }}" style="width:150px; height:200px; border-radius:50%; margin-right:25px;"></div>
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
                            @if($user_edit->id == 1)
                                {!! Form::text('name',$user_edit->name,['placeholder' => trans('message.users_action.nombre'),'class' => 'form-control','id' => 'name_user','disabled' => true]) !!}
                            @else
                                {!! Form::text('name',$user_edit->name,['placeholder' => trans('message.users_action.nombre'),'class' => 'form-control','id' => 'name_user']) !!}
                            @endif 
                        </div>                        
                        <div style="text-align:left;">
                            {!! Form::label('email',trans('message.users_action.email_user'), ['class' => 'control-label']) !!}
                            {!! Form::email('email',$user_edit->email,['placeholder' => trans('message.users_action.mail_ejemplo'),'class' => 'form-control','id' => 'email_user','disabled' => true]) !!}
                        </div>
                        <div style="text-align:left;">
                            {!! Form::label('password',trans('message.users_action.password'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                            {!! Form::password('password',['class' => 'form-control','id' => 'password_user']) !!}
                            <span class="fa fa-fw fa-eye password-icon show-password" style="float: right; position: relative; margin: -25px 10px 0 0; cursor: pointer;"></span>
                        </div>
                        <div style="text-align:left;">
                            {!! Form::label('activo',trans('message.users_action.activo'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                            @if($user_edit->id == 1)
                                {!! Form::select('activo',['DENY' => 'DENY','ALLOW' => 'ALLOW'],$user_edit->activo,['class' => 'form-control','id' => 'activo_user','disabled' => true]) !!}
                            @else
                                @if($rols_id == 1)
                                    {!! Form::select('activo',['DENY' => 'DENY','ALLOW' => 'ALLOW'],$user_edit->activo,['class' => 'form-control','id' => 'activo_user']) !!}
                                @else
                                    {!! Form::select('activo',['DENY' => 'DENY','ALLOW' => 'ALLOW'],$user_edit->activo,['class' => 'form-control','id' => 'activo_user','disabled' => true]) !!}
                                @endif                                
                            @endif    
                        </div>
                        @if($rols_id == 1)                        
                        <div style="text-align:left;">
                            {!! Form::label('direccion_id',trans('message.solicitud_action.direcciones'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                            {!! Form::select('direccion_id', $direccion, $user_edit->direccion_id, ['placeholder' => trans('message.solicitud_action.direcciones'),'class' => 'form-control','id' => 'direccion_id']) !!}
                        </div>
                        @endif
                        @if($rols_id != 1)                        
                        <div style="text-align:left;">
                            {!! Form::label('direccion_id',trans('message.solicitud_action.direcciones'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                            {!! Form::select('direccion_id', $direccion, $user_edit->direccion_id, ['placeholder' => trans('message.solicitud_action.direcciones'),'class' => 'form-control','id' => 'direccion_id', 'disabled' => true]) !!}
                        </div>
                        @endif
                        <div style="text-align:left;">
                            {!! Form::label('rols_id',trans('message.permisos_rol.roles'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                            @if($user_edit->id == 1)
                                {!! Form::select('rols_id', $roles, $user_edit->rols_id, ['placeholder' => trans('message.permisos_rol.opcion'),'class' => 'form-control','id' => 'rols_id','disabled' => true]) !!}
                            @else
                                @if($rols_id == 1)
                                    {!! Form::select('rols_id', $roles, $user_edit->rols_id, ['placeholder' => trans('message.permisos_rol.opcion'),'class' => 'form-control','id' => 'rols_id']) !!}
                                @else
                                    {!! Form::select('rols_id', $roles, $user_edit->rols_id, ['placeholder' => trans('message.permisos_rol.opcion'),'class' => 'form-control','id' => 'rols_id','disabled' => true]) !!}
                                @endif                                
                            @endif
                        </div>
                        <div style="text-align:left;">                            
                            @if($user_edit->id == 1)
                                {!! Form::label('init_day',trans('message.users_action.fecha_inicio'), ['class' => 'control-label']) !!}                                
                                {!! Form::date('init_day',$user_edit->init_day,['class' => 'form-control','id' => 'init_day','disabled' => true]) !!}
                            @else
                                {!! Form::label('init_day',trans('message.users_action.fecha_inicio'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                                @if($rols_id == 1)
                                    {!! Form::date('init_day',$user_edit->init_day,['class' => 'form-control','id' => 'init_day']) !!}
                                @else
                                    {!! Form::date('init_day',$user_edit->init_day,['class' => 'form-control','id' => 'init_day','disabled' => true]) !!}
                                @endif
                                
                            @endif
                        </div>
                        <div style="text-align:left;">                            
                            @if($user_edit->id == 1)
                                {!! Form::label('end_day',trans('message.users_action.fecha_fin'), ['class' => 'control-label']) !!}
                                {!! Form::date('end_day',$user_edit->end_day,['class' => 'form-control','id' => 'end_day','disabled' => true]) !!}
                            @else
                                {!! Form::label('end_day',trans('message.users_action.fecha_fin'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                                @if($rols_id == 1)
                                    {!! Form::date('end_day',$user_edit->end_day,['class' => 'form-control','id' => 'end_day']) !!}
                                @else
                                    {!! Form::date('end_day',$user_edit->end_day,['class' => 'form-control','id' => 'end_day','disabled' => true]) !!}
                                @endif                                
                            @endif
                        </div>                        
                </div>        
                <hr>
                        {!! Form::submit(trans('message.users_action.update_user'),['class'=> 'form-control btn btn-primary','title' => trans('message.users_action.update_user'),'data-toggle' => 'tooltip','style' => 'background-color:'.$array_color['group_button_color'].';']) !!}                     
                </div>
                <input type="hidden" name="id_user" value="{{$user_edit->id}}">
                {!!  Form::close() !!}
            </div>             
        </div>
    </div>
</div>
@endsection
@section('script_datatable')
    <script src="{{ url ('/js_users/js_users.min.js') }}" type="text/javascript"></script>
@endsection  