<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// =============================================================
// Messages Table
// Stores per-project messages between a client and admin.
// Each message belongs to a project and has a sender.
// Powers the messaging UI on the client dashboard
// and admin project view.
// =============================================================

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();

            // The project this message thread belongs to
            $table->foreignId('project_id')
                  ->constrained('projects')
                  ->cascadeOnDelete();

            // The user who sent this message (client or admin)
            $table->foreignId('sender_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // Message body
            $table->text('message');

            // Read tracking — used to show unread counts
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();

            $table->timestamps();

            // Indexes for loading message threads efficiently
            $table->index(['project_id', 'created_at']);
            $table->index(['project_id', 'is_read']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};