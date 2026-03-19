<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

/**
 * Client Payment Controller
 *
 * Shows the logged-in client a read-only view of all payment records
 * across their projects. Clients cannot create or modify payments —
 * that is managed exclusively by the admin.
 *
 * Implementation: walks the client's projects, eager-loads each payment,
 * then plucks the payment object. ->filter() drops projects that have
 * no payment record yet (payment is created by admin, not automatically).
 */
class PaymentController extends Controller
{
    /**
     * Show all payment records for the client's projects.
     * Displayed newest-project-first, matching the project list order.
     */
    public function index(): View
    {
        $payments = auth()->user()
            ->projects()
            ->with('payment')
            ->latest()
            ->get()
            ->pluck('payment')
            ->filter();

        return view('client.payments.index', compact('payments'));
    }
}
