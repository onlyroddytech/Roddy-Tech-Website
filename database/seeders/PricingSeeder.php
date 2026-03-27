<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\PricingItem;
use Illuminate\Database\Seeder;

class PricingSeeder extends Seeder
{
    public function run(): void
    {
        // ── Pricing tiers ──────────────────────────────────────────
        PricingItem::truncate();

        PricingItem::insert([
            [
                'title'       => 'Starter',
                'description' => 'Perfect for small businesses that need a clean, professional online presence fast.',
                'price'       => 200000,
                'currency'    => 'XAF',
                'unit'        => 'one-time',
                'features'    => json_encode([
                    'Simple professional website',
                    'Mobile responsive design',
                    'Business email setup',
                    'Contact form integration',
                    'Basic SEO setup',
                    '1 month support',
                ]),
                'is_featured' => false,
                'is_active'   => true,
                'sort_order'  => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'title'       => 'Business',
                'description' => 'The complete package for businesses ready to grow their digital presence and convert visitors.',
                'price'       => 300000,
                'currency'    => 'XAF',
                'unit'        => 'one-time',
                'features'    => json_encode([
                    'Everything in Starter',
                    'Premium UI/UX design',
                    'Live chat integration',
                    'Google Maps integration',
                    'Multi-page website (up to 8)',
                    'Blog or news section',
                    '6 months maintenance',
                ]),
                'is_featured' => true,
                'is_active'   => true,
                'sort_order'  => 2,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'title'       => 'Premium',
                'description' => 'Full-scale custom solutions for businesses that need advanced systems and dedicated support.',
                'price'       => 500000,
                'currency'    => 'XAF',
                'unit'        => 'one-time',
                'features'    => json_encode([
                    'Everything in Business',
                    'Custom features & systems',
                    'Admin dashboard',
                    'Advanced functionality',
                    'Payment integration',
                    'Full project support',
                    'Priority service & SLA',
                ]),
                'is_featured' => false,
                'is_active'   => true,
                'sort_order'  => 3,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);

        // ── Pricing FAQs ───────────────────────────────────────────
        // Remove old pricing FAQs before inserting fresh ones
        Faq::where('category', 'pricing')->delete();

        $faqs = [
            [
                'question'   => 'Can I request custom features not listed in a plan?',
                'answer'     => 'Absolutely. Every project is unique. If you need a feature that isn\'t listed in a plan, we discuss it during the discovery call and give you a transparent quote for the addition. Custom features are always welcome — that\'s what the Premium plan is built for.',
                'category'   => 'pricing',
                'sort_order' => 1,
                'is_active'  => true,
            ],
            [
                'question'   => 'How long does a typical project take to complete?',
                'answer'     => 'A Starter website typically takes 1–2 weeks. A Business plan project takes 2–4 weeks depending on content readiness. Premium and custom projects are scoped individually — most are delivered within 4–8 weeks. We provide a clear timeline at the start of every project.',
                'category'   => 'pricing',
                'sort_order' => 2,
                'is_active'  => true,
            ],
            [
                'question'   => 'Do you offer refunds?',
                'answer'     => 'We take a 50% deposit before work begins, which covers discovery and design. If you are not satisfied with the initial design direction, we offer one full revision round at no cost. Refunds on completed work are not offered, but we commit to delivering until you are happy.',
                'category'   => 'pricing',
                'sort_order' => 3,
                'is_active'  => true,
            ],
            [
                'question'   => 'Can I upgrade my plan later?',
                'answer'     => 'Yes. You can start with the Starter plan and upgrade to Business or Premium at any time. We will apply a credit for what you\'ve already paid, so you only pay the difference. Upgrades are handled smoothly without starting from scratch.',
                'category'   => 'pricing',
                'sort_order' => 4,
                'is_active'  => true,
            ],
            [
                'question'   => 'Do you provide hosting and domain registration?',
                'answer'     => 'Yes. We can handle domain registration, hosting setup, and deployment as part of the project. We partner with reliable providers for hosting and can also deploy on your preferred provider if you already have one. Ongoing hosting costs are separate and transparent.',
                'category'   => 'pricing',
                'sort_order' => 5,
                'is_active'  => true,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create(array_merge($faq, ['created_at' => now(), 'updated_at' => now()]));
        }
    }
}
