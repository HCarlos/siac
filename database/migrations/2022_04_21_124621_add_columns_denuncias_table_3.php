<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsDenunciasTable3 extends Migration
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
                $table->string('clave_identificadora',150)->default("")->index('clave_identificadora')->comment('Es una clave que permite, identificar un paquete, comunicdad ó programa en especial.');
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
                $table->dropColumn('clave_identificadora');
            });
        }


    }
}
