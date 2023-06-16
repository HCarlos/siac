<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        $tableNamesCatalogos = config('atemun.table_names.catalogos');

        Schema::create('logs', function (Blueprint $table) use ($tableNamesCatalogos){
            $table->id();
            $table->string('model_name',128)->default('');
            $table->integer('model_id')->default(0);
            $table->integer('trigger_type')->default(0);
            $table->string('trigger_status',128)->default('');
            $table->string('message',500)->default('');
            $table->string('icon',25)->default('');
            $table->string('status',5)->default('');
            $table->datetime('fecha')->default(now());
            $table->string('ip',250)->default('');
            $table->string('host',250)->default('');
            $table->integer('user_id')->default(0)->index();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on($tableNamesCatalogos['users'])
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
        Schema::dropIfExists('logs');
    }
}
