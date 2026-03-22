<?php

namespace App\Models;

use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Project Model
 *
 * Represents a client project managed by Roddy Technologies.
 * Uses SoftDeletes — deleted projects are hidden from all standard
 * queries but kept in the DB for billing and activity history.
 *
 * Relationships:
 *   client()       → the User (client) who owns the project
 *   creator()      → the User (admin) who created the project
 *   updates()      → ProjectUpdate entries, newest first (progress timeline)
 *   latestUpdate() → single most-recent update for list views (no N+1)
 *   messages()     → project thread Messages, oldest first (chat order)
 *   payment()      → the one-to-one Payment record for this project
 *
 * Helpers:
 *   isCompleted()   → true when status is ProjectStatus::Completed
 *   isOverdue()     → true if deadline is past and project is not completed
 *   progressLabel() → formatted "75%" string for display
 */
class Project extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'created_by', 'title', 'description',
        'status', 'progress', 'image', 'start_date', 'deadline',
    ];

    protected function casts(): array
    {
        return [
            'status'     => ProjectStatus::class,
            'progress'   => 'integer',
            'start_date' => 'date',
            'deadline'   => 'date',
        ];
    }

    // ── Relationships ──────────────────────────────────────────

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updates(): HasMany
    {
        return $this->hasMany(ProjectUpdate::class)->latest();
    }

    public function latestUpdate(): HasOne
    {
        return $this->hasOne(ProjectUpdate::class)->latestOfMany();
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->oldest();
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    // ── Helpers ────────────────────────────────────────────────

    public function isCompleted(): bool
    {
        return $this->status === ProjectStatus::Completed;
    }

    public function isOverdue(): bool
    {
        return $this->deadline && $this->deadline->isPast() && !$this->isCompleted();
    }

    public function progressLabel(): string
    {
        return $this->progress . '%';
    }
}
