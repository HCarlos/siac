<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterServicio1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        $Catalogos  = config('atemun.table_names.catalogos');
        if (Schema::hasTable($Catalogos['servicios'])) {
            Schema::table($Catalogos['servicios'], function (Blueprint $table) use ($Catalogos) {
                $table->integer('dias_ejecucion')->default(0)->comment('Los días que se tardará en ejecutar dicho servicio');
                $table->integer('dias_maximos_ejecucion')->default(0)->comment('Los días máximos que se tardará en ejecutar dicho servicio');
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
            Schema::table($Catalogos['servicios'], function (Blueprint $table) use ($Catalogos) {
                $table->dropColumn('dias_ejecucion');
                $table->dropColumn('dias_maximos_ejecucion');
            });
        }
    }
}
