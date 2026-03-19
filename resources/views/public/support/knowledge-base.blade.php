<x-layouts.public title="Knowledge Base">
    <section class="py-20 px-4 max-w-3xl mx-auto">
        <h1 class="text-4xl font-bold text-gray-900 mb-10">Knowledge Base</h1>
        @forelse($faqs as $faq)
        <div class="mb-4 bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
            <h3 class="font-semibold text-gray-800 mb-2">{{ $faq->question }}</h3>
            <p class="text-sm text-gray-500 leading-relaxed">{{ $faq->answer }}</p>
        </div>
        @empty
        <p class="text-gray-400">Articles coming soon.</p>
        @endforelse
    </section>
</x-layouts.public>
