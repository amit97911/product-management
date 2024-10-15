<?php

namespace App\Providers;

use App\Models\ApiKey;
use App\Observers\TradelingApiKeyObserver;
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
        ApiKey::observe(TradelingApiKeyObserver::class);
    }
}
