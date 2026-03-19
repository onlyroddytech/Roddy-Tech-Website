<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\View\View;

/**
 * Public Support Controller
 *
 * Renders the three pages accessible from the "Support" nav dropdown:
 *
 *   knowledgeBase() — /support/knowledge-base
 *       General FAQs only (category = 'general'). Quick-answer format.
 *
 *   tutorials()     — /support/tutorials
 *       Static tutorial listings. Content is managed in the Blade view
 *       (video embeds, links). No DB data currently.
 *
 *   helpCenter()    — /support/help-center
 *       All active FAQs across every category, displayed in grouped sections.
 */
class SupportController extends Controller
{
    /**
     * Render the Knowledge Base page.
     * Shows only FAQs categorised as 'general', ordered by sort_order.
     */
    public function knowledgeBase(): View
    {
        return view('public.support.knowledge-base', [
            'faqs' => Faq::active()->where('category', 'general')->get(),
        ]);
    }

    /** Render the Tutorials page. Content is static in the Blade view. */
    public function tutorials(): View
    {
        return view('public.support.tutorials');
    }

    /**
     * Render the Help Center page.
     * Loads all active FAQs; the Blade view groups them by category.
     */
    public function helpCenter(): View
    {
        return view('public.support.help-center', [
            'faqs' => Faq::active()->get(),
        ]);
    }
}
