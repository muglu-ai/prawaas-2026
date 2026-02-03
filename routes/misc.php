<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Miscellaneous Routes
|--------------------------------------------------------------------------
|
| This file contains miscellaneous routes that don't fit into specific
| categories like tickets, delegates, or exhibitors. This includes
| utility routes, testing routes, and other general-purpose endpoints.
|
*/

// Health Check Route
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
        'app' => config('app.name'),
        'version' => config('app.version', '1.0.0'),
    ]);
})->name('health.check');

// System Info Route (for debugging - should be protected in production)
Route::get('/ssystem-info', function () {
    if (!app()->isLocal()) {
        abort(404);
    }
    
    return response()->json([
        'php_version' => PHP_VERSION,
        'laravel_version' => app()->version(),
        'environment' => app()->environment(),
        'debug_mode' => config('app.debug'),
        'timezone' => config('app.timezone'),
        'locale' => config('app.locale'),
    ]);
})->name('system.info');

// Clear Cache Route (useful for debugging - protected)
Route::get('/clear-cache', function () {
    if (!app()->isLocal()) {
        abort(404);
    }
    
    \Artisan::call('cache:clear');
    \Artisan::call('config:clear');
    \Artisan::call('view:clear');
    \Artisan::call('route:clear');
    
    return response()->json([
        'status' => 'success',
        'message' => 'All caches cleared successfully',
    ]);
})->name('cache.clear');

// Test Email Route (for debugging email configuration)
Route::get('/test-email', function () {
    if (!app()->isLocal()) {
        abort(404);
    }
    
    try {
        \Mail::raw('This is a test email from ' . config('app.name'), function ($message) {
            $message->to(config('mail.from.address'))
                    ->subject('Test Email - ' . config('app.name'));
        });
        
        return response()->json([
            'status' => 'success',
            'message' => 'Test email sent successfully',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
        ], 500);
    }
})->name('test.email');

// Maintenance Mode Check
Route::get('/maintenance-status', function () {
    return response()->json([
        'maintenance_mode' => app()->isDownForMaintenance(),
        'timestamp' => now()->toISOString(),
    ]);
})->name('maintenance.status');

/*
|--------------------------------------------------------------------------
| Utility Routes
|--------------------------------------------------------------------------
*/

// Generate UUID
Route::get('/generate-uuid', function () {
    return response()->json([
        'uuid' => \Illuminate\Support\Str::uuid()->toString(),
    ]);
})->name('generate.uuid');

// Current Server Time
Route::get('/server-time', function () {
    return response()->json([
        'timestamp' => now()->toISOString(),
        'timezone' => config('app.timezone'),
        'formatted' => now()->format('Y-m-d H:i:s T'),
    ]);
})->name('server.time');



/*
|--------------------------------------------------------------------------
| Redirect Routes
|--------------------------------------------------------------------------
| Legacy URL redirects and short URLs
*/

// Example: Short URL for registration
// Route::redirect('/register', '/tickets/register', 301);

// Example: Legacy URL redirect
// Route::redirect('/old-path', '/new-path', 301);

/*
|--------------------------------------------------------------------------
| Static Page Routes
|--------------------------------------------------------------------------
*/

// Terms and Conditions
Route::view('/terms-and-conditions', 'pages.terms')->name('terms');

// Privacy Policy  
Route::view('/privacy-policy', 'pages.privacy')->name('privacy');

// About Us
Route::view('/about', 'pages.about')->name('about');

// Contact Us
Route::view('/contact', 'pages.contact')->name('contact');
