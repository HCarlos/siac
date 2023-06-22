<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsermobileMessagerequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usermobile_messagerequest', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('usermobile_id')->index();
            $table->unsignedInteger('usermobilemessage_id')->index();
            $table->unsignedInteger('user_id')->index();
            $table->string('multicast_id')->default('');
            $table->unsignedInteger('success')->default(0);
            $table->unsignedInteger('failure')->default(0);
            $table->unsignedInteger('canonical_ids')->default(0);
            $table->string('message_id')->default('');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('usermobilemessage_id')
                ->references('id')
                ->on('usermobile_message')
                ->onDelete('cascade');

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
    public function down()
    {
        Schema::dropIfExists('usermobile_messagerequest');
    }
}
