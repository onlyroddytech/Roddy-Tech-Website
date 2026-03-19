<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Client Message Controller
 *
 * Handles clients sending messages inside a project thread.
 * Only the client who owns the project may post to its thread.
 */
class MessageController extends Controller
{
    /**
     * Store a new message in a project thread.
     *
     * Security: abort_unless() prevents a client from posting
     * to a project they do not own, even if they know the URL.
     */
    public function store(Request $request, Project $project): RedirectResponse
    {
        abort_unless($project->user_id === auth()->id(), 403);

        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        Message::create([
            'project_id' => $project->id,
            'sender_id'  => auth()->id(),
            'message'    => $request->message,
        ]);

        return redirect()
            ->route('client.projects.show', $project)
            ->with('success', 'Message sent.');
    }
}
