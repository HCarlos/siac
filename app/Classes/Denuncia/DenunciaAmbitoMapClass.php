<?php
/*
 * Copyright (c) 2024. Realizado por Carlos Hidalgo
 */

namespace App\Classes\Denuncia;

use App\Models\Denuncias\Denuncia;
use App\Models\Denuncias\Imagene;
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
//        $googleMapsApiKey = 'AIzaSyBUl6Jk2_5yVYdnwidOuU9c8_ZBk7gGnfo'; //env('GOOGLE_MAPS_KEY'); // Sustituye por tu propia API Key
        $googleMapsApiKey = env('GOOGLE_MAPS_KEY'); // Sustituye por tu propia API Key

//        print $googleMapsApiKey;

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

    public static function importPDFFile(Imagene $img, DenunciaArchivoTCPDF $pdf, String $ext = "pdf"){

        $originalPdf = storage_path('app/public/denuncia/'.$img->image);
        try{

            $pageCount = $pdf->setSourceFile($originalPdf);

            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {

                $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
                if (is_callable(array($pdf, 'AliasNbPages'))) {
                    $pdf->AliasNbPages();
                }
                $pdf->Init();
                $pdf->AddPage();

                $y = $pdf->GetY();
                $pdf->setY( $pdf->getY() + 15 );
                $y = $pdf->GetY();
                $pdf->setY( $y  );


                $pdf->setCellPaddings(1, 1, 1, 1);

//                $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

                $templateId = $pdf->importPage($pageNo);
                $pdf->useTemplate($templateId);

                // Agregar encabezado a cada página
                $pdf->SetFont('helvetica', 'I', 8);
                $pdf->SetY(10);
                $pdf->Cell(0, 0, "Página $pageNo/$pageCount | " . date('d/m/Y'), 0, 0, 'C');

                // Agregar sello en páginas impares
                if ($pageNo % 2 == 1) {
    //                $pdf->Image(
    //                    public_path('images/sello_pequeno.png'),
    //                    180, 280, 15
    //                );
                }
            }


        }catch ( \Exception $e){
            logger()->error("PDF incompatible: " . $e->getMessage());
            $pdf->AddPage();
            $pdf->setY( 100  );
            $pdf->WriteHTMLCell(200,$pdf->alto,10,30,'Error al intentar agregare el pdf. No coincide la resolucióón.','0',1);
        }


    }

    public static function importImageFile(Imagene $img, DenunciaArchivoTCPDF $pdf, String $ext = "png"){

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        if (is_callable(array($pdf, 'AliasNbPages'))) {
            $pdf->AliasNbPages();
        }
        $pdf->Init();
        $pdf->AddPage();

        $y = $pdf->GetY();
        $pdf->setY( $pdf->getY() + 15 );
        $y = $pdf->GetY();
        $pdf->setY( $y  );

        $pdf->setCellPaddings(1, 1, 1, 1);

//        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


        $imagePath = storage_path('app/public/denuncia/'.$img->image);

        // 1. Obtener dimensiones de la imagen
        list($imgWidth, $imgHeight) = getimagesize($imagePath);

        // 2. Calcular dimensiones disponibles (área imprimible)
        $pageWidth = $pdf->getPageWidth() - $pdf->getMargins()['left'] - $pdf->getMargins()['right'];
        $pageHeight = $pdf->getPageHeight() - $pdf->getMargins()['top'] - $pdf->getMargins()['bottom'] - 10;

        // 3. Calcular relación de escalado
        $widthRatio = $pageWidth / $imgWidth;
        $heightRatio = $pageHeight / $imgHeight;
        $scale = min($widthRatio, $heightRatio);

        // 4. Calcular nuevas dimensiones
        $newWidth = $imgWidth * $scale;
        $newHeight = $imgHeight * $scale;

        // 5. Calcular posición centrada
        $x = ($pageWidth - $newWidth) / 2 + $pdf->getMargins()['left'];
        $y = ($pageHeight - $newHeight) / 2 + $pdf->getMargins()['top'] + 10;


        // 6. Insertar imagen ajustada
        $pdf->Image(
            $imagePath,
            $x,
            $y,
            $newWidth,
            $newHeight,
            '',  // Tipo (se detecta automáticamente)
            '',
            'T',
            true,
            300,
            '',
            false,
            false,
            0,
            false,
            false,
            true
        );


    }



}
