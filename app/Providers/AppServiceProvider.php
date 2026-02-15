<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Item;
use App\Observers\ItemObserver;
use Illuminate\Support\Facades\URL; // ← IMPORTANTE


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
        if(env('APP_ENV') === 'produccion'){
        URL::forceScheme('https');
        }

        Item::observe(ItemObserver::class);
    }
}
