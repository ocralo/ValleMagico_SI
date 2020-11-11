<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('second_name');
            $table->string('first_surname');
            $table->string('second_surname');
            $table->string('username');
            $table->integer('headquarter_id');
            $table->integer('grade_id');
            $table->unsignedInteger('map_skin_id')->nullable();
            $table->timestamps();

            $table->foreign('map_skin_id')->references('id')->on('map_skins')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('grade_id')->references('id')->on('grades')->onDelete('cascade')->onUpdate('cascade');
        });

        DB::statement("ALTER TABLE game_users AUTO_INCREMENT = 10000;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_users');
    }
}
