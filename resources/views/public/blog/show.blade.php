<x-layouts.public title="{{ $post->title }}">
    <article class="py-20 px-4 max-w-3xl mx-auto">
        <a href="{{ route('blog.index') }}" class="text-sm text-blue-600 hover:underline mb-6 block">← Blog</a>
        <h1 class="text-4xl font-bold text-gray-900 mb-3">{{ $post->title }}</h1>
        <p class="text-sm text-gray-400 mb-8">{{ $post->published_at?->format('F d, Y') }} · by {{ $post->author->name }}</p>
        <div class="prose prose-gray max-w-none text-gray-700 leading-relaxed">
            {!! nl2br(e($post->body)) !!}
        </div>
    </article>
</x-layouts.public>
