<x-layouts.admin title="Contact Messages">

{{-- Header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-lg font-bold text-white">Contact Messages</h1>
        <p class="text-xs text-gray-500 mt-0.5">All messages submitted via the public contact form</p>
    </div>
    <div class="flex items-center gap-2">
        <span class="text-xs font-semibold px-2.5 py-1 rounded-full"
              style="background: rgba(37,99,235,0.15); color: #60a5fa;">
            {{ $messages->total() }} total
        </span>
        @php $unread = $messages->getCollection()->where('read', false)->count(); @endphp
        @if($unread)
        <span class="text-xs font-semibold px-2.5 py-1 rounded-full"
              style="background: rgba(16,185,129,0.15); color: #34d399;">
            {{ $unread }} unread
        </span>
        @endif
    </div>
</div>

{{-- Flash messages --}}
@if(session('success'))
<div class="flex items-center gap-2.5 px-4 py-3 mb-5 rounded-xl text-sm font-medium"
     style="background: rgba(16,185,129,0.12); border: 1px solid rgba(16,185,129,0.25); color: #34d399;">
    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
    </svg>
    {{ session('success') }}
</div>
@endif

{{-- Messages table --}}
<div class="rounded-2xl overflow-hidden" style="background: #0d0d18; border: 1px solid rgba(255,255,255,0.07);">

    {{-- Table header --}}
    <div class="px-6 py-4 border-b" style="border-color: rgba(255,255,255,0.07); background: rgba(255,255,255,0.02);">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-2 text-[11px] font-semibold uppercase tracking-wider text-gray-500">Sender</div>
            <div class="col-span-2 text-[11px] font-semibold uppercase tracking-wider text-gray-500">Subject</div>
            <div class="col-span-2 text-[11px] font-semibold uppercase tracking-wider text-gray-500">Service</div>
            <div class="col-span-3 text-[11px] font-semibold uppercase tracking-wider text-gray-500">Message</div>
            <div class="col-span-1 text-[11px] font-semibold uppercase tracking-wider text-gray-500">Status</div>
            <div class="col-span-2 text-[11px] font-semibold uppercase tracking-wider text-gray-500 text-right">Actions</div>
        </div>
    </div>

    {{-- Rows --}}
    @forelse($messages as $msg)
    <div class="px-6 py-4 border-b transition-colors hover:bg-white/[0.02]"
         style="border-color: rgba(255,255,255,0.05); {{ !$msg->read ? 'background: rgba(37,99,235,0.04);' : '' }}">
        <div class="grid grid-cols-12 gap-4 items-start">

            {{-- Sender --}}
            <div class="col-span-2">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-lg flex items-center justify-center shrink-0 text-[11px] font-bold text-white"
                         style="background: linear-gradient(135deg, #1e3a5f, #1e40af);">
                        {{ strtoupper(substr($msg->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-[13px] font-semibold text-white truncate {{ !$msg->read ? 'text-white' : 'text-gray-300' }}">
                            {{ $msg->name }}
                        </p>
                        <a href="mailto:{{ $msg->email }}"
                           class="text-[11px] text-gray-500 hover:text-blue-400 transition-colors truncate block">
                            {{ $msg->email }}
                        </a>
                    </div>
                </div>
            </div>

            {{-- Subject --}}
            <div class="col-span-2">
                <p class="text-[13px] text-gray-300 truncate">
                    {{ $msg->subject ?: '—' }}
                </p>
            </div>

            {{-- Service --}}
            <div class="col-span-2">
                @if($msg->service)
                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-medium"
                      style="background: rgba(124,58,237,0.15); color: #a78bfa;">
                    {{ $msg->service }}
                </span>
                @else
                <span class="text-[13px] text-gray-600">—</span>
                @endif
            </div>

            {{-- Message preview --}}
            <div class="col-span-3">
                <p class="text-[13px] text-gray-400 leading-relaxed line-clamp-2">
                    {{ Str::limit($msg->message, 100) }}
                </p>
                <p class="text-[11px] text-gray-600 mt-1">
                    {{ $msg->created_at->diffForHumans() }} · {{ $msg->created_at->format('M d, Y') }}
                </p>
            </div>

            {{-- Read status --}}
            <div class="col-span-1 flex items-center">
                @if($msg->read)
                    <span class="inline-flex items-center gap-1 text-[11px] font-medium text-gray-500">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Read
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold"
                          style="color: #34d399;">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        New
                    </span>
                @endif
            </div>

            {{-- Actions --}}
            <div class="col-span-2 flex items-center justify-end gap-2">

                {{-- Expand / view full message --}}
                <button type="button"
                        onclick="toggleMessage({{ $msg->id }})"
                        class="flex items-center gap-1 text-[11px] font-medium text-gray-400 hover:text-white transition-colors px-2.5 py-1.5 rounded-lg hover:bg-white/[0.06]">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    View
                </button>

                {{-- Mark read --}}
                @if(!$msg->read)
                <form method="POST" action="{{ route('admin.contact-messages.read', $msg) }}">
                    @csrf @method('PATCH')
                    <button type="submit"
                            class="flex items-center gap-1 text-[11px] font-medium text-blue-400 hover:text-blue-300 transition-colors px-2.5 py-1.5 rounded-lg hover:bg-blue-400/10">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Read
                    </button>
                </form>
                @endif

                {{-- Delete --}}
                <form method="POST" action="{{ route('admin.contact-messages.destroy', $msg) }}"
                      onsubmit="return confirm('Delete this message from {{ addslashes($msg->name) }}?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="flex items-center gap-1 text-[11px] font-medium text-red-400 hover:text-red-300 transition-colors px-2.5 py-1.5 rounded-lg hover:bg-red-400/10">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete
                    </button>
                </form>
            </div>

        </div>

        {{-- Full message expand panel --}}
        <div id="msg-{{ $msg->id }}" class="hidden mt-4 pt-4 border-t" style="border-color: rgba(255,255,255,0.06);">
            <div class="rounded-xl p-4" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07);">
                <p class="text-[11px] font-semibold uppercase tracking-wider text-gray-500 mb-2">Full Message</p>
                <p class="text-sm text-gray-300 leading-relaxed whitespace-pre-wrap">{{ $msg->message }}</p>
                <div class="flex items-center gap-4 mt-4 pt-3 border-t" style="border-color: rgba(255,255,255,0.06);">
                    <a href="mailto:{{ $msg->email }}?subject=Re: {{ urlencode($msg->subject ?? 'Your enquiry') }}"
                       class="inline-flex items-center gap-1.5 text-[12px] font-semibold text-blue-400 hover:text-blue-300 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Reply via Email
                    </a>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $msg->email) }}" target="_blank"
                       class="inline-flex items-center gap-1.5 text-[12px] font-semibold text-emerald-400 hover:text-emerald-300 transition-colors">
                        Sent: {{ $msg->created_at->format('F j, Y \a\t g:i A') }}
                    </a>
                </div>
            </div>
        </div>

    </div>
    @empty
    <div class="flex flex-col items-center justify-center py-20 text-center">
        <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-4"
             style="background: rgba(255,255,255,0.05);">
            <svg class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>
        <p class="text-sm font-medium text-gray-500">No messages yet</p>
        <p class="text-xs text-gray-600 mt-1">Messages from the contact form will appear here</p>
    </div>
    @endforelse

</div>

{{-- Pagination --}}
@if($messages->hasPages())
<div class="mt-5">
    {{ $messages->links() }}
</div>
@endif

<script>
function toggleMessage(id) {
    var el = document.getElementById('msg-' + id);
    el.classList.toggle('hidden');
}
</script>

</x-layouts.admin>
