<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Drop the wrong FK (registrations)
            $table->dropForeign(['registration_id']);

            // Recreate FK to the correct table (event_registrations)
            $table->foreign('registration_id')
                ->references('id')
                ->on('event_registrations')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['registration_id']);

            // Restore old FK (ONLY if you really used registrations before)
            $table->foreign('registration_id')
                ->references('id')
                ->on('registrations')
                ->cascadeOnDelete();
        });
    }
};