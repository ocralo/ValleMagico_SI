<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDescriptionStylesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('description_styles', function (Blueprint $table) {
            $table->increments('id');
            $table->text('description');
            $table->unsignedInteger('style_id');
            $table->timestamps();

            $table->foreign('style_id')->references('id')->on('styles')->onDelete('cascade')->onUpdate('cascade');
        });

        DB::statement("ALTER TABLE description_styles AUTO_INCREMENT = 700;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('description_styles');
    }
}
