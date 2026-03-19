<x-layouts.client title="Overview">

{{-- Welcome banner --}}
<div class="relative mb-7 rounded-2xl overflow-hidden px-8 py-7"
     style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #0f172a 100%);">
    <div class="absolute top-0 right-0 w-64 h-64 opacity-20"
         style="background: radial-gradient(circle, #7c3aed 0%, transparent 70%); pointer-events: none;"></div>
    <div class="relative">
        <p class="text-xs font-semibold text-indigo-300 uppercase tracking-widest mb-1.5">Welcome back</p>
        <h1 class="text-xl font-bold text-white mb-1">{{ auth()->user()->name }}</h1>
        <p class="text-sm text-gray-400">Here's an overview of your projects and activity.</p>
    </div>
</div>

{{-- Stat cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-7">
    @php
    $statCards = [
        ['label' => 'Total Projects', 'value' => $stats['total'],     'icon' => 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z', 'color' => '#2563eb', 'bg' => '#eff6ff', 'text' => '#1e40af'],
        ['label' => 'Ongoing',        'value' => $stats['ongoing'],   'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',                                 'color' => '#7c3aed', 'bg' => '#f5f3ff', 'text' => '#5b21b6'],
        ['label' => 'Completed',      'value' => $stats['completed'], 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',                              'color' => '#059669', 'bg' => '#f0fdf4', 'text' => '#065f46'],
        ['label' => 'Unread Alerts',  'value' => $stats['unread'],    'icon' => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9', 'color' => '#d97706', 'bg' => '#fffbeb', 'text' => '#92400e'],
    ];
    @endphp
    @foreach($statCards as $sc)
    <div class="bg-white rounded-2xl p-5 border border-gray-200/60 shadow-sm">
        <div class="flex items-start justify-between mb-4">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background: {{ $sc['bg'] }};">
                <svg class="w-4.5 h-4.5" style="color: {{ $sc['color'] }}; width: 18px; height: 18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $sc['icon'] }}"/>
                </svg>
            </div>
        </div>
        <p class="text-3xl font-bold mb-1" style="color: {{ $sc['text'] }};">{{ $sc['value'] }}</p>
        <p class="text-xs text-gray-400 font-medium">{{ $sc['label'] }}</p>
    </div>
    @endforeach
</div>

{{-- Projects list --}}
<div class="bg-white rounded-2xl border border-gray-200/60 shadow-sm overflow-hidden">
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
        <div>
            <h2 class="text-sm font-semibold text-gray-900">My Projects</h2>
            <p class="text-xs text-gray-400 mt-0.5">Your active and completed work</p>
        </div>
        <a href="{{ route('client.projects.index') }}"
           class="flex items-center gap-1 text-[11px] font-medium text-blue-600 hover:text-blue-800 transition px-3 py-1.5 rounded-lg hover:bg-blue-50">
            View all
            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </a>
    </div>

    @forelse($projects as $project)
    <div class="group px-6 py-4 border-b border-gray-50 last:border-0 hover:bg-gray-50/70 transition-colors">
        <div class="flex items-start justify-between gap-4">
            <div class="flex-1 min-w-0">
                <a href="{{ route('client.projects.show', $project) }}"
                   class="font-semibold text-[13px] text-gray-900 hover:text-blue-600 transition-colors">
                    {{ $project->title }}
                </a>
                @if($project->latestUpdate?->message)
                    <p class="text-xs text-gray-400 mt-0.5 truncate">{{ $project->latestUpdate->message }}</p>
                @endif

                {{-- Progress bar --}}
                <div class="mt-3 flex items-center gap-3">
                    <div class="flex-1 bg-gray-100 rounded-full h-1.5 max-w-xs overflow-hidden">
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

            {{-- Status badge --}}
            @php
                $map = ['completed'=>['bg'=>'bg-green-50','text'=>'text-green-700','dot'=>'bg-green-400'],
                        'ongoing'  =>['bg'=>'bg-blue-50', 'text'=>'text-blue-700', 'dot'=>'bg-blue-400'],
                        'pending'  =>['bg'=>'bg-amber-50','text'=>'text-amber-700','dot'=>'bg-amber-400']];
                $s = $map[$project->status->value] ?? $map['pending'];
            @endphp
            <div class="flex flex-col items-end gap-2 shrink-0">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-medium {{ $s['bg'] }} {{ $s['text'] }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $s['dot'] }}"></span>
                    {{ $project->status->label() }}
                </span>
                @if($project->payment)
                    @php
                        $pm = ['paid'=>['bg'=>'bg-green-50','text'=>'text-green-600'],
                               'partial'=>['bg'=>'bg-yellow-50','text'=>'text-yellow-600'],
                               'unpaid'=>['bg'=>'bg-red-50','text'=>'text-red-600']];
                        $p = $pm[$project->payment->status->value] ?? $pm['unpaid'];
                    @endphp
                    <span class="text-[10px] font-medium px-2 py-0.5 rounded-full {{ $p['bg'] }} {{ $p['text'] }}">
                        {{ $project->payment->status->label() }}
                    </span>
                @endif
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
        <p class="text-xs text-gray-400">Get in touch with us to start a project.</p>
        <a href="{{ route('contact') }}" class="mt-4 inline-block text-xs font-medium text-blue-600 hover:underline">Contact us →</a>
    </div>
    @endforelse
</div>

</x-layouts.client>
