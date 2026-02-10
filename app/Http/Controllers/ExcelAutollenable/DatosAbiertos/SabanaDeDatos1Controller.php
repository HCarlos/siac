<?php
/*
 * Copyright (c) 2026. Realizado por Carlos Hidalgo
 */

namespace App\Http\Controllers\ExcelAutollenable\DatosAbiertos;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ExcelAutollenable\ReporteDiario;
use App\Http\Controllers\ExcelAutollenable\ReporteDiario\ReporteDiarioNov2Class;
use App\Http\Controllers\Funciones\LoadTemplateExcel;
use App\Models\Catalogos\Dependencia;
use App\Models\Denuncias\_viDDSs;
use App\Models\Denuncias\_viDDSS_Viejitas;
use App\Models\Denuncias\_viDepDenServEstatus;
use App\Models\Denuncias\_viMovSM;
use App\Models\Denuncias\Denuncia_Dependencia_Servicio;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class SabanaDeDatos1Controller extends Controller{


    public $vectorServicios;
    protected $ServiciosPrincipales;
    protected $vectorOrigenes;

    protected $arrayOrigenes;

    protected $start_date;
    protected $end_date;
    protected $fecha_desde;

    protected $output;

    protected $denuncias_ids;

    protected $arrItems;

    protected $unidades;

    public function __construct(){
        $this->middleware('auth');
        $this->output = "nada_";

        $this->vectorServicios = collect([
            ['sue_id' => 476, 'Servicio' => 'FUGA DE AGUA', 'R' => 0, 'A' => 0, "PROM_PEN" => 0, "DIAS_PEN" => 0, "PROM_ATE" => 0, "DIAS_ATE" => 0, "LLAMADAS" => 0, "TOTAL" => 0, "DIAS_PEN_DEL" => 0, "DIAS_ATE_DEL" => 0, "DIAS_PEN_INS" => 0, "DIAS_ATE_INS" => 0],
            ['sue_id' => 508, 'Servicio' => 'DESAZOLVE DE DRENAJE', 'R' => 0, 'A' => 0, "PROM_PEN" => 0, "DIAS_PEN" => 0, "PROM_ATE" => 0, "DIAS_ATE" => 0, "LLAMADAS" => 0, "TOTAL" => 0, "DIAS_PEN_DEL" => 0, "DIAS_ATE_DEL" => 0, "DIAS_PEN_INS" => 0, "DIAS_ATE_INS" => 0],
            ['sue_id' => 479, 'Servicio' => 'ALCANTARILLA', 'R' => 0, 'A' => 0, "PROM_PEN" => 0, "DIAS_PEN" => 0, "PROM_ATE" => 0, "DIAS_ATE" => 0, "LLAMADAS" => 0, "TOTAL" => 0, "DIAS_PEN_DEL" => 0, "DIAS_ATE_DEL" => 0, "DIAS_PEN_INS" => 0, "DIAS_ATE_INS" => 0],
            ['sue_id' => 483, 'Servicio' => 'BACHEO', 'R' => 0, 'A' => 0, "PROM_PEN" => 0, "DIAS_PEN" => 0, "PROM_ATE" => 0, "DIAS_ATE" => 0, "LLAMADAS" => 0, "TOTAL" => 0, "DIAS_PEN_DEL" => 0, "DIAS_ATE_DEL" => 0, "DIAS_PEN_INS" => 0, "DIAS_ATE_INS" => 0],
            ['sue_id' => 466, 'Servicio' => 'LUMINARIAS', 'R' => 0, 'A' => 0, "PROM_PEN" => 0, "DIAS_PEN" => 0, "PROM_ATE" => 0, "DIAS_ATE" => 0, "LLAMADAS" => 0, "TOTAL" => 0, "DIAS_PEN_DEL" => 0, "DIAS_ATE_DEL" => 0, "DIAS_PEN_INS" => 0, "DIAS_ATE_INS" => 0],
            ['sue_id' => 503, 'Servicio' => 'RECOLECCIÓN DE RESIDUOS SÓLIDOS', 'R' => 0, 'A' => 0, "PROM_PEN" => 0, "DIAS_PEN" => 0, "PROM_ATE" => 0, "DIAS_ATE" => 0, "LLAMADAS" => 0, "TOTAL" => 0, "DIAS_PEN_DEL" => 0, "DIAS_ATE_DEL" => 0, "DIAS_PEN_INS" => 0, "DIAS_ATE_INS" => 0],
        ]);

        $this->ServiciosPrincipales = [476, 508, 479, 483, 466, 503];

        $this->unidades = [47,48,50,46,49];

        $this->vectorOrigenes = collect([
            ['origen_id' => 29, 'Origen' => 'ATENCION DIRECTA SAS', 'T' => 0],
            ['origen_id' => 27, 'Origen' => 'TELEFONO SAS', 'T' => 0],
            ['origen_id' => 25, 'Origen' => 'VENTANILLA CMSM', 'T' => 0],
            ['origen_id' => 28, 'Origen' => 'TELEFONO 072', 'T' => 0],
            ['origen_id' => 3,  'Origen' => 'TELEREPORTAJE', 'T' => 0],
        ]);
        $this->arrayOrigenes = [29,27,25,28,3];

        // Asegurar que estas propiedades sean colecciones
        $this->arrCoorDR             = collect([]); // Inicializar con tus valores reales


    }

    public function SabanaDeDatos(Request $request){
        ini_set('max_execution_time', 90000);

        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $this->start_date = $start_date. " 00:00:00";
        $this->end_date = $end_date. " 23:59:59";
        $this->fecha_desde = "2025-11-19 00:00:00";
        $this->arrItems = [];

        $C0 = 6;
        $C = $C0;

        try {

            $this->obtenerSabanaDeDatosSoloIDs(0);

            $Items = _viDDSs::whereIn('id', $this->denuncias_ids)
                ->orderByDesc('id')
                ->get();
            if ($Items->count() > 0) {
                $last_value = 0;
                $arrIDs = [];
                foreach ($Items as $item) {
                    if ($item->id !== $last_value) {
                        $arrIDs[] = $item->id;
                        $last_value = $item->id;
                    }
                }
            }else{
                return false;
            }

            $Items = _viDDSs::whereIn('id', $arrIDs)
                ->orderByDesc('id')
                ->get();

            $file_external = "fmt_datos_abiertos_sm_01.xlsx";
            $arrFE = explode('.',$file_external);
            $newFileName = 'datos_abiertos_sm_01_' . Carbon::parse($start_date)->format('dmY') .'_'.Carbon::parse($end_date)->format('dmY'). '.xlsx';
            $this->output   = $newFileName;
            $extension = Str::ucfirst($arrFE[1]);
            $archivo =  LoadTemplateExcel::getFileTemplate($file_external);
            $reader = IOFactory::createReader($extension);
            $spreadsheet = $reader->load($archivo);

            $sh = $spreadsheet->setActiveSheetIndex(0);

            $this->Sabana($C, $C0, $sh, $Items);


            $ws = 1;
            for($i=0, $iMax = count($this->unidades); $i< $iMax; $i++){
                $C = 7;
                $sh = $spreadsheet->setActiveSheetIndex($ws);
                $sh->setCellValue('I2', Carbon::now()->format('d-m-Y h:m:s'));
                $sh->setCellValue('C1', "RANGO DE CONSULTA:");
                $sh->setCellValue('D1', "DEL ".$this->start_date." AL ".$this->end_date);

                $filters = array_values(array_filter($this->arrItems, function ($item) use ($i) {
                    return isset($item['due_id']) && (int)$item['due_id'] === $this->unidades[$i];
                }));
                $Total = 0;
                foreach ($filters as $item){
                    $sh
                        ->setCellValue('A' . $C, $item["servicio"] ?? 0)
                        ->setCellValue('B' . $C, $item["ultimo_estatus"][0]['Total'] ?? 0)
                        ->setCellValue('C' . $C, $item["ultimo_estatus"][1]['Total'] ?? 0)
                        ->setCellValue('D' . $C, $item["ultimo_estatus"][2]['Total'] ?? 0)
                        ->setCellValue('E' . $C, $item["ultimo_estatus"][3]['Total'] ?? 0)
                        ->setCellValue('F' . $C, $item["ultimo_estatus"][4]['Total'] ?? 0)
                        ->setCellValue('G' . $C, $item["ultimo_estatus"][5]['Total'] ?? 0)
                        ->setCellValue('H' . $C, $item["ultimo_estatus"][6]['Total'] ?? 0)
                        ->setCellValue('I' . $C, $item["ultimo_estatus"][7]['Total'] ?? 0);

                    if ($item["is_visible_nombre_corto_ss"]){
                        $sh
                            ->getStyle('A'.$C.':I'.$C)
                            ->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setRGB('FFFF9E'); // 255,255,158

                    }


                    $Total += $item["ultimo_estatus"][7]['Total'];
                    $C++;

                }
                $sh
                    ->setCellValue('H' . $C, "Total")
                    ->setCellValue('I' . $C, $Total ?? 0);

                $ws++;

            }

            for($i=0, $iMax = count($this->unidades); $i< $iMax; $i++){
                $C = 7;
                $sh = $spreadsheet->setActiveSheetIndex($ws);
                $sh->setCellValue('I2', Carbon::now()->format('d-m-Y h:m:s'));
                $sh->setCellValue('C1', "RANGO DE CONSULTA:");
                $sh->setCellValue('D1', "DEL ".$this->start_date." AL ".$this->end_date);

                $filters = array_values(array_filter($this->arrItems, function ($item) use ($i) {
                    return isset($item['due_id']) && (int)$item['due_id'] === $this->unidades[$i];
                }));
                $Total = 0;
                foreach ($filters as $item){
                    $sh
                        ->setCellValue('A' . $C, $item["servicio"] ?? 0)
                        ->setCellValue('B' . $C, $item["ultimo_estatus_compacto"][0]['Total'] ?? 0)
                        ->setCellValue('C' . $C, $item["ultimo_estatus_compacto"][1]['Total'] ?? 0)
                        ->setCellValue('D' . $C, $item["ultimo_estatus_compacto"][2]['Total'] ?? 0)
                        ->setCellValue('E' . $C, $item["ultimo_estatus_compacto"][3]['Total'] ?? 0)
                        ->setCellValue('F' . $C, $item["ultimo_estatus_compacto"][4]['Total'] ?? 0);

                    if ($item["is_visible_nombre_corto_ss"]){
                        $sh
                            ->getStyle('A'.$C.':F'.$C)->applyFromArray([
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['rgb' => 'FFFF9E'],
                            ],
                        ]);
                    }

                    $Total += $item["ultimo_estatus_compacto"][4]['Total'];
                    $C++;

                }
                $sh
                    ->setCellValue('E' . $C, "Total")
                    ->setCellValue('F' . $C, $Total ?? 0);

                $ws++;

            }

            $sh = $spreadsheet->setActiveSheetIndex(0);



            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$this->output.'"');
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            header('Cache-Control: cache, must-revalidate');
            header('Pragma: public');
            $writer = IOFactory::createWriter($spreadsheet, $extension);
            $writer->save('php://output');

            exit;


        } catch (Exception $e) {
            echo 'Ocurrio un error al intentar abrir el archivo ' . $e;
        }


    }


    public function Sabana($C, $C0, $sh, $Items){

        $sh->setCellValue('S2', Carbon::now()->format('d-m-Y h:m:s'));
        $sh->setCellValue('C1', "RANGO DE CONSULTA:");
        $sh->setCellValue('D1', "DEL ".$this->start_date." AL ".$this->end_date);

        $arrItemsBySue = [];
        $estatusTemplate = [
            16 => ["ue_id" => 16, "Estatus"=> "RECIBIDA",            "Total"=> 0],
            17 => ["ue_id" => 17, "Estatus"=> "ATENDIDA",            "Total"=> 0],
            18 => ["ue_id" => 18, "Estatus"=> "OBSERVADA",           "Total"=> 0],
            19 => ["ue_id" => 19, "Estatus"=> "EN PROCESO",          "Total"=> 0],
            20 => ["ue_id" => 20, "Estatus"=> "RECHAZADA",           "Total"=> 0],
            21 => ["ue_id" => 21, "Estatus"=> "CERRADA",             "Total"=> 0],
            22 => ["ue_id" => 22, "Estatus"=> "CERRADO POR RECHAZO", "Total"=> 0],
            99 => ["ue_id" => 99, "Estatus"=> "TOTAL",               "Total"=> 0],
        ];

        $estatusCompactTemplate = [
            0  => ["Estatus"=> "ATENDIDA",   "Total"=> 0],
            1  => ["Estatus"=> "OBSERVADA",  "Total"=> 0],
            2  => ["Estatus"=> "PENDIENTES", "Total"=> 0],
            3  => ["Estatus"=> "RECHAZADO",  "Total"=> 0],
            99 => ["Estatus"=> "TOTAL",      "Total"=> 0],
        ];

// Resumen compacto GLOBAL
        $arrCompactGlobal = $estatusCompactTemplate;


        foreach ($Items as $item) {

            $fechaIngreso = Carbon::parse($item->fecha_ingreso)->format('d-m-Y');
            $fechaIngreso = isset($item->fecha_ingreso) ? $fechaIngreso : '';

            $Colonia = $item->centro_colonia ?? ''; // $item->centroLocalidad->ItemColonia() ?? '';
            $Delegacion = $item->centro_delegacion ?? '';
            $Delegado = $item->delegado ?? '';
            $Ciudadano = $item->ciudadano ?? '';

            $dds = Denuncia_Dependencia_Servicio::query()
                ->where('denuncia_id', $item->id)
            ->where('dependencia_id', $item->due_id)
            ->where('servicio_id', $item->sue_id)
            ->where('estatu_id', $item->ue_id)
                ->orderByDesc('id')
            ->first();

            $sh
                ->setCellValue('A' . $C, $item->id ?? 0)
                ->setCellValue('B' . $C, trim($item->username ?? ''))
                ->setCellValue('C' . $C, trim($item->ap_paterno_ciudadano ?? ''))
                ->setCellValue('D' . $C, trim($item->ap_materno_ciudadano ?? ''))
                ->setCellValue('E' . $C, trim($item->nombre_ciudadano ?? ''))
                ->setCellValue('F' . $C, strtoupper(trim($item->search_google)) ?? '')
                ->setCellValue('G' . $C, $Colonia ?? '')
                ->setCellValue('H' . $C, $Delegacion ?? '')
                ->setCellValue('I' . $C, $Ciudadano == $Delegado ? "Es el delegado" : '')
                ->setCellValue('J' . $C, $item->telefonoscelularesemails ?? '')
                ->setCellValue('K' . $C, $fechaIngreso ?? '')
                ->setCellValue('L' . $C, $item->dependencia_ultimo_estatus ?? '')
                ->setCellValue('M' . $C, $item->servicio_ultimo_estatus ?? '')
                ->setCellValue('N' . $C, ($item->denuncia.' '.$item->referencia) ?? '')
                ->setCellValue('O' . $C, $item->prioridad ?? '')
                ->setCellValue('P' . $C, $item->origen ?? '')
                ->setCellValue('Q' . $C, $item->ultimo_estatus ?? '')
                ->setCellValue('R' . $C, Carbon::parse($item->fecha_ultimo_estatus)->format('d-m-Y') ?? '')
                ->setCellValue('S' . $C, $dds->observaciones ?? '');

//            if ($item->is_visible_nombre_corto_ss){
//                $sh
//                    ->getStyle('A' . $C . ':S' . $C)
//                    ->getFill()
//                    ->applyFromArray([
//                        'fillType' => 'solid',
//                        'rotation' => 0,
//                        'color' => ['rgb' => 'yellow'],
//                    ]);
//            }

            $C++;

            $dueId = (int) $item->due_id;
            $sueId = (int) $item->sue_id;
            $ueId  = (int) $item->ue_id; // el ue_id que corresponde sumar

            // Si no existe el sue_id, lo creamos con plantilla
            if (!isset($arrItemsBySue[$sueId])) {
                $arrItemsBySue[$sueId] = [
                    "due_id" => $dueId,
                    "unidad" => (string) ($item->dependencia_ultimo_estatus ?? ''), // ajusta al nombre real
                    "sue_id" => $sueId,
                    "servicio" => (string) ($item->servicio_ultimo_estatus ?? ''), // ajusta al nombre real
                    "ultimo_estatus" => $estatusTemplate, // OJO: queda indexado por ue_id
                    "ultimo_estatus_compacto" => $estatusCompactTemplate,
                    "is_visible_nombre_corto_ss" => $item->is_visible_nombre_corto_ss ?? false,
                ];
            }

            // Incrementa el Total del ue_id que corresponda
            // 1) Incremento normal (por ue_id)
            if (isset($arrItemsBySue[$sueId]["ultimo_estatus"][$ueId])) {
                $arrItemsBySue[$sueId]["ultimo_estatus"][$ueId]["Total"] += 1;
            } else {
                $arrItemsBySue[$sueId]["ultimo_estatus"][$ueId] = [
                    "ue_id" => $ueId,
                    "Estatus" => "DESCONOCIDO",
                    "Total" => 1,
                ];
            }
            $arrItemsBySue[$sueId]["ultimo_estatus"][99]["Total"] += 1;

            $ueToCompact = [
                17 => 0, 21 => 0, // ATENDIDA
                18 => 1,          // OBSERVADA
                16 => 2, 19 => 2, // PENDIENTES
                20 => 3, 22 => 3, // RECHAZADO
            ];

            $compactKey = $ueToCompact[$ueId] ?? null;

            if ($compactKey !== null) {
                // Por servicio (sue_id)
                $arrItemsBySue[$sueId]["ultimo_estatus_compacto"][$compactKey]["Total"] += 1;
                $arrItemsBySue[$sueId]["ultimo_estatus_compacto"][99]["Total"] += 1;

                // Global
                $arrCompactGlobal[$compactKey]["Total"] += 1;
                $arrCompactGlobal[99]["Total"] += 1;
            }


        }

        $arrItems = array_values(array_map(function ($it) {
            $it["ultimo_estatus"] = array_values($it["ultimo_estatus"]);
            $it["ultimo_estatus_compacto"] = array_values($it["ultimo_estatus_compacto"]);
            return $it;
        }, $arrItemsBySue));

        usort($arrItems, function ($a, $b) {
            $sa = trim($a['servicio'] ?? '');
            $sb = trim($b['servicio'] ?? '');

            $cmp = strcasecmp($sa, $sb); // ignora mayúsculas/minúsculas
            if ($cmp !== 0) return $cmp;

            // desempate (opcional) por sue_id
            return ($a['sue_id'] ?? 0) <=> ($b['sue_id'] ?? 0);
        });

        $arrItems[] = [
            "tipo" => "RESUMEN_COMPACTO_GLOBAL",
            "ultimo_estatus_compacto" => array_values($arrCompactGlobal),
        ];

//        dd($arrItems);
//
        $this->arrItems = $arrItems;

        $Cx = $C  - 1;
        $oVal = $sh->getCell('G1')->getValue();
        $sh->setCellValue('B'.$C, 'TOTAL DE REGISTROS')
            ->setCellValue('C'.$C, '=COUNT(A'.$C0.':A'.$Cx.')')
            ->setCellValue('G'.$C, $oVal);

        $sh->getStyle('A'.$C0.':AZ'.$C)->getFont()
            ->setName('Arial')
            ->setSize(8);

        $sh->getStyle('A'.$C.':AZ'.$C)->getFont()->setBold(true);


    }


    function obtenerSabanaDeDatosSoloIDs($type){

        switch ($type) {
            case 0:
//                $this->denuncias_ids = DB::table("_vimov_filter_sm")
//                    ->whereIn('servicio_id', $this->ServiciosPrincipales)
//                    ->where('fecha_ingreso', '>=', $this->start_date)
//                    ->where('fecha_ingreso', '<=', $this->end_date)
//                    ->orderByDesc('denuncia_id')
//                    ->pluck('denuncia_id')
//                    ->toArray();

//                dd($this->start_date);

                $this->denuncias_ids = DB::table("_videnuncias")
                    ->where('ambito_dependencia', 2)
                    ->whereBetween('fecha_ingreso',  [$this->start_date,$this->end_date])
                    ->orderByDesc('id')
                    ->pluck('id')
                    ->toArray();

                return $this->denuncias_ids;
        }

    }














}
