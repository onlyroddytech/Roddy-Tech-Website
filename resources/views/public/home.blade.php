{{--
    ┌─────────────────────────────────────────────────────────────┐
    │  HOME PAGE — resources/views/public/home.blade.php          │
    │                                                             │
    │  Sections (top → bottom):                                   │
    │   1. HERO          — two-column: left copy / right mockup   │
    │   2. PRODUCT STRIP — 4 owned platform cards                 │
    │   3. SERVICES      — dynamic from DB (if any)               │
    │   4. PRODUCTS      — dynamic from DB (if any)               │
    │   5. WHY CHOOSE US — 6 feature cards, 2×3 grid              │
    │   6. TESTIMONIALS  — dark section, dynamic from DB          │
    │   7. CTA           — final call-to-action banner            │
    │                                                             │
    │  JS at bottom: count-up animations + scroll reveal          │
    │  All animations: CSS keyframes, no external libraries        │
    │  Layout: Tailwind v4 + Alpine.js for interactivity          │
    └─────────────────────────────────────────────────────────────┘
--}}
<x-layouts.public title="Home">

{{-- ═══════════════════════════════════════════════════════
     HERO — Premium Apple × Stripe level
     Layout: two-column grid (left: copy | right: mockup image)
     Min-height: full viewport minus navbar (64px)
════════════════════════════════════════════════════════ --}}
<style>
    /*
     * ─────────────────────────────────────────────
     *  ENTRANCE ANIMATIONS
     *  heroFadeUp  → used by left-column elements (slide up + fade in)
     *  heroFadeIn  → used by right-column visual (scale up + fade in)
     * ─────────────────────────────────────────────
     */
    @keyframes heroFadeUp {
        from { opacity: 0; transform: translateY(26px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes heroFadeIn {
        /* Subtle scale ensures the mockup "grows in" rather than just appearing */
        from { opacity: 0; transform: scale(0.97); }
        to   { opacity: 1; transform: scale(1); }
    }

    /*
     * ─────────────────────────────────────────────
     *  FLOATING CARD ANIMATIONS
     *  Two variants: one tilts left (-1.5deg), the other tilts right (+1.5deg)
     *  The subtle rotation makes the float feel organic, not mechanical
     * ─────────────────────────────────────────────
     */
    @keyframes cardFloat {
        0%   { transform: translateY(0px)   rotate(-1.5deg); }
        50%  { transform: translateY(-11px) rotate(-0.5deg); }
        100% { transform: translateY(0px)   rotate(-1.5deg); }
    }
    @keyframes cardFloatAlt {
        0%   { transform: translateY(0px)  rotate(1.5deg); }
        50%  { transform: translateY(-8px) rotate(0.5deg); }
        100% { transform: translateY(0px)  rotate(1.5deg); }
    }

    /* Progress bar inside the "Active Projects" floating card — fills to 75% */
    @keyframes progressFill {
        from { width: 0%; }
        to   { width: 75%; }
    }

    /* Soft radial glow behind the mockup image — breathes in/out slowly */
    @keyframes glowPulse {
        0%, 100% { opacity: 0.12; transform: scale(1); }
        50%       { opacity: 0.20; transform: scale(1.06); }
    }

    /* Scroll mouse dot — slides down then fades, loops to indicate scroll action */
    @keyframes scrollDot {
        0%   { transform: translateY(0px);  opacity: 1; }
        70%  { transform: translateY(10px); opacity: 0; }
        100% { transform: translateY(0px);  opacity: 0; }
    }
    .scroll-dot { animation: scrollDot 1.9s ease-in-out infinite; }

    /*
     * ─────────────────────────────────────────────
     *  HERO LEFT-COLUMN STAGGER
     *  Each element enters 120–130ms after the previous one.
     *  cubic-bezier(0.22,1,0.36,1) = spring-like "overshoot" feel (Apple style)
     *  "both" = applies animation state before AND after it plays
     * ─────────────────────────────────────────────
     */
    .hero-badge  { animation: heroFadeUp 0.65s cubic-bezier(0.22,1,0.36,1) 0.05s both; }
    .hero-h1     { animation: heroFadeUp 0.70s cubic-bezier(0.22,1,0.36,1) 0.18s both; }
    .hero-sub    { animation: heroFadeUp 0.70s cubic-bezier(0.22,1,0.36,1) 0.30s both; }
    .hero-ctas   { animation: heroFadeUp 0.70s cubic-bezier(0.22,1,0.36,1) 0.40s both; }
    .hero-trust  { animation: heroFadeUp 0.70s cubic-bezier(0.22,1,0.36,1) 0.50s both; }
    .hero-stats  { animation: heroFadeUp 0.70s cubic-bezier(0.22,1,0.36,1) 0.58s both; }

    /* Right column fades in slightly after the left side starts */
    .hero-visual { animation: heroFadeIn 1s cubic-bezier(0.22,1,0.36,1) 0.25s both; }

    /* Floating cards — different durations so they never sync (avoids robotic look) */
    .card-float     { animation: cardFloat    5.5s ease-in-out 1.2s infinite; }
    .card-float-alt { animation: cardFloatAlt 6.5s ease-in-out 2.2s infinite; }

    /* Progress bar inside floating card — delayed to start after hero entrance */
    .progress-bar { animation: progressFill 1.6s cubic-bezier(0.22,1,0.36,1) 1.4s both; }

    /* Glow behind mockup */
    .hero-glow { animation: glowPulse 5s ease-in-out infinite; }

    /*
     * ─────────────────────────────────────────────
     *  BADGE PILL (rotating message strip)
     *  Glass morphism: semi-transparent white + blur + blue border tint
     *  inset box-shadow = inner top highlight (makes it feel raised)
     *  Alpine.js handles the message rotation (see badge HTML below)
     * ─────────────────────────────────────────────
     */
    .badge-pill {
        background: rgba(255,255,255,0.78);
        backdrop-filter: blur(14px) saturate(180%);
        -webkit-backdrop-filter: blur(14px) saturate(180%);
        border: 1px solid rgba(37,99,235,0.18);
        box-shadow: 0 2px 14px rgba(37,99,235,0.09), inset 0 1px 0 rgba(255,255,255,0.9);
        transition: transform 0.22s ease, box-shadow 0.22s ease;
    }
    .badge-pill:hover {
        transform: scale(1.04);
        box-shadow: 0 6px 28px rgba(37,99,235,0.20), inset 0 1px 0 rgba(255,255,255,0.9);
    }
    /* Controls the fade+slide of the rotating text inside the badge */
    .badge-text {
        transition: opacity 0.25s ease, transform 0.25s ease;
    }

    /*
     * ─────────────────────────────────────────────
     *  CTA BUTTONS
     *  Primary  → blue gradient, lifts on hover with deep blue glow
     *  Secondary → white outline, lifts on hover with light fill
     *  Both snap back on :active (tactile press feel)
     * ─────────────────────────────────────────────
     */
    .btn-primary {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        transition: transform 0.18s ease, box-shadow 0.18s ease;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 32px rgba(37,99,235,0.42) !important;
    }
    .btn-primary:active { transform: translateY(0px); }

    .btn-secondary { transition: transform 0.18s ease, border-color 0.18s ease, background 0.18s ease; }
    .btn-secondary:hover { transform: translateY(-2px); border-color: #d1d5db; background: #f9fafb; }
    .btn-secondary:active { transform: translateY(0px); }

    /*
     * ─────────────────────────────────────────────
     *  GLASS CARDS (floating mockup overlays)
     *  Applied to the two floating cards over the mockup image.
     *  backdrop-filter gives the frosted glass look (iOS/macOS style)
     * ─────────────────────────────────────────────
     */
    .glass-card { transition: transform 0.22s ease, box-shadow 0.22s ease; }
    .glass-card:hover {
        box-shadow: 0 16px 48px rgba(0,0,0,0.16), inset 0 1px 0 rgba(255,255,255,0.9) !important;
    }

    /*
     * STAT CARDS — 4 glassy cards at the bottom of the hero left column
     * Glass recipe: semi-white + backdrop-blur + white border + inner highlight
     * Numbers inside use gradient text (blue or green). Count-up runs via JS below.
     */
    .stat-card {
        background: rgba(255,255,255,0.62);
        backdrop-filter: blur(14px) saturate(180%);
        -webkit-backdrop-filter: blur(14px) saturate(180%);
        border: 1px solid rgba(255,255,255,0.75);
        box-shadow: 0 2px 12px rgba(0,0,0,0.06), inset 0 1px 0 rgba(255,255,255,0.9);
        transition: transform 0.22s ease, box-shadow 0.22s ease;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 28px rgba(37,99,235,0.12), inset 0 1px 0 rgba(255,255,255,0.9);
    }

    /*
     * TRUST AVATAR GLOW RINGS
     * Double box-shadow trick: layer 1 = white gap, layer 2 = colored glow ring
     * Each avatar color has its own ring tint (blue, green, dark)
     */
    .trust-avatar-blue  { box-shadow: 0 0 0 2px #fff, 0 0 0 3.5px rgba(37,99,235,0.30); }
    .trust-avatar-green { box-shadow: 0 0 0 2px #fff, 0 0 0 3.5px rgba(16,185,129,0.32); }
    .trust-avatar-dark  { box-shadow: 0 0 0 2px #fff, 0 0 0 3.5px rgba(30,41,59,0.22); }

    /*
     * SCROLL MOUSE INDICATOR (bottom-center of hero)
     * Dot slides down inside the mouse outline and fades at 70% travel
     * Resets to top and loops — gives a continuous "scroll down" hint
     */
    @keyframes scrollDot {
        0%   { transform: translateY(0px);  opacity: 1; }
        70%  { transform: translateY(10px); opacity: 0; }
        100% { transform: translateY(0px);  opacity: 0; }
    }
    .scroll-dot { animation: scrollDot 1.9s ease-in-out infinite; }

    /* Product strip — logos/favicons will be dynamic later */

    /*
     * SERVICE CARDS — Apple glass
     * backdrop-filter gives the frosted look; needs a non-white section bg to show.
     * Inner top highlight (inset 0 1px) = the "raised edge" illusion from macOS.
     * Featured (1 & 3): stronger blue tint + bolder border + deeper glow.
     */
    .svc-card {
        background: #ffffff;
        border: 1px solid #e5eaf2;
        border-radius: 18px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 6px 20px rgba(0,0,0,0.05);
        transition: transform 0.28s cubic-bezier(0.22,1,0.36,1), box-shadow 0.28s ease, border-color 0.28s ease;
    }
    .svc-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 40px rgba(37,99,235,0.10), 0 4px 12px rgba(0,0,0,0.06);
        border-color: rgba(37,99,235,0.18);
    }
    .svc-card-featured, .svc-card-green { background: #ffffff !important; }
    .svc-check {
        flex-shrink: 0;
        width: 17px;
        height: 17px;
        color: #10b981;
    }
    .product-item {
        transition: transform 0.22s cubic-bezier(0.34,1.56,0.64,1);
        cursor: pointer;
        -webkit-tap-highlight-color: transparent; /* removes blue flash on mobile tap */
    }
    .product-item:hover  { transform: translateY(-8px); }
    .product-item:active { transform: translateY(-4px); } /* touch feedback on mobile */

    /*
     * PROJECT CARDS
     * Large rounded cards with image on top, content below.
     * Image wrapper clips zoom on hover via overflow:hidden.
     * Overlay fades in on hover — dark gradient + "View Project" label.
     * Card lifts -10px with stronger shadow on hover.
     */
    .proj-card {
        background: rgba(255,255,255,0.76);
        backdrop-filter: blur(22px) saturate(200%);
        -webkit-backdrop-filter: blur(22px) saturate(200%);
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.72);
        box-shadow: 0 2px 12px rgba(0,0,0,0.05), 0 10px 40px rgba(0,0,0,0.08), inset 0 1px 0 rgba(255,255,255,0.96);
        transition: transform 0.32s cubic-bezier(0.22,1,0.36,1), box-shadow 0.32s ease;
    }
    .proj-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 28px 70px rgba(0,0,0,0.13), 0 10px 28px rgba(37,99,235,0.10), inset 0 1px 0 rgba(255,255,255,0.96);
    }
    .proj-img-wrap { overflow: hidden; position: relative; }
    .proj-img-wrap img {
        transition: transform 0.55s cubic-bezier(0.22,1,0.36,1);
        display: block; width: 100%; height: 100%; object-fit: cover;
    }
    .proj-card:hover .proj-img-wrap img { transform: scale(1.06); }
    .proj-overlay {
        position: absolute; inset: 0;
        background: linear-gradient(180deg, rgba(15,23,42,0) 30%, rgba(15,23,42,0.72) 100%);
        opacity: 0;
        transition: opacity 0.32s ease;
        display: flex; align-items: flex-end; padding: 20px;
    }
    .proj-card:hover .proj-overlay { opacity: 1; }

    /*
     * WEB DEV PROMO CARD
     * Animated bg gradient, pulsing rings, staggered chat messages
     * All timing uses animation-delay + fill-mode:both so opacity starts at 0
     */
    .webdev-bg {
        background: linear-gradient(135deg, #0e2259 0%, #0a1628 40%, #063d2e 80%, #0f2460 100%);
        background-size: 300% 300%;
        animation: webdevBgShift 9s ease infinite;
    }
    @keyframes webdevBgShift {
        0%, 100% { background-position: 0% 50%; }
        50%       { background-position: 100% 50%; }
    }
    /* Rings slowly pulse opacity + scale */
    /*
     * PRODUCT CARDS (spotlight section)
     * Glass + hover lift, icon scales on hover, arrow slides right
     */
    .prod-card {
        background: rgba(255,255,255,0.72);
        backdrop-filter: blur(20px) saturate(200%);
        -webkit-backdrop-filter: blur(20px) saturate(200%);
        border: 1px solid rgba(255,255,255,0.72);
        border-radius: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04), 0 8px 28px rgba(0,0,0,0.06), inset 0 1px 0 rgba(255,255,255,0.96);
        transition: transform 0.28s cubic-bezier(0.22,1,0.36,1), box-shadow 0.28s ease;
        display: block;
        text-decoration: none;
    }
    .prod-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 52px rgba(37,99,235,0.12), 0 8px 20px rgba(0,0,0,0.07), inset 0 1px 0 rgba(255,255,255,0.96);
    }
    .prod-card:hover .prod-icon { transform: scale(1.10); }
    .prod-icon { transition: transform 0.28s cubic-bezier(0.34,1.56,0.64,1); }
    .prod-arrow { transition: transform 0.22s ease; }
    .prod-card:hover .prod-arrow { transform: translateX(4px); }

    .webdev-ring   { animation: ringPulse 6s ease-in-out infinite; }
    .webdev-ring-2 { animation: ringPulse 7s ease-in-out 1.5s infinite; }
    .webdev-ring-3 { animation: ringPulse 8s ease-in-out 3s infinite; }
    @keyframes ringPulse {
        0%, 100% { opacity: 0.04; transform: translateY(-50%) scale(1); }
        50%       { opacity: 0.08; transform: translateY(-50%) scale(1.05); }
    }
    /* Chat message entrance */
    @keyframes chatMsgIn {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    /* Typing indicator: fades in, holds, then fades out before next message */
    @keyframes typingShow {
        0%   { opacity: 0; transform: translateY(8px); }
        12%  { opacity: 1; transform: translateY(0); }
        80%  { opacity: 1; }
        100% { opacity: 0; }
    }
    /* Staggered message timing */
    .chat-msg-1     { opacity:0; animation: chatMsgIn 0.55s cubic-bezier(0.22,1,0.36,1) 0.5s  both; }
    .chat-msg-2     { opacity:0; animation: chatMsgIn 0.55s cubic-bezier(0.22,1,0.36,1) 2.6s  both; }
    .chat-msg-3     { opacity:0; animation: chatMsgIn 0.55s cubic-bezier(0.22,1,0.36,1) 3.7s  both; }
    .chat-msg-4     { opacity:0; animation: chatMsgIn 0.55s cubic-bezier(0.22,1,0.36,1) 6.0s  both; }
    .chat-typing-1  { opacity:0; animation: typingShow 1.5s ease 1.4s both; }
    .chat-typing-2  { opacity:0; animation: typingShow 1.5s ease 4.6s both; }
    .chat-typing-f  { opacity:0; animation: chatMsgIn 0.55s ease 7.2s both; }
    /* Avatar hover bounce */
    .chat-av { transition: transform 0.22s cubic-bezier(0.34,1.56,0.64,1); cursor: default; }
    .chat-av:hover { transform: scale(1.18); }
    /* CTA glow on hover */
    .webdev-cta { transition: transform 0.22s ease, box-shadow 0.22s ease, background 0.22s ease; }
    .webdev-cta:hover {
        transform: translateY(-3px) scale(1.02);
        background: rgba(255,255,255,0.18) !important;
        box-shadow: 0 12px 40px rgba(37,99,235,0.40), 0 6px 20px rgba(16,185,129,0.22), inset 0 1px 0 rgba(255,255,255,0.22) !important;
    }

    /* ── Global button system ── */
    .btn-primary {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        transition: transform 0.18s ease, box-shadow 0.18s ease;
    }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 32px rgba(37,99,235,0.42) !important; }
    .btn-primary:active { transform: translateY(0); }
    .btn-secondary { transition: transform 0.18s ease, border-color 0.18s ease, background 0.18s ease; }
    .btn-secondary:hover { transform: translateY(-2px); border-color: #d1d5db; background: #f9fafb; }
    .btn-secondary:active { transform: translateY(0); }
    /* Dark glass button (used on dark sections) */
    .btn-glass-dark {
        background: rgba(255,255,255,0.10);
        border: 1.5px solid rgba(255,255,255,0.22);
        color: #ffffff;
        backdrop-filter: blur(12px);
        box-shadow: 0 4px 20px rgba(0,0,0,0.22), inset 0 1px 0 rgba(255,255,255,0.15);
        transition: transform 0.20s ease, background 0.20s ease, box-shadow 0.20s ease;
    }
    .btn-glass-dark:hover {
        transform: translateY(-3px) scale(1.02);
        background: rgba(255,255,255,0.18);
        box-shadow: 0 12px 40px rgba(37,99,235,0.38), 0 6px 20px rgba(16,185,129,0.22), inset 0 1px 0 rgba(255,255,255,0.22);
    }
    /* ── Scroll reveal ── */
    /* Stagger delay helpers for grids */
    .reveal-d1 { transition-delay: 0.08s !important; }
    .reveal-d2 { transition-delay: 0.16s !important; }
    .reveal-d3 { transition-delay: 0.24s !important; }
    .reveal-d4 { transition-delay: 0.32s !important; }
    .reveal {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.65s cubic-bezier(0.22,1,0.36,1), transform 0.65s cubic-bezier(0.22,1,0.36,1);
    }
    .reveal.visible { opacity: 1; transform: translateY(0); }
</style>

<section class="relative bg-white overflow-hidden" style="min-height: calc(100vh - 80px);">

    {{-- Subtle star on the hero background grid --}}
    <div class="absolute inset-0 pointer-events-none"
         style="background-image: radial-gradient(circle, rgba(0,0,0,0.13) 1.5px, transparent 1.5px); background-size: 28px 28px;"></div>

    {{-- Ambient glow — blue top-right --}}
    <div class="absolute top-0 right-0 w-[680px] h-[680px] pointer-events-none"
         style="background: radial-gradient(ellipse at top right, rgba(37,99,235,0.10) 0%, transparent 60%);"></div>
    {{-- Ambient glow — green bottom-left --}}
    <div class="absolute bottom-0 left-0 w-[520px] h-[520px] pointer-events-none"
         style="background: radial-gradient(ellipse at bottom left, rgba(16,185,129,0.09) 0%, transparent 60%);"></div>

    <div class="max-w-[1360px] mx-auto px-6 w-full flex items-center" style="min-height: calc(100vh - 80px);">
        <div class="grid lg:grid-cols-[46fr_54fr] gap-12 xl:gap-16 items-center py-20 w-full">

            {{-- ── Left column ── --}}
            <div class="flex flex-col min-w-0">

                {{-- Badge --}}
                <div class="hero-badge self-start mb-7"
                     x-data="{
                         msgs: [
                             'Building Africa\'s Next Generation Tech Company',
                             'Scaling Digital Products Globally',
                             'Powering Startups & Businesses Worldwide'
                         ],
                         idx: 0,
                         show: true,
                         init() {
                             setInterval(() => {
                                 this.show = false;
                                 setTimeout(() => {
                                     this.idx = (this.idx + 1) % this.msgs.length;
                                     this.show = true;
                                 }, 260);
                             }, 3200);
                         }
                     }">
                    <div class="badge-pill inline-flex items-center gap-2.5 px-4 py-2 rounded-full cursor-default">
                        {{-- Live signal dot --}}
                        <span class="relative flex items-center justify-center w-2 h-2 shrink-0">
                            <span class="absolute inline-flex w-full h-full rounded-full bg-blue-500 opacity-40 animate-ping"></span>
                            <span class="relative w-2 h-2 rounded-full bg-blue-500"></span>
                        </span>
                        {{-- Rotating message --}}
                        <span class="badge-text text-[11.5px] font-medium text-blue-700 tracking-[-0.01em] whitespace-nowrap"
                              :style="{ opacity: show ? 1 : 0, transform: show ? 'translateY(0)' : 'translateY(4px)' }"
                              x-text="msgs[idx]">Building Africa's Next Generation Digital</span>
                    </div>
                </div>

                {{-- Headline --}}
                <h1 class="hero-h1 text-[3rem] lg:text-[4rem] font-bold leading-[1.06] tracking-[-0.035em] text-gray-900 mb-6">
                    {{ $cms['hero_title'] ?? 'We Build Powerful' }}<br>
                    <span style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                        {{ $cms['hero_tagline'] ?? 'Digital Products' }}
                    </span><br>
                    That Scale Globally
                </h1>

                {{-- Subtext --}}
                <p class="hero-sub text-[18px] text-gray-600 leading-[1.75] mb-9 max-w-[480px]">
                    {{ $cms['hero_subtitle'] ?? 'From websites to full-scale platforms — we help businesses launch, grow, and dominate online.' }}
                </p>

                {{-- CTAs --}}
                <div class="hero-ctas flex flex-wrap gap-3 mb-10">
                    <a href="{{ route('contact') }}"
                       class="btn-primary inline-flex items-center gap-2 px-6 py-3 rounded-[12px] text-[16px] font-semibold text-white"
                       style="background: #2563eb; box-shadow: 0 4px 20px rgba(37,99,235,0.28);">
                        Start a Project
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    <a href="{{ route('projects.index') }}"
                       class="btn-secondary inline-flex items-center gap-2 px-6 py-3 rounded-[12px] text-[16px] font-semibold text-gray-700 bg-white border border-gray-200 hover:border-gray-300 hover:bg-gray-50/80">
                        Explore Our Work
                        <svg class="w-4 h-4 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>

                {{-- Trust row --}}
                <div class="hero-trust flex items-center gap-3.5 mb-8">
                    <div class="flex -space-x-2.5">
                        <div class="w-8 h-8 rounded-full border-[2.5px] border-white flex items-center justify-center text-[9px] font-bold text-white shrink-0 trust-avatar-blue"
                             style="background: #2563eb;">S</div>
                        <div class="w-8 h-8 rounded-full border-[2.5px] border-white flex items-center justify-center text-[9px] font-bold text-white shrink-0 trust-avatar-green"
                             style="background: #10b981;">A</div>
                        <div class="w-8 h-8 rounded-full border-[2.5px] border-white flex items-center justify-center text-[9px] font-bold text-white shrink-0 trust-avatar-dark"
                             style="background: #000000;">K</div>
                        <div class="w-8 h-8 rounded-full border-[2.5px] border-white flex items-center justify-center text-[9px] font-bold text-white shrink-0 trust-avatar-blue"
                             style="background: #2563eb;">T</div>
                    </div>
                    <p class="text-[15px] text-gray-700 font-medium">Trusted by <span class="text-gray-800 font-semibold">startups, creators</span> & growing businesses</p>
                </div>

                {{-- Stats --}}
                <div class="hero-stats grid grid-cols-4 gap-3 pt-6 border-t border-gray-100/80">
                    @foreach([
                        ['50',  '+', 'Projects',  'linear-gradient(135deg,#2563eb,#1d4ed8)'],
                        ['30',  '+', 'Clients',   'linear-gradient(135deg,#10b981,#059669)'],
                        ['5',   '+', 'Years',     'linear-gradient(135deg,#2563eb,#1d4ed8)'],
                        ['99', '%', 'Uptime', 'linear-gradient(135deg,#10b981,#059669)'],
                    ] as $stat)
                    <div class="stat-card rounded-xl px-3.5 py-3">
                        <div class="text-[1.35rem] font-bold tracking-tight leading-none">
                            <span class="stat-num" data-target="{{ $stat[0] }}" data-suffix="{{ $stat[1] }}"
                                  style="background: {{ $stat[3] }}; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                                0{{ $stat[1] }}
                            </span>
                        </div>
                        <div class="text-[11px] text-gray-900 mt-1.5 font-medium">{{ $stat[2] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- ── Right column — UI Mockup ── --}}
            <div class="hero-visual relative hidden lg:block">

                {{-- Mockup image --}}
                <img src="{{ asset('images/hero-mockup.png') }}"
                     alt="Roddy Technologies Dashboard"
                     class="w-full h-auto relative z-10"
                     style="filter: drop-shadow(0 40px 80px rgba(0,0,0,0.15));">

                {{-- Floating card — Active Projects (top left) --}}
                <div class="card-float glass-card absolute left-4 top-2 w-[192px] rounded-2xl p-4 border border-white/70 z-20"
                     style="background: rgba(255,255,255,0.52); backdrop-filter: saturate(180%) blur(20px); -webkit-backdrop-filter: saturate(180%) blur(20px); box-shadow: 0 8px 32px rgba(0,0,0,0.11), inset 0 1px 0 rgba(255,255,255,0.85);">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-[11.5px] font-semibold text-gray-900">Active Projects</span>
                        <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                    </div>
                    <div class="text-[1.65rem] font-bold text-gray-900 leading-none mb-3">12 <span class="text-sm font-semibold text-green-600">↑ 4</span></div>
                    <div class="w-full rounded-full h-1.5 overflow-hidden" style="background: rgba(0,0,0,0.07);">
                        <div class="progress-bar h-1.5 rounded-full" style="background: linear-gradient(90deg, #2563eb, #10b981);"></div>
                    </div>
                    <p class="text-[10.5px] text-gray-700 mt-2 font-medium">75% on schedule</p>
                </div>

                {{-- Floating card — Payment Received (bottom right) --}}
                <div class="card-float-alt glass-card absolute right-1 bottom-2 w-[196px] rounded-2xl p-4 border border-white/70 z-20"
                     style="background: rgba(255,255,255,0.52); backdrop-filter: saturate(180%) blur(20px); -webkit-backdrop-filter: saturate(180%) blur(20px); box-shadow: 0 8px 32px rgba(0,0,0,0.11), inset 0 1px 0 rgba(255,255,255,0.85);">
                    <div class="flex items-center gap-2.5 mb-2.5">
                        <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0"
                             style="background: linear-gradient(135deg, #d1fae5, #a7f3d0);">
                            <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span class="text-[11.5px] font-semibold text-gray-900">Payment Received</span>
                    </div>
                    <div class="text-[1.35rem] font-bold text-gray-900 leading-tight">850,000
                        <span class="text-xs font-semibold text-gray-500 ml-0.5">XAF</span>
                    </div>
                    <p class="text-[10.5px] text-gray-700 mt-1.5 font-medium">Project milestone cleared ✓</p>
                </div>

                {{-- Glow behind mockup --}}
                <div class="hero-glow absolute -inset-8 -z-10 rounded-3xl blur-3xl"
                     style="background: radial-gradient(ellipse at 55% 50%, rgba(37,99,235,0.22) 0%, rgba(16,185,129,0.14) 55%, transparent 75%);"></div>
            </div>


        </div>
    </div>

    {{-- Scroll cue --}}
    <div class="absolute bottom-7 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2" style="opacity:0.75;">
        <span class="text-[9px] text-gray-900 tracking-[0.18em] uppercase font-semibold">Scroll</span>
        <svg class="w-[18px] h-[28px] text-gray-900" viewBox="0 0 20 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="1" y="1" width="18" height="30" rx="9" stroke="currentColor" stroke-width="1.5"/>
            <rect class="scroll-dot" x="8.5" y="6" width="3" height="6" rx="1.5" fill="currentColor"/>
        </svg>
    </div>

</section>

{{-- ═══════════════════════════════════════════════════════
     PRODUCT STRIP
════════════════════════════════════════════════════════ --}}
{{-- Product logos/favicons will be made dynamic later --}}
<section class="py-14 px-6 border-t border-gray-100" style="background:#e8e8ed;">
    <div class="max-w-[1360px] mx-auto">

        <div class="text-center mb-10">
            <p class="text-[18px] font-semibold uppercase tracking-[0.22em] text-blue-600">Platforms we own & operate</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">

            {{-- Rshop --}}
            <div class="product-item flex flex-col items-center gap-3">
                <div class="w-[72px] h-[72px] rounded-[18px] flex items-center justify-center"
                     style="background: linear-gradient(135deg, #2563eb, #1d4ed8);">
                    <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <span class="text-[16px] font-semibold text-gray-700">Rshop</span>
            </div>

            {{-- RTG Domains --}}
            <div class="product-item flex flex-col items-center gap-3">
                <div class="w-[72px] h-[72px] rounded-[18px] flex items-center justify-center"
                     style="background: linear-gradient(135deg, #10b981, #059669);">
                    <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="12" r="9"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.6 9h16.8M3.6 15h16.8M12 3c-2.5 3-4 5.7-4 9s1.5 6 4 9M12 3c2.5 3 4 5.7 4 9s-1.5 6-4 9"/>
                    </svg>
                </div>
                <span class="text-[16px] font-semibold text-gray-700">RTG Domains</span>
            </div>

            {{-- RhostitCloud --}}
            <div class="product-item flex flex-col items-center gap-3">
                <div class="w-[72px] h-[72px] rounded-[18px] flex items-center justify-center"
                     style="background: linear-gradient(135deg, #2563eb, #1d4ed8);">
                    <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                    </svg>
                </div>
                <span class="text-[16px] font-semibold text-gray-700">RhostitCloud</span>
            </div>

            {{-- Roddy AI --}}
            <div class="product-item flex flex-col items-center gap-3">
                <div class="w-[72px] h-[72px] rounded-[18px] flex items-center justify-center"
                     style="background: linear-gradient(135deg, #10b981, #059669);">
                    <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
                <span class="text-[16px] font-semibold text-gray-700">Roddy AI <span class="text-[10px] font-semibold text-green-600 ml-2.5">Soon</span></span>
            </div>

        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     SERVICES
════════════════════════════════════════════════════════ --}}
{{--
    SERVICES SECTION
    Static for now — 6 hardcoded services.
    Will be made dynamic (admin CMS) in a later phase.
    Cards stagger in on scroll via .svc-card + IntersectionObserver (see JS below).
--}}
<section class="relative py-28 px-6 overflow-hidden" style="background:#ffffff;">

    {{-- Ambient orbs that the glass cards blur over --}}
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[500px] pointer-events-none"
         style="background: radial-gradient(ellipse at center top, rgba(37,99,235,0.10) 0%, transparent 65%);"></div>
    <div class="absolute bottom-0 right-0 w-[500px] h-[400px] pointer-events-none"
         style="background: radial-gradient(ellipse at bottom right, rgba(16,185,129,0.08) 0%, transparent 65%);"></div>

    <div class="max-w-[1360px] mx-auto relative">

        {{-- Section header --}}
        <div class="text-center mb-16">
            <span class="inline-block text-[16px] font-semibold uppercase tracking-[0.2em] text-blue-600 mb-4">What We Do</span>
            <h2 class="text-[2.4rem] lg:text-[3rem] font-bold text-gray-900 tracking-tight leading-[1.1] mb-5">
                We Design, Build &amp; Scale<br>Digital Products
            </h2>
            <p class="text-[18px] text-gray-600 max-w-[540px] mx-auto leading-relaxed">
                From idea to launch, we help businesses create powerful digital solutions that grow globally.
            </p>
        </div>

        {{-- Outer container card — wraps all 6 service cards --}}
        <div class="rounded-[28px] p-5 md:p-7"
             style="background: rgba(255,255,255,0.48);
                    backdrop-filter: blur(28px) saturate(180%);
                    -webkit-backdrop-filter: blur(28px) saturate(180%);
                    border: 1px solid rgba(255,255,255,0.82);
                    box-shadow: 0 8px 40px rgba(0,0,0,0.07), 0 24px 64px rgba(0,0,0,0.05), inset 0 1px 0 rgba(255,255,255,0.98);">

        {{-- Services grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

            {{-- 1. Web Development --}}
            <div class="svc-card svc-card-featured p-8 cursor-default">
                <div class="w-[52px] h-[52px] rounded-xl flex items-center justify-center mb-6"
                     style="background:#eff6ff; border:1px solid #bfdbfe;">
                    <svg class="w-6 h-6" style="color:#2563eb;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                    </svg>
                </div>
                <h3 class="text-[18px] font-bold text-gray-900 mb-1.5">Web Development</h3>
                <p class="text-[14px] text-gray-500 mb-5 leading-relaxed">Scalable, modern web apps tailored to your exact business workflows.</p>
                <ul class="space-y-2.5">
                    @foreach(['Custom admin dashboards','REST API integration','Role-based access control','Mobile-responsive UI','Real-time notifications','Cloud deployment included'] as $f)
                    <li class="flex items-center gap-2.5 text-[14px] text-gray-700">
                        <svg class="svc-check" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        {{ $f }}
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- 2. Mobile App Development --}}
            <div class="svc-card svc-card-green p-8 cursor-default">
                <div class="w-[52px] h-[52px] rounded-xl flex items-center justify-center mb-6"
                     style="background:#ecfdf5; border:1px solid #a7f3d0;">
                    <svg class="w-6 h-6" style="color:#10b981;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-[18px] font-bold text-gray-900 mb-1.5">Mobile App Development</h3>
                <p class="text-[14px] text-gray-500 mb-5 leading-relaxed">Cross-platform iOS &amp; Android apps built with modern frameworks.</p>
                <ul class="space-y-2.5">
                    @foreach(['iOS & Android from one codebase','Offline-first architecture','Push notifications','In-app payments','App Store submission support','Backend API included'] as $f)
                    <li class="flex items-center gap-2.5 text-[14px] text-gray-700">
                        <svg class="svc-check" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        {{ $f }}
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- 3. SaaS Platforms --}}
            <div class="svc-card svc-card-featured p-8 cursor-default">
                <div class="w-[52px] h-[52px] rounded-xl flex items-center justify-center mb-6"
                     style="background:#eff6ff; border:1px solid #bfdbfe;">
                    <svg class="w-6 h-6" style="color:#2563eb;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7C5 4 4 5 4 7zm0 5h16M9 4v16"/>
                    </svg>
                </div>
                <h3 class="text-[18px] font-bold text-gray-900 mb-1.5">SaaS Platforms</h3>
                <p class="text-[14px] text-gray-500 mb-5 leading-relaxed">Full-scale software-as-a-service products built to handle real users at scale.</p>
                <ul class="space-y-2.5">
                    @foreach(['Multi-tenant architecture','Subscription & billing system','Role & permissions engine','Analytics dashboard','White-label ready','99.9% uptime SLA'] as $f)
                    <li class="flex items-center gap-2.5 text-[14px] text-gray-700">
                        <svg class="svc-check" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        {{ $f }}
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- 4. UI/UX Design --}}
            <div class="svc-card svc-card-green p-8 cursor-default">
                <div class="w-[52px] h-[52px] rounded-xl flex items-center justify-center mb-6"
                     style="background:#ecfdf5; border:1px solid #a7f3d0;">
                    <svg class="w-6 h-6" style="color:#10b981;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                </div>
                <h3 class="text-[18px] font-bold text-gray-900 mb-1.5">UI/UX Design</h3>
                <p class="text-[14px] text-gray-500 mb-5 leading-relaxed">Pixel-perfect interfaces that are intuitive, beautiful, and conversion-focused.</p>
                <ul class="space-y-2.5">
                    @foreach(['User research & wireframes','High-fidelity Figma prototypes','Design system creation','Interaction & motion design','Accessibility (WCAG) compliant','Handoff-ready assets'] as $f)
                    <li class="flex items-center gap-2.5 text-[14px] text-gray-700">
                        <svg class="svc-check" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        {{ $f }}
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- 5. Cloud & Hosting --}}
            <div class="svc-card svc-card-featured p-8 cursor-default">
                <div class="w-[52px] h-[52px] rounded-xl flex items-center justify-center mb-6"
                     style="background:#eff6ff; border:1px solid #bfdbfe;">
                    <svg class="w-6 h-6" style="color:#2563eb;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                    </svg>
                </div>
                <h3 class="text-[18px] font-bold text-gray-900 mb-1.5">Cloud & Hosting</h3>
                <p class="text-[14px] text-gray-500 mb-5 leading-relaxed">Reliable, fast cloud infrastructure and managed hosting via RhostitCloud.</p>
                <ul class="space-y-2.5">
                    @foreach(['VPS & dedicated servers','One-click app deployments','Auto-scaling infrastructure','SSL, backups & monitoring','CDN & DDoS protection','24/7 support included'] as $f)
                    <li class="flex items-center gap-2.5 text-[14px] text-gray-700">
                        <svg class="svc-check" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        {{ $f }}
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- 6. Digital Solutions --}}
            <div class="svc-card svc-card-green p-8 cursor-default">
                <div class="w-[52px] h-[52px] rounded-xl flex items-center justify-center mb-6"
                     style="background:#ecfdf5; border:1px solid #a7f3d0;">
                    <svg class="w-6 h-6" style="color:#10b981;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-[18px] font-bold text-gray-900 mb-1.5">Digital Solutions</h3>
                <p class="text-[14px] text-gray-500 mb-5 leading-relaxed">Custom digital strategies and tools tailored to your business goals.</p>
                <ul class="space-y-2.5">
                    @foreach(['Digital transformation roadmap','CRM & ERP integration','Process automation','Data analytics & reporting','E-commerce solutions','Brand & marketing tech'] as $f)
                    <li class="flex items-center gap-2.5 text-[14px] text-gray-700">
                        <svg class="svc-check" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        {{ $f }}
                    </li>
                    @endforeach
                </ul>
            </div>

        </div>{{-- /grid --}}

        {{-- CTA inside the outer card --}}
        <div class="text-center mt-8 pt-6" style="border-top: 1px solid rgba(255,255,255,0.6);">
            <a href="{{ route('services') }}"
               class="inline-flex items-center gap-2.5 px-7 py-3.5 rounded-[12px] text-[16px] font-semibold transition-all duration-200 hover:-translate-y-0.5"
               style="color:#2563eb;
                      background: rgba(37,99,235,0.07);
                      border: 1.5px solid rgba(37,99,235,0.22);
                      backdrop-filter: blur(12px) saturate(160%);
                      -webkit-backdrop-filter: blur(12px) saturate(160%);
                      box-shadow: 0 4px 20px rgba(37,99,235,0.10), inset 0 1px 0 rgba(255,255,255,0.85);"
               onmouseenter="this.style.background='rgba(37,99,235,0.12)';this.style.boxShadow='0 8px 28px rgba(37,99,235,0.18),inset 0 1px 0 rgba(255,255,255,0.9)'"
               onmouseleave="this.style.background='rgba(37,99,235,0.07)';this.style.boxShadow='0 4px 20px rgba(37,99,235,0.10),inset 0 1px 0 rgba(255,255,255,0.85)'">
                View all services
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>{{-- /CTA --}}

        </div>{{-- /outer glass card --}}

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     WHY CHOOSE US
════════════════════════════════════════════════════════ --}}
<style>
    .wcu-card {
        background: rgba(255,255,255,0.60);
        backdrop-filter: blur(24px) saturate(200%);
        -webkit-backdrop-filter: blur(24px) saturate(200%);
        border: 1px solid rgba(255,255,255,0.80);
        border-radius: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04), 0 10px 32px rgba(0,0,0,0.07), inset 0 1px 0 rgba(255,255,255,0.95);
        transition: transform 0.30s cubic-bezier(0.22,1,0.36,1), box-shadow 0.30s ease, border-color 0.30s ease;
        opacity: 0;
        transform: translateY(24px);
    }
    .wcu-card.wcu-visible {
        opacity: 1;
        transform: translateY(0);
        transition: opacity 0.55s ease, transform 0.55s cubic-bezier(0.22,1,0.36,1), box-shadow 0.30s ease, border-color 0.30s ease;
    }
    .wcu-card:hover {
        transform: translateY(-7px);
        box-shadow: 0 20px 52px rgba(37,99,235,0.13), 0 4px 16px rgba(0,0,0,0.06), inset 0 1px 0 rgba(255,255,255,0.98);
        border-color: rgba(37,99,235,0.22);
    }
    .wcu-icon-bg {
        transition: transform 0.30s cubic-bezier(0.34,1.56,0.64,1);
    }
    .wcu-card:hover .wcu-icon-bg { transform: scale(1.10); }
    .wcu-card:hover .wcu-icon-blue  { color: #1d4ed8; }
    .wcu-card:hover .wcu-icon-green { color: #059669; }
</style>

<section class="relative py-28 px-6 overflow-hidden" style="background:#e8e8ed;">

    <div class="absolute pointer-events-none" style="top:-180px;left:-100px;width:600px;height:600px;border-radius:50%;background:radial-gradient(circle,rgba(37,99,235,0.05) 0%,transparent 68%);"></div>
    <div class="absolute pointer-events-none" style="bottom:-140px;right:-80px;width:500px;height:500px;border-radius:50%;background:radial-gradient(circle,rgba(16,185,129,0.05) 0%,transparent 68%);"></div>

    <div class="relative max-w-[1360px] mx-auto">

        <div class="text-center mb-[72px]">
            <span class="inline-flex items-center gap-2 text-[11px] font-bold tracking-[0.22em] uppercase mb-5 px-3.5 py-1.5 rounded-full"
                  style="color:#2563eb; background:rgba(37,99,235,0.07); border:1px solid rgba(37,99,235,0.14);">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                Our Edge
            </span>
            <h2 class="text-[40px] md:text-[50px] font-black text-gray-900 tracking-tight leading-[1.10] mb-5">
                Why Businesses Trust<br>
                <span style="background:linear-gradient(135deg,#2563eb 30%,#10b981 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Roddy Technologies</span>
            </h2>
            <p class="text-[17px] text-gray-500 max-w-[500px] mx-auto leading-relaxed font-normal">
                We build scalable, high-performance digital solutions designed for growth.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-7" id="wcuGrid">

            <div class="wcu-card p-9" style="transition-delay:0ms;">
                <div class="wcu-icon-bg w-[60px] h-[60px] rounded-2xl flex items-center justify-center mb-7"
                     style="background:#2563eb;">
                    <svg class="wcu-icon-blue w-[26px] h-[26px]" style="color:#ffffff;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-[17px] font-bold text-gray-900 mb-2.5 tracking-tight">Fast & Efficient Delivery</h3>
                <p class="text-[15px] text-gray-500 leading-relaxed">We deliver projects on time without ever compromising on quality.</p>
            </div>

            <div class="wcu-card p-9" style="transition-delay:90ms;">
                <div class="wcu-icon-bg w-[60px] h-[60px] rounded-2xl flex items-center justify-center mb-7"
                     style="background:#10b981;">
                    <svg class="wcu-icon-green w-[26px] h-[26px]" style="color:#ffffff;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-[17px] font-bold text-gray-900 mb-2.5 tracking-tight">Premium UI/UX Design</h3>
                <p class="text-[15px] text-gray-500 leading-relaxed">Modern, clean, and user-focused interfaces that stand out from the crowd.</p>
            </div>

            <div class="wcu-card p-9" style="transition-delay:180ms;">
                <div class="wcu-icon-bg w-[60px] h-[60px] rounded-2xl flex items-center justify-center mb-7"
                     style="background:#2563eb;">
                    <svg class="wcu-icon-blue w-[26px] h-[26px]" style="color:#ffffff;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <h3 class="text-[17px] font-bold text-gray-900 mb-2.5 tracking-tight">Scalable Architecture</h3>
                <p class="text-[15px] text-gray-500 leading-relaxed">Systems built to grow with your business from day one to enterprise scale.</p>
            </div>

            <div class="wcu-card p-9" style="transition-delay:270ms;">
                <div class="wcu-icon-bg w-[60px] h-[60px] rounded-2xl flex items-center justify-center mb-7"
                     style="background:#10b981;">
                    <svg class="wcu-icon-green w-[26px] h-[26px]" style="color:#ffffff;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="text-[17px] font-bold text-gray-900 mb-2.5 tracking-tight">Secure & Reliable</h3>
                <p class="text-[15px] text-gray-500 leading-relaxed">We implement best practices for security, uptime, and platform stability.</p>
            </div>

            <div class="wcu-card p-9" style="transition-delay:360ms;">
                <div class="wcu-icon-bg w-[60px] h-[60px] rounded-2xl flex items-center justify-center mb-7"
                     style="background:#2563eb;">
                    <svg class="wcu-icon-blue w-[26px] h-[26px]" style="color:#ffffff;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-[17px] font-bold text-gray-900 mb-2.5 tracking-tight">Global Standard Development</h3>
                <p class="text-[15px] text-gray-500 leading-relaxed">We follow international standards and modern technologies across every project.</p>
            </div>

            <div class="wcu-card p-9" style="transition-delay:450ms;">
                <div class="wcu-icon-bg w-[60px] h-[60px] rounded-2xl flex items-center justify-center mb-7"
                     style="background:#10b981;">
                    <svg class="wcu-icon-green w-[26px] h-[26px]" style="color:#ffffff;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <h3 class="text-[17px] font-bold text-gray-900 mb-2.5 tracking-tight">Long-Term Support</h3>
                <p class="text-[15px] text-gray-500 leading-relaxed">We stay with you beyond launch to ensure your product's continuous success.</p>
            </div>

        </div>
    </div>
</section>

<script>
(function () {
    var cards = document.querySelectorAll('#wcuGrid .wcu-card');
    if (!cards.length || !('IntersectionObserver' in window)) {
        cards.forEach(function (c) { c.classList.add('wcu-visible'); });
        return;
    }
    var obs = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
            if (e.isIntersecting) { e.target.classList.add('wcu-visible'); obs.unobserve(e.target); }
        });
    }, { threshold: 0.10 });
    cards.forEach(function (c) { obs.observe(c); });
})();
</script>

{{-- ═══════════════════════════════════════════════════════
     PROJECTS / WORK
     3 featured projects in an alternating layout:
     - Row 1: large image left, content right
     - Row 2: full-width wide card (reversed emphasis)
     - Row 3: large image right, content left
════════════════════════════════════════════════════════ --}}
<section class="relative py-28 px-6 overflow-hidden" style="background:#ffffff;">
    {{-- Ambient orbs --}}
    <div class="absolute top-0 right-0 w-[600px] h-[500px] pointer-events-none"
         style="background: radial-gradient(ellipse at top right, rgba(37,99,235,0.07) 0%, transparent 65%);"></div>
    <div class="absolute bottom-0 left-0 w-[500px] h-[400px] pointer-events-none"
         style="background: radial-gradient(ellipse at bottom left, rgba(16,185,129,0.07) 0%, transparent 65%);"></div>
    <div class="max-w-[1100px] mx-auto relative">

        {{-- Header --}}
        <div class="text-center mb-18 reveal">
            <span class="inline-block text-[16px] font-semibold text-green-600 tracking-[0.08em] uppercase mb-3">Our Work</span>
            <h2 class="text-[2.25rem] lg:text-[2.75rem] font-bold text-gray-900 tracking-[-0.03em] leading-tight mb-4">
                Some of Our Recent Work
            </h2>
            <p class="text-[18px] text-gray-600 max-w-[540px] mx-auto leading-relaxed">
                We design and build high-quality digital products for businesses across industries.
            </p>
        </div>

        {{-- Projects grid --}}
        <div class="space-y-7">

            {{-- Row 1: Rshop — image left, content right --}}
            <div class="proj-card reveal">
                <div class="grid lg:grid-cols-[1.1fr_1fr] min-h-[400px]">
                    {{-- Image --}}
                    <div class="proj-img-wrap" style="min-height: 280px;">
                        <div class="w-full h-full"
                             style="background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 40%, #2563eb 100%); min-height: 280px; display:flex; align-items:center; justify-content:center;">
                            <div style="text-align:center;">
                                <div style="width:72px;height:72px;border-radius:18px;background:rgba(255,255,255,0.12);backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
                                    <svg width="34" height="34" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1.6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <p style="color:rgba(255,255,255,0.5);font-size:13px;letter-spacing:0.05em;">Rshop</p>
                            </div>
                        </div>
                        <div class="proj-overlay">
                            <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-[13px] font-semibold text-white"
                                  style="background:rgba(255,255,255,0.15);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.25);">
                                View Project →
                            </span>
                        </div>
                    </div>
                    {{-- Content --}}
                    <div class="flex flex-col justify-center p-10 lg:p-14">
                        <div class="flex items-center gap-2 mb-5">
                            <span class="text-[11px] font-semibold px-2.5 py-1 rounded-full tracking-wide"
                                  style="background:rgba(37,99,235,0.08);color:#2563eb;border:1px solid rgba(37,99,235,0.15);">eCommerce</span>
                            <span class="text-[11px] font-semibold px-2.5 py-1 rounded-full tracking-wide"
                                  style="background:rgba(16,185,129,0.08);color:#059669;border:1px solid rgba(16,185,129,0.15);">Mobile</span>
                        </div>
                        <h3 class="text-[1.65rem] font-bold text-gray-900 tracking-[-0.02em] mb-3">Rshop</h3>
                        <p class="text-[16px] text-gray-600 leading-relaxed mb-7">
                            A full-featured African eCommerce platform connecting buyers and sellers with fast checkout, product management, and real-time order tracking.
                        </p>
                        <a href="#"
                           class="self-start inline-flex items-center gap-2 text-[15px] font-semibold text-blue-600 hover:text-blue-800 transition-colors group">
                            View Project
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Row 2 & 3: RTG Domains + RhostitCloud side by side --}}
            <div class="grid md:grid-cols-2 gap-7">

                {{-- RTG Domains --}}
                <div class="proj-card reveal flex flex-col">
                    <div class="proj-img-wrap" style="height:220px;">
                        <div class="w-full h-full flex items-center justify-center"
                             style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #10b981 100%); height:220px;">
                            <div style="text-align:center;">
                                <div style="width:64px;height:64px;border-radius:16px;background:rgba(255,255,255,0.10);backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,0.18);display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                    <svg width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1.6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                    </svg>
                                </div>
                                <p style="color:rgba(255,255,255,0.5);font-size:13px;letter-spacing:0.05em;">RTG Domains</p>
                            </div>
                        </div>
                        <div class="proj-overlay">
                            <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-[13px] font-semibold text-white"
                                  style="background:rgba(255,255,255,0.15);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.25);">
                                View Project →
                            </span>
                        </div>
                    </div>
                    <div class="flex flex-col flex-1 p-8">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="text-[11px] font-semibold px-2.5 py-1 rounded-full"
                                  style="background:rgba(16,185,129,0.08);color:#059669;border:1px solid rgba(16,185,129,0.15);">Domains</span>
                            <span class="text-[11px] font-semibold px-2.5 py-1 rounded-full"
                                  style="background:rgba(37,99,235,0.08);color:#2563eb;border:1px solid rgba(37,99,235,0.15);">SaaS</span>
                        </div>
                        <h3 class="text-[1.35rem] font-bold text-gray-900 tracking-[-0.02em] mb-2.5">RTG Domains</h3>
                        <p class="text-[16px] text-gray-600 leading-relaxed flex-1">
                            Domain registration and management platform built for African businesses fast search, instant activation, and full DNS control.
                        </p>
                        <a href="#"
                           class="mt-6 self-start inline-flex items-center gap-2 text-[15px] font-semibold text-green-600 hover:text-green-800 transition-colors group">
                            View Project
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- RhostitCloud --}}
                <div class="proj-card reveal flex flex-col">
                    <div class="proj-img-wrap" style="height:220px;">
                        <div class="w-full h-full flex items-center justify-center"
                             style="background: linear-gradient(135deg, #0f172a 0%, #1e3050 50%, #7c3aed 100%); height:220px;">
                            <div style="text-align:center;">
                                <div style="width:64px;height:64px;border-radius:16px;background:rgba(255,255,255,0.10);backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,0.18);display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                    <svg width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1.6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                                    </svg>
                                </div>
                                <p style="color:rgba(255,255,255,0.5);font-size:13px;letter-spacing:0.05em;">RhostitCloud</p>
                            </div>
                        </div>
                        <div class="proj-overlay">
                            <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-[13px] font-semibold text-white"
                                  style="background:rgba(255,255,255,0.15);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.25);">
                                View Project →
                            </span>
                        </div>
                    </div>
                    <div class="flex flex-col flex-1 p-8">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="text-[11px] font-semibold px-2.5 py-1 rounded-full"
                                  style="background:rgba(124,58,237,0.08);color:#7c3aed;border:1px solid rgba(124,58,237,0.15);">Cloud</span>
                            <span class="text-[11px] font-semibold px-2.5 py-1 rounded-full"
                                  style="background:rgba(37,99,235,0.08);color:#2563eb;border:1px solid rgba(37,99,235,0.15);">Hosting</span>
                        </div>
                        <h3 class="text-[1.35rem] font-bold text-gray-900 tracking-[-0.02em] mb-2.5">RhostitCloud</h3>
                        <p class="text-[16px] text-gray-600 leading-relaxed flex-1">
                            Managed cloud hosting and server infrastructure for startups and enterprises one-click deployments, 99.9% uptime, and 24/7 monitoring.
                        </p>
                        <a href="#"
                           class="mt-6 self-start inline-flex items-center gap-2 text-[15px] font-semibold text-blue-600 hover:text-blue-800 transition-colors group">
                            View Project
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>

            </div>{{-- /grid --}}

        </div>{{-- /space-y-7 --}}

        {{-- CTA --}}
        <div class="text-center mt-14 reveal">
            <a href="#"
               class="inline-flex items-center gap-2.5 px-7 py-3.5 rounded-[12px] text-[16px] font-semibold transition-all duration-200 hover:-translate-y-0.5"
               style="color:#1d4ed8;
                      background: rgba(37,99,235,0.07);
                      border: 1.5px solid rgba(37,99,235,0.22);
                      backdrop-filter: blur(12px) saturate(160%);
                      -webkit-backdrop-filter: blur(12px) saturate(160%);
                      box-shadow: 0 4px 20px rgba(37,99,235,0.10), inset 0 1px 0 rgba(255,255,255,0.85);"
               onmouseenter="this.style.background='rgba(37,99,235,0.12)';this.style.boxShadow='0 8px 28px rgba(37,99,235,0.18),inset 0 1px 0 rgba(255,255,255,0.9)'"
               onmouseleave="this.style.background='rgba(37,99,235,0.07)';this.style.boxShadow='0 4px 20px rgba(37,99,235,0.10),inset 0 1px 0 rgba(255,255,255,0.85)'">
                View all projects
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     WEB DEV FEATURE CARD
     Dark animated card: left = headline + CTA, right = live chat UI
     Messages appear in sequence via CSS animation-delay
════════════════════════════════════════════════════════ --}}
<section class="py-20 px-6" style="background:#e8e8ed;">
    <div class="max-w-[1100px] mx-auto">
        <div class="webdev-bg relative rounded-[28px] overflow-hidden"
             style="box-shadow: 0 32px 90px rgba(0,0,0,0.32), 0 8px 24px rgba(0,0,0,0.18), inset 0 1px 0 rgba(255,255,255,0.06);">

            {{-- Pulsing rings --}}
            <div class="webdev-ring absolute pointer-events-none"  style="right:-130px;top:50%;width:680px;height:680px;border-radius:50%;border:1px solid rgba(255,255,255,0.06);"></div>
            <div class="webdev-ring-2 absolute pointer-events-none" style="right:-60px;top:50%;width:500px;height:500px;border-radius:50%;border:1px solid rgba(255,255,255,0.07);"></div>
            <div class="webdev-ring-3 absolute pointer-events-none" style="right:30px;top:50%;width:330px;height:330px;border-radius:50%;border:1px solid rgba(255,255,255,0.06);"></div>

            {{-- Ambient glow --}}
            <div class="absolute pointer-events-none" style="top:-60px;left:80px;width:420px;height:420px;border-radius:50%;background:radial-gradient(circle,rgba(37,99,235,0.24) 0%,transparent 68%);"></div>
            <div class="absolute pointer-events-none" style="bottom:-60px;right:120px;width:360px;height:360px;border-radius:50%;background:radial-gradient(circle,rgba(16,185,129,0.22) 0%,transparent 68%);"></div>

            <div class="grid lg:grid-cols-2 items-center" style="min-height:440px;">

                {{-- ── Left: copy ── --}}
                <div class="flex flex-col justify-center p-10 lg:p-16 relative z-10">

                    {{-- Label --}}
                    <div class="inline-flex items-center gap-2 self-start mb-6 px-3 py-1.5 rounded-full"
                         style="background:rgba(16,185,129,0.12);border:1px solid rgba(16,185,129,0.22);">
                        <span class="w-1.5 h-1.5 rounded-full animate-pulse" style="background:#34d399;"></span>
                        <span class="text-[11px] font-semibold tracking-[0.12em] uppercase" style="color:#34d399;">Featured Service</span>
                    </div>

                    {{-- Headline --}}
                    <h2 class="font-bold leading-[1.06] tracking-[-0.03em] mb-5" style="font-size:clamp(2rem,4vw,2.85rem);color:#ffffff;">
                        Build Powerful Web<br>
                        <span style="background:linear-gradient(90deg,#60a5fa 0%,#34d399 100%);
                                     -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                            Applications
                        </span><br>
                        That Scale
                    </h2>

                    <p class="text-[16px] leading-[1.75] mb-9" style="color:rgba(255,255,255,0.55);max-width:370px;">
                        From landing pages to complex platforms we design, build, and launch fast, modern web apps that grow with your business.
                    </p>

                    <a href="{{ route('services') }}" class="webdev-cta self-start inline-flex items-center gap-2.5 text-[15px] font-semibold rounded-[12px] px-6 py-3.5"
                       style="background:rgba(255,255,255,0.10);
                              border:1.5px solid rgba(255,255,255,0.20);
                              color:#ffffff;
                              backdrop-filter:blur(12px);
                              box-shadow:0 4px 20px rgba(0,0,0,0.22),inset 0 1px 0 rgba(255,255,255,0.15);">
                        Start Your Project
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>

                {{-- ── Right: animated chat window ── --}}
                <div class="relative flex items-center justify-center p-6 lg:p-10 z-10">
                    <div class="w-full" style="max-width:410px;">

                        {{-- Chat frame --}}
                        <div class="rounded-[22px] overflow-hidden"
                             style="background:rgba(10,16,34,0.80);
                                    border:1px solid rgba(255,255,255,0.10);
                                    backdrop-filter:blur(24px) saturate(180%);
                                    box-shadow:0 28px 72px rgba(0,0,0,0.50),0 8px 20px rgba(0,0,0,0.30),inset 0 1px 0 rgba(255,255,255,0.08);">

                            {{-- Title bar --}}
                            <div class="flex items-center gap-3 px-4 py-3"
                                 style="border-bottom:1px solid rgba(255,255,255,0.07);background:rgba(255,255,255,0.03);">
                                <div class="flex gap-1.5 shrink-0">
                                    <span class="w-2.5 h-2.5 rounded-full" style="background:#ff5f57;box-shadow:0 0 6px rgba(255,95,87,0.5);"></span>
                                    <span class="w-2.5 h-2.5 rounded-full" style="background:#febc2e;box-shadow:0 0 6px rgba(254,188,46,0.4);"></span>
                                    <span class="w-2.5 h-2.5 rounded-full" style="background:#28c840;box-shadow:0 0 6px rgba(40,200,64,0.4);"></span>
                                </div>
                                <div class="flex-1 flex items-center justify-center gap-2">
                                    <div class="chat-av w-7 h-7 rounded-full flex items-center justify-center text-[11px] font-bold text-white"
                                         style="background:linear-gradient(135deg,#2563eb,#10b981);box-shadow:0 0 12px rgba(37,99,235,0.40);">R</div>
                                    <div>
                                        <p class="text-[12px] font-semibold" style="color:rgba(255,255,255,0.90);line-height:1.3;">Roddy Technologies</p>
                                        <div class="flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full animate-pulse" style="background:#22c55e;"></span>
                                            <span class="text-[10px]" style="color:rgba(255,255,255,0.38);">Online · Web Dev Team</span>
                                        </div>
                                    </div>
                                </div>
                                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" style="color:rgba(255,255,255,0.25);">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>

                            {{-- Message thread --}}
                            <div class="px-4 py-4 space-y-3.5" style="min-height:280px;">

                                {{-- Client msg 1 — enters at 0.5s --}}
                                <div class="chat-msg-1 flex items-end gap-2">
                                    <div class="chat-av w-7 h-7 rounded-full shrink-0 flex items-center justify-center text-[10px] font-bold text-white"
                                         style="background:linear-gradient(135deg,#6366f1,#8b5cf6);box-shadow:0 0 10px rgba(99,102,241,0.35);">M</div>
                                    <div>
                                        <div class="px-3.5 py-2.5 rounded-2xl rounded-bl-sm text-[13px] leading-relaxed"
                                             style="background:rgba(255,255,255,0.10);
                                                    border:1px solid rgba(255,255,255,0.10);
                                                    backdrop-filter:blur(8px);
                                                    color:rgba(255,255,255,0.88);
                                                    box-shadow:0 4px 14px rgba(0,0,0,0.18);
                                                    max-width:226px;">
                                            Hi! We need a website + admin portal for our logistics company. Budget confirmed. 🚀
                                        </div>
                                        <p class="text-[10px] mt-1 ml-1" style="color:rgba(255,255,255,0.22);">2:14 PM</p>
                                    </div>
                                </div>

                                {{-- Typing 1 — enters 1.4s, auto-fades at 2.6s --}}
                                <div class="chat-typing-1 flex items-end gap-2">
                                    <div class="chat-av w-7 h-7 rounded-full shrink-0 flex items-center justify-center text-[10px] font-bold text-white"
                                         style="background:linear-gradient(135deg,#2563eb,#10b981);">R</div>
                                    <div class="px-4 py-3 rounded-2xl rounded-bl-sm flex items-center gap-1.5"
                                         style="background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.08);backdrop-filter:blur(8px);">
                                        <span class="w-1.5 h-1.5 rounded-full animate-bounce" style="background:rgba(52,211,153,0.80);animation-delay:0ms;"></span>
                                        <span class="w-1.5 h-1.5 rounded-full animate-bounce" style="background:rgba(52,211,153,0.80);animation-delay:160ms;"></span>
                                        <span class="w-1.5 h-1.5 rounded-full animate-bounce" style="background:rgba(52,211,153,0.80);animation-delay:320ms;"></span>
                                    </div>
                                </div>

                                {{-- Roddy msg 1 — enters at 2.6s --}}
                                <div class="chat-msg-2 flex items-end gap-2 flex-row-reverse">
                                    <div class="chat-av w-7 h-7 rounded-full shrink-0 flex items-center justify-center text-[10px] font-bold text-white"
                                         style="background:linear-gradient(135deg,#2563eb,#10b981);box-shadow:0 0 10px rgba(37,99,235,0.40);">R</div>
                                    <div class="flex flex-col items-end">
                                        <div class="px-3.5 py-2.5 rounded-2xl rounded-br-sm text-[13px] leading-relaxed"
                                             style="background:linear-gradient(135deg,rgba(37,99,235,0.55),rgba(16,185,129,0.38));
                                                    border:1px solid rgba(255,255,255,0.12);
                                                    backdrop-filter:blur(8px);
                                                    color:rgba(255,255,255,0.92);
                                                    box-shadow:0 4px 18px rgba(37,99,235,0.22);
                                                    max-width:226px;">
                                            Great choice! We specialize in exactly this. What's your go-live date?
                                        </div>
                                        <div class="flex items-center gap-1 mt-1 mr-1">
                                            <p class="text-[10px]" style="color:rgba(255,255,255,0.22);">2:15 PM</p>
                                            <svg class="w-3.5 h-3" viewBox="0 0 18 10" fill="none" style="color:#34d399;">
                                                <path d="M1 5l3.5 3.5L13 1M6 5l3.5 3.5L19 1" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                {{-- Client msg 2 — enters at 3.7s --}}
                                <div class="chat-msg-3 flex items-end gap-2">
                                    <div class="chat-av w-7 h-7 rounded-full shrink-0 flex items-center justify-center text-[10px] font-bold text-white"
                                         style="background:linear-gradient(135deg,#6366f1,#8b5cf6);">M</div>
                                    <div>
                                        <div class="px-3.5 py-2.5 rounded-2xl rounded-bl-sm text-[13px]"
                                             style="background:rgba(255,255,255,0.10);border:1px solid rgba(255,255,255,0.10);backdrop-filter:blur(8px);color:rgba(255,255,255,0.88);box-shadow:0 4px 14px rgba(0,0,0,0.18);max-width:200px;">
                                            6 weeks max. Can you deliver?
                                        </div>
                                        <p class="text-[10px] mt-1 ml-1" style="color:rgba(255,255,255,0.22);">2:16 PM</p>
                                    </div>
                                </div>

                                {{-- Typing 2 — enters 4.6s, fades at 5.8s --}}
                                <div class="chat-typing-2 flex items-end gap-2 flex-row-reverse">
                                    <div class="chat-av w-7 h-7 rounded-full shrink-0 flex items-center justify-center text-[10px] font-bold text-white"
                                         style="background:linear-gradient(135deg,#2563eb,#10b981);">R</div>
                                    <div class="px-4 py-3 rounded-2xl rounded-br-sm flex items-center gap-1.5"
                                         style="background:rgba(37,99,235,0.20);border:1px solid rgba(37,99,235,0.22);backdrop-filter:blur(8px);">
                                        <span class="w-1.5 h-1.5 rounded-full animate-bounce" style="background:rgba(52,211,153,0.80);animation-delay:0ms;"></span>
                                        <span class="w-1.5 h-1.5 rounded-full animate-bounce" style="background:rgba(52,211,153,0.80);animation-delay:160ms;"></span>
                                        <span class="w-1.5 h-1.5 rounded-full animate-bounce" style="background:rgba(52,211,153,0.80);animation-delay:320ms;"></span>
                                    </div>
                                </div>

                                {{-- Roddy msg 2 (checklist) — enters at 6.0s --}}
                                <div class="chat-msg-4 flex items-end gap-2 flex-row-reverse">
                                    <div class="chat-av w-7 h-7 rounded-full shrink-0 flex items-center justify-center text-[10px] font-bold text-white"
                                         style="background:linear-gradient(135deg,#2563eb,#10b981);box-shadow:0 0 10px rgba(37,99,235,0.40);">R</div>
                                    <div class="flex flex-col items-end">
                                        <div class="px-3.5 py-3 rounded-2xl rounded-br-sm text-[13px] space-y-1.5"
                                             style="background:linear-gradient(135deg,rgba(37,99,235,0.55),rgba(16,185,129,0.38));
                                                    border:1px solid rgba(255,255,255,0.12);
                                                    backdrop-filter:blur(8px);
                                                    color:rgba(255,255,255,0.92);
                                                    box-shadow:0 4px 18px rgba(37,99,235,0.22);
                                                    max-width:246px;">
                                            <p class="font-semibold text-white">Done in 5 weeks. Included:</p>
                                            <p style="color:rgba(255,255,255,0.82);">✅ Custom Figma design</p>
                                            <p style="color:rgba(255,255,255,0.82);">✅ Laravel + React stack</p>
                                            <p style="color:rgba(255,255,255,0.82);">✅ Admin panel + client login</p>
                                            <p style="color:rgba(255,255,255,0.82);">✅ Mobile-first &amp; SEO ready</p>
                                            <p style="color:#34d399;font-weight:600;" class="pt-0.5">Ready to kick off? 🎯</p>
                                        </div>
                                        <div class="flex items-center gap-1 mt-1 mr-1">
                                            <p class="text-[10px]" style="color:rgba(255,255,255,0.22);">2:17 PM</p>
                                            <svg class="w-3.5 h-3" viewBox="0 0 18 10" fill="none" style="color:#34d399;">
                                                <path d="M1 5l3.5 3.5L13 1M6 5l3.5 3.5L19 1" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                {{-- Final typing (client replying) — enters 7.2s, stays --}}
                                <div class="chat-typing-f flex items-end gap-2">
                                    <div class="chat-av w-7 h-7 rounded-full shrink-0 flex items-center justify-center text-[10px] font-bold text-white"
                                         style="background:linear-gradient(135deg,#6366f1,#8b5cf6);">M</div>
                                    <div class="px-4 py-3 rounded-2xl rounded-bl-sm flex items-center gap-1.5"
                                         style="background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.08);backdrop-filter:blur(8px);">
                                        <span class="w-1.5 h-1.5 rounded-full animate-bounce" style="background:rgba(255,255,255,0.55);animation-delay:0ms;"></span>
                                        <span class="w-1.5 h-1.5 rounded-full animate-bounce" style="background:rgba(255,255,255,0.55);animation-delay:160ms;"></span>
                                        <span class="w-1.5 h-1.5 rounded-full animate-bounce" style="background:rgba(255,255,255,0.55);animation-delay:320ms;"></span>
                                    </div>
                                </div>

                            </div>{{-- /messages --}}

                            {{-- Input bar --}}
                            <div class="px-3 py-2.5 flex items-center gap-2"
                                 style="border-top:1px solid rgba(255,255,255,0.07);">
                                <div class="flex-1 px-4 py-2 rounded-full text-[12px]"
                                     style="background:rgba(255,255,255,0.06);color:rgba(255,255,255,0.28);border:1px solid rgba(255,255,255,0.08);">
                                    Type a message...
                                </div>
                                <button class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 transition-transform hover:scale-110"
                                        style="background:linear-gradient(135deg,#2563eb,#10b981);box-shadow:0 4px 14px rgba(37,99,235,0.35);">
                                    <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </button>
                            </div>

                        </div>{{-- /chat frame --}}
                    </div>
                </div>{{-- /right --}}

            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     TESTIMONIALS
════════════════════════════════════════════════════════ --}}
@if($testimonials->count())
<section class="py-28 px-6 bg-[#04040a] relative overflow-hidden">
    <div class="orb w-[400px] h-[400px] top-0 right-0 opacity-50"
         style="background: radial-gradient(circle, rgba(124,58,237,0.15) 0%, transparent 70%);"></div>

    <div class="relative max-w-6xl mx-auto">
        <div class="text-center mb-16">
            <p class="text-xs font-semibold text-purple-400 uppercase tracking-widest mb-3">Testimonials</p>
            <h2 class="text-4xl font-bold text-white tracking-tight">Trusted by founders</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($testimonials as $testimonial)
            <div class="p-6 rounded-2xl border"
                 style="background: rgba(255,255,255,0.04); border-color: rgba(255,255,255,0.08); backdrop-filter: blur(10px);">
                {{-- Stars --}}
                <div class="flex gap-0.5 mb-4">
                    @for($i = 0; $i < min($testimonial->rating, 5); $i++)
                        <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <p class="text-gray-300 text-[16px] leading-relaxed mb-5">"{{ $testimonial->content }}"</p>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white shrink-0"
                         style="background: linear-gradient(135deg, #2563eb, #7c3aed);">
                        {{ strtoupper(substr($testimonial->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-white">{{ $testimonial->name }}</p>
                        @if($testimonial->position)
                            <p class="text-xs text-gray-500">{{ $testimonial->position }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════════════════════════════════════
     CTA
════════════════════════════════════════════════════════ --}}
<section class="py-28 px-6" style="background:#ffffff;">
    <div class="max-w-3xl mx-auto text-center">
        <h2 class="text-4xl font-bold text-gray-900 tracking-tight mb-5">Ready to build something great?</h2>
        <p class="text-[18px] text-gray-500 mb-10">Tell us about your project. We'll respond within 24 hours.</p>
        <a href="{{ route('contact') }}"
           class="inline-block px-8 py-4 rounded-2xl text-sm font-semibold text-white transition-all hover:scale-[1.02] active:scale-[0.98] shadow-xl"
           style="background: linear-gradient(135deg, #2563eb, #7c3aed); box-shadow: 0 12px 40px rgba(37,99,235,0.35);">
            Start a Conversation
        </a>
    </div>
</section>

<script>
/*
 * ─────────────────────────────────────────────────────────────
 *  PAGE SCRIPTS — home.blade.php
 *
 *  1. countUp()        — animates stat numbers from 0 → target value
 *  2. setTimeout()     — delays count-up start until hero CSS animation ends
 *  3. IntersectionObserver — triggers .reveal elements when they enter viewport
 * ─────────────────────────────────────────────────────────────
 */
document.addEventListener('DOMContentLoaded', function () {

    /*
     * COUNT-UP ANIMATION
     * Uses requestAnimationFrame for smooth 60fps rendering.
     * Easing: ease-out cubic (1 - (1-t)^3) — fast start, slows at the end.
     * el       = the DOM element whose text content gets updated
     * target   = final number (read from data-target attribute in HTML)
     * suffix   = "+" or "%" appended after the number
     * duration = total animation time in milliseconds
     */
    function countUp(el, target, suffix, duration) {
        var start = performance.now();
        function step(now) {
            var elapsed  = now - start;
            var progress = Math.min(elapsed / duration, 1);
            var eased    = 1 - Math.pow(1 - progress, 3); /* ease-out cubic */
            el.textContent = Math.round(eased * target) + suffix;
            if (progress < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
    }

    /*
     * Delay the count-up by 800ms so it starts AFTER the hero stagger
     * animations complete (the last element animates in at ~580ms delay + 700ms duration).
     * Count runs over 1400ms per stat.
     */
    setTimeout(function () {
        document.querySelectorAll('.stat-num').forEach(function (el) {
            countUp(el, parseInt(el.dataset.target, 10), el.dataset.suffix, 1400);
        });
    }, 800);

    /*
     * SERVICES CARDS STAGGER
     * Each .svc-card fades up with a 80ms delay between cards.
     * Triggered once when the grid enters the viewport.
     */
    var svcCards = document.querySelectorAll('.svc-card');
    if (svcCards.length && 'IntersectionObserver' in window) {
        svcCards.forEach(function (card, i) {
            card.style.opacity = '0';
            card.style.transform = 'translateY(24px)';
            card.style.transition = 'opacity 0.55s cubic-bezier(0.22,1,0.36,1) ' + (i * 80) + 'ms, transform 0.55s cubic-bezier(0.22,1,0.36,1) ' + (i * 80) + 'ms';
        });
        var svcObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    var card = entry.target;
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                    svcObserver.unobserve(card);
                    // Clear inline transform+transition once reveal finishes so CSS :hover takes over
                    card.addEventListener('transitionend', function clear(e) {
                        if (e.propertyName === 'transform') {
                            card.style.transform = '';
                            card.style.transition = '';
                            card.removeEventListener('transitionend', clear);
                        }
                    });
                }
            });
        }, { threshold: 0.12 });
        svcCards.forEach(function (card) { svcObserver.observe(card); });
    }

    /*
     * SCROLL REVEAL
     * Watches all elements with class "reveal".
     * When 14% of the element is visible in the viewport,
     * adds class "visible" which triggers the CSS transition (opacity + translateY).
     * unobserve() stops watching after first trigger (fire once only).
     * Falls back gracefully if browser doesn't support IntersectionObserver.
     */
    var revealEls = document.querySelectorAll('.reveal');
    if (revealEls.length && 'IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target); /* fire once */
                }
            });
        }, { threshold: 0.14 });
        revealEls.forEach(function (el) { observer.observe(el); });
    }

});
</script>

</x-layouts.public>
