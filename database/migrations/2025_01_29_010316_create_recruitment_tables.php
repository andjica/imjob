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
    public function up(): void
    {
        // Table for storing all available subphases linked to their respective phases
        Schema::create('available_recruitment_subphases', function (Blueprint $table) {
            $table->id();
            $table->enum('phase', ['selection', 'preparation', 'transfer', 'offer_stage']);
            $table->string('subphase');
            $table->timestamps();
        });

        
       // New table: candidat profiles
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
            $table->foreignId('city_id')->constrained('cities')->onDelete('cascade');
            $table->string('phone');
            $table->string('profile_image')->nullable();
            $table->date('birthday')->nullable();
            $table->string('current_company')->nullable();
            $table->string('current_title_job')->nullable();
            $table->string('cv');
            $table->string('school_name');
            $table->string('school_degree')->nullable();
            $table->year('school_year_start')->nullable();
            $table->year('school_year_end')->nullable();
            $table->timestamps();
        });

        // New pivot table: candidat ↔ job
        Schema::create('candidate_job', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id')->constrained('candidates')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('job_id')->constrained('jobs')->onDelete('cascade');
            $table->enum('status', ['pending', 'accept', 'reject'])->default('pending');
            $table->timestamp('applied_at')->nullable()->default(now());
            $table->timestamps();
        });
        // Table for tracking the recruitment process for each candidate
        Schema::create('recruitment_processes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id');
            $table->string('status')->nullable();
            $table->enum('current_phase', ['application_received', 'selection', 'preparation', 'transfer', 'offer_stage'])->default('application_received');
            $table->foreignId('current_subphase_id')->nullable()->constrained('available_recruitment_subphases')->onDelete('set null');
            $table->timestamps();
        });

        // Table for tracking scheduled subphases within the recruitment process
        Schema::create('recruitment_subphases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recruitment_process_id')->constrained('recruitment_processes')->onDelete('cascade');
            $table->foreignId('available_subphase_id')->constrained('available_recruitment_subphases')->onDelete('cascade');
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
    public function down(): void
    {
        // Drop tables in correct order to avoid foreign key constraints issues
        Schema::dropIfExists('recruitment_subphases');
        Schema::dropIfExists('recruitment_processes');
        Schema::dropIfExists('candidates');
        Schema::dropIfExists('available_recruitment_subphases');
    }
}
