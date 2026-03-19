<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * TeamMember Model
 *
 * Represents a team member profile shown on the public /team page.
 * Managed by the admin via Admin → Team.
 *
 * sort_order controls left-to-right / top-to-bottom display sequence.
 * is_active = false hides the member from the public page without deleting.
 *
 * Scope:
 *   active() → only active members, ordered by sort_order.
 */
class TeamMember extends Model
{
    protected $fillable = ['name', 'role', 'bio', 'photo', 'twitter', 'linkedin', 'sort_order', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
