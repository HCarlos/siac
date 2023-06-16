<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDomiciliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $tableNames = config('atemun.table_names.domicilios');

        Schema::create($tableNames['afiliaciones'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('afiliacion',100)->default('')->nullable()->unique();
            $table->boolean('predeterminado')->default(false)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create($tableNames['calles'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('calle',150)->default('')->nullable()->unique();
            $table->boolean('predeterminado')->default(false)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create($tableNames['ciudades'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('ciudad',150)->default('')->nullable()->unique();
            $table->boolean('predeterminado')->default(false)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create($tableNames['estados'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('estado',50)->default('')->nullable()->unique();
            $table->boolean('predeterminado')->default(false)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create($tableNames['localidades'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('localidad',250)->default('')->nullable()->unique();
            $table->boolean('predeterminado')->default(false)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create($tableNames['municipios'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('municipio',100)->default('')->nullable()->unique();
            $table->boolean('predeterminado')->default(false)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create($tableNames['paises'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('pais',50)->default('')->nullable()->unique();
            $table->boolean('predeterminado')->default(false)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create($tableNames['tipocomunidades'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipocomunidad',250)->default('')->nullable()->unique();
            $table->boolean('predeterminado')->default(false)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create($tableNames['tipoasentamientos'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipoasentamiento',250)->default('')->nullable()->unique();
            $table->boolean('predeterminado')->default(false)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create($tableNames['codigospostales'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo',6)->default('')->nullable();
            $table->string('cp',6)->default('')->nullable();
            $table->boolean('predeterminado')->default(false)->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['codigo', 'cp']);
        });

        Schema::create($tableNames['asentamientos'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('asentamiento',250)->default('')->nullable()->unique();
            $table->boolean('predeterminado')->default(false)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create($tableNames['comunidades'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->string('comunidad',250)->default('')->nullable()->unique();
            $table->unsignedInteger('ciudad_id')->default(0)->index();
            $table->unsignedInteger('municipio_id')->default(0)->index();
            $table->unsignedInteger('estado_id')->default(0)->index();
            $table->unsignedInteger('delegado_id')->default(0)->index();
            $table->unsignedInteger('tipocomunidad_id')->default(0)->index();
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['delegado_id', 'comunidad' , 'tipocomunidad_id']);

//            $table->foreign('delegado_id')
//                ->references('id')
//                ->on($tableNames['users'])
//                ->onDelete('cascade');

            $table->foreign('tipocomunidad_id')
                ->references('id')
                ->on($tableNames['tipocomunidades'])
                ->onDelete('cascade');

            $table->foreign('ciudad_id')
                ->references('id')
                ->on($tableNames['ciudades'])
                ->onDelete('cascade');

            $table->foreign('municipio_id')
                ->references('id')
                ->on($tableNames['municipios'])
                ->onDelete('cascade');

            $table->foreign('estado_id')
                ->references('id')
                ->on($tableNames['estados'])
                ->onDelete('cascade');

        });


        Schema::create($tableNames['colonias'], function (Blueprint $table) use ($tableNames){
            $table->increments('id');
            $table->string('colonia',250)->default('')->nullable()->unique();
            $table->string('cp',6)->default('')->nullable();
            $table->float('altitud',4,10)->default(0)->nullable();
            $table->float('latitud',4,10)->default(0)->nullable();
            $table->float('longitud',4,10)->default(0)->nullable();
            $table->unsignedInteger('codigopostal_id')->default(0)->index();
            $table->unsignedInteger('comunidad_id')->default(0)->index();
            $table->unsignedInteger('tipocomunidad_id')->default(0)->index();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('codigopostal_id')
                ->references('id')
                ->on($tableNames['codigospostales'])
                ->onDelete('cascade');
            $table->foreign('comunidad_id')
                ->references('id')
                ->on($tableNames['comunidades'])
                ->onDelete('cascade');
            $table->foreign('tipocomunidad_id')
                ->references('id')
                ->on($tableNames['tipocomunidades'])
                ->onDelete('cascade');
        });

        Schema::create($tableNames['sepomex'], function (Blueprint $table) use ($tableNames){
            $table->increments('id');
            $table->string('zona',16)->default('')->nullable();
            $table->unsignedInteger('asentamiento_id')->default(0)->index();
            $table->unsignedInteger('tipoasentamiento_id')->default(0)->index();
            $table->unsignedInteger('codigospostal_id')->default(0)->index();
            $table->unsignedInteger('municipio_id')->default(0)->index();
            $table->unsignedInteger('estado_id')->default(0)->index();
            $table->unsignedInteger('ciudad_id')->default(0)->index();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('asentamiento_id')
                ->references('id')
                ->on($tableNames['asentamientos'])
                ->onDelete('cascade');
            $table->foreign('tipoasentamiento_id')
                ->references('id')
                ->on($tableNames['tipoasentamientos'])
                ->onDelete('cascade');
            $table->foreign('codigospostal_id')
                ->references('id')
                ->on($tableNames['codigospostales'])
                ->onDelete('cascade');
            $table->foreign('municipio_id')
                ->references('id')
                ->on($tableNames['municipios'])
                ->onDelete('cascade');
            $table->foreign('estado_id')
                ->references('id')
                ->on($tableNames['estados'])
                ->onDelete('cascade');
            $table->foreign('ciudad_id')
                ->references('id')
                ->on($tableNames['ciudades'])
                ->onDelete('cascade');
        });




    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        $tableNames = config('atemun.table_names.domicilios');

        Schema::dropIfExists($tableNames['sepomex']);
        Schema::dropIfExists($tableNames['colonias']);
        Schema::dropIfExists($tableNames['comunidades']);

        Schema::dropIfExists($tableNames['afiliaciones']);
        Schema::dropIfExists($tableNames['calles']);
        Schema::dropIfExists($tableNames['localidades']);
        Schema::dropIfExists($tableNames['ciudades']);
        Schema::dropIfExists($tableNames['municipios']);
        Schema::dropIfExists($tableNames['estados']);
        Schema::dropIfExists($tableNames['paises']);
        Schema::dropIfExists($tableNames['tipocomunidades']);
        Schema::dropIfExists($tableNames['asentamientos']);
        Schema::dropIfExists($tableNames['tipoasentamientos']);
        Schema::dropIfExists($tableNames['codigospostales']);




    }
}
