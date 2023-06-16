<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDenunciaImageneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $tableNamesCatalogos = config('atemun.table_names.catalogos');

        Schema::create($tableNamesCatalogos['imagenes'], function (Blueprint $table) use ($tableNamesCatalogos){
            $table->increments('id');
            $table->dateTime('fecha')->nullable();
            $table->string('root',150)->default("")->nullable();
            $table->string('image',100)->default("")->nullable();
            $table->string('image_thumb',100)->default("")->nullable();
            $table->string('titulo',150)->default("")->nullable();
            $table->string('descripcion',500)->default("")->nullable();
            $table->string('momento',10)->default("ANTES")->nullable();
            $table->unsignedInteger('user__id')->default(0)->index();
            $table->unsignedInteger('denuncia__id')->default(0)->index();
            $table->unsignedInteger('parent__id')->default(0)->index();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create($tableNamesCatalogos['denuncia_imagene'], function (Blueprint $table) use ($tableNamesCatalogos){
            $table->increments('id');
            $table->unsignedInteger('denuncia_id')->default(0)->index();
            $table->unsignedInteger('imagene_id')->default(0)->index();
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['denuncia_id', 'imagene_id']);

            $table->foreign('denuncia_id')
                ->references('id')
                ->on($tableNamesCatalogos['denuncias'])
                ->onDelete('cascade');

            $table->foreign('imagene_id')
                ->references('id')
                ->on($tableNamesCatalogos['imagenes'])
                ->onDelete('cascade');
        });

        Schema::create($tableNamesCatalogos['imagene_parent'], function (Blueprint $table) use ($tableNamesCatalogos){
            $table->increments('id');
            $table->unsignedInteger('imagene_id')->default(0)->index();
            $table->unsignedInteger('imagen_parent_id')->default(0)->index();
            $table->softDeletes();
            $table->timestamps();
            $table->unique([ 'imagene_id','imagen_parent_id']);

            $table->foreign('imagene_id')
                ->references('id')
                ->on($tableNamesCatalogos['imagenes'])
                ->onDelete('cascade');

            $table->foreign('imagen_parent_id')
                ->references('id')
                ->on($tableNamesCatalogos['imagenes'])
                ->onDelete('cascade');

        });

        Schema::create($tableNamesCatalogos['imagene_user'], function (Blueprint $table) use ($tableNamesCatalogos){
            $table->increments('id');
            $table->unsignedInteger('imagene_id')->default(0)->index();
            $table->unsignedInteger('user_id')->default(0)->index();
            $table->softDeletes();
            $table->timestamps();
            $table->unique([ 'imagene_id','user_id']);

            $table->foreign('imagene_id')
                ->references('id')
                ->on($tableNamesCatalogos['imagenes'])
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
        Schema::dropIfExists('denuncia_imagene');
        Schema::dropIfExists('imagene_parent');
        Schema::dropIfExists('imagene_user');
        Schema::dropIfExists('imagenes');
    }
}
