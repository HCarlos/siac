<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Agregar_Permisos_Seeder_01 extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $P0= Permission::create(['name' => 'unificar', 'descripcion' => 'unificar valores de algunos catálogos']);
    }
}
