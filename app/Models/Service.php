<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Service Model
 *
 * Represents a service offering displayed on the public website.
 * Managed by the admin via Admin → Services.
 *
 * Scope:
 *   active() → only services where is_active = true, ordered by sort_order.
 *              Use this for all public-facing queries.
 */
class Service extends Model
{
    protected $fillable = ['title', 'description', 'icon', 'image', 'sort_order', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
