<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Llenado_de_Catalogo_10_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        Permission::create(['name'=>'buscar_solo_en_su_ámbito', 'descripcion'=>'Busca solo donde es Enlace','color'=>'#7986cb','guard_name'=>'web']);
    }
}
