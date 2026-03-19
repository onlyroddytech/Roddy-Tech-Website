<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Admin Blog Controller
 *
 * CRUD for blog posts. The logged-in admin is automatically recorded
 * as the author when creating a post.
 *
 * Slug generation: Str::slug(title) + '-' + Str::random(5) ensures
 * unique, URL-safe slugs even when titles are very similar.
 *
 * Publishing behaviour: published_at is stamped once on first publish.
 * Toggling is_published back off does NOT clear published_at, so the
 * original publish date is preserved if the post is re-published later.
 */
class BlogController extends Controller
{
    /** List all posts (published and draft), newest first, paginated. */
    public function index(): View
    {
        return view('admin.blog.index', ['posts' => BlogPost::with('author')->latest()->paginate(15)]);
    }

    /** Show the new post form. */
    public function create(): View
    {
        return view('admin.blog.create');
    }

    /**
     * Validate and persist a new blog post.
     * author_id, slug, and published_at are all set automatically.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'excerpt'      => 'nullable|string|max:500',
            'body'         => 'required|string',
            'is_published' => 'boolean',
        ]);

        $data['author_id']    = auth()->id();
        $data['slug']         = Str::slug($data['title']) . '-' . Str::random(5);
        $data['published_at'] = $data['is_published'] ? now() : null;

        BlogPost::create($data);

        return redirect()->route('admin.blog.index')->with('success', 'Post created.');
    }

    /**
     * Show the edit form.
     * Route model binding key is {blog}, resolving to a BlogPost instance.
     */
    public function edit(BlogPost $blog): View
    {
        return view('admin.blog.edit', ['post' => $blog]);
    }

    /**
     * Validate and save changes to an existing post.
     * Sets published_at on the first time is_published is toggled on.
     * Does not clear published_at when is_published is toggled off.
     */
    public function update(Request $request, BlogPost $blog): RedirectResponse
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'excerpt'      => 'nullable|string|max:500',
            'body'         => 'required|string',
            'is_published' => 'boolean',
        ]);

        if ($data['is_published'] && !$blog->published_at) {
            $data['published_at'] = now();
        }

        $blog->update($data);

        return redirect()->route('admin.blog.index')->with('success', 'Post updated.');
    }

    /** Permanently delete a blog post. */
    public function destroy(BlogPost $blog): RedirectResponse
    {
        $blog->delete();

        return redirect()->route('admin.blog.index')->with('success', 'Post deleted.');
    }
}
