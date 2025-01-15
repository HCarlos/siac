<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>


    <link href="{{ asset('images/favicon/favicon.png') }}" rel="shortcut icon">
    <link href="{{ asset('images/favicon/favicon-32-32.png') }}" rel="shortcut icon" sizes="32x32">
    <link href="{{ asset('images/favicon/favicon-114-114.png') }}" rel="apple-touch-icon" sizes="114x114">
    <link href="{{ asset('images/favicon/favicon-157-157.png') }}" rel="apple-touch-icon" sizes="157x157">
    <link href="{{ asset('images/favicon/favicon-180-180.png') }}" rel="apple-touch-icon" sizes="180x180">
    <link href="{{ asset('images/favicon/favicon-192-192.png') }}" rel="apple-touch-icon" sizes="192x192">
    <link href="{{ asset('images/favicon/favicon-270-270.png') }}" rel="apple-touch-icon" sizes="270x270">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300|Raleway|Roboto+Condensed|Tangerine&effect=3d-float" rel="stylesheet">
    <link href="{{ asset('css/atemun.css') }}" rel="stylesheet">
    <link href="{{ asset('css/servimun.css') }}" rel="stylesheet">

    <style>
        html, body {
            background-color: #fff;
            background: url('{{asset("images/bg-auth.png")}}') no-repeat center;
            background-size: cover;
            min-height: 100vh;
            color: #fff;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            width: 98%;
            text-align: right;
            background: transparent;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }
        .subtitle {
            font-size: 42px;
        }
        lu, li{
            list-style: none;
            background-size: cover !important;
            background-color: transparent !important;
        }
        .links a {
            color: darkred !important;
            padding: 0 25px;
            font-family: 'Raleway', sans-serif;
            font-size: 20px;
            font-weight: bold !important;
            letter-spacing: .1rem;
            text-decoration: none !important;;
            list-style:none !important;
            text-transform: uppercase;
            background-size: cover;
            text-shadow: white 2px 0px 5px;
        }
        .m-b-md {
            margin-bottom: 30px;
        }
        .navbar, .navbar-nav{
            background-size: cover !important;
            background-color: transparent !important;
        }
        .aviso_privacidad {
            color: floralwhite !important;
            padding: 0 2px;
            font-size: 16px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none !important;;
            list-style:none !important;
            text-transform: uppercase;
            background-size: cover;
        }
    </style>

</head>

<body>
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <ul class="navbar navbar-nav">
            <li class="links top-right " >
                @auth
                    <a href="{{ url('/home') }}" class="" ><strong>Entrar</strong></a>
                @else
                    <a href="{{ route('login') }}" class="text-white "><strong>Iniciar sesión</strong></a>
                @endauth
            </li>
        </ul>
    @endif
    <div class="content" style="margin-top: -15em;">
        <span class="text-cafe  font-effect-3d-float font_Tangerine_700"></span>
    </div>
    <p class="wellcome-pos-version font_Open_Sans_Condensed_300">v 1.0   | <a href="/privacidad" class="aviso_privacidad"  target="_blank">Aviso de Privacidad</a></p>
</div>
</body>
</html>
