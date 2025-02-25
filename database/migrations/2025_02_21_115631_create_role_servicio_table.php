<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleServicioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        $tableNames = config('atemun.table_names.catalogos');

        Schema::dropIfExists($tableNames['servicio_user']);
        Schema::dropIfExists($tableNames['denuncia_operador']);
        Schema::dropIfExists($tableNames['centro_localidades']);

        Schema::create($tableNames['servicio_user'], function (Blueprint $table) use ($tableNames){
            $table->increments('id');
            $table->Integer('user_id')->default(0)->index();
            $table->Integer('servicio_id')->default(0)->index();
            $table->tinyInteger('orden')->default(0);
            $table->boolean('predeterminado')->default(false);
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['user_id', 'servicio_id']);

            $table->foreign('user_id')
                ->references('id')
                ->on($tableNames['users'])
                ->onDelete('cascade');

            $table->foreign('servicio_id')
                ->references('id')
                ->on($tableNames['servicios'])
                ->onDelete('cascade');

        });

        Schema::create($tableNames['denuncia_operador'], function (Blueprint $table) use ($tableNames){
            $table->increments('id');
            $table->Integer('operador_id')->default(0)->index();
            $table->Integer('denuncia_id')->default(0)->index();
            $table->tinyInteger('orden')->default(0);
            $table->dateTime('fecha_asignacion')->default(now());
            $table->dateTime('fecha_ejecucion')->default(now());
            $table->text('observaciones')->nullable();
            $table->boolean('cerrada')->default(false)->nullable();
            $table->boolean('predeterminado')->default(false)->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['operador_id', 'denuncia_id']);

            $table->foreign('operador_id')
                ->references('id')
                ->on($tableNames['users'])
                ->onDelete('cascade');

            $table->foreign('denuncia_id')
                ->references('id')
                ->on($tableNames['denuncias'])
                ->onDelete('cascade');

        });

        Schema::create($tableNames['centro_localidades'], function (Blueprint $table) use ($tableNames){
            $table->increments('id');
            $table->Integer('consecutivo')->default(1)->index();
            $table->Integer('zona_id')->default(0)->index();
            $table->string('zona',250)->default('')->nullable();
            $table->Integer('delegacion_id')->default(0)->index();
            $table->string('prefijo_delegacion',50)->default('')->nullable();
            $table->string('delegacion',250)->default('')->nullable();
            $table->Integer('colonia_id')->default(0)->index();
            $table->string('prefijo_colonia',50)->default('')->nullable();
            $table->string('colonia',250)->default('')->nullable();
            $table->Integer('delegado_id')->default(1)->index();
            $table->boolean('activo')->default(true)->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['zona_id', 'delegacion_id', 'colonia_id', 'delegado_id']);

            $table->foreign('delegado_id')
                ->references('id')
                ->on($tableNames['users'])
                ->onDelete('cascade');

        });

        if (Schema::hasTable($tableNames['denuncias'])) {
            Schema::table($tableNames['denuncias'], function (Blueprint $table) use ($tableNames) {
                $table->integer('centro_localidad_id')->default(0)->nullable()->index()->comment('Guarda el ID de la tabla Centro_Localidad');
            });
        }






    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        $Catalogos  = config('atemun.table_names.catalogos');

        Schema::dropIfExists($Catalogos['servicio_user']);
        Schema::dropIfExists($Catalogos['denuncia_operador']);
        Schema::dropIfExists($Catalogos['centro_localidades']);

        if (Schema::hasTable($Catalogos['denuncias'])) {
            Schema::table($Catalogos['denuncias'], function (Blueprint $table) use ($Catalogos) {
                $table->dropColumn('centro_localidad_id');
            });
        }

    }
}
