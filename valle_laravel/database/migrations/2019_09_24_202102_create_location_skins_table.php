<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationSkinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_skins', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('location_id');
            $table->tinyInteger('level');
            $table->tinyInteger('skin');
            $table->timestamps();

            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade')->onUpdate('cascade');
        });

        DB::statement("ALTER TABLE location_skins AUTO_INCREMENT = 100;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location_skins');
    }
}
