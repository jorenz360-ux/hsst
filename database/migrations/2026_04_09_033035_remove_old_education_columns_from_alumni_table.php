<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alumni', function (Blueprint $table) {
            // Drop only columns that exist
            $columns = ['batch_id', 'educational_level', 'did_graduate', 'school_year_attended', 'is_batch_rep'];
            $existingColumns = Schema::getColumnListing('alumni');
            $columnsToDelete = array_intersect($columns, $existingColumns);

            if (!empty($columnsToDelete)) {
                // Try to drop batch_id foreign key if batch_id column exists
                if (in_array('batch_id', $columnsToDelete)) {
                    try {
                        $table->dropForeign(['batch_id']);
                    } catch (\Exception $e) {
                        // Foreign key might not exist, continue
                    }
                }

                $table->dropColumn($columnsToDelete);
            }
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