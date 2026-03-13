<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('event_registrations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('event_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('alumni_id')
                ->constrained('alumni')
                ->cascadeOnDelete();

            // Optional fields (super useful)
            $table->unsignedInteger('fee_paid')->default(0); // centavos
            $table->timestamp('paid_at')->nullable();
            $table->string('status')->default('registered'); // registered/paid/cancelled
            $table->timestamps();

            // Prevent duplicates: one alumni can register once per event
            $table->unique(['event_id', 'alumni_id']);
            $table->index(['event_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_registrations');
    }
};