<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'client', 'supporter', 'referral'])
                  ->default('client')
                  ->after('email');

            $table->string('referral_code', 20)->unique()->nullable()->after('role');

            $table->foreignId('referred_by')
                  ->nullable()
                  ->after('referral_code')
                  ->constrained('users')
                  ->nullOnDelete();

            $table->string('avatar')->nullable()->after('referred_by');
            $table->string('phone', 20)->nullable()->after('avatar');
            $table->boolean('is_active')->default(true)->after('phone');
            $table->timestamp('last_seen_at')->nullable()->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['referred_by']);
            $table->dropColumn(['role', 'referral_code', 'referred_by', 'avatar', 'phone', 'is_active', 'last_seen_at']);
        });
    }
};
