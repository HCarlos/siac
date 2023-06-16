<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddColumnUnificadoraVariousTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        $Domicilios = config('atemun.table_names.domicilios');


        if (Schema::hasTable($Domicilios['comunidades'])) {
            Schema::table($Domicilios['comunidades'], function (Blueprint $table) use ($Domicilios) {
                $table->boolean('is_unificadora')->default(false)->index('comunidades_is_unificadora_index')->comment('Es una clave que permite, unificar varios registros de la misma tabla e indentifica.');
            });
        }


        if (Schema::hasTable($Domicilios['colonias'])) {
            Schema::table($Domicilios['colonias'], function (Blueprint $table) use ($Domicilios) {
                $table->boolean('is_unificadora')->default(false)->index('colonias_is_unificadora_index')->comment('Es una clave que permite, unificar varios registros de la misma tabla e indentifica.');
            });
        }

        if (Schema::hasTable($Domicilios['calles'])) {
            Schema::table($Domicilios['calles'], function (Blueprint $table) use ($Domicilios) {
                $table->boolean('is_unificadora')->default(false)->index('calles_is_unificadora_index')->comment('Es una clave que permite, unificar varios registros de la misma tabla e indentifica.');
            });
        }



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){

        $Domicilios = config('atemun.table_names.domicilios');

        if (Schema::hasTable($Domicilios['comunidades'])) {
            Schema::table($Domicilios['comunidades'], function (Blueprint $table) use ($Domicilios) {
                $table->dropIndex('comunidades_is_unificadora_index');
                $table->dropColumn('is_unificadora');
            });
        }

        if (Schema::hasTable($Domicilios['colonias'])) {
            Schema::table($Domicilios['colonias'], function (Blueprint $table) use ($Domicilios) {
                $table->dropIndex('colonias_is_unificadora_index');
                $table->dropColumn('is_unificadora');
            });
        }

        if (Schema::hasTable($Domicilios['calles'])) {
            Schema::table($Domicilios['calles'], function (Blueprint $table) use ($Domicilios) {
                $table->dropIndex('calles_is_unificadora_index');
                $table->dropColumn('is_unificadora');
            });
        }



    }
}
