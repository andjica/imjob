<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAiSearchHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ai_search_histories', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');

        $table->text('user_message');       // poruka koju je korisnik poslao
        $table->text('ai_response');        // poruka koju je AI vratio

        $table->json('jobs')->nullable();   // lista poslova koje je AI poslao
        $table->json('filters_used')->nullable(); // filteri koje je korisnik koristio

        $table->string('language_code', 10)->nullable(); // jezik odgovora
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
        Schema::dropIfExists('ai_search_histories');
    }
}
