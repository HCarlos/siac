<?php
/*
 * Copyright (c) 2024. Realizado por Carlos Hidalgo
 */

namespace App\Classes\Denuncia;

use App\Models\Denuncias\Denuncia;
use Elibyy\TCPDF\Facades\TCPDF;

class DenunciaAmbitoMapClass{

    public static function printDenunciaAmbitoMap(Denuncia $den, DenunciaArchivoTCPDF $pdf){

        // Imprime el Mapa de Google (inicio)

        $pdf->Init();
        $pdf->AddPage();

        $y = $pdf->GetY();
        $pdf->setY( $pdf->getY() + 20 );
        $y = $pdf->GetY();

        $pdf->setX(10);

        $pdf->SetTextColor(64,64,64);
        $pdf->SetFillColor(255,255,255);

        $pdf->SetFont(FONT_FREEMONO,'B',12);
        $pdf->Cell(195,$pdf->alto,"MAPA DE LOCALIZACIÓN DEL PROBLEMA","",1,"C");

        $y = $pdf->GetY();
        $pdf->setY( $pdf->getY() + 15 );
        $y = $pdf->GetY();
        $pdf->setY( $y  );

        // Coordenadas de ejemplo
        $latitude = $den->latitud; // Coordenada latitud
        $longitude =$den->longitud; // Coordenada longitud

        // Generar URL de Google Maps Static API
        $googleMapsApiKey = env('GOOGLE_MAPS_KEY'); // Sustituye por tu propia API Key
        $mapUrl = "https://maps.googleapis.com/maps/api/staticmap?center={$latitude},{$longitude}&zoom=17&size=2550x3300&markers=color:red|{$latitude},{$longitude}&key={$googleMapsApiKey}";

        // Descargar el mapa como imagen temporal
        $mapImage = public_path('storage/map_image.png'); // Guardamos temporalmente la imagen
        file_put_contents($mapImage, file_get_contents($mapUrl));

        // Agregar el mapa al PDF
        $pdf->Image($mapImage, 31.5, 40, 155, 130); // Ajusta la posición y tamaño según sea necesario

        // Eliminar la imagen temporal
        unlink($mapImage);

        // Imprime el Mapa de Google (fin)

        return $pdf;
    }

}
