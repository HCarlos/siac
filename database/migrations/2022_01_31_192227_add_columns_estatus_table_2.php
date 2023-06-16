<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsEstatusTable2 extends Migration{


    public function up(){

        $Catalogos = config('atemun.table_names.catalogos');
        if (Schema::hasTable($Catalogos['estatus'])) {
            Schema::table($Catalogos['estatus'], function (Blueprint $table) use ($Catalogos) {
                $table->tinyInteger('estatus_cve')->default(1)->comment('0 = Inactivo, 1 = Activo, 2 = Suspendido, 3 = Cancelado');
            });
        }

        if (Schema::hasTable($Catalogos['dependencias'])) {
            Schema::table($Catalogos['dependencias'], function (Blueprint $table) use ($Catalogos) {
                $table->tinyInteger('estatus_cve')->default(1)->comment('0 = Inactivo, 1 = Activo, 2 = Suspendido, 3 = Cancelado');
            });
        }

        if (Schema::hasTable($Catalogos['areas'])) {
            Schema::table($Catalogos['areas'], function (Blueprint $table) use ($Catalogos) {
                $table->tinyInteger('estatus_cve')->default(1)->comment('0 = Inactivo, 1 = Activo, 2 = Suspendido, 3 = Cancelado');
            });
        }

        if (Schema::hasTable($Catalogos['subareas'])) {
            Schema::table($Catalogos['subareas'], function (Blueprint $table) use ($Catalogos) {
                $table->tinyInteger('estatus_cve')->default(1)->comment('0 = Inactivo, 1 = Activo, 2 = Suspendido, 3 = Cancelado');
            });
        }

        if (Schema::hasTable($Catalogos['servicios'])) {
            Schema::table($Catalogos['servicios'], function (Blueprint $table) use ($Catalogos) {
                $table->tinyInteger('estatus_cve')->default(1)->comment('0 = Inactivo, 1 = Activo, 2 = Suspendido, 3 = Cancelado');
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
                $table->dropColumn('estatus_cve');
            });
        }

        if (Schema::hasTable($Catalogos['dependencias'])) {
            Schema::table($Catalogos['dependencias'], function (Blueprint $table)  {
                $table->dropColumn('estatus_cve');
            });
        }

        if (Schema::hasTable($Catalogos['areas'])) {
            Schema::table($Catalogos['areas'], function (Blueprint $table)  {
                $table->dropColumn('estatus_cve');
            });
        }
        if (Schema::hasTable($Catalogos['subareas'])) {
            Schema::table($Catalogos['subareas'], function (Blueprint $table)  {
                $table->dropColumn('estatus_cve');
            });
        }

        if (Schema::hasTable($Catalogos['servicios'])) {
            Schema::table($Catalogos['servicios'], function (Blueprint $table)  {
                $table->dropColumn('estatus_cve');
            });
        }


    }


}
