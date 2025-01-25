<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeRecruiterIdNullableInJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropForeign(['recruiter_id']);
            $table->dropColumn('recruiter_id');
        });

        Schema::table('jobs', function (Blueprint $table) {
            $table->unsignedBigInteger('recruiter_id')->nullable()->after('company_id');
            $table->foreign('recruiter_id')->references('id')->on('users')->onDelete('cascade');
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
            $table->dropForeign(['recruiter_id']);

            $table->dropColumn('recruiter_id');
        });

        Schema::table('jobs', function (Blueprint $table) {
            $table->unsignedBigInteger('recruiter_id')->after('company_id');
            $table->foreign('recruiter_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
