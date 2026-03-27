{{--
    ┌──────────────────────────────────────────────────────────────────┐
    │  ABOUT PAGE  —  resources/views/public/about.blade.php           │
    │                                                                  │
    │  Design rules:                                                   │
    │   - NO background gradients anywhere                             │
    │   - Plain solid backgrounds: white / #f8f9fa / #0f172a (dark)   │
    │   - Brand colours: #2563eb (blue) · #059669 (green) · #0f172a   │
    │   - All prose text constrained to max-w-[600px]                 │
    │   - Mobile-first responsive: 1 col → tablet 2 col → desk 3+ col │
    │   - Scroll reveal via IntersectionObserver (no JS lib)           │
    └──────────────────────────────────────────────────────────────────┘
--}}
<x-layouts.public title="About Us">

<style>
/* ── Entrance animations ──────────────────────────────────────── */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(24px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes spinSlow {
    from { transform: rotate(0deg); }
    to   { transform: rotate(360deg); }
}
@keyframes floatY {
    0%, 100% { transform: translateY(0); }
    50%       { transform: translateY(-10px); }
}
@keyframes ringPulse {
    0%,100% { box-shadow: 0 0 0 0   rgba(37,99,235,0.35); }
    50%      { box-shadow: 0 0 0 10px rgba(37,99,235,0);   }
}

/* Scroll reveal */
.reveal {
    opacity: 0;
    transform: translateY(22px);
    transition: opacity 0.65s ease, transform 0.65s ease;
}
.reveal.visible { opacity: 1; transform: translateY(0); }

/* Stagger helpers */
.anim-fade-up          { animation: fadeUp 0.75s cubic-bezier(.22,1,.36,1) both; }
.anim-delay-1          { animation-delay: .1s; }
.anim-delay-2          { animation-delay: .22s; }
.anim-delay-3          { animation-delay: .34s; }

/* Card hover lift */
.lift-card {
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    will-change: transform, box-shadow;
    transition: transform 0.18s cubic-bezier(0.22,1,0.36,1),
                box-shadow 0.18s cubic-bezier(0.22,1,0.36,1),
                border-color 0.18s ease;
}
.lift-card:hover {
    transform: translateY(-6px) scale(1.02);
    box-shadow: 0 20px 48px rgba(0,0,0,0.10);
    border-color: #bfdbfe;
}

/* Ecosystem card (dark section) */
.eco-card {
    will-change: transform;
    transition: transform 0.18s cubic-bezier(0.22,1,0.36,1),
                background 0.18s ease,
                border-color 0.18s ease;
}
.eco-card:hover {
    transform: translateY(-6px) scale(1.02);
    background: rgba(255,255,255,0.1) !important;
    border-color: rgba(255,255,255,0.18);
}

/* Feature row */
.feature-row {
    border-radius: 1rem;
    transition: background 0.18s cubic-bezier(0.22,1,0.36,1),
                transform 0.18s cubic-bezier(0.22,1,0.36,1);
}
.feature-row:hover {
    background: #f0f7ff;
    transform: translateX(5px);
}

/* Founder ring pulse */
.founder-ring { animation: ringPulse 3s ease-in-out infinite; }

/* Primary button — solid blue, no gradient */
.btn-primary {
    background: #2563eb;
    transition: background 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
}
.btn-primary:hover {
    background: #1d4ed8;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(37,99,235,0.3);
}
.btn-primary:active { transform: scale(0.97); }

/* Ghost button */
.btn-ghost {
    transition: background 0.2s ease, transform 0.2s ease;
}
.btn-ghost:hover {
    background: rgba(255,255,255,0.12);
    transform: translateY(-2px);
}

/* Accent underline on hover links */
.link-arrow {
    transition: gap 0.2s ease, color 0.2s ease;
}
.link-arrow:hover { color: #1d4ed8; }
</style>


{{-- ═══════════════════════════════════════════════════════════════
     1. HERO  — plain dark bg, no orbs, no gradient text
════════════════════════════════════════════════════════════════ --}}
<section class="relative bg-white overflow-hidden pt-32 pb-24 px-4 sm:px-6">

    {{-- Dot grid --}}
    <div class="absolute inset-0 pointer-events-none"
         style="background-image: radial-gradient(circle, rgba(0,0,0,0.07) 1.5px, transparent 1.5px); background-size: 30px 30px;"></div>

    {{-- Blue glow top-right --}}
    <div class="absolute top-0 right-0 w-[600px] h-[500px] pointer-events-none"
         style="background: radial-gradient(ellipse at top right, rgba(37,99,235,0.07) 0%, transparent 65%);"></div>

    {{-- Green glow bottom-left --}}
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] pointer-events-none"
         style="background: radial-gradient(ellipse at bottom left, rgba(16,185,129,0.06) 0%, transparent 65%);"></div>

    <div class="relative max-w-7xl mx-auto text-center">

        {{-- Badge --}}
        <div class="anim-fade-up inline-flex items-center gap-2 mb-7 px-4 py-2 rounded-full bg-blue-50 border border-blue-100">
            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
            <span class="text-xs font-semibold text-blue-700 uppercase tracking-widest">Who We Are</span>
        </div>

        {{-- Headline --}}
        <h1 class="anim-fade-up anim-delay-1
                   text-[2.6rem] sm:text-5xl lg:text-6xl
                   font-black tracking-tight text-gray-900 leading-[1.08]
                   max-w-[720px] mx-auto mb-6">
            We Build Digital Products<br class="hidden sm:block">
            <span class="bg-gradient-to-r from-blue-600 to-emerald-500 bg-clip-text text-transparent">
                That Scale Globally
            </span>
        </h1>

        {{-- Subtext --}}
        <p class="anim-fade-up anim-delay-2
                  text-base sm:text-lg text-gray-500 leading-relaxed
                  max-w-[600px] mx-auto mb-10">
            Roddy Technologies is a premier African technology company that designs, builds,
            and deploys world-class digital solutions from custom software to our own
            ecosystem of platforms.
        </p>

        {{-- Divider --}}
        <div class="anim-fade-up anim-delay-3 flex items-center justify-center gap-3">
            <span class="w-8 h-px bg-blue-300"></span>
            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
            <span class="w-8 h-px bg-blue-300"></span>
        </div>

    </div>
</section>


{{-- ═══════════════════════════════════════════════════════════════
     STATS STRIP
════════════════════════════════════════════════════════════════ --}}
<section class="bg-white border-b border-gray-100 py-14 px-4 sm:px-6">
    <div class="max-w-5xl mx-auto">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6" id="statsGrid">
            @foreach([
                ['50',  '+',  'Projects Delivered', '#2563eb'],
                ['30',  '+',  'Happy Clients',      '#059669'],
                ['5',   '+',  'Years Experience',   '#059669'],
                ['100', '%',  'Commitment',         '#2563eb'],
            ] as [$num, $suffix, $lab, $color])
            <div class="stat-card reveal text-center py-7 px-3 rounded-2xl border border-gray-100 bg-gray-50">
                <p class="text-3xl sm:text-4xl font-black tracking-tight mb-1" style="color: {{ $color }};">
                    <span class="stat-num" data-target="{{ $num }}">0</span><span class="stat-suffix">{{ $suffix }}</span>
                </p>
                <p class="text-[11px] text-gray-500 font-semibold uppercase tracking-widest">{{ $lab }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════════════════════════════
     2. WHO WE ARE  — 2-col on desktop, stacked on mobile
════════════════════════════════════════════════════════════════ --}}
<section class="bg-white py-20 sm:py-28 px-4 sm:px-6">
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">

        {{-- Left: copy --}}
        <div class="reveal">
            <p class="text-xs font-bold text-blue-600 uppercase tracking-widest mb-4">Our Story</p>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight text-gray-900
                       leading-[1.1] mb-6 max-w-[560px]">
                We are more than<br>
                a <span class="text-blue-600">dev shop.</span>
            </h2>
            <p class="text-gray-600 text-base sm:text-lg leading-relaxed mb-5 max-w-[600px]">
                {{ $cms['about_story'] ?? 'Roddy Technologies was founded with a clear mission: to make world-class software accessible to African businesses. We don\'t just write code we architect digital strategies that drive real growth.' }}
            </p>
            <p class="text-gray-500 leading-relaxed mb-8 max-w-[600px]">
                From startups to growing enterprises, we partner with visionary founders to turn
                ambitious ideas into scalable, beautiful, and highly profitable digital products.
            </p>
            <a href="{{ route('contact') }}"
               class="link-arrow inline-flex items-center gap-2 text-sm font-bold text-blue-600">
                Let's work together
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

        {{-- Right: abstract geometry — plain, no gradient fills --}}
        <div class="reveal flex justify-center lg:justify-end">
            <div class="relative w-64 h-64 sm:w-80 sm:h-80 lg:w-88 lg:h-88">

                {{-- Spinning dashed ring --}}
                <div class="absolute inset-0 rounded-full border-2 border-dashed border-blue-200"
                     style="animation: spinSlow 28s linear infinite;"></div>

                {{-- Static inner ring --}}
                <div class="absolute inset-8 rounded-full border border-gray-200"></div>

                {{-- Center card --}}
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-40 h-40 rounded-3xl bg-white border border-gray-200 shadow-lg
                                flex items-center justify-center">
                        <svg class="w-16 h-16" viewBox="0 0 64 64" fill="none">
                            <rect x="8"  y="8"  width="20" height="20" rx="4" fill="#2563eb"/>
                            <rect x="36" y="8"  width="20" height="20" rx="4" fill="#059669"/>
                            <rect x="8"  y="36" width="20" height="20" rx="4" fill="#0f172a"/>
                            <rect x="36" y="36" width="20" height="20" rx="4" fill="#2563eb" opacity=".4"/>
                        </svg>
                    </div>
                </div>

                {{-- Floating dots --}}
                <div class="absolute top-5 right-8 w-3 h-3 rounded-full bg-blue-500"
                     style="animation: floatY 4s ease-in-out infinite;"></div>
                <div class="absolute bottom-8 left-5 w-2 h-2 rounded-full bg-green-500"
                     style="animation: floatY 5.5s ease-in-out infinite 1s;"></div>

                {{-- Labels --}}
                <div class="absolute -top-4 left-8 px-3 py-1 rounded-full
                            bg-white border border-gray-200 shadow text-xs font-semibold text-gray-700">
                    Founded 2019
                </div>
                <div class="absolute -bottom-4 right-6 px-3 py-1 rounded-full
                            bg-blue-600 text-white text-xs font-semibold shadow">
                    Pan-African
                </div>

            </div>
        </div>

    </div>
</section>


{{-- ═══════════════════════════════════════════════════════════════
     3. CORE SERVICES  — plain #f8f9fa bg
════════════════════════════════════════════════════════════════ --}}
<section class="bg-[#f8f9fa] py-20 sm:py-28 px-4 sm:px-6">
    <div class="max-w-7xl mx-auto">

        <div class="reveal text-center mb-14">
            <p class="text-xs font-bold text-blue-600 uppercase tracking-widest mb-4">What We Do</p>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight text-gray-900 mb-4">
                Our Core Services
            </h2>
            <p class="text-gray-500 max-w-[600px] mx-auto text-sm sm:text-base">
                End-to-end digital solutions crafted for businesses that refuse to settle for average.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

            @foreach([
                ['Web Development',        'Custom, high-performance websites and web apps built with modern frameworks that scale without limits.',            '#2563eb', '<path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>'],
                ['Mobile Apps',            'Native and cross-platform iOS & Android apps with pixel-perfect UI and rock-solid performance.',                    '#059669', '<path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>'],
                ['SaaS Platforms',         'Subscription software with multi-tenancy, billing, analytics, and everything in between.',                          '#2563eb', '<path stroke-linecap="round" stroke-linejoin="round" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>'],
                ['UI/UX Design',           'Research-backed design systems that delight users and convert visitors into loyal customers.',                       '#059669', '<path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>'],
                ['Cloud Hosting & Domains','Managed cloud infrastructure, domain registration, and 24/7 monitoring so your product never sleeps.',             '#2563eb', '<path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>'],
                ['Digital Products',       'We ideate, validate, and ship our own digital products alongside building solutions for clients.',                   '#059669', '<path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>'],
            ] as [$title, $desc, $color, $icon])
            <div class="reveal lift-card group bg-gray-100 border border-gray-200 rounded-2xl p-5 sm:p-6 cursor-default">

                {{-- Icon --}}
                <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-5 bg-white border border-gray-200
                            [will-change:transform] transition-transform duration-[180ms] ease-[cubic-bezier(0.22,1,0.36,1)] group-hover:scale-110">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"
                         style="color: {{ $color }};">
                        {!! $icon !!}
                    </svg>
                </div>

                <h3 class="text-[18px] font-bold text-gray-900 mb-2">{{ $title }}</h3>
                <p class="text-base text-gray-600 leading-relaxed">{{ $desc }}</p>

                {{-- Bottom accent line on hover --}}
                <div class="mt-5 h-0.5 w-0 rounded-full group-hover:w-12"
                     style="background: {{ $color }}; transition: width 0.3s cubic-bezier(0.22,1,0.36,1);"></div>
            </div>
            @endforeach

        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════════════════════════════
     4. OUR ECOSYSTEM  — plain dark section, no orbs/gradients
════════════════════════════════════════════════════════════════ --}}
<section class="bg-[#0f172a] py-20 sm:py-28 px-4 sm:px-6">
    <div class="max-w-7xl mx-auto">

        <div class="reveal text-center mb-14">
            <p class="text-xs font-bold text-blue-400 uppercase tracking-widest mb-4">Our Ecosystem</p>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight text-white mb-5">
                Platforms We've Built
            </h2>
            <p class="text-slate-600 max-w-[600px] mx-auto text-sm sm:text-base">
                We don't just build for clients we build our own platforms.
            </p>
        </div>

        {{-- Divider --}}
        <div class="flex items-center justify-center gap-3 mb-12">
            <span class="w-12 h-px bg-slate-700"></span>
            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
            <span class="w-12 h-px bg-slate-700"></span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

            @foreach([
                ['Rshop',        'African eCommerce',    'Full-featured marketplace for eGift-Cards, eSims, Mobile Topups, Bills Payment, flights, stay and more.',         '#2563eb', true,  '<path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>'],
                ['RTG Domains',  'Domain Platform',      'Domain registration and management for African businesses fast search, instant activation, full DNS control.',    '#059669', true,  '<path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>'],
                ['RhostitCloud', 'Cloud Infrastructure', 'Managed cloud hosting for startups and enterprises one-click deploys, 99.9% uptime, 24/7 monitoring.',          '#2563eb', true,  '<path stroke-linecap="round" stroke-linejoin="round" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>'],
                ['Roddy AI',     'AI Platform',          'An intelligent AI suite for African businesses automation, smart analytics, and decision-making tools.',         '#059669', false, '<path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>'],
            ] as [$name, $tagline, $desc, $color, $live, $icon])
            <div class="reveal eco-card relative rounded-2xl p-5 sm:p-6 cursor-default border border-slate-800"
                 style="background: rgba(255,255,255,0.04);">

                {{-- Badge --}}
                <div class="absolute top-4 right-4">
                    @if($live)
                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold
                                 bg-green-900/40 text-green-400 border border-green-800">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-400"></span>LIVE
                    </span>
                    @else
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold
                                 bg-slate-700 text-slate-300 border border-slate-600">
                        SOON
                    </span>
                    @endif
                </div>

                {{-- Icon --}}
                <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-5 bg-slate-800 border border-slate-700">
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"
                         style="color: {{ $color }};">
                        {!! $icon !!}
                    </svg>
                </div>

                <p class="text-[11px] font-bold uppercase tracking-widest mb-1" style="color: {{ $color }};">
                    {{ $tagline }}
                </p>
                <h3 class="text-[18px] font-black text-white mb-3">{{ $name }}</h3>
                <p class="text-base text-slate-400 leading-relaxed">{{ $desc }}</p>

                {{-- Bottom rule on hover --}}
                <div class="mt-4 h-px w-0 transition-all duration-300 eco-card-line"
                     style="background: {{ $color }};"></div>
            </div>
            @endforeach

        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════════════════════════════
     5. MISSION & VISION  — plain white, flat icon badges
════════════════════════════════════════════════════════════════ --}}
<section class="bg-white py-20 sm:py-28 px-4 sm:px-6">
    <div class="max-w-5xl mx-auto">

        <div class="reveal text-center mb-14">
            <p class="text-xs font-bold text-blue-600 uppercase tracking-widest mb-4">Our Purpose</p>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight text-gray-900">
                Why we exist
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Mission --}}
            <div class="reveal lift-card group relative bg-white border border-gray-100 rounded-2xl p-8 sm:p-10 overflow-hidden">
                <div class="w-11 h-11 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center mb-7">
                    <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <p class="text-xs font-bold text-blue-600 uppercase tracking-widest mb-3">Mission</p>
                <h3 class="text-[18px] font-black text-gray-900 mb-4">
                    {{ $cms['about_mission'] ?? 'To empower businesses with scalable digital solutions.' }}
                </h3>
                <p class="text-base text-gray-500 leading-relaxed max-w-[520px]">
                    We exist to close the digital gap for African businesses delivering enterprise-grade
                    software without enterprise-grade friction.
                </p>
                {{-- Solid bottom border on hover --}}
                <div class="absolute bottom-0 left-0 right-0 h-[3px] bg-blue-600 scale-x-0 group-hover:scale-x-100
                            transition-transform duration-[180ms] origin-left rounded-b-2xl"></div>
            </div>

            {{-- Vision --}}
            <div class="reveal lift-card group relative bg-white border border-gray-100 rounded-2xl p-8 sm:p-10 overflow-hidden">
                <div class="w-11 h-11 rounded-xl bg-green-50 border border-green-100 flex items-center justify-center mb-7">
                    <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
                <p class="text-xs font-bold text-green-600 uppercase tracking-widest mb-3">Vision</p>
                <h3 class="text-[18px] font-black text-gray-900 mb-4">
                    {{ $cms['about_vision'] ?? 'To become a leading African tech powerhouse with global impact.' }}
                </h3>
                <p class="text-base text-gray-500 leading-relaxed max-w-[520px]">
                    We are building Roddy Technologies into the most trusted name in African tech creating
                    platforms and products that ripple outward across the globe.
                </p>
                <div class="absolute bottom-0 left-0 right-0 h-[3px] bg-green-600 scale-x-0 group-hover:scale-x-100
                            transition-transform duration-[180ms] origin-left rounded-b-2xl"></div>
            </div>

        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════════════════════════════
     6. WHY CHOOSE US  — plain #f8f9fa
════════════════════════════════════════════════════════════════ --}}
<section class="bg-[#f8f9fa] py-20 sm:py-28 px-4 sm:px-6">
    <div class="max-w-5xl mx-auto">

        <div class="reveal text-center mb-14">
            <p class="text-xs font-bold text-blue-600 uppercase tracking-widest mb-4">The Roddy Advantage</p>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight text-gray-900 mb-4">
                Why choose us?
            </h2>
            <p class="text-gray-500 max-w-[600px] mx-auto text-sm sm:text-base">
                We combine technical excellence with a relentless focus on your business outcomes not just code.
            </p>
        </div>

        <div class="space-y-3">
            @foreach([
                ['01', 'Fast Delivery',              'We ship production-ready products at speed without cutting corners. Agile sprints, daily standups, and a culture of disciplined velocity.',     '#2563eb', '<path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>'],
                ['02', 'Premium UI/UX',              'Every pixel has a purpose. We design for clarity, beauty, and conversion products your users will love from first touch.',                    '#059669', '<path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>'],
                ['03', 'Scalable Architecture',      'We build with tomorrow in mind. Clean code, solid patterns, and infrastructure that grows as seamlessly as your business does.',               '#2563eb', '<path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>'],
                ['04', 'Business-Focused Solutions', 'We don\'t just deliver code we deliver outcomes. Every feature ties directly to a business goal, KPI, or growth lever.',                    '#059669', '<path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>'],
                ['05', 'Ongoing Support',            'Launch is just the beginning. We offer proactive maintenance, performance monitoring, and dedicated support long after go-live.',               '#2563eb', '<path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>'],
            ] as [$num, $title, $desc, $color, $icon])
            <div class="reveal feature-row group flex items-start gap-4 sm:gap-6 p-5 sm:p-6 bg-white border border-gray-100">

                {{-- Number --}}
                <div class="shrink-0 w-9 h-9 rounded-xl bg-gray-50 border border-gray-100
                            flex items-center justify-center text-xs font-black"
                     style="color: {{ $color }};">
                    {{ $num }}
                </div>

                {{-- Icon --}}
                <div class="shrink-0 w-9 h-9 rounded-xl bg-gray-50 border border-gray-100
                            flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"
                         style="color: {{ $color }};">
                        {!! $icon !!}
                    </svg>
                </div>

                {{-- Text --}}
                <div class="flex-1 min-w-0">
                    <h3 class="text-[18px] font-black text-gray-900 mb-1">{{ $title }}</h3>
                    <p class="text-base text-gray-500 leading-relaxed max-w-[600px]">{{ $desc }}</p>
                </div>

                {{-- Arrow (desktop hover only) --}}
                <div class="hidden sm:flex shrink-0 w-8 h-8 rounded-lg bg-gray-50 border border-gray-100
                            items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"
                         style="color: {{ $color }};">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </div>

            </div>
            @endforeach
        </div>

    </div>
</section>


{{-- ═══════════════════════════════════════════════════════════════
     7. FOUNDER  — plain white card
════════════════════════════════════════════════════════════════ --}}
<section class="bg-white py-20 sm:py-28 px-4 sm:px-6">
    <div class="max-w-3xl mx-auto">

        <div class="reveal text-center mb-14">
            <p class="text-xs font-bold text-blue-600 uppercase tracking-widest mb-4">Leadership</p>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight text-gray-900">
                The Founder
            </h2>
        </div>

        <div class="reveal bg-white border border-gray-100 rounded-3xl p-8 sm:p-12 text-center shadow-sm">

            {{-- Avatar --}}
            <div class="relative inline-flex items-center justify-center mb-7">
                <div class="founder-ring w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-blue-600
                            flex items-center justify-center text-white text-2xl sm:text-3xl font-black">
                    R
                </div>
                <div class="absolute bottom-0.5 right-0.5 w-5 h-5 rounded-full bg-green-500
                            border-2 border-white shadow-sm"></div>
            </div>

            {{-- Name --}}
            <h3 class="text-xl sm:text-2xl font-black text-gray-900 mb-1">Roddy Tech</h3>
            <p class="text-xs sm:text-sm font-bold text-blue-600 uppercase tracking-widest mb-8">
                CEO & Founder
            </p>

            {{-- Quote --}}
            <blockquote class="text-base sm:text-lg font-bold text-gray-800 leading-relaxed
                               max-w-[600px] mx-auto mb-8 relative">
                <span class="text-4xl text-blue-200 font-serif leading-none align-top mr-1">"</span>
                Building the future of digital businesses in Africa one product at a time Making sure every solution delivers real value and help the societies Day to Day needs and improvements in productivity.
                <span class="text-4xl text-blue-200 font-serif leading-none align-bottom ml-1">"</span>
            </blockquote>

            {{-- Divider --}}
            <div class="flex items-center justify-center gap-3 mb-7">
                <span class="w-12 h-px bg-gray-200"></span>
                <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
                <span class="w-12 h-px bg-gray-200"></span>
            </div>

            {{-- Tags --}}
            <div class="flex flex-wrap items-center justify-center gap-2">
                @foreach(['Full-Stack Engineer', 'Product Strategist', 'Entrepreneur', 'UI/UX Enthusiast'] as $tag)
                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100
                             text-gray-700 border border-gray-200">
                    {{ $tag }}
                </span>
                @endforeach
            </div>

        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════════════════════════════
     8. TEAM
════════════════════════════════════════════════════════════════ --}}
<section class="bg-white py-20 sm:py-28 px-4 sm:px-6">
    <div class="max-w-6xl mx-auto">

        {{-- Section header --}}
        <div class="reveal text-center mb-16">
            <p class="text-xs font-bold text-blue-600 uppercase tracking-widest mb-4">Our Team</p>
            <h2 class="text-3xl sm:text-5xl font-black tracking-tight text-gray-900 leading-[1.08] mb-5">
                The Minds Behind<br class="hidden sm:block"> Roddy Technologies
            </h2>
            <p class="text-base sm:text-lg text-gray-500 max-w-xl mx-auto leading-relaxed">
                A small, focused team obsessed with craft, quality, and building things that last.
            </p>
        </div>

        {{-- Team grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">

            @php
            $members = [
                [
                    'name'   => 'Ngeh Asah Divine Ofeh',
                    'role'   => 'Founder & CEO',
                    'bio'    => 'Visionary behind Roddy Technologies — building Africa\'s premium digital future.',
                    'avatar' => null,
                    'socials'=> [
                        'linkedin' => '#',
                        'x'        => '#',
                    ],
                ],
                [
                    'name'   => 'Chief Technology Officer',
                    'role'   => 'CTO',
                    'bio'    => 'Architects the technical foundation that powers every product we ship.',
                    'avatar' => null,
                    'socials'=> [
                        'linkedin' => '#',
                        'github'   => '#',
                    ],
                ],
                [
                    'name'   => 'Full Stack Developer',
                    'role'   => 'Engineer',
                    'bio'    => 'Turns complex requirements into fast, reliable, production-grade software.',
                    'avatar' => null,
                    'socials'=> [
                        'github'   => '#',
                        'linkedin' => '#',
                    ],
                ],
                [
                    'name'   => 'UI/UX Designer',
                    'role'   => 'Product Designer',
                    'bio'    => 'Crafts interfaces that feel intuitive, beautiful, and pixel-perfect.',
                    'avatar' => null,
                    'socials'=> [
                        'linkedin' => '#',
                        'x'        => '#',
                    ],
                ],
                [
                    'name'   => 'Graphic Designer',
                    'role'   => 'Brand Designer',
                    'bio'    => 'Shapes the visual identity that makes our clients unforgettable.',
                    'avatar' => null,
                    'socials'=> [
                        'linkedin' => '#',
                        'x'        => '#',
                    ],
                ],
                [
                    'name'   => 'Growth Strategist',
                    'role'   => 'Marketing',
                    'bio'    => 'Drives demand, awareness, and growth across every market we enter.',
                    'avatar' => null,
                    'socials'=> [
                        'linkedin' => '#',
                        'x'        => '#',
                    ],
                ],
            ];
            @endphp

            @foreach($members as $i => $member)
            @php
            $initials = collect(explode(' ', $member['name']))->map(fn($w) => strtoupper($w[0]))->take(2)->implode('');
            $palettes = [
                ['bg'=>'#eff6ff','text'=>'#2563eb'],
                ['bg'=>'#f0fdf4','text'=>'#059669'],
                ['bg'=>'#faf5ff','text'=>'#7c3aed'],
                ['bg'=>'#fff7ed','text'=>'#d97706'],
                ['bg'=>'#fdf2f8','text'=>'#db2777'],
                ['bg'=>'#ecfeff','text'=>'#0891b2'],
            ];
            $pal = $palettes[$i % count($palettes)];
            @endphp

            <div class="team-card reveal group relative bg-white border border-gray-100 rounded-[20px]
                        p-6 sm:p-7 text-center cursor-default
                        transition-all duration-[180ms] ease-[cubic-bezier(0.22,1,0.36,1)]
                        hover:shadow-[0_12px_40px_rgba(0,0,0,0.10)] hover:-translate-y-[5px] hover:scale-[1.02]
                        hover:border-blue-100"
                 style="will-change:transform,box-shadow;">

                {{-- Avatar --}}
                <div class="relative inline-block mb-5">
                    <div class="w-20 h-20 rounded-full overflow-hidden mx-auto ring-2 ring-gray-100
                                group-hover:ring-blue-200 transition-all duration-[180ms]
                                group-hover:scale-[1.06]"
                         style="transition:transform .18s cubic-bezier(0.22,1,0.36,1),box-shadow .18s ease,ring .18s ease;">
                        @if($member['avatar'])
                        <img src="{{ asset($member['avatar']) }}"
                             alt="{{ $member['name'] }}"
                             class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-lg font-black"
                             style="background:{{ $pal['bg'] }}; color:{{ $pal['text'] }};">
                            {{ $initials }}
                        </div>
                        @endif
                    </div>
                    {{-- Online dot --}}
                    <span class="absolute bottom-0.5 right-0.5 w-3.5 h-3.5 rounded-full bg-emerald-400
                                 border-2 border-white shadow-sm"></span>
                </div>

                {{-- Name --}}
                <h3 class="text-base font-black text-gray-900 leading-snug mb-1
                           group-hover:text-blue-600 transition-colors duration-[180ms]">
                    {{ $member['name'] }}
                </h3>

                {{-- Role badge --}}
                <span class="inline-block text-xs font-bold px-2.5 py-0.5 rounded-full mb-3"
                      style="background:{{ $pal['bg'] }}; color:{{ $pal['text'] }};">
                    {{ $member['role'] }}
                </span>

                {{-- Bio --}}
                <p class="text-sm text-gray-500 leading-relaxed mb-5 min-h-[40px]">
                    {{ $member['bio'] }}
                </p>

                {{-- Social icons — hidden, fade in on card hover --}}
                <div class="flex items-center justify-center gap-3
                            opacity-0 translate-y-2 group-hover:opacity-100 group-hover:translate-y-0
                            transition-all duration-[200ms] ease-out">

                    @foreach($member['socials'] as $network => $url)
                    <a href="{{ $url }}"
                       target="_blank" rel="noopener noreferrer"
                       class="w-8 h-8 rounded-lg flex items-center justify-center
                              bg-gray-50 text-gray-400 border border-gray-100
                              hover:bg-blue-600 hover:text-white hover:border-blue-600
                              transition-all duration-[180ms]"
                       aria-label="{{ $network }}">

                        @if($network === 'linkedin')
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>

                        @elseif($network === 'x')
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.741l7.73-8.835L1.254 2.25H8.08l4.253 5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>

                        @elseif($network === 'github')
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                        </svg>

                        @endif
                    </a>
                    @endforeach

                </div>

            </div>
            @endforeach

        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════════════════════════════
     9. CTA  — plain dark section
════════════════════════════════════════════════════════════════ --}}
<section class="bg-[#0f172a] py-20 sm:py-28 px-4 sm:px-6">
    <div class="max-w-3xl mx-auto text-center">

        {{-- Badge --}}
        <div class="reveal inline-flex items-center gap-2 mb-7 px-4 py-1.5 rounded-full
                    bg-blue-900/40 border border-blue-800 text-blue-300 text-xs font-bold uppercase tracking-widest">
            <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
            Let's Build Together
        </div>

        {{-- Headline --}}
        <h2 class="reveal text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight text-white
                   leading-[1.07] mb-6 max-w-[600px] mx-auto">
            Ready to build something powerful?
        </h2>

        <p class="reveal text-slate-400 text-base sm:text-lg mb-10 max-w-[600px] mx-auto leading-relaxed">
            Let's turn your vision into a world-class product. Reach out and our team
            will respond within immidiatly we are up 24/7.
        </p>

        {{-- Buttons --}}
        <div class="reveal flex flex-col sm:flex-row items-center justify-center gap-4">

            <a href="{{ route('contact') }}"
               class="btn-primary w-full sm:w-auto inline-flex items-center justify-center gap-2.5
                      px-7 py-3.5 rounded-xl text-sm font-black text-white">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                Start a Project
            </a>

            <a href="{{ route('contact') }}"
               class="btn-ghost w-full sm:w-auto inline-flex items-center justify-center gap-2.5
                      px-7 py-3.5 rounded-xl text-sm font-black text-white border border-slate-700">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Contact Us
            </a>

        </div>

        {{-- Social proof --}}
        <div class="reveal mt-12 flex flex-col sm:flex-row items-center justify-center gap-5 sm:gap-10">
            @foreach(['50+ Projects Delivered', '30+ Happy Clients', '24h Response Time'] as $proof)
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                <span class="text-sm text-slate-400 font-medium">{{ $proof }}</span>
            </div>
            @endforeach
        </div>

    </div>
</section>


{{-- ══════════════════════════════════════════════════════════════
     SCROLL REVEAL
═══════════════════════════════════════════════════════════════ --}}
<script>
(function () {
    var els = document.querySelectorAll('.reveal');
    if (!els.length) return;
    var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
                io.unobserve(e.target);
            }
        });
    }, { threshold: 0.1 });
    els.forEach(function (el) { io.observe(el); });
}());

/* ── Stats count-up ─────────────────────────────────────────── */
(function () {
    var cards = document.querySelectorAll('#statsGrid .stat-card');
    if (!cards.length) return;

    function animateCount(el) {
        var numEl  = el.querySelector('.stat-num');
        if (!numEl || numEl.dataset.done) return;
        numEl.dataset.done = '1';

        var target   = parseInt(numEl.dataset.target, 10);
        var duration = 1400;
        var start    = null;

        function step(ts) {
            if (!start) start = ts;
            var progress = Math.min((ts - start) / duration, 1);
            /* ease-out cubic */
            var eased = 1 - Math.pow(1 - progress, 3);
            numEl.textContent = Math.floor(eased * target);
            if (progress < 1) {
                requestAnimationFrame(step);
            } else {
                numEl.textContent = target;
            }
        }
        requestAnimationFrame(step);
    }

    var statsObs = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
            if (e.isIntersecting) {
                animateCount(e.target);
                statsObs.unobserve(e.target);
            }
        });
    }, { threshold: 0.4 });

    cards.forEach(function (c) { statsObs.observe(c); });
}());
</script>

</x-layouts.public>
