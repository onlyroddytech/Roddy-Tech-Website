<x-layouts.client title="{{ $project->title }}">

{{-- Breadcrumb --}}
<div class="flex items-center gap-2 text-xs text-gray-400 mb-6">
    <a href="{{ route('client.projects.index') }}" class="hover:text-gray-600 transition">My Projects</a>
    <span>/</span>
    <span class="text-gray-600">{{ Str::limit($project->title, 40) }}</span>
</div>

{{-- Header --}}
<div class="mb-7">
    <h1 class="text-lg font-semibold text-gray-900">{{ $project->title }}</h1>
    @php
        $map = ['completed'=>['bg-green-50','text-green-700','bg-green-400'],
                'ongoing'  =>['bg-blue-50', 'text-blue-700', 'bg-blue-400'],
                'pending'  =>['bg-amber-50','text-amber-700','bg-amber-400']];
        $s = $map[$project->status->value] ?? $map['pending'];
    @endphp
    <div class="flex items-center gap-3 mt-2">
        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-medium {{ $s[0] }} {{ $s[1] }}">
            <span class="w-1.5 h-1.5 rounded-full {{ $s[2] }}"></span>
            {{ $project->status->label() }}
        </span>
        @if($project->deadline)
        <span class="text-xs {{ $project->isOverdue() ? 'text-red-400 font-medium' : 'text-gray-400' }}">
            Due {{ $project->deadline->format('M j, Y') }}
            @if($project->isOverdue()) · Overdue @endif
        </span>
        @endif
    </div>
</div>

<div class="grid lg:grid-cols-[1fr_300px] gap-6">

    {{-- Left --}}
    <div class="space-y-6">

        {{-- Progress --}}
        <div class="bg-white rounded-2xl border border-gray-200/60 shadow-sm p-6">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-sm font-semibold text-gray-900">Overall Progress</h2>
                <span class="text-2xl font-bold text-gray-900">{{ $project->progress }}%</span>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
                <div class="h-2.5 rounded-full transition-all duration-700"
                     style="width: {{ $project->progress }}%; background: linear-gradient(90deg,#3b82f6,#7c3aed);"></div>
            </div>
            @if($project->description)
            <p class="mt-4 text-sm text-gray-500 leading-relaxed">{{ $project->description }}</p>
            @endif
        </div>

        {{-- Timeline --}}
        <div class="bg-white rounded-2xl border border-gray-200/60 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-sm font-semibold text-gray-900">Progress Timeline</h2>
                <p class="text-xs text-gray-400 mt-0.5">Updates from the team</p>
            </div>
            <div class="p-6 space-y-5">
                @forelse($project->updates->sortByDesc('created_at') as $update)
                <div class="flex gap-3">
                    <div class="relative flex flex-col items-center">
                        <div class="w-9 h-9 rounded-full shrink-0 flex items-center justify-center text-[10px] font-bold text-white"
                             style="background: linear-gradient(135deg,#3b82f6,#7c3aed);">
                            {{ $update->progress }}%
                        </div>
                        @if(!$loop->last)
                            <div class="w-px flex-1 bg-gray-100 mt-2" style="min-height:20px;"></div>
                        @endif
                    </div>
                    <div class="pb-4 flex-1">
                        <p class="text-sm text-gray-700 leading-relaxed">{{ $update->message }}</p>
                        <p class="text-[11px] text-gray-400 mt-1">{{ $update->created_at->format('M j, Y · g:ia') }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <p class="text-sm text-gray-400">No updates yet. Check back soon.</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Messages --}}
        <div class="bg-white rounded-2xl border border-gray-200/60 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-sm font-semibold text-gray-900">Messages</h2>
                <p class="text-xs text-gray-400 mt-0.5">Chat with the Roddy Technologies team</p>
            </div>

            <div class="p-6 space-y-4 max-h-[360px] overflow-y-auto">
                @forelse($project->messages->sortBy('created_at') as $msg)
                @php $isMe = $msg->sender_id === auth()->id(); @endphp
                <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }} gap-2">
                    @if(!$isMe)
                    <div class="w-6 h-6 rounded-full flex items-center justify-center text-[9px] font-bold text-white shrink-0 mt-1"
                         style="background: linear-gradient(135deg,#2563eb,#7c3aed);">
                        {{ strtoupper(substr($msg->sender?->name ?? 'R', 0, 1)) }}
                    </div>
                    @endif
                    <div class="max-w-[78%]">
                        <div class="px-4 py-2.5 rounded-2xl text-sm leading-relaxed
                                    {{ $isMe ? 'rounded-tr-sm text-white' : 'rounded-tl-sm text-gray-700 bg-gray-100' }}"
                             @if($isMe) style="background: linear-gradient(135deg,#2563eb,#7c3aed);" @endif>
                            {{ $msg->body }}
                        </div>
                        <p class="text-[10px] text-gray-400 mt-1 {{ $isMe ? 'text-right' : '' }}">{{ $msg->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-400 text-center py-6">No messages yet. Send the first one.</p>
                @endforelse
            </div>

            <div class="p-4 border-t border-gray-100">
                <form method="POST" action="{{ route('client.projects.messages.store', $project) }}" class="flex gap-2">
                    @csrf
                    <input type="text" name="body" required placeholder="Type a message..."
                           class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition">
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

        {{-- Details --}}
        <div class="bg-white rounded-2xl border border-gray-200/60 shadow-sm p-5">
            <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-4">Project Info</h3>
            <dl class="space-y-3">
                @if($project->start_date)
                <div class="flex justify-between items-center">
                    <dt class="text-xs text-gray-400">Started</dt>
                    <dd class="text-xs font-medium text-gray-700">{{ $project->start_date->format('M j, Y') }}</dd>
                </div>
                @endif
                @if($project->deadline)
                <div class="flex justify-between items-center">
                    <dt class="text-xs text-gray-400">Deadline</dt>
                    <dd class="text-xs font-medium {{ $project->isOverdue() ? 'text-red-500' : 'text-gray-700' }}">{{ $project->deadline->format('M j, Y') }}</dd>
                </div>
                @endif
                <div class="flex justify-between items-center">
                    <dt class="text-xs text-gray-400">Created</dt>
                    <dd class="text-xs font-medium text-gray-700">{{ $project->created_at->format('M j, Y') }}</dd>
                </div>
            </dl>
        </div>

        {{-- Payment --}}
        @if($project->payment)
        @php
            $pm = ['paid'=>['bg-green-50','text-green-700'],
                   'partial'=>['bg-yellow-50','text-yellow-700'],
                   'unpaid'=>['bg-red-50','text-red-600']];
            $p = $pm[$project->payment->status->value] ?? $pm['unpaid'];
        @endphp
        <div class="bg-white rounded-2xl border border-gray-200/60 shadow-sm p-5">
            <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-4">Payment</h3>
            <dl class="space-y-3">
                <div class="flex justify-between items-center">
                    <dt class="text-xs text-gray-400">Total</dt>
                    <dd class="text-sm font-bold text-gray-900">{{ number_format($project->payment->amount) }} <span class="font-normal text-gray-400 text-xs">{{ $project->payment->currency ?? 'XAF' }}</span></dd>
                </div>
                <div class="flex justify-between items-center">
                    <dt class="text-xs text-gray-400">Paid</dt>
                    <dd class="text-xs font-medium text-gray-700">{{ number_format($project->payment->paid_amount ?? 0) }} {{ $project->payment->currency ?? 'XAF' }}</dd>
                </div>
                <div class="flex justify-between items-center">
                    <dt class="text-xs text-gray-400">Status</dt>
                    <dd><span class="text-[11px] font-medium px-2.5 py-1 rounded-full {{ $p[0] }} {{ $p[1] }}">{{ $project->payment->status->label() }}</span></dd>
                </div>
            </dl>
            <a href="{{ route('client.payments.index') }}"
               class="mt-4 flex items-center justify-center gap-1 w-full py-2 rounded-xl text-xs font-medium text-blue-600 hover:text-blue-800 transition hover:bg-blue-50">
                View Payments →
            </a>
        </div>
        @endif
    </div>
</div>

</x-layouts.client>
