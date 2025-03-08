<?php

use App\Models\Denuncias\Denuncia;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class AgregarColoniaIdADenunciasSeeder extends Seeder
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

        /* ************************************************************************************************
                //SUBIMOS DEPENDENCIAS
        ************************************************************************************************** */
        $file = 'public/csv/export_data_colonias.csv';
        $json_data = file_get_contents($file);
        $json_data = preg_split( "/\n/", $json_data );

        for ($x = 0, $xMax = count($json_data); $x < $xMax; $x++){
            try{

                $dupla = preg_split("/\t/", $json_data[$x], -1, PREG_SPLIT_NO_EMPTY);
                $arr = str_getcsv($dupla[0]);

                $denuncia_id          = (int)$arr[0];
                $centro_localidad_id  = (int)$arr[1];

                if ($denuncia_id > 0 || $centro_localidad_id > 0) {
                    $den = Denuncia::find($denuncia_id);
                    if ($den) {
                        $den->centro_localidad_id = $centro_localidad_id;
                        $den->save();
                    }else{
                        continue;
                    }
                    Log::alert('Registro Núm: '.$denuncia_id);
                }

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
