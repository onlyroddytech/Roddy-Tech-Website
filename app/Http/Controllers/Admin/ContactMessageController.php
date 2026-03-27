<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Admin Contact Message Controller
 *
 * Allows admins to view and manage all contact form submissions.
 * Messages are stored via the public ContactController::send() method.
 */
class ContactMessageController extends Controller
{
    /** List all contact messages, newest first. */
    public function index(): View
    {
        $messages = ContactMessage::latest()->paginate(20);

        return view('admin.contact-messages.index', compact('messages'));
    }

    /** Mark a message as read. */
    public function markRead(ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->update(['read' => true]);

        return back()->with('success', 'Message marked as read.');
    }

    /** Delete a message. */
    public function destroy(ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->delete();

        return back()->with('success', 'Message deleted.');
    }
}
