<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\View\View;

/**
 * Public Services Controller
 *
 * Renders the /services page with all active services ordered by sort_order.
 * The homepage features a subset of these (first 6) via HomeController.
 * Inactive services are hidden without needing to be deleted.
 */
class ServicesController extends Controller
{
    /** Render the services page with all active services. */
    public function index(): View
    {
        return view('public.services', [
            'services' => Service::active()->get(),
        ]);
    }
}
