<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Admin Team Controller
 *
 * CRUD for team member profiles shown on the public /team page.
 * Members are ordered by sort_order; is_active controls public visibility.
 *
 * Note: The route model binding key is {team} (the resource name),
 * which resolves to a TeamMember instance via Laravel's implicit binding.
 */
class TeamController extends Controller
{
    /** List all team members ordered by sort_order. */
    public function index(): View
    {
        return view('admin.team.index', ['members' => TeamMember::orderBy('sort_order')->get()]);
    }

    /** Show the add team member form. */
    public function create(): View
    {
        return view('admin.team.create');
    }

    /** Validate and persist a new team member. */
    public function store(Request $request): RedirectResponse
    {
        TeamMember::create($request->validate([
            'name'       => 'required|string|max:100',
            'role'       => 'required|string|max:100',
            'bio'        => 'nullable|string',
            'twitter'    => 'nullable|string|max:100',
            'linkedin'   => 'nullable|string|max:100',
            'sort_order' => 'integer',
            'is_active'  => 'boolean',
        ]));

        return redirect()->route('admin.team.index')->with('success', 'Team member added.');
    }

    /** Show the edit form for a team member. */
    public function edit(TeamMember $team): View
    {
        return view('admin.team.edit', ['member' => $team]);
    }

    /** Validate and apply updates to a team member. */
    public function update(Request $request, TeamMember $team): RedirectResponse
    {
        $team->update($request->validate([
            'name'       => 'required|string|max:100',
            'role'       => 'required|string|max:100',
            'bio'        => 'nullable|string',
            'twitter'    => 'nullable|string|max:100',
            'linkedin'   => 'nullable|string|max:100',
            'sort_order' => 'integer',
            'is_active'  => 'boolean',
        ]));

        return redirect()->route('admin.team.index')->with('success', 'Member updated.');
    }

    /** Permanently delete a team member. */
    public function destroy(TeamMember $team): RedirectResponse
    {
        $team->delete();

        return redirect()->route('admin.team.index')->with('success', 'Member deleted.');
    }
}
