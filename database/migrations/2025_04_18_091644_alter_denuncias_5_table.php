<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDenuncias5Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        $Catalogos  = config('atemun.table_names.catalogos');

        if (Schema::hasTable($Catalogos['denuncia_modificadopor'])) {
            Schema::table($Catalogos['denuncia_modificadopor'], function (Blueprint $table) use ($Catalogos) {
                if (Schema::hasColumn($Catalogos['denuncia_modificadopor'], 'descripcion')) {
                    $table->string('campos_modificados', 250)->default('')->comment('Guarda los campos modificados');
                    $table->text('antes')->default('')->comment('valores antes');
                    $table->text('despues')->default('')->comment('valores después');
                }
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
        if (Schema::hasTable($Catalogos['denuncia_modificadopor'])) {
            Schema::table($Catalogos['denuncia_modificadopor'], function (Blueprint $table) use ($Catalogos) {
                if (Schema::hasColumn($Catalogos['denuncia_modificadopor'], 'campos_modificados')) {
                    $table->dropColumn('campos_modificados');
                    $table->dropColumn('antes');
                    $table->dropColumn('despues');
                }
            });
        }

    }
}
