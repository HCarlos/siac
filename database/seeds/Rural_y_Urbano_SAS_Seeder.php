<?php

use Illuminate\Database\Seeder;
use App\Models\Catalogos\CentroLocalidad;

class Rural_y_Urbano_SAS_Seeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        $file = 'public/csv/delegaciones_sas.csv';
        $json_data = file_get_contents($file);
        $json_data = preg_split( "/\n/", $json_data );

        for ($x = 1, $xMax = count($json_data); $x < $xMax; $x++){
            try{

                $dupla = preg_split("/\t/", $json_data[$x], -1, PREG_SPLIT_NO_EMPTY);
                $arr = str_getcsv($dupla[0]);
                if (count($arr) > 1){
                    $id = (int)$arr[0];
                    $zona_id = (int)$arr[1];
                    $zona="RURAL";
                    if ($zona_id == 2){
                        $zona="URBANO";

                    }
                    CentroLocalidad::where('id', $id)
                    ->update(['zona' => $zona, 'zona_id' => $zona_id ]);
                }
            } catch (Exception $e){
                echo "Error en la linea: " . $x.' - '.$zona . " del archivo CSV";
            }
        }


    }
}
