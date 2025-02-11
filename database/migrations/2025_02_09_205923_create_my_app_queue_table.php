<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('my_app_queue', function (Blueprint $table) {
            $table->id();
            $table->string('queue')->index(); // Naziv queue-a
            $table->longText('payload'); // Podaci o zadatku
            $table->unsignedTinyInteger('attempts')->default(0); // Broj pokušaja
            $table->unsignedInteger('reserved_at')->nullable(); // Kada je rezervisan za izvršenje
            $table->unsignedInteger('available_at'); // Kada može biti izvršen
            $table->unsignedInteger('created_at'); // Kada je dodat u queue
        });
    }

    public function down()
    {
        Schema::dropIfExists('my_app_queue');
    }
};
