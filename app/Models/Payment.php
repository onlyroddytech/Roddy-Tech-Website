<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Payment Model
 *
 * Manual payment tracking — one record per project (hasOne from Project).
 * There is no payment gateway. The admin updates amount, status, and note
 * after confirming receipt via bank transfer, mobile money, or any other
 * offline channel.
 *
 * Amount is stored in XAF (Cameroon Franc) by convention (decimal:2).
 * Status follows the PaymentStatus enum: unpaid → partial → paid.
 * Note is a free-text admin memo (e.g. "Received via Orange Money on 15/03").
 */
class Payment extends Model
{
    protected $fillable = ['project_id', 'amount', 'status', 'note'];

    protected function casts(): array
    {
        return [
            'status' => PaymentStatus::class,
            'amount' => 'decimal:2',
        ];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function isPaid(): bool
    {
        return $this->status === PaymentStatus::Paid;
    }
}
