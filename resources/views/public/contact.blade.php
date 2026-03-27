{{--
    ┌──────────────────────────────────────────────────────────────────┐
    │  CONTACT PAGE  —  resources/views/public/contact.blade.php       │
    │                                                                  │
    │  Sections:                                                       │
    │   1. HERO         — white, dot grid, glow                        │
    │   2. INFO CARDS   — email, phone, location                       │
    │   3. FORM SECTION — split layout, saves to DB                    │
    │   4. WHATSAPP CTA — quick contact strip                          │
    │   5. FAQ          — Alpine.js accordion                          │
    │                                                                  │
    │  Backend: POST → route('contact.send') → ContactMessage::create  │
    └──────────────────────────────────────────────────────────────────┋
--}}
<x-layouts.public title="Contact Us">

<style>
    /* ── Scroll reveal ──────────────────────────────────────────── */
    .reveal {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.55s cubic-bezier(0.22,1,0.36,1),
                    transform 0.55s cubic-bezier(0.22,1,0.36,1);
    }
    .reveal.visible { opacity: 1; transform: translateY(0); }

    /* ── Hero entrance ──────────────────────────────────────────── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .h-badge { animation: fadeUp 0.55s cubic-bezier(0.22,1,0.36,1) 0.05s both; }
    .h-title { animation: fadeUp 0.65s cubic-bezier(0.22,1,0.36,1) 0.15s both; }
    .h-sub   { animation: fadeUp 0.65s cubic-bezier(0.22,1,0.36,1) 0.25s both; }

    /* ── Info cards ─────────────────────────────────────────────── */
    .info-card {
        background: #ffffff;
        border: 1.5px solid #e5e7eb;
        border-radius: 18px;
        transition: transform 0.20s cubic-bezier(0.22,1,0.36,1),
                    box-shadow 0.20s ease,
                    border-color 0.20s ease;
    }
    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 36px rgba(0,0,0,0.09);
        border-color: #93c5fd;
    }

    /* ── Form inputs ────────────────────────────────────────────── */
    .f-input {
        width: 100%;
        border: 1.5px solid #e5e7eb;
        border-radius: 10px;
        padding: 11px 14px;
        font-size: 14px;
        color: #111827;
        background: #f9fafb;
        outline: none;
        font-family: inherit;
        transition: border-color 0.16s ease, box-shadow 0.16s ease, background 0.16s ease;
    }
    .f-input::placeholder { color: #9ca3af; }
    .f-input:focus {
        border-color: #2563eb;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.12);
    }
    .f-input.is-error { border-color: #ef4444; box-shadow: 0 0 0 3px rgba(239,68,68,0.10); }

    /* ── Submit button ──────────────────────────────────────────── */
    .btn-send {
        width: 100%;
        background: #2563eb;
        color: #fff;
        font-weight: 700;
        font-size: 15px;
        padding: 13px 24px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 4px 16px rgba(37,99,235,0.28);
        transition: background 0.16s ease, transform 0.16s ease, box-shadow 0.16s ease;
    }
    .btn-send:hover  { background: #1d4ed8; transform: translateY(-1px); box-shadow: 0 8px 24px rgba(37,99,235,0.34); }
    .btn-send:active { transform: translateY(0); }
    .btn-send:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

    /* ── FAQ ────────────────────────────────────────────────────── */
    .faq-body {
        overflow: hidden;
        max-height: 0;
        transition: max-height 0.28s cubic-bezier(0.22,1,0.36,1);
    }
    .faq-body.open { max-height: 220px; }
    .faq-icon { transition: transform 0.22s cubic-bezier(0.22,1,0.36,1); }
    .faq-icon.rotated { transform: rotate(45deg); }
</style>

{{-- ═══════════════════════════════════════════════════════════════
     1. HERO
════════════════════════════════════════════════════════════════ --}}
<section class="relative bg-white overflow-hidden pt-32 pb-20 px-4 sm:px-6">

    <div class="absolute inset-0 pointer-events-none"
         style="background-image: radial-gradient(circle, rgba(0,0,0,0.07) 1.5px, transparent 1.5px); background-size: 30px 30px;"></div>
    <div class="absolute top-0 right-0 w-[500px] h-[400px] pointer-events-none"
         style="background: radial-gradient(ellipse at top right, rgba(37,99,235,0.07) 0%, transparent 65%);"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] pointer-events-none"
         style="background: radial-gradient(ellipse at bottom left, rgba(5,150,105,0.06) 0%, transparent 65%);"></div>

    <div class="relative max-w-3xl mx-auto text-center">

        <div class="h-badge inline-flex items-center gap-2 mb-7 px-4 py-2 rounded-full bg-blue-50 border border-blue-200">
            <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-pulse"></span>
            <span class="text-xs font-bold text-blue-700 uppercase tracking-widest">Get In Touch</span>
        </div>

        <h1 class="h-title text-[2.4rem] sm:text-5xl font-black tracking-tight text-gray-900 leading-[1.06] mb-5">
            Let's Build Something<br class="hidden sm:block"> Great Together
        </h1>

        <p class="h-sub text-base sm:text-lg text-gray-600 max-w-xl mx-auto leading-relaxed">
            Have a project in mind? We help businesses grow through technology. Reach out and let's talk about what we can build together.
        </p>

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     2. CONTACT INFO CARDS
════════════════════════════════════════════════════════════════ --}}
<section class="bg-white pb-6 px-4 sm:px-6">
    <div class="max-w-5xl mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

            <div class="info-card reveal p-7">
                <div class="w-11 h-11 rounded-xl bg-blue-600 flex items-center justify-center mb-5">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1.5">Email</p>
                <a href="mailto:info@roddytechnologies.com"
                   class="text-sm font-semibold text-gray-900 hover:text-blue-600 transition-colors break-all">
                    info@roddytechnologies.com
                </a>
                <p class="text-xs text-gray-500 mt-2">We reply within 24 hours</p>
            </div>

            <div class="info-card reveal p-7" style="transition-delay: 70ms">
                <div class="w-11 h-11 rounded-xl bg-green-600 flex items-center justify-center mb-5">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1.5">Phone</p>
                <a href="tel:+237676700173"
                   class="text-sm font-semibold text-gray-900 hover:text-green-600 transition-colors">
                    +237 676 700 173
                </a>
                <p class="text-xs text-gray-500 mt-2">Mon – Fri, 8am – 6pm WAT</p>
            </div>

            <div class="info-card reveal p-7" style="transition-delay: 140ms">
                <div class="w-11 h-11 rounded-xl bg-gray-900 flex items-center justify-center mb-5">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1.5">Location</p>
                <p class="text-sm font-semibold text-gray-900">Cameroon &amp; Nigeria</p>
                <p class="text-xs text-gray-500 mt-2">Serving clients worldwide</p>
            </div>

        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     3. CONTACT FORM — split layout
════════════════════════════════════════════════════════════════ --}}
<section class="bg-white py-20 px-4 sm:px-6">
    <div class="max-w-5xl mx-auto">
        <div class="grid lg:grid-cols-[1fr_500px] gap-14 xl:gap-20 items-start">

            {{-- Left — copy + trust --}}
            <div class="reveal">
                <p class="text-xs font-bold text-blue-600 uppercase tracking-widest mb-4">Send a Message</p>
                <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-gray-900 leading-[1.1] mb-5">
                    We'd love to hear<br>from you
                </h2>
                <p class="text-base text-gray-700 leading-relaxed mb-10">
                    Tell us about your project, idea, or question. We'll review it and get back to you with a clear, honest response — no spam, no sales pressure.
                </p>

                <div class="space-y-4 mb-10">
                    @foreach([
                        ['bg' => 'bg-blue-600',  'path' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',        'text' => 'Response within 24 hours, guaranteed'],
                        ['bg' => 'bg-green-600', 'path' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'text' => 'Your information stays 100% private'],
                        ['bg' => 'bg-gray-900',  'path' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z', 'text' => 'Free consultation on every inquiry'],
                    ] as $s)
                    <div class="flex items-center gap-3.5">
                        <div class="w-8 h-8 rounded-lg {{ $s['bg'] }} flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $s['path'] }}"/>
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-gray-700">{{ $s['text'] }}</p>
                    </div>
                    @endforeach
                </div>

                <div class="inline-flex items-center gap-2 px-4 py-3 rounded-xl bg-green-50 border border-green-200">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                    <span class="text-xs font-semibold text-green-700">Team is online — we typically reply within a few hours</span>
                </div>
            </div>

            {{-- Right — form --}}
            <div class="reveal" x-data="{
                loading: false,
                done: {{ session('success') ? 'true' : 'false' }},
                submit(e) { this.loading = true; e.target.submit(); }
            }">

                {{-- Success --}}
                <div x-show="done" x-cloak
                     class="p-8 rounded-2xl border-2 border-green-200 bg-green-50 text-center">
                    <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center mx-auto mb-5">
                        <svg class="w-7 h-7 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-black text-gray-900 mb-2">Message Sent!</h3>
                    <p class="text-sm text-gray-700 leading-relaxed max-w-xs mx-auto">
                        Thanks for reaching out. We've saved your message and will get back to you within 24 hours.
                    </p>
                    <button @click="done = false"
                            class="mt-6 text-xs font-bold text-blue-600 hover:text-blue-800 underline underline-offset-2 transition-colors">
                        Send another message
                    </button>
                </div>

                {{-- Form --}}
                <form method="POST" action="{{ route('contact.send') }}"
                      @submit.prevent="submit($event)"
                      x-show="!done"
                      class="border border-gray-200 rounded-2xl p-7 sm:p-8 space-y-5 bg-white"
                      style="box-shadow: 0 2px 20px rgba(0,0,0,0.06);">
                    @csrf

                    {{-- Error banner --}}
                    @if($errors->any())
                    <div class="flex items-start gap-3 px-4 py-3.5 rounded-xl border border-red-200 bg-red-50">
                        <svg class="w-4 h-4 text-red-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <div>
                            <p class="text-xs font-bold text-red-700 mb-1">Please fix the errors below:</p>
                            @foreach($errors->all() as $e)
                                <p class="text-xs text-red-600">• {{ $e }}</p>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Name + Email --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" required
                                   value="{{ old('name') }}"
                                   placeholder="John Doe"
                                   class="f-input {{ $errors->has('name') ? 'is-error' : '' }}">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" required
                                   value="{{ old('email') }}"
                                   placeholder="you@company.com"
                                   class="f-input {{ $errors->has('email') ? 'is-error' : '' }}">
                        </div>
                    </div>

                    {{-- Subject --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">Subject</label>
                        <input type="text" name="subject"
                               value="{{ old('subject') }}"
                               placeholder="e.g. Web App Development Quote"
                               class="f-input">
                    </div>

                    {{-- Service --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">Service Interested In</label>
                        <select name="service" class="f-input" style="cursor: pointer;">
                            <option value="" disabled {{ old('service') ? '' : 'selected' }}>Select a service...</option>
                            @foreach(['Web Development','Mobile App Development','SaaS Platform','UI/UX Design','Cloud & Hosting','Digital Strategy','Other'] as $svc)
                                <option value="{{ $svc }}" {{ old('service') === $svc ? 'selected' : '' }}>{{ $svc }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Message --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">
                            Message <span class="text-red-500">*</span>
                        </label>
                        <textarea name="message" rows="5" required
                                  placeholder="Tell us about your project, goals, timeline, or any questions..."
                                  class="f-input resize-none {{ $errors->has('message') ? 'is-error' : '' }}">{{ old('message') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1.5">Minimum 10 characters.</p>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="btn-send" :disabled="loading">
                        <span x-show="!loading">Send Message</span>
                        <span x-show="loading" x-cloak class="flex items-center gap-2">
                            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                            </svg>
                            Sending...
                        </span>
                        <svg x-show="!loading" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </button>

                </form>
            </div>

        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     4. WHATSAPP CTA
════════════════════════════════════════════════════════════════ --}}
<section class="py-16 px-4 sm:px-6 bg-gray-50 border-t border-gray-100">
    <div class="max-w-3xl mx-auto">
        <div class="reveal flex flex-col sm:flex-row items-center gap-6 bg-white rounded-2xl border border-gray-200 p-8"
             style="box-shadow: 0 2px 16px rgba(0,0,0,0.05);">
            <div class="w-14 h-14 rounded-2xl bg-green-600 flex items-center justify-center shrink-0">
                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
            </div>
            <div class="flex-1 text-center sm:text-left">
                <h3 class="text-lg font-black text-gray-900 mb-1">Need urgent help?</h3>
                <p class="text-sm text-gray-700">Skip the form — chat directly with our team on WhatsApp for fast answers.</p>
            </div>
            <a href="https://wa.me/237676700173" target="_blank"
               class="shrink-0 inline-flex items-center gap-2.5 px-6 py-3 rounded-xl bg-green-600 text-white text-sm font-bold hover:bg-green-700 transition-colors"
               style="box-shadow: 0 4px 14px rgba(5,150,105,0.30);">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                Chat on WhatsApp
            </a>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     5. FAQ
════════════════════════════════════════════════════════════════ --}}
<section class="bg-white py-20 px-4 sm:px-6" x-data="{ open: null }">
    <div class="max-w-2xl mx-auto">

        <div class="reveal text-center mb-12">
            <p class="text-xs font-bold text-blue-600 uppercase tracking-widest mb-3">FAQ</p>
            <h2 class="text-3xl font-black tracking-tight text-gray-900">Quick Answers</h2>
        </div>

        @php
        $faqs = [
            ['q' => 'How fast do you respond to inquiries?',
             'a' => 'We respond to all inquiries within 24 hours on business days. For urgent requests, WhatsApp is the fastest way to reach us — we typically reply within a few hours.'],
            ['q' => 'What services does Roddy Technologies offer?',
             'a' => 'We build web applications, mobile apps, SaaS platforms, and provide UI/UX design, cloud hosting, and digital strategy consulting. From simple landing pages to complex enterprise systems.'],
            ['q' => 'Do you work with international clients?',
             'a' => 'Absolutely. We\'re based in Cameroon and Nigeria but work with clients across Africa, Europe, North America, and beyond. All collaboration is handled remotely.'],
            ['q' => 'How do I get a quote for my project?',
             'a' => 'Fill in the contact form above with your project details. We\'ll schedule a free 30-minute consultation and provide a clear itemized proposal within 48 hours.'],
        ];
        @endphp

        <div class="space-y-3">
            @foreach($faqs as $i => $faq)
            <div class="reveal border border-gray-200 rounded-2xl overflow-hidden bg-white transition-all duration-200"
                 :class="open === {{ $i }} ? 'border-blue-300' : ''"
                 style="transition-delay: {{ $i * 55 }}ms">
                <button class="w-full flex items-center justify-between gap-4 px-6 py-5 text-left bg-transparent border-none cursor-pointer font-inherit"
                        @click="open = open === {{ $i }} ? null : {{ $i }}">
                    <span class="text-sm font-bold text-gray-900">{{ $faq['q'] }}</span>
                    <svg class="faq-icon w-5 h-5 text-gray-400 shrink-0"
                         :class="open === {{ $i }} ? 'rotated' : ''"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                </button>
                <div class="faq-body" :class="open === {{ $i }} ? 'open' : ''">
                    <p class="text-sm text-gray-700 leading-relaxed px-6 pb-5">{{ $faq['a'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

<script>
(function () {
    var els = document.querySelectorAll('.reveal');
    var obs = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
            if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); }
        });
    }, { threshold: 0.10 });
    els.forEach(function (el) { obs.observe(el); });
}());
</script>

</x-layouts.public>
