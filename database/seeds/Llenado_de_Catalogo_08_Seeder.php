<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Llenado_de_Catalogo_08_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $P7 = Permission::findByName('consultar');
        Role::create(['name'=>'USER_DOOTSM_CAP','descripcion'=>'Usuario Capturista de DOOTSM','abreviatura'=>'UDOOC','guard_name'=>'web'])->permissions()->attach($P7);
        Role::create(['name'=>'USER_DOOTSM_ADMIN','descripcion'=>'Usuario Administrador de DOOTSM del SIAC','abreviatura'=>'UDOOA','guard_name'=>'web'])->permissions()->attach($P7);
        Permission::create(['name'=>'cerrar_expediente', 'descripcion'=>'Cierra un expediente archivisticamente',    'color'=>'#7986cb','guard_name'=>'web']);
        Permission::create(['name'=>'eliminar_respuesta', 'descripcion'=>'Puede eliminar una respuesta','color'=>'#7986cb','guard_name'=>'web']);
        Permission::create(['name'=>'guardar_expediente', 'descripcion'=>'Guarda una orden ó expediente','color'=>'#7986cb','guard_name'=>'web']);
        Permission::create(['name'=>'eliminar_expediente', 'descripcion'=>'Elimina una orden ó expediente','color'=>'#7986cb','guard_name'=>'web']);
        Permission::create(['name'=>'modificar_expediente', 'descripcion'=>'Modifica una orden ó expediente','color'=>'#7986cb','guard_name'=>'web']);
    }
}
