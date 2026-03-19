<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Admin Product Controller
 *
 * CRUD for products/tools built by Roddy Technologies, displayed on
 * the public /products page and featured on the homepage. Products can
 * be grouped by category and ordered via sort_order.
 *
 * url links out to the product's external site or dedicated landing page.
 * is_active toggles visibility without deleting the record.
 */
class ProductController extends Controller
{
    /** List all products ordered by sort_order. */
    public function index(): View
    {
        return view('admin.products.index', ['products' => Product::orderBy('sort_order')->get()]);
    }

    /** Show the product creation form. */
    public function create(): View
    {
        return view('admin.products.create');
    }

    /** Validate and persist a new product. */
    public function store(Request $request): RedirectResponse
    {
        Product::create($request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'url'         => 'nullable|url',
            'category'    => 'nullable|string|max:100',
            'sort_order'  => 'integer',
            'is_active'   => 'boolean',
        ]));

        return redirect()->route('admin.products.index')->with('success', 'Product added.');
    }

    /** Show the product edit form. */
    public function edit(Product $product): View
    {
        return view('admin.products.edit', compact('product'));
    }

    /** Validate and apply updates to an existing product. */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $product->update($request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'url'         => 'nullable|url',
            'category'    => 'nullable|string|max:100',
            'sort_order'  => 'integer',
            'is_active'   => 'boolean',
        ]));

        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    /** Permanently delete a product. */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }
}
