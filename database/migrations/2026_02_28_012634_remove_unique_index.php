<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            // 1) Drop the existing unique index if it exists (based on your error)
            $table->dropUnique('batches_yeargrad_unique');

            // 2) Ensure type is correct (optional if already smallint)
            $table->unsignedSmallInteger('yeargrad')->change();

            // 3) Re-add unique (Laravel will create a fresh index name)
            $table->unique('yeargrad');
        });
    }

    public function down(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            // Rollback: remove the new unique index
            $table->dropUnique(['yeargrad']);

            // Optional: restore previous unique index name
            $table->unique('yeargrad', 'batches_yeargrad_unique');
        });
    }
};