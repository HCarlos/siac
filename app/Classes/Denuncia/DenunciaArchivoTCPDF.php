<?php
/**
 * Copyright (c) 2019. Realizado por Carlos Hidalgo
 */

/**
 * Created by PhpStorm.
 * User: devch
 * Date: 20/03/19
 * Time: 11:29 AM
 */

namespace App\Classes\Denuncia;






use App\Traits\TCPDF\InitTrait;
use TCPDF;
use TCPDF_COLORS;
use TCPDF_STATIC;
use App\Classes\sector;

class DenunciaArchivoTCPDF extends TCPDF{

    use InitTrait;

    public $alto     = 6;
    public $timex    = "";
    protected $title = "";
    public $folio    = 0;
    protected $date  = null;
    public $FOLIO    = "";

    public function Header() {

        $style = array(
            'border'       => 0,
            'vpadding'     => 'auto',
            'hpadding'     => 'auto',
            'fgcolor'      => array(28,28,28),
            'bgcolor'      => false, //array(255,255,255)
            'module_width' => 1, // width of a single module in points
            'module_height' => 1 // height of a single module in points
        );

        $this->setY(7);
        $this->setX(5);
        $this->SetTextColor(64,64,64);
        $this->SetFillColor(212,212,212);

        $this->Image(ATEMUN['logo_reportes_encabezado'],10,7,50,14);
        $this->write2DBarcode(url()->full(), 'QRCODE,H', 187, 5, 32, 32, $style, '');

        $this->Cell(62,$this->alto,"","R",0,"L");
        $this->Cell(2,$this->alto,"","",0,"L");
        $this->SetFont(FONT_ARIALN,'',10);
        $this->Cell(120,$this->alto,env("NOMBRE_EMPRESA"),"",1,"L");

        $this->Cell(62,$this->alto,"","R",0,"L");
        $this->Cell(2,$this->alto,"","",0,"L");
        $this->SetFont(FONT_ARIALN,'',11);
        $this->Cell(120,$this->alto,env('INFO_TWO'),"",1,"L");

        $this->Cell(62,$this->alto,"","R",0,"L");
        $this->Cell(2,$this->alto,"","",0,"L");
        $this->SetFont(FONT_ARIALN,'B',12);
        $this->Cell(85,$this->alto,"EXPEDIENTE DE SOLICITUD DE SERVICIO","",1,"L");
        $this->SetFont(FONT_FREEMONO,'B',10);
        $this->line(10,$this->getY(),205,$this->getY());
    }

    function Footer(){

        $this->SetY(-7);
        //Arial italic 8
        $this->SetFont(FONT_DEJAVUSANSMONO,'',6);

//        Page number
//        $this->Cell(0,10,utf8_decode('PlatSource © '.date('Y'),0,0,'L');
        $this->Cell(0,10,'Página '.$this->PageNo().' de '.$this->getAliasNbPages(),0,0,'R');

    }


}
