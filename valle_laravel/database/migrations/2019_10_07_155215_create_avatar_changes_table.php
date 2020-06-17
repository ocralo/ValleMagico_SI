<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvatarChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avatar_changes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('avatar_name');
            $table->unsignedBigInteger('game_user_id');
            $table->unsignedInteger('avatar_id');

            $table->timestamps();
            $table->foreign('game_user_id')->references('id')->on('game_users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('avatar_id')->references('id')->on('avatars')->onDelete('cascade')->onUpdate('cascade');
        });

        DB::statement("ALTER TABLE avatar_changes AUTO_INCREMENT = 500;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('avatar_changes');
    }
}
