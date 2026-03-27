{{--
    ┌──────────────────────────────────────────────────────────────────┐
    │  TUTORIALS  —  resources/views/public/support/tutorials.blade.php│
    │                                                                  │
    │  Sections:                                                       │
    │   1. HERO            — headline + search + filter tabs           │
    │   2. FEATURED        — large spotlight tutorial card             │
    │   3. TUTORIAL GRID   — 3-col responsive, Alpine-filtered         │
    │   4. CATEGORIES      — 4 category cards with counts             │
    │   5. LEARNING PATH   — 3-step beginner → advanced progression   │
    │   6. CTA             — dark "Build it for you?" banner           │
    │                                                                  │
    │  State: Alpine.js (activeFilter, search)                        │
    │  Future: replace $tutorials PHP array with DB + AJAX            │
    └──────────────────────────────────────────────────────────────────┘
--}}
<x-layouts.public title="Tutorials & Guides">

<style>
    /* ── Scroll reveal ───────────────────────────────────────────── */
    .reveal { opacity:0; transform:translateY(22px); transition:opacity .58s cubic-bezier(.22,1,.36,1), transform .58s cubic-bezier(.22,1,.36,1); }
    .reveal.visible { opacity:1; transform:translateY(0); }

    /* ── Hero entrance ───────────────────────────────────────────── */
    @keyframes fadeUp { from{opacity:0;transform:translateY(26px)} to{opacity:1;transform:translateY(0)} }
    .h-badge { animation:fadeUp .5s cubic-bezier(.22,1,.36,1) .05s both; }
    .h-title { animation:fadeUp .6s cubic-bezier(.22,1,.36,1) .14s both; }
    .h-sub   { animation:fadeUp .6s cubic-bezier(.22,1,.36,1) .22s both; }
    .h-srch  { animation:fadeUp .6s cubic-bezier(.22,1,.36,1) .30s both; }
    .h-tabs  { animation:fadeUp .6s cubic-bezier(.22,1,.36,1) .38s both; }

    /* ── Dot grid ────────────────────────────────────────────────── */
    .dot-grid { background-image:radial-gradient(circle,#d1d5db 1px,transparent 1px); background-size:28px 28px; }

    /* ── Filter tabs ─────────────────────────────────────────────── */
    .f-tab {
        display:inline-flex; align-items:center; gap:6px;
        padding:7px 18px; border-radius:99px;
        font-size:.8rem; font-weight:500; white-space:nowrap;
        border:1.5px solid transparent; cursor:pointer;
        transition:background .15s,color .15s,border-color .15s,box-shadow .15s;
        color:#6b7280;
    }
    .f-tab:hover   { background:#f3f4f6; color:#111827; }
    .f-tab.on      { background:#1d4ed8; color:#fff; border-color:#1d4ed8; box-shadow:0 2px 12px rgba(29,78,216,.24); }

    /* ── Featured card ───────────────────────────────────────────── */
    .feat-card {
        background:#fff; border:1.5px solid #e5e7eb; border-radius:24px; overflow:hidden;
        transition:transform .25s cubic-bezier(.22,1,.36,1), box-shadow .25s ease, border-color .25s ease;
    }
    .feat-card:hover { transform:translateY(-6px); box-shadow:0 28px 65px rgba(0,0,0,.09); border-color:#bfdbfe; }
    .feat-card:hover .feat-img { transform:scale(1.04); }
    .feat-img { transition:transform .5s cubic-bezier(.22,1,.36,1); }

    /* ── Tutorial grid card ──────────────────────────────────────── */
    .tut-card {
        background:#fff; border:1.5px solid #e5e7eb; border-radius:18px; overflow:hidden;
        display:flex; flex-direction:column;
        transition:transform .20s cubic-bezier(.22,1,.36,1), box-shadow .20s ease, border-color .20s ease;
    }
    .tut-card:hover { transform:translateY(-6px); box-shadow:0 18px 48px rgba(0,0,0,.09); border-color:#bfdbfe; }
    .tut-card:hover .tut-img { transform:scale(1.06); }
    .tut-img { transition:transform .45s cubic-bezier(.22,1,.36,1); }

    /* ── Category cards ──────────────────────────────────────────── */
    .cat-card {
        background:#fff; border:1.5px solid #e5e7eb; border-radius:18px;
        transition:transform .20s cubic-bezier(.22,1,.36,1), box-shadow .20s ease, border-color .20s ease;
        cursor:pointer;
    }
    .cat-card:hover { transform:translateY(-5px); box-shadow:0 14px 40px rgba(0,0,0,.08); border-color:#bfdbfe; }

    /* ── Learning path ───────────────────────────────────────────── */
    .path-card {
        background:#fff; border:1.5px solid #e5e7eb; border-radius:20px;
        transition:transform .20s cubic-bezier(.22,1,.36,1), box-shadow .20s ease;
        position:relative; overflow:hidden;
    }
    .path-card:hover { transform:translateY(-5px); box-shadow:0 16px 44px rgba(0,0,0,.09); }
    .path-connector { position:absolute; top:36px; right:-24px; width:48px; height:2px; background:linear-gradient(90deg,#bfdbfe,#bbf7d0); z-index:10; }

    /* ── Category badge colours ─────────────────────────────────── */
    .badge-webdev  { background:#eff6ff; color:#1d4ed8; }
    .badge-design  { background:#faf5ff; color:#7c3aed; }
    .badge-business{ background:#f0fdf4; color:#15803d; }
    .badge-tools   { background:#fff7ed; color:#c2410c; }
    .badge-all     { background:#f3f4f6; color:#4b5563; }

    /* ── Thumbnail placeholders ──────────────────────────────────── */
    .thumb-webdev   { background:linear-gradient(135deg,#eff6ff 0%,#dbeafe 100%); }
    .thumb-design   { background:linear-gradient(135deg,#faf5ff 0%,#e9d5ff 100%); }
    .thumb-business { background:linear-gradient(135deg,#f0fdf4 0%,#bbf7d0 100%); }
    .thumb-tools    { background:linear-gradient(135deg,#fff7ed 0%,#fed7aa 100%); }

    /* ── Read time chip ──────────────────────────────────────────── */
    .rt-chip { display:inline-flex; align-items:center; gap:4px; font-size:.72rem; font-weight:500; color:#9ca3af; }

    /* ── Scrollbar hide ──────────────────────────────────────────── */
    .scrollbar-none { -ms-overflow-style:none; scrollbar-width:none; }
    .scrollbar-none::-webkit-scrollbar { display:none; }
</style>

@php
/*
 * ─────────────────────────────────────────────────────────────────
 *  TUTORIAL DATA  (replace with DB queries in future)
 * ─────────────────────────────────────────────────────────────────
 */
$tutorials = [
    [
        'id'       => 'build-saas-laravel',
        'title'    => 'Build a Full SaaS App with Laravel 13',
        'excerpt'  => 'From zero to a fully working multi-tenant SaaS product — auth, billing hooks, dashboard, and deployment covered step by step.',
        'category' => 'Web Development',
        'cat_key'  => 'webdev',
        'read_time'=> 18,
        'featured' => true,
        'level'    => 'Intermediate',
    ],
    [
        'id'       => 'tailwind-design-system',
        'title'    => 'Design a Component System with Tailwind CSS v4',
        'excerpt'  => 'Build a reusable, scalable design system using Tailwind CSS utility classes — buttons, cards, forms, and dark mode included.',
        'category' => 'Design',
        'cat_key'  => 'design',
        'read_time'=> 12,
        'featured' => false,
        'level'    => 'Beginner',
    ],
    [
        'id'       => 'alpinejs-state',
        'title'    => 'Alpine.js State Management Without a Framework',
        'excerpt'  => 'Master reactive UI patterns using only Alpine.js — modals, tabs, accordions, forms with validation, and live search.',
        'category' => 'Web Development',
        'cat_key'  => 'webdev',
        'read_time'=> 9,
        'featured' => false,
        'level'    => 'Intermediate',
    ],
    [
        'id'       => 'launch-digital-product',
        'title'    => 'How to Launch a Digital Product in 30 Days',
        'excerpt'  => 'A practical playbook for founders — from validating your idea to building an MVP, getting your first users, and pricing correctly.',
        'category' => 'Business',
        'cat_key'  => 'business',
        'read_time'=> 14,
        'featured' => false,
        'level'    => 'Beginner',
    ],
    [
        'id'       => 'figma-to-code',
        'title'    => 'From Figma Design to Production Code',
        'excerpt'  => 'How to translate a pixel-perfect Figma design into clean, responsive HTML and Tailwind CSS — with real examples from our projects.',
        'category' => 'Design',
        'cat_key'  => 'design',
        'read_time'=> 11,
        'featured' => false,
        'level'    => 'Intermediate',
    ],
    [
        'id'       => 'laravel-api',
        'title'    => 'Build a Secure REST API with Laravel Sanctum',
        'excerpt'  => 'Authentication, versioned routes, resource transformers, rate limiting, and error handling — a complete production-ready API guide.',
        'category' => 'Web Development',
        'cat_key'  => 'webdev',
        'read_time'=> 16,
        'featured' => false,
        'level'    => 'Advanced',
    ],
    [
        'id'       => 'momo-integration',
        'title'    => 'Integrate MTN MoMo & Orange Money in Laravel',
        'excerpt'  => 'Accept mobile money payments in your Laravel app using the Campay API — initiate, verify webhooks, and reconcile payments.',
        'category' => 'Tools & Resources',
        'cat_key'  => 'tools',
        'read_time'=> 10,
        'featured' => false,
        'level'    => 'Intermediate',
    ],
    [
        'id'       => 'client-pricing',
        'title'    => 'How to Price Your Tech Services as a Freelancer',
        'excerpt'  => 'Stop undercharging. A framework for pricing web projects, setting anchors, handling price objections, and increasing your rates.',
        'category' => 'Business',
        'cat_key'  => 'business',
        'read_time'=> 8,
        'featured' => false,
        'level'    => 'Beginner',
    ],
    [
        'id'       => 'git-workflow',
        'title'    => 'Git Workflow for Solo Developers & Small Teams',
        'excerpt'  => 'Branching strategy, commit conventions, pull request reviews, and deployment pipelines — the workflow we use on every project.',
        'category' => 'Tools & Resources',
        'cat_key'  => 'tools',
        'read_time'=> 7,
        'featured' => false,
        'level'    => 'Beginner',
    ],
];

$featured = collect($tutorials)->firstWhere('featured', true);
$grid     = collect($tutorials)->where('featured', false)->values();

$categories = [
    ['key'=>'webdev',   'label'=>'Web Development',   'count'=> collect($tutorials)->where('cat_key','webdev')->count(),   'color'=>'bg-blue-50 text-blue-600 border-blue-100',   'icon'=>'M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5'],
    ['key'=>'design',   'label'=>'UI/UX Design',       'count'=> collect($tutorials)->where('cat_key','design')->count(),   'color'=>'bg-purple-50 text-purple-600 border-purple-100', 'icon'=>'M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42'],
    ['key'=>'business', 'label'=>'Business Growth',    'count'=> collect($tutorials)->where('cat_key','business')->count(), 'color'=>'bg-green-50 text-green-600 border-green-100',   'icon'=>'M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941'],
    ['key'=>'tools',    'label'=>'Tools & Resources',  'count'=> collect($tutorials)->where('cat_key','tools')->count(),    'color'=>'bg-orange-50 text-orange-500 border-orange-100', 'icon'=>'M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z'],
];
@endphp

{{-- ══════════════════════════════════════════════════════════════ --}}
{{--  Alpine.js root                                               --}}
{{-- ══════════════════════════════════════════════════════════════ --}}
<div x-data="{
    activeFilter: 'All',
    search: '',
    tutorials: {{ Js::from($grid) }},

    get filtered() {
        let list = this.tutorials;
        if (this.activeFilter !== 'All') {
            const map = { 'Web Development':'webdev', 'Design':'design', 'Business':'business', 'Tools & Resources':'tools' };
            list = list.filter(t => t.cat_key === (map[this.activeFilter] ?? ''));
        }
        if (this.search.trim()) {
            const q = this.search.toLowerCase();
            list = list.filter(t => t.title.toLowerCase().includes(q) || t.excerpt.toLowerCase().includes(q));
        }
        return list;
    }
}">

{{-- ══════════════════════════════════════════════════════════════ --}}
{{--  1. HERO                                                       --}}
{{-- ══════════════════════════════════════════════════════════════ --}}
<section class="relative overflow-hidden bg-white dot-grid pt-32 pb-16">

    <div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
        <div class="absolute -top-28 -left-28 w-[540px] h-[540px] rounded-full"
             style="background:radial-gradient(circle,rgba(59,130,246,.11) 0%,transparent 68%);"></div>
        <div class="absolute top-0 right-0 w-[380px] h-[380px] rounded-full"
             style="background:radial-gradient(circle,rgba(16,185,129,.08) 0%,transparent 70%);"></div>
    </div>

    <div class="relative max-w-3xl mx-auto px-6 text-center">

        <div class="h-badge inline-flex items-center gap-2 bg-blue-50 border border-blue-100 text-blue-700 text-xs font-semibold px-4 py-1.5 rounded-full mb-6">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
            </svg>
            Tutorials & Guides
        </div>

        <h1 class="h-title text-[38px] sm:text-5xl font-extrabold text-gray-900 leading-[1.1] tracking-tight mb-5">
            Tutorials &amp; Guides
        </h1>

        <p class="h-sub text-lg text-gray-600 leading-relaxed mb-8">
            Learn, build, and grow with step-by-step tutorials from the Roddy Technologies team.
        </p>

        {{-- Search --}}
        <div class="h-srch relative max-w-xl mx-auto mb-8">
            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none"
                 fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
            </svg>
            <input type="text"
                   x-model="search"
                   placeholder="Search tutorials…"
                   class="w-full pl-12 pr-10 py-4 text-sm bg-white border border-gray-200 rounded-2xl shadow-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:border-blue-400 focus:ring-4 focus:ring-blue-50 transition">
            <template x-if="search.trim()">
                <button @click="search=''"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </template>
        </div>

        {{-- Filter tabs --}}
        <div class="h-tabs flex items-center justify-center gap-2 flex-wrap">
            @foreach(['All', 'Web Development', 'Design', 'Business', 'Tools & Resources'] as $tab)
            <button @click="activeFilter = '{{ $tab }}'"
                    :class="activeFilter === '{{ $tab }}' ? 'f-tab on' : 'f-tab'">
                {{ $tab }}
            </button>
            @endforeach
        </div>

    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════ --}}
{{--  2. FEATURED TUTORIAL                                          --}}
{{-- ══════════════════════════════════════════════════════════════ --}}
@if($featured)
<section class="py-16 bg-white" x-show="activeFilter === 'All' && !search.trim()">
    <div class="max-w-7xl mx-auto px-6">

        <div class="reveal flex items-center gap-3 mb-8">
            <span class="inline-block text-xs font-semibold text-blue-600 bg-blue-50 border border-blue-100 px-3 py-1 rounded-full">
                Featured Tutorial
            </span>
            <div class="flex-1 h-px bg-gray-100"></div>
        </div>

        <div class="feat-card group">
            <div class="grid grid-cols-1 lg:grid-cols-2">

                {{-- Thumbnail --}}
                <div class="relative h-64 lg:h-auto overflow-hidden thumb-webdev flex items-center justify-center min-h-[260px]">
                    {{-- Abstract pattern --}}
                    <div class="absolute inset-0 overflow-hidden" aria-hidden="true">
                        <div class="absolute -top-8 -right-8 w-48 h-48 rounded-3xl rotate-12 opacity-20" style="background:#1d4ed8;"></div>
                        <div class="absolute bottom-4 -left-6 w-32 h-32 rounded-2xl -rotate-6 opacity-15" style="background:#1d4ed8;"></div>
                        <div class="absolute top-1/2 right-12 w-20 h-20 rounded-full opacity-10" style="background:#1d4ed8;"></div>
                    </div>
                    {{-- Code window mockup --}}
                    <div class="relative z-10 bg-gray-900 rounded-2xl shadow-2xl w-72 overflow-hidden">
                        <div class="flex items-center gap-1.5 px-4 py-3 bg-gray-800">
                            <span class="w-3 h-3 rounded-full bg-red-400"></span>
                            <span class="w-3 h-3 rounded-full bg-yellow-400"></span>
                            <span class="w-3 h-3 rounded-full bg-green-400"></span>
                            <span class="flex-1 text-center text-[10px] text-gray-500 font-mono">SaaSController.php</span>
                        </div>
                        <div class="p-4 font-mono text-[11px] leading-relaxed">
                            <p class="text-purple-400">class <span class="text-blue-300">SaaSController</span></p>
                            <p class="text-gray-500 pl-2">extends <span class="text-yellow-300">Controller</span></p>
                            <p class="text-gray-600">{</p>
                            <p class="text-green-400 pl-4">public function <span class="text-blue-300">dashboard</span>()</p>
                            <p class="text-gray-600 pl-4">{</p>
                            <p class="text-gray-300 pl-8">return <span class="text-yellow-300">view</span>(<span class="text-green-300">'dash'</span>);</p>
                            <p class="text-gray-600 pl-4">}</p>
                            <p class="text-gray-600">}</p>
                        </div>
                    </div>
                    {{-- Level badge --}}
                    <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm text-blue-700 text-[10px] font-bold px-3 py-1.5 rounded-full shadow">
                        {{ $featured['level'] }}
                    </div>
                </div>

                {{-- Content --}}
                <div class="p-8 lg:p-12 flex flex-col justify-center">
                    <div class="flex items-center gap-3 mb-5">
                        <span class="badge-webdev text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wide">
                            {{ $featured['category'] }}
                        </span>
                        <span class="rt-chip">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $featured['read_time'] }} min read
                        </span>
                    </div>

                    <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 leading-tight mb-4">
                        {{ $featured['title'] }}
                    </h2>
                    <p class="text-gray-600 text-sm leading-relaxed mb-8">
                        {{ $featured['excerpt'] }}
                    </p>

                    <div class="flex items-center gap-3">
                        <a href="/support/knowledge-base"
                           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-7 py-3 rounded-xl shadow-md shadow-blue-200 transition-all duration-200 hover:-translate-y-0.5">
                            Start Learning
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                        <span class="text-xs text-gray-400 font-medium">Free · No sign-up</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endif

{{-- ══════════════════════════════════════════════════════════════ --}}
{{--  3. TUTORIAL GRID                                              --}}
{{-- ══════════════════════════════════════════════════════════════ --}}
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6">

        {{-- Section header --}}
        <div class="reveal flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
            <div>
                <h2 class="text-[30px] sm:text-3xl font-extrabold text-gray-900">
                    <span x-text="activeFilter === 'All' ? 'All Tutorials' : activeFilter"></span>
                </h2>
                <p class="text-gray-500 text-sm mt-1">
                    <span x-text="filtered.length"></span> tutorial<span x-show="filtered.length !== 1">s</span>
                    <span x-show="search.trim()"> matching "<span x-text="search" class="font-semibold text-gray-700"></span>"</span>
                </p>
            </div>
        </div>

        {{-- Empty state --}}
        <template x-if="filtered.length === 0">
            <div class="text-center py-20">
                <div class="w-16 h-16 bg-white border border-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm">
                    <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                    </svg>
                </div>
                <p class="font-semibold text-gray-700 mb-1">No tutorials found</p>
                <p class="text-sm text-gray-400 mb-4">Try a different search or category.</p>
                <button @click="search=''; activeFilter='All'"
                        class="text-sm text-blue-600 font-semibold hover:underline">Clear filters →</button>
            </div>
        </template>

        {{-- Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <template x-for="(tut, i) in filtered" :key="tut.id">
                <div class="tut-card reveal" :style="'transition-delay:' + (i % 3 * 80) + 'ms'">

                    {{-- Thumbnail --}}
                    <div class="relative h-44 overflow-hidden flex items-center justify-center"
                         :class="'thumb-' + tut.cat_key">
                        {{-- Decorative shapes --}}
                        <div class="absolute inset-0 overflow-hidden" aria-hidden="true">
                            <div class="absolute -top-4 -right-4 w-24 h-24 rounded-2xl rotate-12 opacity-20"
                                 :style="'background:' + {'webdev':'#1d4ed8','design':'#7c3aed','business':'#15803d','tools':'#c2410c'}[tut.cat_key]"></div>
                            <div class="absolute bottom-1 -left-3 w-16 h-16 rounded-xl -rotate-6 opacity-15"
                                 :style="'background:' + {'webdev':'#1d4ed8','design':'#7c3aed','business':'#15803d','tools':'#c2410c'}[tut.cat_key]"></div>
                        </div>
                        {{-- Icon chip --}}
                        <div class="relative z-10 w-14 h-14 bg-white rounded-2xl shadow-lg flex items-center justify-center tut-img">
                            <svg class="w-7 h-7" fill="none" stroke-width="1.5" viewBox="0 0 24 24"
                                 :stroke="{'webdev':'#1d4ed8','design':'#7c3aed','business':'#15803d','tools':'#c2410c'}[tut.cat_key]">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      :d="{'webdev':'M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5','design':'M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42','business':'M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941','tools':'M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z'}[tut.cat_key]"/>
                            </svg>
                        </div>
                        {{-- Level badge --}}
                        <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm text-gray-700 text-[9px] font-bold px-2.5 py-1 rounded-full shadow-sm"
                             x-text="tut.level"></div>
                    </div>

                    {{-- Body --}}
                    <div class="p-5 flex flex-col flex-1">
                        <div class="flex items-center gap-2 mb-2.5">
                            <span class="text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wide"
                                  :class="{'webdev':'badge-webdev','design':'badge-design','business':'badge-business','tools':'badge-tools'}[tut.cat_key]"
                                  x-text="tut.category"></span>
                            <span class="rt-chip ml-auto">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span x-text="tut.read_time + ' min'"></span>
                            </span>
                        </div>

                        <h3 class="font-bold text-gray-900 text-sm leading-snug mb-2" x-text="tut.title"></h3>
                        <p class="text-xs text-gray-500 leading-relaxed line-clamp-2 flex-1 mb-4" x-text="tut.excerpt"></p>

                        <a href="/support/knowledge-base"
                           class="inline-flex items-center gap-1.5 text-blue-600 hover:text-blue-700 text-xs font-semibold group transition mt-auto">
                            Read More
                            <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>

                </div>
            </template>
        </div>

    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════ --}}
{{--  4. CATEGORIES                                                 --}}
{{-- ══════════════════════════════════════════════════════════════ --}}
<section class="py-20 bg-white" x-show="activeFilter === 'All' && !search.trim()">
    <div class="max-w-7xl mx-auto px-6">

        <div class="reveal text-center mb-12">
            <span class="inline-block text-xs font-semibold text-blue-600 bg-blue-50 border border-blue-100 px-3 py-1 rounded-full mb-3">
                Browse by Topic
            </span>
            <h2 class="text-[30px] sm:text-4xl font-extrabold text-gray-900">Find What You Need</h2>
            <p class="text-gray-500 text-sm mt-2 max-w-md mx-auto">
                Tutorials organised by topic — pick what matches your current goal.
            </p>
        </div>

        <div class="reveal grid grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($categories as $i => $cat)
            <div class="cat-card p-6 reveal" style="transition-delay:{{ $i * 80 }}ms"
                 @click="activeFilter = '{{ $cat['label'] }}'; document.getElementById('tut-grid').scrollIntoView({behavior:'smooth'})">

                <div class="{{ $cat['color'] }} w-12 h-12 rounded-xl border flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $cat['icon'] }}"/>
                    </svg>
                </div>

                <h3 class="font-bold text-gray-900 text-sm mb-1">{{ $cat['label'] }}</h3>
                <p class="text-xs text-gray-400 font-medium">{{ $cat['count'] }} tutorial{{ $cat['count'] !== 1 ? 's' : '' }}</p>

                <div class="flex items-center gap-1 mt-4 text-blue-600 text-xs font-semibold">
                    Browse
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- scroll anchor for category click --}}
<div id="tut-grid" class="-mt-20 pt-20 pointer-events-none" aria-hidden="true"></div>

{{-- ══════════════════════════════════════════════════════════════ --}}
{{--  5. LEARNING PATH                                              --}}
{{-- ══════════════════════════════════════════════════════════════ --}}
<section class="py-20 bg-gray-50" x-show="activeFilter === 'All' && !search.trim()">
    <div class="max-w-5xl mx-auto px-6">

        <div class="reveal text-center mb-14">
            <span class="inline-block text-xs font-semibold text-green-600 bg-green-50 border border-green-100 px-3 py-1 rounded-full mb-3">
                Start Here
            </span>
            <h2 class="text-[30px] sm:text-4xl font-extrabold text-gray-900 mb-3">
                Your Learning Path
            </h2>
            <p class="text-gray-500 text-sm max-w-md mx-auto">
                Not sure where to begin? Follow this progression — from your first line of code to launching a real product.
            </p>
        </div>

        @php
        $paths = [
            [
                'step'    => '01',
                'level'   => 'Beginner',
                'title'   => 'Learn the Foundations',
                'desc'    => 'Start with the basics of web development — HTML, CSS, and how the internet works. Build your first page and understand how websites are structured.',
                'topics'  => ['HTML & CSS basics', 'How browsers work', 'Responsive layouts', 'Git & version control'],
                'cta'     => 'Start Beginner Path',
                'color'   => 'bg-blue-600',
                'light'   => 'bg-blue-50',
                'text'    => 'text-blue-600',
                'border'  => 'border-blue-100',
                'icon'    => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25',
            ],
            [
                'step'    => '02',
                'level'   => 'Intermediate',
                'title'   => 'Build Real Projects',
                'desc'    => 'Level up by building complete, functional projects — APIs, dashboards, and full-stack apps. Learn Laravel, Alpine.js, and how to connect frontend to backend.',
                'topics'  => ['Laravel framework', 'Database design', 'REST APIs', 'Alpine.js & interactivity'],
                'cta'     => 'Start Intermediate Path',
                'color'   => 'bg-purple-600',
                'light'   => 'bg-purple-50',
                'text'    => 'text-purple-600',
                'border'  => 'border-purple-100',
                'icon'    => 'M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5',
            ],
            [
                'step'    => '03',
                'level'   => 'Advanced',
                'title'   => 'Launch Your Business',
                'desc'    => 'Turn your skills into income. Learn how to price your services, find clients, build a SaaS product, and grow a sustainable tech business.',
                'topics'  => ['SaaS architecture', 'Pricing & proposals', 'Payment integration', 'Scaling & deployment'],
                'cta'     => 'Start Advanced Path',
                'color'   => 'bg-green-600',
                'light'   => 'bg-green-50',
                'text'    => 'text-green-600',
                'border'  => 'border-green-100',
                'icon'    => 'M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z',
            ],
        ];
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 relative">
            @foreach($paths as $pi => $path)
            <div class="path-card reveal" style="transition-delay:{{ $pi * 110 }}ms">

                {{-- Connector line (desktop only, not on last) --}}
                @if($pi < 2)
                <div class="hidden lg:block path-connector"></div>
                @endif

                {{-- Top accent bar --}}
                <div class="h-1.5 {{ $path['color'] }} w-full"></div>

                <div class="p-7">
                    {{-- Step number + level --}}
                    <div class="flex items-center justify-between mb-5">
                        <span class="text-[10px] font-bold {{ $path['light'] }} {{ $path['text'] }} border {{ $path['border'] }} px-2.5 py-1 rounded-full uppercase tracking-wide">
                            {{ $path['level'] }}
                        </span>
                        <span class="text-4xl font-black text-gray-100 leading-none select-none">
                            {{ $path['step'] }}
                        </span>
                    </div>

                    {{-- Icon --}}
                    <div class="{{ $path['light'] }} border {{ $path['border'] }} w-12 h-12 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 {{ $path['text'] }}" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $path['icon'] }}"/>
                        </svg>
                    </div>

                    <h3 class="text-lg font-extrabold text-gray-900 mb-2">{{ $path['title'] }}</h3>
                    <p class="text-sm text-gray-500 leading-relaxed mb-5">{{ $path['desc'] }}</p>

                    {{-- Topics --}}
                    <ul class="space-y-2 mb-7">
                        @foreach($path['topics'] as $topic)
                        <li class="flex items-center gap-2.5 text-xs text-gray-600">
                            <svg class="w-3.5 h-3.5 {{ $path['text'] }} shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                            </svg>
                            {{ $topic }}
                        </li>
                        @endforeach
                    </ul>

                    <a href="/support/knowledge-base"
                       class="inline-flex items-center gap-1.5 {{ $path['text'] }} text-xs font-bold hover:underline group">
                        {{ $path['cta'] }}
                        <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>

            </div>
            @endforeach
        </div>

        {{-- Progress indicator --}}
        <div class="reveal mt-12 flex items-center justify-center gap-3">
            @foreach(['Beginner', 'Intermediate', 'Advanced'] as $pi => $lvl)
            @if($pi > 0)
            <div class="w-12 h-px bg-gray-200"></div>
            @endif
            <div class="flex items-center gap-1.5">
                <div class="w-2 h-2 rounded-full {{ $pi === 0 ? 'bg-blue-500' : ($pi === 1 ? 'bg-purple-500' : 'bg-green-500') }}"></div>
                <span class="text-xs text-gray-400 font-medium">{{ $lvl }}</span>
            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════ --}}
{{--  6. CTA                                                        --}}
{{-- ══════════════════════════════════════════════════════════════ --}}
<section class="py-20 bg-gray-900">
    <div class="max-w-3xl mx-auto px-6 text-center">

        <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 text-white text-xs font-semibold px-4 py-1.5 rounded-full mb-6">
            <span class="w-2 h-2 rounded-full bg-green-400"></span>
            Available for new projects
        </div>

        <h2 class="text-[30px] sm:text-4xl font-extrabold text-white leading-tight mb-4">
            Want Us to Build It for You?
        </h2>
        <p class="text-gray-400 text-base leading-relaxed max-w-lg mx-auto mb-9">
            Learning is great. But if you need a production-ready product now — we can build it. Fast, clean, and exactly to spec.
        </p>

        <div class="flex flex-wrap items-center justify-center gap-4 mb-12">
            <a href="/contact"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-500 text-white font-semibold text-sm px-9 py-3.5 rounded-2xl shadow-lg shadow-blue-900/40 transition-all duration-200 hover:-translate-y-0.5">
                Start a Project
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
            <a href="/contact"
               class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white font-semibold text-sm px-9 py-3.5 rounded-2xl transition-all duration-200 hover:-translate-y-0.5">
                Contact Us
            </a>
        </div>

        <div class="flex flex-wrap items-center justify-center gap-x-8 gap-y-3 text-gray-500 text-xs">
            @foreach(['Free consultation', 'No commitment', 'MoMo & Orange Money', '30-day support'] as $p)
            <span class="flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-green-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                </svg>
                {{ $p }}
            </span>
            @endforeach
        </div>

    </div>
</section>

</div>{{-- end Alpine root --}}

<script>
(function () {
    const io = new IntersectionObserver((entries) => {
        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); io.unobserve(e.target); } });
    }, { threshold: 0.07 });
    document.querySelectorAll('.reveal').forEach(el => io.observe(el));
})();
</script>

</x-layouts.public>
