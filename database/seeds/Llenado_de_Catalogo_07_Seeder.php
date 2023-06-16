<?php

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class Llenado_de_Catalogo_07_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        $P7 = Permission::findByName('consultar');

        Role::create(['name'=>'USER_DIF_CAP','descripcion'=>'Usuario Capturista de DIF','abreviatura'=>'UDC','guard_name'=>'web'])->permissions()->attach($P7);

        Role::create(['name'=>'USER_DIF_ADMIN','descripcion'=>'Usuario Administrador de DIF del SIAC','abreviatura'=>'UDA','guard_name'=>'web'])->permissions()->attach($P7);

    }
}
