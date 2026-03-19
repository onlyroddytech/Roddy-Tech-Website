<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Admin Service Controller
 *
 * CRUD for service offerings displayed on the public /services page
 * and the homepage services grid. Services are ordered by sort_order,
 * giving the admin full control over display sequence.
 *
 * is_active toggles visibility on the public site without deleting the record.
 */
class ServiceController extends Controller
{
    /** List all services ordered by sort_order. */
    public function index(): View
    {
        return view('admin.services.index', ['services' => Service::orderBy('sort_order')->get()]);
    }

    /** Show the service creation form. */
    public function create(): View
    {
        return view('admin.services.create');
    }

    /** Validate and persist a new service. */
    public function store(Request $request): RedirectResponse
    {
        Service::create($request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'icon'        => 'nullable|string|max:100',
            'sort_order'  => 'integer',
            'is_active'   => 'boolean',
        ]));

        return redirect()->route('admin.services.index')->with('success', 'Service added.');
    }

    /** Show the service edit form. */
    public function edit(Service $service): View
    {
        return view('admin.services.edit', compact('service'));
    }

    /** Validate and apply updates to an existing service. */
    public function update(Request $request, Service $service): RedirectResponse
    {
        $service->update($request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'icon'        => 'nullable|string|max:100',
            'sort_order'  => 'integer',
            'is_active'   => 'boolean',
        ]));

        return redirect()->route('admin.services.index')->with('success', 'Service updated.');
    }

    /** Permanently delete a service. */
    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Service deleted.');
    }
}
