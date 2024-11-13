<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsEstatusTable3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        $Catalogos = config('atemun.table_names.catalogos');

        if (Schema::hasTable($Catalogos['denuncias'])) {
            Schema::table($Catalogos['denuncias'], function (Blueprint $table) use ($Catalogos) {
                $table->index('status_denuncia')->comment('0 = Inactivo, 1 = Activo, 2 = Suspendido, 3 = Cancelado');
            });
        }

        if (Schema::hasTable($Catalogos['estatus'])) {
            Schema::table($Catalogos['estatus'], function (Blueprint $table) use ($Catalogos) {
                $table->index('estatus_cve')->comment('0 = Inactivo, 1 = Activo, 2 = Suspendido, 3 = Cancelado');
            });
        }

        if (Schema::hasTable($Catalogos['dependencias'])) {
            Schema::table($Catalogos['dependencias'], function (Blueprint $table) use ($Catalogos) {
                $table->index('estatus_cve')->comment('0 = Inactivo, 1 = Activo, 2 = Suspendido, 3 = Cancelado');
            });
        }

        if (Schema::hasTable($Catalogos['areas'])) {
            Schema::table($Catalogos['areas'], function (Blueprint $table) use ($Catalogos) {
                $table->index('estatus_cve')->comment('0 = Inactivo, 1 = Activo, 2 = Suspendido, 3 = Cancelado');
            });
        }

        if (Schema::hasTable($Catalogos['subareas'])) {
            Schema::table($Catalogos['subareas'], function (Blueprint $table) use ($Catalogos) {
                $table->index('estatus_cve')->comment('0 = Inactivo, 1 = Activo, 2 = Suspendido, 3 = Cancelado');
            });
        }

        if (Schema::hasTable($Catalogos['servicios'])) {
            Schema::table($Catalogos['servicios'], function (Blueprint $table) use ($Catalogos) {
                $table->index('estatus_cve')->comment('0 = Inactivo, 1 = Activo, 2 = Suspendido, 3 = Cancelado');
            });
        }


        if (Schema::hasTable($Catalogos['origenes'])) {
            Schema::table($Catalogos['origenes'], function (Blueprint $table) use ($Catalogos) {
                $table->tinyInteger('estatus_cve')->default(1)->index()->comment('0 = Inactivo, 1 = Activo, 2 = Suspendido, 3 = Cancelado');
            });
        }

        if (Schema::hasTable($Catalogos['prioridades'])) {
            Schema::table($Catalogos['prioridades'], function (Blueprint $table) use ($Catalogos) {
                $table->tinyInteger('estatus_cve')->default(1)->index()->comment('0 = Inactivo, 1 = Activo, 2 = Suspendido, 3 = Cancelado');
            });
        }

        $Mobiles = config('atemun.table_names.mobiles');

        if (Schema::hasTable($Mobiles['denunciamobile'])) {
            Schema::table($Mobiles['denunciamobile'], function (Blueprint $table) use ($Mobiles) {
                $table->tinyInteger('estatus_cve')->default(1)->index()->comment('0 = Inactivo, 1 = Activo, 2 = Suspendido, 3 = Cancelado');
            });
        }

        $Domicilios = config('atemun.table_names.domicilios');

        if (Schema::hasTable($Domicilios['calles'])) {
            Schema::table($Domicilios['calles'], function (Blueprint $table) use ($Domicilios) {
                $table->tinyInteger('estatus_cve')->default(1)->index()->comment('0 = Inactivo, 1 = Activo, 2 = Suspendido, 3 = Cancelado');
            });
        }

        if (Schema::hasTable($Domicilios['ciudades'])) {
            Schema::table($Domicilios['ciudades'], function (Blueprint $table) use ($Domicilios) {
                $table->tinyInteger('estatus_cve')->default(1)->index()->comment('0 = Inactivo, 1 = Activo, 2 = Suspendido, 3 = Cancelado');
            });
        }

        if (Schema::hasTable($Domicilios['colonias'])) {
            Schema::table($Domicilios['colonias'], function (Blueprint $table) use ($Domicilios) {
                $table->tinyInteger('estatus_cve')->default(1)->index()->comment('0 = Inactivo, 1 = Activo, 2 = Suspendido, 3 = Cancelado');
            });
        }

        if (Schema::hasTable($Domicilios['comunidades'])) {
            Schema::table($Domicilios['comunidades'], function (Blueprint $table) use ($Domicilios) {
                $table->tinyInteger('estatus_cve')->default(1)->index()->comment('0 = Inactivo, 1 = Activo, 2 = Suspendido, 3 = Cancelado');
            });
        }

       if (Schema::hasTable($Domicilios['localidades'])) {
            Schema::table($Domicilios['localidades'], function (Blueprint $table) use ($Domicilios) {
                $table->tinyInteger('estatus_cve')->default(1)->index()->comment('0 = Inactivo, 1 = Activo, 2 = Suspendido, 3 = Cancelado');
            });
        }

        if (Schema::hasTable($Domicilios['ubicaciones'])) {
            Schema::table($Domicilios['ubicaciones'], function (Blueprint $table) use ($Domicilios) {
                $table->tinyInteger('estatus_cve')->default(1)->index()->comment('0 = Inactivo, 1 = Activo, 2 = Suspendido, 3 = Cancelado');
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

        if (Schema::hasTable($Catalogos['denuncias'])) {
            Schema::table($Catalogos['denuncias'], function (Blueprint $table) use ($Catalogos) {
                $table->dropIndex(['status_denuncia']);
            });
        }

        if (Schema::hasTable($Catalogos['estatus'])) {
            Schema::table($Catalogos['estatus'], function (Blueprint $table) use ($Catalogos) {
                $table->dropIndex(['estatus_cve']);
            });
        }

        if (Schema::hasTable($Catalogos['dependencias'])) {
            Schema::table($Catalogos['dependencias'], function (Blueprint $table) use ($Catalogos) {
                $table->dropIndex(['estatus_cve']);
            });
        }

        if (Schema::hasTable($Catalogos['areas'])) {
            Schema::table($Catalogos['areas'], function (Blueprint $table) use ($Catalogos) {
                $table->dropIndex(['estatus_cve']);
            });
        }

        if (Schema::hasTable($Catalogos['subareas'])) {
            Schema::table($Catalogos['subareas'], function (Blueprint $table) use ($Catalogos) {
                $table->dropIndex(['estatus_cve']);
            });
        }

        if (Schema::hasTable($Catalogos['servicios'])) {
            Schema::table($Catalogos['servicios'], function (Blueprint $table) use ($Catalogos) {
                $table->dropIndex(['estatus_cve']);
            });
        }

        if (Schema::hasTable($Catalogos['origenes'])) {
            Schema::table($Catalogos['origenes'], function (Blueprint $table) use ($Catalogos) {
                $table->dropColumn(['estatus_cve']);
            });
        }

        if (Schema::hasTable($Catalogos['prioridades'])) {
            Schema::table($Catalogos['prioridades'], function (Blueprint $table) use ($Catalogos) {
                $table->dropColumn(['estatus_cve']);
            });
        }

        $Mobiles = config('atemun.table_names.mobiles');

        if (Schema::hasTable($Mobiles['denunciamobile'])) {
            Schema::table($Mobiles['denunciamobile'], function (Blueprint $table) use ($Mobiles) {
                $table->dropColumn(['estatus_cve']);
            });
        }

        $Domicilios = config('atemun.table_names.domicilios');

        if (Schema::hasTable($Domicilios['calles'])) {
            Schema::table($Domicilios['calles'], function (Blueprint $table) use ($Domicilios) {
                $table->dropColumn(['estatus_cve']);
            });
        }

        if (Schema::hasTable($Domicilios['ciudades'])) {
            Schema::table($Domicilios['ciudades'], function (Blueprint $table) use ($Domicilios) {
                $table->dropColumn(['estatus_cve']);
            });
        }

        if (Schema::hasTable($Domicilios['colonias'])) {
            Schema::table($Domicilios['colonias'], function (Blueprint $table) use ($Domicilios) {
                $table->dropColumn(['estatus_cve']);
            });
        }

        if (Schema::hasTable($Domicilios['comunidades'])) {
            Schema::table($Domicilios['comunidades'], function (Blueprint $table) use ($Domicilios) {
                $table->dropColumn(['estatus_cve']);
            });
        }

        if (Schema::hasTable($Domicilios['localidades'])) {
            Schema::table($Domicilios['localidades'], function (Blueprint $table) use ($Domicilios) {
                $table->dropColumn(['estatus_cve']);
            });
        }

        if (Schema::hasTable($Domicilios['ubicaciones'])) {
            Schema::table($Domicilios['ubicaciones'], function (Blueprint $table) use ($Domicilios) {
                $table->dropColumn(['estatus_cve']);
            });
        }



    }
}
