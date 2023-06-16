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

class DenunciaTCPDF extends TCPDF{

    use InitTrait;

    protected $alto        = 6;
    public $timex          = "";
    protected $title       = "";
    public $folio          = 0;
    protected $date        = null;
    public $FOLIO          = "";

    public function Header() {

        $style = array(
            'border' => 0,
            'vpadding' => 'auto',
            'hpadding' => 'auto',
            'fgcolor' => array(28,28,28),
            'bgcolor' => false, //array(255,255,255)
            'module_width' => 1, // width of a single module in points
            'module_height' => 1 // height of a single module in points
        );

        $this->setY(7);
        $this->setX(5);
        $this->SetTextColor(64,64,64);
        $this->SetFillColor(212,212,212);

        $this->Image(ATEMUN['logo_reportes_encabezado'],5,7,60,19);
        $this->write2DBarcode(url()->full(), 'QRCODE,H', 180, 5, 50, 50, $style, '');

        $this->Cell(62,$this->alto,"","R",0,"L");
        $this->Cell(2,$this->alto,"","",0,"L");
        $this->SetFont(FONT_ARIALN,'',10);
        $this->Cell(120,$this->alto,env("NOMBRE_EMPRESA"),"",1,"L");

        $this->Cell(62,$this->alto,"","R",0,"L");
        $this->Cell(2,$this->alto,"","",0,"L");
        $this->SetFont(FONT_FREEMONO,'B',11);
        $this->Cell(120,$this->alto,env('INFO_TWO'),"",1,"L");

        $this->Cell(62,$this->alto,"","R",0,"L");
        $this->Cell(2,$this->alto,"","",0,"L");
        $this->SetFont(FONT_ARIALN,'',9);
        $this->Cell(85,$this->alto,"REPORTE CIUDADANO","",1,"L");
        $this->SetFont(FONT_FREEMONO,'B',10);
        $this->ln(10);
        $this->Cell(149,$this->alto,"","",0,"L");
        $this->Cell(22,$this->alto,"FOLIO: ","",0,"L");
        $this->SetFont(FONT_DEJAVUSANSMONO,'B',8);
        $this->SetTextColor(255,64,64);
        $this->Cell(25,$this->alto,$this->FOLIO,"",1,"R");
        $this->SetTextColor(64,64,64);
        $this->SetFont(FONT_FREEMONO,'B',10);
        $this->Cell(149,$this->alto,"","",0,"L");
        $this->Cell(22,$this->alto,"FECHA: ","",0,"L");
        $this->SetFont(FONT_ARIALN,'',10);
        $this->Cell(25,$this->alto,$this->timex,"",1,"R");

        $this->alto  = 6;
        $this->setX(10);
    }



}
