<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class ActualizacionUsuarioUbicacionImagenIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        @ini_set( 'upload_max_size' , '32768M' );
        @ini_set( 'post_max_size', '32768M');
        @ini_set( 'max_execution_time', '256000000' );
        @ini_set('memory_limit', '-1');

            $Users = User::all()->sortBy('id')->take(50);
            foreach ($Users as $User){
                try {
                $ubicacion    = $User->ubicaciones->first();
                $ubicacion_id = $ubicacion->id ?? 0;
                $imagen       = $User->imagenes->first();
                $imagen_id    = $imagen->id ?? 0;
                $User->update(['ubicacion_id'=>$ubicacion_id,'imagen_id'=>$imagen_id]);

                Log::alert('ID User: '.$User->id);

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
