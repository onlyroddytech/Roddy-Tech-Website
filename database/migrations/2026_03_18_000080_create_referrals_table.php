<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();           // referrer
            $table->foreignId('referred_user_id')->constrained('users')->cascadeOnDelete(); // who signed up
            $table->decimal('commission_amount', 10, 2)->default(0);
            $table->enum('status', ['pending', 'approved', 'paid'])->default('pending');
            $table->timestamps();
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};
