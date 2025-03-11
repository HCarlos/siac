<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Integral de Atención Ciudadana</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>

    <link href="{{ asset('images/favicon/favicon.png') }}" rel="shortcut icon">
    <link href="{{ asset('images/favicon/favicon-32-32.png') }}" rel="shortcut icon" sizes="32x32">
    <link href="{{ asset('images/favicon/favicon-114-114.png') }}" rel="apple-touch-icon" sizes="114x114">
    <link href="{{ asset('images/favicon/favicon-157-157.png') }}" rel="apple-touch-icon" sizes="157x157">
    <link href="{{ asset('images/favicon/favicon-180-180.png') }}" rel="apple-touch-icon" sizes="180x180">
    <link href="{{ asset('images/favicon/favicon-192-192.png') }}" rel="apple-touch-icon" sizes="192x192">
    <link href="{{ asset('images/favicon/favicon-270-270.png') }}" rel="apple-touch-icon" sizes="270x270">
    <link href="https://fonts.googleapis.com/css?family=Raleway|PT+Sans+Narrow|Roboto:400,400i,500,500i|Roboto+Mono|Roboto+Condensed|Kaushan+Script&effect=3d-float" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous"><!-- third party css -->

    <link rel="stylesheet" href="{{ asset('css/login_v2.css') }}">

    <script async src="https://www.google.com/recaptcha/api.js"></script>
</head>
<body>
<div class="hero-section">
{{--    <img src="{{ asset('images/background_v2.png') }}" alt="Fondo" class="hero-image">--}}
    <div class="card">
        <div class="card-header">
            <span>Ingreso</span>
        </div>
        <div class="card-body">
            <form action="{{ route('login') }}" method="POST">
                @csrf
                    <label for="username" class="{{$errors->has('username')?'text-danger':'text-default'}}">CURP, Username o Correo Electrónico</label>
                    <input type="text" id="username" name="username" class="{{$errors->has('username')?'has-error form-error':''}}" required>
                    @if ($errors->has('username'))
                        <span class="has-error">
                            <strong class="text-danger">{{ $errors->first('username') }}</strong>
                        </span>
                    @endif

                <label for="password" class="{{$errors->has('password')?'text-danger':'text-default'}}">Contraseña</label>
                <input type="password" id="password" name="password" class="{{$errors->has('password')?'has-error form-error':''}}" required>
                @if ($errors->has('password'))
                    <span class="has-error">
                        <strong class="text-danger">{{ $errors->first('password') }}</strong>
                    </span>
                @endif

                <a href="{{ route('password.request') }}" class=" float-right text-danger "><strong>¿Olvidaste tu contraseña?</strong></a>

                <div class="captcha-container mt-1 mb-1">
                    <div class="g-recaptcha " data-sitekey={{config('services.recaptcha.key')}}></div>
                </div>

                <div class="options mb-1">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Recordar</label>
                </div>
                <button type="submit">Iniciar Sesión</button>
            </form>
{{--            <p><span>¿No tienes cuenta?</span>          <a href="{{ route('register') }}">Regístrate aquí</a></p>--}}

        </div>
    </div>
    <div class="privacy-notice">
        <span class="aviso_privacidad text-verde-morena-bold">Versión 2.0 </span>   | <a href="/privacidad" class="aviso_privacidad"  target="_blank">Aviso de Privacidad</a>
    </div>
</div>
</body>
</html>
