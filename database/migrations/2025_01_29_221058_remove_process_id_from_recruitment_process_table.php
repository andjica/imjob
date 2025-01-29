<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveProcessIdFromRecruitmentProcessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('recruitment_processes', function (Blueprint $table) {
            $table->dropForeign(['current_subphase_id']);
            $table->dropColumn('current_subphase_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('recruitment_processes', function (Blueprint $table) {
            $table->foreignId('current_subphase_id')->nullable()->constrained('available_recruitment_subphases')->onDelete('set null');
        });
    }
}
