<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\View\View;

/**
 * Public Store Controller
 *
 * Renders /store — the digital marketplace for purchasable products.
 * Store products are identified by having a non-null price field.
 * Supports search, category filter, sort, and pagination.
 */
class StoreController extends Controller
{
    public function index(): View
    {
        $search   = request('search');
        $category = request('category');
        $sort     = request('sort', 'popular');

        // Base query: only active products that have a price (store items)
        $query = Product::where('is_active', true)
                        ->whereNotNull('price');

        // ── Search ──────────────────────────────────────────────
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // ── Category filter ─────────────────────────────────────
        if ($category && $category !== 'All') {
            $query->where('category', $category);
        }

        // ── Sort ────────────────────────────────────────────────
        match ($sort) {
            'newest'     => $query->orderByDesc('created_at'),
            'price_low'  => $query->orderByRaw("CAST(REPLACE(REPLACE(price, '$', ''), ',', '') AS DECIMAL(10,2)) ASC"),
            'price_high' => $query->orderByRaw("CAST(REPLACE(REPLACE(price, '$', ''), ',', '') AS DECIMAL(10,2)) DESC"),
            default      => $query->orderByDesc('is_featured')->orderBy('sort_order'),
        };

        $products   = $query->paginate(9)->withQueryString();
        $featured   = Product::where('is_active', true)
                             ->whereNotNull('price')
                             ->where('is_featured', true)
                             ->orderBy('sort_order')
                             ->get();
        $categories = array_merge(['All'], Product::CATEGORIES);
        $total      = Product::where('is_active', true)->whereNotNull('price')->count();

        return view('public.store', compact(
            'products', 'featured', 'categories',
            'category', 'search', 'sort', 'total'
        ));
    }
}
