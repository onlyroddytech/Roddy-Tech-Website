<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Admin Payment Controller
 *
 * Manages manual payment records for client projects.
 * There is no payment gateway — the admin updates payment amount,
 * status, and notes by hand after confirming receipt via bank
 * transfer, mobile money, or any other offline method.
 *
 * Each project has exactly one payment record (hasOne). This
 * controller gives the admin a single list view of all payments
 * and a simple update form per payment.
 */
class PaymentController extends Controller
{
    /**
     * List all payments with their associated project and client.
     * Eager-loads project.client to avoid N+1 on the table rows.
     */
    public function index(): View
    {
        $payments = Payment::with('project.client')->latest()->paginate(20);

        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Update a payment record.
     * Amount is in XAF (Cameroon Franc) by convention.
     * Status must be one of: unpaid, partial, paid.
     * Note is an optional admin memo (e.g. "Received via Orange Money").
     */
    public function update(Request $request, Payment $payment): RedirectResponse
    {
        $data = $request->validate([
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:unpaid,partial,paid',
            'note'   => 'nullable|string|max:500',
        ]);

        $payment->update($data);

        return back()->with('success', 'Payment updated.');
    }
}
