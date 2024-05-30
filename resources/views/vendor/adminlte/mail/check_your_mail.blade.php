@include('adminlte::layouts.partials.html_landing')

<section>
    <div style="text-align: center;">
        <h1><b>{{ trans('message.msg_notification.mensaje1') }}</b></h1>
    </div>
    <div style="text-align: center;">
        <h1>{{ trans('message.msg_notification.mensaje2') }}</h1>
    </div>    
    <div style="text-align: center;">
        <h1>{{ trans('message.msg_notification.mensaje3') }}</h1>
    </div>    
    <div style="text-align: center;">
        <h1>{{ trans('message.msg_notification.mensaje4') }}</h1>
    </div>
</section>
    <!-- Fixed navbar -->
@include('adminlte::layouts.partials.nav')
    <!-- Fin de la barra de navegación fija -->
    <!--==========================
    Intro Section
    ============================-->
@include('adminlte::layouts.partials.section_landing')