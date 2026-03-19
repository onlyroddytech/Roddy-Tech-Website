<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\View\View;

/**
 * Public Team Controller
 *
 * Renders the /team page listing all active team members.
 * Members with is_active = false are hidden from the public page.
 * Display order is controlled by sort_order (admin-managed).
 */
class TeamController extends Controller
{
    /** Render the team page with all active members ordered by sort_order. */
    public function index(): View
    {
        return view('public.team', [
            'members' => TeamMember::active()->get(),
        ]);
    }
}
