<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateJobsTableAddJobWorldTypeAndMakeRecruiterIdNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jobs', function (Blueprint $table) {
           
            $table->string('job_world_type')->after('job_type_id');

            $table->unsignedBigInteger('recruiter_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jobs', function (Blueprint $table) {
            
            $table->dropColumn('job_world_type');

          
            $table->unsignedBigInteger('recruiter_id')->nullable(false);
        });
    }
}
