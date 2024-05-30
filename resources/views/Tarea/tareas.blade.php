@extends('adminlte::layouts.app')

@section('css_database')
    @include('adminlte::layouts.partials.link')
@endsection

@section('htmlheader_title')
    {{ trans('message.home_1') }}
@endsection

@section('contentheader_title')
    <h2 class="mb-4">{{ trans('message.alltasks') }}</h2>
@endsection

    
@section('main-content')
<div class="container-fluid">
<div class="card">
    <div class="card-body">
        <div style="text-align:center;">
            <h1 class="mb-4">{{ trans('message.mensajes_alert.implementar') }}</h1>
        </div>
    </div>
</div>
</div>
@endsection

