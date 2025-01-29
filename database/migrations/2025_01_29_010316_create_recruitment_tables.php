<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecruitmentTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('jobs')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('current_job_title')->nullable();
            $table->string('company')->nullable();
            $table->integer('years_of_experience');
            $table->string('phone');
            $table->string('country');
            $table->string('city');
            $table->enum('status', ['pending', 'accept', 'reject'])->default('pending');
            $table->timestamps();
        });

        Schema::create('recruitment_processes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id')->constrained('candidates')->onDelete('cascade');
            $table->enum('current_phase', ['application_received', 'selection', 'preparation', 'transfer', 'offer_stage'])->default('application_received');
            $table->timestamps();
        });

        Schema::create('recruitment_subphases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recruitment_process_id')->constrained('recruitment_processes')->onDelete('cascade');
            $table->string('phase');
            $table->string('subphase');
            $table->dateTime('scheduled_at')->nullable();
            $table->string('meeting_link')->nullable();
            $table->string('meeting_title')->nullable();
            $table->text('description')->nullable();
            $table->boolean('completed')->default(false);
            $table->text('feedback')->nullable();
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
        Schema::dropIfExists('recruitment_subphases');
        Schema::dropIfExists('recruitment_processes');
        Schema::dropIfExists('candidates');
    }
}
