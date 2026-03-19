<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Testimonial Model
 *
 * Client or community testimonials displayed on the homepage and
 * marketing pages. Managed by the admin.
 * rating stores a 1–5 star integer (cast to int).
 *
 * Scope:
 *   active() → only active testimonials, ordered newest first.
 */
class Testimonial extends Model
{
    protected $fillable = ['name', 'position', 'content', 'photo', 'rating', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean', 'rating' => 'integer'];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->latest();
    }
}
