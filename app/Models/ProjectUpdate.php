<?php

namespace App\Models;

// =============================================================
// ProjectUpdate Model
// Stores a single progress update entry on a project.
// Every time an admin updates project progress, a new record
// is created here. Together they form the project timeline
// visible to the client on their dashboard.
// =============================================================

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectUpdate extends Model
{
    // -------------------------------------------------------
    // Mass Assignment
    // 'created_by' is set in the UpdateProjectProgress action,
    // not from user input directly.
    // -------------------------------------------------------
    protected $fillable = [
        'project_id',
        'created_by',
        'progress',
        'message',
    ];

    // -------------------------------------------------------
    // Casts
    // -------------------------------------------------------
    protected function casts(): array
    {
        return [
            'progress' => 'integer',
        ];
    }

    // ===========================================================
    // RELATIONSHIPS
    // ===========================================================

    /**
     * The project this update belongs to.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    /**
     * The admin who posted this update.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}