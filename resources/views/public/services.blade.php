<x-layouts.public title="Services">

{{-- ═══ HERO ═══ --}}
<section class="relative pt-32 pb-20 px-6 overflow-hidden bg-[#04040a]">
    <div class="orb w-[500px] h-[500px] top-[-80px] right-[-80px]"
         style="background: radial-gradient(circle, rgba(124,58,237,0.22) 0%, transparent 70%);"></div>
    <div class="orb w-[400px] h-[400px] bottom-0 left-[-60px]"
         style="background: radial-gradient(circle, rgba(37,99,235,0.16) 0%, transparent 70%);"></div>
    <div class="absolute inset-0 opacity-[0.025]"
         style="background-image: linear-gradient(rgba(255,255,255,.5) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.5) 1px, transparent 1px); background-size: 40px 40px;"></div>

    <div class="relative max-w-4xl mx-auto text-center">
        <div class="inline-flex items-center gap-2 mb-6 px-4 py-1.5 rounded-full text-xs font-medium text-purple-300 border"
             style="background: rgba(124,58,237,0.1); border-color: rgba(124,58,237,0.3);">
            <span class="w-1.5 h-1.5 rounded-full bg-purple-400 animate-pulse"></span>
            What We Do
        </div>
        <h1 class="text-5xl sm:text-6xl font-bold tracking-tight text-white leading-[1.08] mb-6">
            Services built<br>
            <span style="background: linear-gradient(135deg, #a78bfa, #60a5fa); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                for results
            </span>
        </h1>
        <p class="text-lg text-gray-400 max-w-2xl mx-auto leading-relaxed">
            End-to-end digital services tailored to your business needs, designed to scale from day one.
        </p>
    </div>
</section>

{{-- ═══ SERVICES GRID ═══ --}}
<section class="py-24 px-6 bg-white">
    <div class="max-w-6xl mx-auto">
        @if($services->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($services as $i => $service)
            <div class="group relative p-7 rounded-2xl border border-gray-100 bg-white hover:border-blue-200 hover:shadow-xl hover:shadow-blue-50 transition-all duration-300">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-6 transition-transform duration-300 group-hover:scale-110"
                     style="background: linear-gradient(135deg, {{ ['#eff6ff,#dbeafe','#f5f3ff,#ede9fe','#f0fdf4,#dcfce7','#fff7ed,#fed7aa','#fdf2f8,#fce7f3','#f0f9ff,#e0f2fe'][$i % 6] }});">
                    @if($service->icon)
                        <span class="text-xl">{{ $service->icon }}</span>
                    @else
                        <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    @endif
                </div>
                <h3 class="font-bold text-gray-900 mb-3 text-[15px] group-hover:text-blue-700 transition-colors">{{ $service->title }}</h3>
                <p class="text-sm text-gray-500 leading-relaxed">{{ $service->description }}</p>
                <div class="absolute bottom-0 left-7 right-7 h-px bg-gradient-to-r from-transparent via-blue-400/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-20">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-5"
                 style="background: linear-gradient(135deg,#eff6ff,#dbeafe);">
                <svg class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <p class="text-gray-500 font-medium">Services coming soon.</p>
        </div>
        @endif
    </div>
</section>

{{-- ═══ PROCESS ═══ --}}
<section class="py-24 px-6 bg-[#fafafa]">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-14">
            <p class="text-xs font-semibold text-blue-600 uppercase tracking-widest mb-3">How It Works</p>
            <h2 class="text-4xl font-bold text-gray-900 tracking-tight">Our process</h2>
            <p class="mt-3 text-gray-500 max-w-xl mx-auto">From idea to launch — a transparent, collaborative workflow.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                ['01','Discovery','We learn your business, goals, and vision before writing a single line of code.'],
                ['02','Design','We create detailed wireframes and UI designs for your approval.'],
                ['03','Build','Our engineers execute with speed and precision. You see updates weekly.'],
                ['04','Launch','We deploy, test, and hand over — with ongoing support available.'],
            ] as [$num,$title,$desc])
            <div class="relative p-6 rounded-2xl border border-gray-100 bg-white">
                <p class="text-5xl font-bold mb-4 tracking-tight"
                   style="background: linear-gradient(135deg, #e2e8f0, #cbd5e1); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">{{ $num }}</p>
                <h3 class="font-bold text-gray-900 mb-2">{{ $title }}</h3>
                <p class="text-sm text-gray-500 leading-relaxed">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ CTA ═══ --}}
<section class="py-24 px-6 bg-[#04040a] relative overflow-hidden">
    <div class="orb w-[500px] h-[500px] top-[-100px] right-[-100px]"
         style="background: radial-gradient(circle, rgba(124,58,237,0.18) 0%, transparent 70%);"></div>
    <div class="relative max-w-2xl mx-auto text-center">
        <h2 class="text-4xl font-bold text-white tracking-tight mb-4">Ready to start?</h2>
        <p class="text-gray-400 mb-9">Tell us what you're building. We'll scope it and get back to you within 24 hours.</p>
        <a href="{{ route('contact') }}"
           class="inline-block px-8 py-4 rounded-2xl text-sm font-semibold text-white transition-all hover:scale-[1.02] active:scale-[0.98]"
           style="background: linear-gradient(135deg, #2563eb, #7c3aed); box-shadow: 0 12px 40px rgba(37,99,235,0.4);">
            Get a Free Quote
        </a>
    </div>
</section>

</x-layouts.public>
