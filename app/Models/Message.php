<?php

namespace App\Models;

// =============================================================
// Message Model
// Represents a single message in a project thread.
// Messages are scoped to a project — client and admin
// communicate within the context of a specific project.
// =============================================================

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    // -------------------------------------------------------
    // Mass Assignment
    // -------------------------------------------------------
    protected $fillable = [
        'project_id',
        'sender_id',
        'message',
        'is_read',
        'read_at',
    ];

    // -------------------------------------------------------
    // Casts
    // -------------------------------------------------------
    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
            'read_at' => 'datetime',
        ];
    }

    // ===========================================================
    // RELATIONSHIPS
    // ===========================================================

    /**
     * The project this message belongs to.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    /**
     * The user who sent this message (client or admin).
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // ===========================================================
    // HELPER METHODS
    // ===========================================================

    /**
     * Mark this message as read and record the time.
     * Called when the recipient opens the message thread.
     */
    public function markAsRead(): void
    {
        if (! $this->is_read) {
            $this->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }
    }

    /**
     * Check if this message was sent by the given user.
     * Used in the UI to align messages left (received) or right (sent).
     */
    public function isSentBy(User $user): bool
    {
        return $this->sender_id === $user->id;
    }
}