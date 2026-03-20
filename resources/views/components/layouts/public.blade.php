<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Roddy Technologies' }} | Building Digital Excellence</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800;14..32,900&family=Maven+Pro:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { --font-sans: 'Inter', ui-sans-serif, system-ui, -apple-system, sans-serif; }
        html, body, * { font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, sans-serif !important; }
        h1, h2, h3, h4 { font-family: 'Maven Pro', ui-sans-serif, system-ui, sans-serif !important; }
        [x-cloak] { display: none !important; }
        @keyframes drawer-spin-close {
            from { transform: rotate(-135deg); opacity: 0; }
            to   { transform: rotate(0deg);   opacity: 1; }
        }
        .drawer-close-btn { animation: drawer-spin-close 0.35s cubic-bezier(0.34,1.56,0.64,1) forwards; }
    </style>
</head>
<body class="antialiased bg-white text-gray-900">

{{-- ═══ NAVBAR ═══ --}}
<div x-data="{ menu: false, explore: false, support: false }" @keydown.escape.window="menu=false">

    {{-- Main nav bar --}}
    <nav class="fixed top-0 left-0 right-0 z-50 h-20 flex items-center"
         style="background: rgba(255,255,255,0.82); backdrop-filter: saturate(180%) blur(20px); -webkit-backdrop-filter: saturate(180%) blur(20px); border-bottom: 1px solid rgba(0,0,0,0.08);">

        <div class="w-full max-w-[1360px] mx-auto px-8 flex items-center justify-between">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center shrink-0">
                <img src="{{ asset('images/rtg-logo.png') }}" alt="Roddy Technologies" class="h-11 w-auto">
            </a>

            {{-- Desktop links --}}
            <div class="hidden lg:flex items-center gap-1 text-[16px] font-medium text-gray-700">

                <a href="{{ route('home') }}"           class="px-3 py-2 rounded-lg hover:text-gray-900 hover:bg-gray-100 transition-colors {{ request()->routeIs('home') ? 'text-gray-900 bg-gray-100' : '' }}">Home</a>
                <a href="{{ route('about') }}"          class="px-3 py-2 rounded-lg hover:text-gray-900 hover:bg-gray-100 transition-colors {{ request()->routeIs('about') ? 'text-gray-900 bg-gray-100' : '' }}">About</a>
                <a href="{{ route('services') }}"       class="px-3 py-2 rounded-lg hover:text-gray-900 hover:bg-gray-100 transition-colors {{ request()->routeIs('services') ? 'text-gray-900 bg-gray-100' : '' }}">Services</a>
                <a href="{{ route('projects.index') }}" class="px-3 py-2 rounded-lg hover:text-gray-900 hover:bg-gray-100 transition-colors {{ request()->routeIs('projects.*') ? 'text-gray-900 bg-gray-100' : '' }}">Work</a>
                <a href="{{ route('team') }}"           class="px-3 py-2 rounded-lg hover:text-gray-900 hover:bg-gray-100 transition-colors {{ request()->routeIs('team') ? 'text-gray-900 bg-gray-100' : '' }}">Team</a>

                {{-- Explore dropdown --}}
                <div class="relative" @mouseenter="explore=true" @mouseleave="explore=false">
                    <button class="flex items-center gap-1 px-3 py-2 rounded-lg hover:text-gray-900 hover:bg-gray-100 transition-colors">
                        Explore
                        <svg class="w-3 h-3 transition-transform duration-200" :class="explore?'rotate-180':''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="explore" x-cloak
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 -translate-y-1"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-end="opacity-0"
            class="absolute top-full left-1/2 -translate-x-1/2 mt-[26px] w-64 bg-white rounded-2xl border border-gray-100 shadow-xl shadow-black/10 p-1.5">
                        <a href="{{ route('blog.index') }}"     class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-gray-50 transition-colors">
                            <span class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center"><svg class="w-3.5 h-3.5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg></span>
                            <div><p class="text-[16px] font-medium text-gray-900">Blog</p><p class="text-[13px] text-gray-400">Insights & updates</p></div>
                        </a>
                        <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-gray-50 transition-colors">
                            <span class="w-7 h-7 rounded-lg bg-green-50 flex items-center justify-center"><svg class="w-3.5 h-3.5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg></span>
                            <div><p class="text-[16px] font-medium text-gray-900">Products</p><p class="text-[13px] text-gray-400">Tools we've shipped</p></div>
                        </a>
                        <a href="{{ route('pricing.index') }}"  class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-gray-50 transition-colors">
                            <span class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center"><svg class="w-3.5 h-3.5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg></span>
                            <div><p class="text-[16px] font-medium text-gray-900">Pricing</p><p class="text-[13px] text-gray-400">Transparent rates</p></div>
                        </a>
                        <a href="{{ route('store.index') }}"    class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-gray-50 transition-colors">
                            <span class="w-7 h-7 rounded-lg bg-green-50 flex items-center justify-center"><svg class="w-3.5 h-3.5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg></span>
                            <div><p class="text-[16px] font-medium text-gray-900">Store</p><p class="text-[13px] text-gray-400">Ready-made solutions</p></div>
                        </a>
                    </div>
                </div>

                {{-- Support dropdown --}}
                <div class="relative" @mouseenter="support=true" @mouseleave="support=false">
                    <button class="flex items-center gap-1 px-3 py-2 rounded-lg hover:text-gray-900 hover:bg-gray-100 transition-colors">
                        Support
                        <svg class="w-3 h-3 transition-transform duration-200" :class="support?'rotate-180':''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="support" x-cloak
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-end="opacity-0"
                    class="absolute top-full left-1/2 -translate-x-1/2 mt-[26px] w-64 bg-white rounded-2xl border border-gray-100 shadow-xl shadow-black/10 p-1.5">
                        <a href="{{ route('support.kb') }}"        class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-gray-50 transition-colors">
                            <span class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center"><svg class="w-3.5 h-3.5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></span>
                            <div><p class="text-[16px] font-medium text-gray-900">Knowledge Base</p><p class="text-[13px] text-gray-400">Docs & guides</p></div>
                        </a>
                        <a href="{{ route('support.tutorials') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-gray-50 transition-colors">
                            <span class="w-7 h-7 rounded-lg bg-green-50 flex items-center justify-center"><svg class="w-3.5 h-3.5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></span>
                            <div><p class="text-[16px] font-medium text-gray-900">Tutorials</p><p class="text-[13px] text-gray-400">Step-by-step videos</p></div>
                        </a>
                        <a href="{{ route('support.help') }}"      class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-gray-50 transition-colors">
                            <span class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center"><svg class="w-3.5 h-3.5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></span>
                            <div><p class="text-[16px] font-medium text-gray-900">Help Center</p><p class="text-[13px] text-gray-400">Common questions</p></div>
                        </a>
                    </div>
                </div>

                <a href="{{ route('contact') }}" class="px-3 py-2 rounded-lg hover:text-gray-900 hover:bg-gray-100 transition-colors {{ request()->routeIs('contact') ? 'text-gray-900 bg-gray-100' : '' }}">Contact</a>
            </div>

            {{-- Right side --}}
            <div class="flex items-center gap-2">
                @auth
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('client.dashboard') }}"
                    class="hidden lg:flex items-center gap-1.5 text-[13px] font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 px-3.5 py-2 rounded-[12px] transition-colors">
                        Dashboard
                    </a>
                @else
                    <div class="hidden lg:flex items-center gap-3">
                        <a href="{{ route('login') }}"
                        class="flex items-center gap-1.5 text-[13px] font-medium text-gray-700 hover:text-gray-900 transition-colors">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none">
                                <path d="M8 10V7a4 4 0 1 1 8 0v3" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                                <rect x="4" y="10" width="16" height="12" rx="3" fill="currentColor"/>
                                <circle cx="12" cy="16.5" r="1.6" fill="white"/>
                            </svg>
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                        class="inline-flex text-[13px] font-semibold text-white bg-gray-900 hover:bg-gray-700 px-4 py-2 rounded-[12px] transition-colors">
                            Sign up free
                        </a>
                    </div>
                @endauth

                {{-- Language switcher --}}
                <div class="hidden lg:block relative" x-data="{ langOpen: false }" @click.outside="langOpen=false">
                    <button @click="langOpen=!langOpen"
                            class="flex items-center gap-1.5 px-3 py-2 rounded-[10px] text-[13px] font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-colors"
                            :class="langOpen ? 'bg-gray-100 text-gray-900' : ''">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 100-18 9 9 0 000 18zm0 0c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9M3 12h18"/>
                        </svg>
                        <span x-text="$store.lang.current.code">EN</span>
                        <svg class="w-3 h-3 transition-transform duration-200" :class="langOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="langOpen"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-44 bg-white rounded-2xl border border-gray-100 shadow-xl shadow-black/10 p-1.5 z-50"
                         style="top:100%;">
                        <template x-for="lang in $store.lang.options" :key="lang.code">
                            <button @click="$store.lang.set(lang); langOpen=false"
                                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-left transition-colors"
                                    :class="$store.lang.current.code === lang.code ? 'bg-gray-50 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'">
                                <span class="text-base leading-none" x-text="lang.flag"></span>
                                <div>
                                    <p class="text-[12.5px] font-semibold leading-tight" x-text="lang.label"></p>
                                    <p class="text-[13px] text-gray-400 leading-tight" x-text="lang.native"></p>
                                </div>
                                <svg x-show="$store.lang.current.code === lang.code" class="w-3.5 h-3.5 text-blue-600 ml-auto shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                            </button>
                        </template>
                    </div>
                </div>

                {{-- Hamburger --}}
                <button @click="menu=!menu" class="lg:hidden w-9 h-9 flex items-center justify-center rounded-xl transition-colors group">
                    <svg x-show="!menu" class="w-5 h-5 text-green-500 group-hover:text-blue-600 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="menu" x-cloak class="drawer-close-btn w-5 h-5 text-green-500 group-hover:text-blue-600 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    {{-- ── Mobile Drawer Backdrop ── --}}
    <div x-show="menu" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="menu=false"
         class="lg:hidden fixed top-16 left-0 right-0 bottom-0 z-40"
         style="background:rgba(0,0,0,0.35); backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px);">
    </div>

    {{-- ── Mobile Drawer Panel ── --}}
    <div x-show="menu" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="lg:hidden fixed top-16 right-0 bottom-0 z-50 w-[280px] flex flex-col overflow-hidden"
         style="background:#fff; border-radius:0 0 0 12px; box-shadow:-4px 8px 32px rgba(0,0,0,0.10);">


        {{-- Drawer links --}}
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-0.5">

            <a href="{{ route('home') }}"           class="flex items-center gap-3 px-3 py-2.5 rounded-[10px] text-sm font-medium transition-colors {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                <svg class="w-[18px] h-[18px] text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Home
            </a>
            <a href="{{ route('about') }}"          class="flex items-center gap-3 px-3 py-2.5 rounded-[10px] text-sm font-medium transition-colors {{ request()->routeIs('about') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                <svg class="w-[18px] h-[18px] text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                About
            </a>
            <a href="{{ route('services') }}"       class="flex items-center gap-3 px-3 py-2.5 rounded-[10px] text-sm font-medium transition-colors {{ request()->routeIs('services') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                <svg class="w-[18px] h-[18px] text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                Services
            </a>
            <a href="{{ route('projects.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-[10px] text-sm font-medium transition-colors {{ request()->routeIs('projects.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                <svg class="w-[18px] h-[18px] text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                Work
            </a>
            <a href="{{ route('team') }}"           class="flex items-center gap-3 px-3 py-2.5 rounded-[10px] text-sm font-medium transition-colors {{ request()->routeIs('team') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                <svg class="w-[18px] h-[18px] text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Team
            </a>

            <div class="pt-4 pb-1.5 px-3">
                <div class="flex items-center gap-1.5">
                    <svg class="w-3 h-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 9m0 8V9m0 0L9 7"/></svg>
                    <p class="text-[10.5px] font-semibold uppercase tracking-widest text-gray-500">Explore</p>
                </div>
            </div>
            <a href="{{ route('blog.index') }}"     class="flex items-center gap-3 px-3 py-2.5 rounded-[10px] text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-colors">Blog</a>
            <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-[10px] text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-colors">Products</a>
            <a href="{{ route('pricing.index') }}"  class="flex items-center gap-3 px-3 py-2.5 rounded-[10px] text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-colors">Pricing</a>
            <a href="{{ route('store.index') }}"    class="flex items-center gap-3 px-3 py-2.5 rounded-[10px] text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-colors">Store</a>

            <div class="pt-4 pb-1.5 px-3">
                <div class="flex items-center gap-1.5">
                    <svg class="w-3 h-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <p class="text-[10.5px] font-semibold uppercase tracking-widest text-gray-500">Support</p>
                </div>
            </div>
            <a href="{{ route('support.kb') }}"        class="flex items-center gap-3 px-3 py-2.5 rounded-[10px] text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-colors">Knowledge Base</a>
            <a href="{{ route('support.tutorials') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-[10px] text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-colors">Tutorials</a>
            <a href="{{ route('support.help') }}"      class="flex items-center gap-3 px-3 py-2.5 rounded-[10px] text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-colors">Help Center</a>
            <a href="{{ route('contact') }}"           class="flex items-center gap-3 px-3 py-2.5 rounded-[10px] text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-colors">Contact</a>
        </nav>

        {{-- Drawer footer --}}
        <div class="shrink-0 px-4 py-5 border-t border-gray-100">
            @auth
                <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('client.dashboard') }}"
                   class="flex items-center justify-center w-full py-2.5 text-sm font-semibold text-white bg-gray-900 hover:bg-gray-700 rounded-[12px] transition-colors">
                    Go to Dashboard
                </a>
            @else
                <div class="flex items-center gap-2">
                    <a href="{{ route('login') }}"
                       class="flex-1 flex items-center justify-center gap-1.5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-[12px] transition-colors">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none">
                            <path d="M8 10V7a4 4 0 1 1 8 0v3" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                            <rect x="4" y="10" width="16" height="12" rx="3" fill="currentColor"/>
                            <circle cx="12" cy="16.5" r="1.6" fill="white"/>
                        </svg>
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                       class="flex-1 flex items-center justify-center py-2.5 text-sm font-semibold text-white bg-gray-900 hover:bg-gray-700 rounded-[12px] transition-colors">
                        Sign up free
                    </a>
                </div>
            @endauth
        </div>
    </div>

</div>{{-- end x-data --}}

{{-- ── PAGE CONTENT ── --}}
<main class="pt-20">
    @if(session('success'))
        <div class="max-w-[1360px] mx-auto px-8 pt-4">
            <div class="flex items-center gap-3 px-4 py-3 rounded-xl border border-green-200 bg-green-50 text-green-700 text-sm">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                {{ session('success') }}
            </div>
        </div>
    @endif
    {{ $slot }}
</main>

{{-- ═══ FOOTER ═══ --}}
<footer class="mt-24 border-t border-gray-100" style="background:#e8e8ed;">
    <div class="max-w-[1160px] mx-auto px-6 py-16">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-12">

            {{-- Brand --}}
            <div class="md:col-span-2">
                <a href="{{ route('home') }}" class="inline-flex mb-5">
                    <img src="{{ asset('images/rtg-logo.png') }}" alt="Roddy Technologies" class="h-11 w-auto">
                </a>
                <p class="text-sm text-gray-500 leading-relaxed max-w-xs">
                    Building premium digital products for businesses across Africa and beyond.
                </p>
                <div class="flex items-center gap-2.5 mt-6">
                    <a href="#" class="w-8 h-8 rounded-xl bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-colors">
                        <svg class="w-3.5 h-3.5 text-gray-500" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-xl bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-colors">
                        <svg class="w-3.5 h-3.5 text-gray-500" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-xl bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-colors">
                        <svg class="w-3.5 h-3.5 text-gray-500" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/></svg>
                    </a>
                </div>
            </div>

            <div>
                <h4 class="text-xs font-semibold uppercase tracking-widest text-gray-400 mb-5">Company</h4>
                <ul class="space-y-3.5 text-[13.5px]">
                    <li><a href="{{ route('about') }}"    class="text-gray-500 hover:text-gray-900 transition-colors">About Us</a></li>
                    <li><a href="{{ route('team') }}"     class="text-gray-500 hover:text-gray-900 transition-colors">Our Team</a></li>
                    <li><a href="{{ route('services') }}" class="text-gray-500 hover:text-gray-900 transition-colors">Services</a></li>
                    <li><a href="{{ route('contact') }}"  class="text-gray-500 hover:text-gray-900 transition-colors">Contact</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-xs font-semibold uppercase tracking-widest text-gray-400 mb-5">Explore</h4>
                <ul class="space-y-3.5 text-[13.5px]">
                    <li><a href="{{ route('blog.index') }}"     class="text-gray-500 hover:text-gray-900 transition-colors">Blog</a></li>
                    <li><a href="{{ route('products.index') }}" class="text-gray-500 hover:text-gray-900 transition-colors">Products</a></li>
                    <li><a href="{{ route('pricing.index') }}"  class="text-gray-500 hover:text-gray-900 transition-colors">Pricing</a></li>
                    <li><a href="{{ route('store.index') }}"    class="text-gray-500 hover:text-gray-900 transition-colors">Store</a></li>
                    <li><a href="{{ route('projects.index') }}" class="text-gray-500 hover:text-gray-900 transition-colors">Our Work</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-xs font-semibold uppercase tracking-widest text-gray-400 mb-5">Support</h4>
                <ul class="space-y-3.5 text-[13.5px]">
                    <li><a href="{{ route('support.kb') }}"        class="text-gray-500 hover:text-gray-900 transition-colors">Knowledge Base</a></li>
                    <li><a href="{{ route('support.tutorials') }}"  class="text-gray-500 hover:text-gray-900 transition-colors">Tutorials</a></li>
                    <li><a href="{{ route('support.help') }}"       class="text-gray-500 hover:text-gray-900 transition-colors">Help Center</a></li>
                    <li><a href="{{ route('login') }}"              class="text-gray-500 hover:text-gray-900 transition-colors">Client Portal</a></li>
                </ul>
            </div>
        </div>

        <div class="mt-14 pt-8 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-[12.5px] text-gray-400">&copy; {{ date('Y') }} Roddy Technologies. All rights reserved.</p>
            <div class="flex items-center gap-4 text-[12.5px] text-gray-400">
                <span>Built in Cameroon 🇨🇲</span>
                <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                <a href="{{ route('contact') }}" class="hover:text-gray-600 transition-colors">Privacy</a>
                <a href="{{ route('contact') }}" class="hover:text-gray-600 transition-colors">Terms</a>
            </div>
        </div>
    </div>
</footer>

<script>
document.addEventListener('alpine:init', function () {
    Alpine.store('lang', {
        options: [
            { code: 'EN', label: 'English',  native: 'English',   flag: '🇬🇧' },
            { code: 'FR', label: 'French',   native: 'Français',  flag: '🇫🇷' },
            { code: 'ES', label: 'Spanish',  native: 'Español',   flag: '🇪🇸' },
            { code: 'SG', label: 'Singapore',native: '新加坡',     flag: '🇸🇬' },
        ],
        current: { code: 'EN', label: 'English', native: 'English', flag: '🇬🇧' },
        set(lang) { this.current = lang; }
    });
});
</script>
</body>
</html>
