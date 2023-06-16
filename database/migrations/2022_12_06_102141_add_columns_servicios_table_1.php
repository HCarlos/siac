<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsServiciosTable1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */


    public function up(){

        $Catalogos  = config('atemun.table_names.catalogos');

        if (Schema::hasTable($Catalogos['servicios'])) {
            Schema::table($Catalogos['servicios'], function (Blueprint $table) use ($Catalogos) {
                $table->boolean('is_visible_mobile', false)->default(false);
                $table->string('nombre_mobile',50)->default('');
                $table->string('root',50)->default('');
                $table->string('filename',250)->default('');
                $table->string('filename_png',250)->default('');
                $table->string('filename_thumb',250)->default('');
                $table->string('url_image_mobile',250)->default('');
                $table->integer('orden_image_mobile')->default(0);
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

        if (Schema::hasTable($Catalogos['servicios'])) {
            Schema::table($Catalogos['servicios'], function (Blueprint $table) use ($Catalogos) {
                $table->dropColumn('is_visible_mobile');
                $table->dropColumn('nombre_mobile');
                $table->dropColumn('url_image_mobile');
                $table->dropColumn('orden_image_mobile');
                $table->dropColumn('root');
                $table->dropColumn('filename');
                $table->dropColumn('filename_png');
                $table->dropColumn('filename_thumb');
            });
        }

    }

}
