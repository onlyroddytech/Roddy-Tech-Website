<?php

namespace App\Models;

// =============================================================
// ActivityLog Model
// Records every significant action on the platform.
//
// Each record answers: WHO did WHAT to WHICH record and WHEN.
//
// Used by: LogProjectActivityListener, LogMessageActivityListener
// Displayed in: Admin activity feed (Phase 13 UI — future)
//
// subject_type + subject_id form a polymorphic relation
// pointing to the model affected by the action.
// =============================================================

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'subject_type',
        'subject_id',
        'description',
        'properties',
    ];

    protected function casts(): array
    {
        return [
            'properties' => 'array',
        ];
    }

    // ===========================================================
    // RELATIONSHIPS
    // ===========================================================

    /**
     * The user who performed this action.
     * Null if the action was triggered by the system.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * The model this action was performed on (polymorphic).
     * Could be a Project, Message, Transaction, etc.
     *
     * Usage: $log->subject → returns the actual Project/Message/etc. object
     */
    public function subject(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'subject_type', 'subject_id');
    }

    // ===========================================================
    // HELPER METHODS
    // ===========================================================

    /**
     * Get a short class name for display.
     * e.g. 'App\Models\Project' → 'Project'
     */
    public function subjectLabel(): string
    {
        return $this->subject_type
            ? class_basename($this->subject_type)
            : 'System';
    }
}
