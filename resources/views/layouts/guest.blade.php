<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'Roddy Technologies') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Inter', system-ui, sans-serif; }
        .orb { position: absolute; border-radius: 50%; pointer-events: none; filter: blur(60px); }
        .auth-input {
            width: 100%;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 12px;
            padding: 11px 14px;
            font-size: 13.5px;
            color: #fff;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }
        .auth-input::placeholder { color: rgba(255,255,255,0.3); }
        .auth-input:focus {
            border-color: rgba(99,102,241,0.6);
            box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
        }
        .auth-label { display: block; font-size: 12px; font-weight: 500; color: rgba(255,255,255,0.55); margin-bottom: 6px; letter-spacing: 0.03em; }
        .auth-btn {
            width: 100%;
            padding: 12px;
            border-radius: 12px;
            font-size: 13.5px;
            font-weight: 600;
            color: #fff;
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            border: none;
            cursor: pointer;
            transition: opacity .2s, transform .15s;
            box-shadow: 0 4px 20px rgba(37,99,235,0.4);
        }
        .auth-btn:hover { opacity: .92; transform: translateY(-1px); }
        .auth-btn:active { transform: scale(.98); }
        .auth-error { font-size: 12px; color: #f87171; margin-top: 5px; }
    </style>
</head>
<body class="antialiased" style="background: #04040a; color: #fff; min-height: 100vh;">

<div class="min-h-screen flex">

    {{-- ── Left panel — brand + orbs (hidden on mobile) ── --}}
    <div class="hidden lg:flex lg:w-[44%] xl:w-[42%] relative flex-col justify-between p-12 overflow-hidden"
         style="background: linear-gradient(160deg, #060614 0%, #0d0a2e 60%, #050510 100%);">

        {{-- Orbs --}}
        <div class="orb w-[500px] h-[500px] top-[-100px] left-[-100px]"
             style="background: radial-gradient(circle, rgba(37,99,235,0.28) 0%, transparent 70%);"></div>
        <div class="orb w-[400px] h-[400px] bottom-[-80px] right-[-100px]"
             style="background: radial-gradient(circle, rgba(124,58,237,0.24) 0%, transparent 70%);"></div>
        <div class="orb w-[250px] h-[250px] top-[50%] left-[30%]"
             style="background: radial-gradient(circle, rgba(16,185,129,0.08) 0%, transparent 70%);"></div>

        {{-- Fine grid --}}
        <div class="absolute inset-0 opacity-[0.025]"
             style="background-image: linear-gradient(rgba(255,255,255,.5) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.5) 1px, transparent 1px); background-size: 40px 40px;"></div>

        {{-- Logo --}}
        <div class="relative">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                <svg width="38" height="38" viewBox="0 0 30 30" fill="none">
                    <rect width="30" height="30" rx="8" fill="url(#guestLogo)"/>
                    <path d="M7.5 7.5h6.5a4.5 4.5 0 0 1 0 9H7.5V7.5z" fill="white"/>
                    <path d="M14 17l4.5 5.5h-5l-2-2.5" fill="white" opacity=".65"/>
                    <circle cx="21" cy="21" r="2.5" fill="white" opacity=".4"/>
                    <defs>
                        <linearGradient id="guestLogo" x1="0" y1="0" x2="30" y2="30" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#2563eb"/><stop offset="1" stop-color="#7c3aed"/>
                        </linearGradient>
                    </defs>
                </svg>
                <div>
                    <p class="text-[15px] font-bold text-white leading-none">Roddy Technologies</p>
                    <p class="text-[11px] mt-0.5" style="color: rgba(255,255,255,0.4);">Client Portal</p>
                </div>
            </a>
        </div>

        {{-- Center copy --}}
        <div class="relative">
            <p class="text-xs font-semibold uppercase tracking-widest mb-5" style="color: rgba(99,102,241,0.9);">Trusted by founders across Africa</p>
            <h2 class="text-4xl font-bold leading-[1.15] tracking-tight text-white mb-5">
                Build. Launch.<br>
                <span style="background: linear-gradient(135deg, #60a5fa, #a78bfa); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Scale.</span>
            </h2>
            <p class="text-sm leading-relaxed" style="color: rgba(255,255,255,0.45); max-width: 320px;">
                Access your project dashboard, track progress in real time, and collaborate with our team directly.
            </p>

            {{-- Testimonial quote --}}
            <div class="mt-10 p-5 rounded-2xl border" style="background: rgba(255,255,255,0.04); border-color: rgba(255,255,255,0.08);">
                <div class="flex gap-0.5 mb-3">
                    @for($i = 0; $i < 5; $i++)
                        <svg class="w-3 h-3" style="color:#fbbf24;" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @endfor
                </div>
                <p class="text-sm leading-relaxed" style="color: rgba(255,255,255,0.6);">"Roddy Technologies delivered our platform ahead of schedule. The quality is exceptional."</p>
                <div class="flex items-center gap-2.5 mt-4">
                    <div class="w-7 h-7 rounded-full flex items-center justify-center text-[10px] font-bold text-white"
                         style="background: linear-gradient(135deg,#2563eb,#7c3aed);">A</div>
                    <div>
                        <p class="text-xs font-semibold text-white">Alex M.</p>
                        <p class="text-[11px]" style="color: rgba(255,255,255,0.35);">Founder, StartupNG</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="relative">
            <p class="text-[11px]" style="color: rgba(255,255,255,0.25);">© {{ date('Y') }} Roddy Technologies · Built in Cameroon 🇨🇲</p>
        </div>
    </div>

    {{-- ── Right panel — form ── --}}
    <div class="flex-1 flex items-center justify-center px-6 py-12 relative"
         style="background: #07070f;">

        <div class="orb w-[400px] h-[400px] top-[-50px] right-[-50px] opacity-60"
             style="background: radial-gradient(circle, rgba(124,58,237,0.12) 0%, transparent 70%);"></div>

        <div class="relative w-full max-w-[400px]">
            {{-- Mobile logo --}}
            <div class="flex lg:hidden items-center gap-2.5 mb-10">
                <svg width="32" height="32" viewBox="0 0 30 30" fill="none">
                    <rect width="30" height="30" rx="7" fill="url(#guestLogoMob)"/>
                    <path d="M7.5 7.5h6.5a4.5 4.5 0 0 1 0 9H7.5V7.5z" fill="white"/>
                    <path d="M14 17l4.5 5.5h-5l-2-2.5" fill="white" opacity=".65"/>
                    <circle cx="21" cy="21" r="2.5" fill="white" opacity=".4"/>
                    <defs>
                        <linearGradient id="guestLogoMob" x1="0" y1="0" x2="30" y2="30" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#2563eb"/><stop offset="1" stop-color="#7c3aed"/>
                        </linearGradient>
                    </defs>
                </svg>
                <span class="text-sm font-semibold text-white">Roddy Technologies</span>
            </div>

            {{ $slot }}
        </div>
    </div>
</div>

</body>
</html>
