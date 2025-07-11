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



class ListDenunciaAmbitoXLSXController extends Controller
{

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
                case 4:
                    $this->resumenBasico01($C, $C0, $sh, $Items, $arrFE, $spreadsheet, $archivo, $extension);
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


//        dd($Items->count());

        foreach ($Items as $item){

//            dd($item);

            $fechaIngreso = Carbon::parse($item->fecha_ingreso)->format('d-m-Y');
            $fechaIngreso = isset($item->fecha_ingreso) ? $fechaIngreso : '';

            $Colonia = "";
            $Delegacion = "";
            $CenLoc = $item->centro_localidad_id;
            if ($CenLoc != null || $CenLoc != "" || $CenLoc != 0) {
                $Loc = CentroLocalidad::find($CenLoc);
                $Colonia = $Loc->ItemColonia();
                $Delegacion = $Loc->ItemDelegacion();
            }

            $cds = $item->ciudadano_simple;


//            $telcel = $cds->celulares . '; ' . $cds->telefonos;
//            $telcel = explode(';', $telcel);
//
//            $cadcel = '';
//            for ($i = 0; $i < count($telcel) - 1; $i++) {
//                if ($cadcel === '') {
//                    $cadcel .= trim($telcel[$i]);
//                } else if (trim($telcel[$i]) !== '') {
//                    $cadcel .= ', ' . trim($telcel[$i]);
//                } else {
//                    $cadcel .= '';
//                }
//            }

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

            $gdu = explode(',', trim($item->gd_ubicacion));
            $cadgdu = $gdu[1] ?? '';


            $sh
                ->setCellValue('A' . $C, $item->id ?? 0)
                ->setCellValue('B' . $C, trim($item->username ?? ''))
                ->setCellValue('C' . $C, trim($item->ap_paterno_ciudadano ?? ''))
                ->setCellValue('D' . $C, trim($item->ap_materno_ciudadano ?? ''))
                ->setCellValue('E' . $C, trim($item->nombre_ciudadano ?? ''))
                ->setCellValue('F' . $C, strtoupper(trim($item->search_google)) ?? '')
                ->setCellValue('G' . $C, $Colonia ?? '')
                ->setCellValue('H' . $C, $Delegacion ?? '')
                ->setCellValue('I' . $C, $item->telefonoscelularesemails ?? '')
                ->setCellValue('J' . $C, $fechaIngreso ?? '')
                ->setCellValue('K' . $C, $item->dependencia_ultimo_estatus ?? '')
                ->setCellValue('L' . $C, $item->servicio_ultimo_estatus ?? '')
                ->setCellValue('M' . $C, $item->denuncia ?? '')
                ->setCellValue('N' . $C, $item->prioridad ?? '')
                ->setCellValue('O' . $C, $item->origen ?? '')
                ->setCellValue('P' . $C, $item->ultimo_estatus ?? '')
                ->setCellValue('Q' . $C, Carbon::parse($item->fecha_ultimo_estatus)->format('d-m-Y') ?? '')
                ->setCellValue('R' . $C, strtoupper(trim($item->ultima_respuesta)) ?? '')
                ->setCellValue('S' . $C, $this->getColorSemaforo($item)['status'])
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
                    'color' => ['rgb' => $this->getColorSemaforo($item)['status_i']],
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
                $CenLoc = $item->centro_localidad_id;
                if ($CenLoc != null || $CenLoc != "" || $CenLoc != 0) {
                    $Loc = CentroLocalidad::find($CenLoc);
                    $Colonia = $Loc->ItemColonia();
                    $Delegacion = $Loc->ItemDelegacion();
                }

                $resp = Denuncia_Dependencia_Servicio::query()
                    ->select(['id', 'observaciones', 'dependencia_id', 'favorable', 'denuncia_id'])
                    ->where('denuncia_id', $item->id)
                    ->orderByDesc('id')
                    ->first();

                $cds = $item->ciudadano_simple;

                $telcel = $cds->telefonos . '; ' . $cds->celulares . '; ' . $cds->email;
                $telcel = explode(';', $telcel);

                $cadcel = '';
                for ($i = 0; $i < count($telcel) - 1; $i++) {
                    if ($cadcel === '') {
                        $cadcel .= trim($telcel[$i]);
                    } else if (trim($telcel[$i]) !== '') {
                        $cadcel .= ', ' . trim($telcel[$i]);
                    } else {
                        $cadcel .= '';
                    }
                }

//                $atendidas = 0;
//                $pendientes = 0;
//                if (in_array(((int)$item->ue_id), array(17, 20, 21, 22))) {
//                    $atendidas = 1;
//                } else {
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

                $gdu = explode(',', trim($item->gd_ubicacion));
                $cadgdu = $gdu[1] ?? '';


                $sh
                    ->setCellValue('A' . $C, $item->id ?? 0)
                    ->setCellValue('B' . $C, trim($cds->username ?? ''))
                    ->setCellValue('C' . $C, trim($cds->ap_paterno ?? ''))
                    ->setCellValue('D' . $C, trim($cds->ap_materno ?? ''))
                    ->setCellValue('E' . $C, trim($cds->nombre ?? ''))
                    ->setCellValue('F' . $C, strtoupper(trim($item->search_google)) ?? '')
                    ->setCellValue('G' . $C, $Colonia ?? '')
                    ->setCellValue('H' . $C, $Delegacion ?? '')
                    ->setCellValue('I' . $C, $cadcel ?? '')
                    ->setCellValue('J' . $C, $fechaIngreso ?? '')
                    ->setCellValue('K' . $C, $item->dependencia ?? '')
                    ->setCellValue('L' . $C, $item->servicio ?? '')
                    ->setCellValue('M' . $C, $item->denuncia ?? '')
                    ->setCellValue('N' . $C, $item->prioridad->prioridad ?? '')
                    ->setCellValue('O' . $C, $item->origen->origen ?? '')
                    ->setCellValue('P' . $C, $item->estatus ?? '')
                    ->setCellValue('Q' . $C, Carbon::parse($item->fecha_movimiento)->format('d-m-Y') ?? '')
                    ->setCellValue('R' . $C, $item->observaciones ?? '')
                    ->setCellValue('S' . $C, $this->getColorSemaforo($item)['status'])
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


    public function resumenBasico01($C, $C0, $sh, $Items, $arrFE, $spreadsheet, $archivo, $extension){

        $sh->setCellValue('F1', Carbon::now()->format('d-m-Y h:i:s'));
        $C = 5;
        foreach ($Items as $item){
            $sh
                ->setCellValue('A' . $C, $item["servicio"] ?? '')
                ->setCellValue('B' . $C, $item["atendidas"] ?? 0)
                ->setCellValue('C' . $C, $item["rechazadas"] ?? 0)
                ->setCellValue('D' . $C, $item["pendientes"] ?? 0)
                ->setCellValue('E' . $C, $item["observadas"] ?? 0)
                ->setCellValue('F' . $C, $item["total"] ?? 0);
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


    function exportDataFilterMap2(Request $request){
        $data = $request->all();

        $dids = $data['items'];

        $ids = Str::of($dids)
            ->explode(',')
            ->map(function ($value) {
                return (int) $value;
            })
            ->toArray();

        $items = _viDDSs::query()
            ->select(FuncionesController::itemSelectDenunciasV1())
            ->whereIn('id', $ids)
            ->orderByDesc('id')
            ->get();

        $request->session()->put('items', $items);

        return $this->getListDenunciaAmbitoXLSX($request);

    }




    function exportDataFilterMap3(Request $request){
        $data = $request->all();

        $dids = $data['items'];

        $ids = Str::of($dids)
            ->explode(',')
            ->map(function ($value) {
                return (int) $value;
            })
            ->toArray();

        $items = _viDepDenServEstatus::query()
            ->select(FuncionesController::itemSelectDenuncias())
            ->whereIn('id', $ids)
            ->orderByDesc('id')
            ->get();

        $request->session()->put('items', $items);

        return $this->getListDenunciaAmbitoXLSX($request);

    }

    function resumenBasico01Export(Request $request){
        $arrColl = [
            ["sue_id" => 476, "servicio" => "FUGA DE AGUA POTABLE", "atendidas" => 0,"rechazadas" => 0,"pendientes" => 0,"observadas"=>0, "total"=>0],
            ["sue_id" => 508, "servicio" => "DESASOLVE DE DRENAJE","atendidas" => 0,"rechazadas" => 0,"pendientes" => 0,"observadas"=>0, "total"=>0],
            ["sue_id" => 479, "servicio" => "REPARACION DE ALCANTARILLA","atendidas" => 0,"rechazadas" => 0,"pendientes" => 0,"observadas"=>0, "total"=>0],
        ];

        $data = $request->validate([
            'items' => 'required|string',
        ]);

        $ids = collect(explode(',', $data['items']))
            ->map(function ($value) {
                return (int) $value;
            })
            ->toArray();

        $arrServ = _viDepDenServEstatus::query()
            ->select(FuncionesController::itemSelectDenuncias())
            ->whereIn('id', $ids)
            ->whereIn('servicio_id', [476,568,508,479])
            ->orderByDesc('id')
            ->get();


        $sueIdsDiferentes = $arrServ->pluck('servicio_id')->unique()->values();
        $numeroSueIdDiferentes = $sueIdsDiferentes->count();
//        echo $numeroSueIdDiferentes;

        // Ahora $sueIdsDiferentes es una Collection que contiene los sue_id diferentes.
        // Puedes convertirla a un array si lo prefieres:
        $arraySueIdsDiferentes = $sueIdsDiferentes->toArray();

        // Para imprimirlos:
//        foreach ($arraySueIdsDiferentes as $sueId) {
//            echo $sueId . "<br>";
//        }

//        return false;


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
            switch ($item->servicio_id) {
                case 476:
                case 568:
                    $indice = 0;
                    break;
                case 508:
                    $indice = 1;
                    break;
                case 479:
                    $indice = 2;
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
            }

        }

        $request->session()->put('items', $arrColl);

        return $this->getListDenunciaAmbitoXLSX($request);

    }




}
