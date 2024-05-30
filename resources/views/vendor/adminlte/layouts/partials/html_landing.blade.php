<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">    
    <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' > 
    <meta name="description" content="Adminlte-laravel - {{ trans('message.landingdescription') }} ">
    <meta name="author" content="Tarsicio Carrizales">    

    <title>{{ trans('message.landingdescriptionpratt') }}</title>

    <!-- Custom styles for this template -->
    <link href="{{ asset('/css/all-landing.css') }}" rel="stylesheet">

    <link href='https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>
    <link href="{{ url ('/css_datatable/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url ('/css_bootstrap/bootstrap-theme.min.css') }}" rel="stylesheet">
    <link href="{{ url ('/css_datatable/responsive.bootstrap.min.css') }}" rel="stylesheet">
    @laravelPWA
</head>
<body data-spy="scroll" data-target="#navigation" data-offset="50">
<!-- Libreria DomPdf para Imprimir segun sea el caso -->
<div id="app" v-cloak>