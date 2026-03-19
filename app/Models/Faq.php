<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Faq Model
 *
 * A Frequently Asked Question displayed on the public support pages.
 * FAQs are grouped by category (e.g. 'general', 'billing', 'technical')
 * and ordered by sort_order within each group.
 *
 * Used by:
 *   SupportController::helpCenter()     — all active FAQs
 *   SupportController::knowledgeBase()  — only 'general' category
 *
 * Scope:
 *   active() → only active FAQs, ordered by sort_order.
 */
class Faq extends Model
{
    protected $fillable = ['question', 'answer', 'category', 'sort_order', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
