<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecomendationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recomendations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('performance_id');
            $table->unsignedInteger('subject_id');
            $table->unsignedBigInteger('hierarchy_id');
            $table->integer('grade_id');
            $table->text('recomendation');
            $table->timestamps();

            $table->foreign('performance_id')->references('id')->on('performances')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('hierarchy_id')->references('id')->on('destiny_hierarchies')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('grade_id')->references('id')->on('grades')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recomendations');
    }
}
