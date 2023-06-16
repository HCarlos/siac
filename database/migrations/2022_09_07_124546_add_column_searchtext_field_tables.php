<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddColumnSearchtextFieldTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        // Tabla de Calles
        DB::statement("ALTER DATABASE dbatemun set default_text_search_config = 'spanish'");
        DB::statement("ALTER TABLE calles DROP COLUMN IF EXISTS searchtextcalle");
        DB::statement("ALTER TABLE calles ADD COLUMN searchtextcalle TSVECTOR");
        DB::statement("UPDATE calles SET searchtextcalle = to_tsvector('spanish', coalesce(trim(calle), '')  )");
        DB::statement("CREATE INDEX searchtextcalle ON calles USING GIN(searchtextcalle)");
        DB::statement("CREATE TRIGGER ts_searchtextcalle BEFORE INSERT OR UPDATE ON calles FOR EACH ROW EXECUTE PROCEDURE tsvector_update_trigger('searchtextcalle', 'pg_catalog.spanish', 'calle')");

        // Tabla de Colonias
        DB::statement("ALTER DATABASE dbatemun set default_text_search_config = 'spanish'");
        DB::statement("ALTER TABLE colonias DROP COLUMN IF EXISTS searchtextcolonia");
        DB::statement("ALTER TABLE colonias ADD COLUMN searchtextcolonia TSVECTOR");
        DB::statement("UPDATE colonias SET searchtextcolonia = to_tsvector('spanish', coalesce(trim(colonia), '')  )");
        DB::statement("CREATE INDEX searchtextcolonia ON colonias USING GIN(searchtextcolonia)");
        DB::statement("CREATE TRIGGER ts_searchtextcolonia BEFORE INSERT OR UPDATE ON colonias FOR EACH ROW EXECUTE PROCEDURE tsvector_update_trigger('searchtextcolonia', 'pg_catalog.spanish', 'colonia')");

        // Tabla de Comunidades
        DB::statement("ALTER DATABASE dbatemun set default_text_search_config = 'spanish'");
        DB::statement("ALTER TABLE comunidades DROP COLUMN IF EXISTS searchtextcomunidad");
        DB::statement("ALTER TABLE comunidades ADD COLUMN searchtextcomunidad TSVECTOR");
        DB::statement("UPDATE comunidades SET searchtextcomunidad = to_tsvector('spanish', coalesce(trim(comunidad), '')  )");
        DB::statement("CREATE INDEX searchtextcomunidad ON comunidades USING GIN(searchtextcomunidad)");
        DB::statement("DROP TRIGGER IF EXISTS ts_searchtextcomundiad ON comunidades");
        DB::statement("CREATE TRIGGER ts_searchtextcomundiad BEFORE INSERT OR UPDATE ON comunidades FOR EACH ROW EXECUTE PROCEDURE tsvector_update_trigger('searchtextcomunidad', 'pg_catalog.spanish', 'comunidad')");

        // Tabla de Municipios
        DB::statement("ALTER DATABASE dbatemun set default_text_search_config = 'spanish'");
        DB::statement("ALTER TABLE municipios DROP COLUMN IF EXISTS searchtextmunicipio");
        DB::statement("ALTER TABLE municipios ADD COLUMN searchtextmunicipio TSVECTOR");
        DB::statement("UPDATE municipios SET searchtextmunicipio = to_tsvector('spanish', coalesce(trim(municipio), '')  )");
        DB::statement("CREATE INDEX searchtextmunicipio ON municipios USING GIN(searchtextmunicipio)");
        DB::statement("DROP TRIGGER IF EXISTS ts_searchtextmunicipio ON municipios");
        DB::statement("CREATE TRIGGER ts_searchtextmunicipio BEFORE INSERT OR UPDATE ON municipios FOR EACH ROW EXECUTE PROCEDURE tsvector_update_trigger('searchtextmunicipio', 'pg_catalog.spanish', 'municipio')");

        // Tabla de Estados
        DB::statement("ALTER DATABASE dbatemun set default_text_search_config = 'spanish'");
        DB::statement("ALTER TABLE estados DROP COLUMN IF EXISTS searchtextestado");
        DB::statement("ALTER TABLE estados ADD COLUMN searchtextestado TSVECTOR");
        DB::statement("UPDATE estados SET searchtextestado = to_tsvector('spanish', coalesce(trim(estado), '')  )");
        DB::statement("CREATE INDEX searchtextestado ON estados USING GIN(searchtextestado)");
        DB::statement("DROP TRIGGER IF EXISTS ts_searchtextestado ON estados");
        DB::statement("CREATE TRIGGER ts_searchtextestado BEFORE INSERT OR UPDATE ON estados FOR EACH ROW EXECUTE PROCEDURE tsvector_update_trigger('searchtextestado', 'pg_catalog.spanish', 'estado')");

        // Tabla de Localidades
        DB::statement("ALTER DATABASE dbatemun set default_text_search_config = 'spanish'");
        DB::statement("ALTER TABLE localidades DROP COLUMN IF EXISTS searchtextlocalidad");
        DB::statement("ALTER TABLE localidades ADD COLUMN searchtextlocalidad TSVECTOR");
        DB::statement("UPDATE localidades SET searchtextlocalidad = to_tsvector('spanish', coalesce(trim(localidad), '')  )");
        DB::statement("CREATE INDEX searchtextlocalidad ON localidades USING GIN(searchtextlocalidad)");
        DB::statement("DROP TRIGGER IF EXISTS ts_searchtextlocalidad ON localidades");
        DB::statement("CREATE TRIGGER ts_searchtextlocalidad BEFORE INSERT OR UPDATE ON localidades FOR EACH ROW EXECUTE PROCEDURE tsvector_update_trigger('searchtextlocalidad', 'pg_catalog.spanish', 'localidad')");

        // Tabla de Servicios
        DB::statement("ALTER DATABASE dbatemun set default_text_search_config = 'spanish'");
        DB::statement("ALTER TABLE servicios DROP COLUMN IF EXISTS searchtextservicio");
        DB::statement("ALTER TABLE servicios ADD COLUMN searchtextservicio TSVECTOR");
        DB::statement("UPDATE servicios SET searchtextservicio = to_tsvector('spanish', coalesce(trim(servicio), '')  )");
        DB::statement("CREATE INDEX searchtextservicio ON servicios USING GIN(searchtextservicio)");
        DB::statement("DROP TRIGGER IF EXISTS ts_searchtextservicio ON servicios");
        DB::statement("CREATE TRIGGER ts_searchtextservicio BEFORE INSERT OR UPDATE ON servicios FOR EACH ROW EXECUTE PROCEDURE tsvector_update_trigger('searchtextservicio', 'pg_catalog.spanish', 'servicio')");



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){

        // Catalogo de Calles
        DB::statement("DROP TRIGGER IF EXISTS tsvector_update_trigger ON calles");
        DB::statement("DROP INDEX IF EXISTS searchtextcalle_gin");
        DB::statement("DROP TRIGGER IF EXISTS ts_searchtextcalle ON calles");
        DB::statement("ALTER TABLE calles DROP COLUMN IF EXISTS searchtextcalle");

        // Catalogo de Colonias
        DB::statement("DROP TRIGGER IF EXISTS tsvector_update_trigger ON colonias");
        DB::statement("DROP INDEX IF EXISTS searchtextcolonia_gin");
        DB::statement("DROP TRIGGER IF EXISTS ts_searchtextcolonia ON colonias");
        DB::statement("ALTER TABLE colonias DROP COLUMN IF EXISTS searchtextcolonia");

        // Catalogo de Comunidades
        DB::statement("DROP TRIGGER IF EXISTS tsvector_update_trigger ON comunidades");
        DB::statement("DROP INDEX IF EXISTS searchtextcomunidad_gin");
        DB::statement("DROP TRIGGER IF EXISTS ts_searchtextcomunidad ON comunidades");
        DB::statement("ALTER TABLE comunidades DROP COLUMN IF EXISTS searchtextcomunidad");

        // Catalogo de Municipios
        DB::statement("DROP TRIGGER IF EXISTS tsvector_update_trigger ON municipios");
        DB::statement("DROP INDEX IF EXISTS searchtextmunicipios_gin");
        DB::statement("DROP TRIGGER IF EXISTS ts_searchtextmunicipios ON municipios");
        DB::statement("ALTER TABLE municipios DROP COLUMN IF EXISTS searchtextmunicipios");

        // Catalogo de Estados
        DB::statement("DROP TRIGGER IF EXISTS tsvector_update_trigger ON estados");
        DB::statement("DROP INDEX IF EXISTS searchtextestados_gin");
        DB::statement("DROP TRIGGER IF EXISTS ts_searchtextestados ON estados");
        DB::statement("ALTER TABLE estados DROP COLUMN IF EXISTS searchtextestados");

        // Catalogo de Localidades
        DB::statement("DROP TRIGGER IF EXISTS tsvector_update_trigger ON localidades");
        DB::statement("DROP INDEX IF EXISTS searchtextlocalidad_gin");
        DB::statement("DROP TRIGGER IF EXISTS ts_searchtextlocalidad ON localidades");
        DB::statement("ALTER TABLE localidades DROP COLUMN IF EXISTS searchtextlocalidad");

        // Catalogo de Servicios
        DB::statement("DROP TRIGGER IF EXISTS tsvector_update_trigger ON servicios");
        DB::statement("DROP INDEX IF EXISTS searchtextservicio_gin");
        DB::statement("DROP TRIGGER IF EXISTS ts_searchtextservicio ON servicios");
        DB::statement("ALTER TABLE servicios DROP COLUMN IF EXISTS searchtextservicio");


    }
}
