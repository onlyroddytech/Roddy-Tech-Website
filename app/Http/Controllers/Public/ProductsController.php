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
    /** Render the products page with all active products. */
    public function index(): View
    {
        return view('public.products', [
            'products' => Product::active()->get(),
        ]);
    }
}
