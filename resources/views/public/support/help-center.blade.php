{{--
    ┌──────────────────────────────────────────────────────────────────────┐
    │  HELP CENTER  —  resources/views/public/support/help-center.blade.php│
    │                                                                      │
    │  Sections:                                                           │
    │   1. HERO            — headline + large search bar                  │
    │   2. QUICK HELP      — 4 category shortcut cards                    │
    │   3. FAQ ACCORDION   — category tabs + live search + accordion      │
    │   4. STILL NEED HELP — CTA with contact + WhatsApp buttons          │
    │   5. TRUST BAR       — 3 trust signals                              │
    │                                                                      │
    │  State: Alpine.js (search, activeTab, openIndex)                    │
    │  Future: swap $faqData with Eloquent + AJAX                         │
    └──────────────────────────────────────────────────────────────────────┘
--}}
<x-layouts.public title="Help Center">

<style>
    /* ── Scroll reveal ─────────────────────────────────────────────────── */
    .reveal { opacity:0; transform:translateY(20px); transition:opacity .55s cubic-bezier(.22,1,.36,1), transform .55s cubic-bezier(.22,1,.36,1); }
    .reveal.visible { opacity:1; transform:translateY(0); }

    /* ── Hero animations ───────────────────────────────────────────────── */
    @keyframes hFadeUp { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }
    .h-badge  { animation:hFadeUp .5s cubic-bezier(.22,1,.36,1) .05s both; }
    .h-title  { animation:hFadeUp .6s cubic-bezier(.22,1,.36,1) .13s both; }
    .h-sub    { animation:hFadeUp .6s cubic-bezier(.22,1,.36,1) .21s both; }
    .h-search { animation:hFadeUp .6s cubic-bezier(.22,1,.36,1) .29s both; }
    .h-hint   { animation:hFadeUp .6s cubic-bezier(.22,1,.36,1) .37s both; }

    /* ── Dot-grid background ───────────────────────────────────────────── */
    .dot-grid { background-image:radial-gradient(circle,#e5e7eb 1px,transparent 1px); background-size:26px 26px; }

    /* ── Search bar ────────────────────────────────────────────────────── */
    .search-wrap { position:relative; }
    .search-wrap .s-icon { position:absolute; left:20px; top:50%; transform:translateY(-50%); pointer-events:none; }
    .search-wrap .s-clear { position:absolute; right:20px; top:50%; transform:translateY(-50%); cursor:pointer; }
    .search-input {
        width:100%; padding:18px 52px 18px 54px;
        border:2px solid #e5e7eb; border-radius:16px;
        font-size:1rem; background:#fff;
        box-shadow:0 4px 24px rgba(0,0,0,.06);
        transition:border-color .2s, box-shadow .2s;
        outline:none;
    }
    .search-input:focus { border-color:#3b82f6; box-shadow:0 0 0 4px rgba(59,130,246,.1), 0 4px 24px rgba(0,0,0,.06); }

    /* ── Quick-help cards ──────────────────────────────────────────────── */
    .qcard {
        background:#fff; border:1.5px solid #f1f5f9; border-radius:20px;
        padding:28px 24px; cursor:pointer;
        box-shadow:0 2px 12px rgba(0,0,0,.04);
        transition:transform .22s cubic-bezier(.22,1,.36,1), box-shadow .22s, border-color .22s;
    }
    .qcard:hover { transform:translateY(-5px); box-shadow:0 12px 32px rgba(59,130,246,.12); border-color:#bfdbfe; }
    .qcard-icon {
        width:52px; height:52px; border-radius:14px;
        display:flex; align-items:center; justify-content:center;
        margin-bottom:16px;
    }

    /* ── Category filter tabs ──────────────────────────────────────────── */
    .ctab {
        padding:8px 20px; border-radius:99px;
        font-size:.82rem; font-weight:500; white-space:nowrap; cursor:pointer;
        border:1.5px solid #e5e7eb; color:#6b7280;
        transition:all .18s;
    }
    .ctab:hover { border-color:#93c5fd; color:#2563eb; background:#eff6ff; }
    .ctab.active { background:#2563eb; border-color:#2563eb; color:#fff; box-shadow:0 4px 12px rgba(37,99,235,.25); }

    /* ── FAQ accordion ─────────────────────────────────────────────────── */
    .faq-card {
        background:#fff; border:1.5px solid #f1f5f9; border-radius:16px;
        overflow:hidden; transition:border-color .2s, box-shadow .2s;
    }
    .faq-card:hover { border-color:#dbeafe; }
    .faq-card.open { border-color:#bfdbfe; box-shadow:0 4px 20px rgba(59,130,246,.08); }

    .faq-trigger {
        width:100%; display:flex; align-items:center; justify-content:space-between;
        padding:20px 24px; background:transparent; border:none; cursor:pointer;
        text-align:left; gap:12px;
    }
    .faq-trigger:hover { background:#f8faff; }

    .faq-chevron { transition:transform .25s cubic-bezier(.22,1,.36,1); flex-shrink:0; }
    .faq-chevron.rotated { transform:rotate(180deg); }

    .faq-body { overflow:hidden; transition:max-height .3s cubic-bezier(.22,1,.36,1), opacity .25s; }

    /* ── Trust bar ─────────────────────────────────────────────────────── */
    .trust-pill {
        display:flex; align-items:center; gap:10px;
        padding:14px 22px; background:#fff; border:1.5px solid #f1f5f9;
        border-radius:14px; box-shadow:0 2px 10px rgba(0,0,0,.04);
        transition:transform .2s, box-shadow .2s;
    }
    .trust-pill:hover { transform:translateY(-3px); box-shadow:0 8px 24px rgba(59,130,246,.1); }

    /* ── CTA section ───────────────────────────────────────────────────── */
    .cta-wrap {
        background:linear-gradient(135deg,#1e3a8a 0%,#1d4ed8 50%,#2563eb 100%);
        border-radius:28px; position:relative; overflow:hidden;
    }
    .cta-orb {
        position:absolute; border-radius:50%;
        background:radial-gradient(circle,rgba(255,255,255,.12),transparent 70%);
        pointer-events:none;
    }

    /* ── No-results ────────────────────────────────────────────────────── */
    .no-results { text-align:center; padding:48px 20px; }
</style>

<?php
/* ─────────────────────────────────────────────────────────────────────────
   FAQ DATA  —  swap this for Eloquent queries when ready
   Structure: categories[] → { id, label, icon_path, faqs[] → { q, a } }
───────────────────────────────────────────────────────────────────────── */
$faqData = [
    [
        'id'    => 'general',
        'label' => 'General',
        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"/>',
        'color' => 'bg-blue-50 text-blue-600',
        'faqs'  => [
            [
                'q' => 'What services does Roddy Technologies offer?',
                'a' => 'We build custom websites, web applications, SaaS platforms, e-commerce stores, and digital solutions for businesses across Africa and beyond. Our services include UI/UX design, full-stack development, domain & hosting setup, and ongoing maintenance — all under one roof.',
            ],
            [
                'q' => 'How do I start a project with you?',
                'a' => 'It\'s simple. Reach out through our Contact page or click "Start a Project" anywhere on the site. We schedule a free discovery call to understand your needs, then send you a clear proposal with timeline and pricing within 48 hours.',
            ],
            [
                'q' => 'How long does a typical project take to complete?',
                'a' => 'A Starter website typically takes 1–2 weeks. A Business plan project takes 2–4 weeks depending on content readiness. Premium and custom projects are scoped individually — most are delivered within 4–8 weeks. We provide a clear timeline at the start of every project.',
            ],
            [
                'q' => 'Do you work with clients outside Cameroon?',
                'a' => 'Absolutely. We work with clients across Africa, Europe, and North America. All communication, project management, and delivery happens remotely with no loss in quality. We\'re fluent in both English and French.',
            ],
        ],
    ],
    [
        'id'    => 'pricing',
        'label' => 'Pricing & Payments',
        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/>',
        'color' => 'bg-emerald-50 text-emerald-600',
        'faqs'  => [
            [
                'q' => 'How do payments work?',
                'a' => 'We accept bank transfers, Mobile Money (MTN & Orange), and international payment methods. Payments are made in two stages: 50% deposit before work begins and the remaining 50% upon final delivery and your approval.',
            ],
            [
                'q' => 'Do you require an upfront payment?',
                'a' => 'Yes, we require a 50% deposit to begin work. This covers the discovery phase, initial design concepts, and prototyping. It also secures your spot in our project queue. The deposit is non-refundable after design approval but we offer one full revision round before that.',
            ],
            [
                'q' => 'Can I pay in installments?',
                'a' => 'For larger projects (Business and Premium plans), we can arrange a 3-part payment schedule: 40% to start, 30% at design approval, and 30% at final delivery. This must be agreed upon before the project begins. Contact us to discuss what works best for you.',
            ],
            [
                'q' => 'Can I upgrade my plan after starting?',
                'a' => 'Yes. You can start with the Starter plan and upgrade to Business or Premium at any time. We apply a credit for what you\'ve already paid, so you only pay the difference. Upgrades are handled smoothly — we don\'t start from scratch.',
            ],
        ],
    ],
    [
        'id'    => 'services',
        'label' => 'Website Services',
        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6.75 7.5l3 2.25-3 2.25m4.5 0h3m-9 8.25h13.5A2.25 2.25 0 0021 18V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v12a2.25 2.25 0 002.25 2.25z"/>',
        'color' => 'bg-violet-50 text-violet-600',
        'faqs'  => [
            [
                'q' => 'Do you build fully custom websites?',
                'a' => 'Yes, every project we deliver is custom-built from scratch. We don\'t use WordPress themes or page-builder templates. Your website is coded to your brand, goals, and audience — making it faster, more secure, and completely unique.',
            ],
            [
                'q' => 'Can I request changes after final delivery?',
                'a' => 'Each plan includes a set number of revision rounds during development. After delivery, minor content changes (text, images) within the first month are covered. For structural changes or new features, we provide a transparent hourly or fixed-fee quote.',
            ],
            [
                'q' => 'Do you offer ongoing maintenance after launch?',
                'a' => 'Yes. The Business plan includes 6 months of maintenance and the Premium plan includes full ongoing support. For Starter clients, we offer affordable monthly maintenance packages covering updates, security patches, backups, and uptime monitoring.',
            ],
            [
                'q' => 'Do you provide hosting and domain registration?',
                'a' => 'Yes. We handle domain registration, hosting setup, SSL certificates, and deployment as part of your project. We partner with reliable providers and can also deploy to your existing hosting if preferred. Ongoing hosting costs are separate and always transparent.',
            ],
        ],
    ],
    [
        'id'    => 'support',
        'label' => 'Technical Support',
        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>',
        'color' => 'bg-amber-50 text-amber-600',
        'faqs'  => [
            [
                'q' => 'How do I contact the support team?',
                'a' => 'You can reach us via WhatsApp for fast responses, through our Contact page, or by emailing support@roddytech.com. We aim to respond to all inquiries within 4 business hours. For urgent issues on active projects, WhatsApp is the fastest channel.',
            ],
            [
                'q' => 'Do you provide ongoing technical help after launch?',
                'a' => 'Yes. All active clients have access to our support channel. Depending on your plan, this includes free support for 1–6 months post-launch. After that, we offer affordable retainer packages so you always have a technical partner to call on.',
            ],
            [
                'q' => 'What if I encounter a bug or issue on my website?',
                'a' => 'Bugs discovered within the warranty period (1–6 months depending on your plan) are fixed at no extra cost. We prioritize bug reports and typically resolve critical issues within 24 hours. Non-critical issues are addressed in the next maintenance cycle.',
            ],
            [
                'q' => 'Can you help fix a website built by someone else?',
                'a' => 'Yes, we offer website audit and repair services. We review your existing site, identify issues, and provide a clear fix plan with transparent pricing. Many clients come to us after bad experiences elsewhere — we\'re happy to rescue and improve your existing project.',
            ],
        ],
    ],
];
?>

{{-- ═══════════════════════════════════════════════════════════════════════
     Alpine.js root — wraps the entire page
═══════════════════════════════════════════════════════════════════════ --}}
<div
    x-data="{
        search: '',
        activeTab: 'all',
        openIndex: null,

        tabs: ['all', 'general', 'pricing', 'services', 'support'],

        allFaqs: {{ Js::from(collect($faqData)->flatMap(fn($c) => collect($c['faqs'])->map(fn($f) => ['q' => $f['q'], 'a' => $f['a'], 'cat' => $c['id']]))->values()) }},

        get activeCategory() {
            return {{ Js::from($faqData) }}.find(c => c.id === this.activeTab) ?? null;
        },

        get filteredFaqs() {
            let list = this.activeTab === 'all'
                ? this.allFaqs
                : this.allFaqs.filter(f => f.cat === this.activeTab);

            if (this.search.trim().length > 1) {
                const q = this.search.toLowerCase();
                list = list.filter(f =>
                    f.q.toLowerCase().includes(q) ||
                    f.a.toLowerCase().includes(q)
                );
            }
            return list;
        },

        get resultCount() {
            return this.filteredFaqs.length;
        },

        toggle(i) {
            this.openIndex = this.openIndex === i ? null : i;
        },

        setTab(tab) {
            this.activeTab = tab;
            this.openIndex = null;
            this.search = '';
        },

        jumpToFaq(tab) {
            this.setTab(tab);
            this.$nextTick(() => {
                document.getElementById('faq-section')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        }
    }"
>

{{-- ═══════════════════════════════════════════════════════════════════════
     1. HERO
═══════════════════════════════════════════════════════════════════════ --}}
<section class="relative bg-white overflow-hidden pt-28 pb-24">

    {{-- Dot grid --}}
    <div class="dot-grid absolute inset-0 opacity-60 pointer-events-none"></div>

    {{-- Glow orbs --}}
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-100 rounded-full blur-3xl opacity-40 pointer-events-none"></div>
    <div class="absolute bottom-0 right-1/4 w-80 h-80 bg-indigo-100 rounded-full blur-3xl opacity-30 pointer-events-none"></div>

    <div class="relative z-10 max-w-3xl mx-auto px-6 text-center">

        {{-- Badge --}}
        <div class="h-badge inline-flex items-center gap-2 bg-blue-50 border border-blue-100 text-blue-600 text-xs font-semibold px-4 py-2 rounded-full mb-6">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            Support Center
        </div>

        {{-- Title --}}
        <h1 class="h-title text-5xl sm:text-6xl font-bold text-gray-900 leading-tight tracking-tight mb-5">
            Help Center
        </h1>

        {{-- Subtitle --}}
        <p class="h-sub text-lg text-gray-500 leading-relaxed mb-10 max-w-xl mx-auto">
            Find answers to common questions, browse guides, or reach our team directly.
        </p>

        {{-- Search bar --}}
        <div class="h-search search-wrap max-w-xl mx-auto">
            {{-- Search icon --}}
            <span class="s-icon text-gray-400">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                </svg>
            </span>

            <input
                x-model="search"
                @input="openIndex = null"
                type="text"
                placeholder="Search for answers..."
                class="search-input"
            />

            {{-- Clear button --}}
            <button
                x-show="search.length > 0"
                @click="search = ''; openIndex = null"
                class="s-clear text-gray-400 hover:text-gray-600 transition-colors"
                aria-label="Clear search"
            >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Hint --}}
        <p class="h-hint mt-4 text-sm text-gray-400">
            Popular:
            <button @click="jumpToFaq('pricing')" class="text-blue-500 hover:underline mx-1">Pricing</button>·
            <button @click="jumpToFaq('services')" class="text-blue-500 hover:underline mx-1">Services</button>·
            <button @click="jumpToFaq('support')" class="text-blue-500 hover:underline mx-1">Support</button>
        </p>

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════════
     2. QUICK HELP CARDS
═══════════════════════════════════════════════════════════════════════ --}}
<section class="bg-gray-50/60 py-16" x-show="search.length < 2">
    <div class="max-w-6xl mx-auto px-6">

        <div class="text-center mb-12 reveal">
            <h2 class="text-2xl font-bold text-gray-900">Browse by Topic</h2>
            <p class="text-gray-500 mt-2 text-sm">Jump straight to what you need</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

            {{-- Getting Started --}}
            <div class="qcard reveal" @click="jumpToFaq('general')">
                <div class="qcard-icon bg-blue-50">
                    <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Getting Started</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Learn how to kick off your project and what to expect from us.</p>
                <div class="flex items-center gap-1.5 mt-4 text-blue-600 text-xs font-semibold">
                    View answers
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </div>
            </div>

            {{-- Pricing & Payments --}}
            <div class="qcard reveal" @click="jumpToFaq('pricing')">
                <div class="qcard-icon bg-emerald-50">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Pricing & Payments</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Understand our pricing plans, deposit policy, and payment options.</p>
                <div class="flex items-center gap-1.5 mt-4 text-emerald-600 text-xs font-semibold">
                    View answers
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </div>
            </div>

            {{-- Website Services --}}
            <div class="qcard reveal" @click="jumpToFaq('services')">
                <div class="qcard-icon bg-violet-50">
                    <svg class="w-6 h-6 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6.75 7.5l3 2.25-3 2.25m4.5 0h3m-9 8.25h13.5A2.25 2.25 0 0021 18V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v12a2.25 2.25 0 002.25 2.25z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Website Services</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Custom builds, revisions, maintenance, hosting, and deployment.</p>
                <div class="flex items-center gap-1.5 mt-4 text-violet-600 text-xs font-semibold">
                    View answers
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </div>
            </div>

            {{-- Technical Support --}}
            <div class="qcard reveal" @click="jumpToFaq('support')">
                <div class="qcard-icon bg-amber-50">
                    <svg class="w-6 h-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Technical Support</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Bug reports, post-launch help, and emergency contact channels.</p>
                <div class="flex items-center gap-1.5 mt-4 text-amber-600 text-xs font-semibold">
                    View answers
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════════
     3. FAQ ACCORDION
═══════════════════════════════════════════════════════════════════════ --}}
<section id="faq-section" class="bg-white py-20">
    <div class="max-w-3xl mx-auto px-6">

        {{-- Section header --}}
        <div class="text-center mb-12 reveal">
            <h2 class="text-3xl font-bold text-gray-900 mb-3">
                <span x-show="search.length > 1" x-text="'Search results for &quot;' + search + '&quot;'"></span>
                <span x-show="search.length < 2">Frequently Asked Questions</span>
            </h2>
            <p class="text-gray-500 text-sm" x-show="search.length < 2">Everything you need to know, in one place.</p>
            <p class="text-gray-500 text-sm" x-show="search.length > 1">
                <span x-text="resultCount"></span> result<span x-show="resultCount !== 1">s</span> found
            </p>
        </div>

        {{-- Category tabs —— hidden when searching --}}
        <div
            x-show="search.length < 2"
            class="flex flex-wrap gap-2 justify-center mb-10 reveal"
        >
            <button class="ctab" :class="{ active: activeTab === 'all' }"   @click="setTab('all')">All Questions</button>
            <button class="ctab" :class="{ active: activeTab === 'general' }"  @click="setTab('general')">General</button>
            <button class="ctab" :class="{ active: activeTab === 'pricing' }"  @click="setTab('pricing')">Pricing</button>
            <button class="ctab" :class="{ active: activeTab === 'services' }" @click="setTab('services')">Services</button>
            <button class="ctab" :class="{ active: activeTab === 'support' }"  @click="setTab('support')">Support</button>
        </div>

        {{-- FAQ list --}}
        <div class="space-y-3">

            <template x-if="filteredFaqs.length === 0">
                <div class="no-results">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                        </svg>
                    </div>
                    <p class="text-gray-900 font-semibold mb-2">No results found</p>
                    <p class="text-gray-400 text-sm">Try a different keyword or <button @click="search = ''" class="text-blue-500 hover:underline">clear your search</button>.</p>
                </div>
            </template>

            <template x-for="(faq, i) in filteredFaqs" :key="i">
                <div
                    class="faq-card"
                    :class="{ open: openIndex === i }"
                >
                    {{-- Trigger --}}
                    <button class="faq-trigger" @click="toggle(i)" :aria-expanded="openIndex === i">
                        <span class="font-medium text-gray-900 text-sm leading-snug pr-2" x-text="faq.q"></span>
                        <svg
                            class="faq-chevron w-4 h-4 text-gray-400 flex-shrink-0"
                            :class="{ rotated: openIndex === i }"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                        </svg>
                    </button>

                    {{-- Body --}}
                    <div
                        class="faq-body"
                        :style="openIndex === i ? 'max-height:400px; opacity:1;' : 'max-height:0; opacity:0;'"
                    >
                        <div class="px-6 pb-5 pt-1">
                            <div class="w-full h-px bg-gray-100 mb-4"></div>
                            <p class="text-sm text-gray-600 leading-relaxed" x-text="faq.a"></p>
                        </div>
                    </div>
                </div>
            </template>

        </div>

        {{-- Result count footer (only when all tab, no search) --}}
        <p
            class="text-center text-xs text-gray-400 mt-8"
            x-show="search.length < 2"
            x-text="'Showing ' + filteredFaqs.length + ' question' + (filteredFaqs.length !== 1 ? 's' : '')"
        ></p>

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════════
     4. STILL NEED HELP
═══════════════════════════════════════════════════════════════════════ --}}
<section class="bg-gray-50/60 py-20">
    <div class="max-w-5xl mx-auto px-6">
        <div class="cta-wrap p-10 sm:p-14 text-center reveal">

            {{-- Orbs --}}
            <div class="cta-orb w-96 h-96 -top-20 -left-20"></div>
            <div class="cta-orb w-72 h-72 -bottom-16 -right-16"></div>

            <div class="relative z-10">
                {{-- Icon --}}
                <div class="w-16 h-16 bg-white/15 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/>
                    </svg>
                </div>

                <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">Still need help?</h2>
                <p class="text-blue-100 text-base mb-10 max-w-md mx-auto leading-relaxed">
                    Our team is ready to assist. Reach out and we\'ll get back to you within a few hours.
                </p>

                {{-- Buttons --}}
                <div class="flex flex-col sm:flex-row gap-3 justify-center items-center">

                    {{-- Contact Support --}}
                    <a
                        href="{{ route('contact') }}"
                        class="inline-flex items-center gap-2.5 bg-white text-blue-700 font-semibold px-7 py-3.5 rounded-xl hover:bg-blue-50 transition-colors shadow-lg shadow-blue-900/20 text-sm"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                        </svg>
                        Contact Support
                    </a>

                    {{-- Start a Project --}}
                    <a
                        href="{{ route('contact') }}?subject=new-project"
                        class="inline-flex items-center gap-2.5 bg-white/10 border border-white/20 text-white font-semibold px-7 py-3.5 rounded-xl hover:bg-white/20 transition-colors text-sm backdrop-blur-sm"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        Start a Project
                    </a>

                    {{-- WhatsApp --}}
                    <a
                        href="https://wa.me/237XXXXXXXXX?text=Hi%2C%20I%20need%20help%20with..."
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center gap-2.5 bg-[#25D366]/90 border border-[#25D366] text-white font-semibold px-7 py-3.5 rounded-xl hover:bg-[#22c55e] transition-colors text-sm"
                    >
                        {{-- WhatsApp SVG --}}
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        WhatsApp Us
                    </a>

                </div>

                {{-- Response time note --}}
                <p class="text-blue-200/70 text-xs mt-6">
                    Average response time: <span class="text-blue-100 font-medium">under 4 hours</span> during business days
                </p>

            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════════
     5. TRUST BAR
═══════════════════════════════════════════════════════════════════════ --}}
<section class="bg-white py-16 border-t border-gray-100">
    <div class="max-w-4xl mx-auto px-6">

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

            {{-- Fast response --}}
            <div class="trust-pill reveal">
                <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 text-sm">Fast Response Time</p>
                    <p class="text-gray-500 text-xs mt-0.5">Under 4 hours on business days</p>
                </div>
            </div>

            {{-- Professional support --}}
            <div class="trust-pill reveal">
                <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 text-sm">Professional Support</p>
                    <p class="text-gray-500 text-xs mt-0.5">Dedicated team for every client</p>
                </div>
            </div>

            {{-- Client satisfaction --}}
            <div class="trust-pill reveal">
                <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 text-sm">100% Client Satisfaction</p>
                    <p class="text-gray-500 text-xs mt-0.5">We don\'t stop until you\'re happy</p>
                </div>
            </div>

        </div>
    </div>
</section>

</div>{{-- /Alpine root --}}

{{-- ═══════════════════════════════════════════════════════════════════════
     Scroll-reveal script
═══════════════════════════════════════════════════════════════════════ --}}
<script>
(function () {
    const els = document.querySelectorAll('.reveal');
    if (!els.length) return;
    const io = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) { e.target.classList.add('visible'); io.unobserve(e.target); }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
    els.forEach(el => io.observe(el));
})();
</script>

</x-layouts.public>
