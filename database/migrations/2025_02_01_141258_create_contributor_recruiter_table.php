<?php

use App\Enums\InviteType;
use App\Models\ContributorRecruiter;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContributorRecruiterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contributor_recruiter', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recruiter_id');
            $table->unsignedBigInteger('contributor_id');
            $table->date('from_date')->nullable();
            $table->date('until_date')->nullable();
            $table->string('status')->default(ContributorRecruiter::PENDING);
            $table->enum('invite_type', [InviteType::RECRUITER, InviteType::CONTRIBUTOR])->default(InviteType::RECRUITER)->nullable(false);
            $table->timestamps();

            $table->foreign('recruiter_id')->references('id')->on('recruiters')->onDelete('cascade');
            $table->foreign('contributor_id')->references('id')->on('contributors')->onDelete('cascade');

            $table->unique(['recruiter_id', 'contributor_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contributor_recruiter');
    }
}
