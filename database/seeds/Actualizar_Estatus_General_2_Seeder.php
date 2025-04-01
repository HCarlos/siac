<?php

use App\Classes\Denuncia\ActualizaEstadisticasARO;
use App\Models\Denuncias\Denuncia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class Actualizar_Estatus_General_2_Seeder extends Seeder
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

        $dens = Denuncia::query()
            ->select('id')
        ->where('id', 103917)
            ->orderByDesc('id')
            ->get();


        $vid = new ActualizaEstadisticasARO();

        foreach ($dens as $den) {
            try {
                $vid->ActualizaEstadisticasARO($den->id);
            }catch (\Exception $e) {
                Log::alert("Evento error: ".$e->getMessage());
                continue;
            }
        }
    }


}
