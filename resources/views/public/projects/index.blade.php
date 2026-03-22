{{--
    ┌──────────────────────────────────────────────────────────────────┐
    │  PROJECTS / WORK PAGE  — resources/views/public/projects/index   │
    │                                                                  │
    │  Design rules (site-wide):                                       │
    │   - NO gradients — plain solid backgrounds only                  │
    │   - Backgrounds: white / #f8f9fa / #0f172a                      │
    │   - Brand: #2563eb (blue) · #059669 (green) · #0f172a (dark)   │
    │   - Cards: bg-white / bg-gray-100, gray-900/600 text            │
    │   - Hover: translateY(-6px) scale(1.02), 0.18s ease-out        │
    │   - Scroll reveal via IntersectionObserver                      │
    └──────────────────────────────────────────────────────────────────┘
--}}
<x-layouts.public title="Our Work">

@php
$ongoingProjects   = $projects->getCollection()->filter(fn($p) => $p->status === \App\Enums\ProjectStatus::Ongoing);
$completedProjects = $projects->getCollection()->filter(fn($p) => $p->status === \App\Enums\ProjectStatus::Completed);
@endphp

<style>
/* ── Scroll reveal ─────────────────────────────────────────────── */
.reveal {
    opacity: 0;
    transform: translateY(22px);
    transition: opacity 0.6s ease, transform 0.6s ease;
}
.reveal.visible { opacity: 1; transform: translateY(0); }

/* ── Ongoing project cards ─────────────────────────────────────── */
.proj-card {
    will-change: transform, box-shadow;
    box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    transition: transform 0.18s cubic-bezier(0.22,1,0.36,1),
                box-shadow 0.18s cubic-bezier(0.22,1,0.36,1),
                border-color 0.18s ease;
}
.proj-card:hover {
    transform: translateY(-6px) scale(1.02);
    box-shadow: 0 24px 56px rgba(0,0,0,0.10);
    border-color: #bfdbfe;
}

/* ── Portfolio cards ───────────────────────────────────────────── */
.port-card {
    will-change: transform, box-shadow;
    box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    transition: transform 0.18s cubic-bezier(0.22,1,0.36,1),
                box-shadow 0.18s cubic-bezier(0.22,1,0.36,1),
                border-color 0.18s ease;
}
.port-card:hover {
    transform: translateY(-6px) scale(1.02);
    box-shadow: 0 20px 48px rgba(0,0,0,0.10);
    border-color: #bfdbfe;
}
.port-img { transition: transform 0.4s cubic-bezier(0.22,1,0.36,1); }
.port-card:hover .port-img { transform: scale(1.05); }


/* ── Progress bar ──────────────────────────────────────────────── */
.prog-track { height: 4px; border-radius: 9999px; background: #e5e7eb; overflow: hidden; }
.prog-fill  { height: 100%; border-radius: 9999px; width: 0;
              transition: width 1.2s cubic-bezier(0.22,1,0.36,1); }

/* ── CTA buttons ───────────────────────────────────────────────── */
.btn-primary {
    background: #2563eb;
    transition: background 0.18s ease, transform 0.18s ease, box-shadow 0.18s ease;
}
.btn-primary:hover { background: #1d4ed8; transform: translateY(-2px); box-shadow: 0 10px 28px rgba(37,99,235,0.30); }
.btn-primary:active { transform: scale(0.97); }
.btn-ghost { transition: background 0.18s ease, transform 0.18s ease; }
.btn-ghost:hover { background: rgba(255,255,255,0.10); transform: translateY(-2px); }
</style>


{{-- ════════════════════════════════════════════════════════════════
     1. HERO
════════════════════════════════════════════════════════════════ --}}
<section class="bg-[#0f172a] pt-32 pb-24 px-4 sm:px-6">
    <div class="max-w-7xl mx-auto text-center">

        <div class="inline-flex items-center gap-2 mb-7 px-4 py-1.5 rounded-full
                    bg-blue-900/40 border border-blue-800 text-blue-300 text-xs font-bold uppercase tracking-widest">
            <span class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></span>
            Portfolio & Work
        </div>

        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight text-white
                   leading-[1.08] max-w-[720px] mx-auto mb-6">
            Our Work
        </h1>

        <p class="text-base sm:text-lg text-slate-400 leading-relaxed max-w-[600px] mx-auto mb-12">
            Explore our projects, ongoing work, and the digital solutions we've built
            for clients and our own platforms.
        </p>

        <div class="flex flex-wrap items-center justify-center gap-10 sm:gap-16">
            @foreach([
                [$projects->total(), 'Total Projects'],
                [$ongoingProjects->count(), 'In Progress'],
                [$completedProjects->count(), 'Delivered'],
            ] as [$n, $label])
            <div class="text-center">
                <p class="text-3xl sm:text-4xl font-black text-white">{{ $n }}+</p>
                <p class="text-xs text-slate-500 font-semibold uppercase tracking-widest mt-1">{{ $label }}</p>
            </div>
            @endforeach
        </div>

    </div>
</section>


{{-- ════════════════════════════════════════════════════════════════
     2. ONGOING PROJECTS
════════════════════════════════════════════════════════════════ --}}
@if($ongoingProjects->count())
<section class="bg-white py-20 sm:py-28 px-4 sm:px-6">
    <div class="max-w-7xl mx-auto">

        <div class="reveal flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-12">
            <div>
                <p class="text-xs font-bold text-blue-600 uppercase tracking-widest mb-3">Active Work</p>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight text-gray-900">
                    Ongoing Projects
                </h2>
            </div>
            <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full
                         bg-blue-50 border border-blue-100 text-blue-600 text-xs font-bold shrink-0">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                Currently in development
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @foreach($ongoingProjects as $i => $project)
            @php $colors = ['#2563eb','#059669']; $col = $colors[$i % 2]; @endphp
            <div class="reveal proj-card bg-white border border-gray-200 rounded-2xl overflow-hidden">

                {{-- Image / visual header --}}
                <div class="relative h-52 sm:h-60 overflow-hidden flex items-center justify-center"
                     style="background: {{ $col }}12;">
                    <div class="text-center">
                        <div class="w-14 h-14 rounded-2xl mx-auto mb-3 flex items-center justify-center border"
                             style="background: {{ $col }}22; border-color: {{ $col }}33;">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"
                                 style="color: {{ $col }};">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                            </svg>
                        </div>
                        <p class="text-xs font-bold uppercase tracking-widest" style="color: {{ $col }};">In Development</p>
                    </div>
                    {{-- In progress badge --}}
                    <div class="absolute top-4 left-4">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
                                     text-white text-xs font-bold shadow" style="background: {{ $col }};">
                            <span class="w-1.5 h-1.5 rounded-full bg-white/70 animate-pulse"></span>
                            In Progress
                        </span>
                    </div>
                    {{-- % badge --}}
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1 rounded-full bg-white text-gray-900 text-xs font-black shadow border border-gray-100">
                            {{ $project->progress }}% Complete
                        </span>
                    </div>
                </div>

                {{-- Body --}}
                <div class="p-6 sm:p-7">
                    <div class="flex items-start justify-between gap-4 mb-3">
                        <h3 class="text-[18px] font-black text-gray-900 leading-snug">{{ $project->title }}</h3>
                        @if($project->deadline)
                        <span class="shrink-0 text-xs text-gray-400 font-semibold mt-0.5 whitespace-nowrap">
                            Due {{ $project->deadline->format('M Y') }}
                        </span>
                        @endif
                    </div>

                    <p class="text-base text-gray-600 leading-relaxed mb-6">{{ $project->description }}</p>

                    {{-- Progress bar --}}
                    <div class="flex items-center justify-between text-xs font-semibold text-gray-400 mb-2">
                        <span>Progress</span>
                        <span class="font-black" style="color: {{ $col }};">{{ $project->progress }}%</span>
                    </div>
                    <div class="prog-track">
                        <div class="prog-fill" data-width="{{ $project->progress }}"
                             style="background: {{ $col }};"></div>
                    </div>

                    {{-- Latest update --}}
                    @if($project->updates->isNotEmpty())
                    <div class="mt-5 pt-4 border-t border-gray-100 flex items-start gap-3">
                        <span class="w-1.5 h-1.5 rounded-full mt-1.5 shrink-0" style="background: {{ $col }};"></span>
                        <p class="text-sm text-gray-500 leading-relaxed">
                            <span class="font-semibold text-gray-700">Latest: </span>
                            {{ Str::limit($project->updates->first()->message, 110) }}
                        </p>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif


{{-- ════════════════════════════════════════════════════════════════
     3. PORTFOLIO — completed projects
════════════════════════════════════════════════════════════════ --}}
@if($completedProjects->count())
<section class="bg-[#f8f9fa] py-20 sm:py-28 px-4 sm:px-6">
    <div class="max-w-7xl mx-auto">

        <div class="reveal text-center mb-12">
            <p class="text-xs font-bold text-blue-600 uppercase tracking-widest mb-4">Delivered Work</p>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight text-gray-900 mb-4">
                Portfolio
            </h2>
            <p class="text-base text-gray-500 max-w-[600px] mx-auto">
                A selection of projects we've successfully designed, built, and delivered.
            </p>
        </div>

        {{-- Filter + Grid (Alpine.js) --}}
        <div x-data="{ active: 'All' }" class="reveal">

        {{-- Filter buttons --}}
        <div class="flex flex-wrap items-center justify-center gap-2 mb-12">
            @foreach(['All', 'Website', 'Web App', 'SaaS', 'Mobile App', 'Internal Product', 'Demo'] as $cat)
            <button @click="active = '{{ $cat }}'"
                    :class="active === '{{ $cat }}'
                        ? 'bg-blue-600 text-white border-blue-600'
                        : 'bg-white text-gray-600 border-gray-200 hover:border-blue-600 hover:text-blue-600'"
                    class="px-4 py-2 rounded-xl border text-sm font-semibold transition-all duration-150">
                {{ $cat }}
            </button>
            @endforeach
        </div>

        {{-- Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($completedProjects as $i => $project)
            @php
                $cols = ['#2563eb','#059669'];
                $col  = $cols[$i % 2];
                $categories = ['Website','Web App','SaaS','Mobile App','Internal Product','Demo'];
                $cat  = $categories[$i % count($categories)];
            @endphp
            <div x-show="active === 'All' || active === '{{ $cat }}'"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="port-card bg-white border border-gray-200 rounded-2xl overflow-hidden cursor-default">

                {{-- Image mockup --}}
                <div class="relative h-44 overflow-hidden flex items-center justify-center"
                     style="background: {{ $col }}10;">
                    <div class="port-img absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <div class="w-11 h-11 rounded-xl mx-auto mb-2 flex items-center justify-center border"
                                 style="background: {{ $col }}20; border-color: {{ $col }}30;">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"
                                     style="color: {{ $col }};">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <p class="text-[10px] font-bold uppercase tracking-widest" style="color: {{ $col }}; opacity:.6;">Completed</p>
                        </div>
                    </div>
                    <div class="absolute top-3 left-3">
                        <span class="px-2.5 py-1 rounded-full bg-white/90 text-gray-700 text-[11px] font-bold shadow-sm border border-gray-100">
                            {{ $cat }}
                        </span>
                    </div>
                    <div class="absolute top-3 right-3">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full
                                     bg-green-500 text-white text-[11px] font-bold">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            Delivered
                        </span>
                    </div>
                </div>

                {{-- Body --}}
                <div class="p-5 sm:p-6">
                    <h3 class="text-[18px] font-black text-gray-900 mb-2">{{ $project->title }}</h3>
                    <p class="text-base text-gray-600 leading-relaxed mb-5">
                        {{ Str::limit($project->description, 110) }}
                    </p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-green-500"></span>
                            <span class="text-xs text-gray-400 font-semibold">100% Complete</span>
                        </div>
                        <a href="{{ route('projects.show', $project->id) }}"
                           class="inline-flex items-center gap-1.5 text-sm font-bold text-blue-600
                                  hover:text-blue-800 transition-colors duration-150">
                            View Project
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($projects->hasPages())
        <div class="mt-14 flex justify-center">
            {{ $projects->links() }}
        </div>
        @endif

        </div>{{-- end x-data --}}
    </div>
</section>
@endif


{{-- ════════════════════════════════════════════════════════════════
     EMPTY STATE
════════════════════════════════════════════════════════════════ --}}
@if($projects->isEmpty())
<section class="bg-white py-28 px-4 sm:px-6">
    <div class="max-w-md mx-auto text-center">
        <div class="w-16 h-16 rounded-2xl bg-gray-100 border border-gray-200
                    flex items-center justify-center mx-auto mb-6">
            <svg class="w-7 h-7 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
        </div>
        <h3 class="text-xl font-black text-gray-900 mb-2">Projects coming soon</h3>
        <p class="text-base text-gray-500 leading-relaxed">We're working on some amazing things. Check back shortly.</p>
    </div>
</section>
@endif


{{-- ════════════════════════════════════════════════════════════════
     5. CTA
════════════════════════════════════════════════════════════════ --}}
<section class="bg-[#0f172a] py-20 sm:py-28 px-4 sm:px-6">
    <div class="max-w-3xl mx-auto text-center">

        <div class="reveal inline-flex items-center gap-2 mb-7 px-4 py-1.5 rounded-full
                    bg-blue-900/40 border border-blue-800 text-blue-300 text-xs font-bold uppercase tracking-widest">
            <span class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></span>
            Start Building
        </div>

        <h2 class="reveal text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight text-white
                   leading-[1.07] mb-5 max-w-[600px] mx-auto">
            Got a project in mind?
        </h2>

        <p class="reveal text-slate-400 text-base sm:text-lg mb-10 max-w-[520px] mx-auto leading-relaxed">
            We turn ideas into powerful digital products. Our team will respond within 24 hours.
        </p>

        <div class="reveal flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('contact') }}"
               class="btn-primary w-full sm:w-auto px-8 py-3.5 rounded-xl text-white text-sm font-bold text-center">
                Start a Project
            </a>
            <a href="{{ route('contact') }}"
               class="btn-ghost w-full sm:w-auto px-8 py-3.5 rounded-xl border border-slate-600
                      text-white text-sm font-bold text-center">
                Contact Us
            </a>
        </div>

        <div class="reveal mt-14 flex flex-col sm:flex-row items-center justify-center gap-5 sm:gap-10">
            @foreach(['50+ Projects Delivered', '30+ Happy Clients', '24h Response Time'] as $proof)
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                <span class="text-sm text-slate-400 font-medium">{{ $proof }}</span>
            </div>
            @endforeach
        </div>

    </div>
</section>


{{-- ════════════════════════════════════════════════════════════════
     SCRIPTS
════════════════════════════════════════════════════════════════ --}}
<script>
(function () {
    /* Scroll reveal */
    var revealEls = document.querySelectorAll('.reveal');
    if (revealEls.length) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) { e.target.classList.add('visible'); io.unobserve(e.target); }
            });
        }, { threshold: 0.08 });
        revealEls.forEach(function (el) { io.observe(el); });
    }

    /* Progress bars — animate width on scroll into view */
    var fills = document.querySelectorAll('.prog-fill');
    if (fills.length) {
        var barObs = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) {
                    var w = e.target.dataset.width + '%';
                    requestAnimationFrame(function () {
                        requestAnimationFrame(function () { e.target.style.width = w; });
                    });
                    barObs.unobserve(e.target);
                }
            });
        }, { threshold: 0.3 });
        fills.forEach(function (b) { barObs.observe(b); });
    }
}());
</script>

</x-layouts.public>
