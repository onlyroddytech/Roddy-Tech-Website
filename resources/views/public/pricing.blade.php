{{--
    ┌──────────────────────────────────────────────────────────────────┐
    │  PRICING PAGE  —  resources/views/public/pricing.blade.php       │
    │                                                                  │
    │  Sections:                                                       │
    │   1. HERO             — headline + trust line + billing toggle   │
    │   2. PRICING CARDS    — 3 dynamic DB-driven plan cards           │
    │   3. COMPARISON TABLE — feature matrix across all plans          │
    │   4. PROCESS          — 4-step horizontal timeline               │
    │   5. FAQ              — accordion from DB (pricing category)     │
    │   6. CTA              — dark "Start Your Project" banner         │
    │                                                                  │
    │  Data: $items (PricingItem collection), $faqs (Faq collection)  │
    └──────────────────────────────────────────────────────────────────┘
--}}
<x-layouts.public title="Pricing">

<style>
    /* ── Scroll reveal ───────────────────────────────────────────── */
    .reveal {
        opacity: 0;
        transform: translateY(22px);
        transition: opacity 0.60s cubic-bezier(0.22,1,0.36,1),
                    transform 0.60s cubic-bezier(0.22,1,0.36,1);
    }
    .reveal.visible { opacity: 1; transform: translateY(0); }

    /* ── Hero entrance ───────────────────────────────────────────── */
    @keyframes heroFade {
        from { opacity:0; transform:translateY(28px); }
        to   { opacity:1; transform:translateY(0); }
    }
    .h-badge { animation: heroFade .55s cubic-bezier(.22,1,.36,1) .05s both; }
    .h-title { animation: heroFade .65s cubic-bezier(.22,1,.36,1) .14s both; }
    .h-sub   { animation: heroFade .65s cubic-bezier(.22,1,.36,1) .23s both; }
    .h-trust { animation: heroFade .65s cubic-bezier(.22,1,.36,1) .32s both; }

    /* ── Dot grid ────────────────────────────────────────────────── */
    .dot-grid {
        background-image: radial-gradient(circle, #d1d5db 1px, transparent 1px);
        background-size: 28px 28px;
    }

    /* ── Pricing card ────────────────────────────────────────────── */
    .plan-card {
        background: #ffffff;
        border: 1.5px solid #e5e7eb;
        border-radius: 24px;
        transition: transform .25s cubic-bezier(.22,1,.36,1),
                    box-shadow .25s ease;
    }
    .plan-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 28px 65px rgba(0,0,0,.10);
    }

    /* ── Featured plan card ──────────────────────────────────────── */
    .plan-card-featured {
        background: #ffffff;
        border: 2px solid #2563eb;
        border-radius: 24px;
        box-shadow: 0 0 0 4px rgba(37,99,235,.08),
                    0 20px 60px rgba(37,99,235,.14);
        position: relative;
        transform: scale(1.03);
        transition: transform .25s cubic-bezier(.22,1,.36,1),
                    box-shadow .25s ease;
    }
    .plan-card-featured:hover {
        transform: scale(1.03) translateY(-8px);
        box-shadow: 0 0 0 4px rgba(37,99,235,.12),
                    0 36px 80px rgba(37,99,235,.18);
    }

    /* ── Feature tick ────────────────────────────────────────────── */
    .tick-yes { color: #16a34a; }
    .tick-no  { color: #d1d5db; }

    /* ── Comparison table ────────────────────────────────────────── */
    .cmp-table thead th { font-size:.75rem; font-weight:700; text-transform:uppercase; letter-spacing:.05em; }
    .cmp-table tbody tr { border-top: 1px solid #f3f4f6; }
    .cmp-table tbody tr:hover { background: #fafafa; }
    .cmp-group { background: #f8fafc; font-size:.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:#94a3b8; }

    /* ── Process steps ───────────────────────────────────────────── */
    .step-line {
        position: absolute;
        top: 22px;
        left: calc(50% + 28px);
        right: calc(-50% + 28px);
        height: 2px;
        background: linear-gradient(90deg, #bfdbfe, #bbf7d0);
    }

    /* ── FAQ accordion ───────────────────────────────────────────── */
    .faq-body {
        display: grid;
        grid-template-rows: 0fr;
        transition: grid-template-rows 0.35s cubic-bezier(.22,1,.36,1);
    }
    .faq-body.open { grid-template-rows: 1fr; }
    .faq-body > div { overflow: hidden; }

    /* ── CTA button ──────────────────────────────────────────────── */
    .btn-primary {
        display: inline-flex; align-items: center; gap: 8px;
        background: #2563eb; color: #fff;
        font-weight: 600; font-size: .875rem;
        padding: 13px 28px; border-radius: 14px;
        box-shadow: 0 4px 16px rgba(37,99,235,.30);
        transition: background .18s, transform .18s, box-shadow .18s;
        text-decoration: none;
    }
    .btn-primary:hover { background:#1d4ed8; transform:translateY(-2px); box-shadow:0 8px 24px rgba(37,99,235,.35); }

    .btn-secondary {
        display: inline-flex; align-items: center; gap: 8px;
        background: #fff; color: #374151;
        font-weight: 600; font-size: .875rem;
        padding: 13px 28px; border-radius: 14px;
        border: 1.5px solid #e5e7eb;
        box-shadow: 0 2px 8px rgba(0,0,0,.05);
        transition: background .18s, transform .18s, border-color .18s;
        text-decoration: none;
    }
    .btn-secondary:hover { background:#f9fafb; transform:translateY(-2px); border-color:#d1d5db; }
</style>

{{-- ═══════════════════════════════════════════════════════════════ --}}
{{--  1. HERO                                                        --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
<section class="relative overflow-hidden bg-white dot-grid pt-32 pb-20">

    {{-- Glow orbs --}}
    <div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
        <div class="absolute -top-32 -left-24 w-[580px] h-[580px] rounded-full"
             style="background:radial-gradient(circle,rgba(59,130,246,.11) 0%,transparent 68%);"></div>
        <div class="absolute top-0 right-0 w-[420px] h-[420px] rounded-full"
             style="background:radial-gradient(circle,rgba(16,185,129,.08) 0%,transparent 70%);"></div>
    </div>

    <div class="relative max-w-3xl mx-auto px-6 text-center">

        <div class="h-badge inline-flex items-center gap-2 bg-blue-50 border border-blue-100 text-blue-700 text-xs font-semibold px-4 py-1.5 rounded-full mb-6">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33"/>
            </svg>
            Transparent Pricing
        </div>

        <h1 class="h-title text-[38px] sm:text-5xl lg:text-[3.4rem] font-extrabold text-gray-900 leading-[1.1] tracking-tight mb-5">
            Simple, Transparent<br>
            <span class="text-blue-600">Pricing</span>
        </h1>

        <p class="h-sub text-lg text-gray-600 leading-relaxed mb-4">
            Choose a plan that fits your business needs.<br class="hidden sm:block"> No hidden fees. No surprises.
        </p>

        <p class="h-trust text-sm text-gray-400 font-medium">
            Built for startups, creators, and growing businesses
        </p>

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════ --}}
{{--  2. PRICING CARDS                                              --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
<section class="py-8 pb-24 bg-white" id="plans">
    <div class="max-w-6xl mx-auto px-6">

        @php
        // Accent colours per sort_order position
        $accents = [
            1 => ['dot'=>'bg-green-500',  'btn_bg'=>'bg-gray-900 hover:bg-gray-700',    'btn_text'=>'text-white', 'tag_bg'=>'bg-green-50',  'tag_text'=>'text-green-700',  'icon_bg'=>'bg-green-50',  'icon_color'=>'text-green-600'],
            2 => ['dot'=>'bg-blue-500',   'btn_bg'=>'bg-blue-600 hover:bg-blue-700',    'btn_text'=>'text-white', 'tag_bg'=>'bg-blue-50',   'tag_text'=>'text-blue-700',   'icon_bg'=>'bg-blue-50',   'icon_color'=>'text-blue-600'],
            3 => ['dot'=>'bg-purple-500', 'btn_bg'=>'bg-gray-900 hover:bg-gray-700',    'btn_text'=>'text-white', 'tag_bg'=>'bg-purple-50', 'tag_text'=>'text-purple-700', 'icon_bg'=>'bg-purple-50', 'icon_color'=>'text-purple-600'],
        ];
        $btnLabels = [1=>'Get Started', 2=>'Choose Business', 3=>'Go Premium'];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-stretch">
            @foreach($items as $i => $item)
            @php
                $pos = $item->sort_order;
                $a   = $accents[$pos] ?? $accents[1];
                $lbl = $btnLabels[$pos] ?? 'Get Started';
                $features = is_array($item->features) ? $item->features : json_decode($item->features ?? '[]', true);
            @endphp

            <div class="reveal {{ $item->is_featured ? '' : 'md:mt-4' }}"
                 style="transition-delay:{{ $i*100 }}ms">

                <div class="{{ $item->is_featured ? 'plan-card-featured' : 'plan-card' }} h-full flex flex-col p-8">

                    {{-- Most Popular badge (featured only) --}}
                    @if($item->is_featured)
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2">
                        <span class="inline-flex items-center gap-1.5 bg-blue-600 text-white text-xs font-bold px-4 py-1.5 rounded-full shadow-lg shadow-blue-200">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            Most Popular
                        </span>
                    </div>
                    @endif

                    {{-- Plan tag --}}
                    <div class="flex items-center gap-2 mb-5 {{ $item->is_featured ? 'mt-2' : '' }}">
                        <span class="w-2.5 h-2.5 rounded-full {{ $a['dot'] }}"></span>
                        <span class="{{ $a['tag_bg'] }} {{ $a['tag_text'] }} text-xs font-semibold px-2.5 py-0.5 rounded-full">
                            @if($pos===1) Perfect for small businesses
                            @elseif($pos===2) Most Popular
                            @else Advanced &amp; Custom
                            @endif
                        </span>
                    </div>

                    {{-- Plan name --}}
                    <h3 class="text-xl font-extrabold text-gray-900 mb-1">{{ $item->title }}</h3>
                    @if($item->description)
                    <p class="text-sm text-gray-500 leading-relaxed mb-6">{{ $item->description }}</p>
                    @endif

                    {{-- Price --}}
                    <div class="mb-7">
                        <div class="flex items-baseline gap-1.5">
                            <span class="text-[2.6rem] font-extrabold tracking-tight text-gray-900 leading-none">
                                {{ number_format((float)$item->price, 0, '.', ',') }}
                            </span>
                            <span class="text-base font-semibold text-gray-400">{{ $item->currency }}</span>
                            @if($pos===3)<span class="text-sm text-gray-400 font-medium">+</span>@endif
                        </div>
                        <p class="text-xs text-gray-400 mt-1 font-medium">{{ $item->unit ?? 'one-time' }}</p>
                    </div>

                    {{-- Divider --}}
                    <div class="border-t border-gray-100 mb-6"></div>

                    {{-- Features list --}}
                    <ul class="space-y-3 flex-1 mb-8">
                        @foreach($features as $feat)
                        @php $isInherited = str_starts_with($feat, 'Everything in'); @endphp
                        <li class="flex items-start gap-3 text-sm {{ $isInherited ? 'text-blue-600 font-semibold' : 'text-gray-700' }}">
                            @if($isInherited)
                            <svg class="w-4 h-4 mt-0.5 shrink-0 text-blue-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                            @else
                            <svg class="w-4 h-4 mt-0.5 shrink-0 text-green-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                            </svg>
                            @endif
                            {{ $feat }}
                        </li>
                        @endforeach
                    </ul>

                    {{-- CTA --}}
                    <a href="/contact?plan={{ urlencode($item->title) }}"
                       class="w-full inline-flex items-center justify-center gap-2 {{ $a['btn_bg'] }} {{ $a['btn_text'] }} font-semibold text-sm py-3.5 rounded-2xl transition-all duration-200 shadow-sm hover:shadow-lg mt-auto">
                        {{ $lbl }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>

                </div>
            </div>
            @endforeach
        </div>

        {{-- Money-back note --}}
        <p class="text-center text-xs text-gray-400 mt-10">
            All prices in XAF (CFA Franc) · 50% upfront, 50% on delivery · Payments via MTN MoMo, Orange Money, or bank transfer
        </p>

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════ --}}
{{--  3. COMPARISON TABLE                                           --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
<section class="py-20 bg-gray-50">
    <div class="max-w-5xl mx-auto px-6">

        <div class="reveal text-center mb-14">
            <span class="inline-block text-xs font-semibold text-blue-600 bg-blue-50 border border-blue-100 px-3 py-1 rounded-full mb-3">Compare Plans</span>
            <h2 class="text-[30px] sm:text-4xl font-extrabold text-gray-900">Everything Side by Side</h2>
        </div>

        <div class="reveal bg-white border border-gray-200 rounded-3xl overflow-hidden shadow-sm">
            <table class="cmp-table w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-left px-6 py-4 text-gray-400 font-semibold w-1/2">Feature</th>
                        @foreach($items as $item)
                        <th class="px-4 py-4 text-center {{ $item->is_featured ? 'text-blue-600' : 'text-gray-700' }}">
                            {{ $item->title }}
                            @if($item->is_featured)
                            <span class="block text-[10px] text-blue-400 font-medium normal-case tracking-normal mt-0.5">Most Popular</span>
                            @endif
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>

                    {{-- DESIGN --}}
                    <tr class="cmp-group"><td colspan="4" class="px-6 py-2.5">Design</td></tr>
                    @foreach([
                        'Professional website design',
                        'Mobile responsive layout',
                        'Premium UI/UX design',
                        'Custom brand integration',
                    ] as $j => $feat)
                    <tr>
                        <td class="px-6 py-3.5 text-gray-700">{{ $feat }}</td>
                        @foreach($items as $item)
                        @php $has = $item->sort_order >= ($j < 2 ? 1 : ($j < 3 ? 2 : 3)); @endphp
                        <td class="px-4 py-3.5 text-center">
                            @if($has)
                            <svg class="w-5 h-5 tick-yes mx-auto" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                            </svg>
                            @else
                            <svg class="w-4 h-4 tick-no mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            @endif
                        </td>
                        @endforeach
                    </tr>
                    @endforeach

                    {{-- FEATURES --}}
                    <tr class="cmp-group"><td colspan="4" class="px-6 py-2.5">Features</td></tr>
                    @foreach([
                        ['Contact form & email setup', 1],
                        ['Multi-page website (up to 8)', 2],
                        ['Live chat integration',       2],
                        ['Google Maps integration',     2],
                        ['Blog or news section',        2],
                        ['Admin dashboard',             3],
                        ['Payment integration',         3],
                        ['Custom systems & features',   3],
                    ] as [$feat, $from])
                    <tr>
                        <td class="px-6 py-3.5 text-gray-700">{{ $feat }}</td>
                        @foreach($items as $item)
                        @php $has = $item->sort_order >= $from; @endphp
                        <td class="px-4 py-3.5 text-center">
                            @if($has)
                            <svg class="w-5 h-5 tick-yes mx-auto" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                            </svg>
                            @else
                            <svg class="w-4 h-4 tick-no mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            @endif
                        </td>
                        @endforeach
                    </tr>
                    @endforeach

                    {{-- SUPPORT --}}
                    <tr class="cmp-group"><td colspan="4" class="px-6 py-2.5">Support</td></tr>
                    @foreach([
                        ['1 month support',        1, 1],
                        ['6 months maintenance',   2, 2],
                        ['Priority service & SLA', 3, 3],
                    ] as [$feat, $from, $exact])
                    <tr>
                        <td class="px-6 py-3.5 text-gray-700">{{ $feat }}</td>
                        @foreach($items as $item)
                        @php $has = $item->sort_order === $exact || ($exact < 3 && $item->sort_order > $exact); @endphp
                        <td class="px-4 py-3.5 text-center">
                            @if($has)
                            <svg class="w-5 h-5 tick-yes mx-auto" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                            </svg>
                            @else
                            <svg class="w-4 h-4 tick-no mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            @endif
                        </td>
                        @endforeach
                    </tr>
                    @endforeach

                    {{-- CTA row --}}
                    <tr class="border-t border-gray-100 bg-gray-50/60">
                        <td class="px-6 py-5"></td>
                        @foreach($items as $item)
                        <td class="px-4 py-5 text-center">
                            <a href="/contact?plan={{ urlencode($item->title) }}"
                               class="{{ $item->is_featured ? 'bg-blue-600 hover:bg-blue-700 text-white shadow-md shadow-blue-200' : 'bg-gray-900 hover:bg-gray-700 text-white' }} text-xs font-semibold px-5 py-2.5 rounded-xl transition-all duration-200 inline-block">
                                Choose {{ $item->title }}
                            </a>
                        </td>
                        @endforeach
                    </tr>

                </tbody>
            </table>
        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════ --}}
{{--  4. HOW IT WORKS                                               --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
<section class="py-20 bg-white">
    <div class="max-w-5xl mx-auto px-6">

        <div class="reveal text-center mb-16">
            <span class="inline-block text-xs font-semibold text-blue-600 bg-blue-50 border border-blue-100 px-3 py-1 rounded-full mb-3">Process</span>
            <h2 class="text-[30px] sm:text-4xl font-extrabold text-gray-900">How It Works</h2>
            <p class="text-gray-500 text-sm mt-2 max-w-md mx-auto">From choosing your plan to launching your product — four simple steps.</p>
        </div>

        @php
        $steps = [
            ['num'=>'01','icon'=>'M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V19.5a2.25 2.25 0 002.25 2.25h.75',
             'title'=>'Choose a Plan','desc'=>'Browse our plans and select the one that matches your goals and budget.','color'=>'bg-blue-50 text-blue-600','border'=>'border-blue-100'],
            ['num'=>'02','icon'=>'M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155',
             'title'=>'We Discuss','desc'=>'We jump on a discovery call to understand your project, timeline, and specific requirements.','color'=>'bg-green-50 text-green-600','border'=>'border-green-100'],
            ['num'=>'03','icon'=>'M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5',
             'title'=>'We Design & Build','desc'=>'Our team designs, develops, and tests your project with regular updates and milestone reviews.','color'=>'bg-purple-50 text-purple-600','border'=>'border-purple-100'],
            ['num'=>'04','icon'=>'M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z',
             'title'=>'You Launch 🚀','desc'=>'We deploy your project, hand over all assets, and provide onboarding support for a smooth launch.','color'=>'bg-orange-50 text-orange-500','border'=>'border-orange-100'],
        ];
        @endphp

        <div class="relative grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($steps as $si => $step)
            <div class="reveal text-center relative" style="transition-delay:{{ $si*90 }}ms">

                {{-- Connector line (desktop only, not on last) --}}
                @if($si < 3)
                <div class="hidden lg:block absolute top-8 left-[calc(50%+32px)] right-[calc(-50%+32px)] h-px"
                     style="background:linear-gradient(90deg,#bfdbfe,#bbf7d0);"></div>
                @endif

                {{-- Step icon chip --}}
                <div class="relative z-10 w-16 h-16 {{ $step['color'] }} border {{ $step['border'] }} rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $step['icon'] }}"/>
                    </svg>
                    <span class="absolute -top-2 -right-2 w-6 h-6 bg-gray-900 text-white text-[10px] font-bold rounded-full flex items-center justify-center">
                        {{ $si + 1 }}
                    </span>
                </div>

                <h3 class="font-bold text-gray-900 text-base mb-1.5">{{ $step['title'] }}</h3>
                <p class="text-xs text-gray-500 leading-relaxed">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════ --}}
{{--  5. FAQ                                                        --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
@if($faqs->isNotEmpty())
<section class="py-20 bg-gray-50">
    <div class="max-w-3xl mx-auto px-6">

        <div class="reveal text-center mb-14">
            <span class="inline-block text-xs font-semibold text-blue-600 bg-blue-50 border border-blue-100 px-3 py-1 rounded-full mb-3">FAQ</span>
            <h2 class="text-[30px] sm:text-4xl font-extrabold text-gray-900">Common Questions</h2>
            <p class="text-gray-500 text-sm mt-2">Everything you need to know before getting started.</p>
        </div>

        <div class="reveal space-y-3" x-data="{ open: null }">
            @foreach($faqs as $fi => $faq)
            <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm hover:border-blue-100 transition-colors">

                {{-- Question --}}
                <button type="button"
                        @click="open = open === {{ $fi }} ? null : {{ $fi }}"
                        class="w-full flex items-center justify-between gap-4 px-6 py-5 text-left">
                    <span class="font-semibold text-gray-900 text-sm leading-snug pr-4">{{ $faq->question }}</span>
                    <span class="shrink-0 w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center transition-transform duration-300"
                          :class="open === {{ $fi }} ? 'rotate-45 bg-blue-600 border-blue-600' : 'bg-white'">
                        <svg class="w-4 h-4 transition-colors duration-200"
                             :class="open === {{ $fi }} ? 'text-white' : 'text-gray-500'"
                             fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                    </span>
                </button>

                {{-- Answer --}}
                <div x-show="open === {{ $fi }}"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="px-6 pb-5">
                    <div class="border-t border-gray-100 pt-4">
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $faq->answer }}</p>
                    </div>
                </div>

            </div>
            @endforeach
        </div>

        <div class="reveal mt-10 text-center">
            <p class="text-sm text-gray-500">
                Still have questions?
                <a href="/contact" class="text-blue-600 font-semibold hover:underline">Talk to us →</a>
            </p>
        </div>

    </div>
</section>
@endif

{{-- ═══════════════════════════════════════════════════════════════ --}}
{{--  6. CTA                                                        --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
<section class="py-24 bg-gray-900">
    <div class="max-w-3xl mx-auto px-6 text-center reveal">

        <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 text-white text-xs font-semibold px-4 py-1.5 rounded-full mb-7">
            <span class="w-2 h-2 rounded-full bg-green-400"></span>
            Taking on new projects
        </div>

        <h2 class="text-[30px] sm:text-4xl lg:text-[2.8rem] font-extrabold text-white leading-tight mb-4">
            Ready to Build<br>Something Great?
        </h2>

        <p class="text-gray-400 text-base leading-relaxed max-w-lg mx-auto mb-10">
            Let's bring your idea to life. Pick a plan, reach out, and we'll handle the rest — from design to deployment.
        </p>

        <div class="flex flex-wrap items-center justify-center gap-4 mb-12">
            <a href="/contact"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-500 text-white font-semibold text-sm px-9 py-3.5 rounded-2xl shadow-lg shadow-blue-900/40 transition-all duration-200 hover:-translate-y-0.5">
                Start Your Project
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
            @foreach(['No hidden fees','50% upfront only','MTN MoMo accepted','30-day post-launch support'] as $p)
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

{{-- Scroll reveal --}}
<script>
(function () {
    const io = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) { e.target.classList.add('visible'); io.unobserve(e.target); }
        });
    }, { threshold: 0.08 });
    document.querySelectorAll('.reveal').forEach(el => io.observe(el));
})();
</script>

</x-layouts.public>
