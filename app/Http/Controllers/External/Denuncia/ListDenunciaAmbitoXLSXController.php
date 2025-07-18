<?php

namespace App\Http\Controllers\External\Denuncia;

use App\Classes\Denuncia\ActualizaEstadisticasARO;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\Catalogos\CentroLocalidad;
use App\Models\Catalogos\Dependencia;
use App\Models\Catalogos\Estatu;
use App\Models\Catalogos\Servicio;
use App\Models\Denuncias\_viDDSs;
use App\Models\Denuncias\_viDepDenServEstatus;
use App\Models\Denuncias\_viMovimientos;
use App\Models\Denuncias\_viMovSM;
use App\Models\Denuncias\Denuncia;
use App\Models\Denuncias\Denuncia_Dependencia_Servicio;
use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Http\Request;


use App\Http\Controllers\Funciones\LoadTemplateExcel;
use App\User;
use Carbon\Carbon;
use Exception;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\StreamedResponse;


class ListDenunciaAmbitoXLSXController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }


    public function getListDenunciaAmbitoXLSX(Request $request){
        ini_set('max_execution_time', 90000);
            $Items = $request->session()->get('items');

        $C0 = 6;
        $C = $C0;

        try {

            $data =  $request->only(['fileoutput','indice']);
            $file_external =  $data["fileoutput"];
            $indice = (int) $data["indice"];

//            dd($indice);

            $arrFE = explode('.',$file_external);
            $extension = Str::ucfirst($arrFE[1]);

            $archivo =  LoadTemplateExcel::getFileTemplate($file_external);
            $reader = IOFactory::createReader($extension);
            $spreadsheet = $reader->load($archivo);
            $sh = $spreadsheet->setActiveSheetIndex(0);

//            dd($indice);

            switch ($indice){
                case 0:
                    $this->denunciaGeneral01($C, $C0, $sh, $Items, $arrFE, $spreadsheet, $archivo, $extension);
                    break;
                case 1:
                    $this->denunciaSASGeneral01($C, $C0, $sh, $Items, $arrFE, $spreadsheet, $archivo, $extension);
                    break;
                case 2:
                    $this->denunciaGeneralMap02($C, $C0, $sh, $Items, $arrFE, $spreadsheet, $archivo, $extension);
                    break;
                case 3:
                    $this->denunciaGeneralMap03($C, $C0, $sh, $Items, $arrFE, $spreadsheet, $archivo, $extension);
                    break;
            }

        } catch (Exception $e) {
            echo 'Ocurrio un error al intentar abrir el archivo ' . $e;
        }

    }

    // Denuncia General Formato 01
    public function denunciaGeneral01($C, $C0, $sh, $Items, $arrFE, $spreadsheet, $archivo, $extension){

        $sh->setCellValue('w1', Carbon::now()->format('d-m-Y h:i:s'));
        foreach ($Items as $item){
//            dd($item);
            $fechaIngreso   = Carbon::parse($item->fecha_ingreso)->format('d-m-Y');
            $fechaIngreso   = isset($item->fecha_ingreso) ? $fechaIngreso : '';

            $Colonia = "";
            $Delegacion = "";
            $CenLoc       = $item->centro_localidad_id;
            if ($CenLoc != null || $CenLoc != "" || $CenLoc != 0){
                $Loc = CentroLocalidad::find($CenLoc);
                $Colonia = $Loc->ItemColonia();
                $Delegacion = $Loc->ItemDelegacion();
            }

            $resp = Denuncia_Dependencia_Servicio::query()
                    ->select(['id','observaciones','dependencia_id','favorable','denuncia_id'])
                    ->where('denuncia_id',$item->id)
                    ->orderByDesc('id')
                    ->first();

            $respuesta = "";
            try{
                if ( $resp->observaciones !== null){
                    $res = trim($resp->observaciones) ?? '';
                    if ( $res != ""){
                        $dep = Dependencia::find($resp->dependencia_id);
                        $respuesta = $dep->abreviatura.' - '.$res.'. ';
                    }
                }else{
                    $respuesta = '';
                }
            }catch (Exception $e) {
                $respuesta = '';
            }


            foreach ($item->ciudadanos as $cds){


                $telcel = $cds->telefonos. '; '. $cds->celulares. '; '. $cds->email;
                $telcel = explode(';',$telcel);

                $cadcel = '';
                for ($i = 0; $i < count($telcel) - 1;  $i++) {
                    if ($cadcel === ''){
                        $cadcel .= trim($telcel[$i]);
                    }else if ( trim($telcel[$i]) !== '' ){
                        $cadcel .= ', ' . trim($telcel[$i]);
                    }else{
                        $cadcel .= '';
                    }
                }

//                $atendidas = 0;
//                $pendientes = 0;
//                if ( in_array( ((int) $item->estatu_id),array(17,20,21,22) )){
//                    $atendidas = 1;
//                }else{
//                    $pendientes = 1;
//                }

                $atendidas = 0;
                $rechazadas = 0;
                $pendientes = 0;
                $observadas = 0;
                if (in_array(((int)$item->ue_id), array(17, 21))) {
                    $atendidas = 1;
                }
                if (in_array(((int)$item->ue_id), array(20, 22))) {
                    $rechazadas = 1;
                }
                if (in_array(((int)$item->ue_id), array(16, 19))) {
                    $pendientes = 1;
                }
                if (((int)$item->ue_id) === 18) {
                    $observadas = 1;
                }

                $gdu = explode(',',trim($item->gd_ubicacion));
                $cadgdu = $gdu[1] ?? '';


                $sh
                    ->setCellValue('A'.$C, $item->id ?? 0)
                    ->setCellValue('B'.$C, trim($cds->username ?? ''))
                    ->setCellValue('C'.$C, trim($cds->ap_paterno ?? ''))
                    ->setCellValue('D'.$C, trim($cds->ap_materno ?? ''))
                    ->setCellValue('E'.$C, trim($cds->nombre ?? ''))

                    ->setCellValue('F'.$C, strtoupper(trim($item->search_google)) ?? '' )
                    ->setCellValue('G'.$C, $Colonia ?? '')
                    ->setCellValue('H'.$C, $Delegacion ?? '')

                    ->setCellValue('I'.$C, $cadcel ?? '')
                    ->setCellValue('J'.$C, $fechaIngreso ?? '')
                    ->setCellValue('K'.$C, $item->dependencia ?? '')
                    ->setCellValue('L'.$C, $item->servicio ?? '')

                    ->setCellValue('M'.$C, $item->descripcion ?? '')

                    ->setCellValue('N'.$C, $item->prioridad->prioridad ?? '')
                    ->setCellValue('O'.$C, $item->origen->origen ?? '')
                    ->setCellValue('P'.$C, $item->estatus ?? '')
                    ->setCellValue('Q'.$C, Carbon::parse($item->fecha_movimiento)->format('d-m-Y') ?? '')
                    ->setCellValue('R'.$C, $item->observaciones )
                    ->setCellValue('S'.$C, $this->getColorSemaforo($item)['status'])
                    ->setCellValue('T'.$C, $item->dias_atendida ?? '' )
                    ->setCellValue('U'.$C, $item->dias_rechazada ?? '' )
                    ->setCellValue('V'.$C, $atendidas  )
                    ->setCellValue('W'.$C, $rechazadas  )
                    ->setCellValue('X'.$C, $pendientes  )
                    ->setCellValue('Y'.$C, $observadas  );

                $sh
                    ->getStyle('A'.$C.':Y'.$C)
                    ->getFill()
                    ->applyFromArray([
                            'fillType' => 'solid',
                            'rotation' => 0,
                            'color' => ['rgb' => $this->getColorSemaforo($item)['status_i']],
                            ]);

                $C++;

            }
        }


        $Cx = $C  - 1;
        $oVal = $sh->getCell('G1')->getValue();
        $sh->setCellValue('B'.$C, 'TOTAL DE REGISTROS')
            ->setCellValue('C'.$C, '=COUNT(A'.$C0.':A'.$Cx.')')
            ->setCellValue('G'.$C, $oVal);

        $sh->getStyle('A'.$C0.':G'.$C)->getFont()
            ->setName('Arial')
            ->setSize(8);

        $sh->getStyle('A'.$C.':G'.$C)->getFont()->setBold(true);

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





    // Denuncia General Formato 01
    public function denunciaSASGeneral01($C, $C0, $sh, $Items, $arrFE, $spreadsheet, $archivo, $extension){

        $sh->setCellValue('L1', Carbon::now()->format('d-m-Y H:i:s'));
        foreach ($Items as $item) {
            $fechaIngreso = Carbon::parse($item->fecha_ingreso)->format('d-m-Y H:i:s');
            $fechaIngreso = isset($item->fecha_ingreso) ? $fechaIngreso : '';

            $resp = Denuncia_Dependencia_Servicio::query()
                ->select(['id', 'observaciones', 'dependencia_id', 'favorable', 'denuncia_id'])
                ->where('denuncia_id', $item->id)
                ->orderByDesc('id')
                ->first();

            $Colonia = "";
            $Delegacion = "";
            $CenLoc       = $item->centro_localidad_id;
            if ($CenLoc != null || $CenLoc != "" || $CenLoc != 0){
                $Loc = CentroLocalidad::find($CenLoc);
                $Colonia = $Loc->ItemColonia();
                $Delegacion = $Loc->ItemDelegacion();
            }

                $cadcel = $item->telefonoscelularesemails;


                $gdu = explode(',', trim($item->gd_ubicacion));

                $sh
                    ->setCellValue('A' . $C, $item->id ?? 0)
                    ->setCellValue('B' . $C, trim($item->servicio ?? ''))
                    ->setCellValue('C' . $C, $fechaIngreso ?? '')
                    ->setCellValue('D' . $C, trim($item->ciudadano ?? ''))
                    ->setCellValue('E' . $C, $cadcel)
                    ->setCellValue('F' . $C, trim($item->search_google ?? ''))
                    ->setCellValue('G' . $C, trim($Colonia ?? ''))
                    ->setCellValue('H' . $C, trim($Delegacion ?? ''))
                    ->setCellValue('I' . $C, $item->descripcion ?? '')
                    ->setCellValue('J' . $C, $item->Ambito() ?? '')
                    ->setCellValue('K' . $C, $item->estatus ?? '')
                    ->setCellValue('L' . $C, Carbon::parse($item->fecha_movimiento)->format('d-m-Y H:i:s') ?? '');
                $C++;
//            }
        }

        $Cx = $C  - 1;
        $oVal = $sh->getCell('I1')->getValue();
        $sh->setCellValue('B'.$C, 'TOTAL DE REGISTROS')
            ->setCellValue('C'.$C, '=COUNT(A'.$C0.':A'.$Cx.')')
            ->setCellValue('L'.$C, $oVal);

        $sh->getStyle('A'.$C0.':L'.$C)->getFont()
            ->setName('Arial')
            ->setSize(8);

        $sh->getStyle('A'.$C.':L'.$C)->getFont()->setBold(true);

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









    public function showDataListDenunciaAmbitoRespuestaExcel1A(Request $request){
        ini_set('max_execution_time', 72000);
//        $data = $request->only(['search','items']);
        $Items = $request->session()->get('items');

        $C0 = 7;
        $C = $C0;

        try {
            $file_external = trim(config("atemun.archivos.fmt_lista_respuestas"));
            //dd($file_external);
            $arrFE = explode('.',$file_external);
            $extension = Str::ucfirst($arrFE[1]);

            $archivo =  LoadTemplateExcel::getFileTemplate($file_external);
            $reader = IOFactory::createReader($extension);
            $spreadsheet = $reader->load($archivo);
            $sh = $spreadsheet->setActiveSheetIndex(0);

            $sh->setCellValue('H1', Carbon::now()->format('d-m-Y h:i:s'));
            foreach ($Items as $item){

//                dd($item);

                $Id               = $item->id;
                $denuncia_id      = $item->denuncia_id;
                $dependencia_id   = $item->dependencia_id;
                $servicio_id      = $item->servicio_id;
                $estatu_id        = $item->estatu_id;
                $fecha_movimiento = $item->fecha_movimiento;
                $respuesta        = $item->observaciones;

                $Denuncia    = Denuncia::find($denuncia_id);
                $Dependencia = Dependencia::find($dependencia_id);
                $Servicio    = Servicio::find($servicio_id);
                $Estatus     = Estatu::find($estatu_id);

                $sh
                    ->setCellValue('A'.$C, $item->id)
                    ->setCellValue('B'.$C, trim($Dependencia->dependencia))
                    ->setCellValue('C'.$C, trim($Servicio->servicio))
                    ->setCellValue('D'.$C, trim($Estatus->estatus))
                    ->setCellValue('E'.$C, trim($Denuncia->descripcion))
                    ->setCellValue('F'.$C, trim($Denuncia->referencia))
                    ->setCellValue('G'.$C, trim($respuesta))
                    ->setCellValue('H'.$C,  date('d-m-Y H:i:s', strtotime($fecha_movimiento)) );

                $C++;
            }
            $Cx = $C  - 1;
//            $oVal = $sh->getCell('G1')->getValue();
            $sh->setCellValue('B'.$C, 'TOTAL DE REGISTROS')
                ->setCellValue('C'.$C, '=COUNT(A'.$C0.':A'.$Cx.')');
//                ->setCellValue('G'.$C, $oVal);

            $sh->getStyle('A'.$C0.':G'.$C)->getFont()
                ->setName('Arial')
                ->setSize(8);

            $sh->getStyle('A'.$C.':G'.$C)->getFont()->setBold(true);

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

        } catch (Exception $e) {
            echo 'Ocurrio un error al intentar abrir el archivo ' . $e;
        }



    }



    function getColorSemaforo($g){

        $fecha_menor = new DateTime($g->fecha_ingreso);
        $fecha_mayor = new DateTime($g->fecha_movimiento);

        return ActualizaEstadisticasARO::semaforo_ultimo_estatus_off($g->estatu_id, $fecha_mayor, $fecha_menor);

    }



    public function denunciaGeneralMap02($C, $C0, $sh, $Items, $arrFE, $spreadsheet, $archivo, $extension){

        $sh->setCellValue('w1', Carbon::now()->format('d-m-Y h:i:s'));


        foreach ($Items as $item){

            $fechaIngreso = Carbon::parse($item->fecha_ingreso)->format('d-m-Y');
            $fechaIngreso = isset($item->fecha_ingreso) ? $fechaIngreso : '';

            $Colonia = "";
            $Delegacion = "";
//            $CenLoc = $item->centro_localidad_id;
//            if ($CenLoc != null || $CenLoc != "" || $CenLoc != 0) {
//                $Loc = CentroLocalidad::find($CenLoc);
                $Colonia = $item->centroLocalidad->ItemColonia() ?? '';
                $Delegacion = $item->centroLocalidad->ItemDelegacion() ?? '';
//            }

//            $atendidas = 0;
//            $rechazadas = 0;
//            $pendientes = 0;
//            $observadas = 0;
//            if (in_array(((int)$item->ue_id), array(17, 21))) {
//                $atendidas = 1;
//            }
//            if (in_array(((int)$item->ue_id), array(20, 22))) {
//                $rechazadas = 1;
//            }
//            if (in_array(((int)$item->ue_id), array(16, 19))) {
//                $pendientes = 1;
//            }
//            if (((int)$item->ue_id) === 18) {
//                $observadas = 1;
//            }

            $estados = [
                'atendidas' => [17, 21],
                'rechazadas' => [20, 22],
                'pendientes' => [16, 19],
                'observadas' => [18]
            ];
            $atendidas = in_array($item->ue_id, $estados['atendidas']) ? 1 : 0;
            $rechazadas = in_array($item->ue_id, $estados['rechazadas']) ? 1 : 0;
            $pendientes = in_array($item->ue_id, $estados['pendientes']) ? 1 : 0;
            $observadas = in_array($item->ue_id, $estados['observadas']) ? 1 : 0;


            $sem = $this->getColorSemaforo($item);

            $sh
                ->setCellValue('A' . $C, $item->denuncia_id ?? 0)
                ->setCellValue('B' . $C, trim($item->username_ciudadano ?? ''))
                ->setCellValue('C' . $C, trim($item->ap_paterno_ciudadano ?? ''))
                ->setCellValue('D' . $C, trim($item->ap_materno_ciudadano ?? ''))
                ->setCellValue('E' . $C, trim($item->nombre_ciudadano ?? ''))
                ->setCellValue('F' . $C, strtoupper(trim($item->search_google)) ?? '')
                ->setCellValue('G' . $C, $Colonia ?? '')
                ->setCellValue('H' . $C, $Delegacion ?? '')
                ->setCellValue('I' . $C, $item->telefonos_ciudadano ?? '')
                ->setCellValue('J' . $C, $fechaIngreso ?? '')
                ->setCellValue('K' . $C, $item->dependencia ?? '')
                ->setCellValue('L' . $C, $item->servicio ?? '')
                ->setCellValue('M' . $C, $item->descripcion ?? '')
                ->setCellValue('N' . $C, $item->prioridad ?? '')
                ->setCellValue('O' . $C, $item->origen ?? '')
                ->setCellValue('P' . $C, $item->estatus ?? '')
                ->setCellValue('Q' . $C, Carbon::parse($item->fecha_ultimo_estatus)->format('d-m-Y') ?? '')
                ->setCellValue('R' . $C, $item->observaciones ?? '')
                ->setCellValue('S' . $C, $sem['status'])
                ->setCellValue('T' . $C, $item->dias_atendida ?? '')
                ->setCellValue('U' . $C, $item->dias_rechazada ?? '')
                ->setCellValue('V' . $C, $atendidas)
                ->setCellValue('W' . $C, $rechazadas)
                ->setCellValue('X' . $C, $pendientes)
                ->setCellValue('Y' . $C, $observadas)

                ->getStyle('A' . $C . ':Y' . $C)
                ->getFill()
                ->applyFromArray([
                    'fillType' => 'solid',
                    'rotation' => 0,
                    'color' => ['rgb' => $sem['status_i']],
                ]);

            $C++;

        }


        $Cx = $C  - 1;
        $oVal = $sh->getCell('G1')->getValue();
        $sh->setCellValue('B'.$C, 'TOTAL DE REGISTROS')
            ->setCellValue('C'.$C, '=COUNT(A'.$C0.':A'.$Cx.')')
            ->setCellValue('G'.$C, $oVal);

        $sh->getStyle('A'.$C0.':G'.$C)->getFont()
            ->setName('Arial')
            ->setSize(8);

        $sh->getStyle('A'.$C.':G'.$C)->getFont()->setBold(true);

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

    public function denunciaGeneralMap03($C, $C0, $sh, $Items, $arrFE, $spreadsheet, $archivo, $extension){

        $sh->setCellValue('w1', Carbon::now()->format('d-m-Y h:i:s'));
        $valInit = $Items[0];
        $dependencia_fly_id = $valInit->dependencia_id;
        foreach ($Items as $item){
//            dd($item);

            if ($item->dependencia_id === $dependencia_fly_id) {
//            dd($item);
                $fechaIngreso = Carbon::parse($item->fecha_ingreso)->format('d-m-Y');
                $fechaIngreso = isset($item->fecha_ingreso) ? $fechaIngreso : '';

                $Colonia = "";
                $Delegacion = "";
//                $CenLoc = $item->centro_localidad_id;
//                if ($CenLoc != null || $CenLoc != "" || $CenLoc != 0) {
//                    $Loc = CentroLocalidad::find($CenLoc);
//                    $Colonia = $Loc->ItemColonia();
//                    $Delegacion = $Loc->ItemDelegacion();
//                }

                $Colonia = $item->centroLocalidad->ItemColonia() ?? '';
                $Delegacion = $item->centroLocalidad->ItemDelegacion() ?? '';

//                $atendidas = 0;
//                $rechazadas = 0;
//                $pendientes = 0;
//                $observadas = 0;
//                if (in_array(((int)$item->ue_id), array(17, 21))) {
//                    $atendidas = 1;
//                }
//                if (in_array(((int)$item->ue_id), array(20, 22))) {
//                    $rechazadas = 1;
//                }
//                if (in_array(((int)$item->ue_id), array(16, 19))) {
//                    $pendientes = 1;
//                }
//                if (((int)$item->ue_id) === 18) {
//                    $observadas = 1;
//                }

                $estados = [
                    'atendidas' => [17, 21],
                    'rechazadas' => [20, 22],
                    'pendientes' => [16, 19],
                    'observadas' => [18]
                ];
                $atendidas = in_array($item->ue_id, $estados['atendidas']) ? 1 : 0;
                $rechazadas = in_array($item->ue_id, $estados['rechazadas']) ? 1 : 0;
                $pendientes = in_array($item->ue_id, $estados['pendientes']) ? 1 : 0;
                $observadas = in_array($item->ue_id, $estados['observadas']) ? 1 : 0;


                $sem = $this->getColorSemaforo($item);

                $sh
                    ->setCellValue('A' . $C, $item->denuncia_id ?? 0)
                    ->setCellValue('B' . $C, trim($item->username_ciudadano ?? ''))
                    ->setCellValue('C' . $C, trim($item->ap_paterno_ciudadano ?? ''))
                    ->setCellValue('D' . $C, trim($item->ap_materno_ciudadano ?? ''))
                    ->setCellValue('E' . $C, trim($item->nombre_ciudadano ?? ''))
                    ->setCellValue('F' . $C, strtoupper(trim($item->search_google)) ?? '')
                    ->setCellValue('G' . $C, $Colonia ?? '')
                    ->setCellValue('H' . $C, $Delegacion ?? '')
                    ->setCellValue('I' . $C, $item->telefonos_ciudadano ?? '')
                    ->setCellValue('J' . $C, $fechaIngreso ?? '')
                    ->setCellValue('K' . $C, $item->dependencia ?? '')
                    ->setCellValue('L' . $C, $item->servicio ?? '')
                    ->setCellValue('M' . $C, $item->descripcion ?? '')
                    ->setCellValue('N' . $C, $item->prioridad ?? '')
                    ->setCellValue('O' . $C, $item->origen ?? '')
                    ->setCellValue('P' . $C, $item->estatus ?? '')
                    ->setCellValue('Q' . $C, Carbon::parse($item->fecha_movimiento)->format('d-m-Y') ?? '')
                    ->setCellValue('R' . $C, $item->observaciones ?? '')
                    ->setCellValue('S' . $C, $sem['status'])
                    ->setCellValue('T' . $C, $item->dias_atendida ?? '')
                    ->setCellValue('U' . $C, $item->dias_rechazada ?? '')
                    ->setCellValue('V' . $C, $atendidas)
                    ->setCellValue('W' . $C, $rechazadas)
                    ->setCellValue('X' . $C, $pendientes)
                    ->setCellValue('Y' . $C, $observadas);

                $sh
                    ->getStyle('A' . $C . ':Y' . $C)
                    ->getFill()
                    ->applyFromArray([
                        'fillType' => 'solid',
                        'rotation' => 0,
                        'color' => ['rgb' => $sem['status_i']],
                    ]);

                $C++;

            }
        }


        $Cx = $C  - 1;
        $oVal = $sh->getCell('G1')->getValue();
        $sh->setCellValue('B'.$C, 'TOTAL DE REGISTROS')
            ->setCellValue('C'.$C, '=COUNT(A'.$C0.':A'.$Cx.')')
            ->setCellValue('G'.$C, $oVal);

        $sh->getStyle('A'.$C0.':G'.$C)->getFont()
            ->setName('Arial')
            ->setSize(8);

        $sh->getStyle('A'.$C.':G'.$C)->getFont()->setBold(true);

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



    function exportDataFilterMap2(Request $request){
        $data = $request->all();

        $ddse_ids = $data['items_ddse'];

        $ids = Str::of($ddse_ids)
            ->explode(',')
            ->map(function ($value) {
                return (int) $value;
            })
            ->toArray();

        $items = _viMovSM::select(
                'id','denuncia_id','descripcion','fecha_dias_ejecucion','fecha_dias_maximos_ejecucion',
                'fecha_ingreso', 'fecha_ultimo_estatus', 'dependencia_id', 'dependencia', 'abreviatura',
                'ue_id', 'sue_id', 'servicio', 'ciudadano', 'centro_localidad_id', 'latitud','longitud',
                'estatus','fecha_ultimo_estatus','fecha_ingreso','fecha_dias_ejecucion', 'fecha_dias_maximos_ejecucion',
                'uuid','fecha_movimiento','estatu_id', 'prioridad', 'origen',
                'username_ciudadano','ap_paterno_ciudadano','ap_materno_ciudadano','nombre_ciudadano','telefonos_ciudadano',
                'observaciones','dias_atendida','dias_rechazada','search_google'
            )
            ->whereIn('id', $ids)
            ->orderByDesc('id')
            ->get();


        $request->session()->put('items', $items);

        return $this->getListDenunciaAmbitoXLSX($request);

    }

    function exportDataFilterMap3(Request $request){
        $data = $request->all();

        $ddse_ids = $data['items_ddse'];

        $ids = Str::of($ddse_ids)
            ->explode(',')
            ->map(function ($value) {
                return (int) $value;
            })
            ->toArray();

        $items = _viMovSM::select(
                'id','denuncia_id','descripcion','fecha_dias_ejecucion','fecha_dias_maximos_ejecucion',
                'fecha_ingreso', 'fecha_ultimo_estatus', 'dependencia_id', 'dependencia', 'abreviatura',
                'ue_id', 'sue_id', 'servicio', 'ciudadano', 'centro_localidad_id', 'latitud','longitud',
                'estatus','fecha_ultimo_estatus','fecha_ingreso','fecha_dias_ejecucion', 'fecha_dias_maximos_ejecucion',
                'uuid','fecha_movimiento','estatu_id', 'prioridad', 'origen',
                'username_ciudadano','ap_paterno_ciudadano','ap_materno_ciudadano','nombre_ciudadano','telefonos_ciudadano',
                'observaciones','dias_atendida','dias_rechazada','search_google'
            )
            ->whereIn('id', $ids)
            ->orderByDesc('id')
            ->get();

        $request->session()->put('items', $items);

        return $this->getListDenunciaAmbitoXLSX($request);

    }










}
