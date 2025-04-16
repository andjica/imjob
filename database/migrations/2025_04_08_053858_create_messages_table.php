<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // sender
            $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade'); // receiver
            $table->integer('candidate_id')->nullable();
            $table->text('text')->nullable();         // tekstualna poruka
            $table->string('file_path')->nullable();  // slika/fajl ako postoji
            $table->string('file_type')->nullable();  // npr: image, pdf, etc.
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
        Schema::dropIfExists('messages');
    }
}
