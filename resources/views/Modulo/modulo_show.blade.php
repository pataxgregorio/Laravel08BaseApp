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
    @component('components.boton_back',['ruta' => route('modulos.index'),'color' => $array_color['back_button_color']])
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
                    <div class="col-lg-6 col-xs-6">                    
                        <div class="form-group">                                            
                                <div style="text-align:left;">
                                    {!! Form::label('name',trans('message.modulo_action.nombre'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                                    {!! Form::text('name',$modulo->name,['class' => 'form-control','id' => 'name_rol','disabled' => true]) !!}
                                </div>
                                <div style="text-align:left;">
                                    {!! Form::label('description',trans('message.modulo_action.description'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                                    {!! Form::text('description',$modulo->description,['class' => 'form-control','id' => 'name_description','disabled' => true]) !!}
                                </div>                                                        
                        </div>                        
                    </div>                        
                </div>
            </div>             
        </div>
    </div>
</div>
@endsection