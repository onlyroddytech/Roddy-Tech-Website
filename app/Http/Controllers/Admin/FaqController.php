<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Admin FAQ Controller
 *
 * CRUD for Frequently Asked Questions shown on the public support pages:
 *   - /support/help-center     — all active FAQs grouped by category
 *   - /support/knowledge-base  — only 'general' category FAQs
 *
 * category groups FAQs logically (e.g. 'general', 'billing', 'technical').
 * sort_order controls display sequence within each category.
 */
class FaqController extends Controller
{
    /** List all FAQs ordered by sort_order. */
    public function index(): View
    {
        return view('admin.faqs.index', ['faqs' => Faq::orderBy('sort_order')->get()]);
    }

    /** Show the add FAQ form. */
    public function create(): View
    {
        return view('admin.faqs.create');
    }

    /** Validate and persist a new FAQ. */
    public function store(Request $request): RedirectResponse
    {
        Faq::create($request->validate([
            'question'   => 'required|string|max:500',
            'answer'     => 'required|string',
            'category'   => 'required|string|max:50',
            'sort_order' => 'integer',
            'is_active'  => 'boolean',
        ]));

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ added.');
    }

    /** Show the FAQ edit form. */
    public function edit(Faq $faq): View
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    /** Validate and apply updates to an existing FAQ. */
    public function update(Request $request, Faq $faq): RedirectResponse
    {
        $faq->update($request->validate([
            'question'   => 'required|string|max:500',
            'answer'     => 'required|string',
            'category'   => 'required|string|max:50',
            'sort_order' => 'integer',
            'is_active'  => 'boolean',
        ]));

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ updated.');
    }

    /** Permanently delete a FAQ. */
    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ deleted.');
    }
}
