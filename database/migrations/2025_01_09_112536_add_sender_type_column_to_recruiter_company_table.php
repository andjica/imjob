<?php

use App\Enums\InviteType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSenderTypeColumnToRecruiterCompanyTable extends Migration
{
    public function up(): void
    {
        Schema::table('company_recruiter', function (Blueprint $table) {
            $table->enum('invite_type', [InviteType::RECRUITER, InviteType::COMPANY])
                ->default(InviteType::RECRUITER)
                ->nullable(false)
            ;
        });
    }

    public function down(): void
    {
        Schema::table('company_recruiter', function (Blueprint $table) {
            $table->dropColumn('invite_type');
        });
    }
}
