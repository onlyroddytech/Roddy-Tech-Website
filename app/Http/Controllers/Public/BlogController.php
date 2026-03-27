<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\View\View;

/**
 * Public Blog Controller
 *
 * Renders the public-facing blog. Only published posts are visible.
 * Individual posts are resolved by slug (human-readable URL) rather
 * than by integer ID for cleaner, shareable URLs.
 */
class BlogController extends Controller
{
    /**
     * List published posts, paginated (9 per page).
     * Uses the published() scope: is_published = true, ordered by published_at.
     */
    public function index(): View
    {
        $category = request('category');

        $query = BlogPost::published()->with('author');

        if ($category && $category !== 'All') {
            $query->where('category', $category);
        }

        $featured   = BlogPost::published()->with('author')->first();
        $trending   = BlogPost::published()->with('author')->take(4)->get();
        $posts      = $query->paginate(9)->withQueryString();
        $categories = array_merge(['All'], BlogPost::CATEGORIES);

        return view('public.blog.index', compact('posts', 'featured', 'trending', 'categories', 'category'));
    }

    /**
     * Show a single published blog post by its slug.
     * Returns 404 if the slug doesn't exist or the post is unpublished.
     */
    public function show(string $slug): View
    {
        $post = BlogPost::where('slug', $slug)->where('is_published', true)->firstOrFail();

        return view('public.blog.show', compact('post'));
    }
}
