<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Llenado_de_Servicios_Mobile_02_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        $P7 = Permission::findByName('consultar');

        Role::create(['name'=>'USER_MOBILE_BASIC','descripcion'=>'Acceso a la versión mobile básica','abreviatura'=>'AVMB','guard_name'=>'web'])->permissions()->attach($P7);
        Role::create(['name'=>'USER_MOBILE_ADMIN','descripcion'=>'Acceso a la versión mobile admin','abreviatura'=>'AVMA','guard_name'=>'web'])->permissions()->attach($P7);

        Permission::create(['name'=>'mobile_consulta', 'descripcion'=>'Puede ver solicitudes vía Mobile.',    'color'=>'#7986fb','guard_name'=>'web']);
        Permission::create(['name'=>'mobile_responder', 'descripcion'=>'Puede responder solicitudes vía Mobile.',    'color'=>'#7986gb','guard_name'=>'web']);
        Permission::create(['name'=>'mobile_reporte_basico', 'descripcion'=>'Puede ver reportes de solicitudes vía Mobile.',    'color'=>'#7686cb','guard_name'=>'web']);

    }
}
