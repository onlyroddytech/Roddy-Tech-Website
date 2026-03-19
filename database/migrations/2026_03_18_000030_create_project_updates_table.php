<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// =============================================================
// Project Updates Table
// Stores the full history of progress updates on a project.
// Every time an admin updates project progress, a record is
// written here. This powers the timeline view on the
// client dashboard.
// =============================================================

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_updates', function (Blueprint $table) {
            $table->id();

            // The project this update belongs to
            $table->foreignId('project_id')
                  ->constrained('projects')
                  ->cascadeOnDelete();

            // The admin who posted this update
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // Progress value at the time of this update (0–100)
            $table->unsignedTinyInteger('progress');

            // Update message visible to the client on their timeline
            $table->text('message');

            $table->timestamps();

            // Index for fetching updates by project in chronological order
            $table->index(['project_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_updates');
    }
};