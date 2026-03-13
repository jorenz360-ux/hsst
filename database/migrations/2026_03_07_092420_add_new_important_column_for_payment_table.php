<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('paymongo_checkout_session_id')
                ->nullable()
                ->unique()
                ->after('id'); 
            $table->timestamp('paid_at')->nullable()->after('paymongo_checkout_session_id');
            $table->boolean('is_paid')->default(false)->after('paid_at');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropUnique(['paymongo_checkout_session_id']);

            $table->dropColumn(['paymongo_checkout_session_id', 'paid_at', 'is_paid']);
        });
    }
};