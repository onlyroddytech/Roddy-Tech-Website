{{--
    ┌──────────────────────────────────────────────────────────────────┐
    │  TEAM PAGE  —  resources/views/public/team.blade.php             │
    │                                                                  │
    │  Sections:                                                       │
    │   1. HERO        — white bg, bold heading, gradient text         │
    │   2. LEADERSHIP  — top 4 members, large glass cards              │
    │   3. TEAM GRID   — remaining members, 4-col compact grid         │
    │   4. CULTURE     — 4 values with icons                           │
    │   5. CTA         — dark banner, join us                          │
    │                                                                  │
    │  Design: Apple-style, clean, premium — Tailwind + Alpine.js      │
    └──────────────────────────────────────────────────────────────────┘
--}}
<x-layouts.public title="Our Team">

{{-- ═══════════════════════════════════════════════════════════════
     STYLES
════════════════════════════════════════════════════════════════ --}}
<style>
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(28px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes scaleIn {
        from { opacity: 0; transform: scale(0.94); }
        to   { opacity: 1; transform: scale(1); }
    }
    @keyframes dotPulse {
        0%, 100% { opacity: 0.5; transform: scale(1); }
        50%       { opacity: 1;   transform: scale(1.4); }
    }

    /* Entrance stagger for hero */
    .hero-badge  { animation: fadeUp 0.6s cubic-bezier(0.22,1,0.36,1) 0.05s both; }
    .hero-h1     { animation: fadeUp 0.7s cubic-bezier(0.22,1,0.36,1) 0.18s both; }
    .hero-sub    { animation: fadeUp 0.7s cubic-bezier(0.22,1,0.36,1) 0.30s both; }
    .hero-stats  { animation: fadeUp 0.7s cubic-bezier(0.22,1,0.36,1) 0.42s both; }

    /* Scroll reveal */
    .reveal {
        opacity: 0;
        transform: translateY(22px);
        transition: opacity 0.6s cubic-bezier(0.22,1,0.36,1),
                    transform 0.6s cubic-bezier(0.22,1,0.36,1);
    }
    .reveal.visible { opacity: 1; transform: translateY(0); }

    /* Leadership cards */
    .leader-card {
        background: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 24px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.05), 0 8px 32px rgba(0,0,0,0.04);
        transition: transform 0.22s cubic-bezier(0.22,1,0.36,1),
                    box-shadow 0.22s cubic-bezier(0.22,1,0.36,1),
                    border-color 0.22s ease;
    }
    .leader-card:hover {
        transform: translateY(-8px) scale(1.01);
        box-shadow: 0 20px 60px rgba(37,99,235,0.12), 0 8px 24px rgba(0,0,0,0.08);
        border-color: #bfdbfe;
    }
    .leader-card:hover .leader-avatar-ring {
        box-shadow: 0 0 0 3px #fff, 0 0 0 5px rgba(37,99,235,0.30);
    }

    /* Team member cards (compact grid) */
    .member-card {
        background: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 18px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.04);
        transition: transform 0.20s cubic-bezier(0.22,1,0.36,1),
                    box-shadow 0.20s cubic-bezier(0.22,1,0.36,1),
                    border-color 0.20s ease;
    }
    .member-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 36px rgba(37,99,235,0.10);
        border-color: #c7d2fe;
    }

    /* Role badge */
    .role-badge {
        display: inline-flex;
        align-items: center;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }
    .role-badge-blue   { background: #eff6ff; color: #2563eb; }
    .role-badge-green  { background: #f0fdf4; color: #059669; }
    .role-badge-purple { background: #faf5ff; color: #7c3aed; }
    .role-badge-orange { background: #fff7ed; color: #d97706; }
    .role-badge-pink   { background: #fdf2f8; color: #db2777; }
    .role-badge-teal   { background: #ecfeff; color: #0891b2; }

    /* Founder badge */
    .founder-badge {
        position: absolute;
        top: -10px;
        left: 50%;
        transform: translateX(-50%);
        background: linear-gradient(135deg, #2563eb, #059669);
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        padding: 3px 12px;
        border-radius: 999px;
        white-space: nowrap;
        box-shadow: 0 4px 12px rgba(37,99,235,0.30);
    }

    /* Value cards */
    .value-card {
        border-radius: 20px;
        border: 1px solid #f1f5f9;
        background: #ffffff;
        transition: transform 0.20s cubic-bezier(0.22,1,0.36,1),
                    box-shadow 0.20s ease,
                    border-color 0.20s ease;
    }
    .value-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(0,0,0,0.07);
        border-color: #e0e7ff;
    }

    /* Social icon buttons */
    .social-btn {
        width: 32px;
        height: 32px;
        border-radius: 9px;
        border: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        transition: color 0.16s ease, background 0.16s ease, border-color 0.16s ease;
    }
    .social-btn:hover {
        color: #2563eb;
        background: #eff6ff;
        border-color: #bfdbfe;
    }

    /* Animated glow dots in hero */
    .glow-dot {
        animation: dotPulse 2.8s ease-in-out infinite;
    }
    .glow-dot:nth-child(2) { animation-delay: 0.6s; }
    .glow-dot:nth-child(3) { animation-delay: 1.2s; }
</style>

{{-- ═══════════════════════════════════════════════════════════════
     1. HERO
════════════════════════════════════════════════════════════════ --}}
<section class="relative bg-white overflow-hidden pt-32 pb-24 px-6">

    {{-- Dot grid background --}}
    <div class="absolute inset-0 pointer-events-none"
         style="background-image: radial-gradient(circle, rgba(0,0,0,0.07) 1.5px, transparent 1.5px); background-size: 30px 30px;"></div>

    {{-- Ambient glow top-right --}}
    <div class="absolute top-0 right-0 w-[600px] h-[500px] pointer-events-none"
         style="background: radial-gradient(ellipse at top right, rgba(37,99,235,0.07) 0%, transparent 65%);"></div>

    {{-- Ambient glow bottom-left --}}
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] pointer-events-none"
         style="background: radial-gradient(ellipse at bottom left, rgba(16,185,129,0.06) 0%, transparent 65%);"></div>

    <div class="relative max-w-4xl mx-auto text-center">

        {{-- Badge pill --}}
        <div class="hero-badge inline-flex items-center gap-2 mb-7 px-4 py-2 rounded-full bg-blue-50 border border-blue-100">
            <span class="flex gap-1 items-center">
                <span class="glow-dot w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                <span class="glow-dot w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                <span class="glow-dot w-1.5 h-1.5 rounded-full bg-blue-400"></span>
            </span>
            <span class="text-xs font-semibold text-blue-700 tracking-widest uppercase">The Minds Behind Roddy</span>
        </div>

        {{-- Heading --}}
        <h1 class="hero-h1 text-[2.6rem] sm:text-6xl font-black tracking-tight text-gray-900 leading-[1.06] mb-6">
            Meet the Team<br>
            <span class="bg-gradient-to-r from-blue-600 via-blue-500 to-emerald-500 bg-clip-text text-transparent">
                Behind Innovation
            </span>
        </h1>

        {{-- Subtext --}}
        <p class="hero-sub text-lg text-gray-500 max-w-xl mx-auto leading-relaxed mb-10">
            A focused, passionate group of engineers, designers, and strategists building Africa's next generation of digital products.
        </p>

        {{-- Stats row --}}
        <div class="hero-stats inline-flex items-center gap-8 sm:gap-12 px-8 py-4 rounded-2xl bg-white border border-gray-100 shadow-sm">
            <div class="text-center">
                <p class="text-2xl font-black text-gray-900">{{ $members->count() }}+</p>
                <p class="text-xs text-gray-400 font-medium mt-0.5">Team Members</p>
            </div>
            <div class="w-px h-8 bg-gray-100"></div>
            <div class="text-center">
                <p class="text-2xl font-black text-gray-900">3+</p>
                <p class="text-xs text-gray-400 font-medium mt-0.5">Years Building</p>
            </div>
            <div class="w-px h-8 bg-gray-100"></div>
            <div class="text-center">
                <p class="text-2xl font-black text-gray-900">50+</p>
                <p class="text-xs text-gray-400 font-medium mt-0.5">Projects Shipped</p>
            </div>
        </div>

    </div>
</section>

@php
    $leaders  = $members->take(4);
    $theRest  = $members->skip(4);
    $palettes = ['blue','green','purple','orange','pink','teal'];
    $roleBadgeColors = [
        'founder' => 'role-badge-blue',
        'ceo'     => 'role-badge-blue',
        'cto'     => 'role-badge-purple',
        'lead'    => 'role-badge-green',
        'design'  => 'role-badge-pink',
        'market'  => 'role-badge-orange',
        'default' => 'role-badge-teal',
    ];
    function teamRoleBadge(string $role, array $map): string {
        $r = strtolower($role);
        foreach ($map as $key => $cls) {
            if (str_contains($r, $key)) return $cls;
        }
        return $map['default'];
    }
    $avatarGradients = [
        ['from' => '#2563eb', 'to' => '#3b82f6'],
        ['from' => '#059669', 'to' => '#10b981'],
        ['from' => '#7c3aed', 'to' => '#8b5cf6'],
        ['from' => '#d97706', 'to' => '#f59e0b'],
        ['from' => '#db2777', 'to' => '#ec4899'],
        ['from' => '#0891b2', 'to' => '#06b6d4'],
    ];
@endphp

{{-- ═══════════════════════════════════════════════════════════════
     2. LEADERSHIP
════════════════════════════════════════════════════════════════ --}}
@if($leaders->count())
<section class="bg-white py-24 px-6">
    <div class="max-w-6xl mx-auto">

        {{-- Section header --}}
        <div class="reveal text-center mb-16">
            <p class="text-xs font-bold text-blue-600 uppercase tracking-widest mb-4">Core Leadership</p>
            <h2 class="text-3xl sm:text-[2.6rem] font-black tracking-tight text-gray-900 leading-[1.1] mb-4">
                The People Driving<br class="hidden sm:block"> the Vision
            </h2>
            <p class="text-base text-gray-500 max-w-md mx-auto">
                Leaders who shape our culture, set our standards, and build what others only imagine.
            </p>
        </div>

        {{-- Leadership cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-{{ min($leaders->count(), 4) }} gap-6 sm:gap-8">
            @foreach($leaders as $i => $member)
            @php
                $grad   = $avatarGradients[$i % count($avatarGradients)];
                $badgeCls = teamRoleBadge($member->role, $roleBadgeColors);
                $isFounder = str_contains(strtolower($member->role), 'founder') || str_contains(strtolower($member->role), 'ceo');
                $initials = collect(explode(' ', $member->name))->map(fn($w) => strtoupper($w[0] ?? ''))->take(2)->implode('');
            @endphp
            <div class="leader-card reveal p-7 sm:p-8 text-center relative" style="animation-delay: {{ $i * 80 }}ms">

                {{-- Founder badge --}}
                @if($isFounder)
                <div class="founder-badge">Founder</div>
                @endif

                {{-- Avatar --}}
                <div class="relative inline-block mb-6 mt-{{ $isFounder ? '4' : '0' }}">
                    @if($member->photo)
                        <img src="{{ asset('storage/' . $member->photo) }}"
                             alt="{{ $member->name }}"
                             class="leader-avatar-ring w-24 h-24 rounded-full object-cover mx-auto ring-2 ring-gray-100 transition-all duration-300">
                    @else
                        <div class="leader-avatar-ring w-24 h-24 rounded-full flex items-center justify-center mx-auto text-2xl font-black text-white transition-all duration-300"
                             style="background: linear-gradient(135deg, {{ $grad['from'] }}, {{ $grad['to'] }});">
                            {{ $initials }}
                        </div>
                    @endif
                    {{-- Online dot --}}
                    <span class="absolute bottom-1 right-1 w-3.5 h-3.5 rounded-full bg-emerald-400 border-2 border-white"></span>
                </div>

                {{-- Name --}}
                <h3 class="text-lg font-bold text-gray-900 mb-1 tracking-tight">{{ $member->name }}</h3>

                {{-- Role badge --}}
                <span class="role-badge {{ $badgeCls }} mb-4 inline-block">{{ $member->role }}</span>

                {{-- Bio --}}
                @if($member->bio)
                <p class="text-sm text-gray-500 leading-relaxed mb-6 max-w-[240px] mx-auto">{{ Str::limit($member->bio, 100) }}</p>
                @endif

                {{-- Socials --}}
                @if($member->linkedin || $member->twitter)
                <div class="flex items-center justify-center gap-2">
                    @if($member->linkedin)
                    <a href="{{ $member->linkedin }}" target="_blank" class="social-btn">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </a>
                    @endif
                    @if($member->twitter)
                    <a href="{{ $member->twitter }}" target="_blank" class="social-btn">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                    </a>
                    @endif
                </div>
                @endif

                {{-- Gradient bottom line on hover --}}
                <div class="absolute bottom-0 left-8 right-8 h-px bg-gradient-to-r from-transparent via-blue-400/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity rounded-full"></div>

            </div>
            @endforeach
        </div>

    </div>
</section>
@endif

{{-- ═══════════════════════════════════════════════════════════════
     3. FULL TEAM GRID
════════════════════════════════════════════════════════════════ --}}
@if($theRest->count())
<section class="py-24 px-6" style="background: #f8fafc;">
    <div class="max-w-6xl mx-auto">

        <div class="reveal text-center mb-14">
            <p class="text-xs font-bold text-emerald-600 uppercase tracking-widest mb-4">The Full Team</p>
            <h2 class="text-3xl sm:text-[2.4rem] font-black tracking-tight text-gray-900 leading-[1.1]">
                Every Role, Every Craft
            </h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($theRest as $i => $member)
            @php
                $idx  = ($i + 4) % count($avatarGradients);
                $grad = $avatarGradients[$idx];
                $badgeCls = teamRoleBadge($member->role, $roleBadgeColors);
                $initials = collect(explode(' ', $member->name))->map(fn($w) => strtoupper($w[0] ?? ''))->take(2)->implode('');
            @endphp
            <div class="member-card reveal p-6 text-center" style="animation-delay: {{ ($i % 4) * 60 }}ms">

                {{-- Avatar --}}
                <div class="relative inline-block mb-4">
                    @if($member->photo)
                        <img src="{{ asset('storage/' . $member->photo) }}"
                             alt="{{ $member->name }}"
                             class="w-16 h-16 rounded-2xl object-cover mx-auto">
                    @else
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto text-base font-black text-white"
                             style="background: linear-gradient(135deg, {{ $grad['from'] }}, {{ $grad['to'] }});">
                            {{ $initials }}
                        </div>
                    @endif
                </div>

                <h3 class="text-sm font-bold text-gray-900 mb-1 tracking-tight">{{ $member->name }}</h3>
                <span class="role-badge {{ $badgeCls }}">{{ $member->role }}</span>

                @if($member->bio)
                <p class="text-xs text-gray-400 leading-relaxed mt-3">{{ Str::limit($member->bio, 75) }}</p>
                @endif

                @if($member->linkedin || $member->twitter)
                <div class="flex items-center justify-center gap-2 mt-4">
                    @if($member->linkedin)
                    <a href="{{ $member->linkedin }}" target="_blank" class="social-btn">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </a>
                    @endif
                    @if($member->twitter)
                    <a href="{{ $member->twitter }}" target="_blank" class="social-btn">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                    </a>
                    @endif
                </div>
                @endif

            </div>
            @endforeach
        </div>

    </div>
</section>
@endif

{{-- ═══════════════════════════════════════════════════════════════
     EMPTY STATE (no members in DB)
════════════════════════════════════════════════════════════════ --}}
@if($members->isEmpty())
<section class="bg-white py-32 px-6 text-center">
    <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6 bg-blue-50">
        <svg class="w-7 h-7 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
    </div>
    <h3 class="text-xl font-bold text-gray-900 mb-2">Team coming soon</h3>
    <p class="text-gray-400 text-sm">We're building something great — check back shortly.</p>
</section>
@endif

{{-- ═══════════════════════════════════════════════════════════════
     4. CULTURE / VALUES
════════════════════════════════════════════════════════════════ --}}
<section class="bg-white py-24 px-6">
    <div class="max-w-6xl mx-auto">

        <div class="reveal text-center mb-16">
            <p class="text-xs font-bold text-purple-600 uppercase tracking-widest mb-4">How We Work</p>
            <h2 class="text-3xl sm:text-[2.6rem] font-black tracking-tight text-gray-900 leading-[1.1] mb-4">
                Our Culture
            </h2>
            <p class="text-base text-gray-500 max-w-md mx-auto">
                We don't just build products — we build a team that actually loves what it does.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

            {{-- Innovation --}}
            <div class="value-card reveal p-7">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-5 bg-blue-50">
                    <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-2">Innovation</h3>
                <p class="text-sm text-gray-500 leading-relaxed">We challenge the status quo and push boundaries to build what hasn't been built yet.</p>
            </div>

            {{-- Collaboration --}}
            <div class="value-card reveal p-7" style="transition-delay:80ms">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-5 bg-emerald-50">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-2">Collaboration</h3>
                <p class="text-sm text-gray-500 leading-relaxed">The best ideas come from a team that listens, builds on each other, and ships together.</p>
            </div>

            {{-- Growth --}}
            <div class="value-card reveal p-7" style="transition-delay:160ms">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-5 bg-orange-50">
                    <svg class="w-6 h-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-2">Growth</h3>
                <p class="text-sm text-gray-500 leading-relaxed">We invest in our people. Your career, skills, and ambitions grow alongside the company.</p>
            </div>

            {{-- Excellence --}}
            <div class="value-card reveal p-7" style="transition-delay:240ms">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-5 bg-purple-50">
                    <svg class="w-6 h-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-2">Excellence</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Good enough is never the goal. We obsess over craft, quality, and the details that matter.</p>
            </div>

        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     5. JOIN US CTA
════════════════════════════════════════════════════════════════ --}}
<section class="relative py-24 px-6 overflow-hidden" style="background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0f2d1f 100%);">

    {{-- Background rings --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full border border-white/[0.04]"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[900px] h-[900px] rounded-full border border-white/[0.03]"></div>
        <div class="absolute top-0 right-0 w-[400px] h-[400px]"
             style="background: radial-gradient(ellipse, rgba(37,99,235,0.14) 0%, transparent 65%);"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px]"
             style="background: radial-gradient(ellipse, rgba(16,185,129,0.10) 0%, transparent 65%);"></div>
    </div>

    <div class="relative max-w-2xl mx-auto text-center">

        <div class="reveal inline-flex items-center gap-2 mb-8 px-4 py-2 rounded-full border"
             style="background: rgba(16,185,129,0.10); border-color: rgba(16,185,129,0.24);">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
            <span class="text-xs font-semibold text-emerald-400 tracking-widest uppercase">We're Hiring</span>
        </div>

        <h2 class="reveal text-3xl sm:text-5xl font-black text-white tracking-tight leading-[1.08] mb-5">
            Want to build the<br>
            <span class="bg-gradient-to-r from-blue-400 to-emerald-400 bg-clip-text text-transparent">
                future with us?
            </span>
        </h2>

        <p class="reveal text-base text-gray-400 max-w-lg mx-auto leading-relaxed mb-10">
            We're always looking for talented people who care deeply about their craft and want to make a real impact. Let's talk.
        </p>

        <div class="reveal flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('contact') }}"
               class="inline-flex items-center gap-2.5 px-8 py-4 rounded-2xl text-sm font-bold text-white transition-all hover:scale-[1.03] hover:shadow-2xl"
               style="background: linear-gradient(135deg, #2563eb, #059669); box-shadow: 0 12px 40px rgba(37,99,235,0.35);">
                Join Roddy Technologies
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
            <a href="{{ route('about') }}"
               class="inline-flex items-center gap-2.5 px-8 py-4 rounded-2xl text-sm font-semibold border transition-all hover:scale-[1.02]"
               style="color: rgba(255,255,255,0.75); border-color: rgba(255,255,255,0.14); background: rgba(255,255,255,0.05);">
                Learn About Us
            </a>
        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     SCROLL REVEAL JS
════════════════════════════════════════════════════════════════ --}}
<script>
(function () {
    var els = document.querySelectorAll('.reveal');
    if (!els.length) return;
    var obs = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
                obs.unobserve(e.target);
            }
        });
    }, { threshold: 0.12 });
    els.forEach(function (el) { obs.observe(el); });
}());
</script>

</x-layouts.public>
