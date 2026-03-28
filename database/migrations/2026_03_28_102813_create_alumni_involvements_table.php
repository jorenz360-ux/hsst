<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('alumni_involvements', function (Blueprint $table) {
            $table->id();

            $table->foreignId('alumni_id')
                ->constrained('alumni')
                ->cascadeOnDelete();

            $table->boolean('wants_committee_member')->default(false);
            $table->boolean('is_priest_concelebrate')->default(false);
            $table->boolean('is_medical_practitioner')->default(false);
            $table->string('medical_specialty')->nullable();

            $table->timestamps();

            $table->unique('alumni_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumni_involvements');
    }
};