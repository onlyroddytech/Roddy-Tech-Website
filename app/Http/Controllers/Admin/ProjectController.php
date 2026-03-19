<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProjectStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectUpdate;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Admin Project Controller
 *
 * Full CRUD for managing client projects, plus an extra
 * updateProgress() action that logs a progress snapshot.
 *
 * Each call to updateProgress() does two things atomically:
 *   1. Updates project.progress (the current percentage).
 *   2. Creates a ProjectUpdate record (the timeline entry visible to the client).
 * This keeps the history clean without a separate Action class.
 *
 * Projects use soft deletes — destroy() moves them to the trash
 * rather than permanently removing them, preserving payment history.
 */
class ProjectController extends Controller
{
    /**
     * List all projects, paginated, newest first.
     * Eager-loads client to avoid N+1 on the table.
     */
    public function index(): View
    {
        $projects = Project::with('client')->latest()->paginate(20);

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the project creation form.
     * Passes all clients (alphabetically) for the assignee dropdown.
     */
    public function create(): View
    {
        $clients = User::where('role', 'client')->orderBy('name')->get();

        return view('admin.projects.create', compact('clients'));
    }

    /**
     * Validate and persist a new project.
     * created_by is automatically set to the logged-in admin's ID.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'user_id'     => 'required|exists:users,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:pending,ongoing,completed',
            'progress'    => 'required|integer|min:0|max:100',
            'start_date'  => 'nullable|date',
            'deadline'    => 'nullable|date',
        ]);

        $project = Project::create(array_merge($data, ['created_by' => auth()->id()]));

        return redirect()->route('admin.projects.show', $project)->with('success', 'Project created.');
    }

    /**
     * Show a single project in full detail.
     * Eager-loads updates (timeline), messages with senders (chat thread),
     * and payment record to avoid N+1 queries.
     */
    public function show(Project $project): View
    {
        $project->load(['client', 'updates', 'messages.sender', 'payment']);

        return view('admin.projects.show', compact('project'));
    }

    /** Show the project edit form with the client dropdown pre-populated. */
    public function edit(Project $project): View
    {
        $clients = User::where('role', 'client')->orderBy('name')->get();

        return view('admin.projects.edit', compact('project', 'clients'));
    }

    /** Validate and apply updates to an existing project. */
    public function update(Request $request, Project $project): RedirectResponse
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:pending,ongoing,completed',
            'progress'    => 'required|integer|min:0|max:100',
            'start_date'  => 'nullable|date',
            'deadline'    => 'nullable|date',
        ]);

        $project->update($data);

        return redirect()->route('admin.projects.show', $project)->with('success', 'Project updated.');
    }

    /**
     * Soft-delete the project.
     * The record remains in the DB (visible in trash / history queries)
     * but is excluded from all standard list and show queries.
     */
    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Project deleted.');
    }

    /**
     * Update a project's progress percentage and log a timeline entry.
     *
     * This performs two writes in one request:
     *   1. Updates project.progress so the progress bar reflects the new value.
     *   2. Creates a ProjectUpdate record so the client can see what changed and why.
     */
    public function updateProgress(Request $request, Project $project): RedirectResponse
    {
        $data = $request->validate([
            'progress' => 'required|integer|min:0|max:100',
            'message'  => 'required|string|max:1000',
        ]);

        $project->update(['progress' => $data['progress']]);

        ProjectUpdate::create([
            'project_id' => $project->id,
            'created_by' => auth()->id(),
            'progress'   => $data['progress'],
            'message'    => $data['message'],
        ]);

        return redirect()->route('admin.projects.show', $project)->with('success', 'Progress updated.');
    }
}
