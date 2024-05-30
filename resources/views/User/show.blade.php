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
                <div class="form-group">
                <table style="float: right;">
                    <tr>
                        <td>
                            <div id="preview"><img src="{{ url('/storage/avatars/'.$user_View[0]->AVATAR) }}" style="width:150px; height:200px; border-radius:50%; margin-right:25px;"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>                            
                            </div>
                        </td>
                    </tr>
                </table> 
                <div class="col-lg-6 col-xs-6">                    
                        <div style="text-align:left;">
                            {!! Form::label('name',trans('message.users_action.nombre'), ['class' => 'control-label']) !!}                           
                            {!! Form::text('name',$user_View[0]->NAME,['placeholder' => trans('message.users_action.nombre'),'class' => 'form-control','id' => 'name_user','disabled' => true]) !!}                            
                        </div>                        
                        <div style="text-align:left;">
                            {!! Form::label('email',trans('message.users_action.email_user'), ['class' => 'control-label']) !!}
                            {!! Form::text('email',$user_View[0]->MAIL,['class' => 'form-control','id' => 'email_user','disabled' => true]) !!}
                        </div>
                        <div style="text-align:left;">                           
                        </div>
                        <div style="text-align:left;">
                            {!! Form::label('activo',trans('message.users_action.activo'), ['class' => 'control-label']) !!}                            
                            {!! Form::text('activo',$user_View[0]->ACTIVO,['class' => 'form-control','id' => 'activo_user','disabled' => true]) !!}                            
                        </div>
                        <div style="text-align:left;">
                            {!! Form::label('rols_id',trans('message.permisos_rol.roles'), ['class' => 'control-label']) !!}
                            {!! Form::text('rols_id',$user_View[0]->ROLS_NAME,['class' => 'form-control','id' => 'rols_id','disabled' => true]) !!}                            
                        </div>
                        <div style="text-align:left;">                            
                            {!! Form::label('init_day',trans('message.users_action.fecha_inicio'), ['class' => 'control-label']) !!}                            
                            {!! Form::date('init_day',$user_View[0]->FECHA_INICIO,['class' => 'form-control','id' => 'init_day','disabled' => true]) !!}                            
                        </div>
                        <div style="text-align:left;">                            
                            {!! Form::label('end_day',trans('message.users_action.fecha_fin'), ['class' => 'control-label']) !!}
                            {!! Form::date('end_day',$user_View[0]->FECHA_FIN,['class' => 'form-control','id' => 'end_day','disabled' => true]) !!}                            
                        </div>                        
                </div>                        
                </div>
            </div>             
        </div>
    </div>
</div>
@endsection