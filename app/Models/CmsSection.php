<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * CmsSection Model
 *
 * Stores all editable public website content as key-value pairs so the
 * admin can update headlines, body copy, contact details, etc. from the
 * dashboard without touching Blade files or deploying code.
 *
 * Schema:
 *   key    — unique identifier (e.g. 'hero_title', 'contact_phone')
 *   label  — human-readable name shown in the admin CMS editor
 *   value  — the actual content string
 *   type   — input hint for the editor ('text', 'textarea', 'url', 'email')
 *   group  — page/section grouping (e.g. 'hero', 'about', 'contact')
 *
 * Static helpers (use these in controllers instead of raw queries):
 *   get(key, fallback)  → fetch a single value by key; returns fallback if missing
 *   group(group)        → fetch all key=>value pairs for a section as an array
 *
 * Blade usage examples:
 *   {{ $cms['hero_title'] }}              (after passing CmsSection::group('hero'))
 *   {{ CmsSection::get('hero_title') }}   (direct call anywhere)
 *
 * All valid keys are seeded via DatabaseSeeder — the CMS editor only
 * updates existing rows, it never creates new ones.
 */
class CmsSection extends Model
{
    protected $fillable = ['key', 'label', 'value', 'type', 'group'];

    // Helper: get a CMS value by key with optional fallback
    public static function get(string $key, string $fallback = ''): string
    {
        return static::where('key', $key)->value('value') ?? $fallback;
    }

    // Helper: get all values for a group as key=>value array
    public static function group(string $group): array
    {
        return static::where('group', $group)
            ->pluck('value', 'key')
            ->toArray();
    }
}
