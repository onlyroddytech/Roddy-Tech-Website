{{--
    ┌──────────────────────────────────────────────────────────────────┐
    │  DIGITAL STORE  —  resources/views/public/store.blade.php        │
    │                                                                  │
    │  Sections:                                                       │
    │   1. HERO            — headline + trust badges                   │
    │   2. FILTER BAR      — sticky search + category + sort          │
    │   3. FEATURED STRIP  — 3 top products (default view only)       │
    │   4. PRODUCT GRID    — paginated, 3-col responsive               │
    │   5. TRUST SECTION   — Secure · Instant · Verified · Quality    │
    │   6. CTA             — "Need something custom?" dark banner      │
    │                                                                  │
    │  Data: $products (paginated), $featured, $categories,           │
    │        $category, $search, $sort, $total                        │
    └──────────────────────────────────────────────────────────────────┘
--}}
<x-layouts.public title="Digital Store">

<style>
    /* ── Scroll reveal ───────────────────────────────────────────── */
    .reveal {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.55s cubic-bezier(0.22,1,0.36,1),
                    transform 0.55s cubic-bezier(0.22,1,0.36,1);
    }
    .reveal.visible { opacity: 1; transform: translateY(0); }

    /* ── Hero entrance ───────────────────────────────────────────── */
    @keyframes fadeUp {
        from { opacity:0; transform:translateY(26px); }
        to   { opacity:1; transform:translateY(0); }
    }
    .h-badge { animation: fadeUp .5s cubic-bezier(.22,1,.36,1) .05s both; }
    .h-title { animation: fadeUp .6s cubic-bezier(.22,1,.36,1) .14s both; }
    .h-sub   { animation: fadeUp .6s cubic-bezier(.22,1,.36,1) .23s both; }
    .h-trust { animation: fadeUp .6s cubic-bezier(.22,1,.36,1) .32s both; }

    /* ── Dot grid ────────────────────────────────────────────────── */
    .dot-grid {
        background-image: radial-gradient(circle, #d1d5db 1px, transparent 1px);
        background-size: 28px 28px;
    }

    /* ── Category filter tabs ────────────────────────────────────── */
    .filter-tab {
        display: inline-flex; align-items: center;
        padding: 6px 16px; border-radius: 99px;
        font-size: .8rem; font-weight: 500; white-space: nowrap;
        transition: background .15s, color .15s, box-shadow .15s;
        cursor: pointer; color: #6b7280;
        border: 1.5px solid transparent; text-decoration: none;
    }
    .filter-tab:hover  { color:#1d4ed8; background:#eff6ff; border-color:#bfdbfe; }
    .filter-tab.active { background:#1d4ed8; color:#fff; border-color:#1d4ed8; box-shadow:0 2px 10px rgba(29,78,216,.22); }

    /* ── Category badge colours ─────────────────────────────────── */
    .cat-scripts   { background:#f0fdf4; color:#15803d; }
    .cat-ui-kits   { background:#faf5ff; color:#7c3aed; }
    .cat-templates { background:#fff7ed; color:#c2410c; }
    .cat-tools     { background:#f0f9ff; color:#0369a1; }
    .cat-websites  { background:#eff6ff; color:#1d4ed8; }
    .cat-default   { background:#f3f4f6; color:#4b5563; }

    /* ── Featured cards ──────────────────────────────────────────── */
    .feat-card {
        background:#fff; border:1.5px solid #e5e7eb; border-radius:20px; overflow:hidden;
        transition: transform .22s cubic-bezier(.22,1,.36,1), box-shadow .22s ease, border-color .22s ease;
    }
    .feat-card:hover { transform:translateY(-8px); box-shadow:0 24px 60px rgba(0,0,0,.10); border-color:#bfdbfe; }
    .feat-card:hover .fc-img { transform:scale(1.05); }
    .fc-img { transition: transform .45s cubic-bezier(.22,1,.36,1); }

    /* ── Product grid cards ──────────────────────────────────────── */
    .prod-card {
        background:#fff; border:1.5px solid #e5e7eb; border-radius:18px;
        overflow:hidden; display:flex; flex-direction:column;
        transition: transform .20s cubic-bezier(.22,1,.36,1), box-shadow .20s ease, border-color .20s ease;
    }
    .prod-card:hover { transform:translateY(-6px) scale(1.01); box-shadow:0 18px 48px rgba(0,0,0,.09); border-color:#bfdbfe; }
    .prod-card:hover .pc-img { transform:scale(1.06); }
    .pc-img { transition: transform .40s cubic-bezier(.22,1,.36,1); }

    /* ── Trust cards ─────────────────────────────────────────────── */
    .trust-card {
        background:#fff; border:1.5px solid #e5e7eb; border-radius:16px;
        transition: box-shadow .18s ease, transform .18s ease;
    }
    .trust-card:hover { box-shadow:0 8px 28px rgba(0,0,0,.07); transform:translateY(-3px); }

    /* ── Scrollbar hide ──────────────────────────────────────────── */
    .scrollbar-none { -ms-overflow-style:none; scrollbar-width:none; }
    .scrollbar-none::-webkit-scrollbar { display:none; }

    /* ── Price ───────────────────────────────────────────────────── */
    .price-tag { font-size:1rem; font-weight:800; color:#1d4ed8; }
</style>

@php
$gradients = [
    'scripts'   => ['from'=>'#f0fdf4','to'=>'#bbf7d0','ic'=>'#15803d'],
    'ui-kits'   => ['from'=>'#faf5ff','to'=>'#e9d5ff','ic'=>'#7c3aed'],
    'templates' => ['from'=>'#fff7ed','to'=>'#fed7aa','ic'=>'#c2410c'],
    'tools'     => ['from'=>'#f0f9ff','to'=>'#bae6fd','ic'=>'#0369a1'],
    'websites'  => ['from'=>'#eff6ff','to'=>'#dbeafe','ic'=>'#1d4ed8'],
];
@endphp

{{-- ═══════════════════════════════════════════════════════════════ --}}
{{--  1. HERO                                                        --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
<section class="relative overflow-hidden bg-white dot-grid pt-32 pb-20">

    <div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
        <div class="absolute -top-28 -left-28 w-[540px] h-[540px] rounded-full"
             style="background:radial-gradient(circle,rgba(59,130,246,.12) 0%,transparent 68%);"></div>
        <div class="absolute top-0 right-0 w-[380px] h-[380px] rounded-full"
             style="background:radial-gradient(circle,rgba(16,185,129,.09) 0%,transparent 70%);"></div>
    </div>

    <div class="relative max-w-4xl mx-auto px-6 text-center">

        <div class="h-badge inline-flex items-center gap-2 bg-blue-50 border border-blue-100 text-blue-700 text-xs font-semibold px-4 py-1.5 rounded-full mb-6">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
            Digital Store
        </div>

        <h1 class="h-title text-[38px] sm:text-5xl lg:text-[3.4rem] font-extrabold text-gray-900 leading-[1.1] tracking-tight mb-5">
            Explore Our<br>
            <span class="text-blue-600">Digital Store</span>
        </h1>

        <p class="h-sub max-w-xl mx-auto text-lg text-gray-600 leading-relaxed mb-8">
            Premium scripts, templates, UI kits, and tools — built to the same standard as our client work. Download, customise, and ship.
        </p>

        <div class="h-trust flex flex-wrap items-center justify-center gap-3">
            @foreach([
                ['icon'=>'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z','label'=>'Verified Products','color'=>'text-green-600','bg'=>'bg-green-50 border-green-100'],
                ['icon'=>'M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z',                                                                                                                                                                                                                                                         'label'=>'Instant Access',   'color'=>'text-blue-600', 'bg'=>'bg-blue-50 border-blue-100'],
                ['icon'=>'M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z',                                                                                                                                         'label'=>'Secure Payments',  'color'=>'text-purple-600','bg'=>'bg-purple-50 border-purple-100'],
            ] as $t)
            <div class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-full border {{ $t['bg'] }} {{ $t['color'] }}">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $t['icon'] }}"/>
                </svg>
                {{ $t['label'] }}
            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════ --}}
{{--  2. STICKY FILTER + SEARCH + SORT BAR                          --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
<div class="sticky top-[64px] z-30 bg-white/95 backdrop-blur-md border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-3">

        <form method="GET" action="{{ route('store.index') }}"
              class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">

            {{-- Search --}}
            <div class="relative flex-1 min-w-0">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"
                     fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                </svg>
                <input type="text" name="search" value="{{ $search }}"
                       placeholder="Search products…"
                       class="w-full pl-10 pr-4 py-2 text-sm border border-gray-200 rounded-xl bg-gray-50 text-gray-900 placeholder-gray-400 focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition">
            </div>

            {{-- Sort --}}
            <div class="relative shrink-0">
                <select name="sort" onchange="this.form.submit()"
                        class="appearance-none pl-4 pr-8 py-2 text-sm border border-gray-200 rounded-xl bg-gray-50 text-gray-700 focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100 cursor-pointer transition">
                    <option value="popular"    {{ $sort==='popular'    ?'selected':'' }}>Popular</option>
                    <option value="newest"     {{ $sort==='newest'     ?'selected':'' }}>Newest</option>
                    <option value="price_low"  {{ $sort==='price_low'  ?'selected':'' }}>Price: Low → High</option>
                    <option value="price_high" {{ $sort==='price_high' ?'selected':'' }}>Price: High → Low</option>
                </select>
                <svg class="absolute right-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-gray-400 pointer-events-none"
                     fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>

            {{-- Search button (mobile) --}}
            <button type="submit"
                    class="sm:hidden bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2 px-5 rounded-xl transition">
                Search
            </button>

        </form>

        {{-- Category tabs --}}
        <div class="flex items-center gap-2 mt-2.5 overflow-x-auto scrollbar-none pb-0.5">
            @foreach($categories as $cat)
            @php
                $isActive = (!$category && $cat==='All') || $category===$cat;
                $catUrl   = route('store.index', array_filter([
                    'category' => $cat==='All' ? null : $cat,
                    'search'   => $search ?: null,
                    'sort'     => $sort!=='popular' ? $sort : null,
                ]));
            @endphp
            <a href="{{ $catUrl }}" class="filter-tab {{ $isActive ? 'active' : '' }}">{{ $cat }}</a>
            @endforeach

            @if($search || ($category && $category !== 'All'))
            <a href="{{ route('store.index') }}"
               class="ml-auto shrink-0 inline-flex items-center gap-1 text-xs text-gray-400 hover:text-gray-700 font-medium transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Clear
            </a>
            @endif
        </div>

    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════ --}}
{{--  3. FEATURED STRIP                                             --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
@if($featured->isNotEmpty() && !$search && (!$category || $category==='All') && $sort==='popular' && $products->currentPage()===1)
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-6">

        <div class="reveal flex items-end justify-between mb-10 gap-4">
            <div>
                <span class="inline-block text-xs font-semibold text-blue-600 bg-blue-50 border border-blue-100 px-3 py-1 rounded-full mb-2">
                    Featured
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Top Picks</h2>
            </div>
            <span class="text-xs text-gray-400 font-medium shrink-0">{{ $total }} products in store</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-7">
            @foreach($featured->take(3) as $i => $fp)
            @php
                $fSlug = strtolower(str_replace(' ','-',$fp->category ?? 'tools'));
                $fG    = $gradients[$fSlug] ?? ['from'=>'#f3f4f6','to'=>'#e5e7eb','ic'=>'#6b7280'];
            @endphp
            <div class="feat-card reveal" style="transition-delay:{{ $i*90 }}ms">

                <div class="relative h-48 overflow-hidden flex items-center justify-center"
                     style="background:linear-gradient(135deg,{{ $fG['from'] }} 0%,{{ $fG['to'] }} 100%)">
                    @if($fp->image)
                        <img src="{{ asset('storage/'.$fp->image) }}" alt="{{ $fp->title }}"
                             class="fc-img w-full h-full object-cover" loading="lazy">
                    @else
                        <div class="absolute inset-0 overflow-hidden" aria-hidden="true">
                            <div class="absolute -top-5 -right-5 w-32 h-32 rounded-2xl rotate-12 opacity-25" style="background:{{ $fG['ic'] }}"></div>
                            <div class="absolute bottom-2 -left-4 w-20 h-20 rounded-xl -rotate-6 opacity-15" style="background:{{ $fG['ic'] }}"></div>
                        </div>
                        <div class="relative z-10 w-16 h-16 bg-white rounded-2xl shadow-lg flex items-center justify-center">
                            <svg class="w-8 h-8" fill="none" stroke="{{ $fG['ic'] }}" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                            </svg>
                        </div>
                    @endif
                    <div class="absolute top-3 left-3 bg-blue-600 text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow">
                        Featured
                    </div>
                </div>

                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <span class="cat-{{ $fSlug }} text-[10px] font-semibold px-2.5 py-1 rounded-full uppercase tracking-wide">
                            {{ $fp->category }}
                        </span>
                        <span class="price-tag">{{ $fp->price }}</span>
                    </div>
                    <h3 class="font-bold text-gray-900 text-base leading-snug mb-2">{{ $fp->title }}</h3>
                    <p class="text-xs text-gray-500 leading-relaxed line-clamp-2 mb-5">{{ $fp->description }}</p>
                    <a href="{{ $fp->url && $fp->url !== '#' ? $fp->url : '/contact' }}"
                       {{ $fp->url && $fp->url !== '#' ? 'target="_blank"' : '' }}
                       class="w-full inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2.5 rounded-xl transition-all duration-200 hover:shadow-md hover:shadow-blue-200">
                        View Details
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>

            </div>
            @endforeach
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-6"><div class="border-t border-gray-100"></div></div>
@endif

{{-- ═══════════════════════════════════════════════════════════════ --}}
{{--  4. PRODUCT GRID                                               --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6">

        {{-- Results header --}}
        <div class="reveal flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-10">
            <p class="text-gray-500 text-sm">
                @if($search)
                    Results for <span class="font-semibold text-gray-900">"{{ $search }}"</span>
                    — {{ $products->total() }} product{{ $products->total() !== 1 ? 's' : '' }}
                @elseif($category && $category !== 'All')
                    <span class="font-semibold text-gray-900">{{ $category }}</span>
                    — {{ $products->total() }} product{{ $products->total() !== 1 ? 's' : '' }}
                @else
                    All Products
                    — <span class="font-semibold text-gray-900">{{ $products->total() }}</span> available
                @endif
            </p>
        </div>

        {{-- Empty state --}}
        @if($products->isEmpty())
        <div class="text-center py-20">
            <div class="w-16 h-16 bg-white border border-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm">
                <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                </svg>
            </div>
            <p class="font-semibold text-gray-700 mb-1">No products found</p>
            <p class="text-sm text-gray-400 mb-5">Try a different search term or category.</p>
            <a href="{{ route('store.index') }}" class="text-sm text-blue-600 font-semibold hover:underline">Clear search →</a>
        </div>

        @else

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($products as $i => $product)
            @php
                $pSlug = strtolower(str_replace(' ','-',$product->category ?? 'tools'));
                $pG    = $gradients[$pSlug] ?? ['from'=>'#f3f4f6','to'=>'#e5e7eb','ic'=>'#6b7280'];
            @endphp
            <div class="prod-card reveal" style="transition-delay:{{ ($i % 3)*80 }}ms">

                {{-- Image --}}
                <div class="relative h-44 overflow-hidden flex items-center justify-center"
                     style="background:linear-gradient(135deg,{{ $pG['from'] }} 0%,{{ $pG['to'] }} 100%)">
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->title }}"
                             class="pc-img w-full h-full object-cover" loading="lazy">
                    @else
                        <div class="absolute inset-0 overflow-hidden" aria-hidden="true">
                            <div class="absolute -top-4 -right-4 w-24 h-24 rounded-2xl rotate-12 opacity-20" style="background:{{ $pG['ic'] }}"></div>
                            <div class="absolute bottom-1 -left-3 w-16 h-16 rounded-xl -rotate-6 opacity-15" style="background:{{ $pG['ic'] }}"></div>
                        </div>
                        <div class="relative z-10 w-12 h-12 bg-white rounded-xl shadow-md flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="{{ $pG['ic'] }}" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                            </svg>
                        </div>
                    @endif
                    @if($product->is_featured)
                    <div class="absolute top-2.5 right-2.5 bg-blue-600 text-white text-[9px] font-bold px-2 py-0.5 rounded-full shadow">
                        Featured
                    </div>
                    @endif
                </div>

                {{-- Body --}}
                <div class="p-5 flex flex-col flex-1">
                    <div class="flex items-center justify-between mb-2.5">
                        <span class="cat-{{ $pSlug }} text-[10px] font-semibold px-2.5 py-1 rounded-full uppercase tracking-wide">
                            {{ $product->category }}
                        </span>
                        <span class="price-tag text-sm">{{ $product->price }}</span>
                    </div>
                    <h3 class="font-bold text-gray-900 text-sm leading-snug mb-1.5">{{ $product->title }}</h3>
                    <p class="text-xs text-gray-500 leading-relaxed line-clamp-2 flex-1 mb-4">{{ $product->description }}</p>
                    <a href="{{ $product->url && $product->url !== '#' ? $product->url : '/contact' }}"
                       {{ $product->url && $product->url !== '#' ? 'target="_blank"' : '' }}
                       class="w-full inline-flex items-center justify-center gap-1.5 bg-gray-900 hover:bg-blue-600 text-white text-xs font-semibold py-2.5 rounded-xl transition-all duration-200 hover:shadow-md hover:shadow-blue-200 mt-auto">
                        Buy Now
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>

            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($products->hasPages())
        <div class="mt-12 flex items-center justify-center gap-1.5 reveal">

            {{-- Prev --}}
            @if($products->onFirstPage())
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl border border-gray-200 text-gray-300 cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </span>
            @else
                <a href="{{ $products->previousPageUrl() }}"
                   class="inline-flex items-center justify-center w-10 h-10 rounded-xl border border-gray-200 text-gray-600 hover:bg-blue-50 hover:border-blue-200 hover:text-blue-600 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </a>
            @endif

            {{-- Page numbers --}}
            @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                @if($page == $products->currentPage())
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-blue-600 text-white text-sm font-bold shadow-md shadow-blue-200">{{ $page }}</span>
                @else
                    <a href="{{ $url }}"
                       class="inline-flex items-center justify-center w-10 h-10 rounded-xl border border-gray-200 text-gray-600 hover:bg-blue-50 hover:border-blue-200 hover:text-blue-600 transition text-sm font-medium">
                        {{ $page }}
                    </a>
                @endif
            @endforeach

            {{-- Next --}}
            @if($products->hasMorePages())
                <a href="{{ $products->nextPageUrl() }}"
                   class="inline-flex items-center justify-center w-10 h-10 rounded-xl border border-gray-200 text-gray-600 hover:bg-blue-50 hover:border-blue-200 hover:text-blue-600 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            @else
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl border border-gray-200 text-gray-300 cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </span>
            @endif

        </div>
        <p class="text-center text-xs text-gray-400 mt-3">
            Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }} products
        </p>
        @endif

        @endif {{-- end isEmpty --}}
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════ --}}
{{--  5. TRUST SECTION                                              --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
<section class="py-16 bg-white">
    <div class="max-w-5xl mx-auto px-6">

        <div class="reveal text-center mb-10">
            <h2 class="text-xl font-extrabold text-gray-900">Buy with Confidence</h2>
            <p class="text-gray-500 text-sm mt-1">Every product is built, tested, and guaranteed by Roddy Technologies.</p>
        </div>

        <div class="reveal grid grid-cols-2 lg:grid-cols-4 gap-4">

            @foreach([
                ['icon'=>'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z',   'title'=>'Verified Products', 'sub'=>'Reviewed before publish', 'ic'=>'text-green-600', 'bg'=>'bg-green-50'],
                ['icon'=>'M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z',                                                                                                                                                         'title'=>'Instant Access',    'sub'=>'Download immediately',   'ic'=>'text-blue-600',  'bg'=>'bg-blue-50'],
                ['icon'=>'M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z',                                          'title'=>'Secure Payments',   'sub'=>'MoMo · Orange · Card',  'ic'=>'text-purple-600','bg'=>'bg-purple-50'],
                ['icon'=>'M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z','title'=>'Quality Guarantee', 'sub'=>'Built to our standard', 'ic'=>'text-orange-500','bg'=>'bg-orange-50'],
            ] as $t)
            <div class="trust-card p-5 text-center">
                <div class="w-10 h-10 {{ $t['bg'] }} rounded-xl flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5 {{ $t['ic'] }}" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $t['icon'] }}"/>
                    </svg>
                </div>
                <div class="font-bold text-gray-900 text-sm">{{ $t['title'] }}</div>
                <div class="text-xs text-gray-400 mt-0.5">{{ $t['sub'] }}</div>
            </div>
            @endforeach

        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════ --}}
{{--  6. CTA                                                        --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
<section class="py-20 bg-gray-900">
    <div class="max-w-3xl mx-auto px-6 text-center reveal">

        <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 text-white text-xs font-semibold px-4 py-1.5 rounded-full mb-6">
            <span class="w-2 h-2 rounded-full bg-green-400"></span>
            Available for custom work
        </div>

        <h2 class="text-[30px] sm:text-4xl font-extrabold text-white leading-tight mb-4">
            Need Something Custom?
        </h2>
        <p class="text-gray-400 text-base leading-relaxed max-w-lg mx-auto mb-9">
            Can't find exactly what you need? We build fully custom solutions tailored to your business — from scratch, to spec, on time.
        </p>

        <div class="flex flex-wrap items-center justify-center gap-4">
            <a href="/contact"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-500 text-white font-semibold text-sm px-8 py-3.5 rounded-xl shadow-lg shadow-blue-900/40 transition-all duration-200 hover:-translate-y-0.5">
                Start a Project
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
            <a href="/contact"
               class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white font-semibold text-sm px-8 py-3.5 rounded-xl transition-all duration-200 hover:-translate-y-0.5">
                Contact Us
            </a>
        </div>

    </div>
</section>

{{-- Scroll reveal --}}
<script>
(function () {
    const io = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) { e.target.classList.add('visible'); io.unobserve(e.target); }
        });
    }, { threshold: 0.07 });
    document.querySelectorAll('.reveal').forEach(el => io.observe(el));
})();
</script>

</x-layouts.public>
