<x-layouts.public title="Blog">
    <section class="py-20 px-4 max-w-6xl mx-auto">
        <h1 class="text-4xl font-bold text-gray-900 mb-10">Blog</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($posts as $post)
            <a href="{{ route('blog.show', $post->slug) }}" class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="p-6">
                    <h2 class="font-bold text-gray-900 mb-2">{{ $post->title }}</h2>
                    <p class="text-sm text-gray-500 mb-3">{{ Str::limit($post->excerpt, 100) }}</p>
                    <p class="text-xs text-gray-400">{{ $post->published_at?->format('M d, Y') }} · {{ $post->author->name }}</p>
                </div>
            </a>
            @empty
            <p class="col-span-3 text-center text-gray-400 py-12">No posts yet.</p>
            @endforelse
        </div>
        <div class="mt-8">{{ $posts->links() }}</div>
    </section>
</x-layouts.public>
