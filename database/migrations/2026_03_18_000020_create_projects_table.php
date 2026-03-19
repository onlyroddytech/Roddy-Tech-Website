<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// =============================================================
// Projects Table
// Core table for client project management.
// Each project belongs to a client (user) and is created
// and managed by an admin.
// =============================================================

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            // The client this project belongs to
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // The admin who created this project
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // Project details
            $table->string('title');
            $table->text('description')->nullable();

            // Status — tracks lifecycle stage (see ProjectStatus enum)
            $table->enum('status', ['pending', 'ongoing', 'completed'])
                  ->default('pending')
                  ->index();

            // Progress — integer from 0 to 100 (percentage)
            $table->unsignedTinyInteger('progress')->default(0);

            // Timeline
            $table->date('start_date')->nullable();
            $table->date('deadline')->nullable();

            $table->timestamps();
            $table->softDeletes(); // Soft delete — projects are never hard deleted

            // Indexes for common query patterns
            $table->index(['user_id', 'status']);
            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};