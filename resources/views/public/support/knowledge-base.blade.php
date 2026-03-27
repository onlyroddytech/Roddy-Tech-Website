{{--
    ┌──────────────────────────────────────────────────────────────────┐
    │  KNOWLEDGE BASE  —  resources/views/public/support/             │
    │                      knowledge-base.blade.php                   │
    │                                                                  │
    │  Layout: 2-column sticky sidebar + content area                  │
    │  State: Alpine.js (view: home / category / article)             │
    │                                                                  │
    │  Sections:                                                       │
    │   1. HERO            — title + search bar                       │
    │   2. KB LAYOUT       — sidebar + content (3 sub-views)          │
    │      ↳ HOME VIEW     — category grid + featured articles        │
    │      ↳ CATEGORY VIEW — article list for selected category       │
    │      ↳ ARTICLE VIEW  — full article with TOC                    │
    │   3. CTA             — "Still need help?" dark banner           │
    │                                                                  │
    │  Future: replace $kbData PHP array with DB queries               │
    └──────────────────────────────────────────────────────────────────┘
--}}
<x-layouts.public title="Knowledge Base">

<style>
    /* ── Scroll reveal ───────────────────────────────────────────── */
    .reveal { opacity:0; transform:translateY(20px); transition:opacity .55s cubic-bezier(.22,1,.36,1),transform .55s cubic-bezier(.22,1,.36,1); }
    .reveal.visible { opacity:1; transform:translateY(0); }

    /* ── Hero entrance ───────────────────────────────────────────── */
    @keyframes fadeUp { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }
    .h-title { animation:fadeUp .6s cubic-bezier(.22,1,.36,1) .1s both; }
    .h-sub   { animation:fadeUp .6s cubic-bezier(.22,1,.36,1) .2s both; }
    .h-srch  { animation:fadeUp .6s cubic-bezier(.22,1,.36,1) .3s both; }

    /* ── Dot grid ────────────────────────────────────────────────── */
    .dot-grid { background-image:radial-gradient(circle,#d1d5db 1px,transparent 1px); background-size:28px 28px; }

    /* ── Sidebar nav link ────────────────────────────────────────── */
    .nav-link { display:flex; align-items:center; gap:8px; padding:7px 12px; border-radius:10px; font-size:.825rem; font-weight:500; color:#6b7280; transition:background .15s,color .15s; cursor:pointer; text-decoration:none; }
    .nav-link:hover { background:#f3f4f6; color:#111827; }
    .nav-link.active { background:#eff6ff; color:#1d4ed8; font-weight:600; }

    .nav-article { display:flex; align-items:center; gap:6px; padding:5px 12px 5px 28px; border-radius:8px; font-size:.78rem; color:#6b7280; transition:background .15s,color .15s; cursor:pointer; }
    .nav-article:hover { background:#f9fafb; color:#374151; }
    .nav-article.active { color:#1d4ed8; font-weight:600; }

    /* ── Category cards ──────────────────────────────────────────── */
    .cat-card { background:#fff; border:1.5px solid #e5e7eb; border-radius:18px; transition:transform .20s cubic-bezier(.22,1,.36,1),box-shadow .20s ease,border-color .20s ease; cursor:pointer; }
    .cat-card:hover { transform:translateY(-5px); box-shadow:0 16px 44px rgba(0,0,0,.08); border-color:#bfdbfe; }

    /* ── Article list items ──────────────────────────────────────── */
    .art-item { background:#fff; border:1.5px solid #e5e7eb; border-radius:14px; transition:transform .18s ease,box-shadow .18s ease,border-color .18s ease; cursor:pointer; }
    .art-item:hover { transform:translateY(-3px); box-shadow:0 10px 30px rgba(0,0,0,.07); border-color:#bfdbfe; }

    /* ── Article content typography ──────────────────────────────── */
    .prose-kb h2 { font-size:1.25rem; font-weight:700; color:#111827; margin:2rem 0 .75rem; padding-bottom:.5rem; border-bottom:1px solid #f3f4f6; }
    .prose-kb h3 { font-size:1.05rem; font-weight:600; color:#1f2937; margin:1.5rem 0 .5rem; }
    .prose-kb p  { font-size:.9rem; color:#374151; line-height:1.8; margin-bottom:1rem; }
    .prose-kb ul,.prose-kb ol { padding-left:1.4rem; margin-bottom:1rem; }
    .prose-kb li { font-size:.9rem; color:#374151; line-height:1.7; margin-bottom:.35rem; }
    .prose-kb ul li { list-style-type:disc; }
    .prose-kb ol li { list-style-type:decimal; }
    .prose-kb code { background:#f3f4f6; color:#1d4ed8; font-family:monospace; font-size:.82rem; padding:2px 6px; border-radius:5px; }
    .prose-kb pre  { background:#1e293b; border-radius:14px; padding:1.25rem 1.5rem; overflow-x:auto; margin:1.25rem 0; }
    .prose-kb pre code { background:transparent; color:#e2e8f0; padding:0; font-size:.83rem; line-height:1.7; }
    .prose-kb blockquote { border-left:3px solid #2563eb; padding:.75rem 1rem; background:#eff6ff; border-radius:0 10px 10px 0; margin:1.25rem 0; }
    .prose-kb blockquote p { color:#1d4ed8; margin:0; }
    .prose-kb a { color:#2563eb; text-decoration:underline; text-underline-offset:3px; }
    .prose-kb strong { color:#111827; font-weight:600; }
    .prose-kb .note { background:#f0fdf4; border:1px solid #bbf7d0; border-radius:10px; padding:.875rem 1rem; margin:1rem 0; }
    .prose-kb .note p { color:#15803d; margin:0; font-size:.85rem; }
    .prose-kb .warn { background:#fff7ed; border:1px solid #fed7aa; border-radius:10px; padding:.875rem 1rem; margin:1rem 0; }
    .prose-kb .warn p { color:#c2410c; margin:0; font-size:.85rem; }

    /* ── TOC ─────────────────────────────────────────────────────── */
    .toc-link { display:block; font-size:.78rem; color:#9ca3af; padding:3px 0; transition:color .15s; }
    .toc-link:hover { color:#1d4ed8; }

    /* ── Search highlight ────────────────────────────────────────── */
    mark { background:#dbeafe; color:#1d4ed8; border-radius:3px; padding:0 2px; }
</style>

@php
/*
 * ─────────────────────────────────────────────────────────────
 *  KB DATA  (replace with DB queries in future)
 *  Structure mirrors what a KbCategory + KbArticle model would return.
 * ─────────────────────────────────────────────────────────────
 */
$kbData = [
    [
        'id'          => 'getting-started',
        'title'       => 'Getting Started',
        'description' => 'Your first steps with Roddy Technologies — from contacting us to launching your project.',
        'icon_path'   => 'M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z',
        'color'       => 'bg-blue-50 text-blue-600 border-blue-100',
        'articles'    => [
            [
                'id'        => 'gs-1',
                'title'     => 'How to Start a Project with Roddy Technologies',
                'excerpt'   => 'Learn the step-by-step process for initiating a new project, from first contact to kickoff.',
                'read_time' => 4,
                'featured'  => true,
                'content'   => '<h2>Overview</h2><p>Starting a project with Roddy Technologies is designed to be simple, transparent, and fast. This guide walks you through everything that happens from your first message to the day your project kicks off.</p><h2>Step 1 — Reach Out</h2><p>Contact us via the <a href="/contact">Contact page</a> or WhatsApp. Include a brief description of what you need. The more context you give, the faster we can prepare a relevant response.</p><div class="note"><p>💡 Pro tip: Attach any reference sites, sketches, or brand assets you already have. It saves time in discovery.</p></div><h2>Step 2 — Discovery Call</h2><p>We schedule a short call (30–60 min) to understand:</p><ul><li>Your business and goals</li><li>The problem you are solving</li><li>Your target users</li><li>Timeline and budget expectations</li></ul><h2>Step 3 — Proposal</h2><p>Within 48 hours of the discovery call, you receive a written proposal including:</p><ul><li>Scope of work</li><li>Technology stack recommendation</li><li>Timeline with milestones</li><li>Pricing breakdown</li></ul><h2>Step 4 — Agreement & Deposit</h2><p>Once you approve the proposal, we send a simple project agreement. Work begins after the 50% upfront deposit is received via MTN MoMo, Orange Money, or bank transfer.</p><div class="note"><p>✅ After deposit, your project is scheduled and you receive access to your client dashboard.</p></div>',
            ],
            [
                'id'        => 'gs-2',
                'title'     => 'Understanding Our Project Dashboard',
                'excerpt'   => 'A walkthrough of the client dashboard — track progress, leave feedback, and communicate with your team.',
                'read_time' => 3,
                'featured'  => false,
                'content'   => '<h2>What is the Client Dashboard?</h2><p>Every client at Roddy Technologies gets access to a secure project dashboard. It is your single source of truth for the project — no chasing emails, no wondering what\'s happening.</p><h2>What You Can Do</h2><ul><li>View real-time project progress (percentage complete)</li><li>Read milestone updates posted by the team</li><li>Send and receive messages directly to your project team</li><li>View and download invoices</li><li>Access shared files and design assets</li></ul><h2>How to Access</h2><p>You receive your login credentials by email after the project deposit is confirmed. Visit <code>/login</code> and use the email address you registered with.</p><div class="warn"><p>⚠️ Keep your login credentials secure. Do not share them. Contact us if you need to update your password.</p></div><h2>Getting Support</h2><p>Use the in-dashboard messaging for all project-related questions. For billing or account issues, email us directly at <strong>hello@roddytechnologies.com</strong>.</p>',
            ],
            [
                'id'        => 'gs-3',
                'title'     => 'What Happens After Your Project Launches',
                'excerpt'   => 'Post-launch support, handover process, and how ongoing maintenance works.',
                'read_time' => 3,
                'featured'  => true,
                'content'   => '<h2>Launch Day</h2><p>On launch day, our team deploys your project to the live environment, verifies all functionality, and runs a final quality check. You will receive a launch summary with:</p><ul><li>Live URL and all credentials</li><li>Admin login details (if applicable)</li><li>Hosting and domain information</li><li>A brief walkthrough video for your team</li></ul><h2>30-Day Support Window</h2><p>All plans include a 30-day post-launch support window. During this period, we fix any bugs that surface at no additional charge. This does not cover new feature requests.</p><h2>Ongoing Maintenance</h2><p>Business and Premium plan clients receive 6 months and full-project maintenance respectively. For Starter clients, we offer affordable monthly maintenance packages starting at 15,000 XAF/month covering:</p><ul><li>Security updates</li><li>CMS content changes</li><li>Minor bug fixes</li><li>Uptime monitoring</li></ul><h2>Requesting Changes</h2><p>Changes outside the original scope are quoted separately. Submit a request via your dashboard and we will respond with a quote within 24 hours.</p>',
            ],
        ],
    ],
    [
        'id'          => 'website-services',
        'title'       => 'Website Services',
        'description' => 'Deep dives into our web design and development services, processes, and deliverables.',
        'icon_path'   => 'M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253',
        'color'       => 'bg-green-50 text-green-600 border-green-100',
        'articles'    => [
            [
                'id'        => 'ws-1',
                'title'     => 'What\'s Included in a Starter Website',
                'excerpt'   => 'Everything that comes with the Starter plan — pages, features, and what to expect.',
                'read_time' => 3,
                'featured'  => false,
                'content'   => '<h2>Starter Plan Deliverables</h2><p>The Starter plan is designed for small businesses and entrepreneurs who need a clean, professional web presence quickly. Here is exactly what is included:</p><h2>Pages</h2><ul><li>Home page with hero, services overview, and CTA</li><li>About page</li><li>Services or Products page</li><li>Contact page with form</li></ul><h2>Technical Features</h2><ul><li>Mobile-responsive design (tested on iOS and Android)</li><li>Business email setup (e.g. you@yourdomain.com)</li><li>Contact form connected to your inbox</li><li>Basic on-page SEO (titles, meta descriptions, sitemap)</li><li>Google Analytics integration</li><li>SSL certificate (HTTPS)</li></ul><h2>Design Process</h2><p>After the discovery call, we produce one design direction for your approval. You get two revision rounds before development begins. Final design files are yours to keep.</p><div class="note"><p>💡 Starter sites are typically delivered in 7–14 days after design approval.</p></div>',
            ],
            [
                'id'        => 'ws-2',
                'title'     => 'Business Plan — Full Feature Breakdown',
                'excerpt'   => 'What sets the Business plan apart: multi-page, live chat, Google Maps, and 6-month maintenance.',
                'read_time' => 4,
                'featured'  => true,
                'content'   => '<h2>Business Plan Overview</h2><p>The Business plan is our most popular package for a reason — it covers everything a growing company needs to build credibility, generate leads, and retain customers online.</p><h2>Everything in Starter, Plus</h2><ul><li>Up to 8 custom pages</li><li>Premium UI/UX design (custom-crafted, not templated)</li><li>Live chat integration (Tawk.to or WhatsApp widget)</li><li>Google Maps integration on Contact page</li><li>Blog or news section with easy content management</li><li>Social media links and Open Graph tags</li><li>6 months of maintenance included</li></ul><h2>CMS Integration</h2><p>We build your site on a clean CMS so your team can update content without touching code. Training is included in the delivery handover.</p><h2>Performance Standards</h2><p>Business plan sites are built to score 90+ on Google PageSpeed. We optimise images, lazy-load content, and use caching to keep your site fast everywhere.</p>',
            ],
            [
                'id'        => 'ws-3',
                'title'     => 'How We Handle Revisions & Feedback',
                'excerpt'   => 'Our revision process, how to give good feedback, and what happens if you want major changes.',
                'read_time' => 3,
                'featured'  => false,
                'content'   => '<h2>Revision Rounds</h2><p>Every project includes structured revision rounds to ensure you are happy with the direction before we move to the next phase:</p><ul><li><strong>Design phase:</strong> 2 revision rounds included</li><li><strong>Development phase:</strong> 1 revision round included</li><li><strong>Post-launch:</strong> Bug fixes only (no new features)</li></ul><h2>How to Give Useful Feedback</h2><p>The best feedback is specific and actionable. Instead of "I don\'t like this", try:</p><ul><li>"Can we make the heading font bolder?"</li><li>"The button colour doesn\'t match our brand — use #1d4ed8 instead"</li><li>"Move the testimonials section above the pricing"</li></ul><div class="note"><p>💡 We use a shared feedback document so all comments are tracked and nothing is missed.</p></div><h2>Major Changes After Approval</h2><p>If you request significant structural changes after design approval (e.g. changing the entire layout concept), this may require a change order with an additional quote. We always discuss this transparently before proceeding.</p>',
            ],
        ],
    ],
    [
        'id'          => 'payments-billing',
        'title'       => 'Payments & Billing',
        'description' => 'How invoicing, payment schedules, accepted methods, and receipts work.',
        'icon_path'   => 'M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z',
        'color'       => 'bg-purple-50 text-purple-600 border-purple-100',
        'articles'    => [
            [
                'id'        => 'pb-1',
                'title'     => 'Payment Schedule & Deposit Policy',
                'excerpt'   => 'How our 50/50 payment structure works and when each payment is due.',
                'read_time' => 2,
                'featured'  => false,
                'content'   => '<h2>Our Payment Structure</h2><p>We use a straightforward two-payment model for all projects:</p><ul><li><strong>50% upfront</strong> — due before any design or development work begins</li><li><strong>50% on delivery</strong> — due when the project is complete and live</li></ul><p>This structure protects both parties. You never pay in full until you have a finished product, and we can commit our team\'s time without financial risk.</p><h2>When Is the Deposit Due?</h2><p>The deposit is due within 48 hours of signing the project agreement. Work begins the next business day after confirmation of receipt.</p><div class="warn"><p>⚠️ Your project slot is not reserved until the deposit is received. During busy periods, waiting too long may push your start date out by 1–2 weeks.</p></div><h2>For Larger Projects</h2><p>Premium and custom enterprise projects may use a milestone-based payment schedule (e.g. 40% deposit, 30% at mid-project, 30% on delivery). This is agreed in the proposal phase.</p>',
            ],
            [
                'id'        => 'pb-2',
                'title'     => 'Accepted Payment Methods',
                'excerpt'   => 'MTN MoMo, Orange Money, bank transfer — how to pay and what details you need.',
                'read_time' => 2,
                'featured'  => true,
                'content'   => '<h2>Accepted Methods</h2><p>We accept the following payment methods for all projects:</p><ul><li><strong>MTN Mobile Money (MoMo)</strong> — instant, recommended</li><li><strong>Orange Money</strong> — instant</li><li><strong>Bank Transfer</strong> — 1–3 business days to clear</li><li><strong>Cash</strong> — in-person in Douala only</li></ul><h2>Making a Payment</h2><p>After agreement, you receive an invoice via email with the exact amount and payment details for your preferred method. Once payment is made:</p><ol><li>Send the transaction confirmation to <strong>hello@roddytechnologies.com</strong></li><li>We confirm receipt within 2 hours during business hours</li><li>Your dashboard is updated and work begins</li></ol><h2>Receipts & Invoices</h2><p>Official receipts are issued within 24 hours of payment confirmation. All invoices are available for download from your client dashboard under the Payments section.</p><div class="note"><p>💡 All amounts are quoted and invoiced in XAF (CFA Franc). For international clients, we provide USD equivalents on request.</p></div>',
            ],
            [
                'id'        => 'pb-3',
                'title'     => 'Refund & Cancellation Policy',
                'excerpt'   => 'When refunds apply, what is non-refundable, and how to cancel a project.',
                'read_time' => 3,
                'featured'  => false,
                'content'   => '<h2>Our Refund Policy</h2><p>We are committed to delivering work you are happy with. Our refund policy is fair and clearly defined from the start.</p><h2>When Refunds Apply</h2><ul><li>If we fail to deliver the agreed scope and cannot resolve it within 14 days, you are entitled to a partial refund proportional to the uncompleted work.</li><li>If work has not yet started, the deposit is fully refundable minus a 5,000 XAF administration fee.</li></ul><h2>What Is Non-Refundable</h2><ul><li>Completed and approved design work</li><li>Completed and approved development milestones</li><li>Domain registration and hosting fees (paid to third parties)</li></ul><h2>How to Cancel</h2><p>To cancel a project, send a written notice via email. Cancellations mid-project are subject to a pro-rata charge for all work completed to date. We will issue a final invoice for completed work and close your project file.</p>',
            ],
        ],
    ],
    [
        'id'          => 'tutorials',
        'title'       => 'Tutorials',
        'description' => 'Step-by-step guides for using your website, CMS, and the client dashboard.',
        'icon_path'   => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25',
        'color'       => 'bg-orange-50 text-orange-500 border-orange-100',
        'articles'    => [
            [
                'id'        => 'tut-1',
                'title'     => 'How to Update Your Website Content',
                'excerpt'   => 'A step-by-step guide to editing pages, uploading images, and publishing changes via the CMS.',
                'read_time' => 5,
                'featured'  => true,
                'content'   => '<h2>Accessing Your CMS</h2><p>Your content management system (CMS) is accessible at <code>yourdomain.com/admin</code>. Use the admin credentials provided in your launch handover document.</p><h2>Editing a Page</h2><ol><li>Log in to the admin panel</li><li>Click <strong>Pages</strong> in the left sidebar</li><li>Select the page you want to edit</li><li>Make your changes in the editor</li><li>Click <strong>Save Draft</strong> to preview, or <strong>Publish</strong> to go live immediately</li></ol><div class="note"><p>💡 Always use "Save Draft" first to preview changes before publishing, especially for homepage edits.</p></div><h2>Uploading Images</h2><p>For the best performance, optimise images before uploading:</p><ul><li>Use JPG for photos, PNG for logos and icons</li><li>Keep files under 500KB where possible</li><li>Recommended maximum width: 1920px</li></ul><p>Upload via the <strong>Media Library</strong> in the sidebar, then insert into any page or post.</p><h2>Adding a Blog Post</h2><ol><li>Go to <strong>Blog → New Post</strong></li><li>Add a title, body, and featured image</li><li>Select a category</li><li>Click <strong>Publish</strong></li></ol>',
            ],
            [
                'id'        => 'tut-2',
                'title'     => 'Setting Up Your Business Email',
                'excerpt'   => 'Configure your custom domain email (e.g. you@yourbusiness.com) on Gmail, Outlook, or mobile.',
                'read_time' => 6,
                'featured'  => false,
                'content'   => '<h2>Your Business Email</h2><p>All plans include business email setup. Your email address will follow the format <code>name@yourdomain.com</code> (e.g. <code>hello@acmecorp.com</code>).</p><h2>Using Gmail (Recommended)</h2><p>You can send and receive your business email through Gmail for free using SMTP/IMAP:</p><ol><li>Go to Gmail → Settings → Accounts and Import</li><li>Under "Send mail as", click "Add another email address"</li><li>Enter your business email address</li><li>Enter the SMTP settings from your handover document</li><li>Verify ownership via the confirmation email</li></ol><h2>Using Outlook</h2><ol><li>Open Outlook → File → Add Account</li><li>Enter your full business email address</li><li>Select IMAP when prompted</li><li>Enter the incoming and outgoing server settings from your handover document</li><li>Click Done</li></ol><h2>On Mobile</h2><p>iOS and Android both support IMAP email natively. Go to Settings → Mail → Add Account → Other, then enter your credentials from the handover document.</p><div class="warn"><p>⚠️ Keep your email password secure. If you suspect it has been compromised, contact us immediately and we will reset it within 1 hour.</p></div>',
            ],
            [
                'id'        => 'tut-3',
                'title'     => 'How to Read Your Analytics Dashboard',
                'excerpt'   => 'Understanding visitors, sessions, bounce rate, and top pages in Google Analytics.',
                'read_time' => 4,
                'featured'  => false,
                'content'   => '<h2>Accessing Google Analytics</h2><p>Your website comes with Google Analytics 4 (GA4) pre-installed. Access your dashboard at <a href="https://analytics.google.com">analytics.google.com</a> using the Google account linked during setup.</p><h2>Key Metrics to Track</h2><ul><li><strong>Users</strong> — unique visitors to your site</li><li><strong>Sessions</strong> — total visits (one user can have multiple sessions)</li><li><strong>Engagement Rate</strong> — percentage of sessions where users interacted meaningfully</li><li><strong>Average Session Duration</strong> — how long users stay on average</li></ul><h2>Understanding Top Pages</h2><p>Go to <strong>Reports → Engagement → Pages and screens</strong>. This shows which pages get the most traffic. Use this to understand what content your visitors find most valuable.</p><h2>Traffic Sources</h2><p>Under <strong>Reports → Acquisition → Traffic acquisition</strong>, you can see whether visitors come from Google search, social media, direct URL entry, or referral links. This helps you understand where to invest your marketing efforts.</p><div class="note"><p>💡 Check analytics at least once a month and compare month-over-month to spot trends early.</p></div>',
            ],
        ],
    ],
    [
        'id'          => 'faqs',
        'title'       => 'FAQs',
        'description' => 'Quick answers to the most common questions clients ask us.',
        'icon_path'   => 'M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z',
        'color'       => 'bg-teal-50 text-teal-600 border-teal-100',
        'articles'    => [
            [
                'id'        => 'faq-1',
                'title'     => 'Do you work with clients outside Cameroon?',
                'excerpt'   => 'Yes. We work with clients across Africa and internationally. Here is how remote collaboration works.',
                'read_time' => 2,
                'featured'  => false,
                'content'   => '<h2>Working Remotely</h2><p>Absolutely — approximately 40% of our clients are outside Cameroon. We work with clients across Africa, Europe, and beyond via:</p><ul><li>Video calls (Google Meet, Zoom, WhatsApp)</li><li>Shared project dashboard for all communications</li><li>Email and WhatsApp for quick questions</li></ul><h2>Time Zone Considerations</h2><p>We are based in Central Africa Time (WAT, UTC+1). We accommodate calls with clients in up to UTC+5 and UTC-5 without difficulty. For further time zones, we arrange calls at mutually convenient times.</p><h2>Payments for International Clients</h2><p>International clients typically pay via bank transfer (SWIFT). We provide USD and EUR invoices on request. Contact us to discuss the best option for your country.</p>',
            ],
            [
                'id'        => 'faq-2',
                'title'     => 'What technology stack do you use?',
                'excerpt'   => 'Our core stack: Laravel, Tailwind CSS, Alpine.js, and managed cloud hosting.',
                'read_time' => 3,
                'featured'  => false,
                'content'   => '<h2>Our Core Stack</h2><p>We choose technology based on what is best for your project — not what is trendy. Our primary stack for most web projects:</p><ul><li><strong>Backend:</strong> Laravel (PHP) — reliable, scalable, well-documented</li><li><strong>Frontend:</strong> Tailwind CSS + Alpine.js — fast, modern, minimal JavaScript overhead</li><li><strong>Database:</strong> MySQL or PostgreSQL</li><li><strong>Hosting:</strong> DigitalOcean, AWS, or RhostitCloud</li></ul><h2>For Mobile Apps</h2><ul><li>React Native (iOS + Android from one codebase)</li><li>Flutter (for performance-critical apps)</li></ul><h2>Why Laravel?</h2><p>Laravel gives us a clean MVC structure, excellent ORM, built-in security features, and a mature ecosystem. It lets us ship fast without sacrificing quality — exactly what client projects need.</p>',
            ],
            [
                'id'        => 'faq-3',
                'title'     => 'Can I see examples of your past work?',
                'excerpt'   => 'Yes — browse our project portfolio on the Work page.',
                'read_time' => 1,
                'featured'  => false,
                'content'   => '<h2>Our Portfolio</h2><p>You can browse a curated selection of completed projects on our <a href="/projects">Work page</a>. Each project entry includes:</p><ul><li>A description of the challenge and solution</li><li>The technology stack used</li><li>Screenshots or live links (where permitted by clients)</li></ul><h2>Case Studies</h2><p>Detailed case studies for select projects are published on our <a href="/blog">Blog</a>. These go deeper into the architecture decisions, challenges, and outcomes.</p><h2>References</h2><p>We are happy to provide client references on request during the proposal phase. Contact us and we will arrange an introduction with a past client in a similar industry to yours.</p>',
            ],
            [
                'id'        => 'faq-4',
                'title'     => 'How do I request a feature after launch?',
                'excerpt'   => 'Use the dashboard or email us. New features are quoted separately and handled as a new mini-project.',
                'read_time' => 2,
                'featured'  => false,
                'content'   => '<h2>Post-Launch Feature Requests</h2><p>New features requested after project launch are handled as separate change orders. This keeps your original project clean and ensures new work is properly scoped and priced.</p><h2>How to Submit a Request</h2><ol><li>Log in to your client dashboard</li><li>Go to <strong>Messages</strong> and describe the feature you need</li><li>We respond with a quote and estimated timeline within 24 hours</li></ol><h2>What to Include in Your Request</h2><ul><li>What you want the feature to do</li><li>Who will use it (you, your customers, your staff?)</li><li>Any reference examples you have seen elsewhere</li><li>Your desired deadline (if any)</li></ul><div class="note"><p>💡 The more detail you provide upfront, the faster and more accurately we can quote.</p></div>',
            ],
        ],
    ],
];

// Flatten all articles for search
$allArticles = collect($kbData)->flatMap(fn($cat) =>
    collect($cat['articles'])->map(fn($art) => array_merge($art, ['category_id' => $cat['id'], 'category_title' => $cat['title']]))
)->toArray();
@endphp

{{-- ═══════════════════════════════════════════════════════════════ --}}
{{--  ALPINE.JS ROOT — wraps entire KB with shared state           --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
<div x-data="{
    /* ── State ─────────────────────────────────── */
    view: 'home',           /* home | category | article */
    activeCategory: null,
    activeArticle: null,
    search: '',
    sidebarOpen: false,

    /* ── Raw data (replace with fetch() call later) ─ */
    categories: {{ Js::from($kbData) }},
    allArticles: {{ Js::from($allArticles) }},

    /* ── Computed ───────────────────────────────── */
    get filteredArticles() {
        if (!this.search.trim()) return this.activeCategory?.articles ?? [];
        const q = this.search.toLowerCase();
        return (this.activeCategory?.articles ?? this.allArticles).filter(a =>
            a.title.toLowerCase().includes(q) || a.excerpt.toLowerCase().includes(q)
        );
    },
    get searchResults() {
        if (!this.search.trim()) return [];
        const q = this.search.toLowerCase();
        return this.allArticles.filter(a =>
            a.title.toLowerCase().includes(q) || a.excerpt.toLowerCase().includes(q)
        );
    },
    get featuredArticles() {
        return this.allArticles.filter(a => a.featured).slice(0, 3);
    },

    /* ── Actions ────────────────────────────────── */
    goHome()          { this.view='home'; this.activeCategory=null; this.activeArticle=null; this.search=''; this.sidebarOpen=false; },
    openCategory(cat) { this.view='category'; this.activeCategory=cat; this.activeArticle=null; this.search=''; this.sidebarOpen=false; },
    openArticle(art)  {
        const cat = this.categories.find(c => c.id === art.category_id) ?? this.activeCategory;
        this.activeCategory = cat;
        this.activeArticle = art;
        this.view = 'article';
        this.sidebarOpen = false;
        this.$nextTick(() => window.scrollTo({top: 0, behavior:'smooth'}));
    },
    openArticleFromCategory(art) {
        const full = this.activeCategory?.articles?.find(a => a.id === art.id) ?? art;
        this.activeArticle = full;
        this.view = 'article';
        this.$nextTick(() => window.scrollTo({top:0, behavior:'smooth'}));
    },
}">

{{-- ═══════════════════════════════════════════════════════════════ --}}
{{--  1. HERO                                                        --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
<section class="relative overflow-hidden bg-white dot-grid pt-32 pb-16">
    <div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
        <div class="absolute -top-24 -left-24 w-[500px] h-[500px] rounded-full"
             style="background:radial-gradient(circle,rgba(59,130,246,.11) 0%,transparent 68%);"></div>
        <div class="absolute top-0 right-0 w-[360px] h-[360px] rounded-full"
             style="background:radial-gradient(circle,rgba(16,185,129,.08) 0%,transparent 70%);"></div>
    </div>

    <div class="relative max-w-3xl mx-auto px-6 text-center">
        <div class="h-title inline-flex items-center gap-2 bg-blue-50 border border-blue-100 text-blue-700 text-xs font-semibold px-4 py-1.5 rounded-full mb-5">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
            </svg>
            Knowledge Base
        </div>

        <h1 class="h-title text-[38px] sm:text-5xl font-extrabold text-gray-900 leading-tight tracking-tight mb-4">
            Knowledge Base
        </h1>
        <p class="h-sub text-lg text-gray-600 leading-relaxed mb-8">
            Guides, tutorials, and resources to help you get started
        </p>

        {{-- Search bar --}}
        <div class="h-srch relative max-w-xl mx-auto">
            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none"
                 fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
            </svg>
            <input type="text"
                   x-model="search"
                   @input="if(search.trim()) view='search'"
                   @keydown.escape="search=''; view='home'"
                   placeholder="Search articles, guides, tutorials…"
                   class="w-full pl-12 pr-5 py-4 text-sm border border-gray-200 rounded-2xl bg-white shadow-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:border-blue-400 focus:ring-4 focus:ring-blue-50 transition">
            <template x-if="search.trim()">
                <button @click="search=''; view='home'"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </template>
        </div>

        {{-- Search results dropdown --}}
        <template x-if="search.trim() && searchResults.length">
            <div class="absolute left-1/2 -translate-x-1/2 w-full max-w-xl mt-1 bg-white border border-gray-200 rounded-2xl shadow-xl z-50 overflow-hidden text-left">
                <div class="p-2">
                    <template x-for="res in searchResults.slice(0,6)" :key="res.id">
                        <div @click="openArticle(res)"
                             class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-gray-50 cursor-pointer group">
                            <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V19.5a2.25 2.25 0 002.25 2.25h.75"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-900 truncate" x-text="res.title"></p>
                                <p class="text-xs text-gray-400 truncate" x-text="res.category_title + ' · ' + res.read_time + ' min read'"></p>
                            </div>
                            <svg class="w-4 h-4 text-gray-300 group-hover:text-blue-500 ml-auto shrink-0 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </div>
                    </template>
                </div>
                <template x-if="searchResults.length > 6">
                    <div class="border-t border-gray-100 px-4 py-2.5 text-xs text-gray-400 text-center">
                        + <span x-text="searchResults.length - 6"></span> more results
                    </div>
                </template>
            </div>
        </template>

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════ --}}
{{--  2. MAIN KB LAYOUT                                             --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 pb-24 pt-8">
    <div class="flex gap-8 relative">

        {{-- ── SIDEBAR ──────────────────────────────────────────── --}}

        {{-- Mobile sidebar toggle --}}
        <div class="lg:hidden mb-4 w-full">
            <button @click="sidebarOpen = !sidebarOpen"
                    class="flex items-center gap-2 text-sm font-semibold text-gray-700 bg-white border border-gray-200 px-4 py-2.5 rounded-xl shadow-sm w-full">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12"/>
                </svg>
                <span x-text="sidebarOpen ? 'Hide navigation' : 'Browse categories'"></span>
                <svg class="w-4 h-4 ml-auto transition-transform" :class="sidebarOpen ? 'rotate-180' : ''"
                     fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
        </div>

        <aside class="w-64 shrink-0 hidden lg:block" :class="sidebarOpen ? '!block w-full' : ''">
            <div class="sticky top-24 space-y-1">

                {{-- Home link --}}
                <button @click="goHome()"
                        :class="view==='home' ? 'nav-link active' : 'nav-link'"
                        class="w-full text-left">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                    </svg>
                    Home
                </button>

                <div class="pt-2 pb-1">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest px-3 mb-1">Categories</p>
                </div>

                {{-- Category links --}}
                <template x-for="cat in categories" :key="cat.id">
                    <div>
                        <button @click="openCategory(cat)"
                                :class="activeCategory?.id === cat.id ? 'nav-link active' : 'nav-link'"
                                class="w-full text-left">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" :d="cat.icon_path"/>
                            </svg>
                            <span x-text="cat.title" class="flex-1 truncate"></span>
                            <span class="text-[10px] font-semibold bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded-full ml-auto"
                                  x-text="cat.articles.length"></span>
                        </button>

                        {{-- Article sub-links (visible when category is active) --}}
                        <template x-if="activeCategory?.id === cat.id">
                            <div class="mt-0.5 space-y-0.5">
                                <template x-for="art in cat.articles" :key="art.id">
                                    <button @click="openArticleFromCategory(art)"
                                            :class="activeArticle?.id === art.id ? 'nav-article text-blue-600 font-semibold bg-blue-50' : 'nav-article'"
                                            class="w-full text-left truncate">
                                        <svg class="w-3 h-3 shrink-0 text-gray-300" fill="currentColor" viewBox="0 0 6 6">
                                            <circle cx="3" cy="3" r="3"/>
                                        </svg>
                                        <span x-text="art.title" class="truncate"></span>
                                    </button>
                                </template>
                            </div>
                        </template>
                    </div>
                </template>

                {{-- Divider --}}
                <div class="pt-4 border-t border-gray-100 mt-4">
                    <a href="/contact" class="nav-link w-full text-left text-green-700 bg-green-50 border border-green-100 hover:bg-green-100">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/>
                        </svg>
                        Contact Support
                    </a>
                </div>

            </div>
        </aside>

        {{-- ── CONTENT AREA ─────────────────────────────────────── --}}
        <main class="flex-1 min-w-0">

            {{-- ╔══════════════════════════════╗ --}}
            {{-- ║  HOME VIEW                   ║ --}}
            {{-- ╚══════════════════════════════╝ --}}
            <div x-show="view === 'home'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">

                {{-- Featured articles --}}
                <div class="mb-12">
                    <h2 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-5">Featured Articles</h2>
                    <div class="space-y-3">
                        <template x-for="art in featuredArticles" :key="art.id">
                            <div @click="openArticle(art)"
                                 class="art-item flex items-center gap-4 p-4 group">
                                <div class="w-10 h-10 bg-blue-50 border border-blue-100 rounded-xl flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V19.5a2.25 2.25 0 002.25 2.25h.75"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-gray-900 text-sm leading-snug mb-0.5" x-text="art.title"></p>
                                    <p class="text-xs text-gray-400 truncate" x-text="art.category_title + ' · ' + art.read_time + ' min read'"></p>
                                </div>
                                <svg class="w-4 h-4 text-gray-300 group-hover:text-blue-500 shrink-0 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Category grid --}}
                <div>
                    <h2 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-5">Browse by Category</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <template x-for="cat in categories" :key="cat.id">
                            <div @click="openCategory(cat)" class="cat-card p-5 group">
                                <div class="flex items-start gap-4">
                                    <div :class="cat.color" class="w-11 h-11 rounded-xl border flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" :d="cat.icon_path"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-1">
                                            <h3 class="font-bold text-gray-900 text-sm" x-text="cat.title"></h3>
                                            <span class="text-[10px] font-semibold bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full"
                                                  x-text="cat.articles.length + ' articles'"></span>
                                        </div>
                                        <p class="text-xs text-gray-500 leading-relaxed" x-text="cat.description"></p>
                                    </div>
                                    <svg class="w-4 h-4 text-gray-300 group-hover:text-blue-500 shrink-0 mt-0.5 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            {{-- ╔══════════════════════════════╗ --}}
            {{-- ║  CATEGORY VIEW               ║ --}}
            {{-- ╚══════════════════════════════╝ --}}
            <div x-show="view === 'category'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">

                {{-- Breadcrumb --}}
                <div class="flex items-center gap-2 text-xs text-gray-400 mb-7">
                    <button @click="goHome()" class="hover:text-blue-600 transition font-medium">Home</button>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-gray-700 font-semibold" x-text="activeCategory?.title"></span>
                </div>

                {{-- Category header --}}
                <div class="flex items-center gap-4 mb-8 pb-6 border-b border-gray-100">
                    <div :class="activeCategory?.color" class="w-12 h-12 rounded-2xl border flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" :d="activeCategory?.icon_path"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-extrabold text-gray-900" x-text="activeCategory?.title"></h2>
                        <p class="text-sm text-gray-500 mt-0.5" x-text="activeCategory?.description"></p>
                    </div>
                </div>

                {{-- Search within category --}}
                <div class="relative mb-6">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"
                         fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                    </svg>
                    <input type="text" x-model="search"
                           :placeholder="'Search in ' + (activeCategory?.title ?? '') + '…'"
                           class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 text-gray-900 placeholder-gray-400 focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50 transition">
                </div>

                {{-- Article list --}}
                <div class="space-y-3">
                    <template x-if="filteredArticles.length === 0">
                        <div class="text-center py-12">
                            <p class="text-gray-400 text-sm">No articles found.</p>
                            <button @click="search=''" class="mt-2 text-blue-600 text-xs font-semibold hover:underline">Clear search</button>
                        </div>
                    </template>

                    <template x-for="art in filteredArticles" :key="art.id">
                        <div @click="openArticleFromCategory(art)"
                             class="art-item flex items-center gap-4 p-5 group">
                            <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V19.5a2.25 2.25 0 002.25 2.25h.75"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-gray-900 text-sm mb-0.5" x-text="art.title"></p>
                                <p class="text-xs text-gray-500 leading-relaxed line-clamp-1" x-text="art.excerpt"></p>
                                <p class="text-[11px] text-gray-400 mt-1 font-medium" x-text="art.read_time + ' min read'"></p>
                            </div>
                            <svg class="w-4 h-4 text-gray-300 group-hover:text-blue-500 shrink-0 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </div>
                    </template>
                </div>
            </div>

            {{-- ╔══════════════════════════════╗ --}}
            {{-- ║  ARTICLE VIEW                ║ --}}
            {{-- ╚══════════════════════════════╝ --}}
            <div x-show="view === 'article'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">

                <div class="flex gap-10">

                    {{-- Article main content --}}
                    <div class="flex-1 min-w-0">

                        {{-- Breadcrumb --}}
                        <div class="flex items-center gap-1.5 text-xs text-gray-400 mb-7 flex-wrap">
                            <button @click="goHome()" class="hover:text-blue-600 transition font-medium">Home</button>
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            <button @click="view='category'; activeArticle=null" class="hover:text-blue-600 transition font-medium" x-text="activeCategory?.title"></button>
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            <span class="text-gray-700 font-semibold truncate max-w-[200px]" x-text="activeArticle?.title"></span>
                        </div>

                        {{-- Article header --}}
                        <div class="mb-8 pb-7 border-b border-gray-100">
                            <div class="flex items-center gap-2 mb-4">
                                <span :class="activeCategory?.color" class="text-[10px] font-bold px-2.5 py-1 rounded-full border uppercase tracking-wide" x-text="activeCategory?.title"></span>
                                <span class="text-xs text-gray-400 font-medium" x-text="activeArticle?.read_time + ' min read'"></span>
                            </div>
                            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 leading-tight mb-3" x-text="activeArticle?.title"></h1>
                            <p class="text-sm text-gray-500 leading-relaxed" x-text="activeArticle?.excerpt"></p>
                        </div>

                        {{-- Article body --}}
                        <div class="prose-kb" x-html="activeArticle?.content"></div>

                        {{-- Article footer --}}
                        <div class="mt-12 pt-8 border-t border-gray-100">
                            <p class="text-sm text-gray-500 mb-4">Was this article helpful?</p>
                            <div class="flex items-center gap-3">
                                <button class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 bg-gray-50 hover:bg-green-50 hover:text-green-700 border border-gray-200 hover:border-green-200 px-4 py-2 rounded-xl transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z"/>
                                    </svg>
                                    Yes, helpful
                                </button>
                                <button class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 bg-gray-50 hover:bg-red-50 hover:text-red-600 border border-gray-200 hover:border-red-200 px-4 py-2 rounded-xl transition">
                                    <svg class="w-4 h-4 rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z"/>
                                    </svg>
                                    Not quite
                                </button>
                                <a href="/contact" class="ml-auto text-xs text-blue-600 font-semibold hover:underline">
                                    Still need help? →
                                </a>
                            </div>
                        </div>

                    </div>

                    {{-- TOC sidebar (desktop only) --}}
                    <div class="hidden xl:block w-48 shrink-0">
                        <div class="sticky top-24">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">On this page</p>
                            <template x-for="cat in (activeCategory ? [activeCategory] : [])" :key="cat.id">
                                <nav class="space-y-1">
                                    <template x-for="art in cat.articles" :key="art.id">
                                        <button @click="openArticleFromCategory(art)"
                                                :class="activeArticle?.id === art.id ? 'text-blue-600 font-semibold' : 'text-gray-400 hover:text-gray-700'"
                                                class="block text-left text-xs leading-snug py-1 transition w-full"
                                                x-text="art.title">
                                        </button>
                                    </template>
                                </nav>
                            </template>
                        </div>
                    </div>

                </div>
            </div>

        </main>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════ --}}
{{--  3. CTA                                                        --}}
{{-- ═══════════════════════════════════════════════════════════════ --}}
<section class="py-20 bg-gray-900">
    <div class="max-w-3xl mx-auto px-6 text-center">

        <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 text-white text-xs font-semibold px-4 py-1.5 rounded-full mb-6">
            <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/>
            </svg>
            Support Team
        </div>

        <h2 class="text-[30px] sm:text-4xl font-extrabold text-white leading-tight mb-4">
            Still Need Help?
        </h2>
        <p class="text-gray-400 text-base leading-relaxed max-w-md mx-auto mb-9">
            Can't find what you're looking for? Our team is available to help — reach out and we'll respond fast.
        </p>

        <div class="flex flex-wrap items-center justify-center gap-4">
            <a href="/contact"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-500 text-white font-semibold text-sm px-8 py-3.5 rounded-2xl shadow-lg shadow-blue-900/40 transition-all duration-200 hover:-translate-y-0.5">
                Contact Support
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
            <a href="/contact?ref=project"
               class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white font-semibold text-sm px-8 py-3.5 rounded-2xl transition-all duration-200 hover:-translate-y-0.5">
                Start a Project
            </a>
        </div>

    </div>
</section>

</div>{{-- end Alpine root --}}

<script>
(function () {
    const io = new IntersectionObserver((entries) => {
        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); io.unobserve(e.target); } });
    }, { threshold: 0.08 });
    document.querySelectorAll('.reveal').forEach(el => io.observe(el));
})();
</script>

</x-layouts.public>
