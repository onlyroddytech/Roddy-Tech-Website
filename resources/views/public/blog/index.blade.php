{{--
    ┌──────────────────────────────────────────────────────────────────┐
    │  BLOG INDEX  —  resources/views/public/blog/index.blade.php      │
    │                                                                  │
    │  Sections:                                                       │
    │   1. HERO          — headline + featured post card               │
    │   2. FILTER BAR    — sticky category tabs + search               │
    │   3. BLOG GRID     — 3-col responsive, paginated                 │
    │   4. TRENDING      — 4 compact horizontal cards                  │
    │   5. CTA           — dark "Start a Project" banner               │
    │                                                                  │
    │  Data from controller:                                           │
    │   $posts, $featured, $trending, $categories, $category           │
    └──────────────────────────────────────────────────────────────────┘
--}}
<x-layouts.public title="Blog">

<style>
    /* ── Scroll reveal ──────────────────────────────────────────── */
    .reveal {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.55s cubic-bezier(0.22,1,0.36,1),
                    transform 0.55s cubic-bezier(0.22,1,0.36,1);
    }
    .reveal.visible { opacity: 1; transform: translateY(0); }

    /* ── Hero entrance ──────────────────────────────────────────── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .h-badge { animation: fadeUp 0.55s cubic-bezier(0.22,1,0.36,1) 0.05s both; }
    .h-title { animation: fadeUp 0.65s cubic-bezier(0.22,1,0.36,1) 0.15s both; }
    .h-sub   { animation: fadeUp 0.65s cubic-bezier(0.22,1,0.36,1) 0.26s both; }
    .h-feat  { animation: fadeUp 0.70s cubic-bezier(0.22,1,0.36,1) 0.36s both; }

    /* ── Blog post cards ────────────────────────────────────────── */
    .blog-card {
        background: #ffffff;
        border: 1.5px solid #e5e7eb;
        border-radius: 18px;
        overflow: hidden;
        transition: transform 0.20s cubic-bezier(0.22,1,0.36,1),
                    box-shadow 0.20s ease,
                    border-color 0.20s ease;
    }
    .blog-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 44px rgba(0,0,0,0.09);
        border-color: #bfdbfe;
    }
    .blog-card:hover .blog-thumb { transform: scale(1.04); }
    .blog-thumb {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.40s cubic-bezier(0.22,1,0.36,1);
    }

    /* ── Featured post ──────────────────────────────────────────── */
    .featured-card {
        background: #ffffff;
        border: 1.5px solid #e5e7eb;
        border-radius: 22px;
        overflow: hidden;
        transition: transform 0.22s cubic-bezier(0.22,1,0.36,1),
                    box-shadow 0.22s ease;
    }
    .featured-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 56px rgba(0,0,0,0.10);
    }
    .featured-card:hover .featured-thumb { transform: scale(1.03); }
    .featured-thumb {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.40s cubic-bezier(0.22,1,0.36,1);
    }

    /* ── Trending cards ─────────────────────────────────────────── */
    .trending-card {
        background: #ffffff;
        border: 1.5px solid #e5e7eb;
        border-radius: 14px;
        transition: transform 0.18s cubic-bezier(0.22,1,0.36,1),
                    box-shadow 0.18s ease,
                    border-color 0.18s ease;
    }
    .trending-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 28px rgba(0,0,0,0.08);
        border-color: #a5f3c0;
    }

    /* ── Category badge ─────────────────────────────────────────── */
    .cat-badge {
        display: inline-flex;
        align-items: center;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }
    .cat-blue   { background: #eff6ff; color: #2563eb; }
    .cat-green  { background: #f0fdf4; color: #16a34a; }
    .cat-purple { background: #faf5ff; color: #7c3aed; }
    .cat-orange { background: #fff7ed; color: #ea580c; }
    .cat-teal   { background: #ecfeff; color: #0891b2; }
    .cat-gray   { background: #f9fafb; color: #4b5563; }

    /* ── Filter bar ─────────────────────────────────────────────── */
    .filter-tab {
        padding: 7px 16px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 600;
        color: #6b7280;
        border: 1.5px solid transparent;
        transition: all 0.16s ease;
        white-space: nowrap;
        cursor: pointer;
        text-decoration: none;
    }
    .filter-tab:hover { color: #111827; background: #f3f4f6; }
    .filter-tab.active { background: #111827; color: #fff; border-color: #111827; }

    /* ── Search input ───────────────────────────────────────────── */
    .search-input {
        border: 1.5px solid #e5e7eb;
        border-radius: 10px;
        padding: 8px 14px 8px 38px;
        font-size: 13px;
        color: #111827;
        background: #f9fafb;
        outline: none;
        font-family: inherit;
        transition: border-color 0.16s, box-shadow 0.16s, background 0.16s;
        width: 220px;
    }
    .search-input:focus {
        border-color: #2563eb;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.10);
        width: 260px;
    }
    @media (max-width: 640px) {
        .search-input, .search-input:focus { width: 100%; }
    }

    /* ── No-posts placeholder ───────────────────────────────────── */
    .thumb-placeholder {
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

@php
    $catColors = [
        'Development'  => 'cat-blue',
        'Business'     => 'cat-green',
        'Technology'   => 'cat-teal',
        'Tutorials'    => 'cat-purple',
        'Case Studies' => 'cat-orange',
        'General'      => 'cat-gray',
    ];
    function catColor(string $cat, array $map): string {
        return $map[$cat] ?? 'cat-gray';
    }
@endphp

{{-- ═══════════════════════════════════════════════════════════════
     1. HERO
════════════════════════════════════════════════════════════════ --}}
<section class="relative bg-white overflow-hidden pt-32 pb-16 px-4 sm:px-6">

    <div class="absolute inset-0 pointer-events-none"
         style="background-image: radial-gradient(circle, rgba(0,0,0,0.07) 1.5px, transparent 1.5px); background-size: 30px 30px;"></div>
    <div class="absolute top-0 right-0 w-[500px] h-[420px] pointer-events-none"
         style="background: radial-gradient(ellipse at top right, rgba(37,99,235,0.07) 0%, transparent 65%);"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[360px] pointer-events-none"
         style="background: radial-gradient(ellipse at bottom left, rgba(5,150,105,0.05) 0%, transparent 65%);"></div>

    <div class="relative max-w-6xl mx-auto">

        {{-- Headline block --}}
        <div class="max-w-2xl mb-14">
            <div class="h-badge inline-flex items-center gap-2 mb-6 px-4 py-2 rounded-full bg-blue-50 border border-blue-200">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-pulse"></span>
                <span class="text-xs font-bold text-blue-700 uppercase tracking-widest">The Roddy Blog</span>
            </div>
            <h1 class="h-title text-[2.4rem] sm:text-5xl font-black tracking-tight text-gray-900 leading-[1.06] mb-5">
                Insights from<br>
                <span class="text-blue-600">Roddy Technologies</span>
            </h1>
            <p class="h-sub text-base sm:text-lg text-gray-700 leading-relaxed max-w-lg">
                Deep dives into software, development, business strategy, and the technology shaping Africa's digital future.
            </p>
        </div>

        {{-- Featured post --}}
        @if($featured)
        <div class="h-feat">
            <a href="{{ route('blog.show', $featured->slug) }}" class="featured-card block group">
                <div class="grid lg:grid-cols-[1fr_420px] items-stretch">

                    {{-- Image --}}
                    <div class="relative overflow-hidden" style="min-height: 300px;">
                        @if($featured->cover_image)
                            <img src="{{ asset('storage/' . $featured->cover_image) }}"
                                 alt="{{ $featured->title }}"
                                 class="featured-thumb absolute inset-0 w-full h-full object-cover"
                                 loading="lazy">
                        @else
                            <div class="thumb-placeholder absolute inset-0">
                                <svg class="w-12 h-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        <div class="absolute top-4 left-4">
                            <span class="px-2.5 py-1 rounded-full text-[11px] font-black uppercase tracking-wider bg-blue-600 text-white">
                                Featured
                            </span>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-8 sm:p-10 flex flex-col justify-center">
                        <span class="cat-badge {{ catColor($featured->category, $catColors) }} mb-4 self-start">
                            {{ $featured->category }}
                        </span>
                        <h2 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight leading-[1.1] mb-4 group-hover:text-blue-600 transition-colors">
                            {{ $featured->title }}
                        </h2>
                        @if($featured->excerpt)
                        <p class="text-gray-700 text-sm leading-relaxed mb-6 line-clamp-3">
                            {{ $featured->excerpt }}
                        </p>
                        @endif
                        <div class="flex items-center gap-4 text-xs text-gray-500 mb-6">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $featured->published_at?->format('M d, Y') }}
                            </span>
                            <span class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $featured->read_time }} min read
                            </span>
                            <span>By {{ $featured->author->name }}</span>
                        </div>
                        <div class="inline-flex items-center gap-2 text-sm font-bold text-blue-600 group-hover:gap-3 transition-all">
                            Read Article
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </div>
                    </div>

                </div>
            </a>
        </div>
        @endif

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     2. STICKY FILTER BAR
════════════════════════════════════════════════════════════════ --}}
<div class="sticky top-20 z-40 bg-white border-b border-gray-100"
     style="box-shadow: 0 1px 12px rgba(0,0,0,0.05);">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-3 flex items-center justify-between gap-4">

        {{-- Category tabs --}}
        <div class="flex items-center gap-1.5 overflow-x-auto scrollbar-hide flex-1">
            @foreach($categories as $cat)
            <a href="{{ route('blog.index', $cat !== 'All' ? ['category' => $cat] : []) }}"
               class="filter-tab {{ ($category ?? 'All') === $cat || ($cat === 'All' && !$category) ? 'active' : '' }}">
                {{ $cat }}
            </a>
            @endforeach
        </div>

        {{-- Search --}}
        <div class="relative shrink-0 hidden sm:block">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-gray-400 pointer-events-none"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="search" placeholder="Search articles..." class="search-input">
        </div>

    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════
     3. BLOG GRID
════════════════════════════════════════════════════════════════ --}}
<section class="bg-white py-16 px-4 sm:px-6">
    <div class="max-w-6xl mx-auto">

        @if($category && $category !== 'All')
        <div class="flex items-center gap-3 mb-10">
            <h2 class="text-xl font-black text-gray-900">{{ $category }}</h2>
            <span class="text-xs font-semibold text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full">
                {{ $posts->total() }} {{ Str::plural('post', $posts->total()) }}
            </span>
            <a href="{{ route('blog.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800 transition-colors ml-auto">
                ← All posts
            </a>
        </div>
        @else
        <div class="mb-10">
            <h2 class="text-2xl font-black text-gray-900">Latest Articles</h2>
            <p class="text-sm text-gray-500 mt-1">{{ $posts->total() }} {{ Str::plural('post', $posts->total()) }} published</p>
        </div>
        @endif

        @if($posts->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($posts as $i => $post)
            <a href="{{ route('blog.show', $post->slug) }}"
               class="blog-card reveal block group"
               style="transition-delay: {{ ($i % 3) * 60 }}ms">

                {{-- Thumbnail --}}
                <div class="relative overflow-hidden" style="height: 200px;">
                    @if($post->cover_image)
                        <img src="{{ asset('storage/' . $post->cover_image) }}"
                             alt="{{ $post->title }}"
                             class="blog-thumb"
                             loading="lazy">
                    @else
                        <div class="thumb-placeholder w-full h-full">
                            <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                </div>

                {{-- Content --}}
                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <span class="cat-badge {{ catColor($post->category, $catColors) }}">
                            {{ $post->category }}
                        </span>
                        <span class="text-xs text-gray-400 font-medium">{{ $post->read_time }} min read</span>
                    </div>

                    <h3 class="text-base font-black text-gray-900 leading-tight mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors">
                        {{ $post->title }}
                    </h3>

                    @if($post->excerpt)
                    <p class="text-sm text-gray-700 leading-relaxed line-clamp-2 mb-4">
                        {{ $post->excerpt }}
                    </p>
                    @endif

                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full bg-blue-600 flex items-center justify-center text-[10px] font-bold text-white">
                                {{ strtoupper(substr($post->author->name, 0, 1)) }}
                            </div>
                            <span class="text-xs text-gray-500 font-medium">{{ $post->author->name }}</span>
                        </div>
                        <span class="text-xs text-gray-400">{{ $post->published_at?->format('M d, Y') }}</span>
                    </div>
                </div>

            </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($posts->hasPages())
        <div class="mt-12 flex justify-center">
            {{ $posts->links() }}
        </div>
        @endif

        @else
        <div class="text-center py-24">
            <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mx-auto mb-5">
                <svg class="w-7 h-7 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <h3 class="text-lg font-black text-gray-900 mb-2">No posts yet</h3>
            <p class="text-sm text-gray-500">
                @if($category && $category !== 'All')
                    No posts in <strong>{{ $category }}</strong> yet.
                    <a href="{{ route('blog.index') }}" class="text-blue-600 hover:underline">View all posts</a>
                @else
                    Check back soon — great content is coming.
                @endif
            </p>
        </div>
        @endif

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     4. TRENDING
════════════════════════════════════════════════════════════════ --}}
@if($trending->count())
<section class="bg-gray-50 border-t border-gray-100 py-16 px-4 sm:px-6">
    <div class="max-w-6xl mx-auto">

        <div class="reveal flex items-center justify-between mb-10">
            <div>
                <p class="text-xs font-bold text-green-600 uppercase tracking-widest mb-1">Trending Now</p>
                <h2 class="text-2xl font-black text-gray-900">Most Read</h2>
            </div>
            <a href="{{ route('blog.index') }}"
               class="text-sm font-semibold text-gray-500 hover:text-gray-900 transition-colors flex items-center gap-1.5">
                View all
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($trending as $i => $post)
            <a href="{{ route('blog.show', $post->slug) }}"
               class="trending-card reveal block p-5 group"
               style="transition-delay: {{ $i * 55 }}ms">

                <div class="flex items-center gap-2 mb-3">
                    <span class="cat-badge {{ catColor($post->category, $catColors) }}">{{ $post->category }}</span>
                    <span class="text-xs text-gray-400 ml-auto">{{ $post->read_time }}m</span>
                </div>

                <h3 class="text-sm font-black text-gray-900 leading-snug line-clamp-2 mb-3 group-hover:text-blue-600 transition-colors">
                    {{ $post->title }}
                </h3>

                <div class="flex items-center gap-2 pt-3 border-t border-gray-100">
                    <div class="w-5 h-5 rounded-full bg-green-600 flex items-center justify-center text-[9px] font-bold text-white">
                        {{ strtoupper(substr($post->author->name, 0, 1)) }}
                    </div>
                    <span class="text-xs text-gray-500">{{ $post->published_at?->format('M d') }}</span>
                    <span class="ml-auto text-[10px] font-bold text-gray-400">#{{ $i + 1 }}</span>
                </div>

            </a>
            @endforeach
        </div>

    </div>
</section>
@endif

{{-- ═══════════════════════════════════════════════════════════════
     5. CTA
════════════════════════════════════════════════════════════════ --}}
<section class="relative py-24 px-4 sm:px-6 overflow-hidden bg-gray-900">

    <div class="absolute inset-0 pointer-events-none"
         style="background-image: radial-gradient(circle, rgba(255,255,255,0.04) 1.5px, transparent 1.5px); background-size: 28px 28px;"></div>
    <div class="absolute top-0 right-0 w-[500px] h-[400px] pointer-events-none"
         style="background: radial-gradient(ellipse at top right, rgba(37,99,235,0.18) 0%, transparent 65%);"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[300px] pointer-events-none"
         style="background: radial-gradient(ellipse at bottom left, rgba(5,150,105,0.14) 0%, transparent 65%);"></div>

    <div class="relative max-w-3xl mx-auto text-center reveal">

        <p class="text-xs font-bold text-blue-400 uppercase tracking-widest mb-5">Work With Us</p>

        <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-[1.06] mb-5">
            Let's build your<br>next big project
        </h2>

        <p class="text-base text-gray-400 leading-relaxed max-w-lg mx-auto mb-10">
            From idea to production — we design, build, and scale digital products that deliver real results for your business.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('contact') }}"
               class="inline-flex items-center gap-2.5 px-8 py-4 rounded-xl bg-blue-600 text-white text-sm font-bold hover:bg-blue-700 transition-colors"
               style="box-shadow: 0 8px 28px rgba(37,99,235,0.36);">
                Start a Project
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
            <a href="{{ route('services') }}"
               class="inline-flex items-center gap-2 px-8 py-4 rounded-xl text-sm font-semibold text-gray-300 border border-gray-700 hover:border-gray-500 hover:text-white transition-colors">
                View Our Services
            </a>
        </div>

    </div>
</section>

<script>
(function () {
    var els = document.querySelectorAll('.reveal');
    var obs = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
            if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); }
        });
    }, { threshold: 0.10 });
    els.forEach(function (el) { obs.observe(el); });
}());
</script>

</x-layouts.public>
