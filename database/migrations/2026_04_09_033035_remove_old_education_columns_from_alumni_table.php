<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alumni', function (Blueprint $table) {
            // drop foreign key first (IMPORTANT)
            $table->dropForeign(['batch_id']);

            // then drop columns
            $table->dropColumn([
                'batch_id',
                'educational_level',
                'did_graduate',
                'school_year_attended',
                'is_batch_rep',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('alumni', function (Blueprint $table) {
            $table->unsignedBigInteger('batch_id')->nullable();
            $table->string('educational_level')->nullable();
            $table->boolean('did_graduate')->default(true);
            $table->string('school_year_attended')->nullable();
            $table->boolean('is_batch_rep')->default(false);

            $table->foreign('batch_id')
                ->references('id')
                ->on('batches')
                ->nullOnDelete();
        });
    }
};