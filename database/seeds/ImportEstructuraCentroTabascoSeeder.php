<?php

use App\Models\Catalogos\Area;
use App\Models\Catalogos\Dependencia;
use App\Models\Catalogos\Servicio;
use App\Models\Catalogos\Subarea;
use Illuminate\Database\Seeder;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class ImportEstructuraCentroTabascoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        @ini_set( 'upload_max_size' , '32768M' );
        @ini_set( 'post_max_size', '32768M');
        @ini_set( 'max_execution_time', '256000000' );
        @ini_set('memory_limit', '-1');

        Dependencia::query()->truncate();
        Area::query()->truncate();
        Subarea::query()->truncate();
        Servicio::query()->truncate();

/* ************************************************************************************************
        //SUBIMOS DEPENDENCIAS
************************************************************************************************** */
        $file = 'public/csv/dependencias.csv';
        $json_data = file_get_contents($file);
        $json_data = preg_split( "/\n/", $json_data );

        for ($x = 0; $x < count($json_data); $x++){
            try{

                $dupla = preg_split("/\t/", $json_data[$x], -1, PREG_SPLIT_NO_EMPTY);
                $arr = str_getcsv($dupla[0]);

                $dep_id  = trim($arr[0]) == "" ? 0 : intval($arr[0]);
                $depend  = trim($arr[1]) == "" ? 0 : strtoupper(trim(utf8_encode($arr[1])));
                $abre    = trim($arr[2]) == "" ? 0 : strtoupper(trim(utf8_encode($arr[2])));

                Dependencia::create(['id'=>$dep_id,'dependencia'=>$depend,'abreviatura'=>$abre,'is_areas'=>false,'jefe_id'=>1,'user_id'=>1]);

                Log::alert('Registro Núm: '.$x);

            }catch (QueryException $e){
                Log::alert("Error en :: ".$e->getMessage());
                continue;
            }catch (Exception $e){
                Log::alert("Error en ".$e->getMessage());
                continue;
            }
        }


        /* ************************************************************************************************
                //SUBIMOS areas
        ************************************************************************************************** */
        $file = 'public/csv/areas.csv';
        $json_data = file_get_contents($file);
        $json_data = preg_split( "/\n/", $json_data );

        for ($x = 0; $x < count($json_data); $x++){
            try{

                $dupla = preg_split("/\t/", $json_data[$x], -1, PREG_SPLIT_NO_EMPTY);
                $arr = str_getcsv($dupla[0]);

                $dependencia_id = trim($arr[0]) == "" ? 0 : intval($arr[0]);
                $area_id        = trim($arr[1]) == "" ? 0 : intval($arr[1]);
                $area           = trim($arr[2]) == "" ? 0 : strtoupper(trim(utf8_encode($arr[2])));

                $Area = Area::create(['id'=>$area_id,'area'=>$area,'dependencia_id'=>$dependencia_id,'jefe_id'=>1]);

                $Area->dependencias()->attach($dependencia_id);
                $Area->jefes()->attach(1);

                Log::alert('Registro Núm: '.$x);

            }catch (QueryException $e){
                Log::alert("Error en :: ".$e->getMessage());
                continue;
            }catch (Exception $e){
                Log::alert("Error en ".$e->getMessage());
                continue;
            }
        }


        /* ************************************************************************************************
                //SUBIMOS subareas
        ************************************************************************************************** */
        $file = 'public/csv/subareas.csv';
        $json_data = file_get_contents($file);
        $json_data = preg_split( "/\n/", $json_data );

        for ($x = 0; $x < count($json_data); $x++){
            try{

                $dupla = preg_split("/\t/", $json_data[$x], -1, PREG_SPLIT_NO_EMPTY);
                $arr = str_getcsv($dupla[0]);

                $dependencia_id = trim($arr[0]) == "" ? 0 : intval($arr[0]);
                $area_id        = trim($arr[1]) == "" ? 0 : intval($arr[1]);
                $subarea_id     = trim($arr[2]) == "" ? 0 : intval($arr[2]);
                $subarea        = trim($arr[3]) == "" ? 0 : strtoupper(trim(utf8_encode($arr[3])));

                $Subarea = Subarea::create(['id'=>$subarea_id,'subarea'=>$subarea,'area_id'=>$area_id,'jefe_id'=>1]);

                $Subarea->areas()->attach($area_id);

                Log::alert('Registro Núm: '.$x);

            }catch (QueryException $e){
                Log::alert("Error en :: ".$e->getMessage());
                continue;
            }catch (Exception $e){
                Log::alert("Error en ".$e->getMessage());
                continue;
            }
        }




        /* ************************************************************************************************
                //SUBIMOS subareas
        ************************************************************************************************** */
        $file = 'public/csv/servicios.csv';
        $json_data = file_get_contents($file);
        $json_data = preg_split( "/\n/", $json_data );

        for ($x = 0; $x < count($json_data); $x++){
            try{

                $dupla = preg_split("/\t/", $json_data[$x], -1, PREG_SPLIT_NO_EMPTY);
                $arr = str_getcsv($dupla[0]);

                $dependencia_id = trim($arr[0]) == "" ? 0 : intval($arr[0]);
                $area_id        = trim($arr[1]) == "" ? 0 : intval($arr[1]);
                $subarea_id     = trim($arr[2]) == "" ? 0 : intval($arr[2]);
                $servicio_id    = trim($arr[3]) == "" ? 0 : intval($arr[3]);
                $servicio       = trim($arr[4]) == "" ? 0 : strtoupper(trim(utf8_encode($arr[4])));
//                'id', 'servicio','habilitado', 'medida_id', 'subarea_id',
                $Servicio = Servicio::create(['id'=>$servicio_id,'servicio'=>$servicio,'subarea_id'=>$subarea_id, 'medida_id'=>1]);
                $Servicio->subareas()->attach($subarea_id);
                Log::alert('Registro Núm: '.$x);

            }catch (QueryException $e){
                Log::alert("Error en :: ".$e->getMessage());
                continue;
            }catch (Exception $e){
                Log::alert("Error en ".$e->getMessage());
                continue;
            }
        }




    }
}
