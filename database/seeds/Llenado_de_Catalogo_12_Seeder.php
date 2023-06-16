<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class Llenado_de_Catalogo_12_Seeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        Permission::create(['name'=>'seleccionar_hashtag', 'descripcion'=>'Seleccionar #Hashtags',    'color'=>'#7986cb','guard_name'=>'web']);

    }

}
