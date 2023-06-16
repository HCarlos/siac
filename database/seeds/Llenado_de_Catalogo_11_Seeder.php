<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Llenado_de_Catalogo_11_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $P7 = Permission::findByName('consultar');
        Role::create(['name'=>'USER_CMI_COORD','descripcion'=>'Coordinación de Modernización','abreviatura'=>'CMI','guard_name'=>'web'])->permissions()->attach($P7);
        Permission::create(['name'=>'exportar_reporte_a_excel', 'descripcion'=>'Exportar reporte a Excel',    'color'=>'#7986cb','guard_name'=>'web']);
        Permission::create(['name'=>'buscar_usuario', 'descripcion'=>'Buscar a usuarios',    'color'=>'#7986cb','guard_name'=>'web']);
        Permission::create(['name'=>'agregar_usuario', 'descripcion'=>'Agregar usuario',    'color'=>'#7986cb','guard_name'=>'web']);
        Permission::create(['name'=>'editar_usuario', 'descripcion'=>'Editar usuario',    'color'=>'#7986cb','guard_name'=>'web']);
        Permission::create(['name'=>'quitar_usuario', 'descripcion'=>'Quitar usuario',    'color'=>'#7986cb','guard_name'=>'web']);
        Permission::create(['name'=>'consultar_roles', 'descripcion'=>'Consultar roles',    'color'=>'#7986cb','guard_name'=>'web']);
    }
}
