<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        $Catalogos = config('atemun.table_names.catalogos');
        if (Schema::hasTable($Catalogos['servicios'])) {
            Schema::table($Catalogos['servicios'], function (Blueprint $table) use ($Catalogos) {
                $table->string('ambito_servicio',50)->default('')->comment('RURAL, URBANO');
            });
        }

        $Catalogos = config('atemun.table_names.domicilios');
        if (Schema::hasTable($Catalogos['comunidades'])) {
            Schema::table($Catalogos['comunidades'], function (Blueprint $table) use ($Catalogos) {
                $table->string('ambito_comunidad',50)->default('')->comment('RURAL, URBANO');
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
        if (Schema::hasTable($Catalogos['servicios'])) {
            Schema::table($Catalogos['servicios'], function (Blueprint $table) use ($Catalogos) {
                $table->dropColumn('ambito_servicio');
            });
        }

        $Catalogos = config('atemun.table_names.domicilios');
        if (Schema::hasTable($Catalogos['comunidades'])) {
            Schema::table($Catalogos['comunidades'], function (Blueprint $table) use ($Catalogos) {
                $table->dropColumn('ambito_comunidad');
            });
        }

    }
}
