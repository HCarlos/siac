<?php

namespace App\Http\Controllers\External;

use App\Http\Controllers\Funciones\LoadTemplateExcel;
use App\Models\Catalogos\Afiliacion;
use App\Models\Catalogos\Area;
use App\Models\Catalogos\Dependencia;
use App\Models\Catalogos\Domicilios\Asentamiento;
use App\Models\Catalogos\Domicilios\Calle;
use App\Models\Catalogos\Domicilios\Ciudad;
use App\Models\Catalogos\Domicilios\Codigopostal;
use App\Models\Catalogos\Domicilios\Colonia;
use App\Models\Catalogos\Domicilios\Comunidad;
use App\Models\Catalogos\Domicilios\Estado;
use App\Models\Catalogos\Domicilios\Localidad;
use App\Models\Catalogos\Domicilios\Municipio;
use App\Models\Catalogos\Domicilios\Tipoasentamiento;
use App\Models\Catalogos\Domicilios\Tipocomunidad;
use App\Models\Catalogos\Domicilios\Ubicacion;
use App\Models\Catalogos\Estatu;
use App\Models\Catalogos\Medida;
use App\Models\Catalogos\Origen;
use App\Models\Catalogos\Prioridad;
use App\Models\Catalogos\Servicio;
use App\Models\Catalogos\Subarea;
use App\Models\Denuncias\_viServicios;
use App\Models\Denuncias\Denuncia;
use App\Models\Denuncias\Imagene;
use App\Models\Denuncias\Respuesta;
use App\Models\Users\Categoria;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ListModelXLSXController extends Controller
{

    public function getListModelXLSX($nModel){
        ini_set('max_execution_time', 72000);
        $Model = null;
        switch ($nModel){
            case 1:
                $Model = Ubicacion::all();
                break;
            case 2:
                $Model = _viServicios::all();
                break;
            case 3:
                $Model = Dependencia::all();
                break;
            case 4:
                $Model = Area::all();
                break;
            case 5:
                $Model = Subarea::all();
                break;
            case 6:
                $Model = Subarea::all();
                break;
            case 7:
                $Model = Asentamiento::all();
                break;
            case 8:
                $Model = Calle::all();
                break;
            case 9:
                $Model = Ciudad::all();
                break;
            case 10:
                $Model = Codigopostal::all();
                break;
            case 11:
                $Model = Colonia::all();
                break;
            case 12:
                $Model = Comunidad::all();
                break;
            case 13:
                $Model = Estado::all();
                break;
            case 14:
                $Model = Localidad::all();
                break;
            case 15:
                $Model = Municipio::all();
                break;
            case 16:
                $Model = Tipoasentamiento::all();
                break;
            case 17:
                $Model = Tipocomunidad::all();
                break;
            case 18:
                $Model = Categoria::all();
                break;
            case 19:
                $Model = User::all();
                break;
            case 20:
                $Model = Imagene::all();
                break;
            case 21:
                $Model = Respuesta::all();
                break;
            case 22:
                $Model = Afiliacion::all();
                break;
            case 23:
                $Model = Denuncia::query()->orderByDesc('id')->first();
                break;
            case 24:
                $Model = Estatu::all();
                break;
            case 25:
                $Model = Medida::all();
                break;
            case 26:
                $Model = Origen::all();
                break;
            case 27:
                $Model = Prioridad::all();
                break;
        }

        $C0 = 5;
        $C = $C0;

        $nameTable = $Model->count() >0 ? ucwords($Model->first()->getTable()) : '(Vacio)';
        $nameTable = "Catálogo de ".$nameTable;

//        dd($nameTable);

        try {
            $file_external = trim(config("atemun.archivos.fmt_lista_catalogos"));
            $arrFE = explode('.',$file_external);
            $extension = Str::ucfirst($arrFE[1]);

            $archivo =  LoadTemplateExcel::getFileTemplate($file_external);
            $reader = IOFactory::createReader($extension);
            $spreadsheet = $reader->load($archivo);
            $sh = $spreadsheet->setActiveSheetIndex(0);

//            $sh->getStyle('A2')->getFont()->setBold(true);
            $sh->setCellValue('A2', $nameTable);
//            $sh->getStyle('N1')->getFont()->setBold(true);
            $sh->setCellValue('N1', Carbon::now()->format('d-m-Y h:m:s'));

            $attributes =$Model[0]->toArray();
            $row = 1;
            foreach ($attributes as $key=>$value){
                $sh->getStyleByColumnAndRow($row,$C)->getFont()->setBold(true);
                $sh->setCellValueByColumnAndRow($row,$C, strtoupper($key));
                ++$row;
            }
            $C++;
            foreach ($Model as $user){
                $attributes = $user->toArray();
                $row = 1;
                foreach ($attributes as $key=>$value) {
                        $sh->setCellValueByColumnAndRow($row, $C, $attributes[$key] );
                        ++$row;
                }
                $C++;
            }

            $Cx = $C  - 1;
            $oVal = $sh->getCell('G1')->getValue();
            $sh->setCellValue('B'.$C, 'TOTAL DE REGISTROS')
                ->setCellValue('C'.$C, $Model->count())
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

        } catch (Exception $e) {
            echo 'Ocurrio un error al intentar abrir el archivo ' . $e;
        }

    }


}
