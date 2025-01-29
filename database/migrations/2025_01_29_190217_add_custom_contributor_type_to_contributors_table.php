<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomContributorTypeToContributorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contributors', function (Blueprint $table) {
            $table->string('custom_contributor_type')->nullable()->after('contributor_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contributors', function (Blueprint $table) {
            $table->dropColumn('custom_contributor_type');
        });
    }
}
