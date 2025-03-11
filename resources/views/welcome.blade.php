<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Botón con Redirección</title>
    <style>
        /* Estilo del body con la imagen de fondo */
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background-image: url('/images/background_v2.png');
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Ajustes para iPhone 11 (modo retrato) */
        @media only screen and (max-width: 414px) {
            body {
                background-size: contain;  /* Muestra la imagen completa sin recortes */
                background-position: center top; /* Ajusta la posición para dispositivos pequeños */
            }
        }

        /* Ajustes para iPad mini (usualmente en modo retrato, alrededor de 768px de ancho) */
        @media only screen and (min-width: 415px) and (max-width: 768px) {
            body {
                background-size: cover; /* Puedes ajustar a 'contain' si prefieres ver la imagen completa */
                background-position: center center; /* Centra la imagen */
            }
        }        /* Botón estilizado */

        .modern-button {
            position: absolute; /* Para superponerlo sobre la imagen */
            top: 20px; /* Espaciado desde el borde superior */
            right: 20px; /* Espaciado desde el borde derecho */
            padding: 15px 30px; /* Tamaño del botón */
            font-size: 18px; /* Tamaño del texto */
            font-weight: bold; /* Negrita para el texto */
            color: white; /* Texto blanco */
            background: linear-gradient(135deg, #ff7eb3, #ff758c); /* Gradiente vibrante */
            border: none; /* Sin bordes */
            border-radius: 12px; /* Bordes redondeados */
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3), 0 4px 6px rgba(255, 118, 173, 0.4); /* Sombras */
            cursor: pointer; /* Cursor de mano al pasar */
            text-transform: uppercase; /* Texto en mayúsculas */
            letter-spacing: 1px; /* Espaciado entre letras */
            transition: all 0.4s ease; /* Animación suave */
        }

        /* Efecto hover */
        .modern-button:hover {
            transform: translateY(-5px); /* Elevación */
            background: linear-gradient(135deg, #ff758c, #ff7eb3); /* Gradiente inverso */
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.4), 0 6px 8px rgba(255, 118, 173, 0.5); /* Sombras más intensas */
        }

        /* Efecto activo (clic) */
        .modern-button:active {
            transform: translateY(2px); /* Botón baja ligeramente */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3), 0 3px 5px rgba(255, 118, 173, 0.3); /* Reduce sombras */
        }
    </style>
</head>
<body>
<!-- Botón Resaltado con Redirección -->
<button class="modern-button" onclick="window.location.href='{{ route('login') }}'">¡Ingresar al sistema!</button>
</body>
</html>
