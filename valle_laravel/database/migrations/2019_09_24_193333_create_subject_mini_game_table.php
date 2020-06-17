<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectMiniGameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject_mini_game', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('subject_id');
            $table->unsignedInteger('mini_game_id');
            $table->string('dba')->nullable();
            $table->timestamps();

            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('mini_game_id')->references('id')->on('mini_games')->onDelete('cascade')->onUpdate('cascade');
        });

        DB::statement("ALTER TABLE subject_mini_game AUTO_INCREMENT = 1;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subject_mini_game');
    }
}
