<x-layouts.public title="Our Team">

{{-- ═══ HERO ═══ --}}
<section class="relative pt-32 pb-20 px-6 overflow-hidden bg-[#04040a]">
    <div class="orb w-[450px] h-[450px] top-[-80px] left-[-60px]"
         style="background: radial-gradient(circle, rgba(37,99,235,0.22) 0%, transparent 70%);"></div>
    <div class="orb w-[350px] h-[350px] bottom-0 right-[-60px]"
         style="background: radial-gradient(circle, rgba(16,185,129,0.12) 0%, transparent 70%);"></div>
    <div class="absolute inset-0 opacity-[0.025]"
         style="background-image: linear-gradient(rgba(255,255,255,.5) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.5) 1px, transparent 1px); background-size: 40px 40px;"></div>

    <div class="relative max-w-4xl mx-auto text-center">
        <div class="inline-flex items-center gap-2 mb-6 px-4 py-1.5 rounded-full text-xs font-medium text-green-300 border"
             style="background: rgba(16,185,129,0.1); border-color: rgba(16,185,129,0.3);">
            <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse"></span>
            The People
        </div>
        <h1 class="text-5xl sm:text-6xl font-bold tracking-tight text-white leading-[1.08] mb-6">
            Meet the team<br>
            <span style="background: linear-gradient(135deg, #34d399, #60a5fa); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                behind the work
            </span>
        </h1>
        <p class="text-lg text-gray-400 max-w-2xl mx-auto leading-relaxed">
            Talented engineers, designers, and strategists building the next generation of African tech.
        </p>
    </div>
</section>

{{-- ═══ TEAM GRID ═══ --}}
<section class="py-24 px-6 bg-white">
    <div class="max-w-6xl mx-auto">
        @if($members->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($members as $member)
            <div class="group relative p-6 rounded-2xl border border-gray-100 bg-white hover:shadow-xl hover:shadow-blue-50 hover:border-blue-200 transition-all duration-300 text-center">
                {{-- Avatar --}}
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-5 text-lg font-bold text-white transition-transform duration-300 group-hover:scale-110"
                     style="background: linear-gradient(135deg, #2563eb, #7c3aed);">
                    {{ strtoupper(substr($member->name, 0, 1)) }}
                </div>
                <h3 class="font-semibold text-gray-900 text-[14px]">{{ $member->name }}</h3>
                <p class="text-xs font-medium mt-1 mb-3"
                   style="background: linear-gradient(135deg, #2563eb, #7c3aed); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    {{ $member->role }}
                </p>
                @if($member->bio)
                    <p class="text-xs text-gray-400 leading-relaxed">{{ Str::limit($member->bio, 90) }}</p>
                @endif
                @if($member->twitter || $member->linkedin)
                <div class="flex items-center justify-center gap-3 mt-4">
                    @if($member->twitter)
                    <a href="{{ $member->twitter }}" target="_blank" class="text-gray-300 hover:text-blue-400 transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                    </a>
                    @endif
                    @if($member->linkedin)
                    <a href="{{ $member->linkedin }}" target="_blank" class="text-gray-300 hover:text-blue-400 transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </a>
                    @endif
                </div>
                @endif
                <div class="absolute bottom-0 left-6 right-6 h-px bg-gradient-to-r from-transparent via-blue-400/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-20">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-5"
                 style="background: linear-gradient(135deg,#eff6ff,#dbeafe);">
                <svg class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <p class="text-gray-500 font-medium">Team members coming soon.</p>
        </div>
        @endif
    </div>
</section>

{{-- ═══ JOIN CTA ═══ --}}
<section class="py-24 px-6 bg-[#fafafa]">
    <div class="max-w-2xl mx-auto text-center">
        <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-6"
             style="background: linear-gradient(135deg,#f5f3ff,#ede9fe);">
            <svg class="w-6 h-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
        </div>
        <h2 class="text-4xl font-bold text-gray-900 tracking-tight mb-4">Want to join us?</h2>
        <p class="text-gray-500 mb-9">We're always looking for passionate engineers and designers who want to build the future of African tech.</p>
        <a href="{{ route('contact') }}"
           class="inline-block px-8 py-4 rounded-2xl text-sm font-semibold text-white transition-all hover:scale-[1.02]"
           style="background: linear-gradient(135deg, #2563eb, #7c3aed); box-shadow: 0 12px 40px rgba(37,99,235,0.35);">
            Get In Touch
        </a>
    </div>
</section>

</x-layouts.public>
