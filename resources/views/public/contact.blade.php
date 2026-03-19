<x-layouts.public title="Contact Us">

{{-- ═══ HERO ═══ --}}
<section class="relative pt-32 pb-20 px-6 overflow-hidden bg-[#04040a]">
    <div class="orb w-[450px] h-[450px] top-[-80px] right-[-60px]"
         style="background: radial-gradient(circle, rgba(124,58,237,0.2) 0%, transparent 70%);"></div>
    <div class="orb w-[350px] h-[350px] bottom-0 left-[-60px]"
         style="background: radial-gradient(circle, rgba(37,99,235,0.16) 0%, transparent 70%);"></div>
    <div class="absolute inset-0 opacity-[0.025]"
         style="background-image: linear-gradient(rgba(255,255,255,.5) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.5) 1px, transparent 1px); background-size: 40px 40px;"></div>

    <div class="relative max-w-3xl mx-auto text-center">
        <div class="inline-flex items-center gap-2 mb-6 px-4 py-1.5 rounded-full text-xs font-medium text-blue-300 border"
             style="background: rgba(37,99,235,0.1); border-color: rgba(37,99,235,0.3);">
            <span class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></span>
            Let's Talk
        </div>
        <h1 class="text-5xl sm:text-6xl font-bold tracking-tight text-white leading-[1.08] mb-5">
            Start a conversation
        </h1>
        <p class="text-lg text-gray-400 max-w-xl mx-auto leading-relaxed">
            Have a project in mind? We'd love to hear about it. Drop us a message and we'll respond within 24 hours.
        </p>
    </div>
</section>

{{-- ═══ CONTACT SECTION ═══ --}}
<section class="py-24 px-6 bg-white">
    <div class="max-w-5xl mx-auto">
        <div class="grid lg:grid-cols-[1fr_420px] gap-12 items-start">

            {{-- Left — info --}}
            <div>
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight mb-3">We're here to help</h2>
                <p class="text-gray-500 leading-relaxed mb-10">Whether you're ready to start a project, have questions about our services, or just want to explore the possibilities — reach out.</p>

                <div class="space-y-6">
                    {{-- Email --}}
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0"
                             style="background: linear-gradient(135deg,#eff6ff,#dbeafe);">
                            <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-0.5">Email</p>
                            <a href="mailto:{{ $cms['contact_email'] ?? 'hello@roddytechnologies.com' }}"
                               class="text-sm font-medium text-gray-900 hover:text-blue-600 transition-colors">
                                {{ $cms['contact_email'] ?? 'hello@roddytechnologies.com' }}
                            </a>
                        </div>
                    </div>

                    {{-- Phone --}}
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0"
                             style="background: linear-gradient(135deg,#f5f3ff,#ede9fe);">
                            <svg class="w-5 h-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-0.5">Phone</p>
                            <p class="text-sm font-medium text-gray-900">{{ $cms['contact_phone'] ?? '+237 6XX XXX XXX' }}</p>
                        </div>
                    </div>

                    {{-- Location --}}
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0"
                             style="background: linear-gradient(135deg,#f0fdf4,#dcfce7);">
                            <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-0.5">Location</p>
                            <p class="text-sm font-medium text-gray-900">{{ $cms['contact_address'] ?? 'Yaoundé, Cameroon 🇨🇲' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Response time badge --}}
                <div class="mt-10 inline-flex items-center gap-2.5 px-4 py-3 rounded-xl border border-green-100 bg-green-50">
                    <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                    <span class="text-xs font-medium text-green-700">We typically respond within <strong>24 hours</strong></span>
                </div>
            </div>

            {{-- Right — form --}}
            <div class="p-8 rounded-2xl border border-gray-100 bg-white shadow-sm">

                @if(session('success'))
                    <div class="mb-6 flex items-center gap-2.5 px-4 py-3 rounded-xl text-sm border border-green-200 bg-green-50 text-green-700">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('contact.send') }}" class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Name</label>
                            <input type="text" name="name" required value="{{ old('name') }}"
                                   placeholder="John Doe"
                                   class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition">
                            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Email</label>
                            <input type="email" name="email" required value="{{ old('email') }}"
                                   placeholder="you@example.com"
                                   class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition">
                            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Subject</label>
                        <input type="text" name="subject" value="{{ old('subject') }}"
                               placeholder="What's this about?"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Message</label>
                        <textarea name="message" rows="5" required
                                  placeholder="Tell us about your project..."
                                  class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition resize-none">{{ old('message') }}</textarea>
                        @error('message')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit"
                            class="w-full py-3 rounded-xl text-sm font-semibold text-white transition-all hover:opacity-90 hover:scale-[1.01] active:scale-[0.98]"
                            style="background: linear-gradient(135deg, #2563eb, #7c3aed); box-shadow: 0 4px 20px rgba(37,99,235,0.35);">
                        Send Message
                        <span class="ml-1">→</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

</x-layouts.public>
