<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDenuncias1Table extends Migration
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
                $table->unsignedTinyInteger('ambito')->default(0)->index('ambito')->comment('0=No Aplica, 1=Urbana, 2=Rural');
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
                $table->dropColumn('ambito');
            });
        }
    }
}
