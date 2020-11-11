<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMiniGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mini_games', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('id_code');
            $table->unsignedInteger('location_id')->nullable();
            $table->integer('grade_id')->nullable();
            $table->timestamps();

            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('grade_id')->references('id')->on('grades')->onDelete('cascade')->onUpdate('cascade');
        });

        DB::statement("ALTER TABLE mini_games AUTO_INCREMENT = 1;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mini_games');
    }
}
