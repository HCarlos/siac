<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsDomiciliosTable1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        $Domicilios = config('atemun.table_names.domicilios');
        $Catalogos  = config('atemun.table_names.catalogos');

        if (Schema::hasTable($Catalogos['denuncias'])) {
            Schema::table($Catalogos['denuncias'], function (Blueprint $table) use ($Catalogos) {
                $table->string('folio_sas',50)->default("")->comment('Se refiere folio interno de SAS');
                $table->boolean('favorable')->default(false)->comment('Evalua si al cerrar, fue favorable o no');
            });
        }

        if (Schema::hasTable($Domicilios['comunidades'])) {
            Schema::table($Domicilios['comunidades'], function (Blueprint $table) use ($Domicilios) {
                $table->string('nomenclatura',25)->default("")->comment('Se refiere el tipo de comunidad que contiene');
            });
        }
        if (Schema::hasTable($Domicilios['colonias'])) {
            Schema::table($Domicilios['colonias'], function (Blueprint $table) use ($Domicilios) {
                $table->string('nomenclatura',25)->default("")->comment('Se refiere el tipo de comunidad que contiene');
            });
        }
        if (Schema::hasTable($Domicilios['tipocomunidades'])) {
            Schema::table($Domicilios['tipocomunidades'], function (Blueprint $table) use ($Domicilios) {
                $table->string('nomenclatura',25)->default("")->comment('Se refiere el tipo de comunidad que contiene');
            });
        }
        if (Schema::hasTable($Domicilios['tipoasentamientos'])) {
            Schema::table($Domicilios['tipoasentamientos'], function (Blueprint $table) use ($Domicilios) {
                $table->string('nomenclatura',25)->default("")->comment('Se refiere el tipo de comunidad que contiene');
            });
        }
        if (Schema::hasTable($Domicilios['asentamientos'])) {
            Schema::table($Domicilios['asentamientos'], function (Blueprint $table) use ($Domicilios) {
                $table->string('nomenclatura',25)->default("")->comment('Se refiere el tipo de comunidad que contiene');
            });
        }

        if (Schema::hasTable($Catalogos['denuncia_dependencia_servicio_estatus'])) {
            Schema::table($Catalogos['denuncia_dependencia_servicio_estatus'], function (Blueprint $table) use ($Catalogos) {
                $table->boolean('favorable')->default(false)->comment('Evalua si al cerrar, fue favorable o no');
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
        $Catalogos  = config('atemun.table_names.catalogos');

        if (Schema::hasTable($Catalogos['denuncias'])) {
            Schema::table($Catalogos['denuncias'], function (Blueprint $table) use ($Catalogos) {
                $table->dropColumn('folio_sas');
                $table->dropColumn('favorable');
            });
        }

        if (Schema::hasTable($Domicilios['comunidades'])) {
            Schema::table($Domicilios['comunidades'], function (Blueprint $table)  {
                $table->dropColumn('nomenclatura');
            });
        }

        if (Schema::hasTable($Domicilios['colonias'])) {
            Schema::table($Domicilios['colonias'], function (Blueprint $table) use ($Domicilios) {
                $table->dropColumn('nomenclatura');
            });
        }
        if (Schema::hasTable($Domicilios['tipocomunidades'])) {
            Schema::table($Domicilios['tipocomunidades'], function (Blueprint $table) use ($Domicilios) {
                $table->dropColumn('nomenclatura');
            });
        }
        if (Schema::hasTable($Domicilios['tipoasentamientos'])) {
            Schema::table($Domicilios['tipoasentamientos'], function (Blueprint $table) use ($Domicilios) {
                $table->dropColumn('nomenclatura');
            });
        }
        if (Schema::hasTable($Domicilios['asentamientos'])) {
            Schema::table($Domicilios['asentamientos'], function (Blueprint $table) use ($Domicilios) {
                $table->dropColumn('nomenclatura');
            });
        }


        if (Schema::hasTable($Catalogos['denuncia_dependencia_servicio_estatus'])) {
            Schema::table($Catalogos['denuncia_dependencia_servicio_estatus'], function (Blueprint $table) use ($Catalogos) {
                $table->dropColumn('favorable');
            });
        }



    }
}
