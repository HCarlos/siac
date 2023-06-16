<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterStatusTable extends Migration
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
                $table->integer('resuelto',)->default(0)->comment('0=No', '1=Si');
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
            Schema::table($Catalogos['estatus'], function (Blueprint $table) use ($Catalogos) {
                $table->dropColumn('resuelto');
            });
        }

    }
}
