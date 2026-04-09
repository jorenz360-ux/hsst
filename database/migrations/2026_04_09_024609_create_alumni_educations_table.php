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
        Schema::create('alumni_educations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('alumni_id')
                ->constrained('alumni')
                ->cascadeOnDelete();

            $table->foreignId('batch_id')
                ->constrained('batches')
                ->restrictOnDelete();

            $table->boolean('did_graduate')->default(true);
            $table->string('school_year_attended', 50)->nullable();
            $table->boolean('is_batch_rep')->default(false);

            $table->timestamps();

            $table->unique(['alumni_id', 'batch_id'], 'alumni_educations_alumni_batch_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni_educations');
    }
};