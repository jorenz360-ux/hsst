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
       Schema::create('event_registrations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
        $table->foreignId('alumni_id')->constrained('alumni')->cascadeOnDelete();
        $table->unsignedInteger('fee_paid')->default(0);
        $table->timestamp('paid_at')->nullable();
        $table->string('status')->default('registered');
        $table->timestamps();

        $table->unique(['event_id', 'alumni_id']);
        $table->index(['event_id', 'status']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_registrations');
    }
};
