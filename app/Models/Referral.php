<?php

namespace App\Models;

use App\Enums\ReferralStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Referral Model
 *
 * Tracks users who registered via another user's referral link.
 * A Referral record is created when a new user signs up with a valid
 * referral_code. The admin then manually reviews each referral,
 * sets the commission_amount, and advances the status:
 *   pending → approved → paid  (see ReferralStatus enum)
 *
 * commission_amount is stored in XAF (Cameroon Franc, decimal:2).
 * No automatic payout — the admin confirms payment offline.
 *
 * Relationships:
 *   referrer()     → the User who shared the referral link (user_id FK)
 *   referredUser() → the User who registered via the link (referred_user_id FK)
 */
class Referral extends Model
{
    protected $fillable = ['user_id', 'referred_user_id', 'commission_amount', 'status'];

    protected function casts(): array
    {
        return [
            'status'            => ReferralStatus::class,
            'commission_amount' => 'decimal:2',
        ];
    }

    public function referrer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function referredUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referred_user_id');
    }
}
