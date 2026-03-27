<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class StoreProductSeeder extends Seeder
{
    public function run(): void
    {
        // Store products are identified by having a price set.
        // They sit alongside showcase products in the same table
        // but are displayed only on the /store page.

        $items = [
            [
                'title'       => 'Laravel SaaS Starter Kit',
                'description' => 'Production-ready Laravel 13 boilerplate with multi-tenancy, role-based auth, Stripe-ready billing hooks, admin dashboard, email notifications, and full test suite. Ship your SaaS in days, not months.',
                'url'         => '#',
                'category'    => 'Scripts',
                'price'       => '$149',
                'is_featured' => true,
                'sort_order'  => 10,
            ],
            [
                'title'       => 'Admin UI Component Kit',
                'description' => 'Over 80 clean, responsive UI components built with Tailwind CSS v4 and Alpine.js. Tables, modals, charts, forms, badges, sidebars, dropdowns — ready to drop into any project.',
                'url'         => '#',
                'category'    => 'UI Kits',
                'price'       => '$59',
                'is_featured' => true,
                'sort_order'  => 11,
            ],
            [
                'title'       => 'Multi-Tenant Boilerplate',
                'description' => 'Full multi-tenancy scaffolding for Laravel. Subdomain routing, per-tenant databases, subscription management, onboarding flow, and a superadmin panel — all wired up and ready to extend.',
                'url'         => '#',
                'category'    => 'Scripts',
                'price'       => '$199',
                'is_featured' => true,
                'sort_order'  => 12,
            ],
            [
                'title'       => 'African Payment Integration Bundle',
                'description' => 'Unified PHP/Laravel package for MTN MoMo, Orange Money, and Campay. Handles payment initiation, webhook verification, status polling, and reconciliation through one clean API.',
                'url'         => '#',
                'category'    => 'Scripts',
                'price'       => '$99',
                'is_featured' => false,
                'sort_order'  => 13,
            ],
            [
                'title'       => 'Portfolio Website Template',
                'description' => 'A sleek, animated portfolio template for developers and creative professionals. Dark/light mode, scroll-reveal animations, project showcase grid, and a working contact form.',
                'url'         => '#',
                'category'    => 'Templates',
                'price'       => '$39',
                'is_featured' => false,
                'sort_order'  => 14,
            ],
            [
                'title'       => 'SaaS Landing Page Kit',
                'description' => 'High-converting landing page sections for SaaS products. Hero, features, pricing table, testimonials, FAQ accordion, and CTA — fully responsive and pixel-perfect with Tailwind CSS.',
                'url'         => '#',
                'category'    => 'Templates',
                'price'       => '$29',
                'is_featured' => false,
                'sort_order'  => 15,
            ],
            [
                'title'       => 'Invoice Generator Script',
                'description' => 'Generate, preview, and download professional PDF invoices in seconds. Multi-currency, tax rate support, client profiles, and payment status tracking. Powered by Laravel + DomPDF.',
                'url'         => '#',
                'category'    => 'Tools',
                'price'       => '$49',
                'is_featured' => false,
                'sort_order'  => 16,
            ],
            [
                'title'       => 'E-Commerce Starter Template',
                'description' => 'Clean, conversion-optimised e-commerce template with product grid, filters, cart sidebar, checkout page, and order confirmation. Built with Blade and Alpine.js — no heavy frontend framework.',
                'url'         => '#',
                'category'    => 'Templates',
                'price'       => '$69',
                'is_featured' => false,
                'sort_order'  => 17,
            ],
            [
                'title'       => 'REST API Starter Pack',
                'description' => 'A clean Laravel API scaffold with Sanctum auth, versioned routes, resource transformers, rate limiting, error handling middleware, and Postman collection included.',
                'url'         => '#',
                'category'    => 'Scripts',
                'price'       => '$79',
                'is_featured' => false,
                'sort_order'  => 18,
            ],
            [
                'title'       => 'Minimal Blog Template',
                'description' => 'A fast, readable blog template with category filtering, featured posts, estimated read time, social share, and a newsletter capture section. Clean typography, zero bloat.',
                'url'         => '#',
                'category'    => 'Templates',
                'price'       => '$19',
                'is_featured' => false,
                'sort_order'  => 19,
            ],
            [
                'title'       => 'Dashboard Analytics UI Kit',
                'description' => 'Stat cards, chart wrappers, data tables, KPI grids, and filter panels built for analytics dashboards. Works with Chart.js or ApexCharts. Drop-in ready with Tailwind and Alpine.',
                'url'         => '#',
                'category'    => 'UI Kits',
                'price'       => '$49',
                'is_featured' => false,
                'sort_order'  => 20,
            ],
            [
                'title'       => 'Link-in-Bio Tool',
                'description' => 'A lightweight, self-hosted alternative to Linktree. Custom branding, click tracking, social icons, and a clean mobile-first layout. Built with Laravel and deployable in minutes.',
                'url'         => '#',
                'category'    => 'Tools',
                'price'       => '$29',
                'is_featured' => false,
                'sort_order'  => 21,
            ],
        ];

        foreach ($items as $item) {
            Product::create(array_merge($item, ['is_active' => true]));
        }
    }
}
