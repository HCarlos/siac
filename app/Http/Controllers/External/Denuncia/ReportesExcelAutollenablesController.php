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
use Illuminate\Support\Str;
use PHPExcel_IOFactory;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportesExcelAutollenablesController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

//    public function reporteDiarioExcel(Request $request)
//    {
//        ini_set('max_execution_time', 90000);
//        $start_date = $request->get('start_date');
//        $end_date = $request->get('end_date');
//        $DC = new DashboardClass();
//        $Items = $DC->getRecibidasAtendidas($start_date, $end_date);
//
//        $file_external = "fmt_graficos_diarios.xlsx";
//        $archivo = LoadTemplateExcel::getFileTemplate($file_external);
//
//        try {
//            // 1. Cargar archivo preservando estilos
////            $reader = IOFactory::createReaderForFile($archivo);
////            $reader->setIncludeCharts(true);
////            $spreadsheet = $reader->load($archivo);
//            $spreadsheet = IOFactory::load($archivo);
//
//            // 2. Obtener hoja de datos
//            $sh = $spreadsheet->getSheet(0);
//
//            $sh
//                ->setCellValue('B4', $Items[0]["CR"] ?? '')
//                ->setCellValue('B5', $Items[1]["CR"] ?? '')
//                ->setCellValue('B6', $Items[2]["CR"] ?? '')
//                ->setCellValue('B7', $Items[3]["CR"] ?? '')
//                ->setCellValue('B8', $Items[4]["CR"] ?? '')
//                ->setCellValue('B9', $Items[5]["CR"] ?? '')
//                ->setCellValue('C4', $Items[0]["DR"] ?? '')
//                ->setCellValue('C5', $Items[1]["DR"] ?? '')
//                ->setCellValue('C6', $Items[2]["DR"] ?? '')
//                ->setCellValue('C7', $Items[3]["DR"] ?? '')
//                ->setCellValue('C8', $Items[4]["DR"] ?? '')
//                ->setCellValue('C9', $Items[5]["DR"] ?? '')
//                ->setCellValue('D4', $Items[0]["IR"] ?? '')
//                ->setCellValue('D5', $Items[1]["IR"] ?? '')
//                ->setCellValue('D6', $Items[2]["IR"] ?? '')
//                ->setCellValue('D7', $Items[3]["IR"] ?? '')
//                ->setCellValue('D8', $Items[4]["IR"] ?? '')
//                ->setCellValue('D9', $Items[5]["IR"] ?? '')
//                ->setCellValue('B14', $Items[0]["CA"] ?? '')
//                ->setCellValue('B15', $Items[1]["CA"] ?? '')
//                ->setCellValue('B16', $Items[2]["CA"] ?? '')
//                ->setCellValue('B17', $Items[3]["CA"] ?? '')
//                ->setCellValue('B18', $Items[4]["CA"] ?? '')
//                ->setCellValue('B19', $Items[5]["CA"] ?? '')
//                ->setCellValue('C14', $Items[0]["DA"] ?? '')
//                ->setCellValue('C15', $Items[1]["DA"] ?? '')
//                ->setCellValue('C16', $Items[2]["DA"] ?? '')
//                ->setCellValue('C17', $Items[3]["DA"] ?? '')
//                ->setCellValue('C18', $Items[4]["DA"] ?? '')
//                ->setCellValue('C19', $Items[5]["DA"] ?? '')
//                ->setCellValue('D14', $Items[0]["IA"] ?? '')
//                ->setCellValue('D15', $Items[1]["IA"] ?? '')
//                ->setCellValue('D16', $Items[2]["IA"] ?? '')
//                ->setCellValue('D17', $Items[3]["IA"] ?? '')
//                ->setCellValue('D18', $Items[4]["IA"] ?? '')
//                ->setCellValue('D19', $Items[5]["IA"] ?? '');
//
//
//            $tr = $Items[0]["TR"] + $Items[1]["TR"] + $Items[2]["TR"] + $Items[3]["TR"] + $Items[4]["TR"] + $Items[5]["TR"];
//            $ta = $Items[0]["TA"] + $Items[1]["TA"] + $Items[2]["TA"] + $Items[3]["TA"] + $Items[4]["TA"] + $Items[5]["TA"];
//
//            $sh = $spreadsheet->getSheet(1);
//            $sh->setCellValue('D5', $tr ?? '');
//            $sh->setCellValue('H5', $ta ?? '');
//
//            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
//            $writer->setIncludeCharts(true);
//
//            // 6. Generar nuevo nombre
//            $newFileName = 'grafico_diario_' . Carbon::parse($end_date)->format('dmY') . '.xlsx';
//            $writer->save($newFileName);
//            return response()->download($newFileName, 'Reporte Diario Modificado.xlsx')->deleteFileAfterSend(true);
//
//
//        } catch (\Exception $e) {
//            return response()->json([
//                'error' => $e->getMessage(),
//                'trace' => $e->getTraceAsString()
//            ], 500);
//        }
//    }
//


    public function reporteDiarioExcel(Request $request)
    {
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $DC = new DashboardClass();
        $Items = $DC->getRecibidasAtendidas($start_date, $end_date);

        $file_external = "fmt_graficos_diarios.xlsx";
        $archivo = LoadTemplateExcel::getFileTemplate($file_external);
        $newFileName = 'grafico_diario_' . Carbon::parse($end_date)->format('dmY') . '.xlsx';

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

        $setCell = function(\DOMXPath $xp, \DOMDocument $dom, string $sheetXmlPath, string $cellRef, $value) use ($zip) {
            $query = "//d:c[@r='$cellRef']";
            $nodes = $xp->query($query);
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
                if (is_numeric($value)) {
                    $c->setAttribute('t','n');
                } else {
                    $c->setAttribute('t','inlineStr');
                }
                $row->appendChild($c);
            }
            if (is_numeric($value)) {
                $v = $dom->createElementNS('http://schemas.openxmlformats.org/spreadsheetml/2006/main','v',$value);
            } else {
                $is = $dom->createElementNS('http://schemas.openxmlformats.org/spreadsheetml/2006/main','is');
                $t  = $dom->createElementNS('http://schemas.openxmlformats.org/spreadsheetml/2006/main','t',$value);
                $is->appendChild($t);
                $c->appendChild($is);
                $newXml = $dom->saveXML();
                $zip->addFromString($sheetXmlPath, $newXml);
                return;
            }
            $c->appendChild($v);
            $newXml = $dom->saveXML();
            $zip->addFromString($sheetXmlPath, $newXml);
        };

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

// 1) Eliminar el valor en caché de las fórmulas en E4 y E14
        $nodesF = $xp1->query("//d:c[@r='E4']/d:v | //d:c[@r='E14']/d:v");
        foreach ($nodesF as $v) {
            $v->parentNode->removeChild($v);
        }

// 2) Volver a guardar sheet1.xml sin esos <v>
        $zip->addFromString(
            'xl/worksheets/sheet1.xml',
            $dom1->saveXML()
        );

// Ahora continuas con la carga y modificación de sheet2.xml
        $xml2 = $zip->getFromName('xl/worksheets/sheet2.xml');
        $dom2 = new \DOMDocument();
        $dom2->loadXML($xml2);
        $xp2  = new \DOMXPath($dom2);
        $xp2->registerNamespace('d','http://schemas.openxmlformats.org/spreadsheetml/2006/main');

//        $tr = array_sum(array_column((array)$Items,'TR'));
//        $ta = array_sum(array_column((array)$Items,'TA'));
        $tr = $Items[0]["TR"] + $Items[1]["TR"] + $Items[2]["TR"] + $Items[3]["TR"] + $Items[4]["TR"] + $Items[5]["TR"];
        $ta = $Items[0]["TA"] + $Items[1]["TA"] + $Items[2]["TA"] + $Items[3]["TA"] + $Items[4]["TA"] + $Items[5]["TA"];

        $setCell($xp2, $dom2, 'xl/worksheets/sheet2.xml', 'D5', $tr);
        $setCell($xp2, $dom2, 'xl/worksheets/sheet2.xml', 'H5', $ta);

        $zip->close();

        return response()
            ->download($output, 'Reporte Diario Modificado.xlsx')
            ->deleteFileAfterSend(true);


    }

    public function reporteDiarioExcel_1(Request $request)
    {
        ini_set('max_execution_time', 90000);

        // --- INCLUYE ESTAS LÍNEAS ANTES DE USAR OPENTBS_… ---
//        $pathClass  = base_path('vendor/tinybutstrong/tinybutstrong/tbs_class.php');
//        $pathPlugin = base_path('vendor/tinybutstrong/opentbs/tbs_plugin_opentbs.php');
//
//        if (! file_exists($pathClass) || ! file_exists($pathPlugin)) {
//            throw new \Exception("No encuentro TinyButStrong u OpenTBS en:\n"
//                . "$pathClass\n$pathPlugin");
//        }
//        require_once $pathClass;
//        require_once $pathPlugin;

//        if (! defined('OPENTBS_SET_CELLS')) {
//            // 5 es el valor interno que OpenTBS usa para CHANGE_CELL
//            define('OPENTBS_SET_CELLS', 5);
//        }


        // 1. Rutas
//        $template = storage_path('app/formats/Formato reporte diario SIAC 2.0.xlsx');
//        $output   = storage_path('app/formats/Formato reporte diario SIAC 2.0 – modificado.xlsx');


        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $DC = new DashboardClass();
        $Items = $DC->getRecibidasAtendidas($start_date, $end_date);

        $file_external = "fmt_graficos_diarios.xlsx";
        $archivo = LoadTemplateExcel::getFileTemplate($file_external);
        $newFileName = 'grafico_diario_' . Carbon::parse($end_date)->format('dmY') . '.xlsx';

            // 2. Inicializar TinyButStrong + OpenTBS
        // 2) Creamos un reader que *sí* cargue los gráficos
        $reader = IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(false);
        $reader->setIncludeCharts(true);    // <- clave para preservar gráficos al leer

        // 3) Cargamos el spreadsheet completo
        $spreadsheet = $reader->load($archivo);

        // 4) Tomamos HOJA 1 y volcamos en bloque los datos CR/DR/IR y CA/DA/IA
        $sh = $spreadsheet->getSheet(0);
//        $Items = $request->input('datos', []);
//
//        // Preparar los bloques con fromArray
//        $block1 = array_map(fn($item) => [
//            $item['CR'] ?? '',
//            $item['DR'] ?? '',
//            $item['IR'] ?? '',
//        ],
//            (array)array_slice($Items, 0, 6));
//        $block2 = array_map(fn($item) => [
//            $item['CA'] ?? '',
//            $item['DA'] ?? '',
//            $item['IA'] ?? '',
//        ], (array)array_slice($Items, 0, 6));
//
//        $sh1->fromArray($block1, null, 'B4');   // escribe B4:D9
//        $sh1->fromArray($block2, null, 'B14');  // escribe B14:D19

            $sh
                ->setCellValue('B4', $Items[0]["CR"] ?? '')
                ->setCellValue('B5', $Items[1]["CR"] ?? '')
                ->setCellValue('B6', $Items[2]["CR"] ?? '')
                ->setCellValue('B7', $Items[3]["CR"] ?? '')
                ->setCellValue('B8', $Items[4]["CR"] ?? '')
                ->setCellValue('B9', $Items[5]["CR"] ?? '')
                ->setCellValue('C4', $Items[0]["DR"] ?? '')
                ->setCellValue('C5', $Items[1]["DR"] ?? '')
                ->setCellValue('C6', $Items[2]["DR"] ?? '')
                ->setCellValue('C7', $Items[3]["DR"] ?? '')
                ->setCellValue('C8', $Items[4]["DR"] ?? '')
                ->setCellValue('C9', $Items[5]["DR"] ?? '')
                ->setCellValue('D4', $Items[0]["IR"] ?? '')
                ->setCellValue('D5', $Items[1]["IR"] ?? '')
                ->setCellValue('D6', $Items[2]["IR"] ?? '')
                ->setCellValue('D7', $Items[3]["IR"] ?? '')
                ->setCellValue('D8', $Items[4]["IR"] ?? '')
                ->setCellValue('D9', $Items[5]["IR"] ?? '')
                ->setCellValue('B14', $Items[0]["CA"] ?? '')
                ->setCellValue('B15', $Items[1]["CA"] ?? '')
                ->setCellValue('B16', $Items[2]["CA"] ?? '')
                ->setCellValue('B17', $Items[3]["CA"] ?? '')
                ->setCellValue('B18', $Items[4]["CA"] ?? '')
                ->setCellValue('B19', $Items[5]["CA"] ?? '')
                ->setCellValue('C14', $Items[0]["DA"] ?? '')
                ->setCellValue('C15', $Items[1]["DA"] ?? '')
                ->setCellValue('C16', $Items[2]["DA"] ?? '')
                ->setCellValue('C17', $Items[3]["DA"] ?? '')
                ->setCellValue('C18', $Items[4]["DA"] ?? '')
                ->setCellValue('C19', $Items[5]["DA"] ?? '')
                ->setCellValue('D14', $Items[0]["IA"] ?? '')
                ->setCellValue('D15', $Items[1]["IA"] ?? '')
                ->setCellValue('D16', $Items[2]["IA"] ?? '')
                ->setCellValue('D17', $Items[3]["IA"] ?? '')
                ->setCellValue('D18', $Items[4]["IA"] ?? '')
                ->setCellValue('D19', $Items[5]["IA"] ?? '');


            $tr = $Items[0]["TR"] + $Items[1]["TR"] + $Items[2]["TR"] + $Items[3]["TR"] + $Items[4]["TR"] + $Items[5]["TR"];
            $ta = $Items[0]["TA"] + $Items[1]["TA"] + $Items[2]["TA"] + $Items[3]["TA"] + $Items[4]["TA"] + $Items[5]["TA"];

            $sh = $spreadsheet->getSheet(1);
            $sh->setCellValue('D5', $tr ?? '');
            $sh->setCellValue('H5', $ta ?? '');


        // 5) Sumar TR y TA y escribir en HOJA 2
//        $tr = array_sum(array_column($Items, 'TR'));
//        $ta = array_sum(array_column($Items, 'TA'));
//        $sh2 = $spreadsheet->getSheet(1);
//        $sh2->setCellValue('D5', $tr);
//        $sh2->setCellValue('H5', $ta);

        // 6) Guardar con charts preservados
        $writer = new Xlsx($spreadsheet);
        $writer->setIncludeCharts(true);      // <- clave para preservar al guardar
        $writer->save($newFileName);

        // 7) Enviar descarga al usuario
        return response()
            ->download($newFileName, 'Reporte Diario Modificado.xlsx')
            ->deleteFileAfterSend(true);

        }





}
