<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDependencia1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        $Catalogos  = config('atemun.table_names.catalogos');

        if (Schema::hasTable($Catalogos['dependencias'])) {
            Schema::table($Catalogos['dependencias'], function (Blueprint $table) use ($Catalogos) {
                $table->integer('ambito_dependencia')->default(1)->nullable()->index()->comment('1 = Apoyos Socialies, 2 = Servicios Municipales, 3 = Otros');
            });
        }

        if (Schema::hasTable($Catalogos['servicios'])) {
            Schema::table($Catalogos['servicios'], function (Blueprint $table) use ($Catalogos) {
                $table->string('nombre_corto_ss',100)->default("")->comment('Nombre corto para estadisticos');
                $table->integer('nombre_corto_orden_ss')->default(0)->nullable()->index();
                $table->boolean('is_visible_nombre_corto_ss')->default(false);
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
        if (Schema::hasTable($Catalogos['dependencias'])) {
            Schema::table($Catalogos['dependencias'], function (Blueprint $table) use ($Catalogos) {
                $table->dropColumn('ambito_dependencia');
            });
        }
        if (Schema::hasTable($Catalogos['servicios'])) {
            Schema::table($Catalogos['servicios'], function (Blueprint $table) use ($Catalogos) {
                $table->dropColumn('nombre_corto_ss');
                $table->dropColumn('nombre_corto_orden_ss');
                $table->dropColumn('is_visible_nombre_corto_ss');
            });
        }
    }
}
