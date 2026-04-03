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
        Schema::create('event_rsvps', function (Blueprint $table) {
            $table->id();

            $table->foreignId('event_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('alumni_id')
                ->constrained('alumni')
                ->cascadeOnDelete();

            $table->enum('status', ['attending', 'maybe', 'not_attending'])
                ->default('attending');

            $table->unsignedInteger('guest_count')->default(0);

            $table->text('remarks')->nullable();

            $table->timestamps();

            $table->unique(['event_id', 'alumni_id']);
            $table->index(['event_id', 'status']);
            $table->index(['alumni_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_rsvps');
    }
};