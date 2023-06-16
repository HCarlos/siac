<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterDenunciamobileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        $tableNames = config('atemun.table_names.mobiles');

        if (! Schema::hasTable($tableNames['denunciamobile'])) {
            Schema::table($tableNames['denunciamobile'], function (Blueprint $table) use ($tableNames) {
                $table->integer("megusta")->default(0);
            });
        }

        if (! Schema::hasTable($tableNames['ciudadanomobile_denunciamobile'])) {
            Schema::create($tableNames['ciudadanomobile_denunciamobile'], function (Blueprint $table) use ($tableNames) {
                $table->increments('id');
                $table->unsignedInteger('denunciamobile_id')->default(0)->index();
                $table->unsignedInteger('ciudadanomobile_id')->default(0)->index();
                $table->softDeletes();
                $table->timestamps();
//                $table->unique(['denunciamobile_id', 'ciudadanomobile_id']);

                $table->foreign('denunciamobile_id')
                    ->references('id')
                    ->on($tableNames['denunciamobile'])
                    ->onDelete('cascade');

                $table->foreign('ciudadanomobile_id')
                    ->references('id')
                    ->on($tableNames['users'])
                    ->onDelete('cascade');
            });
        }


        DB::statement("ALTER DATABASE dbatemun set default_text_search_config = 'spanish'");
        DB::statement("ALTER TABLE denunciamobile ADD COLUMN searchtextubicacion TSVECTOR");
        DB::statement("UPDATE denunciamobile SET searchtextubicacion = to_tsvector('spanish', coalesce(trim(ubicacion),'') )");
        DB::statement("CREATE INDEX searchtextmobile_gin ON denunciamobile USING GIN(searchtextubicacion)");
        DB::statement("CREATE TRIGGER ts_searchtextdenuncia BEFORE INSERT OR UPDATE ON denunciamobile FOR EACH ROW EXECUTE PROCEDURE tsvector_update_trigger('searchtextubicacion', 'pg_catalog.spanish', 'ubicacion')");



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){

        $tableNames = config('atemun.table_names.mobiles');

        Schema::dropIfExists('ciudadanomobile_denunciamobile');

        if (! Schema::hasTable($tableNames['denunciamobile'])) {
            Schema::table($tableNames['denunciamobile'], function (Blueprint $table) use ($tableNames) {
                $table->dropColumn('megusta');
            });
        }

        DB::statement("DROP TRIGGER IF EXISTS ts_searchtextdenuncia ON denunciamobile");
        DB::statement("DROP INDEX IF EXISTS searchtextmobile_gin");
        DB::statement("DROP TRIGGER IF EXISTS ts_searchtextdenuncia ON denunciamobile");
        DB::statement("ALTER TABLE denunciamobile DROP COLUMN IF EXISTS searchtextubicacion");



    }
}
