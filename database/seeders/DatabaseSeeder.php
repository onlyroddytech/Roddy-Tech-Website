<?php

namespace Database\Seeders;

use App\Enums\PaymentStatus;
use App\Enums\ProjectStatus;
use App\Enums\UserRole;
use App\Models\CmsSection;
use App\Models\Faq;
use App\Models\Message;
use App\Models\Payment;
use App\Models\PricingItem;
use App\Models\Project;
use App\Models\ProjectUpdate;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Users ──────────────────────────────────────────────
        $admin = User::create([
            'name'              => 'Roddy Admin',
            'email'             => 'admin@roddy.com',
            'password'          => Hash::make('password'),
            'role'              => UserRole::Admin,
            'referral_code'     => Str::upper(Str::random(8)),
            'is_active'         => true,
            'email_verified_at' => now(),
        ]);

        $client = User::create([
            'name'              => 'John Client',
            'email'             => 'client@roddy.com',
            'password'          => Hash::make('password'),
            'role'              => UserRole::Client,
            'referral_code'     => Str::upper(Str::random(8)),
            'is_active'         => true,
            'email_verified_at' => now(),
        ]);

        // ── Projects ───────────────────────────────────────────
        $project1 = Project::create([
            'user_id'     => $client->id,
            'created_by'  => $admin->id,
            'title'       => 'E-Commerce Website',
            'description' => 'Full-stack online store with product catalog, cart, and checkout.',
            'status'      => ProjectStatus::Ongoing,
            'progress'    => 65,
            'start_date'  => now()->subDays(20),
            'deadline'    => now()->addDays(30),
        ]);

        $project2 = Project::create([
            'user_id'     => $client->id,
            'created_by'  => $admin->id,
            'title'       => 'Mobile App MVP',
            'description' => 'iOS and Android fitness tracking app with social features.',
            'status'      => ProjectStatus::Completed,
            'progress'    => 100,
            'start_date'  => now()->subDays(60),
            'deadline'    => now()->subDays(5),
        ]);

        $project3 = Project::create([
            'user_id'    => $client->id,
            'created_by' => $admin->id,
            'title'      => 'Brand Identity Package',
            'description'=> 'Logo, color palette, typography, and full brand guidelines.',
            'status'     => ProjectStatus::Pending,
            'progress'   => 0,
            'deadline'   => now()->addDays(60),
        ]);

        $project4 = Project::create([
            'user_id'     => $client->id,
            'created_by'  => $admin->id,
            'title'       => 'SaaS Dashboard Platform',
            'description' => 'Multi-tenant SaaS platform with subscription billing, analytics, and team management.',
            'status'      => ProjectStatus::Ongoing,
            'progress'    => 40,
            'start_date'  => now()->subDays(10),
            'deadline'    => now()->addDays(50),
        ]);

        $project5 = Project::create([
            'user_id'     => $client->id,
            'created_by'  => $admin->id,
            'title'       => 'Corporate Website Redesign',
            'description' => 'Complete redesign of a corporate website with modern UI, CMS integration, and SEO optimisation.',
            'status'      => ProjectStatus::Completed,
            'progress'    => 100,
            'start_date'  => now()->subDays(90),
            'deadline'    => now()->subDays(15),
        ]);

        $project6 = Project::create([
            'user_id'     => $client->id,
            'created_by'  => $admin->id,
            'title'       => 'RTG Domains Landing Page',
            'description' => 'High-converting landing page for RTG Domains platform with live search and instant activation flow.',
            'status'      => ProjectStatus::Completed,
            'progress'    => 100,
            'start_date'  => now()->subDays(45),
            'deadline'    => now()->subDays(2),
        ]);

        // ── Project Updates ────────────────────────────────────
        ProjectUpdate::create(['project_id' => $project1->id, 'created_by' => $admin->id, 'progress' => 30, 'message' => 'Design approved by client. Development has started.']);
        ProjectUpdate::create(['project_id' => $project1->id, 'created_by' => $admin->id, 'progress' => 65, 'message' => 'Frontend complete. Integrating backend APIs now.']);
        ProjectUpdate::create(['project_id' => $project2->id, 'created_by' => $admin->id, 'progress' => 100, 'message' => 'Project completed and delivered. App live on stores.']);
        ProjectUpdate::create(['project_id' => $project4->id, 'created_by' => $admin->id, 'progress' => 20, 'message' => 'Wireframes signed off. Backend architecture setup in progress.']);
        ProjectUpdate::create(['project_id' => $project4->id, 'created_by' => $admin->id, 'progress' => 40, 'message' => 'Authentication and billing module complete. Moving to dashboard UI.']);
        ProjectUpdate::create(['project_id' => $project5->id, 'created_by' => $admin->id, 'progress' => 100, 'message' => 'Site launched successfully. Client signed off on all deliverables.']);
        ProjectUpdate::create(['project_id' => $project6->id, 'created_by' => $admin->id, 'progress' => 100, 'message' => 'Landing page live. Conversion tracking and analytics configured.']);

        // ── Payments ───────────────────────────────────────────
        Payment::create(['project_id' => $project1->id, 'amount' => 425000, 'status' => PaymentStatus::Partial, 'note' => '50% upfront paid on project start.']);
        Payment::create(['project_id' => $project2->id, 'amount' => 1200000, 'status' => PaymentStatus::Paid, 'note' => 'Full payment received on delivery.']);
        Payment::create(['project_id' => $project3->id, 'amount' => 250000, 'status' => PaymentStatus::Unpaid, 'note' => 'Awaiting deposit before work begins.']);

        // ── Messages ───────────────────────────────────────────
        Message::create(['project_id' => $project1->id, 'sender_id' => $admin->id, 'message' => 'Hi John! Frontend is complete. Moving to backend integration now.']);
        Message::create(['project_id' => $project1->id, 'sender_id' => $client->id, 'message' => 'Great progress! How many more days until completion?']);
        Message::create(['project_id' => $project1->id, 'sender_id' => $admin->id, 'message' => 'About 2-3 weeks. We are on track.']);

        // ── Services ───────────────────────────────────────────
        foreach ([
            ['title' => 'Web Development',    'icon' => '💻', 'description' => 'Custom websites and web applications built with modern frameworks.', 'sort_order' => 1],
            ['title' => 'Mobile Apps',         'icon' => '📱', 'description' => 'Native and cross-platform mobile apps for iOS and Android.', 'sort_order' => 2],
            ['title' => 'UI/UX Design',        'icon' => '🎨', 'description' => 'Beautiful, user-centered interfaces that convert and delight.', 'sort_order' => 3],
            ['title' => 'Brand Identity',      'icon' => '✏️', 'description' => 'Logo, visual identity, and brand guidelines that stand out.', 'sort_order' => 4],
            ['title' => 'API Development',     'icon' => '🔗', 'description' => 'Robust RESTful APIs and microservices for your platform.', 'sort_order' => 5],
            ['title' => 'Digital Consulting',  'icon' => '💡', 'description' => 'Strategy, roadmaps, and technical consulting for your business.', 'sort_order' => 6],
        ] as $s) {
            Service::create(array_merge($s, ['is_active' => true]));
        }

        // ── Team Members ───────────────────────────────────────
        foreach ([
            ['name' => 'Roddy T.',   'role' => 'CEO & Founder',     'bio' => 'Visionary leader and full-stack engineer with 8+ years of experience.', 'sort_order' => 1],
            ['name' => 'Alice M.',   'role' => 'Lead Designer',      'bio' => 'UI/UX specialist passionate about clean, functional design.', 'sort_order' => 2],
            ['name' => 'Eric N.',    'role' => 'Backend Engineer',   'bio' => 'Laravel and Node.js expert building scalable backend systems.', 'sort_order' => 3],
        ] as $m) {
            TeamMember::create(array_merge($m, ['is_active' => true]));
        }

        // ── Testimonials ───────────────────────────────────────
        foreach ([
            ['name' => 'Marie K.',  'position' => 'CEO, Akwa Ventures',     'content' => 'Roddy Technologies built our platform in record time. Outstanding quality and communication.', 'rating' => 5],
            ['name' => 'Paul A.',   'position' => 'Founder, ShopCM',        'content' => 'Professional team, clean code, and they truly understood our vision. Highly recommended!', 'rating' => 5],
            ['name' => 'Linda O.',  'position' => 'Marketing Director',     'content' => 'The redesign transformed our brand completely. Our conversions doubled in 3 months.', 'rating' => 5],
        ] as $t) {
            Testimonial::create(array_merge($t, ['is_active' => true]));
        }

        // ── Pricing ────────────────────────────────────────────
        foreach ([
            ['title' => 'Starter Website',  'price' => 150000,  'currency' => 'XAF', 'unit' => 'per project', 'description' => 'Landing page or small business website.',          'is_featured' => false, 'sort_order' => 1],
            ['title' => 'Business Website', 'price' => 500000,  'currency' => 'XAF', 'unit' => 'per project', 'description' => 'Full website with CMS, blog, and contact forms.',   'is_featured' => true,  'sort_order' => 2],
            ['title' => 'Mobile App',       'price' => 1200000, 'currency' => 'XAF', 'unit' => 'per project', 'description' => 'iOS + Android app with backend API.',               'is_featured' => false, 'sort_order' => 3],
        ] as $p) {
            PricingItem::create(array_merge($p, ['is_active' => true]));
        }

        // ── FAQs ───────────────────────────────────────────────
        foreach ([
            ['question' => 'How long does a typical project take?',     'answer' => 'It depends on scope. A landing page takes 1–2 weeks. A full web app typically takes 4–12 weeks.',    'category' => 'general'],
            ['question' => 'Do you offer post-launch support?',         'answer' => 'Yes! We offer maintenance packages to keep your product running smoothly after launch.',               'category' => 'general'],
            ['question' => 'What payment methods do you accept?',       'answer' => 'We accept MTN MoMo, Orange Money, and bank transfers. 50% upfront, 50% on delivery.',                  'category' => 'billing'],
            ['question' => 'Can I see the project progress?',           'answer' => 'Yes, every client gets a dashboard where they can track progress and communicate with the team.',       'category' => 'general'],
        ] as $idx => $f) {
            Faq::create(array_merge($f, ['sort_order' => $idx + 1, 'is_active' => true]));
        }

        // ── CMS Sections ───────────────────────────────────────
        $cms = [
            ['key' => 'hero_title',      'label' => 'Hero Title',       'value' => 'We Build Software That Matters',          'type' => 'text',     'group' => 'hero'],
            ['key' => 'hero_subtitle',   'label' => 'Hero Subtitle',    'value' => 'Roddy Technologies delivers premium web applications, mobile apps, and digital solutions for businesses across Africa and beyond.', 'type' => 'textarea', 'group' => 'hero'],
            ['key' => 'about_story',     'label' => 'Company Story',    'value' => 'Roddy Technologies was founded with a clear mission: to make world-class software accessible to African businesses.', 'type' => 'textarea', 'group' => 'about'],
            ['key' => 'about_vision',    'label' => 'Vision',           'value' => 'To be the leading technology partner for businesses in Africa.',        'type' => 'textarea', 'group' => 'about'],
            ['key' => 'about_mission',   'label' => 'Mission',          'value' => 'Delivering innovative, reliable, and scalable digital solutions.',      'type' => 'textarea', 'group' => 'about'],
            ['key' => 'contact_email',   'label' => 'Contact Email',    'value' => 'hello@roddytechnologies.com',              'type' => 'text',     'group' => 'contact'],
            ['key' => 'contact_phone',   'label' => 'Contact Phone',    'value' => '+237 6XX XXX XXX',                        'type' => 'text',     'group' => 'contact'],
            ['key' => 'contact_address', 'label' => 'Address',          'value' => 'Douala, Cameroon',                        'type' => 'text',     'group' => 'contact'],
        ];

        foreach ($cms as $section) {
            CmsSection::create($section);
        }

        // ── Products ───────────────────────────────────────────
        foreach ([
            ['title' => 'Rshop',        'description' => 'A full-featured African eCommerce platform connecting buyers and sellers with fast checkout, product management, and real-time order tracking.', 'url' => '#', 'category' => 'eCommerce', 'sort_order' => 1],
            ['title' => 'RTG Domains',  'description' => 'Domain registration and management platform built for African businesses — fast search, instant activation, and full DNS control.',            'url' => '#', 'category' => 'Domains',   'sort_order' => 2],
            ['title' => 'RhostitCloud', 'description' => 'Managed cloud hosting and server infrastructure for startups and enterprises — one-click deployments, 99.9% uptime, and 24/7 monitoring.',   'url' => '#', 'category' => 'Cloud',     'sort_order' => 3],
        ] as $p) {
            \App\Models\Product::create(array_merge($p, ['is_active' => true]));
        }
    }
}
