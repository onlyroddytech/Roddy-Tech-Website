<x-layouts.public title="Pricing">

{{-- ═══ HERO ═══ --}}
<section class="relative pt-32 pb-20 px-6 overflow-hidden bg-[#04040a]">
    <div class="orb w-[500px] h-[500px] top-[-80px] left-[-80px]"
         style="background: radial-gradient(circle, rgba(37,99,235,0.22) 0%, transparent 70%);"></div>
    <div class="orb w-[400px] h-[400px] bottom-0 right-[-60px]"
         style="background: radial-gradient(circle, rgba(124,58,237,0.18) 0%, transparent 70%);"></div>
    <div class="absolute inset-0 opacity-[0.025]"
         style="background-image: linear-gradient(rgba(255,255,255,.5) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.5) 1px, transparent 1px); background-size: 40px 40px;"></div>

    <div class="relative max-w-4xl mx-auto text-center">
        <div class="inline-flex items-center gap-2 mb-6 px-4 py-1.5 rounded-full text-xs font-medium text-blue-300 border"
             style="background: rgba(37,99,235,0.1); border-color: rgba(37,99,235,0.3);">
            <span class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></span>
            Transparent Pricing
        </div>
        <h1 class="text-5xl sm:text-6xl font-bold tracking-tight text-white leading-[1.08] mb-5">
            Simple, project-based<br>
            <span style="background: linear-gradient(135deg, #60a5fa, #a78bfa); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                pricing
            </span>
        </h1>
        <p class="text-lg text-gray-400 max-w-2xl mx-auto leading-relaxed">
            No subscriptions. No surprises. You know exactly what you're paying for before we start.
        </p>
    </div>
</section>

{{-- ═══ PRICING CARDS ═══ --}}
<section class="py-24 px-6 bg-white">
    <div class="max-w-6xl mx-auto">
        @if($items->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-start">
            @foreach($items as $item)
            @php $featured = $item->is_featured; @endphp
            <div class="relative rounded-2xl p-7 border transition-all duration-300
                        {{ $featured ? 'shadow-2xl shadow-blue-100 border-blue-400' : 'border-gray-100 hover:border-blue-200 hover:shadow-xl hover:shadow-blue-50' }}">

                @if($featured)
                    <div class="absolute -top-3.5 left-1/2 -translate-x-1/2">
                        <span class="px-4 py-1.5 rounded-full text-[11px] font-semibold text-white"
                              style="background: linear-gradient(135deg, #2563eb, #7c3aed); box-shadow: 0 4px 14px rgba(37,99,235,0.4);">
                            Most Popular
                        </span>
                    </div>
                    <div class="absolute inset-0 rounded-2xl pointer-events-none"
                         style="background: linear-gradient(135deg, rgba(37,99,235,0.04), rgba(124,58,237,0.04));"></div>
                @endif

                <div class="relative">
                    <h3 class="font-bold text-gray-900 text-lg mb-2">{{ $item->title }}</h3>

                    @if($item->description)
                        <p class="text-sm text-gray-500 leading-relaxed mb-6">{{ $item->description }}</p>
                    @endif

                    <div class="mb-6">
                        <div class="flex items-end gap-1.5">
                            <span class="text-4xl font-bold text-gray-900 tracking-tight">
                                {{ number_format($item->price) }}
                            </span>
                            <span class="text-sm font-medium text-gray-400 mb-1.5">{{ $item->currency ?? 'XAF' }}</span>
                        </div>
                        @if($item->unit)
                            <p class="text-xs text-gray-400 mt-1">{{ $item->unit }}</p>
                        @endif
                    </div>

                    <a href="{{ route('contact') }}"
                       class="block text-center py-3 rounded-xl text-sm font-semibold transition-all hover:opacity-90 hover:scale-[1.01] active:scale-[0.98]
                              {{ $featured ? 'text-white' : 'text-blue-700 border border-blue-200 bg-blue-50 hover:bg-blue-100' }}"
                       @if($featured) style="background: linear-gradient(135deg, #2563eb, #7c3aed); box-shadow: 0 4px 20px rgba(37,99,235,0.3);" @endif>
                        Get Started
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-20">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-5"
                 style="background: linear-gradient(135deg,#eff6ff,#dbeafe);">
                <svg class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
            </div>
            <p class="text-gray-500 font-medium">Pricing coming soon.</p>
            <a href="{{ route('contact') }}" class="mt-4 inline-block text-sm font-medium text-blue-600 hover:underline">Contact us for a quote →</a>
        </div>
        @endif
    </div>
</section>

{{-- ═══ FAQ / NOTE ═══ --}}
<section class="py-20 px-6 bg-[#fafafa]">
    <div class="max-w-3xl mx-auto">
        <div class="text-center mb-12">
            <p class="text-xs font-semibold text-blue-600 uppercase tracking-widest mb-3">Common Questions</p>
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Pricing FAQs</h2>
        </div>

        <div class="space-y-4">
            @foreach([
                ['What\'s included in the price?','All prices cover design, development, testing, and deployment. We don\'t charge extra for revisions within the agreed scope.'],
                ['Do you offer payment plans?','Yes — we typically split payments into 50% upfront and 50% on delivery. Custom plans available for larger projects.'],
                ['What currency do you charge in?','We invoice in XAF (Central African CFA Franc) by default. USD and EUR invoices available on request.'],
                ['How long does a project take?','Depends on scope. A landing page can be done in a week; a full web app typically takes 4–12 weeks.'],
            ] as [$q,$a])
            <div class="p-6 rounded-2xl border border-gray-100 bg-white">
                <h3 class="font-semibold text-gray-900 mb-2 text-[14px]">{{ $q }}</h3>
                <p class="text-sm text-gray-500 leading-relaxed">{{ $a }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ CTA ═══ --}}
<section class="py-20 px-6 bg-white">
    <div class="max-w-2xl mx-auto text-center">
        <h2 class="text-4xl font-bold text-gray-900 tracking-tight mb-4">Need a custom quote?</h2>
        <p class="text-gray-500 mb-9">Every project is unique. Tell us about yours and we'll put together a tailored proposal.</p>
        <a href="{{ route('contact') }}"
           class="inline-block px-8 py-4 rounded-2xl text-sm font-semibold text-white transition-all hover:scale-[1.02]"
           style="background: linear-gradient(135deg, #2563eb, #7c3aed); box-shadow: 0 12px 40px rgba(37,99,235,0.35);">
            Request a Custom Quote
        </a>
    </div>
</section>

</x-layouts.public>
