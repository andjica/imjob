<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhaseColumnToTheSubphasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recruitment_subphases', function (Blueprint $table) {
            $table->enum('phase', [
                'application_received',
                'selection',
                'preparation',
                'transfer',
                'offer_stage'
            ])->default('application_received')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recruitment_subphases', function (Blueprint $table) {
            $table->dropColumn('phase');
        });
    }
}
