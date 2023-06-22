<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsermobile2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        $tableNames = config('atemun.table_names.mobiles');
        if (Schema::hasTable($tableNames['usermobile'])) {
            Schema::table($tableNames['usermobile'], function (Blueprint $table) use ($tableNames) {
                $table->boolean('enabled', true)->default(true);
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){

        $tableNames = config('atemun.table_names.mobiles');
        if (Schema::hasTable($tableNames['usermobile'])) {
            Schema::table($tableNames['usermobile'], function (Blueprint $table) use ($tableNames) {
                $table->dropColumn('enabled');
            });
        }

    }
}
