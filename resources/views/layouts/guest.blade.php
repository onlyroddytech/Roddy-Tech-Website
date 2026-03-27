<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ ($title ?? 'Sign In') . ' — ' . config('app.name', 'Roddy Technologies') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body { font-family: 'Inter', system-ui, sans-serif; -webkit-font-smoothing: antialiased; }

        /* ── Labels ─────────────────────────────────────────── */
        .auth-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 8px;
            letter-spacing: 0.01em;
        }

        /* ── Inputs ─────────────────────────────────────────── */
        .auth-input {
            width: 100%;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px 16px;
            font-size: 14px;
            color: #0f172a;
            outline: none;
            box-shadow: inset 0 1px 3px rgba(0,0,0,.04);
            transition: border-color .25s ease, box-shadow .25s ease, background .25s ease;
            -webkit-appearance: none;
        }
        .auth-input::placeholder { color: #94a3b8; font-size: 13.5px; }
        .auth-input:hover:not(:focus) { border-color: #cbd5e1; background: #f1f5f9; }
        .auth-input:focus {
            background: #fff;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59,130,246,.14), inset 0 1px 2px rgba(0,0,0,.03);
        }
        .auth-input.has-error {
            background: #fff8f8;
            border-color: #f87171;
            box-shadow: 0 0 0 4px rgba(239,68,68,.1), inset 0 1px 2px rgba(0,0,0,.03);
        }

        /* ── Primary button ─────────────────────────────────── */
        .auth-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 15px 20px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.02em;
            color: #fff;
            background: #2563eb;
            border: none;
            cursor: pointer;
            box-shadow: 0 1px 3px rgba(0,0,0,.12), 0 4px 16px rgba(37,99,235,.28);
            transition: background .2s ease,
                        transform .25s cubic-bezier(.22,1,.36,1),
                        box-shadow .25s cubic-bezier(.22,1,.36,1);
            user-select: none;
            -webkit-tap-highlight-color: transparent;
        }
        .auth-btn:hover:not(:disabled) {
            background: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 2px 6px rgba(0,0,0,.12), 0 10px 28px rgba(37,99,235,.38);
        }
        .auth-btn:active:not(:disabled) {
            background: #1e40af;
            transform: scale(.96);
            box-shadow: 0 1px 2px rgba(0,0,0,.1), 0 2px 6px rgba(37,99,235,.2);
            transition-duration: .1s;
        }
        .auth-btn:disabled { opacity: .5; cursor: not-allowed; box-shadow: none; transform: none; }

        /* ── Social buttons ─────────────────────────────────── */
        .social-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            width: 100%;
            padding: 12px 16px;
            border-radius: 11px;
            font-size: 13.5px;
            font-weight: 500;
            color: #1e293b;
            background: #fff;
            border: 1.5px solid #e2e8f0;
            cursor: pointer;
            box-shadow: 0 1px 3px rgba(0,0,0,.05);
            transition: background .2s ease,
                        border-color .2s ease,
                        transform .25s cubic-bezier(.22,1,.36,1),
                        box-shadow .25s cubic-bezier(.22,1,.36,1);
            -webkit-tap-highlight-color: transparent;
        }
        .social-btn:hover {
            background: #f8fafc;
            border-color: #bfdbfe;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,.08);
        }
        .social-btn:active { transform: scale(.96); transition-duration: .1s; }

        /* ── "Coming soon" badge inside social buttons ─────── */
        .social-soon { opacity: .82; position: relative; }
        .social-soon:hover { opacity: 1; }

        .soon-badge {
            margin-left: auto;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.03em;
            color: #64748b;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 2px 6px;
            line-height: 1.4;
            transition: background .2s ease, color .2s ease;
            flex-shrink: 0;
        }
        .social-soon:hover .soon-badge {
            background: #eff6ff;
            color: #3b82f6;
            border-color: #bfdbfe;
        }

        /* ── Error text ─────────────────────────────────────── */
        .auth-error {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            color: #ef4444;
            margin-top: 6px;
        }

        /* ── Checkbox ───────────────────────────────────────── */
        .auth-check {
            width: 16px; height: 16px;
            accent-color: #2563eb;
            cursor: pointer;
            flex-shrink: 0;
        }

        /* ── Form card ──────────────────────────────────────── */
        .auth-card {
            background: #ffffff;
            border: 1px solid #e8edf2;
            border-radius: 20px;
            padding: 40px 40px 36px;
            box-shadow:
                0 1px 2px rgba(0,0,0,.04),
                0 4px 12px rgba(0,0,0,.06),
                0 16px 40px rgba(0,0,0,.07);
        }

        /* ── Left panel dot texture ─────────────────────────── */
        .g-dots {
            background-image: radial-gradient(circle, rgba(255,255,255,.12) 1px, transparent 1px);
            background-size: 24px 24px;
        }

        /* ── Feature icon chip ──────────────────────────────── */
        .feat-icon {
            transition: transform .25s cubic-bezier(.22,1,.36,1);
        }
        .feat-icon:hover { transform: scale(1.08); }

        /* ── Testimonial card ───────────────────────────────── */
        .testim-card {
            transition: transform .25s cubic-bezier(.22,1,.36,1), box-shadow .25s ease;
        }
        .testim-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 32px rgba(0,0,0,.3) !important;
        }

        /* ── Entry animations ───────────────────────────────── */
        @keyframes gPanelIn { from { opacity:0; transform:translateX(-14px); } to { opacity:1; transform:translateX(0); } }
        .g-panel-anim { animation: gPanelIn .6s cubic-bezier(.22,1,.36,1) .05s both; }

        @keyframes gFormIn { from { opacity:0; transform:translateY(18px); } to { opacity:1; transform:translateY(0); } }
        .g-form-anim { animation: gFormIn .6s cubic-bezier(.22,1,.36,1) .12s both; }

        /* ── Spinner ────────────────────────────────────────── */
        @keyframes spin { to { transform: rotate(360deg); } }
        .spinner {
            width: 16px; height: 16px;
            border: 2.5px solid rgba(255,255,255,.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin .6s linear infinite;
            flex-shrink: 0;
        }

        /* ── Mobile ─────────────────────────────────────────── */
        @media (max-width: 640px) {
            .auth-card { padding: 28px 22px 26px; border-radius: 18px; }
            .auth-input { padding: 14px 15px; }
            .auth-btn { padding: 15px 20px; }
        }
    </style>
</head>
<body class="antialiased" style="background:#fff; min-height:100vh; color:#0f172a;">

<div class="min-h-screen flex">

    {{-- ══════════════════════════════════════════════════════════
         LEFT PANEL — dark branding, no gradients
    ══════════════════════════════════════════════════════════ --}}
    <div class="hidden lg:flex lg:w-[46%] xl:w-[44%] relative flex-col justify-between p-14 overflow-hidden g-panel-anim"
         style="background: #0a0a0a;">

        {{-- Dot texture only — no color orbs ─────────────── --}}
        <div class="g-dots absolute inset-0 pointer-events-none"></div>

        {{-- ── Logo ── --}}
        <div class="relative z-10">
            <a href="{{ route('home') }}" class="inline-flex items-center">
                <img src="{{ asset('images/rtg-logo.png') }}"
                     alt="Roddy Technologies"
                     class="h-9 w-auto brightness-0 invert">
            </a>
        </div>

        {{-- ── Center copy ── --}}
        <div class="relative z-10">

            {{-- Headline --}}
            <h2 class="font-bold leading-[1.06] tracking-tight text-white mb-5"
                style="font-size: 3rem;">
                Build. Launch.<br>
                <span style="font-size: 3.35rem; color: #60a5fa;">Scale.</span>
            </h2>

            <p class="text-[14.5px] leading-[1.75] mb-11"
               style="color: rgba(255,255,255,.55); max-width: 290px;">
                Access your project dashboard, track progress in real time, and collaborate directly with our team.
            </p>

            {{-- Feature list ──────────────────────────────── --}}
            <ul class="space-y-4 mb-12">
                @foreach([
                    ['icon' => 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z', 'text' => 'Secure client portal with role-based access'],
                    ['icon' => 'M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z',           'text' => 'Real-time project updates & milestone tracking'],
                    ['icon' => 'M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z', 'text' => 'Direct messaging & fast support from our team'],
                ] as $feat)
                    <li class="flex items-center gap-4">
                        <div class="feat-icon w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                             style="background: rgba(255,255,255,.07); border: 1px solid rgba(255,255,255,.1);">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                 style="width:17px; height:17px; color:rgba(255,255,255,.8);">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $feat['icon'] }}"/>
                            </svg>
                        </div>
                        <span class="text-[13.5px]" style="color:rgba(255,255,255,.7);">{{ $feat['text'] }}</span>
                    </li>
                @endforeach
            </ul>

            {{-- Testimonial ───────────────────────────────── --}}
            <div class="testim-card p-6 rounded-2xl"
                 style="
                     background: rgba(255,255,255,.05);
                     border: 1px solid rgba(255,255,255,.09);
                     box-shadow: 0 2px 16px rgba(0,0,0,.2);
                 ">

                <div class="flex gap-0.5 mb-4">
                    @for($i = 0; $i < 5; $i++)
                        <svg class="w-3.5 h-3.5" fill="#fbbf24" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @endfor
                </div>

                <p class="text-[13.5px] leading-[1.7] italic mb-5"
                   style="color: rgba(255,255,255,.8);">
                    "Roddy Technologies delivered our platform ahead of schedule. The quality is exceptional truly a world-class team."
                </p>

                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center text-[11px] font-bold text-white flex-shrink-0"
                         style="background: #2563eb;">A</div>
                    <div>
                        <p class="text-[13px] font-semibold text-white leading-tight">Alex M.</p>
                        <p class="text-[11.5px] mt-0.5" style="color: rgba(255,255,255,.4);">Founder, StartupNG</p>
                    </div>
                    <div class="ml-auto flex items-center gap-1.5 text-[10px] font-semibold px-2.5 py-1 rounded-full"
                         style="background: rgba(255,255,255,.08); color: rgba(255,255,255,.65); border: 1px solid rgba(255,255,255,.1);">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"
                             style="width:9px; height:9px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Verified
                    </div>
                </div>
            </div>

        </div>

        {{-- ── Footer ── --}}
        <div class="relative z-10">
            <p class="text-[11.5px]" style="color: rgba(255,255,255,.25);">
                © {{ date('Y') }} Roddy Technologies · Built in Cameroon 🇨🇲
            </p>
        </div>

    </div>

    {{-- ══════════════════════════════════════════════════════════
         RIGHT PANEL — white with dot grid
    ══════════════════════════════════════════════════════════ --}}
    <div class="flex-1 flex items-center justify-center px-5 py-10 sm:px-10 relative overflow-hidden"
         style="background: #fff;">

        {{-- Dot grid (same as hero page) --}}
        <div class="absolute inset-0 pointer-events-none"
             style="background-image: radial-gradient(circle, rgba(0,0,0,.07) 1.5px, transparent 1.5px);
                    background-size: 28px 28px;"></div>

        <div class="relative w-full max-w-[430px] g-form-anim">

            {{-- Mobile logo --}}
            <div class="flex lg:hidden justify-center mb-8">
                <img src="{{ asset('images/rtg-logo.png') }}" alt="Roddy Technologies" class="h-8 w-auto">
            </div>

            {{-- Form card --}}
            <div class="auth-card">
                {{ $slot }}
            </div>

            {{-- Back link --}}
            <p class="text-center mt-5 text-[12px]" style="color: #94a3b8;">
                <a href="{{ route('home') }}"
                   class="hover:text-slate-600 transition-colors duration-200">
                    ← Back to roddy.tech
                </a>
            </p>

        </div>
    </div>

</div>

</body>
</html>
