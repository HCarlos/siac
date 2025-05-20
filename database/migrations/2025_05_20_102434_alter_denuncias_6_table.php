<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterDenuncias6Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        $Catalogos = config('atemun.table_names.catalogos');

        if (Schema::hasTable($Catalogos['denuncias'])) {
            DB::statement("ALTER DATABASE dbatemun set default_text_search_config = 'spanish'");
            DB::statement("ALTER TABLE denuncias ADD COLUMN calle_y_numero_searchtext TSVECTOR");
            DB::statement("UPDATE denuncias SET calle_y_numero_searchtext = to_tsvector('spanish', coalesce(trim(search_google),'') )");
            DB::statement("CREATE INDEX calle_y_numero_searchtext_gin ON denuncias USING GIN(calle_y_numero_searchtext)");
            DB::statement("CREATE TRIGGER ts_calle_y_numero_searchtext BEFORE INSERT OR UPDATE ON denuncias FOR EACH ROW EXECUTE PROCEDURE tsvector_update_trigger('calle_y_numero_searchtext', 'pg_catalog.spanish','search_google')");
        }



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){

        $Catalogos = config('atemun.table_names.catalogos');

        if (Schema::hasTable($Catalogos['denuncias'])) {
            DB::statement("DROP INDEX IF EXISTS calle_y_numero_searchtext_gin");
            DB::statement("DROP TRIGGER IF EXISTS ts_calle_y_numero_searchtext ON denuncias");
            DB::statement("ALTER TABLE denuncias DROP COLUMN IF EXISTS calle_y_numero_searchtext");
        }


    }
}
