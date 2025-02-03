<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContributorRecruitmentPhaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recruitment_subphase_contributor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recruitment_subphase_id')->constrained()->onDelete('cascade');
            $table->foreignId('contributor_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contributor_recruitment_phase');
    }
}
