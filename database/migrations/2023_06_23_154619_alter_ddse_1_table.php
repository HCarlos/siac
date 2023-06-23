<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDdse1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        $Catalogos  = config('atemun.table_names.catalogos');
        $Users  = config('atemun.table_names.users');

        if (Schema::hasTable($Catalogos['denuncia_dependencia_servicio_estatus'])) {
            Schema::table($Catalogos['denuncia_dependencia_servicio_estatus'], function (Blueprint $table) use ($Catalogos, $Users) {
                $table->boolean('fue_leida')->default(true)->comment('Evalúa si ya fue leida por el área correspondiente.');
                $table->unsignedInteger('creadopor_id')->default(1)->nullable()->index();

                $table->foreign('creadopor_id')
                    ->references('id')
                    ->on($Users['users'])
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

        if (Schema::hasTable($Catalogos['denuncia_dependencia_servicio_estatus'])) {
            Schema::table($Catalogos['denuncia_dependencia_servicio_estatus'], function (Blueprint $table) use ($Catalogos) {
                $table->dropColumn('fue_leida');
                $table->dropColumn('creadopor_id');
            });
        }


    }
}
