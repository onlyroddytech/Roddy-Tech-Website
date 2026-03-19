<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Admin Message Controller
 *
 * Handles the admin posting a reply in a project's message thread.
 * Unlike the Client MessageController, there is no ownership check —
 * admins have access to all project threads by definition.
 *
 * Messages are stored with sender_id = admin's user ID so the thread
 * view can visually distinguish admin replies from client messages.
 */
class MessageController extends Controller
{
    /**
     * Store a new admin message in a project thread.
     * Redirects back to the project detail page after posting.
     */
    public function store(Request $request, Project $project): RedirectResponse
    {
        $request->validate(['message' => 'required|string|max:2000']);

        Message::create([
            'project_id' => $project->id,
            'sender_id'  => auth()->id(),
            'message'    => $request->message,
        ]);

        return redirect()->route('admin.projects.show', $project)->with('success', 'Message sent.');
    }
}
