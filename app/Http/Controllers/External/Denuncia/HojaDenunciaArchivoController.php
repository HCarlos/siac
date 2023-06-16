<?php

namespace App\Http\Controllers\External\Denuncia;

use App\Classes\Denuncia\DenunciaArchivoTCPDF;
use App\Http\Controllers\Controller;
use App\Models\Denuncias\Denuncia;
use App\Models\Denuncias\Denuncia_Dependencia_Servicio;
use App\Classes\sector;

define('NOMBRE_EMPRESA',config('atemun.nombre_empresa',''));

class HojaDenunciaArchivoController extends Controller{



    public function imprimirDenuncia($UUID=""){
        ini_set('max_execution_time', 72000);

        $den = Denuncia::all()->where('uuid',$UUID)->first();

        $Sector = new sector();


        $pdf = new DenunciaArchivoTCPDF('','mm',array(215.9, 280.0), true, 'UTF-8', false);
        $pdf->FOLIO = $den->folio_dac;
        $pdf->folio = $den->id;
        $pdf->timex = $den->fecha_ingreso_solicitud;
        $pdf->alto   = 6;

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        if (is_callable(array($pdf, 'AliasNbPages'))) {
            $pdf->AliasNbPages();
        }
        $pdf->Init();
        $pdf->AddPage();

        $pdf->setCellPaddings(1, 1, 1, 1);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $roles = $den->ciudadano->RoleNameStrArray;
        $username = $den->ciudadano->username;

        $pdf->alto  = 6;
        $pdf->setY( $pdf->getY() + 20 );
        $pdf->setX(10);

        $y = $pdf->GetY();
        $pdf->SetFillColor(192);
        $pdf->RoundedRect(5,$y,205,6.5,2,'1111','');

        // Folio
        $pdf->SetFont(FONT_ARIALN,'B',10);
        $pdf->Cell(15,$pdf->alto,"FOLIO : ","",0,"R");
        $pdf->SetFont(FONT_FREEMONO,'B',10);
        $pdf->Cell(40,$pdf->alto,$den->folio_dac,"",0,"L");

        // fecha
        $pdf->SetFont(FONT_ARIALN,'B',10);
        $pdf->Cell(16,$pdf->alto,"FECHA : ","L",0,"R");
        $pdf->SetFont(FONT_FREEMONO,'B',10);
        $pdf->Cell(50,$pdf->alto,$den->fecha_ingreso_solicitud,"",0,"L");

        // Estatus
        $pdf->SetFont(FONT_ARIALN,'B',10);
        $pdf->Cell(20,$pdf->alto,"ESTATUS : ","L",0,"R");
        $pdf->SetFont(FONT_FREEMONO,'B',10);
        $pdf->Cell(160,$pdf->alto,$den->denuncia_estatus->first()->estatus,"",1,"L");

        $y = $pdf->GetY();
        $pdf->setY( $pdf->getY() + 0 );
        $y = $pdf->GetY();
        $pdf->SetFillColor(192);
        $pdf->RoundedRect(5,$y,205,6.5,2,'1111','');

        // USUARIO
        $pdf->SetFont(FONT_ARIALN,'B',10);
        $pdf->Cell(20,$pdf->alto,"USUARIO : ","",0,"R");
        $pdf->SetFont(FONT_FREEMONO,'B',10);
        $pdf->Cell(80,$pdf->alto,$den->ciudadano->full_name,"",0,"L");

        // USUARIO-CURO
        $pdf->SetFont(FONT_ARIALN,'B',10);
        $pdf->Cell(13,$pdf->alto,"CURP : ","L",0,"R");
        $pdf->SetFont(FONT_FREEMONO,'B',10);
        $pdf->Cell(60,$pdf->alto,$den->ciudadano->curp,"",0,"L");

        // USUARIO-ID
        $pdf->SetFont(FONT_ARIALN,'B',10);
        $pdf->Cell(8,$pdf->alto,"ID : ","L",0,"R");
        $pdf->SetFont(FONT_FREEMONO,'B',10);
        $pdf->Cell(20,$pdf->alto,$den->ciudadano->id,"",1,"L");

        $y = $pdf->GetY();
        $pdf->setY( $pdf->getY() + 0 );
        $y = $pdf->GetY();
        $pdf->SetFillColor(192);
        $pdf->RoundedRect(5,$y,205,6.5,2,'1111','');

        // CAPTURÓ
        $pdf->SetFont(FONT_ARIALN,'B',10);
        $pdf->Cell(20,$pdf->alto,"CAPTURÓ : ","",0,"R");
        $pdf->SetFont(FONT_FREEMONO,'B',10);
        $pdf->Cell(80,$pdf->alto,$den->creadopor->full_name,"",0,"L");

        // CAPTURÓ-CURO
        $pdf->SetFont(FONT_ARIALN,'B',10);
        $pdf->Cell(13,$pdf->alto,"CURP : ","L",0,"R");
        $pdf->SetFont(FONT_FREEMONO,'B',10);
        $pdf->Cell(60,$pdf->alto,$den->creadopor->curp,"",0,"L");

        // CAPTURÓ-ID
        $pdf->SetFont(FONT_ARIALN,'B',10);
        $pdf->Cell(8,$pdf->alto,"ID : ","L",0,"R");
        $pdf->SetFont(FONT_FREEMONO,'B',10);
        $pdf->Cell(20,$pdf->alto,$den->creadopor->id,"",1,"L");
        //        $pdf->RoundedRect(5, $y, 287, 4, 2, '12', 'FD');

        $y = $pdf->GetY();
        $pdf->setY( $pdf->getY() + 5 );
        $y = $pdf->GetY();
        $pdf->SetFillColor(192);
        $pdf->RoundedRect(5,$y,205,6.5,2,'1111','');

        // C   DEPENDENCIA
        $pdf->SetFont(FONT_ARIALN,'B',10);
        $pdf->Cell(42,$pdf->alto,"UNIDAD ADMINISTRATIVA : ","",0,"R");
        $pdf->SetFont(FONT_FREEMONO,'B',8);
        $pdf->Cell(160,$pdf->alto,$den->dependencia->dependencia.' ('.$den->dependencia->abreviatura.')',"L",1,"L");

        $y = $pdf->GetY();
        $pdf->setY( $pdf->getY() + 2 );
        $y = $pdf->GetY();
        $pdf->SetFillColor(192);
        $pdf->RoundedRect(5,$y,205,6.5,2,'1111','');

        // C   SERVICIO
        $pdf->SetFont(FONT_ARIALN,'B',10);
        $pdf->Cell(20,$pdf->alto,"SERVICIO : ","",0,"R");
        $pdf->SetFont(FONT_FREEMONO,'B',8);
        $pdf->Cell(185,$pdf->alto,$den->servicio->servicio,"L",1,"L");

        // DENUNCIA
        $y = $pdf->GetY();
        $pdf->setY( $pdf->getY() + 5 );
        $y = $pdf->GetY();
        $pdf->SetFillColor(192);
        $pdf->RoundedRect(5,$y,205,26,2,'1111','');

        $pdf->SetFont(FONT_ARIALN,'B',10);
        $pdf->Cell(205,$pdf->alto,"  DESCRIPCIÓN DE LA SOLICITUD : ","B",1,"L");
        $pdf->SetFont(FONT_FREEMONO,'B',8);
//        $pdf->WriteHTMLCell(160,$pdf->alto,$den->descripcion.' '.$den->referencia,"L",1,"L");
        $pdf->WriteHTMLCell(200,$pdf->alto,8,$pdf->getY(),$den->descripcion.' '.$den->referencia,0,1);

        $dds = Denuncia_Dependencia_Servicio::query()->where('denuncia_id',$den->id)->orderBy('id')->get();

        $y = $pdf->GetY()+15;

        foreach ($dds as $res){

            $pdf->setY( $y  );
            $y = $pdf->GetY();

            $pdf->SetFillColor(192);
            $pdf->RoundedRect(5,$y,205,26,2,'1111','');

            $pdf->SetFont(FONT_ARIALN,'B',10);
            $pdf->Cell(35,$pdf->alto,"  R  E  S  P  U  E  S  T  A: ","B",0,"L");
            $pdf->SetFont(FONT_FREEMONO,'B',10);
            $pdf->Cell(65,$pdf->alto, $res->dependencia->abreviatura,"B",0,"L");
            $pdf->SetFont(FONT_ARIALN,'B',10);
            $pdf->Cell(50,$pdf->alto,"FECHA: ".date('d-m-Y H:i:s', strtotime($res->fecha_movimiento)),"B",0,"L");
//            $pdf->Cell(50,$pdf->alto,"FECHA: ".$res->dependencia_id,"B",0,"L");
            $pdf->Cell(55,$pdf->alto,"ESTATUS: ".$res->estatu->estatus,"B",1,"L");
            $pdf->SetFont(FONT_FREEMONO,'B',8);

            $obs = trim($res->observaciones);
            $pdf->WriteHTMLCell(200,$pdf->alto,8,$y+7,$obs==""?'NO HUBO RESPUESTA':$obs,'0',1);

            $y = $y + 30;

        }





//        $html = ATEMUN['style']['denuncia'];
//        $html .= "<p>Estimado <bAzul>C. {$den->ciudadano->FullName}</bAzul> (<bChocolate>{$den->ciudadano->id}</bChocolate>, <bOrange>$username</bOrange>), su petición ha sido recibida y se iniciará el trámite pertinente. <br><br>";
//        $html .= "El <b>". NOMBRE_EMPRESA . "</b> agradece su colaboración y le garantiza confidencialidad y una pronta respuesta.  <br><br>";
//        $html .= "Fue atendido por <bVerde>C. {$den->creadopor->FullName}</bVerde>. <br>";
//        $html .= "</p>";
//        $html .= "<span></span>";
//        $html .= "<pCentrado>";
//        $html .= env('INFO_TWO'). "<br>";
//        $html .= "<span></span>";
//        $html .= "<a href='".env('INFO_FOUR')."'>".env('INFO_FOUR'). "</a>";
//        $html .= "</pCentrado>";

//        $pdf->WriteHTMLCell(195,$alto,10,$pdf->getY(),$html,0,0);

        $pdf->Init();
        $pdf->AddPage();

        $y = $pdf->GetY();
        $pdf->setY( $pdf->getY() + 15 );
        $y = $pdf->GetY();

        $pdf->SetTextColor(64,64,64);
        $pdf->SetFillColor(255,255,255);

        $firma = $den->firmas->last();

        if ($firma){

            $pdf->SetFont(FONT_DEJAVUSANSMONO,'B',7);
            $pdf->WriteHTMLCell(200,$pdf->alto,5,37, "<p><bSelloBold>CADENA ORIGINAL:</bSelloBold></p>",0,0);
            $pdf->SetFont(FONT_AEALARABIYA,'',6);
            $pdf->WriteHTMLCell(200,$pdf->alto,5,40, $firma->cadena_original,0,0);

            $pdf->SetFont(FONT_DEJAVUSANSMONO,'B',7);
            $pdf->WriteHTMLCell(200,$pdf->alto,5,47, "<bSelloBold>HASH:</bSelloBold>",0,0);
            $pdf->SetFont(FONT_AEALARABIYA,'',6);
            $pdf->WriteHTMLCell(200,$pdf->alto,5,50, $firma->hash,0,0);

            $pdf->SetFont(FONT_DEJAVUSANSMONO,'B',7);
            $pdf->WriteHTMLCell(200,$pdf->alto,5,57, "<bSelloBold>SELLO DIGITAL:</bSelloBold>",0,0);
            $pdf->SetFont(FONT_AEALARABIYA,'',6);
            $pdf->WriteHTMLCell(200,$pdf->alto,5,60, $firma->sello,0,0);

        } else {

            $pdf->SetFont(FONT_DEJAVUSANSMONO,'B',7);
            $pdf->WriteHTMLCell(200,$pdf->alto,5,37, "",0,0);
            $pdf->SetFont(FONT_AEALARABIYA,'',6);
            $pdf->WriteHTMLCell(200,$pdf->alto,5,40, "* Escanee la imagen QR para ver el avance en la gestión de su solicitud.",0,0);

        }
// set auto page breaks

        $pdf->Output($pdf->FOLIO . '.pdf');

    }




}
