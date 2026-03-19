<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// =============================================================
// create_activity_logs_table
// Stores a full audit trail of every important action taken
// on the platform — by admins, clients, or the system.
//
// Each record answers: WHO did WHAT to WHICH record and WHEN.
//
// subject_type + subject_id = polymorphic relation
// e.g. subject_type = 'App\Models\Project', subject_id = 5
// This means the log entry is about Project #5.
//
// properties = JSON column for extra context
// e.g. { "progress": 75, "status": "active" }
// =============================================================

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();

            // WHO — the user who triggered this action (nullable for system events)
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            // WHAT — machine-readable action name
            // e.g. 'project.progress_updated', 'message.sent', 'project.created'
            $table->string('action');

            // WHICH — the model type and ID this action was performed on
            $table->string('subject_type')->nullable(); // e.g. App\Models\Project
            $table->unsignedBigInteger('subject_id')->nullable(); // e.g. 5

            // DESCRIPTION — human-readable summary shown in the activity feed
            $table->string('description');

            // EXTRA DATA — JSON context (old/new values, metadata, etc.)
            $table->json('properties')->nullable();

            $table->timestamps();

            // Index for fast lookups in the admin activity feed
            $table->index(['subject_type', 'subject_id']);
            $table->index('action');
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
