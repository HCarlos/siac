<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterServicio3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        $Catalogos  = config('atemun.table_names.catalogos');
        if (Schema::hasTable($Catalogos['servicios'])) {
            Schema::table($Catalogos['servicios'], function (Blueprint $table) {
                $table->float('promedio_dias_rechazada', 10,5)->default(0.00)->comment('Los días promedios en ser rechazada');
                $table->float('promedio_dias_observada', 10,5)->default(0.00)->comment('Los días promedios en ser observada');
            });
        }

        if (Schema::hasTable($Catalogos['denuncias'])) {
            Schema::table($Catalogos['denuncias'], function (Blueprint $table) {
                $table->integer('dias_rechazada')->default(0)->comment('Los dias que se tardó en ser rechazada');
                $table->integer('dias_observada')->default(0)->comment('Los dias que se tardó en ser observada');
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
        if (Schema::hasTable($Catalogos['servicios'])) {
            Schema::table($Catalogos['servicios'], function (Blueprint $table) {
                $table->dropColumn('promedio_dias_rechazada');
                $table->dropColumn('promedio_dias_observada');
            });
        }

        if (Schema::hasTable($Catalogos['denuncias'])) {
            Schema::table($Catalogos['denuncias'], function (Blueprint $table) {
                $table->dropColumn('dias_rechazada');
                $table->dropColumn('dias_observada');
            });
        }

    }
}
