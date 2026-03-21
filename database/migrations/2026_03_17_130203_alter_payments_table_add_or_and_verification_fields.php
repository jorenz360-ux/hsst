<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            

            $table->enum('status', ['pending', 'verified', 'rejected'])
                ->default('pending')
                ->after('paid_at');

            $table->unsignedBigInteger('verified_by')->nullable()->after('status');
            $table->timestamp('verified_at')->nullable()->after('verified_by');

            $table->foreign('verified_by', 'payments_verified_by_fk')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign('payments_verified_by_fk');

            $table->dropColumn([
                'status',
                'verified_by',
                'verified_at',
            ]);
        });
    }
};
