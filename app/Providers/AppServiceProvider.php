<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Foundation\Vite as Vite;
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
        // Registrar Observers
        Item::observe(ItemObserver::class);

        // Forzar HTTPS si APP_URL es https
        if (env('APP_URL') && str_starts_with(env('APP_URL'), 'https://')) {
            URL::forceScheme('https');
            URL::forceRootUrl(env('APP_URL'));
        }

        // 🔹 Configurar Vite para encontrar el manifest en public/build/vite
        $buildPath = config('vite.build_path', 'build/vite');
        $manifestPath = public_path($buildPath . '/manifest.json');

        // Lanzar error solo si el manifest no existe
        if (!file_exists($manifestPath)) {
            throw new \Illuminate\Foundation\ViteManifestNotFoundException(
                "Vite manifest not found at: {$manifestPath}"
            );
        }

        // Decirle a Vite dónde está el manifest
        Vite::useManifestPath($manifestPath);
    }
}
