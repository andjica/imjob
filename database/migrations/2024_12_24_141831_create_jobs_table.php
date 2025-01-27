<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('recruiter_id')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sub_category_id');
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('job_type_id'); // Ensure this replaces any enum 'job_type' field
            $table->string('title');
            $table->text('description');
            $table->decimal('salary_min', 10, 2)->nullable();
            $table->decimal('salary_max', 10, 2)->nullable();
            $table->enum('experience_level', ['Entry-Level', 'Mid-Level', 'Senior-Level', 'Managerial']);
            $table->string('required_skills')->nullable();
            $table->unsignedTinyInteger('min_age')->nullable();
            $table->unsignedTinyInteger('max_age')->nullable();
            $table->boolean('special_requirements')->default(false);
            $table->date('valid_until');
            $table->timestamps();
            $table->softDeletes(); // If implementing soft deletes

            // Foreign Key Constraints
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('recruiter_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('job_type_id')->references('id')->on('job_types')->onDelete('restrict');

            // Shortened Index Name
            $table->index(
                ['company_id', 'recruiter_id', 'category_id', 'sub_category_id', 'country_id', 'city_id', 'job_type_id'],
                'jobs_comp_rec_cat_sub_cat_country_city_jobtype_idx'
            );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}


