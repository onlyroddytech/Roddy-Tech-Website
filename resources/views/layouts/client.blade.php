<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} — Roddy Technologies</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900 antialiased">

    <div class="flex h-screen overflow-hidden">

        {{-- =====================================================
             SIDEBAR
        ====================================================== --}}
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col shrink-0">

            {{-- Logo --}}
            <div class="h-16 flex items-center px-6 border-b border-gray-200">
                <span class="text-lg font-bold text-indigo-600 tracking-tight">Roddy Technologies</span>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 px-4 py-6 space-y-1">

                <a href="{{ route('client.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('client.dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('client.projects.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('client.projects.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    My Projects
                </a>

                <a href="{{ route('client.billing.plans') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('client.billing.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    Billing
                </a>

            </nav>

            {{-- User info at bottom of sidebar --}}
            <div class="px-4 py-4 border-t border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 text-sm font-bold shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                    </div>
                </div>
            </div>

        </aside>

        {{-- =====================================================
             MAIN AREA
        ====================================================== --}}
        <div class="flex-1 flex flex-col overflow-hidden">

            {{-- Top Bar --}}
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 shrink-0">

                {{-- Page title --}}
                <h1 class="text-base font-semibold text-gray-900">{{ $title ?? 'Dashboard' }}</h1>

                {{-- Right side: notifications + logout --}}
                <div class="flex items-center gap-4">

                    {{-- Notification Bell --}}
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open"
                                class="relative p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            @if(auth()->user()->unreadNotificationCount() > 0)
                                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                            @endif
                        </button>

                        {{-- Notification dropdown --}}
                        <div x-show="open"
                             @click.outside="open = false"
                             x-transition
                             class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-200 z-50 overflow-hidden">

                            <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                                <span class="text-sm font-semibold text-gray-900">Notifications</span>
                                @if(auth()->user()->unreadNotificationCount() > 0)
                                    <span class="text-xs bg-red-100 text-red-600 font-medium px-2 py-0.5 rounded-full">
                                        {{ auth()->user()->unreadNotificationCount() }} new
                                    </span>
                                @endif
                            </div>

                            <div class="max-h-72 overflow-y-auto divide-y divide-gray-100">
                                @forelse(auth()->user()->notifications()->limit(6)->get() as $notification)
                                    <a href="{{ $notification->actionUrl() }}"
                                       class="block px-4 py-3 hover:bg-gray-50 transition {{ $notification->is_read ? 'opacity-60' : '' }}">
                                        <p class="text-sm font-medium text-gray-900">{{ $notification->title }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5">{{ $notification->message }}</p>
                                        <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                    </a>
                                @empty
                                    <div class="px-4 py-6 text-center text-sm text-gray-400">No notifications yet</div>
                                @endforelse
                            </div>

                        </div>
                    </div>

                    {{-- Logout --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="text-sm text-gray-500 hover:text-gray-700 hover:bg-gray-100 px-3 py-2 rounded-lg transition">
                            Sign out
                        </button>
                    </form>

                </div>
            </header>

            {{-- Flash message --}}
            @if(session('success'))
                <div class="mx-6 mt-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Page content --}}
            <main class="flex-1 overflow-y-auto p-6">
                {{ $slot }}
            </main>

        </div>
    </div>

</body>
</html>
