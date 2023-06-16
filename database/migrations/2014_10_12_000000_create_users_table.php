<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableNames = config('atemun.table_names.users');
        Schema::create($tableNames['users'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nombre')->nullable();
            $table->string('ap_paterno')->nullable();
            $table->string('ap_materno')->nullable();
            $table->string('curp',18)->default('')->nullable();
            $table->string('emails',500)->default('')->nullable();
            $table->string('celulares',250)->default('')->nullable();
            $table->string('telefonos',250)->default('')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->smallInteger('genero')->default(0)->nullable();
            $table->string('root',150)->default('')->nullable();
            $table->string('filename',50)->nullable();
            $table->string('filename_png',50)->nullable();
            $table->string('filename_thumb',50)->nullable();
            $table->boolean('admin')->default(false);
            $table->boolean('alumno')->default(false);
            $table->boolean('delegado')->default(false);
            $table->string('session_id')->nullable();
            $table->unsignedSmallInteger('status_user')->default(1)->nullable();
            $table->unsignedSmallInteger('empresa_id')->default(0)->nullable();
            $table->string('ip',150)->default('')->nullable();
            $table->string('host',150)->default('')->nullable();
            $table->index('empresa_id');
            $table->boolean('logged')->default(false)->index();
            $table->timestamp('logged_at')->nullable()->index();
            $table->timestamp('logout_at')->nullable()->index();
            $table->timestamp('email_verified_at')->nullable();
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create($tableNames['user_adress'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->string('calle',250)->default('')->nullable();
            $table->string('num_ext',100)->default('')->nullable();
            $table->string('num_int',100)->default('')->nullable();
            $table->string('colonia',150)->default('')->nullable();
            $table->string('localidad',150)->default('')->nullable();
            $table->string('municipio',50)->default('')->nullable();
            $table->string('estado',50)->default('TABASCO')->nullable();
            $table->string('pais',25)->default('MÉXICO')->nullable();
            $table->string('cp',10)->default('')->nullable();
            $table->unsignedInteger('user_id');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')
                ->on($tableNames['users'])
                ->onDelete('cascade');
        });

        Schema::create($tableNames['user_extend'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->string('ocupacion',250)->default('')->nullable();
            $table->string('profesion',250)->default('')->nullable();
            $table->string('lugar_trabajo',250)->default('')->nullable();
            $table->string('lugar_nacimiento',250)->default('')->nullable();
            $table->unsignedInteger('user_id');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')
                ->on($tableNames['users'])
                ->onDelete('cascade');
        });

        Schema::create($tableNames['categorias'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('categoria',150)->default('')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableNames = config('atemun.table_names.users');
        Schema::dropIfExists($tableNames['categorias']);
        Schema::dropIfExists($tableNames['user_adress']);
        Schema::dropIfExists($tableNames['user_extend']);
        Schema::dropIfExists($tableNames['users']);
    }
}
