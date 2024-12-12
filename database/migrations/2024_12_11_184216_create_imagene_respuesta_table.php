<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageneRespuestaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        $tableNamesCatalogos = config('atemun.table_names.catalogos');

        Schema::create($tableNamesCatalogos['imagene_respuesta'], function (Blueprint $table) use ($tableNamesCatalogos){
            $table->increments('id');
            $table->unsignedInteger('imagene_id')->default(0)->index();
            $table->unsignedInteger('ddse_id')->default(0)->index()->comment('Índice de la Tabla: denuncia_dependencia_servicio_estatus');
            $table->softDeletes();
            $table->timestamps();
            $table->unique([ 'imagene_id','ddse_id']);

            $table->foreign('imagene_id')
                ->references('id')
                ->on($tableNamesCatalogos['imagenes'])
                ->onDelete('cascade');

            $table->foreign('ddse_id')
                ->references('id')
                ->on($tableNamesCatalogos['denuncia_dependencia_servicio_estatus'])
                ->onDelete('cascade');

        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imagene_respuesta');
    }
}
