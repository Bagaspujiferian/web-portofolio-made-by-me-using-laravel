<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Automatically use writable /tmp storage path when running on Vercel Serverless
        if (isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL']) || env('VERCEL')) {
            $storagePath = '/tmp/storage';
            if (! is_dir($storagePath.'/framework/views')) {
                @mkdir($storagePath.'/framework/views', 0755, true);
                @mkdir($storagePath.'/framework/cache/data', 0755, true);
                @mkdir($storagePath.'/framework/sessions', 0755, true);
                @mkdir($storagePath.'/logs', 0755, true);
            }
            $this->app->useStoragePath($storagePath);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('id');

        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
