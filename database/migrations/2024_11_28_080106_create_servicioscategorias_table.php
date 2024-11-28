<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicioscategoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        $tableNames = config('atemun.table_names.catalogos');

//        Schema::create('servicioscategorias', function (Blueprint $table) {
//            $table->id();
//            $table->timestamps();
//        });

        Schema::create($tableNames['servicioscategorias'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('categoria_servicios',50)->default('')->nullable();
            $table->string('enlaces_unidades',250)->default('')->nullable();
            $table->boolean('predeterminado')->default(false)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create($tableNames['servicioscategoria_user'], function (Blueprint $table) use ($tableNames){
            $table->increments('id');
            $table->Integer('user_id')->default(0)->index();
            $table->Integer('servicioscategoria_id')->default(0)->index();
            $table->tinyInteger('orden')->default(0);
            $table->boolean('predeterminado')->default(false);
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['user_id', 'servicioscategoria_id']);

            $table->foreign('user_id')
                ->references('id')
                ->on($tableNames['users'])
                ->onDelete('cascade');

            $table->foreign('servicioscategoria_id')
                ->references('id')
                ->on($tableNames['servicioscategorias'])
                ->onDelete('cascade');

        });

        Schema::create($tableNames['origene_user'], function (Blueprint $table) use ($tableNames){
            $table->increments('id');
            $table->Integer('user_id')->default(0)->index();
            $table->Integer('origene_id')->default(0)->index();
            $table->tinyInteger('orden')->default(0);
            $table->boolean('predeterminado')->default(false);
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['user_id', 'origene_id']);

            $table->foreign('user_id')
                ->references('id')
                ->on($tableNames['users'])
                ->onDelete('cascade');

            $table->foreign('origene_id')
                ->references('id')
                ->on($tableNames['origenes'])
                ->onDelete('cascade');

        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){

        $Catalogos  = config('atemun.table_names.catalogos');

        Schema::drop($Catalogos['servicioscategoria_user']);
        Schema::drop($Catalogos['origene_user']);

        Schema::dropIfExists('servicioscategorias');

    }
}
