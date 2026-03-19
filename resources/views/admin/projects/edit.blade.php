<x-layouts.admin title="Edit Project">

{{-- Breadcrumb --}}
<div class="flex items-center gap-2 text-xs text-gray-500 mb-6">
    <a href="{{ route('admin.projects.index') }}" class="hover:text-gray-300 transition">Projects</a>
    <span>/</span>
    <a href="{{ route('admin.projects.show', $project) }}" class="hover:text-gray-300 transition">{{ Str::limit($project->title, 30) }}</a>
    <span>/</span>
    <span class="text-gray-300">Edit</span>
</div>

<div class="max-w-2xl">
    <div class="mb-6">
        <h1 class="text-lg font-semibold text-white">Edit Project</h1>
        <p class="text-xs mt-0.5" style="color: rgba(255,255,255,0.35);">Update the project details below.</p>
    </div>

    <div class="rounded-2xl border p-6" style="background: #0d0d18; border-color: rgba(255,255,255,0.07);">
        <form method="POST" action="{{ route('admin.projects.update', $project) }}" class="space-y-5">
            @csrf @method('PATCH')

            {{-- Title --}}
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider mb-2" style="color: rgba(255,255,255,0.4);">Project Title *</label>
                <input type="text" name="title" value="{{ old('title', $project->title) }}" required
                       class="w-full rounded-xl px-4 py-2.5 text-sm text-white placeholder-gray-600 outline-none transition"
                       style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12);"
                       onfocus="this.style.borderColor='rgba(99,102,241,0.6)'" onblur="this.style.borderColor='rgba(255,255,255,0.12)'">
                @error('title')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider mb-2" style="color: rgba(255,255,255,0.4);">Description</label>
                <textarea name="description" rows="4"
                          class="w-full rounded-xl px-4 py-2.5 text-sm text-white placeholder-gray-600 outline-none transition resize-none"
                          style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12);"
                          onfocus="this.style.borderColor='rgba(99,102,241,0.6)'" onblur="this.style.borderColor='rgba(255,255,255,0.12)'">{{ old('description', $project->description) }}</textarea>
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
                            <option value="{{ $val }}"
                                    {{ old('status', $project->status->value) === $val ? 'selected' : '' }}
                                    style="background:#1a1a2e;">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('status')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider mb-2" style="color: rgba(255,255,255,0.4);">Progress (0–100) *</label>
                    <input type="number" name="progress" value="{{ old('progress', $project->progress) }}" min="0" max="100" required
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
                    <input type="date" name="start_date" value="{{ old('start_date', $project->start_date?->format('Y-m-d')) }}"
                           class="w-full rounded-xl px-4 py-2.5 text-sm text-white outline-none transition"
                           style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12); color-scheme: dark;"
                           onfocus="this.style.borderColor='rgba(99,102,241,0.6)'" onblur="this.style.borderColor='rgba(255,255,255,0.12)'">
                    @error('start_date')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider mb-2" style="color: rgba(255,255,255,0.4);">Deadline</label>
                    <input type="date" name="deadline" value="{{ old('deadline', $project->deadline?->format('Y-m-d')) }}"
                           class="w-full rounded-xl px-4 py-2.5 text-sm text-white outline-none transition"
                           style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12); color-scheme: dark;"
                           onfocus="this.style.borderColor='rgba(99,102,241,0.6)'" onblur="this.style.borderColor='rgba(255,255,255,0.12)'">
                    @error('deadline')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Note: client (user_id) is not editable on update per controller --}}

            {{-- Actions --}}
            <div class="flex items-center justify-between pt-2 border-t" style="border-color: rgba(255,255,255,0.07);">
                <form method="POST" action="{{ route('admin.projects.destroy', $project) }}"
                      onsubmit="return confirm('Permanently delete this project?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="flex items-center gap-1.5 text-xs font-medium text-red-400 hover:text-red-300 transition px-3 py-2 rounded-lg hover:bg-red-400/10">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete Project
                    </button>
                </form>

                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.projects.show', $project) }}"
                       class="px-5 py-2.5 rounded-xl text-sm font-medium text-gray-400 hover:text-white transition"
                       style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.09);">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-6 py-2.5 rounded-xl text-sm font-semibold text-white transition-all hover:opacity-90"
                            style="background: linear-gradient(135deg, #2563eb, #7c3aed); box-shadow: 0 4px 16px rgba(37,99,235,0.35);">
                        Save Changes
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

</x-layouts.admin>
