<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }} — Roddy Technologies</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Inter', system-ui, sans-serif; }
        .cl-link { display: flex; align-items: center; gap: 10px; padding: 8px 12px; border-radius: 10px; font-size: 13px; font-weight: 500; color: #6b7280; transition: all .15s; }
        .cl-link:hover { background: #f3f4f6; color: #111827; }
        .cl-link.active { background: #eff6ff; color: #1d4ed8; }
        .cl-link.active svg { color: #3b82f6; }
        .cl-link svg { width: 16px; height: 16px; flex-shrink: 0; color: #9ca3af; }
        .cl-link.active svg, .cl-link:hover svg { color: inherit; }
    </style>
</head>
<body class="antialiased flex min-h-screen" style="background: #f5f7fa; color: #111827;">

{{-- ═══════════════════════════════════════════════════════
     SIDEBAR
════════════════════════════════════════════════════════ --}}
<aside class="w-[220px] flex flex-col shrink-0 bg-white border-r border-gray-200/80 shadow-sm">

    {{-- Logo --}}
    <div class="h-14 flex items-center px-4 border-b border-gray-100">
        <a href="{{ route('client.dashboard') }}" class="flex items-center gap-2.5">
            <svg width="26" height="26" viewBox="0 0 30 30" fill="none">
                <rect width="30" height="30" rx="7" fill="url(#clientLogo)"/>
                <path d="M7.5 7.5h6.5a4.5 4.5 0 0 1 0 9H7.5V7.5z" fill="white"/>
                <path d="M14 17l4.5 5.5h-5l-2-2.5" fill="white" opacity=".65"/>
                <circle cx="21" cy="21" r="2.5" fill="white" opacity=".4"/>
                <defs>
                    <linearGradient id="clientLogo" x1="0" y1="0" x2="30" y2="30" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#2563eb"/><stop offset="1" stop-color="#7c3aed"/>
                    </linearGradient>
                </defs>
            </svg>
            <div>
                <p class="text-[12px] font-semibold text-gray-900 leading-none">Roddy Tech</p>
                <p class="text-[10px] text-gray-400 mt-0.5">Client Portal</p>
            </div>
        </a>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 px-3 py-3 space-y-0.5">

        <a href="{{ route('client.dashboard') }}"
           class="cl-link {{ request()->routeIs('client.dashboard') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Overview
        </a>

        <a href="{{ route('client.projects.index') }}"
           class="cl-link {{ request()->routeIs('client.projects.*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
            </svg>
            My Projects
        </a>

        <a href="{{ route('client.payments.index') }}"
           class="cl-link {{ request()->routeIs('client.payments.*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
            </svg>
            Payments
        </a>

        <a href="{{ route('client.referrals.index') }}"
           class="cl-link {{ request()->routeIs('client.referrals.*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
            </svg>
            Referrals
        </a>

        <a href="{{ route('client.notifications.index') }}"
           class="cl-link {{ request()->routeIs('client.notifications.*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            Notifications
            @php $unread = auth()->user()->unreadNotificationCount(); @endphp
            @if($unread > 0)
                <span class="ml-auto text-[10px] font-semibold text-white px-1.5 py-0.5 rounded-full"
                      style="background: linear-gradient(135deg,#2563eb,#7c3aed);">{{ $unread }}</span>
            @endif
        </a>

    </nav>

    {{-- User footer --}}
    <div class="px-3 py-3 border-t border-gray-100">
        <div class="flex items-center gap-2.5 px-2 py-2 rounded-xl bg-gray-50">
            <div class="w-7 h-7 rounded-lg flex items-center justify-center text-xs font-bold text-white shrink-0"
                 style="background: linear-gradient(135deg,#2563eb,#7c3aed);">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-semibold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                <p class="text-[10px] text-gray-400 truncate">{{ auth()->user()->email }}</p>
            </div>
        </div>
        <div class="flex items-center gap-1 mt-2 px-1">
            <a href="{{ route('home') }}"
               class="flex-1 text-center text-[11px] text-gray-400 hover:text-gray-600 transition py-1.5 rounded-lg hover:bg-gray-50">
                ← Site
            </a>
            <form method="POST" action="{{ route('logout') }}" class="flex-1">
                @csrf
                <button class="w-full text-center text-[11px] text-red-400 hover:text-red-600 transition py-1.5 rounded-lg hover:bg-red-50">
                    Logout
                </button>
            </form>
        </div>
    </div>
</aside>

{{-- ═══════════════════════════════════════════════════════
     MAIN
════════════════════════════════════════════════════════ --}}
<div class="flex-1 flex flex-col min-w-0">

    {{-- Topbar --}}
    <header class="h-14 bg-white border-b border-gray-200/80 flex items-center justify-between px-6 shrink-0 shadow-sm">
        <h1 class="text-[13px] font-semibold text-gray-900">{{ $title ?? 'Dashboard' }}</h1>
        <div class="flex items-center gap-2">
            <span class="text-[11px] text-gray-400">Welcome back, {{ auth()->user()->name }}</span>
        </div>
    </header>

    <main class="flex-1 p-6 overflow-auto">
        @if(session('success'))
            <div class="mb-5 flex items-center gap-3 px-4 py-3 rounded-xl border border-green-200 bg-green-50 text-green-700 text-sm">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-5 flex items-center gap-3 px-4 py-3 rounded-xl border border-red-200 bg-red-50 text-red-700 text-sm">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif
        {{ $slot }}
    </main>
</div>

</body>
</html>
