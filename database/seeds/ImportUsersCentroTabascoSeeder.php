<?php

use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\Catalogos\Domicilios\Calle;
use App\Models\Catalogos\Domicilios\Ciudad;
use App\Models\Catalogos\Domicilios\Codigopostal;
use App\Models\Catalogos\Domicilios\Colonia;
use App\Models\Catalogos\Domicilios\Comunidad;
use App\Models\Catalogos\Domicilios\Estado;
use App\Models\Catalogos\Domicilios\Localidad;
use App\Models\Catalogos\Domicilios\Municipio;
use App\Models\Catalogos\Domicilios\Ubicacion;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImportUsersCentroTabascoSeeder extends Seeder{

    public function run(){

        @ini_set( 'upload_max_size' , '32768M' );
        @ini_set( 'post_max_size', '32768M');
        @ini_set( 'max_execution_time', '256000000' );
        @ini_set('memory_limit', '-1');
        app()['cache']->forget('spatie.permission.cache');

        $F = new FuncionesController();


//        @ini_set( 'upload_max_size' , '2048M' );
//        @ini_set( 'post_max_size', '2048M');
//        @ini_set( 'max_execution_time', '36000' );


        Calle::query()->truncate();
        Colonia::query()->truncate();
        Localidad::query()->truncate();

 //        Ciudad::query()->truncate();
 //        Municipio::query()->truncate();
 //        Estado::query()->truncate();

        Codigopostal::query()->truncate();
        Comunidad::query()->truncate();
        Ubicacion::query()->truncate();


        // Subimos los Estados
//        $file = 'public/csv/estados.csv';
//        $json_data = file_get_contents($file);
//        $json_data = preg_split( "/\n/", $json_data );
//        for ($x = 0; $x < count($json_data); $x++){
//            try{
//                $dupla = preg_split("/\t/", $json_data[$x], -1, PREG_SPLIT_NO_EMPTY);
//                $arr = str_getcsv($dupla[0]);
//                Estado::create(['id'=>$arr[0],'estado'=>$arr[1],'estado_mig_id'=>$arr[0]]);
//            }catch (QueryException $e){
//                Log::alert($e->getMessage());
//                continue;
//            }catch (Exception $e){
//                Log::alert($e->getMessage());
//                continue;
//            }
//        }

        // Subimos los Municipios
//        $file = 'public/csv/municipios.csv';
//        $json_data = file_get_contents($file);
//        $json_data = preg_split( "/\n/", $json_data );
//        for ($x = 0; $x < count($json_data); $x++){
//            try{
//                $dupla = preg_split("/\t/", $json_data[$x], -1, PREG_SPLIT_NO_EMPTY);
//                $arr = str_getcsv($dupla[0]);
//                Municipio::create(['id'=>$arr[0],'municipio'=>$arr[1],'estado_id'=>$arr[2],'numero_municipio'=>$arr[3],'municipio_mig_id'=>$arr[0]]);
//            }catch (QueryException $e){
//                Log::alert($e->getMessage());
//                continue;
//            }catch (Exception $e){
//                Log::alert($e->getMessage());
//                continue;
//            }
//        }

        // Subimos los Ciudades
//        $file = 'public/csv/ciudades.csv';
//        $json_data = file_get_contents($file);
//        $json_data = preg_split( "/\n/", $json_data );
//        for ($x = 0; $x < count($json_data); $x++){
//            try{
//                $dupla = preg_split("/\t/", $json_data[$x], -1, PREG_SPLIT_NO_EMPTY);
//                $arr = str_getcsv($dupla[0]);
//                Ciudad::create(['id'=>$arr[0],'ciudad'=>$arr[1],'municipio_id'=>$arr[2],'ciudad_mig_id'=>$arr[0]]);
//            }catch (QueryException $e){
//                Log::alert($e->getMessage());
//                continue;
//            }catch (Exception $e){
//                Log::alert($e->getMessage());
//                continue;
//            }
//        }

//        $user = User::query()->where('id','>',13)->delete();

        $user = User::withTrashed()->where('id','>',13);
        $user->forceDelete();
        DB::statement("ALTER SEQUENCE users_id_seq RESTART WITH 14 ");

        //User::query()->truncate();

        //dd(  );

        $file = 'public/csv/dump_centro_tab.csv';
        $json_data = file_get_contents($file);
        $json_data = preg_split( "/\n/", $json_data );

//        dd(count($json_data));

        for ($x = 0; $x < count($json_data); $x++){
            try{

                $dupla = preg_split("/\t/", $json_data[$x], -1, PREG_SPLIT_NO_EMPTY);
                $arr = str_getcsv($dupla[0]);

                $user_mid_id      = trim($arr[0]) == "" ? 0 : intval($arr[0]);
                $curp             = trim($arr[1]) == "" ? "" : strtoupper(trim($arr[1]));
                $ap_paterno       = trim($arr[2]) == "" ? "" : strtoupper(trim($arr[2]));
                $ap_materno       = trim($arr[3]) == "" ? "" : strtoupper(trim($arr[3]));
                $nombre           = trim($arr[4]) == "" ? "" : strtoupper(trim($arr[4]));
                $fecha_nacimiento = trim($arr[5]) == "" ? null : trim($arr[5]);
                $genero           = trim($arr[6]) == "" ? 0 : trim($arr[6]);
                $calle_mig_id     = trim($arr[7]) == "" ? 0 : trim($arr[7]);
                $calle            = trim($arr[8]) == "" ? "" : strtoupper(trim($arr[8]));
                $num_int          = trim($arr[9]) == "" ? "" : strtoupper(trim($arr[9]));
                $num_ext          = trim($arr[10]) == "" ? "" : strtoupper(trim($arr[10]));

                $colonia_mig_id   = trim($arr[11]) == "" ? 0 : intval($arr[11]);
                $colonia          = trim($arr[12]) == "" ? "" : strtoupper(trim($arr[12]));

                $localidad_mig_id = trim($arr[13]) == "" ? 0 : intval($arr[13]);
                $localidad        = trim($arr[14]) == "" ? "" : strtoupper(trim($arr[14]));

                $comunidad_mig_id = trim($arr[13]) == "" ? 0 : intval($arr[13]);
                $comunidad        = trim($arr[14]) == "" ? "" : strtoupper(trim($arr[14]));

                $ciudad_mig_id    = trim($arr[15]) == "" ? 0 : intval($arr[15]);
                $ciudad           = trim($arr[16]) == "" ? "" : strtoupper(trim($arr[16]));

                $municipio_mig_id = trim($arr[17]) == "" ? 0 : intval($arr[17]);
                $municipio        = trim($arr[18]) == "" ? "" : strtoupper(trim($arr[18]));

                $estado_mig_id    = trim($arr[19]) == "" ? 0 : intval($arr[19]);
                $estado           = trim($arr[20]) == "" ? "" : strtoupper(trim($arr[20]));

                $cp_mig_id        = trim($arr[21]) == "" ? 0 : intval($arr[21]);
                $cp               = trim($arr[22]) == "" ? "" : intval($arr[22]);

                $latitud          = trim($arr[23]) == "" ? 0 : intval($arr[23]);
                $longitud         = trim($arr[24]) == "" ? 0 : intval($arr[24]);
                $altitud          = trim($arr[25]) == "" ? 0 : intval($arr[25]);

                $Calle = Calle::query()->where('calle',$calle)->first();
                if ( !$Calle ){
                    $Calle = Calle::create(['calle'=>$calle,'calle_mig_id'=>$calle_mig_id]);
                }

                $CP = Codigopostal::query()->where('cp',$cp)->first();
                if ( !$CP ){
                    $CP = Codigopostal::create(['codigo'=>'000000','cp'=>$cp,'cp_mig_id'=>$cp_mig_id]);
                }

                $Localidad = Localidad::query()->where('localidad',$localidad)->first();
                if ( !$Localidad ){
                    $Localidad = Localidad::create(['localidad'=>$localidad,'localidad_mig_id'=>$localidad_mig_id]);
                }

                $Comunidad = Comunidad::query()->where('comunidad',$localidad)->first();
                if ( !$Comunidad ){
                    $Comunidad = Comunidad::create(['comunidad'=>$localidad,'delegado_id'=>1,'tipocomunidad_id'=>1,'ciudad_id'=>302,'municipio_id'=>2007,'estado_id'=>27,'comunidad_mig_id'=>$localidad_mig_id]);
                }

                $Colonia = Colonia::query()->where('colonia',$colonia)->first();
                if ( !$Colonia ){
                    $col = ['colonia'=>$colonia, 'cp'=>$cp,'altitud'=>$altitud,'latitud'=>$latitud,'longitud'=>$longitud,'codigopostal_id'=> !isset($CP->id) ? 1 : $CP->id,'comunidad_id'=> !isset($Comunidad->id) ? 1 : $Comunidad->id ,'tipocomunidad_id'=>1,'colonia_mig_id'=>$colonia_mig_id];
                    $Colonia = Colonia::create($col);
                }

                $Estado = Estado::query()->where('estado',$estado)->first();
                if ( !$Estado ){
                    $Estado = Estado::create(['estado'=>$estado,'pais_id'=>1,'estado_mig_id'=>$estado_mig_id]);
                }

                $Municipio = Municipio::query()->where('municipio',$municipio)->first();
                if ( !$Municipio ){
                    $Municipio = Municipio::create(['municipio'=>$municipio,'estado_id'=>!isset($Estado->id) ? 33 : $Estado->id,'municipio_mig_id'=>$municipio_mig_id]);
                }

                $Ciudad = Ciudad::query()->where('ciudad',$ciudad)->first();
                if ( !$Ciudad ){
                    $Ciudad = Ciudad::create(['ciudad'=>$ciudad,'municipio_id'=>!isset($Municipio->id) ? 2007 : $Municipio->id,'ciudad_mig_id'=>$ciudad_mig_id]);
                }
                $calle_id        = !isset($Calle->id)  ? 1 : $Calle->id;
                $colonia_id      = !isset($Colonia->id) ? 1 : $Colonia->id;
                $comunidad_id    = !isset($Comunidad->id) ? 1 : $Comunidad->id;
                $ciudad_id       = !isset($Ciudad->id)  ? 1 : $Ciudad->id;
                $municipio_id    = !isset($Municipio->id)  ? 1 : $Municipio->id;
                $estado_id       = !isset($Estado->id)  ? 1 : $Estado->id;
                $codigopostal_id = !isset($CP->id) ? 1 : $CP->id;

                $calle           = !isset($Calle->calle)  ? "" : $Calle->calle;
                $colonia         = !isset($Colonia->colonia) ? "" : $Colonia->colonia;
                $comunidad       = !isset($Comunidad->comunidad) ? "" : $Comunidad->comunidad;
                $ciudad          = !isset($Ciudad->ciudad)  ? "" : $Ciudad->ciudad;
                $municipio       = !isset($Municipio->municipio)  ? "" : $Municipio->municipio;
                $estado          = !isset($Estado->estado)  ? "" : $Estado->estado;
                $cp              = !isset($CP->cp) ? "" : $CP->cp;

                $Item = [
                    'calle'           => $calle,
                    'num_ext'         => $num_ext,
                    'num_int'         => $num_int,
                    'colonia'         => $colonia,
                    'comunidad'       => $localidad,
                    'ciudad'          => $ciudad,
                    'municipio'       => $municipio,
                    'estado'          => $estado,
                    'pais'            => 'MEXICO',
                    'cp'              => $cp,
                    'latitud'         => $latitud,
                    'longitud'        => $longitud,
                    'calle_id'        => $calle_id,
                    'colonia_id'      => $colonia_id,
                    'comunidad_id'    => $comunidad_id,
                    'ciudad_id'       => $ciudad_id,
                    'municipio_id'    => $municipio_id,
                    'estado_id'       => $estado_id,
                    'codigopostal_id' => $codigopostal_id,
                ];

                // UPDATE comunidades set ciudad_id = 302, municipio_id = 2007, estado_id = 27 where ciudad_id = 1 and municipio_id = 1 and estado_id = 1

                $Ubi = Ubicacion::query()
                    ->where('calle_id',$calle_id)
                    ->where('num_ext',strtoupper(trim($num_ext)))
                    ->where('num_int',strtoupper(trim($num_int)))
                    ->where('colonia_id',$colonia_id)
                    ->where('comunidad_id',$comunidad_id)
                    ->where('ciudad_id',$ciudad_id)
                    ->where('municipio_id',$municipio_id)
                    ->where('estado_id',$estado_id)
                    ->first();

//                dd( $Ubi->count());

                if ( !$Ubi ) {
                    $Ubi = Ubicacion::create($Item);
                    $Ubi->calles()->attach($calle_id);
                    $Ubi->colonias()->attach($colonia_id);
                    $Ubi->comunidades()->attach($comunidad_id);
                    $Ubi->ciudades()->attach($ciudad_id);
                    $Ubi->municipios()->attach($municipio_id);
                    $Ubi->estados()->attach($estado_id);
                    $Ubi->codigospostales()->attach($codigopostal_id);
                }

                    $curp = strtoupper(trim($curp));

                    $SiEntro = true;
                    if ($curp != ""){
                        $Usr = User::query()->where('curp',$curp)->get();
                        $username = $curp;
                        $password = bcrypt($username);
                    }else{
                        $SiEntro = false;
                        $arr0 = User::getUsernameNext('CIU');
                        $username = $arr0['username'];
                        $password = bcrypt($username);
                    }
                    $Item = [
                        'curp'              => strtoupper(trim($curp)),
                        'username'          => $username,
                        'password'          => $password,
                        'email'             => strtolower(trim($username))."@mail.com",
                        'ap_paterno'        => strtoupper(trim($ap_paterno)),
                        'ap_materno'        => strtoupper(trim($ap_materno)),
                        'nombre'            => strtoupper(trim($nombre)),
                        'fecha_nacimiento'  => $fecha_nacimiento,
                        'genero'            => $genero,
                        'empresa_id'        => config('atemun.empresa_id'),
                        'imagen_id'         => 0,
                        'email_verified_at' => now(),
                    ];

                    if ( is_object($Ubi)  ) {
                        $User = User::create($Item);
                        $User->update(['ubicacion_id'=>$Ubi->id,'imagen_id'=>0]);
                        $User->ubicaciones()->attach($Ubi);
                        $User->permissions()->attach(7); // Consultar
                        $User->roles()->attach(11); // Ciudadano
                        $User->roles()->attach(12); // Ciudadano Internet
                        $User->user_adress()->create([
                            'calle'     => "",
                            'num_ext'   => "",
                            'num_int'   => "",
                            'colonia'   => "",
                            'localidad' => "",
                            'municipio' => "",
                            'estado'    => "",
                            'pais'      => "",
                            'cp'        => "",

                        ]);
                        $User->user_adress()->update([
                            'calle'     => is_null($Ubi->calle) ? "" : $Ubi->calle,
                            'num_ext'   => $Ubi->num_ext ?? "",
                            'num_int'   => $Ubi->num_int ?? "",
                            'colonia'   => is_null($Ubi->colonia) ? "" : $Ubi->colonia,
                            'localidad' => is_null($Ubi->comunidad) ? "" : $Ubi->comunidad,
                            'municipio' => is_null($Ubi->municipio) ? "" : $Ubi->municipio,
                            'estado'    => is_null($Ubi->estado) ? "" : $Ubi->estado,
                            'pais'      => is_null($Ubi->pais) ? "" : $Ubi->pais,
                            'cp'        => is_null($Ubi->cp) ? "" : $Ubi->cp,
                        ]);
                        $User->user_data_extend()->create([
                            'lugar_nacimiento' => "",
                            'ocupacion'        => "",
                            'profesion'        => "",
                            'lugar_trabajo'    => "",
                        ]);
                        $F->validImage($User,'profile','profile/');
                    }

                    Log::alert('Registro Núm: '.$x);

            }catch (QueryException $e){
                Log::alert("Error en :: ".$user_mid_id. ' => '.$e->getMessage());
                continue;
            }catch (Exception $e){
                Log::alert("Error en ".$user_mid_id. ' => '.$e->getMessage());
                continue;
            }
        }

    }
}
