<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin' }} — Roddy Technologies</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Inter', system-ui, sans-serif; }
        .sidebar-link { display: flex; align-items: center; gap: 10px; padding: 7px 12px; border-radius: 10px; font-size: 13px; font-weight: 500; color: #9ca3af; transition: all .15s; }
        .sidebar-link:hover { background: rgba(255,255,255,0.07); color: #e5e7eb; }
        .sidebar-link.active { background: rgba(37,99,235,0.2); color: #93c5fd; }
        .sidebar-link.active svg { color: #60a5fa; }
        .sidebar-link svg { width: 16px; height: 16px; flex-shrink: 0; opacity: .7; transition: opacity .15s; }
        .sidebar-link:hover svg { opacity: 1; }
        .sidebar-section { font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: .08em; color: #4b5563; padding: 16px 12px 6px; }
    </style>
</head>
<body class="antialiased flex min-h-screen" style="background: #080810; color: #f1f5f9;">

{{-- ═══════════════════════════════════════════════════════
     SIDEBAR
════════════════════════════════════════════════════════ --}}
<aside class="w-[220px] flex flex-col shrink-0 border-r" style="background: #0d0d18; border-color: rgba(255,255,255,0.07);">

    {{-- Logo --}}
    <div class="h-14 flex items-center px-4 border-b" style="border-color: rgba(255,255,255,0.07);">
        <div class="flex items-center gap-2.5 min-w-0">
            <svg width="26" height="26" viewBox="0 0 30 30" fill="none">
                <rect width="30" height="30" rx="7" fill="url(#sidebarLogo)"/>
                <path d="M7.5 7.5h6.5a4.5 4.5 0 0 1 0 9H7.5V7.5z" fill="white"/>
                <path d="M14 17l4.5 5.5h-5l-2-2.5" fill="white" opacity=".6"/>
                <circle cx="21" cy="21" r="2.5" fill="white" opacity=".35"/>
                <defs>
                    <linearGradient id="sidebarLogo" x1="0" y1="0" x2="30" y2="30" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#2563eb"/><stop offset="1" stop-color="#7c3aed"/>
                    </linearGradient>
                </defs>
            </svg>
            <div class="min-w-0">
                <p class="text-[12px] font-semibold text-white leading-none">Roddy Tech</p>
                <p class="text-[10px] text-gray-500 mt-0.5">Admin Panel</p>
            </div>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 px-3 py-3 overflow-y-auto space-y-0.5">

        <a href="{{ route('admin.dashboard') }}"
           class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Dashboard
        </a>

        <div class="sidebar-section">Projects</div>
        <a href="{{ route('admin.projects.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
            </svg>
            All Projects
        </a>
        <a href="{{ route('admin.projects.create') }}" class="sidebar-link">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            New Project
        </a>

        <div class="sidebar-section">Inbox</div>
        <a href="{{ route('admin.contact-messages.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.contact-messages.*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            Contact Messages
            @php $unreadCount = \App\Models\ContactMessage::unread()->count(); @endphp
            @if($unreadCount)
            <span class="ml-auto text-[10px] font-bold px-1.5 py-0.5 rounded-full"
                  style="background: rgba(37,99,235,0.3); color: #93c5fd;">
                {{ $unreadCount }}
            </span>
            @endif
        </a>

        <div class="sidebar-section">People</div>
        <a href="{{ route('admin.users.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Users
        </a>
        <a href="{{ route('admin.referrals.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.referrals.*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
            </svg>
            Referrals
        </a>

        <div class="sidebar-section">Finance</div>
        <a href="{{ route('admin.payments.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
            </svg>
            Payments
        </a>

        <div class="sidebar-section">Website CMS</div>
        <a href="{{ route('admin.cms.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.cms.*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Content
        </a>
        <a href="{{ route('admin.services.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
            Services
        </a>
        <a href="{{ route('admin.blog.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.blog.*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            Blog
        </a>
        <a href="{{ route('admin.team.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.team.*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            Team
        </a>
        <a href="{{ route('admin.products.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            Products
        </a>
        <a href="{{ route('admin.pricing.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.pricing.*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
            </svg>
            Pricing
        </a>
        <a href="{{ route('admin.faqs.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            FAQs
        </a>

    </nav>

    {{-- User --}}
    <div class="px-3 py-3 border-t" style="border-color: rgba(255,255,255,0.07);">
        <div class="flex items-center gap-2.5 px-2 py-2 rounded-xl" style="background: rgba(255,255,255,0.04);">
            <div class="w-7 h-7 rounded-lg flex items-center justify-center text-xs font-bold text-white shrink-0"
                 style="background: linear-gradient(135deg,#2563eb,#7c3aed);">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                <p class="text-[10px] text-gray-500">Administrator</p>
            </div>
        </div>
        <div class="flex items-center gap-2 mt-2 px-2">
            <a href="{{ route('home') }}" target="_blank"
               class="flex-1 text-center text-[11px] text-gray-500 hover:text-gray-300 transition py-1">
                View Site
            </a>
            <span class="text-gray-700">·</span>
            <form method="POST" action="{{ route('logout') }}" class="flex-1">
                @csrf
                <button class="w-full text-center text-[11px] text-red-500 hover:text-red-400 transition py-1">Logout</button>
            </form>
        </div>
    </div>
</aside>

{{-- ═══════════════════════════════════════════════════════
     MAIN CONTENT AREA
════════════════════════════════════════════════════════ --}}
<div class="flex-1 flex flex-col min-w-0">

    {{-- Topbar --}}
    <header class="h-14 flex items-center justify-between px-6 border-b shrink-0"
            style="background: #0d0d18; border-color: rgba(255,255,255,0.07);">
        <h1 class="text-[13px] font-semibold text-white">{{ $title ?? 'Dashboard' }}</h1>
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}" target="_blank"
               class="flex items-center gap-1.5 text-[11px] font-medium text-gray-400 hover:text-white transition px-3 py-1.5 rounded-lg hover:bg-white/5">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                View Website
            </a>
        </div>
    </header>

    {{-- Content --}}
    <main class="flex-1 p-6 overflow-auto">
        @if(session('success'))
            <div class="mb-5 flex items-center gap-3 px-4 py-3 rounded-xl border text-sm"
                 style="background: rgba(16,185,129,0.08); border-color: rgba(16,185,129,0.2); color: #6ee7b7;">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-5 flex items-center gap-3 px-4 py-3 rounded-xl border text-sm"
                 style="background: rgba(239,68,68,0.08); border-color: rgba(239,68,68,0.2); color: #fca5a5;">
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
