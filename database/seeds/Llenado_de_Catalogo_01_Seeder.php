<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Llenado_de_Catalogo_01_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $P7 = Permission::findByName('consultar');

        Role::create(['name'=>'USER_OPERATOR_SIAC','descripcion'=>'Usuario Operador del SIAC','abreviatura'=>'UOS','guard_name'=>'web'])->permissions()->attach($P7);
        Role::create(['name'=>'USER_OPERATOR_ADMIN','descripcion'=>'Usuario Administrador del SIAC','abreviatura'=>'UAS','guard_name'=>'web'])->permissions()->attach($P7);

    }
}
