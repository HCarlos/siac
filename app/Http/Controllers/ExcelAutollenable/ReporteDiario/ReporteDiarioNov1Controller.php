<?php
/*
 * Copyright (c) 2025. Realizado por Carlos Hidalgo
 */

namespace App\Http\Controllers\ExcelAutollenable\ReporteDiario;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ExcelAutollenable\ReporteDiario;
use App\Http\Controllers\Funciones\LoadTemplateExcel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReporteDiarioNov1Controller extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

    public function reporteDiarioExcelNov1(Request $request){

        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

//        dd($start_date,$end_date);

        $file_external = "fmt_graficos_diarios_19nov25_1.xlsx";
        $archivo = LoadTemplateExcel::getFileTemplate($file_external);
        $newFileName = storage_path('app/public/externo/grafico_diario_19nov25_' . Carbon::parse($end_date)->format('dmY') . '.xlsx');

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

        $DC = new ReporteDiarioNov1Class();
        $Items = $DC->getRecibidas($start_date, $end_date) ?? [];
        $i = 4;
        foreach ($Items as $Item) {
            $setCell(
                $xp1,
                $dom1,
                'xl/worksheets/sheet1.xml',
                'B' . $i,
                $Item['R'] ?? ''
            );
            $i++;
        }

        $Items = $DC->getAtendidas($start_date, $end_date) ?? [];

        $i = 14;
        foreach ($Items as $Item) {
            $setCell(
                $xp1,
                $dom1,
                'xl/worksheets/sheet1.xml',
                'B' . $i,
                $Item['A'] ?? ''
            );
            $i++;
        }

        $ItemsOrigenes = $DC->getOrigenes($start_date, $end_date) ?? [];
        $i = 23;
        foreach ($ItemsOrigenes as $Item) {
            $setCell(
                $xp1,
                $dom1,
                'xl/worksheets/sheet1.xml',
                'B' . $i,
                $Item['T'] ?? ''
            );
            $i++;
        }

        $Items = $DC->getPendientesProm($start_date, $end_date) ?? [];


        $i = 33;
        foreach ($Items as $Item) {
            $setCell($xp1, $dom1, 'xl/worksheets/sheet1.xml', 'B' . $i, $Item['PROM_PEN'] ?? '');
            $setCell($xp1, $dom1, 'xl/worksheets/sheet1.xml', 'C' . $i, $Item['DIAS_PEN'] ?? '');
            $i++;
        }

        $Items = $DC->getAtendidasProm($start_date, $end_date) ?? [];

//        dd($Items);

        $i = 43;
        foreach ($Items as $Item) {
            $setCell($xp1, $dom1, 'xl/worksheets/sheet1.xml', 'B' . $i, $Item['PROM_ATE'] ?? '');
            $setCell($xp1, $dom1, 'xl/worksheets/sheet1.xml', 'C' . $i, $Item['DIAS_ATE'] ?? '');
            $i++;
        }

        $Items = $DC->getLlamadas($start_date, $end_date) ?? [];

        $i = 53;
        foreach ($Items as $Item) {
            $setCell($xp1, $dom1, 'xl/worksheets/sheet1.xml', 'B' . $i, $Item['LLAMADAS'] ?? '');
            $i++;
        }

        $i = 63;
        foreach ($Items as $Item) {
            $tr = $Item['TOTAL'];
            $setCell($xp1, $dom1, 'xl/worksheets/sheet1.xml', 'B' . $i, $tr ?? '');
            $setCell($xp1, $dom1, 'xl/worksheets/sheet1.xml', 'C' . $i, $Item['DIAS_ATE'] ?? '');
            $i++;
        }


        // Finaliza procesamiento de datos


        $nodesF = $xp1->query("//d:c[@r='B10']/d:v | //d:c[@r='B20']/d:v | //d:c[@r='B29']/d:v | //d:c[@r='B59']/d:v | //d:c[@r='B69']/d:v | //d:c[@r='C69']/d:v");
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

        $fechaCarbon = Carbon::now(); // Obtiene la fecha y hora actual
        $fechaFormateada = $fechaCarbon->locale('es_MX')->isoFormat('dddd DD [de] MMMM [de] YYYY [corte a las] HH:mm[hrs.]');

        $setCell($xp2, $dom2, 'xl/worksheets/sheet2.xml', 'A6', $end_date);
        $setCell($xp2, $dom2, 'xl/worksheets/sheet2.xml', 'F6', $end_date);
        $setCell($xp2, $dom2, 'xl/worksheets/sheet2.xml', 'A39', $end_date);
        $setCell($xp2, $dom2, 'xl/worksheets/sheet2.xml', 'A55', $end_date);
        $setCell($xp2, $dom2, 'xl/worksheets/sheet2.xml', 'C3', ucfirst($fechaFormateada));
        $setCell($xp2, $dom2, 'xl/worksheets/sheet2.xml', 'C51', ucfirst($fechaFormateada));

        $setCell($xp2, $dom2, 'xl/worksheets/sheet2.xml', 'C22', $ItemsOrigenes[0]['T'] ?? '');
        $setCell($xp2, $dom2, 'xl/worksheets/sheet2.xml', 'C23', $ItemsOrigenes[1]['T'] ?? '');
        $setCell($xp2, $dom2, 'xl/worksheets/sheet2.xml', 'C24', $ItemsOrigenes[2]['T'] ?? '');
        $setCell($xp2, $dom2, 'xl/worksheets/sheet2.xml', 'C25', $ItemsOrigenes[3]['T'] ?? '');
        $setCell($xp2, $dom2, 'xl/worksheets/sheet2.xml', 'C26', $ItemsOrigenes[4]['T'] ?? '');
        $setCell($xp2, $dom2, 'xl/worksheets/sheet2.xml', 'H22', $ItemsOrigenes[5]['T'] ?? '');

        $i = 31;
        foreach ($Items as $Item) {
            $setCell($xp2, $dom2, 'xl/worksheets/sheet2.xml', 'C' . $i, $Item['PROM_PEN'] ?? '');
            $setCell($xp2, $dom2, 'xl/worksheets/sheet2.xml', 'D' . $i, $Item['DIAS_PEN'] ?? '');
            $i++;
        }

        $i = 31;
        foreach ($Items as $Item) {
            $setCell($xp2, $dom2, 'xl/worksheets/sheet2.xml', 'H' . $i, $Item['PROM_ATE'] ?? '');
            $setCell($xp2, $dom2, 'xl/worksheets/sheet2.xml', 'I' . $i, $Item['DIAS_ATE'] ?? '');
            $i++;
        }

        $i = 58;
        foreach ($Items as $Item) {
//            $tr = $Item['DIAS_PEN'] + $Item['DIAS_ATE'];
            $tr = $Item['TOTAL'];

            $setCell($xp2, $dom2, 'xl/worksheets/sheet2.xml', 'E' . $i, $tr ?? '');
            $setCell($xp2, $dom2, 'xl/worksheets/sheet2.xml', 'G' . $i, $Item['DIAS_ATE'] ?? '');
            $i++;
        }


        $nodesF = $xp2->query("//d:c[@r='B7']/d:v | //d:c[@r='G7']/d:v | //d:c[@r='B40']/d:v | //d:c[@r='E64']/d:v | //d:c[@r='G64']/d:v");
        foreach ($nodesF as $v) {
            $v->parentNode->removeChild($v);
        }

        $zip->addFromString(
            'xl/worksheets/sheet2.xml',
            $dom2->saveXML()
        );


        $zip->close();

        return response()
            ->download($output, 'reporte_diario_'. Carbon::parse($end_date)->format('dmY') .'_'. date('dmY_His') . '.xlsx')
            ->deleteFileAfterSend(true);


    }















}
