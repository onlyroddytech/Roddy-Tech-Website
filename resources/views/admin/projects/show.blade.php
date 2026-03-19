<x-layouts.admin title="{{ $project->title }}">

{{-- Breadcrumb --}}
<div class="flex items-center gap-2 text-xs text-gray-500 mb-6">
    <a href="{{ route('admin.projects.index') }}" class="hover:text-gray-300 transition">Projects</a>
    <span>/</span>
    <span class="text-gray-300">{{ Str::limit($project->title, 40) }}</span>
</div>

{{-- Page header --}}
<div class="flex items-start justify-between mb-7 gap-4">
    <div>
        <h1 class="text-xl font-bold text-white tracking-tight">{{ $project->title }}</h1>
        <div class="flex items-center gap-3 mt-2">
            @php
                $sc = ['completed' => ['rgba(16,185,129,0.12)','#34d399','#10b981'],
                       'ongoing'   => ['rgba(59,130,246,0.12)', '#60a5fa','#3b82f6'],
                       'pending'   => ['rgba(234,179,8,0.12)',  '#fbbf24','#f59e0b']][$project->status->value]
                    ?? ['rgba(234,179,8,0.12)','#fbbf24','#f59e0b'];
            @endphp
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-medium"
                  style="background: {{ $sc[0] }}; color: {{ $sc[1] }};">
                <span class="w-1.5 h-1.5 rounded-full" style="background: {{ $sc[2] }};"></span>
                {{ $project->status->label() }}
            </span>
            @if($project->client)
            <span class="flex items-center gap-1.5 text-xs text-gray-400">
                <div class="w-4 h-4 rounded-full flex items-center justify-center text-[8px] font-bold text-white"
                     style="background: linear-gradient(135deg,#2563eb,#7c3aed);">
                    {{ strtoupper(substr($project->client->name, 0, 1)) }}
                </div>
                {{ $project->client->name }}
            </span>
            @endif
            @if($project->deadline)
            <span class="text-xs {{ $project->isOverdue() ? 'text-red-400' : 'text-gray-500' }}">
                Due {{ $project->deadline->format('M j, Y') }}
                @if($project->isOverdue()) · Overdue @endif
            </span>
            @endif
        </div>
    </div>
    <a href="{{ route('admin.projects.edit', $project) }}"
       class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium text-white transition shrink-0"
       style="background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.1);">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
        </svg>
        Edit
    </a>
</div>

<div class="grid lg:grid-cols-[1fr_340px] gap-6">

    {{-- Left column --}}
    <div class="space-y-6">

        {{-- Progress card --}}
        <div class="rounded-2xl border p-6" style="background: #0d0d18; border-color: rgba(255,255,255,0.07);">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-semibold text-white">Progress</h2>
                <span class="text-2xl font-bold text-white">{{ $project->progress }}%</span>
            </div>
            <div class="w-full rounded-full h-2.5 mb-6" style="background: rgba(255,255,255,0.08);">
                <div class="h-2.5 rounded-full transition-all"
                     style="width: {{ $project->progress }}%; background: linear-gradient(90deg, #3b82f6, #8b5cf6);"></div>
            </div>

            {{-- Update progress form --}}
            <form method="POST" action="{{ route('admin.projects.updateProgress', $project) }}"
                  class="pt-4 border-t" style="border-color: rgba(255,255,255,0.07);">
                @csrf
                <p class="text-xs font-semibold uppercase tracking-wider mb-3" style="color: rgba(255,255,255,0.35);">Log Progress Update</p>
                <div class="grid grid-cols-[100px_1fr] gap-3 mb-3">
                    <div>
                        <label class="block text-[11px] text-gray-500 mb-1.5">New % *</label>
                        <input type="number" name="progress" min="0" max="100"
                               value="{{ $project->progress }}" required
                               class="w-full rounded-xl px-3 py-2 text-sm text-white outline-none"
                               style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12);">
                    </div>
                    <div>
                        <label class="block text-[11px] text-gray-500 mb-1.5">Update message *</label>
                        <input type="text" name="message" required
                               placeholder="e.g. Completed backend API integration"
                               class="w-full rounded-xl px-3 py-2 text-sm text-white placeholder-gray-600 outline-none"
                               style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12);">
                    </div>
                </div>
                <button type="submit"
                        class="w-full py-2 rounded-xl text-xs font-semibold text-white transition hover:opacity-90"
                        style="background: linear-gradient(135deg,#2563eb,#7c3aed);">
                    Post Update
                </button>
            </form>
        </div>

        {{-- Timeline --}}
        <div class="rounded-2xl border overflow-hidden" style="background: #0d0d18; border-color: rgba(255,255,255,0.07);">
            <div class="px-6 py-4 border-b" style="border-color: rgba(255,255,255,0.07);">
                <h2 class="text-sm font-semibold text-white">Timeline</h2>
                <p class="text-xs text-gray-500 mt-0.5">Project progress history</p>
            </div>
            <div class="p-6 space-y-4">
                @forelse($project->updates->sortByDesc('created_at') as $update)
                <div class="flex gap-3">
                    <div class="relative flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full shrink-0 flex items-center justify-center text-[10px] font-bold text-white"
                             style="background: linear-gradient(135deg,#2563eb,#7c3aed);">
                            {{ $update->progress }}%
                        </div>
                        @if(!$loop->last)
                        <div class="w-px flex-1 mt-2" style="background: rgba(255,255,255,0.06); min-height: 20px;"></div>
                        @endif
                    </div>
                    <div class="pb-4 flex-1">
                        <p class="text-sm text-white leading-relaxed">{{ $update->message }}</p>
                        <p class="text-[11px] text-gray-600 mt-1">{{ $update->created_at->format('M j, Y · g:ia') }}</p>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-600 text-center py-8">No updates yet. Post the first one above.</p>
                @endforelse
            </div>
        </div>

        {{-- Messages thread --}}
        <div class="rounded-2xl border overflow-hidden" style="background: #0d0d18; border-color: rgba(255,255,255,0.07);">
            <div class="px-6 py-4 border-b" style="border-color: rgba(255,255,255,0.07);">
                <h2 class="text-sm font-semibold text-white">Messages</h2>
                <p class="text-xs text-gray-500 mt-0.5">Direct thread with the client</p>
            </div>

            <div class="p-6 space-y-4 max-h-[400px] overflow-y-auto">
                @forelse($project->messages->sortBy('created_at') as $msg)
                @php $isAdmin = $msg->sender?->role?->value === 'admin'; @endphp
                <div class="flex {{ $isAdmin ? 'justify-end' : 'justify-start' }} gap-2">
                    @if(!$isAdmin)
                    <div class="w-6 h-6 rounded-full flex items-center justify-center text-[9px] font-bold text-white shrink-0 mt-1"
                         style="background: linear-gradient(135deg,#059669,#0d9488);">
                        {{ strtoupper(substr($msg->sender?->name ?? '?', 0, 1)) }}
                    </div>
                    @endif
                    <div class="max-w-[75%]">
                        <div class="px-4 py-2.5 rounded-2xl text-sm leading-relaxed
                                    {{ $isAdmin ? 'rounded-tr-sm text-white' : 'rounded-tl-sm text-gray-200' }}"
                             style="{{ $isAdmin ? 'background: linear-gradient(135deg,rgba(37,99,235,0.6),rgba(124,58,237,0.6));' : 'background: rgba(255,255,255,0.06);' }}">
                            {{ $msg->body }}
                        </div>
                        <p class="text-[10px] text-gray-600 mt-1 {{ $isAdmin ? 'text-right' : '' }}">{{ $msg->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-600 text-center py-6">No messages yet.</p>
                @endforelse
            </div>

            <div class="p-4 border-t" style="border-color: rgba(255,255,255,0.07);">
                <form method="POST" action="{{ route('admin.projects.messages.store', $project) }}" class="flex gap-2">
                    @csrf
                    <input type="text" name="body" required placeholder="Type a message..."
                           class="flex-1 rounded-xl px-4 py-2.5 text-sm text-white placeholder-gray-600 outline-none"
                           style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);">
                    <button type="submit"
                            class="px-4 py-2.5 rounded-xl text-sm font-semibold text-white transition hover:opacity-90"
                            style="background: linear-gradient(135deg,#2563eb,#7c3aed);">
                        Send
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Right sidebar --}}
    <div class="space-y-5">

        {{-- Details card --}}
        <div class="rounded-2xl border p-5" style="background: #0d0d18; border-color: rgba(255,255,255,0.07);">
            <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-4">Project Details</h3>
            <dl class="space-y-3.5">
                @if($project->description)
                <div>
                    <dt class="text-[11px] text-gray-600 uppercase tracking-wider mb-1">Description</dt>
                    <dd class="text-sm text-gray-300 leading-relaxed">{{ $project->description }}</dd>
                </div>
                @endif
                @if($project->start_date)
                <div class="flex justify-between items-center">
                    <dt class="text-[11px] text-gray-600">Start Date</dt>
                    <dd class="text-sm text-gray-300">{{ $project->start_date->format('M j, Y') }}</dd>
                </div>
                @endif
                @if($project->deadline)
                <div class="flex justify-between items-center">
                    <dt class="text-[11px] text-gray-600">Deadline</dt>
                    <dd class="text-sm {{ $project->isOverdue() ? 'text-red-400' : 'text-gray-300' }}">{{ $project->deadline->format('M j, Y') }}</dd>
                </div>
                @endif
                <div class="flex justify-between items-center">
                    <dt class="text-[11px] text-gray-600">Created</dt>
                    <dd class="text-sm text-gray-300">{{ $project->created_at->format('M j, Y') }}</dd>
                </div>
            </dl>
        </div>

        {{-- Client card --}}
        @if($project->client)
        <div class="rounded-2xl border p-5" style="background: #0d0d18; border-color: rgba(255,255,255,0.07);">
            <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-4">Client</h3>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-white text-sm"
                     style="background: linear-gradient(135deg,#2563eb,#7c3aed);">
                    {{ strtoupper(substr($project->client->name, 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-semibold text-white">{{ $project->client->name }}</p>
                    <p class="text-xs text-gray-500">{{ $project->client->email }}</p>
                </div>
            </div>
        </div>
        @endif

        {{-- Payment card --}}
        @if($project->payment)
        @php
            $pm = ['paid'=>['rgba(16,185,129,0.12)','#34d399'],
                   'partial'=>['rgba(234,179,8,0.12)','#fbbf24'],
                   'unpaid'=>['rgba(239,68,68,0.12)','#f87171']][$project->payment->status->value]
                ?? ['rgba(239,68,68,0.12)','#f87171'];
        @endphp
        <div class="rounded-2xl border p-5" style="background: #0d0d18; border-color: rgba(255,255,255,0.07);">
            <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-4">Payment</h3>
            <dl class="space-y-3">
                <div class="flex justify-between items-center">
                    <dt class="text-[11px] text-gray-600">Amount</dt>
                    <dd class="text-sm font-semibold text-white">{{ number_format($project->payment->amount) }} {{ $project->payment->currency ?? 'XAF' }}</dd>
                </div>
                <div class="flex justify-between items-center">
                    <dt class="text-[11px] text-gray-600">Paid</dt>
                    <dd class="text-sm text-gray-300">{{ number_format($project->payment->paid_amount ?? 0) }} {{ $project->payment->currency ?? 'XAF' }}</dd>
                </div>
                <div class="flex justify-between items-center">
                    <dt class="text-[11px] text-gray-600">Status</dt>
                    <dd>
                        <span class="text-[11px] font-medium px-2.5 py-1 rounded-full"
                              style="background: {{ $pm[0] }}; color: {{ $pm[1] }};">
                            {{ $project->payment->status->label() }}
                        </span>
                    </dd>
                </div>
            </dl>
            <a href="{{ route('admin.payments.edit', $project->payment) }}"
               class="mt-4 flex items-center justify-center gap-1.5 w-full py-2 rounded-xl text-xs font-medium text-gray-300 hover:text-white transition"
               style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08);">
                Manage Payment
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
        @endif
    </div>
</div>

</x-layouts.admin>
