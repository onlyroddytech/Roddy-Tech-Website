<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::where('email', 'admin@roddy.com')->first();

        $posts = [
            [
                'category'  => 'Development',
                'title'     => 'Why We Choose Laravel for Every Web Project We Build',
                'excerpt'   => 'After years of shipping production web apps, we keep coming back to Laravel — and here\'s exactly why it remains our go-to framework for clients across Africa and beyond.',
                'body'      => '<p>When clients ask us what technology we use to build their web applications, our answer is almost always the same: <strong>Laravel</strong>. But we don\'t just say it — we mean it. After shipping dozens of production projects ranging from simple business websites to complex multi-tenant SaaS platforms, Laravel has consistently proven itself to be the most productive, elegant, and maintainable PHP framework available today.</p>

<h2>The Artisan Experience</h2>
<p>Laravel\'s artisan CLI is a game-changer for development speed. From generating boilerplate with <code>make:model</code> and <code>make:controller</code> to running custom commands, artisan removes friction from every step of the development process. On a recent SaaS dashboard we built for a client in Douala, we scaffolded the entire authentication system, role management, and email notification pipeline in under two days — something that would have taken a full week in a less opinionated framework.</p>

<h2>Eloquent Makes Database Work Feel Natural</h2>
<p>Eloquent ORM is one of Laravel\'s crown jewels. Relationships, scopes, accessors, and mutators allow us to model complex business logic directly in our models. When we built the Rshop eCommerce platform, Eloquent\'s polymorphic relationships let us attach a single review system to both products and vendors without duplicating logic.</p>

<h2>The Ecosystem is Unmatched</h2>
<p>Laravel Sanctum for API authentication, Horizon for queue monitoring, Telescope for debugging, Breeze and Jetstream for starter kits — the ecosystem means we spend less time reinventing wheels and more time delivering value. First-party packages integrate seamlessly and are maintained by a world-class team.</p>

<h2>Security by Default</h2>
<p>CSRF protection, SQL injection prevention, XSS filtering, and bcrypt password hashing are all baked in. For clients handling sensitive business data, this default security posture is not a nice-to-have — it\'s essential. We\'ve never had a security incident on a Laravel project we built from scratch.</p>

<h2>Our Verdict</h2>
<p>Laravel is not just a framework. It is a philosophy: write expressive, clean code that your future self (and your teammates) will thank you for. At Roddy Technologies, it is the foundation we trust when quality matters.</p>',
                'published_at' => now()->subDays(3),
            ],
            [
                'category'  => 'Business',
                'title'     => '5 Signs Your Business Is Ready for a Custom Web Application',
                'excerpt'   => 'Generic software slows growing businesses down. Here are five clear signs that it\'s time to invest in a custom-built web application tailored to how you actually work.',
                'body'      => '<p>Most businesses start with off-the-shelf tools — spreadsheets, WhatsApp groups, Notion boards, or generic SaaS subscriptions. That works perfectly at the beginning. But at some point, the tool stops fitting the business, and the business starts bending itself to fit the tool. That\'s the moment to consider a custom web application.</p>

<h2>1. You Are Managing Critical Data in Spreadsheets</h2>
<p>Spreadsheets are powerful — but they break under scale. When your team is emailing Excel files back and forth, fighting version conflicts, or manually copy-pasting data between sheets, you\'re spending human hours on work a database could handle in milliseconds. A custom app centralises your data, enforces structure, and gives every team member a single source of truth.</p>

<h2>2. Your Workflows Require Too Many Manual Steps</h2>
<p>If your team follows a multi-step process — approvals, notifications, status updates, reminders — and all of that is done manually, you\'re losing hours every week. Custom applications automate the repetitive so your team can focus on the valuable. We\'ve seen clients reclaim 10+ hours per week just by automating invoice follow-ups and project status updates.</p>

<h2>3. You Can\'t Get Useful Reports Fast Enough</h2>
<p>Decision-making at speed requires data at speed. If generating a revenue summary, client report, or operational overview takes hours of manual work, you\'re flying blind. A well-built custom app puts live dashboards and one-click exports at your fingertips.</p>

<h2>4. You Are Paying for Features You Don\'t Use</h2>
<p>Generic SaaS tools bundle dozens of features, but most businesses use 20% of them and pay for 100%. Over time, that is a significant cost. A custom application is built exactly for your use case — no bloat, no paying for unused seats, no workarounds.</p>

<h2>5. Your Competitor Has an Advantage You Can\'t Match Without Technology</h2>
<p>Technology is a competitive moat. If a competitor is processing orders faster, serving clients better, or scaling without proportionally increasing headcount, there\'s a good chance they\'ve invested in custom software. You should too.</p>

<p>At Roddy Technologies, we specialise in turning business workflows into clean, fast, and secure web applications. If any of these signs resonate, <a href="/contact">let\'s talk</a>.</p>',
                'published_at' => now()->subDays(7),
            ],
            [
                'category'  => 'Technology',
                'title'     => 'The Tech Stack Behind Modern African Startups in 2025',
                'excerpt'   => 'African startups are building world-class products — and their technology choices are increasingly sophisticated. We break down the stacks powering the continent\'s fastest-growing digital businesses.',
                'body'      => '<p>The African tech ecosystem has evolved dramatically. Five years ago, many startups were building on whatever their founders happened to know. Today, the continent\'s leading startups are making deliberate, architecture-first technology decisions that rival Silicon Valley peers. Here\'s what the modern African startup stack looks like in 2025.</p>

<h2>Frontend: React and Vue Still Lead</h2>
<p>React remains dominant, particularly among startups with dedicated frontend engineers or those building complex single-page applications. Vue.js is the strong second choice, especially in francophone Africa where the framework\'s gentler learning curve appeals to smaller, full-stack teams. We\'re seeing increased adoption of Next.js for SEO-critical products like marketplaces and content platforms.</p>

<h2>Backend: Laravel, Node.js, and a Growing Python Presence</h2>
<p>Laravel is the MVP for product-focused startups that need to ship fast without sacrificing structure. Node.js dominates real-time applications — ride-hailing, chat, live marketplaces. Python is rising fast on the back of AI/ML integration, with startups embedding intelligence directly into their core product.</p>

<h2>Payments: A Local-First Approach</h2>
<p>Stripe is not the default answer in Africa. Flutterwave, Paystack, and Campay dominate depending on geography. Smart startups build a payment abstraction layer so they can support MTN MoMo, Orange Money, and card payments through a single API interface. This is not optional — it is table stakes for any B2C product on the continent.</p>

<h2>Infrastructure: Managed Cloud Over DIY</h2>
<p>AWS, DigitalOcean, and Render are the most common hosting choices. We\'re seeing a shift away from raw VPS management toward fully managed environments — less DevOps overhead, faster deployments, better reliability. For Cameroonian and West African startups, latency to European edge locations is acceptable for most use cases.</p>

<h2>The AI Layer</h2>
<p>This is the new frontier. Leading startups are integrating LLM APIs (OpenAI, Claude, Gemini) for customer support automation, document processing, and intelligent search. Those who build the AI layer early will have a compounding advantage as the technology matures.</p>

<p>At Roddy Technologies, we help startups make the right technology choices from day one — stacks that scale, teams that ship, and products that win.</p>',
                'published_at' => now()->subDays(12),
            ],
            [
                'category'  => 'Tutorials',
                'title'     => 'How to Build a Multi-Step Form in Laravel with Alpine.js',
                'excerpt'   => 'Multi-step forms improve completion rates and reduce overwhelm. In this tutorial, we walk through building a clean, validated multi-step form using Laravel and Alpine.js — no page reloads required.',
                'body'      => '<p>Multi-step forms are one of the most effective UX patterns for collecting detailed information from users. By breaking a long form into logical steps, you reduce cognitive load and significantly increase completion rates. In this tutorial, we\'ll build a polished multi-step form using <strong>Laravel</strong> for the backend and <strong>Alpine.js</strong> for the frontend state.</p>

<h2>What We Are Building</h2>
<p>A 3-step project inquiry form: Step 1 collects contact info, Step 2 collects project details, and Step 3 is a review + submit screen. We\'ll handle validation per step and show a progress indicator throughout.</p>

<h2>Step 1 — The Alpine.js State</h2>
<p>Alpine.js handles all the multi-step logic client-side. We define a <code>x-data</code> object with a <code>step</code> counter and a <code>form</code> object holding all fields.</p>

<pre><code>&lt;div x-data="{
    step: 1,
    form: {
        name: \'\', email: \'\', phone: \'\',
        service: \'\', budget: \'\', description: \'\'
    },
    next() { this.step++ },
    prev() { this.step-- }
}"&gt;</code></pre>

<h2>Step 2 — Showing and Hiding Steps</h2>
<p>Each step section is wrapped with <code>x-show="step === 1"</code> and a matching transition. This gives a smooth, animated feel with zero JavaScript overhead.</p>

<pre><code>&lt;div x-show="step === 1" x-transition&gt;
    &lt;!-- Contact info fields --&gt;
&lt;/div&gt;

&lt;div x-show="step === 2" x-transition&gt;
    &lt;!-- Project detail fields --&gt;
&lt;/div&gt;</code></pre>

<h2>Step 3 — Server-Side Validation</h2>
<p>On final submit, the form POSTs to a Laravel controller. The controller validates all fields at once using a <code>FormRequest</code>. If validation fails, we pass the errors back and restore the step where the error occurred using a hidden input.</p>

<h2>Step 4 — The Progress Bar</h2>
<p>A simple progress indicator calculates width as <code>:style="\'width: \' + (step / 3 * 100) + \'%\'"</code>. Pair this with a smooth CSS transition and your form feels professional and responsive.</p>

<h2>Wrapping Up</h2>
<p>Multi-step forms are a small UX investment with a large return. Combining Laravel\'s validation power with Alpine.js\'s reactive simplicity gives you a clean solution with minimal overhead. The full source code for this tutorial is available on our GitHub.</p>',
                'published_at' => now()->subDays(18),
            ],
            [
                'category'  => 'Case Studies',
                'title'     => 'How We Built RTG Domains: A Domain Platform for African Businesses',
                'excerpt'   => 'RTG Domains needed to make domain registration fast, affordable, and accessible across Cameroon and West Africa. Here\'s how we approached the architecture, UX, and payment integration.',
                'body'      => '<p>When the idea for RTG Domains was first brought to us, the brief was deceptively simple: <em>"Make it easy for African businesses to register and manage their domains."</em> Anyone who has tried to buy a domain through legacy registrars with poor local payment support knows how frustrating the experience can be. We set out to fix that.</p>

<h2>The Problem</h2>
<p>Existing domain registrars serving African users had three critical failure points: no local payment methods (no MoMo, no Orange Money), English-only interfaces that failed French-speaking markets, and sluggish UX that made a 30-second task feel like a 10-minute ordeal. Our goal was to eliminate all three.</p>

<h2>Architecture Decisions</h2>
<p>We built RTG Domains on a Laravel backend with a Blade + Alpine.js frontend — the same stack we use for most of our product work. Domain availability checks are handled via a WHOIS API integration with sub-second response times. We cache popular TLD availability results for 60 seconds to reduce external API calls during high traffic periods.</p>

<h2>The Live Search Experience</h2>
<p>The hero search bar was the make-or-break feature. We used Alpine.js with a debounced <code>fetch</code> call to our availability endpoint. Results render in under 200ms on average. The visual design shows available domains in green and unavailable ones in red with alternative suggestions — reducing the frustration of hitting a taken name.</p>

<h2>Payment Integration</h2>
<p>We integrated Campay for MTN MoMo and Orange Money payments, with a manual bank transfer fallback. The checkout flow is a 2-step process: select domain + enter payment details. We deliberately avoided the 4–5 step checkout flows common on legacy registrars. Abandonment drops dramatically when checkout is short.</p>

<h2>Results</h2>
<p>Within 60 days of launch, RTG Domains had processed registrations across 6 TLDs. The average checkout time was under 2 minutes. Client satisfaction was measured via a post-purchase survey — 94% of respondents rated the experience "excellent" or "very good."</p>

<p>This project is a great example of what happens when you combine deep local market understanding with clean engineering. Technology that fits the user always wins.</p>',
                'published_at' => now()->subDays(25),
            ],
            [
                'category'  => 'General',
                'title'     => 'What Working With a Boutique Tech Agency Actually Looks Like',
                'excerpt'   => 'Big agencies have big overheads and small attention spans. Here\'s an honest look at what the Roddy Technologies client experience looks like — from first contact to final delivery.',
                'body'      => '<p>There\'s a common fear when hiring a small agency: <em>"Will they disappear after I pay?"</em> It\'s a fair concern. The agency world has its horror stories. But boutique agencies — when they\'re good — offer something larger firms structurally cannot: genuine ownership, real communication, and a team that is actually invested in your outcome.</p>

<p>Here\'s an honest, behind-the-scenes look at how we work at Roddy Technologies.</p>

<h2>Week 1 — Discovery, Not Just Quoting</h2>
<p>We don\'t send quotes after a 15-minute call. Our first step is a discovery session where we understand your business model, your users, your existing tools, and your goals. A good brief prevents a bad build. We\'d rather spend 3 hours understanding the problem than 3 weeks solving the wrong one.</p>

<h2>The Proposal Phase</h2>
<p>Our proposals include scope, technical approach, timeline, and pricing — broken down clearly. No vague "starting from" numbers. You know exactly what you\'re getting and what it costs before any work begins. We build in revision rounds explicitly so there are no surprises mid-project.</p>

<h2>Active Development — You\'re Not in the Dark</h2>
<p>Every client gets access to a live project dashboard where they can see current progress, leave feedback, and message the team directly. We push to a staging environment throughout development so you can review real, working software — not mockups — at every milestone.</p>

<h2>Communication is Synchronous When It Matters</h2>
<p>We\'re available on WhatsApp and email during business hours. For critical feedback points — design approvals, feature reviews — we jump on calls. We don\'t believe in buried Slack threads for decisions that deserve a conversation.</p>

<h2>Delivery and Handover</h2>
<p>On launch day, we do a full walkthrough with your team. We provide documentation, credentials, and a 30-day post-launch support window included in every project. You\'re never handed a finished product and left to figure it out alone.</p>

<p>That\'s the Roddy Technologies experience. If it sounds like how you\'d want to be treated as a client, <a href="/contact">reach out</a> — we\'d love to work with you.</p>',
                'published_at' => now()->subDays(32),
            ],
        ];

        foreach ($posts as $post) {
            BlogPost::create([
                'author_id'    => $author->id,
                'title'        => $post['title'],
                'slug'         => Str::slug($post['title']) . '-' . Str::lower(Str::random(5)),
                'category'     => $post['category'],
                'excerpt'      => $post['excerpt'],
                'body'         => $post['body'],
                'cover_image'  => null,
                'is_published' => true,
                'published_at' => $post['published_at'],
            ]);
        }
    }
}
