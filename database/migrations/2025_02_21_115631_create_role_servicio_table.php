<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleServicioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        $tableNames = config('atemun.table_names.catalogos');

        Schema::create($tableNames['servicio_user'], function (Blueprint $table) use ($tableNames){
            $table->increments('id');
            $table->Integer('user_id')->default(0)->index();
            $table->Integer('servicio_id')->default(0)->index();
            $table->text('comentario')->default('')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['user_id', 'servicio_id']);

            $table->foreign('user_id')
                ->references('id')
                ->on($tableNames['users'])
                ->onDelete('cascade');

            $table->foreign('servicio_id')
                ->references('id')
                ->on($tableNames['servicios'])
                ->onDelete('cascade');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('servicio_user');
    }
}
