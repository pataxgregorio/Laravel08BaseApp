@extends('adminlte::layouts.auth')

@section('htmlheader_title')
    Log in
@endsection

@section('content')
<body class="hold-transition login-page">
    <div id="app" v-cloak>
        <div class="login-box">
            <div class="login-logo">
                <a href="{{ url('/dashboard') }}"><b>Sistema Integral de Atención</a>
            </div><!-- /.login-logo -->
                   
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> {{ trans('message.someproblems') }}<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="login-box-body">
        <p class="login-box-msg"> {{ trans('message.siginsession') }} </p>

        <login-form name="{{ config('auth.providers.users.field','email') }}"
                    domain="{{ config('auth.defaults.domain','') }}"></login-form>


        <a href="{{ url('/password/reset') }}">{{ trans('message.forgotpassword') }}</a><br>
        <a href="{{ url('/register') }}" class="text-center">{{ trans('message.registermember') }}</a>

    </div>

    </div>
    </div>
    @include('adminlte::layouts.partials.scripts_auth')
</body>

@endsection
