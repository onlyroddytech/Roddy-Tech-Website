<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PricingItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Admin Pricing Controller
 *
 * CRUD for pricing items displayed on the public /pricing page.
 * Prices are stored in XAF (Cameroon Franc) by convention.
 * unit is an optional label such as "per month" or "one-time project".
 * is_featured highlights a tier in the UI (e.g. "Most Popular" badge).
 *
 * Note: The route model binding key is {pricing}, resolving to
 * a PricingItem instance via Laravel's implicit binding.
 */
class PricingController extends Controller
{
    /** List all pricing items ordered by sort_order. */
    public function index(): View
    {
        return view('admin.pricing.index', ['items' => PricingItem::orderBy('sort_order')->get()]);
    }

    /** Show the create pricing item form. */
    public function create(): View
    {
        return view('admin.pricing.create');
    }

    /** Validate and persist a new pricing item. */
    public function store(Request $request): RedirectResponse
    {
        PricingItem::create($request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'currency'    => 'required|string|max:10',
            'unit'        => 'nullable|string|max:50',
            'is_featured' => 'boolean',
            'is_active'   => 'boolean',
            'sort_order'  => 'integer',
        ]));

        return redirect()->route('admin.pricing.index')->with('success', 'Pricing item added.');
    }

    /** Show the edit form for a pricing item. */
    public function edit(PricingItem $pricing): View
    {
        return view('admin.pricing.edit', ['item' => $pricing]);
    }

    /** Validate and apply updates to an existing pricing item. */
    public function update(Request $request, PricingItem $pricing): RedirectResponse
    {
        $pricing->update($request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'currency'    => 'required|string|max:10',
            'unit'        => 'nullable|string|max:50',
            'is_featured' => 'boolean',
            'is_active'   => 'boolean',
            'sort_order'  => 'integer',
        ]));

        return redirect()->route('admin.pricing.index')->with('success', 'Pricing item updated.');
    }

    /** Permanently delete a pricing item. */
    public function destroy(PricingItem $pricing): RedirectResponse
    {
        $pricing->delete();

        return redirect()->route('admin.pricing.index')->with('success', 'Pricing item deleted.');
    }
}
