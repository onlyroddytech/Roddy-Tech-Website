<?php

namespace App\Enums;

/**
 * PaymentStatus Enum
 *
 * Represents the payment state of a project's manual payment record.
 * There is no payment gateway — the admin updates status after
 * confirming receipt via bank transfer, mobile money, etc.
 *
 *   Unpaid  — No payment received yet.
 *   Partial — A partial payment has been received.
 *   Paid    — Fully paid.
 *
 * color() returns a Tailwind CSS color name for status badge styling.
 * Cast automatically on the Payment model.
 */
enum PaymentStatus: string
{
    case Unpaid  = 'unpaid';
    case Partial = 'partial';
    case Paid    = 'paid';

    public function label(): string
    {
        return match($this) {
            self::Unpaid  => 'Unpaid',
            self::Partial => 'Partially Paid',
            self::Paid    => 'Paid',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Unpaid  => 'red',
            self::Partial => 'yellow',
            self::Paid    => 'green',
        };
    }
}
