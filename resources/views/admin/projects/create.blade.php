<x-layouts.admin title="New Project">

{{-- Breadcrumb --}}
<div class="flex items-center gap-2 text-xs text-gray-500 mb-6">
    <a href="{{ route('admin.projects.index') }}" class="hover:text-gray-300 transition">Projects</a>
    <span>/</span>
    <span class="text-gray-300">New Project</span>
</div>

<div class="max-w-2xl">
    <div class="mb-6">
        <h1 class="text-lg font-semibold text-white">Create Project</h1>
        <p class="text-xs mt-0.5" style="color: rgba(255,255,255,0.35);">Fill in the details to create a new client project.</p>
    </div>

    <div class="rounded-2xl border p-6" style="background: #0d0d18; border-color: rgba(255,255,255,0.07);">
        <form method="POST" action="{{ route('admin.projects.store') }}" class="space-y-5">
            @csrf

            {{-- Client --}}
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider mb-2" style="color: rgba(255,255,255,0.4);">Client *</label>
                <select name="user_id" required
                        class="w-full rounded-xl px-4 py-2.5 text-sm text-white outline-none transition"
                        style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12);"
                        onfocus="this.style.borderColor='rgba(99,102,241,0.6)'" onblur="this.style.borderColor='rgba(255,255,255,0.12)'">
                    <option value="" disabled selected style="background:#1a1a2e;">Select a client</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ old('user_id') == $client->id ? 'selected' : '' }}
                                style="background:#1a1a2e;">{{ $client->name }} — {{ $client->email }}</option>
                    @endforeach
                </select>
                @error('user_id')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Title --}}
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider mb-2" style="color: rgba(255,255,255,0.4);">Project Title *</label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       placeholder="e.g. E-commerce Platform Redesign"
                       class="w-full rounded-xl px-4 py-2.5 text-sm text-white placeholder-gray-600 outline-none transition"
                       style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12);"
                       onfocus="this.style.borderColor='rgba(99,102,241,0.6)'" onblur="this.style.borderColor='rgba(255,255,255,0.12)'">
                @error('title')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider mb-2" style="color: rgba(255,255,255,0.4);">Description</label>
                <textarea name="description" rows="4"
                          placeholder="Brief project description..."
                          class="w-full rounded-xl px-4 py-2.5 text-sm text-white placeholder-gray-600 outline-none transition resize-none"
                          style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12);"
                          onfocus="this.style.borderColor='rgba(99,102,241,0.6)'" onblur="this.style.borderColor='rgba(255,255,255,0.12)'">{{ old('description') }}</textarea>
                @error('description')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Status + Progress --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider mb-2" style="color: rgba(255,255,255,0.4);">Status *</label>
                    <select name="status" required
                            class="w-full rounded-xl px-4 py-2.5 text-sm text-white outline-none transition"
                            style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12);"
                            onfocus="this.style.borderColor='rgba(99,102,241,0.6)'" onblur="this.style.borderColor='rgba(255,255,255,0.12)'">
                        @foreach(['pending'=>'Pending','ongoing'=>'Ongoing','completed'=>'Completed'] as $val=>$label)
                            <option value="{{ $val }}" {{ old('status','pending') === $val ? 'selected' : '' }}
                                    style="background:#1a1a2e;">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('status')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider mb-2" style="color: rgba(255,255,255,0.4);">Progress (0–100) *</label>
                    <input type="number" name="progress" value="{{ old('progress', 0) }}" min="0" max="100" required
                           class="w-full rounded-xl px-4 py-2.5 text-sm text-white outline-none transition"
                           style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12);"
                           onfocus="this.style.borderColor='rgba(99,102,241,0.6)'" onblur="this.style.borderColor='rgba(255,255,255,0.12)'">
                    @error('progress')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Dates --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider mb-2" style="color: rgba(255,255,255,0.4);">Start Date</label>
                    <input type="date" name="start_date" value="{{ old('start_date') }}"
                           class="w-full rounded-xl px-4 py-2.5 text-sm text-white outline-none transition"
                           style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12); color-scheme: dark;"
                           onfocus="this.style.borderColor='rgba(99,102,241,0.6)'" onblur="this.style.borderColor='rgba(255,255,255,0.12)'">
                    @error('start_date')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider mb-2" style="color: rgba(255,255,255,0.4);">Deadline</label>
                    <input type="date" name="deadline" value="{{ old('deadline') }}"
                           class="w-full rounded-xl px-4 py-2.5 text-sm text-white outline-none transition"
                           style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12); color-scheme: dark;"
                           onfocus="this.style.borderColor='rgba(99,102,241,0.6)'" onblur="this.style.borderColor='rgba(255,255,255,0.12)'">
                    @error('deadline')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3 pt-2 border-t" style="border-color: rgba(255,255,255,0.07);">
                <a href="{{ route('admin.projects.index') }}"
                   class="px-5 py-2.5 rounded-xl text-sm font-medium text-gray-400 hover:text-white transition"
                   style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.09);">
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2.5 rounded-xl text-sm font-semibold text-white transition-all hover:opacity-90"
                        style="background: linear-gradient(135deg, #2563eb, #7c3aed); box-shadow: 0 4px 16px rgba(37,99,235,0.35);">
                    Create Project
                </button>
            </div>
        </form>
    </div>
</div>

</x-layouts.admin>
