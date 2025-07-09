<?php
/*
 * Copyright (c) 2025. Realizado por Carlos Hidalgo
 */

namespace App\Http\Controllers\External\Denuncia;

use App\Classes\Dashboard\DashboardClass;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones\LoadTemplateExcel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportesExcelAutollenablesController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

    public function reporteDiarioExcel(Request $request){

        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        $file_external = "fmt_graficos_diarios.xlsx";
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

            // --- DETECCIÓN MEJORADA DE FECHAS ---
            // Intenta convertir a Carbon para un parseo más robusto, luego a Excel serial.
            // Si $value es un string, intenta parsearlo como fecha.
            try {
                if (is_string($value) && !empty($value)) {
                    // Intenta parsear con Carbon (más robusto para varios formatos)
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
                // Si Carbon no puede parsear, no es una fecha válida para nosotros.
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

        $DC = new DashboardClass();
        $Items = $DC->getRecibidasAtendidas($start_date, $end_date);

//        dd($Items);


        $bloques = [
            ['cols'=>['B','C','D'], 'keys'=>['CR','DR','IR'], 'startRow'=>4],
            ['cols'=>['B','C','D'], 'keys'=>['CA','DA','IA'], 'startRow'=>14],
        ];
        foreach ($bloques as $bl) {
            foreach ($bl['keys'] as $i => $key) {
                for ($j = 0; $j < 6; $j++) {
                    $col = $bl['cols'][$i];
                    $row = $bl['startRow'] + $j;
                    $ref = "{$col}{$row}";
                    $val = $Items[$j][$key] ?? '';
                    $setCell($xp1, $dom1, 'xl/worksheets/sheet1.xml', $ref, $val);
                }
            }
        }



        $dias_inicio = [24,34,44,54,64,74];

        for ($i=0;  $i<6; $i++) {
            $servicio = $DC->vectorServicios[$i]["DIAS_ATRAS"];
            $di = (int)$dias_inicio[$i];
            for ($j=0; $j<6; $j++) {
                $setCell($xp1, $dom1, 'xl/worksheets/sheet1.xml', "A".$di, date($servicio[$j]["fecha"]));
                $setCell($xp1, $dom1, 'xl/worksheets/sheet1.xml', "B".$di, $servicio[$j]["atendidas"]);
                $setCell($xp1, $dom1, 'xl/worksheets/sheet1.xml', "C".$di, $servicio[$j]["rechazadas"]);
                $setCell($xp1, $dom1, 'xl/worksheets/sheet1.xml', "D".$di, $servicio[$j]["pendientes"]);
                $di++;

            }
        }

        // Finaliza procesamiento de datos


//        $nodesF = $xp1->query("//d:c[@r='C2']/d:v | //d:c[@r='E4']/d:v | //d:c[@r='E14']/d:v");
        $query = "//d:c[starts-with(@r, 'E') and number(substring(@r, 2)) >= 4 and number(substring(@r, 2)) <= 79 and (number(substring(@r, 2)) - 4) mod 10 < 6]/d:v";
        $nodesF = $xp1->query($query);

        foreach ($nodesF as $v) {
            $v->parentNode->removeChild($v);
        }

        $zip->addFromString(
            'xl/worksheets/sheet1.xml',
            $dom1->saveXML()
        );

        $xml2 = $zip->getFromName('xl/worksheets/sheet2.xml');
        $dom2 = new \DOMDocument();
        $dom2->loadXML($xml2);
        $xp2  = new \DOMXPath($dom2);
        $xp2->registerNamespace('d','http://schemas.openxmlformats.org/spreadsheetml/2006/main');

        $tr = $Items[0]["TR"] + $Items[1]["TR"] + $Items[2]["TR"] + $Items[3]["TR"] + $Items[4]["TR"] + $Items[5]["TR"];
        $ta = $Items[0]["TA"] + $Items[1]["TA"] + $Items[2]["TA"] + $Items[3]["TA"] + $Items[4]["TA"] + $Items[5]["TA"];
        $fechaCarbon = Carbon::now(); // Obtiene la fecha y hora actual
        $fechaFormateada = $fechaCarbon->locale('es_MX')->isoFormat('dddd DD [de] MMMM [de] YYYY [corte a las] HH:mm[hrs.]');

        $setCell($xp2, $dom2, 'xl/worksheets/sheet2.xml', 'C5', $tr);
        $setCell($xp2, $dom2, 'xl/worksheets/sheet2.xml', 'G5', $ta);
        $setCell($xp2, $dom2, 'xl/worksheets/sheet2.xml', 'C2', ucfirst($fechaFormateada));


        $zip->close();

        return response()
            ->download($output, 'reporte_diario_'. Carbon::parse($end_date)->format('dmY') .'_'. date('dmY_His') . '.xlsx')
            ->deleteFileAfterSend(true);


    }















}
