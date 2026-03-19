<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Service-based pricing — NOT subscriptions.
// Admin manages these per service offering.

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pricing_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2);
            $table->string('currency')->default('XAF');
            $table->string('unit')->nullable();       // e.g. "per project", "per month"
            $table->json('features')->nullable();     // list of included features
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pricing_items');
    }
};
