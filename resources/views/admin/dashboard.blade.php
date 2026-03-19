<x-layouts.admin title="Dashboard">

{{-- Stat cards --}}
<div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-8">
    @php
    $cards = [
        ['label' => 'Total Clients',  'value' => $stats['clients'],   'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
         'from' => '#1e3a5f', 'to' => '#1e40af', 'accent' => '#60a5fa'],
        ['label' => 'All Projects',   'value' => $stats['projects'],  'icon' => 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z',
         'from' => '#2d1b69', 'to' => '#4c1d95', 'accent' => '#a78bfa'],
        ['label' => 'Ongoing',        'value' => $stats['ongoing'],   'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
         'from' => '#1c3a2a', 'to' => '#14532d', 'accent' => '#4ade80'],
        ['label' => 'Completed',      'value' => $stats['completed'], 'icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z',
         'from' => '#1f2d1a', 'to' => '#14532d', 'accent' => '#86efac'],
        ['label' => 'Unpaid',         'value' => $stats['unpaid'],    'icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z',
         'from' => '#3b1515', 'to' => '#7f1d1d', 'accent' => '#f87171'],
        ['label' => 'Referrals',      'value' => $stats['referrals'], 'icon' => 'M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z',
         'from' => '#2d1f4a', 'to' => '#581c87', 'accent' => '#c084fc'],
    ];
    @endphp

    @foreach($cards as $card)
    <div class="relative rounded-2xl p-4 overflow-hidden border" style="background: linear-gradient(135deg, {{ $card['from'] }}, {{ $card['to'] }}); border-color: rgba(255,255,255,0.07);">
        <div class="flex items-start justify-between mb-3">
            <div class="w-8 h-8 rounded-xl flex items-center justify-center" style="background: rgba(255,255,255,0.1);">
                <svg class="w-4 h-4" style="color: {{ $card['accent'] }};" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $card['icon'] }}"/>
                </svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-white mb-0.5">{{ $card['value'] }}</p>
        <p class="text-[11px] font-medium" style="color: {{ $card['accent'] }}; opacity: .8;">{{ $card['label'] }}</p>
    </div>
    @endforeach
</div>

{{-- Recent Projects --}}
<div class="rounded-2xl border overflow-hidden" style="background: #0d0d18; border-color: rgba(255,255,255,0.07);">
    <div class="flex items-center justify-between px-6 py-4 border-b" style="border-color: rgba(255,255,255,0.07);">
        <div>
            <h2 class="text-sm font-semibold text-white">Recent Projects</h2>
            <p class="text-xs text-gray-500 mt-0.5">Latest 5 across all clients</p>
        </div>
        <a href="{{ route('admin.projects.index') }}"
           class="flex items-center gap-1 text-[11px] font-medium text-blue-400 hover:text-blue-300 transition px-3 py-1.5 rounded-lg hover:bg-blue-400/10">
            View all
            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </a>
    </div>

    <table class="w-full text-sm">
        <thead>
            <tr style="background: rgba(255,255,255,0.03); border-bottom: 1px solid rgba(255,255,255,0.06);">
                <th class="text-left px-6 py-3 text-[11px] font-semibold uppercase tracking-wider text-gray-500">Project</th>
                <th class="text-left px-6 py-3 text-[11px] font-semibold uppercase tracking-wider text-gray-500">Client</th>
                <th class="text-left px-6 py-3 text-[11px] font-semibold uppercase tracking-wider text-gray-500">Status</th>
                <th class="text-left px-6 py-3 text-[11px] font-semibold uppercase tracking-wider text-gray-500">Progress</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentProjects as $project)
            <tr class="border-b transition-colors" style="border-color: rgba(255,255,255,0.04);"
                onmouseover="this.style.background='rgba(255,255,255,0.025)'" onmouseout="this.style.background=''">
                <td class="px-6 py-4">
                    <a href="{{ route('admin.projects.show', $project) }}"
                       class="font-medium text-white hover:text-blue-400 transition text-[13px]">
                        {{ $project->title }}
                    </a>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <div class="w-5 h-5 rounded-full flex items-center justify-center text-[9px] font-bold text-white shrink-0"
                             style="background: linear-gradient(135deg,#2563eb,#7c3aed);">
                            {{ strtoupper(substr($project->client?->name ?? '?', 0, 1)) }}
                        </div>
                        <span class="text-[13px] text-gray-400">{{ $project->client?->name ?? '—' }}</span>
                    </div>
                </td>
                <td class="px-6 py-4">
                    @php
                        $statusColors = ['completed' => ['bg'=>'rgba(16,185,129,0.12)','text'=>'#34d399','dot'=>'#10b981'],
                                         'ongoing'   => ['bg'=>'rgba(59,130,246,0.12)', 'text'=>'#60a5fa','dot'=>'#3b82f6'],
                                         'pending'   => ['bg'=>'rgba(234,179,8,0.12)',  'text'=>'#fbbf24','dot'=>'#f59e0b']];
                        $sc = $statusColors[$project->status->value] ?? $statusColors['pending'];
                    @endphp
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-medium"
                          style="background: {{ $sc['bg'] }}; color: {{ $sc['text'] }};">
                        <span class="w-1.5 h-1.5 rounded-full" style="background: {{ $sc['dot'] }};"></span>
                        {{ $project->status->label() }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2.5 min-w-[100px]">
                        <div class="flex-1 rounded-full h-1.5" style="background: rgba(255,255,255,0.08);">
                            <div class="h-1.5 rounded-full transition-all"
                                 style="width: {{ $project->progress }}%; background: linear-gradient(90deg, #3b82f6, #8b5cf6);"></div>
                        </div>
                        <span class="text-[11px] font-medium text-gray-400 shrink-0">{{ $project->progress }}%</span>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-14 text-center">
                    <div class="flex flex-col items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl flex items-center justify-center" style="background: rgba(255,255,255,0.05);">
                            <svg class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500">No projects yet.</p>
                        <a href="{{ route('admin.projects.create') }}" class="text-xs font-medium text-blue-400 hover:text-blue-300 transition">Create the first one →</a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

</x-layouts.admin>
