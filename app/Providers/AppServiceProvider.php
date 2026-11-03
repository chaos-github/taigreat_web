<?php

namespace App\Providers;

use App\View\Compilers\SafeBladeCompiler;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\DynamicComponent;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // 用 SafeBladeCompiler 取代預設 Blade 編譯器。
        // Windows Docker 掛載磁碟時，Laravel 原版 compile() 的 tempnam() / touch() 會失敗。
        // SafeBladeCompiler 改為直接寫入編譯檔，避開這兩步。
        $this->app->singleton('blade.compiler', function ($app) {
            return tap(new SafeBladeCompiler(
                $app['files'],
                $app['config']['view.compiled'], // 編譯後的 PHP 存放目錄
                $app['config']->get('view.relative_hash', false) ? $app->basePath() : '', // hash 是否去掉專案根路徑
                $app['config']->get('view.cache', true), // 是否快取編譯結果
                $app['config']->get('view.compiled_extension', 'php'), // 編譯檔副檔名
                $app['config']->get('view.check_cache_timestamps', true), // 是否用檔案時間判斷要不要重編譯
            ), function ($blade) {
                // 與 Laravel 預設編譯器相同：註冊 <x-dynamic-component>
                $blade->component('dynamic-component', DynamicComponent::class);
            });
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('contact', fn (Request $request): array => [
            Limit::perMinute(5)->by('contact-minute:'.$request->ip()),
            Limit::perHour(20)->by('contact-hour:'.$request->ip()),
        ]);

        if (! config('app.debug')) {
            Vite::useHotFile(public_path('hot.disabled'));
        }

    }
}
