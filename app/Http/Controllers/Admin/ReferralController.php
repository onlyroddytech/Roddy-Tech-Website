<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Referral;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Admin Referral Controller
 *
 * Manages the referral programme. Referral records are created
 * automatically when a new user registers with a valid referral code.
 * The admin manually reviews each referral, sets the commission amount,
 * and advances the status through:  pending → approved → paid
 *
 * Commission is tracked per-referral in XAF (Cameroon Franc).
 * No automatic payout — the admin confirms payment offline.
 */
class ReferralController extends Controller
{
    /**
     * List all referrals with referrer and referred user.
     * Eager-loads both user relationships to avoid N+1.
     */
    public function index(): View
    {
        $referrals = Referral::with(['referrer', 'referredUser'])->latest()->paginate(20);

        return view('admin.referrals.index', compact('referrals'));
    }

    /**
     * Update a referral's status and commission amount.
     * Redirects back so the admin can continue reviewing the list.
     */
    public function update(Request $request, Referral $referral): RedirectResponse
    {
        $data = $request->validate([
            'status'            => 'required|in:pending,approved,paid',
            'commission_amount' => 'required|numeric|min:0',
        ]);

        $referral->update($data);

        return back()->with('success', 'Referral updated.');
    }
}
