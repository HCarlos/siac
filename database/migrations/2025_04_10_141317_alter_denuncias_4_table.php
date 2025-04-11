<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDenuncias4Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        $Catalogos  = config('atemun.table_names.catalogos');

        if (Schema::hasTable($Catalogos['denuncias'])) {
            Schema::table($Catalogos['denuncias'], function (Blueprint $table) use ($Catalogos) {
                $table->string('codigo_postal_manual',10)->default('')->comment('Guarda el codigo postal manual');
                $table->string('search_google_select',250)->default('')->comment('Dirección google seleccionada');
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
        if (Schema::hasTable($Catalogos['denuncias'])) {
            Schema::table($Catalogos['denuncias'], function (Blueprint $table) use ($Catalogos) {
                $table->dropColumn('codigo_postal_manual');
                $table->dropColumn('search_google_select');
            });
        }

    }



}
