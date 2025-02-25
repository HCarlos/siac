<?php

use App\Models\Catalogos\CentroLocalidad;
use Illuminate\Database\Seeder;

class LocalidadesMunicipioCentroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        CentroLocalidad::create(['consecutivo' => 1, 'zona_id' => 1,'zona' => 'Zona 1', 'delegacion_id' => 1,'prefijo_delegacion' => 'FRACC','delegacion' => 'Francisco Villa', 'colonia_id' => 1,'prefijo_colonia' => 'COL','colonia' => 'Guadalupe Borja', 'delegado_id' => 1]);

    }
}
