{{--
    ┌──────────────────────────────────────────────────────────────────┐
    │  SERVICES PAGE  —  resources/views/public/services.blade.php     │
    │                                                                  │
    │  Design rules (matches site-wide style):                         │
    │   - NO gradients anywhere — plain solid backgrounds only         │
    │   - Backgrounds: white / #f8f9fa / #0f172a                      │
    │   - Brand: #2563eb (blue) · #059669 (green) · #0f172a (dark)   │
    │   - Cards: bg-gray-100, white icon box, gray-900/600 text       │
    │   - Hover: translateY(-6px) scale(1.02), 0.18s ease-out        │
    │   - Prose: max-w-[600px]                                        │
    │   - Scroll reveal via IntersectionObserver                      │
    └──────────────────────────────────────────────────────────────────┘
--}}
<x-layouts.public title="Services">

<style>
/* ── Scroll reveal ─────────────────────────────────────────────── */
.reveal {
    opacity: 0;
    transform: translateY(22px);
    transition: opacity 0.6s ease, transform 0.6s ease;
}
.reveal.visible { opacity: 1; transform: translateY(0); }

/* ── Service cards ─────────────────────────────────────────────── */
.svc-card {
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    will-change: transform, box-shadow;
    transition: transform 0.18s cubic-bezier(0.22,1,0.36,1),
                box-shadow 0.18s cubic-bezier(0.22,1,0.36,1),
                border-color 0.18s ease;
}
.svc-card:hover {
    transform: translateY(-6px) scale(1.02);
    box-shadow: 0 20px 48px rgba(0,0,0,0.10);
    border-color: #bfdbfe;
}
.svc-icon {
    will-change: transform;
    transition: transform 0.18s cubic-bezier(0.22,1,0.36,1);
}
.svc-card:hover .svc-icon { transform: scale(1.10); }
.svc-accent {
    height: 2px; width: 0; border-radius: 9999px;
    transition: width 0.3s cubic-bezier(0.22,1,0.36,1);
}
.svc-card:hover .svc-accent { width: 3rem; }

/* ── Process steps ─────────────────────────────────────────────── */
.step-card {
    transition: transform 0.18s cubic-bezier(0.22,1,0.36,1),
                box-shadow 0.18s cubic-bezier(0.22,1,0.36,1),
                border-color 0.18s ease;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}
.step-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 40px rgba(0,0,0,0.09);
    border-color: #bfdbfe;
}

/* ── Pricing cards ─────────────────────────────────────────────── */
.price-card {
    transition: transform 0.18s cubic-bezier(0.22,1,0.36,1),
                box-shadow 0.18s cubic-bezier(0.22,1,0.36,1);
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}
.price-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 24px 56px rgba(0,0,0,0.11);
}

/* ── Feature rows ──────────────────────────────────────────────── */
.feature-row {
    border-radius: 1rem;
    transition: background 0.18s ease, transform 0.18s cubic-bezier(0.22,1,0.36,1);
}
.feature-row:hover { background: #f0f7ff; transform: translateX(5px); }

/* ── CTA buttons ───────────────────────────────────────────────── */
.btn-primary {
    background: #2563eb;
    transition: background 0.18s ease, transform 0.18s ease, box-shadow 0.18s ease;
}
.btn-primary:hover {
    background: #1d4ed8;
    transform: translateY(-2px);
    box-shadow: 0 10px 28px rgba(37,99,235,0.32);
}
.btn-primary:active { transform: scale(0.97); }

.btn-ghost {
    transition: background 0.18s ease, transform 0.18s ease;
}
.btn-ghost:hover { background: rgba(255,255,255,0.10); transform: translateY(-2px); }
</style>


{{-- ════════════════════════════════════════════════════════════════
     1. HERO — dark #0f172a, no gradients, no orbs
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
        <div class="inline-flex items-center gap-2 mb-7 px-4 py-2 rounded-full bg-blue-50 border border-blue-100">
            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
            <span class="text-xs font-semibold text-blue-700 uppercase tracking-widest">What We Build</span>
        </div>

        <h1 class="text-[2.6rem] sm:text-5xl lg:text-6xl font-black tracking-tight text-gray-900 leading-[1.08]
                   max-w-[760px] mx-auto mb-6">
            Our
            <span class="bg-gradient-to-r from-blue-600 to-emerald-500 bg-clip-text text-transparent">Services</span>
        </h1>

        <p class="text-base sm:text-lg text-gray-500 leading-relaxed max-w-[600px] mx-auto mb-10">
            We design and build scalable digital solutions for startups and businesses ready to grow
            from idea to production-ready product.
        </p>

        <div class="flex items-center justify-center gap-3">
            <span class="w-8 h-px bg-blue-300"></span>
            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
            <span class="w-8 h-px bg-blue-300"></span>
        </div>

    </div>
</section>


{{-- ════════════════════════════════════════════════════════════════
     2. SERVICES GRID — bg-[#f8f9fa], cards bg-gray-100
════════════════════════════════════════════════════════════════ --}}
<section class="bg-[#f8f9fa] py-20 sm:py-28 px-4 sm:px-6">
    <div class="max-w-7xl mx-auto">

        <div class="reveal text-center mb-14">
            <p class="text-xs font-bold text-blue-600 uppercase tracking-widest mb-4">What We Offer</p>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight text-gray-900 mb-4">
                End-to-end digital services
            </h2>
            <p class="text-gray-500 max-w-[600px] mx-auto text-base">
                Every service is tailored to your business goals not copy-pasted from a template.
            </p>
        </div>

        @php
        $hardcodedServices = [
            ['title' => 'Web Development',              'color' => '#2563eb', 'desc' => 'Custom, high-performance websites and web apps built with modern frameworks that scale without limits.', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>'],
            ['title' => 'Mobile App Development',       'color' => '#059669', 'desc' => 'Native and cross-platform iOS & Android apps with pixel-perfect UI and rock-solid performance.',         'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>'],
            ['title' => 'SaaS Platform Development',    'color' => '#2563eb', 'desc' => 'Multi-tenant subscription software with billing, analytics, role management, and 99.9% uptime.',         'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>'],
            ['title' => 'UI/UX Design',                 'color' => '#059669', 'desc' => 'Research-backed design systems that delight users and convert visitors into loyal customers.',             'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>'],
            ['title' => 'Cloud Hosting & Domains',      'color' => '#2563eb', 'desc' => 'Managed cloud infrastructure, domain registration, SSL, and 24/7 monitoring — your product never sleeps.', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>'],
            ['title' => 'Custom Software Solutions',    'color' => '#059669', 'desc' => 'Bespoke software tailored exactly to your workflows — automation, integrations, dashboards, and more.',   'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>'],
        ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @if($services->count())
                @php
                $svgMap = [
                    'Web Development'        => '<path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>',
                    'Mobile Apps'            => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>',
                    'UI/UX Design'           => '<path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>',
                    'Brand Identity'         => '<path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>',
                    'API Development'        => '<path stroke-linecap="round" stroke-linejoin="round" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>',
                    'Digital Consulting'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>',
                ];
                $defaultSvg = '<path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>';
                @endphp
                @foreach($services as $i => $service)
                @php $colors = ['#2563eb','#059669']; $c = $colors[$i % 2];
                      $svgPath = $svgMap[$service->title] ?? $defaultSvg; @endphp
                <div class="reveal svc-card group bg-gray-100 border border-gray-200 rounded-2xl p-5 sm:p-6 cursor-default">
                    <div class="svc-icon w-11 h-11 rounded-xl flex items-center justify-center mb-5 bg-white border border-gray-200">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" style="color:{{ $c }}">
                            {!! $svgPath !!}
                        </svg>
                    </div>
                    <h3 class="text-[18px] font-bold text-gray-900 mb-2">{{ $service->title }}</h3>
                    <p class="text-base text-gray-600 leading-relaxed">{{ $service->description }}</p>
                    <div class="svc-accent mt-5" style="background:{{ $c }};"></div>
                </div>
                @endforeach
            @else
                @foreach($hardcodedServices as $svc)
                <div class="reveal svc-card group bg-gray-100 border border-gray-200 rounded-2xl p-5 sm:p-6 cursor-default">
                    <div class="svc-icon w-11 h-11 rounded-xl flex items-center justify-center mb-5 bg-white border border-gray-200">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" style="color:{{ $svc['color'] }}">
                            {!! $svc['icon'] !!}
                        </svg>
                    </div>
                    <h3 class="text-[18px] font-bold text-gray-900 mb-2">{{ $svc['title'] }}</h3>
                    <p class="text-base text-gray-600 leading-relaxed">{{ $svc['desc'] }}</p>
                    <div class="svc-accent mt-5" style="background:{{ $svc['color'] }};"></div>
                </div>
                @endforeach
            @endif
        </div>

    </div>
</section>


{{-- ════════════════════════════════════════════════════════════════
     3. SERVICE DETAILS — alternating 2-col layout, white bg
════════════════════════════════════════════════════════════════ --}}
<section class="bg-white py-20 sm:py-28 px-4 sm:px-6">
    <div class="max-w-7xl mx-auto space-y-24 sm:space-y-32">

        {{-- Detail 1: Web Development (text left, visual right) --}}
        <div class="reveal grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            <div>
                <p class="text-xs font-bold text-blue-600 uppercase tracking-widest mb-4">Web Development</p>
                <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-gray-900 leading-[1.1] mb-6 max-w-[520px]">
                    Websites & web apps that <span class="text-blue-600">actually convert.</span>
                </h2>
                <p class="text-gray-600 text-base leading-relaxed mb-8 max-w-[560px]">
                    We build custom web applications from scratch no page builders, no bloated themes.
                    Every project is architected for performance, SEO, and long-term scalability.
                </p>
                <ul class="space-y-3 mb-8">
                    @foreach([
                        'Custom admin dashboards & portals',
                        'REST API & third-party integrations',
                        'Role-based access control',
                        'Real-time features (WebSockets)',
                        'Mobile-responsive, pixel-perfect UI',
                        'Cloud deployment & CI/CD pipeline',
                    ] as $feat)
                    <li class="flex items-center gap-3 text-base text-gray-700">
                        <svg class="w-4 h-4 shrink-0 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ $feat }}
                    </li>
                    @endforeach
                </ul>
                <div class="flex flex-wrap gap-2">
                    @foreach(['Laravel','React','Vue.js','Tailwind CSS','MySQL','Redis'] as $tech)
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">{{ $tech }}</span>
                    @endforeach
                </div>
            </div>
            <div class="flex justify-center lg:justify-end">
                <div class="w-full max-w-sm bg-[#0f172a] rounded-2xl p-6 border border-slate-800 shadow-2xl">
                    <div class="flex items-center gap-2 mb-5">
                        <span class="w-3 h-3 rounded-full bg-red-500"></span>
                        <span class="w-3 h-3 rounded-full bg-yellow-400"></span>
                        <span class="w-3 h-3 rounded-full bg-green-500"></span>
                        <span class="ml-3 text-[11px] text-slate-500 font-mono">app.roddytech.com</span>
                    </div>
                    <div class="space-y-2 font-mono text-[12px]">
                        <p><span class="text-blue-400">const</span> <span class="text-white">app</span> <span class="text-slate-400">=</span> <span class="text-green-400">new</span> <span class="text-yellow-300">Application</span><span class="text-slate-400">();</span></p>
                        <p><span class="text-slate-500">// Scalable from day one</span></p>
                        <p><span class="text-white">app</span><span class="text-slate-400">.</span><span class="text-blue-300">boot</span><span class="text-slate-400">(</span><span class="text-green-400">'production'</span><span class="text-slate-400">);</span></p>
                        <p class="mt-4"><span class="text-slate-500">// Performance metrics</span></p>
                        <div class="mt-2 space-y-1.5">
                            @foreach([['Lighthouse Score','98/100','#2563eb'],['Load Time','< 1.2s','#059669'],['Uptime SLA','99.9%','#059669']] as [$k,$v,$col])
                            <div class="flex items-center justify-between bg-slate-800/60 rounded-lg px-3 py-1.5">
                                <span class="text-slate-400">{{ $k }}</span>
                                <span class="font-bold text-[11px]" style="color:{{ $col }}">{{ $v }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Detail 2: Mobile Apps (visual left, text right) --}}
        <div class="reveal grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            <div class="order-2 lg:order-1 flex justify-center lg:justify-start">
                <div class="relative w-[220px]">
                    {{-- Phone shell --}}
                    <div class="w-full bg-[#0f172a] rounded-[2.5rem] p-2 border border-slate-700 shadow-2xl">
                        <div class="bg-slate-900 rounded-[2rem] overflow-hidden">
                            {{-- Status bar --}}
                            <div class="flex items-center justify-between px-5 pt-4 pb-2">
                                <span class="text-[10px] text-slate-400 font-mono">9:41</span>
                                <div class="flex gap-1">
                                    <span class="w-3 h-1.5 rounded-sm bg-green-500"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-600"></span>
                                </div>
                            </div>
                            {{-- App UI mock --}}
                            <div class="px-4 pb-6 space-y-3">
                                <div class="bg-blue-600 rounded-xl p-3">
                                    <p class="text-[9px] text-blue-200 font-semibold uppercase tracking-wider">Dashboard</p>
                                    <p class="text-white font-black text-lg leading-none mt-0.5">XAF 4,250<span class="text-[10px] font-normal text-blue-300">.00</span></p>
                                </div>
                                @foreach([['Orders','12','#2563eb'],['Revenue','↑ 34%','#059669'],['Users','2,400','#2563eb']] as [$l,$v,$c])
                                <div class="flex items-center justify-between bg-slate-800 rounded-xl px-3 py-2">
                                    <span class="text-[10px] text-slate-400">{{ $l }}</span>
                                    <span class="text-[11px] font-bold" style="color:{{ $c }}">{{ $v }}</span>
                                </div>
                                @endforeach
                                <div class="h-20 bg-slate-800 rounded-xl flex items-end px-3 pb-2 gap-1.5">
                                    @foreach([40,65,50,80,60,90,75] as $h)
                                    <div class="flex-1 rounded-sm" style="height:{{ $h }}%; background:#2563eb; opacity: 0.7;"></div>
                                    @endforeach
                                    <div class="flex-1 rounded-sm bg-blue-500" style="height:90%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Badge --}}
                    <div class="absolute -top-3 -right-3 bg-green-500 text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow">
                        iOS & Android
                    </div>
                </div>
            </div>
            <div class="order-1 lg:order-2">
                <p class="text-xs font-bold text-green-600 uppercase tracking-widest mb-4">Mobile App Development</p>
                <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-gray-900 leading-[1.1] mb-6 max-w-[520px]">
                    Apps your users will <span class="text-green-600">actually love.</span>
                </h2>
                <p class="text-gray-600 text-base leading-relaxed mb-8 max-w-[560px]">
                    We ship polished iOS and Android apps from a single codebase fast time to market,
                    native-level performance, and a UI that stands out on any device.
                </p>
                <ul class="space-y-3 mb-8">
                    @foreach([
                        'Cross-platform iOS & Android (React Native / Flutter)',
                        'Offline-first architecture',
                        'Push notifications & deep links',
                        'In-app payments (Stripe, MoMo)',
                        'App Store & Play Store submission',
                        'Backend API included',
                    ] as $feat)
                    <li class="flex items-center gap-3 text-base text-gray-700">
                        <svg class="w-4 h-4 shrink-0 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ $feat }}
                    </li>
                    @endforeach
                </ul>
                <div class="flex flex-wrap gap-2">
                    @foreach(['React Native','Flutter','Firebase','Node.js','Expo','Swift'] as $tech)
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-100">{{ $tech }}</span>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Detail 3: SaaS (text left, visual right) --}}
        <div class="reveal grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            <div>
                <p class="text-xs font-bold text-blue-600 uppercase tracking-widest mb-4">SaaS Platform Development</p>
                <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-gray-900 leading-[1.1] mb-6 max-w-[520px]">
                    Build once. Scale to <span class="text-blue-600">thousands of users.</span>
                </h2>
                <p class="text-gray-600 text-base leading-relaxed mb-8 max-w-[560px]">
                    We architect multi-tenant SaaS platforms with subscription billing, team management,
                    analytics dashboards, and everything you need to run a software business.
                </p>
                <ul class="space-y-3 mb-8">
                    @foreach([
                        'Multi-tenant architecture',
                        'Subscription billing (Stripe / Paystack)',
                        'Role & permission management',
                        'Analytics & reporting dashboard',
                        'White-label ready',
                        'API-first design',
                    ] as $feat)
                    <li class="flex items-center gap-3 text-base text-gray-700">
                        <svg class="w-4 h-4 shrink-0 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ $feat }}
                    </li>
                    @endforeach
                </ul>
                <div class="flex flex-wrap gap-2">
                    @foreach(['Laravel','PostgreSQL','Stripe','Redis','Docker','AWS'] as $tech)
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">{{ $tech }}</span>
                    @endforeach
                </div>
            </div>
            <div class="flex justify-center lg:justify-end">
                <div class="w-full max-w-sm space-y-3">
                    @foreach([
                        ['Total MRR','XAF 2,840,000','↑ 18% this month','#2563eb'],
                        ['Active Tenants','1,240','↑ 34 new this week','#059669'],
                        ['Churn Rate','1.2%','↓ Lowest ever','#059669'],
                    ] as [$label,$val,$sub,$col])
                    <div class="bg-gray-50 border border-gray-200 rounded-2xl px-5 py-4 flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">{{ $label }}</p>
                            <p class="text-lg font-black text-gray-900 mt-0.5">{{ $val }}</p>
                            <p class="text-xs font-semibold mt-0.5" style="color:{{ $col }}">{{ $sub }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-white border border-gray-200">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" style="color:{{ $col }}">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</section>


{{-- ════════════════════════════════════════════════════════════════
     4. PROCESS — #f8f9fa bg, 5 steps
════════════════════════════════════════════════════════════════ --}}
<section class="bg-[#f8f9fa] py-20 sm:py-28 px-4 sm:px-6">
    <div class="max-w-7xl mx-auto">

        <div class="reveal text-center mb-16">
            <p class="text-xs font-bold text-blue-600 uppercase tracking-widest mb-4">How We Work</p>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight text-gray-900 mb-4">
                Our process
            </h2>
            <p class="text-gray-500 max-w-[600px] mx-auto text-base">
                A transparent, collaborative workflow from first conversation to post-launch support.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            @foreach([
                ['01', 'Consultation',  'We listen first. We learn your goals, users, and constraints before any proposal.',        '#2563eb', '<path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>'],
                ['02', 'Planning',      'Scope, timeline, and tech stack agreed in writing. No surprises, no scope creep.',        '#059669', '<path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>'],
                ['03', 'Design',        'Wireframes then high-fidelity UI. You review and approve before we write a line of code.', '#2563eb', '<path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>'],
                ['04', 'Development',   'Weekly demos. Agile sprints. You see progress every step of the way.',                    '#059669', '<path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>'],
                ['05', 'Launch & Support','We deploy, monitor, and support. Launch is just the beginning.',                       '#2563eb', '<path stroke-linecap="round" stroke-linejoin="round" d="M5 3l14 9-14 9V3z"/>'],
            ] as [$num, $title, $desc, $color, $icon])
            <div class="reveal step-card bg-white border border-gray-200 rounded-2xl p-5 sm:p-6 cursor-default">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-4 bg-gray-50 border border-gray-200">
                    <svg class="w-4.5 h-4.5 w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" style="color:{{ $color }}">
                        {!! $icon !!}
                    </svg>
                </div>
                <p class="text-[11px] font-black uppercase tracking-widest mb-2" style="color:{{ $color }}">Step {{ $num }}</p>
                <h3 class="text-[18px] font-black text-gray-900 mb-2">{{ $title }}</h3>
                <p class="text-base text-gray-500 leading-relaxed">{{ $desc }}</p>
            </div>
            @endforeach
        </div>

    </div>
</section>


{{-- ════════════════════════════════════════════════════════════════
     5. PRICING — white bg, 3 cards
════════════════════════════════════════════════════════════════ --}}
<section class="bg-white py-20 sm:py-28 px-4 sm:px-6">
    <div class="max-w-7xl mx-auto">

        <div class="reveal text-center mb-14">
            <p class="text-xs font-bold text-blue-600 uppercase tracking-widest mb-4">Transparent Pricing</p>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight text-gray-900 mb-4">
                Simple, honest packages
            </h2>
            <p class="text-gray-500 max-w-[600px] mx-auto text-base">
                All prices are starting points. Every project is scoped and quoted based on your exact needs.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            {{-- Starter --}}
            <div class="reveal price-card bg-gray-50 border border-gray-200 rounded-2xl p-7 sm:p-8 flex flex-col">
                <div class="mb-6">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Starter</p>
                    <div class="flex items-end gap-1 mb-1">
                        <span class="text-3xl font-black text-gray-900">XAF 150K</span>
                    </div>
                    <p class="text-sm text-gray-400">Starting price · per project</p>
                </div>
                <p class="text-base text-gray-600 leading-relaxed mb-6">
                    Perfect for startups and small businesses launching their first digital product.
                </p>
                <ul class="space-y-3 mb-8 flex-1">
                    @foreach([
                        'Landing page or simple website',
                        'Mobile-responsive design',
                        'Contact form & SEO basics',
                        'Up to 5 pages',
                        '2 rounds of revisions',
                        '1 month post-launch support',
                    ] as $f)
                    <li class="flex items-center gap-2.5 text-base text-gray-600">
                        <svg class="w-4 h-4 shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ $f }}
                    </li>
                    @endforeach
                </ul>
                <a href="{{ route('contact') }}"
                   class="block text-center py-3 rounded-xl border-2 border-gray-300 text-gray-700 text-sm font-bold
                          hover:border-blue-600 hover:text-blue-600 transition-colors duration-150">
                    Request Quote
                </a>
            </div>

            {{-- Professional (featured) --}}
            <div class="reveal price-card relative bg-[#0f172a] border border-slate-700 rounded-2xl p-7 sm:p-8 flex flex-col">
                <div class="absolute -top-3.5 left-1/2 -translate-x-1/2">
                    <span class="inline-block px-4 py-1 rounded-full bg-blue-600 text-white text-[11px] font-black uppercase tracking-widest shadow">
                        Most Popular
                    </span>
                </div>
                <div class="mb-6 mt-3">
                    <p class="text-xs font-bold text-blue-400 uppercase tracking-widest mb-3">Professional</p>
                    <div class="flex items-end gap-1 mb-1">
                        <span class="text-3xl font-black text-white">XAF 500K</span>
                    </div>
                    <p class="text-sm text-slate-400">Starting price · per project</p>
                </div>
                <p class="text-base text-slate-300 leading-relaxed mb-6">
                    For businesses ready to scale with a full-featured platform and premium design.
                </p>
                <ul class="space-y-3 mb-8 flex-1">
                    @foreach([
                        'Full website or web application',
                        'Custom UI/UX design system',
                        'Admin dashboard included',
                        'CMS / blog / dynamic content',
                        'API integrations',
                        'Unlimited revisions',
                        '3 months post-launch support',
                    ] as $f)
                    <li class="flex items-center gap-2.5 text-base text-slate-300">
                        <svg class="w-4 h-4 shrink-0 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ $f }}
                    </li>
                    @endforeach
                </ul>
                <a href="{{ route('contact') }}"
                   class="btn-primary block text-center py-3 rounded-xl text-white text-sm font-bold">
                    Start a Project
                </a>
            </div>

            {{-- Enterprise --}}
            <div class="reveal price-card bg-gray-50 border border-gray-200 rounded-2xl p-7 sm:p-8 flex flex-col">
                <div class="mb-6">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Enterprise</p>
                    <div class="flex items-end gap-1 mb-1">
                        <span class="text-3xl font-black text-gray-900">Custom</span>
                    </div>
                    <p class="text-sm text-gray-400">Scoped per project</p>
                </div>
                <p class="text-base text-gray-600 leading-relaxed mb-6">
                    Large-scale platforms, SaaS products, mobile apps, and bespoke enterprise solutions.
                </p>
                <ul class="space-y-3 mb-8 flex-1">
                    @foreach([
                        'Mobile app (iOS + Android)',
                        'SaaS platform with billing',
                        'Dedicated project manager',
                        'Custom integrations & APIs',
                        'Load testing & security audit',
                        'Priority support SLA',
                        '6+ months support plan',
                    ] as $f)
                    <li class="flex items-center gap-2.5 text-base text-gray-600">
                        <svg class="w-4 h-4 shrink-0 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ $f }}
                    </li>
                    @endforeach
                </ul>
                <a href="{{ route('contact') }}"
                   class="block text-center py-3 rounded-xl border-2 border-green-600 text-green-700 text-sm font-bold
                          hover:bg-green-600 hover:text-white transition-colors duration-150">
                    Contact Us
                </a>
            </div>

        </div>
    </div>
</section>


{{-- ════════════════════════════════════════════════════════════════
     6. WHY CHOOSE US — #f8f9fa, feature rows
════════════════════════════════════════════════════════════════ --}}
<section class="bg-[#f8f9fa] py-20 sm:py-28 px-4 sm:px-6">
    <div class="max-w-5xl mx-auto">

        <div class="reveal text-center mb-14">
            <p class="text-xs font-bold text-blue-600 uppercase tracking-widest mb-4">The Roddy Advantage</p>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight text-gray-900 mb-4">
                Why work with us?
            </h2>
            <p class="text-gray-500 max-w-[600px] mx-auto text-base">
                We don't just deliver code we deliver outcomes tied to your business goals.
            </p>
        </div>

        <div class="space-y-3">
            @foreach([
                ['01', 'Fast Delivery',              '#2563eb', 'We ship production-ready products at speed without cutting corners. Agile sprints, weekly demos, disciplined velocity.',            '<path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>'],
                ['02', 'Premium UI/UX',              '#059669', 'Every pixel has a purpose. We design for clarity, beauty, and conversion products your users will love from first touch.',       '<path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>'],
                ['03', 'Scalable Systems',           '#2563eb', 'We build with tomorrow in mind. Clean code, solid patterns, and infrastructure that grows as seamlessly as your business does.', '<path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>'],
                ['04', 'Business-Focused Approach',  '#059669', 'We don\'t just deliver code we deliver outcomes. Every feature ties directly to a business goal, KPI, or growth lever.',        '<path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>'],
                ['05', 'Dedicated Support',          '#2563eb', 'Launch is just the beginning. Proactive maintenance, performance monitoring, and a team that stays with you long after go-live.',  '<path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>'],
            ] as [$num, $title, $color, $desc, $icon])
            <div class="reveal feature-row group flex items-start gap-4 sm:gap-6 p-5 sm:p-6 bg-white border border-gray-100">
                <div class="shrink-0 w-9 h-9 rounded-xl bg-gray-50 border border-gray-100
                            flex items-center justify-center text-xs font-black" style="color:{{ $color }}">
                    {{ $num }}
                </div>
                <div class="shrink-0 w-9 h-9 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" style="color:{{ $color }}">
                        {!! $icon !!}
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-[18px] font-black text-gray-900 mb-1">{{ $title }}</h3>
                    <p class="text-base text-gray-500 leading-relaxed max-w-[600px]">{{ $desc }}</p>
                </div>
                <div class="hidden sm:flex shrink-0 w-8 h-8 rounded-lg bg-gray-50 border border-gray-100
                            items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-150">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" style="color:{{ $color }}">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>


{{-- ════════════════════════════════════════════════════════════════
     7. CTA — dark #0f172a, no gradients
════════════════════════════════════════════════════════════════ --}}
<section class="bg-[#0f172a] py-20 sm:py-28 px-4 sm:px-6">
    <div class="max-w-3xl mx-auto text-center">

        <div class="reveal inline-flex items-center gap-2 mb-7 px-4 py-1.5 rounded-full
                    bg-blue-900/40 border border-blue-800 text-blue-300 text-xs font-bold uppercase tracking-widest">
            <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
            Let's Build Together
        </div>

        <h2 class="reveal text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight text-white
                   leading-[1.07] mb-6 max-w-[600px] mx-auto">
            Have a project in mind?
        </h2>

        <p class="reveal text-slate-400 text-base sm:text-lg mb-10 max-w-[560px] mx-auto leading-relaxed">
            Let's build something powerful together. Tell us what you're building and we'll
            scope it and respond within 24 hours.
        </p>

        <div class="reveal flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('contact') }}"
               class="btn-primary w-full sm:w-auto px-8 py-3.5 rounded-xl text-white text-sm font-bold text-center">
                Start a Project
            </a>
            <a href="{{ route('contact') }}"
               class="btn-ghost w-full sm:w-auto px-8 py-3.5 rounded-xl border border-slate-600 text-white text-sm font-bold text-center">
                Contact Us
            </a>
        </div>

        <div class="reveal mt-14 flex flex-col sm:flex-row items-center justify-center gap-5 sm:gap-10">
            @foreach(['50+ Projects Delivered', '30+ Happy Clients', '24h Response Time'] as $proof)
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
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
    }, { threshold: 0.08 });
    els.forEach(function (el) { io.observe(el); });
}());
</script>

</x-layouts.public>
