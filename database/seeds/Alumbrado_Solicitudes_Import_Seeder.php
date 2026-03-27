<?php

use Illuminate\Database\Seeder;

class Alumbrado_Solicitudes_Import_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        $file = 'public/csv/alumbrado_import.csv';
        $json_data = file_get_contents($file);
        $json_data = preg_split( "/\n/", $json_data );

        for ($x = 1, $xMax = count($json_data); $x < $xMax; $x++){
            try{

                $dupla = preg_split("/\t/", $json_data[$x], -1, PREG_SPLIT_NO_EMPTY);
                $arr = str_getcsv($dupla[0]);
                if (count($arr) > 1){
                    $ciudadano_id = (int)$arr[0];
                    $calle_y_num = $arr[1];
                    $centro_localidad = trim($arr[2]);
                    $centro_localidad_id = (int)$arr[3];
                    $codigo_postal = 86035;
                    $latitud = (float)$arr[5];
                    $longitud = (float)$arr[6];
                    $servicio_id = (float)$arr[8];
                    $cantidad = (float)$arr[9];

                    dd( $ciudadano_id.', '.$calle_y_num.', '.$centro_localidad_id.', '.$codigo_postal.', '.$latitud.', '.$longitud.', '.$servicio_id.', '.$cantidad );


                }
            } catch (Exception $e){
                echo "Error en la linea: " . $x . " del archivo CSV";
            }
        }



    }
}
