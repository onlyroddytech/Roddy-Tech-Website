<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin' }} — Roddy Technologies</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900 antialiased">

    <div class="flex h-screen overflow-hidden">

        {{-- =====================================================
             SIDEBAR — dark blue/black
        ====================================================== --}}
        <aside class="w-64 bg-gray-900 flex flex-col shrink-0">

            {{-- Logo --}}
            <div class="h-16 flex items-center px-6 border-b border-gray-700">
                <div>
                    <span class="text-white font-bold text-base tracking-tight">Roddy Technologies</span>
                    <span class="ml-2 text-xs bg-blue-600 text-white px-2 py-0.5 rounded font-medium">Admin</span>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 px-4 py-6 space-y-1">

                <a href="{{ route('admin.projects.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('admin.projects.*') ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Projects
                </a>

            </nav>

            {{-- Admin user at bottom --}}
            <div class="px-4 py-4 border-t border-gray-700">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-bold shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400 truncate">Administrator</p>
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

                <h1 class="text-base font-semibold text-gray-900">{{ $title ?? 'Admin Panel' }}</h1>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="text-sm text-gray-500 hover:text-gray-700 hover:bg-gray-100 px-3 py-2 rounded-lg transition">
                        Sign out
                    </button>
                </form>

            </header>

            {{-- Flash messages --}}
            @if(session('success'))
                <div class="mx-6 mt-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mx-6 mt-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg">
                    {{ session('error') }}
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