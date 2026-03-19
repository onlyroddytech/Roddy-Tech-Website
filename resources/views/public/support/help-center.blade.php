<x-layouts.public title="Help Center">
    <section class="py-20 px-4 max-w-3xl mx-auto">
        <h1 class="text-4xl font-bold text-gray-900 mb-10">Help Center</h1>
        @forelse($faqs as $faq)
        <details class="mb-3 bg-white rounded-xl border border-gray-100 shadow-sm">
            <summary class="px-5 py-4 font-medium text-gray-800 cursor-pointer">{{ $faq->question }}</summary>
            <div class="px-5 pb-4 text-sm text-gray-500 leading-relaxed">{{ $faq->answer }}</div>
        </details>
        @empty
        <p class="text-gray-400">FAQs coming soon.</p>
        @endforelse
    </section>
</x-layouts.public>
