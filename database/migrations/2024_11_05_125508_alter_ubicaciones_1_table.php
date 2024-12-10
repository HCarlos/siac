<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterUbicaciones1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        $Domicilios = config('atemun.table_names.domicilios');
        $Catalogos = config('atemun.table_names.catalogos');

        if (Schema::hasTable($Domicilios['ubicaciones'])) {

            Schema::table($Domicilios['ubicaciones'], function (Blueprint $table) use ($Domicilios ) {
                $table->string('g_calle',250)->default('');
                $table->string('g_num_ext',50)->default('');
                $table->string('g_num_int',50)->default('');
                $table->string('g_colonia',150)->default('');
                $table->string('g_comunidad',150)->default('');
                $table->string('g_ciudad',100)->default('');
                $table->string('g_municipio',100)->default('');
                $table->string('g_estado',50)->default('');
                $table->string('g_cp',20)->default('');

                $table->string('search_google',500)->default('');
                $table->string('g_ubicacion',500)->default('');
                $table->double('altitud')->default(0.0000)->nullable();
            });

            Schema::table($Catalogos['denuncias'], function (Blueprint $table) use ($Catalogos ) {
                $table->string('search_google',500)->default('');
                $table->string('gd_ubicacion',500)->default('');
                $table->double('altitud')->default(0.0000)->nullable();
            });

            DB::statement("ALTER DATABASE dbatemun set default_text_search_config = 'spanish'");
            DB::statement("ALTER TABLE ubicaciones ADD COLUMN g_searchtext TSVECTOR");
            DB::statement("UPDATE ubicaciones SET g_searchtext = to_tsvector('spanish', coalesce(trim(g_ubicacion),''))");
            DB::statement("CREATE INDEX g_searchtext_gin ON ubicaciones USING GIN(g_searchtext)");
            DB::statement("CREATE TRIGGER ts_g_searchtext BEFORE INSERT OR UPDATE ON ubicaciones FOR EACH ROW EXECUTE PROCEDURE tsvector_update_trigger('g_searchtext', 'pg_catalog.spanish','g_ubicacion')");

            DB::statement("ALTER DATABASE dbatemun set default_text_search_config = 'spanish'");
            DB::statement("ALTER TABLE denuncias ADD COLUMN gd_searchtext TSVECTOR");
            DB::statement("UPDATE denuncias SET gd_searchtext = to_tsvector('spanish', coalesce(trim(gd_ubicacion),''))");
            DB::statement("CREATE INDEX gd_searchtext_gin ON denuncias USING GIN(gd_searchtext)");
            DB::statement("CREATE TRIGGER ts_gd_searchtext BEFORE INSERT OR UPDATE ON denuncias FOR EACH ROW EXECUTE PROCEDURE tsvector_update_trigger('gd_searchtext', 'pg_catalog.spanish','gd_ubicacion')");

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
            Schema::table($Domicilios['ubicaciones'], function (Blueprint $table) use ($Domicilios ) {
                $table->dropColumn(['g_calle','g_num_ext','g_num_int','g_colonia','g_comunidad','g_ciudad','g_municipio','g_estado','g_cp','g_ubicacion','search_google','altitud']);
            });
            DB::statement("DROP INDEX IF EXISTS g_searchtext_gin");
            DB::statement("DROP TRIGGER IF EXISTS ts_g_searchtext ON ubicaciones");
            DB::statement("ALTER TABLE ubicaciones DROP COLUMN IF EXISTS g_searchtext");

        }

        if (Schema::hasTable($Catalogos['denuncias'])) {
            Schema::table($Catalogos['denuncias'], function (Blueprint $table) use ($Catalogos ) {
                $table->dropColumn(['gd_ubicacion','search_google','altitud']);
            });
            DB::statement("DROP INDEX IF EXISTS gd_searchtext_gin");
            DB::statement("DROP TRIGGER IF EXISTS ts_gd_searchtext ON denuncias");
            DB::statement("ALTER TABLE denuncias DROP COLUMN IF EXISTS gd_searchtext");

        }




    }
}
