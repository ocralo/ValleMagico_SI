<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug',30);
            $table->string('name',45);
            $table->string('desc',45);
            $table->unsignedBigInteger('destiny_hierarchy_id')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table->foreign('destiny_hierarchy_id')->references('id')->on('destiny_hierarchies')->onDelete('cascade')->onUpdate('cascade');
        });

        DB::statement("ALTER TABLE roles AUTO_INCREMENT = 1;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
