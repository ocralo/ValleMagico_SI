<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDestinyHierarchiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('destiny_hierarchies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('table_name', 45);
            $table->timestamps();
        });

        DB::statement("ALTER TABLE destiny_hierarchies AUTO_INCREMENT = 1;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('destiny_hierarchies');
    }
}
