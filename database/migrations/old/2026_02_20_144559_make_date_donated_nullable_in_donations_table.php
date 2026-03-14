<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->timestamp('date_donated')->nullable()->change();
            // If your column is DATETIME instead of TIMESTAMP, use:
            // $table->dateTime('date_donated')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->timestamp('date_donated')->nullable(false)->change();
        });
    }
};