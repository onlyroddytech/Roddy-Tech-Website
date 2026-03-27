{{--
    ┌──────────────────────────────────────────────────────────────────┐
    │  PRODUCTS PAGE  —  resources/views/public/products.blade.php     │
    │                                                                  │
    │  Premium solutions showcase. NOT a marketplace.                  │
    │  Goal: build trust, demonstrate capability, drive enquiries.     │
    │                                                                  │
    │  Sections:                                                       │
    │   1. HERO              — headline + dual CTA                     │
    │   2. FEATURED          — 3 flagship solutions, case-study cards  │
    │   3. SHOWCASE GRID     — remaining solutions, 3-col clean grid   │
    │   4. HOW WE HELP       — 4 capability pillars                    │
    │   5. CTA               — dark "Start a Project" banner           │
    │                                                                  │
    │  Data: $products, $featured, $categories, $category             │
    └──────────────────────────────────────────────────────────────────┘
--}}
<x-layouts.public title="Our Products & Solutions">

<style>
    /* ── Scroll reveal ───────────────────────────────────────────── */
    .reveal {
        opacity: 0;
        transform: translateY(24px);
        transition: opacity 0.60s cubic-bezier(0.22,1,0.36,1),
                    transform 0.60s cubic-bezier(0.22,1,0.36,1);
    }
    .reveal.visible { opacity: 1; transform: translateY(0); }

    /* ── Hero entrance ───────────────────────────────────────────── */
    @keyframes heroFade {
        from { opacity: 0; transform: translateY(28px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .h-badge { animation: heroFade 0.55s cubic-bezier(0.22,1,0.36,1) 0.05s both; }
    .h-title { animation: heroFade 0.65s cubic-bezier(0.22,1,0.36,1) 0.15s both; }
    .h-sub   { animation: heroFade 0.65s cubic-bezier(0.22,1,0.36,1) 0.25s both; }
    .h-cta   { animation: heroFade 0.65s cubic-bezier(0.22,1,0.36,1) 0.35s both; }

    /* ── Dot grid ────────────────────────────────────────────────── */
    .dot-grid {
        background-image: radial-gradient(circle, #d1d5db 1px, transparent 1px);
        background-size: 28px 28px;
    }

    /* ── Featured solution cards ─────────────────────────────────── */
    .solution-card {
        background: #ffffff;
        border: 1.5px solid #e5e7eb;
        border-radius: 24px;
        overflow: hidden;
        transition: transform 0.25s cubic-bezier(0.22,1,0.36,1),
                    box-shadow 0.25s ease,
                    border-color 0.25s ease;
    }
    .solution-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 28px 70px rgba(0,0,0,0.10);
        border-color: #bfdbfe;
    }
    .solution-card:hover .sol-img { transform: scale(1.05); }
    .sol-img { transition: transform 0.50s cubic-bezier(0.22,1,0.36,1); }

    /* ── Showcase grid cards ─────────────────────────────────────── */
    .showcase-card {
        background: #ffffff;
        border: 1.5px solid #e5e7eb;
        border-radius: 20px;
        overflow: hidden;
        transition: transform 0.22s cubic-bezier(0.22,1,0.36,1),
                    box-shadow 0.22s ease,
                    border-color 0.22s ease;
    }
    .showcase-card:hover {
        transform: translateY(-7px);
        box-shadow: 0 20px 52px rgba(0,0,0,0.09);
        border-color: #bfdbfe;
    }
    .showcase-card:hover .sc-img { transform: scale(1.06); }
    .sc-img { transition: transform 0.45s cubic-bezier(0.22,1,0.36,1); }

    /* ── Capability cards ────────────────────────────────────────── */
    .cap-card {
        background: #ffffff;
        border: 1.5px solid #e5e7eb;
        border-radius: 20px;
        transition: transform 0.22s cubic-bezier(0.22,1,0.36,1),
                    box-shadow 0.22s ease;
    }
    .cap-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 44px rgba(0,0,0,0.08);
    }

    /* ── Category pill ───────────────────────────────────────────── */
    .cat-pill {
        display: inline-block;
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        padding: 4px 11px;
        border-radius: 99px;
    }
    .cat-blue   { background:#eff6ff; color:#1d4ed8; }
    .cat-green  { background:#f0fdf4; color:#15803d; }
    .cat-sky    { background:#f0f9ff; color:#0369a1; }
    .cat-purple { background:#faf5ff; color:#7c3aed; }
    .cat-orange { background:#fff7ed; color:#c2410c; }
    .cat-teal   { background:#f0fdfa; color:#0f766e; }
    .cat-gray   { background:#f3f4f6; color:#4b5563; }
</style>

{{-- ═══════════════════════════════════════════════════════════════ --}}
{{--  1. HERO                                                        --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
<section class="relative overflow-hidden bg-white dot-grid pt-32 pb-24">

    {{-- Glow orbs --}}
    <div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
        <div class="absolute -top-32 -left-32 w-[600px] h-[600px] rounded-full"
             style="background:radial-gradient(circle,rgba(59,130,246,0.12) 0%,transparent 68%);"></div>
        <div class="absolute top-0 right-0 w-[440px] h-[440px] rounded-full"
             style="background:radial-gradient(circle,rgba(16,185,129,0.09) 0%,transparent 70%);"></div>
        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[700px] h-[180px] rounded-full"
             style="background:radial-gradient(ellipse,rgba(59,130,246,0.06) 0%,transparent 70%);"></div>
    </div>

    <div class="relative max-w-4xl mx-auto px-6 text-center">

        <div class="h-badge inline-flex items-center gap-2 bg-blue-50 border border-blue-100 text-blue-700 text-xs font-semibold px-4 py-1.5 rounded-full mb-6">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
            </svg>
            Digital Products & Solutions
        </div>

        <h1 class="h-title text-[38px] sm:text-5xl lg:text-[3.5rem] font-extrabold text-gray-900 leading-[1.1] tracking-tight mb-6">
            Our Digital Products<br>
            <span class="text-blue-600">&amp; Solutions</span>
        </h1>

        <p class="h-sub max-w-2xl mx-auto text-lg text-gray-600 leading-relaxed mb-10">
            Roddy Technologies builds powerful systems, platforms, and tools that help businesses operate smarter, serve clients better, and scale with confidence.
        </p>

        <div class="h-cta flex flex-wrap items-center justify-center gap-4">
            <a href="#solutions"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-8 py-3.5 rounded-xl shadow-md shadow-blue-200 transition-all duration-200 hover:-translate-y-0.5">
                Explore Solutions
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
            </a>
            <a href="/contact"
               class="inline-flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-800 font-semibold text-sm px-8 py-3.5 rounded-xl border border-gray-200 shadow-sm transition-all duration-200 hover:-translate-y-0.5">
                Start a Project
            </a>
        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════ --}}
{{--  2. FEATURED SOLUTIONS                                          --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
@if($featured->isNotEmpty())
<section id="solutions" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6">

        {{-- Section header --}}
        <div class="reveal max-w-xl mb-16">
            <span class="inline-block text-xs font-semibold text-blue-600 bg-blue-50 border border-blue-100 px-3 py-1 rounded-full mb-3">
                Flagship Solutions
            </span>
            <h2 class="text-[30px] sm:text-4xl font-extrabold text-gray-900 leading-tight mb-3">
                Products We're Known For
            </h2>
            <p class="text-gray-500 text-sm leading-relaxed">
                Each solution is built to solve a real business problem — not just to look good, but to perform at scale.
            </p>
        </div>

        {{-- Feature bullets per product (keyed by title) --}}
        @php
        $featureMap = [
            'Rshop' => [
                'Full product catalog & inventory management',
                'MTN MoMo & Orange Money checkout built in',
                'Real-time order tracking for buyers & sellers',
            ],
            'RTG Domains' => [
                'Instant domain search across all major TLDs',
                'One-click activation with full DNS control',
                'Built for African registrars & local payment',
            ],
            'RhostitCloud' => [
                'One-click deployments with 99.9% uptime SLA',
                'Auto-scaling infrastructure for any workload',
                '24/7 monitoring, backups & security patching',
            ],
        ];

        $categoryColors = [
            'Websites'  => 'cat-blue',
            'Tools'     => 'cat-sky',
            'Scripts'   => 'cat-green',
            'UI Kits'   => 'cat-purple',
            'Templates' => 'cat-orange',
            'eCommerce' => 'cat-blue',
            'Domains'   => 'cat-teal',
            'Cloud'     => 'cat-sky',
        ];

        $mockupGradients = [
            'Websites'  => ['from' => '#eff6ff', 'to' => '#dbeafe', 'icon_color' => '#1d4ed8'],
            'Tools'     => ['from' => '#f0f9ff', 'to' => '#bae6fd', 'icon_color' => '#0369a1'],
            'Scripts'   => ['from' => '#f0fdf4', 'to' => '#bbf7d0', 'icon_color' => '#15803d'],
            'UI Kits'   => ['from' => '#faf5ff', 'to' => '#e9d5ff', 'icon_color' => '#7c3aed'],
            'Templates' => ['from' => '#fff7ed', 'to' => '#fed7aa', 'icon_color' => '#c2410c'],
            'eCommerce' => ['from' => '#eff6ff', 'to' => '#dbeafe', 'icon_color' => '#1d4ed8'],
            'Domains'   => ['from' => '#f0fdfa', 'to' => '#99f6e4', 'icon_color' => '#0f766e'],
            'Cloud'     => ['from' => '#f0f9ff', 'to' => '#bae6fd', 'icon_color' => '#0369a1'],
        ];
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @foreach($featured as $i => $product)
            @php
                $features  = $featureMap[$product->title] ?? [
                    'Built for performance and reliability',
                    'Clean, modern interface out of the box',
                    'Fully customisable to fit your workflow',
                ];
                $catClass  = $categoryColors[$product->category] ?? 'cat-gray';
                $mock      = $mockupGradients[$product->category] ?? $mockupGradients['Tools'];
            @endphp
            <div class="solution-card reveal" style="transition-delay: {{ $i * 100 }}ms">

                {{-- Mockup / image area --}}
                <div class="relative h-56 overflow-hidden flex items-center justify-center"
                     style="background: linear-gradient(135deg, {{ $mock['from'] }} 0%, {{ $mock['to'] }} 100%);">
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}"
                             alt="{{ $product->title }}"
                             class="sol-img w-full h-full object-cover">
                    @else
                        {{-- Abstract decorative mockup --}}
                        <div class="absolute inset-0 overflow-hidden" aria-hidden="true">
                            <div class="absolute -top-6 -right-6 w-40 h-40 rounded-3xl rotate-12 opacity-30"
                                 style="background:{{ $mock['icon_color'] }};"></div>
                            <div class="absolute bottom-2 -left-4 w-28 h-28 rounded-2xl -rotate-6 opacity-20"
                                 style="background:{{ $mock['icon_color'] }};"></div>
                        </div>
                        {{-- Icon chip --}}
                        <div class="relative z-10 w-20 h-20 rounded-2xl shadow-xl flex items-center justify-center"
                             style="background:#ffffff;">
                            <svg class="w-10 h-10" fill="none" stroke="{{ $mock['icon_color'] }}" stroke-width="1.5" viewBox="0 0 24 24">
                                @if(str_contains(strtolower($product->category ?? ''), 'ecommerce') || str_contains(strtolower($product->title), 'shop'))
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-1.684 2.032-3.5 2.032-5.25 0-1.657-1.343-3-3-3H7.5M7.5 14.25L5.106 5.272M7.5 14.25l-2.38 2.38m0 0A2.25 2.25 0 109.63 19.11M18.75 19.125a2.25 2.25 0 11-4.5 0"/>
                                @elseif(str_contains(strtolower($product->category ?? ''), 'domain') || str_contains(strtolower($product->title), 'domain'))
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253"/>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 14.25h13.5m-13.5 0a3 3 0 01-3-3m3 3a3 3 0 100 6h13.5a3 3 0 100-6m-16.5-3a3 3 0 013-3h13.5a3 3 0 013 3m-19.5 0a4.5 4.5 0 01.9-2.7L5.737 5.1a3.375 3.375 0 012.7-1.35h7.126c1.062 0 2.062.5 2.7 1.35l2.587 3.45a4.5 4.5 0 01.9 2.7m0 0a3 3 0 01-3 3m0 3h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008zm-3 6h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008z"/>
                                @endif
                            </svg>
                        </div>
                    @endif
                </div>

                {{-- Card body --}}
                <div class="p-7">
                    <span class="cat-pill {{ $catClass }} mb-4 block w-fit">{{ $product->category }}</span>

                    <h3 class="text-xl font-extrabold text-gray-900 mb-3 leading-snug">
                        {{ $product->title }}
                    </h3>
                    <p class="text-sm text-gray-600 leading-relaxed mb-5">
                        {{ $product->description }}
                    </p>

                    {{-- Key features --}}
                    <ul class="space-y-2 mb-7">
                        @foreach($features as $feat)
                        <li class="flex items-start gap-2.5 text-sm text-gray-700">
                            <svg class="w-4 h-4 text-green-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                            </svg>
                            {{ $feat }}
                        </li>
                        @endforeach
                    </ul>

                    <a href="{{ $product->url ?: '/contact' }}"
                       {{ $product->url && $product->url !== '#' ? 'target="_blank"' : '' }}
                       class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-semibold text-sm group">
                        View Details
                        <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>

            </div>
            @endforeach
        </div>

    </div>
</section>
@endif

{{-- ═══════════════════════════════════════════════════════════════ --}}
{{--  3. PRODUCT SHOWCASE GRID                                       --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
@php $gridProducts = $products->where('is_featured', false); @endphp
@if($gridProducts->isNotEmpty())
<section class="py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6">

        <div class="reveal flex flex-col sm:flex-row sm:items-end justify-between gap-6 mb-14">
            <div>
                <span class="inline-block text-xs font-semibold text-blue-600 bg-blue-50 border border-blue-100 px-3 py-1 rounded-full mb-3">
                    More Solutions
                </span>
                <h2 class="text-[30px] sm:text-4xl font-extrabold text-gray-900 leading-tight">
                    Explore the Full Range
                </h2>
                <p class="text-gray-500 mt-2 text-sm max-w-md">
                    Tools, kits, and systems built to the same standard — ready to power your next project.
                </p>
            </div>
            <a href="/contact"
               class="shrink-0 inline-flex items-center gap-2 border border-blue-200 text-blue-600 hover:bg-blue-600 hover:text-white font-semibold text-sm px-6 py-2.5 rounded-xl transition-all duration-200">
                Discuss a Need
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-7">
            @foreach($gridProducts as $i => $product)
            @php
                $catClass2 = $categoryColors[$product->category] ?? 'cat-gray';
                $mock2     = $mockupGradients[$product->category] ?? $mockupGradients['Tools'];
            @endphp
            <div class="showcase-card reveal" style="transition-delay: {{ ($i % 3) * 90 }}ms">

                {{-- Image / Mockup --}}
                <div class="relative h-48 overflow-hidden flex items-center justify-center"
                     style="background: linear-gradient(135deg, {{ $mock2['from'] }} 0%, {{ $mock2['to'] }} 100%);">
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}"
                             alt="{{ $product->title }}"
                             class="sc-img w-full h-full object-cover"
                             loading="lazy">
                    @else
                        <div class="absolute inset-0 overflow-hidden" aria-hidden="true">
                            <div class="absolute -top-4 -right-4 w-28 h-28 rounded-2xl rotate-12 opacity-25"
                                 style="background:{{ $mock2['icon_color'] }};"></div>
                            <div class="absolute bottom-0 -left-3 w-20 h-20 rounded-xl -rotate-6 opacity-15"
                                 style="background:{{ $mock2['icon_color'] }};"></div>
                        </div>
                        <div class="relative z-10 w-14 h-14 rounded-2xl shadow-lg flex items-center justify-center bg-white">
                            <svg class="w-7 h-7" fill="none" stroke="{{ $mock2['icon_color'] }}" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                            </svg>
                        </div>
                    @endif
                </div>

                {{-- Body --}}
                <div class="p-6">
                    <span class="cat-pill {{ $catClass2 }} mb-3 block w-fit">{{ $product->category }}</span>
                    <h3 class="font-bold text-gray-900 text-base mb-2 leading-snug">{{ $product->title }}</h3>
                    <p class="text-sm text-gray-500 leading-relaxed mb-5 line-clamp-2">{{ $product->description }}</p>
                    <a href="{{ $product->url ?: '/contact' }}"
                       {{ $product->url && $product->url !== '#' ? 'target="_blank"' : '' }}
                       class="inline-flex items-center gap-1.5 text-blue-600 hover:text-blue-700 text-sm font-semibold group">
                        Learn More
                        <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>

            </div>
            @endforeach
        </div>

    </div>
</section>
@endif

{{-- ═══════════════════════════════════════════════════════════════ --}}
{{--  4. HOW OUR PRODUCTS HELP                                       --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6">

        <div class="reveal text-center max-w-2xl mx-auto mb-16">
            <span class="inline-block text-xs font-semibold text-blue-600 bg-blue-50 border border-blue-100 px-3 py-1 rounded-full mb-3">
                Our Approach
            </span>
            <h2 class="text-[30px] sm:text-4xl font-extrabold text-gray-900 mb-3">
                How Our Products Help Your Business
            </h2>
            <p class="text-gray-500 text-sm leading-relaxed">
                Every product we build is grounded in the same principles: clarity of purpose, quality of execution, and long-term reliability.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            {{-- Scalable Systems --}}
            <div class="cap-card reveal p-7" style="transition-delay:0ms">
                <div class="w-13 h-13 w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6"/>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 text-base mb-2">Scalable Systems</h3>
                <p class="text-gray-500 text-sm leading-relaxed">
                    Architected to grow with you. Whether you have 10 users or 100,000, our products handle the load without requiring a rebuild.
                </p>
            </div>

            {{-- Custom-Built Solutions --}}
            <div class="cap-card reveal p-7" style="transition-delay:80ms">
                <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 text-base mb-2">Custom-Built Solutions</h3>
                <p class="text-gray-500 text-sm leading-relaxed">
                    No generic templates or off-the-shelf workarounds. Each system is engineered around your specific business logic and user needs.
                </p>
            </div>

            {{-- High Performance --}}
            <div class="cap-card reveal p-7" style="transition-delay:160ms">
                <div class="w-12 h-12 rounded-xl bg-sky-50 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 text-base mb-2">High Performance</h3>
                <p class="text-gray-500 text-sm leading-relaxed">
                    Optimised at every layer — from database queries to front-end rendering. Fast products don't just feel better, they convert better.
                </p>
            </div>

            {{-- Modern UI/UX --}}
            <div class="cap-card reveal p-7" style="transition-delay:240ms">
                <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center mb-5">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 text-base mb-2">Modern UI/UX</h3>
                <p class="text-gray-500 text-sm leading-relaxed">
                    Interfaces that are intuitive from the first click. We obsess over usability so your users never have to think twice.
                </p>
            </div>

        </div>

        {{-- Divider row with trust signals --}}
        <div class="reveal mt-16 grid grid-cols-2 sm:grid-cols-4 gap-4">
            @foreach([
                ['value' => '50+',  'label' => 'Clients served'],
                ['value' => '30+',  'label' => 'Solutions shipped'],
                ['value' => '99.9%','label' => 'Uptime SLA'],
                ['value' => '5★',   'label' => 'Client satisfaction'],
            ] as $stat)
            <div class="text-center bg-gray-50 border border-gray-100 rounded-2xl py-6 px-4">
                <div class="text-2xl sm:text-3xl font-extrabold text-gray-900 mb-1">{{ $stat['value'] }}</div>
                <div class="text-xs text-gray-400 font-medium">{{ $stat['label'] }}</div>
            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════ --}}
{{--  5. CTA SECTION                                                 --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
<section class="py-24 bg-gray-900">
    <div class="max-w-4xl mx-auto px-6 text-center reveal">

        <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 text-white text-xs font-semibold px-4 py-1.5 rounded-full mb-7">
            <span class="w-2 h-2 rounded-full bg-green-400"></span>
            Available for new projects
        </div>

        <h2 class="text-[30px] sm:text-4xl lg:text-[2.8rem] font-extrabold text-white leading-tight mb-5">
            Need a Custom Solution<br class="hidden sm:block"> Tailored to Your Business?
        </h2>

        <p class="text-gray-400 text-base leading-relaxed max-w-xl mx-auto mb-10">
            Every great product starts with a conversation. Tell us what you need — we'll tell you exactly how we can build it, what it will take, and how long it will run.
        </p>

        <div class="flex flex-wrap items-center justify-center gap-4 mb-14">
            <a href="/contact"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-500 text-white font-semibold text-sm px-9 py-3.5 rounded-xl shadow-lg shadow-blue-900/40 transition-all duration-200 hover:-translate-y-0.5">
                Start a Project
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
            <a href="/contact"
               class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white font-semibold text-sm px-9 py-3.5 rounded-xl transition-all duration-200 hover:-translate-y-0.5">
                Contact Us
            </a>
        </div>

        {{-- Trust points --}}
        <div class="flex flex-wrap items-center justify-center gap-x-8 gap-y-3 text-gray-500 text-xs">
            @foreach([
                'Free initial consultation',
                'No commitment required',
                '30-day post-launch support',
                'MoMo & Orange Money accepted',
            ] as $point)
            <span class="flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-green-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                </svg>
                {{ $point }}
            </span>
            @endforeach
        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════ --}}
{{--  SCROLL REVEAL                                                  --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
<script>
(function () {
    const io = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
                io.unobserve(e.target);
            }
        });
    }, { threshold: 0.08 });
    document.querySelectorAll('.reveal').forEach(el => io.observe(el));
})();
</script>

</x-layouts.public>
