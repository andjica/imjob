<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecruiterEducationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recruiter_educations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recruiter_id'); // Foreign key to recruiters table
            $table->string('school'); // School name
            $table->string('degree'); // Degree type (e.g., Bachelor, Master)
            $table->string('field_of_study')->nullable(); // Optional field of study
            $table->year('year_of_graduation')->nullable(); // Graduation year
            $table->text('description')->nullable(); // Optional description
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('recruiter_id')->references('id')->on('recruiters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recruiter_education');
    }
}
