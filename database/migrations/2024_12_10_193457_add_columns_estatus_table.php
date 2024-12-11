<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsEstatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        $tableNames = config('atemun.table_names.catalogos');

        if (Schema::hasTable($tableNames['estatus'])) {
            Schema::table($tableNames['estatus'], function (Blueprint $table) use ($tableNames) {
                $table->boolean('requiere_imagen')->default(false)->comment("Pregunta si es necesario agregar una imagen");
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){

        $Catalogos  = config('atemun.table_names.catalogos');

        if (Schema::hasTable($Catalogos['estatus'])) {
            Schema::table($Catalogos['estatus'], function (Blueprint $table) use ($Catalogos) {
                $table->dropColumn('requiere_imagen');
            });
        }


    }
}
