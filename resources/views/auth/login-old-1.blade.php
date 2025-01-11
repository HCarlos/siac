@extends('layouts.app')

@section('styles')
<script async src="https://www.google.com/recaptcha/api.js"></script>
{{--<script async src="{{ asset('js/recaptcha-api.js') }}"></script>--}}

@endsection

@section('content')


<body class="auth-fluid-pages bg-registry  pb-0 m-0" >

    <div class="auth-fluid m-0 p-0">
        <!--Auth fluid left content -->
        <div class=" p-0 m-0 bg-form" >
            <div class="d-flex h-15 " >
                @include('shared.code.__logo_guest')
            </div>
            <div class="align-items-center " >
                <div class="card-body">
                    <!-- title-->
{{--                        <div class="auth-fluid p-2">--}}

                    <h4 class="mt-0 color-title text-white">Ingresar</h4>
                    <p class="text-muted mb-3"></p>
                    <!-- form -->
                    <form method="POST" action="{{ route('login') }}" class="mt-0">
                        @csrf
                        <div class="form-group">
                            <label for="username" class="{{$errors->has('username')?'text-danger':'text-white'}}">CURP, Username ó Correo Electrónico</label>
                            <input class="form-control {{$errors->has('username')?'has-error form-error':''}}" type="text" id="username" name="username" value="{{ old('username') }}" required placeholder="CURP, Username o Correo Electrónico">
                            @if ($errors->has('username'))
                                <span class="has-error">
                                        <strong class="text-danger">{{ $errors->first('username') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <a href="{{ route('password.request') }}" class=" float-right text-danger"><strong>¿Olvidaste tu contraseña?</strong></a>
                            <label for="password" class="{{$errors->has('password')?'text-danger':'text-white'}}">Contraseña</label>
                            <input class="form-control {{$errors->has('password')?'has-error form-error':''}}" type="password" required="" id="password" name="password" placeholder="Contraseña">
                            @if ($errors->has('password'))
                                <span class="has-error">
                                        <strong class="text-danger">{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group">
                        <div class="g-recaptcha mt-4" data-sitekey={{config('services.recaptcha.key')}}></div>
                        </div>

                        <div class="form-group mb-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="checkbox-signin">
                                <label class="custom-control-label  text-danger" for="checkbox-signin">Recordar</label>
                            </div>
                        </div>
                        <div class="form-group mb-4 text-center">
                            <button class="btn btn-danger btn-danger-primary btn-block" type="submit"
                            ><i class="mdi mdi-login"></i> INICIAR SESIÓN </button>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group  mt-2">
                            <p class="text-white float-left">¿No tienes cuenta?</p>
                            <a href="{{ route('register') }}" class="text-danger-light float-right  text-danger"><strong>Regístrate aquí</strong></a>
                        </div>

                    </form>
                    <!-- end form-->
{{--                        </div>--}}
                </div> <!-- end .card-body -->
            </div> <!-- end .align-items-center.d-flex.h-100-->
        </div>
        <!-- end auth-fluid-form-box-->

        <!-- Auth fluid right content -->
        <div class="auth-fluid-right  m-0 p-0" >
            <img src="/images/web/bg-auth-login.png" height="100%" width="100%"  />
        </div>
        <!-- end Auth fluid right content -->
    </div>
    <!-- end auth-fluid-->

    <!-- App js -->
    @include('partials/script_footer')

    <!-- Replace the variables below. -->
    <script>
        function onSubmit(token) {
            document.getElementById("demo-form").submit();
        }
    </script>

    </body>


@endsection

