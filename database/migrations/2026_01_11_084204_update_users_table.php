<?php

// database/migrations/2026_01_11_000003_update_users_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('alumni')->after('password');
            $table->foreignId('alumni_id')->nullable()->constrained('alumni')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['alumni_id']);
            $table->dropColumn(['username', 'role', 'alumni_id']);
        });
    }
};

