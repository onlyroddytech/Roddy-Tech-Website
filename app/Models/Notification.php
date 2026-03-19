<?php

namespace App\Models;

// =============================================================
// Notification Model
// Stores in-app notifications for platform users.
// Triggered by system events — project updates, new messages,
// payment confirmations, and admin system alerts.
//
// The optional 'data' JSON column holds extra context used
// for deep linking (e.g. linking to a specific project).
// =============================================================

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    // -------------------------------------------------------
    // Mass Assignment
    // -------------------------------------------------------
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'data',
        'is_read',
        'read_at',
    ];

    // -------------------------------------------------------
    // Casts
    // 'data' is cast to array so $notification->data['project_id']
    // works directly without manual json_decode().
    // -------------------------------------------------------
    protected function casts(): array
    {
        return [
            'data'    => 'array',
            'is_read' => 'boolean',
            'read_at' => 'datetime',
        ];
    }

    // ===========================================================
    // RELATIONSHIPS
    // ===========================================================

    /**
     * The user who receives this notification.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ===========================================================
    // HELPER METHODS
    // ===========================================================

    /**
     * Mark this notification as read.
     * Called when the user opens the notification dropdown
     * or clicks a specific notification.
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
     * Get the URL this notification should link to.
     * Reads from the 'data' JSON column if a URL was provided.
     * Falls back to the client dashboard if none set.
     */
    public function actionUrl(): string
    {
        return $this->data['url'] ?? route('client.dashboard');
    }
}