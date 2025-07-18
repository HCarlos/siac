<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddIndexesToMultipleTables01 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        $Catalogos  = config('atemun.table_names.catalogos');
        $Users  = config('atemun.table_names.users');

        if (Schema::hasTable($Catalogos['denuncias'])) {

            // Primero, actualiza los valores 0 a NULL si es necesario
            DB::statement('UPDATE denuncias SET centro_localidad_id = NULL WHERE centro_localidad_id = 0');

            Schema::table($Catalogos['denuncias'], function (Blueprint $table) {
                $table->index('fecha_ingreso');
                $table->index(['latitud','longitud']);
                $table->index('fecha_ultimo_estatus');

                $table->integer('centro_localidad_id')->nullable()->change();

                $table->foreign('centro_localidad_id')
                    ->references('id')
                    ->on('centro_localidades')
                    ->onDelete('set null');

            });
        }
        if (Schema::hasTable($Catalogos['denuncia_dependencia_servicio_estatus'])) {
            Schema::table($Catalogos['denuncia_dependencia_servicio_estatus'], function (Blueprint $table) {
                $table->index('fecha_movimiento');
            });
        }

        if (Schema::hasTable($Users['users'])) {
            Schema::table($Users['users'], function (Blueprint $table) {
                $table->index('curp');
                $table->index(['ap_paterno','ap_materno','nombre']);
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
        $Users  = config('atemun.table_names.users');

        if (Schema::hasTable($Catalogos['denuncias'])) {
            Schema::table($Catalogos['denuncias'], function (Blueprint $table) {
                $table->dropIndex(['fecha_ingreso']);
                $table->dropIndex('denuncias_latitud_longitud_index');
                $table->dropIndex(['fecha_ultimo_estatus']);
                $table->dropForeign(['centro_localidad_id']);
            });
        }

        if (Schema::hasTable($Catalogos['denuncia_dependencia_servicio_estatus'])) {
            Schema::table($Catalogos['denuncia_dependencia_servicio_estatus'], function (Blueprint $table) {
                $table->dropIndex(['fecha_movimiento']);
            });
        }

        if (Schema::hasTable($Users['users'])) {
            Schema::table($Users['users'], function (Blueprint $table) {
                $table->dropIndex(['curp']);
                $table->dropIndex('users_ap_paterno_ap_materno_nombre_index');
            });
        }


    }
}
