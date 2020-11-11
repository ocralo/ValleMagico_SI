<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationSkinMapSkinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_skin_map_skin', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('map_skin_id');
            $table->unsignedInteger('location_skin_id');
            $table->timestamps();

            $table->foreign('map_skin_id')->references('id')->on('map_skins')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('location_skin_id')->references('id')->on('location_skins')->onDelete('cascade')->onUpdate('cascade');
        });

        DB::statement("ALTER TABLE location_skin_map_skin AUTO_INCREMENT = 100;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location_skin_map_skin');
    }
}
