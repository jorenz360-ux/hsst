<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('volunteer_signups', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('alumni_id')
                ->nullable()
                ->constrained('alumni')
                ->nullOnDelete();

            $table->foreignId('committee_id')
                ->constrained('committees')
                ->cascadeOnDelete();

            $table->text('notes')->nullable();

            $table->string('status')->default('pending');
            // pending, approved, contacted, declined

            $table->timestamps();

            $table->unique(['user_id', 'committee_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('volunteer_signups');
    }
};