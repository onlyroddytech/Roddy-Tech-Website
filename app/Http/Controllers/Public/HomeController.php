<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\CmsSection;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Product;
use Illuminate\View\View;

/**
 * Public Home Controller
 *
 * Renders the marketing homepage (/).
 *
 * All text content is loaded from the CMS (cms_sections where group = 'hero')
 * so the admin can update headlines and copy without touching Blade files.
 * Dynamic sections (services, products, testimonials) pull live DB data
 * with reasonable limits to keep the page fast.
 */
class HomeController extends Controller
{
    /**
     * Render the homepage.
     *
     * Loads:
     *   - Hero text from CmsSection group 'hero'
     *   - Up to 6 active services (ordered by sort_order)
     *   - Up to 4 active products (ordered by sort_order)
     *   - Up to 6 active testimonials (newest first)
     */
    public function index(): View
    {
        return view('public.home', [
            'cms'          => CmsSection::group('hero'),
            'services'     => Service::active()->take(6)->get(),
            'products'     => Product::active()->take(4)->get(),
            'testimonials' => Testimonial::active()->take(6)->get(),
        ]);
    }
}
