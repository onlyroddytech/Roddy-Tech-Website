<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * PricingItem Model
 *
 * A pricing tier or service package displayed on the public /pricing page.
 * Managed by the admin via Admin → Pricing.
 *
 * features is a JSON column cast to a PHP array — store bullet points
 * as a JSON array (e.g. ["5 pages", "Logo design", "3 revisions"]).
 * price is stored as decimal:2 in XAF (Cameroon Franc) by convention.
 * unit is an optional duration/frequency label (e.g. "per month", "one-time").
 * is_featured marks the highlighted "Most Popular" tier in the UI.
 * sort_order controls left-to-right display order of tiers.
 *
 * Scope:
 *   active() → only active items, ordered by sort_order.
 */
class PricingItem extends Model
{
    protected $fillable = [
        'title', 'description', 'price', 'currency', 'unit',
        'features', 'is_featured', 'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'features'    => 'array',
            'is_featured' => 'boolean',
            'is_active'   => 'boolean',
            'price'       => 'decimal:2',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
