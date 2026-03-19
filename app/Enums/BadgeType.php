<?php

namespace App\Enums;

/**
 * BadgeType Enum
 *
 * Achievement and recognition badges that can be assigned to users.
 * Displayed on user profiles to highlight their status or contributions.
 *
 *   VerifiedClient — Client with at least one completed project.
 *   Supporter      — Active community supporter.
 *   Referral       — Has successfully referred at least one client.
 *   TopReferrer    — Among the top referrers on the platform.
 *   VIP            — High-value client or strategic partner.
 *
 * icon()  → display icon character for UI use.
 * color() → Tailwind CSS color name for badge styling.
 *
 * Badges are currently assigned manually by the admin.
 * Future phase: auto-grant based on milestone triggers.
 */
enum BadgeType: string
{
    case VerifiedClient = 'verified_client';
    case Supporter      = 'supporter';
    case Referral       = 'referral';
    case TopReferrer    = 'top_referrer';
    case VIP            = 'vip';

    public function label(): string
    {
        return match($this) {
            self::VerifiedClient => 'Verified Client',
            self::Supporter      => 'Supporter',
            self::Referral       => 'Referral Partner',
            self::TopReferrer    => 'Top Referrer',
            self::VIP            => 'VIP',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::VerifiedClient => '✓',
            self::Supporter      => '★',
            self::Referral       => '🔗',
            self::TopReferrer    => '🏆',
            self::VIP            => '👑',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::VerifiedClient => 'blue',
            self::Supporter      => 'green',
            self::Referral       => 'purple',
            self::TopReferrer    => 'yellow',
            self::VIP            => 'orange',
        };
    }
}
