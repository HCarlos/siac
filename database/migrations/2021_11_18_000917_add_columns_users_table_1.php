<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsUsersTable1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        $Users      = config('atemun.table_names.users');

        if (Schema::hasTable($Users['users'])) {
            Schema::table($Users['users'], function (Blueprint $table) use ($Users) {
                $table->unsignedInteger('ubicacion_id')->default(0)->index();
                $table->unsignedInteger('imagen_id')->default(0)->index();
            });
        }


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){

        $Users      = config('atemun.table_names.users');

        if (Schema::hasTable($Users['users'])) {
            Schema::table($Users['users'], function (Blueprint $table) use ($Users) {
                $table->dropColumn('imagen_id');
                $table->dropColumn('ubicacion_id');
            });
        }


    }
}
