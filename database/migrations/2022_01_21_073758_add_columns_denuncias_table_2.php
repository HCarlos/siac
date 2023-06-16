<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddColumnsDenunciasTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        $Catalogos = config('atemun.table_names.catalogos');
        $Users = config('atemun.table_names.users');

        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');

        if (Schema::hasTable($Catalogos['denuncias'])) {
            Schema::table($Catalogos['denuncias'], function (Blueprint $table)  {
                $table->uuid('uuid')->default(DB::raw('uuid_generate_v4()'))->unique();
            });
        }

        if (Schema::hasTable($Users['users'])) {
            Schema::table($Users['users'], function (Blueprint $table)  {
                $table->uuid('uuid')->default(DB::raw('uuid_generate_v4()'))->unique();
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){

        $Catalogos = config('atemun.table_names.catalogos');
        $Users = config('atemun.table_names.users');

        if (Schema::hasTable($Catalogos['denuncias'])) {
            Schema::table($Catalogos['denuncias'], function (Blueprint $table)  {
                $table->dropColumn('uuid');
            });
        }

        if (Schema::hasTable($Users['users'])) {
            Schema::table($Users['users'], function (Blueprint $table)  {
                $table->dropColumn('uuid');
            });
        }

    }
}
