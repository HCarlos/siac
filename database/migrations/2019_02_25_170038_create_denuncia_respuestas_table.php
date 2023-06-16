<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDenunciaRespuestasTable extends Migration{

    public function up()
    {
        $tableNamesCatalogos = config('atemun.table_names.catalogos');

        Schema::create($tableNamesCatalogos['denuncia_respuesta'], function (Blueprint $table) use ($tableNamesCatalogos){
            $table->increments('id');
            $table->unsignedInteger('denuncia_id')->default(0)->index();
            $table->unsignedInteger('respuesta_id')->default(0)->index();
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['denuncia_id', 'respuesta_id']);

            $table->foreign('denuncia_id')
                ->references('id')
                ->on($tableNamesCatalogos['denuncias'])
                ->onDelete('cascade');

            $table->foreign('respuesta_id')
                ->references('id')
                ->on($tableNamesCatalogos['respuestas'])
                ->onDelete('cascade');

        });

        Schema::create($tableNamesCatalogos['parent_respuesta'], function (Blueprint $table) use ($tableNamesCatalogos){
            $table->increments('id');
            $table->unsignedInteger('respuesta_id')->default(0)->index();
            $table->unsignedInteger('respuesta_parent_id')->default(0)->index();
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['respuesta_id', 'respuesta_parent_id']);

            $table->foreign('respuesta_id')
                ->references('id')
                ->on($tableNamesCatalogos['respuestas'])
                ->onDelete('cascade');

            $table->foreign('respuesta_parent_id')
                ->references('id')
                ->on($tableNamesCatalogos['respuestas'])
                ->onDelete('cascade');

        });




        Schema::create($tableNamesCatalogos['respuesta_user'], function (Blueprint $table) use ($tableNamesCatalogos){
            $table->increments('id');
            $table->unsignedInteger('respuesta_id')->default(0)->index();
            $table->unsignedInteger('user_id')->default(0)->index();
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['respuesta_id', 'user_id']);

            $table->foreign('respuesta_id')
                ->references('id')
                ->on($tableNamesCatalogos['respuestas'])
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on($tableNamesCatalogos['users'])
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
        Schema::dropIfExists('denuncia_respuesta');
        Schema::dropIfExists('parent_respuesta');
        Schema::dropIfExists('respuesta_user');
    }
}
