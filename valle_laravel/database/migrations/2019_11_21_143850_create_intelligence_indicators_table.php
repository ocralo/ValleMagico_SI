<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntelligenceIndicatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intelligence_indicators', function (Blueprint $table) {
            $table->increments('id');
            $table->text('description');
            $table->unsignedInteger('intelligence_id');
            $table->timestamps();

            $table->foreign('intelligence_id')->references('id')->on('intelligences')->onDelete('cascade')->onUpdate('cascade');
        });

        DB::statement("ALTER TABLE intelligence_indicators AUTO_INCREMENT = 300;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('intelligence_indicators');
    }
}
