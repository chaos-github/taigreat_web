<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

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
        if ($this->app->runningInConsole()) {
            return;
        }

        $https = request()->isSecure()
            || request()->header('X-Forwarded-Proto') === 'https';

        if (! $https) {
            return;
        }

        URL::forceScheme('https');

        if (is_file(public_path('build/manifest.json'))) {
            Vite::useHotFile(public_path('hot.disabled'));
        }
    }
}
