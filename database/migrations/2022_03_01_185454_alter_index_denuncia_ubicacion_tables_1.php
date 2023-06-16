<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterIndexDenunciaUbicacionTables1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        // CAMPO ESPECIAL PARA DENUNCIAS
//        DB::statement("DROP TRIGGER IF EXISTS tsvector_update_trigger ON denuncias");
//        DB::statement("DROP INDEX IF EXISTS searchtextdenuncia_gin");
//        DB::statement("DROP TRIGGER IF EXISTS ts_searchtext ON denuncias");
//        DB::statement("ALTER TABLE denuncias DROP COLUMN IF EXISTS searchtextdenuncia");
//
//        DB::statement("ALTER DATABASE dbatemun set default_text_search_config = 'spanish'");
//        DB::statement("ALTER TABLE denuncias ADD COLUMN searchtextdenuncia TSVECTOR");
//        DB::statement("UPDATE denuncias SET searchtextdenuncia = to_tsvector('spanish', coalesce(trim(descripcion),'') || ' ' || coalesce(trim(referencia),'') || ' ' || coalesce(trim(calle),'') || ' ' || coalesce(trim(num_ext),'') || ' ' || coalesce(trim(num_int),'') || ' ' || coalesce(trim(colonia),'') || ' ' || coalesce(trim(comunidad),'') || ' ' || coalesce(trim(ciudad),'') || ' ' || coalesce(trim(municipio),'') || ' ' || coalesce(trim(estado),'') || ' ' || coalesce(trim(cp),'') )");
//        DB::statement("CREATE INDEX searchtextdenuncia_gin ON denuncias USING GIN(searchtextdenuncia)");
//        DB::statement("CREATE TRIGGER ts_searchtext BEFORE INSERT OR UPDATE ON denuncias FOR EACH ROW EXECUTE PROCEDURE tsvector_update_trigger('searchtextdenuncia', 'pg_catalog.spanish', 'descripcion', 'referencia', 'calle', 'num_ext', 'num_int', 'colonia', 'comunidad', 'ciudad', 'municipio', 'estado', 'cp')");



        // CAMPO ESPECIAL PARA UBICACIONES
//        DB::statement("DROP TRIGGER IF EXISTS tsvector_update_trigger ON ubicaciones");
//        DB::statement("DROP INDEX IF EXISTS searchtext_gin");
//        DB::statement("DROP TRIGGER IF EXISTS ts_searchtext ON ubicaciones");
//        DB::statement("ALTER TABLE ubicaciones DROP COLUMN IF EXISTS searchtext");
//
//        DB::statement("ALTER DATABASE dbatemun set default_text_search_config = 'spanish'");
//        DB::statement("ALTER TABLE ubicaciones ADD COLUMN searchtext TSVECTOR");
//        DB::statement("UPDATE ubicaciones SET searchtext = to_tsvector('spanish', coalesce(trim(calle),'') || ' ' ||  coalesce(trim(num_ext),'') || ' ' ||  coalesce(trim(num_int),'') || ' ' || coalesce(trim(colonia),'') || ' ' || coalesce(trim(comunidad),'') || ' ' || coalesce(trim(ciudad),'') || ' ' || coalesce(trim(municipio),'') || ' ' || coalesce(trim(estado),'') || ' ' || coalesce(trim(cp),'') )");
//        DB::statement("CREATE INDEX searchtext_gin ON ubicaciones USING GIN(searchtext)");
//        DB::statement("CREATE TRIGGER ts_searchtext BEFORE INSERT OR UPDATE ON ubicaciones FOR EACH ROW EXECUTE PROCEDURE tsvector_update_trigger('searchtext', 'pg_catalog.spanish', 'calle', 'num_ext', 'num_int', 'colonia', 'comunidad', 'ciudad', 'municipio', 'estado', 'cp')");


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
