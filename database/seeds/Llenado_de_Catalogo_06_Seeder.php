<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class Llenado_de_Catalogo_06_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        Permission::create(['name'=>'elimina_denuncia_general', 'descripcion'=>'puede eliminar cualquier denuncia',    'color'=>'#7986cb','guard_name'=>'web']);
        Permission::create(['name'=>'consulta_500_items_general', 'descripcion'=>'puede consultar hasta 500 items general','color'=>'#7986cb','guard_name'=>'web']);
    }
}
