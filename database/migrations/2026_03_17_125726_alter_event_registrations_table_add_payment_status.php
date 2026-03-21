<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('event_registrations', function (Blueprint $table) {
            $table->enum('payment_status', ['unpaid', 'pending', 'paid', 'rejected'])
                ->default('unpaid')
                ->after('status');

            // Optional: remove old columns if you want cleaner design
            // only do this if they already exist and you are sure
            $table->dropColumn(['fee_paid', 'paid_at']);
        });
    }

    public function down(): void
    {
        Schema::table('event_registrations', function (Blueprint $table) {
            $table->dropColumn('payment_status');

            // If you dropped them in up(), restore here
            $table->boolean('fee_paid')->default(false);
            $table->timestamp('paid_at')->nullable();
        });
    }
};
