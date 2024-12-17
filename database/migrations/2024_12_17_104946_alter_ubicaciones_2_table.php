<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterUbicaciones2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        $this->down();

        $Domicilios = config('atemun.table_names.domicilios');
        $Catalogos = config('atemun.table_names.catalogos');

        if (Schema::hasTable($Domicilios['ubicaciones'])) {
            DB::statement("ALTER DATABASE dbatemun set default_text_search_config = 'spanish'");
            DB::statement("ALTER TABLE ubicaciones ADD COLUMN g_searchtext TSVECTOR");
            DB::statement("UPDATE ubicaciones SET g_searchtext = to_tsvector('spanish', coalesce(trim(search_google),'') || ' ' || coalesce(trim(g_ubicacion),'') )");
            DB::statement("CREATE INDEX g_searchtext_gin ON ubicaciones USING GIN(g_searchtext)");
            DB::statement("CREATE TRIGGER ts_g_searchtext BEFORE INSERT OR UPDATE ON ubicaciones FOR EACH ROW EXECUTE PROCEDURE tsvector_update_trigger('g_searchtext', 'pg_catalog.spanish','search_google','g_ubicacion')");
        }

        if (Schema::hasTable($Catalogos['denuncias'])) {
            DB::statement("ALTER DATABASE dbatemun set default_text_search_config = 'spanish'");
            DB::statement("ALTER TABLE denuncias ADD COLUMN gd_searchtext TSVECTOR");
            DB::statement("UPDATE denuncias SET gd_searchtext = to_tsvector('spanish', coalesce(trim(search_google),'') || ' ' || coalesce(trim(gd_ubicacion),'') )");
            DB::statement("CREATE INDEX gd_searchtext_gin ON denuncias USING GIN(gd_searchtext)");
            DB::statement("CREATE TRIGGER ts_gd_searchtext BEFORE INSERT OR UPDATE ON denuncias FOR EACH ROW EXECUTE PROCEDURE tsvector_update_trigger('gd_searchtext', 'pg_catalog.spanish','search_google','gd_ubicacion')");
        }




    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){

        $Domicilios = config('atemun.table_names.domicilios');
        $Catalogos = config('atemun.table_names.catalogos');

        if (Schema::hasTable($Domicilios['ubicaciones'])) {
            DB::statement("DROP INDEX IF EXISTS g_searchtext_gin");
            DB::statement("DROP TRIGGER IF EXISTS ts_g_searchtext ON ubicaciones");
            DB::statement("ALTER TABLE ubicaciones DROP COLUMN IF EXISTS g_searchtext");
        }

        if (Schema::hasTable($Catalogos['denuncias'])) {
            DB::statement("DROP INDEX IF EXISTS gd_searchtext_gin");
            DB::statement("DROP TRIGGER IF EXISTS ts_gd_searchtext ON denuncias");
            DB::statement("ALTER TABLE denuncias DROP COLUMN IF EXISTS gd_searchtext");
        }


    }
}
