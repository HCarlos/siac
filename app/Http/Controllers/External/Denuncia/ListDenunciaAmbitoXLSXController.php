<?php

namespace App\Http\Controllers\External\Denuncia;

use App\Models\Catalogos\CentroLocalidad;
use App\Models\Catalogos\Dependencia;
use App\Models\Catalogos\Domicilios\Ubicacion;
use App\Models\Catalogos\Estatu;
use App\Models\Catalogos\Origen;
use App\Models\Catalogos\Prioridad;
use App\Models\Catalogos\Servicio;
use App\Models\Denuncias\_viDDSs;
use App\Models\Denuncias\Denuncia;
use App\Models\Denuncias\Denuncia_Dependencia_Servicio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Http\Controllers\Funciones\LoadTemplateExcel;
use App\User;
use Carbon\Carbon;
use Exception;

use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;



class ListDenunciaAmbitoXLSXController extends Controller
{


    public function getListDenunciaAmbitoXLSX(Request $request){
        ini_set('max_execution_time', 90000);
//        $data = $request->only(['search','items']);
        $Items = $request->session()->get('items');

        $C0 = 6;
        $C = $C0;

        try {

//            $file_external = trim(config("atemun.archivos.fmt_lista_denuncias"));
            $data =  $request->only(['fileoutput','indice']);
            $file_external =  $data["fileoutput"];
            $indice = (int) $data["indice"];

//            dd($file_external);

            $arrFE = explode('.',$file_external);
            $extension = Str::ucfirst($arrFE[1]);

            $archivo =  LoadTemplateExcel::getFileTemplate($file_external);
            $reader = IOFactory::createReader($extension);
            $spreadsheet = $reader->load($archivo);
            $sh = $spreadsheet->setActiveSheetIndex(0);

            switch ($indice){
                case 0:
                    $this->denunciaGeneral01($C, $C0, $sh, $Items, $arrFE, $spreadsheet, $archivo, $extension);
                    break;
                case 1:
                    $this->denunciaSASGeneral01($C, $C0, $sh, $Items, $arrFE, $spreadsheet, $archivo, $extension);
                    break;
            }

        } catch (Exception $e) {
            echo 'Ocurrio un error al intentar abrir el archivo ' . $e;
        }

    }

    // Denuncia General Formato 01
    public function denunciaGeneral01($C, $C0, $sh, $Items, $arrFE, $spreadsheet, $archivo, $extension){

        $sh->setCellValue('u1', Carbon::now()->format('d-m-Y h:m:s'));
        foreach ($Items as $item){
            $fechaIngreso   = Carbon::parse($item->fecha_ingreso)->format('d-m-Y H:i');
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
            $favorable = false;
            try{
                if ( $resp->observaciones !== null){
                    $res = trim($resp->observaciones) ?? '';
                    if ( $res != ""){
                        $dep = Dependencia::find($resp->dependencia_id);
                        $respuesta = $dep->abreviatura.' - '.$res.'. ';
                        $favorable = $resp->favorable;
                    }
                }else{
                    $respuesta = '';
                    $favorable = '';
                }
            }catch (Exception $e) {
                $respuesta = '';
                $favorable = '';
            }


            if (json_decode($item->estatus_general) == null){
                $fechaUntiloEstatus = "";
            }else{
                $arrUltimoEstatus = last(json_decode($item->estatus_general));
                $fechaUntiloEstatus   = Carbon::parse($arrUltimoEstatus->fecha)->format('d-m-Y');
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

                $gdu = explode(',',trim($item->gd_ubicacion));
                $cadgdu = $gdu[1] ?? '';

                $sh
                    ->setCellValue('A'.$C, $item->id ?? 0)
                    ->setCellValue('B'.$C, trim($cds->username ?? ''))
                    ->setCellValue('C'.$C, trim($cds->ap_paterno ?? ''))
                    ->setCellValue('D'.$C, trim($cds->ap_materno ?? ''))
                    ->setCellValue('E'.$C, trim($cds->nombre ?? ''))

                    ->setCellValue('F'.$C, trim($item->gd_ubicacion) ?? '')
                    ->setCellValue('G'.$C, $Colonia ?? '')
                    ->setCellValue('H'.$C, $Delegacion ?? '')

                    ->setCellValue('I'.$C, $cadcel ?? '')
                    ->setCellValue('J'.$C, $fechaIngreso ?? '')
                    ->setCellValue('K'.$C, $item->dependencia_ultimo_estatus->dependencia ?? '')
                    ->setCellValue('L'.$C, $item->servicio_ultimo_estatus->servicio ?? '')

                    ->setCellValue('M'.$C, $item->descripcion ?? '')

                    ->setCellValue('N'.$C, $item->prioridad->prioridad ?? '')
                    ->setCellValue('O'.$C, $item->origen->origen ?? '')
                    ->setCellValue('P'.$C, $item->ultimo_estatus ?? '')
                    ->setCellValue('Q'.$C, Carbon::parse($item->fecha_ultimo_estatus)->format('d-m-Y h:m') ?? '')
                    ->setCellValue('R'.$C, $respuesta )
                    ->setCellValue('S'.$C, $item->clave_identificadora )
                    ->setCellValue('T'.$C, trim($cds->StrGenero ?? ''))
                    ->setCellValue('U'.$C, $item->Ambito() ?? '')
                    ->setCellValue('V'.$C, $this->getColorSemaforo($item));
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

        $sh->setCellValue('I1', Carbon::now()->format('d-m-Y h:m:s'));
        foreach ($Items as $item) {
            $fechaIngreso = Carbon::parse($item->fecha_ingreso)->format('d-m-Y');
            $fechaIngreso = isset($item->fecha_ingreso) ? $fechaIngreso : '';

            $resp = Denuncia_Dependencia_Servicio::query()
                ->select(['id', 'observaciones', 'dependencia_id', 'favorable', 'denuncia_id'])
                ->where('denuncia_id', $item->id)
                ->orderByDesc('id')
                ->first();

            $respuesta = "";
            $favorable = false;
            try {
                if ($resp->observaciones !== null) {
                    $res = trim($resp->observaciones) ?? '';
                    if ($res != "") {
                        $dep = Dependencia::find($resp->dependencia_id);
                        $respuesta = $dep->abreviatura . ' - ' . $res . '. ';
                        $favorable = $resp->favorable;
                    }
                } else {
                    $respuesta = '';
                    $favorable = '';
                }
            } catch (Exception $e) {
                $respuesta = '';
                $favorable = '';
            }

            $Colonia = "";
            $Delegacion = "";
            $CenLoc       = $item->centro_localidad_id;
            if ($CenLoc != null || $CenLoc != "" || $CenLoc != 0){
                $Loc = CentroLocalidad::find($CenLoc);
                $Colonia = $Loc->ItemColonia();
                $Delegacion = $Loc->ItemDelegacion();
            }

            foreach ($item->ciudadanos as $cds) {

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

                $gdu = explode(',', trim($item->gd_ubicacion));
                $cadgdu = $gdu[1] ?? '';

                $sh
                    ->setCellValue('A' . $C, $item->id ?? 0)
                    ->setCellValue('B' . $C, trim($item->servicio_ultimo_estatus->servicio ?? ''))
                    ->setCellValue('C' . $C, $fechaIngreso ?? '')
                    ->setCellValue('D' . $C, trim($cds->full_name ?? ''))
                    ->setCellValue('E' . $C, $cadcel)
                    ->setCellValue('F' . $C, trim($item->gd_ubicacion ?? ''))
                    ->setCellValue('G' . $C, trim($Colonia ?? ''))
                    ->setCellValue('H' . $C, trim($Delegacion ?? ''))
                    ->setCellValue('I' . $C, $item->descripcion ?? '')
                    ->setCellValue('J' . $C, $item->Ambito() ?? '')
                    ->setCellValue('K' . $C, $item->ultimo_estatus ?? '')
                    ->setCellValue('L' . $C, Carbon::parse($item->fecha_ultimo_estatus)->format('d-m-Y H:i') ?? '');
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

            $sh->setCellValue('H1', Carbon::now()->format('d-m-Y h:m:s'));
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

                $ciudadano   = User::find($Denuncia->ciudadano_id);
                $prioridad   = Prioridad::find($Denuncia->prioridad_id);
                $origen      = Origen::find($Denuncia->origen_id);
                $dependencia = Dependencia::find($Denuncia->dependencia_id);
                $servicio    = Servicio::find($Denuncia->servicio_id);
                $ubicacion   = Ubicacion::find($Denuncia->ubicacion_id);
                $estatus     = Estatu::find($Denuncia->estatus_id);
                $creadopor   = User::find($Denuncia->creadopor_id);

                $fechaIngreso   = Carbon::parse($Denuncia->fecha_ingreso)->format('d-m-Y'); //Carbon::createFromFormat('d-m-Y', $item->fecha_nacimiento);
                $fechaLimite    = Carbon::parse($Denuncia->fecha_limite)->format('d-m-Y'); //Carbon::createFromFormat('d-m-Y', $item->fecha_nacimiento);
                $fechaEjecucion = Carbon::parse($Denuncia->fecha_ejecucion)->format('d-m-Y'); //Carbon::createFromFormat('d-m-Y', $item->fecha_nacimiento);

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
        $status = "white";
        $dias_vencidos = 0;
        switch ( $g->ue_id ) {
            case 16:
            case 19:
                $ser = _viDDSs::find($g->id);
                $fex = Carbon::parse(now())->diffInDays(Carbon::parse($ser->fecha_dias_maximos_ejecucion),false);
                if ($fex >= 0) {
                    $status = "amarillo";
                }else{
                    $status = "rojo";
                    $dias_vencidos = abs($fex);
                }
                break;
            case 17:
            case 20:
            case 21:
                $status = "verde";
                break;
            default:
                $status = "amarillo";
                break;
        }
        return $status;

    }




}
