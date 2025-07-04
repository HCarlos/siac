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

    public function reporteDiarioExcel(Request $request)
    {


        ini_set('max_execution_time', 90000);

        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        $DC = new DashboardClass();
        $Items = $DC->getRecibidasAtendidas($start_date, $end_date);

        $file_external = "fmt_graficos_diarios.xlsx";
        $archivo = LoadTemplateExcel::getFileTemplate($file_external);

        try {
            // 1. Cargar archivo usando el método correcto
            $reader = IOFactory::createReaderForFile($archivo);
            $reader->setIncludeCharts(true); // ¡IMPORTANTE! Activar antes de cargar

            $spreadsheet = $reader->load($archivo);

            // 2. Obtener hoja de datos
            $sh = $spreadsheet->getSheet(0);

//            dd("hola");
            $sh
                ->setCellValue('B4', $Items[0]["CR"] ?? 0)
                ->setCellValue('B5', $Items[1]["CR"] ?? 0)
                ->setCellValue('B6', $Items[2]["CR"] ?? 0)
                ->setCellValue('B7', $Items[3]["CR"] ?? 0)
                ->setCellValue('B8', $Items[4]["CR"] ?? 0)
                ->setCellValue('B9', $Items[5]["CR"] ?? 0)
                ->setCellValue('C4', $Items[0]["DR"] ?? 0)
                ->setCellValue('C5', $Items[1]["DR"] ?? 0)
                ->setCellValue('C6', $Items[2]["DR"] ?? 0)
                ->setCellValue('C7', $Items[3]["DR"] ?? 0)
                ->setCellValue('C8', $Items[4]["DR"] ?? 0)
                ->setCellValue('C9', $Items[5]["DR"] ?? 0)
                ->setCellValue('D4', $Items[0]["IR"] ?? 0)
                ->setCellValue('D5', $Items[1]["IR"] ?? 0)
                ->setCellValue('D6', $Items[2]["IR"] ?? 0)
                ->setCellValue('D7', $Items[3]["IR"] ?? 0)
                ->setCellValue('D8', $Items[4]["IR"] ?? 0)
                ->setCellValue('D9', $Items[5]["IR"] ?? 0)
                ->setCellValue('B14', $Items[0]["CA"] ?? 0)
                ->setCellValue('B15', $Items[1]["CA"] ?? 0)
                ->setCellValue('B16', $Items[2]["CA"] ?? 0)
                ->setCellValue('B17', $Items[3]["CA"] ?? 0)
                ->setCellValue('B18', $Items[4]["CA"] ?? 0)
                ->setCellValue('B19', $Items[5]["CA"] ?? 0)
                ->setCellValue('C14', $Items[0]["DA"] ?? 0)
                ->setCellValue('C15', $Items[1]["DA"] ?? 0)
                ->setCellValue('C16', $Items[2]["DA"] ?? 0)
                ->setCellValue('C17', $Items[3]["DA"] ?? 0)
                ->setCellValue('C18', $Items[4]["DA"] ?? 0)
                ->setCellValue('C19', $Items[5]["DA"] ?? 0)
                ->setCellValue('D14', $Items[0]["IA"] ?? 0)
                ->setCellValue('D15', $Items[1]["IA"] ?? 0)
                ->setCellValue('D16', $Items[2]["IA"] ?? 0)
                ->setCellValue('D17', $Items[3]["IA"] ?? 0)
                ->setCellValue('D18', $Items[4]["IA"] ?? 0)
                ->setCellValue('D19', $Items[5]["IA"] ?? 0);

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
            $newFileName = 'misdatos_actualizado_' . now()->format('Ymd_His') . '.xlsx';

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
