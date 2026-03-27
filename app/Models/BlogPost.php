<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * BlogPost Model
 *
 * A published article on the Roddy Technologies blog.
 *
 * Slug: auto-generated in Admin\BlogController as Str::slug(title) + random suffix.
 * Guarantees URL-safe, unique identifiers even for similar titles.
 *
 * Publishing: published_at is set once when is_published is first toggled on.
 * It is NOT cleared when is_published is set back to false, so the original
 * publish date is preserved if the post is re-published later.
 *
 * Relationships:
 *   author() → the User (admin) who wrote the post (author_id FK)
 *
 * Scope:
 *   published() → only published posts, ordered by published_at descending.
 */
class BlogPost extends Model
{
    const CATEGORIES = [
        'Development', 'Business', 'Technology', 'Tutorials', 'Case Studies', 'General',
    ];

    protected $fillable = [
        'author_id', 'title', 'slug', 'category', 'excerpt', 'body',
        'cover_image', 'is_published', 'published_at',
    ];

    /** Estimated reading time in minutes based on body word count (~200 wpm). */
    public function getReadTimeAttribute(): int
    {
        return max(1, (int) ceil(str_word_count(strip_tags($this->body)) / 200));
    }

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->latest('published_at');
    }
}
