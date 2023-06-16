<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDenunciamobile2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        $tableNames = config('atemun.table_names.mobiles');
        if (Schema::hasTable($tableNames['denunciamobile'])) {
            Schema::table($tableNames['denunciamobile'], function (Blueprint $table) use ($tableNames) {
                $table->unsignedInteger("denuncia_id")->nullable()->index();
                $table->softDeletes();

                $table->foreign('denuncia_id')
                    ->references('id')
                    ->on($tableNames['denuncias'])
                    ->onDelete('cascade');

            });
        }

        if (Schema::hasTable($tableNames['denuncias'])) {
            Schema::table($tableNames['denuncias'], function (Blueprint $table) use ($tableNames) {
                $table->unsignedInteger("denunciamobile_id")->nullable()->index();

                $table->foreign('denunciamobile_id')
                    ->references('id')
                    ->on($tableNames['denunciamobile'])
                    ->onDelete('cascade');

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

        if (Schema::hasTable($tableNames['denunciamobile'])) {
            Schema::table($tableNames['denunciamobile'], function (Blueprint $table) use ($tableNames) {
                $table->dropColumn('deleted_at');
                $table->dropColumn('denuncia_id');
            });
        }

        if (Schema::hasTable($tableNames['denuncias'])) {
            Schema::table($tableNames['denuncias'], function (Blueprint $table) use ($tableNames) {
                $table->dropColumn('denunciamobile_id');
            });
        }




    }
}
