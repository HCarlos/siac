<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatEstatusUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        $tableNames = config('atemun.table_names.catalogos');

        if (Schema::hasTable($tableNames['estatus'])) {
            Schema::table($tableNames['estatus'], function (Blueprint $table) use ($tableNames) {
                $table->boolean('favorable')->default(false)->index();
                $table->integer('ambito_estatus')->default(1)->index();
            });
        }



        Schema::create($tableNames['estatu_user'], function (Blueprint $table) use ($tableNames){
            $table->increments('id');
            $table->Integer('user_id')->default(0)->index();
            $table->Integer('estatu_id')->default(0)->index();
            $table->tinyInteger('orden')->default(0);
            $table->boolean('predeterminado')->default(false);
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['user_id', 'estatu_id']);

            $table->foreign('user_id')
                ->references('id')
                ->on($tableNames['users'])
                ->onDelete('cascade');

            $table->foreign('estatu_id')
                ->references('id')
                ->on($tableNames['estatus'])
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
        if (Schema::hasTable($Catalogos['estatus'])) {
            Schema::table($Catalogos['estatus'], function (Blueprint $table) use ($Catalogos) {
                $table->dropColumn('favorable');
                $table->dropColumn('ambito_estatus');
            });
        }

        Schema::drop($Catalogos['estatu_user']);

    }
}
