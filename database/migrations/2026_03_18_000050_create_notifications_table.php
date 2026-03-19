<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// =============================================================
// Notifications Table
// Custom notifications table for the platform.
// Stores in-app notifications for users — project updates,
// new messages, payment confirmations, and system alerts.
//
// Separate from Laravel's built-in polymorphic notifications —
// this gives us full control over the schema and queries.
// =============================================================

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            // The user who receives this notification
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // Type — used to render the correct icon/style in the UI
            // e.g. 'project_update' | 'new_message' | 'payment' | 'system'
            $table->string('type', 50)->index();

            // Short title shown in the notification dropdown
            $table->string('title');

            // Full notification message
            $table->text('message');

            // Optional JSON payload — extra data for deep linking or actions
            // e.g. { "project_id": 5, "url": "/client/projects/5" }
            $table->json('data')->nullable();

            // Read tracking
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();

            $table->timestamps();

            // Index for loading unread notifications per user efficiently
            $table->index(['user_id', 'is_read', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};