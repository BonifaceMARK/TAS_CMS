<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\TasFileObserver;
use App\Models\TasFile;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    
    }
}
