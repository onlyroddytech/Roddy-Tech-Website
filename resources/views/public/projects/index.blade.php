<x-layouts.public title="Our Projects">
    <section class="py-20 px-4 max-w-6xl mx-auto">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-3">Our Work</h1>
            <p class="text-gray-500">Projects we have built and delivered</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($projects as $project)
            <a href="{{ route('projects.show', $project->id) }}" class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition block">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs px-2 py-1 rounded-full
                        {{ $project->status->value === 'completed' ? 'bg-green-100 text-green-700' :
                           ($project->status->value === 'ongoing' ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700') }}">
                        {{ $project->status->label() }}
                    </span>
                    <span class="text-sm font-semibold text-gray-700">{{ $project->progress }}%</span>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">{{ $project->title }}</h3>
                <p class="text-sm text-gray-500 mb-4">{{ Str::limit($project->description, 100) }}</p>
                <div class="bg-gray-100 rounded-full h-1.5">
                    <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ $project->progress }}%"></div>
                </div>
            </a>
            @empty
            <p class="col-span-3 text-center text-gray-400 py-12">No projects to display yet.</p>
            @endforelse
        </div>
        <div class="mt-8">{{ $projects->links() }}</div>
    </section>
</x-layouts.public>
