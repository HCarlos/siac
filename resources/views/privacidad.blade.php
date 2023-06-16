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
    <link href="https://fonts.googleapis.com/css?family=Raleway|PT+Sans+Narrow|Roboto:400,400i,500,500i|Roboto+Mono|Roboto+Condensed|Kaushan+Script&effect=3d-float" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous"><!-- third party css -->
    <link href="{{ asset('css/app.css' )}}" rel="stylesheet" type="text/css" />

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300|Raleway|Roboto+Condensed|Tangerine&effect=3d-float" rel="stylesheet">

    <style>
        html, body {
            background-color: #fff;
            background: url('{{asset("images/web/aviso".rand(1,2).".png")}}') no-repeat center;
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
            font-size: 16px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none !important;;
            list-style:none !important;
            text-transform: uppercase;
            background-size: cover;
        }
        .m-b-md {
            margin-bottom: 30px;
        }
        .navbar, .navbar-nav{
            background-size: cover !important;
            background-color: transparent !important;
        }
    </style>

</head>

<body>
<div class="container">
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            <div class="flex-center position-ref full-height">
                <div class="card card-body " style="background-color: dimgrey; box-shadow: 4px 4px 8px  floralwhite" >
                    <h3 class="card-title text-white text-center">Aviso de Privacidad<br><br></h3>
                    <p class=" text-white text-justify">
                        Los datos recabados en este formato, serán protegidos, incorporados y tratados en los términos establecidos en la Ley General de Protección de Datos Personales en posesión de Sujetos Obligados y los Lineamientos de la Ley de Protección de Datos Personales y Posesión de Sujetos Obligados del Estado de Tabasco y demás normatividad aplicable.<br><br> Por lo anterior, los datos personales que se recabarán en esta plataforma, son: <strong class="text-black-50 font-weight-bold"><i>nombre, edad, sexo, estado civil, ocupación, escolaridad, CURP, e-mail, teléfono celular</i></strong>. <br><br>En ese sentido, de conformidad con los artículos 20 fracción III, 26 y 27 de la Ley General de Protección de Datos Personales en Posesión de Sujetos Obligados, en relación con los numerales 29, 30, 31, 33, 76 y 77, de la Ley de Protección de Datos Personales en Posesión de Sujetos Obligados del Estado de Tabasco, se hace de su conocimiento que los datos recabados únicamente serán utilizados para el fin de un servicio más eficiente en la gestion de su demanda ciudadana. <br><br>No se realizarán transferencias adicionales, salvo aquellas que sean necesarias para atender requerimientos de información de una autoridad competente, que estén debidamente fundados y motivados. <br><br>Usted podrá ejercitar sus derechos de Acceso, Rectificación, Cancelación, Oposición y de Portabilidad de sus datos personales, directamente a la Unidad de Transparencia de este H. Ayuntamiento de Centro, ubicado en Calle Retorno Vía 5, Edifico 105, 2do. Piso, Tabasco 2000, de la ciudad de Villahermosa, Tabasco, C.P. 86035, con horario de 8:00 a 16:00 horas en días hábiles, bajo la responsabilidad de la Lic. Beatriz Adriana Roja Ysquierdo o en la plataforma nacional de transparencia (PNT) con dirección electrónica: <a href="https://www.plataformadetransparencia.org.mx/" target="_blank" class="text-black-50  font-weight-bold">https://www.plataformadetransparencia.org.mx/ </a>
                    </p>
                </div> <!-- end card-->
            </div>
        </div>
        <div class="col-sm-2"></div>
    </div>
</div>
</body>
</html>
