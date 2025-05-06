<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        parent::boot();

        if (file_exists(base_path('routes/channels.php'))) {
            require base_path('routes/channels.php');
        }
    
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/api.php'));
    
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/chat.php')); // ✅ Register your custom route file
    }}

