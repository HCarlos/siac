<?php
/*
 * Copyright (c) 2025. Realizado por Carlos Hidalgo
 */

namespace App\Http\Controllers\External\Denuncia;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Http\Controllers\Funciones\LoadTemplateExcel;
use App\Models\Denuncias\_viDepDenServEstatus;
use App\Models\Denuncias\_viMovSM;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Exception;

class ResumenSMController extends Controller{

    public function getMenu(Request $request){
        ini_set('max_execution_time', 90000);
        $Items = $request->session()->get('items');

        $C0 = 6;
        $C = $C0;

        try {

            $data =  $request->only(['fileoutput','indice']);
            $file_external =  $data["fileoutput"];
            $indice = (int) $data["indice"];

            $arrFE = explode('.',$file_external);
            $extension = Str::ucfirst($arrFE[1]);

            $archivo =  LoadTemplateExcel::getFileTemplate($file_external);
            $reader = IOFactory::createReader($extension);
            $spreadsheet = $reader->load($archivo);
            $sh = $spreadsheet->setActiveSheetIndex(0);

            switch ($indice){
                case 4:
                case 5:
                    $this->resumenBasico($C, $C0, $sh, $Items, $arrFE, $spreadsheet, $archivo, $extension);
                    break;
            }

        } catch (Exception $e) {
            echo 'Ocurrio un error al intentar abrir el archivo ' . $e;
        }

    }

    public function resumenBasico($C, $C0, $sh, $Items, $arrFE, $spreadsheet, $archivo, $extension){

        $sh->setCellValue('F1', Carbon::now()->format('d-m-Y h:i:s'));
        $C = 5;
        foreach ($Items as $item){
            $sh
                ->setCellValue('A' . $C, $item["servicio"] ?? '')
                ->setCellValue('B' . $C, $item["atendidas"] ?? 0)
                ->setCellValue('C' . $C, $item["rechazadas"] ?? 0)
                ->setCellValue('D' . $C, $item["pendientes"] ?? 0)
                ->setCellValue('E' . $C, $item["observadas"] ?? 0)
                ->setCellValue('F' . $C, $item["total"] ?? 0)
                ->setCellValue('G' . $C, $item["obs"] ?? '');
            $C++;
        }


        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="_'.$arrFE[0].'.'.$arrFE[1].'"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $writer = IOFactory::createWriter($spreadsheet, $extension);
        $writer->save('php://output');
        exit;
    }



    function resumenBasico01Export(Request $request){
        $arrColl = [
            ["sue_id" => 476, "servicio" => "FUGA DE AGUA POTABLE", "atendidas" => 0,"rechazadas" => 0,"pendientes" => 0,"observadas"=>0, "total"=>0, "obs"=>''],
            ["sue_id" => 508, "servicio" => "DESASOLVE DE DRENAJE","atendidas" => 0,"rechazadas" => 0,"pendientes" => 0,"observadas"=>0, "total"=>0, "obs"=>''],
            ["sue_id" => 479, "servicio" => "REPARACION DE ALCANTARILLA","atendidas" => 0,"rechazadas" => 0,"pendientes" => 0,"observadas"=>0, "total"=>0, "obs"=>''],
            ["sue_id" => 568, "servicio" => "RESANE HIDRÁHULICO","atendidas" => 0,"rechazadas" => 0,"pendientes" => 0,"observadas"=>0, "total"=>0, "obs"=>'Informativo'],
        ];

        $data = $request->validate([
            'items' => 'required|string',
        ]);

        $ids = collect(explode(',', $data['items']))
            ->map(function ($value) {
                return (int) $value;
            })
            ->toArray();

        $arrServ = _viMovSM::select(
                'id','denuncia_id', 'servicio_id', 'estatu_id'
            )
            ->whereIn('denuncia_id', $ids)
            ->whereIn('servicio_id', [476,508,479,568])
            ->orderByDesc('id')
            ->get();

        $ue_id_mappings = [
            17 => 'atendidas',
            21 => 'atendidas',
            20 => 'rechazadas',
            22 => 'rechazadas',
            16 => 'pendientes',
            19 => 'pendientes',
            18 => 'observadas',
        ];

        foreach ($arrServ as $item) {
            $indice = null;
            $totalNulos = 0;
            switch ($item->servicio_id) {
                case 476:
                    $indice = 0;
                    break;
                case 508:
                    $indice = 1;
                    break;
                case 479:
                    $indice = 2;
                    break;
                case 568:
                    $indice = 3;
                    break;
            }

            if ($indice !== null) {
                $ue_id = (int) $item->estatu_id; // Castea a entero una sola vez

                if (in_array($ue_id, [17, 21])) {
                    $arrColl[$indice]["atendidas"]++;
                }
                if (in_array($ue_id, [20, 22])) {
                    $arrColl[$indice]["rechazadas"]++;
                }
                if (in_array($ue_id, [16, 19])) {
                    $arrColl[$indice]["pendientes"]++;
                }
                if ($ue_id === 18) {
                    $arrColl[$indice]["observadas"]++;
                }
                $arrColl[$indice]["total"]++;
            }else{
                $totalNulos++;
            }

        }

        $request->session()->put('items', $arrColl);

        return $this->getMenu($request);

    }

    function resumenBasico02Export(Request $request){
        $arrColl = [
            ["sue_id" => 476, "servicio" => "FUGA DE AGUA POTABLE", "atendidas" => 0,"rechazadas" => 0,"pendientes" => 0,"observadas"=>0, "total"=>0, "obs"=>''],
            ["sue_id" => 508, "servicio" => "DESASOLVE DE DRENAJE","atendidas" => 0,"rechazadas" => 0,"pendientes" => 0,"observadas"=>0, "total"=>0, "obs"=>''],
            ["sue_id" => 479, "servicio" => "REPARACION DE ALCANTARILLA","atendidas" => 0,"rechazadas" => 0,"pendientes" => 0,"observadas"=>0, "total"=>0, "obs"=>''],
            ["sue_id" => 483, "servicio" => "BACHEO", "atendidas" => 0,"rechazadas" => 0,"pendientes" => 0,"observadas"=>0, "total"=>0, "obs"=>''],
            ["sue_id" => 503, "servicio" => "RECOLECCIÓN DE RESIDUOS SÓLIDOS","atendidas" => 0,"rechazadas" => 0,"pendientes" => 0,"observadas"=>0, "total"=>0, "obs"=>''],
            ["sue_id" => 466, "servicio" => "REPARACIÓN DE LUMINARIAS","atendidas" => 0,"rechazadas" => 0,"pendientes" => 0,"observadas"=>0, "total"=>0, "obs"=>''],
            ["sue_id" => 567, "servicio" => "RESANE ASFÁLTICO","atendidas" => 0,"rechazadas" => 0,"pendientes" => 0,"observadas"=>0, "total"=>0, "obs"=>'Informativo'],
            ["sue_id" => 568, "servicio" => "RESANE HIDRÁHULICO","atendidas" => 0,"rechazadas" => 0,"pendientes" => 0,"observadas"=>0, "total"=>0, "obs"=>'Informativo'],
        ];

        $data = $request->validate([
            'items' => 'required|string',
        ]);

        $ids = collect(explode(',', $data['items']))
            ->map(function ($value) {
                return (int) $value;
            })
            ->toArray();

        $arrServ = _viMovSM::select(
                'id','denuncia_id', 'servicio_id', 'estatu_id'
            )
            ->whereIn('denuncia_id', $ids)
            ->whereIn('servicio_id', [483,508,476,503,479,466,567,568])
            ->orderByDesc('id')
            ->get();

        $ue_id_mappings = [
            17 => 'atendidas',
            21 => 'atendidas',
            20 => 'rechazadas',
            22 => 'rechazadas',
            16 => 'pendientes',
            19 => 'pendientes',
            18 => 'observadas',
        ];

        foreach ($arrServ as $item) {
            $indice = null;
            $totalNulos = 0;
            switch ($item->servicio_id) {
                case 476:
                    $indice = 0;
                    break;
                case 508:
                    $indice = 1;
                    break;
                case 479:
                    $indice = 2;
                    break;
                case 483:
                    $indice = 3;
                    break;
                case 503:
                    $indice = 4;
                    break;
                case 466:
                    $indice = 5;
                    break;
                case 567:
                    $indice = 6;
                    break;
                case 568:
                    $indice = 7;
                    break;
            }

            if ($indice !== null) {
                $ue_id = (int) $item->estatu_id; // Castea a entero una sola vez

                if (in_array($ue_id, [17, 21])) {
                    $arrColl[$indice]["atendidas"]++;
                }
                if (in_array($ue_id, [20, 22])) {
                    $arrColl[$indice]["rechazadas"]++;
                }
                if (in_array($ue_id, [16, 19])) {
                    $arrColl[$indice]["pendientes"]++;
                }
                if ($ue_id === 18) {
                    $arrColl[$indice]["observadas"]++;
                }
                $arrColl[$indice]["total"]++;
            }else{
                $totalNulos++;
            }

        }

        $request->session()->put('items', $arrColl);

        return $this->getMenu($request);

    }




}
