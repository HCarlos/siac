<?php

namespace App\Http\Controllers\External\Denuncia;

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



class ListDenunciaXLSXController extends Controller
{


    public function getListDenunciaXLSX(Request $request){
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

        $sh->setCellValue('S1', Carbon::now()->format('d-m-Y h:m:s'));
//        dd($Items);
        foreach ($Items as $item){
//            $item = _viDDSs::find($it->id);

            //dd($item);

//            $ciudadano   = User::find($item->ciudadano_id);
//            $prioridad   = Prioridad::find($item->prioridad_id);
//            $origen      = Origen::find($item->origen_id);
//            $dependencia = Dependencia::find($item->dependencia_id);
//            $servicio    = Servicio::find($item->servicio_id);
//            $ubicacion   = Ubicacion::find($item->ubicacion_id);
//            $estatus     = Estatu::find($item->estatus_id);
//            $creadopor   = User::find($item->creadopor_id);

//                $fechaIngreso   = Carbon::parse($item->fecha_ingreso)->format('d-m-Y');

//            dd($item->fecha_ingreso);

//            $fechaIngreso   = !is_null($item->fecha_ingreso) ? date_format($item->fecha_ingreso,'d-m-Y') : '';
            $fechaIngreso   = Carbon::parse($item->fecha_ingreso)->format('d-m-Y');
            $fechaLimite    = Carbon::parse($item->fecha_limite)->format('d-m-Y'); //Carbon::createFromFormat('d-m-Y', $item->fecha_nacimiento);
            $fechaEjecucion = Carbon::parse($item->fecha_ejecucion)->format('d-m-Y'); //Carbon::createFromFormat('d-m-Y', $item->fecha_nacimiento);

            $resp = Denuncia_Dependencia_Servicio::query()->where('denuncia_id',$item->id)->orderByDesc('id')->get();
            $respuesta = "";
            $favorable = false;
            foreach ($resp as $r){
                $res = trim($r->observaciones);
                if ( $res != ""){
                    $dep = Dependencia::find($r->dependencia_id);
                    $respuesta.=$dep->abreviatura.' - '.$res.'. ';
                    $favorable = $r->favorable;
                }
            }

//            [{"denuncia_id":97415,"dependencia_id":12,"abrevi...

//            dd(last(json_decode($item->estatus_general)));

            if (json_decode($item->estatus_general) == null){
                $fechaUntiloEstatus = "";
            }else{
                $arrUltimoEstatus = last(json_decode($item->estatus_general));
                $fechaUntiloEstatus   = Carbon::parse($arrUltimoEstatus->fecha)->format('d-m-Y');
            }

            $sh
                ->setCellValue('A'.$C, $item->id ?? 0)
                ->setCellValue('B'.$C, trim($item->curp_ciudadano ?? ''))
                ->setCellValue('C'.$C, trim($item->ap_paterno_ciudadano ?? ''))
                ->setCellValue('D'.$C, trim($item->ap_materno_ciudadano ?? ''))
                ->setCellValue('E'.$C, trim($item->nombre_ciudadano ?? ''))

                ->setCellValue('F'.$C, trim($item->calle ?? ''))
                ->setCellValue('G'.$C, trim($item->num_ext ?? ''))
                ->setCellValue('H'.$C, trim($item->num_int ?? ''))
                ->setCellValue('I'.$C, trim($item->colonia ?? ''))
                ->setCellValue('J'.$C, trim($item->cp ?? ''))

                ->setCellValue('K'.$C, $item->ubicacion ?? '')
                ->setCellValue('L'.$C, $item->telefonoscelularesemails ?? '')
                ->setCellValue('M'.$C, $fechaIngreso ?? '')
                ->setCellValue('N'.$C, $item->dependencia_ultimo_estatus ?? '')
                ->setCellValue('O'.$C, $item->area ?? '')
                ->setCellValue('P'.$C, $item->subarea ?? '')
                ->setCellValue('Q'.$C, $item->servicio_ultimo_estatus ?? '')
                ->setCellValue('R'.$C, $item->denuncia ?? '')
                ->setCellValue('S'.$C, $item->referencia ?? '')
                ->setCellValue('T'.$C, $item->prioridad ?? '')
                ->setCellValue('U'.$C, $item->origen ?? '')
                ->setCellValue('V'.$C, $arrUltimoEstatus->estatus ?? '')
                ->setCellValue('W'.$C, $fechaUntiloEstatus ?? '')
                ->setCellValue('X'.$C, $respuesta )
                ->setCellValue('AA'.$C, $favorable ? "SI" : "NO" )
                ->setCellValue('AB'.$C, $item->observaciones )
                ->setCellValue('AC'.$C, $item->clave_identificadora )
                ->setCellValue('AD'.$C, trim($item->genero_ciudadano ?? ''));
            $C++;
        }
//        ->setCellValue('N'.$C, $servicio->subarea->area->dependencia->dependencia ?? '')
//        ->setCellValue('Q'.$C, $servicio->servicio ?? '')

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
        foreach ($Items as $item){

//            dd($item);

            $ciudadano   = User::find($item->ciudadano_id);
            $prioridad   = Prioridad::find($item->prioridad_id);
            $origen      = Origen::find($item->origen_id);
            $dependencia = Dependencia::find($item->dependencia_id);
            $servicio    = Servicio::find($item->servicio_id);
            $ubicacion   = Ubicacion::find($item->ubicacion_id);
            $estatus     = Estatu::find($item->estatus_id);
            $creadopor   = User::find($item->creadopor_id);

            $fechaIngreso   = Carbon::parse($item->fecha_ingreso)->format('d-m-Y');
            $fechaIngreso   = isset($item->fecha_ingreso) ? $fechaIngreso : '';
            $fechaLimite    = Carbon::parse($item->fecha_limite)->format('d-m-Y'); //Carbon::createFromFormat('d-m-Y', $item->fecha_nacimiento);
            $fechaEjecucion = Carbon::parse($item->fecha_ejecucion)->format('d-m-Y'); //Carbon::createFromFormat('d-m-Y', $item->fecha_nacimiento);

            $resp = Denuncia_Dependencia_Servicio::query()->where('denuncia_id',$item->id)->orderByDesc('id')->get();
            $respuesta = "";
            $favorable = false;
//            dd($resp->denuncia_id);
            $dr = Denuncia::find($item->id);
//            dd($dr->Ambito());

            foreach ($resp as $r){
                $res = trim($r->observaciones);
                if ( $res != ""){
                    $dep = Dependencia::find($r->dependencia_id);
                    $respuesta.=$dep->abreviatura.' - '.$res.'. ';
                    $favorable = $r->favorable;
                }
            }


            $sh
                ->setCellValue('A'.$C, $item->id ?? 0)
                ->setCellValue('B'.$C, trim($item->ultimo_servicio ?? ''))
                ->setCellValue('C'.$C, $fechaIngreso ?? '')
                ->setCellValue('D'.$C, trim($ciudadano->FullName ?? ''))
                ->setCellValue('E'.$C, trim($ciudadano->TelefonosCelularesEmails ?? ''))
                ->setCellValue('F'.$C, trim($ubicacion->calle ?? ''))
                ->setCellValue('G'.$C, trim($ubicacion->num_ext ?? ''))
                ->setCellValue('H'.$C, trim($ubicacion->num_int ?? ''))
                ->setCellValue('I'.$C, trim($ubicacion->colonia ?? ''))
                ->setCellValue('J'.$C, $item->referencia ?? '')
                ->setCellValue('K'.$C, $dr->Ambito() ?? '')
                ->setCellValue('L'.$C, $item->ultimo_estatus ?? '')
                ->setCellValue('M'.$C, $item->ultima_fecha_estatus ?? '');

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









    public function showDataListDenunciaRespuestaExcel1A(Request $request){
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







}
