<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Admin CMS Controller
 *
 * Lets the admin edit all public website text content stored in the
 * cms_sections table — headlines, body copy, contact details, etc. —
 * without touching Blade files or deploying code.
 *
 * The edit form groups sections by their 'group' column (e.g. hero,
 * about, contact). Each input is named  cms[key]  so the POST array
 * maps directly to the cms_sections.key column.
 *
 * update() iterates the submitted cms[] array and issues a targeted
 * UPDATE per key. It never inserts new rows — all valid keys must
 * already exist (seeded via DatabaseSeeder or manually added).
 */
class CmsController extends Controller
{
    /**
     * Display the CMS editor.
     * Groups sections by their 'group' column so the view can render
     * each page's fields in a separate card.
     */
    public function index(): View
    {
        $sections = CmsSection::orderBy('group')->orderBy('key')->get()->groupBy('group');

        return view('admin.cms.index', compact('sections'));
    }

    /**
     * Save all CMS field changes submitted from the editor form.
     * Iterates the posted cms[] array and updates each key's value.
     * Unknown keys are silently ignored (WHERE key = X finds nothing).
     */
    public function update(Request $request): RedirectResponse
    {
        foreach ($request->input('cms', []) as $key => $value) {
            CmsSection::where('key', $key)->update(['value' => $value]);
        }

        return back()->with('success', 'Website content updated.');
    }
}
