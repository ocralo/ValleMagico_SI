<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDissabilityGameUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dissability_game_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('game_user_id');
            $table->unsignedInteger('dissability_id');
            $table->timestamps();

            $table->foreign('game_user_id')->references('id')->on('game_users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('dissability_id')->references('id')->on('dissabilities')->onDelete('cascade')->onUpdate('cascade');
        });

        DB::statement("ALTER TABLE dissability_game_user AUTO_INCREMENT = 900;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dissability_game_user');
    }
}
