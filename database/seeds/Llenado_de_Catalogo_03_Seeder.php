<?php

use App\Models\Denuncias\Denuncia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;


class Llenado_de_Catalogo_03_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

//        @ini_set( 'upload_max_size' , '32768M' );
//        @ini_set( 'post_max_size', '32768M');
//        @ini_set( 'max_execution_time', '256000000' );
//        @ini_set('memory_limit', '-1');
//
        $Denuncias = Denuncia::all();

        foreach ($Denuncias as $Den){
            try{
                $Den->ciudadanos()->attach($Den->ciudadano_id);

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
