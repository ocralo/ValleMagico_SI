<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuRecordIntelligenceIndDescStylesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gu_record_intelligence_ind_desc_styles', function (Blueprint $table) {
            $table->Bigincrements('id');
            $table->unsignedBigInteger('game_user_record_id');
            $table->unsignedInteger('intelligence_indicator_id')->nullable();
            $table->unsignedInteger('description_style_id')->nullable();
            $table->unsignedInteger('vocational_orientation_id')->nullable();
            $table->unsignedBigInteger('competence_id');
            $table->integer('percentage_value')->nullable();
            $table->timestamps();

            $table->foreign('game_user_record_id', 'idgur_foreign')->references('id')->on('game_user_records')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('intelligence_indicator_id', 'idintind_foreign')->references('id')->on('intelligence_indicators')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('description_style_id', 'iddescstyle_foreign')->references('id')->on('description_styles')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('competence_id', 'idcomp_foreign')->references('id')->on('competences')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('vocational_orientation_id', 'idvocor_foreign')->references('id')->on('vocationals_orientations')->onDelete('cascade')->onUpdate('cascade');
        });

        DB::statement("ALTER TABLE gu_record_intelligence_ind_desc_styles AUTO_INCREMENT = 100000;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gu_record_intelligence_ind_desc_styles');
    }
}
