<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <--- necesario
use App\Models\Item;
use App\Observers\ItemObserver;

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
        // Observers
        Item::observe(ItemObserver::class);

        // 🔹 Forzar HTTPS en producción
        if (env('APP_URL') && str_starts_with(env('APP_URL'), 'https://')) {
            URL::forceScheme('https');
            URL::forceRootUrl(env('APP_URL'));
        }
    }
}
