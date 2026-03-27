<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Product Model
 *
 * Represents a product or digital tool built by Roddy Technologies.
 * Displayed on the /products page and featured on the homepage.
 * url links out to the product's external site or dedicated landing page.
 * category is an optional grouping label (e.g. 'SaaS', 'Tool', 'App').
 *
 * Scope:
 *   active() → only active products, ordered by sort_order.
 */
class Product extends Model
{
    const CATEGORIES = ['Websites', 'Scripts', 'Tools', 'UI Kits', 'Templates'];

    protected $fillable = [
        'title', 'description', 'image', 'url',
        'category', 'price', 'is_active', 'is_featured', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active'   => 'boolean',
            'is_featured' => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
