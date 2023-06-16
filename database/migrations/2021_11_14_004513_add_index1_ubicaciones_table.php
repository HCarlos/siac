<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndex1UbicacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        $Domicilios = config('atemun.table_names.domicilios');

        if (Schema::hasTable($Domicilios['ubicaciones'])) {
            Schema::table($Domicilios['ubicaciones'], function (Blueprint $table) use ($Domicilios ) {
                $table->index(['calle_id','num_ext','num_int','colonia_id','comunidad_id','ciudad_id','municipio_id','estado_id']);
                $table->index(['calle','num_ext','num_int','colonia','comunidad','ciudad','municipio','estado']);
            });
        }


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $Domicilios = config('atemun.table_names.domicilios');
        if (Schema::hasTable($Domicilios['ubicaciones'])) {
            Schema::table($Domicilios['ubicaciones'], function (Blueprint $table) use ($Domicilios ) {
                $table->dropIndex(['calle_id_num_ext_num_int_colonia_id_comunidad_id_ciudad_id_municipio_id_estado_id']);
                $table->dropIndex(['calle_num_ext_num_int_colonia_comunidad_ciudad_municipio_estado']);
            });
        }
    }
}
