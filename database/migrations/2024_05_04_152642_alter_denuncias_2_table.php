<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDenuncias2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $Catalogos  = config('atemun.table_names.catalogos');

        if (Schema::hasTable($Catalogos['denuncias'])) {
            Schema::table($Catalogos['denuncias'], function (Blueprint $table) use ($Catalogos) {
                $table->string('estatus_general',4000)->default("")->comment('Guardael estatus general de la denuncia');
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
                $table->dropColumn('estatus_general');
            });
        }
    }
}
