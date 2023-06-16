<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class Llenado_de_Catalogo_13_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        Permission::create(['name'=>'asignar_permisos', 'descripcion'=>'El Usuario puede asiganar permisos',    'color'=>'#7986cb','guard_name'=>'web']);
        Permission::create(['name'=>'asignar_roles', 'descripcion'=>'El Usuario puede asiganar roles',    'color'=>'#7986cb','guard_name'=>'web']);
        Permission::create(['name'=>'asignar_dependencias', 'descripcion'=>'El Usuario puede asiganar dependencias',    'color'=>'#7986cb','guard_name'=>'web']);

    }
}
