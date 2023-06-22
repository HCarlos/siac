<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsermobileMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usermobile_message', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('usermobile_id')->index();
            $table->unsignedInteger('user_id')->index();
            $table->string('campania')->default('');
            $table->string('title')->default('');
            $table->string('message')->default('');
            $table->date('fecha')->default(now());
            $table->boolean('is_read')->default(false)->index();
            $table->string('tags')->default('');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('usermobile_id')
                ->references('id')
                ->on('usermobile')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('usermobile_message');
    }
}
