<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIAC Team!</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">

</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f4; font-family: Arial, sans-serif; color: #333; line-height: 1.5;">
<table role="presentation" style="width: 100%; border-spacing: 0; border-collapse: collapse; background-color: #f4f4f4; margin: 0; padding: 0;">
    <tr>
        <td align="center" style="padding: 20px 0;">
            <a href="https://www.villahermosa.gob.mx" target="_blank">
                <img src="https://siac.villahermosa.gob.mx/images/web/logo-0.png" alt="Villahermosa.gob.mx" style="max-width: 100%; width: 140px; height: 40px; display: block; margin: 0 auto; margin-bottom: 1em;">
            </a>
            <!-- Email Container -->
            <table role="presentation" style="width: 600px; max-width: 100%; background-color: #ffffff; border-spacing: 0; border-collapse: collapse; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);">

                <!-- Header -->
                <tr>
                    <td style="
                        background-color: rgba(239, 185, 165, 0.85);
                        padding: 20px;
                        text-align: center;
                        color: #870606;
                        font-family: 'Poppins', sans-serif;
                    ">
                        <h1 style="
                           margin: 0;
                            font-size: 28px;
                            font-weight: bold;
                            text-shadow: 2px 2px 4px rgb(48,45,45);
                            line-height: 1.2;
                        ">
                            Servicios Municipales
                        </h1>
                        <h2 style="
                           margin: 0;
                            font-size: 22px;
                            font-weight: bold;
                            text-shadow: 2px 2px 4px rgb(48,45,45);
                            line-height: 1.2;
                        ">
                            Centro Tabasco
                        </h2>
                    </td>
                </tr>
                <!-- Body -->
                <tr>
                    <td style="padding: 20px; text-align: left; font-size: 16px; color: #333;">
                        <p style="margin: 0 0 10px;">Hola <strong>{{ $user->username  }}</strong>,</p>
                        <p style="margin: 0 0 10px;">La solicitud <strong>{{$denuncia->id}}</strong>
                        @if($type === 0)
                                se ha <strong>CREADO</strong> con fecha {{$fecha_creacion}}
                        @elseif($type === 3)
                                ha CAMBIADO de ESTATUS a <strong>{{$denuncia->ultimo_estatus}}</strong> con fecha {{ $denuncia->fecha_ultimo_estatus }}
                        @elseif($type === 2)
                                ha sido <strong>Eliminada</strong> por: {{Auth::user()->fullName}}
                        @else
                                Hubo un Problema
                        @endif
                        </p>
                        <br style="margin: 0 0 20px;">¡Gracias por usar nuestra aplicación!.</br> ¡Estamos aquí para ayudarte!</p>

                        <!-- Button -->
                        <div style="text-align: center; margin: 20px 0;">
                            <a href="https://siac.villahermosa.gob.mx/listDenunciaDependenciaServicioAmbito/{{$denuncia->id}}" style="text-decoration: none; background-color: #870606; color: #ffffff; padding: 12px 24px; border-radius: 5px; font-size: 16px; font-weight: bold; display: inline-block;">
                                Revisar ahora
                            </a>
                        </div>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background-color: #f4f4f4; text-align: center; font-size: 12px; color: #666; padding: 10px;">
                        <p style="margin: 0;">&copy; {{ date('Y') }} {{env('NOMBRE_EMPRESA')}}. Todos los derechos reservados.</p>
                        <p style="margin: 5px 0;">
                            <a href="https://www.villahermosa.gob.mx">Villahermosa.gob.mx</a> |
                            <a href="https://transparencia.villahermosa.gob.mx/AvisoPrivacidadSimplificado.php?_gl=1*1tr38fm*_ga*ODA0NTgwNTkuMTY5NzEzMDU1Ng..*_ga_P9FBN46LXM*MTczNDYzMTY5Ny43OC4wLjE3MzQ2MzE2OTguMC4wLjA.">Política de Privacidad</a>
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>
</body>
</html>
