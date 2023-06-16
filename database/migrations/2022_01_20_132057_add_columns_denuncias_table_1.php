<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsDenunciasTable1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        $Catalogos = config('atemun.table_names.catalogos');

        Schema::create($Catalogos['firmas'], function (Blueprint $table) use ($Catalogos) {
            $table->increments('id');
            $table->string('archivo_cer',100)->default('');
            $table->string('sello_cer',4000)->default('');
            $table->string('archivo_key',100)->default('');
            $table->string('sello_key',4000)->default('');
            $table->string('password',100)->default('');
            $table->string('cadena_original',250)->default('');
            $table->string('hash',50)->default('');
            $table->string('sello',500)->default('');
            $table->boolean('valido')->default(false);
            $table->dateTime('fecha_firmado')->default(now());
            $table->unsignedInteger('firmadopor_id')->default(0)->nullable()->index();
            $table->string('ip',150)->default('')->nullable();
            $table->string('host',150)->default('')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        if (Schema::hasTable($Catalogos['denuncias'])) {
            Schema::table($Catalogos['denuncias'], function (Blueprint $table) use ($Catalogos) {
                $table->boolean('cerrado')->default(false);
                $table->dateTime('fecha_cerrado')->default(now());
                $table->unsignedInteger('cerradopor_id')->default(0)->nullable()->index();
                $table->boolean('firmado')->default(false);
            });
        }

        Schema::create($Catalogos['denuncia_firma'], function (Blueprint $table) use ($Catalogos) {
            $table->increments('id');
            $table->integer('denuncia_id');
            $table->integer('firma_id');
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['denuncia_id', 'firma_id']);

            $table->foreign('denuncia_id')
                ->references('id')
                ->on($Catalogos['denuncias'])
                ->onDelete('cascade');

            $table->foreign('firma_id')
                ->references('id')
                ->on($Catalogos['firmas'])
                ->onDelete('cascade');
        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){

        $Catalogos = config('atemun.table_names.catalogos');
        Schema::dropIfExists($Catalogos['denuncia_firma']);
        Schema::dropIfExists($Catalogos['firmas']);

        if (Schema::hasTable($Catalogos['denuncias'])) {
            Schema::table($Catalogos['denuncias'], function (Blueprint $table)  {
                $table->dropColumn('cerrado');
                $table->dropColumn('fecha_cerrado');
                $table->dropColumn('cerradopor_id');
                $table->dropColumn('firmado');
            });
        }

    }
}
