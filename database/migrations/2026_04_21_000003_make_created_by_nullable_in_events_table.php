<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable()->change();
            $table->string('venue')->nullable()->change();
            $table->dateTime('event_date')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable(false)->change();
            $table->string('venue')->nullable(false)->change();
            $table->dateTime('event_date')->nullable(false)->change();
        });
    }
};
