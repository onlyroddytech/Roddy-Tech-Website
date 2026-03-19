<x-layouts.public title="About Us">

{{-- ═══ HERO ═══ --}}
<section class="relative pt-32 pb-24 px-6 overflow-hidden bg-[#04040a]">
    <div class="orb w-[500px] h-[500px] top-[-100px] left-[-80px]"
         style="background: radial-gradient(circle, rgba(37,99,235,0.22) 0%, transparent 70%);"></div>
    <div class="orb w-[400px] h-[400px] top-[20%] right-[-80px]"
         style="background: radial-gradient(circle, rgba(124,58,237,0.18) 0%, transparent 70%);"></div>
    <div class="absolute inset-0 opacity-[0.025]"
         style="background-image: linear-gradient(rgba(255,255,255,.5) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.5) 1px, transparent 1px); background-size: 40px 40px;"></div>

    <div class="relative max-w-4xl mx-auto text-center">
        <div class="inline-flex items-center gap-2 mb-6 px-4 py-1.5 rounded-full text-xs font-medium text-blue-300 border"
             style="background: rgba(37,99,235,0.1); border-color: rgba(37,99,235,0.3);">
            <span class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></span>
            Our Story
        </div>
        <h1 class="text-5xl sm:text-6xl font-bold tracking-tight text-white leading-[1.08] mb-6">
            Building Africa's<br>
            <span style="background: linear-gradient(135deg, #60a5fa, #a78bfa, #34d399); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                digital future
            </span>
        </h1>
        <p class="text-lg text-gray-400 max-w-2xl mx-auto leading-relaxed">
            {{ $cms['about_story'] ?? 'Roddy Technologies is a premier software development company dedicated to building exceptional digital experiences for businesses across Africa and beyond.' }}
        </p>
    </div>
</section>

{{-- ═══ STATS ═══ --}}
<section class="py-16 px-6 bg-white">
    <div class="max-w-5xl mx-auto">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach([['50+','Projects Delivered'],['30+','Happy Clients'],['5+','Years Experience'],['100%','Commitment']] as [$val,$lab])
            <div class="text-center py-8 rounded-2xl border border-gray-100 bg-gray-50/60">
                <p class="text-4xl font-bold text-gray-900 tracking-tight">{{ $val }}</p>
                <p class="text-xs text-gray-400 font-medium mt-1.5 uppercase tracking-wider">{{ $lab }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ VISION & MISSION ═══ --}}
<section class="py-24 px-6 bg-[#fafafa]">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-14">
            <p class="text-xs font-semibold text-blue-600 uppercase tracking-widest mb-3">Our Purpose</p>
            <h2 class="text-4xl font-bold text-gray-900 tracking-tight">Why we exist</h2>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            {{-- Vision --}}
            <div class="group relative p-8 rounded-2xl border border-gray-100 bg-white hover:shadow-xl hover:shadow-blue-50 transition-all duration-300">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-6"
                     style="background: linear-gradient(135deg, #eff6ff, #dbeafe);">
                    <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-3">Our Vision</h3>
                <p class="text-gray-500 leading-relaxed">{{ $cms['about_vision'] ?? 'To be the leading technology partner for businesses in Africa, empowering growth through world-class digital solutions.' }}</p>
                <div class="absolute bottom-0 left-8 right-8 h-px bg-gradient-to-r from-transparent via-blue-400/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            </div>

            {{-- Mission --}}
            <div class="group relative p-8 rounded-2xl border border-gray-100 bg-white hover:shadow-xl hover:shadow-green-50 transition-all duration-300">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-6"
                     style="background: linear-gradient(135deg, #f0fdf4, #dcfce7);">
                    <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-3">Our Mission</h3>
                <p class="text-gray-500 leading-relaxed">{{ $cms['about_mission'] ?? 'Delivering innovative, reliable, and scalable digital solutions that create real impact for businesses and communities.' }}</p>
                <div class="absolute bottom-0 left-8 right-8 h-px bg-gradient-to-r from-transparent via-green-400/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            </div>
        </div>
    </div>
</section>

{{-- ═══ VALUES ═══ --}}
<section class="py-24 px-6 bg-[#04040a] relative overflow-hidden">
    <div class="orb w-[400px] h-[400px] bottom-0 left-0 opacity-60"
         style="background: radial-gradient(circle, rgba(37,99,235,0.15) 0%, transparent 70%);"></div>

    <div class="relative max-w-5xl mx-auto">
        <div class="text-center mb-14">
            <p class="text-xs font-semibold text-purple-400 uppercase tracking-widest mb-3">Core Values</p>
            <h2 class="text-4xl font-bold text-white tracking-tight">What drives us</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach([
                ['Quality First','We don\'t ship until it\'s right. Every line of code is a reflection of our standards.','#eff6ff,#dbeafe','text-blue-600'],
                ['Client-Centric','Your success is our success. We listen first and build second.','#f5f3ff,#ede9fe','text-purple-600'],
                ['Innovation','We embrace modern tools and approaches to deliver future-ready solutions.','#f0fdf4,#dcfce7','text-green-600'],
                ['Transparency','No hidden costs, no surprises. Clear communication at every stage.','#fff7ed,#fed7aa','text-orange-600'],
                ['Speed','We move fast without breaking things — disciplined velocity.','#fdf2f8,#fce7f3','text-pink-600'],
                ['Integrity','We do what we say and say what we do.','#f0f9ff,#e0f2fe','text-cyan-600'],
            ] as [$title,$desc,$gradient,$text])
            <div class="p-6 rounded-2xl border" style="background: rgba(255,255,255,0.04); border-color: rgba(255,255,255,0.08);">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center mb-4"
                     style="background: rgba(255,255,255,0.08);">
                    <div class="w-3 h-3 rounded-full" style="background: linear-gradient(135deg,#2563eb,#7c3aed);"></div>
                </div>
                <h3 class="font-semibold text-white mb-2">{{ $title }}</h3>
                <p class="text-sm text-gray-500 leading-relaxed">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ CTA ═══ --}}
<section class="py-24 px-6 bg-white">
    <div class="max-w-2xl mx-auto text-center">
        <h2 class="text-4xl font-bold text-gray-900 tracking-tight mb-4">Ready to work together?</h2>
        <p class="text-gray-500 mb-9">Let's build something great. Reach out and we'll respond within 24 hours.</p>
        <a href="{{ route('contact') }}"
           class="inline-block px-8 py-4 rounded-2xl text-sm font-semibold text-white transition-all hover:scale-[1.02] active:scale-[0.98] shadow-xl"
           style="background: linear-gradient(135deg, #2563eb, #7c3aed); box-shadow: 0 12px 40px rgba(37,99,235,0.35);">
            Start a Conversation
        </a>
    </div>
</section>

</x-layouts.public>
