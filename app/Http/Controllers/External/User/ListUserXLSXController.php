<?php

namespace App\Http\Controllers\External\User;

use App\Classes\FiltersRules;
use App\Http\Controllers\Funciones\LoadTemplateExcel;
use App\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;


class ListUserXLSXController extends Controller
{


    public function getListUserXLSX(Request $request){
        ini_set('max_execution_time', 72000);

        $data = $request->all(['search','roles']);
        $data['search'] = $data['search']==null ? "" : $data['search'];
        $data['roles']  = $data['roles']==null ? [] : explode(",",$data['roles']);
        $filters = [
            'search' => $data['search'],
            'roles'  => $data['roles'],
        ];
        $Users = User::query()
            ->filterBy( $filters )
            ->orderBy(DB::RAW("CONCAT(ap_paterno,' ',ap_materno,' ',nombre)"),'ASC')
            ->get();

        $C0 = 6;
        $C = $C0;

        try {
            $file_external = trim(config("atemun.archivos.fmt_lista_usuarios"));
            $arrFE = explode('.',$file_external);
            $extension = Str::ucfirst($arrFE[1]);

            $archivo =  LoadTemplateExcel::getFileTemplate($file_external);
            $reader = IOFactory::createReader($extension);
            $spreadsheet = $reader->load($archivo);
            $sh = $spreadsheet->setActiveSheetIndex(0);


            $sh->setCellValue('J1', Carbon::now()->format('d-m-Y h:m:s'));
            foreach ($Users as $user){
                $uaId            = $user->DependenciaIdStrArray;
                $uaName          = $user->DependenciaNameStrArray;
                $uaAbrevName     = $user->DependenciaAbreviaturaStrArray;
                $rolId           = $user->RoleIdStrArray;
                $rolName         = $user->RoleNameStrArray;
                $permisionId     = $user->PermisionIdStrArray;
                $permisionName   = $user->PermisionNameStrArray;
                $deps_abrev      = isset($user->dependencias->first()->abreviatura) ? $user->dependencias->first()->abreviatura : '';
                $deps_name       = isset($user->dependencias->first()->dependencia) ? $user->dependencias->first()->dependencia : '';
                $fechaNacimiento = Carbon::parse($user->fecha_nacimiento)->format('d-m-Y'); //Carbon::createFromFormat('d-m-Y', $user->fecha_nacimiento);
                $sh
                    ->setCellValue('A'.$C, $user->id)
                    ->setCellValue('B'.$C, $user->ap_paterno)
                    ->setCellValue('C'.$C, $user->ap_materno)
                    ->setCellValue('D'.$C, $user->nombre)
                    ->setCellValue('E'.$C, $user->curp)
                    ->setCellValue('F'.$C, $uaAbrevName)
                    ->setCellValue('G'.$C, $uaName)
                    ->setCellValue('H'.$C, $rolName)
                    ->setCellValue('I'.$C, $permisionName)
                    ->setCellValue('J'.$C, $user->logged_at);

/*                ->setCellValue('A'.$C, $user->id)
                    ->setCellValue('B'.$C, $user->username)
                    ->setCellValue('C'.$C, $user->ap_paterno)
                    ->setCellValue('D'.$C, $user->ap_materno)
                    ->setCellValue('E'.$C, $user->nombre)
                    ->setCellValue('F'.$C, $user->FullName)
                    ->setCellValue('G'.$C, $user->email)
                    ->setCellValue('H'.$C, $user->user_adress->calle)
                    ->setCellValue('I'.$C, $user->user_adress->num_ext)
                    ->setCellValue('J'.$C, $user->user_adress->num_int)
                    ->setCellValue('K'.$C, $user->user_adress->colonia)
                    ->setCellValue('L'.$C, $user->user_adress->localidad)
                    ->setCellValue('M'.$C, $user->user_adress->cp)
                    ->setCellValue('N'.$C, $user->user_adress->municipio)
                    ->setCellValue('O'.$C, $user->user_adress->estado)
                    ->setCellValue('P'.$C, $user->user_adress->pais)
                    ->setCellValue('Q'.$C, $user->curp)
                    ->setCellValue('R'.$C, $user->user_data_extend->lugar_nacimiento)
                    ->setCellValue('S'.$C, $fechaNacimiento)
                    ->setCellValue('T'.$C, $user->StrGenero)
                    ->setCellValue('U'.$C, $user->emails)
                    ->setCellValue('V'.$C, $user->celulares)
                    ->setCellValue('W'.$C, $user->telefonos)
                    ->setCellValue('Y'.$C, $user->empresa_id)
                    ->setCellValue('Z'.$C, $user->user_data_extend->ocupacion)
                    ->setCellValue('AA'.$C, $user->user_data_extend->profesion)
                    ->setCellValue('AB'.$C, $rolId)
                    ->setCellValue('AC'.$C, $rolName);*/



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
            header('Content-Disposition: attachment;filename="users_roles_permissions_file"');
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


    public function getUserByRoleToXLSX(Request $request){
        ini_set('max_execution_time', 72000);
        $data = $request->all(['role_user',]);
        $data['role_user'] = $data['role_user']==null ? 'ALUMNO' : $data['role_user'];
        $filters = new FiltersRules();
        $filters = $filters->filterRulesBecasAlumno($request, $data['role_user']);
//        dd($filters);
        $Users = User::query()
            ->filterBy( $filters )
            ->orderBy(DB::RAW("CONCAT(ap_paterno,' ',ap_materno,' ',nombre)"),'ASC')
            ->get();

        $C0 = 6;
        $C = $C0;

        try {
            $file_external = trim(config("atemun.archivos.fmt_lista_usuarios_roles"));
            $arrFE = explode('.',$file_external);
            $extension = Str::ucfirst($arrFE[1]);
            $archivo =  LoadTemplateExcel::getFileTemplate($file_external);
            //dd($archivo);
            $reader = IOFactory::createReader($extension);
            $spreadsheet = $reader->load($archivo);
            $sh = $spreadsheet->setActiveSheetIndex(0);


            $sh->setCellValue('K1', Carbon::now()->format('d-m-Y h:m:s'));
            foreach ($Users as $user){
                $rolId           = $user->RoleIdStrArray;
                $rolName         = $user->RoleNameStrArray;
                $fechaNacimiento = Carbon::parse($user->fecha_nacimiento)->format('d-m-Y'); //Carbon::createFromFormat('d-m-Y', $user->fecha_nacimiento);
                $sh
                    ->setCellValue('A'.$C, $user->id)
                    ->setCellValue('B'.$C, $user->username)
                    ->setCellValue('C'.$C, $user->ap_paterno)
                    ->setCellValue('D'.$C, $user->ap_materno)
                    ->setCellValue('E'.$C, $user->nombre)
                    ->setCellValue('F'.$C, $user->FullName)
                    ->setCellValue('G'.$C, $user->email)
                    ->setCellValue('H'.$C, $user->user_adress->calle)
                    ->setCellValue('I'.$C, $user->user_adress->num_ext)
                    ->setCellValue('J'.$C, $user->user_adress->num_int)
                    ->setCellValue('K'.$C, $user->user_adress->colonia)
                    ->setCellValue('L'.$C, $user->user_adress->localidad)
                    ->setCellValue('M'.$C, $user->user_adress->cp)
                    ->setCellValue('N'.$C, $user->user_adress->municipio)
                    ->setCellValue('O'.$C, $user->user_adress->estado)
                    ->setCellValue('P'.$C, $user->user_adress->pais)
                    ->setCellValue('Q'.$C, $user->curp)
                    ->setCellValue('R'.$C, $user->user_data_extend->lugar_nacimiento)
                    ->setCellValue('S'.$C, $fechaNacimiento)
                    ->setCellValue('T'.$C, $user->StrGenero)
                    ->setCellValue('U'.$C, $user->emails)
                    ->setCellValue('V'.$C, $user->celulares)
                    ->setCellValue('W'.$C, $user->telefonos)
                    ->setCellValue('Y'.$C, $user->empresa_id)
                    ->setCellValue('Z'.$C, $user->user_data_extend->ocupacion)
                    ->setCellValue('AA'.$C, $user->user_data_extend->profesion)
                    ->setCellValue('AB'.$C, $rolId)
                    ->setCellValue('AC'.$C, $rolName);
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

        } catch (Exception $e) {
            echo 'Ocurrio un error al intentar abrir el archivo ' . $e;
        }

    }



}
