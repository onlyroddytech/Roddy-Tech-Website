<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PricingItem;
use Illuminate\View\View;

/**
 * Public Pricing Controller
 *
 * Renders the /pricing page with all active pricing tiers ordered by sort_order.
 * Featured items (is_featured = true) are visually highlighted in the Blade view
 * (e.g. a "Most Popular" badge or elevated card style).
 */
class PricingController extends Controller
{
    /** Render the pricing page with all active pricing items. */
    public function index(): View
    {
        return view('public.pricing', [
            'items' => PricingItem::active()->get(),
        ]);
    }
}
