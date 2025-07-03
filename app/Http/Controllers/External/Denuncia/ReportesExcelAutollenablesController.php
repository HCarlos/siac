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

class ReportesExcelAutollenablesController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

    public function reporteDiarioExcel(Request $request){


        ini_set('max_execution_time', 90000);

        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        $DC = new DashboardClass();
        $Items = $DC->getRecibidasAtendidas($start_date,$end_date);

        try {

//            dd($Items);

            $file_external = "fmt_graficos_diarios.xlsx";
            $arrFE = explode('.', $file_external);
            $extension = Str::ucfirst($arrFE[1]);

            $archivo = LoadTemplateExcel::getFileTemplate($file_external);
            $reader = IOFactory::createReader($extension);
            $spreadsheet = $reader->load($archivo);
            $sh = $spreadsheet->setActiveSheetIndex(0);


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
                ->setCellValue('D19', $Items[5]["IA"] ?? 0)

            ;

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="_'.$arrFE[0].'.'.$arrFE[1].'"');
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            header('Expires: Mon, 26 Jul 3997 05:00:00 GMT');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            header('Cache-Control: cache, must-revalidate');
            header('Pragma: public');
            $writer = IOFactory::createWriter($spreadsheet, $extension);
            $writer->save('php://output');
            exit;

        }catch (\Exception $e){
            //
        }

        }

}
