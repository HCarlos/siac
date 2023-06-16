<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDenunciamobile3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        $tableNames = config('atemun.table_names.mobiles');
        if (Schema::hasTable($tableNames['denunciamobile'])) {
            Schema::table($tableNames['denunciamobile'], function (Blueprint $table) use ($tableNames) {
                $table->unsignedInteger("dependencia_id")->nullable()->index();
                $table->unsignedInteger("servicio_id")->nullable()->index();
                $table->unsignedInteger("estatus_id")->nullable()->index();

                $table->foreign('dependencia_id')
                    ->references('id')
                    ->on($tableNames['dependencias'])
                    ->onDelete('cascade');

                $table->foreign('servicio_id')
                    ->references('id')
                    ->on($tableNames['servicios'])
                    ->onDelete('cascade');

                $table->foreign('estatus_id')
                    ->references('id')
                    ->on($tableNames['estatus'])
                    ->onDelete('cascade');

            });
        }


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){

        $tableNames = config('atemun.table_names.mobiles');

        if (Schema::hasTable($tableNames['denunciamobile'])) {
            Schema::table($tableNames['denunciamobile'], function (Blueprint $table) use ($tableNames) {
                $table->dropColumn('dependencia_id');
                $table->dropColumn('servicio_id');
                $table->dropColumn('estatus_id');
            });
        }



    }
}
