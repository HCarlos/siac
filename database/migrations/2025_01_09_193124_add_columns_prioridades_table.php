<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsPrioridadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        $tableNames = config('atemun.table_names.catalogos');

        if (Schema::hasTable($tableNames['prioridades'])) {
            Schema::table($tableNames['prioridades'], function (Blueprint $table) use ($tableNames) {
                $table->unsignedInteger('orden_impresion')->default(0)->index();
                $table->integer('ambito_prioridad')->default(1)->index();
            });
        }



        Schema::create($tableNames['prioridade_user'], function (Blueprint $table) use ($tableNames){
            $table->increments('id');
            $table->Integer('user_id')->default(0)->index();
            $table->Integer('prioridad_id')->default(0)->index();
            $table->tinyInteger('orden')->default(0);
            $table->boolean('predeterminado')->default(false);
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['user_id', 'prioridad_id']);

            $table->foreign('user_id')
                ->references('id')
                ->on($tableNames['users'])
                ->onDelete('cascade');

            $table->foreign('prioridad_id')
                ->references('id')
                ->on($tableNames['prioridades'])
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
        if (Schema::hasTable($Catalogos['prioridades'])) {

            Schema::table($Catalogos['prioridades'], function (Blueprint $table)  {
                $table->dropColumn('orden_impresion');
                $table->dropColumn('ambito_prioridad');
            });

        }

        Schema::drop($Catalogos['prioridade_user']);


    }
}
