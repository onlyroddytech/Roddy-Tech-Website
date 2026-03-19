<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Enums\ProjectStatus;
use Illuminate\View\View;

/**
 * Public Projects Controller
 *
 * Renders the public portfolio (/projects) — a paginated showcase of
 * completed and ongoing work visible to any site visitor.
 *
 * Client identity is intentionally omitted from the public show view
 * to protect client privacy. Only project details and progress are shown.
 *
 * Soft-deleted projects are automatically excluded by the SoftDeletes
 * trait; the whereNull('deleted_at') call is belt-and-suspenders
 * but is equivalent and safe.
 */
class ProjectsController extends Controller
{
    /**
     * Show the paginated portfolio listing.
     * Eager-loads updates so the progress timeline is available without N+1.
     */
    public function index(): View
    {
        $projects = Project::with('updates')
            ->whereNull('deleted_at')
            ->latest()
            ->paginate(12);

        return view('public.projects.index', compact('projects'));
    }

    /**
     * Show the public detail view of a single project.
     * Client relationship is loaded for potential display of company info,
     * but personal client details should not be exposed in the Blade view.
     */
    public function show(int $id): View
    {
        $project = Project::with(['updates', 'client'])->findOrFail($id);

        return view('public.projects.show', compact('project'));
    }
}
