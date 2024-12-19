<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Correo de Empresa</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .email-header {
            background-color: #0073e6;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }

        .email-body {
            padding: 20px;
        }

        .email-body p {
            line-height: 1.6;
            margin: 10px 0;
        }

        .email-button {
            display: block;
            text-align: center;
            margin: 20px 0;
        }

        .email-button a {
            text-decoration: none;
            background-color: #0073e6;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
        }

        .email-footer {
            background-color: #f4f4f4;
            padding: 10px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }

        .email-footer a {
            color: #0073e6;
            text-decoration: none;
        }

        @media (max-width: 600px) {
            .email-container {
                width: 90%;
            }

            .email-header h1 {
                font-size: 20px;
            }

            .email-body p {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
<div class="email-container">
    <!-- Header -->
    <div class="email-header">
        <h1>¡Hola a {{ $user->fullName  }}!</h1>
    </div>

    <!-- Body -->
    <div class="email-body">
        <p>La solicitud {{ $denuncia->id  }}, ha cambiado de estatus a <strong>{denuncia->ultimo_estats}}</strong></p>

        <!-- Button -->
        <div class="email-button">
            <a href="https://siac.villahermosa.gob.mx/listDenunciaDependenciaServicioAmbito/{{ $denuncia->id }}" target="_blank">Revisar Ahora</a>
        </div>
    </div>

    <!-- Footer -->
    <div class="email-footer">
        <p>&copy; {{ date('Y') }} {{env('NOMBRE_EMPRESA')}}. Todos los derechos reservados.</p>
        <p>
            <a href="https://www.villahermosa.gob.mx">Villahermosa.gob.mx</a> |
            <a href="https://transparencia.villahermosa.gob.mx/AvisoPrivacidadSimplificado.php?_gl=1*1tr38fm*_ga*ODA0NTgwNTkuMTY5NzEzMDU1Ng..*_ga_P9FBN46LXM*MTczNDYzMTY5Ny43OC4wLjE3MzQ2MzE2OTguMC4wLjA.">Política de Privacidad</a>
        </p>
    </div>
</div>
</body>
</html>
