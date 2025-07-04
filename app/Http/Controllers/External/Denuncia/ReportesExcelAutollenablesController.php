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
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportesExcelAutollenablesController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

    public function reporteDiarioExcel(Request $request){
        ini_set('max_execution_time', 90000);
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $DC = new DashboardClass();
        $Items = $DC->getRecibidasAtendidas($start_date, $end_date);

//        dd($Items);

        $file_external = "fmt_graficos_diarios.xlsx";
        $archivo = LoadTemplateExcel::getFileTemplate($file_external);
        try {
            // 1. Cargar archivo usando el método correcto
            $reader = IOFactory::createReaderForFile($archivo);
            $reader->setIncludeCharts(true); // ¡IMPORTANTE! Activar antes de cargar
            $spreadsheet = $reader->load($archivo);
            // 2. Obtener hoja de datos
            $sh = $spreadsheet->getSheet(0);
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

            $tr = $Items[0]["TR"] + $Items[0]["TR"] + $Items[1]["TR"] + $Items[2]["TR"] +$Items[3]["TR"] + $Items[4]["TR"] + $Items[5]["TR"];
            $ta = $Items[0]["TA"] + $Items[0]["TA"] + $Items[1]["TA"] + $Items[2]["TA"] +$Items[3]["TA"] + $Items[4]["TA"] + $Items[5]["TA"];

            $sh = $spreadsheet->getSheet(1);
            $sh->setCellValue('D5', $tr ?? '');
            $sh->setCellValue('H5', $ta ?? '');
            // 4. Configurar writer para gráficos
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->setIncludeCharts(true);

            // 5. Forzar actualización de gráficos
            foreach ($spreadsheet->getAllSheets() as $sheet) {
                foreach ($sheet->getChartCollection() as $chart) {
                    $chart->refresh();
                }
            }

            // 6. Generar nuevo nombre
            $newFileName = 'grafico_diario_' . Carbon::parse($end_date)->format('dmY') . '.xlsx';

            // 7. Descargar directamente
            return new StreamedResponse(
                function () use ($writer) {
                    $writer->save('php://output');
                },
                200,
                [
                    'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'Content-Disposition' => 'attachment; filename="' . $newFileName . '"',
                    'Cache-Control' => 'max-age=0',
                ]
            );

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString() // Solo para desarrollo
            ], 500);
        }
    }
}
