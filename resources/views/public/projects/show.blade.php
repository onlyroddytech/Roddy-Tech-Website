<x-layouts.public title="{{ $project->title }}">
    <section class="py-20 px-4 max-w-3xl mx-auto">
        <a href="{{ route('projects.index') }}" class="text-sm text-blue-600 hover:underline mb-6 block">← Back to Projects</a>

        <div class="flex items-center gap-3 mb-4">
            <span class="text-xs px-3 py-1 rounded-full
                {{ $project->status->value === 'completed' ? 'bg-green-100 text-green-700' :
                   ($project->status->value === 'ongoing' ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700') }}">
                {{ $project->status->label() }}
            </span>
            <span class="text-sm text-gray-500">{{ $project->progress }}% complete</span>
        </div>

        <h1 class="text-3xl font-bold text-gray-900 mb-3">{{ $project->title }}</h1>
        <p class="text-gray-600 mb-8">{{ $project->description }}</p>

        <div class="bg-gray-100 rounded-full h-2 mb-8">
            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $project->progress }}%"></div>
        </div>

        @if($project->updates->count())
        <div>
            <h2 class="font-bold text-gray-800 mb-4">Project Timeline</h2>
            <div class="space-y-4">
                @foreach($project->updates as $update)
                <div class="flex gap-4">
                    <div class="flex flex-col items-center">
                        <div class="w-3 h-3 bg-blue-600 rounded-full mt-1"></div>
                        <div class="w-0.5 bg-gray-200 flex-1 mt-1"></div>
                    </div>
                    <div class="pb-4">
                        <p class="text-sm text-gray-700">{{ $update->message }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $update->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </section>
</x-layouts.public>
