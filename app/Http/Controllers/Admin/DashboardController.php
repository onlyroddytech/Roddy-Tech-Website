<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use App\Models\Payment;
use App\Models\Referral;
use Illuminate\View\View;

/**
 * Admin Dashboard Controller
 *
 * Shows the central admin overview page — the first screen an admin
 * sees after logging in. Displays key platform metrics and a quick
 * view of the most recent projects.
 *
 * Only accessible to admin-role users (enforced by 'role:admin' middleware
 * on the entire admin route group in routes/web.php).
 */
class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * Queries live DB counts for six stat cards:
     *   - Total registered clients
     *   - All-time / ongoing / completed project counts
     *   - Payments still marked as unpaid
     *   - Referrals awaiting admin review
     *
     * Also eager-loads the 5 most-recently-created projects with
     * their client user for the "Recent Projects" table.
     */
    public function index(): View
    {
        $stats = [
            'clients'      => User::where('role', 'client')->count(),
            'projects'     => Project::count(),
            'ongoing'      => Project::where('status', 'ongoing')->count(),
            'completed'    => Project::where('status', 'completed')->count(),
            'unpaid'       => Payment::where('status', 'unpaid')->count(),
            'referrals'    => Referral::where('status', 'pending')->count(),
        ];

        $recentProjects = Project::with('client')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentProjects'));
    }
}
