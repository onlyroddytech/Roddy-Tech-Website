<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\CmsSection;
use Illuminate\View\View;

/**
 * Public About Controller
 *
 * Renders the /about page. All text (mission, vision, story, etc.)
 * is loaded from the CMS (cms_sections where group = 'about') so
 * the admin can update it via the CMS panel without editing Blade files.
 */
class AboutController extends Controller
{
    /** Render the about page with CMS content for the 'about' group. */
    public function index(): View
    {
        return view('public.about', [
            'cms' => CmsSection::group('about'),
        ]);
    }
}
