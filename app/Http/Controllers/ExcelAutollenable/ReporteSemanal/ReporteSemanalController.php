<?php
/*
 * Copyright (c) 2025. Realizado por Carlos Hidalgo
 */

namespace App\Http\Controllers\ExcelAutollenable\ReporteSemanal;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ExcelAutollenable\ReporteDiario\ReporteDiarioClass;
use App\Http\Controllers\Funciones\LoadTemplateExcel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReporteSemanalController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

    public function reporteSemanalExcel(Request $request){

        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        $file_external = "fmt_graficos_semanal_sm.xlsx";
        $archivo = LoadTemplateExcel::getFileTemplate($file_external);
        $newFileName = storage_path('app/public/externo/grafico_diario_' . Carbon::parse($end_date)->format('dmY') . '.xlsx');

        $template = $archivo;
        $output   = $newFileName;

        copy($template, $output);

        $zip = new \ZipArchive;
        if ($zip->open($output) !== true) {
            abort(500, "No se pudo abrir el archivo Excel como ZIP");
        }

        $xml1 = $zip->getFromName('xl/worksheets/sheet1.xml');
        $dom1 = new \DOMDocument();
        $dom1->loadXML($xml1);
        $xp1  = new \DOMXPath($dom1);
        $xp1->registerNamespace('d','http://schemas.openxmlformats.org/spreadsheetml/2006/main');

        $convertPhpDateToExcelSerial = function($date) {
            if ($date instanceof \Carbon\Carbon || $date instanceof \DateTime) {
                $timestamp = $date->getTimestamp();
            } elseif (is_string($date)) {
                $timestamp = strtotime($date);
            } else {
                return null; // No es un formato de fecha reconocido
            }

            if ($timestamp === false) {
                return null; // Fallback si strtotime falla
            }
            return ($timestamp / (24 * 60 * 60)) + 25569;
        };

        $setCell = function(\DOMXPath $xp, \DOMDocument $dom, string $sheetXmlPath, string $cellRef, $value, ?int $styleId = null) use ($zip, $convertPhpDateToExcelSerial) {
            $query = "//d:c[@r='$cellRef']";
            $nodes = $xp->query($query);
            $c = null;

            if ($nodes->length) {
                $c = $nodes->item(0);
                foreach ($xp->query('d:v', $c) as $v) {
                    $c->removeChild($v);
                }
            } else {
                $rowNum = preg_replace('/\D/', '', $cellRef);
                $rowNodes = $xp->query("//d:row[@r='$rowNum']");
                if (! $rowNodes->length) {
                    return;
                }
                $row = $rowNodes->item(0);
                $c   = $dom->createElementNS('http://schemas.openxmlformats.org/spreadsheetml/2006/main','c');
                $c->setAttribute('r',$cellRef);
                $row->appendChild($c);
            }

            $isDate = false;
            $excelValue = $value;

            try {
                if (is_string($value) && !empty($value)) {
                    $carbonDate = \Carbon\Carbon::parse($value);
                    $excelValue = $convertPhpDateToExcelSerial($carbonDate);
                    if ($excelValue !== null) {
                        $isDate = true;
                    }
                } elseif ($value instanceof \Carbon\Carbon || $value instanceof \DateTime) {
                    $excelValue = $convertPhpDateToExcelSerial($value);
                    if ($excelValue !== null) {
                        $isDate = true;
                    }
                }
            } catch (\Exception $e) {
                $isDate = false;
            }


            if ($isDate) {
                $c->setAttribute('t', 'n'); // Tipo numérico para fechas
                if ($styleId !== null) {
                    $c->setAttribute('s', $styleId); // Aplica el estilo de fecha
                }
            } elseif (is_numeric($value)) {
                $c->setAttribute('t','n'); // Tipo numérico para números
                // Puedes añadir un estilo si es un número simple y lo necesitas
                // if ($styleId !== null) $c->setAttribute('s', $styleId);
            } else {
                // Si no es fecha ni número, es texto
                $c->setAttribute('t','inlineStr');
            }

            // Añadir el nodo <v> (valor) o <is> (cadena en línea)
            if ($isDate || is_numeric($value)) {
                $v = $dom->createElementNS('http://schemas.openxmlformats.org/spreadsheetml/2006/main','v',$excelValue);
                $c->appendChild($v);
            } else {
                $is = $dom->createElementNS('http://schemas.openxmlformats.org/spreadsheetml/2006/main','is');
                $t  = $dom->createElementNS('http://schemas.openxmlformats.org/spreadsheetml/2006/main','t',$value);
                $is->appendChild($t);
                $c->appendChild($is);
            }

            // Guardar el XML de la hoja en el archivo ZIP
            $newXml = $dom->saveXML();

            // Actualizar el archivo en el ZIP (borrar y agregar de nuevo)
            $zip->deleteName($sheetXmlPath);
            $zip->addFromString($sheetXmlPath, $newXml);


            // Debug: Guarda el XML a un archivo para inspeccionar
            file_put_contents('/tmp/sheet2_modificado.xml', $newXml);
        };


        // Inicia procesamiento de datos

        $DC = new ReporteSemanalClass();

        // Procesamiento de datos para el Grfico 1

        $Items = $DC->getVectorServicios($start_date, $end_date);

        $nodesF = $xp1->query("//d:c[@r='B3']/d:v | //d:c[@r='B4']/d:v | //d:c[@r='B5']/d:v | //d:c[@r='B6']/d:v | //d:c[@r='B7']/d:v | //d:c[@r='B8']/d:v");
        foreach ($nodesF as $v) {
            $v->parentNode->removeChild($v);
        }

        $di = 3;
        for ($j=0; $j<6; $j++) {
            $tr = $Items[$j]["TR"];
            $setCell($xp1, $dom1, 'xl/worksheets/sheet1.xml', "B".$di, ($tr));
            $di++;
        }

        $nodesF = $xp1->query("//d:c[@r='B9']/d:v | //d:c[@r='B10']/d:v | //d:c[@r='B11']/d:v | //d:c[@r='B12']/d:v");
        foreach ($nodesF as $v) {
            $v->parentNode->removeChild($v);
        }

        $zip->addFromString(
            'xl/worksheets/sheet1.xml',
            $dom1->saveXML()
        );

        // Procesamiento de datos para el Grfico 2

        $itemFte = $DC->getVectorFuentes($start_date, $end_date);
        $di = 15;
        for ($j=0; $j<6; $j++) {
            $total = $itemFte[$j]["Total"];
            $origen = $itemFte[$j]["Origen"];
            $setCell($xp1, $dom1, 'xl/worksheets/sheet1.xml', "A".$di, ($origen));
            $setCell($xp1, $dom1, 'xl/worksheets/sheet1.xml', "B".$di, ($total));
            $di++;
        }

        $zip->addFromString(
            'xl/worksheets/sheet1.xml',
            $dom1->saveXML()
        );

        // Procesamiento de datos para el Grfico 3

        $DC->getDiasAtrasPorServicio($start_date, $end_date);

        $di = 25;
        for ($i=0;  $i<6; $i++) {
            $servicio = $DC->vectorServicios[$i]["DIAS_ATRAS"];
            $setCell($xp1, $dom1, 'xl/worksheets/sheet1.xml', "B".$di, $servicio[0]["atendidas"]);
            $setCell($xp1, $dom1, 'xl/worksheets/sheet1.xml', "C".$di, $servicio[0]["rechazadas"]);
            $setCell($xp1, $dom1, 'xl/worksheets/sheet1.xml', "D".$di, $servicio[0]["pendientes"]);
            $setCell($xp1, $dom1, 'xl/worksheets/sheet1.xml', "E".$di, $servicio[0]["observadas"]);
            $di++;
        }

        $zip->addFromString(
            'xl/worksheets/sheet1.xml',
            $dom1->saveXML()
        );

        // Procesamiento de datos para el Grfico 4

        $meses = $DC->getTotalServiciosPorMes($start_date, $end_date);

        $di = 34;
        $letras =["B","C","D","E","F","G"];
        foreach ($meses as $mes) {
            $servicio = $mes["totales"];
            $i = 0;
            foreach ($servicio as $key => $value) {
                $setCell($xp1, $dom1, 'xl/worksheets/sheet1.xml', $letras[$i].$di, $value);
                $i++;
            }
            $di++;
        }

        $zip->addFromString(
            'xl/worksheets/sheet1.xml',
            $dom1->saveXML()
        );


        /* *************** */
        /*        HOJA 2   */
        /* *************** */

        $xml2 = $zip->getFromName('xl/worksheets/sheet2.xml');
        $dom2 = new \DOMDocument();
        $dom2->loadXML($xml2);
        $xp2  = new \DOMXPath($dom2);
        $xp2->registerNamespace('d','http://schemas.openxmlformats.org/spreadsheetml/2006/main');

        $nodesF = $xp2->query("//d:c[@r='C4']/d:v | //d:c[@r='C5']/d:v | //d:c[@r='F5']/d:v | //d:c[@r='I5']/d:v");
        foreach ($nodesF as $v) {
            $v->parentNode->removeChild($v);
        }

        $zip->addFromString(
            'xl/worksheets/sheet2.xml',
            $dom2->saveXML()
        );

        $fechaCarbon = Carbon::now(); // Obtiene la fecha y hora actual
        $fechaFormateada = $fechaCarbon->locale('es_MX')->isoFormat('dddd DD [de] MMMM [de] YYYY [corte a las] HH:mm[hrs.]');
        $setCell($xp2, $dom2, 'xl/worksheets/sheet2.xml', 'D2', ucfirst($fechaFormateada));

        $zip->close();

        return response()
            ->download($output, 'reporte_semanal_'. Carbon::parse($end_date)->format('dmY') .'_'. date('dmY_His') . '.xlsx')
            ->deleteFileAfterSend(true);


    }















}
