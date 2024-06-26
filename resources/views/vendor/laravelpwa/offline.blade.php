<html>
<head>
    <title>{{ trans('adminlte_lang::message.landingdescriptionpratt') }}</title>
    <link href="{{ url ('/css_datatable/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url ('/css_bootstrap/bootstrap-theme.min.css') }}" rel="stylesheet">
    <link href="{{ url ('/css_datatable/responsive.bootstrap.min.css') }}" rel="stylesheet">
    @laravelPWA
</head>
<body>
  <hr>    
    <div style="text-align: center;">
        <a href="{{ url('/') }}" id="id_return" class="btn btn-sm btn-primary" style="color:black;" data-toggle="tooltip" title="retornar"><b>Go to Internet / Ir a Internet</b></a>
    </div>
    <div style="text-align:center">
    <h1>{{ trans('message.home.modopwa') }}</h1>
    </div>
    <section id="intro" class="clearfix">
      <div class="container">
        <div style="text-align:center;"><h1>{{ trans('message.home.sistema') }}</h1></div>
        <div style="text-align:center;"><h3>{{ trans('message.home.titulo_01') }}</h3></div>
        <div style="text-align:center;"><h3>{{ trans('message.home.titulo_02') }}</h3></div>
        <div class="intro-img" style="text-align:center;">
          <img src="{{ url('intro-img.svg') }}" alt="" class="img-fluid" style="width: 530px; height: 300px;">
        </div>
        <div style="text-align:center;">
        </div>
        <div style="text-align:center;">
        </div>        
      </div>
    </section><!-- #intro -->
    <script src="{{ url ('/js_datatable/jquery-3.5.1.js') }}" type="text/javascript"></script>
    <script src="{{ url ('/js_delete/sweetalert.min.js') }}" type="text/javascript"></script>
    <script src="{{ url ('/indexdDB/indexdDB.min.js') }}" type="text/javascript"></script>    
</body>
</html>