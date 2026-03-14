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
       Schema::create('donations', function (Blueprint $table) {
        $table->id();
        $table->string('paymongo_checkout_session_id')->nullable()->unique();
        $table->timestamp('paid_at')->nullable();
        $table->boolean('is_paid')->default(false);
        $table->foreignId('alumni_id')->constrained('alumni')->cascadeOnDelete();
        $table->decimal('amount', 10, 2);
        $table->timestamp('date_donated')->nullable();
        $table->string('remarks')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
