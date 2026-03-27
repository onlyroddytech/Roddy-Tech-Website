<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\CmsSection;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Public Contact Controller
 *
 * Renders the /contact page and handles the contact form submission.
 * Page content (address, phone, email copy) is loaded from the CMS
 * (cms_sections where group = 'contact') so the admin can update it
 * without touching Blade files.
 *
 * send() currently validates the form and redirects with a success flash.
 * TODO: Wire up email delivery (Mail::to()) or store the inquiry in a DB
 *       table so the admin can review and respond to enquiries.
 */
class ContactController extends Controller
{
    /** Render the contact page with CMS content for the 'contact' group. */
    public function index(): View
    {
        return view('public.contact', [
            'cms' => CmsSection::group('contact'),
        ]);
    }

    /**
     * Handle the contact form submission.
     * Validates name, email, and message; then redirects back with a
     * success flash. Email delivery is a TODO (see class doc above).
     */
    public function send(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:150',
            'subject' => 'nullable|string|max:200',
            'service' => 'nullable|string|max:100',
            'message' => 'required|string|min:10|max:2000',
        ]);

        ContactMessage::create($data);

        return back()->with('success', 'Message sent! We will get back to you within 24 hours.');
    }
}
