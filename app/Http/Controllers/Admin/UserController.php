<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Admin User Controller
 *
 * Manages platform user accounts. Admin can list all users,
 * inspect a user's full profile (projects, referrals), and
 * update a user's role or active status.
 *
 * Destructive operations (delete account, force password reset)
 * are intentionally absent — those require dedicated confirmation flows.
 */
class UserController extends Controller
{
    /** List all users, newest first, paginated. */
    public function index(): View
    {
        $users = User::latest()->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show a user's detail page.
     * Eager-loads their projects and referrals for display.
     */
    public function show(User $user): View
    {
        $user->load(['projects', 'referrals']);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Update a user's role and/or active status.
     * Redirects back to the same page so the admin stays in context.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'role'      => 'required|in:admin,client,supporter,referral',
            'is_active' => 'boolean',
        ]);

        $user->update($data);

        return back()->with('success', 'User updated.');
    }
}
