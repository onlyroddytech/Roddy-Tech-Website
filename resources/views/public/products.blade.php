<x-layouts.public title="Products">
    <section class="py-20 px-4 max-w-6xl mx-auto">
        <h1 class="text-4xl font-bold text-gray-900 mb-10">Our Products</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($products as $product)
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-900 mb-2">{{ $product->title }}</h3>
                <p class="text-sm text-gray-500 mb-4">{{ $product->description }}</p>
                @if($product->url)
                    <a href="{{ $product->url }}" class="text-blue-600 text-sm hover:underline" target="_blank">Learn more →</a>
                @endif
            </div>
            @empty
            <p class="col-span-3 text-center text-gray-400 py-12">Products coming soon.</p>
            @endforelse
        </div>
    </section>
</x-layouts.public>
