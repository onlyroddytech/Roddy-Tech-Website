<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Client;
use App\Http\Controllers\Public as Pub;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ============================================================
// PUBLIC WEBSITE ROUTES
// ============================================================

Route::get('/',          [Pub\HomeController::class, 'index'])->name('home');
Route::get('/about',     [Pub\AboutController::class, 'index'])->name('about');
Route::get('/team',      [Pub\TeamController::class, 'index'])->name('team');
Route::get('/services',  [Pub\ServicesController::class, 'index'])->name('services');
Route::get('/contact',   [Pub\ContactController::class, 'index'])->name('contact');
Route::post('/contact',  [Pub\ContactController::class, 'send'])->name('contact.send');

// Explore dropdown
Route::get('/blog',              [Pub\BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}',       [Pub\BlogController::class, 'show'])->name('blog.show');
Route::get('/products',          [Pub\ProductsController::class, 'index'])->name('products.index');
Route::get('/store',             [Pub\StoreController::class, 'index'])->name('store.index');
Route::get('/pricing',           [Pub\PricingController::class, 'index'])->name('pricing.index');

// Portfolio projects (public)
Route::get('/projects',          [Pub\ProjectsController::class, 'index'])->name('projects.index');
Route::get('/projects/{id}',     [Pub\ProjectsController::class, 'show'])->name('projects.show');

// Support dropdown
Route::get('/support/knowledge-base',              [Pub\SupportController::class, 'knowledgeBase'])->name('support.kb');
Route::get('/support/tutorials',                   [Pub\SupportController::class, 'tutorials'])->name('support.tutorials');
Route::get('/support/help-center',                 [Pub\SupportController::class, 'helpCenter'])->name('support.help');

// ============================================================
// AUTH (Breeze)
// ============================================================

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// ============================================================
// CLIENT DASHBOARD
// ============================================================

Route::middleware(['auth', 'role:client'])
    ->prefix('dashboard')
    ->name('client.')
    ->group(function () {
        Route::get('/',                                     [Client\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/projects',                             [Client\ProjectController::class, 'index'])->name('projects.index');
        Route::get('/projects/{project}',                  [Client\ProjectController::class, 'show'])->name('projects.show');
        Route::post('/projects/{project}/messages',        [Client\MessageController::class, 'store'])->name('projects.messages.store');
        Route::get('/payments',                            [Client\PaymentController::class, 'index'])->name('payments.index');
        Route::get('/referrals',                           [Client\ReferralController::class, 'index'])->name('referrals.index');
        Route::get('/notifications',                       [Client\NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/{id}/read',            [Client\NotificationController::class, 'markRead'])->name('notifications.read');
    });

// ============================================================
// ADMIN DASHBOARD
// ============================================================

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/',                                         [Admin\DashboardController::class, 'index'])->name('dashboard');

        // Contact Messages
        Route::get('/contact-messages',                         [Admin\ContactMessageController::class, 'index'])->name('contact-messages.index');
        Route::patch('/contact-messages/{contactMessage}/read', [Admin\ContactMessageController::class, 'markRead'])->name('contact-messages.read');
        Route::delete('/contact-messages/{contactMessage}',     [Admin\ContactMessageController::class, 'destroy'])->name('contact-messages.destroy');

        // Users
        Route::get('/users',                                    [Admin\UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}',                             [Admin\UserController::class, 'show'])->name('users.show');
        Route::patch('/users/{user}',                           [Admin\UserController::class, 'update'])->name('users.update');

        // Projects
        Route::get('/projects',                                 [Admin\ProjectController::class, 'index'])->name('projects.index');
        Route::get('/projects/create',                          [Admin\ProjectController::class, 'create'])->name('projects.create');
        Route::post('/projects',                                [Admin\ProjectController::class, 'store'])->name('projects.store');
        Route::get('/projects/{project}',                       [Admin\ProjectController::class, 'show'])->name('projects.show');
        Route::get('/projects/{project}/edit',                  [Admin\ProjectController::class, 'edit'])->name('projects.edit');
        Route::patch('/projects/{project}',                     [Admin\ProjectController::class, 'update'])->name('projects.update');
        Route::delete('/projects/{project}',                    [Admin\ProjectController::class, 'destroy'])->name('projects.destroy');
        Route::post('/projects/{project}/progress',             [Admin\ProjectController::class, 'updateProgress'])->name('projects.updateProgress');
        Route::post('/projects/{project}/messages',             [Admin\MessageController::class, 'store'])->name('projects.messages.store');

        // Payments (manual)
        Route::get('/payments',                                 [Admin\PaymentController::class, 'index'])->name('payments.index');
        Route::patch('/payments/{payment}',                     [Admin\PaymentController::class, 'update'])->name('payments.update');

        // Referrals
        Route::get('/referrals',                                [Admin\ReferralController::class, 'index'])->name('referrals.index');
        Route::patch('/referrals/{referral}',                   [Admin\ReferralController::class, 'update'])->name('referrals.update');

        // CMS
        Route::get('/cms',                                      [Admin\CmsController::class, 'index'])->name('cms.index');
        Route::post('/cms',                                     [Admin\CmsController::class, 'update'])->name('cms.update');

        // Services
        Route::resource('services', Admin\ServiceController::class)->except(['show']);

        // Blog
        Route::resource('blog', Admin\BlogController::class)->except(['show']);

        // Team
        Route::resource('team', Admin\TeamController::class)->except(['show']);

        // Products
        Route::resource('products', Admin\ProductController::class)->except(['show']);

        // Pricing
        Route::resource('pricing', Admin\PricingController::class)->except(['show']);

        // FAQs
        Route::resource('faqs', Admin\FaqController::class)->except(['show']);
    });
