{{--
    ┌──────────────────────────────────────────────────────────────────┐
    │  PROJECT DETAIL — resources/views/public/projects/show.blade.php │
    │  Design rules: no gradients, brand blue/green, white/#f8f9fa bg  │
    └──────────────────────────────────────────────────────────────────┘
--}}
<x-layouts.public title="{{ $project->title }} — Roddy Technologies">

@php
$isCompleted = $project->status === \App\Enums\ProjectStatus::Completed;
$isOngoing   = $project->status === \App\Enums\ProjectStatus::Ongoing;
$accentColor = $isCompleted ? '#059669' : ($isOngoing ? '#2563eb' : '#d97706');
@endphp

<style>
.reveal { opacity:0; transform:translateY(20px); transition:opacity .6s ease,transform .6s ease; }
.reveal.visible { opacity:1; transform:translateY(0); }

.prog-track { height:6px; border-radius:9999px; background:#e5e7eb; overflow:hidden; }
.prog-fill  { height:100%; border-radius:9999px; width:0;
              transition:width 1.4s cubic-bezier(0.22,1,0.36,1); }

.timeline-item:last-child .timeline-line { display:none; }

.btn-primary {
    background:#2563eb;
    transition:background .18s ease, transform .18s ease, box-shadow .18s ease;
}
.btn-primary:hover {
    background:#1d4ed8;
    transform:translateY(-2px);
    box-shadow:0 10px 28px rgba(37,99,235,0.28);
}
.btn-primary:active { transform:scale(0.97); }
</style>


{{-- ════════════════════════════════════════════════════════════════
     HERO — dark header
════════════════════════════════════════════════════════════════ --}}
<section class="bg-[#0f172a] pt-32 pb-16 px-4 sm:px-6">
    <div class="max-w-5xl mx-auto">

        {{-- Back link --}}
        <a href="{{ route('projects.index') }}"
           class="inline-flex items-center gap-2 text-slate-400 hover:text-white text-sm font-medium
                  transition-colors duration-150 mb-10 group">
            <svg class="w-4 h-4 transition-transform duration-150 group-hover:-translate-x-1"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Projects
        </a>

        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-6">
            <div class="flex-1">
                {{-- Status badge --}}
                <div class="flex items-center gap-3 mb-5">
                    @if($isOngoing)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
                                 bg-blue-900/50 border border-blue-700 text-blue-300 text-xs font-bold">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
                        In Progress
                    </span>
                    @elseif($isCompleted)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
                                 bg-green-900/40 border border-green-700 text-green-300 text-xs font-bold">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Delivered
                    </span>
                    @else
                    <span class="px-3 py-1 rounded-full bg-yellow-900/40 border border-yellow-700
                                 text-yellow-300 text-xs font-bold">
                        Pending
                    </span>
                    @endif

                    <span class="text-slate-500 text-xs font-semibold">{{ $project->progress }}% complete</span>
                </div>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight text-white
                           leading-[1.08] mb-4 max-w-[640px]">
                    {{ $project->title }}
                </h1>
                <p class="text-base sm:text-lg text-slate-400 leading-relaxed max-w-[580px]">
                    {{ $project->description }}
                </p>
            </div>

            {{-- Progress ring (desktop) --}}
            <div class="shrink-0 hidden sm:flex flex-col items-center justify-center
                        w-32 h-32 rounded-2xl border border-slate-700 bg-slate-800/60">
                <p class="text-3xl font-black text-white">{{ $project->progress }}<span class="text-lg">%</span></p>
                <p class="text-[10px] font-bold uppercase tracking-widest mt-1" style="color:{{ $accentColor }}">
                    {{ $isCompleted ? 'Done' : 'Progress' }}
                </p>
            </div>
        </div>

        {{-- Progress bar --}}
        <div class="mt-10">
            <div class="prog-track">
                <div class="prog-fill" data-width="{{ $project->progress }}"
                     style="background:{{ $accentColor }};"></div>
            </div>
        </div>

    </div>
</section>


{{-- ════════════════════════════════════════════════════════════════
     META STRIP
════════════════════════════════════════════════════════════════ --}}
<section class="bg-white border-b border-gray-100 py-6 px-4 sm:px-6">
    <div class="max-w-5xl mx-auto">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6">

            {{-- Status --}}
            <div class="text-center py-4 px-3 rounded-xl bg-gray-50 border border-gray-100">
                <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Status</p>
                <p class="text-sm font-black text-gray-900">{{ $project->status->label() }}</p>
            </div>

            {{-- Progress --}}
            <div class="text-center py-4 px-3 rounded-xl bg-gray-50 border border-gray-100">
                <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Progress</p>
                <p class="text-sm font-black" style="color:{{ $accentColor }}">{{ $project->progress }}%</p>
            </div>

            {{-- Start date --}}
            <div class="text-center py-4 px-3 rounded-xl bg-gray-50 border border-gray-100">
                <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Started</p>
                <p class="text-sm font-black text-gray-900">
                    {{ $project->start_date ? $project->start_date->format('M d, Y') : '—' }}
                </p>
            </div>

            {{-- Deadline --}}
            <div class="text-center py-4 px-3 rounded-xl bg-gray-50 border border-gray-100">
                <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">
                    {{ $isCompleted ? 'Delivered' : 'Deadline' }}
                </p>
                <p class="text-sm font-black {{ $project->isOverdue() ? 'text-red-600' : 'text-gray-900' }}">
                    {{ $project->deadline ? $project->deadline->format('M d, Y') : '—' }}
                </p>
            </div>

        </div>
    </div>
</section>


{{-- ════════════════════════════════════════════════════════════════
     MAIN CONTENT — timeline + sidebar
════════════════════════════════════════════════════════════════ --}}
<section class="bg-[#f8f9fa] py-16 sm:py-20 px-4 sm:px-6">
    <div class="max-w-5xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

            {{-- Timeline (2/3 width) --}}
            <div class="lg:col-span-2">

                @if($project->updates->count())
                <div class="reveal mb-3">
                    <p class="text-xs font-bold text-blue-600 uppercase tracking-widest mb-2">Activity</p>
                    <h2 class="text-2xl sm:text-3xl font-black text-gray-900">Project Timeline</h2>
                </div>

                <div class="reveal mt-8 space-y-0">
                    @foreach($project->updates as $i => $update)
                    <div class="timeline-item relative flex gap-5 pb-8">

                        {{-- Line + dot --}}
                        <div class="flex flex-col items-center shrink-0">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center border shadow-sm z-10"
                                 style="background:{{ $accentColor }}15; border-color:{{ $accentColor }}30;">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"
                                     style="color:{{ $accentColor }}">
                                    @if($update->progress >= 100)
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    @else
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    @endif
                                </svg>
                            </div>
                            <div class="timeline-line w-px flex-1 mt-2" style="background:{{ $accentColor }}20;"></div>
                        </div>

                        {{-- Content --}}
                        <div class="flex-1 bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
                            <div class="flex items-start justify-between gap-3 mb-2">
                                <p class="text-base font-semibold text-gray-900 leading-snug">
                                    {{ $update->message }}
                                </p>
                                <span class="shrink-0 text-xs font-black px-2 py-0.5 rounded-full"
                                      style="background:{{ $accentColor }}15; color:{{ $accentColor }};">
                                    {{ $update->progress }}%
                                </span>
                            </div>
                            <p class="text-xs text-gray-400 font-semibold">
                                {{ $update->created_at->format('M d, Y · g:i A') }}
                            </p>
                            {{-- Mini progress bar --}}
                            <div class="mt-3 prog-track" style="height:3px;">
                                <div class="prog-fill" data-width="{{ $update->progress }}"
                                     style="background:{{ $accentColor }};"></div>
                            </div>
                        </div>

                    </div>
                    @endforeach
                </div>

                @else
                <div class="reveal bg-white border border-gray-200 rounded-2xl p-10 text-center">
                    <div class="w-12 h-12 rounded-xl bg-gray-100 border border-gray-200
                                flex items-center justify-center mx-auto mb-4">
                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-base font-semibold text-gray-500">No updates yet — check back soon.</p>
                </div>
                @endif

                {{-- Project Cover Photo --}}
                @if($project->image)
                <div class="reveal mt-8">
                    <div class="rounded-2xl overflow-hidden border border-gray-200 shadow-sm">
                        <img src="{{ asset('storage/' . $project->image) }}"
                             alt="{{ $project->title }}"
                             class="w-full h-auto object-cover max-h-[480px]">
                    </div>
                </div>
                @else
                <div class="reveal mt-8">
                    <div class="rounded-2xl overflow-hidden border border-gray-200 bg-gray-100
                                flex items-center justify-center" style="min-height:320px;">
                        <div class="text-center p-10">
                            <div class="w-14 h-14 rounded-2xl bg-white border border-gray-200 shadow-sm
                                        flex items-center justify-center mx-auto mb-4">
                                <svg class="w-6 h-6 text-gray-300" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 20.25h18A1.5 1.5 0 0022.5 18.75V5.25A1.5 1.5 0 0021 3.75H3A1.5 1.5 0 001.5 5.25v13.5A1.5 1.5 0 003 20.25z"/>
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-gray-400">Project photo coming soon</p>
                        </div>
                    </div>
                </div>
                @endif

            </div>

            {{-- Sidebar (1/3 width) --}}
            <div class="space-y-5">

                {{-- Project summary card --}}
                <div class="reveal bg-white border border-gray-200 rounded-2xl p-6">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Project Summary</p>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Completion</span>
                            <span class="text-sm font-black" style="color:{{ $accentColor }}">{{ $project->progress }}%</span>
                        </div>
                        <div class="prog-track">
                            <div class="prog-fill" data-width="{{ $project->progress }}"
                                 style="background:{{ $accentColor }};"></div>
                        </div>

                        <div class="pt-2 space-y-3 border-t border-gray-100">
                            @if($project->updates->count())
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">Updates</span>
                                <span class="font-bold text-gray-900">{{ $project->updates->count() }}</span>
                            </div>
                            @endif
                            @if($project->start_date)
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">Started</span>
                                <span class="font-bold text-gray-900">{{ $project->start_date->format('M d, Y') }}</span>
                            </div>
                            @endif
                            @if($project->deadline)
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">{{ $isCompleted ? 'Delivered' : 'Due' }}</span>
                                <span class="font-bold {{ $project->isOverdue() ? 'text-red-600' : 'text-gray-900' }}">
                                    {{ $project->deadline->format('M d, Y') }}
                                </span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Status card --}}
                <div class="reveal rounded-2xl p-6 border"
                     style="background:{{ $accentColor }}08; border-color:{{ $accentColor }}20;">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                             style="background:{{ $accentColor }}18;">
                            @if($isCompleted)
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                                 style="color:{{ $accentColor }}">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            @else
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"
                                 style="color:{{ $accentColor }}">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            @endif
                        </div>
                        <p class="text-sm font-black" style="color:{{ $accentColor }}">
                            {{ $project->status->label() }}
                        </p>
                    </div>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        @if($isCompleted)
                            This project has been fully delivered and signed off by the client.
                        @elseif($isOngoing)
                            This project is actively in development. Updates are posted regularly.
                        @else
                            This project is queued and will begin shortly.
                        @endif
                    </p>
                </div>

                {{-- CTA card --}}
                <div class="reveal bg-[#0f172a] border border-slate-800 rounded-2xl p-6 text-center">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Start Something Similar</p>
                    <p class="text-base font-black text-white mb-5 leading-snug">
                        Have a project like this in mind?
                    </p>
                    <a href="{{ route('contact') }}"
                       class="btn-primary block w-full py-3 rounded-xl text-white text-sm font-bold text-center">
                        Start a Project
                    </a>
                    <a href="{{ route('projects.index') }}"
                       class="block mt-3 text-sm text-slate-500 hover:text-slate-300 transition-colors duration-150 font-medium">
                        ← Back to all projects
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>


{{-- ════════════════════════════════════════════════════════════════
     SCRIPTS
════════════════════════════════════════════════════════════════ --}}
<script>
(function () {
    /* Scroll reveal */
    var els = document.querySelectorAll('.reveal');
    if (els.length) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) { e.target.classList.add('visible'); io.unobserve(e.target); }
            });
        }, { threshold: 0.08 });
        els.forEach(function (el) { io.observe(el); });
    }

    /* Animate all progress bars */
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
        }, { threshold: 0.2 });
        fills.forEach(function (b) { barObs.observe(b); });
    }
}());
</script>

</x-layouts.public>
