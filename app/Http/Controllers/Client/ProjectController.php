<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\View\View;

/**
 * Client Project Controller
 *
 * Handles project views for the logged-in client.
 * Clients can only see their own projects — ownership is
 * enforced on every method using abort_unless().
 */
class ProjectController extends Controller
{
    /**
     * List all projects belonging to the logged-in client.
     *
     * Eager-loads payment to show payment status on the list view
     * without triggering an extra query per row.
     */
    public function index(): View
    {
        $projects = auth()->user()
            ->projects()
            ->with('payment')
            ->latest()
            ->get();

        return view('client.projects.index', compact('projects'));
    }

    /**
     * Show a single project — progress timeline, messages, and payment info.
     *
     * Security: abort_unless() returns 403 if the project does not
     * belong to the logged-in client. A client can never access
     * another client's project even by guessing the URL.
     */
    public function show(Project $project): View
    {
        abort_unless($project->user_id === auth()->id(), 403);

        $project->load(['updates', 'messages.sender', 'payment']);

        return view('client.projects.show', compact('project'));
    }
}
