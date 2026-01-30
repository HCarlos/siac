<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AgregarLatitudLongitudColumnsToImagenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::table('imagenes', function (Blueprint $table) {
            $table->float('altitud',4,10)->default(0.0000)->nullable()->index();
            $table->float('latitud',4,10)->default(0.0000)->nullable()->index();
            $table->float('longitud',4,10)->default(0.0000)->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('imagenes', function (Blueprint $table) {
            $table->dropColumn('altitud');
            $table->dropColumn('latitud');
            $table->dropColumn('longitud');
        });
    }
}
