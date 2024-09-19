<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDenuncias3Table extends Migration
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
                $table->integer('ue_id')->default(8)->comment('Guarda el último estatus');
                $table->integer('due_id')->default(1)->comment('Guarda la dependencia del último estatus');
                $table->integer('sue_id')->default(73)->comment('Guarda elservicio del último estatus');
                $table->dateTime('fecha_ultimo_estatus', 0)->default(now())->comment('Guarda la fecha del último estatus');

                $table->foreign('ue_id')
                    ->references('id')
                    ->on($Catalogos['estatus'])
                    ->onDelete('cascade');

                $table->foreign('due_id')
                    ->references('id')
                    ->on($Catalogos['dependencias'])
                    ->onDelete('cascade');

                $table->foreign('sue_id')
                    ->references('id')
                    ->on($Catalogos['servicios'])
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
        $Catalogos  = config('atemun.table_names.catalogos');
        if (Schema::hasTable($Catalogos['denuncias'])) {
            Schema::table($Catalogos['denuncias'], function (Blueprint $table) use ($Catalogos) {
                $table->dropColumn('ue_id');
                $table->dropColumn('due_id');
                $table->dropColumn('sue_id');
                $table->dropColumn('fecha_ultimo_estatus');
            });
        }

    }
}
