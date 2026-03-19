<?php

namespace App\Http\Controllers\Client;

use App\Enums\ProjectStatus;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

/**
 * Client Dashboard Controller
 *
 * Shows the client's personal overview page — the first screen
 * they see after logging in. Displays project stats and a list
 * of all their assigned projects with latest update and payment status.
 */
class DashboardController extends Controller
{
    /**
     * Show the client dashboard overview.
     *
     * Loads all projects for the logged-in client, eager-loads
     * payment and latestUpdate to avoid N+1 queries, then
     * computes summary stats for the stat cards.
     */
    public function index(): View
    {
        $user     = auth()->user();
        $projects = $user->projects()->with(['payment', 'latestUpdate'])->latest()->get();

        $stats = [
            'total'     => $projects->count(),
            'ongoing'   => $projects->filter(fn ($p) => $p->status === ProjectStatus::Ongoing)->count(),
            'completed' => $projects->filter(fn ($p) => $p->status === ProjectStatus::Completed)->count(),
            'unread'    => $user->unreadNotificationCount(),
        ];

        return view('client.dashboard', compact('user', 'projects', 'stats'));
    }
}
