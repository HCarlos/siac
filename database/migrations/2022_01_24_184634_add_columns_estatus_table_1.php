<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsEstatusTable1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        $Catalogos = config('atemun.table_names.catalogos');
        if (Schema::hasTable($Catalogos['estatus'])) {
            Schema::table($Catalogos['estatus'], function (Blueprint $table) use ($Catalogos) {
                $table->string('abreviatura',10)->default('');
                $table->integer('orden_impresion')->default(0);
            });
        }

        if (Schema::hasTable($Catalogos['dependencias'])) {
            Schema::table($Catalogos['dependencias'], function (Blueprint $table) use ($Catalogos) {
                $table->integer('orden_impresion')->default(0);
            });
        }

        if (Schema::hasTable($Catalogos['areas'])) {
            Schema::table($Catalogos['areas'], function (Blueprint $table) use ($Catalogos) {
                $table->string('abreviatura',10)->default('');
                $table->integer('orden_impresion')->default(0);
            });
        }

        if (Schema::hasTable($Catalogos['subareas'])) {
            Schema::table($Catalogos['subareas'], function (Blueprint $table) use ($Catalogos) {
                $table->string('abreviatura',10)->default('');
                $table->integer('orden_impresion')->default(0);
            });
        }

        if (Schema::hasTable($Catalogos['servicios'])) {
            Schema::table($Catalogos['servicios'], function (Blueprint $table) use ($Catalogos) {
                $table->integer('orden_impresion')->default(0);
            });
        }


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){

        $Catalogos = config('atemun.table_names.catalogos');

        if (Schema::hasTable($Catalogos['estatus'])) {
            Schema::table($Catalogos['estatus'], function (Blueprint $table)  {
                $table->dropColumn('abreviatura');
                $table->dropColumn('orden_impresion');
            });
        }

        if (Schema::hasTable($Catalogos['dependencias'])) {
            Schema::table($Catalogos['dependencias'], function (Blueprint $table)  {
                $table->dropColumn('orden_impresion');
            });
        }

        if (Schema::hasTable($Catalogos['areas'])) {
            Schema::table($Catalogos['areas'], function (Blueprint $table)  {
                $table->dropColumn('abreviatura');
                $table->dropColumn('orden_impresion');
            });
        }
        if (Schema::hasTable($Catalogos['subareas'])) {
            Schema::table($Catalogos['subareas'], function (Blueprint $table)  {
                $table->dropColumn('abreviatura');
                $table->dropColumn('orden_impresion');
            });
        }

        if (Schema::hasTable($Catalogos['servicios'])) {
            Schema::table($Catalogos['servicios'], function (Blueprint $table)  {
                $table->dropColumn('orden_impresion');
            });
        }


    }
}
