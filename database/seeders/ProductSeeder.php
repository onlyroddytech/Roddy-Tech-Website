<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::truncate();

        $products = [
            // ── Flagship / Featured ────────────────────────────────
            [
                'title'       => 'Rshop',
                'description' => 'A full-featured African eCommerce platform connecting buyers and sellers. Includes product catalog, inventory management, cart, and MTN MoMo / Orange Money checkout — built for African market conditions.',
                'url'         => '#',
                'category'    => 'eCommerce',
                'price'       => null,
                'is_featured' => true,
                'sort_order'  => 1,
            ],
            [
                'title'       => 'RTG Domains',
                'description' => 'Domain registration and DNS management platform built specifically for African businesses. Instant search across all major TLDs, one-click activation, and full zone control from a clean, fast dashboard.',
                'url'         => '#',
                'category'    => 'Domains',
                'price'       => null,
                'is_featured' => true,
                'sort_order'  => 2,
            ],
            [
                'title'       => 'RhostitCloud',
                'description' => 'Managed cloud hosting and server infrastructure for startups and growing enterprises. One-click deployments, a 99.9% uptime SLA, auto-scaling, and around-the-clock monitoring and security patching.',
                'url'         => '#',
                'category'    => 'Cloud',
                'price'       => null,
                'is_featured' => true,
                'sort_order'  => 3,
            ],

            // ── Showcase grid ──────────────────────────────────────
            [
                'title'       => 'Client Project Dashboard',
                'description' => 'A white-label client portal where businesses give their clients real-time visibility into project progress, milestones, file sharing, and direct team messaging.',
                'url'         => '#',
                'category'    => 'Websites',
                'price'       => null,
                'is_featured' => false,
                'sort_order'  => 4,
            ],
            [
                'title'       => 'Invoice & Billing System',
                'description' => 'End-to-end invoicing and payment tracking for service businesses. Generate professional PDF invoices, track payment status, send reminders, and reconcile in one place.',
                'url'         => '#',
                'category'    => 'Tools',
                'price'       => null,
                'is_featured' => false,
                'sort_order'  => 5,
            ],
            [
                'title'       => 'African Payment Gateway SDK',
                'description' => 'A unified PHP/Laravel SDK for MTN MoMo, Orange Money, and Campay. Handles initiation, webhook verification, polling, and reconciliation through a single clean API interface.',
                'url'         => '#',
                'category'    => 'Scripts',
                'price'       => null,
                'is_featured' => false,
                'sort_order'  => 6,
            ],
        ];

        foreach ($products as $product) {
            Product::create(array_merge($product, ['is_active' => true]));
        }
    }
}
