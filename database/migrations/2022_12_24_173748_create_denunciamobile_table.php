<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDenunciamobileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        $tableNames = config('atemun.table_names.mobiles');

        if (! Schema::hasTable($tableNames['serviciomobile'])) {
            Schema::create($tableNames['serviciomobile'], function (Blueprint $table) use ($tableNames) {
                $table->id();
                $table->string("servicio", 250)->default("")->nullable(false);
                $table->boolean('habilitado')->default(true);
                $table->boolean('is_visible_mobile')->default(true);
                $table->string("url_image_mobile", 250)->default("")->nullable(false);
                $table->integer("orden_image_mobile")->index();
                $table->integer("dependencia_id")->index();
                $table->integer("area_id")->index();
                $table->integer("subarea_id")->index();
                $table->integer("servicio_id")->index();
                $table->softDeletes();
                $table->timestamps();

                $table->foreign('dependencia_id')
                    ->references('id')
                    ->on($tableNames['dependencias'])
                    ->onDelete('cascade');

                $table->foreign('area_id')
                    ->references('id')
                    ->on($tableNames['areas'])
                    ->onDelete('cascade');

                $table->foreign('subarea_id')
                    ->references('id')
                    ->on($tableNames['subareas'])
                    ->onDelete('cascade');

                $table->foreign('servicio_id')
                    ->references('id')
                    ->on($tableNames['servicios'])
                    ->onDelete('cascade');

            });
        }

        if (!Schema::hasTable($tableNames['denunciamobile'])) {
            Schema::create($tableNames['denunciamobile'], function (Blueprint $table) use ($tableNames){
                $table->id();
                $table->string("denuncia",500)->default("")->nullable(false);
                $table->dateTime('fecha')->nullable();
                $table->string("tipo_mobile",100)->default("");
                $table->string("marca_mobile",100)->default("");
                $table->integer("serviciomobile_id")->default(0)->index();
                $table->integer("ubicacion_id")->default(1)->index();
                $table->string("ubicacion",500)->default("")->nullable();
                $table->string("ubicacion_google",500)->default("")->nullable();
                $table->integer("user_id")->default(0)->index();
                $table->double('latitud')->default(0.00);
                $table->double('longitud')->default(0.00);
                $table->double('altitud')->default(0.00);
                $table->timestamps();
                $table->foreign('serviciomobile_id')
                    ->references('id')
                    ->on($tableNames['serviciomobile'])
                    ->onDelete('cascade');

                $table->foreign('ubicacion_id')
                    ->references('id')
                    ->on($tableNames['ubicaciones'])
                    ->onDelete('cascade');

                $table->foreign('user_id')
                    ->references('id')
                    ->on($tableNames['users'])
                    ->onDelete('cascade');

            });
        }

        if (!Schema::hasTable($tableNames['imagemobile'])) {
            Schema::create($tableNames['imagemobile'], function (Blueprint $table) use ($tableNames) {
                $table->id();
                $table->dateTime('fecha')->nullable();
                $table->string('root', 150)->default("")->nullable();
                $table->string('filename', 100)->default("")->nullable();
                $table->string('filename_png', 100)->default("")->nullable();
                $table->string('filename_thumb', 100)->default("")->nullable();
                $table->string('titulo', 150)->default("")->nullable();
                $table->string('descripcion', 500)->default("")->nullable();
                $table->string('momento', 10)->default("ANTES")->nullable();
                $table->unsignedInteger('user_id')->default(0)->index();
                $table->unsignedInteger('denunciamobile_id')->default(0)->index();
                $table->unsignedInteger('parent_id')->default(0)->index();
                $table->double('latitud')->default(0.00);
                $table->double('longitud')->default(0.00);
                $table->double('altitud')->default(0.00);
                $table->softDeletes();
                $table->timestamps();

                $table->foreign('denunciamobile_id')
                    ->references('id')
                    ->on($tableNames['denunciamobile'])
                    ->onDelete('cascade');

                $table->foreign('user_id')
                    ->references('id')
                    ->on($tableNames['users'])
                    ->onDelete('cascade');

            });
        }


        if (!Schema::hasTable($tableNames['denunciamobile_imagemobile'])) {
            Schema::create($tableNames['denunciamobile_imagemobile'], function (Blueprint $table) use ($tableNames) {
                $table->increments('id');
                $table->unsignedInteger('denunciamobile_id')->default(0)->index();
                $table->unsignedInteger('imagemobile_id')->default(0)->index();
                $table->softDeletes();
                $table->timestamps();
                $table->unique(['denunciamobile_id', 'imagemobile_id']);

                $table->foreign('denunciamobile_id')
                    ->references('id')
                    ->on($tableNames['denunciamobile'])
                    ->onDelete('cascade');

                $table->foreign('imagemobile_id')
                    ->references('id')
                    ->on($tableNames['imagemobile'])
                    ->onDelete('cascade');
            });
        }


        if (!Schema::hasTable($tableNames['imagemobile_parent'])) {
            Schema::create($tableNames['imagemobile_parent'], function (Blueprint $table) use ($tableNames) {
                $table->increments('id');
                $table->unsignedInteger('image_id')->default(0)->index();
                $table->unsignedInteger('image_parent_id')->default(0)->index();
                $table->softDeletes();
                $table->timestamps();
                $table->unique(['image_id', 'image_parent_id']);

                $table->foreign('image_id')
                    ->references('id')
                    ->on($tableNames['imagemobile'])
                    ->onDelete('cascade');

                $table->foreign('image_parent_id')
                    ->references('id')
                    ->on($tableNames['imagemobile'])
                    ->onDelete('cascade');

            });

            if (!Schema::hasTable($tableNames['imagemobile_user'])) {
                Schema::create($tableNames['imagemobile_user'], function (Blueprint $table) use ($tableNames) {
                    $table->increments('id');
                    $table->unsignedInteger('image_id')->default(0)->index();
                    $table->unsignedInteger('user_id')->default(0)->index();
                    $table->softDeletes();
                    $table->timestamps();
                    $table->unique(['image_id', 'user_id']);

                    $table->foreign('image_id')
                        ->references('id')
                        ->on($tableNames['imagemobile'])
                        ->onDelete('cascade');

                    $table->foreign('user_id')
                        ->references('id')
                        ->on($tableNames['users'])
                        ->onDelete('cascade');

                });


            }


        }





    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('imagemobile_parent');
        Schema::dropIfExists('denunciamobile_imagenemobile');
        Schema::dropIfExists('imagemobile');
        Schema::dropIfExists('denunciamobile');
        Schema::dropIfExists('serviciomobile');

    }
}
