<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

/**
 * Public Store Controller
 *
 * Renders the /store page. Currently a placeholder — the full store
 * with cart, checkout, and digital product delivery is a future phase.
 * The route and controller are registered now so the nav link works.
 */
class StoreController extends Controller
{
    /** Render the store placeholder page. */
    public function index(): View
    {
        return view('public.store');
    }
}
