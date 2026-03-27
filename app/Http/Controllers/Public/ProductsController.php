<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\View\View;

/**
 * Public Products Controller
 *
 * Renders the /products page listing all active products/tools built
 * by Roddy Technologies, ordered by sort_order.
 * Products marked inactive are hidden without deletion.
 */
class ProductsController extends Controller
{
    /** Render the products page with active products, optional category filter. */
    public function index(): View
    {
        $category = request('category');

        $query = Product::active();

        if ($category && $category !== 'All') {
            $query->where('category', $category);
        }

        $featured   = Product::active()->featured()->get();
        $products   = $query->get();
        $categories = array_merge(['All'], Product::CATEGORIES);

        return view('public.products', compact('products', 'featured', 'categories', 'category'));
    }
}
