<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->enum('application_stage', ['pending', 'under_review', 'approved_for_interview', 'interview_scheduled', 'interview_completed', 'approved', 'rejected'])->default('pending')->after('status');
            $table->boolean('is_reachable')->default(true)->after('application_stage');
            $table->boolean('is_under_age_18')->default(false)->after('is_reachable');
            $table->date('application_date')->nullable()->after('is_under_age_18');
            $table->text('rejection_reason')->nullable()->after('application_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['application_stage', 'is_reachable', 'is_under_age_18', 'application_date', 'rejection_reason']);
        });
    }
};
