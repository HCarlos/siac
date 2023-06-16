<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDenunciamobileRespuestasmobilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        $tableNames = config('atemun.table_names.mobiles');

        Schema::create($tableNames['respuestamobile'], function (Blueprint $table) use ($tableNames){
            $table->increments('id');
            $table->dateTime('fecha')->nullable();
            $table->text('respuesta')->default("")->nullable();
            $table->text('observaciones')->default("")->nullable();
            $table->unsignedInteger('user_id')->default(0)->index();
            $table->unsignedInteger('denunciamobile_id')->default(0)->index();
            $table->unsignedInteger('parent_id')->default(0)->index();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create($tableNames['denunciamobile_respuestamobile'], function (Blueprint $table) use ($tableNames){
            $table->increments('id');
            $table->unsignedInteger('denunciamobile_id')->default(0)->index();
            $table->unsignedInteger('respuestamobile_id')->default(0)->index();
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['denunciamobile_id', 'respuestamobile_id']);

            $table->foreign('denunciamobile_id')
                ->references('id')
                ->on($tableNames['denunciamobile'])
                ->onDelete('cascade');

            $table->foreign('respuestamobile_id')
                ->references('id')
                ->on($tableNames['respuestamobile'])
                ->onDelete('cascade');

        });

        Schema::create($tableNames['parent_respuestamobile'], function (Blueprint $table) use ($tableNames){
            $table->increments('id');
            $table->unsignedInteger('respuestamobile_id')->default(0)->index();
            $table->unsignedInteger('respuestamobile_parent_id')->default(0)->index();
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['respuestamobile_id', 'respuestamobile_parent_id']);

            $table->foreign('respuestamobile_id')
                ->references('id')
                ->on($tableNames['respuestamobile'])
                ->onDelete('cascade');

            $table->foreign('respuestamobile_parent_id')
                ->references('id')
                ->on($tableNames['respuestamobile'])
                ->onDelete('cascade');

        });

        Schema::create($tableNames['respuestamobile_user'], function (Blueprint $table) use ($tableNames){
            $table->increments('id');
            $table->unsignedInteger('respuestamobile_id')->default(0)->index();
            $table->unsignedInteger('user_id')->default(0)->index();
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['respuestamobile_id', 'user_id']);

            $table->foreign('respuestamobile_id')
                ->references('id')
                ->on($tableNames['respuestamobile'])
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on($tableNames['users'])
                ->onDelete('cascade');

        });





    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){

        $tableNames = config('atemun.table_names.mobiles');

        Schema::dropIfExists('denunciamobile_respuestamobile');
        Schema::dropIfExists('parent_respuestamobile');
        Schema::dropIfExists('respuestamobile_user');
        Schema::dropIfExists('respuestamobile');


    }
}
