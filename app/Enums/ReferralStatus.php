<?php

namespace App\Enums;

/**
 * ReferralStatus Enum
 *
 * Tracks the lifecycle of a referral commission record.
 *
 *   Pending  — Referral registered; awaiting admin review.
 *   Approved — Admin confirmed the referral is valid and set a commission amount.
 *   Paid     — Commission has been paid out to the referrer offline.
 *
 * color() returns a Tailwind CSS color name for status badge styling.
 * Cast automatically on the Referral model.
 */
enum ReferralStatus: string
{
    case Pending  = 'pending';
    case Approved = 'approved';
    case Paid     = 'paid';

    public function label(): string
    {
        return match($this) {
            self::Pending  => 'Pending',
            self::Approved => 'Approved',
            self::Paid     => 'Paid Out',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Pending  => 'yellow',
            self::Approved => 'blue',
            self::Paid     => 'green',
        };
    }
}
