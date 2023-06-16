<?php

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class Llenado_de_Catalogo_04_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        $P7 = Permission::findByName('consultar');
        Role::create(['name'=>'USER_SAS_CAP','descripcion'=>'Usuario Capturista de SAS','abreviatura'=>'USC','guard_name'=>'web'])->permissions()->attach($P7);
        Role::create(['name'=>'USER_SAS_ADMIN','descripcion'=>'Usuario Administrador de SAS del SIAC','abreviatura'=>'USA','guard_name'=>'web'])->permissions()->attach($P7);

    }
}
