@include('adminlte::layouts.partials.html_landing')

<section>
    <div style="text-align: center;">
        <h1><b>{{ trans('message.mensajes_alert.denegado') }}</b></h1>
    </div>
    <div style="text-align: center;">
        <h1>{{ trans('message.mensajes_alert.mensaje') }}</h1>
    </div>    
    <div style="text-align: center;">
        <h1>{{ trans('message.mensajes_alert.gracias') }}.</h1>
    </div>
</section>
    <!-- Fixed navbar -->
@include('adminlte::layouts.partials.nav')
    <!-- Fin de la barra de navegación fija -->
    <!--==========================
    Intro Section
    ============================-->
@include('adminlte::layouts.partials.section_landing')