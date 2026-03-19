<x-layouts.client title="My Projects">

{{-- Header --}}
<div class="mb-7">
    <h1 class="text-base font-semibold text-gray-900">My Projects</h1>
    <p class="text-xs text-gray-400 mt-0.5">All your active and completed projects</p>
</div>

{{-- Projects list --}}
<div class="bg-white rounded-2xl border border-gray-200/60 shadow-sm overflow-hidden">
    @forelse($projects as $project)
    @php
        $map = ['completed'=>['bg-green-50','text-green-700','bg-green-400'],
                'ongoing'  =>['bg-blue-50', 'text-blue-700', 'bg-blue-400'],
                'pending'  =>['bg-amber-50','text-amber-700','bg-amber-400']];
        $s = $map[$project->status->value] ?? $map['pending'];
    @endphp
    <div class="group px-6 py-5 border-b border-gray-50 last:border-0 hover:bg-gray-50/70 transition-colors">
        <div class="flex items-start justify-between gap-4">
            <div class="flex-1 min-w-0">
                <a href="{{ route('client.projects.show', $project) }}"
                   class="font-semibold text-[13px] text-gray-900 hover:text-blue-600 transition-colors">
                    {{ $project->title }}
                </a>
                @if($project->description)
                    <p class="text-xs text-gray-400 mt-0.5 truncate">{{ Str::limit($project->description, 80) }}</p>
                @endif

                {{-- Progress bar --}}
                <div class="mt-3 flex items-center gap-3 max-w-xs">
                    <div class="flex-1 bg-gray-100 rounded-full h-1.5 overflow-hidden">
                        <div class="h-1.5 rounded-full transition-all duration-700"
                             style="width: {{ $project->progress }}%; background: linear-gradient(90deg, #3b82f6, #7c3aed);"></div>
                    </div>
                    <span class="text-xs font-medium text-gray-400 shrink-0">{{ $project->progress }}%</span>
                </div>

                @if($project->deadline)
                    <p class="mt-1.5 text-[11px] text-gray-400">
                        Due {{ $project->deadline->format('M j, Y') }}
                        @if($project->isOverdue())
                            <span class="text-red-400 font-medium ml-1">· Overdue</span>
                        @endif
                    </p>
                @endif
            </div>

            <div class="flex flex-col items-end gap-2 shrink-0">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-medium {{ $s[0] }} {{ $s[1] }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $s[2] }}"></span>
                    {{ $project->status->label() }}
                </span>

                @if($project->payment)
                @php
                    $pm = ['paid'=>['bg-green-50','text-green-600'],
                           'partial'=>['bg-yellow-50','text-yellow-600'],
                           'unpaid'=>['bg-red-50','text-red-600']];
                    $p = $pm[$project->payment->status->value] ?? $pm['unpaid'];
                @endphp
                <span class="text-[10px] font-medium px-2 py-0.5 rounded-full {{ $p[0] }} {{ $p[1] }}">
                    {{ $project->payment->status->label() }}
                </span>
                @endif

                <a href="{{ route('client.projects.show', $project) }}"
                   class="text-[11px] font-medium text-blue-600 hover:text-blue-800 transition mt-1">
                    View →
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="px-6 py-16 text-center">
        <div class="w-12 h-12 rounded-2xl bg-gray-100 flex items-center justify-center mx-auto mb-4">
            <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
            </svg>
        </div>
        <p class="text-sm font-medium text-gray-600 mb-1">No projects yet</p>
        <p class="text-xs text-gray-400 mb-4">Get in touch with us to start a project.</p>
        <a href="{{ route('contact') }}" class="text-xs font-medium text-blue-600 hover:underline">Contact us →</a>
    </div>
    @endforelse
</div>

</x-layouts.client>
