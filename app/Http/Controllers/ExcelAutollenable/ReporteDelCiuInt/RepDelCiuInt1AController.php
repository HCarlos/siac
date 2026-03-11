<?php
/*
 * Copyright (c) 2025. Realizado por Carlos Hidalgo
 */

namespace App\Http\Controllers\ExcelAutollenable\ReporteDelCiuInt;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ExcelAutollenable\ReporteDiario;
use App\Http\Controllers\Funciones\LoadTemplateExcel;
use App\Models\Catalogos\Servicio;
use App\Models\Denuncias\Denuncia_Dependencia_Servicio;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RepDelCiuInt1AController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

    public function repDelCiuInt1A(Request $request){
        ini_set('max_execution_time', 90000);

        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

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

        $xml1 = $zip->getFromName('xl/worksheets/sheet2.xml');
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
                    // La fila no existe en el template (ej. sheet1 vacío): crearla en sheetData
                    $sheetDataNodes = $xp->query("//d:sheetData");
                    if (! $sheetDataNodes->length) {
                        return; // No hay sheetData en absoluto → no se puede escribir
                    }
                    $sheetData = $sheetDataNodes->item(0);
                    $row = $dom->createElementNS('http://schemas.openxmlformats.org/spreadsheetml/2006/main', 'row');
                    $row->setAttribute('r', $rowNum);
                    $sheetData->appendChild($row);
                } else {
                    $row = $rowNodes->item(0);
                }
                $c = $dom->createElementNS('http://schemas.openxmlformats.org/spreadsheetml/2006/main','c');
                $c->setAttribute('r',$cellRef);

                // Insertar la celda en posición ordenada (Excel requiere celdas en orden por columna)
                $colLetra = preg_replace('/\d/', '', $cellRef);
                $nuevoColNum = 0;
                foreach (str_split($colLetra) as $char) {
                    $nuevoColNum = $nuevoColNum * 26 + (ord($char) - 64);
                }
                $insertarAntes = null;
                foreach ($row->childNodes as $hijo) {
                    if ($hijo->nodeType === XML_ELEMENT_NODE) {
                        $refExistente = $hijo->getAttribute('r');
                        $colExistente = preg_replace('/\d/', '', $refExistente);
                        $colExistenteNum = 0;
                        foreach (str_split($colExistente) as $char) {
                            $colExistenteNum = $colExistenteNum * 26 + (ord($char) - 64);
                        }
                        if ($colExistenteNum > $nuevoColNum) {
                            $insertarAntes = $hijo;
                            break;
                        }
                    }
                }
                if ($insertarAntes) {
                    $row->insertBefore($c, $insertarAntes);
                } else {
                    $row->appendChild($c);
                }
            }

            $isDate = false;
            $excelValue = $value;

            // Detección de fechas: SOLO si el valor ya es Carbon/DateTime (nunca strings).
            // Los strings formateados como "05-03-2025" o "2025" no se auto-detectan
            // porque Carbon los parsea erróneamente como fechas y producen números seriales.
            if ($value instanceof \Carbon\Carbon || $value instanceof \DateTime) {
                $excelValue = $convertPhpDateToExcelSerial($value);
                if ($excelValue !== null) {
                    $isDate = true;
                }
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

            // El ZIP se actualiza UNA VEZ al final de cada hoja (no aquí),
            // para evitar 110,000 escrituras al ZIP con ~4,000 filas × 26 columnas.
        };


        $DC = new RepDelCiuInt1AClass($start_date, $end_date);

        // ─── HOJA 1: construcción directa de XML (sin DOM, mucho más rápido) ──────────
        $xmlSheet1Raw = $zip->getFromName('xl/worksheets/sheet1.xml');

        // Función auxiliar para escapar texto en XML
        $esc = fn($v) => htmlspecialchars((string)$v, ENT_XML1 | ENT_QUOTES, 'UTF-8');

        // Extraer estilos de columna de la fila 6 del template (una sola vez)
        $estilosCol = [];
        preg_match_all('/<c r="([A-Z]+)6"[^>]*?s="(\d+)"/', $xmlSheet1Raw, $mEst);
        if (!empty($mEst[1])) {
            $estilosCol = array_combine($mEst[1], $mEst[2]);
        }

        // Extraer atributos de la fila de datos del template (fila 6) para reutilizarlos
        preg_match('/<row ([^>]*)r="6"/', $xmlSheet1Raw, $mRow);
        $rowAttrsBase = isset($mRow[1]) ? rtrim($mRow[1]) . ' ' : '';

        // Función para construir el XML de una celda directamente como string
        $buildCelda = function(string $col, int $rowNum, $value) use (&$estilosCol, $convertPhpDateToExcelSerial, $esc): string {
            $ref = $col . $rowNum;
            $s   = $estilosCol[$col] ?? '0';
            $sAttr = ($s !== '' && $s !== '0') ? ' s="' . $s . '"' : '';
            if ($value === '' || $value === null) {
                return '<c r="' . $ref . '"' . $sAttr . '/>';
            }
            if ($value instanceof \Carbon\Carbon || $value instanceof \DateTime) {
                $ev = $convertPhpDateToExcelSerial($value);
                return '<c r="' . $ref . '"' . $sAttr . ' t="n"><v>' . $ev . '</v></c>';
            }
            if (is_numeric($value)) {
                return '<c r="' . $ref . '"' . $sAttr . ' t="n"><v>' . $value . '</v></c>';
            }
            return '<c r="' . $ref . '"' . $sAttr . ' t="inlineStr"><is><t>' . $esc($value) . '</t></is></c>';
        };

        $Items = $DC->getSabanaDeDatos();

        $ser = Servicio::where('is_visible_mobile', true)
            ->where('is_visible_nombre_corto_ss', true)
            ->pluck('id')
            ->toArray();

        // Generar XML de las filas de datos directamente como string
        $newRowsXml = '';
        $i = 6;
        foreach ($Items as $item) {
            // Calcular campos derivados de fechas
            $fechaIngreso = $item->fecha_ingreso ? Carbon::parse($item->fecha_ingreso)->format('d-m-Y') : '';
            $fiMes        = $item->fecha_ingreso ? Carbon::parse($item->fecha_ingreso)->format('m')     : '';
            $fiAno        = $item->fecha_ingreso ? Carbon::parse($item->fecha_ingreso)->format('Y')     : '';

            $Delegacion = $item->centro_delegacion ?? '';
            $Colonia    = $item->centro_colonia ?? '';
            $Delegado   = $item->delegado          ?? '';
            $Ciudadano  = $item->ciudadano         ?? '';

            $fueMes      = $item->fecha_ultimo_estatus ? Carbon::parse($item->fecha_ultimo_estatus)->format('m')     : '';
            $fueAno      = $item->fecha_ultimo_estatus ? Carbon::parse($item->fecha_ultimo_estatus)->format('Y')     : '';
            $fueFechaFmt = $item->fecha_ultimo_estatus ? Carbon::parse($item->fecha_ultimo_estatus)->format('d-m-Y') : '';

            $dias_transcurridos_atencion = Carbon::parse($item->fecha_ultimo_estatus)
                ->startOfDay()->diffInDays(Carbon::parse($item->fecha_ingreso)->startOfDay());

            $dias_transcurridos_desde_ultimo_estatus = Carbon::parse($item->fecha_ultimo_estatus)
                ->startOfDay()->diffInDays(Carbon::now()->startOfDay());

            $dias_transcurridos_desde_inicio = Carbon::parse($item->fecha_ingreso)
                ->startOfDay()->diffInDays(Carbon::now()->startOfDay());

            // Construir la fila como XML string (en orden de columna)
            $newRowsXml .= '<row ' . $rowAttrsBase . 'r="' . $i . '">';
            $newRowsXml .= $buildCelda('A', $i, $item->denuncia_id ?? 0);
            $newRowsXml .= $buildCelda('B', $i, trim($item->username_ciudadano ?? ''));
            $newRowsXml .= $buildCelda('C', $i, trim($item->ap_paterno_ciudadano ?? ''));
            $newRowsXml .= $buildCelda('D', $i, trim($item->ap_materno_ciudadano ?? ''));
            $newRowsXml .= $buildCelda('E', $i, trim($item->nombre_ciudadano ?? ''));
            $newRowsXml .= $buildCelda('F', $i, strtoupper(trim($item->search_google ?? '')));
            $newRowsXml .= $buildCelda('G', $i, $Colonia);
            $newRowsXml .= $buildCelda('H', $i, $Delegacion);
            $newRowsXml .= $buildCelda('I', $i, $Ciudadano === $Delegado ? 'Es el delegado' : '');
            $newRowsXml .= $buildCelda('J', $i, trim(($item->telefonos_ciudadano ?? '') . ' ' . ($item->email_ciudadano ?? '')));
            $newRowsXml .= $buildCelda('K', $i, $fechaIngreso);
            $newRowsXml .= $buildCelda('L', $i, $fiMes);
            $newRowsXml .= $buildCelda('M', $i, $fiAno);
            $newRowsXml .= $buildCelda('N', $i, $item->dependencia ?? '');
            $newRowsXml .= $buildCelda('O', $i, $item->servicio ?? '');
            $newRowsXml .= $buildCelda('P', $i, in_array($item->sue_id, $ser, true) ? 'Monitoreado' : '');
            $newRowsXml .= $buildCelda('Q', $i, trim(($item->descripcion ?? '') . ' ' . ($item->referencia ?? '')));
            $newRowsXml .= $buildCelda('R', $i, $item->prioridad ?? '');
            $newRowsXml .= $buildCelda('S', $i, $item->origen ?? '');
            $newRowsXml .= $buildCelda('T', $i, $item->estatus ?? '');
            $newRowsXml .= $buildCelda('U', $i, $fueFechaFmt);
            $newRowsXml .= $buildCelda('V', $i, $fueMes);
            $newRowsXml .= $buildCelda('W', $i, $fueAno);
            $newRowsXml .= $buildCelda('X', $i, $item->observaciones ?? '');
            $newRowsXml .= $buildCelda('Y', $i, $dias_transcurridos_atencion);
            $newRowsXml .= $buildCelda('Z', $i, $dias_transcurridos_desde_ultimo_estatus);
            $newRowsXml .= $buildCelda('AA', $i, $dias_transcurridos_desde_inicio);
            $newRowsXml .= '</row>';
            $i++;
        }

        // Extraer filas de cabecera (1-6) del template para preservar encabezados
        preg_match_all('/<row [^>]*r="[1-5]"[^>]*>.*?<\/row>/s', $xmlSheet1Raw, $mCabeceras);
        $xmlCabeceras = implode('', $mCabeceras[0]);

        // Reemplazar el sheetData completo en el XML del template con string manipulation
        $posIni = strpos($xmlSheet1Raw, '<sheetData');
        $posFin = strpos($xmlSheet1Raw, '</sheetData>') + strlen('</sheetData>');
        $xmlSheet1Final = substr($xmlSheet1Raw, 0, $posIni)
            . '<sheetData>' . $xmlCabeceras . $newRowsXml . '</sheetData>'
            . substr($xmlSheet1Raw, $posFin);

        // Guardar sheet1 al ZIP (una sola operación, sin DOM)
        $zip->deleteName('xl/worksheets/sheet1.xml');
        $zip->addFromString('xl/worksheets/sheet1.xml', $xmlSheet1Final);

        $xml1 = $zip->getFromName('xl/worksheets/sheet2.xml');
        $dom1 = new \DOMDocument();
        $dom1->loadXML($xml1);
        $xp1  = new \DOMXPath($dom1);
        $xp1->registerNamespace('d','http://schemas.openxmlformats.org/spreadsheetml/2006/main');

        // Inicia procesamiento de datos

        $Items = $DC->getRecibidasCiudadanos();
        $i = 4;
        foreach ($Items as $Item) {
            $setCell(
                $xp1,
                $dom1,
                'xl/worksheets/sheet2.xml',
                'B' . $i,
                $Item['TOTAL'] ?? ''
            );
            $i++;
        }

        $Items = $DC->getRecibidasDelegados();
        $i = 4;
        foreach ($Items as $Item) {
            $setCell(
                $xp1,
                $dom1,
                'xl/worksheets/sheet2.xml',
                'F' . $i,
                $Item['TOTAL'] ?? ''
            );
            $i++;
        }

        $Items = $DC->getRecibidasInternos();
        $i = 4;
        foreach ($Items as $Item) {
            $setCell(
                $xp1,
                $dom1,
                'xl/worksheets/sheet2.xml',
                'J' . $i,
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
                'xl/worksheets/sheet2.xml',
                'B' . $i,
                $Item['T'] ?? ''
            );
            $i++;
        }



        $PendientesPromCiudadano = $DC->getPendientesCiudadanos();
        $AtendidasPromCiudadanos = $DC->getAtendidasCiudadanos();
        $i = 25;
        $letrasA = ['B','D','F','H','J','L'];
        $letrasP = ['C','E','G','I','K','M'];
        $ii = [0, 1, 2, 3, 4, 5];

        // Ciudadanos
        foreach ($ii as $key => $value) {
            $Item = $AtendidasPromCiudadanos[$value];
            $setCell($xp1, $dom1, 'xl/worksheets/sheet2.xml', $letrasA[$value] . $i, $Item['DIAS_ATE'] ?? '');
            $Item = $PendientesPromCiudadano[$value];
            $setCell($xp1, $dom1, 'xl/worksheets/sheet2.xml', $letrasP[$value] . $i, $Item['DIAS_PEN'] ?? '');
        }

        // Delegados
        $PendientesPromDelegados = $DC->getPendientesDelegados();
        $AtendidasPromDelegados = $DC->getAtendidasDelegados();
        $i = 26;
        foreach ($ii as $key => $value) {
            $Item = $AtendidasPromDelegados[$value];
            $setCell($xp1, $dom1, 'xl/worksheets/sheet2.xml', $letrasA[$value] . $i, $Item['DIAS_ATE_DEL'] ?? '');
            $Item = $PendientesPromDelegados[$value];
            $setCell($xp1, $dom1, 'xl/worksheets/sheet2.xml', $letrasP[$value] . $i, $Item['DIAS_PEN_DEL'] ?? '');
        }

        // Instituciones
        $PendientesPromInstitucion = $DC->getPendientesInternas();
        $AtendidasPromInstitucion = $DC->getAtendidasInternas();
        $i = 27;
        foreach ($ii as $key => $value) {
            $Item = $AtendidasPromInstitucion[$value];
            $setCell($xp1, $dom1, 'xl/worksheets/sheet2.xml', $letrasA[$value] . $i, $Item['DIAS_ATE_INS'] ?? '');
            $Item = $PendientesPromInstitucion[$value];
            $setCell($xp1, $dom1, 'xl/worksheets/sheet2.xml', $letrasP[$value] . $i, $Item['DIAS_PEN_INS'] ?? '');
        }



        $PendientesProm = $DC->getPendientesProm();
        $AtendidasProm = $DC->getAtendidasProm();

        $ii = [3, 1, 0, 5, 2, 4];
        $i = 32;
        foreach ($ii as $key => $value) {
            $Item = $PendientesProm[$value];
            $setCell($xp1, $dom1, 'xl/worksheets/sheet2.xml', 'B' . $i, $Item['PROM_PEN'] ?? '');
            $setCell($xp1, $dom1, 'xl/worksheets/sheet2.xml', 'C' . $i, $Item['DIAS_PEN'] ?? '');
            $i++;
        }

        $i = 42;
        foreach ($ii as $key => $value) {
            $Item = $AtendidasProm[$value];
            $setCell($xp1, $dom1, 'xl/worksheets/sheet2.xml', 'B' . $i, $Item['PROM_ATE'] ?? '');
            $setCell($xp1, $dom1, 'xl/worksheets/sheet2.xml', 'C' . $i, $Item['DIAS_ATE'] ?? '');
            $i++;
        }

        $Items = $DC->getLlamadas();

        $i = 52;
        foreach ($Items as $Item) {
            $setCell($xp1, $dom1, 'xl/worksheets/sheet2.xml', 'B' . $i, $Item['LLAMADAS'] ?? '');
            $i++;
        }

        // Finaliza procesamiento de datos


        $nodesF = $xp1->query("//d:c[@r='B10']/d:v | //d:c[@r='B20']/d:v | //d:c[@r='C4']/d:v | //d:c[@r='C7']/d:v | //d:c[@r='C9']/d:v | //d:c[@r='C38']/d:v | //d:c[@r='C48']/d:v | //d:c[@r='B58']/d:v | //d:c[@r='F10']/d:v | //d:c[@r='G4']/d:v | //d:c[@r='G7']/d:v | //d:c[@r='G9']/d:v | //d:c[@r='J10']/d:v | //d:c[@r='K4']/d:v | //d:c[@r='K7']/d:v | //d:c[@r='K9']/d:v | //d:c[@r='B28']/d:v | //d:c[@r='C28']/d:v | //d:c[@r='D28']/d:v | //d:c[@r='E28']/d:v | //d:c[@r='F28']/d:v | //d:c[@r='G28']/d:v | //d:c[@r='H28']/d:v | //d:c[@r='I28']/d:v | //d:c[@r='J28']/d:v | //d:c[@r='K28']/d:v | //d:c[@r='L28']/d:v | //d:c[@r='M28']/d:v | //d:c[@r='N25']/d:v | //d:c[@r='N26']/d:v | //d:c[@r='N27']/d:v | //d:c[@r='N28']/d:v");
        foreach ($nodesF as $v) {
            $v->parentNode->removeChild($v);
        }

        // Guardar sheet2 al ZIP una sola vez
        $zip->deleteName('xl/worksheets/sheet2.xml');
        $zip->addFromString('xl/worksheets/sheet2.xml', $dom1->saveXML());

        $xml2 = $zip->getFromName('xl/worksheets/sheet3.xml');
        $dom2 = new \DOMDocument();
        $dom2->loadXML($xml2);
        $xp2  = new \DOMXPath($dom2);
        $xp2->registerNamespace('d','http://schemas.openxmlformats.org/spreadsheetml/2006/main');

        $fechaCarbon = Carbon::now(); // Obtiene la fecha y hora actual
        $fechaFormateada = $fechaCarbon->locale('es_MX')->isoFormat('dddd DD [de] MMMM [de] YYYY [corte a las] HH:mm[hrs.]');

        $setCell($xp2, $dom2, 'xl/worksheets/sheet3.xml', 'M3', $start_date);
        $setCell($xp2, $dom2, 'xl/worksheets/sheet3.xml', 'S3', $end_date);
//        $setCell($xp2, $dom2, 'xl/worksheets/sheet3.xml', 'A39', $end_date);

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

        // Guardar sheet3 al ZIP una sola vez
        $zip->deleteName('xl/worksheets/sheet3.xml');
        $zip->addFromString('xl/worksheets/sheet3.xml', $dom2->saveXML());

        $zip->close();

        return response()
            ->download($output, 'reporte_rango_'. Carbon::parse($start_date)->format('dmY') .'_'. Carbon::parse($end_date)->format('dmY') . '.xlsx')
            ->deleteFileAfterSend(true);

    }















}
