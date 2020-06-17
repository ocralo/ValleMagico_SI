<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameUserRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_user_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('errors');
            $table->tinyInteger('repeated_guide');
            $table->tinyInteger('total_score');
            $table->unsignedInteger('mini_game_id');
            $table->unsignedBigInteger('game_user_id');

            $table->timestamps();
            $table->foreign('mini_game_id')->references('id')->on('mini_games')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('game_user_id')->references('id')->on('game_users')->onDelete('cascade')->onUpdate('cascade');
        });

        DB::statement("ALTER TABLE game_user_records AUTO_INCREMENT = 25000;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_user_records');
    }
}
