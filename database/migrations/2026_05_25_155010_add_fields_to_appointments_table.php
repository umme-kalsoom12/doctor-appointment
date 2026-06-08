<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('rejection_reason')->nullable()->after('status');
            $table->boolean('patient_notified')->default(false)->after('rejection_reason');
        });
    }
    public function down(): void {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['rejection_reason', 'patient_notified']);
        });
    }
};