<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDdse1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        $Catalogos  = config('atemun.table_names.catalogos');
        if (Schema::hasTable($Catalogos['denuncia_dependencia_servicio_estatus'])) {
            Schema::table($Catalogos['denuncia_dependencia_servicio_estatus'], function (Blueprint $table) use ($Catalogos) {
                $table->boolean('fue_leida')->default(true)->comment('Evalúa si ya fue leida por el área correspondiente.');
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

        if (Schema::hasTable($Catalogos['denuncia_dependencia_servicio_estatus'])) {
            Schema::table($Catalogos['denuncia_dependencia_servicio_estatus'], function (Blueprint $table) use ($Catalogos) {
                $table->dropColumn('fue_leida');
            });
        }


    }
}
