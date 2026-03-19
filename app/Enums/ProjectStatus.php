<?php

namespace App\Enums;

/**
 * ProjectStatus Enum
 *
 * Represents the current lifecycle stage of a project.
 *
 *   Pending   — Project created, not yet started (awaiting kickoff).
 *   Ongoing   — Actively being worked on.
 *   Completed — Delivered and closed.
 *
 * color() returns a Tailwind CSS color name used for status badge styling in views.
 * label() returns the human-readable display string.
 *
 * Cast automatically on the Project model. Compare with:
 *   $project->status === ProjectStatus::Ongoing  ✓ (correct)
 *   $project->status->value === 'ongoing'         ✓ (also works)
 *   $project->where('status.value', 'ongoing')    ✗ (broken on collections)
 */
enum ProjectStatus: string
{
    case Pending   = 'pending';
    case Ongoing   = 'ongoing';
    case Completed = 'completed';

    public function label(): string
    {
        return match($this) {
            self::Pending   => 'Pending',
            self::Ongoing   => 'Ongoing',
            self::Completed => 'Completed',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Pending   => 'yellow',
            self::Ongoing   => 'blue',
            self::Completed => 'green',
        };
    }
}
