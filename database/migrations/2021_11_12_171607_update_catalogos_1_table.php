<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateCatalogos1Table extends Migration{


    public function up(){
        $Users      = config('atemun.table_names.users');
        $Domicilios = config('atemun.table_names.domicilios');
        $Catalogos = config('atemun.table_names.catalogos');

        if (Schema::hasTable($Domicilios['calles'])) {
            Schema::table($Domicilios['calles'], function (Blueprint $table) use ($Domicilios, $Users) {
                $table->unsignedInteger('calle_mig_id')->default(0)->index();
            });
        }

        if (Schema::hasTable($Domicilios['colonias'])) {
            Schema::table($Domicilios['colonias'], function (Blueprint $table) use ($Domicilios, $Users) {
                $table->unsignedInteger('colonia_mig_id')->default(0)->index();
            });
        }

        if (Schema::hasTable($Domicilios['localidades'])) {
            Schema::table($Domicilios['localidades'], function (Blueprint $table) use ($Domicilios, $Users) {
                $table->unsignedInteger('localidad_mig_id')->default(0)->index();
            });
        }

        if (Schema::hasTable($Domicilios['comunidades'])) {
            Schema::table($Domicilios['comunidades'], function (Blueprint $table) use ($Domicilios, $Users) {
                $table->unsignedInteger('comunidad_mig_id')->default(0)->index();
            });
        }

        if (Schema::hasTable($Domicilios['ciudades'])) {
            Schema::table($Domicilios['ciudades'], function (Blueprint $table) use ($Domicilios, $Users) {
                $table->unsignedInteger('municipio_id')->default(1)->index();
                $table->unsignedInteger('ciudad_mig_id')->default(0)->index();

                $table->foreign('municipio_id')
                    ->references('id')
                    ->on($Domicilios['municipios'])
                    ->onDelete('cascade');

            });
        }

        if (Schema::hasTable($Domicilios['municipios'])) {
            Schema::table($Domicilios['municipios'], function (Blueprint $table) use ($Domicilios, $Users) {
                $table->unsignedInteger('estado_id')->default(1)->index();
                $table->unsignedInteger('numero_municipio')->default(0)->index();
                $table->unsignedInteger('municipio_mig_id')->default(0)->index();

                $table->foreign('estado_id')
                    ->references('id')
                    ->on($Domicilios['estados'])
                    ->onDelete('cascade');

            });
        }

        if (Schema::hasTable($Domicilios['estados'])) {
            Schema::table($Domicilios['estados'], function (Blueprint $table) use ($Domicilios, $Users) {
                $table->unsignedInteger('estado_mig_id')->default(0)->index();
            });
        }

        if (Schema::hasTable($Domicilios['codigospostales'])) {
            Schema::table($Domicilios['codigospostales'], function (Blueprint $table) use ($Domicilios, $Users) {
                $table->unsignedInteger('cp_mig_id')->default(0)->index();
            });
        }

        if (Schema::hasTable($Users['users'])) {
            Schema::table($Users['users'], function (Blueprint $table) use ($Domicilios, $Users) {
                $table->unsignedInteger('user_mig_id')->default(0)->index();
            });
        }

        Schema::create($Domicilios['ubicacion_user'], function (Blueprint $table) use ($Catalogos, $Domicilios, $Users) {
            $table->increments('id');
            $table->integer('ubicacion_id');
            $table->integer('user_id');
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['ubicacion_id', 'user_id']);

            $table->foreign('ubicacion_id')
                ->references('id')
                ->on($Domicilios['ubicaciones'])
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on($Users['users'])
                ->onDelete('cascade');
        });

        Schema::create($Catalogos['denuncia_user'], function (Blueprint $table) use ($Catalogos, $Domicilios, $Users) {
                $table->increments('id');
                $table->integer('denuncia_id');
                $table->integer('user_id');
                $table->softDeletes();
                $table->timestamps();
                $table->unique(['denuncia_id', 'user_id']);

                $table->foreign('denuncia_id')
                    ->references('id')
                    ->on($Catalogos['denuncias'])
                    ->onDelete('cascade');

                $table->foreign('user_id')
                    ->references('id')
                    ->on($Users['users'])
                    ->onDelete('cascade');

        });




        DB::statement("ALTER DATABASE dbatemun set default_text_search_config = 'spanish'");
        DB::statement("ALTER TABLE users ADD COLUMN searchtext TSVECTOR");
        DB::statement("UPDATE users SET searchtext = to_tsvector('spanish', coalesce(trim(ap_paterno),'') || ' ' || coalesce(trim(ap_paterno),'') || ' ' || coalesce(trim(nombre),'') || ' ' || coalesce(trim(curp),'') || ' ' || coalesce(trim(username),'') || ' ' || coalesce(trim(email),'') )");
        DB::statement("CREATE INDEX user_searchtext_gin ON users USING GIN(searchtext)");
        DB::statement("CREATE TRIGGER ts_searchtext_user1 BEFORE INSERT OR UPDATE ON users FOR EACH ROW EXECUTE PROCEDURE tsvector_update_trigger('searchtext', 'pg_catalog.spanish', 'ap_paterno', 'ap_materno', 'nombre', 'curp', 'username', 'email')");



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        $Users      = config('atemun.table_names.users');
        $Domicilios = config('atemun.table_names.domicilios');
        $Catalogos  = config('atemun.table_names.catalogos');

        if (Schema::hasTable($Domicilios['calles'])) {
            Schema::table($Domicilios['calles'], function (Blueprint $table) use ($Domicilios) {
                $table->dropColumn('calle_mig_id');
            });
        }

        if (Schema::hasTable($Domicilios['colonias'])) {
            Schema::table($Domicilios['colonias'], function (Blueprint $table) use ($Domicilios) {
                $table->dropColumn('colonia_mig_id');
            });
        }

        if (Schema::hasTable($Domicilios['localidades'])) {
            Schema::table($Domicilios['localidades'], function (Blueprint $table) use ($Domicilios) {
                $table->dropColumn('localidad_mig_id');
            });
        }

        if (Schema::hasTable($Domicilios['comunidades'])) {
            Schema::table($Domicilios['comunidades'], function (Blueprint $table) use ($Domicilios) {
                $table->dropColumn('comunidad_mig_id');
            });
        }

        if (Schema::hasTable($Domicilios['ciudades'])) {
            Schema::table($Domicilios['ciudades'], function (Blueprint $table) use ($Domicilios) {
                $table->dropColumn('municipio_id');
                $table->dropColumn('ciudad_mig_id');
            });
        }

        if (Schema::hasTable($Domicilios['municipios'])) {
            Schema::table($Domicilios['municipios'], function (Blueprint $table) use ($Domicilios) {
                $table->dropColumn('estado_id');
                $table->dropColumn('numero_municipio');
                $table->dropColumn('municipio_mig_id');
            });
        }

        if (Schema::hasTable($Domicilios['estados'])) {
            Schema::table($Domicilios['estados'], function (Blueprint $table) use ($Domicilios) {
                $table->dropColumn('estado_mig_id');
            });
        }

        if (Schema::hasTable($Domicilios['codigospostales'])) {
            Schema::table($Domicilios['codigospostales'], function (Blueprint $table) use ($Domicilios) {
                $table->dropColumn('cp_mig_id');
            });
        }

        if (Schema::hasTable($Users['users'])) {
            Schema::table($Users['users'], function (Blueprint $table) use ($Users) {
                $table->dropColumn('user_mig_id');
            });
        }

        Schema::dropIfExists($Domicilios['ubicacion_user']);
        Schema::dropIfExists($Catalogos['denuncia_user']);

        DB::statement("DROP TRIGGER IF EXISTS ts_searchtext_user1 ON users");
        DB::statement("DROP INDEX IF EXISTS user_searchtext_gin");
        DB::statement("ALTER TABLE users DROP COLUMN IF EXISTS searchtext");

    }



}
