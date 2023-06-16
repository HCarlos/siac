<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Llenado_de_Catalogo_05_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

//        $P7 = Permission::findByName('consultar');
//        Role::create(['name'=>'USER_SAS_CAP','descripcion'=>'Usuario Capturista de SAS','abreviatura'=>'USC','guard_name'=>'web'])->permissions()->attach($P7);
//        Role::create(['name'=>'USER_SAS_ADMIN','descripcion'=>'Usuario Administrador de SAS del SIAC','abreviatura'=>'USA','guard_name'=>'web'])->permissions()->attach($P7);

        Permission::create(['name'=>'csd_sas', 'descripcion'=>'crea una denuncia de SAS',    'color'=>'#7986cb','guard_name'=>'web']);
        Permission::create(['name'=>'rsd_sas', 'descripcion'=>'responde una denuncia de SAS','color'=>'#7986cb','guard_name'=>'web']);

    }
}
