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
        Schema::create('events', function (Blueprint $table) {
        $table->id();
        $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
        $table->string('title');
        $table->string('venue');
        $table->dateTime('event_date');
        $table->unsignedInteger('registration_fee')->default(0);
        $table->text('description')->nullable();
        $table->boolean('is_active')->default(true);
        $table->timestamps();

        $table->index(['is_active', 'event_date']);
        $table->index(['created_by', 'event_date']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
