<x-layouts.admin title="Projects">

{{-- Header --}}
<div class="flex items-center justify-between mb-7">
    <div>
        <h1 class="text-lg font-semibold text-white">Projects</h1>
        <p class="text-xs mt-0.5" style="color: rgba(255,255,255,0.35);">All client projects across the platform</p>
    </div>
    <a href="{{ route('admin.projects.create') }}"
       class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white transition-all hover:opacity-90 hover:scale-[1.01]"
       style="background: linear-gradient(135deg, #2563eb, #7c3aed); box-shadow: 0 4px 16px rgba(37,99,235,0.35);">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        New Project
    </a>
</div>

{{-- Table --}}
<div class="rounded-2xl border overflow-hidden" style="background: #0d0d18; border-color: rgba(255,255,255,0.07);">
    <table class="w-full text-sm">
        <thead>
            <tr style="background: rgba(255,255,255,0.03); border-bottom: 1px solid rgba(255,255,255,0.06);">
                <th class="text-left px-6 py-3.5 text-[11px] font-semibold uppercase tracking-wider text-gray-500">Project</th>
                <th class="text-left px-6 py-3.5 text-[11px] font-semibold uppercase tracking-wider text-gray-500">Client</th>
                <th class="text-left px-6 py-3.5 text-[11px] font-semibold uppercase tracking-wider text-gray-500">Status</th>
                <th class="text-left px-6 py-3.5 text-[11px] font-semibold uppercase tracking-wider text-gray-500">Progress</th>
                <th class="text-left px-6 py-3.5 text-[11px] font-semibold uppercase tracking-wider text-gray-500">Deadline</th>
                <th class="text-right px-6 py-3.5 text-[11px] font-semibold uppercase tracking-wider text-gray-500">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($projects as $project)
            @php
                $sc = ['completed' => ['rgba(16,185,129,0.12)','#34d399','#10b981'],
                       'ongoing'   => ['rgba(59,130,246,0.12)', '#60a5fa','#3b82f6'],
                       'pending'   => ['rgba(234,179,8,0.12)',  '#fbbf24','#f59e0b']][$project->status->value]
                    ?? ['rgba(234,179,8,0.12)','#fbbf24','#f59e0b'];
            @endphp
            <tr class="border-b transition-colors" style="border-color: rgba(255,255,255,0.04);"
                onmouseover="this.style.background='rgba(255,255,255,0.025)'" onmouseout="this.style.background=''">
                <td class="px-6 py-4">
                    <a href="{{ route('admin.projects.show', $project) }}"
                       class="font-medium text-white hover:text-blue-400 transition text-[13px]">
                        {{ $project->title }}
                    </a>
                    @if($project->description)
                        <p class="text-[11px] text-gray-600 mt-0.5 truncate max-w-[220px]">{{ Str::limit($project->description, 55) }}</p>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 rounded-full flex items-center justify-center text-[9px] font-bold text-white shrink-0"
                             style="background: linear-gradient(135deg,#2563eb,#7c3aed);">
                            {{ strtoupper(substr($project->client?->name ?? '?', 0, 1)) }}
                        </div>
                        <span class="text-[13px] text-gray-400">{{ $project->client?->name ?? '—' }}</span>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-medium"
                          style="background: {{ $sc[0] }}; color: {{ $sc[1] }};">
                        <span class="w-1.5 h-1.5 rounded-full" style="background: {{ $sc[2] }};"></span>
                        {{ $project->status->label() }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2.5 min-w-[100px]">
                        <div class="flex-1 rounded-full h-1.5" style="background: rgba(255,255,255,0.08);">
                            <div class="h-1.5 rounded-full" style="width: {{ $project->progress }}%; background: linear-gradient(90deg,#3b82f6,#8b5cf6);"></div>
                        </div>
                        <span class="text-[11px] font-medium text-gray-400 shrink-0 w-7 text-right">{{ $project->progress }}%</span>
                    </div>
                </td>
                <td class="px-6 py-4">
                    @if($project->deadline)
                        <span class="text-[12px] {{ $project->isOverdue() ? 'text-red-400' : 'text-gray-400' }}">
                            {{ $project->deadline->format('M j, Y') }}
                            @if($project->isOverdue()) <span class="text-red-500">· overdue</span> @endif
                        </span>
                    @else
                        <span class="text-gray-600 text-[12px]">—</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-end gap-1">
                        <a href="{{ route('admin.projects.show', $project) }}"
                           class="p-1.5 rounded-lg transition-colors text-gray-500 hover:text-blue-400 hover:bg-blue-400/10">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </a>
                        <a href="{{ route('admin.projects.edit', $project) }}"
                           class="p-1.5 rounded-lg transition-colors text-gray-500 hover:text-purple-400 hover:bg-purple-400/10">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                        <form method="POST" action="{{ route('admin.projects.destroy', $project) }}"
                              onsubmit="return confirm('Delete this project?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="p-1.5 rounded-lg transition-colors text-gray-500 hover:text-red-400 hover:bg-red-400/10">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-16 text-center">
                    <div class="flex flex-col items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center" style="background: rgba(255,255,255,0.05);">
                            <svg class="w-6 h-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
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

{{-- Pagination --}}
@if($projects->hasPages())
<div class="mt-5 flex justify-end">
    {{ $projects->links() }}
</div>
@endif

</x-layouts.admin>
