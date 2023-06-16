<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Llenado_de_Catalogo_09_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        Permission::create(['name'=>'guardar_respuesta', 'descripcion'=>'Guarda una respuesta','color'=>'#7986cb','guard_name'=>'web']);
    }
}
