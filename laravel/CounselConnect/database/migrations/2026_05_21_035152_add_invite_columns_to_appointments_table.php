<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Tracks who initiated the appointment (student books normally, counselor sends invite)
            $table->enum('initiated_by', ['student', 'counselor'])->default('student')->after('rejection_reason');

            // Only used when counselor initiates — student must accept or decline
            // null = not applicable (student-initiated), pending/accepted/declined for counselor-initiated
            $table->enum('invite_status', ['pending', 'accepted', 'declined'])->nullable()->after('initiated_by');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['initiated_by', 'invite_status']);
        });
    }
};