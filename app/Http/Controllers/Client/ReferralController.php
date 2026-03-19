<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

/**
 * Client Referral Controller
 *
 * Shows the client their referral dashboard — their unique shareable link
 * and a list of every user they have referred with commission status.
 *
 * The referral link is derived from the client's referral_code stored
 * on the users table. New signups using the link trigger a Referral record.
 * Commission review and payout is handled by the admin.
 */
class ReferralController extends Controller
{
    /**
     * Display the client's referral programme overview.
     * Passes both the user (for the referral link) and their referrals list.
     */
    public function index(): View
    {
        $user      = auth()->user();
        $referrals = $user->referrals()->with('referredUser')->latest()->get();

        return view('client.referrals.index', compact('user', 'referrals'));
    }
}
