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

class ReporteDiarioNov2Controller_old_1 extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

    public function reporteDiarioExcelNov2(Request $request){

        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

//        dd($start_date,$end_date);

        $file_external = "fmt_graficos_rangos_1.xlsx";
        $archivo = LoadTemplateExcel::getFileTemplate($file_external);
        $newFileName = storage_path('app/public/externo/fmt_graficos_rangos_' . Carbon::parse($start_date)->format('dmY') .'_'.Carbon::parse($end_date)->format('dmY'). '.xlsx');

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

        $DC = new ReporteDiarioNov2Class($start_date, $end_date);

        $Items = $DC->getRecibidas();
        $i = 4;
        foreach ($Items as $Item) {
            $setCell(
                $xp1,
                $dom1,
                'xl/worksheets/sheet1.xml',
                'B' . $i,
                $Item['TOTAL'] ?? ''
            );
            $i++;
        }

        $ItemsOrigenes = $DC->getOrigenes();
        $i = 14;
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



        $PendientesPromCiudadano = $DC->getPendientesPromCiudadano();
        $AtendidasPromCiudadanos = $DC->getAtendidasPromCiudadano();
        $i = 25;
        $letrasA = ['B','D','F','H','J','L'];
        $letrasP = ['C','E','G','I','K','M'];
        $ii = [0, 1, 2, 3, 4, 5];

        // Ciudadanos
        foreach ($ii as $key => $value) {
            $Item = $AtendidasPromCiudadanos[$value];
            $setCell($xp1, $dom1, 'xl/worksheets/sheet1.xml', $letrasA[$value] . $i, $Item['DIAS_ATE'] ?? '');
            $Item = $PendientesPromCiudadano[$value];
            $setCell($xp1, $dom1, 'xl/worksheets/sheet1.xml', $letrasP[$value] . $i, $Item['DIAS_PEN'] ?? '');
        }

        // Delegados
        $PendientesPromDelegados = $DC->getPendientesPromDelegados();
        $AtendidasPromDelegados = $DC->getAtendidasPromDelegados();
        $i = 26;
        foreach ($ii as $key => $value) {
            $Item = $AtendidasPromDelegados[$value];
            $setCell($xp1, $dom1, 'xl/worksheets/sheet1.xml', $letrasA[$value] . $i, $Item['DIAS_ATE_DEL'] ?? '');
            $Item = $PendientesPromDelegados[$value];
            $setCell($xp1, $dom1, 'xl/worksheets/sheet1.xml', $letrasP[$value] . $i, $Item['DIAS_PEN_DEL'] ?? '');
        }

        // Instituciones
        $PendientesPromInstitucion = $DC->getPendientesPromInstitucion();
        $AtendidasPromInstitucion = $DC->getAtendidasPromInstitucion();
        $i = 27;
        foreach ($ii as $key => $value) {
            $Item = $AtendidasPromInstitucion[$value];
            $setCell($xp1, $dom1, 'xl/worksheets/sheet1.xml', $letrasA[$value] . $i, $Item['DIAS_ATE_INS'] ?? '');
            $Item = $PendientesPromInstitucion[$value];
            $setCell($xp1, $dom1, 'xl/worksheets/sheet1.xml', $letrasP[$value] . $i, $Item['DIAS_PEN_INS'] ?? '');
        }



        $PendientesProm = $DC->getPendientesProm();
        $AtendidasProm = $DC->getAtendidasProm();

        $ii = [3, 1, 0, 5, 2, 4];
        $i = 31;
        foreach ($ii as $key => $value) {
            $Item = $PendientesProm[$value];
            $setCell($xp1, $dom1, 'xl/worksheets/sheet1.xml', 'B' . $i, $Item['PROM_PEN'] ?? '');
            $setCell($xp1, $dom1, 'xl/worksheets/sheet1.xml', 'C' . $i, $Item['DIAS_PEN'] ?? '');
            $i++;
        }

        $i = 41;
        foreach ($ii as $key => $value) {
            $Item = $AtendidasProm[$value];
            $setCell($xp1, $dom1, 'xl/worksheets/sheet1.xml', 'B' . $i, $Item['PROM_ATE'] ?? '');
            $setCell($xp1, $dom1, 'xl/worksheets/sheet1.xml', 'C' . $i, $Item['DIAS_ATE'] ?? '');
            $i++;
        }

        $Items = $DC->getLlamadas();

        $i = 50;
        foreach ($Items as $Item) {
            $setCell($xp1, $dom1, 'xl/worksheets/sheet1.xml', 'B' . $i, $Item['LLAMADAS'] ?? '');
            $i++;
        }

        // Finaliza procesamiento de datos


        $nodesF = $xp1->query("//d:c[@r='B10']/d:v | //d:c[@r='B20']/d:v | //d:c[@r='B56']/d:v | //d:c[@r='C4']/d:v | //d:c[@r='C7']/d:v | //d:c[@r='C9']/d:v | //d:c[@r='C56']/d:v");
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

        $setCell($xp2, $dom2, 'xl/worksheets/sheet2.xml', 'M3', $start_date);
        $setCell($xp2, $dom2, 'xl/worksheets/sheet2.xml', 'S3', $end_date);
        $setCell($xp2, $dom2, 'xl/worksheets/sheet2.xml', 'A39', $end_date);
//        $setCell($xp2, $dom2, 'xl/worksheets/sheet2.xml', 'C3', ucfirst($fechaFormateada));

        $nodesF = $xp2->query("//d:c[@r='L6']/d:v |
                                        //d:c[@r='E7']/d:v |
                                        //d:c[@r='M7']/d:v |
                                        //d:c[@r='U7']/d:v |
                                        //d:c[@r='C7']/d:v |
                                        //d:c[@r='K7']/d:v |
                                        //d:c[@r='S7']/d:v |
                                        //d:c[@r='L29']/d:v |
                                        //d:c[@r='AG7']/d:v |
                                        //d:c[@r='AG8']/d:v |
                                        //d:c[@r='AG9']/d:v |
                                        //d:c[@r='AG10']/d:v |
                                        //d:c[@r='AG11']/d:v |
                                        //d:c[@r='AG12']/d:v |
                                        //d:c[@r='AE17']/d:v |
                                        //d:c[@r='AG17']/d:v |
                                        //d:c[@r='AE18']/d:v |
                                        //d:c[@r='AG18']/d:v |
                                        //d:c[@r='AE19']/d:v |
                                        //d:c[@r='AG19']/d:v |
                                        //d:c[@r='AE20']/d:v |
                                        //d:c[@r='AG20']/d:v |
                                        //d:c[@r='AE21']/d:v |
                                        //d:c[@r='AG22']/d:v |
                                        //d:c[@r='AE27']/d:v |
                                        //d:c[@r='AG27']/d:v |
                                        //d:c[@r='AE28']/d:v |
                                        //d:c[@r='AG28']/d:v |
                                        //d:c[@r='AE29']/d:v |
                                        //d:c[@r='AG29']/d:v |
                                        //d:c[@r='AE30']/d:v |
                                        //d:c[@r='AG30']/d:v |
                                        //d:c[@r='AE31']/d:v |
                                        //d:c[@r='AG31']/d:v |
                                        //d:c[@r='AE32']/d:v |
                                        //d:c[@r='AG32']/d:v
                                        ");
        foreach ($nodesF as $v) {
            $v->parentNode->removeChild($v);
        }

        $zip->addFromString(
            'xl/worksheets/sheet2.xml',
            $dom2->saveXML()
        );


        $zip->close();

        return response()
            ->download($output, 'reporte_rango_'. Carbon::parse($start_date)->format('dmY') .'_'. Carbon::parse($end_date)->format('dmY') . '.xlsx')
            ->deleteFileAfterSend(true);

    }















}
