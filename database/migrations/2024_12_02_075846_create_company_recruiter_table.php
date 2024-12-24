<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyRecruiterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_recruiter', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recruiter_id');
            $table->unsignedBigInteger('company_id');
            $table->date('from_date')->nullable(); // When the recruiter started
            $table->date('until_date')->nullable(); // When the recruiter left
            $table->string('status')->default('active'); // active or past
            $table->timestamps();
        
            // Foreign keys
            $table->foreign('recruiter_id')->references('id')->on('recruiters')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        
            $table->unique(['recruiter_id', 'company_id']); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_recruiter');
    }
}
