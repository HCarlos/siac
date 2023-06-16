<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Cabin&display=swap" rel="stylesheet">
    <title>Acerca de - SIACentro</title>
</head>

<style type="text/css">
    body, html {
        height: 100%;
    }

    .parallax {
        /* The image used */
        background-image: url("/images/background.png");

        /* Full height */
        height: 100%;

        /* Create the parallax scrolling effect */
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }


    .headerlogo {
        position: relative;
        float: none;
        margin: 50px 5% 0 auto;
        z-index: 999;
    }

    .getapp-nav-img {
        height: 60px;
        margin: auto;
    }

    @media (max-width: 480px) {
        .headerlogo {
            float: none;
            text-align: center;
            margin: 50px auto 0 auto;
        }
    }
</style>

<body class="parallax">

<div class="headerlogo" style="">
    <div class="social-nav">
        <img class="getapp-nav-img" src='/images/logo-1.png'/>
    </div>
</div>

<div style="margin-left:10%; margin-right: 10%; font-family: 'Cabin', sans-serif; text-align: center;">

    <h2><strong>Acerca de</strong></h2>

    <hr>

    <p>Desarrollado por la <strong>Coordinación de Modernización e Innovación </strong></p>

    <hr>

<!--    <a href="https://transparencia.villahermosa.gob.mx/AvisoPrivacidadSimplificado.php"><strong>Aviso de Privacidad</strong></a>-->

    <p><a href="mailto:apps@centro.gob.mx" target="_blank">apps@centro.gob.mx</a></p>

    <hr>

    <p> {{ now()->year }} © {{ config("atemun.nombre_empresa") }}, Villahermosa, Tabasco, México.</p>

</div>

</body>

</html>
