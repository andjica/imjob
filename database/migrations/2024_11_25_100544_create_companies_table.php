<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('company_type_id')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sub_category_id');
            $table->string('address');
            $table->string('owner_title');
            $table->string('name');
            $table->string('registration_number')->unique();
            $table->string('tax_number')->unique();
            $table->string('phone_number');
            $table->string('logo')->nullable();
            $table->string('email')->unique();
            $table->boolean('active')->default(false);
            $table->integer('number_of_employees')->default(0);
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
        Schema::dropIfExists('companies');
    }
}
