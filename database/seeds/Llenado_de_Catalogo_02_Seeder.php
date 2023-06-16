<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Llenado_de_Catalogo_02_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        $P7 = Permission::findByName('consultar');
        Role::create(['name'=>'USER_ARCHIVO_CAP','descripcion'=>'Usuario Capturista de Archivo','abreviatura'=>'UAC','guard_name'=>'web'])->permissions()->attach($P7);
        Role::create(['name'=>'USER_ARCHIVO_ADMIN','descripcion'=>'Usuario Administrador de Archivo del SIAC','abreviatura'=>'UAA','guard_name'=>'web'])->permissions()->attach($P7);

    }

}
