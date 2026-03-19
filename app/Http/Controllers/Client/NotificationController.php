<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Client Notification Controller
 *
 * Manages in-app notifications for the logged-in client.
 * Uses the app's own 'notifications' table (not Laravel's built-in
 * notification system, which was intentionally avoided to keep full
 * control over the schema and delivery logic).
 *
 * markRead() scopes the UPDATE to WHERE user_id = auth()->id() to
 * ensure a client can never mark another client's notification as read
 * by guessing an integer ID.
 */
class NotificationController extends Controller
{
    /**
     * List all notifications for the client, paginated (20 per page).
     * Ordered newest first via appNotifications() → latest().
     */
    public function index(): View
    {
        $notifications = auth()->user()->appNotifications()->paginate(20);

        return view('client.notifications.index', compact('notifications'));
    }

    /**
     * Mark a single notification as read.
     * Scoped to the authenticated user's notifications only —
     * prevents cross-user ID guessing attacks.
     */
    public function markRead(int $id): RedirectResponse
    {
        Notification::where('id', $id)
            ->where('user_id', auth()->id())
            ->update(['is_read' => true, 'read_at' => now()]);

        return back();
    }
}
