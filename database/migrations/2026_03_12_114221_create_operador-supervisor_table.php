<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperadorSupervisorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        $tableNames = config('atemun.table_names.catalogos');

        Schema::create($tableNames['operador_supervisor'], function (Blueprint $table) use ($tableNames){
            $table->increments('id');
            $table->Integer('operador_id')->default(0)->index();
            $table->Integer('supervisor_id')->default(0)->index();
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['operador_id', 'supervisor_id']);

            $table->foreign('operador_id')
                ->references('id')
                ->on($tableNames['users'])
                ->onDelete('cascade');

            $table->foreign('supervisor_id')
                ->references('id')
                ->on($tableNames['users'])
                ->onDelete('cascade');


        });


        Schema::create($tableNames['directorobra_supervisor'], function (Blueprint $table) use ($tableNames){
            $table->increments('id');
            $table->Integer('directorobra_id')->default(0)->index();
            $table->Integer('supervisor_id')->default(0)->index();
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['directorobra_id', 'supervisor_id']);

            $table->foreign('directorobra_id')
                ->references('id')
                ->on($tableNames['users'])
                ->onDelete('cascade');

            $table->foreign('supervisor_id')
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

        $Catalogos  = config('atemun.table_names.catalogos');

        Schema::dropIfExists($Catalogos['operador_supervisor']);
        Schema::dropIfExists($Catalogos['directorobra_supervisor']);


    }
}
