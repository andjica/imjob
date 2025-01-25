<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSpecialRequiremensToTextInJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropColumn('special_requirements');
        });

        Schema::table('jobs', function (Blueprint $table) {
            $table->text('special_requirements')->nullable()->after('max_age');
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
            $table->dropColumn('special_requirements');
        });

        Schema::table('jobs', function (Blueprint $table) {
            // Re-add the column as a boolean
            $table->boolean('special_requirements')->default(false)->after('max_age');
        });
    }
}
