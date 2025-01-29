<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveActiveColumnFromContributorsTable extends Migration
{
    public function up()
    {
        Schema::table('contributors', function (Blueprint $table) {
            $table->dropColumn('active');
        });
    }

    public function down()
    {
        Schema::table('contributors', function (Blueprint $table) {
            $table->boolean('active')->default(0);
        });
    }
}
